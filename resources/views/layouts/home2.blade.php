<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"    content="width=device-width, initial-scale=1.0">
        @php
            $anio = date('Y');
        @endphp
        <meta name="description" content="Operadora de Medios Informativos {{ $anio }}">
        <meta name="author"      content="Isaac Daniel Batista">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Opemedios') }} @yield('title')</title>

        <link rel="shortcut icon" href="/assets/images/favicon.ico">

        <!--<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,700,800,900" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/home/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home/css-font-awesome.min.css') }}">

        <!-- Custom styles for our template -->
        <link rel="stylesheet" href="{{ asset('css/home/bootstrap-theme.css') }}" media="screen" >
        <link rel="stylesheet" href="{{ asset('css/home/main.css') }}">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="{{ asset('js/html5shiv.js') }}"></script>
        <script src="{{ asset('js/respond.min.js') }}"></script>
        <![endif]-->
    </head>
<body class="home">
    <!-- Fixed navbar -->
    <header>
        @include('components.menu-client')   
    </header>
    <!-- /.navbar -->
    @yield('content')

    <footer id="footer" class="top-space">

        <div class="footer1">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 widget">
                        <h3 class="widget-title">Contactanos</h3>
                        <div class="widget-body">
                            <p><a href="tel:5555846410" target="_blank">55-5584-64-10</a><br>
                            <a href="mailto:contacto@opemedios.com.mx" target="_blank">contacto@opemedios.com.mx</a><br>
                            Ures 69, Col. Roma Sur CP. 06760, México, DF, Del. Cuauhtémoc
                            </p>
                        </div>
                    </div>
                    
                    <!-- 2018 -->
                    <div class="col-md-6 widget">
                        <div class="widget-body">
                            <div class="social">
                                <div class="social-tw">
                                    <a href="https://twitter.com/DeMonitoreo" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                                <div class="social-fb">
                                    <a href="https://www.facebook.com/OPEMEDIOS/" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /2018 -->

                </div> <!-- /row of widgets -->
            </div>
        </div>

        <div class="footer2">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 widget">
                        <div class="widget-body">
                            <p class="simplenav">
                                <a href="{{ route('home') }}">Inicio</a> |
                                <a href="{{ route('about') }}">Quiénes somos</a> |
                                <a href="{{ route('clients') }}">Clientes</a> |
                                <a href="{{ route('contact') }}">Contacto</a> |
                                <b><a href="{{ route('signin') }}">Sign up</a></b>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 widget">
                        <div class="widget-body">
                            <p class="text-right">
                                Copyright &copy; <?=date('Y')?>, Opemedios.</a> 
                            </p>
                        </div>
                    </div>

                </div> <!-- /row of widgets -->
            </div>
        </div>

    </footer>





    <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/home/headroom.min.js') }}"></script>
    <script src="{{ asset('js/home/jQuery.headroom.min.js') }}"></script>

    <!-- GMAP3 -->
    <script type="text/javascript" src="{{ asset('js/gmap3/gmap3.min.js') }}"></script>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&amp;language=es&amp;key=AIzaSyAypI43RY-ssw2p2LwVrGSL_mTuFrZPXA8"></script>
    <script src="{{ asset('js/owl/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/home/scripts.js') }}"></script>

    <script src="{{ asset('js/home/template.js') }}"></script>
    {{-- <script src="{{ asset('js/home/client.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>

