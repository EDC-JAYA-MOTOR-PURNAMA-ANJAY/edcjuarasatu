# 📋 DOKUMENTASI LENGKAP FITUR - PART 1: ADMIN

**Project:** EDUCOUNSEL - Sistem Bimbingan Konseling  
**Role:** ADMIN  
**File:** Part 1 dari 4

---

## 🎯 RINGKASAN FITUR ADMIN

Admin adalah role tertinggi dalam sistem yang bertanggung jawab mengelola seluruh sistem, user, dan monitoring.

**Total Fitur Admin:** 10 Fitur Utama

---

# 1️⃣ FITUR: DASHBOARD ADMIN

## 📌 Fungsi Fitur
Dashboard Admin adalah halaman utama setelah admin login yang menampilkan ringkasan statistik seluruh sistem secara real-time.

## 🎯 Tujuan
- Memberikan overview cepat tentang kondisi sistem
- Monitoring jumlah user aktif
- Melihat statistik konseling dan absensi
- Quick access ke menu-menu penting

## 📊 Komponen Dashboard
1. **Statistik Cards**
   - Total Siswa Aktif
   - Total Guru BK Aktif
   - Total Konseling Bulan Ini
   - Total Absensi Hari Ini

2. **Grafik Statistik**
   - Chart konseling per kategori masalah
   - Grafik absensi harian/mingguan
   - Trend konseling bulanan

3. **Quick Actions**
   - Tombol tambah user baru
   - Tombol lihat rekap absensi
   - Tombol monitoring

## 🔄 Alur Kerja
```
1. Admin login dengan email & password
   ↓
2. Sistem validasi credentials
   ↓
3. Jika valid, redirect ke /admin/dashboard
   ↓
4. Dashboard load data statistik dari database:
   - Query count users berdasarkan role
   - Query count konseling bulan ini
   - Query absensi hari ini
   ↓
5. Tampilkan cards dengan data real-time
   ↓
6. Render grafik menggunakan Chart.js
   ↓
7. Admin bisa klik quick action untuk navigate ke fitur lain
```

## 💻 Technical Details
- **Route:** `GET /admin/dashboard`
- **Middleware:** `auth, role:admin`
- **Controller:** Closure function di routes
- **View:** `resources/views/admin/dashboard/index.blade.php`
- **Database Query:**
  - Count users by role
  - Count konseling by date range
  - Count absensi by date

---

# 2️⃣ FITUR: MANAGEMENT PENGGUNA (USER MANAGEMENT)

## 📌 Fungsi Fitur
Sistem CRUD (Create, Read, Update, Delete) lengkap untuk mengelola semua user dalam sistem (Guru BK dan Siswa).

## 🎯 Tujuan
- Admin bisa menambah user baru (Guru BK/Siswa)
- Admin bisa melihat daftar semua user
- Admin bisa mengedit data user
- Admin bisa menghapus/menonaktifkan user
- Admin bisa mencari dan filter user

## 📊 Sub-Fitur

### 2.1. DAFTAR PENGGUNA (User List)

**Fungsi:** Menampilkan tabel semua user dengan pagination, search, dan filter.

**Fitur yang Ada:**
- **Tabel User** dengan kolom:
  - Foto profil (initial avatar)
  - Nama Lengkap
  - NIS/NIP
  - Email
  - Role (Guru BK/Siswa)
  - Kelas (untuk siswa)
  - Status (Aktif/Non-aktif)
  - Action buttons (Edit/Delete)

- **Search Box:** Cari by nama, NIS/NIP, atau email
- **Filter:**
  - Filter by Role (Semua/Guru BK/Siswa)
  - Filter by Status (Semua/Aktif/Non-aktif)
  - Filter by Kelas (untuk siswa)

- **Pagination:** 10 user per halaman
- **Bulk Actions:** (Future: bisa select multiple user)

**Alur Kerja:**
```
1. Admin buka /admin/daftar-pengguna
   ↓
2. Controller load semua users dari database
   ↓
3. Jika ada search query:
   - Filter users berdasarkan search term
   ↓
4. Jika ada filter:
   - Apply filter role/status/kelas
   ↓
5. Paginate hasil (10 per page)
   ↓
6. Tampilkan dalam tabel
   ↓
7. Admin bisa:
   - Klik tombol Edit → Redirect ke form edit
   - Klik tombol Delete → Konfirmasi → Hapus user
   - Klik tombol "Tambah Pengguna" → Form tambah user baru
```

