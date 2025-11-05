@extends('layouts.app')

@section('title', 'EDU AI - Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<style>
    * {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    
    /* Custom animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse-recording {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
    }
    
    @keyframes typing {
        0%, 60%, 100% { 
            transform: translateY(0); 
            opacity: 0.4;
        }
        30% { 
            transform: translateY(-8px); 
            opacity: 1;
        }
    }
    
    .animate-typing {
        animation: typing 1.4s ease-in-out infinite;
    }
    
    @keyframes loading {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    /* Smooth scroll for chat messages */
    #chatMessages {
        scroll-behavior: smooth;
    }
    
    /* Empty state styling */
    #chatMessages:empty::before {
        content: '💬 Start chatting with EDU AI Assistant...';
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #9ca3af;
        font-size: 1rem;
        font-weight: 500;
    }
    
    /* Auto-resize textarea */
    #messageInput {
        max-height: 150px;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- LEFT SIDEBAR -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col h-full">
        <!-- User Profile -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-300 to-purple-400 rounded-full flex items-center justify-center text-white text-xl mb-3">
                    👤
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-900 font-medium text-base">{{ auth()->user()->nama ?? 'Jane Cooper' }}</span>
                    <i class="fas fa-cog text-gray-500 text-sm cursor-pointer hover:text-purple-600 transition-colors"></i>
                </div>
            </div>
        </div>

        <!-- Search Box -->
        <div class="p-4">
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search for chats..." 
                    class="w-full pl-10 pr-4 py-3 bg-gray-50 rounded-xl border-none focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:bg-white text-gray-900 text-sm"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"></i>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="px-4 pb-4">
            <div class="space-y-1">
                <div class="nav-item flex items-center justify-between px-4 py-3 rounded-xl bg-purple-50 text-purple-600 cursor-pointer transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-comment text-sm"></i>
                        <span class="text-sm font-medium">Chats</span>
                    </div>
                    <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full">24</span>
                </div>
                
                <div class="nav-item flex items-center justify-between px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 cursor-pointer transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-book text-sm"></i>
                        <span class="text-sm font-medium">Library</span>
                    </div>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">12</span>
                </div>
                
                <div class="nav-item flex items-center justify-between px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 cursor-pointer transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-cube text-sm"></i>
                        <span class="text-sm font-medium">Apps</span>
                    </div>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">8</span>
                </div>
            </div>
        </div>

        <!-- Pinned Section -->
        <div class="px-4 pb-4">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-2">Pinned</div>
            <div class="space-y-1">
                <div class="recent-item px-4 py-2 rounded-lg text-gray-800 hover:text-purple-600 hover:bg-purple-50 cursor-pointer transition-all text-sm">
                    Mathematics Homework Help
                </div>
                <div class="recent-item px-4 py-2 rounded-lg text-gray-800 hover:text-purple-600 hover:bg-purple-50 cursor-pointer transition-all text-sm">
                    Science Project Discussion
                </div>
                <div class="recent-item px-4 py-2 rounded-lg text-gray-800 hover:text-purple-600 hover:bg-purple-50 cursor-pointer transition-all text-sm">
                    Career Guidance Session
                </div>
            </div>
        </div>

        <!-- Chat History Section -->
        <div class="px-4 pb-4 flex-1">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-2">Chat History</div>
            <div id="recentChats" class="space-y-1">
                <div class="recent-item px-4 py-2 rounded-lg text-gray-400 italic cursor-pointer text-sm">
                    Mulai chat untuk melihat riwayat
                </div>
            </div>
        </div>

        <!-- New Chat Button -->
        <div class="p-4 border-t border-gray-200">
            <button onclick="startNewChat()" class="new-chat-btn w-full bg-purple-600 hover:bg-purple-700 text-white rounded-xl py-3 px-4 font-semibold text-sm flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-purple-500/25">
                <i class="fas fa-plus"></i>
                Start New Chat
            </button>
        </div>
    </div>

    <!-- RIGHT MAIN AREA -->
    <div class="flex-1 flex flex-col bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-10 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Chats</h1>
            </div>
            <div class="relative w-80">
                <input 
                    type="text" 
                    placeholder="Search for chats..." 
                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-gray-900 text-sm"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"></i>
            </div>
        </div>

        <!-- Welcome Hero Card -->
        <div class="bg-gradient-to-r from-blue-300 to-purple-400 rounded-2xl mx-10 my-6 p-10 text-white shadow-xl shadow-blue-500/25">
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->nama ?? 'Jane' }}</h2>
            <p class="text-white/90 text-sm mb-6">Search or ask AI for anything that you want to know</p>
            
            <!-- Research Mode Toggle -->
            <div class="flex justify-center mb-4">
                <div class="research-mode flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg text-white text-sm cursor-pointer transition-all hover:bg-white/30" id="researchMode">
                    <i class="fas fa-search"></i>
                    <span>Deeper Research</span>
                </div>
            </div>
            
            <!-- Main Input Area -->
            <div class="relative max-w-2xl">
                <textarea 
                    id="messageInput"
                    placeholder="How can I help you?" 
                    rows="1"
                    class="w-full px-5 py-4 pr-32 rounded-2xl border-none focus:outline-none text-gray-900 text-sm shadow-lg resize-none"
                    onkeypress="handleKeyPress(event)"
                ></textarea>
                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 flex gap-2">
                    <button id="voiceBtn" class="w-10 h-10 bg-white hover:bg-gray-50 rounded-full flex items-center justify-center text-gray-600 transition-all shadow-md" title="Voice Input">
                        <i class="fas fa-microphone text-sm"></i>
                    </button>
                    <button onclick="sendMessage()" id="sendBtn" class="w-10 h-10 bg-purple-600 hover:bg-purple-700 text-white rounded-full flex items-center justify-center transition-all transform hover:scale-105 shadow-lg shadow-purple-500/25">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                    <button onclick="confirmDeleteChat()" class="w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-all transform hover:scale-105 shadow-lg shadow-red-500/25" title="Delete Chat">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            </div>
            
            <!-- Attach File -->
            <div class="flex items-center justify-center gap-2 mt-4 text-white/80 text-sm cursor-pointer hover:text-white transition-colors" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-paperclip"></i>
                <span>Attach file</span>
                <input type="file" id="fileInput" class="hidden">
            </div>
        </div>

        <!-- Chat Interface (Always visible) -->
        <div id="chatInterface" class="flex-1 flex flex-col overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-lg shadow-sm">
                        🤖
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">EDU AI Assistant</h3>
                        <p class="text-xs text-gray-500">Always here to help you</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="exportChat()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        Export
                    </button>
                    <button onclick="confirmDeleteChat()" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        Delete Chat
                    </button>
                </div>
            </div>
            
            <!-- Messages Area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-8 space-y-6 bg-white">
                <!-- Messages will be dynamically added here -->
            </div>
        </div>
    </div>
