<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Material - Sistem Informasi Inventori Material PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">

    <style id="page-style">
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #B46A72;
            --blue-dark: #3D2227;
            --blue-light: #FDF2F4;
            --yellow: #F7C8D3;
            --yellow-light: #FFF5F7;
            --bg: #FCF9FA;
            --white: #FFFFFF;
            --text-dark: #3D2227;
            --text-mid: #4D2C32;
            --text-muted: #7E5B62;
            --border: #F2E0E4;
            --red: #DC2626;
            --red-light: #FEE2E2;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(180, 106, 114, 0.06);
            --transition: 0.2s ease;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* MAIN */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            height: var(--header-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04);
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
        }

        .topbar-left h1 {
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .topbar-left p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            margin-bottom: 0;
        }

        /* Hamburger (mobile only) */
        .btn-hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-dark);
            transition: background var(--transition);
            cursor: pointer;
        }

        .btn-hamburger:hover {
            background: var(--bg);
        }

        .btn-hamburger .material-symbols-outlined {
            font-size: 22px;
        }

        /* Topbar Right: user profile */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 40px;
            background: #F8FAFC;
            border: 1px solid var(--border);
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .topbar-user:hover {
            background: #F1F5F9;
        }

        .topbar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-dark), var(--blue));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 59, 115, 0.25);
        }

        .topbar-user-detail {
            text-align: right;
        }

        .topbar-user-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .topbar-user-email {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .badge-role {
            display: inline-block;
            margin-top: 2px;
            padding: 2px 8px;
            border-radius: 20px;
            background: var(--yellow-light);
            color: var(--blue-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Content Area */
        .page-content {
            padding: 28px;
            flex: 1;
            max-width: 760px;
            margin: 0 auto;
            width: 100%;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 18px;
            transition: var(--transition);
        }

        .btn-back:hover {
            color: var(--blue);
            transform: translateX(-2px);
        }

        /* Form Card */
        .form-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 32px;
        }

        .form-card-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .form-card-header h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
            margin-bottom: 4px;
        }

        .form-card-header p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 6px 0 0 16px;
            padding: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .form-label .req {
            color: var(--red);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text-dark);
            background: #fff;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .form-control.is-invalid {
            border-color: var(--red);
            background: #FFFBFB;
        }

        .invalid-feedback {
            font-size: 12px;
            color: var(--red);
            margin-top: 2px;
        }

        .form-helper {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            line-height: 1.4;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 87, 184, 0.25);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: #F9FAFB;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
            }

            .btn-hamburger {
                display: flex;
            }

            .topbar {
                padding: 0 16px;
            }

            .page-content {
                padding: 16px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="layout">

        <!-- SIDEBAR -->
        @include('partials.sidebar')

        <!-- MAIN -->
        <main class="main">
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Edit Material</h1>
                        <p>Sistem Informasi Inventori Material PT PLN Indonesia Power UBP Asam Asam</p>
                    </div>
                </div>

                <div class="topbar-user">
                    <div class="topbar-user-detail">
                        <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                        <div class="topbar-user-email">{{ Auth::user()->email }}</div>
                        <span class="badge-role">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="page-content">

                <a href="{{ route('materials.index') }}" class="btn-back">
                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                    Kembali ke Data Material
                </a>

                <div class="form-card">
                    <div class="form-card-header">
                        <h2>Edit Data Material</h2>
                        <p>Perbarui identitas data master material <strong>{{ $material->name }}</strong>
                            ({{ $material->material_number }}).</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert-error">
                            <strong>Terjadi kesalahan pengisian form:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('materials.update', $material->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">

                            <!-- No Material (Terkunci / Tidak Dapat Diedit) -->
                            <div class="form-group">
                                <label for="material_number" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                                    <span>No. Material</span>
                                    <span style="font-size: 11px; font-weight: 600; color: #64748B; background: #F1F5F9; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                        <span class="material-symbols-outlined" style="font-size: 13px;">lock</span>
                                        Terkunci
                                    </span>
                                </label>
                                <div style="position: relative;">
                                    <input type="text" id="material_number"
                                        class="form-control"
                                        value="{{ $material->material_number }}" 
                                        readonly
                                        disabled
                                        style="background-color: #F8FAFC; color: #475569; font-weight: 600; cursor: not-allowed; border-color: #E2E8F0; padding-right: 38px;"
                                        title="No. Material bersifat permanen dan tidak dapat diedit">
                                    <span class="material-symbols-outlined" 
                                          style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 18px; pointer-events: none;">
                                        lock
                                    </span>
                                </div>
                                <span class="form-helper" style="color: #64748B;">
                                    No. Material adalah kode identitas unik permanen yang tidak dapat diubah setelah didaftarkan.
                                </span>
                            </div>

                            <!-- Nama Material -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Nama Material <span class="req">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $material->name) }}" required autocomplete="off">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <span class="form-helper">
                                    Nama lengkap barang atau material (wajib unik dan tidak boleh sama dengan material lain).
                                </span>
                            </div>

                            <!-- Satuan -->
                            <div class="form-group">
                                <label for="unit" class="form-label">
                                    Satuan <span class="req">*</span>
                                </label>
                                <input type="text" id="unit" name="unit" list="unit-suggestions"
                                    class="form-control @error('unit') is-invalid @enderror"
                                    value="{{ old('unit', $material->unit) }}" required autocomplete="off">
                                <datalist id="unit-suggestions">
                                    <option value="Pcs">
                                    <option value="Unit">
                                    <option value="Rim">
                                    <option value="Box">
                                    <option value="Pack">
                                    <option value="Roll">
                                    <option value="Meter">
                                    <option value="Lembar">
                                    <option value="Buah">
                                    <option value="Lusin">
                                    <option value="Botol">
                                    <option value="Set">
                                </datalist>
                                @error('unit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <span class="form-helper">
                                    Satuan takaran material (misal: Pcs, Unit, Rim, Meter, Roll).
                                </span>
                            </div>

                            <!-- Batas Minimum Stok -->
                            <div class="form-group">
                                <label for="min_stock" class="form-label">
                                    Batas Minimum Stok (Peringatan Stok Menipis)
                                </label>
                                <input type="number" id="min_stock" name="min_stock" min="0" step="1"
                                    class="form-control @error('min_stock') is-invalid @enderror"
                                    value="{{ old('min_stock', $material->min_stock ?? 15) }}"
                                    placeholder="15">
                                @error('min_stock')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <span class="form-helper">
                                    Batas jumlah unit untuk status Stok Menipis (Default sistem: 15 unit). Jika stok material ≤ batas ini, status otomatis menjadi "Stok Menipis".
                                </span>
                            </div>

                        </div>

                        <div class="form-actions">
                            <a href="{{ route('materials.index') }}" class="btn btn-outline">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            <script>
                function openSidebar() {
                    document.getElementById('sidebar').classList.add('open');
                    document.getElementById('drawerBackdrop').classList.add('open');
                    document.body.style.overflow = 'hidden';
                }

                function closeSidebar() {
                    document.getElementById('sidebar').classList.remove('open');
                    document.getElementById('drawerBackdrop').classList.remove('open');
                    document.body.style.overflow = '';
                }

                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        closeSidebar();
                    }
                });
            </script>
        </main>
    </div>
</body>

</html>
