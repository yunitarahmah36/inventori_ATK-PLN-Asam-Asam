<?php

namespace App\Imports;

use App\Models\Material;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StockOutImport
{
    /**
     * Normalisasi nomor material: trim dan lowercase.
     */
    public static function normalizeNumber(?string $number): string
    {
        if ($number === null) {
            return '';
        }
        return strtolower(trim($number));
    }

    /**
     * Konversi tanggal dari Excel (serial number atau format teks) ke format Y-m-d database.
     */
    public static function convertDate($date): ?string
    {
        if ($date === null || $date === '') {
            return null;
        }

        // Serial number tanggal dari Excel
        if (is_numeric($date)) {
            try {
                return Date::excelToDateTimeObject((float) $date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        $dateStr = trim((string) $date);

        // Format DD/MM/YYYY
        $d = \DateTime::createFromFormat('d/m/Y', $dateStr);
        if ($d && $d->format('d/m/Y') === $dateStr) {
            return $d->format('Y-m-d');
        }

        // Format YYYY-MM-DD
        $d = \DateTime::createFromFormat('Y-m-d', $dateStr);
        if ($d && $d->format('Y-m-d') === $dateStr) {
            return $d->format('Y-m-d');
        }

        // Format DD-MM-YYYY
        $d = \DateTime::createFromFormat('d-m-Y', $dateStr);
        if ($d && $d->format('d-m-Y') === $dateStr) {
            return $d->format('Y-m-d');
        }

        // Format MM/DD/YYYY
        $d = \DateTime::createFromFormat('m/d/Y', $dateStr);
        if ($d && $d->format('m/d/Y') === $dateStr) {
            return $d->format('Y-m-d');
        }

        // Fallback strtotime
        $ts = strtotime($dateStr);
        if ($ts !== false) {
            return date('Y-m-d', $ts);
        }

        return null;
    }

    /**
     * Parse file Excel untuk analisis pratinjau Stok Keluar:
     * - Membaca baris data
     * - Memvalidasi kelengkapan kolom wajib (Tanggal, No. Material, Nama Pengambil, Bagian/Divisi, Jumlah Keluar)
     * - Mencocokkan No. Material dengan database (tidak membuat material baru)
     * - Memvalidasi jumlah harus bilangan bulat positif
     * - Memvalidasi ketersediaan stok material (termasuk akumulasi jika material sama muncul di beberapa baris)
     * - Memisahkan baris valid dan baris bermasalah beserta alasannya
     */
    public static function parseFile($file): array
    {
        $filePath = is_string($file) ? $file : $file->getRealPath();

        if (!file_exists($filePath)) {
            throw new \Exception('File Excel tidak ditemukan pada server.');
        }

        $spreadsheet = IOFactory::load($filePath);
        $worksheet   = $spreadsheet->getActiveSheet();
        $rows        = $worksheet->toArray(null, true, true, true);

        if (empty($rows)) {
            throw new \Exception('File Excel kosong atau tidak memiliki baris data.');
        }

        // Cari baris header secara fleksibel
        $headerRowIndex = null;
        $colMap = [
            'date'        => null,
            'number'      => null,
            'recipient'   => null,
            'division'    => null,
            'quantity'    => null,
            'description' => null,
        ];

        foreach ($rows as $rIndex => $row) {
            $rowValues = array_map(function ($val) {
                return strtolower(trim((string) $val));
            }, $row);

            $tempMap = [
                'date'        => null,
                'number'      => null,
                'recipient'   => null,
                'division'    => null,
                'quantity'    => null,
                'description' => null,
            ];

            foreach ($rowValues as $colLetter => $cellVal) {
                if (empty($cellVal)) {
                    continue;
                }

                // Tanggal
                if ($tempMap['date'] === null && (str_contains($cellVal, 'tanggal') || str_contains($cellVal, 'tgl') || str_contains($cellVal, 'date'))) {
                    $tempMap['date'] = $colLetter;
                    continue;
                }

                // No. Material
                if ($tempMap['number'] === null && (
                    ((str_contains($cellVal, 'no') || str_contains($cellVal, 'nomor') || str_contains($cellVal, 'kode')) && str_contains($cellVal, 'mat'))
                    || str_contains($cellVal, 'material_number')
                    || $cellVal === 'no material'
                    || $cellVal === 'nomor material'
                )) {
                    $tempMap['number'] = $colLetter;
                    continue;
                }

                // Nama Pengambil / Penerima
                if ($tempMap['recipient'] === null && (str_contains($cellVal, 'pengambil') || str_contains($cellVal, 'penerima') || str_contains($cellVal, 'recipient'))) {
                    $tempMap['recipient'] = $colLetter;
                    continue;
                }

                // Bagian / Divisi
                if ($tempMap['division'] === null && (
                    str_contains($cellVal, 'bagian')
                    || str_contains($cellVal, 'divisi')
                    || str_contains($cellVal, 'unit')
                    || str_contains($cellVal, 'dept')
                    || str_contains($cellVal, 'departemen')
                )) {
                    $tempMap['division'] = $colLetter;
                    continue;
                }

                // Jumlah Keluar
                if ($tempMap['quantity'] === null && (str_contains($cellVal, 'jumlah') || str_contains($cellVal, 'qty') || str_contains($cellVal, 'kuantitas') || str_contains($cellVal, 'keluar'))) {
                    $tempMap['quantity'] = $colLetter;
                    continue;
                }

                // Keterangan (opsional)
                if ($tempMap['description'] === null && (str_contains($cellVal, 'keterangan') || str_contains($cellVal, 'catatan') || str_contains($cellVal, 'deskripsi') || str_contains($cellVal, 'note'))) {
                    $tempMap['description'] = $colLetter;
                    continue;
                }
            }

            // Jika minimal terdeteksi kolom date, number, dan quantity
            if ($tempMap['number'] !== null && $tempMap['quantity'] !== null) {
                $headerRowIndex = $rIndex;
                $colMap = $tempMap;
                break;
            }
        }

        // Fallback ke baris 1 kolom A-F jika header teks tidak terdeteksi
        if ($headerRowIndex === null) {
            $headerRowIndex = 1;
            $colMap = [
                'date'        => 'A',
                'number'      => 'B',
                'recipient'   => 'C',
                'division'    => 'D',
                'quantity'    => 'E',
                'description' => 'F',
            ];
        }

        // Ambil data seluruh material dari database untuk pencocokan cepat
        $allMaterials = Material::all();
        $materialsByNumber = [];
        foreach ($allMaterials as $mat) {
            $materialsByNumber[self::normalizeNumber($mat->material_number)] = $mat;
        }

        $validRows   = [];
        $invalidRows = [];

        // Lacak akumulasi kuantitas yang diminta per material untuk validasi batas stok
        $cumulativeRequested = [];

        foreach ($rows as $rIndex => $row) {
            if ($rIndex <= $headerRowIndex) {
                continue; // Lewati baris header
            }

            $dateRaw      = isset($colMap['date']) && isset($row[$colMap['date']]) ? trim((string) $row[$colMap['date']]) : '';
            $numberRaw    = isset($colMap['number']) && isset($row[$colMap['number']]) ? trim((string) $row[$colMap['number']]) : '';
            $recipientRaw = isset($colMap['recipient']) && isset($row[$colMap['recipient']]) ? trim((string) $row[$colMap['recipient']]) : '';
            $divisionRaw  = isset($colMap['division']) && isset($row[$colMap['division']]) ? trim((string) $row[$colMap['division']]) : '';
            $quantityRaw  = isset($colMap['quantity']) && isset($row[$colMap['quantity']]) ? trim((string) $row[$colMap['quantity']]) : '';
            $descRaw      = isset($colMap['description']) && isset($row[$colMap['description']]) ? trim((string) $row[$colMap['description']]) : '';

            // Jika seluruh cell baris kosong, abaikan
            if ($dateRaw === '' && $numberRaw === '' && $recipientRaw === '' && $divisionRaw === '' && $quantityRaw === '' && $descRaw === '') {
                continue;
            }

            $rowPayload = [
                'row'             => $rIndex,
                'date_raw'        => $dateRaw ?: '-',
                'material_number' => $numberRaw ?: '-',
                'material_name'   => '-',
                'recipient'       => $recipientRaw ?: '-',
                'division'        => $divisionRaw ?: '-',
                'quantity'        => $quantityRaw ?: '-',
                'description'     => $descRaw ?: '-',
            ];

            // 1. Validasi kolom wajib
            $missingCols = [];
            if ($dateRaw === '')      $missingCols[] = 'Tanggal';
            if ($numberRaw === '')    $missingCols[] = 'No. Material';
            if ($recipientRaw === '') $missingCols[] = 'Nama Pengambil';
            if ($divisionRaw === '')  $missingCols[] = 'Bagian/Divisi';
            if ($quantityRaw === '')  $missingCols[] = 'Jumlah Keluar';

            if (!empty($missingCols)) {
                $rowPayload['reason'] = 'Kolom wajib tidak lengkap: ' . implode(', ', $missingCols) . ' harus diisi.';
                $invalidRows[] = $rowPayload;
                continue;
            }

            // 2. Validasi Tanggal
            $convertedDate = self::convertDate($dateRaw);
            if (!$convertedDate) {
                $rowPayload['reason'] = "Format tanggal '{$dateRaw}' tidak valid. Gunakan format DD/MM/YYYY (contoh: 13/10/2026).";
                $invalidRows[] = $rowPayload;
                continue;
            }

            // 3. Validasi Pencocokan No. Material di Database
            $normNum = self::normalizeNumber($numberRaw);
            if (!isset($materialsByNumber[$normNum])) {
                $rowPayload['reason'] = "No. Material '{$numberRaw}' tidak ditemukan di database. Sistem tidak membuat material baru untuk stok keluar.";
                $invalidRows[] = $rowPayload;
                continue;
            }

            $material = $materialsByNumber[$normNum];
            $rowPayload['material_name']   = $material->name;
            $rowPayload['material_number'] = $material->material_number;

            // 4. Validasi Jumlah Keluar harus bilangan bulat positif
            // Bersihkan format ribuan jika ada titik/koma
            $cleanQty = str_replace([' ', '.'], '', $quantityRaw);
            if (!is_numeric($cleanQty) || (int) $cleanQty <= 0 || (int) $cleanQty != (float) $cleanQty) {
                $rowPayload['reason'] = "Jumlah keluar '{$quantityRaw}' tidak valid. Jumlah harus berupa angka bulat positif lebih dari 0.";
                $invalidRows[] = $rowPayload;
                continue;
            }

            $qtyOut = (int) $cleanQty;
            $rowPayload['quantity'] = $qtyOut;

            // 5. Validasi Ketersediaan Stok Material (termasuk akumulasi dalam file)
            $currentAvailable = (int) $material->quantity;
            $alreadyRequested = $cumulativeRequested[$normNum] ?? 0;
            $totalCumulative  = $alreadyRequested + $qtyOut;

            if ($totalCumulative > $currentAvailable) {
                if ($alreadyRequested > 0) {
                    $rowPayload['reason'] = "Stok tidak mencukupi. Stok tersedia: {$currentAvailable} {$material->unit}. Total kebutuhan pada file ({$totalCumulative} {$material->unit}) melebihi stok yang ada.";
                } else {
                    $rowPayload['reason'] = "Stok tidak mencukupi. Jumlah keluar ({$qtyOut} {$material->unit}) melebihi stok yang tersedia ({$currentAvailable} {$material->unit}).";
                }
                $invalidRows[] = $rowPayload;
                continue;
            }

            // Catat pemakaian akumulatif
            $cumulativeRequested[$normNum] = $totalCumulative;

            $validRows[] = [
                'row'             => $rIndex,
                'exit_date'       => $convertedDate,
                'date_formatted'  => Carbon::parse($convertedDate)->format('d/m/Y'),
                'material_id'     => $material->id,
                'material_number' => $material->material_number,
                'material_name'   => $material->name,
                'unit'            => $material->unit,
                'recipient'       => $recipientRaw,
                'division'        => $divisionRaw,
                'quantity'        => $qtyOut,
                'description'     => $descRaw ?: null,
                'current_stock'   => $currentAvailable,
                'remaining_stock' => $currentAvailable - $totalCumulative,
            ];
        }

        $totalRows = count($validRows) + count($invalidRows);

        if ($totalRows === 0) {
            throw new \Exception('File Excel tidak memiliki baris data untuk diimpor.');
        }

        $validMaterialsCount = count(array_unique(array_column($validRows, 'material_id')));
        $totalValidQty       = array_sum(array_column($validRows, 'quantity'));

        return [
            'total_rows'            => $totalRows,
            'valid_count'           => count($validRows),
            'invalid_count'         => count($invalidRows),
            'total_valid_quantity'  => $totalValidQty,
            'valid_materials_count' => $validMaterialsCount,
            'valid_rows'            => $validRows,
            'invalid_rows'          => $invalidRows,
        ];
    }
}
