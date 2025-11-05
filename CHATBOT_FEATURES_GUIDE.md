# 🤖 EDU AI Chatbot - Complete Features Guide

## 📋 Table of Contents
1. [Overview](#overview)
2. [Voice Features](#voice-features)
3. [Text-to-Speech (TTS)](#text-to-speech-tts)
4. [Voice-to-Text (STT)](#voice-to-text-stt)
5. [Chat Management](#chat-management)
6. [User Interface](#user-interface)
7. [Keyboard Shortcuts](#keyboard-shortcuts)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

EDU AI Chatbot adalah asisten AI interaktif yang dilengkapi dengan fitur voice input/output, research mode, dan management tools yang lengkap.

### **Key Features:**
- ✅ Voice-to-Text (Speech Recognition)
- ✅ Text-to-Speech (AI membaca response)
- ✅ Research Mode (detailed responses)
- ✅ Delete Chat
- ✅ Export Chat to PDF
- ✅ Copy Response
- ✅ Auto-scroll chat
- ✅ Typing indicator
- ✅ Modern UI with Tailwind CSS

---

## 🎤 Voice Features

### **1. Voice-to-Text (Input)**
Fitur untuk berbicara dan mengubah suara menjadi text.

#### **Cara Menggunakan:**
1. Klik icon **microphone** (🎤) di input area
2. Browser akan meminta izin akses microphone → **Allow**
3. Button berubah **merah** dengan animasi pulse
4. Mulai **bicara dengan jelas** dalam Bahasa Indonesia
5. Text otomatis muncul di input box
6. Edit jika perlu, lalu klik **Send**

#### **Visual Feedback:**
- 🎤 **Red button** + pulse animation = Recording
- 🔴 **Stop icon** = Click to stop recording
- ✅ **Notification**: "Voice captured: [your text]"

#### **Supported Languages:**
- 🇮🇩 Bahasa Indonesia (default)
- 🇬🇧 English (coming soon)

#### **Browser Support:**
- ✅ Chrome (Desktop & Mobile)
- ✅ Edge
- ✅ Opera
- ❌ Firefox (not supported)
- ⚠️ Safari (limited)

---

### **2. Text-to-Speech (Output)** ⭐ NEW!
Fitur untuk mendengarkan AI response dengan suara.

#### **Cara Menggunakan:**
1. Setelah AI memberikan response
2. Klik button **"Listen"** (🔊) di bawah message
3. AI akan membacakan response dengan suara
4. Button berubah menjadi **"Stop"** saat berbicara

#### **Controls:**
- **🔊 Listen** → Mulai membaca response
- **⏹️ Stop** → Berhenti membaca
- **Click Listen lagi** → Toggle play/stop

#### **Features:**
- ✅ Natural Indonesian voice
- ✅ Adjustable speed (default: 1.0x)
- ✅ Auto-stop when deleting chat
- ✅ Only one speech at a time
- ✅ Visual feedback (button changes)

#### **TTS Settings (Default):**
```javascript
Language: Indonesian (id-ID)
Rate: 1.0x (normal speed)
Pitch: 1.0 (normal)
Volume: 1.0 (100%)
```

#### **Use Cases:**
- 📖 Belajar sambil mendengar
- 🚶 Multi-tasking (dengar sambil jalan)
- 👁️ Accessibility (visual impairment)
- 🎧 Better comprehension

---

## 💬 Chat Management

### **1. Delete Chat** 🗑️

#### **2 Ways to Delete:**

**A. From Hero Card Input Area:**
- Klik button **trash icon** (🗑️) di sebelah Send button
- Confirmation dialog muncul
- Klik **OK** untuk confirm

**B. From Chat Interface Header:**
- Klik button **"Delete Chat"** di header
- Confirmation dialog muncul
- Klik **OK** untuk confirm

#### **What Happens:**
1. ⚠️ Confirmation dialog: "Are you sure?"
2. 🔇 Stop any ongoing speech (TTS)
3. 🗑️ Clear all messages from screen
4. 💾 Save empty history to server
5. 🏠 Return to welcome screen
6. ✅ Notification: "Chat deleted successfully"

#### **Important:**
- ⚠️ Action **cannot be undone**
- ⚠️ All conversation history will be lost
- ✅ Need confirmation before delete

---

### **2. Export Chat** 📥

#### **How to Export:**
1. Click **"Export"** button di chat header
2. System generates PDF
3. PDF auto-downloads to your device

#### **What's Included in PDF:**
- Full conversation history
- Timestamps
- User and AI messages
- Formatted text

#### **Requirements:**
- ⚠️ Must have at least 1 message
- ⚠️ Empty chat cannot be exported

---

### **3. Copy Response** 📋

#### **How to Copy:**
1. Setiap AI response punya button **"Copy"**
2. Klik button **Copy**
3. Text copied to clipboard
4. Notification: "📋 Copied to clipboard"

#### **Use Cases:**
- Save important information
- Share with friends
- Paste to notes/documents

---

## 🔬 Research Mode

### **What is Research Mode?**
Mode khusus untuk mendapatkan response yang lebih **detailed dan mendalam**.

#### **How to Activate:**
1. Klik **"Deeper Research"** toggle di hero card
2. Button berubah warna (lighter background)
3. Notification: "🔬 Research mode activated"

#### **Differences:**

| Normal Mode | Research Mode |
|------------|---------------|
| Quick, concise answers | Detailed, comprehensive answers |
| 💬 Casual conversation | 🔬 In-depth analysis |
| Fast response | More thorough response |

#### **Best For:**
- 📚 Homework help
- 🔍 Research projects
- 📊 Complex topics
- 📖 Learning new concepts

---

## 🎨 User Interface

### **Layout Components:**

#### **1. Left Sidebar**
- User profile
- Search chats
- Navigation menu (Chats, Library, Apps)
- Pinned chats
- Chat history
- New Chat button

#### **2. Hero Card (Input Area)**
- Welcome message
- Research mode toggle
- Main input textarea
  - Auto-resize (max 150px)
  - Multi-line support
  - Enter to send, Shift+Enter for new line
- Action buttons:
  - 🎤 Voice Input
  - ✈️ Send Message
  - 🗑️ Delete Chat
- Attach file option

#### **3. Chat Interface**
- Chat header:
  - AI Assistant info
  - Export button
  - Delete Chat button
- Messages area:
  - User messages (right, blue)
  - AI messages (left, purple)
  - Each AI message has:
    - 🔊 Listen button (TTS)
    - 📋 Copy button
  - Typing indicator
  - Auto-scroll to bottom

#### **4. Chat Cards Grid**
- Filter options (Sort, Content, Created By, Date)
- Card previews
- Recent chats display

---

## ⌨️ Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| **Enter** | Send message |
| **Shift + Enter** | New line in textarea |
| **Ctrl + K** | Focus on input (coming soon) |
| **Esc** | Stop TTS (coming soon) |

---

## 🔧 Troubleshooting

### **Voice-to-Text Issues:**

#### **Problem: "Microphone access denied"**
**Solution:**
1. Click lock icon 🔒 in address bar
2. Change Microphone to "Allow"
3. Refresh page (F5)

#### **Problem: "No speech detected"**
**Solution:**
- Speak louder and clearer
- Check microphone is not muted
- Try again

#### **Problem: Button disabled (gray)**
**Solution:**
- Your browser doesn't support Speech Recognition
- Use Chrome or Edge instead

---

### **Text-to-Speech Issues:**

#### **Problem: No sound when clicking Listen**
**Solution:**
1. Check device volume
2. Check browser sound permissions
3. Try refreshing page

#### **Problem: Voice sounds weird/robotic**
**Solution:**
- This is normal for browser TTS
- Voice quality depends on your device/browser
- Chrome has the best TTS quality

#### **Problem: Speech cuts off mid-sentence**
**Solution:**
- This is a browser limitation
- Try breaking long responses into smaller parts

---

### **Chat Issues:**

#### **Problem: Chat not showing**
**Solution:**
1. Check if `chatInterface` is visible
2. Send at least 1 message to trigger chat view
3. Refresh page if needed

#### **Problem: Scroll not working**
**Solution:**
- Auto-scroll triggers after each message
- Manually scroll if needed
- Check browser console for errors

#### **Problem: Messages not sending**
**Solution:**
1. Check internet connection
2. Check `.env` has `GEMINI_API_KEY`
3. Check browser console for errors
4. Verify backend route is working

---

## 🎯 Best Practices

### **For Voice Input:**
1. ✅ Speak clearly and at normal speed
2. ✅ Use simple, straightforward sentences
3. ✅ Pause briefly between thoughts
4. ✅ Check transcription before sending
5. ❌ Don't speak too fast
6. ❌ Don't have background noise

### **For TTS (Listen):**
1. ✅ Use for long responses
2. ✅ Adjust speed if needed (coming soon)
3. ✅ Stop before deleting chat
4. ❌ Don't play multiple speeches at once

### **For Research Mode:**
1. ✅ Use for complex questions
2. ✅ Use for homework/study
3. ✅ Turn off for quick questions
4. ❌ Don't use for simple greetings

---

## 📊 Feature Status

| Feature | Status | Notes |
|---------|--------|-------|
| Voice-to-Text | ✅ Live | Indonesian only |
| Text-to-Speech | ✅ Live | All responses |
| Delete Chat | ✅ Live | With confirmation |
| Export PDF | ✅ Live | Full history |
| Copy Response | ✅ Live | To clipboard |
| Research Mode | ✅ Live | Toggle on/off |
| Multi-language | 🚧 Coming | English support |
| Voice Commands | 🚧 Coming | Hands-free control |
| TTS Speed Control | 🚧 Coming | 0.5x - 2x |
| Conversation Mode | 🚧 Coming | Continuous chat |

---

## 🆘 Support

### **Need Help?**
1. Check this guide first
2. Check `MICROPHONE_SETUP_GUIDE.md`
3. Check browser console (F12) for errors
4. Contact system administrator

### **Report Issues:**
Include:
- Browser name & version
- Error message (if any)
- Steps to reproduce
- Screenshot (if possible)

---

## 📝 Updates

### **Version 2.0 (Current) - Nov 5, 2025**
- ✨ Added Text-to-Speech (TTS)
- ✨ Added Delete Chat button
- ✨ Added Copy Response button
- ✨ Single input area (removed duplicate)
- ✨ Improved scroll behavior
- ✨ Modern UI redesign
- ✨ Better animations

### **Version 1.0 - Previous**
- Voice-to-Text basic
- Chat functionality
- Export to PDF

---

**🎉 Enjoy your enhanced EDU AI Chatbot experience!**

*Last updated: November 5, 2025*
