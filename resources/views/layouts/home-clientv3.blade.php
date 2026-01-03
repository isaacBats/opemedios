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
    
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
    <!--SaaS Modern Theme-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clientv3/css/theme-saas.css') }}">
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
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="Opemedios">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto" id="main-nav">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}#nosotros" class="nav-link">Quiénes Somos</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}#servicios" class="nav-link">Servicios</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}#clientes" class="nav-link">Clientes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}#contacto" class="nav-link">Contacto</a>
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
    <footer class="footer-modern">
        <div class="container">
            <div class="footer-widgets-wrap">
                <div class="row g-4 gy-5">
                    {{-- About Company --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="ftr-widget about">
                            <div class="footer-logo mb-3">
                                <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="Opemedios" style="max-width: 180px; filter: brightness(0) invert(1);">
                            </div>
                            <p>Somos una empresa especializada en monitoreo de medios y análisis de información con más de 20 años de experiencia. Tus ojos y oídos para la toma de decisiones.</p>
                            <ul class="socials">
                                <li><a href="https://www.facebook.com/OpemediosMx" target="_blank" rel="noopener"><i class="bx bxl-facebook"></i></a></li>
                                <li><a href="https://x.com/DeMonitoreo" target="_blank" rel="noopener"><i class="bx bxl-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/in/opemedios-an%C3%A1lisis-y-seguimiento-medi%C3%A1tico-8abba895/" target="_blank" rel="noopener"><i class="bx bxl-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="col-sm-6 col-lg-2">
                        <div class="ftr-widget">
                            <h2>Enlaces Rápidos</h2>
                            <ul class="navs">
                                <li><a href="{{ url('/') }}">Inicio</a></li>
                                <li><a href="{{ url('/') }}#nosotros">Quiénes Somos</a></li>
                                <li><a href="{{ url('/') }}#servicios">Servicios</a></li>
                                <li><a href="{{ url('/') }}#clientes">Clientes</a></li>
                                <li><a href="{{ url('/') }}#contacto">Contacto</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Services --}}
                    <div class="col-sm-6 col-lg-4">
                        <div class="ftr-widget">
                            <h2>Nuestros Servicios</h2>
                            <ul class="navs">
                                <li><a href="{{ url('/') }}#servicios">Monitoreo Integral de Medios</a></li>
                                <li><a href="{{ url('/') }}#servicios">Análisis de Temas y Palabras Clave</a></li>
                                <li><a href="{{ url('/') }}#servicios">Informe de Competencia Mediática</a></li>
                                <li><a href="{{ url('/') }}#servicios">Reportes Personalizados</a></li>
                                <li><a href="{{ url('/') }}#monitoreos">Monitoreo de Redes Sociales</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="ftr-widget">
                            <h2>Contáctanos</h2>
                            <ul class="contacts">
                                <li>
                                    <i class='bx bxs-phone'></i>
                                    <a href="tel:5540304996">55 4030 4996</a>
                                </li>
                                <li>
                                    <i class='bx bxs-phone'></i>
                                    <a href="tel:5534951145">55 3495 1145</a>
                                </li>
                                <li>
                                    <i class='bx bxs-envelope'></i>
                                    <a href="mailto:contacto@opemedios.com.mx">contacto@opemedios.com.mx</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- Copyright Bar --}}
    <div class="copyright-modern">
        <div class="container">
            <div class="row gy-3 align-items-center">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} Opemedios. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><a href="#">Aviso de Privacidad</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
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