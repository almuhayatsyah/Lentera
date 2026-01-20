<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page for guests, redirect to dashboard for authenticated users
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    
    // Fetch real statistics for landing page
    $stats = [
        'posyandu' => \App\Models\Posyandu::where('aktif', true)->count(),
        'balita' => \App\Models\Anak::where('aktif', true)->count(),
        'kader' => \App\Models\User::where('role', 'kader')->where('aktif', true)->count(),
    ];
    
    return view('landing', compact('stats'));
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
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

    // Export Routes
    Route::get('/export/anak', [App\Http\Controllers\ExportController::class, 'anak'])->name('export.anak');
    Route::get('/export/ibu', [App\Http\Controllers\ExportController::class, 'ibu'])->name('export.ibu');
    Route::get('/export/kunjungan', [App\Http\Controllers\ExportController::class, 'kunjungan'])->name('export.kunjungan');

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

        // Activity Logs
        Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
        Route::get('/activity-log/{activity_log}', [ActivityLogController::class, 'show'])->name('activity-log.show');
        Route::delete('/activity-log/{activity_log}', [ActivityLogController::class, 'destroy'])->name('activity-log.destroy');
        Route::post('/activity-log/clear', [ActivityLogController::class, 'clear'])->name('activity-log.clear');
    });
});

require __DIR__.'/auth.php';
