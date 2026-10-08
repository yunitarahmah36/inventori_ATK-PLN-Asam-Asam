<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

    <title>Import Excel - Inventori ATK PT PLN Indonesia Power UBP Asam Asam</title>

    <link rel="icon" type="image/png" href="{{ asset('images/pln_bulat.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
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
            --bg: #F5F7FA;
            --white: #FFFFFF;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --sidebar-w: 260px;
            --header-h: 68px;
            --radius: 12px;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', Arial, sans-serif;
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

        .page-content {
            padding: 24px 28px 80px;
            flex: 1;
            max-width: 800px;
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
        }

        .btn-back:hover {
            color: var(--blue);
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 36px;
            text-align: center;
        }

        .icon-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .icon-circle .material-symbols-outlined {
            font-size: 36px;
        }

        .card h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-dark);
            margin-bottom: 8px;
        }

        .card > p {
            font-size: 13.5px;
            color: var(--text-muted);
            max-width: 500px;
            margin: 0 auto 24px;
            line-height: 1.6;
        }

        .upload-box {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 40px 20px;
            background: #FAFBFD;
            margin-bottom: 24px;
        }

        .upload-box p {
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--text-muted);
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
            transition: 0.2s;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
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

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: left;
            font-size: 13px;
        }

        .alert-success {
            background: #ECFDF3;
            color: #166534;
            border: 1px solid #BBF7D0;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .error-list {
            margin: 6px 0 0 18px;
        }

        .info-box {
            margin-top: 20px;
            padding: 14px 16px;
            background: var(--blue-light);
            border-radius: 8px;
            text-align: left;
            font-size: 12px;
            color: var(--blue-dark);
            line-height: 1.7;
        }

        @media (max-width: 768px) {

            .btn-hamburger {
                display: flex;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-left h1 {
                font-size: 17px;
            }

            .topbar-user-detail {
                display: none;
            }

            .main {
                margin-left: 0;
            }

            .page-content {
                padding: 16px;
            }

            .card {
                padding: 24px 18px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
    <script>
    document.documentElement.classList.add('page-loading');

    window.addEventListener('load', function () {
        document.documentElement.classList.remove('page-loading');
    });
</script>

<style>
    html.page-loading body {
        visibility: hidden;
    }

    html:not(.page-loading) body {
        visibility: visible;
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

                <button
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
                        Import Data Material
                    </h1>

                    <p>
                        Inventori ATK PT PLN Indonesia Power UBP Asam Asam
                    </p>

                </div>

            </div>

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
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <div class="page-content">

            <a
                href="{{ route('materials.index') }}"
                class="btn-back"
            >
                <span
                    class="material-symbols-outlined"
                    style="font-size:18px;"
                >
                    arrow_back
                </span>

                Kembali ke Data Material
            </a>


            <!-- SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success" style="display:flex;align-items:center;gap:10px;">
                    <span class="material-symbols-outlined" style="font-size:20px;flex-shrink:0;">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif


            <!-- ERROR UMUM (file rusak, kolom salah, dll) -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;margin-top:1px;">error</span>
                        <div>
                            <div style="font-weight:700;font-size:14px;margin-bottom:4px;">Import Tidak Berhasil</div>
                            <div style="line-height:1.6;">{{ session('error') }}</div>
                            <div style="margin-top:10px;font-size:12px;color:#7F1D1D;">
                                💡 <strong>Saran:</strong> Download template di bawah agar format file sudah pasti benar.
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <!-- ERROR VALIDASI PER BARIS (dari Excel) -->
            @if(session('import_errors'))
                @php $importErrors = session('import_errors'); @endphp
                <div class="alert alert-danger">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;margin-top:1px;">table_rows</span>
                        <div style="flex:1;min-width:0;">
                            <div style="font-weight:700;font-size:14px;margin-bottom:4px;">
                                Import Gagal — Ditemukan {{ count($importErrors) }} masalah pada data
                            </div>
                            <div style="font-size:13px;margin-bottom:10px;line-height:1.5;">
                                Beberapa baris di file Excel tidak sesuai format. Perbaiki data berikut lalu coba import ulang.
                            </div>
                            <ul style="margin:0 0 0 4px;padding:0;list-style:none;display:flex;flex-direction:column;gap:5px;">
                                @foreach($importErrors as $err)
                                    <li style="display:flex;align-items:flex-start;gap:7px;font-size:12.5px;padding:6px 10px;background:rgba(185,28,28,0.07);border-radius:6px;">
                                        <span class="material-symbols-outlined" style="font-size:15px;flex-shrink:0;margin-top:1px;color:#B91C1C;">warning</span>
                                        <span>{{ $err }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div style="margin-top:12px;font-size:12px;color:#7F1D1D;">
                                💡 <strong>Saran:</strong> Nomor baris di atas sudah termasuk baris header (baris 1). Jadi "Baris 2" berarti data pertama di file Excel Anda.
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <!-- ERROR VALIDASI FILE (misal: bukan xlsx/xls) -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span class="material-symbols-outlined" style="font-size:22px;flex-shrink:0;margin-top:1px;">upload_file</span>
                        <div>
                            <div style="font-weight:700;font-size:14px;margin-bottom:6px;">File Tidak Dapat Diproses</div>
                            @foreach($errors->all() as $error)
                                <div style="line-height:1.6;">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


            <div class="card">

                <div class="icon-circle">

                    <span class="material-symbols-outlined">
                        upload_file
                    </span>

                </div>


                <h2>
                    Import Data Material via Excel
                </h2>


                <p>
                    Upload file Excel untuk menambahkan data material
                    secara massal ke dalam sistem Inventori ATK PT PLN Indonesia Power UBP Asam Asam.
                </p>


                <!-- FORM IMPORT -->
                <form
                    action="{{ route('materials.import') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="importForm"
                >

                    @csrf


                    <div class="upload-box">

                        <span
                            class="material-symbols-outlined"
                            style="font-size:42px;color:#94A3B8;margin-bottom:8px;"
                        >
                            cloud_upload
                        </span>


                        <p>

                            Format kolom:

                            <strong>
                                No Material, Nama Material,
                                Tanggal Masuk, Jumlah Item,
                                Satuan, Deskripsi
                            </strong>

                        </p>


                        <!-- FILE INPUT -->
                        <input
                            type="file"
                            id="file"
                            name="file"
                            accept=".xlsx,.xls"
                            style="display:none;"
                            required
                            onchange="showFileName(this)"
                        >


                        <!-- PILIH FILE -->
                        <button
                            type="button"
                            class="btn btn-outline"
                            onclick="document.getElementById('file').click()"
                        >

                            <span
                                class="material-symbols-outlined"
                                style="font-size:18px;"
                            >
                                folder_open
                            </span>

                            Pilih File Excel

                        </button>


                        <!-- NAMA FILE -->
                        <div
                            id="fileName"
                            class="file-name"
                        >
                        </div>

                    </div>


                    <!-- BUTTON -->
                    <div
                        class="action-buttons"
                        style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;"
                    >

                        <!-- IMPORT -->
                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="importButton"
                            disabled
                        >

                            <span
                                class="material-symbols-outlined"
                                style="font-size:18px;"
                            >
                                upload
                            </span>

                            Import Excel

                        </button>


                        <!-- TEMPLATE -->
                        <a
                            href="{{ route('materials.import.template') }}"
                            class="btn btn-success"
                        >

                            <span
                                class="material-symbols-outlined"
                                style="font-size:18px;"
                            >
                                download
                            </span>

                            Download Template Excel

                        </a>


                        <!-- KEMBALI -->
                        <a
                            href="{{ route('materials.index') }}"
                            class="btn btn-outline"
                        >

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

        <script>

    function showFileName(input) {

        const fileName = document.getElementById('fileName');
        const importButton = document.getElementById('importButton');

        if (input.files && input.files.length > 0) {

            const file = input.files[0];

            fileName.style.display = 'block';

            fileName.innerHTML =
                'File dipilih: <strong>' +
                file.name +
                '</strong>';

            importButton.disabled = false;

        } else {

            fileName.style.display = 'none';

            fileName.innerHTML = '';

            importButton.disabled = true;
        }
    }


    document
        .getElementById('importForm')
        .addEventListener('submit', function () {

            const button =
                document.getElementById('importButton');

            button.disabled = true;

            button.innerHTML =
                '<span class="material-symbols-outlined" style="font-size:18px;">progress_activity</span>' +
                ' Sedang Mengimport...';

        });

</script>


    </main>

</div>

</body>

</html>