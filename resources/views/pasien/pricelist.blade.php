<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pricelist - D'Smile Dental Clinic</title>
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

        .topbar {
            background: rgba(255,255,255,0.92); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40;
        }

        .card-price {
            background: var(--card); border: 1px solid var(--border); border-radius: 20px;
            transition: all 0.3s ease; overflow: hidden; display: flex; flex-direction: column;
        }
        .card-price:hover { 
            box-shadow: 0 20px 40px rgba(37,99,235,0.1); border-color:#93c5fd; 
            transform: translateY(-6px); 
        }

        .card-img-wrapper {
            position: relative; height: 200px; overflow: hidden;
        }
        .card-img-wrapper img {
            width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;
        }
        .card-price:hover .card-img-wrapper img {
            transform: scale(1.1);
        }

        .badge-promo {
            position: absolute; top: 12px; left: 12px; background: #ef4444; color: white;
            font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 8px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .mobile-overlay { display:none; position:fixed; inset:0; background:rgba(30,41,59,0.4); z-index:45; backdrop-filter:blur(2px); }
        .mobile-overlay.show { display:block; }
        
        /* PERBAIKAN CSS NOTIFIKASI DI SINI (Pakai .show dan pointer-events) */
        .notif-dropdown { 
            position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--border); 
            opacity: 0; visibility: hidden; transform: translateY(-8px); pointer-events: none; /* Tambahan penting */
            transition: all 0.25s ease; z-index: 60; width: 340px; border-radius: 16px; box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1); 
        }
        .notif-dropdown.show { /* Diubah dari .open jadi .show */
            opacity: 1; visibility: visible; transform: translateY(0); pointer-events: auto; /* Tambahan penting */
        }
        .online-dot { width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: 2px solid #fff; position: absolute; bottom: 0; right: 0; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
        .animate-fade-up { animation: fadeUp 0.5s ease forwards; }
        .delay-1 { animation-delay: 0.05s; opacity: 0; }
        .delay-2 { animation-delay: 0.1s; opacity: 0; }
        .delay-3 { animation-delay: 0.15s; opacity: 0; }
        .delay-4 { animation-delay: 0.2s; opacity: 0; }
        .delay-5 { animation-delay: 0.25s; opacity: 0; }
        .delay-6 { animation-delay: 0.3s; opacity: 0; }
        .delay-7 { animation-delay: 0.35s; opacity: 0; }
        .delay-8 { animation-delay: 0.4s; opacity: 0; }

        @media(max-width:1024px) { .sidebar{transform:translateX(-100%);} .sidebar.open{transform:translateX(0);} .main-content{margin-left:0;} }
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
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight" id="page-title">Price List</h2>
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

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button id="notif-btn" class="relative cursor-pointer p-2.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition hidden md:flex items-center justify-center focus:outline-none">
                            <i class="fas fa-bell text-slate-600"></i>
                            <span id="notif-dot" class="absolute top-1.5 right-1.5 w-5 h-5 bg-red-500 rounded-full border-2 border-white text-white text-[10px] flex items-center justify-center font-bold" style="display: none;">0</span>
                        </button>
                        
                        <div id="notif-dropdown" class="notif-dropdown">
                            <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                                <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                            </div>
                            <div id="notif-list" class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                                <div class="p-4 text-center text-slate-400 text-sm">Memuat notifikasi...</div>
                            </div>
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
        <main class="px-6 lg:px-8 py-8">

            <!-- Header Section -->
            <div class="mb-8 animate-fade-up">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Pricelist Perawatan ✨</h1>
                <p class="text-gray-500 mt-2 text-sm md:text-base max-w-xl">Investasi terbaik untuk senyum sempurna Anda. Harga transparan, tanpa biaya tersembunyi.</p>
            </div>

                        <!-- Pricelist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                                <!-- 1. Behel Gigi -->
                <div class="card-price animate-fade-up delay-1">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/behel.jpeg') }}" alt="Behel Gigi">
                        <span class="badge-promo">Promo</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Behel Gigi (Ortodonti)</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Perawatan merapikan susunan gigi dan rahang untuk senyum lebih percaya diri.</p>
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 line-through">Rp 7.000.000</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 5.000.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Behel Gigi" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 2. Bleaching Gigi -->
                <div class="card-price animate-fade-up delay-2">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/bleaching.jpeg') }}" alt="Bleaching Gigi">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Bleaching Gigi</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Pemutihan gigi profesional hasil instan dalam 1 kali kunjungan.</p>
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-400 font-medium">Mulai dari</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 1.500.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Bleaching Gigi" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 3. Gigi Tiruan -->
                <div class="card-price animate-fade-up delay-3">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/gigitiruan.jpeg') }}" alt="Gigi Tiruan">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Gigi Tiruan (Denture)</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Solusi gigi palsu estetis dan nyaman untuk menggantikan gigi yang hilang.</p>
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-400 font-medium">Mulai dari</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 2.500.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Gigi Tiruan" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 4. Gum Lifting -->
                <div class="card-price animate-fade-up delay-4">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/gum.jpeg') }}" alt="Gum Lifting">
                        <span class="badge-promo">Best Seller</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Gum Lifting</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Perbaikan kontur gusi untuk tampilan gusi lebih rapi dan proporsional.</p>
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 line-through">Rp 4.000.000</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 3.000.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Gum Lifting" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 5. Veneer -->
                <div class="card-price animate-fade-up delay-5">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/vener.jpeg') }}" alt="Veneer">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Veneer</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Lapisan tipis porselen custom-made untuk gigi putih berkilau sempurna.</p>
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-400 font-medium">Mulai dari</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 4.500.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Pemasangan Crown / Veneer" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 6. Tambal Gigi -->
                <div class="card-price animate-fade-up delay-6">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/tambal.jpeg') }}" alt="Tambal Gigi">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Tambal Gigi</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Perbaikan gigi berlubang dengan material komposit estetis senada gigi asli.</p>
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-400 font-medium">Mulai dari</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 350.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Penambalan Gigi" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 7. Cabut Gigi -->
                <div class="card-price animate-fade-up delay-7">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/cabutg.jpeg') }}" alt="Cabut Gigi">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Cabut Gigi</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Pencabutan gigi dengan prosedur steril, aman, dan minim rasa sakit.</p>
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-400 font-medium">Mulai dari</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 300.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Pencabutan Gigi" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

                <!-- 8. Scaling Gigi -->
                <div class="card-price animate-fade-up delay-8">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/ccalingg.jpeg') }}" alt="Scaling Gigi">
                        <span class="badge-promo">Promo</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[17px] mb-1">Scaling Gigi</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4 flex-1">Pembersihan karang gigi dan plak keras untuk menjaga kesehatan gusi.</p>
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 line-through">Rp 500.000</p>
                            <p class="text-xl font-extrabold text-primary-600">Rp 400.000</p>
                        </div>
                        <a href="{{ route('appointment.index') }}?open_form=1&treatment=Scaling Gigi" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs rounded-xl transition-colors text-center block shadow-md shadow-blue-200">
                            Buat Janji
                        </a>
                    </div>
                </div>

            </div>
<!-- Note Section -->
<div class="mt-10 bg-white border border-blue-100 rounded-2xl p-5 flex items-start gap-4 animate-fade-up delay-8">
<div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-blue-100">
<i class="fas fa-info-circle text-blue-600"></i>
</div>
<div>
<h4 class="font-bold text-gray-800 text-sm">Informasi Harga</h4>
<p class="text-xs text-gray-500 mt-1 leading-relaxed">Harga yang tertera adalah harga estimasi awal. Harga final dapat berubah sesuai dengan kondisi gigi setelah pemeriksaan langsung oleh dokter. Harga sudah termasuk biaya konsultasi dasar.</p>
</div>
</div>

</main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        const notifDot = document.getElementById('notif-dot');
        const notifList = document.getElementById('notif-list');

        if(notifBtn) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('show'); // Sesuai dengan CSS .notif-dropdown.show
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