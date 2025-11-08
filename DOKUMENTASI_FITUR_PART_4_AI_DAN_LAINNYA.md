# 📋 DOKUMENTASI FITUR - PART 4: AI CHATBOT & LAINNYA

**Project:** EDUCOUNSEL  
**File:** Part 4 dari 4 (FINAL)

---

# 1. AI CHATBOT "SAHABAT AI" 🤖

**Fungsi:** AI Mental Health Companion untuk konseling 24/7.

**Powered by:** Google Gemini 2.5 Flash API (GRATIS)

## UI Components

**Sidebar (Kiri):**
- Logo & "New Chat" button
- Search box
- Recent chats (5 terakhir dengan preview)

**Main Area (Tengah):**
- Header (Export chat, Stats button)
- Central glowing logo (saat belum ada chat)
- Welcome text: "Hello, [Nama Siswa]"
- Saved prompt cards (3 cards):
  - "💡 Curhat tentang stress"
  - "🎯 Tips menghadapi ujian"
  - "😊 Sharing perasaan hari ini"
- Chat messages area
- Input box + Send button
- "Deeper Research" toggle

---

## Alur Kerja Chat

```
1. Siswa login → Klik menu "Sahabat AI"
   ↓
2. Load halaman /student/ai-companion
   ↓
3. Tampil welcome screen dengan:
   - Logo animasi
   - Greeting: "Hello, [Nama]!"
   - Text: "How can I assist you today?"
   - 3 saved prompt cards
   ↓
4. Load chat history dari database (jika ada)
   ↓
5. Siswa ketik pesan: "Aku lagi stress dengan ujian besok"
   ↓
6. Klik Send (atau Enter)
   ↓
7. Frontend process:
   - Disable input (prevent spam)
   - Tampilkan user message (bubble kiri, gray)
   - Tampilkan typing indicator "..."
   ↓
8. AJAX POST ke /student/ai-companion/chat
   Body: { message: "Aku lagi stress..." }
   ↓
9. Backend process (AiCompanionController):
   a. Rate limit check (max 10 chat/menit)
   b. Get conversation history (2 jam terakhir)
   c. Build context untuk AI
   d. Call Gemini API dengan:
      - System prompt (fokus mental health)
      - User message
      - Conversation history
   ↓
10. Gemini AI process:
    - Analyze sentiment (positive/neutral/negative)
    - Detect crisis keywords (bunuh diri, self-harm)
    - Generate empathetic response
    - Return response + metadata
   ↓
11. Backend save ke database:
    - User message (role: user)
    - AI response (role: assistant)
    - Sentiment data
    - Crisis flag (true/false)
   ↓
12. Return JSON:
    {
      success: true,
      user_message: {...},
      ai_message: {
        message: "Aku mengerti kamu lagi tertekan...",
        created_at: "10:30"
      },
      is_crisis: false,
      voice_message: null
    }
   ↓
13. Frontend render:
    - Remove typing indicator
    - Tampilkan AI response (bubble kanan, purple)
    - Enable input kembali
    - Update sidebar (tambah preview chat)
   ↓
14. Jika is_crisis = true:
    - Tampil notification banner (atas):
      "⚠️ Sepertinya kamu sedang mengalami masa sulit.
       Kami sangat recommend untuk bicara dengan Guru BK."
    - Voice notification (TTS urgent)
    - Tombol "Hubungi Guru BK"
   ↓
15. User bisa lanjut chat atau action lain
```

---

## Crisis Detection System

**Fungsi:** Deteksi otomatis jika siswa dalam kondisi krisis.

**Keywords:** (dari config/ai.php)
- "bunuh diri", "suicide"
- "mati aja", "ingin mati"
- "self harm", "menyakiti diri"
- "potong urat"
- "gak ada harapan"
- "kekerasan", "abuse"
- dll

**Alur Deteksi:**
```
User message: "Aku pengen bunuh diri" →
Backend check keywords →
Match found → Set is_crisis = true →
AI generate response serius & supportive →
Save with crisis flag →
Log crisis event (storage/logs/) →
Notify Guru BK (email/WhatsApp) →
Return response dengan warning banner →
Frontend tampil alert + recommended action
```

**Action Otomatis:**
- Auto-create konseling urgent
- Email ke Guru BK
- Log untuk admin review

---

## Non-Konseling Rejection

**Jika siswa tanya di luar mental health:**

Input: "Berapa hasil 2+2?"

AI Response:
```
"Aku di sini sebagai Sahabat AI untuk mental health support, 
bukan untuk bantuan pelajaran. Aku lebih fokus mendengarkan 
curhat kamu tentang perasaan, stress, atau masalah yang kamu 
hadapi. Ada yang pengen kamu ceritain? 😊"
```

**System Prompt:**
- Diconfig di `config/ai.php`
- Instruksi tegas: HANYA mental health
- Redirect gentle ke topik konseling

---

## Sub-Fitur AI Chatbot

### 1.2 Export Chat to PDF

**Fungsi:** Download percakapan dalam format PDF.

