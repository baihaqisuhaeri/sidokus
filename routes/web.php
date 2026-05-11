<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('dokumentasi', DokumentasiController::class);

    // Download route
    Route::get('/dokumentasi/{dokumentasi}/download', [DokumentasiController::class, 'download'])
        ->name('dokumentasi.download');
});

require __DIR__.'/auth.php';