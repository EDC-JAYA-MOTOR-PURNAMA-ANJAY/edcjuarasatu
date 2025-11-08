# ☁️ AWS ARCHITECTURE - EDUCOUNSEL SYSTEM

**Project:** Sistem Bimbingan Konseling Berbasis AI  
**Stack:** Laravel 12 + MySQL + Redis + OpenAI  
**Users:** 100+ concurrent users  
**Date:** 7 November 2025

---

## 📊 EXECUTIVE SUMMARY

### **Total AWS Services Dibutuhkan: 11**

**Core Services (Wajib):** 6 services  
**Optional Services (Recommended):** 5 services  
**Estimated Monthly Cost:** $50 - $150 USD (depending on traffic)

---

## 🏗️ ARCHITECTURE DIAGRAM

```
┌─────────────────────────────────────────────────────────────────┐
│                         INTERNET/USERS                           │
│                    (Guru BK, Siswa, Admin)                      │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTE 53 (DNS)                                │
│             educounsel.com → AWS Infrastructure                  │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│              CLOUDFRONT (CDN) + SSL Certificate                  │
│           Cache static assets, HTTPS termination                 │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│         APPLICATION LOAD BALANCER (ALB)                          │
│    Distribute traffic, Health checks, Auto-scaling trigger       │
└───┬─────────────────────────────────────────────────────────┬───┘
    │                                                         │
    ▼                                                         ▼
┌─────────────────────┐                            ┌─────────────────────┐
│   EC2 Instance #1   │                            │   EC2 Instance #2   │
│   Laravel App       │◄──────Auto Scaling────────►│   Laravel App       │
│   (t3.medium)       │                            │   (t3.medium)       │
└──────┬──────────────┘                            └──────┬──────────────┘
       │                                                  │
       │    ┌─────────────────────────────────────────┐  │
       └───►│          S3 BUCKET                      │◄─┘
            │   File Storage (PDFs, Images)           │
            │   - Public Read for downloads           │
            │   - Lifecycle policy for cost savings   │
            └─────────────────────────────────────────┘
       │
       ├───►┌─────────────────────────────────────────┐
       │    │    RDS MySQL (db.t3.micro)              │
       │    │    - Multi-AZ for high availability     │
       │    │    - Automated backups (7 days)         │
       │    │    - Encrypted at rest                  │
       │    └─────────────────────────────────────────┘
       │
       ├───►┌─────────────────────────────────────────┐
       │    │   ElastiCache Redis (cache.t3.micro)    │
       │    │   - Sessions storage                    │
       │    │   - Laravel cache                       │
       │    │   - Queue jobs                          │
       │    └─────────────────────────────────────────┘
       │
       └───►┌─────────────────────────────────────────┐
            │      EXTERNAL SERVICES                   │
            │   - OpenAI API (Chatbot GPT-4)          │
            │   - Pusher/Laravel Echo (WebSockets)    │
            └─────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                  MONITORING & LOGGING                            │
│   - CloudWatch Logs (Application logs)                          │
│   - CloudWatch Metrics (Performance monitoring)                 │
│   - SNS Alerts (Email notifications for errors)                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🎯 CORE AWS SERVICES (WAJIB)

### **1. EC2 (Elastic Compute Cloud)**

**Fungsi:** Hosting aplikasi Laravel

**Spesifikasi:**
- **Instance Type:** `t3.medium` (2 vCPU, 4GB RAM)
- **OS:** Ubuntu 22.04 LTS
- **Quantity:** 2 instances (untuk high availability)
- **Storage:** 30GB EBS SSD

**Cara Kerja:**
```
1. User request → Load Balancer
2. Load Balancer → EC2 Instance (round-robin)
3. EC2 menjalankan PHP-FPM + Nginx
4. Laravel process request
5. Response kembali ke user
```

**Setup:**
```bash
# Install di EC2
sudo apt update
sudo apt install -y nginx php8.2-fpm php8.2-mysql php8.2-redis \
  php8.2-mbstring php8.2-xml php8.2-curl composer

# Clone project
cd /var/www
git clone <your-repo> educounsel

