<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - D'Smile</title>
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
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        success: {
                            50: '#f0fdf4',
                            500: '#22c55e',
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

        /* Layout */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
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

        /* Sidebar - PUTIH */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(59, 130, 246, 0.03);
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            border-radius: 10px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
            margin: 0 12px;
            text-decoration: none;
        }

        .sidebar-link:hover {
            color: var(--accent);
            background: #eff6ff;
        }

        .sidebar-link.active {
            color: var(--accent);
            background: #eff6ff;
            font-weight: 600;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-link.text-red-500 {
            color: #ef4444;
        }

        .sidebar-link.text-red-500:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .sidebar-title {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding-left: 32px;
            margin-bottom: 8px;
            margin-top: 24px;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(30, 41, 59, 0.4);
            z-index: 45;
            backdrop-filter: blur(2px);
        }

        .mobile-overlay.show {
            display: block;
        }

        /* Payment Method Card */
        .payment-method-card {
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .payment-method-card:hover {
            background-color: #f8fafc;
            border-color: #bfdbfe;
        }
        .payment-method-card.active {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
        .payment-method-card.active .check-circle {
            opacity: 1;
            transform: scale(1);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    @include('pasien.filesidebarpasien')

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Header -->
        <header class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Pasien</p>
                    <h2 class="text-lg md:text-2xl font-bold text-slate-800">Pembayaran</h2>
                </div>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <div class="hidden md:flex items-center bg-white border border-slate-200 rounded-xl px-4 py-2">
                    <i class="fas fa-search text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Cari..." class="ml-2 text-sm outline-none w-32 md:w-40 bg-transparent text-slate-600">
                </div>
                <div class="flex items-center gap-3 pl-2 md:pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">Aprilia Ajeng W</p>
                        <p class="text-[11px] text-slate-400">G41240104</p>
                    </div>
                    <img src="https://picsum.photos/seed/aprilia/100/100" alt="Pasien" class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-white shadow-sm object-cover">
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6 md:p-8">

            <!-- Summary Banner -->
            <div class="rounded-2xl p-6 text-white shadow-lg shadow-blue-200 mb-8 relative overflow-hidden" style="background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);">
                <div class="absolute right-0 top-0 w-64 h-full bg-white opacity-5 skew-x-12 translate-x-10"></div>
                <div class="relative z-10">
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Tagihan Aktif</p>
                    <h3 class="text-3xl font-bold tracking-tight">Rp 450.000</h3>
                    <div class="mt-4 flex items-center gap-3">
                        <span class="bg-blue-800/50 text-blue-100 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-500/30">
                            1 Tagihan Belum Dibayar
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- LEFT COLUMN: Tagihan & Riwayat -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- TAGIHAN MENUNGGU -->
                    <section>
                        <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-primary-600 rounded-full"></span> Tagihan Menunggu
                        </h4>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-5 flex flex-col md:flex-row gap-5">
                                <!-- Doctor Avatar/Info -->
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl border border-blue-100 font-bold">
                                        P
                                    </div>
                                    <div>
                                        <h5 class="text-lg font-bold text-slate-800">Pembersihan Karang Gigi</h5>
                                        <p class="text-sm text-slate-500 mt-1">drg. Putri Ananda</p>
                                        <div class="mt-2 flex items-center gap-2 text-xs text-slate-400">
                                            <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-medium">20 April 2025</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price & Status -->
                                <div class="md:ml-auto flex flex-col md:items-end justify-between w-full md:w-auto">
                                    <div class="text-right mb-3">
                                        <span class="text-xs text-slate-400 block mb-0.5">Total Pembayaran</span>
                                        <span class="text-xl font-extrabold text-primary-600">Rp 450.000</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-orange-50 text-orange-600 border border-orange-100 text-[10px] font-bold uppercase px-2 py-1 rounded-full">Belum Dibayar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- RIWAYAT PEMBAYARAN -->
                    <section>
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 bg-slate-400 rounded-full"></span> Riwayat Pembayaran
                            </h4>
                            <button class="text-xs text-primary-600 font-bold hover:underline">Lihat Semua</button>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 divide-y divide-slate-100">

                            <!-- History Item 1 -->
                            <div class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-100">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm group-hover:text-primary-600 transition-colors">Konsultasi & Pemeriksaan</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">drg. Andi Wijaya • 28 Mar 2025</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-400 text-sm line-through decoration-slate-300">Rp 150.000</p>
                                    <p class="text-[10px] font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded mt-1 inline-block">Lunas</p>
                                </div>
                            </div>

                            <!-- History Item 2 (Placeholder) -->
                            <div class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors opacity-70">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-100">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm">Penambalan Gigi</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">drg. Budi Santoso • 10 Feb 2025</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-400 text-sm line-through decoration-slate-300">Rp 200.000</p>
                                    <p class="text-[10px] font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded mt-1 inline-block">Lunas</p>
                                </div>
                            </div>

                        </div>
                    </section>

                </div>

                <!-- RIGHT COLUMN: Metode Pembayaran -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sticky top-24">
                        <h4 class="font-bold text-slate-800 mb-4">Metode Pembayaran</h4>

                        <div class="space-y-3">
                            <!-- Mandiri -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#FFB800] rounded shadow-sm border border-[#E5A600]"></div>
                                    <span class="text-sm font-bold text-slate-700">Bank Mandiri</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                            <!-- BRI -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#00529C] rounded shadow-sm border border-[#003D73]"></div>
                                    <span class="text-sm font-bold text-slate-700">Bank BRI</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                            <!-- BCA -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#005EB8] rounded shadow-sm border border-[#004A91]"></div>
                                    <span class="text-sm font-bold text-slate-700">Bank BCA</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 my-2"></div>
                            <p class="text-xs text-slate-400 font-bold uppercase px-1 mb-2">E-Wallet</p>

                            <!-- DANA -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#118EEA] rounded shadow-sm border border-[#0E7BC7] text-white text-[8px] font-bold flex items-center justify-center">DANA</div>
                                    <span class="text-sm font-bold text-slate-700">DANA</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                            <!-- OVO -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#4C3494] rounded shadow-sm border border-[#3B2570] text-white text-[8px] font-bold flex items-center justify-center">OVO</div>
                                    <span class="text-sm font-bold text-slate-700">OVO</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                            <!-- GoPay -->
                            <div class="payment-method-card flex items-center justify-between p-3 rounded-xl border border-slate-200" onclick="selectPayment(this)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-5 bg-[#00AED6] rounded shadow-sm border border-[#008FB2] text-white text-[8px] font-bold flex items-center justify-center">GoPay</div>
                                    <span class="text-sm font-bold text-slate-700">GoPay</span>
                                </div>
                                <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 text-primary-600 flex items-center justify-center opacity-0 transition-all">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>

                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-slate-500">Total Bayar</span>
                                <span class="font-extrabold text-slate-800 text-lg">Rp 450.000</span>
                            </div>
                            <button onclick="processPayment()" class="w-full bg-primary-600 text-white py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 hover:bg-primary-700 transition transform active:scale-95 flex items-center justify-center gap-2">
                                <span>Bayar Sekarang</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                            <p class="text-center text-[10px] text-slate-400 mt-3">
                                <i class="fas fa-lock"></i> Transaksi Aman & Terenkripsi
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Sukses -->
    <div id="successModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                <i class="fas fa-check"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Pembayaran Berhasil!</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                Pembayaran Anda telah diverifikasi. Bukti transaksi dikirim ke email.
            </p>
            <button onclick="closeModal()" class="w-full py-3 bg-primary-600 text-white rounded-xl font-bold text-sm hover:bg-primary-700 transition shadow-lg shadow-blue-200">
                Kembali ke Menu
            </button>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar?.classList.toggle('open');
            overlay?.classList.toggle('show');
        }

        function selectPayment(element) {
            // Remove active class from all cards
            document.querySelectorAll('.payment-method-card').forEach(el => {
                el.classList.remove('active');
            });
            // Add active class to clicked card
            element.classList.add('active');
        }

        function processPayment() {
            // Check if payment method is selected
            const selected = document.querySelector('.payment-method-card.active');
            if(!selected) {
                alert("Silakan pilih metode pembayaran terlebih dahulu.");
                return;
            }

            // Open Success Modal
            const modal = document.getElementById('successModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('successModal');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    </script>
</body>
</html>
