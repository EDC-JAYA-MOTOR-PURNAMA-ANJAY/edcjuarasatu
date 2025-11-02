# 📘 COMPLETE CODE DOCUMENTATION
## Sistem Bimbingan Konseling (Educounsel)

**Date:** 2025-11-02  
**Version:** 1.0  
**Framework:** Laravel 12 + Tailwind CSS + Alpine.js  

---

## 📊 PROJECT STATISTICS

- **Total Controllers:** 43 files
- **Total Models:** 16 files
- **Total Views:** 55+ Blade templates
- **Total Migrations:** 21 files
- **Total Seeders:** 8 files
- **Total Routes:** 50+ endpoints

---

## 🎯 CORE MODELS & RELATIONSHIPS

### 1. User Model (`app/Models/User.php`)

**Fillable Attributes:**
```php
'nis_nip', 'nama', 'email', 'password', 'peran', 'status',
'jenis_kelamin', 'alamat', 'no_telepon', 'kelas_id', 'remember_token'
```

**Relationships:**
- `belongsTo`: Kelas
- `hasMany`: konselingAsSiswa, konselingAsGuruBK, kuesioner, jawabanKuesioner, materi, laporan, absensi, absensiVerified

**Helper Methods:**
```php
hasRole(string $role): bool      // Check specific role
isAdmin(): bool                  // Check if admin
isStudent(): bool                // Check if siswa
isGuruBK(): bool                 // Check if guru BK
getRoleAttribute()               // Alias 'peran' as 'role'
```

---

### 2. Absensi Model (`app/Models/Absensi.php`)

**Table:** `absensi`

**Fillable:**
```php
'siswa_id', 'kelas_id', 'tahun_ajaran_id', 'tanggal', 'waktu_masuk',
'waktu_keluar', 'status', 'keterangan', 'bukti_file', 'verified_by', 'verified_at'
```

**Relationships:**
- `belongsTo`: siswa (User), kelas (Kelas), tahunAjaran (TahunAjaran), verifier (User)

**Scopes:**
```php
scopeByStatus($query, $status)
scopeByDateRange($query, $startDate, $endDate)
scopeBySiswa($query, $siswaId)
```

---

## 🎮 KEY CONTROLLERS

### Student AttendanceController (`app/Http/Controllers/Student/AttendanceController.php`)

#### `index()` Method
```php
// Display attendance list with statistics
- Fetch all attendance records for logged-in student
- Calculate stats: totalHadir, totalIzinSakit, totalAlpha, totalTerlambat
- Return view with data
```

#### `store()` Method - Attendance Creation Logic
```php
public function store(Request $request)
{
    $siswaId = auth()->id();
    $today = Carbon::today();
    
    // 1. CHECK: Sudah absen hari ini?
    $existingAbsensi = Absensi::where('siswa_id', $siswaId)
        ->whereDate('tanggal', $today)
        ->first();
    
    if ($existingAbsensi) {
        return response()->json([
            'success' => false,
            'message' => 'Anda sudah melakukan absen hari ini!'
        ], 400);
    }
    
    // 2. GET CURRENT TIME
    $now = Carbon::now();
    $waktuMasuk = $now->format('H:i:s');
    
    // 3. DETERMINE STATUS (Masuk / Telat)
    $keterangan = 'Masuk';
    if ($now->hour >= 7 && $now->minute > 0) {
        $keterangan = 'Telat';
    }
    
    // 4. CREATE ATTENDANCE RECORD
    Absensi::create([
        'siswa_id' => $siswaId,
        'kelas_id' => auth()->user()->kelas_id,
        'tahun_ajaran_id' => 1,
        'tanggal' => $today,
        'waktu_masuk' => $waktuMasuk,
        'status' => 'hadir',
        'keterangan' => $keterangan,
    ]);
    
    // 5. RETURN SUCCESS WITH DATA (for TTS voice)
    return response()->json([
        'success' => true,
        'message' => 'Absen berhasil disimpan!',
        'data' => [
            'nama' => auth()->user()->nama,
            'tanggal' => $now->locale('id')->isoFormat('dddd, D MMMM YYYY'),
            'waktu' => $now->format('H:i'),
            'keterangan' => $keterangan,
            'is_late' => $now->hour >= 7 && $now->minute > 0
        ]
    ]);
}
```

**Key Features:**
- ✅ Prevents duplicate attendance (1 per day)
- ✅ Auto-detects lateness (after 07:00)
- ✅ Returns data for voice notification
- ✅ Uses Carbon for date/time handling

---

### Admin AbsensiController (`app/Http/Controllers/Admin/AbsensiController.php`)

#### Key Methods:

