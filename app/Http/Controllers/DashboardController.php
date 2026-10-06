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

        // 5. Material terbaru (5 data terakhir)
        $latestMaterials = Material::latest()->take(5)->get();

        // 6. Aktivitas terbaru (5 data terakhir dengan relasi user dan material)
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
            'latestActivities'
        ));
    }
}