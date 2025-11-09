<aside class="w-80 h-screen bg-white fixed left-0 top-0 z-50 shadow-lg overflow-y-auto">
    <!-- Logo -->
    <div class="p-6">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/EDClogo.svg') }}" alt="EduCounsel" class="h-8 w-auto">
        </div>
    </div>

    <!-- General Menu Section -->
    <div class="p-4 pt-2">
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 px-4">General</div>
        <nav class="space-y-1" id="sidebarMenu">
            <!-- Dashboard -->
            <a href="{{ route('student.dashboard') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.dashboard') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/dash.png') }}" alt="Dashboard"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.dashboard') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium flex-1 transition-all duration-200 ease-in-out">Dashboard</span>
                @if(isset($badges['total_notifications']) && $badges['total_notifications'] > 0)
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.dashboard') ? 'bg-purple-100 text-purple-700' : 'bg-purple-100 text-purple-700 group-hover:bg-purple-700 group-hover:text-white' }}">
                    {{ $badges['total_notifications'] }}
                </span>
                @endif
            </a>

            <!-- Absensi -->
            <a href="{{ route('student.attendance') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.attendance') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/absensi.png') }}" alt="Absensi"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.attendance') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Absensi</span>
            </a>

            <!-- Ajukan Konseling -->
            <a href="{{ route('student.counseling.create') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.counseling.create') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/chat.png') }}" alt="Ajukan Konseling"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.counseling.create') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Ajukan Konseling</span>
            </a>

            <!-- Jadwal Konseling -->
            <a href="{{ route('student.counseling.schedule') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.counseling.schedule') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/jadwal.png') }}" alt="Jadwal Konseling"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.counseling.schedule') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium flex-1 transition-all duration-200 ease-in-out">Jadwal Konseling</span>
                @if(isset($badges['jadwal_konseling']) && $badges['jadwal_konseling'] > 0)
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.counseling.schedule') ? 'bg-purple-100 text-purple-700' : 'bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white' }}">
                    {{ $badges['jadwal_konseling'] }}
                </span>
                @endif
            </a>

            <!-- Riwayat Konseling -->
            <a href=""
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.counseling.history') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/riwayat.png') }}" alt="Riwayat Konseling"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.counseling.history') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Riwayat Konseling</span>
            </a>

            <!-- Pelanggaran dengan Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="sidebar-menu group flex items-center justify-between w-full px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                               {{ request()->routeIs('student.violation.*') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                    <div class="flex items-center flex-1">
                        <img src="{{ asset('images/icon/pelanggaran.png') }}" alt="Pelanggaran"
                             class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                                    {{ request()->routeIs('student.violation.*') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                        <span class="text-sm font-medium transition-all duration-200 ease-in-out">Pelanggaran</span>
                        @if(isset($badges['pelanggaran']) && $badges['pelanggaran'] > 0)
                        <span class="ml-2 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold bg-red-100 text-red-600">
                            {{ $badges['pelanggaran'] }}
                        </span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 transition-all duration-200 ease-in-out"
                         :class="{ 'rotate-180': open, 'text-purple-700': open || $el.parentElement.classList.contains('bg-purple-700') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                     class="ml-8 mt-1 space-y-1 border-l-2 border-gray-200 pl-3">
                    <a href=""
                       class="sidebar-menu group flex items-center px-3 py-2 rounded-lg transition-all duration-200 ease-in-out relative
                              {{ request()->routeIs('student.violation.history') ? 'bg-purple-700 text-white shadow-sm' : 'text-gray-600 hover:bg-purple-100 hover:text-purple-700' }}">
                        <img src="" alt="" class="w-4 h-4 mr-2 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.violation.history') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                        <span class="text-sm transition-all duration-200 ease-in-out">Riwayat Pelanggaran</span>
                    </a>
                    <a href=""
                       class="sidebar-menu group flex items-center px-3 py-2 rounded-lg transition-all duration-200 ease-in-out relative
                              {{ request()->routeIs('student.violation.points') ? 'bg-purple-700 text-white shadow-sm' : 'text-gray-600 hover:bg-purple-100 hover:text-purple-700' }}">
                        <img src="" alt="" class="w-4 h-4 mr-2 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.violation.points') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                        <span class="text-sm transition-all duration-200 ease-in-out">Poin Pelanggaran</span>
                    </a>
                </div>
            </div>

            <!-- Kuesioner -->
            <a href="{{ route('student.questionnaire') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.questionnaire') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/kuesioner.png') }}" alt="Kuesioner"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.questionnaire') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Kuesioner</span>
            </a>

            <!-- Materi -->
            <a href="{{ route('student.materi') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.materi*') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/materi.png') }}" alt="Materi"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.materi*') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Materi</span>
            </a>

            <!-- Sahabat AI (NEW!) -->
            <a href="{{ route('student.ai-companion.index') }}"
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.ai-companion.*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-900 hover:bg-gradient-to-r hover:from-purple-100 hover:to-pink-100 hover:text-purple-700' }}">
                <div class="w-5 h-5 mr-3 text-lg transition-all duration-200 ease-in-out">
                    🤖
                </div>
                <span class="text-sm font-medium flex-1 transition-all duration-200 ease-in-out">EDU AI</span>
                <span class="px-2 py-0.5 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-bold rounded-full">
                    NEW
                </span>
            </a>
        </nav>
    </div>

    <!-- Setting Menu Section -->
    <div class="p-4 mt-2">
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 px-4">Setting</div>
        <nav class="space-y-1">
            <!-- Panduan Bantuan -->
            <a href=""
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.help') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/tanya.png') }}" alt="Panduan Bantuan"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.help') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Panduan Bantuan</span>
            </a>

            <!-- Pengaturan -->
            <a href=""
               class="sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative
                      {{ request()->routeIs('student.settings') ? 'bg-purple-700 text-white shadow-md' : 'text-gray-900 hover:bg-purple-100 hover:text-purple-700' }}">
                <img src="{{ asset('images/icon/setting.png') }}" alt="Pengaturan"
                     class="w-5 h-5 mr-3 transition-all duration-200 ease-in-out
                            {{ request()->routeIs('student.settings') ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert-50' }}">
                <span class="text-sm font-medium transition-all duration-200 ease-in-out">Pengaturan</span>
            </a>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full sidebar-menu group flex items-center px-4 py-3 rounded-xl transition-all duration-200 ease-in-out relative text-red-600 hover:bg-red-50 hover:text-red-700">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    <span class="text-sm font-medium transition-all duration-200 ease-in-out">Keluar</span>
                </button>
            </form>
        </nav>
    </div>
</aside>

<!-- Include Alpine.js untuk dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
/* Custom styles untuk memastikan konsistensi hover dan active states */
.sidebar-menu {
    position: relative;
    cursor: pointer;
    min-height: 44px;
}

/* 🎯 1. Keadaan Normal (Default State) */
.sidebar-menu {
    background-color: transparent;
    color: #111827; /* gray-900 */
}

.sidebar-menu .bg-purple-100 {
    background-color: #f3f4f6; /* purple-100 */
    color: #7c3aed; /* purple-700 */
}

/* 🖱️ 2. Keadaan Hover (Hover State) */
.sidebar-menu:hover {
    background-color: #faf5ff !important; /* purple-50/100 */
    color: #7c3aed !important; /* purple-700 */
}

.sidebar-menu:hover .bg-purple-100 {
    background-color: #7c3aed !important; /* purple-700 */
    color: white !important;
}

/* Filter untuk mengubah ikon hitam menjadi ungu saat hover */
.sidebar-menu:hover img:not(.filter.brightness-0.invert) {
    filter: brightness(0) saturate(100%) invert(30%) sepia(90%) saturate(2000%) hue-rotate(245deg) brightness(90%) contrast(90%);
}

/* 🖱️💥 3. Keadaan Aktif / Terpilih (Active/Selected State) */
.sidebar-menu.bg-purple-700 {
    background-color: #7c3aed !important; /* purple-700 */
    color: white !important;
    box-shadow: 0 4px 6px -1px rgba(124, 58, 237, 0.1), 0 2px 4px -1px rgba(124, 58, 237, 0.06);
}

.sidebar-menu.bg-purple-700 .bg-purple-100 {
    background-color: #faf5ff !important; /* purple-50/100 */
    color: #7c3aed !important; /* purple-700 */
}

/* Filter untuk mengubah ikon menjadi putih saat active */
.sidebar-menu.bg-purple-700 img {
    filter: brightness(0) invert(1);
}

/* Shadow untuk sidebar */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Smooth transitions untuk semua elemen */
.sidebar-menu,
.sidebar-menu * {
    transition: all 0.2s ease-in-out;
}

/* Smooth transitions untuk dropdown */
[x-cloak] {
    display: none !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.sidebar-menu');
    const currentPath = window.location.pathname;

    // Function untuk set active menu berdasarkan current route
    function setActiveMenu() {
        menuItems.forEach(item => {
            const itemHref = item.getAttribute('href');

            // Reset semua item ke state default
            item.classList.remove('bg-purple-700', 'text-white', 'shadow-md');
            item.classList.add('text-gray-900');

            // Reset ikon
            const icons = item.querySelectorAll('img');
            icons.forEach(icon => {
                icon.classList.remove('filter', 'brightness-0', 'invert');
            });

            // Reset badges (number badges)
            const badges = item.querySelectorAll('span:last-child');
            badges.forEach(badge => {
                if (badge.textContent.match(/^\d+$/)) {
                    badge.classList.remove('bg-white', 'text-purple-700');
                    badge.classList.add('bg-purple-100', 'text-purple-700');
                }
            });

            // Check jika item ini active berdasarkan route
            if (itemHref && currentPath.includes(itemHref.replace(/^https?:\/\/[^\/]+/, ''))) {
                item.classList.add('bg-purple-700', 'text-white', 'shadow-md');
                item.classList.remove('text-gray-900', 'hover:bg-purple-100', 'hover:text-purple-700');

                // Update ikon
                icons.forEach(icon => {
                    icon.classList.add('filter', 'brightness-0', 'invert');
                });

                // Update badges
                badges.forEach(badge => {
                    if (badge.textContent.match(/^\d+$/)) {
                        badge.classList.add('bg-purple-100', 'text-purple-700');
                        badge.classList.remove('bg-purple-700', 'text-white');
                    }
                });
            }
        });
    }

    // Set active menu on page load
    setActiveMenu();

    // Add click event listener untuk smooth transitions
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            if (href && href !== '#') {
                // Simpan state active di sessionStorage
                sessionStorage.setItem('activeSidebarItem', href);

                // Beri feedback visual sebelum redirect
                this.classList.add('bg-purple-700', 'text-white', 'shadow-md');

                // Update ikon
                const icons = this.querySelectorAll('img');
                icons.forEach(icon => {
                    icon.classList.add('filter', 'brightness-0', 'invert');
                });

                // Biarkan browser handle redirect secara natural
            }
        });
    });

    // Load active state dari sessionStorage jika ada
    const savedActiveItem = sessionStorage.getItem('activeSidebarItem');
    if (savedActiveItem) {
        const activeItem = document.querySelector(`.sidebar-menu[href="${savedActiveItem}"]`);
        if (activeItem && currentPath.includes(savedActiveItem.replace(/^https?:\/\/[^\/]+/, ''))) {
            menuItems.forEach(item => {
                item.classList.remove('bg-purple-700', 'text-white', 'shadow-md');
                item.classList.add('text-gray-900');

                const icons = item.querySelectorAll('img');
                icons.forEach(icon => {
                    icon.classList.remove('filter', 'brightness-0', 'invert');
                });
            });

            activeItem.classList.add('bg-purple-700', 'text-white', 'shadow-md');
            activeItem.classList.remove('text-gray-900');

            const activeIcons = activeItem.querySelectorAll('img');
            activeIcons.forEach(icon => {
                icon.classList.add('filter', 'brightness-0', 'invert');
            });
        }
    }

    // Add focus styles untuk accessibility
    menuItems.forEach(item => {
        item.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-purple-300', 'ring-offset-2');
        });

        item.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-purple-300', 'ring-offset-2');
        });
    });

    // Handle route changes (untuk SPA-like behavior)
    window.addEventListener('popstate', function() {
        setActiveMenu();
    });
});
</script>
