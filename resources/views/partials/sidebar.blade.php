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
        <a href="{{ route('dashboard') }}" class="sidebar-brand-link" title="Dashboard STOK ATK">
            <img 
                src="{{ asset('images/logo-pln.png') }}" 
                alt="Logo PLN"
                class="sidebar-logo-image"
                loading="eager"
            >
            <div class="sidebar-logo-text">
                <h1>STOK ATK</h1>
                <p>PLN Asam-Asam</p>
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

        <!-- Data Material -->
        <a href="{{ route('materials.index') }}" 
           class="nav-item {{ request()->routeIs('materials.*') ? 'active' : '' }}" 
           data-spa-link>
            <span class="material-symbols-outlined">inventory_2</span>
            <span>Data Material</span>
        </a>

        <!-- Riwayat Stok -->
        <a href="{{ route('stock-movements.index') }}"
           class="nav-item {{ request()->routeIs('stock-movements.*') || request()->is('stock-history*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">history</span>
            <span>Riwayat Stok</span>
        </a>    

        <div class="nav-section-title" style="margin-top:10px;">Akun</div>

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
        --sidebar-blue: #003B73;
        --sidebar-yellow: #FFC107;
    }

    /* ============================================================
       YOUTUBE-STYLE TOP LOADING PROGRESS BAR
    ============================================================ */
    .sidebar-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, #FFC107 0%, #0057B8 50%, #FFC107 100%);
        background-size: 200% 100%;
        z-index: 999999;
        pointer-events: none;
        opacity: 0;
        transition: width 0.22s cubic-bezier(0.1, 0.85, 0.25, 1), opacity 0.2s ease;
        box-shadow: 0 0 10px rgba(255, 193, 7, 0.9), 0 0 4px rgba(0, 87, 184, 0.6);
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

    /* Transisi Halus Area Main (Sidebar tetap diam 100%) */
    .main {
        transition: opacity 0.08s ease;
    }

    /* Container Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: var(--sidebar-w);
        background: var(--sidebar-blue);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        padding: 0;
        z-index: 999;
        box-shadow: 2px 0 16px rgba(0, 0, 0, 0.08);
        user-select: none;
        -webkit-user-select: none;
        /* Default: jangan ada transition transform agar tidak ngesot/bergerak di desktop */
        transform: none;
        transition: none;
    }

    /* PENTING: Kunci posisi di Desktop agar tidak pernah bergerak/ngesot saat load */
    @media (min-width: 769px) {
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
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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
        font-size: 15px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: 0.02em;
    }

    .sidebar-logo-text p {
        margin: 2px 0 0;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.62);
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
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #ffffff;
        cursor: pointer;
        transition: background 0.15s ease;
        touch-action: manipulation;
    }

    .sidebar-close-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* User Card */
    .sidebar-user {
        margin: 14px 14px 6px;
        padding: 11px 12px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 11px;
        text-decoration: none;
        color: inherit;
        transition: background 0.15s ease;
        cursor: pointer;
    }
    .sidebar-user:hover {
        background: rgba(255, 255, 255, 0.14);
    }

    .sidebar-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        min-height: 38px;
        border-radius: 50%;
        background: var(--sidebar-yellow);
        color: var(--sidebar-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .sidebar-user-info {
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }

    .sidebar-user-name {
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role {
        font-size: 10px;
        font-weight: 700;
        color: var(--sidebar-yellow);
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
        scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.18);
        border-radius: 4px;
    }

    .nav-section-title {
        font-size: 10px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.45);
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
        color: rgba(255, 255, 255, 0.78);
        text-decoration: none;
        margin-bottom: 3px;
        transition: background 0.12s ease, color 0.12s ease;
        touch-action: manipulation;
        cursor: pointer;
        position: relative;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .nav-item:active {
        background: rgba(255, 255, 255, 0.18);
    }

    .nav-item.active {
        background: var(--sidebar-yellow);
        color: var(--sidebar-blue);
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.14);
    }

    .nav-item.active:hover {
        background: #f5b700;
        color: var(--sidebar-blue);
    }

    /* Footer & Logout */
    .sidebar-footer {
        padding: 12px 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .btn-logout {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 9px;
        border: 1px solid rgba(239, 68, 68, 0.28);
        background: rgba(239, 68, 68, 0.12);
        color: #FCA5A5;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
        touch-action: manipulation;
        font-family: inherit;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.26);
        color: #ffffff;
    }

    .btn-logout:active {
        background: rgba(239, 68, 68, 0.35);
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

    /* Responsif Mobile (Max 768px) */
    @media (max-width: 768px) {
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

    // --- SEAMLESS INSTANT SPA PAGE ENGINE (SIDEBAR DIAM AJA) ---
    async function navigatePage(url, push = true) {
        window.YouTubeProgress.start();

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                window.location.href = url;
                return;
            }

            const htmlText = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(htmlText, 'text/html');

            const newMain = newDoc.querySelector('main.main');
            const currentMain = document.querySelector('main.main');

            if (!newMain || !currentMain) {
                window.location.href = url;
                return;
            }

            // Transisi halus pada area konten (sidebar tetap diam 100%)
            currentMain.style.opacity = '0.35';

            setTimeout(() => {
                // 1. Ganti CSS Halaman secara instan
                const newPageStyle = newDoc.getElementById('page-style');
                let currentPageStyle = document.getElementById('page-style');
                if (newPageStyle) {
                    if (currentPageStyle) {
                        currentPageStyle.textContent = newPageStyle.textContent;
                    } else {
                        const st = document.createElement('style');
                        st.id = 'page-style';
                        st.textContent = newPageStyle.textContent;
                        document.head.appendChild(st);
                    }
                }

                // 2. Ganti konten main
currentMain.innerHTML = newMain.innerHTML;

// 3. Jalankan ulang script halaman baru
currentMain.querySelectorAll('script').forEach(oldScript => {

    const newScript = document.createElement('script');

    // Salin semua atribut script
    Array.from(oldScript.attributes).forEach(attribute => {
        newScript.setAttribute(
            attribute.name,
            attribute.value
        );
    });

    // Salin isi JavaScript
    newScript.textContent = oldScript.textContent;

    // Replace script lama dengan script baru
    oldScript.replaceWith(newScript);
});

// 4. Update judul tab browser
document.title = newDoc.title;

// 5. Update address bar URL
if (push) {
    history.pushState(
        { url: url },
        newDoc.title,
        url
    );
}

// 6. Update menu aktif di sidebar
updateSidebarActiveMenu(url);

                // 7. Scroll ke paling atas
                window.scrollTo({ top: 0, behavior: 'instant' });

                // 8. Tampilkan kembali konten dengan mulus
                currentMain.style.opacity = '1';

                // 9. Selesaikan loading bar YouTube
                window.YouTubeProgress.done();

                // 10. Jika di HP, tutup menu drawer
                if (window.innerWidth <= 768) {
                    window.closeSidebar();
                }
            }, 60);

        } catch (err) {
            window.location.href = url;
        }
    }

    // Perbarui highlight warna aktif di sidebar
    function updateSidebarActiveMenu(targetUrlStr) {
        try {
            const targetUrl = new URL(targetUrlStr, window.location.origin);
            const path = targetUrl.pathname;
            document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
                const href = item.getAttribute('href');
                if (!href || href.startsWith('javascript') || href === '#') return;
                try {
                    const itemUrl = new URL(href, window.location.origin);
                    let isActive = false;

                    if (itemUrl.pathname === '/dashboard' && path === '/dashboard') {
                        isActive = true;
                    } else if (itemUrl.pathname === '/materials' && path.startsWith('/materials')) {
                        isActive = true;
                    } else if ((itemUrl.pathname === '/stock-history' || itemUrl.pathname.startsWith('/stock-movements')) && (path === '/stock-history' || path.startsWith('/stock-movements'))) {
                        isActive = true;
                    } else if (itemUrl.pathname === '/profile' && path.startsWith('/profile')) {
                        isActive = true;
                    }

                    if (isActive) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
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
            const validPrefixes = ['/dashboard', '/materials', '/stock-history', '/stock-movements', '/profile'];
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

    // Form submission
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.method.toLowerCase() === 'get') {
            e.preventDefault();
            const action = form.action || window.location.href;
            const formData = new FormData(form);
            const searchParams = new URLSearchParams(formData);
            const targetUrl = new URL(action, window.location.origin);
            targetUrl.search = searchParams.toString();
            navigatePage(targetUrl.toString(), true);
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
