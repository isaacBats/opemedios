@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if( $route != 'home' &&  $route != 'about' &&  $route != 'clients' &&  $route != 'signin' &&  $route != 'contact')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endif
    <meta name="description" content="Opemedios: Tu partner estratégico en soluciones integrales de comunicación. Creamos, gestionamos y amplificamos tu marca en todos los canales.">
    <meta name="keywords" content="Opemedios, marketing, comunicación, empresa, agencia, soluciones, monitoreo">
    <meta name="author" content="Isaac Daniel Batista">
    @yield('metas')
    <title>{{ config('app.name', 'Opemedios') }} @yield('title')</title>
    <!-- Standard Favicon -->
    <!-- <link rel="icon" href="{{ asset('assets/clientv3/img/fav/favicon-96x96.png') }}"> -->

    <!-- Touch Icons - iOS and Android 2.1+ -->
    <!-- <link rel="apple-touch-icon" href="{{ asset('assets/clientv3/img/fav/android-icon-48x48.png') }}"> -->
    <!-- <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/clientv3/img/fav/android-icon-72x72.png') }}"> -->
    <!-- <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/clientv3/img/fav/apple-icon-114x114.png') }}"> -->

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/clientv3/img/fav/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/clientv3/img/fav/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/clientv3/img/fav/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/clientv3/img/fav/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/clientv3/img/fav/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/clientv3/img/fav/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/clientv3/img/fav/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/clientv3/img/fav/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/clientv3/img/fav/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/clientv3/img/fav/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/clientv3/img/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/clientv3/img/fav/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/clientv3/img/fav/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/clientv3/img/fav/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    
    <!--bootstrap v5.2.3 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/bootstrap.min.css') }}">
    <!--flag css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/flags.css') }}">
    <!--meanmenu-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/meanmenu.css') }}">
    <!--icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/boxicons.min.css') }}">
    <!--aos-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/aos.css') }}">
    <!--slick slider-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/slick.css') }}">
    <!--main style-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/style.css') }}">
    @yield('styles')

    <!--modernizr-->
    <script src="{{ asset('assets/clientv3/js/vendor/modernizr.js') }}"></script>
    <!-- <script src="assets/clientv3/js/vendor/modernizr.js"></script> -->

    <!--[if lt IE 9]>
    <script src="{{ asset('assets/clientv3/js/html5/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="60">
    <div class="se-pre-con"></div>

    <!-- main nav start -->
    <header class="header-style-3">
        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}"  alt="Opemedios">
                            </a>
                        </div><!--/.logo-->
                    </div>
                </div>
            </div>
            <div class="main-navbar  v3">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.html">
                            <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="image">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="about.html" class="nav-link">Quiénes Somos</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link ">Servicios</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link ">Clientes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="contact.html" class="nav-link">Contacto</a>
                                </li>
                            </ul><!--/.navbar-nav -->
                            <div class="others-options v3 d-flex align-items-center">

                                <div class="option-item d-none d-xl-inline-block">
                                    <ul class="header-info-list">
                                        <li>
                                            <span class="icon">
                                                <i class='bx bxs-envelope'></i>
                                            </span>
                                            <h6>Email</h6>
                                            <a href="mailto:contacto@opemedios.com.mx">contacto@opemedios.com.mx</a>
                                        </li>
                                    </ul><!--/.header-info-list-->
                                </div>
                            </div><!--/.others-options-->
                        </div>
                    </nav><!--/.navbar-->
                </div>
            </div>
    
        </div>
    </header>
    <!-- /.navbar -->

    @yield('content')
    
    <!--footer area start-->
    <footer class="footers">
        <div class="container">
            <div class="row g-0">
                <div class="col-12">
                    <div class="newsletter-form">
                        <div class="d-md-flex align-items-center justify-content-between">
                            <div class="left-content">
                                <p>For Digital Marketing Agency</p>
                                <h2>Join Our Agency Community</h2>
                            </div>
                            <div class="right-content">
                                <form>
                                    <div class="newslttr-grp">
                                        <input type="email" placeholder="Enter your email address" class="form-control">
                                        <button type="submit" class="btn">Subscribe Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/.newsletter-form-->
                </div>
                <div class="col-12">
                    <div class="footer-widgets-wrap">
                        <div class="row g-4 gy-5">
                            <div class="col-sm-6 col-lg-3">
                                <div class="ftr-widget about">
                                    <h2>About Company</h2>
                                    <p>There are many variations of passages of Lore Ipsum availab but the majority have suffereds alteration in some form, by injected humour a randomised words which</p>
                                    <ul class="socials">
                                        <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                        <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                        <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                        <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                    </ul>
                                </div><!--/.ftr-widget-->
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="ftr-widget">
                                    <h2>Featured Services </h2>
                                    <ul class="navs">
                                        <li><a href="#">Social Media Marketing</a></li>
                                        <li><a href="#">Pay Per Click Management</a></li>
                                        <li><a href="#">Search Engine Optimization</a></li>
                                        <li><a href="#">Free SEO Analysis</a></li>
                                        <li><a href="#">Case Studies</a></li>
                                    </ul>
                                </div><!--/.ftr-widget-->
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="ftr-widget">
                                    <h2>Recent Post </h2>
                                    <ul class="recent-posts">
                                        <li class="d-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <img src="img/blog1.jpg" alt="">
                                            </div>
                                            <div class="flex-shrink-1">
                                                <a href="blog-details.html">Thoughtful man using laptop pondering </a>
                                                <p><i class='bx bx-calendar'></i> 09 Dec 2022</p>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <img src="img/blog2.jpg" alt="">
                                            </div>
                                            <div class="flex-shrink-1">
                                                <a href="blog-details.html">Thoughtful man using laptop pondering </a>
                                                <p><i class='bx bx-calendar'></i> 09 Dec 2022</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!--/.ftr-widget-->
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="ftr-widget">
                                    <h2>Contact Us</h2>
                                    <ul class="contacts">
                                        <li>
                                            <i class='bx bxs-phone' ></i>
                                            <a href="tel:7501234">+(323) 750-1234</a>
                                        </li>
                                        <li>
                                            <i class='bx bxs-envelope' ></i>
                                            <a href="mailto:infoyourortencey@email.com">infoyourortencey@email.com</a>
                                        </li>
                                        <li>
                                            <i class='bx bxs-map' ></i>
                                            <address>374 FA Tower, William S Blvd, Melbourne
                                                2721, IL, USA</address>
                                        </li>
                                    </ul>
                                </div><!--/.ftr-widget-->
                            </div>
                        </div>
                    </div><!--/.footer-widgets-wrap-->
                </div>
            </div>
        </div><!--/.container-->
    </footer>
    <div class="copyright-conts">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-6">
                    <p>2022 © All rights reserved by devsnest-llc</p>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--footer area end-->

     <!-- Return to Top -->
    <a href="javascript:" id="return-to-top"><i class="bx bx-chevron-up"></i></a>

    
    <!--jquery-->
    <script src="{{ asset('assets/clientv3/js/jquery.js') }}"></script>
    <!--bootstrap bundle v5.2.3-->
    <script src="{{ asset('assets/clientv3/js/vendor/bootstrap.bundle.js') }}"></script>
    <!--meanmenu-->
    <script src="{{ asset('assets/clientv3/js/vendor/jquery.meanmenu.js') }}"></script>
    <!--flag-->
    <script src="{{ asset('assets/clientv3/js/vendor/jquery.flagstrap.min.js') }}"></script>
    <!--aos-->
    <script src="{{ asset('assets/clientv3/js/vendor/aos.js') }}"></script>
    <!--slick-->
    <script src="{{ asset('assets/clientv3/js/vendor/slick.min.js') }}"></script>
    <!--easing js-->
    <script src="{{ asset('assets/clientv3/js/vendor/easing.js') }}"></script>
    <!--main script-->
    <script src="{{ asset('assets/clientv3/js/main.js') }}"></script>

</body>
</html>