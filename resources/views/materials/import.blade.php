<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Import Excel - Inventori ATK PLN Asam-Asam</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
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
            --shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        html, body { height: 100%; font-family: 'Inter', Arial, sans-serif; background: var(--bg); color: var(--text-dark); }
        a { text-decoration: none; color: inherit; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { position: fixed; inset: 0 auto 0 0; width: var(--sidebar-w); background: var(--blue-dark); color: #fff; display: flex; flex-direction: column; z-index: 200; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 22px 20px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .sidebar-logo-image { width: 40px; height: 40px; object-fit: contain; }
        .sidebar-logo-text h1 { font-size: 15px; font-weight: 700; color: #fff; }
        .sidebar-logo-text p { font-size: 11px; color: rgba(255, 255, 255, 0.55); }
        .sidebar-user { margin: 14px 12px 6px; padding: 12px; background: rgba(255,255,255,0.07); border-radius: 10px; display: flex; align-items: center; gap: 10px; }
        .sidebar-avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--yellow); color: var(--blue-dark); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; }
        .sidebar-user-name { font-size: 13px; font-weight: 700; color: #fff; }
        .sidebar-user-role { font-size: 11px; color: var(--yellow); font-weight: 600; text-transform: uppercase; }
        .sidebar-nav { flex: 1; padding: 10px 12px; }
        .nav-item { display: flex; align-items: center; gap: 11px; padding: 10px 12px; border-radius: 9px; color: rgba(255,255,255,0.78); font-size: 13.5px; font-weight: 500; }
        .nav-item.active { background: rgba(255,255,255,0.14); color: var(--yellow); font-weight: 700; }
        .nav-item .material-symbols-outlined { font-size: 20px; }
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-width: 0; min-height: 100vh; }
        .topbar { height: var(--header-h); background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; position: sticky; top: 0; z-index: 100; }
        .topbar-left h1 { font-size: 18px; font-weight: 800; color: var(--blue-dark); }
        .topbar-left p { font-size: 12px; color: var(--text-muted); }
        .page-content { padding: 24px 28px 80px; flex: 1; max-width: 800px; margin: 0 auto; width: 100%; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 16px; }
        .btn-back:hover { color: var(--blue); }
        .card { background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 36px; text-align: center; }
        .icon-circle { width: 72px; height: 72px; border-radius: 50%; background: var(--blue-light); color: var(--blue); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
        .icon-circle .material-symbols-outlined { font-size: 36px; }
        .card h2 { font-size: 20px; font-weight: 800; color: var(--blue-dark); margin-bottom: 8px; }
        .card p { font-size: 13.5px; color: var(--text-muted); max-width: 500px; margin: 0 auto 24px; line-height: 1.6; }
        .upload-box { border: 2px dashed #CBD5E1; border-radius: 12px; padding: 40px 20px; background: #FAFBFD; margin-bottom: 24px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-outline { background: var(--white); color: var(--text-dark); border: 1px solid var(--border); }
        @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; } .page-content { padding: 16px; } }
    </style>
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" class="sidebar-logo-image">
                <div class="sidebar-logo-text">
                    <h1>STOK ATK</h1>
                    <p>PLN Asam-Asam</p>
                </div>
            </div>
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="material-symbols-outlined">speed</span>
                    Dashboard
                </a>
                <a href="{{ route('materials.index') }}" class="nav-item active">
                    <span class="material-symbols-outlined">inventory_2</span>
                    Data Material
                </a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="topbar-left">
                    <h1>Import Data Material</h1>
                    <p>Inventori ATK PLN Asam-Asam</p>
                </div>
            </header>

            <div class="page-content">
                <a href="{{ route('materials.index') }}" class="btn-back">
                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                    Kembali ke Data Material
                </a>

                <div class="card">
                    <div class="icon-circle">
                        <span class="material-symbols-outlined">upload_file</span>
                    </div>
                    <h2>Import Data Material via Excel</h2>
                    <p>Fitur upload file Excel (.xlsx / .csv) untuk import massal data material ATK PLN Asam-Asam. Pastikan format kolom sesuai dengan template standar.</p>

                    <div class="upload-box">
                        <span class="material-symbols-outlined" style="font-size:42px;color:#94A3B8;margin-bottom:8px;">cloud_upload</span>
                        <p style="margin-bottom:12px;font-size:13px;color:var(--text-muted);">
                            Format kolom: <strong>No Material, Nama Material, Tanggal Masuk, Jumlah, Satuan, Deskripsi</strong>
                        </p>
                        <input type="file" id="file" accept=".csv,.xlsx,.xls" style="display:none;" onchange="alert('File ' + this.files[0].name + ' siap diproses.')">
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('file').click()">
                            Pilih File Excel / CSV
                        </button>
                    </div>

                    <div style="display:flex;justify-content:center;gap:12px;">
                        <a href="{{ route('materials.export') }}" class="btn btn-outline">
                            <span class="material-symbols-outlined" style="font-size:18px;">download</span>
                            Download Template CSV
                        </a>
                        <a href="{{ route('materials.index') }}" class="btn btn-primary">
                            Kembali ke Data Material
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
