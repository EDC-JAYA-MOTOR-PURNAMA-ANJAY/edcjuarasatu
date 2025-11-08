<?php

namespace App\Observers;

use App\Models\Pelanggaran;
use App\Services\NotificationService;

class PelanggaranObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Pelanggaran "created" event.
     */
    public function created(Pelanggaran $pelanggaran): void
    {
        // Send notification to student when pelanggaran is recorded
        $this->notificationService->notifyStudentAboutPelanggaran($pelanggaran);
    }
}
