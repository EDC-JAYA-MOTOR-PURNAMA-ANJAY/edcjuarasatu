<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaranAktif = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
        $jurusanRPL = DB::table('jurusan')->where('kode_jurusan', 'RPL')->first();
        $jurusanTKJ = DB::table('jurusan')->where('kode_jurusan', 'TKJ')->first();
        $jurusanMM = DB::table('jurusan')->where('kode_jurusan', 'MM')->first();

        $kelas = [];

        // Kelas RPL
        if ($jurusanRPL && $tahunAjaranAktif) {
            $kelas[] = [
                'nama_kelas' => 'X RPL 1',
                'jurusan_id' => $jurusanRPL->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $kelas[] = [
                'nama_kelas' => 'X RPL 2',
                'jurusan_id' => $jurusanRPL->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $kelas[] = [
                'nama_kelas' => 'XI RPL 1',
                'jurusan_id' => $jurusanRPL->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $kelas[] = [
                'nama_kelas' => 'XII RPL 1',
                'jurusan_id' => $jurusanRPL->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Kelas TKJ
        if ($jurusanTKJ && $tahunAjaranAktif) {
            $kelas[] = [
                'nama_kelas' => 'X TKJ 1',
                'jurusan_id' => $jurusanTKJ->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $kelas[] = [
                'nama_kelas' => 'XI TKJ 1',
                'jurusan_id' => $jurusanTKJ->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Kelas MM
        if ($jurusanMM && $tahunAjaranAktif) {
            $kelas[] = [
                'nama_kelas' => 'X MM 1',
                'jurusan_id' => $jurusanMM->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($kelas)) {
            DB::table('kelas')->insert($kelas);
        }
    }
}
