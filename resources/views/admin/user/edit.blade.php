@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <form action="{{ route('admin.edit.user', ['id' => $user->id]) }}" method="POST">
            @csrf
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <ul class="panel-options">
                        <li><a class="panel-minimize"><i class="fa fa-chevron-down"></i></a></li>
                    </ul>
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ __("Datos personales") }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-name">{{ __('Nombre completo') }}</label>
                            <input type="text" id="input-user-name" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-email">{{ __('Email') }}</label>
                            <input type="text" id="input-user-email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-phone">{{ __('Teléfono Oficina') }}</label>
                            <input type="text" id="input-user-phone" class="form-control" name="user_phone" value="{{ old('user_phone', $user->getMetaByKey('user_phone') ? $user->getMetaByKey('user_phone')->meta_value : false) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-whatsapp">{{ __('Whatsapp') }}</label>
                            <input type="text" id="input-user-whatsapp" class="form-control" name="user_whatsapp" value="{{ old('user_whatsapp', $user->getMetaByKey('user_whatsapp') ? $user->getMetaByKey('user_whatsapp')->meta_value : false) }}">
                        </div>
                        <div class="form-group">
                            <label for="input-user-address">{{ __('Dirección') }}</label>
                            <input type="text" id="input-user-address" class="form-control" name="user_address" value="{{ old('user_address', $user->getMetaByKey('user_address') ? $user->getMetaByKey('user_address')->meta_value : false) }}">
                        </div>
                        <div class="form-group">
                            <label for="textarea-user-about">{{ __('Sobre mi') }}</label>
                            <textarea name="user_aboutme" id="textarea-user-about" cols="30" rows="10" class="form-control">{{ old('user_aboutme', $user->getMetaByKey('user_aboutme') ? $user->getMetaByKey('user_aboutme')->meta_value : false) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <ul class="panel-options">
                        <li><a class="panel-minimize"><i class="fa fa-chevron-down"></i></a></li>
                    </ul>
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ __("Redes Sociales") }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-face">{{ __('Facebook') }}</label>
                            <input type="url" id="input-user-face" class="form-control" name="user_facebook" value="{{ old('user_facebook', $user->getMetaByKey('user_facebook') ? $user->getMetaByKey('user_facebook')->meta_value : false) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-twitter">{{ __('Twitter') }}</label>
                            <input type="url" id="input-user-twitter" class="form-control" name="user_twitter" value="{{ old('user_twitter', $user->getMetaByKey('user_twitter') ? $user->getMetaByKey('user_twitter')->meta_value : false) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-instagram">{{ __('Instagram') }}</label>
                            <input type="url" id="input-user-instagram" class="form-control" name="user_instagram" value="{{ old('user_instagram', $user->getMetaByKey('user_instagram') ? $user->getMetaByKey('user_instagram')->meta_value : false) }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-linkedin">{{ __('LinkedIn') }}</label>
                            <input type="url" id="input-user-linkedin" class="form-control" name="user_linkedin" value="{{ old('user_linkedin', $user->getMetaByKey('user_linkedin') ? $user->getMetaByKey('user_linkedin')->meta_value : false) }}">
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <ul class="panel-options">
                        <li><a class="panel-minimize"><i class="fa fa-chevron-down"></i></a></li>
                    </ul>
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ __("Datos Laborales") }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-disabled-user-rol">{{ __('Rol') }}</label>
                            <input type="text" class="form-control" value="{{ $user->toStringRoles() }}" disabled>
                        </div>
                        @if($user->hasRole('client'))
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="select-user-company">{{ __('Empresa') }}</label>
                                <input type="text" class="form-control" value="{{ $user->company()->name }}" disabled>
                            </div>
                        @endif
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-position">{{ __('Cargo') }}</label>
                            <input type="text" id="input-user-position" class="form-control" name="user_position" value="{{ old('user_position', $user->getMetaByKey('user_position') ? $user->getMetaByKey('user_position')->meta_value : false) }}">
                        </div>
                        @if($user->hasRole('monitor'))
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="select-user-monitor">{{ __('Monitor de') }}</label>
                                <select name="user_monitor_type" id="select-user-monitor" class="form-control">
                                    <option value="">{{ __('Selecciona que tipo de monitor eres') }}</option>
                                    @foreach($monitors as $monitor)
                                        <option value="{{ $monitor->id }}" {{ old('user_monitor_type', $user->getMetaByKey('user_monitor_type') ? $user->getMetaByKey('user_monitor_type')->meta_value : false) == $monitor->id ? 'selected' : '' }} >{{ "Monitor de {$monitor->name}" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel panel-primary">
                    <ul class="panel-options">
                        <li><a class="panel-minimize"><i class="fa fa-chevron-down"></i></a></li>
                    </ul>
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ __("Cambio de contraseña") }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-new-password">{{ __('Nueva contraseña') }}</label>
                            <input type="password" id="input-user-new-password" class="form-control" name="new_password">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-lg" value="{{ __('Guardar cambios') }}">
                </div>
            </div>
        </form>
    </div>
@endsection