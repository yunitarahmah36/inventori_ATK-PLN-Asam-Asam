<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsExport implements FromCollection, WithStyles, WithColumnWidths, WithEvents
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    /**
     * Kumpulan data yang akan diekspor: hanya data master material (No. Material, Nama Material, Satuan)
     */
    public function collection()
    {
        $query = Material::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('material_number', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
            });
        }

        $materials = $query->orderBy('material_number', 'asc')->get();

        $data = collect();

        // 1. JUDUL
        $data->push([
            'DATA MASTER MATERIAL ATK',
            '',
            '',
            '',
        ]);

        $data->push([
            'PT PLN INDONESIA POWER UBP ASAM ASAM',
            '',
            '',
            '',
        ]);

        $data->push([
            'Tanggal Unduh: ' . date('d/m/Y H:i') . ' WITA',
            '',
            '',
            '',
        ]);

        // Baris kosong
        $data->push([
            '',
            '',
            '',
            '',
        ]);

        // 2. HEADER TABEL (Hanya 4 kolom: No, No. Material, Nama Material, Satuan)
        $data->push([
            'No',
            'No. Material',
            'Nama Material',
            'Satuan',
        ]);

        // 3. BARIS DATA
        foreach ($materials as $index => $mat) {
            $data->push([
                $index + 1,
                $mat->material_number,
                $mat->name,
                $mat->unit,
            ]);
        }

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,  // No
            'B' => 20, // No. Material
            'C' => 45, // Nama Material
            'D' => 16, // Satuan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Judul Utama
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 14,
                'color' => ['rgb' => '003B73'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 11,
                'color' => ['rgb' => '0057B8'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'italic' => true,
                'size'   => 9,
                'color'  => ['rgb' => '64748B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Header Tabel di baris 5
        $sheet->getStyle('A5:D5')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 10.5,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0057B8'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                $sheet->getRowDimension(5)->setRowHeight(26);

                if ($highestRow >= 6) {
                    $sheet->getStyle("A6:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("B6:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C6:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("D6:D{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Border Tabel
                    $sheet->getStyle("A5:D{$highestRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => 'CBD5E1'],
                            ],
                        ],
                    ]);
                }
            },
        ];
    }
}