**Technical Details:**
- **Route:** `GET /admin/daftar-pengguna`
- **Controller:** `PenggunaController@index`
- **View:** `admin/management-pengguna/daftar-pengguna.blade.php`
- **Query:** 
  ```php
  User::with('kelas.jurusan')
      ->where('nama', 'like', "%{$search}%")
      ->where('peran', $filter_role)
      ->paginate(10)
  ```

---

### 2.2. TAMBAH AKUN (Add User)

**Fungsi:** Form untuk membuat user baru (Guru BK atau Siswa).

**Field yang Harus Diisi:**
1. **Role** (dropdown)
   - Guru BK
   - Siswa

2. **Data Pribadi:**
   - Nama Lengkap (required)
   - NIK/NIP (required, unique)
   - Email (required, unique, valid email)
   - Password (required, min 8 char, harus ada uppercase, lowercase, angka, special char)
   - Jenis Kelamin (Laki-laki/Perempuan)
   - Nomor Telepon
   - Alamat

3. **Data Akademik (khusus Siswa):**
   - Kelas (dropdown dari daftar kelas)
   - Jurusan (auto-populate berdasarkan kelas)

4. **Status Account:**
   - Aktif / Non-aktif

**Validasi:**
- Email harus unique (cek database)
- NIK/NIP harus unique
- Password strength: min 8 karakter, harus ada huruf besar, kecil, angka, dan simbol
- Nomor telepon hanya angka
- Jika role Siswa, kelas wajib diisi

**Alur Kerja:**
```
1. Admin klik "Tambah Pengguna"
   ↓
2. Load form tambah akun
   ↓
3. Admin isi semua field
   ↓
4. Admin submit form
   ↓
5. Backend validasi data:
   - Cek email unique
   - Cek NIK/NIP unique
   - Validasi password strength
   - Validasi required fields
   ↓
6. Jika ada error:
   - Tampilkan error message
   - Return ke form dengan old input
   ↓
7. Jika valid:
   - Hash password dengan bcrypt
   - Insert data ke database (table users)
   - Generate avatar initial (huruf depan nama)
   ↓
8. Redirect ke daftar pengguna
   ↓
9. Tampilkan success message: "User berhasil ditambahkan!"
```

**Technical Details:**
- **Route:** 
  - `GET /admin/tambah-akun` (form)
  - `POST /admin/pengguna/store` (submit)
- **Controller:** `PenggunaController@create` & `PenggunaController@store`
- **View:** `admin/management-pengguna/tambah-akun.blade.php`
- **Validation Rules:**
  ```php
  'email' => 'required|email|unique:users,email',
  'nis_nip' => 'required|unique:users,nis_nip',
  'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
  'kelas_id' => 'required_if:role,siswa|exists:kelas,id'
  ```

---

### 2.3. EDIT PENGGUNA (Edit User)

**Fungsi:** Form untuk mengubah data user yang sudah ada.

**Field yang Bisa Diedit:**
- Semua field sama seperti tambah user
- Password: Optional (jika kosong = tidak diubah)
- Status: Bisa diubah Aktif/Non-aktif

**Perbedaan dengan Tambah:**
- Form pre-filled dengan data user saat ini
- Email dan NIK/NIP bisa sama dengan data lama (unique kecuali untuk user ini)
- Password optional

**Alur Kerja:**
```
1. Admin klik tombol Edit di daftar user
   ↓
2. Load form edit dengan data user (by ID)
   ↓
3. Form ter-isi dengan data current user
   ↓
4. Admin ubah data yang perlu diubah
   ↓
5. Admin submit form
   ↓
6. Backend validasi:
   - Cek email unique (kecuali email user ini)
   - Cek NIK/NIP unique (kecuali NIP user ini)
   - Jika password diisi, validasi strength
   ↓
7. Update data di database
   ↓
8. Jika password diisi, hash dan update password
   ↓
9. Redirect ke daftar pengguna
   ↓
10. Success message: "Data user berhasil diupdate!"
```

