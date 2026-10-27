<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Data Buku & Ketersediaan Stok - PT PLN Indonesia Power UBP Asam Asam</title>
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

        /* Card & Filter */
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
            min-width: 220px;
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

        .filter-select {
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            background: var(--bg);
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--blue);
            background: var(--white);
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

        /* ============================================================
           DATA TABLE (Rapi, Proporsional, Profesional)
        ============================================================ */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-custom {
            width: 100%;
            min-width: 780px;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .table-custom thead th {
            background: #FDF5F7;
            padding: 13px 16px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border);
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-custom tbody tr {
            transition: background 0.15s ease;
        }

        .table-custom tbody tr:hover td {
            background: #FFF9FA;
        }

        .table-custom tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            vertical-align: middle;
            line-height: 1.45;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        /* Column Specific Styling & Alignment */
        .col-number {
            width: 56px;
            text-align: center;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 12.5px;
        }

        .col-book-info {
            min-width: 260px;
        }

        .book-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.4;
            word-break: break-word;
            margin-bottom: 3px;
        }

        .book-author {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            word-break: break-word;
        }

        .book-author .author-icon {
            font-size: 15px;
            color: var(--blue);
            vertical-align: middle;
        }

        .col-category {
            width: 160px;
        }

        .category-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            background: #FDF2F4;
            color: var(--blue);
            border: 1px solid #F7C8D3;
            font-size: 11.5px;
            font-weight: 600;
            word-break: break-word;
            line-height: 1.35;
        }

        .col-stock {
            width: 140px;
            text-align: center;
        }

        .stock-display {
            display: inline-flex;
            align-items: baseline;
            justify-content: center;
            gap: 4px;
            font-size: 13.5px;
            font-weight: 700;
        }

        .stock-avail-num {
            font-size: 14px;
            font-weight: 800;
        }

        .stock-avail-num.available { color: #059669; }
        .stock-avail-num.empty { color: #DC2626; }

        .stock-total-num {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        .col-status {
            width: 130px;
            text-align: center;
        }

        .stock-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .stock-available {
            background: #ECFDF5;
            color: #047857;
            border: 1px solid #A7F3D0;
        }

        .stock-empty {
            background: #FEF2F2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        .col-action {
            width: 130px;
            text-align: center;
        }

        .action-btns {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-mid);
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .btn-action-loan {
            color: #D97706;
            background: #FFFBEB;
            border-color: #FDE68A;
        }

        .btn-action-loan:hover {
            color: #B45309;
            background: #FEF3C7;
            border-color: #FCD34D;
        }

        .btn-action-edit {
            color: var(--blue);
            background: #FDF5F7;
            border-color: #F7C8D3;
        }

        .btn-action-edit:hover {
            color: var(--blue-dark);
            background: #FCE8ED;
            border-color: var(--blue);
        }

        .btn-action-delete {
            color: var(--red);
            background: #FEF2F2;
            border-color: #FECACA;
        }

        .btn-action-delete:hover {
            color: #991B1B;
            background: #FEE2E2;
            border-color: #F87171;
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
            max-width: 580px;
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
                    <h1>Data Buku &amp; Ketersediaan Stok</h1>
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
                        <span class="material-symbols-outlined">library_books</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total_titles'] }}</div>
                        <div class="stat-label">Total Judul Buku</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#EEF2FF; color:#6366F1;">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total_stock'] }}</div>
                        <div class="stat-label">Total Seluruh Eksemplar</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#ECFDF5; color:#059669;">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['available_stock'] }}</div>
                        <div class="stat-label">Stok Buku Tersedia</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#FEF3C7; color:#D97706;">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['borrowed_stock'] }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="data-card">
                <div class="card-header-bar">
                    <div class="card-title">
                        <span class="material-symbols-outlined" style="color:var(--blue);">menu_book</span>
                        <span>Katalog Koleksi Buku</span>
                    </div>

                    <div class="filter-controls">
                        <!-- Search & Filter Form -->
                        <form method="GET" action="{{ route('books.index') }}" style="display:flex; flex-wrap:wrap; gap:8px;">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <div class="search-box">
                                <span class="material-symbols-outlined search-icon">search</span>
                                <input type="text" name="search" id="bookSearchInput" placeholder="Cari judul dan penulis..." value="{{ $search ?? '' }}" autocomplete="off">
                            </div>

                            <select name="category" class="filter-select" onchange="this.form.requestSubmit ? this.form.requestSubmit() : this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ ($category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>

                            <select name="availability" class="filter-select" onchange="this.form.requestSubmit ? this.form.requestSubmit() : this.form.submit()">
                                <option value="">Semua Status Stok</option>
                                <option value="available" {{ ($availability ?? '') === 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="empty" {{ ($availability ?? '') === 'empty' ? 'selected' : '' }}>Stok Habis</option>
                            </select>

                            @if($search || $category || $availability)
                                <a href="{{ route('books.index', ['per_page' => $perPage]) }}" class="btn-secondary">Reset</a>
                            @endif
                        </form>

                        <button type="button" class="btn-primary" onclick="openCreateBookModal()">
                            <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                            <span>Tambah Buku</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th class="col-number">No</th>
                                <th class="col-book-info">Judul Buku &amp; Penulis</th>
                                <th class="col-category">Kategori</th>
                                <th class="col-stock">Stok Tersedia</th>
                                <th class="col-status">Status</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $index => $b)
                                <tr>
                                    <td class="col-number">{{ $books->firstItem() + $index }}</td>
                                    <td class="col-book-info">
                                        <div class="book-title">{{ $b->title }}</div>
                                        <div class="book-author">
                                            <span class="material-symbols-outlined author-icon">person</span>
                                            <span>{{ $b->author ?: 'Tidak disebutkan' }}</span>
                                        </div>
                                    </td>
                                    <td class="col-category">
                                        <span class="category-badge">
                                            {{ $b->category ?: 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="col-stock">
                                        <div class="stock-display">
                                            <span class="stock-avail-num {{ $b->available_stock > 0 ? 'available' : 'empty' }}">
                                                {{ $b->available_stock }}
                                            </span>
                                            <span class="stock-total-num">/ {{ $b->total_stock }} Eksemplar</span>
                                        </div>
                                    </td>
                                    <td class="col-status">
                                        @if($b->available_stock > 0)
                                            <span class="stock-pill stock-available">
                                                <span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span>
                                                <span>Tersedia</span>
                                            </span>
                                        @else
                                            <span class="stock-pill stock-empty">
                                                <span class="material-symbols-outlined" style="font-size: 14px;">cancel</span>
                                                <span>Dipinjam Semua</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="col-action">
                                        <div class="action-btns">
                                            @if($b->available_stock > 0)
                                                <a href="{{ route('book-loans.index', ['quick_book_id' => $b->id]) }}" class="btn-action btn-action-loan" title="Catat Peminjaman Buku Ini" data-spa-link>
                                                    <span class="material-symbols-outlined" style="font-size:16px;">assignment_add</span>
                                                </a>
                                            @endif

                                            <button type="button" class="btn-action btn-action-edit" title="Edit Data Buku"
                                                    onclick="openEditBookModal({{ json_encode($b) }})">
                                                <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                            </button>

                                            <button type="button" class="btn-action btn-action-delete" title="Hapus Buku"
                                                    onclick="openDeleteBookModal({{ $b->id }}, '{{ addslashes($b->title) }}')">
                                                <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px 16px; color: var(--text-muted);">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                                            <span class="material-symbols-outlined" style="font-size: 44px; color: #CBD5E1;">menu_book</span>
                                            <p style="font-size: 13.5px; font-weight: 500; margin: 0;">Belum ada data buku yang sesuai dengan pencarian atau filter.</p>
                                        </div>
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
                                Menampilkan <strong>1–{{ $books->total() }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                            @elseif ($books->total() > 0)
                                Menampilkan <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                            @else
                                Menampilkan <strong>0</strong> buku
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
                        {{ $books->onEachSide(1)->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>

<!-- Modal Tambah Buku -->
<div id="createBookModal" class="modal-backdrop">
    <div class="modal-card">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">add_box</span>
                    Tambah Buku Baru
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeCreateBookModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="create_title">Judul Buku *</label>
                    <input type="text" id="create_title" name="title" class="form-control" required placeholder="Masukkan judul buku lengkap">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_author">Penulis / Pengarang</label>
                        <input type="text" id="create_author" name="author" class="form-control" placeholder="Nama penulis">
                    </div>
                    <div class="form-group">
                        <label for="create_category">Kategori</label>
                        <input type="text" id="create_category" name="category" class="form-control" placeholder="Contoh: K3 & Lingkungan, Teknik & Operasi">
                    </div>
                </div>

                <div class="form-group">
                    <label for="create_total_stock">Jumlah Stok (Eksemplar) *</label>
                    <input type="number" id="create_total_stock" name="total_stock" class="form-control" required min="1" value="1">
                </div>

                <div class="form-group">
                    <label for="create_description">Deskripsi / Keterangan</label>
                    <textarea id="create_description" name="description" class="form-control" placeholder="Ringkasan isi buku atau catatan khusus"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCreateBookModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Buku -->
<div id="editBookModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="editBookForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">edit_note</span>
                    Edit Data Buku
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeEditBookModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_title">Judul Buku *</label>
                    <input type="text" id="edit_title" name="title" class="form-control" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_author">Penulis / Pengarang</label>
                        <input type="text" id="edit_author" name="author" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_category">Kategori</label>
                        <input type="text" id="edit_category" name="category" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_total_stock">Jumlah Stok Total (Eksemplar) *</label>
                    <input type="number" id="edit_total_stock" name="total_stock" class="form-control" required min="1">
                </div>

                <div class="form-group">
                    <label for="edit_description">Deskripsi</label>
                    <textarea id="edit_description" name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditBookModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Buku</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Buku -->
<div id="deleteBookModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="deleteBookForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h3 style="color:var(--red);">
                    <span class="material-symbols-outlined" style="color:var(--red);">warning</span>
                    Konfirmasi Hapus Buku
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeDeleteBookModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku <strong id="deleteBookTitle"></strong> dari katalog?</p>
                <p style="font-size:12px; color:var(--text-muted); margin-top:8px;">Buku hanya dapat dihapus jika tidak sedang memiliki transaksi peminjaman aktif.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeDeleteBookModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background:var(--red);">Hapus Buku</button>
            </div>
        </form>
    </div>
</div>

    <!-- JAVASCRIPT LOGIC (Di dalam <main> untuk kompatibilitas SPA) -->
    <script>
        (function() {
            if (window._booksPageController) {
                try { window._booksPageController.abort(); } catch (e) {}
            }
            window._booksPageController = new AbortController();
            const signal = window._booksPageController.signal;
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

            window.openCreateBookModal = function() {
                const m = document.getElementById('createBookModal');
                if (m) m.classList.add('show');
            };
            window.closeCreateBookModal = function() {
                const m = document.getElementById('createBookModal');
                if (m) m.classList.remove('show');
            };

            window.openEditBookModal = function(book) {
                const form = document.getElementById('editBookForm');
                if (!form) return;
                form.action = `/books/${book.id}`;
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.value = val;
                };
                setVal('edit_title', book.title);
                setVal('edit_author', book.author || '');
                setVal('edit_category', book.category || '');
                setVal('edit_total_stock', book.total_stock);
                setVal('edit_description', book.description || '');
                const m = document.getElementById('editBookModal');
                if (m) m.classList.add('show');
            };
            window.closeEditBookModal = function() {
                const m = document.getElementById('editBookModal');
                if (m) m.classList.remove('show');
            };

            window.openDeleteBookModal = function(id, title) {
                const form = document.getElementById('deleteBookForm');
                if (!form) return;
                form.action = `/books/${id}`;
                const titleEl = document.getElementById('deleteBookTitle');
                if (titleEl) titleEl.textContent = `"${title}"`;
                const m = document.getElementById('deleteBookModal');
                if (m) m.classList.add('show');
            };
            window.closeDeleteBookModal = function() {
                const m = document.getElementById('deleteBookModal');
                if (m) m.classList.remove('show');
            };

            // Klik backdrop modal untuk menutup
            document.addEventListener('click', function(e) {
                ['createBookModal', 'editBookModal', 'deleteBookModal'].forEach(id => {
                    const m = document.getElementById(id);
                    if (m && e.target === m) m.classList.remove('show');
                });
            }, { signal });

            // Tombol Escape untuk menutup modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    ['createBookModal', 'editBookModal', 'deleteBookModal'].forEach(id => {
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
