# 🚀 QUICK START: Testing Notification System

**Created:** 6 November 2025  
**Feature:** Real-Time Notification + Voice Alert System

---

## ⚡ PERSIAPAN AWAL

### **1. Pastikan Migrations Sudah Dijalankan**

```bash
php artisan migrate
```

✅ Output harus menunjukkan:
- `2025_11_06_160349_create_materi_table` - DONE
- `2025_11_06_163614_create_notifications_table` - DONE

---

### **2. Pastikan Server Running**

```bash
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

---

### **3. Buka Browser dengan Sound Enabled**

Pastikan:
- ✅ Volume browser tidak mute
- ✅ Browser mendukung Web Audio API (Chrome, Firefox, Edge, Safari)
- ✅ Notification permission akan diminta (klik "Allow")

---

## 🎬 SCENARIO TESTING 1: Voice Alert untuk Guru BK

### **Objective:**
Verify bahwa Guru BK mendapat voice feedback saat input materi berhasil.

### **Steps:**

1. **Login sebagai Guru BK**
   ```
   URL: http://127.0.0.1:8000/login
   Email: guru_bk@test.com (sesuai database Anda)
   Password: password
   ```

2. **Navigate ke Materi Page**
   ```
   URL: http://127.0.0.1:8000/guru_bk/materi
   ```

3. **Klik "Tambah Data"**
   ```
   URL: http://127.0.0.1:8000/guru_bk/materi/create
   ```

4. **Isi Form dengan Data Sample:**
   ```
   Jenis Konten: Artikel
   Judul: Membangun Kepercayaan Diri
   Konten: [Isi bebas, minimal 50 karakter]
   Thumbnail: [Upload gambar, atau skip]
   Kategori: Motivasi
   Target Kelas: Semua Kelas
   ```

5. **Klik "Simpan"**

### **Expected Results:**

✅ **Visual:**
- Redirect ke `/guru_bk/materi`
- Flash message hijau muncul: "Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!"
- Message dengan animasi slide down

✅ **Audio:**
- **Success Sound** terdengar (3 nada naik: 600Hz → 900Hz → 1200Hz)
- Durasi: ~0.6 detik
- Volume: sedang (30%)

✅ **Voice:**
- **Text-to-Speech** berbicara dalam Bahasa Indonesia
- Message: "Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!"
- Suara: default system voice (female/male tergantung OS)
- Delay: ~300ms setelah success sound

✅ **Database:**
```sql
-- Check di database
SELECT * FROM materi ORDER BY id DESC LIMIT 1;
-- Harus ada record baru

SELECT * FROM notifications WHERE type = 'materi' ORDER BY id DESC;
-- Harus ada notifications untuk SEMUA siswa
```

### **Troubleshooting:**

❌ **Sound tidak terdengar?**
- Klik di halaman dulu (browser autoplay policy)
- Check volume browser/system
- Open console: ada error?

❌ **Voice tidak berbicara?**
- Tunggu 1-2 detik (voice loading)
- Check console: `speechSynthesis.getVoices()`
- Try di browser lain (Chrome recommended)

---

## 📱 SCENARIO TESTING 2: Real-Time Notification untuk Siswa

### **Objective:**
Verify bahwa Siswa mendapat notifikasi real-time saat Guru BK input materi.

### **Steps:**

1. **Buka Browser Baru / Incognito Mode**
   ```
   Kenapa? Agar bisa login sebagai user berbeda (Guru BK + Siswa)
   ```

2. **Login sebagai Siswa**
   ```
   URL: http://127.0.0.1:8000/login
   Email: siswa@test.com (sesuai database Anda)
   Password: password
   ```

3. **Navigate ke Dashboard atau Materi Page**
   ```
   URL: http://127.0.0.1:8000/student/dashboard
   atau: http://127.0.0.1:8000/student/materi
   ```

4. **Biarkan Browser Tetap Terbuka**
   ```
   Jangan close tab siswa!
   ```

5. **Dari Browser Guru BK: Input Materi Baru**
   ```
   Ikuti steps dari Scenario 1
   ```

6. **Tunggu Maksimal 30 Detik**
   ```
   Polling interval: 30 seconds
   Real-time broadcasting: instant (jika configured)
   ```

### **Expected Results:**

✅ **Browser Notification (Desktop/Mobile Push):**
- **Title:** "Materi Baru Tersedia!"
- **Body:** "Guru BK telah menambahkan materi baru: [Judul Materi] - Kategori: [Kategori]"
- **Icon:** Thumbnail materi (atau default logo)
- **Action:** Klik → navigate to materi detail

✅ **In-App Toast Notification:**
- Slide in dari kanan
- Background: putih dengan border hijau
- Icon: 📚 (book icon)
- Title: "Materi Baru Tersedia!"
- Message: Detail materi
- Close button: ✕
- Auto-dismiss: 5 detik
- Hover effect: elevate shadow

✅ **Sound Alert:**
- Notification bell sound (800Hz → 1000Hz)
- Durasi: ~0.5 detik
- Volume: sedang (30%)

✅ **Voice Announcement (Optional):**
- TTS berbicara (tergantung browser notification settings)
- Message: "Materi baru tersedia: [Judul]"

✅ **Notification Badge:**
- Counter badge muncul di navbar (jika ada icon notification)
- Angka bertambah: 1, 2, 3...
- Badge merah dengan animasi pulse

✅ **Console Logs:**
```javascript
🔔 Initializing Notification Manager...
✅ Notification Manager initialized
🔄 Polling started (every 30s)
📬 New notifications found: [...]
```

✅ **Database:**
```sql
SELECT * FROM notifications 
WHERE user_id = [siswa_id] 
  AND type = 'materi'
  AND is_read = 0
