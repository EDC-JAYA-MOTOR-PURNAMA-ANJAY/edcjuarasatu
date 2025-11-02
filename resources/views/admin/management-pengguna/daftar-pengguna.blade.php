@extends('layouts.app-admin')

@section('title', 'Daftar Pengguna')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    /* Custom styles untuk status dengan border radius 10px dan ukuran 110x35 */
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 110px;
        height: 35px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-aktif {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .status-nonaktif {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    /* Style untuk tombol aksi dengan gambar */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .action-btn:hover {
        transform: scale(1.05);
    }
    
    .edit-btn {
        background-color: #ffedd5;
    }
    
    .edit-btn:hover {
        background-color: #fed7aa;
    }
    
    .delete-btn {
        background-color: #fee2e2;
    }
    
    .delete-btn:hover {
        background-color: #fecaca;
    }
    
    .action-icon {
        width: 16px;
        height: 16px;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
<div class="p-6 pt-20 font-sans">

    <!-- HEADER CARD (Visual Diperbarui) -->
    <div class="bg-[#EDE2FF] rounded-2xl p-6 mb-8 flex items-center justify-between shadow-sm">
        <!-- Panah Kembali -->
        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>

        <!-- Judul Utama (Tengah) -->
        <div class="text-center flex-1">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Pengguna di halaman ini</p>
        </div>

        <!-- Ilustrasi Chat Modern (Dekoratif, Tanpa Gambar Eksternal) -->
        <div class="relative w-24 flex justify-end">
            <!-- Balon chat utama -->
            <div class="relative z-10">
                <div class="w-16 h-12 bg-purple-500 rounded-2xl flex items-center justify-center">
                    <span class="text-white text-xs font-bold">Hi!</span>
                </div>
                <div class="absolute -bottom-1 left-4 w-3 h-3 bg-purple-500 transform rotate-45"></div>
            </div>

            <!-- Elemen dekoratif mengambang -->
            <div class="absolute -top-2 -right-2 w-3 h-3 bg-yellow-400 rounded-full"></div>
            <div class="absolute top-4 -right-1 w-2 h-2 bg-blue-300 rounded-full"></div>
            <div class="absolute bottom-6 -right-2 w-2 h-2 bg-green-400 rounded-full"></div>
            <div class="absolute bottom-2 -right-3 w-1.5 h-1.5 bg-orange-400 rounded-full"></div>
            <div class="absolute -top-1 left-1 w-2 h-2 border border-gray-400 rounded-full"></div>
        </div>
    </div>

    <!-- Label di atas Search -->
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Daftar Pengguna</h2>

    <!-- SEARCH & FILTER BAR -->
    <form action="{{ route('admin.daftar-pengguna') }}" method="GET" id="filterForm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <!-- Search Input -->
            <div class="flex-1 relative max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Telusuri pengguna..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 text-sm shadow-sm">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>

            <!-- Buttons Group -->
            <div class="flex gap-2 items-center">
                <!-- Filter Dropdown Button -->
                <div class="relative">
                    <button type="button" id="filterButton" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-600 hover:bg-purple-50 hover:border-purple-300 transition shadow-sm">
                        <i class="fas fa-filter text-xs"></i>
                        <span>Filter</span>
                        <i id="filterChevron" class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"></i>
                    </button>

                    <!-- Advanced Filter Dropdown Panel -->
                    <div id="filterDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-200 hidden z-50 overflow-hidden">
                        <div class="p-5">
                            <!-- Header Filter -->
                            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-filter text-purple-600"></i>
                                    <h3 class="text-sm font-semibold text-gray-700">Filter Data</h3>
                                </div>
                                <button type="button" onclick="resetFilters()" class="text-xs text-gray-500 hover:text-purple-600 transition">Reset</button>
                            </div>

                            <!-- Filter Categories -->
                            <div class="space-y-1">
                                <!-- Role Filter -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button type="button" onclick="toggleFilterSection('role')" class="w-full flex items-center justify-between px-4 py-3 hover:bg-purple-50 transition group">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Role</span>
                                        <i id="roleChevron" class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                                    </button>
                                    <div id="roleSection" class="px-4 pb-3 space-y-2.5 hidden bg-gray-50">
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_role" value="admin" {{ request('filter_role') == 'admin' ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="text-sm text-gray-700 group-hover:text-purple-700">Admin</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_role" value="guru_bk" {{ request('filter_role') == 'guru_bk' ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="text-sm text-gray-700 group-hover:text-purple-700">Guru BK</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_role" value="siswa" {{ request('filter_role') == 'siswa' ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="text-sm text-gray-700 group-hover:text-purple-700">Siswa</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button type="button" onclick="toggleFilterSection('status')" class="w-full flex items-center justify-between px-4 py-3 hover:bg-purple-50 transition group {{ request('filter_status') ? 'bg-purple-50' : '' }}">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Status</span>
                                        <i id="statusChevron" class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                                    </button>
                                    <div id="statusSection" class="px-4 pb-3 space-y-2.5 hidden bg-gray-50">
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_status" value="aktif" {{ request('filter_status') == 'aktif' ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="inline-flex items-center gap-2">
                                                <span class="status-badge status-aktif">Aktif</span>
                                            </span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_status" value="non-aktif" {{ request('filter_status') == 'non-aktif' ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="inline-flex items-center gap-2">
                                                <span class="status-badge status-nonaktif">NonAktif</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Kelas Filter -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button type="button" onclick="toggleFilterSection('kelas')" class="w-full flex items-center justify-between px-4 py-3 hover:bg-purple-50 transition group">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Kelas</span>
                                        <i id="kelasChevron" class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                                    </button>
                                    <div id="kelasSection" class="px-4 pb-3 space-y-2.5 hidden bg-gray-50 max-h-64 overflow-y-auto">
                                        @foreach($kelasList as $kelas)
                                        <label class="flex items-center gap-3 cursor-pointer py-1.5 hover:bg-white px-2 rounded-lg transition group">
                                            <input type="radio" name="filter_kelas" value="{{ $kelas->id }}" {{ request('filter_kelas') == $kelas->id ? 'checked' : '' }} class="hidden peer">
                                            <span class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-purple-600 transition">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                                            </span>
                                            <span class="text-sm text-gray-700 group-hover:text-purple-700">{{ $kelas->nama_kelas }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <button type="submit" class="w-full mt-5 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Active Filters Display -->
    @if(request('filter_role') || request('filter_status') || request('filter_kelas'))
    <div class="mb-4 flex flex-wrap gap-2 items-center">
        <span class="text-sm text-gray-600 font-medium">Filter Aktif:</span>
        
        @if(request('filter_role'))
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm">
            <span class="font-medium">Role:</span>
            <span>{{ request('filter_role') == 'guru_bk' ? 'Guru BK' : ucfirst(request('filter_role')) }}</span>
            <a href="{{ request()->fullUrlWithQuery(['filter_role' => null]) }}" class="ml-1 hover:text-purple-900">
                <i class="fas fa-times text-xs"></i>
            </a>
        </span>
        @endif

        @if(request('filter_status'))
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm">
            <span class="font-medium">Status:</span>
            <span>{{ ucfirst(request('filter_status')) }}</span>
            <a href="{{ request()->fullUrlWithQuery(['filter_status' => null]) }}" class="ml-1 hover:text-purple-900">
                <i class="fas fa-times text-xs"></i>
            </a>
        </span>
        @endif

        @if(request('filter_kelas'))
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm">
            <span class="font-medium">Kelas:</span>
            <span>{{ $kelasList->where('id', request('filter_kelas'))->first()->nama_kelas ?? '-' }}</span>
            <a href="{{ request()->fullUrlWithQuery(['filter_kelas' => null]) }}" class="ml-1 hover:text-purple-900">
                <i class="fas fa-times text-xs"></i>
            </a>
        </span>
        @endif

        <a href="{{ route('admin.daftar-pengguna') }}" class="text-sm text-red-600 hover:text-red-700 font-medium ml-2">
            <i class="fas fa-times-circle mr-1"></i>Hapus Semua
        </a>
    </div>
    @endif

    <!-- USERS TABLE -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIS/NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $user->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->nis_nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($user->peran === 'admin')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Admin</span>
                            @elseif($user->peran === 'guru_bk')
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Guru BK</span>
                            @else
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Siswa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $user->kelas ? $user->kelas->nama_kelas : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->status === 'aktif')
                                <span class="status-badge status-aktif">Aktif</span>
                            @else
                                <span class="status-badge status-nonaktif">NonAktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="action-btn edit-btn" title="Edit">
                                    <!-- Ganti dengan path gambar edit Anda -->
                                    <img src="{{ asset('images/icon/edit.png') }}" alt="Edit" class="action-icon" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                    <i class="fas fa-edit text-xs" style="display: none; color: #ea580c;"></i>
                                </a>
                                <button onclick="deleteUser({{ $user->id }}, '{{ $user->nama }}')" class="action-btn delete-btn" title="Hapus">
                                    <!-- Ganti dengan path gambar hapus Anda -->
                                    <img src="{{ asset('images/icon/hapus.png') }}" alt="Hapus" class="action-icon" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                    <i class="fas fa-trash text-xs" style="display: none; color: #dc2626;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-3 opacity-30"></i>
                            <p class="font-medium">Tidak ada data pengguna.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-600 font-medium">Menampilkan <span class="font-bold text-gray-800">{{ $users->count() }}</span> dari <span class="font-bold text-gray-800">{{ $users->total() }}</span> data</p>
                <div class="flex items-center gap-1">
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
                    @endphp

                    <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 text-sm rounded-lg {{ $currentPage > 1 ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>

                    @for ($i = 1; $i <= $lastPage; $i++)
                        @if ($i == $currentPage)
                            <span class="px-3 py-1.5 text-sm bg-purple-600 text-white rounded-lg">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" class="px-3 py-1.5 text-sm bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 rounded-lg">{{ $i }}</a>
                        @endif
                    @endfor

                    <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 text-sm rounded-lg {{ $currentPage < $lastPage ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS MODAL -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl p-6 max-w-sm w-full shadow-xl">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Berhasil Dikirim!</h3>
                <p class="text-sm text-gray-600 mb-6">Data berhasil dikirim.</p>
                <button onclick="closeSuccessModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Oke
                </button>
            </div>
        </div>
    </div>

    <div class="h-8"></div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@push('scripts')
<script>
    // Toggle Filter Dropdown
    document.getElementById('filterButton').addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('filterDropdown');
        const chevron = document.getElementById('filterChevron');
        const isHidden = dropdown.classList.contains('hidden');
        
        dropdown.classList.toggle('hidden');
        chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    // Close dropdown if click outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('filterDropdown');
        const button = document.getElementById('filterButton');
        
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            document.getElementById('filterChevron').style.transform = 'rotate(0deg)';
        }
    });

    // Toggle Filter Sections (Expandable/Collapsible)
    function toggleFilterSection(sectionName) {
        const section = document.getElementById(`${sectionName}Section`);
        const chevron = document.getElementById(`${sectionName}Chevron`);
        const isHidden = section.classList.contains('hidden');
        
        // Toggle visibility
        section.classList.toggle('hidden');
        
        // Rotate chevron
        if (isHidden) {
            chevron.style.transform = 'rotate(180deg)';
        } else {
            chevron.style.transform = 'rotate(0deg)';
        }
    }

    // Reset All Filters
    function resetFilters() {
        // Uncheck all radio buttons
        document.querySelectorAll('input[name="filter_role"], input[name="filter_status"], input[name="filter_kelas"]').forEach(input => {
            input.checked = false;
        });
        
        // Close all expandable sections
        ['role', 'status', 'kelas'].forEach(section => {
            document.getElementById(`${section}Section`).classList.add('hidden');
            document.getElementById(`${section}Chevron`).style.transform = 'rotate(0deg)';
        });
    }

    // Auto-expand sections that have active filters
    document.addEventListener('DOMContentLoaded', function() {
        // Check if any filter is active and expand that section
        @if(request('filter_role'))
            toggleFilterSection('role');
        @endif
        
        @if(request('filter_status'))
            toggleFilterSection('status');
        @endif
        
        @if(request('filter_kelas'))
            toggleFilterSection('kelas');
        @endif
    });

    // Delete User with SweetAlert
    function deleteUser(userId, userName) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: `Apakah Anda yakin ingin menghapus "${userName}"? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send delete request
                $.ajax({
                    url: `/admin/pengguna/${userId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'Pengguna berhasil dihapus.',
                            icon: 'success',
                            confirmButtonColor: '#10b981',
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Gagal menghapus pengguna.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                });
            }
        });
    }

    // Show success message if redirected from tambah akun
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonColor: '#10b981',
            timer: 3000
        });
    @endif
</script>
@endpush

@endsection