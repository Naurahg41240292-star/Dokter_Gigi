<style>
    .page-fade-in {
        animation: pageFadeIn 0.28s ease both;
    }

    @keyframes pageFadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<style>
    :root {
        --bg: #eff6ff;
        --fg: #1e293b;
        --muted: #64748b;
        --accent: #2563eb;
        --card: #FFFFFF;
        --border: #dbeafe;
        --sidebar: #FFFFFF;
    }

    /* Sidebar layout */
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: var(--sidebar);
        border-right: 1px solid var(--border);
        position: fixed;
        left: 0;
        top: 0;
        z-index: 50;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 4px 0 24px rgba(59, 130, 246, 0.03);
        padding-bottom: 80px;
    }

    .sidebar .px-7 { padding-left: 20px; padding-right: 20px; }

    .sidebar-title {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: #9aa6b2;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 10px 20px;
        margin-top: 6px;
        margin-bottom: 6px;
    }

    nav.space-y-1 { padding-bottom: 40px; }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 12px;
        color: var(--muted);
        font-size: 14px;
        font-weight: 600;
        transition: all 0.18s ease;
        cursor: pointer;
        position: relative;
        margin: 6px 12px;
        text-decoration: none;
        background: transparent;
    }

    .sidebar-link i {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 15px;
        color: #6b7280;
        background: transparent;
    }

    .icon-box { width: 36px; height: 36px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; }

    .sidebar-link .icon-box i { margin: 0; }

    .sidebar-link.active .icon-box { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #fff; box-shadow: 0 6px 18px rgba(37,99,235,0.08); }

    .sidebar-link.active .icon-box i { color: #fff; }

    .sidebar-link span { display: inline-block; }

    .sidebar-link:hover {
        color: var(--accent);
        background: #f1f8ff;
    }

    .sidebar-link.active {
        color: var(--accent);
        background: #eef6ff;
        font-weight: 700;
    }

    .sidebar-link.active::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 28px;
        background: var(--accent);
        border-radius: 0 6px 6px 0;
    }

    .sidebar-link.active i {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        box-shadow: 0 6px 18px rgba(37,99,235,0.08);
    }

    @media (max-width: 1024px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
    }
</style>

<aside class="sidebar" id="sidebar">
    <div class="px-7 pt-7 pb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-gray-800 font-bold text-[17px] leading-tight tracking-tight">D'Smile</h1>
                <p class="text-[11px] text-blue-400 font-bold tracking-widest uppercase">Pasien</p>
            </div>
        </div>
    </div>

    <nav class="space-y-1">
        <p class="sidebar-title">Menu Utama</p>

        <a href="/dashboardpasien" class="{{ request()->is('dashboardpasien') ? 'sidebar-link active' : 'sidebar-link' }} transition-all duration-300 hover:translate-x-1" id="nav-dashboard">
            <span class="icon-box"><i class="fas fa-home"></i></span>
            <span>Beranda</span>
        </a>
        <a href="/appointment" class="{{ request()->is('appointment') ? 'sidebar-link active' : 'sidebar-link' }} transition-all duration-300 hover:translate-x-1" id="nav-appointment">
            <span class="icon-box"><i class="fas fa-calendar-check"></i></span>
            <span>Appointment</span>
        </a>
        <a href="/riwayat-perawatan" class="{{ request()->is('riwayat-perawatan') ? 'sidebar-link active' : 'sidebar-link' }} transition-all duration-300 hover:translate-x-1" id="nav-history">
            <span class="icon-box"><i class="fas fa-file-medical"></i></span>
            <span>Riwayat Perawatan</span>
        </a>

        <p class="sidebar-title">Layanan</p>

        <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran*') ? 'sidebar-link active' : 'sidebar-link' }} transition-all duration-300 hover:translate-x-1">
            <span class="icon-box"><i class="fas fa-credit-card"></i></span>
            <span>Pembayaran</span>
        </a>
        <a href="{{ route('pasien.artikel') }}" class="{{ request()->is('artikel*') ? 'sidebar-link active' : 'sidebar-link' }} transition-all duration-300 hover:translate-x-1">
            <span class="icon-box"><i class="fas fa-newspaper"></i></span>
            <span>Artikel Kesehatan</span>
        </a>
        <a href="#" class="sidebar-link transition-all duration-300 hover:translate-x-1">
            <span class="icon-box"><i class="fas fa-comment-medical"></i></span>
            <span>Konsultasi Online</span>
        </a>

        <p class="sidebar-title">Akun</p>

        <a href="#" class="sidebar-link transition-all duration-300 hover:translate-x-1">
            <span class="icon-box"><i class="fas fa-cog"></i></span>
            <span>Pengaturan</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
            @csrf
            <button type="submit" class="sidebar-link w-full text-red-500 hover:bg-red-50 hover:text-red-600 transition-all duration-300 hover:translate-x-1">
                <span class="icon-box"><i class="fas fa-sign-out-alt"></i></span>
                <span>Keluar</span>
            </button>
        </form>
    </nav>

    <div class="absolute bottom-6 left-0 right-0 px-6">
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shadow-sm">
                    <i class="fas fa-headset text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-gray-800 text-xs font-bold">Butuh Bantuan?</p>
                    <p class="text-gray-500 text-[10px]">Tim kami siap sedia</p>
                </div>
            </div>
            <button class="w-full text-center text-[11px] font-bold text-blue-600 bg-white py-2 rounded-lg shadow-sm hover:bg-blue-500 hover:text-white transition-all cursor-pointer border border-blue-100">
                Hubungi Kami
            </button>
        </div>
    </div>
</aside>
