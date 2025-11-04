@extends('layouts.app-admin')

@section('title', 'Pengaturan Sistem - Admin')

@push('styles')
<style>
    .pengaturan-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .settings-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .settings-section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .settings-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #000;
        margin-bottom: 15px;
    }
    
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
    }
    
    .setting-label {
        font-size: 14px;
        font-weight: 500;
        color: #000;
    }
    
    .setting-desc {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
    
    .toggle-switch {
        position: relative;
        width: 50px;
        height: 24px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background-color: #7000CC;
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    .form-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 14px;
        margin-top: 10px;
    }
    
    .btn-save {
        background: #7000CC;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        background: #5E00A8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(112, 0, 204, 0.3);
    }
</style>
@endpush

@section('content')
<div class="pengaturan-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 style="font-size: 28px; font-weight: 700; color: #000; margin-bottom: 10px;">⚙️ Pengaturan Sistem</h1>
        <p style="color: #666; font-size: 14px;">Kelola konfigurasi dan preferensi sistem Educounsel</p>
    </div>
    
    <!-- General Settings -->
    <div class="settings-card">
        <div class="settings-section">
            <div class="section-title">🏫 Pengaturan Umum</div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Nama Sekolah</div>
                    <input type="text" class="form-input" value="SMK Antartika 1 Sidoarjo" placeholder="Nama Sekolah">
                </div>
            </div>
            
            <div class="setting-item">
                <div style="width: 100%;">
                    <div class="setting-label">Alamat Sekolah</div>
                    <textarea class="form-input" rows="3" placeholder="Alamat lengkap sekolah">Jl. Pendidikan No. 123, Sidoarjo, Jawa Timur</textarea>
                </div>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Email Sekolah</div>
                    <input type="email" class="form-input" value="info@smkantartika1.sch.id" placeholder="Email Sekolah">
                </div>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Nomor Telepon</div>
                    <input type="text" class="form-input" value="(031) 1234567" placeholder="Nomor Telepon">
                </div>
            </div>
        </div>
        
        <!-- System Settings -->
        <div class="settings-section">
            <div class="section-title">🔧 Pengaturan Sistem</div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Notifikasi Email</div>
                    <div class="setting-desc">Kirim notifikasi melalui email untuk event penting</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Voice Notification</div>
                    <div class="setting-desc">Aktifkan notifikasi suara di sistem</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Registrasi Siswa Baru</div>
                    <div class="setting-desc">Izinkan pendaftaran siswa baru secara mandiri</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Mode Maintenance</div>
                    <div class="setting-desc">Aktifkan mode maintenance untuk pemeliharaan sistem</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        
        <!-- Absensi Settings -->
        <div class="settings-section">
            <div class="section-title">📅 Pengaturan Absensi</div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Batas Waktu Absensi</div>
                    <input type="time" class="form-input" value="07:30" style="width: 200px;">
                </div>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Auto-Close Absensi</div>
                    <div class="setting-desc">Tutup absensi otomatis setelah jam tertentu</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Rate Limit Absensi</div>
                    <div class="setting-desc">Waktu tunggu (detik) setelah absen gagal</div>
                </div>
                <input type="number" class="form-input" value="30" style="width: 120px;">
            </div>
        </div>
        
        <!-- Security Settings -->
        <div class="settings-section">
            <div class="section-title">🔒 Pengaturan Keamanan</div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Login Rate Limit</div>
                    <div class="setting-desc">Maksimal percobaan login sebelum diblokir</div>
                </div>
                <input type="number" class="form-input" value="5" style="width: 120px;">
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Session Timeout (menit)</div>
                    <div class="setting-desc">Waktu maksimal sesi tidak aktif</div>
                </div>
                <input type="number" class="form-input" value="120" style="width: 120px;">
            </div>
            
            <div class="setting-item">
                <div>
                    <div class="setting-label">Force HTTPS</div>
                    <div class="setting-desc">Paksa penggunaan HTTPS untuk keamanan</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        
        <!-- Save Button -->
        <div style="text-align: right; margin-top: 30px;">
            <button class="btn-save" onclick="saveSettings()">
                💾 Simpan Perubahan
            </button>
        </div>
        <!-- Voice Settings Section -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-volume-up text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">🎙️ Pengaturan Suara</h2>
                    <p class="text-sm text-gray-500">Kelola notifikasi suara sistem</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Voice Toggle -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <label class="font-medium text-gray-700 block mb-1">Aktifkan Voice Notification</label>
                        <p class="text-sm text-gray-500">Suara akan membacakan notifikasi penting seperti konfirmasi, pengingat, dan pemberitahuan</p>
                    </div>
                    
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input type="checkbox" id="voiceToggle" class="sr-only peer" checked>
                        <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-600 peer-checked:to-pink-600"></div>
                    </label>
                </div>

                <!-- Test Voice Button -->
                <div class="flex gap-3">
                    <button onclick="testVoice()" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-volume-up"></i>
                        <span class="font-medium">🔊 Test Suara</span>
                    </button>
                    
                    <button onclick="showVoiceInfo()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span class="font-medium">Info</span>
                    </button>
                </div>

                <!-- Voice Features List -->
                <div class="mt-6">
                    <h3 class="font-semibold text-gray-700 mb-3">Fitur Voice yang Tersedia:</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Login Success:</strong> Sambutan setelah berhasil login</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Absensi:</strong> Konfirmasi kehadiran siswa</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Kuesioner:</strong> Konfirmasi selesai mengisi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Profile Update:</strong> Konfirmasi perubahan profil</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Account Creation:</strong> Konfirmasi pembuatan akun</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Dashboard Reminder:</strong> Pengingat harian (1x per hari)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Export Data:</strong> Konfirmasi download data</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span><strong>Logout:</strong> Pesan perpisahan</span>
                        </li>
                    </ul>
                </div>

                <!-- Status Display -->
                <div id="voiceStatus" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                    <p class="text-sm text-blue-800"></p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
// Voice Settings Handler
document.addEventListener('DOMContentLoaded', function() {
    const voiceToggle = document.getElementById('voiceToggle');
    
    // Load saved preference
    if (window.voiceHelper) {
        voiceToggle.checked = window.voiceHelper.isVoiceEnabled();
    }
    
    // Handle toggle change
    voiceToggle.addEventListener('change', function() {
        if (window.voiceHelper) {
            window.voiceHelper.toggle(this.checked);
            
            // Show status
            showStatus(this.checked ? 'Voice notification diaktifkan ✅' : 'Voice notification dinonaktifkan 🔇');
        }
    });
});

// Test Voice Function
function testVoice() {
    if (window.voiceHelper) {
        window.voiceHelper.testVoice();
    } else {
        alert('Voice Helper belum dimuat. Refresh halaman dan coba lagi.');
    }
}

// Show Voice Info
function showVoiceInfo() {
    if (window.voiceHelper) {
        const info = window.voiceHelper.getVoiceInfo();
        if (info) {
            alert(`🎙️ Voice Information:\n\nVoice: ${info.name}\nLanguage: ${info.lang}\nStatus: ${info.enabled ? 'Enabled ✅' : 'Disabled 🔇'}\n\nSupported by Web Speech API`);
        } else {
            alert('Voice information not available');
        }
    } else {
        alert('Voice Helper tidak tersedia');
    }
}

// Show Status Message
function showStatus(message) {
    const statusEl = document.getElementById('voiceStatus');
    const statusText = statusEl.querySelector('p');
    
    statusText.textContent = message;
    statusEl.classList.remove('hidden');
    
    setTimeout(() => {
        statusEl.classList.add('hidden');
    }, 3000);
}
</script>
@endpush

@push('scripts')
<script>
function saveSettings() {
    // Show success message
    alert('Pengaturan berhasil disimpan!');
    
    // In real implementation, send data to backend
    // Example:
    // fetch('/admin/pengaturan/save', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //     },
    //     body: JSON.stringify(formData)
    // });
}
</script>
@endpush
