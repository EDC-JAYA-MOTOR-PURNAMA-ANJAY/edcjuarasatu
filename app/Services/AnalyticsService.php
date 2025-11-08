<?php

namespace App\Services;

use App\Models\Materi;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsService
{
    /**
     * Get dashboard statistics for Guru BK
     */
    public function getDashboardStats(int $guruBkId): array
    {
        return [
            'total_students' => $this->getTotalStudents(),
            'total_materi' => $this->getTotalMateri($guruBkId),
            'total_notifications' => $this->getTotalNotifications(),
            'active_students_today' => $this->getActiveStudentsToday(),
            'materi_this_month' => $this->getMateriThisMonth($guruBkId),
            'notification_reach_rate' => $this->getNotificationReachRate(),
        ];
    }

    /**
     * Get total students in system
     */
    public function getTotalStudents(): int
    {
        return User::where('peran', 'siswa')->count();
    }

    /**
     * Get total materi created by Guru BK
     */
    public function getTotalMateri(int $guruBkId): int
    {
        return Materi::where('dibuat_oleh', $guruBkId)->count();
    }

    /**
     * Get total notifications sent
     */
    public function getTotalNotifications(): int
    {
        return Notification::where('type', 'materi')->count();
    }

    /**
     * Get active students today (logged in or interacted)
     */
    public function getActiveStudentsToday(): int
    {
        // Fallback: Count siswa with updated_at today (activity indicator)
        // TODO: Add last_login_at column to users table for accurate tracking
        return User::where('peran', 'siswa')
            ->whereDate('updated_at', '>=', Carbon::today())
            ->count();
    }

    /**
     * Get materi created this month
     */
    public function getMateriThisMonth(int $guruBkId): int
    {
        return Materi::where('dibuat_oleh', $guruBkId)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }

    /**
     * Get notification reach rate (read vs sent)
     */
    public function getNotificationReachRate(): float
    {
        $total = Notification::where('type', 'materi')->count();
        if ($total === 0) return 0;

        $read = Notification::where('type', 'materi')
            ->where('is_read', true)
            ->count();

        return round(($read / $total) * 100, 2);
    }

    /**
     * Get materi by kategori breakdown
     */
    public function getMateriByKategori(int $guruBkId): array
    {
        $data = Materi::where('dibuat_oleh', $guruBkId)
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get()
            ->pluck('total', 'kategori')
            ->toArray();

        // Ensure all categories are present
        $categories = ['Motivasi', 'Akademik', 'Kesehatan Mental', 'Karier'];
        $result = [];
        
        foreach ($categories as $category) {
            $result[$category] = $data[$category] ?? 0;
        }

        return $result;
    }

    /**
     * Get materi by jenis breakdown
     */
    public function getMateriByJenis(int $guruBkId): array
    {
        $data = Materi::where('dibuat_oleh', $guruBkId)
            ->select('jenis', DB::raw('count(*) as total'))
            ->groupBy('jenis')
            ->get()
            ->pluck('total', 'jenis')
            ->toArray();

        // Ensure all types are present
        $types = ['Artikel', 'Video Link', 'File/Dokumen'];
        $result = [];
        
        foreach ($types as $type) {
            $result[$type] = $data[$type] ?? 0;
        }

        return $result;
    }

    /**
     * Get monthly materi creation trend (last 6 months)
     */
    public function getMonthlyMateriTrend(int $guruBkId): array
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $months[] = $monthName;

            $count = Materi::where('dibuat_oleh', $guruBkId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    /**
     * Get most engaged materi (by notification reads)
     */
    public function getMostEngagedMateri(int $guruBkId, int $limit = 5): array
    {
        return Materi::where('dibuat_oleh', $guruBkId)
            ->withCount([
                'notifications as read_count' => function ($query) {
                    $query->where('is_read', true);
                }
            ])
            ->orderBy('read_count', 'desc')
            ->limit($limit)
            ->get(['id', 'judul', 'kategori', 'jenis', 'created_at'])
            ->map(function ($materi) {
                return [
                    'id' => $materi->id,
                    'judul' => $materi->judul,
                    'kategori' => $materi->kategori,
                    'jenis' => $materi->jenis,
                    'engagement' => $materi->read_count,
                    'created_at' => $materi->created_at->format('d M Y'),
                ];
            })
            ->toArray();
    }

    /**
     * Get notification delivery stats
     */
    public function getNotificationStats(): array
    {
        $total = Notification::where('type', 'materi')->count();
        $read = Notification::where('type', 'materi')->where('is_read', true)->count();
        $unread = $total - $read;

        return [
            'total' => $total,
            'read' => $read,
            'unread' => $unread,
            'read_rate' => $total > 0 ? round(($read / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get student engagement summary
     */
    public function getStudentEngagementSummary(): array
    {
        $totalStudents = $this->getTotalStudents();
        $activeToday = $this->getActiveStudentsToday();
        // Use updated_at as activity indicator (fallback)
        $activeThisWeek = User::where('peran', 'siswa')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->count();

        return [
            'total' => $totalStudents,
            'active_today' => $activeToday,
            'active_week' => $activeThisWeek,
            'engagement_rate' => $totalStudents > 0 ? round(($activeThisWeek / $totalStudents) * 100, 2) : 0,
        ];
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities(int $guruBkId, int $limit = 10): array
    {
        $activities = [];

        // Get recent materi
        $recentMateri = Materi::where('dibuat_oleh', $guruBkId)
            ->latest()
            ->limit($limit)
            ->get(['id', 'judul', 'jenis', 'created_at']);

        foreach ($recentMateri as $materi) {
            $activities[] = [
                'type' => 'materi_created',
                'icon' => 'fa-book',
                'color' => 'primary',
                'title' => 'Materi Baru Dibuat',
                'description' => $materi->judul . ' (' . $materi->jenis . ')',
                'time' => $materi->created_at->diffForHumans(),
                'timestamp' => $materi->created_at->timestamp,
            ];
        }

        // Sort by timestamp
        usort($activities, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return array_slice($activities, 0, $limit);
    }

    /**
     * Export analytics data to array for PDF/Excel
     */
    public function exportAnalyticsData(int $guruBkId): array
    {
        return [
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'guru_bk_id' => $guruBkId,
            'statistics' => $this->getDashboardStats($guruBkId),
            'materi_by_kategori' => $this->getMateriByKategori($guruBkId),
            'materi_by_jenis' => $this->getMateriByJenis($guruBkId),
            'monthly_trend' => $this->getMonthlyMateriTrend($guruBkId),
            'notification_stats' => $this->getNotificationStats(),
            'student_engagement' => $this->getStudentEngagementSummary(),
            'top_materi' => $this->getMostEngagedMateri($guruBkId, 10),
        ];
    }
}
