<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialAnalysisController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LandingController;

// ==========================
// LANDING PAGE & PENGAMBILAN PUBLIK
// ==========================
Route::get('/', [LandingController::class, 'index'])
    ->name('landing');

Route::get('/pengambilan-barang', [LandingController::class, 'pengambilanForm'])
    ->name('pengambilan.form');

Route::post('/pengambilan-barang', [LandingController::class, 'storePengambilan'])
    ->name('pengambilan.store');

// ==========================
// PEMINJAMAN BUKU PUBLIK (LANDING PAGE)
// ==========================
Route::get('/peminjaman-buku', [\App\Http\Controllers\LandingBookController::class, 'index'])
    ->name('public.books.index');

Route::post('/peminjaman-buku', [\App\Http\Controllers\LandingBookController::class, 'storeLoan'])
    ->name('public.books.store-loan');

Route::post('/peminjaman-buku/kembalikan/{loan}', [\App\Http\Controllers\LandingBookController::class, 'returnLoan'])
    ->name('public.books.return-loan');


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
    // DATA MATERIAL & INVENTORI (ADMIN, KEUANGAN, UMUM)
    // ==========================
    Route::middleware('role:Admin,Keuangan,Umum')->group(function () {

    Route::get('/materials/export', [MaterialController::class, 'export'])
        ->name('materials.export');

    Route::get('/materials/import/template', [MaterialController::class, 'downloadTemplate'])
    ->name('materials.import.template');

    Route::get('/materials/import', [MaterialController::class, 'importForm'])
        ->name('materials.import.form');

    Route::post('/materials/import', [MaterialController::class, 'import'])
        ->name('materials.import');

    Route::post('/materials/import/confirm', [MaterialController::class, 'confirmImport'])
        ->name('materials.import.confirm');

    Route::post('/materials/import/cancel', [MaterialController::class, 'cancelImport'])
        ->name('materials.import.cancel');

    Route::post('/materials/bulk-destroy', [MaterialController::class, 'bulkDestroy'])
        ->name('materials.bulk-destroy');

    Route::post('/materials/delete-all', [MaterialController::class, 'deleteAll'])
        ->name('materials.delete-all');

    Route::post('/materials/{material}/stock-out', [MaterialController::class, 'stockOut'])
        ->name('materials.stock-out');

    Route::match(['put', 'post'], '/materials/{material}/min-stock', [MaterialController::class, 'updateMinStock'])
        ->name('materials.update-min-stock');

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

    Route::get('/materials/stock-in/export', [StockInController::class, 'export'])
        ->name('materials.stock-in.export');

    // ==========================
    // STOK KELUAR (SUBMENU DATA MATERIAL)
    // ==========================

    Route::get('/materials/stock-out', [StockOutController::class, 'index'])
        ->name('materials.stock-out.index');

    Route::post('/materials/stock-out', [StockOutController::class, 'store'])
        ->name('materials.stock-out.store');

    Route::get('/materials/stock-out/template', [StockOutController::class, 'downloadTemplate'])
        ->name('materials.stock-out.template');

    Route::post('/materials/stock-out/import', [StockOutController::class, 'import'])
        ->name('materials.stock-out.import');

    Route::post('/materials/stock-out/import/confirm', [StockOutController::class, 'confirmImport'])
        ->name('materials.stock-out.import.confirm');

    Route::post('/materials/stock-out/import/cancel', [StockOutController::class, 'cancelImport'])
        ->name('materials.stock-out.import.cancel');

    Route::get('/materials/stock-out/export', [StockOutController::class, 'export'])
        ->name('materials.stock-out.export');

    Route::put('/materials/stock-out/{stockMovement}', [StockOutController::class, 'update'])
        ->name('materials.stock-out.update');

    Route::delete('/materials/stock-out/{stockMovement}', [StockOutController::class, 'destroy'])
        ->name('materials.stock-out.destroy');

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

    });


    // ==========================
    // MANAJEMEN USER (KHUSUS ADMIN)
    // ==========================
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    });


    // ==========================
    // KELOLA BUKU & PEMINJAMAN (ADMIN & PENGELOLA BUKU)
    // ==========================
    Route::middleware('role:Admin,Pengelola Buku')->group(function () {
        Route::resource('books', BookController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::get('/book-loans', [BookLoanController::class, 'index'])
            ->name('book-loans.index');

        Route::post('/book-loans', [BookLoanController::class, 'store'])
            ->name('book-loans.store');

        Route::put('/book-loans/{bookLoan}', [BookLoanController::class, 'update'])
            ->name('book-loans.update');

        Route::post('/book-loans/{bookLoan}/return', [BookLoanController::class, 'returnBook'])
            ->name('book-loans.return');

        Route::delete('/book-loans/{bookLoan}', [BookLoanController::class, 'destroy'])
            ->name('book-loans.destroy');
    });


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

    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
        ->name('logout');

});