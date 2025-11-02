<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduCounsel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .input-field:focus {
            outline: none;
            border-color: #3949AB;
            box-shadow: 0 0 0 3px rgba(57, 73, 171, 0.1);
        }
        .btn-login:hover {
            background-color: #303F9F;
        }
        .btn-social:hover, .btn-register:hover {
            background-color: #E8EAF6;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="login-container flex h-screen w-full">
        <div class="left-side w-3/5 bg-[#BBCBE3] flex flex-col items-center justify-center relative overflow-hidden">
            <div class="logo-container absolute top-10 left-14 z-30">
                @if(file_exists(public_path('images/EDClogo.svg')))
                    <img src="{{ asset('images/EDClogo.svg') }}" alt="EduCounsel Logo" class="h-10 w-auto">
                @else
                    <div class="h-10 w-32 bg-[#3949AB] rounded flex items-center justify-center">
                        <span class="text-white font-bold text-lg">EDUCOUNSEL</span>
                    </div>
                @endif
            </div>

            <div class="circle-background absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                @if(file_exists(public_path('images/icon/Back.png')))
                    <img src="{{ asset('images/icon/Back.png') }}" alt="Decorative Circle"
                         class="w-[221px] h-[221px] object-cover rounded-full">
                @else
                    <div class="w-[221px] h-[211px] bg-[#3F51B5] rounded-full opacity-80"></div>
                @endif
            </div>

            <div class="illustration-container flex flex-col items-center justify-center text-center w-full z-20 px-14">
                <div class="mb-8 relative z-20">
                    @if(file_exists(public_path('images/icon/ilustrasi.png')))
                        <img src="{{ asset('images/icon/ilustrasi.png') }}" alt="Counseling Illustration"
                             class="w-full max-w-md md:max-w-lg lg:max-w-xl h-auto filter drop-shadow-lg">
                    @else
                        <div class="bg-white rounded-2xl p-8 shadow-lg max-w-md">
                            <svg width="300" height="200" viewBox="0 0 300 200" class="max-w-full">
                                <rect x="30" y="140" width="240" height="12" fill="#8B4513" rx="4"/>
                                <circle cx="100" cy="100" r="15" fill="#FFD700"/>
                                <rect x="88" y="115" width="24" height="40" fill="#3949AB" rx="4"/>
                                <rect x="75" y="125" width="12" height="20" fill="#303F9F" rx="2"/>
                                <rect x="113" y="125" width="12" height="20" fill="#303F9F" rx="2"/>
                                <circle cx="180" cy="100" r="14" fill="#FFD700"/>
                                <rect x="168" y="114" width="24" height="36" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="1.5" rx="4"/>
                                <rect x="155" y="124" width="12" height="18" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="1.5" rx="2"/>
                                <rect x="193" y="124" width="12" height="18" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="1.5" rx="2"/>
                                <path d="M60 80 Q50 65 65 55 Q80 65 70 80 Z" fill="#FFFFFF" stroke="#E5E7EB" stroke-width="0.8"/>
                                <circle cx="62" cy="70" r="2.5" fill="#3949AB"/>
                                <path d="M220 80 Q210 65 225 55 Q240 65 230 80 Z" fill="#FFFFFF" stroke="#E5E7EB" stroke-width="0.8"/>
                                <circle cx="222" cy="70" r="2.5" fill="#FF6B35"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="welcome-text text-white text-center z-20">
                    <h2 class="welcome-title text-2xl md:text-3xl font-bold mb-3 text-white">
                        Welcome aboard my friend
                    </h2>
                    <p class="welcome-subtitle text-base text-gray-200 font-normal">
                        just a couple of clicks and we start
                    </p>
                </div>
            </div>
        </div>

        <div class="right-side w-2/5 bg-white flex flex-col items-center justify-center px-12">

            <div class="w-full max-w-sm">
                <h2 class="form-title text-2xl font-bold mb-8 text-gray-800 text-center">
                    Welcome
                </h2>

                <div id="throttleWarning" class="mb-4 p-3 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 rounded-lg shadow-md hidden animate-fade-in">
                    <div class="flex items-start gap-3">
                        <div class="bg-red-600 rounded-full p-1.5 animate-pulse-scale flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-red-800 mb-1">🔒 Akun Diblokir Sementara</h5>
                            <p class="text-xs text-red-700 leading-relaxed mb-2">
                                Terlalu banyak percobaan login gagal. Tunggu <span id="countdownTimer" class="font-bold text-red-900 text-sm">30</span> detik.
                            </p>
                            <p class="text-xs text-red-600">
                                ⚠️ Fitur keamanan untuk melindungi akun Anda.
                            </p>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 rounded-lg shadow-lg" id="errorMessage">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h5 class="font-bold text-red-800 mb-1">Login Gagal</h5>
                                <p class="text-red-700 font-medium text-sm">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 p-4 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-lg shadow-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h5 class="font-bold text-green-800 mb-1">Berhasil</h5>
                                <p class="text-green-700 font-medium text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="login-form w-full" method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="w-full mb-4">
                        <div class="input-group relative">
                            <svg class="input-icon absolute left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            <input
                                type="email"
                                name="email"
                                placeholder="Email"
                                class="input-field w-full h-12 border border-gray-300 rounded-lg px-12 text-gray-700 bg-white transition-all duration-300"
                                required
                                value="{{ old('email') }}"
                            >
                        </div>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full mb-2">
                        <div class="input-group relative">
                            <svg class="input-icon absolute left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Password"
                                class="input-field w-full h-12 border border-gray-300 rounded-lg px-12 text-gray-700 bg-white transition-all duration-300"
                                required
                            >
                            <svg class="eye-icon absolute right-4 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 cursor-pointer" id="togglePassword" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <a href="" class="forgot-password text-[#7E57C2] text-sm no-underline font-normal hover:underline">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login w-full h-12 bg-[#3949AB] text-white border-none rounded-lg text-base font-medium cursor-pointer transition-all duration-300 mb-6 hover:bg-[#303F9F]">
                        Log in
                    </button>
                </form>

                <div class="separator flex items-center w-full my-6 text-gray-500 text-sm">
                    <hr class="flex-1 border-t border-gray-300">
                    <span class="px-3">Or</span>
                    <hr class="flex-1 border-t border-gray-300">
                </div>

                <a href="" class="btn-social w-full h-12 border border-[#3949AB] text-gray-700 bg-white rounded-lg text-base font-normal cursor-pointer transition-all duration-300 flex items-center justify-center gap-3 mb-6 no-underline hover:bg-[#E8EAF6]">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continue with Google
                </a>

                <div class="text-center">
                    <p class="no-account text-gray-600 text-base mb-4 font-normal">
                        Have no account yet?
                    </p>
                    <a href="" class="btn-register w-full h-12 border border-[#3949AB] text-[#3949AB] bg-white rounded-lg text-base font-normal cursor-pointer transition-all duration-300 flex items-center justify-center no-underline hover:bg-[#E8EAF6]">
                        Registration
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let voicesLoaded = false;
            let bestVoice = null;

            function loadVoices() {
                const voices = window.speechSynthesis.getVoices();
                if (voices.length > 0 && !voicesLoaded) {
                    console.log('🔍 FORCING FEMALE Indonesian voice...');
                    console.log('📋 All available voices:', voices.map(v => `${v.name} (${v.lang})`).join(', '));
                    
                    // SUPER AGGRESSIVE FEMALE SEARCH - Check ALL voices
                    const femaleKeywords = ['gadis', 'damayanti', 'female', 'perempuan', 'wanita', 'woman', 'girl', 'siti', 'dewi'];
                    
                    // Priority 1: Exact id-ID with female keywords
                    for (const keyword of femaleKeywords) {
                        const found = voices.find(v => v.lang === 'id-ID' && v.name.toLowerCase().includes(keyword));
                        if (found) {
                            bestVoice = found;
                            console.log('🎯 FOUND FEMALE (id-ID):', found.name);
                            break;
                        }
                    }
                    
                    // Priority 2: Any id-* with female keywords
                    if (!bestVoice) {
                        for (const keyword of femaleKeywords) {
                            const found = voices.find(v => v.lang.startsWith('id') && v.name.toLowerCase().includes(keyword));
                            if (found) {
                                bestVoice = found;
                                console.log('🎯 FOUND FEMALE (id-*):', found.name);
                                break;
                            }
                        }
                    }
                    
                    // Priority 3: Google Indonesian (usually good quality)
                    if (!bestVoice) {
                        bestVoice = voices.find(v => v.name.toLowerCase().includes('google') && v.lang.startsWith('id'));
                        if (bestVoice) console.log('🎯 FOUND Google:', bestVoice.name);
                    }
                    
                    // Priority 4: Remote Indonesian (better quality)
                    if (!bestVoice) {
                        bestVoice = voices.find(v => v.lang === 'id-ID' && !v.localService);
                        if (bestVoice) console.log('🎯 FOUND Remote:', bestVoice.name);
                    }
                    
                    // Priority 5: Any Indonesian
                    if (!bestVoice) {
                        bestVoice = voices.find(v => v.lang === 'id-ID' || v.lang.startsWith('id'));
                        if (bestVoice) console.log('⚠️ FALLBACK Indonesian:', bestVoice.name);
                    }
                    
                    // Priority 6: Last resort
                    if (!bestVoice) {
                        bestVoice = voices[0];
                        console.log('⚠️ LAST RESORT:', bestVoice?.name);
                    }
                    
                    voicesLoaded = true;
                    const isFemale = bestVoice?.name.toLowerCase().match(/(female|gadis|damayanti|perempuan|wanita|woman|girl|siti|dewi)/);
                    console.log('\n✅ FINAL VOICE SELECTED:', bestVoice?.name || 'Default');
                    console.log('   📍 Language:', bestVoice?.lang);
                    console.log('   🎭 Gender:', isFemale ? '👩 FEMALE ✅' : '⚠️ NOT CONFIRMED - May be male');
                    console.log('   🌐 Local Service:', bestVoice?.localService);
                }
            }

            function speak(text, rate = 0.85, pitch = 1.0, volume = 1.0) {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    
                    if (!voicesLoaded) {
                        loadVoices();
                    }
                    
                    setTimeout(() => {
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'id-ID';
                        utterance.rate = rate;
                        utterance.pitch = pitch;
                        utterance.volume = volume;
                        
                        if (bestVoice) {
                            utterance.voice = bestVoice;
                        }
                        
                        utterance.onerror = function(event) {
                            console.warn('Speech error:', event.error);
                        };
                        
                        utterance.onend = function() {
                            console.log('Speech completed');
                        };
                        
                        window.speechSynthesis.speak(utterance);
                    }, 50);
                } else {
                    console.warn('Speech Synthesis not supported');
                }
            }
            function stopSpeech() {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                }
            }
            if ('speechSynthesis' in window) {
                loadVoices();
                window.speechSynthesis.onvoiceschanged = function() {
                    loadVoices();
                };
                setTimeout(loadVoices, 100);
            }
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            function togglePasswordVisibility() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                if (togglePassword) {
                    if (type === 'text') {
                        togglePassword.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        `;
                    } else {
                        togglePassword.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        `;
                    }
                }
            }

            if (togglePassword) {
                togglePassword.addEventListener('click', togglePasswordVisibility);
            }
            const loginForm = document.querySelector('.login-form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const email = this.querySelector('input[type="email"]').value;
                    const password = this.querySelector('input[type="password"]').value;

                    if (!email || !password) {
                        e.preventDefault();
                        alert('Please fill in all fields');
                    }
                });
            }
            @if($errors->has('email'))
                setTimeout(function() {
                    const emailField = document.querySelector('input[name="email"]');
                    if (emailField) {
                        emailField.focus();
                    }
                    speak('Email yang anda masukkan salah', 0.85, 1.0, 1.0);
                }, 100);
            @endif
            @if($errors->has('password') && !$errors->has('email'))
                setTimeout(function() {
                    speak('Password yang anda masukkan salah', 0.85, 1.0, 1.0);
                }, 100);
            @endif
            @if($errors->any())
                setTimeout(function() {
                    const firstError = document.querySelector('.text-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            @endif
            const loginButton = document.querySelector('.btn-login');
            if (loginButton) {
                loginForm.addEventListener('submit', function() {
                    loginButton.innerHTML = 'Logging in...';
                    loginButton.disabled = true;
                    loginButton.classList.add('opacity-50', 'cursor-not-allowed');
                });
            }
            (function checkStoredThrottle() {
                const throttledUntil = localStorage.getItem('throttled_until');
                const throttleActive = localStorage.getItem('throttle_active');
                
                if (throttleActive === 'true' && throttledUntil) {
                    const remainingTime = Math.ceil((parseInt(throttledUntil) - Date.now()) / 1000);
                    
                    if (remainingTime > 0) {
                        handleThrottled(remainingTime);
                    } else {
                        localStorage.removeItem('throttled_until');
                        localStorage.removeItem('throttle_active');
                    }
                }
            })();
            @if($errors->any() && (request()->header('X-Throttled') || str_contains($errors->first(), 'Terlalu banyak')))
                handleThrottled({{ $errors->first('email') ? 30 : 30 }});
            @endif

            function handleThrottled(seconds) {
                showThrottleWarning();
                disableForm();
                const throttleEndTime = Date.now() + (seconds * 1000);
                localStorage.setItem('throttled_until', throttleEndTime);
                localStorage.setItem('throttle_active', 'true');
                setTimeout(() => {
                    speak('Terlalu banyak percobaan. Akun anda diblokir sementara selama 30 detik', 0.85, 1.0, 1.0);
                }, 200);
                startCountdown(seconds);
            }

            function showThrottleWarning() {
                const warning = document.getElementById('throttleWarning');
                const errorMessage = document.getElementById('errorMessage');
                
                if (warning) {
                    warning.classList.remove('hidden');
                    warning.classList.add('animate-shake');
                }
                if (errorMessage) {
                    errorMessage.classList.add('hidden');
                }
            }

            function disableForm() {
                const form = document.getElementById('loginForm');
                const inputs = form.querySelectorAll('input');
                const submitBtn = form.querySelector('button[type="submit"]');
                inputs.forEach(input => {
                    input.disabled = true;
                    input.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-60');
                });
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.innerHTML = '🔒 Diblokir';
                }
            }

            function enableForm() {
                const form = document.getElementById('loginForm');
                const inputs = form.querySelectorAll('input');
                const submitBtn = form.querySelector('button[type="submit"]');
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('bg-gray-100', 'cursor-not-allowed', 'opacity-60');
                });
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.innerHTML = 'Log in';
                }
            }

            function startCountdown(seconds) {
                let remaining = seconds;
                const timerElement = document.getElementById('countdownTimer');
                const inlineTimer = document.getElementById('inlineTimer');
                const warning = document.getElementById('throttleWarning');
                const notification = document.getElementById('blockedNotification');
                const interval = setInterval(() => {
                    remaining--;
                    if (timerElement) {
                        timerElement.textContent = remaining;
                        if (remaining <= 10) {
                            timerElement.classList.add('animate-pulse');
                        }
                    }
                    if (inlineTimer) {
                        inlineTimer.textContent = remaining;
                    }
                    if (remaining >= 1 && remaining <= 5) {
                        const countdownWords = {
                            5: 'lima',
                            4: 'empat',
                            3: 'tiga',
                            2: 'dua',
                            1: 'satu'
                        };
                        speak(countdownWords[remaining], 0.9, 1.0, 1.0);
                    }
                    if (remaining <= 0) {
                        clearInterval(interval);
                        if (warning) {
                            warning.classList.add('hidden');
                        }
                        if (notification) {
                            notification.style.opacity = '0';
                            notification.style.transform = 'translateY(-10px)';
                            notification.style.transition = 'all 0.3s ease-out';
                            setTimeout(() => notification.remove(), 300);
                        }
                        enableForm();
                        showSuccessMessage();
                        setTimeout(() => {
                            speak('Akun anda sudah terbuka. Silahkan login kembali. Terima kasih', 0.85, 1.0, 1.0);
                        }, 300);
                        localStorage.removeItem('throttled_until');
                        localStorage.removeItem('throttle_active');
                    }
                }, 1000);
            }

            function showSuccessMessage() {
                const container = document.querySelector('.max-w-sm');
                const successDiv = document.createElement('div');
                successDiv.className = 'mb-5 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-lg shadow-lg animate-fade-in overflow-hidden';
                successDiv.innerHTML = `
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-green-600 rounded-full p-2 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="font-bold text-green-800 mb-1 text-base">✅ Akun Dibuka Kembali</h5>
                                <p class="text-green-700 font-medium text-sm">Akun telah aktif kembali. Silakan login dengan credentials yang benar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-green-200 relative overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 to-green-600 absolute top-0 left-0 loading-bar-animation" style="width: 0%; animation: loadingBar 2s ease-out forwards;"></div>
                    </div>
                `;
                const welcomeTitle = container.querySelector('.form-title');
                welcomeTitle.insertAdjacentElement('afterend', successDiv);
                setTimeout(() => {
                    successDiv.style.opacity = '0';
                    successDiv.style.transform = 'translateY(-10px)';
                    successDiv.style.transition = 'all 0.3s ease-out';
                    setTimeout(() => successDiv.remove(), 300);
                }, 7000);
            }
            const form = document.getElementById('loginForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const warning = document.getElementById('throttleWarning');
                    
                    if (warning && !warning.classList.contains('hidden')) {
                        e.preventDefault();
                        warning.classList.remove('animate-shake');
                        setTimeout(() => {
                            warning.classList.add('animate-shake');
                        }, 10);
                        showBlockedAlert();
                        return false;
                    }
                });
            }
            function showBlockedAlert() {
                const container = document.querySelector('.max-w-sm');
                const warningDiv = document.createElement('div');
                warningDiv.id = 'blockedNotification';
                warningDiv.className = 'mb-5 p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 rounded-lg shadow-lg animate-fade-in';
                warningDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="bg-red-600 rounded-full p-2 animate-pulse-scale">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-red-800 mb-1 text-base">🔒 Akses Diblokir Sementara</h5>
                            <p class="text-red-700 font-medium text-sm mb-2">Terlalu banyak percobaan login gagal. Harap tunggu <span id="inlineTimer" class="font-bold">${document.getElementById('countdownTimer')?.textContent || '30'}</span> detik.</p>
                            <p class="text-red-600 text-xs">⚠️ Ini adalah fitur keamanan untuk melindungi akun Anda.</p>
                        </div>
                    </div>
                `;
                const welcomeTitle = container.querySelector('.form-title');
                welcomeTitle.insertAdjacentElement('afterend', warningDiv);
                setTimeout(() => {
                    const remainingTime = document.getElementById('countdownTimer')?.textContent || '30';
                    speak(`Akun masih diblokir. Harap tunggu ${remainingTime} detik lagi`, 0.85, 1.0, 1.0);
                }, 100);
            }

            window.closeBlockedModal = function() {
            }
            const errorText = document.querySelector('#errorMessage p')?.textContent || '';
            const match = errorText.match(/(\d+) detik/);
            if (match) {
                const seconds = parseInt(match[1]);
                handleThrottled(seconds);
            }
        });
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
                20%, 40%, 60%, 80% { transform: translateX(8px); }
            }
            .animate-shake {
                animation: shake 0.5s ease-in-out;
            }
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 0.4s ease-out;
            }
            @keyframes spin-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .animate-spin-slow {
                animation: spin-slow 3s linear infinite;
            }
            @keyframes pulse-scale {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.08); }
            }
            .animate-pulse-scale {
                animation: pulse-scale 2s ease-in-out infinite;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            
            @keyframes fadeOut {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }
            
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            
            @keyframes slideDown {
                from {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
                to {
                    opacity: 0;
                    transform: translateY(20px) scale(0.95);
                }
            }
            @keyframes loadingBar {
                from {
                    width: 0%;
                }
                to {
                    width: 100%;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
