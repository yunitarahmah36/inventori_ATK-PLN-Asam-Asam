<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Manajemen User - Sistem Inventori Material PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style id="page-style">
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #B46A72;
            --blue-dark: #3D2227;
            --blue-light: #FDF2F4;
            --yellow: #F7C8D3;
            --yellow-light: #FFF5F7;
            --bg: #FCF9FA;
            --white: #FFFFFF;
            --text-dark: #3D2227;
            --text-mid: #4D2C32;
            --text-muted: #7E5B62;
            --border: #F2E0E4;
            --red: #DC2626;
            --red-light: #FEE2E2;
            --green: #059669;
            --green-light: #ECFDF5;
            --amber: #D97706;
            --amber-light: #FEF3C7;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(180, 106, 114, 0.06);
            --transition: 0.2s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .layout, .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .main, .content-area {
            flex: 1;
            margin-left: var(--sidebar-w);
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            transition: margin-left var(--transition);
        }

        /* Top Header */
        .top-header {
            height: var(--header-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .header-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-dark);
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .page-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            border-radius: 30px;
            background: var(--blue-light);
            border: 1px solid rgba(180, 106, 114, 0.15);
        }

        .badge-role {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-admin { background: #3D2227; color: #FFF; }
        .badge-keuangan { background: #059669; color: #FFF; }
        .badge-umum { background: #6366F1; color: #FFF; }
        .badge-buku { background: #D97706; color: #FFF; }

        /* Main Body Content */
        .page-content {
            padding: 24px;
            flex: 1;
        }

        /* Alert Notification */
        .alert-box {
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow);
            transition: transform var(--transition), box-shadow var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(180, 106, 114, 0.12);
        }

        .stat-icon-wrap {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-info .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .stat-info .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Card Container */
        .data-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header-bar {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            position: relative;
            min-width: 240px;
        }

        .search-box input {
            width: 100%;
            height: 38px;
            padding: 0 14px 0 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            background: var(--bg);
            outline: none;
            transition: border-color var(--transition);
        }

        .search-box input:focus {
            border-color: var(--blue);
            background: var(--white);
        }

        .search-box .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }

        .filter-select {
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            background: var(--bg);
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--blue);
            background: var(--white);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue);
            color: var(--white);
            border: none;
            border-radius: 8px;
            height: 38px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        /* Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .table-custom th {
            background: #FDF7F8;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table-custom td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            vertical-align: middle;
        }

        .table-custom tr:hover td {
            background: #FFF9FA;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-cell-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid rgba(180, 106, 114, 0.2);
        }

        .user-cell-meta .u-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-cell-meta .u-username {
            font-size: 12px;
            color: var(--text-muted);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-mid);
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-action:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
        }

        .btn-action-delete:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-light);
        }

        .action-btns {
            display: flex;
            gap: 6px;
        }

        /* Table Footer & Pagination (Seragam dengan Dashboard) */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #FCF9FA;
            flex-wrap: wrap;
            gap: 12px;
            box-sizing: border-box;
            width: 100%;
        }

        .table-footer-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .data-info {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .data-info strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .table-footer-pagination {
            display: flex;
            align-items: center;
        }

        .table-footer svg {
            display: none !important;
        }

        @media (max-width: 768px) {
            .table-footer {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                gap: 12px !important;
                padding: 14px 16px !important;
            }
            .table-footer-left {
                justify-content: center !important;
            }
            .table-footer-pagination {
                justify-content: center !important;
                width: 100% !important;
            }
        }

        /* Modal Styles */
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(61, 34, 39, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-card {
            background: var(--white);
            border-radius: var(--radius);
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            animation: modalFadeIn 0.2s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
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
        }

        .modal-body {
            padding: 20px 24px;
        }

        .modal-footer {
            padding: 14px 24px;
            background: #FDF9FA;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-secondary {
            background: #E5E7EB;
            color: var(--text-dark);
            border: none;
            border-radius: 8px;
            height: 38px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
            transition: border-color var(--transition);
        }

        .form-control:focus {
            border-color: var(--blue);
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        @media (max-width: 900px) {
            .content-area { margin-left: 0; }
            .sidebar-toggle-btn { display: flex; }
        }
    </style>
</head>
<body>
<div class="layout main-wrapper">
    <!-- Include Sidebar -->
    @include('partials.sidebar')

    <!-- Content Area -->
    <main class="main content-area">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title-wrap">
                <button type="button" class="sidebar-toggle-btn" onclick="openSidebar()" aria-label="Buka Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="page-title">Manajemen User &amp; Role Akses</h1>
            </div>
            <div class="header-user-badge">
                <span class="material-symbols-outlined" style="font-size:18px; color:var(--blue)">admin_panel_settings</span>
                <span style="font-size:13px; font-weight:600;">{{ Auth::user()->name }}</span>
                <span class="badge-role badge-admin">{{ Auth::user()->role }}</span>
            </div>
        </header>

        <!-- Main Page Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert-box alert-success">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-error">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box alert-error">
                    <span class="material-symbols-outlined">warning</span>
                    <div>
                        <strong>Terjadi kesalahan input:</strong>
                        <ul style="margin-left: 20px; margin-top: 4px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#FDF2F4; color:#B46A72;">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Pengguna</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#F3F4F6; color:#3D2227;">
                        <span class="material-symbols-outlined">shield_person</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['admin'] }}</div>
                        <div class="stat-label">Administrator</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#ECFDF5; color:#059669;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['keuangan'] }}</div>
                        <div class="stat-label">Role Keuangan</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#EEF2FF; color:#6366F1;">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['umum'] }}</div>
                        <div class="stat-label">Role Umum</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:#FEF3C7; color:#D97706;">
                        <span class="material-symbols-outlined">local_library</span>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['pengelola_buku'] }}</div>
                        <div class="stat-label">Pengelola Buku</div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="data-card">
                <div class="card-header-bar">
                    <div class="card-title">
                        <span class="material-symbols-outlined" style="color:var(--blue);">manage_accounts</span>
                        <span>Daftar Akun Pengguna</span>
                    </div>

                    <div class="filter-controls">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('users.index') }}" style="display:flex; gap:8px;">
                            <div class="search-box">
                                <span class="material-symbols-outlined search-icon">search</span>
                                <input type="text" name="search" id="userSearchInput" placeholder="Cari nama, username, email..." value="{{ $search ?? '' }}" autocomplete="off">
                            </div>

                            <select name="role" class="filter-select">
                                <option value="">Semua Role</option>
                                <option value="Admin" {{ ($roleFilter ?? '') === 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Keuangan" {{ ($roleFilter ?? '') === 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                <option value="Umum" {{ ($roleFilter ?? '') === 'Umum' ? 'selected' : '' }}>Umum</option>
                                <option value="Pengelola Buku" {{ ($roleFilter ?? '') === 'Pengelola Buku' ? 'selected' : '' }}>Pengelola Buku</option>
                            </select>

                            @if($search || $roleFilter)
                                <a href="{{ route('users.index') }}" class="btn-secondary" style="display:inline-flex; align-items:center; height:38px; padding:0 12px; text-decoration:none;">Reset</a>
                            @endif
                        </form>

                        <button type="button" class="btn-primary" onclick="openCreateUserModal()">
                            <span class="material-symbols-outlined" style="font-size:18px;">person_add</span>
                            <span>Tambah Pengguna</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Pengguna</th>
                                <th>Email</th>
                                <th>Role Akses</th>
                                <th>Terdaftar Sejak</th>
                                <th style="text-align: right; width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-cell-avatar">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div class="user-cell-meta">
                                                <div class="u-name">{{ $u->name }}</div>
                                                <div class="u-username">{{ '@' . $u->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        @if($u->role === 'Admin')
                                            <span class="badge-role badge-admin">Admin</span>
                                        @elseif($u->role === 'Keuangan')
                                            <span class="badge-role badge-keuangan">Keuangan</span>
                                        @elseif($u->role === 'Umum')
                                            <span class="badge-role badge-umum">Umum</span>
                                        @elseif($u->role === 'Pengelola Buku')
                                            <span class="badge-role badge-buku">Pengelola Buku</span>
                                        @else
                                            <span class="badge-role" style="background:#9CA3AF; color:#fff;">{{ $u->role }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}</td>
                                    <td>
                                        <div class="action-btns" style="justify-content: flex-end;">
                                            <button type="button" class="btn-action" title="Edit Pengguna"
                                                    onclick="openEditUserModal({{ json_encode($u) }})">
                                                <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                            </button>

                                            @if($u->id !== Auth::id())
                                                <button type="button" class="btn-action btn-action-delete" title="Hapus Pengguna"
                                                        onclick="openDeleteUserModal({{ $u->id }}, '{{ addslashes($u->name) }}')">
                                                    <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 36px; color: var(--text-muted);">
                                        <span class="material-symbols-outlined" style="font-size: 40px; margin-bottom: 8px; color: #CBD5E1;">person_off</span>
                                        <p>Tidak ada pengguna yang cocok dengan kriteria pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="table-footer-left">
                        <div class="data-info">
                            @if($users->total() > 0)
                                Menampilkan <strong>{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
                            @else
                                Menampilkan <strong>0</strong> pengguna
                            @endif
                        </div>
                    </div>
                    <div class="table-footer-pagination">
                        {{ $users->onEachSide(1)->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal Tambah Pengguna -->
<div id="createUserModal" class="modal-backdrop">
    <div class="modal-card">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">person_add</span>
                    Tambah Pengguna Baru
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeCreateUserModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="create_name">Nama Lengkap *</label>
                    <input type="text" id="create_name" name="name" class="form-control" required placeholder="Contoh: Rian Pratama">
                </div>

                <div class="form-group">
                    <label for="create_username">Username *</label>
                    <input type="text" id="create_username" name="username" class="form-control" required placeholder="Contoh: rian_buku">
                    <div class="form-hint">Hanya huruf, angka, tanda hubung, atau garis bawah.</div>
                </div>

                <div class="form-group">
                    <label for="create_email">Alamat Email *</label>
                    <input type="email" id="create_email" name="email" class="form-control" required placeholder="Contoh: rian@pln.co.id">
                </div>

                <div class="form-group">
                    <label for="create_password">Password *</label>
                    <input type="password" id="create_password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                </div>

                <div class="form-group">
                    <label for="create_role">Role / Hak Akses *</label>
                    <select id="create_role" name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Administrator (Akses Penuh)</option>
                        <option value="Pengelola Buku">Pengelola Buku (Kelola Peminjaman & Stok Buku)</option>
                        <option value="Keuangan">Keuangan (Material & Analisis)</option>
                        <option value="Umum">Umum (Material & Inventori)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCreateUserModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div id="editUserModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="editUserForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3>
                    <span class="material-symbols-outlined" style="color:var(--blue);">manage_accounts</span>
                    Edit Data Pengguna
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeEditUserModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_name">Nama Lengkap *</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_username">Username *</label>
                    <input type="text" id="edit_username" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_email">Alamat Email *</label>
                    <input type="email" id="edit_email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_password">Password Baru (Opsional)</label>
                    <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>

                <div class="form-group">
                    <label for="edit_role">Role / Hak Akses *</label>
                    <select id="edit_role" name="role" class="form-control" required>
                        <option value="Admin">Administrator (Akses Penuh)</option>
                        <option value="Pengelola Buku">Pengelola Buku (Kelola Peminjaman & Stok Buku)</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditUserModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pengguna -->
<div id="deleteUserModal" class="modal-backdrop">
    <div class="modal-card">
        <form id="deleteUserForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h3 style="color:var(--red);">
                    <span class="material-symbols-outlined" style="color:var(--red);">warning</span>
                    Konfirmasi Hapus Pengguna
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeDeleteUserModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun pengguna <strong id="deleteUserName"></strong> dari sistem?</p>
                <p style="font-size:12px; color:var(--text-muted); margin-top:8px;">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeDeleteUserModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background:var(--red);">Hapus Pengguna</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.add('show');
    }
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('show');
    }

    function openEditUserModal(user) {
        const form = document.getElementById('editUserForm');
        form.action = `/users/${user.id}`;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_username').value = user.username;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_password').value = '';
        document.getElementById('editUserModal').classList.add('show');
    }
    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.remove('show');
    }

    function openDeleteUserModal(id, name) {
        const form = document.getElementById('deleteUserForm');
        form.action = `/users/${id}`;
        document.getElementById('deleteUserName').textContent = `"${name}"`;
        document.getElementById('deleteUserModal').classList.add('show');
    }
    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.remove('show');
    }

    window.onclick = function(event) {
        ['createUserModal', 'editUserModal', 'deleteUserModal'].forEach(id => {
            const m = document.getElementById(id);
            if (event.target === m) m.classList.remove('show');
        });
    };
</script>
</main>
</div>
</body>
</html>
