<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsTemplateExport implements FromArray, WithStyles, WithColumnWidths, WithEvents
{
    /**
     * Data template master material: hanya 3 kolom (No. Material, Nama Material, Satuan)
     */
    public function array(): array
    {
        return [
            [
                'No. Material',
                'Nama Material',
                'Satuan',
            ],
            [
                'MAT001',
                'Kertas HVS A4 70gr',
                'Rim',
            ],
            [
                'MAT002',
                'Pulpen Standard Hitam',
                'Pcs',
            ],
            [
                'MAT003',
                'Spidol Boardmarker Hitam',
                'Pcs',
            ],
        ];
    }

    /**
     * Pengaturan lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // No. Material
            'B' => 45, // Nama Material
            'C' => 18, // Satuan
        ];
    }

    /**
     * Styling baris & kolom
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0057B8'], // PLN Blue
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Pengaturan tampilan border dan perataan isi tabel
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Perataan kolom data
                $sheet->getStyle('A2:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B2:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C2:C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Border seluruh tabel contoh
                $sheet->getStyle('A1:C4')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'CBD5E1'],
                        ],
                    ],
                ]);

                // Pastikan format kolom No. Material adalah Text agar tidak diubah excel jadi angka
                $sheet->getStyle('A2:A1000')
                    ->getNumberFormat()
                    ->setFormatCode('@');
            },
        ];
    }
}