<!-- Voice Assistant for Guru BK -->
<div id="voiceAssistant" class="voice-assistant-container">
    <!-- Voice Toggle Button (Floating) -->
    <button id="voiceToggle" class="voice-toggle-btn" onclick="toggleVoice()" title="Voice Assistant">
        <i class="fas fa-volume-up" id="voiceIcon"></i>
        <span class="voice-status-indicator" id="voiceStatus"></span>
    </button>
    
    <!-- Voice Settings Panel (Slide from bottom) -->
    <div id="voicePanel" class="voice-panel">
        <div class="voice-panel-header">
            <h3><i class="fas fa-microphone-alt"></i> Voice Assistant</h3>
            <button onclick="closeVoicePanel()" class="close-panel-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="voice-panel-body">
            <!-- Voice Enable/Disable -->
            <div class="voice-setting-item">
                <div class="setting-info">
                    <i class="fas fa-volume-up text-purple-600"></i>
                    <div>
                        <h4>Voice Assistant</h4>
                        <p>Aktifkan suara untuk notifikasi dan feedback</p>
                    </div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="voiceEnabled" onchange="handleVoiceToggle(this)" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <!-- Voice Speed -->
            <div class="voice-setting-item">
                <div class="setting-info">
                    <i class="fas fa-tachometer-alt text-blue-600"></i>
                    <div>
                        <h4>Kecepatan Suara</h4>
                        <p>Atur kecepatan pembacaan</p>
                    </div>
                </div>
                <select id="voiceSpeed" class="voice-select" onchange="updateVoiceSpeed(this.value)">
                    <option value="0.8">Lambat</option>
                    <option value="1.0" selected>Normal</option>
                    <option value="1.2">Cepat</option>
                    <option value="1.5">Sangat Cepat</option>
                </select>
            </div>
            
            <!-- Voice Pitch -->
            <div class="voice-setting-item">
                <div class="setting-info">
                    <i class="fas fa-sliders-h text-green-600"></i>
                    <div>
                        <h4>Nada Suara</h4>
                        <p>Atur tinggi rendah suara</p>
                    </div>
                </div>
                <select id="voicePitch" class="voice-select" onchange="updateVoicePitch(this.value)">
                    <option value="0.8">Rendah</option>
                    <option value="1.0" selected>Normal</option>
                    <option value="1.2">Tinggi</option>
                </select>
            </div>
            
            <!-- Voice Language -->
            <div class="voice-setting-item">
                <div class="setting-info">
                    <i class="fas fa-language text-orange-600"></i>
                    <div>
                        <h4>Bahasa</h4>
                        <p>Pilih bahasa suara</p>
                    </div>
                </div>
                <select id="voiceLang" class="voice-select" onchange="updateVoiceLang(this.value)">
                    <option value="id-ID" selected>Bahasa Indonesia</option>
                    <option value="en-US">English</option>
                </select>
            </div>
            
            <!-- Test Voice -->
            <button onclick="testVoice()" class="test-voice-btn">
                <i class="fas fa-play"></i>
                Test Suara
            </button>
        </div>
    </div>
    
    <!-- Voice Visualizer (Speaking Indicator) -->
    <div id="voiceVisualizer" class="voice-visualizer">
        <div class="wave-container">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        <p class="speaking-text">Berbicara...</p>
    </div>
</div>

<style>
/* Voice Assistant Styles */
.voice-assistant-container {
    position: fixed;
    z-index: 9999;
}

/* Voice Toggle Button */
.voice-toggle-btn {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(128, 0, 255, 0.4);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.voice-toggle-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(128, 0, 255, 0.6);
}

.voice-toggle-btn:active {
    transform: scale(0.95);
}

