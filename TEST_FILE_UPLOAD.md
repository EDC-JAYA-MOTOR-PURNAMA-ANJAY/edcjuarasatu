# 🧪 TESTING: FILE UPLOAD FEATURE

**Quick Testing Guide - 5 Minutes**

---

## 🎯 QUICK TEST FLOW

### **Test 1: Guru BK Upload File (3 menit)**

1. **Login as Guru BK**
   ```
   URL: http://127.0.0.1:8000/guru_bk/login
   Email: gurubk@example.com
   Password: password
   ```

2. **Navigate to Materi**
   ```
   Click: Sidebar → "Materi"
   URL: /guru_bk/materi
   ```

3. **Create New Materi**
   ```
   Click: "Tambah Data" button
   URL: /guru_bk/materi/create
   ```

4. **Fill Form**
   - **Jenis Konten:** Select **"File/Dokumen (PDF, Word, Excel, PowerPoint)"**
     → File upload field akan muncul otomatis ✅
   
   - **Judul:** "Test Materi PDF - Konseling Karier"
   
   - **Konten:** "Ini adalah materi test untuk file upload PDF"
   
   - **Upload File:** 
     - Click "Pilih File"
     - Select any PDF file (< 10MB)
     - File name + size akan muncul ✅
   
   - **Thumbnail:** (Optional) Upload image
   
   - **Kategori:** "Karier"
   
   - **Target Kelas:** "Semua Kelas"

5. **Submit**
   - Click "Simpan"
   - **Expected Results:**
     ```
     ✅ Success message: "Materi berhasil ditambahkan..."
     ✅ Voice alert: "Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!"
     ✅ Redirect to: /guru_bk/materi
     ✅ New materi appears in list
     ```

---

### **Test 2: Siswa Receive Notification (2 menit)**

1. **Open NEW Browser Tab/Window** (or Incognito)

2. **Login as Siswa**
   ```
   URL: http://127.0.0.1:8000/login
   Email: siswa@example.com
   Password: password
   ```

3. **Go to Materi Page**
   ```
   Click: Sidebar → "Materi"
   URL: /student/materi
   ```

4. **KEEP THIS TAB OPEN**

5. **From Guru BK Tab:** Upload new file materi (repeat Test 1)

6. **Switch back to Siswa Tab**
   - **Within 30 seconds, you should see:**

   **A) Browser Notification (Top-right corner):**
   ```
   Title: Materi Baru Tersedia!
   Body: Guru BK telah menambahkan materi baru: "Test Materi PDF - Konseling Karier" - Kategori: Karier
         📎 File PDF tersedia untuk diunduh (X.X MB)
   ```

   **B) In-App Toast (Slides from right):**
   ```
   Icon: 📄 (file icon, not book)
   Title: Materi Baru Tersedia!
   Message: Test Materi PDF - Konseling Karier
   File Info: 📎 PDF - X.X MB (green color)
   ```

   **C) Voice Alert (Speaks out loud):**
   ```
   "Materi baru tersedia: Test Materi PDF - Konseling Karier. File PDF dapat diunduh."
   ```

   **D) Unread Badge:**
   ```
   Badge counter increases: 🔴 1
   ```

---

### **Test 3: Download File (1 menit)**

1. **On Siswa page** (`/student/materi`)

2. **Scroll to find new materi card**

3. **Verify Card Shows:**
   ```
   ✅ Thumbnail (or default icon)
   ✅ Title: "Test Materi PDF - Konseling Karier"
   ✅ Description: "Ini adalah materi test..."
   ✅ Kategori: "Karier"
   ✅ Jenis: "File/Dokumen" with 📄 icon
   ✅ File Info: "PDF - X.X MB" with download icon
   ✅ Author: "Oleh: [Guru BK Name]"
   ✅ Download button (GREEN) + Baca button (PURPLE)
   ```

4. **Click "Download" button**
   ```
   ✅ File downloads to your browser's download folder
   ✅ Filename: 1730123456_[original-name].pdf (timestamped)
   ✅ File opens successfully
   ```

5. **Click "Baca" button**
   ```
   ✅ Navigate to: /student/materi/{id}
   ✅ Detail page shows file info + download link
   ```

---

## ✅ SUCCESS CRITERIA

### **Backend:**
- ✅ File uploaded to `storage/app/public/materi/files/`
- ✅ Database record created with `file_path` column populated
- ✅ Notification records created for ALL students
- ✅ Event `MateriCreated` fired successfully

### **Frontend:**
- ✅ File upload field appears/disappears based on jenis selection
- ✅ File name + size displays after selection
- ✅ Form validates file type (only accepts PDF, DOC, etc.)
- ✅ Form validates file size (max 10MB)
- ✅ Success message + voice alert after submit

### **Student Experience:**
- ✅ Real-time notification received (within 30s)
- ✅ Browser notification shows file info
- ✅ In-app toast shows file icon + info
- ✅ Voice alert announces file availability
- ✅ Materi card displays file metadata
- ✅ Download button works correctly
- ✅ File downloads successfully

---

