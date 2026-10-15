<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bukti Resi Pengambilan Barang - PLN IP UBP Asam Asam</title>
    <style>
        /* Reset Styles */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.4;
            color: #3D2227;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #F8F5F6;
            width: 100% !important;
            height: 100% !important;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Mobile Responsive Overrides */
        @media only screen and (max-width: 600px) {
            .mobile-container {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                border-left: none !important;
                border-right: none !important;
            }
            .mobile-wrapper {
                padding: 0 !important;
            }
            .mobile-content {
                padding: 16px 14px !important;
            }
            .mobile-header {
                padding: 20px 16px !important;
            }
            .stat-box {
                padding: 8px 6px !important;
            }
            .stat-value {
                font-size: 13px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F8F5F6;">
    @php
        $namaPengambil = $receipt['nama_pengambil'] ?? (str_contains($receipt['recipient'] ?? '', '(') ? trim(explode('(', $receipt['recipient'])[0]) : ($receipt['recipient'] ?? '-'));
        $bagianPengambil = $receipt['divisi'] ?? ($receipt['bagian'] ?? (preg_match('/\((.*?)\)/', $receipt['recipient'] ?? '', $m) ? $m[1] : '-'));
        $items = !empty($receipt['items']) && is_array($receipt['items']) ? $receipt['items'] : [];
    @endphp

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="mobile-wrapper" style="width: 100%; background-color: #F8F5F6; padding: 20px 10px;">
        <tr>
            <td align="center" style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="mobile-container" style="max-width: 600px; width: 100%; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; border: 1px solid #F0DDE2; box-shadow: 0 4px 16px rgba(180, 106, 114, 0.08);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" class="mobile-header" style="background: linear-gradient(135deg, #3D2227 0%, #B46A72 100%); padding: 24px 20px; color: #FFFFFF; text-align: center;">
                            <div style="font-size: 10.5px; letter-spacing: 1.5px; text-transform: uppercase; color: #F7C8D3; margin-bottom: 4px; font-weight: 700;">
                                PT PLN INDONESIA POWER &bull; UBP ASAM ASAM
                            </div>
                            <h1 style="font-size: 18px; font-weight: 800; margin: 0; letter-spacing: 0.3px; color: #FFFFFF; line-height: 1.3;">
                                BUKTI RESI PENGAMBILAN BARANG
                            </h1>
                            <div style="display: inline-block; margin-top: 8px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35); border-radius: 20px; padding: 3px 12px; font-size: 11px; font-weight: 600; color: #FFFFFF;">
                                Sistem Persediaan ATK &bull; Notifikasi Otomatis
                            </div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="mobile-content" style="padding: 24px 22px;">
                            
                            <!-- Card Data Pengambil -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; background-color: #FFF5F7; border: 1px dashed #B46A72; border-radius: 10px; margin-bottom: 22px;">
                                <tr>
                                    <td style="padding: 14px 16px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                            <tr>
                                                <td style="padding: 4px 0; font-size: 12px; color: #7E5B62; width: 36%; vertical-align: top; font-weight: 500;">
                                                    Waktu Pencatatan
                                                </td>
                                                <td style="padding: 4px 0; font-size: 12px; color: #3D2227; font-weight: 700; width: 64%; vertical-align: top;">
                                                    {{ $receipt['date'] ?? now()->translatedFormat('d F Y, H:i') . ' WITA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; font-size: 12px; color: #7E5B62; vertical-align: top; font-weight: 500;">
                                                    Nama Pengambil
                                                </td>
                                                <td style="padding: 4px 0; font-size: 13px; color: #3D2227; font-weight: 700; vertical-align: top;">
                                                    {{ $namaPengambil }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; font-size: 12px; color: #7E5B62; vertical-align: top; font-weight: 500;">
                                                    Bagian / Divisi
                                                </td>
                                                <td style="padding: 4px 0; font-size: 13px; color: #3D2227; font-weight: 700; vertical-align: top;">
                                                    {{ $bagianPengambil }}
                                                </td>
                                            </tr>
                                            @if (!empty($receipt['description']))
                                            <tr>
                                                <td style="padding: 4px 0; font-size: 12px; color: #7E5B62; vertical-align: top; font-weight: 500;">
                                                    Keperluan / Ket.
                                                </td>
                                                <td style="padding: 4px 0; font-size: 12px; color: #5C3840; font-weight: 500; vertical-align: top;">
                                                    {{ $receipt['description'] }}
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Section Title -->
                            <div style="font-size: 13.5px; font-weight: 800; color: #3D2227; margin-bottom: 12px; display: flex; align-items: center;">
                                <span>Daftar Material yang Diambil ({{ count($items) > 0 ? count($items) : 1 }} Jenis Barang):</span>
                            </div>

                            <!-- List Material Cards (Responsif untuk Layar HP & Desktop) -->
                            @if (count($items) > 0)
                                @foreach ($items as $idx => $item)
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; background-color: #FFFFFF; border: 1px solid #F0DDE2; border-radius: 8px; margin-bottom: 12px; overflow: hidden;">
                                        <!-- Header Item: No, Nama, dan Kode -->
                                        <tr>
                                            <td style="padding: 10px 14px 8px 14px; background-color: #FCF9FA; border-bottom: 1px solid #F4E8EB;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                                    <tr>
                                                        <td style="vertical-align: top;">
                                                            <span style="display: inline-block; background-color: #B46A72; color: #FFFFFF; font-size: 11px; font-weight: 700; border-radius: 4px; padding: 2px 7px; margin-right: 6px; vertical-align: middle;">
                                                                #{{ $idx + 1 }}
                                                            </span>
                                                            <strong style="font-size: 13.5px; color: #3D2227; vertical-align: middle; word-break: break-word;">
                                                                {{ $item['material_name'] }}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 5px;">
                                                            <span style="font-size: 11.5px; color: #7E5B62;">Kode / No. Material:</span>
                                                            <code style="font-family: monospace; font-size: 12px; font-weight: 700; color: #3D2227; background-color: #F3E7EA; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">
                                                                {{ !empty($item['material_number']) && $item['material_number'] !== '-' ? $item['material_number'] : '-' }}
                                                            </code>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Detail Angka: Jumlah Diambil & Sisa Stok (2 Box Sejajar Responsif) -->
                                        <tr>
                                            <td style="padding: 10px 12px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                                    <tr>
                                                        <td width="50%" style="width: 50%; padding-right: 5px; vertical-align: top;">
                                                            <div class="stat-box" style="background-color: #FFF0F3; border: 1px solid #F7C8D3; border-radius: 6px; padding: 8px 8px; text-align: center;">
                                                                <div style="font-size: 10.5px; color: #7E5B62; text-transform: uppercase; font-weight: 600; letter-spacing: 0.3px; margin-bottom: 2px;">
                                                                    Jumlah Diambil
                                                                </div>
                                                                <div class="stat-value" style="font-size: 14px; font-weight: 800; color: #B46A72;">
                                                                    {{ $item['qty_out'] }} {{ $item['unit'] }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="50%" style="width: 50%; padding-left: 5px; vertical-align: top;">
                                                            <div class="stat-box" style="background-color: #F8F9FA; border: 1px solid #E5E7EB; border-radius: 6px; padding: 8px 8px; text-align: center;">
                                                                <div style="font-size: 10.5px; color: #6B7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.3px; margin-bottom: 2px;">
                                                                    Sisa Stok Terkini
                                                                </div>
                                                                <div class="stat-value" style="font-size: 14px; font-weight: 800; color: #3D2227;">
                                                                    {{ $item['remaining_stock'] }} {{ $item['unit'] }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach
                            @else
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; background-color: #FFFFFF; border: 1px solid #F0DDE2; border-radius: 8px; margin-bottom: 12px; overflow: hidden;">
                                    <tr>
                                        <td style="padding: 10px 14px 8px 14px; background-color: #FCF9FA; border-bottom: 1px solid #F4E8EB;">
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                        <span style="display: inline-block; background-color: #B46A72; color: #FFFFFF; font-size: 11px; font-weight: 700; border-radius: 4px; padding: 2px 7px; margin-right: 6px; vertical-align: middle;">
                                                            #1
                                                        </span>
                                                        <strong style="font-size: 13.5px; color: #3D2227; vertical-align: middle; word-break: break-word;">
                                                            {{ $receipt['material_name'] ?? '-' }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 5px;">
                                                        <span style="font-size: 11.5px; color: #7E5B62;">Kode / No. Material:</span>
                                                        <code style="font-family: monospace; font-size: 12px; font-weight: 700; color: #3D2227; background-color: #F3E7EA; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">
                                                            {{ !empty($receipt['material_number']) && $receipt['material_number'] !== '-' ? $receipt['material_number'] : '-' }}
                                                        </code>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 12px;">
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                                <tr>
                                                    <td width="50%" style="width: 50%; padding-right: 5px; vertical-align: top;">
                                                        <div class="stat-box" style="background-color: #FFF0F3; border: 1px solid #F7C8D3; border-radius: 6px; padding: 8px 8px; text-align: center;">
                                                            <div style="font-size: 10.5px; color: #7E5B62; text-transform: uppercase; font-weight: 600; letter-spacing: 0.3px; margin-bottom: 2px;">
                                                                Jumlah Diambil
                                                            </div>
                                                            <div class="stat-value" style="font-size: 14px; font-weight: 800; color: #B46A72;">
                                                                {{ $receipt['qty_out'] ?? 0 }} {{ $receipt['unit'] ?? 'Unit' }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="50%" style="width: 50%; padding-left: 5px; vertical-align: top;">
                                                        <div class="stat-box" style="background-color: #F8F9FA; border: 1px solid #E5E7EB; border-radius: 6px; padding: 8px 8px; text-align: center;">
                                                            <div style="font-size: 10.5px; color: #6B7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.3px; margin-bottom: 2px;">
                                                                Sisa Stok Terkini
                                                            </div>
                                                            <div class="stat-value" style="font-size: 14px; font-weight: 800; color: #3D2227;">
                                                                {{ $receipt['remaining_stock'] ?? 0 }} {{ $receipt['unit'] ?? 'Unit' }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- Catatan Sistem -->
                            <div style="background-color: #F8F9FA; border-left: 4px solid #B46A72; padding: 12px 14px; border-radius: 4px; font-size: 11.5px; color: #5C3840; margin-top: 16px; line-height: 1.5;">
                                <strong>Pemberitahuan Sistem:</strong> Pengambilan barang di atas telah diverifikasi dan stok pada sistem inventori otomatis dikurangi sesuai jumlah pengambilan. Bukti resi ini diterbitkan sebagai bukti transaksi yang sah.
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #FCF9FA; border-top: 1px solid #F0DDE2; padding: 18px 20px; text-align: center; font-size: 11px; color: #8C6F75;">
                            <p style="margin: 0 0 3px 0; font-weight: 700; color: #5C3840;">PT PLN INDONESIA POWER UBP ASAM ASAM</p>
                            <p style="margin: 0 0 10px 0; color: #7E5B62;">Sistem Pengelolaan Persediaan ATK &bull; Otomasi Pengambilan Mandiri</p>
                            <div style="border-top: 1px dashed #E5D0D5; padding-top: 10px; font-size: 10.5px; color: #7E5B62; line-height: 1.4;">
                                Salinan bukti resi ini diteruskan secara otomatis ke:<br>
                                <strong>Admin Keuangan</strong> (finance.inventori@gmail.com)<br>
                                <strong>Admin Inventori</strong> (admin.inventoripln@gmail.com)<br>
                                <strong>General</strong> (general.inventoripln@gmail.com)
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
