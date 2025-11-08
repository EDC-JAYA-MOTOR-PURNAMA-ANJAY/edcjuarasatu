# ⚡ AWS QUICK REFERENCE CARD

**EduCounsel System - Cloud Infrastructure**

---

## 📋 11 AWS SERVICES RINGKASAN

| # | Service | Fungsi | Analogi | Biaya/bulan |
|---|---------|--------|---------|-------------|
| 1 | **EC2** | Server aplikasi | Komputer virtual | $60 |
| 2 | **RDS** | Database MySQL | MySQL terkelola | $30 |
| 3 | **S3** | File storage | Google Drive unlimited | $3 |
| 4 | **Redis** | Cache & Queue | RAM untuk website | $12 |
| 5 | **ALB** | Load Balancer | Traffic distributor | $25 |
| 6 | **Route 53** | DNS | Penerjemah domain | $1 |
| 7 | **CloudFront** | CDN | Cache global | $12 |
| 8 | **ACM** | SSL Certificate | HTTPS gratis | $0 |
| 9 | **CloudWatch** | Monitoring | Sistem alarm | $8 |
| 10 | **Auto Scaling** | Auto scale | Tambah server otomatis | $0 |
| 11 | **SNS** | Notifications | Email/SMS alert | $1 |

**TOTAL:** ~$152/month (Production) atau ~$32/month (Development)

---

## 🎯 CORE 6 (WAJIB)

### 1. EC2 - Virtual Server
```
Spek: t3.medium (2 CPU, 4GB RAM) x 2
OS: Ubuntu 22.04
Role: Hosting Laravel + Nginx + PHP-FPM
```

### 2. RDS - Database
```
Spek: db.t3.micro (1GB RAM)
Engine: MySQL 8.0 Multi-AZ
Backup: 7 days auto
```

### 3. S3 - File Storage
```
Storage: Unlimited
Use: PDF materi, images
Access: Public read, private write
```

### 4. ElastiCache - Redis
```
Spek: cache.t3.micro (0.5GB)
Use: Cache, Sessions, Queue
Speed: 20x faster
```

### 5. ALB - Load Balancer
```
Distribute traffic ke 2+ EC2
Health check setiap 30s
SSL termination
```

### 6. Route 53 - DNS
```
Convert: educounsel.com → ALB IP
TTL: 300 seconds
```

---

## 🚀 OPTIONAL 5 (Recommended)

### 7. CloudFront - CDN
```
Edge: 400+ locations global
Cache: 1 week untuk PDF
Speed: 10x faster download
```

### 8. ACM - SSL Certificate
```
Cost: FREE!
Auto-renewal: Yes
Type: Wildcard support
```

### 9. CloudWatch - Monitoring
```
Logs: Real-time streaming
Metrics: CPU, RAM, disk
Alarms: Email/SMS alert
```

### 10. Auto Scaling
```
Min: 1 instance
Max: 5 instances
Trigger: CPU > 70%
```

### 11. SNS - Notifications
```
Email: admin@educounsel.com
SMS: Optional
Trigger: CloudWatch alarms
```

---

## 🔄 REQUEST FLOW

```
USER
 ↓
Route 53 (DNS)
 ↓
CloudFront (CDN cache)
 ↓
Application Load Balancer
 ↓           ↓
EC2 #1    EC2 #2 (Laravel)
 ↓           ↓
 ├─→ RDS MySQL (data)
 ├─→ ElastiCache Redis (cache)
 └─→ S3 (files)
```

---

## 💰 COST BREAKDOWN

### Production (100-500 users)
```
EC2:        $60  (2x t3.medium)
RDS:        $30  (Multi-AZ)
Redis:      $12  (cache.t3.micro)
S3:         $3   (100GB)
ALB:        $25  (Load Balancer)
CloudFront: $12  (CDN)
Others:     $10  (Route53, CloudWatch, SNS)
────────────────
TOTAL:      $152/month
```

### Development (Testing)
```
EC2:        $15  (1x t3.small)
RDS:        $15  (Single-AZ)
S3:         $1   (20GB)
Route53:    $1   (DNS)
────────────────
TOTAL:      $32/month
```

---

## ⚡ PERFORMANCE METRICS

### Speed Improvement
```
WITHOUT AWS:
- Page load: 2000ms
- File download: 5000ms
- Peak capacity: 50 users

WITH AWS:
- Page load: 200ms (10x faster)
- File download: 500ms (10x faster)
- Peak capacity: 1000+ users (20x scale)
```

### Uptime
```
Traditional Server: 95% uptime (438 hours downtime/year)
AWS Infrastructure: 99.99% uptime (52 minutes downtime/year)
```

---

## 🔒 SECURITY FEATURES

```
✅ HTTPS (TLS 1.3)
✅ Database encryption (at rest)
✅ S3 encryption (AES-256)
✅ Private subnets (no public IP)
✅ Security groups (firewall)
✅ IAM roles (access control)
✅ MFA (multi-factor auth)
✅ Auto backup (7 days)
✅ DDoS protection (CloudFront)
✅ WAF (Web Application Firewall) - optional
```

---

## 📊 SCALABILITY PATH

```
Stage 1: MVP (0-100 users)
└─ 1 EC2 + RDS + S3 = $30/month

Stage 2: Growth (100-500 users)
└─ 2 EC2 + RDS Multi-AZ + Redis + CDN = $150/month

Stage 3: Scale (500-2000 users)
└─ 5 EC2 + RDS + Redis Cluster + CDN = $400/month

Stage 4: Enterprise (2000+ users)
└─ ECS/EKS + Aurora + Lambda = $1,500/month
```

