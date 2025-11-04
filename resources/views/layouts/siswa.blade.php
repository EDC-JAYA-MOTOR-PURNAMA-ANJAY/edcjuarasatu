<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa - Educounsel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- ⚡ PERFORMANCE BOOST -->
    <link href="{{ asset('css/performance-boost.css') }}" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1e3a8a 0%, #3730a3 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .logo-blue {
            color: #60a5fa;
        }

        .logo-orange {
            color: #fbbf24;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #e5e7eb;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #f59e0b;
        }

        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .user-details h3 {
            color: #1f2937;
            font-size: 16px;
            font-weight: 600;
        }

        .user-details p {
            color: #6b7280;
            font-size: 14px;
        }

        /* Content Area */
        .content-area {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .page-title {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .page-description {
            color: #6b7280;
            margin-bottom: 30px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #3b82f6;
        }

        .stat-card.hadir { border-left-color: #10b981; }
        .stat-card.izin { border-left-color: #f59e0b; }
        .stat-card.alpha { border-left-color: #ef4444; }
        .stat-card.telat { border-left-color: #8b5cf6; }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }

        /* Section Title */
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin: 30px 0 15px 0;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f8fafc;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #6b7280;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover {
            background: #f9fafb;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            .main-content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <h1>
                <span class="logo-blue">edu</span><span class="logo-orange">counsel</span>
            </h1>
        </div>

        <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.absensi') }}" class="nav-link active">
                        <i>📅</i> Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.konseling.ajukan') }}" class="nav-link">
                        <i>💬</i> Ajukan Konseling
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.konseling.jadwal') }}" class="nav-link">
                        <i>🕐</i> Jadwal Konseling
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.konseling.riwayat') }}" class="nav-link">
                        <i>📋</i> Riwayat Konseling
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.pelanggaran') }}" class="nav-link">
                        <i>⚠️</i> Pelanggaran
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.kuesioner') }}" class="nav-link">
                        <i>📝</i> Kuesioner
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.materi') }}" class="nav-link">
                        <i>📚</i> Materi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.panduan') }}" class="nav-link">
                        <i>❓</i> Panduan Bantuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.pengaturan') }}" class="nav-link">
                        <i>⚙️</i> Pengaturan
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-details">
                    <h3>{{ Auth::user()->name }}</h3>
                    <p>Siswa</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
        });
    </script>
    
    <!-- Performance Boost Script -->
    <script src="{{ asset('js/performance-boost.js') }}" defer></script>
    
    <!-- Voice Helper (Load First) -->
    <script src="{{ asset('js/voice-helper.js') }}"></script>

    <!-- Welcome Voice Script (Deferred) -->
    @if(session('login_success_voice') && session('user_name_voice'))
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            let femaleVoice = null;
            let voicesReady = false;
            
            function loadFemaleVoice() {
                const voices = window.speechSynthesis.getVoices();
                if (voices.length > 0 && !voicesReady) {
                    // PRIORITAS: GOOGLE VOICE FIRST untuk suara seperti Google Assistant!
            femaleVoice = 
                // 1. Google Indonesia (PRIORITAS UTAMA!)
                voices.find(v => v.name.toLowerCase().includes('google') && v.lang.startsWith('id')) ||
                // 2. Microsoft Gadis/Damayanti (Backup terbaik)
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('gadis')) ||
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('damayanti')) ||
                // 3. Any female Indonesian
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('female')) ||
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('perempuan')) ||
                // 4. Default Indonesian
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
                        utterance.rate = 0.95;  // ⚡⚡ SUPER ENERGIK!
                        utterance.pitch = 1.22;  // 🎵🔥 SANGAT CERIA!
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
                const message = `Yeay! Selamat datang {{ session('user_name_voice') }}! Anda berhasil login. Ayo semangat hari ini!`;
                speakWelcome(message);
            }, 200);
        });
    </script>
    @endif
</body>
</html>