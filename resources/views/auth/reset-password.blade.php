<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            background-color: #f8fafc;
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
    <div class="w-full max-w-6xl min-h-[600px] bg-white shadow-2xl rounded-[1.5rem] overflow-hidden flex flex-col md:flex-row relative">

        <!-- ================= KIRI: FORM RESET ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] bg-white p-6 md:p-12 flex flex-col justify-center relative z-10 safe-scroll">

            <!-- Logo & Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-dsmile-main flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i class="fas fa-tooth text-white text-lg" aria-hidden="true"></i>
                    </div>
                    <span class="font-bold text-lg text-slate-800 tracking-tight">D'Smile</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Reset Password</h1>
                <p class="text-slate-500 text-sm">Buat kata sandi baru untuk melindungi akun Anda.</p>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-sm text-red-600 flex items-start gap-3 animate-fade-in">
                    <div class="bg-red-100 rounded-full p-1 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xs" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="font-bold text-xs uppercase text-red-400 mb-1">Perbaiki Kesalahan Berikut</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Inputs -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Kata Sandi Baru -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Kata Sandi Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-lock text-sm" aria-hidden="true"></i>
                        </div>
                        <input id="reset-password-new" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400">
                        <button type="button" data-toggle-password="reset-password-new" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-dsmile-main transition-colors" aria-label="Tampilkan kata sandi baru">
                            <i class="fas fa-eye text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-600 uppercase ml-1 tracking-wide">Konfirmasi Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-dsmile-main transition-colors">
                            <i class="fas fa-check-circle text-sm" aria-hidden="true"></i>
                        </div>
                        <input id="reset-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi baru" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700 focus:bg-white focus:border-dsmile-main focus:ring-2 focus:ring-dsmile-main/20 outline-none transition-all font-medium placeholder:text-slate-400">
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-dsmile-main text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 hover:bg-dsmile-dark hover:shadow-blue-600/40 transform hover:-translate-y-0.5 transition-all duration-200 text-base mt-4">
                    Reset Password
                </button>
            </form>
        </div>

        <!-- ================= KANAN: VISUAL BRANDING ================= -->
        <div class="w-full md:w-1/2 min-h-[600px] relative bg-slate-100 hidden md:block overflow-hidden">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=1974&auto=format&fit=crop" alt="Security" class="absolute inset-0 w-full h-full object-cover">

            <!-- Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-dsmile-dark/80 via-dsmile-main/60 to-transparent"></div>

            <!-- Content Overlay -->
            <div class="absolute inset-0 flex flex-col justify-center p-12 text-white z-10">

                <!-- Visual Icon (Shield & Lock) -->
                <div class="mb-8 flex justify-center animate-float">
                    <div class="relative">
                        <!-- Lingkaran Belakang -->
                        <div class="w-32 h-32 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center border-4 border-white/20 shadow-[0_0_50px_rgba(37,99,235,0.3)]">
                            <i class="fas fa-lock text-5xl text-white drop-shadow-lg"></i>
                        </div>
                        <!-- Ikon Shield Overlay -->
                        <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-green-400 rounded-full border-4 border-dsmile-main flex items-center justify-center shadow-lg animate-bounce">
                            <i class="fas fa-shield-halved text-dsmile-main text-xl"></i>
                        </div>
                    </div>
                </div>

                <h2 class="text-3xl font-extrabold leading-tight mb-4 text-center">Amankan Data Anda</h2>

                <div class="max-w-sm mx-auto space-y-4">
                    <!-- Tip 1 -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-8 h-8 rounded-lg bg-white text-dsmile-main flex items-center justify-center shrink-0">
                            <i class="fas fa-key text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Kombinasi Unik</h4>
                            <p class="text-xs text-blue-100">Campur huruf, angka & simbol.</p>
                        </div>
                    </div>

                    <!-- Tip 2 -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-8 h-8 rounded-lg bg-white text-dsmile-main flex items-center justify-center shrink-0">
                            <i class="fas fa-user-secret text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Jangan Bagikan</h4>
                            <p class="text-xs text-blue-100">Rahasiakan kata sandi Anda.</p>
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
