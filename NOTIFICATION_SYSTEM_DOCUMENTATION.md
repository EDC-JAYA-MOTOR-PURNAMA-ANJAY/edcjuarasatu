# 🔔 SISTEM NOTIFIKASI REAL-TIME + VOICE ALERT

**Project:** Educounsel - Sistem Bimbingan Konseling  
**Feature:** Real-Time Notification System dengan Voice Alert  
**Last Updated:** 6 November 2025

---

## 📋 OVERVIEW

Sistem notifikasi lengkap yang memberikan **notifikasi real-time** kepada siswa ketika Guru BK menginputkan materi baru, dengan dukungan:

✅ **Real-Time Broadcasting** (Laravel Echo + Pusher/Reverb)  
✅ **Polling Fallback** (AJAX every 30 seconds)  
✅ **Voice Alert** (Text-to-Speech notification)  
✅ **Sound Notification** (Web Audio API)  
✅ **Browser Notification** (Push Notifications)  
✅ **In-App Toast** (Visual notification)  
✅ **Database Persistence** (Notification history)

---

## 🎯 FITUR UTAMA

### **1️⃣ Untuk Guru BK**

- ✅ **Voice Feedback** saat berhasil menginputkan materi
- ✅ **Success Sound** (pleasant chime)
- ✅ **Text-to-Speech** membacakan pesan sukses
- ✅ **Visual Alert** (flash message dengan animasi)

### **2️⃣ Untuk Siswa**

- ✅ **Real-Time Notification** (instant, tanpa refresh)
- ✅ **Polling Fallback** (jika broadcasting tidak tersedia)
- ✅ **Sound Alert** (notification chime)
- ✅ **Voice Announcement** (Text-to-Speech membacakan notifikasi)
- ✅ **Browser Notification** (desktop/mobile push notification)
- ✅ **In-App Toast** (visual notification di dalam aplikasi)
- ✅ **Notification Badge** (counter unread notifications)
- ✅ **Notification History** (daftar semua notifikasi)

---

## 🗄️ DATABASE SCHEMA

### **Table: `notifications`**

```sql
CREATE TABLE `notifications` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `type` VARCHAR(50) NOT NULL, -- 'materi', 'counseling', 'questionnaire'
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL, -- Siswa penerima
    `related_id` BIGINT UNSIGNED NULL, -- ID materi/etc
    `related_type` VARCHAR(255) NULL, -- 'Materi', 'Konseling', etc
    `is_read` BOOLEAN DEFAULT FALSE,
    `read_at` TIMESTAMP NULL,
    `data` JSON NULL, -- Additional metadata
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX (`user_id`, `is_read`),
    INDEX (`created_at`)
);
```

---

## 📁 FILE STRUCTURE

```
app/
├── Events/
│   └── MateriCreated.php                    ✅ Broadcasting event
├── Services/
│   └── NotificationService.php              ✅ Notification logic
├── Models/
│   └── Notification.php                     ✅ Notification model
├── Http/
│   └── Controllers/
│       ├── MateriController.php             ✅ Updated with event firing
│       └── NotificationController.php       ✅ API endpoints
│
database/
└── migrations/
    └── 2025_11_06_163614_create_notifications_table.php  ✅
│
public/
├── js/
│   └── notification-manager.js              ✅ Main notification handler
├── sounds/
│   └── notification.js                      ✅ Audio generator
└── css/
    └── notifications.css                    ✅ UI styles
│
resources/
└── views/
    └── layouts/
        └── siswa.blade.php                  ✅ Updated with notification system
│
routes/
├── web.php                                  ✅ Updated
└── api.php                                  ✅ API routes for notifications
```

---

## 🚀 HOW IT WORKS

### **Flow Diagram:**

```
Guru BK Input Materi
        ↓
MateriController@store
        ↓
[Database Transaction]
        ├──→ Create Materi Record
        ├──→ Fire Event: MateriCreated (Broadcasting)
        └──→ NotificationService: Create DB Notifications
                ↓
        ┌───────┴───────┐
        ↓               ↓
    Broadcasting    Database
    (Real-Time)     (Persistent)
        ↓               ↓
   Laravel Echo    Polling API
        ↓               ↓
        └───────┬───────┘
                ↓
        NotificationManager.js
                ↓
        ┌───────┼───────┐
        ↓       ↓       ↓
    Sound   Voice   Browser
    Alert   TTS     Notification
        ↓       ↓       ↓
    In-App Toast UI
```

---

## 🔧 COMPONENTS

### **1. MateriCreated Event** (`app/Events/MateriCreated.php`)

```php
class MateriCreated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('materi-updates');
    }

    public function broadcastAs(): string
    {
        return 'materi.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->materi->id,
            'judul' => $this->materi->judul,
            'kategori' => $this->materi->kategori,
            'guru_bk_name' => $this->materi->guruBK->name,
            // ...
        ];
    }
}
```

