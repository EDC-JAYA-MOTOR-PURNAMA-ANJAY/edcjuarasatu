# 📝 CARA MENDAFTARKAN USER BARU - SISTEM BK

## 🎯 **3 METODE PENDAFTARAN**

---

## ✅ **METHOD 1: VIA ADMIN PANEL (RECOMMENDED)**

### **Untuk: Siswa & Guru BK Baru**

### **Step-by-Step:**

```
1️⃣ Login Admin
   URL: http://localhost/login
   Email: admin@educounsel.com
   Password: admin123

2️⃣ Buka Menu
   Sidebar → "Daftar Pengguna"

3️⃣ Click Button
   "Tambah Akun Pengguna" (hijau, pojok kanan)

4️⃣ Isi Form
   ┌─────────────────────────────────────┐
   │ FORM TAMBAH AKUN PENGGUNA           │
   ├─────────────────────────────────────┤
   │ Role          : Pilih peran         │
   │                 [Siswa / Guru BK]   │
   │                                     │
   │ Nama Lengkap  : [Contoh: Budi S]    │
   │                                     │
   │ NIK/NIP       : [SIS036 / GBK006]   │
   │                 ⚠️ Harus UNIK!      │
   │                                     │
   │ Email         : [budi@example.com]  │
   │                 ⚠️ Harus UNIK!      │
   │                                     │
   │ Password      : [Admin@2024]        │
   │                 ⚠️ Min 8 char       │
   │                 ⚠️ Huruf besar      │
   │                 ⚠️ Huruf kecil      │
   │                 ⚠️ Angka            │
   │                 ⚠️ Special (@$!#&)  │
   │                                     │
   │ Jenis Kelamin : [Laki-laki/Perempuan]│
   │                                     │
   │ No Telepon    : [081234567890]      │
   │                                     │
   │ Status        : [Aktif]             │
   │                                     │
   │ Alamat        : [Jl. Contoh No.1]   │
   │                                     │
   │ Kelas         : [X RPL 1]           │
   │                 📌 Hanya untuk Siswa│
   └─────────────────────────────────────┘

5️⃣ Validasi
   - Pastikan semua field terisi
   - Pastikan password memenuhi requirement
   - Pastikan NIK/NIP & Email belum terdaftar

6️⃣ Click "Simpan"

7️⃣ Success!
   ✅ Alert: "Akun pengguna berhasil ditambahkan!"
   ✅ User muncul di Daftar Pengguna
   ✅ User bisa login segera
```

---

### **📋 PASSWORD REQUIREMENTS**

**HARUS memenuhi semua:**
```
✅ Minimal 8 karakter
✅ Minimal 1 huruf BESAR (A-Z)
✅ Minimal 1 huruf kecil (a-z)
✅ Minimal 1 angka (0-9)
✅ Minimal 1 karakter khusus (@, $, !, %, *, #, ?, &)
```

**Contoh Password VALID:**
```
✅ Admin@2024
✅ Siswa#123Bk
✅ GuruBK$2024
✅ Password!123
✅ MyPass@2024
```

**Contoh Password TIDAK VALID:**
```
❌ admin123       → Tidak ada huruf besar & special char
❌ Admin123       → Tidak ada special char
❌ Admin@         → Kurang dari 8 karakter
❌ ADMIN@123      → Tidak ada huruf kecil
❌ admin@abc      → Tidak ada angka
```

---

### **🎭 ROLE YANG BISA DITAMBAH**

**Via Admin Panel:**
```
1. ✅ Guru BK    (peran: guru_bk)
2. ✅ Siswa      (peran: siswa)
```

**⚠️ TIDAK BISA:**
```
❌ Admin baru tidak bisa ditambah via form
   (Alasan: Security - Hanya super admin yang bisa)
```

---

### **🔒 VALIDASI OTOMATIS**

**System akan cek:**
```
✅ NIK/NIP belum dipakai user lain
✅ Email belum terdaftar
✅ Password cukup kuat
✅ Format email valid
✅ Nomor telepon valid
✅ Kelas valid (untuk siswa)
```

**Jika gagal:**
```
❌ Error message muncul
❌ Field yang bermasalah ditandai merah
❌ Data tidak tersimpan
```

---

## 🛠️ **METHOD 2: VIA SEEDER (DEVELOPMENT/TESTING)**

### **Untuk: Testing & Development Only**

### **Langkah:**

