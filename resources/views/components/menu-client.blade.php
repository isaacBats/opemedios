@php
    $slug = session()->get('slug_company');
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
                    @hasrole('client')
                    <li class="uk-hidden@m">
                        <a class="{{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">
                            <span >Dashboard</span>
                        </a>
                    </li>
                    @else
                    <li class="uk-hidden@m">
                        <a class="{{ $route == 'signin' ? ' uk-active' : '' }}" href="{{ route('signin') }}">
                            <span >Iniciar Sesión</span>
                        </a>
                    </li>
                    @endhasrole
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
                    @hasrole('client')
                    <a class="uk-button uk-button-secondary {{ $route == 'news' ? ' uk-active' : '' }}" href="{{ route('news', ['company' => $slug]) }}">
                        <span >Dashboard</span>
                    </a>
                    @else
                    <a class="uk-button uk-button-secondary {{ $route == 'signin' ? ' uk-active' : '' }}" href="{{ route('signin') }}">
                        <span >Iniciar Sesión</span>
                    </a>
                    @endhasrole
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
            @if( $route == 'news')
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav scroll-to uk-list">
                    <li>
                        <a href="#" uk-icon="chevron-down">Temas</a>
                        <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav uk-panel-scrollable" uk-scrollspy-nav="closest: li; scroll: true; offset: 200;">
                            @foreach($company->themes as $theme)
                            <li style="margin-top: 10px;">
                                <a href="#theme{{ $theme->id }}">{{ $theme->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        </div>
                    </li>
                </ul>
            </div>
            @elseif( $route == 'themes')
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav list-group" id="list-group-themes">
                    <li>
                        <a href="#">Temas<i class="icon-chevron-down"></i></a>
                        <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav" id="themes">
                            @foreach ($company->themes as $theme)
                            <li class="list-group-item theme-transition @if($theme->id == $defaultThemeId) uk-active @endif"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}">{{ $theme->name }}</a></li>
                            @endforeach
                        </ul>
                        </div>
                    </li>
                </ul>
            </div>
            @endif
        </nav>
    </div>
</div>
    
<div id="offcanvas-nav" uk-offcanvas="mode: push; overlay: true;">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-default uk-text-bold uk-text-uppercase">
            <li><a class="uk-navbar-item uk-logo" href="{{ route('home') }}"><img src="{{ asset('images/opemedios-logo.png') }}" alt="logo opeMedios" /></a><br><br></li>
            @hasrole('client')
            <li class="{{ $route == 'news' ? ' uk-active' : '' }}"><a href="{{ route('news', ['company' => $slug]) }}">Dashboard</a></li>
            <li class="{{ $route == 'themes' ? ' uk-active' : '' }}"><a href="{{ route('themes', ['company' => $slug]) }}">Mis temas</a></li>
            <li class="{{ $route == 'client.others.news' ? ' uk-active' : '' }}"><a href="{{ route('client.others.news', ['company' => $slug]) }}">Otras notas</a></li>
            <li class="uk-nav-header uk-text-light">Archivo</li>
            <li class="{{ request('type') == 'primeras' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $slug, 'type' => 'primeras']) }}">Primeras Planas</a></li>
            <li class="{{ request('type') == 'politicas' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $slug, 'type' => 'politicas']) }}">Columnas Pol&iacute;ticas</a></li>
            <li class="{{ request('type') == 'financieras' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $slug, 'type' => 'financieras']) }}">Columnas Financieras</a></li>
            <li class="{{ request('type') == 'portadas' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $slug, 'type' => 'portadas']) }}">Portadas Financieras</a></li>
            <li class="{{ request('type') == 'cartones' ? ' uk-active' : '' }}"><a href="{{ route('client.sections', ['company' => $slug, 'type' => 'cartones']) }}">Cartones</a><br></li>
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
            @endhasrole
        </ul>

    </div>
</div>
@endif