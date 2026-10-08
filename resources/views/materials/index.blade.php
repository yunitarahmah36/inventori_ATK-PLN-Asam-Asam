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
        /* ============================================================
           RESET & CSS VARIABLES
        ============================================================ */
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
            --green-light: #D1FAE5;
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
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        select,
        input {
            font-family: inherit;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        /* ============================================================
           LAYOUT
        ============================================================ */
        .layout {
            display: flex;
            min-height: 100vh;
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
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 40px;
            transition: background var(--transition);
        }
        .topbar-user:hover {
            background: #F1F5F9;
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
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .empty-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-top: 4px;
}

.empty-actions .btn {
    min-width: 170px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0 18px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
}

.empty-actions .material-symbols-outlined {
    font-size: 20px !important;
    line-height: 1;
    margin: 0 !important;
}

.empty-actions .btn-primary .material-symbols-outlined {
    color: #fff;
}

.empty-actions .btn-yellow .material-symbols-outlined {
    color: var(--blue-dark);
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
            background: rgba(0, 0, 0, 0.5);
            z-index: 199;
        }

        /* ============================================================
           RESPONSIVE (Max 768px)
        ============================================================ */
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

        /* ============================================================
   POPUP KONFIRMASI HAPUS
============================================================ */

.delete-modal {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.48);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
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
    max-width: 420px;
    background: #fff;
    border-radius: 14px;
    padding: 26px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.20);
    text-align: center;
    animation: deleteModalIn 0.2s ease-out;
}

.delete-modal-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: var(--red-light);
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-modal-icon .material-symbols-outlined {
    font-size: 28px;
}

.delete-modal-box h3 {
    margin: 0 0 8px;
    font-size: 18px;
    font-weight: 800;
    color: var(--text-dark);
}

.delete-modal-box p {
    margin: 0 auto 22px;
    font-size: 13px;
    line-height: 1.5;
    color: var(--text-muted);
}

