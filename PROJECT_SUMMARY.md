# 📚 PROJECT SUMMARY - Sistem BK Educounsel

**Updated:** 2025-11-02  
**Framework:** Laravel 12 + Tailwind CSS + Alpine.js  
**Database:** MySQL  

---

## 🎯 PROJECT OVERVIEW

Sistem Informasi Bimbingan Konseling untuk SMK Antartika 1 Sidoarjo dengan fitur:
- Multi-role authentication (Admin, Guru BK, Siswa)
- Manajemen absensi siswa real-time
- Sistem konseling & jadwal
- Voice notifications (TTS female Indonesia)
- Dashboard interaktif untuk setiap role

---

## 📂 FOLDER STRUCTURE

```
sistem_bk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           (8 controllers)
│   │   │   ├── Auth/            (11 controllers)
│   │   │   ├── GuruBK/          (8 controllers)
│   │   │   └── Student/         (13 controllers)
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php
│   │   │   ├── RoleMiddleware.php
│   │   │   └── SecurityHeaders.php
│   │   └── Requests/
│   ├── Models/                  (16 models)
│   └── View/
├── config/                      (10 config files)
├── database/
│   ├── migrations/              (21 migrations)
│   ├── seeders/                 (8 seeders)
│   └── factories/
├── public/
│   ├── images/
│   └── index.php
├── resources/
│   ├── views/
│   │   ├── admin/               (8 views)
│   │   ├── auth/                (6 views)
│   │   ├── student/             (3 folders)
│   │   ├── layouts/             (8 layouts)
│   │   └── components/          (21 components)
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                  (Main routes)
│   ├── siswa.php
│   └── auth.php
└── storage/
```

---

## 🎯 KEY CONTROLLERS

### Admin Controllers (app/Http/Controllers/Admin/)
- `AbsensiController.php` - Rekap & export absensi
- `PenggunaController.php` - CRUD users
- `DashboardController.php` - Admin dashboard
- `TahunAjaranController.php` - Manage tahun ajaran
- `JurusanController.php`, `KelasController.php`, `MonitoringController.php`

### Auth Controllers (app/Http/Controllers/Auth/)
- `LoginController.php` - Custom login dengan rate limiting
- `RegisteredUserController.php` - User registration
- Plus 9 default Laravel auth controllers

### Student Controllers (app/Http/Controllers/Student/)
- `AttendanceController.php` - Absensi siswa
- `DashboardController.php` - Student dashboard
- `KonselingController.php` - Ajukan konseling
- `AbsensiController.php`, `ProfileController.php`, dll

### GuruBK Controllers (app/Http/Controllers/GuruBK/)
- `DashboardController.php`, `KonselingController.php`
- `LaporanController.php`, `MateriController.php`
- `SiswaController.php`, `AnalisisController.php`

---

## 💾 MODELS (app/Models/)

```
User.php                    - Users (admin, guru_bk, siswa)
Absensi.php                 - Attendance records
Kelas.php                   - Classes
Jurusan.php                 - Majors
TahunAjaran.php             - Academic years
Konseling.php               - Counseling sessions
Kuesioner.php               - Questionnaires
PertanyaanKuesioner.php     - Questions
JawabanKuesioner.php        - Answers
HasilKonseling.php          - Counseling results
FeedbackKonseling.php       - Feedback
Laporan.php                 - Reports
Materi.php                  - Materials
KategoriMasalah.php         - Problem categories
JenisKuesioner.php          - Questionnaire types
HasilAnalisisKuesioner.php  - Analysis results
```

---

## 🗄️ DATABASE MIGRATIONS

### Core Tables (21 migrations)
1. `users` - User accounts (extended)
2. `absensi` - Attendance records
3. `kelas` - Classes
4. `jurusan` - Majors
5. `tahun_ajaran` - Academic years
6. `konseling` - Counseling
7. `kuesioner` - Questionnaires
8. `pertanyaan_kuesioner`, `jawaban_kuesioner`
9. `hasil_konseling`, `feedback_konseling`
10. `hasil_analisis_kuesioner`
11. `materi` - Learning materials
12. `laporan` - Reports
13. `kategori_masalah` - Problem categories
14. `jenis_kuesioner` - Questionnaire types
15. `panggilan_orang_tua` - Parent calls
16. `pelanggaran` - Violations

---

## 🌐 ROUTES

