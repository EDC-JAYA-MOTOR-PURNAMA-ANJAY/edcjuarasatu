<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guru BK - Educounsel')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
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
                            <!-- Notification Icon -->
                            <button class="relative text-gray-700 hover:text-gray-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            
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

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>