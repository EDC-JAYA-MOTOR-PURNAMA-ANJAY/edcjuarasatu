# 📋 DOKUMENTASI FITUR - PART 3: SISWA

**Project:** EDUCOUNSEL
**Role:** SISWA
**File:** Part 3 dari 4

---

# RINGKASAN FITUR SISWA

Total Fitur: 7 Fitur Utama + AI Chatbot (dibahas Part 4)

---

# 1. DASHBOARD SISWA

**Fungsi:** Halaman utama siswa dengan ringkasan aktivitas.

**Komponen:**
- Welcome message dengan voice TTS
- Statistics cards:
  - Kehadiran bulan ini
  - Konseling yang dijadwalkan
  - Kuesioner pending
  - Status pelanggaran (jika ada)
- Jadwal konseling terdekat
- Reminder (absen hari ini, kuesioner belum diisi)
- Quick access menu
- Recent activity

**Alur Kerja:**
```
Login → Voice welcome "Selamat datang, [Nama]!" →
Dashboard load → Query stats dari DB →
Tampil cards → Load jadwal konseling →
Check: sudah absen hari ini? (tampil reminder jika belum) →
Siswa navigate ke fitur lain via menu
```

**Technical:**
- Route: `/student/dashboard`
- View: `student/dashboard/index.blade.php`
- TTS Voice: Female Indonesia (rate 0.88, pitch 1.15)

---

# 2. FITUR ABSENSI

**Fungsi:** Sistem absensi mandiri untuk siswa.

## 2.1 Halaman Absensi

**Komponen:**
- **Absen Button (besar, prominent)**
  - Icon fingerprint/check-in
  - Text: "Absen Sekarang"
  - Disabled jika sudah absen hari ini

- **Time Display:**
  - Jam real-time (update setiap detik)
  - Tanggal hari ini
  - Status: "Tepat Waktu" (hijau) atau "Terlambat" (merah)

- **Statistics Cards:**
  - Total Hadir
  - Total Izin/Sakit
  - Total Alpha
  - Total Terlambat

- **Tabel Riwayat Absensi:**
  - 10 absensi terakhir
  - Tanggal
  - Waktu masuk
  - Status
  - Keterangan

**Alur Kerja - Absen:**
```
1. Siswa buka /student/attendance
   ↓
2. Check: sudah absen hari ini?
   ↓
3. Jika belum:
   - Button "Absen Sekarang" aktif
   - Tampil jam real-time
   ↓
4. Siswa klik "Absen Sekarang"
   ↓
5. Confirm dialog: "Yakin ingin absen?"
   ↓
6. Submit via AJAX
   ↓
7. Backend process:
   - Get current time
   - Check: apakah > 07:00? (terlambat)
   - Insert ke table absensi:
     * siswa_id
     * tanggal: today
     * waktu_masuk: now()
     * status: 'hadir'
     * keterangan: 'Masuk' atau 'Telat'
   ↓
8. Return response dengan voice notification
   ↓
9. Frontend:
   - Success animation
   - Voice TTS: "Absensi berhasil! Selamat belajar, [Nama]!"
   - Jika terlambat: "Kamu terlambat hari ini. Besok usahakan tepat waktu ya!"
   - Button disabled
   - Update statistics
   ↓
10. Refresh tabel riwayat (absen hari ini muncul)
```

**Validasi:**
- Hanya bisa absen 1x per hari
- Tidak bisa absen untuk tanggal lain
- Tidak bisa absen di hari libur (future enhancement)

**Voice Notification:**
- Success: Energetic female voice
- Late: Gentle reminder voice
- Motivasi: "Semangat belajar hari ini!"

**Technical:**
- Route POST: `/student/attendance/store`
- Controller: `AttendanceController@store`
- Response JSON: 
  ```json
  {
    "success": true,
    "message": "Absen berhasil!",
    "data": {
      "nama": "Ahmad",
      "tanggal": "Senin, 6 November 2025",
      "waktu": "07:15",
      "keterangan": "Telat",
      "is_late": true
    }
  }
  ```

---

# 3. FITUR KONSELING

**Fungsi:** Siswa bisa ajukan konseling dan lihat riwayat.

## 3.1 Daftar Konseling

**Tampilan:**
- List konseling siswa ini (past & upcoming)
- Card per konseling:
  - Tanggal & waktu
  - Guru BK yang handle
  - Kategori masalah
  - Status (Dijadwalkan/Selesai)
  - Hasil/feedback (jika sudah selesai)

## 3.2 Ajukan Konseling Baru

