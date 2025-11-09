@extends('layouts.app-guru-bk')

@section('title', 'Tambah Kuesioner')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    
    * {
        font-family: 'Roboto', sans-serif;
    }
    
    .question-card {
        transition: all 0.3s ease;
    }
    
    .question-card:hover {
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.15);
    }
    
    .opsi-input:focus {
        ring: 2px;
        ring-color: rgb(139, 92, 246);
    }
</style>

<div class="p-6 pt-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-100 to-purple-50 rounded-xl p-5 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('guru_bk.kuesioner.index') }}" class="w-10 h-10 flex items-center justify-center bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-0.5">Tambah Kuesioner</h1>
                    <p class="text-gray-500 text-xs">Buat kuesioner baru untuk siswa</p>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Create Illustration" class="w-24 h-24 object-contain">
            </div>
        </div>
    </div>

    <form action="{{ route('guru_bk.kuesioner.store') }}" method="POST" id="kuesionerForm">
        @csrf
        
        <!-- Section 1: Informasi Kuesioner -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                Informasi Kuesioner
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Kuesioner <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="judul" 
                        value="{{ old('judul') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                        placeholder="Contoh: Kuesioner Minat & Bakat Siswa"
                        required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kuesioner -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kuesioner <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="jenis_kuesioner_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        required>
                        <option value="">Pilih Jenis</option>
                        @foreach($jenisKuesioner ?? [] as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_kuesioner_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_kuesioner }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_kuesioner_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kadaluarsa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kadaluarsa
                    </label>
                    <input 
                        type="date" 
                        name="expired_at" 
                        value="{{ old('expired_at') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('expired_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea 
                        name="deskripsi" 
                        rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                        placeholder="Jelaskan tujuan dan instruksi pengisian kuesioner...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 2: Pertanyaan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-question-circle text-purple-600 mr-2"></i>
                    Daftar Pertanyaan
                </h2>
                <button 
                    type="button" 
                    onclick="addQuestion()" 
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Pertanyaan
                </button>
            </div>

            <div id="questionsContainer">
                <!-- Questions will be added here dynamically -->
            </div>

            <div id="emptyState" class="text-center py-8 text-gray-400">
                <i class="fas fa-clipboard-question text-5xl mb-3"></i>
                <p class="font-medium">Belum ada pertanyaan</p>
                <p class="text-sm">Klik tombol "Tambah Pertanyaan" untuk memulai</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('guru_bk.kuesioner.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-medium">
                Batal
            </a>
            <button 
                type="submit" 
                class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md hover:shadow-lg font-medium">
                <i class="fas fa-save mr-2"></i>
                Simpan Kuesioner
            </button>
        </div>
    </form>

    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>

@push('scripts')
<script>
let questionCounter = 0;

// Add new question
function addQuestion() {
    questionCounter++;
    const container = document.getElementById('questionsContainer');
    const emptyState = document.getElementById('emptyState');
    
    if (emptyState) {
        emptyState.style.display = 'none';
    }
    
    const questionHtml = `
        <div class="question-card border border-gray-200 rounded-lg p-4 mb-4" data-question="${questionCounter}">
            <div class="flex items-start justify-between mb-3">
                <h3 class="font-semibold text-gray-800">Pertanyaan #${questionCounter}</h3>
                <button 
                    type="button" 
                    onclick="removeQuestion(${questionCounter})" 
                    class="text-red-500 hover:text-red-700 transition-colors"
                    title="Hapus Pertanyaan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <!-- Pertanyaan Text -->
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="pertanyaan[${questionCounter}][pertanyaan]" 
                    rows="2" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm" 
                    placeholder="Tuliskan pertanyaan Anda..."
                    required></textarea>
            </div>

            <!-- Tipe Jawaban -->
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Jawaban <span class="text-red-500">*</span>
                </label>
                <select 
                    name="pertanyaan[${questionCounter}][tipe_jawaban]" 
                    onchange="updateOpsiSection(${questionCounter}, this.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm"
                    required>
                    <option value="">Pilih Tipe</option>
                    <option value="multiple_choice">Multiple Choice (Pilihan Ganda)</option>
                    <option value="checkbox">Checkbox (Pilihan Multiple)</option>
                    <option value="text">Text Pendek</option>
                    <option value="textarea">Text Panjang (Paragraph)</option>
                    <option value="rating">Rating (1-5 Bintang)</option>
                    <option value="yes_no">Ya / Tidak</option>
                </select>
            </div>

            <!-- Opsi Jawaban (Initially hidden) -->
            <div id="opsiContainer${questionCounter}" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Opsi Jawaban <span class="text-red-500">*</span>
                </label>
                <div id="opsiList${questionCounter}" class="space-y-2 mb-2">
                    <!-- Opsi will be added here -->
                </div>
                <button 
                    type="button" 
                    onclick="addOpsi(${questionCounter})" 
                    class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Tambah Opsi
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHtml);
}

// Remove question
function removeQuestion(id) {
    if (confirm('Hapus pertanyaan ini?')) {
        const question = document.querySelector(`[data-question="${id}"]`);
        if (question) {
            question.remove();
        }
        
        // Check if empty
        const container = document.getElementById('questionsContainer');
        const emptyState = document.getElementById('emptyState');
        if (container.children.length === 0 && emptyState) {
            emptyState.style.display = 'block';
        }
        
        // Renumber questions
        renumberQuestions();
    }
}

// Renumber questions after deletion
function renumberQuestions() {
    const questions = document.querySelectorAll('.question-card');
    questions.forEach((question, index) => {
        const heading = question.querySelector('h3');
        if (heading) {
            heading.textContent = `Pertanyaan #${index + 1}`;
        }
    });
}

