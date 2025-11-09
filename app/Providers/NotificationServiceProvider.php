<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share notification badge counts with all views
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->peran === 'siswa') {
                $studentId = Auth::id();
                
                // Badge counts for sidebar menus (only show if > 0)
                $badges = [
                    // Jadwal Konseling: konseling yang menunggu persetujuan
                    'jadwal_konseling' => Konseling::where('siswa_id', $studentId)
                                                   ->where('status', 'menunggu_persetujuan')
                                                   ->count(),
                    
                    // Materi Baru: belum dibaca (perlu table read tracking)
                    'materi_baru' => 0, // Will be implemented when materi has read tracking
                    
                    // Pelanggaran Aktif
                    'pelanggaran' => Pelanggaran::where('siswa_id', $studentId)
                                                ->where('status', 'aktif')
                                                ->count(),
                    
                    // Total Notifications (unread)
                    'total_notifications' => Notification::where('user_id', $studentId)
                                                        ->where('is_read', false)
                                                        ->count(),
                ];
                
                $view->with('badges', $badges);
            }
        });
    }
}
