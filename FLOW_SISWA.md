# 👨‍🎓 ALUR SISWA - AWS MAPPING

## 1️⃣ LOGIN

```
educounsel.com → [Route 53] → [ALB] → [EC2] Laravel
                                        ↓
                            [RDS] Check users table
                                        ↓
                            [Redis] Store session
                                        ↓
                         Redirect /student/dashboard
```

**AWS:** Route 53, ALB, EC2, RDS, Redis

---

## 2️⃣ DASHBOARD

```
GET /student/dashboard
        ↓
[EC2] DashboardController
        ↓
[RDS] Query:
├─ Recent materi (LIMIT 3)
├─ Appointments (upcoming)
└─ Notifications (unread)
        ↓
Display dashboard widgets
```

**AWS:** EC2, RDS

---

## 3️⃣ BACA MATERI

```
GET /student/materi
        ↓
[EC2] MateriController@studentIndex
        ↓
[RDS] Query materi WHERE status='Aktif'
        ↓
Display cards:
├─ Thumbnail → [CloudFront] → [S3] (cached, 50ms)
└─ Buttons: [Baca] [Download]

Click "Baca" → /student/materi/123
        ↓
[EC2] MateriController@studentShow
        ↓
[RDS] Get materi details
        ↓
Display tabs:
├─ [Baca Konten] → Text content
└─ [Lihat File PDF] → [CloudFront] → [S3] PDF (inline viewer)

Click "Download"
        ↓
[CloudFront] Serve from edge → 10x faster
```

**AWS:** EC2, RDS, S3, CloudFront

---

## 4️⃣ AI CHATBOT

```
GET /student/ai-companion
        ↓
[EC2] AiCompanionController
        ↓
[RDS] Load chat history
        ↓
Display chat interface

User send message:
POST /student/ai-companion/chat
        ↓
[EC2] Save message → [RDS]
        ↓
[Redis] Queue job: ProcessChatbot
        ↓
[EC2] Worker → Call OpenAI API
        ↓
[RDS] Save AI response
        ↓
[WebSocket] Push response to browser (real-time)
```

**AWS:** EC2, RDS, Redis

---

## 5️⃣ BOOKING APPOINTMENT

```
GET /student/appointments/create
        ↓
[EC2] AppointmentController
        ↓
[RDS] Get available Guru BK & time slots
        ↓
Display booking form

POST /student/appointments/store
        ↓
[EC2] Validate & save
        ↓
[RDS] INSERT INTO appointments
        ↓
[Redis] Queue: SendAppointmentNotification
        ↓
[EC2] Worker → Notify Guru BK
```

**AWS:** EC2, RDS, Redis

---

## 6️⃣ RECEIVE NOTIFICATIONS

```
Guru upload materi:
        ↓
[Redis] Queue job
        ↓
[EC2] Worker process:
├─ [RDS] Get all siswa
├─ Loop: Create notifications
└─ [WebSocket] Broadcast to browser
        ↓
[Browser] Siswa sees:
├─ Toast notification ✅
├─ Sound alert 🔔
└─ Badge count update
```

**AWS:** EC2, RDS, Redis, WebSocket (Pusher)

---

## 📊 SISWA AWS USAGE

| Fitur | EC2 | RDS | S3 | Redis | CloudFront |
|-------|-----|-----|----|----|------------|
| Login | ✅ | ✅ | - | ✅ | - |
| Dashboard | ✅ | ✅ | - | - | - |
| Baca Materi | ✅ | ✅ | ✅ | - | ✅ |
| Download PDF | - | - | ✅ | - | ✅ |
| AI Chatbot | ✅ | ✅ | - | ✅ | - |
| Appointments | ✅ | ✅ | - | ✅ | - |
| Notifications | ✅ | ✅ | - | ✅ | - |
