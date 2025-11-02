# 🔒 TESTING GUIDE - Rate Limiting dengan Countdown Timer

## 📋 Fitur yang Diimplementasikan

### ✅ **Rate Limiting Protection**
- Max 5 percobaan login gagal
- Auto-block selama **30 detik** setelah 5x gagal
- Countdown timer real-time
- Warning message progresif

### ✅ **Visual Feedback**
- 🔴 **Throttle Warning Box** - Muncul saat diblokir
- ⏱️ **Countdown Timer** - Hitung mundur 30 detik
- 🔒 **Disabled Form** - Form tidak bisa disubmit saat diblokir
- ⚠️ **Alert Modal** - Peringatan jika paksa login saat diblokir
- ✅ **Success Message** - Notifikasi saat akun dibuka kembali

### ✅ **User Experience**
- Sisa percobaan ditampilkan mulai percobaan ke-3
- Form inputs disabled saat throttled
- Button berubah jadi "🔒 Diblokir"
- Countdown dengan efek pulse di 10 detik terakhir
- Shake animation pada warning box

---

## 🧪 CARA TESTING

### **Test 1: Rate Limiting Basic (2 menit)**

#### **Langkah:**
1. Buka browser → `http://localhost/login`
2. Masukkan email: `admin@educounsel.com`
3. Masukkan password SALAH: `wrongpassword`
4. Klik "Log in" **5 KALI**

#### **Expected Results:**

**Percobaan 1-2:**
```
❌ Email atau password yang Anda masukkan salah.
```

**Percobaan 3:**
```
❌ Email atau password yang Anda masukkan salah. 
   Sisa percobaan: 2x. Setelah 5x gagal, akun akan diblokir 30 detik.
```

**Percobaan 4:**
```
❌ Email atau password yang Anda masukkan salah. 
   Sisa percobaan: 1x. Setelah 5x gagal, akun akan diblokir 30 detik.
```

**Percobaan 5:**
```
🚨 THROTTLE WARNING MUNCUL!

┌─────────────────────────────────────────┐
│ ⚠️ Akun Diblokir Sementara            │
│                                          │
│ Terlalu banyak percobaan login gagal.   │
│ Akun Anda diblokir untuk melindungi     │
│ keamanan.                                │
│                                          │
│ 🕐 Coba lagi dalam: 30 detik            │
└─────────────────────────────────────────┘

✅ Form inputs DISABLED (abu-abu)
✅ Button berubah jadi "🔒 Diblokir"
✅ Countdown mulai dari 30 → 29 → 28 ... → 0
```

---

### **Test 2: Countdown Timer (30 detik)**

#### **Langkah:**
1. Setelah diblokir, **tunggu dan perhatikan**:
   - Timer countdown dari 30 detik
   - Di 10 detik terakhir, timer akan **pulse**
   - Form tetap disabled selama countdown

#### **Expected Results:**

```
⏱️ 30 → 29 → 28 → ... → 11 → 10 (mulai pulse) → 9 → ... → 1 → 0

Saat countdown = 0:
✅ Warning box HILANG
✅ Form inputs ENABLED kembali
✅ Button kembali jadi "Log in"
✅ Success message muncul: "Akun telah dibuka kembali. Silakan login."
```

---

### **Test 3: Forced Login Warning (PENTING!)**

#### **Langkah:**
1. Setelah diblokir (countdown masih jalan)
2. **Coba klik button "🔒 Diblokir"** atau tekan Enter

#### **Expected Results:**

```
⚠️ ALERT MUNCUL:

┌──────────────────────────────────────┐
│ ⚠️ PERINGATAN!                      │
│                                      │
│ Akun Anda sedang diblokir sementara │
│ karena terlalu banyak percobaan      │
│ login gagal.                         │
│                                      │
│ Harap tunggu hingga countdown       │
│ selesai sebelum mencoba login        │
│ kembali.                             │
│                                      │
│ Ini adalah fitur keamanan untuk     │
│ melindungi akun Anda.                │
└──────────────────────────────────────┘

✅ Warning box SHAKE (goyang)
✅ Form TIDAK submit
✅ Countdown tetap jalan
```

---

### **Test 4: Login Success After Unblock**

#### **Langkah:**
1. Tunggu countdown sampai 0
2. Success message muncul
3. Masukkan credentials BENAR:
   - Email: `admin@educounsel.com`
   - Password: `admin123`
4. Klik "Log in"

#### **Expected Results:**
```
✅ Login BERHASIL
✅ Redirect ke dashboard admin
✅ Session created
✅ Rate limiter CLEARED
```

