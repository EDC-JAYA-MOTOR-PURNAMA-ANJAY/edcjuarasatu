<aside class="fixed left-0 top-0 z-40 h-screen w-64 bg-white shadow-xl transition-transform">
    <div class="flex h-full flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                    <span class="text-sm font-bold text-white">E</span>
                </div>
                <span class="text-xl font-bold text-gray-800">educounsel</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-4 py-4">
            <!-- General Section -->
            <div class="mb-4">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">General</p>
                <ul class="mt-1 space-y-1">
                    <li>
                        <a href="{{ route('student.dashboard') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/dashboard-icon.png" alt="Dashboard" class="h-5 w-5">
                            <span>Dashboard</span>
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">3</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Menu -->
            <div class="mb-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('student.attendance') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->routeIs('student.attendance') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/absensi-icon.png" alt="Absensi" class="h-5 w-5">
                            <span>Absensi</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('student.counseling.create') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->routeIs('student.counseling.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/ajukan-konseling-icon.png" alt="Ajukan Konseling" class="h-5 w-5">
                            <span>Ajukan Konseling</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('student.counseling.schedule') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100">
                            <img src="/icons/jadwal-konseling-icon.png" alt="Jadwal Konseling" class="h-5 w-5">
                            <span>Jadwal Konseling</span>
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">3</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('student.counseling.index') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100">
                            <img src="/icons/riwayat-konseling-icon.png" alt="Riwayat Konseling" class="h-5 w-5">
                            <span>Riwayat Konseling</span>
                        </a>
                    </li>
                    
                    <!-- Pelanggaran dengan Dropdown -->
                    <li>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="flex items-center justify-between w-full rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->routeIs('student.violation') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <img src="/icons/pelanggaran-icon.png" alt="Pelanggaran" class="h-5 w-5">
                                    <span>Pelanggaran</span>
                                </div>
                                <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 class="ml-6 mt-1 space-y-1 border-l-2 border-gray-200 pl-3">
                                <a href="{{ route('student.violation') }}" 
                                   class="flex items-center space-x-3 rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-800">
                                    <img src="/icons/riwayat-pelanggaran-icon.png" alt="Riwayat Pelanggaran" class="h-4 w-4">
                                    <span>Riwayat Pelanggaran</span>
                                </a>
                                <a href="{{ route('student.violation') }}" 
                                   class="flex items-center space-x-3 rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-800">
                                    <img src="/icons/poin-pelanggaran-icon.png" alt="Poin Pelanggaran" class="h-4 w-4">
                                    <span>Poin Pelanggaran</span>
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <a href="{{ # }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->false ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/kuesioner-icon.png" alt="Kuesioner" class="h-5 w-5">
                            <span>Kuesioner</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ # }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->false ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/materi-icon.png" alt="Materi" class="h-5 w-5">
                            <span>Materi</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Bottom Menu -->
            <div class="mt-auto space-y-1 pt-4">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Setting</p>
                <ul class="mt-1 space-y-1">
                    <li>
                        <a href="{{ # }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100 {{ request()->false ? 'bg-blue-50 text-blue-600' : '' }}">
                            <img src="/icons/panduan-icon.png" alt="Panduan Bantuan" class="h-5 w-5">
                            <span>Panduan Bantuan</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('student.profile') }}" 
                           class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100">
                            <img src="/icons/pengaturan-icon.png" alt="Pengaturan" class="h-5 w-5">
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>

<!-- Include Alpine.js untuk dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>