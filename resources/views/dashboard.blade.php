<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Dashboard - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>
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
           RESET & BASE
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

        button {
            cursor: pointer;
            font-family: inherit;
        }

        /* scrollbar tipis */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }


        /* ============================================================
           LAYOUT WRAPPER
        ============================================================ */
        .layout {
            display: flex;
            min-height: 100vh;
        }


        /* ============================================================
           MAIN CONTENT AREA
        ============================================================ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


        /* ============================================================
           TOPBAR (Header)
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
            margin: 0;
        }

        .topbar-left p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            margin-bottom: 0;
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
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 59, 115, 0.25);
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
            text-transform: uppercase;
        }


        /* ============================================================
           PAGE CONTENT
        ============================================================ */
        .page-content {
    flex: 1;
    width: 100%;
    max-width: none;
    padding: 24px 28px 100px;
    box-sizing: border-box;
}

.welcome-card,
.quick-actions,
.stock-alert-banner,
.stats-grid,
.sections-row {
    width: 100%;
    max-width: none;
}


        /* ============================================================
           WELCOME CARD
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
        }

        .welcome-date-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 12px;
        }

        .welcome-date-badge .material-symbols-outlined {
            font-size: 14px;
        }

        .welcome-card h2 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .welcome-card p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
        }

        .welcome-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .welcome-status .material-symbols-outlined {
            font-size: 15px;
        }

        .welcome-role-badge {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            background: var(--yellow);
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 8px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }


        /* ============================================================
           SECTION TITLES
        ============================================================ */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
        }


        /* ============================================================
           AKSI CEPAT (Quick Actions)
        ============================================================ */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 18px 12px;
            border-radius: var(--radius);
            border: none;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            min-height: 80px;
        }

        .action-btn:active {
            transform: scale(0.97);
        }

        .action-btn:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .action-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-icon .material-symbols-outlined {
            font-size: 20px;
        }

        .action-btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .action-btn-primary .action-icon {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .action-btn-yellow {
            background: var(--yellow);
            color: var(--blue-dark);
        }

        .action-btn-yellow .action-icon {
            background: rgba(0, 59, 115, 0.1);
            color: var(--blue-dark);
        }

        .action-btn-white {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .action-btn-white .action-icon {
            background: var(--blue-light);
            color: var(--blue);
        }


        /* ============================================================
           STATISTIK CARDS
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
            position: relative;
            overflow: hidden;
        }

        .stat-card-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card-bar.yellow {
            background: var(--yellow);
        }

        .stat-card-bar.blue {
            background: var(--blue);
        }

        .stat-card-bar.teal {
            background: #10B981;
        }

        .stat-card-bar.orange {
            background: #F97316;
        }

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
            font-size: 18px;
        }

        .stat-icon-blue {
            background: var(--blue-light);
            color: var(--blue);
        }

        .stat-icon-yellow {
            background: var(--yellow-light);
            color: #92400E;
        }

        .stat-icon-teal {
            background: #D1FAE5;
            color: #065F46;
        }

        .stat-icon-orange {
            background: #FFF7ED;
            color: #C2410C;
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--blue-dark);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card-sub {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .stat-card-sub .material-symbols-outlined {
            font-size: 13px;
        }


        /* ============================================================
           SECTION CARDS (Material & Aktivitas)
        ============================================================ */
        .sections-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .section-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .section-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .section-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--blue-dark);
        }

        .section-card-title .material-symbols-outlined {
            font-size: 20px;
            color: var(--blue);
        }

        .btn-lihat-semua {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 12px;
            font-weight: 600;
            color: var(--blue);
            border: none;
            background: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: background var(--transition);
        }

        .btn-lihat-semua:hover {
            background: var(--blue-light);
        }

        .btn-lihat-semua .material-symbols-outlined {
            font-size: 15px;
        }


        /* Stock Alert Banner */
        .stock-alert-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            border: 1px solid #FCD34D;
            border-left: 5px solid #F59E0B;
            border-radius: var(--radius);
            padding: 16px 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.12);
        }

        .stock-alert-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stock-alert-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #B45309;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.2);
        }

        .stock-alert-icon-wrap .stock-alert-icon {
            font-size: 26px;
        }

        .stock-alert-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .stock-alert-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #92400E;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stock-alert-desc {
            font-size: 12.5px;
            color: #B45309;
            line-height: 1.45;
        }

        .stock-alert-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #D97706;
            color: #FFFFFF !important;
            font-size: 12.5px;
            font-weight: 600;
            padding: 9px 16px;
            border-radius: 8px;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(217, 119, 6, 0.25);
            transition: all var(--transition);
        }

        .stock-alert-btn:hover {
            background: #B45309;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(217, 119, 6, 0.35);
        }

        .stock-alert-btn .material-symbols-outlined {
            font-size: 16px;
        }

        .badge-header-warning {
            font-size: 11px;
            font-weight: 700;
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FCD34D;
            padding: 2px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        /* Material List */
        .material-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 6px;
            border: 1px solid transparent;
            transition: background var(--transition);
        }

        .material-item:hover {
            background: var(--bg);
        }

        .material-item.is-low-stock {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-left: 4px solid #F59E0B;
        }

        .material-item.is-critical-stock {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-left: 4px solid #EF4444;
        }

        .material-item.is-low-stock:hover {
            background: #FEF3C7;
        }

        .material-item.is-critical-stock:hover {
            background: #FEE2E2;
        }

        .material-item:last-child {
            margin-bottom: 0;
        }

        .material-item-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
            padding-right: 10px;
        }

        .material-item-top {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .material-badge-no {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 4px;
            background: var(--bg);
            color: var(--text-muted);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .material-badge-no.low-stock {
            background: var(--yellow-light);
            color: #92400E;
        }

        .material-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .material-date {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .material-date-ago {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 11px;
        }

        .material-low-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 700;
            color: #92400E;
            flex-wrap: wrap;
        }

        .material-low-label .material-symbols-outlined {
            font-size: 13px;
            color: #F59E0B;
        }

        .material-low-label.critical {
            color: #B91C1C;
        }

        .material-low-label.critical .material-symbols-outlined {
            color: #EF4444;
        }

        .material-item-right {
            text-align: right;
            flex-shrink: 0;
        }

        .material-qty {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .material-qty.low {
            color: #92400E;
        }

        .pill-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
            white-space: nowrap;
        }

        .pill-critical {
            color: #DC2626;
            background: #FEE2E2;
        }

        .pill-warning {
            color: #D97706;
            background: #FEF3C7;
        }


        /* Activity Timeline */
        .activity-list {
            position: relative;
            padding-left: 22px;
        }

        .activity-list::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: var(--border);
            border-radius: 2px;
        }

        .activity-item {
            position: relative;
            margin-bottom: 16px;
        }

        .activity-item:last-child {
            margin-bottom: 0;
        }

        .activity-dot {
            position: absolute;
            left: -22px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-dot-inner {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .dot-tambah {
            background: #D1FAE5;
        }

        .dot-tambah .activity-dot-inner {
            background: #059669;
        }

        .dot-import {
            background: var(--blue-light);
        }

        .dot-import .activity-dot-inner {
            background: var(--blue);
        }

        .dot-edit {
            background: var(--yellow-light);
        }

        .dot-edit .activity-dot-inner {
            background: #D97706;
        }

        .dot-hapus {
            background: #FEE2E2;
        }

        .dot-hapus .activity-dot-inner {
            background: #DC2626;
        }

        .dot-default {
            background: var(--bg);
        }

        .dot-default .activity-dot-inner {
            background: var(--text-muted);
        }

        .activity-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }

        .activity-desc {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.45;
        }

        .activity-desc strong {
            font-weight: 700;
            color: var(--blue);
        }

        .activity-badge {
            flex-shrink: 0;
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-tambah {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-import {
            background: var(--blue-light);
            color: #1D4ED8;
        }

        .badge-edit {
            background: var(--yellow-light);
            color: #92400E;
        }

        .badge-hapus {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .badge-other {
            background: var(--bg);
            color: var(--text-muted);
        }

        .activity-time {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 3px;
        }


        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 30px 16px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .empty-state .material-symbols-outlined {
            font-size: 36px;
            display: block;
            margin-bottom: 8px;
            color: #D1D5DB;
        }


        /* ============================================================
           MOBILE DRAWER OVERLAY
        ============================================================ */
        .drawer-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 190;
            backdrop-filter: blur(2px);
        }

        .drawer-backdrop.open {
            display: block;
        }

        /* ============================================================
           RESPONSIVE BREAKPOINTS
        ============================================================ */

        /* Tablet */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .sections-row {
                grid-template-columns: 1fr;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-left h1 {
                font-size: 17px;
            }

            .btn-hamburger {
                display: flex;
            }

            .topbar-user-detail {
                display: none;
            }

            .page-content {
                padding: 16px 16px 80px;
            }

            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 18px 18px;
            }

            .welcome-card h2 {
                font-size: 18px;
            }

            .welcome-role-badge {
                align-self: flex-start;
            }

            .quick-actions {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .action-btn {
                padding: 14px 8px;
                min-height: 70px;
                font-size: 11.5px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .stat-card-value {
                font-size: 22px;
            }

            .stock-alert-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 14px 16px;
            }

            .stock-alert-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 400px) {
            .quick-actions {
                grid-template-columns: repeat(3, 1fr);
                gap: 6px;
            }

            .action-btn {
                min-height: 64px;
                padding: 10px 4px;
            }
        }
    </style>
</head>


<body>

    <!-- ============================================================
         LAYOUT WRAPPER
    ============================================================ -->
    <div class="layout">


        <!-- SIDEBAR -->
        @include('partials.sidebar')


        <!-- ============================================================
             MAIN CONTENT
        ============================================================ -->
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
                        <h1>Dashboard</h1>
                        <p>Sistem Informasi Inventori ATK PT PLN Indonesia Power UBP Asam Asam</p>
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


            <!-- ============================================================
                 PAGE CONTENT
            ============================================================ -->
            <div class="page-content">

                <!-- ==================================================
                     1. WELCOME CARD
                ================================================== -->
                @php
                    $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $namaBulan = [
                        '',
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                    ];
                    $hariIni =
                        $namaHari[date('w')] . ', ' . date('j') . ' ' . $namaBulan[(int) date('n')] . ' ' . date('Y');
                @endphp

                <div class="welcome-card">
                    <div class="welcome-left">

                        <div class="welcome-date-badge">
                            <span class="material-symbols-outlined">calendar_today</span>
                            {{ $hariIni }}
                        </div>

                        <h2>Selamat Datang Kembali, {{ Auth::user()->name }}</h2>

                        <p>Sistem Manajemen Stok Material ATK PT PLN Indonesia Power UBP Asam Asam</p>

                    </div>

                    <!-- Badge Role: Dinamis (Admin / Umum / Keuangan) -->
                    <div class="welcome-role-badge">
                        {{ Auth::user()->role }}
                    </div>
                </div>


                <!-- ==================================================
                     2. AKSI CEPAT
                ================================================== -->
                <p class="section-label">Aksi Cepat</p>
                <div class="quick-actions" style="margin-bottom:22px;">

                    <a href="{{ route('materials.create') }}" class="action-btn action-btn-primary">
                        <div class="action-icon">
                            <span class="material-symbols-outlined">add_box</span>
                        </div>
                        + Tambah
                    </a>

                    <a href="{{ route('materials.import') }}" class="action-btn action-btn-yellow">
                        <div class="action-icon">
                            <span class="material-symbols-outlined">upload_file</span>
                        </div>
                        Import Excel
                    </a>

                    <a href="{{ route('stock-movements.index') }}" class="action-btn action-btn-white">
                        <div class="action-icon">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                        Riwayat
                    </a>

                </div>


                <!-- ==================================================
                     PERINGATAN STOK MENIPIS (Jika Ada)
                ================================================== -->
                @if ($lowStockCount > 0)
                    <div class="stock-alert-banner">
                        <div class="stock-alert-left">
                            <div class="stock-alert-icon-wrap">
                                <span class="material-symbols-outlined stock-alert-icon">warning</span>
                            </div>
                            <div class="stock-alert-info">
                                <div class="stock-alert-title">
                                    Peringatan: Terdapat {{ $lowStockCount }} Jenis Material dengan Stok Menipis!
                                </div>
                                <div class="stock-alert-desc">
                                    Material yang sudah lama masuk dan persediaannya menipis (≤ 15 unit) otomatis diprioritaskan di posisi teratas daftar material agar segera dilakukan restock / pengadaan.
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('materials.index', ['filter_stock' => 'low']) }}" class="stock-alert-btn">
                            Lihat Semua Material Menipis
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                @endif


                <!-- ==================================================
                     3. STATISTIK (4 Card, semua data dari database)
                ================================================== -->
                <p class="section-label">Ringkasan Statistik</p>
                <div class="stats-grid">

                    <!-- Card 1: Total Material -->
                    <div class="stat-card">
                        <div class="stat-card-bar yellow"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Total Material</span>
                            <div class="stat-card-icon stat-icon-blue">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $totalMaterial }}</div>
                        <div class="stat-card-sub">
                            <span class="material-symbols-outlined" style="color:#10B981;">trending_up</span>
                            Jenis material terdaftar
                        </div>
                    </div>

                    <!-- Card 2: Total Stok -->
                    <div class="stat-card">
                        <div class="stat-card-bar blue"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Total Stok</span>
                            <div class="stat-card-icon stat-icon-yellow">
                                <span class="material-symbols-outlined">bar_chart</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ number_format($totalStok, 0, ',', '.') }}</div>
                        <div class="stat-card-sub">
                            Total unit semua material
                        </div>
                    </div>

                    <!-- Card 3: Material Masuk Bulan Ini -->
                    <div class="stat-card">
                        <div class="stat-card-bar teal"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Material Masuk</span>
                            <div class="stat-card-icon stat-icon-teal">
                                <span class="material-symbols-outlined">download_done</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $materialMasuk }}</div>
                        <div class="stat-card-sub">
                            Masuk bulan {{ $namaBulan[(int) date('n')] }}
                        </div>
                    </div>

                    <!-- Card 4: Aktivitas Hari Ini -->
                    <div class="stat-card">
                        <div class="stat-card-bar orange"></div>
                        <div class="stat-card-header">
                            <span class="stat-card-label">Aktivitas Hari Ini</span>
                            <div class="stat-card-icon stat-icon-orange">
                                <span class="material-symbols-outlined">history_toggle_off</span>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $aktivitasHariIni }}</div>
                        <div class="stat-card-sub">
                            Perubahan stok hari ini
                        </div>
                    </div>

                </div>


                <!-- ==================================================
                     4 & 5. MATERIAL TERBARU + AKTIVITAS TERBARU
                ================================================== -->
                <div class="sections-row">

                    <!-- Material Terbaru & Prioritas Stok -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <div class="section-card-title">
                                <span class="material-symbols-outlined">assignment_turned_in</span>
                                Daftar Material
                                @if ($lowStockCount > 0)
                                    <a href="{{ route('materials.index', ['filter_stock' => 'low']) }}" class="badge-header-warning" title="Lihat semua material dengan stok menipis">
                                        <span class="material-symbols-outlined" style="font-size:13px;">warning</span>
                                        {{ $lowStockCount }} Menipis
                                    </a>
                                @endif
                            </div>
                            <a href="{{ route('materials.index') }}" class="btn-lihat-semua">
                                Lihat Semua
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>

                        @if ($latestMaterials->count() > 0)
                            @foreach ($latestMaterials as $mat)
                                @php
                                    $isCritical = $mat->quantity <= 5;
                                    $isLow = $mat->quantity <= 15;
                                @endphp
                                <div class="material-item {{ $isCritical ? 'is-critical-stock' : ($isLow ? 'is-low-stock' : '') }}">
                                    <div class="material-item-left">
                                        <div class="material-item-top">
                                            <span class="material-badge-no {{ $isLow ? 'low-stock' : '' }}">
                                                {{ $mat->material_number }}
                                            </span>
                                            <span class="material-name" title="{{ $mat->name }}">{{ $mat->name }}</span>
                                        </div>
                                        @if ($isLow)
                                            <div class="material-low-label {{ $isCritical ? 'critical' : '' }}">
                                                <span class="material-symbols-outlined">{{ $isCritical ? 'error' : 'warning' }}</span>
                                                <span>{{ $isCritical ? 'Stok Kritis' : 'Stok Menipis' }}</span>
                                                <span class="material-date-ago">
                                                    • Masuk: {{ $mat->entry_date ? $mat->entry_date->translatedFormat('j M Y') : '-' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="material-date">
                                                Masuk: {{ $mat->entry_date ? $mat->entry_date->translatedFormat('j M Y') : '-' }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="material-item-right">
                                        <div class="material-qty {{ $isLow ? 'low' : '' }}" style="{{ $isCritical ? 'color:#B91C1C;' : '' }}">
                                            {{ number_format($mat->quantity, 0, ',', '.') }} {{ $mat->unit }}
                                        </div>
                                        @if ($isCritical)
                                            <span class="pill-badge pill-critical">Stok Kritis</span>
                                        @elseif ($isLow)
                                            <span class="pill-badge pill-warning">Perlu Restock</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <span class="material-symbols-outlined">inventory_2</span>
                                Belum ada data material.
                            </div>
                        @endif
                    </div>


                    <!-- Aktivitas Terbaru -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <div class="section-card-title">
                                <span class="material-symbols-outlined">schedule</span>
                                Aktivitas Terbaru
                            </div>
                            <span style="font-size:12px;color:var(--text-muted);">Semua Pengguna</span>
                        </div>

                        @if ($latestActivities->count() > 0)
                            <div class="activity-list">
                                @foreach ($latestActivities as $act)
                                    @php
                                        $dotClass = match ($act->activity) {
                                            'Tambah' => 'dot-tambah',
                                            'Import' => 'dot-import',
                                            'Edit' => 'dot-edit',
                                            'Hapus' => 'dot-hapus',
                                            default => 'dot-default',
                                        };
                                        $badgeClass = match ($act->activity) {
                                            'Tambah' => 'badge-tambah',
                                            'Import' => 'badge-import',
                                            'Edit' => 'badge-edit',
                                            'Hapus' => 'badge-hapus',
                                            default => 'badge-other',
                                        };
                                        $verb = match ($act->activity) {
                                            'Tambah' => 'menambahkan',
                                            'Import' => 'mengimport data dari Excel untuk',
                                            'Edit' => 'mengubah stok',
                                            'Hapus' => 'menghapus',
                                            default => 'memperbarui',
                                        };
                                    @endphp
                                    <div class="activity-item">
                                        <div class="activity-dot {{ $dotClass }}">
                                            <div class="activity-dot-inner"></div>
                                        </div>
                                        <div class="activity-row">
                                            <div>
                                                <div class="activity-desc">
                                                    <strong>{{ $act->user->name ?? 'Pengguna' }}</strong>
                                                    {{ $verb }}
                                                    <strong
                                                        style="color:var(--text-dark);">{{ $act->material->name ?? ($act->material_name ?? 'Material') }}</strong>
                                                    @if (!empty($act->description))
                                                        <div
                                                            style="color:var(--text-muted);font-size:11.5px;margin-top:2px;">
                                                            {{ $act->description }}</div>
                                                    @endif
                                                </div>
                                                <div class="activity-time" style="margin-top:3px;">
                                                    {{ $act->created_at->diffForHumans() }}</div>
                                            </div>
                                            <span
                                                class="activity-badge {{ $badgeClass }}">{{ $act->activity }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <span class="material-symbols-outlined">schedule</span>
                                Belum ada aktivitas tercatat.
                            </div>
                        @endif
                    </div>

                </div>

            </div>
            <!-- /page-content -->

        </main>
        <!-- /main -->

    </div>
    <!-- /layout -->

    <!-- ============================================================
         JAVASCRIPT
    ============================================================ -->
    <script>
        // --- Sidebar Drawer (Mobile) ---
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('drawerBackdrop').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('drawerBackdrop').classList.remove('open');
            document.body.style.overflow = '';
        }

        // --- Submenu toggle ---
        function toggleSubmenu(e, id) {
            e.preventDefault();
            const menu = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id.replace('submenu-', ''));
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            if (arrow) arrow.textContent = isOpen ? 'expand_more' : 'expand_less';
        }

        // Tutup sidebar saat layar diperbesar ke desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>

</body>

</html>
