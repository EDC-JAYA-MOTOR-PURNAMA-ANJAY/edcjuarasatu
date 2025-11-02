<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;

class StudentController extends Controller
{
    // HAPUS CONSTRUCTOR - karena middleware sudah di route

    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'konseling_aktif' => Konseling::where('siswa_id', $user->id)
                ->whereIn('status', ['menunggu_persetujuan', 'diproses'])
                ->count(),
            'konseling_selesai' => Konseling::where('siswa_id', $user->id)
                ->where('status', 'selesai')
                ->count(),
        ];

        return view('student.dashboard', compact('stats'));
    }
}