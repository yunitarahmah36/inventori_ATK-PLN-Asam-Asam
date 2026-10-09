<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Analisis Material - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
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
           TOPBAR HEADER (Seragam 100% dengan Halaman Lain)
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

        /* Page Header Title */
        .page-header {
            margin-bottom: 22px;
        }

        .page-header h2 {
            font-size: 24px;
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

        /* ============================================================
           WELCOME / BANNER CARD (Seragam dengan Dashboard)
        ============================================================ */
        .welcome-card {
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
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            right: 60px;
            bottom: -60px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .welcome-left {
            position: relative;
            z-index: 1;
            max-width: 820px;
        }

        .welcome-badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 12px;
        }

        .welcome-badge-tag .material-symbols-outlined {
            font-size: 15px;
            color: var(--yellow);
        }

        .welcome-card h3 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .welcome-card p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.5;
        }

        .highlight-tag {
            background: rgba(255, 193, 7, 0.25);
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            color: #FFF8E1;
        }

        .welcome-role-badge {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            background: var(--yellow);
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 800;
            padding: 14px 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .welcome-role-badge-number {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.1;
        }

        .welcome-role-badge-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        /* ============================================================
           STATISTIK CARDS (KPI) - Seragam 100% dengan Dashboard
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
            margin-bottom: 14px;
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
           FILTER CARD (Seragam 100% dengan Riwayat Stok & Data Material)
        ============================================================ */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: var(--shadow);
        }

        .filter-form {
            display: grid;
            grid-template-columns: minmax(260px, 1.8fr) minmax(180px, 1fr) minmax(180px, 1fr) auto;
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
        .filter-group select {
            width: 100%;
            height: 42px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            background: #FFFFFF;
            color: var(--text-dark);
            font-size: 13px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .search-input input {
            padding: 0 12px 0 40px;
        }

        .filter-group select {
            padding: 0 38px 0 12px;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 15px;
            cursor: pointer;
        }

        .search-input input:focus,
        .filter-group select:focus {
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
            text-decoration: none;
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

        /* ============================================================
           SECTION HEADER: DAFTAR KELOMPOK MATERIAL (CARD GRID)
        ============================================================ */
        .section-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header-left h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-dark);
        }

        .badge-count {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 12px;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 11.5px;
            font-weight: 700;
        }

        .per-page-form {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .per-page-form select {
            height: 36px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            padding: 0 10px;
            font-size: 12.5px;
            background: #fff;
            color: var(--text-dark);
            cursor: pointer;
            outline: none;
            font-weight: 600;
        }

        /* ============================================================
           MATERIALS CARD GRID (KONSISTEN, RAPI, & SERAGAM)
        ============================================================ */
        .materials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
            align-items: stretch;
        }

        .material-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .material-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 59, 115, 0.12);
            border-color: #BFDBFE;
        }

        /* Top Status Accent Bar */
        .material-card-bar {
            height: 4px;
            width: 100%;
        }

        .material-card-bar.success { background: var(--green); }
        .material-card-bar.warning { background: var(--yellow); }
        .material-card-bar.danger  { background: var(--red); }

        /* Card Content Container */
        .material-card-content {
            padding: 18px 20px 14px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* Top Row: Code Pill + Status */
        .material-card-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 10px;
            height: 28px;
        }

        .material-code-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 9px;
            border-radius: 6px;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            font-size: 11.5px;
            font-family: monospace;
            font-weight: 700;
            color: var(--blue-dark);
        }

        .material-code-pill .material-symbols-outlined {
            font-size: 15px;
            color: var(--blue);
        }

        .material-extra-pill {
            display: inline-flex;
            align-items: center;
            padding: 1px 5px;
            border-radius: 4px;
            background: #E2E8F0;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-mid);
            margin-left: 2px;
        }

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
            white-space: nowrap;
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

        /* Title with fixed height for 100% uniformity */
        .material-card-title-box {
            margin-bottom: 8px;
            height: 44px;
            display: flex;
            align-items: center;
        }

        .material-card-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-word;
        }

        /* Meta Tag Row with fixed height */
        .material-card-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            height: 26px;
            margin-bottom: 14px;
        }

        .merged-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
            background: var(--yellow-light);
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .merged-tag .material-symbols-outlined {
            font-size: 13px;
        }

        .single-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            background: #F8FAFC;
            color: #64748B;
            border: 1px solid #E2E8F0;
        }

        .single-tag .material-symbols-outlined {
            font-size: 13px;
            color: #10B981;
        }

        .unit-pill {
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .unit-pill strong {
            color: var(--text-mid);
            font-weight: 700;
        }

        /* Hero Stock Block (Stok Saat Ini) */
        .card-stock-hero {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stock-hero-left {
            display: flex;
            flex-direction: column;
        }

        .stock-hero-label {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2px;
        }

        .stock-hero-number {
            font-size: 22px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .stock-hero-unit {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            background: var(--white);
            border: 1px solid #CBD5E1;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
        }

        /* 2-Column Mutasi Flow Grid (Symmetrical & Spacious) */
        .card-flow-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 6px;
        }

        .flow-box {
            padding: 9px 12px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
        }

        .flow-in {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
        }

        .flow-out {
            background: #FEF2F2;
            border: 1px solid #FECDD3;
        }

        .flow-label {
            font-size: 10.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 3px;
        }

        .flow-in .flow-label { color: #15803D; }
        .flow-out .flow-label { color: #BE123C; }

        .flow-label .material-symbols-outlined {
            font-size: 14px;
        }

        .flow-val {
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
        }

        .flow-in .flow-val { color: #166534; }
        .flow-out .flow-val { color: #9F1239; }

        /* Card Action Footer */
        .material-card-footer {
            padding: 12px 20px 16px;
            border-top: 1px solid #F1F5F9;
            background: #FAFCFF;
            margin-top: auto;
        }

        .btn-detail-card {
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: var(--blue);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            transition: background var(--transition), transform var(--transition);
            box-shadow: 0 2px 6px rgba(0, 87, 184, 0.2);
            text-decoration: none;
            cursor: pointer;
        }

        .btn-detail-card:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        .btn-detail-card .material-symbols-outlined {
            font-size: 17px;
            transition: transform 0.15s ease;
        }

        .btn-detail-card:hover .material-symbols-outlined {
            transform: translateX(3px);
        }

        /* Empty State */
        .empty-state-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 60px 20px;
            text-align: center;
            box-shadow: var(--shadow);
            grid-column: 1 / -1;
        }

        .empty-state-icon {
            font-size: 54px;
            color: #CBD5E1;
            margin-bottom: 12px;
        }

        /* ============================================================
           PAGINATION & FOOTER
        ============================================================ */
        .pagination-container {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow);
            flex-wrap: wrap;
            gap: 12px;
        }

        .data-info {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .pagination-simple {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-page {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 600;
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border);
            cursor: pointer;
            text-decoration: none;
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
           RESPONSIVE MOBILE BREAKPOINTS
        ============================================================ */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .filter-actions {
                grid-column: span 2;
                justify-content: flex-end;
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

            .welcome-card {
                flex-direction: column;
                gap: 16px;
                padding: 18px 20px;
            }

            .welcome-role-badge {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .materials-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                grid-column: span 1;
                width: 100%;
            }

            .filter-actions .btn-filter,
            .filter-actions .btn-reset {
                flex: 1;
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
                        <h1>Analisis Material</h1>
                        <p>Pantau jumlah dan pergerakan stok setiap material</p>
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

                

                <!-- FILTER CARD -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('material-analysis.index') }}" class="filter-form" id="analysisFilterForm">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">

                        <!-- Input Pencarian -->
                        <div class="filter-group">
                            <label for="search">Pencarian Material:</label>
                            <div class="search-input">
                                <span class="material-symbols-outlined">search</span>
                                <input type="text" id="search" name="search" value="{{ $search }}"
                                    placeholder="Cari nama material atau no material..." autocomplete="off">
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div class="filter-group">
                            <label for="status">Filter Status:</label>
                            <select id="status" name="status">
                                <option value="" {{ empty($filterStatus) ? 'selected' : '' }}>Semua Material</option>
                                <option value="safe" {{ $filterStatus === 'safe' ? 'selected' : '' }}>Stok Aman (> 15)</option>
                                <option value="low" {{ $filterStatus === 'low' ? 'selected' : '' }}>Stok Menipis (≤ 15)</option>
                                <option value="out" {{ $filterStatus === 'out' ? 'selected' : '' }}>Stok Habis (0)</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="filter-group">
                            <label for="sort">Urutkan Data:</label>
                            <select id="sort" name="sort">
                                <option value="stock_desc" {{ $sortBy === 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                                <option value="stock_asc" {{ $sortBy === 'stock_asc' ? 'selected' : '' }}>Stok Tersedikit</option>
                                <option value="masuk_desc" {{ $sortBy === 'masuk_desc' ? 'selected' : '' }}>Stok Masuk Terbanyak</option>
                                <option value="keluar_desc" {{ $sortBy === 'keluar_desc' ? 'selected' : '' }}>Stok Keluar Terbanyak</option>
                                <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Nama A - Z</option>
                                <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Nama Z - A</option>
                            </select>
                        </div>

                        <!-- Filter Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter" id="btnSubmitFilter">
                                <span class="material-symbols-outlined" style="font-size:18px;">filter_alt</span>
                                Filter
                            </button>

                            @if (!empty($search) || !empty($filterStatus) || $sortBy !== 'stock_desc')
                                <a href="{{ route('material-analysis.index', ['per_page' => $perPage]) }}" class="btn-reset" data-spa-link>
                                    <span class="material-symbols-outlined" style="font-size:18px;">restart_alt</span>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- SECTION HEADER BAR -->
                <div class="section-header-bar">
                    <div class="section-header-left">
                        <h3>Daftar Material</h3>
                        <span class="badge-count">{{ $totalFiltered }} Data Material</span>
                    </div>

                    <div class="per-page-form">
                        <label for="card_per_page">Tampilkan:</label>
                        <select id="card_per_page" onchange="window.changeAnalysisPerPage(this.value)">
                            <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                            <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ $perPage == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                </div>

                <!-- CARD GRID (SETIAP MATERIAL DITAMPILKAN DALAM BENTUK CARD) -->
                <div class="materials-grid">
                    @forelse ($groups as $grp)
                        <div class="material-card">
                            <!-- Top Accent Bar -->
                            <div class="material-card-bar {{ $grp['status_class'] }}"></div>

                            <div class="material-card-content">
                                <!-- Top Row: Code Pill + Status Badge -->
                                <div class="material-card-top-row">
                                    <div class="material-code-pill" title="Nomor Material">
                                        <span class="material-symbols-outlined">inventory_2</span>
                                        <span>{{ $grp['material_number'] ?? ($grp['material_numbers'][0] ?? 'MAT') }}</span>
                                    </div>

                                    <span class="status-badge status-{{ $grp['status_class'] }}">
                                        <span class="status-dot"></span>
                                        {{ $grp['status'] }}
                                    </span>
                                </div>

                                <!-- Title Box (Fixed Height: 44px) -->
                                <div class="material-card-title-box">
                                    <h3 class="material-card-title" title="{{ $grp['name'] }}">
                                        {{ $grp['name'] }}
                                    </h3>
                                </div>

                                <!-- Meta Row (Fixed Height: 26px) -->
                                <div class="material-card-meta-row">
                                    

                                    <span class="unit-pill">Satuan: <strong>{{ $grp['unit'] }}</strong></span>
                                </div>

                                <!-- Hero Stock Block (Stok Fisik Saat Ini) -->
                                <div class="card-stock-hero">
                                    <div class="stock-hero-left">
                                        <span class="stock-hero-label">Stok Fisik Saat Ini</span>
                                        <div class="stock-hero-number">{{ number_format($grp['total_quantity'], 0, ',', '.') }}</div>
                                    </div>
                                    <span class="stock-hero-unit">{{ $grp['unit'] }}</span>
                                </div>

                                <!-- Mutasi Grid (Stok Masuk & Stok Keluar - Symmetrical 2 Columns) -->
                                <div class="card-flow-grid">
                                    <div class="flow-box flow-in">
                                        <span class="flow-label">
                                            <span class="material-symbols-outlined">arrow_upward</span>
                                            Stok Masuk
                                        </span>
                                        <div class="flow-val">+{{ number_format($grp['total_masuk'], 0, ',', '.') }}</div>
                                    </div>

                                    <div class="flow-box flow-out">
                                        <span class="flow-label">
                                            <span class="material-symbols-outlined">arrow_downward</span>
                                            Stok Keluar
                                        </span>
                                        <div class="flow-val">-{{ number_format($grp['total_keluar'], 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer: Tombol Lihat Detail -->
                            <div class="material-card-footer">
                                <a href="{{ route('material-analysis.show', $grp['slug']) }}" class="btn-detail-card" data-spa-link>
                                    <span>Lihat Detail</span>
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-card">
                            <span class="material-symbols-outlined empty-state-icon">search_off</span>
                            <h4 style="font-size:16px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">Tidak ada material yang ditemukan</h4>
                            <p style="font-size:13px;color:var(--text-muted);margin-bottom:16px;">Silakan sesuaikan kata kunci pencarian atau filter yang dipilih.</p>
                            <a href="{{ route('material-analysis.index') }}" class="btn-reset" data-spa-link>
                                Tampilkan Semua Material
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- PAGINATION FOOTER -->
                <div class="pagination-container">
                    <div class="data-info">
                        Menampilkan <strong>{{ $groups->count() }}</strong> dari <strong>{{ $totalFiltered }}</strong> data material
                        @if (!empty($search)) (difilter dari total {{ $totalGroupsCount }}) @endif
                    </div>

                    @if ($totalPages > 1)
                        <div class="pagination-simple">
                            {{-- Tombol Previous --}}
                            @if ($currentPage > 1)
                                <a href="{{ route('material-analysis.index', array_merge(request()->query(), ['page' => $currentPage - 1])) }}"
                                   class="btn-page" data-spa-link>
                                    <span class="material-symbols-outlined" style="font-size:16px;">chevron_left</span>
                                    Sebelumnya
                                </a>
                            @else
                                <span class="btn-page disabled">
                                    <span class="material-symbols-outlined" style="font-size:16px;">chevron_left</span>
                                    Sebelumnya
                                </span>
                            @endif

                            <span style="font-size:12.5px;color:var(--text-muted);padding:0 8px;">
                                Hal <strong>{{ $currentPage }}</strong> dari <strong>{{ $totalPages }}</strong>
                            </span>

                            {{-- Tombol Next --}}
                            @if ($currentPage < $totalPages)
                                <a href="{{ route('material-analysis.index', array_merge(request()->query(), ['page' => $currentPage + 1])) }}"
                                   class="btn-page" data-spa-link>
                                    Berikutnya
                                    <span class="material-symbols-outlined" style="font-size:16px;">chevron_right</span>
                                </a>
                            @else
                                <span class="btn-page disabled">
                                    Berikutnya
                                    <span class="material-symbols-outlined" style="font-size:16px;">chevron_right</span>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

            </div>

            <!-- JAVASCRIPT LOGIC (Di dalam <main> untuk kompatibilitas SPA) -->
            <script id="page-script">
                (function () {
                    // Stub kosong agar tidak terjadi error saat SPA memanggil router hook
                    window.initAnalysisCharts = function () {};

                    window.changeAnalysisPerPage = function (val) {
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
    </div>
</body>

</html>
