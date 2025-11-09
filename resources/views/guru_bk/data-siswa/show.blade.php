@extends('layouts.app-guru-bk')

@section('title', 'Profile Lengkap Siswa - Guru BK')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-4">
    <!-- Gradient Header -->
    <div class="bg-gradient-to-r from-purple-100 via-pink-50 to-purple-100 rounded-2xl p-6 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between relative z-10">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <button onclick="window.history.back()" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/50 transition-all">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Profile Lengkap Siswa</h1>
                    <p class="text-gray-600 text-sm mt-0.5">Profile Lengkap Siswa di halaman ini</p>
                </div>
            </div>
            <!-- Icon Ilustrasi -->
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Chat Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
        <!-- Decorative circles -->
        <div class="absolute top-0 right-20 w-32 h-32 bg-purple-200 rounded-full opacity-20 blur-2xl"></div>
        <div class="absolute bottom-0 left-20 w-24 h-24 bg-pink-200 rounded-full opacity-20 blur-xl"></div>
    </div>

    <!-- Biodata Siswa Section -->
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Biodata Siswa</h2>
        
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
                <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-purple-100 shadow-lg">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->nama) }}&size=200&background=7c3aed&color=fff" 
                         alt="{{ $student->nama }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Biodata Grid -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">NIS :</label>
                        <p class="text-gray-900 font-medium">{{ $student->nis_nip ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">NISN :</label>
                        <p class="text-gray-900 font-medium">-</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama :</label>
                        <p class="text-gray-900 font-medium">{{ $student->nama }}</p>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Kelas / No. Absen :</label>
                        <p class="text-gray-900 font-medium">{{ $student->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Alamat :</label>
                        <p class="text-gray-900 font-medium">{{ $student->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">No. Hp :</label>
                        <p class="text-gray-900 font-medium">{{ $student->no_telepon ?? '-' }}</p>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Orang Tua :</label>
                        <p class="text-gray-900 font-medium">-</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin :</label>
                        <p class="text-gray-900 font-medium">{{ $student->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email :</label>
                        <p class="text-gray-900 font-medium">{{ $student->email ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Konseling Siswa Section -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Konseling Siswa</h2>
            <button class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-all text-sm font-medium">
                Tambah Konseling
            </button>
        </div>

        <!-- Table Riwayat Konseling -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Guru BK</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konselingHistory as $konseling)
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $konseling->created_at->format('d - m - Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $konseling->guruBK->nama ?? 'Guru BK' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $konseling->deskripsi_masalah ?? $konseling->topik ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                            <p class="text-sm">Belum ada riwayat konseling</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
