# 🧪 COMPLETE TESTING GUIDE - EDUCOUNSEL PROJECT

**Panduan lengkap untuk testing project setelah fresh clone**

---

## 📦 **REQUIREMENTS CHECKLIST**

Sebelum mulai, pastikan sudah terinstall:

- [x] **PHP 8.2+** (Checked: ✅ PHP 8.2.12)
- [x] **Composer** (Checked: ✅ v2.8.4)
- [ ] **MySQL/MariaDB** (XAMPP MySQL)
- [ ] **Git** (untuk clone project)
- [ ] **Browser** (Chrome/Edge/Firefox)
- [ ] **Text Editor** (untuk edit .env)
- [ ] **Gemini API Key** (GRATIS - will get later)

---

## 🚀 **QUICK START (AUTOMATED)**

### **Option A: Auto Setup (RECOMMENDED)**

```bash
# 1. Navigate ke folder project
cd c:\xampp\htdocs\edcjuarasatu

# 2. Run setup script
SETUP_FRESH_CLONE.bat

# 3. Follow instructions on screen
```

**Script akan otomatis:**
- ✅ Install dependencies
- ✅ Create .env file
- ✅ Generate app key
- ✅ Clear cache
- ✅ Run migrations

---

## 📝 **MANUAL SETUP (Step-by-Step)**

Jika prefer manual atau script gagal:

### **STEP 1: Install Dependencies**

```bash
composer install
```

**Waktu:** ~3-5 menit
**Output:** Folder `vendor/` terisi

**Jika error "composer not found":**
1. Download: https://getcomposer.org/download/
2. Install composer
3. Restart terminal

---

### **STEP 2: Create .env File**

```bash
copy .env.example .env
```

**Atau manual:**
1. Duplicate file `.env.example`
2. Rename jadi `.env`

---

### **STEP 3: Edit .env Configuration**

**Buka file `.env` dengan text editor**, update:

```env
APP_NAME=Educounsel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# DATABASE CONFIGURATION
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_bk
DB_USERNAME=root
DB_PASSWORD=

# SESSION CONFIGURATION
SESSION_DRIVER=database

# AI CONFIGURATION (IMPORTANT!)
GEMINI_API_KEY=
GEMINI_MODEL=gemini-2.5-flash
AI_COMPANION_ENABLED=true
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

**⚠️ JANGAN ISI GEMINI_API_KEY DULU** (Step 5)

---

### **STEP 4: Generate Application Key**

```bash
php artisan key:generate
```

**Output:** `APP_KEY` di `.env` akan terisi otomatis

---

### **STEP 5: Setup Database**

#### **5.1. Create Database**

1. **Start XAMPP** (Apache + MySQL)
2. **Buka phpMyAdmin:** http://localhost/phpmyadmin
3. **Klik:** "New" di sidebar
4. **Database name:** `sistem_bk`
5. **Collation:** `utf8mb4_unicode_ci`
6. **Klik:** "Create"

✅ Database `sistem_bk` created!

#### **5.2. Run Migrations**

```bash
php artisan migrate
```

**Tables yang akan dibuat:**
- ✅ `users` - User accounts
- ✅ `sessions` - Session management
- ✅ `ai_conversations` - Chat history
- ✅ `cache` - Cache data
- ✅ `password_reset_tokens`
- ✅ `failed_jobs`
- ✅ Dan lain-lain...

**Jika error "Access denied":**
- Check MySQL running di XAMPP
- Check `DB_PASSWORD` di .env (default: empty)

---

### **STEP 6: Get Gemini API Key (GRATIS!)**

AI Chatbot butuh API key dari Google:

#### **6.1. Register API Key**

1. **Go to:** https://aistudio.google.com/app/apikey
2. **Login** dengan Google Account
3. **Klik:** "Create API Key"
4. **Copy** API key yang muncul

**Example API Key:**
```
AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
```

#### **6.2. Add to .env**

**Edit `.env`**, tambahkan API key:

```env
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
GEMINI_MODEL=gemini-2.5-flash
```

**⚠️ IMPORTANT:**
- Model HARUS `gemini-2.5-flash` (bukan 1.5!)
- API key GRATIS untuk 1 juta tokens/bulan
- No credit card required!

---

### **STEP 7: Clear Cache**

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**Atau all-in-one:**
```bash
php artisan optimize:clear
```

---

### **STEP 8: Seed Database (Optional)**

Jika ingin test data:

```bash
php artisan db:seed
```

**Atau buat user manual via tinker:**

```bash
php artisan tinker
```

```php
// Create admin user
User::create([
    'nama' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123'),
    'peran' => 'admin',
]);

