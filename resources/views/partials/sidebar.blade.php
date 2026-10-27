{{-- ============================================================
     KOMPONEN SIDEBAR UTAMA & FAST-PAGE TRANSITION ENGINE
     Cukup panggil: @include('partials.sidebar') di setiap halaman
     ============================================================ --}}

{{-- Top Progress Bar saat pindah halaman --}}
<div id="sidebarProgressBar" class="sidebar-progress-bar"></div>

{{-- Backdrop Mobile --}}
<div class="drawer-backdrop" id="drawerBackdrop" onclick="closeSidebar()" aria-hidden="true"></div>

{{-- Sidebar Navigation --}}
<aside class="sidebar" id="sidebar" aria-label="Navigasi Utama">

    <!-- Logo PLN & Close Button Mobile -->
    <div class="sidebar-logo">
        <a href="{{ route('dashboard') }}" class="sidebar-brand-link" title="Dashboard Inventori Material">
            <img 
                src="{{ asset('images/logo-pln.png') }}" 
                alt="Logo PLN"
                class="sidebar-logo-image"
                loading="eager"
            >
            <div class="sidebar-logo-text">
                <h1>SISTEM PERSEDIAAN ATK</h1>
                <p>PT PLN Indonesia Power UBP Asam Asam</p>
            </div>
        </a>
        <button type="button" class="sidebar-close-btn" onclick="closeSidebar()" aria-label="Tutup Menu">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- User Profile Card -->
    <a href="{{ route('profile.show') }}" class="sidebar-user" title="Buka Profil Pengguna" data-spa-link>
        <div class="sidebar-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name" title="{{ Auth::user()->name ?? 'Pengguna' }}">
                {{ Auth::user()->name ?? 'Pengguna' }}
            </div>
            <div class="sidebar-user-role">
                {{ Auth::user()->role ?? 'User' }}
            </div>
        </div>
    </a>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">speed</span>
            <span>Dashboard</span>
        </a>

        @if(Auth::user()->role !== 'Pengelola Buku')
        <!-- Data Material (Parent Menu with Submenu) -->
        <div class="nav-group {{ (request()->routeIs('materials.*') || request()->is('materials*')) ? 'open' : '' }}" id="navGroupMaterials">
            <button type="button" 
                    class="nav-item nav-parent {{ (request()->routeIs('materials.*') || request()->is('materials*')) ? 'active-parent' : '' }}" 
                    id="btnToggleMaterials"
                    onclick="toggleMaterialSubmenu(event)"
                    aria-expanded="{{ (request()->routeIs('materials.*') || request()->is('materials*')) ? 'true' : 'false' }}"
                    title="Buka / Tutup Submenu Data Material">
                <div class="nav-parent-title">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span>Data Material</span>
                </div>
                <span class="material-symbols-outlined nav-arrow">expand_more</span>
            </button>
            <div class="nav-submenu" id="materialSubmenu">
                <!-- Master Data Material -->
                <a href="{{ route('materials.index') }}" 
                   class="nav-subitem {{ (request()->routeIs('materials.*') && !request()->routeIs('materials.stock-in.*') && !request()->is('materials/stock-in*') && !request()->routeIs('materials.stock-out.*') && !request()->is('materials/stock-out*')) ? 'active' : '' }}"
                   data-spa-link>
                    <span class="material-symbols-outlined">format_list_bulleted</span>
                    <span>Daftar Material</span>
                </a>

                <!-- Submenu Stok Masuk -->
                <a href="{{ route('materials.stock-in.index') }}" 
                   class="nav-subitem {{ (request()->routeIs('materials.stock-in.*') || request()->is('materials/stock-in*')) ? 'active' : '' }}"
                   data-spa-link>
                    <span class="material-symbols-outlined">add_circle</span>
                    <span>Stok Masuk</span>
                </a>

                <!-- Submenu Stok Keluar -->
                <a href="{{ route('materials.stock-out.index') }}" 
                   class="nav-subitem {{ (request()->routeIs('materials.stock-out.*') || request()->is('materials/stock-out*')) ? 'active' : '' }}"
                   data-spa-link>
                    <span class="material-symbols-outlined">do_not_disturb_on</span>
                    <span>Stok Keluar</span>
                </a>
            </div>
        </div>

        <!-- Riwayat Stok -->
        <a href="{{ route('stock-movements.index') }}"
           class="nav-item {{ request()->routeIs('stock-movements.*') || request()->is('stock-history*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">history</span>
            <span>Riwayat Stok</span>
        </a>    

        <!-- Analisis Material -->
        <a href="{{ route('material-analysis.index') }}" 
           class="nav-item {{ request()->routeIs('material-analysis.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">analytics</span>
            <span>Analisis Material</span>
        </a>
        @endif

        @if(in_array(Auth::user()->role, ['Admin', 'Pengelola Buku']))
        <div class="nav-section-title" style="margin-top:14px;">Manajemen Buku</div>

        <!-- Data Buku & Stok -->
        <a href="{{ route('books.index') }}" 
           class="nav-item {{ request()->routeIs('books.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">menu_book</span>
            <span>Data Buku &amp; Stok</span>
        </a>

        <!-- Transaksi Peminjaman & Pengembalian Buku -->
        <a href="{{ route('book-loans.index') }}" 
           class="nav-item {{ request()->routeIs('book-loans.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">assignment</span>
            <span>Peminjaman &amp; Pengembalian</span>
        </a>
        @endif

        @if(Auth::user()->role === 'Admin')
        <div class="nav-section-title" style="margin-top:14px;">Administrasi Sistem</div>

        <!-- Manajemen Pengguna -->
        <a href="{{ route('users.index') }}" 
           class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">manage_accounts</span>
            <span>Manajemen User</span>
        </a>
        @endif

        <div class="nav-section-title" style="margin-top:14px;">Akun</div>

        <!-- Profile -->
        <a href="{{ route('profile.show') }}" 
           class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">account_circle</span>
            <span>Profile</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin:0;" id="logoutForm">
            @csrf
            <button type="button" class="btn-logout" title="Keluar dari akun"
                    onclick="openLogoutModal()">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar (Logout)</span>
            </button>
        </form>
    </div>

