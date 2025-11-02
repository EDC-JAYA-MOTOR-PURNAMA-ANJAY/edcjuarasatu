<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;

// Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/features', function () {
    return view('landing.features');
})->name('features');
Route::get('/about', function () {
    return view('landing.about');
})->name('about');
Route::get('/contact', function () {
    return view('landing.contact');
})->name('contact');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    
    // Management Pengguna Routes
    Route::get('/daftar-pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('daftar-pengguna');
    Route::get('/tambah-akun', [App\Http\Controllers\Admin\PenggunaController::class, 'create'])->name('tambah-akun');
    Route::post('/pengguna/store', [App\Http\Controllers\Admin\PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{id}/edit', [App\Http\Controllers\Admin\PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{id}', [App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    Route::get('/pengguna/kelas-list', [App\Http\Controllers\Admin\PenggunaController::class, 'getKelasList'])->name('pengguna.kelas-list');

    // Tahun Ajaran - langsung di level admin
    Route::get('/tahun-ajaran', function () {
        return view('admin.tahun-ajaran.index');
    })->name('tahun-ajaran');

    // Rekap Absensi
    Route::get('/rekap-absensi', [App\Http\Controllers\Admin\AbsensiController::class, 'rekapAbsensi'])->name('rekap-absensi');
    
    // Detail Absensi
    Route::get('/detail-absensi/{id}', [App\Http\Controllers\Admin\AbsensiController::class, 'detailAbsensi'])->name('detail-absensi');
    
    // Summary by Kelas (API)
    Route::get('/absensi/summary/{kelasId}', [App\Http\Controllers\Admin\AbsensiController::class, 'getSummaryByKelas'])->name('absensi.summary');
    
    // Export Absensi
    Route::get('/absensi/export', [App\Http\Controllers\Admin\AbsensiController::class, 'exportAbsensi'])->name('absensi.export');

    // Monitoring & Statistik - langsung di level admin
    Route::get('/monitoring', function () {
        return view('admin.monitoring.index');
    })->name('monitoring');

    // Panduan Bantuan - langsung di level admin
    Route::get('/panduan', function () {
        return view('admin.setting.panduan');
    })->name('panduan');

    // Pengaturan - langsung di level admin
    Route::get('/pengaturan', function () {
        return view('admin.setting.pengaturan');
    })->name('pengaturan');

    // Route untuk halaman index admin (jika ada)
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');
});

// Guru BK Routes
Route::prefix('guru_bk')->name('guru_bk.')->middleware(['auth', 'role:guru_bk'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('guru_bk.dashboard.index');
    })->name('dashboard');

    // Management Konseling
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/', function () {
            return view('guru_bk.konseling.index');
        })->name('index');
        
        Route::get('/jadwal', function () {
            return view('guru_bk.konseling.jadwal');
        })->name('jadwal');
    });

    // Management Pelanggaran
    Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
        Route::get('/', function () {
            return view('guru_bk.pelanggaran.index');
        })->name('index');
    });
});

// Student Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'role:siswa'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('student.dashboard.index');
    })->name('dashboard');

    // Attendance
    Route::get('/attendance', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/store', [App\Http\Controllers\Student\AttendanceController::class, 'store'])->name('attendance.store');

    // Counseling
    Route::prefix('counseling')->name('counseling.')->group(function () {
        Route::get('/', function () {
            return view('student.counseling.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('student.counseling.create');
        })->name('create');
        
        Route::get('/schedule', function () {
            return view('student.counseling.schedule');
        })->name('schedule');
    });

    // Violation
    Route::get('/violation', function () {
        return view('student.violation.index');
    })->name('violation');

    // Profile
    Route::get('/profile', function () {
        return view('student.profile.index');
    })->name('profile');
});

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Debug route - hapus setelah debugging selesai
Route::get('/debug-user', function() {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'logged_in' => true,
            'user_id' => $user->id,
            'email' => $user->email,
            'nama' => $user->nama,
            'peran' => $user->peran,
            'status' => $user->status,
            'redirect_should_be' => match($user->peran) {
                'admin' => route('admin.dashboard'),
                'guru_bk' => route('guru_bk.dashboard'),
                'siswa' => route('student.dashboard'),
                default => 'Unknown role: ' . $user->peran
            }
        ]);
    }
    return response()->json(['logged_in' => false]);
})->name('debug-user');

// Fallback route
Route::fallback(function () {
    return redirect('/');
});

// Comment out default auth routes karena kita sudah buat custom LoginController
// require __DIR__.'/auth.php';