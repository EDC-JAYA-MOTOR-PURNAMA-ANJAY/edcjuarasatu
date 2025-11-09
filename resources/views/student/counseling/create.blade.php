@extends('layouts.app')

@section('title', 'Ajukan Konseling - Educounsel')

@push('styles')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    /* Apply Roboto globally */
    body {
        font-family: 'Roboto', system-ui, -apple-system, sans-serif;
    }

    /* Custom Radio Button */
    .radio-custom {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        border: 2px solid #9CA3AF;
        background-color: white;
        transition: all 0.2s ease;
    }

    input[type="radio"]:checked + label .radio-custom {
        background-color: #7000CC;
        border-color: #7000CC;
        box-shadow: inset 0 0 0 3px white;
    }

    /* Efek shine untuk tombol */
    @keyframes shine {
        0% {
            transform: translateX(-100%) skewX(-12deg);
        }
        100% {
            transform: translateX(200%) skewX(-12deg);
        }
    }

    .group:hover .animate-shine {
        animation: shine 0.7s ease-out;
    }

    /* Focus ring */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 2px rgba(112, 0, 204, 0.15);
    }

    /* Popup Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1) translateY(0); }
        to { opacity: 0; transform: scale(0.9) translateY(-10px); }
    }
    .popup-show { animation: fadeIn 0.3s ease-out forwards; }
    .popup-hide { animation: fadeOut 0.3s ease-out forwards; }

    /* Hapus efek hover pada input, select, dan textarea */
    input, select, textarea {
        transition: none !important;
    }
    
    input:hover, select:hover, textarea:hover {
        border-color: #E0E0E0 !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#F9FAFB] pt-16 font-['Roboto']">
    <!-- Header Section -->
    <div class="px-6 py-4">
        <div class="bg-[#E9D7FF] rounded-xl p-4 w-[1044px] h-[144px] flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Title Section -->
            <div class="flex flex-col">
                <h1 class="text-lg font-bold text-gray-900">Ajukan Konseling</h1>
                <p class="text-xs text-gray-500 mt-1">Ajukan konseling dengan guru BK di halaman ini</p>
            </div>

            <!-- Chat Illustration -->
            <div class="w-[100px] h-[100px] flex-shrink-0">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Ilustrasi Chat" class="w-full h-full object-contain" onerror="this.style.display='none'">
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="px-6 pb-8 flex justify-center">
        <div class="bg-white rounded-xl shadow-[0px_2px_10px_rgba(0,0,0,0.05)] p-8 w-full max-w-[1024px]">
            <!-- Section Title -->
            <h2 class="text-xl font-bold text-[#7000CC] mb-6">Buat Jadwal Konseling</h2>

            <form id="counselingForm">
                @csrf
                <div class="space-y-6">

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-900 mb-2">Nama</label>
                        <input type="text" id="nama" name="nama"
                               class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent"
                               placeholder="Masukkan Nama">
                    </div>

                    <!-- Kelas & Jurusan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-900 mb-2">Kelas</label>
                            <select id="kelas" name="kelas"
                                    class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent bg-white dropdown-select">
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <div>
                            <label for="jurusan" class="block text-sm font-medium text-gray-900 mb-2">Jurusan</label>
                            <select id="jurusan" name="jurusan"
                                    class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent bg-white dropdown-select">
                                <option value="" disabled selected>Pilih Jurusan</option>
                                @foreach($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Guru BK -->
                    <div>
                        <label for="guru_bk" class="block text-sm font-medium text-gray-900 mb-2">Guru BK</label>
                        <select id="guru_bk" name="guru_bk"
                                class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent bg-white dropdown-select">
                            <option value="" disabled selected>Pilih Guru BK</option>
                            @foreach($guruBK as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Metode Konseling -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-3">Metode Konseling</label>
                        <div class="flex flex-wrap gap-6">
                            <div class="flex items-center">
                                <input type="radio" id="offline" name="metode" value="offline" class="hidden" checked>
                                <label for="offline" class="flex items-center cursor-pointer">
                                    <span class="w-5 h-5 inline-block mr-2 rounded-full border border-gray-400 flex-shrink-0 radio-custom"></span>
                                    <span class="text-gray-700 font-medium">Konseling Offline (Tatap Muka)</span>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="online" name="metode" value="online" class="hidden">
                                <label for="online" class="flex items-center cursor-pointer">
                                    <span class="w-5 h-5 inline-block mr-2 rounded-full border border-gray-400 flex-shrink-0 radio-custom"></span>
                                    <span class="text-gray-700 font-medium">Konseling Online (Via Zoom)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Konseling -->
                    <div>
                        <label for="jenis_konseling" class="block text-sm font-medium text-gray-900 mb-2">Jenis Konseling</label>
                        <select id="jenis_konseling" name="jenis_konseling"
                                class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent bg-white dropdown-select">
                            <option value="" disabled selected>Pilih Jenis Konseling</option>
                            <option value="individu">Konseling Individu</option>
                            <option value="kelompok">Konseling Kelompok</option>
                            <option value="minat_bakat">Minat dan Bakat</option>
                            <option value="mediasi_kasus">Mediasi Kasus</option>
                            <option value="karir">Konseling Karir</option>
                        </select>
                    </div>

                    <!-- Tanggal & Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-900 mb-2">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal"
                                   class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent">
                        </div>

                        <div>
                            <label for="jam" class="block text-sm font-medium text-gray-900 mb-2">Jam</label>
                            <input type="time" id="jam" name="jam"
                                   class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Cerita Singkat Masalahmu -->
                    <div>
                        <label for="cerita" class="block text-sm font-medium text-gray-900 mb-2">Cerita Singkat Masalahmu <span class="italic text-gray-500">(Optional)</span></label>
                        <textarea id="cerita" name="cerita" rows="4"
                                  class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7000CC] focus:border-transparent resize-none"
                                  placeholder="Masukkan Cerita Singkat Masalahmu"></textarea>
                    </div>

                    <!-- Submit Button dengan efek bayangan yang hilang saat hover -->
                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn"
                                class="bg-[#7000CC] text-white px-8 py-3 rounded-full font-semibold text-base transition-all duration-300 relative shadow-[0_6px_0_0_#5A00A8] hover:shadow-none hover:translate-y-1 overflow-hidden group">
                            <span class="relative z-10">Kirim</span>
                            <!-- Efek cahaya kaca -->
                            <div class="absolute inset-0 overflow-hidden rounded-full">
                                <div class="absolute -inset-full top-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform skew-x-12 group-hover:animate-shine group-hover:duration-700"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
    <div class="bg-white rounded-xl p-8 max-w-sm w-full mx-4 shadow-[0px_4px_12px_rgba(0,0,0,0.1)] z-10">
        <div class="flex flex-col items-center text-center">
            <!-- Title -->
            <h3 class="text-xl font-bold text-black mb-2">Berhasil Dikirim!</h3>

            <!-- Message -->
            <p class="text-sm text-gray-600 mb-6">Jadwal Konseling telah diajukan.</p>

            <!-- OK Button -->
            <button id="closePopup" class="bg-[#1CD062] hover:brightness-95 text-white px-6 py-3 rounded-lg font-semibold w-full transition-all duration-200 shadow-[0_4px_12px_rgba(28,208,98,0.25)]">
                Oke
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('counselingForm');
    const submitBtn = document.getElementById('submitBtn');
    const popup = document.getElementById('successPopup');
    const closeBtn = document.getElementById('closePopup');

    // Handle radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.radio-custom').forEach(el => {
                el.style.backgroundColor = '';
                el.style.borderColor = '';
                el.style.boxShadow = '';
            });
            if (this.checked) {
                const label = document.querySelector(`label[for="${this.id}"] .radio-custom`);
                label.style.backgroundColor = '#7000CC';
                label.style.borderColor = '#7000CC';
                label.style.boxShadow = 'inset 0 0 0 3px white';
            }
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validation: all required fields must be filled
        const requiredFields = ['nama', 'kelas', 'guru_bk', 'jenis_konseling', 'tanggal', 'jam'];
        const metodeSelected = document.querySelector('input[name="metode"]:checked');

        let isValid = true;
        requiredFields.forEach(id => {
            const element = document.getElementById(id);
            if (element && !element.value.trim()) isValid = false;
        });
        if (!metodeSelected) isValid = false;

        if (!isValid) {
            alert('Harap lengkapi semua field yang wajib.');
            return;
        }

        // Show loading
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';
        submitBtn.disabled = true;

        // Get form data
        const formData = new FormData(form);

        // Submit via AJAX
        fetch('{{ route("student.counseling.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success popup
                popup.classList.remove('hidden');
                popup.classList.add('popup-show');
                
                // Reset form
                form.reset();
                
                // Reset radio
                document.querySelectorAll('.radio-custom').forEach(el => {
                    el.style.backgroundColor = '';
                    el.style.borderColor = '';
                    el.style.boxShadow = '';
                });
                document.getElementById('offline').checked = true;
                document.querySelector('label[for="offline"] .radio-custom').style.backgroundColor = '#7000CC';
                document.querySelector('label[for="offline"] .radio-custom').style.borderColor = '#7000CC';
                document.querySelector('label[for="offline"] .radio-custom').style.boxShadow = 'inset 0 0 0 3px white';
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
            submitBtn.innerHTML = '<span class="relative z-10">Kirim</span><div class="absolute inset-0 overflow-hidden rounded-full"><div class="absolute -inset-full top-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform skew-x-12 group-hover:animate-shine group-hover:duration-700"></div></div>';
            submitBtn.disabled = false;
        });
    });

    // Close popup
    closeBtn.addEventListener('click', hidePopup);
    popup.addEventListener('click', (e) => {
        if (e.target === popup) hidePopup();
    });

    function hidePopup() {
        popup.classList.remove('popup-show');
        popup.classList.add('popup-hide');
        setTimeout(() => {
            popup.classList.add('hidden');
            popup.classList.remove('popup-hide');
            // Redirect to jadwal konseling
            window.location.href = '{{ route("student.counseling.schedule") }}';
        }, 300);
    }
});
</script>
@endpush