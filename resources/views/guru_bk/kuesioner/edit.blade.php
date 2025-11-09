@extends('layouts.app-guru-bk')

@section('title', 'Edit Kuesioner')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    * { font-family: 'Roboto', sans-serif; }
</style>

<div class="p-6 pt-20">
    <div class="bg-gradient-to-r from-purple-100 to-purple-50 rounded-xl p-5 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('guru_bk.kuesioner.show', $kuesioner->id) }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">Edit Kuesioner</h1>
                    <p class="text-gray-500 text-xs">{{ $kuesioner->judul }}</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('guru_bk.kuesioner.update', $kuesioner->id) }}" method="POST" id="kuesionerForm">
        @csrf
        @method('PUT')
        
        <!-- Section 1: Informasi Kuesioner -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Kuesioner</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kuesioner *</label>
                    <input type="text" name="judul" value="{{ old('judul', $kuesioner->judul) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kuesioner *</label>
                    <select name="jenis_kuesioner_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                        @foreach($jenisKuesioner ?? [] as $jenis)
                            <option value="{{ $jenis->id }}" {{ $kuesioner->jenis_kuesioner_id == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_kuesioner }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kadaluarsa</label>
                    <input type="date" name="expired_at" 
                           value="{{ old('expired_at', $kuesioner->expired_at ? $kuesioner->expired_at->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('deskripsi', $kuesioner->deskripsi) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Note if has responses -->
        @if($kuesioner->jawaban_count > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                <div>
                    <p class="font-medium text-yellow-800">Perhatian!</p>
                    <p class="text-sm text-yellow-700">Kuesioner ini sudah memiliki {{ $kuesioner->jawaban_count }} responden. Mengubah pertanyaan dapat mempengaruhi konsistensi data.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Halaman edit mirip dengan create, user akan edit dari show page -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <p class="text-gray-600 text-center py-4">
                Untuk mengedit pertanyaan, silakan hapus dan buat kuesioner baru, atau hubungi administrator.
            </p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('guru_bk.kuesioner.show', $kuesioner->id) }}" 
               class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-medium">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md font-medium">
                <i class="fas fa-save mr-2"></i>Update Kuesioner
            </button>
        </div>
    </form>
</div>
@endsection
