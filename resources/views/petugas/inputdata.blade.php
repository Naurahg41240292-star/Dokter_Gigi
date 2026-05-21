<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pasien - D'Smile Dental Clinic</title>
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
        body { background-color: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; }
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
           
            <div class="my-6 px-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
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
            <div>
                <h2 class="text-xl font-bold text-slate-800">Input Data Pasien</h2>
                <p class="text-sm text-slate-500">Lengkapi formulir berikut untuk menambahkan pasien baru.</p>
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

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert">
                <i class="fas fa-check-circle"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- FORM CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-5xl mx-auto">
            
            <form action="{{ route('petugas.input-data.store') }}" method="POST">
                @csrf
                
                <!-- Section 1: DATA PASIEN -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">DATA PASIEN</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Masukkan nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (No. KTP) <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" maxlength="16" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="16 digit NIK">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="contoh@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon Pasien</label>
                            <input type="tel" name="no_telp" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                            <div class="flex items-center gap-6 mt-2.5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="w-4 h-4 text-primary-600">
                                    <span class="text-sm text-slate-700">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="w-4 h-4 text-primary-600">
                                    <span class="text-sm text-slate-700">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Masukkan alamat lengkap"></textarea>
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
                            <select name="golongan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tekanan Darah</label>
                            <input type="text" name="tekanan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: 120/80 mmHg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Alergi Obat</label>
                            <input type="text" name="riwayat_alergi" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Penisilin, Amoxicillin">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alergi Makanan</label>
                            <input type="text" name="alergi_makanan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Kacang, Susu, Makanan Laut">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Obat Dikonsumsi Saat Ini</label>
                            <input type="text" name="obat_dikonsumsi" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Metformin, Obat Darah Tinggi">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Riwayat penyakit dahulu jika ada"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: JADWAL KUNJUNGAN (APPOINTMENT) -->
                <div class="mb-10 bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">JADWAL KUNJUNGAN</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Appointment <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_appointment" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Waktu yang Diinginkan <span class="text-red-500">*</span></label>
                            <input type="time" name="waktu" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Dokter <span class="text-red-500">*</span></label>
                            <select name="dokter" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                                <option value="">Pilih Dokter</option>
                                <option value="drg. Gabriela Putri">drg. Gabriela Putri</option>
                                <option value="drg. Kevin Sanjaya">drg. Kevin Sanjaya</option>
                                <option value="dr. Andi Wijaya">dr. Andi Wijaya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Perawatan <span class="text-red-500">*</span></label>
                            <select name="jenis_perawatan" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                                <option value="">Pilih Perawatan</option>
                                <option value="Pemeriksaan Umum">Pemeriksaan Umum</option>
                                <option value="Scalling">Scalling</option>
                                <option value="Cabut Gigi">Cabut Gigi</option>
                                <option value="Tambal Gigi">Tambal Gigi</option>
                                <option value="Kawat Gigi">Kawat Gigi</option>
                                <option value="Veneer">Veneer</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keluhan Saat Ini</label>
                            <textarea name="keluhan" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Deskripsikan keluhan pasien"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 4: KONTAK DARURAT -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">KONTAK DARURAT</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kontak</label>
                            <input type="text" name="kontak_nama" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Masukkan nama kontak darurat">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hubungan</label>
                            <select name="kontak_hubungan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                                <option value="">Pilih Hubungan</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Saudara">Saudara</option>
                                <option value="Suami/Istri">Suami/Istri</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
                            <input type="tel" name="kontak_telepon" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xx-xxxx-xxxx">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                    <button type="reset" class="px-6 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition flex items-center gap-2">
                        <i class="fas fa-undo text-xs"></i> Reset form
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Simpan
                    </button>
                </div>

            </form>
        </div>

    </main>

    <script>
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

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