<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jurusan' => 'TKJ',
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jurusan' => 'MM',
                'nama_jurusan' => 'Multimedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jurusan' => 'TJKT',
                'nama_jurusan' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jurusan' => 'DKV',
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
