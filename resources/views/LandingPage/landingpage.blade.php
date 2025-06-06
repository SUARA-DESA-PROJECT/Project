<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Suara Desa</title>
  <meta name="description" content="Portal informasi terbuka untuk masyarakat desa">
  <meta name="keywords" content="desa, informasi desa, portal desa">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    /* Navbar Modern ala Act Theme */
    .header {
      background: transparent;
      box-shadow: none;
      position: fixed;
      width: 100%;
      z-index: 1030;
      top: 0;
      left: 0;
      padding: 1rem 0;
      transition: all 0.3s ease;
    }
    .header.scrolled {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 0.7rem 0;
    }
    .header .logo h1 {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 2rem;
      letter-spacing: 1px;
      color: #fff;
      margin-bottom: 0;
    }
    .header.scrolled .logo h1 {
      color: #222;
    }
    .header .sitename .text-success {
      color: #1cda71 !important;
    }
    .header .navmenu ul {
      background: none;
      box-shadow: none;
      gap: 2rem;
    }
    .header .navmenu ul li a {
      color: #fff;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      padding: 0.5rem 0.8rem;
      border-radius: 30px;
      transition: background 0.2s, color 0.2s;
    }
    .header.scrolled .navmenu ul li a {
      color: #222;
    }
    .header .navmenu ul li a:hover {
      background: rgba(29, 233, 182, 0.15);
      color: #1cda71;
    }
    .header.scrolled .navmenu ul li a:hover {
      background: rgba(28, 218, 113, 0.1);
      color: #1cda71;
    }
    .header .btn-nav {
      background: #1cda71;
      color: #fff;
      border-radius: 30px;
      padding: 0.5rem 1.5rem;
      font-weight: 700;
      margin-left: 1.5rem;
      border: none;
      transition: background 0.2s, color 0.2s;
    }
    .header .btn-nav:hover {
      background: #fff;
      color: #1cda71;
      border: 1.5px solid #1cda71;
    }

    /* Hero Banner ala Act Theme */
    .hero {
      min-height: 100vh;
      width: 100vw;
      background: url('assets/img/bg-banner.jpg') center center/cover no-repeat;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      z-index: 1;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(30, 40, 60, 0.55);
      z-index: 2;
    }
    .hero-content {
      position: relative;
      z-index: 3;
      width: 100%;
      max-width: 700px;
      margin: 0 auto;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .hero-title {
      font-size: 3rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1.2rem;
      letter-spacing: -1px;
      text-shadow: 0 4px 24px rgba(0,0,0,0.25);
    }
    @media (min-width: 768px) {
      .hero-title { font-size: 4rem; }
    }
    .hero-subtitle {
      font-size: 1.15rem;
      font-weight: 400;
      margin-bottom: 2.2rem;
      color: #e0e0e0;
      text-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .hero-btns {
      display: flex;
      gap: 1.2rem;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn-outline {
      background: transparent;
      color: #fff;
      border: 2px solid #fff;
      border-radius: 30px;
      padding: 0.7rem 2.2rem;
      font-weight: 700;
      font-size: 1.1rem;
      transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-outline:hover {
      background: #fff;
      color: #1cda71;
      border: 2px solid #1cda71;
    }
    .btn-solid {
      background: #1cda71;
      color: #fff;
      border: 2px solid #1cda71;
      border-radius: 30px;
      padding: 0.7rem 2.2rem;
      font-weight: 700;
      font-size: 1.1rem;
      transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-solid:hover {
      background: #fff;
      color: #1cda71;
      border: 2px solid #1cda71;
    }
    .scroll-down {
      position: absolute;
      left: 50%;
      bottom: 2.5rem;
      transform: translateX(-50%);
      z-index: 4;
      color: #1cda71;
      font-size: 2.2rem;
      opacity: 0.85;
      transition: opacity 0.2s;
      cursor: pointer;
      animation: bounce 2s infinite;
    }
    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(10px); }
    }
    /* Responsive tweaks */
    @media (max-width: 600px) {
      .hero-title { font-size: 2.1rem; }
      .hero-content { padding: 0 1rem; }
    }
    /* Section titles and cards */
    .section-title h2 {
      font-weight: 800;
      font-size: 2.2rem;
      color: #222;
      margin-bottom: 0.5rem;
    }
    .section-title p {
      color: #888;
      font-size: 1.1rem;
    }
    .feature-box, .icon-box {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.07);
      padding: 2rem 1.2rem;
      transition: box-shadow 0.2s, transform 0.2s;
      position: relative;
    }
    .feature-box:hover, .icon-box:hover {
      box-shadow: 0 8px 32px rgba(29,233,182,0.13);
      transform: translateY(-4px) scale(1.03);
    }
    .feature-box .icon, .icon-box .icon {
      color: #1cda71;
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .feature-box h3, .icon-box h4 {
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }
    .feature-box p, .icon-box p {
      color: #666;
      font-size: 1rem;
    }
    /* Footer */
    .footer {
      background: #f8f9fa;
      color: #222;
      padding: 3rem 0 2rem 0;
      text-align: center;
    }
    .footer .social-links a {
      color: #1cda71;
      font-size: 1.5rem;
      margin: 0 0.5rem;
      transition: color 0.2s;
    }
    .footer .social-links a:hover {
      color: #222;
    }
    .feature-box, .icon-box { position: relative; }
  </style>

  <!-- =======================================================
  * Template Name: eStartup
  * Template URL: https://bootstrapmade.com/estartup-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center">
    <div class="container-xl d-flex align-items-center justify-content-between">
      <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Suara<span class="text-success"> Desa</span></h1>
      </a>
      <nav id="navmenu" class="navmenu d-flex align-items-center">
        <ul class="d-flex align-items-center mb-0">
          <li><a href="#hero">Beranda</a></li>
          <li><a href="#akses">Akses</a></li>
          <li><a href="#features">Fitur</a></li>
        </ul>
        <a href="{{ route('login-masyarakat') }}" class="btn-nav ms-3">Dashboard</a>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero">
      <div class="hero-content">
        <div class="hero-title" id="hero-typing"></div>
        <div class="hero-subtitle">Temukan informasi terkini, laporkan masalah, dan terhubung dengan desa Anda melalui Suara Desa.</div>
        <div class="hero-btns">
          <a href="{{ route('login-masyarakat') }}" class="btn-outline">Dashboard Desa</a>
          <a href="{{ route('registrasi-masyarakat') }}" class="btn-solid">Daftarkan Diri</a>
        </div>
      </div>
      <a href="#akses" class="scroll-down"><i class="bi bi-chevron-down"></i></a>
    </section>

    <!-- Access Section -->
    <section id="akses" class="section bg-light">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2>Akses Dashboard</h2>
          <p class="text-muted">Pilih peran Anda untuk mengakses dashboard</p>
        </div>

        <div class="row g-4">
          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-box text-center">
              <div class="icon mb-3">
                <i class="bi bi-person-vcard display-4 text-success"></i>
              </div>
              <h4 class="title">
                <a href="{{ route('login-masyarakat') }}" class="text-decoration-none">Masyarakat</a>
              </h4>
              <p class="text-muted">Akses informasi dan laporan untuk masyarakat</p>
            </div>
          </div>

          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-box text-center">
              <div class="icon mb-3">
                <i class="bi bi-person-rolodex display-4 text-success"></i>
              </div>
              <h4 class="title">
                <a href="{{ route('login-kepaladesa') }}" class="text-decoration-none">Kepala Desa</a>
              </h4>
              <p class="text-muted">Kelola informasi dan laporan desa</p>
            </div>
          </div>

          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-box text-center">
              <div class="icon mb-3">
                <i class="bi bi-person-gear display-4 text-success"></i>
              </div>
              <h4 class="title">
                <a href="{{ route('login-admin') }}" class="text-decoration-none">Admin</a>
              </h4>
              <p class="text-muted">Kelola sistem dan pengguna</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features section">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2>Fitur Unggulan</h2>
          <p class="text-muted">Temukan berbagai fitur yang tersedia di Suara Desa</p>
        </div>

        <div class="row gy-5 justify-content-between align-items-center">
          <div class="col-xl-5" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/assets/img//template/eStartup/features.svg" class="img-fluid" alt="">
          </div>

          <div class="col-xl-6">
            <div class="row g-4">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Informasi terkini</h3>
                  <p class="text-muted">Akses informasi terbaru seputar desa</p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Laporkan masalah</h3>
                  <p class="text-muted">Laporkan masalah dengan mudah dan cepat</p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Kategori laporan</h3>
                  <p class="text-muted">Pilih kategori sesuai jenis laporan</p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Peta persebaran</h3>
                  <p class="text-muted">Lihat persebaran laporan di peta</p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Sharing laporan</h3>
                  <p class="text-muted">Bagikan laporan ke media sosial</p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="feature-box">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <h3>Laporan terverifikasi</h3>
                  <p class="text-muted">Laporan yang sudah diverifikasi</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer bg-light py-5">
    <div class="container">
      <div class="text-center">
        <h3 class="mb-4">Suara<span class="text-success"> Desa</span></h3>
        <div class="social-links d-flex justify-content-center gap-3 mb-4">
          <a href="#" class="text-success"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="text-success"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-success"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-success"><i class="bi bi-linkedin"></i></a>
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          Designed by <a href="#" class="text-success">PPL Project Kelompok 5</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top Button -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Custom JS -->
  <script>
    // Initialize AOS
    AOS.init({
      duration: 1000,
      once: true
    });

    // Typing Animation
    document.addEventListener('DOMContentLoaded', function() {
      const text = document.querySelector('.typing-text');
      text.style.width = '0';
      setTimeout(() => {
        text.style.width = '100%';
      }, 100);
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
  </script>

  <script>
    window.addEventListener('load', function() {
      var preloader = document.getElementById('preloader');
      if (preloader) preloader.style.display = 'none';
    });
  </script>

  <!-- Typing Animation for Hero Title -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const el = document.getElementById('hero-typing');
      const text = 'Portal Informasi Desa\nTerbuka & Modern';
      let i = 0;
      function type() {
        if (i <= text.length) {
          let display = text.substring(0, i).replace(/\n/g, '<br>');
          el.innerHTML = display + '<span class="typing-cursor">|</span>';
          i++;
          setTimeout(type, 40);
        } else {
          el.innerHTML = text.replace(/\n/g, '<br>') + '<span class="typing-cursor">|</span>';
          setTimeout(() => {
            i = 0;
            el.innerHTML = '<span class="typing-cursor">|</span>';
            setTimeout(type, 400);
          }, 3000); // jeda 5 detik sebelum ulang
        }
      }
      type();
    });
  </script>
  <style>
    .typing-cursor {
      display: inline-block;
      width: 1ch;
      color: #1cda71;
      animation: blink-cursor 0.8s steps(1) infinite;
    }
    @keyframes blink-cursor {
      0%, 100% { opacity: 1; }
      50% { opacity: 0; }
    }
  </style>

</body>

</html>