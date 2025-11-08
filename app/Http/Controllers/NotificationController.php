<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get unread notifications for authenticated user
     * GET /api/notifications/unread
     */
    public function getUnread(Request $request): JsonResponse
    {
        try {
            $notifications = $this->notificationService->getUnreadNotifications(auth()->id());
            $count = $notifications->count();

            return response()->json([
                'success' => true,
                'count' => $count,
                'notifications' => $notifications,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching notifications',
            ], 500);
        }
    }

    /**
     * Get unread count for polling
     * GET /api/notifications/count
     */
    public function getUnreadCount(Request $request): JsonResponse
    {
        try {
            $count = $this->notificationService->getUnreadCount(auth()->id());

            return response()->json([
                'success' => true,
                'count' => $count,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching notification count',
            ], 500);
        }
    }

    /**
     * Check for new notifications (polling endpoint)
     * GET /api/notifications/check-new
     */
    public function checkNew(Request $request): JsonResponse
    {
        try {
            // Get notifications created in last 2 minutes
            $recentNotifications = Notification::forUser(auth()->id())
                ->unread()
                ->where('created_at', '>=', now()->subMinutes(2))
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'has_new' => $recentNotifications->isNotEmpty(),
                'count' => $recentNotifications->count(),
                'notifications' => $recentNotifications,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking new notifications',
            ], 500);
        }
    }

    /**
     * Mark notification as read
     * POST /api/notifications/{id}/read
     */
    public function markAsRead(Request $request, int $id): JsonResponse
    {
        try {
            $notification = Notification::findOrFail($id);

            // Check ownership
            if ($notification->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking notification as read',
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     * POST /api/notifications/read-all
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        try {
            $this->notificationService->markAllAsRead(auth()->id());

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking all notifications as read',
            ], 500);
        }
    }

    /**
     * Get all notifications (with pagination)
     * GET /student/notifications
     */
    public function index(Request $request)
    {
        try {
            $notifications = Notification::forUser(auth()->id())
                ->latest()
                ->paginate(20);

            return view('student.notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading notifications');
        }
    }
}
