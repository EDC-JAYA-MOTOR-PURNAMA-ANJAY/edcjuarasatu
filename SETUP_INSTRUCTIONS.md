# 🚀 SETUP INSTRUCTIONS - EDUCOUNSEL PROJECT

**Panduan Lengkap Setup Project Setelah Download/Clone dari GitHub**

---

## 📦 **REQUIREMENTS:**

Sebelum mulai, pastikan sudah install:

- ✅ **PHP 8.2+** (XAMPP sudah include)
- ✅ **Composer** (https://getcomposer.org)
- ✅ **MySQL** (XAMPP sudah include)
- ✅ **Git** (optional, untuk clone)
- ✅ **Web Browser** (Chrome/Edge/Firefox)

---

## 🔽 **STEP 1: DOWNLOAD PROJECT**

### **Option A: Clone via Git**
```bash
git clone https://github.com/EDC-JAYA-MOTOR-PURNAMA-ANJAY/edcjuarasatu.git
cd edcjuarasatu
```

### **Option B: Download ZIP**
1. Go to: https://github.com/EDC-JAYA-MOTOR-PURNAMA-ANJAY/edcjuarasatu
2. Click: **Code** → **Download ZIP**
3. Extract ke: `c:\xampp\htdocs\edcjuarasatu`

---

## 📝 **STEP 2: INSTALL DEPENDENCIES**

Buka terminal di folder project, jalankan:

```bash
composer install
```

**Ini akan:**
- Download semua library PHP yang dibutuhkan
- Install Laravel framework
- Install DomPDF untuk export PDF
- Setup autoloader

**Waktu:** ~3-5 menit (tergantung internet)

---

## 🗄️ **STEP 3: SETUP DATABASE**

### **3.1. Buat Database**

1. **Buka phpMyAdmin:** `http://localhost/phpmyadmin`
2. **Klik:** "New" di sidebar
3. **Nama database:** `sistem_bk`
4. **Collation:** `utf8mb4_unicode_ci`
5. **Klik:** "Create"

### **3.2. Create .env File**

**PENTING:** File `.env` tidak ada di GitHub!

```bash
# Copy dari example
copy .env.example .env
```

Atau manual: Duplicate file `.env.example` → rename jadi `.env`

### **3.3. Edit .env File**

Buka file `.env` dengan text editor, update:

```env
APP_NAME=Educounsel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Config
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_bk
DB_USERNAME=root
DB_PASSWORD=

# PENTING: AI Configuration (lihat STEP 4)
GEMINI_API_KEY=your_api_key_here
GEMINI_MODEL=gemini-2.5-flash
AI_COMPANION_ENABLED=true
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

### **3.4. Generate Application Key**

```bash
php artisan key:generate
```

Ini akan auto-fill `APP_KEY` di `.env`

---

## 🤖 **STEP 4: SETUP AI COMPANION (CHATBOT)**

### **4.1. Dapatkan Gemini API Key (GRATIS)**

1. **Buka:** https://aistudio.google.com/app/apikey
2. **Login** dengan Google Account
3. **Klik:** "Create API Key"
4. **Copy** API key yang muncul

**Contoh API Key:**
```
AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
```

### **4.2. Update .env**

Paste API key ke file `.env`:

```env
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
GEMINI_MODEL=gemini-2.5-flash
AI_COMPANION_ENABLED=true
```

**⚠️ PENTING:**
- Model HARUS `gemini-2.5-flash` (bukan 1.5!)
- API key GRATIS untuk 1 juta tokens/bulan
- No credit card needed!

---

## 🗃️ **STEP 5: RUN MIGRATIONS**

Setup database tables:

```bash
php artisan migrate
```

**Ini akan create tables:**
- ✅ `users` - User accounts
- ✅ `sessions` - Laravel sessions
- ✅ `ai_conversations` - Chat history
- ✅ `cache` - Cache storage
- ✅ Dan lain-lain

**Jika error:**
- Check database connection di `.env`
- Pastikan MySQL sudah running (XAMPP)
- Pastikan database `sistem_bk` sudah dibuat

---

## 🧹 **STEP 6: CLEAR CACHE**

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Atau pakai command all-in-one:

```bash
php artisan optimize:clear
```

---

## 🚀 **STEP 7: START SERVER**

```bash
php artisan serve
```

**Output:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

**Jangan tutup terminal ini!** Server akan running di background.

---

## 🌐 **STEP 8: AKSES WEBSITE**

**Buka browser:**
```
http://localhost:8000
```

### **Login:**
- **Admin/Guru BK:** (tergantung seeder)
- **Siswa:** (tergantung seeder)

**Jika belum ada user, buat via:**
- Register page (jika ada)
- Atau manual insert ke database

---

## 🧪 **STEP 9: TEST AI CHATBOT**

1. **Login sebagai siswa**
2. **Buka menu:** "Sahabat AI"
3. **Test chat:** Ketik "Halo, test koneksi"
4. **AI harus merespon** dalam 2-5 detik

**Jika AI tidak merespon:**
- Check `.env` → GEMINI_API_KEY correct?
- Check `.env` → GEMINI_MODEL = `gemini-2.5-flash`?
- Run: `php artisan config:clear`
- Check internet connection

---

## ✅ **VERIFICATION CHECKLIST:**

Setelah setup, test semua fitur:

- [ ] **Website buka:** `http://localhost:8000` ✅
- [ ] **Login berhasil** ✅
- [ ] **Dashboard muncul** ✅
- [ ] **Profile photo = initials** ✅
- [ ] **Menu navigasi berfungsi** ✅
- [ ] **AI Companion accessible** ✅
- [ ] **Chat dengan AI berhasil** ✅
- [ ] **AI merespon dengan benar** ✅
- [ ] **Export PDF berfungsi** ✅
- [ ] **Download PDF berhasil** ✅

---

## 🆘 **TROUBLESHOOTING:**

### **Problem 1: Composer Install Error**

**Error:** `composer not found`

**Solution:**
```bash
# Download & install Composer
https://getcomposer.org/download/
```

---

### **Problem 2: Database Connection Error**

**Error:** `SQLSTATE[HY000] [1045] Access denied`

**Solution:**
1. Check XAMPP MySQL running
2. Check `.env`:
   ```env
   DB_USERNAME=root
   DB_PASSWORD=        # Empty for XAMPP
   ```
3. Test connection:
   ```bash
   php artisan tinker
   DB::connection()->getPdo();
   ```

---

### **Problem 3: Migration Error**

**Error:** `Table 'sessions' already exists`

**Solution:**
```bash
php artisan migrate:fresh
# WARNING: Ini hapus semua data!
```

**Or:**
```bash
# Skip existing tables
php artisan migrate --force
```

---

### **Problem 4: AI Chatbot Error**

**Error:** "Maaf, aku sedang sibuk"

**Solution:**

**A. Check API Key:**
```bash
php artisan tinker
echo config('ai.gemini.api_key');
```

Should show your API key (not empty)

**B. Check Model:**
```bash
php artisan tinker
echo config('ai.gemini.model');
```

Should show: `gemini-2.5-flash`

**C. Update .env:**
```env
GEMINI_API_KEY=your_actual_key
GEMINI_MODEL=gemini-2.5-flash
```

**D. Clear cache:**
```bash
php artisan config:clear
```

**E. Restart server:**
```bash
# Stop: Ctrl + C
php artisan serve
```

---

### **Problem 5: Export PDF Error**

**Error:** `Class 'Pdf' not found`

**Solution:**
```bash
# Reinstall dompdf
composer require barryvdh/laravel-dompdf
composer dump-autoload
php artisan config:clear
```

---

### **Problem 6: 404 Not Found**

**Error:** Routes not found

**Solution:**
```bash
php artisan route:clear
php artisan route:cache
php artisan optimize
```

---

## 📚 **ADDITIONAL DOCUMENTATION:**

**Di folder project, baca:**

1. **AI_READY_TO_USE.md** - Panduan AI Companion
2. **CORTEX_REDESIGN_COMPLETE.md** - Design documentation
3. **EXPORT_PDF_FEATURE.md** - Export feature guide
4. **FIX_AI_MODEL.md** - Troubleshooting AI
5. **UPDATE_ENV_NOW.md** - .env configuration

---

## 🎯 **QUICK START SUMMARY:**

```bash
# 1. Download project
git clone https://github.com/EDC-JAYA-MOTOR-PURNAMA-ANJAY/edcjuarasatu.git
cd edcjuarasatu

# 2. Install dependencies
composer install

# 3. Setup .env
copy .env.example .env
# Edit .env: add GEMINI_API_KEY & database config

# 4. Generate key
php artisan key:generate

# 5. Create database 'sistem_bk' in phpMyAdmin

# 6. Run migrations
php artisan migrate

# 7. Clear cache
php artisan optimize:clear

# 8. Start server
php artisan serve

# 9. Open browser
# http://localhost:8000
```

**Total waktu setup: 10-15 menit**

---

## 🎉 **DONE!**

**Setelah ikuti semua langkah:**
- ✅ Website running
- ✅ Database configured
- ✅ AI Chatbot working
- ✅ Export PDF working
- ✅ All features functional

---

## 📞 **NEED HELP?**

**Check documentation:**
- README.md
- All *.md files in root folder

**Common issues:**
- API key wrong → Get new key
- Database error → Check MySQL running
- Migration error → Check database exists
- AI not working → Check .env config

---

## 🔐 **SECURITY NOTES:**

**JANGAN SHARE:**
- ❌ `.env` file (contains secrets!)
- ❌ GEMINI_API_KEY (personal!)
- ❌ Database credentials

**AMAN DI-SHARE:**
- ✅ Semua kode (.php, .blade.php, dll)
- ✅ Documentation (.md files)
- ✅ Config files (kecuali .env)

---

## 🎊 **SUCCESS!**

**Project siap digunakan!**

**Features:**
- ✅ AI Mental Health Companion
- ✅ Cortex-style modern UI
- ✅ Export chat to PDF
- ✅ Sentiment analysis
- ✅ Crisis detection
- ✅ Profile with initials

**100% Functional!** 🚀

---

**Made with ❤️ for Educounsel**
**Setup guide v1.0**
