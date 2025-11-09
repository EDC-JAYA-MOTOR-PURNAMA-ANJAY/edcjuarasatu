<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Rekap Absensi - Menampilkan semua siswa yang terdaftar
     */
    public function rekapAbsensi(Request $request)
    {
        // Get all siswa with their kelas
        $query = User::with(['kelas'])
            ->where('peran', 'siswa')
            ->where('status', 'aktif');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nip', 'like', "%{$search}%");
            });
        }

        // Filter by kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Paginate results
        $siswaList = $query->orderBy('nama', 'asc')->paginate(10);

        // Get latest absensi for each siswa
        foreach ($siswaList as $siswa) {
            $siswa->latest_absensi = Absensi::where('siswa_id', $siswa->id)
                ->latest('tanggal')
                ->first();
            
            // Count total absensi
            $siswa->total_absensi = Absensi::where('siswa_id', $siswa->id)->count();
        }

        // Get all kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('guru_bk.rekap-absensi.index', compact('siswaList', 'kelasList'));
    }

    /**
     * Detail Absensi - Menampilkan detail absensi per siswa
     */
    public function detailAbsensi($id)
    {
        // Get siswa data
        $siswa = User::with('kelas')->findOrFail($id);

        // Validate siswa role
        if ($siswa->peran !== 'siswa') {
            abort(404, 'Data siswa tidak ditemukan');
        }

        // Calculate statistics
        $stats = [
            'hadir' => Absensi::where('siswa_id', $id)
                        ->where('status', 'hadir')
                        ->count(),
            
            'izin' => Absensi::where('siswa_id', $id)
                        ->whereIn('status', ['izin', 'sakit'])
                        ->count(),
            
            'alpha' => Absensi::where('siswa_id', $id)
                        ->where('status', 'alpha')
                        ->count(),
            
            'terlambat' => Absensi::where('siswa_id', $id)
                        ->where('status', 'hadir')
                        ->where('waktu_masuk', '>', '07:00:00')
                        ->count(),
        ];

        // Get absensi records with pagination
        $absensiList = Absensi::where('siswa_id', $id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('guru_bk.detail-absensi.index', compact('siswa', 'stats', 'absensiList'));
    }

    /**
     * Get absensi summary by kelas
     */
    public function getSummaryByKelas($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        $siswaList = User::where('kelas_id', $kelasId)
            ->where('peran', 'siswa')
            ->get();

        $summary = [];
        foreach ($siswaList as $siswa) {
            $summary[] = [
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
                'hadir' => Absensi::where('siswa_id', $siswa->id)
                            ->where('status', 'hadir')
                            ->count(),
                'izin' => Absensi::where('siswa_id', $siswa->id)
                            ->whereIn('status', ['izin', 'sakit'])
                            ->count(),
                'alpha' => Absensi::where('siswa_id', $siswa->id)
                            ->where('status', 'alpha')
                            ->count(),
            ];
        }

        return response()->json([
            'kelas' => $kelas->nama_kelas,
            'summary' => $summary
        ]);
    }
}
