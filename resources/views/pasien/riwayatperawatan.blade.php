<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perawatan - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg: #eff6ff;
            --card: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --line: #dbeafe;
            --accent: #2563eb;
            --sidebar-bg: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* --- SIDEBAR FIX --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--line);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 50; /* Di atas konten */
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
            overflow-y: auto; /* Supaya bisa discroll jika layar pendek */
        }

        .sidebar nav {
            flex: 1;
            padding-top: 10px;
        }

        .sidebar-title {
            padding: 16px 20px 8px 20px;
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            border-radius: 10px;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            margin: 0 12px; /* Jarak kiri kanan di dalam sidebar */
            position: relative;
        }

        .sidebar-link:hover {
            background-color: #eff6ff;
            color: var(--accent);
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        /* Active State Styling (Garis Biru di Kiri) */
        .sidebar-link.active {
            background-color: #eff6ff;
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -12px; /* Posisi garis di luar padding */
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link.text-red-500 {
            color: #ef4444;
        }

        .sidebar-link.text-red-500:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* --- LAYOUT --- */
        .content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0; /* Padding dipindahkan ke header/main saja */
            transition: margin-left 0.35s ease;
        }

        .topbar {
            height: 64px;
            background: rgba(255,255,255,0.9);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(8px);
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        /* --- TABS & CARDS --- */
        .tab {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
            padding-bottom: 12px;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: color 0.25s ease, border-color 0.25s ease, background-color 0.25s ease;
        }

        .tab.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .record-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .record-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }

        .record-date {
            width: 60px;
            min-width: 60px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
            padding: 8px 4px;
        }

        .record-date .month { font-size: 10px; color: #3b82f6; font-weight: 700; text-transform: uppercase; }
        .record-date .day { font-size: 20px; color: #0f172a; font-weight: 800; margin-top: 2px; line-height: 1; }
        .record-date .dow { font-size: 10px; color: #94a3b8; font-weight: 600; margin-top: 4px; }

        /* --- RESPONSIVE FIXES --- */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(30, 41, 59, 0.4);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.35s ease;
            backdrop-filter: blur(2px);
        }

        .mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="page-fade-in">

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <div class="content">

        <header class="topbar flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-sm"></i>
                </button>

                <div class="hidden sm:block">
                    <h2 class="text-lg font-bold text-slate-800">Riwayat Perawatan</h2>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative w-9 h-9 rounded-full border border-slate-200 bg-white text-slate-500 hover:text-blue-600 transition">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                </button>

                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <img src="https://picsum.photos/seed/ayu/80/80" alt="Ayu" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                    <div class="hidden sm:block leading-tight text-right">
                        <div class="text-xs text-slate-500">Halo,</div>
                        <div class="text-sm font-bold text-slate-800">Ayu Nadila</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-5 sm:p-8">
            <div class="panel p-6 sm:p-8">

                <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Perawatan</h1>
                        <p class="mt-1 text-sm text-slate-500">Lihat riwayat lengkap perawatan gigi Anda</p>
                    </div>
                    <button class="self-start sm:self-end px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50 transition shadow-sm">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>

                <div class="flex gap-6 border-b border-slate-200 mb-6 overflow-x-auto">
                    <button class="tab active whitespace-nowrap">Semua</button>
                    <button class="tab whitespace-nowrap hover:text-slate-600">Perawatan</button>
                    <button class="tab whitespace-nowrap hover:text-slate-600">Konsultasi</button>
                    <button class="tab whitespace-nowrap hover:text-slate-600">Tindakan</button>
                </div>

                <div class="space-y-4">

                    <article class="record-card p-5 flex flex-col md:flex-row md:items-center gap-5">
                        <div class="record-date">
                            <div class="month">Mar</div>
                            <div class="day">20</div>
                            <div class="dow">KAM</div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Selesai</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Tambal Gigi</h3>
                            <p class="text-sm text-slate-500 font-medium">drg. Andi Wijaya</p>
                            <p class="mt-1 text-xs text-slate-400">Penambalan gigi geraham kiri bawah (komposit).</p>
                        </div>

                        <div class="flex items-center gap-3 md:ml-auto w-full md:w-auto justify-between md:justify-end">
                            <button class="px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold hover:bg-blue-100 transition border border-blue-100">
                                Lihat Detail
                            </button>
                            <button class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 transition" aria-label="menu">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                    </article>

                    <article class="record-card p-5 flex flex-col md:flex-row md:items-center gap-5">
                        <div class="record-date">
                            <div class="month">Feb</div>
                            <div class="day">16</div>
                            <div class="dow">RAB</div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Selesai</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Bleaching</h3>
                            <p class="text-sm text-slate-500 font-medium">drg. Putri Ananda</p>
                            <p class="mt-1 text-xs text-slate-400">Perawatan pemutihan gigi (In-Office Bleaching).</p>
                        </div>

                        <div class="flex items-center gap-3 md:ml-auto w-full md:w-auto justify-between md:justify-end">
                            <button class="px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold hover:bg-blue-100 transition border border-blue-100">
                                Lihat Detail
                            </button>
                            <button class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 transition" aria-label="menu">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                    </article>

                    <article class="record-card p-5 flex flex-col md:flex-row md:items-center gap-5">
                        <div class="record-date">
                            <div class="month">Jan</div>
                            <div class="day">11</div>
                            <div class="dow">SEN</div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Selesai</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Konsultasi Ortodonti</h3>
                            <p class="text-sm text-slate-500 font-medium">drg. Andi Wijaya</p>
                            <p class="mt-1 text-xs text-slate-400">Konsultasi awal untuk pemasangan behel metalik.</p>
                        </div>

                        <div class="flex items-center gap-3 md:ml-auto w-full md:w-auto justify-between md:justify-end">
                            <button class="px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold hover:bg-blue-100 transition border border-blue-100">
                                Lihat Detail
                            </button>
                            <button class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 transition" aria-label="menu">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                    </article>

                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>
