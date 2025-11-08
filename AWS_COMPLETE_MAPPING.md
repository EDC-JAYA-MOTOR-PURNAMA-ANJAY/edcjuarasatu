# 🗺️ AWS SERVICES - COMPLETE MAPPING

**Setiap Halaman → AWS Services yang Digunakan**

---

## 📋 TABLE OF CONTENTS

1. [Login System](#login-system)
2. [Guru BK Pages](#guru-bk-pages)
3. [Siswa Pages](#siswa-pages)
4. [Admin Pages](#admin-pages)
5. [Background Jobs](#background-jobs)
6. [AWS Services Summary](#aws-services-summary)

---

## 🔐 LOGIN SYSTEM

### **Halaman: `/login`**

**Flow:**
```
User → educounsel.com/login
```

**AWS Services:**

1. **Route 53** (DNS)
   - Function: Resolve domain → ALB IP
   - Time: ~10ms

2. **Application Load Balancer** (ALB)
   - Function: Distribute traffic ke EC2 instances
   - Health check: Ping every 30s
   - Time: ~20ms

3. **EC2** (Compute)
   - Function: Run Laravel application
   - Process: AuthController@showLoginForm
   - Time: ~30ms

4. **RDS MySQL** (Database)
   - Function: Validate credentials
   - Query: `SELECT * FROM users WHERE email=?`
   - Time: ~50ms

5. **ElastiCache Redis** (Session)
   - Function: Store login session
   - Key: `laravel_session:abc123`
   - Time: ~5ms

**Total Time:** ~115ms

---

## 👨‍💼 GURU BK PAGES

### **1. Dashboard - `/guru_bk/dashboard`**

**AWS Services:**

| Service | Function | Time |
|---------|----------|------|
| EC2 | Run DashboardController | 30ms |
| Redis | Get cached stats | 1ms (HIT) |
| RDS | Query if cache miss | 100ms (MISS) |
| CloudWatch | Log page view | 5ms |

**Queries (if cache miss):**
```sql
SELECT COUNT(*) FROM users WHERE peran='siswa'
SELECT COUNT(*) FROM materi WHERE dibuat_oleh=:id
SELECT COUNT(*) FROM appointments WHERE guru_bk_id=:id
SELECT * FROM notifications WHERE user_id=:id LIMIT 5
```

---

### **2. Materi List - `/guru_bk/materi`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | MateriController@index | Controller logic |
| RDS | Query materi table | `SELECT * FROM materi WHERE dibuat_oleh=:id` |
| CloudFront | Load thumbnails | Cached at edge, 50ms |
| S3 | Source for thumbnails | If CloudFront miss |

**Display:**
- List materi yang dibuat guru
- Thumbnails via CloudFront (fast!)
- Actions: Edit, Delete, Toggle Status

---

### **3. Create Materi - `/guru_bk/materi/create`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | Show form | MateriController@create |
| RDS | Load dropdown data | Kategori, target kelas |

---

### **4. Upload Materi - `POST /guru_bk/materi`**

**AWS Services & Flow:**

```
1. [EC2] Receive POST request
        ↓
2. [EC2] Validate form data (StoreMateriRequest)
        ↓
3. [S3] Upload thumbnail:
   - Path: s3://educounsel/materi/thumbnails/
   - Size: 2MB
   - Time: 500ms
        ↓
4. [S3] Upload file (PDF):
   - Path: s3://educounsel/materi/files/
   - Size: 5MB
   - Time: 1500ms
        ↓
5. [RDS] Save metadata:
   - INSERT INTO materi (judul, konten, file_path, thumbnail, ...)
   - Time: 50ms
        ↓
6. [Redis] Queue notification job:
   - Job: SendMateriNotifications
   - Queue: notifications
   - Time: 5ms
        ↓
7. [EC2] Background worker:
   - Process queue
   - Send to 100 siswa
   - Time: 2000ms (async)
        ↓
8. [WebSocket] Push real-time:
   - Broadcast to all siswa browsers
   - Via Pusher/Laravel Echo
        ↓
9. [CloudFront] Invalidate cache:
   - Clear old cache
   - Next request → fresh from S3
```

**Total Time:** ~2.5 seconds (sync part)

---

### **5. Analytics - `/guru_bk/analytics`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | AnalyticsController | Generate charts |
| RDS | Heavy queries | Multiple JOINs, aggregations |
| Redis | Cache results | 10 min expiry |
| CloudWatch | Track metrics | Log analytics requests |

**Queries:**
```sql
SELECT DATE(created_at), COUNT(*) 
FROM chatbot_sessions 
WHERE guru_bk_id=:id 
GROUP BY DATE(created_at)

SELECT kategori, COUNT(*) 
FROM materi 
WHERE dibuat_oleh=:id 
GROUP BY kategori

SELECT status, COUNT(*) 
FROM appointments 
WHERE guru_bk_id=:id 
GROUP BY status
```

---

### **6. Appointments - `/guru_bk/appointments`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | AppointmentController | CRUD operations |
| RDS | Query appointments | JOINs with users table |

**Actions:**
- View appointments (list/calendar)
- Approve/reject requests
- Complete appointments
- Add notes

---

### **7. Chatbot Reports - `/guru_bk/chatbot-reports`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | ChatbotController | Generate reports |
| RDS | Query chatbot_sessions | Filter by date, student |
| Redis | Cache frequent queries | 5 min cache |

---

## 👨‍🎓 SISWA PAGES

### **1. Dashboard - `/student/dashboard`**

**AWS Services:**

| Service | Function | Time |
|---------|----------|------|
| EC2 | DashboardController | 30ms |
| RDS | Query materi, appointments | 80ms |

**Display:**
- Recent materi (3 items)
- Upcoming appointments
- Unread notifications

---

### **2. Materi List - `/student/materi`**

**AWS Services:**

```
[EC2] MateriController@studentIndex
        ↓
[RDS] Query: SELECT * FROM materi WHERE status='Aktif'
        ↓
Display cards with:
├─ Thumbnail → [CloudFront] → [S3] (cached, 50ms)
├─ Title, description
└─ [Baca] [Download] buttons
```

**Performance:**
- First load: 500ms (fetch from S3)
- Cached: 50ms (serve from CloudFront edge)

---

### **3. Read Materi - `/student/materi/{id}`**

**AWS Services & Flow:**

```
Click "Baca" button
        ↓
[EC2] MateriController@studentShow
        ↓
[RDS] Query materi + related materi
        ↓
Display page:
├─ Header info
├─ [CloudFront] Thumbnail (50ms)
└─ Tabs:
    ├─ [Baca Konten] → Text content
    └─ [Lihat File PDF] → PDF iframe

PDF Tab:
        ↓
<iframe src="CloudFront-URL/file.pdf">
        ↓
[CloudFront] Check edge cache:
├─ HIT → Serve (50ms) ✅
└─ MISS → [S3] Fetch (500ms) → Cache → Serve
        ↓
Browser renders PDF inline (800px height)
```

**Download Flow:**
```
Click "Download" button
        ↓
[CloudFront] Signed URL
        ↓
Download from edge location (nearest)
        ↓
Speed: 10x faster than direct S3
```

---

### **4. AI Chatbot - `/student/ai-companion`**

**AWS Services:**

```
GET /student/ai-companion
        ↓
[EC2] AiCompanionController@index
        ↓
[RDS] Load chat history (last 20 messages)
        ↓
Display chat interface

User sends message:
        ↓
POST /student/ai-companion/chat
        ↓
[EC2] Save message → [RDS]
        ↓
[Redis] Queue job: ProcessChatGPT
        ↓
[EC2] Worker:
├─ Fetch from queue
├─ Call OpenAI API (external)
├─ Parse response
└─ Save → [RDS]
        ↓
[WebSocket] Push response to browser (real-time)
        ↓
Browser displays AI response with typing animation
```

**Timing:**
- Save user message: 50ms
- Queue job: 5ms
- OpenAI API call: 2-5 seconds
- Real-time push: 50ms

---

### **5. Appointments - `/student/appointments`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | AppointmentController | CRUD logic |
| RDS | Query/Save appointments | student_id foreign key |
| Redis | Queue notifications | Notify Guru BK |

**Flow:**
```
Create Appointment:
        ↓
[RDS] Check available slots
        ↓
[RDS] INSERT INTO appointments
        ↓
[Redis] Queue: NotifyGuruBK
        ↓
[EC2] Worker → Send notification
```

---

### **6. Profile - `/student/profile`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | ProfileController | Display/update |
| RDS | Query users table | Get current data |
| S3 | Upload profile photo | Optional |

---

### **7. Notifications - `/student/notifications`**

**AWS Services:**

```
Real-time notifications (when guru upload materi):
        ↓
[Redis] Queue job from MateriCreated event
        ↓
[EC2] Worker processes:
├─ [RDS] Get all siswa (100 users)
├─ Loop: INSERT INTO notifications
└─ [WebSocket] Broadcast(new MateriUploaded)
        ↓
[Browser] Siswa receives:
├─ Toast notification (top-right)
├─ Sound alert
└─ Badge count update

View all notifications:
        ↓
GET /student/notifications
        ↓
[EC2] NotificationController@index
        ↓
[RDS] Query: SELECT * FROM notifications WHERE user_id=:id
        ↓
Display list (paginated)
```

---

## 👨‍💻 ADMIN PAGES

### **1. Dashboard - `/admin/dashboard`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | AdminController | Process request |
| RDS | Aggregate queries | COUNT users, materi, etc |
| Redis | Cache dashboard | 5 min TTL |
| CloudWatch | Fetch metrics | Server health |

---

### **2. User Management - `/admin/users`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | UserController | CRUD operations |
| RDS | Users table | All operations |

**Operations:**
- List users (filter by role)
- Create new user
- Edit user details
- Delete user
- Reset password

---

### **3. Kelas Management - `/admin/kelas`**

**AWS Services:**

| Service | Function | Details |
|---------|----------|---------|
| EC2 | KelasController | CRUD logic |
| RDS | Kelas table | Foreign key to users |

---

### **4. System Logs - `/admin/logs`**

**AWS Services:**

```
GET /admin/logs
        ↓
[EC2] LogController
        ↓
[CloudWatch Logs] Query logs:
├─ Application logs (Laravel)
├─ Error logs
├─ Access logs (Nginx)
└─ Database slow queries
        ↓
Display with filters:
├─ Date range
├─ Log level (INFO, ERROR, WARNING)
└─ Search keyword
```

---

### **5. Monitoring - `/admin/monitoring`**

**AWS Services:**

```
GET /admin/monitoring
        ↓
[EC2] MonitoringController
        ↓
[CloudWatch] Fetch metrics:
├─ EC2 CPU utilization
├─ EC2 Memory usage
├─ RDS connections
├─ RDS CPU
├─ S3 storage used
├─ Request count/min
├─ Error rate
└─ Response time (P50, P95, P99)
        ↓
Display charts (real-time)
```

---

## ⚙️ BACKGROUND JOBS

### **Job 1: SendMateriNotifications**

```
Trigger: Guru upload materi
        ↓
[Redis] Queue job with materi_id
        ↓
[EC2] Worker picks up job:
├─ [RDS] Get materi details
├─ [RDS] Get all siswa (100 users)
├─ Loop each siswa:
│   ├─ [RDS] INSERT INTO notifications
│   └─ [WebSocket] Broadcast to browser
└─ Mark job complete
        ↓
[CloudWatch] Log job completion
```

**Time:** ~2-3 seconds for 100 siswa

---

### **Job 2: ProcessChatGPT**

```
Trigger: Siswa send chat message
        ↓
[Redis] Queue job with message
        ↓
[EC2] Worker:
├─ Call OpenAI API (external, 2-5s)
├─ Parse response
├─ [RDS] Save AI response
└─ [WebSocket] Push to browser
        ↓
[CloudWatch] Log API call + latency
```

---

### **Job 3: SendAppointmentReminders**

```
Cron: Daily at 8:00 AM
        ↓
[EC2] Scheduler triggers job
        ↓
[RDS] Query appointments for next 24 hours
        ↓
Loop each appointment:
├─ [Redis] Queue: SendReminderEmail
└─ [SNS] Send SMS (optional)
        ↓
[EC2] Worker sends emails
```

---

## 📊 AWS SERVICES SUMMARY

### **Complete Usage Map:**

| AWS Service | Used By | Primary Function |
|-------------|---------|------------------|
| **Route 53** | All users | DNS resolution |
| **ALB** | All users | Load balancing, SSL termination |
| **EC2** | All pages | Run Laravel application |
| **RDS MySQL** | All pages | Store all data |
| **S3** | Materi | Store files & thumbnails |
| **CloudFront** | Materi | Fast file delivery (CDN) |
| **ElastiCache Redis** | Auth, Cache, Queue | Sessions, cache, background jobs |
| **CloudWatch** | Admin, Monitoring | Logs, metrics, alerts |
| **SNS** | Notifications | Email/SMS alerts |
| **ACM** | All HTTPS | Free SSL certificates |
| **Auto Scaling** | High traffic | Add/remove EC2 instances |

---

### **Traffic Flow Summary:**

```
EVERY REQUEST GOES THROUGH:

User Browser
      ↓
[Route 53] DNS Lookup (10ms)
      ↓
[CloudFront] CDN (if static assets) (50ms)
      ↓
[ALB] Load Balancer (20ms)
      ↓
[EC2] Laravel App (30-100ms)
      ↓
[RDS] Database queries (50-200ms)
      ↓
[Redis] Cache/Session (1-5ms)
      ↓
Response back to user

Total: 150-400ms average
```

---

### **Data Storage:**

| Data Type | Storage | Backup |
|-----------|---------|--------|
| **User data** | RDS MySQL | Daily snapshot |
| **Materi files** | S3 | Versioning enabled |
| **Thumbnails** | S3 | Versioning enabled |
| **Sessions** | Redis | Memory only |
| **Cache** | Redis | Memory only |
| **Logs** | CloudWatch | 7 days retention |

---

### **Cost Breakdown by Feature:**

| Feature | Primary AWS Cost | Monthly Est. |
|---------|------------------|--------------|
| **File Storage** | S3 + CloudFront | $15 |
| **Compute** | EC2 instances | $60 |
| **Database** | RDS Multi-AZ | $30 |
| **Cache** | ElastiCache Redis | $12 |
| **Load Balancer** | ALB | $25 |
| **Monitoring** | CloudWatch | $8 |
| **DNS** | Route 53 | $1 |
| **TOTAL** | | **~$151/month** |

---

## 🎯 PERFORMANCE OPTIMIZATION

### **Caching Strategy:**

```
Level 1: CloudFront (Edge Cache)
├─ Static assets: 7 days
├─ Thumbnails: 30 days
└─ PDF files: 7 days

Level 2: Redis (Application Cache)
├─ Dashboard stats: 5 min
├─ Analytics data: 10 min
├─ Materi list: 3 min
└─ User sessions: 2 hours

Level 3: RDS (Database)
├─ Query cache enabled
└─ Slow query log monitoring
```

---

### **Scaling Strategy:**

```
Normal Load (50-100 users):
├─ 2 EC2 instances (t3.medium)
├─ ALB distributes 50/50
└─ CPU: 30-40%

High Load (500+ users):
├─ Auto Scaling triggers at CPU > 70%
├─ Launch 3 more EC2 instances
├─ ALB distributes traffic across 5 instances
└─ CPU back to 30-40%

After traffic drops:
├─ Auto Scaling detects CPU < 30%
├─ Terminate extra instances
└─ Back to 2 instances (save cost)
```

---

**Last Updated:** 7 November 2025  
**Version:** 1.0 Complete  
**Status:** Production-Ready Documentation ✅