**Alur:**
```
Click "Export chat" button →
Frontend send GET /student/ai-companion/export-pdf →
Backend:
  - Query all conversations user ini
  - Generate PDF dengan DomPDF
  - Format: A4 portrait
  - Header: Logo, nama siswa, tanggal export
  - Content: Semua messages dengan timestamp
  - Footer: Total messages
→ Return PDF file →
Browser download: 
  "Chat_Sahabat_AI_[Nama]_2025-11-06.pdf"
```

### 1.3 New Chat

**Fungsi:** Clear chat & mulai percakapan baru.

**Alur:**
```
Click "New chat" →
Confirm dialog: "Mulai chat baru? (history tetap tersimpan)" →
User confirm →
AJAX POST /student/ai-companion/clear →
Backend: (tidak delete, hanya frontend clear) →
Success →
Frontend:
  - Clear chat area
  - Tampil welcome screen lagi
  - Input focus
```

### 1.4 Chat Statistics

**Fungsi:** Lihat statistik penggunaan AI.

**Data:**
- Total messages (all time)
- Messages today
- Messages this week
- Messages this month
- Sentiment breakdown (positive/neutral/negative %)

**Alur:**
```
Click "Stats" button →
Modal muncul →
AJAX GET /student/ai-companion/stats →
Backend calculate dari database →
Return JSON →
Frontend render dalam modal dengan charts
```

### 1.5 Deeper Research Mode

**Fungsi:** Toggle untuk response lebih detail dengan referensi.

**Normal Mode:**
- Response singkat & to the point
- Fokus empati & validasi

**Research Mode:**
- Response lebih panjang
- Include data/penelitian
- Referensi artikel psikologi
- Teknik coping yang evidence-based

**Technical:**
- Toggle button di UI
- Frontend set flag `research_mode: true`
- Backend adjust Gemini parameters:
  - max_tokens: 1000 → 2000
  - temperature: 0.7 → 0.5 (lebih factual)

---

## Rate Limiting

**Fungsi:** Prevent spam & abuse.

**Limits:**
- 10 messages per minute
- 100 messages per hour

**Alur:**
```
User send message →
Backend check rate limit:
  - Count messages last 1 minute
  - If > 10: reject
→ Return 429 error:
  "Kamu terlalu banyak chat. Istirahat dulu ya! 😊"
→ Frontend tampil error message
→ Disable input selama 30 detik
```

---

# 2. VOICE NOTIFICATION SYSTEM (TTS) 🔊

**Fungsi:** Text-to-Speech untuk notifikasi suara.

**Technology:** Web Speech API (browser native, 100% gratis)

## Voice Settings

```javascript
rate: 0.88      // Energetic speed
pitch: 1.15     // Cheerful female tone
volume: 1.0     // Maximum
lang: 'id-ID'   // Indonesian
voice: 'Microsoft Gadis' / 'Damayanti' / 'Google TTS'
```

## Implementasi di Halaman

### 2.1 Login Page Voice

**Trigger:**
- Wrong email: "Email yang kamu masukkan salah"
- Wrong password: "Password salah, coba lagi"
- Throttle (5x failed): "Kamu sudah 5x salah password. Tunggu 30 detik ya"
  (dengan countdown voice)

### 2.2 Dashboard Welcome Voice

**Trigger:** Setelah login berhasil

**Text:** "Selamat datang kembali, [Nama Siswa]! Semangat belajar hari ini!"

### 2.3 Absensi Voice

**Success:** "Absensi berhasil! Selamat belajar, [Nama]!"

**Late:** "Kamu terlambat hari ini. Besok usahakan tepat waktu ya!"

### 2.4 Crisis Detection Voice

**Text:** "Sepertinya kamu sedang mengalami masa sulit. Kami sangat recommend untuk bicara dengan Guru BK atau orang yang kamu percaya."

**Tone:** Serious, caring

---

## Technical Implementation

```javascript
function speak(text) {
  if ('speechSynthesis' in window) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.rate = 0.88;
    utterance.pitch = 1.15;
    utterance.volume = 1.0;
    utterance.lang = 'id-ID';
    
    // Prioritas voice female Indonesia
    const voices = speechSynthesis.getVoices();
    const femaleVoice = voices.find(v => 
      v.name.includes('Gadis') || 
      v.name.includes('Damayanti') ||
      v.lang === 'id-ID' && v.name.includes('Female')
    );
    if (femaleVoice) utterance.voice = femaleVoice;
    
    speechSynthesis.speak(utterance);
  }
}
```

---

# 3. AUTHENTICATION & SECURITY 🔐

## 3.1 Login System

**Route:** `/login`

**Features:**
- Email & password authentication
- "Remember me" checkbox
- "Forgot password" link
- Rate limiting (security)

