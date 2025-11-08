# 🧪 TESTING GUIDE - EDUCOUNSEL PLATFORM

**Complete Testing Instructions for All Features**

---

## 📋 PRE-TESTING SETUP

### **1. Database Setup**
```bash
# Run all migrations
php artisan migrate

# Or fresh database (will reset all data!)
php artisan migrate:fresh

# Create symbolic link for file storage
php artisan storage:link
```

### **2. Create Test Users**
```bash
# Run seeder (if available)
php artisan db:seed --class=UserSeeder

# Or manually create via phpMyAdmin/MySQL:
```

```sql
-- Guru BK
INSERT INTO users (name, email, password, role, peran, status, created_at, updated_at) 
VALUES ('Guru BK Test', 'gurubk@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru_bk', 'guru_bk', 'aktif', NOW(), NOW());
-- Password: password

-- Siswa 1
INSERT INTO users (name, email, password, role, peran, kelas, status, created_at, updated_at) 
VALUES ('Siswa Test 1', 'siswa1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', 'siswa', 'XII-1', 'aktif', NOW(), NOW());

-- Siswa 2
INSERT INTO users (name, email, password, role, peran, kelas, status, created_at, updated_at) 
VALUES ('Siswa Test 2', 'siswa2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', 'siswa', 'XI-2', 'aktif', NOW(), NOW());
```

### **3. Start Server**
```bash
# Start Laravel development server
php artisan serve

# Access: http://127.0.0.1:8000
```

### **4. Browser Permissions**
- Allow **Notifications** for real-time alerts
- Allow **Microphone** for voice (if needed)
- Enable **JavaScript**
- Clear cache if needed (Ctrl+Shift+Delete)

---

## 🧪 TEST 1: DASHBOARD ANALYTICS

### **Test 1.1: View Dashboard**

**Steps:**
1. Login as Guru BK (gurubk@test.com / password)
2. You should auto-redirect to `/guru_bk/dashboard`
3. Or manually navigate to: `http://127.0.0.1:8000/guru_bk/dashboard`

**Expected Results:**
✅ Page loads successfully  
✅ 4 statistics cards displayed:
   - Total Siswa
   - Total Materi
   - Total Notifikasi
   - Engagement Rate

✅ 3 interactive charts displayed:
   - Doughnut chart (Materi per Kategori)
   - Pie chart (Materi per Jenis)
   - Line chart (Monthly Trend)

✅ Top 5 Materi table (may be empty if no data)  
✅ Recent Activities timeline  
✅ No errors in browser console (F12)

**If Empty Data:**
- This is normal for new installation
- Numbers will show "0"
- Charts will be empty
- Upload some materi first (Test 2) then come back

---

### **Test 1.2: Export Analytics**

**Steps:**
1. On dashboard, click "Export Data" button (purple, top-right of trend chart)
2. Wait for download

**Expected Results:**
✅ File downloads: `analytics_2025-11-07.json`  
✅ Success alert: "✅ Data analytics berhasil diexport!"  
✅ JSON file contains:
   ```json
   {
     "generated_at": "2025-11-07 12:10:00",
     "guru_bk_id": 1,
     "statistics": {...},
     "materi_by_kategori": {...},
     ...
   }
   ```

---

## 🧪 TEST 2: FILE UPLOAD & DOWNLOAD

### **Test 2.1: Upload PDF Materi**

**Steps:**
1. As Guru BK, navigate to `/guru_bk/materi`
2. Click "Tambah Data" button
3. Fill form:
   - **Jenis Konten:** Select "File/Dokumen (PDF, Word, Excel, PowerPoint)"
     → File upload field should appear automatically ✅
   
   - **Judul:** "Test Materi - Konseling Karier"
   
   - **Konten:** "Ini adalah materi test untuk file upload PDF testing"
   
   - **Upload File:**
     - Click "Pilih File" button
     - Select a PDF file (< 10MB)
     - File name + size should display: "test.pdf (X.X MB)" ✅
   
   - **Thumbnail:** (Optional) Upload an image
   
   - **Kategori:** "Karier"
   
   - **Target Kelas:** "Semua Kelas"

4. Click "Simpan"

**Expected Results:**
✅ Page redirects to `/guru_bk/materi`  
✅ Success flash message: "Materi berhasil ditambahkan..."  
✅ Voice alert plays: "Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!"  
✅ New materi appears in list  
✅ File stored in: `storage/app/public/materi/files/[timestamp]_test.pdf`  
✅ Database record created (check via phpMyAdmin)

