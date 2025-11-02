<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Educounsel - Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sidebar-bg': '#FFFFFF',
                        'main-bg': '#F8F9FA',
                        'text-primary': '#212529',
                        'text-secondary': '#495057',
                        'hover-bg': '#E9ECEF',
                        'active-purple': '#7B3FE4',
                        'badge-purple': '#6B2EDB',
                        'logo-blue': '#2357C6',
                        'logo-orange': '#F9A825',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'medium': '0 4px 12px rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F8F9FA] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Admin Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Navbar -->
            @include('components.navbar')

            <!-- Page Content -->
            <main class="min-h-screen bg-[#F8F9FA]">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <!-- Welcome Voice Script -->
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
                        utterance.rate = 0.88;  // ⚡ Lebih energik!
                        utterance.pitch = 1.15;  // 🎵 Lebih ceria!
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
</body>
</html>
