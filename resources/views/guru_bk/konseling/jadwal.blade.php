@extends('layouts.app')

@section('title', 'Buat Jadwal Konseling - Guru BK')

@push('styles')
<style>
    body {
        background-color: #F5F5F5;
    }
    
    .jadwal-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 10px;
    }
    
    .form-subtitle {
        color: #666;
        font-size: 14px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #000;
        margin-bottom: 8px;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #7000CC;
        box-shadow: 0 0 0 3px rgba(112, 0, 204, 0.1);
    }
    
    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }
    
    .btn {
        padding: 14px 32px;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary {
        background: #7000CC;
        color: white;
    }
    
    .btn-primary:hover {
        background: #5E00A8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(112, 0, 204, 0.3);
    }
    
    .btn-secondary {
        background: white;
        color: #7000CC;
        border: 2px solid #7000CC;
    }
    
    .btn-secondary:hover {
        background: #F2E6FF;
    }
    
    .required {
        color: #EF4444;
    }
</style>
@endpush

@section('content')
<div class="jadwal-container">
    <div class="form-card">
        <div class="form-header">
            <div class="form-title">📅 Buat Jadwal Konseling</div>
            <div class="form-subtitle">Isi formulir di bawah untuk membuat jadwal konseling baru</div>
        </div>
        
        <form action="#" method="POST">
            @csrf
            
            <!-- Siswa -->
            <div class="form-group">
                <label class="form-label">
                    Siswa <span class="required">*</span>
                </label>
                <select class="form-select" name="siswa_id" required>
                    <option value="">Pilih Siswa</option>
                    <option value="1">Fikri Maulana - X TKJ 1</option>
                    <option value="2">Putri Amelia - X RPL 1</option>
                    <option value="3">Ahmad Rizki - XI TKJ 1</option>
                </select>
            </div>
            
            <!-- Jenis Konseling -->
            <div class="form-group">
                <label class="form-label">
                    Jenis Konseling <span class="required">*</span>
                </label>
                <select class="form-select" name="jenis_konseling" required>
                    <option value="">Pilih Jenis</option>
                    <option value="individu">Konseling Individu</option>
                    <option value="kelompok">Konseling Kelompok</option>
                </select>
            </div>
            
            <!-- Kategori Masalah -->
            <div class="form-group">
                <label class="form-label">
                    Kategori Masalah <span class="required">*</span>
                </label>
                <select class="form-select" name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    <option value="1">Akademik - Kesulitan Belajar</option>
                    <option value="2">Sosial - Masalah Pertemanan</option>
                    <option value="3">Pribadi - Motivasi</option>
                    <option value="4">Karir - Perencanaan Masa Depan</option>
                </select>
            </div>
            
            <!-- Tanggal -->
            <div class="form-group">
                <label class="form-label">
                    Tanggal Konseling <span class="required">*</span>
                </label>
                <input type="date" class="form-input" name="tanggal" required>
            </div>
            
            <!-- Waktu -->
            <div class="form-group">
                <label class="form-label">
                    Waktu Konseling <span class="required">*</span>
                </label>
                <input type="time" class="form-input" name="waktu" required>
            </div>
            
            <!-- Tempat -->
            <div class="form-group">
                <label class="form-label">
                    Tempat Konseling <span class="required">*</span>
                </label>
                <input type="text" class="form-input" name="tempat" placeholder="Contoh: Ruang BK" required>
            </div>
            
            <!-- Topik -->
            <div class="form-group">
                <label class="form-label">
                    Topik Pembahasan <span class="required">*</span>
                </label>
                <textarea class="form-textarea" name="topik" placeholder="Jelaskan topik yang akan dibahas..." required></textarea>
            </div>
            
            <!-- Catatan -->
            <div class="form-group">
                <label class="form-label">
                    Catatan Tambahan
                </label>
                <textarea class="form-textarea" name="catatan" placeholder="Catatan atau persiapan khusus..."></textarea>
            </div>
            
            <!-- Buttons -->
            <div class="btn-group">
                <a href="{{ route('guru_bk.konseling.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    💾 Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Set minimum date to today
document.querySelector('input[type="date"]').min = new Date().toISOString().split('T')[0];
</script>
@endpush
