@extends('layouts.app')

@section('title', 'Ajukan Konseling - Educounsel')

@push('styles')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="min-h-screen bg-[#F9FAFB] pt-16 font-['Roboto']">
    <!-- Header Section -->
    <div class="px-6 py-6 flex justify-center">
        <div class="bg-[#EDE1FA] rounded-xl p-6 w-full max-w-[1024px] flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Back Button + Title -->
            <div class="flex items-center space-x-3">
                <a href="#" class="text-gray-700 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Ajukan Konseling</h1>
                    <p class="text-sm text-gray-600 mt-1">Ajukan konseling dengan guru bk di halaman ini</p>
                </div>
            </div>

            <!-- Chat Illustration (160x160) -->
            <div class="w-[160px] h-[160px] flex-shrink-0">
                <img src="{{ asset('images/ilustrasi_chat.png') }}" alt="Ilustrasi Chat" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="px-6 pb-8 flex justify-center">
        <div class="bg-white rounded-xl shadow-[0px_4px_16px_rgba(0,0,0,0.08)] p-8 w-full max-w-[1024px]">
            <!-- Section Title -->
            <h2 class="text-lg font-bold text-[#6A4C93] mb-6">Buat Jadwal Konseling</h2>

            <form id="counselingForm">
                <div class="space-y-6">

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-900 mb-2">Nama</label>
                        <input type="text" id="nama" name="nama"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan Nama">
                    </div>

                    <!-- Kelas & Jurusan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-900 mb-2">Kelas</label>
                            <div class="relative">
                                <select id="kelas" name="kelas"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="10">Kelas 10</option>
                                    <option value="11">Kelas 11</option>
                                    <option value="12">Kelas 12</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="jurusan" class="block text-sm font-medium text-gray-900 mb-2">Jurusan</label>
                            <div class="relative">
                                <select id="jurusan" name="jurusan"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    <option value="ipa">IPA</option>
                                    <option value="ips">IPS</option>
                                    <option value="bahasa">Bahasa</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guru BK -->
                    <div>
                        <label for="guru_bk" class="block text-sm font-medium text-gray-900 mb-2">Guru BK</label>
                        <div class="relative">
                            <select id="guru_bk" name="guru_bk"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200 bg-white">
                                <option value="" disabled selected>Pilih Guru BK</option>
                                <option value="1">Bu Sari Indah, M.Psi.</option>
                                <option value="2">Pak Budi Santoso, S.Pd.</option>
                                <option value="3">Bu Maya Wulandari, M.Pd.</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Konseling -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-3">Metode Konseling</label>
                        <div class="flex flex-wrap gap-6">
                            <div class="flex items-center">
                                <input type="radio" id="offline" name="metode" value="offline" class="hidden" checked>
                                <label for="offline" class="flex items-center cursor-pointer">
                                    <span class="w-5 h-5 inline-block mr-2 rounded-full border border-gray-400 flex-shrink-0 radio-custom"></span>
                                    <span class="text-gray-700">Konseling Offline (Tatap Muka)</span>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="online" name="metode" value="online" class="hidden">
                                <label for="online" class="flex items-center cursor-pointer">
                                    <span class="w-5 h-5 inline-block mr-2 rounded-full border border-gray-400 flex-shrink-0 radio-custom"></span>
                                    <span class="text-gray-700">Konseling Online (Via Zoom)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Konseling -->
                    <div>
                        <label for="jenis_konseling" class="block text-sm font-medium text-gray-900 mb-2">Jenis Konseling</label>
                        <div class="relative">
                            <select id="jenis_konseling" name="jenis_konseling"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200 bg-white">
                                <option value="" disabled selected>Pilih Jenis Konseling</option>
                                <option value="akademik">Konseling Akademik</option>
                                <option value="karir">Konseling Karir</option>
                                <option value="personal">Konseling Personal/Sosial</option>
                                <option value="keluarga">Konseling Keluarga</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal & Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-900 mb-2">Tanggal</label>
                            <div class="relative">
                                <input type="date" id="tanggal" name="tanggal"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 001 1h8a1 1 0 001-1V6a1 1 0 00-1-1H7a1 1 0 00-1 1v1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="jam" class="block text-sm font-medium text-gray-900 mb-2">Jam</label>
                            <div class="relative">
                                <input type="time" id="jam" name="jam"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cerita Singkat Masalahmu -->
                    <div>
                        <label for="cerita" class="block text-sm font-medium text-gray-900 mb-2">Cerita Singkat Masalahmu <span class="italic text-gray-500">(Optional)</span></label>
                        <textarea id="cerita" name="cerita" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6A4C93] focus:border-transparent transition-all duration-200 resize-none"
                                  placeholder="Masukkan Cerita Singkat Masalahmu"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn"
                                class="bg-[#6A4C93] hover:bg-[#563D7C] text-white px-6 py-3 rounded-lg font-semibold text-base transition-all duration-200 shadow-[0px_3px_6px_rgba(106,76,147,0.25)] hover:shadow-[0px_4px_8px_rgba(106,76,147,0.3)]">
                            Kirim
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
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-[#1CD062] rounded-full flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

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

@push('styles')
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
        background-color: #6A4C93;
        border-color: #6A4C93;
        box-shadow: inset 0 0 0 3px white;
    }

    /* Focus ring */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 2px rgba(106, 76, 147, 0.15);
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
</style>
@endpush

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
                label.style.backgroundColor = '#6A4C93';
                label.style.borderColor = '#6A4C93';
                label.style.boxShadow = 'inset 0 0 0 3px white';
            }
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validation: all required fields must be filled
        const requiredFields = ['nama', 'kelas', 'jurusan', 'guru_bk', 'jenis_konseling', 'tanggal', 'jam'];
        const metodeSelected = document.querySelector('input[name="metode"]:checked');

        let isValid = true;
        requiredFields.forEach(id => {
            if (!document.getElementById(id).value.trim()) isValid = false;
        });
        if (!metodeSelected) isValid = false;

        if (!isValid) {
            alert('Harap lengkapi semua field yang wajib.');
            return;
        }

        // Show loading
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';
        submitBtn.disabled = true;

        // Simulate API delay
        setTimeout(() => {
            popup.classList.remove('hidden');
            popup.classList.add('popup-show');
            form.reset();
            // Reset radio
            document.querySelectorAll('.radio-custom').forEach(el => {
                el.style.backgroundColor = '';
                el.style.borderColor = '';
                el.style.boxShadow = '';
            });
            document.getElementById('offline').checked = true;
            document.querySelector('label[for="offline"] .radio-custom').style.backgroundColor = '#6A4C93';
            document.querySelector('label[for="offline"] .radio-custom').style.borderColor = '#6A4C93';
            document.querySelector('label[for="offline"] .radio-custom').style.boxShadow = 'inset 0 0 0 3px white';

            submitBtn.innerHTML = 'Kirim';
            submitBtn.disabled = false;
        }, 1200);
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
        }, 300);
    }
});
</script>
@endpush
