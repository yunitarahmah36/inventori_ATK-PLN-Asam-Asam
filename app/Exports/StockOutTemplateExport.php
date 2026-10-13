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

class StockOutTemplateExport implements FromArray, WithEvents, WithColumnFormatting
{
    /**
     * Data header kolom template Excel Stok Keluar
     * Kolom: Tanggal, No. Material, Nama Pengambil, Bagian/Divisi, Jumlah Keluar, Keterangan (opsional)
     */
    public function array(): array
    {
        return [
            [
                'Tanggal',
                'No. Material',
                'Nama Pengambil',
                'Bagian/Divisi',
                'Jumlah Keluar',
                'Keterangan',
            ],
        ];
    }

    /**
     * Format kolom Excel:
     * Kolom A bertipe Tanggal (dd/mm/yyyy) dan Kolom E bertipe Angka Bulat (0)
     */
    public function columnFormats(): array
    {
        return [
            'A' => 'dd/mm/yyyy',
            'E' => '0',
        ];
    }

    /**
     * Styling, komentar panduan, dan validasi data cell Excel
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | KOMENTAR PANDUAN PADA CELL HEADER
                |--------------------------------------------------------------------------
                */
                $sheet->getComment('A1')
                    ->getText()
                    ->createTextRun('Format tanggal wajib: DD/MM/YYYY (contoh: 13/10/2026)');

                $sheet->getComment('B1')
                    ->getText()
                    ->createTextRun('Masukkan No. Material yang telah terdaftar di database.');

                $sheet->getComment('C1')
                    ->getText()
                    ->createTextRun('Nama personil / pengambil barang.');

                $sheet->getComment('D1')
                    ->getText()
                    ->createTextRun('Bagian / Divisi / Unit tujuan barang.');

                $sheet->getComment('E1')
                    ->getText()
                    ->createTextRun('Jumlah keluar berupa angka bulat positif minimal 1.');

                $sheet->getComment('F1')
                    ->getText()
                    ->createTextRun('Keterangan atau catatan tambahan (opsional).');

                /*
                |--------------------------------------------------------------------------
                | STYLE HEADER
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 11,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'B46A72'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '8E4A52'],
                        ],
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | BORDER & ALIGNMENT DATA (BARIS 2 S/D 104)
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('A2:F104')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'F2E0E4'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Alignment horizontal untuk Tanggal, No. Material, dan Jumlah
                $sheet->getStyle('A2:A104')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B2:B104')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E2:E104')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Format Tanggal Kolom A
                $sheet->getStyle('A2:A104')
                    ->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy');

                // Format Jumlah Keluar Kolom E
                $sheet->getStyle('E2:E104')
                    ->getNumberFormat()
                    ->setFormatCode('0');

                /*
                |--------------------------------------------------------------------------
                | VALIDASI TANGGAL (KOLOM A)
                |--------------------------------------------------------------------------
                */
                for ($row = 2; $row <= 104; $row++) {
                    $dateValidation = new DataValidation();
                    $dateValidation->setType(DataValidation::TYPE_DATE);
                    $dateValidation->setOperator(DataValidation::OPERATOR_BETWEEN);
                    $dateValidation->setFormula1('DATE(2000,1,1)');
                    $dateValidation->setFormula2('DATE(2100,12,31)');
                    $dateValidation->setAllowBlank(true);
                    $dateValidation->setShowInputMessage(true);
                    $dateValidation->setShowErrorMessage(true);
                    $dateValidation->setErrorTitle('Tanggal tidak valid');
                    $dateValidation->setError('Format tanggal wajib DD/MM/YYYY (contoh: 13/10/2026).');
                    $dateValidation->setPromptTitle('Tanggal Keluar');
                    $dateValidation->setPrompt('Format tanggal: DD/MM/YYYY (contoh: 13/10/2026)');

                    $sheet->getCell('A' . $row)->setDataValidation($dateValidation);
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI JUMLAH KELUAR (KOLOM E)
                |--------------------------------------------------------------------------
                */
                for ($row = 2; $row <= 104; $row++) {
                    $qtyValidation = new DataValidation();
                    $qtyValidation->setType(DataValidation::TYPE_WHOLE);
                    $qtyValidation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                    $qtyValidation->setFormula1('1');
                    $qtyValidation->setAllowBlank(true);
                    $qtyValidation->setShowInputMessage(true);
                    $qtyValidation->setShowErrorMessage(true);
                    $qtyValidation->setErrorTitle('Jumlah tidak valid');
                    $qtyValidation->setError('Jumlah keluar harus berupa bilangan bulat minimal 1.');
                    $qtyValidation->setPromptTitle('Jumlah Keluar');
                    $qtyValidation->setPrompt('Masukkan kuantitas keluar (angka bulat >= 1).');

                    $sheet->getCell('E' . $row)->setDataValidation($qtyValidation);
                }

                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER & LEBAR KOLOM
                |--------------------------------------------------------------------------
                */
                $sheet->freezePane('A2');

                $sheet->getColumnDimension('A')->setWidth(18); // Tanggal
                $sheet->getColumnDimension('B')->setWidth(20); // No. Material
                $sheet->getColumnDimension('C')->setWidth(25); // Nama Pengambil
                $sheet->getColumnDimension('D')->setWidth(25); // Bagian/Divisi
                $sheet->getColumnDimension('E')->setWidth(18); // Jumlah Keluar
                $sheet->getColumnDimension('F')->setWidth(35); // Keterangan

                // Tinggi baris
                $sheet->getRowDimension(1)->setRowHeight(30);
                for ($r = 2; $r <= 104; $r++) {
                    $sheet->getRowDimension($r)->setRowHeight(22);
                }

                $sheet->getStyle('A1:F104')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
