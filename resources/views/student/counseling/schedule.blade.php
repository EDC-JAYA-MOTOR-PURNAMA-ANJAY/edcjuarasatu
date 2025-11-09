@extends('layouts.app')

@section('title', 'Jadwal Konseling - Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Roboto', sans-serif;
    }

    body {
        background: #F5F7FA;
        min-height: 100vh;
    }

    .schedule-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Header Banner */
    .header-banner {
        width: 100%;
        max-width: 1044px;
        height: 144px;
        background: #E8DAF7;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .back-button {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }

    .back-button:hover {
        background: rgba(255,255,255,0.8);
        transform: translateX(-2px);
    }

    .back-button i {
        color: #4B3F72;
        font-size: 20px;
    }

    .header-text h1 {
        font-size: 24px;
        font-weight: 700;
        color: #4B3F72;
        margin: 0 0 4px 0;
    }

    .header-text p {
        font-size: 14px;
        font-weight: 400;
        color: #757575;
        margin: 0;
    }

    .header-illustration {
        flex-shrink: 0;
    }

    .header-illustration img {
        width: 160px;
        height: 160px;
        object-fit: contain;
    }

    /* Date Card */
    .date-card-wrapper {
        margin-bottom: 30px;
    }

    .date-card {
        background: white;
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        max-width: fit-content;
    }

    .date-box {
        border: 2px solid #F5A623;
        border-radius: 8px;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        color: #333;
    }

    .date-info h3 {
        font-size: 18px;
        font-weight: 500;
        color: #424242;
        margin: 0 0 4px 0;
    }

    .date-info p {
        font-size: 14px;
        font-weight: 400;
        color: #9E9E9E;
        margin: 0;
    }

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 284px;
        gap: 30px;
        align-items: start;
    }

    /* Agenda Section */
    .agenda-section h2 {
        font-size: 20px;
        font-weight: 700;
        color: #7A2CF9;
        margin: 0 0 20px 0;
    }

    .agenda-card {
        width: 100%;
        max-width: 739px;
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    /* Profile Section */
    .profile-section {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .profile-photo {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #E8DAF7;
    }

    .profile-info h3 {
        font-size: 18px;
        font-weight: 600;
        color: #212121;
        margin: 0 0 4px 0;
    }

    .profile-info p {
        font-size: 14px;
        font-weight: 400;
        color: #9E9E9E;
        margin: 0 0 8px 0;
    }

    .progress-bar {
        width: 200px;
        height: 6px;
        background: #E8DAF7;
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #7A2CF9 0%, #B794F6 100%);
        width: 50%;
        border-radius: 3px;
    }

    /* Profile Divider */
    .profile-divider {
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #7A2CF9 0%, #E8DAF7 100%);
        margin: 20px 0;
        border-radius: 2px;
    }

    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 30px;
        right: 30px;
        background: #FFE8CC;
        color: #F57C00;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge i {
        font-size: 16px;
    }

    /* Counseling Info */
    .counseling-info {
        margin-top: 24px;
    }

    .info-row {
        margin-bottom: 16px;
    }

    .info-label {
        font-size: 12px;
        font-weight: 400;
        color: #9E9E9E;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 600;
        color: #212121;
    }

    .story-text {
        font-size: 14px;
        color: #424242;
        line-height: 1.6;
    }

    .link-detail {
        color: #7A2CF9;
        font-weight: 500;
        cursor: pointer;
        margin-left: 4px;
    }

    /* Method and Type Badges */
    .badge-datetime-group {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 20px 0;
    }

    .badge-wrapper {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .badge-label {
        font-size: 12px;
        font-weight: 400;
        color: #9E9E9E;
    }

    .badge-outline {
        padding: 10px 16px;
        border: 1.5px solid #5E35B1;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #5E35B1;
        background: white;
        transition: all 0.3s;
    }

    .badge-outline i {
        color: #5E35B1;
        font-size: 14px;
    }

    .datetime-card-small {
        background: #F3E5F5;
        border: 1.5px solid #9C27B0;
        padding: 10px 16px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        width: 100%;
        justify-content: center;
    }

    .datetime-card-small:hover {
        background: #E1BEE7;
        box-shadow: 0 2px 8px rgba(156, 39, 176, 0.2);
    }

    .datetime-card-small i {
        color: #9C27B0;
        font-size: 16px;
    }

    .datetime-text-small {
        font-size: 13px;
        font-weight: 500;
        color: #9C27B0;
        white-space: nowrap;
    }

    /* Cancel Button */
    .btn-cancel {
        background: #D32F2F;
        color: white;
        padding: 12px 32px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        float: right;
        margin-top: 20px;
        transition: background 0.3s;
    }

    .btn-cancel:hover {
        background: #B71C1C;
    }

    /* Calendar Section */
    .calendar-wrapper {
        width: 284px;
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        position: sticky;
        top: 30px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-month {
        font-size: 16px;
        font-weight: 500;
        color: #424242;
    }

    .calendar-nav {
        display: flex;
        gap: 8px;
    }

    .nav-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #E0E0E0;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #757575;
        transition: all 0.3s;
    }

    .nav-btn:hover {
        background: #F5F5F5;
        border-color: #7A2CF9;
        color: #7A2CF9;
    }

    /* Calendar Grid */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
        margin-bottom: 20px;
    }

    .calendar-day-header {
        text-align: center;
        font-size: 12px;
        font-weight: 500;
        color: #9E9E9E;
        padding: 8px 0;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 400;
        color: #424242;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .calendar-day:hover {
        background: #F5F5F5;
    }

    .calendar-day.active {
        background: #7A2CF9;
        color: white;
        font-weight: 600;
    }

    .calendar-day.selected {
        border: 2px solid #F5A623;
        color: #424242;
        font-weight: 600;
    }

    .calendar-day.inactive {
        color: #BDBDBD;
    }

    /* Calendar Actions */
    .calendar-actions {
        display: flex;
        gap: 12px;
    }

    .btn-calendar {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel-cal {
        background: #EEEEEE;
        color: #424242;
    }

    .btn-cancel-cal:hover {
        background: #E0E0E0;
    }

    .btn-done {
        background: #7A2CF9;
        color: white;
    }

    .btn-done:hover {
        background: #6A1FE0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .calendar-wrapper {
            position: relative;
            top: 0;
            max-width: 400px;
            margin: 0 auto;
        }

        .header-banner {
            height: auto;
            padding: 30px;
        }

        .header-illustration {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .agenda-card {
            padding: 20px;
        }

        .status-badge {
            position: relative;
            top: 0;
            right: 0;
            margin-bottom: 16px;
            display: inline-block;
        }
    }
</style>
@endpush

@section('content')
<div class="schedule-container">
    
    <!-- Header Banner -->
    <div class="header-banner">
        <div class="header-left">
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="header-text">
                <h1>Jadwal Konseling</h1>
                <p>Cek jadwal konseling di halaman ini.</p>
            </div>
        </div>
        <div class="header-illustration">
            <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Chat Illustration">
        </div>
    </div>

    <!-- Selected Date Card -->
    <div class="date-card-wrapper">
        <div class="date-card">
            <div class="date-box">{{ $currentDay }}</div>
            <div class="date-info">
                <h3>{{ $currentDayName }}</h3>
                <p>{{ $todayScheduleCount }} Jadwal Konseling</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        
        <!-- Agenda Section -->
        <div class="agenda-section">
            <h2>Agenda Konseling</h2>
            
            @if($konselings->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mb-6">
                        <i class="far fa-calendar-times text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Jadwal Konseling</h3>
                    <p class="text-gray-500 mb-6">Anda belum mengajukan jadwal konseling.</p>
                    <a href="{{ route('student.counseling.create') }}" 
                       class="inline-block bg-[#7000CC] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#5A00A8] transition-all">
                        <i class="fas fa-plus mr-2"></i> Ajukan Konseling
                    </a>
                </div>
            @else
                @foreach($konselings as $konseling)
                <div class="agenda-card" style="position: relative; margin-bottom: 20px;">
                
                <!-- Status Badge -->
                <span class="status-badge">
                    <i class="far fa-clock"></i> 
                    @if($konseling->status == 'menunggu_persetujuan') Menunggu
                    @elseif($konseling->status == 'dikonfirmasi') Dikonfirmasi
                    @elseif($konseling->status == 'selesai') Selesai
                    @elseif($konseling->status == 'ditolak') Ditolak
                    @else {{ ucfirst($konseling->status) }}
                    @endif
                </span>
                
                <!-- Profile Section -->
                <div class="profile-section">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($konseling->nama_siswa ?? Auth::user()->nama) }}&background=7A2CF9&color=fff&size=128" 
                         alt="{{ $konseling->nama_siswa ?? Auth::user()->nama }}" 
                         class="profile-photo">
                    <div class="profile-info">
                        <h3>{{ $konseling->nama_siswa ?? Auth::user()->nama }}</h3>
                        <p>{{ $konseling->kelas }}{{ $konseling->jurusan ? ' - ' . $konseling->jurusan->kode_jurusan : '' }}</p>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Divider -->
                <div class="profile-divider"></div>

                <!-- Counseling Info -->
                <div class="counseling-info">
                    
                    <!-- Guru BK -->
                    <div class="info-row">
                        <div class="info-label">Guru BK</div>
                        <div class="info-value">{{ $konseling->guruBK->nama ?? 'Belum ditentukan' }}</div>
                    </div>

                    <!-- Story -->
                    @if($konseling->deskripsi)
                    <div class="info-row">
                        <div class="info-label">Cerita Singkat Permasalahan</div>
                        <div class="story-text">
                            {{ Str::limit($konseling->deskripsi, 100) }}
                            @if(strlen($konseling->deskripsi) > 100)
                                <span class="link-detail" onclick="alert('{{ addslashes($konseling->deskripsi) }}')">Lihat Detail</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Method/Type Badges + Date/Time (4 Columns with Labels) -->
                    <div class="badge-datetime-group">
                        <!-- Metode Konseling -->
                        <div class="badge-wrapper">
                            <div class="badge-label">Metode Konseling</div>
                            <span class="badge-outline">
                                <i class="fas fa-{{ $konseling->metode_konseling == 'offline' ? 'user-friends' : 'video' }}"></i> 
                                Konseling {{ ucfirst($konseling->metode_konseling) }}
                            </span>
                        </div>
                        
                        <!-- Jenis Konseling -->
                        <div class="badge-wrapper">
                            <div class="badge-label">Jenis Konseling</div>
                            <span class="badge-outline">
                                <i class="fas fa-user"></i> {{ $konseling->jenis_konseling ?? 'Konseling Umum' }}
                            </span>
                        </div>
                        
                        <!-- Tanggal -->
                        <div class="badge-wrapper">
                            <div class="badge-label">Tanggal</div>
                            <div class="datetime-card-small">
                                <i class="far fa-calendar"></i>
                                <span class="datetime-text-small">{{ $konseling->tanggal_konseling ? \Carbon\Carbon::parse($konseling->tanggal_konseling)->isoFormat('dddd, D - MMMM - Y') : 'Belum ditentukan' }}</span>
                            </div>
                        </div>
                        
                        <!-- Jam -->
                        <div class="badge-wrapper">
                            <div class="badge-label">Jam</div>
                            <div class="datetime-card-small">
                                <i class="far fa-clock"></i>
                                <span class="datetime-text-small">{{ $konseling->waktu_konseling ? \Carbon\Carbon::parse($konseling->waktu_konseling)->format('H.i') : 'Belum ditentukan' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Button -->
                    <button class="btn-cancel" onclick="confirmCancel({{ $konseling->id }})">
                        Batalkan Jadwal
                    </button>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Calendar Section -->
        <div class="calendar-wrapper">
            <div class="calendar-header">
                <span class="calendar-month">{{ $currentMonth }}</span>
                <div class="calendar-nav">
                    <button class="nav-btn" onclick="prevMonth()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="nav-btn" onclick="nextMonth()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <!-- Day Headers -->
                <div class="calendar-day-header">Min</div>
                <div class="calendar-day-header">Sen</div>
                <div class="calendar-day-header">Sel</div>
                <div class="calendar-day-header">Rab</div>
                <div class="calendar-day-header">Kam</div>
                <div class="calendar-day-header">Jum</div>
                <div class="calendar-day-header">Sab</div>

                <!-- Days -->
                <div class="calendar-day inactive">27</div>
                <div class="calendar-day inactive">28</div>
                <div class="calendar-day inactive">29</div>
                <div class="calendar-day inactive">30</div>
                <div class="calendar-day inactive">31</div>
                <div class="calendar-day">1</div>
                <div class="calendar-day">2</div>
                
                <div class="calendar-day">3</div>
                <div class="calendar-day">4</div>
                <div class="calendar-day">5</div>
                <div class="calendar-day">6</div>
                <div class="calendar-day">7</div>
                <div class="calendar-day active">8</div>
                <div class="calendar-day">9</div>
                
                <div class="calendar-day selected">10</div>
                <div class="calendar-day">11</div>
                <div class="calendar-day">12</div>
                <div class="calendar-day">13</div>
                <div class="calendar-day">14</div>
                <div class="calendar-day">15</div>
                <div class="calendar-day">16</div>
                
                <div class="calendar-day">17</div>
                <div class="calendar-day">18</div>
                <div class="calendar-day">19</div>
                <div class="calendar-day">20</div>
                <div class="calendar-day">21</div>
                <div class="calendar-day">22</div>
                <div class="calendar-day">23</div>
                
                <div class="calendar-day">24</div>
                <div class="calendar-day">25</div>
                <div class="calendar-day">26</div>
                <div class="calendar-day">27</div>
                <div class="calendar-day">28</div>
                <div class="calendar-day">29</div>
                <div class="calendar-day">30</div>
            </div>

            <!-- Calendar Actions -->
            <div class="calendar-actions">
                <button class="btn-calendar btn-cancel-cal">Cancel</button>
                <button class="btn-calendar btn-done">Done</button>
            </div>
        </div>

    </div>

</div>

<script>
    function confirmCancel() {
        if (confirm('Apakah Anda yakin ingin membatalkan jadwal konseling ini?')) {
            // TODO: Implement cancel logic
            alert('Jadwal konseling berhasil dibatalkan');
            window.location.reload();
        }
    }

    function prevMonth() {
        alert('Navigate to previous month');
        // TODO: Implement month navigation
    }

    function nextMonth() {
        alert('Navigate to next month');
        // TODO: Implement month navigation
    }

    // Calendar day click handler
    document.querySelectorAll('.calendar-day:not(.inactive)').forEach(day => {
        day.addEventListener('click', function() {
            // Remove selected class from all days
            document.querySelectorAll('.calendar-day').forEach(d => {
                d.classList.remove('selected');
            });
            
            // Add selected class to clicked day
            if (!this.classList.contains('active')) {
                this.classList.add('selected');
            }
            
            // TODO: Load schedule for selected date
            console.log('Selected date:', this.textContent);
        });
    });
</script>
@endsection
