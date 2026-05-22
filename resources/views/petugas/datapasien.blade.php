<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - D'Smile Dental Clinic</title>
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
        .table-row { cursor: pointer; transition: background-color 0.15s ease-in-out; }
        .table-row:hover { background-color: #f8fafc; }
        .table-row.selected { background-color: #eff6ff; }
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

        <!-- Header Top Bar -->
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
                <h2 class="text-xl font-bold text-slate-800">Data Pasien</h2>
                <p class="text-sm text-slate-500">Daftar seluruh pasien yang terdaftar di sistem.</p>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                <div class="hidden md:flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 w-full md:w-60">
                    <i class="fas fa-search text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Cari pasien..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
                </div>
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

        <!-- TABEL DATA PASIEN -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Daftar Pasien</h3>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg">Total: {{ $pasiens->total() }} Pasien</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3 pl-4">NO</th>
                            <th class="pb-3">NAMA PASIEN</th>
                            <th class="pb-3">NIK</th>
                            <th class="pb-3">JENIS KELAMIN</th>
                            <th class="pb-3">GOL. DARAH</th>
                            <th class="pb-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($pasiens as $index => $pasien)
                        <tr class="border-b border-gray-50 table-row transition">
                            <td class="py-4 pl-4 text-slate-500 font-medium">{{ $pasiens->firstItem() + $index }}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs uppercase">
                                        {{ substr($pasien->nama, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $pasien->nama }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-slate-600">{{ $pasien->nik }}</td>
                            <td class="py-4 text-slate-600">{{ $pasien->jenis_kelamin ?? '-' }}</td>
                            <td class="py-4 text-slate-600">{{ $pasien->golongan_darah ?? '-' }}</td>
                            <td class="py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('petugas.edit-pasien', $pasien->id) }}" class="bg-amber-500 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-amber-600 transition shadow-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('petugas.hapus-pasien', $pasien->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pasien ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-sm">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <i class="fas fa-users text-4xl mb-3 block text-slate-300"></i>
                                Belum ada data pasien. Silakan input data pasien baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-center">
                {{ $pasiens->links() }}
            </div>
        </div>

    </main>

    <script>
        // Efek klik baris biru
        document.querySelectorAll('.table-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) return;
                document.querySelectorAll('.table-row.selected').forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    </script>
</body>
</html>