**If Errors:**
- "File too large": Use file < 10MB
- "Invalid file type": Only PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT
- "Field required": Fill all mandatory fields

---

### **Test 2.2: Siswa Download File**

**Steps:**
1. **Open NEW browser tab/window** (or Incognito mode)
2. Login as Siswa (siswa1@test.com / password)
3. Navigate to `/student/materi`
4. Find the newly uploaded materi card

**Expected Results:**
✅ Materi card displayed with:
   - Thumbnail image (or default icon)
   - Title: "Test Materi - Konseling Karier"
   - Description excerpt
   - Metadata:
     * Kategori badge: "Karier"
     * Jenis icon: 📄 File/Dokumen
     * File info: "PDF - X.X MB" with download icon
   - Author: "Oleh: Guru BK Test"
   - Action buttons:
     * **Download button (GREEN)** ✅
     * Baca button (PURPLE)

5. Click "Download" button

**Expected Results:**
✅ File downloads to browser's download folder  
✅ Filename: `[timestamp]_test.pdf`  
✅ File opens successfully in PDF reader  
✅ Content matches uploaded file

---

## 🧪 TEST 3: REAL-TIME NOTIFICATIONS

### **Test 3.1: Receive Notification (2 Browsers)**

**Setup:**
- Browser A: Guru BK (logged in)
- Browser B: Siswa (logged in, on `/student/materi` page)

**IMPORTANT:** Keep Browser B visible and active during test!

**Steps:**
1. Browser B (Siswa): Stay on `/student/materi` page, **keep tab active**
2. Browser A (Guru BK): Upload new materi (repeat Test 2.1 with different title)
3. Wait max **30 seconds**
4. Observe Browser B (Siswa)

**Expected Results (Browser B):**

✅ **A) Browser Notification (Top-right corner):**
```
Title: "Materi Baru Tersedia!"
Body: "Guru BK telah menambahkan materi baru: 
       'Test Materi 2' - Kategori: Karier
       📎 File PDF tersedia untuk diunduh (X.X MB)"
Icon: Thumbnail atau logo
Duration: 7 seconds
```

✅ **B) In-App Toast (Slides from right):**
```
Icon: 📄 (file icon)
Title: "Materi Baru Tersedia!"
Message: "Test Materi 2"
File Info: "📎 PDF - X.X MB" (green color)
Duration: 7 seconds
Close button: X
```

✅ **C) Sound Alert:**
- Bell chime plays (3 tones crescendo)
- Duration: ~1 second

✅ **D) Voice Alert (Text-to-Speech):**
- Voice says (Indonesian):
  "Materi baru tersedia: Test Materi 2. File PDF dapat diunduh."
- Rate: Normal speed
- Pitch: Slightly higher than normal
- Volume: 80%

✅ **E) Badge Counter:**
- Notification icon shows: 🔴 1
- Number increments each new notification

✅ **F) Console Logs (F12):**
```
✅ Notification system initialized for student
📬 New notifications found: [...]
🔔 Sound played
🔊 Voice: "Materi baru tersedia..."
```

**If Notification Not Received:**
- Check browser permissions (F12 → Application → Notifications: Allowed)
- Check console for errors (F12 → Console)
- Verify polling is running (should see API calls every 30s in Network tab)
- Try refreshing Browser B page
- Check that siswa user ID exists in notifications table

---

### **Test 3.2: Click Notification**

**Steps:**
1. Click the browser notification or in-app toast

**Expected Results:**
✅ Navigate to materi detail page: `/student/materi/{id}`  
✅ Full materi content displayed  
✅ Download button available  
✅ Notification marked as read (badge counter -1)

---

### **Test 3.3: Mark as Read**

**Steps:**
1. Click notification bell icon (if exists in UI)
2. View notification list
3. Click a notification

**Expected Results:**
✅ Notification style changes (grey out)  
✅ Database updated: `is_read = 1, read_at = NOW()`  
✅ Badge counter decrements

---

## 🧪 TEST 4: CHATBOT REPORTING

### **Test 4.1: View Chatbot Reports**

**Precondition:** Some chatbot conversations exist (can be dummy data)

**Steps:**
1. As Guru BK, navigate to `/guru_bk/chatbot/reports`

**Expected Results:**
✅ Page loads successfully  
✅ 4 statistics cards:
   - Total Percakapan
   - Pengguna Aktif
   - Kepuasan Pengguna
   - Rata-rata Pesan

