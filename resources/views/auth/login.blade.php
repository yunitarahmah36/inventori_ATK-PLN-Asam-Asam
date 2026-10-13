<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Inventori Material</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Reset & Background */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            /* Background gradasi putih bersih ke blush petal lembut */
            background: linear-gradient(135deg, #FFFFFF 0%, #FAF0F3 45%, #F7C8D3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Kartu Login */
        .login-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 40px 35px;
            border-radius: 14px;
            border: 1px solid #F2E0E4;
            box-shadow: 0 16px 40px rgba(180, 106, 114, 0.12);
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 5px solid #B46A72; /* Aksen Rosewood di atas */
        }

        /* Logo */
        .logo-container {
            margin-bottom: 20px;
        }
        .logo-container img {
            height: 60px;
            object-fit: contain;
        }

        /* Teks Judul */
        h2 {
            font-size: 22px;
            color: #3D2227; /* Deep Rosewood - kontras tinggi & nyaman */
            font-weight: 800;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 13px;
            color: #7E5B62;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        /* Aksen Blush Petal di bawah subtitle */
        .subtitle::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background-color: #F7C8D3;
            border: 1px solid #EAAAB9;
            margin: 8px auto 0;
            border-radius: 2px;
        }

        /* Form Group */
        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #3D2227;
            margin-bottom: 8px;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            background-color: #FFFFFF;
            border: 2px solid #EDD4DA;
            border-radius: 8px;
            font-size: 14px;
            color: #3D2227;
            outline: none;
            transition: all 0.3s;
        }

        /* Fokus input: border Rosewood + shadow Blush Petal */
        .input-wrapper input:focus {
            border-color: #B46A72;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(247, 200, 211, 0.45);
        }

        /* Ikon di dalam input */
        .input-icon {
            position: absolute;
            left: 12px;
            color: #B46A72;
            display: flex;
            align-items: center;
        }

        /* Ikon mata (toggle password) */
        .toggle-password {
            position: absolute;
            right: 12px;
            color: #B46A72;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        /* Remember & Forgot Password */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            color: #4D2C32;
            font-weight: 500;
            cursor: pointer;
        }

        .remember-me input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color: #B46A72;
            cursor: pointer;
        }

        .forgot-password {
            color: #B46A72;
            text-decoration: none;
            font-weight: 700;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #8E474F;
        }

        /* Tombol Masuk */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #B46A72 0%, #9C545C 100%);
            color: #ffffff;
            border: 2px solid #8E474F;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(180, 106, 114, 0.3);
        }

        /* Hover tombol: berubah jadi Blush Petal, teks gelap nyaman */
        .btn-submit:hover {
            background: linear-gradient(135deg, #F7C8D3 0%, #F5BCC9 100%);
            border-color: #E6A8B5;
            color: #3D2227;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(180, 106, 114, 0.25);
        }

        /* Footer */
        .footer-text {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px dashed #F2E0E4;
            font-size: 12px;
            color: #7E5B62;
            font-weight: 600;
        }

        /* Error Alert */
        .alert-error {
            background-color: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }

        /* Dekorasi lingkaran blush di pojok kartu */
        .login-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(247, 200, 211, 0.35) 0%, rgba(247, 200, 211, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN">
        </div>

        <!-- Judul -->
        <h2>Inventori Material</h2>
        <p class="subtitle">Silakan masuk ke akun Anda</p>

        <!-- Error Handling Laravel -->
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <!-- Input Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email Anda" required>
                </div>
            </div>

            <!-- Input Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                    
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                            <line x1="2" x2="22" y1="2" y2="22"></line>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Ingat Saya & Lupa Password -->
            <div class="form-actions">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    Ingat Saya
                </label>
                <a href="{{ route('password.reset.form') }}" class="forgot-password">
                    Lupa Password?
                </a>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="btn-submit">
                Masuk
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" x2="3" y1="12" y2="12"></line>
                </svg>
            </button>
        </form>

        <!-- Footer -->
        <div class="footer-text">
            PT PLN Indonesia Power UBP Asam Asam
        </div>
    </div>

    <!-- Script untuk Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ganti ikon mata terbuka (opsional)
                eyeIcon.innerHTML = `
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            } else {
                passwordInput.type = 'password';
                // Kembalikan ikon mata tertutup
                eyeIcon.innerHTML = `
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                    <line x1="2" x2="22" y1="2" y2="22"></line>
                `;
            }
        }
    </script>
</body>
</html>