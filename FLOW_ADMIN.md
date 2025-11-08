# 👨‍💻 ALUR ADMIN - AWS MAPPING

## 1️⃣ LOGIN

```
educounsel.com/admin → [Route 53] → [ALB] → [EC2] Laravel
                                              ↓
                                  [RDS] Check admin credentials
                                              ↓
                                  [Redis] Store admin session
                                              ↓
                               Redirect /admin/dashboard
```

**AWS:** Route 53, ALB, EC2, RDS, Redis

---

## 2️⃣ DASHBOARD

```
GET /admin/dashboard
        ↓
[EC2] AdminController@dashboard
        ↓
[Redis] Get cache: admin:dashboard:stats
        ├─ HIT → Return (1ms) ✅
        └─ MISS → [RDS] Query:
                  ├─ Total users (by role)
                  ├─ Total materi
                  ├─ System logs
                  └─ Activity stats
                        ↓
                  [Redis] Cache 5min
```

**AWS:** EC2, RDS, Redis

---

## 3️⃣ MANAGE USERS

```
GET /admin/users
        ↓
[EC2] UserController@index
        ↓
[RDS] Query users table with filters
        ↓
Display user list:
├─ Admin (2 users)
├─ Guru BK (5 users)
└─ Siswa (100 users)

Actions:
├─ Create new user → [RDS] INSERT
├─ Edit user → [RDS] UPDATE
├─ Delete user → [RDS] DELETE
└─ Reset password → [RDS] UPDATE + Hash::make()
```

**AWS:** EC2, RDS

---

## 4️⃣ MANAGE KELAS

```
GET /admin/kelas
        ↓
[EC2] KelasController@index
        ↓
[RDS] Query kelas table
        ↓
Display kelas list (X RPL 1, X RPL 2, etc)

Actions:
├─ Create kelas → [RDS] INSERT
├─ Edit kelas → [RDS] UPDATE
├─ Delete kelas → [RDS] DELETE (check foreign keys)
└─ Assign siswa → [RDS] UPDATE users.kelas_id
```

**AWS:** EC2, RDS

---

## 5️⃣ SYSTEM MONITORING

```
GET /admin/monitoring
        ↓
[EC2] MonitoringController
        ↓
[CloudWatch] Fetch metrics:
├─ EC2 CPU usage
├─ RDS connections
├─ S3 storage usage
├─ Request count
└─ Error rate
        ↓
Display monitoring dashboard
```

**AWS:** EC2, CloudWatch

---

## 6️⃣ SYSTEM LOGS

```
GET /admin/logs
        ↓
[EC2] LogController
        ↓
[CloudWatch Logs] Query:
├─ Application logs
├─ Error logs
├─ Access logs
└─ Audit logs
        ↓
Display with filters (date, level, user)
```

**AWS:** EC2, CloudWatch Logs

---

## 7️⃣ BACKUP & RESTORE

```
Manual Backup:
        ↓
[EC2] BackupController@create
        ↓
[RDS] Create snapshot
        ↓
[S3] Backup files (materi, thumbnails)
        ↓
Success notification

Automated Backup:
        ↓
[RDS] Daily automated snapshot (7 days retention)
        ↓
[S3] Versioning enabled (auto)
```

**AWS:** EC2, RDS, S3

---

## 📊 ADMIN AWS USAGE

| Fitur | EC2 | RDS | S3 | Redis | CloudWatch |
|-------|-----|-----|----|----|------------|
| Login | ✅ | ✅ | - | ✅ | - |
| Dashboard | ✅ | ✅ | - | ✅ | - |
| Manage Users | ✅ | ✅ | - | - | - |
| Manage Kelas | ✅ | ✅ | - | - | - |
| Monitoring | ✅ | - | - | - | ✅ |
| Logs | ✅ | - | - | - | ✅ |
| Backup | ✅ | ✅ | ✅ | - | - |
