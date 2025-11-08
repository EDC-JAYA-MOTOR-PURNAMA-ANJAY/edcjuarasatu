# SLIDE 10: PERBANDINGAN

## 💰 AWS vs LOCAL SERVER

---

### **LOCAL SERVER (Traditional)**

```
BIAYA:
├─ Server fisik: $5,000-10,000
├─ Listrik: $100/month
├─ Internet: $200/month
├─ Maintenance: 40 hours/month
└─ TOTAL: $10,000 + $300/month

MASALAH:
❌ Mahal (upfront $10K)
❌ Manual backup (risky)
❌ Downtime tinggi (95% uptime)
❌ Tidak scalable
❌ Single point of failure
❌ Slow untuk remote users
```

---

### **AWS CLOUD (Modern)**

```
BIAYA:
├─ EC2: FREE (12 bulan)
├─ RDS: FREE (12 bulan)
├─ S3: FREE 5GB (12 bulan)
├─ CloudFront: FREE 50GB (12 bulan)
└─ TOTAL: $0/month (Year 1)
          $30/month (Year 2+)

KEUNTUNGAN:
✅ Murah (no upfront cost)
✅ Auto backup (daily)
✅ High uptime (99.95%)
✅ Auto scalable
✅ Multi-AZ redundancy
✅ Fast globally (CDN)
```

---

## PERFORMANCE COMPARISON

| Metric | Local Server | AWS Cloud |
|--------|--------------|-----------|
| **Setup Time** | 7 days | 3 hours |
| **Page Load** | 2000ms | 200ms |
| **File Download** | 10s | 1s (CDN) |
| **Uptime** | 95% | 99.95% |
| **Backup** | Manual | Automatic |
| **Scale** | Buy server | Click button |

---

## ROI (Return on Investment)

**Year 1:**
- Local: $13,600
- AWS: $0 (FREE!)
- **SAVINGS: $13,600** 💰

**Year 2:**
- Local: $3,600
- AWS: $360
- **SAVINGS: $3,240** 💰
