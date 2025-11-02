# 📤 PANDUAN PUSH PROJECT KE GITHUB

Updated: 2025-11-02

---

## ✅ Status Saat Ini

- ✅ Git sudah diinisialisasi
- ✅ README.md sudah diupdate
- ✅ Semua file sudah di-commit
- ⏳ Tinggal push ke GitHub

---

## 🚀 LANGKAH-LANGKAH PUSH KE GITHUB

### **Step 1: Buat Repository Baru di GitHub**

1. **Buka GitHub**
   - Go to: https://github.com
   - Login ke akun GitHub Anda
   
2. **Create New Repository**
   - Click tombol hijau **"New"** atau **"+"** di kanan atas → **"New repository"**
   
3. **Isi Form Repository:**
   ```
   Repository name: sistem_bk
   Description: Sistem Informasi Bimbingan Konseling - SMK Antartika 1 Sidoarjo
   
   Visibility: 
   - [x] Public (jika ingin orang lain bisa lihat)
   - [ ] Private (jika ingin private)
   
   Initialize repository:
   - [ ] JANGAN centang "Add a README file"
   - [ ] JANGAN centang "Add .gitignore"
   - [ ] JANGAN centang "Choose a license"
   
   (Karena kita sudah punya file-file ini di local)
   ```

4. **Click "Create repository"**

---

### **Step 2: Copy URL Repository**

Setelah repository dibuat, GitHub akan menampilkan halaman dengan instruksi.

Copy URL repository Anda. Ada 2 pilihan:

#### **Option A: HTTPS (Recommended untuk pemula)**
```
https://github.com/USERNAME/sistem_bk.git
```
Contoh: `https://github.com/john123/sistem_bk.git`

#### **Option B: SSH (Jika sudah setup SSH key)**
```
git@github.com:USERNAME/sistem_bk.git
```

**Pilih HTTPS jika belum pernah setup SSH key.**

---

### **Step 3: Connect Local ke GitHub**

Buka **Terminal/PowerShell** di VS Code (atau Command Prompt):

```bash
# Navigate ke folder project (jika belum)
cd c:\xampp\htdocs\sistem_bk

# Add remote repository (ganti USERNAME dengan username GitHub Anda)
git remote add origin https://github.com/USERNAME/sistem_bk.git

# Verify remote
git remote -v
```

**Expected output:**
```
origin  https://github.com/USERNAME/sistem_bk.git (fetch)
origin  https://github.com/USERNAME/sistem_bk.git (push)
```

---

### **Step 4: Push ke GitHub**

```bash
# Push semua code ke GitHub
git push -u origin main
```

atau jika branch Anda bernama `master`:

```bash
git push -u origin master
```

**Catatan:** 
- `-u` = set upstream (supaya next time bisa langsung `git push`)
- `origin` = nama remote repository
- `main` / `master` = nama branch

---

### **Step 5: Authenticate (Jika diminta)**

Saat pertama kali push, GitHub akan minta authenticate:

#### **Jika menggunakan HTTPS:**

**Windows (modern):**
- Pop-up akan muncul: **"Sign in to GitHub"**
- Click **"Sign in with your browser"**
- Login di browser
- Authorize Git Credential Manager
- Done! ✅

**Atau manual dengan Personal Access Token:**
1. Go to GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token
3. Pilih scope: `repo` (full control)
4. Copy token
5. Saat git push minta password, paste token (bukan password GitHub!)

#### **Jika menggunakan SSH:**
- Pastikan SSH key sudah di-setup
- Tidak perlu password

---

### **Step 6: Verify di GitHub**

1. Refresh halaman repository di GitHub
2. Anda akan lihat semua file sudah terupload! 🎉
3. README.md akan otomatis tampil di bawah

---

## 🔄 WORKFLOW SELANJUTNYA

Setelah ini, untuk update code:

```bash
# 1. Check status
git status

# 2. Add perubahan
git add .

# 3. Commit dengan message
git commit -m "Deskripsi perubahan"

# 4. Push ke GitHub
git push
```

---

## ❗ TROUBLESHOOTING

### **Error: "remote origin already exists"**

```bash
# Remove existing remote
git remote remove origin

# Add correct remote
git remote add origin https://github.com/USERNAME/sistem_bk.git
```

---

### **Error: "failed to push some refs"**

Jika GitHub repository sudah ada file:

```bash
# Pull dulu, merge, baru push
git pull origin main --allow-unrelated-histories
git push -u origin main
```

---

### **Error: "src refspec main does not exist"**

Branch Anda mungkin bernama `master`, bukan `main`:

```bash
# Check branch name
git branch

# Push dengan nama branch yang benar
git push -u origin master
```

---

### **Error: Authentication failed**

**Untuk HTTPS:**
1. Generate Personal Access Token di GitHub
2. Use token sebagai password saat push

**Untuk SSH:**
1. Generate SSH key: `ssh-keygen -t ed25519 -C "your_email@example.com"`
2. Add ke GitHub: Settings → SSH and GPG keys → New SSH key
3. Copy public key: `cat ~/.ssh/id_ed25519.pub`

---

## 🎯 QUICK COMMANDS

```bash
# Check remote
git remote -v

# Change remote URL
git remote set-url origin https://github.com/NEW_USERNAME/sistem_bk.git

# Check branch
git branch

# Rename branch (jika mau ubah master → main)
git branch -M main

# Force push (hati-hati!)
git push -f origin main

# View commit history
git log --oneline

# Undo last commit (keep changes)
git reset --soft HEAD~1
```

---

## 📋 CHECKLIST

Sebelum push, pastikan:

- [x] `.env` TIDAK ter-commit (dilindungi oleh `.gitignore`)
- [x] `/vendor` TIDAK ter-commit (dilindungi oleh `.gitignore`)
- [x] `/node_modules` TIDAK ter-commit (dilindungi oleh `.gitignore`)
- [x] README.md sudah di-update
- [x] Commit message jelas dan descriptive

---

## 🎉 SELAMAT!

Jika berhasil push, project Anda sekarang:
- ✅ Tersimpan di GitHub (backup cloud)
- ✅ Bisa diakses dari mana saja
- ✅ Bisa di-clone oleh orang lain (jika public)
- ✅ Ada version control yang proper
- ✅ Portfolio yang bagus!

---

## 📞 NEED HELP?

Jika ada error atau stuck:

1. Copy paste error message ke Google
2. Check GitHub docs: https://docs.github.com
3. Ask di Stack Overflow
4. Check Git documentation: https://git-scm.com/doc

---

**Repository URL:** https://github.com/USERNAME/sistem_bk

**Good luck!** 🚀