### **2. NotificationService** (`app/Services/NotificationService.php`)

```php
class NotificationService
{
    public function notifyStudentsAboutNewMateri($materi): void
    {
        $students = User::where('role', 'siswa')->get();

        foreach ($students as $student) {
            Notification::create([
                'type' => 'materi',
                'title' => 'Materi Baru Tersedia!',
                'message' => "Guru BK telah menambahkan materi: {$materi->judul}",
                'user_id' => $student->id,
                'related_id' => $materi->id,
                'related_type' => 'Materi',
                'data' => [...],
            ]);
        }
    }
}
```

### **3. NotificationManager.js** (`public/js/notification-manager.js`)

**Main Features:**

```javascript
class NotificationManager {
    // Initialize both broadcasting and polling
    init() {
        this.initializeBroadcasting();  // Laravel Echo
        this.startPolling();             // Fallback
    }

    // Handle new notification
    handleNewNotification(notification) {
        this.notificationSound.play();              // Sound
        this.showBrowserNotification(notification); // Browser push
        this.showInAppNotification(notification);   // Toast
        // Voice TTS handled by browser notification
    }

    // Polling every 30 seconds
    checkForNewNotifications() {
        fetch('/api/notifications/check-new')
            .then(response => response.json())
            .then(data => {
                if (data.has_new) {
                    data.notifications.forEach(n => {
                        this.handleNewNotification(n);
                    });
                }
            });
    }
}
```

---

## 🎨 UI COMPONENTS

### **1. Notification Toast**

```html
<div class="notification-toast show">
    <div class="notification-toast-icon">
        <i class="fas fa-book"></i>
    </div>
    <div class="notification-toast-content">
        <div class="notification-toast-title">Materi Baru</div>
        <div class="notification-toast-message">Guru BK telah menambahkan...</div>
    </div>
    <button class="notification-toast-close">×</button>
</div>
```

**CSS:** `public/css/notifications.css`

---

## 📡 API ENDPOINTS

### **Notification API Routes** (`routes/api.php`)

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/notifications/unread` | GET | Get all unread notifications |
| `/api/notifications/count` | GET | Get unread count |
| `/api/notifications/check-new` | GET | Check for new notifications (polling) |
| `/api/notifications/{id}/read` | POST | Mark as read |
| `/api/notifications/read-all` | POST | Mark all as read |

---

## 🎵 AUDIO FEATURES

### **1. Success Sound for Guru BK**

```javascript
// When Guru BK successfully creates materi
const audioContext = new AudioContext();
oscillator.frequency.setValueAtTime(600, currentTime);
oscillator.frequency.setValueAtTime(900, currentTime + 0.1);
oscillator.frequency.setValueAtTime(1200, currentTime + 0.2);
// Pleasant ascending chime
```

### **2. Notification Sound for Siswa**

```javascript
// Generated via Web Audio API
oscillator.frequency.setValueAtTime(800, currentTime);
oscillator.frequency.setValueAtTime(1000, currentTime + 0.1);
// Notification bell sound
```

### **3. Voice Announcement (Text-to-Speech)**

```javascript
// Guru BK
const utterance = new SpeechSynthesisUtterance('Materi berhasil ditambahkan dan notifikasi telah dikirim ke semua siswa!');
utterance.lang = 'id-ID';
speechSynthesis.speak(utterance);

