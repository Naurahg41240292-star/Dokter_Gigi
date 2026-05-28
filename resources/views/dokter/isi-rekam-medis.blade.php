<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Rekam Medis - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        body { background: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all .2s; cursor: pointer; text-decoration: none; }
        .nav-item:hover { background: #eff6ff; color: #2563eb; }
        .nav-item.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
    </style>
</head>
<body class="flex">

    <!-- SIDEBAR DOKTER -->
    <aside class="sidebar flex flex-col shadow-sm">
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
            <a href="{{ route('dokter.pengaturan') }}" class="nav-item">
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

        <!-- TOPBAR -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200 px-6 lg:px-8 py-4 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wide mb-1">Rekam Medis</p>
                    <h2 class="text-2xl font-extrabold text-slate-800">Form Pemeriksaan Pasien</h2>
                </div>
                <div class="flex items-center gap-3 pl-3 pr-3 py-1 rounded-xl select-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-400">{{ auth()->user()->spesialisasi ?? 'Dokter Gigi' }}</p>
                    </div>
                    <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff' }}" class="w-9 h-9 rounded-lg object-cover border-2 border-primary-100">
                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="px-6 lg:px-8 pb-12">

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Info Pasien Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-primary-600">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Data Pasien</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <span class="text-slate-400 text-xs font-semibold block mb-1">Nama Lengkap</span>
                        <p class="font-bold text-slate-700">{{ $appointment->nama_lengkap }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <span class="text-slate-400 text-xs font-semibold block mb-1">Jadwal Periksa</span>
                        <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($appointment->tanggal)->format('d F Y') }} | {{ $appointment->waktu }} WIB</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <span class="text-slate-400 text-xs font-semibold block mb-1">Jenis Perawatan</span>
                        <p class="font-bold text-slate-700">{{ $appointment->jenis_perawatan }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 md:col-span-3">
                        <span class="text-slate-400 text-xs font-semibold block mb-1">Keluhan Utama</span>
                        <p class="font-bold text-slate-700">{{ $appointment->keluhan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Rekam Medis Card -->
            <form action="{{ route('dokter.rekam-medis.simpan', $appointment->id) }}" method="POST">
                @csrf
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Hasil Pemeriksaan</h3>
                    </div>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Diagnosa <span class="text-red-500">*</span></label>
                            <textarea name="diagnosa" rows="3" required class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition" placeholder="Masukkan diagnosa hasil pemeriksaan">{{ old('diagnosa', $rekamMedis->diagnosa ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tindakan Medis <span class="text-red-500">*</span></label>
                            <textarea name="tindakan" rows="3" required class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition" placeholder="Tindakan yang dilakukan selama pemeriksaan">{{ old('tindakan', $rekamMedis->tindakan ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Resep Obat</label>
                                <textarea name="resep_obat" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition" placeholder="Obat yang diresepkan (opsional)">{{ old('resep_obat', $rekamMedis->resep_obat ?? '') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Tambahan</label>
                                <textarea name="catatan" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition" placeholder="Catatan khusus untuk pasien (opsional)">{{ old('catatan', $rekamMedis->catatan ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('dokter.dashboard') }}" class="px-6 py-3 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition inline-flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i> Kembali
                    </a>
                    <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 shadow-lg shadow-green-500/20 transition flex items-center gap-2">
                        <i class="fas fa-check-circle text-xs"></i> Selesai Periksa
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>