# ✅ QUICK SETUP CHECKLIST

**Untuk teman yang download project dari GitHub**

---

## 📋 **SETUP CHECKLIST (10-15 menit):**

### **□ 1. Requirements Installed**
- [ ] PHP 8.2+ (via XAMPP)
- [ ] Composer installed
- [ ] MySQL running (XAMPP)

### **□ 2. Download Project**
```bash
git clone https://github.com/EDC-JAYA-MOTOR-PURNAMA-ANJAY/edcjuarasatu.git
cd edcjuarasatu
```

### **□ 3. Install Dependencies**
```bash
composer install
```
⏱️ ~3-5 menit

### **□ 4. Create Database**
- [ ] Buka phpMyAdmin
- [ ] Create database: `sistem_bk`

### **□ 5. Setup .env File**
```bash
copy .env.example .env
```
Edit `.env`:
- [ ] Database config (DB_DATABASE=sistem_bk)
- [ ] **PENTING: Tambah GEMINI_API_KEY**

### **□ 6. Get Gemini API Key (GRATIS)**
1. [ ] Go to: https://aistudio.google.com/app/apikey
2. [ ] Login Google
3. [ ] Create API Key
4. [ ] Copy & paste ke `.env`

```env
GEMINI_API_KEY=your_key_here
GEMINI_MODEL=gemini-2.5-flash
AI_COMPANION_ENABLED=true
```

### **□ 7. Generate App Key**
```bash
php artisan key:generate
```

### **□ 8. Run Migrations**
```bash
php artisan migrate
```

### **□ 9. Clear Cache**
```bash
php artisan optimize:clear
```

### **□ 10. Start Server**
```bash
php artisan serve
```

### **□ 11. Test**
- [ ] Open: `http://localhost:8000`
- [ ] Login
- [ ] Test AI Chatbot
- [ ] Test Export PDF

---

## ⚠️ **YANG PERLU DISETUP:**

| Item | Status | Action |
|------|--------|--------|
| **Dependencies** | ❌ Tidak ada | `composer install` |
| **.env File** | ❌ Tidak ada | `copy .env.example .env` |
| **API Key** | ❌ Tidak ada | Daftar di Google AI Studio |
| **Database** | ❌ Kosong | Create DB + migrate |
| **App Key** | ❌ Kosong | `php artisan key:generate` |

---

## ✅ **YANG SUDAH ADA DI GITHUB:**

✅ Semua kode chatbot  
✅ UI Cortex design  
✅ Export PDF feature  
✅ Documentation  
✅ Migrations  
✅ Config files  

---

## 🚨 **COMMON ERRORS:**

### **Error: "Maaf aku sedang sibuk"**
**Fix:**
1. Check `.env` → GEMINI_MODEL=`gemini-2.5-flash`
2. Run: `php artisan config:clear`
3. Restart server

### **Error: Database connection**
**Fix:**
1. Check MySQL running
2. Check `.env` → DB_PASSWORD=`` (empty)

### **Error: Class not found**
**Fix:**
```bash
composer dump-autoload
php artisan config:clear
```

---

## 📝 **CRITICAL: .env Configuration**

**File ini HARUS ada dan HARUS di-edit!**

```env
# WAJIB ISI:
GEMINI_API_KEY=your_actual_key_here
GEMINI_MODEL=gemini-2.5-flash
DB_DATABASE=sistem_bk

# Optional (default OK):
DB_USERNAME=root
DB_PASSWORD=
AI_COMPANION_ENABLED=true
```

---

## 🎯 **ONE-LINER SETUP:**

```bash
composer install && copy .env.example .env && php artisan key:generate && php artisan migrate && php artisan optimize:clear && php artisan serve
```

**Tapi tetap perlu:**
1. Edit `.env` → Add GEMINI_API_KEY
2. Create database `sistem_bk`

---

## 📞 **HELP:**

**Baca:** `SETUP_INSTRUCTIONS.md` untuk detail lengkap

**Stuck?** Check:
- [ ] Composer installed?
- [ ] MySQL running?
- [ ] .env edited?
- [ ] API key valid?
- [ ] Database created?

---

## ✨ **RESULT:**

Setelah setup berhasil:

✅ Website: `http://localhost:8000`  
✅ AI Chatbot: Working  
✅ Export PDF: Working  
✅ All features: Functional  

**Total time: 10-15 minutes**

---

**🎉 DONE! ENJOY!**
