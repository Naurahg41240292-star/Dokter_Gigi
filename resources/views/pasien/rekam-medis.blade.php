<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perawatan - D'Smile</title>
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
                    <h2 class="text-lg font-bold text-gray-800 leading-tight">Riwayat Perawatan Saya</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Catatan hasil pemeriksaan dan tindakan medis Anda</p>
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

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if($rekamMedis->count() > 0)
            <div class="card overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Dokter</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Diagnosa</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Tindakan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekamMedis as $rm)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                    @if($rm->tanggal_kunjungan)
                                        {{ \Carbon\Carbon::parse($rm->tanggal_kunjungan)->format('d M Y') }}
                                    @elseif($rm->tanggal_periksa)
                                        {{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $rm->dokter ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($rm->diagnosa, 30) ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($rm->tindakan, 30) ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('pasien.rekam-medis.show', $rm->id) }}" class="text-primary-600 hover:text-primary-800 text-sm font-semibold inline-flex items-center gap-1">
                                        <i class="fas fa-eye text-xs"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($rekamMedis->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-center">
                    {{ $rekamMedis->links() }}
                </div>
                @endif
            </div>

            @else
            <div class="card p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-file-medical text-3xl text-blue-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Riwayat Perawatan</h3>
                <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto leading-relaxed">Riwayat perawatan Anda akan muncul di sini setelah Anda selesai melakukan konsultasi atau perawatan di klinik.</p>
                <a href="{{ route('appointment.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-blue-200 transition-all cursor-pointer inline-flex items-center gap-2">
                    <i class="fas fa-calendar-plus"></i> Buat Janji Temu
                </a>
            </div>
            @endif

        </main>
    </div>

</body>
</html>