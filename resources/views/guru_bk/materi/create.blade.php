@extends('layouts.app-guru-bk')

@section('title', 'Form Input Materi - Guru BK Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    * {
        font-family: 'Roboto', sans-serif;
        box-sizing: border-box;
    }

    body {
        background-color: #FFFFFF;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .form-container {
        max-width: 1044px;
        width: 100%;
        margin: 0 auto;
        padding: 20px 24px 32px 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Header Banner */
    .form-header {
        background: #EADAFD;
        border-radius: 12px;
        padding: 24px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        width: 1044px;
        height: 144px;
        margin: 0 auto;
    }

    .header-content {
        display: flex;
        align-items: center;
    }

    .back-icon {
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: #4B0082;
        padding: 0;
        margin-right: 12px;
        width: 18px;
        height: 18px;
    }

    .back-icon i {
        font-size: 18px;
    }

    .header-text h1 {
        font-size: 20px;
        font-weight: 700;
        color: #3A2E67;
        margin: 0 0 4px 0;
        line-height: 24px;
    }

    .header-text p {
        font-size: 14px;
        color: #7B7197;
        margin: 0;
        font-weight: 400;
        line-height: 20px;
    }

    .header-illustration {
        width: 160px;
        height: 160px;
    }

    .header-illustration img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Section Title */
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #4A0CF5;
        margin: 8px 0 16px 0;
        padding-left: 8px;
    }

    /* Form Card */
    .form-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        width: 1044px;
        margin: 0 auto;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333333;
        margin-bottom: 6px;
    }

    .form-hint {
        display: block;
        font-size: 12px;
        color: #666666;
        margin-top: 4px;
        font-style: italic;
    }

    /* Input Styles */
    .form-input,
    .form-select {
        width: 100%;
        height: 48px;
        padding: 0 12px;
        border: 1px solid #E0E0E0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 400;
        color: #333333;
        background: #FFFFFF;
        transition: all 0.25s ease-in-out;
    }

    .form-input::placeholder,
    .form-select option:disabled {
        color: #999999;
    }

    .form-input:hover,
    .form-select:hover {
        border-color: #B38CFF;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #8000FF;
        box-shadow: 0 0 0 3px rgba(128, 0, 255, 0.15);
    }

    /* Dropdown Arrow */
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 12 12'%3E%3Cpath fill='%23888888' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
    }

    /* Text Editor Container */
    .editor-container {
        border: 1px solid #E0E0E0;
        border-radius: 8px;
        overflow: hidden;
        width: 100%;
    }

    .editor-toolbar {
        background: #F8F8F8;
        border-bottom: 1px solid #E0E0E0;
        padding: 6px 12px;
        display: flex;
        gap: 8px;
        height: 32px;
        align-items: center;
    }

    .editor-toolbar button {
        width: 24px;
        height: 24px;
        border: none;
        background: transparent;
        color: #555555;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        padding: 0;
    }

    .editor-toolbar button:hover {
        background: #E0E0E0;
    }

    .editor-toolbar button.active {
        background: #D5D5D5;
        color: #333333;
    }

    .editor-toolbar i {
        font-size: 12px;
    }

    .editor-textarea {
        width: 100%;
        height: 120px;
        padding: 12px;
        border: none;
        font-size: 14px;
        font-weight: 400;
        color: #333333;
        resize: vertical;
        font-family: 'Roboto', sans-serif;
        min-height: 120px;
    }

    .editor-textarea:focus {
        outline: none;
    }

    .editor-textarea::placeholder {
        color: #999999;
    }

    /* File Upload */
    .file-upload-container {
        display: flex;
        align-items: center;
        width: 100%;
        height: 48px;
        border: 1px solid #E0E0E0;
        border-radius: 8px;
        overflow: hidden;
    }

    .file-upload-btn {
        padding: 0 16px;
        height: 100%;
        background: #F3F3F3;
        border: none;
        border-right: 1px solid #E0E0E0;
        font-size: 14px;
        font-weight: 500;
        color: #333333;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
    }

    .file-upload-btn:hover {
        background: #EAEAEA;
    }

    .file-upload-input {
        display: none;
    }

    .file-name {
        font-size: 14px;
        color: #999999;
        font-weight: 400;
        padding: 0 12px;
        flex: 1;
    }

    /* Grid 2 Columns */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        width: 100%;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
        width: 1044px;
        margin: 20px auto 0;
    }

    .btn {
        padding: 0 20px;
        height: 38px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 100px;
    }

    .btn-secondary {
        background: #E0E0E0;
        color: #333333;
    }

    .btn-secondary:hover {
        background: #D5D5D5;
    }

    .btn-primary {
        background: #8000FF;
        color: #FFFFFF;
        box-shadow: 0 2px 4px rgba(128, 0, 255, 0.2);
    }

    .btn-primary:hover {
        background: #6600CC;
        box-shadow: 0 1px 2px rgba(128, 0, 255, 0.1);
    }

    .btn:active {
        transform: scale(0.98);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .form-container,
        .form-header,
        .form-card,
        .form-actions {
            width: 100%;
            max-width: 1044px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 16px 16px 24px 16px;
            gap: 12px;
        }

        .form-header {
            height: auto;
            min-height: 120px;
            padding: 16px 20px;
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }

        .header-content {
            flex-direction: column;
            gap: 8px;
        }

        .back-icon {
            margin-right: 0;
            margin-bottom: 6px;
        }

        .header-illustration {
            width: 100px;
            height: 100px;
        }

        .section-title {
            margin: 4px 0 12px 0;
            padding-left: 0;
            text-align: center;
            font-size: 16px;
        }

        .form-card {
            padding: 16px;
        }

        .form-actions {
            flex-direction: column-reverse;
            margin-top: 16px;
        }

        .btn {
            width: 100%;
            height: 36px;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 12px 12px 20px 12px;
        }

        .form-header {
            padding: 12px 16px;
        }

        .header-illustration {
            width: 80px;
            height: 80px;
        }

        .form-card {
            padding: 12px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-input,
        .form-select {
            height: 44px;
        }

        .file-upload-container {
            height: 44px;
        }

        .editor-textarea {
            height: 100px;
            min-height: 100px;
        }
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <!-- Header Banner -->
    <div class="form-header">
        <div class="header-content">
            <button class="back-icon" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="header-text">
                <h1>Form Input Materi</h1>
                <p>Form Input Materi di halaman ini</p>
            </div>
        </div>
        <div class="header-illustration">
            <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Ilustrasi Chat" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- Section Title -->
    <h2 class="section-title">Form Input Materi</h2>

    <!-- Form Card -->
    <form id="materiForm" action="{{ route('guru_bk.materi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-card">
            <!-- Jenis Konten -->
            <div class="form-group">
                <label class="form-label" for="jenis">Jenis Konten</label>
                <select class="form-select" id="jenis" name="jenis" required onchange="toggleFileUpload()">
                    <option value="" disabled selected>Memilih</option>
                    <option value="Artikel">Artikel</option>
                    <option value="Video Link">Video Link</option>
                    <option value="File/Dokumen">File/Dokumen (PDF, Word, Excel, PowerPoint)</option>
                </select>
            </div>

            <!-- Judul -->
            <div class="form-group">
                <label class="form-label" for="judul">Judul</label>
                <input type="text" class="form-input" id="judul" name="judul" placeholder="Masukkan Judul" required>
            </div>

            <!-- Konten -->
            <div class="form-group">
                <label class="form-label" for="konten">Konten</label>
                <div class="editor-container">
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('bold')" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" onclick="formatText('italic')" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" onclick="formatText('underline')" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <button type="button" onclick="formatText('justifyFull')" title="Justify">
                            <i class="fas fa-align-justify"></i>
                        </button>
                    </div>
                    <textarea class="editor-textarea" id="konten" name="konten" placeholder="Masukkan konten materi" required></textarea>
                </div>
            </div>

            <!-- File Upload (Conditional - only for File/Dokumen) -->
            <div class="form-group" id="fileUploadGroup" style="display: none;">
                <label class="form-label" for="file">Upload File <span style="font-size: 12px; color: #666;">(PDF, Word, Excel, PowerPoint - Max 10MB)</span></label>
                <div class="file-upload-container">
                    <label for="file" class="file-upload-btn"><i class="fas fa-file-upload"></i> Pilih File</label>
                    <input type="file" class="file-upload-input" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt" onchange="updateFileNameDisplay(this, 'fileNameDisplay')">
                    <span class="file-name" id="fileNameDisplay">No file chosen</span>
                </div>
                <small class="form-hint">Format yang didukung: PDF, Word, Excel, PowerPoint, Text</small>
            </div>

            <!-- Thumbnail -->
            <div class="form-group">
                <label class="form-label" for="thumbnail">Thumbnail <span style="font-size: 12px; color: #666;">(Opsional)</span></label>
                <div class="file-upload-container">
                    <label for="thumbnail" class="file-upload-btn"><i class="fas fa-image"></i> Pilih Gambar</label>
                    <input type="file" class="file-upload-input" id="thumbnail" name="thumbnail" accept="image/*" onchange="updateFileNameDisplay(this, 'fileName')">
                    <span class="file-name" id="fileName">No file chosen</span>
                </div>
                <small class="form-hint">Gambar thumbnail akan ditampilkan di daftar materi siswa</small>
            </div>

            <!-- Kategori & Target Kelas (Grid 2 Kolom) -->
            <div class="form-row">
                <!-- Kategori -->
                <div class="form-group">
                    <label class="form-label" for="kategori">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <option value="" disabled selected>Memilih</option>
                        <option value="Motivasi">Motivasi</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Kesehatan Mental">Kesehatan Mental</option>
                        <option value="Karier">Karier</option>
                    </select>
                </div>

                <!-- Target Kelas -->
                <div class="form-group">
                    <label class="form-label" for="target_kelas">Target Kelas</label>
                    <select class="form-select" id="target_kelas" name="target_kelas" required>
                        <option value="" disabled selected>Memilih</option>
                        <option value="Semua Kelas">Semua Kelas</option>
                        <option value="Kelas X">Kelas X</option>
                        <option value="Kelas XI">Kelas XI</option>
                        <option value="Kelas XII">Kelas XII</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                Kembali
            </button>
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Toggle file upload field based on jenis selection
function toggleFileUpload() {
    const jenisSelect = document.getElementById('jenis');
    const fileUploadGroup = document.getElementById('fileUploadGroup');
    const fileInput = document.getElementById('file');
    
    if (jenisSelect.value === 'File/Dokumen') {
        fileUploadGroup.style.display = 'block';
        fileInput.setAttribute('required', 'required');
    } else {
        fileUploadGroup.style.display = 'none';
        fileInput.removeAttribute('required');
        fileInput.value = ''; // Clear file input
        document.getElementById('fileNameDisplay').textContent = 'No file chosen';
    }
}

// Update file name display (generic function)
function updateFileNameDisplay(input, displayId) {
    const displayElement = document.getElementById(displayId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        displayElement.textContent = `${file.name} (${fileSize} MB)`;
        displayElement.style.color = '#333333';
    } else {
        displayElement.textContent = 'No file chosen';
        displayElement.style.color = '#999999';
    }
}

// Update file name display (legacy function for compatibility)
function updateFileName(input) {
    updateFileNameDisplay(input, 'fileName');
}

// Text formatting (basic implementation)
function formatText(command) {
    const textarea = document.getElementById('konten');
    textarea.focus();
    
    const button = event.target.closest('button');
    button.classList.toggle('active');
    
    console.log('Format applied:', command);
}

// Form validation
document.getElementById('materiForm').addEventListener('submit', function(e) {
    const formData = new FormData(this);
    
    const jenis = formData.get('jenis');
    const judul = formData.get('judul');
    const konten = formData.get('konten');
    const kategori = formData.get('kategori');
    const target_kelas = formData.get('target_kelas');
    
    if (!jenis || !judul || !konten || !kategori || !target_kelas) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return false;
    }
    
    // Submit form to server (let it proceed naturally)
    return true;
});

// Prevent form submission on Enter key in input fields
document.querySelectorAll('.form-input, .form-select').forEach(element => {
    element.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});
</script>
@endpush