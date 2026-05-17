<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - D'Smile</title>
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
                        success: '#10B981',
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

        /* Sidebar Style */
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

        /* Table & Card Hover */
        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
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

    <!-- ========== SIDEBAR DOKTER ========== -->
    <aside class="sidebar">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Dokter Panel</p>
            </div>
        </div>

        <!-- Dokter Profile Snippet -->
        <div class="px-6 mb-6 mt-4">
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                <img src="https://picsum.photos/seed/drgabriella/100/100" alt="Dokter" class="w-10 h-10 rounded-full object-cover border border-white">
                <div>
                    <p class="text-xs font-bold text-slate-800">dr. Gabriella Putri</p>
                    <p class="text-[10px] text-slate-500">Dokter Gigi</p>
                </div>
            </div>
        </div>

        <nav>
            <a href="{{ route('dokter.dashboard') }}" class="nav-item active">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>
            <a href="/jadwal-pasien" class="nav-item">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span>Input Data dan Jadwal Dokter</span>
            </a>
            <a href="/jadwal-pasien" class="nav-item">
                <i class="fas fa-user-injured w-5 text-center"></i>
                <span>Riwayat Pasien</span>
            </a>
            <a href="/rekam-medis-dokter" class="nav-item">
                <i class="fas fa-file-medical-alt w-5 text-center"></i>
                <span>Rekam Medis</span>
            </a>
            <a href="/pesan-pasien" class="nav-item">
                <i class="fas fa-comment-dots w-5 text-center"></i>
                <span>Pesan Pasien</span>
            </a>

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="/laporan-medis" class="nav-item">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan Akun</span>
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
    <main class="flex-1 ml-[260px] p-6 lg:p-8 overflow-y-auto h-screen">

        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <p class="text-slate-400 text-sm font-medium uppercase tracking-wide mb-1">Dashboard</p>
                <h2 class="text-2xl font-bold text-slate-800">Halo, dr. Gabriella! 👋</h2>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <!-- Search -->
                <div class="flex items-center bg-white border border-gray-200 rounded-xl px-4 py-2.5 w-full md:w-64">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Cari pasien..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
                </div>
                <!-- Notif -->
                <div class="relative cursor-pointer p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pasien Hari Ini -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Pasien Hari Ini</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">18</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary-600">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> 3
                    </span>
                    <span class="ml-2 text-slate-400 text-xs">dari kemarin</span>
                </div>
            </div>

            <!-- Janji Temu -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Janji Temu</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">12</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> 2
                    </span>
                    <span class="ml-2 text-slate-400 text-xs">dari kemarin</span>
                </div>
            </div>

            <!-- Hari Ini (Kunjungan) -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Sedang Diperiksa</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">6</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs font-bold">
                        Aktif sekarang
                    </span>
                </div>
            </div>

            <!-- Total Pasien -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Total Pasien</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">50</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full text-xs font-bold">
                        Keseluruhan
                    </span>
                </div>
            </div>
        </div>

        <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            <!-- KOLOM KIRI: JADWAL (Lebih Lebar) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Jadwal Hari Ini</h3>
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
                                <th class="pb-3">Keluhan / Tindakan</th>
                                <th class="pb-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <!-- Row 1 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600 w-24">09:00</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/doc1/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Budi Santoso</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-500">Scaling Gigi</td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto border border-gray-200">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600 w-24">10:30</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/doc2/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Siti Aminah</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-500">Cabut Gigi Bungsu</td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto border border-gray-200">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600 w-24">13:00</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="https://picsum.photos/seed/doc3/100/100" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-slate-700">Reza Rahadian</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-500">Konsultasi Ortodonti</td>
                                <td class="py-4 text-center">
                                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-primary-50 text-slate-400 hover:text-primary-600 transition flex items-center justify-center mx-auto border border-gray-200">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KOLOM KANAN: TREND CHART -->
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Tren Kunjungan</h3>
                    <button class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <!-- Simulated Bar Chart (CSS Only) -->
                <div class="flex-1 flex items-end justify-between gap-2 h-48 mt-4">
                    <!-- Mon -->
                    <div class="w-full bg-slate-100 rounded-t-lg relative group h-[40%] hover:bg-primary-400 transition-all">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-500 opacity-0 group-hover:opacity-100">40</div>
                    </div>
                    <!-- Tue -->
                    <div class="w-full bg-slate-100 rounded-t-lg relative group h-[60%] hover:bg-primary-400 transition-all">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-500 opacity-0 group-hover:opacity-100">60</div>
                    </div>
                    <!-- Wed -->
                    <div class="w-full bg-primary-600 rounded-t-lg relative group h-[85%] shadow-lg shadow-blue-500/20">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-primary-600">85</div>
                    </div>
                    <!-- Thu -->
                    <div class="w-full bg-slate-100 rounded-t-lg relative group h-[55%] hover:bg-primary-400 transition-all">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-500 opacity-0 group-hover:opacity-100">55</div>
                    </div>
                    <!-- Fri -->
                    <div class="w-full bg-slate-100 rounded-t-lg relative group h-[70%] hover:bg-primary-400 transition-all">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-500 opacity-0 group-hover:opacity-100">70</div>
                    </div>
                </div>

                <!-- Labels -->
                <div class="flex justify-between mt-2 text-xs text-slate-400 font-medium">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span>
                </div>
            </div>

        </div>

        <!-- NOTIFIKASI DATA PASIEN TERBARU (Blue Box) -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 md:p-8 shadow-lg shadow-blue-500/20 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full transform translate-x-10 -translate-y-10"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white">Update Data Pasien Terbaru!</h4>
                </div>
                <p class="text-blue-100 text-sm max-w-2xl">
                    Ada 3 data pasien baru yang perlu diperiksa secara mendalam sebelum tindakan dilakukan. Silakan periksa riwayat kesehatan gigi mereka.
                </p>
            </div>

            <div class="relative z-10 shrink-0">
                <button class="bg-white text-primary-700 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-blue-50 transition transform hover:scale-105">
                    Lihat Data Pasien
                </button>
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
