<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Import Data Material - Sistem Informasi Inventori Material PT PLN Indonesia Power UBP Asam Asam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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
            --red-light: #FEF2F2;
            --green: #059669;
            --green-light: #ECFDF5;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(180, 106, 114, 0.06);
            --transition: 0.2s ease;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--text-dark);
            cursor: pointer;
            align-items: center;
            justify-content: center;
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
            padding: 28px;
            flex: 1;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .btn-back:hover {
            color: var(--blue);
            transform: translateX(-2px);
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 32px;
        }

        .upload-icon-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .upload-box {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 36px 20px;
            background: #FAFBFD;
            text-align: center;
            margin-bottom: 24px;
            transition: var(--transition);
        }

        .upload-box:hover {
            border-color: var(--blue);
            background: #F0F7FF;
        }

        .file-name {
            margin-top: 14px;
            font-size: 13px;
            color: var(--blue-dark);
            font-weight: 600;
            display: none;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        .btn:disabled,
        .btn[disabled] {
            opacity: 0.55;
            cursor: not-allowed !important;
            box-shadow: none !important;
        }

        .btn:disabled:hover,
        .btn[disabled]:hover {
            opacity: 0.55;
            cursor: not-allowed !important;
        }

        .upload-box.has-error {
            border-color: var(--red) !important;
            background: #FEF2F2 !important;
        }

        .upload-box.has-error:hover {
            border-color: var(--red) !important;
            background: #FEE2E2 !important;
        }

        .upload-box.has-file {
            border-color: var(--blue) !important;
            background: #F0F7FF !important;
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .btn-success {
            background: #198754;
            color: #fff;
        }

        .btn-success:hover {
            background: #157347;
        }

        .btn-danger {
            background: var(--red);
            color: #fff;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        /* STATS GRID */
        .preview-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon.green {
            background: var(--green-light);
            color: var(--green);
        }

        .stat-icon.yellow {
            background: var(--yellow-light);
            color: #D97706;
        }

        .stat-icon.red {
            background: var(--red-light);
            color: var(--red);
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 600;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-warning {
            background: #FFFBEB;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .alert-danger {
            background: var(--red-light);
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-info {
            background: var(--blue-light);
            color: var(--blue-dark);
            border: 1px solid #BFDBFE;
        }

        .preview-table-box {
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .preview-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .preview-table thead tr {
            background: #F8FAFC;
            border-bottom: 1px solid var(--border);
        }

        .preview-table th {
            padding: 12px 16px;
            font-weight: 700;
            color: var(--blue-dark);
            text-align: left;
            font-size: 12px;
        }

        .preview-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
        }

        .preview-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-num {
            display: inline-block;
            font-family: monospace;
            font-weight: 700;
            padding: 2px 6px;
            background: #EFF6FF;
            color: var(--blue-dark);
            border-radius: 4px;
        }

        /* ============================================================
           RESPONSIVE BREAKPOINTS (PC, LAPTOP, TABLET & HP)
        ============================================================ */

        @media (max-width: 992px) {
            .main {
                margin-left: 0 !important;
            }

            .btn-hamburger {
                display: flex;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-user-detail .topbar-user-email {
                display: none;
            }

            .page-content {
                padding: 16px;
            }
        }

        @media (max-width: 768px) {
            .topbar-left h1 {
                font-size: 17px;
            }

            .topbar-left p {
                display: none;
            }

            .topbar-user-detail {
                display: none;
            }

            .card {
                padding: 20px 16px;
            }

            .dropzone-area {
                padding: 24px 14px;
            }
        }

        @media (max-width: 480px) {
            .page-content {
                padding: 12px;
            }

            .card {
                padding: 16px 12px;
                border-radius: 10px;
            }

            .btn-back {
                font-size: 12.5px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:14px;">
                <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="topbar-left">
                    <h1>Import Data Material</h1>
                    <p>Mengimport data material ATK PT PLN Indonesia Power UBP Asam Asam melalui file Excel.</p>
                </div>
            </div>

            <div class="topbar-user">
                <div class="topbar-user-detail">
                    <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                    <div class="topbar-user-email">{{ Auth::user()->email }}</div>
                    <span class="badge-role">{{ Auth::user()->role }}</span>
                </div>
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="page-content">

            <a href="{{ route('materials.index') }}" class="btn-back">
                <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                Kembali ke Daftar Material
            </a>

            <!-- NOTIFIKASI UMUM -->
            @if(session('success'))
                <div class="alert alert-success" style="display:flex;align-items:center;gap:10px;">
                    <span class="material-symbols-outlined" style="font-size:20px;flex-shrink:0;">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info" style="display:flex;align-items:center;gap:10px;">
                    <span class="material-symbols-outlined" style="font-size:20px;flex-shrink:0;">info</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="display:flex;align-items:flex-start;gap:10px;">
                    <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;margin-top:1px;">error</span>
                    <div>
                        <div style="font-weight:700;font-size:14px;margin-bottom:2px;">Import Tidak Berhasil</div>
                        <div>{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="display:flex;align-items:flex-start;gap:10px;">
                    <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;margin-top:1px;">upload_file</span>
                    <div>
                        <div style="font-weight:700;font-size:14px;margin-bottom:4px;">File Tidak Dapat Diproses</div>
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($preview) && is_array($preview))
                {{-- ============================================================
                     BAGIAN 2: PRATINJAU HASIL ANALISIS EXCEL SEBELUM KONFIRMASI
                ============================================================ --}}
                <div class="card">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;border-bottom:1px solid var(--border);padding-bottom:16px;">
                        <span class="material-symbols-outlined" style="font-size:28px;color:var(--blue);">analytics</span>
                        <div>
                            <h2 style="font-size:18px;font-weight:800;color:var(--blue-dark);">Pratinjau Data Import Material</h2>
                            <p style="font-size:13px;color:var(--text-muted);">Periksa ringkasan data sebelum menyimpan material ke sistem.</p>
                        </div>
                    </div>

                    <!-- RINGKASAN STATISTIK -->
                    <div class="preview-stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon green">
                                <span class="material-symbols-outlined">add_circle</span>
                            </div>
                            <div>
                                <div class="stat-number" style="color:var(--green);">{{ $preview['new_count'] }}</div>
                                <div class="stat-label">Data Baru (Siap Diimpor)</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon yellow">
                                <span class="material-symbols-outlined">history</span>
                            </div>
                            <div>
                                <div class="stat-number" style="color:#D97706;">{{ $preview['duplicate_count'] }}</div>
                                <div class="stat-label">Duplikat (Sudah Terdaftar)</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon red">
                                <span class="material-symbols-outlined">warning</span>
                            </div>
                            <div>
                                <div class="stat-number" style="color:var(--red);">{{ $preview['conflict_count'] }}</div>
                                <div class="stat-label">Data Tidak Valid (Ditolak)</div>
                            </div>
                        </div>
                    </div>

                    <!-- PEMBERITAHUAN JIKA SEMUA DATA SUDAH TERDAFTAR -->
                    @if($preview['new_count'] === 0 && $preview['duplicate_count'] > 0 && $preview['conflict_count'] === 0)
                        <div class="alert alert-info" style="display:flex;align-items:flex-start;gap:10px;">
                            <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;">info</span>
                            <div>
                                <div style="font-weight:700;font-size:14px;margin-bottom:2px;">Tidak Ada Data Baru</div>
                                <div>Seluruh {{ $preview['duplicate_count'] }} data material dalam file Excel sudah terdaftar di sistem. Tidak ada data baru yang perlu diimpor.</div>
                            </div>
                        </div>
                    @endif

                    <!-- RINCIAN KONFLIK DATA (JIKA ADA) -->
                    @if(!empty($preview['conflicts']))
                        <div class="alert alert-danger" style="margin-bottom:20px;">
                            <div style="display:flex;align-items:center;gap:8px;font-weight:700;margin-bottom:8px;">
                                <span class="material-symbols-outlined" style="font-size:20px;">error</span>
                                <span>Ditemukan {{ count($preview['conflicts']) }} Konflik No. Material (Tidak Dapat Diimpor):</span>
                            </div>
                            <ul style="margin:0 0 0 20px;padding:0;">
                                @foreach($preview['conflicts'] as $c)
                                    <li style="margin-bottom:6px;font-size:12.5px;">
                                        Baris {{ $c['row'] }}: <strong>{{ $c['material_number'] }}</strong> &mdash; {{ $c['reason'] }}
                                    </li>
                                @endforeach
                            </ul>
                            <div style="font-size:12px;margin-top:8px;color:#7F1D1D;">
                                💡 <em>Satu No. Material hanya boleh digunakan untuk satu nama material. Harap periksa file Excel Anda.</em>
                            </div>
                        </div>
                    @endif

                    <!-- TABEL PRATINJAU DATA BARU YANG AKAN DIIMPOR -->
                    @if($preview['new_count'] > 0)
                        <div style="margin-bottom:12px;">
                            <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);">Daftar Material Baru yang Akan Diimpor ({{ $preview['new_count'] }} Material):</h3>
                        </div>

                        <div class="preview-table-box">
                            <table class="preview-table">
                                <thead>
                                    <tr>
                                        <th style="width:50px;">No</th>
                                        <th style="width:160px;">No. Material</th>
                                        <th>Nama Material</th>
                                        <th style="width:120px;">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($preview['new_items'] as $idx => $item)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td><span class="badge-num">{{ $item['material_number'] }}</span></td>
                                            <td style="font-weight:600;">{{ $item['name'] }}</td>
                                            <td>{{ $item['unit'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- AKSI KONFIRMASI -->
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:12px;flex-wrap:wrap;">
                            <form action="{{ route('materials.import.cancel') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline">
                                    Batal / Unggah File Lain
                                </button>
                            </form>

                            <form action="{{ route('materials.import.confirm') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                                    Konfirmasi & Simpan {{ $preview['new_count'] }} Material Baru
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- AKSI JIKA TIDAK ADA DATA BARU -->
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:12px;margin-top:16px;">
                            <form action="{{ route('materials.import.cancel') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline">
                                    Upload File Lain
                                </button>
                            </form>

                            <a href="{{ route('materials.index') }}" class="btn btn-primary">
                                Kembali ke Data Material
                            </a>
                        </div>
                    @endif
                </div>

            @else
                {{-- ============================================================
                     BAGIAN 1: FORM UPLOAD FILE EXCEL BARU (3 KOLOM)
                ============================================================ --}}
                <div class="card" style="text-align:center;">
                    <div class="upload-icon-circle">
                        <span class="material-symbols-outlined" style="font-size:36px;">upload_file</span>
                    </div>

                    <h2 style="font-size:20px;font-weight:800;color:var(--blue-dark);margin-bottom:8px;">
                        Import Data Material melalui Excel
                    </h2>

                    <p style="font-size:13.5px;color:var(--text-muted);max-width:540px;margin:0 auto 24px;line-height:1.6;">
                        Unggah file Excel berisi data material. Periksa pratinjau data sebelum menyimpannya ke sistem.
                    </p>

                    <!-- FORM IMPORT -->
                    <form action="{{ route('materials.import') }}" method="POST" enctype="multipart/form-data" id="importForm" novalidate>
                        @csrf

                        <!-- ALERT VALIDASI JIKA FILE BELUM DIPILIH -->
                        <div id="importFileAlert" class="alert alert-danger" style="display:none;margin-bottom:16px;padding:12px 16px;border-radius:10px;text-align:left;align-items:center;justify-content:space-between;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span class="material-symbols-outlined" style="font-size:20px;color:var(--red);">error</span>
                                <span id="importFileAlertText" style="font-size:13.5px;font-weight:600;color:#991B1B;">Silakan pilih file Excel terlebih dahulu!</span>
                            </div>
                            <button type="button" id="closeImportAlertBtn" style="background:none;border:none;cursor:pointer;color:inherit;display:flex;align-items:center;" aria-label="Tutup">
                                <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                            </button>
                        </div>

                        <div class="upload-box" id="uploadBox">
                            <span class="material-symbols-outlined" id="uploadBoxIcon" style="font-size:42px;color:#94A3B8;margin-bottom:10px;">
                                cloud_upload
                            </span>

                            <p style="font-size:13.5px;color:var(--text-dark);margin-bottom:6px;font-weight:600;">
                                Format Kolom Template:
                            </p>

                            <div style="display:inline-flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;justify-content:center;">
                                <span style="background:#EFF6FF;color:var(--blue-dark);font-size:12px;font-weight:700;padding:4px 10px;border-radius:6px;border:1px solid #DBEAFE;">1. No. Material</span>
                                <span style="background:#EFF6FF;color:var(--blue-dark);font-size:12px;font-weight:700;padding:4px 10px;border-radius:6px;border:1px solid #DBEAFE;">2. Nama Material</span>
                                <span style="background:#EFF6FF;color:var(--blue-dark);font-size:12px;font-weight:700;padding:4px 10px;border-radius:6px;border:1px solid #DBEAFE;">3. Satuan</span>
                            </div>

                            <!-- FILE INPUT -->
                            <input type="file" id="file" name="file" accept=".xlsx" style="display:none;" onchange="showFileName(this)">

                            <!-- TOMBOL PILIH FILE -->
                            <div>
                                <button type="button" class="btn btn-outline" onclick="document.getElementById('file').click()">
                                    <span class="material-symbols-outlined" style="font-size:18px;">folder_open</span>
                                    Pilih File Excel (.xlsx)
                                </button>
                            </div>

                            <!-- NAMA FILE PILIHAN -->
                            <div id="fileName" class="file-name"></div>

                            <!-- PESAN ERROR DI BAWAH -->
                            <div id="importFileErrorMsg" style="display:none;color:var(--red);font-size:12.5px;font-weight:600;margin-top:12px;align-items:center;justify-content:center;gap:6px;">
                                <span class="material-symbols-outlined" style="font-size:18px;">error</span>
                                <span id="importFileErrorMsgText">Silakan pilih file Excel terlebih dahulu!</span>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
                            <div id="importButtonWrapper" style="display:inline-block;cursor:not-allowed;" title="Silakan pilih file Excel terlebih dahulu!">
                                <button type="submit" class="btn btn-primary" id="importButton" disabled>
                                    <span class="material-symbols-outlined" style="font-size:18px;">upload</span>
                                    Import Data
                                </button>
                            </div>

                            <a href="{{ route('materials.import.template') }}" class="btn btn-success">
                                <span class="material-symbols-outlined" style="font-size:18px;">download</span>
                                Unduh Template Excel
                            </a>

                            <a href="{{ route('materials.index') }}" class="btn btn-outline">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            @endif

        </div>

        <script id="material-import-scripts">
        (function () {
            const fileInput              = document.getElementById('file');
            const fileNameEl             = document.getElementById('fileName');
            const importBtn              = document.getElementById('importButton');
            const importBtnWrapper       = document.getElementById('importButtonWrapper');
            const uploadBox              = document.getElementById('uploadBox');
            const uploadBoxIcon          = document.getElementById('uploadBoxIcon');
            const importFileAlert        = document.getElementById('importFileAlert');
            const importFileAlertText    = document.getElementById('importFileAlertText');
            const closeImportAlertBtn    = document.getElementById('closeImportAlertBtn');
            const importFileErrorMsg     = document.getElementById('importFileErrorMsg');
            const importFileErrorMsgText = document.getElementById('importFileErrorMsgText');
            const importForm             = document.getElementById('importForm');

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function isXlsxFile(file) {
                if (!file || !file.name) return false;
                return file.name.toLowerCase().endsWith('.xlsx');
            }

            function showImportError(msg) {
                const message = msg || 'Silakan pilih file Excel terlebih dahulu!';
                if (importFileAlert) {
                    if (importFileAlertText) importFileAlertText.textContent = message;
                    importFileAlert.style.display = 'flex';
                }
                if (importFileErrorMsg) {
                    if (importFileErrorMsgText) importFileErrorMsgText.textContent = message;
                    importFileErrorMsg.style.display = 'flex';
                }
                if (uploadBox) {
                    uploadBox.classList.add('has-error');
                    uploadBox.classList.remove('has-file');
                }
            }

            function hideImportError() {
                if (importFileAlert) importFileAlert.style.display = 'none';
                if (importFileErrorMsg) importFileErrorMsg.style.display = 'none';
                if (uploadBox) uploadBox.classList.remove('has-error');
            }

            function showFileName(input) {
                if (input && input.files && input.files.length > 0) {
                    const file = input.files[0];
                    if (!isXlsxFile(file)) {
                        input.value = '';
                        showImportError('Format file tidak didukung! Hanya file Excel dengan format .xlsx yang diperbolehkan.');
                        if (uploadBox) {
                            uploadBox.classList.add('has-error');
                            uploadBox.classList.remove('has-file');
                        }
                        if (uploadBoxIcon) {
                            uploadBoxIcon.textContent = 'warning';
                            uploadBoxIcon.style.color = 'var(--red)';
                        }
                        if (fileNameEl) {
                            fileNameEl.style.display = 'none';
                            fileNameEl.innerHTML = '';
                        }
                        if (importBtn) {
                            importBtn.disabled = true;
                        }
                        if (importBtnWrapper) {
                            importBtnWrapper.style.cursor = 'not-allowed';
                            importBtnWrapper.title = 'Silakan pilih file Excel terlebih dahulu!';
                        }
                        return;
                    }
                    hideImportError();
                    if (uploadBox) {
                        uploadBox.classList.remove('has-error');
                        uploadBox.classList.add('has-file');
                    }
                    if (uploadBoxIcon) {
                        uploadBoxIcon.textContent = 'description';
                        uploadBoxIcon.style.color = 'var(--blue)';
                    }
                    if (fileNameEl) {
                        fileNameEl.style.display = 'block';
                        fileNameEl.innerHTML = 'File dipilih: <strong style="color:var(--blue);">' + escapeHtml(file.name) + '</strong> (' + (file.size / 1024).toFixed(1) + ' KB)';
                    }
                    if (importBtn) {
                        importBtn.disabled = false;
                    }
                    if (importBtnWrapper) {
                        importBtnWrapper.style.cursor = 'default';
                        importBtnWrapper.removeAttribute('title');
                    }
                } else {
                    hideImportError();
                    if (uploadBox) {
                        uploadBox.classList.remove('has-error', 'has-file');
                    }
                    if (uploadBoxIcon) {
                        uploadBoxIcon.textContent = 'cloud_upload';
                        uploadBoxIcon.style.color = '#94A3B8';
                    }
                    if (fileNameEl) {
                        fileNameEl.style.display = 'none';
                        fileNameEl.innerHTML = '';
                    }
                    if (importBtn) {
                        importBtn.disabled = true;
                    }
                    if (importBtnWrapper) {
                        importBtnWrapper.style.cursor = 'not-allowed';
                        importBtnWrapper.title = 'Silakan pilih file Excel terlebih dahulu!';
                    }
                }
            }

            // Bind ke window agar inline onchange="showFileName(this)" selalu berfungsi
            window.showFileName = showFileName;

            function validateImportFile(e) {
                if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                    if (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    showImportError('Silakan pilih file Excel terlebih dahulu!');
                    return false;
                }
                const file = fileInput.files[0];
                if (!isXlsxFile(file)) {
                    if (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    fileInput.value = '';
                    showImportError('Format file tidak didukung! Hanya file Excel dengan format .xlsx yang diperbolehkan.');
                    return false;
                }
                return true;
            }

            if (fileInput) {
                fileInput.addEventListener('click', function () {
                    this.value = '';
                });
                fileInput.addEventListener('change', function () {
                    showFileName(this);
                });
            }

            if (closeImportAlertBtn) {
                closeImportAlertBtn.addEventListener('click', hideImportError);
            }

            if (importBtnWrapper) {
                importBtnWrapper.addEventListener('click', function (e) {
                    if (importBtn && importBtn.disabled) {
                        validateImportFile(e);
                    }
                });
            }

            if (importBtn) {
                importBtn.addEventListener('click', function (e) {
                    if (!validateImportFile(e)) {
                        return false;
                    }
                });
            }

            if (importForm) {
                importForm.addEventListener('submit', function (e) {
                    if (!validateImportFile(e)) {
                        return false;
                    }
                    if (importBtn) {
                        importBtn.disabled = true;
                        importBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size:18px;">hourglass_top</span> Memeriksa File...';
                    }
                });
            }

            // Drag and drop & klik box support pada uploadBox
            if (uploadBox && fileInput) {
                uploadBox.addEventListener('click', function (e) {
                    if (e.target.closest('button') || e.target.closest('a') || e.target === fileInput) return;
                    fileInput.click();
                });
                uploadBox.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    uploadBox.style.borderColor = 'var(--blue)';
                    uploadBox.style.background = '#F0F7FF';
                });
                uploadBox.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!fileInput.files || fileInput.files.length === 0) {
                        uploadBox.style.borderColor = '#CBD5E1';
                        uploadBox.style.background = '#FAFBFD';
                    }
                });
                uploadBox.addEventListener('drop', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                        fileInput.files = e.dataTransfer.files;
                        showFileName(fileInput);
                    }
                });
            }

            window.openSidebar = window.openSidebar || function () {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.add('open');
            };
        })();
        </script>

    </main>

</div>

</body>

</html>