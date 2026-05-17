<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment & Riwayat - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            --bg: #eff6ff;         /* Latar belakang halaman */
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

        /* Main Content Layout */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content header {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .main-content main {
            padding: 24px 32px;
            background: var(--bg);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #93c5fd; }

        /* Sidebar Styling */
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
            overflow-y: auto;
        }

        /* Sidebar Link Styling */
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
            text-decoration: none;
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

        /* Indikator Aktif (Garis Biru di Kiri) */
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
            padding: 16px 20px 8px 20px;
            margin: 0 12px;
        }

        /* Badge Status Colors */
        .badge-confirmed { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-pending { background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
        .badge-completed { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Hover Effect untuk List Item */
        .list-item-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border-color: #bfdbfe;
        }

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
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="page-fade-in">

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <div class="main-content">

        <header class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-sm"></i>
                </button>

                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Pasien</p>
                    <h2 class="text-lg md:text-2xl font-bold text-slate-800" id="page-title">Appointment Saya</h2>
                </div>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <div class="hidden md:flex items-center bg-white border border-slate-200 rounded-xl px-4 py-2">
                    <i class="fas fa-search text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Cari dokter..." class="ml-2 text-sm outline-none w-32 md:w-40 bg-transparent text-slate-600">
                </div>
                <div class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">Aprilia Ajeng W</p>
                        <p class="text-[11px] text-slate-400">G41240104</p>
                    </div>
                    <img src="https://picsum.photos/seed/aprilia/100/100" alt="Pasien" class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </div>
            </div>
        </header>

        <main>
            <section id="view-appointment" class="space-y-6 animate-fade-in">

                <div class="flex gap-2 md:gap-4 overflow-x-auto pb-2">
                    <button class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-bold shadow-sm shadow-blue-200 whitespace-nowrap">Semua</button>
                    <button class="px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-sm font-bold hover:bg-slate-50 whitespace-nowrap">Mendatang</button>
                    <button class="px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-sm font-bold hover:bg-slate-50 whitespace-nowrap">Selesai</button>
                </div>

                <div class="space-y-4">

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 list-item-hover transition-all duration-300">
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="bg-primary-50 text-primary-700 rounded-xl px-4 py-3 text-center min-w-[70px] border border-primary-100 flex-shrink-0">
                                <p class="text-xs font-bold uppercase">Apr</p>
                                <p class="text-2xl font-extrabold leading-none mt-1">16</p>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-800 text-lg truncate">Scaling Gigi Rutin</h4>
                                <p class="text-slate-500 text-sm flex items-center gap-2 mt-1">
                                    <i class="fas fa-user-md text-xs"></i> drg. Andi Wijoya
                                </p>
                                <p class="text-slate-400 text-xs mt-1">
                                    <i class="far fa-clock text-xs"></i> 09:00 - 09:45 WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 md:gap-4 w-full md:w-auto justify-between md:justify-end flex-shrink-0">
                            <span class="badge-confirmed px-3 py-1 rounded-full text-xs font-bold">
                                Terjadwal
                            </span>
                            <button class="w-8 h-8 rounded-full bg-slate-50 hover:bg-red-50 hover:text-red-500 text-slate-400 transition flex items-center justify-center border border-slate-200" title="Batalkan">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 list-item-hover transition-all duration-300">
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="bg-primary-50 text-primary-700 rounded-xl px-4 py-3 text-center min-w-[70px] border border-primary-100 flex-shrink-0">
                                <p class="text-xs font-bold uppercase">Apr</p>
                                <p class="text-2xl font-extrabold leading-none mt-1">28</p>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-800 text-lg truncate">Konsultasi Ortodonti</h4>
                                <p class="text-slate-500 text-sm flex items-center gap-2 mt-1">
                                    <i class="fas fa-user-md text-xs"></i> drg. Rina Sari
                                </p>
                                <p class="text-slate-400 text-xs mt-1">
                                    <i class="far fa-clock text-xs"></i> 13:30 - 14:30 WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 md:gap-4 w-full md:w-auto justify-between md:justify-end flex-shrink-0">
                            <span class="badge-pending px-3 py-1 rounded-full text-xs font-bold">
                                Menunggu Konfirmasi
                            </span>
                            <button class="w-8 h-8 rounded-full bg-slate-50 hover:bg-red-50 hover:text-red-500 text-slate-400 transition flex items-center justify-center border border-slate-200" title="Batalkan">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 list-item-hover transition-all duration-300 opacity-75">
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="bg-slate-100 text-slate-500 rounded-xl px-4 py-3 text-center min-w-[70px] border border-slate-200 flex-shrink-0">
                                <p class="text-xs font-bold uppercase">Mar</p>
                                <p class="text-2xl font-extrabold leading-none mt-1">10</p>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-800 text-lg truncate">Penambalan Gigi</h4>
                                <p class="text-slate-500 text-sm flex items-center gap-2 mt-1">
                                    <i class="fas fa-user-md text-xs"></i> dr. Budi Prasetyo
                                </p>
                                <p class="text-slate-400 text-xs mt-1">
                                    <i class="far fa-clock text-xs"></i> 10:00 - 10:30 WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end flex-shrink-0">
                            <span class="badge-completed px-3 py-1 rounded-full text-xs font-bold">
                                Selesai
                            </span>
                            <button class="text-primary-600 text-xs font-bold hover:underline">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                </div>
            </section>

            <section id="view-history" class="hidden space-y-6 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <h3 class="font-bold text-slate-800">Daftar Riwayat Medis</h3>
                        <button class="text-primary-600 text-xs font-bold border border-primary-200 bg-primary-50 px-3 py-1.5 rounded-lg hover:bg-primary-100 transition w-full sm:w-auto">
                            <i class="fas fa-download mr-1"></i> Download PDF
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100">

                        <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex gap-4 w-full md:w-auto">
                                <div class="flex flex-col items-center min-w-[60px]">
                                    <span class="text-2xl font-bold text-slate-700">20</span>
                                    <span class="text-xs font-bold text-slate-400 uppercase">Mar</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-base truncate">Pembersihan Karang Gigi (Scaling)</h4>
                                    <div class="flex items-center gap-2 md:gap-4 mt-1 flex-wrap">
                                        <span class="text-xs text-slate-500"><i class="fas fa-user-md text-primary-500 mr-1"></i> drg. Andi Wijoya</span>
                                        <span class="text-xs text-slate-400 hidden md:inline">|</span>
                                        <span class="text-xs text-slate-500">Ruang 202</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-2 italic">"Pembersihan menyeluruh, gigi bersih, dianjurkan kontrol 6 bulan lagi."</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                                <span class="badge-completed px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                <button class="w-8 h-8 rounded-full bg-slate-100 hover:bg-primary-100 text-slate-500 hover:text-primary-600 transition flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex gap-4 w-full md:w-auto">
                                <div class="flex flex-col items-center min-w-[60px]">
                                    <span class="text-2xl font-bold text-slate-700">16</span>
                                    <span class="text-xs font-bold text-slate-400 uppercase">Apr</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-base truncate">Cabut Gigi Bungsu</h4>
                                    <div class="flex items-center gap-2 md:gap-4 mt-1 flex-wrap">
                                        <span class="text-xs text-slate-500"><i class="fas fa-user-md text-primary-500 mr-1"></i> drg. Budi Prasetyo</span>
                                        <span class="text-xs text-slate-400 hidden md:inline">|</span>
                                        <span class="text-xs text-slate-500">Ruang 305 (Operasi)</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-2 italic">"Proses berjalan lancar, pasien disarankan istirahat."</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                                <span class="badge-completed px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                <button class="w-8 h-8 rounded-full bg-slate-100 hover:bg-primary-100 text-slate-500 hover:text-primary-600 transition flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex gap-4 w-full md:w-auto">
                                <div class="flex flex-col items-center min-w-[60px]">
                                    <span class="text-2xl font-bold text-slate-700">11</span>
                                    <span class="text-xs font-bold text-slate-400 uppercase">Apr</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-base truncate">Konsultasi Sakit Gigi</h4>
                                    <div class="flex items-center gap-2 md:gap-4 mt-1 flex-wrap">
                                        <span class="text-xs text-slate-500"><i class="fas fa-user-md text-primary-500 mr-1"></i> drg. Rina Sari</span>
                                        <span class="text-xs text-slate-400 hidden md:inline">|</span>
                                        <span class="text-xs text-slate-500">Ruang 101</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-2 italic">"Diagnosa radang gusi, diberikan resep obat kumur."</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                                <span class="badge-completed px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                <button class="w-8 h-8 rounded-full bg-slate-100 hover:bg-primary-100 text-slate-500 hover:text-primary-600 transition flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Fungsi untuk mengganti tampilan halaman
        function switchView(viewName) {
            document.getElementById('view-appointment').classList.add('hidden');
            document.getElementById('view-history').classList.add('hidden');

            const navIds = ['nav-appointment', 'nav-history', 'nav-dashboard'];
            navIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('active');
            });

            if (viewName === 'appointment') {
                document.getElementById('view-appointment').classList.remove('hidden');
                document.getElementById('nav-appointment').classList.add('active');
                document.getElementById('page-title').innerText = "Appointment Saya";
            }
            else if (viewName === 'history') {
                document.getElementById('view-history').classList.remove('hidden');
                document.getElementById('nav-history').classList.add('active');
                document.getElementById('page-title').innerText = "Riwayat Perawatan";
            }
            else if (viewName === 'dashboard') {
                document.getElementById('view-appointment').classList.remove('hidden');
                document.getElementById('nav-dashboard').classList.add('active');
                document.getElementById('page-title').innerText = "Beranda";
            }

            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }
    </script>
</body>
</html>