```bash
1. Buka file: database/seeders/UserSeeder.php

2. Tambah user baru di method run():

   User::create([
       'nis_nip' => 'SIS036',                    // Unique ID
       'nama' => 'Nama Siswa Baru',
       'email' => 'siswa.baru@educounsel.com',  // Unique email
       'password' => Hash::make('siswa123'),     // Password
       'peran' => 'siswa',                       // siswa/guru_bk/admin
       'status' => 'aktif',                      // aktif/nonaktif
       'jenis_kelamin' => 'laki-laki',
       'alamat' => 'Jl. Contoh No. 1',
       'no_telepon' => '081234567899',
       'kelas_id' => 1                           // ID kelas (untuk siswa)
   ]);

3. Run seeder:
   php artisan db:seed --class=UserSeeder

4. Done! User baru terdaftar ✅
```

---

### **📝 TEMPLATE SEEDER**

#### **A. Untuk Siswa Baru:**
```php
User::create([
    'nis_nip' => 'SIS036',                        // Unique
    'nama' => 'Budi Santoso',
    'email' => 'budi.santoso@educounsel.com',     // Unique
    'password' => Hash::make('siswa123'),
    'peran' => 'siswa',
    'status' => 'aktif',
    'jenis_kelamin' => 'laki-laki',
    'alamat' => 'Jl. Merdeka No. 10, Jakarta',
    'no_telepon' => '081234567899',
    'kelas_id' => 1                                // 1=X RPL 1, 2=X RPL 2, dst
]);
```

#### **B. Untuk Guru BK Baru:**
```php
User::create([
    'nis_nip' => 'GBK006',                        // Unique
    'nama' => 'Dr. Siti Rahayu, M.Pd',
    'email' => 'siti.rahayu@educounsel.com',      // Unique
    'password' => Hash::make('guru123'),
    'peran' => 'guru_bk',
    'status' => 'aktif',
    'jenis_kelamin' => 'perempuan',
    'alamat' => 'Jl. Pendidikan No. 20, Jakarta',
    'no_telepon' => '081234567900',
    'kelas_id' => null                             // Guru tidak punya kelas
]);
```

#### **C. Untuk Admin Baru:**
```php
User::create([
    'nis_nip' => 'ADM003',                        // Unique
    'nama' => 'Super Admin',
    'email' => 'superadmin@educounsel.com',       // Unique
    'password' => Hash::make('admin123'),
    'peran' => 'admin',
    'status' => 'aktif',
    'jenis_kelamin' => 'laki-laki',
    'alamat' => 'Jl. Administrator No. 1, Jakarta',
    'no_telepon' => '081234567901',
    'kelas_id' => null                             // Admin tidak punya kelas
]);
```

---

### **⚠️ PENTING - SEEDER:**

```
✅ Gunakan Hash::make() untuk password
✅ Pastikan nis_nip UNIQUE
✅ Pastikan email UNIQUE
✅ kelas_id = null untuk Guru BK & Admin
✅ kelas_id = ID kelas untuk Siswa

❌ Jangan hardcode password production di seeder
❌ Jangan commit seeder dengan data sensitif
```

---

## 💾 **METHOD 3: VIA DATABASE DIRECT (NOT RECOMMENDED)**

### **⚠️ WARNING: Advanced User Only!**

### **Langkah:**

```sql
1. Buka phpMyAdmin atau MySQL client

2. Select database: sistem_bk

3. Insert ke tabel users:

INSERT INTO `users` (
    `nis_nip`, 
    `nama`, 
    `email`, 
    `password`, 
    `peran`, 
    `status`,
    `jenis_kelamin`,
    `alamat`,
    `no_telepon`,
    `kelas_id`,
    `created_at`,
    `updated_at`
) VALUES (
    'SIS036',                                  -- Unique ID
    'Nama Siswa Baru',                         -- Nama
    'siswa.baru@educounsel.com',              -- Unique email
    '$2y$12$hashed_password_here',            -- Hashed password
    'siswa',                                   -- Role
    'aktif',                                   -- Status
    'laki-laki',                               -- Gender
    'Jl. Contoh No. 1, Jakarta',              -- Address
    '081234567899',                            -- Phone
    1,                                         -- Kelas ID (NULL untuk guru/admin)
    NOW(),                                     -- Created at
    NOW()                                      -- Updated at
);

4. ⚠️ HARUS hash password dulu!
```

---

### **🔐 CARA HASH PASSWORD (For Method 3):**

**Via Laravel Tinker:**
```bash
# Jalankan tinker
php artisan tinker

# Hash password
>>> Hash::make('siswa123')
=> "$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"

# Copy hash tersebut untuk query SQL
```

**Via PHP Script:**
```php
<?php
$password = 'siswa123';
$hashed = password_hash($password, PASSWORD_BCRYPT);
echo $hashed;
```

---

## 📊 **COMPARISON TABLE**

