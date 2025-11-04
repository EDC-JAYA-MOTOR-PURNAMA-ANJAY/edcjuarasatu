@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran - Educounsel')

@push('styles')
<style>
    body {
        background-color: #F5F5F5;
    }
    
    .violation-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .page-header {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 10px;
    }
    
    .page-subtitle {
        color: #666;
        font-size: 14px;
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
        text-align: center;
    }
    
    .stat-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #000;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
    }
    
    .violations-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .violation-item {
        padding: 20px;
        border-left: 4px solid #EF4444;
        background: #FEF2F2;
        border-radius: 12px;
        margin-bottom: 15px;
    }
    
    .violation-item.ringan {
        border-left-color: #F59E0B;
        background: #FFFBEB;
    }
    
    .violation-item.sedang {
        border-left-color: #EF4444;
        background: #FEF2F2;
    }
    
    .violation-item.berat {
        border-left-color: #DC2626;
        background: #FEE2E2;
    }
    
    .violation-date {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .violation-title {
        font-size: 16px;
        font-weight: 700;
        color: #000;
        margin-bottom: 5px;
    }
    
    .violation-desc {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }
    
    .violation-points {
        display: inline-block;
        padding: 4px 12px;
        background: #DC2626;
        color: white;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }
    
    .empty-text {
        font-size: 18px;
        color: #666;
    }
</style>
@endpush

@section('content')
<div class="violation-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">📋 Riwayat Pelanggaran</div>
        <div class="page-subtitle">Pantau catatan pelanggaran dan poin Anda</div>
    </div>
    
    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Total Pelanggaran</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Poin Pelanggaran</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">Baik</div>
            <div class="stat-label">Status Perilaku</div>
        </div>
    </div>
    
    <!-- Violations List -->
    <div class="violations-card">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #000;">
            Daftar Pelanggaran
        </h3>
        
        <!-- Empty State (uncomment when there's no data) -->
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <div class="empty-text">
                <strong>Selamat!</strong> Anda tidak memiliki catatan pelanggaran.
                <br>Terus pertahankan perilaku yang baik!
            </div>
        </div>
        
        <!-- Example violations (comment out when showing empty state) -->
        <!--
        <div class="violation-item ringan">
            <div class="violation-date">📅 01 November 2025, 08:30 WIB</div>
            <div class="violation-title">Terlambat Masuk Kelas</div>
            <div class="violation-desc">Terlambat masuk kelas tanpa keterangan yang jelas</div>
            <span class="violation-points">-5 Poin</span>
        </div>
        
        <div class="violation-item sedang">
            <div class="violation-date">📅 25 Oktober 2025, 10:15 WIB</div>
            <div class="violation-title">Tidak Menggunakan Seragam Lengkap</div>
            <div class="violation-desc">Tidak memakai atribut seragam lengkap (dasi)</div>
            <span class="violation-points">-10 Poin</span>
        </div>
        -->
    </div>
</div>
@endsection
