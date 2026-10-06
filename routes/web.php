<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PasswordController;
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

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Data Material
    Route::get('/materials/export', [MaterialController::class, 'export'])
        ->name('materials.export');
    Route::get('/materials/import', [MaterialController::class, 'importForm'])
        ->name('materials.import');

    Route::resource('materials', MaterialController::class);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});