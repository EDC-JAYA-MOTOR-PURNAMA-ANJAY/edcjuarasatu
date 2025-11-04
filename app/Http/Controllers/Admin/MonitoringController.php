<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Display monitoring and statistics page
     */
    public function index()
    {
        // Get list of Guru BK for filter
        $guruBkList = User::where('peran', 'guru_bk')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();
        
        // Get list of Jurusan for filter
        $jurusanList = Jurusan::orderBy('nama_jurusan')->get();
        
        // Get list of Kelas for filter
        $kelasList = Kelas::with('jurusan')
            ->orderBy('nama_kelas')
            ->get();
        
        // Get kategori statistics (for pie chart)
        // Use kategori_masalah_id and join with kategori_masalah table
        $kategoriStats = Konseling::select('kategori_masalah_id', DB::raw('count(*) as total'))
            ->whereNotNull('kategori_masalah_id')
            ->with('kategoriMasalah')
            ->groupBy('kategori_masalah_id')
            ->get()
            ->map(function($item) {
                return [
                    'kategori' => $item->kategoriMasalah->nama_kategori ?? 'Lainnya',
                    'total' => $item->total
                ];
            })
            ->toArray();
        
        // If no data, provide dummy data
        if (empty($kategoriStats)) {
            $kategoriStats = [
                ['kategori' => 'Akademik', 'total' => 0],
                ['kategori' => 'Sosial', 'total' => 0],
                ['kategori' => 'Pribadi', 'total' => 0],
            ];
        }
        
        // Get demografi statistics (for bar chart)
        // Count siswa (male), siswi (female), guru_bk
        $siswaCount = User::where('peran', 'siswa')
            ->where('jenis_kelamin', 'laki-laki')
            ->where('status', 'aktif')
            ->count();
            
        $siswiCount = User::where('peran', 'siswa')
            ->where('jenis_kelamin', 'perempuan')
            ->where('status', 'aktif')
            ->count();
            
        $guruBkCount = User::where('peran', 'guru_bk')
            ->where('status', 'aktif')
            ->count();
        
        $demografiStats = [
            ['peran' => 'siswa', 'total' => $siswaCount],
            ['peran' => 'siswi', 'total' => $siswiCount],
            ['peran' => 'guru_bk', 'total' => $guruBkCount],
        ];
        
        return view('admin.monitoring.index', compact(
            'guruBkList', 
            'jurusanList', 
            'kelasList',
            'kategoriStats',
            'demografiStats'
        ));
    }
    
    /**
     * Get filtered data for AJAX request
     */
    public function getData(Request $request)
    {
        $query = Konseling::query();
        
        // Filter by Guru BK
        if ($request->filled('guru_bk')) {
            $query->where('guru_bk_id', $request->guru_bk);
        }
        
        // Filter by Jurusan (via siswa's kelas)
        if ($request->filled('jurusan')) {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan);
            });
        }
        
        // Get kategori stats
        $kategoriData = (clone $query)->select('kategori_masalah_id', DB::raw('count(*) as total'))
            ->whereNotNull('kategori_masalah_id')
            ->with('kategoriMasalah')
            ->groupBy('kategori_masalah_id')
            ->get()
            ->map(function($item) {
                return [
                    'kategori' => $item->kategoriMasalah->nama_kategori ?? 'Lainnya',
                    'total' => $item->total
                ];
            })
            ->toArray();
        
        if (empty($kategoriData)) {
            $kategoriData = [
                ['kategori' => 'Akademik', 'total' => 0],
                ['kategori' => 'Sosial', 'total' => 0],
                ['kategori' => 'Pribadi', 'total' => 0],
            ];
        }
        
        // Get demografi stats (siswa counts by gender)
        $siswaQuery = User::where('peran', 'siswa')->where('status', 'aktif');
        
        if ($request->filled('jurusan')) {
            $siswaQuery->whereHas('kelas', function($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan);
            });
        }
        
        $siswaCount = (clone $siswaQuery)->where('jenis_kelamin', 'laki-laki')->count();
        $siswiCount = (clone $siswaQuery)->where('jenis_kelamin', 'perempuan')->count();
        $guruBkCount = User::where('peran', 'guru_bk')->where('status', 'aktif')->count();
        
        $demografiData = [
            ['peran' => 'siswa', 'total' => $siswaCount],
            ['peran' => 'siswi', 'total' => $siswiCount],
            ['peran' => 'guru_bk', 'total' => $guruBkCount],
        ];
        
        return response()->json([
            'kategori' => $kategoriData,
            'demografi' => $demografiData,
        ]);
    }
    
    /**
     * Export data to PDF
     */
    public function exportPdf()
    {
        // TODO: Implement PDF export
        return redirect()->back()->with('info', 'Fitur export PDF akan segera tersedia');
    }
    
    /**
     * Export data to Excel
     */
    public function exportExcel()
    {
        // TODO: Implement Excel export
        return redirect()->back()->with('info', 'Fitur export Excel akan segera tersedia');
    }
}