**Alur:**
```
1. User buka /login
   ↓
2. Input email & password
   ↓
3. Submit form
   ↓
4. Backend validate:
   - Check email exists
   - Verify password (bcrypt)
   ↓
5. Jika gagal:
   - Increment failed_attempts (session)
   - If attempts >= 5:
     * Block login 30 seconds
     * Voice: countdown warning
   - Return error dengan voice
   ↓
6. Jika berhasil:
   - Regenerate session ID (security)
   - Set auth session
   - Reset failed_attempts
   - Log login activity
   ↓
7. Redirect based on role:
   - Admin → /admin/dashboard
   - Guru BK → /guru_bk/dashboard
   - Siswa → /student/dashboard
   ↓
8. Welcome voice notification
```

**Security Features:**
- Rate limiting: Max 5 attempts, 30s block
- CSRF protection
- Session regeneration
- Password hashing (bcrypt rounds: 12)
- Activity logging

---

## 3.2 Logout

**Alur:**
```
Click "Logout" →
Confirm (optional) →
POST /logout →
Backend:
  - Destroy session
  - Clear auth cookies
  - Log logout activity
→ Redirect to landing page →
Success message: "Kamu berhasil logout"
```

---

## 3.3 Middleware & Authorization

**Middleware:**

1. **`auth`** - Cek user sudah login
2. **`role:admin`** - Hanya admin
3. **`role:guru_bk`** - Hanya Guru BK
4. **`role:siswa`** - Hanya Siswa

**Contoh Route:**
```php
Route::middleware(['auth', 'role:siswa'])
    ->group(function() {
        Route::get('/student/dashboard', ...);
    });
```

**Unauthorized Access:**
```
User belum login → Akses /student/dashboard →
Middleware detect no auth →
Redirect to /login with message:
  "Silakan login terlebih dahulu"
```

---

# 4. LANDING PAGE 🌐

**Fungsi:** Homepage untuk public (belum login).

**Route:** `/` (root)

**Sections:**

## 4.1 Hero Section
- Headline: "Sistem Bimbingan Konseling Modern"
- Subheadline: "Platform digital untuk mental health support siswa"
- CTA Button: "Login" & "Daftar"
- Hero image / illustration

## 4.2 Features Section
- 3-4 cards highlight fitur utama:
  - 🤖 AI Chatbot 24/7
  - 📊 Monitoring Akademik
  - 👥 Konseling Professional
  - 📱 Mobile Friendly

## 4.3 About Section
- Tentang sistem
- Manfaat untuk siswa
- Manfaat untuk sekolah

## 4.4 Contact Section
- Alamat sekolah
- Email & telepon
- Social media links
- Google Maps embed

**Routes:**
- `/features` - Detail fitur
- `/about` - Tentang kami
- `/contact` - Kontak

---

# 5. NOTIFICATION SYSTEM 🔔

**Fungsi:** Real-time notifications untuk user.

**Jenis Notifikasi:**

## 5.1 Email Notifications
- Jadwal konseling baru
- Reminder konseling besok
- Hasil konseling tersedia
- Kuesioner baru

## 5.2 In-App Notifications
- Badge di navbar (jumlah notif unread)
- Dropdown list notifikasi
- Mark as read
- Clear all

## 5.3 Push Notifications (Future)
- Browser push (service worker)
- Mobile app push

---

# 6. FITUR TAMBAHAN

## 6.1 Search Global
- Search box di navbar
- Search across: siswa, konseling, kuesioner
- Fuzzy search (typo-tolerant)

## 6.2 Dark Mode (Future)
- Toggle light/dark theme
- Save preference

## 6.3 Multi-language (Future)
- Indonesia (default)
- English

## 6.4 Export/Import Data
- Admin: Export semua data (backup)
- Import data siswa dari Excel

---

# TECHNICAL STACK SUMMARY

**Backend:**
- Laravel 12 (PHP 8.2+)
- MySQL Database
- Gemini AI API

**Frontend:**
- Blade Templates
- Tailwind CSS
- Alpine.js
- Chart.js
- SweetAlert2

**APIs:**
- Google Gemini 2.5 Flash (AI)
- Web Speech API (TTS)

**Security:**
- CSRF Protection
- Rate Limiting
- Password Hashing (bcrypt)
- Role-based Access Control

**Deployment:**
- XAMPP (Local)
- Apache Web Server
- PHP-FPM

---

# TOTAL FITUR PROJECT

**Admin:** 5 fitur utama
**Guru BK:** 6 fitur utama
**Siswa:** 7 fitur + AI Chatbot
**Umum:** Authentication, Landing Page, Voice System

**GRAND TOTAL:** 20+ Fitur Utama dengan 50+ Sub-fitur

---

**🎉 END OF DOCUMENTATION - SEMUA FITUR LENGKAP! 🎉**

**Files:**
- Part 1: Admin (5 fitur)
- Part 2: Guru BK (6 fitur)
- Part 3: Siswa (7 fitur)
- Part 4: AI Chatbot & Lainnya (8+ fitur)

**Semua fitur sudah dijelaskan dengan:**
✅ Fungsi fitur
✅ Alur kerja detail
✅ Komponen & UI
✅ Technical implementation
✅ Database queries
✅ Routes & controllers

---

**🚀 EDUCOUNSEL - Production Ready!**
