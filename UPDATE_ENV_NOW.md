# ⚡ UPDATE FILE .ENV - COPY PASTE INI!

## 🎯 **LANGKAH MUDAH (2 MENIT):**

---

## **STEP 1: BUKA FILE .ENV**

**Di VS Code:**
1. Tekan `Ctrl + P`
2. Ketik: `.env`
3. Tekan Enter

**ATAU**

Buka file manual:
```
c:\xampp\htdocs\edcjuarasatu\.env
```

---

## **STEP 2: CARI SECTION AI COMPANION**

Scroll ke bawah, cari bagian yang mirip ini:

```env
# AI Companion Configuration
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
```

---

## **STEP 3: COPY-PASTE INI (GANTI SEMUA):**

**HAPUS bagian lama, GANTI dengan ini:**

```env
# ==========================================
# AI Companion Configuration
# ==========================================
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
GEMINI_MODEL=gemini-2.5-flash
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

**ATAU jika belum ada sama sekali, tambahkan di paling bawah file .env**

---

## **STEP 4: SAVE FILE**

**TEKAN: Ctrl + S**

⚠️ **PASTIKAN FILE SAVED!** (tidak ada tanda `●` di tab)

---

## **STEP 5: CLEAR CACHE**

**Buka terminal, jalankan:**

```bash
php artisan config:clear
php artisan cache:clear
```

---

## **STEP 6: VERIFY**

**Jalankan command ini:**

```bash
php artisan tinker --execute="echo 'Model: ' . config('ai.gemini.model');"
```

**HARUS MUNCUL:**
```
Model: gemini-2.5-flash
```

✅ **Jika sudah gemini-2.5-flash, BENAR!**
❌ **Jika masih gemini-1.5-flash, ulangi dari STEP 1**

---

## **STEP 7: RESTART SERVER**

**Stop server** (Ctrl + C di terminal yang running)

**Start ulang:**
```bash
php artisan serve
```

---

## **STEP 8: HARD REFRESH BROWSER**

Di browser, tekan:
- **Ctrl + Shift + R** (Chrome/Edge)
- **Ctrl + F5** (Firefox)

---

## **STEP 9: TEST CHAT!**

Buka: `http://localhost:8000/student/ai-companion`

Ketik:
```
Halo, test koneksi
```

**AI seharusnya merespon dengan benar sekarang!** ✅

---

## 🎉 **DONE!**

Chatbot akan bekerja normal dengan response 2-5 detik!

---

## 🆘 **JIKA MASIH ERROR:**

1. Screenshot file .env bagian AI Configuration
2. Screenshot output command verify
3. Screenshot error di chatbot

Kirim ke saya!

---

**File contoh ada di:** `.env.ai.fixed`

**Copy isi file itu ke .env Anda!**
