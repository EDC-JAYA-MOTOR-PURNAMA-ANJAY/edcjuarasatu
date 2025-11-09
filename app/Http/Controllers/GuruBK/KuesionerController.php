<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\JenisKuesioner;
use App\Models\PertanyaanKuesioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KuesionerController extends Controller
{
    /**
     * Display a listing of kuesioner
     */
    public function index(Request $request)
    {
        $query = Kuesioner::with(['jenisKuesioner', 'creator'])
            ->withCount(['pertanyaan', 'jawaban'])
            ->where('created_by', auth()->id())
            ->latest();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'aktif') {
                $query->where(function($q) {
                    $q->whereNull('expired_at')
                      ->orWhere('expired_at', '>=', now());
                });
            } elseif ($request->status === 'expired') {
                $query->where('expired_at', '<', now());
            }
        }

        $kuesionerList = $query->paginate(10);

        // Statistics
        $totalKuesioner = Kuesioner::where('created_by', auth()->id())->count();
        $aktif = Kuesioner::where('created_by', auth()->id())
            ->where(function($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>=', now());
            })
            ->count();
        $expired = Kuesioner::where('created_by', auth()->id())
            ->where('expired_at', '<', now())
            ->count();
        $totalResponden = DB::table('jawaban_kuesioner')
            ->whereIn('kuesioner_id', function($query) {
                $query->select('id')
                    ->from('kuesioner')
                    ->where('created_by', auth()->id());
            })
            ->distinct('siswa_id')
            ->count('siswa_id');

        return view('guru_bk.kuesioner.index', compact(
            'kuesionerList',
            'totalKuesioner',
            'aktif',
            'expired',
            'totalResponden'
        ));
    }

    /**
     * Show the form for creating a new kuesioner
     */
    public function create()
    {
        $jenisKuesioner = JenisKuesioner::all();
        return view('guru_bk.kuesioner.create', compact('jenisKuesioner'));
    }

    /**
     * Store a newly created kuesioner
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_kuesioner_id' => 'required|exists:jenis_kuesioner,id',
            'deskripsi' => 'nullable|string',
            'expired_at' => 'nullable|date|after:today',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.pertanyaan' => 'required|string',
            'pertanyaan.*.tipe_jawaban' => 'required|string',
            'pertanyaan.*.opsi' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Create kuesioner
            $kuesioner = Kuesioner::create([
                'judul' => $validated['judul'],
                'jenis_kuesioner_id' => $validated['jenis_kuesioner_id'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'created_by' => auth()->id(),
                'expired_at' => $validated['expired_at'] ?? null,
            ]);

            // Create pertanyaan
            foreach ($validated['pertanyaan'] as $pertanyaanData) {
                $opsiJawaban = null;
                
                // Handle opsi for multiple choice, checkbox, and yes_no
                if (in_array($pertanyaanData['tipe_jawaban'], ['multiple_choice', 'checkbox', 'yes_no'])) {
                    $opsiJawaban = $pertanyaanData['opsi'] ?? [];
                }

                PertanyaanKuesioner::create([
                    'kuesioner_id' => $kuesioner->id,
                    'pertanyaan' => $pertanyaanData['pertanyaan'],
                    'tipe_jawaban' => $pertanyaanData['tipe_jawaban'],
                    'opsi_jawaban' => $opsiJawaban,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('guru_bk.kuesioner.index')
                ->with('success', 'Kuesioner berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating kuesioner: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat kuesioner. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified kuesioner
     */
    public function show($id)
    {
        $kuesioner = Kuesioner::with(['jenisKuesioner', 'creator', 'pertanyaan'])
            ->withCount(['pertanyaan', 'jawaban'])
            ->where('created_by', auth()->id())
            ->findOrFail($id);

        return view('guru_bk.kuesioner.show', compact('kuesioner'));
    }

    /**
     * Show the form for editing the specified kuesioner
     */
    public function edit($id)
    {
        $kuesioner = Kuesioner::with('pertanyaan')
            ->where('created_by', auth()->id())
            ->findOrFail($id);
        
        $jenisKuesioner = JenisKuesioner::all();

        return view('guru_bk.kuesioner.edit', compact('kuesioner', 'jenisKuesioner'));
    }

    /**
     * Update the specified kuesioner
     */
    public function update(Request $request, $id)
    {
        $kuesioner = Kuesioner::where('created_by', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_kuesioner_id' => 'required|exists:jenis_kuesioner,id',
            'deskripsi' => 'nullable|string',
            'expired_at' => 'nullable|date',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.pertanyaan' => 'required|string',
            'pertanyaan.*.tipe_jawaban' => 'required|string',
            'pertanyaan.*.opsi' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Update kuesioner
            $kuesioner->update([
                'judul' => $validated['judul'],
                'jenis_kuesioner_id' => $validated['jenis_kuesioner_id'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'expired_at' => $validated['expired_at'] ?? null,
            ]);

            // Delete existing pertanyaan
            $kuesioner->pertanyaan()->delete();

            // Create new pertanyaan
            foreach ($validated['pertanyaan'] as $pertanyaanData) {
                $opsiJawaban = null;
                
                if (in_array($pertanyaanData['tipe_jawaban'], ['multiple_choice', 'checkbox', 'yes_no'])) {
                    $opsiJawaban = $pertanyaanData['opsi'] ?? [];
                }

                PertanyaanKuesioner::create([
                    'kuesioner_id' => $kuesioner->id,
                    'pertanyaan' => $pertanyaanData['pertanyaan'],
                    'tipe_jawaban' => $pertanyaanData['tipe_jawaban'],
                    'opsi_jawaban' => $opsiJawaban,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('guru_bk.kuesioner.index')
                ->with('success', 'Kuesioner berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating kuesioner: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate kuesioner. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified kuesioner
     */
    public function destroy($id)
    {
        $kuesioner = Kuesioner::where('created_by', auth()->id())->findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete pertanyaan first (cascade)
            $kuesioner->pertanyaan()->delete();
            
            // Delete jawaban
            $kuesioner->jawaban()->delete();
            
            // Delete kuesioner
            $kuesioner->delete();

            DB::commit();

            return redirect()
                ->route('guru_bk.kuesioner.index')
                ->with('success', 'Kuesioner berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting kuesioner: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus kuesioner. Silakan coba lagi.');
        }
    }
}