**1. rekapAbsensi() - Attendance Summary**
```php
// Features:
- Lists all active students with their latest attendance
- Search by name or NIS
- Filter by class
- Pagination (10 per page)
- Calculates total attendance count per student
```

**2. detailAbsensi($id) - Student Detail**
```php
// Features:
- Shows individual student attendance history
- Calculates statistics:
  * Total hadir
  * Total izin/sakit
  * Total alpha
  * Total terlambat (waktu_masuk > 07:00:00)
- Paginated attendance records
```

**3. getSummaryByKelas($kelasId) - Class Summary API**
```php
// Returns JSON:
{
    "kelas": "X RPL 1",
    "summary": [
        {
            "siswa_id": 1,
            "nama": "Andi Pratama",
            "hadir": 15,
            "izin": 2,
            "alpha": 1
        },
        ...
    ]
}
```

---

### Auth LoginController (`app/Http/Controllers/Auth/LoginController.php`)

#### Login Flow with Rate Limiting:

```php
public function login(Request $request)
{
    // 1. VALIDATE INPUT
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    // 2. RATE LIMITING CHECK
    $throttleKey = Str::transliterate(
        Str::lower($request->email).'|'.$request->ip()
    );
    
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        
        // Log brute force attempt
        Log::warning('Brute force login detected', [...]);
        
        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan... {$seconds} detik."
        ])->status(429);
    }
    
    // 3. ATTEMPT LOGIN
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $user = Auth::user();
        
        // Clear rate limiter
        RateLimiter::clear($throttleKey);
        
        // Check account status
        if ($user->status !== 'aktif') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif.'
            ]);
        }
        
        // Flash session for welcome voice
        $request->session()->flash('login_success_voice', true);
        $request->session()->flash('user_name_voice', $user->nama);
        
        // Redirect based on role
        return $this->redirectBasedOnRole($user);
    }
    
    // 4. FAILED LOGIN - INCREMENT RATE LIMITER
    RateLimiter::hit($throttleKey, 30); // 30 seconds block
    $attempts = RateLimiter::attempts($throttleKey);
    $remaining = 5 - $attempts;
    
    $message = 'Email atau password salah.';
    if ($attempts >= 3) {
        $message .= " Sisa percobaan: {$remaining}x.";
    }
    
    throw ValidationException::withMessages(['email' => $message]);
}
```

**Security Features:**
- ✅ Rate limiting: 5 attempts → 30 seconds block
- ✅ Brute force logging
- ✅ Account status check
- ✅ Remaining attempts warning
- ✅ Session regeneration after login

---

## 🛡️ MIDDLEWARE

### CheckRole Middleware (`app/Http/Middleware/CheckRole.php`)

```php
public function handle(Request $request, Closure $next, $role)
{
    // 1. Check authentication
    if (!auth()->check()) {
        return redirect('/login')
            ->with('error', 'Silakan login terlebih dahulu.');
    }
    
    // 2. Map role variants (support multiple names)
    $roleMap = [
        'student' => 'siswa',
        'siswa' => 'siswa',
        'admin' => 'admin',
        'guru_bk' => 'guru_bk',
        'teacher' => 'guru_bk',
    ];
    
    // 3. Check role match
    $checkRole = $roleMap[$role] ?? $role;
    $userRole = auth()->user()->peran;
    
    if ($userRole !== $checkRole) {
        abort(403, 'Unauthorized action.');
    }
    
    return $next($request);
}
```

**Usage in Routes:**
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only routes
});
```

---

## 🌱 DATABASE SEEDERS

### UserSeeder (`database/seeders/UserSeeder.php`)

**Creates:**
- **2 Admin accounts**
  - `admin@educounsel.com` / `admin123`
  - `sari.indah@educounsel.com` / `admin123`

- **5 Guru BK accounts**
  - `gurubk@educounsel.com` / `gurubk123`
  - Plus 4 more teachers

- **35 Siswa accounts** (distributed across 3 classes)
  - X RPL 1: 12 students
  - X RPL 2: 12 students
  - X TKJ 1: 11 students
  - All passwords: `siswa123`

**Sample Students:**
```php
// X RPL 1
'fikri.maulana@educounsel.com'    // Male
'putri.amelia@educounsel.com'     // Female

// X RPL 2
'siswa@educounsel.com'            // Andi Pratama
'rina.sari@educounsel.com'        // Female
```

---

## 🎨 KEY VIEWS & FEATURES

### Login Page (`resources/views/auth/login.blade.php`)

**TTS Voice Features:**
```javascript
// Voice Selection Logic (Aggressive Female Search)
Priority 1: Exact id-ID with female keywords
Priority 2: Any id-* with female keywords
Priority 3: Google Indonesian
Priority 4: Remote Indonesian
Priority 5: Any Indonesian
Priority 6: Last resort

