<?php

/**
 * CREATE TEST USERS SCRIPT
 * Run: php create_test_users.php
 */

// Load Laravel
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "========================================\n";
echo " CREATING TEST USERS\n";
echo "========================================\n\n";

// Admin User
echo "[1/3] Creating Admin User...\n";
try {
    $admin = User::updateOrCreate(
        ['email' => 'admin@test.com'],
        [
            'nama' => 'Admin Test',
            'nis_nip' => 'ADM001',
            'password' => Hash::make('password123'),
            'peran' => 'admin',
        ]
    );
    echo "✓ Admin created!\n";
    echo "  Email: admin@test.com\n";
    echo "  Password: password123\n\n";
} catch (Exception $e) {
    echo "✗ Failed: " . $e->getMessage() . "\n\n";
}

// Guru BK User
echo "[2/3] Creating Guru BK User...\n";
try {
    $guru = User::updateOrCreate(
        ['email' => 'guru@test.com'],
        [
            'nama' => 'Guru BK Test',
            'nis_nip' => 'GRU001',
            'password' => Hash::make('password123'),
            'peran' => 'guru_bk',
        ]
    );
    echo "✓ Guru BK created!\n";
    echo "  Email: guru@test.com\n";
    echo "  Password: password123\n\n";
} catch (Exception $e) {
    echo "✗ Failed: " . $e->getMessage() . "\n\n";
}

// Student User
echo "[3/3] Creating Student User...\n";
try {
    $siswa = User::updateOrCreate(
        ['email' => 'siswa@test.com'],
        [
            'nama' => 'Siswa Test',
            'nis_nip' => '12345',
            'password' => Hash::make('password123'),
            'peran' => 'siswa',
        ]
    );
    echo "✓ Student created!\n";
    echo "  Email: siswa@test.com\n";
    echo "  Password: password123\n\n";
} catch (Exception $e) {
    echo "✗ Failed: " . $e->getMessage() . "\n\n";
}

echo "========================================\n";
echo " TEST USERS READY!\n";
echo "========================================\n\n";

echo "LOGIN CREDENTIALS:\n\n";
echo "1. ADMIN:\n";
echo "   Email: admin@test.com\n";
echo "   Password: password123\n\n";

echo "2. GURU BK:\n";
echo "   Email: guru@test.com\n";
echo "   Password: password123\n\n";

echo "3. SISWA:\n";
echo "   Email: siswa@test.com\n";
echo "   Password: password123\n\n";

echo "========================================\n";
echo "You can now login at: http://localhost:8000/login\n";
echo "========================================\n";
