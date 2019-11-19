@extends('layouts.signin')

@section('title-section', ' - Iniciar Sesión')

@section('content')
<div class="panel signin">
  <div class="panel-heading">
    <h1><a href="{{ url('/') }}">{{ config('app.name') }}</a></h1>
    <h4 class="panel-title">Bienvenido! Por favor identificate.</h4>
  </div>
  <div class="panel-body">
    {{-- <button class="btn btn-primary btn-quirk btn-fb btn-block">Connect with Facebook</button>
    <div class="or">or</div> --}}
    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @csrf
        <div class="form-group mb10">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo') }}" name="email" value="{{ old('email') }}" required autofocus>

            </div>
            @if ($errors->has('email'))
                <span class="invalid-feedback text-muted" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group nomargin">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password" name="password" required>

            </div>
            @if ($errors->has('password'))
                <span class="invalid-feedback text-muted" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div><a href="{{ route('password.request') }}" class="forgot">¿Se te olvidó tu contraseña?</a></div>
        <div class="form-group">
            <button type="subit" class="btn btn-success btn-quirk btn-block">Entrar</button>
        </div>
    </form>
    <hr class="invisible">
    <div class="form-group">
      <a href="{{ url('/') }}" class="btn btn-default btn-quirk btn-stroke btn-stroke-thin btn-block btn-sign"><span class="glyphicon glyphicon-arrow-left"></span> Regresar al Inicio</a>
    </div>
  </div>
</div><!-- panel -->
@endsection
