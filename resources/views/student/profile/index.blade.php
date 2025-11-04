@extends('layouts.app')

@section('title', 'Profil Saya - Educounsel')

@push('styles')
<style>
    body {
        background-color: #F5F5F5;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #7000CC 0%, #5E00A8 100%);
        border-radius: 20px 20px 0 0;
        padding: 40px;
        text-align: center;
        color: white;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid white;
        margin: 0 auto 20px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
    }
    
    .profile-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .profile-role {
        font-size: 14px;
        opacity: 0.9;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 30px;
    }
    
    .info-item {
        padding: 20px;
        background: #F8F9FA;
        border-radius: 12px;
    }
    
    .info-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 16px;
        color: #000;
        font-weight: 500;
    }
    
    .btn-edit {
        background: #7000CC;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-edit:hover {
        background: #5E00A8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(112, 0, 204, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
    <div class="profile-card">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                👤
            </div>
            <div class="profile-name">{{ auth()->user()->nama }}</div>
            <div class="profile-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->peran)) }}</div>
        </div>
        
        <!-- Profile Info -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">NIS</div>
                <div class="info-value">{{ auth()->user()->nis_nip ?? '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ auth()->user()->email }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">{{ auth()->user()->jenis_kelamin ? ucfirst(auth()->user()->jenis_kelamin) : '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ auth()->user()->no_telepon ?? '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Kelas</div>
                <div class="info-value">
                    @if(auth()->user()->kelas)
                        {{ auth()->user()->kelas->tingkat }} {{ auth()->user()->kelas->jurusan->nama_jurusan }} {{ auth()->user()->kelas->nomor_kelas }}
                    @else
                        -
                    @endif
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span style="color: {{ auth()->user()->status == 'aktif' ? '#10B981' : '#EF4444' }}; font-weight: 700;">
                        {{ ucfirst(auth()->user()->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        @if(auth()->user()->alamat)
        <div style="padding: 0 30px 30px;">
            <div class="info-item">
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ auth()->user()->alamat }}</div>
            </div>
        </div>
        @endif
        
        <!-- Action Buttons -->
        <div style="padding: 0 30px 30px; text-align: center;">
            <button class="btn-edit" onclick="alert('Fitur edit profil akan segera hadir!')">
                ✏️ Edit Profil
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Profile Update Handler (if form exists)
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.querySelector('#profileForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            // If using AJAX
            const formData = new FormData(this);
            
            // After successful profile update (add this to your AJAX success callback)
            // 🎙️ VOICE: Profile Updated
            if (window.voiceHelper) {
                window.voiceHelper.speakProfileUpdated();
            }
        });
    }
});
</script>
@endpush
