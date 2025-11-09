<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\JawabanKuesioner;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    /**
     * Display list of active questionnaires
     */
    public function index()
    {
        // Get active questionnaires (not expired or no expiry date)
        $kuesionerList = Kuesioner::with(['jenisKuesioner', 'pertanyaan'])
            ->withCount('pertanyaan')
            ->where(function($query) {
                $query->whereNull('expired_at')
                      ->orWhere('expired_at', '>=', now());
            })
            ->latest()
            ->get();

        return view('student.questionnaire.index', compact('kuesionerList'));
    }

    /**
     * Display questionnaire form
     */
    public function show($id)
    {
        $kuesioner = Kuesioner::with(['jenisKuesioner', 'pertanyaan'])
            ->where(function($query) {
                $query->whereNull('expired_at')
                      ->orWhere('expired_at', '>=', now());
            })
            ->findOrFail($id);

        // Check if student already answered
        $hasAnswered = JawabanKuesioner::where('kuesioner_id', $id)
            ->where('siswa_id', auth()->id())
            ->exists();

        if ($hasAnswered) {
            return redirect()
                ->route('student.kuesioner')
                ->with('info', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        return view('student.questionnaire.show', compact('kuesioner'));
    }

    /**
     * Store questionnaire answers
     */
    public function store(Request $request, $id)
    {
        $kuesioner = Kuesioner::findOrFail($id);

        // Validate
        $validated = $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required',
        ]);

        // Check if already answered
        $hasAnswered = JawabanKuesioner::where('kuesioner_id', $id)
            ->where('siswa_id', auth()->id())
            ->exists();

        if ($hasAnswered) {
            return redirect()
                ->route('student.kuesioner')
                ->with('error', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        // Save answers
        foreach ($validated['jawaban'] as $pertanyaanId => $jawaban) {
            JawabanKuesioner::create([
                'kuesioner_id' => $id,
                'pertanyaan_id' => $pertanyaanId,
                'siswa_id' => auth()->id(),
                'jawaban' => is_array($jawaban) ? json_encode($jawaban) : $jawaban,
            ]);
        }

        return redirect()
            ->route('student.kuesioner')
            ->with('success', 'Terima kasih! Jawaban Anda telah berhasil disimpan.');
    }
}
