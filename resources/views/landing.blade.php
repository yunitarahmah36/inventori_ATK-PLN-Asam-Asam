<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Inventori Material - PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        /* ============================================================
           RESET & COLOR PALETTE
           Dominant: Putih (#FFFFFF & #FCF9FA)
           Aksen Utama: Rosewood (#B46A72)
           Aksen Kedua: Blush Petal (#F7C8D3)
           Font Kontras: Deep Rosewood / Plum (#3D2227 & #4D2C32)
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
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (max-width: 640px) {
            .container {
                padding: 0 16px;
            }
        }

        /* ============================================================
           NAVBAR
        ============================================================ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-soft);
            box-shadow: 0 2px 10px rgba(180, 106, 114, 0.04);
            transition: var(--transition);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
            gap: 16px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            min-width: 0;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(180, 106, 114, 0.1);
            flex-shrink: 0;
        }

        .brand-text {
            min-width: 0;
        }

        .brand-text h1 {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.2px;
            color: var(--text-main);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-text p {
            font-size: 11px;
            font-weight: 600;
            color: var(--rosewood);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 22px;
            list-style: none;
        }

        .nav-link {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--rosewood);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* Mobile Hamburger Button */
        .btn-hamburger {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            color: var(--rosewood-dark);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-hamburger:hover {
            background: var(--blush-light);
            border-color: var(--rosewood);
        }

        /* Mobile Drawer Menu */
        .mobile-nav-drawer {
            display: none;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-soft);
            padding: 16px 20px 24px;
            box-shadow: 0 12px 24px rgba(180, 106, 114, 0.08);
            animation: slideDown 0.25s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mobile-nav-drawer.open {
            display: block;
        }

        .mobile-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .mobile-nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            background: var(--bg-page);
            border: 1px solid var(--border-soft);
            transition: var(--transition);
        }

        .mobile-nav-item a:hover {
            background: var(--blush-light);
            border-color: var(--blush-petal);
            color: var(--rosewood);
        }

        .mobile-nav-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Buttons */
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
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 13px;
            border-radius: 10px;
        }

        .btn-primary {
            background: var(--rosewood);
            color: #ffffff;
            border-color: var(--rosewood);
            box-shadow: 0 4px 14px rgba(180, 106, 114, 0.22);
        }

        .btn-primary:hover {
            background: var(--rosewood-hover);
            border-color: var(--rosewood-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(180, 106, 114, 0.32);
        }

        .btn-accent {
            background: var(--blush-petal);
            color: var(--rosewood-dark);
            border-color: #F2C0CB;
            font-weight: 700;
        }

        .btn-accent:hover {
            background: #F4BAC7;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: #ffffff;
            color: var(--text-main);
            border-color: var(--border-soft);
        }

        .btn-outline:hover {
            border-color: var(--rosewood);
            color: var(--rosewood);
            background: var(--blush-light);
        }

        /* ============================================================
           HERO SECTION
        ============================================================ */
        .hero-section {
            padding: 56px 0 48px;
            background: linear-gradient(180deg, #FFFFFF 0%, #FFF8FA 60%, var(--bg-page) 100%);
            border-bottom: 1px solid var(--border-soft);
            position: relative;
            overflow: hidden;
        }

        .hero-backdrop-glow {
            position: absolute;
            top: -20%;
            right: 5%;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(247, 200, 211, 0.45) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 820px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            color: var(--rosewood);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
            max-width: 100%;
            text-align: center;
        }

        .hero-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2E7D32;
            animation: pulse-green 2s infinite;
            flex-shrink: 0;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(46, 125, 50, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(46, 125, 50, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(46, 125, 50, 0); }
        }

        .hero-title {
            font-size: clamp(24px, 5vw, 38px);
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--rosewood-dark);
            line-height: 1.25;
            margin-bottom: 16px;
        }

        .hero-title .highlight {
            color: var(--rosewood);
            position: relative;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: clamp(14px, 2.5vw, 16px);
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 680px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .hero-btn-cta {
            padding: 13px 26px;
            font-size: 15px;
            border-radius: var(--radius-md);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 16px;
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 20px 14px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--blush-petal);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--blush-light);
            color: var(--rosewood);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            color: var(--rosewood-dark);
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* ============================================================
           SECTION: FORM PENGAMBILAN BARANG
        ============================================================ */
        .section-form {
            padding: 64px 0;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-soft);
        }

        .section-header {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 36px;
        }

        .section-tag {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--rosewood);
            margin-bottom: 6px;
        }

        .section-title {
            font-size: clamp(22px, 4vw, 28px);
            font-weight: 800;
            color: var(--rosewood-dark);
            letter-spacing: -0.4px;
            margin-bottom: 10px;
        }

        .section-desc {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .form-layout {
            max-width: 820px;
            margin: 0 auto;
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border-top: 5px solid var(--rosewood);
        }

        .form-header-bar {
            background: linear-gradient(135deg, var(--blush-light) 0%, #FFFFFF 100%);
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .form-header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-header-title .icon-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            color: var(--rosewood);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .form-header-title h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--rosewood-dark);
        }

        .form-header-title p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .form-badge-open {
            padding: 5px 12px;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            color: var(--rosewood);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .form-body {
            padding: 28px;
        }

        /* Form Controls */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .form-grid-full {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--rosewood-dark);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-label .req {
            color: #C62828;
        }

        .form-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 20px;
            pointer-events: none;
            transition: var(--transition);
        }

        .form-input,
        .form-select {
            width: 100%;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-main);
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-md);
            padding: 12px 14px 12px 42px;
            outline: none;
            transition: var(--transition);
            min-height: 46px;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(180, 106, 114, 0.15);
        }

        .form-input-wrap:focus-within .form-input-icon {
            color: var(--rosewood);
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .stock-badge-live {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: var(--radius-pill);
            background: var(--blush-light);
            border: 1px solid var(--blush-petal);
            color: var(--rosewood);
            margin-top: 6px;
        }

        .stock-badge-live.warning {
            background: #FFF8E1;
            border-color: #FFE082;
            color: #B78103;
        }

        .stock-badge-live.danger {
            background: #FFEBEE;
            border-color: #FFCDD2;
            color: #C62828;
        }

        /* Success & Error Alert */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: #F1F8E9;
            border: 1px solid #C5E1A5;
            color: #2E7D32;
        }

        .alert-danger {
            background: #FFEBEE;
            border: 1px solid #FFCDD2;
            color: #C62828;
        }

        /* Receipt Card */
        .receipt-card {
            background: var(--blush-light);
            border: 1px dashed var(--rosewood);
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 24px;
        }

        .receipt-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--rosewood-dark);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border-soft);
        }

        .receipt-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            font-size: 13px;
        }

        .receipt-item-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .receipt-item-val {
            font-weight: 700;
            color: var(--rosewood-dark);
            text-align: right;
            word-break: break-word;
        }

        /* Submit Action */
        .form-footer-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border-soft);
            margin-top: 10px;
        }

        .form-note {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ============================================================
           SECTION: ALUR PENGAMBILAN
        ============================================================ */
        .section-workflow {
            padding: 64px 0;
            background: var(--bg-page);
            border-bottom: 1px solid var(--border-soft);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .step-card {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 24px 20px;
            position: relative;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .step-card:hover {
            transform: translateY(-4px);
            border-color: var(--blush-petal);
            box-shadow: var(--shadow-md);
        }

        .step-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--blush-petal);
            color: var(--rosewood-dark);
            font-weight: 800;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .step-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--rosewood-dark);
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* ============================================================
           SECTION: KATALOG STOK RINGKAS
        ============================================================ */
        .section-catalog {
            padding: 64px 0;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-soft);
        }

        .catalog-search-bar {
            max-width: 480px;
            margin: 0 auto 24px;
            position: relative;
        }

        .catalog-search-input {
            width: 100%;
            font-family: inherit;
            font-size: 14px;
            padding: 12px 18px 12px 46px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--border-soft);
            outline: none;
            background: var(--bg-page);
            color: var(--text-main);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .catalog-search-input:focus {
            background: #FFFFFF;
            border-color: var(--rosewood);
            box-shadow: 0 0 0 3px rgba(180, 106, 114, 0.12);
        }

        .catalog-search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .catalog-table-scroll-hint {
            display: none;
            text-align: right;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .catalog-table-wrapper {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            box-shadow: var(--shadow-sm);
        }

        .catalog-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
            min-width: 620px; /* Memastikan kolom tidak terpotong sempit di mobile */
        }

        .catalog-table th {
            background: var(--blush-light);
            color: var(--rosewood-dark);
            font-weight: 700;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-soft);
            white-space: nowrap;
        }

        .catalog-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-secondary);
        }

        .catalog-table tr:last-child td {
            border-bottom: none;
        }

        .catalog-table tr:hover td {
            background: #FFF9FA;
        }

        .badge-stock {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-stock-ready {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .badge-stock-low {
            background: #FFF8E1;
            color: #F57F17;
        }

        /* ============================================================
           FOOTER (BERSIH TANPA DUPLIKASI NAVIGASI)
        ============================================================ */
        .footer {
            background: #FFFFFF;
            border-top: 1px solid var(--border-soft);
            padding: 36px 0 28px;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-soft);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .footer-brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 50%;
            background: #FFFFFF;
            box-shadow: 0 2px 6px rgba(180, 106, 114, 0.08);
        }

        .footer-info h4 {
            font-size: 14px;
            font-weight: 800;
            color: var(--rosewood-dark);
            letter-spacing: -0.2px;
        }

        .footer-info p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .footer-bottom {
            padding-top: 18px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ============================================================
           RESPONSIVE BREAKPOINTS (MOBILE & TABLET EXCELLENCE)
        ============================================================ */
        @media (max-width: 992px) {
            .nav-menu {
                display: none;
            }

            .btn-hamburger {
                display: flex;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar-inner {
                height: 64px;
            }

            .brand-logo {
                width: 38px;
                height: 38px;
            }

            .brand-text h1 {
                font-size: 14px;
            }

            .brand-text p {
                font-size: 10px;
            }

            .nav-actions .btn-desktop-only {
                display: none;
            }

            .hero-section {
                padding: 40px 0 36px;
            }

            .hero-actions {
                flex-direction: column;
                gap: 12px;
            }

            .hero-btn-cta {
                width: 100%;
                max-width: 340px;
            }

            .form-body {
                padding: 20px 16px;
            }

            .form-header-bar {
                padding: 16px 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .form-grid-full {
                grid-column: span 1;
            }

            /* Ukuran font input 16px mencegah auto-zoom di browser iOS mobile */
            .form-input,
            .form-select {
                font-size: 15px;
            }

            .receipt-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .receipt-item-val {
                text-align: left;
            }

            .form-footer-action {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .form-footer-action .btn {
                width: 100%;
            }

            .catalog-table-scroll-hint {
                display: block;
            }

            .section-form,
            .section-workflow,
            .section-catalog {
                padding: 48px 0;
            }
        }

        @media (max-width: 480px) {
            .brand-text p {
                display: none; /* Sembunyikan subtitle panjang di layar sangat kecil agar tetap rapi */
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .hero-badge {
                font-size: 11px;
                padding: 6px 12px;
            }

            .form-badge-open {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================================
         NAVBAR
    ============================================================ -->
    <nav class="navbar" id="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('landing') }}" class="brand-link">
                <img src="{{ asset('images/pln_bulat.png') }}" alt="PLN Logo" class="brand-logo">
                <div class="brand-text">
                    <h1>INVENTORI MATERIAL</h1>
                    <p>PT PLN INDONESIA POWER UBP ASAM ASAM</p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <ul class="nav-menu">
                <li><a href="#hero" class="nav-link"><span class="material-symbols-outlined" style="font-size: 18px;">home</span> Beranda</a></li>
                <li><a href="#form-pengambilan" class="nav-link"><span class="material-symbols-outlined" style="font-size: 18px;">output</span> Catat Pengambilan</a></li>
                <li><a href="#katalog" class="nav-link"><span class="material-symbols-outlined" style="font-size: 18px;">inventory_2</span> Cek Stok</a></li>
                <li><a href="#alur" class="nav-link"><span class="material-symbols-outlined" style="font-size: 18px;">help_outline</span> Alur Prosedur</a></li>
            </ul>

            <div class="nav-actions">
                <a href="#form-pengambilan" class="btn btn-primary btn-sm">
                    <span class="material-symbols-outlined" style="font-size: 18px;">edit_document</span>
                    Catat Pengambilan
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm btn-desktop-only">
                        <span class="material-symbols-outlined" style="font-size: 18px;">dashboard</span>
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm btn-desktop-only">
                        <span class="material-symbols-outlined" style="font-size: 18px;">lock</span>
                        Login Admin
                    </a>
                @endauth

                <!-- Hamburger Button (Mobile & Tablet) -->
                <button type="button" class="btn-hamburger" id="mobileMenuBtn" aria-label="Buka Menu Navigasi">
                    <span class="material-symbols-outlined" id="mobileMenuIcon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div class="mobile-nav-drawer" id="mobileNavDrawer">
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a href="#hero" class="mobile-link">
                        <span class="material-symbols-outlined" style="font-size: 20px; color: var(--rosewood);">home</span>
                        Beranda
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="#form-pengambilan" class="mobile-link">
                        <span class="material-symbols-outlined" style="font-size: 20px; color: var(--rosewood);">output</span>
                        Catat Pengambilan Barang
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="#katalog" class="mobile-link">
                        <span class="material-symbols-outlined" style="font-size: 20px; color: var(--rosewood);">inventory_2</span>
                        Cek Ketersediaan Stok
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="#alur" class="mobile-link">
                        <span class="material-symbols-outlined" style="font-size: 20px; color: var(--rosewood);">help_outline</span>
                        Alur & Prosedur Pengambilan
                    </a>
                </li>
            </ul>
            <div class="mobile-nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline" style="width: 100%;">
                        <span class="material-symbols-outlined">dashboard</span>
                        Masuk Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">
                        <span class="material-symbols-outlined">lock</span>
                        Login Petugas Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ============================================================
         HERO SECTION
    ============================================================ -->
    <section class="hero-section" id="hero">
        <div class="hero-backdrop-glow"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Portal Layanan Pengambilan Terbuka Karyawan & Mitra
                </div>

                <h1 class="hero-title">
                    Pencatatan Mandiri & Transparan <br>
                    <span class="highlight">Pengambilan Material</span> Gudang
                </h1>

                <p class="hero-subtitle">
                    Akses cepat pencatatan barang keluar bagi seluruh bagian/divisi PT PLN Indonesia Power UBP Asam Asam tanpa perlu login. Transaksi tervalidasi secara instan dan stok terpotong otomatis.
                </p>

                <div class="hero-actions">
                    <a href="#form-pengambilan" class="btn btn-primary hero-btn-cta">
                        <span class="material-symbols-outlined">edit_document</span>
                        Catat Pengambilan Barang Sekarang
                    </a>
                    <a href="#katalog" class="btn btn-accent hero-btn-cta">
                        <span class="material-symbols-outlined">search</span>
                        Cek Ketersediaan Stok
                    </a>
                </div>

                <!-- Stats Strip -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <span class="material-symbols-outlined">category</span>
                        </div>
                        <div class="stat-number">{{ number_format($totalItemsAvailable, 0, ',', '.') }}</div>
                        <div class="stat-label">Jenis Barang Siap Ambil</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <span class="material-symbols-outlined">inventory</span>
                        </div>
                        <div class="stat-number">{{ number_format($totalQuantityInStock, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Unit Stok Fisik</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <span class="material-symbols-outlined">sync_alt</span>
                        </div>
                        <div class="stat-number">{{ number_format($totalTransactions, 0, ',', '.') }}</div>
                        <div class="stat-label">Riwayat Pergerakan Stok</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <span class="material-symbols-outlined">verified</span>
                        </div>
                        <div class="stat-number">24 Jam</div>
                        <div class="stat-label">Layanan Mandiri Real-Time</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION FORMULIR PENGAMBILAN BARANG
    ============================================================ -->
    <section class="section-form" id="form-pengambilan">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Formulir Mandiri</div>
                <h2 class="section-title">Form Catat Pengambilan Barang</h2>
                <p class="section-desc">
                    Silakan isi identitas dan detail material yang Anda ambil. Sistem akan memvalidasi stok dan mencatat riwayat transaksi secara otomatis.
                </p>
            </div>

            <div class="form-layout">
                <div class="form-header-bar">
                    <div class="form-header-title">
                        <div class="icon-circle">
                            <span class="material-symbols-outlined" style="font-size: 22px;">output</span>
                        </div>
                        <div>
                            <h3>Formulir Stok Keluar Publik</h3>
                            <p>Tanpa login • Otomatis memotong stok gudang</p>
                        </div>
                    </div>
                    <span class="form-badge-open">
                        <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">check_circle</span>
                        Sistem Terbuka
                    </span>
                </div>

                <div class="form-body">
                    <!-- Alert Notifikasi Berhasil -->
                    @if (session('success_pengambilan'))
                        <div class="alert alert-success">
                            <span class="material-symbols-outlined" style="font-size: 22px; flex-shrink: 0;">check_circle</span>
                            <div>
                                <strong>Transaksi Berhasil!</strong>
                                <p>{{ session('success_pengambilan') }}</p>
                            </div>
                        </div>

                        @if (session('receipt_data'))
                            @php $receipt = session('receipt_data'); @endphp
                            <div class="receipt-card">
                                <div class="receipt-title">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">receipt_long</span>
                                    BUKTI RESI PENGAMBILAN BARANG
                                </div>
                                <div class="receipt-grid">
                                    <div><span class="receipt-item-label">Waktu Pencatatan:</span></div>
                                    <div><span class="receipt-item-val">{{ $receipt['date'] }}</span></div>

                                    <div><span class="receipt-item-label">Nama Pengambil:</span></div>
                                    <div><span class="receipt-item-val">{{ $receipt['recipient'] }}</span></div>

                                    <div><span class="receipt-item-label">Nama Material:</span></div>
                                    <div><span class="receipt-item-val">{{ $receipt['material_name'] }}</span></div>

                                    <div><span class="receipt-item-label">No. Material:</span></div>
                                    <div><span class="receipt-item-val">{{ $receipt['material_number'] ?? '-' }}</span></div>

                                    <div><span class="receipt-item-label">Jumlah Diambil:</span></div>
                                    <div><span class="receipt-item-val" style="color: #B46A72;">{{ $receipt['qty_out'] }} {{ $receipt['unit'] }}</span></div>

                                    <div><span class="receipt-item-label">Sisa Stok Terkini:</span></div>
                                    <div><span class="receipt-item-val">{{ $receipt['remaining_stock'] }} {{ $receipt['unit'] }}</span></div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Alert Notifikasi Error -->
                    @if (session('error_pengambilan'))
                        <div class="alert alert-danger">
                            <span class="material-symbols-outlined" style="font-size: 22px; flex-shrink: 0;">error</span>
                            <div>
                                <strong>Terjadi Kesalahan!</strong>
                                <p>{{ session('error_pengambilan') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <span class="material-symbols-outlined" style="font-size: 22px; flex-shrink: 0;">warning</span>
                            <div>
                                <strong>Mohon periksa data formulir:</strong>
                                <ul style="margin-left: 18px; margin-top: 4px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Form Input -->
                    <form action="{{ route('pengambilan.store') }}" method="POST" id="pengambilanForm">
                        @csrf

                        <div class="form-grid">
                            <!-- Nama Pengambil -->
                            <div class="form-group">
                                <label for="nama_pengambil" class="form-label">
                                    Nama Pengambil <span class="req">*</span>
                                </label>
                                <div class="form-input-wrap">
                                    <span class="material-symbols-outlined form-input-icon">person</span>
                                    <input type="text"
                                           name="nama_pengambil"
                                           id="nama_pengambil"
                                           class="form-input"
                                           value="{{ old('nama_pengambil') }}"
                                           placeholder="Contoh: Ahmad Fauzi"
                                           required>
                                </div>
                                <span class="form-hint">Nama lengkap personel yang mengambil barang fisik.</span>
                            </div>

                            <!-- Bagian / Divisi -->
                            <div class="form-group">
                                <label for="divisi" class="form-label">
                                    Bagian / Divisi <span class="req">*</span>
                                </label>
                                <div class="form-input-wrap">
                                    <span class="material-symbols-outlined form-input-icon">corporate_fare</span>
                                    <input type="text"
                                           name="divisi"
                                           id="divisi"
                                           list="divisi-list"
                                           class="form-input"
                                           value="{{ old('divisi') }}"
                                           placeholder="Pilih atau ketik divisi/bagian"
                                           required>
                                    <datalist id="divisi-list">
                                        <option value="Operasi">
                                        <option value="Pemeliharaan Mesin">
                                        <option value="Pemeliharaan Listrik">
                                        <option value="Pemeliharaan Instrumen & Kontrol">
                                        <option value="K3 & Lingkungan (K3L)">
                                        <option value="Logistik & Pergudangan">
                                        <option value="Enjiniring & Perencanaan">
                                        <option value="Administrasi & Keuangan">
                                        <option value="Keamanan / Security">
                                        <option value="Mitra Kerja / Vendor">
                                    </datalist>
                                </div>
                                <span class="form-hint">Pilih dari saran atau ketik unit kerja Anda.</span>
                            </div>

                            <!-- Nama Barang (Material) -->
                            <div class="form-group form-grid-full">
                                <label for="material_id" class="form-label">
                                    Nama Barang / Material <span class="req">*</span>
                                </label>
                                <div class="form-input-wrap">
                                    <span class="material-symbols-outlined form-input-icon">inventory_2</span>
                                    <select name="material_id" id="material_id" class="form-select" required>
                                        <option value="" data-stock="0" data-unit="">-- Silakan Pilih Barang yang Diambil --</option>
                                        @foreach ($materials as $mat)
                                            <option value="{{ $mat->id }}"
                                                    data-stock="{{ $mat->quantity }}"
                                                    data-unit="{{ $mat->unit }}"
                                                    data-name="{{ $mat->name }}"
                                                    {{ old('material_id') == $mat->id ? 'selected' : '' }}>
                                                {{ $mat->name }} {{ $mat->material_number ? '(' . $mat->material_number . ')' : '' }} — Stok: {{ $mat->quantity }} {{ $mat->unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="liveStockInfo" style="display: none;">
                                    <div class="stock-badge-live" id="stockBadgeText">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">info</span>
                                        <span id="stockValue">Pilih barang</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah Barang -->
                            <div class="form-group">
                                <label for="quantity" class="form-label">
                                    Jumlah Pengambilan <span class="req">*</span>
                                </label>
                                <div class="form-input-wrap">
                                    <span class="material-symbols-outlined form-input-icon">pin</span>
                                    <input type="number"
                                           name="quantity"
                                           id="quantity"
                                           class="form-input"
                                           value="{{ old('quantity', 1) }}"
                                           min="1"
                                           placeholder="1"
                                           required>
                                </div>
                                <span class="form-hint" id="quantityHint">Jumlah tidak boleh melebihi stok yang tersedia.</span>
                            </div>

                            <!-- Keterangan / Keperluan -->
                            <div class="form-group">
                                <label for="description" class="form-label">
                                    Keterangan / Keperluan
                                </label>
                                <div class="form-input-wrap">
                                    <span class="material-symbols-outlined form-input-icon">description</span>
                                    <input type="text"
                                           name="description"
                                           id="description"
                                           class="form-input"
                                           value="{{ old('description') }}"
                                           placeholder="Contoh: Perbaikan panel unit 2, instalasi, dll.">
                                </div>
                                <span class="form-hint">Catatan peruntukan pengambilan (opsional).</span>
                            </div>
                        </div>

                        <!-- Action Submit -->
                        <div class="form-footer-action">
                            <div class="form-note">
                                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--rosewood);">shield</span>
                                Data disimpan otomatis dan tervalidasi langsung dengan sistem inventori.
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSubmitPengambilan">
                                <span class="material-symbols-outlined">save</span>
                                Konfirmasi & Simpan Pengambilan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION ALUR PENGAMBILAN
    ============================================================ -->
    <section class="section-workflow" id="alur">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Prosedur Operasional</div>
                <h2 class="section-title">4 Langkah Mudah Pengambilan Material</h2>
                <p class="section-desc">Standar alur kerja pengambilan barang yang tertib, transparan, dan terkontrol.</p>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-badge">1</div>
                    <h3 class="step-title">Pilih Barang</h3>
                    <p class="step-desc">Cek ketersediaan material yang dibutuhkan pada katalog atau formulir pencatatan.</p>
                </div>

                <div class="step-card">
                    <div class="step-badge">2</div>
                    <h3 class="step-title">Isi Formulir</h3>
                    <p class="step-desc">Tulis nama personel, bagian/divisi, jumlah material yang diambil, dan peruntukannya.</p>
                </div>

                <div class="step-card">
                    <div class="step-badge">3</div>
                    <h3 class="step-title">Validasi Otomatis</h3>
                    <p class="step-desc">Sistem memverifikasi batas stok secara real-time dan langsung memotong saldo stok gudang.</p>
                </div>

                <div class="step-card">
                    <div class="step-badge">4</div>
                    <h3 class="step-title">Tercatat di Sistem</h3>
                    <p class="step-desc">Transaksi resmi tersimpan ke database riwayat stok keluar dan dapat diaudit petugas admin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION KATALOG / CEK STOK
    ============================================================ -->
    <section class="section-catalog" id="katalog">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Katalog Real-Time</div>
                <h2 class="section-title">Daftar Material Siap Digunakan</h2>
                <p class="section-desc">Pantau ketersediaan stok fisik barang sebelum melakukan pencatatan pengambilan.</p>
            </div>

            <div class="catalog-search-bar">
                <span class="material-symbols-outlined catalog-search-icon">search</span>
                <input type="text" id="catalogSearch" class="catalog-search-input" placeholder="Cari nama barang atau kode material...">
            </div>

            <div class="catalog-table-scroll-hint">
                <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">swipe</span>
                Geser tabel untuk melihat kolom lainnya &rarr;
            </div>

            <div class="catalog-table-wrapper">
                <table class="catalog-table" id="catalogTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 140px;">No. Material</th>
                            <th>Nama Barang</th>
                            <th style="width: 150px; text-align: center;">Sisa Stok</th>
                            <th style="width: 110px; text-align: center;">Status</th>
                            <th style="width: 140px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $index => $material)
                            <tr class="catalog-row" data-name="{{ strtolower($material->name) }}" data-number="{{ strtolower($material->material_number ?? '') }}">
                                <td>{{ $index + 1 }}</td>
                                <td><span style="font-family: monospace; font-weight: 700;">{{ $material->material_number ?? '-' }}</span></td>
                                <td><strong>{{ $material->name }}</strong></td>
                                <td style="text-align: center; font-weight: 700; color: var(--rosewood-dark);">
                                    {{ $material->quantity }} {{ $material->unit }}
                                </td>
                                <td style="text-align: center;">
                                    @if ($material->quantity > 10)
                                        <span class="badge-stock badge-stock-ready">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span> Tersedia
                                        </span>
                                    @else
                                        <span class="badge-stock badge-stock-low">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">warning</span> Terbatas
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button type="button"
                                            class="btn btn-primary btn-sm btn-select-item"
                                            data-id="{{ $material->id }}"
                                            style="padding: 5px 12px; font-size: 12px;">
                                        <span class="material-symbols-outlined" style="font-size: 15px;">add_shopping_cart</span> Ambil
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-muted);">
                                    Belum ada material dengan stok tersedia saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ============================================================
         FOOTER (BERSIH - NAVIGASI BAWAH DIHAPUS AGAR TIDAK DUPLIKAT)
    ============================================================ -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
    
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} PT PLN Indonesia Power UBP Asam Asam. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- ============================================================
         JAVASCRIPT: INTERAKTIF STOK, SELECTOR, MOBILE MENU, DAN FILTER
    ============================================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileNavDrawer = document.getElementById('mobileNavDrawer');
            const mobileMenuIcon = document.getElementById('mobileMenuIcon');
            const mobileLinks = document.querySelectorAll('.mobile-link');

            if (mobileMenuBtn && mobileNavDrawer) {
                mobileMenuBtn.addEventListener('click', function () {
                    const isOpen = mobileNavDrawer.classList.toggle('open');
                    if (mobileMenuIcon) {
                        mobileMenuIcon.textContent = isOpen ? 'close' : 'menu';
                    }
                });

                mobileLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        mobileNavDrawer.classList.remove('open');
                        if (mobileMenuIcon) {
                            mobileMenuIcon.textContent = 'menu';
                        }
                    });
                });
            }

            // Material Form & Stock Validation
            const materialSelect = document.getElementById('material_id');
            const qtyInput = document.getElementById('quantity');
            const qtyHint = document.getElementById('quantityHint');
            const liveStockInfo = document.getElementById('liveStockInfo');
            const stockBadgeText = document.getElementById('stockBadgeText');
            const stockValue = document.getElementById('stockValue');
            const form = document.getElementById('pengambilanForm');
            const catalogSearch = document.getElementById('catalogSearch');
            const catalogRows = document.querySelectorAll('.catalog-row');
            const btnSelectItems = document.querySelectorAll('.btn-select-item');

            function updateStockDisplay() {
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) {
                    liveStockInfo.style.display = 'none';
                    qtyInput.removeAttribute('max');
                    qtyHint.textContent = 'Jumlah tidak boleh melebihi stok yang tersedia.';
                    return;
                }

                const stock = parseInt(selectedOption.getAttribute('data-stock') || '0', 10);
                const unit = selectedOption.getAttribute('data-unit') || '';

                liveStockInfo.style.display = 'block';
                stockBadgeText.className = 'stock-badge-live';

                if (stock <= 0) {
                    stockBadgeText.classList.add('danger');
                    stockValue.textContent = `Stok Habis (0 ${unit})`;
                } else if (stock <= 5) {
                    stockBadgeText.classList.add('warning');
                    stockValue.textContent = `Stok Terbatas: ${stock} ${unit} tersedia`;
                } else {
                    stockValue.textContent = `Stok Tersedia: ${stock} ${unit}`;
                }

                qtyInput.setAttribute('max', stock);
                qtyHint.textContent = `Maksimal pengambilan saat ini: ${stock} ${unit}`;

                // Validasi live jika input quantity melebihi stok
                validateLiveQuantity();
            }

            function validateLiveQuantity() {
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;

                const stock = parseInt(selectedOption.getAttribute('data-stock') || '0', 10);
                const currentQty = parseInt(qtyInput.value || '0', 10);

                if (currentQty > stock) {
                    qtyInput.style.borderColor = '#C62828';
                    qtyInput.style.boxShadow = '0 0 0 3px rgba(198, 40, 40, 0.15)';
                    qtyHint.innerHTML = `<span style="color: #C62828; font-weight: 700;">Jumlah (${currentQty}) melebihi stok tersedia (${stock})!</span>`;
                } else {
                    qtyInput.style.borderColor = '';
                    qtyInput.style.boxShadow = '';
                    qtyHint.textContent = `Maksimal pengambilan saat ini: ${stock} ${selectedOption.getAttribute('data-unit') || ''}`;
                }
            }

            materialSelect.addEventListener('change', updateStockDisplay);
            qtyInput.addEventListener('input', validateLiveQuantity);

            // Inisialisasi awal jika ada old() value
            if (materialSelect.value) {
                updateStockDisplay();
            }

            // Quick select dari tabel katalog
            btnSelectItems.forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    if (id && materialSelect) {
                        materialSelect.value = id;
                        updateStockDisplay();
                        // Scroll ke form
                        const formSection = document.getElementById('form-pengambilan');
                        if (formSection) {
                            formSection.scrollIntoView({ behavior: 'smooth' });
                        }
                        // Focus ke nama pengambil atau quantity
                        const namaInput = document.getElementById('nama_pengambil');
                        if (namaInput && !namaInput.value) {
                            namaInput.focus();
                        } else {
                            qtyInput.focus();
                        }
                    }
                });
            });

            // Filter pencarian tabel katalog
            if (catalogSearch) {
                catalogSearch.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();
                    catalogRows.forEach(row => {
                        const name = row.getAttribute('data-name') || '';
                        const number = row.getAttribute('data-number') || '';
                        if (name.includes(query) || number.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Submit validation prevent submit jika stock tidak mencukupi
            if (form) {
                form.addEventListener('submit', function (e) {
                    const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        const stock = parseInt(selectedOption.getAttribute('data-stock') || '0', 10);
                        const qty = parseInt(qtyInput.value || '0', 10);
                        if (qty > stock) {
                            e.preventDefault();
                            alert(`Jumlah pengambilan (${qty}) melebihi stok fisik yang tersedia (${stock})! Silakan sesuaikan jumlah.`);
                            qtyInput.focus();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
