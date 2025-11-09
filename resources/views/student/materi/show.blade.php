@extends('layouts.app')

@section('title', $materi->judul . ' - Materi')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap');
    
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    body {
        background-color: #F8F9FA;
        margin: 0;
        padding: 0;
    }
    
    .materi-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px;
    }
    
    /* Back Button */
    .back-button-wrapper {
        margin-bottom: 24px;
    }
    
    .btn-back {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        color: #374151;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: #F9FAFB;
        border-color: #8000FF;
        color: #8000FF;
        transform: translateX(-4px);
    }
    
    .btn-back i {
        font-size: 16px;
    }
    
    /* Main Content Card */
    .materi-card {
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 32px;
    }
    
    /* Header Section */
    .materi-header {
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        padding: 40px;
        color: white;
    }
    
    .materi-meta {
        display: flex;
        gap: 24px;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .meta-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .meta-badge i {
        font-size: 14px;
    }
    
    .materi-title {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 16px 0;
        line-height: 1.3;
    }
    
    .materi-author {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        opacity: 0.95;
    }
    
    .materi-author i {
        font-size: 18px;
    }
    
    /* Content Section */
    .materi-content {
        padding: 40px;
    }
    
    /* Thumbnail */
    .materi-thumbnail {
        width: 100%;
        max-height: 500px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 32px;
        background: #F8F5FF;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .materi-thumbnail img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
    }
    
    /* Content Text */
    .materi-body {
        font-size: 16px;
        line-height: 1.8;
        color: #374151;
        margin-bottom: 32px;
    }
    
    .materi-body p {
        margin-bottom: 16px;
    }
    
    .materi-body h2 {
        font-size: 24px;
        font-weight: 600;
        color: #1F2937;
        margin: 32px 0 16px 0;
    }
    
    .materi-body h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1F2937;
        margin: 24px 0 12px 0;
    }
    
    .materi-body ul, .materi-body ol {
        margin: 16px 0;
        padding-left: 24px;
    }
    
    .materi-body li {
        margin-bottom: 8px;
    }
    
    /* Tabs Navigation */
    .content-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        border-bottom: 2px solid #E5E7EB;
    }
    
    .tab-button {
        padding: 12px 24px;
        border: none;
        background: transparent;
        color: #6B7280;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }
    
    .tab-button.active {
        color: #8000FF;
        border-bottom-color: #8000FF;
    }
    
    .tab-button:hover {
        color: #8000FF;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* PDF Viewer */
    .pdf-viewer-container {
        width: 100%;
        background: #F9FAFB;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .pdf-viewer {
        width: 100%;
        height: 800px;
        border: none;
        border-radius: 12px;
    }
    
    .pdf-controls {
        background: #FFFFFF;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #E5E7EB;
    }
    
    .pdf-info {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: #6B7280;
    }
    
    /* File Download Section */
    .file-download-section {
        background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 32px;
    }
    
    .file-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .file-details {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .file-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
    }
    
    .file-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .file-name {
        font-size: 16px;
        font-weight: 600;
        color: #1F2937;
    }
    
    .file-size {
        font-size: 14px;
        color: #6B7280;
    }
    
    .btn-download {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-download:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }
    
    .btn-download i {
        font-size: 18px;
    }
    
    /* Related Materi Section */
    .related-section {
        margin-top: 48px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #E5E7EB;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .related-card {
        background: #FFFFFF;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }
    
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(128, 0, 255, 0.15);
    }
    
    .related-thumbnail {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #F8F5FF 0%, #FFFFFF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .related-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    .related-content {
        padding: 16px;
    }
    
    .related-title {
        font-size: 16px;
        font-weight: 600;
        color: #1F2937;
        margin: 0 0 8px 0;
        line-height: 1.4;
    }
    
    .related-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #6B7280;
    }
    
    .related-meta i {
        font-size: 12px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .materi-detail-container {
            padding: 16px;
        }
        
        .materi-header {
            padding: 24px;
        }
        
        .materi-title {
            font-size: 24px;
        }
        
        .materi-content {
            padding: 24px;
        }
        
        .file-info {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-download {
            width: 100%;
            justify-content: center;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="materi-detail-container">
    <!-- Back Button -->
    <div class="back-button-wrapper">
        <a href="{{ route('student.materi') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar Materi
        </a>
    </div>
    
    <!-- Main Materi Card -->
    <div class="materi-card">
        <!-- Header Section -->
        <div class="materi-header">
            <div class="materi-meta">
                <span class="meta-badge">
                    <i class="fas fa-tag"></i>
                    {{ $materi->kategori }}
                </span>
                <span class="meta-badge">
                    <i class="fas fa-{{ $materi->jenis === 'Artikel' ? 'file-alt' : ($materi->jenis === 'Video Link' ? 'video' : 'file-pdf') }}"></i>
                    {{ $materi->jenis }}
                </span>
                <span class="meta-badge">
                    <i class="fas fa-calendar"></i>
                    {{ $materi->created_at->format('d M Y') }}
                </span>
            </div>
            
            <h1 class="materi-title">{{ $materi->judul }}</h1>
            
            <div class="materi-author">
                <i class="fas fa-user-tie"></i>
                <span>Oleh: {{ $materi->guruBK->nama ?? 'Guru BK' }}</span>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="materi-content">
            <!-- Thumbnail -->
            @if($materi->thumbnail)
            <div class="materi-thumbnail">
                <img src="{{ asset('storage/' . $materi->thumbnail) }}" alt="{{ $materi->judul }}">
            </div>
            @endif
            
            <!-- Tabs Navigation (if file exists) -->
            @if($materi->file_path)
            <div class="content-tabs">
                <button class="tab-button active" data-tab="content">
                    <i class="fas fa-align-left"></i> Baca Konten
                </button>
                <button class="tab-button" data-tab="file">
                    <i class="fas fa-file-pdf"></i> Lihat File ({{ $materi->file_extension }})
                </button>
            </div>
            @endif
            
            <!-- Video Embed (if jenis is Video Link) -->
            @if($materi->jenis === 'Video Link' && $materi->konten)
            <div class="video-container" style="margin-bottom: 32px;">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000;">
                    @php
                        $videoUrl = $materi->konten;
                        $embedUrl = '';
                        
                        // YouTube
                        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                        } 
                        // Vimeo
                        elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $matches)) {
                            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                        }
                        // Google Drive
                        elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                            $embedUrl = 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
                        }
                        // Already embed URL
                        elseif (strpos($videoUrl, 'embed') !== false || strpos($videoUrl, 'player') !== false) {
                            $embedUrl = $videoUrl;
                        }
                    @endphp
                    
                    @if($embedUrl)
                        <iframe 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                            src="{{ $embedUrl }}" 
                            title="{{ $materi->judul }}"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
                            <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 16px;"></i>
                            <p>Format video link tidak didukung</p>
                            <a href="{{ $videoUrl }}" target="_blank" style="color: #8000FF; text-decoration: underline;">Buka di tab baru</a>
                        </div>
                    @endif
                </div>
                <div style="margin-top: 16px; padding: 16px; background: #F9FAFB; border-radius: 8px;">
                    <p style="margin: 0; color: #6B7280; font-size: 14px;">
                        <i class="fas fa-link" style="margin-right: 8px;"></i>
                        Link: <a href="{{ $materi->konten }}" target="_blank" style="color: #8000FF;">{{ $materi->konten }}</a>
                    </p>
                </div>
            </div>
            @endif
            
            <!-- Tab Content: Text Content -->
            <div class="tab-content active" id="content-tab">
                <div class="materi-body">
                    @if($materi->jenis !== 'Video Link')
                        {!! nl2br(e($materi->konten)) !!}
                    @else
                        <div style="text-align: center; padding: 40px; color: #6B7280;">
                            <i class="fas fa-video" style="font-size: 48px; color: #8000FF; margin-bottom: 16px;"></i>
                            <p>Video ditampilkan di atas. Nikmati pembelajaran Anda!</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Tab Content: File Viewer (if file exists) -->
            @if($materi->file_path)
            <div class="tab-content" id="file-tab">
                <div class="pdf-viewer-container">
                    @php
                        $extension = strtolower($materi->file_extension ?? pathinfo($materi->file_path, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if($extension === 'pdf')
                        <!-- PDF Viewer using iframe -->
                        <iframe class="pdf-viewer" 
                                src="{{ asset('storage/' . $materi->file_path) }}" 
                                type="application/pdf"
                                title="{{ $materi->judul }}">
                            <p>Browser Anda tidak mendukung PDF viewer. 
                               <a href="{{ asset('storage/' . $materi->file_path) }}" download>Download file</a> untuk melihat.</p>
                        </iframe>
                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']))
                        <!-- Image Viewer -->
                        <div style="padding: 24px; text-align: center;">
                            <img src="{{ asset('storage/' . $materi->file_path) }}" 
                                 alt="{{ $materi->judul }}" 
                                 style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        </div>
                    @elseif(in_array($extension, ['mp3', 'wav', 'ogg']))
                        <!-- Audio Player -->
                        <div style="padding: 40px; text-align: center;">
                            <i class="fas fa-music" style="font-size: 64px; color: #8000FF; margin-bottom: 24px;"></i>
                            <audio controls style="width: 100%; max-width: 600px;">
                                <source src="{{ asset('storage/' . $materi->file_path) }}" type="audio/{{ $extension }}">
                                Browser Anda tidak mendukung audio player.
                            </audio>
                        </div>
                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                        <!-- Video Player (uploaded file) -->
                        <div style="padding: 24px;">
                            <video controls style="width: 100%; max-width: 100%; border-radius: 12px;">
                                <source src="{{ asset('storage/' . $materi->file_path) }}" type="video/{{ $extension }}">
                                Browser Anda tidak mendukung video player.
                            </video>
                        </div>
                    @else
                        <!-- For other file types (DOC, DOCX, etc) - Show Google Docs Viewer -->
                        <div style="padding: 40px; text-align: center;">
                            <i class="fas fa-file-alt" style="font-size: 64px; color: #8000FF; margin-bottom: 16px;"></i>
                            <p style="font-size: 16px; color: #374151; margin-bottom: 8px; font-weight: 600;">
                                {{ strtoupper($extension) }} - Preview dengan Google Docs Viewer
                            </p>
                            <p style="font-size: 14px; color: #6B7280; margin-bottom: 24px;">
                                Klik tombol di bawah untuk membuka preview
                            </p>
                            
                            <!-- Google Docs Viewer Button -->
                            <a href="https://docs.google.com/viewer?url={{ urlencode(asset('storage/' . $materi->file_path)) }}&embedded=true" 
                               target="_blank" 
                               class="btn-download" 
                               style="display: inline-flex; margin-bottom: 16px;">
                                <i class="fas fa-eye"></i>
                                Buka Preview (Google Docs)
                            </a>
                            
                            <br>
                            
                            <!-- Download Button as alternative -->
                            <a href="{{ asset('storage/' . $materi->file_path) }}" class="btn-download" download style="display: inline-flex; background: #6B7280;">
                                <i class="fas fa-download"></i>
                                atau Download File
                            </a>
                        </div>
                    @endif
                    
                    <!-- PDF Controls -->
                    @if(strtolower($materi->file_extension) === 'PDF')
                    <div class="pdf-controls">
                        <div class="pdf-info">
                            <i class="fas fa-file-pdf" style="color: #EF4444;"></i>
                            <span><strong>{{ $materi->judul }}.pdf</strong></span>
                            <span>•</span>
                            <span>{{ $materi->file_size }}</span>
                        </div>
                        <a href="{{ $materi->file_url }}" class="btn-download" download>
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Related Materi Section -->
    @if($relatedMateri->count() > 0)
    <div class="related-section">
        <h2 class="section-title">Materi Terkait</h2>
        <div class="related-grid">
            @foreach($relatedMateri as $related)
            <a href="{{ route('student.materi.show', $related->id) }}" class="related-card">
                <div class="related-thumbnail">
                    @if($related->thumbnail)
                        <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->judul }}">
                    @else
                        <svg width="120" height="120" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="100" cy="100" r="80" fill="#E6DAF7" opacity="0.3"/>
                            <circle cx="80" cy="90" r="20" fill="#8000FF"/>
                            <rect x="60" y="110" width="40" height="50" rx="5" fill="#A855F7"/>
                        </svg>
                    @endif
                </div>
                <div class="related-content">
                    <h3 class="related-title">{{ Str::limit($related->judul, 60) }}</h3>
                    <div class="related-meta">
                        <span><i class="fas fa-tag"></i> {{ $related->kategori }}</span>
                        <span><i class="fas fa-calendar"></i> {{ $related->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Smooth scroll animation
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Add fade-in animation
    const content = document.querySelector('.materi-detail-container');
    content.style.opacity = '0';
    content.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        content.style.transition = 'all 0.6s ease';
        content.style.opacity = '1';
        content.style.transform = 'translateY(0)';
    }, 100);
});

// Tabs functionality
const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', function() {
        const tabName = this.getAttribute('data-tab');
        
        // Remove active class from all buttons and contents
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked button and corresponding content
        this.classList.add('active');
        document.getElementById(tabName + '-tab').classList.add('active');
    });
});

// Download button animation
const downloadBtns = document.querySelectorAll('.btn-download');
downloadBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        const originalContent = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Downloading...';
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-check"></i> Downloaded!';
            setTimeout(() => {
                this.innerHTML = originalContent;
            }, 2000);
        }, 800);
    });
});
</script>
@endpush
@endsection
