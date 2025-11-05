@extends('layouts.app-guru-bk')

@section('title', 'Dashboard - Guru BK')

@section('content')
<!-- Main Content -->
<div class="max-w-full mx-auto px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Jadwal Konseling & Notifikasi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Jadwal Konseling -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Jadwal Konseling</h2>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-600">02 - 08 Octo</span>
                            <div class="flex space-x-2">
                                <button class="p-1 hover:bg-gray-100 rounded">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button class="p-1 hover:bg-gray-100 rounded">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="overflow-x-auto">
                        <div class="min-w-full">
                            <!-- Day Headers -->
                            <div class="grid grid-cols-8 gap-0 mb-4">
                                <div class="text-center py-2"></div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Sen</p>
                                    <p class="text-sm font-semibold text-gray-700">02</p>
                                </div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Sel</p>
                                    <p class="text-sm font-semibold text-gray-700">03</p>
                                </div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Rab</p>
                                    <p class="text-sm font-semibold text-gray-700">04</p>
                                </div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Kam</p>
                                    <p class="text-sm font-semibold text-gray-700">05</p>
                                </div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Jum</p>
                                    <p class="text-sm font-semibold text-gray-700">06</p>
                                </div>
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500">Sab</p>
                                    <p class="text-sm font-semibold text-gray-700">07</p>
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div class="space-y-0">
                                <!-- 07:00 -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">07:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>

                                <!-- 08:00 - Konseling with Aida -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">08:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="col-span-3 border-l border-gray-200 px-2 py-2" style="border-top: 1px dashed #d1d5db;">
                                        <div class="bg-purple-200 rounded-xl p-3 relative h-full">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-white"></div>
                                                <div>
                                                    <p class="text-sm font-semibold text-purple-900">Konseling</p>
                                                    <p class="text-xs text-purple-700">Aida</p>
                                                </div>
                                            </div>
                                            <div class="absolute top-2 right-2 flex -space-x-2">
                                                <div class="w-6 h-6 rounded-full bg-pink-400 border-2 border-white"></div>
                                                <div class="w-6 h-6 rounded-full bg-blue-400 border-2 border-white"></div>
                                                <div class="w-6 h-6 rounded-full bg-yellow-400 border-2 border-white"></div>
                                            </div>
                                            <p class="text-xs text-purple-700 mt-2">08:00</p>
                                        </div>
                                    </div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>

                                <!-- 09:00 - Konseling with Budi -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">09:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="col-span-3 border-l border-gray-200 px-2 py-2" style="border-top: 1px dashed #d1d5db;">
                                        <div class="bg-purple-600 rounded-xl p-3 relative h-full">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-white"></div>
                                                <div>
                                                    <p class="text-sm font-semibold text-white">Konseling</p>
                                                    <p class="text-xs text-purple-100">Budi</p>
                                                </div>
                                            </div>
                                            <div class="absolute top-2 right-2 flex -space-x-2">
                                                <div class="w-6 h-6 rounded-full bg-orange-400 border-2 border-white"></div>
                                                <div class="w-6 h-6 rounded-full bg-green-400 border-2 border-white"></div>
                                            </div>
                                            <p class="text-xs text-purple-100 mt-2">09:00</p>
                                        </div>
                                    </div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>

                                <!-- 10:00 - Konseling with Citra -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">10:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="col-span-2 border-l border-gray-200 px-2 py-2" style="border-top: 1px dashed #d1d5db;">
                                        <div class="bg-purple-800 rounded-xl p-3 relative h-full">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-white"></div>
                                                <div>
                                                    <p class="text-sm font-semibold text-white">Konseling</p>
                                                    <p class="text-xs text-purple-100">Citra</p>
                                                </div>
                                            </div>
                                            <div class="absolute top-2 right-2 flex -space-x-2">
                                                <div class="w-6 h-6 rounded-full bg-red-400 border-2 border-white"></div>
                                                <div class="w-6 h-6 rounded-full bg-teal-400 border-2 border-white"></div>
                                            </div>
                                            <p class="text-xs text-purple-100 mt-2">10:30</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- 11:00 -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">11:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>

                                <!-- 12:00 -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">12:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>

                                <!-- 13:00 -->
                                <div class="grid grid-cols-8 gap-0 min-h-[60px]">
                                    <div class="text-sm font-medium text-gray-700 py-2 pr-4 text-right">13:00</div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                    <div class="border-l border-gray-200 px-2" style="border-top: 1px dashed #d1d5db;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Notifikasi</h2>
                    <div class="space-y-3">
                        <!-- Notification Item 1 -->
                        <div class="flex items-start space-x-4 bg-purple-50 rounded-xl p-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">Angket yang sudah banyak diisi dan siap di analisis</p>
                            </div>
                        </div>

                        <!-- Notification Item 2 -->
                        <div class="flex items-start space-x-4 bg-purple-50 rounded-xl p-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">Angket yang sudah banyak diisi dan siap di analisis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Statistik Cepat -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Statistik Cepat</h2>
                    <div class="space-y-6">
                        <!-- Stat 1 -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-2xl border-4 border-purple-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-purple-600">5</span>
                                </div>
                            </div>
                            <div class="flex-1 pt-2">
                                <p class="text-sm font-semibold text-gray-800">Pengajuan perunggu</p>
                                <p class="text-sm text-gray-600">persetujuan</p>
                            </div>
                        </div>

                        <!-- Stat 2 -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-2xl border-4 border-purple-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-purple-600">12</span>
                                </div>
                            </div>
                            <div class="flex-1 pt-2">
                                <p class="text-sm font-semibold text-gray-800">Konseling</p>
                                <p class="text-sm text-gray-600">Minggu ini</p>
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-2xl border-4 border-purple-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-purple-600">35</span>
                                </div>
                            </div>
                            <div class="flex-1 pt-2">
                                <p class="text-sm font-semibold text-gray-800">Siswa ditangani</p>
                                <p class="text-sm text-gray-600">bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection