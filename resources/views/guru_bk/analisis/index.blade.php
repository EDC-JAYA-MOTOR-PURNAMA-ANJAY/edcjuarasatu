@extends('layouts.app-guru-bk')

@section('title', 'Analisis Angket - Guru BK')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="max-w-full mx-auto px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Daftar Angket (2 kolom) -->
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Daftar Angket yang Telah Ditutup</h2>
            
            <!-- Dropdown -->
            <div class="mb-6">
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white text-gray-700">
                    <option>Angket Kepuasan Siswa</option>
                    <option>Angket Kelas Online</option>
                    <option>Angket Karier</option>
                    <option>Angket Bimbingan Belajar</option>
                </select>
            </div>

            <!-- List of Angket -->
            <div class="space-y-3">
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-4 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer">
                    <p class="text-gray-700 font-medium">Angket Kepuasan Siswa</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-4 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer">
                    <p class="text-gray-700 font-medium">Angket Kelas Online</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-4 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer">
                    <p class="text-gray-700 font-medium">Angket Karier</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-4 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer">
                    <p class="text-gray-700 font-medium">Angket Bimbingan Belajar</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Dashboard Analisis (1 kolom) -->
        <div class="lg:col-span-1">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Dashboard Analisis</h2>

            <!-- Pertanyaan Pilihan Ganda Card -->
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Pertanyaan Pilihan Ganda</h3>
                
                <div class="flex flex-col items-center justify-center gap-3 py-2">
                    <!-- Bar Chart -->
                    <div style="width: 100%; max-width: 200px; height: 140px; display: flex; align-items: flex-end;">
                        <canvas id="barChart"></canvas>
                    </div>

                    <!-- Pie Chart -->
                    <div style="width: 100%; max-width: 140px; height: 140px; display: flex; align-items: center; justify-content: center;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Analisis AI Otomatis Card -->
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Analisis AI Otomatis</h3>
                
                <!-- Analysis Text -->
                <div class="space-y-2 text-xs text-gray-700 leading-relaxed">
                    <p>75% siswa di kelas X RPL 1 merasa kesulitan dengan tugas coding. "Kata kunci yang sering muncul di angket karir: 'bingung', 'minat', 'kuliah'."</p>
                    <p>"Terdapat peningkatan kepuasan layanan sebesar 15% dibandingkan semester lalu.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['A', 'B', 'C'],
            datasets: [{
                data: [85, 65, 55],
                backgroundColor: [
                    '#3B82F6', // Blue
                    '#F97316', // Orange
                    '#EF4444'  // Red
                ],
                borderRadius: 8,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        display: false
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju'],
            datasets: [{
                data: [30, 25, 25, 20],
                backgroundColor: [
                    '#FB923C', // Orange
                    '#FBBF24', // Yellow
                    '#4ADE80', // Green
                    '#60A5FA'  // Blue
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Add interactivity for angket selection
    document.querySelectorAll('.cursor-pointer').forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            document.querySelectorAll('.cursor-pointer').forEach(el => {
                el.classList.remove('border-purple-500', 'bg-purple-50');
            });
            
            // Add active class to clicked item
            this.classList.add('border-purple-500', 'bg-purple-50');
        });
    });
</script>
@endpush
