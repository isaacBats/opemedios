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
        <title>{{ config('app.name', 'Opemedios') }} @yield('title')</title>
        
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
            @include('components.menu-client')
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
        @if(App::environment('production'))
            <script src="https://www.google.com/recaptcha/api.js?render=6Lf0xckUAAAAAAKtxbthI_-CzR_Z2nRz_vLPqk4M"></script>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('6Lf0xckUAAAAAAKtxbthI_-CzR_Z2nRz_vLPqk4M', {action: 'homepage'}).then(function(token) {
                       ...
                    });
                });
            </script>
        @endif
        @yield('scripts')
    </body>
</html>
