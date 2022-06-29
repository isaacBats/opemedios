@extends('layouts.home')
@section('title', ' - Contacto')
@section('styles')
    {!! NoCaptcha::renderJs() !!}
@endsection
@section('content')
    <!-- container -->
    <div class="uk-container op-content-mt">
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
                <div class="alert alert-success uk-text-success uk-text-bold">
                    {{ session('status') }}
                </div>
                <hr>
                @endif
                <form id="form-contact" class="f-contact" method="POST" action="{{ route('form.contact') }}">
                @csrf
                
                    <div class="uk-margin">
                        <label for="name">Nombre*</label>
                        <input class="form-control uk-input" type="text" name="name" 
                            placeholder="Nombre" 
                            value="{{ old('name') }}" required>
                        @error('name')
                            <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="uk-margin">
                        <label for="email">Correo*</label>
                        <input class="form-control uk-input" type="email" name="email" 
                            value="{{ old('email') }}"
                            placeholder="contacto&#64;contacto.com" required>
                        @error('email')
                            <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="uk-margin">
                        <label for="phone">Teléfono</label>
                        <input class="form-control uk-input" type="text" name="phone" 
                            value="{{ old('phone')}}"
                            placeholder="*5512345678" required>
                        @error('phone')
                            <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="uk-margin">
                        <label for="message">Mensaje *</label>
                        <textarea name="message" class="form-control uk-textarea" rows="9" required>{{ old('message') }}</textarea>
                        @error('message')
                            <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                     {!! NoCaptcha::display() !!}
                     @error('g-recaptcha-response')
                        <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                            <strong>{{ $message }}</strong>
                        </label>
                    @enderror
                    <hr>
                
                    <div class="uk-margin">
                        <input id="btn-send-form-contact" class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Enviar mensaje">
                    </div>
                </form>
            </div>
        </div>
    </div>  <!-- /container -->
@endsection
