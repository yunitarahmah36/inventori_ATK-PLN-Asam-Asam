<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Stok - STOK ATK PLN Asam-Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0"
        rel="stylesheet"
    >

    <style id="page-style">

        :root {
            --blue: #0057B8;
            --blue-dark: #003B73;
            --blue-light: #EAF3FF;
            --yellow: #FFC107;

            --white: #FFFFFF;
            --bg: #F5F7FA;
            --border: #E5E7EB;

            --text-dark: #1F2937;
            --text-mid: #4B5563;
            --text-muted: #6B7280;

            --green: #16A34A;
            --green-light: #ECFDF3;

            --red: #DC2626;
            --red-light: #FEF2F2;

            --orange: #EA580C;
            --orange-light: #FFF7ED;

            --purple: #7C3AED;
            --purple-light: #F5F3FF;

            --radius: 12px;

            --shadow:
                0 2px 8px rgba(0, 0, 0, 0.05);

            --header-h: 68px;
        }


        * {
            box-sizing: border-box;
        }


        html {
            overflow-y: scroll;
        }


        body {
            margin: 0;
            padding: 0;

            background: var(--bg);

            color: var(--text-dark);

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Arial,
                sans-serif;
        }


        a {
            text-decoration: none;
        }


        button,
        input,
        select {
            font-family: inherit;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            min-height: 100vh;

            margin-left: 260px;

            display: flex;
            flex-direction: column;

            min-width: 0;
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


        .btn-hamburger {
            display: none;

            width: 38px;
            height: 38px;

            align-items: center;
            justify-content: center;

            background: transparent;

            border: none;

            color: var(--text-dark);

            cursor: pointer;

            border-radius: 8px;
        }


        .btn-hamburger:hover {
            background: #F3F4F6;
        }


        .topbar-left h1 {
            margin: 0;

            font-size: 18px;
            font-weight: 800;

            color: var(--blue-dark);

            line-height: 1.2;
        }


        .topbar-left p {
            margin: 2px 0 0;

            font-size: 12px;

            color: var(--text-muted);
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

            background: var(--blue-light);

            color: var(--blue);

            font-size: 9px;

            font-weight: 800;

            text-transform: uppercase;
        }


        .topbar-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: var(--blue);

            color: #FFFFFF;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;

            font-weight: 800;

            flex-shrink: 0;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .stock-history-page {
            padding: 28px;

            min-height: calc(100vh - var(--header-h));

            background: var(--bg);
        }


        .page-container {
            width: 100%;

            max-width: 1500px;

            margin: 0 auto;
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header {
            display: flex;

            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 20px;
        }


        .page-header h1 {
            margin: 0;

            color: var(--blue-dark);

            font-size: 25px;

            font-weight: 800;

            line-height: 1.2;
        }


        .page-header p {
            margin: 6px 0 0;

            color: var(--text-muted);

            font-size: 13px;
        }


        /* =========================================================
           FILTER CARD
        ========================================================= */

        .filter-card {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: var(--radius);

            box-shadow: var(--shadow);

            padding: 20px;

            margin-bottom: 20px;
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


        .filter-group select,
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
            border: 1px solid #D1D5DB;

            background: #FFFFFF;

            color: var(--text-mid);
        }


        .btn-reset:hover {
            background: #F9FAFB;

            color: var(--blue);
        }


        .btn-filter .material-symbols-outlined {
            font-size: 18px;
        }


        /* =========================================================
           TABLE CARD
        ========================================================= */

        .table-card {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: var(--radius);

            box-shadow: var(--shadow);

            overflow: hidden;
        }


        .table-card-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 20px 22px;

            border-bottom: 1px solid var(--border);
        }


        .table-card-header h2 {
            margin: 0;

            color: var(--blue-dark);

            font-size: 17px;

            font-weight: 800;
        }


        .table-card-header p {
            margin: 4px 0 0;

            color: var(--text-muted);

            font-size: 12px;
        }


        /* =========================================================
           PER PAGE
        ========================================================= */

        .per-page-form {
            display: flex;

            align-items: center;

            gap: 8px;

            flex-shrink: 0;
        }


        .per-page-form label {
            font-size: 12px;

            font-weight: 600;

            color: var(--text-muted);
        }


        .per-page-form select {
            height: 36px;

            min-width: 90px;

            padding: 0 28px 0 10px;

            border: 1px solid #D1D5DB;

            border-radius: 7px;

            background: #FFFFFF;

            color: var(--text-dark);

            font-size: 12px;

            outline: none;

            cursor: pointer;
        }


        .per-page-form select:focus {
            border-color: var(--blue);
        }


        /* =========================================================
           TABLE
        ========================================================= */

        .table-responsive {
            width: 100%;

            overflow-x: auto;
        }


        .stock-history-table {
            width: 100%;

            min-width: 1100px;

            border-collapse: collapse;
        }


        .stock-history-table thead {
            background: #F8FAFC;
        }


        .stock-history-table th {
            padding: 13px 14px;

            text-align: left;

            border-bottom: 1px solid var(--border);

            color: #475569;

            font-size: 11px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .025em;

            white-space: nowrap;
        }


        .stock-history-table td {
            padding: 14px;

            border-bottom: 1px solid #EEF0F3;

            color: var(--text-mid);

            font-size: 12.5px;

            vertical-align: middle;
        }


        .stock-history-table tbody tr {
            transition: background .12s ease;
        }


        .stock-history-table tbody tr:hover {
            background: #F8FAFC;
        }


        .stock-history-table tbody tr:last-child td {
            border-bottom: none;
        }


        .stock-history-table th:first-child,
        .stock-history-table td:first-child {
            width: 50px;

            text-align: center;
        }


        /* =========================================================
           DATE
        ========================================================= */

        .date-main {
            color: var(--text-dark);

            font-weight: 700;

            font-size: 12px;
        }


        .date-time {
            color: var(--text-muted);

            font-size: 11px;

            margin-top: 3px;
        }


        /* =========================================================
           USER
        ========================================================= */

        .user-cell {
            display: flex;

            flex-direction: column;

            gap: 3px;

            min-width: 120px;
        }


        .user-name {
            color: var(--text-dark);

            font-weight: 700;

            font-size: 12px;
        }


        .user-role {
            color: var(--text-muted);

            font-size: 10px;

            text-transform: uppercase;

            font-weight: 700;
        }


        /* =========================================================
           MATERIAL
        ========================================================= */

        .material-cell {
            min-width: 180px;
        }


        .material-name {
            color: var(--text-dark);

            font-size: 12px;

            font-weight: 700;

            line-height: 1.4;
        }


        .material-number {
            display: inline-block;

            margin-top: 3px;

            color: var(--text-muted);

            font-size: 10.5px;

            font-weight: 600;
        }


        /* =========================================================
           ACTIVITY BADGE
        ========================================================= */

        .activity-badge {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10.5px;

            font-weight: 800;

            white-space: nowrap;
        }


        .activity-tambah {
            background: var(--green-light);

            color: var(--green);
        }


        .activity-kurangi,
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
            background: var(--orange-light);

            color: var(--orange);
        }


        .activity-default {
            background: #F3F4F6;

            color: #4B5563;
        }


        /* =========================================================
           QUANTITY
        ========================================================= */

        .quantity-before,
        .quantity-after {
            color: var(--text-dark);

            font-size: 12.5px;

            font-weight: 700;

            white-space: nowrap;
        }


        .quantity-change {
            display: inline-block;

            font-weight: 800;

            font-size: 12.5px;

            white-space: nowrap;
        }


        .change-positive {
            color: var(--green);
        }


        .change-negative {
            color: var(--red);
        }


        .change-zero {
            color: var(--text-muted);
        }


        /* =========================================================
           DESCRIPTION
        ========================================================= */

        .description-text {
            display: block;

            max-width: 220px;

            color: var(--text-muted);

            font-size: 11.5px;

            line-height: 1.5;

            white-space: normal;
        }


        /* =========================================================
           TABLE FOOTER
        ========================================================= */

        .table-footer {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 15px 20px;

            border-top: 1px solid var(--border);

            background: #FFFFFF;
        }


        .table-info {
            color: var(--text-muted);

            font-size: 12px;
        }


        .table-info strong {
            color: var(--text-dark);

            font-weight: 700;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .simple-pagination {
            display: flex;

            align-items: center;

            gap: 7px;
        }


        .simple-pagination a,
        .pagination-disabled,
        .pagination-current {
            min-height: 34px;

            padding: 0 11px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 7px;

            font-size: 11.5px;

            font-weight: 700;

            white-space: nowrap;
        }


        .simple-pagination a {
            border: 1px solid #D1D5DB;

            color: var(--blue);

            background: #FFFFFF;
        }


        .simple-pagination a:hover {
            background: var(--blue-light);

            border-color: #B9D5F5;
        }


        .pagination-current {
            background: var(--blue);

            color: #FFFFFF;

            border: 1px solid var(--blue);
        }


        .pagination-disabled {
            background: #F3F4F6;

            color: #9CA3AF;

            border: 1px solid #E5E7EB;
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {
            padding: 70px 30px;

            text-align: center;
        }


        .empty-icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: var(--blue-light);

            color: var(--blue);

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .empty-icon .material-symbols-outlined {
            font-size: 32px;
        }


        .empty-state h3 {
            margin: 0;

            color: var(--text-dark);

            font-size: 16px;

            font-weight: 800;
        }


        .empty-state p {
            margin: 7px 0 0;

            color: var(--text-muted);

            font-size: 12.5px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1200px) {

            .filter-form {
                grid-template-columns:
                    minmax(220px, 1fr)
                    minmax(160px, 1fr)
                    minmax(160px, 1fr)
                    minmax(160px, 1fr);
            }

            .filter-actions {
                grid-column: 1 / -1;

                justify-content: flex-end;
            }

        }


        @media (max-width: 900px) {

            .topbar {
                padding: 0 18px;
            }

            .stock-history-page {
                padding: 20px;
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .filter-actions {
                grid-column: 1 / -1;
            }

        }


        @media (max-width: 768px) {

            .main {
                margin-left: 0 !important;
            }


            .btn-hamburger {
                display: flex;
            }


            .topbar {
                height: 62px;

                padding: 0 14px;
            }


            .topbar-left h1 {
                font-size: 16px;
            }


            .topbar-left p {
                display: none;
            }


            .topbar-user-detail {
                display: none;
            }


            .topbar-avatar {
                width: 35px;
                height: 35px;

                font-size: 13px;
            }


            .stock-history-page {
                padding: 16px;
            }


            .page-header {
                margin-bottom: 16px;
            }


            .page-header h1 {
                font-size: 21px;
            }


            .page-header p {
                font-size: 11.5px;

                line-height: 1.5;
            }


            .filter-card {
                padding: 15px;
            }


            .filter-form {
                grid-template-columns: 1fr;
            }


            .filter-actions {
                grid-column: auto;

                justify-content: stretch;
            }


            .btn-filter,
            .btn-reset {
                flex: 1;
            }


            .table-card-header {
                align-items: flex-start;

                flex-direction: column;

                padding: 16px;
            }


            .per-page-form {
                width: 100%;

                justify-content: space-between;
            }


            .per-page-form select {
                flex: 1;

                max-width: 150px;
            }


            .table-footer {
                align-items: flex-start;

                flex-direction: column;

                padding: 14px 16px;
            }


            .simple-pagination {
                width: 100%;

                justify-content: space-between;
            }

        }


        @media (max-width: 480px) {

            .page-header h1 {
                font-size: 19px;
            }


            .page-header p {
                font-size: 11px;
            }


            .stock-history-page {
                padding: 12px;
            }


            .filter-card {
                padding: 12px;
            }


            .table-card-header h2 {
                font-size: 15px;
            }


            .table-card-header p {
                font-size: 11px;
            }


            .simple-pagination a,
            .pagination-disabled,
            .pagination-current {
                padding: 0 8px;

                font-size: 10.5px;
            }

        }

    </style>

</head>


<body>

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
                    <span class="material-symbols-outlined">
                        menu
                    </span>
                </button>


                <div class="topbar-left">

                    <h1>
                        Riwayat Stok
                    </h1>

                    <p>
                        Inventori ATK PLN Asam-Asam
                    </p>

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

        <div class="stock-history-page">

            <div class="page-container">


                {{-- =================================================
                     PAGE HEADER
                ================================================== --}}

                <div class="page-header">

                    <div>

                        <h1>
                            Riwayat Stok
                        </h1>

                        <p>
                            Catatan aktivitas perubahan stok material ATK PLN Asam-Asam
                        </p>

                    </div>

                </div>


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

                        <div class="filter-group search-group">

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
                                >

                            </div>

                        </div>


                        {{-- AKTIVITAS --}}

                        <div class="filter-group">

                            <label for="activity">
                                Aktivitas
                            </label>

                            <select
                                name="activity"
                                id="activity"
                            >

                                <option value="">
                                    Semua Aktivitas
                                </option>

                                <option
                                    value="Tambah"
                                    {{ request('activity') === 'Tambah' ? 'selected' : '' }}
                                >
                                    Tambah
                                </option>

                                <option
                                    value="Kurangi"
                                    {{ request('activity') === 'Kurangi' ? 'selected' : '' }}
                                >
                                    Kurangi
                                </option>

                                <option
                                    value="Edit"
                                    {{ request('activity') === 'Edit' ? 'selected' : '' }}
                                >
                                    Edit
                                </option>

                                <option
                                    value="Import"
                                    {{ request('activity') === 'Import' ? 'selected' : '' }}
                                >
                                    Import
                                </option>

                                <option
                                    value="Hapus"
                                    {{ request('activity') === 'Hapus' ? 'selected' : '' }}
                                >
                                    Hapus
                                </option>

                            </select>

                        </div>


                        {{-- TANGGAL MULAI --}}

                        <div class="filter-group">

                            <label for="start_date">
                                Dari Tanggal
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ request('start_date') }}"
                            >

                        </div>


                        {{-- TANGGAL SELESAI --}}

                        <div class="filter-group">

                            <label for="end_date">
                                Sampai Tanggal
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                value="{{ request('end_date') }}"
                            >

                        </div>


                        {{-- BUTTON --}}

                        <div class="filter-actions">

                            <button
                                type="submit"
                                class="btn-filter"
                            >

                                <span class="material-symbols-outlined">
                                    filter_alt
                                </span>

                                Filter

                            </button>


                            <a
                                href="{{ route('stock-movements.index') }}"
                                class="btn-reset"
                            >
                                Reset
                            </a>

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

                        <form
                            action="{{ route('stock-movements.index') }}"
                            method="GET"
                            class="per-page-form"
                        >

                            @foreach(request()->except(['per_page', 'page']) as $key => $value)

                                @if(is_array($value))

                                    @foreach($value as $item)

                                        <input
                                            type="hidden"
                                            name="{{ $key }}[]"
                                            value="{{ $item }}"
                                        >

                                    @endforeach

                                @else

                                    <input
                                        type="hidden"
                                        name="{{ $key }}"
                                        value="{{ $value }}"
                                    >

                                @endif

                            @endforeach


                            <label for="per_page">
                                Tampilkan
                            </label>


                            <select
                                name="per_page"
                                id="per_page"
                                onchange="this.form.submit()"
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
                                    {{ request('per_page') == 50 ? 'selected' : '' }}
                                >
                                    50
                                </option>

                                <option
                                    value="100"
                                    {{ request('per_page') == 100 ? 'selected' : '' }}
                                >
                                    100
                                </option>

                                <option
                                    value="250"
                                    {{ request('per_page') == 250 ? 'selected' : '' }}
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

                        </form>

                    </div>


                    {{-- =================================================
                         DATA ADA
                    ================================================== --}}

                    @if($movements->count() > 0)

                        <div class="table-responsive">

                            <table class="stock-history-table">

                                <thead>

                                    <tr>

                                        <th>
                                            No
                                        </th>

                                        <th>
                                            Tanggal & Waktu
                                        </th>

                                        <th>
                                            Pengguna
                                        </th>

                                        <th>
                                            Material
                                        </th>

                                        <th>
                                            Aktivitas
                                        </th>

                                        <th>
                                            Stok Sebelum
                                        </th>

                                        <th>
                                            Perubahan
                                        </th>

                                        <th>
                                            Stok Sesudah
                                        </th>

                                        <th>
                                            Keterangan
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($movements as $index => $movement)

                                        <tr>


                                            {{-- NO --}}

                                            <td>

                                                @if(method_exists($movements, 'firstItem'))

                                                    {{ $movements->firstItem() + $index }}

                                                @else

                                                    {{ $index + 1 }}

                                                @endif

                                            </td>


                                            {{-- TANGGAL --}}

                                            <td>

                                                @if($movement->created_at)

                                                    <div class="date-main">

                                                        {{ $movement->created_at->format('d/m/Y') }}

                                                    </div>

                                                    <div class="date-time">

                                                        {{ $movement->created_at->format('H:i') }} WITA

                                                    </div>

                                                @else

                                                    <div class="date-main">-</div>
                                                    <div class="date-time">-</div>

                                                @endif

                                            </td>


                                            {{-- PENGGUNA --}}

                                            <td>

                                                @php

                                                    $email = $movement->user->email ?? '';

                                                    $displayUser = '';

                                                    if ($email && str_contains($email, '@')) {

                                                        $displayUser = strtoupper(
                                                            strstr($email, '@', true)
                                                        );

                                                    }

                                                    if (empty($displayUser)) {

                                                        $displayUser = strtoupper(
                                                            $movement->user->name ?? 'USER'
                                                        );

                                                    }

                                                @endphp


                                                <div class="user-cell">

                                                    <div class="user-name">
                                                        {{ $displayUser }}
                                                    </div>

                                                    <div class="user-role">
                                                        {{ $movement->user->role ?? 'User' }}
                                                    </div>

                                                </div>

                                            </td>


                                            {{-- MATERIAL --}}

                                            <td>

                                                <div class="material-cell">

<div class="material-name">

    {{ $movement->material->name ?? '-' }}

</div>

<span class="material-number">

    No:
    {{ $movement->material->material_number ?? '-' }}
                                                    
</span>

                                                </div>

                                            </td>


                                            {{-- AKTIVITAS --}}

                                            <td>

                                                @php

                                                    $activity = strtolower(
                                                        trim($movement->activity ?? '')
                                                    );

                                                    $activityClass = match ($activity) {

                                                        'tambah' =>
                                                            'activity-tambah',

                                                        'kurangi',
                                                        'kurang' =>
                                                            'activity-kurangi',

                                                        'edit' =>
                                                            'activity-edit',

                                                        'import' =>
                                                            'activity-import',

                                                        'hapus' =>
                                                            'activity-hapus',

                                                        default =>
                                                            'activity-default',

                                                    };

                                                @endphp


                                                <span class="activity-badge {{ $activityClass }}">

                                                    {{ $movement->activity ?? '-' }}

                                                </span>

                                            </td>


                                            {{-- STOK SEBELUM --}}

                                            <td>

                                                <strong class="quantity-before">

                                                    {{ number_format(
                                                        $movement->quantity_before ?? 0,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </strong>

                                            </td>


                                            {{-- PERUBAHAN --}}

                                            <td>

                                                @php

                                                    $change = (int) (
                                                        $movement->quantity_change ?? 0
                                                    );

                                                @endphp


                                                <span
                                                    class="quantity-change
                                                    {{
                                                        $change > 0
                                                            ? 'change-positive'
                                                            : ($change < 0
                                                                ? 'change-negative'
                                                                : 'change-zero')
                                                    }}"
                                                >

                                                    {{ $change > 0 ? '+' : '' }}

                                                    {{ number_format(
                                                        $change,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </span>

                                            </td>


                                            {{-- STOK SESUDAH --}}

                                            <td>

                                                <strong class="quantity-after">

                                                    {{ number_format(
                                                        $movement->quantity_after ?? 0,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </strong>

                                            </td>


                                            {{-- KETERANGAN --}}

                                            <td>

                                                <span class="description-text">

                                                    {{ $movement->description ?: '-' }}

                                                </span>

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


                            {{-- INFO --}}

                            <div class="table-info">

                                @if(method_exists($movements, 'firstItem'))

                                    Menampilkan

                                    <strong>
                                        {{ $movements->firstItem() }}
                                    </strong>

                                    -

                                    <strong>
                                        {{ $movements->lastItem() }}
                                    </strong>

                                    dari

                                    <strong>
                                        {{ $movements->total() }}
                                    </strong>

                                    aktivitas

                                @else

                                    Menampilkan

                                    <strong>
                                        {{ $movements->count() }}
                                    </strong>

                                    aktivitas

                                @endif

                            </div>


                            {{-- PAGINATION --}}

                            @if(method_exists($movements, 'hasPages'))

                                @if($movements->hasPages())

                                    <div class="simple-pagination">


                                        {{-- PREVIOUS --}}

                                        @if($movements->onFirstPage())

                                            <span class="pagination-disabled">
                                                ← Sebelumnya
                                            </span>

                                        @else

                                            <a href="{{ $movements->previousPageUrl() }}">
                                                ← Sebelumnya
                                            </a>

                                        @endif


                                        {{-- CURRENT --}}

                                        <span class="pagination-current">

                                            Halaman
                                            {{ $movements->currentPage() }}

                                        </span>


                                        {{-- NEXT --}}

                                        @if($movements->hasMorePages())

                                            <a href="{{ $movements->nextPageUrl() }}">
                                                Berikutnya →
                                            </a>

                                        @else

                                            <span class="pagination-disabled">
                                                Berikutnya →
                                            </span>

                                        @endif

                                    </div>

                                @endif

                            @endif

                        </div>


                    {{-- =================================================
                         EMPTY STATE
                    ================================================== --}}

                    @else

                        <div class="empty-state">

                            <div class="empty-icon">

                                <span class="material-symbols-outlined">
                                    history
                                </span>

                            </div>


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

        </div>

    </main>


</body>

</html>