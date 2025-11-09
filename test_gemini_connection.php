<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "═══════════════════════════════════════════════════════\n";
echo "  🧪 TESTING GEMINI API CONNECTION\n";
echo "═══════════════════════════════════════════════════════\n\n";

// Check config
$apiKey = config('ai.gemini.api_key');
$model = config('ai.gemini.model');
$enabled = config('ai.companion.enabled');

echo "✓ API Key: " . substr($apiKey, 0, 20) . "...\n";
echo "✓ Model: $model\n";
echo "✓ AI Companion: " . ($enabled ? 'Enabled' : 'Disabled') . "\n";
echo "✓ Max Tokens: " . config('ai.companion.max_tokens') . "\n";
echo "✓ Temperature: " . config('ai.companion.temperature') . "\n\n";

// Test API connection
echo "Testing API connection...\n";

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Say "Hello, I am working!" in Indonesian']
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 100,
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ CURL Error: $error\n";
    exit(1);
}

echo "HTTP Status: $httpCode\n\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'];
        echo "✅ SUCCESS! Gemini API is working!\n\n";
        echo "AI Response:\n";
        echo "─────────────────────────────────────────────────────\n";
        echo $aiResponse . "\n";
        echo "─────────────────────────────────────────────────────\n\n";
        echo "🎉 All systems ready! AI Chatbot is functional!\n";
    } else {
        echo "⚠️  Response received but unexpected format:\n";
        echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "❌ API Error (HTTP $httpCode):\n";
    echo $response . "\n";
}

echo "\n═══════════════════════════════════════════════════════\n";
