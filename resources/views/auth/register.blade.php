<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        dsmile: {
                            main: '#2563eb',
                            dark: '#1e40af'
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 5s ease-in-out 1s infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f0f4f8;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .safe-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .safe-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .safe-scroll::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .safe-scroll:hover::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
        }

        /* Efek Gelas / Blur */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-transition {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.28s ease, transform 0.28s ease;
        }

        .page-transition.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .page-transition.is-leaving {
            opacity: 0;
            transform: translateY(8px);
        }
    </style>
</head>
<body class="min-h-screen w-full flex items-center justify-center p-4 md:p-8 page-transition">

    <!-- KARTU MENENGAH (Floating Card) -->
    <!-- UBAHAN: max-w-4xl diganti menjadi max-w-6xl agar lebih lebar -->
    <div class="w-full max-w-6xl min-h-[600px] bg-white shadow-2xl rounded-[1.5rem] overflow-hidden flex flex-col md:flex-row relative">

        <!-- ================= KIRI: FORM REGISTER ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] bg-white p-6 md:p-12 flex flex-col justify-center relative z-10 overflow-y-auto safe-scroll">

            <!-- Header dengan Dekorasi Animasi Kecil -->
            <div class="mb-8 relative">
                <!-- Dekorasi Animasi Kecil di pojok kanan header -->
                <div class="absolute -top-4 -right-4 w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center animate-pulse-slow text-blue-100">
                    <i class="fas fa-tooth text-2xl" aria-hidden="true"></i>
                </div>

                <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Buat Akun Anda</h1>
                <p class="text-slate-500 text-base">Mulai perawatan gigi Anda sekarang.</p>
            </div>

            <!-- Form Inputs -->
            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-user text-sm" aria-hidden="true"></i>
                        </div>
                        <input name="name" type="text" placeholder="Nama Anda" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-envelope text-sm" aria-hidden="true"></i>
                        </div>
                        <input name="email" type="email" placeholder="contoh@email.com" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Nomor Telepon</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-phone text-sm" aria-hidden="true"></i>
                        </div>
                        <input name="phone" type="tel" placeholder="0812xxxx" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400" value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-lock text-sm" aria-hidden="true"></i>
                        </div>
                        <input id="register-password" name="password" type="password" placeholder="Buat kata sandi" class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400">
                        <button type="button" data-toggle-password="register-password" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-dsmile-main transition-colors" aria-label="Tampilkan kata sandi">
                            <i class="fas fa-eye text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Konfirmasi Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-lock text-sm" aria-hidden="true"></i>
                        </div>
                        <input id="register-password-confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Role: registration is for Pasien only (hidden) -->
                <input type="hidden" name="role" value="pasien">

                <!-- Terms -->
                <div class="flex items-start gap-3 mt-2">
                    <input type="checkbox" id="terms" class="mt-1 w-4 h-4 text-dsmile-main border-slate-300 rounded focus:ring-dsmile-main cursor-pointer">
                    <label for="terms" class="text-sm text-slate-500 leading-tight cursor-pointer">
                        Saya Setuju dengan <a href="#" class="text-dsmile-main font-bold hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-dsmile-main font-bold hover:underline">Kebijakan Privasi</a>.
                    </label>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-dsmile-main text-white font-bold py-3.5 rounded-xl shadow-md shadow-blue-500/20 hover:bg-dsmile-dark hover:shadow-blue-600/30 transform hover:-translate-y-0.5 transition-all duration-200 text-base mt-4">
                    DAFTAR SEKARANG
                </button>
            </form>

            <!-- Footer Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500">
                    Sudah Punya Akun? <a href="{{ route('login') }}" class="font-bold text-dsmile-main hover:text-dsmile-dark hover:underline transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>

        <!-- ================= KANAN: GAMBAR (BRANDING) ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] relative bg-dsmile-main hidden md:block overflow-hidden">

            <!-- Elemen Animasi Latar Belakang (2D Elements) -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Lingkaran Besar Berdenyut -->
                <div class="absolute top-[-50px] right-[-50px] w-96 h-96 bg-white/10 rounded-full animate-pulse-slow"></div>
                <!-- Lingkaran Kecil Melayang -->
                <div class="absolute bottom-[10%] left-[-20px] w-64 h-64 bg-white/5 rounded-full animate-float-slow"></div>
                <!-- Gigi Raksasa Transparan (Watermark) -->
                <div class="absolute top-[20%] left-[10%] text-white/5 text-[12rem] animate-float">
                    <i class="fas fa-tooth" aria-hidden="true"></i>
                </div>
                <!-- Ikon Plus Melayang -->
                <div class="absolute top-[20%] right-[20%] text-white/20 text-4xl animate-float-delayed">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                </div>
                <div class="absolute bottom-[20%] left-[30%] text-white/10 text-6xl animate-float-delayed">
                    <i class="fas fa-heartbeat" aria-hidden="true"></i>
                </div>
            </div>

            <!-- Content Overlay (Vertically Centered) -->
            <div class="absolute inset-0 flex flex-col justify-center p-12 text-white z-10">

                <!-- Kartun/Illustrasi Maskot -->
                <div class="mb-8 flex justify-center animate-float">
                    <!-- Lingkaran Latar Maskot -->
                    <div class="w-40 h-40 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30 relative shadow-[0_0_40px_rgba(255,255,255,0.2)]">
                        <!-- Ikon Gigi Utama -->
                        <i class="fas fa-user-md text-6xl text-white drop-shadow-lg" aria-hidden="true"></i>

                        <!-- Badge "Check" yang memantul -->
                        <div class="absolute -bottom-2 -right-2 w-14 h-14 bg-green-400 rounded-full border-4 border-dsmile-main flex items-center justify-center animate-bounce-slow shadow-lg">
                            <i class="fas fa-check text-dsmile-main text-xl" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <h3 class="text-center text-2xl font-bold mb-8 drop-shadow-md">Bergabung di D'Smile, Anda dapat:</h3>

                <div class="space-y-4 max-w-sm mx-auto">
                    <!-- Benefit 1 -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl glass-card hover:bg-white/20 transition-all duration-300 transform hover:scale-105 cursor-default group">
                        <div class="w-10 h-10 rounded-xl bg-white text-dsmile-main flex items-center justify-center flex-shrink-0 shadow-sm group-hover:rotate-12 transition-transform">
                            <i class="fas fa-calendar-check text-sm" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Booking Appointment</h4>
                            <p class="text-xs text-blue-100">Mudah & cepat tanpa antri.</p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl glass-card hover:bg-white/20 transition-all duration-300 transform hover:scale-105 cursor-default group">
                        <div class="w-10 h-10 rounded-xl bg-white text-dsmile-main flex items-center justify-center flex-shrink-0 shadow-sm group-hover:rotate-12 transition-transform">
                            <i class="fas fa-file-medical-alt text-sm" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Rekam Medis</h4>
                            <p class="text-xs text-blue-100">Riwayat kesehatan terdokumentasi.</p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl glass-card hover:bg-white/20 transition-all duration-300 transform hover:scale-105 cursor-default group">
                        <div class="w-10 h-10 rounded-xl bg-white text-dsmile-main flex items-center justify-center flex-shrink-0 shadow-sm group-hover:rotate-12 transition-transform">
                            <i class="fas fa-comments text-sm" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Konsultasi Online</h4>
                            <p class="text-xs text-blue-100">Tanya dokter dari rumah.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const inputId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                if (!input || !icon) {
                    return;
                }

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isHidden);
                icon.classList.toggle('fa-eye-slash', isHidden);
                button.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            });
        });

        const page = document.body;
        requestAnimationFrame(() => page.classList.add('is-visible'));

        document.querySelectorAll('a[href]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const href = link.getAttribute('href');

                if (!href || href.startsWith('#') || link.target === '_blank' || event.metaKey || event.ctrlKey) {
                    return;
                }

                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) {
                    return;
                }

                event.preventDefault();
                page.classList.add('is-leaving');
                setTimeout(() => {
                    window.location.href = targetUrl.href;
                }, 220);
            });
        });
    </script>
</body>
</html>
