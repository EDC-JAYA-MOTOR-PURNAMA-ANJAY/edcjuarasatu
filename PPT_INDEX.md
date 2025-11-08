# 📊 PRESENTASI EDUCOUNSEL - INDEX

**12 Slides untuk PowerPoint/Google Slides**

---

## 📋 DAFTAR SLIDES

### **BAGIAN 1: INTRODUCTION**

**Slide 1:** Intro
- File: `PPT_SLIDE_01_INTRO.md`
- Isi: Overview system, fitur, tech stack

**Slide 2:** AWS Free Tier
- File: `PPT_SLIDE_02_AWS_FREE.md`
- Isi: Services gratis 12 bulan, alternatif Railway

---

### **BAGIAN 2: SYSTEM FLOW**

**Slide 3:** Alur Login
- File: `PPT_SLIDE_03_ALUR_LOGIN.md`
- Isi: Login flow dengan AWS mapping

**Slide 4:** Alur Upload Materi (Guru BK)
- File: `PPT_SLIDE_04_ALUR_UPLOAD.md`
- Isi: Upload flow dengan S3, notifications

**Slide 5:** Alur Baca Materi (Siswa)
- File: `PPT_SLIDE_05_ALUR_BACA.md`
- Isi: Read flow, PDF inline viewer, CloudFront

**Slide 6:** Alur AI Chatbot
- File: `PPT_SLIDE_06_ALUR_CHATBOT.md`
- Isi: Chat flow dengan OpenAI API

**Slide 7:** Alur Notifikasi Real-time
- File: `PPT_SLIDE_07_ALUR_NOTIF.md`
- Isi: Notification system, WebSocket

**Slide 8:** Alur Analytics Dashboard
- File: `PPT_SLIDE_08_ALUR_ANALYTICS.md`
- Isi: Dashboard stats, charts, queries

---

### **BAGIAN 3: INFRASTRUCTURE**

**Slide 9:** AWS Architecture
- File: `PPT_SLIDE_09_AWS_ARCHITECTURE.md`
- Isi: Diagram arsitektur, free tier config

**Slide 10:** Comparison (AWS vs Local)
- File: `PPT_SLIDE_10_COMPARISON.md`
- Isi: Perbandingan biaya, performance, ROI

**Slide 11:** Opsi Gratis Lainnya
- File: `PPT_SLIDE_11_FREE_OPTIONS.md`
- Isi: Railway, AWS Educate, GitHub Student Pack

**Slide 12:** Kesimpulan
- File: `PPT_SLIDE_12_CONCLUSION.md`
- Isi: Summary, next steps, metrics

---

## 🎨 CARA PAKAI

### **PowerPoint:**

1. Buka PowerPoint
2. Create new presentation
3. Copy content dari setiap file .md
4. Format dengan:
   - Title: 36pt Bold
   - Body: 20pt
   - Code blocks: Courier New 16pt
   - Diagrams: Paste as is (monospace font)

### **Google Slides:**

1. Buka Google Slides
2. Create new presentation
3. Copy-paste dari file .md
4. Use theme: "Simple Dark" atau "Modern Writer"
5. Add icons/images jika perlu

---

## 🎯 TIPS PRESENTASI

### **Timing (20-30 menit total):**

- Slide 1-2: 3 menit (intro)
- Slide 3-8: 15 menit (demo flow)
- Slide 9-11: 7 menit (infrastructure)
- Slide 12: 3 menit (conclusion)
- Q&A: 5-10 menit

### **Focus Points:**

✅ **Slide 4-5:** Demo upload & baca (CORE FEATURE)
✅ **Slide 7:** Real-time notifications (WOW FACTOR)
✅ **Slide 10:** Cost comparison (SELLING POINT)

### **Visual Aids:**

- Use ASCII diagrams (already in slides)
- Add screenshots dari actual app
- Show live demo if possible
- Use colors:
  - Green: ✅ Success/Free
  - Purple: AWS/System
  - Blue: Data flow
  - Red: Alerts/Important

---

## 📝 QUICK REFERENCE

### **Key Numbers:**