.voice-toggle-btn.disabled {
    background: linear-gradient(135deg, #9CA3AF 0%, #6B7280 100%);
    box-shadow: 0 4px 16px rgba(156, 163, 175, 0.4);
}

.voice-status-indicator {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 12px;
    height: 12px;
    background: #10B981;
    border: 2px solid white;
    border-radius: 50%;
    animation: pulse-indicator 2s infinite;
}

@keyframes pulse-indicator {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Voice Panel */
.voice-panel {
    position: fixed;
    bottom: -100%;
    right: 24px;
    width: 380px;
    max-height: 600px;
    background: white;
    border-radius: 16px 16px 0 0;
    box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.15);
    transition: bottom 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 9998;
}

.voice-panel.show {
    bottom: 0;
}

.voice-panel-header {
    background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
    color: white;
    padding: 20px;
    border-radius: 16px 16px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.voice-panel-header h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.close-panel-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.close-panel-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.voice-panel-body {
    padding: 20px;
    max-height: 500px;
    overflow-y: auto;
}

/* Voice Settings */
.voice-setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: #F9FAFB;
    border-radius: 12px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.voice-setting-item:hover {
    background: #F3F4F6;
}

.setting-info {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    flex: 1;
}

.setting-info i {
    font-size: 20px;
    margin-top: 2px;
}

.setting-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1F2937;
    margin: 0 0 4px 0;
}

.setting-info p {
    font-size: 12px;
    color: #6B7280;
    margin: 0;
}

/* Toggle Switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #CBD5E1;
    transition: 0.4s;
    border-radius: 26px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background-color: #8000FF;
}

input:checked + .toggle-slider:before {
    transform: translateX(22px);
}

/* Voice Select */
.voice-select {
    padding: 8px 12px;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    font-size: 13px;
    color: #374151;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.voice-select:hover {
    border-color: #8000FF;
}

.voice-select:focus {
    outline: none;
    border-color: #8000FF;
    box-shadow: 0 0 0 3px rgba(128, 0, 255, 0.1);
}

/* Test Voice Button */
.test-voice-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 8px;
    transition: all 0.3s ease;
}

.test-voice-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(128, 0, 255, 0.3);
}

/* Voice Visualizer */
.voice-visualizer {
    position: fixed;
    bottom: 100px;
    right: 24px;
    background: white;
    padding: 20px 24px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    display: none;
    align-items: center;
    gap: 16px;
    z-index: 9997;
}

.voice-visualizer.show {
    display: flex;
    animation: slideInUp 0.3s ease;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.wave-container {
    display: flex;
    align-items: center;
    gap: 3px;
    height: 30px;
}

.wave {
    width: 4px;
    background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
    border-radius: 2px;
    animation: wave-animation 1s ease-in-out infinite;
}

.wave:nth-child(1) { animation-delay: 0s; }
.wave:nth-child(2) { animation-delay: 0.1s; }
.wave:nth-child(3) { animation-delay: 0.2s; }
.wave:nth-child(4) { animation-delay: 0.3s; }
.wave:nth-child(5) { animation-delay: 0.4s; }

@keyframes wave-animation {
    0%, 100% { height: 10px; }
    50% { height: 30px; }
}

.speaking-text {
    font-size: 14px;
    font-weight: 500;
    color: #8000FF;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .voice-panel {
        right: 0;
        left: 0;
        width: 100%;
        border-radius: 16px 16px 0 0;
    }
    
    .voice-toggle-btn {
        bottom: 16px;
        right: 16px;
    }
    
    .voice-visualizer {
        right: 16px;
        bottom: 90px;
    }
}
</style>

<script>
// Voice Assistant JavaScript
let voiceEnabled = true;
let voiceSpeed = 1.0;
let voicePitch = 1.0;
let voiceLang = 'id-ID';
let currentUtterance = null;

// Initialize voice settings from localStorage
function initVoiceSettings() {
    const saved = localStorage.getItem('guruBkVoiceSettings');
    if (saved) {
        const settings = JSON.parse(saved);
        voiceEnabled = settings.enabled ?? true;
        voiceSpeed = settings.speed ?? 1.0;
        voicePitch = settings.pitch ?? 1.0;
        voiceLang = settings.lang ?? 'id-ID';
        
        document.getElementById('voiceEnabled').checked = voiceEnabled;
        document.getElementById('voiceSpeed').value = voiceSpeed;
        document.getElementById('voicePitch').value = voicePitch;
        document.getElementById('voiceLang').value = voiceLang;
        
        updateVoiceButtonState();
    }
}

