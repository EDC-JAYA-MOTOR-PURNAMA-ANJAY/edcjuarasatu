<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        // Middleware already applied in routes (web, auth, role:guru_bk)
        // No need to apply again here
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display Guru BK dashboard with analytics
     */
    public function index()
    {
        $guruBkId = Auth::id();

        // Get all analytics data
        $statistics = $this->analyticsService->getDashboardStats($guruBkId);
        $materiByKategori = $this->analyticsService->getMateriByKategori($guruBkId);
        $materiByJenis = $this->analyticsService->getMateriByJenis($guruBkId);
        $monthlyTrend = $this->analyticsService->getMonthlyMateriTrend($guruBkId);
        $notificationStats = $this->analyticsService->getNotificationStats();
        $studentEngagement = $this->analyticsService->getStudentEngagementSummary();
        $topMateri = $this->analyticsService->getMostEngagedMateri($guruBkId, 5);
        $recentActivities = $this->analyticsService->getRecentActivities($guruBkId, 8);

        return view('guru_bk.dashboard', compact(
            'statistics',
            'materiByKategori',
            'materiByJenis',
            'monthlyTrend',
            'notificationStats',
            'studentEngagement',
            'topMateri',
            'recentActivities'
        ));
    }

    /**
     * Export analytics data as JSON
     */
    public function exportAnalytics()
    {
        $guruBkId = Auth::id();
        $data = $this->analyticsService->exportAnalyticsData($guruBkId);

        return response()->json($data);
    }
}
