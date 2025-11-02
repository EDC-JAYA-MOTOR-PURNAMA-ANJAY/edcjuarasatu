@extends('layouts.app-admin')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="p-6 pt-20">
    <!-- Header with Premium Design -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="javascript:history.back()" class="w-12 h-12 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl hover:shadow-lg transition-all">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">Tahun Ajaran</h1>
                <p class="text-gray-600">Kelola periode tahun ajaran sistem Educounsel</p>
            </div>
        </div>
    </div>

    <!-- Search and Actions -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-5 border border-white/20 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative max-w-md flex-1">
                <input 
                    type="text" 
                    placeholder="Cari tahun ajaran..." 
                    class="w-full pl-10 pr-4 py-3 border-2 border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all"
                >
                <i class="fas fa-search absolute left-3 top-4 text-purple-400"></i>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all font-semibold">
                    <i class="fas fa-plus mr-2"></i>Tambah Tahun Ajaran
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl overflow-hidden border border-white/20">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-purple-50 to-pink-50">
                    <tr>
                        <th class="py-4 px-6 font-bold text-purple-900 text-left uppercase tracking-wider">Tahun Ajaran</th>
                        <th class="py-4 px-6 font-bold text-purple-900 text-left uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 font-bold text-purple-900 text-left uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-3">
                                    <i class="fas fa-calendar text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-800 text-base">2025 / 2026</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-2 border-green-200">
                                <i class="fas fa-check-circle mr-2"></i>Aktif
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold mr-3">
                                    <i class="fas fa-calendar text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-800 text-base">2024 / 2025</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-red-100 to-pink-100 text-red-700 border-2 border-red-200">
                                <i class="fas fa-times-circle mr-2"></i>NonAktif
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold mr-3">
                                    <i class="fas fa-calendar text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-800 text-base">2023 / 2024</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-red-100 to-pink-100 text-red-700 border-2 border-red-200">
                                <i class="fas fa-times-circle mr-2"></i>NonAktif
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold mr-3">
                                    <i class="fas fa-calendar text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-800 text-base">2022 / 2023</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-red-100 to-pink-100 text-red-700 border-2 border-red-200">
                                <i class="fas fa-times-circle mr-2"></i>NonAktif
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold mr-3">
                                    <i class="fas fa-calendar text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-800 text-base">2021 / 2022</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-red-100 to-pink-100 text-red-700 border-2 border-red-200">
                                <i class="fas fa-times-circle mr-2"></i>NonAktif
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-purple-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-600 font-medium">Menampilkan <span class="font-bold text-purple-600">5</span> dari <span class="font-bold text-purple-600">10</span> data</p>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-2 bg-white border-2 border-purple-200 text-purple-600 rounded-lg hover:bg-purple-50 transition-all font-semibold">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold">1</button>
                    <button class="px-4 py-2 bg-white border-2 border-purple-200 text-purple-600 rounded-lg hover:bg-purple-50 transition-all font-semibold">2</button>
                    <button class="px-3 py-2 bg-white border-2 border-purple-200 text-purple-600 rounded-lg hover:bg-purple-50 transition-all font-semibold">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>
@endsection
