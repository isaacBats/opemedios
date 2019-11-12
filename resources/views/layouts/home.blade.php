<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        @php
            $anio = date('Y');
        @endphp
        <meta name="description" content="Operadora de Medios Informativos {{ $anio }}">
        <meta name="author"      content="Isaac Daniel Batista">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link href="{{ asset('fonts/04.Geomanist_Regular_webfontkit/stylesheet.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('fonts/07.Geomanist_Bold_webfontkit/stylesheet.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <!--Owl -->
        <link rel="stylesheet" href="{{ asset('css/owl/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl/owl.theme.default.min.css') }}">
        
        <!-- Style -->
        <link href="{{ asset('css/home/style.css') }}" media="all" rel="stylesheet" type="text/css">
        @yield('styles')
    </head>
    <body class="home">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-6 col-sm-4">
                        <figure class="logo"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></figure>
                    </div>
                    <div class="col-6 col-sm-8">
                        <nav class="navbar navbar-dark d-md-none d-lg-none d-xl-none">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                        <nav class="menu d-none d-md-block d-lg-block d-xl-block">
                            <ul>
                                <li><a href="https://opemedios.mx/sign-in" class="login">Iniciar Sesión</a></li>
                                <li><a href="https://opemedios.mx/contacto">Contacto</a></li>
                                <li><a href="https://opemedios.mx/clientes">Clientes</a></li>
                                <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                <li><a href="https://opemedios.mx/" class="active">Inicio</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="collapse" id="navbarToggleExternalContent">
                            <nav class="mobile  text-center">
                                <?php if( !isset( $_SESSION['user'] ) ): ?>
                                <ul>
                                    <li><a href="https://opemedios.mx/sign-in" class="login">Iniciar Sesión</a></li>
                                    <li><a href="https://opemedios.mx/contacto">Contacto</a></li>
                                    <li><a href="https://opemedios.mx/clientes">Clientes</a></li>
                                    <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                    <li><a href="https://opemedios.mx/" class="active">Inicio</a></li>
                                </ul>
                                <?php else: ?>
                                <ul>
                                    <li><a href="" class="login">Sesion iniciada</a></li>
                                    <li><a href="">Otro menu</a></li>
                                </ul>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
            
        @yield('content')

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="legal">
                            <p><span>&#169; {{ $anio }} OPEMEDIOS</span>  <!--<span class="legal-spacer">|</span> AVISO DE PRIVACIDAD <span class="legal-spacer">|</span> TERMINOS Y CONDICIONES--></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="social">
                           <!-- <div class="social-yt">
                                <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>-->
                            <div class="social-tw">
                                <a href="https://twitter.com/DeMonitoreo" target="_blank"><i class="fab fa-twitter"></i></a>
                            </div>
                            <div class="social-fb">
                                <a href="https://www.facebook.com/OPEMEDIOS/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="top"><i class="fas fa-arrow-up fa-lg"></i></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <!-- OWL -->
        <script src="{{ asset('js/owl/owl.carousel.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- FA -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
        <!-- GMAP3 -->
        <script type="text/javascript" src="{{ asset('js/gmap3/gmap3.min.js') }}"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=es&amp;key=AIzaSyDNWJrJgodmdVVk0lGK7YXQTAmsAgCnKgc"></script>
        <!-- Scripts-->
        <script src="{{ asset('js/home/scripts.js') }}"></script>
        @yield('scripts')
    </body>
</html>
