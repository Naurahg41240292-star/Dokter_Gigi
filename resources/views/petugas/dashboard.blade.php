<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } }
                }
            }
        }
    </script>
    <style>
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
        .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
        .hover-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .table-row { cursor: pointer; transition: background-color 0.15s; }
        .table-row:hover { background-color: #f8fafc; }
        .table-row.selected { background-color: #eff6ff; }
        .notif-dropdown { transform: translateY(-10px); opacity: 0; visibility: hidden; transition: all 0.2s ease; }
        .notif-dropdown.show { transform: translateY(0); opacity: 1; visibility: visible; }
    </style>
</head>
<body class="flex page-transition">

    <!-- ========== SIDEBAR ========== -->
    <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3 flex-shrink-0">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30"><i class="fas fa-tooth text-white text-lg"></i></div>
            <div><h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1><p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p></div>
        </div>
        <nav class="flex-1 overflow-y-auto mt-2 pb-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item active"><i class="fas fa-home w-5 text-center"></i><span>Beranda</span></a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}"><i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span></a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item {{ request()->routeIs('petugas.data-pasien') ? 'active' : '' }}"><i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span></a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item {{ request()->routeIs('petugas.jadwal-kontrol') ? 'active' : '' }}"><i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span></a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item {{ request()->routeIs('petugas.manajemen-user') ? 'active' : '' }}"><i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span></a>
            <div class="my-4 mx-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}"><i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span></a>
        </nav>
        <div class="flex-shrink-0 border-t border-slate-100 p-4 mt-auto">
            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50 m-0"><i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span></button></form>
        </div>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] min-h-screen">
        
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between gap-4 sticky top-0 z-40">
            <div><h2 class="text-xl font-bold text-slate-800">Dashboard Petugas</h2><p class="text-sm text-slate-500">Ringkasan aktivitas klinik hari ini.</p></div>
            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                <div class="hidden md:flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 w-full md:w-60"><i class="fas fa-search text-slate-400 text-sm"></i><input type="text" placeholder="Cari pasien..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600"></div>
                <div class="relative">
                    <button id="notif-btn" class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center focus:outline-none"><i class="fas fa-bell text-slate-600"></i><span id="notif-dot" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span></button>
                    <div id="notif-dropdown" class="notif-dropdown absolute right-0 top-full mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                        <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 bg-slate-50/50"><h3 class="text-sm font-bold text-slate-800">Notifikasi</h3><button id="read-all-btn" class="text-[11px] font-semibold text-primary-600 hover:text-primary-700 transition">Tandai dibaca</button></div>
                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-50"><a href="#" class="block px-5 py-3.5 hover:bg-slate-50 transition relative"><div class="flex gap-3"><div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fas fa-user-plus text-primary-600 text-xs"></i></div><div><p class="text-xs font-semibold text-slate-800">Pasien Baru Terdaftar</p><p class="text-[11px] text-slate-500 mt-0.5">Rina Wati baru saja mendaftar.</p><p class="text-[10px] text-slate-400 mt-1.5 font-medium">5 menit yang lalu</p></div></div><span class="absolute top-4 right-4 w-2 h-2 bg-primary-600 rounded-full"></span></a></div>
                        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 text-center"><a href="#" class="text-xs font-bold text-primary-600 hover:text-primary-700 transition">Lihat Semua Notifikasi</a></div>
                    </div>
                </div>
                <a href="{{ route('petugas.pengaturan') }}" class="flex items-center gap-3 pl-4 border-l border-slate-200 hover:bg-slate-50 p-2 rounded-lg transition cursor-pointer">
                    <div class="text-right hidden sm:block"><p class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</p><p class="text-xs text-primary-600 font-medium">{{ auth()->user()->role ?? 'Petugas' }}</p></div>
                    <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </a>
            </div>
        </header>

        <div class="p-8">

            @if (session('success'))<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert"><i class="fas fa-check-circle"></i><span class="font-medium">{{ session('success') }}</span></div>@endif

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card"><div class="flex justify-between items-start mb-4"><div><p class="text-slate-500 text-sm font-medium mb-1">Pasien Hari Ini</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $pasienHariIni }}</h3></div><div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500"><i class="fas fa-calendar-check"></i></div></div><span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs font-bold">Kunjungan</span></div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card"><div class="flex justify-between items-start mb-4"><div><p class="text-slate-500 text-sm font-medium mb-1">Selesai Diperiksa</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $selesaiHariIni }}</h3></div><div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500"><i class="fas fa-check-circle"></i></div></div><span class="bg-green-50 text-green-600 px-2 py-0.5 rounded-full text-xs font-bold">Tuntas</span></div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card"><div class="flex justify-between items-start mb-4"><div><p class="text-slate-500 text-sm font-medium mb-1">Total Pasien</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $totalPasien }}</h3></div><div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-500"><i class="fas fa-users"></i></div></div><span class="bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full text-xs font-bold">Keseluruhan</span></div>
                <!-- Kartu ke-4 yang diperbaiki -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card"><div class="flex justify-between items-start mb-4"><div><p class="text-slate-500 text-sm font-medium mb-1">Dokter Aktif</p><h3 class="text-3xl font-extrabold text-slate-800">{{ $dokterAktif }}</h3></div><div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500"><i class="fas fa-user-md"></i></div></div><span class="bg-orange-50 text-orange-600 px-2 py-0.5 rounded-full text-xs font-bold">Klinik</span></div>
            </div>

            <!-- CONTENT GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 flex items-center justify-between border-b border-slate-100">
                        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center"><i class="fas fa-list-ol text-primary-600"></i></div><div><h3 class="text-sm font-bold text-slate-800">Jadwal Kontrol Hari Ini</h3><p class="text-xs text-slate-500">Antrean hari ini</p></div></div>
                        <a href="{{ route('petugas.jadwal-kontrol') }}" class="text-[11px] font-bold text-primary-600 border border-primary-200 bg-primary-50 px-3 py-1.5 rounded-lg hover:bg-primary-100 transition">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead><tr class="bg-slate-50/80 border-b border-slate-100"><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pasien</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th></tr></thead>
                            <tbody class="divide-y divide-slate-50 text-sm">
                                @forelse ($jadwalHariIni as $rm)
                                <tr class="hover:bg-slate-50/50 transition table-row">
                                    <td class="px-6 py-4 font-medium text-slate-600 w-24">{{ $rm->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4"><div class="flex items-center gap-3"><img src="{{ isset($rm->pasien) && $rm->pasien->foto ? asset('storage/' . $rm->pasien->foto) : 'https://ui-avatars.com/api/?name='.urlencode($rm->pasien->nama ?? 'P').'&background=2563eb&color=fff' }}" class="w-8 h-8 rounded-full shadow-sm object-cover" alt="Avatar"><span class="font-semibold text-slate-800">{{ $rm->pasien->nama ?? 'Pasien Umum' }}</span></div></td>
                                    <td class="px-6 py-4 text-slate-600">{{ $rm->dokter }}</td>
                                    <td class="px-6 py-4 text-center">@if($rm->status == 'Selesai')<span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-md text-[11px] font-bold">Selesai</span>@else<span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-md text-[11px] font-bold">{{ $rm->status }}</span>@endif</td>
                                    <td class="px-6 py-4 text-right">@if(optional($rm->pasien)->id)<a href="{{ route('petugas.edit-pasien', optional($rm->pasien)->id) }}" class="inline-flex items-center gap-2 bg-primary-600 text-white px-3 py-2 rounded-lg text-[11px] font-bold hover:bg-primary-700 transition shadow-sm"><i class="fas fa-file-medical text-[10px]"></i> Rekam Medis</a>@endif</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="py-16 text-center text-slate-400"><i class="fas fa-calendar-times text-4xl mb-3 block text-slate-300"></i>Belum ada jadwal kontrol hari ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full overflow-hidden">
                    <div class="p-6 flex items-center justify-between border-b border-slate-100">
                         <div class="flex items-center gap-3"><div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center"><i class="fas fa-user-clock text-purple-600"></i></div><div><h3 class="text-sm font-bold text-slate-800">Pasien Terbaru</h3><p class="text-xs text-slate-500">Data yang baru terdaftar</p></div></div>
                    </div>
                    <div class="p-6 space-y-4 overflow-y-auto flex-1">
                        @forelse ($pasienTerbaru as $pasien)
                        <a href="{{ route('petugas.edit-pasien', $pasien->id) }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <img src="{{ isset($pasien->foto) && $pasien->foto ? asset('storage/' . $pasien->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pasien->nama).'&background=2563eb&color=fff' }}" class="w-10 h-10 rounded-full shadow-sm object-cover" alt="Avatar">
                                <div><h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">{{ $pasien->nama }}</h4><p class="text-xs text-slate-500">NIK: {{ $pasien->nik }}</p></div>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $pasien->created_at->format('d M') }}</span>
                        </a>
                        @empty
                        <div class="py-10 text-center text-slate-400"><i class="fas fa-user-plus text-3xl mb-2 block text-slate-300"></i>Belum ada pasien baru.</div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50 text-center"><a href="{{ route('petugas.data-pasien') }}" class="text-xs font-bold text-slate-500 hover:text-primary-600 transition">Lihat Semua Pasien</a></div>
                </div>
            </div>

        </div>
    </main>

    <script>
        const page = document.body; requestAnimationFrame(() => page.classList.add('is-visible'));
        const notifBtn = document.getElementById('notif-btn'); const notifDropdown = document.getElementById('notif-dropdown'); const readAllBtn = document.getElementById('read-all-btn'); const notifDot = document.getElementById('notif-dot');
        notifBtn.addEventListener('click', (e) => { e.stopPropagation(); notifDropdown.classList.toggle('show'); });
        document.addEventListener('click', (e) => { if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) notifDropdown.classList.remove('show'); });
        readAllBtn.addEventListener('click', (e) => { e.preventDefault(); document.querySelectorAll('#notif-dropdown .bg-primary-600.rounded-full.w-2').forEach(dot => dot.remove()); if(notifDot) notifDot.style.display = 'none'; });
        document.querySelectorAll('.table-row').forEach(row => { row.addEventListener('click', function(e) { if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) return; document.querySelectorAll('.table-row.selected').forEach(r => r.classList.remove('selected')); this.classList.add('selected'); }); });
        document.querySelectorAll('a[href]').forEach((link) => { link.addEventListener('click', (event) => { const href = link.getAttribute('href'); if (!href || href.startsWith('#') || link.target === '_blank' || event.metaKey || event.ctrlKey) return; const targetUrl = new URL(href, window.location.origin); if (targetUrl.origin !== window.location.origin) return; event.preventDefault(); page.classList.add('is-leaving'); setTimeout(() => { window.location.href = targetUrl.href; }, 220); }); });
    </script>
</body>
</html>