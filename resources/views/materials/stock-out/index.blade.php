<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stok Keluar - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style id="page-style">
        :root {
            --blue: #0057B8;
            --blue-dark: #003B73;
            --blue-light: #EBF3FC;
            --yellow: #FFC107;
            --yellow-light: #FFF8E1;
            --text-dark: #1E293B;
            --text-mid: #475569;
            --text-muted: #94A3B8;
            --bg: #F0F4F8;
            --white: #FFFFFF;
            --border: #E2E8F0;
            --green: #10B981;
            --green-light: #ECFDF5;
            --red: #EF4444;
            --red-light: #FEF2F2;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            --radius: 12px;
            --transition: all 0.2s ease;
            --sidebar-w: 260px;
            --header-h: 70px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* Topbar */
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
            z-index: 50;
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
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 40px;
            background: #F8FAFC;
            border: 1px solid var(--border);
            text-decoration: none;
            color: inherit;
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
            text-transform: uppercase;
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
            cursor: pointer;
            margin-right: 12px;
        }

        /* Page Content */
        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 500;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-close {
            background: transparent;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Header Card */
        .header-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            box-shadow: var(--shadow-sm);
        }

        .header-card-title h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
            margin-bottom: 4px;
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

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: var(--transition);
            font-family: inherit;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: #004595;
            color: #fff;
        }

        .btn-outline {
            background: var(--white);
            border-color: var(--border);
            color: var(--text-dark);
        }

        .btn-outline:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .btn-danger {
            background: var(--red);
            color: #fff;
        }

        .btn-danger:hover {
            background: #DC2626;
            color: #fff;
        }

        /* KPI Stats Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi-icon.blue { background: var(--blue-light); color: var(--blue); }
        .kpi-icon.red { background: var(--red-light); color: var(--red); }
        .kpi-icon.amber { background: #FEF3C7; color: #D97706; }

        .kpi-info-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .kpi-info-val {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            margin-top: 2px;
        }

        /* Filter Card */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 240px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            outline: none;
            transition: var(--transition);
            background: #F8FAFC;
        }

        .search-box input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .search-box .material-symbols-outlined {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }

        .date-input-group {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-mid);
        }

        .date-input-group input[type="date"] {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 12.5px;
            color: var(--text-dark);
            background: #F8FAFC;
            outline: none;
        }

        .date-input-group input[type="date"]:focus {
            border-color: var(--blue);
            background: #fff;
        }

        /* Table Card */
        .table-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13.5px;
        }

        .data-table th {
            background: #F8FAFC;
            color: var(--text-mid);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover td {
            background: #FBFDFF;
        }

        .badge-material-number {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            background: #F1F5F9;
            color: var(--text-mid);
            font-family: monospace;
            font-weight: 700;
            font-size: 12px;
        }

        .qty-badge-out {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 10px;
            border-radius: 20px;
            background: var(--red-light);
            color: var(--red);
            font-weight: 700;
            font-size: 13px;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text-mid);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-table-action:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
        }

        .btn-table-action.delete:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-light);
        }

        /* Table Footer */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #FAFCFE;
            flex-wrap: wrap;
            gap: 14px;
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
            box-shadow: 0 0 0 2px rgba(0, 87, 184, 0.15);
        }

        .table-footer-pagination {
            display: flex;
            align-items: center;
        }

        /* Base Button & Link Pagination */
        .page-link,
        .table-footer .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            min-width: 35px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            border: 1px solid var(--border);
            background: var(--white);
            color: #64748B;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            user-select: none;
            line-height: 1;
            box-sizing: border-box;
        }

        .page-link:hover:not(.disabled):not(.active),
        .table-footer a.page-link:hover {
            background: var(--blue-light);
            border-color: #BFDBFE;
            color: var(--blue);
        }

        .page-item.active .page-link,
        .page-link.active,
        .page-num.active {
            background: var(--blue) !important;
            border-color: var(--blue) !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 6px rgba(0, 87, 184, 0.28);
            font-weight: 700;
            cursor: default;
            pointer-events: none;
        }

        .page-prev,
        .page-next {
            padding: 0 13px;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .page-item.disabled .page-link,
        .page-link.disabled,
        .page-prev.disabled,
        .page-next.disabled {
            background: #F8FAFC !important;
            border-color: #E2E8F0 !important;
            color: #94A3B8 !important;
            cursor: not-allowed !important;
            pointer-events: none;
            opacity: 0.65;
        }

        .page-ellipsis {
            border: none !important;
            background: transparent !important;
            color: #94A3B8 !important;
            cursor: default !important;
            pointer-events: none;
            padding: 0 4px;
            min-width: 22px;
            font-weight: 700;
        }

        .pagination-icon {
            font-size: 18px !important;
            width: 18px !important;
            height: 18px !important;
            line-height: 18px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
        }

        .table-footer svg,
        .pagination-nav svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            vertical-align: middle;
            display: inline-block;
        }

        /* Empty State */
        .empty-state {
            padding: 50px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state .material-symbols-outlined {
            font-size: 48px;
            color: #CBD5E1;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        /* Modals */
        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.52);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 20px;
        }

        .modal-backdrop-custom.show {
            display: flex;
        }

        .modal-box-custom {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 16px;
            padding: 26px 28px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
            position: relative;
            animation: modalFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(12px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header-custom {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .modal-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-header-icon.blue { background: var(--blue-light); color: var(--blue); }
        .modal-header-icon.red { background: var(--red-light); color: var(--red); }

        .modal-header-custom h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
            margin-bottom: 3px;
        }

        .modal-header-custom p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        .modal-close-btn {
            position: absolute;
            top: 18px;
            right: 18px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close-btn:hover {
            background: #F1F5F9;
            color: var(--text-dark);
        }

        .form-group-custom {
            margin-bottom: 15px;
        }

        .form-label-custom {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control-custom {
            width: 100%;
            padding: 9px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text-dark);
            background: #fff;
            transition: var(--transition);
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .modal-card-preview {
            background: #F8FAFC;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .preview-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .preview-row:last-child {
            margin-bottom: 0;
        }

        .modal-actions-custom {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .modal-input-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .modal-input-error {
            font-size: 12px;
            color: var(--red);
            font-weight: 600;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
            }
            .btn-hamburger {
                display: flex;
            }
            .page-content {
                padding: 16px 14px 60px;
            }
            .header-card {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- Sidebar Komponen Terpusat --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <main class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <div style="display:flex;align-items:center;">
                <button type="button" class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="topbar-left">
                    <h1>Stok Keluar</h1>
                    <p>PT PLN Indonesia Power UBP Asam Asam &bull; Submenu Data Material</p>
                </div>
            </div>

            <div class="topbar-user">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="topbar-user-detail">
                    <div class="topbar-user-name">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                    <div class="topbar-user-email">{{ Auth::user()->email ?? '' }}</div>
                    <span class="badge-role">{{ Auth::user()->role ?? 'User' }}</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="page-content">

            {{-- Flash Messages --}}
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

            @if (session('error'))
                <div class="alert alert-error" id="alertError">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="material-symbols-outlined" style="font-size:20px;">error</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="alert-close" onclick="document.getElementById('alertError').remove()">
                        <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" id="alertValidationErrors">
                    <div style="display:flex;align-items:flex-start;gap:8px;">
                        <span class="material-symbols-outlined" style="font-size:20px;margin-top:2px;">error</span>
                        <div>
                            <strong>Terdapat kesalahan data:</strong>
                            <ul style="margin:4px 0 0 16px;padding:0;font-size:13px;max-height:160px;overflow-y:auto;">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="alert-close" onclick="document.getElementById('alertValidationErrors').remove()">
                        <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                    </button>
                </div>
            @endif

            {{-- Header Card dengan Tombol Aksi Utama --}}
            <div class="header-card">
                <div class="header-card-title">
                    <h2>Pencatatan Stok Keluar</h2>
                    <p>Catat pengeluaran stok material ke penerima atau unit tujuan secara terkendali.</p>
                </div>

                <div class="header-actions">
                    <!-- Tombol Catat Stok Keluar -->
                    <button type="button" class="btn btn-primary" id="btnOpenCreateModal">
                        <span class="material-symbols-outlined" style="font-size:19px;">do_not_disturb_on</span>
                        Catat Stok Keluar
                    </button>

                    <!-- Tombol Export Excel -->
                    <a href="{{ route('materials.stock-out.export', ['search' => $search, 'start_date' => $startDate, 'end_date' => $endDate, 'per_page' => $perPage]) }}" 
                       class="btn btn-outline" 
                       download>
                        <span class="material-symbols-outlined" style="font-size:19px;">download</span>
                        Export Excel
                    </a>
                </div>
            </div>

            {{-- KPI Stats --}}
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon blue">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div>
                        <div class="kpi-info-label">Total Transaksi Keluar</div>
                        <div class="kpi-info-val">{{ number_format($totalTransactions, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon red">
                        <span class="material-symbols-outlined">outbox</span>
                    </div>
                    <div>
                        <div class="kpi-info-label">Total Item Dikeluarkan</div>
                        <div class="kpi-info-val">-{{ number_format($totalQuantityOut, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon amber">
                        <span class="material-symbols-outlined">category</span>
                    </div>
                    <div>
                        <div class="kpi-info-label">Jenis Material Keluar</div>
                        <div class="kpi-info-val">{{ number_format($totalMaterialsOut, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Filter & Search Bar --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('materials.stock-out.index') }}" class="filter-form" id="filterForm">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">

                    <div class="search-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Material, nama material, penerima, keterangan, pengguna...">
                    </div>

                    <div class="date-input-group">
                        <label for="startDate">Mulai:</label>
                        <input type="date" id="startDate" name="start_date" value="{{ $startDate }}">
                    </div>

                    <div class="date-input-group">
                        <label for="endDate">Selesai:</label>
                        <input type="date" id="endDate" name="end_date" value="{{ $endDate }}">
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding:8px 14px;">
                        <span class="material-symbols-outlined" style="font-size:17px;">filter_alt</span>
                        Filter
                    </button>

                    @if (!empty($search) || !empty($startDate) || !empty($endDate))
                        <a href="{{ route('materials.stock-out.index', ['per_page' => $perPage]) }}" class="btn btn-outline" style="padding:8px 12px;" title="Reset Filter" data-spa-link>
                            <span class="material-symbols-outlined" style="font-size:17px;">restart_alt</span>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabel Riwayat Stok Keluar --}}
            <div class="table-card">
                @if ($stockOuts->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 140px;">No Material</th>
                                    <th>Nama Material</th>
                                    <th style="width: 130px;">Tanggal Keluar</th>
                                    <th style="width: 130px;">Jumlah Keluar</th>
                                    <th style="width: 90px;">Satuan</th>
                                    <th>Penerima / Unit</th>
                                    <th>Keterangan</th>
                                    <th style="width: 140px;">Dicatat Oleh</th>
                                    <th style="width: 90px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startNumber = ($stockOuts->currentPage() - 1) * $stockOuts->perPage();
                                @endphp
                                @foreach ($stockOuts as $item)
                                    <tr>
                                        <td>{{ $startNumber + $loop->iteration }}</td>
                                        <td>
                                            <span class="badge-material-number">{{ $item->material_number }}</span>
                                        </td>
                                        <td style="font-weight: 600;">
                                            {{ $item->material_name ?: ($item->material->name ?? '-') }}
                                        </td>
                                        <td>
                                            {{ $item->created_at ? $item->created_at->translatedFormat('j M Y') : '-' }}
                                        </td>
                                        <td>
                                            <span class="qty-badge-out">
                                                <span class="material-symbols-outlined" style="font-size:15px;">remove</span>
                                                {{ number_format(abs($item->quantity_change), 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td style="color:var(--text-mid);">
                                            {{ $item->material->unit ?? 'Unit' }}
                                        </td>
                                        <td style="font-weight: 600; color: var(--blue-dark);">
                                            {{ $item->recipient ?: '-' }}
                                        </td>
                                        <td style="color:var(--text-mid); font-size: 12.5px;">
                                            {{ $item->description ?: '-' }}
                                        </td>
                                        <td>
                                            <div style="font-weight:600; font-size:12.5px;">{{ $item->user->name ?? '-' }}</div>
                                            <div style="font-size:11px; color:var(--text-muted);">{{ $item->created_at ? $item->created_at->format('H:i') : '' }} WITA</div>
                                        </td>
                                        <td>
                                            <div class="action-btns" style="justify-content: center;">
                                                <button type="button" 
                                                        class="btn-table-action btn-open-edit"
                                                        title="Edit Transaksi Stok Keluar"
                                                        data-id="{{ $item->id }}"
                                                        data-material-name="{{ $item->material_name ?: ($item->material->name ?? '-') }}"
                                                        data-material-number="{{ $item->material_number }}"
                                                        data-quantity="{{ abs($item->quantity_change) }}"
                                                        data-unit="{{ $item->material->unit ?? 'Unit' }}"
                                                        data-exit-date="{{ $item->created_at ? $item->created_at->format('Y-m-d') : date('Y-m-d') }}"
                                                        data-recipient="{{ $item->recipient ?? '' }}"
                                                        data-description="{{ $item->description ?? '' }}"
                                                        data-current-stock="{{ $item->material->quantity ?? 0 }}">
                                                    <span class="material-symbols-outlined" style="font-size:17px;">edit</span>
                                                </button>

                                                <button type="button" 
                                                        class="btn-table-action delete btn-open-delete"
                                                        title="Hapus Transaksi Stok Keluar"
                                                        data-id="{{ $item->id }}"
                                                        data-material-name="{{ $item->material_name ?: ($item->material->name ?? '-') }}"
                                                        data-material-number="{{ $item->material_number }}"
                                                        data-quantity="{{ abs($item->quantity_change) }}"
                                                        data-unit="{{ $item->material->unit ?? 'Unit' }}">
                                                    <span class="material-symbols-outlined" style="font-size:17px;">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Tabel: Informasi Data, Pilihan Tampilkan Per Halaman & Navigasi Pagination --}}
                    <div class="table-footer">
                        <div class="table-footer-left">
                            <div class="data-info">
                                @if ($perPage === 'all' || $perPage === 'Semua')
                                    Menampilkan <strong>1–{{ $stockOuts->total() }}</strong> dari <strong>{{ $stockOuts->total() }}</strong> transaksi
                                @else
                                    Menampilkan <strong>{{ $stockOuts->firstItem() ?? 0 }}–{{ $stockOuts->lastItem() ?? 0 }}</strong> dari <strong>{{ $stockOuts->total() }}</strong> transaksi
                                @endif
                            </div>

                            <div class="per-page-select">
                                <label for="per_page_select">Tampilkan:</label>
                                <select id="per_page_select" onchange="changePerPage(this.value)">
                                    <option value="10" {{ (string)$perPage === '10' ? 'selected' : '' }}>10 data per halaman</option>
                                    <option value="25" {{ (string)$perPage === '25' || empty($perPage) ? 'selected' : '' }}>25 data per halaman</option>
                                    <option value="50" {{ (string)$perPage === '50' ? 'selected' : '' }}>50 data per halaman</option>
                                    <option value="100" {{ (string)$perPage === '100' ? 'selected' : '' }}>100 data per halaman</option>
                                    <option value="250" {{ (string)$perPage === '250' ? 'selected' : '' }}>250 data per halaman</option>
                                    <option value="all" {{ $perPage === 'all' || $perPage === 'Semua' ? 'selected' : '' }}>Semua data</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-footer-pagination">
                            {{ $stockOuts->onEachSide(1)->links('partials.pagination') }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <span class="material-symbols-outlined">outbox</span>
                        <h3>Belum Ada Transaksi Stok Keluar</h3>
                        <p>Catat pengeluaran stok material menggunakan tombol "Catat Stok Keluar".</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- ============================================================
             MODAL 1: CATAT STOK KELUAR (TAMBAH)
        ============================================================ --}}
        <div id="createStockOutModal" class="modal-backdrop-custom" aria-hidden="true" role="dialog">
            <div class="modal-box-custom">
                <button type="button" class="modal-close-btn" id="closeCreateModalBtn" aria-label="Tutup">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="modal-header-custom">
                    <div class="modal-header-icon blue">
                        <span class="material-symbols-outlined" style="font-size:26px;">do_not_disturb_on</span>
                    </div>
                    <div>
                        <h3>Catat Stok Keluar</h3>
                        <p>Keluarkan stok material untuk unit kerja atau penerima yang dituju.</p>
                    </div>
                </div>

                <form action="{{ route('materials.stock-out.store') }}" method="POST" id="createStockOutForm">
                    @csrf

                    <!-- Pilihan Material -->
                    <div class="form-group-custom">
                        <label for="createSelectMaterial" class="form-label-custom">
                            Pilih Material <span style="color:var(--red);">*</span>
                        </label>
                        <select id="createSelectMaterial" name="material_id" class="form-control-custom" required>
                            <option value="">-- Pilih Material (No Material & Nama) --</option>
                            @foreach ($allMaterials as $m)
                                <option value="{{ $m->id }}" 
                                        data-number="{{ $m->material_number }}" 
                                        data-name="{{ $m->name }}" 
                                        data-stock="{{ $m->quantity }}" 
                                        data-unit="{{ $m->unit }}">
                                    [{{ $m->material_number }}] {{ $m->name }} (Tersedia: {{ number_format($m->quantity, 0, ',', '.') }} {{ $m->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ringkasan Info Material yang Dipilih -->
                    <div id="createMaterialPreview" class="modal-card-preview" style="display:none;">
                        <div class="preview-row">
                            <span style="color:var(--text-muted);">No Material:</span>
                            <span class="badge-material-number" id="createPreviewNumber">-</span>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Nama Material:</span>
                            <strong id="createPreviewName" style="color:var(--text-dark);">-</strong>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Stok Tersedia Saat Ini:</span>
                            <strong id="createPreviewStock" style="color:var(--blue);">-</strong>
                        </div>
                    </div>

                    <!-- Jumlah Keluar -->
                    <div class="form-group-custom">
                        <label for="createQuantity" class="form-label-custom">
                            Jumlah Keluar <span style="color:var(--red);">*</span>
                        </label>
                        <div style="position:relative;">
                            <input type="number" 
                                   id="createQuantity" 
                                   name="quantity" 
                                   class="form-control-custom" 
                                   min="1" 
                                   required 
                                   placeholder="Masukkan kuantitas keluar">
                            <span id="createUnitSuffix" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:12.5px;color:var(--text-muted);font-weight:600;">Unit</span>
                        </div>
                        <div id="createMaxQtyHint" class="modal-input-hint" style="display:none;">
                            Maksimal pengeluaran: <strong id="createMaxQtyText" style="color:var(--text-dark);">0 Unit</strong>
                        </div>
                        <div id="createQtyError" class="modal-input-error" style="display:none;">
                            Jumlah keluar melebihi stok yang tersedia.
                        </div>
                    </div>

                    <!-- Tanggal Keluar -->
                    <div class="form-group-custom">
                        <label for="createExitDate" class="form-label-custom">
                            Tanggal Keluar <span style="color:var(--red);">*</span>
                        </label>
                        <input type="date" 
                               id="createExitDate" 
                               name="exit_date" 
                               class="form-control-custom" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                    </div>

                    <!-- Penerima / Unit Tujuan -->
                    <div class="form-group-custom">
                        <label for="createRecipient" class="form-label-custom">
                            Penerima / Unit Tujuan <span style="color:var(--red);">*</span>
                        </label>
                        <input type="text" 
                               id="createRecipient" 
                               name="recipient" 
                               class="form-control-custom" 
                               required 
                               placeholder="Contoh: Unit Pemeliharaan Turbin / Bpk. Rudi">
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group-custom">
                        <label for="createDescription" class="form-label-custom">
                            Keterangan <span style="color:var(--text-muted);font-weight:normal;font-size:12px;">(Opsional)</span>
                        </label>
                        <textarea id="createDescription" 
                                  name="description" 
                                  class="form-control-custom" 
                                  rows="3" 
                                  placeholder="Contoh: Keperluan perbaikan darurat boiler... (opsional)"></textarea>
                    </div>

                    <div class="modal-actions-custom">
                        <button type="button" class="btn btn-outline" id="cancelCreateModalBtn">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateBtn">
                            <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                            Simpan Stok Keluar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================================================
             MODAL 2: EDIT STOK KELUAR
        ============================================================ --}}
        <div id="editStockOutModal" class="modal-backdrop-custom" aria-hidden="true" role="dialog">
            <div class="modal-box-custom">
                <button type="button" class="modal-close-btn" id="closeEditModalBtn" aria-label="Tutup">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="modal-header-custom">
                    <div class="modal-header-icon blue">
                        <span class="material-symbols-outlined" style="font-size:26px;">edit_note</span>
                    </div>
                    <div>
                        <h3>Edit Transaksi Stok Keluar</h3>
                        <p>Perbarui jumlah keluar, tanggal, penerima, atau keterangan transaksi.</p>
                    </div>
                </div>

                <form action="" method="POST" id="editStockOutForm">
                    @csrf
                    @method('PUT')

                    <!-- Ringkasan Material -->
                    <div class="modal-card-preview">
                        <div class="preview-row">
                            <span style="color:var(--text-muted);">No Material:</span>
                            <span class="badge-material-number" id="editPreviewNumber">-</span>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Nama Material:</span>
                            <strong id="editPreviewName" style="color:var(--text-dark);">-</strong>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Total Stok Tersedia (Termasuk Transaksi Ini):</span>
                            <strong id="editPreviewAvailable" style="color:var(--blue);">-</strong>
                        </div>
                    </div>

                    <!-- Jumlah Keluar -->
                    <div class="form-group-custom">
                        <label for="editQuantity" class="form-label-custom">
                            Jumlah Keluar <span style="color:var(--red);">*</span>
                        </label>
                        <div style="position:relative;">
                            <input type="number" 
                                   id="editQuantity" 
                                   name="quantity" 
                                   class="form-control-custom" 
                                   min="1" 
                                   required 
                                   placeholder="Masukkan kuantitas keluar">
                            <span id="editUnitSuffix" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:12.5px;color:var(--text-muted);font-weight:600;">Unit</span>
                        </div>
                        <div id="editMaxQtyHint" class="modal-input-hint">
                            Maksimal pengeluaran: <strong id="editMaxQtyText" style="color:var(--text-dark);">0 Unit</strong>
                        </div>
                        <div id="editQtyError" class="modal-input-error" style="display:none;">
                            Jumlah keluar melebihi stok yang tersedia.
                        </div>
                    </div>

                    <!-- Tanggal Keluar -->
                    <div class="form-group-custom">
                        <label for="editExitDate" class="form-label-custom">
                            Tanggal Keluar <span style="color:var(--red);">*</span>
                        </label>
                        <input type="date" 
                               id="editExitDate" 
                               name="exit_date" 
                               class="form-control-custom" 
                               required>
                    </div>

                    <!-- Penerima / Unit Tujuan -->
                    <div class="form-group-custom">
                        <label for="editRecipient" class="form-label-custom">
                            Penerima / Unit Tujuan <span style="color:var(--red);">*</span>
                        </label>
                        <input type="text" 
                               id="editRecipient" 
                               name="recipient" 
                               class="form-control-custom" 
                               required 
                               placeholder="Contoh: Unit Pemeliharaan Turbin / Bpk. Rudi">
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group-custom">
                        <label for="editDescription" class="form-label-custom">
                            Keterangan <span style="color:var(--text-muted);font-weight:normal;font-size:12px;">(Opsional)</span>
                        </label>
                        <textarea id="editDescription" 
                                  name="description" 
                                  class="form-control-custom" 
                                  rows="3" 
                                  placeholder="Keterangan transaksi... (opsional)"></textarea>
                    </div>

                    <div class="modal-actions-custom">
                        <button type="button" class="btn btn-outline" id="cancelEditModalBtn">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitEditBtn">
                            <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                            Perbarui Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================================================
             MODAL 3: KONFIRMASI HAPUS STOK KELUAR
        ============================================================ --}}
        <div id="deleteStockOutModal" class="modal-backdrop-custom" aria-hidden="true" role="dialog">
            <div class="modal-box-custom" style="max-width:440px; text-align:center;">
                <div class="modal-header-icon red" style="margin: 0 auto 16px;">
                    <span class="material-symbols-outlined" style="font-size:28px;">delete_forever</span>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:var(--text-dark);margin-bottom:8px;">Hapus Transaksi Stok Keluar?</h3>
                <p style="font-size:13px;color:var(--text-mid);line-height:1.5;margin-bottom:16px;">
                    Data transaksi pengeluaran material <strong id="deleteMaterialNameText">-</strong> sebanyak <strong id="deleteQuantityText">0 Unit</strong> akan dihapus, dan kuantitas stok akan <strong>dikembalikan</strong> ke data material.
                </p>

                <form action="" method="POST" id="deleteStockOutForm">
                    @csrf
                    @method('DELETE')

                    <div class="modal-actions-custom" style="justify-content:center;border-top:none;margin-top:0;">
                        <button type="button" class="btn btn-outline" id="cancelDeleteModalBtn">Batal</button>
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                            <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                            Ya, Hapus & Kembalikan Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>

    {{-- Script Interaktif Halaman Stok Keluar --}}
    <script>
        function initStockOutPage() {
            // ==========================================
            // MODAL TAMBAH STOK KELUAR
            // ==========================================
            const createModal        = document.getElementById('createStockOutModal');
            const btnOpenCreateModal = document.getElementById('btnOpenCreateModal');
            const closeCreateModalBtn= document.getElementById('closeCreateModalBtn');
            const cancelCreateBtn    = document.getElementById('cancelCreateModalBtn');
            const createSelectMat    = document.getElementById('createSelectMaterial');
            const createPreviewBox   = document.getElementById('createMaterialPreview');
            const createPreviewNum   = document.getElementById('createPreviewNumber');
            const createPreviewName  = document.getElementById('createPreviewName');
            const createPreviewStock = document.getElementById('createPreviewStock');
            const createQtyInput     = document.getElementById('createQuantity');
            const createUnitSuffix   = document.getElementById('createUnitSuffix');
            const createMaxHint      = document.getElementById('createMaxQtyHint');
            const createMaxText      = document.getElementById('createMaxQtyText');
            const createQtyError     = document.getElementById('createQtyError');
            const submitCreateBtn    = document.getElementById('submitCreateBtn');

            let currentAvailableStock = 0;

            function openCreateModal() {
                if (createModal) {
                    createModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeCreateModal() {
                if (createModal) {
                    createModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            if (btnOpenCreateModal) btnOpenCreateModal.addEventListener('click', openCreateModal);
            if (closeCreateModalBtn) closeCreateModalBtn.addEventListener('click', closeCreateModal);
            if (cancelCreateBtn) cancelCreateBtn.addEventListener('click', closeCreateModal);

            if (createSelectMat) {
                createSelectMat.addEventListener('change', function () {
                    const opt = this.options[this.selectedIndex];
                    if (this.value && opt) {
                        const num   = opt.getAttribute('data-number') || '-';
                        const name  = opt.getAttribute('data-name') || '-';
                        const stock = parseInt(opt.getAttribute('data-stock') || '0', 10);
                        const unit  = opt.getAttribute('data-unit') || 'Unit';

                        currentAvailableStock = stock;

                        createPreviewNum.textContent   = num;
                        createPreviewName.textContent  = name;
                        createPreviewStock.textContent = `${stock.toLocaleString('id-ID')} ${unit}`;
                        createPreviewBox.style.display = 'block';

                        createUnitSuffix.textContent   = unit;
                        createMaxText.textContent      = `${stock.toLocaleString('id-ID')} ${unit}`;
                        createMaxHint.style.display    = 'block';

                        createQtyInput.max = stock;
                        validateCreateQty();
                    } else {
                        currentAvailableStock = 0;
                        createPreviewBox.style.display = 'none';
                        createMaxHint.style.display    = 'none';
                        createUnitSuffix.textContent   = 'Unit';
                        createQtyError.style.display   = 'none';
                        submitCreateBtn.disabled       = false;
                    }
                });
            }

            function validateCreateQty() {
                if (!createQtyInput || currentAvailableStock === 0) return;
                const val = parseInt(createQtyInput.value || '0', 10);
                if (val > currentAvailableStock) {
                    createQtyError.style.display = 'block';
                    createQtyError.textContent   = `Jumlah keluar (${val}) melebihi stok tersedia (${currentAvailableStock}).`;
                    submitCreateBtn.disabled     = true;
                } else {
                    createQtyError.style.display = 'none';
                    submitCreateBtn.disabled     = false;
                }
            }

            if (createQtyInput) {
                createQtyInput.addEventListener('input', validateCreateQty);
            }

            // ==========================================
            // MODAL EDIT STOK KELUAR
            // ==========================================
            const editModal         = document.getElementById('editStockOutModal');
            const closeEditModalBtn = document.getElementById('closeEditModalBtn');
            const cancelEditBtn     = document.getElementById('cancelEditModalBtn');
            const editForm          = document.getElementById('editStockOutForm');
            const editPreviewNum    = document.getElementById('editPreviewNumber');
            const editPreviewName   = document.getElementById('editPreviewName');
            const editPreviewAvail  = document.getElementById('editPreviewAvailable');
            const editQtyInput      = document.getElementById('editQuantity');
            const editUnitSuffix    = document.getElementById('editUnitSuffix');
            const editMaxText       = document.getElementById('editMaxQtyText');
            const editQtyError      = document.getElementById('editQtyError');
            const editExitDate      = document.getElementById('editExitDate');
            const editRecipient     = document.getElementById('editRecipient');
            const editDescription   = document.getElementById('editDescription');
            const submitEditBtn     = document.getElementById('submitEditBtn');

            let editMaxStock = 0;

            function openEditModal(btn) {
                const id        = btn.getAttribute('data-id');
                const matName   = btn.getAttribute('data-material-name');
                const matNum    = btn.getAttribute('data-material-number');
                const qty       = parseInt(btn.getAttribute('data-quantity') || '0', 10);
                const unit      = btn.getAttribute('data-unit') || 'Unit';
                const exitDate  = btn.getAttribute('data-exit-date') || '';
                const recipient = btn.getAttribute('data-recipient') || '';
                const desc      = btn.getAttribute('data-description') || '';
                const curStock  = parseInt(btn.getAttribute('data-current-stock') || '0', 10);

                editMaxStock = curStock + qty;

                editForm.action = `/materials/stock-out/${id}`;
                editPreviewNum.textContent   = matNum;
                editPreviewName.textContent  = matName;
                editPreviewAvail.textContent = `${editMaxStock.toLocaleString('id-ID')} ${unit} (${curStock.toLocaleString('id-ID')} + ${qty.toLocaleString('id-ID')})`;

                editQtyInput.value           = qty;
                editQtyInput.max             = editMaxStock;
                editUnitSuffix.textContent   = unit;
                editMaxText.textContent      = `${editMaxStock.toLocaleString('id-ID')} ${unit}`;
                editExitDate.value           = exitDate;
                editRecipient.value          = recipient;
                editDescription.value        = desc;

                editQtyError.style.display   = 'none';
                submitEditBtn.disabled       = false;

                if (editModal) {
                    editModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeEditModal() {
                if (editModal) {
                    editModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            document.querySelectorAll('.btn-open-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    openEditModal(this);
                });
            });

            if (closeEditModalBtn) closeEditModalBtn.addEventListener('click', closeEditModal);
            if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);

            if (editQtyInput) {
                editQtyInput.addEventListener('input', function () {
                    const val = parseInt(this.value || '0', 10);
                    if (val > editMaxStock) {
                        editQtyError.style.display = 'block';
                        editQtyError.textContent   = `Jumlah keluar (${val}) melebihi stok yang tersedia (${editMaxStock}).`;
                        submitEditBtn.disabled     = true;
                    } else {
                        editQtyError.style.display = 'none';
                        submitEditBtn.disabled     = false;
                    }
                });
            }

            // ==========================================
            // MODAL HAPUS STOK KELUAR
            // ==========================================
            const deleteModal         = document.getElementById('deleteStockOutModal');
            const cancelDeleteBtn     = document.getElementById('cancelDeleteModalBtn');
            const deleteForm          = document.getElementById('deleteStockOutForm');
            const deleteMatNameText   = document.getElementById('deleteMaterialNameText');
            const deleteQtyText       = document.getElementById('deleteQuantityText');

            function openDeleteModal(btn) {
                const id      = btn.getAttribute('data-id');
                const matName = btn.getAttribute('data-material-name');
                const qty     = btn.getAttribute('data-quantity');
                const unit    = btn.getAttribute('data-unit');

                deleteForm.action = `/materials/stock-out/${id}`;
                deleteMatNameText.textContent = matName;
                deleteQtyText.textContent     = `${qty} ${unit}`;

                if (deleteModal) {
                    deleteModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeDeleteModal() {
                if (deleteModal) {
                    deleteModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            document.querySelectorAll('.btn-open-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    openDeleteModal(this);
                });
            });

            if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);

            // Tutup modal jika klik di luar box
            window.addEventListener('click', function (e) {
                if (e.target === createModal) closeCreateModal();
                if (e.target === editModal) closeEditModal();
                if (e.target === deleteModal) closeDeleteModal();
            });

            // Tutup modal dengan tombol Escape
            window.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeCreateModal();
                    closeEditModal();
                    closeDeleteModal();
                }
            });
        }

        // Jalankan juga saat halaman dimuat lewat navigasi SPA.
        // DOMContentLoaded hanya terjadi sekali saat dokumen pertama kali dimuat.
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initStockOutPage, { once: true });
        } else {
            initStockOutPage();
        }
    </script>

    </main>


</body>

</html>
