<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educounsel - Portal Bimbingan Konseling Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(180deg, #D3B0EF 0%, #FFFFFF 100%);
            min-height: 100vh;
        }
        .btn-primary {
            background-color: #6A00B8;
            color: #FFFFFF;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #8B5CF6;
        }
        .login-btn {
            background-color: #FBBF24;
            color: #000000;
            border-radius: 20px;
            padding: 0.6rem 1.4rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            background-color: #8B5CF6;
            color: #FFFFFF;
        }
    </style>
</head>
<body class="bg-white">
    @include('components.navbar-landing')

    <main>
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchBtn = document.getElementById('search-btn');
            const searchInput = document.getElementById('search-input');

            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    const searchTerm = searchInput.value;
                    if (searchTerm.trim()) {
                        alert('Mencari: ' + searchTerm);
                    }
                });
            }

            // Login button functionality
            const loginBtn = document.getElementById('login-btn');
            if (loginBtn) {
                loginBtn.addEventListener('click', function() {
                    window.location.href = "{{ route('login') }}";
                });
            }

            // Schedule button functionality
            const scheduleBtn = document.getElementById('schedule-btn');
            if (scheduleBtn) {
                scheduleBtn.addEventListener('click', function() {
                    window.location.href = "{{ route('login') }}";
                });
            }
        });
    </script>
</body>
</html>
