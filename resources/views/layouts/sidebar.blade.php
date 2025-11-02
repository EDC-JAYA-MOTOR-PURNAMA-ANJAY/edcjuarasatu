<nav class="sidebar">
    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('images/EDClogo.svg') }}" alt="EduCounsel" class="EduCounsel">
    </div>

    <!-- General Menu Section -->
    <div class="menu-section">
        <div class="section-title">General</div>
        <ul class="nav-menu">
            <li class="nav-item active">
                <a href="{{ route('student.dashboard') }}" class="nav-link">
                    <i class="fas fa-th"></i> <!-- Ikon kisi 3x3 -->
                    <span>Dashboard</span>
                    <span class="badge">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.absensi') }}" class="nav-link">
                    <i class="fas fa-list-alt"></i> <!-- Ikon daftar/checklist -->
                    <span>Absensi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.ajukan.konseling') }}" class="nav-link">
                    <i class="fas fa-comment"></i> <!-- Ikon gelembung percakapan -->
                    <span>Ajukan Konseling</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.jadwal') }}" class="nav-link">
                    <i class="fas fa-calendar-day"></i> <!-- Ikon kalender dengan waktu -->
                    <span>Jadwal Konseling</span>
                    <span class="badge">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.riwayat') }}" class="nav-link">
                    <i class="fas fa-file-alt"></i> <!-- Ikon dokumen/arsip -->
                    <span>Riwayat Konseling</span>
                </a>
            </li>
            <li class="nav-item has-dropdown">
                <a href="#" class="nav-link">
                    <i class="fas fa-exclamation-triangle"></i> <!-- Ikon segitiga peringatan -->
                    <span>Pelanggaran</span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-clipboard-check"></i> <!-- Ikon formulir -->
                    <span>Kuesioner</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-book"></i> <!-- Ikon buku -->
                    <span>Materi</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Setting Menu Section -->
    <div class="menu-section setting-section">
        <div class="section-title">Setting</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-question-circle"></i> <!-- Ikon lingkaran dengan tanda tanya -->
                    <span>Panduan Bantuan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i> <!-- Ikon roda gigi -->
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
:root {
    --primary-blue: #2E46FF;
    --light-blue: #E5F1FF;
    --white: #FFFFFF;
    --text-primary: #222222;
    --text-gray: #8A8A8A;
    --shadow-sidebar: 0 6px 18px rgba(15, 23, 42, 0.04);
    --hover-bg: rgba(46, 70, 255, 0.06);
}

.sidebar {
    width: 300px; /* Diubah menjadi 300px */
    height: 1400px; /* Diubah menjadi 1400px */
    background: var(--white);
    border-radius: 15px;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px; /* Tetap sama */
    box-shadow: var(--shadow-sidebar);
    z-index: 1000;
    margin: 20px;
    overflow-y: auto;
    font-family: 'Poppins', sans-serif;
}

.logo {
    height: 40px;
    display: flex;
    align-items: center;
    margin-bottom: 0;
    padding: 0 8px;
}

.logo img {
    height: 35px;
    width: auto;
    max-width: 100%;
}

.menu-section {
    margin-top: 24px;
}

.section-title {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    padding: 0 8px;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    height: 40px;
    margin-bottom: 4px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
}

/* Default State */
.nav-item:not(.active):hover {
    background: var(--hover-bg);
}

.nav-item:not(.active):hover .nav-link {
    color: var(--primary-blue);
}

.nav-item:not(.active):hover .nav-link i {
    color: var(--primary-blue);
}

/* Active State */
.nav-item.active {
    background: var(--primary-blue);
}

.nav-item.active .nav-link {
    color: var(--white);
}

.nav-item.active .nav-link i {
    color: var(--white);
}

.nav-item.active .badge {
    background: var(--white);
    color: var(--primary-blue);
}

.nav-link {
    display: flex;
    align-items: center;
    height: 40px;
    padding: 0 12px;
    text-decoration: none;
    color: var(--text-primary);
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    font-size: 14px;
    font-weight: 500;
}

.nav-link i {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    font-size: 16px;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.nav-link span:not(.badge) {
    flex: 1;
    margin-left: 0;
}

.badge {
    background: var(--light-blue);
    color: var(--primary-blue);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* Dropdown Styles */
.has-dropdown .dropdown-arrow {
    margin-left: auto;
    font-size: 12px;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.nav-item:not(.active):hover .dropdown-arrow {
    color: var(--primary-blue);
}

.nav-item.active .dropdown-arrow {
    color: var(--white);
}

.has-dropdown:hover .dropdown-arrow {
    transform: rotate(180deg);
}

.setting-section {
    margin-top: 28px;
}

.setting-section .section-title {
    color: var(--text-gray);
}

/* Smooth transitions for all interactive elements */
.nav-item,
.nav-link,
.nav-link i,
.badge,
.dropdown-arrow {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Focus states for accessibility */
.nav-link:focus {
    outline: 2px solid var(--primary-blue);
    outline-offset: 2px;
}

/* Scrollbar styling */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive design - Sidebar icon-only */
@media (max-width: 1024px) {
    .sidebar {
        width: 60px;
        padding: 20px 10px;
    }

    .logo {
        justify-content: center;
        padding: 0;
    }

    .logo img {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    .section-title,
    .nav-link span:not(.badge),
    .badge,
    .dropdown-arrow {
        display: none;
    }

    .nav-link {
        justify-content: center;
        padding: 0;
    }

    .nav-link i {
        margin-right: 0;
    }

    .menu-section {
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        margin: 0;
        border-radius: 0 15px 15px 0;
        width: 300px; /* Tetap 300px di mobile */
        height: 100vh; /* Di mobile pakai full height */
        padding: 20px;
    }

    .sidebar.mobile-open {
        transform: translateX(0);
    }

    .section-title,
    .nav-link span:not(.badge),
    .badge,
    .dropdown-arrow {
        display: block;
    }

    .nav-link {
        justify-content: flex-start;
        padding: 0 12px;
    }

    .nav-link i {
        margin-right: 10px;
    }
}

/* Untuk layar yang sangat tinggi */
@media (min-height: 1400px) {
    .sidebar {
        height: 1400px; /* Fixed height untuk layar tinggi */
    }
}

/* Tambahan untuk memastikan Font Awesome tersedia */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
</style>