**Form:**
1. Kategori Masalah (dropdown):
   - Akademik (nilai, belajar)
   - Sosial (pertemanan, bullying)
   - Pribadi (emosi, stress)
   - Karir (cita-cita, jurusan kuliah)
   - Keluarga (masalah di rumah)

2. Tingkat Urgensi:
   - Normal
   - Urgent (need immediate attention)

3. Deskripsi Masalah (text area):
   - Ceritakan masalah secara singkat
   - Min 50 karakter

4. Waktu Preferred (optional):
   - Date picker
   - Time slot (pagi/siang/sore)

5. Konseling dengan: (optional)
   - Pilih Guru BK tertentu
   - Default: sistem auto-assign

6. Anonymous? (checkbox):
   - Jika checked, data diri disembunyikan dari preview
   - Guru BK tetap tahu, tapi tidak tampil di public list

**Alur Kerja:**
```
1. Siswa klik "Ajukan Konseling Baru"
   ↓
2. Modal form muncul
   ↓
3. Siswa isi form:
   - Kategori: "Pribadi"
   - Urgensi: "Urgent"
   - Deskripsi: "Saya merasa sangat tertekan dengan ujian..."
   - Waktu: "Besok siang"
   ↓
4. Submit
   ↓
5. Validasi:
   - Kategori wajib diisi
   - Deskripsi min 50 char
   ↓
6. Insert ke table 'konseling':
   - siswa_id
   - kategori_masalah_id
   - deskripsi
   - tingkat_urgensi
   - waktu_preferred
   - status: 'pending'
   - created_at
   ↓
7. Notify Guru BK via:
   - Email notification
   - In-app notification
   - WhatsApp (jika ada API)
   ↓
8. Success message:
   "Permohonan konseling berhasil dikirim!
   Guru BK akan menghubungi kamu segera."
   ↓
9. Muncul di list konseling siswa dengan status "Menunggu Penjadwalan"
   ↓
10. Guru BK akan buat jadwal & konfirmasi ke siswa
```

## 3.3 Lihat Hasil Konseling

**Setelah konseling selesai:**
- Siswa bisa buka detail konseling
- Melihat feedback/kesimpulan dari Guru BK
- Melihat rencana tindak lanjut
- Rating (optional): beri rating ke Guru BK

**Technical:**
- Route: `/student/counseling`
- Controller: `CounselingController`
- Model: `Konseling`

---

# 4. FITUR RIWAYAT PELANGGARAN

**Fungsi:** Siswa bisa melihat pelanggaran yang pernah dilakukan.

**Tampilan:**
- Alert jika ada pelanggaran baru
- Total point pelanggaran (progress bar):
  - 0-30: Hijau (aman)
  - 31-70: Kuning (warning)
  - 71-100: Merah (bahaya!)

- **Tabel Pelanggaran:**
  - Tanggal
  - Jenis pelanggaran
  - Point
  - Sanksi
  - Status penanganan

- **Warning System:**
  - Jika point > 50: Warning box
    "Perhatian! Kamu sudah mendapat 50 point. Harap perbaiki perilaku."
  - Jika point > 100: Danger box
    "Orang tuamu akan dipanggil! Segera temui Guru BK."

**Fungsi Edukatif:**
- Explain kenapa pelanggaran itu buruk
- Tips untuk avoid pelanggaran
- Motivasi untuk perbaiki diri

**Alur:**
```
Guru BK input pelanggaran → Siswa dapat notif →
Siswa buka /student/violation → Lihat pelanggaran baru →
Check total point → Tampil warning jika tinggi →
Siswa aware dan berusaha perbaiki
```

**Technical:**
- Route: `/student/violation`
- Query: `Pelanggaran::where('siswa_id', auth()->id())->get()`

---

# 5. FITUR KUESIONER

**Fungsi:** Siswa mengisi kuesioner psikologi untuk assessment.

## 5.1 Daftar Kuesioner

**Tampilan:**
- Card per kuesioner:
  - Judul kuesioner
  - Deskripsi singkat
  - Jumlah pertanyaan
  - Estimasi waktu
  - Status: Belum Diisi / Sudah Diisi
  - Button: "Mulai" atau "Lihat Hasil"

**Jenis Kuesioner:**
- Kuesioner SDQ (psychological screening)
- Kuesioner minat karir
- Kuesioner kepribadian
- Kuesioner masalah siswa

## 5.2 Mengerjakan Kuesioner

**UI:**
- Full-screen mode (distraction-free)
- Progress bar (pertanyaan ke-X dari Y)
- Pertanyaan ditampilkan satu per satu
- Pilihan jawaban:
  - Multiple choice
  - Skala 1-5 (Likert scale)
  - Text input (untuk essay)
