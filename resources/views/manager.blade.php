@extends('layouts.signin')
@section('title-section', ' - Administrador de sesiones')
@section('content')
    <div class="panel signin">
  <div class="panel-heading">
    <h1><a href="{{ url('/') }}">{{ config('app.name') }}</a></h1>
    <h4 class="panel-title">Administrador de accesos</h4>
  </div>
  <div class="panel-body">
    {{-- <button class="btn btn-primary btn-quirk btn-fb btn-block">Connect with Facebook</button>
    <div class="or">or</div> --}}
    <form method="POST" action="" aria-label="Acceso">
        @csrf
        <div class="form-group mb10">
            <div class="input-group">
                <select class="form-control" name="access_type" id="select-access-type">
                    <option value="">¿Cómo quieres entrar?</option>
                    <option value="admin">Panel de administración</option>
                    <option value="client">Panel de cliente</option>
                </select>
            </div>
            @if ($errors->has('email'))
                <span class="invalid-feedback text-muted" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        
    </form>
  </div>
</div><!-- panel -->
@endsection