<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Profil Pengguna - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">

    <!-- Smooth Loading Preloader Script -->
    <script>
        document.documentElement.classList.add('page-loading');
        window.addEventListener('load', function () {
            document.documentElement.classList.remove('page-loading');
            if (window.YouTubeProgress) {
                window.YouTubeProgress.done();
            }
        });
    </script>

    <style>
        html.page-loading body {
            opacity: 0;
            visibility: hidden;
        }

        html:not(.page-loading) body {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.22s ease-in;
        }
    </style>

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
            --border-focus: #0057B8;
            --red: #DC2626;
            --red-light: #FEE2E2;
            --green: #10B981;
            --green-light: #D1FAE5;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 14px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 30px rgba(0, 59, 115, 0.12);
            --transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
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
            min-width: 0;
            transition: opacity 0.15s ease;
        }

        /* ============================================================
           TOPBAR / HEADER
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
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .topbar-left p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
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
            transition: background var(--transition);
            cursor: pointer;
        }

        .btn-hamburger:hover {
            background: var(--bg);
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

        /* ============================================================
           PAGE CONTENT CONTAINER
        ============================================================ */
        .page-content {
            flex: 1;
            padding: 28px 32px 100px;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
        }

        /* ============================================================
           PROFILE HERO BANNER
        ============================================================ */
        .profile-banner {
            position: relative;
            background: linear-gradient(135deg, #002855 0%, #003B73 45%, #0057B8 100%);
            border-radius: var(--radius);
            padding: 36px 36px 32px;
            color: #FFFFFF;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 24px;
        }

        /* Decorative glowing pattern */
        .profile-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255, 193, 7, 0.22) 0%, rgba(0, 87, 184, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .profile-banner::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 20%;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            flex-wrap: wrap;
        }

        .banner-user-left {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .banner-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .banner-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);
            color: #003B73;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 900;
            border: 4px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            text-transform: uppercase;
        }

        .banner-avatar-status {
            position: absolute;
            bottom: 3px;
            right: 3px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #10B981;
            border: 3px solid #003B73;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.8);
        }

        .banner-user-info h2 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.01em;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .banner-verified {
            font-size: 20px;
            color: #FFC107;
            vertical-align: middle;
        }

        .banner-user-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .banner-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
        }

        .banner-meta-item .material-symbols-outlined {
            font-size: 16px;
            color: #FFC107;
        }

        .banner-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            background: #FFC107;
            color: #003B73;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Banner quick stats pills */
        .banner-stats {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .banner-stat-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            padding: 12px 18px;
            min-width: 120px;
            text-align: center;
            transition: transform var(--transition), background var(--transition);
        }

        .banner-stat-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.18);
        }

        .banner-stat-val {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            line-height: 1.1;
        }

        .banner-stat-lbl {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.78);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
        }

        /* ============================================================
           ALERT / TOAST MESSAGE
        ============================================================ */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 22px;
            box-shadow: var(--shadow-sm);
            animation: alertSlideDown 0.28s ease-out;
        }

        @keyframes alertSlideDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .alert-icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .alert-content ul {
            margin: 6px 0 0 18px;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 2px;
            opacity: 0.7;
            transition: opacity 0.15s ease;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* ============================================================
           TAB NAVIGATION BAR
        ============================================================ */
        .tabs-header {
            display: flex;
            gap: 8px;
            background: var(--white);
            padding: 8px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .tab-btn {
            flex: 1;
            min-width: 170px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 10px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
        }

        .tab-btn .material-symbols-outlined {
            font-size: 19px;
            transition: transform var(--transition);
        }

        .tab-btn:hover {
            color: var(--blue-dark);
            background: #F8FAFC;
        }

        .tab-btn.active {
            background: var(--blue);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 87, 184, 0.25);
        }

        .tab-btn.active .material-symbols-outlined {
            color: var(--yellow);
            transform: scale(1.08);
        }

        /* ============================================================
           TAB CONTENT PANELS
        ============================================================ */
        .tab-pane {
            display: none;
            animation: paneFadeIn 0.24s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .tab-pane.active {
            display: block;
        }

        @keyframes paneFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================================
           CARD COMPONENTS
        ============================================================ */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 24px;
        }

        .card-header-clean {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            gap: 16px;
        }

        .card-header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--blue-light);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-header-icon.security {
            background: #FEF3C7;
            color: #D97706;
        }

        .card-header-icon.activity {
            background: #EDE9FE;
            color: #7C3AED;
        }

        .card-header-title h3 {
            font-size: 17px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1.2;
        }

        .card-header-title p {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ============================================================
           FORMS & INPUTS
        ============================================================ */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-label span.req {
            color: var(--red);
            margin-left: 2px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            font-size: 19px;
            pointer-events: none;
            transition: color var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 44px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text-dark);
            background: #FAFBFD;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
        }

        .form-control:focus {
            background: #FFFFFF;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 87, 184, 0.12);
        }

        .form-control:focus + .input-icon-left,
        .input-wrap:focus-within .input-icon-left {
            color: var(--blue);
        }

        .form-control.is-invalid {
            border-color: var(--red);
            background: #FFF5F5;
        }

        .form-control.is-readonly {
            background: #F1F5F9;
            color: #64748B;
            cursor: not-allowed;
            border-color: #E2E8F0;
        }

        .btn-toggle-pass {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color var(--transition);
        }

        .btn-toggle-pass:hover {
            color: var(--text-dark);
        }

        .input-hint {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 3px;
            line-height: 1.4;
        }

        .invalid-feedback {
            font-size: 11.5px;
            color: var(--red);
            margin-top: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Password strength indicator bar */
        .pass-meter-wrap {
            margin-top: 6px;
        }

        .pass-meter-bar {
            height: 4px;
            width: 100%;
            background: #E2E8F0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .pass-meter-fill {
            height: 100%;
            width: 0%;
            border-radius: 4px;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .pass-meter-text {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
        }

        /* ============================================================
           ACTION BUTTONS
        ============================================================ */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all var(--transition);
            text-decoration: none;
        }

        .btn-primary {
            background: var(--blue);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 87, 184, 0.25);
        }

        .btn-primary:hover {
            background: #004696;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 87, 184, 0.32);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #F1F5F9;
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #E2E8F0;
            color: var(--text-dark);
        }

        .btn:disabled,
        .btn.loading {
            opacity: 0.65;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Spinner inside button */
        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #FFFFFF;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ============================================================
           SECURITY TIPS CARD
        ============================================================ */
        .security-tip-box {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            color: #92400E;
        }

        .security-tip-icon {
            font-size: 22px;
            color: #D97706;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .security-tip-text h4 {
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .security-tip-text p {
            font-size: 12.5px;
            line-height: 1.5;
            color: #B45309;
        }

        /* ============================================================
           RECENT ACTIVITY LIST
        ============================================================ */
        .activity-timeline {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            background: #F8FAFC;
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all var(--transition);
            gap: 16px;
        }

        .activity-item:hover {
            background: #FFFFFF;
            border-color: #CBD5E1;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            transform: translateX(3px);
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .activity-icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .activity-icon-badge.masuk {
            background: #D1FAE5;
            color: #059669;
        }

        .activity-icon-badge.keluar {
            background: #FEE2E2;
            color: #DC2626;
        }

        .activity-icon-badge.penyesuaian {
            background: #DBEAFE;
            color: #2563EB;
        }

        .activity-details {
            min-width: 0;
        }

        .activity-material-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .activity-right {
            text-align: right;
            flex-shrink: 0;
        }

        .activity-qty {
            font-size: 14px;
            font-weight: 800;
        }

        .activity-qty.masuk {
            color: #059669;
        }

        .activity-qty.keluar {
            color: #DC2626;
        }

        .activity-qty.penyesuaian {
            color: #2563EB;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .empty-activity {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }

        .empty-activity-icon {
            font-size: 54px;
            color: #CBD5E1;
            margin-bottom: 12px;
        }

        .empty-activity h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .empty-activity p {
            font-size: 13px;
            max-width: 360px;
            margin: 0 auto 18px;
        }

        /* ============================================================
           RESPONSIVE STYLES
        ============================================================ */
        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .profile-banner {
                padding: 24px 20px;
            }

            .banner-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .banner-stats {
                width: 100%;
                justify-content: space-between;
            }

            .banner-stat-card {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0 !important;
            }

            .topbar {
                padding: 0 16px;
            }

            .btn-hamburger {
                display: flex;
            }

            .topbar-user {
                padding: 4px 8px;
            }

            .topbar-user-email {
                display: none;
            }

            .page-content {
                padding: 18px 16px 80px;
            }

            .card {
                padding: 20px 16px;
            }

            .banner-user-left {
                flex-direction: column;
                align-items: center;
                text-align: center;
                width: 100%;
            }

            .banner-user-info h2 {
                justify-content: center;
            }

            .banner-user-meta {
                justify-content: center;
            }

            .tabs-header {
                padding: 4px;
            }

            .tab-btn {
                min-width: 130px;
                padding: 10px 12px;
                font-size: 12.5px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="layout">

        <!-- ============================================================
             SIDEBAR NAVIGATION COMPONENT (SPA & YOUTUBE BAR ENGINE)
        ============================================================ -->
        @include('partials.sidebar')

        <!-- ============================================================
             MAIN CONTENT AREA
        ============================================================ -->
        <main class="main">

            <!-- ============================================================
                 TOPBAR (HEADER)
            ============================================================ -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button type="button" class="btn-hamburger" id="btnHamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Profil Pengguna</h1>
                        <p>Kelola data akun, keamanan kata sandi, dan riwayat aktivitas</p>
                    </div>
                </div>

                <!-- Topbar User Pill -->
                <div class="topbar-user">
                    <div class="topbar-user-detail">
                        <div class="topbar-user-name">{{ $user->name }}</div>
                        <div class="topbar-user-email">{{ $user->email }}</div>
                        <span class="badge-role">{{ $user->role }}</span>
                    </div>
                    <div class="topbar-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- ============================================================
                 PAGE CONTENT
            ============================================================ -->
            <div class="page-content">

                <!-- Flash Message: Sukses -->
                @if (session('success'))
                    <div class="alert alert-success" role="alert" id="successAlert">
                        <span class="material-symbols-outlined alert-icon">check_circle</span>
                        <div class="alert-content">
                            <strong>Berhasil!</strong>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif

                <!-- Flash Message: Error Validasi -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert" id="errorAlert">
                        <span class="material-symbols-outlined alert-icon">error</span>
                        <div class="alert-content">
                            <strong>Terdapat kesalahan pada formulir:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif

                <!-- ============================================================
                     1. PROFILE HERO BANNER
                ============================================================ -->
                <div class="profile-banner">
                    <div class="banner-content">
                        <div class="banner-user-left">
                            <div class="banner-avatar-wrap">
                                <div class="banner-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="banner-avatar-status" title="Status Akun: Aktif"></div>
                            </div>
                            <div class="banner-user-info">
                                <h2>
                                    <span>{{ $user->name }}</span>
                                    <span class="material-symbols-outlined banner-verified" title="Akun Terverifikasi PLN">verified</span>
                                </h2>
                                <div class="banner-user-meta">
                                    <span class="banner-role-badge">
                                        <span class="material-symbols-outlined" style="font-size:15px;">shield_person</span>
                                        {{ $user->role }}
                                    </span>
                                    <span class="banner-meta-item">
                                        <span class="material-symbols-outlined">mail</span>
                                        {{ $user->email }}
                                    </span>
                                    <span class="banner-meta-item">
                                        <span class="material-symbols-outlined">calendar_month</span>
                                        Bergabung {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Quick Stats -->
                        <div class="banner-stats">
                            <div class="banner-stat-card">
                                <div class="banner-stat-val">{{ number_format($totalMaterial) }}</div>
                                <div class="banner-stat-lbl">Material Diinput</div>
                            </div>
                            <div class="banner-stat-card">
                                <div class="banner-stat-val">{{ number_format($totalAktivitas) }}</div>
                                <div class="banner-stat-lbl">Riwayat Stok</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================
                     2. TABS NAVIGATION
                ============================================================ -->
                <div class="tabs-header" role="tablist">
                    <button type="button" 
                            class="tab-btn {{ session('active_tab') !== 'password' ? 'active' : '' }}" 
                            id="tab-profile-btn" 
                            onclick="switchProfileTab('profile')"
                            role="tab" 
                            aria-controls="pane-profile" 
                            aria-selected="{{ session('active_tab') !== 'password' ? 'true' : 'false' }}">
                        <span class="material-symbols-outlined">person</span>
                        <span>Informasi Akun</span>
                    </button>
                    <button type="button" 
                            class="tab-btn {{ session('active_tab') === 'password' ? 'active' : '' }}" 
                            id="tab-password-btn" 
                            onclick="switchProfileTab('password')"
                            role="tab" 
                            aria-controls="pane-password" 
                            aria-selected="{{ session('active_tab') === 'password' ? 'true' : 'false' }}">
                        <span class="material-symbols-outlined">lock_reset</span>
                        <span>Keamanan & Sandi</span>
                    </button>
                    <button type="button" 
                            class="tab-btn" 
                            id="tab-activity-btn" 
                            onclick="switchProfileTab('activity')"
                            role="tab" 
                            aria-controls="pane-activity" 
                            aria-selected="false">
                        <span class="material-symbols-outlined">history</span>
                        <span>Aktivitas Terakhir</span>
                    </button>
                </div>

                <!-- ============================================================
                     3. TAB PANE 1: INFORMASI AKUN
                ============================================================ -->
                <div class="tab-pane {{ session('active_tab') !== 'password' ? 'active' : '' }}" id="pane-profile" role="tabpanel">
                    <div class="card">
                        <div class="card-header-clean">
                            <div class="card-header-title">
                                <div class="card-header-icon">
                                    <span class="material-symbols-outlined">badge</span>
                                </div>
                                <div>
                                    <h3>Edit Data Pribadi</h3>
                                    <p>Perbarui informasi akun Anda untuk identitas di sistem inventori</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" id="profileUpdateForm" onsubmit="handleFormSubmit(this)">
                            @csrf
                            @method('PUT')

                            <div class="form-grid">
                                <!-- Nama Lengkap -->
                                <div class="form-group full-width">
                                    <label class="form-label" for="inputName">
                                        <span>Nama Lengkap <span class="req">*</span></span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="text" 
                                               name="name" 
                                               id="inputName" 
                                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                               value="{{ old('name', $user->name) }}" 
                                               required 
                                               autocomplete="name"
                                               placeholder="Masukkan nama lengkap Anda">
                                        <span class="material-symbols-outlined input-icon-left">person</span>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="input-hint">Nama ini akan tercatat pada setiap penambahan dan mutasi stok.</div>
                                </div>

                                <!-- Email (Permanen / Tidak Dapat Diubah) -->
                                <div class="form-group">
                                    <label class="form-label" for="inputEmail">
                                        <span>Alamat Email</span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="email" 
                                               id="inputEmail" 
                                               class="form-control is-readonly" 
                                               value="{{ $user->email }}" 
                                               readonly>
                                        <span class="material-symbols-outlined input-icon-left">mail</span>
                                    </div>
                                    <div class="input-hint">Alamat email terdaftar dan tidak dapat diubah.</div>
                                </div>

                                <!-- Role / Hak Akses (Permanen / Tidak Dapat Diubah) -->
                                <div class="form-group">
                                    <label class="form-label" for="inputRole">
                                        <span>Tingkat Akses (Role)</span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="text" 
                                               id="inputRole" 
                                               class="form-control is-readonly" 
                                               value="{{ $user->role }}" 
                                               readonly>
                                        <span class="material-symbols-outlined input-icon-left">shield</span>
                                    </div>
                                    <div class="input-hint">Hak akses yang ditetapkan untuk akun Anda dalam sistem inventori.</div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="reset" class="btn btn-secondary">
                                    <span class="material-symbols-outlined">restart_alt</span>
                                    <span>Reset Perubahan</span>
                                </button>
                                <button type="submit" class="btn btn-primary" id="btnSubmitProfile">
                                    <span class="material-symbols-outlined">save</span>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ============================================================
                     4. TAB PANE 2: KEAMANAN & PASSWORD
                ============================================================ -->
                <div class="tab-pane {{ session('active_tab') === 'password' ? 'active' : '' }}" id="pane-password" role="tabpanel">
                    <div class="card">
                        <div class="card-header-clean">
                            <div class="card-header-title">
                                <div class="card-header-icon security">
                                    <span class="material-symbols-outlined">lock</span>
                                </div>
                                <div>
                                    <h3>Ubah Kata Sandi</h3>
                                    <p>Pastikan akun Anda terlindungi dengan kombinasi kata sandi yang kuat</p>
                                </div>
                            </div>
                        </div>

                        <!-- Security Notice Box -->
                        <div class="security-tip-box">
                            <span class="material-symbols-outlined security-tip-icon">security</span>
                            <div class="security-tip-text">
                                <h4>Tips Keamanan Akun PLN</h4>
                                <p>Gunakan kombinasi minimal 8 karakter yang terdiri dari huruf besar, huruf kecil, angka, dan simbol. Jangan berikan kata sandi Anda kepada pihak lain.</p>
                            </div>
                        </div>

                        <form action="{{ route('profile.password') }}" method="POST" id="passwordUpdateForm" onsubmit="handleFormSubmit(this)">
                            @csrf
                            @method('PUT')

                            <div class="form-grid">
                                <!-- Password Saat Ini -->
                                <div class="form-group full-width">
                                    <label class="form-label" for="current_password">
                                        <span>Kata Sandi Saat Ini <span class="req">*</span></span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="password" 
                                               name="current_password" 
                                               id="current_password" 
                                               class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" 
                                               required 
                                               autocomplete="current-password"
                                               placeholder="Masukkan kata sandi lama Anda">
                                        <span class="material-symbols-outlined input-icon-left">key</span>
                                        <button type="button" 
                                                class="btn-toggle-pass" 
                                                onclick="togglePasswordVisibility('current_password', this)"
                                                aria-label="Tampilkan sandi">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback">
                                            <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Baru -->
                                <div class="form-group">
                                    <label class="form-label" for="new_password">
                                        <span>Kata Sandi Baru <span class="req">*</span></span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="password" 
                                               name="new_password" 
                                               id="new_password" 
                                               class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Minimal 8 karakter"
                                               oninput="checkPasswordStrength(this.value)">
                                        <span class="material-symbols-outlined input-icon-left">lock</span>
                                        <button type="button" 
                                                class="btn-toggle-pass" 
                                                onclick="togglePasswordVisibility('new_password', this)"
                                                aria-label="Tampilkan sandi">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </button>
                                    </div>
                                    <!-- Strength Meter -->
                                    <div class="pass-meter-wrap" id="passMeterWrap" style="display:none;">
                                        <div class="pass-meter-bar">
                                            <div class="pass-meter-fill" id="passMeterFill"></div>
                                        </div>
                                        <div class="pass-meter-text">
                                            <span>Kekuatan Sandi:</span>
                                            <span id="passMeterLabel">-</span>
                                        </div>
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback">
                                            <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password Baru -->
                                <div class="form-group">
                                    <label class="form-label" for="new_password_confirmation">
                                        <span>Konfirmasi Kata Sandi Baru <span class="req">*</span></span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="password" 
                                               name="new_password_confirmation" 
                                               id="new_password_confirmation" 
                                               class="form-control" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Ulangi kata sandi baru"
                                               oninput="checkPasswordMatch()">
                                        <span class="material-symbols-outlined input-icon-left">lock_clock</span>
                                        <button type="button" 
                                                class="btn-toggle-pass" 
                                                onclick="togglePasswordVisibility('new_password_confirmation', this)"
                                                aria-label="Tampilkan sandi">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </button>
                                    </div>
                                    <div id="passMatchFeedback" style="font-size:11.5px;margin-top:3px;display:none;"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="reset" class="btn btn-secondary" onclick="resetPasswordStrength()">
                                    <span class="material-symbols-outlined">restart_alt</span>
                                    <span>Batal</span>
                                </button>
                                <button type="submit" class="btn btn-primary" id="btnSubmitPassword">
                                    <span class="material-symbols-outlined">vpn_key</span>
                                    <span>Perbarui Kata Sandi</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ============================================================
                     5. TAB PANE 3: AKTIVITAS TERAKHIR
                ============================================================ -->
                <div class="tab-pane" id="pane-activity" role="tabpanel">
                    <div class="card">
                        <div class="card-header-clean">
                            <div class="card-header-title">
                                <div class="card-header-icon activity">
                                    <span class="material-symbols-outlined">receipt_long</span>
                                </div>
                                <div>
                                    <h3>Aktivitas Mutasi Stok Terakhir</h3>
                                    <p>Catatan transaksi stok barang yang dilakukan oleh akun Anda</p>
                                </div>
                            </div>

                            <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary" style="font-size:12.5px;padding:8px 14px;" data-spa-link>
                                <span class="material-symbols-outlined" style="font-size:17px;">history</span>
                                <span>Lihat Semua Riwayat</span>
                            </a>
                        </div>

                        @if (isset($recentMovements) && $recentMovements->count() > 0)
                            <div class="activity-timeline">
                                @foreach ($recentMovements as $mv)
                                    @php
                                        $act = strtolower($mv->activity);
                                        $icon = 'tune';
                                        $typeClass = 'penyesuaian';
                                        $prefix = '';

                                        if (str_contains($act, 'masuk') || str_contains($act, 'tambah')) {
                                            $icon = 'arrow_downward';
                                            $typeClass = 'masuk';
                                            $prefix = '+';
                                        } elseif (str_contains($act, 'keluar') || str_contains($act, 'kurang')) {
                                            $icon = 'arrow_upward';
                                            $typeClass = 'keluar';
                                            $prefix = '-';
                                        } elseif (str_contains($act, 'hapus')) {
                                            $icon = 'delete';
                                            $typeClass = 'keluar';
                                            $prefix = '';
                                        }

                                        $materialDisplayName = $mv->material->name ?? ($mv->material_name ?? ($mv->material_id ? 'Material #' . $mv->material_id : 'Material Dihapus'));
                                        $materialNumber = $mv->material->material_number ?? ($mv->material_number ?? null);
                                    @endphp

                                    <div class="activity-item">
                                        <div class="activity-left">
                                            <div class="activity-icon-badge {{ $typeClass }}">
                                                <span class="material-symbols-outlined">{{ $icon }}</span>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-material-name" title="{{ $materialDisplayName }}">
                                                    {{ $materialDisplayName }}
                                                    @if ($materialNumber)
                                                        <span style="font-size:12px;font-weight:500;color:var(--text-muted);margin-left:4px;">({{ $materialNumber }})</span>
                                                    @endif
                                                </div>
                                                <div class="activity-sub">
                                                    <span style="font-weight:700;text-transform:uppercase;">{{ $mv->activity }}</span>
                                                    <span>•</span>
                                                    <span>{{ $mv->description ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="activity-right">
                                            <div class="activity-qty {{ $typeClass }}">
                                                @if ((int) $mv->quantity_change > 0)
                                                    +{{ number_format($mv->quantity_change) }}
                                                @else
                                                    {{ number_format($mv->quantity_change) }}
                                                @endif
                                                {{ $mv->material->unit ?? 'Item' }}
                                            </div>
                                            <div class="activity-time">
                                                {{ $mv->created_at ? $mv->created_at->diffForHumans() : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-activity">
                                <span class="material-symbols-outlined empty-activity-icon">inventory_2</span>
                                <h4>Belum Ada Aktivitas</h4>
                                <p>Anda belum melakukan transaksi mutasi atau penambahan stok material ATK.</p>
                                <a href="{{ route('materials.index') }}" class="btn btn-primary" data-spa-link>
                                    <span class="material-symbols-outlined">inventory_2</span>
                                    <span>Buka Data Material</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- ============================================================
         INTERACTIVE SCRIPTS (PAGE BEHAVIOR)
    ============================================================ -->
    <script>
        // Tab Switcher
        function switchProfileTab(tabName) {
            const tabs = ['profile', 'password', 'activity'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab-' + t + '-btn');
                const pane = document.getElementById('pane-' + t);
                if (btn && pane) {
                    if (t === tabName) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-selected', 'true');
                        pane.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-selected', 'false');
                        pane.classList.remove('active');
                    }
                }
            });

            // Smooth scroll up if needed
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Toggle Password Visibility
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;

            const icon = btn.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) icon.textContent = 'visibility_off';
                btn.setAttribute('aria-label', 'Sembunyikan sandi');
            } else {
                input.type = 'password';
                if (icon) icon.textContent = 'visibility';
                btn.setAttribute('aria-label', 'Tampilkan sandi');
            }
        }

        // Live Password Strength Meter
        function checkPasswordStrength(password) {
            const wrap = document.getElementById('passMeterWrap');
            const fill = document.getElementById('passMeterFill');
            const label = document.getElementById('passMeterLabel');

            if (!password || password.length === 0) {
                if (wrap) wrap.style.display = 'none';
                return;
            }

            if (wrap) wrap.style.display = 'block';

            let score = 0;
            if (password.length >= 8) score += 25;
            if (password.length >= 12) score += 15;
            if (/[A-Z]/.test(password)) score += 20;
            if (/[0-9]/.test(password)) score += 20;
            if (/[^A-Za-z0-9]/.test(password)) score += 20;

            if (score < 40) {
                fill.style.width = '30%';
                fill.style.background = '#DC2626';
                label.textContent = 'Lemah (tambahkan angka & huruf besar)';
                label.style.color = '#DC2626';
            } else if (score < 75) {
                fill.style.width = '65%';
                fill.style.background = '#F59E0B';
                label.textContent = 'Sedang (cukup aman)';
                label.style.color = '#D97706';
            } else {
                fill.style.width = '100%';
                fill.style.background = '#10B981';
                label.textContent = 'Kuat (sangat aman)';
                label.style.color = '#059669';
            }

            checkPasswordMatch();
        }

        function resetPasswordStrength() {
            const wrap = document.getElementById('passMeterWrap');
            if (wrap) wrap.style.display = 'none';
            const feedback = document.getElementById('passMatchFeedback');
            if (feedback) feedback.style.display = 'none';
        }

        // Live Password Confirmation Match
        function checkPasswordMatch() {
            const pass = document.getElementById('new_password');
            const conf = document.getElementById('new_password_confirmation');
            const feedback = document.getElementById('passMatchFeedback');

            if (!pass || !conf || !feedback) return;

            if (conf.value.length === 0) {
                feedback.style.display = 'none';
                return;
            }

            feedback.style.display = 'block';
            if (pass.value === conf.value) {
                feedback.style.color = '#059669';
                feedback.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">check_circle</span> Kata sandi konfirmasi cocok.';
            } else {
                feedback.style.color = '#DC2626';
                feedback.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">cancel</span> Kata sandi konfirmasi belum sesuai.';
            }
        }

        // Handle Form Submission with Progress Bar & Spinner
        function handleFormSubmit(form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                const icon = submitBtn.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.className = 'spinner';
                    icon.textContent = '';
                }
            }

            // Mulai progress bar YouTube secara mulus
            if (window.YouTubeProgress) {
                window.YouTubeProgress.start();
            }
        }

        // Pastikan progress bar selesai saat dimuat
        document.addEventListener('DOMContentLoaded', function () {
            if (window.YouTubeProgress) {
                window.YouTubeProgress.done();
            }
        });
    </script>

        </main>

    </div>

</body>

</html>
