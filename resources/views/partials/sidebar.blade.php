<!-- ============================================================
     SIDEBAR
     Sama untuk Admin, Umum, dan Keuangan
     ============================================================ -->
<aside class="sidebar" id="sidebar">

    <!-- Logo PLN -->
    <div class="sidebar-logo">
        <img 
            src="{{ asset('images/logo-pln.png') }}" 
            alt="Logo PLN"
            class="sidebar-logo-image"
        >
        <div class="sidebar-logo-text">
            <h1>STOK ATK</h1>
            <p>PLN Asam-Asam</p>
        </div>
    </div>

    <!-- User Card: Dinamis berdasarkan user login -->
    <div class="sidebar-user">
        <div class="sidebar-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
        </div>
    </div>

    <!-- Navigation Menu: SAMA untuk ketiga user, tanpa pembatasan berdasarkan role -->
    <nav class="sidebar-nav">

        <div class="nav-section-title">Menu Utama</div>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined">speed</span>
            Dashboard
        </a>

        <!-- Data Material (Langsung ke halaman Data Material) -->
        <a href="{{ route('materials.index') }}" class="nav-item {{ request()->routeIs('materials.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">inventory_2</span>
            Data Material
        </a>

        <!-- Riwayat Stok -->
        <a href="#" class="nav-item {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}" onclick="alert('Halaman Riwayat Stok belum tersedia.')">
            <span class="material-symbols-outlined">history</span>
            Riwayat Stok
        </a>

        <!-- Laporan -->
        <a href="#" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" onclick="alert('Halaman Laporan belum tersedia.')">
            <span class="material-symbols-outlined">bar_chart</span>
            Laporan
        </a>

        <div class="nav-section-title" style="margin-top:8px;">Akun</div>

        <!-- Profile -->
        <a href="#" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" onclick="alert('Halaman Profile belum tersedia.')">
            <span class="material-symbols-outlined">account_circle</span>
            Profile
        </a>

    </nav>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span class="material-symbols-outlined">logout</span>
                Keluar (Logout)
            </button>
        </form>
    </div>

</aside>
