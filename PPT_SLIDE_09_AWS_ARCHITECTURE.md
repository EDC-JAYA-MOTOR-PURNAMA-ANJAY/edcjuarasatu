# SLIDE 9: AWS ARCHITECTURE

## 🏗️ INFRASTRUKTUR SISTEM

---

```
                    [USERS]
                 /    |    \
            Admin  Guru BK  Siswa
                 \    |    /
                      ↓
        ┌──────────────────────────┐
        │   ROUTE 53 (DNS)         │
        │   educounsel.com         │
        └──────────┬───────────────┘
                   ↓
        ┌──────────────────────────┐
        │   CLOUDFRONT (CDN)       │
        │   • Cache static assets  │
        │   • Fast file delivery   │
        └──────────┬───────────────┘
                   ↓
        ┌──────────────────────────┐
        │   EC2 (Server)           │
        │   • Laravel App          │
        │   • Nginx                │
        │   • PHP 8.2              │
        └──────┬────────┬──────────┘
               ↓        ↓
    ┌──────────────┐  ┌──────────────┐
    │ RDS MySQL    │  │ S3 Storage   │
    │ • Users      │  │ • Thumbnails │
    │ • Materi     │  │ • PDF files  │
    │ • Chatbot    │  │              │
    │ • Notifications│  │            │
    └──────────────┘  └──────────────┘
```

---

## FREE TIER CONFIGURATION

**EC2 Instance:**
- Type: t2.micro (1 vCPU, 1GB RAM)
- OS: Ubuntu 22.04
- FREE: 750 hours/month

**RDS MySQL:**
- Type: db.t2.micro (1GB RAM)
- Storage: 20GB
- FREE: 750 hours/month

**S3 Bucket:**
- Storage: 5GB
- Transfer: 15GB/month out
- FREE: First 12 months

**CloudFront:**
- Transfer: 50GB/month
- FREE: First 12 months

---

## CAPACITY (FREE TIER)

- **Users:** 100-200 concurrent
- **Files:** Up to 5GB
- **Database:** 20GB
- **Uptime:** 24/7 (750h = 31 days)

**Perfect untuk: Demo, MVP, Testing**
