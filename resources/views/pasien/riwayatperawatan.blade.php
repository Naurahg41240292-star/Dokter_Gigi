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
            overflow-x: hidden;
        }

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
            z-index: 50;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
            overflow-y: auto;
        }

        .sidebar nav { flex: 1; padding-top: 10px; }

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
            margin: 0 12px;
            position: relative;
        }

        .sidebar-link:hover { background-color: #eff6ff; color: var(--accent); }
        .sidebar-link i { width: 18px; text-align: center; font-size: 14px; }

        .sidebar-link.active { background-color: #eff6ff; color: var(--accent); font-weight: 600; }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link.text-red-500 { color: #ef4444; }
        .sidebar-link.text-red-500:hover { background: #fee2e2; color: #dc2626; }

        .content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
            transition: margin-left 0.35s ease;
        }

        .topbar {
            background: rgba(255,255,255,0.9); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid var(--line); 
            position: sticky; 
            top: 0; 
            z-index: 40;
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .notif-dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--line); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s ease; z-index: 60; width: 340px; border-radius: 16px; box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1); }
        .notif-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .online-dot { width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: 2px solid #fff; position: absolute; bottom: 0; right: 0; }

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

        .mobile-overlay.active { opacity: 1; pointer-events: auto; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; }
        }
    </style>
</head>
<body class="page-fade-in">

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <div class="content">

        <!-- TOPBAR -->
        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight" id="page-title">Riwayat Perawatan</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Lihat riwayat lengkap perawatan gigi Anda</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition-colors relative cursor-pointer" onclick="toggleNotif()" id="notifBtn">
                            <i class="fas fa-bell text-[15px]"></i>
                        </button>
                        <div class="notif-dropdown" id="notifDropdown">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900">Notifikasi</h4>
                                    <button class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">Tandai semua dibaca</button>
                                </div>
                            </div>
                            <div class="p-6 text-center text-sm text-gray-400">Belum ada notifikasi</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pl-3 pr-3 py-1 rounded-xl select-none">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                            <span class="online-dot"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 py-6">
            <div class="panel overflow-hidden">
                
                <!-- Header Tabel -->
                <div class="p-6 sm:p-8 border-b border-slate-100">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tabel Riwayat Pasien</h1>
                    <p class="mt-1 text-sm text-slate-500">Data diagnosa dan resep obat pasien</p>
                </div>

                <!-- TABEL YANG SUDAH DIATUR LEBAR KOLOMNYA -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        
                        <!-- Pengaturan Lebar Kolom agar Presisi -->
                        <colgroup>
                            <col class="w-[140px] md:w-[15%]"> <!-- Tanggal -->
                            <col class="w-[180px] md:w-[20%]"> <!-- Nama Pasien -->
                            <col class="md:w-[25%]">           <!-- Diagnosa -->
                            <col class="md:w-[25%]">           <!-- Resep Obat -->
                            <col class="w-[100px] md:w-[15%]"> <!-- Aksi -->
                        </colgroup>

                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200">
                                <th class="px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Diagnosa</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Resep Obat</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            
                            {{-- CONTOH DATA DINAMIS NANTI
                            @forelse($riwayats as $riwayat)
                            <tr class="hover:bg-slate-50 transition-colors align-middle">
                                <td class="px-5 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $riwayat->tanggal }}</td>
                                <td class="px-5 py-4 text-sm text-slate-800 font-semibold whitespace-nowrap">{{ $riwayat->nama_pasien }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $riwayat->diagnosa }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $riwayat->resep_obat }}</td>
                                <td class="px-5 py-4 text-center">
                                    <button class="px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold hover:bg-blue-100 transition border border-blue-100">Detail</button>
                                </td>
                            </tr>
                            @empty
                            --}}
                            
                            <!-- EMPTY STATE -->
                            <tr>
                                <td colspan="5" class="px-5 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-5 border border-slate-200">
                                            <i class="fas fa-folder-open text-3xl text-slate-400"></i>
                                        </div>
                                        <p class="text-base font-bold text-slate-700 mb-1">Belum ada data riwayat pasien</p>
                                        <p class="text-sm text-slate-400 max-w-xs mx-auto">Data diagnosa dan resep obat akan otomatis muncul di sini setelah Anda melakukan perawatan.</p>
                                    </div>
                                </td>
                            </tr>

                            {{-- TUTUP EMPTY FORELSE NANTI
                            @endforelse
                            --}}
                        </tbody>
                    </table>
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

        function toggleNotif() { 
            document.getElementById('notifDropdown').classList.toggle('open'); 
        }

        document.addEventListener('click', function(e) {
            const notifBtn = document.getElementById('notifBtn'); 
            const notifDrop = document.getElementById('notifDropdown');
            if (!notifBtn.contains(e.target) && !notifDrop.contains(e.target)) notifDrop.classList.remove('open');
        });
    </script>
</body>
</html>