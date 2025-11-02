<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('student.counseling.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic untuk menyimpan data konseling akan ditambahkan kemudian
        return redirect()->route('student.counseling.index')
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
        return view('student.counseling.schedule');
    }
}