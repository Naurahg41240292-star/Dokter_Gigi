<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekam Medis - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8' } }
                }
            }
        }
    </script>
    <style>
        body { background-color: #eff6ff; color: #1e293b; font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .card { background: #FFFFFF; border: 1px solid #dbeafe; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    </style>
</head>
<body class="flex">

    <!-- SIDEBAR PETUGAS -->
    <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200 z-50 flex flex-col shadow-sm">
        <div class="px-8 pt-8 pb-6 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30"><i class="fas fa-tooth text-white text-lg"></i></div>
                <div><h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1><p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p></div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto mt-2 pb-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item"><i class="fas fa-home w-5 text-center"></i><span>Beranda</span></a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item"><i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span></a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item"><i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span></a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item active"><i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span></a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item"><i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span></a>
            <div class="my-4 mx-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item"><i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span></a>
        </nav>
        <div class="flex-shrink-0 border-t border-slate-100 p-4 mt-auto">
            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50 m-0"><i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span></button></form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 ml-[260px] min-h-screen">
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between gap-4 sticky top-0 z-40">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Rekam Medis</h2>
                <p class="text-sm text-slate-500">Hasil pemeriksaan dari Dokter</p>
            </div>
            <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-primary-600 font-medium">{{ auth()->user()->role }}</p>
                </div>
                <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
            </div>
        </header>

        <div class="p-8">
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-800 text-sm font-semibold mb-6 transition">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Jadwal Kontrol
            </a>

            <!-- Info Appointment -->
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-check text-primary-600"></i> Informasi Kunjungan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-slate-50 p-3 rounded-lg">
                        <span class="text-slate-500 text-xs font-semibold block mb-1">Nama Pasien</span>
                        <p class="font-bold text-slate-800">{{ $appointment->nama_lengkap }}</p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg">
                        <span class="text-slate-500 text-xs font-semibold block mb-1">Jadwal</span>
                        <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($appointment->tanggal)->format('d F Y') }} | {{ $appointment->waktu }}</p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg">
                        <span class="text-slate-500 text-xs font-semibold block mb-1">Jenis Perawatan</span>
                        <p class="font-bold text-slate-800">{{ $appointment->jenis_perawatan }}</p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg md:col-span-3">
                        <span class="text-slate-500 text-xs font-semibold block mb-1">Keluhan Utama</span>
                        <p class="font-semibold text-slate-700">{{ $appointment->keluhan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($rekamMedis)
            <!-- Hasil Rekam Medis dari Dokter -->
            <div class="card border-teal-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-5 text-white flex items-center gap-3">
                    <i class="fas fa-file-medical-alt text-xl"></i>
                    <div>
                        <h3 class="font-bold text-lg leading-tight">Hasil Pemeriksaan Dokter</h3>
                        <p class="text-teal-100 text-xs mt-0.5">Ditangani oleh: {{ $rekamMedis->dokter ?? '-' }}</p>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2"><i class="fas fa-stethoscope text-purple-500"></i> Diagnosa</h4>
                        <div class="bg-purple-50 border border-purple-100 p-4 rounded-xl text-sm text-slate-800 leading-relaxed">
                            {{ $rekamMedis->diagnosa ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2"><i class="fas fa-hand-holding-medical text-blue-500"></i> Tindakan</h4>
                        <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-sm text-slate-800 leading-relaxed">
                            {{ $rekamMedis->tindakan ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2"><i class="fas fa-pills text-amber-500"></i> Resep Obat</h4>
                        <div class="bg-amber-50 border border-amber-100 p-4 rounded-xl text-sm text-slate-800 leading-relaxed">
                            {{ $rekamMedis->resep_obat ?? 'Tidak ada resep obat yang diberikan.' }}
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-4 rounded-xl flex items-center gap-3">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="font-medium">Belum ada rekam medis yang diisi oleh Dokter untuk appointment ini.</span>
            </div>
            @endif

        </div>
    </main>
    @include('petugas.partials.notif-script')
</body>
</html>
</body>
</html>