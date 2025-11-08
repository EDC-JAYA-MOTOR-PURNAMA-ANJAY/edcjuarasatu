<?php

namespace App\Observers;

use App\Models\PanggilanOrangTua;
use App\Services\NotificationService;

class PanggilanOrangTuaObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the PanggilanOrangTua "created" event.
     */
    public function created(PanggilanOrangTua $panggilan): void
    {
        // Send notification to student when their parent is called
        $this->notificationService->notifyStudentAboutPanggilanOrangTua($panggilan);
    }
}
