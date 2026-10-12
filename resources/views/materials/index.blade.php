<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Data Material - Sistem Informasi Inventori Material PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Material Symbols (Icons) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">

    <style id="page-style">
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
            --green-light: #ECFDF5;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            --transition: 0.2s ease;
        }

        
html,
body {
    height: 100%;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: var(--bg);
    color: var(--text-dark);
    overflow-x: hidden;
}

/* Scrollbar */
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

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

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

        
.page-content {
    flex: 1;
    width: 100%;
    max-width: none;
    padding: 24px 28px 100px;
    box-sizing: border-box;
}


        /* ALERTS */
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: var(--red-light);
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            opacity: 0.7;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* HEADER CARD */
        .header-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-card-title h2 {
            font-size: 18px;
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

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            white-space: nowrap;
            text-decoration: none;
            line-height: 1.4;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn .material-symbols-outlined {
            font-size: 19px !important;
            color: inherit !important;
            line-height: 1 !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 87, 184, 0.25);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            box-shadow: 0 4px 10px rgba(0, 87, 184, 0.35);
        }

        .btn-yellow {
            background: var(--yellow);
            color: var(--blue-dark);
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
        }

        .btn-yellow:hover {
            background: #E5AC00;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            color: var(--text-dark);
        }

        .btn-danger {
            background: var(--red);
            color: #fff;
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        .btn-icon-only {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text-mid);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-edit:hover {
            background: var(--blue-light);
            color: var(--blue);
            border-color: var(--blue);
        }

        .btn-delete:hover {
            background: var(--red-light);
            color: var(--red);
            border-color: var(--red);
        }

        /* ============================================================
           SEARCH & FILTER CARD
        ============================================================ */
        .search-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            padding: 16px 20px;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .search-card:hover {
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .search-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .search-input-group {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .search-input-wrapper .search-icon {
            position: absolute;
            left: 14px;
            font-size: 20px;
            color: #94A3B8;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .search-input-wrapper input {
            width: 100%;
            height: 42px;
            padding: 0 40px 0 44px;
            border-radius: 9px;
            border: 1.5px solid var(--border);
            font-size: 13.5px;
            color: var(--text-dark);
            background: #F8FAFC;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input-wrapper input:hover {
            background: #FFFFFF;
            border-color: #CBD5E1;
        }

        .search-input-wrapper input:focus {
            background: #FFFFFF;
            border-color: var(--blue);
            box-shadow: 0 0 0 3.5px rgba(0, 87, 184, 0.12);
        }

        .search-input-wrapper:focus-within .search-icon {
            color: var(--blue);
        }

        .btn-clear-search {
            position: absolute;
            right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border: none;
            background: #E2E8F0;
            color: #64748B;
            border-radius: 50%;
            cursor: pointer;
            padding: 0;
            transition: all 0.2s ease;
        }

        .btn-clear-search:hover {
            background: #CBD5E1;
            color: var(--text-dark);
        }

        .btn-clear-search .material-symbols-outlined {
            font-size: 16px;
        }

        .search-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-search {
            height: 42px;
            padding: 0 18px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--blue);
            color: #FFFFFF;
            border: 1.5px solid var(--blue);
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 87, 184, 0.18);
            transition: all 0.2s ease;
        }

        .btn-search:hover {
            background: var(--blue-dark);
            border-color: var(--blue-dark);
            box-shadow: 0 4px 8px rgba(0, 59, 115, 0.25);
            transform: translateY(-1px);
        }

        .btn-search:active {
            transform: translateY(0);
        }

        .btn-search .material-symbols-outlined {
            font-size: 19px;
        }

        .btn-reset {
            height: 42px;
            padding: 0 16px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F1F5F9;
            color: #475569;
            border: 1.5px solid #E2E8F0;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background: #E2E8F0;
            color: var(--text-dark);
            border-color: #CBD5E1;
        }

        .btn-reset .material-symbols-outlined {
            font-size: 18px;
            color: #64748B;
        }

        /* Filter Pengurutan (Sort Dropdown) */
        .sort-select-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .sort-select-wrapper .sort-icon {
            position: absolute;
            left: 12px;
            font-size: 19px;
            color: #64748B;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .sort-select-wrapper select {
            height: 42px;
            padding: 0 34px 0 38px;
            border-radius: 9px;
            border: 1.5px solid var(--border);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            background-color: #F8FAFC;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2364748b'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 18px;
            transition: all 0.2s ease;
        }

        .sort-select-wrapper select:hover {
            background-color: #FFFFFF;
            border-color: #CBD5E1;
        }

        .sort-select-wrapper select:focus {
            background-color: #FFFFFF;
            border-color: var(--blue);
            box-shadow: 0 0 0 3.5px rgba(0, 87, 184, 0.12);
        }

        .sort-select-wrapper:focus-within .sort-icon {
            color: var(--blue);
        }

        /* Search Status Bar & Badge */
        .search-status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            padding-top: 2px;
        }

        .search-result-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            background: rgba(0, 87, 184, 0.08);
            border: 1px solid rgba(0, 87, 184, 0.18);
            border-radius: 20px;
            color: var(--blue-dark);
            font-size: 12.5px;
        }

        .search-result-pill strong {
            color: var(--blue);
            font-weight: 700;
        }

        .search-result-pill .result-count {
            color: #64748B;
            font-size: 12px;
        }

        .search-result-pill .pill-icon {
            font-size: 16px;
            color: var(--blue);
        }

        .search-result-pill .pill-remove {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(0, 87, 184, 0.15);
            color: var(--blue-dark);
            text-decoration: none;
            margin-left: 2px;
            transition: all 0.15s ease;
        }

        .search-result-pill .pill-remove:hover {
            background: var(--red);
            color: #FFFFFF;
        }

        .search-result-pill .pill-remove .material-symbols-outlined {
            font-size: 13px;
        }

        .search-meta-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748B;
            font-size: 12.5px;
            font-weight: 500;
        }

        .search-meta-info .material-symbols-outlined {
            font-size: 17px;
            color: #94A3B8;
        }

        .search-meta-info strong {
            color: var(--text-dark);
        }

        @media (max-width: 768px) {
            .search-input-group {
                flex-direction: column;
                align-items: stretch;
            }
            .sort-select-wrapper,
            .sort-select-wrapper select {
                width: 100%;
            }
            .search-buttons {
                width: 100%;
            }
            .btn-search, .btn-reset {
                flex: 1;
                justify-content: center;
            }
        }

        /* BULK TOOLBAR */
        .bulk-toolbar {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            background: var(--blue-dark);
            border-radius: var(--radius);
            margin-bottom: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.18);
            animation: bulkToolbarIn 0.18s ease-out;
        }

        .bulk-toolbar.visible {
            display: flex;
        }

        @keyframes bulkToolbarIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .bulk-count-badge {
            background: var(--yellow);
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .bulk-toolbar-label {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            flex: 1;
        }

        .btn-bulk-delete {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-bulk-delete:hover {
            background: #B91C1C;
        }

        .btn-bulk-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-bulk-cancel:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        /* TABLE */
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

        .data-table thead tr {
            background: #F8FAFC;
            border-bottom: 2px solid var(--border);
        }

        .data-table th {
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--blue-dark);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text-dark);
        }

        .data-table tbody tr:hover {
            background: #F8FAFC;
        }

        .data-table tbody tr.row-selected {
            background: #EFF6FF !important;
        }

        .badge-material-number {
            display: inline-block;
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            background: #EFF6FF;
            color: var(--blue-dark);
            border: 1px solid #DBEAFE;
            letter-spacing: 0.02em;
        }

        .cb-cell {
            width: 44px;
            text-align: center;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* TABLE FOOTER */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #fff;
            border-top: 1px solid var(--border);
            gap: 16px;
            flex-wrap: wrap;
        }

        .table-footer-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .data-info {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .per-page-select {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .per-page-select select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-dark);
            background: #fff;
            cursor: pointer;
        }

        .pagination-simple {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-page {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .btn-page:hover:not(.disabled) {
            background: var(--blue-light);
            color: var(--blue);
            border-color: var(--blue);
        }

        .btn-page.disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state > .material-symbols-outlined,
        .empty-state-icon {
            font-size: 52px !important;
            color: #94A3B8 !important;
            margin-bottom: 14px;
            display: inline-block;
        }

        .empty-state h3 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 22px;
        }

        .empty-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* DELETE MODAL */
        .delete-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 20px;
        }

        .delete-modal.show {
            display: flex;
        }

        .delete-modal-box {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            animation: modalIn 0.2s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .delete-modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--red-light);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .delete-modal-icon .material-symbols-outlined {
            font-size: 30px;
        }

        .delete-modal-box h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .delete-modal-box p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .delete-modal-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .delete-modal-cancel {
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            cursor: pointer;
        }

        .delete-modal-confirm {
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            background: var(--red);
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
        }

        .delete-modal-confirm:hover {
            background: #B91C1C;
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
                padding: 16px;
            }

            .header-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="layout">

        <!-- SIDEBAR -->
        @include('partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="main">

            <!-- Topbar Header -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:14px;">
                    <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="topbar-left">
                        <h1>Data Material</h1>
                        <p>Pendaftaran dan pengelolaan data master material PT PLN Indonesia Power UBP Asam Asam</p>
                    </div>
                </div>

                <a href="{{ route('profile.show') }}" class="topbar-user" title="Buka Profil Pengguna">
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

            <div class="page-content">

                <!-- Notifikasi Flash Message -->
                @if (session('success'))
                    <div class="alert alert-success" id="alertSuccess">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertSuccess').remove()">
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
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertError').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error" id="alertValidationErrors">
                        <div style="display:flex;align-items:flex-start;gap:8px;">
                            <span class="material-symbols-outlined" style="font-size:20px;margin-top:2px;">error</span>
                            <div>
                                <strong>Gagal memproses data:</strong>
                                <ul style="margin:4px 0 0 16px;padding:0;font-size:13px;">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="alert-close"
                            onclick="document.getElementById('alertValidationErrors').remove()">
                            <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                        </button>
                    </div>
                @endif

                <!-- Header Card dengan Tombol Aksi Utama -->
                <div class="header-card">
                    <div class="header-card-title">
                        <h2>Data Master Material</h2>
                        <p>Kelola identitas material (No. Material, Nama Material, dan Satuan)</p>
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('materials.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size:19px;">add</span>
                            Tambah Material
                        </a>

                        <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                            <span class="material-symbols-outlined" style="font-size:19px;">upload_file</span>
                            Import Excel
                        </a>

                        <a href="{{ route('materials.export', array_merge(request()->query(), ['per_page' => $perPage, 'sort' => $sort])) }}" class="btn btn-outline" title="Export Excel sesuai filter dan urutan yang tampil">
                            <span class="material-symbols-outlined">download</span>
                            <span>Export Excel</span>
                        </a>
                    </div>
                </div>

                <!-- Search & Filter Card -->
                <div class="search-card">
                    <form method="GET" action="{{ route('materials.index') }}" class="search-form" id="searchForm">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">

                        <!-- Input Pencarian, Filter Pengurutan, & Tombol Aksi -->
                        <div class="search-input-group">
                            <div class="search-input-wrapper">
                                <span class="material-symbols-outlined search-icon">search</span>
                                <input type="text"
                                       name="search"
                                       id="searchInput"
                                       value="{{ $search }}"
                                       placeholder="Cari No. Material atau Nama Material..."
                                       autocomplete="off"
                                       spellcheck="false">
                                @if (!empty($search))
                                    <button type="button" class="btn-clear-search" id="btnClearSearch" title="Hapus teks pencarian">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                @endif
                            </div>

                            <!-- Filter Pengurutan -->
                            <div class="sort-select-wrapper">
                                <span class="material-symbols-outlined sort-icon">swap_vert</span>
                                <select name="sort" id="sortSelect" onchange="document.getElementById('searchForm').submit()" title="Urutkan data material">
                                    <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Terbaru (Paling Atas)</option>
                                    <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>Nama Material (A - Z)</option>
                                    <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Nama Material (Z - A)</option>
                                    <option value="number_asc" {{ ($sort ?? '') === 'number_asc' ? 'selected' : '' }}>No. Material (A - Z)</option>
                                    <option value="number_desc" {{ ($sort ?? '') === 'number_desc' ? 'selected' : '' }}>No. Material (Z - A)</option>
                                </select>
                            </div>

                            <div class="search-buttons">
                                <button type="submit" class="btn btn-search">
                                    <span class="material-symbols-outlined">search</span>
                                    <span>Cari</span>
                                </button>

                                @if (!empty($search) || ($sort ?? 'latest') !== 'latest')
                                    <a href="{{ route('materials.index', ['per_page' => $perPage]) }}" class="btn btn-reset" title="Kembalikan semua data & reset pengurutan">
                                        <span class="material-symbols-outlined">restart_alt</span>
                                        <span>Reset</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Bar Status & Ringkasan Pencarian -->
                        <div class="search-status-bar">
                            @if (!empty($search))
                                <div class="search-result-pill">
                                    <span class="material-symbols-outlined pill-icon">filter_alt</span>
                                    <span>Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong></span>
                                    <span class="result-count">({{ $materials->total() }} material ditemukan)</span>
                                    <a href="{{ route('materials.index', array_merge(['per_page' => $perPage], ($sort !== 'latest' ? ['sort' => $sort] : []))) }}" class="pill-remove" title="Hapus filter pencarian">
                                        <span class="material-symbols-outlined">close</span>
                                    </a>
                                </div>
                            @else
                                <div class="search-meta-info">
                                    <span class="material-symbols-outlined">inventory_2</span>
                                    <span>Total <strong>{{ $materials->total() }}</strong> Master Material terdaftar</span>
                                    @if (($sort ?? 'latest') !== 'latest')
                                        <span style="color:var(--text-muted);font-size:12px;">• Urutan: 
                                            @if ($sort === 'oldest') Terlama
                                            @elseif ($sort === 'name_asc') Nama (A - Z)
                                            @elseif ($sort === 'name_desc') Nama (Z - A)
                                            @elseif ($sort === 'number_asc') No. Material (A - Z)
                                            @elseif ($sort === 'number_desc') No. Material (Z - A)
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Bulk Action Toolbar -->
                <div class="bulk-toolbar" id="bulkToolbar">
                    <span class="bulk-count-badge" id="bulkCountBadge">0</span>
                    <span class="bulk-toolbar-label">material dipilih</span>
                    <button type="button" class="btn-bulk-cancel" id="bulkCancelBtn">
                        Batal
                    </button>
                    <button type="button" class="btn-bulk-delete" id="bulkDeleteBtn">
                        <span class="material-symbols-outlined">delete_sweep</span>
                        Hapus Terpilih
                    </button>
                </div>

                <!-- Data Table Card (Hanya 4 Kolom: No. Material, Nama Material, Satuan, dan Aksi) -->
                <div class="table-card">
                    @if ($materials->count() > 0)
                        <div class="table-responsive">
                            <table class="data-table" id="materialsTable">
                                <thead>
                                    <tr>
                                        <th class="cb-cell">
                                            <input type="checkbox" class="check-all" id="checkAll" title="Pilih Semua">
                                        </th>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 160px;">No. Material</th>
                                        <th>Nama Material</th>
                                        <th style="width: 140px;">Satuan</th>
                                        <th style="width: 130px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $startNumber = ($materials->currentPage() - 1) * $materials->perPage();
                                    @endphp
                                    @foreach ($materials as $index => $mat)
                                        <tr data-id="{{ $mat->id }}">
                                            <td class="cb-cell">
                                                <input type="checkbox" class="row-checkbox"
                                                        value="{{ $mat->id }}"
                                                        aria-label="Pilih {{ $mat->name }}">
                                            </td>
                                            <td>{{ $startNumber + $loop->iteration }}</td>
                                            <td>
                                                <span class="badge-material-number">{{ $mat->material_number }}</span>
                                            </td>
                                            <td style="font-weight: 600;">
                                                {{ $mat->name }}
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: var(--text-mid);">{{ $mat->unit }}</span>
                                            </td>
                                            <td>
                                                <div class="actions-cell">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('materials.edit', $mat->id) }}"
                                                        class="btn-icon-only btn-edit" title="Edit Material">
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <button type="button"
                                                            class="btn-icon-only btn-delete btn-open-delete-modal"
                                                            title="Hapus Material"
                                                            data-action="{{ route('materials.destroy', $mat->id) }}"
                                                            data-name="{{ addslashes($mat->name) }}"
                                                            data-number="{{ $mat->material_number }}"
                                                            data-has-relations="{{ $mat->stockMovements()->exists() ? '1' : '0' }}">
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel: Informasi Data, Dropdown Per Page, & Navigasi Simple -->
                        <div class="table-footer">
                            <div class="table-footer-left">
                                <div class="data-info">
                                    @if ($perPage === 'all' || $perPage === 'Semua')
                                        Menampilkan <strong>1–{{ $materials->total() }}</strong> dari
                                        <strong>{{ $materials->total() }}</strong> material
                                    @else
                                        Menampilkan
                                        <strong>{{ $materials->firstItem() ?? 0 }}–{{ $materials->lastItem() ?? 0 }}</strong>
                                        dari <strong>{{ $materials->total() }}</strong> material
                                    @endif
                                </div>

                                <div class="per-page-select">
                                    <label for="per_page_select">Tampilkan:</label>
                                    <select id="per_page_select" onchange="changePerPage(this.value)">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data per halaman</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 data per halaman</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data per halaman</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data per halaman</option>
                                        <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250 data per halaman</option>
                                        <option value="all" {{ $perPage === 'all' || $perPage === 'Semua' ? 'selected' : '' }}>Semua data</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Navigasi Halaman Simpel -->
                            <div class="pagination-simple">
                                @if ($materials->onFirstPage())
                                    <span class="btn-page disabled">
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $materials->previousPageUrl() }}" class="btn-page">
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                                        Sebelumnya
                                    </a>
                                @endif

                                @if ($materials->hasMorePages())
                                    <a href="{{ $materials->nextPageUrl() }}" class="btn-page">
                                        Berikutnya
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </a>
                                @else
                                    <span class="btn-page disabled">
                                        Berikutnya
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Empty State Jika Tidak Ada Material -->
                        <div class="empty-state">
                            <span class="material-symbols-outlined empty-state-icon">inventory_2</span>
                            <h3>Belum ada data material</h3>
                            <p>Silakan daftarkan material baru atau import data master melalui file Excel.</p>
                            <div class="empty-actions">
                                <a href="{{ route('materials.create') }}" class="btn btn-primary">
                                    <span class="material-symbols-outlined">add</span>
                                    <span>Tambah Material</span>
                                </a>
                                <a href="{{ route('materials.import') }}" class="btn btn-yellow">
                                    <span class="material-symbols-outlined">upload_file</span>
                                    <span>Import Excel</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- POPUP KONFIRMASI HAPUS SATUAN -->
            <div id="deleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon">
                        <span class="material-symbols-outlined">delete</span>
                    </div>
                    <h3 id="deleteModalTitle">Hapus Data Material?</h3>
                    <p id="deleteModalMessage">
                        Apakah Anda yakin ingin menghapus data material ini?<br>
                        <span style="color:var(--text-muted);font-size:12.5px;margin-top:6px;display:block;">Data yang telah dihapus tidak dapat dikembalikan.</span>
                    </p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="deleteModalCancel">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="deleteModalConfirm">Ya, Hapus</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk submit hapus satu -->
            <form id="deleteHiddenForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- POPUP KONFIRMASI HAPUS MASSAL & HAPUS SEMUA DATA -->
            <div id="bulkDeleteModal" class="delete-modal">
                <div class="delete-modal-box">
                    <div class="delete-modal-icon">
                        <span class="material-symbols-outlined">delete_sweep</span>
                    </div>
                    <h3 id="bulkDeleteModalTitle">Hapus Material Terpilih?</h3>
                    <p id="bulkDeleteModalMessage">
                        Apakah Anda yakin ingin menghapus material yang dipilih?<br>
                        <span style="color:var(--text-muted);font-size:12.5px;margin-top:6px;display:block;">Data yang telah dihapus tidak dapat dikembalikan.</span>
                    </p>
                    <div class="delete-modal-actions">
                        <button type="button" class="delete-modal-cancel" id="bulkModalCancelBtn">Batal</button>
                        <button type="button" class="delete-modal-confirm" id="bulkModalConfirmBtn">Ya, Hapus</button>
                    </div>
                </div>
            </div>

            <!-- Form tersembunyi untuk bulk delete & hapus semua -->
            <form id="bulkDeleteHiddenForm" method="POST"
                  action="{{ route('materials.bulk-destroy') }}"
                  style="display:none;">
                @csrf
                <input type="hidden" name="all" id="bulkDeleteAllInput" value="0">
            </form>

            <script>
            (function () {
                // ======================================================
                // 1. HAPUS SATU (Single Delete)
                // ======================================================
                const modal      = document.getElementById('deleteModal');
                const cancelBtn  = document.getElementById('deleteModalCancel');
                const confirmBtn = document.getElementById('deleteModalConfirm');
                const msgEl      = document.getElementById('deleteModalMessage');
                const titleEl    = document.getElementById('deleteModalTitle');
                const hiddenForm = document.getElementById('deleteHiddenForm');

                let pendingAction = null;

                if (modal && cancelBtn && confirmBtn && hiddenForm) {
                    document.addEventListener('click', function (e) {
                        const btn = e.target.closest('.btn-open-delete-modal');
                        if (!btn) return;
                        e.preventDefault();

                        pendingAction = btn.dataset.action;
                        const name   = btn.dataset.name || '';
                        const number = btn.dataset.number || '';

                        titleEl.textContent = 'Hapus Data Material?';
                        msgEl.innerHTML = `Apakah Anda yakin ingin menghapus data material <strong>"${name}"</strong> (${number})?<br><span style="color:var(--text-muted);font-size:12.5px;margin-top:6px;display:block;">Data yang telah dihapus tidak dapat dikembalikan.</span>`;
                        confirmBtn.textContent = 'Ya, Hapus';

                        modal.classList.add('show');
                    });

                    cancelBtn.addEventListener('click', function () {
                        modal.classList.remove('show');
                        pendingAction = null;
                    });

                    confirmBtn.addEventListener('click', function () {
                        if (!pendingAction) return;
                        const action = pendingAction;
                        modal.classList.remove('show');
                        pendingAction = null;

                        confirmBtn.disabled    = true;
                        confirmBtn.textContent = 'Memproses...';

                        hiddenForm.action = action;
                        hiddenForm.submit();
                    });

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) {
                            modal.classList.remove('show');
                            pendingAction = null;
                        }
                    });

                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape' && modal.classList.contains('show')) {
                            modal.classList.remove('show');
                            pendingAction = null;
                        }
                    });
                }

                // ======================================================
                // 2. HAPUS MASSAL & HAPUS SEMUA DATA (Bulk & All Delete)
                // ======================================================
                const bulkModal        = document.getElementById('bulkDeleteModal');
                const bulkModalTitle   = document.getElementById('bulkDeleteModalTitle');
                const bulkCancelBtn    = document.getElementById('bulkModalCancelBtn');
                const bulkConfirmBtn   = document.getElementById('bulkModalConfirmBtn');
                const bulkMsgEl        = document.getElementById('bulkDeleteModalMessage');
                const bulkForm         = document.getElementById('bulkDeleteHiddenForm');
                const bulkAllInput     = document.getElementById('bulkDeleteAllInput');
                const bulkToolbar      = document.getElementById('bulkToolbar');
                const bulkCountBadge   = document.getElementById('bulkCountBadge');
                const bulkDeleteBtn    = document.getElementById('bulkDeleteBtn');
                const bulkCancelBtn2   = document.getElementById('bulkCancelBtn');
                const checkAll         = document.getElementById('checkAll');

                function getChecked() {
                    return Array.from(document.querySelectorAll('.row-checkbox:checked'));
                }

                function updateToolbar() {
                    const checked  = getChecked();
                    const count    = checked.length;
                    const allBoxes = document.querySelectorAll('.row-checkbox');

                    if (bulkToolbar) {
                        if (count > 0) {
                            bulkCountBadge.textContent = count;
                            const toolbarLabel = bulkToolbar.querySelector('.bulk-toolbar-label');
                            if (toolbarLabel) {
                                toolbarLabel.textContent = (allBoxes.length > 1 && count === allBoxes.length)
                                    ? 'seluruh material terpilih'
                                    : 'material dipilih';
                            }
                            bulkToolbar.classList.add('visible');
                        } else {
                            bulkToolbar.classList.remove('visible');
                        }
                    }

                    if (checkAll && allBoxes.length > 0) {
                        checkAll.indeterminate = count > 0 && count < allBoxes.length;
                        checkAll.checked       = count > 0 && count === allBoxes.length;
                    }

                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        const row = cb.closest('tr');
                        if (row) row.classList.toggle('row-selected', cb.checked);
                    });
                }

                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => {
                            cb.checked = checkAll.checked;
                        });
                        updateToolbar();
                    });
                }

                document.addEventListener('change', function (e) {
                    if (e.target.classList.contains('row-checkbox')) {
                        updateToolbar();
                    }
                });

                if (bulkCancelBtn2) {
                    bulkCancelBtn2.addEventListener('click', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
                        if (checkAll) { checkAll.checked = false; checkAll.indeterminate = false; }
                        updateToolbar();
                    });
                }

                // Klik "Hapus Terpilih" dari toolbar pilihan checkbox
                if (bulkDeleteBtn) {
                    bulkDeleteBtn.addEventListener('click', function () {
                        const count    = getChecked().length;
                        const allBoxes = document.querySelectorAll('.row-checkbox');
                        if (count === 0) return;

                        if (bulkAllInput) bulkAllInput.value = '0';

                        if (allBoxes.length > 1 && count === allBoxes.length) {
                            if (bulkModalTitle) bulkModalTitle.textContent = 'Hapus Semua Material Terpilih?';
                            bulkMsgEl.innerHTML = `Apakah Anda yakin ingin menghapus <strong>seluruh material terpilih (${count} material)</strong>?<br><span style="color:var(--text-muted);font-size:12.5px;margin-top:6px;display:block;">Data yang telah dihapus tidak dapat dikembalikan.</span>`;
                            bulkConfirmBtn.textContent = `Ya, Hapus Semua (${count})`;
                        } else {
                            if (bulkModalTitle) bulkModalTitle.textContent = 'Hapus Material Terpilih?';
                            bulkMsgEl.innerHTML = `Apakah Anda yakin ingin menghapus <strong>${count} material terpilih</strong>?<br><span style="color:var(--text-muted);font-size:12.5px;margin-top:6px;display:block;">Data yang telah dihapus tidak dapat dikembalikan.</span>`;
                            bulkConfirmBtn.textContent = `Ya, Hapus (${count})`;
                        }

                        bulkModal.classList.add('show');
                    });
                }

                if (bulkCancelBtn) {
                    bulkCancelBtn.addEventListener('click', function () {
                        bulkModal.classList.remove('show');
                    });
                }

                if (bulkConfirmBtn && bulkForm) {
                    bulkConfirmBtn.addEventListener('click', function () {
                        bulkModal.classList.remove('show');
                        bulkConfirmBtn.disabled    = true;
                        bulkConfirmBtn.textContent = 'Memproses...';

                        // Bersihkan input ids[] lama dari bulkForm
                        bulkForm.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

                        if (bulkAllInput) bulkAllInput.value = '0';
                        const checkedBoxes = getChecked();
                        if (checkedBoxes.length === 0) {
                            bulkConfirmBtn.disabled = false;
                            return;
                        }
                        checkedBoxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type  = 'hidden';
                            input.name  = 'ids[]';
                            input.value = cb.value;
                            bulkForm.appendChild(input);
                        });

                        bulkForm.submit();
                    });
                }

                if (bulkModal) {
                    bulkModal.addEventListener('click', function (e) {
                        if (e.target === bulkModal) bulkModal.classList.remove('show');
                    });
                }

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && bulkModal && bulkModal.classList.contains('show')) {
                        bulkModal.classList.remove('show');
                    }
                });

                // Clear button untuk input pencarian
                const btnClearSearch = document.getElementById('btnClearSearch');
                const searchInput    = document.getElementById('searchInput');
                if (btnClearSearch && searchInput) {
                    btnClearSearch.addEventListener('click', function () {
                        searchInput.value = '';
                        searchInput.focus();
                        const searchForm = document.getElementById('searchForm');
                        if (searchForm) searchForm.submit();
                    });
                }

            })();

            function changePerPage(val) {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', val);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }

            function openSidebar() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.add('open');
            }
            </script>

        </main>
    </div>

</body>

</html>