- Button: "Sebelumnya" & "Selanjutnya"
- Auto-save draft setiap 30 detik

**Alur Kerja:**
```
1. Siswa pilih kuesioner "SDQ"
   ↓
2. Klik "Mulai Kuesioner"
   ↓
3. Redirect ke /student/questionnaire/start/{id}
   ↓
4. Load pertanyaan pertama
   ↓
5. Siswa jawab → Klik "Selanjutnya"
   ↓
6. Auto-save jawaban via AJAX
   ↓
7. Load pertanyaan berikutnya
   ↓
8. Repeat sampai semua pertanyaan selesai
   ↓
9. Halaman konfirmasi: "Review jawaban?"
   ↓
10. Siswa klik "Submit Kuesioner"
   ↓
11. Backend:
    - Save semua jawaban final
    - Mark kuesioner as completed
    - Notify Guru BK untuk analisis
   ↓
12. Success page:
    "Terima kasih! Guru BK akan menganalisis hasilmu."
   ↓
13. Redirect ke dashboard
```

## 5.3 Lihat Hasil Kuesioner

**Setelah Guru BK analisis:**
- Siswa bisa lihat feedback
- Tampilan:
  - Score per kategori (visual chart)
  - Interpretasi singkat
  - Rekomendasi dari Guru BK
  - Follow-up action (jika perlu konseling)

**Privacy:**
- Hasil detail hanya siswa & Guru BK yang bisa lihat
- Orang lain tidak bisa akses

**Technical:**
- Route: `/student/questionnaire`
- Controller: `KuesionerController`
- Model: `Kuesioner`, `JawabanKuesioner`

---

# 6. FITUR PROFILE & SETTINGS

**Fungsi:** Siswa bisa edit profile dan pengaturan akun.

**Profile Page:**

**Section 1: Data Diri**
- Avatar/foto (bisa upload)
- Nama lengkap (read-only)
- NIS (read-only)
- Email (bisa edit)
- No. Telepon (bisa edit)
- Alamat (bisa edit)

**Section 2: Data Akademik**
- Kelas (read-only)
- Jurusan (read-only)
- Kehadiran bulan ini (%)
- Ranking kelas (future)

**Section 3: Statistik Personal**
- Total konseling
- Kuesioner yang sudah diisi
- Persentase kehadiran overall
- Grafik trend nilai (future)

**Section 4: Security**
- Ubah password
- Validasi: password lama, password baru, konfirmasi

**Section 5: Preferences**
- Notifikasi: Email/WhatsApp (toggle)
- Language: Indonesia/English
- Theme: Light/Dark mode (future)

**Alur Edit Profile:**
```
Siswa buka profile → Klik edit → Ubah data →
Submit → Validasi → Update DB → Success message
```

**Alur Ubah Password:**
```
Klik "Ubah Password" → Form muncul →
Input password lama, baru, konfirmasi →
Submit → Backend verify password lama →
Jika match: hash password baru → Update →
Success: "Password berhasil diubah! Silakan login ulang."
```

**Technical:**
- Route: `/student/profile`
- Controller: `ProfileController`
- Validation: 
  ```php
  'password_lama' => 'required',
  'password_baru' => 'required|min:8|confirmed'
  ```

---

# 7. FITUR MATERI & PANDUAN

**Fungsi:** Akses materi edukasi dan panduan.

**Konten:**
- **Artikel Psikologi:**
  - Mengelola stress
  - Tips belajar efektif
  - Cara mengatasi anxiety
  - Self-care untuk remaja

- **Video Edukasi:**
  - Embedded YouTube videos
  - Topik: mental health, motivasi, karir

- **E-Book/PDF:**
  - Panduan memilih jurusan kuliah
  - Tips menghadapi ujian
  - Healthy lifestyle untuk pelajar

- **FAQ:**
  - Tanya jawab seputar BK
  - Cara ajukan konseling
  - Kerahasiaan konseling

**Fitur:**
- Search materi
- Filter by kategori
- Bookmark (simpan favorit)
- Share ke teman

**Alur:**
```
Siswa buka /student/materi → Browse artikel →
Klik artikel → Read content → Bookmark jika suka →
Share via WhatsApp/email
```

**Technical:**
- Route: `/student/materi`
- Model: `Materi`
- Categories: Artikel, Video, E-Book, FAQ

---

**END PART 3**
Next: Part 4 (AI Chatbot & Fitur Lainnya)
