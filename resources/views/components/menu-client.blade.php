@php
    $route = Route::getCurrentRoute()->getName();
@endphp
@if( $route == 'home' || $route == 'about' || $route == 'clients' || $route == 'contact' || $route == 'signin'  )
<div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent uk-dark; top: 250;">
    <div class="uk-container uk-dark">
        <nav class="uk-navbar-container uk-navbar-transparent uk-container" uk-navbar>
            <div class="uk-navbar-left uk-hidden@m">
                <button id="menu-sitio-toggle" class="uk-button uk-button-default" type="button" uk-navbar-toggle-icon uk-toggle="target: #menu-sitio"></button>
            </div>
            <div class="uk-navbar-left logo-opemedios">
                <a class="uk-navbar-item uk-logo" href="{{ route('home') }}"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" /></a>
            </div>
            <div class="uk-navbar-right uk-width-expand uk-flex uk-flex-right" id="menu-sitio">
                <ul class="uk-navbar-nav">
                    <li class="uk-hidden@m uk-text-center">
                        <img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" />
                        <hr>
                    </li>
                    @if( $route != 'home')
                    <li><a href="{{ route('home') }}" class="{{ $route == 'home' ? ' uk-active' : '' }}">Inicio</a></li>
                    @endif
                    <li class="{{ $route == 'about' ? ' uk-active' : '' }}"><a href="{{ route('about') }}">Quiénes somos</a></li>
                    <li class="{{ $route == 'clients' ? ' uk-active' : '' }}"><a href="{{ route('clients') }}">Clientes</a></li>
                    @hasanyrole('client|manager|admin')
                    <li class="uk-hidden@m">
                        <a class="{{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $company]) }}">
                            <span >Dashboard</span>
                        </a>
                    </li>
                    @else
                    <li class="uk-hidden@m">
                        <a class="{{ $route == 'signin' ? ' uk-active' : '' }}" href="{{ route('signin') }}">
                            <span >Iniciar Sesión</span>
                        </a>
                    </li>
                    @endhasanyrole
                    <li>
                        <a class="uk-hidden@m" href="{{ route('contact') }}">Contáctanos</a>
                    </a>
                    </li>
                    <li class="uk-hidden@m uk-text-center">
                        <hr>
                        <hr>
                        <div class="uk-flex-center uk-grid-divider" uk-grid>
                            <a href="https://twitter.com/DeMonitoreo" target="_blank" style="color: #333;"><i class="icon-twitter"></i></a>
                            <a href="https://www.facebook.com/OPEMEDIOS/" target="_blank" style="color: #333;"><i class="icon-facebook"></i></a>
                        </div>
                    </li>
                </ul>
                <div class="uk-visible@m" style="padding-left: 40px;">
                    @hasanyrole('client|manager|admin')
                    <a class="uk-button uk-button-secondary {{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $company]) }}">
                        <span >Dashboard</span>
                    </a>
                    @else
                    <a class="uk-button uk-button-secondary {{ $route == 'signin' ? ' uk-active' : '' }}" href="{{ route('signin') }}">
                        <span >Iniciar Sesión</span>
                    </a>
                    @endhasanyrole
                </div>
            </div>
            <div class="uk-navbar-right contact" style="padding-left: 30px;">
                <a id="contact-button" class="uk-button uk-button-secondary" href="{{ route('contact') }}">
                    <span class="uk-visible@s">Contáctanos</span>
                    <span class="uk-hidden@s icon-mail"></span>
                </a>
            </div>
        </nav>
    </div>
</div>
@else
<div class="uk-hidden@l" uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent uk-dark; top: 250;">
    <div class="uk-container uk-dark">
        <nav class="uk-navbar-container uk-navbar-transparent uk-container" uk-navbar>
            <div class="uk-navbar-left">
                <button id="menu-sitio-toggle" class="uk-button uk-button-default" type="button" uk-toggle="target: #offcanvas-nav" uk-navbar-toggle-icon></button>
            </div>
            <div class="uk-navbar-left logo-opemedios uk-width-expand">
                <a class="uk-navbar-item uk-logo" href="{{ route('home') }}" style="margin: 0 auto;"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios"/></a>
            </div>
        </nav>
    </div>
</div>

<div id="offcanvas-nav" uk-offcanvas="mode: push; overlay: true;">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-default uk-text-bold uk-text-uppercase">
            <li><a class="uk-navbar-item uk-logo" href="{{ route('home') }}"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" /></a><br><br></li>
            @hasanyrole('client|manager|admin')
                @if(auth()->user()->companies->count() > 0)
                    <li>
                        <div class="uk-form-controls" uk-form-custom="target: true">
                            <select name="parent" id="select-parent" class="uk-select">
                                @foreach(auth()->user()->companies as $entity)
                                    <option {{ $entity->slug == session()->get('slug_company') ? 'selected' : ''}} value="{{ $entity->slug }}">{{ $entity->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="empresas-btn">EMPRESAS <span class="icon-chevron-down"></span></button>
                        </div>
                    </li>
                @endif
            @endhasanyrole
            @hasanyrole('client|manager|admin')
            <li class="{{ $route == 'news' ? ' uk-active' : '' }}"><a href="{{ route('news', ['company' => $company]) }}">Dashboard</a></li>
            <li class="{{ $route == 'client.mynews' ? ' uk-active' : '' }}"><a href="{{ route('client.mynews', ['company' => $company]) }}">Mis noticias</a></li>
            <li class="uk-nav-header uk-text-light">Archivo</li>
            <li class="{{ request('type') == 'primeras' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $company, 'type' => 'primeras']) }}">Primeras Planas</a></li>
            <li class="{{ request('type') == 'politicas' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $company, 'type' => 'politicas']) }}">Columnas Pol&iacute;ticas</a></li>
            <li class="{{ request('type') == 'financieras' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $company, 'type' => 'financieras']) }}">Columnas Financieras</a></li>
            <li class="{{ request('type') == 'portadas' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $company, 'type' => 'portadas']) }}">Portadas Financieras</a></li>
            <li class="{{ request('type') == 'cartones' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $company, 'type' => 'cartones']) }}">Cartones</a><br></li>
            <li class="uk-nav-header uk-text-light">Reporte</li>
            <li class="{{ request('type') == 'reporte' ? ' uk-active' : '' }}"><a href="{{ route('client.report', ['company' => $company]) }}">Reportes</a><br></li>
            @hasanyrole('manager|admin')
            <li class="uk-nav-divider"></li>
            <li ><a href="{{ route('panel') }}">Volver al admin</a><br></li>
            @endhasanyrole
            <li class="uk-nav-divider"></li>
            <li class="uk-nav-header uk-text-light"><i class="icon-user"></i> {{ strtoupper(Auth::user()->name) }}</li>
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
            @endhasanyrole
        </ul>
    </div>
</div>
@endif
