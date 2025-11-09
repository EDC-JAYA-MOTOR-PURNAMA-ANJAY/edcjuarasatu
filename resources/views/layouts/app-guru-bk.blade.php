<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru BK - Educounsel')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
        
        body {
            background: #F9FAFB;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar Guru BK -->
        @include('components.sidebar-guru-bk')

        <!-- Main Content Area -->
        <div class="flex-1" style="margin-left: 256px;">
            <!-- Navbar -->
            <div class="bg-white shadow-sm sticky top-0 z-30">
                <div class="max-w-full mx-auto px-8 py-3">
                    <div class="flex items-center justify-end">
                        <!-- Right Side: Notification & User Profile -->
                        <div class="flex items-center space-x-4">
                            <!-- Notification Icon with Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative text-gray-700 hover:text-gray-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @php
                                        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                
                                <!-- Notification Dropdown -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
                                     style="display: none;">
                                    
                                    <!-- Header -->
                                    <div class="px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-t-lg">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-sm">Notifikasi</h3>
                                            @if($unreadCount > 0)
                                                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">
                                                    {{ $unreadCount }} baru
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Notification List -->
                                    <div class="max-h-96 overflow-y-auto" id="notificationList">
                                        @php
                                            $notifications = \App\Models\Notification::where('user_id', Auth::id())
                                                ->orderBy('created_at', 'desc')
                                                ->limit(10)
                                                ->get();
                                        @endphp
                                        
                                        @if($notifications->count() > 0)
                                            @foreach($notifications as $notification)
                                                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-purple-50' : '' }}"
                                                     onclick="markAsRead({{ $notification->id }})">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0 mt-1">
                                                            @if($notification->type == 'chatbot_alert')
                                                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                                                </div>
                                                            @elseif($notification->type == 'chatbot_shared')
                                                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                                    <i class="fas fa-share text-purple-600"></i>
                                                                </div>
                                                            @else
                                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                                    <i class="fas fa-bell text-blue-600"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-gray-900">
                                                                {{ $notification->title }}
                                                            </p>
                                                            <p class="text-xs text-gray-600 mt-1">
                                                                {{ Str::limit($notification->message, 80) }}
                                                            </p>
                                                            <p class="text-xs text-gray-400 mt-1">
                                                                <i class="far fa-clock mr-1"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                        @if(!$notification->is_read)
                                                            <div class="flex-shrink-0">
                                                                <span class="inline-block w-2 h-2 bg-purple-600 rounded-full"></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="px-4 py-8 text-center text-gray-500">
                                                <i class="fas fa-bell-slash text-4xl mb-3 opacity-30"></i>
                                                <p class="text-sm">Belum ada notifikasi</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Footer -->
                                    @if($notifications->count() > 0)
                                        <div class="px-4 py-3 bg-gray-50 rounded-b-lg text-center border-t border-gray-200">
                                            <a href="{{ route('guru_bk.chatbot.shared') }}" 
                                               class="text-xs text-purple-600 hover:text-purple-700 font-semibold">
                                                Lihat Semua Notifikasi →
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- User Info & Avatar -->
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->nama ?? 'Griselia Athasya' }}</p>
                                    <p class="text-xs text-gray-500">Admin</p>
                                </div>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Griselia Athasya') }}&background=7c3aed&color=fff&size=128" 
                                     alt="User Avatar" 
                                     class="w-10 h-10 rounded-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="min-h-screen bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mark Notification as Read -->
    <script>
    function markAsRead(notificationId) {
        fetch(`/guru_bk/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload to update badge count
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
    
    <!-- Voice Helper JS (Same as Admin & Siswa) -->
    <script src="{{ asset('js/voice-helper.js') }}"></script>
    
    <!-- Welcome Voice Script (Same as Admin & Siswa) -->
    @if(session('login_success_voice') && session('user_name_voice'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let femaleVoice = null;
            let voicesReady = false;
            
            function loadFemaleVoice() {
                const voices = window.speechSynthesis.getVoices();
                if (voices.length > 0 && !voicesReady) {
                    femaleVoice = voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('gadis')) ||
                                  voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('damayanti')) ||
                                  voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('female')) ||
                                  voices.find(v => v.lang === 'id-ID');
                    voicesReady = true;
                }
            }
            
            function speakWelcome(text) {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    if (!voicesReady) loadFemaleVoice();
                    setTimeout(() => {
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'id-ID';
                        utterance.rate = 1.05;  // ⚡ Lebih cepat & energik!
                        utterance.pitch = 1.4;   // 🎵 SUPER CERIA untuk Guru BK!
                        utterance.volume = 1.0;
                        if (femaleVoice) utterance.voice = femaleVoice;
                        window.speechSynthesis.speak(utterance);
                    }, 50);
                }
            }
            
            if ('speechSynthesis' in window) {
                loadFemaleVoice();
                window.speechSynthesis.onvoiceschanged = loadFemaleVoice;
            }
            
            setTimeout(() => {
                const message = `Selamat! Anda berhasil login. Halo {{ session('user_name_voice') }}, selamat datang kembali!`;
                speakWelcome(message);
            }, 200);
        });
    </script>
    @endif
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>