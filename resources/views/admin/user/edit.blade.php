@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        @php
            if($user->trashed()) {
                $route = route('admin.user.restore', ['id' => $user->id]);
                $button = '<input type="submit" class="btn btn-info btn-lg" value="Restaurar Usuario">';
                $isDeleted = true;
                $method = 'GET';
            } else {
                $route = route('admin.edit.user', ['id' => $user->id]);
                $button = '<input type="submit" class="btn btn-info btn-lg" value="Guardar cambios">';
                $isDeleted = false;
                $method = 'POST';
            }
            $userCompanyId = false;
            if($user->company()) {
                $userCompanyId = $user->company()->id;
            }
        @endphp
        <form action="{{ $route }}" method="{{ $method }}">
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
                            <input type="text" id="input-user-name" class="form-control" name="name"
                                value="{{ old('name', $user->name) }}" {{ $isDeleted ? 'disabled' : '' }}>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="input-user-email">{{ __('Email') }}</label>
                            <input type="text" id="input-user-email" class="form-control" name="email"
                                value="{{ old('email', $user->email) }}" {{ $isDeleted ? 'disabled' : '' }}>
                        </div>
                        @if(!$isDeleted)
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
                        @endif
                    </div>
                </div>
                @if(!$isDeleted)
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
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select name="rol" id="rol" class="form-control" required>
                                    <option value="">Selecciona un rol</option>
                                    @foreach(Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ App\Models\User::getRoleNameCustom($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('rol')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                                @enderror
                            </div>
                            <div class="form-group col-sm-12 col-md-6" id="div-select-company" style="display: none;">
                                <label for="company">Empresa</label>
                                <select name="company_id" id="company" class="form-control">
                                    <option value="">Selecciona un Empresa</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $userCompanyId === $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="input-user-position">{{ __('Cargo') }}</label>
                                <input type="text" id="input-user-position" class="form-control" name="user_position" value="{{ old('user_position', $user->getMetaByKey('user_position') ? $user->getMetaByKey('user_position')->meta_value : false) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-6" id="div-select-monitor-type" style="display: none;">
                                <label for="select-user-monitor">Monitor de</label>
                                <select name="user_monitor_type" id="select-user-monitor" class="form-control">
                                    <option value="">Selecciona que tipo de monitor eres</option>
                                    @foreach($monitors as $monitor)
                                        <option value="{{ $monitor->id }}" {{ old('user_monitor_type', $user->getMetaByKey('user_monitor_type') ? $user->getMetaByKey('user_monitor_type')->meta_value : false) == $monitor->id ? 'selected' : '' }} >{{ "Monitor de {$monitor->name}" }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                                <label for="input-user-new-password">Contraseña actual</label>
                                <div class="input-group">
                                    <input id="input-password-show" type="password" class="form-control" value="{{ $user->getMetaByKey('user_password') ? \Crypt::decryptString($user->getMetaByKey('user_password')->meta_value) : '' }}">
                                    <span id="btn-press-eye" class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="input-user-new-password">{{ __('Nueva contraseña') }}</label>
                                <input type="password" id="input-user-new-password" class="form-control" name="new_password">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                <div class="form-group">
                    {!! $button !!}
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            selectOption();

            //show password
            $('span#btn-press-eye').on('click', function(){
                var inputText = $('#input-password-show');
                var icon = $(this).find('i');
                if(inputText.val().length == 0) {
                    alert('No hay registro de password');
                } else {
                    if(inputText.attr('type') == 'password') {
                        inputText.attr('type', 'text');
                        icon.removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                    } else {
                        inputText.attr('type','password');
                        icon.removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                    }
                }

            });

            // select rol
            $('select#rol').change(function () {
                var option = $(this).val()
                var role = $('option:selected', this).text()
                var company = $('#div-select-company')
                var monitor = $('#div-select-monitor-type')

                if (role == 'Cliente') {
                    hideItems()
                    company.find('select#company').removeAttr('disabled')
                    company.find('select#company').attr('required', true)
                    company.show('fade')
                } else if (role == 'Monitorista') {
                    hideItems()
                    monitor.find('select#select-monitor').removeAttr('disabled')
                    monitor.find('select#select-monitor').attr('required', true)
                    monitor.show('fade')
                } else {
                    hideItems()
                }
            })

            function hideItems() {
                var company = $('#div-select-company')
                var monitor = $('#div-select-monitor-type')

                var selectCompany = company.find('select')
                var selectMonitor = monitor.find('select')

                selectCompany.prop('selectedIndex', 0)
                selectCompany.attr('disabled', true)
                selectCompany.removeAttr('required')
                company.hide('fade')

                selectMonitor.prop('selectedIndex', 0)
                selectMonitor.attr('disabled', true)
                selectMonitor.removeAttr('required')
                monitor.hide('fade')
            }

            function selectOption() {
                var role = $('select#rol').find('option:selected').text();
                if(role === 'Cliente') {
                    hideItems();
                    $('div#div-select-company').show('fade')
                        .find('select#company').removeAttr('disabled');
                }

                if(role === 'Monitorista') {
                    hideItems();
                    $('div#div-select-monitor-type').show('fade')
                        .find('select#select-monitor').removeAttr('disabled');
                }
            }
        });
    </script>
@endsection
