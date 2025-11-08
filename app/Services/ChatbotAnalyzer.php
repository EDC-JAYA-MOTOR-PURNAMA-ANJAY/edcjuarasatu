<?php

namespace App\Services;

class ChatbotAnalyzer
{
    /**
     * Sensitive keywords categorized by severity
     */
    private const CRITICAL_KEYWORDS = [
        'bunuh diri', 'suicide', 'mengakhiri hidup', 'ingin mati',
        'menyakiti diri', 'self harm', 'potong nadi', 'lompat dari',
        'tidak ingin hidup', 'lebih baik mati', 'akhiri saja'
    ];

    private const HIGH_KEYWORDS = [
        'depresi berat', 'sangat tertekan', 'putus asa',
        'tidak ada harapan', 'tidak berguna', 'sangat sedih',
        'ingin menghilang', 'tidak kuat lagi', 'cape hidup',
        'dibully', 'di-bully', 'dipukul', 'kekerasan', 'pelecehan'
    ];

    private const MEDIUM_KEYWORDS = [
        'stress', 'cemas', 'takut', 'khawatir', 'gelisah',
        'kesulitan tidur', 'insomnia', 'mimpi buruk',
        'minder', 'tidak percaya diri', 'sendiri', 'kesepian',
        'masalah keluarga', 'orang tua bertengkar', 'broken home'
    ];

    /**
     * Topics for categorization
     */
    private const TOPIC_KEYWORDS = [
        'akademik' => ['nilai', 'ujian', 'pr', 'tugas', 'belajar', 'pelajaran', 'sekolah', 'guru'],
        'keluarga' => ['orang tua', 'ayah', 'ibu', 'kakak', 'adik', 'keluarga', 'rumah'],
        'pertemanan' => ['teman', 'sahabat', 'bertengkar', 'dikucilkan', 'sendiri'],
        'percintaan' => ['pacar', 'cinta', 'putus', 'patah hati', 'gebetan', 'nembak'],
        'karir' => ['cita-cita', 'kuliah', 'jurusan', 'masa depan', 'pekerjaan'],
        'kesehatan_mental' => ['depresi', 'cemas', 'stress', 'takut', 'sedih'],
        'bullying' => ['dibully', 'diejek', 'diintimidasi', 'dikucilkan']
    ];

    /**
     * Analyze conversation for sensitive content
     */
    public function analyzeSensitiveContent(array $messages): array
    {
        $fullText = $this->extractMessagesText($messages);
        $detectedKeywords = [];
        $alertLevel = 'none';

        // Check CRITICAL keywords
        foreach (self::CRITICAL_KEYWORDS as $keyword) {
            if ($this->containsKeyword($fullText, $keyword)) {
                $detectedKeywords[] = ['keyword' => $keyword, 'severity' => 'critical'];
                $alertLevel = 'critical';
            }
        }

        // If not critical, check HIGH keywords
        if ($alertLevel !== 'critical') {
            foreach (self::HIGH_KEYWORDS as $keyword) {
                if ($this->containsKeyword($fullText, $keyword)) {
                    $detectedKeywords[] = ['keyword' => $keyword, 'severity' => 'high'];
                    $alertLevel = 'high';
                }
            }
        }

        // If not high, check MEDIUM keywords
        if ($alertLevel === 'none') {
            foreach (self::MEDIUM_KEYWORDS as $keyword) {
                if ($this->containsKeyword($fullText, $keyword)) {
                    $detectedKeywords[] = ['keyword' => $keyword, 'severity' => 'medium'];
                    if ($alertLevel === 'none') {
                        $alertLevel = 'medium';
                    }
                }
            }
        }

        return [
            'has_sensitive_content' => count($detectedKeywords) > 0,
            'detected_keywords' => $detectedKeywords,
            'alert_level' => $alertLevel
        ];
    }

    /**
     * Detect topics in conversation
     */
    public function detectTopics(array $messages): array
    {
        $fullText = $this->extractMessagesText($messages);
        $topics = [];

        foreach (self::TOPIC_KEYWORDS as $topic => $keywords) {
            foreach ($keywords as $keyword) {
                if ($this->containsKeyword($fullText, $keyword)) {
                    if (!in_array($topic, $topics)) {
                        $topics[] = $topic;
                    }
                    break; // Found this topic, move to next
                }
            }
        }

        return $topics;
    }

    /**
     * Analyze sentiment (simple version)
     */
    public function analyzeSentiment(array $messages): string
    {
        $fullText = $this->extractMessagesText($messages);

        $negativeWords = ['sedih', 'gagal', 'buruk', 'takut', 'cemas', 'stress', 'susah', 'sulit', 'tidak bisa'];
        $positiveWords = ['senang', 'bahagia', 'sukses', 'bagus', 'hebat', 'lega', 'optimis', 'semangat'];

        $negativeCount = 0;
        $positiveCount = 0;

        foreach ($negativeWords as $word) {
            $negativeCount += substr_count(strtolower($fullText), $word);
        }

        foreach ($positiveWords as $word) {
            $positiveCount += substr_count(strtolower($fullText), $word);
        }

        if ($negativeCount > $positiveCount * 1.5) {
            return 'negative';
        } elseif ($positiveCount > $negativeCount * 1.5) {
            return 'positive';
        }

        return 'neutral';
    }

    /**
     * Generate summary for Guru BK
     */
    public function generateSummary(array $messages, array $analysis): string
    {
        $topics = $analysis['topics'] ?? [];
        $sentiment = $analysis['sentiment'] ?? 'neutral';
        $messageCount = count($messages);

        $summary = "Percakapan dengan {$messageCount} pesan. ";
        
        if (!empty($topics)) {
            $summary .= "Topik: " . implode(', ', array_map('ucfirst', $topics)) . ". ";
        }

        $summary .= "Sentimen: " . ucfirst($sentiment) . ". ";

        if ($analysis['alert_level'] !== 'none') {
            $summary .= "⚠️ Memerlukan perhatian khusus (" . strtoupper($analysis['alert_level']) . ").";
        }

        return $summary;
    }

    /**
     * Extract text from messages array
     */
    private function extractMessagesText(array $messages): string
    {
        $text = '';
        foreach ($messages as $message) {
            if (isset($message['role']) && $message['role'] === 'user') {
                $text .= ' ' . ($message['content'] ?? '');
            }
        }
        return strtolower($text);
    }

    /**
     * Check if text contains keyword (case-insensitive)
     */
    private function containsKeyword(string $text, string $keyword): bool
    {
        return str_contains(strtolower($text), strtolower($keyword));
    }

    /**
     * Get alert message for notification
     */
    public function getAlertMessage(string $alertLevel, string $studentName): string
    {
        $messages = [
            'critical' => "🚨 DARURAT: {$studentName} menunjukkan tanda-tanda krisis mental yang serius. Segera hubungi siswa!",
            'high' => "⚠️ PERHATIAN: {$studentName} menunjukkan distress emosional yang tinggi. Perlu segera dihubungi.",
            'medium' => "📌 INFO: {$studentName} mungkin memerlukan dukungan tambahan berdasarkan percakapan chatbot.",
            'low' => "ℹ️ {$studentName} membagikan percakapan chatbot untuk ditinjau."
        ];

        return $messages[$alertLevel] ?? $messages['low'];
    }
}
