<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $layanan['title'] }} - D'SMILE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0056b3; --primary-gradient: linear-gradient(135deg, #0056b3 0%, #00a8e8 100%); --dark: #0f172a; --text-muted: #64748b; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--dark); }
        .navbar-brand img { height: 50px; }
        .detail-img { border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.15); width: 100%; object-fit: cover; }
        .detail-title { font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; }
        .detail-desc { font-size: 1.1rem; line-height: 1.8; color: var(--text-muted); margin-bottom: 30px; }
        .btn-back { background: var(--primary-gradient); color: white; border-radius: 8px; padding: 12px 30px; font-weight: 700; text-decoration: none; display: inline-block; transition: transform 0.3s; }
        .btn-back:hover { transform: translateY(-3px); color: white; }
    </style>
</head>
<body>

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-light bg-white shadow-sm py-3 mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('images/logo (2).png') }}" alt="D'SMILE Logo">
            </a>
        </div>
    </nav>

    <!-- Konten Detail -->
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ $layanan['image'] }}" class="detail-img" alt="{{ $layanan['title'] }}">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="mb-3" style="font-size: 3rem; color: var(--primary);">
                    <i class="{{ $layanan['icon'] }}"></i>
                </div>
                <h1 class="detail-title">{{ $layanan['title'] }}</h1>
                <p class="detail-desc">{{ $layanan['description'] }}</p>
                
                <h5 class="fw-bold mb-3">Keunggulan di D'SMILE:</h5>
                <ul class="text-muted" style="line-height: 2;">
                    <li>Dokter spesialis berpengalaman</li>
                    <li>Peralatan steril & berteknologi modern</li>
                    <li>Prosedur minim rasa sakit</li>
                    <li>Hasil yang maksimal dan tahan lama</li>
                </ul>

                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn-back me-3"><i class="fas fa-calendar-check me-2"></i> Buat Janji</a>
                    <a href="{{ route('landing') }}" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 12px 30px; font-weight: 700;">Kembali</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>