# Install dependencies
cd educounsel
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configure Nginx
sudo nano /etc/nginx/sites-available/educounsel
```

**Biaya Perkiraan:**
- 2 x t3.medium: ~$60/bulan (730 hours × $0.0416/hour × 2)

---

### **2. RDS (Relational Database Service)**

**Fungsi:** MySQL database hosting

**Spesifikasi:**
- **Instance Class:** `db.t3.micro` (2 vCPU, 1GB RAM)
- **Engine:** MySQL 8.0
- **Storage:** 20GB SSD (General Purpose)
- **Multi-AZ:** Yes (untuk backup otomatis)
- **Backup Retention:** 7 days

**Cara Kerja:**
```
1. Laravel → Connect ke RDS endpoint
2. RDS Master handles writes
3. RDS Standby (Multi-AZ) syncs otomatis
4. Jika Master fail → Auto failover ke Standby
5. Automated backup setiap hari
```

**Environment Variable di EC2:**
```env
DB_CONNECTION=mysql
DB_HOST=educounsel-db.abc123.ap-southeast-1.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=educounsel
DB_USERNAME=admin
DB_PASSWORD=SecurePassword123!
```

**Keuntungan:**
- ✅ Auto backup & restore
- ✅ Auto patching & updates
- ✅ High availability (Multi-AZ)
- ✅ Point-in-time recovery
- ✅ Monitoring built-in

**Biaya Perkiraan:**
- db.t3.micro Multi-AZ: ~$30/bulan

---

### **3. S3 (Simple Storage Service)**

**Fungsi:** File storage untuk materi (PDF, images)

**Spesifikasi:**
- **Bucket Name:** `educounsel-materi`
- **Region:** `ap-southeast-1` (Singapore)
- **Storage Class:** S3 Standard (frequently accessed)
- **Public Access:** Partial (read-only untuk downloads)

**Cara Kerja:**
```
UPLOAD FLOW:
1. Guru BK upload PDF via web form
2. Laravel validates file (size, type)
3. Laravel upload ke S3 via AWS SDK
4. S3 returns public URL
5. URL disimpan di database

DOWNLOAD FLOW:
1. Siswa click download button
2. Laravel generate signed URL (expire 1 hour)
3. Browser download langsung dari S3
4. CloudFront cache untuk faster delivery
```

**Laravel Configuration:**
```php
// config/filesystems.php
'disks' => [
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
        'bucket' => env('AWS_BUCKET', 'educounsel-materi'),
    ],
],

// Usage
Storage::disk('s3')->put('materi/files/test.pdf', $file);
$url = Storage::disk('s3')->url('materi/files/test.pdf');
```

**Bucket Policy (Read-only public):**
```json
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Sid": "PublicReadGetObject",
      "Effect": "Allow",
      "Principal": "*",
      "Action": "s3:GetObject",
      "Resource": "arn:aws:s3:::educounsel-materi/public/*"
    }
  ]
}
```

**Lifecycle Policy (Cost Optimization):**
```
- Files older than 90 days → S3 Intelligent-Tiering
- Files older than 365 days → S3 Glacier (archive)
```

**Biaya Perkiraan:**
- Storage: $0.023/GB per month
- 100GB storage: ~$2.30/bulan
- Transfer: First 1GB free, then $0.09/GB

---

### **4. ElastiCache (Redis)**

**Fungsi:** Cache, session storage, queue management

**Spesifikasi:**
- **Instance Type:** `cache.t3.micro` (0.5GB memory)
- **Engine:** Redis 7.0
- **Nodes:** 1 (single node untuk dev, 2+ untuk production)

**Cara Kerja:**

**1. Session Storage:**
```
User login → Session disimpan di Redis (bukan file)
Keuntungan:
- Shared sessions antar EC2 instances
- Faster than database sessions
- Auto expire
```

**2. Cache:**
```
Laravel cache dashboard statistics → Redis
Next request → Ambil dari Redis (no DB query)
Cache expire after 5 minutes
10x faster response
```

**3. Queue Jobs:**
```
Upload materi → Push job ke Redis queue
Background worker → Process notification sending
Non-blocking user experience
```

**Laravel Configuration:**
```env
REDIS_HOST=educounsel-cache.abc123.cache.amazonaws.com
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