**Technical Details:**
- **Route:**
  - `GET /admin/pengguna/{id}/edit` (form)
  - `PUT /admin/pengguna/{id}` (update)
- **Controller:** `PenggunaController@edit` & `PenggunaController@update`
- **View:** `admin/management-pengguna/edit-pengguna.blade.php`

---

### 2.4. HAPUS PENGGUNA (Delete User)

**Fungsi:** Menghapus user dari sistem (soft delete atau hard delete).

**Konfirmasi:**
- Pop-up konfirmasi sebelum hapus
- Warning: "Data yang dihapus tidak bisa dikembalikan!"

**Alur Kerja:**
```
1. Admin klik tombol Delete di user list
   ↓
2. Muncul modal konfirmasi:
   "Yakin ingin menghapus [Nama User]?"
   ↓
3. Jika Admin klik "Batal" → Modal close
   ↓
4. Jika Admin klik "Hapus":
   - Send DELETE request ke backend
   ↓
5. Backend cek:
   - Apakah user ini punya data terkait? (absensi, konseling)
   ↓
6. Jika punya data penting:
   - Soft delete (set status = non-aktif)
   - Success: "User dinonaktifkan"
   ↓
7. Jika tidak ada data penting:
   - Hard delete dari database
   - Success: "User berhasil dihapus"
   ↓
8. Refresh halaman
   ↓
9. User hilang dari list
```

**Technical Details:**
- **Route:** `DELETE /admin/pengguna/{id}`
- **Controller:** `PenggunaController@destroy`
- **Method:** Soft Delete (recommended)
- **JavaScript:** SweetAlert2 untuk konfirmasi modal

---

# 3️⃣ FITUR: REKAP ABSENSI

## 📌 Fungsi Fitur
Sistem untuk melihat, monitoring, dan export data absensi siswa dengan berbagai filter dan periode.

## 🎯 Tujuan
- Admin bisa melihat rekap absensi per kelas
- Admin bisa melihat detail absensi per siswa
- Admin bisa filter by tanggal, kelas, status
- Admin bisa export data ke Excel/PDF

## 📊 Sub-Fitur

### 3.1. HALAMAN REKAP ABSENSI

**Fungsi:** Menampilkan tabel rekap absensi dengan filter dan statistik.

**Komponen:**
1. **Filter Panel:**
   - Filter by Kelas (dropdown)
   - Filter by Tanggal (date range picker)
   - Filter by Status (Hadir/Izin/Sakit/Alpha)
   - Filter by Bulan & Tahun

2. **Summary Cards:**
   - Total Hadir
   - Total Izin/Sakit
   - Total Alpha
   - Persentase Kehadiran

3. **Tabel Absensi:**
   - Nama Siswa
   - Kelas
   - Tanggal
   - Waktu Masuk
   - Status
   - Keterangan
   - Action (Detail)

4. **Export Buttons:**
   - Export to Excel
   - Export to PDF
   - Print

**Alur Kerja:**
```
1. Admin buka /admin/rekap-absensi
   ↓
2. Load default data (bulan ini, semua kelas)
   ↓
3. Query database:
   - Get absensi records
   - Join dengan data siswa & kelas
   - Calculate statistics
   ↓
4. Tampilkan summary cards:
   - Count by status (hadir, izin, sakit, alpha)
   - Calculate persentase kehadiran
   ↓
5. Render tabel dengan data absensi
   ↓
6. Admin bisa apply filter:
   - Pilih kelas tertentu
   - Pilih date range
   - Filter by status
   ↓
7. AJAX request dengan filter parameters
   ↓
8. Backend query ulang dengan filter
   ↓
9. Return JSON data
   ↓
10. Frontend update tabel & statistics (tanpa reload page)
```

**Technical Details:**
- **Route:** `GET /admin/rekap-absensi`
- **Controller:** `AbsensiController@rekapAbsensi`
- **View:** `admin/rekap-absensi/index.blade.php`
- **Database Query:**
  ```php
  Absensi::with('siswa', 'kelas')
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('kelas_id', $kelasId)
      ->where('status', $status)
      ->get()
  ```

---

### 3.2. DETAIL ABSENSI SISWA

**Fungsi:** Melihat riwayat absensi detail per siswa individual.

