<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Konseling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CounselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('student.counseling.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all active Guru BK from database
        $guruBK = User::where('peran', 'guru_bk')
                      ->where('status', 'aktif')
                      ->select('id', 'nama', 'nis_nip')
                      ->orderBy('nama')
                      ->get();
        
        // Get all jurusan from database
        $jurusan = DB::table('jurusan')
                     ->select('id', 'kode_jurusan', 'nama_jurusan')
                     ->orderBy('kode_jurusan')
                     ->get();
        
        return view('student.counseling.create', compact('guruBK', 'jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string',
            'jurusan' => 'nullable|exists:jurusan,id',
            'guru_bk' => 'required|exists:users,id',
            'metode' => 'required|in:offline,online',
            'jenis_konseling' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'cerita' => 'nullable|string',
        ]);

        // Create konseling record
        $konseling = Konseling::create([
            'siswa_id' => Auth::id(),
            'nama_siswa' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'jurusan_id' => $validated['jurusan'] ?? null,
            'guru_bk_id' => $validated['guru_bk'],
            'metode_konseling' => $validated['metode'],
            'jenis_konseling' => $validated['jenis_konseling'],
            'deskripsi' => $validated['cerita'] ?? null,
            'tanggal_pengajuan' => now()->toDateString(),
            'waktu_pengajuan' => now()->toTimeString(),
            'tanggal_konseling' => $validated['tanggal'],
            'waktu_konseling' => $validated['jam'],
            'status' => 'menunggu_persetujuan',
        ]);

        // Return JSON response for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal Konseling telah diajukan.',
                'data' => $konseling
            ]);
        }

        return redirect()->route('student.counseling.schedule')
                         ->with('success', 'Pengajuan konseling berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('student.counseling.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('student.counseling.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logic untuk update data konseling
        return redirect()->route('student.counseling.index')
                         ->with('success', 'Data konseling berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk hapus data konseling
        return redirect()->route('student.counseling.index')
                         ->with('success', 'Data konseling berhasil dihapus!');
    }

    /**
     * Display counseling schedule.
     */
    public function schedule()
    {
        // Get current authenticated student
        $studentId = Auth::id();
        
        // Fetch all konseling for this student
        $konselings = Konseling::where('siswa_id', $studentId)
                               ->with(['guruBK', 'jurusan'])
                               ->orderBy('tanggal_konseling', 'desc')
                               ->orderBy('waktu_konseling', 'desc')
                               ->get();
        
        // Get today's date for calendar
        $today = Carbon::now();
        $currentMonth = $today->format('F Y');
        $currentDay = $today->format('d');
        $currentDayName = $today->isoFormat('dddd, D MMMM Y');
        
        // Count today's schedule
        $todayScheduleCount = Konseling::where('siswa_id', $studentId)
                                      ->whereDate('tanggal_konseling', $today->toDateString())
                                      ->count();
        
        return view('student.counseling.schedule', compact(
            'konselings',
            'today',
            'currentMonth',
            'currentDay',
            'currentDayName',
            'todayScheduleCount'
        ));
    }
}