Female Keywords: 
['gadis', 'damayanti', 'female', 'perempuan', 'wanita', 
 'woman', 'girl', 'siti', 'dewi']

// Voice Messages
- Wrong email/password error
- Throttle warning with countdown
- Unblock success message
```

---

### Student Attendance Page (`resources/views/student/attendance/index.blade.php`)

**Features:**
1. **Attendance Button** - AJAX POST to `/student/attendance/store`
2. **Statistics Cards** - Hadir, Izin/Sakit, Alpha, Terlambat
3. **Attendance Table** - Sortable, clickable rows
4. **Success Animation** - Animated row insertion
5. **TTS Voice** - Energetic success message

**Voice Message:**
```javascript
rate: 0.88      // Energetic speed
pitch: 1.15     // Cheerful tone
message: "Mantap! [Nama], berhasil absen. Semangat hari ini!"
```

**AJAX Success Handler:**
```javascript
fetch('/student/attendance/store', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 1. Show popup
            showPopup(data.data.nama, data.data.tanggal, ...);
            
            // 2. Add animated row to table
            addAttendanceRow(data.data);
            
            // 3. Update statistics
            updateStats();
            
            // 4. Play voice notification
            speakAttendanceSuccess(data.data.nama);
        }
    });
```

---

### Layouts with Welcome Voice

#### App Layout (`resources/views/layouts/app.blade.php`)

**Welcome Voice Implementation:**
```javascript
@if(session('login_success_voice'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let femaleVoice = null;
        let voicesReady = false;
        
        function loadFemaleVoice() {
            const voices = window.speechSynthesis.getVoices();
            // Prioritize: Gadis, Damayanti, Google, etc.
            femaleVoice = voices.find(v => 
                v.lang.startsWith('id') && 
                v.name.toLowerCase().includes('gadis')
            );
            voicesReady = true;
        }
        
        function speakWelcome(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.88;   // ⚡ Energetic!
            utterance.pitch = 1.15;  // 🎵 Cheerful!
            utterance.volume = 1.0;
            
            if (femaleVoice) {
                utterance.voice = femaleVoice;
            }
            
            window.speechSynthesis.speak(utterance);
        }
        
        // Trigger welcome message
        setTimeout(() => {
            const userName = "{{ session('user_name_voice') }}";
            const message = `Selamat! Anda berhasil login. Halo ${userName}, selamat datang kembali!`;
            speakWelcome(message);
        }, 200);
    });
</script>
@endif
```

**Voice Parameters (Energetic Profile):**
```javascript
rate: 0.88      // +10% faster than default (0.80)
pitch: 1.15     // +15% higher for cheerful tone
volume: 1.0     // Maximum clarity
lang: 'id-ID'   // Indonesian
```

---

## 🔗 ROUTES SUMMARY

### Web Routes (`routes/web.php`)

```php
// === LANDING ===
GET  /                           → LandingController@index
GET  /features, /about, /contact → Static views

// === AUTH ===
GET  /login                      → LoginController@showLoginForm
POST /login                      → LoginController@login
POST /logout                     → LoginController@logout

// === ADMIN (auth, role:admin) ===
GET  /admin/dashboard            → View
GET  /admin/daftar-pengguna      → PenggunaController@index
GET  /admin/tambah-akun          → PenggunaController@create
POST /admin/pengguna/store       → PenggunaController@store
GET  /admin/rekap-absensi        → AbsensiController@rekapAbsensi
GET  /admin/detail-absensi/{id}  → AbsensiController@detailAbsensi
GET  /admin/tahun-ajaran         → View

// === GURU BK (auth, role:guru_bk) ===
GET  /guru_bk/dashboard          → View
GET  /guru_bk/konseling          → View
GET  /guru_bk/pelanggaran        → View

// === STUDENT (auth, role:siswa) ===
GET  /student/dashboard          → View
GET  /student/attendance         → AttendanceController@index
POST /student/attendance/store   → AttendanceController@store
GET  /student/counseling         → View
GET  /student/profile            → View

