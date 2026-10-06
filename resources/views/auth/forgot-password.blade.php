<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - Stok Material ATK</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #fef9c3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

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
            border-top: 5px solid #facc15;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo-container img {
            height: 60px;
            object-fit: contain;
        }

        h2 {
            font-size: 22px;
            color: #005fb8;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #005fb8;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 45px 12px 12px; /* ruang kanan untuk tombol mata */
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1f2937;
            outline: none;
            transition: all 0.3s;
        }

        .input-wrapper input:focus {
            border-color: #facc15;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.2);
        }

        /* Validasi konfirmasi password */
        .input-wrapper input.match {
            border-color: #16a34a;
            background-color: #f0fdf4;
        }

        .input-wrapper input.mismatch {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        /* Tombol toggle mata */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            transition: color 0.2s;
            border-radius: 4px;
        }

        .toggle-password:hover {
            color: #005fb8;
        }

        .toggle-password:focus-visible {
            outline: 2px solid #facc15;
            outline-offset: 2px;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        /* Indikator kekuatan password */
        .password-strength {
            margin-top: 8px;
            display: none;
        }

        .password-strength.visible {
            display: block;
        }

        .strength-bar {
            height: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
        }

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
            transition: all 0.3s ease;
            margin-top: 5px;
        }

        .btn-submit:hover {
            background-color: #facc15;
            border-color: #facc15;
            color: #005fb8;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(250, 204, 21, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-login {
            display: inline-block;
            margin-top: 20px;
            color: #005fb8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-login:hover {
            text-decoration: underline;
            color: #facc15;
        }

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

        .alert-success {
            background-color: #f0fdf4;
            color: #16a34a;
            border-left: 4px solid #16a34a;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 120px;
            height: 120px;
            background: radial-gradient(
                circle,
                rgba(250, 204, 21, 0.2) 0%,
                rgba(250, 204, 21, 0) 70%
            );
            border-radius: 50%;
            pointer-events: none;
        }

        .footer-text {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px dashed #e2e8f0;
            font-size: 12px;
            color: #005fb8;
            font-weight: 500;
        }

        /* Responsif */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 22px;
            }

            h2 {
                font-size: 20px;
            }
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
        <h2>Lupa Password</h2>

        <p class="subtitle">
            Masukkan email dan password baru Anda
        </p>

        <!-- Error -->
        @if ($errors->any())
            <div class="alert-error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Success -->
        @if (session('status'))
            <div class="alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('password.reset') }}" method="POST" id="resetForm">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>

                <div class="input-wrapper">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        autocomplete="email"
                        required
                    >
                </div>
            </div>

            <!-- Password Baru -->
            <div class="form-group">
                <label for="password">Password Baru</label>

                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password baru"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        data-target="password"
                        aria-label="Tampilkan password"
                        title="Tampilkan password"
                    >
                        <!-- Ikon mata tertutup -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>

                <!-- Indikator kekuatan password -->
                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBarFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText"></span>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password baru"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        data-target="password_confirmation"
                        aria-label="Tampilkan konfirmasi password"
                        title="Tampilkan konfirmasi password"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn-submit">
                Ubah Password
            </button>

        </form>

        <!-- Kembali -->
        <a href="{{ route('login') }}" class="back-login">
            ← Kembali ke Login
        </a>

        <!-- Footer -->
        <div class="footer-text">
            PT PLN Indonesia Power UBP Asam Asam
        </div>

    </div>

    <script>
        // ====== TOGGLE PASSWORD VISIBILITY ======
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (!input) return;

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                // Update ikon & label
                if (isPassword) {
                    this.setAttribute('aria-label', 'Sembunyikan password');
                    this.setAttribute('title', 'Sembunyikan password');
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    `;
                } else {
                    this.setAttribute('aria-label', 'Tampilkan password');
                    this.setAttribute('title', 'Tampilkan password');
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    `;
                }
            });
        });

        // ====== PASSWORD STRENGTH INDICATOR ======
        const passwordInput = document.getElementById('password');
        const strengthContainer = document.getElementById('passwordStrength');
        const strengthBarFill = document.getElementById('strengthBarFill');
        const strengthText = document.getElementById('strengthText');

        function calculateStrength(password) {
            let score = 0;
            if (!password) return { score: 0, label: '', color: '' };

            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^a-zA-Z0-9]/.test(password)) score++;

            if (score <= 2) return { score, label: 'Lemah', color: '#dc2626' };
            if (score <= 4) return { score, label: 'Sedang', color: '#f59e0b' };
            return { score, label: 'Kuat', color: '#16a34a' };
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const val = this.value;

                if (!val) {
                    strengthContainer.classList.remove('visible');
                    return;
                }

                strengthContainer.classList.add('visible');

                const { score, label, color } = calculateStrength(val);
                const percent = Math.min((score / 6) * 100, 100);

                strengthBarFill.style.width = percent + '%';
                strengthBarFill.style.backgroundColor = color;
                strengthText.textContent = 'Kekuatan password: ' + label;
                strengthText.style.color = color;
            });
        }

        // ====== KONFIRMASI PASSWORD REAL-TIME ======
        const confirmInput = document.getElementById('password_confirmation');

        function checkMatch() {
            if (!passwordInput || !confirmInput) return;
            if (!confirmInput.value) {
                confirmInput.classList.remove('match', 'mismatch');
                return;
            }

            if (passwordInput.value === confirmInput.value) {
                confirmInput.classList.add('match');
                confirmInput.classList.remove('mismatch');
            } else {
                confirmInput.classList.add('mismatch');
                confirmInput.classList.remove('match');
            }
        }

        if (confirmInput) {
            confirmInput.addEventListener('input', checkMatch);
        }
        if (passwordInput) {
            passwordInput.addEventListener('input', checkMatch);
        }

        // ====== VALIDASI FORM SEBELUM SUBMIT ======
        const form = document.getElementById('resetForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                if (passwordInput.value !== confirmInput.value) {
                    e.preventDefault();
                    confirmInput.classList.add('mismatch');
                    confirmInput.focus();
                    alert('Password dan konfirmasi password tidak sama!');
                }
            });
        }
    </script>

</body>
</html>