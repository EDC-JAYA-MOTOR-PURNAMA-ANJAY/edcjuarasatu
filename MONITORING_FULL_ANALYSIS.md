# 🚨 ANALISIS LENGKAP ERROR - HALAMAN MONITORING

## ❌ DAFTAR ERROR YANG DITEMUKAN

### **1. UNDEFINED VARIABLES (3 Errors)**

#### Error 1.1: `$kelasList` (Line 118)
```blade
@forelse($kelasList as $kelas)
    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
@empty
```
**Status:** ❌ Variable TIDAK di-pass dari controller

#### Error 1.2: `$kategoriStats` (Line 163)
```javascript
const kategoriData = @json($kategoriStats);
```
**Status:** ❌ Variable TIDAK di-pass dari controller (untuk Chart.js)

#### Error 1.3: `$demografiStats` (Line 164)
```javascript
const demografiData = @json($demografiStats);
```
**Status:** ❌ Variable TIDAK di-pass dari controller (untuk Chart.js)

---

### **2. MISSING ROUTES (3 Errors)**

#### Error 2.1: AJAX Route `/admin/monitoring/data`
```javascript
fetch('/admin/monitoring/data?' + params.toString())
```
**Status:** ❌ Route TIDAK terdaftar (untuk filter data)

#### Error 2.2: Export PDF Route
```javascript
window.location.href = '{{ route("admin.monitoring.export-pdf") }}';
```
**Status:** ❌ Route `admin.monitoring.export-pdf` TIDAK ada

#### Error 2.3: Export Excel Route
```javascript
window.location.href = '{{ route("admin.monitoring.export-excel") }}';
```
**Status:** ❌ Route `admin.monitoring.export-excel` TIDAK ada

---

### **3. MISSING METHODS (3 Errors)**

#### Error 3.1: getData() method
```php
// Method untuk handle AJAX request filter
public function getData(Request $request) { }
```
**Status:** ❌ Method TIDAK ada di MonitoringController

#### Error 3.2: exportPdf() method
```php
public function exportPdf() { }
```
**Status:** ❌ Method TIDAK ada di MonitoringController

#### Error 3.3: exportExcel() method
```php
public function exportExcel() { }
```
**Status:** ❌ Method TIDAK ada di MonitoringController

---

## 📊 RINGKASAN ERROR

| No | Type | Error | Status | Impact |
|----|------|-------|--------|--------|
| 1 | Variable | `$kelasList` undefined | ❌ CRITICAL | Dropdown error |
| 2 | Variable | `$kategoriStats` undefined | ❌ CRITICAL | Chart crash |
| 3 | Variable | `$demografiStats` undefined | ❌ CRITICAL | Chart crash |
| 4 | Route | `/admin/monitoring/data` missing | ❌ HIGH | Filter tidak fungsi |
| 5 | Route | `admin.monitoring.export-pdf` missing | ❌ MEDIUM | Export button error |
| 6 | Route | `admin.monitoring.export-excel` missing | ❌ MEDIUM | Export button error |
| 7 | Method | `getData()` missing | ❌ HIGH | AJAX 404 error |
| 8 | Method | `exportPdf()` missing | ❌ MEDIUM | Export fail |
| 9 | Method | `exportExcel()` missing | ❌ MEDIUM | Export fail |

**Total Errors: 9**

---

## 🔍 DETAIL ANALISIS

### **Current Controller State**
```php
// app/Http/Controllers/Admin/MonitoringController.php
public function index()
{
    $guruBkList = User::where('peran', 'guru_bk')
        ->where('status', 'aktif')
        ->orderBy('nama')
        ->get();
    
    $jurusanList = Jurusan::orderBy('nama_jurusan')->get();
    
    return view('admin.monitoring.index', compact('guruBkList', 'jurusanList'));
}
```

**Missing Data:**
- ❌ `$kelasList` - List kelas untuk dropdown filter
- ❌ `$kategoriStats` - Data statistik kategori untuk pie chart
- ❌ `$demografiStats` - Data demografi untuk bar chart

---

### **View Requirements Analysis**

#### **Dropdown Filters:**
```blade
<!-- Line 118-122: Kelas dropdown -->
@forelse($kelasList as $kelas)
    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
@empty
    <option disabled>Tidak ada data kelas</option>
@endforelse
```
**Required:** `$kelasList` (Collection of Kelas)

#### **Chart Data:**
```javascript
// Line 163-164: Chart initialization
const kategoriData = @json($kategoriStats);
const demografiData = @json($demografiStats);
```
**Required:**
- `$kategoriStats` - Array of kategori konseling stats
- `$demografiStats` - Array of demografi stats

---

### **JavaScript Dependencies**

```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
```

**Charts Used:**
1. **Pie Chart** (`kategoriChart`) - Statistik Permasalahan
2. **Bar Chart** (`demografiChart`) - Statistik Demografi

**Plugin:** ChartDataLabels - untuk menampilkan percentage di dalam pie

---

### **AJAX Endpoints Requirements**

#### **1. Filter Data** (Line 335)
```javascript
fetch('/admin/monitoring/data?' + params.toString())
    .then(response => response.json())
    .then(data => {
        // Update charts dengan data baru
    });
```

