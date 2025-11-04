@extends('layouts.app')

@section('title', 'Dashboard - Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #E8C8FF 0%, #FFFFFF 100%);
        min-height: 100vh;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Hero Section Styles */
    .hero-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 60px;
        padding: 40px 0;
    }

    .hero-content h1 {
        font-size: 36px;
        font-weight: 700;
        color: #5A00A3;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .hero-content h1 .highlight {
        color: #5A00A3;
    }

    .hero-content p {
        font-size: 18px;
        color: #333333;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .btn-primary {
        background: #7000CC;
        color: #FFFFFF;
        padding: 14px 32px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary:hover {
        background: #5A00A3;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(112, 0, 204, 0.3);
    }

    .hero-illustration {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-illustration img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }

    /* Cards Section */
    .cards-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .info-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #F0F0F0;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .card-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        color: #6B7280;
    }

    .card-item i {
        width: 20px;
        text-align: center;
        color: #9CA3AF;
    }

    .card-accent {
        height: 4px;
        border-radius: 2px;
        margin-top: 20px;
    }

    /* Specific Card Styles */
    .card-konseling .card-icon {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
    }

    .card-konseling .card-accent {
        background: linear-gradient(90deg, #4CAF50, #8BC34A);
    }

    .card-orangtua .card-icon {
        background: rgba(255, 82, 82, 0.1);
        color: #FF5252;
    }

    .card-orangtua .card-accent {
        background: linear-gradient(90deg, #FF5252, #FF8A80);
    }

    .card-pelanggaran .card-icon {
        background: rgba(112, 0, 204, 0.1);
        color: #7000CC;
    }

    .card-pelanggaran .card-accent {
        background: linear-gradient(90deg, #7000CC, #5A00A3);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .hero-section {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 32px;
        }

        .cards-section {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }

        .hero-content h1 {
            font-size: 28px;
        }

        .hero-content p {
            font-size: 16px;
        }

        .btn-primary {
            padding: 12px 24px;
            font-size: 14px;
        }

        .info-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Left Side - Text Content -->
        <div class="hero-content">
            <h1>
                Selamat Datang di <span class="highlight">Portal Bimbingan Konseling Sekolah!</span>
            </h1>
            <p>
                Tempat kamu bisa curhat, cari solusi, dan dapet motivasi — semua dalam satu ruang yang aman dan nyaman.
            </p>
            <a href="{{ route('student.counseling.create') }}" class="btn-primary">
                <i class="fas fa-calendar-plus"></i>
                <span>Buat Jadwal Konseling</span>
            </a>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hero-illustration">
            <img 
                src="{{ asset('images/konseling.png') }}" 
                alt="Konseling Illustration"
                onerror="this.src='https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'"
            >
        </div>
    </section>

    <!-- Information Cards Section -->
    <section class="cards-section">
        <!-- Card 1: Konseling Terjadwal -->
        <div class="info-card card-konseling">
            <div class="card-header">
                <h3>Konseling Terjadwal</h3>
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="card-item">
                    <i class="fas fa-calendar"></i>
                    <span>21 Oktober 2025</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-clock"></i>
                    <span>09:00 WIB</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Bu Eta</span>
                </div>
            </div>
            <div class="card-accent"></div>
        </div>

        <!-- Card 2: Panggilan Orang Tua -->
        <div class="info-card card-orangtua">
            <div class="card-header">
                <h3>Panggilan Orang Tua</h3>
                <div class="card-icon">
                    <i class="fas fa-phone"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="card-item">
                    <i class="fas fa-calendar"></i>
                    <span>22 Oktober 2025</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-clock"></i>
                    <span>14:00 WIB</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Pak Budi</span>
                </div>
            </div>
            <div class="card-accent"></div>
        </div>

        <!-- Card 3: Pelanggaran Terbaru -->
        <div class="info-card card-pelanggaran">
            <div class="card-header">
                <h3>Pelanggaran Terbaru</h3>
                <div class="card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="card-item">
                    <i class="fas fa-calendar"></i>
                    <span>20 Oktober 2025</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-clock"></i>
                    <span>Terlambat 3x</span>
                </div>
                <div class="card-item">
                    <i class="fas fa-info-circle"></i>
                    <span style="color: #EF4444; font-weight: 500;">Perlu perhatian</span>
                </div>
            </div>
            <div class="card-accent"></div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🎙️ DASHBOARD DAILY REMINDER
    const lastVoiceDate = localStorage.getItem('dashboard_voice_date');
    const today = new Date().toDateString();
    
    if (lastVoiceDate !== today) {
        const userName = '{{ Auth::user()->nama ?? "Pengguna" }}';
        const pendingKonseling = 0; // From controller if available
        const pendingKuesioner = 0; // From controller if available
        
        setTimeout(() => {
            if (window.voiceHelper) {
                window.voiceHelper.speakDashboardReminder(userName, pendingKonseling, pendingKuesioner);
                localStorage.setItem('dashboard_voice_date', today);
            }
        }, 1500);
    }
    
    // Smooth animations for cards
    const cards = document.querySelectorAll('.info-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Add click handlers for cards
    cards[0].addEventListener('click', function() {
        window.location.href = '{{ route('student.counseling.schedule') }}';
    });

    cards[1].addEventListener('click', function() {
        // Redirect untuk panggilan orang tua
        alert('Fitur panggilan orang tua akan segera tersedia');
    });

    cards[2].addEventListener('click', function() {
        // Redirect untuk pelanggaran
        alert('Fitur pelanggaran akan segera tersedia');
    });
});
</script>
@endpush