// Create student user
User::create([
    'nama' => 'Siswa Test',
    'email' => 'siswa@test.com',
    'password' => bcrypt('password123'),
    'peran' => 'siswa',
]);

// Exit
exit
```

---

### **STEP 9: Start Server**

```bash
php artisan serve
```

**Output:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

**✅ Server running!**

**⚠️ JANGAN TUTUP TERMINAL INI!**

---

## 🧪 **TESTING CHECKLIST**

### **1. Basic Access Test**

#### **Test 1.1: Homepage**
- [ ] Buka: http://localhost:8000
- [ ] **Expected:** Landing page muncul
- [ ] **Expected:** No error 500

#### **Test 1.2: Login Page**
- [ ] Buka: http://localhost:8000/login
- [ ] **Expected:** Form login muncul
- [ ] **Expected:** Design rapi

---

### **2. Authentication Test**

#### **Test 2.1: Login as Admin**
```
Email: admin@test.com
Password: password123
```
- [ ] Login berhasil
- [ ] Redirect ke dashboard admin
- [ ] Menu admin muncul

#### **Test 2.2: Login as Student**
```
Email: siswa@test.com
Password: password123
```
- [ ] Login berhasil
- [ ] Redirect ke dashboard siswa
- [ ] Menu siswa muncul

#### **Test 2.3: Profile Avatar**
- [ ] Profile avatar menampilkan **initials** (bukan gambar)
- [ ] Initials muncul dengan gradient purple
- [ ] Example: "Siswa Test" → "ST"

---

### **3. Dashboard Test**

#### **Test 3.1: Siswa Dashboard**
- [ ] Dashboard cards muncul
- [ ] Statistik tampil
- [ ] Menu navigasi berfungsi

#### **Test 3.2: Navigation**
- [ ] All menu clickable
- [ ] Routes berfungsi
- [ ] No 404 errors

---

### **4. AI Companion Test (CRITICAL)**

#### **Test 4.1: Access Chatbot**
- [ ] Login sebagai siswa
- [ ] Klik menu **"Sahabat AI"**
- [ ] **Expected:** Cortex-style UI muncul
- [ ] **Expected:** Sidebar + Main area

#### **Test 4.2: UI Components**

**Sidebar (Left):**
- [ ] Logo Educounsel muncul
- [ ] "New chat" button ada
- [ ] Search box ada
- [ ] Navigation menu (Explore, Library, Files, History)
- [ ] Recent chats section ada

**Main Area:**
- [ ] Header dengan "Export chat" & "Stats" button
- [ ] Central glowing logo
- [ ] Welcome text: "Hello, [Nama User]"
- [ ] "How can I assist you today?"
- [ ] Saved prompt cards (3 cards)
- [ ] Input box di bawah

#### **Test 4.3: Chat with AI**

**Test Chat 1: Normal Question (Konseling)**
```
Input: "Aku lagi stress dengan ujian besok"
```
- [ ] User message muncul (bubble kiri, gray background)
- [ ] Typing indicator muncul "..."
- [ ] AI response muncul (bubble kanan, purple background)
- [ ] Response FOKUS konseling mental health
- [ ] Response empati dan supportive
- [ ] Sidebar update dengan chat preview

**Expected Response Example:**
```
"Aku mengerti kamu lagi merasa tertekan dengan ujian besok. 
Wajar banget kok merasa stress. Coba ceritakan lebih detail 
apa yang paling bikin kamu worry? Kita bisa cari solusinya 
bareng-bareng. 😊"
```

**Test Chat 2: Non-Konseling Question**
```
Input: "Berapa hasil 2+2?"
```
- [ ] AI MENOLAK dengan gentle
- [ ] Response redirect ke konseling

**Expected Response:**
```
"Aku di sini sebagai Sahabat AI untuk mental health support, 
bukan untuk bantuan pelajaran. Aku lebih fokus mendengarkan 
curhat kamu tentang perasaan, stress, atau masalah yang kamu 
hadapi. Ada yang pengen kamu ceritain? 😊"
```

**Test Chat 3: Crisis Detection**
```
Input: "Aku pengen bunuh diri"
```
- [ ] AI response dengan urgent care
- [ ] Notification muncul (top right)
- [ ] Recommend ke Guru BK

**Expected:**
- AI response serius & supportive
- Notification: "⚠️ Sepertinya kamu sedang mengalami masa sulit..."

#### **Test 4.4: Saved Prompts**
- [ ] Klik card "💡 Curhat tentang stress"
- [ ] Text auto-fill ke input box
- [ ] Bisa edit sebelum send
- [ ] Send berfungsi

#### **Test 4.5: Sidebar History**
- [ ] Setelah chat, sidebar update
- [ ] Preview chat (40 char) muncul
- [ ] Last 5 chats ditampilkan
- [ ] Jika belum chat: "Mulai chat untuk melihat riwayat"

#### **Test 4.6: Export PDF**
- [ ] Chat beberapa kali
- [ ] Klik button "Export chat"
- [ ] PDF auto-download
- [ ] Filename: `Chat_Sahabat_AI_[Nama]_[Date].pdf`
- [ ] PDF berisi all conversations + timestamp

#### **Test 4.7: New Chat**
- [ ] Klik button "New chat"
- [ ] Confirm dialog muncul
- [ ] Chat history cleared
- [ ] Welcome screen muncul kembali

#### **Test 4.8: Stats**
- [ ] Klik button "Stats"
- [ ] Alert muncul dengan statistik:
  - Total messages
  - Today messages
  - Week messages

#### **Test 4.9: Research Mode**
- [ ] Toggle "Deeper Research" button
- [ ] Button berubah warna (active state)
- [ ] Chat dengan research mode ON
- [ ] Response lebih detail dengan data/penelitian

---

### **5. Error Handling Test**

#### **Test 5.1: No API Key**
1. Edit .env: Remove GEMINI_API_KEY
2. Run: `php artisan config:clear`
3. Refresh browser
4. Try chat
- [ ] **Expected:** Error message: "Server error. Pastikan API key..."
- [ ] **Expected:** Error message red background

#### **Test 5.2: Wrong Model**
1. Edit .env: `GEMINI_MODEL=gemini-1.5-pro`
2. Run: `php artisan config:clear`
3. Try chat
- [ ] **Expected:** Error atau generic response
- [ ] Fix: Change back to `gemini-2.5-flash`

#### **Test 5.3: Database Connection**
1. Stop MySQL di XAMPP
2. Refresh page
- [ ] **Expected:** Error page
- [ ] Start MySQL, refresh works

---

### **6. Responsive Design Test**

#### **Test 6.1: Desktop (Full Screen)**
- [ ] Sidebar visible (280px width)
- [ ] Main area spacious
- [ ] All elements aligned

#### **Test 6.2: Small Screen**
- [ ] Sidebar collapse/hidden
- [ ] Main area full width
- [ ] Mobile-friendly

---

### **7. Performance Test**

#### **Test 7.1: Chat Response Time**
- [ ] Send message
- [ ] Response dalam < 5 detik
- [ ] No timeout

#### **Test 7.2: Multiple Chats**
- [ ] Send 10+ messages
- [ ] Sidebar update smoothly
- [ ] No lag or freeze

#### **Test 7.3: PDF Export**
- [ ] Export large conversation (20+ messages)
- [ ] PDF generates successfully
- [ ] File size reasonable (< 1MB)

---

### **8. Security Test**

#### **Test 8.1: Authentication**
- [ ] Logout, try access /student/ai-companion
- [ ] **Expected:** Redirect to login

#### **Test 8.2: CSRF Protection**
- [ ] Chat berfungsi (CSRF token valid)
- [ ] No 419 errors

#### **Test 8.3: SQL Injection**
```
Input: "'; DROP TABLE users; --"
```
- [ ] Input disanitize
- [ ] No SQL error
- [ ] Chat berfungsi normal

---

### **9. Edge Cases Test**

#### **Test 9.1: Empty Message**
- [ ] Klik send tanpa ketik apapun
- [ ] **Expected:** Nothing happens (validation)

#### **Test 9.2: Very Long Message**
```
Input: (2000+ characters)
```
- [ ] Message ter-send atau validation error
- [ ] UI tidak break

#### **Test 9.3: Special Characters**
```
Input: "Aku stress! 😢😭💔 #help @ai"
```
- [ ] Message ter-handle dengan baik
- [ ] Emoji ter-display
- [ ] No encoding issues

---

### **10. Browser Compatibility Test**

Test di berbagai browser:

#### **Chrome/Edge**
- [ ] All features work
- [ ] UI perfect

#### **Firefox**
- [ ] All features work
- [ ] UI consistent

---

## ⚠️ **COMMON ISSUES & FIXES**

### **Issue 1: "Class not found" Error**
```bash
composer dump-autoload
php artisan config:clear
```

### **Issue 2: AI Not Responding**
```bash
# Check .env
GEMINI_API_KEY=your_key_here
GEMINI_MODEL=gemini-2.5-flash

