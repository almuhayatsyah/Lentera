<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login or dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Data Master - Ibu
    Route::resource('ibu', IbuController::class);

    // Data Master - Anak
    Route::resource('anak', AnakController::class);
    Route::get('/anak/{anak}/riwayat', [AnakController::class, 'riwayat'])->name('anak.riwayat');

    // Kunjungan / Visit
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/wizard', [KunjunganController::class, 'wizard'])->name('kunjungan.wizard');
    Route::get('/kunjungan/wizard/{anak}', [KunjunganController::class, 'wizardWithAnak'])->name('kunjungan.wizard.anak');
    Route::post('/kunjungan/store', [KunjunganController::class, 'store'])->name('kunjungan.store');
    Route::get('/kunjungan/history', [KunjunganController::class, 'history'])->name('kunjungan.history');
    Route::get('/kunjungan/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');

    // API for live calculation (AJAX)
    Route::post('/api/calculate-status', [KunjunganController::class, 'calculateStatus'])->name('api.calculate-status');
    Route::get('/api/search-anak', [AnakController::class, 'search'])->name('api.search-anak');

    // Admin Only Routes
    Route::middleware('can:admin')->group(function () {
        // Posyandu Management
        Route::resource('posyandu', PosyanduController::class);

        // User Management
        Route::resource('users', UserController::class);

        // Laporan / Reports
        Route::get('/laporan/skdn', [LaporanController::class, 'skdn'])->name('laporan.skdn');
        Route::get('/laporan/sebaran', [LaporanController::class, 'sebaran'])->name('laporan.sebaran');
        Route::get('/laporan/export-skdn', [LaporanController::class, 'exportSkdn'])->name('laporan.export-skdn');
    });
});

require __DIR__.'/auth.php';
