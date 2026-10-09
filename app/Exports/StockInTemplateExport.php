<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockInTemplateExport implements FromArray, WithEvents, WithColumnFormatting
{
    /**
     * Data awal template Excel Stok Masuk (hanya header kolom tanpa baris contoh/data awal)
     */
    public function array(): array
    {
        return [
            [
                'No Material',
                'Nama Material',
                'Tanggal Masuk',
                'Jumlah Masuk',
                'Keterangan',
            ],
        ];
    }

    /**
     * Format kolom Excel agar kolom C selalu bertipe Tanggal (dd/mm/yyyy) dan D angka (0)
     */
    public function columnFormats(): array
    {
        return [
            'C' => 'dd/mm/yyyy',
            'D' => '0',
        ];
    }

    /**
     * Pengaturan tampilan Excel persis sama dengan MaterialsTemplateExport
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | KETERANGAN KOLOM TANGGAL
                |--------------------------------------------------------------------------
                */

                $sheet->getComment('C1')
                    ->getText()
                    ->createTextRun(
                        'Format tanggal wajib: MM/DD/YYYY (contoh: 12/20/2026)'
                    );


                /*
                |--------------------------------------------------------------------------
                | STYLE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],

                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '4472C4',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'B4C7E7',
                            ],
                        ],
                    ],
                ]);


                /*
                |--------------------------------------------------------------------------
                | BORDER DATA
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A2:E104')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'D9E2F3',
                            ],
                        ],
                    ],

                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);


                /*
                |--------------------------------------------------------------------------
                | FORMAT TANGGAL
                |--------------------------------------------------------------------------
                |
                | Excel akan menampilkan tanggal sebagai:
                | DD/MM/YYYY
                |
                */

                $sheet->getStyle('C2:C104')
                    ->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');


                /*
                |--------------------------------------------------------------------------
                | VALIDASI TANGGAL
                |--------------------------------------------------------------------------
                */

                for ($row = 2; $row <= 104; $row++) {

                    $dateValidation = new DataValidation();

                    $dateValidation->setType(
                        DataValidation::TYPE_DATE
                    );

                    $dateValidation->setOperator(
                        DataValidation::OPERATOR_BETWEEN
                    );

                    $dateValidation->setFormula1(
                        'DATE(2000,1,1)'
                    );

                    $dateValidation->setFormula2(
                        'DATE(2100,12,31)'
                    );

                    $dateValidation->setAllowBlank(true);

                    $dateValidation->setShowInputMessage(true);

                    $dateValidation->setShowErrorMessage(true);

                    $dateValidation->setErrorTitle(
                        'Tanggal tidak valid'
                    );

                    $dateValidation->setError(
                        'Masukkan tanggal dengan format MM/DD/YYYY. Contoh: 12/20/2026'
                    );

                    $dateValidation->setPromptTitle(
                        'Tanggal Masuk'
                    );

                    $dateValidation->setPrompt(
                        'Masukkan tanggal dengan format MM/DD/YYYY. Contoh: 12/20/2026'
                    );

                    $sheet
                        ->getCell('C' . $row)
                        ->setDataValidation($dateValidation);
                }


                /*
                |--------------------------------------------------------------------------
                | FORMAT JUMLAH MASUK
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('D2:D104')
                    ->getNumberFormat()
                    ->setFormatCode('0');


                /*
                |--------------------------------------------------------------------------
                | VALIDASI JUMLAH MASUK
                |--------------------------------------------------------------------------
                */

                for ($row = 2; $row <= 104; $row++) {

                    $quantityValidation = new DataValidation();

                    $quantityValidation->setType(
                        DataValidation::TYPE_WHOLE
                    );

                    $quantityValidation->setOperator(
                        DataValidation::OPERATOR_GREATERTHANOREQUAL
                    );

                    $quantityValidation->setFormula1('1');

                    $quantityValidation->setAllowBlank(true);

                    $quantityValidation->setShowInputMessage(true);

                    $quantityValidation->setShowErrorMessage(true);

                    $quantityValidation->setErrorTitle(
                        'Jumlah tidak valid'
                    );

                    $quantityValidation->setError(
                        'Jumlah Masuk harus berupa angka 1 atau lebih.'
                    );

                    $quantityValidation->setPromptTitle(
                        'Jumlah Masuk'
                    );

                    $quantityValidation->setPrompt(
                        'Masukkan jumlah masuk dalam angka.'
                    );

                    $sheet
                        ->getCell('D' . $row)
                        ->setDataValidation($quantityValidation);
                }


                /*
                |--------------------------------------------------------------------------
                | ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A1:A104')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                $sheet
                    ->getStyle('C1:C104')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                $sheet
                    ->getStyle('D1:D104')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );


                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A2');


                /*
                |--------------------------------------------------------------------------
                | TIDAK MENGGUNAKAN FILTER
                |--------------------------------------------------------------------------
                */


                /*
                |--------------------------------------------------------------------------
                | LEBAR KOLOM
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getColumnDimension('A')
                    ->setWidth(18);

                $sheet
                    ->getColumnDimension('B')
                    ->setWidth(30);

                $sheet
                    ->getColumnDimension('C')
                    ->setWidth(20);

                $sheet
                    ->getColumnDimension('D')
                    ->setWidth(17);

                $sheet
                    ->getColumnDimension('E')
                    ->setWidth(45);


                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(30);

                $sheet
                    ->getRowDimension(2)
                    ->setRowHeight(25);


                /*
                |--------------------------------------------------------------------------
                | WRAP TEXT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A1:E104')
                    ->getAlignment()
                    ->setWrapText(true);
            },
        ];
    }
}
