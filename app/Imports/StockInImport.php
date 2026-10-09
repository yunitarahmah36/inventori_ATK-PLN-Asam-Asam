<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StockInImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    /**
     * Jumlah baris yang berhasil diproses.
     */
    public int $processedRowsCount = 0;

    /**
     * Jumlah material unik yang diperbarui.
     */
    public int $affectedMaterialsCount = 0;

    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Normalisasi nama material: hapus spasi berlebih dan lowercase UTF-8.
     */
    public static function normalizeName(?string $name): string
    {
        if ($name === null) {
            return '';
        }
        $cleaned = preg_replace('/\s+/u', ' ', trim($name));
        return mb_strtolower($cleaned, 'UTF-8');
    }

    /**
     * Normalisasi No. Material: trim dan lowercase.
     */
    public static function normalizeNumber(?string $number): string
    {
        if ($number === null) {
            return '';
        }
        return strtolower(trim($number));
    }

    /**
     * Parse tanggal dari format Excel (serial number atau text string).
     */
    private function parseDate($dateValue): ?string
    {
        if (empty($dateValue)) {
            return null;
        }

        if (is_numeric($dateValue)) {
            try {
                return Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
            } catch (\Exception $e) {}
        }

        try {
            return Carbon::parse($dateValue)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Proses koleksi data Excel:
     * 1. Validasi komprehensif seluruh baris: No. Material dan Nama Material sekaligus berdasarkan master data di database.
     * 2. Jika No. Material benar tetapi nama berbeda, atau nama benar tetapi No. Material berbeda, tolak data. Keduanya wajib cocok dengan satu data material yang sama.
     * 3. Jika ada kesalahan, tampilkan pesan error beserta nomor baris Excel dan jangan simpan atau ubah stok sebagian (atomic rollback).
     * 4. Jika semua baris valid, jalankan database transaction dan catat riwayat pergerakan stok.
     */
    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => 'File Excel tidak memiliki baris data untuk diimport.',
            ]);
        }

        $errors = [];
        $parsedRows = [];
        $now = Carbon::now();

        // Ambil seluruh master data material dari database untuk validasi cepat dan akurat
        $masterMaterials = Material::all();
        $masterByNumber  = [];
        $masterByName    = [];

        foreach ($masterMaterials as $mat) {
            $masterByNumber[self::normalizeNumber($mat->material_number)] = $mat;
            $masterByName[self::normalizeName($mat->name)] = $mat;
        }

        // ---------------------------------------------------------------
        // TAHAP 1: VALIDASI SEMUA BARIS (TIDAK ADA PERUBAHAN DATABASE)
        // ---------------------------------------------------------------
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Baris 1 adalah header di Excel

            // Ambil No Material dari berbagai kemungkinan nama kolom
            $noMaterial = trim((string) (
                $row['no_material'] 
                ?? $row['no'] 
                ?? $row['nomor_material'] 
                ?? $row['kode_material'] 
                ?? $row['no_mat'] 
                ?? ''
            ));

            // Ambil Nama Material dari berbagai kemungkinan nama kolom
            $namaMaterial = trim((string) (
                $row['nama_material']
                ?? $row['nama']
                ?? $row['nama_barang']
                ?? $row['material']
                ?? $row['nama_item']
                ?? ''
            ));

            // Ambil Jumlah Masuk dari berbagai kemungkinan nama kolom
            $qtyRaw = $row['jumlah_masuk'] 
                ?? $row['jumlah'] 
                ?? $row['jumlah_item'] 
                ?? $row['qty'] 
                ?? null;

            // Ambil Tanggal Masuk
            $dateRaw = $row['tanggal_masuk'] 
                ?? $row['tanggal'] 
                ?? $row['tgl'] 
                ?? null;

            // Ambil Keterangan
            $descRaw = trim((string) (
                $row['keterangan'] 
                ?? $row['deskripsi'] 
                ?? $row['sumber'] 
                ?? ''
            ));

            // Lewati jika seluruh baris benar-benar kosong
            if ($noMaterial === '' && $namaMaterial === '' && ($qtyRaw === null || trim((string) $qtyRaw) === '') && empty($descRaw)) {
                continue;
            }

            $rowHasFieldError = false;

            // 1. Validasi Keberadaan Kolom Wajib
            if ($noMaterial === '') {
                $errors[] = "Baris {$rowNumber}: Kolom No. Material wajib diisi.";
                $rowHasFieldError = true;
            }

            if ($namaMaterial === '') {
                $errors[] = "Baris {$rowNumber}: Kolom Nama Material wajib diisi.";
                $rowHasFieldError = true;
            }

            if ($qtyRaw === null || trim((string) $qtyRaw) === '') {
                $errors[] = "Baris {$rowNumber}: Kolom Jumlah Masuk wajib diisi.";
                $rowHasFieldError = true;
            } elseif (!is_numeric($qtyRaw) || (int) $qtyRaw != $qtyRaw || (int) $qtyRaw <= 0) {
                $errors[] = "Baris {$rowNumber}: Jumlah Masuk harus berupa bilangan bulat positif lebih dari 0 (ditemukan: '{$qtyRaw}').";
                $rowHasFieldError = true;
            }

            if ($rowHasFieldError) {
                continue;
            }

            $qtyInt = (int) $qtyRaw;
            $parsedDate = $this->parseDate($dateRaw) ?: $now->format('Y-m-d');

            // 2. Validasi No. Material dan Nama Material Sekaligus Berdasarkan Data Master
            $normNo   = self::normalizeNumber($noMaterial);
            $normName = self::normalizeName($namaMaterial);

            $matByNumber = $masterByNumber[$normNo] ?? null;
            $matByName   = $masterByName[$normName] ?? null;

            // Skenario A: Keduanya cocok dengan satu data material yang sama
            if ($matByNumber && $matByName && $matByNumber->id === $matByName->id) {
                $matchedMaterial = $matByNumber;

                $parsedRows[] = [
                    'row_number'      => $rowNumber,
                    'material_id'     => $matchedMaterial->id,
                    'material_number' => $matchedMaterial->material_number,
                    'material_name'   => $matchedMaterial->name,
                    'quantity'        => $qtyInt,
                    'entry_date'      => $parsedDate,
                    'description'     => $descRaw ?: 'Import Stok Masuk Excel',
                ];
                continue;
            }

            // Skenario B: No. Material terdaftar, tetapi Nama Material berbeda / tidak cocok
            if ($matByNumber) {
                if ($matByName && $matByNumber->id !== $matByName->id) {
                    $errors[] = "Baris {$rowNumber}: No. Material '{$noMaterial}' adalah untuk '{$matByNumber->name}', sedangkan Nama Material '{$namaMaterial}' terdaftar dengan No. Material '{$matByName->material_number}'. No. Material dan Nama Material tidak cocok dengan satu data material yang sama.";
                } else {
                    $errors[] = "Baris {$rowNumber}: No. Material '{$noMaterial}' terdaftar untuk material '{$matByNumber->name}', tetapi pada file Excel tertulis '{$namaMaterial}'. Keduanya wajib cocok dengan satu data material yang sama.";
                }
                continue;
            }

            // Skenario C: Nama Material terdaftar, tetapi No. Material berbeda / tidak cocok
            if ($matByName) {
                $errors[] = "Baris {$rowNumber}: Nama Material '{$namaMaterial}' terdaftar dengan No. Material '{$matByName->material_number}', tetapi pada file Excel tertulis '{$noMaterial}'. Keduanya wajib cocok dengan satu data material yang sama.";
                continue;
            }

            // Skenario D: Keduanya tidak ditemukan sama sekali di master data
            $errors[] = "Baris {$rowNumber}: Data material dengan No. Material '{$noMaterial}' dan Nama Material '{$namaMaterial}' belum terdaftar di Data Material. Pastikan material sudah ditambahkan terlebih dahulu pada master Data Material.";
        }

        // Jika ditemukan satu atau lebih kesalahan, tolak seluruh proses sebelum menyimpan (TIDAK ADA PERUBAHAN STOK)
        if (!empty($errors)) {
            throw ValidationException::withMessages([
                'import_errors' => $errors,
            ]);
        }

        if (empty($parsedRows)) {
            throw ValidationException::withMessages([
                'file' => 'Tidak ada baris data valid yang ditemukan untuk diproses.',
            ]);
        }

        // ---------------------------------------------------------------
        // TAHAP 2: EKSEKUSI PENAMBAHAN STOK & PENCATATAN RIWAYAT SECARA TRANSAKSIONAL
        // ---------------------------------------------------------------
        DB::transaction(function () use ($parsedRows, $now) {
            $affectedMaterialIds = [];

            foreach ($parsedRows as $item) {
                // Kunci baris material untuk mencegah race condition
                $lockedMaterial = Material::lockForUpdate()->findOrFail($item['material_id']);

                $qtyBefore = (int) $lockedMaterial->quantity;
                $qtyIn     = (int) $item['quantity'];
                $qtyAfter  = $qtyBefore + $qtyIn;

                // Update kuantitas stok material
                $lockedMaterial->update([
                    'quantity' => $qtyAfter,
                ]);

                // Tanggal dan waktu pergerakan stok masuk
                $entryDateTime = Carbon::parse($item['entry_date'])->setTime(
                    $now->hour,
                    $now->minute,
                    $now->second
                );

                // Catat ke Riwayat Pergerakan Material
                StockMovement::create([
                    'material_id'     => $lockedMaterial->id,
                    'material_name'   => $lockedMaterial->name,
                    'material_number' => $lockedMaterial->material_number,
                    'user_id'         => Auth::id() ?? 1,
                    'activity'        => 'Tambah',
                    'quantity_before' => $qtyBefore,
                    'quantity_after'  => $qtyAfter,
                    'quantity_change' => $qtyIn,
                    'description'     => $item['description'],
                    'created_at'      => $entryDateTime,
                ]);

                $affectedMaterialIds[$lockedMaterial->id] = true;
                $this->processedRowsCount++;
            }

            $this->affectedMaterialsCount = count($affectedMaterialIds);
        });
    }
}
