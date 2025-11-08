<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Services\ChatbotReportingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    protected $reportingService;

    public function __construct(ChatbotReportingService $reportingService)
    {
        // Middleware already applied in routes
        $this->reportingService = $reportingService;
    }

    /**
     * Display chatbot reporting dashboard
     */
    public function reports()
    {
        $overview = $this->reportingService->getChatbotOverview();
        $topicDistribution = $this->reportingService->getConversationsByTopic();
        $moodTrend = $this->reportingService->getMoodTrend(30);
        $studentsNeedingAttention = $this->reportingService->getStudentsNeedingAttention(10);
        $effectiveness = $this->reportingService->getEffectivenessMetrics();
        $peakTimes = $this->reportingService->getConversationPeakTimes();

        return view('guru_bk.chatbot.reports', compact(
            'overview',
            'topicDistribution',
            'moodTrend',
            'studentsNeedingAttention',
            'effectiveness',
            'peakTimes'
        ));
    }

    /**
     * View individual student chat history
     */
    public function studentHistory(int $studentId)
    {
        $history = $this->reportingService->getStudentChatbotHistory($studentId);
        
        return view('guru_bk.chatbot.student-history', compact('history', 'studentId'));
    }

    /**
     * Export full chatbot report
     */
    public function exportReport()
    {
        $data = $this->reportingService->exportFullReport();
        
        return response()->json($data);
    }
    
    /**
     * Display shared conversations dashboard
     */
    public function sharedConversations(Request $request)
    {
        $filter = $request->get('filter', 'all'); // all, critical, high, pending
        
        $query = \App\Models\AiConversation::with(['user', 'user.kelas'])
            ->where('is_shared_with_guru_bk', true)
            ->orderBy('shared_at', 'desc');
        
        // Apply filters
        if ($filter === 'critical') {
            $query->where('alert_level', 'critical');
        } elseif ($filter === 'high') {
            $query->where('alert_level', 'high');
        } elseif ($filter === 'needs_attention') {
            $query->whereIn('alert_level', ['critical', 'high']);
        } elseif ($filter === 'pending') {
            $query->where('status', 'shared');
        }
        
        $conversations = $query->paginate(20);
        
        // Statistics
        $stats = [
            'total_shared' => \App\Models\AiConversation::where('is_shared_with_guru_bk', true)->count(),
            'critical' => \App\Models\AiConversation::where('is_shared_with_guru_bk', true)->where('alert_level', 'critical')->count(),
            'high' => \App\Models\AiConversation::where('is_shared_with_guru_bk', true)->where('alert_level', 'high')->count(),
            'pending' => \App\Models\AiConversation::where('is_shared_with_guru_bk', true)->where('status', 'shared')->count(),
            'reviewed' => \App\Models\AiConversation::where('is_shared_with_guru_bk', true)->where('status', 'reviewed')->count(),
        ];
        
        return view('guru_bk.chatbot.shared-conversations', compact('conversations', 'stats', 'filter'));
    }
    
    /**
     * View shared conversation detail
     */
    public function viewSharedConversation($id)
    {
        $conversation = \App\Models\AiConversation::with(['user', 'user.kelas', 'reviewer'])
            ->where('is_shared_with_guru_bk', true)
            ->findOrFail($id);
        
        return view('guru_bk.chatbot.conversation-detail', compact('conversation'));
    }
    
    /**
     * Add notes to shared conversation
     */
    public function addNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);
        
        $conversation = \App\Models\AiConversation::where('is_shared_with_guru_bk', true)
            ->findOrFail($id);
        
        $conversation->update([
            'guru_bk_notes' => $request->notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'status' => 'reviewed'
        ]);
        
        // Notify student
        \App\Models\Notification::create([
            'user_id' => $conversation->user_id,
            'type' => 'chatbot_reviewed',
            'title' => '💬 Guru BK Telah Meninjau Chat Kamu',
            'message' => Auth::user()->nama . ' telah meninjau percakapan yang kamu bagikan. Guru BK mungkin akan menghubungimu segera.',
            'data' => json_encode([
                'conversation_id' => $conversation->id,
                'guru_bk_name' => Auth::user()->nama
            ]),
            'is_read' => false
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil disimpan dan siswa telah diberi tahu'
        ]);
    }
    
    /**
     * Analytics dashboard for chatbot
     */
    public function analytics()
    {
        // Get conversations from last 30 days
        $startDate = now()->subDays(30);
        
        // Topic distribution
        $allConversations = \App\Models\AiConversation::where('is_shared_with_guru_bk', true)
            ->where('created_at', '>=', $startDate)
            ->get();
        
        $topicStats = [];
        foreach ($allConversations as $conv) {
            if ($conv->topics) {
                foreach ($conv->topics as $topic) {
                    $topicStats[$topic] = ($topicStats[$topic] ?? 0) + 1;
                }
            }
        }
        arsort($topicStats);
        
        // Sentiment distribution
        $sentimentStats = \App\Models\AiConversation::where('is_shared_with_guru_bk', true)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('sentiment, COUNT(*) as count')
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment')
            ->toArray();
        
        // Alert level distribution
        $alertStats = \App\Models\AiConversation::where('is_shared_with_guru_bk', true)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('alert_level, COUNT(*) as count')
            ->groupBy('alert_level')
            ->pluck('count', 'alert_level')
            ->toArray();
        
        // Students needing attention
        $studentsNeedingAttention = \App\Models\AiConversation::with('user')
            ->where('is_shared_with_guru_bk', true)
            ->whereIn('alert_level', ['critical', 'high'])
            ->where('status', 'shared') // Not yet reviewed
            ->orderBy('alert_level', 'desc')
            ->orderBy('shared_at', 'asc')
            ->limit(10)
            ->get();
        
        // Weekly trend
        $weeklyTrend = \App\Models\AiConversation::where('is_shared_with_guru_bk', true)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(shared_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('guru_bk.chatbot.analytics', compact(
            'topicStats',
            'sentimentStats',
            'alertStats',
            'studentsNeedingAttention',
            'weeklyTrend'
        ));
    }
}