**Biaya Perkiraan:**
- cache.t3.micro: ~$12/bulan

---

### **5. Application Load Balancer (ALB)**

**Fungsi:** Distribute traffic, health checks, SSL termination

**Cara Kerja:**
```
1. User → HTTPS request → ALB
2. ALB terminates SSL (menggunakan ACM certificate)
3. ALB checks health of EC2 instances
4. ALB routes ke healthy instance (round-robin)
5. If instance unhealthy → Auto remove from pool
6. Auto Scaling adds new instance → ALB detects & adds
```

**Health Check Configuration:**
```
Path: /health-check
Interval: 30 seconds
Timeout: 5 seconds
Healthy threshold: 2 consecutive successes
Unhealthy threshold: 3 consecutive failures
```

**Laravel Health Check Route:**
```php
// routes/web.php
Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'failed'
    ]);
});
```

**Biaya Perkiraan:**
- ALB: ~$16/bulan (base) + $0.008 per LCU-hour
- Total: ~$20-25/bulan

---

### **6. Route 53 (DNS Management)**

**Fungsi:** Domain name resolution

**Setup:**
```
Domain: educounsel.com
A Record: educounsel.com → ALB DNS name
CNAME: www.educounsel.com → educounsel.com
```

**Biaya Perkiraan:**
- Hosted Zone: $0.50/month
- Queries: $0.40 per million queries
- Total: ~$1-2/bulan

---

## 🚀 OPTIONAL SERVICES (RECOMMENDED)

### **7. CloudFront (CDN)**

**Fungsi:** Content delivery, caching, DDoS protection

**Cara Kerja:**
```
User di Jakarta request PDF → CloudFront Singapore edge
CloudFront cache hit → Serve dari edge (5ms)
CloudFront cache miss → Fetch dari S3 (50ms) → Cache

Result: 10x faster file downloads
```

**Cache Behavior:**
```
Static Assets (CSS, JS, Images): Cache 1 year
PDF Files: Cache 1 week
API Responses: No cache
```

**Biaya Perkiraan:**
- Data Transfer: $0.12/GB (first 10TB)
- 100GB/month: ~$12/bulan

---

### **8. AWS Certificate Manager (ACM)**

**Fungsi:** SSL/TLS certificates (GRATIS!)

**Setup:**
```
1. Request certificate untuk educounsel.com
2. Verify domain ownership (DNS validation)
3. Attach certificate ke ALB
4. Auto-renewal (sebelum expire)
```

**Biaya:** $0 (FREE!)

---

### **9. CloudWatch (Monitoring)**

**Fungsi:** Logs, metrics, alarms

**Monitoring:**
```
1. Application Logs:
   - Laravel logs → CloudWatch Logs
   - Error tracking
   - Query analysis

2. Metrics:
   - CPU utilization (EC2)
   - Database connections (RDS)
   - Request count (ALB)
   - Cache hit rate (Redis)

3. Alarms:
   - CPU > 80% → SNS email alert
   - Error rate > 5% → SNS alert
   - Disk space < 10% → SNS alert
```

**Biaya Perkiraan:**
- Logs: First 5GB free, then $0.50/GB
- Total: ~$5-10/bulan

---

### **10. Auto Scaling**

**Fungsi:** Automatic EC2 instance scaling

**Configuration:**
```yaml
Min Instances: 1
Max Instances: 5
Desired: 2

Scale Out (add instance):
- CPU > 70% for 5 minutes
- Request count > 1000/min

Scale In (remove instance):
- CPU < 30% for 10 minutes
- Request count < 200/min
```

**Biaya:** No additional cost (pay only for EC2 instances)

---

### **11. SNS (Simple Notification Service)**

**Fungsi:** Alert notifications via email/SMS

**Setup:**
```
Topic: educounsel-alerts
Subscribers:
- admin@educounsel.com (email)
- +62812XXXXX (SMS - optional)

Triggers:
- Error rate > 5%
- Database connection failed
- Disk space critical
- SSL certificate expiring
```

