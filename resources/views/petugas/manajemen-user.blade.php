<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - D'Smile Dental Clinic</title>
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
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-item.active i { color: #2563eb; }
        .table-row-hover:hover { background-color: #f8fafc; }
    </style>
</head>
<body class="flex">

    <!-- ========== SIDEBAR PETUGAS ========== -->
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
            <a href="{{ route('petugas.dashboard') }}" class="nav-item">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item">
                <i class="fas fa-user-plus w-5 text-center"></i>
                <span>Input Data Pasien</span>
            </a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Data Pasien</span>
            </a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span>Jadwal Kontrol</span>
            </a>
            <!-- Menu Manajemen User Active -->
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item active">
                <i class="fas fa-users-cog w-5 text-center"></i>
                <span>Manajemen User</span>
            </a>

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="{{ route('petugas.pengaturan') }}" class="nav-item">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        <!-- Profil Pojok Kiri Bawah -->
        <div class="px-4 pb-4 border-t border-slate-100 pt-4">
            <a href="{{ route('petugas.pengaturan') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Petugas</p>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50 m-0 px-3">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] p-6 lg:p-8">

        <!-- Header -->
        <header class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 px-6 lg:px-8 pt-6 pb-5 mb-8 bg-white border-b border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manajemen User</h2>
                <p class="text-sm text-slate-500">Kelola persetujuan akun Dokter & Petugas baru.</p>
            </div>
        </header>

        <!-- TABEL MANAJEMEN USER -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3 pl-4">PENGGUNA</th>
                            <th class="pb-3">KONTAK</th>
                            <th class="pb-3">ROLE</th>
                            <th class="pb-3">TERDAFTAR</th>
                            <th class="pb-3">STATUS</th>
                            <th class="pb-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($users as $user)
                        <tr class="border-b border-gray-50 table-row-hover transition">
                            <td class="py-4 pl-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="py-4">
                                <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md text-xs font-bold uppercase">{{ $user->role->label() }}</span>
                            </td>
                            <td class="py-4 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-4">
                                @if($user->status === \App\Enums\Status::PENDING)
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-md text-xs font-bold">PENDING</span>
                                @elseif($user->status === \App\Enums\Status::APPROVED)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-xs font-bold">APPROVED</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-md text-xs font-bold">REJECTED</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                @if($user->status === \App\Enums\Status::PENDING)
                                    <form action="{{ route('petugas.approve-user', $user->id) }}" method="POST" class="inline-block">
                                        @csrf @method('PUT')
                                        <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-700 transition shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i> Setujui
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-xs italic">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <i class="fas fa-users text-4xl mb-3 block text-slate-300"></i>
                                Belum ada permintaan registrasi user baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </main>
</body>
</html>