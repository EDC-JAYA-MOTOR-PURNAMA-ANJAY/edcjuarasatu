<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;

class GuruController extends Controller
{
    // HAPUS CONSTRUCTOR - karena middleware sudah di route

    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'konseling_menunggu' => Konseling::where('guru_bk_id', $user->id)
                ->where('status', 'menunggu_persetujuan')
                ->count(),
            'konseling_aktif' => Konseling::where('guru_bk_id', $user->id)
                ->where('status', 'diproses')
                ->count(),
            'konseling_selesai' => Konseling::where('guru_bk_id', $user->id)
                ->where('status', 'selesai')
                ->count(),
        ];

        return view('guru_bk.dashboard.index', compact('stats'));
    }
}