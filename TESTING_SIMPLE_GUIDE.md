# 🧪 PANDUAN TESTING PRAKTIS - EDUCOUNSEL

**Quick & Easy Testing Guide**

---

## ✅ PERSIAPAN (5 MENIT)

### **Step 1: Create Test Users via SQL**

Buka **phpMyAdmin** atau MySQL client, jalankan:

```sql
-- 1. Guru BK Test User
INSERT INTO users (nama, email, password, nis_nip, peran, status, created_at, updated_at) 
VALUES ('Guru BK Test', 'gurubk@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '198501012010011001', 'guru_bk', 'aktif', NOW(), NOW());

-- 2. Siswa Test 1
INSERT INTO users (nama, email, password, nis_nip, peran, kelas, status, created_at, updated_at) 
VALUES ('Siswa Test 1', 'siswa1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024001', 'siswa', 'XII-1', 'aktif', NOW(), NOW());

-- 3. Siswa Test 2
INSERT INTO users (nama, email, password, nis_nip, peran, kelas, status, created_at, updated_at) 
VALUES ('Siswa Test 2', 'siswa2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024002', 'siswa', 'XI-2', 'aktif', NOW(), NOW());
```

**Password untuk semua:** `password`

---

### **Step 2: Start Server**

```bash
php artisan serve
```

URL: **http://127.0.0.1:8000**

---

## 🧪 TEST 1: DASHBOARD ANALYTICS (5 MENIT)

### **Cara Test:**

1. **Buka browser:** `http://127.0.0.1:8000/guru_bk/login`
2. **Login:**
   - Email: `gurubk@test.com`
   - Password: `password`
3. **Auto-redirect ke:** `/guru_bk/dashboard`

### **Expected Results:**

✅ Dashboard loads  
✅ 4 statistics cards displayed:
   - Total Siswa
   - Total Materi  
   - Total Notifikasi
   - Engagement Rate

✅ 3 charts displayed:
   - Doughnut: Materi per Kategori
   - Pie: Materi per Jenis
   - Line: Monthly Trend

✅ Top 5 Materi table (may be empty)  
✅ Recent Activities timeline  
✅ No console errors (F12)

### **Test Export:**

1. Click "Export Data" button (purple button on trend chart)
2. File downloads: `analytics_YYYY-MM-DD.json`
3. Success alert: "✅ Data analytics berhasil diexport!"

**✅ Status:** **PASS jika dashboard loads tanpa error!**

---

## 🧪 TEST 2: FILE UPLOAD MATERI (10 MENIT)

### **Cara Test:**

1. **As Guru BK**, navigate to: `/guru_bk/materi`
2. Click **"Tambah Data"** button
3. **Fill form:**
   ```
   Jenis Konten: "File/Dokumen (PDF, Word, Excel, PowerPoint)"
   → File upload field muncul ✅
   
   Judul: "Test Materi - Konseling Karier"
   
   Konten: "Ini adalah test materi untuk file upload PDF"
   
   Upload File: 
   - Click "Pilih File"
   - Select PDF file (< 10MB)
   - File name displays: "test.pdf (X.X MB)" ✅
   
   Thumbnail: (Optional)
   
   Kategori: "Karier"
   
   Target Kelas: "Semua Kelas"
   ```

4. Click **"Simpan"**

### **Expected Results:**

✅ Page redirects to `/guru_bk/materi`  
✅ Success message: "Materi berhasil ditambahkan..."  
✅ **Voice alert plays:** "Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!"  
✅ New materi appears in list  
✅ File saved to: `storage/app/public/materi/files/`

### **Verify in Database:**

```sql
SELECT * FROM materi ORDER BY created_at DESC LIMIT 1;
```

✅ Check `file_path` column has value

**✅ Status:** **PASS jika file ter-upload dan voice alert berbunyi!**

---

## 🧪 TEST 3: REAL-TIME NOTIFICATION (10 MENIT)

### **Setup: 2 Browsers**

**Browser A (Chrome):** Guru BK  
**Browser B (Firefox/Incognito):** Siswa

### **Cara Test:**

**Step 1: Browser B (Siswa)**
1. Open: `http://127.0.0.1:8000/login`
2. Login:
   - Email: `siswa1@test.com`
   - Password: `password`
