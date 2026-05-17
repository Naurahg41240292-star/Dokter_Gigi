<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - D'Smile</title>
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
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
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

        /* Custom Scrollbar */
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
<body class="min-h-screen w-full flex items-center justify-center p-4 md:p-8 font-sans text-slate-800 page-transition">

    <!-- KARTU MENENGAH (Floating Card) -->
    <!-- UBAHAN: max-w-4xl diganti menjadi max-w-6xl agar lebih lebar -->
    <div class="w-full max-w-6xl min-h-[600px] bg-white shadow-2xl rounded-[1.5rem] overflow-hidden flex flex-col md:flex-row relative">

        <!-- ================= KIRI: FORM LOGIN ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] bg-white p-6 md:p-12 flex flex-col justify-center relative z-10 safe-scroll">

            <!-- Header -->
            <div class="mb-10">
                <div class="mb-4">
                    <img src="{{ asset('images/logo (2).png') }}" alt="D'SMILE Logo" class="h-10 w-auto">
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Selamat Datang!</h1>
                <p class="text-slate-500 text-base">Masuk untuk melanjutkan perjalanan sehat Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form Inputs -->
            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                <!-- Email / Telepon -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Email / No. Telepon</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-envelope text-sm" aria-hidden="true"></i>
                        </div>
                        <input name="email" type="text" placeholder="Masukkan email Anda..." class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400" value="{{ old('email') }}">
                    </div>
                    @error('email')
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
                        <input id="login-password" name="password" type="password" placeholder="Masukkan kata sandi..." class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400">
                        <button type="button" data-toggle-password="login-password" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-dsmile-main transition-colors" aria-label="Tampilkan kata sandi">
                            <i class="fas fa-eye text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror

                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-dsmile-main border-slate-300 rounded focus:ring-dsmile-main cursor-pointer">
                            <label for="remember" class="text-xs text-slate-500 cursor-pointer select-none">Ingat saya</label>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-dsmile-main hover:text-dsmile-dark transition-colors">Lupa Kata Sandi?</a>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-dsmile-main text-white font-bold py-3.5 rounded-xl shadow-md shadow-blue-500/20 hover:bg-dsmile-dark hover:shadow-blue-600/30 transform hover:-translate-y-0.5 transition-all duration-200 text-base mt-2">
                    MASUK
                </button>
            </form>

            <!-- Divider & Socials -->
            <div class="mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-grow h-px bg-slate-200"></div>
                    <span class="text-xs text-slate-400 font-medium whitespace-nowrap">atau masuk dengan</span>
                    <div class="flex-grow h-px bg-slate-200"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-2 py-3 border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors text-xs font-bold text-slate-600 hover:text-slate-800">
                        <i class="fab fa-google text-red-500 text-base" aria-hidden="true"></i> Google
                    </button>
                    <button class="flex items-center justify-center gap-2 py-3 border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors text-xs font-bold text-slate-600 hover:text-slate-800">
                        <i class="fab fa-facebook text-blue-600 text-base" aria-hidden="true"></i> Facebook
                    </button>
                </div>
            </div>

            <!-- Footer Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-dsmile-main hover:text-dsmile-dark hover:underline transition-colors">Daftar disini</a>
                </p>
            </div>
        </div>

        <!-- ================= KANAN: GAMBAR (BRANDING) ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] relative bg-slate-100 hidden md:block overflow-hidden">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=2068&auto=format&fit=crop" alt="Ruang Tunggu D'Smile" class="absolute inset-0 w-full h-full object-cover">

            <!-- Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-dsmile-dark/80 via-dsmile-main/70 to-transparent"></div>

            <!-- Content Overlay (Vertically Centered) -->
            <div class="absolute inset-0 flex flex-col justify-center p-12 text-white z-10">

                <!-- Logo & Text -->
                    <h2 class="text-5xl font-extrabold leading-tight mb-3 text-shadow-sm">Your Smile,</h2>
                    <h2 class="text-5xl font-extrabold leading-tight mb-4 text-blue-200 text-shadow-sm">Our Priority</h2>

                    <p class="text-sm text-blue-50 leading-relaxed mb-8">
                        Memberikan kenyamanan terbaik dengan fasilitas modern dan ruang tunggu yang asri untuk pengalaman dokter gigi yang menyenangkan.
                    </p>

                    <!-- Mini Info -->
                    <div class="flex items-center gap-6 text-sm font-medium text-blue-100">
                        <span class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-300" aria-hidden="true"></i> Dokter Profesional</span>
                        <span class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-300" aria-hidden="true"></i> Layanan Modern</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toast Notification -->
    <script>
        // Show registration success toast if redirected after register
        (function(){
            const registered = {{ session('registered') ? 'true' : 'false' }};
            if (registered === 'true') {
                const toast = document.createElement('div');
                toast.className = 'fixed left-1/2 bottom-10 -translate-x-1/2 bg-emerald-600 text-white px-6 py-3 rounded-full shadow-lg text-sm font-medium animate-fade-in flex items-center gap-2 z-50';
                toast.innerHTML = '<i class="fas fa-check-circle" aria-hidden="true"></i> Pendaftaran berhasil. Silakan login.';
                document.body.appendChild(toast);

                // Remove toast after 3.5 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    setTimeout(() => toast.remove(), 300);
                }, 3500);
            }
        })();

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
