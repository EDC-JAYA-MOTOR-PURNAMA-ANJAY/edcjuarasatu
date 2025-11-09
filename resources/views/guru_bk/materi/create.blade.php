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
                    <option value="Artikel">📝 Artikel (Text/HTML)</option>
                    <option value="Video Link">🔗 Video Link (YouTube/Vimeo/Google Drive)</option>
                    <option value="Video Upload">🎥 Video Upload (MP4, WebM, OGG - Max 100MB)</option>
                    <option value="PDF">📄 PDF (Dokumen PDF)</option>
                    <option value="Gambar">🖼️ Gambar/Infografis (JPG, PNG, GIF, SVG)</option>
                    <option value="Audio">🎵 Audio/Podcast (MP3, WAV, OGG)</option>
                    <option value="Dokumen Office">📊 Dokumen Office (Word, Excel, PowerPoint)</option>
                </select>
                <small class="form-hint" style="margin-top: 8px; display: block; color: #6B7280;">
                    💡 Tip: Semua file yang diupload bisa langsung diakses siswa tanpa perlu download!
                </small>
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

            <!-- File Upload (Conditional) -->
            <div class="form-group" id="fileUploadGroup" style="display: none;">
                <label class="form-label" for="file">
                    Upload File 
                    <span id="fileTypeHint" style="font-size: 12px; color: #666;"></span>
                </label>
                <div class="file-upload-container">
                    <label for="file" class="file-upload-btn">
                        <i class="fas fa-cloud-upload-alt"></i> Pilih File
                    </label>
                    <input type="file" class="file-upload-input" id="file" name="file" onchange="updateFileNameDisplay(this, 'fileNameDisplay')">
                    <span class="file-name" id="fileNameDisplay">Belum ada file dipilih</span>
                </div>
                <small class="form-hint" id="fileFormatHint">Pilih jenis konten terlebih dahulu</small>
                
                <!-- File Size Preview -->
                <div id="fileSizePreview" style="display: none; margin-top: 12px; padding: 12px; background: #F0F9FF; border-radius: 8px; border-left: 4px solid #3B82F6;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-info-circle" style="color: #3B82F6;"></i>
                        <div>
                            <p style="margin: 0; font-size: 13px; color: #1F2937;">
                                <strong>File dipilih:</strong> <span id="selectedFileName"></span>
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #6B7280;">
                                Ukuran: <span id="selectedFileSize"></span>
                            </p>
                        </div>
                    </div>
                </div>
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
            
            <!-- Durasi Video (Conditional - only for Video) -->
            <div class="form-group" id="durasiGroup" style="display: none;">
                <label class="form-label" for="durasi_menit">
                    <i class="fas fa-clock"></i> Durasi Video (Menit)
                </label>
                <input type="number" class="form-input" id="durasi_menit" name="durasi_menit" min="1" placeholder="Contoh: 30 (untuk 30 menit)">
                <small class="form-hint">Masukkan durasi video dalam menit. Contoh: 90 untuk 1 jam 30 menit</small>
            </div>
            
            <!-- Total Halaman (Conditional - only for PDF) -->
            <div class="form-group" id="halamanGroup" style="display: none;">
                <label class="form-label" for="total_halaman">
                    <i class="fas fa-file-alt"></i> Total Halaman
                </label>
                <input type="number" class="form-input" id="total_halaman" name="total_halaman" min="1" placeholder="Contoh: 15">
                <small class="form-hint">Masukkan jumlah halaman PDF</small>
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
            <button type="button" class="btn btn-secondary" onclick="window.history.back()" id="btnBack">
                Kembali
            </button>
            <button type="submit" class="btn btn-primary" id="btnSubmit">
                <span id="btnText">Simpan</span>
                <span id="btnLoading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Handle form submit with loading state
const materiForm = document.querySelector('form');
const btnSubmit = document.getElementById('btnSubmit');
const btnBack = document.getElementById('btnBack');
const btnText = document.getElementById('btnText');
const btnLoading = document.getElementById('btnLoading');

materiForm.addEventListener('submit', function(e) {
    // Disable button to prevent double submission
    btnSubmit.disabled = true;
    btnBack.disabled = true;
    
    // Show loading
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline';
    
    // Form will continue to submit
});

