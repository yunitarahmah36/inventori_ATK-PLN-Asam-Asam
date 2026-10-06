<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMaterial = Material::count();

        $totalItem = Material::sum('quantity');

        $latestMaterials = Material::latest()->take(5)->get();

        $latestActivities = StockMovement::with(['material', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMaterial',
            'totalItem',
            'latestMaterials',
            'latestActivities'
        ));
    }
}