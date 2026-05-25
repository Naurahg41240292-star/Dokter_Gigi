<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - D'Smile</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' }
                    }
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
        .page-transition { opacity: 0; transform: translateY(8px); transition: .3s ease; }
        .page-transition.is-visible { opacity: 1; transform: translateY(0); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        
        /* Accordion Transition */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }
        .accordion-content.open {
            max-height: 1000px; 
        }
        .accordion-icon {
            transition: transform 0.3s ease;
        }
        .accordion-icon.rotated {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="flex page-transition">

    <!-- SIDEBAR -->
     <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-6 pt-8 pb-6 flex-shrink-0">
            <img src="{{ asset('images/logo (2).png') }}" alt="D'Smile Dental Clinic Logo" class="w-auto h-12 object-contain">
        </div>

        <nav class="mt-4">
            <a href="{{ route('dokter.dashboard') }}" class="nav-item">
                <i class="fas fa-home w-5 text-center"></i><span>Beranda</span>
            </a>
            <a href="{{ route('dokter.riwayat-pasien') }}" class="nav-item">
                <i class="fas fa-notes-medical w-5 text-center"></i><span>Riwayat Pasien</span>
            </a>
            <div class="my-6 px-8 border-t border-gray-100"></div>
            <a href="{{ route('dokter.pengaturan') }}" class="nav-item active">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan Akun</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 ml-[260px] overflow-y-auto h-screen">

        <!-- TOP NAVBAR -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200 px-6 lg:px-8 py-4 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wide mb-1">Manajemen Akun</p>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800">Pengaturan ⚙️</h2>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="flex items-center bg-white border border-gray-200 rounded-xl px-4 py-2.5 w-full md:w-72 shadow-sm focus-within:ring-2 focus-within:ring-primary-500 transition">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                        <input type="text" placeholder="Cari pengaturan..." class="ml-2 text-sm outline-none w-full bg-transparent text-slate-600">
                    </div>
                    <div class="relative cursor-pointer p-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
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

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- SETTINGS LIST -->
            <div class="space-y-4 mb-8">

                <!-- 1. PROFIL SAYA -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button onclick="toggleAccordion('profil')" class="w-full flex justify-between items-center p-6 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-primary-600">
                                <i class="fas fa-user text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-slate-800">Profil Saya</h3>
                                <p class="text-xs text-slate-400">Ubah foto, identitas, dan informasi dasar</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 accordion-icon" id="icon-profil"></i>
                    </button>
                    
                    <div class="accordion-content px-6 pb-0" id="section-profil">
                        <div class="border-t border-slate-100 pt-6 pb-8">
                            <form action="{{ route('dokter.pengaturan.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- FOTO & IDENTITAS RINGKAS -->
                                <div class="flex flex-col md:flex-row items-center gap-6 mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="relative flex-shrink-0">
                                        <img id="photoPreview" 
                                             src="{{ $dokter->photo ? asset('storage/'.$dokter->photo) : 'https://ui-avatars.com/api/?name='.urlencode($dokter->name).'&background=2563eb&color=fff' }}" 
                                             class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-md">
                                        
                                        <label for="photo" class="absolute -bottom-2 -right-2 w-9 h-9 bg-primary-600 rounded-full flex items-center justify-center text-white cursor-pointer hover:bg-primary-700 transition shadow-lg">
                                            <i class="fas fa-camera text-sm"></i>
                                        </label>
                                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    
                                    <div class="text-center md:text-left">
                                        <h4 class="font-bold text-slate-800 text-lg">{{ $dokter->name }}</h4>
                                        <p class="text-sm text-primary-600 font-medium">{{ $dokter->spesialisasi ?? 'Dokter Gigi Umum' }}</p>
                                        <p class="text-xs text-slate-400 mt-1">SIP: {{ $dokter->nomor_sip ?? 'Belum ditambahkan' }}</p>
                                    </div>
                                </div>

                                <!-- FORM DETAIL -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', $dokter->name) }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                                        <input type="email" name="email" value="{{ old('email', $dokter->email) }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Spesialisasi</label>
                                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi', $dokter->spesialisasi) }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Ortodonti">
                                        @error('spesialisasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor SIP (Surat Izin Praktik)</label>
                                        <input type="text" name="nomor_sip" value="{{ old('nomor_sip', $dokter->nomor_sip) }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 12345/SIP/2023">
                                        @error('nomor_sip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-primary-700 transition shadow-lg shadow-blue-500/20">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. KEAMANAN AKUN -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button onclick="toggleAccordion('keamanan')" class="w-full flex justify-between items-center p-6 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                                <i class="fas fa-shield-alt text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-slate-800">Keamanan Akun</h3>
                                <p class="text-xs text-slate-400">Ubah kata sandi akun Anda secara berkala</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 accordion-icon" id="icon-keamanan"></i>
                    </button>
                    
                    <div class="accordion-content px-6 pb-0" id="section-keamanan">
                        <div class="border-t border-slate-100 pt-6 pb-8">
                            <form action="{{ route('dokter.pengaturan.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-5 mb-6 max-w-md">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current_password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan password lama">
                                        @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Baru</label>
                                        <input type="password" name="password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Min. 8 karakter">
                                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                        <input type="password" name="password_confirmation" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-green-700 transition shadow-lg shadow-green-500/20">
                                    Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. PRIVASI & DATA -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button onclick="toggleAccordion('privasi')" class="w-full flex justify-between items-center p-6 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600">
                                <i class="fas fa-lock text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-slate-800">Privasi & Data</h3>
                                <p class="text-xs text-slate-400">Kebijakan privasi dan pengelolaan data pasien</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 accordion-icon" id="icon-privasi"></i>
                    </button>
                    
                    <div class="accordion-content px-6 pb-0" id="section-privasi">
                        <div class="border-t border-slate-100 pt-6 pb-8">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-sm text-slate-600 leading-relaxed">
                                <p class="font-bold text-slate-800 mb-2">Kebijakan Privasi Klinik D'Smile</p>
                                <p>Semua data pasien yang Anda kelola, termasuk diagnosa dan rekam medis, dilindungi secara enkripsi dan hanya dapat diakses oleh akun dokter yang bersangkutan. Kami tidak akan membagikan data pribadi pasien kepada pihak ketiga tanpa persetujuan tertulis sesuai dengan peraturan Kemenkes RI.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. BANTUAN & DUKUNGAN -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button onclick="toggleAccordion('bantuan')" class="w-full flex justify-between items-center p-6 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600">
                                <i class="fas fa-headset text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-slate-800">Bantuan & Dukungan</h3>
                                <p class="text-xs text-slate-400">Hubungi tim IT jika mengalami kendala teknis</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 accordion-icon" id="icon-bantuan"></i>
                    </button>
                    
                    <div class="accordion-content px-6 pb-0" id="section-bantuan">
                        <div class="border-t border-slate-100 pt-6 pb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <i class="fas fa-envelope text-primary-600 text-xl"></i>
                                    <div>
                                        <p class="text-xs text-slate-400">Email IT Support</p>
                                        <p class="font-semibold text-slate-700 text-sm">it@dsmile-klinik.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                                    <div>
                                        <p class="text-xs text-slate-400">WhatsApp Helpdesk</p>
                                        <p class="font-semibold text-slate-700 text-sm">+62 812-3456-7890</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div> <!-- End Content Area -->

    </main>

    <script>
        const page = document.body;
        requestAnimationFrame(() => { page.classList.add('is-visible'); });

        // Fungsi Accordion
        function toggleAccordion(sectionId) {
            const section = document.getElementById(`section-${sectionId}`);
            const icon = document.getElementById(`icon-${sectionId}`);

            // Tutup semua section lain
            document.querySelectorAll('.accordion-content').forEach(el => {
                if (el.id !== `section-${sectionId}`) {
                    el.classList.remove('open');
                }
            });
            document.querySelectorAll('.accordion-icon').forEach(el => {
                if (el.id !== `icon-${sectionId}`) {
                    el.classList.remove('rotated');
                }
            });

            // Toggle section yang diklik
            section.classList.toggle('open');
            icon.classList.toggle('rotated');
        }

        // Fungsi Preview Foto sebelum upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ==========================================
        // TAMBAHAN: BUKA ACCORDION OTOMATIS DARI URL
        // ==========================================
        const urlParams = new URLSearchParams(window.location.search);
        const openSection = urlParams.get('open');
        if (openSection) {
            toggleAccordion(openSection);
        }
    </script>

</body>
</html>