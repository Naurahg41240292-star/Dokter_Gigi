<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pasien - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } } } }
        }
    </script>
    <style>
        body { background-color: #f8fafc; color: #1e293b; }
        .sidebar { width: 260px; height: 100vh; background: white; border-right: 1px solid #e2e8f0; position: fixed; left: 0; top: 0; z-index: 50; display: flex; flex-direction: column; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 24px; margin: 0 16px 8px 16px; border-radius: 12px; color: #64748b; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
        .nav-item:hover { background-color: #eff6ff; color: #2563eb; }
        .nav-item.active { background-color: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-item.active i { color: #2563eb; }
    </style>
</head>
<body class="flex">

    <!-- ========== SIDEBAR (UNIVERSAL) ========== -->
    <aside class="sidebar">
        <div class="px-8 pt-8 pb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-blue-500/20"><i class="fas fa-tooth text-white text-lg"></i></div>
            <div><h1 class="text-lg font-bold text-slate-800 leading-none">D'Smile</h1><p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mt-1">Admin Panel</p></div>
        </div>
        <nav class="mt-4 flex-1 overflow-y-auto">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"><i class="fas fa-home w-5 text-center"></i><span>Beranda</span></a>
            <a href="{{ route('petugas.input-data') }}" class="nav-item {{ request()->routeIs('petugas.input-data') ? 'active' : '' }}"><i class="fas fa-user-plus w-5 text-center"></i><span>Input Data Pasien</span></a>
            <a href="{{ route('petugas.data-pasien') }}" class="nav-item active"><i class="fas fa-users w-5 text-center"></i><span>Data Pasien</span></a>
            <a href="{{ route('petugas.jadwal-kontrol') }}" class="nav-item {{ request()->routeIs('petugas.jadwal-kontrol') ? 'active' : '' }}"><i class="fas fa-calendar-alt w-5 text-center"></i><span>Jadwal Kontrol</span></a>
            <a href="{{ route('petugas.manajemen-user') }}" class="nav-item {{ request()->routeIs('petugas.manajemen-user') ? 'active' : '' }}"><i class="fas fa-users-cog w-5 text-center"></i><span>Manajemen User</span></a>
            <div class="my-6 px-8 border-t border-gray-100"></div>
            <a href="{{ route('petugas.pengaturan') }}" class="nav-item {{ request()->routeIs('petugas.pengaturan') ? 'active' : '' }}"><i class="fas fa-cog w-5 text-center"></i><span>Pengaturan</span></a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf <button type="submit" class="nav-item w-full text-red-500 hover:text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar</span></button></form>
        </nav>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 ml-[260px] p-8">

        <header class="-mx-8 -mt-8 px-8 pt-6 pb-5 mb-8 bg-white border-b border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Data Pasien</h2>
                <p class="text-sm text-slate-500">Memperbarui data milik: <span class="font-bold text-primary-600">{{ $pasien->nama }}</span></p>
            </div>
            <a href="{{ route('petugas.data-pasien') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-2"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Pasien</a>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-5xl mx-auto">
            
            <form action="{{ route('petugas.update-pasien', $pasien->id) }}" method="POST">
                @csrf @method('PUT')
                
                <!-- Section 1: DATA PASIEN -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">DATA PASIEN</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label><input type="text" name="nama" value="{{ old('nama', $pasien->nama) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">NIK (No. KTP) <span class="text-red-500">*</span></label><input type="text" name="nik" value="{{ old('nik', $pasien->nik) }}" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-slate-600"></div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                            <div class="flex items-center gap-6 mt-2.5">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} class="w-4 h-4 text-primary-600"><span class="text-sm text-slate-700">Laki-laki</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }} class="w-4 h-4 text-primary-600"><span class="text-sm text-slate-700">Perempuan</span></label>
                            </div>
                        </div>
                        <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label><textarea name="alamat" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ old('alamat', $pasien->alamat) }}</textarea></div>
                    </div>
                </div>

                <!-- Section 2: DATA MEDIS AWAL -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">DATA MEDIS AWAL</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Golongan Darah</label>
                            <select name="golongan_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white text-slate-600">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ old('golongan_darah', $pasien->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('golongan_darah', $pasien->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('golongan_darah', $pasien->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('golongan_darah', $pasien->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Alergi</label><input type="text" name="riwayat_alergi" value="{{ old('riwayat_alergi', $pasien->riwayat_alergi) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                        <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Riwayat Penyakit</label><textarea name="riwayat_penyakit" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ old('riwayat_penyakit', $pasien->riwayat_penyakit) }}</textarea></div>
                    </div>
                </div>

                <!-- Section 3: KONTAK DARURAT -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">KONTAK DARURAT</h3>
                    <div class="w-16 h-1 bg-primary-600 rounded-full mb-6"></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kontak</label><input type="text" name="kontak_nama" value="{{ old('kontak_nama', $pasien->kontak_nama) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Hubungan</label>
                            <select name="kontak_hubungan" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white text-slate-600">
                                <option value="">Pilih Hubungan</option>
                                <option value="Orang Tua" {{ old('kontak_hubungan', $pasien->kontak_hubungan) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                <option value="Saudara" {{ old('kontak_hubungan', $pasien->kontak_hubungan) == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                                <option value="Suami/Istri" {{ old('kontak_hubungan', $pasien->kontak_hubungan) == 'Suami/Istri' ? 'selected' : '' }}>Suami/Istri</option>
                                <option value="Lainnya" {{ old('kontak_hubungan', $pasien->kontak_hubungan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label><input type="tel" name="kontak_telepon" value="{{ old('kontak_telepon', $pasien->kontak_telepon) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- Section 4: REKAM MEDIS (DIGABUNG) -->
                <!-- ========================================== -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">REKAM MEDIS & TINDAKAN</h3>
                    <div class="w-16 h-1 bg-blue-400 rounded-full mb-2"></div>
                    <p class="text-sm text-slate-500 mb-6">Update kondisi terkait pasien yang sedang menunggu atau dalam perawatan.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Diagnosa</label>
                            <textarea name="diagnosa" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" placeholder