</div>

<script>
let conversationHistory = [];
let isResearchMode = false;
let currentSpeech = null;
let isSpeaking = false;

// Text-to-Speech Initialization
const synth = window.speechSynthesis;
let utterance = null;

// Load history on page load
document.addEventListener('DOMContentLoaded', function() {
    loadHistory();
    setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
    // Research mode toggle
    document.getElementById('researchMode').addEventListener('click', function() {
        isResearchMode = !isResearchMode;
        
        if (isResearchMode) {
            this.classList.add('bg-white/40', 'border-white/50');
            this.classList.remove('bg-white/20', 'border-white/30');
            showNotification('🔬 Research mode activated - Detailed responses');
        } else {
            this.classList.remove('bg-white/40', 'border-white/50');
            this.classList.add('bg-white/20', 'border-white/30');
            showNotification('💬 Normal mode activated');
        }
    });
    
    // Auto-resize textarea
    const textarea = document.getElementById('messageInput');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Voice input button - Initialize Speech Recognition
    const voiceBtn = document.getElementById('voiceBtn');
    const messageInput = document.getElementById('messageInput');
    let recognition = null;
    let isRecording = false;

    // Check if browser supports Speech Recognition
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.lang = 'id-ID'; // Bahasa Indonesia
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        recognition.onstart = function() {
            isRecording = true;
            voiceBtn.classList.add('bg-red-500', 'text-white', 'border-red-500');
            voiceBtn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
            voiceBtn.innerHTML = '<i class="fas fa-stop text-sm"></i>';
            showNotification('🎤 Listening... Speak now!');
        };

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            messageInput.value = transcript;
            messageInput.focus();
            // Auto resize textarea
            messageInput.style.height = 'auto';
            messageInput.style.height = (messageInput.scrollHeight) + 'px';
            showNotification('✅ Voice captured successfully!');
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            isRecording = false;
            voiceBtn.classList.remove('bg-red-500', 'text-white', 'border-red-500');
            voiceBtn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            voiceBtn.innerHTML = '<i class="fas fa-microphone text-sm"></i>';
            
            let errorMsg = '';
            
            switch(event.error) {
                case 'no-speech':
                    errorMsg = '⚠️ Tidak mendengar suara. Coba lagi dan bicara lebih jelas.';
                    showNotification(errorMsg);
                    break;
                case 'audio-capture':
                    errorMsg = '⚠️ Microphone tidak ditemukan. Pastikan microphone terhubung.';
                    showNotification(errorMsg);
                    break;
                case 'not-allowed':
                    // Show detailed alert for permission denied
                    setTimeout(() => {
                        alert('🔴 MICROPHONE AKSES DITOLAK!\n\n' +
                            '📋 Langkah untuk mengizinkan:\n\n' +
                            '1️⃣ Klik icon 🔒 di sebelah URL (address bar)\n' +
                            '2️⃣ Cari pengaturan "Microphone"\n' +
                            '3️⃣ Ubah dari "Block" ke "Allow"\n' +
                            '4️⃣ Refresh halaman ini (F5)\n' +
                            '5️⃣ Klik tombol 🎤 lagi\n\n' +
                            '💡 Tip: Pastikan microphone tidak sedang digunakan aplikasi lain!\n\n' +
                            'URL: ' + window.location.hostname);
                    }, 100);
                    break;
                case 'network':
                    errorMsg = '⚠️ Kesalahan jaringan. Periksa koneksi internet Anda.';
                    showNotification(errorMsg);
                    break;
                case 'aborted':
                    // Silent error, user probably stopped it
                    console.log('Voice input aborted by user');
                    break;
                default:
                    errorMsg = '⚠️ Kesalahan voice recognition: ' + event.error;
                    showNotification(errorMsg);
            }
        };

        recognition.onend = function() {
            isRecording = false;
            voiceBtn.classList.remove('bg-red-500', 'text-white', 'border-red-500');
            voiceBtn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            voiceBtn.innerHTML = '<i class="fas fa-microphone text-sm"></i>';
        };

        voiceBtn.addEventListener('click', async function() {
            if (isRecording) {
                recognition.stop();
                showNotification('🛑 Voice input stopped');
            } else {
                // Debug: Check permission status
                console.log('=== Voice Button Clicked ===');
                console.log('Browser:', navigator.userAgent);
                console.log('HTTPS:', window.location.protocol === 'https:');
                
                // Check if microphone permission API is available
                if (navigator.permissions && navigator.permissions.query) {
                    try {
                        const permissionStatus = await navigator.permissions.query({ name: 'microphone' });
                        console.log('Microphone permission status:', permissionStatus.state);
                        
                        if (permissionStatus.state === 'denied') {
                            alert('❌ MICROPHONE DI-BLOCK!\n\n' +
                                'Permission status: DENIED\n\n' +
                                'Cara fix:\n' +
                                '1. Klik icon 🔒 di address bar\n' +
                                '2. Klik "Reset izin"\n' +
                                '3. Refresh halaman (F5)\n' +
                                '4. Klik 🎤 lagi dan pilih "Izinkan"');
                            return;
                        }
                    } catch (err) {
                        console.log('Permission API not available:', err);
                    }
                }
                
                try {
                    console.log('Attempting to start recognition...');
                    recognition.start();
                    console.log('✅ Speech recognition started successfully');
                } catch (error) {
                    console.error('❌ Error starting recognition:', error);
                    console.error('Error name:', error.name);
                    console.error('Error message:', error.message);
                    
                    if (error.name === 'InvalidStateError') {
                        console.log('Recognition already running, stopping first...');
                        // Recognition is already started, stop it first
                        recognition.stop();
                        setTimeout(() => {
                            try {
                                console.log('Retrying recognition start...');
                                recognition.start();
                                console.log('✅ Retry successful');
                            } catch (e) {
                                console.error('❌ Retry failed:', e);
                                showNotification('⚠️ Gagal memulai voice recognition. Refresh halaman (F5).');
                            }
                        }, 200);
                    } else if (error.name === 'NotAllowedError') {
                        console.error('❌ NotAllowedError - Permission denied at start');
                        alert('❌ PERMISSION ERROR!\n\n' +
                            'Browser block akses microphone.\n\n' +
                            'Solusi:\n' +
                            '1. Tutup browser sepenuhnya\n' +
                            '2. Buka lagi\n' +
                            '3. Buka chatbot\n' +
                            '4. Saat popup muncul, klik IZINKAN\n\n' +
                            'Current permission sudah diset tapi browser masih block.');
                    } else {
                        showNotification('⚠️ Gagal memulai voice recognition: ' + error.name);
                    }
                }
            }
        });
    } else {
        // Browser doesn't support Speech Recognition
        voiceBtn.addEventListener('click', function() {
            showNotification('⚠️ Voice input not supported in this browser. Please use Chrome or Edge.');
        });
        voiceBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

// Start new chat
function startNewChat() {
    if (conversationHistory.length === 0 || confirm('Mulai percakapan baru? Riwayat chat saat ini akan tetap tersimpan.')) {
        stopSpeaking(); // Stop any ongoing speech
        conversationHistory = [];
        document.getElementById('chatMessages').innerHTML = '';
        document.getElementById('messageInput').value = '';
        
        showNotification('✅ New chat started');
    }
}

// Confirm delete chat
function confirmDeleteChat() {
    if (conversationHistory.length === 0) {
        showNotification('⚠️ No chat to delete');
        return;
    }
    
    if (confirm('⚠️ Are you sure you want to delete this entire chat? This action cannot be undone.')) {
        stopSpeaking();
        conversationHistory = [];
        document.getElementById('chatMessages').innerHTML = '';
        document.getElementById('messageInput').value = '';
        
        // Save empty history to server
        fetch('{{ route("student.ai-companion.save-history") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ history: [] })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('🗑️ Chat deleted successfully');
            } else {
                showNotification('⚠️ Failed to delete chat from server');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showNotification('⚠️ Error deleting chat');
        });
    }
}

