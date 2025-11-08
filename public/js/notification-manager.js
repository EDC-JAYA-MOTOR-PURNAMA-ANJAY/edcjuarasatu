/**
 * Notification Manager
 * Handles real-time notifications via Broadcasting + Polling Fallback
 * with Voice Alert support
 */

class NotificationManager {
    constructor(config = {}) {
        this.config = {
            pollingInterval: config.pollingInterval || 30000, // 30 seconds
            soundEnabled: config.soundEnabled !== false,
            browserNotificationEnabled: config.browserNotificationEnabled !== false,
            apiBaseUrl: config.apiBaseUrl || '/api/notifications',
            ...config
        };

        this.notificationSound = new NotificationSound();
        this.unreadCount = 0;
        this.lastCheckedTimestamp = null;
        this.pollingTimer = null;
        this.isPolling = false;
        this.echo = null;

        this.init();
    }

    /**
     * Initialize notification system
     */
    init() {
        console.log('🔔 Initializing Notification Manager...');

        // Request browser notification permission
        this.requestNotificationPermission();

        // Try to initialize Laravel Echo (Broadcasting)
        this.initializeBroadcasting();

        // Start polling fallback
        this.startPolling();

        // Load initial unread count
        this.updateUnreadCount();

        console.log('✅ Notification Manager initialized');
    }

    /**
     * Request browser notification permission
     */
    async requestNotificationPermission() {
        if (!('Notification' in window)) {
            console.warn('Browser notifications not supported');
            return false;
        }

        if (Notification.permission === 'granted') {
            return true;
        }

        if (Notification.permission !== 'denied') {
            const permission = await Notification.requestPermission();
            return permission === 'granted';
        }

        return false;
    }

    /**
     * Initialize Laravel Echo for real-time broadcasting
     */
    initializeBroadcasting() {
        // Check if Laravel Echo is available
        if (typeof Echo === 'undefined') {
            console.warn('Laravel Echo not available, using polling only');
            return;
        }

        try {
            // Listen to materi-updates channel
            this.echo = Echo.channel('materi-updates')
                .listen('.materi.created', (data) => {
                    console.log('📡 Real-time notification received:', data);
                    this.handleNewNotification(data);
                });

            console.log('✅ Laravel Echo initialized');
        } catch (error) {
            console.error('❌ Error initializing Laravel Echo:', error);
        }
    }

    /**
     * Start polling for new notifications
     */
    startPolling() {
        if (this.isPolling) return;

        this.isPolling = true;
        this.lastCheckedTimestamp = new Date().toISOString();

        this.pollingTimer = setInterval(() => {
            this.checkForNewNotifications();
        }, this.config.pollingInterval);

        console.log(`🔄 Polling started (every ${this.config.pollingInterval / 1000}s)`);
    }

    /**
     * Stop polling
     */
    stopPolling() {
        if (this.pollingTimer) {
            clearInterval(this.pollingTimer);
            this.pollingTimer = null;
        }
        this.isPolling = false;
        console.log('⏸️ Polling stopped');
    }

