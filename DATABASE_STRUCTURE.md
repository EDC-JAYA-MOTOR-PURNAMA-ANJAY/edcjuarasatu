# 📊 Struktur Database - Sistem BK (Educounsel)

## 📋 Daftar Isi
1. [Overview](#overview)
2. [ERD & Relasi](#erd--relasi)
3. [Tabel Database](#tabel-database)
4. [Cara Menjalankan Migration](#cara-menjalankan-migration)
5. [Login Credentials](#login-credentials)

---

## Overview

Database sistem BK terdiri dari **15 tabel** dengan relasi hierarki yang terstruktur:

### Level 1: Tabel Independen (Tanpa Foreign Key)
- `tahun_ajaran` - Data tahun ajaran
- `jurusan` - Data jurusan
- `kategori_masalah` - Kategori masalah siswa
- `jenis_kuesioner` - Jenis/tipe kuesioner

### Level 2: Tabel dengan FK ke Level 1
- `kelas` - Data kelas (FK: jurusan, tahun_ajaran)

### Level 3: Tabel Users
- `users` - Data pengguna sistem (FK: kelas)

### Level 4: Tabel dengan FK ke Users
- `konseling` - Data konseling (FK: siswa, guru_bk, kategori_masalah)
- `kuesioner` - Data kuesioner (FK: jenis_kuesioner, created_by)
- `materi` - Data materi edukasi (FK: created_by)
- `laporan` - Data laporan (FK: created_by)

### Level 5: Tabel Relasional
- `hasil_konseling` - Hasil konseling (FK: konseling)
- `feedback_konseling` - Feedback konseling (FK: konseling)
- `pertanyaan_kuesioner` - Pertanyaan dalam kuesioner (FK: kuesioner)

### Level 6: Tabel Transaksional
- `jawaban_kuesioner` - Jawaban siswa (FK: kuesioner, pertanyaan, siswa)
- `hasil_analisis_kuesioner` - Hasil analisis (FK: kuesioner)

---

## ERD & Relasi

```
tahun_ajaran (1) ──┐
                   ├──> kelas (M) ──> users (M)
jurusan (1) ───────┘                     │
                                         │
kategori_masalah (1) ────┐              │
                         ├──> konseling (M) ──┬──> hasil_konseling (1)
users (guru_bk) ─────────┤                    └──> feedback_konseling (M)
users (siswa) ───────────┘

jenis_kuesioner (1) ──┐
                      ├──> kuesioner (M) ──┬──> pertanyaan_kuesioner (M) ──┐
users (created_by) ───┘                    │                                │
                                           ├──> hasil_analisis_kuesioner (1)│
                                           │                                │
users (siswa) ─────────────────────────────┴──> jawaban_kuesioner (M) <────┘

users (created_by) ────> materi (M)
users (created_by) ────> laporan (M)
```

---

## Tabel Database

### 1. tahun_ajaran
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| tahun_ajaran | VARCHAR(9) | Format: 2024/2025 |
| status | ENUM | aktif / non-aktif |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 2. jurusan
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| kode_jurusan | VARCHAR(10) | RPL, TKJ, MM, dll |
| nama_jurusan | VARCHAR(50) | Nama lengkap jurusan |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 3. kelas
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| nama_kelas | VARCHAR(20) | X RPL 1, XI TKJ 2, dll |
| jurusan_id | INT (FK) | Foreign key ke jurusan |
| tahun_ajaran_id | INT (FK) | Foreign key ke tahun_ajaran |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 4. users
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| nis_nip | VARCHAR(20) | NIS untuk siswa, NIP untuk guru/admin |
| nama | VARCHAR(100) | Nama lengkap |
| email | VARCHAR(100) | Email (unique) |
| password | VARCHAR(255) | Password (hashed) |
| peran | ENUM | admin / guru_bk / siswa |
| status | ENUM | aktif / non-aktif |
| jenis_kelamin | ENUM | laki-laki / perempuan |
| alamat | TEXT | Alamat lengkap |
| no_telepon | VARCHAR(15) | Nomor telepon |
| kelas_id | INT (FK) | Foreign key ke kelas (untuk siswa) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 5. kategori_masalah
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| nama_kategori | VARCHAR(50) | Akademik, Sosial, Pribadi, dll |
| deskripsi | TEXT | Deskripsi kategori |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 6. konseling
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| siswa_id | INT (FK) | Foreign key ke users (siswa) |
| guru_bk_id | INT (FK) | Foreign key ke users (guru_bk) |
| kategori_masalah_id | INT (FK) | Foreign key ke kategori_masalah |
| judul | VARCHAR(100) | Judul konseling |
| deskripsi | TEXT | Deskripsi masalah |
| tanggal_pengajuan | DATE | Tanggal pengajuan |
| waktu_pengajuan | TIME | Waktu pengajuan |
| tanggal_konseling | DATE | Tanggal konseling (nullable) |
| waktu_konseling | TIME | Waktu konseling (nullable) |
| status | ENUM | menunggu_persetujuan / diproses / dikonfirmasi / ditolak / selesai |
| alasan_penolakan | TEXT | Alasan jika ditolak (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 7. hasil_konseling
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| konseling_id | INT (FK) | Foreign key ke konseling |
| catatan | TEXT | Catatan hasil konseling |
| tindak_lanjut | TEXT | Tindak lanjut (nullable) |
| tanggal_selesai | DATE | Tanggal selesai (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 8. feedback_konseling
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| konseling_id | INT (FK) | Foreign key ke konseling |
| rating | INT | Rating 1-5 |
| komentar | TEXT | Komentar feedback (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 9. jenis_kuesioner
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| nama_kuesioner | VARCHAR(100) | Nama jenis kuesioner |
| deskripsi | TEXT | Deskripsi (nullable) |
| tipe | ENUM | layanan_bk / akademik / lainnya |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 10. kuesioner
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| judul | VARCHAR(100) | Judul kuesioner |
| jenis_kuesioner_id | INT (FK) | Foreign key ke jenis_kuesioner |
| deskripsi | TEXT | Deskripsi (nullable) |
| created_by | INT (FK) | Foreign key ke users (creator) |
| expired_at | DATE | Tanggal expired (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 11. pertanyaan_kuesioner
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| kuesioner_id | INT (FK) | Foreign key ke kuesioner |
| pertanyaan | TEXT | Isi pertanyaan |
| tipe_jawaban | ENUM | pilihan_ganda / eskalasi_likert / teks |
| opsi_jawaban | JSON | Opsi jawaban (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 12. jawaban_kuesioner
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| kuesioner_id | INT (FK) | Foreign key ke kuesioner |
| pertanyaan_id | INT (FK) | Foreign key ke pertanyaan_kuesioner |
| siswa_id | INT (FK) | Foreign key ke users (siswa) |
| jawaban | TEXT | Jawaban siswa |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 13. hasil_analisis_kuesioner
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| kuesioner_id | INT (FK) | Foreign key ke kuesioner |
| summary | TEXT | Ringkasan hasil |
| insights | JSON | Insights analisis (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 14. materi
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| judul | VARCHAR(100) | Judul materi |
| konten | TEXT | Konten materi |
| tipe | ENUM | artikel / video |
| url_video | VARCHAR(255) | URL video (nullable) |
| created_by | INT (FK) | Foreign key ke users (creator) |
| tags | JSON | Tags materi (nullable) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### 15. laporan
| Field | Type | Description |
|-------|------|-------------|
| id | INT (PK) | Primary key |
| judul | VARCHAR(100) | Judul laporan |
| tipe_laporan | ENUM | bulanan / tahunan / khusus |
| periode | VARCHAR(50) | Periode laporan |
| data | JSON | Data laporan |
| created_by | INT (FK) | Foreign key ke users (creator) |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

---

## Cara Menjalankan Migration

### 1. Persiapan
Pastikan XAMPP MySQL sudah running dan file `.env` sudah dikonfigurasi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_bk
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Buat Database
Buat database baru di phpMyAdmin atau via command line:
```sql
CREATE DATABASE sistem_bk;
```

### 3. Jalankan Migration
```bash
php artisan migrate
```

### 4. Jalankan Seeder (Data Awal)
```bash
php artisan db:seed
```

Atau jalankan semuanya sekaligus:
```bash
php artisan migrate:fresh --seed
```

### 5. Jika Ada Error
Reset database dan jalankan ulang:
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

---

## Login Credentials

Setelah menjalankan seeder, gunakan credentials berikut untuk login:

### 👨‍💼 Admin
- **Email:** admin@educounsel.com
- **Password:** admin123

### 👨‍🏫 Guru BK
- **Email:** guru@educounsel.com
- **Password:** guru123

### 👨‍🎓 Siswa
- **Email:** siswa@educounsel.com
- **Password:** siswa123

---

## Model Relationships

### User Model
```php
// Relationships
$user->kelas                    // BelongsTo Kelas
$user->konselingAsSiswa         // HasMany Konseling (as siswa)
$user->konselingAsGuruBK        // HasMany Konseling (as guru_bk)
$user->kuesioner                // HasMany Kuesioner (created)
$user->jawabanKuesioner         // HasMany JawabanKuesioner
$user->materi                   // HasMany Materi (created)
$user->laporan                  // HasMany Laporan (created)
```

### Konseling Model
```php
// Relationships
$konseling->siswa               // BelongsTo User
$konseling->guruBK              // BelongsTo User
$konseling->kategoriMasalah     // BelongsTo KategoriMasalah
$konseling->hasilKonseling      // HasOne HasilKonseling
$konseling->feedback            // HasMany FeedbackKonseling
```

### Kuesioner Model
```php
// Relationships
$kuesioner->jenisKuesioner      // BelongsTo JenisKuesioner
$kuesioner->creator             // BelongsTo User
$kuesioner->pertanyaan          // HasMany PertanyaanKuesioner
$kuesioner->jawaban             // HasMany JawabanKuesioner
$kuesioner->hasilAnalisis       // HasOne HasilAnalisisKuesioner
```

---

## Catatan Penting

1. **Urutan Migration** sudah diatur dengan timestamp yang benar
2. **Foreign Key Constraints** menggunakan `onDelete('cascade')` untuk auto-delete
3. **JSON Fields** untuk data dinamis (tags, opsi_jawaban, insights, dll)
4. **Enum Fields** untuk status yang terbatas
5. **Timestamps** otomatis di semua tabel

---

## Support

Jika ada pertanyaan atau masalah, silakan hubungi tim developer.

**Generated:** 2025-01-01
**Version:** 1.0.0
