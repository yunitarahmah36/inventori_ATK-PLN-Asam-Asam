<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockInTemplateExport implements FromArray, WithEvents
{
    /**
     * Data baris awal template Excel Stok Masuk
     */
    public function array(): array
    {
        return [
            [
                'No Material',
                'Nama Material',
                'Jumlah Masuk',
                'Tanggal Masuk',
                'Keterangan',
            ],
            [
                'MAT001',
                'Kertas HVS A4 80gr',
                10,
                Date::PHPToExcel(new \DateTime('2026-10-09')),
                'Pengadaan ATK Rutin Unit',
            ],
            [
                'MAT002',
                'Spidol Boardmarker Hitam',
                25,
                Date::PHPToExcel(new \DateTime('2026-10-09')),
                'Stok Operasional Kantor',
            ],
        ];
    }

    /**
     * Styling dan format header template Excel Stok Masuk
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Style Header (A1:E1)
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 11,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '0057B8'], // PLN Blue
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '003B73'],
                        ],
                    ],
                ]);

                // Format Tanggal Kolom D
                $sheet->getStyle('D2:D500')
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');

                // Lebar kolom otomatis
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