    /**
     * Check for new notifications via API
     */
    async checkForNewNotifications() {
        try {
            const response = await fetch(`${this.config.apiBaseUrl}/check-new`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to check notifications');

            const data = await response.json();

            if (data.success && data.has_new && data.notifications.length > 0) {
                console.log('📬 New notifications found:', data.notifications);
                
                // Handle each new notification
                data.notifications.forEach(notification => {
                    this.handleNewNotification(notification);
                });

                // Update count
                this.updateUnreadCount();
            }
        } catch (error) {
            console.error('Error checking notifications:', error);
        }
    }

    /**
     * Handle new notification
     */
    handleNewNotification(notification) {
        // Play sound
        if (this.config.soundEnabled) {
            this.notificationSound.play();
        }

        // Show browser notification
        if (this.config.browserNotificationEnabled) {
            this.showBrowserNotification(notification);
        }

        // Show in-app notification
        this.showInAppNotification(notification);

        // Update unread count
        this.unreadCount++;
        this.updateBadge();

        // Trigger custom event
        this.triggerNotificationEvent(notification);
    }

    /**
     * Show browser notification
     */
    showBrowserNotification(notification) {
        if (Notification.permission !== 'granted') return;

        const data = notification.data || {};
        const title = notification.title || data.materi_judul || 'Materi Baru';
        
        let body = notification.message || `Materi baru telah ditambahkan`;
        if (data.has_file) {
            body += `\n📎 File ${data.file_extension} tersedia untuk diunduh (${data.file_size})`;
        }
        
        const icon = data.thumbnail_url || '/images/logo.png';

        try {
            const browserNotif = new Notification(title, {
                body: body,
                icon: icon,
                badge: icon,
                tag: `notification-${notification.id}`,
                requireInteraction: false,
                silent: false,
            });

            // Handle click
            browserNotif.onclick = () => {
                window.focus();
                // Navigate to materi detail if available
                if (notification.related_id || data.materi_id) {
                    const materiId = notification.related_id || data.materi_id;
                    window.location.href = `/student/materi/${materiId}`;
                }
                browserNotif.close();
            };

            // Auto close after 6 seconds (longer for file info)
            setTimeout(() => browserNotif.close(), data.has_file ? 7000 : 5000);
        } catch (error) {
            console.error('Error showing browser notification:', error);
        }
    }

    /**
     * Show in-app notification toast
     */
    showInAppNotification(notification) {
        const data = notification.data || {};
        const hasFile = data.has_file || false;
        const fileInfo = hasFile ? `${data.file_extension} - ${data.file_size}` : '';
        
        const toast = document.createElement('div');
        toast.className = 'notification-toast';
        toast.innerHTML = `
            <div class="notification-toast-icon">
                <i class="fas fa-${hasFile ? 'file-pdf' : 'book'}"></i>
            </div>
            <div class="notification-toast-content">
                <div class="notification-toast-title">${notification.title || 'Materi Baru'}</div>
                <div class="notification-toast-message">
                    ${data.materi_judul || notification.message || ''}
                    ${hasFile ? `<br><small style="color: #10B981; font-weight: 600;"><i class="fas fa-paperclip"></i> ${fileInfo}</small>` : ''}
                </div>
            </div>
            <button class="notification-toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => toast.classList.add('show'), 100);

        // Auto remove after 7 seconds (longer for file info)
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, hasFile ? 7000 : 5000);

        // Handle click
        toast.addEventListener('click', (e) => {
            if (!e.target.closest('.notification-toast-close')) {
                if (notification.related_id || data.materi_id) {
                    const materiId = notification.related_id || data.materi_id;
                    window.location.href = `/student/materi/${materiId}`;
                }
            }
        });
        
        // Voice announcement with file info
        if ('speechSynthesis' in window) {
            setTimeout(() => {
                let voiceMessage = `Materi baru tersedia: ${data.materi_judul || notification.title}`;
                if (hasFile) {
                    voiceMessage += `. File ${data.file_extension} dapat diunduh.`;
                }
                const utterance = new SpeechSynthesisUtterance(voiceMessage);
                utterance.lang = 'id-ID';
                utterance.rate = 1.0;
                utterance.pitch = 1.1;
                utterance.volume = 0.8;
                window.speechSynthesis.speak(utterance);
            }, 500);
        }
    }

    /**
     * Update unread count
     */
    async updateUnreadCount() {
        try {
            const response = await fetch(`${this.config.apiBaseUrl}/count`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to get count');

            const data = await response.json();

            if (data.success) {
                this.unreadCount = data.count;
                this.updateBadge();
            }
        } catch (error) {
            console.error('Error updating count:', error);
        }
    }

    /**
     * Update badge UI
     */
    updateBadge() {
        const badges = document.querySelectorAll('.notification-badge, [data-notification-badge]');
        badges.forEach(badge => {
            if (this.unreadCount > 0) {
                badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });

        // Update document title
        if (this.unreadCount > 0) {
            document.title = `(${this.unreadCount}) ${document.title.replace(/^\(\d+\) /, '')}`;
        } else {
            document.title = document.title.replace(/^\(\d+\) /, '');
        }
    }

    /**
     * Mark notification as read
     */
    async markAsRead(notificationId) {
        try {
            const response = await fetch(`${this.config.apiBaseUrl}/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to mark as read');

            const data = await response.json();

            if (data.success) {
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.updateBadge();
            }

            return data.success;
        } catch (error) {
            console.error('Error marking as read:', error);
            return false;
        }
    }

    /**
     * Mark all as read
     */
    async markAllAsRead() {
        try {
            const response = await fetch(`${this.config.apiBaseUrl}/read-all`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to mark all as read');

            const data = await response.json();

            if (data.success) {
                this.unreadCount = 0;
                this.updateBadge();
            }

            return data.success;
        } catch (error) {
            console.error('Error marking all as read:', error);
            return false;
        }
    }

    /**
     * Trigger custom notification event
     */
    triggerNotificationEvent(notification) {
        const event = new CustomEvent('notification:received', {
            detail: notification
        });
        window.dispatchEvent(event);
    }

    /**
     * Toggle sound
     */
    toggleSound() {
        this.config.soundEnabled = !this.config.soundEnabled;
        return this.config.soundEnabled;
    }

    /**
     * Destroy
     */
    destroy() {
        this.stopPolling();
        if (this.echo) {
            this.echo.leaveChannel('materi-updates');
        }
        console.log('🔕 Notification Manager destroyed');
    }
}

// Initialize globally for student users
window.NotificationManager = NotificationManager;
