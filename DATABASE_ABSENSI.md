# 📊 Struktur Database Absensi - Sistem BK (Educounsel)

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Struktur Tabel](#struktur-tabel)
3. [Relasi Database](#relasi-database)
4. [Cara Menjalankan](#cara-menjalankan)
5. [Penggunaan Model](#penggunaan-model)
6. [Query Examples](#query-examples)

---

## Overview

Database absensi adalah bagian dari sistem BK untuk tracking kehadiran siswa. Tabel ini mencatat:
- ✅ Kehadiran harian siswa
- ⏰ Waktu masuk dan keluar
- 📝 Status (Hadir, Izin, Sakit, Alpha)
- 🔍 Verifikasi oleh guru/admin
- 📎 Upload bukti surat (untuk izin/sakit)

---

## Struktur Tabel

### Tabel: `absensi`

| Field | Type | Nullable | Description |
|-------|------|----------|-------------|
| id | BIGINT (PK) | NO | Primary key auto increment |
| siswa_id | BIGINT (FK) | NO | Foreign key ke tabel users (siswa) |
| kelas_id | BIGINT (FK) | YES | Foreign key ke tabel kelas |
| tahun_ajaran_id | BIGINT (FK) | YES | Foreign key ke tabel tahun_ajaran |
| tanggal | DATE | NO | Tanggal absensi |
| waktu_masuk | TIME | YES | Waktu masuk siswa (HH:MM:SS) |
| waktu_keluar | TIME | YES | Waktu keluar siswa (HH:MM:SS) |
| status | ENUM | NO | hadir / izin / sakit / alpha |
| keterangan | TEXT | YES | Keterangan tambahan |
| bukti_file | VARCHAR(255) | YES | Path file surat izin/sakit |
| verified_by | BIGINT (FK) | YES | User ID yang memverifikasi |
| verified_at | TIMESTAMP | YES | Waktu verifikasi |
| created_at | TIMESTAMP | NO | Waktu record dibuat |
| updated_at | TIMESTAMP | NO | Waktu record diupdate |

### Indexes

```sql
-- Composite index untuk pencarian cepat
INDEX idx_siswa_tanggal (siswa_id, tanggal)

-- Index untuk filter status
INDEX idx_status (status)
```

### Enum Values

**Status:**
- `hadir` - Siswa hadir di sekolah
- `izin` - Siswa izin dengan surat/pemberitahuan
- `sakit` - Siswa sakit dengan/tanpa surat dokter
- `alpha` - Siswa tidak hadir tanpa keterangan

---

## Relasi Database

### ERD Diagram

```
users (siswa) ──────┐
                    │
kelas ──────────────┼──> absensi (M)
                    │
tahun_ajaran ───────┤
                    │
users (verifier) ───┘
```

### Foreign Keys

1. **siswa_id** → users.id
   - ON DELETE CASCADE
   - Jika siswa dihapus, absensinya juga terhapus

2. **kelas_id** → kelas.id
   - ON DELETE SET NULL
   - Jika kelas dihapus, kelas_id di absensi menjadi NULL

3. **tahun_ajaran_id** → tahun_ajaran.id
   - ON DELETE SET NULL
   - Jika tahun ajaran dihapus, tahun_ajaran_id menjadi NULL

4. **verified_by** → users.id
   - ON DELETE SET NULL
   - Jika user verifier dihapus, verified_by menjadi NULL

---

## Cara Menjalankan

### 1. Jalankan Migration

```bash
# Jalankan migration absensi
php artisan migrate

# Atau jika ingin fresh migrate semua
php artisan migrate:fresh
```

### 2. Jalankan Seeder (Optional)

```bash
# Jalankan seeder absensi untuk data dummy
php artisan db:seed --class=AbsensiSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

### 3. Rollback (Jika Diperlukan)

```bash
# Rollback migration terakhir
php artisan migrate:rollback

# Rollback step tertentu
php artisan migrate:rollback --step=1
```

---

## Penggunaan Model

### Model Absensi

```php
use App\Models\Absensi;

// Get all absensi
$absensi = Absensi::all();

// Get absensi dengan relasi
$absensi = Absensi::with(['siswa', 'kelas', 'tahunAjaran', 'verifier'])->get();

// Filter by siswa
$absensiSiswa = Absensi::where('siswa_id', 1)->get();

// Filter by tanggal
$absensiHariIni = Absensi::whereDate('tanggal', today())->get();

// Filter by status
$siswaHadir = Absensi::where('status', 'hadir')->get();
```

### Relationships

```php
// Dari Absensi ke Siswa
$absensi->siswa; // User object (siswa)
$absensi->siswa->nama; // Nama siswa

// Dari Absensi ke Kelas
$absensi->kelas; // Kelas object
$absensi->kelas->nama_kelas; // Nama kelas

// Dari Absensi ke Tahun Ajaran
$absensi->tahunAjaran; // TahunAjaran object
$absensi->tahunAjaran->tahun_ajaran; // 2024/2025

// Dari Absensi ke Verifier
$absensi->verifier; // User object (guru/admin)
$absensi->verifier->nama; // Nama verifier
```

### Dari User Model

```php
use App\Models\User;

// Get absensi siswa
$siswa = User::find(1);
$absensiSiswa = $siswa->absensi; // Collection of Absensi

// Get absensi yang diverifikasi oleh user
$guru = User::find(2);
$absensiVerified = $guru->absensiVerified; // Collection of Absensi
```

---

## Query Examples

### 1. Rekap Absensi Siswa Per Bulan

```php
use App\Models\Absensi;
use Carbon\Carbon;

$bulan = Carbon::now()->month;
$tahun = Carbon::now()->year;

$rekapAbsensi = Absensi::where('siswa_id', $siswaId)
    ->whereMonth('tanggal', $bulan)
    ->whereYear('tanggal', $tahun)
    ->selectRaw('
        status, 
        COUNT(*) as jumlah
    ')
    ->groupBy('status')
    ->get();

// Result:
// [
//     {status: 'hadir', jumlah: 18},
//     {status: 'izin', jumlah: 1},
//     {status: 'sakit', jumlah: 1}
// ]
```

### 2. Persentase Kehadiran Siswa

```php
$totalHari = Absensi::where('siswa_id', $siswaId)
    ->whereMonth('tanggal', $bulan)
    ->count();

$totalHadir = Absensi::where('siswa_id', $siswaId)
    ->whereMonth('tanggal', $bulan)
    ->where('status', 'hadir')
    ->count();

$persentase = ($totalHadir / $totalHari) * 100;
// Result: 90% (contoh)
```

### 3. Daftar Siswa Alpha Hari Ini

```php
$siswaAlpha = Absensi::with('siswa')
    ->whereDate('tanggal', today())
    ->where('status', 'alpha')
    ->get();

foreach ($siswaAlpha as $absen) {
    echo $absen->siswa->nama . " - " . $absen->siswa->kelas->nama_kelas;
}
```

### 4. Absensi Per Kelas

```php
$absensiKelas = Absensi::with(['siswa', 'kelas'])
    ->where('kelas_id', $kelasId)
    ->whereDate('tanggal', today())
    ->get()
    ->groupBy('status');

// Result:
// [
//     'hadir' => Collection [...],
//     'izin' => Collection [...],
//     'sakit' => Collection [...],
//     'alpha' => Collection [...]
// ]
```

### 5. Siswa dengan Kehadiran Rendah (< 75%)

```php
use Illuminate\Support\Facades\DB;

$siswaKehadiranRendah = DB::table('absensi')
    ->select('siswa_id', 
        DB::raw('COUNT(*) as total_hari'),
        DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as total_hadir'),
        DB::raw('(SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) / COUNT(*)) * 100 as persentase')
    )
    ->whereMonth('tanggal', $bulan)
    ->groupBy('siswa_id')
    ->having('persentase', '<', 75)
    ->get();
```

### 6. Menggunakan Scopes

```php
use App\Models\Absensi;

// Filter by status (menggunakan scope)
$siswaHadir = Absensi::byStatus('hadir')->get();

// Filter by date range
$startDate = '2025-01-01';
$endDate = '2025-01-31';
$absensiJanuari = Absensi::byDateRange($startDate, $endDate)->get();

// Filter by siswa
$absensiSiswa = Absensi::bySiswa($siswaId)->get();

// Kombinasi scopes
$absensiSiswaHadir = Absensi::bySiswa($siswaId)
    ->byStatus('hadir')
    ->byDateRange($startDate, $endDate)
    ->get();
```

---

## Create/Update/Delete Examples

### 1. Create Absensi

```php
use App\Models\Absensi;

Absensi::create([
    'siswa_id' => 1,
    'kelas_id' => 1,
    'tahun_ajaran_id' => 1,
    'tanggal' => today(),
    'waktu_masuk' => '07:15:00',
    'waktu_keluar' => '14:30:00',
    'status' => 'hadir',
    'keterangan' => null,
]);
```

### 2. Update Absensi

```php
$absensi = Absensi::find(1);
$absensi->update([
    'status' => 'izin',
    'keterangan' => 'Sakit demam',
    'verified_by' => auth()->id(),
    'verified_at' => now(),
]);
```

### 3. Upload Bukti File

```php
$request->validate([
    'bukti_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
]);

$path = $request->file('bukti_file')->store('absensi/bukti', 'public');

$absensi->update([
    'bukti_file' => $path,
]);
```

---

## Statistik & Analytics

### Dashboard Admin - Statistik Hari Ini

```php
$today = today();

$stats = [
    'total_siswa' => User::where('peran', 'siswa')->count(),
    'hadir' => Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count(),
    'izin' => Absensi::whereDate('tanggal', $today)->where('status', 'izin')->count(),
    'sakit' => Absensi::whereDate('tanggal', $today)->where('status', 'sakit')->count(),
    'alpha' => Absensi::whereDate('tanggal', $today)->where('status', 'alpha')->count(),
];

$stats['persentase_hadir'] = ($stats['hadir'] / $stats['total_siswa']) * 100;
```

---

## Validasi & Rules

### Form Validation

```php
// Controller validation
$request->validate([
    'siswa_id' => 'required|exists:users,id',
    'tanggal' => 'required|date',
    'status' => 'required|in:hadir,izin,sakit,alpha',
    'waktu_masuk' => 'nullable|date_format:H:i',
    'waktu_keluar' => 'nullable|date_format:H:i',
    'keterangan' => 'nullable|string|max:500',
    'bukti_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
]);
```

---

## Catatan Penting

1. ✅ **Foreign Keys** sudah diatur dengan onDelete cascade/set null
2. ✅ **Indexes** untuk optimasi query
3. ✅ **Scopes** untuk filter yang sering digunakan
4. ✅ **Relationships** lengkap di semua model
5. ✅ **Seeder** untuk data dummy testing
6. ⚠️ **Backup** data secara berkala
7. ⚠️ **Validasi** file upload untuk keamanan

---

## Support

Jika ada pertanyaan atau masalah, silakan hubungi tim developer.

**Generated:** 2025-10-31  
**Version:** 1.0.0
