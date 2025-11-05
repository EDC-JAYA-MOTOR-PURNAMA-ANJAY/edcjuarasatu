<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = config('ai.gemini.api_key');

echo "🔍 List Available Models...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

try {
    // Try v1beta
    $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key=$apiKey");
    
    if ($response->successful()) {
        echo "✅ v1beta Models:\n";
        $data = $response->json();
        foreach ($data['models'] as $model) {
            if (str_contains($model['name'], 'gemini')) {
                echo "  - " . $model['name'] . "\n";
                if (isset($model['supportedGenerationMethods'])) {
                    echo "    Methods: " . implode(', ', $model['supportedGenerationMethods']) . "\n";
                }
            }
        }
    } else {
        echo "❌ v1beta failed: " . $response->body() . "\n";
    }
    
    echo "\n";
    
    // Try v1
    $response2 = Http::get("https://generativelanguage.googleapis.com/v1/models?key=$apiKey");
    
    if ($response2->successful()) {
        echo "✅ v1 Models:\n";
        $data2 = $response2->json();
        foreach ($data2['models'] as $model) {
            if (str_contains($model['name'], 'gemini')) {
                echo "  - " . $model['name'] . "\n";
                if (isset($model['supportedGenerationMethods'])) {
                    echo "    Methods: " . implode(', ', $model['supportedGenerationMethods']) . "\n";
                }
            }
        }
    } else {
        echo "❌ v1 failed: " . $response2->body() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
