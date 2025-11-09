<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentId = Auth::id();
        $student = Auth::user();
        
        // Count konseling (realtime)
        $totalKonseling = Konseling::where('siswa_id', $studentId)->count();
        $konselingMenunggu = Konseling::where('siswa_id', $studentId)
                                     ->where('status', 'menunggu_persetujuan')
                                     ->count();
        $konselingDikonfirmasi = Konseling::where('siswa_id', $studentId)
                                          ->where('status', 'dikonfirmasi')
                                          ->count();
        $konselingSelesai = Konseling::where('siswa_id', $studentId)
                                     ->where('status', 'selesai')
                                     ->count();
        
        // Count pelanggaran (realtime)
        $totalPelanggaran = Pelanggaran::where('siswa_id', $studentId)->count();
        $pelanggaranRingan = Pelanggaran::where('siswa_id', $studentId)
                                        ->where('jenis_pelanggaran', 'Ringan')
                                        ->count();
        $pelanggaranBerat = Pelanggaran::where('siswa_id', $studentId)
                                       ->where('jenis_pelanggaran', 'Berat')
                                       ->count();
        
        // Get recent konseling (last 3)
        $recentKonseling = Konseling::where('siswa_id', $studentId)
                                   ->with(['guruBK'])
                                   ->orderBy('created_at', 'desc')
                                   ->take(3)
                                   ->get();
        
        // Get recent pelanggaran (last 3)
        $recentPelanggaran = Pelanggaran::where('siswa_id', $studentId)
                                        ->with(['guruBK'])
                                        ->orderBy('tanggal_pelanggaran', 'desc')
                                        ->take(3)
                                        ->get();
        
        return view('student.dashboard.index', compact(
            'student',
            'totalKonseling',
            'konselingMenunggu',
            'konselingDikonfirmasi',
            'konselingSelesai',
            'totalPelanggaran',
            'pelanggaranRingan',
            'pelanggaranBerat',
            'recentKonseling',
            'recentPelanggaran'
        ));
    }
}