**Required Response Format:**
```json
{
    "kategori": [
        {"kategori": "Akademik", "total": 45},
        {"kategori": "Sosial", "total": 30},
        {"kategori": "Pribadi", "total": 25}
    ],
    "demografi": [
        {"peran": "siswa", "total": 150},
        {"peran": "siswi", "total": 130},
        {"peran": "guru_bk", "total": 5}
    ]
}
```

#### **2. Export Functions**
```javascript
function exportPdf() {
    window.location.href = '{{ route("admin.monitoring.export-pdf") }}';
}

function exportExcel() {
    window.location.href = '{{ route("admin.monitoring.export-excel") }}';
}
```

---

## 🎯 EXPECTED DATA STRUCTURE

### **1. $kategoriStats**
```php
[
    ['kategori' => 'Akademik', 'total' => 45],
    ['kategori' => 'Sosial', 'total' => 30],
    ['kategori' => 'Pribadi', 'total' => 25],
]
```

### **2. $demografiStats**
```php
[
    ['peran' => 'siswa', 'total' => 150],
    ['peran' => 'siswi', 'total' => 130],
    ['peran' => 'guru_bk', 'total' => 5],
]
```

### **3. $kelasList**
```php
Collection of Kelas models with:
- id
- kode_kelas
- nama_kelas
- tingkat
- jurusan_id
```

---

## 💥 POTENTIAL RUNTIME ERRORS

### **JavaScript Console Errors:**
```
1. Uncaught ReferenceError: kategoriData is not defined
   - Caused by: $kategoriStats undefined

2. Uncaught ReferenceError: demografiData is not defined
   - Caused by: $demografiStats undefined

3. Cannot read property 'map' of undefined
   - Caused by: kategoriData or demografiData being undefined

4. Uncaught TypeError: Cannot set property 'data' of undefined
   - Caused by: Chart objects not initialized properly

5. 404 Not Found: /admin/monitoring/data
   - Caused by: Missing AJAX route

6. 404 Not Found: admin.monitoring.export-pdf
   - Caused by: Missing export route

7. 404 Not Found: admin.monitoring.export-excel
   - Caused by: Missing export route
```

### **Blade Rendering Errors:**
```
1. Undefined variable $kelasList
   - Location: Line 118
   - Impact: Dropdown kelas kosong atau error

2. Undefined variable $kategoriStats
   - Location: Line 163
   - Impact: JavaScript error, chart tidak muncul

3. Undefined variable $demografiStats
   - Location: Line 164
   - Impact: JavaScript error, chart tidak muncul
```

---

## 🔧 SOLUSI YANG DIBUTUHKAN

### **Priority 1: CRITICAL (Must Fix)**
1. ✅ Add `$kelasList` to controller
2. ✅ Add `$kategoriStats` to controller
3. ✅ Add `$demografiStats` to controller

### **Priority 2: HIGH (Should Fix)**
4. ✅ Create AJAX route `/admin/monitoring/data`
5. ✅ Create `getData()` method in controller

### **Priority 3: MEDIUM (Nice to Have)**
6. ✅ Create export PDF route & method
7. ✅ Create export Excel route & method

---

## 📝 IMPLEMENTATION CHECKLIST

- [ ] Update MonitoringController@index() method
  - [ ] Add Kelas query
  - [ ] Add kategori statistics query
  - [ ] Add demografi statistics query
  - [ ] Pass all data to view

- [ ] Add AJAX route in web.php
  - [ ] Route::get('/monitoring/data', ...)

- [ ] Create getData() method
  - [ ] Handle filter parameters
  - [ ] Return JSON response
  - [ ] Support filtering by Guru BK & Jurusan

- [ ] Add export routes (optional)
  - [ ] Route for PDF export
  - [ ] Route for Excel export

- [ ] Create export methods (optional)
  - [ ] exportPdf() method
  - [ ] exportExcel() method

---

## ⚠️ TEMPORARY WORKAROUND

Jika ingin halaman bisa load tanpa error (tanpa data real):

```php
public function index()
{
    $guruBkList = User::where('peran', 'guru_bk')->get();
    $jurusanList = Jurusan::all();
    $kelasList = Kelas::all();
    
    // Dummy data untuk testing
    $kategoriStats = [
        ['kategori' => 'Akademik', 'total' => 0],
        ['kategori' => 'Sosial', 'total' => 0],
        ['kategori' => 'Pribadi', 'total' => 0],
    ];
    
    $demografiStats = [
        ['peran' => 'siswa', 'total' => 0],
        ['peran' => 'siswi', 'total' => 0],
        ['peran' => 'guru_bk', 'total' => 0],
    ];
    
    return view('admin.monitoring.index', compact(
        'guruBkList', 
        'jurusanList', 
        'kelasList',
        'kategoriStats',
        'demografiStats'
    ));
}
```

---

## 🎯 NEXT STEPS

1. **Immediate Fix:** Add missing variables dengan dummy data
2. **Phase 2:** Implement real data queries dari database
3. **Phase 3:** Add AJAX filtering functionality
4. **Phase 4:** Add export features

---

Total Errors Found: **9 Critical Issues**
Fixes Required: **9 Implementations**
Priority Level: **CRITICAL** 🚨
