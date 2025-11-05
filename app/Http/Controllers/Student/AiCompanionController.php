<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use App\Models\AiConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AiCompanionController extends Controller
{
    protected $gemini;
    
    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }
    
    /**
     * Show AI companion chat page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get today's conversation count
        $todayCount = AiConversation::where('user_id', $user->id)
            ->where('role', 'user')
            ->whereDate('created_at', today())
            ->count();
        
        // Get conversation stats
        $stats = [
            'total_conversations' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->count(),
            'today' => $todayCount,
            'this_week' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->where('created_at', '>=', now()->startOfWeek())
                ->count(),
        ];
        
        return view('student.ai-companion.index', compact('stats'));
    }
    
    /**
     * Load chat history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        
        $limit = $request->get('limit', 50);
        
        $conversations = AiConversation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
        
        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }
    
    /**
     * Send message to AI
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        
        $user = Auth::user();
        $message = trim($request->message);
        
        // Check rate limit
        if (!$this->gemini->checkRateLimit($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu terlalu banyak chat. Istirahat dulu ya, tunggu sebentar! 😊',
            ], 429);
        }
        
        try {
            // Get recent conversation history for context
            $history = AiConversation::where('user_id', $user->id)
                ->where('created_at', '>=', now()->subHours(2))
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($conv) {
                    return [
                        'role' => $conv->role,
                        'message' => $conv->message,
                    ];
                })
                ->toArray();
            
            // Send to Gemini AI
            $response = $this->gemini->chat($message, $history);
            
            if ($response['success']) {
                // Save user message
                $userMessage = AiConversation::create([
                    'user_id' => $user->id,
                    'role' => 'user',
                    'message' => $message,
                    'sentiment' => $response['sentiment'],
                    'is_crisis' => $response['is_crisis'],
                ]);
                
                // Save AI response
                $aiMessage = AiConversation::create([
                    'user_id' => $user->id,
                    'role' => 'assistant',
                    'message' => $response['message'],
                    'sentiment' => null,
                    'is_crisis' => false,
                ]);
                
                // If crisis detected, notify (you can implement this)
                if ($response['is_crisis']) {
                    $this->handleCrisis($user, $message);
                }
                
                // Voice notification
                if ($response['is_crisis']) {
                    $voiceMessage = "Sepertinya kamu sedang mengalami masa sulit. Aku sangat recommend untuk bicara dengan Guru BK atau orang yang kamu percaya.";
                } else {
                    $voiceMessage = null;
                }
                
                return response()->json([
                    'success' => true,
                    'user_message' => [
                        'id' => $userMessage->id,
                        'message' => $userMessage->message,
                        'created_at' => $userMessage->created_at->format('H:i'),
                    ],
                    'ai_message' => [
                        'id' => $aiMessage->id,
                        'message' => $aiMessage->message,
                        'created_at' => $aiMessage->created_at->format('H:i'),
                    ],
                    'sentiment' => $response['sentiment'],
                    'is_crisis' => $response['is_crisis'],
                    'voice_message' => $voiceMessage,
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => $response['message'],
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan. Coba lagi ya! 🙏',
            ], 500);
        }
    }
    
    /**
     * Handle crisis situation
     */
    protected function handleCrisis($user, $message)
    {
        // Log crisis event
        Log::warning('CRISIS DETECTED', [
            'user_id' => $user->id,
            'user_name' => $user->nama,
            'message' => substr($message, 0, 200),
            'time' => now(),
        ]);
        
        // TODO: Send notification to Guru BK
        // You can implement email, SMS, or push notification here
        
        // Example: Create notification in database
        // Notification::create([
        //     'type' => 'crisis_alert',
        //     'user_id' => $user->id,
        //     'message' => "Student {$user->nama} may need immediate attention",
        //     'data' => json_encode(['message' => $message]),
        // ]);
    }
    
    /**
     * Clear conversation history
     */
    public function clearHistory()
    {
        $user = Auth::user();
        
        $deleted = AiConversation::where('user_id', $user->id)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil menghapus {$deleted} pesan.",
        ]);
    }
    
    /**
     * Get conversation statistics
     */
    public function stats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_messages' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->count(),
            'today' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->whereDate('created_at', today())
                ->count(),
            'this_week' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->where('created_at', '>=', now()->startOfWeek())
                ->count(),
            'this_month' => AiConversation::where('user_id', $user->id)
                ->where('role', 'user')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'sentiment_breakdown' => [
                'positive' => AiConversation::where('user_id', $user->id)
                    ->where('sentiment', 'positive')
                    ->count(),
                'neutral' => AiConversation::where('user_id', $user->id)
                    ->where('sentiment', 'neutral')
                    ->count(),
                'negative' => AiConversation::where('user_id', $user->id)
                    ->where('sentiment', 'negative')
                    ->count(),
            ],
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
    
    /**
     * Export conversation to PDF
     */
    public function exportPdf()
    {
        $user = Auth::user();
        
        // Get all conversations for this user
        $conversations = AiConversation::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        if ($conversations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada percakapan untuk diexport.');
        }
        
        // Prepare data for PDF
        $data = [
            'user' => $user,
            'conversations' => $conversations,
            'exported_at' => now()->format('d F Y, H:i'),
            'total_messages' => $conversations->count(),
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('student.ai-companion.export-pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');
        
        // Download PDF
        $filename = 'Chat_Sahabat_AI_' . $user->nama . '_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}
