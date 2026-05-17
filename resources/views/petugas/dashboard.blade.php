<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                        },
                        success: '#10B981', // Hijau untuk angka positif
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: white;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            margin: 0 16px 8px 16px;
            border-radius: 12px;
            color: #64748b;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-item:hover {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .nav-item.active {
            background-color: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .nav-item.active i {
            color: #2563eb;
        }

        /* Card Hover Effect */
        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Table Row Hover */
        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        .page-transition {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.28s ease, transform 0.28s ease;
        }

        .page-transition.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .page-transition.is-leaving {
            opacity: 0;
            transform: translateY(8px);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="flex page-transition">

    <!-- ========== SIDEBAR PETUGAS ========== -->
    <aside class="sidebar">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p>
            </div>
        </div>

        <nav class="mt-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item active">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>
            <a href="/input-data-pasien" class="nav-item">
                <i class="fas fa-user-plus w-5 text-center"></i>
                <span>Input Data Pasien</span>
            </a>
            <a href="/jadwal-kontrol" class="nav-item">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span>Jadwal Kontrol</span>
            </a>
            <a href="/rekam-medis-petugas" class="nav-item">
                <i class="fas fa-file-medical w-5 text-center"></i>
                <span>Rekam Medis</span>
            </a>
            <a href="/keuangan" class="nav-item">
                <i class="fas fa-wallet w-5 text-center"></i>
                <span>Keuangan</span>
            </a>
            <a href="/laporan-petugas" class="nav-item">
                <i class="fas fa-box w-5 text-center"></i>
                <span>Inventaris Obat</span>
            </a>

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="/laporan-petugas" class="nav-item">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
                @csrf
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] p-6 lg:p-8">

        <!-- Header Top Bar -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Dashboard Petugas</h2>
                <p class="text-slate-500 text-sm">Ringkasan aktivitas klinik hari ini.</p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Search -->
                <div class="hidden md:flex items-center bg-white border border-gray-200 rounded-xl px-4 py-2">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Cari pasien..." class="ml-2 text-sm outline-none w-48 bg-transparent text-slate-600">
                </div>
                <!-- Notif -->
                <div class="relative cursor-pointer p-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </div>
                <!-- Profile -->
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">Siti Aminah</p>
                        <p class="text-xs text-primary-600 font-medium">Resepsionis</p>
                    </div>
                    <img src="https://picsum.photos/seed/admin/100/100" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </div>
            </div>
        </header>

        <!-- STATS CARDS (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pasien Hari Ini -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Pasien Hari Ini</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">24</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary-600">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> 12
                    </span>
                    <span class="ml-2 text-slate-400 text-xs">dari kemarin</span>
                </div>
            </div>

            <!-- Jadwal Kontrol -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Jadwal Kontrol</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">18</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> 5
                    </span>
                    <span class="ml-2 text-slate-400 text-xs">dari kemarin</span>
                </div>
            </div>

            <!-- Dokter Aktif -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Dokter Aktif</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">6</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-teal-100 text-teal-700 px-2 py-0.5 rounded-full text-xs font-bold">
                        Semua Tersedia
                    </span>
                </div>
            </div>

            <!-- Penerimaan -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Penerimaan Hari Ini</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">15</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> 3
                    </span>
                    <span class="ml-2 text-slate-400 text-xs">dari kemarin</span>
                </div>
            </div>
        </div>

        <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- KOLOM KIRI: JADWAL KONTROL (Wider) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Jadwal Kontrol Hari Ini</h3>
                    <button class="text-xs font-bold text-primary-600 border border-primary-200 bg-primary-50 px-3 py-1.5 rounded-lg hover:bg-primary-100 transition">
                        Lihat Semua
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                                <th class="pb-3">Waktu</th>
                                <th class="pb-3">Nama Pasien</th>
                                <th class="pb-3">Dokter</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <!-- Row 1 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600">08:00</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/p1/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">El Rumi</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600">dr. Andi Wijaya</td>
                                <td class="py-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-xs font-bold">Menunggu</span>
                                </td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600">09:30</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/p2/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Sylva Hodju</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600">drg. Rina Sari</td>
                                <td class="py-4">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-xs font-bold">Sedang Periksa</span>
                                </td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600">10:00</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/p3/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Budi Santoso</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600">dr. Andi Wijaya</td>
                                <td class="py-4">
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md text-xs font-bold">Selesai</span>
                                </td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600">11:30</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/p4/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Lesti Kejora</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600">drg. Budi Prasetyo</td>
                                <td class="py-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-xs font-bold">Menunggu</span>
                                </td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KOLOM KANAN: PASIEN TERBARU (Narrower) -->
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Pasien Terbaru</h3>
                    <button class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center hover:bg-primary-100 transition">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>

                <div class="space-y-4 overflow-y-auto pr-2 flex-1 max-h-[400px]">
                    <!-- List Item 1 -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="https://picsum.photos/seed/raffi/100/100" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">Raffi Ahmad</h4>
                                <p class="text-xs text-slate-500">0812-3456-xxxx</p>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-primary-600 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>

                    <!-- List Item 2 -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="https://picsum.photos/seed/nadia/100/100" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">Nadia Omara</h4>
                                <p class="text-xs text-slate-500">0813-9876-xxxx</p>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-primary-600 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>

                    <!-- List Item 3 -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="https://picsum.photos/seed/desta/100/100" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">Desta Mahendra</h4>
                                <p class="text-xs text-slate-500">0857-1122-xxxx</p>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-primary-600 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>

                    <!-- List Item 4 -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="https://picsum.photos/seed/vincent/100/100" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">Vincent Rompies</h4>
                                <p class="text-xs text-slate-500">0819-5555-xxxx</p>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-primary-600 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                    <button class="text-xs font-bold text-slate-500 hover:text-primary-600 transition">
                        Lihat Semua Pasien
                    </button>
                </div>
            </div>

        </div>
    </main>

    <script>
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

        document.querySelectorAll('a[href]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const href = link.getAttribute('href');

                if (!href || href.startsWith('#') || link.target === '_blank' || event.metaKey || event.ctrlKey) {
                    return;
                }

                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) {
                    return;
                }

                event.preventDefault();
                page.classList.add('is-leaving');
                setTimeout(() => {
                    window.location.href = targetUrl.href;
                }, 220);
            });
        });
    </script>
</body>
</html>
