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
            <a href="{{ route('admin.dashboard') }}"
               class="dashboard-menu flex items-center px-3 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg mb-1 transition-colors duration-200 group">
                <img src="{{ asset('images/icon/dash.png') }}" alt="Dashboard" class="w-4 h-4 mr-3">
                <span class="text-sm font-medium flex-1">Dashboard</span>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded-full">
                    3
                </span>
            </a>
        </div>

        <!-- Manajemen Pengguna Section -->
        <div class="mb-2">
            <!-- Parent Menu -->
            <button onclick="toggleDropdown('pengguna')"
                    class="pengguna-menu flex items-center justify-between w-full px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-lg mb-1 transition-colors duration-200 group">
                <div class="flex items-center">
                    <img src="{{ asset('images/icon/man.png') }}" alt="Manajemen Pengguna" class="w-4 h-4 mr-3">
                    <span class="text-sm font-medium">Manajemen Pengguna</span>
                </div>
                <img id="pengguna-arrow" src="{{ asset('images/icon/arrow.png') }}" alt="Toggle" class="w-3 h-3 transition-transform duration-200">
            </button>

            <!-- Dropdown Submenu -->
            <div id="pengguna-dropdown" class="ml-4 space-y-1 hidden transition-all duration-200">
                <a href="{{ route('admin.tambah-akun') }}"
                   class="tambah-akun-menu flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-purple-700 rounded-lg text-sm transition-colors duration-200 group">
                    <img src="{{ asset('images/icon/user-plus.png') }}" alt="Tambah Akun" class="w-4 h-4 mr-3">
                    <span>Tambah Akun Pengguna</span>
                </a>
                <a href="{{ route('admin.daftar-pengguna') }}"
                   class="daftar-pengguna-menu flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-purple-700 rounded-lg text-sm transition-colors duration-200 group">
                    <img src="{{ asset('images/icon/list.png') }}" alt="Daftar Pengguna" class="w-4 h-4 mr-3">
                    <span>Daftar Pengguna</span>
                </a>
            </div>
        </div>

        <!-- Manajemen Sistem Section -->
        <div class="mb-2">
            <!-- Parent Menu -->
            <button onclick="toggleDropdown('sistem')"
                    class="sistem-menu flex items-center justify-between w-full px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-lg mb-1 transition-colors duration-200 group">
                <div class="flex items-center">
                    <img src="{{ asset('images/icon/sistem.png') }}" alt="Manajemen Sistem" class="w-4 h-4 mr-3">
                    <span class="text-sm font-medium">Manajemen Sistem</span>
                </div>
                <img id="sistem-arrow" src="{{ asset('images/icon/arrow.png') }}" alt="Toggle" class="w-3 h-3 transition-transform duration-200">
            </button>

            <!-- Dropdown Submenu -->
            <div id="sistem-dropdown" class="ml-4 space-y-1 hidden transition-all duration-200">
               <a href="{{ route('admin.tahun-ajaran') }}"
   class="tahun-ajaran-menu flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-purple-700 rounded-lg text-sm transition-colors duration-200 group">
    <img src="{{ asset('images/icon/calendar.png') }}" alt="" class="w-4 h-4 mr-3">
    <span>Tahun Ajaran</span>
