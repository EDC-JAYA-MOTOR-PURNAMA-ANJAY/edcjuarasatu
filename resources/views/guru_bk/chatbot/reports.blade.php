@extends('layouts.app-guru-bk')

@section('title', 'Laporan Chatbot - Guru BK')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
    * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
    body { background: #F8F9FA; margin: 0; padding: 0; }
    
    .chatbot-container { padding: 24px; max-width: 1400px; margin: 0 auto; }
    
    .page-header { margin-bottom: 32px; }
    .page-title { font-size: 28px; font-weight: 700; color: #1E293B; margin: 0 0 8px 0; }
    .page-subtitle { font-size: 14px; color: #64748B; margin: 0; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px; }
    
    .stat-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-4px); }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(180deg, #8000FF 0%, #A855F7 100%); }
    
    .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 24px; }
    .stat-icon.primary { background: linear-gradient(135deg, #8000FF 0%, #A855F7 100%); color: white; }
    .stat-icon.success { background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; }
    .stat-icon.warning { background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; }
    .stat-icon.info { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; }
    
    .stat-label { font-size: 13px; color: #64748B; margin-bottom: 8px; font-weight: 500; }
    .stat-value { font-size: 32px; font-weight: 700; color: #1E293B; margin-bottom: 8px; }
    .stat-change { font-size: 12px; font-weight: 600; color: #10B981; }
    
    .charts-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 32px; }
    @media (max-width: 1024px) { .charts-grid { grid-template-columns: 1fr; } }
    
    .chart-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .chart-title { font-size: 18px; font-weight: 600; color: #1E293B; margin: 0; }
    .chart-subtitle { font-size: 12px; color: #64748B; margin-top: 4px; }
    .chart-canvas { max-height: 300px; }
    
    .table-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 24px; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .table-title { font-size: 18px; font-weight: 600; color: #1E293B; margin: 0; }
    
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { text-align: left; padding: 12px; background: #F8F9FA; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; border-bottom: 2px solid #E2E8F0; }
    .data-table tbody td { padding: 16px 12px; border-bottom: 1px solid #E2E8F0; font-size: 14px; color: #475569; }
    .data-table tbody tr:hover { background: #F8F9FA; }
    
    .priority-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .priority-badge.high { background: #FEE2E2; color: #991B1B; }
    .priority-badge.medium { background: #FEF3C7; color: #92400E; }
    .priority-badge.low { background: #DBEAFE; color: #1E40AF; }
    
    .action-btn { background: #8000FF; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .action-btn:hover { background: #6A00D4; transform: translateY(-1px); }
    
    .export-btn { background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .export-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(128, 0, 255, 0.3); }
    
    .empty-state { text-align: center; padding: 48px 24px; color: #94A3B8; }
    .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
</style>
@endpush

@section('content')
<div class="chatbot-container">
    <div class="page-header">
        <h1 class="page-title">🤖 Laporan Chatbot AI Companion</h1>
        <p class="page-subtitle">Monitor dan analisis interaksi siswa dengan AI Chatbot</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-comments"></i></div>
            <div class="stat-label">Total Percakapan</div>
            <div class="stat-value">{{ $overview['total_conversations'] }}</div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> {{ $overview['active_users_today'] }} hari ini</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-users"></i></div>
            <div class="stat-label">Pengguna Aktif</div>
            <div class="stat-value">{{ $overview['active_users_week'] }}</div>
            <div class="stat-change"><i class="fas fa-calendar"></i> Minggu ini</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-star"></i></div>
            <div class="stat-label">Kepuasan Pengguna</div>
            <div class="stat-value">{{ number_format($overview['user_satisfaction_rate'], 1) }}%</div>
            <div class="stat-change"><i class="fas fa-heart"></i> Rating tinggi</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon info"><i class="fas fa-message"></i></div>
            <div class="stat-label">Rata-rata Pesan</div>
            <div class="stat-value">{{ $overview['avg_messages_per_conversation'] }}</div>
            <div class="stat-change"><i class="fas fa-comments"></i> Per percakapan</div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <!-- Topic Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Topik Percakapan</h3>
                    <p class="chart-subtitle">Distribusi masalah yang dibahas</p>
                </div>
            </div>
            <canvas id="topicChart" class="chart-canvas"></canvas>
        </div>

        <!-- Effectiveness Metrics -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Efektivitas Chatbot</h3>
                    <p class="chart-subtitle">Metrics kinerja AI</p>
                </div>
            </div>
            <canvas id="effectivenessChart" class="chart-canvas"></canvas>
        </div>

        <!-- Mood Trend -->
        <div class="chart-card" style="grid-column: 1 / -1;">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Trend Mood Siswa (30 Hari)</h3>
                    <p class="chart-subtitle">Tracking kesehatan mental siswa</p>
                </div>
                <button class="export-btn" onclick="exportReport()">
                    <i class="fas fa-download"></i> Export Laporan
                </button>
            </div>
            <canvas id="moodTrendChart" class="chart-canvas"></canvas>
        </div>
    </div>

    <!-- Students Needing Attention -->
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">⚠️ Siswa yang Memerlukan Perhatian</h3>
        </div>
        @if(count($studentsNeedingAttention) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Percakapan</th>
                    <th>Masalah Terakhir</th>
                    <th>Mood</th>
                    <th>Prioritas</th>
                    <th>Aktivitas Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsNeedingAttention as $student)
                <tr>
                    <td><strong>{{ $student['name'] }}</strong></td>
                    <td>{{ $student['kelas'] }}</td>
                    <td>{{ $student['conversation_count'] }}x</td>
                    <td>{{ $student['latest_issue'] }}</td>
                    <td>{{ $student['mood_score'] }}/5</td>
                    <td>
                        <span class="priority-badge {{ strtolower($student['priority']) }}">
                            @if($student['priority'] === 'High') 🔴 @elseif($student['priority'] === 'Medium') 🟡 @else 🟢 @endif
                            {{ $student['priority'] }}
                        </span>
                    </td>
                    <td>{{ $student['last_activity'] }}</td>
                    <td>
                        <a href="/guru_bk/chatbot/student/{{ $student['id'] }}" class="action-btn">
                            <i class="fas fa-eye"></i> Lihat Riwayat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <p>Tidak ada siswa yang memerlukan perhatian khusus saat ini</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
const colors = {
    primary: '#8000FF',
    success: '#10B981',
    warning: '#F59E0B',
    danger: '#EF4444',
    info: '#3B82F6',
};

// Topic Distribution Chart
const topicCtx = document.getElementById('topicChart').getContext('2d');
new Chart(topicCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($topicDistribution)) !!},
        datasets: [{
            data: {!! json_encode(array_values($topicDistribution)) !!},
            backgroundColor: [colors.primary, colors.success, colors.warning, colors.danger, colors.info, '#A855F7', '#10B981', '#F59E0B', '#3B82F6', '#6B7280'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { position: 'right', labels: { padding: 10, font: { size: 11 } } }
        }
    }
});

// Effectiveness Chart
const effectivenessCtx = document.getElementById('effectivenessChart').getContext('2d');
new Chart(effectivenessCtx, {
    type: 'bar',
    data: {
        labels: ['Satisfaction', 'Resolution', 'Escalation'],
        datasets: [{
            label: 'Percentage',
            data: [
                {{ $effectiveness['satisfaction_rate'] }},
                {{ $effectiveness['resolution_rate'] }},
                {{ $effectiveness['escalation_rate'] }}
            ],
            backgroundColor: [colors.success, colors.primary, colors.warning],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: { y: { beginAtZero: true, max: 100 } },
        plugins: { legend: { display: false } }
    }
});

// Mood Trend Chart
const moodTrendCtx = document.getElementById('moodTrendChart').getContext('2d');
new Chart(moodTrendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($moodTrend['labels']) !!},
        datasets: [{
            label: 'Average Mood Score',
            data: {!! json_encode($moodTrend['data']) !!},
            borderColor: colors.primary,
            backgroundColor: 'rgba(128, 0, 255, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: colors.primary,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: { y: { beginAtZero: true, max: 5 } },
        plugins: { legend: { display: false } }
    }
});

// Export Report
async function exportReport() {
    try {
        const response = await fetch('/guru_bk/chatbot/export', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });
        
        const data = await response.json();
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `chatbot-report-${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        alert('✅ Laporan berhasil diexport!');
    } catch (error) {
        console.error('Export error:', error);
        alert('❌ Gagal export laporan');
    }
}
</script>
@endpush
