@extends('layouts.signin')

@section('title-section', ' - Restablecer la contraseña')

@section('content')
<div class="panel signin">
  <div class="panel-heading">
    <h1><a href="{{ url('/') }}">{{ config('app.name') }}</a></h1>
    <h4 class="panel-title">Restablecer la contraseña.</h4>
  </div>
  <div class="panel-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
        @csrf
        <div class="form-group mb10">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo') }}" name="email" value="{{ old('email') }}" required>

            </div>
            @if ($errors->has('email'))
                <span class="invalid-feedback text-muted" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <button type="subit" class="btn btn-success btn-quirk btn-block">Enviar enlace</button>
        </div>
    </form>
    <hr class="invisible">
    <div class="form-group">
      <a href="{{ url('/') }}" class="btn btn-default btn-quirk btn-stroke btn-stroke-thin btn-block btn-sign"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
    </div>
  </div>
</div><!-- panel -->
@endsection
