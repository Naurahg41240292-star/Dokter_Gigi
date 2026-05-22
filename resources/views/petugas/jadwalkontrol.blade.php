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
                    colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-item.active i { color: #2563eb; }
        .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
        .hover-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .table-row-hover:hover { background-color: #f8fafc; }
    </style>
</head>
<body class="flex">

        <!-- ========== SIDEBAR PETUGAS (UNIVERSAL - AMAN) ========== -->
    <aside class="sidebar flex flex-col">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p>
            </div>
        </div>
        <nav class="mt-4 flex-1 overflow-y-auto">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i><span>Beranda</span>
            </a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}">
                <i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span>
            </a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item {{ request()->routeIs('petugas.data-pasien') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span>
            </a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item {{ request()->routeIs('petugas.jadwal-kontrol') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span>
            </a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item {{ request()->routeIs('petugas.manajemen-user') ? 'active' : '' }}">
                <i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span>
            </a>
            <div class="my-6 px-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>
    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] p-6 lg:p-8">

        <!-- Header Top Bar (Profil ada di pojok kanan atas) -->
        <header class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 px-6 lg:px-8 pt-6 pb-5 mb-8 bg-white border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="fas fa-tooth text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                    <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">ADMIN PANEL</p>
                </div>
            </div>
            <div class="hidden md:block text-center">
                <h2 class="text-xl font-bold text-slate-800">Jadwal Kontrol</h2>
                <p class="text-sm text-slate-500">Kelola dan pantau jadwal kontrol pasien hari ini.</p>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                <div class="hidden md:flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 w-full md:w-60">
                    <i class="fas fa-search text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Cari pasien..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
                </div>
                <div class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center">
                    <i class="fas fa-bell text-slate-600"></i>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                <!-- Profil Pojok Kanan Atas -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-primary-600 font-medium">Petugas</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

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
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Daftar Antrean Pasien</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">Waktu</th>
                            <th class="pb-3">Nama Pasien</th>
                            <th class="pb-3">Dokter</th>
                            <th class="pb-3">Perawatan</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($appointments as $item)
                        <tr class="border-b border-gray-50 table-row-hover transition">
                            <td class="py-4 font-medium text-slate-600 w-24">
                                @if($item->waktu) {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} @else {{ $item->created_at->format('H:i') }} @endif
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary-600 font-bold text-xs uppercase">
                                        {{ substr(($item->pasien->nama ?? $item->user->name ?? 'P'), 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $item->pasien->nama ?? $item->user->name ?? 'Pasien Umum' }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-slate-600">{{ $item->dokter }}</td>
                            <td class="py-4 text-slate-500">{{ $item->perawatan }}</td>
                            <td class="py-4">
                                @if($item->status == 'Selesai')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md text-xs font-bold">Selesai</span>
                                @elseif($item->status == 'Sedang Berjalan')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-xs font-bold">Sedang Berjalan</span>
                                @elseif($item->status == 'Dibatalkan')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-md text-xs font-bold">Dibatalkan</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-xs font-bold">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                @if(optional($item->pasien)->id)
                                    <a href="{{ route('petugas.edit-pasien', optional($item->pasien)->id) }}" class="inline-flex items-center gap-2 bg-primary-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-primary-700 transition shadow-sm">
                                        <i class="fas fa-file-medical"></i> Isi Rekam Medis
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs italic">Belum ada data pasien</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <i class="fas fa-calendar-times text-4xl mb-3 block"></i>Belum ada jadwal kontrol hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-center">
                {{ $appointments->links() }}
            </div>
        </div>

    </main>
</body>
</html>