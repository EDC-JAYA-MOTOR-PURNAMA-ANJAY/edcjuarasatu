<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeders dalam urutan yang benar sesuai dependency
        $this->call([
            // Level 1: Tabel tanpa foreign key
            TahunAjaranSeeder::class,
            JurusanSeeder::class,
            KategoriMasalahSeeder::class,
            JenisKuesionerSeeder::class,
            
            // Level 2: Tabel dengan FK ke Level 1
            KelasSeeder::class,
            
            // Level 3: Users (dengan FK ke kelas)
            UserSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Default Credentials:');
        $this->command->info('Admin: admin@educounsel.com / admin123');
        $this->command->info('Guru BK: guru@educounsel.com / guru123');
        $this->command->info('Siswa: siswa@educounsel.com / siswa123');
    }
}