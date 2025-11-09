<?php

echo "Testing Gemini API...\n";

$apiKey = 'AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM';
$model = 'gemini-2.5-flash';
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Jawab dengan singkat: Halo, apa kabar?']
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        echo "\n✅ SUCCESS! Gemini API is working!\n";
        echo "AI Response: " . $result['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "\n⚠️  Response structure:\n";
        print_r($result);
    }
} else {
    echo "\n❌ Error: $response\n";
}
