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
    <div class="sidebar-user">
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
    </div>

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
        <a href="javascript:void(0)" 
           class="nav-item {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}" 
           onclick="showSidebarToast('Fitur Riwayat Stok sedang dikembangkan.')">
            <span class="material-symbols-outlined">history</span>
            <span>Riwayat Stok</span>
        </a>

        <!-- Laporan -->
        <a href="javascript:void(0)" 
           class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
           onclick="showSidebarToast('Fitur Laporan sedang dikembangkan.')">
            <span class="material-symbols-outlined">bar_chart</span>
            <span>Laporan</span>
        </a>

        <div class="nav-section-title" style="margin-top:10px;">Akun</div>

        <!-- Profile -->
        <a href="javascript:void(0)" 
           class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" 
           onclick="showSidebarToast('Fitur Profile sedang dikembangkan.')">
            <span class="material-symbols-outlined">account_circle</span>
            <span>Profile</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout" title="Keluar dari akun">
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

{{-- CSS Terpusat & Anti-Ngesot / Anti-Patah --}}
<style id="sidebar-styles">
    :root {
        --sidebar-w: 260px;
        --sidebar-blue: #003B73;
        --sidebar-yellow: #FFC107;
    }

    /* Top Progress Bar saat berpindah halaman */
    .sidebar-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, #FFC107, #0057B8);
        z-index: 10000;
        pointer-events: none;
        transition: width 0.2s ease, opacity 0.2s ease;
        opacity: 0;
    }
    .sidebar-progress-bar.active {
        opacity: 1;
        width: 70%;
    }
    .sidebar-progress-bar.finish {
        width: 100%;
        opacity: 0;
        transition: width 0.1s ease, opacity 0.3s ease 0.1s;
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

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
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

    // --- SEAMLESS INSTANT PAGE TRANSITION ENGINE (Micro-SPA) ---
    // Mencegah reload layar penuh sehingga sidebar tidak kedip, tidak ngesot, dan sangat cepat
    (function () {
        const progressBar = document.getElementById('sidebarProgressBar');

        function startProgress() {
            if (progressBar) {
                progressBar.classList.remove('finish');
                progressBar.classList.add('active');
            }
        }

        function finishProgress() {
            if (progressBar) {
                progressBar.classList.remove('active');
                progressBar.classList.add('finish');
            }
        }

        // Cek apakah URL valid untuk di-swap tanpa reload
        function isInternalNavLink(url) {
            try {
                const target = new URL(url, window.location.origin);
                // Jangan swap jika bukan domain yang sama
                if (target.origin !== window.location.origin) return false;
                // Jangan swap file export download
                if (target.pathname.includes('/export')) return false;
                // Hanya swap rute dalam aplikasi
                const allowedRoutes = ['/dashboard', '/materials'];
                return allowedRoutes.some(r => target.pathname.startsWith(r));
            } catch (e) {
                return false;
            }
        }

        // Eksekusi perpindahan halaman instan
        async function navigatePage(url, push = true) {
            startProgress();
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
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

                // Update judul tab
                document.title = newDoc.title;

                // Transisi halus fade out -> swap -> fade in (hanya 60ms)
                currentMain.style.opacity = '0';
                setTimeout(() => {
                    currentMain.innerHTML = newMain.innerHTML;

                    // Jalankan ulang tag script yang ada di dalam main jika ada
                    newMain.querySelectorAll('script').forEach(oldScript => {
                        const newScript = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                        currentMain.appendChild(newScript);
                    });

                    currentMain.style.opacity = '1';
                    finishProgress();
                    window.scrollTo({ top: 0, behavior: 'instant' });

                    if (push) {
                        history.pushState({ url: url }, newDoc.title, url);
                    }

                    // Perbarui status menu aktif di sidebar
                    updateSidebarMenuState(url);

                    // Di layar HP, tutup drawer setelah klik menu
                    if (window.innerWidth <= 768) {
                        window.closeSidebar();
                    }
                }, 60);

            } catch (err) {
                finishProgress();
                window.location.href = url;
            }
        }

        // Perbarui highlight warna aktif di sidebar
        function updateSidebarMenuState(currentUrl) {
            const target = new URL(currentUrl, window.location.origin);
            document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
                const href = item.getAttribute('href');
                if (!href || href.startsWith('javascript') || href === '#') return;
                try {
                    const itemUrl = new URL(href, window.location.origin);
                    let isActive = false;

                    if (itemUrl.pathname === '/dashboard' && target.pathname === '/dashboard') {
                        isActive = true;
                    } else if (itemUrl.pathname.startsWith('/materials') && target.pathname.startsWith('/materials')) {
                        isActive = true;
                    }

                    if (isActive) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                } catch (e) {}
            });
        }

        // Tangkap klik pada link menu dan tombol navigasi internal
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript') || 
                link.target === '_blank' || link.hasAttribute('download')) {
                return;
            }

            if (isInternalNavLink(href)) {
                e.preventDefault();
                navigatePage(href, true);
            }
        });

        // Dukung tombol Back / Forward browser
        window.addEventListener('popstate', function () {
            navigatePage(window.location.href, false);
        });
    })();
</script>
