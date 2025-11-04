# 🔧 SOLUSI SERVER ERROR - EDUCOUNSEL

## ❌ MASALAH YANG DITEMUKAN

**Error:** 500 Internal Server Error saat akses `http://localhost:8000`

**Root Cause:** Table `sessions` tidak ada di database, padahal konfigurasi session menggunakan database driver.

---

## ✅ SOLUSI YANG DITERAPKAN

### 1. **Update Environment ke Development Mode**
```bash
APP_ENV=local
APP_DEBUG=true
```

### 2. **Clear All Cache**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. **Create Sessions Table** ✅
```sql
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🚀 CARA MENJALANKAN APLIKASI

### **Step 1: Start MySQL**
Pastikan XAMPP MySQL sudah running

### **Step 2: Start Laravel Server**
```bash
php artisan serve
```

### **Step 3: Build Frontend Assets** (Terminal Baru)
```bash
npm run dev
```

### **Step 4: Akses Aplikasi**
Buka browser: **http://localhost:8000**

---

## 🔑 LOGIN CREDENTIALS

### Admin
- **Email:** admin@educounsel.com
- **Password:** admin123

### Guru BK
- **Email:** guru@educounsel.com
- **Password:** guru123

### Siswa
- **Email:** siswa@educounsel.com
- **Password:** siswa123

---

## ✅ VERIFIKASI

Setelah menjalankan server, Anda harus bisa:
- ✅ Akses homepage: `http://localhost:8000`
- ✅ Akses login: `http://localhost:8000/login`
- ✅ Login dengan kredensial di atas
- ✅ Redirect ke dashboard sesuai role

---

## 📋 TROUBLESHOOTING

### Jika masih error:

**1. Clear cache lagi:**
```bash
php artisan optimize:clear
```

**2. Check database connection:**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

**3. Check sessions table:**
```bash
php artisan tinker
>>> DB::table('sessions')->count();
```

**4. Recreate sessions table jika perlu:**
```bash
php artisan session:table
php artisan migrate
```

---

## 🎯 STATUS AKHIR

✅ Database: Connected
✅ Sessions Table: Created
✅ Cache: Cleared
✅ Config: Development Mode
✅ Server: Ready to Run

**SISTEM SIAP DIGUNAKAN!** 🎉
