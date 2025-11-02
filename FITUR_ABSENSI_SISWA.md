# 📱 Fitur Absensi Siswa - Real-time

## 🎯 **Overview**

Fitur absensi siswa yang memungkinkan siswa untuk melakukan absen secara real-time dengan validasi waktu masuk dan tampilan visual yang berbeda berdasarkan waktu absen.

---

## ✨ **Fitur Utama**

### **1. Button Absen**
- ✅ Tombol hijau "Absen" yang mudah diakses
- ✅ Konfirmasi sebelum absen
- ✅ Loading state saat proses absen
- ✅ Popup sukses setelah absen berhasil

### **2. Validasi Waktu Absen**

#### **🟢 Masuk (06:00 - 07:00)**
- **Waktu:** Jam 06:00 sampai 07:00
- **Badge Warna:** Hijau (#A7F3D0)
- **Text Warna:** Hijau Tua (#065F46)
- **Keterangan:** "Masuk"
- **Statistik:** Menambah "Total Hadir"

#### **🔴 Telat (07:01 ke atas)**
- **Waktu:** Jam 07:01 sampai seterusnya
- **Badge Warna:** Merah (#FCA5A5)
- **Text Warna:** Merah Tua (#7F1D1D)
- **Keterangan:** "Telat"
- **Statistik:** Menambah "Total Terlambat"

### **3. Tampilan Tabel Real-time**
- ✅ Row baru muncul di posisi paling atas
- ✅ Animasi slide-in saat row baru ditambahkan
- ✅ Highlight kuning untuk row baru (fade out setelah 2 detik)
- ✅ Data yang ditampilkan:
  - Nama Siswa (dari authentication)
  - Tanggal (format: Hari, DD Bulan YYYY)
  - Waktu (format: HH:MM dengan badge warna)
  - Keterangan (Masuk/Telat)

### **4. Update Statistik Otomatis**
- ✅ Total Hadir bertambah jika absen jam 06:00-07:00
- ✅ Total Terlambat bertambah jika absen jam 07:01+
- ✅ Update real-time tanpa refresh halaman

---

## 🎨 **Design Specifications**

### **Badge Waktu - Hijau (Masuk)**
```css
background: #A7F3D0
text-color: #065F46
border-radius: full
padding: 8px 12px
```

### **Badge Waktu - Merah (Telat)**
```css
background: #FCA5A5
text-color: #7F1D1D
border-radius: full
padding: 8px 12px
```

### **Row Highlight Animation**
```css
background: #FEF3C7 (kuning muda)
transition: 2s ease
animation: slideInDown 0.5s
```

---

## 💻 **Cara Kerja Teknis**

### **1. User Click Button "Absen"**
```javascript
absenBtn.addEventListener('click', function() {
    // Konfirmasi
    if (confirm('Apakah Anda yakin ingin melakukan absen hari ini?')) {
        // Show loading
        // Proses absen
        // Tambah row ke tabel
        // Show popup sukses
    }
});
```

### **2. Logika Validasi Waktu**
```javascript
function cekStatusAbsensi(waktu) {
    const jam = waktu.getHours();
    const menit = waktu.getMinutes();
    
    // Jam 06:00 - 07:00 = Masuk (hijau)
    if ((jam === 6) || (jam === 7 && menit === 0)) {
        return { status: 'masuk', keterangan: 'Masuk', bgColor: 'bg-[#A7F3D0]', textColor: 'text-[#065F46]' };
    }
    // Jam 07:01+ = Telat (merah)
    else {
        return { status: 'telat', keterangan: 'Telat', bgColor: 'bg-[#FCA5A5]', textColor: 'text-[#7F1D1D]' };
    }
}
```

### **3. Tambah Row ke Tabel**
```javascript
function tambahAbsensi() {
    const now = new Date();
    const namaSiswa = "{{ auth()->user()->nama }}";
    const tanggal = formatTanggalIndonesia(now);
    const waktu = formatWaktu(now);
    const statusData = cekStatusAbsensi(now);

    // Buat row baru
    const newRow = document.createElement('tr');
    newRow.innerHTML = `...`;
    
    // Insert di posisi paling atas
    tableBody.insertBefore(newRow, tableBody.firstChild);
    
    // Update statistik
    updateStatistik(statusData.status);
}
```

---

## 📊 **Contoh Skenario**

### **Skenario 1: Siswa Absen Jam 06:45**
1. User klik button "Absen"
2. Sistem ambil waktu: 06:45
3. Validasi: 06:45 masuk range 06:00-07:00
4. Result:
   - Badge: **Hijau** (#A7F3D0)
   - Waktu: **06:45**
   - Keterangan: **Masuk**
   - Statistik "Total Hadir" bertambah +1

### **Skenario 2: Siswa Absen Jam 07:15**
1. User klik button "Absen"
2. Sistem ambil waktu: 07:15
3. Validasi: 07:15 di atas 07:00
4. Result:
   - Badge: **Merah** (#FCA5A5)
   - Waktu: **07:15**
   - Keterangan: **Telat**
   - Statistik "Total Terlambat" bertambah +1

### **Skenario 3: Siswa Absen Jam 07:00 (Tepat)**
1. User klik button "Absen"
2. Sistem ambil waktu: 07:00
3. Validasi: 07:00 masih masuk range (jam 7 menit 0)
4. Result:
   - Badge: **Hijau** (#A7F3D0)
   - Waktu: **07:00**
   - Keterangan: **Masuk**
   - Statistik "Total Hadir" bertambah +1

---

## 🎯 **User Experience Flow**

```
1. Siswa buka halaman Absensi
   ↓
2. Klik button "Absen"
   ↓
3. Konfirmasi "Apakah yakin?"
   ↓
4. Button berubah "Memproses..." dengan spinner
   ↓
5. Row baru muncul di tabel (paling atas)
   - Highlight kuning
   - Animasi slide-in
   ↓
6. Popup sukses muncul
   - Icon centang hijau
   - "Berhasil Absen!"
   ↓
7. Klik "Oke" untuk tutup popup
   ↓
8. Highlight fade out setelah 2 detik
   ↓
9. ✅ Absensi tercatat!
```

---

## 🔧 **Kustomisasi**

### **Ubah Rentang Waktu Masuk**
Edit di fungsi `cekStatusAbsensi()`:
```javascript
// Contoh: Ubah jadi 06:30 - 07:30
if ((jam === 6 && menit >= 30) || (jam === 7 && menit <= 30)) {
    return { status: 'masuk', ... };
}
```

### **Tambah Status Baru (Misal: "Sangat Telat")**
```javascript
// Jam 08:00+ = Sangat Telat (ungu)
else if (jam >= 8) {
    return {
        status: 'sangat_telat',
        keterangan: 'Sangat Telat',
        bgColor: 'bg-purple-200',
        textColor: 'text-purple-900'
    };
}
```

---

## 📱 **Responsive Design**

✅ Mobile-friendly dengan grid responsive
✅ Table scroll horizontal di mobile
✅ Badge ukuran otomatis menyesuaikan layar
✅ Popup centered di semua ukuran layar

---

## ⚠️ **Catatan Penting**

1. **Waktu Client-Side:** 
   - Sistem menggunakan waktu browser user
   - Pastikan device siswa waktu yang akurat

2. **Authentication:**
   - Nama siswa diambil dari `auth()->user()->nama`
   - Pastikan user sudah login

3. **Validasi Server-Side:**
   - Saat ini hanya client-side validation
   - Untuk production, tambahkan validasi di backend

4. **Duplikasi Absen:**
   - Belum ada proteksi double absen
   - Tambahkan cek di backend untuk prevent duplikasi

---

## 🚀 **Next Steps (Optional)**

1. **Backend Integration:**
   - Save absensi ke database via AJAX
   - Validasi server-side
   - Prevent duplikasi

2. **Geolocation Check:**
   - Validasi lokasi siswa (harus di sekolah)

3. **QR Code Scan:**
   - Alternatif absen dengan scan QR

4. **Export Data:**
   - Export absensi ke Excel/PDF

5. **Notifikasi:**
   - Email/SMS ke orang tua jika telat
   - Push notification

---

**Generated:** 2025-10-31  
**Version:** 1.0.0  
**Author:** Educounsel Development Team
