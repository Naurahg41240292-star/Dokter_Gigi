<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pasien - D'Smile</title>

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
        body { background: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all .2s; cursor: pointer; }
        .nav-item:hover { background: #eff6ff; color: #2563eb; }
        .nav-item.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
        .hover-card { transition: all .25s ease; }
        .hover-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(0,0,0,.06); }
        .table-row-hover:hover { background: #f8fafc; }
        .page-transition { opacity: 0; transform: translateY(8px); transition: .3s ease; }
        .page-transition.is-visible { opacity: 1; transform: translateY(0); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        /* CSS NOTIFIKASI (Pointer events none agar tidak menutupi klik) */
        .notif-dropdown { transform: translateY(-10px); opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.2s ease; }
        .notif-dropdown.show { transform: translateY(0); opacity: 1; visibility: visible; pointer-events: auto; }
    </style>
    <!-- HAPUS DUPLICATE </style> DI SINI -->
</head>

<body class="flex page-transition">

    <!-- SIDEBAR -->
     <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-6 pt-8 pb-6 flex-shrink-0">
            <img src="{{ asset('images/logo (2).png') }}" alt="D'Smile Dental Clinic Logo" class="w-auto h-12 object-contain">
        </div>

        <nav class="mt-4">
            <a href="{{ route('dokter.dashboard') }}" class="nav-item">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>

            <a href="{{ route('dokter.riwayat-pasien') }}" class="nav-item active">
                <i class="fas fa-notes-medical w-5 text-center"></i>
                <span>Riwayat Pasien</span>
            </a>

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="{{ route('dokter.pengaturan') }}" class="nav-item">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan Akun</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">
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
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wide mb-1">Manajemen Data</p>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800">Riwayat Pasien 📋</h2>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    
                    <!-- SEARCH BAR DENGAN ID -->
                    <div class="flex items-center bg-white border border-gray-200 rounded-xl px-4 py-2.5 w-full md:w-72 shadow-sm focus-within:ring-2 focus-within:ring-primary-500 transition">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                        <input type="text" id="searchRiwayat" placeholder="Cari riwayat pasien..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
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

                    <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
                    
                    <!-- PROFILE NAVBAR DINAMIS -->
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
            
            <!-- ALERT SUCCESS -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3" id="successAlert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-7 mb-8">
                
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Tabel Riwayat Pasien</h3>
                    <p class="text-sm text-slate-400 mt-1">Data diagnosa dan resep obat pasien dari petugas</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs uppercase tracking-wider text-slate-400">
                                <th class="pb-4">Tanggal</th>
                                <th class="pb-4">Nama Pasien</th>
                                <th class="pb-4">Diagnosa</th>
                                <th class="pb-4">Resep Obat</th>
                                <th class="pb-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                       <!-- Cari bagian tbody tabel riwayat pasien, ganti dengan ini -->
                        <tbody>
                            @forelse($riwayatPasien as $riwayat)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_kunjungan)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-700">
                                    {{ $riwayat->pasien->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ Str::limit($riwayat->diagnosa, 40) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ Str::limit($riwayat->resep_obat, 40) ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dokter.edit-riwayat', $riwayat->id) }}" class="text-primary-600 hover:text-primary-800 text-sm font-semibold mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('dokter.hapus-riwayat', $riwayat->id) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold" onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <i class="fas fa-file-medical text-3xl mb-3 block text-slate-300"></i>
                                    Belum ada data riwayat pasien.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <script>
    // Bungkus semua di DOMContentLoaded agar aman
    document.addEventListener('DOMContentLoaded', function() {

        // 1. ANIMASI MUNCUL HALAMAN
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

        // 2. LOGIKA NOTIFIKASI
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