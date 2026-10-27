<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Peminjaman Buku &amp; Katalog Koleksi - PT PLN Indonesia Power UBP Asam Asam</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

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
            --rosewood: #B46A72;
            --rosewood-hover: #9E565E;
            --rosewood-dark: #3D2227;
            --blush-petal: #F7C8D3;
            --blush-light: #FFF5F7;
            --bg-page: #FCF9FA;
            --bg-surface: #FFFFFF;
            --text-main: #3D2227;
            --text-secondary: #5C3840;
            --text-muted: #7E5B62;
            --border-soft: #F2E0E4;
            --border-focus: #B46A72;
            --green: #059669;
            --green-light: #ECFDF5;
            --red: #DC2626;
            --red-light: #FEF2F2;
            --amber: #D97706;
            --amber-light: #FFFBEB;
            --shadow-sm: 0 2px 8px rgba(180, 106, 114, 0.06);
            --shadow-md: 0 6px 20px rgba(180, 106, 114, 0.09);
            --shadow-lg: 0 16px 36px rgba(180, 106, 114, 0.12);
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-pill: 9999px;
            --transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            scrollbar-gutter: stable;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }

        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (max-width: 640px) {
            .container { padding: 0 16px; }
        }

        /* ============================================================
           YOUTUBE-STYLE TOP LOADING PROGRESS BAR
        ============================================================ */
        .page-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #F7C8D3 0%, #B46A72 50%, #F7C8D3 100%);
            background-size: 200% 100%;
            z-index: 999999;
            pointer-events: none;
            opacity: 0;
            transition: width 0.22s cubic-bezier(0.1, 0.85, 0.25, 1), opacity 0.2s ease;
            box-shadow: 0 0 10px rgba(247, 200, 211, 0.9), 0 0 4px rgba(180, 106, 114, 0.6);
        }

        .page-progress-bar.active {
            opacity: 1;
            animation: ytProgressShimmer 1.4s infinite linear;
        }

        .page-progress-bar.finish {
            width: 100% !important;
            opacity: 0;
            transition: width 0.12s ease-out, opacity 0.25s ease-out 0.12s;
        }

        @keyframes ytProgressShimmer {
            0% { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }

        /* ============================================================
           TOP BAR (TANPA NAVBAR, RAPI DENGAN TOMBOL KEMBALI)
        ============================================================ */
        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-soft);
            box-shadow: 0 2px 10px rgba(180, 106, 114, 0.04);
            transition: var(--transition);
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
            gap: 12px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            min-width: 0;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-text { min-width: 0; }

        .brand-text h1 {
            font-size: 14.5px;
            font-weight: 800;
            letter-spacing: -0.2px;
            color: var(--text-main);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-text p {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--rosewood);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            border: 1.5px solid var(--border-soft);
            color: var(--rosewood-dark);
            font-size: 13px;
            font-weight: 700;
            transition: var(--transition);
            box-shadow: 0 1px 4px rgba(180, 106, 114, 0.06);
            white-space: nowrap;
        }

        .btn-back-home:hover {
            background: var(--blush-light);
            border-color: var(--rosewood);
            color: var(--rosewood);
            transform: translateX(-2px);
        }

        .btn-back-home .material-symbols-outlined {
            font-size: 18px;
            color: var(--rosewood);
            transition: transform 0.2s ease;
        }

        .btn-back-home:hover .material-symbols-outlined {
            transform: translateX(-2px);
        }

        /* ============================================================
           BUTTONS & SPINNERS
        ============================================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
            white-space: nowrap;
            text-align: center;
            text-decoration: none;
            min-height: 42px;
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 12.5px;
            min-height: 36px;
            border-radius: 8px;
        }

        .btn-primary {
            background: var(--rosewood);
            color: #ffffff;
            border-color: var(--rosewood);
            box-shadow: 0 4px 14px rgba(180, 106, 114, 0.22);
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--rosewood-hover);
            border-color: var(--rosewood-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(180, 106, 114, 0.32);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-main);
            border-color: var(--border-soft);
        }

        .btn-outline:hover:not(:disabled) {
            background: var(--blush-light);
            border-color: var(--rosewood);
            color: var(--rosewood);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #4B5563;
            border: 1px solid #E5E7EB;
        }

        .btn-secondary:hover:not(:disabled) {
            background: #E5E7EB;
            color: #1F2937;
        }

        .btn:disabled,
        .btn.loading {
            opacity: 0.65;
            cursor: not-allowed !important;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #FFFFFF;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        .spinner-dark {
            border-color: rgba(180, 106, 114, 0.25);
            border-top-color: var(--rosewood);
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ============================================================
           HEADER BANNER SECTION & STATS
        ============================================================ */
        .page-header-banner {
            position: relative;
            padding: 40px 0 32px;
            background: linear-gradient(180deg, #FFFFFF 0%, #FFF5F7 60%, var(--bg-page) 100%);
            border-bottom: 1px solid var(--border-soft);
            overflow: hidden;
        }

        .banner-content {
            text-align: center;
            max-width: 820px;
            margin: 0 auto;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            border-radius: var(--radius-pill);
            background: #FFF0F3;
            border: 1px solid var(--blush-petal);
            color: var(--rosewood);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .banner-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--rosewood-dark);
            line-height: 1.3;
            margin-bottom: 10px;
            letter-spacing: -0.4px;
        }

        .banner-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 24px;
            max-width: 680px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-top: 20px;
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 16px 14px;
            box-shadow: var(--shadow-sm);
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--blush-petal);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }

        .stat-num {
            font-size: 22px;
            font-weight: 800;
            color: var(--rosewood-dark);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 3px;
        }

        /* ============================================================
           SECTIONS & CARDS
        ============================================================ */
        .section-block {
            padding: 44px 0;
            border-bottom: 1px solid var(--border-soft);
        }

        .section-header {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 28px;
        }

        .section-tag {
            display: inline-block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--rosewood);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--rosewood-dark);
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .section-desc {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .card-box {
            background: var(--bg-surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            position: relative;
        }

        .card-header-bar {
            padding: 16px 22px;
            background: linear-gradient(135deg, #FFF9FA 0%, #FFFFFF 100%);
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-header-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-title h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-main);
        }

        .card-header-title p {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .card-body-padded {
            padding: 24px 26px;
        }

        /* ============================================================
           FORM GRID & CONTROLS
        ============================================================ */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .req-star {
            color: var(--red);
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border-soft);
            background: #FFFFFF;
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text-main);
            outline: none;
            transition: var(--transition);
            min-height: 42px;
        }

        .form-control:focus {
            border-color: var(--rosewood);
            box-shadow: 0 0 0 3px rgba(180, 106, 114, 0.15);
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
        }

        .stock-indicator-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            margin-top: 4px;
        }

        .stock-indicator-pill.avail {
            background: var(--green-light);
            color: var(--green);
            border: 1px solid #A7F3D0;
        }

        .stock-indicator-pill.empty {
            background: var(--red-light);
            color: var(--red);
            border: 1px solid #FECACA;
        }

        /* Multi-Book Form Selector Styles */
        .form-section-divider {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            margin-top: 6px;
            border-top: 1.5px dashed var(--border-soft);
            gap: 12px;
            flex-wrap: wrap;
        }

        .form-section-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .form-section-title-wrap h4 {
            margin: 0;
            font-size: 14.5px;
            font-weight: 800;
            color: var(--rosewood-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-multi-free {
            font-size: 11px;
            font-weight: 700;
            color: var(--rosewood);
            background: #FFF0F3;
            padding: 3px 10px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--blush-petal);
        }

        .book-items-wrapper {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .book-item-row {
            background: #FAFAFB;
            border: 1.5px solid #F0EAEB;
            border-radius: var(--radius-md);
            padding: 16px;
            position: relative;
            transition: all 0.25s ease;
        }

        .book-item-row:hover {
            border-color: var(--blush-petal);
            background: #FFFDFE;
            box-shadow: 0 4px 14px rgba(180, 106, 114, 0.06);
        }

        .book-item-row.highlighted {
            border-color: var(--rosewood);
            background: #FFF9FA;
            box-shadow: 0 0 0 3px rgba(180, 106, 114, 0.25);
            animation: pulseBookRow 0.8s ease;
        }

        @keyframes pulseBookRow {
            0% { transform: scale(1); }
            50% { transform: scale(1.015); }
            100% { transform: scale(1); }
        }

        .book-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .book-item-number-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: var(--rosewood-dark);
            background: #FFF0F3;
            padding: 3px 10px;
            border-radius: 6px;
        }

        .btn-remove-book-row {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            color: #9CA3AF;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-remove-book-row:hover:not(:disabled) {
            background: #FEE2E2;
            color: #DC2626;
            border-color: #FECACA;
        }

        .btn-remove-book-row:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            background: transparent;
            border-color: transparent;
        }

        .book-item-grid {
            display: grid;
            grid-template-columns: 1fr 190px;
            gap: 14px;
            align-items: start;
        }

        @media (max-width: 640px) {
            .book-item-grid {
                grid-template-columns: 1fr;
            }
        }

        .book-items-actions-bar {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding-top: 6px;
        }

        .btn-add-book-row {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #FFF8F9;
            color: var(--rosewood);
            border: 1.5px dashed var(--rosewood);
            border-radius: var(--radius-md);
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-add-book-row:hover {
            background: var(--rosewood);
            color: #FFFFFF;
            border-style: solid;
            box-shadow: 0 4px 12px rgba(180, 106, 114, 0.25);
        }

        .book-selection-summary {
            font-size: 13px;
            color: var(--text-muted);
            background: #F8FAFC;
            padding: 7px 14px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--border-soft);
        }

        .book-selection-summary strong {
            color: var(--rosewood-dark);
        }

        /* Alert Notification */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: fadeInAlert 0.25s ease;
        }

        @keyframes fadeInAlert {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: var(--green-light);
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-danger {
            background: var(--red-light);
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        /* Resi Card */
        .receipt-card {
            background: #FFFFFF;
            border: 2px dashed var(--blush-petal);
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
            animation: fadeInAlert 0.25s ease;
        }

        .receipt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-soft);
            margin-bottom: 14px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .receipt-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--rosewood-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .receipt-code-pill {
            font-family: monospace;
            font-size: 12.5px;
            font-weight: 700;
            background: #FFF0F3;
            color: var(--rosewood);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--blush-petal);
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .receipt-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #F3F4F6;
        }

        .receipt-table td:first-child {
            width: 35%;
            color: var(--text-muted);
            font-weight: 500;
        }

        .receipt-table td:last-child {
            color: var(--text-main);
            font-weight: 700;
        }

        .receipt-action-bar {
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px dashed var(--blush-petal);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-new-loan {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            background: linear-gradient(135deg, var(--rosewood) 0%, var(--rosewood-dark) 100%);
            color: #FFFFFF !important;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(162, 59, 79, 0.28);
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-new-loan:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(162, 59, 79, 0.4);
            background: linear-gradient(135deg, var(--rosewood-light) 0%, var(--rosewood) 100%);
        }

        .btn-new-loan:active {
            transform: translateY(0);
        }

        .btn-new-loan .material-symbols-outlined {
            font-size: 19px;
        }

        @media (max-width: 640px) {
            .receipt-action-bar {
                justify-content: center;
            }
            .btn-new-loan {
                width: 100%;
            }
        }

        /* ============================================================
           KATALOG KOLEKSI BUKU
        ============================================================ */
        .catalog-filter-bar {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 14px 18px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .catalog-filter-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-box input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border-soft);
            font-size: 13px;
            outline: none;
            transition: var(--transition);
            min-height: 40px;
        }

        .search-box input:focus {
            border-color: var(--rosewood);
            box-shadow: 0 0 0 3px rgba(180, 106, 114, 0.12);
        }

        .search-box .search-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }

        .search-box .search-spinner {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            display: none;
        }

        .filter-select {
            padding: 8px 12px;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border-soft);
            background: #FFFFFF;
            font-size: 12.5px;
            color: var(--text-main);
            font-weight: 600;
            outline: none;
            cursor: pointer;
            min-height: 40px;
        }

        .filter-select:focus {
            border-color: var(--rosewood);
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 16px;
        }

        .book-card {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 16px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 12px;
            transition: var(--transition);
        }

        .book-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--blush-petal);
        }

        .book-card-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .book-cover-placeholder {
            width: 44px;
            height: 54px;
            background: linear-gradient(135deg, #FFF0F3 0%, #FDE4EB 100%);
            border: 1px solid var(--blush-petal);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rosewood);
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(180, 106, 114, 0.08);
        }

        .book-card-info {
            flex: 1;
            min-width: 0;
        }

        .book-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }

        .book-category-tag {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--rosewood);
            background: #FFF5F7;
            padding: 2px 7px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-stock {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 2.5px 8px;
            border-radius: 12px;
            line-height: 1.2;
            flex-shrink: 0;
        }

        .badge-stock .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-stock.badge-avail {
            background: #ECFDF5;
            color: #047857;
            border: 1px solid #A7F3D0;
        }

        .badge-stock.badge-avail .badge-dot {
            background: #10B981;
        }

        .badge-stock.badge-empty {
            background: #FEF2F2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        .badge-stock.badge-empty .badge-dot {
            background: #EF4444;
        }

        .book-title-text {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--rosewood-dark);
            line-height: 1.35;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .book-author-text {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .book-card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid #F3F4F6;
        }

        .btn-pinjam-buku {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 8px;
            background: var(--rosewood);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            min-height: 38px;
        }

        .btn-pinjam-buku:hover {
            background: var(--rosewood-hover);
        }

        .btn-pinjam-buku:disabled {
            background: #E5E7EB;
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .btn-view-borrowers {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid var(--border-soft);
            background: #FFFFFF;
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            min-height: 38px;
        }

        .btn-view-borrowers:hover {
            border-color: var(--rosewood);
            color: var(--rosewood);
            background: var(--blush-light);
        }

        /* ============================================================
           TABEL & KARTU INFORMASI PEMINJAM AKTIF
        ============================================================ */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table-custom thead {
            background: #FDF9FA;
            border-bottom: 2px solid var(--border-soft);
        }

        .data-table-custom th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--rosewood-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .data-table-custom td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-main);
            vertical-align: middle;
        }

        .data-table-custom tbody tr:hover {
            background: #FFF9FA;
        }

        .borrower-name {
            font-weight: 700;
            color: var(--text-main);
        }

        .borrower-phone {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .loan-code-badge {
            font-family: monospace;
            font-size: 11px;
            font-weight: 700;
            color: var(--rosewood);
            background: #FFF0F3;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-dipinjam {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }

        .status-terlambat {
            background: var(--red-light);
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        .btn-kembalikan {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 8px;
            background: var(--green);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            min-height: 32px;
        }

        .btn-kembalikan:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        /* Modals */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(61, 34, 39, 0.55);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.show { display: flex; }

        .modal-card {
            background: #FFFFFF;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 16px 40px rgba(0,0,0,0.2);
            animation: modalPop 0.22s ease;
        }

        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--rosewood-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 20px;
            line-height: 1;
            padding: 4px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 14px 20px;
            background: #FCF9FA;
            border-top: 1px solid var(--border-soft);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .empty-box {
            text-align: center;
            padding: 36px 16px;
            color: var(--text-muted);
        }

        .empty-box span {
            font-size: 44px;
            color: #CBD5E1;
            margin-bottom: 6px;
        }

        .empty-box p {
            font-size: 13.5px;
            font-weight: 500;
        }

        /* Toast Notification */
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
            background: var(--rosewood-dark);
            color: #FFFFFF;
            padding: 12px 18px;
            border-radius: var(--radius-md);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
            max-width: 400px;
        }

        .toast-notification.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .footer {
            background: #FFFFFF;
            border-top: 1px solid var(--border-soft);
            padding: 32px 0 20px;
            text-align: center;
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .footer-brand {
            font-weight: 800;
            color: var(--rosewood-dark);
            margin-bottom: 4px;
        }

        /* ============================================================
           MEDIA QUERIES (DESKTOP, TABLET, MOBILE)
        ============================================================ */
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .form-grid { grid-template-columns: 1fr; }
            .books-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .topbar-inner { height: 60px; }
            .brand-logo { width: 36px; height: 36px; }
            .brand-text h1 { font-size: 13px; }
            .brand-text p { font-size: 9.5px; }
            .btn-back-home {
                padding: 6px 12px;
                font-size: 12px;
            }
            .page-header-banner { padding: 28px 0 24px; }
            .banner-title { font-size: 22px; }
            .banner-desc { font-size: 13px; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card { padding: 12px 10px; }
            .stat-num { font-size: 19px; }
            .section-block { padding: 32px 0; }
            .section-title { font-size: 20px; }
            .card-body-padded { padding: 16px; }
            .card-header-bar { padding: 14px 16px; }
            .books-grid { grid-template-columns: 1fr; }
            .catalog-filter-bar { padding: 12px 14px; }
            .search-box { min-width: 100%; }
            .catalog-filter-form { flex-direction: column; align-items: stretch; }
            .filter-select { width: 100%; }
            .toast-notification { left: 16px; right: 16px; bottom: 16px; max-width: none; }
        }
    </style>
</head>
<body>

    <!-- YOUTUBE-STYLE TOP LOADING PROGRESS BAR -->
    <div class="page-progress-bar" id="pageProgressBar"></div>

    <!-- TOP BAR (RAPI, TANPA NAVBAR, DENGAN TOMBOL KEMBALI) -->
    <header class="app-topbar">
        <div class="container topbar-inner">

            <div class="topbar-actions">
                <a href="{{ route('landing') }}" class="btn-back-home" title="Kembali ke Halaman Utama Persediaan ATK">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>
        </div>
    </header>

    <!-- TOAST NOTIFICATION -->
    <div class="toast-notification" id="toastNotification">
        <span class="material-symbols-outlined" id="toastIcon" style="font-size:20px; color:#10B981;">check_circle</span>
        <span id="toastMessage">Peminjaman berhasil diproses.</span>
    </div>

    <!-- ============================================================
         PAGE HEADER BANNER & STATS
    ============================================================ -->

                <!-- Stats Container (Dynamic SPA update) -->
                <div class="stats-grid" id="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #FFF0F3; color: var(--rosewood);">
                            <span class="material-symbols-outlined" style="font-size:22px;">auto_stories</span>
                        </div>
                        <div class="stat-num" id="statTotalTitles">{{ $stats['total_titles'] }}</div>
                        <div class="stat-label">Judul Koleksi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #EFF6FF; color: #1D4ED8;">
                            <span class="material-symbols-outlined" style="font-size:22px;">library_books</span>
                        </div>
                        <div class="stat-num" id="statTotalStock">{{ $stats['total_stock'] }}</div>
                        <div class="stat-label">Total Stok Buku</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                            <span class="material-symbols-outlined" style="font-size:22px;">check_circle</span>
                        </div>
                        <div class="stat-num" id="statAvailableStock">{{ $stats['available_stock'] }}</div>
                        <div class="stat-label">Stok Tersedia</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--amber-light); color: var(--amber);">
                            <span class="material-symbols-outlined" style="font-size:22px;">pending_actions</span>
                        </div>
                        <div class="stat-num" id="statBorrowedStock">{{ $stats['borrowed_stock'] }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================================================
         SECTION FORMULIR PEMINJAMAN BUKU
    ============================================================ -->
    <section class="section-block" id="form-peminjaman">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Form Pengajuan Peminjaman Buku</h2>
                <p class="section-desc">
                    Isi data peminjam dan pilih buku favoritmu untuk mulai meminjam.
                </p>
            </div>

            <div class="card-box" style="max-width: 860px; margin: 0 auto;">
                <div class="card-header-bar">
                    <div class="card-header-title">
                        <div style="width:38px; height:38px; border-radius:10px; background:#FFF0F3; color:var(--rosewood); display:flex; align-items:center; justify-content:center;">
                            <span class="material-symbols-outlined" style="font-size:20px;">edit_note</span>
                        </div>
                        <div>
                            <h3>Formulir Peminjaman Buku</h3>
                            <p>Layanan peminjaman untuk koleksi buku yang tersedia.</p>
                        </div>
                    </div>
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:var(--green); background:var(--green-light); padding:3px 10px; border-radius:var(--radius-pill);">
                        <span class="material-symbols-outlined" style="font-size:13px;">verified</span>
                        Terbuka
                    </span>
                </div>

                <div class="card-body-padded">
                    <!-- Alert & Resi Container (Dynamic SPA update) -->
                    <div id="alertAndReceiptContainer">
                        @if(session('success_peminjaman_buku'))
                            <div class="alert alert-success">
                                <span class="material-symbols-outlined" style="font-size:22px;">check_circle</span>
                                <div>
                                    <strong>Peminjaman Berhasil Diajukan!</strong>
                                    <p>{{ session('success_peminjaman_buku') }}</p>
                                </div>
                            </div>

                            @if(session('receipt_peminjaman'))
                                @php $receipt = session('receipt_peminjaman'); @endphp
                                <div class="receipt-card">
                                    <div class="receipt-header">
                                        <div class="receipt-title">
                                            <span class="material-symbols-outlined" style="color:var(--rosewood);">receipt_long</span>
                                            <span>Tanda Terima Peminjaman Buku</span>
                                        </div>
                                    </div>
                                    <table class="receipt-table">
                                        <tr>
                                            <td>Nama Peminjam</td>
                                            <td>{{ $receipt['borrower_name'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bagian / Divisi</td>
                                            <td>{{ $receipt['borrower_department'] ?? '-' }}</td>
                                        </tr>
                                        @if(!empty($receipt['borrower_phone']))
                                        <tr>
                                            <td>No. Telepon / WhatsApp</td>
                                            <td>{{ $receipt['borrower_phone'] }}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($receipt['books']) && count($receipt['books']) > 1)
                                        <tr>
                                            <td>Daftar Buku Dipinjam</td>
                                            <td>
                                                <ul style="margin:0; padding-left:18px; line-height:1.6;">
                                                    @foreach($receipt['books'] as $rb)
                                                        <li>
                                                            <strong>{{ $rb['title'] }}</strong> &mdash; <span style="color:var(--rosewood); font-weight:700;">{{ $rb['quantity'] }} Eksemplar</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Buku Dipinjam</td>
                                            <td><strong style="color:var(--rosewood); font-size:14px;">{{ $receipt['quantity'] ?? 1 }} Eksemplar</strong> ({{ count($receipt['books']) }} Judul Buku)</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>Judul Buku</td>
                                            <td>{{ $receipt['book_title'] ?? ($receipt['books'][0]['title'] ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Buku</td>
                                            <td>{{ $receipt['quantity'] ?? 1 }} Eksemplar</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Tanggal Peminjaman</td>
                                            <td>{{ $receipt['loan_date'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Rencana Pengembalian</td>
                                            <td><span style="color:#B91C1C;">{{ $receipt['due_date'] ?? '-' }}</span></td>
                                        </tr>
                                        @if(!empty($receipt['notes']))
                                        <tr>
                                            <td>Catatan</td>
                                            <td>{{ $receipt['notes'] }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                    <div class="receipt-action-bar">
                                        <button type="button" class="btn-new-loan" onclick="openNewLoanForm()">
                                            <span class="material-symbols-outlined">add_circle</span>
                                            <span>+ Catat Peminjaman Baru</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if(session('error_peminjaman_buku'))
                            <div class="alert alert-danger">
                                <span class="material-symbols-outlined" style="font-size:22px;">error</span>
                                <div>
                                    <strong>Peminjaman Tidak Dapat Diproses!</strong>
                                    <p>{{ session('error_peminjaman_buku') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Formulir Peminjaman Multi-Buku -->
                    <form method="POST" action="{{ route('public.books.store-loan') }}" id="bookLoanForm" @if(session('receipt_peminjaman') || session('success_peminjaman_buku')) style="display: none;" @endif>
                        @csrf
                        <!-- 1. DATA IDENTITAS & JADWAL PEMINJAM (Diisi Cukup Sekali) -->
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="borrower_name">Nama Peminjam <span class="req-star">*</span></label>
                                <input type="text" id="borrower_name" name="borrower_name" class="form-control"
                                       placeholder="Masukkan nama lengkap peminjam..." value="{{ old('borrower_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="borrower_department">Bagian / Divisi <span class="req-star">*</span></label>
                                <input type="text" id="borrower_department" name="borrower_department" class="form-control"
                                       placeholder="Contoh: Operasi, Pemeliharaan, K3L, Umum..." value="{{ old('borrower_department') }}" required list="departmentList">
                                <datalist id="departmentList">
                                    <option value="Operasi">
                                    <option value="Pemeliharaan">
                                    <option value="K3L & Lingkungan">
                                    <option value="Engineering / Enjiniring">
                                    <option value="Keuangan & Administrasi">
                                    <option value="Logistik & Gudang">
                                    <option value="SDM & Umum">
                                    <option value="Kimia & Laboratorium">
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="borrower_phone">Nomor Telepon / WhatsApp</label>
                                <input type="text" id="borrower_phone" name="borrower_phone" class="form-control"
                                       placeholder="Contoh: 08123456789 (opsional)" value="{{ old('borrower_phone') }}">
                            </div>

                            <div class="form-group">
                                <label for="loan_date">Tanggal Peminjaman <span class="req-star">*</span></label>
                                <input type="date" id="loan_date" name="loan_date" class="form-control"
                                       value="{{ old('loan_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="due_date">Tanggal Rencana Pengembalian <span class="req-star">*</span></label>
                                <input type="date" id="due_date" name="due_date" class="form-control"
                                       value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="notes">Catatan / Keperluan Peminjaman</label>
                                <textarea id="notes" name="notes" class="form-control" rows="2"
                                          placeholder="Tuliskan catatan tambahan atau keperluan peminjaman (opsional)...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- 2. DAFTAR BUKU YANG INGIN DIPINJAM (Multi-Item Tanpa Batas Maksimal) -->
                            <div class="form-section-divider">
                                <div class="form-section-title-wrap">
                                    <h4>
                                        <span class="material-symbols-outlined" style="font-size:20px; color:var(--rosewood);">library_books</span>
                                        <span>Daftar Buku yang Ingin Dipinjam</span>
                                    </h4>
                                </div>
                                <div class="book-selection-summary" id="bookSelectionSummaryBadge">
                                    Total: <strong id="totalSummaryTitles">1</strong> judul buku (<strong id="totalSummaryQty">1</strong> eksemplar)
                                </div>
                            </div>

                            <div class="book-items-wrapper" id="bookItemsContainer">
                                <!-- Baris Item Buku Pertama -->
                                <div class="book-item-row" data-index="0">
                                    <div class="book-item-header">
                                        <span class="book-item-number-badge">
                                            <span class="material-symbols-outlined" style="font-size:16px;">book</span>
                                            <span class="item-title-label">Judul Buku #1</span>
                                        </span>
                                        <button type="button" class="btn-remove-book-row" title="Hapus buku ini" onclick="removeBookRow(this)" disabled>
                                            <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                        </button>
                                    </div>

                                    <div class="book-item-grid">
                                        <div class="form-group" style="margin:0;">
                                            <label for="book_id">Pilih Judul Buku <span class="req-star">*</span></label>
                                            <select id="book_id" name="items[0][book_id]" class="form-control book-item-select" required onchange="handleBookRowSelectChange(this)">
                                                <option value="">-- Pilih Judul Buku yang Ingin Dipinjam --</option>
                                                @foreach($availableBooks as $ab)
                                                    <option value="{{ $ab->id }}"
                                                            data-stock="{{ $ab->available_stock }}"
                                                            data-title="{{ $ab->title }}"
                                                            {{ (old('book_id') == $ab->id || request('selected_book') == $ab->id) ? 'selected' : '' }}>
                                                        {{ $ab->title }} (Sisa Stok: {{ $ab->available_stock }} Eksemplar)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="row-stock-display" id="selectedBookStockDisplay" style="display:none; margin-top:5px;">
                                                <span class="stock-indicator-pill avail row-stock-pill" id="stockPillText">Stok Tersedia: 0 Eksemplar</span>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin:0;">
                                            <label for="quantity">Jumlah Buku (Eksemplar) <span class="req-star">*</span></label>
                                            <input type="number" id="quantity" name="items[0][quantity]" class="form-control book-item-qty"
                                                   min="1" value="{{ old('quantity', 1) }}" required oninput="handleBookRowQtyInput(this)">
                                            <span class="form-hint row-qty-hint" id="qtyHintText">Minimal 1 eksemplar.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="book-items-actions-bar">
                                <button type="button" class="btn-add-book-row" id="btnAddBookRow">
                                    <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span>
                                    <span>+ Tambah Judul Buku Lain</span>
                                </button>
                                <div style="font-size:12px; color:var(--text-muted);">
                                    * Tentukan jumlah eksemplar sesuai stok tersedia. Anda dapat memilih banyak buku sekaligus.
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 24px; display:flex; justify-content:flex-end; gap:12px;">
                            <button type="submit" class="btn btn-primary" id="btnSubmitLoan" style="padding: 12px 28px;">
                                <span class="btn-text-content" style="display:inline-flex; align-items:center; gap:8px;">
                                    <span class="material-symbols-outlined" style="font-size:18px;">send</span>
                                    <span>Ajukan Peminjaman</span>
                                </span>
                                <span class="btn-loading-content" style="display:none; align-items:center; gap:8px;">
                                    <span class="spinner"></span>
                                    <span>Memproses...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Template Baris Buku untuk Dynamic Addition -->
                    <template id="bookItemRowTemplate">
                        <div class="book-item-row" data-index="__INDEX__">
                            <div class="book-item-header">
                                <span class="book-item-number-badge">
                                    <span class="material-symbols-outlined" style="font-size:16px;">book</span>
                                    <span class="item-title-label">Judul Buku #__NUMBER__</span>
                                </span>
                                <button type="button" class="btn-remove-book-row" title="Hapus buku ini" onclick="removeBookRow(this)">
                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                </button>
                            </div>

                            <div class="book-item-grid">
                                <div class="form-group" style="margin:0;">
                                    <label>Pilih Judul Buku <span class="req-star">*</span></label>
                                    <select name="items[__INDEX__][book_id]" class="form-control book-item-select" required onchange="handleBookRowSelectChange(this)">
                                        <option value="">-- Pilih Judul Buku yang Ingin Dipinjam --</option>
                                        @foreach($availableBooks as $ab)
                                            <option value="{{ $ab->id }}"
                                                    data-stock="{{ $ab->available_stock }}"
                                                    data-title="{{ $ab->title }}">
                                                {{ $ab->title }} (Sisa Stok: {{ $ab->available_stock }} Eksemplar)
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="row-stock-display" style="display:none; margin-top:5px;">
                                        <span class="stock-indicator-pill avail row-stock-pill">Stok Tersedia: 0 Eksemplar</span>
                                    </div>
                                </div>

                                <div class="form-group" style="margin:0;">
                                    <label>Jumlah Buku (Eksemplar) <span class="req-star">*</span></label>
                                    <input type="number" name="items[__INDEX__][quantity]" class="form-control book-item-qty"
                                           min="1" value="1" required oninput="handleBookRowQtyInput(this)">
                                    <span class="form-hint row-qty-hint">Minimal 1 eksemplar.</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION KATALOG BUKU
    ============================================================ -->
    <section class="section-block" id="katalog-buku" style="background:#FFFFFF;">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Koleksi Lengkap</div>
                <h2 class="section-title">Katalog Koleksi Buku Perpustakaan</h2>
                <p class="section-desc">
                    Jelajahi seluruh daftar buku yang tersedia. Anda dapat melihat informasi stok, peminjam aktif, dan meminjam buku secara langsung.
                </p>
            </div>

            <!-- Filter & Search Bar -->
            <div class="catalog-filter-bar">
                <div class="catalog-filter-form">
                    <div class="search-box">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" id="catalogSearchInput" placeholder="Cari judul buku, penulis, kategori, peminjam..." value="{{ $search ?? '' }}" autocomplete="off">
                        <span class="spinner spinner-dark search-spinner" id="catalogSearchSpinner"></span>
                    </div>

                    <select id="categoryFilter" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ ($category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <select id="availabilityFilter" class="filter-select">
                        <option value="">Semua Status Stok</option>
                        <option value="available" {{ ($availability ?? '') === 'available' ? 'selected' : '' }}>Stok Tersedia</option>
                        <option value="empty" {{ ($availability ?? '') === 'empty' ? 'selected' : '' }}>Dipinjam Semua</option>
                    </select>

                    <button type="button" id="btnResetCatalogFilter" class="btn btn-outline btn-sm" style="display: {{ ($search || $category || $availability) ? 'inline-flex' : 'none' }};">
                        <span class="material-symbols-outlined" style="font-size:16px;">restart_alt</span>
                        <span>Reset</span>
                    </button>
                </div>

                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;" id="catalogCountDisplay">
                    Menampilkan <strong>{{ $books->count() }}</strong> judul buku
                </div>
            </div>

            <!-- Grid Koleksi Buku (Dynamic SPA update) -->
            <div id="katalog-container">
                @if($books->count() > 0)
                    <div class="books-grid">
                        @foreach($books as $b)
                            @php
                                $activeCount = $b->activeLoans->count();
                            @endphp
                            <div class="book-card" data-title="{{ strtolower($b->title) }}" data-author="{{ strtolower($b->author) }}">
                                <div class="book-card-top">
                                    <div class="book-cover-placeholder">
                                        <span class="material-symbols-outlined" style="font-size:26px;">menu_book</span>
                                    </div>
                                    <div class="book-card-info">
                                        <div class="book-card-meta">
                                            <span class="book-category-tag">{{ $b->category ?: 'Umum' }}</span>
                                            @if($b->available_stock > 0)
                                                <span class="badge-stock badge-avail">
                                                    <span class="badge-dot"></span>
                                                    Tersedia: {{ $b->available_stock }} Eksemplar
                                                </span>
                                            @else
                                                <span class="badge-stock badge-empty">
                                                    <span class="badge-dot"></span>
                                                    Stok Habis (0 Eksemplar)
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="book-title-text">{{ $b->title }}</h3>
                                        <div class="book-author-text">
                                            <span class="material-symbols-outlined" style="font-size:14px;">person</span>
                                            <span>{{ $b->author ?: 'Penulis tidak disebutkan' }}</span>
                                        </div>
                                        <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 6px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                            <span>Total Stok: <strong>{{ $b->total_stock }} eksemplar</strong></span>
                                            <span>&bull;</span>
                                            <span>Tersedia: <strong style="color: {{ $b->available_stock > 0 ? 'var(--green)' : '#B91C1C' }};">{{ $b->available_stock }} eksemplar</strong></span>
                                            <span>&bull;</span>
                                            <span>Dipinjam: <strong>{{ $b->borrowed_stock }} eksemplar</strong></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="book-card-actions">
                                    @if($b->available_stock > 0)
                                        <button type="button" class="btn-pinjam-buku" onclick="quickSelectBook({{ $b->id }}, '{{ addslashes($b->title) }}', {{ $b->available_stock }})">
                                            <span class="material-symbols-outlined" style="font-size:16px;">note_add</span>
                                            <span>Pinjam Buku</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn-pinjam-buku" disabled>
                                            <span class="material-symbols-outlined" style="font-size:16px;">block</span>
                                            <span>Stok Habis (0 Eksemplar)</span>
                                        </button>
                                    @endif

                                    <button type="button" class="btn-view-borrowers"
                                            title="Lihat Peminjam"
                                            onclick='openBorrowersModal(@json($b->title), @json($b->activeLoans))'>
                                        <span class="material-symbols-outlined" style="font-size:16px;">group</span>
                                        <span>Lihat Peminjam ({{ $activeCount }})</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        <span class="material-symbols-outlined">menu_book</span>
                        <p>Tidak ada koleksi buku yang sesuai dengan pencarian atau filter Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================================
         MODAL LIHAT PEMINJAM AKTIF PER BUKU
    ============================================================ -->
    <div class="modal-overlay" id="borrowersModal">
        <div class="modal-card" style="max-width: 680px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #FFF0F3; color: var(--rosewood); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">group</span>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: var(--rosewood-dark);">Detail Peminjam Buku</h4>
                        <div id="modalBookTitle" style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">-</div>
                    </div>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeBorrowersModal()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 16px 20px;">
                <div id="modalBorrowersContent">
                    <!-- Populated via JavaScript: table or empty state -->
                </div>
            </div>
            <div class="modal-footer" style="padding: 12px 20px; background: #FAF7F8; border-top: 1px solid var(--border-soft); display: flex; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeBorrowersModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ============================================================
         MODAL KONFIRMASI PENGEMBALIAN BUKU
    ============================================================ -->
    <div class="modal-overlay" id="confirmReturnModal">
        <div class="modal-card" style="max-width: 480px;">
            <form method="POST" id="returnLoanForm" action="">
                @csrf
                <div class="modal-header">
                    <h4>
                        <span class="material-symbols-outlined" style="color:var(--green);">assignment_turned_in</span>
                        <span>Konfirmasi Pengembalian Buku</span>
                    </h4>
                    <button type="button" class="modal-close-btn" onclick="closeConfirmReturnModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p style="font-size:13.5px; color:var(--text-main); margin-bottom:12px;">
                        Apakah Anda yakin ingin memproses pengembalian buku berikut?
                    </p>
                    <div style="background:#F9FAFB; border:1px solid #E5E7EB; border-radius:10px; padding:12px 14px; font-size:12.5px;">
                        <div style="margin-bottom:6px;">
                            <span style="color:var(--text-muted);">Judul Buku:</span>
                            <strong id="returnModalBookTitle" style="display:block; color:var(--text-main); font-size:13px;">-</strong>
                        </div>
                        <div style="margin-bottom:6px;">
                            <span style="color:var(--text-muted);">Nama Peminjam:</span>
                            <strong id="returnModalBorrowerName" style="display:block; color:var(--text-main);">-</strong>
                        </div>
                        <div>
                            <span style="color:var(--text-muted);">Jumlah Dikembalikan:</span>
                            <strong id="returnModalQuantity" style="color:var(--green);">1 Eksemplar</strong>
                        </div>
                    </div>
                    <p style="font-size:11.5px; color:var(--text-muted); margin-top:10px;">
                        * Setelah dikonfirmasi, stok buku yang tersedia akan otomatis bertambah dan status transaksi diubah menjadi "Dikembalikan".
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeConfirmReturnModal()">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="btnConfirmReturnSubmit" style="background:var(--green); border-color:var(--green);">
                        <span class="btn-text-content" style="display:inline-flex; align-items:center; gap:6px;">
                            <span class="material-symbols-outlined" style="font-size:16px;">check</span>
                            <span>Konfirmasi Pengembalian</span>
                        </span>
                        <span class="btn-loading-content" style="display:none; align-items:center; gap:6px;">
                            <span class="spinner"></span>
                            <span>Memproses...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================
         SPA ENGINE & JAVASCRIPT LOGIC
    ============================================================ -->
    <script>
        // Progress Engine (YouTube Style)
        const ProgressEngine = (function () {
            let bar = document.getElementById('pageProgressBar');
            let timer = null;
            let width = 0;
            let running = false;

            function getBar() {
                if (!bar) bar = document.getElementById('pageProgressBar');
                return bar;
            }

            function setWidth(w) {
                width = Math.min(100, Math.max(0, w));
                const el = getBar();
                if (el) el.style.width = width + '%';
            }

            function start() {
                const el = getBar();
                if (!el || running) return;
                running = true;
                if (timer) clearInterval(timer);
                el.classList.remove('finish');
                el.classList.add('active');
                setWidth(0);

                setTimeout(() => { if (running) setWidth(25); }, 20);

                timer = setInterval(() => {
                    if (!running) return;
                    if (width < 60) setWidth(width + Math.random() * 8 + 3);
                    else if (width < 85) setWidth(width + Math.random() * 4 + 1);
                    else if (width < 94) setWidth(width + 0.3);
                }, 150);
            }

            function done() {
                const el = getBar();
                if (!el) return;
                running = false;
                if (timer) clearInterval(timer);
                setWidth(100);
                el.classList.add('finish');
                setTimeout(() => {
                    el.classList.remove('active', 'finish');
                    setWidth(0);
                }, 350);
            }

            return { start, done };
        })();

        // Toast Notification System
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            const icon = document.getElementById('toastIcon');
            const msgEl = document.getElementById('toastMessage');

            if (!toast || !msgEl) return;
            msgEl.textContent = message;

            if (type === 'success') {
                if (icon) {
                    icon.textContent = 'check_circle';
                    icon.style.color = '#10B981';
                }
            } else if (type === 'error') {
                if (icon) {
                    icon.textContent = 'error';
                    icon.style.color = '#EF4444';
                }
            } else {
                if (icon) {
                    icon.textContent = 'info';
                    icon.style.color = '#3B82F6';
                }
            }

            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }

        // SPA Engine & DOM Handler
        document.addEventListener('DOMContentLoaded', function () {
            const catalogSearchInput = document.getElementById('catalogSearchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const availabilityFilter = document.getElementById('availabilityFilter');
            const btnResetCatalogFilter = document.getElementById('btnResetCatalogFilter');
            const catalogSpinner = document.getElementById('catalogSearchSpinner');
            const borrowerTableSearch = document.getElementById('borrowerTableSearch');
            const bookLoanForm = document.getElementById('bookLoanForm');
            const returnLoanForm = document.getElementById('returnLoanForm');

            let searchTimeout = null;

            // Debounced Filter & Search Function (SPA Fetch)
            function executeCatalogFilter() {
                const searchVal = catalogSearchInput ? catalogSearchInput.value.trim() : '';
                const categoryVal = categoryFilter ? categoryFilter.value : '';
                const availVal = availabilityFilter ? availabilityFilter.value : '';

                if (btnResetCatalogFilter) {
                    btnResetCatalogFilter.style.display = (searchVal || categoryVal || availVal) ? 'inline-flex' : 'none';
                }

                if (catalogSpinner) catalogSpinner.style.display = 'inline-block';
                ProgressEngine.start();

                const params = new URLSearchParams();
                if (searchVal) params.set('search', searchVal);
                if (categoryVal) params.set('category', categoryVal);
                if (availVal) params.set('availability', availVal);

                const targetUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');

                fetch(targetUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // 1. Update stats container
                    const newStats = doc.getElementById('stats-container');
                    const curStats = document.getElementById('stats-container');
                    if (newStats && curStats) curStats.innerHTML = newStats.innerHTML;

                    // 2. Update catalog container
                    const newKatalog = doc.getElementById('katalog-container');
                    const curKatalog = document.getElementById('katalog-container');
                    if (newKatalog && curKatalog) curKatalog.innerHTML = newKatalog.innerHTML;

                    // 3. Update catalog count display
                    const newCount = doc.getElementById('catalogCountDisplay');
                    const curCount = document.getElementById('catalogCountDisplay');
                    if (newCount && curCount) curCount.innerHTML = newCount.innerHTML;

                    // 4. Update book options in form selects and template
                    const newSelect = doc.getElementById('book_id');
                    if (newSelect) {
                        const newOptionsHtml = newSelect.innerHTML;
                        document.querySelectorAll('.book-item-select').forEach(sel => {
                            const currentVal = sel.value;
                            sel.innerHTML = newOptionsHtml;
                            sel.value = currentVal;
                            handleBookRowSelectChange(sel, false);
                        });

                        const templateEl = document.getElementById('bookItemRowTemplate');
                        if (templateEl) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = templateEl.innerHTML;
                            const tSel = tempDiv.querySelector('.book-item-select');
                            if (tSel) {
                                tSel.innerHTML = newOptionsHtml;
                                templateEl.innerHTML = tempDiv.innerHTML;
                            }
                        }
                    }

                    // Push state without page reload
                    window.history.pushState(null, '', targetUrl);
                })
                .catch(err => {
                    console.error('SPA Filter error:', err);
                })
                .finally(() => {
                    if (catalogSpinner) catalogSpinner.style.display = 'none';
                    ProgressEngine.done();
                });
            }

            // Bind Event Listeners on Search & Filter Inputs
            if (catalogSearchInput) {
                catalogSearchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(executeCatalogFilter, 280);
                });
            }

            if (categoryFilter) {
                categoryFilter.addEventListener('change', executeCatalogFilter);
            }

            if (availabilityFilter) {
                availabilityFilter.addEventListener('change', executeCatalogFilter);
            }

            if (btnResetCatalogFilter) {
                btnResetCatalogFilter.addEventListener('click', function () {
                    if (catalogSearchInput) catalogSearchInput.value = '';
                    if (categoryFilter) categoryFilter.value = '';
                    if (availabilityFilter) availabilityFilter.value = '';
                    executeCatalogFilter();
                });
            }

            // Tombol Tambah Judul Buku Lain
            const btnAddBook = document.getElementById('btnAddBookRow');
            if (btnAddBook) {
                btnAddBook.addEventListener('click', function () {
                    const newRow = createNewBookRow();
                    if (newRow) {
                        const sel = newRow.querySelector('.book-item-select');
                        if (sel) sel.focus();
                    }
                });
            }

            // SPA AJAX Submission for Multi-Book Loan Form
            if (bookLoanForm) {
                bookLoanForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('btnSubmitLoan');
                    const textContent = submitBtn.querySelector('.btn-text-content');
                    const loadingContent = submitBtn.querySelector('.btn-loading-content');

                    const rows = document.querySelectorAll('#bookItemsContainer .book-item-row');
                    if (rows.length === 0) {
                        alert('Silakan pilih minimal 1 judul buku yang ingin dipinjam.');
                        return;
                    }

                    // Client validation
                    let hasError = false;
                    const bookTotals = {};

                    rows.forEach((row, i) => {
                        if (hasError) return;
                        const select = row.querySelector('.book-item-select');
                        const qtyInput = row.querySelector('.book-item-qty');
                        if (!select || !qtyInput) return;

                        if (!select.value) {
                            alert(`Judul Buku #${i + 1}: Silakan pilih buku yang ingin dipinjam.`);
                            select.focus();
                            hasError = true;
                            return;
                        }

                        const opt = select.options[select.selectedIndex];
                        const stock = parseInt(opt.getAttribute('data-stock') || '0', 10);
                        const qty = parseInt(qtyInput.value || '0', 10);
                        const title = opt.getAttribute('data-title') || opt.textContent.trim();

                        if (isNaN(qty) || qty < 1) {
                            alert(`Judul Buku #${i + 1} (${title}): Jumlah peminjaman minimal 1 eksemplar.`);
                            qtyInput.focus();
                            hasError = true;
                            return;
                        }

                        const bId = select.value;
                        if (!bookTotals[bId]) {
                            bookTotals[bId] = { totalQty: 0, stock: stock, title: title, input: qtyInput };
                        }
                        bookTotals[bId].totalQty += qty;
                    });

                    if (hasError) return;

                    // Periksa apakah total pinjam tiap buku melebihi sisa stok yang tersedia
                    for (const bId in bookTotals) {
                        const item = bookTotals[bId];
                        if (item.totalQty > item.stock) {
                            alert(`Total peminjaman buku "${item.title}" (${item.totalQty} eksemplar) melebihi stok yang tersedia (${item.stock} eksemplar)! Silakan sesuaikan jumlah.`);
                            item.input.focus();
                            return;
                        }
                    }

                    // Set loading state
                    submitBtn.classList.add('loading');
                    if (textContent) textContent.style.display = 'none';
                    if (loadingContent) loadingContent.style.display = 'inline-flex';
                    ProgressEngine.start();

                    const formData = new FormData(bookLoanForm);

                    fetch(bookLoanForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        return res.json().then(data => ({ status: res.status, body: data }));
                    })
                    .then(({ status, body }) => {
                        const alertContainer = document.getElementById('alertAndReceiptContainer');
                        if (status >= 200 && status < 300 && body.success) {
                            // Render Receipt Card Multi-Buku
                            const r = body.receipt || {};
                            let bookRowsHtml = '';

                            if (r.books && r.books.length > 1) {
                                let bookListItems = '';
                                r.books.forEach(b => {
                                    bookListItems += `
                                        <li style="margin-bottom:4px;">
                                            <strong>${escapeHtml(b.title)}</strong> &mdash; <span style="color:var(--rosewood); font-weight:700;">${b.quantity} Eksemplar</span>
                                        </li>
                                    `;
                                });
                                bookRowsHtml = `
                                    <tr>
                                        <td>Daftar Buku Dipinjam</td>
                                        <td>
                                            <ul style="margin:0; padding-left:18px; line-height:1.6;">
                                                ${bookListItems}
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Buku Dipinjam</td>
                                        <td><strong style="color:var(--rosewood); font-size:14px;">${r.quantity || 1} Eksemplar</strong> (${r.books.length} Judul Buku)</td>
                                    </tr>
                                `;
                            } else {
                                const bTitle = r.book_title || (r.books && r.books[0] ? r.books[0].title : '-');
                                bookRowsHtml = `
                                    <tr><td>Judul Buku</td><td>${escapeHtml(bTitle)}</td></tr>
                                    <tr><td>Jumlah Buku</td><td>${r.quantity || 1} Eksemplar</td></tr>
                                `;
                            }

                            if (alertContainer) {
                                alertContainer.innerHTML = `
                                    <div class="alert alert-success">
                                        <span class="material-symbols-outlined" style="font-size:22px;">check_circle</span>
                                        <div>
                                            <strong>Peminjaman Berhasil Diajukan!</strong>
                                            <p>${escapeHtml(body.message || 'Peminjaman buku berhasil dicatat dalam sistem.')}</p>
                                        </div>
                                    </div>
                                    <div class="receipt-card">
                                        <div class="receipt-header">
                                            <div class="receipt-title">
                                                <span class="material-symbols-outlined" style="color:var(--rosewood);">receipt_long</span>
                                                <span>Tanda Terima Peminjaman Buku</span>
                                            </div>
                                            <div class="receipt-code-pill">
                                                ${(r.books && r.books.length > 1) ? r.books.length + ' Judul Buku' : '1 Judul Buku'}
                                            </div>
                                        </div>
                                        <table class="receipt-table">
                                            <tr><td>Nama Peminjam</td><td>${escapeHtml(r.borrower_name || '-')}</td></tr>
                                            <tr><td>Bagian / Divisi</td><td>${escapeHtml(r.borrower_department || '-')}</td></tr>
                                            ${r.borrower_phone ? `<tr><td>No. Telepon / WhatsApp</td><td>${escapeHtml(r.borrower_phone)}</td></tr>` : ''}
                                            ${bookRowsHtml}
                                            <tr><td>Tanggal Peminjaman</td><td>${escapeHtml(r.loan_date || '-')}</td></tr>
                                            <tr><td>Rencana Pengembalian</td><td><span style="color:#B91C1C;">${escapeHtml(r.due_date || '-')}</span></td></tr>
                                            ${r.notes ? `<tr><td>Catatan</td><td>${escapeHtml(r.notes)}</td></tr>` : ''}
                                        </table>
                                        <div class="receipt-action-bar">
                                            <button type="button" class="btn-new-loan" onclick="openNewLoanForm()">
                                                <span class="material-symbols-outlined">add_circle</span>
                                                <span>+ Catat Peminjaman Baru</span>
                                            </button>
                                        </div>
                                    </div>
                                `;
                            }

                            showToast('Peminjaman buku berhasil diajukan!');

                            // Sembunyikan formulir peminjaman agar tidak langsung muncul kembali
                            bookLoanForm.style.display = 'none';

                            // Smooth scroll ke tanda terima peminjaman
                            const formAnchor = document.getElementById('form-peminjaman');
                            if (formAnchor) formAnchor.scrollIntoView({ behavior: 'smooth' });

                            // Refresh data across the page via SPA
                            executeCatalogFilter();
                        } else {
                            if (alertContainer) {
                                alertContainer.innerHTML = `
                                    <div class="alert alert-danger">
                                        <span class="material-symbols-outlined" style="font-size:22px;">error</span>
                                        <div>
                                            <strong>Gagal Mengajukan Peminjaman:</strong>
                                            <p>${escapeHtml(body.message || 'Terjadi kesalahan sistem.')}</p>
                                        </div>
                                    </div>
                                `;
                            }
                            showToast(body.message || 'Gagal mengajukan peminjaman.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Submit error:', err);
                        showToast('Terjadi kesalahan jaringan.', 'error');
                    })
                    .finally(() => {
                        submitBtn.classList.remove('loading');
                        if (textContent) textContent.style.display = 'inline-flex';
                        if (loadingContent) loadingContent.style.display = 'none';
                        ProgressEngine.done();
                    });
                });
            }

            // SPA AJAX Submission for Return Loan Form
            if (returnLoanForm) {
                returnLoanForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('btnConfirmReturnSubmit');
                    const textContent = submitBtn.querySelector('.btn-text-content');
                    const loadingContent = submitBtn.querySelector('.btn-loading-content');

                    submitBtn.classList.add('loading');
                    if (textContent) textContent.style.display = 'none';
                    if (loadingContent) loadingContent.style.display = 'inline-flex';
                    ProgressEngine.start();

                    const formData = new FormData(returnLoanForm);

                    fetch(returnLoanForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        closeConfirmReturnModal();
                        if (data.success) {
                            showToast(data.message || 'Buku berhasil dikembalikan!');
                            // Refresh data seamlessly
                            executeCatalogFilter();
                        } else {
                            showToast(data.message || 'Gagal memproses pengembalian.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Return error:', err);
                        closeConfirmReturnModal();
                        showToast('Terjadi kesalahan saat memproses pengembalian.', 'error');
                    })
                    .finally(() => {
                        submitBtn.classList.remove('loading');
                        if (textContent) textContent.style.display = 'inline-flex';
                        if (loadingContent) loadingContent.style.display = 'none';
                        ProgressEngine.done();
                    });
                });
            }

            // Inisialisasi baris pertama jika ada value terpilih
            const initialSelect = document.getElementById('book_id');
            if (initialSelect && initialSelect.value) {
                handleBookRowSelectChange(initialSelect, false);
            }
            updateRemoveButtonsState();
            recalculateTotals();
        });

        // Dynamic Multi-Book Item Functions
        function createNewBookRow(selectedBookId = null) {
            const template = document.getElementById('bookItemRowTemplate');
            const container = document.getElementById('bookItemsContainer');
            if (!template || !container) return null;

            const rows = container.querySelectorAll('.book-item-row');
            const newIndex = rows.length;
            const newNumber = newIndex + 1;

            let html = template.innerHTML;
            html = html.replace(/__INDEX__/g, newIndex).replace(/__NUMBER__/g, newNumber);

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html.trim();
            const newRow = tempDiv.firstElementChild;

            container.appendChild(newRow);
            reindexBookRows();

            if (selectedBookId) {
                const sel = newRow.querySelector('.book-item-select');
                if (sel) {
                    sel.value = selectedBookId;
                    handleBookRowSelectChange(sel, false);
                }
            }

            recalculateTotals();
            return newRow;
        }

        function removeBookRow(btn) {
            const container = document.getElementById('bookItemsContainer');
            if (!container) return;

            const row = btn.closest('.book-item-row');
            if (!row) return;

            const rows = container.querySelectorAll('.book-item-row');
            if (rows.length > 1) {
                row.remove();
                reindexBookRows();
                recalculateTotals();
            }
        }

        function reindexBookRows() {
            const container = document.getElementById('bookItemsContainer');
            if (!container) return;

            const rows = container.querySelectorAll('.book-item-row');
            rows.forEach((row, i) => {
                row.setAttribute('data-index', i);
                const numberBadge = row.querySelector('.item-title-label');
                if (numberBadge) {
                    numberBadge.textContent = `Judul Buku #${i + 1}`;
                }

                const sel = row.querySelector('.book-item-select');
                const qty = row.querySelector('.book-item-qty');

                if (sel) sel.name = `items[${i}][book_id]`;
                if (qty) qty.name = `items[${i}][quantity]`;

                // Pastikan ID book_id dan quantity tetap ada pada baris pertama untuk selector kompatibilitas
                if (i === 0) {
                    if (sel) sel.id = 'book_id';
                    if (qty) qty.id = 'quantity';
                }
            });

            updateRemoveButtonsState();
        }

        function updateRemoveButtonsState() {
            const container = document.getElementById('bookItemsContainer');
            if (!container) return;

            const rows = container.querySelectorAll('.book-item-row');
            const btns = container.querySelectorAll('.btn-remove-book-row');

            btns.forEach(btn => {
                btn.disabled = rows.length <= 1;
            });
        }

        function handleBookRowSelectChange(selectEl, triggerRecalc = true) {
            const row = selectEl.closest('.book-item-row');
            if (!row) return;

            const stockDisplay = row.querySelector('.row-stock-display');
            const stockPill = row.querySelector('.row-stock-pill');
            const qtyInput = row.querySelector('.book-item-qty');
            const qtyHint = row.querySelector('.row-qty-hint');

            if (!selectEl.value) {
                if (stockDisplay) stockDisplay.style.display = 'none';
                if (qtyInput) qtyInput.removeAttribute('max');
                if (qtyHint) qtyHint.textContent = 'Minimal 1 eksemplar.';
                if (triggerRecalc) recalculateTotals();
                return;
            }

            const opt = selectEl.options[selectEl.selectedIndex];
            const stock = parseInt(opt.getAttribute('data-stock') || '0', 10);

            if (stockDisplay && stockPill) {
                stockDisplay.style.display = 'block';
                if (stock > 0) {
                    stockPill.className = 'stock-indicator-pill avail row-stock-pill';
                    stockPill.textContent = `Stok Tersedia: ${stock} Eksemplar`;
                } else {
                    stockPill.className = 'stock-indicator-pill empty row-stock-pill';
                    stockPill.textContent = `Stok Habis (0 Eksemplar)`;
                }
            }

            if (qtyInput) {
                qtyInput.setAttribute('max', stock);
                if (parseInt(qtyInput.value || '1', 10) > stock) {
                    qtyInput.value = stock > 0 ? 1 : 0;
                }
            }

            if (qtyHint) {
                qtyHint.textContent = `Maksimal dapat dipinjam saat ini: ${stock} eksemplar.`;
            }

            if (triggerRecalc) recalculateTotals();
        }

        function handleBookRowQtyInput(qtyInput) {
            const row = qtyInput.closest('.book-item-row');
            if (row) {
                const sel = row.querySelector('.book-item-select');
                if (sel && sel.value) {
                    const opt = sel.options[sel.selectedIndex];
                    const stock = parseInt(opt.getAttribute('data-stock') || '0', 10);
                    const val = parseInt(qtyInput.value || '0', 10);
                    if (val > stock) {
                        qtyInput.style.borderColor = '#DC2626';
                    } else {
                        qtyInput.style.borderColor = '';
                    }
                }
            }
            recalculateTotals();
        }

        function recalculateTotals() {
            const container = document.getElementById('bookItemsContainer');
            if (!container) return;

            const rows = container.querySelectorAll('.book-item-row');
            let selectedTitlesCount = 0;
            let totalQty = 0;

            rows.forEach(row => {
                const sel = row.querySelector('.book-item-select');
                const qtyInput = row.querySelector('.book-item-qty');
                if (sel && sel.value) {
                    selectedTitlesCount++;
                }
                if (qtyInput) {
                    const q = parseInt(qtyInput.value || '0', 10);
                    if (!isNaN(q) && q > 0) {
                        totalQty += q;
                    }
                }
            });

            const summaryTitles = document.getElementById('totalSummaryTitles');
            const summaryQty = document.getElementById('totalSummaryQty');

            if (summaryTitles) summaryTitles.textContent = Math.max(1, selectedTitlesCount);
            if (summaryQty) summaryQty.textContent = Math.max(1, totalQty);
        }

        // Buka formulir peminjaman baru setelah tanda terima ditampilkan
        function openNewLoanForm() {
            const form = document.getElementById('bookLoanForm');
            if (!form) return;

            // Sembunyikan dan bersihkan resi peminjaman serta alert sebelumnya dari layar
            const alertContainer = document.getElementById('alertAndReceiptContainer');
            if (alertContainer) {
                alertContainer.innerHTML = '';
            }

            // 1. Kosongkan data identitas peminjam
            const borrowerName = document.getElementById('borrower_name');
            const borrowerDept = document.getElementById('borrower_department');
            const borrowerPhone = document.getElementById('borrower_phone');
            const notes = document.getElementById('notes');
            const loanDate = document.getElementById('loan_date');
            const dueDate = document.getElementById('due_date');

            if (borrowerName) borrowerName.value = '';
            if (borrowerDept) borrowerDept.value = '';
            if (borrowerPhone) borrowerPhone.value = '';
            if (notes) notes.value = '';

            // Setel tanggal hari ini & rencana pengembalian (+7 hari)
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            if (loanDate) loanDate.value = `${yyyy}-${mm}-${dd}`;

            const due = new Date();
            due.setDate(due.getDate() + 7);
            const dueYyyy = due.getFullYear();
            const dueMm = String(due.getMonth() + 1).padStart(2, '0');
            const dueDd = String(due.getDate()).padStart(2, '0');
            if (dueDate) dueDate.value = `${dueYyyy}-${dueMm}-${dueDd}`;

            // 2. Kosongkan pilihan buku dan kembalikan ke 1 baris awal bersih
            const container = document.getElementById('bookItemsContainer');
            if (container) {
                const rows = container.querySelectorAll('.book-item-row');
                rows.forEach((row, idx) => {
                    if (idx === 0) {
                        const sel = row.querySelector('.book-item-select');
                        const qty = row.querySelector('.book-item-qty');
                        if (sel) {
                            sel.value = '';
                            handleBookRowSelectChange(sel, false);
                        }
                        if (qty) qty.value = '1';
                    } else {
                        row.remove();
                    }
                });
                updateRemoveButtonsState();
                recalculateTotals();
            }

            // 3. Tampilkan formulir peminjaman
            form.style.display = 'block';

            // 4. Scroll mulus ke formulir dan fokus pada input nama peminjam
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (borrowerName) {
                setTimeout(() => borrowerName.focus(), 350);
            }
        }

        // Backward-compatible alias
        function handleBookSelectChange(selectEl) {
            handleBookRowSelectChange(selectEl, true);
        }

        // Quick select book from catalog button (Menambah / Memilih di Formulir)
        function quickSelectBook(bookId, bookTitle, availableStock) {
            const form = document.getElementById('bookLoanForm');
            if (form && form.style.display === 'none') {
                openNewLoanForm();
            }

            const container = document.getElementById('bookItemsContainer');
            const formSection = document.getElementById('form-peminjaman');

            if (!container) return;

            let targetRow = null;
            const rows = container.querySelectorAll('.book-item-row');

            // 1. Cek apakah buku ini sudah dipilih di salah satu baris
            for (let row of rows) {
                const sel = row.querySelector('.book-item-select');
                if (sel && parseInt(sel.value, 10) === parseInt(bookId, 10)) {
                    targetRow = row;
                    break;
                }
            }

            // 2. Jika belum, cek apakah ada baris yang pilihannya masih kosong
            if (!targetRow) {
                for (let row of rows) {
                    const sel = row.querySelector('.book-item-select');
                    if (sel && !sel.value) {
                        sel.value = bookId;
                        handleBookRowSelectChange(sel);
                        targetRow = row;
                        break;
                    }
                }
            }

            // 3. Jika semua baris sudah terisi dan buku ini belum ada, buat baris baru otomatis!
            if (!targetRow) {
                targetRow = createNewBookRow(bookId);
            }

            // Scroll mulus ke formulir
            if (formSection) {
                formSection.scrollIntoView({ behavior: 'smooth' });
            }

            // Beri efek highlight visual pada baris buku yang dipilih
            if (targetRow) {
                targetRow.classList.remove('highlighted');
                void targetRow.offsetWidth; // trigger reflow
                targetRow.classList.add('highlighted');

                // Fokus ke nama peminjam jika kosong, atau ke input kuantitas baris ini
                const nameInput = document.getElementById('borrower_name');
                if (nameInput && !nameInput.value.trim()) {
                    setTimeout(() => nameInput.focus(), 250);
                } else {
                    const qtyInput = targetRow.querySelector('.book-item-qty');
                    if (qtyInput) setTimeout(() => qtyInput.focus(), 250);
                }
            }

            showToast(`Buku "${bookTitle}" dimasukkan ke formulir peminjaman.`);
        }

        // Helper utilities
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function escapeJs(str) {
            if (!str) return '';
            return String(str).replace(/'/g, "\\'");
        }

        function formatDateIndo(dateStr) {
            if (!dateStr) return '-';
            try {
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    const day = parseInt(parts[2], 10);
                    const month = months[parseInt(parts[1], 10) - 1];
                    const year = parts[0];
                    return `${day} ${month} ${year}`;
                }
                const d = new Date(dateStr);
                return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            } catch (e) {
                return dateStr;
            }
        }

        // Modal Peminjam Aktif per Buku
        function openBorrowersModal(bookTitle, borrowers) {
            const modal = document.getElementById('borrowersModal');
            const titleEl = document.getElementById('modalBookTitle');
            const contentEl = document.getElementById('modalBorrowersContent');

            if (titleEl) titleEl.textContent = bookTitle || 'Detail Buku';
            if (contentEl) {
                if (!borrowers || borrowers.length === 0) {
                    contentEl.innerHTML = `
                        <div style="text-align:center; padding:32px 16px;">
                            <div style="width:48px; height:48px; border-radius:50%; background:#ECFDF5; color:#047857; display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px;">
                                <span class="material-symbols-outlined" style="font-size:26px;">check_circle</span>
                            </div>
                            <h5 style="font-size:15px; font-weight:700; color:var(--text-main); margin-bottom:4px;">Belum Ada Peminjam</h5>
                            <p style="font-size:13px; color:var(--text-muted); margin:0;">Buku ini saat ini belum dipinjam oleh siapa pun. Seluruh stok tersedia di perpustakaan.</p>
                        </div>
                    `;
                } else {
                    let rowsHtml = '';
                    const todayStr = new Date().toISOString().slice(0, 10);

                    borrowers.forEach(b => {
                        const phone = b.borrower_phone ? `<div style="font-size:11px; color:var(--text-muted); margin-top:2px;">${escapeHtml(b.borrower_phone)}</div>` : '';
                        const loanDate = b.loan_date ? formatDateIndo(b.loan_date) : '-';
                        const dueDate = b.due_date ? formatDateIndo(b.due_date) : '-';
                        const isOverdue = b.status === 'Terlambat' || (b.due_date && b.due_date < todayStr);

                        rowsHtml += `
                            <tr>
                                <td style="padding:10px 12px;">
                                    <div style="font-weight:700; color:var(--text-main);">${escapeHtml(b.borrower_name)}</div>
                                    ${phone}
                                </td>
                                <td style="padding:10px 12px;">
                                    <span style="font-weight:600; color:var(--text-secondary);">${escapeHtml(b.borrower_department || '-')}</span>
                                </td>
                                <td style="padding:10px 12px; text-align:center; font-weight:700;">
                                    ${b.quantity || 1} Eksemplar
                                </td>
                                <td style="padding:10px 12px;">
                                    ${loanDate}
                                </td>
                                <td style="padding:10px 12px;">
                                    <div style="font-weight:700; ${isOverdue ? 'color:#B91C1C;' : 'color:var(--text-main);'}">
                                        ${dueDate}
                                    </div>
                                    ${isOverdue ? '<span style="font-size:10.5px; font-weight:700; color:#B91C1C;">(Terlambat)</span>' : ''}
                                </td>
                                <td style="padding:10px 12px; text-align:right;">
                                    <button type="button" class="btn-kembalikan" style="padding:5px 10px; font-size:11.5px;"
                                            onclick="closeBorrowersModal(); openConfirmReturnModal(${b.id}, '${escapeJs(bookTitle)}', '${escapeJs(b.borrower_name)}', ${b.quantity || 1})">
                                        <span class="material-symbols-outlined" style="font-size:14px;">assignment_turned_in</span>
                                        <span>Kembalikan</span>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    contentEl.innerHTML = `
                        <div class="table-responsive">
                            <table class="data-table-custom" style="font-size:12.5px; width:100%;">
                                <thead>
                                    <tr style="background:#FDF9FA; border-bottom:1.5px solid var(--border-soft); text-align:left;">
                                        <th style="padding:10px 12px;">Nama Peminjam</th>
                                        <th style="padding:10px 12px;">Bagian / Divisi</th>
                                        <th style="padding:10px 12px; text-align:center;">Jumlah</th>
                                        <th style="padding:10px 12px;">Tanggal Pinjam</th>
                                        <th style="padding:10px 12px;">Rencana Pengembalian</th>
                                        <th style="padding:10px 12px; text-align:right;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rowsHtml}
                                </tbody>
                            </table>
                        </div>
                    `;
                }
            }

            if (modal) modal.classList.add('show');
        }

        function closeBorrowersModal() {
            const modal = document.getElementById('borrowersModal');
            if (modal) modal.classList.remove('show');
        }

        // Modal Konfirmasi Pengembalian Buku
        function openConfirmReturnModal(loanId, bookTitle, borrowerName, quantity) {
            const modal = document.getElementById('confirmReturnModal');
            const form = document.getElementById('returnLoanForm');
            const titleEl = document.getElementById('returnModalBookTitle');
            const nameEl = document.getElementById('returnModalBorrowerName');
            const qtyEl = document.getElementById('returnModalQuantity');

            if (form) {
                form.action = `/peminjaman-buku/kembalikan/${loanId}`;
            }
            if (titleEl) titleEl.textContent = bookTitle;
            if (nameEl) nameEl.textContent = borrowerName;
            if (qtyEl) qtyEl.textContent = `${quantity} Eksemplar`;

            if (modal) modal.classList.add('show');
        }

        function closeConfirmReturnModal() {
            const modal = document.getElementById('confirmReturnModal');
            if (modal) modal.classList.remove('show');
        }

        // Close modal on click outside or ESC key
        window.addEventListener('click', function (e) {
            const bModal = document.getElementById('borrowersModal');
            const rModal = document.getElementById('confirmReturnModal');
            if (e.target === bModal) closeBorrowersModal();
            if (e.target === rModal) closeConfirmReturnModal();
        });

        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeBorrowersModal();
                closeConfirmReturnModal();
            }
        });
    </script>
</body>
</html>
