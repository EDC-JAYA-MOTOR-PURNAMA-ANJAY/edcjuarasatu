<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Guru BK can create materi
        return auth()->check() && auth()->user()->hasRole('guru_bk');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'jenis' => 'required|in:Artikel,Video Link,Video Upload,PDF,Gambar,Audio,Dokumen Office',
            'judul' => 'required|string|max:255',
            'konten' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048', // Max 2MB
            'kategori' => 'required|in:Motivasi,Akademik,Kesehatan Mental,Karier',
            'target_kelas' => 'required|in:Semua Kelas,Kelas X,Kelas XI,Kelas XII',
            'deskripsi_singkat' => 'nullable|string|max:200',
            'durasi_menit' => 'nullable|integer|min:1',
            'total_halaman' => 'nullable|integer|min:1',
        ];
        
        // Dynamic file validation based on jenis
        $jenis = $this->input('jenis');
        
        if ($jenis === 'Video Upload') {
            $rules['file'] = 'required|file|mimes:mp4,webm,ogg,mov,avi|max:102400'; // Max 100MB
        } elseif ($jenis === 'PDF') {
            $rules['file'] = 'required|file|mimes:pdf|max:10240'; // Max 10MB
        } elseif ($jenis === 'Gambar') {
            $rules['file'] = 'required|file|mimes:jpeg,jpg,png,gif,svg,webp|max:5120'; // Max 5MB
        } elseif ($jenis === 'Audio') {
            $rules['file'] = 'required|file|mimes:mp3,wav,ogg,m4a|max:20480'; // Max 20MB
        } elseif ($jenis === 'Dokumen Office') {
            $rules['file'] = 'required|file|mimes:doc,docx,ppt,pptx,xls,xlsx|max:10240'; // Max 10MB
        } elseif ($jenis === 'Artikel' || $jenis === 'Video Link') {
            $rules['konten'] = 'required|string';
        }
        
        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [
            'jenis.required' => 'Jenis konten harus dipilih.',
            'jenis.in' => 'Jenis konten tidak valid.',
            'judul.required' => 'Judul materi harus diisi.',
            'judul.max' => 'Judul materi maksimal 255 karakter.',
            'konten.required' => 'Konten materi harus diisi.',
            'file.required' => 'File harus diupload.',
            'file.file' => 'File harus berupa dokumen yang valid.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail harus jpeg, jpg, png, webp, atau svg.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'kategori.required' => 'Kategori harus dipilih.',
            'kategori.in' => 'Kategori tidak valid.',
            'target_kelas.required' => 'Target kelas harus dipilih.',
            'target_kelas.in' => 'Target kelas tidak valid.',
        ];
        
        // Dynamic messages based on jenis
        $jenis = $this->input('jenis');
        
        if ($jenis === 'Video Upload') {
            $messages['file.mimes'] = 'Format video harus MP4, WebM, OGG, MOV, atau AVI.';
            $messages['file.max'] = 'Ukuran video maksimal 100MB.';
        } elseif ($jenis === 'PDF') {
            $messages['file.mimes'] = 'Format file harus PDF.';
            $messages['file.max'] = 'Ukuran file maksimal 10MB.';
        } elseif ($jenis === 'Gambar') {
            $messages['file.mimes'] = 'Format gambar harus JPG, PNG, GIF, SVG, atau WebP.';
            $messages['file.max'] = 'Ukuran gambar maksimal 5MB.';
        } elseif ($jenis === 'Audio') {
            $messages['file.mimes'] = 'Format audio harus MP3, WAV, OGG, atau M4A.';
            $messages['file.max'] = 'Ukuran audio maksimal 20MB.';
        } elseif ($jenis === 'Dokumen Office') {
            $messages['file.mimes'] = 'Format dokumen harus DOC, DOCX, PPT, PPTX, XLS, atau XLSX.';
            $messages['file.max'] = 'Ukuran dokumen maksimal 10MB.';
        }
        
        return $messages;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'jenis' => 'jenis konten',
            'judul' => 'judul materi',
            'konten' => 'konten materi',
            'thumbnail' => 'thumbnail',
            'kategori' => 'kategori',
            'target_kelas' => 'target kelas',
        ];
    }
}