---

## 📊 VISUAL INDICATORS

### **Status Normal**
```
┌────────────────────┐
│  Email: [_______] │
│  Password: [____] │
│  [  Log in  ]     │
└────────────────────┘
```

### **Status Throttled**
```
┌─────────────────────────────────┐
│ 🚨 WARNING BOX (merah)          │
│ Coba lagi dalam: 25 detik       │
└─────────────────────────────────┘

┌────────────────────┐
│  Email: [DISABLED] │ ← Abu-abu
│  Password: [____]  │ ← Abu-abu
│  [🔒 Diblokir]     │ ← Disabled
└────────────────────┘
```

### **Countdown Stages**
```
30-11 detik: Normal countdown
10-1 detik:  PULSE animation (berkedip)
0 detik:     Success message + form enabled
```

---

## 🔍 LOG MONITORING

### **View Logs Real-time:**
```powershell
# Windows PowerShell
Get-Content storage\logs\laravel.log -Tail 20 -Wait

# Or one-time check
Get-Content storage\logs\laravel.log -Tail 50
```

### **Expected Log Entries:**

#### **Failed Login (1-4):**
```
[2025-11-01 15:30:01] local.WARNING: Failed login attempt 
{
    "email":"admin@educounsel.com",
    "ip":"127.0.0.1",
    "attempts":1,
    "remaining":4
}
```

#### **Brute Force Detected (5th attempt):**
```
[2025-11-01 15:30:15] local.WARNING: Brute force login detected 
{
    "email":"admin@educounsel.com",
    "ip":"127.0.0.1",
    "retry_after":30
}
```

#### **Successful Login:**
```
[2025-11-01 15:31:00] local.INFO: User logged in successfully 
{
    "user_id":1,
    "email":"admin@educounsel.com",
    "role":"admin"
}
```

---

## ✅ SUCCESS CRITERIA

Test dianggap **BERHASIL** jika:

- [ ] ✅ Setelah 5x login gagal, throttle warning muncul
- [ ] ✅ Countdown timer berjalan dari 30 ke 0
- [ ] ✅ Form disabled saat throttled
- [ ] ✅ Alert muncul jika paksa login
- [ ] ✅ Setelah 30 detik, form enabled kembali
- [ ] ✅ Sisa percobaan ditampilkan (mulai percobaan ke-3)
- [ ] ✅ Logs tercatat dengan benar
- [ ] ✅ Login berhasil setelah countdown selesai

---

## 🎯 QUICK TEST CHECKLIST

```
[ ] Open http://localhost/login
[ ] Login dengan password salah 5x
[ ] Verify throttle warning muncul
[ ] Verify countdown dari 30 detik
[ ] Try click login saat diblokir → Alert muncul
[ ] Wait 30 seconds → Form enabled
[ ] Login dengan password benar → Success
[ ] Check logs → All events recorded
```

---

## 🐛 TROUBLESHOOTING

### **Problem: Throttle tidak trigger**
**Solution:** 
- Clear cache: `php artisan cache:clear`
- Check logs: `storage/logs/laravel.log`

### **Problem: Countdown tidak muncul**
**Solution:**
- Clear view cache: `php artisan view:clear`
- Hard refresh browser: `Ctrl + Shift + R`

### **Problem: Form tidak disabled**
**Solution:**
- Check JavaScript console for errors
- Verify jQuery loaded

---

## 📝 TECHNICAL DETAILS

### **Rate Limit Settings:**
```php
// LoginController.php
- Max attempts: 5
- Decay time: 30 seconds
- Throttle key: email + IP
```

### **Frontend Features:**
```javascript
- Countdown timer: 1 second interval
- Form disable/enable: Dynamic
- Visual feedback: CSS animations
- Alert system: Native alert + custom modal
```

### **Security Logs:**
```
- Failed attempts logged
- Brute force detected logged
- Attempt count + remaining attempts logged
- IP + User-Agent tracked
```

---

## 🎉 EXPECTED USER EXPERIENCE

1. **Percobaan 1-2:** Normal error message
2. **Percobaan 3-4:** Warning dengan sisa percobaan
3. **Percobaan 5:** Throttle triggered, countdown start
4. **Selama 30 detik:** Form disabled, countdown visible
5. **Try login paksa:** Alert warning muncul
6. **After 30 detik:** Form enabled, success message
7. **Login benar:** Redirect ke dashboard

---

**🔒 Security Level: Maximum**  
**⏱️ Test Duration: ~3 minutes**  
**✅ Status: Ready for Testing**
