<!-- Sidebar -->
<aside class="fixed left-0 top-0 w-64 h-full bg-white shadow-xl z-40 overflow-y-auto">
    <!-- Header dengan Logo -->
    <div class="p-6">
        <div class="flex items-center justify-center">
            <!-- Logo Educounsel -->
            <img src="{{ asset('images/EDClogo.svg') }}" alt="educounsel" class="h-8 w-auto">
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1">
        <!-- General Section -->
        <div class="mb-2">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">General</div>

            <!-- Dashboard -->
            <a href="{{ route('guru_bk.dashboard') }}"
               class="dashboard-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/board.svg') }}" alt="Dashboard" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium flex-1">Dashboard</span>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded-full group-hover:bg-purple-600 group-hover:text-white group-active:bg-white group-active:text-purple-700">
                    3
                </span>
            </a>
        </div>

        <!-- Manajemen Konseling -->
        <div class="mb-2">
            <a href="{{ route('guru_bk.konseling.hasil') }}"
               class="konseling-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/MK.svg') }}" alt="Manajemen Konseling" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Manajemen Konseling</span>
            </a>
        </div>

        <!-- Data Siswa -->
        <div class="mb-2">
            <a href="{{ route('guru_bk.data-siswa') }}"
               class="data-siswa-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/DS.svg') }}" alt="Data Siswa" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Data Siswa</span>
            </a>
        </div>

        <!-- Laporan Bulanan -->
        <div class="mb-2">
            <a href="#"
               class="laporan-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/LB.svg') }}" alt="Laporan Bulanan" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Laporan Bulanan</span>
            </a>
        </div>

        <!-- Materi -->
        <div class="mb-2">
            <a href="{{ route('guru_bk.materi.index') }}"
               class="materi-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/MT.svg') }}" alt="Materi" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Materi</span>
            </a>
        </div>

        <!-- Analisis Angket -->
        <div class="mb-2">
            <a href="{{ route('guru_bk.analisis') }}"
               class="analisis-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/AA.svg') }}" alt="Analisis Angket" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Analisis Angket</span>
            </a>
        </div>

        <!-- Setting Section -->
        <div class="mb-2">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Setting</div>

            <a href=""
               class="panduan-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/tanya.png') }}" alt="Panduan Bantuan" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Panduan Bantuan</span>
            </a>

            <a href=""
               class="pengaturan-menu flex items-center px-3 py-3 text-gray-700 rounded-lg mb-1 transition-all duration-200 group hover:bg-purple-50 hover:text-purple-700 hover:rounded-xl hover:shadow-sm active:bg-purple-600 active:text-white">
                <img src="{{ asset('images/icon/setting.png') }}" alt="Pengaturan" class="w-4 h-4 mr-3 group-hover:brightness-0 group-hover:invert group-hover:sepia-0 group-hover:hue-rotate-90 group-hover:saturate-10000 group-active:brightness-0 group-active:invert">
                <span class="text-sm font-medium">Pengaturan</span>
            </a>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-3 text-red-600 rounded-lg mb-1 transition-all duration-200 group hover:bg-red-50 hover:rounded-xl hover:shadow-sm">
                    <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                    <span class="text-sm font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

<!-- Overlay for Mobile -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" id="sidebarOverlay" style="display: none;"></div>

<script>
    // Dropdown toggle functionality - FIXED: Tidak menutup dropdown lainnya
    function toggleDropdown(menu) {
        const dropdown = document.getElementById(`${menu}-dropdown`);
        const arrow = document.getElementById(`${menu}-arrow`);

        // Hanya toggle dropdown yang diklik, tidak menutup yang lain
        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    // Mobile sidebar functionality
    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.style.display = 'block';
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.style.display = 'none';
        }
    }

    // Close sidebar when clicking overlay
    document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
        toggleSidebar();
    });

    // Active menu management - FIXED: Masalah icon hilang
    let currentActiveMenu = null;

    function setActiveMenu(menuElement) {
        // Remove active class from all menus
        document.querySelectorAll('.dashboard-menu, .konseling-menu, .data-siswa-menu, .laporan-menu, .materi-menu, .analisis-menu, .panduan-menu, .pengaturan-menu').forEach(menu => {
            menu.classList.remove('bg-purple-600', 'text-white', 'shadow-md');
            menu.classList.add('text-gray-700');
            
            // Reset semua ikon ke state normal
            const icons = menu.querySelectorAll('img');
            icons.forEach(icon => {
                if (!icon.id.includes('arrow')) {
                    icon.classList.remove('brightness-0', 'invert');
                }
            });
            
            // Reset badge
            const badge = menu.querySelector('span.bg-purple-100');
            if (badge) {
                badge.classList.remove('bg-white', 'text-purple-700');
                badge.classList.add('bg-purple-100', 'text-purple-700');
            }
        });

        // Add active class to clicked menu
        menuElement.classList.remove('text-gray-700');
        menuElement.classList.add('bg-purple-600', 'text-white', 'shadow-md');

        // Update icon color - FIXED: Menggunakan filter CSS yang benar
        const icons = menuElement.querySelectorAll('img');
        icons.forEach(icon => {
            if (!icon.id.includes('arrow')) {
                icon.classList.add('brightness-0', 'invert');
            }
        });
        
        // Update badge
        const badge = menuElement.querySelector('span.bg-purple-100');
        if (badge) {
            badge.classList.remove('bg-purple-100', 'text-purple-700');
            badge.classList.add('bg-white', 'text-purple-700');
        }

        currentActiveMenu = menuElement;
    }

    // Initialize active menu based on current page
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        // Map routes to menu classes
        const routeMap = {
            '/guru_bk/dashboard': '.dashboard-menu',
            '/guru_bk/konseling': '.konseling-menu',
            '/guru_bk/data-siswa': '.data-siswa-menu',
            '/guru_bk/laporan': '.laporan-menu',
            '/guru_bk/materi': '.materi-menu',
            '/guru_bk/analisis': '.analisis-menu',
            '/guru_bk/panduan': '.panduan-menu',
            '/guru_bk/pengaturan': '.pengaturan-menu'
        };

        // Find matching menu and set active
        for (const [route, menuClass] of Object.entries(routeMap)) {
            if (currentPath === route || currentPath.startsWith(route + '/')) {
                const menuElement = document.querySelector(menuClass);
                if (menuElement) {
                    setActiveMenu(menuElement);
                }
                break;
            }
        }

        // Add click event listeners to all menu items
        document.querySelectorAll('a.dashboard-menu, a.konseling-menu, a.data-siswa-menu, a.laporan-menu, a.materi-menu, a.analisis-menu, a.panduan-menu, a.pengaturan-menu').forEach(menu => {
            menu.addEventListener('click', function() {
                setActiveMenu(this);
            });
        });
    });
</script>

<style>
    /* Import Roboto font */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

    /* Custom scrollbar for sidebar */
    aside::-webkit-scrollbar {
        width: 4px;
    }

    aside::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    aside::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    aside::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease-in-out;
    }

    /* Rotate animation for dropdown arrows */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Font family */
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    /* Custom styles untuk efek hover dan active */
    .group:hover .group-hover\:brightness-0 {
        filter: brightness(0);
    }
    
    .group:hover .group-hover\:invert {
        filter: invert(1);
    }
    
    .group:hover .group-hover\:sepia-0 {
        filter: sepia(0);
    }
    
    .group:hover .group-hover\:hue-rotate-90 {
        filter: hue-rotate(90deg);
    }
    
    .group:hover .group-hover\:saturate-10000 {
        filter: saturate(10000%);
    }
</style>