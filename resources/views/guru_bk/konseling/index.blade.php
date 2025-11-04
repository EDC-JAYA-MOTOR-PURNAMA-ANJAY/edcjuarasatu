@extends('layouts.app')

@section('title', 'Manajemen Konseling - Guru BK')

@push('styles')
<style>
    body {
        background-color: #F5F5F5;
    }
    
    .konseling-container {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .page-header {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .btn-primary {
        background: #7000CC;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        background: #5E00A8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(112, 0, 204, 0.3);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .stat-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
    }
    
    .konseling-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .konseling-item {
        padding: 20px;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    
    .konseling-item:hover {
        border-color: #7000CC;
        box-shadow: 0 4px 12px rgba(112, 0, 204, 0.1);
    }
    
    .konseling-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
    }
    
    .student-name {
        font-size: 16px;
        font-weight: 700;
        color: #000;
    }
    
    .konseling-date {
        font-size: 12px;
        color: #666;
    }
    
    .konseling-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-pending {
        background: #FEF3C7;
        color: #92400E;
    }
    
    .status-ongoing {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .status-completed {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .konseling-desc {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }
    
    .konseling-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-action {
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-detail {
        background: #EEF2FF;
        color: #4F46E5;
    }
    
    .btn-detail:hover {
        background: #4F46E5;
        color: white;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #92400E;
    }
    
    .btn-edit:hover {
        background: #92400E;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
</style>
@endpush

@section('content')
<div class="konseling-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #000; margin-bottom: 5px;">
                💬 Manajemen Konseling
            </h1>
            <p style="color: #666; font-size: 14px;">Kelola jadwal dan sesi konseling siswa</p>
        </div>
        <a href="{{ route('guru_bk.konseling.jadwal') }}" class="btn-primary">
            ➕ Buat Jadwal Baru
        </a>
    </div>
    
    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Total Konseling</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Menunggu</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🔄</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Berlangsung</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
    
    <!-- Konseling List -->
    <div class="konseling-card">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #000;">
            Daftar Konseling
        </h3>
        
        <!-- Empty State -->
        <div class="empty-state">
            <div style="font-size: 80px; margin-bottom: 20px;">📋</div>
            <div style="font-size: 18px; color: #666; margin-bottom: 10px;">
                <strong>Belum ada jadwal konseling</strong>
            </div>
            <p style="color: #999; font-size: 14px; margin-bottom: 20px;">
                Buat jadwal konseling baru dengan klik tombol "Buat Jadwal Baru" di atas
            </p>
        </div>
        
        <!-- Example Konseling Items (uncomment when there's data) -->
        <!--
        <div class="konseling-item">
            <div class="konseling-header">
                <div>
                    <div class="student-name">Fikri Maulana - X TKJ 1</div>
                    <div class="konseling-date">📅 05 November 2025, 10:00 WIB</div>
                </div>
                <span class="konseling-status status-pending">Menunggu</span>
            </div>
            <div class="konseling-desc">
                <strong>Kategori:</strong> Kesulitan Belajar<br>
                <strong>Topik:</strong> Kesulitan memahami pelajaran matematika
            </div>
            <div class="konseling-actions">
                <a href="#" class="btn-action btn-detail">Detail</a>
                <a href="#" class="btn-action btn-edit">Edit</a>
            </div>
        </div>
        -->
    </div>
</div>
@endsection