**Tampilan:**
- Header dengan data siswa:
  - Nama Lengkap
  - NIS
  - Kelas
  - Foto/Avatar

- **Timeline Absensi:**
  - List semua absensi siswa ini (terbaru dulu)
  - Per item menampilkan:
    - Tanggal
    - Hari
    - Waktu masuk & keluar
    - Status
    - Keterangan
    - Badge warna (hijau=hadir, kuning=izin, merah=alpha)

- **Statistik Personal:**
  - Total hari hadir
  - Total hari izin/sakit
  - Total alpha
  - Total terlambat
  - Persentase kehadiran
  - Grafik trend kehadiran bulanan

**Alur Kerja:**
```
1. Admin klik nama siswa di rekap absensi
   ↓
2. Redirect ke /admin/detail-absensi/{siswa_id}
   ↓
3. Load data siswa from database
   ↓
4. Load semua absensi siswa ini
   ↓
5. Calculate personal statistics
   ↓
6. Render timeline absensi (chronological)
   ↓
7. Render statistik cards
   ↓
8. Render grafik trend dengan Chart.js
```

**Technical Details:**
- **Route:** `GET /admin/detail-absensi/{id}`
- **Controller:** `AbsensiController@detailAbsensi`
- **View:** `admin/rekap-absensi/detail.blade.php`

---

### 3.3. EXPORT ABSENSI

**Fungsi:** Export data absensi ke format Excel atau PDF.

**Format Export:**

**Excel (.xlsx):**
- Sheet 1: Summary (statistik keseluruhan)
- Sheet 2: Detail Absensi (semua records)
- Include:
  - Header dengan logo & nama sekolah
  - Tanggal export
  - Filter yang digunakan
  - Data lengkap sesuai tabel

**PDF:**
- Format A4 Landscape
- Header: Logo, nama sekolah, judul laporan
- Tabel absensi dengan styling
- Footer: Total records, tanggal cetak

**Alur Kerja:**
```
1. Admin klik tombol "Export to Excel" atau "Export to PDF"
   ↓
2. Frontend send request dengan filter parameters:
   - Kelas ID
   - Date range
   - Status filter
   ↓
3. Backend process:
   - Query data sesuai filter
   - Generate file Excel/PDF
   - Set proper headers
   ↓
4. Return file sebagai download
   ↓
5. Browser trigger download
   ↓
6. File tersimpan di komputer user
   
File naming: Rekap_Absensi_[Kelas]_[Tanggal].xlsx
```

**Technical Details:**
- **Route:** `GET /admin/absensi/export?format=excel&kelas=X&...`
- **Controller:** `AbsensiController@exportAbsensi`
- **Library:** 
  - Excel: Maatwebsite/Laravel-Excel
  - PDF: DomPDF atau TCPDF

---

# 4️⃣ FITUR: TAHUN AJARAN

## 📌 Fungsi Fitur
Mengelola data tahun ajaran (academic year) yang digunakan untuk periodik data dalam sistem.

## 🎯 Tujuan
- Admin bisa membuat tahun ajaran baru
- Admin bisa set tahun ajaran aktif
- Data absensi & konseling ter-group by tahun ajaran

## 📊 Komponen

**Tabel Tahun Ajaran:**
- Nama Tahun Ajaran (contoh: "2024/2025")
- Tanggal Mulai
- Tanggal Selesai
- Status (Aktif/Non-aktif)
- Badge "AKTIF" untuk tahun ajaran yang sedang berjalan
- Action buttons (Edit/Delete/Set Aktif)

**Form Tambah/Edit:**
- Nama Tahun Ajaran
- Tanggal Mulai
- Tanggal Selesai
- Status
- Validasi: hanya 1 tahun ajaran yang boleh aktif

**Alur Kerja - Tambah Tahun Ajaran:**
```
1. Admin klik "Tambah Tahun Ajaran"
   ↓
2. Modal form muncul
   ↓
3. Admin isi:
   - Nama: "2024/2025"
   - Mulai: 2024-07-01
   - Selesai: 2025-06-30
   - Status: Aktif
   ↓
4. Submit form
   ↓
5. Backend validasi:
   - Cek overlapping tanggal dengan tahun ajaran lain
   - Jika set aktif, nonaktifkan tahun ajaran lain
   ↓
6. Insert ke database
   ↓
7. Success message
   ↓
8. Tabel refresh, tahun ajaran baru muncul
```

