<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Riwayat Stok - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>

    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Material Symbols --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">


    {{-- =========================================
          CSS HALAMAN INI
    ========================================== --}}
    <style id="page-style">
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

            --shadow:
                0 2px 12px rgba(0, 0, 0, 0.07);

            --transition:
                0.2s ease;
        }


        /* ============================================================
       RESET & BASE (HAPUS JARAK DEFAULT BROWSER)
    ============================================================ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
        input,
        select {
            font-family: inherit;
        }


        /* =========================================================
           SCROLLBAR
        ========================================================= */

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }


        /* =========================================================
           MAIN LAYOUT
        ========================================================= */

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


        /* ============================================================
           TOPBAR (Header - Seragam dengan Dashboard & Halaman Lain)
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
            font-family: 'Inter', Arial, sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .topbar-left p {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
            font-weight: 400;
            color: var(--text-muted);
            margin-top: 2px;
            margin-bottom: 0;
            line-height: 1.3;
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
            color: var(--text-dark);
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
            font-family: 'Inter', Arial, sans-serif;
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 59, 115, 0.25);
        }

        .topbar-user-detail {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .topbar-user-name {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .topbar-user-email {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 11px;
            font-weight: 400;
            color: var(--text-muted);
            margin-top: 1px;
            line-height: 1.2;
        }

        .badge-role {
            display: inline-block;
            margin-top: 2px;
            padding: 2px 8px;
            border-radius: 20px;
            background: var(--yellow-light);
            color: var(--blue-dark);
            font-family: 'Inter', Arial, sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1.2;
        }


        /* =========================================================
           PAGE CONTENT
        ========================================================= */

        .page-content {
            padding: 24px 28px 60px;
            flex: 1;
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            font-size: 25px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
            letter-spacing: -.3px;
        }

        .page-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }


        /* =========================================================
           FILTER CARD
        ========================================================= */

        .filter-card {
            background: var(--white);

            border-radius: var(--radius);
            border: 1px solid var(--border);

            padding: 20px;

            margin-bottom: 20px;

            box-shadow: var(--shadow);
        }

        .filter-form {
            display: grid;

            grid-template-columns:
                minmax(250px, 1.6fr) minmax(170px, 1fr) minmax(160px, 1fr) minmax(160px, 1fr) auto;

            gap: 14px;

            align-items: end;
        }

        .filter-group {
            min-width: 0;
        }

        .filter-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 12px;
            font-weight: 700;

            color: var(--text-mid);
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .search-input {
            position: relative;
            width: 100%;
        }

        .search-input .material-symbols-outlined {
            position: absolute;

            left: 12px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--text-muted);

            font-size: 20px;

            pointer-events: none;
        }

        .search-input input,
        .filter-group select,
        .filter-group input[type="date"] {

            width: 100%;
            height: 42px;

            border: 1px solid #D1D5DB;
            border-radius: 8px;

            background: #FFFFFF;
            color: var(--text-dark);

            font-size: 13px;

            outline: none;

            transition:
                border-color .15s ease,
                box-shadow .15s ease;
        }

        .search-input input {
            padding: 0 12px 0 40px;
        }

        .filter-group select {
            padding: 0 38px 0 12px;

            appearance: none;
            -webkit-appearance: none;

            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");

            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 15px;
        }

        .filter-group input[type="date"] {
            padding: 0 12px;
        }

        .search-input input:focus,
        .filter-group select:focus,
        .filter-group input[type="date"]:focus {

            border-color: var(--blue);

            box-shadow:
                0 0 0 3px rgba(0, 87, 184, .10);
        }


        /* =========================================================
           FILTER BUTTONS
        ========================================================= */

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-filter,
        .btn-reset {

            height: 42px;

            border-radius: 8px;

            padding: 0 16px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;
            white-space: nowrap;

            transition: .15s ease;
        }

        .btn-filter {
            border: none;

            background: var(--blue);
            color: #FFFFFF;

            box-shadow:
                0 2px 6px rgba(0, 87, 184, .20);
        }

        .btn-filter:hover {
            background: var(--blue-dark);
        }

        .btn-reset {
            background: #FFFFFF;
            color: var(--text-mid);

            border: 1px solid var(--border);
        }

        .btn-reset:hover {
            background: #F9FAFB;
            border-color: #CBD5E1;
        }


        /* =========================================================
           TABLE CARD
        ========================================================= */

        .table-card {
            background: var(--white);

            border-radius: var(--radius);

            border: 1px solid var(--border);

            box-shadow: var(--shadow);

            overflow: hidden;
        }


        /* =========================================================
           TABLE HEADER
        ========================================================= */

        .table-card-header {

            min-height: 80px;

            padding: 16px 24px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            border-bottom: 1px solid var(--border);
        }

        .table-card-title {
            min-width: 0;
        }

        .table-card-title h2 {
            font-size: 20px;

            font-weight: 800;

            color: var(--blue-dark);

            letter-spacing: -.3px;

            line-height: 1.3;
        }

        .table-card-title p {
            font-size: 12px;

            color: var(--text-muted);

            margin-top: 3px;
        }


        /* =========================================================
           TABLE ACTIONS
        ========================================================= */

        .table-card-actions {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 12px;

            flex-shrink: 0;
        }


        /* =========================================================
           PER PAGE
        ========================================================= */

        .per-page-form {

            display: flex;

            align-items: center;

            gap: 7px;

            font-size: 12px;

            color: var(--text-muted);

            white-space: nowrap;
        }

        .per-page-form label {
            font-size: 12px;
            color: var(--text-muted);
        }

        .per-page-form select {

            width: 72px;
            height: 40px;

            padding: 0 9px;

            border: 1px solid #D1D5DB;

            border-radius: 8px;

            background: #FFFFFF;

            color: var(--text-dark);

            font-size: 12px;

            font-weight: 600;

            outline: none;

            cursor: pointer;
        }

        .per-page-form select:hover {
            border-color: #94A3B8;
        }

        .per-page-form select:focus {

            border-color: var(--blue);

            box-shadow:
                0 0 0 3px rgba(0, 87, 184, .10);
        }


        /* =========================================================
           EXPORT PDF
        ========================================================= */

        .btn-export-pdf {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            height: 40px;

            padding: 0 15px;

            border-radius: 8px;

            background: var(--blue);

            color: #FFFFFF;

            font-size: 12.5px;

            font-weight: 700;

            text-decoration: none;

            white-space: nowrap;

            transition: .15s ease;

            box-shadow:
                0 2px 6px rgba(0, 87, 184, .20);
        }

        .btn-export-pdf:hover {

            background: var(--blue-dark);

            color: #FFFFFF;
        }

        .btn-export-pdf .material-symbols-outlined {
            font-size: 18px;
        }


        /* =========================================================
           TABLE RESPONSIVE
        ========================================================= */

        .table-responsive {

            width: 100%;

            overflow-x: auto;

            overflow-y: hidden;
        }


        /* =========================================================
           DATA TABLE
        ========================================================= */

        table.data-table {

            width: 100%;

            min-width: 1000px;

            border-collapse: collapse;

            font-size: 12px;

            text-align: left;
        }

        table.data-table thead {

            background: #F8FAFC;

            border-bottom: 2px solid var(--border);
        }

        table.data-table th {

            padding: 11px 10px;

            font-weight: 700;

            color: var(--text-mid);

            font-size: 10.5px;

            text-transform: uppercase;

            letter-spacing: .3px;

            white-space: nowrap;

            vertical-align: middle;
        }

        table.data-table tbody tr {

            border-bottom: 1px solid var(--border);

            transition:
                background var(--transition);
        }

        table.data-table tbody tr:last-child {
            border-bottom: none;
        }

        table.data-table tbody tr:hover {
            background: #F9FBFF;
        }

        table.data-table td {

            padding: 11px 10px;

            vertical-align: middle;

            color: var(--text-dark);

            font-size: 12px;
        }


        /* =========================================================
           TEXT CENTER
        ========================================================= */

        .text-center {
            text-align: center !important;
        }


        /* =========================================================
           DATE
        ========================================================= */

        .date-main {

            font-weight: 700;

            color: var(--text-dark);

            font-size: 11.5px;
        }

        .date-time {

            margin-top: 2px;

            font-size: 10px;

            color: var(--text-muted);
        }


        /* =========================================================
           USER
        ========================================================= */

        .user-name {

            font-weight: 700;

            font-size: 11.5px;

            color: var(--text-dark);

            text-transform: uppercase;
        }

        .user-role {

            margin-top: 2px;

            font-size: 9px;

            color: var(--text-muted);

            text-transform: uppercase;
        }


        /* =========================================================
           MATERIAL
        ========================================================= */

        .material-name {

            font-weight: 700;

            color: var(--text-dark);

            font-size: 11.5px;

            line-height: 1.3;
        }

        .material-number {

            margin-top: 2px;

            font-size: 9.5px;

            color: var(--text-muted);
        }


        /* =========================================================
           ACTIVITY BADGE
        ========================================================= */

        .activity-badge {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 4px 8px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;
        }

        .activity-tambah {

            background: var(--green-light);

            color: #059669;
        }

        .activity-kurang {

            background: var(--red-light);

            color: var(--red);
        }

        .activity-edit {

            background: var(--blue-light);

            color: var(--blue);
        }

        .activity-import {

            background: #FFF3E0;

            color: #E65100;
        }

        .activity-hapus {

            background: var(--red-light);

            color: var(--red);
        }

        .activity-default {

            background: #F1F5F9;

            color: var(--text-mid);
        }


        /* =========================================================
           STOCK NUMBER
        ========================================================= */

        .stock-number {

            font-size: 11.5px;

            font-weight: 700;

            color: var(--text-dark);

            white-space: nowrap;
        }


        /* =========================================================
           STOCK CHANGE BADGE
        ========================================================= */

        .stock-change-badge {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 48px;

            padding: 4px 8px;

            border-radius: 6px;

            font-size: 11px;

            font-weight: 700;

            line-height: 1.2;

            white-space: nowrap;
        }

        /* POSITIVE */

        .stock-change-positive {

            color: #047857;

            background: #D1FAE5;

            border: 1px solid #A7F3D0;
        }

        /* NEGATIVE */

        .stock-change-negative {

            color: #B91C1C;

            background: #FEE2E2;

            border: 1px solid #FECACA;
        }

        /* ZERO */

        .stock-change-zero {

            color: #6B7280;

            background: #F3F4F6;

            border: 1px solid #E5E7EB;
        }


        /* =========================================================
           DESCRIPTION
        ========================================================= */

        .description {

            max-width: 160px;

            color: var(--text-muted);

            font-size: 10px;

            line-height: 1.4;
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {

            padding: 70px 20px;

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

            line-height: 1.5;
        }


        /* =========================================================
           TABLE FOOTER
        ========================================================= */

        .table-footer {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 14px 20px;

            background: #FAFBFD;

            border-top: 1px solid var(--border);

            gap: 15px;
        }

        .table-footer-left {

            display: flex;

            align-items: center;

            gap: 16px;

            flex-wrap: wrap;
        }

        .data-info {

            font-size: 12px;

            color: var(--text-muted);

            font-weight: 500;
        }

        .data-info strong {

            color: var(--text-dark);

            font-weight: 700;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .simple-pagination {

            display: flex;

            align-items: center;

            gap: 8px;
        }

        .pagination-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            min-width: 110px;

            height: 36px;

            padding: 0 14px;

            border-radius: 7px;

            font-size: 12px;

            font-weight: 600;

            background: var(--white);

            color: var(--text-dark);

            border: 1px solid var(--border);

            transition: var(--transition);
        }

        .pagination-btn:hover:not(.disabled) {

            background: var(--blue-light);

            border-color: #BFDBFE;

            color: var(--blue);
        }

        .pagination-btn.disabled {

            opacity: .45;

            cursor: not-allowed;

            pointer-events: none;

            background: #F1F5F9;
        }


        /* =========================================================
           RESPONSIVE 1100px
        ========================================================= */

@media (max-width: 1550px) {
    .filter-form {
        grid-template-columns: 1.5fr 1fr 1fr 1fr auto;
        gap: 12px;
    }

    .filter-actions {
        grid-column: auto;
        display: flex;
        gap: 8px;
    }
}

        /* =========================================================
           RESPONSIVE 768px
        ========================================================= */

        @media (max-width: 768px) {

            .main {

                margin-left: 0;
            }

            .btn-hamburger {

                display: flex;

                align-items: center;

                justify-content: center;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-left h1 {
                font-size: 17px;
            }

            .page-content {

                padding:
                    16px 16px 40px;
            }

            .topbar-user-detail {

                display: none;
            }

            .page-header h2 {

                font-size: 21px;
            }

            .filter-form {

                grid-template-columns: 1fr;
            }

            .filter-actions {

                grid-column: auto;

                width: 100%;

                justify-content: stretch;
            }

            .filter-actions .btn-filter,
            .filter-actions .btn-reset {

                flex: 1;
            }


            /* TABLE HEADER MOBILE */

            .table-card-header {

                padding: 16px;

                flex-direction: column;

                align-items: stretch;

                gap: 14px;
            }

            .table-card-title h2 {

                font-size: 18px;
            }

            .table-card-title p {

                font-size: 11px;
            }

            .table-card-actions {

                width: 100%;

                justify-content: space-between;

                gap: 10px;
            }

            .per-page-form {

                flex: 1;
            }

            .per-page-form select {

                width: 70px;
            }

            .btn-export-pdf {

                flex-shrink: 0;
            }


            /* FOOTER */

            .table-footer {

                flex-direction: column;

                align-items: stretch;
            }

            .table-footer-left {

                justify-content: space-between;
            }

            .simple-pagination {

                width: 100%;

                justify-content: space-between;
            }

            .pagination-btn {

                flex: 1;
            }

        }


        /* =========================================================
           RESPONSIVE 480px
        ========================================================= */

        @media (max-width: 480px) {

            .page-header h2 {

                font-size: 19px;
            }

            .page-header p {

                font-size: 11px;
            }

            .filter-card {

                padding: 14px;
            }

            .table-card-actions {

                align-items: stretch;
            }

            .per-page-form {

                justify-content: flex-start;
            }

            .btn-export-pdf {

                padding: 0 12px;
            }

            .btn-export-pdf {

                font-size: 11px;
            }

            .table-footer-left {

                flex-direction: column;

                align-items: flex-start;

                gap: 10px;
            }

        }
    </style>

</head>


<body>


    {{-- =========================================================
         LAYOUT
    ========================================================= --}}

    <div class="layout">


        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}

        @include('partials.sidebar')


        {{-- =====================================================
             MAIN
        ====================================================== --}}

        <main class="main">

            <!-- ============================================================
                 TOPBAR / HEADER
            ============================================================ -->
            <header class="topbar">

                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" id="btnHamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Riwayat Stok</h1>
                        <p>Catatan aktivitas dan perubahan stok material ATK</p>
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


            {{-- =================================================
                 PAGE CONTENT
            ================================================== --}}

            <div class="page-content">

                {{-- =================================================
                     FILTER CARD
                ================================================== --}}

                <div class="filter-card">


                    <form action="{{ route('stock-movements.index') }}" method="GET" class="filter-form">


                        {{-- SEARCH --}}

                        <div class="filter-group">

                            <label for="search">
                                Cari Riwayat
                            </label>

                            <div class="search-input">

                                <span class="material-symbols-outlined">
                                    search
                                </span>

                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari material, pengguna, atau aktivitas..." autocomplete="off">

                            </div>

                        </div>


                        {{-- AKTIVITAS --}}

                        <div class="filter-group">

                            <label for="activity">
                                Aktivitas
                            </label>

                            <select name="activity" id="activity">

                                <option value="">
                                    Semua Aktivitas
                                </option>

                                <option value="Tambah" {{ request('activity') == 'Tambah' ? 'selected' : '' }}>

                                    Tambah

                                </option>

                                <option value="Edit" {{ request('activity') == 'Edit' ? 'selected' : '' }}>

                                    Edit

                                </option>

                                <option value="Import" {{ request('activity') == 'Import' ? 'selected' : '' }}>

                                    Import

                                </option>

                                <option value="Hapus" {{ request('activity') == 'Hapus' ? 'selected' : '' }}>

                                    Hapus

                                </option>

                            </select>

                        </div>


                        {{-- DARI TANGGAL --}}

                        <div class="filter-group">

                            <label for="start_date">
                                Dari Tanggal
                            </label>

                            <input type="date" id="start_date" name="start_date"
                                value="{{ request('start_date') }}">

                        </div>


                        {{-- SAMPAI TANGGAL --}}

                        <div class="filter-group">

                            <label for="end_date">
                                Sampai Tanggal
                            </label>

                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">

                        </div>


                        {{-- BUTTON --}}

                        <div class="filter-actions">


                            <button type="submit" class="btn-filter">

                                <span class="material-symbols-outlined" style="font-size:18px;">

                                    filter_alt

                                </span>

                                Filter

                            </button>


                            @if (request('search') || request('activity') || request('start_date') || request('end_date'))
                                <a href="{{ route('stock-movements.index') }}" class="btn-reset">

                                    Reset

                                </a>
                            @endif


                        </div>


                    </form>

                </div>


                {{-- =================================================
                     TABLE CARD
                ================================================== --}}

                <div class="table-card">


                    {{-- =================================================
                         TABLE HEADER
                    ================================================== --}}

                    <div class="table-card-header">


                        {{-- JUDUL --}}

                        <div class="table-card-title">

                            <h2>
                                Daftar Riwayat Stok
                            </h2>

                            <p>
                                Riwayat aktivitas perubahan stok material
                            </p>

                        </div>


                        {{-- =================================================
                             ACTION KANAN
                             HANYA ADA SATU PER PAGE
                        ================================================== --}}

                        <div class="table-card-actions">


                            {{-- PER PAGE --}}

                            <div class="per-page-form">

                                <label for="per_page_select">
                                    Tampilkan
                                </label>

                                <select id="per_page_select" onchange="changePerPage(this.value)">

                                    <option value="10" {{ request('per_page', 25) == 10 ? 'selected' : '' }}>

                                        10

                                    </option>

                                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>

                                        25

                                    </option>

                                    <option value="50" {{ request('per_page', 25) == 50 ? 'selected' : '' }}>

                                        50

                                    </option>

                                    <option value="100" {{ request('per_page', 25) == 100 ? 'selected' : '' }}>

                                        100

                                    </option>

                                    <option value="250" {{ request('per_page', 25) == 250 ? 'selected' : '' }}>

                                        250

                                    </option>

                                    <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>

                                        Semua

                                    </option>

                                </select>

                            </div>


                            {{-- EXPORT PDF --}}

                            <a href="{{ route('stock-movements.export-pdf', request()->query()) }}"
                                class="btn-export-pdf">

                                <span class="material-symbols-outlined">
                                    picture_as_pdf
                                </span>

                                Export PDF

                            </a>


                        </div>


                    </div>


                    {{-- =================================================
                         TABLE
                    ================================================== --}}

                    @if ($movements->count() > 0)


                        <div class="table-responsive">


                            <table class="data-table">


                                {{-- =================================================
                                     TABLE HEADER
                                ================================================== --}}

                                <thead>

                                    <tr>

                                        <th style="width:45px;">
                                            No
                                        </th>

                                        <th style="width:125px;">
                                            Tanggal & Waktu
                                        </th>

                                        <th style="width:110px;">
                                            Pengguna
                                        </th>

                                        <th style="min-width:170px;">
                                            Material
                                        </th>

                                        <th style="width:90px;">
                                            Aktivitas
                                        </th>

                                        <th style="width:95px;">
                                            Stok Sebelum
                                        </th>

                                        <th style="width:95px; text-align:center;">
                                            Perubahan
                                        </th>

                                        <th style="width:95px;">
                                            Stok Sesudah
                                        </th>

                                        <th style="min-width:150px;">
                                            Keterangan
                                        </th>

                                    </tr>

                                </thead>


                                {{-- =================================================
                                     TABLE BODY
                                ================================================== --}}

                                <tbody>


                                    @foreach ($movements as $index => $movement)
                                        @php

                                            /*
                                             * NOMOR
                                             */

                                            if (
                                                method_exists($movements, 'firstItem') &&
                                                $movements->firstItem() !== null
                                            ) {
                                                $rowNumber = $movements->firstItem() + $index;
                                            } else {
                                                $rowNumber = $index + 1;
                                            }

                                            /*
                                             * USER
                                             */

                                            $userName = $movement->user->name ?? 'Unknown';

                                            $userEmail = $movement->user->email ?? '';

                                            $displayUserName = $userEmail
                                                ? strtoupper(strstr($userEmail, '@', true))
                                                : strtoupper($userName);

                                            /*
                                             * ACTIVITY
                                             */

                                            $activity = strtolower($movement->activity ?? '');

                                            if (str_contains($activity, 'tambah')) {
                                                $activityClass = 'activity-tambah';
                                            } elseif (
                                                str_contains($activity, 'kurang') ||
                                                str_contains($activity, 'keluar')
                                            ) {
                                                $activityClass = 'activity-kurang';
                                            } elseif (str_contains($activity, 'edit')) {
                                                $activityClass = 'activity-edit';
                                            } elseif (str_contains($activity, 'import')) {
                                                $activityClass = 'activity-import';
                                            } elseif (str_contains($activity, 'hapus')) {
                                                $activityClass = 'activity-hapus';
                                            } else {
                                                $activityClass = 'activity-default';
                                            }

                                            /*
                                             * STOCK CHANGE
                                             */

                                            $change = (int) ($movement->quantity_change ?? 0);
                                        @endphp


                                        <tr>


                                            {{-- =================================================
                                                 NO
                                            ================================================== --}}

                                            <td>

                                                {{ $rowNumber }}

                                            </td>


                                            {{-- =================================================
                                                 TANGGAL
                                            ================================================== --}}

                                            <td>

                                                <div class="date-main">

                                                    {{ $movement->created_at ? $movement->created_at->format('d/m/Y') : '-' }}

                                                </div>

                                                <div class="date-time">

                                                    {{ $movement->created_at ? $movement->created_at->format('H:i') . ' WITA' : '-' }}

                                                </div>

                                            </td>


                                            {{-- =================================================
                                                 PENGGUNA
                                            ================================================== --}}

                                            <td>

                                                <div class="user-name">

                                                    {{ $displayUserName }}

                                                </div>

                                                <div class="user-role">

                                                    {{ $movement->user->role ?? '-' }}

                                                </div>

                                            </td>


                                            {{-- =================================================
                                                 MATERIAL
                                            ================================================== --}}

                                            <td>

                                                <div class="material-name">

                                                    {{ $movement->material->name ?? ($movement->material_name ?? '-') }}

                                                </div>

                                                <div class="material-number">

                                                    No:
                                                    {{ $movement->material->material_number ?? ($movement->material_number ?? '-') }}

                                                </div>

                                            </td>


                                            {{-- =================================================
                                                 AKTIVITAS
                                            ================================================== --}}

                                            <td>

                                                <span class="activity-badge {{ $activityClass }}">

                                                    {{ $movement->activity ?? '-' }}

                                                </span>

                                            </td>


                                            {{-- =================================================
                                                 STOK SEBELUM
                                            ================================================== --}}

                                            <td>

                                                <span class="stock-number">

                                                    {{ number_format($movement->quantity_before ?? 0, 0, ',', '.') }}

                                                </span>

                                            </td>


                                            {{-- =================================================
                                                 PERUBAHAN
                                            ================================================== --}}

                                            <td class="text-center">


                                                @if ($change > 0)
                                                    {{-- STOK BERTAMBAH --}}

                                                    <span class="stock-change-badge stock-change-positive">

                                                        +{{ number_format($change, 0, ',', '.') }}

                                                    </span>
                                                @elseif ($change < 0)
                                                    {{-- STOK BERKURANG --}}

                                                    <span class="stock-change-badge stock-change-negative">

                                                        {{ number_format($change, 0, ',', '.') }}

                                                    </span>
                                                @else
                                                    {{-- TIDAK ADA PERUBAHAN --}}

                                                    <span class="stock-change-badge stock-change-zero">

                                                        0

                                                    </span>
                                                @endif


                                            </td>


                                            {{-- =================================================
                                                 STOK SESUDAH
                                            ================================================== --}}

                                            <td>

                                                <span class="stock-number">

                                                    {{ number_format($movement->quantity_after ?? 0, 0, ',', '.') }}

                                                </span>

                                            </td>


                                            {{-- =================================================
                                                 KETERANGAN
                                            ================================================== --}}

                                            <td>

                                                <div class="description">

                                                    {{ $movement->description ?: '-' }}

                                                </div>

                                            </td>


                                        </tr>
                                    @endforeach


                                </tbody>


                            </table>


                        </div>


                        {{-- =================================================
                             TABLE FOOTER
                        ================================================== --}}

                        <div class="table-footer">


                            <div class="table-footer-left">


                                <div class="data-info">


                                    @if (request('per_page') === 'all' || request('per_page') === 'Semua')
                                        Menampilkan

                                        <strong>
                                            1–{{ $movements->count() }}
                                        </strong>

                                        dari

                                        <strong>
                                            {{ $movements->count() }}
                                        </strong>

                                        aktivitas
                                    @else
                                        Menampilkan

                                        <strong>
                                            {{ $movements->firstItem() ?? 0 }}
                                            –
                                            {{ $movements->lastItem() ?? 0 }}
                                        </strong>

                                        dari

                                        <strong>
                                            {{ $movements->total() }}
                                        </strong>

                                        aktivitas
                                    @endif


                                </div>


                            </div>


                            {{-- =================================================
                                 PAGINATION
                            ================================================== --}}

                            @if (method_exists($movements, 'hasPages'))


                                <div class="simple-pagination">


                                    {{-- SEBELUMNYA --}}

                                    @if ($movements->onFirstPage())
                                        <span class="pagination-btn disabled">

                                            <span class="material-symbols-outlined" style="font-size:16px;">

                                                arrow_back

                                            </span>

                                            Sebelumnya

                                        </span>
                                    @else
                                        <a href="{{ $movements->previousPageUrl() }}" class="pagination-btn">

                                            <span class="material-symbols-outlined" style="font-size:16px;">

                                                arrow_back

                                            </span>

                                            Sebelumnya

                                        </a>
                                    @endif


                                    {{-- BERIKUTNYA --}}

                                    @if ($movements->hasMorePages())
                                        <a href="{{ $movements->nextPageUrl() }}" class="pagination-btn">

                                            Berikutnya

                                            <span class="material-symbols-outlined" style="font-size:16px;">

                                                arrow_forward

                                            </span>

                                        </a>
                                    @else
                                        <span class="pagination-btn disabled">

                                            Berikutnya

                                            <span class="material-symbols-outlined" style="font-size:16px;">

                                                arrow_forward

                                            </span>

                                        </span>
                                    @endif


                                </div>


                            @endif


                        </div>
                    @else
                        {{-- =================================================
                             EMPTY STATE
                        ================================================== --}}

                        <div class="empty-state">


                            <span class="material-symbols-outlined">

                                history

                            </span>


                            <h3>

                                Belum Ada Riwayat Stok

                            </h3>


                            <p>

                                Belum terdapat aktivitas perubahan stok
                                material.

                            </p>


                        </div>


                    @endif


                </div>


            </div>


        </main>


    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================= --}}

    <script>
        /* =========================================================
                           CHANGE PER PAGE
                        ========================================================= */

        function changePerPage(value) {

            const url =
                new URL(window.location.href);

            /*
             * Simpan pilihan jumlah data
             */

            url.searchParams.set(
                'per_page',
                value
            );

            /*
             * Kembali ke halaman pertama
             */

            url.searchParams.delete(
                'page'
            );


            /*
             * Jika fungsi SPA tersedia
             */

            if (
                typeof navigatePage === 'function'
            ) {

                navigatePage(
                    url.toString(),
                    true
                );

            } else {

                /*
                 * Fallback biasa
                 */

                window.location.href =
                    url.toString();

            }

        }


        /* =========================================================
           ENTER PADA SEARCH
        ========================================================= */

        document.addEventListener(
            'DOMContentLoaded',
            function() {


                const searchInput =
                    document.getElementById('search');


                if (searchInput) {

                    searchInput.addEventListener(
                        'keydown',
                        function(event) {

                            if (
                                event.key === 'Enter'
                            ) {

                                event.preventDefault();

                                this
                                    .closest('form')
                                    .submit();

                            }

                        }
                    );

                }


            }
        );


        /* =========================================================
           RESPONSIVE SIDEBAR
        ========================================================= */

        window.addEventListener(
            'resize',
            function() {

                if (
                    window.innerWidth > 768
                ) {

                    if (
                        typeof closeSidebar === 'function'
                    ) {

                        closeSidebar();

                    }

                }

            }
        );
    </script>


</body>

</html>
