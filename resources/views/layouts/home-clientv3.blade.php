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
    {{-- Preloader v3 con fail-safe --}}
    <div class="se-pre-con">
        <div class="preloader-spinner"></div>
    </div>
    <style>
        /* Preloader v3 Styles - Inline para carga inmediata */
        .se-pre-con {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999999;
            background: var(--ope-white, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        .se-pre-con.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .preloader-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--ope-gray-200, #f3f4f6);
            border-top-color: var(--ope-primary, #2563eb);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    <script>
        // Fail-safe: Forzar cierre del preloader después de 5 segundos
        (function() {
            var maxWait = 5000;
            var preloader = document.querySelector('.se-pre-con');

            // Timeout de seguridad
            setTimeout(function() {
                if (preloader && !preloader.classList.contains('loaded')) {
                    preloader.classList.add('loaded');
                    console.warn('Preloader: Timeout de seguridad activado (5s)');
                }
            }, maxWait);

            // Escuchar evento load como respaldo
            window.addEventListener('load', function() {
                if (preloader) {
                    preloader.classList.add('loaded');
                }
            });
        })();
    </script>

    {{-- Variables de autenticación para el header --}}
    @php
        $userCompanySlug = null;
        $userCompany = null;
        $isAuthenticated = auth()->check();
        $isClient = false;
        $isAdmin = false;

        if ($isAuthenticated) {
            $user = auth()->user();
            $isClient = $user->isClient();
            $isAdmin = $user->hasRole('admin') || $user->hasRole('manager');

            if ($isClient) {
                $metas = $user->metas()->where('meta_key', 'company_id')->first();
                if ($metas) {
                    $userCompany = \App\Models\Company::find($metas->meta_value);
                    $userCompanySlug = $userCompany?->slug;
                }
            }
        }
    @endphp

    <!-- main nav start -->
    <header class="header-style-3 {{ $isAuthenticated ? 'header-authenticated' : '' }}">
        <div class="navbar-area">
            {{-- Mobile Navigation --}}
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            @if($isAuthenticated && $userCompany && $userCompany->logo)
                                {{-- Logo del cliente cuando está autenticado --}}
                                <a href="{{ route('news', ['company' => $userCompanySlug]) }}">
                                    <img src="{{ asset($userCompany->logo) }}" alt="{{ $userCompany->name }}" class="client-logo-nav">
                                </a>
                            @else
                                {{-- Logo de Opemedios para visitantes --}}
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="Opemedios">
                                </a>
                            @endif
                        </div><!--/.logo-->
                    </div>
                </div>
            </div>

            {{-- Desktop Navigation --}}
            <div class="main-navbar v3">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        {{-- Logo --}}
                        @if($isAuthenticated && $userCompany && $userCompany->logo)
                            <a class="navbar-brand" href="{{ route('news', ['company' => $userCompanySlug]) }}">
                                <img src="{{ asset($userCompany->logo) }}" alt="{{ $userCompany->name }}" class="client-logo-nav">
                            </a>
                        @else
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="Opemedios">
                            </a>
                        @endif

                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto" id="main-nav">
                                @if($isAuthenticated && $isClient && $userCompanySlug)
                                    {{-- ========================================
                                         MENÚ PRIVADO (Cliente Autenticado)
                                         ======================================== --}}
                                    <li class="nav-item">
                                        <a href="{{ route('news', ['company' => $userCompanySlug]) }}" class="nav-link {{ request()->routeIs('news') ? 'active' : '' }}">
                                            <i class='bx bx-grid-alt nav-icon'></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('client.mynews', ['company' => $userCompanySlug]) }}" class="nav-link {{ request()->routeIs('client.mynews') ? 'active' : '' }}">
                                            <i class='bx bx-news nav-icon'></i>
                                            Mis Noticias
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('client.report', ['company' => $userCompanySlug]) }}" class="nav-link {{ request()->routeIs('client.report*') ? 'active' : '' }}">
                                            <i class='bx bx-file nav-icon'></i>
                                            Reportes
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('client.sections') ? 'active' : '' }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class='bx bx-image-alt nav-icon'></i>
                                            Otras Secciones
                                            <i class='bx bx-chevron-down dropdown-caret'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('client.sections', ['company' => $userCompanySlug, 'type' => 'primeras']) }}"><i class='bx bx-news me-2'></i>Primeras Planas</a></li>
                                            <li><a class="dropdown-item" href="{{ route('client.sections', ['company' => $userCompanySlug, 'type' => 'politicas']) }}"><i class='bx bx-building-house me-2'></i>Columnas Políticas</a></li>
                                            <li><a class="dropdown-item" href="{{ route('client.sections', ['company' => $userCompanySlug, 'type' => 'financieras']) }}"><i class='bx bx-line-chart me-2'></i>Columnas Financieras</a></li>
                                            <li><a class="dropdown-item" href="{{ route('client.sections', ['company' => $userCompanySlug, 'type' => 'portadas']) }}"><i class='bx bx-book-open me-2'></i>Portadas Financieras</a></li>
                                            <li><a class="dropdown-item" href="{{ route('client.sections', ['company' => $userCompanySlug, 'type' => 'cartones']) }}"><i class='bx bx-palette me-2'></i>Cartones</a></li>
                                        </ul>
                                    </li>
                                    {{-- Logout en menú móvil --}}
                                    <li class="nav-item mobile-logout-item d-md-none">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="nav-link logout-link">
                                                <i class='bx bx-log-out nav-icon'></i>
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                @elseif($isAuthenticated && $isAdmin)
                                    {{-- ========================================
                                         MENÚ ADMIN/MANAGER
                                         ======================================== --}}
                                    <li class="nav-item">
                                        <a href="{{ url('/panel') }}" class="nav-link">
                                            <i class='bx bx-grid-alt nav-icon'></i>
                                            Panel Admin
                                        </a>
                                    </li>
                                    <li class="nav-item mobile-logout-item d-md-none">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="nav-link logout-link">
                                                <i class='bx bx-log-out nav-icon'></i>
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    {{-- ========================================
                                         MENÚ PÚBLICO (Visitante)
                                         ======================================== --}}
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                            <i class='bx bx-home nav-icon d-md-none'></i>
                                            Inicio
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#nosotros" class="nav-link">
                                            <i class='bx bx-group nav-icon d-md-none'></i>
                                            Quiénes Somos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#servicios" class="nav-link">
                                            <i class='bx bx-cog nav-icon d-md-none'></i>
                                            Servicios
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#clientes" class="nav-link">
                                            <i class='bx bx-briefcase nav-icon d-md-none'></i>
                                            Clientes
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#contacto" class="nav-link">
                                            <i class='bx bx-envelope nav-icon d-md-none'></i>
                                            Contacto
                                        </a>
                                    </li>
                                @endif
                            </ul><!--/.navbar-nav -->

                            {{-- Botones de acción (Desktop) --}}
                            <div class="others-options v3 d-flex align-items-center">
                                @if($isAuthenticated)
                                    {{-- Usuario info (opcional) --}}
                                    @if($userCompany)
                                        <div class="option-item d-none d-lg-block me-3">
                                            <span class="user-company-badge">
                                                <i class='bx bx-building'></i>
                                                {{ \Illuminate\Support\Str::limit($userCompany->name, 20) }}
                                            </span>
                                        </div>
                                    @endif
                                    {{-- Logout button (Desktop) --}}
                                    <div class="option-item">
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-saas btn-saas-logout" title="Cerrar sesión">
                                                <i class='bx bx-log-out'></i>
                                                <span class="d-none d-lg-inline ms-1">Salir</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    {{-- Login button --}}
                                    <div class="option-item">
                                        <a href="{{ route('signin') }}" class="btn-saas btn-saas-primary">
                                            <i class='bx bx-log-in'></i>
                                            Entrar
                                        </a>
                                    </div>
                                @endif
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

    @yield('scripts')
</body>
</html>