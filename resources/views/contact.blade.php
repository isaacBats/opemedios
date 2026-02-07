@extends('layouts.home')
@section('title', ' - Contacto')
@section('styles')
    @if(\App\Services\RecaptchaV3Service::isEnabled())
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <style>.grecaptcha-badge { visibility: hidden; }</style>
    @endif
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
                        <i class="icon-phone"></i> <a href="tel:5540304996" target="_blank">55 4030 4996</a>
                    </address>
                    <address>
                        <i class="icon-phone"></i> <a href="tel:5534951145" target="_blank">55 3495 1145</a>
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
                    {{-- reCAPTCHA v3 hidden input --}}
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    @error('g-recaptcha-response')
                        <label class="uk-text-danger uk-text-bold uk-text-small" role="alert">
                            <strong>{{ $message }}</strong>
                        </label>
                    @enderror

                    @if(\App\Services\RecaptchaV3Service::isEnabled())
                        <p style="font-size: 0.75rem; color: #666; margin-top: 10px;">
                            Este sitio está protegido por reCAPTCHA.
                            <a href="https://policies.google.com/privacy" target="_blank">Privacidad</a> |
                            <a href="https://policies.google.com/terms" target="_blank">Términos</a>
                        </p>
                    @endif
                    <hr>

                    <div class="uk-margin">
                        <input id="btn-send-form-contact" class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Enviar mensaje">
                    </div>
                </form>
            </div>
        </div>
    </div>  <!-- /container -->
@endsection

@section('scripts')
    @if(\App\Services\RecaptchaV3Service::isEnabled())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('form-contact');
                var submitBtn = document.getElementById('btn-send-form-contact');
                var recaptchaInput = document.getElementById('g-recaptcha-response');
                var siteKey = '{{ config('services.recaptcha.site_key') }}';

                if (form && submitBtn && recaptchaInput) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        var originalValue = submitBtn.value;
                        submitBtn.disabled = true;
                        submitBtn.value = 'Enviando...';

                        grecaptcha.ready(function() {
                            grecaptcha.execute(siteKey, { action: 'contact' })
                                .then(function(token) {
                                    recaptchaInput.value = token;
                                    form.submit();
                                })
                                .catch(function(error) {
                                    console.error('reCAPTCHA error:', error);
                                    submitBtn.disabled = false;
                                    submitBtn.value = originalValue;
                                    alert('Error de verificación. Por favor, intenta de nuevo.');
                                });
                        });
                    });
                }
            });
        </script>
    @endif
@endsection
