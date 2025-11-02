@extends('layouts.landing')

@section('content')
    <!-- Hero Section -->
    <section id="beranda" class="hero-bg flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content - Text -->
            <div class="pl-0 lg:pl-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-[#6A00B8] leading-tight mb-6">
                    Selamat Datang di Portal Bimbingan Konseling Sekolah!
                </h1>
                <p class="text-lg text-[#7C3AED] mb-8 leading-relaxed max-w-lg">
                    Tempat kamu bisa curhat, cari solusi, dan dapet motivasi — semua dalam satu ruang yang aman dan nyaman.
                </p>
                <button
                    id="schedule-btn"
                    class="btn-primary text-lg px-8 py-4 hover:scale-105 transition duration-200"
                >
                    Buat Jadwal Konseling
                </button>
            </div>

            <!-- Right Content - Single Illustration -->
            <div class="flex justify-center lg:justify-end">
                <img
                    src="{{ asset('images/konseling.png') }}"
                    alt="Guru dan siswa sedang konseling"
                    class="w-full max-w-md lg:max-w-lg h-auto"
                    onerror="this.style.display='none'"
                >
                <!-- Fallback jika gambar tidak ada -->
                <div class="bg-gradient-to-br from-purple-200 to-blue-200 rounded-2xl w-full max-w-md lg:max-w-lg h-64 flex items-center justify-center text-gray-500 hidden">
                    Ilustrasi Konseling
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    @include('partials.features')

    <!-- About Section -->
    @include('landing.about')

    <!-- FAQ Section -->
    @include('landing.faq')
@endsection
