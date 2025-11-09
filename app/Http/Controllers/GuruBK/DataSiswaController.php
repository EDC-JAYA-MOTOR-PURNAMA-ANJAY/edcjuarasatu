<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Konseling;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        // Get all students (siswa) with their class info
        $students = User::where('peran', 'siswa')
                       ->with('kelas')
                       ->orderBy('nama', 'asc')
                       ->get();
        
        return view('guru_bk.data-siswa.index', compact('students'));
    }

    /**
     * Display the specified student profile.
     */
    public function show($id)
    {
        // Get student data with kelas relationship
        $student = User::with('kelas')->findOrFail($id);
        
        // Get konseling history for this student
        $konselingHistory = Konseling::where('siswa_id', $id)
                                    ->with('guruBK')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        
        return view('guru_bk.data-siswa.show', compact('student', 'konselingHistory'));
    }
}