3. Navigate to: `/student/materi`
4. **KEEP THIS TAB ACTIVE!** (don't minimize)

**Step 2: Browser A (Guru BK)**
1. Login as Guru BK
2. Upload new materi (repeat Test 2 with different title)
3. Click "Simpan"

**Step 3: Watch Browser B (Siswa)**

**WAIT 30 SECONDS...**

### **Expected Results (Browser B):**

✅ **Browser Notification (top-right):**
```
Title: "Materi Baru Tersedia!"
Body: "Guru BK telah menambahkan materi baru: [title]
       📎 File PDF tersedia untuk diunduh (X.X MB)"
```

✅ **In-App Toast (slides from right):**
```
Icon: 📄
Title: "Materi Baru Tersedia!"
Message: [materi title]
File Info: "📎 PDF - X.X MB" (green)
```

✅ **Sound Alert:** Bell chime plays (~1 second)

✅ **Voice Alert (Indonesian TTS):**
```
"Materi baru tersedia: [title]. File PDF dapat diunduh."
```

✅ **Badge Counter:** 🔴 1 (increases)

### **Check Console (F12):**

```
✅ Notification system initialized for student
📬 New notifications found: [...]
🔔 Sound played
🔊 Voice: "Materi baru tersedia..."
```

**✅ Status:** **PASS jika notifikasi muncul dalam 30 detik!**

---

## 🧪 TEST 4: DOWNLOAD FILE (3 MENIT)

### **Cara Test:**

1. **As Siswa**, on `/student/materi` page
2. Find newly uploaded materi card
3. **Verify card shows:**
   ```
   ✅ Thumbnail
   ✅ Title: "Test Materi..."
   ✅ Description excerpt
   ✅ Kategori badge: "Karier"
   ✅ Jenis icon: 📄 File/Dokumen
   ✅ File info: "PDF - X.X MB" with icon
   ✅ Author: "Oleh: Guru BK Test"
   ✅ Green "Download" button
   ✅ Purple "Baca" button
   ```

4. Click **"Download"** button

### **Expected Results:**

✅ File downloads to browser's download folder  
✅ Filename: `[timestamp]_test.pdf`  
✅ File opens successfully in PDF reader  
✅ Content matches uploaded file

**✅ Status:** **PASS jika file downloaded successfully!**

---

## 🧪 TEST 5: CHATBOT REPORTS (5 MENIT)

### **Cara Test:**

1. **As Guru BK**, navigate to: `/guru_bk/chatbot/reports`

### **Expected Results:**

✅ Page loads  
✅ 4 statistics cards:
   - Total Percakapan
   - Pengguna Aktif
   - Kepuasan Pengguna
   - Rata-rata Pesan

✅ 3 charts:
   - Doughnut: Topik Percakapan
   - Bar: Efektivitas Chatbot
   - Line: Trend Mood 30 hari

✅ Table: "Siswa yang Memerlukan Perhatian"
   - Columns displayed correctly
   - Action buttons present

✅ "Export Laporan" button works

**Note:** Charts/tables may be empty if no chatbot data yet - **THIS IS NORMAL!**

**✅ Status:** **PASS jika page loads tanpa error!**

---

## 🧪 TEST 6: APPOINTMENT SYSTEM (5 MENIT)

### **Cara Test Backend:**

```bash
php artisan tinker
```

```php
use App\Models\Appointment;
use App\Models\User;

// Get users
$student = User::where('peran', 'siswa')->first();
$guruBk = User::where('peran', 'guru_bk')->first();

// Create appointment
$apt = Appointment::create([
    'student_id' => $student->id,
    'guru_bk_id' => $guruBk->id,
    'appointment_date' => now()->addDays(2)->toDateString(),
    'appointment_time' => '10:00',
    'topic' => 'Test Konsultasi',
    'student_notes' => 'Testing appointment',
    'status' => 'pending',
]);

echo "✅ Appointment created! ID: " . $apt->id . "\n";
echo "Student: " . $apt->student->nama . "\n";
echo "Guru BK: " . $apt->guruBK->nama . "\n";
echo "Status: " . $apt->status . "\n";

// Test approve
$apt->update(['status' => 'approved', 'approved_at' => now()]);
echo "✅ Status updated: " . $apt->status . "\n";

exit
```

### **Expected Results:**

✅ Appointment created  
✅ Relationships work (student, guruBK)  
✅ Status methods work  
✅ Approval workflow works

### **Test Routes (Browser):**

1. **Guru BK:** `http://127.0.0.1:8000/guru_bk/appointments`
2. **Student:** `http://127.0.0.1:8000/student/appointments`

**Expected:** Controller runs (will show "View not found" - **NORMAL! Backend works!**)

**✅ Status:** **PASS jika tinker commands sukses!**

---

## ✅ TESTING CHECKLIST

### **Quick Verification:**

- [ ] Server running (`php artisan serve`)
- [ ] Test users created (3 users)
- [ ] Storage link created
- [ ] Dashboard loads (Guru BK)
- [ ] File upload works
- [ ] Notification received (2 browsers)
- [ ] Voice alert plays
- [ ] File downloads (Siswa)
- [ ] Chatbot reports loads
- [ ] Appointment backend works (tinker)

---

## 📊 EXPECTED TEST RESULTS

| Test | Feature | Expected Result | Time |
|------|---------|-----------------|------|
| 1 | Dashboard Analytics | ✅ Loads dengan charts | 5 min |
| 2 | File Upload | ✅ Upload + voice alert | 10 min |
| 3 | Notifications | ✅ Real-time dalam 30s | 10 min |
| 4 | Download | ✅ File downloads | 3 min |
| 5 | Chatbot Reports | ✅ Page loads | 5 min |
| 6 | Appointments | ✅ Backend works | 5 min |

**Total Testing Time:** ~40 minutes

---

## 🐛 COMMON ISSUES

### **Issue 1: Notification tidak muncul**

**Check:**
- Browser tab ACTIVE (not minimized)
- Browser permissions: Allow notifications
- Console (F12): Check for errors
- Wait full 30 seconds

### **Issue 2: Voice tidak berbunyi**

**Check:**
- Browser supports Web Speech API
- System volume not muted
- Browser tab is active

### **Issue 3: File upload error**

**Check:**
- `php.ini`: `upload_max_filesize = 20M`
- Storage link exists: `php artisan storage:link`
- File < 10MB

### **Issue 4: "View not found" error**

**If on appointments routes:** **THIS IS NORMAL!**  
Backend controllers work, views not created yet.

---

## 🎯 SUCCESS CRITERIA

**All tests PASS if:**

✅ Dashboard displays charts  
✅ File uploads successfully  
✅ Notifications deliver within 30s  
✅ Voice alert plays  
✅ File downloads work  
✅ Chatbot reports page loads  
✅ Appointment backend functions (tinker)  
✅ No fatal PHP errors  
✅ No 500 errors

---

## 🎉 DONE!

**If 6/6 tests pass:** ✅ **SYSTEM WORKING PERFECTLY!**

**Ready for demo!** 🚀

---

**📝 For detailed testing:** See `TESTING_GUIDE_COMPLETE.md` (30 pages)  
**📝 For troubleshooting:** See error sections in each test

**Happy Testing! 🎉**
