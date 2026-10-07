<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

    <title>Riwayat Stok - Inventori ATK PLN Asam-Asam</title>

    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Material Symbols --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">

    <style id="page-style">
        /* =========================================================
           LAYOUT & RESET
        ========================================================= */

        .layout {
            display: flex;
            min-height: 100vh;
        }

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

            --orange: #EA580C;
            --orange-light: #FFF7ED;

            --purple: #7C3AED;
            --purple-light: #F5F3FF;

            --sidebar-w: 260px;
            --header-h: 68px;

            --radius: 12px;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.07);

            --transition: 0.2s ease;
        }

        html {
            height: 100%;
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        body {
            min-height: 100%;
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


        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }


        /* =========================================================
           TOPBAR
        ========================================================= */

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

        .topbar-left-wrapper {
            display: flex;
            align-items: center;
            gap: 14px;
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
            flex-shrink: 0;
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


        /* =========================================================
           PAGE CONTENT
           SAMA DENGAN DATA MATERIAL
        ========================================================= */

        .page-content {
            padding: 24px 28px 80px;
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
            letter-spacing: -0.3px;
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
            padding: 20px;
            border: 1px solid var(--border);
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .filter-form {
            display: grid;

            grid-template-columns:
                minmax(250px, 1.6fr)
                minmax(170px, 1fr)
                minmax(160px, 1fr)
                minmax(160px, 1fr)
                auto;

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
    -moz-appearance: none;

    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 15px 15px;
}

.filter-group input[type="date"] {
    padding: 0 12px;
}

.search-input input:focus,
.filter-group select:focus,
.filter-group input[type="date"]:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(0, 87, 184, .10);
}

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

            box-shadow: 0 2px 6px rgba(0, 87, 184, .20);
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

        .table-card-header {
            padding: 22px 24px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            border-bottom: 1px solid var(--border);
        }

        .table-card-header h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            letter-spacing: -0.3px;
        }

        .table-card-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .per-page-form {
            display: flex;
            align-items: center;
            gap: 8px;

            font-size: 12px;
            color: var(--text-muted);
        }

        .per-page-form select {
            padding: 8px 10px;

            border: 1px solid var(--border);
            border-radius: 8px;

            background: #fff;

            font-size: 12px;
            font-weight: 600;

            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        .per-page-form select:focus {
            border-color: var(--blue);
        }


/* =========================================================
   TABLE - LEBIH COMPACT
========================================================= */

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

table.data-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    font-size: 12px;
    text-align: left;
}

table.data-table thead {
    background: #F8FAFC;
    border-bottom: 2px solid var(--border);
}

table.data-table th {
    padding: 10px 10px;
    font-weight: 700;
    color: var(--text-mid);
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
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
    padding: 10px 10px;
    vertical-align: middle;
    color: var(--text-dark);
    font-size: 12px;
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
            background: var(--purple-light);
            color: var(--purple);
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
           STOCK NUMBERS
        ========================================================= */

.stock-number {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--text-dark);
}

.change-positive,
.change-negative,
.change-zero {
    font-size: 11.5px;
}


        /* =========================================================
           DESCRIPTION
        ========================================================= */

.description {
    max-width: 130px;
    color: var(--text-muted);
    font-size: 10px;
    line-height: 1.35;
}

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {
            padding: 60px 20px;

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
            font-weight: 600;

            color: var(--text-dark);
            background: #fff;

            cursor: pointer;
            outline: none;
        }

        .per-page-select select:focus {
            border-color: var(--blue);
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
            padding: 7px 14px;

            border-radius: 7px;

            font-size: 12.5px;
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
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {
            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .filter-actions {
                grid-column: span 2;
            }
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
                padding: 16px 16px 80px;
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
            }

            .filter-actions .btn-filter,
            .filter-actions .btn-reset {
                flex: 1;
            }

            .table-card-header {
                padding: 18px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .per-page-form {
                width: 100%;
                justify-content: space-between;
            }

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

            .table-card-header h2 {
                font-size: 17px;
            }

            .table-card-header p {
                font-size: 11px;
            }
        }
    </style>
</head>


<body>

    <div class="layout">

        {{-- =========================================================
             SIDEBAR
        ========================================================== --}}
        @include('partials.sidebar')


    {{-- =========================================================
         MAIN
    ========================================================== --}}
    <main class="main">

        {{-- =====================================================
             TOPBAR
        ====================================================== --}}
        <header class="topbar">

            <div class="topbar-left-wrapper">

                <button
                    type="button"
                    class="btn-hamburger"
                    onclick="openSidebar()"
                    aria-label="Buka Menu"
                >
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="topbar-left">
                    <h1>Riwayat Stok</h1>
                    <p>Inventori ATK PLN Asam-Asam</p>
                </div>

            </div>


            {{-- USER TOPBAR --}}
            <div class="topbar-user">

                <div class="topbar-user-detail">

                    <div class="topbar-user-name">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="topbar-user-email">
                        {{ Auth::user()->email }}
                    </div>

                    <span class="badge-role">
                        {{ Auth::user()->role }}
                    </span>

                </div>

                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>

            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <div class="page-content">


            {{-- =================================================
                 FILTER
            ================================================== --}}
            <div class="filter-card">

                <form
                    action="{{ route('stock-movements.index') }}"
                    method="GET"
                    class="filter-form"
                >

                    {{-- SEARCH --}}
                    <div class="filter-group">

                        <label for="search">
                            Cari Riwayat
                        </label>

                        <div class="search-input">

                            <span class="material-symbols-outlined">
                                search
                            </span>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari material, pengguna, atau aktivitas..."
                                autocomplete="off"
                            >

                        </div>

                    </div>


                    {{-- AKTIVITAS --}}
                    <div class="filter-group">

                        <label>Aktivitas</label>

                        <select name="activity">
                            <option value="">Semua Aktivitas</option>
                            <option value="Tambah" {{ request('activity') == 'Tambah' ? 'selected' : '' }}>
                                Tambah
                            </option>
                            <option value="Kurangi" {{ request('activity') == 'Kurangi' ? 'selected' : '' }}>
                                Kurangi
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

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                        >

                    </div>


                    {{-- SAMPAI TANGGAL --}}
                    <div class="filter-group">

                        <label for="end_date">
                            Sampai Tanggal
                        </label>

                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                        >

                    </div>


                    {{-- BUTTON --}}
                    <div class="filter-actions">

                        <button
                            type="submit"
                            class="btn-filter"
                        >
                            <span class="material-symbols-outlined"
                                style="font-size:18px;">
                                filter_alt
                            </span>

                            Filter
                        </button>

                        @if (
                            request('search') ||
                            request('activity') ||
                            request('start_date') ||
                            request('end_date')
                        )

                            <a
                                href="{{ route('stock-movements.index') }}"
                                class="btn-reset"
                            >
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

                {{-- TABLE HEADER --}}
                <div class="table-card-header">

                    <div>

                        <h2>
                            Daftar Riwayat Stok
                        </h2>

                        <p>
                            Riwayat aktivitas perubahan stok material
                        </p>

                    </div>


                    {{-- PER PAGE --}}
                    <div class="per-page-form">

                        <label for="per_page_select">
                            Tampilkan
                        </label>

                        <select
                            id="per_page_select"
                            onchange="changePerPage(this.value)"
                        >

                            <option
                                value="10"
                                {{ request('per_page', 25) == 10 ? 'selected' : '' }}
                            >
                                10
                            </option>

                            <option
                                value="25"
                                {{ request('per_page', 25) == 25 ? 'selected' : '' }}
                            >
                                25
                            </option>

                            <option
                                value="50"
                                {{ request('per_page', 25) == 50 ? 'selected' : '' }}
                            >
                                50
                            </option>

                            <option
                                value="100"
                                {{ request('per_page', 25) == 100 ? 'selected' : '' }}
                            >
                                100
                            </option>

                            <option
                                value="250"
                                {{ request('per_page', 25) == 250 ? 'selected' : '' }}
                            >
                                250
                            </option>

                            <option
                                value="all"
                                {{ request('per_page') === 'all' ? 'selected' : '' }}
                            >
                                Semua
                            </option>

                        </select>

                    </div>

                </div>


                {{-- =================================================
                     TABLE
                ================================================== --}}

                @if ($movements->count() > 0)

                    <div class="table-responsive">

                        <table class="data-table">

<thead>
    <tr>

        <th style="width:40px;">
            No
        </th>

        <th style="width:120px;">
            Tanggal & Waktu
        </th>

        <th style="width:105px;">
            Pengguna
        </th>

        <th style="min-width:150px;">
            Material
        </th>

        <th style="width:90px;">
            Aktivitas
        </th>

        <th style="width:90px;">
            Stok Sebelum
        </th>

        <th style="width:80px;">
            Perubahan
        </th>

        <th style="width:90px;">
            Stok Sesudah
        </th>

        <th style="min-width:130px;">
            Keterangan
        </th>

    </tr>
</thead>


                            <tbody>

                                @foreach ($movements as $index => $movement)

                                    <tr>

                                        {{-- NO --}}
                                        <td>
                                            @if (method_exists($movements, 'firstItem'))

                                                {{ $movements->firstItem() + $index }}

                                            @else

                                                {{ $index + 1 }}

                                            @endif
                                        </td>


                                        {{-- TANGGAL & WAKTU --}}
                                        <td>

                                            <div class="date-main">
                                                {{ $movement->created_at
                                                    ? $movement->created_at->format('d/m/Y')
                                                    : '-' }}
                                            </div>

                                            <div class="date-time">
                                                {{ $movement->created_at
                                                    ? $movement->created_at->format('H:i') . ' WITA'
                                                    : '-' }}
                                            </div>

                                        </td>


                                        {{-- PENGGUNA --}}
                                        <td>

                                            @php
                                                $userName = $movement->user->name ?? 'Unknown';
                                                $userEmail = $movement->user->email ?? '';
                                                $displayUserName = $userEmail
                                                    ? strtoupper(strstr($userEmail, '@', true))
                                                    : strtoupper($userName);
                                            @endphp

                                            <div class="user-name">
                                                {{ $displayUserName }}
                                            </div>

                                            <div class="user-role">
                                                {{ $movement->user->role ?? '-' }}
                                            </div>

                                        </td>


                                        {{-- MATERIAL --}}
                                        <td>

                                            <div class="material-name">
                                                {{ $movement->material->name ?? '-' }}
                                            </div>

                                            <div class="material-number">
                                                No:
                                                {{ $movement->material->material_number ?? '-' }}
                                            </div>

                                        </td>


                                        {{-- AKTIVITAS --}}
                                        <td>

                                            @php
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
                                            @endphp

                                            <span class="activity-badge {{ $activityClass }}">
                                                {{ $movement->activity }}
                                            </span>

                                        </td>


                                        {{-- STOK SEBELUM --}}
                                        <td>

                                            <span class="stock-number">
                                                {{ number_format(
                                                    $movement->quantity_before ?? 0,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </span>

                                        </td>


                                        {{-- PERUBAHAN --}}
                                        <td>

                                            @php
                                                $change = (int) ($movement->quantity_change ?? 0);
                                            @endphp

                                            @if ($change > 0)

                                                <span class="change-positive">
                                                    + {{ number_format($change, 0, ',', '.') }}
                                                </span>

                                            @elseif ($change < 0)

                                                <span class="change-negative">
                                                    {{ number_format($change, 0, ',', '.') }}
                                                </span>

                                            @else

                                                <span class="change-zero">
                                                    0
                                                </span>

                                            @endif

                                        </td>


                                        {{-- STOK SESUDAH --}}
                                        <td>

                                            <span class="stock-number">
                                                {{ number_format(
                                                    $movement->quantity_after ?? 0,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </span>

                                        </td>


                                        {{-- KETERANGAN --}}
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
                         FOOTER TABLE
                    ================================================== --}}
                    <div class="table-footer">

                        <div class="table-footer-left">

                            <div class="data-info">

                                @if (
                                    request('per_page') === 'all' ||
                                    request('per_page') === 'Semua'
                                )

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
                                        {{ $movements->firstItem() ?? 0 }}–{{ $movements->lastItem() ?? 0 }}
                                    </strong>
                                    dari
                                    <strong>
                                        {{ $movements->total() }}
                                    </strong>
                                    aktivitas

                                @endif

                            </div>


                            <div class="per-page-select">

                                <label for="per_page_footer">
                                    Tampilkan:
                                </label>

                                <select
                                    id="per_page_footer"
                                    onchange="changePerPage(this.value)"
                                >

                                    <option
                                        value="10"
                                        {{ request('per_page', 25) == 10 ? 'selected' : '' }}
                                    >
                                        10
                                    </option>

                                    <option
                                        value="25"
                                        {{ request('per_page', 25) == 25 ? 'selected' : '' }}
                                    >
                                        25
                                    </option>

                                    <option
                                        value="50"
                                        {{ request('per_page', 25) == 50 ? 'selected' : '' }}
                                    >
                                        50
                                    </option>

                                    <option
                                        value="100"
                                        {{ request('per_page', 25) == 100 ? 'selected' : '' }}
                                    >
                                        100
                                    </option>

                                    <option
                                        value="250"
                                        {{ request('per_page', 25) == 250 ? 'selected' : '' }}
                                    >
                                        250
                                    </option>

                                    <option
                                        value="all"
                                        {{ request('per_page') === 'all' ? 'selected' : '' }}
                                    >
                                        Semua
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- PAGINATION --}}
                        @if (method_exists($movements, 'hasPages'))

                            <div class="simple-pagination">

                                @if ($movements->onFirstPage())

                                    <span class="pagination-btn disabled">

                                        <span
                                            class="material-symbols-outlined"
                                            style="font-size:16px;"
                                        >
                                            arrow_back
                                        </span>

                                        Sebelumnya

                                    </span>

                                @else

                                    <a
                                        href="{{ $movements->previousPageUrl() }}"
                                        class="pagination-btn"
                                    >

                                        <span
                                            class="material-symbols-outlined"
                                            style="font-size:16px;"
                                        >
                                            arrow_back
                                        </span>

                                        Sebelumnya

                                    </a>

                                @endif


                                @if ($movements->hasMorePages())

                                    <a
                                        href="{{ $movements->nextPageUrl() }}"
                                        class="pagination-btn"
                                    >

                                        Berikutnya

                                        <span
                                            class="material-symbols-outlined"
                                            style="font-size:16px;"
                                        >
                                            arrow_forward
                                        </span>

                                    </a>

                                @else

                                    <span class="pagination-btn disabled">

                                        Berikutnya

                                        <span
                                            class="material-symbols-outlined"
                                            style="font-size:16px;"
                                        >
                                            arrow_forward
                                        </span>

                                    </span>

                                @endif

                            </div>

                        @endif

                    </div>


                @else

                    {{-- EMPTY STATE --}}

                    <div class="empty-state">

                        <span class="material-symbols-outlined">
                            history
                        </span>

                        <h3>
                            Belum Ada Riwayat Stok
                        </h3>

                        <p>
                            Belum terdapat aktivitas perubahan stok material.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </main>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        function changePerPage(value) {

            const url = new URL(window.location.href);

            url.searchParams.set('per_page', value);

            url.searchParams.delete('page');

            if (typeof navigatePage === 'function') {
                navigatePage(url.toString(), true);
            } else {
                window.location.href = url.toString();
            }

        }


        window.addEventListener('resize', function () {

            if (window.innerWidth > 768) {

                if (typeof closeSidebar === 'function') {
                    closeSidebar();
                }

            }

        });

    </script>

</body>

</html>