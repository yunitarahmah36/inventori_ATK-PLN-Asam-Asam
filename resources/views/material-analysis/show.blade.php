<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Detail Material: {{ $group['name'] }} - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <style id="page-style">
        /* ============================================================
           RESET & CSS VARIABLES (Seragam dengan Dashboard & Riwayat Stok)
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
            --orange: #F97316;
            --orange-light: #FFEDD5;
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

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            min-width: 0;
        }

        /* ============================================================
           TOPBAR HEADER
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
            transition: background var(--transition);
        }

        .btn-hamburger:hover {
            background: var(--bg);
        }

        .btn-hamburger .material-symbols-outlined {
            font-size: 22px;
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
            display: flex;
            flex-direction: column;
            align-items: flex-end;
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

        /* ============================================================
           PAGE CONTENT
        ============================================================ */
        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* Navigation Bar Back */
        .nav-back-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            background: var(--white);
            border: 1px solid var(--border);
            color: var(--text-mid);
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .btn-back:hover {
            background: var(--blue-light);
            border-color: #BFDBFE;
            color: var(--blue);
        }

        .btn-back .material-symbols-outlined {
            font-size: 18px;
        }

        /* ============================================================
           HERO DETAIL CARD
        ============================================================ */
        .hero-detail-card {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            border-radius: var(--radius);
            padding: 24px 28px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 59, 115, 0.2);
            flex-wrap: wrap;
            gap: 18px;
        }

        .hero-detail-card::before {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .hero-left {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.16);
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
        }

        .hero-tag .material-symbols-outlined {
            font-size: 15px;
            color: var(--yellow);
        }

        .hero-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.4px;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .hero-desc {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .hero-badges-list {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            font-family: monospace;
        }

        .hero-right-badge {
            position: relative;
            z-index: 1;
            background: var(--yellow);
            color: var(--blue-dark);
            padding: 16px 24px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .hero-right-num {
            font-size: 32px;
            font-weight: 800;
            line-height: 1;
        }

        .hero-right-unit {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 4px;
        }

        /* ============================================================
           STATISTIK CARDS (KPI)
        ============================================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.09);
        }

        .stat-card-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card-bar.yellow { background: var(--yellow); }
        .stat-card-bar.blue   { background: var(--blue); }
        .stat-card-bar.teal   { background: var(--green); }
        .stat-card-bar.orange { background: var(--orange); }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-card-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .stat-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-icon .material-symbols-outlined {
            font-size: 19px;
        }

        .stat-icon-yellow { background: var(--yellow-light); color: #B45309; }
        .stat-icon-blue   { background: var(--blue-light);   color: var(--blue); }
        .stat-icon-teal   { background: var(--green-light);  color: #065F46; }
        .stat-icon-orange { background: var(--orange-light); color: #C2410C; }

        .stat-card-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .stat-card-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ============================================================
           GRAFIK PERGERAKAN STOK MATERIAL (CHART.JS)
        ============================================================ */
        .chart-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 22px 26px;
            margin-bottom: 24px;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #F1F5F9;
            flex-wrap: wrap;
            gap: 12px;
        }

        .chart-header-left h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-header-left p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .chart-controls-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .period-switcher {
            display: inline-flex;
            align-items: center;
            background: #F1F5F9;
            padding: 3px;
            border-radius: 8px;
            gap: 2px;
            border: 1px solid #E2E8F0;
        }

        .btn-period {
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
        }

        .btn-period:hover {
            color: var(--blue-dark);
        }

        .btn-period.active {
            background: var(--blue);
            color: #ffffff;
            box-shadow: 0 1px 4px rgba(0, 87, 184, 0.25);
        }

        .picker-dynamic-wrap {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 3px 6px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }

        .picker-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            padding-left: 2px;
            white-space: nowrap;
        }

        .input-chart-date, .select-chart-year {
            border: 1px solid transparent;
            background: transparent;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: var(--text-dark);
            padding: 4px 6px;
            outline: none;
            border-radius: 4px;
        }

        .input-chart-date:focus, .select-chart-year:focus {
            background: #F8FAFC;
            border-color: var(--blue);
        }

        .btn-apply-chart {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--blue);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-apply-chart:hover {
            background: var(--blue-dark);
        }

        .btn-apply-chart:active {
            transform: scale(0.98);
        }

        .chart-period-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: var(--blue-dark);
            background: var(--blue-light);
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid rgba(0, 87, 184, 0.15);
        }

        .chart-legend-custom {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-mid);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .legend-color.green  { background: #10B981; }
        .legend-color.red    { background: #DC2626; }
        .legend-color.blue   { background: #0057B8; }

        .chart-container {
            position: relative;
            min-height: 320px;
            width: 100%;
        }

        /* ============================================================
           TABLE CARDS (RIWAYAT PERGERAKAN MATERIAL & RINCIAN ITEM TERDAFTAR)
        ============================================================ */
        .table-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-card-header {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            gap: 16px;
            flex-wrap: wrap;
        }

        .table-card-title h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-card-title p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .badge-count {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 12px;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 11.5px;
            font-weight: 700;
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

        table.data-table thead tr {
            background: #F8FAFC;
            border-bottom: 1px solid var(--border);
        }

        table.data-table th {
            padding: 13px 18px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        table.data-table tbody tr {
            border-bottom: 1px solid #F1F5F9;
            transition: background 0.15s ease;
        }

        table.data-table tbody tr:hover {
            background: #FAFBFD;
        }

        table.data-table td {
            padding: 14px 18px;
            vertical-align: middle;
            color: var(--text-mid);
        }

        /* Activity Badges */
        .badge-act {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .act-tambah { background: #D1FAE5; color: #065F46; }
        .act-edit   { background: #DBEAFE; color: #1E40AF; }
        .act-hapus  { background: #FEE2E2; color: #991B1B; }
        .act-import { background: #FEF3C7; color: #92400E; }

        /* Movement Change Badges */
        .change-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 13px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .change-in  { background: #ECFDF5; color: #065F46; }
        .change-out { background: #FEF2F2; color: #991B1B; }
        .change-none{ background: #F1F5F9; color: #64748B; }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-success { background: var(--green-light);  color: #065F46; }
        .status-warning { background: var(--yellow-light); color: #B45309; }
        .status-danger  { background: var(--red-light);    color: var(--red); }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-success .status-dot { background: var(--green); }
        .status-warning .status-dot { background: var(--yellow); }
        .status-danger  .status-dot { background: var(--red); }

        /* ============================================================
           RESPONSIVE MOBILE
        ============================================================ */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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
                padding: 0 16px;
            }

            .topbar-user-detail {
                display: none;
            }

            .page-content {
                padding: 16px 16px 60px;
            }

            .hero-detail-card {
                flex-direction: column;
                padding: 20px;
            }

            .hero-right-badge {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .chart-container {
                min-height: 250px;
            }
        }
    </style>
</head>

<body>
    <div class="layout">

        <!-- SIDEBAR -->
        @include('partials.sidebar')

        <!-- MAIN CONTENT AREA -->
        <main class="main">

            <!-- TOPBAR HEADER -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Detail Material</h1>
                        <p>Informasi stok, grafik pergerakan stok, dan riwayat pergerakan material</p>
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

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- NAV BACK -->
                <div class="nav-back-bar">
                    <a href="{{ route('material-analysis.index') }}" class="btn-back" data-spa-link>
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Kembali ke Analisis Material</span>
                    </a>
                </div>

                <!-- HERO DETAIL CARD -->
                <div class="hero-detail-card">
                    <div class="hero-left">
                        <div class="hero-tag">
                            <span class="material-symbols-outlined">inventory_2</span>
                            Identitas Material
                        </div>
                        <h2 class="hero-title">{{ $group['name'] }}</h2>
                        <p class="hero-desc">
                            Material ini memiliki satuan resmi <strong>{{ $group['unit'] }}</strong> dengan status ketersediaan
                            <span class="status-badge status-{{ $group['status_class'] }}" style="margin-left:6px;vertical-align:middle;">
                                <span class="status-dot"></span>
                                {{ $group['status'] }}
                            </span>.
                        </p>

                        <div class="hero-badges-list">
                            <span style="font-size:12px;color:rgba(255,255,255,0.75);margin-right:4px;">No Material:</span>
                            @foreach ($group['material_numbers'] as $no)
                                <span class="hero-pill">{{ $no }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="hero-right-badge">
                        <div class="hero-right-num">{{ number_format($group['total_quantity'], 0, ',', '.') }}</div>
                        <div class="hero-right-unit">Stok {{ $group['unit'] }} Saat Ini</div>
                    </div>
                </div>

                <!-- KPI STATS CARDS -->
                <div class="stats-grid">
                    <!-- Stat 1: Stok Saat Ini -->
                    <div class="stat-card">
                        <div class="stat-card-bar yellow"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Stok Fisik Saat Ini</span>
                            <div class="stat-card-icon stat-icon-yellow">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ number_format($group['total_quantity'], 0, ',', '.') }} <small style="font-size:14px;color:var(--text-muted);">{{ $group['unit'] }}</small></div>
                        <div class="stat-card-sub">
                            <span class="material-symbols-outlined" style="font-size:15px;color:var(--blue);">check_circle</span>
                            Tersedia
                        </div>
                    </div>

                    <!-- Stat 2: Total Stok Masuk -->
                    <div class="stat-card">
                        <div class="stat-card-bar teal"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Total Stok Masuk</span>
                            <div class="stat-card-icon stat-icon-teal">
                                <span class="material-symbols-outlined">move_to_inbox</span>
                            </div>
                        </div>
                        <div class="stat-card-value" style="color:#065F46;">+{{ number_format($group['total_masuk'], 0, ',', '.') }}</div>
                        <div class="stat-card-sub">
                            <span class="material-symbols-outlined" style="font-size:15px;color:#065F46;">arrow_upward</span>
                            Akumulasi penerimaan barang
                        </div>
                    </div>

                    <!-- Stat 3: Total Stok Keluar -->
                    <div class="stat-card">
                        <div class="stat-card-bar orange"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Total Stok Keluar</span>
                            <div class="stat-card-icon stat-icon-orange">
                                <span class="material-symbols-outlined">outbox</span>
                            </div>
                        </div>
                        <div class="stat-card-value" style="color:#C2410C;">-{{ number_format($group['total_keluar'], 0, ',', '.') }}</div>
                        <div class="stat-card-sub">
                            <span class="material-symbols-outlined" style="font-size:15px;color:#C2410C;">arrow_downward</span>
                            Akumulasi pengeluaran/pemakaian
                        </div>
                    </div>

                    <!-- Stat 4: Total Pergerakan Material -->
                    <div class="stat-card">
                        <div class="stat-card-bar blue"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Total Pergerakan Material</span>
                            <div class="stat-card-icon stat-icon-blue">
                                <span class="material-symbols-outlined">history</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ number_format($transactions->count(), 0, ',', '.') }}</div>
                        <div class="stat-card-sub">
                            <span class="material-symbols-outlined" style="font-size:15px;color:var(--blue);">receipt_long</span>
                            Pergerakan material tercatat di sistem
                        </div>
                    </div>
                </div>

                <!-- GRAFIK PERGERAKAN STOK MASUK DAN KELUAR -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-header-left">
                            <h3>
                                <span class="material-symbols-outlined" style="color:var(--blue);">show_chart</span>
                                <span>Grafik Pergerakan Stok Masuk & Keluar</span>
                            </h3>
                            <div style="display:flex;align-items:center;gap:8px;margin-top:4px;flex-wrap:wrap;">
                                <p style="margin:0;">Visualisasi tren mutasi stok masuk dan stok keluar berdasarkan periode waktu</p>
                                <span id="materialPeriodBadge" class="chart-period-badge">
                                    <span class="material-symbols-outlined" style="font-size:13px;">calendar_today</span>
                                    <span id="materialPeriodBadgeText">Memuat periode...</span>
                                </span>
                            </div>
                        </div>
                        <div class="chart-controls-wrap">
                            <!-- Switcher Tab Periode: Hari, Minggu, Bulan -->
                            <div class="period-switcher" role="group" aria-label="Pilih Periode Grafik">
                                <button type="button" class="btn-period btn-period-material active" data-period="hari" onclick="changeMaterialPeriodTab('hari')">Hari</button>
                                <button type="button" class="btn-period btn-period-material" data-period="minggu" onclick="changeMaterialPeriodTab('minggu')">Minggu</button>
                                <button type="button" class="btn-period btn-period-material" data-period="bulan" onclick="changeMaterialPeriodTab('bulan')">Bulan</button>
                            </div>

                            <!-- Input Date Picker / Select Dinamis Sesuai Periode -->
                            <div class="picker-dynamic-wrap">
                                <!-- Mode Hari: Pilih 1 Tanggal -->
                                <div id="materialGroupPickerHari" class="picker-group-item" style="display:flex;align-items:center;gap:4px;">
                                    <span class="picker-label">Tanggal:</span>
                                    <input type="date" id="materialPickerDateHari" class="input-chart-date" value="{{ date('Y-m-d') }}">
                                </div>

                                <!-- Mode Minggu: Pilih 1 Tanggal Mulai (7 Hari Penuh) -->
                                <div id="materialGroupPickerMinggu" class="picker-group-item" style="display:none;align-items:center;gap:4px;">
                                    <span class="picker-label">Mulai:</span>
                                    <input type="date" id="materialPickerDateMinggu" class="input-chart-date" value="{{ date('Y-m-d', strtotime('-6 days')) }}">
                                </div>

                                <!-- Mode Bulan: Pilih Tahun (Januari - Desember) -->
                                <div id="materialGroupPickerBulan" class="picker-group-item" style="display:none;align-items:center;gap:4px;">
                                    <span class="picker-label">Tahun:</span>
                                    <select id="materialPickerSelectTahun" class="select-chart-year">
                                        @foreach ($availableYears as $yr)
                                            <option value="{{ $yr }}" {{ $yr == date('Y') ? 'selected' : '' }}>{{ $yr }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tombol Terapkan Filter -->
                                <button type="button" class="btn-apply-chart" onclick="applyMaterialChartFilter()" title="Terapkan Filter Grafik">
                                    <span class="material-symbols-outlined" style="font-size:15px;">filter_alt</span>
                                    <span>Terapkan</span>
                                </button>
                            </div>

                            <!-- Legend -->
                            <div class="chart-legend-custom">
                                <div class="legend-item">
                                    <span class="legend-color green"></span>
                                    <span>Stok Masuk</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color red"></span>
                                    <span>Stok Keluar</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="materialTimelineChart"></canvas>
                    </div>
                </div>

                <!-- TABEL RINCIAN ENTRI ASLI DATABASE (JIKA GABUNGAN) -->
                @if ($group['items_count'] > 1)
                    <div class="table-card">
                        <div class="table-card-header">
                            <div class="table-card-title">
                                <h3>
                                    <span class="material-symbols-outlined" style="color:var(--blue);">format_list_bulleted</span>
                                    <span>Rincian Entri Terdaftar dalam Kelompok Ini</span>
                                    <span class="badge-count">{{ $group['items_count'] }} Entri</span>
                                </h3>
                                <p>Daftar data individual di database yang digabungkan karena kesamaan nama (case-insensitive)</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width:50px;text-align:center;">No</th>
                                        <th>No Material</th>
                                        <th>Nama Asli di Input</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Stok Fisik</th>
                                        <th>Satuan</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group['items'] as $itIdx => $item)
                                        <tr>
                                            <td style="text-align:center;font-weight:600;color:var(--text-muted);">{{ $itIdx + 1 }}</td>
                                            <td><strong style="color:var(--blue-dark);font-family:monospace;">{{ $item->material_number }}</strong></td>
                                            <td><strong style="color:var(--text-dark);">{{ $item->name }}</strong></td>
                                            <td style="color:var(--text-muted);">{{ $item->entry_date ? $item->entry_date->format('d/m/Y') : '-' }}</td>
                                            <td><strong style="color:var(--blue);">{{ number_format($item->quantity, 0, ',', '.') }}</strong></td>
                                            <td>{{ $item->unit }}</td>
                                            <td style="color:var(--text-muted);">{{ $item->creator ? $item->creator->name : '-' }}</td>
                                            <td style="color:var(--text-muted);">{{ $item->description ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- TABEL RIWAYAT PERGERAKAN MATERIAL -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div class="table-card-title">
                            <h3>
                                <span class="material-symbols-outlined" style="color:var(--blue);">receipt_long</span>
                                <span>Riwayat Pergerakan Material</span>
                                <span class="badge-count">{{ $transactions->count() }} Pergerakan Material</span>
                            </h3>
                            <p>Catatan lengkap seluruh pergerakan material masuk, keluar, penyesuaian, dan penghapusan</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width:50px;text-align:center;">No</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Aktivitas</th>
                                    <th>Stok Sebelum</th>
                                    <th>Perubahan Stok</th>
                                    <th>Stok Sesudah</th>
                                    <th>Operator</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $tIdx => $trx)
                                    <tr>
                                        <td style="text-align:center;font-weight:600;color:var(--text-muted);">
                                            {{ $tIdx + 1 }}
                                        </td>
                                        <td style="white-space:nowrap;font-weight:600;color:var(--text-dark);">
                                            {{ $trx->created_at ? $trx->created_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $actClass = match($trx->activity) {
                                                    'Tambah' => 'act-tambah',
                                                    'Edit'   => 'act-edit',
                                                    'Hapus'  => 'act-hapus',
                                                    'Import' => 'act-import',
                                                    default  => 'act-edit'
                                                };
                                            @endphp
                                            <span class="badge-act {{ $actClass }}">
                                                {{ $trx->activity }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ number_format($trx->quantity_before, 0, ',', '.') }} {{ $group['unit'] }}
                                        </td>
                                        <td>
                                            @if ($trx->quantity_change > 0)
                                                <span class="change-badge change-in">
                                                    <span class="material-symbols-outlined" style="font-size:15px;">arrow_upward</span>
                                                    +{{ number_format($trx->quantity_change, 0, ',', '.') }}
                                                </span>
                                            @elseif ($trx->quantity_change < 0)
                                                <span class="change-badge change-out">
                                                    <span class="material-symbols-outlined" style="font-size:15px;">arrow_downward</span>
                                                    {{ number_format($trx->quantity_change, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="change-badge change-none">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong style="color:var(--blue);">
                                                {{ number_format($trx->quantity_after, 0, ',', '.') }} {{ $group['unit'] }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span style="font-weight:600;color:var(--text-mid);">
                                                {{ $trx->user ? $trx->user->name : 'Sistem' }}
                                            </span>
                                        </td>
                                        <td style="color:var(--text-muted);max-width:280px;">
                                            {{ $trx->description ?: '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align:center;padding:40px 20px;color:var(--text-muted);">
                                            <div style="display:flex;flex-direction:column;align-items:center;gap:10px;">
                                                <span class="material-symbols-outlined" style="font-size:44px;color:#CBD5E1;">history_toggle_off</span>
                                                <p style="font-size:14px;font-weight:600;">Belum ada catatan pergerakan material untuk item ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- JAVASCRIPT LOGIC & TIMELINE CHART (Di dalam <main> untuk kompatibilitas SPA) -->
            <script id="page-script">
                (function () {
                    const rawMovements = @json($rawMovements ?? []);
                    let currentMaterialPeriod = 'hari';

                    function ensureChartJs(callback) {
                        if (typeof Chart !== 'undefined') {
                            callback();
                            return;
                        }
                        let script = document.querySelector('script[src*="chart.umd.min.js"]');
                        if (!script) {
                            script = document.createElement('script');
                            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js';
                            script.onload = () => callback();
                            script.onerror = () => console.error('Gagal memuat Chart.js dari CDN');
                            document.head.appendChild(script);
                        } else {
                            script.addEventListener('load', () => callback());
                        }
                    }

                    // Format tanggal singkat: 08 Okt
                    function formatShortDate(dateObj) {
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                        const dd = String(dateObj.getDate()).padStart(2, '0');
                        return dd + ' ' + months[dateObj.getMonth()];
                    }

                    // Format tanggal lengkap Indonesia: 08 Okt 2026
                    function formatDateIndo(dateStr) {
                        if (!dateStr) return '-';
                        const parts = dateStr.split('-');
                        if (parts.length !== 3) return dateStr;
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                        const mIdx = parseInt(parts[1], 10) - 1;
                        return parts[2] + ' ' + (months[mIdx] || parts[1]) + ' ' + parts[0];
                    }

                    // Menghitung dataset dan labels berdasarkan periode dan filter yang dipilih
                    function computeMaterialChartData(period) {
                        let labels = [];
                        let masuk = [];
                        let keluar = [];
                        let infoBadgeText = '';

                        if (period === 'hari') {
                            const dateInput = document.getElementById('materialPickerDateHari');
                            const targetDate = dateInput ? dateInput.value : '';
                            const labelTgl = targetDate ? formatDateIndo(targetDate) : 'Hari Ini';
                            infoBadgeText = 'Tanggal: ' + labelTgl;

                            labels = [labelTgl];
                            let sumMasuk = 0;
                            let sumKeluar = 0;

                            if (targetDate) {
                                rawMovements.forEach(m => {
                                    if (m.d === targetDate) {
                                        if (m.c > 0) sumMasuk += m.c;
                                        else if (m.c < 0) sumKeluar += Math.abs(m.c);
                                    }
                                });
                            }
                            masuk = [sumMasuk];
                            keluar = [sumKeluar];

                        } else if (period === 'minggu') {
                            const weekInput = document.getElementById('materialPickerDateMinggu');
                            const startStr = weekInput && weekInput.value ? weekInput.value : '{{ date("Y-m-d", strtotime("-6 days")) }}';
                            const startDate = new Date(startStr + 'T00:00:00');

                            for (let i = 0; i < 7; i++) {
                                const curDate = new Date(startDate);
                                curDate.setDate(startDate.getDate() + i);

                                const yyyy = curDate.getFullYear();
                                const mm = String(curDate.getMonth() + 1).padStart(2, '0');
                                const dd = String(curDate.getDate()).padStart(2, '0');
                                const dateKey = `${yyyy}-${mm}-${dd}`;

                                labels.push(formatShortDate(curDate));

                                let sumMasuk = 0;
                                let sumKeluar = 0;
                                rawMovements.forEach(m => {
                                    if (m.d === dateKey) {
                                        if (m.c > 0) sumMasuk += m.c;
                                        else if (m.c < 0) sumKeluar += Math.abs(m.c);
                                    }
                                });
                                masuk.push(sumMasuk);
                                keluar.push(sumKeluar);
                            }

                            const endLabel = labels[6] || '';
                            infoBadgeText = '1 Minggu (' + labels[0] + ' - ' + endLabel + ')';

                        } else if (period === 'bulan') {
                            const yearSelect = document.getElementById('materialPickerSelectTahun');
                            const targetYear = yearSelect ? yearSelect.value : '{{ date("Y") }}';
                            infoBadgeText = 'Tahun ' + targetYear + ' (Januari - Desember)';

                            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                            labels = monthNames;

                            for (let m = 1; m <= 12; m++) {
                                const mKey = `${targetYear}-${String(m).padStart(2, '0')}`;
                                let sumMasuk = 0;
                                let sumKeluar = 0;
                                rawMovements.forEach(item => {
                                    if (item.m === mKey) {
                                        if (item.c > 0) sumMasuk += item.c;
                                        else if (item.c < 0) sumKeluar += Math.abs(item.c);
                                    }
                                });
                                masuk.push(sumMasuk);
                                keluar.push(sumKeluar);
                            }
                        }

                        return {
                            labels: labels,
                            masuk: masuk,
                            keluar: keluar,
                            infoBadge: infoBadgeText
                        };
                    }

                    // Mengganti tab periode (Hari, Minggu, Bulan)
                    function changeMaterialPeriodTab(period) {
                        currentMaterialPeriod = period;

                        // Toggle active class tab button
                        document.querySelectorAll('.btn-period-material').forEach(btn => {
                            btn.classList.toggle('active', btn.dataset.period === period);
                        });

                        // Tampilkan picker yang sesuai periode
                        const gHari = document.getElementById('materialGroupPickerHari');
                        const gMinggu = document.getElementById('materialGroupPickerMinggu');
                        const gBulan = document.getElementById('materialGroupPickerBulan');

                        if (gHari) gHari.style.display = (period === 'hari') ? 'flex' : 'none';
                        if (gMinggu) gMinggu.style.display = (period === 'minggu') ? 'flex' : 'none';
                        if (gBulan) gBulan.style.display = (period === 'bulan') ? 'flex' : 'none';

                        // Terapkan filter grafik seketika tanpa reload
                        applyMaterialChartFilter();
                    }
                    window.changeMaterialPeriodTab = changeMaterialPeriodTab;
                    window.switchMaterialPeriod = changeMaterialPeriodTab; // alias backwards-compat

                    // Menerapkan filter pada grafik tanpa reload halaman
                    function applyMaterialChartFilter() {
                        const data = computeMaterialChartData(currentMaterialPeriod);

                        // Update badge info
                        const badgeTextEl = document.getElementById('materialPeriodBadgeText');
                        if (badgeTextEl) {
                            badgeTextEl.textContent = data.infoBadge;
                        }

                        if (!window._myMaterialTimelineChart) {
                            initTimelineChart();
                            return;
                        }

                        window._myMaterialTimelineChart.data.labels = data.labels;
                        window._myMaterialTimelineChart.data.datasets[0].data = data.masuk;
                        window._myMaterialTimelineChart.data.datasets[1].data = data.keluar;

                        // Sesuaikan proporsi batang grafik
                        if (currentMaterialPeriod === 'hari') {
                            window._myMaterialTimelineChart.data.datasets[0].barPercentage = 0.25;
                            window._myMaterialTimelineChart.data.datasets[1].barPercentage = 0.25;
                        } else {
                            window._myMaterialTimelineChart.data.datasets[0].barPercentage = 0.55;
                            window._myMaterialTimelineChart.data.datasets[1].barPercentage = 0.55;
                        }

                        window._myMaterialTimelineChart.update();
                    }
                    window.applyMaterialChartFilter = applyMaterialChartFilter;

                    function initTimelineChart() {
                        ensureChartJs(function () {
                            const canvas = document.getElementById('materialTimelineChart');
                            if (!canvas) return;

                            // Hancurkan chart lama jika ada agar tidak konflik saat render ulang SPA
                            if (window._myMaterialTimelineChart) {
                                try {
                                    window._myMaterialTimelineChart.destroy();
                                } catch (e) {}
                                window._myMaterialTimelineChart = null;
                            }

                            if (typeof Chart !== 'undefined' && typeof Chart.getChart === 'function') {
                                const existingChart = Chart.getChart(canvas);
                                if (existingChart) {
                                    try {
                                        existingChart.destroy();
                                    } catch (e) {}
                                }
                            }

                            const data = computeMaterialChartData(currentMaterialPeriod);

                            // Update badge text
                            const badgeTextEl = document.getElementById('materialPeriodBadgeText');
                            if (badgeTextEl) {
                                badgeTextEl.textContent = data.infoBadge;
                            }

                            const ctx = canvas.getContext('2d');
                            window._myMaterialTimelineChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: [
                                        {
                                            label: 'Stok Masuk',
                                            data: data.masuk,
                                            backgroundColor: '#10B981',
                                            borderRadius: 5,
                                            barPercentage: currentMaterialPeriod === 'hari' ? 0.25 : 0.55,
                                            categoryPercentage: 0.7,
                                        },
                                        {
                                            label: 'Stok Keluar',
                                            data: data.keluar,
                                            backgroundColor: '#DC2626',
                                            borderRadius: 5,
                                            barPercentage: currentMaterialPeriod === 'hari' ? 0.25 : 0.55,
                                            categoryPercentage: 0.7,
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    animation: {
                                        duration: 350
                                    },
                                    interaction: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            backgroundColor: '#0F172A',
                                            titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                                            bodyFont: { family: 'Inter', size: 12 },
                                            padding: 12,
                                            cornerRadius: 8,
                                            callbacks: {
                                                label: function (ctx) {
                                                    return ' ' + ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString('id-ID') + ' {{ $group['unit'] }}';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: { display: false },
                                            ticks: {
                                                font: { family: 'Inter', size: 11, weight: '500' },
                                                color: '#64748B',
                                                maxRotation: 30,
                                                minRotation: 0,
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            grid: { color: '#F1F5F9' },
                                            ticks: {
                                                font: { family: 'Inter', size: 11 },
                                                color: '#64748B',
                                                precision: 0
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }

                    // Daftarkan ke window agar dapat dipanggil kembali oleh SPA router setelah konten selesai dimuat
                    window.initTimelineChart = initTimelineChart;

                    // Jalankan inisialisasi awal
                    initTimelineChart();
                })();
            </script>

        </main>
    </div>
</body>

</html>