</aside>

{{-- Toast Notifikasi Halus --}}
<div id="sidebarToast" class="sidebar-toast" role="alert" aria-live="polite">
    <span class="material-symbols-outlined sidebar-toast-icon">info</span>
    <span id="sidebarToastMsg" class="sidebar-toast-msg"></span>
</div>

{{-- Popup Konfirmasi Logout --}}
<div id="logoutModal" class="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
    <div class="logout-modal-box">
        <div class="logout-modal-icon">
            <span class="material-symbols-outlined">logout</span>
        </div>
        <h3 id="logoutModalTitle">Keluar dari Akun?</h3>
        <p>Anda akan keluar dari sistem. Pastikan semua pekerjaan sudah tersimpan sebelum melanjutkan.</p>
        <div class="logout-modal-actions">
            <button type="button" class="logout-modal-cancel" onclick="closeLogoutModal()">
                Batal
            </button>
            <button type="button" class="logout-modal-confirm" onclick="document.getElementById('logoutForm').submit()">
                <span class="material-symbols-outlined" style="font-size:17px;">logout</span>
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

{{-- CSS Terpusat & Anti-Ngesot / Anti-Patah --}}
<style id="sidebar-styles">
    :root {
        --sidebar-w: 260px;
        --sidebar-rosewood: #B46A72;
        --sidebar-blush: #F7C8D3;
        --sidebar-dark: #3D2227;
        --sidebar-muted: #7E5B62;
        --sidebar-border: #F2E0E4;
        --sidebar-bg: #FFFFFF;
    }

    /* ============================================================
       YOUTUBE-STYLE TOP LOADING PROGRESS BAR (Blush & Rosewood)
    ============================================================ */
    .sidebar-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, #F7C8D3 0%, #B46A72 50%, #F7C8D3 100%);
        background-size: 200% 100%;
        z-index: 999999;
        pointer-events: none;
        opacity: 0;
        transition: width 0.22s cubic-bezier(0.1, 0.85, 0.25, 1), opacity 0.2s ease;
        box-shadow: 0 0 10px rgba(247, 200, 211, 0.9), 0 0 4px rgba(180, 106, 114, 0.6);
    }
    .sidebar-progress-bar.active {
        opacity: 1;
        animation: ytProgressShimmer 1.4s infinite linear;
    }
    .sidebar-progress-bar.finish {
        width: 100% !important;
        opacity: 0;
        transition: width 0.12s ease-out, opacity 0.25s ease-out 0.12s;
    }
    @keyframes ytProgressShimmer {
        0% { background-position: 100% 0; }
        100% { background-position: -100% 0; }
    }

    /* Stabilisasi Scrollbar & Anti-Goyang Antar Halaman */
    html {
        overflow-y: scroll;
        scrollbar-gutter: stable;
    }

    body,
    .layout,
    .sidebar,
    .main {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    button,
    input,
    select,
    textarea {
        font-family: inherit;
    }

    /* Layout Wrapper Global */
    .layout {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* Transisi Halus Area Main (Sidebar tetap diam 100%) */
    .main {
        transition: opacity 0.08s ease;
    }

    /* Container Sidebar (Putih Dominan dengan Aksen Blush & Rosewood) */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: var(--sidebar-w);
        background: #FFFFFF;
        color: #3D2227;
        border-right: 1px solid #F2E0E4;
        display: flex;
        flex-direction: column;
        padding: 0;
        z-index: 999;
        box-shadow: 2px 0 16px rgba(180, 106, 114, 0.06);
        user-select: none;
        -webkit-user-select: none;
        /* Default: jangan ada transition transform agar tidak ngesot/bergerak di desktop */
        transform: none;
        transition: none;
    }

    /* PENTING: Kunci posisi di Desktop & Laptop (>992px) agar tidak bergerak/ngesot saat load */
    @media (min-width: 993px) {
        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            width: var(--sidebar-w) !important;
            transform: none !important;
            transition: none !important;
        }
        .main {
            margin-left: var(--sidebar-w) !important;
            transition: none !important;
        }
        .btn-hamburger {
            display: none !important;
        }
    }

    /* Kunci Ukuran Icon agar TIDAK PATAH-PATAH / TIDAK MELONCAT saat font dimuat */
    .sidebar .material-symbols-outlined {
        width: 24px;
        height: 24px;
        min-width: 24px;
        min-height: 24px;
        font-size: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        line-height: 1;
        text-align: center;
        vertical-align: middle;
        user-select: none;
    }

    /* Logo & Header */
    .sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 18px;
        border-bottom: 1px solid #F5E8EB;
        height: 68px;
        box-sizing: border-box;
    }

    .sidebar-brand-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
        min-width: 0;
        flex: 1;
    }

    .sidebar-logo-image {
        width: 38px;
        height: 38px;
        max-width: 38px;
        max-height: 38px;
        object-fit: contain;
        flex-shrink: 0;
        display: block;
    }

    .sidebar-logo-text {
        min-width: 0;
    }

    .sidebar-logo-text h1 {
        margin: 0;
        font-size: 13px;
        font-weight: 800;
        color: #3D2227;
        line-height: 1.2;
        letter-spacing: 0.02em;
    }

    .sidebar-logo-text p {
        margin: 2px 0 0;
        font-size: 11px;
        color: #7E5B62;
        line-height: 1.2;
    }

    /* Tombol Close di Layar HP */
    .sidebar-close-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #FDF2F4;
        border: none;
        color: #3D2227;
        cursor: pointer;
        transition: background 0.15s ease;
        touch-action: manipulation;
    }

    .sidebar-close-btn:hover {
        background: #F7C8D3;
        color: #3D2227;
    }

    /* User Card */
    .sidebar-user {
        margin: 14px 14px 6px;
        padding: 11px 12px;
        background: #FDF5F7;
        border: 1px solid #F2E0E4;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 11px;
        text-decoration: none;
        color: inherit;
        transition: all 0.15s ease;
        cursor: pointer;
    }
    .sidebar-user:hover {
        background: #FDE8ED;
        border-color: #F7C8D3;
    }

    .sidebar-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        min-height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #B46A72 0%, #D88F97 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(180, 106, 114, 0.25);
        border: 2px solid #F7C8D3;
    }

    .sidebar-user-info {
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }

    .sidebar-user-name {
        font-size: 13px;
        font-weight: 700;
        color: #3D2227;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role {
        font-size: 10px;
        font-weight: 700;
        color: #B46A72;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }

    /* Navigation Items */
    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px 12px;
        scrollbar-width: thin;
        scrollbar-color: rgba(180, 106, 114, 0.2) transparent;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(180, 106, 114, 0.2);
        border-radius: 4px;
    }

    .nav-section-title {
        font-size: 10px;
        font-weight: 700;
        color: #9C7981;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 8px 8px 5px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 12px;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 500;
        color: #5C3D43;
        text-decoration: none;
        margin-bottom: 3px;
        transition: background 0.12s ease, color 0.12s ease;
        touch-action: manipulation;
        cursor: pointer;
        position: relative;
    }

    .nav-item:hover {
        background: #FDF2F4;
        color: #B46A72;
    }

    .nav-item:active {
        background: #FDE8ED;
    }

    .nav-item.active {
        background: linear-gradient(135deg, #F7C8D3 0%, #F5BCC9 100%);
        color: #3D2227;
        font-weight: 800;
        box-shadow: 0 3px 10px rgba(180, 106, 114, 0.2);
        border-left: 4px solid #B46A72;
    }

    .nav-item.active:hover {
        background: #F5BCC9;
        color: #3D2227;
    }

    /* ============================================================
       SUBMENU NAVIGATION (DATA MATERIAL -> STOK MASUK)
    ============================================================ */
    .nav-group {
        margin-bottom: 3px;
    }

    .nav-parent {
        width: 100%;
        border: none;
        background: transparent;
        font-family: inherit;
        text-align: left;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
    }

    .nav-parent-title {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .nav-parent .nav-arrow {
        font-size: 19px !important;
        width: 20px !important;
        height: 20px !important;
        min-width: 20px !important;
        min-height: 20px !important;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        color: #8C656C;
    }

    .nav-group.open .nav-parent .nav-arrow {
        transform: rotate(180deg);
        color: #B46A72;
    }

    .nav-item.active-parent {
        background: #FDF2F4;
        color: #B46A72;
        font-weight: 700;
    }

    .nav-submenu {
        display: none;
        flex-direction: column;
        padding-left: 18px;
        margin: 2px 0 6px 10px;
        border-left: 2px solid #F7C8D3;
        gap: 2px;
    }

    .nav-group.open .nav-submenu {
        display: flex;
        animation: submenuSlideDown 0.18s ease-out;
    }

    @keyframes submenuSlideDown {
        from {
            opacity: 0;
            transform: translateY(-4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nav-subitem {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 500;
        color: #6E4D53;
        text-decoration: none;
        transition: background 0.12s ease, color 0.12s ease;
        touch-action: manipulation;
    }

    .nav-subitem .material-symbols-outlined {
        font-size: 17px !important;
        width: 18px !important;
        height: 18px !important;
        min-width: 18px !important;
        min-height: 18px !important;
    }

    .nav-subitem:hover {
        background: #FDF2F4;
        color: #B46A72;
    }

    .nav-subitem.active {
        background: #F7C8D3;
        color: #3D2227;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(180, 106, 114, 0.15);
        border-left: 3px solid #B46A72;
    }

    .nav-subitem.active:hover {
        background: #F5BCC9;
        color: #3D2227;
    }

    /* Footer & Logout */
    .sidebar-footer {
        padding: 12px 14px;
        border-top: 1px solid #F5E8EB;
    }

    .btn-logout {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 9px;
        border: 1px solid rgba(180, 106, 114, 0.25);
        background: #FFF5F6;
        color: #B46A72;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
        touch-action: manipulation;
        font-family: inherit;
    }

    .btn-logout:hover {
        background: #B46A72;
        color: #ffffff;
    }

    .btn-logout:active {
        background: #9C545C;
    }

    /* Backdrop Mobile */
    .drawer-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.48);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 990;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.22s ease;
    }

    .drawer-backdrop.open {
        opacity: 1;
        pointer-events: auto;
    }

    /* Toast Notification */
    .sidebar-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        background: #1E293B;
        color: #ffffff;
        border-left: 4px solid var(--sidebar-yellow);
        border-radius: 10px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
        font-size: 13.5px;
        font-weight: 500;
        transform: translateY(-24px);
        opacity: 0;
        pointer-events: none;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
    }

    .sidebar-toast.show {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    .sidebar-toast-icon {
        color: var(--sidebar-yellow);
        font-size: 20px;
        flex-shrink: 0;
    }

    /* ============================================================
       POPUP KONFIRMASI LOGOUT
    ============================================================ */
    .logout-modal {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.52);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        padding: 20px;
    }

    .logout-modal.show {
        display: flex;
        animation: logoutModalFadeIn 0.18s ease-out;
    }

    @keyframes logoutModalFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .logout-modal-box {
        width: 100%;
        max-width: 380px;
        background: #fff;
        border-radius: 16px;
        padding: 30px 26px 24px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
        text-align: center;
        animation: logoutBoxIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes logoutBoxIn {
        from { opacity: 0; transform: scale(0.94) translateY(10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .logout-modal-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #FEE2E2;
        color: #DC2626;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .logout-modal-icon .material-symbols-outlined {
        font-size: 28px;
    }

    .logout-modal-box h3 {
        font-size: 18px;
        font-weight: 800;
        color: #1F2937;
        margin: 0 0 8px;
    }

    .logout-modal-box p {
        font-size: 13px;
        color: #6B7280;
        line-height: 1.6;
        margin: 0 0 22px;
    }

    .logout-modal-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .logout-modal-cancel {
        flex: 1;
        height: 40px;
        border-radius: 9px;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        color: #374151;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s ease, border-color 0.15s ease;
    }

    .logout-modal-cancel:hover {
        background: #F1F5F9;
        border-color: #CBD5E1;
    }

    .logout-modal-confirm {
        flex: 1;
        height: 40px;
        border-radius: 9px;
        border: none;
        background: #DC2626;
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s ease;
    }

    .logout-modal-confirm:hover {
        background: #B91C1C;
    }

    /* Transisi Halus Konten Utama (SPA) */
    .main {
        transition: opacity 0.08s ease-in-out;
    }

    /* Responsif Mobile & Tablet (Max 992px) */
    @media (max-width: 992px) {
        .layout {
            display: block;
            width: 100%;
        }

        .main {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .sidebar {
            width: min(280px, 86vw) !important;
            transform: translate3d(-100%, 0, 0) !important;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: none !important;
        }

        .sidebar.open {
            transform: translate3d(0, 0, 0) !important;
            box-shadow: 4px 0 28px rgba(0, 0, 0, 0.3) !important;
        }

        .sidebar-close-btn {
            display: flex;
        }

        .btn-hamburger {
            display: flex !important;
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            width: 85vw !important;
        }
        .logout-modal-box {
            padding: 24px 18px 20px;
        }
        .logout-modal-actions {
            flex-direction: column-reverse;
        }
        .logout-modal-cancel,
        .logout-modal-confirm {
            width: 100%;
        }
    }

    /* ============================================================
       GLOBAL THEME: BLUSH PETAL (#F7C8D3), ROSEWOOD (#B46A72), DOMINANT WHITE
       - Dominant background: #FCF9FA / #FFFFFF
       - Primary accent: Blush Petal #F7C8D3
       - Secondary accent: Rosewood #B46A72
       - Font headings & dark text: #3D2227 (High contrast, readable)
       - Font body: #4D2C32
       - Font muted: #7E5B62
       - Border: #F2E0E4
    ============================================================ */
    body {
        background-color: #FCF9FA !important;
        color: #4D2C32 !important;
    }

    /* Topbar */
    .topbar {
        background-color: #FFFFFF !important;
        border-bottom: 1px solid #F2E0E4 !important;
        box-shadow: 0 1px 6px rgba(180, 106, 114, 0.04) !important;
    }
    .topbar-left h1 {
        color: #3D2227 !important;
    }
    .topbar-left p {
        color: #7E5B62 !important;
    }
    .topbar-avatar {
        background: linear-gradient(135deg, #B46A72 0%, #D88F97 100%) !important;
        color: #ffffff !important;
        border: 2px solid #F7C8D3 !important;
    }
    .topbar-user {
        background: #FDF5F7 !important;
        border: 1px solid #F2E0E4 !important;
    }
    .topbar-user:hover {
        background: #FDE8ED !important;
    }
    .topbar-user-name {
        color: #3D2227 !important;
    }

    /* Primary buttons */
    .btn-primary,
    .btn-submit,
    .action-btn-primary {
        background: linear-gradient(135deg, #B46A72 0%, #9C545C 100%) !important;
        border: 1px solid #8E474F !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(180, 106, 114, 0.28) !important;
    }
    .btn-primary:hover,
    .btn-submit:hover,
    .action-btn-primary:hover {
        background: linear-gradient(135deg, #F7C8D3 0%, #F5BCC9 100%) !important;
        border-color: #E6A8B5 !important;
        color: #3D2227 !important;
        box-shadow: 0 6px 16px rgba(180, 106, 114, 0.22) !important;
    }

    /* Yellow / Blush Accent buttons */
    .btn-yellow,
    .btn-warning,
    .action-btn-yellow {
        background: linear-gradient(135deg, #F7C8D3 0%, #F5BCC9 100%) !important;
        border: 1px solid #E6A8B5 !important;
        color: #3D2227 !important;
    }
    .btn-yellow:hover,
    .btn-warning:hover,
    .action-btn-yellow:hover {
        background: linear-gradient(135deg, #B46A72 0%, #9C545C 100%) !important;
        border-color: #8E474F !important;
        color: #ffffff !important;
    }
    .action-btn-yellow .action-icon {
        background: rgba(61, 34, 39, 0.1) !important;
        color: #3D2227 !important;
    }

    /* Action buttons white */
    .action-btn-white {
        background: #ffffff !important;
        border: 1px solid #F2E0E4 !important;
        color: #3D2227 !important;
    }
    .action-btn-white .action-icon {
        background: #FDF2F4 !important;
        color: #B46A72 !important;
    }

    /* Tables */
    table thead th,
    .data-table thead th {
        background: #FAF0F3 !important;
        color: #3D2227 !important;
        border: 1px solid #F2E0E4 !important;
        font-weight: 700 !important;
    }
    table tbody tr:hover,
    .data-table tbody tr:hover {
        background: #FDF5F7 !important;
    }
    table tbody td,
    .data-table tbody td {
        border-bottom: 1px solid #F5EAEB !important;
        color: #4D2C32 !important;
    }

    /* Cards */
    .card,
    .section-card,
    .stat-card {
        background: #ffffff !important;
        border: 1px solid #F2E0E4 !important;
        box-shadow: 0 2px 10px rgba(180, 106, 114, 0.05) !important;
    }
    .section-card-header {
        border-bottom-color: #F5EAEB !important;
    }
    .section-card-title,
    .card-title {
        color: #3D2227 !important;
    }
    .stat-card-value {
        color: #3D2227 !important;
    }
    .stat-card-label {
        color: #7E5B62 !important;
    }
    .stat-card-bar.blue {
        background: #B46A72 !important;
    }
    .stat-card-bar.yellow {
        background: #F7C8D3 !important;
    }
    .stat-icon-blue {
        background: #FDF2F4 !important;
        color: #B46A72 !important;
    }
    .stat-icon-yellow {
        background: #FDE8ED !important;
        color: #B46A72 !important;
    }

    /* Badges & Pills */
    .badge-role {
        background: #FDF2F4 !important;
        color: #B46A72 !important;
        border: 1px solid #F7C8D3 !important;
    }
    .badge-blue,
    .badge-tambah,
    .badge-info,
    .badge-import {
        background: #FDF2F4 !important;
        color: #B46A72 !important;
        border: 1px solid #F7C8D3 !important;
    }
    .badge-edit {
        background: #F7C8D3 !important;
        color: #3D2227 !important;
        border: 1px solid #EAAAB9 !important;
    }

    /* Inputs, Selects, Textareas */
    input:focus,
    select:focus,
    textarea:focus {
        border-color: #B46A72 !important;
        box-shadow: 0 0 0 3.5px rgba(247, 200, 211, 0.45) !important;
    }

    /* Links & Icons */
    a.btn-lihat-semua,
    .text-primary,
    .link-primary {
        color: #B46A72 !important;
    }
    a.btn-lihat-semua:hover {
        background: #FDF2F4 !important;
        color: #3D2227 !important;
    }

    /* Welcome Card (Dashboard) */
    .welcome-card {
        background: linear-gradient(135deg, #FFF0F3 0%, #FDE2E7 50%, #F7C8D3 100%) !important;
        border: 1px solid #F2CCD4 !important;
        box-shadow: 0 8px 24px rgba(180, 106, 114, 0.12) !important;
        color: #3D2227 !important;
    }
    .welcome-card h2 {
        color: #3D2227 !important;
    }
    .welcome-card p {
        color: #6E4D53 !important;
    }
    .welcome-date-badge {
        background: rgba(180, 106, 114, 0.12) !important;
        color: #3D2227 !important;
    }
    .welcome-status {
        background: rgba(180, 106, 114, 0.12) !important;
        color: #3D2227 !important;
    }
    .welcome-role-badge {
        background: #B46A72 !important;
        color: #ffffff !important;
        border: 1px solid #8E474F !important;
        box-shadow: 0 3px 10px rgba(180, 106, 114, 0.3) !important;
    }
</style>

{{-- Script Global, Anti-Lelet & Seamless Page Swapper --}}
<script id="sidebar-scripts">
    // --- Mobile Drawer Toggle ---
    window.openSidebar = function () {
        const sidebar = document.getElementById('sidebar');
        const backdrops = document.querySelectorAll('.drawer-backdrop');
        if (sidebar) sidebar.classList.add('open');
        backdrops.forEach(b => b.classList.add('open'));
        document.body.style.overflow = 'hidden';
    };

    window.closeSidebar = function () {
        const sidebar = document.getElementById('sidebar');
        const backdrops = document.querySelectorAll('.drawer-backdrop');
        if (sidebar) sidebar.classList.remove('open');
        backdrops.forEach(b => b.classList.remove('open'));
        document.body.style.overflow = '';
    };

    // --- Logout Modal ---
    window.openLogoutModal = function () {
        const m = document.getElementById('logoutModal');
        if (m) {
            m.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeLogoutModal = function () {
        const m = document.getElementById('logoutModal');
        if (m) {
            m.classList.remove('show');
            document.body.style.overflow = '';
        }
    };

    // Klik di luar kotak modal logout untuk tutup
    document.addEventListener('click', function (e) {
        const m = document.getElementById('logoutModal');
        if (m && m.classList.contains('show') && e.target === m) {
            window.closeLogoutModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            window.closeLogoutModal();
            window.closeSidebar();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            window.closeSidebar();
        }
    });

    // --- Submenu Data Material Toggle (Buka/Tutup) ---
    window.toggleMaterialSubmenu = function (e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const group = document.getElementById('navGroupMaterials');
        if (!group) return;
        const isCurrentlyOpen = group.classList.contains('open');
        if (isCurrentlyOpen) {
            group.classList.remove('open');
        } else {
            group.classList.add('open');
        }
        const btn = document.getElementById('btnToggleMaterials');
        if (btn) btn.setAttribute('aria-expanded', !isCurrentlyOpen);
    };

    // --- Toast Ringan & Cepat ---
    let _sidebarToastTimer = null;
    window.showSidebarToast = function (msg) {
        const toast = document.getElementById('sidebarToast');
        const toastMsg = document.getElementById('sidebarToastMsg');
        if (!toast || !toastMsg) return;

        toastMsg.textContent = msg;
        toast.classList.add('show');

        if (_sidebarToastTimer) clearTimeout(_sidebarToastTimer);
        _sidebarToastTimer = setTimeout(function () {
            toast.classList.remove('show');
        }, 2500);
    };

    // --- YOUTUBE-STYLE TOP LOADING PROGRESS BAR ENGINE ---
    window.YouTubeProgress = (function () {
        let progressBar = document.getElementById('sidebarProgressBar');
        let timer = null;
        let currentWidth = 0;
        let isRunning = false;

        function getBar() {
            if (!progressBar) progressBar = document.getElementById('sidebarProgressBar');
            return progressBar;
        }

        function setWidth(w) {
            currentWidth = Math.min(100, Math.max(0, w));
            const bar = getBar();
            if (bar) bar.style.width = currentWidth + '%';
        }

        function start() {
            const bar = getBar();
            if (!bar) return;
            if (isRunning) return;
            isRunning = true;

            if (timer) clearInterval(timer);
            bar.classList.remove('finish');
            bar.classList.add('active');
            setWidth(0);

            // Respon secepat kilat ala YouTube (loncat ke ~25%)
            setTimeout(function () {
                if (!isRunning) return;
                setWidth(25);
            }, 25);

            // Animasi trickle halus
            timer = setInterval(function () {
                if (!isRunning) return;
                if (currentWidth < 55) {
                    setWidth(currentWidth + Math.random() * 10 + 4);
                } else if (currentWidth < 82) {
                    setWidth(currentWidth + Math.random() * 5 + 1);
                } else if (currentWidth < 93) {
                    setWidth(currentWidth + 0.4);
                }
            }, 180);
        }

        function done() {
            const bar = getBar();
            if (!bar) return;
            isRunning = false;
            if (timer) clearInterval(timer);
            setWidth(100);
            bar.classList.add('finish');
            setTimeout(function () {
                bar.classList.remove('active');
                setWidth(0);
            }, 350);
        }

        return {
            start: start,
            done: done,
            setWidth: setWidth
        };
    })();

    // Selesaikan bar saat halaman selesai render awal
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        window.YouTubeProgress.done();
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            window.YouTubeProgress.done();
        });
    }

    window.addEventListener('pageshow', function () {
        window.YouTubeProgress.done();
    });

    // --- SIDEBAR DRAWER (Mobile & Tablet) ---
    function openSidebar() {
        const s = document.getElementById('sidebar');
        const d = document.getElementById('drawerBackdrop');
        if (s) s.classList.add('open');
        if (d) d.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        const s = document.getElementById('sidebar');
        const d = document.getElementById('drawerBackdrop');
        if (s) s.classList.remove('open');
        if (d) d.classList.remove('open');
        document.body.style.overflow = '';
    }

    function toggleSubmenu(e, id) {
        if (e && e.preventDefault) e.preventDefault();
        const menu = document.getElementById(id);
        const arrow = document.getElementById('arrow-' + id.replace('submenu-', ''));
        if (!menu) return;
        const isOpen = menu.style.display === 'block';
        menu.style.display = isOpen ? 'none' : 'block';
        if (arrow) arrow.textContent = isOpen ? 'expand_more' : 'expand_less';
    }

    window.openSidebar = openSidebar;
    window.closeSidebar = closeSidebar;
    window.toggleSubmenu = toggleSubmenu;

    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            closeSidebar();
        }
    });

    // --- SEAMLESS INSTANT SPA PAGE ENGINE (SIDEBAR DIAM AJA) ---
    let _navRequestId = 0;
    let _navAbortController = null;

    async function navigatePage(url, push = true, options = {}) {
        if (_navAbortController) {
            try { _navAbortController.abort(); } catch (e) {}
        }
        _navAbortController = new AbortController();
        const currentReqId = ++_navRequestId;

        const isLive = Boolean(options && options.isLiveSearch);

        if (!isLive) {
            window.YouTubeProgress.start();
        }

        try {
            const response = await fetch(url, {
                signal: _navAbortController.signal,
                cache: 'no-cache',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (currentReqId !== _navRequestId) {
                return;
            }

            if (!response.ok) {
                window.location.href = url;
                return;
            }

            const htmlText = await response.text();
            if (currentReqId !== _navRequestId) {
                return;
            }

            const parser = new DOMParser();
            const newDoc = parser.parseFromString(htmlText, 'text/html');

            const newMain = newDoc.querySelector('main.main') || newDoc.querySelector('main');
            const currentMain = document.querySelector('main.main') || document.querySelector('main');

            if (!newMain || !currentMain) {
                window.location.href = url;
                return;
            }

            // Tangkap elemen aktif sebelum penggantian DOM untuk restore focus & cursor
            const activeEl = document.activeElement;
            const isTyping = activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA' || activeEl.tagName === 'SELECT');
            const preserve = (options && options.preserveState) ? options.preserveState : (isTyping ? {
                name: activeEl.getAttribute('name'),
                id: activeEl.id,
                value: activeEl.value,
                selectionStart: activeEl.selectionStart,
                selectionEnd: activeEl.selectionEnd
            } : null);

            // Nilai teks dan posisi kursor langsung dari input yang aktif saat ini
            const liveVal = isTyping ? activeEl.value : (preserve ? preserve.value : null);
            const liveStart = (isTyping && typeof activeEl.selectionStart === 'number') ? activeEl.selectionStart : (preserve ? preserve.selectionStart : null);
            const liveEnd = (isTyping && typeof activeEl.selectionEnd === 'number') ? activeEl.selectionEnd : (preserve ? preserve.selectionEnd : null);

            const applyContentUpdate = () => {
                if (currentReqId !== _navRequestId) {
                    return;
                }

                // 1. Ganti CSS Halaman secara instan jika berbeda
                const newPageStyle = newDoc.getElementById('page-style');
                let currentPageStyle = document.getElementById('page-style');
                if (newPageStyle) {
                    if (currentPageStyle) {
                        if (currentPageStyle.textContent !== newPageStyle.textContent) {
                            currentPageStyle.textContent = newPageStyle.textContent;
                        }
                    } else {
                        const st = document.createElement('style');
                        st.id = 'page-style';
                        st.textContent = newPageStyle.textContent;
                        document.head.appendChild(st);
                    }
                }

                // Salin script library dari head halaman baru jika belum ada (misal Chart.js)
                newDoc.querySelectorAll('head script[src]').forEach(extScript => {
                    const src = extScript.getAttribute('src');
                    if (src && !document.querySelector(`head script[src="${src}"]`)) {
                        const s = document.createElement('script');
                        s.src = src;
                        document.head.appendChild(s);
                    }
                });

                // Sinkronkan class layout wrapper dan main
                const newLayout = newDoc.querySelector('.layout');
                const currentLayout = document.querySelector('.layout');
                if (newLayout && currentLayout && newLayout.className) {
                    currentLayout.className = newLayout.className;
                }
                if (newMain.className) {
                    currentMain.className = newMain.className;
                }

                // 2. Ganti konten main
                currentMain.innerHTML = newMain.innerHTML;

                // Sinkronkan token CSRF di sidebar jika halaman baru memiliki token segar
                const newCsrf = newDoc.querySelector('input[name="_token"]')?.value
                             || newDoc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (newCsrf) {
                    document.querySelectorAll('input[name="_token"]').forEach(input => input.value = newCsrf);
                    const metaCsrf = document.querySelector('meta[name="csrf-token"]');
                    if (metaCsrf) metaCsrf.setAttribute('content', newCsrf);
                }

                // 3. Jalankan ulang script halaman baru
                currentMain.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    Array.from(oldScript.attributes).forEach(attribute => {
                        newScript.setAttribute(attribute.name, attribute.value);
                    });
                    newScript.textContent = oldScript.textContent;
                    oldScript.replaceWith(newScript);
                });

                // Restore active input focus, value, dan posisi kursor secara presisi
                if (preserve && (preserve.name || preserve.id || isLive)) {
                    let restoreTarget = null;
                    if (preserve.id) {
                        restoreTarget = currentMain.querySelector('#' + preserve.id);
                    }
                    if (!restoreTarget && preserve.name) {
                        restoreTarget = currentMain.querySelector(`input[name="${preserve.name}"], textarea[name="${preserve.name}"], select[name="${preserve.name}"]`);
                    }
                    if (!restoreTarget) {
                        restoreTarget = currentMain.querySelector('.search-box input, input[name="search"], #searchInput, #search');
                    }
                    if (restoreTarget) {
                        if (liveVal !== null && restoreTarget.value !== liveVal) {
                            restoreTarget.value = liveVal;
                        }
                        restoreTarget.focus();
                        if (typeof liveStart === 'number' && typeof liveEnd === 'number') {
                            try {
                                restoreTarget.setSelectionRange(liveStart, liveEnd);
                            } catch (e) {}
                        }
                    }
                }

                // 4. Update judul tab browser
                document.title = newDoc.title;

                // 5. Update address bar URL
                if (isLive) {
                    history.replaceState({ url: url }, newDoc.title, url);
                } else if (push) {
                    history.pushState({ url: url }, newDoc.title, url);
                }

                // 6. Update menu aktif di sidebar
                updateSidebarActiveMenu(url);

                if (!isLive) {
                    // 7. Scroll ke paling atas hanya jika navigasi halaman penuh
                    window.scrollTo({ top: 0, behavior: 'instant' });

                    // 8. Tampilkan kembali konten dengan mulus
                    currentMain.style.opacity = '1';

                    // 9. Selesaikan loading bar YouTube
                    window.YouTubeProgress.done();

                    // 10. Jika di HP/tablet, tutup menu drawer
                    if (window.innerWidth <= 992) {
                        closeSidebar();
                    }
                } else {
                    currentMain.style.opacity = '1';
                }

                // 11. Trigger resize & layout recalculation untuk elemen responsif, chart, table
                requestAnimationFrame(() => {
                    window.dispatchEvent(new Event('resize'));
                });

                // 12. Jalankan kembali callback chart jika ada
                if (typeof window.initTimelineChart === 'function') {
                    try {
                        window.initTimelineChart();
                    } catch (e) {
                        console.error('Error executing initTimelineChart:', e);
                    }
                }
                if (typeof window.initAnalysisCharts === 'function') {
                    try {
                        window.initAnalysisCharts();
                    } catch (e) {
                        console.error('Error executing initAnalysisCharts:', e);
                    }
                }
            };

            if (isLive) {
                applyContentUpdate();
            } else {
                currentMain.style.opacity = '0.35';
                setTimeout(applyContentUpdate, 60);
            }

        } catch (err) {
            if (err.name === 'AbortError') {
                return;
            }
            window.location.href = url;
        }
    }

    window.navigatePage = navigatePage;

    // Perbarui highlight warna aktif di sidebar
    function updateSidebarActiveMenu(targetUrlStr) {
        try {
            const targetUrl = new URL(targetUrlStr, window.location.origin);
            const path = targetUrl.pathname;

            // 1. Menu Utama non-group
            document.querySelectorAll('.sidebar-nav > .nav-item:not(.nav-parent)').forEach(item => {
                const href = item.getAttribute('href');
                if (!href || href.startsWith('javascript') || href === '#') return;
                try {
                    const itemUrl = new URL(href, window.location.origin);
                    let isActive = false;

                    if (itemUrl.pathname === '/dashboard' && path === '/dashboard') {
                        isActive = true;
                    } else if ((itemUrl.pathname === '/stock-history' || itemUrl.pathname.startsWith('/stock-movements')) && (path === '/stock-history' || path.startsWith('/stock-movements'))) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/material-analysis' && path.startsWith('/material-analysis')) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/profile' && path.startsWith('/profile')) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/books' && path.startsWith('/books')) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/book-loans' && path.startsWith('/book-loans')) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/users' && path.startsWith('/users')) {
                        isActive = true;
                    }

                    if (isActive) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                } catch (e) {}
            });

            // 2. Data Material Group & Submenu
            const groupMaterials = document.getElementById('navGroupMaterials');
            const parentBtn = document.getElementById('btnToggleMaterials');
            const isStockIn = path.startsWith('/materials/stock-in');
            const isStockOut = path.startsWith('/materials/stock-out');
            const isMaterials = path.startsWith('/materials');

            if (groupMaterials) {
                if (isMaterials || isStockIn || isStockOut) {
                    groupMaterials.classList.add('open');
                    if (parentBtn) {
                        parentBtn.classList.add('active-parent');
                        parentBtn.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    if (parentBtn) {
                        parentBtn.classList.remove('active-parent');
                    }
                }
            }

            // Subitem highlight
            document.querySelectorAll('.nav-submenu .nav-subitem').forEach(sub => {
                const href = sub.getAttribute('href');
                if (!href) return;
                try {
                    const subUrl = new URL(href, window.location.origin);
                    let isSubActive = false;
                    if (isStockOut && subUrl.pathname.includes('/stock-out')) {
                        isSubActive = true;
                    } else if (isStockIn && subUrl.pathname.includes('/stock-in')) {
                        isSubActive = true;
                    } else if (!isStockIn && !isStockOut && isMaterials && !subUrl.pathname.includes('/stock-in') && !subUrl.pathname.includes('/stock-out')) {
                        isSubActive = true;
                    }

                    if (isSubActive) {
                        sub.classList.add('active');
                    } else {
                        sub.classList.remove('active');
                    }
                } catch (e) {}
            });
        } catch (e) {}
    }

    // Cek apakah URL valid untuk di-swap instan tanpa reload browser
    function isInternalNavigableUrl(href, linkEl) {
        if (!href || href === '#' || href.startsWith('javascript') || href.startsWith('#')) return false;
        if (linkEl && (linkEl.target === '_blank' || linkEl.hasAttribute('download'))) return false;

        try {
            const url = new URL(href, window.location.origin);
            if (url.origin !== window.location.origin) return false;
            // File export download jangan di-swap
            if (url.pathname.includes('/export')) return false;
            // Hanya rute internal aplikasi
            const validPrefixes = [
                '/dashboard',
                '/materials',
                '/stock-history',
                '/stock-movements',
                '/material-analysis',
                '/books',
                '/book-loans',
                '/users',
                '/profile'
            ];
            return validPrefixes.some(prefix => url.pathname.startsWith(prefix));
        } catch (e) {
            return false;
        }
    }

    // Tangkap klik link navigasi (sidebar & konten)
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (isInternalNavigableUrl(href, link)) {
            const targetUrl = new URL(link.href, window.location.origin);
            if (targetUrl.href === window.location.href) return;

            e.preventDefault();
            navigatePage(link.href, true);
        }
    });

    // Tangkap tombol browser Back / Forward
    window.addEventListener('popstate', function (e) {
        navigatePage(window.location.href, false);
    });

    // Dropdown jumlah baris per halaman (Data Material)
    window.changePerPage = function (val) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', val);
        url.searchParams.delete('page');
        navigatePage(url.toString(), true);
    };

    // --- REAL-TIME LIVE SEARCH & FILTER WITH DEBOUNCE ---
    let _liveSearchTimer = null;

    function handleLiveSearch(targetEl, immediate = false) {
        if (!targetEl) return;
        const form = targetEl.closest('form');
        if (!form || form.method.toLowerCase() !== 'get') return;

        clearTimeout(_liveSearchTimer);

        const executeSearch = () => {
            const action = form.action || window.location.href;
            const formData = new FormData(form);
            const searchParams = new URLSearchParams();

            for (const [key, val] of formData.entries()) {
                if (key === 'page') continue; // Reset ke halaman 1 saat pencarian/filter berubah
                if (val !== '') {
                    searchParams.append(key, val);
                }
            }

            const targetUrl = new URL(action, window.location.origin);
            targetUrl.search = searchParams.toString();

            const preserveState = {
                name: (typeof targetEl.getAttribute === 'function') ? targetEl.getAttribute('name') : null,
                id: targetEl.id || null,
                value: (typeof targetEl.value !== 'undefined') ? targetEl.value : null,
                selectionStart: (typeof targetEl.selectionStart === 'number') ? targetEl.selectionStart : null,
                selectionEnd: (typeof targetEl.selectionEnd === 'number') ? targetEl.selectionEnd : null
            };

            navigatePage(targetUrl.toString(), true, {
                isLiveSearch: true,
                preserveState: preserveState
            });
        };

        if (immediate) {
            executeSearch();
        } else {
            _liveSearchTimer = setTimeout(executeSearch, 300);
        }
    }
    window.handleLiveSearch = handleLiveSearch;

    // Real-time typing listener dengan debounce 300ms
    document.addEventListener('input', function (e) {
        const input = e.target;
        if (!input || input.type === 'hidden' || input.type === 'password' || input.type === 'file') return;

        const form = input.closest('form');
        if (!form || form.method.toLowerCase() !== 'get') return;

        const isSearchField = input.name === 'search' ||
                              input.type === 'search' ||
                              input.id === 'search' ||
                              input.id === 'searchInput' ||
                              input.id === 'bookSearchInput' ||
                              input.id === 'loanSearchInput' ||
                              input.id === 'userSearchInput' ||
                              input.closest('.search-box') ||
                              input.closest('.search-input') ||
                              input.closest('.search-input-wrapper');

        if (isSearchField) {
            handleLiveSearch(input, false);
        }
    });

    // Real-time filter perubahan dropdown / tanggal / checkbox langsung tanpa reload
    document.addEventListener('change', function (e) {
        const el = e.target;
        if (!el) return;

        const form = el.closest('form');
        if (!form || form.method.toLowerCase() !== 'get') return;

        if (el.matches('select, input[type="date"], input[type="radio"], input[type="checkbox"]')) {
            handleLiveSearch(el, true);
        }
    });

    // Tangkap klik tombol reset / clear search
    document.addEventListener('click', function (e) {
        const clearBtn = e.target.closest('#btnClearSearch, .btn-clear-search');
        if (clearBtn) {
            const form = clearBtn.closest('form');
            const input = form ? form.querySelector('input[name="search"], #searchInput, input[type="text"]') : null;
            if (input) {
                input.value = '';
                handleLiveSearch(input, true);
            }
        }
    });

    // Form submission
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.method.toLowerCase() === 'get') {
            e.preventDefault();
            clearTimeout(_liveSearchTimer);
            const activeInput = form.querySelector('input[name="search"], input[type="text"], input[type="search"]') || form;
            handleLiveSearch(activeInput, true);
            return;
        } else {
    // DELETE form → proses tanpa hard reload
    const methodInput = form.querySelector('input[name="_method"]');

    if (methodInput && methodInput.value.toUpperCase() === 'DELETE') {
        e.preventDefault();

        if (form.dataset.submitting === '1') return;
        form.dataset.submitting = '1';

        window.YouTubeProgress.start();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal menghapus data');
            }

            // Laravel sudah melakukan redirect + flash message.
            // Setelah itu refresh isi halaman melalui SPA.
            return navigatePage(window.location.pathname + window.location.search, false);
        })
        .catch(error => {
            console.error(error);
            window.location.reload();
        })
        .finally(() => {
            form.dataset.submitting = '0';
        });

        return;
    }

    // POST form biasa (simpan data, logout, dll.)
    window.YouTubeProgress.start();
}
    });
</script>
