<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.12), transparent 26%),
                radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.10), transparent 22%),
                #eff6ff;
        }

        .page-fade-in {
            animation: pageFadeIn 0.35s ease both;
        }

        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
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
<body class="min-h-screen page-fade-in page-transition flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-4xl overflow-hidden rounded-[2rem] border border-white/60 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.16)] grid lg:grid-cols-2">
        <div class="p-8 sm:p-10 lg:p-14">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.22em] text-blue-500 font-bold">D'Smile</p>
                    <h1 class="text-xl font-extrabold text-slate-900 leading-tight">Lupa password</h1>
                </div>
            </div>

            <p class="text-sm leading-7 text-slate-600">
                Masukkan email akun Anda untuk melanjutkan ke form membuat kata sandi baru.
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <!-- STEP 1: Email Input -->
            @if (!request('step') || request('step') == '1')
                <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Email</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', request('email')) }}" required autocomplete="email" placeholder="nama@email.com" class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-4 pl-12 pr-4 text-slate-700 outline-none transition-all duration-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                        </div>
                    </div>

                    <button type="submit" class="group w-full rounded-2xl bg-blue-600 py-4 font-bold text-white shadow-lg shadow-blue-500/25 transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-blue-500/35">
                        <span class="inline-flex items-center justify-center gap-2">
                            Lanjut ke Form Kata Sandi
                            <i class="fas fa-arrow-right text-sm transition-transform duration-300 group-hover:translate-x-1"></i>
                        </span>
                    </button>
                </form>
            @endif

            <div class="mt-8 flex items-center justify-between gap-4 text-sm">
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">Kembali ke login</a>
                <a href="{{ route('register') }}" class="font-semibold text-slate-500 hover:text-slate-700 transition">Buat akun baru</a>
            </div>
        </div>

        <div class="hidden lg:block bg-gradient-to-br from-blue-700 via-blue-600 to-sky-500 p-10 text-white">
            <div class="h-full flex flex-col justify-between">
                <div class="inline-flex w-max items-center gap-3 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur-md">
                    <i class="fas fa-shield-heart"></i>
                    Akses akun tetap aman
                </div>

                <div class="max-w-md">
                    <h2 class="text-4xl font-extrabold leading-tight">
                        @if (!request('step') || request('step') == '1')
                            Verifikasi email untuk keamanan akun.
                        @else
                            Buat kata sandi yang kuat untuk akun Anda.
                        @endif
                    </h2>
                    <p class="mt-4 text-blue-100 text-sm leading-relaxed">
                        @if (!request('step') || request('step') == '1')
                            Masukkan email terdaftar untuk melanjutkan ke proses reset password.
                        @else
                            Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk hasil terbaik.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
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
</html>
