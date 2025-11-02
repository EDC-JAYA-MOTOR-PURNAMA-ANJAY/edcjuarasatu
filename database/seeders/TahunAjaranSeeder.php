<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tahun_ajaran')->insert([
            [
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2023/2024',
                'status' => 'non-aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2022/2023',
                'status' => 'non-aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
