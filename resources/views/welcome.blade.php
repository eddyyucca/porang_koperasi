<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Barakat Pangan Banua - Bersama Tumbuh, Bersama Sejahtera</title>
    <meta name="description" content="Koperasi Barakat Pangan Banua – pusat pengelolaan dan pemasaran tanaman porang terpercaya di Indonesia">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
        /* ============================================================
           CSS VARIABLES & RESET
        ============================================================ */
        :root {
            --green-dark:   #1a4d2e;
            --green:        #2d6a2d;
            --green-mid:    #3a7d44;
            --green-light:  #5a9e5a;
            --green-pale:   #d4edda;
            --yellow:       #f5c518;
            --yellow-dark:  #e8a805;
            --yellow-pale:  #fff8e1;
            --brown:        #6b3a2a;
            --brown-mid:    #8b5a2b;
            --brown-light:  #c8956c;
            --brown-pale:   #f5ebe0;
            --cream:        #faf7f2;
            --white:        #ffffff;
            --text-dark:    #1a1a1a;
            --text-mid:     #4a4a4a;
            --text-light:   #7a7a7a;
            --shadow-sm:    0 2px 8px rgba(0,0,0,.08);
            --shadow-md:    0 8px 24px rgba(0,0,0,.12);
            --shadow-lg:    0 20px 60px rgba(0,0,0,.18);
            --radius-sm:    8px;
            --radius-md:    16px;
            --radius-lg:    24px;
            --radius-xl:    40px;
            --transition:   all .35s cubic-bezier(.4,0,.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; font-size: 16px; }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        img { max-width: 100%; height: auto; display: block; }
        a  { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ============================================================
           NAVBAR
        ============================================================ */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 20px 0;
            transition: var(--transition);
        }

        #navbar.scrolled {
            background: rgba(26, 77, 46, .97);
            backdrop-filter: blur(12px);
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,.2);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo-icon {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--yellow), var(--yellow-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(245,197,24,.4);
            flex-shrink: 0;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-text strong {
            color: var(--white);
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .nav-logo-text span {
            color: var(--yellow);
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .nav-links a {
            color: rgba(255,255,255,.85);
            font-size: .88rem;
            font-weight: 500;
            position: relative;
            padding-bottom: 4px;
            transition: var(--transition);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background: var(--yellow);
            border-radius: 2px;
            transition: width .3s ease;
        }

        .nav-links a:hover { color: var(--white); }
        .nav-links a:hover::after { width: 100%; }

        /* CTA button */
        .nav-cta {
            background: var(--yellow);
            color: var(--green-dark) !important;
            font-weight: 700 !important;
            padding: 10px 22px;
            border-radius: 50px;
            box-shadow: 0 4px 16px rgba(245,197,24,.35);
            transition: var(--transition) !important;
        }

        .nav-cta::after { display: none !important; }

        .nav-cta:hover {
            background: var(--yellow-dark) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245,197,24,.45) !important;
        }

        /* Hamburger */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
        }

        .nav-toggle span {
            display: block;
            width: 26px; height: 2.5px;
            background: var(--white);
            border-radius: 2px;
            transition: var(--transition);
        }

        .nav-toggle.open span:nth-child(1) { transform: translateY(7.5px) rotate(45deg); }
        .nav-toggle.open span:nth-child(2) { opacity: 0; }
        .nav-toggle.open span:nth-child(3) { transform: translateY(-7.5px) rotate(-45deg); }

        /* Mobile menu */
        @media (max-width: 900px) {
            .nav-toggle { display: flex; }

            .nav-links {
                position: fixed;
                top: 0; right: -100%;
                width: min(320px, 85vw);
                height: 100vh;
                background: var(--green-dark);
                flex-direction: column;
                align-items: flex-start;
                padding: 100px 36px 40px;
                gap: 28px;
                transition: right .4s cubic-bezier(.4,0,.2,1);
                box-shadow: -8px 0 40px rgba(0,0,0,.3);
            }

            .nav-links.open { right: 0; }

            .nav-links a { font-size: 1rem; }

            .nav-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 999;
                opacity: 0;
                pointer-events: none;
                transition: opacity .4s;
            }

            .nav-overlay.open {
                opacity: 1;
                pointer-events: all;
            }
        }

        /* ============================================================
           SHARED SECTION STYLES
        ============================================================ */
        section { position: relative; }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--green-pale);
            color: var(--green-dark);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 16px;
        }

        .section-label i { color: var(--green-mid); }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            line-height: 1.2;
            color: var(--green-dark);
            margin-bottom: 16px;
        }

        .section-title span { color: var(--yellow-dark); }

        .section-desc {
            font-size: 1rem;
            color: var(--text-mid);
            line-height: 1.8;
            max-width: 560px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: .95rem;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            color: var(--white);
            box-shadow: 0 6px 24px rgba(45,106,45,.35);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(45,106,45,.45);
        }

        .btn-secondary {
            background: var(--yellow);
            color: var(--green-dark);
            box-shadow: 0 6px 24px rgba(245,197,24,.3);
        }

        .btn-secondary:hover {
            background: var(--yellow-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(245,197,24,.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--white);
            color: var(--white);
        }

        .btn-outline:hover {
            background: var(--white);
            color: var(--green-dark);
            transform: translateY(-3px);
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(255,255,255,.1);
            border-radius: 50px;
            padding: 4px 10px;
            margin-left: 8px;
            flex-shrink: 0;
        }
        .lang-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,.6);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 50px;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }
        .lang-btn.active, .lang-btn:hover {
            color: var(--white);
            background: rgba(255,255,255,.15);
        }
        .lang-sep { color: rgba(255,255,255,.3); font-size: .7rem; }

        /* Decorative wave divider */
        .wave-divider { line-height: 0; overflow: hidden; }
        .wave-divider svg { display: block; width: 100%; }

    </style>
</head>
<body>

<!-- ============================================================
     NAVBAR
============================================================ -->
<div class="nav-overlay" id="navOverlay"></div>

<nav id="navbar">
    <div class="container">
        <div class="nav-inner">
            <!-- Logo -->
            <a href="#home" class="nav-logo">
                <div class="nav-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 22s4-4 8-7c2.5-1.8 5-3 8-3 0 4-2 7-6 9-3.3 1.7-7 1.7-10 1z"/><path d="M2 22c0-4 2-8 6-10"/></svg>
                </div>
                <div class="nav-logo-text">
                    <strong>Koperasi Barakat</strong>
                    <span>Pangan Banua</span>
                </div>
            </a>

            <!-- Links -->
            <ul class="nav-links" id="navLinks">
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#statistics">Data &amp; Statistik</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#kelompok-tani">Kelompok Tani</a></li>
                <li><a href="#join">Bergabung</a></li>
                <li><a href="{{ route('login') }}" class="nav-cta" data-i18n="nav_login">Masuk Sistem</a></li>
            </ul>

            <!-- Language switcher -->
            <div class="lang-switcher" id="langSwitcher">
                <button class="lang-btn active" data-lang="id">ID</button>
                <span class="lang-sep">|</span>
                <button class="lang-btn" data-lang="en">EN</button>
            </div>

            <!-- Hamburger -->
            <div class="nav-toggle" id="navToggle">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
</nav>

{{-- ============================================================
     PLACEHOLDER SECTIONS (akan diisi bertahap)
============================================================ --}}

