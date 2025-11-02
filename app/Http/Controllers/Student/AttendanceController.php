<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswaId = auth()->id();
        
        // Ambil data absensi siswa yang login dari database
        $absensiList = Absensi::where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->get();
        
        // Hitung statistik dari database
        $totalHadir = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'hadir')
            ->count();
        
        $totalIzinSakit = Absensi::where('siswa_id', $siswaId)
            ->whereIn('status', ['izin', 'sakit'])
            ->count();
        
        $totalAlpha = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'alpha')
            ->count();
        
        $totalTerlambat = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'hadir')
            ->where('waktu_masuk', '>', '07:00:00')
            ->count();
        
        return view('student.attendance.index', compact(
            'absensiList',
            'totalHadir',
            'totalIzinSakit',
            'totalAlpha',
            'totalTerlambat'
        ));
    }
    
    /**
     * Store new attendance record
     */
    public function store(Request $request)
    {
        $siswaId = auth()->id();
        $today = Carbon::today();
        
        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absensi::where('siswa_id', $siswaId)
            ->whereDate('tanggal', $today)
            ->first();
        
        if ($existingAbsensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen hari ini!'
            ], 400);
        }
        
        $now = Carbon::now();
        $waktuMasuk = $now->format('H:i:s');
        
        // Tentukan keterangan berdasarkan waktu
        $keterangan = 'Masuk';
        if ($now->hour >= 7 && $now->minute > 0) {
            $keterangan = 'Telat';
        }
        
        // Simpan ke database
        Absensi::create([
            'siswa_id' => $siswaId,
            'kelas_id' => auth()->user()->kelas_id,
            'tahun_ajaran_id' => 1,
            'tanggal' => $today,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => null,
            'status' => 'hadir',
            'keterangan' => $keterangan,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil disimpan!',
            'data' => [
                'nama' => auth()->user()->nama,
                'tanggal' => $now->locale('id')->isoFormat('dddd, D MMMM YYYY'),
                'waktu' => $now->format('H:i'),
                'keterangan' => $keterangan,
                'is_late' => $now->hour >= 7 && $now->minute > 0
            ]
        ]);
    }
}
