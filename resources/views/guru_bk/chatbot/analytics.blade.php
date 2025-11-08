@extends('layouts.guru_bk')

@section('title', 'Chatbot Analytics')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">📊 Chatbot Analytics</h2>
            <p class="text-muted mb-0">Data percakapan 30 hari terakhir</p>
        </div>
        <a href="{{ route('guru_bk.chatbot.shared') }}" class="btn btn-outline-primary">
            <i class="fas fa-list me-2"></i>Lihat Conversations
        </a>
    </div>

    <!-- Topic Distribution -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tags me-2"></i>
                        Distribusi Topik
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($topicStats))
                        <canvas id="topicChart" height="250"></canvas>
                        
                        <div class="mt-3">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($topicStats as $topic => $count)
                                        <tr>
                                            <td><strong>{{ ucfirst($topic) }}</strong></td>
                                            <td class="text-end">{{ $count }} percakapan</td>
                                            <td class="text-end">
                                                {{ round(($count / array_sum($topicStats)) * 100, 1) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-5">Belum ada data topik</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-smile me-2"></i>
                        Analisis Sentimen
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($sentimentStats))
                        <canvas id="sentimentChart" height="250"></canvas>
                        
                        <div class="mt-3">
                            <div class="row text-center">
                                @php
                                    $total = array_sum($sentimentStats);
                                @endphp
                                <div class="col-4">
                                    <h3 class="text-success">{{ $sentimentStats['positive'] ?? 0 }}</h3>
                                    <small class="text-muted">😊 Positif</small><br>
                                    <small>{{ $total > 0 ? round((($sentimentStats['positive'] ?? 0) / $total) * 100, 1) : 0 }}%</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-secondary">{{ $sentimentStats['neutral'] ?? 0 }}</h3>
                                    <small class="text-muted">😐 Netral</small><br>
                                    <small>{{ $total > 0 ? round((($sentimentStats['neutral'] ?? 0) / $total) * 100, 1) : 0 }}%</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-danger">{{ $sentimentStats['negative'] ?? 0 }}</h3>
                                    <small class="text-muted">😢 Negatif</small><br>
                                    <small>{{ $total > 0 ? round((($sentimentStats['negative'] ?? 0) / $total) * 100, 1) : 0 }}%</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted text-center py-5">Belum ada data sentimen</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Level Distribution -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Distribusi Alert Level
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($alertStats))
                        <div class="row text-center mb-3">
                            @php
                                $alertTotal = array_sum($alertStats);
                            @endphp
                            <div class="col">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h2 class="mb-0">{{ $alertStats['critical'] ?? 0 }}</h2>
                                        <small>🚨 Kritis</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <h2 class="mb-0">{{ $alertStats['high'] ?? 0 }}</h2>
                                        <small>⚠️ Tinggi</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h2 class="mb-0">{{ $alertStats['medium'] ?? 0 }}</h2>
                                        <small>📌 Sedang</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-secondary text-white">
                                    <div class="card-body">
                                        <h2 class="mb-0">{{ $alertStats['low'] ?? 0 }}</h2>
                                        <small>ℹ️ Rendah</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h2 class="mb-0">{{ $alertStats['none'] ?? 0 }}</h2>
                                        <small>Normal</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="alertChart" height="100"></canvas>
                    @else
                        <p class="text-muted text-center py-5">Belum ada data alert</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Perlu Perhatian
                    </h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($studentsNeedingAttention->count() > 0)
                        @foreach($studentsNeedingAttention as $conv)
                            <div class="mb-3 p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $conv->user->nama }}</strong><br>
                                        <small class="text-muted">
                                            {{ optional($conv->user->kelas)->nama_kelas ?? '-' }}
                                        </small>
                                    </div>
                                    {!! $conv->alert_badge !!}
                                </div>
                                <small class="text-muted d-block mt-2">
                                    {{ $conv->shared_at->diffForHumans() }}
                                </small>
                                <a href="{{ route('guru_bk.chatbot.conversation.view', $conv->id) }}" 
                                   class="btn btn-sm btn-outline-primary mt-2 w-100">
                                    <i class="fas fa-eye me-1"></i>Lihat Detail
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i><br>
                            Tidak ada yang butuh perhatian segera
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Trend -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Trend Mingguan
                    </h5>
                </div>
                <div class="card-body">
                    @if($weeklyTrend->count() > 0)
                        <canvas id="weeklyTrendChart" height="80"></canvas>
                    @else
                        <p class="text-muted text-center py-5">Belum ada data trend</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Key Insights -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Key Insights
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>📌 Topik Paling Sering:</h6>
                            @if(!empty($topicStats))
                                @php
                                    $topTopic = array_key_first($topicStats);
                                @endphp
                                <p class="text-muted">
                                    <strong>{{ ucfirst($topTopic) }}</strong> 
                                    ({{ $topicStats[$topTopic] }} percakapan)
                                </p>
                            @else
                                <p class="text-muted">-</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>⚠️ Alert Tertinggi:</h6>
                            @if(!empty($alertStats))
                                <p class="text-muted">
                                    {{ ($alertStats['critical'] ?? 0) > 0 ? 'Kritis: ' . $alertStats['critical'] : 
                                       (($alertStats['high'] ?? 0) > 0 ? 'Tinggi: ' . $alertStats['high'] : 'Rendah') }}
                                </p>
                            @else
                                <p class="text-muted">-</p>
                            @endif
                        </div>
                    </div>
                    
                    @if(($alertStats['critical'] ?? 0) > 0 || ($alertStats['high'] ?? 0) > 0)
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Action Required:</strong>
                            Ada {{ ($alertStats['critical'] ?? 0) + ($alertStats['high'] ?? 0) }} siswa yang membutuhkan perhatian segera.
                            <a href="{{ route('guru_bk.chatbot.shared', ['filter' => 'needs_attention']) }}" class="alert-link">
                                Lihat sekarang →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
