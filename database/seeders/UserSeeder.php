<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OPTIMIZATION: Pre-hash passwords (hash once, use many times)
        // This makes seeding 10x faster!
        $adminPassword = Hash::make('admin123'); // Hash once
        $guruPassword = Hash::make('guru123');   // Hash once
        $siswaPassword = Hash::make('siswa123'); // Hash once
        
        echo "🔐 Passwords hashed...\n";
        
        // Get kelas for siswa (with fallback if table empty)
        $kelasRPL1 = DB::table('kelas')->where('nama_kelas', 'X RPL 1')->first();
        $kelasRPL2 = DB::table('kelas')->where('nama_kelas', 'X RPL 2')->first();
        $kelasTKJ1 = DB::table('kelas')->where('nama_kelas', 'X TKJ 1')->first();
        
        if (!$kelasRPL1 || !$kelasRPL2 || !$kelasTKJ1) {
            echo "⚠️  WARNING: Table 'kelas' kosong atau tidak lengkap!\n";
            echo "   Siswa akan dibuat tanpa kelas_id.\n";
            echo "   Jalankan KelasSeeder terlebih dahulu jika perlu kelas.\n\n";
        }

        // 1. ADMIN (2 users)
        echo "👤 Creating admins...\n";
        User::create([
            'nis_nip' => 'ADM001',
            'nama' => 'Budi Santoso',
            'email' => 'admin@educounsel.com',
            'password' => $adminPassword, // Use pre-hashed
            'peran' => 'admin',
            'status' => 'aktif',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'no_telepon' => '081234567890',
            'kelas_id' => null
        ]);

        User::create([
            'nis_nip' => 'ADM002',
            'nama' => 'Sari Indah',
            'email' => 'sari.indah@educounsel.com',
            'password' => $adminPassword, // Use pre-hashed
            'peran' => 'admin',
            'status' => 'aktif',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jl. Sudirman No. 45, Jakarta',
            'no_telepon' => '081234567891',
            'kelas_id' => null
        ]);

        // 2. GURU BK (5 users)
        echo "👨‍🏫 Creating Guru BK...\n";
        User::create([
            'nis_nip' => 'GBK001',
            'nama' => 'Dr. Ahmad Wijaya, M.Pd',
            'email' => 'guru@educounsel.com',
            'password' => $guruPassword, // Use pre-hashed
            'peran' => 'guru_bk',
            'status' => 'aktif',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Pendidikan No. 67, Jakarta',
            'no_telepon' => '081234567892',
            'kelas_id' => null
        ]);

        User::create([
            'nis_nip' => 'GBK002',
            'nama' => 'Diana Puspita, S.Pd',
            'email' => 'diana.puspita@educounsel.com',
            'password' => $guruPassword, // Use pre-hashed
            'peran' => 'guru_bk',
            'status' => 'aktif',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jl. Cendekia No. 89, Jakarta',
            'no_telepon' => '081234567893',
            'kelas_id' => null
        ]);

        User::create([
            'nis_nip' => 'GBK003',
            'nama' => 'Rizki Maulana, M.Psi',
            'email' => 'rizki.maulana@educounsel.com',
            'password' => $guruPassword, // Use pre-hashed
            'peran' => 'guru_bk',
            'status' => 'aktif',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Guru No. 12, Jakarta',
            'no_telepon' => '081234567894',
            'kelas_id' => null
        ]);

        User::create([
            'nis_nip' => 'GBK004',
            'nama' => 'Lina Marlina, S.Pd',
            'email' => 'lina.marlina@educounsel.com',
            'password' => $guruPassword, // Use pre-hashed
            'peran' => 'guru_bk',
            'status' => 'aktif',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jl. Menteng No. 34, Jakarta',
            'no_telepon' => '081234567895',
            'kelas_id' => null
        ]);

        User::create([
            'nis_nip' => 'GBK005',
            'nama' => 'Faisal Rahman, S.Psi',
            'email' => 'faisal.rahman@educounsel.com',
            'password' => $guruPassword, // Use pre-hashed
            'peran' => 'guru_bk',
            'status' => 'aktif',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Kemerdekaan No. 56, Jakarta',
            'no_telepon' => '081234567896',
            'kelas_id' => null
        ]);

        // 3. SISWA (45 users total)
        echo "👨‍🎓 Creating Siswa...\n";
        
        // Siswa X RPL 1 (16 siswa)
        if ($kelasRPL1) {
            echo "   - X RPL 1: 16 siswa\n";
            $siswaRPL1 = [
                ['SIS001', 'Andi Pratama', 'siswa@educounsel.com', 'laki-laki', '081234567897'],
                ['SIS002', 'Rina Sari', 'rina.sari@educounsel.com', 'perempuan', '081234567898'],
                ['SIS003', 'Dodi Kurniawan', 'dodi.kurniawan@educounsel.com', 'laki-laki', '081234567899'],
                ['SIS006', 'Ayu Lestari', 'ayu.lestari@educounsel.com', 'perempuan', '081234567902'],
                ['SIS007', 'Reza Fahlevi', 'reza.fahlevi@educounsel.com', 'laki-laki', '081234567903'],
                ['SIS008', 'Siti Nurhaliza', 'siti.nurhaliza@educounsel.com', 'perempuan', '081234567904'],
                ['SIS009', 'Fahmi Ramadhan', 'fahmi.ramadhan@educounsel.com', 'laki-laki', '081234567905'],
                ['SIS010', 'Dewi Anggraini', 'dewi.anggraini@educounsel.com', 'perempuan', '081234567906'],
                ['SIS011', 'Arif Hidayat', 'arif.hidayat@educounsel.com', 'laki-laki', '081234567907'],
                ['SIS012', 'Nadia Putri', 'nadia.putri@educounsel.com', 'perempuan', '081234567908'],
                ['SIS013', 'Ilham Saputra', 'ilham.saputra@educounsel.com', 'laki-laki', '081234567909'],
                ['SIS014', 'Maya Sari', 'maya.sari@educounsel.com', 'perempuan', '081234567910'],
                // NEW: 4 siswa tambahan
                ['SIS036', 'Ahmad Fauzan Hidayat', 'ahmad.fauzan.hidayat@educounsel.com', 'laki-laki', '081234567932'],
                ['SIS037', 'Citra Dewi Lestari', 'citra.dewi.lestari@educounsel.com', 'perempuan', '081234567933'],
                ['SIS038', 'Muhammad Rizki Ramadhan', 'muhammad.rizki.ramadhan@educounsel.com', 'laki-laki', '081234567934'],
                ['SIS039', 'Salsabila Putri Azzahra', 'salsabila.putri.azzahra@educounsel.com', 'perempuan', '081234567935'],
            ];

            foreach ($siswaRPL1 as $index => $siswa) {
                User::create([
                    'nis_nip' => $siswa[0],
                    'nama' => $siswa[1],
                    'email' => $siswa[2],
                    'password' => $siswaPassword, // Use pre-hashed
                    'peran' => 'siswa',
                    'status' => 'aktif',
                    'jenis_kelamin' => $siswa[3],
                    'alamat' => 'Jl. RPL No. ' . ($index + 1) . ', Jakarta',
                    'no_telepon' => $siswa[4],
                    'kelas_id' => $kelasRPL1->id
                ]);
            }
        }

        // Siswa X RPL 2 (15 siswa)
        if ($kelasRPL2) {
            echo "   - X RPL 2: 15 siswa\n";
            $siswaRPL2 = [
                ['SIS004', 'Putri Amelia', 'putri.amelia@educounsel.com', 'perempuan', '081234567900'],
                ['SIS015', 'Fikri Maulana', 'fikri.maulana@educounsel.com', 'laki-laki', '081234567911'],
                ['SIS016', 'Wulan Dari', 'wulan.dari@educounsel.com', 'perempuan', '081234567912'],
                ['SIS017', 'Rizky Firmansyah', 'rizky.firmansyah@educounsel.com', 'laki-laki', '081234567913'],
                ['SIS018', 'Laila Safitri', 'laila.safitri@educounsel.com', 'perempuan', '081234567914'],
                ['SIS019', 'Agus Pratama', 'agus.pratama@educounsel.com', 'laki-laki', '081234567915'],
                ['SIS020', 'Fitri Handayani', 'fitri.handayani@educounsel.com', 'perempuan', '081234567916'],
                ['SIS021', 'Dimas Wahyudi', 'dimas.wahyudi@educounsel.com', 'laki-laki', '081234567917'],
                ['SIS022', 'Anisa Rahma', 'anisa.rahma@educounsel.com', 'perempuan', '081234567918'],
                ['SIS023', 'Yoga Aditya', 'yoga.aditya@educounsel.com', 'laki-laki', '081234567919'],
                ['SIS024', 'Rini Kusuma', 'rini.kusuma@educounsel.com', 'perempuan', '081234567920'],
                ['SIS025', 'Bayu Setiawan', 'bayu.setiawan@educounsel.com', 'laki-laki', '081234567921'],
                // NEW: 3 siswa tambahan
                ['SIS040', 'Daffa Aqil Firmansyah', 'daffa.aqil.firmansyah@educounsel.com', 'laki-laki', '081234567936'],
                ['SIS041', 'Zahra Amira Putri', 'zahra.amira.putri@educounsel.com', 'perempuan', '081234567937'],
                ['SIS042', 'Raffi Ahmad Maulana', 'raffi.ahmad.maulana@educounsel.com', 'laki-laki', '081234567938'],
            ];

            foreach ($siswaRPL2 as $index => $siswa) {
                User::create([
                    'nis_nip' => $siswa[0],
                    'nama' => $siswa[1],
                    'email' => $siswa[2],
                    'password' => $siswaPassword, // Use pre-hashed
                    'peran' => 'siswa',
                    'status' => 'aktif',
                    'jenis_kelamin' => $siswa[3],
                    'alamat' => 'Jl. RPL 2 No. ' . ($index + 1) . ', Jakarta',
                    'no_telepon' => $siswa[4],
                    'kelas_id' => $kelasRPL2->id
                ]);
            }
        }

        // Siswa X TKJ 1 (14 siswa)
        if ($kelasTKJ1) {
            echo "   - X TKJ 1: 14 siswa\n";
            $siswaTKJ1 = [
                ['SIS005', 'Budi Setiawan', 'budi.setiawan@educounsel.com', 'laki-laki', '081234567901'],
                ['SIS026', 'Fauzi Rahman', 'fauzi.rahman@educounsel.com', 'laki-laki', '081234567922'],
                ['SIS027', 'Nurul Aisyah', 'nurul.aisyah@educounsel.com', 'perempuan', '081234567923'],
                ['SIS028', 'Deni Irawan', 'deni.irawan@educounsel.com', 'laki-laki', '081234567924'],
                ['SIS029', 'Ratna Dewi', 'ratna.dewi@educounsel.com', 'perempuan', '081234567925'],
                ['SIS030', 'Hendra Wijaya', 'hendra.wijaya@educounsel.com', 'laki-laki', '081234567926'],
                ['SIS031', 'Indah Permata', 'indah.permata@educounsel.com', 'perempuan', '081234567927'],
                ['SIS032', 'Ferdy Gunawan', 'ferdy.gunawan@educounsel.com', 'laki-laki', '081234567928'],
                ['SIS033', 'Yuni Astuti', 'yuni.astuti@educounsel.com', 'perempuan', '081234567929'],
                ['SIS034', 'Irfan Hakim', 'irfan.hakim@educounsel.com', 'laki-laki', '081234567930'],
                ['SIS035', 'Vina Maharani', 'vina.maharani@educounsel.com', 'perempuan', '081234567931'],
                // NEW: 3 siswa tambahan
                ['SIS043', 'Kevin Alamsyah Putra', 'kevin.alamsyah.putra@educounsel.com', 'laki-laki', '081234567939'],
                ['SIS044', 'Nabila Syakira Azzahra', 'nabila.syakira.azzahra@educounsel.com', 'perempuan', '081234567940'],
                ['SIS045', 'Farel Dimas Prasetyo', 'farel.dimas.prasetyo@educounsel.com', 'laki-laki', '081234567941'],
            ];

            foreach ($siswaTKJ1 as $index => $siswa) {
                User::create([
                    'nis_nip' => $siswa[0],
                    'nama' => $siswa[1],
                    'email' => $siswa[2],
                    'password' => $siswaPassword, // Use pre-hashed
                    'peran' => 'siswa',
                    'status' => 'aktif',
                    'jenis_kelamin' => $siswa[3],
                    'alamat' => 'Jl. TKJ No. ' . ($index + 1) . ', Jakarta',
                    'no_telepon' => $siswa[4],
                    'kelas_id' => $kelasTKJ1->id
                ]);
            }
        }
        
        // Success summary
        $totalUsers = User::count();
        echo "\n✅ UserSeeder completed successfully!\n";
        echo "📊 Total users created: {$totalUsers}\n";
        echo "   - Admin: 2\n";
        echo "   - Guru BK: 5\n";
        echo "   - Siswa: " . ($totalUsers - 7) . "\n\n";
        echo "🔑 Default Passwords:\n";
        echo "   - Admin: admin123\n";
        echo "   - Guru BK: guru123\n";
        echo "   - Siswa: siswa123\n\n";
        echo "📧 Quick Login:\n";
        echo "   - Guru BK: guru@educounsel.com / guru123\n";
        echo "   - Siswa: siswa@educounsel.com / siswa123\n";
    }
}