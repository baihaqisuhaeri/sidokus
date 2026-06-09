<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SatkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Surat Suara
    Route::resource('dokumentasi', DokumentasiController::class);
    Route::get('/dokumentasi/{dokumentasi}/download', [DokumentasiController::class, 'download'])
        ->name('dokumentasi.download');

    // Dokumentasi Kegiatan
    Route::resource('kegiatan', KegiatanController::class);
    Route::delete('/kegiatan/foto/{foto}', [KegiatanController::class, 'destroyFoto'])
        ->name('kegiatan.foto.destroy');

    // Berkas
    Route::resource('berkas', BerkasController::class);
    Route::get('/berkas/{berka}/download', [BerkasController::class, 'download'])
        ->name('berkas.download');

    // Admin only
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
        Route::resource('satkers', SatkerController::class)->except(['show']);

        // Di dalam route auth group, sudah ada di web.php yang gw generate sebelumnya
        Route::get('/berkas/{berka}/download', [BerkasController::class, 'download'])
            ->name('berkas.download');
    });
});

require __DIR__ . '/auth.php';
