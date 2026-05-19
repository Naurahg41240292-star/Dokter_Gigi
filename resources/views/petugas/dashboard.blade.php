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

        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
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
<body class="flex">

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

            <!-- INI KODE BARU UNTUK BERANDA -->
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>

            <!-- INI KODE BARU UNTUK INPUT DATA -->
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}">
                <i class="fas fa-user-plus w-5 text-center"></i>
                <span>Input Data Pasien</span>
            </a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item {{ request()->routeIs('petugas.data-pasien') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Data Pasien</span>
            </a>

            <!-- Menu di bawah ini biarkan seperti biasa (karena belum dibuatkan route) -->
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

            <div class="my-6 px-8 border-t border-gray-100"></div>

            <a href="/pengaturan" class="nav-item">
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
                <!-- ID ditambahkan untuk diubah via JS -->
                <h2 id="header-title" class="text-xl font-bold text-slate-800">Dashboard Petugas</h2>
                <p id="header-subtitle" class="text-sm text-slate-500">Ringkasan aktivitas klinik hari ini.</p>
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
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">Siti Aminah</p>
                        <p class="text-xs text-primary-600 font-medium">Resepsionis</p>
                    </div>
                    <img src="https://picsum.photos/seed/admin/100/100" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </div>
            </div>
        </header>

        <!-- ======================================================= -->
        <!-- HALAMAN 1: BERANDA (Default Visible)                     -->
        <!-- ======================================================= -->
        <div id="page-beranda" class="page-content">
            
          <!-- STATS CARDS (Grid) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <!-- 1. Pasien Hari Ini -->
    <a href="{{ route('petugas.jadwal-kontrol') }}" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Pasien Hari Ini</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $pasienHariIni }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary-600">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs font-bold">Kunjungan Hari Ini</span>
        </div>
    </a>

    <!-- 2. Antrian Menunggu (Mengganti Pasien Baru Daftar) -->
    <a href="{{ route('petugas.rekam-medis') }}" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Antrian Menunggu</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $antrianHariIni }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-yellow-50 text-yellow-600 px-2 py-0.5 rounded-full text-xs font-bold">Belum Diperiksa</span>
        </div>
    </a>

    <!-- 3. Selesai Diperiksa -->
    <a href="{{ route('petugas.rekam-medis') }}" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Selesai Diperiksa</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $selesaiHariIni }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-green-50 text-green-600 px-2 py-0.5 rounded-full text-xs font-bold">Tuntas</span>
        </div>
    </a>

    <!-- 4. Total Pasien -->
    <a href="{{ route('petugas.data-pasien') }}" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pasien</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalPasien }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full text-xs font-bold">Keseluruhan</span>
        </div>
    </a>

    <!-- 5. Dokter Aktif -->
    <a href="#" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Dokter Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $dokterAktif }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-teal-100 text-teal-700 px-2 py-0.5 rounded-full text-xs font-bold">Semua Tersedia</span>
        </div>
    </a>

    <!-- 6. Penerimaan Hari Ini -->
    <a href="#" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover-card relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Penerimaan Hari Ini</p>
                <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($penerimaanHariIni, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                <i class="fas fa-cash-register"></i>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-orange-50 text-orange-600 px-2 py-0.5 rounded-full text-xs font-bold">Estimasi</span>
        </div>
    </a>

</div>

                   <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            <!-- KOLOM KIRI: JADWAL KONTROL (Lebih Lebar) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Jadwal Kontrol Hari Ini</h3>
                    <a href="{{ route('petugas.jadwal-kontrol') }}" class="text-xs font-bold text-primary-600 border border-primary-200 bg-primary-50 px-3 py-1.5 rounded-lg hover:bg-primary-100 transition">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                                <th class="pb-3">Waktu</th>
                                <th class="pb-3">Nama Pasien</th>
                                <th class="pb-3">Dokter</th>
                                <th class="pb-3">Perawatan</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                       <tbody class="text-sm">
                            @forelse ($jadwalHariIni as $rm)
                            <tr class="border-b border-gray-50 table-row-hover transition">
                                <td class="py-4 font-medium text-slate-600 w-24">
                                    {{ $rm->created_at->format('H:i') }}
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary-600 font-bold text-xs uppercase">
                                            {{ substr($rm->pasien->nama ?? 'P', 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $rm->pasien->nama ?? 'Pasien Umum' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600">{{ $rm->dokter }}</td>
                                <td class="py-4 text-slate-500">{{ $rm->tindakan ?? 'Belum ada tindakan' }}</td>
                                <td class="py-4">
                                    @if($rm->status == 'Selesai')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md text-xs font-bold">Selesai</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-xs font-bold">{{ $rm->status }}</span>
                                    @endif
                                </td>
                                <td class="py-4 text-center">
                                    <!-- Tombol langsung mengarah ke edit Rekam Medis -->
                                    <a href="{{ route('petugas.edit-rm', $rm->id) }}" class="inline-flex items-center gap-2 bg-primary-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-primary-700 transition shadow-sm">
                                        <i class="fas fa-file-medical"></i> Isi Rekam Medis
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400">
                                    <i class="fas fa-calendar-times text-3xl mb-2 block"></i>
                                    Belum ada jadwal kontrol hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KOLOM KANAN: PASIEN TERBARU (Narrower) -->
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Pasien Terbaru</h3>
                    <a href="{{ route('petugas.data-pasien') }}" class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center hover:bg-primary-100 transition">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="space-y-4 overflow-y-auto flex-1 max-h-[350px]">
                    @forelse ($pasienTerbaru as $pasien)
                    <!-- List Item -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-sm uppercase">
                                {{ substr($pasien->nama, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition">{{ $pasien->nama }}</h4>
                                <p class="text-xs text-slate-500">NIK: {{ $pasien->nik }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">{{ $pasien->created_at->format('d M Y') }}</span>
                    </div>
                    @empty
                    <div class="py-10 text-center text-slate-400">
                        <i class="fas fa-user-plus text-3xl mb-2 block"></i>
                        Belum ada pasien baru.
                    </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                    <a href="{{ route('petugas.data-pasien') }}" class="text-xs font-bold text-slate-500 hover:text-primary-600 transition">
                        Lihat Semua Pasien
                    </a>
                </div>
            </div>

        </div>
        <!-- ======================================================= -->
        <!-- HALAMAN 2: INPUT DATA PASIEN (Default Hidden)           -->
        <!-- ======================================================= -->
        <div id="page-input-data" class="page-content hidden">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-5xl mx-auto">
                <form action="#" method="POST">
                    @csrf
                    
                    <!-- Section 1: DATA PASIEN -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">DATA PASIEN</h3>
                        <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="Masukkan nama lengkap pasien">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (No. KTP) <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="Masukkan 16 digit NIK pasien">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition text-slate-600">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                                <div class="flex items-center gap-6 mt-2.5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="w-4 h-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <span class="text-sm text-slate-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="w-4 h-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <span class="text-sm text-slate-700">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none" placeholder="Masukkan alamat lengkap pasien"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: DATA MEDIS AWAL -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">DATA MEDIS AWAL</h3>
                        <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Golongan Darah</label>
                                <select name="golongan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition bg-white text-slate-600">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Alergi</label>
                                <input type="text" name="riwayat_alergi" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="Contoh: Penisilin, Debu">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Penyakit</label>
                                <textarea name="riwayat_penyakit" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none" placeholder="Masukkan riwayat penyakit dahulu jika ada"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: KONTAK DARURAT -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">KONTAK DARURAT</h3>
                        <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kontak</label>
                                <input type="text" name="kontak_nama" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="Masukkan nama kontak darurat">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Hubungan</label>
                                <select name="kontak_hubungan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition bg-white text-slate-600">
                                    <option value="">Pilih Hubungan</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Suami/Istri">Suami/Istri</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
                                <input type="tel" name="kontak_telepon" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                        <button type="reset" class="px-6 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition flex items-center gap-2">
                            <i class="fas fa-undo text-xs"></i>
                            Reset form
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                            <i class="fas fa-save text-xs"></i>
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </main>

    <!-- ========== JAVASCRIPT NAVIGASI ========== -->
    <script>
        // Tangkap elemen navigasi yang memiliki data-page
        const navLinks = document.querySelectorAll('.nav-item[data-page]');
        const pages = document.querySelectorAll('.page-content');
        
        // Elemen header untuk diubah teksnya
        const headerTitle = document.getElementById('header-title');
        const headerSubtitle = document.getElementById('header-subtitle');

        // Data teks header per halaman
        const pageTitles = {
            'beranda': {
                title: 'Dashboard Petugas',
                subtitle: 'Ringkasan aktivitas klinik hari ini.'
            },
            'input-data': {
                title: 'Input Data Pasien',
                subtitle: 'Lengkapi formulir berikut untuk menambahkan pasien baru ke dalam sistem.'
            }
        };

        // Tambahkan event listener untuk setiap link navigasi
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah reload halaman
                
                // Ambil target halaman dari atribut data-page
                const targetPage = link.getAttribute('data-page');

                // Hilangkan class 'active' dari semua menu sidebar
                navLinks.forEach(nav => nav.classList.remove('active'));
                
                // Tambahkan class 'active' ke menu yang diklik
                link.classList.add('active');

                // Sembunyikan semua halaman konten
                pages.forEach(page => page.classList.add('hidden'));

                // Tampilkan halaman konten yang dituju
                document.getElementById(`page-${targetPage}`).classList.remove('hidden');

                // Update teks Header sesuai halaman
                if(pageTitles[targetPage]) {
                    headerTitle.innerText = pageTitles[targetPage].title;
                    headerSubtitle.innerText = pageTitles[targetPage].subtitle;
                }
            });
        });
    </script>
</body>
</html>