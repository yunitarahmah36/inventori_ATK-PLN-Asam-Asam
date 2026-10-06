<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Data Material - Inventori ATK PLN Asam-Asam</title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        /* ============================================================
           RESET & CSS VARIABLES
        ============================================================ */
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
            --green:        #10B981;
            --green-light:  #D1FAE5;
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
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }
        button, select, input { font-family: inherit; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        /* ============================================================
           LAYOUT
        ============================================================ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

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
            padding: 0;
            z-index: 200;
            transition: transform var(--transition);
        }

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
            line-height: 1.2;
        }

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
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

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
            letter-spacing: 0.8px;
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
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,0.14);
            color: #fff;
        }

        .nav-item.active {
            font-weight: 700;
            color: var(--yellow);
        }

        .nav-item .material-symbols-outlined {
            font-size: 20px;
            flex-shrink: 0;
        }

        .nav-submenu {
            display: block;
            padding-left: 32px;
            margin: 2px 0;
        }

        .nav-sub-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 12.5px;
            color: rgba(255,255,255,0.7);
            transition: var(--transition);
        }

        .nav-sub-item:hover, .nav-sub-item.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .nav-sub-item.active {
            color: var(--yellow);
            font-weight: 600;
        }

        .nav-sub-item .material-symbols-outlined {
            font-size: 16px;
        }

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
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: #DC2626;
            color: #fff;
        }

        .btn-logout .material-symbols-outlined {
            font-size: 19px;
        }

        /* ============================================================
           MAIN CONTENT
        ============================================================ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* ============================================================
           TOPBAR
        ============================================================ */
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

        .topbar-left {
            display: flex;
            flex-direction: column;
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

        .topbar-user-detail {
            text-align: right;
        }

        .topbar-user-name {
            font-size: 13px;
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
            font-size: 10px;
            font-weight: 700;
            padding: 1px 7px;
            border-radius: 20px;
            background: var(--blue-light);
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
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
            border-radius: 6px;
        }

        /* ============================================================
           PAGE CONTENT
        ============================================================ */
        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
        }

        /* Flash Message */
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: var(--green-light);
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-close {
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            display: flex;
            align-items: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Card */
        .header-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px 24px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .header-card-title h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            letter-spacing: -0.3px;
        }

        .header-card-title p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 87, 184, 0.25);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            color: #fff;
        }

        .btn-yellow {
            background: var(--yellow);
            color: var(--blue-dark);
            font-weight: 700;
        }

        .btn-yellow:hover {
            background: #E5AC00;
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: #F9FAFB;
            border-color: #CBD5E1;
            color: var(--text-dark);
        }

        .btn-icon-only {
            padding: 6px;
            border-radius: 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-edit {
            background: var(--blue-light);
            color: var(--blue);
            border: 1px solid #BFDBFE;
        }

        .btn-edit:hover {
            background: var(--blue);
            color: #fff;
        }

        .btn-delete {
            background: var(--red-light);
            color: var(--red);
            border: 1px solid #FECACA;
        }

        .btn-delete:hover {
            background: var(--red);
            color: #fff;
        }

        /* ============================================================
           FILTER & SEARCH BAR
        ============================================================ */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 16px 20px;
            border: 1px solid var(--border);
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 240px;
        }

        .search-box .material-symbols-outlined {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 19px;
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            padding: 9px 12px 9px 38px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            color: var(--text-dark);
            outline: none;
            transition: var(--transition);
            background: #FAFBFD;
        }

        .search-box input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.1);
        }

        .date-input-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-input-group label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .date-input-group input[type="date"] {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 12.5px;
            color: var(--text-dark);
            background: #FAFBFD;
            outline: none;
        }

        .date-input-group input[type="date"]:focus {
            border-color: var(--blue);
            background: #fff;
        }

        /* ============================================================
           DATA TABLE CARD
        ============================================================ */
        .table-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        table.data-table thead {
            background: #F8FAFC;
            border-bottom: 2px solid var(--border);
        }

        table.data-table th {
            padding: 13px 18px;
            font-weight: 700;
            color: var(--text-mid);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }

        table.data-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background var(--transition);
        }

        table.data-table tbody tr:hover {
            background: #F9FBFF;
        }

        table.data-table td {
            padding: 14px 18px;
            vertical-align: middle;
            color: var(--text-dark);
        }

        /* Badges */
        .badge-material-number {
            display: inline-block;
            font-weight: 700;
            font-size: 12px;
            color: var(--blue-dark);
            background: var(--blue-light);
            padding: 3px 9px;
            border-radius: 6px;
            border: 1px solid #BFDBFE;
            letter-spacing: 0.4px;
        }

        .qty-badge {
            font-weight: 700;
            color: var(--blue);
            font-size: 14px;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Empty State */
        .empty-state {
            padding: 56px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-state .material-symbols-outlined {
            font-size: 54px;
            color: #94A3B8;
            margin-bottom: 14px;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-muted);
            max-width: 420px;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        /* ============================================================
           PAGINATION & FOOTER
        ============================================================ */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            background: #FAFBFD;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-footer-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .data-info {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .data-info strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .per-page-select {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--text-muted);
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
        }

        .per-page-select select:focus {
            border-color: var(--blue);
        }

        .pagination-simple {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-page {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 7px 14px;
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 600;
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-page:hover:not(.disabled) {
            background: var(--blue-light);
            border-color: #BFDBFE;
            color: var(--blue);
        }

        .btn-page.disabled {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
            background: #F1F5F9;
        }

        /* ============================================================
           DRAWER & BOTTOM NAV (Mobile)
        ============================================================ */
        .drawer-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 199;
        }

        .bottom-nav {
            display: none;
            position: fixed;
            inset: auto 0 0 0;
            height: 60px;
            background: #fff;
            border-top: 1px solid var(--border);
            z-index: 100;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.06);
        }

        .bottom-nav-inner {
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: space-around;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            font-size: 10.5px;
            font-weight: 600;
            color: var(--text-muted);
            padding: 6px 12px;
            border-radius: 8px;
            transition: color var(--transition);
        }

        .bottom-nav-item.active {
            color: var(--blue);
        }

        .bottom-nav-item .material-symbols-outlined {
            font-size: 22px;
        }

        /* ============================================================
           RESPONSIVE (Max 768px)
        ============================================================ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .drawer-backdrop.open {
                display: block;
            }

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
                padding: 16px 16px 80px;
            }

            .header-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
                justify-content: center;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .date-input-group {
                flex-direction: column;
                align-items: stretch;
            }

            .date-input-group input[type="date"] {
                width: 100%;
            }

            .table-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .table-footer-left {
                justify-content: space-between;
            }

            .pagination-simple {
                justify-content: space-between;
                width: 100%;
            }

            .pagination-simple .btn-page {
                flex: 1;
                justify-content: center;
            }

            .bottom-nav {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Backdrop Mobile -->
    <div class="drawer-backdrop" id="drawerBackdrop" onclick="closeSidebar()"></div>

    <div class="layout">

        <!-- SIDEBAR -->
        @include('partials.sidebar')


        <!-- ============================================================
             MAIN CONTENT
        ============================================================ -->
        <main class="main">

            <!-- Topbar Header -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Data Material</h1>
                        <p>Kelola data material ATK PLN Asam-Asam</p>
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

                <!-- Notifikasi Flash Message -->
                @if (session('success'))
                    <div class="alert alert-success" id="alertSuccess">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="alert-close" onclick="document.getElementById('alertSuccess').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                <!-- Header Card dengan Tombol Aksi Utama -->
                <div class="header-card">
                    <div class="header-card-title">
                        <h2>Data Material</h2>
                        <p>Kelola data material ATK PLN Asam-Asam</p>
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('materials.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size:19px;">add</span>
                            + Tambah Material
                        </a>

                        <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                            <span class="material-symbols-outlined" style="font-size:19px;">upload_file</span>
                            Import Excel
                        </a>

                        <a href="{{ route('materials.export', request()->query()) }}" class="btn btn-outline">
                            <span class="material-symbols-outlined" style="font-size:19px;">download</span>
                            Export Excel
                        </a>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('materials.index') }}" class="filter-form" id="filterForm">
                        <!-- Pertahankan per_page jika ada -->
                        <input type="hidden" name="per_page" value="{{ $perPage }}">

                        <!-- Input Pencarian -->
                        <div class="search-box">
                            <span class="material-symbols-outlined">search</span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}" 
                                placeholder="Cari no material atau nama material..."
                                autocomplete="off"
                            >
                        </div>

                        <!-- Filter Tanggal Masuk -->
                        <div class="date-input-group">
                            <label for="start_date">Mulai:</label>
                            <input 
                                type="date" 
                                id="start_date" 
                                name="start_date" 
                                value="{{ $startDate }}"
                            >
                        </div>

                        <div class="date-input-group">
                            <label for="end_date">Selesai:</label>
                            <input 
                                type="date" 
                                id="end_date" 
                                name="end_date" 
                                value="{{ $endDate }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary" style="padding: 8px 14px;">
                            <span class="material-symbols-outlined" style="font-size:18px;">filter_alt</span>
                            Filter
                        </button>

                        @if (!empty($search) || !empty($startDate) || !empty($endDate))
                            <a href="{{ route('materials.index', ['per_page' => $perPage]) }}" class="btn btn-outline" style="padding: 8px 14px;">
                                <span class="material-symbols-outlined" style="font-size:18px;">restart_alt</span>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Data Table Card -->
                <div class="table-card">
                    @if ($materials->count() > 0)
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 140px;">No Material</th>
                                        <th>Nama Material</th>
                                        <th style="width: 140px;">Tanggal Masuk</th>
                                        <th style="width: 130px;">Jumlah Item</th>
                                        <th style="width: 100px;">Satuan</th>
                                        <th style="width: 110px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $startNumber = ($materials->currentPage() - 1) * $materials->perPage();
                                    @endphp
                                    @foreach ($materials as $index => $mat)
                                        <tr>
                                            <td>{{ $startNumber + $loop->iteration }}</td>
                                            <td>
                                                <span class="badge-material-number">{{ $mat->material_number }}</span>
                                            </td>
                                            <td style="font-weight: 600;">
                                                {{ $mat->name }}
                                                @if (!empty($mat->description))
                                                    <div style="font-size: 11.5px; color: var(--text-muted); font-weight: normal; margin-top: 2px;">
                                                        {{ $mat->description }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $mat->entry_date ? $mat->entry_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                <span class="qty-badge">{{ number_format($mat->quantity, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: var(--text-mid);">{{ $mat->unit }}</span>
                                            </td>
                                            <td>
                                                <div class="actions-cell" style="justify-content: center;">
                                                    <!-- Tombol Edit -->
                                                    <a 
                                                        href="{{ route('materials.edit', $mat->id) }}" 
                                                        class="btn btn-icon-only btn-edit" 
                                                        title="Edit Material"
                                                    >
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <form 
                                                        action="{{ route('materials.destroy', $mat->id) }}" 
                                                        method="POST" 
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus material {{ $mat->name }} ({{ $mat->material_number }})?');"
                                                        style="display: inline;"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            type="submit" 
                                                            class="btn btn-icon-only btn-delete" 
                                                            title="Hapus Material"
                                                        >
                                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel: Informasi Data, Dropdown Per Page, & Navigasi Simple -->
                        <div class="table-footer">
                            <div class="table-footer-left">
                                <!-- Informasi Jumlah Data Dinamis -->
                                <div class="data-info">
                                    @if ($perPage === 'all' || $perPage === 'Semua')
                                        Menampilkan <strong>1–{{ $materials->total() }}</strong> dari <strong>{{ $materials->total() }}</strong> material
                                    @else
                                        Menampilkan <strong>{{ $materials->firstItem() ?? 0 }}–{{ $materials->lastItem() ?? 0 }}</strong> dari <strong>{{ $materials->total() }}</strong> material
                                    @endif
                                </div>

                                <!-- Dropdown Jumlah Baris Per Halaman -->
                                <div class="per-page-select">
                                    <label for="per_page_select">Tampilkan:</label>
                                    <select id="per_page_select" onchange="changePerPage(this.value)">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data per halaman</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 data per halaman</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data per halaman</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data per halaman</option>
                                        <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250 data per halaman</option>
                                        <option value="all" {{ ($perPage === 'all' || $perPage === 'Semua') ? 'selected' : '' }}>Semua data</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Navigasi Halaman Simpel (HANYA Sebelumnya & Berikutnya) -->
                            <div class="pagination-simple">
                                @if ($materials->onFirstPage())
                                    <span class="btn-page disabled">
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $materials->previousPageUrl() }}" class="btn-page">
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </a>
                                @endif

                                @if ($materials->hasMorePages())
                                    <a href="{{ $materials->nextPageUrl() }}" class="btn-page">
                                        Berikutnya
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </a>
                                @else
                                    <span class="btn-page disabled">
                                        Berikutnya
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                    @else
                        <!-- Empty State Jika Tidak Ada Material -->
                        <div class="empty-state">
                            <span class="material-symbols-outlined">inventory_2</span>
                            <h3>Belum ada data material</h3>
                            <p>Silakan tambahkan material baru atau import data melalui Excel.</p>
                            <div style="display:flex;gap:10px;">
                                <a href="{{ route('materials.create') }}" class="btn btn-primary">
                                    <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                                    + Tambah Material
                                </a>
                                <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                                    <span class="material-symbols-outlined" style="font-size:18px;">upload_file</span>
                                    Import Excel
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

        </main>

    </div>

    <!-- Bottom Nav (Mobile) -->
    <nav class="bottom-nav">
        <div class="bottom-nav-inner">
            <a href="{{ route('dashboard') }}" class="bottom-nav-item">
                <span class="material-symbols-outlined">speed</span>
                Dashboard
            </a>
            <a href="{{ route('materials.index') }}" class="bottom-nav-item active">
                <span class="material-symbols-outlined">inventory_2</span>
                Material
            </a>
            <a href="#" class="bottom-nav-item" onclick="alert('Halaman Riwayat Stok belum tersedia.')">
                <span class="material-symbols-outlined">history</span>
                Riwayat
            </a>
            <a href="#" class="bottom-nav-item" onclick="alert('Halaman Profile belum tersedia.')">
                <span class="material-symbols-outlined">account_circle</span>
                Profile
            </a>
        </div>
    </nav>

    <!-- JavaScript -->
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
            e.preventDefault();
            const menu  = document.getElementById(id);
            const arrow = document.getElementById('arrow-material');
            const isOpen = menu.style.display !== 'none';
            menu.style.display = isOpen ? 'none' : 'block';
            if (arrow) arrow.textContent = isOpen ? 'expand_more' : 'expand_less';
        }

        function changePerPage(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.delete('page'); // Reset ke page 1
            window.location.href = url.toString();
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>

</body>

</html>
