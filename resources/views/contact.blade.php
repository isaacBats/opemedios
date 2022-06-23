@extends('layouts.home')
@section('title', ' - Contacto')
@section('content')
    <!-- container -->
    <div class="uk-container op-content-mt">
        @if($errors->any())
            <ul class="uk-list uk-list-hyphen">
            @foreach($errors->all() as $message)
                <li class="uk-text-danger uk-text-bold uk-text-small">{{ $message }}</li>
            @endforeach
            </ul>
        @endif

        <div class="uk-grid-divider uk-child-width-1-2@s uk-flex-middle uk-padding-large uk-padding-remove-horizontal" uk-grid>
            <div>
                <h1 class="page-title">Contáctanos</h1>
                <p>Nos encantaría saber de usted. ¿Interesados en trabajar juntos? Rellene el siguiente formulario con una breve información sobre su proyecto y nos pondremos en contacto tan pronto como sea posible. Por favor espere un par de días nuestra respuesta.</p>
                <hr>
                <div class="widget">
                    <address>
                        <i class="icon-map-pin"></i> Ures 69, Col. Roma Sur CP. 06760, México, DF, Del. Cuauhtémoc
                    </address>
                    <address>
                        <i class="icon-phone"></i> <a href="tel:5555846410" target="_blank">55-5584-64-10</a>
                    </address>
                    <email>
                        <i class="icon-mail"></i> <a href="mailto:contacto@opemedios.com.mx" target="_blank">contacto@opemedios.com.mx</a>
                    </email>
                </div>
            </div>
            <div>
                @if (session('status'))
                <div class="alert alert-success uk-text-success">
                    {{ session('status') }}
                </div>
                <hr>
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
                        <input class="form-control uk-input" type="text" name="phone" placeholder="*Teléfono" required>
                    </div>
                    <div class="uk-margin">
                        <textarea name="message" placeholder="Escribanos un mensaje..." class="form-control uk-textarea" rows="9" required></textarea>
                    </div>
                
                    <hr>
                
                    <div class="uk-margin">
                        <input id="btn-send-form-contact" class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Enviar mensaje">
                    </div>
                </form>
            </div>
        </div>
    </div>  <!-- /container -->
@endsection
