<?php

namespace App\Observers;

use App\Models\Absensi;
use App\Services\NotificationService;

class AbsensiObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Absensi "created" event.
     */
    public function created(Absensi $absensi): void
    {
        // Send notification to student when their attendance is recorded
        $this->notificationService->notifyStudentAboutAbsensi($absensi);
    }

    /**
     * Handle the Absensi "updated" event.
     */
    public function updated(Absensi $absensi): void
    {
        // Send notification when attendance status is updated
        if ($absensi->isDirty('status')) {
            $this->notificationService->notifyStudentAboutAbsensi($absensi);
        }
    }
}
