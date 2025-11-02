<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Educounsel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="ml-80 flex-1">
            <!-- Navbar -->

            <!-- Page Content -->
            <main class="min-h-screen bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
