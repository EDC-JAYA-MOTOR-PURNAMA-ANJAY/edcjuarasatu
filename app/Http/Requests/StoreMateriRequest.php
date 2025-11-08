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
        return [
            'jenis' => 'required|in:Artikel,Video Link,File/Dokumen',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:10240', // Max 10MB
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048', // Max 2MB
            'kategori' => 'required|in:Motivasi,Akademik,Kesehatan Mental,Karier',
            'target_kelas' => 'required|in:Semua Kelas,Kelas X,Kelas XI,Kelas XII',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'jenis.required' => 'Jenis konten harus dipilih.',
            'jenis.in' => 'Jenis konten harus Artikel, Video Link, atau File/Dokumen.',
            'judul.required' => 'Judul materi harus diisi.',
            'judul.max' => 'Judul materi maksimal 255 karakter.',
            'konten.required' => 'Konten materi harus diisi.',
            'file.file' => 'File harus berupa dokumen yang valid.',
            'file.mimes' => 'Format file harus pdf, doc, docx, ppt, pptx, xls, xlsx, atau txt.',
            'file.max' => 'Ukuran file maksimal 10MB.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, jpg, png, webp, atau svg.',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB.',
            'kategori.required' => 'Kategori harus dipilih.',
            'kategori.in' => 'Kategori tidak valid.',
            'target_kelas.required' => 'Target kelas harus dipilih.',
            'target_kelas.in' => 'Target kelas tidak valid.',
        ];
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
