@extends('layouts.app')

@section('title', 'Hasil Tes Minat Bakat - Educounsel')

@push('styles')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #F5F5F5;
    }

    .result-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Header Card */
    .result-header {
        background: linear-gradient(135deg, #7000CC 0%, #5E00A8 100%);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 8px 24px rgba(112, 0, 204, 0.2);
    }

    .result-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .result-subtitle {
        font-size: 16px;
        font-weight: 400;
        opacity: 0.9;
    }

    /* Main Result Card */
    .dominant-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .category-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
    }

    .category-title {
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;
        color: #000000;
    }

    .category-subtitle {
        font-size: 16px;
        font-weight: 500;
        text-align: center;
        color: #7000CC;
        margin-bottom: 20px;
    }

    .category-description {
        font-size: 15px;
        line-height: 1.8;
        color: #555555;
        text-align: center;
        margin-bottom: 20px;
    }

    .category-fields {
        background: #F2E6FF;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .fields-title {
        font-size: 14px;
        font-weight: 700;
        color: #7000CC;
        margin-bottom: 10px;
        text-align: center;
    }

    .fields-list {
        font-size: 14px;
        color: #555555;
        line-height: 1.6;
        text-align: center;
    }

    /* Scores Chart */
    .scores-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .scores-title {
        font-size: 18px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 20px;
        text-align: center;
    }

    .score-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .score-label {
        width: 200px;
        font-size: 14px;
        font-weight: 500;
        color: #000000;
    }

    .score-bar-container {
        flex: 1;
        height: 30px;
        background: #E0E0E0;
        border-radius: 15px;
        overflow: hidden;
        margin: 0 15px;
    }

    .score-bar {
        height: 100%;
        transition: width 0.8s ease;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
        color: white;
        font-weight: 700;
        font-size: 13px;
    }

    .score-count {
        width: 40px;
        text-align: right;
        font-size: 14px;
        font-weight: 700;
        color: #000000;
    }

    /* Color schemes for each category */
    .color-A { background: linear-gradient(90deg, #FF6B9D 0%, #FF8FAB 100%); }
    .color-B { background: linear-gradient(90deg, #4A90E2 0%, #63A4E9 100%); }
    .color-C { background: linear-gradient(90deg, #F5A623 0%, #F7B955 100%); }
    .color-D { background: linear-gradient(90deg, #50E3C2 0%, #6EEBD4 100%); }
    .color-E { background: linear-gradient(90deg, #7000CC 0%, #8C52FF 100%); }

    .icon-bg-A { background: linear-gradient(135deg, #FF6B9D 0%, #FF8FAB 100%); }
    .icon-bg-B { background: linear-gradient(135deg, #4A90E2 0%, #63A4E9 100%); }
    .icon-bg-C { background: linear-gradient(135deg, #F5A623 0%, #F7B955 100%); }
    .icon-bg-D { background: linear-gradient(135deg, #50E3C2 0%, #6EEBD4 100%); }
    .icon-bg-E { background: linear-gradient(135deg, #7000CC 0%, #8C52FF 100%); }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-action {
        padding: 14px 32px;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: #7000CC;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #5E00A8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(112, 0, 204, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #7000CC;
        border: 2px solid #7000CC;
    }

    .btn-secondary:hover {
        background: #F2E6FF;
        transform: translateY(-2px);
    }

    /* Secondary Category */
    .secondary-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .secondary-title {
        font-size: 16px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 10px;
        text-align: center;
    }

    .secondary-desc {
        font-size: 14px;
        color: #555555;
        text-align: center;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .result-header {
            padding: 30px 20px;
        }

        .result-title {
            font-size: 24px;
        }

        .dominant-card {
            padding: 30px 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="result-container">
    <!-- Header -->
    <div class="result-header">
        <div class="result-title">🎉 Hasil Tes Minat Bakat</div>
        <div class="result-subtitle">Berikut adalah hasil analisis minat dan bakat kamu</div>
    </div>

    <!-- Dominant Category -->
    <div class="dominant-card" id="dominantCard">
        <div class="category-icon icon-bg-A" id="categoryIcon">🎨</div>
        <div class="category-title" id="categoryTitle">Seni & Kreativitas</div>
        <div class="category-subtitle" id="categorySubtitle">Kategori Dominan Kamu</div>
        <div class="category-description" id="categoryDescription">
            Kamu memiliki bakat dan minat tinggi di bidang seni dan ide kreatif.
            Kamu senang mengekspresikan diri dan menghasilkan karya yang unik.
        </div>
        <div class="category-fields">
            <div class="fields-title">🎓 Jurusan yang Cocok:</div>
            <div class="fields-list" id="categoryFields">
                DKV, Desain Produk, Fotografi, Perfilman, Sastra, Seni Musik
            </div>
        </div>
    </div>

    <!-- Secondary Category (if applicable) -->
    <div class="secondary-card" id="secondaryCard" style="display: none;">
        <div class="secondary-title" id="secondaryTitle">Kombinasi dengan Kepemimpinan</div>
        <div class="secondary-desc" id="secondaryDesc">
            Kamu juga menunjukkan minat di bidang manajemen dan kepemimpinan.
            Kombinasi ini cocok untuk: Manajemen Kreatif, Event Organizer, atau Creative Director.
        </div>
    </div>

    <!-- Scores Chart -->
    <div class="scores-card">
        <div class="scores-title">📊 Detail Skor Kamu</div>
        
        <div class="score-item">
            <div class="score-label">🎨 Seni & Kreativitas</div>
            <div class="score-bar-container">
                <div class="score-bar color-A" id="scoreBarA" style="width: 0%">0</div>
            </div>
            <div class="score-count" id="scoreCountA">0</div>
        </div>

        <div class="score-item">
            <div class="score-label">🧮 Logika & Sains</div>
            <div class="score-bar-container">
                <div class="score-bar color-B" id="scoreBarB" style="width: 0%">0</div>
            </div>
            <div class="score-count" id="scoreCountB">0</div>
        </div>

        <div class="score-item">
            <div class="score-label">💬 Sosial & Pendidikan</div>
            <div class="score-bar-container">
                <div class="score-bar color-C" id="scoreBarC" style="width: 0%">0</div>
            </div>
            <div class="score-count" id="scoreCountC">0</div>
        </div>

        <div class="score-item">
            <div class="score-label">💻 Teknologi & Teknik</div>
            <div class="score-bar-container">
                <div class="score-bar color-D" id="scoreBarD" style="width: 0%">0</div>
            </div>
            <div class="score-count" id="scoreCountD">0</div>
        </div>

        <div class="score-item">
            <div class="score-label">🧭 Manajemen & Kepemimpinan</div>
            <div class="score-bar-container">
                <div class="score-bar color-E" id="scoreBarE" style="width: 0%">0</div>
            </div>
            <div class="score-count" id="scoreCountE">0</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('student.questionnaire') }}" class="btn-action btn-secondary">
            Kembali ke Kuisioner
        </a>
        <button onclick="window.print()" class="btn-action btn-primary">
            📄 Cetak Hasil
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get result from sessionStorage
    const resultData = JSON.parse(sessionStorage.getItem('questionnaireResult'));
    
    if (!resultData) {
        // No result data, redirect back
        alert('Tidak ada data hasil. Silakan isi kuisioner terlebih dahulu.');
        window.location.href = "{{ route('student.questionnaire') }}";
        return;
    }

    // Category data
    const categories = {
        A: {
            name: 'Seni & Kreativitas',
            icon: '🎨',
            iconClass: 'icon-bg-A',
            description: 'Kamu memiliki bakat dan minat tinggi di bidang seni dan ide kreatif. Kamu senang mengekspresikan diri dan menghasilkan karya yang unik. Kamu imajinatif, ekspresif, dan cocok di bidang yang memerlukan kreativitas tinggi.',
            fields: 'DKV, Desain Produk, Fotografi, Perfilman, Sastra, Seni Musik, Animasi, Game Design'
        },
        B: {
            name: 'Logika & Sains',
            icon: '🧮',
            iconClass: 'icon-bg-B',
            description: 'Kamu memiliki kemampuan berpikir logis, analitis, dan sistematis. Kamu teliti, suka memecahkan masalah, dan senang mencari kebenaran ilmiah. Kamu cocok di bidang yang memerlukan analisis mendalam dan presisi.',
            fields: 'Matematika, Akuntansi, Sains, Ekonomi, Riset Data, Statistika, Aktuaria'
        },
        C: {
            name: 'Sosial & Pendidikan',
            icon: '💬',
            iconClass: 'icon-bg-C',
            description: 'Kamu memiliki empati tinggi, mudah memahami orang lain, dan senang berkomunikasi. Kamu peduli dan nyaman bekerja bersama orang lain. Kamu cocok di bidang yang berfokus pada pengembangan manusia dan masyarakat.',
            fields: 'Psikologi, Pendidikan, Hukum, Bimbingan Konseling, Hubungan Masyarakat, Sosiologi'
        },
        D: {
            name: 'Teknologi & Teknik',
            icon: '💻',
            iconClass: 'icon-bg-D',
            description: 'Kamu senang memecahkan masalah praktis dan bekerja dengan alat atau sistem. Kamu cepat belajar hal teknis dan suka mencoba hal baru secara langsung. Kamu praktis, inovatif, dan cocok di bidang teknologi.',
            fields: 'Teknik Mesin, Elektro, Informatika, IT, Teknologi Industri, Teknik Sipil, Robotika'
        },
        E: {
            name: 'Manajemen & Kepemimpinan',
            icon: '🧭',
            iconClass: 'icon-bg-E',
            description: 'Kamu memiliki jiwa pemimpin, mampu mengambil keputusan, dan suka mengorganisir orang lain. Kamu percaya diri, aktif, dan mampu memotivasi orang lain. Kamu cocok di bidang yang memerlukan koordinasi dan leadership.',
            fields: 'Manajemen, Bisnis, Kewirausahaan, Administrasi, Politik, Event Management'
        }
    };

    // Display dominant category
    const dominant = resultData.dominant;
    const dominantData = categories[dominant];
    
    document.getElementById('categoryIcon').textContent = dominantData.icon;
    document.getElementById('categoryIcon').className = 'category-icon ' + dominantData.iconClass;
    document.getElementById('categoryTitle').textContent = dominantData.name;
    document.getElementById('categoryDescription').textContent = dominantData.description;
    document.getElementById('categoryFields').textContent = dominantData.fields;

    // Display secondary category if significantly high
    const secondary = resultData.secondary;
    const secondaryCount = resultData.secondaryCount;
    
    if (secondaryCount >= 5 && secondary !== dominant) {
        const secondaryData = categories[secondary];
        document.getElementById('secondaryCard').style.display = 'block';
        document.getElementById('secondaryTitle').textContent = `Kombinasi dengan ${secondaryData.name}`;
        document.getElementById('secondaryDesc').textContent = 
            `Kamu juga menunjukkan minat di bidang ${secondaryData.name.toLowerCase()}. 
            Kombinasi ${dominantData.name} dan ${secondaryData.name} membuka peluang karir yang unik dan menarik.`;
    }

    // Display scores chart
    const scores = resultData.scores;
    const maxScore = 30;

    // Animate bars
    setTimeout(() => {
        Object.keys(scores).forEach(category => {
            const count = scores[category];
            const percentage = (count / maxScore) * 100;
            
            document.getElementById('scoreBar' + category).style.width = percentage + '%';
            document.getElementById('scoreBar' + category).textContent = count;
            document.getElementById('scoreCount' + category).textContent = count;
        });
    }, 300);

    // Clear sessionStorage after displaying (optional)
    // sessionStorage.removeItem('questionnaireResult');
    // sessionStorage.removeItem('questionnaireAnswers');
});
</script>
@endpush