### Main Routes (routes/web.php)
```php
// Landing
GET  /                  - Landing page
GET  /features, /about, /contact

// Auth
GET  /login            - Login form
POST /login            - Login process
POST /logout           - Logout

// Admin (middleware: auth, role:admin)
GET  /admin/dashboard
GET  /admin/daftar-pengguna
GET  /admin/tambah-akun
GET  /admin/rekap-absensi
GET  /admin/detail-absensi/{id}
GET  /admin/tahun-ajaran
GET  /admin/monitoring

// Guru BK (middleware: auth, role:guru_bk)
GET  /guru_bk/dashboard
GET  /guru_bk/konseling
GET  /guru_bk/pelanggaran

// Student (middleware: auth, role:siswa)
GET  /student/dashboard
GET  /student/attendance
POST /student/attendance/store
GET  /student/counseling
GET  /student/profile
```

---

## 🎨 KEY VIEWS

### Layouts
- `app.blade.php` - Main app layout (dengan welcome voice)
- `app-admin.blade.php` - Admin layout
- `siswa.blade.php` - Student layout
- `auth.blade.php` - Auth layout
- `guest.blade.php` - Guest layout

### Auth Views
- `login.blade.php` - Login page (dengan TTS voice)
- `register.blade.php`, `forgot-password.blade.php`

### Student Views
- `student/dashboard/index.blade.php` - Student dashboard
- `student/attendance/index.blade.php` - Attendance page (TTS)
- `student/counseling/create.blade.php` - Create counseling

### Admin Views
- `admin/dashboard/index.blade.php` - Admin dashboard
- `admin/management-pengguna/` - User management
- `admin/rekap-absensi/` - Attendance recap

---

## 🔊 VOICE SYSTEM (TTS)

### Implementation Files
- `resources/views/auth/login.blade.php` - Login errors voice
- `resources/views/layouts/app.blade.php` - Welcome voice
- `resources/views/student/attendance/index.blade.php` - Attendance voice

### Voice Parameters
```javascript
rate: 0.88      // Energetic speed
pitch: 1.15     // Cheerful female tone
volume: 1.0     // Maximum volume
lang: 'id-ID'   // Indonesian
```

### Voice Features
- Female Indonesian voice (Microsoft Gadis/Damayanti)
- Welcome message after login
- Error notifications (wrong email/password)
- Throttle countdown
- Attendance success message

---

## 🔐 SECURITY FEATURES

- **Rate Limiting:** 5 failed login attempts → 30 seconds block
- **Middleware:** `CheckRole`, `RoleMiddleware`
- **CSRF Protection:** Laravel default
- **Password Hashing:** Bcrypt
- **Session Management:** Secure regeneration
- **Activity Logging:** All login attempts logged

---

## 📦 DEPENDENCIES

### Backend (composer.json)
```json
"laravel/framework": "^12.0"
"laravel/tinker": "^2.10.1"
"maatwebsite/excel": "^1.1"      // Excel export
"openai-php/laravel": "^0.17.1"  // AI integration
"twilio/sdk": "^8.8"             // SMS notifications
"barryvdh/laravel-debugbar": "^3.16"
"laravel/breeze": "^2.3"         // Auth scaffolding
```

### Frontend (package.json)
```json
"alpinejs": "^3.15.0"
"tailwindcss": "^3.1.0"
"vite": "^7.0.7"
"chart.js": "^4.5.1"             // Dashboard charts
"sweetalert2": "^11.26.3"        // Alerts
```

---

## 👤 DEFAULT USERS (Seeders)

```php
Admin:    admin@educounsel.com    / admin123
Guru BK:  gurubk@educounsel.com   / gurubk123
Siswa:    fikri.maulana@educounsel.com / siswa123
Siswa:    putri.amelia@educounsel.com  / siswa123
...plus 38 siswa lainnya
```

---

## 🚀 QUICK START

```bash
# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Build & Run
npm run build
php artisan serve
```

---

## 📄 DOCUMENTATION FILES

Project ini memiliki 30+ file dokumentasi:
- `README.md` - Main documentation
- `QUICK_START.md` - Quick start guide
- `DATABASE_STRUCTURE.md` - Database schema
- `VOICE_ENERGETIC_UPDATE.md` - Voice system
- `SECURITY.md` - Security features
- `LOGIN_SYSTEM_GUIDE.md` - Login flow
- `GITHUB_PUSH_GUIDE.md` - Git push guide
- Plus 20+ lainnya

---

## 🎯 TECH STACK SUMMARY

```
Backend:     Laravel 12 (PHP 8.2+)
Frontend:    Blade + Tailwind + Alpine.js
Database:    MySQL
Auth:        Laravel Breeze (custom)
Voice:       Web Speech API (client-side)
Charts:      Chart.js
Alerts:      SweetAlert2
Icons:       Heroicons
Build:       Vite
```

---

**Repository:** https://github.com/kapaliut22/sistem_bk  
**Local Dev:** http://localhost/sistem_bk  
**Status:** ✅ Production Ready
