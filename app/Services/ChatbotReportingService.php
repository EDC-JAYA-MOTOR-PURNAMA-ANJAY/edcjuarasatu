<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatbotReportingService
{
    /**
     * Get chatbot usage overview for Guru BK dashboard
     */
    public function getChatbotOverview(): array
    {
        return [
            'total_conversations' => $this->getTotalConversations(),
            'active_users_today' => $this->getActiveUsersToday(),
            'active_users_week' => $this->getActiveUsersWeek(),
            'active_users_month' => $this->getActiveUsersMonth(),
            'total_messages' => $this->getTotalMessages(),
            'avg_messages_per_conversation' => $this->getAverageMessagesPerConversation(),
            'user_satisfaction_rate' => $this->getUserSatisfactionRate(),
            'response_rate' => $this->getResponseRate(),
        ];
    }

    /**
     * Get conversation statistics by topic/category
     */
    public function getConversationsByTopic(): array
    {
        $topics = DB::table('chatbot_conversations')
            ->select('detected_issue as topic', DB::raw('count(*) as total'))
            ->whereNotNull('detected_issue')
            ->groupBy('detected_issue')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $result = [];
        foreach ($topics as $topic) {
            $result[$topic->topic] = $topic->total;
        }

        // Fill common categories if not present
        $commonCategories = [
            'Stress Akademik', 'Masalah Keluarga', 'Hubungan Pertemanan',
            'Kesehatan Mental', 'Karier & Masa Depan', 'Percintaan',
            'Bullying', 'Motivasi Belajar', 'Time Management', 'Lainnya'
        ];

        foreach ($commonCategories as $category) {
            if (!isset($result[$category])) {
                $result[$category] = 0;
            }
        }

        return $result;
    }

    /**
     * Get mood trend analysis (if mood tracking implemented)
     */
    public function getMoodTrend(int $days = 30): array
    {
        $dates = [];
        $moodAverages = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('M d');

            $avgMood = DB::table('mood_tracking')
                ->whereDate('date', $date->toDateString())
                ->avg('mood_level');

            $moodAverages[] = $avgMood ? round($avgMood, 2) : 0;
        }

        return [
            'labels' => $dates,
            'data' => $moodAverages,
        ];
    }

    /**
     * Get students who need attention (flagged by chatbot)
     */
    public function getStudentsNeedingAttention(int $limit = 10): array
    {
        // Students with:
        // - Multiple negative sentiment conversations
        // - Low mood scores
        // - Recurring critical issues
        // - Long time since last Guru BK meeting

        $students = DB::table('users')
            ->select('users.id', 'users.name', 'users.kelas', DB::raw('count(chatbot_conversations.id) as conversation_count'))
            ->join('chatbot_conversations', 'users.id', '=', 'chatbot_conversations.user_id')
            ->where('users.role', 'siswa')
            ->where('chatbot_conversations.sentiment_score', '<', -0.5) // Negative sentiment
            ->where('chatbot_conversations.created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('users.id', 'users.name', 'users.kelas')
            ->having('conversation_count', '>=', 3) // Multiple conversations
            ->orderByDesc('conversation_count')
            ->limit($limit)
            ->get();

        $result = [];
        foreach ($students as $student) {
            // Get latest issue
            $latestIssue = DB::table('chatbot_conversations')
                ->where('user_id', $student->id)
                ->whereNotNull('detected_issue')
                ->orderByDesc('created_at')
                ->value('detected_issue');

            // Get mood score if available
            $latestMood = DB::table('mood_tracking')
                ->where('user_id', $student->id)
                ->orderByDesc('date')
                ->value('mood_level');

            $result[] = [
                'id' => $student->id,
                'name' => $student->name,
                'kelas' => $student->kelas,
                'conversation_count' => $student->conversation_count,
                'latest_issue' => $latestIssue ?? 'Tidak terdeteksi',
                'mood_score' => $latestMood ?? 'N/A',
                'priority' => $this->calculatePriority($student->conversation_count, $latestMood),
                'last_activity' => $this->getLastActivity($student->id),
            ];
        }

        return $result;
    }

    /**
     * Get individual student chatbot history
     */
    public function getStudentChatbotHistory(int $studentId): array
    {
        $conversations = DB::table('chatbot_conversations')
            ->where('user_id', $studentId)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        $summary = [
            'total_conversations' => $conversations->count(),
            'first_conversation' => $conversations->last()->created_at ?? null,
            'last_conversation' => $conversations->first()->created_at ?? null,
            'detected_issues' => [],
            'sentiment_trend' => [],
            'conversations' => [],
        ];

        // Group by detected issues
        $issueGroups = [];
        foreach ($conversations as $conv) {
            if ($conv->detected_issue) {
                $issueGroups[$conv->detected_issue] = ($issueGroups[$conv->detected_issue] ?? 0) + 1;
            }

            $summary['conversations'][] = [
                'message' => $conv->message,
                'response' => $conv->response,
                'sentiment' => $conv->sentiment_score,
                'issue' => $conv->detected_issue,
                'timestamp' => $conv->created_at,
            ];
        }

        $summary['detected_issues'] = $issueGroups;

        // Calculate sentiment trend (last 10 conversations)
        $recentConversations = array_slice($summary['conversations'], 0, 10);
        foreach ($recentConversations as $conv) {
            $summary['sentiment_trend'][] = $conv['sentiment'];
        }

        return $summary;
    }

    /**
     * Get chatbot effectiveness metrics
     */
    public function getEffectivenessMetrics(): array
    {
        $totalFeedback = DB::table('chatbot_feedback')->count();
        $positiveFeedback = DB::table('chatbot_feedback')->where('rating', '>=', 4)->count();

        $conversationsWithEscalation = DB::table('chatbot_conversations')
            ->where('escalated_to_guru_bk', true)
            ->count();

        $conversationsWithResolution = DB::table('chatbot_conversations')
            ->where('issue_resolved', true)
            ->count();

        $totalConversations = DB::table('chatbot_conversations')->count();

        return [
            'satisfaction_rate' => $totalFeedback > 0 ? round(($positiveFeedback / $totalFeedback) * 100, 2) : 0,
            'escalation_rate' => $totalConversations > 0 ? round(($conversationsWithEscalation / $totalConversations) * 100, 2) : 0,
            'resolution_rate' => $totalConversations > 0 ? round(($conversationsWithResolution / $totalConversations) * 100, 2) : 0,
            'total_feedback' => $totalFeedback,
            'positive_feedback' => $positiveFeedback,
            'escalations' => $conversationsWithEscalation,
            'resolutions' => $conversationsWithResolution,
        ];
    }

    /**
     * Get conversation peak times (when students chat most)
     */
    public function getConversationPeakTimes(): array
    {
        $hourlyData = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $count = DB::table('chatbot_conversations')
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->count();

            $hourlyData[] = [
                'hour' => sprintf('%02d:00', $hour),
                'count' => $count,
            ];
        }

        return $hourlyData;
    }

    /**
     * Export full chatbot report
     */
    public function exportFullReport(): array
    {
        return [
            'generated_at' => Carbon::now()->toDateTimeString(),
            'overview' => $this->getChatbotOverview(),
            'topics' => $this->getConversationsByTopic(),
            'mood_trend' => $this->getMoodTrend(30),
            'students_needing_attention' => $this->getStudentsNeedingAttention(20),
            'effectiveness' => $this->getEffectivenessMetrics(),
            'peak_times' => $this->getConversationPeakTimes(),
        ];
    }

    // Helper methods
    private function getTotalConversations(): int
    {
        return DB::table('chatbot_conversations')
            ->distinct('user_id', 'created_at')
            ->count();
    }

    private function getActiveUsersToday(): int
    {
        return DB::table('chatbot_conversations')
            ->whereDate('created_at', Carbon::today())
            ->distinct('user_id')
            ->count();
    }

    private function getActiveUsersWeek(): int
    {
        return DB::table('chatbot_conversations')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->distinct('user_id')
            ->count();
    }

    private function getActiveUsersMonth(): int
    {
        return DB::table('chatbot_conversations')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->distinct('user_id')
            ->count();
    }

    private function getTotalMessages(): int
    {
        return DB::table('chatbot_conversations')->count();
    }

    private function getAverageMessagesPerConversation(): float
    {
        $conversations = $this->getTotalConversations();
        $messages = $this->getTotalMessages();

        return $conversations > 0 ? round($messages / $conversations, 2) : 0;
    }

    private function getUserSatisfactionRate(): float
    {
        $totalRatings = DB::table('chatbot_feedback')->count();
        if ($totalRatings === 0) return 0;

        $averageRating = DB::table('chatbot_feedback')->avg('rating');
        return round(($averageRating / 5) * 100, 2);
    }

    private function getResponseRate(): float
    {
        // Percentage of conversations that got a response
        return 100.0; // Assuming chatbot always responds
    }

    private function calculatePriority(int $conversationCount, $moodScore): string
    {
        if ($moodScore !== null && $moodScore <= 2) {
            return 'High';
        }

        if ($conversationCount >= 5 && ($moodScore === null || $moodScore <= 3)) {
            return 'High';
        }

        if ($conversationCount >= 3) {
            return 'Medium';
        }

        return 'Low';
    }

    private function getLastActivity(int $userId): string
    {
        $lastConversation = DB::table('chatbot_conversations')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->value('created_at');

        if (!$lastConversation) {
            return 'N/A';
        }

        return Carbon::parse($lastConversation)->diffForHumans();
    }
}
