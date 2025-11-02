<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get siswa users
        $siswaList = DB::table('users')->where('peran', 'siswa')->get();
        
        // Get tahun ajaran aktif
        $tahunAjaranAktif = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
        
        if ($siswaList->isEmpty() || !$tahunAjaranAktif) {
            $this->command->info('Tidak ada siswa atau tahun ajaran aktif. Seeder absensi dibatalkan.');
            return;
        }

        // Generate absensi untuk 30 hari terakhir
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        foreach ($siswaList as $siswa) {
            $currentDate = $startDate->copy();
            
            while ($currentDate <= $endDate) {
                // Skip weekend (Sabtu & Minggu)
                if ($currentDate->isWeekend()) {
                    $currentDate->addDay();
                    continue;
                }

                // Random status dengan probability
                $rand = rand(1, 100);
                if ($rand <= 85) {
                    $status = 'hadir'; // 85% hadir
                    $waktuMasuk = $currentDate->copy()->setTime(7, rand(0, 30), 0)->format('H:i:s');
                    $waktuKeluar = $currentDate->copy()->setTime(14, rand(0, 30), 0)->format('H:i:s');
                    $keterangan = null;
                } elseif ($rand <= 92) {
                    $status = 'izin'; // 7% izin
                    $waktuMasuk = null;
                    $waktuKeluar = null;
                    $keterangan = 'Acara keluarga';
                } elseif ($rand <= 97) {
                    $status = 'sakit'; 
                    $waktuMasuk = null;
                    $waktuKeluar = null;
                    $keterangan = 'Sakit demam';
                } else {
                    $status = 'alpha'; 
                    $waktuMasuk = null;
                    $waktuKeluar = null;
                    $keterangan = null;
                }

                Absensi::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $siswa->kelas_id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'tanggal' => $currentDate->format('Y-m-d'),
                    'waktu_masuk' => $waktuMasuk,
                    'waktu_keluar' => $waktuKeluar,
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'verified_by' => $status !== 'hadir' ? 1 : null, // Admin verifikasi izin/sakit/alpha
                    'verified_at' => $status !== 'hadir' ? $currentDate->copy()->addHours(2) : null,
                ]);

                $currentDate->addDay();
            }
        }

        $this->command->info('Absensi seeder berhasil dijalankan.');
    }
}