---

## 🎯 KEY BENEFITS

| Feature | Benefit |
|---------|---------|
| **Auto Backup** | Data safe, recover anytime |
| **Auto Scaling** | Handle traffic spike |
| **High Availability** | 99.99% uptime |
| **Global CDN** | Fast worldwide |
| **Pay as You Grow** | Start small, scale later |
| **Managed Services** | Less maintenance |
| **Enterprise Security** | Bank-grade encryption |

---

## 🛠️ SETUP TIME

```
Total: ~6 hours

AWS Account Setup:        15 min
Infrastructure Setup:     2 hours
Application Deployment:   1 hour
CDN Configuration:        30 min
Monitoring Setup:         30 min
Testing & Verification:   1 hour
Documentation:            30 min
```

---

## 📱 UNTUK PRESENTASI

### Slide 1: Problem
```
❌ Server sendiri: Mahal, ribet, sering down
❌ Upfront cost: $10,000+
❌ Maintenance: 40 jam/bulan
❌ Scaling: Beli server baru
```

### Slide 2: Solution
```
✅ AWS Cloud: Murah, mudah, reliable
✅ Upfront cost: $0
✅ Maintenance: Minimal
✅ Scaling: Click button
```

### Slide 3: Architecture
```
[Show diagram]
User → DNS → CDN → Load Balancer → EC2 → Database
```

### Slide 4: Cost Comparison
```
Traditional: $10,000 + $300/month
AWS Cloud: $0 + $150/month
SAVINGS: $11,800 year 1
```

### Slide 5: Benefits
```
✅ 99.99% uptime (24/7 available)
✅ Auto backup (data safe)
✅ Auto scale (handle 1000+ users)
✅ Fast global (CDN 400+ locations)
✅ Secure (bank-grade encryption)
```

---

## 💡 ANALOGIES untuk Penjelasan

```
EC2 = Sewa apartemen di cloud (virtual computer)
RDS = Asisten DBA yang urus database 24/7
S3 = Google Drive unlimited untuk website
Redis = Sticky notes super cepat untuk data temporary
ALB = Petugas parkir yang atur traffic
Route 53 = GPS yang arahkan user ke website
CloudFront = Cabang/franchise di berbagai kota
ACM = Sertifikat keamanan gratis selamanya
CloudWatch = CCTV + alarm untuk monitoring
Auto Scaling = Panggil karyawan tambahan saat ramai
SNS = SMS/Email untuk alert urgent
```

---

## ❓ Q&A PREPARATION

**Q: Kenapa tidak pakai shared hosting ($5/month)?**
```
A: Shared hosting:
   - Limited resources (crash saat ramai)
   - No auto scaling
   - No auto backup
   - Shared IP (SEO impact)
   - No control over server
   
   AWS:
   - Dedicated resources
   - Auto scale unlimited
   - Auto backup daily
   - Dedicated IP
   - Full control
```

**Q: Apa yang terjadi jika server down?**
```
A: Multi-AZ setup:
   - Server 1 down → Auto failover ke Server 2
   - Downtime: < 30 detik
   - User tidak notice
   - Auto alert ke admin
```

**Q: Berapa lama setup AWS?**
```
A: Total: 6 hours
   - AWS console: 15 menit
   - Infrastructure: 2 jam
   - Deploy app: 1 jam
   - Testing: 1 jam
```

**Q: Apakah perlu skill AWS khusus?**
```
A: Basic knowledge cukup:
   - Bisa ikuti tutorial AWS
   - Documentation lengkap
   - Support 24/7 available
   - Laravel integration mudah
```

**Q: Bagaimana jika budget terbatas?**
```
A: Mulai dari yang kecil:
   - Stage 1: $30/month (1 EC2 + RDS)
   - Stage 2: $150/month (production)
   - Scale sesuai growth
   - AWS Free Tier: 12 bulan gratis!
```

---

## 🚀 NEXT STEPS

### Immediate (Today)
```
1. Create AWS account
2. Apply for AWS Educate (students free credit)
3. Review architecture diagram
```

### Short-term (This Week)
```
1. Setup development environment
2. Test deployment to EC2
3. Configure S3 bucket
4. Test file upload/download
```

### Long-term (This Month)
```
1. Production deployment
2. Configure monitoring
3. Load testing
4. Security audit
5. Go live!
```

---

## 📚 DOCUMENTATION LINKS

**Main Document:** `AWS_ARCHITECTURE.md` (50 pages)  
**Simple Guide:** `AWS_SIMPLIFIED_GUIDE.md` (30 pages)  
**This Card:** `AWS_QUICK_REFERENCE.md` (Quick lookup)

**AWS Free Tier:** https://aws.amazon.com/free/  
**AWS Calculator:** https://calculator.aws/  
**Laravel on AWS:** https://docs.aws.amazon.com/elasticbeanstalk/

---

**💰 TOTAL INVESTMENT:**
- Development: $32/month
- Production: $152/month
- Enterprise: $400+/month

**⏱️ SETUP TIME:** 6 hours

**📈 SCALABILITY:** 10 → 10,000 users

**🔒 UPTIME:** 99.99% SLA

**✅ RECOMMENDATION:** START WITH DEVELOPMENT TIER!

---

**Last Updated:** 7 November 2025  
**Version:** 1.0 - Quick Reference  
**Print & Keep:** For presentation & meetings
