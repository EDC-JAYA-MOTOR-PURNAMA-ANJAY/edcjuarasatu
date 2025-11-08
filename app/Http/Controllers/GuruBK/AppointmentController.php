<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        // Middleware already applied in routes
    }

    /**
     * Display list of appointments for Guru BK
     */
    public function index(Request $request)
    {
        $guruBkId = Auth::id();
        $status = $request->get('status', 'all');

        $query = Appointment::with(['student'])
            ->where('guru_bk_id', $guruBkId)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $appointments = $query->paginate(15);
        $counts = [
            'all' => Appointment::where('guru_bk_id', $guruBkId)->count(),
            'pending' => Appointment::where('guru_bk_id', $guruBkId)->pending()->count(),
            'approved' => Appointment::where('guru_bk_id', $guruBkId)->approved()->count(),
            'completed' => Appointment::where('guru_bk_id', $guruBkId)->completed()->count(),
        ];

        return view('guru_bk.appointments.index', compact('appointments', 'status', 'counts'));
    }

    /**
     * Show appointment details
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['student', 'guruBK']);
        
        return view('guru_bk.appointments.show', compact('appointment'));
    }

    /**
     * Approve appointment
     */
    public function approve(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Send notification to student
        $this->notificationService->notifyStudentAboutAppointment($appointment, 'approved');

        return redirect()->back()->with('success', 'Appointment berhasil diapprove dan siswa telah menerima notifikasi!');
    }

    /**
     * Reject appointment
     */
    public function reject(Request $request, Appointment $appointment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $appointment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send notification to student with rejection reason
        $this->notificationService->notifyStudentAboutAppointment($appointment, 'rejected', $request->rejection_reason);

        return redirect()->back()->with('success', 'Appointment berhasil ditolak dan siswa telah menerima notifikasi.');
    }

    /**
     * Mark appointment as completed
     */
    public function complete(Request $request, Appointment $appointment)
    {
        $request->validate([
            'guru_bk_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update([
            'status' => 'completed',
            'completed_at' => now(),
            'guru_bk_notes' => $request->guru_bk_notes,
        ]);

        // Send notification to student
        $this->notificationService->notifyStudentAboutAppointment($appointment, 'completed');

        return redirect()->back()->with('success', 'Appointment ditandai sebagai selesai dan siswa telah menerima notifikasi!');
    }

    /**
     * Cancel appointment
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
        ]);

        // Send notification to student
        $this->notificationService->notifyStudentAboutAppointment($appointment, 'cancelled');

        return redirect()->back()->with('success', 'Appointment dibatalkan dan siswa telah menerima notifikasi.');
    }

    /**
     * Calendar view
     */
    public function calendar()
    {
        $guruBkId = Auth::id();
        $appointments = Appointment::with(['student'])
            ->where('guru_bk_id', $guruBkId)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        return view('guru_bk.appointments.calendar', compact('appointments'));
    }
}
