<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - Educounsel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
        }

        /* Left Side - Branding */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #C9D3EB 0%, #B0B4EA 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .logo {
            position: absolute;
            top: 40px;
            left: 60px;
            font-size: 24px;
            font-weight: 600;
        }

        .logo-blue {
            color: #2563EB;
        }

        .logo-orange {
            color: #F59E0B;
        }

        .illustration-container {
            position: relative;
            margin-top: 80px;
        }

        .circle-bg {
            width: 350px;
            height: 350px;
            background: #7C88CA;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 50%;
        }

        .welcome-text {
            text-align: center;
            margin-top: 40px;
            color: #F9FAFB;
        }

        .welcome-text h2 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .welcome-text p {
            font-size: 14px;
            font-weight: 400;
            color: #E5E7EB;
        }

        /* Right Side - Login Form */
        .login-right {
            flex: 1;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 60px;
        }

        .login-container {
            width: 100%;
            max-width: 360px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            background: #FFFFFF;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3F51B5;
            box-shadow: 0 0 0 3px rgba(63, 81, 181, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6B7280;
            cursor: pointer;
        }

        .forgot-password {
            text-align: right;
            margin-top: 4px;
        }

        .forgot-password a {
            color: #6366F1;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            background: #3F51B5;
            color: #FFFFFF;
            border: none;
            border-radius: 9999px;
            padding: 12px 0;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn-login:hover {
            background: #303F9F;
            box-shadow: 0 4px 12px rgba(63, 81, 181, 0.3);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #9CA3AF;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #E5E7EB;
        }

        .divider::before {
            margin-right: 16px;
        }

        .divider::after {
            margin-left: 16px;
        }

        .social-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 0;
            border: 1.5px solid #3F51B5;
            border-radius: 9999px;
            background: #FFFFFF;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            color: #374151;
        }

        .btn-social:hover {
            box-shadow: 0 4px 12px rgba(63, 81, 181, 0.2);
        }

        .social-icon {
            width: 18px;
            height: 18px;
        }

        .register-section {
            text-align: center;
            margin-top: 20px;
        }

        .register-text {
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .btn-register {
            width: 100%;
            padding: 10px 0;
            border: 1.5px solid #3F51B5;
            border-radius: 9999px;
            background: #FFFFFF;
            color: #3F51B5;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: #E0E7FF;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
        }

        .alert-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #16A34A;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Left Side - Branding & Illustration -->
    <div class="login-left">
        <div class="logo">
            <span class="logo-blue">edu</span><span class="logo-orange">counsel</span>
        </div>

        <div class="illustration-container">
            <div class="circle-bg">
                <img src="{{ asset('images/konseling.png') }}" alt="Ilustrasi Konseling" class="illustration">
            </div>
        </div>

        <div class="welcome-text">
            <h2>Welcome aboard my friend</h2>
            <p>just a couple of clicks and we start</p>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="login-right">
        <div class="login-container">
            @yield('content')
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.password-toggle');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.previousElementSibling;
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
                });
            });
        });
    </script>
</body>
</html>
