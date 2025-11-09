@extends('layouts.app-guru-bk')

@section('title', 'Rekap Absensi')

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
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">Rekap Absensi</h1>
                    <p class="text-gray-500 text-xs">Rekap Absensi di halaman ini</p>
                </div>
            </div>
            <!-- Ilustrasi Kanan -->
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Chat Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
    </div>

    <!-- Judul Konten, Search dan Filter -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Rekap Absensi Siswa</h2>
        
        <form method="GET" action="{{ route('guru_bk.rekap-absensi') }}" class="flex flex-col sm:flex-row gap-4">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau NIS siswa..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-400 transition-all"
                >
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            
            <!-- Filter Kelas -->
            <select 
                name="kelas_id" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-400 transition-all"
                onchange="this.form.submit()"
            >
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
            
            <!-- Button Search -->
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            
            @if(request('search') || request('kelas_id'))
                <a href="{{ route('guru_bk.rekap-absensi') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">No</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">NIS</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">Nama Siswa</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">Kelas</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">Absensi Terakhir</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-left">Total Absensi</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswaList as $index => $siswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- No -->
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">
                                {{ $siswaList->firstItem() + $index }}
                            </td>
                            
                            <!-- NIS -->
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700 font-medium">
                                {{ $siswa->nis_nip }}
                            </td>
                            
                            <!-- Nama Siswa -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="font-medium text-gray-800">{{ $siswa->nama }}</span>
                            </td>
                            
                            <!-- Kelas -->
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">
                                {{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}
                            </td>
                            
                            <!-- Absensi Terakhir -->
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">
                                @if($siswa->latest_absensi)
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ \Carbon\Carbon::parse($siswa->latest_absensi->tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                                        <span class="text-xs text-gray-500">
                                            Status: 
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($siswa->latest_absensi->status == 'hadir') bg-green-100 text-green-800
                                                @elseif($siswa->latest_absensi->status == 'izin') bg-yellow-100 text-yellow-800
                                                @elseif($siswa->latest_absensi->status == 'sakit') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($siswa->latest_absensi->status) }}
                                            </span>
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Belum ada absensi</span>
                                @endif
                            </td>
                            
                            <!-- Total Absensi -->
                            <td class="py-3 px-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $siswa->total_absensi > 0 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $siswa->total_absensi }} hari
                                </span>
                            </td>
                            
                            <!-- Detail -->
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('guru_bk.detail-absensi', $siswa->id) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 transition-all"
                                   title="Lihat Detail Absensi {{ $siswa->nama }}">
                                    <img src="{{ asset('images/icon/eyes.png') }}" alt="View" class="w-4 h-4 object-contain">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                    <p class="font-medium">Tidak ada data siswa</p>
                                    @if(request('search') || request('kelas_id'))
                                        <p class="text-sm">Coba ubah filter atau kata kunci pencarian</p>
                                    @else
                                        <p class="text-sm">Belum ada siswa terdaftar dalam sistem</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="px-4 py-4 border-t border-gray-200 bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $siswaList->firstItem() ?? 0 }} - {{ $siswaList->lastItem() ?? 0 }} 
                    dari {{ $siswaList->total() }} siswa
                </p>
                
                <!-- Custom Pagination Design -->
                <div class="flex items-center gap-2">
                    @if ($siswaList->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-300 rounded-lg cursor-not-allowed">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    @else
                        <a href="{{ $siswaList->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    
                    @foreach(range(1, $siswaList->lastPage()) as $page)
                        @if($page == $siswaList->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-purple-600 text-white rounded-lg font-semibold">
                                {{ $page }}
                            </span>
                        @elseif($page == 1 || $page == $siswaList->lastPage() || abs($page - $siswaList->currentPage()) <= 1)
                            <a href="{{ $siswaList->url($page) }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 border border-gray-200 rounded-lg hover:bg-purple-50 transition-all font-medium">
                                {{ $page }}
                            </a>
                        @elseif(abs($page - $siswaList->currentPage()) == 2)
                            <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
                        @endif
                    @endforeach
                    
                    @if ($siswaList->hasMorePages())
                        <a href="{{ $siswaList->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
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
    </div>
    
    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>
@endsection
