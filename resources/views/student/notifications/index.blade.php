@extends('layouts.app')

@section('title', 'Notifikasi - Siswa')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap');
    
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    body {
        background-color: #F8F9FA;
    }
    
    .notifications-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 32px;
    }
    
    /* Header */
    .page-header {
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
        color: white;
        box-shadow: 0 8px 24px rgba(128, 0, 255, 0.2);
    }
    
    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    
    .page-header p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }
    
    /* Notifications List */
    .notifications-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .notification-item {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    
    .notification-item:hover {
        background: #F9FAFB;
    }
    
    .notification-item:last-child {
        border-bottom: none;
    }
    
    .notification-item.unread {
        background: #F0F9FF;
        border-left: 4px solid #3B82F6;
    }
    
    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }
    
    .icon-materi {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .icon-konseling {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .icon-general {
        background: #FEF3C7;
        color: #92400E;
    }
    
    .notification-content {
        flex: 1;
        min-width: 0;
    }
    
    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #1F2937;
        margin: 0 0 4px 0;
    }
    
    .notification-message {
        font-size: 14px;
        color: #6B7280;
        margin: 0 0 8px 0;
        line-height: 1.5;
    }
    
    .notification-time {
        font-size: 12px;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .notification-badge {
        width: 8px;
        height: 8px;
        background: #3B82F6;
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #D1D5DB;
        margin-bottom: 16px;
    }
    
    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: #6B7280;
        margin: 0 0 8px 0;
    }
    
    .empty-state p {
        font-size: 14px;
        color: #9CA3AF;
        margin: 0;
    }
    
    /* Pagination */
    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }
    
    /* Actions */
    .notifications-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding: 0 4px;
    }
    
    .notifications-count {
        font-size: 14px;
        color: #6B7280;
    }
    
    .btn-mark-all-read {
        background: transparent;
        border: 1px solid #E5E7EB;
        color: #6B7280;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-mark-all-read:hover {
        background: #F9FAFB;
        border-color: #8000FF;
        color: #8000FF;
    }
</style>
@endpush

@section('content')
<div class="notifications-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-bell"></i> Notifikasi</h1>
        <p>Lihat semua notifikasi dan pembaruan terbaru</p>
    </div>
    
    <!-- Actions Bar -->
    @if($notifications->total() > 0)
    <div class="notifications-actions">
        <div class="notifications-count">
            <strong>{{ $notifications->total() }}</strong> notifikasi
            @php
                $unreadCount = $notifications->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span style="color: #3B82F6;"> • {{ $unreadCount }} belum dibaca</span>
            @endif
        </div>
        
        @if($unreadCount > 0)
        <button class="btn-mark-all-read" onclick="markAllAsRead()">
            <i class="fas fa-check-double"></i>
            Tandai Semua Dibaca
        </button>
        @endif
    </div>
    @endif
    
    <!-- Notifications List -->
    <div class="notifications-list">
        @forelse($notifications as $notification)
        <a href="{{ $notification->related_link ?? '#' }}" 
           class="notification-item {{ !$notification->is_read ? 'unread' : '' }}"
           onclick="markAsRead({{ $notification->id }})">
            <div class="notification-icon {{ $notification->related_type === 'Materi' ? 'icon-materi' : ($notification->related_type === 'Konseling' ? 'icon-konseling' : 'icon-general') }}">
                @if($notification->related_type === 'Materi')
                    <i class="fas fa-book"></i>
                @elseif($notification->related_type === 'Konseling')
                    <i class="fas fa-comments"></i>
                @else
                    <i class="fas fa-info-circle"></i>
                @endif
            </div>
            
            <div class="notification-content">
                <h3 class="notification-title">{{ $notification->title }}</h3>
                <p class="notification-message">{{ $notification->message }}</p>
                <div class="notification-time">
                    @if(!$notification->is_read)
                        <span class="notification-badge"></span>
                    @endif
                    <i class="fas fa-clock"></i>
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
        </a>
        @empty
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <h3>Tidak ada notifikasi</h3>
            <p>Notifikasi akan muncul di sini ketika ada pembaruan baru</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($notifications->hasPages())
    <div class="pagination-wrapper">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

<script>
// Mark single notification as read
function markAsRead(notificationId) {
    fetch(`/api/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Notification marked as read');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Mark all notifications as read
function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai sudah dibaca?')) {
        return;
    }
    
    fetch('/api/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
