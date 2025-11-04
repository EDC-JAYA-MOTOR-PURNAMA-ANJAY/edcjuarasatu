@extends('layouts.app')

@section('title', 'Manajemen Pelanggaran - Guru BK')

@push('styles')
<style>
    body {
        background-color: #F5F5F5;
    }
    
    .pelanggaran-container {
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
    
    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .filter-item {
        flex: 1;
        min-width: 200px;
    }
    
    .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .pelanggaran-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table thead {
        background: #F9FAFB;
    }
    
    .table th {
        padding: 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #000;
        border-bottom: 2px solid #E5E7EB;
    }
    
    .table td {
        padding: 15px;
        border-bottom: 1px solid #E5E7EB;
        font-size: 14px;
        color: #555;
    }
    
    .table tbody tr:hover {
        background: #F9FAFB;
    }
    
    .severity-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .severity-ringan {
        background: #FEF3C7;
        color: #92400E;
    }
    
    .severity-sedang {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .severity-berat {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .action-btn {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
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
<div class="pelanggaran-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #000; margin-bottom: 5px;">
                ⚠️ Manajemen Pelanggaran
            </h1>
            <p style="color: #666; font-size: 14px;">Kelola data pelanggaran siswa</p>
        </div>
        <button class="btn-primary" onclick="alert('Fitur tambah pelanggaran akan segera hadir!')">
            ➕ Catat Pelanggaran
        </button>
    </div>
    
    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Total Pelanggaran</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🟡</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Pelanggaran Ringan</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🟠</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Pelanggaran Sedang</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🔴</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Pelanggaran Berat</div>
        </div>
    </div>
    
    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-item">
            <select class="form-select">
                <option value="">Semua Kelas</option>
                <option value="X">Kelas X</option>
                <option value="XI">Kelas XI</option>
                <option value="XII">Kelas XII</option>
            </select>
        </div>
        <div class="filter-item">
            <select class="form-select">
                <option value="">Semua Tingkat</option>
                <option value="ringan">Ringan</option>
                <option value="sedang">Sedang</option>
                <option value="berat">Berat</option>
            </select>
        </div>
        <div class="filter-item">
            <input type="date" class="form-select" placeholder="Tanggal">
        </div>
    </div>
    
    <!-- Pelanggaran Table -->
    <div class="pelanggaran-card">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #000;">
            Daftar Pelanggaran
        </h3>
        
        <!-- Empty State -->
        <div class="empty-state">
            <div style="font-size: 80px; margin-bottom: 20px;">🎉</div>
            <div style="font-size: 18px; color: #666; margin-bottom: 10px;">
                <strong>Tidak ada pelanggaran tercatat</strong>
            </div>
            <p style="color: #999; font-size: 14px;">
                Semua siswa menunjukkan perilaku yang baik
            </p>
        </div>
        
        <!-- Example Table (uncomment when there's data) -->
        <!--
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tingkat</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>04 Nov 2025</td>
                    <td>Fikri Maulana</td>
                    <td>X TKJ 1</td>
                    <td>Terlambat Masuk Kelas</td>
                    <td><span class="severity-badge severity-ringan">Ringan</span></td>
                    <td>-5</td>
                    <td>
                        <a href="#" class="action-btn btn-detail">Detail</a>
                        <a href="#" class="action-btn btn-edit">Edit</a>
                    </td>
                </tr>
            </tbody>
        </table>
        -->
    </div>
</div>
@endsection
