@extends('layouts.app-guru-bk')

@section('title', 'Detail Kuesioner')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    * {
        font-family: 'Roboto', sans-serif;
    }
</style>

<div class="p-6 pt-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-100 to-purple-50 rounded-xl p-5 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('guru_bk.kuesioner.index') }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">{{ $kuesioner->judul }}</h1>
                    <p class="text-gray-500 text-xs">{{ $kuesioner->jenisKuesioner->nama_kuesioner ?? 'Umum' }}</p>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Detail Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Total Pertanyaan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $kuesioner->pertanyaan_count }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Total Responden</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $kuesioner->jawaban_count }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Status</p>
                    <p class="text-lg font-bold {{ $kuesioner->expired_at && $kuesioner->expired_at < now() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $kuesioner->expired_at && $kuesioner->expired_at < now() ? 'Expired' : 'Aktif' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 mb-6">
        <a href="{{ route('guru_bk.kuesioner.edit', $kuesioner->id) }}" 
           class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all text-sm font-medium">
            <i class="fas fa-edit mr-2"></i>Edit Kuesioner
        </a>
        <button onclick="confirmDelete({{ $kuesioner->id }})" 
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all text-sm font-medium">
            <i class="fas fa-trash mr-2"></i>Hapus
        </button>
    </div>

    <!-- Kuesioner Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Kuesioner</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <p class="text-sm text-gray-500">Dibuat oleh</p>
                <p class="font-medium">{{ $kuesioner->creator->nama ?? 'Unknown' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                <p class="font-medium">{{ $kuesioner->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Kadaluarsa</p>
                <p class="font-medium">{{ $kuesioner->expired_at ? $kuesioner->expired_at->format('d M Y') : 'Tidak ada' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Kuesioner</p>
                <p class="font-medium">{{ $kuesioner->jenisKuesioner->nama_kuesioner ?? 'Umum' }}</p>
            </div>
        </div>

        @if($kuesioner->deskripsi)
        <div>
            <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
            <p class="text-gray-700">{{ $kuesioner->deskripsi }}</p>
        </div>
        @endif
    </div>

    <!-- Pertanyaan List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Daftar Pertanyaan</h2>
        
        <div class="space-y-4">
            @foreach($kuesioner->pertanyaan as $index => $pertanyaan)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-purple-600">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 mb-2">{{ $pertanyaan->pertanyaan }}</p>
                        
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">
                                {{ ucfirst(str_replace('_', ' ', $pertanyaan->tipe_jawaban)) }}
                            </span>
                        </div>

                        @if($pertanyaan->opsi_jawaban && count($pertanyaan->opsi_jawaban) > 0)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Opsi Jawaban:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($pertanyaan->opsi_jawaban as $opsi)
                                <li class="text-sm text-gray-700">{{ $opsi }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kuesioner ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/guru_bk/kuesioner/${id}`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
