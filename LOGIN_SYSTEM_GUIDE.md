# 🔐 Panduan Sistem Login Multi-Role - EduCounsel

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Struktur File](#struktur-file)
3. [Cara Menggunakan](#cara-menggunakan)
4. [Login Credentials](#login-credentials)
5. [Flow Diagram](#flow-diagram)
6. [Troubleshooting](#troubleshooting)

---

## Overview

Sistem login multi-role dengan fitur:
- ✅ **3 Role berbeda**: Admin, Guru BK, Siswa
- ✅ **Auto-redirect** berdasarkan role setelah login
- ✅ **Middleware protection** untuk setiap route
- ✅ **Status validation** - hanya user aktif yang bisa login
- ✅ **Session management** dengan remember me
- ✅ **Beautiful UI** dengan Tailwind CSS

---

## Struktur File

### 1. Controller
```
app/Http/Controllers/Auth/
└── LoginController.php          ✅ Handle login, logout, redirect
```

**Fitur LoginController:**
- `showLoginForm()` - Menampilkan halaman login
- `login()` - Proses authentication
- `redirectBasedOnRole()` - Auto-redirect berdasarkan peran
- `logout()` - Logout dan clear session

### 2. Middleware
```
app/Http/Middleware/
└── CheckRole.php                ✅ Validasi akses berdasarkan role
```

**Fitur CheckRole Middleware:**
- Cek apakah user sudah login
- Validasi role user sesuai dengan yang dibutuhkan
- Block unauthorized access dengan 403 error

### 3. Views

#### Login View
```
resources/views/auth/
└── login.blade.php              ✅ Halaman login dengan UI modern
```

#### Dashboard Views
```
resources/views/
├── admin/
│   └── dashboard/
│       └── index.blade.php      ✅ Dashboard Admin (sudah ada)
├── guru_bk/
│   └── dashboard/
│       └── index.blade.php      ✅ Dashboard Guru BK (baru)
└── siswa/
    └── dashboard/
        └── index.blade.php      ✅ Dashboard Siswa (baru)
```

### 4. Routes
```
routes/
└── web.php                      ✅ Routes dengan middleware protection
```

**Route Structure:**
```php
// Public routes
GET  /                           → Landing page
GET  /login                      → Login form (middleware: guest)
POST /login                      → Process login (middleware: guest)
POST /logout                     → Logout (middleware: auth)

// Admin routes (middleware: auth, role:admin)
GET  /admin/dashboard            → Admin dashboard
GET  /admin/tambah-akun          → Tambah akun
GET  /admin/daftar-pengguna      → Daftar pengguna
... (dan route admin lainnya)

// Guru BK routes (middleware: auth, role:guru_bk)
GET  /guru_bk/dashboard          → Guru BK dashboard
GET  /guru_bk/konseling          → Kelola konseling
GET  /guru_bk/konseling/jadwal   → Jadwal konseling
... (dan route guru_bk lainnya)

// Student routes (middleware: auth, role:siswa)
GET  /student/dashboard          → Student dashboard
GET  /student/counseling/create  → Ajukan konseling
GET  /student/counseling         → Riwayat konseling
GET  /student/attendance         → Absensi
GET  /student/profile            → Profile
... (dan route student lainnya)
```

### 5. Configuration
```
bootstrap/
└── app.php                      ✅ Register middleware alias
```

---

## Cara Menggunakan

### 1️⃣ Jalankan Aplikasi

Pastikan server sudah running:
```bash
php artisan serve
```

### 2️⃣ Akses Halaman Login

Buka browser dan akses:
```
http://localhost:8000/login
```

### 3️⃣ Login dengan Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@educounsel.com | admin123 |
| **Guru BK** | guru@educounsel.com | guru123 |
| **Siswa** | siswa@educounsel.com | siswa123 |

### 4️⃣ Auto-Redirect

Setelah login berhasil, sistem otomatis redirect ke:

**Admin:**
```
http://localhost:8000/admin/dashboard
```

**Guru BK:**
```
http://localhost:8000/guru_bk/dashboard
```

**Siswa:**
```
http://localhost:8000/student/dashboard
```

---

## Login Credentials

### 👨‍💼 Admin (2 Akun)
```
Email: admin@educounsel.com
Password: admin123
NIS/NIP: ADM001
Nama: Budi Santoso

Email: sari.indah@educounsel.com
Password: admin123
NIS/NIP: ADM002
Nama: Sari Indah
```

### 👨‍🏫 Guru BK (5 Akun)
```
Email: guru@educounsel.com
Password: guru123
NIS/NIP: GBK001
Nama: Dr. Ahmad Wijaya, M.Pd

Email: diana.puspita@educounsel.com
Password: guru123
NIS/NIP: GBK002
Nama: Diana Puspita, S.Pd

Email: rizki.maulana@educounsel.com
Password: guru123
NIS/NIP: GBK003
Nama: Rizki Maulana, M.Psi

Email: lina.marlina@educounsel.com
Password: guru123
NIS/NIP: GBK004
Nama: Lina Marlina, S.Pd

Email: faisal.rahman@educounsel.com
Password: guru123
NIS/NIP: GBK005
Nama: Faisal Rahman, S.Psi
```

### 👨‍🎓 Siswa (5 Akun)
```
Email: siswa@educounsel.com
Password: siswa123
NIS/NIP: SIS001
Nama: Andi Pratama
Kelas: X RPL 1

Email: rina.sari@educounsel.com
Password: siswa123
NIS/NIP: SIS002
Nama: Rina Sari
Kelas: X RPL 1

Email: dodi.kurniawan@educounsel.com
Password: siswa123
NIS/NIP: SIS003
Nama: Dodi Kurniawan
Kelas: X RPL 1

Email: putri.amelia@educounsel.com
Password: siswa123
NIS/NIP: SIS004
Nama: Putri Amelia
Kelas: X RPL 2

Email: budi.setiawan@educounsel.com
Password: siswa123
NIS/NIP: SIS005
Nama: Budi Setiawan
Kelas: X TKJ 1
```

---

## Flow Diagram

### Authentication Flow

```
┌─────────────────┐
│  Akses /login   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Input Email &   │
│    Password     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Validasi Form  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Auth::attempt() │
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
   ✓│        ✗│
    │         │
    ▼         ▼
┌────────┐  ┌──────────┐
│Success │  │  Failed  │
└───┬────┘  └────┬─────┘
    │            │
    ▼            ▼
┌────────┐  ┌──────────────┐
│Check   │  │ Show Error   │
│Status  │  │ "Email atau  │
└───┬────┘  │  password    │
    │       │  salah"      │
┌───┴───┐   └──────────────┘
│       │
✓│      ✗│
│       │
│       ▼
│   ┌──────────────┐
│   │ Show Error   │
│   │ "Akun tidak  │
│   │  aktif"      │
│   └──────────────┘
│
▼
┌─────────────────┐
│Check User Peran │
└────────┬────────┘
         │
    ┌────┼────┬────────┐
    │    │    │        │
    ▼    ▼    ▼        ▼
┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐
│Admin │ │Guru  │ │Siswa │ │Error │
│      │ │BK    │ │      │ │403   │
└───┬──┘ └───┬──┘ └───┬──┘ └──────┘
    │        │        │
    ▼        ▼        ▼
/admin    /guru_bk  /siswa
/dashboard /dashboard /dashboard
```

### Route Protection Flow

```
User Request
     │
     ▼
┌──────────────┐
│ Middleware:  │
│   'auth'     │
└──────┬───────┘
       │
  ┌────┴────┐
  │         │
 ✓│        ✗│
  │         │
  │         ▼
  │   ┌──────────────┐
  │   │ Redirect to  │
  │   │   /login     │
  │   └──────────────┘
  │
  ▼
┌──────────────┐
│ Middleware:  │
│   'role:X'   │
└──────┬───────┘
       │
  ┌────┴────┐
  │         │
 ✓│        ✗│
  │         │
  │         ▼
  │   ┌──────────────┐
  │   │ Error 403    │
  │   │ Unauthorized │
  │   └──────────────┘
  │
  ▼
┌──────────────┐
│ Allow Access │
└──────────────┘
```

---

## Troubleshooting

### 1. Error: "Method showLoginForm does not exist"

**Penyebab:** Route menggunakan controller yang salah

**Solusi:**
```php
// ❌ SALAH
use App\Http\Controllers\Auth\AuthController;

// ✅ BENAR
use App\Http\Controllers\Auth\LoginController;
```

---

### 2. Error: "Middleware role not found"

**Penyebab:** Middleware belum terdaftar di `bootstrap/app.php`

**Solusi:**
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

---

### 3. Error: "Field 'name' doesn't have a default value"

**Penyebab:** Migration users table masih menggunakan field lama

**Solusi:**
```bash
php artisan migrate:fresh --seed
```

---

### 4. Login berhasil tapi tidak redirect

**Penyebab:** Route name tidak sesuai

**Cek:**
- `admin.dashboard` route exists?
- `guru_bk.dashboard` route exists?
- `student.dashboard` route exists?

**Solusi:**
```bash
php artisan route:list
```

---

### 5. Error 403 "Unauthorized action"

**Penyebab:** User mencoba akses route yang tidak sesuai role-nya

**Ini adalah behavior yang benar!** User tidak boleh akses route role lain.

Contoh:
- Siswa tidak boleh akses `/admin/dashboard`
- Admin tidak boleh akses `/student/dashboard`

---

### 6. Session expired terus

**Penyebab:** Session driver atau configuration

**Solusi:**
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Generate key baru
php artisan key:generate
```

---

## Testing Login

### Test Case 1: Login sebagai Admin
```
1. Buka http://localhost:8000/login
2. Input email: admin@educounsel.com
3. Input password: admin123
4. Click "Log in"
5. ✅ Expected: Redirect ke /admin/dashboard
```

### Test Case 2: Login sebagai Guru BK
```
1. Buka http://localhost:8000/login
2. Input email: guru@educounsel.com
3. Input password: guru123
4. Click "Log in"
5. ✅ Expected: Redirect ke /guru_bk/dashboard
```

### Test Case 3: Login sebagai Siswa
```
1. Buka http://localhost:8000/login
2. Input email: siswa@educounsel.com
3. Input password: siswa123
4. Click "Log in"
5. ✅ Expected: Redirect ke /student/dashboard
```

### Test Case 4: Wrong Password
```
1. Buka http://localhost:8000/login
2. Input email: admin@educounsel.com
3. Input password: wrongpassword
4. Click "Log in"
5. ✅ Expected: Error "Email atau password yang Anda masukkan salah."
```

### Test Case 5: Access Protected Route Without Login
```
1. Logout dulu (jika sudah login)
2. Akses http://localhost:8000/admin/dashboard
3. ✅ Expected: Redirect ke /login
```

### Test Case 6: Access Wrong Role Route
```
1. Login sebagai siswa
2. Coba akses http://localhost:8000/admin/dashboard
3. ✅ Expected: Error 403 Unauthorized
```

---

## Features Summary

### ✅ Implemented
- [x] Multi-role authentication (Admin, Guru BK, Siswa)
- [x] Auto-redirect berdasarkan role
- [x] Middleware protection untuk routes
- [x] Status validation (hanya user aktif)
- [x] Beautiful login UI dengan Tailwind CSS
- [x] Password hashing otomatis
- [x] Remember me functionality
- [x] Session management
- [x] Logout functionality
- [x] 403 error handling
- [x] Guest middleware untuk login page
- [x] Dashboard untuk setiap role

### 🔄 Ready to Implement
- [ ] Forgot password functionality
- [ ] Two-factor authentication (2FA)
- [ ] Login with Google OAuth
- [ ] Login attempt limiter
- [ ] User activity logging
- [ ] Email verification
- [ ] Profile management

---

## Security Best Practices

1. ✅ **Password Hashing** - Menggunakan `Hash::make()`
2. ✅ **CSRF Protection** - Token di semua form
3. ✅ **Session Regeneration** - Setiap login baru
4. ✅ **Middleware Protection** - Semua protected routes
5. ✅ **Guest Middleware** - Login page hanya untuk guest
6. ✅ **Status Validation** - Cek user aktif saat login

---

## Next Steps

1. **Implementasi CRUD Features** untuk setiap role
2. **Tambahkan Profile Management** 
3. **Buat Forgot Password System**
4. **Add Activity Logging**
5. **Implement Email Notifications**
6. **Add User Preferences**

---

## Support

Jika ada masalah atau pertanyaan:
1. Cek dokumentasi ini terlebih dahulu
2. Lihat `DATABASE_STRUCTURE.md` untuk struktur database
3. Run `php artisan route:list` untuk cek semua routes
4. Run `php artisan config:clear` jika ada masalah konfigurasi

---

**Generated:** 2025-01-01  
**Version:** 1.0.0  
**Status:** ✅ Production Ready
