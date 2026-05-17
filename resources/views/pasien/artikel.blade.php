<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Kesehatan - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg: #eff6ff;
            --fg: #1e293b;
            --muted: #64748b;
            --accent: #2563eb;
            --card: #FFFFFF;
            --border: #dbeafe;
            --sidebar: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--fg);
            overflow-x: hidden;
        }

        /* Sidebar CSS moved to pasien.filesidebarpasien for consistency */

        /* --- EXISTING STYLES --- */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content header {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .main-content main {
            padding: 24px 32px;
            background: var(--bg);
        }

        .topbar {
            background: rgba(255,255,255,0.9);
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

        .card:hover {
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.08);
            border-color: #bfdbfe;
            transform: translateY(-2px);
        }

        .article-card img {
            transition: transform 0.4s ease;
        }

        .article-card:hover img {
            transform: scale(1.05);
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(30, 41, 59, 0.4);
            z-index: 45;
            backdrop-filter: blur(2px);
        }

        .mobile-overlay.show { display: block; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        @media (max-width: 640px) {
            .main-content main {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body class="page-fade-in">

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <div class="main-content">
        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">Artikel Kesehatan</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Informasi singkat untuk menjaga kesehatan gigi dan gusi</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 md:gap-4">
                    <div class="hidden md:flex items-center bg-white rounded-xl px-4 py-2.5 gap-2 w-72 border border-blue-100 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-50 transition-all">
                        <i class="fas fa-search text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari artikel, tips, atau topik..." class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none w-full font-medium">
                    </div>

                    <div class="relative">
                        <button class="flex items-center gap-3 pl-3 pr-1 py-1 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-800 leading-tight">Aprilia Ajeng</p>
                                <p class="text-[11px] text-gray-400">G41240104</p>
                            </div>
                            <img src="https://picsum.photos/seed/pasien-artikel/80/80.jpg" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Banner Utama -->
                    <div class="rounded-2xl p-6 text-white shadow-lg shadow-blue-200 relative overflow-hidden" style="background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);">
                        <div class="relative z-10 max-w-2xl">
                            <p class="text-blue-100 text-sm font-semibold mb-2">Artikel Pilihan</p>
                            <h3 class="text-3xl font-bold leading-tight mb-3">Panduan menjaga kesehatan gigi dan gusi setiap hari</h3>
                            <p class="text-blue-100 text-sm leading-relaxed">Temukan tips singkat yang bisa langsung diterapkan untuk menjaga senyum tetap sehat, bersih, dan percaya diri.</p>
                        </div>
                    </div>

                    <!-- Statistik Ringkas -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="card p-4">
                            <p class="text-xs text-slate-400 font-semibold uppercase">Tips</p>
                            <p class="text-2xl font-extrabold text-slate-800 mt-2">12</p>
                            <p class="text-xs text-slate-500 mt-1">Artikel singkat</p>
                        </div>
                        <div class="card p-4">
                            <p class="text-xs text-slate-400 font-semibold uppercase">Populer</p>
                            <p class="text-2xl font-extrabold text-slate-800 mt-2">8</p>
                            <p class="text-xs text-slate-500 mt-1">Topik dibaca</p>
                        </div>
                        <div class="card p-4">
                            <p class="text-xs text-slate-400 font-semibold uppercase">Kesehatan</p>
                            <p class="text-2xl font-extrabold text-slate-800 mt-2">4.8</p>
                            <p class="text-xs text-slate-500 mt-1">Skor konten</p>
                        </div>
                        <div class="card p-4">
                            <p class="text-xs text-slate-400 font-semibold uppercase">Baru</p>
                            <p class="text-2xl font-extrabold text-slate-800 mt-2">3</p>
                            <p class="text-xs text-slate-500 mt-1">Update hari ini</p>
                        </div>
                    </div>

                    <!-- Daftar Artikel -->
                    <div class="grid md:grid-cols-2 gap-5">
                        <article class="article-card card overflow-hidden">
                            <div class="h-44 bg-blue-50 flex items-center justify-center relative">
                                <i class="fas fa-tooth text-5xl text-blue-500"></i>
                            </div>
                            <div class="p-5 space-y-3">
                                <span class="tag bg-blue-50 text-blue-600">Kebersihan Harian</span>
                                <h4 class="text-lg font-bold text-slate-800">Cara menyikat gigi yang benar</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">Gunakan sikat berbulu lembut, teknik memutar lembut, dan durasi minimal dua menit setiap kali menyikat gigi.</p>
                                <button class="w-full py-2 rounded-lg bg-slate-50 text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Baca Selengkapnya</button>
                            </div>
                        </article>

                        <article class="article-card card overflow-hidden">
                            <div class="h-44 bg-emerald-50 flex items-center justify-center relative">
                                <i class="fas fa-apple-whole text-5xl text-emerald-500"></i>
                            </div>
                            <div class="p-5 space-y-3">
                                <span class="tag bg-emerald-50 text-emerald-600">Pola Makan</span>
                                <h4 class="text-lg font-bold text-slate-800">Makanan yang baik untuk gigi</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">Kalsium, vitamin D, dan air putih membantu menjaga kekuatan email gigi serta kesehatan gusi.</p>
                                <button class="w-full py-2 rounded-lg bg-slate-50 text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Baca Selengkapnya</button>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Sidebar Kanan -->
                <aside class="card p-5 h-fit sticky top-24">
                    <h4 class="font-bold text-slate-800 mb-4">Artikel Populer</h4>
                    <div class="space-y-4">
                        <div class="flex gap-3 cursor-pointer hover:bg-slate-50 p-2 rounded-lg transition">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Efek samping pemutih gigi</p>
                                <p class="text-xs text-slate-500 mt-1">Tips aman sebelum whitening</p>
                            </div>
                        </div>
                        <div class="flex gap-3 cursor-pointer hover:bg-slate-50 p-2 rounded-lg transition">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                                <i class="fas fa-shield-heart text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Pencegahan gigi berlubang</p>
                                <p class="text-xs text-slate-500 mt-1">Kebiasaan kecil, dampak besar</p>
                            </div>
                        </div>
                        <div class="flex gap-3 cursor-pointer hover:bg-slate-50 p-2 rounded-lg transition">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                                <i class="fas fa-tooth text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Sakit gigi saat hamil</p>
                                <p class="text-xs text-slate-500 mt-1">Waspada perubahan hormon</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (sidebar && overlay) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            }
        }
    </script>

</body>
</html>
