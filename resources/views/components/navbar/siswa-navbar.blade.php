<header class="top-header">
    <div class="header-content">
        <div class="header-right">
            <!-- Notification Bell -->
            <button class="notification-btn">
                <i class="fas fa-bell"></i>
            </button>

            <!-- User Profile -->
            <div class="user-profile">
                <div class="profile-info">
                    <span class="user-name">Keysita Marchelina Harlie</span>
                    <span class="user-role">Siswa</span>
                </div>
                <div class="profile-avatar-container">
                    <img src="{{ asset('images/key.jpeg') }}"
                         alt="Profile" class="profile-img" id="profileAvatar">
                </div>
            </div>

            <!-- Profile Card Popup -->
            <div class="profile-card-popup" id="profileCard">
                <div class="profile-card-content">
                    <!-- Profile Image Large -->
                    <div class="profile-card-avatar">
                        <img src="{{ asset('images/key.jpeg') }}"
                             alt="Profile Large" class="profile-img-large">
                    </div>

                    <!-- User Info -->
                    <div class="profile-card-info">
                        <h3 class="profile-card-name">Keysita Marchelina Harlie</h3>
                        <p class="profile-card-role">Siswa</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="profile-card-actions">
                        <button class="profile-btn view-profile-btn" onclick="window.location.href='{{ route('student.profile') }}'">
                            <i class="fas fa-user"></i>
                            <span>Lihat Profil</span>
                        </button>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="profile-btn logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Overlay Background -->
            <div class="profile-overlay" id="profileOverlay"></div>
        </div>
    </div>
</header>

<style>
.top-header {
    background: var(--white);
    height: 72px;
    position: fixed;
    top: 0;
    left: 260px;
    right: 0;
    z-index: 999;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    height: 100%;
    padding: 0 32px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

.notification-btn {
    background: none;
    border: none;
    width: 24px;
    height: 24px;
    cursor: pointer;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.3s ease;
}

.notification-btn:hover {
    color: var(--primary-blue);
}

/* User Profile Styles */
.user-profile {
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.user-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.2;
}

.user-role {
    font-size: 12px;
    font-weight: 400;
    color: var(--text-gray);
    line-height: 1.2;
}

/* Profile Avatar Container */
.profile-avatar-container {
    position: relative;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #E6E6E6;
    cursor: pointer;
    transition: all 0.25s ease;
}

.profile-img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Profile Card Popup */
.profile-card-popup {
    position: absolute;
    top: calc(100% + 20px);
    right: 0;
    width: 280px;
    background: #FFFFFF;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    padding: 20px;
    z-index: 100;
    opacity: 0;
    transform: translateY(-10px) scale(0.95);
    visibility: hidden;
    transition: all 0.35s cubic-bezier(0.25, 0.1, 0.25, 1);
}

.profile-card-popup.active {
    opacity: 1;
    transform: translateY(0) scale(1);
    visibility: visible;
}

.profile-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

/* Profile Card Avatar Large */
.profile-card-avatar {
    margin-bottom: 8px;
}

.profile-img-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #F0F0F0;
}

/* Profile Card Info */
.profile-card-info {
    text-align: center;
    margin-bottom: 8px;
}

.profile-card-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px 0;
    line-height: 1.2;
}

.profile-card-role {
    font-size: 14px;
    font-weight: 400;
    color: #666666;
    margin: 0;
    line-height: 1.2;
}

/* Profile Card Actions */
.profile-card-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}

.profile-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border: none;
    border-radius: 10px;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    width: 100%;
}

.profile-btn:hover {
    background: #F8F9FA;
    transform: translateX(4px);
}

.view-profile-btn:hover {
    color: var(--primary-blue);
}

.logout-btn:hover {
    color: #FF6B6B;
}

.profile-btn i {
    width: 16px;
    font-size: 14px;
}

/* Overlay Background */
.profile-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    z-index: 99;
    opacity: 0;
    visibility: hidden;
    transition: all 0.35s ease;
}

.profile-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Avatar Animation when clicked */
.profile-avatar-container.animate .profile-img {
    animation: avatarClick 0.5s ease;
}

@keyframes avatarClick {
    0% {
        transform: scale(1) rotate(0deg);
    }
    50% {
        transform: scale(0.95) rotate(8deg);
    }
    100% {
        transform: scale(1) rotate(0deg);
    }
}

/* Bounce animation for popup */
@keyframes popupBounce {
    0% {
        transform: translateY(-10px) scale(0.95);
    }
    50% {
        transform: translateY(2px) scale(1.02);
    }
    100% {
        transform: translateY(0) scale(1);
    }
}

.profile-card-popup.active {
    animation: popupBounce 0.5s cubic-bezier(0.25, 0.1, 0.25, 1.5);
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-card-popup {
        right: -20px;
        width: 260px;
    }

    .user-name {
        display: none;
    }

    .user-role {
        display: none;
    }
}

/* Close popup when clicking outside */
.profile-card-popup::before {
    content: '';
    position: absolute;
    top: -10px;
    right: 15px;
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid #FFFFFF;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileAvatar = document.getElementById('profileAvatar');
    const profileCard = document.getElementById('profileCard');
    const profileOverlay = document.getElementById('profileOverlay');
    const avatarContainer = document.querySelector('.profile-avatar-container');

    // Toggle profile card
    function toggleProfileCard() {
        const isActive = profileCard.classList.contains('active');

        if (!isActive) {
            // Add animation to avatar
            avatarContainer.classList.add('animate');

            // Show popup and overlay
            profileCard.classList.add('active');
            profileOverlay.classList.add('active');

            // Remove animation class after animation completes
            setTimeout(() => {
                avatarContainer.classList.remove('animate');
            }, 500);
        } else {
            closeProfileCard();
        }
    }

    // Close profile card
    function closeProfileCard() {
        profileCard.classList.remove('active');
        profileOverlay.classList.remove('active');
    }

    // Event listeners
    profileAvatar.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleProfileCard();
    });

    profileOverlay.addEventListener('click', closeProfileCard);

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileCard.contains(e.target) && !profileAvatar.contains(e.target)) {
            closeProfileCard();
        }
    });

    // Prevent card from closing when clicking inside
    profileCard.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Button actions
    const viewProfileBtn = document.querySelector('.view-profile-btn');
    const logoutBtn = document.querySelector('.logout-btn');

    viewProfileBtn.addEventListener('click', function() {
        alert('Fitur Lihat Profil akan segera tersedia!');
        closeProfileCard();
    });

    logoutBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            alert('Anda telah keluar dari sistem');
            closeProfileCard();
            // window.location.href = '/logout'; // Uncomment for actual logout
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProfileCard();
        }
    });
});
</script>
