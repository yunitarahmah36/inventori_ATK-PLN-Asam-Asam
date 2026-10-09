<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stok Masuk - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>

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
        }

        /* Header Card */
        .header-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px 24px;
            border: 1px solid var(--border);
            margin-bottom: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-card-title h2 {
            font-size: 19px;
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

        /* KPI Stats Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: var(--transition);
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .kpi-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi-icon.blue { background: var(--blue-light); color: var(--blue); }
        .kpi-icon.green { background: #DCFCE7; color: #16A34A; }
        .kpi-icon.amber { background: #FEF3C7; color: #D97706; }

        .kpi-info-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .kpi-info-val {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            margin-top: 2px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            font-family: inherit;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        .btn-yellow {
            background: var(--yellow);
            color: var(--blue-dark);
        }

        .btn-yellow:hover {
            background: #E0A800;
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: #F8FAFC;
            color: var(--text-dark);
        }

        /* Filter Card */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 16px 20px;
            border: 1px solid var(--border);
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
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-box .material-symbols-outlined {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 19px;
            color: var(--text-muted);
        }

        .search-box input {
            width: 100%;
            padding: 9px 12px 9px 38px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            background: #FAFAFA;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .date-input-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .date-input-group label {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-mid);
        }

        .date-input-group input[type="date"] {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 12.5px;
            font-family: inherit;
            color: var(--text-dark);
            background: #FAFAFA;
        }

        /* Data Table */
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

        .data-table thead {
            background: #F8FAFC;
            border-bottom: 1px solid var(--border);
        }

        .data-table th {
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .data-table td {
            padding: 13px 16px;
            border-bottom: 1px solid #F1F5F9;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: #F8FAFC;
        }

        .badge-material-number {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            background: #EFF6FF;
            color: var(--blue);
            font-weight: 700;
            font-size: 11.5px;
            font-family: monospace;
            border: 1px solid #DBEAFE;
        }

        .qty-badge-in {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            background: #DCFCE7;
            color: #15803D;
            font-weight: 700;
            font-size: 12px;
        }

        /* ============================================================
           TABLE FOOTER & PAGINATION (Biru-Putih PLN)
        ============================================================ */
        .table-footer {
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            background: #FAFBFD;
            border-top: 1px solid var(--border);
            font-size: 12.5px;
            color: var(--text-muted);
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

        .table-footer-info {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .table-footer-info strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .table-footer-pagination {
            display: flex;
            align-items: center;
        }

        .pagination-nav {
            display: flex;
            align-items: center;
        }

        .pagination-list,
        .pagination-nav ul,
        .table-footer ul.pagination {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .pagination-list li,
        .pagination-nav li,
        .table-footer li.page-item {
            list-style: none;
            margin: 0;
            padding: 0;
            display: inline-flex;
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

        /* Hover pada tombol aktif yang belum disabled/active */
        .page-link:hover:not(.disabled):not(.active),
        .table-footer a.page-link:hover {
            background: var(--blue-light);
            border-color: #BFDBFE;
            color: var(--blue);
        }

        /* Halaman Aktif: Warna Biru PLN Solid */
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

        /* Tombol Previous & Next Proporsional */
        .page-prev,
        .page-next {
            padding: 0 13px;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Halaman / Tombol Nonaktif (Disabled) Abu-abu */
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

        /* Pemisah Ellipsis Titik Tiga (...) */
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

        /* Ikon Panah Berukuran Normal */
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

        /* Pengaman jika ada SVG */
        .table-footer svg,
        .pagination-nav svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            vertical-align: middle;
            display: inline-block;
        }

        @media (max-width: 640px) {
            .table-footer {
                flex-direction: column;
                align-items: center;
                gap: 12px;
                text-align: center;
            }
            .table-footer-left {
                flex-direction: column;
                gap: 8px;
                align-items: center;
            }
            .pagination-list {
                justify-content: center;
            }
            .page-text {
                display: none;
            }
            .page-prev, .page-next {
                padding: 0 10px;
            }
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
        .modal-header-icon.yellow { background: var(--yellow-light); color: #B45309; }

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

        .callout-info {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: #1E40AF;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 12.5px;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .callout-info ul {
            margin: 6px 0 0 16px;
            padding: 0;
        }

        /* Upload Dropzone */
        .dropzone-area {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 24px 16px;
            text-align: center;
            background: #F8FAFC;
            cursor: pointer;
            transition: var(--transition);
        }

        .dropzone-area:hover {
            border-color: var(--blue);
            background: #F0F7FF;
        }

        .dropzone-area .material-symbols-outlined {
            font-size: 38px;
            color: var(--blue);
            margin-bottom: 6px;
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
                    <h1>Stok Masuk</h1>
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
                    <h2>Pencatatan Stok Masuk</h2>
                    <p>Catat penambahan stok secara manual atau import banyak material sekaligus via Excel.</p>
                </div>

                <div class="header-actions">
                    <!-- Tombol Input Manual -->
                    <button type="button" class="btn btn-primary" id="btnOpenManualModal">
                        <span class="material-symbols-outlined" style="font-size:19px;">add_circle</span>
                        Input Stok Masuk
                    </button>

                    <!-- Tombol Import Excel -->
                    <button type="button" class="btn btn-yellow" id="btnOpenImportModal">
                        <span class="material-symbols-outlined" style="font-size:19px;">upload_file</span>
                        Import Excel
                    </button>

                    <!-- Tombol Unduh Template -->
                    <a href="{{ route('materials.stock-in.template') }}" class="btn btn-outline" download>
                        <span class="material-symbols-outlined" style="font-size:19px;">download</span>
                        Template Excel
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
                        <div class="kpi-info-label">Total Transaksi Masuk</div>
                        <div class="kpi-info-val">{{ number_format($totalTransactions, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon green">
                        <span class="material-symbols-outlined">move_to_inbox</span>
                    </div>
                    <div>
                        <div class="kpi-info-label">Total Item Diterima</div>
                        <div class="kpi-info-val">+{{ number_format($totalQuantityIn, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon amber">
                        <span class="material-symbols-outlined">category</span>
                    </div>
                    <div>
                        <div class="kpi-info-label">Jenis Material Masuk</div>
                        <div class="kpi-info-val">{{ number_format($totalMaterialsIn, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Filter & Search Bar --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('materials.stock-in.index') }}" class="filter-form" id="filterForm">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">

                    <div class="search-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Material, nama material, keterangan, pengguna...">
                    </div>

                    <div class="date-input-group">
                        <label for="startDate">Dari:</label>
                        <input type="date" id="startDate" name="start_date" value="{{ $startDate }}">
                    </div>

                    <div class="date-input-group">
                        <label for="endDate">Sampai:</label>
                        <input type="date" id="endDate" name="end_date" value="{{ $endDate }}">
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding:8px 14px;">
                        <span class="material-symbols-outlined" style="font-size:17px;">filter_alt</span>
                        Filter
                    </button>

                    @if (!empty($search) || !empty($startDate) || !empty($endDate))
                        <a href="{{ route('materials.stock-in.index', ['per_page' => $perPage]) }}" class="btn btn-outline" style="padding:8px 12px;" title="Reset Filter" data-spa-link>
                            <span class="material-symbols-outlined" style="font-size:17px;">restart_alt</span>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabel Riwayat Stok Masuk --}}
            <div class="table-card">
                @if ($stockIns->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 140px;">No Material</th>
                                    <th>Nama Material</th>
                                    <th style="width: 130px;">Jumlah Masuk</th>
                                    <th style="width: 90px;">Satuan</th>
                                    <th>Keterangan / Sumber</th>
                                    <th style="width: 130px;">Tanggal Masuk</th>
                                    <th style="width: 140px;">Dicatat Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startNumber = ($stockIns->currentPage() - 1) * $stockIns->perPage();
                                @endphp
                                @foreach ($stockIns as $item)
                                    <tr>
                                        <td>{{ $startNumber + $loop->iteration }}</td>
                                        <td>
                                            <span class="badge-material-number">{{ $item->material_number }}</span>
                                        </td>
                                        <td style="font-weight: 600;">
                                            {{ $item->material_name ?: ($item->material->name ?? '-') }}
                                        </td>
                                        <td>
                                            <span class="qty-badge-in">
                                                <span class="material-symbols-outlined" style="font-size:15px;">add</span>
                                                {{ number_format(abs($item->quantity_change), 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td style="color:var(--text-mid);">
                                            {{ $item->material->unit ?? 'Unit' }}
                                        </td>
                                        <td style="color:var(--text-mid); font-size: 12.5px;">
                                            {{ $item->description ?: '-' }}
                                        </td>
                                        <td>
                                            {{ $item->created_at ? $item->created_at->translatedFormat('j M Y') : '-' }}
                                        </td>
                                        <td>
                                            <div style="font-weight:600; font-size:12.5px;">{{ $item->user->name ?? '-' }}</div>
                                            <div style="font-size:11px; color:var(--text-muted);">{{ $item->created_at ? $item->created_at->format('H:i') : '' }} WITA</div>
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
                                    Menampilkan <strong>1–{{ $stockIns->total() }}</strong> dari <strong>{{ $stockIns->total() }}</strong> transaksi
                                @else
                                    Menampilkan <strong>{{ $stockIns->firstItem() ?? 0 }}–{{ $stockIns->lastItem() ?? 0 }}</strong> dari <strong>{{ $stockIns->total() }}</strong> transaksi
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
                            {{ $stockIns->onEachSide(1)->links('partials.pagination') }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <span class="material-symbols-outlined">inbox</span>
                        <h3>Belum Ada Riwayat Stok Masuk</h3>
                        <p>Catat stok masuk material melalui tombol "Input Stok Masuk" atau "Import Excel".</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- ============================================================
             MODAL 1: INPUT MANUAL STOK MASUK
        ============================================================ --}}
        <div id="manualStockInModal" class="modal-backdrop-custom" aria-hidden="true" role="dialog">
            <div class="modal-box-custom">
                <button type="button" class="modal-close-btn" id="closeManualModalBtn" aria-label="Tutup">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="modal-header-custom">
                    <div class="modal-header-icon blue">
                        <span class="material-symbols-outlined" style="font-size:26px;">input</span>
                    </div>
                    <div>
                        <h3>Input Stok Masuk</h3>
                        <p>Pilih material terdaftar dan tambahkan kuantitas masuk ke stok.</p>
                    </div>
                </div>

                <form action="{{ route('materials.stock-in.store') }}" method="POST" id="manualStockInForm">
                    @csrf

                    <!-- Pilihan Material -->
                    <div class="form-group-custom">
                        <label for="selectMaterial" class="form-label-custom">
                            Pilih Material <span style="color:var(--red);">*</span>
                        </label>
                        <select id="selectMaterial" name="material_id" class="form-control-custom" required>
                            <option value="">-- Pilih Material (No Material & Nama) --</option>
                            @foreach ($allMaterials as $m)
                                <option value="{{ $m->id }}" 
                                        data-number="{{ $m->material_number }}" 
                                        data-name="{{ $m->name }}" 
                                        data-stock="{{ $m->quantity }}" 
                                        data-unit="{{ $m->unit }}">
                                    [{{ $m->material_number }}] {{ $m->name }} (Stok: {{ number_format($m->quantity, 0, ',', '.') }} {{ $m->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ringkasan Info Material yang Dipilih -->
                    <div id="selectedMaterialPreview" class="modal-card-preview" style="display:none;">
                        <div class="preview-row">
                            <span style="color:var(--text-muted);">No Material:</span>
                            <span class="badge-material-number" id="previewNumber">-</span>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Nama Material:</span>
                            <strong id="previewName" style="color:var(--text-dark);">-</strong>
                        </div>
                        <div class="preview-row" style="margin-top:4px;">
                            <span style="color:var(--text-muted);">Stok Saat Ini:</span>
                            <strong id="previewStock" style="color:var(--blue);">-</strong>
                        </div>
                    </div>

                    <!-- Jumlah Masuk -->
                    <div class="form-group-custom">
                        <label for="manualQuantity" class="form-label-custom">
                            Jumlah Masuk <span style="color:var(--red);">*</span>
                        </label>
                        <div style="position:relative;">
                            <input type="number" 
                                   id="manualQuantity" 
                                   name="quantity" 
                                   class="form-control-custom" 
                                   min="1" 
                                   required 
                                   placeholder="Masukkan kuantitas yang masuk">
                            <span id="manualUnitSuffix" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:12.5px;color:var(--text-muted);font-weight:600;">Unit</span>
                        </div>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="form-group-custom">
                        <label for="manualEntryDate" class="form-label-custom">
                            Tanggal Masuk <span style="color:var(--red);">*</span>
                        </label>
                        <input type="date" 
                               id="manualEntryDate" 
                               name="entry_date" 
                               class="form-control-custom" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                    </div>

                    <!-- Keterangan / Sumber -->
                    <div class="form-group-custom">
                        <label for="manualDescription" class="form-label-custom">
                            Keterangan / Dokumen Sumber <span style="color:var(--red);">*</span>
                        </label>
                        <textarea id="manualDescription" 
                                  name="description" 
                                  class="form-control-custom" 
                                  rows="3" 
                                  required 
                                  placeholder="Contoh: Pengadaan ATK Triwulan IV / No. Surat Jalan: SJ-2026-10..."></textarea>
                    </div>

                    <div class="modal-actions-custom">
                        <button type="button" class="btn btn-outline" id="cancelManualModalBtn">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitManualBtn">
                            <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                            Simpan Stok Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================================================
             MODAL 2: IMPORT EXCEL STOK MASUK
        ============================================================ --}}
        <div id="importStockInModal" class="modal-backdrop-custom" aria-hidden="true" role="dialog">
            <div class="modal-box-custom">
                <button type="button" class="modal-close-btn" id="closeImportModalBtn" aria-label="Tutup">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="modal-header-custom">
                    <div class="modal-header-icon yellow">
                        <span class="material-symbols-outlined" style="font-size:26px;">upload_file</span>
                    </div>
                    <div>
                        <h3>Import Stok Masuk via Excel</h3>
                        <p>Tambahkan stok untuk banyak material sekaligus menggunakan file Excel.</p>
                    </div>
                </div>

                <div class="callout-info">
                    <strong>Ketentuan Import Stok Masuk:</strong>
                    <ul>
                        <li>Setiap baris divalidasi berdasarkan <strong>No. Material dan Nama Material sekaligus</strong>.</li>
                        <li>Keduanya <strong>wajib cocok</strong> dengan satu data material yang sama di master Data Material.</li>
                        <li>Mendukung baris material yang <strong>bercampur dan berulang</strong>.</li>
                        <li>Sistem memvalidasi seluruh baris sebelum menyimpan. Jika ada kesalahan, proses dibatalkan tanpa mengubah stok.</li>
                    </ul>
                </div>

                <form action="{{ route('materials.stock-in.import') }}" method="POST" enctype="multipart/form-data" id="importStockInForm">
                    @csrf

                    <div class="form-group-custom">
                        <label for="importFile" class="form-label-custom">
                            Pilih File Excel (.xlsx, .xls, .csv) <span style="color:var(--red);">*</span>
                        </label>
                        <div class="dropzone-area" onclick="document.getElementById('importFile').click()">
                            <span class="material-symbols-outlined">cloud_upload</span>
                            <div style="font-weight:600;font-size:13.5px;color:var(--text-dark);" id="dropzoneText">Klik untuk memilih file Excel</div>
                            <div style="font-size:11.5px;color:var(--text-muted);margin-top:2px;">Format .xlsx, .xls, .csv (Maksimal 10MB)</div>
                        </div>
                        <input type="file" id="importFile" name="file" accept=".xlsx,.xls,.csv" style="display:none;" required>
                    </div>

                    <div style="margin-top:14px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
                        <a href="{{ route('materials.stock-in.template') }}" class="btn btn-outline" style="font-size:12px;padding:6px 12px;" download>
                            <span class="material-symbols-outlined" style="font-size:16px;">download</span>
                            Unduh Template Format
                        </a>

                        <div style="display:flex;gap:8px;">
                            <button type="button" class="btn btn-outline" id="cancelImportModalBtn">Batal</button>
                            <button type="submit" class="btn btn-yellow" id="submitImportBtn">
                                <span class="material-symbols-outlined" style="font-size:18px;">upload</span>
                                Proses Import
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <script id="stock-in-scripts">
    (function () {
        // --- Modal 1: Input Manual ---
        const manualModal      = document.getElementById('manualStockInModal');
        const openManualBtn    = document.getElementById('btnOpenManualModal');
        const closeManualBtn   = document.getElementById('closeManualModalBtn');
        const cancelManualBtn  = document.getElementById('cancelManualModalBtn');
        const manualForm       = document.getElementById('manualStockInForm');
        const submitManualBtn  = document.getElementById('submitManualBtn');

        const selectMaterial   = document.getElementById('selectMaterial');
        const previewCard      = document.getElementById('selectedMaterialPreview');
        const previewNumber    = document.getElementById('previewNumber');
        const previewName      = document.getElementById('previewName');
        const previewStock     = document.getElementById('previewStock');
        const manualUnitSuffix = document.getElementById('manualUnitSuffix');

        function openManualModal() {
            if (manualModal) manualModal.classList.add('show');
        }

        function closeManualModal() {
            if (manualModal) manualModal.classList.remove('show');
        }

        if (openManualBtn) openManualBtn.addEventListener('click', openManualModal);
        if (closeManualBtn) closeManualBtn.addEventListener('click', closeManualModal);
        if (cancelManualBtn) cancelManualBtn.addEventListener('click', closeManualModal);

        if (selectMaterial) {
            selectMaterial.addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];
                if (opt && opt.value) {
                    const number = opt.dataset.number;
                    const name   = opt.dataset.name;
                    const stock  = opt.dataset.stock;
                    const unit   = opt.dataset.unit || 'Unit';

                    previewNumber.textContent = number;
                    previewName.textContent   = name;
                    previewStock.textContent  = `${parseInt(stock, 10).toLocaleString('id-ID')} ${unit}`;
                    manualUnitSuffix.textContent = unit;
                    previewCard.style.display = 'block';
                } else {
                    previewCard.style.display = 'none';
                    manualUnitSuffix.textContent = 'Unit';
                }
            });
        }

        if (manualForm) {
            manualForm.addEventListener('submit', function () {
                submitManualBtn.disabled = true;
                submitManualBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size:18px;">hourglass_empty</span> Menyimpan...';
            });
        }

        // --- Modal 2: Import Excel ---
        const importModal     = document.getElementById('importStockInModal');
        const openImportBtn   = document.getElementById('btnOpenImportModal');
        const closeImportBtn  = document.getElementById('closeImportModalBtn');
        const cancelImportBtn = document.getElementById('cancelImportModalBtn');
        const importForm      = document.getElementById('importStockInForm');
        const submitImportBtn = document.getElementById('submitImportBtn');
        const importFileInput = document.getElementById('importFile');
        const dropzoneText    = document.getElementById('dropzoneText');

        function openImportModal() {
            if (importModal) importModal.classList.add('show');
        }

        function closeImportModal() {
            if (importModal) importModal.classList.remove('show');
        }

        if (openImportBtn) openImportBtn.addEventListener('click', openImportModal);
        if (closeImportBtn) closeImportBtn.addEventListener('click', closeImportModal);
        if (cancelImportBtn) cancelImportBtn.addEventListener('click', closeImportModal);

        if (importFileInput) {
            importFileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    dropzoneText.textContent = `File dipilih: ${this.files[0].name}`;
                    dropzoneText.style.color = 'var(--blue)';
                } else {
                    dropzoneText.textContent = 'Klik untuk memilih file Excel';
                    dropzoneText.style.color = 'var(--text-dark)';
                }
            });
        }

        if (importForm) {
            importForm.addEventListener('submit', function () {
                submitImportBtn.disabled = true;
                submitImportBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size:18px;">hourglass_empty</span> Memproses...';
            });
        }

        // Klik di luar modal untuk menutup
        window.addEventListener('click', function (e) {
            if (manualModal && e.target === manualModal) closeManualModal();
            if (importModal && e.target === importModal) closeImportModal();
        });

        // Escape untuk menutup modal
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeManualModal();
                closeImportModal();
            }
        });

        // Dropdown baris per halaman fallback
        window.changePerPage = window.changePerPage || function (val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.delete('page');
            if (typeof window.navigatePage === 'function') {
                window.navigatePage(url.toString(), true);
            } else {
                window.location.href = url.toString();
            }
        };
    })();
    </script>
    </main>

</body>

</html>
