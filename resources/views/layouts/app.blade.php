<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Educounsel')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-purple': '#8C52FF',
                        'light-purple': '#EEDCFF',
                        'pastel-blue': '#FFFFFF',
                        'dark-gray': '#212121',
                        'custom-green': '#00C853',
                        'custom-yellow': '#FFCA28',
                        'custom-red': '#E53935',
                        'custom-orange': '#FFB74D',
                        'sidebar-active': '#8C52FF',
                        'text-primary': '#333333',
                        'text-secondary': '#666666',
                        'text-gray': '#777777',
                        'border-light': '#F2F2F2',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 6px rgba(0, 0, 0, 0.06)',
                        'medium': '0 3px 8px rgba(0, 0, 0, 0.05)',
                        'card': '0 4px 10px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-student')

        <!-- Main Content Area -->
        <div class="ml-80 flex-1">
            <!-- Navbar -->
            @include('components.navbar')

            <!-- Page Content -->
            <main class="pt-16 min-h-screen">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
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
                    console.log('🎤 Loading FEMALE voice for welcome...');
                    
                    femaleVoice = 
                        voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('gadis')) ||
                        voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('damayanti')) ||
                        voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('female')) ||
                        voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('perempuan')) ||
                        voices.find(v => v.name.toLowerCase().includes('google') && v.lang.startsWith('id')) ||
                        voices.find(v => v.lang === 'id-ID');
                    
                    voicesReady = true;
                    console.log('✅ Welcome voice:', femaleVoice?.name || 'Default');
                }
            }
            
            function speakWelcome(text) {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    
                    if (!voicesReady) loadFemaleVoice();
                    
                    setTimeout(() => {
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'id-ID';
                        utterance.rate = 0.88;  // ⚡ Lebih cepat = lebih energik!
                        utterance.pitch = 1.15;  // 🎵 Lebih tinggi = lebih ceria!
                        utterance.volume = 1.0;
                        
                        if (femaleVoice) {
                            utterance.voice = femaleVoice;
                        }
                        
                        utterance.onend = () => console.log('✅ Welcome completed (ENERGIK!)');
                        utterance.onerror = (e) => console.warn('❌ Welcome error:', e.error);
                        
                        console.log('🔊 Speaking (SEMANGAT!):', text);
                        window.speechSynthesis.speak(utterance);
                    }, 50);
                }
            }
            
            if ('speechSynthesis' in window) {
                loadFemaleVoice();
                window.speechSynthesis.onvoiceschanged = loadFemaleVoice;
                setTimeout(loadFemaleVoice, 100);
            }
            
            setTimeout(() => {
                const userName = "{{ session('user_name_voice') }}";
                // Message lebih EXCITED & BERSEMANGAT!
                const message = `Selamat! Anda berhasil login. Halo ${userName}, selamat datang kembali!`;
                console.log('👋 Welcome message (ENERGIK!) for:', userName);
                speakWelcome(message);
            }, 200);
        });
    </script>
    @endif
</body>
</html>