✅ 3 charts:
   - Doughnut: Topik Percakapan
   - Bar: Efektivitas Chatbot (Satisfaction, Resolution, Escalation)
   - Line: Trend Mood 30 hari

✅ Table: "Siswa yang Memerlukan Perhatian"
   - Columns: Nama, Kelas, Percakapan, Masalah, Mood, Prioritas, Aktivitas, Aksi
   - Priority badges: High (red), Medium (yellow), Low (blue)
   - "Lihat Riwayat" button for each student

✅ Export button: "Export Laporan"

**If Empty:**
- Tables/charts will be empty (no data yet)
- This is normal for new installation
- Chatbot conversations need to exist first

---

### **Test 4.2: Export Chatbot Report**

**Steps:**
1. On chatbot reports page, click "Export Laporan" button
2. Wait for download

**Expected Results:**
✅ File downloads: `chatbot-report-2025-11-07.json`  
✅ Success alert: "✅ Laporan berhasil diexport!"  
✅ JSON contains:
   ```json
   {
     "generated_at": "...",
     "overview": {...},
     "topics": {...},
     "mood_trend": {...},
     "students_needing_attention": [...],
     ...
   }
   ```

---

## 🧪 TEST 5: APPOINTMENT SYSTEM

### **Test 5.1: Student Book Appointment**

**Steps:**
1. As Siswa, navigate to `/student/appointments` or `/student/konseling/book`
2. Fill booking form:
   - **Date:** Tomorrow's date
   - **Time:** 10:00
   - **Topic:** "Konsultasi Karier"
   - **Notes:** "Ingin diskusi tentang pilihan universitas"
3. Click "Submit" or "Book Appointment"

**Expected Results:**
✅ Form validates (date cannot be past, time must be valid)  
✅ Appointment created with status: "pending"  
✅ Redirect to success page or appointment list  
✅ Success message: "Appointment berhasil dibuat, menunggu approval Guru BK"  
✅ Database record created in `appointments` table  
✅ (Optional) Email notification sent to Guru BK

---

### **Test 5.2: Guru BK Approve Appointment**

**Steps:**
1. As Guru BK, navigate to `/guru_bk/appointments` or calendar view
2. See pending appointments list
3. Click appointment to view details
4. Click "Approve" button

**Expected Results:**
✅ Status changes to "approved"  
✅ `approved_at` timestamp recorded  
✅ Success message: "Appointment telah diapprove"  
✅ (Optional) Notification sent to student  
✅ (Optional) SMS/Email sent to student

---

### **Test 5.3: View Calendar**

**Steps:**
1. As Guru BK, navigate to calendar view (`/guru_bk/appointments/calendar`)

**Expected Results:**
✅ Calendar displays (month/week/day view)  
✅ Appointments shown on respective dates  
✅ Color-coded by status:
   - Pending: Yellow
   - Approved: Green
   - Completed: Blue
✅ Click appointment → View details  
✅ Empty slots are clickable (for manual booking)

---

## 🧪 TEST 6: STUDENT PROFILE

### **Test 6.1: View Student Profile (Guru BK)**

**Steps:**
1. As Guru BK, navigate to `/guru_bk/students` or `/guru_bk/siswa`
2. Click a student name
3. View profile page

**Expected Results:**
✅ Student information displayed:
   - Photo
   - Name, Class, NISN
   - Contact info
   - Academic data

✅ Tabs/Sections:
   - **Counseling History:** List of past appointments
   - **Chatbot Conversations:** Summary of AI chats
   - **Progress Tracking:** Timeline of development
   - **Documents:** Uploaded files (if any)
   - **Guru BK Notes:** Private notes

✅ Action buttons:
   - Create Appointment
   - View Full Chat History
   - Add Note
   - Export Profile

---

### **Test 6.2: Add Guru BK Note**

**Steps:**
1. On student profile page, find "Guru BK Notes" section
2. Click "Add Note" button
3. Fill:
   - **Note Type:** "Behavioral", "Academic", "Personal", etc.
   - **Content:** "Student shows improvement in..."
   - **Private:** Checkbox (yes/no - visible to student or not)
4. Click "Save Note"

**Expected Results:**
✅ Note saved to database  
✅ Note appears in student profile  
✅ Timestamp recorded  
✅ If not private, student can see it in their profile

---

## 🧪 INTEGRATION TESTS

### **Test 7: End-to-End Flow**

