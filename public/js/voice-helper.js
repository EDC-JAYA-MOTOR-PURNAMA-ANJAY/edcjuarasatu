/**
 * Voice Helper - Educounsel
 * Reusable voice notification system
 * Version: 1.0.0
 */

class VoiceHelper {
    constructor() {
        this.femaleVoice = null;
        this.voicesReady = false;
        this.isEnabled = this.getVoicePreference();
        this.initVoice();
    }

    /**
     * Initialize and load voice
     */
    initVoice() {
        if (!('speechSynthesis' in window)) {
            console.warn('🔇 Speech Synthesis not supported');
            return;
        }

        const loadVoices = () => {
            const voices = window.speechSynthesis.getVoices();
            
            if (voices.length > 0 && !this.voicesReady) {
                console.log('🎤 Loading voice for Educounsel...');
                
                // Priority: Google Indonesian > Local Indonesian > Any Indonesian
                this.femaleVoice = 
                    voices.find(v => v.lang.startsWith('id-') && v.name.toLowerCase().includes('google')) ||
                    voices.find(v => v.lang.startsWith('id-') && v.name.toLowerCase().includes('gadis')) ||
                    voices.find(v => v.lang.startsWith('id-') && v.name.toLowerCase().includes('damayanti')) ||
                    voices.find(v => v.lang.startsWith('id-')) ||
                    voices[0];
                
                this.voicesReady = true;
                
                if (this.femaleVoice) {
                    console.log('✅ Voice loaded:', this.femaleVoice.name);
                }
            }
        };

        loadVoices();
        
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        
        setTimeout(loadVoices, 100);
    }

    /**
     * Main speak function
     */
    speak(message, options = {}) {
        if (!this.isEnabled || !('speechSynthesis' in window)) {
            console.log('🔇 Voice disabled or not supported');
            return;
        }

        // Cancel any ongoing speech
        window.speechSynthesis.cancel();
        
        if (!this.voicesReady) {
            this.initVoice();
        }

        setTimeout(() => {
            const utterance = new SpeechSynthesisUtterance(message);
            
            // Voice settings
            utterance.lang = options.lang || 'id-ID';
            utterance.rate = options.rate || 0.95;  // Slightly fast
            utterance.pitch = options.pitch || 1.22; // Cheerful
            utterance.volume = options.volume || 1.0;
            
            if (this.femaleVoice) {
                utterance.voice = this.femaleVoice;
            }

            // Event handlers
            utterance.onstart = () => {
                console.log('🔊 Speaking:', message);
            };

            utterance.onend = () => {
                console.log('✅ Speech completed');
            };

            utterance.onerror = (e) => {
                console.warn('❌ Speech error:', e.error);
            };

            window.speechSynthesis.speak(utterance);
        }, options.delay || 50);
    }

    /**
     * Speak with success tone (extra cheerful)
     */
    speakSuccess(message, delay = 300) {
        this.speak(message, { 
            pitch: 1.3,  // Extra cheerful for success
            delay: delay 
        });
    }

    /**
     * Speak with info tone (normal)
     */
    speakInfo(message, delay = 200) {
        this.speak(message, { 
            rate: 0.9,   // Slightly slower for clarity
            pitch: 1.15,
            delay: delay 
        });
    }

    /**
     * Speak with warning tone (serious)
     */
    speakWarning(message, delay = 200) {
        this.speak(message, { 
            pitch: 1.0,  // Normal pitch for warning
            rate: 0.85,  // Slower for emphasis
            delay: delay 
        });
    }

