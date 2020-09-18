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
                        <li><a href="{{ route('home') }}" class="{{ $route == 'home' ? ' uk-active' : '' }}">Inicio</a></li>
                        <li><a href="{{ route('about') }}" class="{{ $route == 'about' ? ' uk-active' : '' }}">Quiénes somos</a></li>
                        <li><a href="{{ route('clients') }}" class="{{ $route == 'clients' ? ' uk-active' : '' }}">Clientes</a></li>
                        <li><a href="{{ route('contact') }}" class="{{ $route == 'contact' ? ' uk-active' : '' }}">Contacto</a></li>
                        @hasrole('client')
                            <li><a class="{{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                        @else
                            <li><a class="btn{{ $route == 'signin' ? ' uk-active' : '' }}" href="{{ route('signin') }}">Iniciar Sesión</a></li>
                        @endhasrole
                    @else
                        @hasrole('client')
                            <li><a class="{{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                            <li><a class="{{ $route == 'themes' ? ' uk-active' : '' }}" href="{{ route('themes', ['company' => $slug]) }}">Mis temas</a></li>
                            <li><a class="{{ $route == 'client.others.news' ? ' uk-active' : '' }}" href="{{ route('client.others.news', ['company' => $slug]) }}">Otras notas</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle user btn-ope" type="button" id="menuArchivo" data-toggle="dropdown" > ARCHIVO <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right ope-menu" role="menu" aria-labelledby="menuArchivo">
                                        <li><a class="{{ request('type') == 'primeras' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'primeras']) }}">Primeras Planas</a></li>
                                        <li><a class="{{ request('type') == 'politicas' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'politicas']) }}">Columnas Pol&iacute;ticas</a></li>
                                        <li><a class="{{ request('type') == 'financieras' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'financieras']) }}">Columnas Financieras</a></li>
                                        <li><a class="{{ request('type') == 'portadas' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'portadas']) }}">Portadas Financieras</a></li>
                                        <li><a class="{{ request('type') == 'cartones' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'cartones']) }}">Cartones</a></li>
                                    </ul>
                                </div>
                            </li>
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
<div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent uk-light; top: 250;">
    <div class="uk-container uk-dark">
        <nav class="uk-navbar-container uk-navbar-transparent uk-container" uk-navbar>
            <div class="uk-navbar-left uk-hidden@m">
                <a class="uk-navbar-toggle" uk-navbar-toggle-icon href=""></a>
            </div>
            <div class="uk-navbar-left uk-visible@m">
                <a class="uk-navbar-item uk-logo" href="{{ route('home') }}"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" /></a>
            </div>
            <div class="uk-navbar-center uk-hidden@m">
                <a class="uk-navbar-item uk-logo" href="{{ route('home') }}"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" /></a>
            </div>
            <div class="uk-navbar-right uk-visible@m">
                <ul class="uk-navbar-nav">
                    @if( $route == 'home' || $route == 'about' || $route == 'clients' || $route == 'contact' || $route == 'signin' && auth()->guest())
                        @hasrole('client')
                            <li class="{{ $route == 'news' ? ' uk-active' : '' }}"><a href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                        @else
                            <li class="btn {{ $route == 'signin' ? ' uk-active' : '' }}"><a href="{{ route('signin') }}">Iniciar Sesión</a></li>
                        @endhasrole
                        <li class="{{ $route == 'clients' ? ' uk-active' : '' }}"><a href="{{ route('clients') }}">Clientes</a></li>
                        <li class="{{ $route == 'about' ? ' uk-active' : '' }}"><a href="{{ route('about') }}">Quiénes somos</a></li>
                    @else
                        @hasrole('client')
                            <li class="{{ $route == 'news' ? ' uk-active' : '' }}"><a href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
                            <li class="{{ $route == 'themes' ? ' uk-active' : '' }}"><a href="{{ route('themes', ['company' => $slug]) }}">Mis temas</a></li>
                            <li class="{{ $route == 'client.others.news' ? ' uk-active' : '' }}"><a href="{{ route('client.others.news', ['company' => $slug]) }}">Otras notas</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle user btn-ope" type="button" id="menuArchivo" data-toggle="dropdown" > ARCHIVO <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right ope-menu" role="menu" aria-labelledby="menuArchivo">
                                        <li><a class="{{ request('type') == 'primeras' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'primeras']) }}">Primeras Planas</a></li>
                                        <li><a class="{{ request('type') == 'politicas' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'politicas']) }}">Columnas Pol&iacute;ticas</a></li>
                                        <li><a class="{{ request('type') == 'financieras' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'financieras']) }}">Columnas Financieras</a></li>
                                        <li><a class="{{ request('type') == 'portadas' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'portadas']) }}">Portadas Financieras</a></li>
                                        <li><a class="{{ request('type') == 'cartones' ? ' uk-active' : '' }}" href="{{ route('client.sections', ['company' => $slug, 'type' => 'cartones']) }}">Cartones</a></li>
                                    </ul>
                                </div>
                            </li>
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
            </div>
            <div class="uk-navbar-right">
                <a class="uk-button uk-button-default" href="#contact-form" uk-toggle>Contáctanos</a>
            </div>
        </nav>
    </div>
</div>
@endif
