@extends('layouts.app-admin')

@section('title', 'Panduan Bantuan - Admin')

@push('styles')
<style>
    .panduan-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 10px;
    }
    
    .faq-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .faq-item {
        border-bottom: 1px solid #E5E7EB;
        padding: 20px 0;
    }
    
    .faq-item:last-child {
        border-bottom: none;
    }
    
    .faq-question {
        font-size: 16px;
        font-weight: 600;
        color: #000;
        margin-bottom: 10px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .faq-answer {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        display: none;
        padding-top: 10px;
    }
    
    .faq-answer.active {
        display: block;
    }
    
    .quick-guide {
        background: linear-gradient(135deg, #7000CC 0%, #5E00A8 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 20px;
    }
    
    .guide-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
    }
    
    .guide-title {
        font-size: 16px;
        font-weight: 700;
        color: #7000CC;
        margin-bottom: 10px;
    }
    
    .guide-desc {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="panduan-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">❓ Panduan Bantuan</div>
        <p style="color: #666; font-size: 14px;">Panduan lengkap penggunaan sistem Educounsel</p>
    </div>
    
    <!-- Quick Guide -->
    <div class="quick-guide">
        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 20px;">🚀 Panduan Cepat</h3>
        
        <div class="guide-item">
            <div class="guide-title">1. Dashboard Admin</div>
            <div class="guide-desc">
                Dashboard menampilkan statistik lengkap sistem termasuk jumlah siswa, guru BK, absensi, dan konseling.
                Anda dapat melihat overview seluruh aktivitas di sistem.
            </div>
        </div>
        
        <div class="guide-item">
            <div class="guide-title">2. Manajemen Pengguna</div>
            <div class="guide-desc">
                Kelola data admin, guru BK, dan siswa. Anda dapat menambah, edit, atau hapus pengguna.
                Pastikan data NIS/NIP dan email unik untuk setiap pengguna.
            </div>
        </div>
        
        <div class="guide-item">
            <div class="guide-title">3. Rekap Absensi</div>
            <div class="guide-desc">
                Lihat rekap absensi siswa per kelas. Anda dapat melihat detail kehadiran, izin, sakit, dan alpha.
                Fitur export tersedia untuk laporan Excel.
            </div>
        </div>
        
        <div class="guide-item">
            <div class="guide-title">4. Tahun Ajaran</div>
            <div class="guide-desc">
                Kelola tahun ajaran aktif. Hanya satu tahun ajaran yang dapat aktif pada satu waktu.
                Tahun ajaran aktif akan digunakan untuk semua data baru.
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="faq-section">
        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 20px; color: #000;">💬 Pertanyaan yang Sering Diajukan (FAQ)</h3>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Bagaimana cara menambah pengguna baru?
                <span>▼</span>
            </div>
            <div class="faq-answer">
                Buka menu "Daftar Pengguna", klik tombol "Tambah Akun", isi formulir dengan lengkap,
                pilih peran (admin/guru_bk/siswa), dan klik simpan.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Bagaimana cara export data absensi?
                <span>▼</span>
            </div>
            <div class="faq-answer">
                Buka menu "Rekap Absensi", pilih kelas yang ingin di-export, klik tombol "Export Excel".
                File akan otomatis terdownload.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Bagaimana cara mengubah tahun ajaran aktif?
                <span>▼</span>
            </div>
            <div class="faq-answer">
                Buka menu "Tahun Ajaran", cari tahun ajaran yang ingin diaktifkan,
                klik toggle switch untuk mengaktifkan. Tahun ajaran lain akan otomatis non-aktif.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Apa yang harus dilakukan jika lupa password?
                <span>▼</span>
            </div>
            <div class="faq-answer">
                Hubungi super admin untuk reset password. Admin dapat mereset password pengguna
                melalui menu edit pengguna.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Bagaimana cara menghapus pengguna?
                <span>▼</span>
            </div>
            <div class="faq-answer">
                Buka "Daftar Pengguna", cari pengguna yang ingin dihapus, klik tombol hapus (ikon trash).
                Konfirmasi penghapusan. <strong>Perhatian:</strong> Data yang sudah dihapus tidak dapat dikembalikan.
            </div>
        </div>
    </div>
    
    <!-- Contact Support -->
    <div style="background: white; border-radius: 16px; padding: 30px; text-align: center; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 10px; color: #000;">
            📞 Butuh Bantuan Lebih Lanjut?
        </h3>
        <p style="color: #666; margin-bottom: 20px;">
            Hubungi tim support kami untuk bantuan teknis
        </p>
        <a href="mailto:support@educounsel.com" style="background: #7000CC; color: white; padding: 12px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block;">
            Hubungi Support
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFaq(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('span');
    
    // Close all other answers
    document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.classList.remove('active');
        }
    });
    
    // Reset all icons
    document.querySelectorAll('.faq-question span').forEach(item => {
        if (item !== icon) {
            item.textContent = '▼';
        }
    });
    
    // Toggle current
    answer.classList.toggle('active');
    icon.textContent = answer.classList.contains('active') ? '▲' : '▼';
}
</script>
@endpush
