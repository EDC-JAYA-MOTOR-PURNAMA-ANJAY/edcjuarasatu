@extends('layouts.guru_bk')

@section('title', 'Detail Percakapan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('guru_bk.chatbot.shared') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <h2 class="mb-0">💬 Detail Percakapan</h2>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Student Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: {{ 
                    $conversation->alert_level == 'critical' ? '#dc3545' : 
                    ($conversation->alert_level == 'high' ? '#ffc107' : '#0d6efd') 
                }}; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>
                            {{ $conversation->user->nama }}
                        </h5>
                        {!! $conversation->alert_badge !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>NIS:</strong> {{ $conversation->user->nis_nip }}</p>
                            <p class="mb-2"><strong>Kelas:</strong> {{ optional($conversation->user->kelas)->nama_kelas ?? '-' }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $conversation->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Dibagikan:</strong> {{ $conversation->shared_at->format('d M Y, H:i') }}</p>
                            <p class="mb-2"><strong>Sentimen:</strong> {!! $conversation->sentiment_badge !!}</p>
                            <p class="mb-2"><strong>Status:</strong> {!! $conversation->status_badge !!}</p>
                        </div>
                    </div>

                    @if($conversation->topics && count($conversation->topics) > 0)
                        <div class="mb-3">
                            <strong>Topik Percakapan:</strong><br>
                            @foreach($conversation->topics as $topic)
                                <span class="badge bg-primary me-1">{{ ucfirst($topic) }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($conversation->sharing_note)
                        <div class="alert alert-info">
                            <strong>Catatan dari Siswa:</strong><br>
                            "{{ $conversation->sharing_note }}"
                        </div>
                    @endif

                    @if($conversation->detected_keywords && count($conversation->detected_keywords) > 0)
                        <div class="alert alert-warning">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Keyword Terdeteksi:</strong><br>
                            @foreach($conversation->detected_keywords as $kw)
                                <span class="badge bg-{{ $kw['severity'] == 'critical' ? 'danger' : ($kw['severity'] == 'high' ? 'warning' : 'info') }} me-1">
                                    {{ $kw['keyword'] }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Conversation Messages -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Percakapan ({{ $conversation->message_count }} pesan)
                    </h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    @if($conversation->messages && count($conversation->messages) > 0)
                        <div class="chat-container">
                            @foreach($conversation->messages as $msg)
                                @if($msg['role'] == 'user')
                                    <!-- User Message -->
                                    <div class="d-flex justify-content-end mb-3">
                                        <div class="message-bubble user-message" style="max-width: 70%;">
                                            <div class="p-3 rounded" style="background-color: #8000FF; color: white;">
                                                {{ $msg['content'] }}
                                            </div>
                                            @if(isset($msg['time']))
                                                <small class="text-muted d-block text-end mt-1">{{ $msg['time'] }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <!-- AI Message -->
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="message-bubble ai-message" style="max-width: 70%;">
                                            <div class="p-3 rounded" style="background-color: #f0f0f0;">
                                                <strong class="text-primary">🤖 AI Companion:</strong><br>
                                                {{ $msg['content'] }}
                                            </div>
                                            @if(isset($msg['time']))
                                                <small class="text-muted d-block mt-1">{{ $msg['time'] }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Tidak ada percakapan tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Review Notes -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i>
                        Catatan Review
                    </h5>
                </div>
                <div class="card-body">
                    @if($conversation->status == 'reviewed')
                        <div class="alert alert-success">
                            <strong>
                                <i class="fas fa-check-circle me-2"></i>
                                Sudah Direview
                            </strong><br>
                            <small>Oleh: {{ optional($conversation->reviewer)->nama ?? '-' }}</small><br>
                            <small>Pada: {{ $conversation->reviewed_at?->format('d M Y, H:i') }}</small>
                        </div>
                        @if($conversation->guru_bk_notes)
                            <div class="alert alert-light">
                                <strong>Catatan:</strong><br>
                                {{ $conversation->guru_bk_notes }}
                            </div>
                        @endif
                    @else
                        <form id="reviewForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><strong>Tambahkan Catatan Review:</strong></label>
                                <textarea class="form-control" id="reviewNotes" rows="5" required
                                    placeholder="Contoh:&#10;- Sudah dihubungi via WhatsApp&#10;- Akan dijadwalkan konseling tatap muka&#10;- Situasi sudah ditangani"></textarea>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Catatan akan dilihat oleh Guru BK lain dan siswa akan diberi tahu bahwa chat telah direview.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan & Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $conversation->user->no_telepon ?? '') }}" 
                           class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp Siswa
                        </a>
                        <a href="tel:{{ $conversation->user->no_telepon }}" class="btn btn-info">
                            <i class="fas fa-phone me-2"></i>Telepon
                        </a>
                        <a href="mailto:{{ $conversation->user->email }}" class="btn btn-secondary">
                            <i class="fas fa-envelope me-2"></i>Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alert Guide -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title">Panduan Alert Level</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <span class="badge bg-danger">🚨 KRITIS</span><br>
                            <small class="text-muted">Butuh tindakan segera (dalam 15 menit)</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-warning">⚠️ TINGGI</span><br>
                            <small class="text-muted">Prioritas tinggi (hari ini)</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-info">📌 SEDANG</span><br>
                            <small class="text-muted">Review dalam 1-2 hari</small>
                        </li>
                        <li>
                            <span class="badge bg-secondary">ℹ️ RENDAH</span><br>
                            <small class="text-muted">Informasi, tidak urgent</small>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Emergency Contacts -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-danger">
                        <i class="fas fa-phone-volume me-2"></i>
                        Hotline Darurat
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <strong>Halo Kemkes:</strong><br>
                            <a href="tel:119">119</a> (24/7)
                        </li>
                        <li class="mb-2">
                            <strong>LSM Jangan Bunuh Diri:</strong><br>
                            <a href="tel:021-9696-9293">021-9696-9293</a>
                        </li>
                        <li>
                            <strong>Sejiwa:</strong><br>
                            <a href="tel:119">119 ext 8</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Handle review form submission
document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const notes = document.getElementById('reviewNotes').value;
    const conversationId = {{ $conversation->id }};
    
    if (!notes.trim()) {
        alert('Mohon isi catatan review');
        return;
    }
    
    if (!confirm('Yakin ingin menandai percakapan ini sebagai telah direview?\nSiswa akan menerima notifikasi.')) {
        return;
    }
    
    fetch(`/guru_bk/chatbot/conversation/${conversationId}/notes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            window.location.reload();
        } else {
            alert('❌ Gagal menyimpan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan');
    });
});
</script>

<style>
.chat-container {
    font-size: 0.95rem;
}

.message-bubble {
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
