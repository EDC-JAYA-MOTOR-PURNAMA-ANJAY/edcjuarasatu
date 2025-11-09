<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ViolationController extends Controller
{
    /**
     * Display student's violations (realtime)
     */
    public function index()
    {
        $studentId = Auth::id();
        
        // Get all violations for this student (realtime from database)
        $violations = Pelanggaran::where('siswa_id', $studentId)
                                ->with(['pelapor', 'guruBK'])
                                ->orderBy('tanggal_pelanggaran', 'desc')
                                ->get();
        
        // Statistics
        $totalViolations = $violations->count();
        $violationsRingan = $violations->filter(function($v) {
            return strtolower($v->jenis_pelanggaran) == 'ringan';
        })->count();
        $violationsBerat = $violations->filter(function($v) {
            return strtolower($v->jenis_pelanggaran) == 'berat';
        })->count();
        
        return view('student.violation.index', compact(
            'violations',
            'totalViolations',
            'violationsRingan',
            'violationsBerat'
        ));
    }
}
