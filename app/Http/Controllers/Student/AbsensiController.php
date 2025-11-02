<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('siswa.absensi.index');
    }

    public function riwayat(Request $request)
    {
        // Logic untuk riwayat absensi
        return view('siswa.absensi.riwayat');
    }

    public function show(Absensi $absensi)
    {
        // Authorization check
        if ($absensi->siswa_id !== auth()->id()) {
            abort(403);
        }

        return view('siswa.absensi.detail', compact('absensi'));
    }
}