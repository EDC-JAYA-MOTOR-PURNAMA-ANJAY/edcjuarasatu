@extends('layouts.guru_bk')

@section('title', 'Shared Conversations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">💬 Chat yang Dibagikan Siswa</h2>
            <p class="text-muted mb-0">Monitor dan review percakapan chatbot</p>
        </div>
        <a href="{{ route('guru_bk.chatbot.analytics') }}" class="btn btn-outline-primary">
            <i class="fas fa-chart-bar me-2"></i>Analytics
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Dibagikan</h6>
                            <h3 class="mb-0">{{ $stats['total_shared'] }}</h3>
                        </div>
                        <i class="fas fa-share fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">🚨 Kritis</h6>
                            <h3 class="mb-0 text-danger">{{ $stats['critical'] }}</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">⚠️ Tinggi</h6>
                            <h3 class="mb-0 text-warning">{{ $stats['high'] }}</h3>
                        </div>
                        <i class="fas fa-bell fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Pending Review</h6>
                            <h3 class="mb-0 text-info">{{ $stats['pending'] }}</h3>
                        </div>
                        <i class="fas fa-clock fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'all' ? 'active' : '' }}" 
               href="{{ route('guru_bk.chatbot.shared', ['filter' => 'all']) }}">
                Semua ({{ $stats['total_shared'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'critical' ? 'active' : '' }}" 
               href="{{ route('guru_bk.chatbot.shared', ['filter' => 'critical']) }}">
                🚨 Kritis ({{ $stats['critical'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'high' ? 'active' : '' }}" 
               href="{{ route('guru_bk.chatbot.shared', ['filter' => 'high']) }}">
                ⚠️ Tinggi ({{ $stats['high'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'needs_attention' ? 'active' : '' }}" 
               href="{{ route('guru_bk.chatbot.shared', ['filter' => 'needs_attention']) }}">
                Perlu Perhatian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'pending' ? 'active' : '' }}" 
               href="{{ route('guru_bk.chatbot.shared', ['filter' => 'pending']) }}">
                Pending ({{ $stats['pending'] }})
            </a>
        </li>
    </ul>

    <!-- Conversations Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($conversations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Topik</th>
                                <th>Sentimen</th>
                                <th>Alert Level</th>
                                <th>Status</th>
                                <th>Pesan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conversations as $conv)
                                <tr class="{{ in_array($conv->alert_level, ['critical', 'high']) ? 'table-warning' : '' }}">
                                    <td>
                                        <small>{{ $conv->shared_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $conv->shared_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $conv->user->nama }}</strong><br>
                                        <small class="text-muted">
                                            {{ optional($conv->user->kelas)->nama_kelas ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($conv->topics && count($conv->topics) > 0)
                                            @foreach($conv->topics as $topic)
                                                <span class="badge bg-secondary small">{{ ucfirst($topic) }}</span>
                                            @endforeach
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>{!! $conv->sentiment_badge !!}</td>
                                    <td>{!! $conv->alert_badge !!}</td>
                                    <td>{!! $conv->status_badge !!}</td>
                                    <td>
                                        <small>{{ $conv->message_count }} pesan</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru_bk.chatbot.conversation.view', $conv->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $conversations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada percakapan yang dibagikan</h5>
                    <p class="text-muted">
                        @if($filter == 'critical')
                            Tidak ada chat dengan alert level kritis
                        @elseif($filter == 'high')
                            Tidak ada chat dengan alert level tinggi
                        @elseif($filter == 'pending')
                            Semua chat sudah direview
                        @else
                            Belum ada siswa yang membagikan chat mereka
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    @if($stats['critical'] > 0 || $stats['high'] > 0)
        <div class="alert alert-warning mt-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Ada {{ $stats['critical'] + $stats['high'] }} siswa yang butuh perhatian segera.
            Segera review dan hubungi mereka.
        </div>
    @endif
</div>
@endsection