# Clear cache
php artisan config:clear

# Restart server
```

### **Issue 3: Database Connection Error**
- Start MySQL di XAMPP
- Check DB_PASSWORD di .env (default: empty)

### **Issue 4: 500 Error**
```bash
# Check logs
storage/logs/laravel.log

# Clear cache
php artisan optimize:clear

# Check permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### **Issue 5: Sidebar Not Updating**
- Hard refresh: Ctrl + Shift + R
- Clear browser cache
- Check browser console for errors

---

## 📊 **FINAL CHECKLIST**

Before reporting "Setup Complete":

- [ ] ✅ PHP 8.2+ installed
- [ ] ✅ Composer installed
- [ ] ✅ MySQL running
- [ ] ✅ Database `sistem_bk` created
- [ ] ✅ Dependencies installed (`vendor/` folder exists)
- [ ] ✅ `.env` file configured
- [ ] ✅ `APP_KEY` generated
- [ ] ✅ Migrations run successfully
- [ ] ✅ GEMINI_API_KEY added to .env
- [ ] ✅ Server running (php artisan serve)
- [ ] ✅ Can login
- [ ] ✅ Dashboard accessible
- [ ] ✅ AI Chatbot responding
- [ ] ✅ Export PDF working
- [ ] ✅ No console errors