</a>
                <a href="{{ route('admin.rekap-absensi') }}"
                   class="kelas-jurusan-menu flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-purple-700 rounded-lg text-sm transition-colors duration-200 group">
                    <img src="{{ asset('images/icon/graduation.png') }}" alt="" class="w-4 h-4 mr-3">
                    <span>Rekap Absensi</span>
                </a>
            </div>
        </div>

        <!-- Monitoring & Statistik -->
        <div class="mb-2">
            <a href=""
               class="monitoring-menu flex items-center px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-lg mb-1 transition-colors duration-200 group">
                <img src="{{ asset('images/icon/moni.png') }}" alt="Monitoring & Statistik" class="w-4 h-4 mr-3">
                <span class="text-sm font-medium">Monitoring & Statistik</span>
            </a>
        </div>

        <!-- Setting Section -->
        <div class="mb-2">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Setting</div>

            <a href=""
               class="panduan-menu flex items-center px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-lg mb-1 transition-colors duration-200 group">
                <img src="{{ asset('images/icon/tanya.png') }}" alt="Panduan Bantuan" class="w-4 h-4 mr-3">
                <span class="text-sm font-medium">Panduan Bantuan</span>
            </a>

            <a href=""
               class="pengaturan-menu flex items-center px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-lg mb-1 transition-colors duration-200 group">
                <img src="{{ asset('images/icon/setting.png') }}" alt="Pengaturan" class="w-4 h-4 mr-3">
                <span class="text-sm font-medium">Pengaturan</span>
            </a>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-3 text-red-600 hover:bg-red-50 rounded-lg mb-1 transition-colors duration-200 group">
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
        document.querySelectorAll('.dashboard-menu, .pengguna-menu, .sistem-menu, .monitoring-menu, .panduan-menu, .pengaturan-menu, .tambah-akun-menu, .daftar-pengguna-menu, .tahun-ajaran-menu, .kelas-jurusan-menu').forEach(menu => {
            menu.classList.remove('bg-purple-600', 'text-white', 'shadow-md');
            menu.classList.add('text-gray-700', 'hover:bg-gray-100');
            
            // Reset semua ikon ke state normal
            const icons = menu.querySelectorAll('img');
            icons.forEach(icon => {
                if (!icon.id.includes('arrow')) {
                    icon.classList.remove('brightness-0', 'invert-0');
                }
            });
        });

        // Remove active class from parent dropdown buttons
        document.querySelectorAll('button.pengguna-menu, button.sistem-menu').forEach(button => {
            button.classList.remove('bg-purple-600', 'text-white');
            button.classList.add('text-gray-700', 'hover:bg-gray-100');
        });

        // Add active class to clicked menu
        menuElement.classList.remove('text-gray-700', 'hover:bg-gray-100');
        menuElement.classList.add('bg-purple-600', 'text-white', 'shadow-md');

        // Update icon color - FIXED: Menggunakan filter CSS yang benar
        const icons = menuElement.querySelectorAll('img');
        icons.forEach(icon => {
            if (!icon.id.includes('arrow')) {
                icon.classList.add('brightness-0', 'invert');
            }
        });

        currentActiveMenu = menuElement;
    }

    // Initialize active menu based on current page
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        // Map routes to menu classes
        const routeMap = {
            '/admin/dashboard': '.dashboard-menu',
            '/admin/tambah-akun': '.tambah-akun-menu',
            '/admin/daftar-pengguna': '.daftar-pengguna-menu',
            '/admin/tahun-ajaran': '.tahun-ajaran-menu',
            '/admin/kelas-jurusan': '.kelas-jurusan-menu',
            '/admin/monitoring': '.monitoring-menu',
            '/admin/panduan': '.panduan-menu',
            '/admin/pengaturan': '.pengaturan-menu'
        };

        // Find matching menu and set active
        for (const [route, menuClass] of Object.entries(routeMap)) {
            if (currentPath === route || currentPath.startsWith(route + '/')) {
                const menuElement = document.querySelector(menuClass);
                if (menuElement) {
                    setActiveMenu(menuElement);

                    // Auto-expand parent dropdown if it's a submenu
                    if (menuClass.includes('tambah-akun') || menuClass.includes('daftar-pengguna')) {
                        document.getElementById('pengguna-dropdown')?.classList.remove('hidden');
                        document.getElementById('pengguna-arrow')?.classList.add('rotate-180');
                    }
                    if (menuClass.includes('tahun-ajaran') || menuClass.includes('kelas-jurusan')) {
                        document.getElementById('sistem-dropdown')?.classList.remove('hidden');
                        document.getElementById('sistem-arrow')?.classList.add('rotate-180');
                    }
                }
                break;
            }
        }

        // Add click event listeners to all menu items
        document.querySelectorAll('a.dashboard-menu, a.monitoring-menu, a.panduan-menu, a.pengaturan-menu, a.tambah-akun-menu, a.daftar-pengguna-menu, a.tahun-ajaran-menu, a.kelas-jurusan-menu').forEach(menu => {
            menu.addEventListener('click', function() {
                setActiveMenu(this);
            });
        });

        // Add click event listeners to dropdown buttons
        document.querySelectorAll('button.pengguna-menu, button.sistem-menu').forEach(button => {
            button.addEventListener('click', function() {
                // Only set active if it's a direct click (not from toggle)
                if (!this.classList.contains('bg-purple-600')) {
                    setActiveMenu(this);
                }
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

    /* Double hover effect for dropdown items */
    #pengguna-dropdown a:hover,
    #sistem-dropdown a:hover {
        background-color: #f3f4f6;
        color: #7c3aed;
    }
</style>