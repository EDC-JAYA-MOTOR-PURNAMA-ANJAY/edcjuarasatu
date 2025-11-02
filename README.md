# 🎓 Sistem Bimbingan Konseling (Educounsel)

Sistem Informasi Bimbingan Konseling berbasis web untuk SMK Antartika 1 Sidoarjo yang dibangun dengan Laravel 12 dan modern web technologies.

![Laravel](https://img.shields.io/badge/Laravel-12-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?logo=php)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Tentang Project

Sistem Bimbingan Konseling (Educounsel) adalah aplikasi web modern untuk mengelola kegiatan bimbingan konseling di sekolah. Aplikasi ini menyediakan platform digital yang memudahkan siswa, guru BK, dan admin dalam mengelola konseling, absensi, dan berbagai layanan BK lainnya.

### ✨ Fitur Utama

- **🔐 Multi-Role Authentication**
  - Admin Dashboard
  - Guru BK Dashboard
  - Student Dashboard
  - Role-based access control dengan middleware

- **📊 Manajemen Pengguna**
  - CRUD user (Admin, Guru BK, Siswa)
  - Manajemen kelas dan jurusan
  - Tahun ajaran dinamis

- **📅 Sistem Absensi**
  - Absensi siswa real-time
  - Rekap absensi per kelas
  - Export data absensi
  - Statistik kehadiran

- **💬 Konseling**
  - Jadwal konseling individu & kelompok
  - Riwayat konseling
  - Feedback konseling
  - Kategori masalah

- **🔊 Voice Notifications (TTS)**
  - Welcome message dengan suara female Indonesia
  - Notifikasi sukses absensi
  - Error messages dengan voice
  - Rate limiting countdown
  - Energetic & motivating voice (rate 0.88, pitch 1.15)

- **🎨 Modern UI/UX**
  - Responsive design
  - Dark/Light theme support
  - Smooth animations
  - Interactive dashboards

- **🔒 Security Features**
  - Login rate limiting (5 attempts, 30 seconds block)
  - Secure password hashing
  - CSRF protection
  - XSS protection
  - Session management

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Breeze (customized)
- **Voice:** Web Speech API (client-side TTS)
- **Build Tools:** Vite

---

## 📦 Instalasi

### Requirements

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

### Step-by-Step Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/sistem_bk.git
   cd sistem_bk
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_bk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start Server**
   ```bash
   php artisan serve
   ```

8. **Access Application**
   
   Open browser: `http://localhost:8000`

---

## 👤 Default Users

Setelah seeding, Anda dapat login dengan:

### Admin
- Email: `admin@educounsel.com`
- Password: `admin123`

### Guru BK
- Email: `gurubk@educounsel.com`
- Password: `gurubk123`

### Siswa
- Email: `fikri.maulana@educounsel.com`
- Password: `siswa123`
- Email: `putri.amelia@educounsel.com`
- Password: `siswa123`

(Lihat `database/seeders/UserSeeder.php` untuk user lainnya)

---

## 🗂️ Struktur Project

```
sistem_bk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication
│   │   │   ├── GuruBK/         # Guru BK controllers
│   │   │   └── Student/        # Student controllers
│   │   └── Middleware/         # Custom middleware
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Data seeders
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   ├── auth/               # Auth views
│   │   ├── student/            # Student views
│   │   └── layouts/            # Layout templates
│   ├── css/                    # Styles
│   └── js/                     # JavaScript
├── routes/
│   ├── web.php                 # Main routes
│   └── auth.php                # Auth routes
└── public/                     # Public assets
```

---

## 🚀 Key Features Details

### Voice Notification System

Sistem TTS (Text-to-Speech) client-side yang:
- **100% gratis** (menggunakan Web Speech API browser)
- **Female voice** Indonesia (prioritas: Microsoft Gadis, Damayanti, Google TTS)
- **Energetic & motivating** (pitch 1.15, rate 0.88)
- **Zero server load** (processing di browser user)
- **Privacy-safe** (tidak ada data dikirim ke server eksternal)

Fitur voice:
- Welcome message setelah login
- Error notifications (email salah, password salah)
- Throttle warning dengan countdown
- Attendance success message
- Unblock notification

### Security Features

- **Rate Limiting:** 5 percobaan login gagal = blokir 30 detik
- **Session Security:** Regenerate token setelah login/logout
- **Password Hashing:** Bcrypt encryption
- **Middleware Protection:** Role-based access control
- **CSRF Protection:** Laravel default protection
- **Activity Logging:** Log semua login attempts

---

## 📖 Dokumentasi Tambahan

Project ini memiliki dokumentasi lengkap di folder root:

- `QUICK_START.md` - Panduan cepat memulai
- `DATABASE_STRUCTURE.md` - Struktur database
- `VOICE_ENERGETIC_UPDATE.md` - Detail sistem voice
- `SECURITY.md` - Fitur keamanan
- `LOGIN_SYSTEM_GUIDE.md` - Panduan sistem login

---

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Developer

Developed with ❤️ for SMK Antartika 1 Sidoarjo

---

## 📞 Contact & Support

- **Issues:** [GitHub Issues](https://github.com/YOUR_USERNAME/sistem_bk/issues)
- **Email:** support@educounsel.com

---

## 🎯 Roadmap

- [ ] Export laporan ke PDF
- [ ] Notifikasi real-time dengan WebSocket
- [ ] Mobile app (Flutter/React Native)
- [ ] API documentation (Swagger)
- [ ] Unit & Feature tests
- [ ] CI/CD pipeline

---

**Built with Laravel 12 🚀**
