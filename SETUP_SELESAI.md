# ✅ SETUP BERHASIL - EDUCOUNSEL

Selamat! Website Educounsel sudah siap digunakan.

---

## 🔐 AKUN LOGIN

### **1. ADMIN**
- Email: `admin@test.com`
- Password: `password123`
- Akses: Dashboard Admin, Kelola user, dll

### **2. GURU BK**
- Email: `guru@test.com`
- Password: `password123`
- Akses: Dashboard Guru BK, Konseling, Absensi

### **3. SISWA**
- Email: `siswa@test.com`
- Password: `password123`
- Akses: Dashboard Siswa, AI Chatbot, Absensi

---

## 🌐 URL AKSES

- **Homepage:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Dashboard Siswa:** http://localhost:8000/student/dashboard
- **AI Chatbot:** http://localhost:8000/student/ai-companion
- **phpMyAdmin:** http://localhost/phpmyadmin

---

## ✨ FITUR-FITUR WEBSITE

### 🔐 **Multi-Role Authentication**
- Admin Dashboard
- Guru BK Dashboard  
- Student Dashboard
- Role-based access control

### 🤖 **AI Chatbot Sahabat (FITUR UTAMA)**
- Konseling mental health dengan AI
- Powered by Google Gemini 2.5 Flash
- Voice notifications (TTS)
- Export chat ke PDF
- Chat history

### 📊 **Sistem Absensi**
- Absensi siswa real-time
- Rekap absensi per kelas
- Export data absensi
- Statistik kehadiran

### 💬 **Konseling**
- Jadwal konseling individu & kelompok
- Riwayat konseling
- Feedback konseling

### 🎨 **Modern UI/UX**
- Responsive design
- Smooth animations
- Interactive dashboards

---

## 🎯 CARA MENGGUNAKAN

### **Login Pertama Kali:**
1. Buka: http://localhost:8000
2. Klik tombol **"Login"**
3. Gunakan salah satu akun di atas
4. Anda akan diarahkan ke dashboard sesuai role

### **Mencoba AI Chatbot:**
1. Login sebagai **SISWA** (`siswa@test.com`)
2. Di sidebar, klik menu **"Sahabat AI"**
3. Ketik pesan konseling, contoh:
   - "Aku lagi stress dengan ujian besok"
   - "Aku kesulitan bergaul dengan teman"
   - "Aku merasa sedih akhir-akhir ini"
4. AI akan merespon dengan empati dan saran konseling
5. Klik **"Export chat"** untuk download percakapan ke PDF

---

## ⚠️ PENTING: SETUP API KEY

Untuk mengaktifkan **AI Chatbot**, Anda WAJIB menambahkan Gemini API Key:

### **Cara Mendapatkan API Key (GRATIS):**
1. Buka: https://aistudio.google.com/app/apikey
2. Login dengan akun Google
3. Klik **"Create API Key"**
4. Copy API key yang muncul

### **Cara Menambahkan ke Website:**
1. Buka file `.env` di folder project
2. Cari baris: `GEMINI_API_KEY=`
3. Paste API key Anda:
   ```
   GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
   ```
4. Save file
5. Jalankan di terminal:
   ```bash
   php artisan config:clear
   ```
6. Refresh browser

**Tanpa API key, fitur AI Chatbot tidak akan berfungsi!**

---

## 🚀 CARA MENJALANKAN SERVER (Setiap Kali)

Setiap kali ingin menggunakan website:

1. **Start XAMPP:**
   - Buka XAMPP Control Panel
   - Start **Apache**
   - Start **MySQL**

2. **Start Laravel Server:**
   - Buka terminal/command prompt
   - Navigate ke folder project:
     ```bash
     cd c:\xampp\htdocs\edcjuarasatu
     ```
   - Jalankan server:
     ```bash
     php artisan serve
     ```
   - Server akan running di: http://localhost:8000

3. **Buka Browser:**
   - Akses: http://localhost:8000

**JANGAN tutup terminal saat server berjalan!**

---

## 🛠️ TROUBLESHOOTING

### **Problem: AI Chatbot tidak merespon**
**Fix:**
1. Pastikan sudah add GEMINI_API_KEY di file `.env`
2. API Key harus valid (cek di https://aistudio.google.com/app/apikey)
3. Jalankan: `php artisan config:clear`
4. Refresh browser

### **Problem: Error "Class not found"**
**Fix:**
```bash
composer dump-autoload
php artisan config:clear
```

### **Problem: Database connection error**
**Fix:**
1. Start MySQL di XAMPP Control Panel
2. Cek database `sistem_bk` sudah dibuat di phpMyAdmin
3. Cek `.env` file:
   ```
   DB_DATABASE=sistem_bk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### **Problem: 500 Error**
**Fix:**
1. Check logs: `storage/logs/laravel.log`
2. Clear cache: `php artisan optimize:clear`
3. Restart server

---

## 📚 DOKUMENTASI LENGKAP

Project ini punya dokumentasi lengkap di folder root:

- `README.md` - Overview project
- `TESTING_GUIDE.md` - Panduan testing lengkap
- `QUICK_START.md` - Quick start guide
- `SETUP_INSTRUCTIONS.md` - Setup detail
- `CARA_MENGGUNAKAN_AI_COMPANION.md` - Panduan AI Chatbot
- `DATABASE_STRUCTURE.md` - Struktur database
- `SECURITY.md` - Fitur keamanan

---

## 🎓 TECH STACK

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **AI:** Google Gemini 2.5 Flash
- **Voice:** Web Speech API (TTS)

---

## 📞 BUTUH BANTUAN?

Jika ada masalah:
1. Check dokumentasi di folder project
2. Check logs di `storage/logs/laravel.log`
3. Check browser console (F12) untuk error frontend

---

## ✅ CHECKLIST AKHIR

Pastikan semua ini sudah:
- [x] ✅ PHP 8.2+ installed
- [x] ✅ Composer installed
- [x] ✅ MySQL running di XAMPP
- [x] ✅ Database `sistem_bk` created
- [x] ✅ Dependencies installed
- [x] ✅ `.env` file configured
- [x] ✅ App key generated
- [x] ✅ Migrations run
- [x] ✅ Test users created
- [x] ✅ Server running
- [ ] ⏳ GEMINI_API_KEY added (WAJIB untuk AI Chatbot!)

**Setelah add API key, website 100% siap digunakan!**

---

## 🎉 SELAMAT!

Website Educounsel sudah siap digunakan. Sekarang Anda bisa:
- ✅ Login dengan akun test
- ✅ Explore dashboard
- ✅ Mencoba fitur absensi
- ✅ Menggunakan AI Chatbot (setelah add API key)
- ✅ Export data ke PDF

**Happy Testing!** 🚀

---

**Project:** EDUCOUNSEL - Sistem Bimbingan Konseling  
**Framework:** Laravel 12  
**AI:** Google Gemini 2.5 Flash (FREE)  
**Developer:** SMK Antartika 1 Sidoarjo
