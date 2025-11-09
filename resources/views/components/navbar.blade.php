<header class="bg-white h-16 fixed top-0 right-0 left-64 z-40 border-b border-gray-100 shadow-sm">
    <div class="flex items-center justify-end h-full px-8">
        <!-- User Profile -->
        <div class="flex items-center space-x-4 relative">
            <!-- Notification Bell -->
            <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-50 transition-colors relative shadow-sm">
                <img src="{{ asset('images/icon/bell-ring.svg') }}" alt="Notifications" class="w-5 h-5 object-contain transition-all duration-300 hover:scale-110">
                @if(isset($badges['total_notifications']) && $badges['total_notifications'] > 0)
                <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-gradient-to-br from-red-500 to-red-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-md px-1 animate-pulse">
                    {{ $badges['total_notifications'] }}
                </span>
                @endif
            </button>

            <!-- User Profile -->
            <div class="flex items-center space-x-3 cursor-pointer group" id="profileTrigger">
                <div class="text-right">
                    <div class="text-text-primary font-medium text-sm">{{ auth()->user()->nama ?? 'User' }}</div>
                    <div class="text-text-gray text-xs">
                        @if(auth()->user()->peran === 'admin')
                            Admin
                        @elseif(auth()->user()->peran === 'guru_bk')
                            Guru BK
                        @elseif(auth()->user()->peran === 'siswa')
                            Siswa
                        @else
                            {{ ucfirst(auth()->user()->peran) }}
                        @endif
                    </div>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-md group-hover:shadow-lg transition-all">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 2)) }}
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-md border border-gray-100 py-4 opacity-0 invisible transition-all duration-300 transform translate-y-2" id="profileDropdown">
                <div class="flex flex-col items-center px-4 pb-4 border-b border-gray-100">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-2xl shadow-lg mb-3">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 2)) }}
                    </div>
                    <h3 class="font-bold text-text-primary text-lg">{{ auth()->user()->nama ?? 'User' }}</h3>
                    <p class="text-primary-purple text-sm">
                        @if(auth()->user()->peran === 'admin')
                            Admin
                        @elseif(auth()->user()->peran === 'guru_bk')
                            Guru BK
                        @elseif(auth()->user()->peran === 'siswa')
                            Siswa
                            @if(auth()->user()->kelas)
                                - {{ auth()->user()->kelas->nama_kelas }}
                            @endif
                        @else
                            {{ ucfirst(auth()->user()->peran) }}
                        @endif
                    </p>
                    <p class="text-text-gray text-xs mt-1">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                </div>

                <div class="px-2 pt-2">
                    <button class="w-full flex items-center px-3 py-2 text-text-primary rounded-lg hover:bg-gray-50 transition-colors group shadow-sm" onclick="window.location.href='{{ route('student.profile') }}'">
                        <i class="fas fa-user w-5 mr-3 text-gray-500 group-hover:text-primary-purple"></i>
                        <span class="text-sm">Lihat Profil</span>
                    </button>
                    <button class="w-full flex items-center px-3 py-2 text-text-primary rounded-lg hover:bg-gray-50 transition-colors group shadow-sm">
                        <i class="fas fa-cog w-5 mr-3 text-gray-500 group-hover:text-primary-purple"></i>
                        <span class="text-sm">Pengaturan</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-red-600 rounded-lg hover:bg-red-50 transition-colors group shadow-sm">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            <span class="text-sm">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Overlay -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" id="overlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');
    const overlay = document.getElementById('overlay');

    function toggleProfileDropdown() {
        const isVisible = profileDropdown.classList.contains('opacity-0');

        if (isVisible) {
            profileDropdown.classList.remove('opacity-0', 'invisible', 'translate-y-2');
            profileDropdown.classList.add('opacity-100', 'visible', 'translate-y-0');
            overlay.classList.remove('hidden');
        } else {
            profileDropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
            profileDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
            overlay.classList.add('hidden');
        }
    }

    profileTrigger.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleProfileDropdown();
    });

    overlay.addEventListener('click', function() {
        profileDropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
        profileDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
        overlay.classList.add('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileTrigger.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
            profileDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
            overlay.classList.add('hidden');
        }
    });
});
</script>
