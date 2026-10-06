<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Inventori ATK PLN Asam-Asam</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #F5F7FA;
            color: #1F2937;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #0057B8;
            color: white;
            padding: 25px 18px;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo h2 {
            font-size: 20px;
        }

        .logo p {
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.85;
        }

        .menu-title {
            font-size: 11px;
            opacity: 0.7;
            margin: 20px 12px 10px;
            text-transform: uppercase;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 15px;
            margin-bottom: 6px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .menu a.active {
            background: #FFC107;
            color: #003B73;
            font-weight: bold;
        }

        .logout {
            position: absolute;
            bottom: 25px;
            left: 18px;
            right: 18px;
        }

        .logout button {
            width: 100%;
            border: none;
            background: rgba(255, 255, 255, 0.12);
            color: white;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout button:hover {
            background: #dc3545;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            height: 75px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar h1 {
            font-size: 22px;
            color: #003B73;
        }

        .topbar p {
            font-size: 13px;
            color: #6B7280;
            margin-top: 4px;
        }

        /* =========================
           USER INFO
        ========================= */

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #0057B8;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
            font-weight: bold;
        }

        .user-detail {
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: bold;
            color: #1F2937;
        }

        .user-email {
            font-size: 12px;
            color: #6B7280;
            margin-top: 2px;
        }

        .user-role {
            display: inline-block;
            margin-top: 4px;
            padding: 3px 8px;
            border-radius: 10px;
            background: #FFF8E1;
            color: #0057B8;
            font-size: 10px;
            font-weight: bold;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            padding: 30px;
        }

        .welcome {
            background: linear-gradient(
                135deg,
                #0057B8,
                #003B73
            );

            color: white;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome h2 {
            font-size: 22px;
            margin-bottom: 7px;
        }

        .welcome p {
            font-size: 13px;
            opacity: 0.9;
        }

        .welcome-user {
            background: #FFC107;
            color: #003B73;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        /* =========================
           STATISTICS
        ========================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 22px;

            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

            display: flex;
            align-items: center;
            gap: 18px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;

            background: #EAF3FF;
            color: #0057B8;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
            font-weight: bold;
        }

        .card h3 {
            font-size: 13px;
            color: #6B7280;
            margin-bottom: 6px;
        }

        .card p {
            font-size: 25px;
            font-weight: bold;
            color: #003B73;
        }

        /* =========================
           SECTION
        ========================= */

        .section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;

            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .section-header h2 {
            font-size: 17px;
            color: #003B73;
        }

        .section-header span {
            font-size: 12px;
            color: #6B7280;
        }

        /* =========================
           TABLE
        ========================= */

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            background: #0057B8;
            color: white;
            padding: 13px;
            text-align: left;
            font-size: 12px;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #FFF8E1;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-tambah {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-edit {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .badge-hapus {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .badge-import {
            background: #FEF3C7;
            color: #92400E;
        }

        /* =========================
           EMPTY DATA
        ========================= */

        .empty {
            text-align: center;
            padding: 30px;
            color: #6B7280;
            font-size: 13px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
            }

            .logout {
                position: relative;
                left: auto;
                right: auto;
                bottom: auto;
                margin-top: 20px;
            }

            .topbar {
                height: auto;
                padding: 18px;
                gap: 15px;
            }

            .topbar h1 {
                font-size: 18px;
            }

            .user-detail {
                display: none;
            }

            .content {
                padding: 18px;
            }

            .welcome {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>


<body>

    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">

        <div class="logo">
            <h2>INVENTORI ATK</h2>
            <p>PLN Indonesia Power</p>
            <p>UBP Asam-Asam</p>
        </div>


        <div class="menu-title">
            Menu Utama
        </div>


        <nav class="menu">

            <a href="{{ route('dashboard') }}" class="active">
                <span>▣</span>
                <span>Dashboard</span>
            </a>

            <a href="#">
                <span>▤</span>
                <span>Data Material</span>
            </a>

            <a href="#">
                <span>↔</span>
                <span>Riwayat Stok</span>
            </a>

            <a href="#">
                <span>▥</span>
                <span>Laporan</span>
            </a>

        </nav>


        <div class="menu-title">
            Akun
        </div>


        <nav class="menu">

            <a href="#">
                <span>◉</span>
                <span>Profile</span>
            </a>

        </nav>


        <!-- LOGOUT -->

        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit">
                    ⇥ &nbsp; Logout
                </button>

            </form>

        </div>

    </aside>



    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <main class="main">


        <!-- TOPBAR -->

        <header class="topbar">

            <div>
                <h1>Dashboard</h1>

                <p>
                    Sistem Informasi Inventori ATK
                </p>
            </div>


            <!-- USER YANG SEDANG LOGIN -->

            <div class="user-info">

                <div class="user-detail">

                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-email">
                        {{ auth()->user()->email }}
                    </div>

                    <span class="user-role">
                        {{ auth()->user()->role }}
                    </span>

                </div>


                <!-- AVATAR OTOMATIS -->

                <div class="avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>



        <!-- CONTENT -->

        <div class="content">


            <!-- =========================
                 WELCOME
            ========================= -->

            <div class="welcome">

                <div>

                    <h2>
                        Selamat Datang,
                        {{ auth()->user()->name }}!
                    </h2>

                    <p>
                        Anda login sebagai
                        <strong>{{ auth()->user()->role }}</strong>.
                        Selamat bekerja!
                    </p>

                </div>


                <div class="welcome-user">

                    {{ auth()->user()->role }}

                </div>

            </div>



            <!-- =========================
                 STATISTIK
            ========================= -->

            <div class="cards">


                <!-- TOTAL MATERIAL -->

                <div class="card">

                    <div class="card-icon">
                        M
                    </div>

                    <div>

                        <h3>
                            Total Material
                        </h3>

                        <p>
                            {{ $totalMaterial }}
                        </p>

                    </div>

                </div>



                <!-- TOTAL ITEM -->

                <div class="card">

                    <div class="card-icon">
                        I
                    </div>

                    <div>

                        <h3>
                            Total Jumlah Item
                        </h3>

                        <p>
                            {{ $totalItem }}
                        </p>

                    </div>

                </div>

            </div>



            <!-- =========================
                 MATERIAL TERBARU
            ========================= -->

            <div class="section">

                <div class="section-header">

                    <h2>
                        Material Terbaru
                    </h2>

                    <span>
                        Data material yang terakhir ditambahkan
                    </span>

                </div>


                @if ($latestMaterials->count() > 0)

                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>
                                    <th>No Material</th>
                                    <th>Nama Material</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($latestMaterials as $material)

                                    <tr>

                                        <td>
                                            {{ $material->material_number }}
                                        </td>

                                        <td>
                                            {{ $material->name }}
                                        </td>

                                        <td>
                                            {{ $material->entry_date->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            {{ $material->quantity }}
                                        </td>

                                        <td>
                                            {{ $material->unit }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty">
                        Belum ada data material.
                    </div>

                @endif

            </div>



            <!-- =========================
                 AKTIVITAS TERBARU
            ========================= -->

            <div class="section">

                <div class="section-header">

                    <h2>
                        Aktivitas Terbaru
                    </h2>

                    <span>
                        Aktivitas pengguna sistem
                    </span>

                </div>


                @if ($latestActivities->count() > 0)

                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>
                                    <th>Pengguna</th>
                                    <th>Material</th>
                                    <th>Aktivitas</th>
                                    <th>Perubahan</th>
                                    <th>Waktu</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($latestActivities as $activity)

                                    <tr>

                                        <td>
                                            <strong>
                                                {{ $activity->user->name }}
                                            </strong>

                                            <br>

                                            <small style="color:#6B7280;">
                                                {{ $activity->user->role }}
                                            </small>
                                        </td>


                                        <td>
                                            {{ $activity->material->name }}
                                        </td>


                                        <td>

                                            @if ($activity->activity == 'Tambah')

                                                <span class="badge badge-tambah">
                                                    Tambah
                                                </span>

                                            @elseif ($activity->activity == 'Edit')

                                                <span class="badge badge-edit">
                                                    Edit
                                                </span>

                                            @elseif ($activity->activity == 'Hapus')

                                                <span class="badge badge-hapus">
                                                    Hapus
                                                </span>

                                            @elseif ($activity->activity == 'Import')

                                                <span class="badge badge-import">
                                                    Import
                                                </span>

                                            @else

                                                <span class="badge">
                                                    {{ $activity->activity }}
                                                </span>

                                            @endif

                                        </td>


                                        <td>

                                            @if ($activity->quantity_change > 0)

                                                +{{ $activity->quantity_change }}

                                            @elseif ($activity->quantity_change < 0)

                                                {{ $activity->quantity_change }}

                                            @else

                                                0

                                            @endif

                                        </td>


                                        <td>

                                            {{ $activity->created_at->format('d-m-Y H:i') }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty">
                        Belum ada aktivitas.
                    </div>

                @endif

            </div>


        </div>

    </main>


</body>

</html>