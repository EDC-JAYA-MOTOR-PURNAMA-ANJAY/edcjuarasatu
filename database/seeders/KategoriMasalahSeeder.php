<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMasalahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_masalah')->insert([
            [
                'nama_kategori' => 'Akademik',
                'deskripsi' => 'Masalah terkait pembelajaran dan prestasi akademik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sosial',
                'deskripsi' => 'Masalah hubungan dengan teman dan lingkungan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Pribadi',
                'deskripsi' => 'Masalah perkembangan diri dan karakter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Karier',
                'deskripsi' => 'Masalah perencanaan masa depan dan karier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Keluarga',
                'deskripsi' => 'Masalah terkait hubungan keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
