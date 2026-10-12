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
    protected $sort;
    protected $perPage;
    protected $page;

    public function __construct($search = null, $sort = 'latest', $perPage = null, $page = 1)
    {
        $this->search  = $search;
        $this->sort    = $sort ?: 'latest';
        $this->perPage = $perPage;
        $this->page    = (int) ($page ?: 1);
    }

    /**
     * Kumpulan data yang akan diekspor: hanya data master material (No. Material, Nama Material, Satuan).
     * Sesuai filter pencarian, filter pengurutan (A-Z, terbaru, dll), dan batasan baris data yang tampil.
     */
    public function collection()
    {
        $query = Material::query();

        // 1. Filter Pencarian
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('material_number', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
            });
        }

        // 2. Filter Pengurutan (sama persis dengan tampilan di web)
        switch ($this->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc')->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc')->orderBy('id', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc')->orderBy('id', 'desc');
                break;
            case 'number_asc':
                $query->orderBy('material_number', 'asc')->orderBy('id', 'asc');
                break;
            case 'number_desc':
                $query->orderBy('material_number', 'desc')->orderBy('id', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                break;
        }

        $startNumber = 0;

        // 3. Batasi jumlah data jika filter per_page aktif (misal 10, 20, 25, 50, dsb)
        if (!empty($this->perPage) && $this->perPage !== 'all' && $this->perPage !== 'Semua') {
            $limit = (int) $this->perPage;
            if ($limit > 0) {
                $page = max(1, $this->page);
                $query->forPage($page, $limit);
                $startNumber = ($page - 1) * $limit;
            }
        }

        $materials = $query->get();

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
                $startNumber + $index + 1,
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