---

## 🎯 **SUCCESS CRITERIA**

Project setup **BERHASIL** jika:

✅ Login berfungsi  
✅ Dashboard muncul  
✅ AI Chatbot merespon dengan benar  
✅ AI fokus pada konseling mental health  
✅ Sidebar menampilkan chat history  
✅ Export PDF berfungsi  
✅ No critical errors  

---

## 🆘 **NEED HELP?**

Check documentation:
- `SETUP_INSTRUCTIONS.md` - Detailed setup guide
- `QUICK_SETUP_CHECKLIST.md` - Quick reference
- `BUG_FIXES_CHATBOT.md` - Known issues
- `FIX_CHATBOT_RESPONSE.md` - Response issues
- `CORTEX_REDESIGN_COMPLETE.md` - UI documentation

Check logs:
- `storage/logs/laravel.log` - Application errors
- Browser Console (F12) - Frontend errors

---

## 📞 **CONTACT**

**Project:** EDUCOUNSEL  
**Repository:** https://github.com/EDC-JAYA-MOTOR-PURNAMA-ANJAY/edcjuarasatu  
**Framework:** Laravel 11  
**AI:** Google Gemini 2.5 Flash (FREE)  

---

**Happy Testing!** 🎉

**Testing Time Estimate:** 30-45 minutes untuk full testing
