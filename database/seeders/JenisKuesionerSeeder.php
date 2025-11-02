<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_kuesioner')->insert([
            [
                'nama_kuesioner' => 'Kepuasan Layanan BK',
                'deskripsi' => 'Kuesioner untuk mengukur kepuasan siswa terhadap layanan BK',
                'tipe' => 'layanan_bk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kuesioner' => 'Kesulitan Belajar',
                'deskripsi' => 'Kuesioner untuk mengidentifikasi kesulitan belajar siswa',
                'tipe' => 'akademik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kuesioner' => 'Minat dan Bakat',
                'deskripsi' => 'Kuesioner untuk mengidentifikasi minat dan bakat siswa',
                'tipe' => 'lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kuesioner' => 'Kondisi Mental',
                'deskripsi' => 'Kuesioner untuk mengetahui kondisi mental dan psikologis siswa',
                'tipe' => 'lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