**Biaya Perkiraan:**
- Email: First 1000 free, then $2 per 100,000
- Total: <$1/bulan

---

## 💰 TOTAL COST ESTIMATE

### **Production Setup (Medium Traffic)**

| Service | Specification | Monthly Cost |
|---------|--------------|--------------|
| EC2 (2x t3.medium) | 4 vCPU, 8GB RAM total | $60 |
| RDS MySQL | db.t3.micro Multi-AZ | $30 |
| ElastiCache Redis | cache.t3.micro | $12 |
| S3 Storage | 100GB + transfer | $5 |
| Application Load Balancer | - | $25 |
| CloudFront CDN | 100GB transfer | $12 |
| Route 53 | DNS hosting | $1 |
| CloudWatch | Logs & metrics | $8 |
| **TOTAL** | | **~$153/month** |

### **Development/Testing Setup (Low Traffic)**

| Service | Specification | Monthly Cost |
|---------|--------------|--------------|
| EC2 (1x t3.small) | 2 vCPU, 2GB RAM | $15 |
| RDS MySQL | db.t3.micro (single-AZ) | $15 |
| ElastiCache Redis | cache.t3.micro | $12 |
| S3 Storage | 20GB + transfer | $2 |
| Route 53 | DNS hosting | $1 |
| **TOTAL** | | **~$45/month** |

### **Cost Optimization Tips:**

1. **Reserved Instances:** Save 30-60% dengan commit 1-3 years
2. **Spot Instances:** Save 70% untuk background workers
3. **S3 Lifecycle:** Auto-archive old files ke Glacier
4. **CloudFront:** Cache aggressively untuk reduce S3 calls
5. **Auto Scaling:** Scale down during off-peak hours

---

## 🔄 REQUEST FLOW LENGKAP

### **Flow 1: User Login**

```
1. User → https://educounsel.com/login
2. Route 53 → Resolve to ALB IP
3. CloudFront → Check cache (no cache for dynamic pages)
4. ALB → Health check EC2 instances
5. ALB → Route to EC2 #1 (least connections)
6. Nginx → Pass to PHP-FPM
7. Laravel → Validate credentials vs RDS MySQL
8. Laravel → Store session in ElastiCache Redis
9. Laravel → Return dashboard view
10. Response → ALB → CloudFront → User
```

**Time:** ~200-300ms

---

### **Flow 2: Upload Materi (PDF)**

```
1. Guru BK → Upload PDF via form
2. ALB → EC2 instance
3. Laravel → Validate file (max 10MB, type PDF)
4. Laravel → Upload to S3 bucket
   - SDK: AWS\S3\S3Client::putObject()
   - Path: s3://educounsel-materi/materi/files/uuid.pdf
5. S3 → Return object URL
6. Laravel → Save metadata to RDS:
   - Table: materi
   - Columns: judul, file_path, s3_url, uploaded_by
7. Laravel → Push notification job to Redis queue
8. Background Worker → Process queue:
   - Fetch all active siswa
   - Send browser notification via Pusher
   - Log to notifications table
9. Laravel → Return success response
10. Frontend → Voice alert: "Materi berhasil..."
```

**Time:** ~2-3 seconds (upload) + background notification

---

### **Flow 3: Download Materi (Siswa)**

```
1. Siswa → Click download button
2. Laravel → Generate signed S3 URL (expire 1 hour)
   - $url = Storage::disk('s3')->temporaryUrl($path, now()->addHour());
3. Laravel → Return signed URL
4. Browser → Redirect to S3 URL
5. CloudFront → Check edge cache
   - Cache HIT: Serve from Singapore edge (~5ms)
   - Cache MISS: Fetch from S3 → Cache → Serve
6. File download starts
```

**Time:** 5-50ms (depending on cache)

---

### **Flow 4: Dashboard Analytics**

