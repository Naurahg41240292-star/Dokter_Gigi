<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'SMILE - Premium Dental Care</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0056b3;
            --primary-gradient: linear-gradient(135deg, #0056b3 0%, #00a8e8 100%);
            --dark: #0f172a;
            --light-bg: #f8fafc;
            --text-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 15px 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .navbar.scrolled { box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .navbar-brand img { height: 50px; }
        .nav-link { font-weight: 600; color: var(--dark) !important; margin: 0 15px; font-size: 0.95rem; position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 15px; width: 0; height: 2px; background: var(--primary); transition: width 0.3s; }
        .nav-link:hover::after { width: 60%; }
        .nav-link:hover { color: var(--primary) !important; }
        .btn-appointment-nav {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 28px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0, 86, 179, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-appointment-nav:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 86, 179, 0.4); color: white; }

        /* --- HERO SECTION --- */
        .hero-section {
            background: var(--light-bg);
            padding: 120px 0 80px 0;
            position: relative;
        }
        .hero-shape { position: absolute; top: -50px; right: -100px; width: 400px; height: 400px; background: linear-gradient(135deg, rgba(0,86,179,0.05) 0%, rgba(0,168,232,0.05) 100%); border-radius: 50%; z-index: 0; }
        .hero-tag {
            background: rgba(0, 86, 179, 0.1);
            color: var(--primary);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
            color: var(--dark);
        }
        .gradient-text { background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { color: var(--text-muted); font-size: 1.1rem; line-height: 1.8; margin-bottom: 35px; max-width: 500px; }
        .btn-hero-primary { background: var(--primary-gradient); color: white; padding: 14px 35px; border-radius: 8px; font-weight: 700; border: none; box-shadow: 0 4px 15px rgba(0, 86, 179, 0.3); transition: transform 0.3s; }
        .btn-hero-primary:hover { transform: translateY(-3px); color: white; }
        .btn-hero-outline { border: 2px solid var(--dark); color: var(--dark); padding: 12px 35px; border-radius: 8px; font-weight: 700; background: transparent; transition: all 0.3s; }
        .btn-hero-outline:hover { background: var(--dark); color: white; }
        
        .hero-img-wrapper { position: relative; z-index: 1; }
        .hero-img { border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.15); width: 100%; object-fit: cover; }
        
        .floating-card {
            position: absolute;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 2;
            animation: float 3s ease-in-out infinite;
        }
        .floating-card-bottom { bottom: 30px; left: -40px; }
        .floating-card-icon { width: 45px; height: 45px; background: rgba(0, 86, 179, 0.1); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }

        /* --- STATS SECTION --- */
        .stats-section { margin-top: -50px; position: relative; z-index: 2; }
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            text-align: center;
            transition: transform 0.3s;
        }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-number { font-size: 2.5rem; font-weight: 800; color: var(--primary); }
        .stats-label { color: var(--text-muted); font-weight: 500; margin-top: 5px; }

        /* --- GLOBAL SECTION --- */
        .section-padding { padding: 100px 0; }
        .section-tag { background: rgba(0, 86, 179, 0.1); color: var(--primary); padding: 5px 15px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; display: inline-block; margin-bottom: 15px; }
        .section-title { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; }
        .section-subtitle { color: var(--text-muted); max-width: 600px; margin: 0 auto 50px auto; font-size: 1.05rem; }

        /* --- LAYANAN --- */
        #layanan { background: white; }
        .service-card {
            background: var(--light-bg);
            border-radius: 16px;
            padding: 40px 30px;
            border: 1px solid transparent;
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 0;
            background: var(--primary-gradient);
            border-radius: 0 0 4px 0;
            transition: height 0.4s ease;
        }
        .service-card:hover { background: white; border-color: rgba(0,86,179,0.1); box-shadow: 0 20px 40px rgba(0,86,179,0.08); transform: translateY(-5px); }
        .service-card:hover::before { height: 100%; }
        .service-icon { width: 65px; height: 65px; background: white; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .service-card h5 { font-weight: 700; margin-bottom: 15px; font-size: 1.2rem; }
        .service-link { color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 5px; margin-top: 15px; transition: gap 0.3s; }
        .service-link:hover { gap: 10px; color: var(--primary); }

        /* --- TENTANG --- */
        #tentang { background: var(--light-bg); }
        .about-img-main { border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .about-img-secondary { position: absolute; bottom: -30px; right: -30px; width: 50%; border-radius: 20px; border: 5px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .about-list { list-style: none; padding: 0; }
        .about-list li { margin-bottom: 15px; display: flex; align-items: flex-start; gap: 15px; }
        .about-list i { color: var(--primary); margin-top: 5px; font-size: 1.2rem; }

        /* --- DOKTER --- */
        #dokter { background: white; }
        .doctor-card { text-align: center; background: var(--light-bg); border-radius: 16px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
        .doctor-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .doctor-img { width: 100%; height: 350px; object-fit: cover; transition: transform 0.5s; }
        .doctor-card:hover .doctor-img { transform: scale(1.05); }
        .doctor-content { padding: 25px; background: white; border-radius: 0 0 16px 16px; }

        /* --- CTA SECTION --- */
        .cta-section {
            background: var(--primary-gradient);
            color: white;
            border-radius: 24px;
            padding: 80px 60px;
            position: relative;
            overflow: hidden;
        }
        .cta-pattern { position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border: 20px solid rgba(255,255,255,0.1); border-radius: 50%; }
        .btn-white-premium { background: white; color: var(--primary); border-radius: 8px; padding: 15px 40px; font-weight: 800; font-size: 1.1rem; transition: transform 0.3s, box-shadow 0.3s; }
        .btn-white-premium:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); color: var(--primary); }

        /* --- FOOTER --- */
        footer { background: var(--dark); color: #94a3b8; }
        footer h5 { color: white; font-weight: 700; margin-bottom: 25px; font-size: 1.1rem; }
        footer a { color: #94a3b8; text-decoration: none; transition: color 0.3s; display: block; margin-bottom: 10px; }
        footer a:hover { color: white; }
        .footer-logo { height: 45px; background: white; padding: 8px 15px; border-radius: 8px; margin-bottom: 20px; }
        .social-icon { display: inline-flex; width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: white; border-radius: 8px; align-items: center; justify-content: center; margin-right: 10px; transition: background 0.3s; }
        .social-icon:hover { background: var(--primary); }

        /* --- WHATSAPP FLOAT --- */
        .whatsapp-float {
            position: fixed; width: 65px; height: 65px; bottom: 30px; right: 30px;
            background-color: #25d366; color: #FFF; border-radius: 16px; font-size: 30px;
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4); z-index: 100;
            display: flex; align-items: center; justify-content: center; transition: transform 0.3s;
        }
        .whatsapp-float:hover { color: white; transform: scale(1.1) translateY(-3px); }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo (2).png') }}" alt="D'SMILE Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#dokter">Dokter</a></li>
                    <li class="nav-item ms-4">
                        <a href="#appointment-section" class="btn btn-appointment-nav">Appointment</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-shape"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200">
                    <div class="hero-tag">✨ Premium Dental Clinic</div>
                    <h1 class="hero-title">Senyum Sempurna <br><span class="gradient-text">Dimulai di D'SMILE</span></h1>
                    <p class="hero-desc">— Your Smile, Our Priority — Menghadirkan perawatan gigi bermutu dengan peralatan berstandar internasional dan sentuhan personalized.</p>
                    <a href="#appointment-section" class="btn btn-hero-primary me-3 mb-2">Appointment <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="#layanan" class="btn btn-hero-outline mb-2">Lihat Layanan</a>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="1200">
                    <div class="hero-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?q=80&w=800&auto=format&fit=crop" alt="Dokter Gigi D'SMILE" class="hero-img">
                        
                        <!-- Kartu Mengambang -->
                        <div class="floating-card floating-card-bottom" data-aos="fade-up" data-aos-delay="800">
                            <div class="floating-card-icon"><i class="fas fa-star"></i></div>
                            <div>
                                <strong style="color: var(--dark);">4.9/5 Rating</strong>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">1000+ Pasien Puas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-card">
                        <div class="stats-number">5+</div>
                        <div class="stats-label">Tahun Pengalaman</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-card">
                        <div class="stats-number">5K+</div>
                        <div class="stats-label">Pasien Bahagia</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-card">
                        <div class="stats-number">5+</div>
                        <div class="stats-label">Dokter Spesialis</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-card">
                        <div class="stats-number">10+</div>
                        <div class="stats-label">Jenis Perawatan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <    <!-- Layanan Section -->
    <section id="layanan" class="section-padding">
        <div class="container text-center">
            <div class="section-tag">Layanan Kami</div>
            <h2 class="section-title">Perawatan Gigi Terlengkap</h2>
            <p class="section-subtitle">Pilihan perawatan komprehensif dengan teknologi modern untuk memastikan senyum terbaik Anda.</p>
            
            <div class="row g-4 text-start">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-teeth-open"></i></div>
                        <h5>Behel Gigi</h5>
                        <p class="text-muted small">Perapian gigi dengan kawat gigi konvensional atau transparan.</p>
                        <a href="{{ route('layanan.detail', 'behel-gigi') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-sun"></i></div>
                        <h5>Bleaching Gigi</h5>
                        <p class="text-muted small">Pemutihan gigi untuk mendapatkan senyum cerah dan memikat.</p>
                        <a href="{{ route('layanan.detail', 'bleaching-gigi') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-teeth"></i></div>
                        <h5>Gigi Tiruan</h5>
                        <p class="text-muted small">Solusi gigi palsu untuk mengembalikan fungsi senyum dan gigitan.</p>
                        <a href="{{ route('layanan.detail', 'gigi-tiruan') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-hand-holding-medical"></i></div>
                        <h5>Gum Lifting</h5>
                        <p class="text-muted small">Perbaikan kontur gusi untuk senyum yang lebih proporsional.</p>
                        <a href="{{ route('layanan.detail', 'gum-lifting') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-gem"></i></div>
                        <h5>Veneer</h5>
                        <p class="text-muted small">Lapisan tipis untuk memperbaiki warna, bentuk, dan ukuran gigi.</p>
                        <a href="{{ route('layanan.detail', 'veneer') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-tooth"></i></div>
                        <h5>Tambal Gigi</h5>
                        <p class="text-muted small">Perbaikan gigi berlubang dengan material berkualitas tinggi.</p>
                        <a href="{{ route('layanan.detail', 'tambal-gigi') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-hand-scissors"></i></div>
                        <h5>Pencabutan Gigi</h5>
                        <p class="text-muted small">Prosedur pencabutan yang aman, steril, dan minim rasa sakit.</p>
                        <a href="{{ route('layanan.detail', 'pencabutan-gigi') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-broom"></i></div>
                        <h5>Scaling Gigi</h5>
                        <p class="text-muted small">Pembersihan karang gigi untuk menjaga kesehatan gusi dan mulut.</p>
                        <a href="{{ route('layanan.detail', 'scaling-gigi') }}" class="service-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Dokter Section -->
    <section id="dokter" class="section-padding">
        <div class="container text-center">
            <div class="section-tag">Tim Profesional</div>
            <h2 class="section-title">Dokter Gigi Ahli Kami</h2>
            <p class="section-subtitle">Senyum terbaik Anda ditangani oleh tangan-tangan terampil dan berpengalaman.</p>
            
            <!-- Baris Pertama (3 Dokter) -->
            <div class="row g-4 justify-content-center mb-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Andi"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Andi Pratama, Sp.Ort</h5>
                            <span class="text-muted small">Spesialis Ortodonti</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Sari"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Sari Dewi, KG</h5>
                            <span class="text-muted small">Perawatan Umum & Estetika</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Budi"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Budi Santoso, Sp.Pros</h5>
                            <span class="text-muted small">Spesialis Gigi Tiruan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris Kedua (3 Dokter) -->
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1614608682850-e0d6ed316d47?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Rina"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Rina Wati, Sp.Perio</h5>
                            <span class="text-muted small">Spesialis Penyakit Gusi</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Dimas"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Dimas Pratama, Sp.BM</h5>
                            <span class="text-muted small">Spesialis Bedah Mulut</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="doctor-card">
                        <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1551836022-deb4988cc6c0?q=80&w=600&auto=format&fit=crop" class="doctor-img" alt="Drg. Ayu"></div>
                        <div class="doctor-content">
                            <h5 class="mb-1 fw-bold">Drg. Ayu Lestari, Sp.KGA</h5>
                            <span class="text-muted small">Dokter Gigi Anak</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="appointment-section" class="section-padding" style="background: var(--light-bg);">
        <div class="container" data-aos="zoom-in" data-aos-duration="800">
            <div class="cta-section text-center position-relative">
                <div class="cta-pattern"></div>
                <div class="position-relative" style="z-index: 2;">
                    <h2 class="fw-bold mb-3 display-5">Siap Mendapatkan Senyum Impian?</h2>
                    <p class="mb-4 fs-5 opacity-75">Jangan tunda lagi, jadwalkan kunjungan Anda ke D'SMILE hari ini!</p>
                    <a href="{{ route('login') }}" class="btn btn-white-premium btn-lg">
                        <i class="fas fa-calendar-check me-2"></i> Login untuk Buat Janji
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{ asset('images/logo (2).png') }}" alt="D'SMILE Logo" class="footer-logo">
                    <p class="small">— Your Smile, Our Priority — Klinik gigi terpercaya untuk perawatan gigi profesional dan nyaman.</p>
                </div>
                <div class="col-lg-2 mb-4 mb-lg-0">
                    <h5>Quick Links</h5>
                    <a href="#layanan">Layanan</a>
                    <a href="#tentang">Tentang Kami</a>
                    <a href="#dokter">Dokter</a>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <h5>Jam Operasional</h5>
                    <a href="#">Senin - Jumat: 09.00 - 21.00</a>
                    <a href="#">Sabtu: 09.00 - 17.00</a>
                    <a href="#">Minggu: Tutup</a>
                </div>
                <div class="col-lg-3">
                    <h5>Hubungi Kami</h5>
                    <a href="#"><i class="fas fa-map-marker-alt me-2"></i> Jl. Senyum Bahagia No. 12</a>
                    <a href="#"><i class="fas fa-phone me-2"></i> (021) 1234-5678</a>
                    <a href="#"><i class="fas fa-envelope me-2"></i> info@dsmile.co.id</a>
                </div>
            </div>
            <hr style="border-color: #334155; margin: 30px 0 20px 0;">
            <div class="text-center small" style="color: #64748b;">
                &copy; 2024 D'SMILE Dental Clinic. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });

        window.addEventListener('scroll', function() {
            let navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>