<?php

use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\AbsensiController;
use App\Http\Controllers\Siswa\KonselingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Absensi
    // Di dalam group route siswa
Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('index');
    Route::get('/riwayat', [AbsensiController::class, 'riwayat'])->name('riwayat');
    Route::get('/create', [AbsensiController::class, 'create'])->name('create');
    Route::post('/', [AbsensiController::class, 'store'])->name('store');
    Route::get('/{absensi}', [AbsensiController::class, 'show'])->name('show');
});
    
    // Konseling
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/ajukan', [KonselingController::class, 'create'])->name('ajukan');
        Route::get('/jadwal', [KonselingController::class, 'jadwal'])->name('jadwal');
        Route::get('/riwayat', [KonselingController::class, 'riwayat'])->name('riwayat');
    });
    
    // Routes lainnya...
    Route::get('/pelanggaran', function () {
        return view('siswa.pelanggaran.index');
    })->name('pelanggaran');
    
    Route::get('/kuesioner', function () {
        return view('siswa.kuesioner.index');
    })->name('kuesioner');
    
    Route::get('/materi', function () {
        return view('siswa.materi.index');
    })->name('materi');
    
    Route::get('/panduan', function () {
        return view('siswa.panduan.index');
    })->name('panduan');
    
    Route::get('/pengaturan', function () {
        return view('siswa.pengaturan.index');
    })->name('pengaturan');
});