```
1. Guru BK → Open dashboard
2. Laravel → Check Redis cache:
   - Key: "dashboard:stats:guru_id:3"
   - TTL: 5 minutes
3. If CACHE HIT:
   - Return cached data (5ms)
4. If CACHE MISS:
   - Query RDS MySQL (5 queries):
     a. Count total siswa
     b. Count total materi
     c. Count notifications
     d. Get engagement stats
     e. Get recent activities
   - Store in Redis cache
   - Return data (100ms)
5. Blade view → Render charts with Chart.js
```

**Time:** 5ms (cached) or 100ms (fresh)

---

## 🔒 SECURITY BEST PRACTICES

### **1. VPC (Virtual Private Cloud)**

```
Public Subnets (DMZ):
├─ Application Load Balancer
└─ NAT Gateway

Private Subnets (Secure):
├─ EC2 Instances (Laravel app)
├─ RDS MySQL (no public access)
└─ ElastiCache Redis (no public access)
```

**Security Groups:**

```
ALB Security Group:
- Inbound: 443 (HTTPS) from 0.0.0.0/0
- Outbound: 80, 443 to EC2 Security Group

EC2 Security Group:
- Inbound: 80 from ALB Security Group only
- Inbound: 22 (SSH) from Bastion Host only
- Outbound: 443 to Internet (for API calls)
- Outbound: 3306 to RDS Security Group
- Outbound: 6379 to Redis Security Group

RDS Security Group:
- Inbound: 3306 from EC2 Security Group only
- No outbound internet access

Redis Security Group:
- Inbound: 6379 from EC2 Security Group only
- No outbound internet access
```

### **2. IAM (Identity & Access Management)**

**EC2 Instance Role:**
```json
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:GetObject",
        "s3:PutObject",
        "s3:DeleteObject"
      ],
      "Resource": "arn:aws:s3:::educounsel-materi/*"
    },
    {
      "Effect": "Allow",
      "Action": [
        "logs:CreateLogGroup",
        "logs:CreateLogStream",
        "logs:PutLogEvents"
      ],
      "Resource": "*"
    }
  ]
}
```

### **3. Encryption**

```
✅ Data at Rest:
- RDS: Encrypted with AWS KMS
- S3: Server-side encryption (AES-256)
- EBS: Encrypted volumes

✅ Data in Transit:
- ALB: HTTPS/TLS 1.2+
- RDS: SSL connection
- Redis: In-transit encryption enabled
```

---

## 📈 SCALABILITY PLAN

### **Stage 1: 100 users (Current)**
```
- 1x EC2 t3.small
- 1x RDS db.t3.micro
- Cost: ~$45/month
```

### **Stage 2: 500 users**
```
- 2x EC2 t3.medium (with Auto Scaling)
- 1x RDS db.t3.small (Multi-AZ)
- ElastiCache Redis
- Cost: ~$150/month
```

### **Stage 3: 2000+ users**
```
- 3-5x EC2 t3.large (Auto Scaling)
- 1x RDS db.t3.medium (Multi-AZ, Read Replica)
- 2x ElastiCache Redis (cluster mode)
- CloudFront CDN
- Cost: ~$400/month
```

### **Stage 4: 10,000+ users (Enterprise)**
```
- ECS/EKS (Container orchestration)
- Aurora Serverless (auto-scaling database)
- ElastiCache Redis cluster
- S3 + CloudFront
- Lambda for microservices
- Cost: ~$1,500/month
```

---

## 🚀 DEPLOYMENT WORKFLOW

### **CI/CD Pipeline (GitHub Actions → AWS)**

```yaml
name: Deploy to AWS

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Configure AWS credentials
        uses: aws-actions/configure-aws-credentials@v1
        with:
          aws-access-key-id: ${{ secrets.AWS_ACCESS_KEY_ID }}
          aws-secret-access-key: ${{ secrets.AWS_SECRET_ACCESS_KEY }}
          aws-region: ap-southeast-1
      
      - name: Build & Test
        run: |
          composer install
          php artisan test
      
      - name: Deploy to EC2
        run: |
          aws deploy create-deployment \
            --application-name educounsel \
            --deployment-group production \
            --s3-location bucket=educounsel-deploy,key=app.zip
      
      - name: Invalidate CloudFront cache
        run: |
          aws cloudfront create-invalidation \
            --distribution-id E123456789 \
            --paths "/*"
```

