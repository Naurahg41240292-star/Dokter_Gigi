<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekam Medis - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-item.active i { color: #2563eb; }
    </style>
</head>
<body class="flex">

    <!-- ========== SIDEBAR PETUGAS (UTUH) ========== -->
    <aside class="sidebar">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-tooth text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1>
                <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p>
            </div>
        </div>
        <nav class="mt-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i><span>Beranda</span>
            </a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}">
                <i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span>
            </a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item {{ request()->routeIs('petugas.data-pasien') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span>
            </a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item {{ request()->routeIs('petugas.jadwal-kontrol') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span>
            </a>
            <a href="{{ route('petugas.rekam-medis') }}" class="nav-item {{ request()->routeIs('petugas.rekam-medis') ? 'active' : '' }}">
                <i class="fas fa-file-medical w-5 text-center"></i><span>Rekam Medis</span>
            </a>
            <a href="{{ route('petugas.keuangan') }}" class="nav-item {{ request()->routeIs('petugas.keuangan') ? 'active' : '' }}">
                <i class="fas fa-wallet w-5 text-center"></i><span>Keuangan</span>
            </a>
            <div class="my-6 px-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mx-4 mt-2">
                @csrf
                <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] p-6 lg:p-8">
        
        <!-- Header -->
        <header class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 px-6 lg:px-8 pt-6 pb-5 mb-8 bg-white border-b border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Rekam Medis</h2>
                <p class="text-sm text-slate-500">Memperbarui catatan medis pasien.</p>
            </div>
            <a href="{{ route('petugas.rekam-medis') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Rekam Medis
            </a>
        </header>

        <!-- FORM CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-5xl mx-auto">
            
            <!-- PENTING: Form menggunakan method PUT untuk update di Laravel -->
            <form action="{{ route('petugas.update', $pasien->id) }}" method="POST">
            @csrf
            @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pasien <span class="text-red-500">*</span></label>
                        <select name="pasien_id" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                            <option value="">Pilih Pasien</option>
                            @foreach ($pasiens as $pasien)
                                <!-- Menandai pasien yang sedang diedit sebagai 'selected' -->
                                <option value="{{ $pasien->id }}" {{ old('pasien_id', $rekamMedis->pasien_id) == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama }} (NIK: {{ $pasien->nik }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Dokter Penanggung Jawab <span class="text-red-500">*</span></label>
                        <input type="text" name="dokter" value="{{ old('dokter', $rekamMedis->dokter) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $rekamMedis->tanggal_kunjungan) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                            <option value="Dalam Perawatan" {{ old('status', $rekamMedis->status) == 'Dalam Perawatan' ? 'selected' : '' }}>Dalam Perawatan</option>
                            <option value="Selesai" {{ old('status', $rekamMedis->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keluhan</label>
                        <textarea name="keluhan" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Diagnosa</label>
                        <input type="text" name="diagnosa" value="{{ old('diagnosa', $rekamMedis->diagnosa) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tindakan / Perawatan</label>
                        <input type="text" name="tindakan" value="{{ old('tindakan', $rekamMedis->tindakan) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Resep Obat</label>
                        <input type="text" name="resep_obat" value="{{ old('resep_obat', $rekamMedis->resep_obat) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('petugas.rekam-medis') }}" class="px-6 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </main>
    @include('petugas.partials.notif-script')
</body>
</html>
</body>
</html>