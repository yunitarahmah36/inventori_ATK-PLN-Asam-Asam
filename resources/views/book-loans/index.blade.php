<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Transaksi Peminjaman & Pengembalian Buku - PT PLN Indonesia Power UBP Asam Asam</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style id="page-style">
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
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
            --green: #059669;
            --green-light: #ECFDF5;
            --amber: #D97706;
            --amber-light: #FEF3C7;
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
    overflow-x: hidden;
}

/* Scrollbar sama seperti Dashboard */
::-webkit-scrollbar {
    width: 5px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 10px;
}


        /* ============================================================
           LAYOUT & MAIN WRAPPER (Konsisten dengan Dashboard)
        ============================================================ */
        .layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            transition: margin-left var(--transition);
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .content-area {
            flex: 1;
            min-width: 0;
        }

        /* ============================================================
           TOPBAR (Header Konsisten dengan Dashboard)
        ============================================================ */
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
            background: #FDF2F4;
            color: #B46A72;
            border: 1px solid #F7C8D3;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }

        .alert-box {
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow);
            transition: transform var(--transition);
        }

        .stat-card:hover { transform: translateY(-2px); }

        .stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-info .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .stat-info .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Tabs Bar */
        .status-tabs-container {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
            overflow-x: auto;
        }

        .status-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            background: var(--white);
            border: 1px solid var(--border);
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
        }

        .status-tab-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .status-tab-btn.active {
            background: var(--blue);
            color: var(--white);
            border-color: var(--blue);
        }

        .tab-counter {
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 10px;
            background: rgba(0,0,0,0.08);
            font-weight: 700;
        }

        .status-tab-btn.active .tab-counter {
            background: rgba(255,255,255,0.25);
            color: var(--white);
        }

        /* Data Card */
        .data-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header-bar {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            position: relative;
            min-width: 240px;
        }

        .search-box input {
            width: 100%;
            height: 38px;
            padding: 0 14px 0 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            background: var(--bg);
            outline: none;
            transition: border-color var(--transition);
        }

        .search-box input:focus {
            border-color: var(--blue);
            background: var(--white);
        }

        .search-box .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue);
            color: var(--white);
            border: none;
            border-radius: 8px;
            height: 38px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #E5E7EB;
            color: var(--text-dark);
            border: none;
            border-radius: 8px;
            height: 38px;
            padding: 0 14px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        /* Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .table-custom th {
            background: #FDF7F8;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table-custom td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            vertical-align: middle;
        }

        .table-custom tr:hover td {
            background: #FFF9FA;
        }

        .loan-code {
            font-family: monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--blue-dark);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .status-dipinjam {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }

        .status-terlambat {
            background: #FEF2F2;
            color: #B91C1C;
            border: 1px solid #FECACA;
            animation: pulseWarning 2s infinite ease-in-out;
        }

        @keyframes pulseWarning {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .status-dikembalikan {
            background: #ECFDF5;
            color: #047857;
            border: 1px solid #A7F3D0;
        }

        .btn-return {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            background: #059669;
            color: #FFF;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
        }

        .btn-return:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            background: #FDF2F4;
            color: var(--blue);
            border: 1px solid var(--border);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: var(--blue);
            color: #FFF;
            border-color: var(--blue);
            transform: translateY(-1px);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .detail-item {
            background: #FCF9FA;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
        }

        .detail-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            word-break: break-word;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-mid);
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-action:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
        }

        .btn-action-delete:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-light);
        }

        .action-btns {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: flex-end;
        }

        /* Table Footer & Pagination (Seragam dengan Dashboard) */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #FCF9FA;
            flex-wrap: wrap;
            gap: 12px;
            box-sizing: border-box;
            width: 100%;
        }

        .table-footer-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .data-info {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .data-info strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .table-footer-pagination {
            display: flex;
            align-items: center;
        }

        .table-footer svg {
            display: none !important;
        }

        .per-page-select {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .per-page-select label {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .per-page-select select {
            padding: 5px 8px;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-dark);
            background: #fff;
            cursor: pointer;
            outline: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .per-page-select select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 2px rgba(180, 106, 114, 0.15);
        }

        @media (max-width: 768px) {
            .table-footer {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                gap: 12px !important;
                padding: 14px 16px !important;
            }
            .table-footer-left {
                flex-direction: column !important;
                gap: 8px !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .per-page-select {
                justify-content: center !important;
            }
            .table-footer-pagination {
                justify-content: center !important;
                width: 100% !important;
            }
        }

        /* Modal Styles */
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(61, 34, 39, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.show { display: flex; }

        .modal-card {
            background: var(--white);
            border-radius: var(--radius);
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.2s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 20px;
        }

        .modal-body {
            padding: 20px 24px;
        }

        .modal-footer {
            padding: 14px 24px;
            background: #FDF9FA;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
            transition: border-color var(--transition);
        }

        .form-control:focus {
            border-color: var(--blue);
        }

        textarea.form-control {
            height: 70px;
            padding: 8px 12px;
            resize: vertical;
        }

        @media (max-width: 992px) {
            .main, .content-area { margin-left: 0 !important; }
            .btn-hamburger { display: flex; }
            .topbar { padding: 0 16px; }
            .topbar-left h1 { font-size: 18px; }
            .topbar-user-detail .topbar-user-email { display: none; }
            .form-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .topbar-user-detail { display: none; }
            .topbar-left p { display: none; }
        }
    </style>
</head>
<body>
<div class="layout">
    <!-- Include Sidebar -->
    @include('partials.sidebar')

    <!-- Content Area -->
    <main class="main">
        <!-- Topbar Header -->
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:14px;">
                <button class="btn-hamburger" id="btnHamburger" onclick="openSidebar()" aria-label="Buka Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="topbar-left">
                    <h1>Transaksi Peminjaman &amp; Pengembalian Buku</h1>
                    <p>Sistem Informasi Inventori Material PT PLN Indonesia Power UBP Asam Asam</p>
                </div>
            </div>

            <!-- Profile: Dinamis sesuai user yang sedang login -->
            <a href="{{ route('profile.show') }}" class="topbar-user" title="Buka Profil Pengguna" data-spa-link>
                <div class="topbar-user-detail">
                    <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                    <div class="topbar-user-email">{{ Auth::user()->email }}</div>
                    <span class="badge-role">{{ Auth::user()->role }}</span>
                </div>
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </a>
        </header>

        <!-- Main Page Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert-box alert-success">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-error">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#FDF2F4; color:#B46A72;">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Transaksi</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#EFF6FF; color:#1D4ED8;">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['active'] }}</div>
                        <div class="stat-label">Sedang Berlangsung</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#FEF2F2; color:#B91C1C;">
                        <span class="material-symbols-outlined">alarm</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['overdue'] }}</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#ECFDF5; color:#047857;">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['returned'] }}</div>
                        <div class="stat-label">Sudah Dikembalikan</div>
                    </div>
                </div>
            </div>

            <!-- Status Tabs -->
            <div class="status-tabs-container">
                <a href="{{ route('book-loans.index', ['status' => 'all', 'search' => $search, 'per_page' => $perPage]) }}"
                   class="status-tab-btn {{ ($tab === 'all' || !$tab) ? 'active' : '' }}">
                    <span class="material-symbols-outlined" style="font-size:16px;">list_alt</span>
                    <span>Semua Peminjaman</span>
                    <span class="tab-counter">{{ $stats['total'] }}</span>
                </a>

                <a href="{{ route('book-loans.index', ['status' => 'Dipinjam', 'search' => $search, 'per_page' => $perPage]) }}"
                   class="status-tab-btn {{ ($tab === 'Dipinjam' || $tab === 'active') ? 'active' : '' }}">
                    <span class="material-symbols-outlined" style="font-size:16px;">hourglass_top</span>
                    <span>Sedang Berlangsung</span>
                    <span class="tab-counter">{{ $stats['active'] }}</span>
                </a>

                <a href="{{ route('book-loans.index', ['status' => 'Terlambat', 'search' => $search, 'per_page' => $perPage]) }}"
                   class="status-tab-btn {{ ($tab === 'Terlambat' || $tab === 'overdue') ? 'active' : '' }}"
                   style="{{ $stats['overdue'] > 0 ? 'color:#B91C1C; border-color:#FECACA;' : '' }}">
                    <span class="material-symbols-outlined" style="font-size:16px;">warning</span>
                    <span>Terlambat</span>
                    <span class="tab-counter" style="{{ $stats['overdue'] > 0 ? 'background:#FEE2E2; color:#B91C1C;' : '' }}">
                        {{ $stats['overdue'] }}
                    </span>
                </a>

                <a href="{{ route('book-loans.index', ['status' => 'Dikembalikan', 'search' => $search, 'per_page' => $perPage]) }}"
                   class="status-tab-btn {{ ($tab === 'Dikembalikan' || $tab === 'returned') ? 'active' : '' }}">
                    <span class="material-symbols-outlined" style="font-size:16px;">assignment_turned_in</span>
                    <span>Sudah Dikembalikan</span>
                    <span class="tab-counter">{{ $stats['returned'] }}</span>
                </a>
            </div>

            <!-- Table Card -->
            <div class="data-card">
                <div class="card-header-bar">
                    <div class="card-title">
                        <span class="material-symbols-outlined" style="color:var(--blue);">menu_book</span>
                        <span>Daftar Transaksi Peminjaman &amp; Pengembalian Buku</span>
                    </div>

                    <div class="filter-controls">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('book-loans.index') }}" style="display:flex; gap:8px;">
                            <input type="hidden" name="status" value="{{ $tab }}">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <div class="search-box">
                                <span class="material-symbols-outlined search-icon">search</span>
                                <input type="text" name="search" id="loanSearchInput" placeholder="Cari nama peminjam, buku, divisi..." value="{{ $search ?? '' }}" autocomplete="off">
                            </div>

                            @if($search)
                                <a href="{{ route('book-loans.index', ['status' => $tab, 'per_page' => $perPage]) }}" class="btn-secondary">Reset</a>
                            @endif
                        </form>

                        <button type="button" class="btn-primary" onclick="openCreateLoanModal()">
                            <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                            <span>Peminjaman Baru</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th style="width: 45px;">No</th>
                                <th>Peminjam</th>
                                <th>Bagian / Divisi</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Batas Pengembalian</th>
                                <th>Jumlah Buku</th>
                                <th>Status</th>
                                <th style="text-align: right; width: 170px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $index => $loan)
                                <tr>
                                    <td>{{ $loans->firstItem() + $index }}</td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text-dark);">{{ $loan->borrower_name }}</div>
                                        @if($loan->borrower_phone)
                                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">{{ $loan->borrower_phone }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="color: var(--text-mid);">{{ $loan->borrower_department ?: '-' }}</span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text-dark);">
                                            {{ $loan->book->title ?? 'Buku Dihapus' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; font-weight: 500;">
                                            {{ $loan->loan_date ? \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; font-weight: 600;">
                                            {{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y') : '-' }}
                                        </div>
                                        @if($loan->return_date)
                                            <div style="font-size: 11px; color: #047857; margin-top: 2px;">
                                                Kembali: {{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-weight: 600;">{{ $loan->quantity }} Eksemplar</span>
                                    </td>
                                    <td>
                                        @if($loan->status === 'Dikembalikan')
                                            <span class="status-badge status-dikembalikan">
                                                <span class="material-symbols-outlined" style="font-size:14px;">check_circle</span>
                                                Dikembalikan
                                            </span>
                                        @elseif($loan->status === 'Terlambat')
                                            <span class="status-badge status-terlambat">
                                                <span class="material-symbols-outlined" style="font-size:14px;">warning</span>
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="status-badge status-dipinjam">
                                                <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btns" style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            @if($loan->status === 'Dikembalikan')
                                                <button type="button" class="btn-detail" title="Lihat Detail Transaksi"
                                                        onclick='openDetailLoanModal(@json($loan))'>
                                                    <span class="material-symbols-outlined" style="font-size:15px;">visibility</span>
                                                    <span>Detail</span>
                                                </button>
                                            @else
                                                <button type="button" class="btn-return" title="Proses Pengembalian Buku"
                                                        onclick='openReturnLoanModal(@json($loan))'>
                                                    <span class="material-symbols-outlined" style="font-size:15px;">assignment_turned_in</span>
                                                    <span>Proses Pengembalian</span>
                                                </button>
                                            @endif

                                            <button type="button" class="btn-action" title="Edit Transaksi"
                                                    onclick='openEditLoanModal(@json($loan))'>
                                                <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                            </button>

                                            <button type="button" class="btn-action btn-action-delete" title="Hapus Transaksi"
                                                    onclick="openDeleteLoanModal({{ $loan->id }}, '{{ addslashes(($loan->book->title ?? 'Buku') . ' - ' . $loan->borrower_name) }}')">
                                                <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 36px; color: var(--text-muted);">
                                        <span class="material-symbols-outlined" style="font-size: 40px; margin-bottom: 8px; color: #CBD5E1;">assignment</span>
                                        <p>Tidak ada transaksi peminjaman &amp; pengembalian pada kategori ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="table-footer-left">
                        <div class="data-info">
                            @if ($perPage === 'all' || $perPage === 'Semua')
                                Menampilkan <strong>1–{{ $loans->total() }}</strong> dari <strong>{{ $loans->total() }}</strong> transaksi
                            @elseif ($loans->total() > 0)
                                Menampilkan <strong>{{ $loans->firstItem() ?? 0 }}–{{ $loans->lastItem() ?? 0 }}</strong> dari <strong>{{ $loans->total() }}</strong> transaksi
                            @else
                                Menampilkan <strong>0</strong> transaksi
                            @endif
                        </div>

                        <div class="per-page-select">
                            <label for="per_page_select">Tampilkan:</label>
                            <select id="per_page_select" onchange="changePerPage(this.value)">
                                <option value="10" {{ (string)$perPage === '10' ? 'selected' : '' }}>10 data per halaman</option>
                                <option value="25" {{ (string)$perPage === '25' || empty($perPage) ? 'selected' : '' }}>25 data per halaman</option>
                                <option value="50" {{ (string)$perPage === '50' ? 'selected' : '' }}>50 data per halaman</option>
                                <option value="100" {{ (string)$perPage === '100' ? 'selected' : '' }}>100 data per halaman</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-footer-pagination">
                        {{ $loans->onEachSide(1)->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>

<!-- Modal Catat Peminjaman Baru -->
<div id="createLoanModal" class="modal-backdrop">
    <div class="modal-card">
        <form method="POST" action="{{ route('book-loans.store') }}">
            @csrf
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">note_add</span>
                    Catat Peminjaman Buku Baru
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeCreateLoanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="create_book_id">Pilih Buku yang Dipinjam *</label>
                    <select id="create_book_id" name="book_id" class="form-control" required>
                        <option value="">-- Pilih Judul Buku (Stok Tersedia) --</option>
                        @foreach($availableBooks as $ab)
                            <option value="{{ $ab->id }}" {{ request('quick_book_id') == $ab->id ? 'selected' : '' }}>
                                [{{ $ab->book_code }}] {{ $ab->title }} (Sisa: {{ $ab->available_stock }} Eksemplar)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_borrower_name">Nama Peminjam *</label>
                        <input type="text" id="create_borrower_name" name="borrower_name" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="form-group">
                        <label for="create_borrower_department">Divisi / Bagian</label>
                        <input type="text" id="create_borrower_department" name="borrower_department" class="form-control" placeholder="Contoh: Operasi PLTU Unit 1">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_borrower_phone">No. Telepon / WhatsApp</label>
                        <input type="text" id="create_borrower_phone" name="borrower_phone" class="form-control" placeholder="0812xxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="create_quantity">Jumlah Buku (Eksemplar) *</label>
                        <input type="number" id="create_quantity" name="quantity" class="form-control" required min="1" value="1">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_loan_date">Tanggal Pinjam *</label>
                        <input type="date" id="create_loan_date" name="loan_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="create_due_date">Tanggal Rencana Pengembalian *</label>
                        <input type="date" id="create_due_date" name="due_date" class="form-control" required value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="create_notes">Catatan Peminjaman</label>
                    <textarea id="create_notes" name="notes" class="form-control" placeholder="Keterangan peruntukan buku atau catatan lainnya"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCreateLoanModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan & Perbarui Stok</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Proses Pengembalian Buku -->
<div id="returnLoanModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="returnLoanForm" method="POST" action="">
            @csrf
            <div class="modal-header">
                <h3 style="color:#059669;">
                    <span class="material-symbols-outlined" style="color:#059669;">assignment_turned_in</span>
                    Proses Pengembalian Buku
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeReturnLoanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div style="background:#FDF7F8; padding:14px; border-radius:8px; margin-bottom:16px; border:1px solid var(--border);">
                    <div style="font-size:12px; color:var(--text-muted);">Judul Buku:</div>
                    <div style="font-weight:700; color:var(--text-dark);" id="returnBookTitle">-</div>
                    <div style="font-size:12px; margin-top:6px; color:var(--text-mid);">
                        Peminjam: <strong id="returnBorrowerName">-</strong> &bull; Jumlah: <strong id="returnQuantity">1</strong> Eksemplar
                    </div>
                </div>

                <div class="form-group">
                    <label for="return_date">Tanggal Aktual Pengembalian *</label>
                    <input type="date" id="return_date" name="return_date" class="form-control" required value="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="return_notes">Catatan Kondisi Buku saat Dikembalikan</label>
                    <textarea id="return_notes" name="notes" class="form-control" placeholder="Contoh: Buku dikembalikan lengkap dan dalam kondisi sangat baik."></textarea>
                </div>

                <p style="font-size:12px; color:#059669; font-weight:600;">
                    <span class="material-symbols-outlined" style="font-size:14px; vertical-align:middle;">info</span>
                    Stok buku yang tersedia akan otomatis bertambah kembali setelah formulir disimpan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeReturnLoanModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background:#059669;">Konfirmasi Pengembalian</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Transaksi Peminjaman -->
<div id="editLoanModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="editLoanForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">edit_note</span>
                    Edit Data Peminjaman
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeEditLoanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_borrower_name">Nama Peminjam *</label>
                        <input type="text" id="edit_borrower_name" name="borrower_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_borrower_department">Divisi / Bagian</label>
                        <input type="text" id="edit_borrower_department" name="borrower_department" class="form-control">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_borrower_phone">No. Telepon / WhatsApp</label>
                        <input type="text" id="edit_borrower_phone" name="borrower_phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_due_date">Tanggal Rencana Pengembalian *</label>
                        <input type="date" id="edit_due_date" name="due_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_loan_date">Tanggal Pinjam *</label>
                    <input type="date" id="edit_loan_date" name="loan_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_notes">Catatan Transaksi</label>
                    <textarea id="edit_notes" name="notes" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditLoanModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Transaksi -->
<div id="deleteLoanModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="deleteLoanForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h3 style="color:var(--red);">
                    <span class="material-symbols-outlined" style="color:var(--red);">warning</span>
                    Konfirmasi Hapus Transaksi
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeDeleteLoanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan/menghapus transaksi peminjaman <strong id="deleteLoanCode"></strong>?</p>
                <p style="font-size:12px; color:var(--text-muted); margin-top:8px;">
                    Jika transaksi masih berstatus aktif, stok buku yang dipinjam akan otomatis dikembalikan ke katalog.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeDeleteLoanModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background:var(--red);">Hapus Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Riwayat Transaksi -->
<div id="detailLoanModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 600px;">
        <div class="modal-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <span class="material-symbols-outlined" style="color:var(--blue); font-size:24px;">receipt_long</span>
                <div>
                    <h3 style="margin:0; font-size:16px;">Detail Riwayat Transaksi</h3>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <span id="detail_status_badge" class="status-badge"></span>
                <button type="button" class="modal-close-btn" onclick="closeDetailLoanModal()">&times;</button>
            </div>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item" style="grid-column: span 2;">
                    <div class="detail-label">Judul Buku</div>
                    <div class="detail-value" id="detail_book_title" style="font-size:14px; color:var(--blue-dark);">-</div>
                    <div style="display:flex; gap:16px; margin-top:6px; font-size:12px; color:var(--text-muted);">
                        <span>Kategori: <strong id="detail_book_category" style="color:var(--text-dark);">-</strong></span>
                        <span>Jumlah: <strong id="detail_quantity" style="color:var(--text-dark);">-</strong></span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Nama Peminjam</div>
                    <div class="detail-value" id="detail_borrower_name">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Bagian / Divisi</div>
                    <div class="detail-value" id="detail_borrower_dept">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">No. Telepon / WhatsApp</div>
                    <div class="detail-value" id="detail_borrower_phone">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Petugas Pencatat</div>
                    <div class="detail-value" id="detail_handler_name">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Tanggal Peminjaman</div>
                    <div class="detail-value" id="detail_loan_date">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Batas Waktu Pengembalian</div>
                    <div class="detail-value" id="detail_due_date">-</div>
                </div>

                <div class="detail-item" style="grid-column: span 2;">
                    <div class="detail-label">Tanggal Pengembalian</div>
                    <div class="detail-value" id="detail_return_date" style="color:#047857;">-</div>
                </div>

                <div class="detail-item" style="grid-column: span 2;">
                    <div class="detail-label">Catatan Transaksi / Kondisi Pengembalian</div>
                    <div class="detail-value" id="detail_notes" style="font-weight:normal; color:var(--text-mid);">-</div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDetailLoanModal()">Tutup</button>
        </div>
    </div>
</div>

    <!-- JAVASCRIPT LOGIC (Di dalam <main> untuk kompatibilitas SPA) -->
    <script>
        (function() {
            if (window._bookLoansPageController) {
                try { window._bookLoansPageController.abort(); } catch (e) {}
            }
            window._bookLoansPageController = new AbortController();
            const signal = window._bookLoansPageController.signal;
            window.openSidebar = function() {
                const s = document.getElementById('sidebar');
                const d = document.getElementById('drawerBackdrop');
                if (s) s.classList.add('open');
                if (d) d.classList.add('open');
                document.body.style.overflow = 'hidden';
            };
            window.closeSidebar = function() {
                const s = document.getElementById('sidebar');
                const d = document.getElementById('drawerBackdrop');
                if (s) s.classList.remove('open');
                if (d) d.classList.remove('open');
                document.body.style.overflow = '';
            };

            function formatDateIndo(dateStr) {
                if (!dateStr) return '-';
                const parts = dateStr.substring(0, 10).split('-');
                if (parts.length !== 3) return dateStr;
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const monthIndex = parseInt(parts[1], 10) - 1;
                return `${parseInt(parts[2], 10)} ${months[monthIndex] || parts[1]} ${parts[0]}`;
            }

            window.openCreateLoanModal = function() {
                const m = document.getElementById('createLoanModal');
                if (m) m.classList.add('show');
            };
            window.closeCreateLoanModal = function() {
                const m = document.getElementById('createLoanModal');
                if (m) m.classList.remove('show');
            };

            window.openReturnLoanModal = function(loan) {
                const form = document.getElementById('returnLoanForm');
                if (!form) return;
                form.action = `/book-loans/${loan.id}/return`;
                const titleEl = document.getElementById('returnBookTitle');
                if (titleEl) titleEl.textContent = loan.book ? loan.book.title : '-';
                const borrowerEl = document.getElementById('returnBorrowerName');
                if (borrowerEl) borrowerEl.textContent = loan.borrower_name;
                const qtyEl = document.getElementById('returnQuantity');
                if (qtyEl) qtyEl.textContent = loan.quantity;
                const m = document.getElementById('returnLoanModal');
                if (m) m.classList.add('show');
            };
            window.closeReturnLoanModal = function() {
                const m = document.getElementById('returnLoanModal');
                if (m) m.classList.remove('show');
            };

            window.openDetailLoanModal = function(loan) {
                const setText = (id, text) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = text || '-';
                };
                setText('detail_book_title', loan.book ? loan.book.title : 'Buku Dihapus');
                setText('detail_book_category', loan.book && loan.book.category ? loan.book.category : '-');
                setText('detail_quantity', (loan.quantity || 1) + ' Eksemplar');
                setText('detail_borrower_name', loan.borrower_name);
                setText('detail_borrower_dept', loan.borrower_department || '-');
                setText('detail_borrower_phone', loan.borrower_phone || '-');
                setText('detail_loan_date', formatDateIndo(loan.loan_date));
                setText('detail_due_date', formatDateIndo(loan.due_date));
                setText('detail_return_date', loan.return_date ? formatDateIndo(loan.return_date) : '-');
                setText('detail_handler_name', loan.handler ? loan.handler.name : '-');
                setText('detail_notes', loan.notes || 'Tidak ada catatan transaksi.');

                const statusBadge = document.getElementById('detail_status_badge');
                if (statusBadge) {
                    if (loan.status === 'Dikembalikan') {
                        statusBadge.className = 'status-badge status-dikembalikan';
                        statusBadge.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px;">check_circle</span> Sudah Dikembalikan';
                    } else if (loan.status === 'Terlambat') {
                        statusBadge.className = 'status-badge status-terlambat';
                        statusBadge.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px;">warning</span> Terlambat';
                    } else {
                        statusBadge.className = 'status-badge status-dipinjam';
                        statusBadge.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px;">schedule</span> Sedang Berlangsung';
                    }
                }

                const m = document.getElementById('detailLoanModal');
                if (m) m.classList.add('show');
            };
            window.closeDetailLoanModal = function() {
                const m = document.getElementById('detailLoanModal');
                if (m) m.classList.remove('show');
            };

            window.openEditLoanModal = function(loan) {
                const form = document.getElementById('editLoanForm');
                if (!form) return;
                form.action = `/book-loans/${loan.id}`;
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.value = val;
                };
                setVal('edit_borrower_name', loan.borrower_name);
                setVal('edit_borrower_department', loan.borrower_department || '');
                setVal('edit_borrower_phone', loan.borrower_phone || '');
                setVal('edit_loan_date', loan.loan_date ? loan.loan_date.substring(0, 10) : '');
                setVal('edit_due_date', loan.due_date ? loan.due_date.substring(0, 10) : '');
                setVal('edit_notes', loan.notes || '');
                const m = document.getElementById('editLoanModal');
                if (m) m.classList.add('show');
            };
            window.closeEditLoanModal = function() {
                const m = document.getElementById('editLoanModal');
                if (m) m.classList.remove('show');
            };

            window.openDeleteLoanModal = function(id, code) {
                const form = document.getElementById('deleteLoanForm');
                if (!form) return;
                form.action = `/book-loans/${id}`;
                const codeEl = document.getElementById('deleteLoanCode');
                if (codeEl) codeEl.textContent = `#${code}`;
                const m = document.getElementById('deleteLoanModal');
                if (m) m.classList.add('show');
            };
            window.closeDeleteLoanModal = function() {
                const m = document.getElementById('deleteLoanModal');
                if (m) m.classList.remove('show');
            };

            @if(request('quick_book_id'))
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', () => {
                        window.openCreateLoanModal();
                    }, { signal });
                } else {
                    window.openCreateLoanModal();
                }
            @endif

            // Klik backdrop modal untuk menutup
            document.addEventListener('click', function(e) {
                ['createLoanModal', 'returnLoanModal', 'detailLoanModal', 'editLoanModal', 'deleteLoanModal'].forEach(id => {
                    const m = document.getElementById(id);
                    if (m && e.target === m) m.classList.remove('show');
                });
            }, { signal });

            // Tombol Escape untuk menutup modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    ['createLoanModal', 'returnLoanModal', 'detailLoanModal', 'editLoanModal', 'deleteLoanModal'].forEach(id => {
                        const m = document.getElementById(id);
                        if (m && m.classList.contains('show')) m.classList.remove('show');
                    });
                }
            }, { signal });
        })();
    </script>
    </main>
</div>
</body>
</html>
