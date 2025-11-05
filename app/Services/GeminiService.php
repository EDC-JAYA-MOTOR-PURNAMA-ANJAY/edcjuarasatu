<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiService
{
    protected $apiKey;
    protected $endpoint;
    protected $model;
    protected $timeout;
    
    public function __construct()
    {
        $this->apiKey = config('ai.gemini.api_key');
        $this->endpoint = config('ai.gemini.endpoint');
        $this->model = config('ai.gemini.model');
        $this->timeout = config('ai.gemini.timeout', 30);
    }
    
    /**
     * Chat with Gemini AI
     */
    public function chat($message, $conversationHistory = [])
    {
        try {
            // Check if AI is enabled
            if (!config('ai.companion.enabled')) {
                return $this->errorResponse('AI companion sedang dinonaktifkan.');
            }
            
            // Check API key
            if (empty($this->apiKey)) {
                Log::error('Gemini API key not configured');
                return $this->errorResponse('AI tidak dikonfigurasi dengan benar.');
            }
            
            // Build conversation context
            $contents = $this->buildContents($message, $conversationHistory);
            
            // Make API request
            $response = Http::timeout($this->timeout)
                ->post("{$this->endpoint}/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => config('ai.companion.temperature'),
                        'maxOutputTokens' => config('ai.companion.max_tokens'),
                        'topP' => 0.95,
                        'topK' => 40,
                    ],
                    'safetySettings' => $this->getSafetySettings(),
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Extract AI response
                $aiMessage = $data['candidates'][0]['content']['parts'][0]['text'] ?? 
                            'Maaf, aku tidak bisa merespon saat ini. 😔';
                
                // Analyze user message
                $sentiment = $this->analyzeSentiment($message);
                $isCrisis = $this->detectCrisis($message);
                
                return [
                    'success' => true,
                    'message' => trim($aiMessage),
                    'sentiment' => $sentiment,
                    'is_crisis' => $isCrisis,
                    'tokens_used' => $this->estimateTokens($message . $aiMessage),
                ];
            }
            
            // Handle API errors
            $errorData = $response->json();
            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $errorData,
            ]);
            
            return $this->errorResponse('Maaf, aku sedang sibuk. Coba lagi dalam beberapa saat ya! 😊');
            
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            
            return $this->errorResponse('Ups, ada yang error. Coba lagi ya! 🙏');
        }
    }
    
    /**
     * Build conversation contents for API
     */
    protected function buildContents($message, $history)
    {
        $contents = [];
        
        // Add system prompt as first interaction
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => config('ai.companion.system_prompt')]],
        ];
        
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => 'Siap! Aku di sini sebagai Sahabat AI yang akan selalu mendengarkan dan support kamu. Cerita aja apa yang ada di pikiran kamu! 😊']],
        ];
        
        // Add recent conversation history (last N messages)
        $maxHistory = config('ai.companion.max_history', 10);
        $recentHistory = array_slice($history, -$maxHistory);
        
        foreach ($recentHistory as $msg) {
            $contents[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg['message']]],
            ];
        }
        
        // Add current message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $message]],
        ];
        
        return $contents;
    }
    
    /**
     * Get safety settings for API
     */
    protected function getSafetySettings()
    {
        return [
            [
                'category' => 'HARM_CATEGORY_HARASSMENT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
            ],
            [
                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
            ],
            [
                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
            ],
            [
                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                'threshold' => 'BLOCK_ONLY_HIGH',
            ],
        ];
    }
    
    /**
     * Analyze sentiment of message
     */
    protected function analyzeSentiment($text)
    {
        $text = strtolower($text);
        
        $positiveWords = [
            'senang', 'bahagia', 'gembira', 'suka', 'bagus', 'mantap', 
            'keren', 'asik', 'excited', 'semangat', 'thanks', 'terima kasih'
        ];
        
        $negativeWords = [
            'sedih', 'stress', 'galau', 'bingung', 'takut', 'cemas', 
            'depresi', 'capek', 'lelah', 'down', 'hopeless', 'putus asa',
            'marah', 'kesal', 'jengkel', 'bad', 'buruk'
        ];
        
        $positiveCount = 0;
        $negativeCount = 0;
        
        foreach ($positiveWords as $word) {
            if (str_contains($text, $word)) $positiveCount++;
        }
        
        foreach ($negativeWords as $word) {
            if (str_contains($text, $word)) $negativeCount++;
        }
        
        if ($positiveCount > $negativeCount) return 'positive';
        if ($negativeCount > $positiveCount) return 'negative';
        return 'neutral';
    }
    
    /**
     * Detect crisis keywords in message
     */
    protected function detectCrisis($text)
    {
        $text = strtolower($text);
        $crisisKeywords = config('ai.crisis_keywords', []);
        
        foreach ($crisisKeywords as $keyword) {
            if (str_contains($text, strtolower($keyword))) {
                Log::warning('Crisis keyword detected', [
                    'keyword' => $keyword,
                    'message' => substr($text, 0, 100),
                ]);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Estimate tokens used
     */
    protected function estimateTokens($text)
    {
        // Rough estimation: 1 token ≈ 4 characters for Indonesian
        return ceil(strlen($text) / 4);
    }
    
    /**
     * Error response helper
     */
    protected function errorResponse($message)
    {
        return [
            'success' => false,
            'message' => $message,
            'sentiment' => 'neutral',
            'is_crisis' => false,
        ];
    }
    
    /**
     * Check rate limit for user
     */
    public function checkRateLimit($userId)
    {
        if (!config('ai.rate_limit.enabled')) {
            return true;
        }
        
        $keyMinute = "ai_rate_limit:minute:{$userId}";
        $keyHour = "ai_rate_limit:hour:{$userId}";
        
        $countMinute = Cache::get($keyMinute, 0);
        $countHour = Cache::get($keyHour, 0);
        
        $maxMinute = config('ai.rate_limit.max_requests_per_minute');
        $maxHour = config('ai.rate_limit.max_requests_per_hour');
        
        if ($countMinute >= $maxMinute || $countHour >= $maxHour) {
            return false;
        }
        
        // Increment counters
        Cache::put($keyMinute, $countMinute + 1, 60);
        Cache::put($keyHour, $countHour + 1, 3600);
        
        return true;
    }
}