.delete-modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.delete-modal-actions button {
    min-width: 110px;
    height: 40px;
    border-radius: 8px;
    border: none;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.delete-modal-cancel {
    background: #F1F5F9;
    color: var(--text-mid);
}

.delete-modal-cancel:hover {
    background: #E2E8F0;
}

.delete-modal-confirm {
    background: var(--red);
    color: #fff;
}

.delete-modal-confirm:hover {
    background: #B91C1C;
}

@keyframes deleteModalIn {
    from {
        opacity: 0;
        transform: translateY(8px) scale(0.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* ============================================================
   CHECKBOX & BULK SELECT
============================================================ */
.cb-cell {
    width: 44px;
    padding-left: 18px !important;
    padding-right: 8px !important;
}

.row-checkbox,
.check-all {
    width: 17px;
    height: 17px;
    accent-color: var(--blue);
    cursor: pointer;
    flex-shrink: 0;
}

table.data-table tbody tr.row-selected {
    background: #EAF3FF;
}

/* ============================================================
   BULK ACTION TOOLBAR (floating bar)
============================================================ */
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
    white-space: nowrap;
}

.btn-bulk-delete:hover {
    background: #B91C1C;
}

.btn-bulk-delete .material-symbols-outlined {
    font-size: 18px;
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
    white-space: nowrap;
}

.btn-bulk-cancel:hover {
    background: rgba(255,255,255,0.18);
    color: #fff;
}
    </style>
</head>

<body>

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
                        <p>Kelola data material ATK PT PLN Indonesia Power UBP Asam Asam</p>
                    </div>
                </div>

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

                <!-- Header Card dengan Tombol Aksi Utama -->
                <div class="header-card">
                    <div class="header-card-title">
                        <h2>Data Material</h2>
                        <p>Kelola data material ATK PT PLN Indonesia Power UBP Asam Asam</p>
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
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari no material atau nama material..." autocomplete="off">
                        </div>

                        <!-- Filter Tanggal Masuk -->
                        <div class="date-input-group">
                            <label for="start_date">Mulai:</label>
                            <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>

                        <div class="date-input-group">
                            <label for="end_date">Selesai:</label>
                            <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>

                        <button type="submit" class="btn btn-primary" style="padding: 8px 14px;">
                            <span class="material-symbols-outlined" style="font-size:18px;">filter_alt</span>
                            Filter
                        </button>

                        @if (!empty($search) || !empty($startDate) || !empty($endDate))
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

                <!-- Data Table Card -->
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
                                        <tr data-id="{{ $mat->id }}">
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
                                                @if (!empty($mat->description))
                                                    <div
                                                        style="font-size: 11.5px; color: var(--text-muted); font-weight: normal; margin-top: 2px;">
                                                        {{ $mat->description }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $mat->entry_date ? $mat->entry_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="qty-badge">{{ number_format($mat->quantity, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    style="font-weight: 500; color: var(--text-mid);">{{ $mat->unit }}</span>
                                            </td>
                                            <td>
                                                <div class="actions-cell" style="justify-content: center;">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('materials.edit', $mat->id) }}"
                                                        class="btn btn-icon-only btn-edit" title="Edit Material">
                                                        <span class="material-symbols-outlined"
                                                            style="font-size: 18px;">edit</span>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <button type="button"
                                                            class="btn btn-icon-only btn-delete btn-open-delete-modal"
                                                            title="Hapus Material"
                                                            data-action="{{ route('materials.destroy', $mat->id) }}"
                                                            data-name="{{ addslashes($mat->name) }}">
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
                                <!-- Informasi Jumlah Data Dinamis -->
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

                                <!-- Dropdown Jumlah Baris Per Halaman -->
                                <div class="per-page-select">
                                    <label for="per_page_select">Tampilkan:</label>
                                    <select id="per_page_select" onchange="changePerPage(this.value)">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data per
                                            halaman</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 data per
                                            halaman</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data per
                                            halaman</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data per
                                            halaman</option>
                                        <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250 data per
                                            halaman</option>
                                        <option value="all"
                                            {{ $perPage === 'all' || $perPage === 'Semua' ? 'selected' : '' }}>Semua
                                            data</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Navigasi Halaman Simpel (HANYA Sebelumnya & Berikutnya) -->
                            <div class="pagination-simple">
                                @if ($materials->onFirstPage())
                                    <span class="btn-page disabled">
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $materials->previousPageUrl() }}" class="btn-page">
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </a>
                                @endif

                                @if ($materials->hasMorePages())
                                    <a href="{{ $materials->nextPageUrl() }}" class="btn-page">
                                        Berikutnya
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;">arrow_forward</span>
                                    </a>
                                @else
                                    <span class="btn-page disabled">
                                        Berikutnya
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;">arrow_forward</span>
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

            <!-- POPUP KONFIRMASI HAPUS MASSAL -->
            <div id="bulkDeleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon" style="background:#FEE2E2;color:#DC2626;">
                        <span class="material-symbols-outlined">delete_sweep</span>
                    </div>
                    <h3>Hapus Material Terpilih?</h3>
                    <p id="bulkDeleteModalMessage">Anda akan menghapus beberapa material sekaligus. Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="bulkModalCancelBtn">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="bulkModalConfirmBtn">Hapus Semua</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk bulk delete -->
            <form id="bulkDeleteHiddenForm" method="POST"
                  action="{{ route('materials.bulk-destroy') }}"
                  style="display:none;">
                @csrf
            </form>

            <!-- POPUP KONFIRMASI HAPUS -->
            <div id="deleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon">
                        <span class="material-symbols-outlined">delete</span>
                    </div>
                    <h3>Hapus Material?</h3>
                    <p id="deleteModalMessage">
                        Apakah Anda yakin ingin menghapus material ini?
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="deleteModalCancel">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="deleteModalConfirm">Hapus</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk submit hapus -->
            <form id="deleteHiddenForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <script>
            (function () {

                // ======================================================
                // 1. HAPUS SATU (single delete)
                // ======================================================
                const modal      = document.getElementById('deleteModal');
                const cancelBtn  = document.getElementById('deleteModalCancel');
                const confirmBtn = document.getElementById('deleteModalConfirm');
                const msgEl      = document.getElementById('deleteModalMessage');
                const hiddenForm = document.getElementById('deleteHiddenForm');

                let pendingAction = null;
                let pendingRow    = null;

                if (modal && cancelBtn && confirmBtn && hiddenForm) {

                    document.querySelector('main.main').addEventListener('click', function (e) {
                        const btn = e.target.closest('.btn-open-delete-modal');
                        if (!btn) return;
                        e.preventDefault();
                        pendingAction = btn.dataset.action;
                        pendingRow    = btn.closest('tr') || null;
                        const name    = btn.dataset.name || '';
                        msgEl.textContent = name
                            ? `Apakah Anda yakin ingin menghapus material "${name}"? Data yang dihapus tidak dapat dikembalikan.`
                            : 'Apakah Anda yakin ingin menghapus material ini? Data yang dihapus tidak dapat dikembalikan.';
                        modal.classList.add('show');
                    });

                    cancelBtn.addEventListener('click', function () {
                        modal.classList.remove('show');
                        pendingAction = null;
                        pendingRow    = null;
                    });

                    confirmBtn.addEventListener('click', async function () {
                        if (!pendingAction) return;
                        const action = pendingAction;
                        const row    = pendingRow;
                        modal.classList.remove('show');
                        pendingAction = null;
                        pendingRow    = null;

                        if (row) {
                            row.style.transition = 'opacity 0.22s ease, transform 0.22s ease';
                            row.style.opacity    = '0';
                            row.style.transform  = 'translateX(-12px)';
                        }

                        confirmBtn.disabled    = true;
                        confirmBtn.textContent = 'Menghapus...';

                        try {
                            const csrfToken = hiddenForm.querySelector('input[name="_token"]').value;
                            const formData  = new FormData();
                            formData.append('_token',  csrfToken);
                            formData.append('_method', 'DELETE');
                            await fetch(action, {
                                method: 'POST',
                                body:   formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            setTimeout(async function () {
                                if (typeof navigatePage === 'function') {
                                    await navigatePage(window.location.pathname + window.location.search, false);
                                } else {
                                    window.location.reload();
                                }
                                confirmBtn.disabled    = false;
                                confirmBtn.textContent = 'Hapus';
                            }, 220);
                        } catch (err) {
                            console.error('Delete error:', err);
                            if (row) { row.style.opacity = '1'; row.style.transform = 'translateX(0)'; }
                            confirmBtn.disabled    = false;
                            confirmBtn.textContent = 'Hapus';
                            alert('Gagal menghapus material. Silakan coba lagi.');
                        }
                    });

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) {
                            modal.classList.remove('show');
                            pendingAction = null;
                            pendingRow    = null;
                        }
                    });

                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape' && modal.classList.contains('show')) {
                            modal.classList.remove('show');
                            pendingAction = null;
                            pendingRow    = null;
                        }
                    });
                }

                // ======================================================
                // 2. HAPUS MASSAL (bulk delete)
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
                    // Update state checkAll
                    const allBoxes = document.querySelectorAll('.row-checkbox');
                    if (checkAll) {
                        checkAll.indeterminate = count > 0 && count < allBoxes.length;
                        checkAll.checked       = count > 0 && count === allBoxes.length;
                    }
                    // Highlight baris terpilih
                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        const row = cb.closest('tr');
                        if (row) row.classList.toggle('row-selected', cb.checked);
                    });
                }

                // Pilih semua
                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => {
                            cb.checked = checkAll.checked;
                        });
                        updateToolbar();
                    });
                }

                // Per-baris checkbox (event delegation)
                document.querySelector('main.main').addEventListener('change', function (e) {
                    if (e.target.classList.contains('row-checkbox')) {
                        updateToolbar();
                    }
                });

                // Tombol Batal di toolbar
                if (bulkCancelToolbarBtn) {
                    bulkCancelToolbarBtn.addEventListener('click', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
                        if (checkAll) { checkAll.checked = false; checkAll.indeterminate = false; }
                        updateToolbar();
                    });
                }

                // Tombol Hapus Terpilih → buka modal konfirmasi
                if (bulkDeleteBtn) {
                    bulkDeleteBtn.addEventListener('click', function () {
                        const count = getChecked().length;
                        if (count === 0) return;
                        bulkMsgEl.textContent = `Anda akan menghapus ${count} material sekaligus. Data yang dihapus tidak dapat dikembalikan.`;
                        bulkModal.classList.add('show');
                    });
                }

                // Batal dari modal bulk
                if (bulkCancelBtn) {
                    bulkCancelBtn.addEventListener('click', function () {
                        bulkModal.classList.remove('show');
                    });
                }

                // Konfirmasi hapus massal
                if (bulkConfirmBtn && bulkForm) {
                    bulkConfirmBtn.addEventListener('click', async function () {
                        const checkedBoxes = getChecked();
                        if (checkedBoxes.length === 0) return;

                        bulkModal.classList.remove('show');
                        bulkConfirmBtn.disabled    = true;
                        bulkConfirmBtn.textContent = 'Menghapus...';

                        // Animasi fade-out semua baris terpilih
                        checkedBoxes.forEach(cb => {
                            const row = cb.closest('tr');
                            if (row) {
                                row.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                                row.style.opacity    = '0';
                                row.style.transform  = 'translateX(-12px)';
                            }
                        });

                        try {
                            const csrfInput = bulkForm.querySelector('input[name="_token"]');
                            const csrfToken = csrfInput ? csrfInput.value : '';
                            const formData  = new FormData();
                            formData.append('_token', csrfToken);
                            checkedBoxes.forEach(cb => formData.append('ids[]', cb.value));

                            await fetch(bulkForm.action, {
                                method: 'POST',
                                body:   formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });

                            setTimeout(async function () {
                                if (typeof navigatePage === 'function') {
                                    await navigatePage(window.location.pathname + window.location.search, false);
                                } else {
                                    window.location.reload();
                                }
                                bulkConfirmBtn.disabled    = false;
                                bulkConfirmBtn.textContent = 'Hapus Semua';
                            }, 220);

                        } catch (err) {
                            console.error('Bulk delete error:', err);
                            // Kembalikan baris
                            checkedBoxes.forEach(cb => {
                                const row = cb.closest('tr');
                                if (row) { row.style.opacity = '1'; row.style.transform = 'translateX(0)'; }
                            });
                            bulkConfirmBtn.disabled    = false;
                            bulkConfirmBtn.textContent = 'Hapus Semua';
                            alert('Gagal menghapus material. Silakan coba lagi.');
                        }
                    });
                }

                // Klik luar modal bulk
                if (bulkModal) {
                    bulkModal.addEventListener('click', function (e) {
                        if (e.target === bulkModal) bulkModal.classList.remove('show');
                    });
                }

                // Escape tutup kedua modal
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        if (bulkModal) bulkModal.classList.remove('show');
                    }
                });

            })();
            </script>

        </main>
   

</body>

</html>
