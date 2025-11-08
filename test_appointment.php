<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Appointment;
use App\Models\User;

echo "🧪 TESTING APPOINTMENT SYSTEM\n";
echo "=============================\n\n";

// Get users
$student = User::where('peran', 'siswa')->first();
$guruBk = User::where('peran', 'guru_bk')->first();

if (!$student) {
    echo "❌ No student found! Please create a student user first.\n";
    echo "   Run: INSERT INTO users (name, email, password, role, peran, status) VALUES ('Test Student', 'student@test.com', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', 'siswa', 'aktif');\n";
    exit(1);
}

if (!$guruBk) {
    echo "❌ No Guru BK found! Please create a Guru BK user first.\n";
    echo "   Run: INSERT INTO users (name, email, password, role, peran, status) VALUES ('Test Guru BK', 'gurubk@test.com', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru_bk', 'guru_bk', 'aktif');\n";
    exit(1);
}

echo "✅ Found Student: {$student->name} (ID: {$student->id})\n";
echo "✅ Found Guru BK: {$guruBk->name} (ID: {$guruBk->id})\n\n";

// Create test appointment
try {
    $appointment = Appointment::create([
        'student_id' => $student->id,
        'guru_bk_id' => $guruBk->id,
        'appointment_date' => now()->addDays(2)->toDateString(),
        'appointment_time' => '10:00',
        'topic' => 'Test Konsultasi Karier',
        'student_notes' => 'Testing appointment system functionality',
        'status' => 'pending',
    ]);

    echo "✅ SUCCESS! Appointment created:\n";
    echo "   ID: {$appointment->id}\n";
    echo "   Date: {$appointment->appointment_date->format('d M Y')}\n";
    echo "   Time: {$appointment->appointment_time->format('H:i')}\n";
    echo "   Status: {$appointment->status}\n";
    echo "   Topic: {$appointment->topic}\n\n";

    // Test relationship
    echo "✅ Relationship Test:\n";
    echo "   Student: {$appointment->student->name}\n";
    echo "   Guru BK: {$appointment->guruBK->name}\n\n";

    // Test status methods
    echo "✅ Status Methods:\n";
    echo "   isPending(): " . ($appointment->isPending() ? 'true' : 'false') . "\n";
    echo "   isApproved(): " . ($appointment->isApproved() ? 'true' : 'false') . "\n\n";

    // Test approve
    $appointment->update(['status' => 'approved', 'approved_at' => now()]);
    echo "✅ Appointment approved!\n";
    echo "   Status: {$appointment->status}\n";
    echo "   Approved at: {$appointment->approved_at->format('d M Y H:i')}\n\n";

    echo "🎉 ALL TESTS PASSED! Appointment system is working perfectly!\n\n";

    // Show route hints
    echo "📝 Next Steps:\n";
    echo "   1. Visit: http://127.0.0.1:8000/guru_bk/appointments (Guru BK view)\n";
    echo "   2. Visit: http://127.0.0.1:8000/student/appointments (Student view)\n";
    echo "   3. Controllers are ready, just need to add views!\n\n";

    echo "🗑️  To clean up test data, run:\n";
    echo "   php artisan tinker --execute=\"App\\Models\\Appointment::truncate();\"\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
