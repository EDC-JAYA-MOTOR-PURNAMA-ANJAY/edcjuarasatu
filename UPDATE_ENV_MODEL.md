# UPDATE .env FILE - IMPORTANT!

## Buka file `.env` dan UPDATE baris ini:

**CARI:**
```
GEMINI_MODEL=gemini-1.5-flash
```

**GANTI DENGAN:**
```
GEMINI_MODEL=gemini-2.5-flash
```

**ATAU HAPUS BARIS ITU** (biarkan pakai default dari config)

---

## Setelah itu, run:
```bash
php artisan config:clear
```

## File `.env` Anda harus seperti ini:

```env
# AI Companion Configuration
GEMINI_API_KEY=AIzaSyCwtAVPzPrbnDHrNTa54b9JGZ5hlKhmJDM
AI_COMPANION_ENABLED=true
GEMINI_MODEL=gemini-2.5-flash
AI_MAX_TOKENS=1000
AI_TEMPERATURE=0.7
```

**Model yang SUPPORTED:** `gemini-2.5-flash`
