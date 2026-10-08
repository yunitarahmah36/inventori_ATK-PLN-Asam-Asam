<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Data user yang sedang login (Admin / Umum / Keuangan)
        $user = Auth::user();

        // 1. Total jenis material yang terdaftar
        $totalMaterial = Material::count();

        // 2. Total seluruh stok / unit item dari semua material
        $totalStok = (int) Material::sum('quantity');

        // 3. Material yang masuk bulan ini (berdasarkan entry_date)
        $materialMasuk = Material::whereMonth('entry_date', Carbon::now()->month)
            ->whereYear('entry_date', Carbon::now()->year)
            ->count();

        // 4. Jumlah aktivitas yang terjadi hari ini
        $aktivitasHariIni = StockMovement::whereDate('created_at', Carbon::today())->count();

        // 5. Daftar material di dashboard:
        // Cukup 1 material stok menipis (<= 15 unit) paling prioritas yang dimunculkan di paling atas.
        // Sisanya diisi oleh urutan data material paling baru ke lama berdasarkan tanggal masuk / nomor material.
        $criticalLowStock = Material::where('quantity', '<=', 15)
            ->orderBy('quantity', 'asc')
            ->orderBy('entry_date', 'asc')
            ->first();

        if ($criticalLowStock) {
            $otherMaterials = Material::where('id', '!=', $criticalLowStock->id)
                ->orderBy('entry_date', 'desc')
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();

            $latestMaterials = collect([$criticalLowStock])->merge($otherMaterials);
        } else {
            $latestMaterials = Material::orderBy('entry_date', 'desc')
                ->orderBy('id', 'desc')
                ->take(6)
                ->get();
        }

        // 6. Total jenis material dengan stok menipis (<= 15 unit)
        $lowStockCount = Material::where('quantity', '<=', 15)->count();

        // 7. Aktivitas terbaru (5 data terakhir dengan relasi user dan material)
        $latestActivities = StockMovement::with(['material', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalMaterial',
            'totalStok',
            'materialMasuk',
            'aktivitasHariIni',
            'latestMaterials',
            'lowStockCount',
            'latestActivities'
        ));
    }
}