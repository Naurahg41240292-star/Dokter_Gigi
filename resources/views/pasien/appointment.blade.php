<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment & Riwayat - D'Smile Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tambahkan Library QR Code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                        accent: '#2563eb', surface: '#eff6ff', sidebar: '#FFFFFF',
                    }
                }
            }
        }
    </script>

    <style>
        :root { --bg: #eff6ff; --fg: #1e293b; --muted: #64748b; --accent: #2563eb; --card: #FFFFFF; --border: #dbeafe; --sidebar: #FFFFFF; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--fg); overflow-x: hidden; }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: transparent; } ::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 3px; }
        
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar); border-right: 1px solid var(--border); position: fixed; left: 0; top: 0; z-index: 50; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 4px 0 24px rgba(59, 130, 246, 0.03); }
        .main-content { margin-left: 260px; min-height: 100vh; padding: 0; }
        .topbar { background: rgba(255,255,255,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }
        
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease; cursor: pointer; }
        .card:hover { box-shadow: 0 12px 40px rgba(37, 99, 235, 0.08); border-color: #bfdbfe; transform: translateY(-2px); }
        
        .notif-dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--border); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s ease; z-index: 60; width: 340px; border-radius: 16px; box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1); }
        .notif-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .online-dot { width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: 2px solid #fff; position: absolute; bottom: 0; right: 0; }

        .badge-confirmed { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-pending { background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
        .badge-completed { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        
        .form-input { width:100%; padding:10px 14px; border:1.5px solid var(--border); border-radius:10px; font-size:14px; font-family:'Plus Jakarta Sans',sans-serif; color:var(--fg); background:#fff; transition:all 0.2s ease; outline:none; }
        .form-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
        .form-input::placeholder { color:#a0aec0; }
        .form-label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:6px; }
        .form-label .required { color:#ef4444; margin-left:2px; }
        select.form-input { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
        textarea.form-input { resize:vertical; min-height:80px; }
        
        .section-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; transition:all 0.2s ease; }
        .section-header { display:flex; align-items:center; gap:12px; padding:18px 24px; background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%); border-bottom:1px solid var(--border); }
        .section-header .icon-box { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
        .section-body { padding:24px; }
        
        .tab-btn { padding:9px 20px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s ease; border:1.5px solid transparent; white-space:nowrap; }
        .tab-btn.active { background:var(--accent); color:#fff; box-shadow:0 4px 12px rgba(37,99,235,0.25); }
        .tab-btn:not(.active) { background:#fff; color:#64748b; border-color:var(--border); }
        .tab-btn:not(.active):hover { background:#eff6ff; color:var(--accent); border-color:#bfdbfe; }
        
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
        .animate-fade-up { animation:fadeSlideUp 0.4s ease forwards; }
        .animate-fade-up-delay-1 { animation-delay:0.08s; opacity:0; }
        .animate-fade-up-delay-2 { animation-delay:0.16s; opacity:0; }
        .animate-fade-up-delay-3 { animation-delay:0.24s; opacity:0; }
        
        .mobile-overlay { display:none; position:fixed; inset:0; background:rgba(30,41,59,0.4); z-index:45; backdrop-filter:blur(2px); }
        .mobile-overlay.show { display:block; }
        @media(max-width:1024px) { .sidebar{transform:translateX(-100%);} .sidebar.open{transform:translateX(0);} .main-content{margin-left:0;} }

        .modal-overlay { position: fixed; inset: 0; background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(4px); z-index: 100; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-content { background: #fff; border-radius: 20px; max-width: 600px; width: 100%; max-height: 90vh; position: relative; animation: fadeSlideUp 0.3s ease; display: flex; flex-direction: column; }
        .modal-body-scroll::-webkit-scrollbar { width: 6px; } .modal-body-scroll::-webkit-scrollbar-track { background: #f1f5f9; } .modal-body-scroll::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
        
        /* CSS Khusus E-Ticket */
        .ticket-tear { border-top: 2px dashed #e2e8f0; position: relative; margin-top: 1.5rem; padding-top: 1.5rem; }
        .ticket-tear::before, .ticket-tear::after { content: ''; position: absolute; top: -12px; width: 24px; height: 24px; background: rgba(30, 41, 59, 0.6); border-radius: 50%; }
        .ticket-tear::before { left: -28px; }
        .ticket-tear::after { right: -28px; }
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
                        <h2 class="text-lg font-bold text-gray-800 leading-tight" id="page-title">Appointment Saya</h2>
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
                    <!-- Notifikasi -->
                    <div class="relative">
                        <button class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition-colors relative cursor-pointer" onclick="toggleNotif()" id="notifBtn">
                            <i class="fas fa-bell text-[15px]"></i>
                        </button>
                        <div class="notif-dropdown" id="notifDropdown">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900">Notifikasi</h4>
                                    <button class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">Tandai semua dibaca</button>
                                </div>
                            </div>
                            <div class="p-6 text-center text-sm text-gray-400">Belum ada notifikasi</div>
                        </div>
                    </div>

                    <!-- Profil -->
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

        <main class="px-6 lg:px-8 py-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 font-semibold text-sm animate-fade-up">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl mb-4 flex items-center gap-3 font-semibold text-sm animate-fade-up">
                    <i class="fas fa-exclamation-circle"></i> 
                    <div>
                        <span class="font-bold">Gagal menyimpan!</span> Silakan periksa kembali data Anda:
                        <ul class="mt-1 ml-4 list-disc text-xs font-normal">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- VIEW: APPOINTMENT LIST -->
            <section id="view-appointment" class="space-y-6 animate-fade-up">

                <!-- Header Filter & Tombol -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex gap-2 overflow-x-auto pb-1">
                        <button type="button" class="tab-btn active" onclick="filterAppointments(this, 'semua')">Semua</button>
                        <button type="button" class="tab-btn" onclick="filterAppointments(this, 'mendatang')">Aktif</button>
                        <button type="button" class="tab-btn" onclick="filterAppointments(this, 'selesai')">Selesai</button>
                        <button type="button" class="tab-btn" onclick="filterAppointments(this, 'dibatalkan')">Dibatalkan</button>
                    </div>
                    <button type="button" onclick="switchView('form-appointment')" class="cursor-pointer inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 hover:shadow-lg hover:shadow-blue-200 transition-all duration-200 active:scale-[0.97]">
                        <i class="fas fa-plus text-xs"></i> Buat Appointment
                    </button>
                </div>

                <!-- Daftar Appointment -->
                <div class="space-y-4" id="appointment-list">
                    
                    @forelse($appointments as $item)
                    <div class="card p-5 flex flex-col md:flex-row items-center justify-between gap-4 
                        {{ $item->status == 'Dibatalkan' ? 'opacity-60' : '' }} 
                        {{ $item->status == 'Selesai' ? 'opacity-75' : '' }}"
                        data-status="{{ $item->status == 'Terjadwal' || $item->status == 'Menunggu Konfirmasi' ? 'mendatang' : ($item->status == 'Selesai' ? 'selesai' : 'dibatalkan') }}"
                        onclick="openDetailModal(this)"
                        data-treatment="{{ $item->jenis_perawatan }}"
                        data-doctor="{{ $item->dokter }}"
                        data-date="{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}"
                        data-time="{{ $item->waktu }}"
                        data-status-text="{{ $item->status }}"
                        data-name="{{ $item->nama_lengkap }}"
                        data-phone="{{ $item->no_telepon }}"
                        data-keluhan="{{ $item->keluhan ?? '-' }}"
                        data-ec-name="{{ $item->kontak_darurat_nama ?? '-' }}"
                        data-ec-phone="{{ $item->kontak_darurat_telepon ?? '-' }}"
                        data-queue="A-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}"
                        data-id="{{ $item->id }}">
                        
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="@if($item->status=='Terjadwal') bg-primary-50 text-primary-700 border-primary-100 @elseif($item->status=='Menunggu Konfirmasi') bg-amber-50 text-amber-700 border-amber-100 @elseif($item->status=='Dibatalkan') bg-red-50 text-red-400 border-red-100 @else bg-slate-100 text-slate-500 border-slate-200 @endif rounded-xl px-4 py-3 text-center min-w-[72px] border flex-shrink-0">
                                <p class="text-[11px] font-bold uppercase tracking-wide">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</p>
                                <p class="text-2xl font-extrabold leading-none mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</p>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-gray-800 text-[17px] truncate @if($item->status=='Dibatalkan') line-through text-slate-500 @endif">{{ $item->jenis_perawatan }}</h4>
                                <p class="text-gray-500 text-sm flex items-center gap-2 mt-1">
                                    <i class="fas fa-user-md text-xs text-primary-400"></i> {{ $item->dokter }}
                                </p>
                                <p class="text-gray-400 text-xs mt-1 flex items-center gap-2">
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
                                <form action="{{ route('appointment.cancel', $item->id) }}" method="POST" onclick="event.stopPropagation()">
                                    @csrf @method('PUT')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-white hover:bg-red-50 text-red-400 hover:text-red-600 text-xs font-bold transition border border-red-200 hover:border-red-300" onclick="return confirm('Yakin ingin membatalkan janji ini? Tindakan ini tidak bisa dibatalkan.')">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    
                    <!-- EMPTY STATE -->
                    <div class="min-h-[50vh] flex items-center justify-center w-full animate-fade-up">
                        <div class="bg-white border-2 border-dashed border-blue-200 rounded-2xl p-12 md:p-16 w-full text-center shadow-sm">
                            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4 mx-auto border border-blue-100">
                                <i class="fas fa-calendar-plus text-2xl text-primary-400"></i>
                            </div>
                            <p class="text-gray-800 font-bold text-base mb-1">Belum Ada Janji Temu</p>
                            <p class="text-gray-400 text-sm">Silakan buat appointment baru menggunakan tombol di atas.</p>
                        </div>
                    </div>
                    @endforelse

                </div>
            </section>

            <!-- VIEW: FORM APPOINTMENT -->
            <section id="view-form-appointment" class="hidden space-y-6 animate-fade-up">

                <div class="flex items-center gap-3">
                    <button type="button" onclick="switchView('appointment')" class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </button>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Kembali ke daftar</p>
                        <h3 class="text-lg font-bold text-gray-800">Buat Appointment Baru</h3>
                    </div>
                </div>

                <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST">
                    @csrf

                    <!-- SECTION 1: DATA PASIEN -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-1">
                        <div class="section-header">
                            <div class="icon-box bg-primary-100 text-primary-600"><i class="fas fa-user"></i></div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-[15px]">Data Pasien</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Informasi lengkap pasien</p>
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
                                    <input type="text" name="nik" id="inputNik" class="form-input" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required oninput="validateNik()">
                                    <span id="warningNik" class="text-red-500 text-xs mt-1 hidden"></span>
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
                                    <input type="tel" name="no_telepon" id="inputTelp" class="form-input" value="{{ old('no_telepon') }}" placeholder="12 digit nomor telepon" maxlength="13" required oninput="validatePhone('inputTelp', 'warningTelp')">
                                    <span id="warningTelp" class="text-red-500 text-xs mt-1 hidden"></span>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                                    <textarea name="alamat" class="form-input" placeholder="Masukkan alamat lengkap..." rows="2" required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: KONTAK DARURAT -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-2">
                        <div class="section-header">
                            <div class="icon-box bg-amber-50 text-amber-600"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-[15px]">Kontak Darurat</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Kontak yang bisa dihubungi saat darurat</p>
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
                                    <input type="tel" name="kontak_darurat_telepon" id="inputTelpDarurat" class="form-input" value="{{ old('kontak_darurat_telepon') }}" placeholder="12 digit nomor telepon" maxlength="13" required oninput="validatePhone('inputTelpDarurat', 'warningTelpDarurat')">
                                    <span id="warningTelpDarurat" class="text-red-500 text-xs mt-1 hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: DETAIL APPOINTMENT -->
                    <div class="section-card mb-5 animate-fade-up animate-fade-up-delay-3">
                        <div class="section-header">
                            <div class="icon-box bg-violet-50 text-violet-600"><i class="fas fa-calendar-plus"></i></div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-[15px]">Detail Appointment</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Pilih jadwal & dokter yang diinginkan</p>
                            </div>
                        </div>
                        <div class="section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="form-label">Tanggal Appointment <span class="required">*</span></label>
                                    <input type="date" name="tanggal" class="form-input" id="appointmentDate" value="{{ old('tanggal') }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
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
                                        <option value="drg. Ahmad Eunwo Ramdhan, Sp.Ort" @if(old('dokter')=='drg. Ahmad Eunwo Ramdhan, Sp.Ort') selected @endif>drg. Ahmad Eunwo Ramdhan, Sp.Ort</option>
                                        <option value="drg. Naurah Afkarina Ananda, KG" @if(old('dokter')=='drg. Naurah Afkarina Ananda, KG') selected @endif>drg. Naurah Afkarina Ananda, KG</option>
                                        <option value="drg. Binan Wooseok Sagara, Sp. Pros" @if(old('dokter')=='drg. Binan Wooseok Sagara, Sp. Pros') selected @endif>drg. Binan Wooseok Sagara, Sp. Pros</option>
                                        <option value="drg. Intan Novitasari, Sp. Perio" @if(old('dokter')=='drg. Intan Novitasari, Sp. Perio') selected @endif>drg. Intan Novitasari, Sp. Perio</option>
                                        <option value="drg. Najwa Wahdaniyatul Meilani, Sp. BM" @if(old('dokter')=='drg. Najwa Wahdaniyatul Meilani, Sp. BM') selected @endif>drg. Najwa Wahdaniyatul Meilani, Sp. BM</option>
                                        <option value="drg. Aprilia Ajeng Wulandari, Sp.KGA" @if(old('dokter')=='drg. Aprilia Ajeng Wulandari, Sp.KGA') selected @endif>drg. Aprilia Ajeng Wulandari, Sp.KGA</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Jenis Perawatan <span class="required">*</span></label>
                                    <select name="jenis_perawatan" class="form-input" required>
                                        <option value="" disabled @if(!old('jenis_perawatan')) selected @endif>Pilih perawatan</option>
                                        <option value="Behel Gigi" @if(old('jenis_perawatan')=='Behel Gigi') selected @endif>Behel Gigi</option>
                                        <option value="Bleaching Gigi" @if(old('jenis_perawatan')=='Bleaching Gigi') selected @endif>Bleaching Gigi</option>
                                        <option value="Gigi Tiruan" @if(old('jenis_perawatan')=='Gigi Tiruan') selected @endif>Gigi Tiruan</option>
                                        <option value="Gum Lifting" @if(old('jenis_perawatan')=='Gum Lifting') selected @endif>Gum Lifting</option>
                                        <option value="Veneer" @if(old('jenis_perawatan')=='Veneer') selected @endif>Veneer</option>
                                        <option value="Tambal Gigi" @if(old('jenis_perawatan')=='Tambal Gigi') selected @endif>Tambal Gigi</option>
                                        <option value="Cabut Gigi" @if(old('jenis_perawatan')=='Cabut Gigi') selected @endif>Cabut Gigi</option>
                                        <option value="Scaling Gigi" @if(old('jenis_perawatan')=='Scaling Gigi') selected @endif>Scaling Gigi</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Keluhan / Catatan Tambahan</label>
                                    <textarea name="keluhan" class="form-input" placeholder="Jelaskan keluhan atau catatan khusus yang ingin disampaikan ke dokter..." rows="3">{{ old('keluhan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="switchView('appointment')" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-200 transition-all active:scale-[0.97] flex items-center justify-center gap-2">
                            <i class="fas fa-check text-xs"></i> Simpan Appointment
                        </button>
                    </div>

                </form>
            </section>

        </main>

    </div> <!-- Penutup main-content -->

    <!-- MODAL DETAIL APPOINTMENT (E-TICKET / STRUK) -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-colors z-10 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
            
            <div class="p-8 modal-body-scroll overflow-y-auto flex-1">
                <!-- Header Modal -->
                <div class="flex items-center justify-between mb-6">
                    <h2 id="modalTreatment" class="text-2xl font-extrabold text-gray-900"></h2>
                    <span id="modalStatus" class="px-3.5 py-1.5 rounded-full text-xs font-bold"></span>
                </div>

                <!-- Info Utama -->
                <div class="bg-gradient-to-r from-primary-50 to-white p-5 rounded-xl border border-primary-100 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Tanggal</p>
                            <p id="modalDate" class="text-sm font-bold text-gray-800 mt-1"><i class="fas fa-calendar-day text-primary-500 mr-2"></i>-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Waktu</p>
                            <p id="modalTime" class="text-sm font-bold text-gray-800 mt-1"><i class="fas fa-clock text-primary-500 mr-2"></i>-</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 font-medium">Dokter</p>
                            <p id="modalDoctor" class="text-sm font-bold text-gray-800 mt-1"><i class="fas fa-user-md text-primary-500 mr-2"></i>-</p>
                        </div>
                    </div>
                </div>

                <!-- Info Pasien & Keluhan -->
                <div class="space-y-4">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2"><i class="fas fa-user text-primary-500 text-xs"></i> Data Pasien</h4>
                        <div class="bg-gray-50 p-4 rounded-xl text-sm space-y-2 border border-gray-100">
                            <p class="text-gray-600"><span class="font-semibold text-gray-800">Nama:</span> <span id="modalName"></span></p>
                            <p class="text-gray-600"><span class="font-semibold text-gray-800">No. Telepon:</span> <span id="modalPhone"></span></p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2"><i class="fas fa-notes-medical text-primary-500 text-xs"></i> Keluhan</h4>
                        <div class="bg-gray-50 p-4 rounded-xl text-sm border border-gray-100">
                            <p id="modalKeluhan" class="text-gray-600 italic">-</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2"><i class="fas fa-phone-volume text-red-500 text-xs"></i> Kontak Darurat</h4>
                        <div class="bg-gray-50 p-4 rounded-xl text-sm space-y-2 border border-gray-100">
                            <p class="text-gray-600"><span class="font-semibold text-gray-800">Nama:</span> <span id="modalEcName"></span></p>
                            <p class="text-gray-600"><span class="font-semibold text-gray-800">Telepon:</span> <span id="modalEcPhone"></span></p>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN E-TICKET (NOMOR ANTRIAN & BARCODE) -->
                <div class="ticket-tear">
                    <div class="flex flex-col items-center text-center">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Nomor Antrian Anda</p>
                        <h2 id="modalQueue" class="text-5xl font-extrabold text-primary-600 mb-5 tracking-wider">A-001</h2>
                        
                        <div class="bg-white p-3 rounded-xl border-2 border-primary-100 shadow-md mb-4">
                            <div id="modalQrCode"></div>
                        </div>
                        
                        <p class="text-[11px] text-gray-400 max-w-[220px] leading-relaxed">Tunjukkan barcode ini ke petugas resepsionis saat tiba di klinik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT DIGABUNG JADI SATU SAJA BIAR GAK ERROR -->
    <script>
        // SET MINIMUM DATE HARI INI
        const dateInput = document.getElementById('appointmentDate');
        if(dateInput){
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        }

        // FUNGSI SWITCH VIEW
        function switchView(viewName) {
            const viewList = document.getElementById('view-appointment');
            const viewForm = document.getElementById('view-form-appointment');
            const title = document.getElementById('page-title');

            if(viewList) viewList.classList.add('hidden');
            if(viewForm) viewForm.classList.add('hidden');

            if (viewName === 'appointment') {
                if(viewList) viewList.classList.remove('hidden');
                if(title) title.innerText = 'Appointment Saya';
            }
            else if (viewName === 'form-appointment') {
                if(viewForm) viewForm.classList.remove('hidden');
                if(title) title.innerText = 'Buat Appointment';
            }

            if (window.innerWidth <= 1024) { closeSidebar(); }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // FUNGSI FILTER TAB
        function filterAppointments(btnEl, filter) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btnEl.classList.add('active');
            const cards = document.querySelectorAll('#appointment-list > div');
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                let show = false;

                if (filter === 'semua') {
                    show = true;
                } else if (filter === 'mendatang') {
                    show = (status === 'mendatang');
                } else if (filter === 'selesai') {
                    show = (status === 'selesai');
                } else if (filter === 'dibatalkan') {
                    show = (status === 'dibatalkan');
                }

                card.style.display = show ? '' : 'none';
            });
        }

        // FUNGSI SIDEBAR & TOPBAR
        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('mobileOverlay').classList.toggle('show'); }
        function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('mobileOverlay').classList.remove('show'); }
        function toggleNotif() { document.getElementById('notifDropdown').classList.toggle('open'); }

        document.addEventListener('click', function(e) {
            const notifBtn = document.getElementById('notifBtn'); 
            const notifDrop = document.getElementById('notifDropdown');
            if (!notifBtn.contains(e.target) && !notifDrop.contains(e.target)) notifDrop.classList.remove('open');
        });

        // SCRIPT UNTUK MODAL DETAIL & QR CODE
        function openDetailModal(element) {
            document.getElementById('modalTreatment').innerText = element.dataset.treatment;
            document.getElementById('modalDate').innerHTML = `<i class="fas fa-calendar-day text-primary-500 mr-2"></i>${element.dataset.date}`;
            document.getElementById('modalTime').innerHTML = `<i class="fas fa-clock text-primary-500 mr-2"></i>${element.dataset.time} WIB`;
            document.getElementById('modalDoctor').innerHTML = `<i class="fas fa-user-md text-primary-500 mr-2"></i>${element.dataset.doctor}`;
            document.getElementById('modalName').innerText = element.dataset.name;
            document.getElementById('modalPhone').innerText = element.dataset.phone;
            document.getElementById('modalKeluhan').innerText = element.dataset.keluhan;
            document.getElementById('modalEcName').innerText = element.dataset.ecName;
            document.getElementById('modalEcPhone').innerText = element.dataset.ecPhone;
            
            const queueNum = element.dataset.queue;
            document.getElementById('modalQueue').innerText = queueNum;

            const statusText = element.dataset.statusText;
            const statusEl = document.getElementById('modalStatus');
            statusEl.innerText = statusText;
            statusEl.className = "px-3.5 py-1.5 rounded-full text-xs font-bold ";
            if(statusText === 'Terjadwal') statusEl.classList.add('badge-confirmed');
            else if(statusText === 'Menunggu Konfirmasi') statusEl.classList.add('badge-pending');
            else if(statusText === 'Selesai') statusEl.classList.add('badge-completed');
            else statusEl.classList.add('badge-cancelled');

            const qrContainer = document.getElementById('modalQrCode');
            qrContainer.innerHTML = ""; 
            
            new QRCode(qrContainer, {
                text: queueNum,
                width: 140,
                height: 140,
                colorDark : "#1e3a8a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            document.getElementById('detailModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('open');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeDetailModal(); });

        // AUTO SWITCH KE FORM KALO ADA ERROR VALIDASI ATAU DATANG DARI PRICELIST
        @if($errors->any() || old('nama_lengkap'))
            document.addEventListener('DOMContentLoaded', function() {
                switchView('form-appointment');
            });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const openForm = urlParams.get('open_form');
            const treatment = urlParams.get('treatment');

            // Kalau diklik dari pricelist
            if (openForm === '1') {
                switchView('form-appointment');
                
                // Auto-select jenis perawatan kalau ada parameter treatment dari pricelist
                if (treatment) {
                    const selectEl = document.querySelector('select[name="jenis_perawatan"]');
                    if (selectEl) {
                        selectEl.value = treatment;
                        selectEl.dispatchEvent(new Event('change'));
                    }
                }
            }
        });

        // VALIDASI REAL-TIME NIK
        function validateNik() {
            const input = document.getElementById('inputNik');
            const warning = document.getElementById('warningNik');
            const val = input.value;

            if (val.length > 0 && val.length < 16) {
                warning.textContent = 'NIK harus tepat 16 digit. (Kurang ' + (16 - val.length) + ' digit)';
                warning.classList.remove('hidden');
                input.classList.add('border-red-400');
            } else if (val.length === 16) {
                warning.classList.add('hidden');
                input.classList.remove('border-red-400');
            } else {
                warning.classList.add('hidden');
                input.classList.remove('border-red-400');
            }
        }

        // VALIDASI REAL-TIME NO. TELEPON
        function validatePhone(inputId, warningId) {
            const input = document.getElementById(inputId);
            const warning = document.getElementById(warningId);
            const val = input.value;

            if (val.length > 0 && val.length < 12) {
                warning.textContent = 'No. Telepon harus tepat 12 digit. (Kurang ' + (12 - val.length) + ' digit)';
                warning.classList.remove('hidden');
                input.classList.add('border-red-400');
            } else if (val.length === 12) {
                warning.classList.add('hidden');
                input.classList.remove('border-red-400');
            } else if (val.length > 12) {
                warning.textContent = 'No. Telepon tidak boleh lebih dari 12 digit.';
                warning.classList.remove('hidden');
                input.classList.add('border-red-400');
            } else {
                warning.classList.add('hidden');
                input.classList.remove('border-red-400');
            }
        }

        // VALIDASI SAAT FORM DI-SUBMIT
        const form = document.getElementById('appointmentForm');
        if(form) {
            form.addEventListener('submit', function(event) {
                const nikVal = document.getElementById('inputNik').value;
                const telpVal = document.getElementById('inputTelp').value;
                const telpDaruratVal = document.getElementById('inputTelpDarurat').value;

                let errorMsg = [];

                if(nikVal.length !== 16) errorMsg.push('NIK harus tepat 16 digit');
                if(telpVal.length !== 12) errorMsg.push('No. Telepon harus tepat 12 digit');
                if(telpDaruratVal.length !== 12) errorMsg.push('No. Telepon Darurat harus tepat 12 digit');

                if (!form.checkValidity()) {
                    errorMsg.push('Masih ada data wajib isi yang kosong.');
                }

                if(errorMsg.length > 0) {
                    event.preventDefault();
                    alert('GAGAL SIMPAN!\n\n' + errorMsg.join('\n'));
                }
            });
        }
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('appointmentDate');
    const dokterSelect = document.querySelector('select[name="dokter"]'); // Sesuaikan name select doktermu
    const waktuSelect = document.querySelector('select[name="waktu"]'); // Sesuaikan name select waktumu

    async function updateSlots() {
        const tanggal = tanggalInput.value;
        const dokter = dokterSelect.value;

        // Jika tanggal atau dokter belum dipilih, jangan cek dulu
        if (!tanggal || !dokter) return;

        try {
            // Kirim request ke backend
            const response = await fetch(`/cek-jadwal?tanggal=${tanggal}&dokter=${encodeURIComponent(dokter)}`);
            const bookedSlots = await response.json();

            // Reset semua opsi waktu (hapus tulisan Sudah Dibooking sebelumnya)
            Array.from(waktuSelect.options).forEach(option => {
                option.disabled = false;
                // Hapus teks "(Sudah Dibooking)" kalau ada
                option.text = option.text.replace(' (Sudah Dibooking)', '');
            });

            // Disable opsi yang sudah dibooking
            bookedSlots.forEach(slot => {
                const optionToDisable = Array.from(waktuSelect.options).find(opt => opt.value === slot);
                if (optionToDisable) {
                    optionToDisable.disabled = true; // Opsinya tidak bisa diklik
                    optionToDisable.text += ' (Sudah Dibooking)'; // Tambah keterangan
                }
            });

        } catch (error) {
            console.error('Gagal mengambil jadwal:', error);
        }
    }

    // Jalankan fungsi saat tanggal atau dokter berubah
    tanggalInput.addEventListener('change', updateSlots);
    dokterSelect.addEventListener('change', updateSlots);
    
    // Jalankan sekali saat halaman dibuka (kalau ada old input)
    updateSlots();
});
</script>
</body>
</html>