// Topic Chart
@if(!empty($topicStats))
new Chart(document.getElementById('topicChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_map('ucfirst', array_keys($topicStats))) !!},
        datasets: [{
            data: {!! json_encode(array_values($topicStats)) !!},
            backgroundColor: [
                '#8000FF', '#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A',
                '#98D8C8', '#F7DC6F', '#BB8FCE'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
@endif

// Sentiment Chart
@if(!empty($sentimentStats))
new Chart(document.getElementById('sentimentChart'), {
    type: 'pie',
    data: {
        labels: ['Positif', 'Netral', 'Negatif'],
        datasets: [{
            data: [
                {{ $sentimentStats['positive'] ?? 0 }},
                {{ $sentimentStats['neutral'] ?? 0 }},
                {{ $sentimentStats['negative'] ?? 0 }}
            ],
            backgroundColor: ['#28a745', '#6c757d', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
@endif

// Alert Chart
@if(!empty($alertStats))
new Chart(document.getElementById('alertChart'), {
    type: 'bar',
    data: {
        labels: ['Kritis', 'Tinggi', 'Sedang', 'Rendah', 'Normal'],
        datasets: [{
            label: 'Jumlah',
            data: [
                {{ $alertStats['critical'] ?? 0 }},
                {{ $alertStats['high'] ?? 0 }},
                {{ $alertStats['medium'] ?? 0 }},
                {{ $alertStats['low'] ?? 0 }},
                {{ $alertStats['none'] ?? 0 }}
            ],
            backgroundColor: ['#dc3545', '#ffc107', '#17a2b8', '#6c757d', '#e9ecef']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
@endif

// Weekly Trend Chart
@if($weeklyTrend->count() > 0)
new Chart(document.getElementById('weeklyTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($weeklyTrend->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        })) !!},
        datasets: [{
            label: 'Percakapan Dibagikan',
            data: {!! json_encode($weeklyTrend->pluck('count')) !!},
            borderColor: '#8000FF',
            backgroundColor: 'rgba(128, 0, 255, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
@endif
</script>
@endsection