- **Users:** 100+ siswa, 5 Guru BK, 2 Admin
- **AWS Free:** 12 bulan ($600 value)
- **Setup Time:** 3 hours (AWS) / 20 min (Railway)
- **Performance:** 10x faster dengan CDN
- **Uptime:** 99.95%
- **Savings Year 1:** $13,600

### **AWS Services (FREE):**

1. **EC2** - 750h/month (server)
2. **RDS** - 750h/month (database)
3. **S3** - 5GB (files)
4. **CloudFront** - 50GB (CDN)
5. **Route 53** - $0.50/month (DNS)

---

## 🎬 DEMO SCRIPT

### **For Live Demo:**

```
1. Login as Guru BK
   → Show dashboard with analytics

2. Upload new materi
   → Upload PDF + thumbnail
   → Show success message

3. Login as Siswa (new tab)
   → Show toast notification (real-time!)
   → Click notification
   → Navigate to materi page

4. Read materi
   → Show tabs: Content & PDF
   → Demo inline PDF viewer
   → Download file

5. Open AI Chatbot
   → Send message
   → Show real-time response
   → Explain GPT-4 integration

6. Back to Guru BK
   → Show updated analytics
   → Explain caching strategy
```

---

## 📊 BACKUP SLIDES (Optional)

### **If Time Allows:**

**Slide 13:** Technical Stack Detail
- Laravel 12, Blade, Tailwind
- MySQL, Redis, WebSocket
- Chart.js, jQuery

**Slide 14:** Security Features
- SSL/TLS encryption
- Password hashing (bcrypt)
- CSRF protection
- Role-based access

**Slide 15:** Scalability Plan
- Stage 1: 100 users (FREE)
- Stage 2: 500 users ($150/month)
- Stage 3: 2000+ users ($400/month)

---

## ✅ CHECKLIST SEBELUM PRESENTASI

- [ ] Review semua 12 slides
- [ ] Practice demo flow (5-10 menit)
- [ ] Prepare live demo environment
- [ ] Test internet connection
- [ ] Backup: Screenshot/video demo
- [ ] Print handout (optional)
- [ ] Prepare Q&A answers

---

## 💡 COMMON QUESTIONS & ANSWERS

**Q: Berapa biaya AWS setelah 12 bulan?**
A: ~$30/month untuk basic, $150 untuk production

**Q: Apakah bisa pakai hosting biasa?**
A: Bisa, tapi tidak dapat: auto backup, CDN, scalability

**Q: Berapa kapasitas free tier?**
A: 100-200 concurrent users, 5GB files

**Q: Setup berapa lama?**
A: AWS: 3 jam, Railway: 20 menit

**Q: Apakah perlu skill AWS?**
A: Basic knowledge cukup, dokumentasi lengkap tersedia

---

## 📁 FILE STRUCTURE

```
PPT Files:
├── PPT_INDEX.md (this file)
├── PPT_SLIDE_01_INTRO.md
├── PPT_SLIDE_02_AWS_FREE.md
├── PPT_SLIDE_03_ALUR_LOGIN.md
├── PPT_SLIDE_04_ALUR_UPLOAD.md
├── PPT_SLIDE_05_ALUR_BACA.md
├── PPT_SLIDE_06_ALUR_CHATBOT.md
├── PPT_SLIDE_07_ALUR_NOTIF.md
├── PPT_SLIDE_08_ALUR_ANALYTICS.md
├── PPT_SLIDE_09_AWS_ARCHITECTURE.md
├── PPT_SLIDE_10_COMPARISON.md
├── PPT_SLIDE_11_FREE_OPTIONS.md
└── PPT_SLIDE_12_CONCLUSION.md

Supporting Docs:
├── AWS_COMPLETE_MAPPING.md (detail)
├── FLOW_GURU_BK.md (detail)
├── FLOW_SISWA.md (detail)
└── FLOW_ADMIN.md (detail)
```

---

**Last Updated:** 7 November 2025  
**Version:** 1.0 - Complete PPT Package  
**Status:** Ready for Presentation ✅

**🎯 GOOD LUCK WITH YOUR PRESENTATION!** 🚀
