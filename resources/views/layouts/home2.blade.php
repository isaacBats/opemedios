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
    <div class="navbar navbar-inverse navbar-fixed-top headroom" >
        <div class="container">
            <div class="navbar-header">
                <!-- Button for smallest screens -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Opemedios" class="op-logo">
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right op-nav">
                    <?php if( !isset( $_SESSION['user'] ) ): ?>

                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                        <li><a href="{{ route('clients') }}">Clientes</a></li>
                        <li><a href="{{ route('contact') }}">Contacto</a></li>
                        <li><a class="btn" href="{{ route('signin') }}">Iniciar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="/noticias">Noticias</a></li>
                        <li class="dropdown">
                            <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                Portadas
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="/primeras-planas">Primeras Planas</a></li>
                                <li><a href="/portadas-financieras">Portadas Financieras</a></li>
                                <li><a href="/cartones">Cartones</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                Columnas
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="/columnas-financieras">Columnas Financieras</a></li>
                                <li><a href="/columnas-politicas">Columnas Politicas</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                          <div class="dropdown">
                              <a id="report" class="btn dropdown-toggle user" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                  Reportes <span class="caret"></span>
                              </a>
                                  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu">
                                
                                <li><a href="/reporte/cliente">Noticias por cliente</a></li>
                                <li><a href="#">Reporte de notas por día</a></li>
                              </ul>
                          </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle user" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?= $_SESSION['user']['usuario'] ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <!-- <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li> -->
                                    <li><a href="/sign-out">Salir</a></li>
                              </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <!-- /.navbar -->
    @yield('content')

    <footer id="footer" class="top-space">

        <div class="footer1">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 widget">
                        <h3 class="widget-title">Contactanos</h3>
                        <div class="widget-body">
                            <p>+52 1 55 55846410<br>
                            <a href="mailto:atencion@opemedios.mx">atencion@opemedios.mx</a><br>
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
                                <a href="/clientes">Clientes</a> |
                                <a href="/contacto">Contacto</a> |
                                <b><a href="signup.html">Sign up</a></b>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/home/headroom.min.js') }}"></script>
    <script src="{{ asset('js/home/jQuery.headroom.min.js') }}"></script>

    <!-- GMAP3 -->
    <script type="text/javascript" src="{{ asset('js/gmap3/gmap3.min.js') }}"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=es&amp;key=AIzaSyDNWJrJgodmdVVk0lGK7YXQTAmsAgCnKgc"></script>
    <script src="{{ asset('js/home/scripts.js') }}"></script>

    <script src="{{ asset('js/home/template.js') }}></script>
</body>
</html>

