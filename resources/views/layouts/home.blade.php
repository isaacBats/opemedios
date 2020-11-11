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
    </head>
    @if( $route == 'home' || $route == 'clients' || $route == 'contact' || $route == 'signin' )
    <body class="{{ str_replace('.', '-', $route) }}">
    @elseif ( $route == 'about' )
    <body class="{{ str_replace('.', '-', $route) }}" style="background-image: url({{ asset('images/home/aboutus.jpg') }});">
    @else
        <body class="{{ str_replace('.', '-', $route) }} with-side-menu">
    @endif
        {{-- $route --}}
        <header>
            @include('components.menu-client')
        </header>

        @yield('content')

        <footer class="uk-section uk-padding-remove-bottom">
            <section class="op-icons-mark uk-container">

                <div class="social uk-grid-divider uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-flex uk-flex-center" uk-grid>
                   <!-- <div class="social-yt">
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>-->
                    
                    <div class="item go-0 uk-text-center uk-text-left@m">
                        <div class="icon"><i class="icon-map-pin"></i> Ures 69, Col. Roma Sur<br> CP. 06760, México,<br> DF, Del. Cuauhtémoc</div>
                    </div>
                    
                    <div class="item go-1 uk-text-center">
                        <a class="ope-contact" href="mailto:contacto@opemedios.com.mx?subject=Correo%20de%20contacto" target="_blank">
                            <div class="icon"><i class="icon-mail"></i> contacto@opemedios.com.mx</div>
                        </a>
                        <br>
                        <a class="ope-contact" href="tel:5555846410" target="_blank">
                            <div class="icon"><i class="icon-phone"></i> 55-5584-64-10</div>
                        </a>
                    </div>

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
