<!-- Voice Notification Helper (Lightweight) -->
<script>
// Simple Voice Notification System
const VoiceNotification = {
    settings: {
        enabled: true,
        speed: 1.0,
        pitch: 1.0,
        lang: 'id-ID'
    },
    
    // Initialize settings from localStorage
    init() {
        const saved = localStorage.getItem('voiceSettings');
        if (saved) {
            this.settings = { ...this.settings, ...JSON.parse(saved) };
        }
    },
    
    // Main speak function
    speak(text, options = {}) {
        if (!this.settings.enabled || !('speechSynthesis' in window)) {
            return;
        }
        
        // Cancel any ongoing speech
        window.speechSynthesis.cancel();
        
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = options.lang || this.settings.lang;
        utterance.rate = options.speed || this.settings.speed;
        utterance.pitch = options.pitch || this.settings.pitch;
        utterance.volume = options.volume || 1.0;
        
        window.speechSynthesis.speak(utterance);
    },
    
    // Shortcut methods
    success(message) {
        this.speak(message, { pitch: 1.2 });
    },
    
    error(message) {
        this.speak(message, { pitch: 0.8, speed: 0.9 });
    },
    
    info(message) {
        this.speak(message);
    },
    
    // Toggle voice on/off
    toggle() {
        this.settings.enabled = !this.settings.enabled;
        localStorage.setItem('voiceSettings', JSON.stringify(this.settings));
        return this.settings.enabled;
    }
};

// Initialize
VoiceNotification.init();

// Make it globally accessible
window.voiceNotif = VoiceNotification;
window.voiceSuccess = (msg) => VoiceNotification.success(msg);
window.voiceError = (msg) => VoiceNotification.error(msg);
window.voiceInfo = (msg) => VoiceNotification.info(msg);
window.voiceSpeak = (msg, opts) => VoiceNotification.speak(msg, opts);
</script>
