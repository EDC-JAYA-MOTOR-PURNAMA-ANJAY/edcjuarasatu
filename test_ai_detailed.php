<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

echo "🔍 Detailed API Test...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$apiKey = config('ai.gemini.api_key');
$model = 'gemini-2.5-flash';
$endpoint = config('ai.gemini.endpoint');

echo "API Key: " . substr($apiKey, 0, 20) . "...\n";
echo "Model: $model\n";
echo "Endpoint: $endpoint\n\n";

echo "Testing direct API call...\n";

try {
    $url = "$endpoint/$model:generateContent?key=$apiKey";
    
    $response = Http::timeout(30)->post($url, [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [['text' => 'Halo, tes koneksi!']]
            ]
        ]
    ]);
    
    echo "Status: " . $response->status() . "\n";
    
    if ($response->successful()) {
        echo "✅ SUCCESS!\n";
        $data = $response->json();
        echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "❌ FAILED!\n";
        echo "Response: " . $response->body() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
