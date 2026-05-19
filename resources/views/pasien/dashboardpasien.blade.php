<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien - D'Smile Dental Clinic</title>
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
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                        accent: '#2563eb', surface: '#eff6ff', sidebar: '#FFFFFF',
                    }
                }
            }
        }
    </script>
    <style>
        :root { --bg: #eff6ff; --fg: #1e293b; --muted: #64748b; --accent: #2563eb; --card: #FFFFFF; --border: #dbeafe; --sidebar: #FFFFFF; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--fg); overflow-x: hidden; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 3px; }
        
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar); border-right: 1px solid var(--border); position: fixed; left: 0; top: 0; z-index: 50; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 4px 0 24px rgba(59, 130, 246, 0.03); }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 11px 20px; border-radius: 10px; color: var(--muted); font-size: 14px; font-weight: 500; transition: all 0.2s ease; cursor: pointer; position: relative; margin: 0 12px; text-decoration: none; }
        .sidebar-link:hover { color: var(--accent); background: #eff6ff; }
        .sidebar-link.active { color: var(--accent); background: #eff6ff; font-weight: 600; }
        .sidebar-link.active::before { content: ''; position: absolute; left: -12px; top: 50%; transform: translateY(-50%); width: 4px; height: 20px; background: var(--accent); border-radius: 0 4px 4px 0; }
        .sidebar-link i { width: 20px; text-align: center; font-size: 15px; }
        .sidebar-title { color: #94a3b8; font-size: 10px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; padding-left: 32px; margin-bottom: 8px; margin-top: 24px; }
        
        .main-content { margin-left: 260px; min-height: 100vh; padding: 0; }
        .topbar { background: rgba(255,255,255,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }
        
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease; }
        .card:hover { box-shadow: 0 12px 40px rgba(37, 99, 235, 0.08); border-color: #bfdbfe; transform: translateY(-2px); }
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; opacity: 0.08; }
        .stat-card.blue::after { background: #2563EB; } .stat-card.orange::after { background: #F59E0B; } .stat-card.purple::after { background: #8B5CF6; } .stat-card.teal::after { background: #06C4AD; }
        
        .notif-badge { position: absolute; top: -3px; right: -3px; width: 18px; height: 18px; background: var(--accent); color: #fff; font-size: 10px; font-weight: 700; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; animation: pulse-badge 2s infinite; }
        @keyframes pulse-badge { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.15); } }
        
        .schedule-card { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; color: #fff; border-radius: 20px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(37, 99, 235, 0.25); }
        .schedule-card::before { content: ''; position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; background: rgba(255,255,255,0.1); border-radius: 50%; }
        
        .article-card img { transition: transform 0.4s ease; } .article-card:hover img { transform: scale(1.05); }
        .tag { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; letter-spacing: 0.02em; }
        
        .notif-dropdown, .profile-dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--border); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s ease; z-index: 60; }
        .notif-dropdown { width: 340px; border-radius: 16px; box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1); }
        .profile-dropdown { width: 200px; border-radius: 12px; box-shadow: 0 12px 36px rgba(37, 99, 235, 0.08); }
        .notif-dropdown.open, .profile-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .profile-dropdown a { display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: var(--fg); transition: background 0.15s; text-decoration: none; }
        .profile-dropdown a:hover { background: #eff6ff; } .profile-dropdown a.danger { color: #EF4444; }
        
        .fade-up { opacity: 0; transform: translateY(16px); animation: fadeUp 0.6s ease forwards; }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        .fade-up:nth-child(1) { animation-delay: 0.05s; } .fade-up:nth-child(2) { animation-delay: 0.1s; } .fade-up:nth-child(3) { animation-delay: 0.15s; } .fade-up:nth-child(4) { animation-delay: 0.2s; }
        
        .mobile-overlay { display: none; position: fixed; inset: 0; background: rgba(30, 41, 59, 0.4); z-index: 45; backdrop-filter: blur(2px); }
        .mobile-overlay.show { display: block; }
        @media (max-width: 1024px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .main-content { margin-left: 0; } }
        
        .online-dot { width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: 2px solid #fff; position: absolute; bottom: 0; right: 0; }

        .modal-overlay { position: fixed; inset: 0; background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(4px); z-index: 100; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-content { background: #fff; border-radius: 20px; max-width: 800px; width: 100%; max-height: 90vh; position: relative; animation: fadeUp 0.3s ease; display: flex; flex-direction: column; }
        .modal-body-scroll::-webkit-scrollbar { width: 6px; } .modal-body-scroll::-webkit-scrollbar-track { background: #f1f5f9; } .modal-body-scroll::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
    </style>
</head>
<body class="page-fade-in">

    <!-- VARIABEL UNTUK SIMULASI -->
    @php 
        // Ganti jadi 'false' kalau mau lihat tampilan pasien lama (yang udah punya data)
        $isNewUser = true; 
    @endphp

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>
    @include('pasien.filesidebarpasien')

    <div class="main-content">

        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div>
                        @if($isNewUser)
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">Selamat datang di D'Smile, {{ auth()->user()->name }}! 👋</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Mari mulai perjalanan kesehatan gigi Anda</p>
                        @else
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">Selamat datang kembali, {{ auth()->user()->name }}!</h2>
                            <p class="text-xs text-gray-400 mt-0.5" id="currentDate"></p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition-colors relative cursor-pointer" onclick="toggleNotif()" id="notifBtn">
                            <i class="fas fa-bell text-[15px]"></i>
                            @if(!$isNewUser)<span class="notif-badge">4</span>@endif
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

                    <div class="relative">
                        <button class="flex items-center gap-3 pl-3 pr-1 py-1 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleProfile()" id="profileBtn">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                                <span class="online-dot"></span>
                            </div>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 mr-2"></i>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="p-3 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="#"><i class="fas fa-user text-gray-400 text-xs w-4"></i> Profil Saya</a>
                                <a href="#"><i class="fas fa-cog text-gray-400 text-xs w-4"></i> Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt text-xs w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 py-6">

            <!-- STAT CARDS (Kondisi Dinamis) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card stat-card blue p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i class="fas fa-calendar-alt text-blue-600 text-sm"></i></div>
                        @if(!$isNewUser)<span class="tag bg-amber-50 text-amber-600">Menunggu</span>@endif
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $isNewUser ? '0' : '1' }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Appointment</p>
                </div>
                <div class="card stat-card orange p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center"><i class="fas fa-tooth text-amber-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $isNewUser ? '0' : '12' }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Total Perawatan</p>
                </div>
                <div class="card stat-card purple p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center"><i class="fas fa-file-invoice text-purple-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $isNewUser ? '0' : '2' }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Tagihan Pending</p>
                </div>
                <div class="card stat-card teal p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center"><i class="fas fa-star text-teal-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $isNewUser ? 'N/A' : '4.8' }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Skor Kesehatan Gigi</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-5 gap-5 mb-6">
                
                @if($isNewUser)
                <!-- EMPTY STATE: CTA Buat Janji -->
                <div class="lg:col-span-3 fade-up" style="animation-delay:0.25s">
                    <div class="card p-8 text-center flex flex-col items-center justify-center h-full border-dashed border-2 border-blue-200 bg-blue-50/30">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
                            <i class="fas fa-calendar-plus text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Janji Temu</h3>
                        <p class="text-gray-500 text-sm mb-6 max-w-sm">Mulai perjalanan kesehatan gigi Anda dengan membuat janji temu pertama bersama dokter profesional kami.</p>
                        <button class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-blue-200 transition-all cursor-pointer">
                            <i class="fas fa-plus mr-2"></i> Buat Janji Temu Sekarang
                        </button>
                    </div>
                </div>
                @else
                <!-- POPULATED STATE: Kartu Appointment Biru -->
                <div class="lg:col-span-3 fade-up" style="animation-delay:0.25s">
                    <div class="schedule-card p-6 relative z-10">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <span class="tag bg-white/15 text-white/90 mb-2 border border-white/10">Mendatang</span>
                                <h3 class="text-lg font-bold mt-2">Appointment Berikutnya</h3>
                            </div>
                            <button class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white/80 hover:bg-white/20 transition-colors cursor-pointer">
                                <i class="fas fa-bell text-sm"></i>
                            </button>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-5">
                            <div class="bg-white/10 rounded-xl p-4 text-center flex-shrink-0 w-full sm:w-28 backdrop-blur-sm border border-white/10">
                                <p class="text-[11px] text-blue-100 font-semibold uppercase tracking-wider">April</p>
                                <p class="text-4xl font-extrabold mt-1 leading-none">16</p>
                                <p class="text-xs text-blue-100 mt-2 font-medium">2025</p>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-bold">Pembersihan Karang Gigi</h4>
                                <div class="flex flex-wrap items-center gap-4 mt-3">
                                    <div class="flex items-center gap-2"><i class="fas fa-user-md text-blue-200 text-xs"></i><span class="text-sm text-white/90">dr. Andi Wijaya</span></div>
                                    <div class="flex items-center gap-2"><i class="fas fa-clock text-blue-200 text-xs"></i><span class="text-sm text-white/90">09:00 - 09:45 WIB</span></div>
                                </div>
                                <div class="flex items-center gap-2 mt-2"><i class="fas fa-map-marker-alt text-blue-200 text-xs"></i><span class="text-sm text-white/70">Klinik Utama - Lantai 2, Ruang 205</span></div>
                                <div class="flex gap-3 mt-5">
                                    <button class="bg-white text-blue-600 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-50 transition-colors cursor-pointer shadow-lg"><i class="fas fa-redo text-[10px]"></i> Jadwal Ulang</button>
                                    <button class="px-4 py-2.5 rounded-xl border border-white/20 text-white/90 text-xs font-bold hover:bg-white/10 transition-colors cursor-pointer">Batalkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="lg:col-span-2 fade-up" style="animation-delay:0.3s">
                    <div class="card overflow-hidden h-full">
                        <img src="https://picsum.photos/seed/dentalpromo/600/400.jpg" alt="Promo kesehatan gigi" class="w-full h-44 object-cover">
                        <div class="p-5">
                            <span class="tag bg-red-50 text-red-600 mb-2">Promo Spesial</span>
                            <h4 class="font-bold text-sm text-gray-900 mt-2 leading-snug">Diskon 20% Scaling Pertama</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">Berlaku hingga 30 April 2025 untuk pasien baru D'Smile.</p>
                            <button class="mt-4 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer transition-colors group">Gunakan Promo <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ARTIKEL (Tampil di semua kondisi) -->
            <section class="fade-up" style="animation-delay:0.35s">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Artikel & Tips Kesehatan Gigi</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Wawasan terbaru untuk senyum Anda</p>
                    </div>
                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer transition-colors">Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i></button>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="card article-card overflow-hidden cursor-pointer group" onclick="openArticle('Cara Menyikat Gigi yang Benar','https://picsum.photos/seed/teethbrush/800/400.jpg','<p class=\'mb-4\'>Menyikat gigi adalah fondasi utama kesehatan mulut. Namun, banyak orang yang melakukannya dengan cara yang kurang tepat. Berikut adalah panduan lengkap dari D\'Smile:</p><ul class=\'list-disc list-inside mb-4 text-gray-600\'><li class=\'mb-2\'><strong>Sikat selama 2 menit:</strong> Bagi mulut menjadi 4 kuadran dan habiskan 30 detik untuk setiap bagian.</li><li class=\'mb-2\'><strong>Teknik 45 derajat:</strong> Arahkan bulu sikat pada sudut 45 derajat ke garis gusi.</li><li class=\'mb-2\'><strong>Gerakan memutar:</strong> Hindari menyikat dari kiri ke kanan dengan keras. Gunakan gerakan memutar yang lembut.</li><li class=\'mb-2\'><strong>Jangan lupakan lidah:</strong> Bakteri juga menempel di lidah.</li></ul><p>Gunakan pasta gigi berfluoride dan ganti sikat gigi setiap 3 bulan.</p>','dr. Rina Sari','12 Apr 2025','5 min baca')">
                        <div class="overflow-hidden h-44"><img src="https://picsum.photos/seed/teethbrush/600/400.jpg" alt="Tips sikat gigi" class="w-full h-full object-cover"></div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5"><span class="tag bg-blue-50 text-blue-700">Gigi Sehat</span><span class="text-[11px] text-gray-400">5 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Cara Menyikat Gigi yang Benar</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Panduan lengkap langkah demi langkah untuk membersihkan gigi dan mulut secara efektif.</p>
                        </div>
                    </div>

                    <div class="card article-card overflow-hidden cursor-pointer group" onclick="openArticle('Makanan yang Baik untuk Kesehatan Gigi','https://picsum.photos/seed/dentalfood/800/400.jpg','<p class=\'mb-4\'>Apa yang Anda makan berpengaruh besar pada kesehatan gigi dan gusi.</p><ol class=\'list-decimal list-inside mb-4 text-gray-600\'><li class=\'mb-2\'><strong>Apel dan Wortel:</strong> Makanan renyah ini merangsang produksi air liur.</li><li class=\'mb-2\'><strong>Keju dan Yogurt:</strong> Kaya akan kalsium dan fosfat.</li><li class=\'mb-2\'><strong>Brokoli:</strong> Mengandung zat besi yang membantu membentuk penghalang asam.</li><li class=\'mb-2\'><strong>Teh Hijau:</strong> Mengandung polifenol yang membantu membunuh bakteri.</li></ol><p>Pastikan untuk minum air putih yang cukup setelah makan.</p>','dr. Budi Prasetyo','10 Apr 2025','7 min baca')">
                        <div class="overflow-hidden h-44"><img src="https://picsum.photos/seed/dentalfood/600/400.jpg" alt="Makanan untuk gigi" class="w-full h-full object-cover"></div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5"><span class="tag bg-amber-50 text-amber-700">Nutrisi</span><span class="text-[11px] text-gray-400">7 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Makanan yang Baik untuk Kesehatan Gigi</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Daftar makanan sehat yang membantu memperkuat enamel gigi dan menjaga kesehatan gusi.</p>
                        </div>
                    </div>

                    <div class="card article-card overflow-hidden cursor-pointer group sm:col-span-2 lg:col-span-1" onclick="openArticle('Benarkah Veneer Aman untuk Gigi?','https://picsum.photos/seed/whiteteeth/800/400.jpg','<p class=\'mb-4\'>Veneer menjadi salah satu prosedur kosmetik gigi paling populer saat ini. Namun, apakah prosedur ini aman?</p><p class=\'mb-4\'><strong>Apa itu Veneer?</strong><br>Veneer adalah cangkang tipis berwarna gigi yang menutupi permukaan depan gigi.</p><p class=\'mb-4\'><strong>Keamanan:</strong><br>Secara medis, veneer sangat aman jika dilakukan oleh dokter gigi profesional. Material yang digunakan biocompatible.</p><p class=\'mb-4\'><strong>Perawatan:</strong><br>Veneer porselen tahan noda dan bisa bertahan hingga 10-15 tahun dengan perawatan yang baik.</p>','drg. Andi Wijaya','8 Apr 2025','4 min baca')">
                        <img src="images/veener.png" class="doctor-img" alt="Gigi putih" class="w-full h-full object-cover">
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2.5"><span class="tag bg-purple-50 text-purple-700">Perawatan</span><span class="text-[11px] text-gray-400">4 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">Benarkah Veneer Aman untuk Gigi?</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Veneer menjadi tren perawatan gigi. Simak fakta medis sebelum Anda memutuskan.</p>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- MODAL ARTIKEL -->
    <div class="modal-overlay" id="articleModal">
        <div class="modal-content">
            <button onclick="closeArticle()" class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-colors z-10 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
            <img id="modalImg" src="" alt="Gambar Artikel" class="w-full h-64 object-cover flex-shrink-0 rounded-t-[20px]">
            <div class="p-8 modal-body-scroll overflow-y-auto flex-1">
                <h2 id="modalTitle" class="text-2xl font-extrabold text-gray-900 mb-3"></h2>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <span id="modalAuthor" class="text-sm text-gray-500 font-medium"></span>
                    <span class="text-gray-300">·</span>
                    <span id="modalDate" class="text-sm text-gray-400"></span>
                    <span class="text-gray-300">·</span>
                    <span id="modalReadTime" class="text-sm text-gray-400"></span>
                </div>
                <div id="modalBody" class="text-gray-600 text-[15px] leading-relaxed"></div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('mobileOverlay').classList.toggle('show'); }
        function toggleNotif() { document.getElementById('notifDropdown').classList.toggle('open'); document.getElementById('profileDropdown').classList.remove('open'); }
        function toggleProfile() { document.getElementById('profileDropdown').classList.toggle('open'); document.getElementById('notifDropdown').classList.remove('open'); }

        document.addEventListener('click', function(e) {
            const notifBtn = document.getElementById('notifBtn'); const notifDrop = document.getElementById('notifDropdown');
            const profileBtn = document.getElementById('profileBtn'); const profileDrop = document.getElementById('profileDropdown');
            if (!notifBtn.contains(e.target) && !notifDrop.contains(e.target)) notifDrop.classList.remove('open');
            if (!profileBtn.contains(e.target) && !profileDrop.contains(e.target)) profileDrop.classList.remove('open');
        });

        function updateDate() {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const now = new Date(); const dateStr = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            const dateEl = document.getElementById('currentDate'); if (dateEl) dateEl.textContent = dateStr;
        }
        updateDate();

        function openArticle(title, img, body, author, date, readTime) {
            document.getElementById('modalTitle').innerText = title; document.getElementById('modalImg').src = img;
            document.getElementById('modalBody').innerHTML = body; document.getElementById('modalAuthor').innerText = author;
            document.getElementById('modalDate').innerText = date; document.getElementById('modalReadTime').innerText = readTime;
            document.getElementById('articleModal').classList.add('open'); document.body.style.overflow = 'hidden';
        }
        function closeArticle() { document.getElementById('articleModal').classList.remove('open'); document.body.style.overflow = 'auto'; }
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeArticle(); });
    </script>
</body>
</html>