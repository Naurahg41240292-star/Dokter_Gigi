<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: '#2563eb', // Biru Utama
                        surface: '#eff6ff', // Biru Sangat Muda
                        sidebar: '#FFFFFF', // Sidebar Putih
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --bg: #eff6ff;         /* Latar belakang halaman (Biru sangat muda) */
            --fg: #1e293b;         /* Teks utama */
            --muted: #64748b;      /* Teks sekunder */
            --accent: #2563eb;     /* Biru Royal */
            --card: #FFFFFF;       /* Kartu Putih */
            --border: #dbeafe;     /* Border biru muda */
            --sidebar: #FFFFFF;    /* Sidebar Putih */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--fg);
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #93c5fd; }

        /* Sidebar - PUTIH */
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
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            border-radius: 10px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
            margin: 0 12px;
        }

        .sidebar-link:hover {
            color: var(--accent);
            background: #eff6ff;
        }

        .sidebar-link.active {
            color: var(--accent);
            background: #eff6ff;
            font-weight: 600;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-link {
            color: var(--muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-link.text-red-500 {
            color: #ef4444;
        }

        .sidebar-link.text-red-500:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .sidebar-title {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding-left: 32px;
            margin-bottom: 8px;
            margin-top: 24px;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        .topbar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
        }

        .card:hover {
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.08);
            border-color: #bfdbfe;
            transform: translateY(-2px);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            opacity: 0.08;
        }

        .stat-card.blue::after { background: #2563EB; }
        .stat-card.orange::after { background: #F59E0B; }
        .stat-card.purple::after { background: #8B5CF6; }
        .stat-card.teal::after { background: #06C4AD; }

        .notif-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 18px;
            height: 18px;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .schedule-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.25);
        }

        .schedule-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .article-card img {
            transition: transform 0.4s ease;
        }

        .article-card:hover img {
            transform: scale(1.05);
        }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            color: #fff;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .notif-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 340px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s ease;
            z-index: 60;
        }

        .notif-dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 200px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 12px 36px rgba(37, 99, 235, 0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s ease;
            z-index: 60;
        }

        .profile-dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 13px;
            color: var(--fg);
            transition: background 0.15s;
        }

        .profile-dropdown a:hover {
            background: #eff6ff;
        }

        .profile-dropdown a.danger {
            color: #EF4444;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(16px);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-up:nth-child(1) { animation-delay: 0.05s; }
        .fade-up:nth-child(2) { animation-delay: 0.1s; }
        .fade-up:nth-child(3) { animation-delay: 0.15s; }
        .fade-up:nth-child(4) { animation-delay: 0.2s; }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(30, 41, 59, 0.4);
            z-index: 45;
            backdrop-filter: blur(2px);
        }

        .mobile-overlay.show { display: block; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #22C55E;
            border-radius: 50%;
            border: 2px solid #fff;
            position: absolute;
            bottom: 0;
            right: 0;
        }
    </style>
</head>
<body class="page-fade-in">

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <div class="main-content">

        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">Selamat datang, Wulan!</h2>
                        <p class="text-xs text-gray-400 mt-0.5" id="currentDate">Senin, 1 mei 202g</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center bg-white rounded-xl px-4 py-2.5 gap-2 w-64 border border-blue-100 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-50 transition-all">
                        <i class="fas fa-search text-gray-400 text-xs"></i>
                        <input type="text" placeholder="Cari layanan atau dokter..." class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none w-full font-medium">
                    </div>

                    <div class="relative">
                        <button class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition-colors relative cursor-pointer" onclick="toggleNotif()" id="notifBtn">
                            <i class="fas fa-bell text-[15px]"></i>
                            <span class="notif-badge">4</span>
                        </button>

                        <div class="notif-dropdown" id="notifDropdown">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900">Notifikasi</h4>
                                    <button class="text-xs text-blue-600 font-bold hover:underline cursor-pointer" onclick="showToast('Semua notifikasi telah dibaca')">Tandai semua dibaca</button>
                                </div>
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                <div class="p-4 hover:bg-blue-50/50 transition-colors cursor-pointer border-l-[3px] border-blue-500">
                                    <div class="flex gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-calendar-check text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-gray-800 font-bold leading-snug">Appointment dikonfirmasi</p>
                                            <p class="text-[11px] text-gray-400 mt-1">Baru saja</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer border-l-[3px] border-transparent">
                                    <div class="flex gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-exclamation-circle text-amber-500 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-gray-800 font-medium leading-snug">Pengingat konsumsi obat</p>
                                            <p class="text-[11px] text-gray-400 mt-1">1 jam yang lalu</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer border-l-[3px] border-transparent">
                                    <div class="flex gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-star text-purple-500 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-gray-800 font-medium leading-snug">Klinik mendapat ulasan baru</p>
                                            <p class="text-[11px] text-gray-400 mt-1">Kemarin</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer border-l-[3px] border-transparent">
                                    <div class="flex gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-gift text-green-500 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-[13px] text-gray-800 font-medium leading-snug">Promo akhir pekan spesial</p>
                                            <p class="text-[11px] text-gray-400 mt-1">2 hari yang lalu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border-t border-gray-100 text-center">
                                <button class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">Lihat semua notifikasi</button>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button class="flex items-center gap-3 pl-3 pr-1 py-1 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleProfile()" id="profileBtn">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-800 leading-tight">Wulan</p>
                                <p class="text-[11px] text-gray-400">Pasien</p>
                            </div>
                            <div class="relative">
                                <img src="https://picsum.photos/seed/wulan/80/80.jpg" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                                <span class="online-dot"></span>
                            </div>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 mr-2"></i>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="p-3 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900">Wulan</p>
                                <p class="text-[11px] text-gray-400">wulan@email.com</p>
                            </div>
                            <div class="py-1">
                                <a href="#"><i class="fas fa-user text-gray-400 text-xs w-4"></i> Profil Saya</a>
                                <a href="#"><i class="fas fa-cog text-gray-400 text-xs w-4"></i> Pengaturan</a>
                                <a href="#" class="danger"><i class="fas fa-sign-out-alt text-xs w-4"></i> Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 py-6">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card stat-card blue p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                        </div>
                        <span class="tag bg-amber-50 text-amber-600">Menunggu Konfirmasi</span>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">1</p>
                                    <p class="text-xs text-gray-400 mt-1 font-medium">Appointment</p>
                </div>

                <div class="card stat-card orange p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i class="fas fa-tooth text-amber-500 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">12</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Total Perawatan</p>
                </div>

                <div class="card stat-card purple p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-file-invoice text-purple-500 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">2</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Tagihan Pending</p>
                </div>

                <div class="card stat-card teal p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">
                            <i class="fas fa-star text-teal-500 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">4.8</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Skor Kesehatan Gigi</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-5 gap-5 mb-6">

                <div class="lg:col-span-3 fade-up" style="animation-delay:0.25s">
                    <div class="schedule-card p-6 relative z-10">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <span class="tag bg-white/15 text-white/90 mb-2 border border-white/10">Mendatang</span>
                                <h3 class="text-lg font-bold mt-2">Appointment Berikutnya</h3>
                            </div>
                            <button class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white/80 hover:bg-white/20 transition-colors cursor-pointer" onclick="showToast('Pengingat diaktifkan')">
                                <i class="fas fa-bell text-sm"></i>
                            </button>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-5">
                            <div class="bg-white/10 rounded-xl p-4 text-center flex-shrink-0 w-full sm:w-28 backdrop-blur-sm border border-white/10">
                                <p class="text-[11px] text-blue-100 font-semibold uppercase tracking-wider">April</p>
                                <p class="text-4xl font-extrabold mt-1 leading-none">16</p>
                                <p class="text-xs text-blue-100 mt-2 font-medium">2025</p>
                            </div>

                            <div class="flex-1">
                                <h4 class="text-base font-bold">Pembersihan Karang Gigi</h4>
                                <div class="flex flex-wrap items-center gap-4 mt-3">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-md text-blue-200 text-xs"></i>
                                        <span class="text-sm text-white/90">dr. Andi Wijaya</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-clock text-blue-200 text-xs"></i>
                                        <span class="text-sm text-white/90">09:00 - 09:45 WIB</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <i class="fas fa-map-marker-alt text-blue-200 text-xs"></i>
                                    <span class="text-sm text-white/70">Klinik Utama - Lantai 2, Ruang 205</span>
                                </div>

                                <div class="flex gap-3 mt-5">
                                    <button class="bg-white text-blue-600 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-50 transition-colors cursor-pointer shadow-lg" onclick="showToast('Mereschedule appointment')">
                                        <i class="fas fa-redo text-[10px]"></i> Jadwal Ulang
                                    </button>
                                    <button class="px-4 py-2.5 rounded-xl border border-white/20 text-white/90 text-xs font-bold hover:bg-white/10 transition-colors cursor-pointer" onclick="showToast('Appointment dibatalkan')">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 fade-up" style="animation-delay:0.3s">
                    <div class="card overflow-hidden h-full">
                        <img src="https://picsum.photos/seed/dentalpromo/600/400.jpg" alt="Promo kesehatan gigi" class="w-full h-44 object-cover">
                        <div class="p-5">
                            <span class="tag bg-red-50 text-red-600 mb-2">Promo Spesial</span>
                            <h4 class="font-bold text-sm text-gray-900 mt-2 leading-snug">Diskon 20% Scaling Pertama</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">Berlaku hingga 30 April 2025 untuk pasien baru D'Smile.</p>
                            <button class="mt-4 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer transition-colors group" onclick="showToast('Kode promo disalin: DSMILE20')">
                                Gunakan Promo <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="fade-up" style="animation-delay:0.35s">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Artikel & Tips Kesehatan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Wawasan terbaru untuk senyum Anda</p>
                    </div>
                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer transition-colors">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="card article-card overflow-hidden cursor-pointer group" onclick="showToast('Membuka artikel: Cara menyikat gigi yang benar')">
                        <div class="overflow-hidden h-44">
                            <img src="https://picsum.photos/seed/teethbrush/600/400.jpg" alt="Tips sikat gigi" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5">
                                <span class="tag bg-blue-50 text-blue-700">Gigi Sehat</span>
                                <span class="text-[11px] text-gray-400">5 min baca</span>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Cara menyikat gigi yang benar</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Panduan lengkap langkah demi langkah untuk membersihkan gigi dan mulut secara efektif.</p>
                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                                <img src="https://picsum.photos/seed/dokter1/60/60.jpg" alt="Dokter" class="w-6 h-6 rounded-full object-cover">
                                <span class="text-[11px] text-gray-500 font-medium">dr. Rina Sari</span>
                                <span class="text-[11px] text-gray-300 mx-1">·</span>
                                <span class="text-[11px] text-gray-400">12 Apr 2025</span>
                            </div>
                        </div>
                    </div>

                    <div class="card article-card overflow-hidden cursor-pointer group" onclick="showToast('Membuka artikel: Makanan yang baik untuk kesehatan gigi')">
                        <div class="overflow-hidden h-44">
                            <img src="https://picsum.photos/seed/dentalfood/600/400.jpg" alt="Makanan untuk gigi" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5">
                                <span class="tag bg-amber-50 text-amber-700">Nutrisi</span>
                                <span class="text-[11px] text-gray-400">7 min baca</span>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Makanan yang baik untuk kesehatan gigi</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Daftar makanan sehat yang membantu memperkuat email gigi dan menjaga kesehatan gusi.</p>
                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                                <img src="https://picsum.photos/seed/dokter2/60/60.jpg" alt="Dokter" class="w-6 h-6 rounded-full object-cover">
                                <span class="text-[11px] text-gray-500 font-medium">dr. Budi Prasetyo</span>
                                <span class="text-[11px] text-gray-300 mx-1">·</span>
                                <span class="text-[11px] text-gray-400">10 Apr 2025</span>
                            </div>
                        </div>
                    </div>

                    <div class="card article-card overflow-hidden cursor-pointer group sm:col-span-2 lg:col-span-1" onclick="showToast('Membuka artikel: Efek samping pemutih gigi')">
                        <div class="overflow-hidden h-44">
                            <img src="https://picsum.photos/seed/whiteteeth/600/400.jpg" alt="Gigi putih" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5">
                                <span class="tag bg-purple-50 text-purple-700">Perawatan</span>
                                <span class="text-[11px] text-gray-400">4 min baca</span>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Benarkah Veneer Aman untuk Gigi?</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Veneer menjadi tren perawatan gigi. Simak fakta medis sebelum Anda memutuskan untuk melakukannya.</p>
                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                                <img src="https://picsum.photos/seed/dokter3/60/60.jpg" alt="Dokter" class="w-6 h-6 rounded-full object-cover">
                                <span class="text-[11px] text-gray-500 font-medium">drg. Andi Wijoya</span>
                                <span class="text-[11px] text-gray-300 mx-1">·</span>
                                <span class="text-[11px] text-gray-400">8 Apr 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <div class="toast" id="toast">
        <i class="fas fa-info-circle text-blue-400"></i>
        <span id="toastMsg">Pesan notifikasi</span>
    </div>

    <script>
        function setActive(el) {
            document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('.sidebar-link i').forEach(icon => {
                icon.classList.remove('text-blue-500');
            });
            const activeIcon = el.querySelector('i');
            if(activeIcon) {
                activeIcon.classList.add('text-blue-500');
            }
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        function toggleNotif() {
            const dropdown = document.getElementById('notifDropdown');
            const profileDrop = document.getElementById('profileDropdown');
            profileDrop.classList.remove('open');
            dropdown.classList.toggle('open');
        }

        function toggleProfile() {
            const dropdown = document.getElementById('profileDropdown');
            const notifDrop = document.getElementById('notifDropdown');
            notifDrop.classList.remove('open');
            dropdown.classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const notifBtn = document.getElementById('notifBtn');
            const notifDrop = document.getElementById('notifDropdown');
            const profileBtn = document.getElementById('profileBtn');
            const profileDrop = document.getElementById('profileDropdown');

            if (!notifBtn.contains(e.target) && !notifDrop.contains(e.target)) {
                notifDrop.classList.remove('open');
            }
            if (!profileBtn.contains(e.target) && !profileDrop.contains(e.target)) {
                profileDrop.classList.remove('open');
            }
        });

        let toastTimeout;
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = message;
            clearTimeout(toastTimeout);
            toast.classList.remove('show');
            void toast.offsetWidth;
            toast.classList.add('show');
            toastTimeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-up').forEach(el => {
                observer.observe(el);
            });
        });

        function updateDate() {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const now = new Date();
            const dateStr = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            const dateEl = document.getElementById('currentDate');
            if (dateEl) {
                dateEl.textContent = dateStr;
            }
        }

        updateDate();
    </script>
</body>
</html>