| Aspek | Admin Panel | Seeder | Database |
|-------|------------|--------|----------|
| **Difficulty** | ⭐ Easy | ⭐⭐ Medium | ⭐⭐⭐ Hard |
| **Safety** | ✅ Very Safe | ✅ Safe | ⚠️ Risk |
| **Validation** | ✅ Auto | ⚠️ Manual | ❌ None |
| **Password Hash** | ✅ Auto | ✅ Auto | ⚠️ Manual |
| **Logging** | ✅ Yes | ❌ No | ❌ No |
| **Best For** | Production | Testing | Emergency |
| **Recommended** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐ |

---

## 🎯 **RECOMMENDED WORKFLOW**

### **Production (Live System):**
```
1. Login sebagai Admin
2. Gunakan form "Tambah Akun Pengguna"
3. Validasi otomatis
4. Data tersimpan dengan log audit
```

### **Development (Testing):**
```
1. Edit UserSeeder.php
2. Tambah user baru
3. Run: php artisan db:seed --class=UserSeeder
4. Test functionality
```

### **Emergency (Last Resort):**
```
1. Backup database dulu!
2. Insert via SQL
3. Hash password manual
4. Verify data di aplikasi
```

---

## ✅ **AFTER REGISTRATION CHECKLIST**

**Setelah user baru terdaftar:**

```
✅ User muncul di "Daftar Pengguna"
✅ User bisa login dengan email & password
✅ User redirect ke dashboard sesuai role:
   - Admin    → /admin/dashboard
   - Guru BK  → /guru_bk/dashboard
   - Siswa    → /student/dashboard

✅ Jika Siswa → Muncul di "Rekap Absensi"
✅ Data lengkap (nama, kelas, dll)
✅ Status aktif/nonaktif sesuai setting
```

---

## 🧪 **TESTING NEW USER**

### **Test Login:**
```bash
1. Logout dari akun admin
2. Login dengan akun baru
   Email: [email baru]
   Password: [password baru]
3. Verify redirect ke dashboard yang benar
4. Check menu & akses sesuai role
```

### **Test Data:**
```bash
1. Check di "Daftar Pengguna"
   ✅ User muncul
   ✅ Data lengkap

2. Check di "Rekap Absensi" (untuk siswa)
   ✅ Siswa muncul
   ✅ Status: "Belum ada absensi"

3. Click detail
   ✅ Nama & kelas correct
   ✅ Stats = 0 (belum absen)
```

---

## 🔒 **SECURITY NOTES**

### **DO:**
```
✅ Gunakan password kuat
✅ Unique email & NIS/NIP
✅ Hash password dengan Hash::make()
✅ Set status sesuai kebutuhan
✅ Log audit aktivitas admin
```

### **DON'T:**
```
❌ Share password default
❌ Hardcode password di code
❌ Commit seeder dengan data real
❌ Bypass validasi
❌ Insert plain text password
```

---

## 📝 **EXAMPLE: FULL WORKFLOW**

### **Scenario: Daftar Siswa Baru**

```
1. Login Admin
   URL: http://localhost/login
   Email: admin@educounsel.com
   Password: admin123

2. Menu → Daftar Pengguna

3. Click "Tambah Akun Pengguna"

4. Isi Form:
   Role         : Siswa
   Nama         : Ahmad Fauzi
   NIK/NIP      : SIS036
   Email        : ahmad.fauzi@educounsel.com
   Password     : Siswa@2024
   Gender       : Laki-laki
   Telepon      : 081234567899
   Status       : Aktif
   Alamat       : Jl. Pendidikan No. 25, Jakarta
   Kelas        : X RPL 1

5. Click "Simpan"

6. ✅ Success!
   Alert: "Akun pengguna berhasil ditambahkan!"

7. Verify:
   - Muncul di Daftar Pengguna
   - Muncul di Rekap Absensi
   - Bisa login dengan email & password

8. Test Login:
   Email: ahmad.fauzi@educounsel.com
   Password: Siswa@2024
   → Redirect ke /student/dashboard ✅
```

---

## 🎉 **SUMMARY**

### **Cara Tercepat & Teraman:**

```
1. Login Admin
2. Daftar Pengguna → Tambah Akun
3. Isi form dengan lengkap
4. Password min 8 char + kompleks
5. Click Simpan
6. Done! ✅
```

### **Routes:**
```
Form Tambah: /admin/tambah-akun
API Store  : POST /admin/pengguna/store
Daftar     : /admin/daftar-pengguna
```

### **Key Points:**
```
✅ Password HARUS kompleks (besar, kecil, angka, special)
✅ NIK/NIP & Email HARUS unique
✅ Siswa HARUS pilih kelas
✅ Guru BK & Admin TIDAK perlu kelas
✅ Validasi otomatis oleh system
✅ Log audit tersimpan
```

---

**Sekarang Anda siap mendaftarkan user baru! 🚀**
