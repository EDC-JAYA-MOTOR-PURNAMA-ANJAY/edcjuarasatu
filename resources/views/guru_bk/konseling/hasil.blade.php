@extends('layouts.app-guru-bk')

@section('title', 'Catatan Hasil Konseling - Guru BK')

@push('styles')
<style>
    body {
        background: #F5F5F7;
    }

    .hasil-konseling-container {
        max-width: 100%;
        padding: 32px;
        min-height: calc(100vh - 70px);
    }

    .page-header {
        margin-bottom: 32px;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1F2937;
        margin: 0;
    }

    .content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 32px;
        align-items: start;
        max-width: 1400px;
        margin: 0 auto;
    }

    .form-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-group-voice {
        position: relative;
    }

    .form-group textarea {
        width: 100%;
        padding: 12px 50px 12px 16px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        transition: all 0.2s;
    }

    .form-group textarea:focus {
        outline: none;
        border-color: #7000CC;
        box-shadow: 0 0 0 3px rgba(112, 0, 204, 0.1);
    }

    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 14px;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-group select:focus {
        outline: none;
        border-color: #7000CC;
        box-shadow: 0 0 0 3px rgba(112, 0, 204, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn {
        padding: 12px 32px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #7000CC;
        color: white;
    }

    .btn-primary:hover {
        background: #5A00A3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(112, 0, 204, 0.3);
    }

    .btn-secondary {
        background: #E5E7EB;
        color: #6B7280;
    }

    .btn-secondary:hover {
        background: #D1D5DB;
    }

    /* Right Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .calendar-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .calendar-nav {
        display: flex;
        gap: 12px;
    }

    .calendar-nav button {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #F3F4F6;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-nav button:hover {
        background: #E5E7EB;
    }

    .calendar-month {
        text-align: center;
        font-size: 15px;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 16px;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 8px;
    }

    .calendar-weekday {
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        padding: 8px 0;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        color: #374151;
    }

    .calendar-day:hover {
        background: #F3F4F6;
    }

    .calendar-day.active {
        background: #7000CC;
        color: white;
        font-weight: 600;
    }

    .calendar-day.today {
        border: 2px solid #7000CC;
        font-weight: 600;
    }

    .calendar-day.disabled {
        color: #D1D5DB;
        cursor: not-allowed;
    }

    /* List View Card */
    .list-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .list-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .list-actions {
        display: flex;
        gap: 8px;
    }

    .list-actions button {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #9CA3AF;
        cursor: pointer;
        transition: all 0.2s;
    }

    .list-actions button:hover {
        background: #F3F4F6;
        color: #6B7280;
    }

    .list-table {
        width: 100%;
    }

    .list-table thead {
        border-bottom: 2px solid #F3F4F6;
    }

    .list-table th {
        text-align: left;
        padding: 12px 8px;
        font-size: 13px;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .list-table td {
        padding: 16px 8px;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }

    .list-table tbody tr:hover {
        background: #F9FAFB;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.selesai {
        background: #D1FAE5;
        color: #065F46;
    }

    .status-badge.proses {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-badge.rujukan {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .status-badge.tindak-lanjut {
        background: #FED7AA;
        color: #9A3412;
    }

    /* Voice Button Styles */
    .voice-btn {
        position: absolute;
        right: 12px;
        top: 36px;
        width: 36px;
        height: 36px;
        border: 1.5px solid #E5E7EB;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        color: #6B7280;
        font-size: 14px;
    }

    .voice-btn:hover {
        background: #F9FAFB;
        border-color: #7000CC;
        color: #7000CC;
    }

    .voice-btn.recording {
        background: #DC2626;
        border-color: #DC2626;
        color: white;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Notification */
    .voice-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #1F2937;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .hasil-konseling-container {
            padding: 16px;
        }

        .form-section,
        .calendar-card,
        .list-card {
            padding: 20px;
        }

        .calendar-days {
            gap: 4px;
        }

        .calendar-day {
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')
<div class="hasil-konseling-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Catatan Hasil Konseling</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success" style="max-width: 1400px; margin: 0 auto 24px;">
        <div style="background: #D1FAE5; border-left: 4px solid #10B981; padding: 16px 20px; border-radius: 8px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle" style="color: #059669; font-size: 20px;"></i>
            <span style="color: #065F46; font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Left Side - Form -->
        <div class="form-section">
            <form action="{{ route('guru_bk.konseling.hasil.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="konseling_id">Pilih Siswa / Konseling</label>
                    <select id="konseling_id" name="konseling_id" required>
                        <option value="">-- Pilih Konseling --</option>
                        @foreach($konselings as $konseling)
                            <option value="{{ $konseling->id }}">
                                {{ $konseling->siswa->nama }} - {{ $konseling->judul }} ({{ $konseling->tanggal_konseling ? $konseling->tanggal_konseling->format('d/m/Y') : 'Belum dijadwalkan' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-group-voice">
                    <label for="masalah">Masalah Yang Dikemukakan</label>
                    <textarea 
                        id="masalah" 
                        name="masalah" 
                        rows="4" 
                        placeholder="Tuliskan masalah yang dikemukakan siswa atau gunakan voice input..."
                        required
                    ></textarea>
                    <button type="button" class="voice-btn" onclick="startVoiceInput('masalah')" title="Voice Input">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>

                <div class="form-group form-group-voice">
                    <label for="analisis">Analisis & Observasi</label>
                    <textarea 
                        id="analisis" 
                        name="analisis" 
                        rows="4" 
                        placeholder="Tuliskan hasil analisis dan observasi atau gunakan voice input..."
                        required
                    ></textarea>
                    <button type="button" class="voice-btn" onclick="startVoiceInput('analisis')" title="Voice Input">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>

                <div class="form-group form-group-voice">
                    <label for="rencana">Rencana Tindak Lanjut</label>
                    <textarea 
                        id="rencana" 
                        name="rencana" 
                        rows="4" 
                        placeholder="Tuliskan rencana tindak lanjut atau gunakan voice input..."
                        required
                    ></textarea>
                    <button type="button" class="voice-btn" onclick="startVoiceInput('rencana')" title="Voice Input">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori Hasil</label>
                    <select id="kategori" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Perlu Tindak Lanjut">Perlu Tindak Lanjut</option>
                        <option value="Dalam Proses">Dalam Proses</option>
                        <option value="Rujukan">Rujukan</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Side - Calendar & List -->
        <div class="sidebar">
            <!-- Calendar -->
            <div class="calendar-card">
                <div class="calendar-header">
                    <h3 id="currentMonthYear">{{ now()->format('F Y') }}</h3>
                    <div class="calendar-nav">
                        <button type="button" onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                        <button type="button" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="calendar-weekdays">
                    <div class="calendar-weekday">Su</div>
                    <div class="calendar-weekday">Mo</div>
                    <div class="calendar-weekday">Tu</div>
                    <div class="calendar-weekday">We</div>
                    <div class="calendar-weekday">Th</div>
                    <div class="calendar-weekday">Fr</div>
                    <div class="calendar-weekday">Sa</div>
                </div>

                <div class="calendar-days" id="calendarDays">
                    <!-- Will be generated by JavaScript -->
                </div>

                <div style="margin-top: 16px; display: flex; gap: 12px;">
                    <button type="button" class="btn btn-secondary" style="flex: 1; font-size: 14px; padding: 10px;" onclick="cancelDateSelection()">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" style="flex: 1; font-size: 14px; padding: 10px;" onclick="selectDate()">
                        Done
                    </button>
                </div>
            </div>

            <!-- List View -->
            <div class="list-card">
                <div class="list-header">
                    <h3>Riwayat Catatan</h3>
                    <div class="list-actions">
                        <button type="button" title="Refresh" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <table class="list-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilKonselings as $hasil)
                            <tr onclick="window.location.href='{{ route('guru_bk.konseling.hasil.show', $hasil->id) }}'" style="cursor: pointer;">
                                <td>{{ $hasil->created_at->format('d/m/Y') }}</td>
                                <td>{{ $hasil->konseling->siswa->nama }}</td>
                                <td>
                                    <span class="status-badge {{ strtolower(str_replace(' ', '-', $hasil->kategori)) }}">
                                        {{ $hasil->kategori }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 32px; color: #9CA3AF;">
                                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 8px; display: block;"></i>
                                    Belum ada data catatan konseling
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentDate = new Date();
let selectedDate = null;

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update month/year display
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    document.getElementById('currentMonthYear').textContent = monthNames[month] + ' ' + year;
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    // Clear calendar
    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';
    
    // Add previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        calendarDays.innerHTML += `<div class="calendar-day disabled">${day}</div>`;
    }
    
    // Add current month days
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        let classes = 'calendar-day';
        if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
            classes += ' today';
        }
        calendarDays.innerHTML += `<div class="${classes}" onclick="selectDay(${day})">${day}</div>`;
    }
    
    // Add next month days
    const remainingCells = 42 - (firstDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        calendarDays.innerHTML += `<div class="calendar-day disabled">${day}</div>`;
    }
}

function selectDay(day) {
    // Remove active class from all days
    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
    
    // Add active class to selected day
    event.target.classList.add('active');
    
    selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

function selectDate() {
    if (selectedDate) {
        alert('Selected date: ' + selectedDate.toLocaleDateString());
        // You can use this date for filtering or other purposes
    } else {
        alert('Please select a date first');
    }
}

function cancelDateSelection() {
    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
    selectedDate = null;
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin menghapus semua input?')) {
        document.querySelector('form').reset();
    }
}

// Voice Recognition
let currentRecognition = null;
let currentTargetId = null;

function showVoiceNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'voice-notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function startVoiceInput(textareaId) {
    const textarea = document.getElementById(textareaId);
    const button = textarea.parentElement.querySelector('.voice-btn');
    
    // Check if Speech Recognition is supported
    if (!('webkitSpeechRecognition' in window || 'SpeechRecognition' in window)) {
        alert('❌ Voice input tidak didukung di browser ini.\n\nGunakan Google Chrome atau Microsoft Edge.');
        return;
    }
    
    // If already recording this field, stop it
    if (currentRecognition && currentTargetId === textareaId) {
        currentRecognition.stop();
        button.classList.remove('recording');
        showVoiceNotification('🛑 Voice input dihentikan');
        return;
    }
    
    // Stop any existing recognition
    if (currentRecognition) {
        currentRecognition.stop();
        document.querySelectorAll('.voice-btn').forEach(btn => btn.classList.remove('recording'));
    }
    
    // Create new recognition instance
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();
    
    recognition.lang = 'id-ID';
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    
    recognition.onstart = function() {
        button.classList.add('recording');
        showVoiceNotification('🎤 Mendengarkan... Silakan berbicara.');
        currentRecognition = recognition;
        currentTargetId = textareaId;
    };
    
    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        
        // Append to existing text or replace
        if (textarea.value.trim()) {
            textarea.value += ' ' + transcript;
        } else {
            textarea.value = transcript;
        }
        
        // Auto resize
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
        
        showVoiceNotification('✅ Voice berhasil ditangkap!');
    };
    
    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
        button.classList.remove('recording');
        
        let errorMsg = '';
        switch(event.error) {
            case 'no-speech':
                errorMsg = '⚠️ Tidak mendengar suara. Coba lagi.';
                break;
            case 'audio-capture':
                errorMsg = '⚠️ Microphone tidak ditemukan.';
                break;
            case 'not-allowed':
                setTimeout(() => {
                    alert('🔴 MICROPHONE AKSES DITOLAK!\n\n' +
                        '📋 Langkah untuk mengizinkan:\n\n' +
                        '1️⃣ Klik icon 🔒 di sebelah URL\n' +
                        '2️⃣ Cari pengaturan "Microphone"\n' +
                        '3️⃣ Ubah ke "Allow" / "Izinkan"\n' +
                        '4️⃣ Refresh halaman (F5)\n' +
                        '5️⃣ Klik tombol 🎤 lagi');
                }, 100);
                break;
            case 'network':
                errorMsg = '⚠️ Kesalahan jaringan.';
                break;
            default:
                errorMsg = '⚠️ Kesalahan: ' + event.error;
        }
        
        if (errorMsg) {
            showVoiceNotification(errorMsg);
        }
        
        currentRecognition = null;
        currentTargetId = null;
    };
    
    recognition.onend = function() {
        button.classList.remove('recording');
        currentRecognition = null;
        currentTargetId = null;
    };
    
    // Start recognition
    try {
        recognition.start();
        console.log('Voice recognition started for:', textareaId);
    } catch (error) {
        console.error('Error starting recognition:', error);
        showVoiceNotification('⚠️ Gagal memulai voice input. Refresh halaman.');
    }
}

// Initialize calendar on page load
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin menyimpan catatan hasil konseling ini?')) {
            this.submit();
        }
    });
    
    // Auto resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});
</script>

<style>
@keyframes slideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
</style>
@endpush
