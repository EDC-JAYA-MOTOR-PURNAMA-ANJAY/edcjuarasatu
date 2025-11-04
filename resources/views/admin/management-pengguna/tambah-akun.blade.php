@extends('layouts.app-admin')

@section('title', 'Tambah Akun Pengguna')

@section('content')
<div class="p-6 pt-20 min-h-screen bg-white">
    <!-- Header dengan Background Ungu Muda -->
    <div class="bg-[#F0E6FF] rounded-3xl p-8 mb-6 relative overflow-hidden" style="background-color: #F0E6FF;">
        <div class="relative z-10">
            <!-- Ikon Kembali -->
            <a href="{{ route('admin.daftar-pengguna') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full text-[#4B2A8C] hover:bg-purple-50 transition-all mb-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            
            <!-- Judul dan Subjudul -->
            <h1 class="text-4xl font-bold mb-2" style="color: #4B2A8C;">Tambah Akun Pengguna</h1>
            <p class="text-base" style="color: #555555;">Tambah Akun Pengguna di halaman ini</p>
        </div>
        
        <!-- Ilustrasi Dekoratif di Pojok Kanan (Diperkecil) -->
        <div class="absolute -right-2 -top-2 w-32 h-32 opacity-40">
            <div class="relative w-full h-full">
                <!-- Chat Bubble -->
                <div class="absolute top-4 right-4 w-16 h-12 bg-purple-400 rounded-3xl rounded-br-none"></div>
                <div class="absolute top-8 right-6 w-12 h-10 bg-purple-300 rounded-3xl rounded-br-none"></div>
                <!-- Bintang -->
                <div class="absolute top-2 right-12 text-yellow-400 text-lg">★</div>
                <div class="absolute top-10 right-2 text-yellow-300 text-sm">★</div>
                <!-- Hati -->
                <div class="absolute top-12 right-14 text-pink-400 text-xl">♥</div>
                <!-- Lingkaran -->
                <div class="absolute top-4 right-4 w-3 h-3 bg-blue-400 rounded-full"></div>
                <div class="absolute top-16 right-10 w-2 h-2 bg-pink-300 rounded-full"></div>
                <div class="absolute top-6 right-16 w-3 h-3 bg-red-300 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Form Input Data Pengguna -->
    <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
        <form id="userForm" method="POST" action="{{ route('admin.pengguna.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <div class="relative">
                        <select name="role" id="roleSelect" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all appearance-none" style="color: #333;" onchange="toggleKelasField()">
                            <option value="">Pilih Role</option>
                            <option value="guru_bk" style="background-color: #6C4AB6; color: white;">Guru BK</option>
                            <option value="siswa" style="background-color: white; color: #333;">Siswa</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    <span id="roleError" class="text-red-500 text-xs mt-1 hidden">Role harus dipilih.</span>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all">
                    <span id="namaLengkapError" class="text-red-500 text-xs mt-1 hidden">Nama lengkap wajib diisi.</span>
                </div>

                <!-- NIK / NIP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIK / NIP</label>
                    <input type="text" name="nik_nip" placeholder="Masukkan NIK / NIP"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all">
                    <span id="nikNipError" class="text-red-500 text-xs mt-1 hidden">NIK/NIP wajib diisi.</span>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all">
                    <span id="emailError" class="text-red-500 text-xs mt-1 hidden">Email wajib diisi dan harus valid.</span>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all">
                    <span id="passwordError" class="text-red-500 text-xs mt-1 hidden">Password wajib diisi minimal 6 karakter.</span>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Kelamin</label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="radio" name="jenis_kelamin" value="laki-laki" class="sr-only peer" checked>
                                <div class="w-5 h-5 border-2 rounded-full peer-checked:border-[#4B2A8C] peer-checked:border-4" style="border-color: #4B2A8C;"></div>
                            </div>
                            <span class="ml-3 text-gray-700">Laki - Laki</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="radio" name="jenis_kelamin" value="perempuan" class="sr-only peer">
                                <div class="w-5 h-5 border-2 border-purple-300 rounded-full peer-checked:border-[#4B2A8C] peer-checked:border-4"></div>
                            </div>
                            <span class="ml-3 text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    <span id="jenisKelaminError" class="text-red-500 text-xs mt-1 hidden">Jenis kelamin wajib dipilih.</span>
                </div>

                <!-- No Telephone/Whatsapp -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No Telephone / Whatsapp</label>
                    <input type="tel" name="telepon" placeholder="Masukkan No Telephone / Whatsapp"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all">
                    <span id="teleponError" class="text-red-500 text-xs mt-1 hidden">Nomor telepon wajib diisi.</span>
                </div>

                <!-- Kelas (hanya untuk Siswa) -->
                <div id="kelasField" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                    <div class="relative">
                        <select name="kelas_id" id="kelasSelect" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all appearance-none" style="color: #333;">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} - {{ $kelas->jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    <span id="kelasError" class="text-red-500 text-xs mt-1 hidden">Kelas harus dipilih untuk siswa.</span>
                </div>

                <!-- Status Akun -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Akun</label>
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all appearance-none" style="color: #333;">
                            <option value="">Pilih Status</option>
                            <option value="aktif" style="background-color: #C8E6C9; color: #2E7D32;">Aktif</option>
                            <option value="non-aktif" style="background-color: #6C4AB6; color: white;">Non-Aktif</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    <span id="statusError" class="text-red-500 text-xs mt-1 hidden">Status akun harus dipilih.</span>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" placeholder="Masukkan Alamat" rows="3"
                              class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all resize-none"></textarea>
                    <span id="alamatError" class="text-red-500 text-xs mt-1 hidden">Alamat wajib diisi.</span>
                </div>
            </div>

            <!-- Footer Tombol Aksi -->
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.daftar-pengguna') }}"
                   class="px-8 py-3 rounded-lg text-black font-medium hover:opacity-80 transition-all"
                   style="background-color: #D9D9D9;">
                    Kembali
                </a>
                <button type="button" onclick="validateAndSubmit()"
                        class="px-8 py-3 rounded-lg text-white font-medium hover:opacity-90 transition-all"
                        style="background-color: #6C4AB6;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    
    <!-- Modal Pop-up "Berhasil Dikirim!" -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeModalOnOverlay(event)">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center" onclick="event.stopPropagation()">
            <!-- Ikon Sukses -->
            <div class="mb-4 flex justify-center">
                <div class="w-20 h-20 rounded-full flex items-center justify-center" style="background-color: #E8FCE8;">
                    <svg class="w-12 h-12" style="color: #4CAF50;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Teks Judul -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Berhasil Dikirim !</h2>
            
            <!-- Teks Subjudul -->
            <p class="text-gray-600 mb-6">Data berhasil dikirim.</p>
            
            <!-- Tombol Oke -->
            <button onclick="closeSuccessModal()" 
                    class="w-full py-3 rounded-lg text-white font-medium hover:opacity-90 transition-all"
                    style="background-color: #4CAF50;">
                Oke
            </button>
        </div>
    </div>
    
    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Toggle kelas field based on role selection
