# Setup HTTPS untuk Localhost Laravel

## Method 1: Menggunakan Laravel Valet (Windows - Easiest)

### Install Laravel Valet for Windows:
```bash
composer global require cretueusebiu/valet-windows
valet install
```

### Setup Site:
```bash
cd c:\xampp\htdocs\edcjuarasatu
valet link edcjuarasatu
valet secure edcjuarasatu
```

### Access:
```
https://edcjuarasatu.test
```

---

## Method 2: Self-Signed Certificate (Manual)

### Step 1: Generate Certificate
```bash
# Install OpenSSL (sudah ada di XAMPP)
cd C:\xampp\apache\bin

# Generate private key
openssl genrsa -out localhost.key 2048

# Generate certificate
openssl req -new -x509 -key localhost.key -out localhost.crt -days 365
```

### Step 2: Edit Apache Config
File: `C:\xampp\apache\conf\extra\httpd-ssl.conf`

```apache
<VirtualHost _default_:443>
    DocumentRoot "C:/xampp/htdocs/edcjuarasatu/public"
    ServerName localhost:443
    ServerAdmin admin@localhost
    
    SSLEngine on
    SSLCertificateFile "C:/xampp/apache/bin/localhost.crt"
    SSLCertificateKeyFile "C:/xampp/apache/bin/localhost.key"
    
    <Directory "C:/xampp/htdocs/edcjuarasatu/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Step 3: Enable SSL in Apache
File: `C:\xampp\apache\conf\httpd.conf`

Uncomment lines:
```apache
LoadModule ssl_module modules/mod_ssl.so
Include conf/extra/httpd-ssl.conf
```

### Step 4: Trust Certificate
1. Double-click `localhost.crt`
2. Click "Install Certificate"
3. Select "Local Machine"
4. Place in "Trusted Root Certification Authorities"
5. Finish

### Step 5: Restart Apache
```
Stop Apache di XAMPP Control Panel
Start Apache lagi
```

### Step 6: Update Laravel .env
```env
APP_URL=https://localhost
```

### Access:
```
https://localhost/edcjuarasatu/public
```

---

## Method 3: PHP Built-in Server dengan Ngrok (Easiest - No Config)

### Step 1: Install Ngrok
Download: https://ngrok.com/download
Extract ke: `C:\ngrok`

### Step 2: Run Laravel
```bash
cd c:\xampp\htdocs\edcjuarasatu
php artisan serve --port=8000
```

### Step 3: Run Ngrok (Terminal Baru)
```bash
cd C:\ngrok
ngrok http 8000
```

### Access:
```
https://[random-id].ngrok-free.app
```

Ngrok akan provide HTTPS URL dengan valid certificate!

---

## Method 4: Laravel Valet Alternative (Laragon)

### Install Laragon:
1. Download: https://laragon.org/download/
2. Install Laragon
3. Put project in: `C:\laragon\www\edcjuarasatu`
4. Right-click Laragon tray icon
5. Click "Quick app" → "edcjuarasatu"
6. Enable SSL from Laragon menu

### Access:
```
https://edcjuarasatu.test
```

---

## IMPORTANT NOTES:

### ⚠️ Development Only
- Self-signed certificates akan show "Not Secure" warning
- User harus manual "Proceed anyway"
- Ini OK untuk development

### ✅ Production
- Untuk production, gunakan:
  - Let's Encrypt (Free SSL)
  - CloudFlare (Free SSL)
  - SSL dari hosting provider

### 🎯 Recommendation
Untuk localhost development:
- **TIDAK perlu HTTPS**
- Chrome mengizinkan microphone di localhost HTTP
- Warning "tidak aman" bisa diabaikan
- Fokus ke development dulu

---

## Verify SSL Working:
```bash
# Test HTTPS
curl -k https://localhost

# Check certificate
openssl s_client -connect localhost:443 -showcerts
```

---

## Troubleshooting:

### Apache tidak start dengan SSL:
```
Check error log: C:\xampp\apache\logs\error.log
Pastikan port 443 tidak digunakan aplikasi lain
```

### Certificate error:
```
Re-generate certificate
Trust certificate di Windows Certificate Manager
Clear browser cache
```

### Ngrok free limit:
```
Free tier: 40 connections/minute
Cukup untuk development
```
