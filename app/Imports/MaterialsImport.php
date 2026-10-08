<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MaterialsImport implements
    OnEachRow,
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
     * Import setiap baris dan catat riwayat stok.
     */
    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        $quantity = (int) $rowArray['jumlah_item'];

        $material = Material::create([
            'material_number' => trim($rowArray['no_material']),

            'name' => trim($rowArray['nama_material']),

            'entry_date' => $this->convertDate(
                $rowArray['tanggal_masuk']
            ),

            'quantity' => $quantity,

            'unit' => $this->normalizeUnit(
                $rowArray['satuan']
            ),

            'description' => !empty($rowArray['deskripsi'])
                ? trim($rowArray['deskripsi'])
                : null,

            'created_by' => Auth::id(),
        ]);

        // Catat riwayat aktivitas stok
        StockMovement::create([
            'material_id'     => $material->id,
            'user_id'         => Auth::id(),
            'activity'        => 'Import',
            'quantity_before' => 0,
            'quantity_after'  => $quantity,
            'quantity_change' => $quantity,
            'description'     => 'Import data via Excel',
        ]);
    }

    /**
     * Validasi data.
     */
    public function rules(): array
    {
        return [
            'no_material' => [
                'required',
                'string',
                'max:50',
                'unique:materials,material_number',
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
     * Pesan validasi yang ramah pengguna.
     */
    public function customValidationMessages(): array
    {
        return [
            'no_material.required'    => 'Kolom No Material tidak boleh kosong.',
            'no_material.max'         => 'No Material terlalu panjang (maksimal 50 karakter).',
            'no_material.unique'      => 'No Material ":input" sudah terdaftar di sistem. Gunakan nomor lain.',
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
            'pcs' => 'Pcs',
            'pc' => 'Pcs',

            'rim' => 'Rim',

            'buah' => 'Buah',

            'box' => 'Box',

            'pack' => 'Pack',

            'lusin' => 'Lusin',

            'rol' => 'Rol',
            'roll' => 'Rol',

            'lembar' => 'Lembar',

            'botol' => 'Botol',

            'karton' => 'Karton',

            'dus' => 'Dus',

            'set' => 'Set',

            'unit' => 'Unit',
        ];

        if (isset($units[$unit])) {
            return $units[$unit];
        }

        return ucwords($unit);
    }

    /**
     * Konversi tanggal Excel menjadi format database.
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

                return Date::excelToDateTimeObject(
                    $date
                )->format('Y-m-d');

            } catch (\Exception $e) {

                return null;
            }
        }

        $date = trim((string) $date);

        /*
        |--------------------------------------------------------------------------
        | Format DD/MM/YYYY
        |--------------------------------------------------------------------------
        */

        $dateObject = \DateTime::createFromFormat(
            'd/m/Y',
            $date
        );

        if ($dateObject) {
            return $dateObject->format('Y-m-d');
        }

        /*
        |--------------------------------------------------------------------------
        | Format DD-MM-YYYY
        |--------------------------------------------------------------------------
        */

        $dateObject = \DateTime::createFromFormat(
            'd-m-Y',
            $date
        );

        if ($dateObject) {
            return $dateObject->format('Y-m-d');
        }

        /*
        |--------------------------------------------------------------------------
        | Format YYYY-MM-DD
        |--------------------------------------------------------------------------
        */

        $dateObject = \DateTime::createFromFormat(
            'Y-m-d',
            $date
        );

        if ($dateObject) {
            return $dateObject->format('Y-m-d');
        }

        return null;
    }
}