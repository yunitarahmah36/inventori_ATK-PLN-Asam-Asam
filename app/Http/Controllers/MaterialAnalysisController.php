<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MaterialAnalysisController extends Controller
{
    /**
     * Dapatkan data seluruh material dengan No Material sebagai identitas unik.
     * Material dengan nama sama tetapi No Material berbeda tidak digabungkan.
     */
    protected function getGroupedMaterials()
    {
        $allMaterials = Material::with('creator')
            ->orderBy('name')
            ->get();

        $allMovements = StockMovement::with('user')->get();

        $groups = collect();
        $usedSlugs = [];

        foreach ($allMaterials as $mat) {
            $rawName   = trim($mat->name ?? '');
            $matNumber = trim($mat->material_number ?? '');
            $key       = mb_strtolower($matNumber);

            // Filter pergerakan stok khusus untuk material ini berdasarkan material_id atau material_number
            $groupMovements = $allMovements->filter(function ($mov) use ($mat, $matNumber) {
                if ($mov->material_id && $mov->material_id === $mat->id) {
                    return true;
                }
                if ($mov->material_number && strtoupper(trim($mov->material_number)) === strtoupper($matNumber)) {
                    return true;
                }
                return false;
            })->unique('id');

            $totalMasuk = 0;
            $totalKeluar = 0;

            foreach ($groupMovements as $mov) {
                $change = (int) $mov->quantity_change;
                if ($change > 0) {
                    $totalMasuk += $change;
                } elseif ($change < 0) {
                    $totalKeluar += abs($change);
                }
            }

            $currentQty = (int) $mat->quantity;

            // Minimal stok masuk mencakup stok fisik saat ini + yang sudah keluar
            if ($totalMasuk < $currentQty + $totalKeluar) {
                $effectiveMasuk = max($totalMasuk, $currentQty + $totalKeluar);
            } else {
                $effectiveMasuk = $totalMasuk;
            }

            // Status ketersediaan stok
            if ($currentQty <= 0) {
                $status = 'Habis';
                $statusClass = 'danger';
            } elseif ($currentQty <= 15) {
                $status = 'Menipis';
                $statusClass = 'warning';
            } else {
                $status = 'Aman';
                $statusClass = 'success';
            }

            // Generate URL slug ramah pengguna berdasarkan No Material & Nama
            $baseSlug = Str::slug($matNumber);
            if (empty($baseSlug)) {
                $baseSlug = 'mat-' . $mat->id;
            }
            $slug = $baseSlug;
            $counter = 1;
            while (isset($usedSlugs[$slug])) {
                $slug = $baseSlug . '-' . (++$counter);
            }
            $usedSlugs[$slug] = true;

            $groups->push([
                'key'                => $key,
                'slug'               => $slug,
                'material_id'        => $mat->id,
                'material_number'    => $matNumber,
                'name'               => $rawName,
                'raw_name'           => $rawName,
                'canonical_name'     => $rawName,
                'item'               => $mat,
                'items'              => collect([$mat]),
                'items_count'        => 1,
                'variants'           => collect([$rawName]),
                'variants_count'     => 1,
                'has_duplicates'     => false,
                'material_numbers'   => [$matNumber],
                'total_quantity'     => $currentQty,
                'unit'               => $mat->unit ?: '-',
                'total_masuk'        => $effectiveMasuk,
                'total_keluar'       => $totalKeluar,
                'movements_count'    => $groupMovements->count(),
                'status'             => $status,
                'status_class'       => $statusClass,
                'first_entry_date'   => $mat->entry_date,
                'last_entry_date'    => $mat->entry_date,
            ]);
        }

        return $groups;
    }

    /**
     * Siapkan data agregasi mutasi stok per periode Hari, Minggu, dan Bulan.
     *
     * @param  \Illuminate\Support\Collection  $movements
     * @return array
     */
    protected function prepareMovementPeriodData($movements)
    {
        $today = Carbon::today();

        // 1. Data per HARI (14 hari terakhir)
        $days = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = $today->copy()->subDays($i);
            $key = $d->format('Y-m-d');
            $days[$key] = [
                'label'  => $d->translatedFormat('d M'),
                'masuk'  => 0,
                'keluar' => 0
            ];
        }

        // 2. Data per MINGGU (8 minggu terakhir)
        $weeks = [];
        for ($i = 7; $i >= 0; $i--) {
            $wStart = $today->copy()->subWeeks($i)->startOfWeek();
            $wEnd = $wStart->copy()->endOfWeek();
            $key = $wStart->format('Y-W');
            $weeks[$key] = [
                'label'  => $wStart->translatedFormat('d M') . ' - ' . $wEnd->translatedFormat('d M'),
                'masuk'  => 0,
                'keluar' => 0
            ];
        }

        // 3. Data per BULAN (6 bulan terakhir)
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $mDate = $today->copy()->subMonths($i)->startOfMonth();
            $key = $mDate->format('Y-m');
            $months[$key] = [
                'label'  => $mDate->translatedFormat('M Y'),
                'masuk'  => 0,
                'keluar' => 0
            ];
        }

        // Agregasi mutasi ke masing-masing periode
        foreach ($movements as $m) {
            if (!$m->created_at) continue;
            $cDate = Carbon::parse($m->created_at);
            $change = (int) $m->quantity_change;
            $masuk = $change > 0 ? $change : 0;
            $keluar = $change < 0 ? abs($change) : 0;

            // Hari
            $dKey = $cDate->format('Y-m-d');
            if (isset($days[$dKey])) {
                $days[$dKey]['masuk'] += $masuk;
                $days[$dKey]['keluar'] += $keluar;
            } else {
                $days[$dKey] = [
                    'label'  => $cDate->translatedFormat('d M'),
                    'masuk'  => $masuk,
                    'keluar' => $keluar
                ];
            }

            // Minggu
            $wKey = $cDate->format('Y-W');
            if (isset($weeks[$wKey])) {
                $weeks[$wKey]['masuk'] += $masuk;
                $weeks[$wKey]['keluar'] += $keluar;
            } else {
                $wStart = $cDate->copy()->startOfWeek();
                $wEnd = $wStart->copy()->endOfWeek();
                $weeks[$wKey] = [
                    'label'  => $wStart->translatedFormat('d M') . ' - ' . $wEnd->translatedFormat('d M'),
                    'masuk'  => $masuk,
                    'keluar' => $keluar
                ];
            }

            // Bulan
            $mKey = $cDate->format('Y-m');
            if (isset($months[$mKey])) {
                $months[$mKey]['masuk'] += $masuk;
                $months[$mKey]['keluar'] += $keluar;
            } else {
                $months[$mKey] = [
                    'label'  => $cDate->translatedFormat('M Y'),
                    'masuk'  => $masuk,
                    'keluar' => $keluar
                ];
            }
        }

        ksort($days);
        ksort($weeks);
        ksort($months);

        return [
            'hari' => [
                'labels' => array_column(array_values($days), 'label'),
                'masuk'  => array_column(array_values($days), 'masuk'),
                'keluar' => array_column(array_values($days), 'keluar'),
            ],
            'minggu' => [
                'labels' => array_column(array_values($weeks), 'label'),
                'masuk'  => array_column(array_values($weeks), 'masuk'),
                'keluar' => array_column(array_values($weeks), 'keluar'),
            ],
            'bulan' => [
                'labels' => array_column(array_values($months), 'label'),
                'masuk'  => array_column(array_values($months), 'masuk'),
                'keluar' => array_column(array_values($months), 'keluar'),
            ],
        ];
    }

    /**
     * Menampilkan halaman Analisis Material dalam format Card Grid.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $groups = $this->getGroupedMaterials();

        // Total Statistik Global (KPI Cards)
        $totalGroupsCount     = $groups->count();
        $totalCombinedStock   = $groups->sum('total_quantity');
        $totalOverallMasuk    = $groups->sum('total_masuk');
        $totalOverallKeluar   = $groups->sum('total_keluar');
        $duplicateGroupsCount = 0;
        $lowStockCount        = $groups->whereIn('status', ['Menipis', 'Habis'])->count();

        // Filter dan Pencarian untuk Cards
        $search = $request->query('search', '');
        $filterStatus = $request->query('status', '');
        $sortBy = $request->query('sort', 'stock_desc');

        $filteredGroups = $groups;

        // Pencarian (berdasarkan nama material atau no material)
        if (!empty($search)) {
            $searchLower = mb_strtolower(trim($search));
            $filteredGroups = $filteredGroups->filter(function ($grp) use ($searchLower) {
                if (str_contains(mb_strtolower($grp['name']), $searchLower)) {
                    return true;
                }
                if (str_contains(mb_strtolower($grp['material_number']), $searchLower)) {
                    return true;
                }
                return false;
            });
        }

        // Filter Status
        if (!empty($filterStatus)) {
            if ($filterStatus === 'low') {
                $filteredGroups = $filteredGroups->where('status', 'Menipis');
            } elseif ($filterStatus === 'out') {
                $filteredGroups = $filteredGroups->where('status', 'Habis');
            } elseif ($filterStatus === 'safe') {
                $filteredGroups = $filteredGroups->where('status', 'Aman');
            }
        }

        // Pengurutan (Sorting)
        switch ($sortBy) {
            case 'stock_asc':
                $filteredGroups = $filteredGroups->sortBy('total_quantity');
                break;
            case 'name_asc':
                $filteredGroups = $filteredGroups->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
                break;
            case 'name_desc':
                $filteredGroups = $filteredGroups->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);
                break;
            case 'masuk_desc':
                $filteredGroups = $filteredGroups->sortByDesc('total_masuk');
                break;
            case 'keluar_desc':
                $filteredGroups = $filteredGroups->sortByDesc('total_keluar');
                break;
            case 'stock_desc':
            default:
                $filteredGroups = $filteredGroups->sortByDesc('total_quantity');
                break;
        }

        // Pagination untuk Cards (default 12 kartu per halaman)
        $perPage = (int) $request->query('per_page', 12);
        if (!in_array($perPage, [6, 12, 24, 48])) {
            $perPage = 12;
        }

        $currentPage = (int) $request->query('page', 1);
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $totalFiltered = $filteredGroups->count();
        $totalPages = max(1, (int) ceil($totalFiltered / $perPage));
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $paginatedGroups = $filteredGroups->forPage($currentPage, $perPage)->values();

        return view('material-analysis.index', [
            'user'                 => $user,
            'groups'               => $paginatedGroups,
            'totalFiltered'        => $totalFiltered,
            'totalGroupsCount'     => $totalGroupsCount,
            'totalCombinedStock'   => $totalCombinedStock,
            'totalOverallMasuk'    => $totalOverallMasuk,
            'totalOverallKeluar'   => $totalOverallKeluar,
            'duplicateGroupsCount' => $duplicateGroupsCount,
            'lowStockCount'        => $lowStockCount,
            'search'               => $search,
            'filterStatus'         => $filterStatus,
            'sortBy'               => $sortBy,
            'perPage'              => $perPage,
            'currentPage'          => $currentPage,
            'totalPages'           => $totalPages,
        ]);
    }

    /**
     * Menampilkan halaman Detail Material.
     * Berisi informasi stok, grafik pergerakan stok masuk dan keluar, serta riwayat transaksi.
     */
    public function show($key)
    {
        $user = Auth::user();
        $groups = $this->getGroupedMaterials();

        // Cari material berdasarkan slug, key, atau nomor material
        $searchKey = mb_strtolower(urldecode($key));
        $group = $groups->first(function ($g) use ($key, $searchKey) {
            return $g['slug'] === $key
                || strtolower($g['slug']) === $searchKey
                || $g['key'] === $searchKey
                || Str::slug($g['material_number']) === $searchKey
                || strtolower($g['material_number']) === $searchKey
                || in_array(strtoupper($searchKey), array_map('strtoupper', $g['material_numbers']))
                || (string) $g['material_id'] === $key;
        });

        if (!$group) {
            abort(404, 'Material tidak ditemukan dalam analisis inventori.');
        }

        $materialId = $group['material_id'];
        $matNumber  = $group['material_number'];

        // Ambil seluruh riwayat transaksi / mutasi khusus untuk material ini
        $transactions = StockMovement::with(['user', 'material'])
            ->where(function ($q) use ($materialId, $matNumber) {
                if ($materialId) {
                    $q->where('material_id', $materialId);
                }
                if ($matNumber) {
                    $q->orWhere('material_number', $matNumber);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Siapkan data grafik kronologis mutasi stok khusus material ini
        $chronologicalMovements = $transactions->sortBy('created_at')->values();

        $timelineLabels = [];
        $timelineMasuk  = [];
        $timelineKeluar = [];
        $timelineBalance = [];

        foreach ($chronologicalMovements as $mov) {
            $dateLabel = $mov->created_at ? $mov->created_at->format('d/m/Y H:i') : '-';
            $change = (int) $mov->quantity_change;

            $timelineLabels[]  = $dateLabel;
            $timelineMasuk[]   = $change > 0 ? $change : 0;
            $timelineKeluar[]  = $change < 0 ? abs($change) : 0;
            $timelineBalance[] = (int) $mov->quantity_after;
        }

        // Data Grafik Pergerakan Stok per Periode (Hari, Minggu, Bulan) untuk material ini
        $movementPeriodData = $this->prepareMovementPeriodData($transactions);

        $rawMovements = $transactions->map(function ($m) {
            return [
                'd' => $m->created_at ? $m->created_at->format('Y-m-d') : null,
                'm' => $m->created_at ? $m->created_at->format('Y-m') : null,
                'y' => $m->created_at ? $m->created_at->format('Y') : null,
                'c' => (int) $m->quantity_change,
            ];
        })->values();

        $availableYears = $transactions->map(function ($m) {
            return $m->created_at ? $m->created_at->format('Y') : null;
        })->filter()->unique()->values()->all();

        $currentYear = (string) Carbon::now()->year;
        if (empty($availableYears)) {
            $availableYears = [$currentYear];
        }
        if (!in_array($currentYear, $availableYears)) {
            array_unshift($availableYears, $currentYear);
        }
        rsort($availableYears);

        return view('material-analysis.show', [
            'user'               => $user,
            'group'              => $group,
            'transactions'       => $transactions,
            'timelineLabels'     => $timelineLabels,
            'timelineMasuk'      => $timelineMasuk,
            'timelineKeluar'     => $timelineKeluar,
            'timelineBalance'    => $timelineBalance,
            'movementPeriodData' => $movementPeriodData,
            'rawMovements'       => $rawMovements,
            'availableYears'     => $availableYears,
        ]);
    }
}
