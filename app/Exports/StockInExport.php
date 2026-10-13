<?php

namespace App\Exports;

use App\Models\StockMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockInExport implements FromCollection, WithStyles, WithColumnWidths, WithEvents
{
    protected $search;
    protected $startDate;
    protected $endDate;
    protected $perPage;
    protected $page;

    public function __construct(
        $search = null,
        $startDate = null,
        $endDate = null,
        $perPage = null,
        $page = null
    ) {
        $this->search    = $search;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->perPage   = $perPage;
        $this->page      = $page;
    }

    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        $query = StockMovement::with(['material', 'user'])
            ->where(function ($q) {
                $q->where('activity', 'Tambah')
                  ->orWhere('quantity_change', '>', 0);
            });

        // Filter pencarian
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('material_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter rentang tanggal
        if (!empty($this->startDate)) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if (!empty($this->endDate)) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        $query->latest('created_at')->latest('id');

        $startNumber = 1;

        if ($this->perPage === 'all' || $this->perPage === 'Semua' || empty($this->perPage)) {
            $items = $query->get();
        } else {
            $perPageValue = in_array((int) $this->perPage, [10, 25, 50, 100, 250])
                ? (int) $this->perPage
                : 25;
            $pageValue = max((int) ($this->page ?? 1), 1);

            $items = $query->forPage($pageValue, $perPageValue)->get();
            $startNumber = (($pageValue - 1) * $perPageValue) + 1;
        }

        $data = collect();

        // Row 1: Judul
        $data->push([
            'LAPORAN STOK MASUK - INVENTORI ATK PT PLN INDONESIA POWER UBP ASAM ASAM',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ]);

        // Row 2: Periode
        if ($this->startDate && $this->endDate) {
            if ($this->startDate === $this->endDate) {
                $periode = 'Tanggal: ' . date('d/m/Y', strtotime($this->startDate));
            } else {
                $periode = 'Periode: ' . date('d/m/Y', strtotime($this->startDate)) . ' s.d. ' . date('d/m/Y', strtotime($this->endDate));
            }
        } elseif ($this->startDate) {
            $periode = 'Mulai tanggal: ' . date('d/m/Y', strtotime($this->startDate));
        } elseif ($this->endDate) {
            $periode = 'Sampai tanggal: ' . date('d/m/Y', strtotime($this->endDate));
        } else {
            $periode = 'Semua Periode Transaksi';
        }

        $data->push([
            $periode,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ]);

        // Row 3: Spacer kosong
        $data->push([
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ]);

        // Row 4: Header Kolom
        $data->push([
            'No',
            'No Material',
            'Nama Material',
            'Tanggal Masuk',
            'Jumlah Masuk',
            'Satuan',
            'Keterangan / Sumber',
            'Dicatat Oleh',
        ]);

        // Data Rows
        $no = $startNumber;
        foreach ($items as $item) {
            if ($item->material && $item->material->entry_date && ($item->quantity_before == 0 || str_contains($item->description ?? '', 'Penambahan material baru') || str_contains($item->description ?? '', 'Import'))) {
                $tanggalMasuk = $item->material->entry_date->format('d/m/Y');
            } elseif ($item->created_at) {
                $tanggalMasuk = $item->created_at->format('d/m/Y');
            } elseif ($item->material && $item->material->entry_date) {
                $tanggalMasuk = $item->material->entry_date->format('d/m/Y');
            } else {
                $tanggalMasuk = '-';
            }

            $jumlahMasuk = abs($item->quantity_change);
            $satuan      = $item->material->unit ?? 'Unit';
            $keterangan  = $item->description ?: '-';
            $user        = $item->user->name ?? '-';

            $data->push([
                $no++,
                $item->material_number,
                $item->material_name ?: ($item->material->name ?? '-'),
                $tanggalMasuk,
                $jumlahMasuk,
                $satuan,
                $keterangan,
                $user,
            ]);
        }

        return $data;
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Judul utama di A1
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 14,
                'color' => ['rgb' => '003B73'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Periode di A2
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2:H2')->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 11,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Header Tabel di A4:H4
        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0057B8'],
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

        return [];
    }

    /**
     * Lebar Kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 18,
            'C' => 32,
            'D' => 18,
            'E' => 16,
            'F' => 14,
            'G' => 36,
            'H' => 22,
        ];
    }

    /**
     * Register events
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(4)->setRowHeight(26);

                if ($highestRow >= 4) {
                    $sheet->getStyle("A4:H{$highestRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => 'CBD5E1'],
                            ],
                        ],
                    ]);

                    // Alignment data
                    $sheet->getStyle("A5:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("B5:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("D5:D{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E5:E{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("F5:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Number format untuk jumlah masuk
                    $sheet->getStyle("E5:E{$highestRow}")->getNumberFormat()->setFormatCode('#,##0');
                }
            },
        ];
    }
}
