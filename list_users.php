<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== EXISTING USERS IN DATABASE ===\n\n";

$guruBkUsers = User::where('peran', 'guru_bk')->get(['nama', 'email', 'peran']);
$siswaUsers = User::where('peran', 'siswa')->limit(5)->get();

echo "👨‍🏫 GURU BK (" . $guruBkUsers->count() . " users):\n";
if ($guruBkUsers->count() > 0) {
    foreach ($guruBkUsers as $user) {
        echo "   ✅ " . $user->nama . " (" . $user->email . ")\n";
    }
} else {
    echo "   ❌ No Guru BK found!\n";
}

echo "\n👨‍🎓 SISWA (" . User::where('peran', 'siswa')->count() . " total, showing 5):\n";
if ($siswaUsers->count() > 0) {
    foreach ($siswaUsers as $user) {
        $kelas = $user->kelas ?? 'N/A';
        echo "   ✅ " . $user->nama . " - Kelas " . $kelas . " (" . $user->email . ")\n";
    }
} else {
    echo "   ❌ No Siswa found!\n";
}

echo "\n📊 TOTAL USERS: " . User::count() . "\n\n";

if ($guruBkUsers->count() > 0 && $siswaUsers->count() > 0) {
    echo "✅ YOU CAN USE EXISTING ACCOUNTS FOR TESTING!\n\n";
    echo "📝 TESTING INSTRUCTIONS:\n";
    echo "1. Login as Guru BK: Use any email above with your password\n";
    echo "2. Login as Siswa: Use any email above with your password\n";
    echo "3. If you don't know password, you can:\n";
    echo "   - Reset via 'Forgot Password'\n";
    echo "   - Or update in database\n";
    echo "   - Or create new test users\n\n";
    
    echo "🔐 TO UPDATE PASSWORD (if needed):\n";
    echo "php artisan tinker\n";
    echo "\$user = User::where('email', 'your@email.com')->first();\n";
    echo "\$user->password = bcrypt('newpassword');\n";
    echo "\$user->save();\n";
} else {
    echo "⚠️ YOU NEED TO CREATE TEST USERS!\n";
    echo "See TESTING_SIMPLE_GUIDE.md for SQL commands\n";
}
