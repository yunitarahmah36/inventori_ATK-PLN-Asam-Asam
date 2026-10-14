<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Riwayat Stok Material</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8.5px;
            color: #1F2937;
            margin: 0;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            width: 100%;
            border-bottom: 3px solid #B46A72;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 70%;
            vertical-align: middle;
        }

        .header-right {
            width: 30%;
            text-align: right;
            vertical-align: middle;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #3D2227;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 10px;
            color: #7E5B62;
        }

        .document-label {
            display: inline-block;
            background: #FDF0F3;
            color: #B46A72;
            border: 1px solid #F7C8D3;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 8px;
            font-weight: bold;
        }


        /* =========================
           SUMMARY
        ========================= */

        .summary {
            width: 100%;
            margin-bottom: 14px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-left: -8px;
        }

        .summary-box {
            border: 1px solid #F2E0E4;
            background: #FAF4F6;
            padding: 9px 11px;
            border-radius: 7px;
        }

        .summary-label {
            color: #7E5B62;
            font-size: 7.5px;
            margin-bottom: 3px;
        }

        .summary-value {
            color: #3D2227;
            font-size: 11px;
            font-weight: bold;
        }

        .summary-date {
            color: #4D2C32;
            font-size: 8px;
        }


        /* =========================
           TABLE
        ========================= */

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table thead th {
            background: #B46A72;
            color: #FFFFFF;
            padding: 8px 5px;
            text-align: center;
            font-size: 7.8px;
            font-weight: bold;
            border: 1px solid #9C545C;
        }

        .data-table tbody td {
            padding: 7px 5px;
            border-bottom: 1px solid #F2E0E4;
            vertical-align: middle;
            font-size: 7.8px;
            word-wrap: break-word;
        }

        .data-table tbody tr:nth-child(even) {
            background: #FAF4F6;
        }

        .data-table tbody tr:nth-child(odd) {
            background: #FFFFFF;
        }


        /* =========================
           ALIGNMENT
        ========================= */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }


        /* =========================
           MATERIAL
        ========================= */

        .material-name {
            font-weight: bold;
            color: #1F2937;
            font-size: 8px;
        }

        .material-number {
            color: #6B7280;
            font-size: 7px;
            margin-top: 2px;
        }


        /* =========================
           USER
        ========================= */

        .user-name {
            font-weight: bold;
            color: #1F2937;
            font-size: 8px;
        }

        .user-role {
            color: #6B7280;
            font-size: 7px;
            margin-top: 2px;
        }


        /* =========================
           STOCK CHANGE
        ========================= */

        .stock-change {
            display: inline-block;
            min-width: 48px;
            padding: 4px 6px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        .stock-positive {
            color: #047857;
            background: #D1FAE5;
            border: 1px solid #A7F3D0;
        }

        .stock-negative {
            color: #B91C1C;
            background: #FEE2E2;
            border: 1px solid #FECACA;
        }

        .stock-zero {
            color: #6B7280;
            background: #F3F4F6;
            border: 1px solid #E5E7EB;
        }


        /* =========================
           ACTIVITY
        ========================= */

        .activity {
            display: inline-block;
            padding: 4px 7px;
            border-radius: 5px;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
        }

        .activity-tambah {
            background: #D1FAE5;
            color: #047857;
        }

        .activity-kurangi {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .activity-edit {
            background: #FEF3C7;
            color: #92400E;
        }

        .activity-import {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .activity-hapus {
            background: #FEE2E2;
            color: #991B1B;
        }

        .activity-default {
            background: #F3F4F6;
            color: #374151;
        }


        /* =========================
           STOCK NUMBER
        ========================= */

        .stock-number {
            font-weight: bold;
            color: #374151;
            text-align: center;
        }


        /* =========================
           DATE
        ========================= */

        .date-main {
            font-weight: bold;
            color: #374151;
        }

        .date-time {
            color: #6B7280;
            font-size: 7px;
            margin-top: 2px;
        }


        /* =========================
           DESCRIPTION
        ========================= */

        .description {
            color: #4B5563;
            font-size: 7.5px;
            line-height: 1.4;
        }


        /* =========================
           EMPTY DATA
        ========================= */

        .empty {
            text-align: center;
            padding: 20px;
            color: #6B7280;
            font-size: 9px;
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #E5E7EB;
            color: #6B7280;
            font-size: 7px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-right {
            text-align: right;
        }


        /* =========================
           COLUMN WIDTH
        ========================= */

        .col-no {
            width: 4%;
        }

        .col-date {
            width: 11%;
        }

        .col-user {
            width: 11%;
        }

        .col-material {
            width: 21%;
        }

        .col-activity {
            width: 9%;
        }

        .col-before {
            width: 9%;
        }

        .col-change {
            width: 9%;
        }

        .col-after {
            width: 9%;
        }

        .col-description {
            width: 17%;
        }

    </style>
</head>

<body>

    {{-- =========================
         HEADER
    ========================= --}}

    <div class="header">

        <table class="header-table">
            <tr>

                <td class="header-left">

                    <div class="title">
                        RIWAYAT STOK MATERIAL
                    </div>

                    <div class="subtitle">
                        Sistem Informasi Persediaan ATK PT PLN Indonesia Power UBP Asam Asam
                    </div>

                </td>

                <td class="header-right">

                    <span class="document-label">
                        LAPORAN RIWAYAT STOK
                    </span>

                </td>

            </tr>
        </table>

    </div>


    {{-- =========================
         SUMMARY
    ========================= --}}

    @php
        $appliedFilters = [];

        // 1. Filter Tanggal (hanya jika memang diisi di filter/request)
        $hasStart = request()->filled('start_date');
        $hasEnd = request()->filled('end_date');

        if ($hasStart && $hasEnd) {
            $startDateObj = \Carbon\Carbon::parse(request('start_date'))->locale('id');
            $endDateObj = \Carbon\Carbon::parse(request('end_date'))->locale('id');
            if ($startDateObj->gt($endDateObj)) {
                [$startDateObj, $endDateObj] = [$endDateObj, $startDateObj];
            }

            if ($startDateObj->isSameDay($endDateObj)) {
                $dateFormatted = $startDateObj->translatedFormat('j F Y');
            } elseif ($startDateObj->isSameMonth($endDateObj) && $startDateObj->isSameYear($endDateObj)) {
                $dateFormatted = $startDateObj->translatedFormat('j') . '–' . $endDateObj->translatedFormat('j F Y');
            } elseif ($startDateObj->isSameYear($endDateObj)) {
                $dateFormatted = $startDateObj->translatedFormat('j F') . ' – ' . $endDateObj->translatedFormat('j F Y');
            } else {
                $dateFormatted = $startDateObj->translatedFormat('j F Y') . ' – ' . $endDateObj->translatedFormat('j F Y');
            }

            $appliedFilters['date'] = [
                'type' => 'date',
                'label' => 'Periode',
                'value' => $dateFormatted,
            ];
        } elseif ($hasStart) {
            $startDateObj = \Carbon\Carbon::parse(request('start_date'))->locale('id');
            $appliedFilters['date'] = [
                'type' => 'date',
                'label' => 'Periode',
                'value' => 'Mulai ' . $startDateObj->translatedFormat('j F Y'),
            ];
        } elseif ($hasEnd) {
            $endDateObj = \Carbon\Carbon::parse(request('end_date'))->locale('id');
            $appliedFilters['date'] = [
                'type' => 'date',
                'label' => 'Periode',
                'value' => 'Sampai ' . $endDateObj->translatedFormat('j F Y'),
            ];
        }

        // 2. Filter Jenis Transaksi / Aktivitas
        if (request()->filled('activity')) {
            $appliedFilters['activity'] = [
                'type' => 'activity',
                'label' => 'Transaksi',
                'value' => request('activity'),
            ];
        }

        // 3. Filter Nama Material
        $filterMaterialName = null;
        if (request()->filled('material_name')) {
            $filterMaterialName = request('material_name');
        } elseif (request()->filled('material_id')) {
            $mat = \App\Models\Material::find(request('material_id'));
            $filterMaterialName = $mat ? $mat->name : 'ID #' . request('material_id');
        } elseif (request()->filled('material')) {
            $matParam = request('material');
            $mat = is_numeric($matParam) ? \App\Models\Material::find($matParam) : null;
            $filterMaterialName = $mat ? $mat->name : $matParam;
        }

        // Cek jika parameter search persis cocok dengan nomor material atau nama material
        if (!$filterMaterialName && request()->filled('search')) {
            $searchVal = trim(request('search'));
            $matchedMaterial = \App\Models\Material::where('material_number', $searchVal)
                ->orWhere('name', $searchVal)
                ->first();
            if ($matchedMaterial) {
                $filterMaterialName = $matchedMaterial->name;
            }
        }

        if ($filterMaterialName) {
            $appliedFilters['material'] = [
                'type' => 'material',
                'label' => 'Material',
                'value' => $filterMaterialName,
            ];
        }

        // 4. Filter Pencarian Bebas (jika belum dipakai sebagai filter material persis)
        if (request()->filled('search') && !$filterMaterialName) {
            $appliedFilters['search'] = [
                'type' => 'search',
                'label' => 'Pencarian',
                'value' => '"' . request('search') . '"',
            ];
        }

        // Menentukan label kartu header & representasi tampilannya
        $filterCount = count($appliedFilters);

        if ($filterCount === 0) {
            $cardHeaderLabel = 'FILTER LAPORAN';
            $isSingleFilter = true;
            $singleFilterValue = 'Semua Data';
        } elseif ($filterCount === 1) {
            $firstFilter = reset($appliedFilters);
            $cardHeaderLabel = match ($firstFilter['type']) {
                'date' => 'PERIODE LAPORAN',
                'activity' => 'JENIS TRANSAKSI',
                'material' => 'FILTER MATERIAL',
                'search' => 'FILTER PENCARIAN',
                default => 'FILTER LAPORAN',
            };
            $isSingleFilter = true;
            $singleFilterValue = $firstFilter['value'];
        } else {
            $cardHeaderLabel = 'FILTER LAPORAN';
            $isSingleFilter = false;
            $singleFilterValue = null;
        }
    @endphp

    <div class="summary">

        <table class="summary-table">

            <tr>

                <td width="25%">
                    <div class="summary-box">

                        <div class="summary-label">
                            TOTAL AKTIVITAS
                        </div>

                        <div class="summary-value">
                            {{ $movements->count() }} Aktivitas
                        </div>

                    </div>
                </td>

                <td width="25%">
                    <div class="summary-box">

                        <div class="summary-label">
                            STATUS DATA
                        </div>

                        <div class="summary-value">
                            Data Riwayat Stok
                        </div>

                    </div>
                </td>

                <td width="25%">
                    <div class="summary-box">

                        <div class="summary-label">
                            TANGGAL CETAK
                        </div>

                        <div class="summary-date">
                            {{ now()->format('d/m/Y H:i') }} WITA
                        </div>

                    </div>
                </td>

                <td width="25%">
                    <div class="summary-box">

                        <div class="summary-label">
                            {{ $cardHeaderLabel }}
                        </div>

                        <div class="summary-date">
                            @if ($isSingleFilter)
                                <span style="font-weight: bold; color: #3D2227; font-size: 8.5px;">
                                    {{ $singleFilterValue }}
                                </span>
                            @else
                                @foreach ($appliedFilters as $filterItem)
                                    <div style="line-height: 1.35; margin-bottom: 2px;">
                                        <span style="color: #7E5B62;">{{ $filterItem['label'] }}:</span>
                                        <strong style="color: #3D2227;">{{ $filterItem['value'] }}</strong>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </td>

            </tr>

        </table>

    </div>


    {{-- =========================
         DATA TABLE
    ========================= --}}

    <table class="data-table">

        <thead>

            <tr>

                <th class="col-no">
                    No
                </th>

                <th class="col-date">
                    Tanggal & Waktu
                </th>

                <th class="col-user">
                    Pengguna
                </th>

                <th class="col-material">
                    Material
                </th>

                <th class="col-activity">
                    Aktivitas
                </th>

                <th class="col-before">
                    Stok Sebelum
                </th>

                <th class="col-change">
                    Perubahan
                </th>

                <th class="col-after">
                    Stok Sesudah
                </th>

                <th class="col-description">
                    Keterangan
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse ($movements as $index => $movement)

                @php

                    $change = (int) ($movement->quantity_change ?? 0);

                    /*
                     * USER / PEMINJAM
                     */
                    if (!empty($movement->recipient)) {
                        $displayUserName = strtoupper($movement->recipient);
                        $displayRole = 'Peminjam / Pengambil';
                    } else {
                        $userEmail = $movement->user->email ?? '';
                        $userName = $movement->user->name ?? 'Unknown';

                        $displayUserName = $userEmail
                            ? strtoupper(strstr($userEmail, '@', true))
                            : strtoupper($userName);
                        $displayRole = $movement->user->role ?? '-';
                    }


                    /*
                     * ACTIVITY
                     */
                    $activity = strtolower($movement->activity ?? '');

                    $activityClass = match ($activity) {

                        'tambah' => 'activity-tambah',

                        'kurangi', 'keluar' => 'activity-kurangi',

                        'edit' => 'activity-edit',

                        'import' => 'activity-import',

                        'hapus' => 'activity-hapus',

                        default => 'activity-default',

                    };


                    /*
                     * STOCK CHANGE
                     */
                    if ($change > 0) {

                        $changeClass = 'stock-positive';

                        $changeText = '+' . number_format(
                            $change,
                            0,
                            ',',
                            '.'
                        );

                    } elseif ($change < 0) {

                        $changeClass = 'stock-negative';

                        $changeText = number_format(
                            $change,
                            0,
                            ',',
                            '.'
                        );

                    } else {

                        $changeClass = 'stock-zero';

                        $changeText = '0';

                    }

                @endphp


                <tr>

                    {{-- NO --}}

                    <td class="text-center">
                        {{ (isset($startNumber) ? $startNumber : 1) + $index }}
                    </td>


                    {{-- DATE --}}

                    <td class="text-center">

                        <div class="date-main">

                            {{ $movement->created_at
                                ? $movement->created_at->format('d/m/Y')
                                : '-'
                            }}

                        </div>

                        <div class="date-time">

                            {{ $movement->created_at
                                ? $movement->created_at->format('H:i') . ' WITA'
                                : '-'
                            }}

                        </div>

                    </td>


                    {{-- USER --}}

                    <td>

                        <div class="user-name">

                            {{ $displayUserName }}

                        </div>

                        <div class="user-role">

                            {{ $displayRole ?? '-' }}

                        </div>

                    </td>


                    {{-- MATERIAL --}}

                    <td>

                        <div class="material-name">

                            {{ $movement->material->name ?? $movement->material_name ?? '-' }}

                        </div>

                        <div class="material-number">

                            No Material:
                            {{ $movement->material->material_number ?? $movement->material_number ?? '-' }}

                        </div>

                    </td>


                    {{-- ACTIVITY --}}

                    <td class="text-center">

                        <span class="activity {{ $activityClass }}">

                            {{ $movement->activity ?? '-' }}

                        </span>

                    </td>


                    {{-- BEFORE --}}

                    <td class="text-center">

                        <span class="stock-number">

                            {{ number_format(
                                $movement->quantity_before ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </td>


                    {{-- CHANGE --}}

                    <td class="text-center">

                        <span class="stock-change {{ $changeClass }}">

                            {{ $changeText }}

                        </span>

                    </td>


                    {{-- AFTER --}}

                    <td class="text-center">

                        <span class="stock-number">

                            {{ number_format(
                                $movement->quantity_after ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </td>


                    {{-- DESCRIPTION --}}

                    <td>

                        <div class="description">

                            {{ $movement->description ?: '-' }}

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="empty">

                        Tidak ada riwayat stok yang tersedia.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================
         FOOTER
    ========================= --}}

    <div class="footer">

        <table class="footer-table">

            <tr>

                <td>
                    Dokumen dibuat secara otomatis oleh
                    Sistem Informasi Persediaan ATK PT PLN Indonesia Power UBP Asam Asam.
                </td>

                <td class="footer-right">
                    {{ now()->format('d/m/Y H:i') }} WITA
                </td>

            </tr>

        </table>

    </div>

</body>
</html>