**Scenario:** Student has issue → Uses chatbot → Books appointment → Gets counseling

**Steps:**
1. **Siswa:** Login, go to AI Companion
2. **Siswa:** Chat about "Stress ujian"
3. **System:** AI responds, detects issue, suggests booking appointment
4. **Siswa:** Click "Book Appointment" from chatbot suggestion
5. **Siswa:** Fill booking form, submit
6. **Guru BK:** Login, check dashboard → See notification "New appointment request"
7. **Guru BK:** Go to chatbot reports → See student in "Need Attention" table
8. **Guru BK:** Click "View History" → See complete chat transcript
9. **Guru BK:** Go to appointments → Approve the appointment
10. **Siswa:** Receive notification "Appointment approved for [date] [time]"
11. **After Meeting:** Guru BK marks appointment as "completed", adds notes
12. **Guru BK:** View student profile → See complete history (chat + appointment + notes)

**Expected Results:**
✅ Seamless flow from chatbot → appointment → counseling  
✅ All data properly linked (student → conversations → appointments)  
✅ Guru BK has complete context before meeting  
✅ Student profile shows comprehensive history

---

## 🐛 TROUBLESHOOTING

### **Issue: "Base table or view not found"**
**Solution:**
```bash
php artisan migrate
```

### **Issue: "File upload failed" or "The file field is required"**
**Solution:**
- Check `php.ini` settings:
  ```ini
  upload_max_filesize = 20M
  post_max_size = 20M
  ```
- Restart server: `php artisan serve`

### **Issue: "404 Not Found" for storage files**
**Solution:**
```bash
php artisan storage:link
# Verify: ls -la public/storage (should show link to ../storage/app/public)
```

### **Issue: Notifications not working**
**Solution:**
1. Check browser permissions (Allow notifications)
2. Check console for JavaScript errors (F12)
3. Verify `notification-manager.js` is loaded
4. Check API endpoint `/api/notifications/check-new` returns data

### **Issue: Charts not displaying**
**Solution:**
1. Verify Chart.js CDN is loading (check Network tab)
2. Check console for errors
3. Ensure data is passed correctly from controller to view

### **Issue: Voice alert not playing**
**Solution:**
1. Check browser supports Web Speech API
2. System volume not muted
3. Browser tab is active (some browsers block audio on inactive tabs)
4. Try manual test in console:
   ```javascript
   const utterance = new SpeechSynthesisUtterance('Test');
   utterance.lang = 'id-ID';
   window.speechSynthesis.speak(utterance);
   ```

---

## ✅ TEST CHECKLIST

**Before Presentation:**
- [ ] Database migrated successfully
- [ ] Test users created (Guru BK + 2 Siswa)
- [ ] Server running (php artisan serve)
- [ ] Storage link created (php artisan storage:link)
- [ ] Browser notifications enabled
- [ ] At least 2-3 materi uploaded (with files)
- [ ] Dashboard shows data (not all zeros)
- [ ] Notification system tested (2 browsers)
- [ ] File download working
- [ ] Charts displaying correctly
- [ ] Chatbot reports accessible
- [ ] No console errors (F12)

**During Demo:**
- [ ] Prepare sample files (PDF < 10MB)
- [ ] 2 browsers open (Guru BK + Siswa)
- [ ] Network stable
- [ ] Volume on for voice alerts
- [ ] Close unnecessary tabs (performance)

---

## 📊 PERFORMANCE BENCHMARKS

**Expected Load Times:**
- Dashboard: < 2 seconds
- Materi list: < 1 second
- File upload: < 3 seconds (for 5MB file)
- Notification delivery: < 30 seconds (polling) or instant (broadcasting)
- Chart rendering: < 1 second

**If Slower:**
- Clear browser cache
- Check server resources
- Optimize database queries
- Add indexes to frequently queried columns

---

## 🎯 SUCCESS CRITERIA

**All Tests Pass If:**
✅ No fatal PHP errors  
✅ No 404 errors  
✅ No JavaScript console errors  
✅ All CRUD operations work  
✅ File upload & download functional  
✅ Notifications deliver within 30 seconds  
✅ Voice alerts play  
✅ Charts render correctly  
✅ Database records created properly  
✅ User experience is smooth

---

**🎉 Testing Complete! Ready for Demo!**

**Estimated Testing Time:** 30-45 minutes for full suite  
**Quick Test:** 10 minutes (Dashboard + File Upload + Notification)

**Good luck! 🚀**
