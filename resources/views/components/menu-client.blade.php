@php
    $slug = session()->get('slug_company');
    $route = Route::getCurrentRoute()->getName();
@endphp

@if( $route != 'home')
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
                    @if( $route == 'home' || $route == 'about' || $route == 'clients' || $route == 'contact' || $route == 'signin' && auth()->guest())
                        <li><a href="{{ route('home') }}" class="{{ $route == 'home' ? ' active' : '' }}">Inicio</a></li>
                        <li><a href="{{ route('about') }}" class="{{ $route == 'about' ? ' active' : '' }}">Quiénes somos</a></li>
                        <li><a href="{{ route('clients') }}" class="{{ $route == 'clients' ? ' active' : '' }}">Clientes</a></li>
                        <li><a href="{{ route('contact') }}" class="{{ $route == 'contact' ? ' active' : '' }}">Contacto</a></li>
                        @hasrole('client')
                            <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                        @else
                            <li><a class="btn{{ $route == 'signin' ? ' active' : '' }}" href="{{ route('signin') }}">Iniciar Sesión</a></li>
                        @endhasrole
                    @else
                        @hasrole('client')
                            <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle user btn-ope" type="button" id="menuArchivo" data-toggle="dropdown" > ARCHIVO <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right ope-menu" role="menu" aria-labelledby="menuArchivo">
                                        <li><a class="{{ $route == 'primeras' ? ' active' : '' }}" href="{{ route('primeras', ['company' => $slug]) }}">Primeras Planas</a></li>
                                        <li><a class="{{ $route == 'politicas' ? ' active' : '' }}" href="{{ route('politicas', ['company' => $slug]) }}">Columnas Pol&iacute;ticas</a></li>
                                        <li><a class="{{ $route == 'financieras' ? ' active' : '' }}" href="{{ route('financieras', ['company' => $slug]) }}">Columnas Financieras</a></li>
                                        <li><a class="{{ $route == 'portadas' ? ' active' : '' }}" href="{{ route('portadas', ['company' => $slug]) }}">Portadas Financieras</a></li>
                                        <li><a class="{{ $route == 'cartones' ? ' active' : '' }}" href="{{ route('cartones', ['company' => $slug]) }}">Cartones</a></li>
                                    </ul>
                                </div>
                            </li>
                            {{-- <li class="dropdown">
                                <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                    Portadas
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="/primeras-planas">Primeras Planas</a></li>
                                    <li><a href="/portadas-financieras">Portadas Financieras</a></li>
                                    <li><a href="/cartones">Cartones</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li class="dropdown">
                                <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                    Columnas
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="/columnas-financieras">Columnas Financieras</a></li>
                                    <li><a href="/columnas-politicas">Columnas Politicas</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li class="dropdown">
                              <div class="dropdown">
                                  <a id="report" class="btn dropdown-toggle user" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                      Reportes <span class="caret"></span>
                                  </a>
                                      <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu">
                                    
                                    <li><a href="/reporte/cliente">Noticias por cliente</a></li>
                                    <li><a href="#">Reporte de notas por día</a></li>
                                  </ul>
                              </div>
                            </li> --}}
                            <li>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle user btn-ope" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        {{ strtoupper(Auth::user()->name) }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu ope-menu" aria-labelledby="dropdownMenu1">
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
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
@else
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
                        @if( $route == 'home' || $route == 'about' || $route == 'clients' || $route == 'contact' || $route == 'signin' && auth()->guest())
                            @hasrole('client')
                                <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                            @else
                                <li><a class="btn {{ $route == 'signin' ? ' active' : '' }}" href="{{ route('signin') }}">Iniciar Sesión</a></li>
                            @endhasrole
                            <li><a href="{{ route('contact') }}" class="{{ $route == 'contact' ? ' active' : '' }}">Contacto</a></li>
                            <li><a href="{{ route('clients') }}" class="{{ $route == 'clients' ? ' active' : '' }}">Clientes</a></li>
                            <li><a href="{{ route('about') }}" class="{{ $route == 'about' ? ' active' : '' }}">Quiénes somos</a></li>
                            <li><a href="{{ route('home') }}" class="{{ $route == 'home' ? ' active' : '' }}">Inicio</a></li>
                        @else
                            @hasrole('client')
                                <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                                <li><a class="{{ $route == 'primeras' ? ' active' : '' }}" href="{{ route('primeras') }}">Primeras Planas</a></li>
                                <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Columnas</a></li>
                                <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Portadas Financieras</a></li>
                                <li><a class="{{ $route == 'news' ? ' active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Cartones</a></li>
                                {{-- <li class="dropdown">
                                    <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                        Portadas
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="/primeras-planas">Primeras Planas</a></li>
                                        <li><a href="/portadas-financieras">Portadas Financieras</a></li>
                                        <li><a href="/cartones">Cartones</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <li class="dropdown">
                                    <a class="btn dropdown-toggle user" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                        Columnas
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="/columnas-financieras">Columnas Financieras</a></li>
                                        <li><a href="/columnas-politicas">Columnas Politicas</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <li class="dropdown">
                                  <div class="dropdown">
                                      <a id="report" class="btn dropdown-toggle user" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="true" href="javascript:void(0);">
                                          Reportes <span class="caret"></span>
                                      </a>
                                          <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu">
                                        
                                        <li><a href="/reporte/cliente">Noticias por cliente</a></li>
                                        <li><a href="#">Reporte de notas por día</a></li>
                                      </ul>
                                  </div>
                                </li> --}}
                                <li>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle user" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        {{ strtoupper(Auth::user()->name) }}
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
                        @endif
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
@endif