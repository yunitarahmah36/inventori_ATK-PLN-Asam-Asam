<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Data Material - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
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
            --blue: #0057B8;
            --blue-dark: #003B73;
            --blue-light: #EAF3FF;
            --yellow: #FFC107;
            --yellow-light: #FFF8E1;
            --bg: #F5F7FA;
            --white: #FFFFFF;
            --text-dark: #1F2937;
            --text-mid: #374151;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --red: #DC2626;
            --red-light: #FEE2E2;
            --green: #10B981;
            --green-light: #ECFDF5;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            --transition: 0.2s ease;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', Arial, sans-serif;
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

        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ALERTS */
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: var(--red-light);
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            opacity: 0.7;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* HEADER CARD */
        .header-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-card-title h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
            margin-bottom: 3px;
        }

        .header-card-title p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 8px;
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
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .btn-icon-only {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text-mid);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-edit:hover {
            background: var(--blue-light);
            color: var(--blue);
            border-color: var(--blue);
        }

        .btn-delete:hover {
            background: var(--red-light);
            color: var(--red);
            border-color: var(--red);
        }

        /* FILTER CARD */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 16px 20px;
            margin-bottom: 20px;
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
            min-width: 260px;
        }

        .search-box .material-symbols-outlined {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            padding: 9px 12px 9px 38px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            color: var(--text-dark);
            background: #fff;
            outline: none;
            transition: var(--transition);
        }

        .search-box input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .filter-select-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-mid);
            font-weight: 600;
        }

        .filter-select-group select {
            padding: 9px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            color: var(--text-dark);
            background: #fff;
            outline: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-select-group select:focus {
            border-color: var(--blue);
        }

        /* BULK TOOLBAR */
        .bulk-toolbar {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            background: var(--blue-dark);
            border-radius: var(--radius);
            margin-bottom: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.18);
            animation: bulkToolbarIn 0.18s ease-out;
        }

        .bulk-toolbar.visible {
            display: flex;
        }

        @keyframes bulkToolbarIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .bulk-count-badge {
            background: var(--yellow);
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .bulk-toolbar-label {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            flex: 1;
        }

        .btn-bulk-delete {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-bulk-delete:hover {
            background: #B91C1C;
        }

        .btn-bulk-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-bulk-cancel:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        /* TABLE */
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        .data-table thead tr {
            background: #F8FAFC;
            border-bottom: 2px solid var(--border);
        }

        .data-table th {
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--blue-dark);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text-dark);
        }

        .data-table tbody tr:hover {
            background: #F8FAFC;
        }

        .data-table tbody tr.row-selected {
            background: #EFF6FF !important;
        }

        .data-table tbody tr.row-inactive {
            background: #FAFBFD;
            opacity: 0.75;
        }

        .badge-material-number {
            display: inline-block;
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            background: #EFF6FF;
            color: var(--blue-dark);
            border: 1px solid #DBEAFE;
            letter-spacing: 0.02em;
        }

        .badge-status-inactive {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            background: #F3F4F6;
            color: #6B7280;
            border: 1px solid #E5E7EB;
            margin-left: 6px;
            text-transform: uppercase;
        }

        .cb-cell {
            width: 44px;
            text-align: center;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* TABLE FOOTER */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #fff;
            border-top: 1px solid var(--border);
            gap: 16px;
            flex-wrap: wrap;
        }

        .table-footer-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .data-info {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .per-page-select {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .per-page-select select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-dark);
            background: #fff;
            cursor: pointer;
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
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .btn-page:hover:not(.disabled) {
            background: var(--blue-light);
            color: var(--blue);
            border-color: var(--blue);
        }

        .btn-page.disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state .material-symbols-outlined {
            font-size: 48px;
            color: #94A3B8;
            margin-bottom: 12px;
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
            margin-bottom: 18px;
        }

        .empty-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* DELETE MODAL */
        .delete-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 20px;
        }

        .delete-modal.show {
            display: flex;
        }

        .delete-modal-box {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            animation: modalIn 0.2s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .delete-modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--red-light);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .delete-modal-icon .material-symbols-outlined {
            font-size: 30px;
        }

        .delete-modal-box h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .delete-modal-box p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .delete-modal-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .delete-modal-cancel {
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            cursor: pointer;
        }

        .delete-modal-confirm {
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            background: var(--red);
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
        }

        .delete-modal-confirm:hover {
            background: #B91C1C;
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
        }
    </style>
</head>

