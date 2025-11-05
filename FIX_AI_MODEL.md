# 🔧 FIX AI MODEL - QUICK GUIDE

## ❌ MASALAH:
Chatbot merespon: "Maaf saya sedang sibuk"

## ✅ PENYEBAB:
Model `gemini-1.5-flash` TIDAK SUPPORTED!

## ✅ SOLUSI:
Update ke `gemini-2.5-flash`

---

## 📝 LANGKAH-LANGKAH:

### **1. Buka File .env**

File `.env` ada di root folder project:
```
c:\xampp\htdocs\edcjuarasatu\.env
```

**Di VS Code:**
- Tekan `Ctrl + P`
- Ketik: `.env`
- Enter

### **2. Cari Section AI Configuration**

Scroll sampai ketemu:
```env
# AI Companion Configuration
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
```

### **3. Cari atau Tambah Baris GEMINI_MODEL**

**Jika sudah ada baris `GEMINI_MODEL`:**
```env
GEMINI_MODEL=gemini-1.5-flash  ← GANTI INI!
```

**GANTI menjadi:**
```env
GEMINI_MODEL=gemini-2.5-flash  ← YANG BENAR!
```

**Jika BELUM ada baris `GEMINI_MODEL`:**

Tambahkan dibawah `AI_COMPANION_ENABLED`:
```env
# AI Companion Configuration
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
GEMINI_MODEL=gemini-2.5-flash  ← TAMBAHKAN INI!
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

### **4. Save File**

**Tekan: Ctrl + S**

**Pastikan tab tidak ada tanda `●` (unsaved)**

### **5. Clear Cache**

Buka terminal dan jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### **6. Refresh Browser**

Di halaman chatbot, tekan **F5** atau **Ctrl + F5**

### **7. Test Chat!**

Ketik pesan lagi:
```
Halo, test koneksi
```

**Seharusnya AI akan merespon dengan benar!** ✅

---

## 🔍 VERIFY CONFIG

Cek apakah sudah benar:

```bash
php artisan tinker --execute="echo 'Model: ' . config('ai.gemini.model');"
```

**Harus muncul:**
```
Model: gemini-2.5-flash
```

**Jika masih `gemini-1.5-flash`, berarti:**
- File .env belum di-save
- Cache belum clear
- Restart server diperlukan

---

## 🆘 TROUBLESHOOTING

### Problem: Config masih gemini-1.5-flash

**Solution:**
1. Double-check file .env sudah save
2. Clear cache lagi:
   ```bash
   php artisan optimize:clear
   ```
3. Restart server:
   - Stop server (Ctrl + C)
   - Start lagi: `php artisan serve`

### Problem: Masih "sedang sibuk"

**Solution:**
1. Check .env model: `gemini-2.5-flash` ✅
2. Check API key valid
3. Check internet connection
4. Check Laravel log: `storage/logs/laravel.log`

---

## ✅ FINAL .ENV EXAMPLE

File `.env` Anda harus seperti ini:

```env
APP_NAME=Educounsel
APP_ENV=local
# ... (config lain) ...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_bk
DB_USERNAME=root
DB_PASSWORD=

# ... (config lain) ...

# ==========================================
# AI Companion Configuration
# ==========================================
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
GEMINI_MODEL=gemini-2.5-flash
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

**Yang PENTING:**
- `GEMINI_MODEL=gemini-2.5-flash` (BUKAN 1.5!)
- No quotes, no spaces

---

## 🎉 DONE!

Setelah update, chatbot akan merespon dengan benar!

**Happy chatting!** 🤖✨
