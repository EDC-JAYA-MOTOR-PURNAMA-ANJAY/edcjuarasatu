<?php

namespace App\Observers;

use App\Models\Konseling;
use App\Services\NotificationService;

class KonselingObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Konseling "created" event.
     */
    public function created(Konseling $konseling): void
    {
        // Send notification to student when new konseling is scheduled
        $this->notificationService->notifyStudentAboutKonseling($konseling);
    }
}
