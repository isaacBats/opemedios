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
            <div class="container">
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <figure class="logo"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></figure>
                    </div>
                    <div class="col-7 col-sm-8">
                        <nav class="navbar navbar-dark d-md-none d-lg-none d-xl-none">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                        <nav class="menu d-none d-md-block d-lg-block d-xl-block">
                            <ul>
                                @guest
                                    <li><a href="{{ route('signin') }}" class="login">Iniciar Sesión</a></li>
                                    <li><a href="{{ route('contact') }}">Contacto</a></li>
                                    <li><a href="{{ route('clients') }}">Clientes</a></li>
                                    <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                    <li><a href="{{ route('home') }}" class="active">Inicio</a></li>
                                @else
                                    @hasrole('client')
                                    @php
                                        $metas = auth()->user()->metas()->where(['meta_key' => 'company_id'])->first();
                                        $company = App\Company::find($metas->meta_value);
                                        $slug = $company->slug;
                                    @endphp
                                    <li><a href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                                    <li><a href="{{ route('contact') }}">Contacto</a></li>
                                    <li><a href="{{ route('clients') }}">Clientes</a></li>
                                    <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                    <li><a href="{{ route('home') }}" class="active">Inicio</a></li>
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
                                                {{ Auth::user()->name }}
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li>
                                                        <a href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                            Salir
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endhasrole
                                @endguest
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
                                <ul>
                                    @guest
                                        <li><a href="{{ route('signin') }}" class="login">Iniciar Sesión</a></li>
                                        <li><a href="{{ route('contact') }}">Contacto</a></li>
                                        <li><a href="{{ route('clients') }}">Clientes</a></li>
                                        <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                        <li><a href="{{ route('home') }}" class="active">Inicio</a></li>
                                    @else
                                        @hasrole('client')
                                        @php
                                            $metas = auth()->user()->metas()->where(['meta_key' => 'company_id'])->first();
                                            $company = App\Company::find($metas->meta_value);
                                            $slug = $company->slug;
                                        @endphp
                                        <li><a href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                                        <li><a href="{{ route('contact') }}">Contacto</a></li>
                                        <li><a href="{{ route('clients') }}">Clientes</a></li>
                                        <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                                        <li><a href="{{ route('home') }}" class="active">Inicio</a></li>
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
                                                    {{ Auth::user()->name }}
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        <li>
                                                            <a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                                Salir
                                                            </a>
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                  </ul>
                                                </div>
                                            </li>
                                        @endhasrole
                                    @endguest
                                </ul>
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
