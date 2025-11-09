@extends('layouts.app-guru-bk')

@section('title', 'Materi - Guru BK Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: #FFFFFF;
        margin: 0;
        padding: 0;
    }

    .materi-container {
        padding: 32px 48px 48px 48px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Banner sesuai deskripsi */
    .materi-header {
        background: #E9D8FD;
        border-radius: 12px;
        padding: 20px 32px;
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.04);
        width: 100%;
        height: 110px;
        position: relative;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 2;
    }

    .back-button {
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: #3D0075;
        padding: 0;
        margin-right: 12px;
    }

    .back-button i {
        font-size: 22px;
    }

    .header-text h1 {
        font-size: 20px;
        font-weight: 700;
        color: #3A2E67;
        margin: 0 0 4px 0;
        line-height: 1.3;
    }

    .header-text p {
        font-size: 14px;
        color: #8577B3;
        margin: 0;
        font-weight: 400;
    }

    .header-illustration {
        width: 80px;
        height: 80px;
        z-index: 2;
    }

    .header-illustration img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Section Title & Controls */
    .section-controls {
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #4A0CF5;
        margin-bottom: 16px;
    }

    .controls-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    /* Search Input sesuai deskripsi */
    .search-container {
        flex: 1;
        max-width: 260px;
        position: relative;
    }

    .search-input {
        width: 100%;
        height: 38px;
        padding: 0 16px 0 44px;
        border: 1px solid #E0E0E0;
        border-radius: 20px;
        font-size: 14px;
        background: #FFFFFF;
        font-weight: 400;
        color: #333333;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #C5A4FF;
        box-shadow: 0 0 0 3px rgba(197, 164, 255, 0.1);
    }

    .search-input::placeholder {
        color: #999999;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #999999;
        font-size: 16px;
    }

    /* Add Button sesuai deskripsi */
    .btn-add {
        padding: 0 16px;
        background: #8000FF;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        width: 130px;
        box-shadow: 0 4px 6px rgba(128, 0, 255, 0.2);
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background: #6600CC;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(128, 0, 255, 0.1);
    }

    .btn-add:active {
        transform: scale(0.97);
    }

    .btn-add i {
        font-size: 14px;
    }

    /* Table Card sesuai deskripsi */
    .table-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-top: 24px;
        width: 100%;
    }

    /* Table Styles sesuai deskripsi */
    .materi-table {
        width: 100%;
        border-collapse: collapse;
    }

    .materi-table thead {
        background: transparent;
    }

    .materi-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 14px;
        font-weight: 500;
        color: #666666;
        border-bottom: 1px solid #E5E5E5;
    }

    /* Kolom width sesuai deskripsi */
    .materi-table thead th:nth-child(1) { width: 20%; } /* Jenis */
    .materi-table thead th:nth-child(2) { width: 45%; } /* Judul */
    .materi-table thead th:nth-child(3) { width: 35%; } /* Kategori */

    .materi-table tbody tr {
        border-bottom: 1px solid #EFEFEF;
        transition: all 0.3s ease;
    }

    .materi-table tbody tr:hover {
        background: #FAF9FF;
    }

    .materi-table tbody tr:last-child {
        border-bottom: none;
    }

    .materi-table tbody td {
        padding: 12px 16px;
        font-size: 14px;
        color: #333333;
        font-weight: 400;
    }

    /* Badge Jenis - dihapus karena tidak ada dalam deskripsi */
    /* Badge Kategori - dihapus karena tidak ada dalam deskripsi */

    /* Kategori text biasa sesuai deskripsi */
    .kategori-text {
        font-size: 14px;
        color: #333333;
        font-weight: 400;
    }

    /* Action Buttons - dihapus karena tidak ada dalam deskripsi */

    /* Alert Messages */
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        animation: slideDown 0.3s ease;
    }

    .alert i {
        font-size: 18px;
    }

    .alert-success {
        background: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #81C784;
    }

    .alert-error {
        background: #FFEBEE;
        color: #C62828;
        border: 1px solid #EF5350;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #E0E0E0;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 16px;
        color: #999999;
        margin: 0;
    }

    /* Footer dengan info data dan pagination */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding-top: 12px;
        border-top: 1px solid #E5E5E5;
    }

    .data-info {
        font-size: 12px;
        color: #888888;
        font-weight: 400;
    }

    /* Pagination sesuai deskripsi */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .pagination button {
        width: 32px;
        height: 32px;
        border: 1px solid #E0E0E0;
        background: #FFFFFF;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        color: #8000FF;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .pagination button:hover:not(:disabled) {
        background: #E9D8FD;
        border-color: #E9D8FD;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination .page-active {
        background: #8000FF;
        color: #FFFFFF;
        border-color: #8000FF;
    }

    .pagination button:active {
        transform: scale(0.95);
        transition: transform 0.1s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .materi-container {
            padding: 24px 24px 32px 24px;
        }

        .materi-header {
            height: auto;
            min-height: 100px;
            padding: 16px 24px;
        }

        .controls-row {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }

        .search-container {
            max-width: 100%;
        }

        .btn-add {
            width: 100%;
            justify-content: center;
        }

        .section-title {
            margin-bottom: 12px;
        }

        .table-footer {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }

        .pagination {
            align-self: flex-end;
        }
    }

    @media (max-width: 480px) {
        .materi-container {
            padding: 16px 16px 24px 16px;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .back-button {
            align-self: flex-start;
        }

        .header-illustration {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="materi-container">
    <!-- Header Banner -->
    <div class="materi-header">
        <div class="header-content">
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="header-text">
                <h1>Materi</h1>
                <p>Materi di halaman ini</p>
            </div>
        </div>
        <div class="header-illustration">
            <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Ilustrasi Chat" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Section Controls -->
    <div class="section-controls">
        <h2 class="section-title">Daftar Materi Saya</h2>
        <div class="controls-row">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Telusuri" id="searchInput">
            </div>
            <button class="btn-add" onclick="tambahMateri()">
                Tambah Data
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table class="materi-table" id="materiTable">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materiList as $materi)
                <tr>
                    <td>{{ $materi->jenis }}</td>
                    <td>{{ $materi->judul }}</td>
                    <td>
                        <span class="kategori-text">{{ $materi->kategori }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada materi tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer dengan info data dan pagination -->
        @if($materiList->total() > 0)
        <div class="table-footer">
            <div class="data-info">
                Menampilkan {{ $materiList->firstItem() }} - {{ $materiList->lastItem() }} dari {{ $materiList->total() }} data
            </div>
            <div class="pagination">
                {{ $materiList->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const table = document.getElementById('materiTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let row of rows) {
        const judul = row.cells[1]?.textContent.toLowerCase() || '';
        const jenis = row.cells[0]?.textContent.toLowerCase() || '';
        const kategori = row.cells[2]?.textContent.toLowerCase() || '';
        
        if (judul.includes(searchTerm) || jenis.includes(searchTerm) || kategori.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});

// Tambah Materi
function tambahMateri() {
    window.location.href = '{{ route("guru_bk.materi.create") }}';
}

// Voice Notification for Success/Error Messages (CHEERFUL for Guru BK)
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance('{{ session("success") }}');
            utterance.lang = 'id-ID';
            utterance.rate = 1.05;   // ⚡ Energik
            utterance.pitch = 1.45;  // 🎵 Extra Ceria untuk Success!
            utterance.volume = 1.0;
            window.speechSynthesis.speak(utterance);
        }
    }, 800);
});
@endif

@if(session('error'))
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance('{{ session("error") }}');
            utterance.lang = 'id-ID';
            utterance.rate = 0.95;   // Lebih lambat untuk error
            utterance.pitch = 1.15;  // Nada lebih rendah untuk error
            utterance.volume = 1.0;
            window.speechSynthesis.speak(utterance);
        }
    }, 800);
});
@endif
</script>
@endpush