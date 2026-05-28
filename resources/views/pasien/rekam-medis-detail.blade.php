<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekam Medis - D'Smile</title>
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
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8' }
                    }
                }
            }
        }
    </script>
    <style>
        :root { --bg:#eff6ff; --fg:#1e293b; --muted:#64748b; --accent:#2563eb; --card:#FFFFFF; --border:#dbeafe; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--fg); }
        .main-content { margin-left:260px; min-height:100vh; }
        .topbar { background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; }
    </style>
</head>
<body>

    @include('pasien.filesidebarpasien')

    <div class="main-content">

        <header class="topbar px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 leading-tight">Detail Rekam Medis</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Hasil pemeriksaan dan catatan medis</p>
                </div>
                <div class="flex items-center gap-3 pl-3 pr-3 py-1 rounded-xl select-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="Profil" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 py-6">

            <!-- Tombol Kembali -->
            <a href="{{ route('pasien.riwayat') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-800 text-sm font-semibold mb-6 transition">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Riwayat Perawatan
            </a>

            <!-- Info Utama -->
            <div class="card shadow-sm mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <p class="text-blue-200 text-xs font-semibold uppercase tracking-wider mb-1">Tanggal Pemeriksaan</p>
                            <h3 class="text-2xl font-extrabold">
                                @if($rekamMedis->tanggal_kunjungan)
                                    {{ \Carbon\Carbon::parse($rekamMedis->tanggal_kunjungan)->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </h3>
                        </div>
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold">Selesai</span>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Dokter yang Menangani</p>
                        <p class="text-slate-800 font-bold text-lg">{{ $rekamMedis->dokter ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Keluhan Utama</p>
                        <p class="text-slate-800 font-semibold">{{ $rekamMedis->keluhan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Hasil Pemeriksaan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="card shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h4 class="font-bold text-slate-800">Diagnosa</h4>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $rekamMedis->diagnosa ?? '-' }}</p>
                </div>

                <div class="card shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                            <i class="fas fa-hand-holding-medical"></i>
                        </div>
                        <h4 class="font-bold text-slate-800">Tindakan</h4>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $rekamMedis->tindakan ?? '-' }}</p>
                </div>
            </div>

            <div class="card shadow-sm p-6 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <i class="fas fa-pills"></i>
                    </div>
                    <h4 class="font-bold text-slate-800">Resep Obat</h4>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                    {{ $rekamMedis->resep_obat ?? 'Tidak ada resep obat yang diberikan.' }}
                </p>
            </div>

        </main>
    </div>

</body>
</html>