@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __("Agregar cuenta para {$company->name}") }}</h4>
                </div>
                <div class="panel-body">
                    <div class="table-users-list">
                        <table class="table table-bordered table-primary table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Usuarios pendientes por asignar empresa') }}</th>
                                    <th class="text-center">{{ __('Acción') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $iteration = 1;
                                @endphp
                                @foreach($clients as $client)
                                        <tr>
                                            <td>{{ $iteration }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void()" class="add-user-to-company" data-userid="{{ $client->id }}" data-company="{{ $company->id }}">
                                                    {{ __('Agregar') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $iteration++;
                                        @endphp
                                @endforeach
                                @if($iteration == 1)
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            {{ __('No hay cuentas pendientes por asignar') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-warning btn-show-form">Agregar un nuevo usuario</button>
                    <div class="form-add-new-user" style="display: none;">
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
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            // add user to company
            $('.table-users-list').on('click', '.add-user-to-company', function (event) {
                event.preventDefault()
                var userID = $(this).data('userid')
                var companyID = $(this).data('company')
                var form = $('#modal-default-form')
                var inputUser = $("<input>")
                   .attr("type", "hidden")
                   .attr("name", "user").val(userID);
                var inputCompany = $("<input>")
                   .attr("type", "hidden")
                   .attr("name", "company").val(companyID);

                form.attr('method', 'POST')
                form.attr('action', '/panel/empresa/agregar-usuario-ajax')
                form.append(inputUser)
                form.append(inputCompany)

                form.submit()
            })
            // show form for add user
            $('.btn-show-form').on('click', function(){
                var userList = $('.table-users-list')
                var formSection = $('.form-add-new-user')

                $(this).hide('slow')
                userList.hide('slow')
                formSection.show('slow')
            })
        })


    </script>
@endsection