<main id="home">
    <!-- ============================================================
         HERO SECTION
    ============================================================ -->
    <section id="hero" style="
        min-height: 100vh;
        background: linear-gradient(160deg, #0d3320 0%, #1a4d2e 40%, #2d6a2d 75%, #3a7d44 100%);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding-top: 80px;
    ">
        <!-- Animated background blobs -->
        <div class="hero-blobs">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <!-- Decorative dots grid -->
        <div class="hero-dots"></div>

        <div class="container" style="position:relative;z-index:2;">
            <div class="hero-grid">
                <!-- LEFT: Text -->
                <div class="hero-text" data-aos="fade-right">
                    <div class="hero-badge">
                        <span class="badge-dot"></span>
                        Koperasi Resmi Terdaftar &bull; Est. 2018
                    </div>

                    <h1 class="hero-title">
                        Koperasi Petani<br>
                        <span class="hero-title-accent">Barakat Pangan Banua</span>
                    </h1>

                    <p class="hero-subtitle">
                        Wadah bersama petani porang Indonesia — kami menghubungkan Anda
                        dengan pasar, mendampingi budidaya, dan mengelola hasil panen secara transparan.
                        Bergabunglah, tumbuh bersama kami.
                    </p>

                    <!-- Quick stats bar -->
                    <div class="hero-stats-bar">
                        <div class="hero-stat">
                            <strong>1.200+</strong>
                            <span data-i18n="hero_stat1">Petani Anggota</span>
                        </div>
                        <div class="hero-stat-div"></div>
                        <div class="hero-stat">
                            <strong>15+</strong>
                            <span data-i18n="hero_stat2">BUMDes Mitra</span>
                        </div>
                        <div class="hero-stat-div"></div>
                        <div class="hero-stat">
                            <strong>850 ton</strong>
                            <span data-i18n="hero_stat3">Panen/Tahun</span>
                        </div>
                    </div>

                    <div class="hero-actions">
                        <a href="{{ route('daftar') }}" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            Daftar Kelompok Tani
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Portal Anggota
                        </a>
                    </div>
                </div>

                <!-- RIGHT: Image card stack -->
                <div class="hero-visual" data-aos="fade-left" data-aos-delay="150">
                    <div class="hero-card-stack">
                        <!-- Main image -->
                        <div class="hero-img-main">
                            <img
                                src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=700&q=80"
                                alt="Petani Porang"
                                loading="eager"
                                onerror="this.src='https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?w=700&q=80'"
                            >
                            <div class="hero-img-overlay" onclick="document.getElementById('videoModal').style.display='flex'" style="cursor:pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="white"><circle cx="12" cy="12" r="10" fill="rgba(255,255,255,0.2)" stroke="white" stroke-width="1.5"/><polygon points="10 8 16 12 10 16 10 8" fill="white"/></svg>
                                <span>Lihat Video</span>
                            </div>
                        </div>

                        <!-- Floating card: anggota -->
                        <div class="float-card float-card-left">
                            <div class="float-card-icon" style="background:var(--yellow);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div>
                                <strong data-i18n="float1_strong">1.200+ Petani</strong>
                                <span data-i18n="float1_span">Aktif Bersama</span>
                            </div>
                        </div>

                        <!-- Floating card: pasar -->
                        <div class="float-card float-card-right">
                            <div class="float-card-icon" style="background:var(--green-light);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            </div>
                            <div>
                                <strong data-i18n="float2_strong">Harga Terjamin</strong>
                                <span data-i18n="float2_span">Akses Pasar Luas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom wave -->
        <div class="wave-divider" style="position:absolute;bottom:-1px;left:0;right:0;">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" fill="#faf7f2"/>
            </svg>
        </div>
    </section>

    <style>
        /* Hero blobs */
        .hero-blobs { position: absolute; inset: 0; pointer-events: none; }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .18;
        }
        .blob-1 { width: 500px; height: 500px; background: var(--yellow); top: -100px; right: -100px; animation: blobFloat 8s ease-in-out infinite; }
        .blob-2 { width: 400px; height: 400px; background: var(--green-light); bottom: -80px; left: -80px; animation: blobFloat 10s ease-in-out infinite reverse; }
        .blob-3 { width: 300px; height: 300px; background: var(--brown-light); top: 40%; left: 40%; animation: blobFloat 12s ease-in-out infinite 2s; }

        @keyframes blobFloat {
            0%,100% { transform: translate(0,0) scale(1); }
            33%      { transform: translate(20px,-30px) scale(1.05); }
            66%      { transform: translate(-15px,20px) scale(.95); }
        }

        /* Dots */
        .hero-dots {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.08) 1.5px, transparent 1.5px);
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* Hero grid */
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 60px 0;
        }

        /* Hero badge */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            backdrop-filter: blur(8px);
            color: rgba(255,255,255,.9);
            font-size: .8rem;
            font-weight: 500;
            padding: 8px 18px;
            border-radius: 50px;
            margin-bottom: 24px;
            letter-spacing: .04em;
        }
        .badge-dot {
            width: 8px; height: 8px;
            background: var(--yellow);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(245,197,24,.5); }
            50%      { box-shadow: 0 0 0 6px rgba(245,197,24,0); }
        }

        /* Hero title */
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4.5vw, 3.8rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 20px;
        }
        .hero-title-accent {
            background: linear-gradient(90deg, var(--yellow), #ffdd44);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Hero subtitle */
        .hero-subtitle {
            font-size: 1.05rem;
            color: rgba(255,255,255,.75);
            line-height: 1.8;
            margin-bottom: 36px;
            max-width: 480px;
        }

        /* Hero stats bar */
        .hero-stats-bar {
            display: flex;
            align-items: center;
            gap: 24px;
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: var(--radius-md);
            padding: 18px 28px;
            margin-bottom: 36px;
            width: fit-content;
        }
        .hero-stat { text-align: center; }
        .hero-stat strong { display: block; font-size: 1.35rem; font-weight: 800; color: var(--yellow); }
        .hero-stat span { font-size: .75rem; color: rgba(255,255,255,.7); font-weight: 500; }
        .hero-stat-div { width: 1px; height: 36px; background: rgba(255,255,255,.2); }

        /* Hero actions */
        .hero-actions { display: flex; gap: 16px; flex-wrap: wrap; }

        /* Hero visual */
        .hero-card-stack { position: relative; }

        .hero-img-main {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,.4);
            aspect-ratio: 4/3;
        }
        .hero-img-main img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .6s ease;
        }
        .hero-img-main:hover img { transform: scale(1.05); }

        .hero-img-overlay {
            position: absolute; inset: 0;
            background: rgba(26,77,46,.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            opacity: 0;
            transition: var(--transition);
            cursor: pointer;
            color: white;
        }
        .hero-img-overlay i { font-size: 3rem; }
        .hero-img-overlay span { font-weight: 600; font-size: .9rem; }
        .hero-img-main:hover .hero-img-overlay { opacity: 1; }

        /* Floating cards */
        .float-card {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 12px 18px;
            box-shadow: var(--shadow-lg);
            animation: floatUp 4s ease-in-out infinite;
        }
        .float-card-left  { bottom: 24px; left: -30px; }
        .float-card-right { top: 24px; right: -30px; animation-delay: 2s; }
        .float-card-icon  { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .float-card strong { display: block; font-size: .85rem; font-weight: 700; color: var(--text-dark); }
        .float-card span   { font-size: .75rem; color: var(--text-light); }

        @keyframes floatUp {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; gap: 40px; padding: 40px 0; min-height: auto; }
            .hero-visual { order: -1; }
            .hero-img-main { aspect-ratio: 16/9; }
            .float-card-left  { left: 10px; }
            .float-card-right { right: 10px; }
            .hero-stats-bar { width: 100%; justify-content: center; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2rem; }
            .hero-stats-bar { flex-direction: column; gap: 16px; }
            .hero-stat-div { width: 60px; height: 1px; }
            .hero-actions { flex-direction: column; }
            .hero-actions .btn { justify-content: center; }
        }
    </style>
    <!-- ============================================================
         ABOUT SECTION
    ============================================================ -->
    <section id="about" style="background:var(--cream); padding:100px 0;">
        <div class="container">
            <div class="about-grid">
                <!-- Left: Images collage -->
                <div class="about-images" data-aos="fade-right">
                    <div class="about-img-main">
                        <img src="https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?w=600&q=80"
                             alt="Petani Porang"
                             onerror="this.src='https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?w=600&q=80'">
                    </div>
                    <div class="about-img-small">
                        <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=300&q=80"
                             alt="Umbi Porang"
                             onerror="this.src='https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=300&q=80'">
                    </div>
                    <div class="about-badge-years">
                        <strong>6+</strong>
                        <span>Tahun<br>Berpengalaman</span>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="about-content" data-aos="fade-left" data-aos-delay="100">
                    <div class="section-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 1 10 10c0 5.52-4.48 10-10 10S2 17.52 2 12c0-2.76 1.12-5.26 2.93-7.07"/><path d="M12 6v6l4 2"/></svg>
                        Tentang Kami
                    </div>
                    <h2 class="section-title">
                        Bukan Pengolah — <span>Tapi Kekuatan</span><br>di Balik Petani Porang
                    </h2>
                    <p class="section-desc" style="margin-bottom:20px;">
                        Koperasi Barakat Pangan Banua bukan unit pengolahan hasil panen. Kami adalah
                        <strong>wadah organisasi petani porang</strong> — mengelola keanggotaan, membangun
                        jaringan pasar, dan memastikan setiap petani mendapat harga yang adil dan layanan yang profesional.
                    </p>
                    <p class="section-desc" style="margin-bottom:36px; font-size:.93rem; color:var(--text-mid);">
                        Siapa pun bisa bergabung — petani aktif, calon petani, pemilik lahan, maupun
                        kelompok tani. Bersama, kita bangun ekosistem porang yang kuat dari hulu.
                        Porang (<em>Amorphophallus muelleri</em>) adalah komoditas ekspor bernilai tinggi
                        yang masa depannya sangat menjanjikan.
                    </p>

                    <!-- Value pills -->
                    <div class="about-values">
                        <div class="value-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Transparan &amp; Akuntabel
                        </div>
                        <div class="value-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Berbasis Digital
                        </div>
                        <div class="value-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Terbuka untuk Semua
                        </div>
                        <div class="value-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Berorientasi Petani
                        </div>
                    </div>

                    <a href="#join" class="btn btn-primary" style="margin-top:36px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Bergabung Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         STATISTICS SECTION
    ============================================================ -->
    <section id="statistics" style="background: linear-gradient(135deg,#1a4d2e,#2d6a2d); padding:80px 0; position:relative; overflow:hidden;">
        <!-- Decorative circles -->
        <div style="position:absolute;top:-60px;right:-60px;width:300px;height:300px;border-radius:50%;border:60px solid rgba(255,255,255,.04);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-80px;left:-80px;width:400px;height:400px;border-radius:50%;border:80px solid rgba(255,255,255,.04);pointer-events:none;"></div>

        <div class="container" style="position:relative;z-index:2;">
            <div style="text-align:center;margin-bottom:56px;" data-aos="fade-up">
                <div class="section-label" style="background:rgba(255,255,255,.12);color:var(--yellow);justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span data-i18n="stats_label">Data &amp; Statistik</span>
                </div>
                <h2 class="section-title" style="color:var(--white);">
                    Angka yang <span style="color:var(--yellow);">Bicara</span> untuk Kami
                </h2>
                <p style="color:rgba(255,255,255,.7);font-size:.97rem;line-height:1.8;max-width:500px;margin:0 auto;">
                    Pencapaian nyata Koperasi Barakat Pangan Banua yang terus tumbuh setiap tahunnya
                </p>
            </div>

            <!-- Counter cards -->
            <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="stat-num" data-target="1247">0</div>
                    <div class="stat-suffix" data-i18n="hero_stat1_unit">Petani</div>
                    <div class="stat-label" data-i18n="stat1_label">Anggota Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="stat-num" data-target="18">0</div>
                    <div class="stat-suffix">BUMDes</div>
                    <div class="stat-label" data-i18n="stat2_label">Mitra Desa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-6.88 17.25"/><line x1="8" y1="12" x2="12" y2="8"/><line x1="12" y1="8" x2="16" y2="12"/><line x1="12" y1="8" x2="12" y2="16"/></svg>
                    </div>
                    <div class="stat-num" data-target="856">0</div>
                    <div class="stat-suffix">Ton</div>
                    <div class="stat-label" data-i18n="stat3_label">Total Panen 2024</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="stat-num" data-target="12">0</div>
                    <div class="stat-suffix">Miliar</div>
                    <div class="stat-label" data-i18n="stat4_label">Omzet Tahunan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div class="stat-num" data-target="8">0</div>
                    <div class="stat-suffix" data-i18n="stat5_unit">Negara</div>
                    <div class="stat-label" data-i18n="stat5_label">Tujuan Ekspor</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><rect x="9" y="12" width="6" height="10" rx="1"/></svg>
                    </div>
                    <div class="stat-num" data-target="3420">0</div>
                    <div class="stat-suffix">Ha</div>
                    <div class="stat-label" data-i18n="stat6_label">Total Lahan</div>
                </div>
            </div>

            <!-- Chart area -->
            <div class="chart-area" data-aos="fade-up" data-aos-delay="200">
                <div class="chart-card">
                    <h3 style="color:var(--green-dark);font-size:1.1rem;font-weight:700;margin-bottom:4px;display:flex;align-items:center;gap:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span data-i18n="chart1_title">Tren Produksi Porang (2019–2024)</span>
                    </h3>
                    <p style="color:var(--text-light);font-size:.82rem;margin-bottom:20px;">Dalam satuan ton</p>
                    <canvas id="productionChart" height="100"></canvas>
                </div>
                <div class="chart-card">
                    <h3 style="color:var(--green-dark);font-size:1.1rem;font-weight:700;margin-bottom:4px;display:flex;align-items:center;gap:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--yellow-dark)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                        <span data-i18n="chart2_title">Distribusi Produk Porang</span>
                    </h3>
                    <p style="color:var(--text-light);font-size:.82rem;margin-bottom:20px;">Berdasarkan jenis olahan</p>
                    <canvas id="productChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* About grid */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-images { position: relative; }

        .about-img-main {
            border-radius: var(--radius-lg);
            overflow: hidden;
            aspect-ratio: 4/3;
            box-shadow: var(--shadow-lg);
        }
        .about-img-main img { width: 100%; height: 100%; object-fit: cover; }

        .about-img-small {
            position: absolute;
            bottom: -30px; right: -30px;
            width: 45%;
            border-radius: var(--radius-md);
            overflow: hidden;
            aspect-ratio: 1;
            border: 5px solid var(--white);
            box-shadow: var(--shadow-md);
        }
        .about-img-small img { width: 100%; height: 100%; object-fit: cover; }

        .about-badge-years {
            position: absolute;
            top: 24px; left: -24px;
            background: linear-gradient(135deg, var(--yellow), var(--yellow-dark));
            color: var(--green-dark);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            text-align: center;
            box-shadow: var(--shadow-md);
        }
        .about-badge-years strong { display: block; font-size: 1.8rem; font-weight: 900; line-height: 1; }
        .about-badge-years span   { font-size: .72rem; font-weight: 600; line-height: 1.4; }

        .about-values { display: flex; flex-wrap: wrap; gap: 10px; }
        .value-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            border: 1.5px solid var(--green-pale);
            color: var(--green-dark);
            font-size: .82rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 50px;
        }
        .value-pill i { color: var(--green-mid); }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: var(--radius-md);
            padding: 28px 16px;
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            background: rgba(255,255,255,.18);
            transform: translateY(-6px);
        }

        .stat-icon { font-size: 2rem; margin-bottom: 8px; }
        .stat-num {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--yellow);
            line-height: 1;
        }
        .stat-suffix { font-size: .75rem; color: var(--yellow); font-weight: 700; margin-bottom: 4px; }
        .stat-label  { font-size: .75rem; color: rgba(255,255,255,.65); }

        /* Charts */
        .chart-area {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 24px;
        }

        .chart-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 28px;
            box-shadow: var(--shadow-md);
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(3,1fr); }
        }

        @media (max-width: 900px) {
            .about-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-img-small { display: none; }
            .about-badge-years { left: 16px; }
            .chart-area { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: repeat(2,1fr); }
        }
    </style>
    <!-- ============================================================
         LAYANAN SECTION
    ============================================================ -->
    <section id="layanan" style="background:var(--white); padding:100px 0;">
        <div class="container">
            <div style="text-align:center;margin-bottom:56px;" data-aos="fade-up">
                <div class="section-label" style="justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    Layanan Koperasi
                </div>
                <h2 class="section-title">Apa yang Kami <span>Berikan untuk Anda</span></h2>
                <p class="section-desc" style="margin:0 auto;text-align:center;">
                    Sebagai anggota koperasi, Anda mendapatkan akses penuh ke berbagai layanan dan program
                    yang dirancang khusus untuk membantu petani porang tumbuh dan sejahtera.
                </p>
            </div>

            <!-- Layanan: 2x2 big cards with image + text -->
            <div class="layanan-grid">
                <!-- Layanan 1 -->
                <div class="layanan-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="layanan-img">
                        <img src="https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?w=600&q=80"
                             alt="Pendampingan Budidaya"
                             onerror="this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&q=80'">
                    </div>
                    <div class="layanan-body">
                        <div class="layanan-icon" style="background:var(--green-pale);color:var(--green);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-6.88 17.25"/><path d="M12 2v4"/><path d="M12 18v4"/><path d="M4.93 4.93l2.83 2.83"/><path d="M16.24 16.24l2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/><circle cx="12" cy="12" r="4"/></svg>
                        </div>
                        <h3>Pendampingan Budidaya</h3>
                        <p>Tim agronomi kami hadir langsung ke lahan — dari pemilihan bibit unggul, teknik tanam, hingga pengendalian hama agar panen optimal.</p>
                        <ul class="layanan-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Konsultasi teknis gratis
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Akses bibit porang bermutu
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Monitoring pertumbuhan digital
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Layanan 2 -->
                <div class="layanan-card" data-aos="fade-up" data-aos-delay="80">
                    <div class="layanan-img">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&q=80"
                             alt="Akses Pasar"
                             onerror="this.src='https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80'">
                    </div>
                    <div class="layanan-body">
                        <div class="layanan-icon" style="background:var(--yellow-pale);color:var(--yellow-dark);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <h3>Akses Pasar &amp; Pemasaran</h3>
                        <p>Hasil panen anggota kami salurkan ke jaringan pembeli yang sudah terpercaya — tanpa perantara berlebih, harga lebih adil untuk petani.</p>
                        <ul class="layanan-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Jaringan pembeli nasional
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Harga terjamin &amp; transparan
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Kontrak pembelian tertulis
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Layanan 3 -->
                <div class="layanan-card" data-aos="fade-up" data-aos-delay="160">
                    <div class="layanan-img">
                        <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=600&q=80"
                             alt="Layanan Keuangan"
                             onerror="this.src='https://images.unsplash.com/photo-1579621970588-a35d0e7ab9b6?w=600&q=80'">
                    </div>
                    <div class="layanan-body">
                        <div class="layanan-icon" style="background:var(--brown-pale);color:var(--brown);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                        <h3>Simpan Pinjam &amp; Modal Usaha</h3>
                        <p>Anggota koperasi mendapat akses fasilitas simpan pinjam berbunga rendah untuk modal tanam, pembelian pupuk, dan kebutuhan pertanian lainnya.</p>
                        <ul class="layanan-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Bunga ringan 0.8%/bulan
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Proses cepat &amp; mudah
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Cicilan fleksibel
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Layanan 4 -->
                <div class="layanan-card" data-aos="fade-up" data-aos-delay="240">
                    <div class="layanan-img">
                        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80"
                             alt="Pelatihan Petani"
                             onerror="this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=600&q=80'">
                    </div>
                    <div class="layanan-body">
                        <div class="layanan-icon" style="background:var(--green-pale);color:var(--green-mid);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                        <h3>Pelatihan &amp; Pengembangan</h3>
                        <p>Program pelatihan rutin — dari budidaya organik, manajemen panen, hingga literasi digital — agar petani terus berkembang dan kompetitif.</p>
                        <ul class="layanan-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Pelatihan bulanan gratis
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Studi banding lapangan
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Sertifikasi kompetensi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- CTA strip -->
            <div class="layanan-cta-strip" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <strong>Semua layanan terbuka untuk anggota koperasi</strong>
                    <span>Daftar sekarang dan mulai nikmati seluruh manfaatnya</span>
                </div>
                <a href="#join" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Daftar Anggota
                </a>
            </div>
        </div>
    </section>

    <style>
        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
            margin-bottom: 48px;
        }

        .layanan-card {
            display: flex;
            gap: 0;
            background: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1.5px solid #f0f0f0;
            transition: var(--transition);
            flex-direction: column;
        }
        .layanan-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: var(--green-pale);
        }

        .layanan-img {
            aspect-ratio: 16/7;
            overflow: hidden;
            flex-shrink: 0;
        }
        .layanan-img img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }
        .layanan-card:hover .layanan-img img { transform: scale(1.05); }

        .layanan-body { padding: 28px 28px 24px; }

        .layanan-icon {
            width: 52px; height: 52px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }

        .layanan-body h3 {
            font-size: 1.12rem;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 10px;
        }
        .layanan-body p {
            font-size: .88rem;
            color: var(--text-mid);
            line-height: 1.75;
            margin-bottom: 18px;
        }

        .layanan-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .layanan-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .84rem;
            color: var(--text-mid);
            font-weight: 500;
        }
        .layanan-list li svg { color: var(--green-mid); flex-shrink: 0; }

        .layanan-cta-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            background: linear-gradient(135deg, var(--green-pale), var(--yellow-pale));
            border: 1.5px solid var(--green-pale);
            border-radius: var(--radius-md);
            padding: 28px 36px;
        }
        .layanan-cta-strip strong { display: block; font-size: 1.05rem; color: var(--green-dark); font-weight: 700; margin-bottom: 4px; }
        .layanan-cta-strip span  { font-size: .85rem; color: var(--text-mid); }

        @media (max-width: 900px) {
            .layanan-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .layanan-cta-strip { flex-direction: column; text-align: center; }
            .layanan-body { padding: 20px; }
        }
    </style>
    <!-- ============================================================
         GALLERY SECTION
    ============================================================ -->
    <section id="gallery" style="background:var(--brown-pale); padding:100px 0;">
        <div class="container">
            <div style="text-align:center;margin-bottom:56px;" data-aos="fade-up">
                <div class="section-label" style="justify-content:center;background:rgba(107,58,42,.1);color:var(--brown);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Galeri &amp; Video
                </div>
                <h2 class="section-title">
                    Kehidupan Nyata <span>Petani Porang Kami</span>
                </h2>
                <p class="section-desc" style="margin:0 auto;text-align:center;">
                    Dokumentasi kegiatan budidaya, panen, pelatihan, dan kebersamaan anggota koperasi di lapangan
                </p>
            </div>

            <!-- Photo masonry grid -->
            <div class="gallery-grid" data-aos="fade-up">
                <div class="gallery-item gallery-large">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&q=80"
                         alt="Petani di ladang porang"
                         onerror="this.src='https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?w=800&q=80'">
                    <div class="gallery-caption">Petani Anggota di Lahan Porang</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&q=80"
                         alt="Ladang porang hijau"
                         onerror="this.src='https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&q=80'">
                    <div class="gallery-caption">Kebun Porang Anggota</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=400&q=80"
                         alt="Umbi porang segar"
                         onerror="this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400&q=80'">
                    <div class="gallery-caption">Umbi Porang Siap Panen</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&q=80"
                         alt="Lahan pertanian subur"
                         onerror="this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&q=80'">
                    <div class="gallery-caption">Lahan Subur Anggota</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&q=80"
                         alt="Rapat dan pelatihan"
                         onerror="this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400&q=80'">
                    <div class="gallery-caption">Pelatihan Anggota</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400&q=80"
                         alt="Panen porang"
                         onerror="this.src='https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?w=400&q=80'">
                    <div class="gallery-caption">Musim Panen Raya</div>
                </div>

                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?w=400&q=80"
                         alt="Rapat anggota koperasi"
                         onerror="this.src='https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&q=80'">
                    <div class="gallery-caption">Rapat Anggota Tahunan</div>
                </div>
            </div>

            <!-- Video section -->
            <div class="video-section" data-aos="fade-up" data-aos-delay="100">
                <div class="video-content">
                    <div class="section-label" style="background:rgba(107,58,42,.1);color:var(--brown);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                        Video Profil
                    </div>
                    <h3 style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:800;color:var(--green-dark);margin-bottom:16px;line-height:1.3;">
                        Mengenal Lebih Dekat<br><span style="color:var(--yellow-dark);">Koperasi Barakat Pangan Banua</span>
                    </h3>
                    <p style="color:var(--text-mid);font-size:.95rem;line-height:1.8;margin-bottom:28px;">
                        Saksikan kehidupan nyata petani porang anggota koperasi kami — dari menanam bibit,
                        merawat lahan, hingga panen dan mendapatkan hasil yang layak melalui jaringan koperasi.
                    </p>
                    <div class="video-highlights">
                        <div class="video-highlight">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Cara budidaya porang yang benar
                        </div>
                        <div class="video-highlight">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Peran koperasi dalam mendampingi petani
                        </div>
                        <div class="video-highlight">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Testimoni petani sukses bersama koperasi
                        </div>
                    </div>
                </div>

                <div class="video-embed-wrap">
                    <div class="video-embed-container">
                        <!-- YouTube embed: ganti URL dengan video porang yang sesuai -->
                        <iframe
                            src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1"
                            title="Video Profil Koperasi Barakat Pangan Banua"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                    <div class="video-play-note">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#ff0000"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>
                        Klik untuk memutar video profil
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Gallery grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto;
            gap: 16px;
            margin-bottom: 60px;
        }

        .gallery-large {
            grid-column: span 2;
            grid-row: span 2;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .gallery-large { aspect-ratio: auto; }

        .gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .gallery-item:hover img { transform: scale(1.08); }

        .gallery-caption {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(26,77,46,.85), transparent);
            color: var(--white);
            font-size: .78rem;
            font-weight: 600;
            padding: 20px 14px 10px;
            opacity: 0;
            transform: translateY(8px);
            transition: var(--transition);
        }

        .gallery-item:hover .gallery-caption { opacity: 1; transform: translateY(0); }

        /* Video section */
        .video-section {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 60px;
            align-items: center;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 48px;
            box-shadow: var(--shadow-md);
        }

        .video-highlights { display: flex; flex-direction: column; gap: 12px; }
        .video-highlight {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .9rem;
            color: var(--text-mid);
            font-weight: 500;
        }
        .video-highlight i { color: var(--green-mid); font-size: .85rem; }

        .video-embed-container {
            position: relative;
            padding-bottom: 56.25%;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }
        .video-embed-container iframe {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
        }

        .video-play-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
            font-size: .8rem;
            color: var(--text-light);
        }

        @media (max-width: 900px) {
            .gallery-grid { grid-template-columns: repeat(2,1fr); }
            .gallery-large { grid-column: span 2; aspect-ratio: 16/9; }
            .video-section { grid-template-columns: 1fr; gap: 32px; padding: 28px; }
        }

        @media (max-width: 600px) {
            .gallery-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        }
    </style>
    <!-- ============================================================
         BENEFITS SECTION
    ============================================================ -->
    <section style="background:var(--cream); padding:100px 0;">
        <div class="container">
            <div style="text-align:center;margin-bottom:56px;" data-aos="fade-up">
                <div class="section-label" style="justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <span data-i18n="benefits_label">Keunggulan Kami</span>
                </div>
                <h2 class="section-title"><span data-i18n="benefits_title">Mengapa Bergabung dengan <span>Koperasi Kami?</span></span></h2>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d6a2d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h4 data-i18n="b1_title">Pendampingan Penuh</h4>
                    <p data-i18n="b1_desc">Tim agronomis berpengalaman mendampingi petani dari penanaman hingga panen — gratis untuk seluruh anggota koperasi.</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="60">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#fff8e1,#ffe0b2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a805" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h4 data-i18n="b2_title">Harga Terjamin</h4>
                    <p data-i18n="b2_desc">Harga beli hasil panen lebih adil dan transparan — tanpa perantara tengkulak. Petani anggota mendapat keuntungan penuh.</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="120">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#e8eaf6,#c5cae9);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#5c6bc0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                    </div>
                    <h4 data-i18n="b3_title">Sistem Digital</h4>
                    <p data-i18n="b3_desc">Pantau lahan, jadwal panen, dan riwayat transaksi kapan saja via portal web koperasi yang mudah digunakan.</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="180">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#fce4ec,#f8bbd0);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e91e63" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <h4 data-i18n="b4_title">Akses Modal Usaha</h4>
                    <p data-i18n="b4_desc">Fasilitas simpan pinjam berbunga rendah khusus anggota untuk modal tanam, pupuk, dan kebutuhan pertanian lainnya.</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="240">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#e0f7fa,#b2ebf2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00838f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <h4 data-i18n="b5_title">Jaringan Pasar Luas</h4>
                    <p data-i18n="b5_desc">Hasil panen anggota tersalurkan ke jaringan pembeli nasional dan internasional yang sudah terbangun oleh koperasi.</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="benefit-icon" style="background:linear-gradient(135deg,#f3e5f5,#e1bee7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#7b1fa2" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <h4 data-i18n="b6_title">Pelatihan &amp; Edukasi</h4>
                    <p data-i18n="b6_desc">Workshop bulanan, studi banding lapangan, dan sertifikasi kompetensi pertanian — gratis untuk semua anggota aktif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PARTNERS SECTION
    ============================================================ -->
    <section style="background:var(--white); padding:80px 0;">
        <div class="container">
            <div style="text-align:center;margin-bottom:48px;" data-aos="fade-up">
                <div class="section-label" style="justify-content:center;background:rgba(107,58,42,.08);color:var(--brown);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <span data-i18n="partners_label">Mitra &amp; BUMDes</span>
                </div>
                <h2 class="section-title"><span data-i18n="partners_title">BUMDes <span>Mitra Kami</span></span></h2>
                <p class="section-desc" style="margin:0 auto;text-align:center;" data-i18n="partners_desc">
                    Bersinergi dengan BUMDes untuk pemerataan kesejahteraan di desa-desa penghasil porang
                </p>
            </div>

            <!-- BUMDes cards -->
            <div class="partners-grid" data-aos="fade-up" data-aos-delay="80">
                @php
                    $bumdes = [
                        ['name'=>'BUMDes Maju Bersama','village'=>'Desa Sumberejo, Madiun','members'=>87],
                        ['name'=>'BUMDes Porang Jaya','village'=>'Desa Gemarang, Ngawi','members'=>124],
                        ['name'=>'BUMDes Hijau Lestari','village'=>'Desa Bringin, Nganjuk','members'=>63],
                        ['name'=>'BUMDes Mandiri Sejati','village'=>'Desa Pelem, Madiun','members'=>95],
                        ['name'=>'BUMDes Tani Barokah','village'=>'Desa Kare, Madiun','members'=>78],
                        ['name'=>'BUMDes Porang Mas','village'=>'Desa Saradan, Madiun','members'=>112],
                    ];
                @endphp
                @foreach($bumdes as $b)
                <div class="partner-card">
                    <div class="partner-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <h4>{{ $b['name'] }}</h4>
                    <p>{{ $b['village'] }}</p>
                    <div class="partner-members">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        {{ $b['members'] }} <span data-i18n="member_word">Petani</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Logo strip -->
            <div style="margin-top:56px;text-align:center;" data-aos="fade-up">
                <p style="font-size:.82rem;color:var(--text-light);font-weight:600;letter-spacing:.08em;text-transform:uppercase;margin-bottom:24px;" data-i18n="supported_by">
                    Didukung &amp; Bermitra dengan
                </p>
                <div class="logo-strip">
                    <div class="logo-pill">Kementerian Pertanian RI</div>
                    <div class="logo-pill">BUMD Jawa Timur</div>
                    <div class="logo-pill">BRI Agriniaga</div>
                    <div class="logo-pill">Universitas Brawijaya</div>
                    <div class="logo-pill">Dinas Pertanian Madiun</div>
                    <div class="logo-pill">Gabungan Kelompok Tani</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         KELOMPOK TANI SECTION
    ============================================================ -->
    <section id="kelompok-tani" style="background: linear-gradient(180deg, var(--white) 0%, var(--green-pale) 100%); padding:100px 0;">
        <div class="container">
            <div data-aos="fade-up" style="text-align:center;margin-bottom:60px;">
                <div class="section-label" style="justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Kelompok Tani</span>
                </div>
                <h2 class="section-title">Bergabung sebagai <span>Kelompok Tani</span></h2>
                <p class="section-desc" style="margin:0 auto;text-align:center;">
                    Daftarkan kelompok tani Anda dan akses seluruh program pendampingan, pelatihan,
                    serta jaringan pasar yang telah koperasi bangun untuk petani porang Indonesia.
                </p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px;margin-bottom:60px;">
                <!-- Card: Apa itu Kelompok Tani -->
                <div data-aos="fade-up" data-aos-delay="0" style="
                    background:#fff;
                    border-radius:20px;
                    padding:32px 28px;
                    box-shadow:0 8px 32px rgba(0,0,0,.08);
                    border-top:4px solid var(--green-mid);
                ">
                    <div style="width:56px;height:56px;background:var(--green-pale);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--green-dark)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h4 style="font-size:1.1rem;font-weight:700;color:var(--green-dark);margin-bottom:12px;">Apa itu Kelompok Tani?</h4>
                    <p style="font-size:.9rem;color:var(--text-mid);line-height:1.7;">
                        Kelompok tani adalah kumpulan petani porang yang bersatu dalam satu wadah untuk
                        mengelola budidaya bersama, berbagi pengetahuan, dan memperkuat posisi tawar di pasar.
                        Berbeda dengan BUMDes, kelompok tani bisa diikuti oleh banyak petani dari satu desa atau dusun.
                    </p>
                </div>

                <!-- Card: Keuntungan -->
                <div data-aos="fade-up" data-aos-delay="100" style="
                    background:#fff;
                    border-radius:20px;
                    padding:32px 28px;
                    box-shadow:0 8px 32px rgba(0,0,0,.08);
                    border-top:4px solid var(--yellow);
                ">
                    <div style="width:56px;height:56px;background:var(--yellow-pale);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--yellow-dark)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <h4 style="font-size:1.1rem;font-weight:700;color:var(--green-dark);margin-bottom:12px;">Keuntungan Bergabung</h4>
                    <ul style="font-size:.9rem;color:var(--text-mid);line-height:1.8;padding-left:0;list-style:none;">
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:3px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Akses program pendampingan budidaya gratis
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:3px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Pelatihan rutin teknis pertanian porang
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:3px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Harga beli hasil panen terjamin & transparan
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:3px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Akses modal usaha & simpan pinjam koperasi
                        </li>
                    </ul>
                </div>

                <!-- Card: Persyaratan -->
                <div data-aos="fade-up" data-aos-delay="200" style="
                    background:#fff;
                    border-radius:20px;
                    padding:32px 28px;
                    box-shadow:0 8px 32px rgba(0,0,0,.08);
                    border-top:4px solid var(--green-light);
                ">
                    <div style="width:56px;height:56px;background:var(--green-pale);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--green-dark)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <h4 style="font-size:1.1rem;font-weight:700;color:var(--green-dark);margin-bottom:12px;">Persyaratan Pendaftaran</h4>
                    <ul style="font-size:.9rem;color:var(--text-mid);line-height:1.8;padding-left:0;list-style:none;">
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <span style="color:var(--green-mid);font-weight:700;">01</span>
                            Nama & data pengurus kelompok (ketua, sekretaris, bendahara)
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <span style="color:var(--green-mid);font-weight:700;">02</span>
                            Nomor telepon ketua yang aktif
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;">
                            <span style="color:var(--green-mid);font-weight:700;">03</span>
                            Lokasi desa/kecamatan kelompok tani
                        </li>
                        <li style="display:flex;gap:10px;align-items:flex-start;">
                            <span style="color:var(--green-mid);font-weight:700;">04</span>
                            SK pembentukan kelompok tani (jika ada)
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CTA Daftar Kelompok Tani -->
            <div data-aos="fade-up" style="
                background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
                border-radius: 24px;
                padding: 48px 40px;
                text-align: center;
                color: #fff;
                position: relative;
                overflow: hidden;
            ">
                <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-30px;left:-30px;width:120px;height:120px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
                <div style="position:relative;z-index:1;">
                    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,197,24,.2);border:1px solid rgba(245,197,24,.4);border-radius:50px;padding:6px 18px;font-size:.8rem;font-weight:600;color:var(--yellow);margin-bottom:20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Pendaftaran Gratis & Cepat
                    </div>
                    <h3 style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;margin-bottom:14px;line-height:1.3;">
                        Daftarkan Kelompok Tani Anda Sekarang
                    </h3>
                    <p style="font-size:.95rem;opacity:.85;max-width:480px;margin:0 auto 32px;line-height:1.7;">
                        Proses verifikasi 1–3 hari kerja. Ketua kelompok akan dihubungi langsung setelah pendaftaran disetujui.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:14px;justify-content:center;">
                        <a href="{{ route('daftar') }}" style="
                            display:inline-flex;align-items:center;gap:10px;
                            background:var(--yellow);color:var(--green-dark);
                            padding:14px 32px;border-radius:50px;
                            font-weight:700;font-size:1rem;
                            box-shadow:0 6px 24px rgba(245,197,24,.4);
                            transition:all .3s;text-decoration:none;
                        " onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            Daftar Kelompok Tani
                        </a>
                        <a href="#join" style="
                            display:inline-flex;align-items:center;gap:10px;
                            background:transparent;color:#fff;
                            padding:14px 32px;border-radius:50px;
                            font-weight:600;font-size:1rem;
                            border:2px solid rgba(255,255,255,.5);
                            transition:all .3s;text-decoration:none;
                        " onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='transparent'">
                            Pelajari Cara Bergabung
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         JOIN STEPS SECTION
    ============================================================ -->
    <section id="join" style="background:var(--cream); padding:100px 0;">
        <div class="container">
            <div style="text-align:center;margin-bottom:60px;" data-aos="fade-up">
                <div class="section-label" style="justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    <span data-i18n="join_label">Cara Bergabung</span>
                </div>
                <h2 class="section-title"><span data-i18n="join_title">3 Langkah Mudah <span>Menjadi Anggota</span></span></h2>
                <p class="section-desc" style="margin:0 auto;text-align:center;" data-i18n="join_desc">
                    Proses pendaftaran sederhana, cepat, dan tidak dipungut biaya apapun di awal
                </p>
            </div>

            <div class="steps-grid" data-aos="fade-up">
                <div class="step-card">
                    <div class="step-number">01</div>
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h4 data-i18n="step1_title">Isi Formulir Pendaftaran</h4>
                    <p data-i18n="step1_desc">Daftar melalui portal online kami atau langsung ke kantor koperasi terdekat. Siapkan KTP dan data lahan Anda.</p>
                </div>
                <div class="step-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </div>
                <div class="step-card">
                    <div class="step-number">02</div>
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h4 data-i18n="step2_title">Verifikasi &amp; Persetujuan</h4>
                    <p data-i18n="step2_desc">Tim koperasi akan memverifikasi data Anda dalam 1–3 hari kerja. Anda akan mendapat notifikasi persetujuan via telepon atau WhatsApp.</p>
                </div>
                <div class="step-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </div>
                <div class="step-card">
                    <div class="step-number">03</div>
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <h4 data-i18n="step3_title">Aktif sebagai Anggota</h4>
                    <p data-i18n="step3_desc">Setelah disetujui, Anda resmi menjadi anggota dan langsung dapat mengakses seluruh layanan, pendampingan, dan program koperasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         CTA SECTION
    ============================================================ -->
    <section id="contact" style="padding:0;">
        <div class="cta-section">
            <div class="cta-bg"></div>
            <div class="container" style="position:relative;z-index:2;">
                <div class="cta-inner" data-aos="zoom-in">
                    <div class="cta-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--yellow)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:var(--white);margin-bottom:16px;line-height:1.2;" data-i18n="cta_title">
                        Siap Bergabung Bersama Kami?
                    </h2>
                    <p style="color:rgba(255,255,255,.8);font-size:1rem;line-height:1.8;max-width:520px;margin:0 auto 36px;" data-i18n="cta_desc">
                        Jadilah bagian dari ribuan petani yang telah merasakan manfaat nyata bersama Koperasi Barakat Pangan Banua. Daftarkan diri Anda sekarang — gratis!
                    </p>
                    <div class="cta-actions">
                        <a href="{{ route('daftar') }}" class="btn btn-secondary" style="font-size:1rem;padding:15px 32px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            <span data-i18n="cta_btn_register">Daftar Kelompok Tani</span>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn btn-outline" style="font-size:1rem;padding:15px 32px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            <span data-i18n="cta_btn_wa">Chat WhatsApp</span>
                        </a>
                    </div>
                    <div class="cta-contact-row">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.58 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.87-1.87a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            (0351) 123-4567
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            info@barakatpanganbanua.com
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Jl. Raya Porang No.1, Madiun
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Steps */
        .steps-grid {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr;
            gap: 16px;
            align-items: center;
            max-width: 900px;
            margin: 0 auto;
        }
        .step-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 32px 24px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            border: 1.5px solid #f0f0f0;
            transition: var(--transition);
            position: relative;
        }
        .step-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); border-color: var(--green-pale); }
        .step-number {
            position: absolute;
            top: -14px; left: 50%; transform: translateX(-50%);
            background: var(--green-dark);
            color: var(--white);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            padding: 4px 12px;
            border-radius: 50px;
        }
        .step-icon {
            width: 68px; height: 68px;
            background: var(--green-pale);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 8px auto 16px;
            color: var(--green-dark);
        }
        .step-card h4 { font-size: 1rem; font-weight: 700; color: var(--green-dark); margin-bottom: 10px; }
        .step-card p  { font-size: .84rem; color: var(--text-mid); line-height: 1.7; }
        .step-arrow { display: flex; justify-content: center; }

        /* CTA icon */
        .cta-icon-wrap {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            border: 2px solid rgba(245,197,24,.4);
        }

        @media (max-width: 768px) {
            .steps-grid { grid-template-columns: 1fr; max-width: 400px; }
            .step-arrow { transform: rotate(90deg); }
        }
    </style>

    <!-- ============================================================
         FOOTER
    ============================================================ -->
    <footer style="background:#0d1f14; color:rgba(255,255,255,.7); padding:60px 0 0;">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 22s4-4 8-7c2.5-1.8 5-3 8-3 0 4-2 7-6 9-3.3 1.7-7 1.7-10 1z"/><path d="M2 22c0-4 2-8 6-10"/></svg>
                        </div>
                        <div>
                            <strong style="color:var(--white);font-size:1.1rem;">Koperasi Barakat</strong>
                            <span style="display:block;color:var(--yellow);font-size:.72rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">Pangan Banua</span>
                        </div>
                    </div>
                    <p style="font-size:.87rem;line-height:1.8;margin:20px 0;" data-i18n="footer_tagline">
                        Wadah bersama petani porang Indonesia — transparan, profesional, dan berpihak pada kesejahteraan anggota.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-btn" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="YouTube">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0d1f14"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" class="social-btn" aria-label="WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div class="footer-col">
                    <h5 data-i18n="footer_menu">Menu Utama</h5>
                    <ul>
                        <li><a href="#about" data-i18n="nav_about">Tentang Kami</a></li>
                        <li><a href="#statistics" data-i18n="nav_stats">Data &amp; Statistik</a></li>
                        <li><a href="#layanan" data-i18n="nav_service">Layanan</a></li>
                        <li><a href="#gallery" data-i18n="nav_gallery">Galeri</a></li>
                        <li><a href="#join" data-i18n="nav_join">Bergabung</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5 data-i18n="footer_service">Layanan Koperasi</h5>
                    <ul>
                        <li><a href="#layanan" data-i18n="fs1">Pendampingan Budidaya</a></li>
                        <li><a href="#layanan" data-i18n="fs2">Akses Pasar &amp; Harga</a></li>
                        <li><a href="#layanan" data-i18n="fs3">Simpan Pinjam</a></li>
                        <li><a href="#layanan" data-i18n="fs4">Pelatihan Petani</a></li>
                        <li><a href="{{ route('login') }}" data-i18n="fs5">Portal Anggota</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5 data-i18n="footer_contact">Kontak Kami</h5>
                    <ul class="footer-contacts">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Jl. Raya Porang No.1<br>Madiun, Jawa Timur 63151
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.58 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.87-1.87a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            (0351) 123-4567
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            info@barakatpanganbanua.com
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span data-i18n="office_hours">Senin–Jumat, 08.00–17.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer bottom -->
        <div style="border-top:1px solid rgba(255,255,255,.08);margin-top:48px;padding:20px 0;">
            <div class="container" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <p style="font-size:.8rem;" data-i18n="copyright">© {{ date('Y') }} Koperasi Barakat Pangan Banua. Hak Cipta Dilindungi.</p>
                <div style="display:flex;gap:20px;">
                    <a href="#" style="font-size:.78rem;color:rgba(255,255,255,.5);transition:color .3s;" data-i18n="privacy">Kebijakan Privasi</a>
                    <a href="#" style="font-size:.78rem;color:rgba(255,255,255,.5);transition:color .3s;" data-i18n="terms">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <button id="backTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Kembali ke atas">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
    </button>

    <style>
        /* Benefits */
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 24px;
        }
        .benefit-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 32px 28px;
            box-shadow: var(--shadow-sm);
            border: 1.5px solid #f0f0f0;
            transition: var(--transition);
        }
        .benefit-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); border-color: var(--green-pale); }
        .benefit-icon { font-size: 2.4rem; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .benefit-card h4 { font-size: 1.05rem; font-weight: 700; color: var(--green-dark); margin-bottom: 10px; }
        .benefit-card p  { font-size: .87rem; color: var(--text-mid); line-height: 1.7; }

        /* Partners */
        .partners-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 20px;
        }
        .partner-card {
            background: var(--cream);
            border: 1.5px solid var(--green-pale);
            border-radius: var(--radius-md);
            padding: 24px 20px;
            text-align: center;
            transition: var(--transition);
        }
        .partner-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-sm); border-color: var(--green-light); }
        .partner-icon { font-size: 2rem; margin-bottom: 10px; }
        .partner-card h4 { font-size: .95rem; font-weight: 700; color: var(--green-dark); margin-bottom: 4px; }
        .partner-card p  { font-size: .8rem; color: var(--text-light); margin-bottom: 10px; }
        .partner-members { display: inline-flex; align-items: center; gap: 6px; background: var(--green-pale); color: var(--green-dark); font-size: .75rem; font-weight: 600; padding: 4px 12px; border-radius: 50px; }
        .partner-members i { font-size: .65rem; }

        .logo-strip { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
        .logo-pill {
            background: var(--cream);
            border: 1.5px solid #e8e0d0;
            color: var(--text-mid);
            font-size: .82rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 50px;
            transition: var(--transition);
        }
        .logo-pill:hover { border-color: var(--green-mid); color: var(--green-dark); }

        /* CTA */
        .cta-section {
            position: relative;
            background: linear-gradient(135deg, #0d3320, #1a4d2e, #2d6a2d);
            padding: 100px 0;
            overflow: hidden;
            text-align: center;
        }
        .cta-bg {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.06) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
            pointer-events: none;
        }
        .cta-icon { font-size: 3.5rem; margin-bottom: 20px; animation: floatUp 3s ease-in-out infinite; }
        .cta-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 36px; }
        .cta-contact-row {
            display: flex;
            gap: 28px;
            justify-content: center;
            flex-wrap: wrap;
            font-size: .85rem;
            color: rgba(255,255,255,.65);
        }
        .cta-contact-row span { display: flex; align-items: center; gap: 8px; }
        .cta-contact-row i { color: var(--yellow); }

        /* Footer */
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 48px;
        }
        .footer-logo { display: flex; align-items: center; gap: 14px; margin-bottom: 4px; }
        .footer-logo-icon {
            width: 44px; height: 44px;
            background: var(--green-mid);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .footer-social { display: flex; gap: 10px; margin-top: 20px; }
        .social-btn {
            width: 38px; height: 38px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.7);
            font-size: .9rem;
            transition: var(--transition);
        }
        .social-btn:hover { background: var(--yellow); color: var(--green-dark); transform: translateY(-3px); }

        .footer-col h5 { color: var(--white); font-size: .88rem; font-weight: 700; margin-bottom: 18px; letter-spacing: .04em; }
        .footer-col ul  { display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li a { font-size: .84rem; color: rgba(255,255,255,.55); transition: color .3s; }
        .footer-col ul li a:hover { color: var(--yellow); }

        .footer-contacts { display: flex; flex-direction: column; gap: 12px; }
        .footer-contacts li { display: flex; align-items: flex-start; gap: 10px; font-size: .84rem; }
        .footer-contacts li svg { color: var(--yellow); margin-top: 3px; flex-shrink: 0; }

        /* Back to top */
        #backTop {
            position: fixed;
            bottom: 32px; right: 32px;
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            color: var(--white);
            border: none;
            border-radius: 50%;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            opacity: 0;
            transform: translateY(16px);
            transition: var(--transition);
            z-index: 500;
        }
        #backTop.visible { opacity: 1; transform: translateY(0); }
        #backTop:hover { transform: translateY(-4px) !important; }

        /* Responsive */
        @media (max-width: 1100px) { .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; } }
        @media (max-width: 900px) {
            .benefits-grid { grid-template-columns: 1fr 1fr; }
            .partners-grid  { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .benefits-grid  { grid-template-columns: 1fr; }
            .partners-grid  { grid-template-columns: 1fr; }
            .footer-grid    { grid-template-columns: 1fr; gap: 28px; }
            .cta-contact-row{ flex-direction: column; align-items: center; gap: 12px; }
            #backTop { bottom: 20px; right: 20px; }
        }
    </style>
</main>

<!-- ============================================================
     SCRIPTS
============================================================ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // AOS init
    AOS.init({ duration: 800, once: true, easing: 'ease-out-cubic', offset: 60 });

    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    });

    // Mobile menu
    const toggle   = document.getElementById('navToggle');
    const links    = document.getElementById('navLinks');
    const overlay  = document.getElementById('navOverlay');

    function openMenu()  { toggle.classList.add('open'); links.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeMenu() { toggle.classList.remove('open'); links.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

    toggle.addEventListener('click', () => toggle.classList.contains('open') ? closeMenu() : openMenu());
    overlay.addEventListener('click', closeMenu);
    links.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

    // ── Animated Counters ─────────────────────────────────────
    function animateCounter(el) {
        const target = +el.dataset.target;
        const dur = 2000;
        const step = target / (dur / 16);
        let cur = 0;
        const t = setInterval(() => {
            cur = Math.min(cur + step, target);
            el.textContent = Math.floor(cur).toLocaleString('id');
            if (cur >= target) clearInterval(t);
        }, 16);
    }

    const counterObserver = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                animateCounter(e.target);
                counterObserver.unobserve(e.target);
            }
        });
    }, { threshold: .4 });

    document.querySelectorAll('.stat-num').forEach(el => counterObserver.observe(el));

    // ── Chart.js: Production Line ─────────────────────────────
    const prodCtx = document.getElementById('productionChart');
    if (prodCtx) {
        new Chart(prodCtx, {
            type: 'line',
            data: {
                labels: ['2019','2020','2021','2022','2023','2024'],
                datasets: [{
                    label: 'Produksi (ton)',
                    data: [120, 210, 380, 540, 720, 856],
                    borderColor: '#2d6a2d',
                    backgroundColor: 'rgba(45,106,45,.12)',
                    borderWidth: 3,
                    pointBackgroundColor: '#f5c518',
                    pointBorderColor: '#2d6a2d',
                    pointRadius: 6,
                    pointHoverRadius: 9,
                    tension: .4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ` ${ctx.raw} ton` } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.06)' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }

    // ── Back to top ───────────────────────────────────────────
    const backTop = document.getElementById('backTop');
    window.addEventListener('scroll', () => {
        backTop.classList.toggle('visible', window.scrollY > 300);
    });

    // ── Bilingual i18n ────────────────────────────────────────
    const translations = {
        id: {
            // Navbar
            nav_about:   'Tentang Kami',
            nav_stats:   'Data & Statistik',
            nav_service: 'Layanan',
            nav_gallery: 'Galeri',
            nav_join:    'Bergabung',
            nav_login:   'Masuk Sistem',
            // Hero
            hero_badge:    'Koperasi Resmi Terdaftar',
            hero_stat1:    'Petani Anggota',
            hero_stat2:    'BUMDes Mitra',
            hero_stat3:    'Panen/Tahun',
            hero_btn1:     'Daftar Anggota',
            hero_btn2:     'Portal Anggota',
            float1_strong: '1.200+ Petani',
            float1_span:   'Aktif Bersama',
            float2_strong: 'Harga Terjamin',
            float2_span:   'Akses Pasar Luas',
            // About
            about_label: 'Tentang Kami',
            about_title: 'Bukan Pengolah — Tapi Kekuatan di Balik Petani Porang',
            about_p1:    'Koperasi Barakat Pangan Banua bukan unit pengolahan hasil panen. Kami adalah wadah organisasi petani porang — mengelola keanggotaan, membangun jaringan pasar, dan memastikan setiap petani mendapat harga yang adil dan layanan yang profesional.',
            about_p2:    'Siapa pun bisa bergabung — petani aktif, calon petani, pemilik lahan, maupun kelompok tani. Bersama, kita bangun ekosistem porang yang kuat dari hulu. Porang (Amorphophallus muelleri) adalah komoditas ekspor bernilai tinggi yang masa depannya sangat menjanjikan.',
            v1: 'Transparan & Akuntabel', v2: 'Berbasis Digital',
            v3: 'Terbuka untuk Semua',    v4: 'Berorientasi Petani',
            about_cta: 'Bergabung Sekarang',
            // Statistics
            stats_label: 'Data & Statistik',
            stats_title: 'Porang: Komoditas Masa Depan Indonesia',
            stats_desc:  'Data nyata pertumbuhan industri porang nasional dan kinerja koperasi kami',
            chart1_title: 'Tren Produksi Porang Nasional (ton)',
            chart2_title: 'Segmen Pasar Produk Porang',
            hero_stat1_unit: 'Petani', stat1_label: 'Anggota Aktif',
            stat2_label: 'Mitra Desa', stat3_label: 'Total Panen 2024',
            stat4_label: 'Omzet Tahunan', stat5_unit: 'Negara',
            stat5_label: 'Tujuan Ekspor', stat6_label: 'Total Lahan',
            // Layanan
            layanan_label: 'Layanan Koperasi',
            l1_title: 'Pendampingan Budidaya',
            l1_desc:  'Tim agronomi kami hadir langsung ke lahan — dari pemilihan bibit unggul, teknik tanam, hingga pengendalian hama agar panen optimal.',
            l1_li1: 'Konsultasi teknis gratis', l1_li2: 'Akses bibit porang bermutu', l1_li3: 'Monitoring pertumbuhan digital',
            l2_title: 'Akses Pasar & Pemasaran',
            l2_desc:  'Hasil panen anggota kami salurkan ke jaringan pembeli yang sudah terpercaya — tanpa perantara berlebih, harga lebih adil untuk petani.',
            l2_li1: 'Jaringan pembeli nasional', l2_li2: 'Harga terjamin & transparan', l2_li3: 'Kontrak pembelian tertulis',
            l3_title: 'Simpan Pinjam & Modal Usaha',
            l3_desc:  'Anggota koperasi mendapat akses fasilitas simpan pinjam berbunga rendah untuk modal tanam, pembelian pupuk, dan kebutuhan pertanian lainnya.',
            l3_li1: 'Bunga ringan 0.8%/bulan', l3_li2: 'Proses cepat & mudah', l3_li3: 'Cicilan fleksibel',
            l4_title: 'Pelatihan & Pengembangan',
            l4_desc:  'Program pelatihan rutin — dari budidaya organik, manajemen panen, hingga literasi digital — agar petani terus berkembang dan kompetitif.',
            l4_li1: 'Pelatihan bulanan gratis', l4_li2: 'Studi banding lapangan', l4_li3: 'Sertifikasi kompetensi',
            layanan_cta_strong: 'Semua layanan terbuka untuk anggota koperasi',
            layanan_cta_span:   'Daftar sekarang dan mulai nikmati seluruh manfaatnya',
            layanan_cta_btn:    'Daftar Anggota',
            // Gallery
            gallery_label: 'Galeri & Video',
            gallery_title: 'Kehidupan Nyata Petani Porang Kami',
            gallery_desc:  'Dokumentasi kegiatan budidaya, panen, pelatihan, dan kebersamaan anggota koperasi di lapangan',
            video_label: 'Video Profil',
            video_title: 'Mengenal Lebih Dekat Koperasi Barakat Pangan Banua',
            video_desc:  'Saksikan kehidupan nyata petani porang anggota koperasi kami — dari menanam bibit, merawat lahan, hingga panen dan mendapatkan hasil yang layak melalui jaringan koperasi.',
            vh1: 'Cara budidaya porang yang benar',
            vh2: 'Peran koperasi dalam mendampingi petani',
            vh3: 'Testimoni petani sukses bersama koperasi',
            // Benefits
            benefits_label: 'Keunggulan Kami',
            benefits_title: 'Mengapa Bergabung dengan Koperasi Kami?',
            b1_title: 'Pendampingan Penuh',    b1_desc: 'Tim agronomis berpengalaman mendampingi petani dari penanaman hingga panen — gratis untuk seluruh anggota koperasi.',
            b2_title: 'Harga Terjamin',         b2_desc: 'Harga beli hasil panen lebih adil dan transparan — tanpa perantara tengkulak. Petani anggota mendapat keuntungan penuh.',
            b3_title: 'Sistem Digital',         b3_desc: 'Pantau lahan, jadwal panen, dan riwayat transaksi kapan saja via portal web koperasi yang mudah digunakan.',
            b4_title: 'Akses Modal Usaha',      b4_desc: 'Fasilitas simpan pinjam berbunga rendah khusus anggota untuk modal tanam, pupuk, dan kebutuhan pertanian lainnya.',
            b5_title: 'Jaringan Pasar Luas',    b5_desc: 'Hasil panen anggota tersalurkan ke jaringan pembeli nasional dan internasional yang sudah terbangun oleh koperasi.',
            b6_title: 'Pelatihan & Edukasi',    b6_desc: 'Workshop bulanan, studi banding lapangan, dan sertifikasi kompetensi pertanian — gratis untuk semua anggota aktif.',
            // Partners
            partners_label: 'Mitra & BUMDes',
            partners_title: 'BUMDes Mitra Kami',
            partners_desc:  'Bersinergi dengan BUMDes untuk pemerataan kesejahteraan di desa-desa penghasil porang',
            member_word:    'Petani',
            supported_by:   'Didukung & Bermitra dengan',
            // Join Steps
            join_label: 'Cara Bergabung',
            join_title: '3 Langkah Mudah Menjadi Anggota',
            join_desc:  'Proses pendaftaran sederhana, cepat, dan tidak dipungut biaya apapun di awal',
            step1_title: 'Isi Formulir Pendaftaran',  step1_desc: 'Daftar melalui portal online kami atau langsung ke kantor koperasi terdekat. Siapkan KTP dan data lahan Anda.',
            step2_title: 'Verifikasi & Persetujuan',   step2_desc: 'Tim koperasi akan memverifikasi data Anda dalam 1–3 hari kerja. Anda akan mendapat notifikasi persetujuan via telepon atau WhatsApp.',
            step3_title: 'Aktif sebagai Anggota',      step3_desc: 'Setelah disetujui, Anda resmi menjadi anggota dan langsung dapat mengakses seluruh layanan, pendampingan, dan program koperasi.',
            // CTA
            cta_title:         'Siap Bergabung Bersama Kami?',
            cta_desc:          'Jadilah bagian dari ribuan petani yang telah merasakan manfaat nyata bersama Koperasi Barakat Pangan Banua. Daftarkan diri Anda sekarang — gratis!',
            cta_btn_register:  'Daftar Jadi Anggota',
            cta_btn_wa:        'Chat WhatsApp',
            // Footer
            footer_tagline:  'Wadah bersama petani porang Indonesia — transparan, profesional, dan berpihak pada kesejahteraan anggota.',
            footer_menu:     'Menu Utama',
            footer_service:  'Layanan Koperasi',
            footer_contact:  'Kontak Kami',
            fs1: 'Pendampingan Budidaya', fs2: 'Akses Pasar & Harga',
            fs3: 'Simpan Pinjam',         fs4: 'Pelatihan Petani',       fs5: 'Portal Anggota',
            office_hours: 'Senin–Jumat, 08.00–17.00 WIB',
            copyright: '© {{ date("Y") }} Koperasi Barakat Pangan Banua. Hak Cipta Dilindungi.',
            privacy: 'Kebijakan Privasi',
            terms:   'Syarat & Ketentuan',
        },
        en: {
            // Navbar
            nav_about:   'About Us',
            nav_stats:   'Data & Statistics',
            nav_service: 'Services',
            nav_gallery: 'Gallery',
            nav_join:    'Join Us',
            nav_login:   'Member Portal',
            // Hero
            hero_badge:    'Officially Registered Cooperative',
            hero_stat1:    'Active Members',
            hero_stat2:    'BUMDes Partners',
            hero_stat3:    'Harvest/Year',
            hero_btn1:     'Become a Member',
            hero_btn2:     'Member Portal',
            float1_strong: '1,200+ Farmers',
            float1_span:   'Growing Together',
            float2_strong: 'Guaranteed Price',
            float2_span:   'Wide Market Access',
            // About
            about_label: 'About Us',
            about_title: 'Not a Processor — But the Strength Behind Porang Farmers',
            about_p1:    'Koperasi Barakat Pangan Banua is not a crop processing unit. We are an organizational platform for porang farmers — managing memberships, building market networks, and ensuring every farmer gets a fair price and professional service.',
            about_p2:    'Anyone can join — active farmers, aspiring farmers, landowners, or farmer groups. Together, we build a strong porang ecosystem from the ground up. Porang (Amorphophallus muelleri) is a high-value export commodity with a very promising future.',
            v1: 'Transparent & Accountable', v2: 'Digitally Powered',
            v3: 'Open to Everyone',           v4: 'Farmer-Oriented',
            about_cta: 'Join Now',
            // Statistics
            stats_label: 'Data & Statistics',
            stats_title: 'Porang: Indonesia\'s Commodity of the Future',
            stats_desc:  'Real data on national porang industry growth and our cooperative\'s performance',
            chart1_title: 'National Porang Production Trend (tons)',
            chart2_title: 'Porang Product Market Segments',
            hero_stat1_unit: 'Farmers', stat1_label: 'Active Members',
            stat2_label: 'Village Partners', stat3_label: 'Total Harvest 2024',
            stat4_label: 'Annual Revenue',  stat5_unit: 'Countries',
            stat5_label: 'Export Markets',  stat6_label: 'Total Land Area',
            // Layanan
            layanan_label: 'Cooperative Services',
            l1_title: 'Farming Assistance',
            l1_desc:  'Our agronomy team visits your farm directly — from selecting quality seeds, planting techniques, to pest management for optimal harvest.',
            l1_li1: 'Free technical consultation', l1_li2: 'Access to quality porang seeds', l1_li3: 'Digital growth monitoring',
            l2_title: 'Market Access & Sales',
            l2_desc:  'Member harvests are channeled to trusted buyer networks — fewer middlemen, fairer prices for farmers.',
            l2_li1: 'National buyer network', l2_li2: 'Guaranteed & transparent pricing', l2_li3: 'Written purchase contracts',
            l3_title: 'Savings & Business Capital',
            l3_desc:  'Cooperative members get access to low-interest savings and loan facilities for planting capital, fertilizer purchases, and other farming needs.',
            l3_li1: 'Low interest 0.8%/month', l3_li2: 'Fast & easy process', l3_li3: 'Flexible installments',
            l4_title: 'Training & Development',
            l4_desc:  'Regular training programs — from organic farming, harvest management, to digital literacy — so farmers keep growing and stay competitive.',
            l4_li1: 'Free monthly training', l4_li2: 'Field study visits', l4_li3: 'Competency certification',
            layanan_cta_strong: 'All services are open to cooperative members',
            layanan_cta_span:   'Register now and start enjoying all the benefits',
            layanan_cta_btn:    'Become a Member',
            // Gallery
            gallery_label: 'Gallery & Video',
            gallery_title: 'The Real Life of Our Porang Farmers',
            gallery_desc:  'Documentation of cultivation, harvest, training activities, and community of cooperative members in the field',
            video_label: 'Profile Video',
            video_title: 'Getting to Know Koperasi Barakat Pangan Banua',
            video_desc:  'See the real life of our cooperative\'s porang farming members — from planting seeds, tending the land, to harvesting and receiving fair returns through the cooperative network.',
            vh1: 'Proper porang cultivation techniques',
            vh2: 'The cooperative\'s role in supporting farmers',
            vh3: 'Success stories from farmers in our cooperative',
            // Benefits
            benefits_label: 'Why Choose Us',
            benefits_title: 'Why Join Our Cooperative?',
            b1_title: 'Full Support',            b1_desc: 'Experienced agronomists accompany farmers from planting to harvest — free for all cooperative members.',
            b2_title: 'Guaranteed Prices',       b2_desc: 'Fairer and more transparent purchase prices — no middlemen. Member farmers get full profit from their harvest.',
            b3_title: 'Digital System',          b3_desc: 'Monitor land, harvest schedules, and transaction history anytime via our easy-to-use cooperative web portal.',
            b4_title: 'Business Capital Access', b4_desc: 'Low-interest savings and loan facilities exclusively for members — for planting capital, fertilizer, and other farming needs.',
            b5_title: 'Wide Market Network',     b5_desc: 'Member harvests are channeled to national and international buyer networks already established by the cooperative.',
            b6_title: 'Training & Education',    b6_desc: 'Monthly workshops, field study visits, and farming competency certifications — free for all active members.',
            // Partners
            partners_label: 'Partners & BUMDes',
            partners_title: 'Our BUMDes Partners',
            partners_desc:  'Collaborating with BUMDes to spread prosperity in porang-producing villages',
            member_word:    'Farmers',
            supported_by:   'Supported & Partnered with',
            // Join Steps
            join_label: 'How to Join',
            join_title: '3 Easy Steps to Become a Member',
            join_desc:  'Simple, fast registration process — no upfront fees required',
            step1_title: 'Fill in the Registration Form', step1_desc: 'Register through our online portal or directly visit the nearest cooperative office. Prepare your ID and land data.',
            step2_title: 'Verification & Approval',        step2_desc: 'The cooperative team will verify your data within 1–3 business days. You will receive an approval notification via phone or WhatsApp.',
            step3_title: 'Active as a Member',             step3_desc: 'Once approved, you are officially a member and can immediately access all services, mentoring, and cooperative programs.',
            // CTA
            cta_title:        'Ready to Join Us?',
            cta_desc:         'Become part of thousands of farmers who have experienced real benefits with Koperasi Barakat Pangan Banua. Register now — it\'s free!',
            cta_btn_register: 'Become a Member',
            cta_btn_wa:       'Chat on WhatsApp',
            // Footer
            footer_tagline:  'A shared platform for Indonesian porang farmers — transparent, professional, and committed to member prosperity.',
            footer_menu:     'Main Menu',
            footer_service:  'Cooperative Services',
            footer_contact:  'Contact Us',
            fs1: 'Farming Assistance', fs2: 'Market & Price Access',
            fs3: 'Savings & Loans',    fs4: 'Farmer Training',     fs5: 'Member Portal',
            office_hours: 'Monday–Friday, 08:00–17:00 WIB',
            copyright: '© {{ date("Y") }} Koperasi Barakat Pangan Banua. All Rights Reserved.',
            privacy: 'Privacy Policy',
            terms:   'Terms & Conditions',
        }
    };

    let currentLang = localStorage.getItem('lang') || 'id';

    function applyLang(lang) {
        currentLang = lang;
        localStorage.setItem('lang', lang);
        const t = translations[lang];

        // Update all data-i18n elements
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key] !== undefined) el.innerHTML = t[key];
        });

        // Update html lang attribute
        document.documentElement.lang = lang;

        // Update lang buttons
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === lang);
        });

        // Update page title
        document.title = lang === 'en'
            ? 'Koperasi Barakat Pangan Banua - Growing Together, Prospering Together'
            : 'Koperasi Barakat Pangan Banua - Bersama Tumbuh, Bersama Sejahtera';
    }

    // Init language
    applyLang(currentLang);

    // Lang button click
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => applyLang(btn.dataset.lang));
    });

    // ── Chart.js: Product Doughnut ────────────────────────────
    const pieCtx = document.getElementById('productChart');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Chips Kering','Tepung Konjak','Umbi Segar','Glukomanan'],
                datasets: [{
                    data: [38, 28, 22, 12],
                    backgroundColor: ['#2d6a2d','#f5c518','#8b5a2b','#5a9e5a'],
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, font: { size: 11 }, usePointStyle: true, pointStyleWidth: 10 }
                    }
                }
            }
        });
    }
</script>

</body>
</html>