    /**
     * Stop any ongoing speech
     */
    stop() {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
        }
    }

    /**
     * Toggle voice on/off
     */
    toggle(enabled) {
        this.isEnabled = enabled;
        localStorage.setItem('educounsel_voice_enabled', enabled ? 'true' : 'false');
        
        if (enabled) {
            this.speakSuccess('Voice notification diaktifkan!');
        }
        
        console.log(enabled ? '🔊 Voice enabled' : '🔇 Voice disabled');
    }

    /**
     * Check if voice is enabled
     */
    isVoiceEnabled() {
        return this.isEnabled;
    }

    /**
     * Get voice preference from localStorage
     */
    getVoicePreference() {
        const saved = localStorage.getItem('educounsel_voice_enabled');
        return saved === null ? true : saved === 'true'; // Default: enabled
    }

    /**
     * Get current voice info
     */
    getVoiceInfo() {
        if (this.femaleVoice) {
            return {
                name: this.femaleVoice.name,
                lang: this.femaleVoice.lang,
                enabled: this.isEnabled
            };
        }
        return null;
    }

    // ========================================
    // CONVENIENCE METHODS FOR SPECIFIC ACTIONS
    // ========================================

    /**
     * 1. Konseling - Pengajuan Berhasil
     */
    speakCounselingSuccess(kategori = '') {
        const message = kategori 
            ? `Pengajuan konseling ${kategori} Anda berhasil dikirim! Tunggu konfirmasi dari Guru BK ya.`
            : 'Pengajuan konseling Anda berhasil dikirim! Tunggu konfirmasi dari Guru BK ya.';
        this.speakSuccess(message);
    }

    /**
     * 2. Questionnaire - Selesai Mengisi
     */
    speakQuestionnaireComplete(namaKuesioner = '') {
        const message = namaKuesioner
            ? `Terima kasih sudah mengisi kuesioner ${namaKuesioner}! Hasil akan diproses oleh Guru BK.`
            : 'Terima kasih sudah mengisi kuesioner! Hasil akan diproses oleh Guru BK.';
        this.speakSuccess(message);
    }

    /**
     * 3. Violation - Pencatatan Pelanggaran
     */
    speakViolationRecorded(namaSiswa = '', jenisPelanggaran = '') {
        const message = namaSiswa && jenisPelanggaran
            ? `Pelanggaran ${jenisPelanggaran} untuk ${namaSiswa} berhasil dicatat. Notifikasi akan dikirim.`
            : 'Pelanggaran berhasil dicatat. Notifikasi akan dikirim ke siswa dan orang tua.';
        this.speakSuccess(message);
    }

    /**
     * 4. Profile - Update Berhasil
     */
    speakProfileUpdated() {
        this.speakSuccess('Profil Anda berhasil diperbarui!');
    }

    /**
     * 5. Account - Pembuatan Akun Baru
     */
    speakAccountCreated(role = '', nama = '') {
        const message = role && nama
            ? `Akun ${role} atas nama ${nama} berhasil dibuat!`
            : 'Akun baru berhasil dibuat!';
        this.speakSuccess(message);
    }

    /**
     * 6. Dashboard - Daily Reminder
     */
    speakDashboardReminder(nama, pendingKonseling = 0, pendingKuesioner = 0) {
        const hour = new Date().getHours();
        let greeting = 'Selamat pagi';
        if (hour >= 11 && hour < 15) greeting = 'Selamat siang';
        else if (hour >= 15 && hour < 18) greeting = 'Selamat sore';
        else if (hour >= 18) greeting = 'Selamat malam';

        let message = `${greeting} ${nama}!`;
        
        if (pendingKonseling > 0) {
            message += ` Anda punya ${pendingKonseling} konseling yang menunggu.`;
        }
        
        if (pendingKuesioner > 0) {
            message += ` Dan ${pendingKuesioner} kuesioner belum diisi.`;
        }
        
        if (pendingKonseling === 0 && pendingKuesioner === 0) {
            message += ' Semua tugas Anda sudah selesai. Hebat!';
        }

        this.speakInfo(message, 1000);
    }

    /**
     * 7. Export - Konfirmasi Download
     */
    speakExportStarted(type = 'data') {
        const message = `${type} sedang diunduh. Tunggu sebentar ya!`;
        this.speakInfo(message);
    }

    /**
     * 8. Konseling Schedule - Jadwal Dibuat
     */
    speakScheduleCreated(namaSiswa = '', tanggal = '', waktu = '') {
        const message = namaSiswa && tanggal && waktu
            ? `Jadwal konseling dengan ${namaSiswa} berhasil dibuat untuk ${tanggal} jam ${waktu}.`
            : 'Jadwal konseling berhasil dibuat!';
        this.speakSuccess(message);
    }

    /**
     * 9. Tahun Ajaran - Aktivasi
     */
    speakTahunAjaranActivated(tahun = '') {
        const message = tahun
            ? `Tahun ajaran ${tahun} berhasil diaktifkan! Semua data siap digunakan.`
            : 'Tahun ajaran berhasil diaktifkan!';
        this.speakSuccess(message);
    }

    /**
     * 10. Notification - Alert Baru
     */
    speakNotificationAlert(message) {
        this.speakInfo(`Anda punya notifikasi baru! ${message}`);
    }

    /**
     * 11. Settings - Pengaturan Disimpan
     */
    speakSettingsSaved() {
        this.speakSuccess('Pengaturan berhasil disimpan!');
    }

    /**
     * 12. Logout - Goodbye
     */
    speakGoodbye(nama = '') {
        const message = nama
            ? `Sampai jumpa ${nama}! Terima kasih sudah menggunakan Educounsel.`
            : 'Sampai jumpa! Terima kasih sudah menggunakan Educounsel.';
        this.speakInfo(message, 100);
    }

    /**
     * 13. Login Success (already exists, but for completeness)
     */
    speakLoginSuccess(nama) {
        const message = `Selamat! Anda berhasil login. Halo ${nama}, selamat datang kembali!`;
        this.speakSuccess(message, 200);
    }

    /**
     * 14. Absensi Success (already exists)
     */
    speakAttendanceSuccess(nama) {
        const message = `Terima kasih ${nama}! Kehadiran Anda berhasil dicatat. Semangat belajar hari ini!`;
        this.speakSuccess(message);
    }

    /**
     * 15. Delete Confirmation
     */
    speakDeleteSuccess(item = 'Data') {
        this.speakSuccess(`${item} berhasil dihapus!`);
    }

    /**
     * Test voice function
     */
    testVoice() {
        this.speakSuccess('Halo! Ini adalah tes suara Educounsel. Suara berfungsi dengan baik!');
    }
}

// ========================================
// INITIALIZE GLOBAL INSTANCE
// ========================================

// Check if already initialized
if (typeof window.voiceHelper === 'undefined') {
    window.voiceHelper = new VoiceHelper();
    console.log('✅ Voice Helper initialized');
}

// Make it available globally
window.VoiceHelper = VoiceHelper;
