# 🔍 Debug: Kenapa Login Selalu ke Dashboard Siswa?

## Kemungkinan Penyebab

### 1. **User yang Login Memiliki Role 'siswa'**

Cek data user di database:

```sql
SELECT id, email, nama, peran, status FROM users;
```

**Yang harus dicek:**
- Apakah email yang Anda gunakan untuk login memiliki peran yang benar?
- Admin: `admin@educounsel.com` → peran = 'admin'
- Guru BK: `guru@educounsel.com` → peran = 'guru_bk'  
- Siswa: `siswa@educounsel.com` → peran = 'siswa'

---

## ✅ Solusi Langkah demi Langkah

### Step 1: Cek Email yang Anda Gunakan

**Pertanyaan:** Email apa yang Anda gunakan untuk login?

- [ ] admin@educounsel.com
- [ ] guru@educounsel.com
- [ ] siswa@educounsel.com
- [ ] Email lain: ______________

### Step 2: Cek Data di Database

Buka **phpMyAdmin** atau jalankan query:

```sql
USE sistem_bk;
SELECT id, nis_nip, nama, email, peran, status FROM users;
```

**Expected Output:**
```
+----+---------+---------------------------+---------------------------+---------+--------+
| id | nis_nip | nama                      | email                     | peran   | status |
+----+---------+---------------------------+---------------------------+---------+--------+
|  1 | ADM001  | Budi Santoso              | admin@educounsel.com      | admin   | aktif  |
|  2 | ADM002  | Sari Indah                | sari.indah@educounsel.com | admin   | aktif  |
|  3 | GBK001  | Dr. Ahmad Wijaya, M.Pd    | guru@educounsel.com       | guru_bk | aktif  |
|  4 | GBK002  | Diana Puspita, S.Pd       | diana.puspita@...         | guru_bk | aktif  |
|  8 | SIS001  | Andi Pratama              | siswa@educounsel.com      | siswa   | aktif  |
+----+---------+---------------------------+---------------------------+---------+--------+
```

### Step 3: Verifikasi User ID 8

Dari error trace Anda:
```
* mysql - select * from `users` where `id` = 8 limit 1 (4.75 ms)
```

User dengan ID 8 sedang login. Cek apa peran user ID 8:

```sql
SELECT * FROM users WHERE id = 8;
```

**Jika hasilnya:**
- peran = 'siswa' → **BENAR**, user ID 8 memang siswa
- peran = 'admin' atau 'guru_bk' → Ada masalah di LoginController

---

## 🔧 Perbaikan Jika Data Salah

### Jika User ID 8 Seharusnya Admin

```sql
UPDATE users SET peran = 'admin' WHERE id = 8;
```

### Jika User ID 8 Seharusnya Guru BK

```sql
UPDATE users SET peran = 'guru_bk' WHERE id = 8;
```

### Jika Ingin Reset Semua Data

```bash
php artisan migrate:fresh --seed
```

**WARNING:** Ini akan menghapus semua data dan membuat ulang!

---

## 🧪 Test Login dengan Email yang Benar

### Test 1: Login sebagai Admin
```
Email: admin@educounsel.com
Password: admin123
Expected: Redirect ke /admin/dashboard
```

### Test 2: Login sebagai Guru BK
```
Email: guru@educounsel.com
Password: guru123
Expected: Redirect ke /guru_bk/dashboard
```

### Test 3: Login sebagai Siswa
```
Email: siswa@educounsel.com
Password: siswa123
Expected: Redirect ke /student/dashboard
```

---

## 📊 Debug Mode (Opsional)

Jika masih bingung, tambahkan debug di LoginController:

```php
// Di method redirectBasedOnRole(), tambahkan:
dd([
    'user_id' => $user->id,
    'email' => $user->email,
    'peran' => $user->peran,
    'redirect_to' => match($user->peran) {
        'admin' => route('admin.dashboard'),
        'guru_bk' => route('guru_bk.dashboard'),
        'siswa' => route('student.dashboard'),
        default => 'unknown'
    }
]);
```

Ini akan menampilkan informasi user sebelum redirect.

---

## ✅ Kesimpulan

**Kemungkinan Besar:**
1. ✅ Anda login dengan email yang memiliki peran 'siswa'
2. ✅ User ID 8 di database memang memiliki peran 'siswa'
3. ✅ Sistem berfungsi dengan benar!

**Solusi:**
- Login dengan email yang sesuai dengan role yang diinginkan
- Atau ubah peran user di database jika memang salah

---

## 📞 Next Step

**Tolong konfirmasi:**
1. Email apa yang Anda gunakan untuk login?
2. Cek di database, apa peran dari user dengan email tersebut?
3. Screenshot hasil query: `SELECT * FROM users WHERE id = 8;`

Setelah itu saya bisa bantu lebih spesifik! 🚀
