<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    /**
     * Seed 100 siswa for testing
     */
    public function run(): void
    {
        echo "🎓 Creating 100 Siswa...\n";
        
        // Pre-hash password once (optimization)
        $password = Hash::make('siswa123');
        
        // Indonesian names for realistic data
        $namaDepan = [
            'Andi', 'Budi', 'Citra', 'Dian', 'Eko', 'Fitri', 'Gita', 'Hadi',
            'Indra', 'Joko', 'Kartika', 'Lina', 'Made', 'Nita', 'Omar', 'Putri',
            'Rama', 'Sari', 'Tono', 'Udin', 'Vina', 'Wati', 'Yoga', 'Zahra',
            'Agus', 'Bayu', 'Dewi', 'Fadil', 'Hana', 'Iman', 'Krisna', 'Maya',
            'Nia', 'Putra', 'Ratna', 'Sinta', 'Tina', 'Wahyu', 'Yuni', 'Zaki'
        ];
        
        $namaBelakang = [
            'Pratama', 'Kusuma', 'Wijaya', 'Santoso', 'Setiawan', 'Rahayu',
            'Permata', 'Saputra', 'Lestari', 'Hidayat', 'Suharto', 'Anggraini',
            'Firmansyah', 'Handayani', 'Maulana', 'Safitri', 'Rahman', 'Marlina',
            'Kurniawan', 'Puspita', 'Ramadhan', 'Nurhaliza', 'Aditya', 'Maharani',
            'Gunawan', 'Astuti', 'Nugroho', 'Kartini', 'Irawan', 'Dewanti'
        ];
        
        $jenisKelamin = ['laki-laki', 'perempuan'];
        
        // Create 100 siswa (without kelas_id - table kelas may not exist)
        for ($i = 1; $i <= 100; $i++) {
            $namaLengkap = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            $nis = sprintf('2024%04d', $i); // NIS: 20240001 - 20240100
            $email = 'siswa' . $i . '@educounsel.com';
            $jk = $jenisKelamin[array_rand($jenisKelamin)];
            
            User::create([
                'nis_nip' => $nis,
                'nama' => $namaLengkap,
                'email' => $email,
                'password' => $password, // Pre-hashed
                'peran' => 'siswa',
                'status' => 'aktif',
                'jenis_kelamin' => $jk,
                'kelas_id' => null, // No kelas assigned
                'alamat' => 'Jl. Pendidikan No. ' . $i . ', Jakarta',
                'no_telepon' => '08' . str_pad($i, 10, '0', STR_PAD_LEFT),
            ]);
            
            // Progress indicator
            if ($i % 10 == 0) {
                echo "   ✅ {$i}/100 siswa created...\n";
            }
        }
        
        echo "\n✅ 100 Siswa berhasil dibuat!\n\n";
        
        // Summary
        $totalSiswa = User::where('peran', 'siswa')->count();
        $lakiLaki = User::where('peran', 'siswa')->where('jenis_kelamin', 'laki-laki')->count();
        $perempuan = User::where('peran', 'siswa')->where('jenis_kelamin', 'perempuan')->count();
        
        echo "📊 SUMMARY:\n";
        echo "   Total Siswa: {$totalSiswa}\n";
        echo "   Laki-laki: {$lakiLaki}\n";
        echo "   Perempuan: {$perempuan}\n\n";
        
        echo "🔑 LOGIN TEST ACCOUNTS:\n";
        echo "   Email: siswa1@educounsel.com / siswa123\n";
        echo "   Email: siswa50@educounsel.com / siswa123\n";
        echo "   Email: siswa100@educounsel.com / siswa123\n\n";
        
        echo "💡 ALL SISWA USE PASSWORD: siswa123\n";
    }
}
