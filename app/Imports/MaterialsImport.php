<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MaterialsImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows
{
    /**
     * Header berada di baris pertama.
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Normalisasi nama material dengan mengabaikan huruf besar/kecil dan spasi berlebih.
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
     * Validasi data dasar per kolom.
     */
    public function rules(): array
    {
        return [
            'no_material' => [
                'required',
                'string',
                'max:50',
            ],

            'nama_material' => [
                'required',
                'string',
                'max:255',
            ],

            'tanggal_masuk' => [
                'required',
            ],

            'jumlah_item' => [
                'required',
                'integer',
                'min:0',
            ],

            'satuan' => [
                'required',
                'string',
                'max:50',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Pengecekan aturan bisnis No Material & Normalisasi Nama:
     * 1. Material yang sama (setelah normalisasi nama & No Material sama) dapat menggunakan No Material yang sama.
     * 2. Jika No Material dan nama material sama setelah normalisasi, jangan ditolak sebagai duplikat (cegah data ganda saat simpan).
     * 3. Jika No Material sama tetapi nama material berbeda setelah normalisasi, tampilkan validasi error.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();
            if (empty($data) || !is_array($data)) {
                return;
            }

            // Kumpulkan seluruh No Material dari data file Excel
            $fileNumbers = [];
            foreach ($data as $row) {
                if (!isset($row['no_material']) || trim((string) $row['no_material']) === '') {
                    continue;
                }
                $fileNumbers[] = trim((string) $row['no_material']);
            }

            // Ambil seluruh material yang sudah terdaftar di database berdasarkan No Material
            $existingMaterials = [];
            if (!empty($fileNumbers)) {
                $dbMaterials = Material::whereIn('material_number', array_unique($fileNumbers))->get();
                foreach ($dbMaterials as $mat) {
                    $existingMaterials[strtolower(trim($mat->material_number))] = $mat;
                }
            }

            $seenInFile = [];

            foreach ($data as $rowNum => $row) {
                if (!isset($row['no_material']) || trim((string) $row['no_material']) === '') {
                    continue;
                }

                $noMaterialRaw  = trim((string) $row['no_material']);
                $noMaterialKey  = strtolower($noMaterialRaw);
                $nameRaw        = isset($row['nama_material']) ? trim((string) $row['nama_material']) : '';
                $normalizedName = self::normalizeName($nameRaw);

                // 1. Cek terhadap baris sebelumnya di dalam file Excel itu sendiri
                if (isset($seenInFile[$noMaterialKey])) {
                    $prev = $seenInFile[$noMaterialKey];
                    $normalizedPrevName = self::normalizeName($prev['name']);

                    // Jika No Material sama tetapi nama material BERBEDA setelah normalisasi:
                    if ($normalizedName !== $normalizedPrevName) {
                        $validator->errors()->add(
                            "{$rowNum}.no_material",
                            "No Material '{$noMaterialRaw}' sama dengan Baris {$prev['row']} tetapi memiliki nama material berbeda ('{$nameRaw}' vs '{$prev['name']}'). No Material yang sama tidak boleh digunakan untuk nama material yang berbeda."
                        );
                    }
                    // Jika No Material sama DAN nama material SAMA setelah normalisasi:
                    // Jangan ditolak sebagai duplikat; biarkan lolos, nanti saat simpan stoknya digabungkan untuk mencegah data ganda.
                } else {
                    $seenInFile[$noMaterialKey] = [
                        'row'    => $rowNum,
                        'name'   => $nameRaw,
                        'raw_no' => $noMaterialRaw,
                    ];
                }

                // 2. Cek terhadap database
                if (isset($existingMaterials[$noMaterialKey])) {
                    $existing = $existingMaterials[$noMaterialKey];
                    $normalizedDbName = self::normalizeName($existing->name);

                    // Jika No Material sama tetapi nama material BERBEDA setelah normalisasi:
                    if ($normalizedName !== $normalizedDbName) {
                        $validator->errors()->add(
                            "{$rowNum}.no_material",
                            "No Material '{$noMaterialRaw}' sudah terdaftar di sistem untuk material '{$existing->name}', tetapi pada file Excel tertulis '{$nameRaw}'. No Material yang sama tidak boleh digunakan untuk nama material yang berbeda."
                        );
                    }
                    // Jika No Material sama DAN nama material SAMA setelah normalisasi:
                    // Jangan ditolak sebagai duplikat; biarkan lolos, nanti saat simpan stoknya ditambahkan ke material yang ada.
                }

                // 3. Validasi format tanggal masuk
                if (!empty($row['tanggal_masuk']) && $this->convertDate($row['tanggal_masuk']) === null) {
                    $validator->errors()->add(
                        "{$rowNum}.tanggal_masuk",
                        "Format tanggal tidak dikenali. Gunakan format DD/MM/YYYY (contoh: 01/07/2026)."
                    );
                }
            }
        });
    }

    /**
     * Simpan seluruh data material dan catat riwayat stok secara transaksional.
     * Mencegah pembuatan data ganda: jika No Material sudah ada, perbarui stoknya.
     */
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception('Import gagal. File Excel yang diunggah tidak memiliki data. Pastikan file berisi minimal satu baris data.');
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Lewati jika baris kosong
                if (empty($row['no_material']) && empty($row['nama_material'])) {
                    continue;
                }

                $matNumber    = trim((string) $row['no_material']);
                $matNumberKey = strtolower($matNumber);
                $quantity     = (int) $row['jumlah_item'];
                $name         = trim((string) $row['nama_material']);
                $entryDate    = $this->convertDate($row['tanggal_masuk']);
                $unit         = $this->normalizeUnit($row['satuan']);
                $desc         = !empty($row['deskripsi']) ? trim((string) $row['deskripsi']) : null;

                // Cari apakah No Material sudah ada di database (atau sudah dibuat oleh baris sebelumnya)
                $material = Material::whereRaw('LOWER(TRIM(material_number)) = ?', [$matNumberKey])->first();

                if ($material) {
                    // Cegah pembuatan data ganda: tambahkan stok ke material yang sudah ada
                    $qtyBefore = (int) $material->quantity;
                    $qtyAfter  = $qtyBefore + $quantity;

                    $material->update([
                        'quantity'   => $qtyAfter,
                        'entry_date' => $entryDate && $entryDate > $material->entry_date ? $entryDate : $material->entry_date,
                    ]);

                    StockMovement::create([
                        'material_id'     => $material->id,
                        'material_name'   => $material->name,
                        'material_number' => $material->material_number,
                        'user_id'         => Auth::id(),
                        'activity'        => 'Import',
                        'quantity_before' => $qtyBefore,
                        'quantity_after'  => $qtyAfter,
                        'quantity_change' => $quantity,
                        'description'     => $desc ?: 'Import data via Excel (penambahan stok material)',
                    ]);
                } else {
                    // Buat data material baru
                    $material = Material::create([
                        'material_number' => $matNumber,
                        'name'            => $name,
                        'entry_date'      => $entryDate,
                        'quantity'        => $quantity,
                        'unit'            => $unit,
                        'description'     => $desc,
                        'created_by'      => Auth::id(),
                    ]);

                    StockMovement::create([
                        'material_id'     => $material->id,
                        'material_name'   => $material->name,
                        'material_number' => $material->material_number,
                        'user_id'         => Auth::id(),
                        'activity'        => 'Import',
                        'quantity_before' => 0,
                        'quantity_after'  => $quantity,
                        'quantity_change' => $quantity,
                        'description'     => $desc ?: 'Import data via Excel',
                    ]);
                }
            }
        });
    }

    /**
     * Pesan validasi yang ramah pengguna.
     */
    public function customValidationMessages(): array
    {
        return [
            'no_material.required'    => 'Kolom No Material tidak boleh kosong.',
            'no_material.max'         => 'No Material terlalu panjang (maksimal 50 karakter).',
            'nama_material.required'  => 'Kolom Nama Material tidak boleh kosong.',
            'nama_material.max'       => 'Nama Material terlalu panjang (maksimal 255 karakter).',
            'tanggal_masuk.required'  => 'Kolom Tanggal Masuk tidak boleh kosong.',
            'jumlah_item.required'    => 'Kolom Jumlah Item tidak boleh kosong.',
            'jumlah_item.integer'     => 'Jumlah Item harus berupa angka bulat (contoh: 10, 25, 100).',
            'jumlah_item.min'         => 'Jumlah Item tidak boleh bernilai negatif.',
            'satuan.required'         => 'Kolom Satuan tidak boleh kosong.',
            'satuan.max'              => 'Satuan terlalu panjang (maksimal 50 karakter).',
        ];
    }

    /**
     * Label kolom yang ditampilkan di pesan error.
     */
    public function customValidationAttributes(): array
    {
        return [
            'no_material'   => 'No Material',
            'nama_material' => 'Nama Material',
            'tanggal_masuk' => 'Tanggal Masuk',
            'jumlah_item'   => 'Jumlah Item',
            'satuan'        => 'Satuan',
            'deskripsi'     => 'Deskripsi',
        ];
    }

    /**
     * Normalisasi satuan.
     */
    private function normalizeUnit($unit)
    {
        $unit = strtolower(trim((string) $unit));

        $units = [
            'pcs'    => 'Pcs',
            'pc'     => 'Pcs',
            'rim'    => 'Rim',
            'buah'   => 'Buah',
            'box'    => 'Box',
            'pack'   => 'Pack',
            'lusin'  => 'Lusin',
            'rol'    => 'Rol',
            'roll'   => 'Rol',
            'lembar' => 'Lembar',
            'botol'  => 'Botol',
            'karton' => 'Karton',
            'dus'    => 'Dus',
            'set'    => 'Set',
            'unit'   => 'Unit',
        ];

        if (isset($units[$unit])) {
            return $units[$unit];
        }

        return ucwords($unit);
    }

    /**
     * Konversi tanggal Excel menjadi format database (Y-m-d).
     */
    private function convertDate($date)
    {
        if (empty($date)) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Jika Excel mengirim tanggal sebagai serial number
        |--------------------------------------------------------------------------
        */
        if (is_numeric($date)) {
            try {
                return Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        $date = trim((string) $date);

        // Format DD/MM/YYYY
        $dateObject = \DateTime::createFromFormat('d/m/Y', $date);
        if ($dateObject && $dateObject->format('d/m/Y') === $date) {
            return $dateObject->format('Y-m-d');
        }

        // Format MM/DD/YYYY
        $dateObject = \DateTime::createFromFormat('m/d/Y', $date);
        if ($dateObject && $dateObject->format('m/d/Y') === $date) {
            return $dateObject->format('Y-m-d');
        }

        // Format DD-MM-YYYY
        $dateObject = \DateTime::createFromFormat('d-m-Y', $date);
        if ($dateObject && $dateObject->format('d-m-Y') === $date) {
            return $dateObject->format('Y-m-d');
        }

        // Format YYYY-MM-DD
        $dateObject = \DateTime::createFromFormat('Y-m-d', $date);
        if ($dateObject && $dateObject->format('Y-m-d') === $date) {
            return $dateObject->format('Y-m-d');
        }

        // Fallback strtotime
        $ts = strtotime($date);
        if ($ts !== false) {
            return date('Y-m-d', $ts);
        }

        return null;
    }
}