<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Suara Desa</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

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

  <!-- =======================================================
  * Template Name: eStartup
  * Template URL: https://bootstrapmade.com/estartup-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">Suara<span class="text-success"> Desa</span></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero">Beranda</a></li>
          <li><a href="#akses">Akses</a></li>
          <li><a href="#features">Fitur</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h2>Suara<span class="text-success"> Desa</span></h2>
            <p>Portal informasi terbuka untuk masyarakat desa dan pengelola desa. Temukan informasi terkini dan up-to-date di <span class="fw-bold">Suara Desa</span></p>
            <div class="d-flex gap-3">
              <a href="{{ route('login-masyarakat') }}" class="btn-get-started">Dashboard Desa</a>
              <a href="{{ route('registrasi-masyarakat') }}" class="btn-get-started">Daftarkan Diri</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="assets/img/hero-img.png" class="img-fluid" alt="">
          </div>
        </div>
      </div>

      <div id="akses" class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
        <div class="container position-relative">
            <div class="container section-title" data-aos="fade-up">
                <div><span>Akses</span> <span class="description-title">Dashboard</span></div>
            </div><!-- End Section Title -->
          <div class="row">

            <div class="col-xl-4 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-person-vcard"></i></div>
                <h4 class="title"><a href="{{ route('login-masyarakat') }}" class="stretched-link">Masyarakat</a></h4>
              </div>
            </div><!--End Icon Box -->

            <div class="col-xl-4 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-person-rolodex"></i></div>
                <h4 class="title"><a href="{{ route('login-kepaladesa') }}" class="stretched-link">Kepala Desa</a></h4>
              </div>
            </div><!--End Icon Box -->
            
            <div class="col-xl-4 col-md-6">
                <div class="icon-box">
                  <div class="icon"><i class="bi bi-person-gear"></i></div>
                  <h4 class="title"><a href="" class="stretched-link">Admin</a></h4>
                </div>
            </div><!--End Icon Box -->

          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Fitur</h2>
        <div><span>Fitur Dashboard</span> <span class="description-title">Berita</span></div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5 justify-content-between">

          <div class="col-xl-5" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/assets/img//template/eStartup/features.svg" class="img-fluid" alt="">
          </div>

          <div class="col-xl-6 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Informasi terkini</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Laporkan masalah</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Kategori laporan</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Peta persebaran</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Sharing laporan</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Laporan terverifikasi</h3>
                </div>
              </div><!-- End Feature Item -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container">
      <div class="copyright text-center ">
        <p>Suara<span class="text-success"> Desa</span></p>
      </div>
      <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">PPL Project Kelompok 5</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>