## 🐛 COMMON ISSUES & FIXES

### **Issue 1: File upload field tidak muncul**

**Problem:** Select "File/Dokumen" tapi field tidak muncul

**Solution:**
```javascript
// Check browser console for errors
// Verify JavaScript function exists:
function toggleFileUpload() { ... }

// Refresh page (Ctrl+F5)
```

---

### **Issue 2: Error "The file must be a file"**

**Problem:** Form submission fails with validation error

**Solution:**
```html
<!-- Verify form has enctype -->
<form method="POST" enctype="multipart/form-data">
```

---

### **Issue 3: Notification tidak muncul**

**Problem:** Guru BK upload sukses, tapi siswa tidak terima notifikasi

**Solution A - Check Database:**
```sql
SELECT * FROM notifications WHERE type = 'materi' ORDER BY created_at DESC LIMIT 1;
-- Should show new notification with file info in 'data' JSON
```

**Solution B - Check JavaScript Console (Student page):**
```javascript
// Should see:
✅ Notification system initialized for student
✅ Polling started (every 30 seconds)
📬 New notifications found: [...]
🔔 Sound played
```

**Solution C - Check Browser Permissions:**
```
1. Click 🔒 icon in address bar
2. Notifications: Allow
3. Sound: Allow
4. Refresh page
```

---

### **Issue 4: File 404 saat download**

**Problem:** Click download button → 404 error

**Solution:**
```bash
# Create symbolic link
cd c:\xampp\htdocs\edcjuarasatu
php artisan storage:link

# Verify link exists
dir public\storage
# Should show: <SYMLINKD> storage [..\..\storage\app\public]
```

---

### **Issue 5: Voice tidak berbunyi**

**Problem:** Notification muncul tapi tidak ada suara voice

**Solution:**
```javascript
// Check browser support
console.log('Speech Synthesis:', 'speechSynthesis' in window); // Should be true

// Check volume
// Make sure browser/system volume is not muted

// Try manual test
const utterance = new SpeechSynthesisUtterance('Test voice');
utterance.lang = 'id-ID';
window.speechSynthesis.speak(utterance);
```

---

## 📊 EXPECTED DATABASE STATE

### **After Upload:**

```sql
-- Materi table
SELECT id, jenis, judul, file_path, thumbnail, status 
FROM materi 
WHERE jenis = 'File/Dokumen' 
ORDER BY created_at DESC 
LIMIT 1;

-- Expected output:
id | jenis         | judul                    | file_path                           | thumbnail | status
---|---------------|--------------------------|-------------------------------------|-----------|-------
23 | File/Dokumen  | Test Materi PDF - Kon... | materi/files/1730123456_test.pdf   | ...       | Aktif
```

```sql
-- Notifications table
SELECT id, type, title, message, user_id, related_id, data 
FROM notifications 
WHERE type = 'materi' AND related_id = 23;

-- Expected output:
-- Multiple records (one per student)
-- 'data' JSON should include:
{
    "materi_id": 23,
    "materi_judul": "Test Materi PDF - Konseling Karier",
    "materi_kategori": "Karier",
    "materi_jenis": "File/Dokumen",
    "guru_bk_name": "Guru BK",
    "thumbnail_url": "http://...",
    "has_file": true,
    "file_extension": "PDF",
    "file_size": "2.5 MB",
    "file_url": "/storage/materi/files/1730123456_test.pdf"
}
```

---

## 🎯 PERFORMANCE CHECK

### **File Upload Speed:**
- **< 1MB:** < 1 second
- **1-5 MB:** 1-3 seconds
- **5-10 MB:** 3-7 seconds

### **Notification Delivery:**
- **With Broadcasting (Laravel Echo):** Instant (< 1 second)
- **With Polling:** Up to 30 seconds (configurable)

### **Voice Announcement:**
- **Starts:** 500ms after toast appears
- **Duration:** 3-5 seconds (depends on text length)
- **Language:** Indonesian (id-ID)

---

## ✅ FINAL CHECKLIST

**Before Going Live:**

- [ ] Run migration: `php artisan migrate`
- [ ] Create storage link: `php artisan storage:link`
- [ ] Test with real PDF file (< 10MB)
- [ ] Test with Word document (.docx)
- [ ] Test with Excel file (.xlsx)
- [ ] Test with PowerPoint (.pptx)
- [ ] Test file > 10MB (should be rejected)
- [ ] Test invalid file type (e.g., .exe, .zip) → should fail validation
- [ ] Test without thumbnail → should use default icon
- [ ] Test notification on multiple student accounts
- [ ] Test voice alert in different browsers
- [ ] Verify file downloads correctly
- [ ] Verify file path stored in database
- [ ] Check server disk space (for file storage)

---

## 🚀 READY!

**Jika semua test di atas PASS:**
✅ Feature is production-ready!
✅ Guru BK can upload files
✅ Siswa receive notifications
✅ Files can be downloaded
✅ Voice alerts work
✅ Everything integrated!

**Estimated Testing Time:** 5-10 minutes total

---

**Happy Testing! 🎉**
