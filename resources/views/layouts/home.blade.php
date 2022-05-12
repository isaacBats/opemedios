@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        @php
            $anio = date('Y');
        @endphp
        <meta name="description" content="Operadora de Medios Informativos {{ $anio }}">
        <meta name="author"      content="Isaac Daniel Batista">
        @yield('metas')
        @if( $route != 'home' &&  $route != 'about' &&  $route != 'clients' &&  $route != 'signin' &&  $route != 'contact')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @endif
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'Opemedios') }} @yield('title')</title>

        <!-- Fonts -->
         <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="{{ asset('uikit/css/uikit.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('icomoon/style.css') }}" />

        <!-- Style -->
        <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css">
        @yield('styles')
        <style>
            .lds-roller {
              display: inline-block;
              position: relative;
              width: 80px;
              height: 80px;
            }
            .lds-roller div {
              animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
              transform-origin: 40px 40px;
            }
            .lds-roller div:after {
              content: " ";
              display: block;
              position: absolute;
              width: 7px;
              height: 7px;
              border-radius: 50%;
              background: #dfc;
              margin: -4px 0 0 -4px;
            }
            .lds-roller div:nth-child(1) {
              animation-delay: -0.036s;
            }
            .lds-roller div:nth-child(1):after {
              top: 63px;
              left: 63px;
            }
            .lds-roller div:nth-child(2) {
              animation-delay: -0.072s;
            }
            .lds-roller div:nth-child(2):after {
              top: 68px;
              left: 56px;
            }
            .lds-roller div:nth-child(3) {
              animation-delay: -0.108s;
            }
            .lds-roller div:nth-child(3):after {
              top: 71px;
              left: 48px;
            }
            .lds-roller div:nth-child(4) {
              animation-delay: -0.144s;
            }
            .lds-roller div:nth-child(4):after {
              top: 72px;
              left: 40px;
            }
            .lds-roller div:nth-child(5) {
              animation-delay: -0.18s;
            }
            .lds-roller div:nth-child(5):after {
              top: 71px;
              left: 32px;
            }
            .lds-roller div:nth-child(6) {
              animation-delay: -0.216s;
            }
            .lds-roller div:nth-child(6):after {
              top: 68px;
              left: 24px;
            }
            .lds-roller div:nth-child(7) {
              animation-delay: -0.252s;
            }
            .lds-roller div:nth-child(7):after {
              top: 63px;
              left: 17px;
            }
            .lds-roller div:nth-child(8) {
              animation-delay: -0.288s;
            }
            .lds-roller div:nth-child(8):after {
              top: 56px;
              left: 12px;
            }
            @keyframes lds-roller {
              0% {
                transform: rotate(0deg);
              }
              100% {
                transform: rotate(360deg);
              }
            }
        </style>
    </head>
    @if( $route == 'home' || $route == 'clients' || $route == 'contact' || $route == 'signin' )
    <body class="{{ str_replace('.', '-', $route) }}">
    @elseif ( $route == 'about' )
    <body class="{{ str_replace('.', '-', $route) }}" style="background-image: url({{ asset('images/home/aboutus.jpg') }});">
    @else
        <body class="{{ str_replace('.', '-', $route) }} with-side-menu">
    @endif
    @yield('shared-scripts')
        {{-- $route --}}
        <header>
            @include('components.menu-client')
        </header>        
        
        @yield('content')
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

        <footer class="uk-section uk-padding-remove-bottom">
            <section class="op-icons-mark uk-container">

                <div class="social uk-grid-divider uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-flex uk-flex-center" uk-grid>
                   <!-- <div class="social-yt">
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>-->
                    @php /*
                    <div class="item go-0 uk-text-center uk-text-left@m uk-hidden">
                        <div class="icon"><i class="icon-map-pin"></i> Av. Revolución No. 308 - 8<br> Col. Escandón I Sección<br> CDMX, Alcaldía Miguel Hidalgo<br> C.P. 11800</div>
                    </div>
                    
                    <div class="item go-1 uk-text-center uk-hidden">
                        <a class="ope-contact" href="mailto:contacto@opemedios.com.mx?subject=Correo%20de%20contacto" target="_blank">
                            <div class="icon"><i class="icon-mail"></i> contacto@opemedios.com.mx</div>
                        </a>
                        <br>
                        <div class="ope-contact">
                            <a class="ope-contact" href="tel:5563868892" target="_blank" class="icon">
                                <i class="icon-phone"></i>&nbsp;&nbsp;55 638 688 92
                            </a>
                            <br>
                            <a class="ope-contact" href="tel:5563868893" target="_blank" class="icon">
                                <i class="icon-phone"></i>&nbsp;&nbsp;55 638 688 93
                            </a>
                        </div>
                    </div> */
                    @endphp
                    <div class="uk-text-center uk-flex-first uk-flex-last@s links-sociales">
                        <a href="https://twitter.com/DeMonitoreo" target="_blank" class="uk-padding uk-padding-remove-top icon-twitter"></a>
                        <a href="https://www.facebook.com/OPEMEDIOS/" target="_blank" class="uk-padding uk-padding-remove-top icon-facebook"></a>
                    </div>

                </div>
                
                <div class="legal uk-text-center uk-padding-large uk-padding-remove-bottom uk-padding-remove-horizontal">
                    <p><span>&#169; {{ $anio }} OPEMEDIOS</span>  <!--<span class="legal-spacer">|</span> AVISO DE PRIVACIDAD <span class="legal-spacer">|</span> TERMINOS Y CONDICIONES--></p>
                </div>
            </section>
                    
        </footer>
        <!--<div class="top"><i class="fas fa-arrow-up fa-lg"></i></div>-->
        <!-- UIkit JS -->
        <script src="{{ asset('uikit/js/uikit.min.js') }}"></script>
        <!--<script src="{{ asset('uikit/js/uikit-icons.min.js') }}"></script>-->
        
        <script
              src="https://code.jquery.com/jquery-3.5.1.min.js"
              integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
              crossorigin="anonymous"></script>
        @php
            $slug = session()->get('slug_company');
            $route = Route::getCurrentRoute()->getName();
        @endphp
        <!-- FA -->
        <!--<script defer src="//use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>-->
        <!-- Scripts-->
        <script src="{{ asset('js/home/scripts.js') }}"></script>

        @if( $route == 'home' || $route == 'about' || $route == 'clients' || $route == 'contact' || $route == 'signin' )
        @else
        <script src="{{ asset('js/home/template.js') }}"></script>
        <script src="{{ asset('js/home/client.js') }}"></script>
        @endif
        @yield('scripts')
        @if( $route == 'client.shownew')
        <style>
        </style>
            <script src="{{ asset('js/pdfobject.min.js') }}"></script>
            <script>
            if(!PDFObject.supportsPDFs){
                $(".lightbox.pdf").addClass('uk-hidden');
                $(".no-pdf-inline").removeClass('uk-hidden');
            }
            </script>
        @endif
    </body>
</html>
