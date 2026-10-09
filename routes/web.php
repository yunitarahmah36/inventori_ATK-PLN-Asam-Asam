<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialAnalysisController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});


// ==========================
// LOGIN
// ==========================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


// ==========================
// LUPA PASSWORD
// ==========================
// Tidak membutuhkan login

Route::get('/forgot-password', [PasswordController::class, 'showResetForm'])
    ->name('password.reset.form');

Route::post('/forgot-password', [PasswordController::class, 'resetPassword'])
    ->name('password.reset');


// ==========================
// AREA YANG HARUS LOGIN
// ==========================

Route::middleware('auth')->group(function () {

    // ==========================
    // DASHBOARD
    // ==========================

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ==========================
    // DATA MATERIAL
    // ==========================

    Route::get('/materials/export', [MaterialController::class, 'export'])
        ->name('materials.export');

    Route::get('/materials/import/template', [MaterialController::class, 'downloadTemplate'])
    ->name('materials.import.template');

    Route::get('/materials/import', [MaterialController::class, 'importForm'])
        ->name('materials.import.form');

    Route::post('/materials/import', [MaterialController::class, 'import'])
        ->name('materials.import');

    Route::post('/materials/bulk-destroy', [MaterialController::class, 'bulkDestroy'])
        ->name('materials.bulk-destroy');

    Route::post('/materials/{material}/stock-out', [MaterialController::class, 'stockOut'])
        ->name('materials.stock-out');

    // ==========================
    // STOK MASUK (SUBMENU DATA MATERIAL)
    // ==========================

    Route::get('/materials/stock-in', [StockInController::class, 'index'])
        ->name('materials.stock-in.index');

    Route::post('/materials/stock-in', [StockInController::class, 'storeManual'])
        ->name('materials.stock-in.store');

    Route::get('/materials/stock-in/template', [StockInController::class, 'downloadTemplate'])
        ->name('materials.stock-in.template');

    Route::post('/materials/stock-in/import', [StockInController::class, 'import'])
        ->name('materials.stock-in.import');

    Route::resource('materials', MaterialController::class);


    // ==========================
    // RIWAYAT STOK
    // ==========================

Route::get('/stock-history', [StockMovementController::class, 'index'])
    ->name('stock-movements.index');

Route::get('/stock-history/export-pdf', [StockMovementController::class, 'exportPdf'])
    ->name('stock-movements.export-pdf');


    // ==========================
    // ANALISIS MATERIAL
    // ==========================

    Route::get('/material-analysis', [MaterialAnalysisController::class, 'index'])
        ->name('material-analysis.index');

    Route::get('/material-analysis/{key}', [MaterialAnalysisController::class, 'show'])
        ->name('material-analysis.show');


    // ==========================
    // PROFIL PENGGUNA
    // ==========================

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');


    // ==========================
    // LOGOUT
    // ==========================

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});