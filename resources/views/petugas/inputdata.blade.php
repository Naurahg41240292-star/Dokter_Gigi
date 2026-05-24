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
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"><i class="fas fa-home w-5 text-center"></i><span>Beranda</span></a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item active"><i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span></a>
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
            <div><h2 class="text-xl font-bold text-slate-800">Input Data Pasien</h2><p class="text-sm text-slate-500">Lengkapi formulir berikut untuk menambahkan pasien baru.</p></div>
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

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-5xl mx-auto">
                <form action="{{ route('petugas.input-data.store') }}" method="POST">@csrf
                    
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">DATA PASIEN</h3>
                        <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Masukkan nama lengkap">
                                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (No. KTP) <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="16 digit NIK">
                                @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="contoh@email.com">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- No. Telepon -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon Pasien <span class="text-red-500">*</span></label>
                                <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xx-xxxx-xxxx" maxlength="13">
                                @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-6 mt-2.5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" required class="w-4 h-4 text-primary-600" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                                        <span class="text-sm text-slate-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="w-4 h-4 text-primary-600" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                        <span class="text-sm text-slate-700">Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                        </div>
                    </div>
                

                    <div class="mb-10"><h3 class="text-lg font-bold text-slate-800 mb-1">DATA MEDIS AWAL</h3><div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Golongan Darah</label><select name="golongan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"><option value="">Pilih Golongan Darah</option><option value="A">A</option><option value="B">B</option><option value="AB">AB</option><option value="O">O</option></select></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Tekanan Darah</label><input type="text" name="tekanan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: 120/80 mmHg"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Alergi Obat</label><input type="text" name="riwayat_alergi" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Penisilin, Amoxicillin"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Alergi Makanan</label><input type="text" name="alergi_makanan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Kacang, Susu, Makanan Laut"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Obat Dikonsumsi Saat Ini</label><input type="text" name="obat_dikonsumsi" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Metformin, Obat Darah Tinggi"></div>
                            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Penyakit</label><textarea name="riwayat_penyakit" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Riwayat penyakit dahulu jika ada"></textarea></div>
                        </div>
                    </div>

                    <div class="mb-10 bg-blue-50/50 p-6 rounded-2xl border border-blue-100"><h3 class="text-lg font-bold text-slate-800 mb-1">JADWAL KUNJUNGAN</h3><div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Appointment <span class="text-red-500">*</span></label><input type="date" name="tanggal_appointment" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Waktu yang Diinginkan <span class="text-red-500">*</span></label><input type="time" name="waktu" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Dokter <span class="text-red-500">*</span></label><select name="dokter" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"><option value="">Pilih Dokter</option><option value="drg.Ahmad Eunwo Ramdhan, Sp.Ort">drg.Ahmad Eunwo Ramdhan, Sp.Ort</option><option value="drg. Naurah Afkarina Ananda, KG">drg. Naurah Afkarina Ananda, KG</option><option value="drg. Binan Wooseok Sagara, Sp. Pros">drg. Binan Wooseok Sagara, Sp. Pros</option><option value="drg. Intan Novitasari, Sp. Perio">drg. Intan Novitasari, Sp. Perio</option><option value="drg. Najwa Wahdaniyatul Meilani, Sp. BM">drg. Najwa Wahdaniyatul Meilani, Sp. BM</option><option value="drg. Aprilia Ajeng Wulandari, Sp.KGA">drg. Aprilia Ajeng Wulandari, Sp.KGA</option></select></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Perawatan <span class="text-red-500">*</span></label><select name="jenis_perawatan" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"><option value="">Pilih Perawatan</option><option value="Pemeriksaan Umum">Pemeriksaan Umum</option><option value="behel gigi (Rp. 7.000.000)">behel gigi (Rp. 7.000.000)</option><option value="bleaching gigi (Rp. 1.500.000)">bleaching gigi (Rp. 1.500.000)</option><option value="gigi tiruan (Rp. 2.500.000)">gigi tiruan (Rp. 2.500.000)</option><option value="gum lifting (Rp. 4.000.000)">gum lifting (Rp. 4.000.000)</option><option value="Veneer (Rp. 4.500.000)">Veneer (Rp. 4.500.000)</option><option value="tambal gigi (Rp. 350.000)">tambal gigi (Rp. 350.000)</option><option value="cabut gigi (Rp. 300.000)">cabut gigi (Rp. 300.000)</option><option value="scalling gigi (Rp. 500.00０)">scalling gigi (Rp. 50₀.₀₀₀)</option></select></div>
                            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-7０ mb-2">Keluhan Saat Ini</label><textarea name="keluhan" rows="3" class="w-full border border-slate-2０₀ rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-5₀₀" placeholder="Deskripsikan keluhan pasien"></textarea></div>
                        </div>
                    </div>

                    <div class="mb-8"><h3 class="text-lg font-bold text-slate-800 mb-1">KONTAK DARURAT</h3><div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kontak</label><input type="text" name="kontak_nama" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Masukkan nama kontak darurat"></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Hubungan</label><select name="kontak_hubungan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white"><option value="">Pilih Hubungan</option><option value="Orang Tua">Orang Tua</option><option value="Saudara">Saudara</option><option value="Suami/Istri">Suami/Istri</option><option value="Lainnya">Lainnya</option></select></div>
                            <div><label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label><input type="tel" name="kontak_telepon" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xx-xxxx-xxxx" maxlength="13"></div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                        <button type="reset" class="px-6 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition flex items-center gap-2"><i class="fas fa-undo text-xs"></i> Reset form</button>
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 shadow-md shadow-blue-500/20 transition flex items-center gap-2"><i class="fas fa-save text-xs"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const page = document.body; requestAnimationFrame(() => page.classList.add('is-visible'));
        const notifBtn = document.getElementById('notif-btn'); const notifDropdown = document.getElementById('notif-dropdown'); const readAllBtn = document.getElementById('read-all-btn'); const notifDot = document.getElementById('notif-dot');
        notifBtn.addEventListener('click', (e) => { e.stopPropagation(); notifDropdown.classList.toggle('show'); });
        document.addEventListener('click', (e) => { if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) notifDropdown.classList.remove('show'); });
        readAllBtn.addEventListener('click', (e) => { e.preventDefault(); document.querySelectorAll('#notif-dropdown .bg-primary-600.rounded-full.w-2').forEach(dot => dot.remove()); if(notifDot) notifDot.style.display = 'none'; });
        document.querySelectorAll('a[href]').forEach((link) => { link.addEventListener('click', (event) => { const href = link.getAttribute('href'); if (!href || href.startsWith('#') || link.target === '_blank' || event.metaKey || event.ctrlKey) return; const targetUrl = new URL(href, window.location.origin); if (targetUrl.origin !== window.location.origin) return; event.preventDefault(); page.classList.add('is-leaving'); setTimeout(() => { window.location.href = targetUrl.href; }, 220); }); });
    </script>
</body>
</html>