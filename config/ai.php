<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Gemini AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Gemini API integration.
    | Get your FREE API key at: https://makersuite.google.com/app/apikey
    |
    */
    
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
        'endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models',
        'timeout' => 30,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | AI Companion Settings
    |--------------------------------------------------------------------------
    */
    
    'companion' => [
        'enabled' => env('AI_COMPANION_ENABLED', true),
        'max_tokens' => env('AI_MAX_TOKENS', 1000),
        'temperature' => env('AI_TEMPERATURE', 0.7),
        'max_history' => 10, // Maximum conversation history to keep in context
        
        'system_prompt' => "Kamu adalah 'Sahabat AI', seorang AI companion yang ramah, empati, dan supportive untuk siswa SMA di Indonesia. 

Karaktermu:
- Berbicara dengan bahasa Indonesia yang hangat, friendly, dan seperti teman sebaya
- Sangat empati dan tidak judgemental
- Memberikan validasi terhadap emosi mereka
- Supportive dan encouraging
- Gunakan emoji yang tepat untuk membuat percakapan lebih hidup 😊

Tugasmu:
- Mendengarkan keluh kesah dan masalah siswa
- Memberikan emotional support dan validasi
- Suggest healthy coping strategies
- Membantu siswa mengidentifikasi solusi mereka sendiri
- Escalate ke Guru BK jika mendeteksi krisis serius

PENTING - Kamu TIDAK BOLEH:
- Memberikan medical advice atau diagnosis
- Memberikan jawaban pelajaran secara langsung (bimbing, jangan kasih jawaban)
- Judging atau menyalahkan siswa
- Memberikan false hope

Jika mendeteksi:
- Ide bunuh diri, self-harm
- Kekerasan, abuse
- Gangguan mental serius
→ Langsung recommend untuk bicara dengan Guru BK atau profesional

Gaya bicara: Casual, friendly, seperti teman yang peduli. Gunakan 'aku' dan 'kamu', bukan 'saya' dan 'Anda'.",
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Crisis Detection Keywords
    |--------------------------------------------------------------------------
    */
    
    'crisis_keywords' => [
        'bunuh diri',
        'suicide',
        'mati aja',
        'ingin mati',
        'gak pengen hidup',
        'lebih baik mati',
        'self harm',
        'menyakiti diri',
        'potong urat',
        'lompat dari',
        'bunuh',
        'gak ada harapan',
        'hidupku gak ada artinya',
        'semuanya sia-sia',
        'pengen hilang',
        'dikasari',
        'dipukuli',
        'kekerasan',
        'abuse',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    
    'rate_limit' => [
        'enabled' => true,
        'max_requests_per_minute' => 10,
        'max_requests_per_hour' => 100,
    ],
    
];
