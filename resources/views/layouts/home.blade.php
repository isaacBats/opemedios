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
        <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />

        <!-- Style -->
        <link href="{{ asset('css/home/style.css') }}" media="all" rel="stylesheet" type="text/css">
        @yield('styles')
    </head>
    <body class="home">
        <header>
            @include('components.menu-client')
        </header>

        @yield('content')


        <div id="contact-form" class="uk-modal-full" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                <div class="uk-container" uk-height-viewport>
                    <div class="uk-grid-divider uk-child-width-1-2@s uk-flex-middle" uk-grid>
                        <div class="uk-padding-large">
                            <h1>Contáctanos</h1>
                            <p>Nos encantaría saber de usted. ¿Interesados en trabajar juntos? Rellene el siguiente formulario con una breve información sobre su proyecto y nos pondremos en contacto tan pronto como sea posible. Por favor espere un par de días nuestra respuesta.</p>
                            <hr>
                            <div class="widget">
                                <address>
                                    Ures 69, Col. Roma Sur CP. 06760, México, DF, Del. Cuauhtémoc
                                </address>
                                <address>
                                    <a href="tel:5555846410" target="_blank">55-5584-64-10</a>
                                </address>
                                <email>
                                    <a href="mailto:contacto@opemedios.com.mx" target="_blank">contacto@opemedios.com.mx</a>
                                </email>
                            </div>
                        </div>
                        <div class="uk-padding-large">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form id="form-contact" class="f-contact" method="POST" action="{{ route('form.contact') }}">
                            @csrf
                            
                                <div class="uk-margin">
                                    <input class="form-control uk-input" type="text" name="name" placeholder="*Nombre" required>
                                </div>
                                <div class="uk-margin">
                                    <input class="form-control uk-input" type="email" name="email" placeholder="*Email" required>
                                </div>
                                <div class="uk-margin">
                                    <input class="form-control uk-input" type="text" name="phone" placeholder="Teléfono">
                                </div>
                                <div class="uk-margin">
                                    <textarea name="message" placeholder="Escribanos un mensaje..." class="form-control uk-textarea" rows="9" required></textarea>
                                </div>
                            
                                <hr>
                            
                                <div class="uk-margin">
                                    <input id="btn-send-form-contact" class="btn btn-action uk-button uk-button-large uk-button-default" type="submit" value="Enviar mensaje">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="uk-section uk-section-secondary">
            <section class="op-icons-mark uk-container">

                <div class="social uk-text-center">
                   <!-- <div class="social-yt">
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>-->
                    <a href="https://twitter.com/DeMonitoreo" target="_blank" uk-icon="icon: twitter; ratio: 1.5;" class="uk-padding uk-padding-remove-top"></a>
                    <a href="https://www.facebook.com/OPEMEDIOS/" target="_blank" uk-icon="icon: facebook; ratio: 1.5;" class="uk-padding uk-padding-remove-top"></a>
               
                    
                    <div class="item go-0">
                        <div class="icon"><i class="fas fa-map-marker-alt fa-lg"></i> Ures 69, Col. Roma Sur<br> CP. 06760, México,<br> DF, Del. Cuauhtémoc</div>
                    </div>
                    <br>
                    <div class="item go-1">
                        <a class="ope-contact" href="mailto:contacto@opemedios.com.mx?subject=Correo%20de%20contacto" target="_blank">
                            <div class="icon"><i class="far fa-envelope fa-lg"></i> contacto@opemedios.com.mx</div>
                        </a>
                    </div>
                    <br>
                    <div class="item go-2">
                        <a class="ope-contact" href="tel:5555846410" target="_blank">
                            <div class="icon"><i class="fas fa-phone fa-lg"></i> 55-5584-64-10</div>
                        </a>
                    </div>
                </div>
                
                <div class="legal uk-text-center uk-padding-large uk-padding-remove-bottom uk-padding-remove-horizontal">
                    <p><span>&#169; {{ $anio }} OPEMEDIOS</span>  <!--<span class="legal-spacer">|</span> AVISO DE PRIVACIDAD <span class="legal-spacer">|</span> TERMINOS Y CONDICIONES--></p>
                </div>
            </section>
                    
        </footer>
        <!--<div class="top"><i class="fas fa-arrow-up fa-lg"></i></div>-->
        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

        <!-- FA -->
        <script defer src="//use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
        <!-- Scripts-->
        <script src="{{ asset('js/home/scripts.js') }}"></script>

        @yield('scripts')
    </body>
</html>
