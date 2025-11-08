@extends('layouts.app')

@section('title', 'Materi Pembelajaran - Siswa')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap');
    
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    body {
        background-color: #FFFFFF;
        margin: 0;
        padding: 0;
    }
    
    .materi-container {
        padding: 32px;
        max-width: 1400px;
        margin: 0;
    }
    
    /* Header Banner - Diubah ukuran menjadi 1044x120 */
    .materi-header {
        background: linear-gradient(135deg, #E6DAF7 0%, #F3E6FF 100%);
        border-radius: 12px;
        padding: 24px 32px;
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        width: 1044px;
        height: 120px;
    }
    
    .header-content {
        flex: 1;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    /* Back Button di kiri tengah */
    .back-button {
        width: 40px;
        height: 40px;
        background: rgba(128, 0, 255, 0.1);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        margin: 0; /* Reset margin */
    }
    
    .back-button:hover {
        background: rgba(128, 0, 255, 0.2);
        transform: translateX(-3px);
    }
    
    .back-button i {
        color: #8000FF;
        font-size: 18px;
    }
    
    .header-text {
        flex: 1;
    }
    
    .header-title {
        font-size: 28px;
        font-weight: 700;
        color: #4A3B5C;
        margin: 0 0 8px 0;
    }
    
    .header-description {
        font-size: 15px;
        color: #6B5B7E;
        margin: 0;
        line-height: 1.6;
    }
    
    .header-illustration {
        width: 180px;
        height: 180px;
        position: relative;
        z-index: 2;
    }
    
    .header-illustration img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    /* Cards Grid - Pojok kiri dengan jarak dekat */
    .materi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, 300px);
        gap: 12px;
        margin-top: 24px;
        justify-content: start;
    }
    
    @media (max-width: 1200px) {
        .materi-grid {
            grid-template-columns: repeat(auto-fill, 300px);
            gap: 12px;
        }
    }
    
    @media (max-width: 768px) {
        .materi-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .materi-header {
            width: 100%;
            height: auto;
            min-height: 120px;
            padding: 20px;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .back-button {
            align-self: flex-start;
        }
    }
    
    /* Card Styling - Diubah ukuran menjadi 300x390 */
    .materi-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        display: flex;
        flex-direction: column;
        height: 390px;
        width: 300px;
        position: relative;
        overflow: hidden;
        margin: 0 auto; /* Center card jika perlu */
    }
    
    /* Efek Glassmorphism dan Shadow saat hover */
    .materi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            135deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0) 50%, 
            rgba(255, 255, 255, 0.2) 100%
        );
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
        border-radius: 12px;
    }
    
    .materi-card:hover {
        transform: translateY(-8px);
        box-shadow: 
            0 20px 40px rgba(128, 0, 255, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.1);
    }
    
    .materi-card:hover::before {
        opacity: 1;
    }
    
    /* Efek cahaya glassmorphism */
    .materi-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            45deg,
            transparent,
            rgba(255, 255, 255, 0.1),
            transparent
        );
        transform: rotate(45deg);
        transition: all 0.6s ease;
        opacity: 0;
    }
    
    .materi-card:hover::after {
        opacity: 1;
        animation: glass-shine 1.5s ease-in-out;
    }
    
    @keyframes glass-shine {
        0% {
            transform: rotate(45deg) translateX(-100%);
        }
        100% {
            transform: rotate(45deg) translateX(100%);
        }
    }
    
    /* Card Illustration */
    .card-illustration {
        width: 100%;
        height: 180px;
        margin-bottom: 16px;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #F8F5FF 0%, #FFFFFF 100%);
        position: relative;
        z-index: 2;
    }
    
    .card-illustration img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 8px;
    }
    
    /* Card Content */
    .card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 2;
    }
    
    .card-title {
        font-size: 17px;
        font-weight: 700;
        color: #333333;
        margin: 0 0 8px 0;
    }
    
    .card-description {
        font-size: 14px;
        color: #666666;
        line-height: 1.6;
        margin: 0 0 16px 0;
        flex: 1;
    }
    
    /* Card Meta */
    .card-meta {
        display: flex;
        gap: 16px;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F0F0F0;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #888888;
    }
    
    .meta-item i {
        font-size: 14px;
        color: #999999;
    }
    
    /* Progress Section */
    .card-progress {
        margin-bottom: 16px;
    }
    
    .progress-label {
        font-size: 12px;
        color: #999999;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .progress-percentage {
        font-weight: 600;
        color: #8000FF;
    }
    
    .progress-bar-container {
        width: 100%;
        height: 6px;
        background: #EAEAEA;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 16px;
    }
    
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #8000FF 0%, #A855F7 100%);
        border-radius: 10px;
        transition: width 0.6s ease;
    }
    
    /* Card Author Info */
    .card-author {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #666;
        margin-bottom: 16px;
        padding: 8px 12px;
        background: #F9FAFB;
        border-radius: 6px;
    }
    
    .card-author i {
        color: #8000FF;
    }
    
    /* Card Action Button */
    .card-action {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        position: relative;
        z-index: 2;
    }
    
    .btn-baca, .btn-download {
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 10px rgba(128, 0, 255, 0.25);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-download {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
    }
    
    .btn-baca:hover, .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(128, 0, 255, 0.35);
    }
    
    .btn-baca:hover {
        background: linear-gradient(135deg, #7500EB 0%, #5F00C0 100%);
    }
    
    .btn-download:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
    }
    
    .btn-baca:active, .btn-download:active {
        transform: translateY(0px);
        box-shadow: 0 2px 6px rgba(128, 0, 255, 0.2);
    }
    
    .btn-baca i {
        margin-right: 6px;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999999;
        grid-column: 1 / -1;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #E0E0E0;
        margin-bottom: 16px;
    }
    
    .empty-state p {
        font-size: 16px;
        margin: 0;
    }
    
    /* Ripple Effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="materi-container">
    <!-- Header Banner -->
    <div class="materi-header">
        <div class="header-content">
            <!-- Back Button sekarang di kiri tengah -->
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="header-text">
                <h1 class="header-title">Materi</h1>
                <p class="header-description">
                    Temukan wawasan baru tentang karier, emosi, dan hubungan sosial.
                </p>
            </div>
        </div>
        <div class="header-illustration">
            <!-- Ganti dengan gambar ilustrasi chat -->
            <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Ilustrasi Chat" onerror="this.style.display='none'">
        </div>
    </div>
    
    <!-- Materi Grid dengan jarak yang lebih rapat -->
    <div class="materi-grid">
        @forelse($materiList as $materi)
        <!-- Dynamic Materi Cards -->
        <div class="materi-card">
            <div class="card-illustration">
                @if($materi->thumbnail)
                    <img src="{{ asset('storage/' . $materi->thumbnail) }}" alt="{{ $materi->judul }}">
                @else
                    <!-- Fallback SVG illustration -->
                    <svg width="160" height="160" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="#E6DAF7" opacity="0.3"/>
                        <circle cx="80" cy="90" r="20" fill="#8000FF"/>
                        <rect x="60" y="110" width="40" height="50" rx="5" fill="#A855F7"/>
                        <rect x="95" y="120" width="30" height="25" rx="3" fill="#FFD700"/>
                        <line x1="110" y1="125" x2="110" y2="140" stroke="#FFF" stroke-width="2"/>
                    </svg>
                @endif
            </div>
            
            <div class="card-content">
                <h3 class="card-title">{{ $materi->judul }}</h3>
                <p class="card-description">
                    {{ Str::limit($materi->konten, 120) }}
                </p>
                
                <div class="card-meta">
                    <div class="meta-item">
                        <i class="fas fa-tag"></i>
                        <span>{{ $materi->kategori }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-{{ $materi->jenis === 'Artikel' ? 'file-alt' : ($materi->jenis === 'Video Link' ? 'video' : 'file-pdf') }}"></i>
                        <span>{{ $materi->jenis }}</span>
                    </div>
                    @if($materi->file_path)
                    <div class="meta-item">
                        <i class="fas fa-download"></i>
                        <span>{{ $materi->file_extension }} - {{ $materi->file_size }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="card-author">
                    <i class="fas fa-user-tie"></i>
                    <span>Oleh: {{ $materi->guruBK->name ?? 'Guru BK' }}</span>
                </div>
                
                <div class="card-action">
                    @if($materi->file_path)
                    <a href="{{ $materi->file_url }}" class="btn-download" download>
                        <i class="fas fa-download"></i>
                        Download
                    </a>
                    @endif
                    <button class="btn-baca" onclick="readMateri({{ $materi->id }})">
                        <i class="fas fa-book-open"></i>
                        Baca
                    </button>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <p>Belum ada materi tersedia</p>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
// Ripple Effect for Buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-baca');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            button.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
});

// Function to read materi
function readMateri(materiId) {
    console.log('Reading materi:', materiId);
    
    // Show loading animation
    const btn = event.target.closest('.btn-baca');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    btn.disabled = true;
    
    // Simulate navigation delay
    setTimeout(() => {
        // Navigate to materi detail page
        window.location.href = '/student/materi/' + materiId;
        
        btn.innerHTML = originalContent;
        btn.disabled = false;
    }, 800);
}

// Animate progress bars on load
window.addEventListener('load', function() {
    const progressBars = document.querySelectorAll('.progress-bar-fill');
    
    progressBars.forEach(bar => {
        const targetWidth = bar.style.width;
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.width = targetWidth;
        }, 300);
    });
});

// Animate cards on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, index * 100);
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.materi-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });
});
</script>
@endpush
@endsection