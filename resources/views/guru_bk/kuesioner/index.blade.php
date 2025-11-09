@extends('layouts.app-guru-bk')

@section('title', 'Daftar Kuesioner')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    
    * {
        font-family: 'Roboto', sans-serif;
    }
</style>

<div class="p-6 pt-20">
    <!-- Header dengan background ungu muda dan ilustrasi -->
    <div class="bg-gradient-to-r from-purple-100 to-purple-50 rounded-xl p-5 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">Daftar Kuesioner</h1>
                    <p class="text-gray-500 text-xs">Kelola kuesioner untuk siswa</p>
                </div>
            </div>
            <!-- Ilustrasi Kanan -->
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Kuesioner Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Kuesioner -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-purple-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $totalKuesioner ?? 0 }}</div>
            <div class="text-gray-600 text-xs">Total Kuesioner</div>
        </div>

        <!-- Kuesioner Aktif -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-green-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $aktif ?? 0 }}</div>
            <div class="text-gray-600 text-xs">Kuesioner Aktif</div>
        </div>

        <!-- Total Responden -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-blue-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $totalResponden ?? 0 }}</div>
            <div class="text-gray-600 text-xs">Total Responden</div>
        </div>

        <!-- Expired -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-red-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $expired ?? 0 }}</div>
            <div class="text-gray-600 text-xs">Kadaluarsa</div>
        </div>
    </div>

    <!-- Button Tambah & Search -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            <!-- Button Tambah -->
            <a href="{{ route('guru_bk.kuesioner.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md hover:shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                <span class="font-medium text-sm">Tambah Kuesioner</span>
            </a>

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('guru_bk.kuesioner.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 sm:max-w-2xl">
                <!-- Search -->
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul kuesioner..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>

                <!-- Filter Status -->
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all text-sm font-medium">
                        Cari
                    </button>
                    <a href="{{ route('guru_bk.kuesioner.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all text-sm font-medium">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kuesioner -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold text-sm">No</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold text-sm">Judul Kuesioner</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold text-sm">Jenis</th>
                        <th class="py-3 px-4 text-center text-gray-700 font-semibold text-sm">Pertanyaan</th>
                        <th class="py-3 px-4 text-center text-gray-700 font-semibold text-sm">Responden</th>
                        <th class="py-3 px-4 text-center text-gray-700 font-semibold text-sm">Status</th>
                        <th class="py-3 px-4 text-center text-gray-700 font-semibold text-sm">Expired</th>
                        <th class="py-3 px-4 text-center text-gray-700 font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kuesionerList ?? [] as $index => $kuesioner)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-gray-700 text-sm">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">{{ $kuesioner->judul ?? 'Untitled' }}</span>
                                    <span class="text-xs text-gray-500">{{ Str::limit($kuesioner->deskripsi ?? '', 50) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                    {{ $kuesioner->jenisKuesioner->nama_kuesioner ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                    {{ $kuesioner->pertanyaan_count ?? 0 }} soal
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    {{ $kuesioner->jawaban_count ?? 0 }} siswa
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($kuesioner->expired_at && $kuesioner->expired_at < now())
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        Expired
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center text-xs text-gray-600">
                                {{ $kuesioner->expired_at ? \Carbon\Carbon::parse($kuesioner->expired_at)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('guru_bk.kuesioner.show', $kuesioner->id) }}" 
                                       class="p-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('guru_bk.kuesioner.edit', $kuesioner->id) }}" 
                                       class="p-1.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all" 
                                       title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $kuesioner->id }})" 
                                            class="p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all" 
                                            title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                    <p class="font-medium">Belum ada kuesioner</p>
                                    <p class="text-sm">Klik tombol "Tambah Kuesioner" untuk membuat kuesioner baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        @if(isset($kuesionerList) && $kuesionerList->hasPages())
        <div class="px-4 py-4 border-t border-gray-200 bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $kuesionerList->firstItem() ?? 0 }} - {{ $kuesionerList->lastItem() ?? 0 }} 
                    dari {{ $kuesionerList->total() }} kuesioner
                </p>
                
                <!-- Custom Pagination Design -->
                <div class="flex items-center gap-2">
                    @if ($kuesionerList->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-300 rounded-lg cursor-not-allowed">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    @else
                        <a href="{{ $kuesionerList->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    
                    @foreach(range(1, $kuesionerList->lastPage()) as $page)
                        @if($page == $kuesionerList->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-purple-600 text-white rounded-lg font-semibold">
                                {{ $page }}
                            </span>
                        @elseif($page == 1 || $page == $kuesionerList->lastPage() || abs($page - $kuesionerList->currentPage()) <= 1)
                            <a href="{{ $kuesionerList->url($page) }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 border border-gray-200 rounded-lg hover:bg-purple-50 transition-all font-medium">
                                {{ $page }}
                            </a>
                        @elseif(abs($page - $kuesionerList->currentPage()) == 2)
                            <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
                        @endif
                    @endforeach
                    
                    @if ($kuesionerList->hasMorePages())
                        <a href="{{ $kuesionerList->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-300 rounded-lg cursor-not-allowed">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kuesioner ini? Data yang dihapus tidak dapat dikembalikan.')) {
        // Submit delete form
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
