@extends('layouts.app-admin')

@section('title', 'Management Pengguna')

@section('content')
<div class="p-6 pt-20">
    <!-- Header with Premium Design -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">Management Pengguna</h1>
        <p class="text-gray-600">Overview dan kelola semua pengguna sistem Educounsel</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengguna -->
        <div class="group bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20 hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <span class="text-xs font-bold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">352</h3>
            <p class="text-sm text-gray-600">Total Pengguna</p>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-xs text-green-600 font-semibold"><i class="fas fa-arrow-up mr-1"></i> +12% dari bulan lalu</p>
            </div>
        </div>

        <!-- Admin -->
        <div class="group bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20 hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-shield text-white text-xl"></i>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Admin</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">5</h3>
            <p class="text-sm text-gray-600">Administrator</p>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-500"><i class="fas fa-check-circle mr-1 text-green-500"></i> Semua aktif</p>
            </div>
        </div>

        <!-- Guru BK -->
        <div class="group bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20 hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-100 px-3 py-1 rounded-full">Guru BK</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">12</h3>
            <p class="text-sm text-gray-600">Guru BK</p>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-500"><i class="fas fa-user-check mr-1 text-green-500"></i> 10 online</p>
            </div>
        </div>

        <!-- Siswa -->
        <div class="group bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20 hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate text-white text-xl"></i>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-100 px-3 py-1 rounded-full">Siswa</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">335</h3>
            <p class="text-sm text-gray-600">Siswa Aktif</p>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-xs text-green-600 font-semibold"><i class="fas fa-arrow-up mr-1"></i> +15 siswa baru</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Quick Add User -->
        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Tambah Pengguna Baru</h3>
                    <p class="text-purple-100">Buat akun baru untuk sistem</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.tambah-akun') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 rounded-xl hover:shadow-lg transition-all font-semibold mt-4">
                <i class="fas fa-plus mr-2"></i> Tambah Sekarang
            </a>
        </div>

        <!-- View All Users -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Lihat Semua Pengguna</h3>
                    <p class="text-blue-100">Kelola dan edit data pengguna</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <i class="fas fa-list text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.daftar-pengguna') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-xl hover:shadow-lg transition-all font-semibold mt-4">
                <i class="fas fa-arrow-right mr-2"></i> Lihat Daftar
            </a>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">Pengguna Terbaru</h3>
            <a href="{{ route('admin.daftar-pengguna') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="space-y-4">
            @for($i = 0; $i < 5; $i++)
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl hover:shadow-md transition-all">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold mr-4">
                        {{ substr(['Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari', 'Eko Prasetyo'][$i], 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ ['Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari', 'Eko Prasetyo'][$i] }}</h4>
                        <p class="text-sm text-gray-600">{{ ['Siswa - XI RPL 1', 'Guru BK', 'Siswa - XII TKJ 2', 'Admin', 'Siswa - X MM 1'][$i] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </span>
                    <span class="text-xs text-gray-500">{{ ['2 jam lalu', '5 jam lalu', '1 hari lalu', '2 hari lalu', '3 hari lalu'][$i] }}</span>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>
@endsection