<body>

    <div class="layout">

        <!-- SIDEBAR -->
        @include('partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="main">

            <!-- Topbar Header -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Data Material</h1>
                        <p>Pendaftaran dan pengelolaan data master material ATK PT PLN Indonesia Power UBP Asam Asam</p>
                    </div>
                </div>

                <a href="{{ route('profile.show') }}" class="topbar-user" title="Buka Profil Pengguna">
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

            <div class="page-content">

                <!-- Notifikasi Flash Message -->
                @if (session('success'))
                    <div class="alert alert-success" id="alertSuccess">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertSuccess').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error" id="alertError">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertError').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error" id="alertValidationErrors">
                        <div style="display:flex;align-items:flex-start;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;margin-top:2px;">error</span>
                            <div>
                                <strong>Gagal memproses data:</strong>
                                <ul style="margin:4px 0 0 16px;padding:0;font-size:13px;">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertValidationErrors').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                <!-- Header Card dengan Tombol Aksi Utama -->
                <div class="header-card">
                    <div class="header-card-title">
                        <h2>Data Master Material</h2>
                        <p>Kelola identitas material (No. Material, Nama Material, dan Satuan)</p>
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('materials.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size:19px;">add</span>
                            Tambah Material
                        </a>

                        <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                            <span class="material-symbols-outlined" style="font-size:19px;">upload_file</span>
                            Import Excel
                        </a>

                        <a href="{{ route('materials.export', array_merge(['per_page' => $perPage], request()->query())) }}" class="btn btn-outline">
                            <span class="material-symbols-outlined" style="font-size:19px;">download</span>
                            Export Excel
                        </a>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('materials.index') }}" class="filter-form" id="filterForm">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">

                        <!-- Input Pencarian -->
                        <div class="search-box">
                            <span class="material-symbols-outlined">search</span>
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari No. Material atau Nama Material..." autocomplete="off">
                        </div>

                        <!-- Filter Status -->
                        <div class="filter-select-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua Material</option>
                                <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="padding: 8px 14px;">
                            <span class="material-symbols-outlined" style="font-size:18px;">search</span>
                            Cari
                        </button>

                        @if (!empty($search) || ($status ?? 'all') !== 'all')
                            <a href="{{ route('materials.index', ['per_page' => $perPage]) }}" class="btn btn-outline"
                                style="padding: 8px 14px;">
                                <span class="material-symbols-outlined" style="font-size:18px;">restart_alt</span>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Bulk Action Toolbar -->
                <div class="bulk-toolbar" id="bulkToolbar">
                    <span class="bulk-count-badge" id="bulkCountBadge">0</span>
                    <span class="bulk-toolbar-label">material dipilih</span>
                    <button type="button" class="btn-bulk-cancel" id="bulkCancelBtn">
                        Batal
                    </button>
                    <button type="button" class="btn-bulk-delete" id="bulkDeleteBtn">
                        <span class="material-symbols-outlined">delete_sweep</span>
                        Hapus Terpilih
                    </button>
                </div>

                <!-- Data Table Card (Hanya 4 Kolom: No. Material, Nama Material, Satuan, dan Aksi) -->
                <div class="table-card">
                    @if ($materials->count() > 0)
                        <div class="table-responsive">
                            <table class="data-table" id="materialsTable">
                                <thead>
                                    <tr>
                                        <th class="cb-cell">
                                            <input type="checkbox" class="check-all" id="checkAll" title="Pilih Semua">
                                        </th>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 160px;">No. Material</th>
                                        <th>Nama Material</th>
                                        <th style="width: 140px;">Satuan</th>
                                        <th style="width: 130px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $startNumber = ($materials->currentPage() - 1) * $materials->perPage();
                                    @endphp
                                    @foreach ($materials as $index => $mat)
                                        <tr data-id="{{ $mat->id }}" class="{{ !$mat->is_active ? 'row-inactive' : '' }}">
                                            <td class="cb-cell">
                                                <input type="checkbox" class="row-checkbox"
                                                        value="{{ $mat->id }}"
                                                        aria-label="Pilih {{ $mat->name }}">
                                            </td>
                                            <td>{{ $startNumber + $loop->iteration }}</td>
                                            <td>
                                                <span class="badge-material-number">{{ $mat->material_number }}</span>
                                            </td>
                                            <td style="font-weight: 600;">
                                                {{ $mat->name }}
                                                @if (!$mat->is_active)
                                                    <span class="badge-status-inactive" title="Material dinonaktifkan (memiliki riwayat transaksi, tidak dapat dipilih untuk transaksi baru)">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: var(--text-mid);">{{ $mat->unit }}</span>
                                            </td>
                                            <td>
                                                <div class="actions-cell">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('materials.edit', $mat->id) }}"
                                                        class="btn-icon-only btn-edit" title="Edit Material">
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <button type="button"
                                                            class="btn-icon-only btn-delete btn-open-delete-modal"
                                                            title="Hapus Material"
                                                            data-action="{{ route('materials.destroy', $mat->id) }}"
                                                            data-name="{{ addslashes($mat->name) }}"
                                                            data-number="{{ $mat->material_number }}"
                                                            data-has-relations="{{ $mat->stockMovements()->exists() ? '1' : '0' }}">
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                                    </button>
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
                                <div class="data-info">
                                    @if ($perPage === 'all' || $perPage === 'Semua')
                                        Menampilkan <strong>1–{{ $materials->total() }}</strong> dari
                                        <strong>{{ $materials->total() }}</strong> material
                                    @else
                                        Menampilkan
                                        <strong>{{ $materials->firstItem() ?? 0 }}–{{ $materials->lastItem() ?? 0 }}</strong>
                                        dari <strong>{{ $materials->total() }}</strong> material
                                    @endif
                                </div>

                                <div class="per-page-select">
                                    <label for="per_page_select">Tampilkan:</label>
                                    <select id="per_page_select" onchange="changePerPage(this.value)">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data per halaman</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 data per halaman</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data per halaman</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data per halaman</option>
                                        <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250 data per halaman</option>
                                        <option value="all" {{ $perPage === 'all' || $perPage === 'Semua' ? 'selected' : '' }}>Semua data</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Navigasi Halaman Simpel -->
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
                            <p>Silakan daftarkan material baru atau import data master melalui file Excel.</p>
                            <div class="empty-actions">
                                <a href="{{ route('materials.create') }}" class="btn btn-primary">
                                    <span class="material-symbols-outlined">add</span>
                                    Tambah Material
                                </a>
                                <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                                    <span class="material-symbols-outlined">upload_file</span>
                                    Import Excel
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- POPUP KONFIRMASI HAPUS SATUAN -->
            <div id="deleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon">
                        <span class="material-symbols-outlined">delete</span>
                    </div>
                    <h3 id="deleteModalTitle">Hapus Material?</h3>
                    <p id="deleteModalMessage">
                        Apakah Anda yakin ingin menghapus data material ini?
                    </p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="deleteModalCancel">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="deleteModalConfirm">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk submit hapus -->
            <form id="deleteHiddenForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- POPUP KONFIRMASI HAPUS MASSAL -->
            <div id="bulkDeleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon">
                        <span class="material-symbols-outlined">delete_sweep</span>
                    </div>
                    <h3>Hapus Material Terpilih?</h3>
                    <p id="bulkDeleteModalMessage">
                        Material yang belum memiliki riwayat akan dihapus permanen, sedangkan material yang sudah memiliki riwayat stok akan dinonaktifkan secara aman.
                    </p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="bulkModalCancelBtn">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="bulkModalConfirmBtn">Ya, Hapus Semua</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk bulk delete -->
            <form id="bulkDeleteHiddenForm" method="POST"
                  action="{{ route('materials.bulk-destroy') }}"
                  style="display:none;">
                @csrf
            </form>

            <script>
            (function () {
                // ======================================================
                // 1. HAPUS SATU (Single Delete with relation detection)
                // ======================================================
                const modal      = document.getElementById('deleteModal');
                const cancelBtn  = document.getElementById('deleteModalCancel');
                const confirmBtn = document.getElementById('deleteModalConfirm');
                const msgEl      = document.getElementById('deleteModalMessage');
                const titleEl    = document.getElementById('deleteModalTitle');
                const hiddenForm = document.getElementById('deleteHiddenForm');

                let pendingAction = null;

                if (modal && cancelBtn && confirmBtn && hiddenForm) {
                    document.querySelector('main.main').addEventListener('click', function (e) {
                        const btn = e.target.closest('.btn-open-delete-modal');
                        if (!btn) return;
                        e.preventDefault();

                        pendingAction = btn.dataset.action;
                        const name         = btn.dataset.name || '';
                        const number       = btn.dataset.number || '';
                        const hasRelations = btn.dataset.hasRelations === '1';

                        if (hasRelations) {
                            titleEl.textContent = 'Nonaktifkan Material?';
                            msgEl.innerHTML = `Material <strong>"${name}"</strong> (${number}) telah memiliki riwayat pergerakan stok.<br><br>Untuk menjaga keutuhan data riwayat, material ini akan <strong>dinonaktifkan</strong> dari sistem dan tidak dapat dipilih untuk transaksi stok baru.`;
                            confirmBtn.textContent = 'Ya, Nonaktifkan';
                        } else {
                            titleEl.textContent = 'Hapus Material?';
                            msgEl.innerHTML = `Apakah Anda yakin ingin menghapus material <strong>"${name}"</strong> (${number}) secara permanen? Data yang belum memiliki riwayat akan dihapus dari sistem.`;
                            confirmBtn.textContent = 'Ya, Hapus Permanen';
                        }

                        modal.classList.add('show');
                    });

                    cancelBtn.addEventListener('click', function () {
                        modal.classList.remove('show');
                        pendingAction = null;
                    });

                    confirmBtn.addEventListener('click', function () {
                        if (!pendingAction) return;
                        const action = pendingAction;
                        modal.classList.remove('show');
                        pendingAction = null;

                        confirmBtn.disabled    = true;
                        confirmBtn.textContent = 'Memproses...';

                        hiddenForm.action = action;
                        hiddenForm.submit();
                    });

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) {
                            modal.classList.remove('show');
                            pendingAction = null;
                        }
                    });

                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape' && modal.classList.contains('show')) {
                            modal.classList.remove('show');
                            pendingAction = null;
                        }
                    });
                }

                // ======================================================
                // 2. HAPUS MASSAL (Bulk Delete)
                // ======================================================
                const bulkModal      = document.getElementById('bulkDeleteModal');
                const bulkCancelBtn  = document.getElementById('bulkModalCancelBtn');
                const bulkConfirmBtn = document.getElementById('bulkModalConfirmBtn');
                const bulkMsgEl      = document.getElementById('bulkDeleteModalMessage');
                const bulkForm       = document.getElementById('bulkDeleteHiddenForm');
                const bulkToolbar    = document.getElementById('bulkToolbar');
                const bulkCountBadge = document.getElementById('bulkCountBadge');
                const bulkDeleteBtn  = document.getElementById('bulkDeleteBtn');
                const bulkCancelToolbarBtn = document.getElementById('bulkCancelBtn');
                const checkAll       = document.getElementById('checkAll');

                function getChecked() {
                    return Array.from(document.querySelectorAll('.row-checkbox:checked'));
                }

                function updateToolbar() {
                    const checked = getChecked();
                    const count   = checked.length;
                    if (count > 0) {
                        bulkCountBadge.textContent = count;
                        bulkToolbar.classList.add('visible');
                    } else {
                        bulkToolbar.classList.remove('visible');
                    }

                    const allBoxes = document.querySelectorAll('.row-checkbox');
                    if (checkAll) {
                        checkAll.indeterminate = count > 0 && count < allBoxes.length;
                        checkAll.checked       = count > 0 && count === allBoxes.length;
                    }

                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        const row = cb.closest('tr');
                        if (row) row.classList.toggle('row-selected', cb.checked);
                    });
                }

                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => {
                            cb.checked = checkAll.checked;
                        });
                        updateToolbar();
                    });
                }

                document.querySelector('main.main').addEventListener('change', function (e) {
                    if (e.target.classList.contains('row-checkbox')) {
                        updateToolbar();
                    }
                });

                if (bulkCancelToolbarBtn) {
                    bulkCancelToolbarBtn.addEventListener('click', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
                        if (checkAll) { checkAll.checked = false; checkAll.indeterminate = false; }
                        updateToolbar();
                    });
                }

                if (bulkDeleteBtn) {
                    bulkDeleteBtn.addEventListener('click', function () {
                        const count = getChecked().length;
                        if (count === 0) return;
                        bulkMsgEl.innerHTML = `Anda akan memproses <strong>${count} material terpilih</strong>.<br><br>Material yang sudah memiliki riwayat stok akan dinonaktifkan, sedangkan material yang belum pernah digunakan akan dihapus permanen.`;
                        bulkModal.classList.add('show');
                    });
                }

                if (bulkCancelBtn) {
                    bulkCancelBtn.addEventListener('click', function () {
                        bulkModal.classList.remove('show');
                    });
                }

                if (bulkConfirmBtn && bulkForm) {
                    bulkConfirmBtn.addEventListener('click', function () {
                        const checkedBoxes = getChecked();
                        if (checkedBoxes.length === 0) return;

                        bulkModal.classList.remove('show');
                        bulkConfirmBtn.disabled    = true;
                        bulkConfirmBtn.textContent = 'Memproses...';

                        bulkForm.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

                        checkedBoxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type  = 'hidden';
                            input.name  = 'ids[]';
                            input.value = cb.value;
                            bulkForm.appendChild(input);
                        });

                        bulkForm.submit();
                    });
                }

                if (bulkModal) {
                    bulkModal.addEventListener('click', function (e) {
                        if (e.target === bulkModal) bulkModal.classList.remove('show');
                    });
                }

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        if (bulkModal) bulkModal.classList.remove('show');
                    }
                });

            })();

            function changePerPage(val) {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', val);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }

            function openSidebar() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.add('open');
            }
            </script>

        </main>
    </div>

</body>

</html>