---

## 📚 SETUP INSTRUCTIONS

### **Step 1: AWS Account Setup**

```bash
1. Create AWS account
2. Enable MFA for root account
3. Create IAM admin user
4. Install AWS CLI:
   
   # Windows
   msi installer dari aws.amazon.com/cli
   
   # Configure
   aws configure
   AWS Access Key ID: AKIA...
   AWS Secret Access Key: ...
   Default region: ap-southeast-1
   Default output: json
```

### **Step 2: Create RDS Database**

```bash
aws rds create-db-instance \
  --db-instance-identifier educounsel-db \
  --db-instance-class db.t3.micro \
  --engine mysql \
  --master-username admin \
  --master-user-password SecurePass123! \
  --allocated-storage 20 \
  --backup-retention-period 7 \
  --multi-az
```

### **Step 3: Create S3 Bucket**

```bash
aws s3 mb s3://educounsel-materi --region ap-southeast-1

# Enable versioning
aws s3api put-bucket-versioning \
  --bucket educounsel-materi \
  --versioning-configuration Status=Enabled

# Set CORS
aws s3api put-bucket-cors \
  --bucket educounsel-materi \
  --cors-configuration file://cors.json
```

### **Step 4: Launch EC2 Instance**

```bash
# Create instance
aws ec2 run-instances \
  --image-id ami-0c55b159cbfafe1f0 \
  --instance-type t3.medium \
  --key-name educounsel-key \
  --security-group-ids sg-xxx \
  --subnet-id subnet-xxx \
  --iam-instance-profile Name=educounsel-ec2-role

# SSH to instance
ssh -i educounsel-key.pem ubuntu@ec2-xx-xx-xx-xx.ap-southeast-1.compute.amazonaws.com

# Install dependencies (run on EC2)
sudo apt update
sudo apt install -y nginx php8.2-fpm php8.2-mysql php8.2-redis composer git
```

### **Step 5: Deploy Laravel**

```bash
# On EC2
cd /var/www
git clone https://github.com/your-repo/educounsel.git
cd educounsel

# Install
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Environment
cp .env.example .env
nano .env

# Set:
DB_HOST=educounsel-db.xxx.ap-southeast-1.rds.amazonaws.com
REDIS_HOST=educounsel-cache.xxx.cache.amazonaws.com
AWS_BUCKET=educounsel-materi
FILESYSTEM_DISK=s3

# Generate key
php artisan key:generate

# Migrate
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
sudo chown -R www-data:www-data storage bootstrap/cache
```

---

## 🎯 CONCLUSION

### **Why AWS for EduCounsel?**

✅ **Scalability:** Auto-scale dari 100 → 10,000 users  
✅ **Reliability:** 99.99% uptime SLA  
✅ **Security:** Enterprise-grade encryption & compliance  
✅ **Performance:** CDN global, low latency  
✅ **Cost-Effective:** Pay only for what you use  
✅ **Managed Services:** Less maintenance, more development  

### **Recommended Starting Point:**

**For Demo/Testing:**
- 1x EC2 t3.small
- RDS db.t3.micro
- S3 bucket
- **Total: ~$40/month**

**For Production (100 users):**
- 2x EC2 t3.medium (Auto Scaling)
- RDS db.t3.micro (Multi-AZ)
- ElastiCache Redis
- CloudFront CDN
- **Total: ~$150/month**

### **Next Steps:**

1. ✅ Setup AWS account
2. ✅ Create VPC & subnets
3. ✅ Launch RDS database
4. ✅ Create S3 bucket
5. ✅ Deploy EC2 instances
6. ✅ Configure Load Balancer
7. ✅ Setup CloudFront
8. ✅ Configure monitoring
9. ✅ Test thoroughly
10. ✅ Go live!

---

**Need Help?** Refer to AWS documentation atau contact AWS Support.

**Last Updated:** 7 November 2025  
**Version:** 1.0  
**Status:** Production-Ready Architecture