// Update opsi section based on tipe jawaban
function updateOpsiSection(questionId, tipe) {
    const opsiContainer = document.getElementById(`opsiContainer${questionId}`);
    const opsiList = document.getElementById(`opsiList${questionId}`);
    
    // Show opsi for multiple choice and checkbox
    if (tipe === 'multiple_choice' || tipe === 'checkbox') {
        opsiContainer.classList.remove('hidden');
        // Add 3 default options
        if (opsiList.children.length === 0) {
            for (let i = 1; i <= 3; i++) {
                addOpsi(questionId, `Opsi ${i}`);
            }
        }
    } else if (tipe === 'yes_no') {
        opsiContainer.classList.remove('hidden');
        opsiList.innerHTML = '';
        addOpsi(questionId, 'Ya', true);
        addOpsi(questionId, 'Tidak', true);
    } else {
        opsiContainer.classList.add('hidden');
        opsiList.innerHTML = '';
    }
}

// Add opsi to question
function addOpsi(questionId, defaultValue = '', readonly = false) {
    const opsiList = document.getElementById(`opsiList${questionId}`);
    const opsiCount = opsiList.children.length + 1;
    
    const opsiHtml = `
        <div class="flex items-center gap-2">
            <input 
                type="text" 
                name="pertanyaan[${questionId}][opsi][]" 
                value="${defaultValue}"
                ${readonly ? 'readonly' : ''}
                class="opsi-input flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm" 
                placeholder="Opsi ${opsiCount}"
                required>
            ${!readonly ? `<button 
                type="button" 
                onclick="this.parentElement.remove()" 
                class="text-red-500 hover:text-red-700 transition-colors">
                <i class="fas fa-times-circle"></i>
            </button>` : ''}
        </div>
    `;
    
    opsiList.insertAdjacentHTML('beforeend', opsiHtml);
}

// Form validation before submit
document.getElementById('kuesionerForm').addEventListener('submit', function(e) {
    const container = document.getElementById('questionsContainer');
    
    if (container.children.length === 0) {
        e.preventDefault();
        alert('Tambahkan minimal 1 pertanyaan untuk kuesioner!');
        return false;
    }
    
    // Validate that all required fields are filled
    const questions = document.querySelectorAll('.question-card');
    let isValid = true;
    
    questions.forEach((question, index) => {
        const pertanyaan = question.querySelector('textarea[name*="[pertanyaan]"]').value;
        const tipe = question.querySelector('select[name*="[tipe_jawaban]"]').value;
        
        if (!pertanyaan || !tipe) {
            isValid = false;
        }
        
        // Validate opsi for multiple choice and checkbox
        if (tipe === 'multiple_choice' || tipe === 'checkbox' || tipe === 'yes_no') {
            const opsi = question.querySelectorAll('input[name*="[opsi]"]');
            if (opsi.length < 2) {
                isValid = false;
            }
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Pastikan semua pertanyaan terisi dengan lengkap!');
        return false;
    }
});

// Add first question on load
document.addEventListener('DOMContentLoaded', function() {
    // Auto add first question
    // addQuestion();
});
</script>
@endpush
@endsection
