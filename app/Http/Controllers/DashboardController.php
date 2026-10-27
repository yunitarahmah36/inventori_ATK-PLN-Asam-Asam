<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Update overdue book loans
        BookLoan::where('status', BookLoan::STATUS_DIPINJAM)
            ->whereDate('due_date', '<', Carbon::today()->toDateString())
            ->update(['status' => BookLoan::STATUS_TERLAMBAT]);

        // Data user yang sedang login (Admin / Umum / Keuangan / Pengelola Buku)
        $user = Auth::user();

        // 1. Total jenis material yang terdaftar
        $totalMaterial = Material::count();

        // 2. Total seluruh stok / unit item dari semua material
        $totalStok = (int) Material::sum('quantity');

        // 3. Material yang masuk bulan ini (berdasarkan entry_date)
        $materialMasuk = Material::whereMonth('entry_date', Carbon::now()->month)
            ->whereYear('entry_date', Carbon::now()->year)
            ->count();

        // 4. Jumlah aktivitas yang terjadi hari ini (pencatatan & perubahan pergerakan stok hari ini)
        $aktivitasHariIni = StockMovement::where(function ($q) {
            $q->whereDate('created_at', Carbon::today())
              ->orWhereDate('updated_at', Carbon::today());
        })->count();

        // 5. Daftar material di dashboard
        $criticalLowStock = Material::whereRaw('quantity <= COALESCE(min_stock, 15)')
            ->orderBy('quantity', 'asc')
            ->orderBy('entry_date', 'asc')
            ->first();

        if ($criticalLowStock) {
            $otherMaterials = Material::where('id', '!=', $criticalLowStock->id)
                ->orderBy('entry_date', 'desc')
                ->orderBy('id', 'desc')
                ->take(9)
                ->get();

            $latestMaterials = collect([$criticalLowStock])->merge($otherMaterials);
        } else {
            $latestMaterials = Material::orderBy('entry_date', 'desc')
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();
        }

        // 6. Total jenis material dengan stok menipis (<= batas minimum)
        $lowStockCount = Material::whereRaw('quantity <= COALESCE(min_stock, 15)')->count();

        // 7. Aktivitas terbaru
        $latestActivities = StockMovement::with(['material', 'user'])
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        // 8. Statistik Buku & Peminjaman
        $bookStats = [
            'total_titles'    => Book::count(),
            'total_stock'     => (int) Book::sum('total_stock'),
            'available_stock' => (int) Book::sum('available_stock'),
            'active_loans'    => BookLoan::where('status', BookLoan::STATUS_DIPINJAM)->count(),
            'overdue_loans'   => BookLoan::where('status', BookLoan::STATUS_TERLAMBAT)->count(),
            'returned_loans'  => BookLoan::where('status', BookLoan::STATUS_DIKEMBALIKAN)->count(),
        ];

        $latestBookLoans = BookLoan::with(['book', 'handler'])
            ->orderBy('loan_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalMaterial',
            'totalStok',
            'materialMasuk',
            'aktivitasHariIni',
            'latestMaterials',
            'lowStockCount',
            'latestActivities',
            'bookStats',
            'latestBookLoans'
        ));
    }
}