@extends('layouts.app')

@section('title', 'Sahabat AI - Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    body {
        background: #ffffff;
        overflow: hidden;
    }

    /* Main Container - 2 Column Layout */
    .cortex-container {
        display: flex;
        height: 100vh;
        margin-left: 260px;
        padding-top: 72px;
    }

    /* LEFT SIDEBAR - Navigation Panel */
    .cortex-sidebar {
        width: 280px;
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        overflow-y: auto;
        box-shadow: 1px 0 10px rgba(0, 0, 0, 0.03);
    }

    /* Logo Section */
    .cortex-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding: 0 8px;
    }

    .cortex-logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #C9A8FF 0%, #B48DFF 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(180, 141, 255, 0.3);
    }

    .cortex-logo-text {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        letter-spacing: -0.5px;
    }

    /* New Chat Button */
    .new-chat-btn {
        width: 100%;
        background: #000000;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .new-chat-btn:hover {
        background: #1f2937;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Search Box */
    .search-box {
        position: relative;
        margin-bottom: 24px;
    }

    .search-box input {
        width: 100%;
        padding: 12px 40px 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        background: #f9fafb;
        transition: all 0.2s;
    }

    .search-box input:focus {
        outline: none;
        border-color: #B48DFF;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(180, 141, 255, 0.1);
    }

    .search-box i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    /* Navigation Menu */
    .nav-menu {
        margin-bottom: 24px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 4px;
    }

    .nav-item:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    .nav-item.active {
        background: #faf5ff;
        color: #B48DFF;
    }

    .nav-item i {
        width: 18px;
        font-size: 16px;
    }

    /* Recent Chats Section */
    .recent-section {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .recent-title {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        padding: 0 8px;
    }

    .recent-item {
        padding: 10px 16px;
        color: #6b7280;
        font-size: 13px;
        border-radius: 8px;
        cursor: pointer;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: all 0.2s;
    }

    .recent-item:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    /* RIGHT MAIN AREA - Chat Workspace */
    .cortex-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        position: relative;
    }

    /* Top Header */
    .cortex-header {
        padding: 24px 32px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .header-left-content {
        flex: 1;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    /* Export & Upgrade Buttons */
    .export-btn {
        padding: 10px 20px;
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        color: #1f2937;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .export-btn:hover {
        border-color: #B48DFF;
        background: #faf5ff;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(180, 141, 255, 0.15);
    }

    .upgrade-btn {
        padding: 10px 20px;
        background: #000000;
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upgrade-btn:hover {
        background: #1f2937;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Main Content - Empty State */
    .cortex-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        overflow-y: auto;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }

    /* Central Logo */
    .central-logo {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, rgba(201, 168, 255, 0.3) 0%, rgba(180, 141, 255, 0.3) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
        position: relative;
        box-shadow: 0 8px 32px rgba(180, 141, 255, 0.2);
    }

    .central-logo::before {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        background: linear-gradient(135deg, rgba(201, 168, 255, 0.15) 0%, rgba(180, 141, 255, 0.15) 100%);
        border-radius: 50%;
        z-index: -1;
        animation: pulse 2s infinite;
    }

    .central-logo i {
        font-size: 50px;
        color: #B48DFF;
        filter: drop-shadow(0 4px 8px rgba(180, 141, 255, 0.3));
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.05); opacity: 0.4; }
        100% { transform: scale(1); opacity: 0.7; }
    }

    /* Welcome Text */
    .welcome-text {
        text-align: center;
        margin-bottom: 40px;
    }

    .welcome-greeting {
        font-size: 28px;
        font-weight: 300;
        color: #C9A8FF;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .welcome-question {
        font-size: 36px;
        font-weight: 700;
        color: #1f2937;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    /* Chat Messages Area (when has messages) */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 32px;
        display: none;
        background: #ffffff;
    }

    .chat-messages.active {
        display: block;
    }

    .message {
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        animation: fadeInUp 0.3s ease-out;
    }

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

    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .message-user .message-avatar {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .message-ai .message-avatar {
        background: linear-gradient(135deg, #C9A8FF 0%, #B48DFF 100%);
    }

    .message-content {
        flex: 1;
        padding: 16px 20px;
        border-radius: 16px;
        font-size: 15px;
        line-height: 1.6;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .message-user .message-content {
        background: #f3f4f6;
        color: #1f2937;
        border-bottom-left-radius: 4px;
    }

    .message-ai .message-content {
        background: #faf5ff;
        color: #1f2937;
        border-bottom-right-radius: 4px;
    }

    /* Input Area */
    .cortex-input-area {
        padding: 24px 32px 32px;
        border-top: 1px solid #f3f4f6;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .input-container {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
    }

    .main-input {
        width: 100%;
        padding: 18px 130px 18px 20px;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        font-size: 15px;
        background: #f9fafb;
        resize: none;
        font-family: inherit;
        transition: all 0.2s;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .main-input:focus {
        outline: none;
        border-color: #B48DFF;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(180, 141, 255, 0.15);
    }

    .input-actions {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 8px;
    }

    .input-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: #ffffff;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .input-btn:hover {
        background: #f3f4f6;
        color: #1f2937;
        transform: translateY(-1px);
    }

    .input-btn.send {
        background: linear-gradient(135deg, #C9A8FF 0%, #B48DFF 100%);
        color: #ffffff;
    }

    .input-btn.send:hover {
        background: linear-gradient(135deg, #B48DFF 0%, #9f6ee8 100%);
        transform: translateY(-1px) scale(1.05);
    }

    /* Attach File Button */
    .attach-file {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        margin-top: 12px;
        color: #6b7280;
        font-size: 14px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        max-width: 900px;
        margin: 12px auto 0;
        width: fit-content;
    }

    .attach-file:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    /* Saved Prompts Section */
    .saved-prompts {
        max-width: 900px;
        margin: 0 auto 24px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
    }

    .prompt-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .prompt-card:hover {
        border-color: #B48DFF;
        background: #faf5ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(180, 141, 255, 0.15);
    }

    .prompt-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, rgba(201, 168, 255, 0.2) 0%, rgba(180, 141, 255, 0.2) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        color: #B48DFF;
        font-size: 18px;
    }

    .prompt-title {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .prompt-desc {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: none;
        padding: 16px 20px;
        background: #faf5ff;
        border-radius: 16px;
        width: fit-content;
        margin-bottom: 24px;
        animation: fadeInUp 0.3s ease-out;
    }

    .typing-indicator span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #B48DFF;
        margin: 0 3px;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }

    /* Research Mode Button */
    .research-mode {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #6b7280;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        margin-right: 8px;
    }

    .research-mode:hover {
        background: #f1f5f9;
        border-color: #B48DFF;
    }

    .research-mode.active {
        background: #faf5ff;
        border-color: #B48DFF;
        color: #B48DFF;
    }

    /* Scrollbar */
    .cortex-sidebar::-webkit-scrollbar,
    .cortex-content::-webkit-scrollbar,
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .cortex-sidebar::-webkit-scrollbar-thumb,
    .cortex-content::-webkit-scrollbar-thumb,
    .chat-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .cortex-sidebar::-webkit-scrollbar-thumb:hover,
    .cortex-content::-webkit-scrollbar-thumb:hover,
    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .cortex-sidebar {
            display: none;
        }

        .cortex-container {
            margin-left: 0;
        }
    }

    /* Loading Animation */
    .loading-dots {
        display: inline-flex;
        gap: 4px;
    }

    .loading-dots span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #B48DFF;
        animation: loading 1.4s infinite ease-in-out;
    }

    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes loading {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
</style>
@endpush

@section('content')
<div class="cortex-container">
    <!-- LEFT SIDEBAR -->
    <div class="cortex-sidebar">
        <!-- Logo -->
        <div class="cortex-logo">
            <div class="cortex-logo-icon">
                🎓
            </div>
            <div class="cortex-logo-text">Educounsel</div>
        </div>

        <!-- New Chat Button -->
        <button class="new-chat-btn" onclick="startNewChat()">
            <i class="fas fa-plus"></i>
            New chat
        </button>

        <!-- Search Box -->
        <div class="search-box">
            <input type="text" placeholder="Search conversations..." id="searchInput">
            <i class="fas fa-search"></i>
        </div>

        <!-- Navigation Menu -->
        <div class="nav-menu">
            <div class="nav-item" onclick="window.location.href='{{ route('student.dashboard') }}'">
                <i class="fas fa-compass"></i>
                <span>Explore</span>
            </div>
            <div class="nav-item" onclick="window.location.href=">
                <i class="fas fa-book"></i>
                <span>Library</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-folder"></i>
                <span>Files</span>
            </div>
            <div class="nav-item active" onclick="showHistory()">
                <i class="fas fa-clock"></i>
                <span>History</span>
            </div>
        </div>

        <!-- Recent Chats -->
        <div class="recent-section">
            <div class="recent-title">Recent Chats</div>
            <div id="recentChats">
                <div class="recent-item" style="color: #9ca3af; font-style: italic;">Mulai chat untuk melihat riwayat</div>
            </div>
        </div>
    </div>

    <!-- RIGHT MAIN AREA -->
    <div class="cortex-main">
        <!-- Header -->
        <div class="cortex-header">
            <div class="header-left-content"></div>
            <div class="header-actions">
                <a href="{{ route('student.ai-companion.export-pdf') }}" class="export-btn" id="exportBtn">
                    <i class="fas fa-download"></i>
                    Export chat
                </a>
                <button class="upgrade-btn" onclick="showStats()">
                    <i class="fas fa-chart-line"></i>
                    Stats
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="cortex-content" id="cortexContent">
            <!-- Empty State -->
            <div id="emptyState">
                <!-- Central Logo -->
                <div class="central-logo">
                    <i class="fas fa-robot"></i>
                </div>

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <div class="welcome-greeting">Hello, {{ auth()->user()->nama ?? 'there' }}</div>
                    <div class="welcome-question">How can I assist you today?</div>
                </div>

                <!-- Saved Prompts -->
                <div class="saved-prompts">
                    <div class="prompt-card" onclick="usePrompt('Aku lagi stress dengan tugas sekolah, bisakah kamu bantu aku?')">
                        <div class="prompt-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="prompt-title">Curhat Stress</div>
                        <div class="prompt-desc">Ceritakan tentang kesulitan belajar dan dapatkan dukungan</div>
                    </div>
                    <div class="prompt-card" onclick="usePrompt('Bagaimana cara belajar yang efektif untuk ujian?')">
                        <div class="prompt-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="prompt-title">Tips Belajar</div>
                        <div class="prompt-desc">Dapatkan strategi belajar yang efektif dan produktif</div>
                    </div>
                    <div class="prompt-card" onclick="usePrompt('Aku merasa cemas menjelang ujian, apa yang harus aku lakukan?')">
                        <div class="prompt-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="prompt-title">Kelola Kecemasan</div>
                        <div class="prompt-desc">Teknik untuk mengatasi kecemasan dan stress</div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages (initially hidden) -->
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will be appended here -->
            </div>
        </div>

        <!-- Input Area -->
        <div class="cortex-input-area">
            <div style="display: flex; justify-content: center; margin-bottom: 12px;">
                <div class="research-mode" id="researchMode">
                    <i class="fas fa-search"></i>
                    <span>Deeper Research</span>
                </div>
            </div>
            
            <div class="input-container">
                <textarea 
                    class="main-input" 
                    id="messageInput" 
                    placeholder="Ask me anything..."
                    rows="1"
                    onkeypress="handleKeyPress(event)"></textarea>
                <div class="input-actions">
                    <button class="input-btn" title="Voice Input" id="voiceBtn">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="input-btn send" onclick="sendMessage()" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            <div class="attach-file" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-paperclip"></i>
                <span>Attach file</span>
                <input type="file" id="fileInput" style="display: none;">
            </div>
        </div>
    </div>
</div>

<script>
let conversationHistory = [];
let isResearchMode = false;

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
        this.classList.toggle('active', isResearchMode);
        
        if (isResearchMode) {
            showNotification('Research mode activated - I will provide more detailed responses');
        }
    });
    
    // Auto-resize textarea
    const textarea = document.getElementById('messageInput');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Voice input button
    document.getElementById('voiceBtn').addEventListener('click', function() {
        showNotification('Voice input feature coming soon!');
    });
}

// Use prompt suggestion
function usePrompt(message) {
    document.getElementById('messageInput').value = message;
    document.getElementById('messageInput').focus();
    // Don't auto-send, let user review and send manually
}

// Start new chat
function startNewChat() {
    if (conversationHistory.length === 0 || confirm('Mulai percakapan baru? Riwayat chat saat ini akan tetap tersimpan.')) {
        conversationHistory = [];
        document.getElementById('chatMessages').innerHTML = '';
        document.getElementById('chatMessages').classList.remove('active');
        document.getElementById('emptyState').style.display = 'block';
        document.getElementById('messageInput').value = '';
        document.getElementById('exportBtn').style.opacity = '0.5';
        
        showNotification('New chat started');
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
        document.getElementById('emptyState').style.display = 'none';
        chatMessages.classList.add('active');
        document.getElementById('exportBtn').style.opacity = '1';
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
    .then(response => response.json())
    .then(data => {
        hideTypingIndicator();
        
        if (data.success) {
            addMessageToUI(data.message, 'assistant');
            conversationHistory.push(
                { role: 'user', message: message },
                { role: 'assistant', message: data.message }
            );
            
            // Update sidebar with new chat
            updateRecentChats(conversationHistory);
            
            // Enable export button
            document.getElementById('exportBtn').style.opacity = '1';
        } else {
            addMessageToUI(data.message || 'Maaf, terjadi kesalahan. Coba lagi ya!', 'assistant');
        }
    })
    .catch(error => {
        hideTypingIndicator();
        console.error('Error:', error);
        addMessageToUI('Maaf, koneksi bermasalah. Pastikan .env sudah diconfig dengan benar! 😊', 'assistant');
    });
}

// Add message to UI
function addMessageToUI(message, role, scroll = true) {
    const chatMessages = document.getElementById('chatMessages');
    
    // Hide empty state
    document.getElementById('emptyState').style.display = 'none';
    chatMessages.classList.add('active');
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message message-${role}`;
    
    const avatar = document.createElement('div');
    avatar.className = 'message-avatar';
    avatar.innerHTML = role === 'user' ? '👤' : '🤖';
    
    const content = document.createElement('div');
    content.className = 'message-content';
    
    // Format message with basic markdown-like styling
    const formattedMessage = message
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\n/g, '<br>');
    
    content.innerHTML = formattedMessage;
    
    messageDiv.appendChild(avatar);
    messageDiv.appendChild(content);
    chatMessages.appendChild(messageDiv);
    
    if (scroll) scrollToBottom();
}

// Typing indicator
function showTypingIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'typing-indicator';
    indicator.id = 'typingIndicator';
    indicator.innerHTML = '<span></span><span></span><span></span>';
    indicator.style.display = 'block';
    
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
        recentChatsDiv.innerHTML = '<div class="recent-item" style="color: #9ca3af; font-style: italic;">Belum ada percakapan</div>';
        return;
    }
    
    // Get unique user messages (chat sessions)
    const userMessages = conversations.filter(conv => conv.role === 'user');
    const recentMessages = userMessages.slice(-5).reverse(); // Last 5 chats
    
    let html = '';
    recentMessages.forEach((msg, index) => {
        const preview = msg.message.substring(0, 40) + (msg.message.length > 40 ? '...' : '');
        html += `<div class="recent-item" onclick="scrollToBottom()">${preview}</div>`;
    });
    
    recentChatsDiv.innerHTML = html || '<div class="recent-item" style="color: #9ca3af;">Belum ada percakapan</div>';
}

// Show stats
function showStats() {
    fetch('{{ route("student.ai-companion.stats") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.stats;
                alert(`📊 Statistik Chat:\n\nTotal: ${stats.total_messages} pesan\nHari ini: ${stats.today_messages} pesan\nMinggu ini: ${stats.week_messages} pesan`);
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
        });
}

// Show history
function showHistory() {
    loadHistory();
    showNotification('Menampilkan riwayat percakapan');
}

// Show notification
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 30px;
        background: #1f2937;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease-out;
    `;
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

// Add CSS for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection