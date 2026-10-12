<?php

namespace App\Imports;

use App\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaterialsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected $importedCount = 0;
    protected $skippedCount = 0;
    protected $conflicts = [];

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
     * Parse file Excel untuk analisis pratinjau (data baru, duplikat, konflik, error)
     * sebelum konfirmasi simpan.
     */
    public static function parseFile($file): array
    {
        $filePath = is_string($file) ? $file : $file->getRealPath();

        $spreadsheet = IOFactory::load($filePath);
        $worksheet   = $spreadsheet->getActiveSheet();
        $rows        = $worksheet->toArray(null, true, true, true);

        if (empty($rows)) {
            throw new \Exception('File Excel kosong atau tidak memiliki data.');
        }

        // Cari baris header (baris pertama yang memiliki teks kolom)
        $headerRowIndex = null;
        $colMap = [
            'number' => null,
            'name'   => null,
            'unit'   => null,
        ];

        foreach ($rows as $rIndex => $row) {
            $rowValues = array_map(function ($val) {
                return strtolower(trim((string) $val));
            }, $row);

            foreach ($rowValues as $colLetter => $cellVal) {
                if ($colMap['number'] === null && (str_contains($cellVal, 'no') || str_contains($cellVal, 'kode')) && str_contains($cellVal, 'mat')) {
                    $colMap['number'] = $colLetter;
                } elseif ($colMap['number'] === null && (str_contains($cellVal, 'no_material') || $cellVal === 'no material' || $cellVal === 'nomor material')) {
                    $colMap['number'] = $colLetter;
                }

                if ($colMap['name'] === null && (str_contains($cellVal, 'nama') || str_contains($cellVal, 'barang') || str_contains($cellVal, 'item'))) {
                    $colMap['name'] = $colLetter;
                }

                if ($colMap['unit'] === null && (str_contains($cellVal, 'satuan') || str_contains($cellVal, 'unit'))) {
                    $colMap['unit'] = $colLetter;
                }
            }

            if ($colMap['number'] !== null && $colMap['name'] !== null && $colMap['unit'] !== null) {
                $headerRowIndex = $rIndex;
                break;
            }
        }

        // Jika header 3 kolom spesifik tidak terdeteksi via nama, fallback ke kolom A, B, C jika baris 1
        if ($headerRowIndex === null) {
            // Coba periksa baris 1 apakah minimal memiliki 3 kolom
            if (isset($rows[1])) {
                $colMap = ['number' => 'A', 'name' => 'B', 'unit' => 'C'];
                $headerRowIndex = 1;
            } else {
                throw new \Exception('Format kolom Excel tidak sesuai. Template baru mewajibkan 3 kolom: No. Material, Nama Material, dan Satuan.');
            }
        }

        $allDataRows = [];
        $newItems    = [];
        $duplicates  = [];
        $conflicts   = [];
        $errors      = [];

        $seenInFile = [];

        // Ambil semua nomor material dari database ke memori untuk pencocokan cepat
        $existingMaterials = Material::all()->keyBy(function ($item) {
            return strtolower(trim($item->material_number));
        });

        foreach ($rows as $rIndex => $row) {
            if ($rIndex <= $headerRowIndex) {
                continue; // Lewati header
            }

            $numVal  = trim((string) ($row[$colMap['number']] ?? ''));
            $nameVal = trim((string) ($row[$colMap['name']] ?? ''));
            $unitVal = trim((string) ($row[$colMap['unit']] ?? ''));

            // Lewati jika seluruh baris kosong
            if ($numVal === '' && $nameVal === '' && $unitVal === '') {
                continue;
            }

            $allDataRows[] = [
                'row'             => $rIndex,
                'material_number' => $numVal,
                'name'            => $nameVal,
                'unit'            => $unitVal,
            ];

            // Validasi kelengkapan data
            if ($numVal === '' || $nameVal === '' || $unitVal === '') {
                $missing = [];
                if ($numVal === '')  $missing[] = 'No. Material';
                if ($nameVal === '') $missing[] = 'Nama Material';
                if ($unitVal === '') $missing[] = 'Satuan';

                $errors[] = [
                    'row'             => $rIndex,
                    'material_number' => $numVal ?: '-',
                    'name'            => $nameVal ?: '-',
                    'unit'            => $unitVal ?: '-',
                    'reason'          => 'Kolom tidak lengkap: ' . implode(', ', $missing) . ' wajib diisi.',
                ];
                continue;
            }

            $numKey         = strtolower($numVal);
            $normalizedName = self::normalizeName($nameVal);

            // 1. Cek duplikasi di internal file Excel itu sendiri
            if (isset($seenInFile[$numKey])) {
                $prev = $seenInFile[$numKey];
                if ($normalizedName !== $prev['normalized_name']) {
                    // Konflik internal file: No Material sama tapi nama material beda
                    $conflicts[] = [
                        'row'              => $rIndex,
                        'material_number'  => $numVal,
                        'name'             => $nameVal,
                        'conflicting_name' => $prev['name'],
                        'reason'           => "No. Material '{$numVal}' sama dengan Baris {$prev['row']} pada file, tetapi Nama Material berbeda ('{$nameVal}' vs '{$prev['name']}').",
                    ];
                } else {
                    // Duplikat dalam file dengan nama sama: lewati
                    $duplicates[] = [
                        'row'             => $rIndex,
                        'material_number' => $numVal,
                        'name'            => $nameVal,
                        'unit'            => $unitVal,
                        'reason'          => "Duplikat di dalam file Excel (sama dengan Baris {$prev['row']}).",
                    ];
                }
                continue;
            }

            $seenInFile[$numKey] = [
                'row'             => $rIndex,
                'name'            => $nameVal,
                'normalized_name' => $normalizedName,
            ];

            // 2. Cek terhadap database
            if ($existingMaterials->has($numKey)) {
                $existing = $existingMaterials->get($numKey);
                $existingNormName = self::normalizeName($existing->name);

                if ($normalizedName !== $existingNormName) {
                    // Konflik dengan database: No Material sudah terdaftar tapi nama berbeda
                    $conflicts[] = [
                        'row'              => $rIndex,
                        'material_number'  => $numVal,
                        'name'             => $nameVal,
                        'conflicting_name' => $existing->name,
                        'reason'           => "No. Material '{$numVal}' sudah terdaftar di sistem untuk '{$existing->name}', tetapi pada file tertulis '{$nameVal}'.",
                    ];
                } else {
                    // Duplikat data lama: No Material dan Nama sama persis -> lewati
                    $duplicates[] = [
                        'row'             => $rIndex,
                        'material_number' => $numVal,
                        'name'            => $nameVal,
                        'unit'            => $unitVal,
                        'reason'          => "Material sudah terdaftar di sistem ('{$existing->name}').",
                    ];
                }
                continue;
            }

            // 3. Data Baru yang Valid
            $newItems[] = [
                'row'             => $rIndex,
                'material_number' => $numVal,
                'name'            => $nameVal,
                'unit'            => $unitVal,
            ];
        }

        return [
            'total_rows'      => count($allDataRows),
            'new_items'       => $newItems,
            'duplicates'      => $duplicates,
            'conflicts'       => $conflicts,
            'errors'          => $errors,
            'new_count'       => count($newItems),
            'duplicate_count' => count($duplicates),
            'conflict_count'  => count($conflicts),
            'error_count'     => count($errors),
        ];
    }

    /**
     * Pelaksanaan import langsung untuk koleksi baris jika dipanggil via Excel::import.
     * Mengimpor data baru, melewati duplikat, dan menolak konflik.
     * Tidak mengubah kuantitas stok atau membuat riwayat stok.
     */
    public function collection(Collection $rows)
    {
        $existingMaterials = Material::all()->keyBy(function ($m) {
            return strtolower(trim($m->material_number));
        });

        $seenInFile = [];
        $toInsert   = [];

        foreach ($rows as $index => $row) {
            $num  = trim((string) ($row['no_material'] ?? $row['no_material'] ?? $row['kode_material'] ?? ''));
            $name = trim((string) ($row['nama_material'] ?? $row['nama'] ?? ''));
            $unit = trim((string) ($row['satuan'] ?? $row['unit'] ?? ''));

            if ($num === '' && $name === '' && $unit === '') {
                continue;
            }

            if ($num === '' || $name === '' || $unit === '') {
                continue;
            }

            $numKey  = strtolower($num);
            $normName = self::normalizeName($name);

            // Cek konflik di file
            if (isset($seenInFile[$numKey])) {
                if ($seenInFile[$numKey] !== $normName) {
                    throw new \Exception("Konflik data: No. Material '{$num}' digunakan untuk nama material yang berbeda.");
                }
                $this->skippedCount++;
                continue;
            }
            $seenInFile[$numKey] = $normName;

            // Cek di database
            if ($existingMaterials->has($numKey)) {
                $dbMat = $existingMaterials->get($numKey);
                if (self::normalizeName($dbMat->name) !== $normName) {
                    throw new \Exception("Konflik data: No. Material '{$num}' sudah terdaftar untuk '{$dbMat->name}', tetapi di file tertulis '{$name}'.");
                }
                // Duplikat yang sama persis: lewati
                $this->skippedCount++;
                continue;
            }

            $toInsert[] = [
                'material_number' => $num,
                'name'            => $name,
                'unit'            => $unit,
                'entry_date'      => now()->toDateString(),
                'quantity'        => 0,
                'is_active'       => true,
                'created_by'      => Auth::id(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        if (!empty($toInsert)) {
            DB::transaction(function () use ($toInsert) {
                Material::insert($toInsert);
            });
            $this->importedCount = count($toInsert);
        }
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
}