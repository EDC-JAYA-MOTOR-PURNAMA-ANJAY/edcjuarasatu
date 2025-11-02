@extends('layouts.app-admin')

@section('title', 'Dashboard Admin - Educounsel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#D3B0EF] to-white bg-[50%_50%]">
    @include('components.navbar')
    
    <div class="p-6 pt-24"> <!-- Added pt-24 to account for fixed navbar -->
        

        <!-- Stats Grid - 4 Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Siswa Card -->
            <div class="bg-white rounded-2xl shadow-soft p-6 relative overflow-hidden">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-inter mb-2">Total Siswa</p>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2 font-poppins">300</h3>
                        <p class="text-green-500 text-xs font-inter flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8.5% Up from every year
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-[#E0E7FF] rounded-xl flex items-center justify-center ml-4">
                        <i class="fas fa-users text-[#6366F1] text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Admin Card -->
            <div class="bg-white rounded-2xl shadow-soft p-6 relative overflow-hidden">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-inter mb-2">Total Admin</p>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2 font-poppins">2</h3>
                        <p class="text-green-500 text-xs font-inter flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 1.3% Up from every day
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEF9C3] rounded-xl flex items-center justify-center ml-4">
                        <i class="fas fa-user-shield text-[#FACC15] text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Guru BK Card -->
            <div class="bg-white rounded-2xl shadow-soft p-6 relative overflow-hidden">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-inter mb-2">Total Guru BK</p>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2 font-poppins">5</h3>
                        <p class="text-green-500 text-xs font-inter flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8.5% Up from every year
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-[#D1FAE5] rounded-xl flex items-center justify-center ml-4">
                        <i class="fas fa-chalkboard-teacher text-[#10B981] text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Konseling Card -->
            <div class="bg-white rounded-2xl shadow-soft p-6 relative overflow-hidden">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-inter mb-2">Total Konseling</p>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2 font-poppins">10</h3>
                        <p class="text-red-500 text-xs font-inter flex items-center">
                            <i class="fas fa-arrow-down mr-1"></i> 4.3% Down from yesterday
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-[#FFE4E6] rounded-xl flex items-center justify-center ml-4">
                        <i class="fas fa-comments text-[#FB7185] text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Chart -->
        <div class="bg-white rounded-2xl shadow-soft p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 font-poppins">Statistics</h3>
            </div>
            <div class="h-80">
                <canvas id="statisticsChart"></canvas>
            </div>
        </div>

        <!-- Three Chart Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Siswa Donut Chart -->
            <div class="bg-white rounded-2xl shadow-soft p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 font-poppins">Siswa</h3>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-40 mb-4">
                        <canvas id="siswaChart"></canvas>
                    </div>
                    <div class="space-y-2 text-center w-full">
                        <div class="flex items-center justify-between px-4 py-2 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-[#6366F1] rounded-full mr-2"></div>
                                <span class="text-sm text-gray-700 font-inter">Laki-laki</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 font-poppins">290</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-2 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-[#E0E7FF] rounded-full mr-2"></div>
                                <span class="text-sm text-gray-700 font-inter">Perempuan</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 font-poppins">10</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pie Chart -->
            <div class="bg-white rounded-2xl shadow-soft p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 font-poppins">Data</h3>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-40 mb-4">
                        <canvas id="dataChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs w-full">
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 bg-[#3B82F6] rounded-full"></div>
                            <span class="text-gray-700 font-inter">35% Siswa</span>
                        </div>
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 bg-[#10B981] rounded-full"></div>
                            <span class="text-gray-700 font-inter">30% Guru BK</span>
                        </div>
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 bg-[#FACC15] rounded-full"></div>
                            <span class="text-gray-700 font-inter">10% Admin</span>
                        </div>
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 bg-[#FB7185] rounded-full"></div>
                            <span class="text-gray-700 font-inter">25% Konseling</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guru BK Donut Chart -->
            <div class="bg-white rounded-2xl shadow-soft p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 font-poppins">Guru BK</h3>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-40 mb-4">
                        <canvas id="guruChart"></canvas>
                    </div>
                    <div class="space-y-2 text-center w-full">
                        <div class="flex items-center justify-between px-4 py-2 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-[#10B981] rounded-full mr-2"></div>
                                <span class="text-sm text-gray-700 font-inter">Guru BK</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 font-poppins">4</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-2 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-[#A7F3D0] rounded-full mr-2"></div>
                                <span class="text-sm text-gray-700 font-inter">Guru BK Baru</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 font-poppins">1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js  "></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Statistics Area Chart
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        const statisticsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['5%', '10%', '15%', '20%', '25%', '30%', '35%', '40%', '45%', '50%', '55%', '60%'],
                datasets: [
                    {
                        label: 'Permasalahan',
                        data: [15, 30, 25, 45, 40, 60, 75, 70, 65, 80, 85, 90],
                        borderColor: '#FB923C',
                        backgroundColor: 'rgba(251, 146, 60, 0.2)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FB923C',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Pengguna',
                        data: [10, 20, 35, 30, 50, 45, 65, 80, 75, 85, 80, 95],
                        borderColor: '#A78BFA',
                        backgroundColor: 'rgba(167, 139, 250, 0.2)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#A78BFA',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: 'Inter',
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#374151',
                        bodyColor: '#374151',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 20,
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            color: '#6B7280'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Siswa Donut Chart
        const siswaCtx = document.getElementById('siswaChart').getContext('2d');
        const siswaChart = new Chart(siswaCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [290, 10],
                    backgroundColor: ['#6366F1', '#E0E7FF'],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Data Pie Chart
        const dataCtx = document.getElementById('dataChart').getContext('2d');
        const dataChart = new Chart(dataCtx, {
            type: 'pie',
            data: {
                labels: ['Siswa', 'Guru BK', 'Admin', 'Konseling'],
                datasets: [{
                    data: [35, 30, 10, 25],
                    backgroundColor: ['#3B82F6', '#10B981', '#FACC15', '#FB7185'],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                }
            }
        });

        // Guru BK Donut Chart
        const guruCtx = document.getElementById('guruChart').getContext('2d');
        const guruChart = new Chart(guruCtx, {
            type: 'doughnut',
            data: {
                labels: ['Guru BK', 'Guru BK Baru'],
                datasets: [{
                    data: [4, 1],
                    backgroundColor: ['#10B981', '#A7F3D0'],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }
    
    .font-inter {
        font-family: 'Inter', sans-serif;
    }
    
    .shadow-soft {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    /* Smooth transitions for hover effects */
    .bg-white {
        transition: all 0.3s ease;
    }
    
    .bg-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
</style>
@endpush
@endsection