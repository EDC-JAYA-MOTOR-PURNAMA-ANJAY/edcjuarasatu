<?php

namespace App\Providers;

use App\Models\Absensi;
use App\Models\Konseling;
use App\Observers\AbsensiObserver;
use App\Observers\KonselingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for automatic notifications
        // When Guru BK creates these records, students will automatically receive notifications
        Konseling::observe(KonselingObserver::class);
        Absensi::observe(AbsensiObserver::class);
        
        // TODO: Add more observers when models are created:
        // - PelanggaranObserver (when Pelanggaran model exists)
        // - PanggilanOrangTuaObserver (when PanggilanOrangTua model exists)
        // - HasilKonselingObserver (for konseling results)
    }
}
