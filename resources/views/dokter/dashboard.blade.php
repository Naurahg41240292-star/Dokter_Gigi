<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: #f8fafc;
            color: #1e293b;
        }

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
            transition: all .2s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-item.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .hover-card {
            transition: all .25s ease;
        }

        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(0,0,0,.06);
        }

        .table-row-hover:hover {
            background: #f8fafc;
        }

        .page-transition {
            opacity: 0;
            transform: translateY(8px);
            transition: .3s ease;
        }

        .page-transition.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }
        .notif-dropdown { transform: translateY(-10px); opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.2s ease; }
        .notif-dropdown.show { transform: translateY(0); opacity: 1; visibility: visible; pointer-events: auto; }
    </style>
</head>

<body class="flex page-transition">

    <!-- SIDEBAR -->
     <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-6 pt-8 pb-6 flex-shrink-0">
            <img src="{{ asset('images/logo (2).png') }}" alt="D'Smile Dental Clinic Logo" class="w-auto h-12 object-contain">
        </div>

        <!-- MENU -->
        <nav class="mt-4">
            <a href="{{ route('dokter.dashboard') }}" class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>

            <a href="{{ route('dokter.riwayat-pasien') }}" class="nav-item {{ request()->routeIs('dokter.riwayat-pasien') ? 'active' : '' }}">
                <i class="fas fa-notes-medical w-5 text-center"></i>
                <span>Riwayat Pasien</span>
            </a>

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="{{ route('dokter.pengaturan') }}" class="nav-item {{ request()->routeIs('dokter.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan Akun</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit"
                    class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">

                    <i class="fas fa-sign-out-alt w-5 text-center"></i>

                    <span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 ml-[260px] overflow-y-auto h-screen">

        <!-- TOP NAVBAR -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200 px-6 lg:px-8 py-4 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wide mb-1">
                        Dashboard
                    </p>

                    <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800">
                        Halo, {{ auth()->user()->name }}! 👋
                    </h2>
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">

                    <!-- SEARCH BAR -->
                    <div class="flex items-center bg-white border border-gray-200 rounded-xl px-4 py-2.5 w-full md:w-72 shadow-sm focus-within:ring-2 focus-within:ring-primary-500 transition">
                        <i class="fas fa-search text-gray-400 text-sm"></i>

                        <input type="text" id="searchPasien"
                            placeholder="Cari pasien..."
                            class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
                    </div>

                    <!-- NOTIFIKASI DROPDOWN -->
                  <div class="relative">
                    <button id="notif-btn" class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center focus:outline-none">
                        <i class="fas fa-bell text-slate-600"></i>
                        <span id="notif-dot" class="absolute top-1.5 right-1.5 w-5 h-5 bg-red-500 rounded-full border-2 border-white text-white text-[10px] flex items-center justify-center font-bold" style="display: none;">0</span>
                    </button>
                    
                    <div id="notif-dropdown" class="notif-dropdown absolute right-0 top-full mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                        <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-sm font-bold text-slate-800">Notifikasi Pasien</h3>
                        </div>
                        <div id="notif-list" class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                            <div class="p-4 text-center text-slate-400 text-sm">Memuat notifikasi...</div>
                        </div>
                    </div>
                </div>
                    <!-- SEPARATOR -->
                    <div class="h-8 w-px bg-gray-200 hidden md:block"></div>

                    <!-- PROFILE NAVBAR (DINAMIS) -->
                    <a href="{{ route('dokter.pengaturan') }}?open=profil" class="hidden md:flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1.5 pr-4 rounded-xl transition border border-transparent hover:border-gray-200">
                        <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" class="w-9 h-9 rounded-full object-cover border-2 border-primary-100">
                        <div>
                            <p class="text-sm font-bold text-slate-800 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ auth()->user()->spesialisasi ?? 'Dokter Gigi' }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                    </a>

                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="px-6 lg:px-8">

                           <!-- CARDS DINAMIS -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

                <!-- CARD: Pasien Hari Ini -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover-card">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-2">Pasien Hari Ini</p>
                            <h3 class="text-4xl font-extrabold text-slate-800">{{ $antrianHariIni->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-primary-600">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">Hari ini</span>
                        <span class="text-slate-400 text-xs">dari jadwal</span>
                    </div>
                </div>

                <!-- CARD: Menunggu Konfirmasi -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover-card">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-2">Menunggu Konfirmasi</p>
                            <h3 class="text-4xl font-extrabold text-slate-800">{{ $antrianHariIni->where('status', 'Menunggu Konfirmasi')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-yellow-50 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold">Pending</span>
                        <span class="text-slate-400 text-xs">perlu dicek</span>
                    </div>
                </div>

                <!-- CARD: Terjadwal / Sedang Diperiksa -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover-card">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-2">Terjadwal</p>
                            <h3 class="text-4xl font-extrabold text-slate-800">{{ $antrianHariIni->where('status', 'Terjadwal')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                    </div>
                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Siap diperiksa</span>
                </div>

                <!-- CARD: Selesai -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover-card">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-2">Selesai</p>
                            <h3 class="text-4xl font-extrabold text-slate-800">{{ $antrianHariIni->where('status', 'Selesai')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">Hari ini</span>
                </div>
            </div>

            <!-- JADWAL FULL -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-7 mb-8">

                <div class="flex justify-between items-center mb-6">

                    <div>
                        <h3 class="text-xl font-bold text-slate-800">
                            Jadwal Hari Ini
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            Daftar pemeriksaan pasien hari ini
                        </p>
                    </div>

                    <a href="{{ route('dokter.riwayat-pasien') }}" class="text-sm font-bold text-primary-600 bg-primary-50 px-4 py-2 rounded-xl hover:bg-primary-100 transition inline-block">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left" id="tabelPasien">

                        <thead>
                            <tr class="border-b border-slate-100 text-xs uppercase tracking-wider text-slate-400">
                                <th class="pb-4">Waktu</th>
                                <th class="pb-4">Nama Pasien</th>
                                <th class="pb-4">Keluhan</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                                                <!-- ID UNTUK JAVASCRIPT SEARCH -->
                        <tbody class="text-sm" id="bodyTabelPasien">
                            @forelse($antrianHariIni as $antrian)
                            <tr class="border-b border-slate-50 table-row-hover transition">
                               <td class="py-5 font-semibold text-slate-600">{{ $antrian->waktu }}</td>
                                <td class="py-5">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($antrian->nama_lengkap) }}&background=random" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-bold text-slate-700">{{ $antrian->nama_lengkap }}</p>
                                            <p class="text-xs text-slate-400">{{ $antrian->jenis_perawatan ?? 'Perawatan Umum' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 text-slate-500">{{ Str::limit($antrian->keluhan, 30) ?? '-' }}</td>
                                <td class="py-5">
                                    @if($antrian->status == 'Menunggu Konfirmasi')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                                    @elseif($antrian->status == 'Terjadwal')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Terjadwal</span>
                                    @elseif($antrian->status == 'Sedang Berjalan')
                                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-bold">Sedang Diperiksa</span>
                                    @elseif($antrian->status == 'Selesai')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">{{ $antrian->status }}</span>
                                    @endif
                                </td>
                                
                                <!-- BAGIAN AKSI YANG SUDAH DIUBAH -->
                                <td class="py-5 text-center">
                                    @if($antrian->status == 'Terjadwal')
                                        <a href="{{ route('dokter.rekam-medis.isi', $antrian->id) }}" 
                                        class="inline-flex items-center gap-2 bg-primary-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-primary-700 transition shadow-sm">
                                            <i class="fas fa-stethoscope text-[10px]"></i> Periksa
                                        </a>
                                    @elseif($antrian->status == 'Sedang Berjalan')
                                        <a href="{{ route('dokter.rekam-medis.isi', $antrian->id) }}" 
                                        class="inline-flex items-center gap-2 bg-teal-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-teal-700 transition shadow-sm">
                                            <i class="fas fa-file-medical text-[10px]"></i> Lanjut Isi RM
                                        </a>
                                    @elseif($antrian->status == 'Selesai')
                                        <span class="text-green-600 text-xs font-bold"><i class="fas fa-check-circle"></i> Selesai</span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Menunggu Konfirmasi</span>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-400 font-medium">
                                    <i class="fas fa-coffee text-3xl mb-3 block text-slate-300"></i>
                                    Belum ada antrian pasien hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BLUE INFO BOX -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-3xl p-8 shadow-xl shadow-blue-500/20 flex flex-col lg:flex-row justify-between items-center gap-6 overflow-hidden relative mb-8">

                <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-10 translate-x-10"></div>

                <div class="relative z-10">

                    <div class="flex items-center gap-4 mb-3">

                        <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-lg"></i>
                        </div>

                        <h4 class="text-2xl font-bold text-white">
                            Update Data Pasien Terbaru
                        </h4>
                    </div>

                    <p class="text-blue-100 text-sm leading-relaxed max-w-3xl">
                        Ada {{ $pasienHariIni ?? 0 }} data pasien baru yang perlu diperiksa lebih lanjut sebelum tindakan dilakukan. 
                        Pastikan riwayat kesehatan dan rekam medis pasien sudah diperiksa.
                    </p>
                </div>

                <button class="relative z-10 bg-white text-primary-700 px-7 py-3 rounded-2xl font-bold text-sm hover:bg-blue-50 transition hover:scale-105">
                    Lihat Data Pasien
                </button>
            </div>

        </div> <!-- End Content Area -->

    </main>

   <script>
    // 1. ANIMASI MUNCUL HALAMAN (INI YANG TADI KURANG)
    const page = document.body;
    requestAnimationFrame(() => page.classList.add('is-visible'));

    // 2. LOGIKA NOTIFIKASI
    document.addEventListener('DOMContentLoaded', function() {
        
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        const notifDot = document.getElementById('notif-dot');
        const notifList = document.getElementById('notif-list');

        if(notifBtn) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('show');
            });
            
            document.addEventListener('click', (e) => {
                if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                    notifDropdown.classList.remove('show');
                }
            });
        }

        function fetchNotifications() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route("dokter.notifikasi") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP status ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if(notifDot && notifList) {
                    if (data.count > 0 && Array.isArray(data.notifications)) {
                        notifDot.classList.remove('hidden'); 
                        notifDot.style.display = 'flex';     
                        
                        let htmlString = '';
                        data.notifications.forEach(item => {
                            htmlString += `
                                <a href="${item.url}" class="block px-5 py-3.5 hover:bg-slate-50 transition relative">
                                    <div class="flex gap-3">
                                        <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-stethoscope text-emerald-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-800">${item.pesan}</p>
                                            <p class="text-[10px] text-slate-400 mt-1.5 font-medium">${item.waktu}</p>
                                        </div>
                                    </div>
                                    <span class="absolute top-4 right-4 w-2 h-2 bg-emerald-500 rounded-full"></span>
                                </a>
                            `;
                        });
                        notifList.innerHTML = htmlString;

                    } else {
                        notifDot.classList.add('hidden'); 
                        notifDot.style.display = 'none';  
                        notifList.innerHTML = '<div class="px-5 py-6 text-center text-slate-400 text-xs"><i class="fas fa-bell-slash text-2xl mb-2 block"></i>Tidak ada notifikasi baru</div>';
                    }
                }
            })
            .catch(error => {
                console.warn('Gagal memuat notifikasi:', error.message);
            });
        }

        fetchNotifications();
        setInterval(fetchNotifications, 10000);

    });
</script>
</body>
</html>