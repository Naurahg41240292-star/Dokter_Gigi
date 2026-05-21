<style>
    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<style>
    :root {
        --bg: #eff6ff;
        --fg: #1e293b;
        --muted: #64748b;
        --accent: #2563eb;
        --card: #FFFFFF;
        --border: #e8eef6;
        --sidebar: #FFFFFF;
    }

    .sidebar-pasien {
        width: 260px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 50;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-pasien-inner {
        width: 100%;
        height: 100%;
        background: var(--sidebar);
        border-right: 1px solid var(--border);
        box-shadow: 2px 0 16px rgba(59, 130, 246, 0.04);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-pasien-logo {
        padding: 22px 22px 18px 22px;
        flex-shrink: 0;
    }

    .sidebar-pasien-logo img {
        height: 34px;
        width: auto;
        object-fit: contain;
    }

    .sidebar-pasien-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: 0 20px;
        flex-shrink: 0;
    }

    .sidebar-pasien-nav {
        flex: 1;
        padding: 14px 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-pasien-nav::-webkit-scrollbar { width: 0; }

    .sidebar-pasien-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--muted);
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .sidebar-pasien-link-inner {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 10px 22px;
        transition: all 0.2s ease;
    }

    .sidebar-pasien-link .sp-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: transparent;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .sidebar-pasien-link .sp-icon i {
        font-size: 14px;
        color: #94a3b8;
        transition: all 0.2s ease;
    }

    .sidebar-pasien-link .sp-text {
        transition: color 0.2s ease;
    }

    /* Active bar */
    .sidebar-pasien-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 3px;
        background: var(--accent);
        border-radius: 0 4px 4px 0;
        z-index: 2;
    }

    /* Hover */
    .sidebar-pasien-link:hover .sp-icon { background: #eff6ff; }
    .sidebar-pasien-link:hover .sp-icon i { color: var(--accent); }
    .sidebar-pasien-link:hover .sp-text { color: var(--accent); }

    /* Active */
    .sidebar-pasien-link.active .sp-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.18);
    }
    .sidebar-pasien-link.active .sp-icon i { color: #fff; }
    .sidebar-pasien-link.active .sp-text { color: var(--accent); font-weight: 700; }
    .sidebar-pasien-link.active .sidebar-pasien-link-inner { background: #f0f7ff; }

    /* Bottom */
    .sidebar-pasien-bottom {
        padding: 8px 0 20px 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
        flex-shrink: 0;
    }

    /* Logout merah */
    .sidebar-pasien-link.logout-link:hover .sp-icon { background: #fef2f2; }
    .sidebar-pasien-link.logout-link:hover .sp-icon i { color: #EF4444; }
    .sidebar-pasien-link.logout-link:hover .sp-text { color: #EF4444; }

    @media (max-width: 1024px) {
        .sidebar-pasien { transform: translateX(-100%); }
        .sidebar-pasien.open { transform: translateX(0); }
    }
</style>

<div class="sidebar-pasien" id="sidebar">
    <div class="sidebar-pasien-inner">

        <div class="sidebar-pasien-logo">
            <img src="{{ asset('images/logo (2).png') }}" alt="D'Smile Logo">
        </div>

        <div class="sidebar-pasien-divider"></div>

        <nav class="sidebar-pasien-nav">
            <a href="/dashboardpasien" class="sidebar-pasien-link {{ request()->is('dashboardpasien') ? 'active' : '' }}">
                <div class="sidebar-pasien-link-inner">
                    <span class="sp-icon"><i class="fas fa-home"></i></span>
                    <span class="sp-text">Beranda</span>
                </div>
            </a>
            <a href="/appointment" class="sidebar-pasien-link {{ request()->is('appointment') ? 'active' : '' }}">
                <div class="sidebar-pasien-link-inner">
                    <span class="sp-icon"><i class="fas fa-calendar-check"></i></span>
                    <span class="sp-text">Appointment</span>
                </div>
            </a>
            <a href="/riwayat-perawatan" class="sidebar-pasien-link {{ request()->is('riwayat-perawatan') ? 'active' : '' }}">
                <div class="sidebar-pasien-link-inner">
                    <span class="sp-icon"><i class="fas fa-file-medical"></i></span>
                    <span class="sp-text">Riwayat Perawatan</span>
                </div>
            </a>
            <a href="{{ route('pembayaran.index') }}" class="sidebar-pasien-link {{ request()->is('pembayaran*') ? 'active' : '' }}">
                <div class="sidebar-pasien-link-inner">
                    <span class="sp-icon"><i class="fas fa-tags"></i></span>
                    <span class="sp-text">Pricelist</span>
                </div>
            </a>
        </nav>

        <div class="sidebar-pasien-divider"></div>

        <div class="sidebar-pasien-bottom">
            <a href="#" class="sidebar-pasien-link">
                <div class="sidebar-pasien-link-inner">
                    <span class="sp-icon"><i class="fas fa-cog"></i></span>
                    <span class="sp-text">Pengaturan</span>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-pasien-link logout-link">
                    <div class="sidebar-pasien-link-inner">
                        <span class="sp-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span class="sp-text">Keluar</span>
                    </div>
                </button>
            </form>
        </div>

    </div>
</div>