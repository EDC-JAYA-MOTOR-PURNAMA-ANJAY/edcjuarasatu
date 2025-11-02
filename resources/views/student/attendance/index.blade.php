@extends('layouts.app')

@section('title', 'Absensi - Educounsel')

@push('styles')
<style>
    /* Animasi untuk row baru muncul */
    .new-row-animation {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .new-row-animation.show {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* Animasi pulse untuk badge */
    @keyframes badgePulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    .badge-pulse {
        animation: badgePulse 1.5s ease-in-out;
    }

    /* Animasi pulse untuk statistik card */
    @keyframes statPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .stat-pulse {
        animation: statPulse 0.6s ease-in-out;
    }

    /* Glow effect untuk row baru */
    .new-row-animation {
        position: relative;
    }

    .new-row-animation::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(147, 51, 234, 0.1), 
            transparent
        );
        transform: translateX(-100%);
        transition: transform 0.8s ease;
    }

    .new-row-animation.show::before {
        transform: translateX(100%);
    }

    /* Highlight effect untuk row baru */
    @keyframes highlightRow {
        0% {
            background-color: rgba(147, 51, 234, 0.1);
        }
        100% {
            background-color: transparent;
        }
    }

    .new-row-animation.show {
        animation: highlightRow 2s ease-out forwards;
    }

    /* Smooth transition untuk semua row */
    tbody tr {
        transition: all 0.3s ease;
    }

    /* Bounce in animation untuk empty state removal */
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }

    .fade-out-animation {
        animation: fadeOut 0.4s ease-out forwards;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Hero Header - GAMBAR DIPERBESAR -->
    <div class="px-6 py-3">
        <div class="bg-[#F1E6FA] rounded-xl p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <!-- Left Side - Text Content with Back Button -->
                <div class="flex-1 z-10">
                    <div class="flex items-center mb-1">
                        <!-- Back Icon -->
                        <button onclick="history.back()" class="mr-2 text-[#1F2937] hover:text-purple-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <h1 class="text-lg font-medium text-[#1F2937] font-roboto">Absensi</h1>
                    </div>
                    <p class="text-gray-600 text-xs font-roboto ml-6">
                        Cek Status hadir, izin, atau alpha di halaman ini.
                    </p>
                </div>

                <!-- Right Side - Chat Illustration - DIPERBESAR -->
                <div class="flex-shrink-0 z-10">
                    <img src="{{ asset('images/ilustrasi_chat.png') }}"
                         alt="Chat Illustration"
                         class="w-24 h-24 object-contain transform hover:scale-105 transition-transform duration-300">
                </div>
            </div>

            <!-- Background pattern untuk mengisi space -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200 opacity-20 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 opacity-30 rounded-full translate-y-4 -translate-x-4"></div>
        </div>
    </div>

    <!-- Statistics Cards - IMPROVED DESIGN -->
    <div class="px-6 mt-3">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Total Hadir -->
            <div class="bg-white rounded-xl p-4 relative overflow-hidden border-0 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="text-2xl font-bold text-gray-900 mb-1" id="totalHadirValue">{{ $totalHadir }}</div>
                <div class="text-gray-500 text-xs font-medium">Total Hadir</div>
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-green-500 rounded-b-xl"></div>
                <div class="absolute top-2 right-2 w-7 h-7 bg-green-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-500 text-xs"></i>
                </div>
            </div>

            <!-- Total Izin & Sakit -->
            <div class="bg-white rounded-xl p-4 relative overflow-hidden border-0 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="text-2xl font-bold text-gray-900 mb-1" id="totalIzinSakitValue">{{ $totalIzinSakit }}</div>
                <div class="text-gray-500 text-xs font-medium">Total Izin & Sakit</div>
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-yellow-500 rounded-b-xl"></div>
                <div class="absolute top-2 right-2 w-7 h-7 bg-yellow-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-medical text-yellow-500 text-xs"></i>
                </div>
            </div>

            <!-- Total Alpha -->
            <div class="bg-white rounded-xl p-4 relative overflow-hidden border-0 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="text-2xl font-bold text-gray-900 mb-1" id="totalAlphaValue">{{ $totalAlpha }}</div>
                <div class="text-gray-500 text-xs font-medium">Total Alpha</div>
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-red-500 rounded-b-xl"></div>
                <div class="absolute top-2 right-2 w-7 h-7 bg-red-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-500 text-xs"></i>
                </div>
            </div>

            <!-- Total Terlambat -->
            <div class="bg-white rounded-xl p-4 relative overflow-hidden border-0 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="text-2xl font-bold text-gray-900 mb-1" id="totalTerlambatValue">{{ $totalTerlambat }}</div>
                <div class="text-gray-500 text-xs font-medium">Total Terlambat</div>
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-orange-500 rounded-b-xl"></div>
                <div class="absolute top-2 right-2 w-7 h-7 bg-orange-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-500 text-xs"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-6 mt-4">
        <div class="flex space-x-3">
            <!-- Absen Button -->
            <button id="absenBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center space-x-2 transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-check-circle text-xs"></i>
                <span>Absen</span>
            </button>

            <!-- Buat Izin Button -->
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center space-x-2 transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-file-medical text-xs"></i>
                <span>Buat Izin</span>
            </button>
        </div>
    </div>

    <!-- Attendance Table - IMPROVED DESIGN -->
    <div class="px-6 mt-4 pb-6">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#E5E7EB]">
                            <th class="px-4 py-3 text-left text-[15px] font-medium text-[#9CA3AF] font-roboto">
                                Nama
                            </th>
                            <th class="px-4 py-3 text-left text-[15px] font-medium text-[#9CA3AF] font-roboto">
                                Tanggal
                            </th>
                            <th class="px-4 py-3 text-left text-[15px] font-medium text-[#9CA3AF] font-roboto">
                                Waktu
                            </th>
                            <th class="px-4 py-3 text-left text-[15px] font-medium text-[#9CA3AF] font-roboto">
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody" class="divide-y divide-[#E5E7EB]">
                        <!-- Data absensi akan ditambahkan di sini secara dinamis -->
                        
                        @forelse($absensiList as $absensi)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                                {{ auth()->user()->nama }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                                {{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $waktu = $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk) : null;
                                    $isLate = $waktu && ($waktu->hour > 7 || ($waktu->hour == 7 && $waktu->minute > 0));
                                @endphp
                                @if($waktu)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-medium {{ $isLate ? 'bg-[#FCA5A5] text-[#7F1D1D]' : 'bg-[#A7F3D0] text-[#065F46]' }} font-roboto">
                                    {{ $waktu->format('H:i') }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-medium bg-gray-200 text-gray-700 font-roboto">
                                    -
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State untuk Siswa yang Belum Punya Data -->
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-500 font-roboto">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4"></i>
                                    <p class="text-base font-semibold text-gray-700 mb-2">Belum Ada Data Absensi</p>
                                    <p class="text-sm text-gray-500 mb-1">Anda belum memiliki riwayat absensi</p>
                                    <p class="text-xs text-gray-400">Klik tombol "Absen" untuk mencatat kehadiran Anda hari ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination & Info -->
        @if($absensiList->count() > 0)
        <div class="mt-4 flex justify-between items-center">
            <div class="text-gray-500 text-xs font-roboto">
                Menampilkan {{ $absensiList->count() }} data absensi
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-25 backdrop-blur-sm"></div>
    <div class="bg-white rounded-xl p-8 max-w-sm w-full mx-4 shadow-lg z-10">
        <div class="flex flex-col items-center text-center">
            <!-- Success Icon -->
            <div class="w-24 h-24 bg-[#1CD062] rounded-full flex items-center justify-center mb-5">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>

            <!-- Title -->
            <h3 class="text-[22px] font-bold text-black mb-1 font-roboto">Berhasil Absen !</h3>

            <!-- Message -->
            <p class="text-[15px] text-[#333333] mb-6 font-roboto">Absen telah ditambahkan</p>

            <!-- OK Button -->
            <button id="closePopup" class="bg-[#1CD062] hover:brightness-95 text-white px-6 py-3 rounded-lg font-semibold w-full transition-all duration-200 shadow-[0_4px_12px_rgba(28,208,98,0.25)] font-roboto">
                Oke
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Import Roboto Font */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

    .font-roboto {
        font-family: 'Roboto', sans-serif;
    }

    /* Font family untuk popup */
    #successPopup {
        font-family: 'Roboto', 'Inter', 'Poppins', system-ui, -apple-system, sans-serif;
    }

    /* Animation for popup */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        to {
            opacity: 0;
            transform: scale(0.9) translateY(-10px);
        }
    }

    .popup-show {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .popup-hide {
        animation: fadeOut 0.3s ease-out forwards;
    }

    /* Improved table styling */
    table {
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 16px;
    }

    /* Ensure consistent spacing */
    .divide-y > * + * {
        border-top-width: 1px;
    }

    /* Highlight effect untuk row baru */
    .new-attendance-highlight {
        background-color: #FEF3C7 !important;
        transition: background-color 2s ease;
    }

    .highlight-fade {
        background-color: transparent !important;
    }

    /* Smooth entry animation */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .new-attendance-highlight {
        animation: slideInDown 0.5s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let femaleVoice = null;
    let voicesReady = false;
    
    function loadFemaleVoice() {
        const voices = window.speechSynthesis.getVoices();
        if (voices.length > 0 && !voicesReady) {
            console.log('🎤 Loading FEMALE voice for attendance...');
            
            // PRIORITAS: GOOGLE VOICE FIRST untuk suara seperti Google Assistant!
            femaleVoice = 
                // 1. Google Indonesia (PRIORITAS UTAMA!)
                voices.find(v => v.name.toLowerCase().includes('google') && v.lang.startsWith('id')) ||
                // 2. Microsoft Gadis/Damayanti (Backup terbaik)
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('gadis')) ||
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('damayanti')) ||
                // 3. Any female Indonesian
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('female')) ||
                voices.find(v => (v.lang === 'id-ID' || v.lang.startsWith('id-')) && v.name.toLowerCase().includes('perempuan')) ||
                // 4. Default Indonesian
                voices.find(v => v.lang === 'id-ID');
            
            voicesReady = true;
            console.log('✅ Attendance voice:', femaleVoice?.name || 'Default');
            console.log('   Gender:', femaleVoice?.name.toLowerCase().match(/(female|gadis|damayanti|perempuan)/) ? '👩 FEMALE' : '⚠️ Check manually');
        }
    }
    
    function speakAttendanceSuccess(namaSiswa) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            
            if (!voicesReady) loadFemaleVoice();
            
            setTimeout(() => {
                // Message SUPER BERSEMANGAT & MOTIVATING!
                const message = `Keren! ${namaSiswa} berhasil absen! Hebat! Ayo terus semangat belajar hari ini!`;
                const utterance = new SpeechSynthesisUtterance(message);
                utterance.lang = 'id-ID';
                utterance.rate = 0.95;  // ⚡⚡ SUPER CEPAT = SUPER ENERGIK!
                utterance.pitch = 1.22;  // 🎵🔥 SANGAT TINGGI = SANGAT CERIA!
                utterance.volume = 1.0;
                
                if (femaleVoice) {
                    utterance.voice = femaleVoice;
                }
                
                utterance.onend = () => console.log('✅ Attendance voice completed (ENERGIK!)');
                utterance.onerror = (e) => console.warn('❌ Attendance voice error:', e.error);
                
                console.log('🔊 Speaking (SEMANGAT!):', message);
                window.speechSynthesis.speak(utterance);
            }, 50);
        }
    }
    
    if ('speechSynthesis' in window) {
        loadFemaleVoice();
        window.speechSynthesis.onvoiceschanged = loadFemaleVoice;
        setTimeout(loadFemaleVoice, 100);
    }
    
    const absenBtn = document.getElementById('absenBtn');
    const successPopup = document.getElementById('successPopup');
    const closePopup = document.getElementById('closePopup');
    const tableBody = document.getElementById('attendanceTableBody');

    // Fungsi untuk format tanggal Indonesia
    function formatTanggalIndonesia(date) {
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[date.getDay()];
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        
        return `${dayName}, ${day} ${month} ${year}`;
    }

    // Fungsi untuk format waktu HH:MM
    function formatWaktu(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    // Fungsi untuk cek status absensi
    function cekStatusAbsensi(waktu) {
        const jam = waktu.getHours();
        const menit = waktu.getMinutes();
        
        // Jam 06:00 - 07:00 = Masuk (hijau)
        if ((jam === 6) || (jam === 7 && menit === 0)) {
            return {
                status: 'masuk',
                keterangan: 'Masuk',
                bgColor: 'bg-[#A7F3D0]',
                textColor: 'text-[#065F46]'
            };
        }
        // Jam 07:01 ke atas = Telat (merah)
        else {
            return {
                status: 'telat',
                keterangan: 'Telat',
                bgColor: 'bg-[#FCA5A5]',
                textColor: 'text-[#7F1D1D]'
            };
        }
    }

    // Fungsi untuk tambah row baru ke tabel
    function tambahAbsensi() {
        const now = new Date();
        const namaSiswa = "{{ auth()->user()->nama ?? 'Nama Siswa' }}"; // Ambil dari auth
        const tanggal = formatTanggalIndonesia(now);
        const waktu = formatWaktu(now);
        const statusData = cekStatusAbsensi(now);

        // Buat row baru
        const newRow = document.createElement('tr');
        newRow.className = 'hover:bg-gray-50 transition-colors cursor-pointer new-attendance-highlight';
        newRow.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                ${namaSiswa}
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                ${tanggal}
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-medium ${statusData.bgColor} ${statusData.textColor} font-roboto">
                    ${waktu}
                </span>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                ${statusData.keterangan}
            </td>
        `;

        // Tambahkan row baru di posisi paling atas
        tableBody.insertBefore(newRow, tableBody.firstChild);

        // Highlight effect untuk row baru
        setTimeout(() => {
            newRow.classList.add('highlight-fade');
        }, 100);

        // Add click event untuk row baru
        newRow.addEventListener('click', function() {
            const cells = this.querySelectorAll('td');
            const nama = cells[0].textContent.trim();
            const tanggal = cells[1].textContent.trim();
            const waktu = cells[2].textContent.trim();
            const keterangan = cells[3].textContent.trim();

            alert(`Detail Absensi:\n\nNama: ${nama}\nTanggal: ${tanggal}\nWaktu: ${waktu}\nKeterangan: ${keterangan}`);
        });

        // Update statistik
        updateStatistik(statusData.status);
    }

    // Fungsi untuk update statistik
    function updateStatistik(status) {
        if (status === 'masuk') {
            // Update Total Hadir
            const hadirCard = document.querySelector('.bg-green-500').closest('.bg-white');
            const hadirValue = hadirCard.querySelector('.text-2xl');
            hadirValue.textContent = parseInt(hadirValue.textContent) + 1;
        } else if (status === 'telat') {
            // Update Total Terlambat
            const telatCard = document.querySelector('.bg-orange-500').closest('.bg-white');
            const telatValue = telatCard.querySelector('.text-2xl');
            telatValue.textContent = parseInt(telatValue.textContent) + 1;
        }
    }

    // Absen button functionality
    absenBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin melakukan absen hari ini?')) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
            this.disabled = true;

            // AJAX call to store attendance ke database
            fetch('{{ route("student.attendance.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success popup
                    successPopup.classList.remove('hidden');
                    successPopup.classList.add('popup-show');
                    
                    // Reset button
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    // Tambahkan row baru dengan animasi smooth
                    setTimeout(() => {
                        addAbsensiRowWithAnimation(data.data);
                        updateStatistikWithAnimation();
                        
                        // 🔊 Speak attendance success dengan FEMALE voice
                        setTimeout(() => {
                            speakAttendanceSuccess(data.data.nama);
                        }, 500);
                    }, 800);
                } else {
                    alert(data.message || 'Terjadi kesalahan saat melakukan absen');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat melakukan absen');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        }
    });

    // Function untuk menambahkan row dengan animasi
    function addAbsensiRowWithAnimation(data) {
        const tbody = document.getElementById('attendanceTableBody');
        
        // Cek jika ada empty state, hapus dengan animasi
        const emptyState = tbody.querySelector('tr td[colspan="4"]');
        if (emptyState) {
            const emptyRow = emptyState.closest('tr');
            emptyRow.classList.add('fade-out-animation');
            
            // Hapus setelah animasi selesai
            setTimeout(() => {
                emptyRow.remove();
                insertNewRow();
            }, 400);
        } else {
            insertNewRow();
        }
        
        function insertNewRow() {
            // Buat row baru
            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-gray-50 transition-colors cursor-pointer new-row-animation';
            
            // Badge color
            const badgeClass = data.is_late ? 'bg-[#FCA5A5] text-[#7F1D1D]' : 'bg-[#A7F3D0] text-[#065F46]';
            
            newRow.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                    ${data.nama}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                    ${data.tanggal}
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-medium ${badgeClass} font-roboto badge-pulse">
                        ${data.waktu}
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-[14px] text-[#374151] font-roboto">
                    ${data.keterangan}
                </td>
            `;
            
            // Insert di posisi pertama dengan animasi
            tbody.insertBefore(newRow, tbody.firstChild);
            
            // Trigger animation
            setTimeout(() => {
                newRow.classList.add('show');
            }, 10);
            
            // Hapus class animasi setelah selesai
            setTimeout(() => {
                newRow.classList.remove('new-row-animation', 'show');
            }, 1500);
        }
    }

    // Function untuk update statistik dengan animasi counting
    function updateStatistikWithAnimation() {
        const hadirValue = document.getElementById('totalHadirValue');
        const currentValue = parseInt(hadirValue.textContent) || 0;
        const newValue = currentValue + 1;
        
        // Animasi counting
        animateCounter(hadirValue, currentValue, newValue, 500);
        
        // Tambahkan efek pulse pada card
        const hadirCard = hadirValue.closest('.bg-white');
        hadirCard.classList.add('stat-pulse');
        setTimeout(() => {
            hadirCard.classList.remove('stat-pulse');
        }, 600);
    }

    // Function untuk animasi counter
    function animateCounter(element, start, end, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.round(current);
        }, 16);
    }

    // Close popup functionality
    closePopup.addEventListener('click', function() {
        successPopup.classList.remove('popup-show');
        successPopup.classList.add('popup-hide');

        setTimeout(() => {
            successPopup.classList.add('hidden');
            successPopup.classList.remove('popup-hide');
        }, 300);
    });

    // Close popup when clicking outside
    successPopup.addEventListener('click', function(e) {
        if (e.target === successPopup) {
            successPopup.classList.remove('popup-show');
            successPopup.classList.add('popup-hide');

            setTimeout(() => {
                successPopup.classList.add('hidden');
                successPopup.classList.remove('popup-hide');
            }, 300);
        }
    });

    // Izin button functionality
    const izinBtn = document.querySelector('.bg-yellow-500');
    izinBtn.addEventListener('click', function() {
        window.location.href = "{{ route('student.counseling.create') }}";
    });

    // Table row click functionality
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            const cells = this.querySelectorAll('td');
            const nama = cells[0].textContent.trim();
            const tanggal = cells[1].textContent.trim();
            const waktu = cells[2].textContent.trim();
            const keterangan = cells[3].textContent.trim();

            alert(`Detail Absensi:\n\nNama: ${nama}\nTanggal: ${tanggal}\nWaktu: ${waktu}\nKeterangan: ${keterangan}`);
        });
    });
});
</script>
@endpush