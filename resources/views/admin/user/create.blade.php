@extends('layouts.admin')
@section('admin-title', ' - Nuevo usuario')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __('Nuevo usuario') }}</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('register.user') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Nombre') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @error('name')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Correo') }}</label>
                            <input type="email" class="form-control" id="email" name="email">
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
                        <div class="form-group">
                            <label for="rol">{{ __('Rol') }}</label>
                            <select name="rol" id="rol" class="form-control">
                                <option value="">Selecciona un rol</option>
                                @foreach(Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="div-select-company" style="display: none;">
                            <label for="company">{{ __('Empresa') }}</label>
                            <select name="company_id" id="company" class="form-control">
                                <option value="">Selecciona un Empresa</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="div-select-monitor-type" style="display: none;">
                            <label for="select-monitor">{{ __('Tipo de monitor') }}</label>
                            <select name="monitor_type" id="select-monitor" class="form-control">
                                <option value="">{{ __('Selecciona que tipo de monitor eres') }}</option>
                                @foreach($monitors as $monitor)
                                    <option value="{{ $monitor->id }}">{{ "Monitor de {$monitor->name}" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ocupation">{{ __('Puesto') }}</label>
                            <input type="text" class="form-control" id="ocupation" name="user_position">
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
@section('scripts')
    <script  type="text/javascript">
        $(document).ready(function(){
            $('select#rol').change(function(){
                var option = $(this).val()
                var role = $('option:selected', this).text()
                var company = $('#div-select-company')
                var monitor = $('#div-select-monitor-type')

                if(role =='client') {
                    hideItems()
                    company.show('fade')
                }else if(role == 'monitor'){
                    hideItems()
                    monitor.show('fade')
                }else {
                    hideItems()
                }
            })

            function hideItems() {
                var company = $('#div-select-company')
                var monitor = $('#div-select-monitor-type')

                var selectCompany = company.find('select')
                var selectMonitor = monitor.find('select')

                selectCompany.prop('selectedIndex', 0)
                company.hide('fade')

                selectMonitor.prop('selectedIndex', 0)
                monitor.hide('fade')
            }
        })
    </script>
@endsection
