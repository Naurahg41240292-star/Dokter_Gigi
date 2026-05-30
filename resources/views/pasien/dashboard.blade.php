<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' },
                        accent: '#2563eb', surface: '#eff6ff',
                    }
                }
            }
        }
    </script>
    <style>
        :root { --bg:#eff6ff; --fg:#1e293b; --muted:#64748b; --accent:#2563eb; --card:#FFFFFF; --border:#dbeafe; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--fg); overflow-x:hidden; }
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#bfdbfe; border-radius:3px; }

        @keyframes pageFadeIn {
            from { opacity:0; transform:translateY(8px); }
            to { opacity:1; transform:translateY(0); }
        }
        .page-fade-in { animation: pageFadeIn 0.28s ease both; }

        .main-content { margin-left:260px; min-height:100vh; }

        .topbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
        }
        .card:hover { box-shadow:0 12px 40px rgba(37,99,235,0.08); border-color:#bfdbfe; transform:translateY(-2px); }

        .stat-card { position:relative; overflow:hidden; }
        .stat-card::after { content:''; position:absolute; top:-20px; right:-20px; width:80px; height:80px; border-radius:50%; opacity:0.08; }
        .stat-card.blue::after { background:#2563EB; } .stat-card.orange::after { background:#F59E0B; }
        .stat-card.purple::after { background:#8B5CF6; } .stat-card.teal::after { background:#06C4AD; }

        .tag { display:inline-flex; align-items:center; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600; }

        .schedule-card { background:linear-gradient(135deg,#3b82f6,#2563eb); border:none; color:#fff; border-radius:20px; position:relative; overflow:hidden; box-shadow:0 10px 30px rgba(37,99,235,0.25); }
        .schedule-card::before { content:''; position:absolute; top:-40px; right:-40px; width:160px; height:160px; background:rgba(255,255,255,0.1); border-radius:50%; }

        .article-card { overflow:hidden; cursor:pointer; }
        .article-card .article-img { transition:transform 0.4s ease; }
        .article-card:hover .article-img { transform:scale(1.06); }
        .article-card:hover .article-title { color:var(--accent); }

        .fade-up { opacity:0; transform:translateY(16px); animation:fadeUp 0.6s ease forwards; }
        @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
        .fade-up:nth-child(1){animation-delay:.05s} .fade-up:nth-child(2){animation-delay:.1s}
        .fade-up:nth-child(3){animation-delay:.15s} .fade-up:nth-child(4){animation-delay:.2s}

        .online-dot { width:8px; height:8px; background:#22C55E; border-radius:50%; border:2px solid #fff; position:absolute; bottom:0; right:0; }

        .promo-card img { transition:transform 0.4s ease; }
        .promo-card:hover img { transform:scale(1.04); }

        .mobile-overlay { display:none; position:fixed; inset:0; background:rgba(30,41,59,0.4); z-index:45; backdrop-filter:blur(2px); }
        .mobile-overlay.show { display:block; }
        @media (max-width:1024px) { .main-content { margin-left:0; } }

        .article-modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px); z-index:200; display:none; }
        .article-modal-overlay.open { display:block; }
        .article-modal-sticky-bar { position:sticky; top:0; z-index:210; display:flex; justify-content:flex-end; padding:16px 16px 0 0; pointer-events:none; }
        .article-modal-close-btn { pointer-events:auto; width:40px; height:40px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:none; color:#475569; font-size:14px; transition:all 0.2s ease; box-shadow:0 2px 12px rgba(0,0,0,0.15); }
        .article-modal-close-btn:hover { background:#f1f5f9; color:#0f172a; box-shadow:0 4px 20px rgba(0,0,0,0.2); }
        .article-modal-scroll { position:absolute; inset:0; overflow-y:auto; overscroll-behavior:contain; -webkit-overflow-scrolling:touch; padding:0 16px 40px 16px; }
        .article-modal-content { background:#fff; border-radius:20px; max-width:700px; width:100%; margin:24px auto 24px auto; overflow:hidden; animation:fadeUp 0.3s ease; }
        .article-modal-img { width:100%; height:220px; object-fit:cover; display:block; }
        .article-modal-body { padding:28px 32px 36px 32px; }
        .article-modal-body h2 { font-size:22px; font-weight:800; color:#0f172a; margin-bottom:14px; line-height:1.35; }
        .article-modal-meta { display:flex; align-items:center; gap:8px; margin-bottom:24px; padding-bottom:18px; border-bottom:1px solid #f1f5f9; flex-wrap:wrap; }
        .article-modal-meta span { font-size:13px; color:#94a3b8; }
        .article-modal-meta .dot { width:3px; height:3px; background:#cbd5e1; border-radius:50%; display:inline-block; }
        .article-modal-content .article-text { font-size:15px; line-height:1.85; color:#475569; }
        .article-modal-content .article-text p { margin-bottom:16px; }
        .article-modal-content .article-text ul, .article-modal-content .article-text ol { margin-bottom:16px; padding-left:20px; }
        .article-modal-content .article-text li { margin-bottom:10px; line-height:1.75; }
        .notif-dropdown { transform: translateY(-10px); opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.2s ease; }
.notif-dropdown.show { transform: translateY(0); opacity: 1; visibility: visible; pointer-events: auto; }
    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>
    @include('pasien.filesidebarpasien')

    <div class="main-content page-fade-in">

        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div>
                        @if($totalAppointments == 0)
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">Selamat datang di D'Smile, {{ auth()->user()->name }}! 👋</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Mari mulai perjalanan kesehatan gigi Anda</p>
                        @else
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">Selamat datang {{ auth()->user()->name }}!</h2>
                            <p class="text-xs text-gray-400 mt-0.5" id="currentDate"></p>
                        @endif
                    </div>
                </div>

                <!-- TOPBAR - Bagian Profil -->
                <div class="flex items-center gap-3">
                    <!-- Notifikasi -->
                    <div class="relative">
                        <button id="notif-btn" class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center focus:outline-none">
                            <i class="fas fa-bell text-slate-600"></i>
                            <span id="notif-dot" class="absolute top-1.5 right-1.5 w-5 h-5 bg-red-500 rounded-full border-2 border-white text-white text-[10px] flex items-center justify-center font-bold" style="display: none;">0</span>
                        </button>
                        
                        <div id="notif-dropdown" class="notif-dropdown absolute right-0 top-full mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                                <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                            </div>
                            <div id="notif-list" class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                                <div class="p-4 text-center text-slate-400 text-sm">Memuat notifikasi...</div>
                            </div>
                        </div>
                    </div>
                    <!-- Profil -->
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

        <main class="px-6 lg:px-8 py-6">

            <!-- STAT CARDS (DATA ASLI DARI CONTROLLER) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card stat-card blue p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i class="fas fa-calendar-alt text-blue-600 text-sm"></i></div>
                        @if($upcomingAppointment)<span class="tag bg-amber-50 text-amber-600">Aktif</span>@endif
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalAppointments }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Appointment</p>
                </div>
                <div class="card stat-card orange p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center"><i class="fas fa-tooth text-amber-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalPerawatan }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Total Perawatan</p>
                </div>
                <div class="card stat-card purple p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center"><i class="fas fa-file-invoice text-purple-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $tagihanPending }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Tagihan Pending</p>
                </div>
                <div class="card stat-card teal p-5 fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center"><i class="fas fa-star text-teal-500 text-sm"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalAppointments > 0 ? '4.8' : 'N/A' }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">Skor Kesehatan Gigi</p>
                </div>
            </div>

            <!-- CTA + PROMO (KONDISIONAL BERDASARKAN $upcomingAppointment) -->
            <div class="grid lg:grid-cols-5 gap-5 mb-8">
                
                @if($upcomingAppointment)
                <!-- KARTU KALO ADA JANJI TEMU AKTIF MENDATANG -->
                <div class="lg:col-span-3 fade-up" style="animation-delay:0.25s">
                    <a href="{{ route('appointment.index') }}" class="block schedule-card p-6 relative z-10 h-full hover:scale-[1.01] transition-transform cursor-pointer">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <span class="tag bg-white/15 text-white/90 mb-2 border border-white/10">Mendatang</span>
                                <h3 class="text-lg font-bold mt-2">Appointment Berikutnya</h3>
                            </div>
                            @if($upcomingAppointment->status == 'Terjadwal')
                                <span class="tag bg-green-100 text-green-700 border border-green-200">Terjadwal</span>
                            @else
                                <span class="tag bg-amber-100 text-amber-700 border border-amber-200">Menunggu Konfirmasi</span>
                            @endif
                        </div>
                        <div class="flex flex-col sm:flex-row gap-5">
                            <div class="bg-white/10 rounded-xl p-4 text-center flex-shrink-0 w-full sm:w-28 backdrop-blur-sm border border-white/10">
                                <p class="text-[11px] text-blue-100 font-semibold uppercase tracking-wider">{{ \Carbon\Carbon::parse($upcomingAppointment->tanggal)->format('M') }}</p>
                                <p class="text-4xl font-extrabold mt-1 leading-none">{{ \Carbon\Carbon::parse($upcomingAppointment->tanggal)->format('d') }}</p>
                                <p class="text-xs text-blue-100 mt-2 font-medium">{{ \Carbon\Carbon::parse($upcomingAppointment->tanggal)->format('Y') }}</p>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-bold">{{ $upcomingAppointment->jenis_perawatan }}</h4>
                                <div class="flex flex-wrap items-center gap-4 mt-3">
                                    <div class="flex items-center gap-2"><i class="fas fa-user-md text-blue-200 text-xs"></i><span class="text-sm text-white/90">{{ $upcomingAppointment->dokter }}</span></div>
                                    <div class="flex items-center gap-2"><i class="fas fa-clock text-blue-200 text-xs"></i><span class="text-sm text-white/90">{{ $upcomingAppointment->waktu }} WIB</span></div>
                                </div>
                                <div class="mt-5">
                                    <span class="text-xs text-white/80 font-semibold flex items-center gap-2">Lihat Detail & E-Ticket <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <!-- KARTU KALO BELUM ADA JANJI TEMU (EMPTY STATE) -->
                <div class="lg:col-span-3 fade-up" style="animation-delay:0.25s">
                    <a href="{{ route('appointment.index') }}" class="card p-8 text-center flex flex-col items-center justify-center h-full border-dashed border-2 border-blue-200 bg-blue-50/30 block hover:border-blue-400 transition-colors cursor-pointer group">
                        <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mb-5 shadow-inner group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-calendar-plus text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Janji Temu</h3>
                        <p class="text-gray-500 text-sm mb-6 max-w-sm leading-relaxed">Mulai perjalanan kesehatan gigi Anda dengan membuat janji temu pertama bersama dokter profesional kami.</p>
                        <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-blue-200 transition-all cursor-pointer inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i> Buat Janji Temu Sekarang
                        </span>
                    </a>
                </div>
                @endif

                <div class="lg:col-span-2 fade-up" style="animation-delay:0.3s">
                    <div class="card overflow-hidden h-full promo-card">
                        <div class="overflow-hidden h-44">
                            <img src="{{ asset('images/scaling.jpeg') }}" alt="Promo" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <span class="tag bg-red-50 text-red-600 mb-2">Promo Spesial</span>
                            <h4 class="font-bold text-sm text-gray-900 mt-2 leading-snug">Diskon 20% Scaling Pertama</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">Berlaku hingga 30 April 2025 untuk pasien baru D'Smile.</p>
                            <button class="mt-4 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer transition-colors group">Gunakan Promo <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ARTIKEL -->
            <section class="fade-up" style="animation-delay:0.35s">
                <div class="mb-5">
                    <h3 class="font-bold text-gray-800 text-base">Tips & Artikel Kesehatan Gigi</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Wawasan terbaru untuk senyum Anda</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="card article-card group" onclick="openArticle('Cara Menyikat Gigi yang Benar','{{ asset('images/sikatgigi.jpeg') }}','<p>Menyikat gigi adalah fondasi utama kesehatan mulut. Namun, banyak orang yang melakukannya dengan cara yang kurang tepat. Berikut adalah panduan lengkap:</p><ul><li><strong>Sikat selama 2 menit:</strong> Bagi mulut menjadi 4 kuadran dan habiskan 30 detik untuk setiap bagian.</li><li><strong>Teknik 45 derajat:</strong> Arahkan bulu sikat pada sudut 45 derajat ke garis gusi.</li><li><strong>Gerakan memutar:</strong> Hindari menyikat dari kiri ke kanan dengan keras. Gunakan gerakan memutar yang lembut.</li><li><strong>Jangan lupakan lidah:</strong> Bakteri juga menempel di lidah.</li></ul><p>Gunakan pasta gigi berfluoride dan ganti sikat gigi setiap 3 bulan.</p>','dr. Rina Sari','12 Apr 2025','5 min baca')">
                        <div class="overflow-hidden h-48"><img src="{{ asset('images/sikatgigi.jpeg') }}" alt="Tips sikat gigi" class="w-full h-full object-cover article-img"></div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3"><span class="tag bg-blue-50 text-blue-700">Gigi Sehat</span><span class="text-[11px] text-gray-400">5 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug article-title transition-colors">Cara Menyikat Gigi yang Benar</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Panduan lengkap langkah demi langkah untuk membersihkan gigi dan mulut secara efektif.</p>
                        </div>
                    </div>

                    <div class="card article-card group" onclick="openArticle('Makanan yang Baik untuk Gigi','{{ asset('images/makanan.jpeg') }}','<p>Apa yang Anda makan berpengaruh besar pada kesehatan gigi dan gusi.</p><ol><li><strong>Apel dan Wortel:</strong> Makanan renyah ini merangsang produksi air liur.</li><li><strong>Keju dan Yogurt:</strong> Kaya akan kalsium dan fosfat.</li><li><strong>Brokoli:</strong> Mengandung zat besi yang membantu membentuk penghalang asam.</li><li><strong>Teh Hijau:</strong> Mengandung polifenol yang membantu membunuh bakteri.</li></ol><p>Pastikan untuk minum air putih yang cukup setelah makan.</p>','dr. Budi Prasetyo','10 Apr 2025','7 min baca')">
                        <div class="overflow-hidden h-48"><img src="{{ asset('images/makanan.jpeg') }}" alt="Makanan untuk gigi" class="w-full h-full object-cover article-img"></div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3"><span class="tag bg-amber-50 text-amber-700">Nutrisi</span><span class="text-[11px] text-gray-400">7 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug article-title transition-colors">Makanan yang Baik untuk Kesehatan Gigi</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Daftar makanan sehat yang membantu memperkuat enamel gigi dan menjaga kesehatan gusi.</p>
                        </div>
                    </div>

                    <div class="card article-card group sm:col-span-2 lg:col-span-1" onclick="openArticle('Benarkah Veneer Aman untuk Gigi?','{{ asset('images/veener.jpeg') }}','<p>Veneer menjadi salah satu prosedur kosmetik gigi paling populer saat ini. Namun, apakah prosedur ini aman?</p><p><strong>Apa itu Veneer?</strong><br>Veneer adalah cangkang tipis berwarna gigi yang menutupi permukaan depan gigi.</p><p><strong>Keamanan:</strong><br>Secara medis, veneer sangat aman jika dilakukan oleh dokter gigi profesional. Material yang digunakan biocompatible.</p><p><strong>Perawatan:</strong><br>Veneer porselen tahan noda dan bisa bertahan hingga 10-15 tahun dengan perawatan yang baik.</p>','drg. Andi Wijaya','8 Apr 2025','4 min baca')">
                        <div class="overflow-hidden h-48"><img src="{{ asset('images/veener.jpeg') }}" alt="Gigi putih" class="w-full h-full object-cover article-img"></div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3"><span class="tag bg-purple-50 text-purple-700">Perawatan</span><span class="text-[11px] text-gray-400">4 min baca</span></div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug article-title transition-colors">Benarkah Veneer Aman untuk Gigi?</h4>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed line-clamp-2">Veneer menjadi tren perawatan gigi. Simak fakta medis sebelum Anda memutuskan.</p>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- MODAL ARTIKEL -->
    <div class="article-modal-overlay" id="articleModal">
        <div class="article-modal-scroll" id="articleModalScroll">
            <div class="article-modal-sticky-bar">
                <button class="article-modal-close-btn" onclick="closeArticle()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="article-modal-content" onclick="event.stopPropagation()">
                <img id="modalImg" src="" alt="Gambar Artikel" class="article-modal-img">
                <div class="article-modal-body">
                    <h2 id="modalTitle"></h2>
                    <div class="article-modal-meta">
                        <span id="modalAuthor" class="font-medium text-gray-600"></span>
                        <span class="dot"></span>
                        <span id="modalDate"></span>
                        <span class="dot"></span>
                        <span id="modalReadTime"></span>
                    </div>
                    <div id="modalBody" class="article-text"></div>
                </div>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

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

            fetch('{{ route("pasien.notifikasi") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP status ' + response.status);
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
                                        <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fas fa-bell text-primary-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-800">${item.pesan}</p>
                                            <p class="text-[10px] text-slate-400 mt-1.5 font-medium">${item.waktu}</p>
                                        </div>
                                    </div>
                                    <span class="absolute top-4 right-4 w-2 h-2 bg-primary-500 rounded-full"></span>
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
            .catch(error => console.warn('Gagal memuat notifikasi:', error.message));
        }

        fetchNotifications();
        setInterval(fetchNotifications, 10000);

    });
</script>
</body>
</html>