@extends('layouts.app-guru-bk')

@section('title', 'Dashboard Analytics - Guru BK')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
    * {
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
    }

    body {
        background: #F8F9FA;
        margin: 0;
        padding: 0;
    }

    .dashboard-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1E293B;
        margin: 0 0 8px 0;
    }

    .page-subtitle {
        font-size: 14px;
        color: #64748B;
        margin: 0;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #8000FF 0%, #A855F7 100%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(128, 0, 255, 0.15);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 24px;
    }

    .stat-icon.primary { background: linear-gradient(135deg, #8000FF 0%, #A855F7 100%); color: white; }
    .stat-icon.success { background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; }
    .stat-icon.warning { background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; }
    .stat-icon.info { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; }

    .stat-label {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
    }

    .stat-change {
        font-size: 12px;
        font-weight: 600;
    }

    .stat-change.positive { color: #10B981; }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (max-width: 1024px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #1E293B;
        margin: 0;
    }

    .chart-subtitle {
        font-size: 12px;
        color: #64748B;
        margin-top: 4px;
    }

    .chart-canvas {
        max-height: 300px;
    }

    /* Tables */
    .table-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #1E293B;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        text-align: left;
        padding: 12px;
        background: #F8F9FA;
        font-size: 12px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        border-bottom: 2px solid #E2E8F0;
    }

    .data-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #E2E8F0;
        font-size: 14px;
        color: #475569;
    }

    .data-table tbody tr:hover {
        background: #F8F9FA;
    }

    .engagement-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .engagement-badge.high { background: #DEF7EC; color: #03543F; }
    .engagement-badge.medium { background: #FEF3C7; color: #92400E; }
    .engagement-badge.low { background: #FEE2E2; color: #991B1B; }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-primary { background: #EDE9FE; color: #8000FF; }

    /* Activity Timeline */
    .activity-timeline {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #E2E8F0;
    }

    .activity-item {
        position: relative;
        padding-left: 56px;
        padding-bottom: 24px;
    }

    .activity-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 2px solid #E2E8F0;
        font-size: 16px;
        z-index: 1;
    }

    .activity-icon.primary { background: #EDE9FE; color: #8000FF; border-color: #A855F7; }

    .activity-content {
        background: #F8F9FA;
        padding: 12px 16px;
        border-radius: 8px;
    }

    .activity-title {
        font-size: 14px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 4px;
    }

    .activity-description {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #94A3B8;
    }

    /* Export Button */
    .export-btn {
        background: linear-gradient(135deg, #8000FF 0%, #6A00D4 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(128, 0, 255, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">📊 Dashboard Analytics</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->name }}! Berikut adalah ringkasan aktivitas BK Anda.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ $statistics['total_students'] }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $statistics['active_students_today'] }} aktif hari ini
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-label">Total Materi</div>
            <div class="stat-value">{{ $statistics['total_materi'] }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> {{ $statistics['materi_this_month'] }} bulan ini
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-label">Total Notifikasi</div>
            <div class="stat-value">{{ $statistics['total_notifications'] }}</div>
            <div class="stat-change positive">
                <i class="fas fa-check"></i> {{ number_format($statistics['notification_reach_rate'], 1) }}% terbaca
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-label">Engagement Rate</div>
            <div class="stat-value">{{ number_format($studentEngagement['engagement_rate'], 1) }}%</div>
            <div class="stat-change positive">
                <i class="fas fa-users"></i> {{ $studentEngagement['active_week'] }} siswa minggu ini
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <!-- Materi by Kategori -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Materi per Kategori</h3>
                    <p class="chart-subtitle">Distribusi materi berdasarkan kategori</p>
                </div>
            </div>
            <canvas id="kategoriChart" class="chart-canvas"></canvas>
        </div>

        <!-- Materi by Jenis -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Materi per Jenis</h3>
                    <p class="chart-subtitle">Distribusi materi berdasarkan tipe konten</p>
                </div>
            </div>
            <canvas id="jenisChart" class="chart-canvas"></canvas>
        </div>

        <!-- Monthly Trend -->
        <div class="chart-card" style="grid-column: 1 / -1;">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Trend Materi Bulanan</h3>
                    <p class="chart-subtitle">Materi yang dibuat dalam 6 bulan terakhir</p>
                </div>
                <button class="export-btn" onclick="exportAnalytics()">
                    <i class="fas fa-download"></i>
                    Export Data
                </button>
            </div>
            <canvas id="trendChart" class="chart-canvas"></canvas>
        </div>
    </div>

    <!-- Top Engaged Materi Table -->
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">📈 Top 5 Materi Paling Diminati</h3>
        </div>
        @if(count($topMateri) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul Materi</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Engagement</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMateri as $materi)
                <tr>
                    <td><strong>{{ $materi['judul'] }}</strong></td>
                    <td>
                        <span class="badge badge-primary">{{ $materi['kategori'] }}</span>
                    </td>
                    <td>{{ $materi['jenis'] }}</td>
                    <td>
                        @php
                            $engagementClass = $materi['engagement'] > 50 ? 'high' : ($materi['engagement'] > 20 ? 'medium' : 'low');
                        @endphp
                        <span class="engagement-badge {{ $engagementClass }}">
                            <i class="fas fa-eye"></i> {{ $materi['engagement'] }} views
                        </span>
                    </td>
                    <td>{{ $materi['created_at'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada data engagement</p>
        </div>
        @endif
    </div>

    <!-- Recent Activities -->
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">🕒 Aktivitas Terbaru</h3>
        </div>
        @if(count($recentActivities) > 0)
        <ul class="activity-timeline">
            @foreach($recentActivities as $activity)
            <li class="activity-item">
                <div class="activity-icon {{ $activity['color'] }}">
                    <i class="fas {{ $activity['icon'] }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $activity['title'] }}</div>
                    <div class="activity-description">{{ $activity['description'] }}</div>
                    <div class="activity-time">{{ $activity['time'] }}</div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="empty-state">
            <i class="fas fa-history"></i>
            <p>Belum ada aktivitas</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Chart Colors
const colors = {
    primary: '#8000FF',
    success: '#10B981',
    warning: '#F59E0B',
    info: '#3B82F6',
    purple: '#A855F7',
};

// Kategori Chart (Doughnut)
const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
new Chart(kategoriCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($materiByKategori)) !!},
        datasets: [{
            data: {!! json_encode(array_values($materiByKategori)) !!},
            backgroundColor: [colors.primary, colors.success, colors.warning, colors.info],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, font: { size: 12 } }
            }
        }
    }
});

// Jenis Chart (Pie)
const jenisCtx = document.getElementById('jenisChart').getContext('2d');
new Chart(jenisCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode(array_keys($materiByJenis)) !!},
        datasets: [{
            data: {!! json_encode(array_values($materiByJenis)) !!},
            backgroundColor: [colors.info, colors.success, colors.purple],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, font: { size: 12 } }
            }
        }
    }
});

// Monthly Trend Chart (Line)
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyTrend['labels']) !!},
        datasets: [{
            label: 'Materi Dibuat',
            data: {!! json_encode($monthlyTrend['data']) !!},
            borderColor: colors.primary,
            backgroundColor: 'rgba(128, 0, 255, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: colors.primary,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// Export Analytics
async function exportAnalytics() {
    try {
        const response = await fetch('/guru_bk/dashboard/export', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        // Create downloadable JSON file
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `analytics_${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        alert('✅ Data analytics berhasil diexport!');
    } catch (error) {
        console.error('Export error:', error);
        alert('❌ Gagal export data');
    }
}
</script>
@endpush
