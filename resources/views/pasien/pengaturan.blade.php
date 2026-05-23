<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' },
                    }
                }
            }
        }
    </script>

    <style>
        :root { --bg:#eff6ff; --fg:#1e293b; --muted:#64748b; --accent:#2563eb; --card:#FFFFFF; --border:#dbeafe; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--fg); overflow-x:hidden; }
        ::-webkit-scrollbar { width:6px; } ::-webkit-scrollbar-track { background:transparent; } ::-webkit-scrollbar-thumb { background:#bfdbfe; border-radius:3px; }

        .main-content { margin-left:260px; min-height:100vh; }
        .topbar { background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }

        .form-input { width:100%; padding:10px 14px; border:1.5px solid var(--border); border-radius:10px; font-size:14px; font-family:'Plus Jakarta Sans',sans-serif; color:var(--fg); background:#fff; transition:all 0.2s ease; outline:none; }
        .form-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
        .form-label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:6px; }
        .form-label .required { color:#ef4444; margin-left:2px; }

        .section-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; }
        .section-header { display:flex; align-items:center; gap:12px; padding:18px 24px; background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%); border-bottom:1px solid var(--border); }
        .section-header .icon-box { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
        .section-body { padding:24px; }

        .notif-dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--border); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s ease; z-index: 60; width: 340px; border-radius: 16px; box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1); }
        .notif-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .online-dot { width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: 2px solid #fff; position: absolute; bottom: 0; right: 0; }

        .setting-menu-card { background:#fff; border:1px solid var(--border); border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:16px; cursor:pointer; transition: all 0.2s ease; }
        .setting-menu-card:hover { box-shadow: 0 8px 24px rgba(37, 99, 235, 0.08); border-color: #bfdbfe; transform: translateY(-2px); }
        .setting-menu-card .icon-box { width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }

        .mobile-overlay { display:none; position:fixed; inset:0; background:rgba(30,41,59,0.4); z-index:45; backdrop-filter:blur(2px); }
        .mobile-overlay.show { display:block; }
        @media(max-width:1024px) { .sidebar{transform:translateX(-100%);} .sidebar.open{transform:translateX(0);} .main-content{margin-left:0;} }
        
        @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
        .animate-fade-up { animation: fadeUp 0.4s ease forwards; }
    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>
    @include('pasien.filesidebarpasien')

    <div class="main-content">

        <!-- TOPBAR -->
        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div class="flex items-center gap-3">
                        <!-- Tombol Back (Hidden default) -->
                        <button id="backToSettings" class="hidden w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all cursor-pointer" onclick="switchSettingsView('list')">
                            <i class="fas fa-arrow-left text-sm"></i>
                        </button>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 leading-tight" id="page-title">Pengaturan</h2>
                            <p class="text-xs text-gray-400 mt-0.5" id="currentDate"></p>
                            <script>
                                (function() {
                                    var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                    var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                    var now = new Date();
                                    var el = document.getElementById('currentDate');
                                    if (el) el.textContent = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
                                })();
                            </script>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition-colors relative cursor-pointer" onclick="toggleNotif()" id="notifBtn">
                            <i class="fas fa-bell text-[15px]"></i>
                        </button>
                        <div class="notif-dropdown" id="notifDropdown">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900">Notifikasi</h4>
                                    <button class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">Tandai semua dibaca</button>
                                </div>
                            </div>
                            <div class="p-6 text-center text-sm text-gray-400">Belum ada notifikasi</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pl-3 pr-3 py-1 rounded-xl select-none">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                            <span class="online-dot"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="px-6 lg:px-8 py-8 max-w-5xl mx-auto">
                    @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 font-semibold text-sm animate-fade-up">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 font-semibold text-sm animate-fade-up">
                <i class="fas fa-exclamation-circle"></i> 
                <div>
                    <span class="font-bold">Gagal menyimpan!</span> 
                    <ul class="mt-1 ml-4 list-disc text-xs font-normal">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

            <!-- VIEW 1: MENU LIST -->
            <section id="view-setting-list" class="space-y-4 animate-fade-up">
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 text-xl">Pengaturan Akun</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi pribadi, keamanan, dan preferensi akun Anda.</p>
                </div>

                <div class="setting-menu-card" onclick="switchSettingsView('profil')">
                    <div class="icon-box bg-blue-50 text-blue-600 border border-blue-100">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-[15px]">Profil Saya</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Ubah foto, identitas, dan informasi dasar</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                </div>

                <div class="setting-menu-card" onclick="switchSettingsView('keamanan')">
                    <div class="icon-box bg-green-50 text-green-600 border border-green-100">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-[15px]">Keamanan Akun</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Ubah kata sandi akun Anda secara berkala</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                </div>

                <div class="setting-menu-card" onclick="switchSettingsView('privasi')">
                    <div class="icon-box bg-purple-50 text-purple-600 border border-purple-100">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-[15px]">Privasi & Data</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Kebijakan privasi dan pengelolaan data pasien</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                </div>

                <div class="setting-menu-card" onclick="switchSettingsView('bantuan')">
                    <div class="icon-box bg-amber-50 text-amber-600 border border-amber-100">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-[15px]">Bantuan & Dukungan</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Hubungi tim IT jika mengalami kendala teknis</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                </div>
            </section>

            <!-- VIEW 2: PROFIL SAYA -->
            <section id="view-setting-profil" class="hidden animate-fade-up">
                <div class="section-card">
                    <div class="section-header">
                        <div class="icon-box bg-blue-100 text-blue-600"><i class="fas fa-user-pen"></i></div>
                        <div>
                            <form action="{{ route('pengaturan.profile.update') }}" method="POST" enctype="multipart/form-data">
                            <p class="text-xs text-gray-400 mt-0.5">Perbarui data diri dan foto profil Anda</p>
                        </div>
                    </div>
                    <div class="section-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            
                            <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 pb-6 border-b border-slate-100">
                                <div class="relative group">
                                    <img id="avatarPreview" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff&size=128" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover border-2 border-slate-100 shadow-sm">
                                    <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" onclick="document.getElementById('fileAvatar').click()">
                                        <i class="fas fa-camera text-white text-lg"></i>
                                    </div>
                                    <input type="file" id="fileAvatar" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                                </div>
                                <div class="text-center sm:text-left">
                                    <h4 class="font-bold text-gray-800">{{ auth()->user()->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                    <button type="button" onclick="document.getElementById('fileAvatar').click()" class="mt-2 text-xs font-bold text-primary-600 hover:text-primary-800 transition-colors cursor-pointer">Ubah Foto Profil</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                                </div>
                                <div>
                                    <label class="form-label">No. Telepon</label>
                                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Contoh: 081234567890">
                                </div>
                                <div>
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="dob" class="form-input" value="{{ old('dob', auth()->user()->dob ?? '') }}">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" class="form-input" rows="3" placeholder="Masukkan alamat lengkap Anda...">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-200 transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                                    <i class="fas fa-check text-xs"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- VIEW 3: KEAMANAN AKUN -->
            <section id="view-setting-keamanan" class="hidden animate-fade-up">
                <div class="section-card">
                    <div class="section-header">
                        <div class="icon-box bg-green-100 text-green-600"><i class="fas fa-shield-halved"></i></div>
                        <div>
                            <form action="{{ route('pengaturan.password.update') }}" method="POST">
                            <p class="text-xs text-gray-400 mt-0.5">Pastikan akun Anda menggunakan password yang kuat</p>
                        </div>
                    </div>
                    <div class="section-body">
                        <form action="#" method="POST">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Password Saat Ini <span class="required">*</span></label>
                                    <input type="password" name="current_password" class="form-input" placeholder="••••••••" required>
                                </div>
                                <div>
                                    <label class="form-label">Password Baru <span class="required">*</span></label>
                                    <input type="password" name="new_password" class="form-input" placeholder="Min. 8 karakter" required>
                                </div>
                                <div>
                                    <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                                    <input type="password" name="new_password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-xl shadow-md shadow-green-200 transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                                    <i class="fas fa-key text-xs"></i> Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- VIEW 4: PRIVASI & DATA -->
            <section id="view-setting-privasi" class="hidden animate-fade-up">
                <div class="section-card">
                    <div class="section-header">
                        <div class="icon-box bg-purple-100 text-purple-600"><i class="fas fa-lock"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-[15px]">Privasi & Data</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Kebijakan privasi dan pengelolaan data pasien</p>
                        </div>
                    </div>
                    <div class="section-body prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        <p><strong>Kebijakan Privasi D'Smile Dental Clinic</strong></p>
                        <p>Kami berkomitmen untuk melindungi privasi Anda. Semua data pribadi dan rekam medis yang Anda berikan akan diolah dengan aman dan sesuai dengan peraturan perlindungan data yang berlaku.</p>
                        <p class="mt-3"><strong>Pengelolaan Data:</strong></p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                            <li>Data medis hanya diakses oleh dokter dan staf berwenang di klinik.</li>
                            <li>Kami tidak akan menjual data pribadi Anda kepada pihak ketiga.</li>
                            <li>Data disimpan menggunakan enkripsi standar industri.</li>
                        </ul>
                        <p class="mt-4 text-xs text-gray-400 italic">Terakhir diperbarui: 1 Januari 2025</p>
                    </div>
                </div>
            </section>

            <!-- VIEW 5: BANTUAN & DUKUNGAN -->
            <section id="view-setting-bantuan" class="hidden animate-fade-up">
                <div class="section-card">
                    <div class="section-header">
                        <div class="icon-box bg-amber-100 text-amber-600"><i class="fas fa-headset"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-[15px]">Bantuan & Dukungan</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Hubungi tim IT jika mengalami kendala teknis</p>
                        </div>
                    </div>
                    <div class="section-body space-y-5">
                        <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex items-center gap-5">
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0 border border-amber-200">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">Email Support</h4>
                                <p class="text-sm text-primary-600 font-medium mt-0.5">it.support@dsmileklinik.com</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex items-center gap-5">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 flex-shrink-0 border border-green-200">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">WhatsApp IT</h4>
                                <p class="text-sm text-gray-600 font-medium mt-0.5">+62 812-3456-7890 (Senin - Jumat, 09.00 - 17.00)</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 text-center">
                            <p class="text-xs text-blue-800 font-medium">Harap sertakan Screenshot/Error Log saat menghubungi tim IT agar penanganan lebih cepat.</p>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('mobileOverlay');
            if (sidebar) sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('show');
        }

        function toggleNotif() { 
            document.getElementById('notifDropdown').classList.toggle('open'); 
        }

        document.addEventListener('click', function(e) {
            var notifBtn = document.getElementById('notifBtn'); 
            var notifDrop = document.getElementById('notifDropdown');
            if (notifBtn && !notifBtn.contains(e.target) && !notifDrop.contains(e.target)) notifDrop.classList.remove('open');
        });

        // View Switcher untuk Pengaturan
        function switchSettingsView(viewName) {
            // Sembunyikan semua view
            document.querySelectorAll('[id^="view-setting-"]').forEach(el => el.classList.add('hidden'));
            
            // Tampilkan view yang dipilih
            var targetView = document.getElementById('view-setting-' + viewName);
            if(targetView) {
                targetView.classList.remove('hidden');
                // Reset animasi
                targetView.classList.remove('animate-fade-up');
                void targetView.offsetWidth; 
                targetView.classList.add('animate-fade-up');
            }

            // Atur Topbar
            var titleEl = document.getElementById('page-title');
            var backBtn = document.getElementById('backToSettings');

            if (viewName === 'list') {
                titleEl.innerText = 'Pengaturan';
                backBtn.classList.add('hidden');
            } else {
                var titles = {
                    'profil': 'Profil Saya',
                    'keamanan': 'Keamanan Akun',
                    'privasi': 'Privasi & Data',
                    'bantuan': 'Bantuan & Dukungan'
                };
                titleEl.innerText = titles[viewName];
                backBtn.classList.remove('hidden');
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Preview Avatar
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>