<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Tambah Material - Inventori ATK PLN Asam-Asam</title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
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

/* ============================================================
   SIDEBAR
   ============================================================ */

.sidebar {
    position: fixed;
    inset: 0 auto 0 0;
    width: var(--sidebar-w);
    background: var(--blue-dark);
    color: #fff;
    display: flex;
    flex-direction: column;
    z-index: 200;
    transition: transform var(--transition);
}

/* ============================================================
   LOGO
   ============================================================ */

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 22px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.sidebar-logo-image {
    width: 40px;
    height: 40px;
    max-width: 40px;
    max-height: 40px;
    object-fit: contain;
    object-position: center;
    display: block;
    flex-shrink: 0;
}

.sidebar-logo-text {
    min-width: 0;
}

.sidebar-logo-text h1 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}

.sidebar-logo-text p {
    margin: 1px 0 0;
    font-size: 11px;
    color: rgba(255, 255, 255, 0.55);
}

/* ============================================================
   USER CARD
   ============================================================ */

.sidebar-user {
    margin: 14px 12px 6px;
    padding: 12px;
    background: rgba(255,255,255,0.07);
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--yellow);
    color: var(--blue-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 15px;
    flex-shrink: 0;
}

.sidebar-user-info {
    min-width: 0;
}

.sidebar-user-name {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}

.sidebar-user-role {
    font-size: 11px;
    color: var(--yellow);
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 2px;
}

/* ============================================================
   NAVIGATION
   ============================================================ */

.sidebar-nav {
    flex: 1;
    padding: 10px 12px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.nav-section-title {
    font-size: 10.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    padding: 10px 10px 4px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px 12px;
    border-radius: 9px;
    color: rgba(255,255,255,0.78);
    font-size: 13.5px;
    font-weight: 500;
    transition: background var(--transition), color var(--transition);
    cursor: pointer;
}

.nav-item:hover {
    background: rgba(255,255,255,0.10);
    color: #fff;
}

/* ACTIVE MENU UTAMA */
.nav-item.active {
    background: rgba(255,255,255,0.14);
    color: var(--yellow);
    font-weight: 700;
}

.nav-item .material-symbols-outlined {
    font-size: 20px;
}

/* ============================================================
   SUBMENU DATA MATERIAL
   ============================================================ */

.nav-submenu {
    display: none;
    padding: 3px 0 4px 14px;
}

.nav-submenu.show {
    display: block;
}

.nav-sub-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 12px;
    margin: 2px 0;
    border-radius: 8px;
    color: rgba(255,255,255,0.68);
    font-size: 12.5px;
    font-weight: 500;
    transition: background var(--transition), color var(--transition);
}

.nav-sub-item:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* SUBMENU YANG AKTIF */
.nav-sub-item.active {
    background: rgba(255,193,7,0.16);
    color: var(--yellow);
    font-weight: 700;
}

.nav-sub-item .material-symbols-outlined {
    font-size: 18px;
}

/* ============================================================
   SIDEBAR FOOTER
   ============================================================ */

.sidebar-footer {
    padding: 12px;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.btn-logout {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 9px;
    background: rgba(220, 38, 38, 0.18);
    color: #FCA5A5;
    border: 1px solid rgba(220, 38, 38, 0.3);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.btn-logout:hover {
    background: rgba(220, 38, 38, 0.28);
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

        /* Mobile */
        .drawer-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 199;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .drawer-backdrop.open { display: block; }
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

    <div class="drawer-backdrop" id="drawerBackdrop" onclick="closeSidebar()"></div>

    <div class="layout">

<!-- ============================================================
     SIDEBAR
     Sama untuk Admin, Keuangan, dan Umum
     ============================================================ -->

<aside class="sidebar" id="sidebar">

    <!-- ========================================================
         LOGO
         ======================================================== -->

    <div class="sidebar-logo">

        <img
            src="{{ asset('images/logo-pln.png') }}"
            alt="Logo PLN"
            class="sidebar-logo-image"
        >

        <div class="sidebar-logo-text">
            <h1>STOK ATK</h1>
            <p>PLN Asam-Asam</p>
        </div>

    </div>


    <!-- ========================================================
         USER CARD
         Nama diambil dari bagian sebelum @ pada email
         ======================================================== -->

    @php
        $userEmail = Auth::user()->email ?? '';
        $displayName = strtoupper(strstr($userEmail, '@', true));

        if (empty($displayName)) {
            $displayName = strtoupper(Auth::user()->name ?? 'USER');
        }

        $userRole = strtoupper(Auth::user()->role ?? 'PENGGUNA');
        $avatarInitial = substr($displayName, 0, 1);
    @endphp


    <div class="sidebar-user">

        <div class="sidebar-avatar">
            {{ $avatarInitial }}
        </div>

        <div class="sidebar-user-info">

            <div class="sidebar-user-name">
                {{ $displayName }}
            </div>

            <div class="sidebar-user-role">
                {{ $userRole }}
            </div>

        </div>

    </div>


    <!-- ========================================================
         NAVIGATION
         Semua user memiliki menu yang sama
         ======================================================== -->

    <nav class="sidebar-nav">

        <div class="nav-section-title">
            Menu Utama
        </div>


        <!-- ====================================================
             DASHBOARD
             Aktif hanya ketika benar-benar berada di dashboard
             ==================================================== -->

        <a
            href="{{ route('dashboard') }}"
            class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >
            <span class="material-symbols-outlined">
                speed
            </span>

            Dashboard
        </a>


        <!-- ====================================================
             DATA MATERIAL
             Parent aktif pada semua halaman materials.*
             ==================================================== -->

        <!-- ====================================================
             DATA MATERIAL
             ==================================================== -->

        <a
            href="{{ route('materials.index') }}"
            class="nav-item {{ request()->routeIs('materials.*') ? 'active' : '' }}"
        >
            <span class="material-symbols-outlined">
                inventory_2
            </span>

            Data Material
        </a>


        <!-- ====================================================
             RIWAYAT STOK
             Belum aktif karena fiturnya belum dikerjakan
             ==================================================== -->

        <a href="#" class="nav-item">

            <span class="material-symbols-outlined">
                history
            </span>

            Riwayat Stok

        </a>


        <!-- ====================================================
             LAPORAN
             ==================================================== -->

        <a href="#" class="nav-item">

            <span class="material-symbols-outlined">
                bar_chart
            </span>

            Laporan

        </a>


        <!-- ====================================================
             AKUN
             ==================================================== -->

        <div
            class="nav-section-title"
            style="margin-top:8px;"
        >
            Akun
        </div>


        <!-- Profile -->
        <a href="#" class="nav-item">

            <span class="material-symbols-outlined">
                account_circle
            </span>

            Profile

        </a>

    </nav>


    <!-- ========================================================
         LOGOUT
         ======================================================== -->

    <div class="sidebar-footer">

        <form
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="btn-logout"
            >

                <span class="material-symbols-outlined">
                    logout
                </span>

                Keluar (Logout)

            </button>

        </form>

    </div>

</aside>

        <!-- MAIN -->
        <main class="main">
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Tambah Material</h1>
                        <p>Inventori ATK PLN Asam-Asam</p>
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
                                    value="{{ old('material_number', $suggestedNumber) }}" 
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
