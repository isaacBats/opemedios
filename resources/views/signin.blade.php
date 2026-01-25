@extends('layouts.home-clientv3')
@section('title', ' - Entrar a mi cuenta')
@section('styles')
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 160px 1rem 80px;
            background: linear-gradient(135deg, var(--ope-gray-100) 0%, var(--ope-gray-200) 100%);
            position: relative;
        }

        /* Decorative background elements */
        .login-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: var(--ope-gradient);
            opacity: 0.03;
            pointer-events: none;
        }

        .login-card {
            background: var(--ope-white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: 3rem;
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            border: 1px solid var(--ope-gray-200);
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header .login-logo {
            width: 160px;
            margin-bottom: 1.25rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--ope-dark);
            margin-bottom: 0.5rem;
        }

        .login-header h1 .text-gradient {
            display: block;
        }

        .login-header p {
            color: var(--ope-gray-600);
            font-size: 0.9375rem;
        }

        /* Large screens (1600px+) - Increased safe area */
        @media (min-width: 1600px) {
            .login-section {
                padding-top: 180px;
                padding-bottom: 100px;
            }
        }

        @media (min-width: 1920px) {
            .login-section {
                padding-top: 200px;
                padding-bottom: 120px;
            }
        }

        /* Responsive adjustments - Tablet and below */
        @media (max-width: 991px) {
            .login-section {
                padding-top: 140px;
            }

            .login-card {
                padding: 2.5rem;
            }
        }

        @media (max-width: 767px) {
            .login-section {
                padding: 120px 1rem 60px;
                align-items: center;
            }

            .login-card {
                padding: 2rem;
                border-radius: var(--radius-lg);
            }

            .login-header .login-logo {
                width: 140px;
            }

            .login-header h1 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .login-section {
                padding: 100px 1rem 40px;
            }

            .login-card {
                padding: 1.5rem;
                border-radius: var(--radius-md);
            }
        }

        .login-form .form-group-modern {
            margin-bottom: 1.25rem;
        }

        .login-form .form-group-modern label {
            display: block;
            font-weight: 600;
            color: var(--ope-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9375rem;
        }

        .login-form .form-control-modern {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            border: 2px solid var(--ope-gray-300);
            border-radius: var(--radius-md);
            background: var(--ope-gray-100);
            transition: all var(--transition-base);
        }

        .login-form .form-control-modern:focus {
            border-color: var(--ope-primary);
            background: var(--ope-white);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .login-form .form-control-modern.is-invalid {
            border-color: #ef4444;
        }

        .login-form .btn-login {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--ope-gray-200);
        }

        .login-footer p {
            color: var(--ope-gray-600);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .login-footer a {
            color: var(--ope-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #b91c1c;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        /* reCAPTCHA v3 badge positioning */
        .grecaptcha-badge {
            visibility: hidden;
        }

        .recaptcha-notice {
            font-size: 0.75rem;
            color: var(--ope-gray-500);
            text-align: center;
            margin-top: 1rem;
            line-height: 1.5;
        }

        .recaptcha-notice a {
            color: var(--ope-gray-600);
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="login-card">
                <div class="login-header">
                    <img src="{{ asset('assets/clientv3/img/opemedios-logo.png') }}" alt="Opemedios" class="login-logo">
                    <h1>
                        Bienvenido
                        <span class="text-gradient">de nuevo</span>
                    </h1>
                    <p>Ingresa a tu cuenta para acceder a tus noticias</p>
                </div>

                @if ($errors->any())
                    <div class="error-message">
                        <i class='bx bx-error-circle'></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}@if (!$loop->last)<br>@endif
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form" id="login-form">
                    @csrf

                    <div class="form-group-modern">
                        <label for="email">
                            <i class='bx bx-envelope'></i> Correo electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control-modern @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="tu@email.com"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group-modern">
                        <label for="password">
                            <i class='bx bx-lock-alt'></i> Contraseña
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control-modern @error('password') is-invalid @enderror"
                            placeholder="Tu contraseña"
                            required
                        >
                    </div>

                    {{-- reCAPTCHA v3 hidden input --}}
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    <button type="submit" class="btn-saas btn-saas-primary btn-login" id="login-submit-btn">
                        Entrar
                        <i class='bx bx-log-in-circle'></i>
                    </button>

                    {{-- reCAPTCHA v3 notice (required by Google ToS) --}}
                    @if(\App\Services\RecaptchaV3Service::isEnabled())
                        <p class="recaptcha-notice">
                            Este sitio está protegido por reCAPTCHA y aplican la
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de Privacidad</a> y
                            <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de Google.
                        </p>
                    @endif
                </form>

                <div class="login-footer">
                    <p>
                        <i class='bx bx-help-circle'></i>
                        ¿Olvidaste tu contraseña?<br>
                        Contacta a soporte en <a href="mailto:contacto@opemedios.com.mx">contacto@opemedios.com.mx</a> para restablecerla.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @if(\App\Services\RecaptchaV3Service::isEnabled())
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('login-form');
                const submitBtn = document.getElementById('login-submit-btn');
                const recaptchaInput = document.getElementById('g-recaptcha-response');
                const siteKey = '{{ config('services.recaptcha.site_key') }}';

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Disable button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Verificando...';

                    // Execute reCAPTCHA v3
                    grecaptcha.ready(function() {
                        grecaptcha.execute(siteKey, { action: 'login' })
                            .then(function(token) {
                                recaptchaInput.value = token;
                                form.submit();
                            })
                            .catch(function(error) {
                                console.error('reCAPTCHA error:', error);
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = 'Entrar <i class="bx bx-log-in-circle"></i>';
                                alert('Error de verificación. Por favor, intenta de nuevo.');
                            });
                    });
                });
            });
        </script>
    @endif
@endsection
