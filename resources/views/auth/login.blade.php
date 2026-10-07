<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stok Material ATK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Reset & Background */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            /* Background gradasi biru ke kuning */
            background: linear-gradient(135deg, #e0f2fe 0%, #fef9c3 100%);
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
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 95, 184, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 5px solid #facc15; /* Garis kuning di atas */
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
            color: #005fb8; /* Biru PLN */
            font-weight: 700;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        /* Aksen kuning di bawah subtitle */
        .subtitle::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background-color: #facc15;
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
            font-weight: 600;
            color: #005fb8; /* Label biru */
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
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1f2937;
            outline: none;
            transition: all 0.3s;
        }

        /* Fokus input: border kuning + shadow biru */
        .input-wrapper input:focus {
            border-color: #facc15;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.2);
        }

        /* Ikon di dalam input */
        .input-icon {
            position: absolute;
            left: 12px;
            color: #005fb8; /* Ikon biru */
            display: flex;
            align-items: center;
        }

        /* Ikon mata (toggle password) */
        .toggle-password {
            position: absolute;
            right: 12px;
            color: #005fb8;
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
            color: #374151;
            font-weight: 500;
            cursor: pointer;
        }

        .remember-me input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color: #005fb8;
            cursor: pointer;
        }

        .forgot-password {
            color: #d97706; /* Kuning tua/oranye */
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #b45309;
        }

        /* Tombol Masuk */
        .btn-submit {
            width: 100%;
            background-color: #005fb8;
            color: #ffffff;
            border: 2px solid #005fb8;
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
        }

        /* Hover tombol: berubah jadi kuning, teks biru */
        .btn-submit:hover {
            background-color: #facc15;
            border-color: #facc15;
            color: #005fb8;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(250, 204, 21, 0.4);
        }

        /* Footer */
        .footer-text {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px dashed #e2e8f0;
            font-size: 12px;
            color: #005fb8;
            font-weight: 500;
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

        /* Dekorasi lingkaran kuning di pojok kartu */
        .login-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(250, 204, 21, 0.2) 0%, rgba(250, 204, 21, 0) 70%);
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
        <h2>Stok Material ATK</h2>
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