**Alur Kerja - Set Tahun Ajaran Aktif:**
```
1. Admin klik "Set Aktif" pada tahun ajaran tertentu
   ↓
2. Konfirmasi: "Set tahun ajaran ini sebagai aktif?"
   ↓
3. Backend process:
   - Set semua tahun ajaran status = non-aktif
   - Set tahun ajaran ini status = aktif
   ↓
4. Update database
   ↓
5. Success: "Tahun ajaran 2024/2025 sekarang aktif"
   ↓
6. Sistem sekarang gunakan tahun ajaran ini untuk data baru
```

**Technical Details:**
- **Route:** 
  - `GET /admin/tahun-ajaran`
  - `POST /admin/tahun-ajaran/store`
  - `PUT /admin/tahun-ajaran/{id}/set-active`
- **Controller:** `TahunAjaranController`
- **Model:** `TahunAjaran`
- **Database:** `tahun_ajaran` table

---

# 5️⃣ FITUR: MONITORING & STATISTIK

## 📌 Fungsi Fitur
Dashboard monitoring lengkap untuk statistik konseling dan demografi siswa dengan visualisasi grafik.

## 🎯 Tujuan
- Admin bisa monitor statistik konseling
- Melihat breakdown kategori masalah
- Melihat demografi siswa (gender, jurusan)
- Export laporan statistik

## 📊 Komponen

### Dashboard Monitoring:

**1. Filter Panel:**
- Filter by Guru BK (dropdown)
- Filter by Jurusan (dropdown)
- Filter by Kelas (dropdown)
- Filter by Date Range

**2. Grafik Kategori Masalah (Pie Chart):**
- Akademik
- Sosial
- Pribadi
- Karir
- Keluarga
- Warna berbeda per kategori
- Hover menampilkan jumlah & persentase

**3. Grafik Demografi (Bar Chart):**
- Jumlah Siswa (Laki-laki)
- Jumlah Siswi (Perempuan)
- Jumlah Guru BK
- Breakdown per jurusan

**4. Statistics Cards:**
- Total Konseling Bulan Ini
- Total Siswa Aktif
- Total Guru BK Aktif
- Rata-rata Konseling per Siswa

**5. Tabel Detail:**
- Recent konseling (10 terbaru)
- Status konseling (Pending/Selesai)
- Quick action (Lihat Detail)

**Alur Kerja:**
```
1. Admin buka /admin/monitoring
   ↓
2. Load data default (bulan ini, semua jurusan)
   ↓
3. Backend query:
   - Count konseling by kategori_masalah
   - Count users by gender & role
   - Get recent konseling
   ↓
4. Return data dalam JSON format
   ↓
5. Frontend render dengan Chart.js:
   - Pie chart untuk kategori masalah
   - Bar chart untuk demografi
   ↓
6. Render statistics cards
   ↓
7. Render tabel recent konseling
   ↓
8. Admin apply filter:
   - Select Guru BK / Jurusan
   ↓
9. AJAX request dengan filter
   ↓
10. Backend query ulang dengan filter
   ↓
11. Return updated JSON data
   ↓
12. Frontend update charts tanpa reload
```

**Real-time Update:**
- Setiap apply filter, charts update otomatis
- Smooth animation saat data berubah
- Loading indicator saat fetch data

**Export Options:**
- Export grafik as PNG image
- Export data as PDF report
- Export data as Excel

**Technical Details:**
- **Route:** 
  - `GET /admin/monitoring`
  - `GET /admin/monitoring/data` (AJAX)
  - `GET /admin/monitoring/export-pdf`
  - `GET /admin/monitoring/export-excel`
- **Controller:** `MonitoringController`
- **View:** `admin/monitoring/index.blade.php`
- **Charts:** Chart.js library

---

**🔚 END OF PART 1 - ADMIN FEATURES**

**Next Files:**
- Part 2: Fitur Guru BK
- Part 3: Fitur Siswa  
- Part 4: Fitur AI Chatbot & Lainnya

---

**Total Fitur Admin:** 5 Fitur Utama dengan 10+ Sub-fitur
