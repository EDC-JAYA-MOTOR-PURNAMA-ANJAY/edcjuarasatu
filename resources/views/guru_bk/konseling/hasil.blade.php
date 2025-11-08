@extends('layouts.app-guru-bk')

@section('title', 'Catatan Hasil Konseling - Guru BK')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap');
    
    body {
        font-family: 'Roboto', sans-serif;
        background: #FFFFFF;
    }
    
    /* Voice Button Animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .voice-recording {
        animation: pulse 1.5s ease-in-out infinite;
    }
    
    /* Notification Animation */
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .notification-slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    /* Custom dropdown arrow */
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L2 4h8z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 36px;
    }

    /* Enhanced Button Animations */
    .btn-simpan {
        position: relative;
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 12px 32px;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 6px 16px rgba(128, 0, 255, 0.3),
                    0 2px 8px rgba(128, 0, 255, 0.2);
        transform: translateY(0);
        overflow: hidden;
    }

    .btn-simpan::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.2), 
            transparent);
        transition: left 0.6s ease;
    }

    .btn-simpan:hover {
        transform: translateY(2px);
        box-shadow: 0 4px 8px rgba(128, 0, 255, 0.25),
                    0 1px 4px rgba(128, 0, 255, 0.15);
        background: linear-gradient(135deg, #7500EB 0%, #5F00C0 100%);
    }

    .btn-simpan:hover::before {
        left: 100%;
    }

    .btn-simpan:active {
        transform: translateY(4px);
        box-shadow: 0 2px 4px rgba(128, 0, 255, 0.1),
                    0 1px 2px rgba(128, 0, 255, 0.05);
        background: linear-gradient(135deg, #6A00D4 0%, #5500A8 100%);
        transition: all 0.1s ease;
    }

    .btn-simpan:active::before {
        transition: none;
        left: 100%;
    }

    /* Hapus Button Animations */
    .btn-hapus {
        position: relative;
        background: linear-gradient(135deg, #D3D3D3 0%, #C0C0C0 100%);
        color: #444444;
        border: none;
        border-radius: 25px;
        padding: 12px 32px;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(0);
        overflow: hidden;
    }

    .btn-hapus:hover {
        transform: translateY(1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        background: linear-gradient(135deg, #C8C8C8 0%, #B0B0B0 100%);
    }

    .btn-hapus:active {
        transform: translateY(2px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        background: linear-gradient(135deg, #B8B8B8 0%, #A0A0A0 100%);
        transition: all 0.1s ease;
    }

    /* Calendar Button Animations */
    .calendar-nav-btn {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1);
    }

    .calendar-nav-btn:hover {
        transform: scale(1.1);
        background: #F0F0F0 !important;
    }

    .calendar-nav-btn:active {
        transform: scale(0.95);
        transition: all 0.1s ease;
    }

    /* Calendar Day Animations */
    .calendar-day {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1);
    }

    .calendar-day:hover:not(.disabled) {
        transform: scale(1.05);
        background: #F5F5F5;
    }

    .calendar-day.active {
        transform: scale(1.05);
        animation: daySelect 0.3s ease-out;
    }

    @keyframes daySelect {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1.05); }
    }

    /* Voice Button Enhanced Animations */
    .voice-btn {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1);
    }

    .voice-btn:hover {
        transform: scale(1.1);
    }

    .voice-btn:active {
        transform: scale(0.95);
    }

    /* Input Focus Animations */
    .form-input {
        transition: all 0.3s ease;
    }

    .form-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(128, 0, 255, 0.15);
    }

    /* Table Row Animations */
    .table-row {
        transition: all 0.3s ease;
    }

    .table-row:hover {
        transform: translateX(4px);
        background: #F8F8F8;
    }

    /* Status Badge Animations */
    .status-badge {
        transition: all 0.3s ease;
        transform: scale(1);
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    /* Loading Animation for Form Submission */
    @keyframes buttonLoading {
        0% { transform: translateY(0) scale(1); }
        50% { transform: translateY(2px) scale(0.98); }
        100% { transform: translateY(0) scale(1); }
    }

    .btn-loading {
        animation: buttonLoading 1.5s ease-in-out infinite;
        pointer-events: none;
        opacity: 0.8;
    }

    /* Success Animation */
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .success-animation {
        animation: successPulse 0.6s ease-out;
    }

    /* Ripple Effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-white p-6">
    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Left Column - Main Form (75%) -->
        <div class="xl:col-span-3">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="text-[18px] font-bold text-[#5B2C91]">Catatan Hasil Konseling</h1>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 success-animation">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form id="konselingForm" action="{{ route('guru_bk.konseling.hasil.store') }}" method="POST">
                    @csrf
                    
                    <!-- Student Selection -->
                    <div class="mb-4">
                        <label for="konseling_id" class="block text-sm font-medium text-[#555555] mb-2">
                            Pilih Siswa / Konseling
                        </label>
                        <select 
                            id="konseling_id" 
                            name="konseling_id" 
                            required
                            class="w-full h-12 px-4 border border-[#D9D9D9] rounded-lg focus:ring-2 focus:ring-[#8000FF] focus:border-[#8000FF] transition-all duration-300 form-input bg-white appearance-none"
                        >
                            <option value="">-- Pilih Konseling --</option>
                            @foreach($konselings as $konseling)
                                <option value="{{ $konseling->id }}">
                                    {{ $konseling->siswa->nama }} - {{ $konseling->judul }} ({{ $konseling->tanggal_konseling ? $konseling->tanggal_konseling->format('d/m/Y') : 'Belum dijadwalkan' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Problems Field -->
                    <div class="mb-4 relative">
                        <label for="masalah" class="block text-sm font-medium text-[#555555] mb-2">
                            Masalah Yang Diajukan
                        </label>
                        <textarea 
                            id="masalah" 
                            name="masalah" 
                            rows="3" 
                            placeholder="Tuliskan masalah yang dikemukakan siswa atau gunakan voice input..."
                            required
                            class="w-full h-12 px-4 py-3 pr-12 border border-[#D9D9D9] rounded-lg focus:ring-2 focus:ring-[#8000FF] focus:border-[#8000FF] transition-all duration-300 form-input resize-none text-[#333333] text-sm"
                        ></textarea>
                        <button 
                            type="button" 
                            onclick="startVoiceInput('masalah')" 
                            title="Voice Input"
                            class="absolute right-3 top-9 w-8 h-8 border border-[#D9D9D9] bg-white rounded-lg flex items-center justify-center text-gray-500 hover:border-[#8000FF] hover:text-[#8000FF] transition-all voice-btn voice-btn-masalah"
                        >
                            <i class="fas fa-microphone text-sm"></i>
                        </button>
                    </div>

                    <!-- Analysis Field -->
                    <div class="mb-4 relative">
                        <label for="analisis" class="block text-sm font-medium text-[#555555] mb-2">
                            Analisis & Observasi
                        </label>
                        <textarea 
                            id="analisis" 
                            name="analisis" 
                            rows="3" 
                            placeholder="Tuliskan hasil analisis dan observasi atau gunakan voice input..."
                            required
                            class="w-full h-12 px-4 py-3 pr-12 border border-[#D9D9D9] rounded-lg focus:ring-2 focus:ring-[#8000FF] focus:border-[#8000FF] transition-all duration-300 form-input resize-none text-[#333333] text-sm"
                        ></textarea>
                        <button 
                            type="button" 
                            onclick="startVoiceInput('analisis')" 
                            title="Voice Input"
                            class="absolute right-3 top-9 w-8 h-8 border border-[#D9D9D9] bg-white rounded-lg flex items-center justify-center text-gray-500 hover:border-[#8000FF] hover:text-[#8000FF] transition-all voice-btn voice-btn-analisis"
                        >
                            <i class="fas fa-microphone text-sm"></i>
                        </button>
                    </div>

                    <!-- Follow-up Plan Field -->
                    <div class="mb-4 relative">
                        <label for="rencana" class="block text-sm font-medium text-[#555555] mb-2">
                            Rencana Tindak Lanjut
                        </label>
                        <textarea 
                            id="rencana" 
                            name="rencana" 
                            rows="4" 
                            placeholder="Tuliskan rencana tindak lanjut atau gunakan voice input..."
                            required
                            class="w-full px-4 py-3 pr-12 border border-[#D9D9D9] rounded-lg focus:ring-2 focus:ring-[#8000FF] focus:border-[#8000FF] transition-all duration-300 form-input resize-none text-[#333333] text-sm"
                        ></textarea>
                        <button 
                            type="button" 
                            onclick="startVoiceInput('rencana')" 
                            title="Voice Input"
                            class="absolute right-3 top-9 w-8 h-8 border border-[#D9D9D9] bg-white rounded-lg flex items-center justify-center text-gray-500 hover:border-[#8000FF] hover:text-[#8000FF] transition-all voice-btn voice-btn-rencana"
                        >
                            <i class="fas fa-microphone text-sm"></i>
                        </button>
                    </div>

                    <!-- Result Category -->
                    <div class="mb-6">
                        <label for="kategori" class="block text-sm font-medium text-[#555555] mb-2">
                            Kategori Hasil
                        </label>
                        <select 
                            id="kategori" 
                            name="kategori" 
                            required
                            class="w-full h-12 px-4 border border-[#D9D9D9] rounded-lg focus:ring-2 focus:ring-[#8000FF] focus:border-[#8000FF] transition-all duration-300 form-input bg-white appearance-none"
                        >
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Perlu Tindak Lanjut">Perlu Tindak Lanjut</option>
                            <option value="Dalam Proses">Dalam Proses</option>
                            <option value="Rujukan">Rujukan</option>
                        </select>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 justify-center">
                        <button 
                            type="button" 
                            onclick="resetForm()"
                            class="btn-hapus flex items-center justify-center gap-2 text-sm"
                        >
                            <i class="fas fa-trash text-xs"></i>
                            Hapus
                        </button>
                        <button 
                            type="submit"
                            class="btn-simpan flex items-center justify-center gap-2 text-sm"
                            id="submitBtn"
                        >
                            <i class="fas fa-save text-xs"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Sidebar (25%) -->
        <div class="space-y-6">
            <!-- Calendar Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <button 
                        type="button" 
                        onclick="previousMonth()"
                        class="w-6 h-6 text-[#444444] flex items-center justify-center hover:bg-gray-100 rounded transition-all calendar-nav-btn"
                    >
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <h3 class="text-sm font-medium text-[#444444]" id="currentMonthYear">
                        {{ now()->format('F Y') }}
                    </h3>
                    <button 
                        type="button" 
                        onclick="nextMonth()"
                        class="w-6 h-6 text-[#444444] flex items-center justify-center hover:bg-gray-100 rounded transition-all calendar-nav-btn"
                    >
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>

                <!-- Weekdays -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Su</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Mo</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Tu</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">We</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Th</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Fr</div>
                    <div class="text-center text-xs font-medium text-[#666666] py-2">Sa</div>
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-1" id="calendarDays">
                    <!-- Generated by JavaScript -->
                </div>

                <!-- Calendar Actions -->
                <div class="flex gap-2 mt-4">
                    <button 
                        type="button" 
                        onclick="cancelDateSelection()"
                        class="flex-1 px-3 py-2 bg-gray-200 text-[#444444] rounded-lg text-xs font-medium hover:bg-gray-300 transition-all btn-hapus"
                        style="border-radius: 8px; padding: 8px 12px;"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        onclick="selectDate()"
                        class="flex-1 px-3 py-2 bg-[#8000FF] text-white rounded-lg text-xs font-medium hover:bg-[#6C00D6] transition-all btn-simpan"
                        style="border-radius: 8px; padding: 8px 12px;"
                    >
                        Done
                    </button>
                </div>
            </div>

            <!-- List View Card -->
            <div class="bg-white rounded-lg border border-[#E0E0E0] overflow-hidden">
                <!-- Table Header -->
                <div class="bg-[#F3E6FF] px-4 py-3">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-4 text-xs font-medium text-[#4B0082] text-center">Tanggal</div>
                        <div class="col-span-4 text-xs font-medium text-[#4B0082] text-center">Siswa</div>
                        <div class="col-span-4 text-xs font-medium text-[#4B0082] text-center">Status</div>
                    </div>
                </div>
                
                <!-- Table Body -->
                <div class="divide-y divide-[#E5E5E5]">
                    @forelse($hasilKonselings as $hasil)
                    <div class="px-4 py-3 hover:bg-gray-50 transition-all table-row">
                        <div class="grid grid-cols-12 gap-2 items-center">
                            <div class="col-span-4 text-xs text-[#444444] text-center">
                                {{ $hasil->created_at->format('d/m/Y') }}
                            </div>
                            <div class="col-span-4 text-xs text-[#444444] text-center">
                                {{ $hasil->konseling->siswa->nama }}
                            </div>
                            <div class="col-span-4 text-center">
                                @php
                                    $statusClasses = [
                                        'Selesai' => 'bg-green-100 text-green-800',
                                        'Perlu Tindak Lanjut' => 'bg-yellow-100 text-yellow-800',
                                        'Dalam Proses' => 'bg-blue-100 text-blue-800',
                                        'Rujukan' => 'bg-orange-100 text-orange-800'
                                    ];
                                    $class = $statusClasses[$hasil->kategori] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full status-badge {{ $class }}">
                                    {{ $hasil->kategori }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-8 text-center">
                        <i class="fas fa-inbox text-2xl text-gray-400 mb-2 block"></i>
                        <span class="text-xs text-gray-500">Belum ada data catatan konseling</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentDate = new Date();
let selectedDate = null;

// Ripple Effect Function
function createRipple(event) {
    const button = event.currentTarget;
    const circle = document.createElement("span");
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.getBoundingClientRect().left - radius}px`;
    circle.style.top = `${event.clientY - button.getBoundingClientRect().top - radius}px`;
    circle.classList.add("ripple");

    const ripple = button.getElementsByClassName("ripple")[0];
    if (ripple) {
        ripple.remove();
    }

    button.appendChild(circle);
}

// Add ripple effect to buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-simpan, .btn-hapus');
    buttons.forEach(button => {
        button.addEventListener('click', createRipple);
    });
});

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
        calendarDays.innerHTML += `<div class="text-center py-2 text-xs text-gray-400 cursor-not-allowed calendar-day disabled">${day}</div>`;
    }
    
    // Add current month days
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        let classes = 'text-center py-2 text-xs text-[#444444] cursor-pointer rounded-lg hover:bg-[#F5F5F5] transition-all calendar-day';
        
        calendarDays.innerHTML += `<div class="${classes}" onclick="selectDay(${day})">${day}</div>`;
    }
    
    // Add next month days
    const remainingCells = 42 - (firstDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        calendarDays.innerHTML += `<div class="text-center py-2 text-xs text-gray-400 cursor-not-allowed calendar-day disabled">${day}</div>`;
    }
}

function selectDay(day) {
    // Remove active class from all days
    document.querySelectorAll('#calendarDays > div').forEach(d => {
        d.classList.remove('bg-[#8000FF]', 'text-white', 'active');
        if (!d.classList.contains('disabled')) {
            d.classList.add('text-[#444444]', 'hover:bg-[#F5F5F5]');
        }
    });
    
    // Add active class to selected day
    event.target.classList.remove('text-[#444444]', 'hover:bg-[#F5F5F5]');
    event.target.classList.add('bg-[#8000FF]', 'text-white', 'active');
    
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
        // Add success animation
        const doneBtn = event.target;
        doneBtn.classList.add('success-animation');
        setTimeout(() => {
            doneBtn.classList.remove('success-animation');
        }, 600);
        
        alert('Selected date: ' + selectedDate.toLocaleDateString());
        // You can use this date for filtering or other purposes
    } else {
        alert('Please select a date first');
    }
}

function cancelDateSelection() {
    document.querySelectorAll('#calendarDays > div').forEach(d => {
        d.classList.remove('bg-[#8000FF]', 'text-white', 'active');
        if (!d.classList.contains('disabled')) {
            d.classList.add('text-[#444444]', 'hover:bg-[#F5F5F5]');
        }
    });
    selectedDate = null;
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin menghapus semua input?')) {
        document.querySelector('form').reset();
        
        // Add reset animation
        const form = document.getElementById('konselingForm');
        form.style.opacity = '0.7';
        setTimeout(() => {
            form.style.opacity = '1';
        }, 300);
    }
}

// Voice Recognition
let currentRecognition = null;
let currentTargetId = null;

function showVoiceNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-5 right-5 bg-gray-900 text-white px-4 py-3 rounded-lg shadow-lg notification-slide-in z-50';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function startVoiceInput(textareaId) {
    const textarea = document.getElementById(textareaId);
    const button = document.querySelector(`.voice-btn-${textareaId}`);
    
    // Check if Speech Recognition is supported
    if (!('webkitSpeechRecognition' in window || 'SpeechRecognition' in window)) {
        alert('❌ Voice input tidak didukung di browser ini.\n\nGunakan Google Chrome atau Microsoft Edge.');
        return;
    }
    
    // If already recording this field, stop it
    if (currentRecognition && currentTargetId === textareaId) {
        currentRecognition.stop();
        button.classList.remove('voice-recording', 'bg-red-600', 'text-white', 'border-red-600');
        button.classList.add('border-[#D9D9D9]', 'text-gray-500', 'bg-white');
        showVoiceNotification('🛑 Voice input dihentikan');
        return;
    }
    
    // Stop any existing recognition
    if (currentRecognition) {
        currentRecognition.stop();
        document.querySelectorAll('[class*="voice-btn-"]').forEach(btn => {
            btn.classList.remove('voice-recording', 'bg-red-600', 'text-white', 'border-red-600');
            btn.classList.add('border-[#D9D9D9]', 'text-gray-500', 'bg-white');
        });
    }
    
    // Create new recognition instance
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();
    
    recognition.lang = 'id-ID';
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    
    recognition.onstart = function() {
        button.classList.remove('border-[#D9D9D9]', 'text-gray-500', 'bg-white');
        button.classList.add('voice-recording', 'bg-red-600', 'text-white', 'border-red-600');
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
        button.classList.remove('voice-recording', 'bg-red-600', 'text-white', 'border-red-600');
        button.classList.add('border-[#D9D9D9]', 'text-gray-500', 'bg-white');
        
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
        button.classList.remove('voice-recording', 'bg-red-600', 'text-white', 'border-red-600');
        button.classList.add('border-[#D9D9D9]', 'text-gray-500', 'bg-white');
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

// Enhanced Form Submission
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
    
    const form = document.getElementById('konselingForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add loading animation
        submitBtn.classList.add('btn-loading');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Menyimpan...';
        
        setTimeout(() => {
            if (confirm('Apakah Anda yakin ingin menyimpan catatan hasil konseling ini?')) {
                // Remove loading animation
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = '<i class="fas fa-save text-xs"></i> Simpan';
                
                // Add success animation
                submitBtn.classList.add('success-animation');
                setTimeout(() => {
                    submitBtn.classList.remove('success-animation');
                }, 600);
                
                // Submit the form
                this.submit();
            } else {
                // Remove loading animation if cancelled
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = '<i class="fas fa-save text-xs"></i> Simpan';
            }
        }, 1000);
    });
    
    // Auto resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Set initial height
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    });

    // Add focus animations to inputs
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('transform', 'scale-105');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('transform', 'scale-105');
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