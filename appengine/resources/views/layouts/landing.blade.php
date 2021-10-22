<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Dinas Kominfotik Provinsi Indonesia">
    <meta name="keywords" content="Nyantri,Nyantri Aplikasi Pesantren, Aplikasi Pesantren Indonesia,Nyantri Indonesia">
    <meta name="description" content="Home Website Nyantri Aplikasi Pesantren">
    <meta name="robots" content="all,index,follow">
    <meta http-equiv="Content-Language" content="id-ID">
    <meta NAME="Distribution" CONTENT="Global">
    <meta NAME="Rating" CONTENT="General">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.png')}}">
    <!-- Site Title  -->
    <title>Nyantri - #1 Aplikasi Pesantren</title>
    <!-- Bundle and Base CSS -->
    <link rel="stylesheet" href="{{ asset('landing/assets/css/bundle.css')}}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/styles.css')}}">
</head>

<body class="nk-body">

<div class="nk-wrap">
    <header class="nk-header bg-light has-overlay" id="home">
        <div class="overlay shape shape-a"></div><!-- Overlay Shape -->
        <div class="nk-navbar is-light is-sticky" id="navbar">
            <div class="container">
                <div class="nk-navbar-wrap">
                    <div class="nk-navbar-logo logo">
                        <a href="{{ url('/') }}" class="logo-link">
                            <img class="logo-dark" src="{{ asset('landing/images/logo-white.png')}}" srcset="{{ asset('landing/images/logo-white .png')}}" alt="logo">
                            <img class="logo-light" src="{{ asset('landing/images/logo-white.png')}}" srcset="{{ asset('landing/images/logo-white.png')}}" alt="logo">
                        </a>
                    </div><!-- .nk-navbar-logo -->
                    <div class="nk-navbar-toggle d-lg-none">
                        <a href="#" class="toggle" data-menu-toggle="navbar-menu"><em class="icon-menu icon ni ni-menu"></em><em class="icon-close icon ni ni-cross"></em></a>
                    </div><!-- .nk-navbar-toggle -->
                    <nav class="nk-navbar-menu" id="navbar-menu">
                        <ul class="nk-menu">
                            <li class="nk-menu-item"><a class="scrollto nav-link nk-menu-link" href="#home">Home</a></li>
                        </ul>
                        @if(Auth::check())
                        <ul class="nk-menu-btns">
                            <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="btn btn-sm scrollto nav-link">Dashboard</a></li>
                        </ul>
                        @else
                        <ul class="nk-menu-btns">
                            <li class="nk-menu-item"><a href="{{ route('login') }}" class="btn btn-sm scrollto nav-link">Login</a></li>
                        </ul>
                        @endif
                    </nav><!-- .nk-navbar-menu -->
                </div><!-- .nk-navbar-wrap -->
            </div><!-- .container -->
        </div><!-- .nk-navbar -->
        <div class="nk-banner">
            <div class="container">
                <div class="row g-gs align-items-center justify-content-between">
                    <div class="col-lg-5 order-lg-last">
                        <div class="nk-banner-image">
                            <img src="{{ asset('landing/images/logo_landing.png')}}" alt="">
                        </div>
                    </div><!-- .col -->
                    <div class="col-lg-6">
                        <div class="nk-banner-block">
                            <div class="content">
                                <h1 class="heading">
                                    <span>Nyantri</span>
                                    <span class="heading-sm">
                                            <span class="sup">Aplikasi Pesantren #1</span>
                                            <span class="sub"></span>
                                        </span>
                                </h1>
                                <p><strong class="font-weight-bold text-danger">Nyantri</strong> adalah aplikasi Islami karya anak negeri TERLENGKAP ✅ GRATIS✅, dan BEBAS IKLAN ✅ yang didesain khusus untuk santri / wali santri dalam mencari pesantren yang cocok dengan kebutuhan nya.</p>

                                <ul class="nk-banner-btns">
                                    <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.tapisdev.nyantri" class="btn"><span>Download Aplikasi</span></a></li>
                                </ul>
                                <div class="status" data-covid="world">
                                    <div class="row g-gs">
                                        <div class="col-sm-4 col-6">
                                            <div class="status-item">
                                                <h6 class="title">Total Pesantren</h6>
                                                <div class="h3 count covid-stats-cases"> {{$jml_pesantren}}  </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-6">
                                            <div class="status-item">
                                                <h6 class="title">Total Santri Terdaftar</h6>
                                                <div class="h3 count covid-stats-death"> {{$jml_santri}} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .status -->
                            </div><!-- .content -->
                        </div><!-- .nk-banner-block -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .nk-banner -->
    </header><!-- .nk-header -->

    <main class="nk-pages">
        <section class="section section-l bg-white section-about" id="about">
            <div class="container">
                <div class="section-content">
                    <div class="row g-gs justify-content-between">
                        <div class="col-lg-7">
                            <div class="text-block">
                                <h5 class="subtitle">Tentang Aplikasi</h5>
                                <h2 class="title">Nyantri <br class="d-sm-none"></h2>
                                <p class="lead"><strong>Di Aplikasi Nyantri,</strong> Pesantren juga dapat berpartisipasi di aplikasi santri untuk mengelola profil pesantren nya agar lebih menarik dan memudahkan wali untuk melihat Progress santri di pesantren</p>

                                <p>Dilengkapi dengan fitur Lokasi, anda dapat dengan mudah melihat lokasi pesantren dan melihat rute nya dari lokasi anda. Bahkan anda dapat melihat pesantren yang berada di sekitar anda dengan sangat mudah.</p>
                            </div><!-- .text-block -->
                        </div><!-- .col -->
                        <div class="col-lg-5 col-xl-4">
                            <div class="wgs wgs-card mt-sm-2 mt-md-4 mt-lg-0 ml-lg-4 ml-xl-0">
                                <div class="wgs-head">
                                    <h4>Fitur Nyantri</h4>
                                </div>
                                <ul class="wgs-list">
                                    <li><a class="scrollto"> Pesantren Disekitar </a></li>
                                    <li><a class="scrollto" href="{{ url('/media-terdaftar?kategori=SKM') }}">Mudah Mencari Pesantren</a></li>
                                    <li><a class="scrollto" href="{{ url('/media-terdaftar?kategori=ONLINE') }}">Foto dan Data Pesantren Jelas</a></li>
                                    <li><a class="scrollto" href="{{ url('/media-terdaftar?kategori=TELEVISI') }}">Bagi Wali, dapat melihat santri yang terdaftar</a></li>
                                </ul>
                            </div><!-- .wgs -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .section-content -->
            </div><!-- .container -->
        </section><!-- .section -->

    </main><!-- .nk-pages -->

    <footer class="nk-footer bg-dark tc-light has-overlay">
        <div class="overlay shape shape-c"></div><!-- Overlay Shape -->
        <section class="section section-footer section-m tc-light">
            <div class="container">
                <div class="nk-footer-top">
                    <div class="row g-gs gy-m">
                        <div class="col-lg-4 col-md-9 mr-auto">
                            <div class="wgs wgs-about">
                                <div class="wgs-logo logo">
                                    <a href="./" class="logo-link">
                                        <img src="{{ asset('landing/images/logo-white.png')}}" srcset="{{ asset('landing/images/logo-white.png')}}" alt="logo">
                                    </a>
                                </div>
                                <div class="wgs-about-text">
                                    <p>Nyantri adalah sistem yang dibuat dengan tujuan memudahkan calon santri dan wali santri dalam mencari pesantren yang cocok bagianya. Serta dapat memudahkan
                                     wali santri dalam memantau kondisi santri nya ketika sedang dalam masa belajar di pesantren</p>
                                </div>
                                {{--<ul class="wgs-social">
                                    <li><a href="#"><em class="icon ni ni-facebook-f"></em></a></li>
                                    <li><a href="#"><em class="icon ni ni-twitter"></em></a></li>
                                    <li><a href="#"><em class="icon ni ni-youtube-fill"></em></a></li>
                                </ul>--}}
                            </div>
                        </div><!-- .col -->
                        <div class="col-sm-4 col-lg-3">
                            <div class="wgs wgs-menu">
                                <h6 class="wgs-title">Layanan Nyantri Indonesia</h6>
                                <ul class="wgs-links">
                                    <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.tapisdev.nyantri">Aplikasi Nyantri Android</a></li>
                                </ul>
                            </div><!-- .wgs -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .nk-footer-top -->
                <div class="nk-footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <p class="nk-copyright">&copy; 2021{{ \Carbon\Carbon::now()->format('Y') != '2021' ? ' - '. \Carbon\Carbon::now()->format('Y') : '' }} Nyantri Indonesia. </p>
                        </div><!-- .col -->
                        {{--<div class="col-md-6">
                            <ul class="nk-footer-links justify-content-md-end">
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>--}}<!-- .col -->
                    </div><!-- .row -->
                </div><!-- .nk-footer-bottom -->
            </div><!-- .container -->
        </section><!-- .section -->
    </footer><!-- .nk-footer -->
</div><!-- .nk-wrap -->

<!-- JavaScript -->
<script src="{{ asset('landing/assets/js/bundle.js?ver=112')}}"></script>
<script src="{{ asset('landing/assets/js/scripts.js?ver=112')}}"></script>
<script>
    $(document).ready(function () {
        if (window.location.hash) {
            var hash = window.location.hash;

            if ($(hash).length) {
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, 'swing');
            }
        }
    })
</script>
</body>
</html>
