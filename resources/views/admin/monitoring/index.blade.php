@extends('layouts.app-admin')

@section('title', 'Monitoring & Statistik - Educounsel')

@section('content')
<div class="min-h-screen bg-white p-4 sm:p-6 pt-20 sm:pt-24">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <button onclick="window.history.back()" class="p-2 hover:bg-white/50 rounded-lg transition">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Monitoring & Statistik</h1>
            </div>
            <p class="text-sm sm:text-base text-gray-600 ml-11">Monitoring & Statistik di halaman ini</p>
        </div>
        <div class="flex-shrink-0 z-10">
            <img src="{{ asset('images/ilustrasi_chat.png') }}"
                 alt="Chat Illustration"
                 class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 object-contain transform hover:scale-105 transition-transform duration-300">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

        <!-- Card Kiri: Statistik Permasalahan -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden flex flex-col h-full">
            <!-- Header Warna #6500B8 -->
            <div class="bg-[#6500B8] px-4 sm:px-6 py-3">
                <h2 class="text-base sm:text-lg font-bold text-white">Statistik Permasalahan</h2>
            </div>

            <!-- Body -->
            <div class="p-4 sm:p-6 flex-grow flex flex-col">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Kategori Permasalahan</h3>
                <div class="flex justify-center items-center mb-6">
                    <div class="w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap gap-4 justify-center mb-6">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-purple-600"></div>
                        <span class="text-sm text-gray-600">Akademik</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-indigo-900"></div>
                        <span class="text-sm text-gray-600">Sosial</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-purple-300"></div>
                        <span class="text-sm text-gray-600">Pribadi</span>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="mt-auto pt-4 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 mt-4">Filter</h3>
                    <form id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-2">Guru Bk</label>
                            <select name="guru_bk" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Memilih</option>
                                @foreach($guruBkList as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-2">Jurusan</label>
                            <select name="jurusan" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Memilih</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2 flex flex-col sm:flex-row gap-2 sm:justify-end">
                            <button type="submit" class="bg-indigo-200 hover:bg-indigo-300 text-gray-700 font-medium py-2 px-6 rounded-lg text-sm transition w-full sm:w-auto">
                                Submit
                            </button>
                            <button type="button" onclick="exportData()" class="bg-blue-700 hover:bg-blue-900 text-white font-medium py-2 px-6 rounded-lg text-sm transition w-full sm:w-auto">
                                Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card Kanan: Statistik Demografi -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden flex flex-col h-full">
            <!-- Header Warna #6500B8 -->
            <div class="bg-[#6500B8] px-4 sm:px-6 py-3">
                <h2 class="text-base sm:text-lg font-bold text-white">Statistik Demografi</h2>
            </div>

            <!-- Body -->
            <div class="p-4 sm:p-6 flex-grow flex flex-col">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Kategori Permasalahan</h3>
                <div class="mb-6 h-64 sm:h-72">
                    <canvas id="demografiChart"></canvas>
                </div>

                <!-- Kelas & Jurusan Filter -->
                <div class="mt-auto pt-4 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 mt-4">Filter</h3>
                    <div class="space-y-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Kelas</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Memilih</option>
                                @forelse($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @empty
                                    <option disabled>Tidak ada data kelas</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Jurusan</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Memilih</option>
                                @forelse($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @empty
                                    <option disabled>Tidak ada data jurusan</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <button onclick="exportPdf()" class="flex-1 bg-blue-700 hover:bg-blue-900 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                            PDF
                        </button>
                        <button onclick="exportExcel()" class="flex-1 bg-blue-700 hover:bg-blue-900 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                            Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    // Register the plugin globally
    Chart.register(ChartDataLabels);

    // Data from backend
    const kategoriData = @json($kategoriStats);
    const demografiData = @json($demografiStats);

    // Pie Chart for Kategori Permasalahan
    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    const kategoriChart = new Chart(ctxKategori, {
        type: 'pie',
        plugins: [ChartDataLabels],
        data: {
            labels: kategoriData.map(item => item.kategori || 'Lainnya'),
            datasets: [{
                data: kategoriData.map(item => item.total),
                backgroundColor: [
                    '#7000CC', // Purple - Akademik
                    '#32005C', // Dark Purple - Sosial
                    '#E1BBFE', // Light Purple - Pribadi
                ],
                borderWidth: 4,
                borderColor: '#ffffff',
                spacing: 6,
                hoverOffset: 15,
                hoverBorderWidth: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 20
            },
            elements: {
                arc: {
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    borderAlign: 'center',
                    offset: 0
                }
            },
            interaction: {
                mode: 'nearest',
                intersect: true
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 800,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(0);
                            return context.label + ': ' + percentage + '%';
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    anchor: 'center',
                    align: 'center',
                    offset: 0,
                    formatter: (value, ctx) => {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(0);
                        return percentage + '%';
                    }
                }
            }
        }
    });

    // Bar Chart for Demografi
    const ctxDemografi = document.getElementById('demografiChart').getContext('2d');

    // Sort data: Siswa, Siswi, Guru BK
    const sortedDemografi = [];
    const siswaData = demografiData.find(item => item.peran === 'siswa');
    const siswiData = demografiData.find(item => item.peran === 'siswi');
    const guruBkData = demografiData.find(item => item.peran === 'guru_bk');

    // Always show Siswa, Siswi, Guru BK even if no data
    sortedDemografi.push({label: 'Siswa', total: siswaData ? siswaData.total : 0, color: '#7000CC'});
    sortedDemografi.push({label: 'Siswi', total: siswiData ? siswiData.total : 0, color: '#EAD9F7'});
    sortedDemografi.push({label: 'Guru BK', total: guruBkData ? guruBkData.total : 0, color: '#B0B4EA'});

    const demografiChart = new Chart(ctxDemografi, {
        type: 'bar',
        plugins: [],  // No datalabels for bar chart
        data: {
            labels: sortedDemografi.map(item => item.label),
            datasets: [{
                label: 'Jumlah',
                data: sortedDemografi.map(item => item.total),
                backgroundColor: sortedDemografi.map(item => item.color),
                borderWidth: 0,
                borderRadius: 8,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    display: false  // Hide data labels on bars
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 300,
                    ticks: {
                        stepSize: 50,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: true,
                        color: '#404040',
                        lineWidth: 1,
                        drawBorder: false,
                        drawTicks: false
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Filter form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams(formData);

        fetch('/admin/monitoring/data?' + params.toString())
            .then(response => response.json())
            .then(data => {
                // Update kategori chart
                kategoriChart.data.labels = data.kategori.map(item => item.kategori || 'Lainnya');
                kategoriChart.data.datasets[0].data = data.kategori.map(item => item.total);
                kategoriChart.update();

                // Update demografi chart with sorted order
                const sortedFilteredDemografi = [];
                const siswaFiltered = data.demografi.find(item => item.peran === 'siswa');
                const siswiFiltered = data.demografi.find(item => item.peran === 'siswi');
                const guruBkFiltered = data.demografi.find(item => item.peran === 'guru_bk');

                // Always show all categories
                sortedFilteredDemografi.push({label: 'Siswa', total: siswaFiltered ? siswaFiltered.total : 0, color: '#7000CC'});
                sortedFilteredDemografi.push({label: 'Siswi', total: siswiFiltered ? siswiFiltered.total : 0, color: '#EAD9F7'});
                sortedFilteredDemografi.push({label: 'Guru BK', total: guruBkFiltered ? guruBkFiltered.total : 0, color: '#B0B4EA'});

                demografiChart.data.labels = sortedFilteredDemografi.map(item => item.label);
                demografiChart.data.datasets[0].data = sortedFilteredDemografi.map(item => item.total);
                demografiChart.data.datasets[0].backgroundColor = sortedFilteredDemografi.map(item => item.color);
                demografiChart.update();
            });
    });

    function exportData() {
        // 🎙️ VOICE: Export Started
        if (window.voiceHelper) {
            window.voiceHelper.speakExportStarted('Data monitoring');
        }
        
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);
        window.location.href = '/admin/monitoring/export?' + params.toString();
    }

    function exportPdf() {
        // 🎙️ VOICE: Export PDF
        if (window.voiceHelper) {
            window.voiceHelper.speakExportStarted('PDF');
        }
        
        window.location.href = '{{ route("admin.monitoring.export-pdf") }}';
    }

    function exportExcel() {
        // 🎙️ VOICE: Export Excel
        if (window.voiceHelper) {
            window.voiceHelper.speakExportStarted('Excel');
        }
        
        window.location.href = '{{ route("admin.monitoring.export-excel") }}';
    }
</script>
@endpush