@extends('layouts.app-guru-bk')

@section('title', 'Detail Absensi Siswa')

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
                <a href="{{ route('guru_bk.rekap-absensi') }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">Detail Absensi Siswa</h1>
                    <p class="text-gray-500 text-xs">
                        {{ isset($siswa) ? $siswa->nama . ' - ' . ($siswa->kelas ? $siswa->kelas->nama_kelas : '-') : 'Detail kehadiran siswa' }}
                    </p>
                </div>
            </div>
            <!-- Ilustrasi Kanan -->
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Chat Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Hadir -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-green-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ isset($stats) ? $stats['hadir'] : 0 }}</div>
            <div class="text-gray-600 text-xs">Total Hadir</div>
        </div>

        <!-- Total Izin & Sakit -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-yellow-400"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ isset($stats) ? $stats['izin'] : 0 }}</div>
            <div class="text-gray-600 text-xs">Total Izin & Sakit</div>
        </div>

        <!-- Total Alpha -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-red-500"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ isset($stats) ? $stats['alpha'] : 0 }}</div>
            <div class="text-gray-600 text-xs">Total Alpha</div>
        </div>

        <!-- Total Terlambat -->
        <div class="bg-white rounded-xl shadow-sm p-4 text-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-orange-400"></div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ isset($stats) ? $stats['terlambat'] : 0 }}</div>
            <div class="text-gray-600 text-xs">Total Terlambat</div>
        </div>
    </div>

    <!-- Tabel Data Kehadiran -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-4 px-6 text-left text-gray-700 font-semibold">Nama</th>
                        <th class="py-4 px-6 text-left text-gray-700 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 text-left text-gray-700 font-semibold">Waktu</th>
                        <th class="py-4 px-6 text-left text-gray-700 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensiList as $absensi)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <!-- Nama -->
                        <td class="py-4 px-6 text-gray-800 font-medium">
                            {{ $siswa->nama }}
                        </td>
                        
                        <!-- Tanggal -->
                        <td class="py-4 px-6 text-gray-800">
                            {{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        
                        <!-- Waktu & Status -->
                        <td class="py-4 px-6">
                            @if($absensi->status == 'hadir')
                                @php
                                    $waktuMasuk = \Carbon\Carbon::parse($absensi->waktu_masuk);
                                    $isTerlambat = $waktuMasuk->format('H:i:s') > '07:00:00';
                                @endphp
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $isTerlambat ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                                        <i class="fas fa-clock mr-1 text-xs"></i>
                                        {{ $waktuMasuk->format('H:i') }}
                                    </span>
                                    @if($isTerlambat)
                                        <span class="text-xs text-orange-600">Terlambat</span>
                                    @endif
                                </div>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($absensi->status == 'izin') bg-yellow-100 text-yellow-800
                                    @elseif($absensi->status == 'sakit') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            @endif
                        </td>
                        
                        <!-- Keterangan -->
                        <td class="py-4 px-6">
                            @if($absensi->keterangan)
                                <span class="text-gray-700 text-sm">{{ $absensi->keterangan }}</span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                                <p class="font-medium">Belum ada data absensi</p>
                                <p class="text-sm">Siswa ini belum pernah melakukan absensi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $absensiList->firstItem() ?? 0 }} - {{ $absensiList->lastItem() ?? 0 }} 
                    dari {{ $absensiList->total() }} data absensi
                </p>
                
                <!-- Custom Pagination Design -->
                <div class="flex items-center gap-2">
                    @if ($absensiList->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-300 rounded-lg cursor-not-allowed">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    @else
                        <a href="{{ $absensiList->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    
                    @foreach(range(1, $absensiList->lastPage()) as $page)
                        @if($page == $absensiList->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-purple-600 text-white rounded-lg font-semibold">
                                {{ $page }}
                            </span>
                        @elseif($page == 1 || $page == $absensiList->lastPage() || abs($page - $absensiList->currentPage()) <= 1)
                            <a href="{{ $absensiList->url($page) }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 border border-gray-200 rounded-lg hover:bg-purple-50 transition-all font-medium">
                                {{ $page }}
                            </a>
                        @elseif(abs($page - $absensiList->currentPage()) == 2)
                            <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
                        @endif
                    @endforeach
                    
                    @if ($absensiList->hasMorePages())
                        <a href="{{ $absensiList->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-all">
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