// Export chat
function exportChat() {
    if (conversationHistory.length === 0) {
        showNotification('⚠️ No chat to export');
        return;
    }
    window.location.href = '{{ route("student.ai-companion.export-pdf") }}';
    showNotification('📥 Exporting chat...');
}

// Text-to-Speech Functions
function speakText(text, messageId) {
    // Stop any ongoing speech first
    stopSpeaking();
    
    utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'id-ID';
    utterance.rate = 1.0;
    utterance.pitch = 1.0;
    utterance.volume = 1.0;
    
    // Update UI when speaking starts
    utterance.onstart = function() {
        isSpeaking = true;
        const speakBtn = document.getElementById('speak-' + messageId);
        if (speakBtn) {
            speakBtn.innerHTML = '<i class="fas fa-stop text-sm"></i>';
            speakBtn.classList.add('bg-purple-600', 'text-white');
            speakBtn.classList.remove('bg-purple-50', 'text-purple-600');
        }
        showNotification('🔊 Speaking...');
    };
    
    // Update UI when speaking ends
    utterance.onend = function() {
        isSpeaking = false;
        const speakBtn = document.getElementById('speak-' + messageId);
        if (speakBtn) {
            speakBtn.innerHTML = '<i class="fas fa-volume-up text-sm"></i>';
            speakBtn.classList.remove('bg-purple-600', 'text-white');
            speakBtn.classList.add('bg-purple-50', 'text-purple-600');
        }
    };
    
    utterance.onerror = function(event) {
        console.error('Speech synthesis error:', event);
        showNotification('⚠️ Failed to speak');
        isSpeaking = false;
    };
    
    currentSpeech = utterance;
    synth.speak(utterance);
}

