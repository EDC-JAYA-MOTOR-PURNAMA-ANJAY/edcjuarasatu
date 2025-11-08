<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        // Middleware already applied in routes
    }

    /**
     * Display student's appointments
     */
    public function index()
    {
        $studentId = Auth::id();
        $appointments = Appointment::with(['guruBK'])
            ->where('student_id', $studentId)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('student.appointments.index', compact('appointments'));
    }

    /**
     * Show booking form
     */
    public function create()
    {
        // Get available Guru BK
        $guruBKList = User::where('role', 'guru_bk')
            ->where('status', 'aktif')
            ->get();

        return view('student.appointments.create', compact('guruBKList'));
    }

    /**
     * Store new appointment booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_bk_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'topic' => 'nullable|string|max:255',
            'student_notes' => 'nullable|string|max:1000',
        ], [
            'appointment_date.after' => 'Tanggal appointment minimal besok.',
            'guru_bk_id.required' => 'Pilih Guru BK terlebih dahulu.',
        ]);

        Appointment::create([
            'student_id' => Auth::id(),
            'guru_bk_id' => $validated['guru_bk_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'topic' => $validated['topic'],
            'student_notes' => $validated['student_notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('student.appointments.index')
            ->with('success', 'Appointment berhasil dibuat! Menunggu approval dari Guru BK.');
    }

    /**
     * Show appointment details
     */
    public function show(Appointment $appointment)
    {
        // Ensure student can only view their own appointment
        if ($appointment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $appointment->load(['guruBK']);
        
        return view('student.appointments.show', compact('appointment'));
    }

    /**
     * Cancel appointment
     */
    public function cancel(Appointment $appointment)
    {
        // Ensure student can only cancel their own appointment
        if ($appointment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Can only cancel if pending or approved
        if (!in_array($appointment->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Appointment tidak dapat dibatalkan.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Appointment berhasil dibatalkan.');
    }
}
