<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kontrol - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' },
                    }
                }
            }
        }
    </script>
    <style>
        /* Background utama lebih biru */
        body { background-color: #eff6ff; color: #1e293b; }
        
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-item.active i { color: #2563eb; }
        
        .page-transition { opacity: 0; transform: translateY(8px); transition: opacity 0.28s ease, transform 0.28s ease; }
        .page-transition.is-visible { opacity: 1; transform: translateY(0); }
        .page-transition.is-leaving { opacity: 0; transform: translateY(8px); }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Animasi dropdown notifikasi */
        .notif-dropdown { transform: translateY(-10px); opacity: 0; visibility: hidden; transition: all 0.2s ease; }
        .notif-dropdown.show { transform: translateY(0); opacity: 1; visibility: visible; }
        
        /* Efek hover kartu */
        .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
        .hover-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        
        /* Efek baris tabel */
        .table-row-hover:hover { background-color: #f8fafc; }
    </style>
</head>
<body class="flex page-transition">

    <!-- ========== SIDEBAR ========== -->
    <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-6 pt-8 pb-6 flex-shrink-0">
            <img src="{{ asset('images/logo (2).png') }}" alt="D'Smile Dental Clinic Logo" class="w-auto h-12 object-contain">
        </div>

        <nav class="flex-1 overflow-y-auto mt-2 pb-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i><span>Beranda</span>
            </a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}">
                <i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span>
            </a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item {{ request()->routeIs('petugas.data-pasien') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span>
            </a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item active">
                <i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span>
            </a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item {{ request()->routeIs('petugas.manajemen-user') ? 'active' : '' }}">
                <i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span>
            </a>
            
            <div class="my-4 mx-8 border-t border-gray-100"></div>
            
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span>
            </a>
        </nav>

        <div class="flex-shrink-0 border-t border-slate-100 p-4 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50 m-0">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] min-h-screen">
        
       <!-- Header -->
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between gap-4 sticky top-0 z-40">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Jadwal Kontrol</h2>
                <p class="text-sm text-slate-500">Kelola dan pantau jadwal kontrol pasien hari ini.</p>
            </div>
            <div class="flex items-center gap-4">
                
                <!-- Notifikasi -->
                <div class="relative">
                    <button id="notif-btn" class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center focus:outline-none">
                        <i class="fas fa-bell text-slate-600"></i>
                        <span id="notif-dot" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white hidden"></span>
                    </button>

                    <div id="notif-dropdown" class="notif-dropdown absolute right-0 top-full mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                        <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                            <button id="read-all-btn" class="text-[11px] font-semibold text-primary-600 hover:text-primary-700 transition">Tandai dibaca</button>
                        </div>
                        <div id="notif-list" class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                            <div class="px-5 py-6 text-center text-slate-400 text-xs">Memuat notifikasi...</div>
                        </div>
                        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 text-center">
                            <a href="{{ route('petugas.jadwal-kontrol') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 transition">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div> <!-- INI PENUTUP DIV NOTIFIKASI YANG SEBELUMNYA HILANG -->

                <!-- Profil -->
                <a href="{{ route('petugas.pengaturan') }}" class="flex items-center gap-3 pl-4 border-l border-slate-200 hover:bg-slate-50 p-2 rounded-lg transition cursor-pointer">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-primary-600 font-medium">{{ auth()->user()->role ?? 'Petugas' }}</p>
                    </div>
                    <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </a>
                
            </div>
        </header>

        <!-- Area Konten -->
        <div class="p-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div><p class="text-slate-500 text-sm font-medium mb-1">Total Janji</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $totalJanji }}</h3></div>
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary-600"><i class="fas fa-calendar-check"></i></div>
                    </div>
                    <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs font-bold">Hari ini</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div><p class="text-slate-500 text-sm font-medium mb-1">Menunggu</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $menunggu }}</h3></div>
                        <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500"><i class="fas fa-clock"></i></div>
                    </div>
                    <span class="bg-yellow-50 text-yellow-600 px-2 py-0.5 rounded-full text-xs font-bold">Antrian</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div><p class="text-slate-500 text-sm font-medium mb-1">Sedang Diperiksa</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $sedangPeriksa }}</h3></div>
                        <div class="w-10 h-10 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-600"><i class="fas fa-stethoscope"></i></div>
                    </div>
                    <span class="bg-cyan-50 text-cyan-600 px-2 py-0.5 rounded-full text-xs font-bold">Aktif</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div><p class="text-slate-500 text-sm font-medium mb-1">Selesai</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $selesai }}</h3></div>
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <span class="bg-green-50 text-green-600 px-2 py-0.5 rounded-full text-xs font-bold">Tuntas</span>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list-ol text-primary-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Daftar Antrean Pasien</h3>
                            <p class="text-xs text-slate-500">Jadwal kontrol hari ini</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Perawatan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse ($appointments as $item)
                        <tr class="hover:bg-slate-50/50 transition table-row-hover">
                            <td class="px-6 py-4 font-medium text-slate-600 w-24">
                                {{ $item->waktu ?? $item->created_at->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar disederhanakan agar tidak error -->
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($item->pasien)->nama ?? optional($item->user)->name ?? 'P') }}&background=2563eb&color=fff" class="w-8 h-8 rounded-full shadow-sm object-cover" alt="Avatar">
                                    
                                    <span class="font-semibold text-slate-800">{{ optional($item->pasien)->nama ?? optional($item->user)->name ?? 'Pasien Umum' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->dokter ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $item->jenis_perawatan ?? '-' }}</td>
                            <!-- KOLOM STATUS -->
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'Menunggu Konfirmasi')
                                    <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Menunggu Konfirmasi</span>
                                @elseif($item->status == 'Terjadwal')
                                    <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Terjadwal</span>
                                @elseif($item->status == 'Sedang Berjalan')
                                    <span class="bg-teal-50 text-teal-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Sedang Berjalan</span>
                                @elseif($item->status == 'Selesai')
                                    <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Selesai</span>
                                @elseif($item->status == 'Dibatalkan')
                                    <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Dibatalkan</span>
                                @else
                                    <span class="bg-slate-50 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if($item->status == 'Menunggu Konfirmasi')
                                    <!-- Tombol Konfirmasi -->
                                    <form action="{{ route('petugas.konfirmasi-appointment', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-3 py-2 rounded-lg text-[11px] font-bold hover:bg-emerald-700 transition shadow-sm">
                                            <i class="fas fa-check text-[10px]"></i> Konfirmasi
                                        </button>
                                    </form>
                                @elseif($item->status == 'Terjadwal')
                                    <!-- Tombol Edit Data Pasien -->
                                    @if(optional($item->pasien)->id)
                                        <a href="{{ route('petugas.edit-pasien', $item->pasien->id) }}" class="inline-flex items-center gap-2 bg-primary-600 text-white px-3 py-2 rounded-lg text-[11px] font-bold hover:bg-primary-700 transition shadow-sm">
                                            <i class="fas fa-user-edit text-[10px]"></i> Edit Pasien
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Belum ada data pasien</span>
                                    @endif
                                @elseif($item->status == 'Selesai')
                                    <!-- Tombol Lihat Rekam Medis (BARU) -->
                                    <a href="{{ route('petugas.lihat-rekam-medis', $item->id) }}" class="inline-flex items-center gap-2 bg-teal-600 text-white px-3 py-2 rounded-lg text-[11px] font-bold hover:bg-teal-700 transition shadow-sm">
                                        <i class="fas fa-file-medical-alt text-[10px]"></i> Lihat RM
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs italic">{{ $item->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <i class="fas fa-calendar-times text-4xl mb-3 block text-slate-300"></i>
                                Belum ada jadwal kontrol hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($appointments->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-center">
                    {{ $appointments->links() }}
                </div>
                @endif
            </div>

        </div>
    </main>

    <script>
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

        // Script Notifikasi
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        const readAllBtn = document.getElementById('read-all-btn');
        const notifDot = document.getElementById('notif-dot');

        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });

        readAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('#notif-dropdown .bg-primary-600.rounded-full.w-2').forEach(dot => dot.remove());
            document.querySelectorAll('#notif-dropdown .bg-primary-50\\/30').forEach(bg => bg.classList.remove('bg-primary-50/30'));
            if(notifDot) notifDot.style.display = 'none';
        });

        // Script Animasi Pindah Halaman
        document.querySelectorAll('a[href]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const href = link.getAttribute('href');
                if (!href || href.startsWith('#') || link.target === '_blank' || event.metaKey || event.ctrlKey) return;
                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) return;
                event.preventDefault();
                page.classList.add('is-leaving');
                setTimeout(() => { window.location.href = targetUrl.href; }, 220);
            });
        });
    </script>
</body>
</html>