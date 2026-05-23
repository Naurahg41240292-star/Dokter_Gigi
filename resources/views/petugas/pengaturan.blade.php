<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - D'Smile Dental Clinic</title>
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
        
        .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.35s ease-out; }
        .accordion-content.open { max-height: 2000px; }
        .accordion-icon { transition: transform 0.3s ease; }
        .accordion-icon.rotated { transform: rotate(180deg); }
    </style>
</head>
<body class="flex page-transition">

    <!-- ========== SIDEBAR (FIXED FULL HEIGHT PAKAI TOP-0 BOTTOM-0) ========== -->
    <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        
        <!-- Logo -->
        <div class="px-8 pt-8 pb-6 flex items-center gap-3 flex-shrink-0">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p>
            </div>
        </div>

        <!-- Menu Scrollable Utama -->
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
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item {{ request()->routeIs('petugas.jadwal-kontrol') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span>
            </a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item {{ request()->routeIs('petugas.manajemen-user') ? 'active' : '' }}">
                <i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span>
            </a>
            
            <div class="my-4 mx-8 border-t border-gray-100"></div>
            
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item active">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span>
            </a>
        </nav>

        <!-- Tombol Keluar di Paling Bawah -->
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
        
        <!-- Header Top Bar (Profil Ada Di Sini & Bisa Diklik) -->
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between gap-4 sticky top-0 z-40">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Pengaturan</h2>
                <p class="text-sm text-slate-500">Kelola informasi profil, keamanan, dan preferensi akun kamu.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center">
                    <i class="fas fa-bell text-slate-600"></i>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                
                <!-- PROFIL DI HEADER (Bisa Diklik Ke Pengaturan) -->
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
            
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6" role="alert">
                    <div class="flex items-center gap-2 font-medium mb-1">
                        <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan:
                    </div>
                    <ul class="list-disc list-inside text-sm ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- PENGATURAN LIST ACCORDION -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 max-w-4xl mx-auto overflow-hidden divide-y divide-slate-100">
                
                <!-- 1. PROFIL SAYA -->
                <div>
                    <button onclick="toggleAccordion('profil')" class="w-full flex items-center gap-5 p-6 hover:bg-slate-50 transition group text-left">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-blue-600 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-800">Profil Saya</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola informasi profil dan data pribadi Anda</p>
                        </div>
                        <i id="icon-profil" class="fas fa-chevron-down text-slate-300 group-hover:text-primary-600 transition accordion-icon"></i>
                    </button>
                    
                    <div id="content-profil" class="accordion-content bg-slate-50/50">
                        <div class="p-6 pt-2 border-t border-slate-100">
                            <form action="{{ route('petugas.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="flex flex-col items-center mb-6">
                                    <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" alt="Foto Profil" class="w-20 h-20 rounded-full border-4 border-white shadow-md object-cover mb-3">
                                    <label class="cursor-pointer px-4 py-2 bg-white border border-slate-200 text-primary-600 text-xs font-semibold rounded-lg hover:bg-primary-50 transition">
                                        <i class="fas fa-camera mr-1"></i> Ubah Foto
                                        <input type="file" name="foto" class="hidden" accept="image/*">
                                    </label>
                                    @error('foto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white @error('name') border-red-400 @enderror">
                                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white @error('email') border-red-400 @enderror">
                                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">No. Telepon</label>
                                        <input type="tel" name="no_telp" value="{{ old('no_telp', auth()->user()->no_telp) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white" placeholder="08xx-xxxx-xxxx">
                                    </div>
                                </div>
                                <div class="flex justify-end mt-6">
                                    <button type="submit" class="px-5 py-2.5 bg-primary-600 text-white rounded-xl text-xs font-bold hover:bg-primary-700 shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. KEAMANAN AKUN -->
                <div>
                    <button onclick="toggleAccordion('keamanan')" class="w-full flex items-center gap-5 p-6 hover:bg-slate-50 transition group text-left">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-halved text-emerald-600 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-800">Keamanan Akun</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Atur kata sandi dan verifikasi dua langkah</p>
                        </div>
                        <i id="icon-keamanan" class="fas fa-chevron-down text-slate-300 group-hover:text-emerald-600 transition accordion-icon"></i>
                    </button>
                    
                    <div id="content-keamanan" class="accordion-content bg-slate-50/50">
                        <div class="p-6 pt-2 border-t border-slate-100">
                            <form action="{{ route('petugas.pengaturan.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 mb-4 flex items-start gap-2">
                                    <i class="fas fa-info-circle text-emerald-600 mt-0.5 text-xs"></i>
                                    <p class="text-xs text-emerald-700">Pastikan kata sandi baru Anda kuat, mengandung huruf besar, kecil, angka, dan simbol.</p>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current_password" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white @error('current_password') border-red-400 @enderror">
                                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                                        <input type="password" name="new_password" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white @error('new_password') border-red-400 @enderror">
                                        @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                                        <input type="password" name="new_password_confirmation" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                    </div>
                                </div>
                                <div class="flex justify-end mt-6">
                                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition flex items-center gap-2">
                                        <i class="fas fa-key"></i> Update Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. PRIVASI & DATA -->
                <div>
                    <button onclick="toggleAccordion('privasi')" class="w-full flex items-center gap-5 p-6 hover:bg-slate-50 transition group text-left">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-eye text-purple-600 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-800">Privasi & Data</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola data Anda dan preferensi privasi</p>
                        </div>
                        <i id="icon-privasi" class="fas fa-chevron-down text-slate-300 group-hover:text-purple-600 transition accordion-icon"></i>
                    </button>
                    
                    <div id="content-privasi" class="accordion-content bg-slate-50/50">
                        <div class="p-6 pt-2 border-t border-slate-100 space-y-4">
                            <div class="flex items-center justify-between p-4 border border-slate-200 rounded-xl bg-white">
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-800">Notifikasi Email</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Terima pemberitahuan jadwal pasien via email</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" checked class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            <div class="p-4 border border-red-200 bg-red-50 rounded-xl">
                                <h4 class="text-xs font-semibold text-red-700">Hapus Akun</h4>
                                <p class="text-[11px] text-red-500 mt-0.5 mb-3">Setelah menghapus akun, semua data tidak dapat dikembalikan.</p>
                                <button class="px-3 py-1.5 bg-white border border-red-300 text-red-600 text-[11px] font-bold rounded-lg hover:bg-red-100 transition">Hapus Akun Saya</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. BANTUAN & DUKUNGAN -->
                <div>
                    <button onclick="toggleAccordion('bantuan')" class="w-full flex items-center gap-5 p-6 hover:bg-slate-50 transition group text-left">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-circle-question text-amber-600 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-800">Bantuan & Dukungan</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Dapatkan bantuan atau hubungi dukungan</p>
                        </div>
                        <i id="icon-bantuan" class="fas fa-chevron-down text-slate-300 group-hover:text-amber-600 transition accordion-icon"></i>
                    </button>
                    
                    <div id="content-bantuan" class="accordion-content bg-slate-50/50">
                        <div class="p-6 pt-2 border-t border-slate-100 space-y-6">
                            
                            <!-- Bagian Panduan Penggunaan -->
                            <div>
                                <h5 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <i class="fas fa-book-open text-amber-500"></i> Panduan Penggunaan
                                </h5>
                                <div class="space-y-2">
                                    <details class="group bg-white border border-slate-200 rounded-lg">
                                        <summary class="px-4 py-3 cursor-pointer list-none flex justify-between items-center text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-lg">
                                            <span>Bagaimana cara menambahkan pasien baru?</span>
                                            <i class="fas fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                                        </summary>
                                        <div class="px-4 py-3 text-xs text-slate-600 bg-slate-50 border-t border-slate-100 rounded-b-lg">
                                            Klik menu <b>"Input Data Pasien"</b> di sidebar sebelah kiri, lalu isi formulir data pribadi, data medis, dan jadwal kunjungan pasien. Setelah selesai, klik tombol <b>"Simpan"</b> di bagian bawah halaman.
                                        </div>
                                    </details>
                                    <details class="group bg-white border border-slate-200 rounded-lg">
                                        <summary class="px-4 py-3 cursor-pointer list-none flex justify-between items-center text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-lg">
                                            <span>Bagaimana cara mengubah jadwal kontrol pasien?</span>
                                            <i class="fas fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                                        </summary>
                                        <div class="px-4 py-3 text-xs text-slate-600 bg-slate-50 border-t border-slate-100 rounded-b-lg">
                                            Buka menu <b>"Jadwal Kontrol"</b>, cari nama pasien yang ingin diubah, lalu klik ikon edit (pensil) pada baris pasien tersebut untuk memperbarui tanggal dan waktu kunjungan.
                                        </div>
                                    </details>
                                    <details class="group bg-white border border-slate-200 rounded-lg">
                                        <summary class="px-4 py-3 cursor-pointer list-none flex justify-between items-center text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-lg">
                                            <span>Dimana saya bisa melihat rekam medis pasien?</span>
                                            <i class="fas fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                                        </summary>
                                        <div class="px-4 py-3 text-xs text-slate-600 bg-slate-50 border-t border-slate-100 rounded-b-lg">
                                            Pergi ke menu <b>"Data Pasien"</b>, lalu klik ikon mata (lihat detail) pada pasien yang dicari. Semua riwayat medis dan perawatan akan ditampilkan di sana.
                                        </div>
                                    </details>
                                </div>
                            </div>

                            <!-- Bagian Hubungi IT Support -->
                            <div>
                                <h5 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <i class="fas fa-headset text-blue-500"></i> Hubungi IT Support
                                </h5>
                                <div class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-envelope text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-700">Email</p>
                                            <p class="text-xs text-slate-500">it.support@dsmile-dental.com</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fab fa-whatsapp text-green-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-700">WhatsApp / Telepon</p>
                                            <p class="text-xs text-slate-500">+62 812-3456-7890</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-clock text-amber-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-700">Jam Operasional IT</p>
                                            <p class="text-xs text-slate-500">Senin - Jumat, 08:00 - 17:00 WIB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

        function toggleAccordion(id) {
            const content = document.getElementById('content-' + id);
            const icon = document.getElementById('icon-' + id);
            const isOpen = content.classList.contains('open');

            document.querySelectorAll('.accordion-content').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('.accordion-icon').forEach(el => el.classList.remove('rotated'));

            if (!isOpen) {
                content.classList.add('open');
                icon.classList.add('rotated');
            }
        }

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