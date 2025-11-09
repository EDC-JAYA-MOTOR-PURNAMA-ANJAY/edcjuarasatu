@extends('layouts.app')

@section('title', 'Kuisioner - Educounsel')

@push('styles')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    /* Apply Roboto globally */
    body {
        font-family: 'Roboto', system-ui, -apple-system, sans-serif;
    }

    /* Card Hover Effect */
    .questionnaire-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 16px;
        background-color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px 24px;
    }

    .questionnaire-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08) !important;
    }

    /* Button Container with Shadow */
    .btn-container {
        position: relative;
        display: inline-block;
    }

    .btn-container::before {
        content: '';
        position: absolute;
        top: 8px;
        left: 0;
        right: 0;
        bottom: -8px;
        background: linear-gradient(135deg, rgba(112, 0, 204, 0.4), rgba(94, 0, 168, 0.3));
        border-radius: 50px;
        z-index: 0;
        transition: all 0.4s ease;
        filter: blur(8px);
    }

    .btn-container:hover::before {
        opacity: 0;
        transform: translateY(4px);
    }

    /* Button Style */
    .btn-kerjakan {
        transition: all 0.4s ease;
        background-color: #7000CC;
        color: white;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 50px;
        font-family: 'Roboto', sans-serif;
        border: none;
        cursor: pointer;
        position: relative;
        z-index: 1;
        transform: translateY(0);
    }

    .btn-kerjakan:hover {
        background-color: #5E00A8;
        transform: translateY(2px);
    }

    /* Badge Style */
    .badge-soal {
        background-color: #F2E6FF;
        color: #7000CC;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        display: inline-block;
        font-family: 'Roboto', sans-serif;
    }

    /* Back Button Hover */
    .back-button {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .back-button:hover {
        transform: translateX(-3px);
        color: #000 !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-white pt-16 font-['Roboto']">
    <!-- Header / Banner -->
    <div class="px-6 py-6">
        <div class="bg-[#E9D7FF] rounded-[20px] p-6 w-[1044px] h-[144px] flex flex-col md:flex-row items-center justify-between gap-4 relative">
            <!-- Back Button -->
            <a href="{{ route('student.dashboard') }}" class="absolute top-6 left-6 back-button text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Title Section -->
            <div class="flex flex-col ml-12 md:ml-0">
                <h1 class="text-2xl font-bold text-black">Kuisioner</h1>
                <p class="text-sm text-[#555555] mt-1">Periksa dan kerjakan kuisioner yang tersedia.</p>
            </div>

            <!-- Chat Illustration -->
            <div class="w-[120px] h-[120px] flex-shrink-0">
                <img src="{{ asset('images/chat_ilustrasi.svg') }}" alt="Ilustrasi Chat" class="w-full h-full object-contain" onerror="this.style.display='none'">
            </div>
        </div>
    </div>

    <!-- Konten Kuisioner -->
    <div class="px-6 pb-8 flex justify-center mt-8">
        <div class="w-full max-w-[1200px]">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
            @endif

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($kuesionerList as $kuesioner)
                    <!-- Card Kuesioner -->
                    <div class="questionnaire-card" data-id="{{ $kuesioner->id }}">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-bold text-black flex-1">{{ $kuesioner->judul }}</h3>
                            @if($kuesioner->jenisKuesioner)
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium ml-2">
                                {{ $kuesioner->jenisKuesioner->nama_kuesioner }}
                            </span>
                            @endif
                        </div>
                        
                        <p class="text-sm text-[#555555] leading-relaxed mb-6">
                            {{ Str::limit($kuesioner->deskripsi ?? 'Silakan kerjakan kuesioner ini untuk membantu kami memahami kebutuhan Anda.', 120) }}
                        </p>
                        
                        <!-- Bottom Section -->
                        <div class="flex items-center justify-between">
                            <span class="badge-soal">{{ $kuesioner->pertanyaan_count ?? 0 }} Soal</span>
                            <div class="btn-container">
                                <button class="btn-kerjakan">
                                    Kerjakan
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-2 text-center py-12">
                        <div class="flex flex-col items-center gap-4">
                            <i class="fas fa-clipboard-question text-6xl text-gray-300"></i>
                            <div>
                                <p class="text-lg font-semibold text-gray-700">Belum Ada Kuesioner</p>
                                <p class="text-sm text-gray-500 mt-1">Saat ini belum ada kuesioner yang tersedia.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle "Kerjakan" button clicks
    const buttons = document.querySelectorAll('.btn-kerjakan');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.questionnaire-card');
            const questionnaireId = card.dataset.id;
            
            // Navigate to questionnaire detail/show page
            window.location.href = '{{ route("student.questionnaire") }}/' + questionnaireId;
        });
    });

    // Make entire card clickable (optional)
    const cards = document.querySelectorAll('.questionnaire-card');
    
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking the button directly
            if (!e.target.classList.contains('btn-kerjakan') && !e.target.closest('.btn-container')) {
                const button = this.querySelector('.btn-kerjakan');
                button.click();
            }
        });
    });
});
</script>
@endpush