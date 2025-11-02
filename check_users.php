<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "===========================================\n";
echo "DAFTAR USER DI DATABASE\n";
echo "===========================================\n\n";

$users = User::all();

if ($users->count() === 0) {
    echo "❌ TIDAK ADA USER! Silakan jalankan seeder.\n\n";
    echo "Jalankan command:\n";
    echo "php artisan db:seed\n\n";
} else {
    echo "Total Users: " . $users->count() . "\n\n";
    
    foreach ($users as $user) {
        echo "-------------------------------------------\n";
        echo "Role     : " . strtoupper($user->peran) . "\n";
        echo "Nama     : " . $user->nama . "\n";
        echo "Email    : " . $user->email . "\n";
        echo "Status   : " . $user->status . "\n";
        echo "NIS/NIP  : " . $user->nis_nip . "\n";
        if ($user->kelas) {
            echo "Kelas    : " . $user->kelas->nama_kelas . "\n";
        }
        echo "\n";
    }
    
    echo "===========================================\n";
    echo "LOGIN CREDENTIALS (Password untuk semua):\n";
    echo "===========================================\n\n";
    
    echo "🔐 ADMIN:\n";
    echo "   Email: admin@educounsel.com\n";
    echo "   Password: admin123\n\n";
    
    echo "👨‍🏫 GURU BK:\n";
    echo "   Email: guru@educounsel.com\n";
    echo "   Password: guru123\n\n";
    
    echo "👨‍🎓 SISWA:\n";
    echo "   Email: siswa@educounsel.com\n";
    echo "   Password: siswa123\n\n";
}
