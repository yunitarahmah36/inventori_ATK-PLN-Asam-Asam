<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
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

    Route::resource('materials', MaterialController::class);


    // ==========================
    // RIWAYAT STOK
    // ==========================

Route::get('/stock-history', [StockMovementController::class, 'index'])
    ->name('stock-movements.index');

Route::get('/stock-history/export-pdf', [StockMovementController::class, 'exportPdf'])
    ->name('stock-movements.export-pdf');


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