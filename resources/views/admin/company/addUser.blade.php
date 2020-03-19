@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __("Agregar cuenta para {$company->name}") }}</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('register.user') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $company->id}}" name="company_id">
                        <input type="hidden" value="{{ true }}" name="company_route">
                        <div class="form-group">
                            <label for="name">{{ __('Nombre') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Correo') }}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Contraseña') }}</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirmar contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <input type="hidden" value="{{ $role->id}}" name="rol">
                        
                        <div class="form-group">
                            <label for="ocupation">{{ __('Puesto') }}</label>
                            <input type="text" class="form-control" id="ocupation" name="user_position" value="{{ old('user_position') }}">
                            @error('user_position')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-10 col-sm-2">
                                <input type="submit" class="btn btn-primary btn-block" value="{{ __('Crear') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection