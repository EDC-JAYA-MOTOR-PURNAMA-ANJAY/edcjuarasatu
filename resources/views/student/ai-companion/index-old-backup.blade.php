@extends('layouts.app')

@section('title', 'Sahabat AI - Educounsel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Inter', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Chat Container */
    .chat-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        height: calc(100vh - 64px);
        display: flex;
        flex-direction: column;
    }

    /* Header Card */
    .chat-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px 24px 0 0;
        padding: 24px 32px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .ai-avatar {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        50% {
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.6);
        }
    }

    .ai-info h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .ai-status {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #10b981;
        margin-top: 4px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        animation: blink 2s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        background: #f3f4f6;
        border: none;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 18px;
    }

    .action-btn:hover {
        background: #e5e7eb;
        transform: scale(1.05);
    }

    /* Chat Messages Area */
    .chat-messages {
        flex: 1;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 32px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: #f3f4f6;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 80px;
        margin-bottom: 20px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 16px;
        line-height: 1.6;
        max-width: 500px;
        margin: 0 auto 24px;
    }

    .suggestion-chips {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .chip {
        background: white;
        border: 2px solid #e5e7eb;
        padding: 12px 20px;
        border-radius: 24px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
    }

    .chip:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }

    /* Message Bubbles */
    .message {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.user {
        flex-direction: row-reverse;
    }

    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .message-avatar.ai {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .message-avatar.user {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .message-content {
        max-width: 60%;
    }

    .message-bubble {
        padding: 14px 18px;
        border-radius: 18px;
        word-wrap: break-word;
        line-height: 1.5;
        font-size: 15px;
    }

    .message.ai .message-bubble {
        background: white;
        color: #1f2937;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-bottom-left-radius: 4px;
    }

    .message.user .message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .message-time {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 6px;
        padding: 0 4px;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        align-items: flex-end;
        gap: 12px;
    }

    .typing-bubble {
        background: white;
        padding: 16px 20px;
        border-radius: 18px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .typing-dots {
        display: flex;
        gap: 6px;
    }

    .typing-dots span {
        width: 8px;
        height: 8px;
        background: #9ca3af;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out;
    }

    .typing-dots span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes bounce {
        0%, 80%, 100% {
            transform: scale(0);
        }
        40% {
            transform: scale(1);
        }
    }

    /* Input Area */
    .chat-input {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 0 0 24px 24px;
        padding: 24px 32px;
        box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.1);
    }

    .input-wrapper {
        display: flex;
        gap: 12px;
        align-items: flex-end;
    }

    .input-field {
        flex: 1;
        background: #f3f4f6;
        border: 2px solid transparent;
        border-radius: 24px;
        padding: 14px 20px;
        font-size: 15px;
        transition: all 0.2s;
        resize: none;
        max-height: 120px;
        font-family: 'Inter', sans-serif;
    }

    .input-field:focus {
        outline: none;
        border-color: #667eea;
        background: white;
    }

    .send-btn {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .send-btn:hover:not(:disabled) {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Stats Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        animation: modalSlideUp 0.3s ease-out;
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .modal-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .close-modal {
        width: 32px;
        height: 32px;
        background: #f3f4f6;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.2s;
    }

    .close-modal:hover {
        background: #e5e7eb;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 16px;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chat-header {
            padding: 16px 20px;
            border-radius: 16px 16px 0 0;
        }

        .ai-avatar {
            width: 48px;
            height: 48px;
            font-size: 24px;
        }

        .ai-info h1 {
            font-size: 20px;
        }

        .chat-messages {
            padding: 20px;
        }

        .message-content {
            max-width: 75%;
        }

        .chat-input {
            padding: 16px 20px;
            border-radius: 0 0 16px 16px;
        }

        .suggestion-chips {
            flex-direction: column;
        }

        .chip {
            width: 100%;
        }
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="chat-container">
    <!-- Header -->
    <div class="chat-header">
        <div class="header-left">
            <div class="ai-avatar">🤖</div>
            <div class="ai-info">
                <h1>Sahabat AI</h1>
                <div class="ai-status">
                    <span class="status-dot"></span>
                    <span>Online - Siap Bantu Kamu 24/7</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <button class="action-btn" onclick="showStats()" title="Statistik">
                📊
            </button>
            <a href="{{ route('student.ai-companion.export-pdf') }}" class="action-btn" title="Export Chat ke PDF" style="text-decoration: none; color: inherit;">
                📄
            </a>
            <button class="action-btn" onclick="confirmClearHistory()" title="Hapus Riwayat">
                🗑️
            </button>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="chat-messages" id="chatMessages">
        <!-- Empty State -->
        <div class="empty-state" id="emptyState">
            <div class="empty-state-icon">💭</div>
            <h3>Halo {{ Auth::user()->nama }}! 👋</h3>
            <p>
                Aku adalah <strong>Sahabat AI</strong>, teman curhat yang siap mendengarkan kamu kapan saja. 
                Cerita aja apa yang ada di pikiran kamu, aku di sini untuk support!
            </p>
            <div class="suggestion-chips">
                <div class="chip" onclick="sendQuickMessage('Halo! Aku mau cerita tentang hari ini')">
                    💬 Cerita hari ini
                </div>
                <div class="chip" onclick="sendQuickMessage('Aku lagi stress dengan tugas sekolah')">
                    😔 Curhat stress
                </div>
                <div class="chip" onclick="sendQuickMessage('Gimana cara manage waktu yang baik?')">
                    ⏰ Tips waktu
                </div>
            </div>
        </div>

        <!-- Messages will be appended here -->
    </div>

    <!-- Input Area -->
    <div class="chat-input">
        <div class="input-wrapper">
            <textarea 
                id="messageInput" 
                class="input-field" 
                placeholder="Ketik pesan kamu di sini... 💭"
                rows="1"
                maxlength="2000"
            ></textarea>
            <button class="send-btn" id="sendBtn" onclick="sendMessage()" disabled>
                ✈️
            </button>
        </div>
    </div>
</div>

<!-- Stats Modal -->
<div class="modal" id="statsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📊 Statistik Chat</h3>
            <button class="close-modal" onclick="closeModal('statsModal')">✕</button>
        </div>
        <div id="statsContent">
            <div class="stat-card">
                <div class="stat-label">Total Percakapan</div>
                <div class="stat-value">{{ $stats['total_conversations'] ?? 0 }}</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stat-label">Chat Hari Ini</div>
                <div class="stat-value">{{ $stats['today'] ?? 0 }}</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stat-label">Chat Minggu Ini</div>
                <div class="stat-value">{{ $stats['this_week'] ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize
let isLoading = false;
const messagesContainer = document.getElementById('chatMessages');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');
const emptyState = document.getElementById('emptyState');

// Load chat history on page load
document.addEventListener('DOMContentLoaded', function() {
    loadHistory();
    
    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        
        // Enable/disable send button
        sendBtn.disabled = this.value.trim() === '';
    });
    
    // Send on Enter (Shift+Enter for new line)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!sendBtn.disabled) {
                sendMessage();
            }
        }
    });
});

// Load chat history
function loadHistory() {
    fetch('{{ route("student.ai-companion.history") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.conversations.length > 0) {
                emptyState.style.display = 'none';
                data.conversations.forEach(conv => {
                    appendMessage(conv.role, conv.message, formatTime(conv.created_at));
                });
                scrollToBottom();
            }
        })
        .catch(error => console.error('Error loading history:', error));
}

// Send message
async function sendMessage() {
    const message = messageInput.value.trim();
    if (!message || isLoading) return;
    
    // Hide empty state
    emptyState.style.display = 'none';
    
    // Append user message
    appendMessage('user', message, 'Sekarang');
    
    // Clear input
    messageInput.value = '';
    messageInput.style.height = 'auto';
    sendBtn.disabled = true;
    
    // Show typing indicator
    showTyping();
    isLoading = true;
    
    try {
        const response = await fetch('{{ route("student.ai-companion.chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        });
        
        const data = await response.json();
        
        // Remove typing indicator
        removeTyping();
        
        if (data.success) {
            // Append AI response
            appendMessage('assistant', data.ai_message.message, data.ai_message.created_at);
            
            // Voice notification if crisis
            if (data.is_crisis && data.voice_message && window.voiceHelper) {
                setTimeout(() => {
                    window.voiceHelper.speakWarning(data.voice_message);
                }, 1000);
            }
        } else {
            appendMessage('assistant', data.message || 'Maaf, terjadi kesalahan. Coba lagi ya! 🙏', 'Sekarang');
        }
    } catch (error) {
        console.error('Error:', error);
        removeTyping();
        appendMessage('assistant', 'Ups, koneksi bermasalah. Coba lagi ya! 😊', 'Sekarang');
    } finally {
        isLoading = false;
    }
}

// Append message to chat
function appendMessage(role, message, time) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${role}`;
    
    const avatar = document.createElement('div');
    avatar.className = `message-avatar ${role}`;
    avatar.textContent = role === 'user' ? '{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}' : '🤖';
    
    const content = document.createElement('div');
    content.className = 'message-content';
    
    const bubble = document.createElement('div');
    bubble.className = 'message-bubble';
    bubble.textContent = message;
    
    const timeDiv = document.createElement('div');
    timeDiv.className = 'message-time';
    timeDiv.textContent = time;
    
    content.appendChild(bubble);
    content.appendChild(timeDiv);
    
    messageDiv.appendChild(avatar);
    messageDiv.appendChild(content);
    
    messagesContainer.appendChild(messageDiv);
    scrollToBottom();
}

// Show typing indicator
function showTyping() {
    const typingDiv = document.createElement('div');
    typingDiv.className = 'typing-indicator';
    typingDiv.id = 'typingIndicator';
    
    typingDiv.innerHTML = `
        <div class="message-avatar ai">🤖</div>
        <div class="typing-bubble">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(typingDiv);
    scrollToBottom();
}

// Remove typing indicator
function removeTyping() {
    const typing = document.getElementById('typingIndicator');
    if (typing) typing.remove();
}

// Quick message
function sendQuickMessage(message) {
    messageInput.value = message;
    sendBtn.disabled = false;
    sendMessage();
}

// Scroll to bottom
function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Format time
function formatTime(datetime) {
    if (!datetime) return 'Sekarang';
    const date = new Date(datetime);
    return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
}

// Show stats modal
function showStats() {
    document.getElementById('statsModal').classList.add('active');
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// Clear history
function confirmClearHistory() {
    if (confirm('Yakin ingin menghapus semua riwayat chat? Ini tidak bisa dibatalkan!')) {
        fetch('{{ route("student.ai-companion.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear messages
                const messages = messagesContainer.querySelectorAll('.message');
                messages.forEach(msg => msg.remove());
                
                // Show empty state
                emptyState.style.display = 'block';
                
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
@endpush