function stopSpeaking() {
    if (synth.speaking || isSpeaking) {
        synth.cancel();
        isSpeaking = false;
        
        // Reset all speak buttons
        document.querySelectorAll('[id^="speak-"]').forEach(btn => {
            btn.innerHTML = '<i class="fas fa-volume-up text-sm"></i>';
            btn.classList.remove('bg-purple-600', 'text-white');
            btn.classList.add('bg-purple-50', 'text-purple-600');
        });
    }
}

function toggleSpeak(text, messageId) {
    if (isSpeaking) {
        stopSpeaking();
        showNotification('🔇 Speech stopped');
    } else {
        speakText(text, messageId);
    }
}

// Load conversation history
function loadHistory() {
    fetch('{{ route("student.ai-companion.history") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.conversations.length > 0) {
                conversationHistory = data.conversations;
                displayHistory();
                updateRecentChats(data.conversations);
            }
        })
        .catch(error => {
            console.error('Error loading history:', error);
        });
}

// Display conversation history
function displayHistory() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.innerHTML = '';
    
    conversationHistory.forEach(conv => {
        addMessageToUI(conv.message, conv.role, false);
    });
    
    if (conversationHistory.length > 0) {
        scrollToBottom();
    }
}

// Send message
function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Add user message to UI
    addMessageToUI(message, 'user');
    input.value = '';
    input.style.height = 'auto';
    
    // Show typing indicator
    showTypingIndicator();
    
    // Send to real API
    fetch('{{ route("student.ai-companion.chat") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            message: message,
            research_mode: isResearchMode 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideTypingIndicator();
        
        if (data.success) {
            // Extract AI message from response
            const aiMessage = data.ai_message?.message || data.message || 'Maaf, tidak ada respon dari AI.';
            
            addMessageToUI(aiMessage, 'assistant');
            conversationHistory.push(
                { role: 'user', message: message },
                { role: 'assistant', message: aiMessage }
            );
            
            // Update sidebar with new chat
            updateRecentChats(conversationHistory);
            
            // Show crisis warning if detected
            if (data.is_crisis && data.voice_message) {
                setTimeout(() => {
                    showNotification('⚠️ ' + data.voice_message);
                }, 1000);
            }
        } else {
            addMessageToUI(data.message || 'Maaf, terjadi kesalahan. Coba lagi ya!', 'assistant');
        }
    })
    .catch(error => {
        hideTypingIndicator();
        console.error('Error:', error);
        
        // More specific error messages
        let errorMsg = 'Maaf, terjadi kesalahan. ';
        if (error.message.includes('401') || error.message.includes('403')) {
            errorMsg += 'Kamu belum login. Silakan login terlebih dahulu! 🔐';
        } else if (error.message.includes('429')) {
            errorMsg += 'Terlalu banyak request. Tunggu sebentar ya! ⏳';
        } else if (error.message.includes('500')) {
            errorMsg += 'Server error. Pastikan API key sudah diconfig di .env! 🔧';
        } else {
            errorMsg += 'Koneksi bermasalah. Cek internet atau config .env kamu! 😊';
        }
        
        addMessageToUI(errorMsg, 'assistant', true, true);
    });
}

// Add message to UI
function addMessageToUI(message, role, scroll = true, isError = false) {
    const chatMessages = document.getElementById('chatMessages');
    const messageId = 'msg-' + Date.now();
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex gap-4 ${role === 'user' ? 'justify-end' : 'justify-start'}`;
    messageDiv.id = messageId;
    
    if (role === 'user') {
        messageDiv.innerHTML = `
            <div class="flex flex-col items-end max-w-3/4">
                <div class="bg-gray-100 text-gray-900 rounded-2xl rounded-br-md px-5 py-3 text-sm shadow-sm">
                    ${message.replace(/\n/g, '<br>')}
                </div>
            </div>
            <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm shadow-sm flex-shrink-0">
                👤
            </div>
        `;
    } else {
        const cleanMessage = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        messageDiv.innerHTML = `
            <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm shadow-sm flex-shrink-0">
                🤖
            </div>
            <div class="flex flex-col max-w-3/4 gap-2">
                <div class="bg-purple-50 text-gray-900 rounded-2xl rounded-bl-md px-5 py-3 text-sm border-l-4 ${isError ? 'border-red-500 bg-red-50' : 'border-purple-500'} shadow-sm">
                    ${cleanMessage.replace(/\n/g, '<br>')}
                </div>
                ${!isError ? `
                <div class="flex items-center gap-2">
                    <button 
                        id="speak-${messageId}"
                        onclick="toggleSpeak(\`${message.replace(/'/g, "\\'").replace(/`/g, "\\`")}\`, '${messageId}')"
                        class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg text-xs font-medium transition-all flex items-center gap-1.5 shadow-sm"
                        title="Listen to response"
                    >
                        <i class="fas fa-volume-up text-sm"></i>
                        <span>Listen</span>
                    </button>
                    <button 
                        onclick="copyToClipboard(\`${message.replace(/'/g, "\\'").replace(/`/g, "\\`")}\`)"
                        class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg text-xs font-medium transition-all flex items-center gap-1.5 shadow-sm"
                        title="Copy response"
                    >
                        <i class="fas fa-copy text-sm"></i>
                        <span>Copy</span>
                    </button>
                </div>
                ` : ''}
            </div>
        `;
    }
    
    messageDiv.style.animation = 'fadeInUp 0.3s ease-out';
    chatMessages.appendChild(messageDiv);
    
    if (scroll) scrollToBottom();
    
    return messageId;
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('📋 Copied to clipboard');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showNotification('⚠️ Failed to copy');
    });
}

// Typing indicator
function showTypingIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'flex gap-4 justify-start';
    indicator.id = 'typingIndicator';
    indicator.innerHTML = `
        <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm shadow-sm">
            🤖
        </div>
        <div class="bg-purple-50 text-gray-900 rounded-2xl rounded-bl-md px-5 py-4 text-sm border-l-4 border-purple-500 shadow-sm">
            <div class="flex gap-1">
                <span class="w-2 h-2 bg-purple-500 rounded-full animate-typing"></span>
                <span class="w-2 h-2 bg-purple-500 rounded-full animate-typing" style="animation-delay: 0.2s"></span>
                <span class="w-2 h-2 bg-purple-500 rounded-full animate-typing" style="animation-delay: 0.4s"></span>
            </div>
        </div>
    `;
    
    document.getElementById('chatMessages').appendChild(indicator);
    scrollToBottom();
}

function hideTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) indicator.remove();
}

// Scroll to bottom
function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Handle enter key
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

// Update recent chats in sidebar
function updateRecentChats(conversations) {
    const recentChatsDiv = document.getElementById('recentChats');
    
    if (!conversations || conversations.length === 0) {
        recentChatsDiv.innerHTML = '<div class="recent-item px-4 py-2 rounded-lg text-gray-400 italic cursor-pointer text-sm">Belum ada percakapan</div>';
        return;
    }
    
    // Get unique user messages (chat sessions)
    const userMessages = conversations.filter(conv => conv.role === 'user');
    const recentMessages = userMessages.slice(-5).reverse(); // Last 5 chats
    
    let html = '';
    recentMessages.forEach((msg, index) => {
        const preview = msg.message.substring(0, 40) + (msg.message.length > 40 ? '...' : '');
        html += `<div class="recent-item px-4 py-2 rounded-lg text-gray-800 hover:text-purple-600 hover:bg-purple-50 cursor-pointer transition-all text-sm">${preview}</div>`;
    });
    
    recentChatsDiv.innerHTML = html || '<div class="recent-item px-4 py-2 rounded-lg text-gray-400 italic cursor-pointer text-sm">Belum ada percakapan</div>';
}

// Show notification
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-8 bg-gray-900 text-white px-5 py-3 rounded-xl text-sm z-50 shadow-xl';
    notification.style.animation = 'slideInRight 0.3s ease-out';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endsection