ORDER BY created_at DESC;
-- Harus ada record baru untuk siswa ini
```

### **Troubleshooting:**

❌ **Notification tidak muncul setelah 30 detik?**

**Check 1: Browser Console**
```javascript
// Buka Developer Tools (F12)
// Tab: Console
// Expected logs:
✅ "Notification Manager initialized"
✅ "Polling started"

// If error:
❌ "Failed to check notifications" → Check API endpoint
❌ "Unauthorized" → User tidak login
```

**Check 2: API Endpoint**
```
Manual test di browser:
http://127.0.0.1:8000/api/notifications/check-new

Expected response:
{
  "success": true,
  "has_new": true/false,
  "count": 0,
  "notifications": [...]
}
```

**Check 3: Database**
```sql
-- Apakah notifikasi tercipta?
SELECT COUNT(*) FROM notifications WHERE type = 'materi';

-- Jika 0, check MateriController apakah fire event berhasil
```

**Check 4: User Role**
```sql
-- Pastikan user adalah siswa
SELECT id, name, role FROM users WHERE id = [your_siswa_id];
-- role harus = 'siswa'
```

---

## 🔄 SCENARIO TESTING 3: Polling Mechanism

### **Objective:**
Verify polling bekerja dengan baik sebagai fallback.

### **Steps:**

1. **Login sebagai Siswa**
2. **Open Browser Console (F12)**
3. **Lihat Console Logs:**

```javascript
// Setiap 30 detik, harus ada log:
🔄 Checking for new notifications...

// Jika ada notifikasi baru:
📬 New notifications found: [{...}]
```

4. **Monitor Network Tab:**
   - Filter by: `XHR` atau `Fetch`
   - Setiap 30 detik, request ke: `/api/notifications/check-new`
   - Status: 200 OK
   - Response time: < 500ms

### **Expected Results:**

✅ **Polling Active:**
- Request setiap 30 detik
- Response JSON valid
- No errors in console

✅ **New Notification Detection:**
- Detect notifications created dalam 2 menit terakhir
- Trigger notification handler automatically

---

## 🎵 SCENARIO TESTING 4: Sound & Voice Settings

### **Objective:**
Test sound dan voice dapat di-toggle.

### **Steps:**

1. **Login sebagai Siswa**
2. **Open Browser Console**
3. **Test Sound:**

```javascript
// Play sound manually
window.notificationManager.notificationSound.play();
// Harus terdengar notification bell

// Toggle sound off
window.notificationManager.toggleSound();
// Return: false

// Toggle sound on
window.notificationManager.toggleSound();
// Return: true
```

4. **Test Voice:**

```javascript
// Test TTS manually
const utterance = new SpeechSynthesisUtterance('Halo, ini adalah tes suara');
utterance.lang = 'id-ID';
speechSynthesis.speak(utterance);
// Harus terdengar suara berbicara
```

---

## 🔐 SCENARIO TESTING 5: Browser Permission

### **Objective:**
Test browser notification permission flow.

### **Steps:**

1. **First Load (Permission Not Granted):**
   - Siswa login pertama kali
   - Browser akan minta permission: "Allow notifications?"
   - Expected: Permission dialog muncul

2. **Permission Granted:**
   - Klik "Allow"
   - Browser notification akan enabled
   - Test dengan input materi baru

3. **Permission Denied:**
   - Klik "Block" atau "Deny"
   - Browser notification tidak muncul
   - In-app toast masih berfungsi
   - Sound & voice masih berfungsi

4. **Reset Permission:**
   ```
   Chrome: Settings → Site Settings → Notifications → Find your site → Reset
   Firefox: Padlock icon → Permissions → Clear
   ```

---

## 📊 SCENARIO TESTING 6: Multiple Students

### **Objective:**
Verify semua siswa mendapat notifikasi.

### **Setup:**

```sql
-- Pastikan ada beberapa siswa di database
SELECT id, name, email, role FROM users WHERE role = 'siswa';
```

### **Steps:**

1. **Login sebagai Guru BK** → Input materi baru
2. **Check Database:**

```sql
-- Count notifications created
SELECT 
    COUNT(*) as total_notifications,
    COUNT(DISTINCT user_id) as total_students
