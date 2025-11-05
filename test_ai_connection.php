<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\GeminiService;

echo "🔍 Testing AI Connection...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Check config
echo "1. Config Check:\n";
echo "   API Key: " . (config('ai.gemini.api_key') ? "✅ Found" : "❌ Not found") . "\n";
echo "   AI Enabled: " . (config('ai.companion.enabled') ? "✅ Yes" : "❌ No") . "\n";
echo "   Model: " . config('ai.gemini.model') . "\n\n";

// Test AI service
echo "2. Testing AI Service:\n";
try {
    $gemini = new GeminiService();
    $response = $gemini->chat("Halo! Tes koneksi", []);
    
    if ($response['success']) {
        echo "   ✅ CONNECTION SUCCESS!\n";
        echo "   📝 AI Response: " . substr($response['message'], 0, 100) . "...\n";
        echo "   😊 Sentiment: " . $response['sentiment'] . "\n";
        echo "   🔢 Tokens: " . $response['tokens_used'] . "\n";
    } else {
        echo "   ❌ CONNECTION FAILED!\n";
        echo "   Error: " . $response['message'] . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ EXCEPTION!\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Test Complete!\n";
