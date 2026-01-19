@extends('layouts.home-clientv3')
@section('title', ' - Entrar a mi cuenta')
@section('styles')
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 140px 1rem 60px;
            background: var(--ope-gray-100);
        }

        .login-card {
            background: var(--ope-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
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

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .login-section {
                padding-top: 120px;
            }
        }

        @media (max-width: 767px) {
            .login-section {
                padding: 100px 1rem 40px;
                align-items: flex-start;
            }

            .login-card {
                padding: 1.5rem;
                border-radius: var(--radius-md);
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
                padding: 90px 0.75rem 30px;
            }

            .login-card {
                padding: 1.25rem;
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

        /* reCAPTCHA container styling */
        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
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

                    <div class="form-group-modern recaptcha-container">
                        {!! NoCaptcha::display() !!}
                    </div>

                    <button type="submit" class="btn-saas btn-saas-primary btn-login">
                        Entrar
                        <i class='bx bx-log-in-circle'></i>
                    </button>
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
    {!! NoCaptcha::renderJs() !!}
@endsection
