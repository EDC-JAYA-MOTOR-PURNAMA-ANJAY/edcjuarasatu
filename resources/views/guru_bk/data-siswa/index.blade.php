@extends('layouts.app-guru-bk')

@section('title', 'Data Siswa - Guru BK')

@section('content')
<div class="max-w-full mx-auto px-6 py-4">
    <!-- Gradient Header dengan Icon -->
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
                    <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
                    <p class="text-gray-600 text-sm mt-0.5">Data Siswa di halaman ini</p>
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

    <!-- Page Title -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Siswa</h2>

    <!-- Search & Filter Row -->
    <div class="flex items-center justify-between mb-4 gap-4">
        <!-- Search Box -->
        <div class="flex-1 max-w-md">
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Telusuri" 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Filter Button -->
        <button class="flex items-center space-x-2 px-4 py-2.5 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="text-gray-700 font-medium">Filter</span>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Simple Table -->
    <div class="bg-white rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-sm font-medium text-gray-500">
                            Detail
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50/50 transition-colors border-b border-gray-100">
                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                            {{ $student->nis_nip ?? '-' }}
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                            {{ $student->nama }}
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <div class="flex justify-center">
                                <a href="{{ route('guru_bk.data-siswa.show', $student->id) }}" class="hover:opacity-70 transition-opacity">
                                    <img src="{{ asset('images/icon/eyes.png') }}" alt="Detail" class="w-6 h-6">
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">Belum ada data siswa</p>
                                <p class="text-sm">Data siswa akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-5 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold">10</span> dari <span class="font-semibold">100</span> data
                </div>
                <div class="flex items-center space-x-1">
                    <!-- Previous Button -->
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Page 1 (Active) -->
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-purple-600 text-white text-sm font-semibold shadow-sm hover:bg-purple-700 transition-all">
                        1
                    </button>
                    
                    <!-- Page 2 -->
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-all">
                        2
                    </button>
                    
                    <!-- Separator -->
                    <span class="px-2 text-gray-400">...</span>
                    
                    <!-- Last Page -->
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-all">
                        6
                    </button>
                    
                    <!-- Next Button -->
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const nis = row.cells[0]?.textContent.toLowerCase() || '';
                const nama = row.cells[1]?.textContent.toLowerCase() || '';
                const searchString = nis + ' ' + nama;
                
                if (searchString.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Detail link click - no additional handler needed, uses href directly
</script>
@endpush