// Save voice settings
function saveVoiceSettings() {
    const settings = {
        enabled: voiceEnabled,
        speed: voiceSpeed,
        pitch: voicePitch,
        lang: voiceLang
    };
    localStorage.setItem('guruBkVoiceSettings', JSON.stringify(settings));
}

// Toggle voice on/off
function toggleVoice() {
    const panel = document.getElementById('voicePanel');
    panel.classList.toggle('show');
}

function closeVoicePanel() {
    document.getElementById('voicePanel').classList.remove('show');
}

// Handle voice toggle
function handleVoiceToggle(checkbox) {
    voiceEnabled = checkbox.checked;
    updateVoiceButtonState();
    saveVoiceSettings();
    
    if (voiceEnabled) {
        speak('Voice Assistant diaktifkan');
    }
}

// Update voice button state
function updateVoiceButtonState() {
    const btn = document.getElementById('voiceToggle');
    const icon = document.getElementById('voiceIcon');
    
    if (voiceEnabled) {
        btn.classList.remove('disabled');
        icon.className = 'fas fa-volume-up';
    } else {
        btn.classList.add('disabled');
        icon.className = 'fas fa-volume-mute';
    }
}

// Update voice speed
function updateVoiceSpeed(speed) {
    voiceSpeed = parseFloat(speed);
    saveVoiceSettings();
}

// Update voice pitch
function updateVoicePitch(pitch) {
    voicePitch = parseFloat(pitch);
    saveVoiceSettings();
}

// Update voice language
function updateVoiceLang(lang) {
    voiceLang = lang;
    saveVoiceSettings();
}

// Test voice
function testVoice() {
    const testMessage = voiceLang === 'id-ID' 
        ? 'Halo, saya adalah voice assistant untuk Guru BK. Sistem ini siap membantu Anda.' 
        : 'Hello, I am the voice assistant for Guidance Counselor. The system is ready to assist you.';
    speak(testMessage);
}

// Main speak function
function speak(text, options = {}) {
    if (!voiceEnabled || !('speechSynthesis' in window)) {
        return;
    }
    
    // Cancel previous speech
    window.speechSynthesis.cancel();
    
    // Create utterance
    currentUtterance = new SpeechSynthesisUtterance(text);
    currentUtterance.lang = options.lang || voiceLang;
    currentUtterance.rate = options.speed || voiceSpeed;
    currentUtterance.pitch = options.pitch || voicePitch;
    currentUtterance.volume = options.volume || 1.0;
    
    // Show visualizer
    const visualizer = document.getElementById('voiceVisualizer');
    visualizer.classList.add('show');
    
    // Events
    currentUtterance.onend = function() {
        visualizer.classList.remove('show');
    };
    
    currentUtterance.onerror = function() {
        visualizer.classList.remove('show');
    };
    
    // Speak
    window.speechSynthesis.speak(currentUtterance);
}

// Voice notification shortcuts
window.voiceSuccess = function(message) {
    speak(message);
};

window.voiceError = function(message) {
    speak(message, { pitch: 0.8 });
};

window.voiceInfo = function(message) {
    speak(message, { pitch: 1.2 });
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initVoiceSettings();
    
    // Auto-speak page loaded
    setTimeout(() => {
        if (voiceEnabled) {
            const pageName = document.title.split('-')[0].trim();
            speak(`Halaman ${pageName} berhasil dimuat`);
        }
    }, 500);
});

// Close panel when clicking outside
document.addEventListener('click', function(event) {
    const panel = document.getElementById('voicePanel');
    const btn = document.getElementById('voiceToggle');
    
    if (!panel.contains(event.target) && !btn.contains(event.target)) {
        panel.classList.remove('show');
    }
});
</script>
