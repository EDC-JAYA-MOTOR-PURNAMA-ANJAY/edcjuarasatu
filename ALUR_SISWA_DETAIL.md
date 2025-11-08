# 👨‍🎓 ALUR SISWA - DETAIL LENGKAP + AWS

## 🔐 1. LOGIN

```
educounsel.com → [Route 53] → [ALB] → [EC2]
                   10ms        20ms     30ms
                             ↓
                        [RDS] Query
                          50ms
                             ↓
                    ✅ Login Success
                    Total: 110ms
```

---

## 📖 2. BACA MATERI (LENGKAP)

### **List Materi**

```
GET /student/materi
    ↓
[EC2] Controller → [RDS] Query materi
    ↓
Display 12 cards dengan thumbnail [CloudFront]
Time: 200ms
```

### **Read Detail + PDF Inline**

```
Click "Baca" → /student/materi/123
    ↓
[EC2] Show detail
    ↓
Tabs: [Baca Konten] [Lihat PDF]
    ↓
PDF tab → [CloudFront] Load PDF
    ↓
Inline viewer (800px) - 50ms cached!
    ↓
[Download] button → CloudFront serve
```

**AWS Services:**
- EC2 (Controller)
- RDS (Query)
- S3 (Source files)
- CloudFront (CDN - 10x faster!)

---

## 🤖 3. AI CHATBOT

```
/student/ai-companion
    ↓
Send message → [EC2] Save → [RDS]
    ↓
Background: Call OpenAI API (2-5s)
    ↓
[WebSocket] Push response real-time
    ↓
Browser displays with typing animation
```

**Time:** ~3 seconds total

---

## 📅 4. APPOINTMENTS

```
/student/appointments/create
    ↓
[RDS] Get available Guru BK & slots
    ↓
Submit form → [EC2] Validate
    ↓
[RDS] INSERT appointment
    ↓
Notify Guru BK (background)
```

---

## 🔔 5. NOTIFICATIONS

```
Guru upload materi
    ↓
[EC2] Worker → Insert 100 notifications
    ↓
[WebSocket] Broadcast to browsers
    ↓
Siswa sees: Toast + Sound + Badge
Time: < 1 second! ⚡
```

---

## ⚙️ SISWA AWS USAGE

**Per Day:**
- Login: 3x
- Baca materi: 10x  
- AI Chat: 5 messages
- Notifications: 2 received

**Monthly Cost:** $0 (FREE tier!) ✅

---

**Status:** Complete ✅
