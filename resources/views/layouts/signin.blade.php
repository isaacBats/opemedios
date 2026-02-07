<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="Este es el login de la pagina de opemedios">
  <meta name="author" content="Isaac Daniel Batista">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Opemedios') }}@yield('title-section', ' - ')</title>

  <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/font-awesome.css') }}">

  <link rel="stylesheet" href="{{ asset('css/quirk.css') }}">

  <script src="{{ asset('lib/modernizr/modernizr.js') }}"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('lib/html5shiv/html5shiv.js') }}"></script>
  <script src="{{ asset('lib/respond/respond.src.js') }}"></script>
  <![endif]-->

  {{-- reCAPTCHA v3 Script --}}
  @if(\App\Services\RecaptchaV3Service::isEnabled())
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
  @endif
</head>

<body class="signwrapper">

  <div class="sign-overlay"></div>
  <div class="signpanel"></div>

  @yield('content')

  {{-- reCAPTCHA v3 Form Handler --}}
  @if(\App\Services\RecaptchaV3Service::isEnabled())
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form[action*="login"]');
        var submitBtn = document.getElementById('login-submit-btn');
        var recaptchaInput = document.getElementById('g-recaptcha-response');
        var siteKey = '{{ config('services.recaptcha.site_key') }}';

        if (form && submitBtn && recaptchaInput) {
          form.addEventListener('submit', function(e) {
            e.preventDefault();

            var originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Verificando...';

            grecaptcha.ready(function() {
              grecaptcha.execute(siteKey, { action: 'login' })
                .then(function(token) {
                  recaptchaInput.value = token;
                  form.submit();
                })
                .catch(function(error) {
                  console.error('reCAPTCHA error:', error);
                  submitBtn.disabled = false;
                  submitBtn.innerHTML = originalText;
                  alert('Error de verificación. Por favor, intenta de nuevo.');
                });
            });
          });
        }
      });
    </script>
  @endif

  @yield('scripts')

</body>
</html>
