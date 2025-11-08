<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use App\Events\MateriCreated;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MateriController extends Controller
{
    /**
     * Display a listing of materi for Guru BK
     * GET /guru_bk/materi
     */
    public function index(Request $request)
    {
        try {
            $query = Materi::with('guruBK')
                ->byGuruBK(auth()->id())
                ->latest();

            // Search functionality
            if ($request->has('search') && $request->search) {
                $query->search($request->search);
            }

            // Filter by kategori
            if ($request->has('kategori') && $request->kategori) {
                $query->kategori($request->kategori);
            }

            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            $materiList = $query->paginate(10);

            return view('guru_bk.materi.index', compact('materiList'));
        } catch (\Exception $e) {
            Log::error('Error fetching materi list: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data materi.');
        }
    }

    /**
     * Show the form for creating new materi
     * GET /guru_bk/materi/create
     */
    public function create()
    {
        return view('guru_bk.materi.create');
    }

    /**
     * Store a newly created materi
     * POST /guru_bk/materi
     */
    public function store(StoreMateriRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $validatedData['dibuat_oleh'] = auth()->id();
            $validatedData['status'] = 'Aktif'; // Default status

            // Handle file upload (PDF, DOC, etc)
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('materi/files', $fileName, 'public');
                $validatedData['file_path'] = $filePath;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('materi/thumbnails', 'public');
                $validatedData['thumbnail'] = $thumbnailPath;
            }

            $materi = Materi::create($validatedData);

            // Load relationship for event
            $materi->load('guruBK');

            DB::commit();

            // Fire event for real-time notification (broadcasting)
            event(new MateriCreated($materi));

            // Create database notifications for all students
            $notificationService = new NotificationService();
            $notificationService->notifyStudentsAboutNewMateri($materi);

            return redirect()
                ->route('guru_bk.materi.index')
                ->with('success', 'Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing materi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan materi. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified materi (for Guru BK preview)
     * GET /guru_bk/materi/{id}
     */
    public function show(Materi $materi)
    {
        try {
            // Check if this materi belongs to the logged-in Guru BK
            if ($materi->dibuat_oleh !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke materi ini.');
            }

            return view('guru_bk.materi.show', compact('materi'));
        } catch (\Exception $e) {
            Log::error('Error showing materi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail materi.');
        }
    }

    /**
     * Show the form for editing materi
     * GET /guru_bk/materi/{id}/edit
     */
    public function edit(Materi $materi)
    {
        try {
            // Check if this materi belongs to the logged-in Guru BK
            if ($materi->dibuat_oleh !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit materi ini.');
            }

            return view('guru_bk.materi.edit', compact('materi'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form edit.');
        }
    }

    /**
     * Update the specified materi
     * PUT/PATCH /guru_bk/materi/{id}
     */
    public function update(UpdateMateriRequest $request, Materi $materi)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            // Handle file upload if new file is provided
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($materi->file_path) {
                    Storage::disk('public')->delete($materi->file_path);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('materi/files', $fileName, 'public');
                $validatedData['file_path'] = $filePath;
            }

            // Handle thumbnail upload if new file is provided
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($materi->thumbnail) {
                    Storage::disk('public')->delete($materi->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')->store('materi/thumbnails', 'public');
                $validatedData['thumbnail'] = $thumbnailPath;
            }

            $materi->update($validatedData);

            DB::commit();

            return redirect()
                ->route('guru_bk.materi')
                ->with('success', 'Materi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating materi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui materi. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified materi
     * DELETE /guru_bk/materi/{id}
     */
    public function destroy(Materi $materi)
    {
        DB::beginTransaction();

        try {
            // Check if this materi belongs to the logged-in Guru BK
            if ($materi->dibuat_oleh !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus materi ini.');
            }

            // Delete file if exists
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }

            // Delete thumbnail file if exists
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }

            $materi->delete();

            DB::commit();

            return redirect()
                ->route('guru_bk.materi.index')
                ->with('success', 'Materi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting materi: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus materi.');
        }
    }

    /**
     * Toggle status materi (Aktif/Nonaktif)
     * POST /guru_bk/materi/{id}/toggle-status
     */
    public function toggleStatus(Materi $materi)
    {
        try {
            // Check if this materi belongs to the logged-in Guru BK
            if ($materi->dibuat_oleh !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah status materi ini.');
            }

            $newStatus = $materi->status === 'Aktif' ? 'Nonaktif' : 'Aktif';
            $materi->update(['status' => $newStatus]);

            return back()->with('success', "Status materi berhasil diubah menjadi {$newStatus}.");
        } catch (\Exception $e) {
            Log::error('Error toggling materi status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengubah status materi.');
        }
    }

    // ========================================
    // STUDENT (SISWA) METHODS
    // ========================================

    /**
     * Display materi list for students
     * GET /student/materi
     */
    public function studentIndex(Request $request)
    {
        try {
            $query = Materi::with('guruBK')
                ->aktif()
                ->latest();

            // Search functionality
            if ($request->has('search') && $request->search) {
                $query->search($request->search);
            }

            // Filter by kategori
            if ($request->has('kategori') && $request->kategori) {
                $query->kategori($request->kategori);
            }

            // Filter by jenis
            if ($request->has('jenis') && $request->jenis) {
                $query->where('jenis', $request->jenis);
            }

            $materiList = $query->paginate(12);

            return view('student.materi.index', compact('materiList'));
        } catch (\Exception $e) {
            Log::error('Error fetching student materi list: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data materi.');
        }
    }

    /**
     * Display materi detail for students
     * GET /student/materi/{id}
     */
    public function studentShow(Materi $materi)
    {
        try {
            // Only show active materi to students
            if ($materi->status !== 'Aktif') {
                abort(404, 'Materi tidak ditemukan.');
            }

            $materi->load('guruBK');

            // Get related materi (same category, active, exclude current)
            $relatedMateri = Materi::aktif()
                ->where('kategori', $materi->kategori)
                ->where('id', '!=', $materi->id)
                ->limit(4)
                ->get();

            return view('student.materi.show', compact('materi', 'relatedMateri'));
        } catch (\Exception $e) {
            Log::error('Error showing student materi detail: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail materi.');
        }
    }
}