// Toggle file upload field based on jenis selection
function toggleFileUpload() {
    const jenisSelect = document.getElementById('jenis');
    const fileUploadGroup = document.getElementById('fileUploadGroup');
    const fileInput = document.getElementById('file');
    const fileTypeHint = document.getElementById('fileTypeHint');
    const fileFormatHint = document.getElementById('fileFormatHint');
    const kontenGroup = document.getElementById('konten').closest('.form-group');
    const kontenInput = document.getElementById('konten');
    
    const jenis = jenisSelect.value;
    
    // Reset
    fileInput.value = '';
    document.getElementById('fileNameDisplay').textContent = 'Belum ada file dipilih';
    document.getElementById('fileSizePreview').style.display = 'none';
    
    // Configure based on jenis
    const config = {
        'Video Upload': {
            show: true,
            required: true,
            accept: '.mp4,.webm,.ogg,.mov,.avi',
            hint: '(MP4, WebM, OGG - Max 100MB)',
            format: 'Video: MP4, WebM, OGG, MOV, AVI',
            hideKonten: false,
            kontenPlaceholder: 'Deskripsi video (opsional)'
        },
        'PDF': {
            show: true,
            required: true,
            accept: '.pdf',
            hint: '(PDF - Max 10MB)',
            format: 'Dokumen PDF',
            hideKonten: false,
            kontenPlaceholder: 'Deskripsi PDF (opsional)'
        },
        'Gambar': {
            show: true,
            required: true,
            accept: '.jpg,.jpeg,.png,.gif,.svg,.webp',
            hint: '(JPG, PNG, GIF, SVG, WebP - Max 5MB)',
            format: 'Gambar: JPG, PNG, GIF, SVG, WebP',
            hideKonten: false,
            kontenPlaceholder: 'Deskripsi gambar (opsional)'
        },
        'Audio': {
            show: true,
            required: true,
            accept: '.mp3,.wav,.ogg,.m4a',
            hint: '(MP3, WAV, OGG - Max 20MB)',
            format: 'Audio: MP3, WAV, OGG, M4A',
            hideKonten: false,
            kontenPlaceholder: 'Deskripsi audio (opsional)'
        },
        'Dokumen Office': {
            show: true,
            required: true,
            accept: '.doc,.docx,.ppt,.pptx,.xls,.xlsx',
            hint: '(Word, PowerPoint, Excel - Max 10MB)',
            format: 'Office: DOC, DOCX, PPT, PPTX, XLS, XLSX',
            hideKonten: false,
            kontenPlaceholder: 'Deskripsi dokumen (opsional)'
        },
        'Artikel': {
            show: false,
            required: false,
            hideKonten: false,
            kontenPlaceholder: 'Tulis konten artikel Anda di sini...'
        },
        'Video Link': {
            show: false,
            required: false,
            hideKonten: false,
            kontenPlaceholder: 'Paste link YouTube/Vimeo/Google Drive di sini... (contoh: https://youtube.com/watch?v=xxxxx)'
        }
    };
    
    const settings = config[jenis];
    
    if (settings) {
        // File upload visibility
        if (settings.show) {
            fileUploadGroup.style.display = 'block';
            fileInput.setAttribute('accept', settings.accept);
            fileTypeHint.textContent = settings.hint;
            fileFormatHint.textContent = settings.format;
            
            if (settings.required) {
                fileInput.setAttribute('required', 'required');
            } else {
                fileInput.removeAttribute('required');
            }
        } else {
            fileUploadGroup.style.display = 'none';
            fileInput.removeAttribute('required');
        }
        
        // Konten field
        kontenInput.placeholder = settings.kontenPlaceholder;
        
        if (settings.hideKonten) {
            kontenGroup.style.display = 'none';
            kontenInput.removeAttribute('required');
        } else {
            kontenGroup.style.display = 'block';
            // Make konten optional for file uploads
            if (settings.show) {
                kontenInput.removeAttribute('required');
            } else {
                kontenInput.setAttribute('required', 'required');
            }
        }
        
        // Show/hide metadata fields
        const durasiGroup = document.getElementById('durasiGroup');
        const halamanGroup = document.getElementById('halamanGroup');
        const durasiInput = document.getElementById('durasi_menit');
        const halamanInput = document.getElementById('total_halaman');
        
        // Reset visibility
        durasiGroup.style.display = 'none';
        halamanGroup.style.display = 'none';
        durasiInput.removeAttribute('required');
        halamanInput.removeAttribute('required');
        
        // Show based on jenis
        if (jenis === 'Video Upload' || jenis === 'Video Link') {
            durasiGroup.style.display = 'block';
        } else if (jenis === 'PDF') {
            halamanGroup.style.display = 'block';
        }
    }
}

// Update file name display (generic function)
function updateFileNameDisplay(input, displayId) {
    const displayElement = document.getElementById(displayId);
    const previewDiv = document.getElementById('fileSizePreview');
    const fileNameSpan = document.getElementById('selectedFileName');
    const fileSizeSpan = document.getElementById('selectedFileSize');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        
        displayElement.textContent = file.name;
        displayElement.style.color = '#10B981';
        displayElement.style.fontWeight = '500';
        
        // Show preview
        if (previewDiv && fileNameSpan && fileSizeSpan) {
            fileNameSpan.textContent = file.name;
            fileSizeSpan.textContent = fileSize + ' MB';
            previewDiv.style.display = 'block';
            
            // Validate file size based on type
            const jenis = document.getElementById('jenis').value;
            let maxSize = 10; // Default 10MB
            
            if (jenis === 'Video Upload') maxSize = 100;
            else if (jenis === 'Audio') maxSize = 20;
            else if (jenis === 'Gambar') maxSize = 5;
            
            if (parseFloat(fileSize) > maxSize) {
                previewDiv.style.background = '#FEF2F2';
                previewDiv.style.borderLeftColor = '#EF4444';
                fileSizeSpan.style.color = '#EF4444';
                fileSizeSpan.textContent += ` (Maksimal ${maxSize}MB!)`;
            } else {
                previewDiv.style.background = '#F0F9FF';
                previewDiv.style.borderLeftColor = '#3B82F6';
                fileSizeSpan.style.color = '#6B7280';
            }
        }
    } else {
        displayElement.textContent = 'Belum ada file dipilih';
        displayElement.style.color = '#999999';
        displayElement.style.fontWeight = 'normal';
        if (previewDiv) previewDiv.style.display = 'none';
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