function toggleKelasField() {
    const role = document.getElementById('roleSelect').value;
    const kelasField = document.getElementById('kelasField');
    
    if (role === 'siswa') {
        kelasField.classList.remove('hidden');
    } else {
        kelasField.classList.add('hidden');
        document.getElementById('kelasSelect').value = '';
    }
}

function validateAndSubmit() {
    let isValid = true;

    // Reset semua error
    document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));

    // Validasi Role
    const role = document.querySelector('select[name="role"]').value;
    if (!role) {
        document.getElementById('roleError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Nama Lengkap
    const namaLengkap = document.querySelector('input[name="nama_lengkap"]').value.trim();
    if (!namaLengkap) {
        document.getElementById('namaLengkapError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi NIK/NIP
    const nikNip = document.querySelector('input[name="nik_nip"]').value.trim();
    if (!nikNip) {
        document.getElementById('nikNipError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Email
    const email = document.querySelector('input[name="email"]').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
        document.getElementById('emailError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Password
    const password = document.querySelector('input[name="password"]').value.trim();
    if (!password || password.length < 6) {
        document.getElementById('passwordError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Jenis Kelamin
    const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
    if (!jenisKelamin) {
        document.getElementById('jenisKelaminError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Telepon
    const telepon = document.querySelector('input[name="telepon"]').value.trim();
    if (!telepon) {
        document.getElementById('teleponError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Kelas jika role = siswa
    if (role === 'siswa') {
        const kelas = document.querySelector('select[name="kelas_id"]').value;
        if (!kelas) {
            document.getElementById('kelasError').classList.remove('hidden');
            isValid = false;
        }
    }

    // Validasi Status
    const status = document.querySelector('select[name="status"]').value;
    if (!status) {
        document.getElementById('statusError').classList.remove('hidden');
        isValid = false;
    }

    // Validasi Alamat
    const alamat = document.querySelector('textarea[name="alamat"]').value.trim();
    if (!alamat) {
        document.getElementById('alamatError').classList.remove('hidden');
        isValid = false;
    }

    // Jika valid, submit via AJAX
    if (isValid) {
        submitForm();
    }
}

function submitForm() {
    const form = document.getElementById('userForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    // Disable button and show loading
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

    $.ajax({
        url: '{{ route("admin.pengguna.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // 🎙️ VOICE: Account Created
            if (window.voiceHelper && response.user) {
                const roleName = response.user.peran === 'guru_bk' ? 'Guru BK' : 
                               response.user.peran === 'siswa' ? 'Siswa' : response.user.peran;
                window.voiceHelper.speakAccountCreated(roleName, response.user.nama);
            }
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message || 'Pengguna berhasil ditambahkan',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '{{ route("admin.daftar-pengguna") }}';
            });
        },
        error: function(xhr) {
            // Re-enable button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan';
            
            if (xhr.status === 422) {
                // Validation errors
                const errors = xhr.responseJSON.errors;
                
                // Display errors
                if (errors.role) {
                    document.getElementById('roleError').textContent = errors.role[0];
                    document.getElementById('roleError').classList.remove('hidden');
                }
                if (errors.nama_lengkap) {
                    document.getElementById('namaLengkapError').textContent = errors.nama_lengkap[0];
                    document.getElementById('namaLengkapError').classList.remove('hidden');
                }
                if (errors.nik_nip) {
                    document.getElementById('nikNipError').textContent = errors.nik_nip[0];
                    document.getElementById('nikNipError').classList.remove('hidden');
                }
                if (errors.email) {
                    document.getElementById('emailError').textContent = errors.email[0];
                    document.getElementById('emailError').classList.remove('hidden');
                }
                if (errors.password) {
                    document.getElementById('passwordError').textContent = errors.password[0];
                    document.getElementById('passwordError').classList.remove('hidden');
                }
                if (errors.telepon) {
                    document.getElementById('teleponError').textContent = errors.telepon[0];
                    document.getElementById('teleponError').classList.remove('hidden');
                }
                if (errors.kelas_id) {
                    document.getElementById('kelasError').textContent = errors.kelas_id[0];
                    document.getElementById('kelasError').classList.remove('hidden');
                }
                if (errors.status) {
                    document.getElementById('statusError').textContent = errors.status[0];
                    document.getElementById('statusError').classList.remove('hidden');
                }
                if (errors.alamat) {
                    document.getElementById('alamatError').textContent = errors.alamat[0];
                    document.getElementById('alamatError').classList.remove('hidden');
                }
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        }
    });
}

function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
}

function closeSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
    // Redirect ke daftar pengguna
    window.location.href = "{{ route('admin.daftar-pengguna') }}";
}

function closeModalOnOverlay(event) {
    if (event.target.id === 'successModal') {
        closeSuccessModal();
    }
}
</script>

@endsection