<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Tambah Material - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style id="page-style">
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue:         #0057B8;
            --blue-dark:    #003B73;
            --blue-light:   #EAF3FF;
            --yellow:       #FFC107;
            --yellow-light: #FFF8E1;
            --bg:           #F5F7FA;
            --white:        #FFFFFF;
            --text-dark:    #1F2937;
            --text-mid:     #374151;
            --text-muted:   #6B7280;
            --border:       #E5E7EB;
            --red:          #DC2626;
            --red-light:    #FEE2E2;
            --sidebar-w:    260px;
            --header-h:     68px;
            --radius:       12px;
            --shadow:       0 2px 12px rgba(0,0,0,0.07);
            --transition:   0.2s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', Arial, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
        }

        a { text-decoration: none; color: inherit; }
        button, input, select, textarea { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }

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
            height: var(--header-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left h1 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
        }

        .topbar-left p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-user-detail { text-align: right; }
        .topbar-user-name { font-size: 13px; font-weight: 700; color: var(--text-dark); }
        .topbar-user-email { font-size: 11px; color: var(--text-muted); }
        .badge-role {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 7px;
            border-radius: 20px;
            background: var(--blue-light);
            color: var(--blue);
            text-transform: uppercase;
        }

        .topbar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
        }

        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-dark);
            cursor: pointer;
            padding: 4px;
        }

        /* PAGE CONTENT */
        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 16px;
            transition: color var(--transition);
        }

        .btn-back:hover {
            color: var(--blue);
        }

        .form-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .form-card-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .form-card-header h2 {
            font-size: 19px;
            font-weight: 800;
            color: var(--blue-dark);
        }

        .form-card-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Errors Alert */
        .alert-error {
            background: var(--red-light);
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .alert-error ul {
            margin-top: 6px;
            padding-left: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
        }

        .form-label span.req {
            color: var(--red);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text-dark);
            background: #FAFBFD;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--red);
            background: #FFF5F5;
        }

        .invalid-feedback {
            font-size: 11.5px;
            color: var(--red);
            font-weight: 500;
        }

        .form-helper {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
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
            .main { margin-left: 0; }
            .btn-hamburger { display: flex; }
            .topbar { padding: 0 16px; }
            .page-content { padding: 16px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions .btn { width: 100%; justify-content: center; }
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
                        <h1>Tambah Material</h1>
                        <p>Inventori ATK PT PLN Indonesia Power UBP Asam Asam</p>
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
                        <h2>Form Tambah Material Baru</h2>
                        <p>Lengkapi formulir di bawah ini untuk menambahkan stok material ATK baru.</p>
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

                    <form action="{{ route('materials.store') }}" method="POST">
                        @csrf

                        <div class="form-grid">

                            <!-- No Material -->
                            <div class="form-group">
                                <label for="material_number" class="form-label">
                                    No Material <span class="req">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="material_number" 
                                    name="material_number" 
                                    class="form-control @error('material_number') is-invalid @enderror"
                                    value="{{ old('material_number') }}"
                                    placeholder="Contoh: MAT001"
                                    required
                                >
                                @error('material_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <span class="form-helper">Nomor unik pengenal material</span>
                            </div>

                            <!-- Nama Material -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Nama Material <span class="req">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" 
                                    placeholder="Contoh: Kertas HVS A4 70gr"
                                    required
                                >
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="form-group">
                                <label for="entry_date" class="form-label">
                                    Tanggal Masuk <span class="req">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="entry_date" 
                                    name="entry_date" 
                                    class="form-control @error('entry_date') is-invalid @enderror"
                                    value="{{ old('entry_date', date('Y-m-d')) }}" 
                                    required
                                >
                                @error('entry_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jumlah Item -->
                            <div class="form-group">
                                <label for="quantity" class="form-label">
                                    Jumlah Item (Stok) <span class="req">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity', 0) }}" 
                                    min="0"
                                    placeholder="0"
                                    required
                                >
                                @error('quantity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Satuan -->
                            <div class="form-group">
                                <label for="unit" class="form-label">
                                    Satuan <span class="req">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="unit" 
                                    name="unit" 
                                    list="unit-suggestions"
                                    class="form-control @error('unit') is-invalid @enderror"
                                    value="{{ old('unit') }}" 
                                    placeholder="Contoh: Rim, Pcs, Buah, Box"
                                    required
                                >
                                <datalist id="unit-suggestions">
                                    <option value="Rim">
                                    <option value="Pcs">
                                    <option value="Buah">
                                    <option value="Box">
                                    <option value="Pack">
                                    <option value="Lusin">
                                    <option value="Rol">
                                    <option value="Lembar">
                                    <option value="Botol">
                                </datalist>
                                @error('unit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group full-width">
                                <label for="description" class="form-label">
                                    Deskripsi / Keterangan (Opsional)
                                </label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="3" 
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Tambahkan catatan spesifikasi, merk, atau lokasi penyimpanan material jika ada..."
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-actions">
                            <a href="{{ route('materials.index') }}" class="btn btn-outline">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                                Simpan Material
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>
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

        function toggleSubmenu(e, id) {
            if (e) e.preventDefault();
            const menu = document.getElementById(id);
            const arrow = document.getElementById('arrow-material');
            if (!menu) return;

            menu.classList.toggle('show');
            const isOpen = menu.classList.contains('show');

            if (arrow) {
                arrow.textContent = isOpen ? 'expand_less' : 'expand_more';
            }
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>
</body>

</html>
