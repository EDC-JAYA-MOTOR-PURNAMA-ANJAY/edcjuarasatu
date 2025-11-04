@extends('layouts.app')

@section('title', 'Kerjakan Kuisioner - Educounsel')

@push('styles')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    /* Global Font */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #FFFFFF;
    }

    /* Progress Bar Container */
    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #E0E0E0;
        z-index: 1000;
    }

    .progress-bar {
        height: 100%;
        background-color: #7000CC;
        transition: width 0.4s ease;
        width: 3.33%; /* 1/30 pertanyaan */
    }

    /* Header Navigation */
    .header-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 32px;
        margin-top: 3px;
    }

    .btn-back {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #A0A0A0;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 400;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .btn-back:hover {
        color: #7000CC;
    }

    .btn-back svg {
        width: 20px;
        height: 20px;
    }

    .time-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .time-label {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 400;
        color: #A0A0A0;
    }

    .time-badge {
        background-color: #7000CC;
        color: #FFFFFF;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Main Content */
    .questionnaire-content {
        max-width: 600px;
        margin: 40px auto 60px;
        padding: 0 32px;
    }

    /* Question Section */
    .question-number {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: #7000CC;
        margin-bottom: 16px;
    }

    .question-text {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 40px;
        line-height: 1.4;
    }

    /* Options Container */
    .options-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 40px;
    }

    /* Option Card */
    .option-card {
        background-color: #FFFFFF;
        border: 2px solid #E0E0E0;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .option-card:hover {
        background-color: #F9F9F9;
        border-color: #C5C5C5;
    }

    .option-card.selected {
        background-color: #F2E6FF;
        border-color: #7000CC;
    }

    .option-content {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .option-label {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 500;
        color: #000000;
        min-width: 24px;
    }

    .option-text {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 400;
        color: #000000;
        line-height: 1.5;
    }

    /* Radio Button */
    .radio-button {
        width: 20px;
        height: 20px;
        border: 2px solid #BDBDBD;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
    }

    .option-card.selected .radio-button {
        border-color: #7000CC;
        background-color: #7000CC;
    }

    .radio-button-inner {
        width: 8px;
        height: 8px;
        background-color: #FFFFFF;
        border-radius: 50%;
        opacity: 0;
        transform: scale(0);
        transition: all 0.2s ease;
    }

    .option-card.selected .radio-button-inner {
        opacity: 1;
        transform: scale(1);
    }

    /* Navigation Button */
    .btn-next-container {
        display: flex;
        justify-content: center;
        padding-bottom: 40px;
    }

    .btn-next {
        background-color: #7000CC;
        color: #FFFFFF;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 500;
        padding: 12px 32px;
        border-radius: 24px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-next:hover {
        background-color: #5E00A8;
        transform: scale(1.03);
    }

    .btn-next:disabled {
        background-color: #BDBDBD;
        cursor: not-allowed;
        transform: scale(1);
    }

    .btn-next svg {
        width: 20px;
        height: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-nav {
            padding: 16px 20px;
        }

        .questionnaire-content {
            padding: 0 20px;
            margin: 30px auto 40px;
        }

        .question-text {
            font-size: 20px;
        }

        .option-card {
            padding: 14px 16px;
        }

        .option-text {
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
<!-- Progress Bar -->
<div class="progress-container">
    <div class="progress-bar" id="progressBar"></div>
</div>

<!-- Header Navigation -->
<div class="header-nav">
    <!-- Back Button -->
    <a href="{{ route('student.questionnaire') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Kembali</span>
    </a>

    <!-- Time Info -->
    <div class="time-info">
        <span class="time-label">Waktu Tersisa</span>
        <div class="time-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
            </svg>
            <span id="timerDisplay">20:00</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="questionnaire-content">
    <!-- Question Number -->
    <div class="question-number" id="questionNumber">Pertanyaan 1/30</div>

    <!-- Question Text -->
    <h2 class="question-text" id="questionText">Kegiatan apa yang paling kamu sukai?</h2>

    <!-- Options -->
    <div class="options-container" id="optionsContainer">
        <div class="option-card" data-value="A">
            <div class="option-content">
                <span class="option-label">A.</span>
                <span class="option-text">Menggambar atau desain</span>
            </div>
            <div class="radio-button">
                <div class="radio-button-inner"></div>
            </div>
        </div>

        <div class="option-card" data-value="B">
            <div class="option-content">
                <span class="option-label">B.</span>
                <span class="option-text">Membaca buku dan menulis</span>
            </div>
            <div class="radio-button">
                <div class="radio-button-inner"></div>
            </div>
        </div>

        <div class="option-card" data-value="C">
            <div class="option-content">
                <span class="option-label">C.</span>
                <span class="option-text">Bermain musik atau menyanyi</span>
            </div>
            <div class="radio-button">
                <div class="radio-button-inner"></div>
            </div>
        </div>

        <div class="option-card" data-value="D">
            <div class="option-content">
                <span class="option-label">D.</span>
                <span class="option-text">Bermain olahraga atau aktivitas fisik</span>
            </div>
            <div class="radio-button">
                <div class="radio-button-inner"></div>
            </div>
        </div>

        <div class="option-card" data-value="E">
            <div class="option-content">
                <span class="option-label">E.</span>
                <span class="option-text">Memimpin tim atau organisasi</span>
            </div>
            <div class="radio-button">
                <div class="radio-button-inner"></div>
            </div>
        </div>
    </div>

    <!-- Next Button -->
    <div class="btn-next-container">
        <button class="btn-next" id="btnNext" disabled>
            <span>Selanjutnya</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // State Management
    let currentQuestion = 1;
    const totalQuestions = 30;
    let selectedAnswer = null;
    let timeRemaining = 20 * 60; // 20 minutes in seconds
    let timerInterval;

    // Elements
    const progressBar = document.getElementById('progressBar');
    const questionNumber = document.getElementById('questionNumber');
    const questionText = document.getElementById('questionText');
    const optionsContainer = document.getElementById('optionsContainer');
    const btnNext = document.getElementById('btnNext');
    const timerDisplay = document.getElementById('timerDisplay');

    // Answers storage
    let answers = {};
    
    // 30 Soal Minat Bakat
    const questions = [
        { id: 1, text: "Kegiatan apa yang paling kamu sukai?", options: [
            { label: "A", text: "Menggambar atau desain" },
            { label: "B", text: "Menghitung atau analisis data" },
            { label: "C", text: "Membantu orang lain" },
            { label: "D", text: "Mengoperasikan teknologi" },
            { label: "E", text: "Memimpin tim atau organisasi" }
        ]},
        { id: 2, text: "Pelajaran favoritmu di sekolah?", options: [
            { label: "A", text: "Seni Budaya" },
            { label: "B", text: "Matematika / Fisika" },
            { label: "C", text: "Sosiologi / BK" },
            { label: "D", text: "Informatika / TIK" },
            { label: "E", text: "PPKn / Bahasa Indonesia" }
        ]},
        { id: 3, text: "Kamu paling nyaman bekerja…", options: [
            { label: "A", text: "Dengan hal kreatif" },
            { label: "B", text: "Dengan angka" },
            { label: "C", text: "Dengan orang lain" },
            { label: "D", text: "Dengan teknologi" },
            { label: "E", text: "Dalam sebuah organisasi" }
        ]},
        { id: 4, text: "Dalam kelompok, peran yang paling kamu suka:", options: [
            { label: "A", text: "Pengembang ide" },
            { label: "B", text: "Pengolah data" },
            { label: "C", text: "Konselor / penyemangat" },
            { label: "D", text: "Teknisi / pelaksana" },
            { label: "E", text: "Koordinator" }
        ]},
        { id: 5, text: "Kamu lebih memilih kegiatan:", options: [
            { label: "A", text: "Mendesain sesuatu" },
            { label: "B", text: "Menyelesaikan soal logika" },
            { label: "C", text: "Menjadi relawan sosial" },
            { label: "D", text: "Mencoba software baru" },
            { label: "E", text: "Menjadi ketua panitia" }
        ]},
        { id: 6, text: "Kamu merasa paling berbakat dalam:", options: [
            { label: "A", text: "Seni visual atau audio" },
            { label: "B", text: "Logika dan analisis" },
            { label: "C", text: "Komunikasi dan empati" },
            { label: "D", text: "Teknologi dan otomasi" },
            { label: "E", text: "Kepemimpinan" }
        ]},
        { id: 7, text: "Kamu paling tidak suka:", options: [
            { label: "A", text: "Rutinitas" },
            { label: "B", text: "Ketidakjelasan data" },
            { label: "C", text: "Konflik antar orang" },
            { label: "D", text: "Kerja manual" },
            { label: "E", text: "Diam tanpa aktivitas" }
        ]},
        { id: 8, text: "Kebiasaanmu saat belajar:", options: [
            { label: "A", text: "Membuat mindmap atau poster" },
            { label: "B", text: "Menyusun ulang data" },
            { label: "C", text: "Diskusi dengan teman" },
            { label: "D", text: "Nonton video edukasi teknologi" },
            { label: "E", text: "Belajar sambil mengajar teman" }
        ]},
        { id: 9, text: "Kamu ingin masa depan di bidang:", options: [
            { label: "A", text: "Seni/desain/media" },
            { label: "B", text: "Ilmu sains/matematika" },
            { label: "C", text: "Pendidikan/psikologi" },
            { label: "D", text: "Teknik/IT" },
            { label: "E", text: "Bisnis/organisasi" }
        ]},
        { id: 10, text: "Hobimu:", options: [
            { label: "A", text: "Menggambar, edit foto/video" },
            { label: "B", text: "Puzzle atau game strategi" },
            { label: "C", text: "Menjadi pendengar curhat" },
            { label: "D", text: "Coding/teknologi" },
            { label: "E", text: "Event organizing" }
        ]},
        { id: 11, text: "Kamu merasa puas ketika…", options: [
            { label: "A", text: "Menciptakan sesuatu yang unik" },
            { label: "B", text: "Memecahkan masalah sulit" },
            { label: "C", text: "Membantu seseorang merasa lebih baik" },
            { label: "D", text: "Bisa memperbaiki sesuatu" },
            { label: "E", text: "Proyek berjalan sukses" }
        ]},
        { id: 12, text: "Kamu cenderung…", options: [
            { label: "A", text: "Imajinatif" },
            { label: "B", text: "Analitis" },
            { label: "C", text: "Peduli" },
            { label: "D", text: "Praktis" },
            { label: "E", text: "Tegas" }
        ]},
        { id: 13, text: "Kamu paling cocok bekerja sebagai…", options: [
            { label: "A", text: "Desainer / Animator" },
            { label: "B", text: "Analis / Akuntan" },
            { label: "C", text: "Konselor / Guru" },
            { label: "D", text: "Teknisi / Programmer" },
            { label: "E", text: "Manajer / Leader" }
        ]},
        { id: 14, text: "Saat ada masalah, kamu…", options: [
            { label: "A", text: "Cari inspirasi kreatif" },
            { label: "B", text: "Analisis dulu" },
            { label: "C", text: "Diskusi dengan teman" },
            { label: "D", text: "Cari solusi praktis" },
            { label: "E", text: "Koordinasi orang lain" }
        ]},
        { id: 15, text: "Kamu lebih suka tugas…", options: [
            { label: "A", text: "Poster / presentasi" },
            { label: "B", text: "Hitung-hitungan" },
            { label: "C", text: "Kelompok sosial" },
            { label: "D", text: "Teknologi" },
            { label: "E", text: "Organisasi" }
        ]},
        { id: 16, text: "Kamu sering dipuji karena…", options: [
            { label: "A", text: "Kreatif" },
            { label: "B", text: "Pintar logika" },
            { label: "C", text: "Suka membantu" },
            { label: "D", text: "Tech-savvy" },
            { label: "E", text: "Pemimpin alami" }
        ]},
        { id: 17, text: "Kamu paling betah di…", options: [
            { label: "A", text: "Studio kreatif" },
            { label: "B", text: "Lab atau ruang data" },
            { label: "C", text: "Ruang BK atau sosial" },
            { label: "D", text: "Bengkel / lab komputer" },
            { label: "E", text: "Ruang OSIS / organisasi" }
        ]},
        { id: 18, text: "Kalau ikut lomba, kamu pilih…", options: [
            { label: "A", text: "Poster / desain" },
            { label: "B", text: "Karya ilmiah" },
            { label: "C", text: "Debat / pidato" },
            { label: "D", text: "Inovasi teknologi" },
            { label: "E", text: "Lomba organisasi / kepemimpinan" }
        ]},
        { id: 19, text: "Kamu merasa kuat di bidang…", options: [
            { label: "A", text: "Seni" },
            { label: "B", text: "Analisis" },
            { label: "C", text: "Sosial" },
            { label: "D", text: "Teknik" },
            { label: "E", text: "Bisnis" }
        ]},
        { id: 20, text: "Kepribadianmu lebih dekat ke…", options: [
            { label: "A", text: "Kreator" },
            { label: "B", text: "Pemecah masalah" },
            { label: "C", text: "Penolong" },
            { label: "D", text: "Teknisi" },
            { label: "E", text: "Pemimpin" }
        ]},
        { id: 21, text: "Jika diberi proyek besar, kamu akan…", options: [
            { label: "A", text: "Membuat konsep kreatifnya" },
            { label: "B", text: "Menyusun data & perencanaannya" },
            { label: "C", text: "Mengatur komunikasi dalam tim" },
            { label: "D", text: "Mengurus teknis & sistemnya" },
            { label: "E", text: "Memimpin pelaksanaannya" }
        ]},
        { id: 22, text: "Kamu cepat mengerti saat belajar melalui…", options: [
            { label: "A", text: "Gambar / visual" },
            { label: "B", text: "Rumus / angka" },
            { label: "C", text: "Cerita / penjelasan orang lain" },
            { label: "D", text: "Praktik langsung" },
            { label: "E", text: "Diskusi kelompok" }
        ]},
        { id: 23, text: "Kamu ingin dikenal sebagai orang yang…", options: [
            { label: "A", text: "Kreatif" },
            { label: "B", text: "Cerdas" },
            { label: "C", text: "Peduli" },
            { label: "D", text: "Teknis" },
            { label: "E", text: "Berpengaruh" }
        ]},
        { id: 24, text: "Kamu paling nyaman bekerja…", options: [
            { label: "A", text: "Sendiri tetapi bebas berkreasi" },
            { label: "B", text: "Dengan data yang jelas" },
            { label: "C", text: "Bersama orang lain" },
            { label: "D", text: "Dengan alat dan teknologi" },
            { label: "E", text: "Dalam tim organisasi" }
        ]},
        { id: 25, text: "Jika mengikuti kegiatan sekolah, kamu memilih…", options: [
            { label: "A", text: "Ekstrakulikuler seni" },
            { label: "B", text: "Klub olimpiade matematika/sains" },
            { label: "C", text: "PIK-R/PMR/psikologi" },
            { label: "D", text: "IT Club/Teknik" },
            { label: "E", text: "OSIS/mpk" }
        ]},
        { id: 26, text: "Kalau melihat orang kesulitan, kamu…", options: [
            { label: "A", text: "Cari ide agar dia merasa lebih baik" },
            { label: "B", text: "Analisis masalahnya" },
            { label: "C", text: "Ajak bicara & bantu" },
            { label: "D", text: "Cari solusi teknis" },
            { label: "E", text: "Ajak bekerja sama" }
        ]},
        { id: 27, text: "Kamu paling betah membaca tentang…", options: [
            { label: "A", text: "Seni & desain" },
            { label: "B", text: "Logika & sains" },
            { label: "C", text: "Psikologi manusia" },
            { label: "D", text: "Teknologi terbaru" },
            { label: "E", text: "Bisnis & kepemimpinan" }
        ]},
        { id: 28, text: "Kamu cepat bosan kalau…", options: [
            { label: "A", text: "Tidak bisa berkreasi" },
            { label: "B", text: "Tidak ada tantangan berpikir" },
            { label: "C", text: "Tidak ada teman bicara" },
            { label: "D", text: "Tidak ada teknologi" },
            { label: "E", text: "Tidak ada tujuan besar" }
        ]},
        { id: 29, text: "Kamu suka tugas yang…", options: [
            { label: "A", text: "Mengembangkan kreativitas" },
            { label: "B", text: "Melibatkan angka" },
            { label: "C", text: "Berkaitan dengan manusia" },
            { label: "D", text: "Menggunakan alat/mesin" },
            { label: "E", text: "Mengatur strategi" }
        ]},
        { id: 30, text: "Jika boleh memilih jurusan, kamu condong ke…", options: [
            { label: "A", text: "Desain / DKV / Seni" },
            { label: "B", text: "Matematika / Akuntansi / Sains" },
            { label: "C", text: "Psikologi / Pendidikan / Sosial" },
            { label: "D", text: "Teknik / Informatika" },
            { label: "E", text: "Bisnis / Manajemen" }
        ]}
    ];

    // Initialize Timer
    function startTimer() {
        timerInterval = setInterval(() => {
            timeRemaining--;
            
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                handleTimeUp();
                return;
            }

            updateTimerDisplay();
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Warning when < 5 minutes
        if (timeRemaining < 300) {
            timerDisplay.parentElement.style.backgroundColor = '#E53935';
        }
    }

    function handleTimeUp() {
        alert('Waktu habis! Kuisioner akan diserahkan otomatis.');
        submitQuestionnaire();
    }

    // Update Progress Bar
    function updateProgress() {
        const progress = (currentQuestion / totalQuestions) * 100;
        progressBar.style.width = progress + '%';
    }

    // Load Question
    function loadQuestion(questionIndex) {
        const question = questions[questionIndex - 1] || questions[0];
        
        questionNumber.textContent = `Pertanyaan ${currentQuestion}/${totalQuestions}`;
        questionText.textContent = question.text;
        
        // Clear and rebuild options
        optionsContainer.innerHTML = '';
        question.options.forEach(option => {
            const optionCard = document.createElement('div');
            optionCard.className = 'option-card';
            optionCard.dataset.value = option.label;
            
            optionCard.innerHTML = `
                <div class="option-content">
                    <span class="option-label">${option.label}.</span>
                    <span class="option-text">${option.text}</span>
                </div>
                <div class="radio-button">
                    <div class="radio-button-inner"></div>
                </div>
            `;
            
            optionCard.addEventListener('click', () => selectOption(option.label));
            optionsContainer.appendChild(optionCard);
        });

        // Reset selection
        selectedAnswer = null;
        btnNext.disabled = true;
        updateProgress();
    }

    // Handle Option Selection
    function selectOption(value) {
        selectedAnswer = value;
        
        // Remove previous selection
        document.querySelectorAll('.option-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selection to clicked card
        const selectedCard = document.querySelector(`.option-card[data-value="${value}"]`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
        
        // Enable next button
        btnNext.disabled = false;
    }

    // Handle Next Button
    btnNext.addEventListener('click', function() {
        if (!selectedAnswer) return;
        
        // Save answer
        answers[currentQuestion] = selectedAnswer;
        console.log(`Question ${currentQuestion}: Answer ${selectedAnswer}`);
        
        // Move to next question
        if (currentQuestion < totalQuestions) {
            currentQuestion++;
            loadQuestion(currentQuestion);
        } else {
            // Last question - submit
            submitQuestionnaire();
        }
    });

    // Calculate Scoring
    function calculateScores() {
        const scores = { A: 0, B: 0, C: 0, D: 0, E: 0 };
        
        // Count each answer
        Object.values(answers).forEach(answer => {
            if (scores.hasOwnProperty(answer)) {
                scores[answer]++;
            }
        });
        
        // Sort by count (descending)
        const sorted = Object.entries(scores).sort((a, b) => b[1] - a[1]);
        
        return {
            scores: scores,
            dominant: sorted[0][0],
            dominantCount: sorted[0][1],
            secondary: sorted[1][0],
            secondaryCount: sorted[1][1],
            sortedScores: sorted
        };
    }

    // Submit Questionnaire
    function submitQuestionnaire() {
        clearInterval(timerInterval);
        
        // Calculate result
        const result = calculateScores();
        
        // Save to sessionStorage for result page
        sessionStorage.setItem('questionnaireResult', JSON.stringify(result));
        sessionStorage.setItem('questionnaireAnswers', JSON.stringify(answers));
        
        // Voice notification
        if (window.voiceHelper) {
            window.voiceHelper.speakQuestionnaireComplete();
        }

        // Redirect to result page
        setTimeout(() => {
            window.location.href = "{{ route('student.questionnaire') }}/result";
        }, 2000); // Delay untuk voice selesai
    }

    // Handle Browser Back/Refresh
    window.addEventListener('beforeunload', function(e) {
        if (currentQuestion > 1 || selectedAnswer) {
            e.preventDefault();
            e.returnValue = '';
            return 'Yakin ingin keluar? Progress akan hilang.';
        }
    });

    // Initialize
    loadQuestion(1);
    startTimer();
    updateProgress();
});
</script>
@endpush
