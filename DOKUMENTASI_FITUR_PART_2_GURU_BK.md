# 📋 DOKUMENTASI FITUR - PART 2: GURU BK

**Project:** EDUCOUNSEL
**Role:** GURU BK
**File:** Part 2 dari 4

---

# RINGKASAN FITUR GURU BK

Total Fitur: 6 Fitur Utama

---

# 1. DASHBOARD GURU BK

**Fungsi:** Halaman utama monitoring konseling dan jadwal.

**Komponen:**
- Statistics cards (konseling bulan ini, pending, selesai)
- Jadwal konseling hari ini
- Siswa priority (need attention)
- Recent activity
- Quick actions

**Alur Kerja:**
```
Login → Dashboard load → Tampil stats → Jadwal hari ini →
Siswa priority → Quick actions → Navigate ke fitur
```

---

# 2. MANAGEMENT KONSELING

**Fungsi:** Sistem lengkap untuk kelola konseling.

## 2.1 Daftar Konseling
- Tabel semua konseling
- Filter by status, tanggal, kategori
- Action: detail, edit, mulai, catatan hasil

## 2.2 Jadwal Konseling
**Form Input:**
- Siswa (searchable dropdown)
- Jenis (individu/kelompok)
- Kategori masalah
- Tanggal & waktu
- Tempat
- Keterangan
- Priority level

**Alur:** Pilih siswa → Isi form → Validasi jadwal → Insert DB → Notif siswa → Success

## 2.3 Catatan Hasil Konseling
**Form Input:**
- Pilih konseling
- Masalah yang dibahas
- Analisis Guru BK
- Rencana tindak lanjut
- Tingkat keseriusan
- Kesimpulan
- Follow-up schedule

**Alur:** Konseling selesai → Isi form hasil → Submit → Update status → Notif jika urgent → Simpan hasil

---

# 3. MANAGEMENT PELANGGARAN

**Fungsi:** Catat dan monitor pelanggaran siswa.

**Form Pelanggaran:**
- Siswa
- Tanggal
- Jenis pelanggaran
- Detail kronologi
- Point (auto-calculate)
- Sanksi
- Perlu panggil ortu?

**Point System:**
- Terlambat: 5 point
- Cabut: 20 point
- Berkelahi: 50 point
- >100 point → Auto panggil ortu

**Alur:** Input pelanggaran → Calculate point → Cek threshold → Alert jika >100 → Generate surat panggilan

---

# 4. DATA SISWA

**Fungsi:** Database profil lengkap siswa untuk konseling.

**Profile Sections:**
1. Data pribadi (biodata lengkap)
2. Riwayat akademik (nilai, kehadiran)
3. Riwayat konseling (timeline)
4. Riwayat pelanggaran (total point)
5. Psychological profile (hasil kuesioner)
6. Catatan private Guru BK

**Alur:** Search siswa → Klik profile → Load data → Tampil tabs → Baca riwayat → Tambah catatan → Jadwalkan konseling

---

# 5. ANALISIS KUESIONER

**Fungsi:** Analisis hasil kuesioner psikologi siswa.

**Jenis Kuesioner:**
- SDQ (psychological screening)
- Minat karir
- Kepribadian
- Masalah psikologis

**Alur:**
```
Siswa isi kuesioner → Masuk list belum dianalisis →
Guru BK buka → Tampil jawaban → Auto-score →
Guru BK tulis analisis → Beri rekomendasi →
Submit → Jika urgent: auto jadwal konseling →
Siswa dapat feedback
```

---

# 6. LAPORAN & PANGGILAN ORTU

## 6.1 Laporan
**Jenis:**
- Laporan konseling bulanan
- Laporan pelanggaran
- Laporan individu siswa
- Laporan tahunan

**Alur:** Pilih jenis → Set periode → Generate → Download PDF/Excel

## 6.2 Panggilan Orang Tua
**Form:**
- Siswa
- Alasan panggilan
- Tanggal
- Generate surat? (auto-create PDF)
- Status (dijadwalkan/hadir/tidak hadir)

**Alur:** Input data → Generate surat → Send notif ortu → Pertemuan → Catat hasil

---

**END PART 2**
Next: Part 3 (Siswa) & Part 4 (AI Chatbot)