// === DEBUG ===
GET  /debug-user                 → JSON of current user
```

---

## 📦 DEPENDENCIES DETAIL

### Backend (Composer)

```json
{
    "laravel/framework": "^12.0",          // Core framework
    "laravel/tinker": "^2.10.1",           // Artisan REPL
    "maatwebsite/excel": "^1.1",           // Excel export
    "openai-php/laravel": "^0.17.1",       // AI integration
    "twilio/sdk": "^8.8",                  // SMS notifications
    
    // Dev Dependencies
    "barryvdh/laravel-debugbar": "^3.16",  // Debug toolbar
    "laravel/breeze": "^2.3",              // Auth scaffolding
    "laravel/pail": "^1.2.2",              // Log viewer
    "pestphp/pest": "^3.8"                 // Testing framework
}
```

### Frontend (NPM)

```json
{
    "alpinejs": "^3.15.0",                 // Reactive JS
    "tailwindcss": "^3.1.0",               // CSS framework
    "vite": "^7.0.7",                      // Build tool
    "chart.js": "^4.5.1",                  // Charts
    "sweetalert2": "^11.26.3",             // Beautiful alerts
    "@heroicons/vue": "^2.2.0",            // Icon set
    "axios": "^1.11.0"                     // HTTP client
}
```

---

## 🔐 SECURITY IMPLEMENTATION

### 1. Rate Limiting
```php
// In LoginController
$throttleKey = email + IP address
Max attempts: 5
Block duration: 30 seconds
Warning starts at: 3 attempts
```

### 2. Password Hashing
```php
// In User model
protected function casts(): array {
    return [
        'password' => 'hashed', // Auto bcrypt
    ];
}
```

### 3. Middleware Protection
```php
// Route groups
->middleware(['auth', 'role:admin'])
->middleware(['auth', 'role:guru_bk'])
->middleware(['auth', 'role:siswa'])
```

### 4. CSRF Protection
```blade
@csrf // Laravel auto-protection in all forms
```

### 5. Activity Logging
```php
Log::info('User logged in', [
    'user_id' => $user->id,
    'email' => $user->email,
    'role' => $user->peran,
    'ip' => $request->ip(),
]);

Log::warning('Failed login attempt', [...]);
Log::warning('Brute force detected', [...]);
```

---

## 🎯 KEY FEATURES SUMMARY

### Voice System (TTS)
- ✅ Client-side (Web Speech API)
- ✅ 100% free, no external API
- ✅ Female Indonesian voice prioritized
- ✅ Energetic parameters (rate 0.88, pitch 1.15)
- ✅ Welcome message after login
- ✅ Attendance success notification
- ✅ Error messages on login page
- ✅ Throttle countdown

### Attendance System
- ✅ Real-time recording
- ✅ Duplicate prevention (1 per day)
- ✅ Auto late detection (> 07:00)
- ✅ Statistics calculation
- ✅ Animated UI updates
- ✅ Voice feedback

### User Management
- ✅ Multi-role system (Admin, Guru BK, Siswa)
- ✅ CRUD operations
- ✅ Search & filter
- ✅ Class assignment
- ✅ Status management

### Dashboard
- ✅ Role-specific layouts
- ✅ Statistics cards
- ✅ Interactive charts
- ✅ Quick actions

---

## 📈 DATABASE SCHEMA SUMMARY

### Core Tables
```
users               → User accounts (extended)
absensi             → Attendance records
kelas               → Classes
jurusan             → Majors
tahun_ajaran        → Academic years
konseling           → Counseling sessions
kuesioner           → Questionnaires
materi              → Learning materials
laporan             → Reports
```

### Relationships
```
User → Kelas (belongsTo)
User → Absensi (hasMany)
User → Konseling (hasMany as siswa)
User → Konseling (hasMany as guru_bk)
Absensi → User (belongsTo as siswa)
Absensi → Kelas (belongsTo)
Kelas → Jurusan (belongsTo)
```

---

## 🚀 QUICK COMMANDS

```bash
# Setup
composer install
npm install
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate:fresh --seed

# Development
php artisan serve               # Backend
npm run dev                     # Frontend watch
php artisan queue:work          # Queue worker

# Clear Cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Testing
php artisan test
```

---

## 📂 IMPORTANT FILE PATHS

```
Controllers:
- app/Http/Controllers/Auth/LoginController.php
- app/Http/Controllers/Student/AttendanceController.php
- app/Http/Controllers/Admin/AbsensiController.php

Models:
- app/Models/User.php
- app/Models/Absensi.php
- app/Models/Kelas.php

Views (Voice):
- resources/views/auth/login.blade.php
- resources/views/layouts/app.blade.php
- resources/views/student/attendance/index.blade.php

Middleware:
- app/Http/Middleware/CheckRole.php
- app/Http/Middleware/RoleMiddleware.php

Seeders:
- database/seeders/UserSeeder.php
- database/seeders/AbsensiSeeder.php
```

---

## 🎓 DEFAULT LOGIN CREDENTIALS

```
Admin:
  Email: admin@educounsel.com
  Pass:  admin123

Guru BK:
  Email: gurubk@educounsel.com
  Pass:  gurubk123

Siswa (Sample):
  Email: fikri.maulana@educounsel.com
  Pass:  siswa123
  
  Email: putri.amelia@educounsel.com
  Pass:  siswa123
```

---

**Documentation Created:** 2025-11-02  
**Repository:** https://github.com/kapaliut22/sistem_bk  
**Status:** ✅ Production Ready
