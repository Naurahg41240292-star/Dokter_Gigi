<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment & Riwayat - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50:'#eff6ff', 100:'#dbeafe', 200:'#bfdbfe', 300:'#93c5fd', 400:'#60a5fa', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8', 800:'#1e40af' }
                    }
                }
            }
        }
    </script>

    <style>
        :root { --bg:#f0f5fb; --fg:#1e293b; --muted:#64748b; --accent:#2563eb; --card:#FFFFFF; --border:#e2e8f0; --sidebar:#FFFFFF; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--fg); overflow-x:hidden; }
        .main-content { margin-left:260px; min-height:100vh; transition:margin-left 0.3s ease; }
        .main-content header { background:rgba(255,255,255,0.92); backdrop-filter:blur(16px); border-bottom:1px solid var(--border); padding:14px 28px; position:sticky; top:0; z-index:40; }
        .main-content main { padding:28px 32px; background:var(--bg); }
        ::-webkit-scrollbar { width:5px; } ::-webkit-scrollbar-track { background:transparent; } ::-webkit-scrollbar-thumb { background:#c7d2e0; border-radius:3px; }
        .sidebar { width:260px; min-height:100vh; background:var(--sidebar); border-right:1px solid var(--border); position:fixed; left:0; top:0; z-index:50; transition:transform 0.3s cubic-bezier(0.4,0,0.2,1); box-shadow:4px 0 24px rgba(0,0,0,0.03); overflow-y:auto; }
        .sidebar-link { display:flex; align-items:center; gap:12px; padding:11px 20px; border-radius:10px; color:var(--muted); font-size:14px; font-weight:500; transition:all 0.2s ease; cursor:pointer; position:relative; margin:2px 12px; text-decoration:none; }
        .sidebar-link:hover { color:var(--accent); background:#eff6ff; }
        .sidebar-link.active { color:var(--accent); background:#eff6ff; font-weight:600; }
        .sidebar-link.active::before { content:''; position:absolute; left:-12px; top:50%; transform:translateY(-50%); width:4px; height:22px; background:var(--accent); border-radius:0 4px 4px 0; }
        .sidebar-link i { width:20px; text-align:center; font-size:15px; }
        .sidebar-title { color:#94a3b8; font-size:10px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; padding:20px 20px 8px 20px; margin:0 12px; }
        .badge-confirmed { background-color:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
        .badge-pending { background-color:#fef9c3; color:#854d0e; border:1px solid #fde047; }
        .badge-completed { background-color:#e0e7ff; color:#3730a3; border:1px solid #c7d2fe; }
        .badge-cancelled { background-color:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
        .list-item-hover { transition:all 0.25s ease; }
        .list-item-hover:hover { transform:translateY(-2px); box-shadow:0 12px 28px -6px rgba(37,99,235,0.08),0 4px 10px -4px rgba(0,0,0,0.04); border-color:#bfdbfe; }
        .form-input { width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:14px; font-family:'Plus Jakarta Sans',sans-serif; color:var(--fg); background:#fff; transition:all 0.2s ease; outline:none; }
        .form-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
        .form-input::placeholder { color:#a0aec0; }
        .form-label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:6px; }
        .form-label .required { color:#ef4444; margin-left:2px; }
        select.form-input { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
        textarea.form-input { resize:vertical; min-height:80px; }
        .section-card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; overflow:hidden; transition:all 0.2s ease; }
        .section-card:hover { box-shadow:0 4px 16px rgba(37,99,235,0.05); }
        .section-header { display:flex; align-items:center; gap:12px; padding:18px 24px; background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%); border-bottom:1px solid #e2e8f0; }
        .section-header .icon-box { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
        .section-body { padding:24px; }
        .tab-btn { padding:9px 20px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s ease; border:1.5px solid transparent; white-space:nowrap; }
        .tab-btn.active { background:var(--accent); color:#fff; box-shadow:0 4px 12px rgba(37,99,235,0.25); }
        .tab-btn:not(.active) { background:#fff; color:#64748b; border-color:#e2e8f0; }
        .tab-btn:not(.active):hover { background:#f8fafc; color:var(--accent); border-color:#bfdbfe; }
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
        .animate-fade-up { animation:fadeSlideUp 0.4s ease forwards; }
        .animate-fade-up-delay-1 { animation-delay:0.08s; opacity:0; }
        .animate-fade-up-delay-2 { animation-delay:0.16s; opacity:0; }
        .animate-fade-up-delay-3 { animation-delay:0.24s; opacity:0; }
        .mobile-overlay { display:none; position:fixed; inset:0; background:rgba(30,41,59,0.4); z-index:45; backdrop-filter:blur(2px); }
        .mobile-overlay.show { display:block; }
        @media(max-width:1024px) { .sidebar{transform:translateX(-100%);} .sidebar.open{transform:translateX(0);} .main-content{margin-left:0;} .main-content main{padding:20px 16px;} }
        @media(max-width:640px) { .section-body{padding:16px;} .section-header{padding:14px 16px;} }
    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
        <div class="p-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-md shadow-blue-200">
                    <i class="fas fa-tooth text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-800 tracking-tight">D'Smile</h1>
                    <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Dental Clinic</p>
                </div>
            </div>
        </div>
        <nav class="py-4">
            <p class="sidebar-title">Menu Utama</p>
            <a href="#" class="sidebar-link" id="nav-dashboard" onclick="switchView('dashboard')">
                <i class="fas fa-th-large"></i> Beranda
            </a>
            <a href="#" class="sidebar-link active" id="nav-appointment" onclick="switchView('appointment')">
                <i class="fas fa-calendar-check"></i> Appointment
            </a>
            <a href="#" class="sidebar-link" id="nav-history" onclick="switchView('history')">
                <i class="fas fa-file-medical"></i> Riwayat Perawatan
            </a>
            <p class="sidebar-title mt-2">Lainnya</p>
            <a href="#" class="sidebar-link">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
            <!-- Logout Form -->
            <a href="#" class="sidebar-link text-red-500" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </nav>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">

        <!-- HEADER -->
        <header class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-sm"></i>
                </button>
                <div>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Pasien</p>
                    <h2 class="text-lg md:text-xl font-extrabold text-slate-800" id="page-title">Appointment Saya</h2>
                </div>
            </div>
            <div class="flex items-center gap-3 md:gap-4">
                <div class="flex items-center gap-2 md:gap-3 pl-3 md:pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold border-2 border-white shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main>

            <!-- Flash Message Sukses dari Laravel -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 font-semibold text-sm animate-fade-up">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- ============================================ -->
            <!-- VIEW: APPOINTMENT LIST                       -->
            <!-- ============================================ -->
            <section id="view-appointment" class="space-y-6 animate-fade-up">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex gap-2 overflow-x-auto pb-1">
                        <button class="tab-btn active" onclick="filterAppointments(this, 'semua')">Semua</button>
                        <button class="tab-btn" onclick="filterAppointments(this, 'mendatang')">Mendatang</button>
                        <button class="tab-btn" onclick="filterAppointments(this, 'selesai')">Selesai</button>
                    </div>
                    <button onclick="switchView('form-appointment')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 hover:shadow-lg hover:shadow-blue-200 transition-all duration-200 active:scale-[0.97]">
                        <i class="fas fa-plus text-xs"></i> Buat Appointment
                    </button>
                </div>

                <div class="space-y-4" id="appointment-list">
                    
                    @forelse($appointments as $item)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 list-item-hover 
                        {{ $item->status == 'Dibatalkan' ? 'opacity-60' : '' }} 
                        {{ $item->status == 'Selesai' ? 'opacity-75' : '' }}"
                        data-status="{{ $item->status == 'Terjadwal' || $item->status == 'Menunggu Konfirmasi' ? 'mendatang' : ($item->status == 'Selesai' ? 'selesai' : 'dibatalkan') }}">
                        
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="@if($item->status=='Terjadwal') bg-primary-50 text-primary-700 border-primary-100 @elseif($item->status=='Menunggu Konfirmasi') bg-amber-50 text-amber-700 border-amber-100 @elseif($item->status=='Dibatalkan') bg-red-50 text-red-400 border-red-100 @else bg-slate-100 text-slate-500 border-slate-200 @endif rounded-xl px-4 py-3 text-center min-w-[72px] border flex-shrink-0">
                                <p class="text-[11px] font-bold uppercase tracking-wide">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</p>
                                <p class="text-2xl font-extrabold leading-none mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</p>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-800 text-[17px] truncate @if($item->status=='Dibatalkan') line-through text-slate-500 @endif">{{ $item->jenis_perawatan }}</h4>
                                <p class="text-slate-500 text-sm flex items-center gap-2 mt-1">
                                    <i class="fas fa-user-md text-xs text-primary-400"></i> {{ $item->dokter }}
                                </p>
                                <p class="text-slate-400 text-xs mt-1 flex items-center gap-2">
                                    <i class="far fa-clock text-[10px]"></i> {{ $item->waktu }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end flex-shrink-0">
                            @if($item->status == 'Terjadwal')
                                <span class="badge-confirmed px-3.5 py-1.5 rounded-full text-xs font-bold">Terjadwal</span>
                            @elseif($item->status == 'Menunggu Konfirmasi')
                                <span class="badge-pending px-3.5 py-1.5 rounded-full text-xs font-bold">Menunggu Konfirmasi</span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge-completed px-3.5 py-1.5 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="badge-cancelled px-3.5 py-1.5 rounded-full text-xs font-bold">Dibatalkan</span>
                            @endif

                            @if(in_array($item->status, ['Terjadwal', 'Menunggu Konfirmasi']))
                            <form action="{{ route('appointment.cancel', $item->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-red-50 hover:text-red-500 text-slate-400 transition flex items-center justify-center border border-slate-200 hover:border-red-200" title="Batalkan" onclick="return confirm('Yakin ingin membatalkan appointment ini?')">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-slate-200 text-center">
                        <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                        <p class="text-slate-500 font-semibold">Belum ada appointment.</p>
                        <p class="text-slate-400 text-sm">Silakan buat appointment baru.</p>
                    </div>
                    @endforelse

                </div>
            </section>

            <!-- ============================================ -->
            <!-- VIEW: FORM APPOINTMENT                       -->
            <!-- ============================================ -->
            <section id="view-form-appointment" class="hidden space-y-6 animate-fade-up">

                <div class="flex items-center gap-3">
                    <button onclick="switchView('appointment')" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </button>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Kembali ke daftar</p>
                        <h3 class="text-lg font-extrabold text-slate-800">Buat Appointment Baru</h3>
                    </div>
                </div>

                <!-- FORM DITAMBAHKAN ACTION & METHOD POST -->
                <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST">
                    @csrf

                    <!-- ===== SECTION 1: DATA PASIEN ===== -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-1">
                        <div class="section-header">
                            <div class="icon-box bg-primary-100 text-primary-600"><i class="fas fa-user"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-[15px]">Data Pasien</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Informasi lengkap pasien</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div>
                                    <label class="form-label">NIK / No. KTP <span class="required">*</span></label>
                                    <input type="text" name="nik" class="form-input" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
                                </div>
                                <div>
                                    <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                                    <input type="date" name="tgl_lahir" class="form-input" value="{{ old('tgl_lahir') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                    <select name="jenis_kelamin" class="form-input" required>
                                        <option value="" disabled @if(!old('jenis_kelamin')) selected @endif>Pilih jenis kelamin</option>
                                        <option value="Laki-laki" @if(old('jenis_kelamin')=='Laki-laki') selected @endif>Laki-laki</option>
                                        <option value="Perempuan" @if(old('jenis_kelamin')=='Perempuan') selected @endif>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">No. Telepon <span class="required">*</span></label>
                                    <input type="tel" name="no_telepon" class="form-input" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="contoh@email.com">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                                    <textarea name="alamat" class="form-input" placeholder="Masukkan alamat lengkap..." rows="2" required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 2: DATA MEDIS AWAL ===== -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-2">
                        <div class="section-header">
                            <div class="icon-box bg-emerald-100 text-emerald-600"><i class="fas fa-heartbeat"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-[15px]">Data Medis Awal</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Riwayat kesehatan & kondisi saat ini</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Golongan Darah</label>
                                    <select name="golongan_darah" class="form-input">
                                        <option value="" disabled selected>Pilih golongan darah</option>
                                        <option value="A" @if(old('golongan_darah')=='A') selected @endif>A</option>
                                        <option value="B" @if(old('golongan_darah')=='B') selected @endif>B</option>
                                        <option value="AB" @if(old('golongan_darah')=='AB') selected @endif>AB</option>
                                        <option value="O" @if(old('golongan_darah')=='O') selected @endif>O</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Tekanan Darah</label>
                                    <input type="text" name="tekanan_darah" class="form-input" value="{{ old('tekanan_darah') }}" placeholder="Contoh: 120/80 mmHg">
                                </div>
                                <div>
                                    <label class="form-label">Alergi Obat</label>
                                    <input type="text" name="alergi_obat" class="form-input" value="{{ old('alergi_obat') }}" placeholder="Tulis alergi obat, jika ada">
                                </div>
                                <div>
                                    <label class="form-label">Alergi Makanan</label>
                                    <input type="text" name="alergi_makanan" class="form-input" value="{{ old('alergi_makanan') }}" placeholder="Tulis alergi makanan, jika ada">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Riwayat Penyakit</label>
                                    <textarea name="riwayat_penyakit" class="form-input" placeholder="Diabetes, hipertensi, penyakit jantung, dll..." rows="2">{{ old('riwayat_penyakit') }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Obat yang Dikonsumsi Saat Ini</label>
                                    <textarea name="obat_dikonsumsi" class="form-input" placeholder="Nama obat & dosis yang sedang dikonsumsi..." rows="2">{{ old('obat_dikonsumsi') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 3: KONTAK DARURAT ===== -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-3">
                        <div class="section-header">
                            <div class="icon-box bg-amber-100 text-amber-600"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-[15px]">Kontak Darurat</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Kontak yang bisa dihubungi saat darurat</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Nama Kontak Darurat <span class="required">*</span></label>
                                    <input type="text" name="kontak_darurat_nama" class="form-input" value="{{ old('kontak_darurat_nama') }}" placeholder="Nama lengkap" required>
                                </div>
                                <div>
                                    <label class="form-label">Hubungan <span class="required">*</span></label>
                                    <select name="kontak_darurat_hubungan" class="form-input" required>
                                        <option value="" disabled @if(!old('kontak_darurat_hubungan')) selected @endif>Pilih hubungan</option>
                                        <option value="Orang Tua" @if(old('kontak_darurat_hubungan')=='Orang Tua') selected @endif>Orang Tua</option>
                                        <option value="Suami / Istri" @if(old('kontak_darurat_hubungan')=='Suami / Istri') selected @endif>Suami / Istri</option>
                                        <option value="Saudara" @if(old('kontak_darurat_hubungan')=='Saudara') selected @endif>Saudara</option>
                                        <option value="Anak" @if(old('kontak_darurat_hubungan')=='Anak') selected @endif>Anak</option>
                                        <option value="Lainnya" @if(old('kontak_darurat_hubungan')=='Lainnya') selected @endif>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">No. Telepon Darurat <span class="required">*</span></label>
                                    <input type="tel" name="kontak_darurat_telepon" class="form-input" value="{{ old('kontak_darurat_telepon') }}" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="form-label">Alamat Kontak Darurat</label>
                                    <input type="text" name="kontak_darurat_alamat" class="form-input" value="{{ old('kontak_darurat_alamat') }}" placeholder="Alamat lengkap (opsional)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 4: DETAIL APPOINTMENT ===== -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-3">
                        <div class="section-header">
                            <div class="icon-box bg-violet-100 text-violet-600"><i class="fas fa-calendar-plus"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-[15px]">Detail Appointment</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Pilih jadwal & dokter yang diinginkan</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Tanggal Appointment <span class="required">*</span></label>
                                    <input type="date" name="tanggal" class="form-input" id="appointmentDate" value="{{ old('tanggal') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Waktu yang Diinginkan <span class="required">*</span></label>
                                    <select name="waktu" class="form-input" required>
                                        <option value="" disabled @if(!old('waktu')) selected @endif>Pilih waktu</option>
                                        <option value="08:00 - 08:45" @if(old('waktu')=='08:00 - 08:45') selected @endif>08:00 - 08:45</option>
                                        <option value="09:00 - 09:45" @if(old('waktu')=='09:00 - 09:45') selected @endif>09:00 - 09:45</option>
                                        <option value="10:00 - 10:45" @if(old('waktu')=='10:00 - 10:45') selected @endif>10:00 - 10:45</option>
                                        <option value="11:00 - 11:45" @if(old('waktu')=='11:00 - 11:45') selected @endif>11:00 - 11:45</option>
                                        <option value="13:00 - 13:45" @if(old('waktu')=='13:00 - 13:45') selected @endif>13:00 - 13:45</option>
                                        <option value="14:00 - 14:45" @if(old('waktu')=='14:00 - 14:45') selected @endif>14:00 - 14:45</option>
                                        <option value="15:00 - 15:45" @if(old('waktu')=='15:00 - 15:45') selected @endif>15:00 - 15:45</option>
                                        <option value="16:00 - 16:45" @if(old('waktu')=='16:00 - 16:45') selected @endif>16:00 - 16:45</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Dokter <span class="required">*</span></label>
                                    <select name="dokter" class="form-input" required>
                                        <option value="" disabled @if(!old('dokter')) selected @endif>Pilih dokter</option>
                                        <option value="drg. Andi Wijoya" @if(old('dokter')=='drg. Andi Wijoya') selected @endif>drg. Andi Wijoya (Umum)</option>
                                        <option value="drg. Rina Sari" @if(old('dokter')=='drg. Rina Sari') selected @endif>drg. Rina Sari (Ortodonti)</option>
                                        <option value="drg. Budi Prasetyo" @if(old('dokter')=='drg. Budi Prasetyo') selected @endif>drg. Budi Prasetyo (Bedah)</option>
                                        <option value="drg. Siti Aminah" @if(old('dokter')=='drg. Siti Aminah') selected @endif>drg. Siti Aminah (Pedodonti)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Jenis Perawatan <span class="required">*</span></label>
                                    <select name="jenis_perawatan" class="form-input" required>
                                        <option value="" disabled @if(!old('jenis_perawatan')) selected @endif>Pilih perawatan</option>
                                        <option value="Scaling Gigi" @if(old('jenis_perawatan')=='Scaling Gigi') selected @endif>Scaling Gigi</option>
                                        <option value="Penambalan Gigi" @if(old('jenis_perawatan')=='Penambalan Gigi') selected @endif>Penambalan Gigi</option>
                                        <option value="Pencabutan Gigi" @if(old('jenis_perawatan')=='Pencabutan Gigi') selected @endif>Pencabutan Gigi</option>
                                        <option value="Konsultasi Ortodonti" @if(old('jenis_perawatan')=='Konsultasi Ortodonti') selected @endif>Konsultasi Ortodonti</option>
                                        <option value="Perawatan Saluran Akar" @if(old('jenis_perawatan')=='Perawatan Saluran Akar') selected @endif>Perawatan Saluran Akar</option>
                                        <option value="Pemasangan Crown / Veneer" @if(old('jenis_perawatan')=='Pemasangan Crown / Veneer') selected @endif>Pemasangan Crown / Veneer</option>
                                        <option value="Konsultasi Umum" @if(old('jenis_perawatan')=='Konsultasi Umum') selected @endif>Konsultasi Umum</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Keluhan / Catatan Tambahan</label>
                                    <textarea name="keluhan" class="form-input" placeholder="Jelaskan keluhan atau catatan khusus yang ingin disampaikan ke dokter..." rows="3">{{ old('keluhan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== BUTTONS ===== -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="switchView('appointment')" class="w-full sm:w-auto px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-all">Batal</button>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-200 transition-all active:scale-[0.97] flex items-center justify-center gap-2">
                            <i class="fas fa-check text-xs"></i> Simpan Appointment
                        </button>
                    </div>

                </form>
            </section>

            <!-- ============================================ -->
            <!-- VIEW: HISTORY                                -->
            <!-- ============================================ -->
            <section id="view-history" class="hidden space-y-6 animate-fade-up">
                <!-- History section tetap statis dulu karena fokus ke Appointment -->
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-lg">Daftar Riwayat Medis</h3>
                    <button class="text-primary-600 text-xs font-bold border border-primary-200 bg-primary-50 px-4 py-2 rounded-xl hover:bg-primary-100 transition flex items-center gap-1.5">
                        <i class="fas fa-download text-[10px]"></i> Download PDF
                    </button>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-10 text-center text-slate-400">
                    <p>Fitur Riwayat Perawatan segera hadir.</p>
                </div>
            </section>

        </main>
    </div>

    <script>
        // Set min date hari ini
        const dateInput = document.getElementById('appointmentDate');
        if(dateInput){
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        }

        function switchView(viewName) {
            document.getElementById('view-appointment').classList.add('hidden');
            document.getElementById('view-form-appointment').classList.add('hidden');
            document.getElementById('view-history').classList.add('hidden');

            const navIds = ['nav-appointment', 'nav-history', 'nav-dashboard'];
            navIds.forEach(id => { const el = document.getElementById(id); if(el) el.classList.remove('active'); });

            if (viewName === 'appointment') {
                document.getElementById('view-appointment').classList.remove('hidden');
                document.getElementById('nav-appointment').classList.add('active');
                document.getElementById('page-title').innerText = 'Appointment Saya';
            }
            else if (viewName === 'form-appointment') {
                document.getElementById('view-form-appointment').classList.remove('hidden');
                document.getElementById('nav-appointment').classList.add('active');
                document.getElementById('page-title').innerText = 'Buat Appointment';
            }
            else if (viewName === 'history') {
                document.getElementById('view-history').classList.remove('hidden');
                document.getElementById('nav-history').classList.add('active');
                document.getElementById('page-title').innerText = 'Riwayat Perawatan';
            }
            else if (viewName === 'dashboard') {
                document.getElementById('view-appointment').classList.remove('hidden');
                document.getElementById('nav-dashboard').classList.add('active');
                document.getElementById('page-title').innerText = 'Beranda';
            }

            if (window.innerWidth <= 1024) { closeSidebar(); }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function filterAppointments(btnEl, filter) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btnEl.classList.add('active');
            const cards = document.querySelectorAll('#appointment-list > div');
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (filter === 'semua') { card.style.display = ''; } 
                else if (filter === 'mendatang') { card.style.display = (status === 'mendatang') ? '' : 'none'; } 
                else if (filter === 'selesai') { card.style.display = (status === 'selesai' || status === 'dibatalkan') ? '' : 'none'; }
            });
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('mobileOverlay').classList.toggle('show');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('mobileOverlay').classList.remove('show');
        }
    </script>
</body>
</html>