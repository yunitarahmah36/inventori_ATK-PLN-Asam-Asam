<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PasswordController;
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

    Route::resource('materials', MaterialController::class);


    // ==========================
    // RIWAYAT STOK
    // ==========================

    Route::get('/stock-history', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');


    // ==========================
    // LOGOUT
    // ==========================

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});