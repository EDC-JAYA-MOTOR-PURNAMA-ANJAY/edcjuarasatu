# 🔒 SECURITY DOCUMENTATION - Sistem BK Educounsel

## 📋 Security Features Implemented

### ✅ 1. **Authentication & Authorization**
- ✅ Role-based access control (RBAC) dengan middleware
- ✅ Session regeneration setelah login
- ✅ Logout dengan session invalidation
- ✅ Proteksi route dengan middleware `auth` dan `role`
- ✅ Check status akun (aktif/non-aktif)

### ✅ 2. **Rate Limiting & Brute Force Protection**
- ✅ Max 5 login attempts per email per menit
- ✅ Automatic throttling dengan countdown
- ✅ Logging untuk brute force attempts
- ✅ IP tracking untuk suspicious activity

### ✅ 3. **Password Security**
- ✅ **Minimum 8 characters**
- ✅ **Must contain:**
  - At least 1 lowercase letter (a-z)
  - At least 1 uppercase letter (A-Z)
  - At least 1 digit (0-9)
  - At least 1 special character (@$!%*#?&)
- ✅ Bcrypt hashing (12 rounds)
- ✅ Password tidak pernah di-log atau ditampilkan

### ✅ 4. **Session Security**
- ✅ Session encryption enabled
- ✅ HTTPOnly cookies (prevent XSS)
- ✅ Secure cookies (HTTPS only)
- ✅ SameSite=Strict (prevent CSRF)
- ✅ Session lifetime: 120 minutes
- ✅ Session stored in database

### ✅ 5. **Security Headers**
- ✅ **X-Content-Type-Options**: nosniff
- ✅ **X-Frame-Options**: SAMEORIGIN (prevent clickjacking)
- ✅ **X-XSS-Protection**: 1; mode=block
- ✅ **Strict-Transport-Security**: HSTS enabled
- ✅ **Content-Security-Policy**: CSP rules
- ✅ **Referrer-Policy**: strict-origin-when-cross-origin
- ✅ **Permissions-Policy**: restricted

### ✅ 6. **Input Validation & Sanitization**
- ✅ Laravel validation rules di semua form
- ✅ Email validation
- ✅ SQL Injection prevention (Eloquent ORM)
- ✅ XSS prevention (Blade escaping)
- ✅ Mass assignment protection

### ✅ 7. **Audit Logging**
- ✅ **Login Events:**
  - Successful logins dengan user details
  - Failed login attempts dengan IP
  - Brute force detection
  - Inactive account login attempts
  
- ✅ **User Management Events:**
  - User creation (admin + new user details)
  - User updates (old data vs new data)
  - Password changes
  - User deletion (admin + deleted user info)
  - Attempt to delete own account
  
- ✅ **Logout Events:**
  - User logout dengan timestamp dan IP

### ✅ 8. **CSRF Protection**
- ✅ @csrf token di semua forms
- ✅ Automatic CSRF validation oleh Laravel
- ✅ CSRF token regeneration after login

### ✅ 9. **Error Handling**
- ✅ Generic error messages (tidak expose sensitive info)
- ✅ Detailed error logging di backend
- ✅ Production mode: APP_DEBUG=false

---

## 🛡️ Security Best Practices

### **Development Environment**
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
SESSION_SECURE_COOKIE=false
```

### **Production Environment**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
```

---

## 🔐 Security Checklist

### **Before Deployment:**

- [ ] Generate APP_KEY: `php artisan key:generate`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Use HTTPS (SSL/TLS certificate)
- [ ] Update `APP_URL` to production domain
- [ ] Change default database credentials
- [ ] Enable session encryption
- [ ] Configure proper file permissions
- [ ] Remove `.env` from version control
- [ ] Review all logs location
- [ ] Configure backup strategy

### **Regular Maintenance:**

- [ ] Monitor security logs weekly
- [ ] Update Laravel & dependencies monthly
- [ ] Review user permissions quarterly
- [ ] Audit failed login attempts
- [ ] Check for suspicious activities
- [ ] Test backup restoration
- [ ] Review and update password policy

---

## 🚨 Security Incident Response

### **Suspected Brute Force Attack:**
1. Check logs: `storage/logs/laravel.log`
2. Search for: `"Brute force login detected"`
3. Block IP if necessary
4. Notify affected users
5. Consider increasing rate limit

### **Suspicious User Activity:**
1. Check audit logs for user actions
2. Review last login IP and location
3. Temporarily disable suspicious accounts
4. Investigate data access patterns
5. Reset passwords if compromised

### **Failed Login Attempts:**
```bash
# Check recent failed logins
grep "Failed login attempt" storage/logs/laravel.log | tail -20

# Check specific user
grep "email@example.com" storage/logs/laravel.log | grep "Failed login"
```

---

## 📊 Log Monitoring

### **Important Log Events:**

#### **Critical (Review Immediately)**
- Brute force login detected
- Multiple failed login attempts
- Admin attempted to delete own account
- User account deleted
- Failed to create/update/delete user

#### **Warning (Review Daily)**
- Failed login attempt
- Inactive account login attempt

#### **Info (Review Weekly)**
- User logged in successfully
- User logged out
- New user created
- User data updated

### **Log Locations:**
```
storage/logs/laravel.log          # Main application log
storage/logs/laravel-YYYY-MM-DD.log  # Daily logs
```

---

## 🔍 Security Testing

### **Manual Testing:**

1. **Test Rate Limiting:**
   - Try 6 failed login attempts
   - Should block after 5 attempts
   
2. **Test Password Policy:**
   - Try weak passwords
   - Should reject: "password", "12345678", "Test123"
   - Should accept: "SecureP@ss123"

3. **Test Session Security:**
   - Login from browser A
   - Logout from browser A
   - Session should be invalid

4. **Test CSRF Protection:**
   - Remove @csrf token
   - Form should reject submission

5. **Test Role-based Access:**
   - Login as siswa
   - Try to access `/admin/dashboard`
   - Should be denied

---

## 🛠️ Configuration Files

### **Key Security Files:**
```
app/Http/Middleware/SecurityHeaders.php      # Security headers
app/Http/Middleware/CheckRole.php            # Role-based access
app/Http/Controllers/Auth/LoginController.php # Rate limiting
bootstrap/app.php                            # Middleware registration
.env                                         # Security configuration
```

---

## ⚠️ Common Vulnerabilities to Avoid

### **❌ DON'T:**
- Store passwords in plain text
- Use weak password policies
- Expose sensitive data in logs
- Trust user input without validation
- Use `APP_DEBUG=true` in production
- Commit `.env` to version control
- Use predictable session IDs
- Disable CSRF protection

### **✅ DO:**
- Hash all passwords
- Validate all inputs
- Sanitize all outputs
- Use HTTPS in production
- Keep dependencies updated
- Log security events
- Use strong session configuration
- Implement rate limiting

---

## 📞 Security Contacts

**Security Issues:**
Report security vulnerabilities to: [security@yourdomain.com]

**Emergency Response:**
Contact system administrator immediately for critical incidents.

---

## 📚 Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

---

**Last Updated:** 2025-01-01  
**Version:** 1.0.0  
**Security Audit:** ✅ Passed
