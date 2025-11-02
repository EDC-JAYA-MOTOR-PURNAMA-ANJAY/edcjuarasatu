<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Educounsel - Portal Bimbingan Konseling Sekolah')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #374151;
            background: #FFFFFF;
        }

        /* Background dengan Gradient Wave yang Menyatu */
        .background-wrapper {
            position: relative;
            min-height: 100vh;
        }

        .gradient-wave-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 75vh;
            background: 
                linear-gradient(180deg, #B0B4EA 0%, #B0B4EA 70%, #FFFFFF 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath fill='%23B0B4EA' d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25'%3E%3C/path%3E%3Cpath fill='%23B0B4EA' d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.5'%3E%3C/path%3E%3Cpath fill='%23B0B4EA' d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: 100% 100%, 1200px 120px;
            background-position: 0 0, 0 100%;
            background-repeat: no-repeat;
            z-index: -1;
        }

        /* Alternatif: Wave sebagai mask */
        .wave-mask {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 120px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23B0B4EA'%3E%3C/path%3E%3C/svg%3E");
            background-size: 1200px 120px;
            background-position: center bottom;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 80px;
        }

        /* Navbar */
        .navbar {
            background-color: #FFFFFF;
            height: 70px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
        }

        .logo-blue {
            color: #2563EB;
        }

        .logo-orange {
            color: #F59E0B;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 28px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-menu a:hover {
            color: #2563EB;
        }

        .search-container {
            position: relative;
            width: 200px;
        }

        .search-input {
            width: 100%;
            height: 36px;
            border-radius: 9999px;
            background-color: #F3F4F6;
            border: none;
            padding: 0 40px 0 16px;
            font-size: 14px;
            outline: none;
        }

        .search-input::placeholder {
            color: #9CA3AF;
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
        }

        .login-btn {
            background-color: #F59E0B;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-btn:hover {
            background-color: #D97706;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
            transform: translateY(-1px);
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 650px;
            display: flex;
            align-items: center;
            margin-top: 70px;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 100px 0;
        }

        .hero-text {
            flex: 1;
            max-width: 50%;
        }

        .hero-title {
            font-size: 36px;
            font-weight: 600;
            color: #1E3A8A;
            line-height: 1.4;
            margin-bottom: 16px;
        }

        .hero-description {
            font-size: 16px;
            color: #4B5563;
            max-width: 500px;
            margin-bottom: 28px;
            font-weight: 400;
        }

        .cta-button {
            background-color: #2563EB;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .cta-button:hover {
            background-color: #1E40AF;
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            margin-left: 60px;
        }

        .hero-image img {
            width: 480px;
            height: auto;
            object-fit: contain;
        }

        /* Content Sections */
        .content-section {
            position: relative;
            z-index: 2;
            background: #FFFFFF;
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            color: #1E3A8A;
            margin-bottom: 40px;
            font-weight: 600;
        }

        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .about-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .about-card:hover {
            transform: translateY(-5px);
        }

        .about-card h3 {
            color: #2563EB;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .about-card p {
            color: #6B7280;
            line-height: 1.6;
        }

        /* Features Section */
        .features-section {
            background: #F8FAFC;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #2563EB, #1E40AF);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .feature-card h3 {
            color: #1E3A8A;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .feature-card p {
            color: #6B7280;
            line-height: 1.6;
        }

        /* FAQ Section */
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 20px;
        }

        .faq-item h3 {
            color: #374151;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .faq-item p {
            color: #6B7280;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: #1E3A8A;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .footer-links a:hover {
            opacity: 0.8;
        }

        .copyright {
            color: #E5E7EB;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 0 40px;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
                padding: 60px 0;
            }

            .hero-text {
                max-width: 100%;
                margin-bottom: 40px;
            }

            .hero-image {
                margin-left: 0;
            }

            .hero-image img {
                width: 400px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            .nav-menu {
                display: none;
            }

            .search-container {
                display: none;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-image img {
                width: 300px;
            }

            .section-title {
                font-size: 28px;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 24px;
            }
            
            .hero-image img {
                width: 250px;
            }
            
            .about-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Background dengan Gradient Wave yang Menyatu -->
    <div class="background-wrapper">
        <div class="gradient-wave-bg"></div>
        <!-- <div class="wave-mask"></div> -->

        <!-- Navbar -->
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <span class="logo-blue">edu</span><span class="logo-orange">counsel</span>
                </div>

                <ul class="nav-menu">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#fitur">Keunggulan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search">
                    <span class="search-icon">🔍</span>
                </div>

                <a href="{{ route('login') }}">
                    <button class="login-btn">Login</button>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animasi untuk cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.about-card, .feature-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>