FROM notifications 
WHERE type = 'materi'
  AND created_at >= NOW() - INTERVAL 1 MINUTE;

-- Expected: 
-- total_notifications = total_students = jumlah siswa
```

3. **Login Sebagai Siswa 1, 2, 3...**
   - Semua harus terima notifikasi
   - Each notification independent (mark as read tidak affect others)

---

## 🐛 COMMON ISSUES & SOLUTIONS

### **Issue 1: "Failed to check notifications"**

**Cause:** API endpoint tidak accessible  
**Solution:**
```bash
# Check routes
php artisan route:list | grep notifications

# Expected routes:
GET|HEAD  api/notifications/check-new
GET|HEAD  api/notifications/count
GET|HEAD  api/notifications/unread
POST      api/notifications/read-all
POST      api/notifications/{id}/read
```

---

### **Issue 2: Notifications created but not received**

**Cause:** User ID mismatch  
**Solution:**
```javascript
// Check logged-in user in console
console.log('User ID:', {{ auth()->id() }});

// Check notifications for this user
// URL: /api/notifications/unread
```

---

### **Issue 3: Sound plays but no voice**

**Cause:** Voice not loaded yet  
**Solution:**
```javascript
// Wait for voices to load
speechSynthesis.onvoiceschanged = () => {
    console.log('Voices loaded:', speechSynthesis.getVoices());
};

// Or add delay before speaking
setTimeout(() => {
    speechSynthesis.speak(utterance);
}, 1000);
```

---

### **Issue 4: Browser notification permission not showing**

**Cause:** HTTPS required (some browsers)  
**Solution:**
- Use `localhost` (always works)
- Or use ngrok/local tunnel for HTTPS
- Or test in Chrome (less strict)

---

## ✅ CHECKLIST FINAL

### **Backend:**
- [ ] Migrations run successfully
- [ ] `materi` table exists
- [ ] `notifications` table exists
- [ ] API routes accessible
- [ ] MateriController fires event
- [ ] NotificationService creates notifications

### **Frontend:**
- [ ] `notification-manager.js` loaded
- [ ] `notification.js` (sound) loaded
- [ ] `notifications.css` loaded
- [ ] Polling initialized (check console)
- [ ] No JavaScript errors

### **Guru BK Features:**
- [ ] Voice feedback on materi creation
- [ ] Success sound plays
- [ ] Flash message displays
- [ ] Materi saved to database

### **Siswa Features:**
- [ ] Browser notification appears
- [ ] In-app toast slides in
- [ ] Notification sound plays
- [ ] Voice announcement (optional)
- [ ] Badge counter updates
- [ ] Click notification → navigate to materi

### **Database:**
- [ ] Notifications created for all students
- [ ] Notification type = 'materi'
- [ ] Related ID points to materi
- [ ] Timestamps correct

---

## 🎯 SUCCESS CRITERIA

✅ **System is working if:**

1. Guru BK input materi → **hears voice + sound**
2. Siswa receives notification dalam **≤ 30 seconds**
3. **All notification types** work (browser + in-app + sound + voice)
4. **Database records** created correctly
5. **No console errors**

---

## 📞 NEED HELP?

**Check Documentation:**
- `NOTIFICATION_SYSTEM_DOCUMENTATION.md` - Full technical docs
- `BACKEND_MATERI_DOCUMENTATION.md` - Materi system docs

**Debug Commands:**
```bash
# Check migrations
php artisan migrate:status

# View logs
tail -f storage/logs/laravel.log

# Check routes
php artisan route:list

# Clear cache
php artisan optimize:clear
```

**Browser Debug:**
```javascript
// Check notification manager
console.log(window.notificationManager);

// Test sound
window.notificationManager.notificationSound.play();

// Test voice
speechSynthesis.speak(new SpeechSynthesisUtterance('Test'));

// Check polling
window.notificationManager.checkForNewNotifications();
```

---

## 🎉 READY TO TEST!

**Mulai dari Scenario 1 dan ikuti step by step.**

Jika ada masalah, check Troubleshooting section atau console logs untuk detail error.

**Good luck! 🚀**
