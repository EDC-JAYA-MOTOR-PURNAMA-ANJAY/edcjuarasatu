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
    Route::get('/management-pengguna', function () {
        return view('admin.management-pengguna.index');
    })->name('management-pengguna');
    
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
    
    // Tahun Ajaran New (Alternatif UI)
    Route::get('/tahun-ajaran-new', function () {
        return view('admin.tahun-ajaran.index-new');
    })->name('tahun-ajaran-new');

    // Rekap Absensi
    Route::get('/rekap-absensi', [App\Http\Controllers\Admin\AbsensiController::class, 'rekapAbsensi'])->name('rekap-absensi');
    
    // Detail Absensi
    Route::get('/detail-absensi/{id}', [App\Http\Controllers\Admin\AbsensiController::class, 'detailAbsensi'])->name('detail-absensi');
    
    // Summary by Kelas (API)
    Route::get('/absensi/summary/{kelasId}', [App\Http\Controllers\Admin\AbsensiController::class, 'getSummaryByKelas'])->name('absensi.summary');
    
    // Export Absensi
    Route::get('/absensi/export', [App\Http\Controllers\Admin\AbsensiController::class, 'exportAbsensi'])->name('absensi.export');

    // Monitoring & Statistik
    Route::get('/monitoring', [App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/monitoring/data', [App\Http\Controllers\Admin\MonitoringController::class, 'getData'])->name('monitoring.data');
    Route::get('/monitoring/export-pdf', [App\Http\Controllers\Admin\MonitoringController::class, 'exportPdf'])->name('monitoring.export-pdf');
    Route::get('/monitoring/export-excel', [App\Http\Controllers\Admin\MonitoringController::class, 'exportExcel'])->name('monitoring.export-excel');

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
    // Dashboard with Analytics
    Route::get('/dashboard', [\App\Http\Controllers\GuruBK\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [\App\Http\Controllers\GuruBK\DashboardController::class, 'exportAnalytics'])->name('dashboard.export');

    // Chatbot Reports
    Route::prefix('chatbot')->name('chatbot.')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'reports'])->name('reports');
        Route::get('/student/{id}', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'studentHistory'])->name('student.history');
        Route::get('/export', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'exportReport'])->name('export');
        
        // NEW: Shared conversations & analytics
        Route::get('/shared-conversations', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'sharedConversations'])->name('shared');
        Route::get('/conversation/{id}', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'viewSharedConversation'])->name('conversation.view');
        Route::post('/conversation/{id}/notes', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'addNotes'])->name('conversation.notes');
        Route::get('/analytics', [\App\Http\Controllers\GuruBK\ChatbotController::class, 'analytics'])->name('analytics');
    });

    // Appointments Management
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'index'])->name('index');
        Route::get('/calendar', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'calendar'])->name('calendar');
        Route::get('/{appointment}', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'show'])->name('show');
        Route::post('/{appointment}/approve', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'approve'])->name('approve');
        Route::post('/{appointment}/reject', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'reject'])->name('reject');
        Route::post('/{appointment}/complete', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'complete'])->name('complete');
        Route::post('/{appointment}/cancel', [\App\Http\Controllers\GuruBK\AppointmentController::class, 'cancel'])->name('cancel');
    });
    
    // Notifications
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Management Konseling
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/', function () {
            return view('guru_bk.konseling.index');
        })->name('index');
        
        Route::get('/jadwal', function () {
            return view('guru_bk.konseling.jadwal');
        })->name('jadwal');
        
        Route::get('/hasil', function () {
            // Get konseling data for dropdown (pending konseling)
            $konselings = collect([
                (object)[
                    'id' => 1,
                    'judul' => 'Konseling Akademik',
                    'tanggal_konseling' => now(),
                    'siswa' => (object)['nama' => 'Ahmad Rizki']
                ],
                (object)[
                    'id' => 2,
                    'judul' => 'Konseling Pribadi',
                    'tanggal_konseling' => now()->subDays(1),
                    'siswa' => (object)['nama' => 'Siti Nurhaliza']
                ]
            ]);
            
            // Get hasil konseling data (completed konseling with results)
            $hasilKonselings = collect([
                (object)[
                    'id' => 1,
                    'created_at' => now()->subDays(2),
                    'kategori' => 'Akademik',
                    'konseling' => (object)[
                        'siswa' => (object)['nama' => 'Ahmad Rizki']
                    ]
                ],
                (object)[
                    'id' => 2,
                    'created_at' => now()->subDays(5),
                    'kategori' => 'Pribadi',
                    'konseling' => (object)[
                        'siswa' => (object)['nama' => 'Siti Nurhaliza']
                    ]
                ]
            ]);
            
            return view('guru_bk.konseling.hasil', compact('konselings', 'hasilKonselings'));
        })->name('hasil');
        
        Route::post('/hasil/store', function (Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'konseling_id' => 'required',
                'masalah' => 'required|string',
                'analisis' => 'required|string',
                'rencana' => 'required|string',
                'kategori' => 'required|string',
            ]);
            
            // TODO: Save to database
            // For now, just redirect back with success message
            
            return redirect()->route('guru_bk.konseling.hasil')
                ->with('success', 'Catatan hasil konseling berhasil disimpan!');
        })->name('hasil.store');
    });

    // Management Pelanggaran
    Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
        Route::get('/', function () {
            return view('guru_bk.pelanggaran.index');
        })->name('index');
    });
    
    // Data Siswa
    Route::get('/data-siswa', function () {
        return view('guru_bk.data-siswa.index');
    })->name('data-siswa');
    
    // Analisis Angket
    Route::get('/analisis', function () {
        return view('guru_bk.analisis.index');
    })->name('analisis');
    
    // Materi Management - Resource Routes
    Route::resource('materi', \App\Http\Controllers\MateriController::class);
    
    // Materi Toggle Status
    Route::post('/materi/{materi}/toggle-status', [\App\Http\Controllers\MateriController::class, 'toggleStatus'])
        ->name('materi.toggle-status');
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

    // Appointments (Student Booking)
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Student\AppointmentController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Student\AppointmentController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Student\AppointmentController::class, 'store'])->name('store');
        Route::get('/{appointment}', [\App\Http\Controllers\Student\AppointmentController::class, 'show'])->name('show');
        Route::post('/{appointment}/cancel', [\App\Http\Controllers\Student\AppointmentController::class, 'cancel'])->name('cancel');
    });

    // Violation
    Route::get('/violation', function () {
        return view('student.violation.index');
    })->name('violation');

    // Questionnaire
    Route::get('/questionnaire', function () {
        return view('student.questionnaire.index');
    })->name('questionnaire');
    
    Route::get('/questionnaire/start/{id}', function ($id) {
        return view('student.questionnaire.take', ['questionnaireId' => $id]);
    })->name('questionnaire.start');
    
    Route::get('/questionnaire/result', function () {
        return view('student.questionnaire.result');
    })->name('questionnaire.result');

    // Materi (Educational Materials) - Connected to Database
    Route::get('/materi', [\App\Http\Controllers\MateriController::class, 'studentIndex'])->name('materi');
    Route::get('/materi/{materi}', [\App\Http\Controllers\MateriController::class, 'studentShow'])->name('materi.show');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');

    // AI Companion
    Route::prefix('ai-companion')->name('ai-companion.')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\AiCompanionController::class, 'index'])->name('index');
        Route::post('/chat', [App\Http\Controllers\Student\AiCompanionController::class, 'chat'])->name('chat');
        Route::get('/history', [App\Http\Controllers\Student\AiCompanionController::class, 'history'])->name('history');
        Route::post('/save-history', [App\Http\Controllers\Student\AiCompanionController::class, 'saveHistory'])->name('save-history');
        Route::post('/clear', [App\Http\Controllers\Student\AiCompanionController::class, 'clearHistory'])->name('clear');
        Route::get('/stats', [App\Http\Controllers\Student\AiCompanionController::class, 'stats'])->name('stats');
        Route::get('/export-pdf', [App\Http\Controllers\Student\AiCompanionController::class, 'exportPdf'])->name('export-pdf');
        
        // NEW: Sharing features
        Route::post('/share-with-guru-bk', [App\Http\Controllers\Student\AiCompanionController::class, 'shareWithGuruBK'])->name('share');
        Route::get('/shareable-conversation', [App\Http\Controllers\Student\AiCompanionController::class, 'getShareableConversation'])->name('shareable');
        
        // Alternatif UI
        Route::get('/cortex-new', function () {
            return view('student.ai-companion.index-cortex-new');
        })->name('cortex-new');
        
        // Backup UI (old version)
        Route::get('/old-backup', function () {
            return view('student.ai-companion.index-old-backup');
        })->name('old-backup');
    });

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