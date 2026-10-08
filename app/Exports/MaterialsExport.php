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
    protected $startDate;
    protected $endDate;
    protected $perPage;
    protected $page;
    protected $filterStock;

    public function __construct(
        $search = null,
        $startDate = null,
        $endDate = null,
        $perPage = null,
        $page = null,
        $filterStock = null
    ) {
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->filterStock = $filterStock;
    }

    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        $query = Material::query();

        // Filter pencarian
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where(
                    'material_number',
                    'like',
                    "%{$this->search}%"
                )->orWhere(
                    'name',
                    'like',
                    "%{$this->search}%"
                );
            });
        }

        // Filter tanggal mulai
        if (!empty($this->startDate)) {
            $query->whereDate(
                'entry_date',
                '>=',
                $this->startDate
            );
        }

        // Filter tanggal akhir
        if (!empty($this->endDate)) {
            $query->whereDate(
                'entry_date',
                '<=',
                $this->endDate
            );
        }

        // Filter stok menipis (<= 15 unit)
        if ($this->filterStock === 'low') {
            $query->where('quantity', '<=', 15);
            $query->orderBy('quantity', 'asc')->orderBy('entry_date', 'asc');
        } else {
            $query->latest('entry_date')->latest('id');
        }

        $startNumber = 1;

        if ($this->perPage === 'all' || $this->perPage === 'Semua') {
            $materials = $query->get();
        } else {
            $perPageValue = in_array((int) $this->perPage, [10, 25, 50, 100, 250])
                ? (int) $this->perPage
                : 25;
            $pageValue = max((int) ($this->page ?? 1), 1);

            $materials = $query->forPage($pageValue, $perPageValue)->get();
            $startNumber = (($pageValue - 1) * $perPageValue) + 1;
        }

        $data = collect();

        // =========================
        // JUDUL
        // =========================

        $data->push([
            'DATA MATERIAL',
            '',
            '',
            '',
            '',
            '',
            '',
        ]);

        // =========================
        // PERIODE
        // =========================

        if ($this->startDate && $this->endDate) {

            if ($this->startDate === $this->endDate) {

                $periode = 'Tanggal: ' .
                    date(
                        'd/m/Y',
                        strtotime($this->startDate)
                    );

            } else {

                $periode = 'Periode: ' .
                    date(
                        'd/m/Y',
                        strtotime($this->startDate)
                    ) .
                    ' s.d. ' .
                    date(
                        'd/m/Y',
                        strtotime($this->endDate)
                    );
            }

        } elseif ($this->startDate) {

            $periode = 'Mulai tanggal: ' .
                date(
                    'd/m/Y',
                    strtotime($this->startDate)
                );

        } elseif ($this->endDate) {

            $periode = 'Sampai tanggal: ' .
                date(
                    'd/m/Y',
                    strtotime($this->endDate)
                );

        } else {

            $periode = 'Seluruh Data Material';
        }

        $data->push([
            $periode,
            '',
            '',
            '',
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
            '',
            '',
            '',
        ]);

        // =========================
        // HEADER TABEL
        // =========================

        $data->push([
            'No',
            'No Material',
            'Nama Material',
            'Tanggal Masuk',
            'Jumlah Item',
            'Satuan',
            'Deskripsi',
        ]);

        // =========================
        // DATA MATERIAL
        // =========================

        foreach ($materials as $index => $mat) {

            $data->push([
                $startNumber + $index,
                $mat->material_number,
                $mat->name,
                $mat->entry_date
                    ? $mat->entry_date->format('d/m/Y')
                    : '-',
                $mat->quantity,
                $mat->unit,
                $mat->description ?? '-',
            ]);
        }

        return $data;
    }

    /**
     * Styling dasar
     */
    public function styles(Worksheet $sheet)
    {
        // =========================
        // JUDUL
        // =========================

        $sheet->mergeCells('A1:G1');

        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // =========================
        // PERIODE
        // =========================

        $sheet->mergeCells('A2:G2');

        $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // =========================
        // HEADER TABEL
        // =========================

        $sheet->getStyle('A4:G4')->applyFromArray([
            'font' => [
                'bold' => true,
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
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '808080',
                    ],
                ],
            ],
        ]);

        return [];
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 18,
            'C' => 30,
            'D' => 18,
            'E' => 15,
            'F' => 15,
            'G' => 40,
        ];
    }

    /**
     * Event setelah sheet dibuat
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                // =========================
                // TINGGI BARIS
                // =========================

                $sheet->getRowDimension(1)
                    ->setRowHeight(30);

                $sheet->getRowDimension(2)
                    ->setRowHeight(22);

                $sheet->getRowDimension(4)
                    ->setRowHeight(25);

                // =========================
                // BORDER TABEL
                // =========================

                if ($highestRow >= 4) {

                    $sheet
                        ->getStyle("A4:G{$highestRow}")
                        ->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' =>
                                        Border::BORDER_THIN,
                                    'color' => [
                                        'rgb' => 'BFBFBF',
                                    ],
                                ],
                            ],
                        ]);
                }

                // =========================
                // ALIGNMENT
                // =========================

                if ($highestRow >= 5) {

                    // Nomor
                    $sheet
                        ->getStyle("A5:A{$highestRow}")
                        ->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    // Tanggal, jumlah, satuan
                    $sheet
                        ->getStyle("D5:F{$highestRow}")
                        ->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    // Deskripsi
                    $sheet
                        ->getStyle("G5:G{$highestRow}")
                        ->getAlignment()
                        ->setWrapText(true);
                }

                // =========================
                // FREEZE HEADER
                // =========================

                $sheet->freezePane('A5');

                // =========================
                // FILTER EXCEL
                // =========================

                if ($highestRow >= 4) {
                    $sheet->setAutoFilter(
                        "A4:G{$highestRow}"
                    );
                }

                // =========================
                // WARNA SELANG-SELING
                // =========================

                for ($row = 5; $row <= $highestRow; $row++) {

                    if ($row % 2 === 0) {

                        $sheet
                            ->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(
                                Fill::FILL_SOLID
                            );

                        $sheet
                            ->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->getStartColor()
                            ->setRGB('F2F6FC');
                    }
                }
            },
        ];
    }
}