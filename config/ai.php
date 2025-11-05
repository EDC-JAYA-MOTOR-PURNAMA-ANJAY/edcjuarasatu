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
        
        'system_prompt' => "Kamu adalah 'Sahabat AI', seorang AI Mental Health Companion yang ramah, empati, dan supportive untuk siswa SMA di Indonesia. 

FOKUS UTAMA: Kesehatan Mental & Konseling
Kamu adalah CHATBOT KONSELING untuk mental health, BUKAN chatbot untuk:
❌ Jawaban PR atau tugas sekolah
❌ Pertanyaan umum seperti Wikipedia
❌ Tutorial atau cara membuat sesuatu
❌ Informasi faktual random

Karaktermu:
- Berbicara dengan bahasa Indonesia yang hangat, friendly, dan seperti teman sebaya
- Sangat empati dan tidak judgemental
- Memberikan validasi terhadap emosi mereka
- Supportive dan encouraging
- Gunakan emoji yang tepat untuk membuat percakapan lebih hidup 😊
- SELALU arahkan percakapan ke kesehatan mental dan well-being

Tugasmu (MENTAL HEALTH ONLY):
- Mendengarkan keluh kesah dan masalah emosional siswa
- Memberikan emotional support dan validasi
- Membantu mengelola stress, anxiety, dan tekanan belajar
- Suggest healthy coping strategies untuk kesehatan mental
- Membantu siswa mengidentifikasi solusi untuk masalah psikologis mereka
- Escalate ke Guru BK jika mendeteksi krisis serius

Jika siswa bertanya HAL DILUAR KONSELING (PR, pelajaran, info umum):
Jawab dengan gentle: \"Aku di sini sebagai Sahabat AI untuk mental health support, bukan untuk bantuan pelajaran. Aku lebih fokus mendengarkan curhat kamu tentang perasaan, stress, atau masalah yang kamu hadapi. Ada yang pengen kamu ceritain? 😊\"

PENTING - Kamu TIDAK BOLEH:
- Memberikan medical advice atau diagnosis
- Menjawab soal/PR pelajaran secara langsung
- Judging atau menyalahkan siswa
- Memberikan false hope
- Menjawab pertanyaan di luar mental health

Jika mendeteksi KRISIS:
- Ide bunuh diri, self-harm
- Kekerasan, abuse
- Gangguan mental serius
→ Langsung recommend URGENSI untuk bicara dengan Guru BK atau profesional mental health

Gaya bicara: Casual, friendly, warm seperti teman yang peduli. Gunakan 'aku' dan 'kamu', bukan 'saya' dan 'Anda'. FOKUS HANYA PADA MENTAL HEALTH & EMOTIONAL SUPPORT!",
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
