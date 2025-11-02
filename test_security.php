<?php
/**
 * Security Testing Script
 * Run: php test_security.php
 */

echo "====================================\n";
echo "🔒 SECURITY TESTING SCRIPT\n";
echo "====================================\n\n";

// Test 1: Rate Limiting
echo "📋 Test 1: Rate Limiting\n";
echo "Testing brute force protection...\n";
echo "Open your browser and:\n";
echo "1. Go to: http://localhost/login\n";
echo "2. Try login 6 times with wrong password\n";
echo "3. After 5 attempts, you should see:\n";
echo "   'Terlalu banyak percobaan login. Silakan coba lagi dalam X detik.'\n";
echo "Status: ✅ Manual testing required\n\n";

// Test 2: Password Policy
echo "📋 Test 2: Strong Password Policy\n";
echo "Password requirements:\n";
echo "- Minimum 8 characters\n";
echo "- Must contain lowercase (a-z)\n";
echo "- Must contain uppercase (A-Z)\n";
echo "- Must contain digit (0-9)\n";
echo "- Must contain special char (@\$!%*#?&)\n\n";

$testPasswords = [
    'password' => '❌ Too weak',
    'Password' => '❌ No digit, no special char',
    'password123' => '❌ No uppercase, no special char',
    'Password123' => '❌ No special char',
    'Pass@123' => '✅ Valid (8 chars, all requirements)',
    'SecureP@ss123' => '✅ Valid (strong)',
];

echo "Test passwords:\n";
foreach ($testPasswords as $password => $result) {
    echo "  $password => $result\n";
}
echo "\nTo test: Try creating a user with these passwords\n";
echo "Status: ✅ Can be tested via admin panel\n\n";

// Test 3: Security Headers
echo "📋 Test 3: Security Headers\n";
echo "Run this command to check headers:\n";
echo "curl -I http://localhost/login\n\n";
echo "Expected headers:\n";
echo "- X-Content-Type-Options: nosniff\n";
echo "- X-Frame-Options: SAMEORIGIN\n";
echo "- X-XSS-Protection: 1; mode=block\n";
echo "- Content-Security-Policy: (configured)\n";
echo "Status: ⏳ Requires curl command\n\n";

// Test 4: Logging
echo "📋 Test 4: Audit Logging\n";
echo "Log file location: storage/logs/laravel.log\n";
echo "To check logs, run:\n";
echo "  tail -50 storage/logs/laravel.log\n";
echo "Or on Windows:\n";
echo "  Get-Content storage\\logs\\laravel.log -Tail 50\n\n";
echo "Actions to test:\n";
echo "1. Login (successful) - should log user details\n";
echo "2. Login (failed) - should log attempt\n";
echo "3. Create user - should log admin and new user\n";
echo "4. Update user - should log changes\n";
echo "5. Delete user - should log deletion\n";
echo "Status: ✅ Check log file after actions\n\n";

// Test 5: Session Security
echo "📋 Test 5: Session Security\n";
echo "Test steps:\n";
echo "1. Login from Browser A\n";
echo "2. Copy session cookie\n";
echo "3. Try using session from Browser B\n";
echo "4. Session should be encrypted and HTTPOnly\n";
echo "Status: ⏳ Manual browser testing\n\n";

echo "====================================\n";
echo "📝 QUICK TEST CHECKLIST\n";
echo "====================================\n";
echo "[ ] Test rate limiting (6 failed logins)\n";
echo "[ ] Test password policy (create user with weak password)\n";
echo "[ ] Check security headers (curl -I)\n";
echo "[ ] Verify logging (check laravel.log)\n";
echo "[ ] Test session security\n\n";

echo "====================================\n";
echo "🎯 TESTING COMPLETE!\n";
echo "====================================\n";