// Siswa (via browser notification or in-app)
const utterance = new SpeechSynthesisUtterance('Materi baru tersedia: ' + notification.title);
speechSynthesis.speak(utterance);
```

---

## 🔐 PERMISSIONS

### **Browser Notification Permission**

```javascript
// Auto-request on page load for students
if ('Notification' in window && Notification.permission === 'default') {
    await Notification.requestPermission();
}
```

### **Audio Permission**

Web Audio API doesn't require explicit permission, but may be blocked by browser autoplay policies. User interaction (click) is required first.

---

## 🧪 TESTING

### **1. Test Materi Creation Flow**

```bash
# Step 1: Login as Guru BK
# Step 2: Navigate to /guru_bk/materi
# Step 3: Click "Tambah Data"
# Step 4: Fill form and submit
# Expected Results:
#   - Success flash message
#   - Success sound plays
#   - Voice announcement: "Materi berhasil ditambahkan..."
#   - Redirect to /guru_bk/materi
```

### **2. Test Student Notification Reception**

```bash
# Step 1: Open browser as Siswa (in different tab/incognito)
# Step 2: Login as Siswa
# Step 3: Stay on any student page
# Step 4: Guru BK creates materi (from step 1)
# Expected Results (within 30 seconds or instant if broadcasting works):
#   - Notification sound plays
#   - Browser notification appears (if permission granted)
#   - In-app toast appears
#   - Notification badge counter increases
#   - Voice announcement (optional, depends on browser)
```

### **3. Test Polling Fallback**

```bash
# If Laravel Echo is not configured:
# - System automatically falls back to polling
# - Notifications arrive within 30 seconds
# - Check browser console for "Polling started"
```

---

## ⚙️ CONFIGURATION

### **Broadcasting Configuration (Optional)**

To enable real-time broadcasting, configure `config/broadcasting.php`:

```php
'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
        ],
    ],
],
```

**.env:**
```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=ap1
```

**If you don't configure broadcasting, the system will automatically use polling fallback.**

---

## 📊 NOTIFICATION TYPES

### **Current: Materi Notifications**

```php
'type' => 'materi',
'title' => 'Materi Baru Tersedia!',
'message' => 'Guru BK telah menambahkan materi: ...',
'related_type' => 'Materi',
'related_id' => $materi->id,
```

### **Future Extensions**

You can easily add more notification types:

- **Counseling Scheduled:** `type => 'counseling'`
- **Questionnaire Available:** `type => 'questionnaire'`
- **Attendance Reminder:** `type => 'attendance'`
- **Message from Guru BK:** `type => 'message'`

---

## 🐛 TROUBLESHOOTING

### **Issue: Notifications not received**

**Check:**
1. Database: Are notifications being created? `SELECT * FROM notifications;`
2. Browser Console: Any errors?
3. Polling: Check for "Polling started" message in console
4. API: Test `/api/notifications/check-new` manually in browser

**Solution:**
- Ensure migrations are run: `php artisan migrate`
- Check if polling is working (should work even without broadcasting)
- Verify user is logged in as siswa

---

### **Issue: No sound playing**

**Check:**
1. Browser autoplay policy (sound requires user interaction first)
2. Browser console for Web Audio API errors
3. Sound enabled in NotificationManager config

**Solution:**
- Click anywhere on page first (browser requirement)
- Check `soundEnabled: true` in NotificationManager init
- Test with `notificationManager.notificationSound.play()`

---

### **Issue: No voice announcement**

**Check:**
1. Browser supports Speech Synthesis API (all modern browsers do)
2. Voices are loaded: `speechSynthesis.getVoices()`
3. Language set correctly: `utterance.lang = 'id-ID'`

**Solution:**
- Wait for voices to load (async process)
- Try different voice or fallback to default
- Check browser settings for TTS

---

## 📈 PERFORMANCE

### **Optimization:**

- ✅ Polling interval: 30 seconds (adjustable)
- ✅ Broadcast reduces server load (instant delivery)
- ✅ Index on `user_id` and `is_read` for fast queries
- ✅ Toast auto-dismiss after 5 seconds
- ✅ Cleanup old read notifications (optional cronjob)

### **Scalability:**

For large number of students, consider:
- **Queue Jobs:** Process notifications asynchronously
- **Broadcasting:** Reduce API calls with real-time updates
- **Batch Processing:** Create notifications in batches
- **Caching:** Cache unread count

---

## 🎓 USAGE EXAMPLES

### **Check Unread Count (JavaScript)**

```javascript
const count = await notificationManager.updateUnreadCount();
console.log('Unread notifications:', count);
```

### **Mark Notification as Read**

```javascript
await notificationManager.markAsRead(notificationId);
```

### **Toggle Sound**

```javascript
const isEnabled = notificationManager.toggleSound();
console.log('Sound enabled:', isEnabled);
```

### **Listen for Custom Event**

```javascript
window.addEventListener('notification:received', (event) => {
    console.log('New notification:', event.detail);
    // Custom handling
});
```

---

## ✅ CHECKLIST

### **Guru BK Features:**

- [x] Voice feedback saat input materi berhasil
- [x] Success sound (pleasant chime)
- [x] Flash message dengan animasi
- [x] Text-to-Speech announcement

### **Siswa Features:**

- [x] Real-time notification via broadcasting
- [x] Polling fallback (30s interval)
- [x] Sound alert
- [x] Voice announcement (TTS)
- [x] Browser push notification
- [x] In-app toast notification
- [x] Notification badge counter
- [x] Notification history (database)
- [x] Mark as read functionality
- [x] Click to navigate to materi

---

## 🚀 FUTURE ENHANCEMENTS

1. **Notification Preferences**
   - Allow users to toggle sound/voice
   - Choose notification types
   - Set quiet hours

2. **Rich Notifications**
   - Thumbnail preview
   - Action buttons (Read, Dismiss)
   - Inline reply

3. **Analytics**
   - Track notification open rates
   - Engagement metrics
   - Popular materi based on notification clicks

4. **Multi-Channel**
   - Email notifications
   - WhatsApp integration
   - SMS for important alerts

---

## 📞 SUPPORT

Jika ada issue atau pertanyaan:

1. Check browser console for errors
2. Test API endpoints manually
3. Verify database records
4. Check broadcasting configuration

**Everything should work out of the box with polling fallback, even without broadcasting configured!** 🎉

---

**© 2025 Educounsel - Real-Time Notification System**
