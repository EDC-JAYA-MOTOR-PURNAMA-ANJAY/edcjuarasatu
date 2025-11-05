# 🎤 Panduan Setup Microphone untuk Voice to Text

## ❌ Masalah: "Microphone access denied"

Jika Anda melihat popup **"Microphone access denied. Please allow access."**, berikut cara mengatasinya:

---

## ✅ Solusi 1: Allow Microphone di Chrome/Edge

### **Step 1: Klik Icon Gembok/Info di Address Bar**
- Di sebelah kiri URL `http://127.0.0.1:8000`, ada icon 🔒 atau ⓘ
- Klik icon tersebut

### **Step 2: Change Permission**
- Cari setting **Microphone**
- Ubah dari **"Block"** atau **"Ask"** menjadi **"Allow"**

### **Step 3: Refresh Page**
- Tekan `F5` atau refresh halaman
- Microphone sekarang sudah bisa digunakan!

---

## ✅ Solusi 2: Melalui Chrome Settings

### **Cara Manual:**
1. Buka Chrome Settings: `chrome://settings/content/microphone`
2. Di bagian **"Allowed to use your microphone"**, klik **Add**
3. Masukkan: `http://127.0.0.1:8000` atau `http://localhost:8000`
4. Klik **Add**
5. Refresh halaman chatbot

---

## ✅ Solusi 3: Reset All Permissions

### **Jika masih tidak bisa:**
1. Buka Chrome Settings: `chrome://settings/privacy`
2. Klik **"Site Settings"**
3. Scroll ke **"Recent activity"**
4. Cari `127.0.0.1:8000`
5. Klik **"Clear & reset"**
6. Refresh halaman dan allow microphone saat diminta

---

## 🔍 Troubleshooting

### **1. Microphone tidak terdeteksi di device**
- Pastikan microphone fisik terhubung (laptop biasanya punya built-in mic)
- Cek Windows Settings → Privacy → Microphone
- Pastikan "Allow apps to access your microphone" = ON

### **2. Browser tidak support**
- Voice to Text hanya work di:
  - ✅ Google Chrome
  - ✅ Microsoft Edge
  - ✅ Opera
- Tidak work di:
  - ❌ Firefox
  - ❌ Safari (limited)

### **3. Microphone button disabled**
- Jika button microphone abu-abu (disabled), berarti browser Anda tidak support Speech Recognition
- Solusi: Gunakan Chrome atau Edge

---

## 📝 Testing Microphone

### **Quick Test:**
1. Buka chatbot: `http://localhost:8000/student/ai-companion`
2. Klik icon microphone 🎤
3. Jika muncul popup permission, klik **"Allow"**
4. Button akan berubah merah dengan animasi pulse
5. Bicara: "Halo, ini adalah test microphone"
6. Text akan muncul di input box

### **Jika Berhasil:**
- ✅ Button berubah merah saat recording
- ✅ Ada animasi pulse
- ✅ Notification: "🎤 Listening... Speak now!"
- ✅ Text muncul setelah selesai bicara
- ✅ Notification: "✅ Voice captured: [your text]"

---

## 🎯 Tips Penggunaan

### **Untuk Hasil Terbaik:**
1. **Bicara dengan jelas** dan tidak terlalu cepat
2. **Pastikan tidak ada noise** dari background
3. **Gunakan bahasa Indonesia** yang baik dan benar
4. **Jangan bicara terlalu panjang** (max ~30 detik per recording)
5. **Tunggu notification** sebelum mulai bicara

### **Command Umum:**
- Klik mic → bicara → otomatis stop
- Atau klik mic → bicara → klik stop manual

---

## 🔐 Privacy & Security

### **Apakah Aman?**
- ✅ **100% Private**: Speech recognition dilakukan di browser Anda (client-side)
- ✅ **No Server**: Audio tidak dikirim ke server kami
- ✅ **No Storage**: Recording tidak disimpan
- ✅ **Local Processing**: Semua proses di device Anda

### **Data Yang Dikirim:**
- ❌ Audio file → TIDAK
- ✅ Text hasil recognition → YA (untuk chat dengan AI)

---

## 📞 Need Help?

Jika masih ada masalah:
1. Check browser console (F12) untuk error messages
2. Test microphone di website lain: https://mictests.com/
3. Restart browser
4. Contact support

---

**Last Updated:** Nov 5, 2025  
**Version:** 1.0
