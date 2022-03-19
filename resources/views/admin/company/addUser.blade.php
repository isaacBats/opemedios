@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-lg-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __("Administrar cuentas para {$company->name}") }}</h4>
                </div>
                <div class="panel-body">
                    <div class="table-users-list"> <!-- user list -->
                        <caption>Cuentas asignadas</caption>
                        <table class="table table-bordered table-primary table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $iteration = 1;
                                @endphp
                                @foreach($accounts as $account)
                                        <tr>
                                            <td>{{ $iteration }}</td>
                                            <td>{{ $account->name }}</td>
                                            <td>
                                                {{ $account->metas->where('meta_key', 'user_position')
                                                ->first()->meta_value }}
                                            </td>
                                            <td>
                                                {{ $account->email }}
                                            </td>
                                        </tr>
                                        @php
                                            $iteration++;
                                        @endphp
                                @endforeach
                                @if($iteration == 1)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            {{ "La empresa {$company->name} aun no tiene cuentas" }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div> <!-- end user list -->
                    <button class="btn btn-warning btn-show-form">Agregar un nuevo usuario</button>
                    <div class="form-add-new-user" style="display: none;"> <!-- Form add new user-->
                        <form action="{{ route('admin.company.add.accounts') }}" class="form-horizontal" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $company->id}}" name="company_id">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Selecciona los usuarios a agregar</label>
                                <div class="col-sm-8">
                                    <select id="select-user" data-company="{{ $company->id }}" class="form-control" name="users[]" multiple="multiple" required ></select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" class="btn btn-primary btn-block" value="Guardar usuarios">
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('company.show', ['id' => $company->id]) }}" class="btn btn-danger btn-block">
                            {{ "Volver al detalle de {$company->name}" }}
                        </a>
                    </div> <!-- End form add new user-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <style>
        #select-user {
            width: 100%;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            // show form for add user
            $('.btn-show-form').on('click', function(){
                var userList = $('.table-users-list');
                var formSection = $('.form-add-new-user');

                $(this).hide('slow');
                userList.hide('slow');
                formSection.show('slow');
            })
            
            // Select users for add to company
            $('#select-user').select2({
                language: {
                    inputTooShort: function() {
                        return "Agrega más de tres caracteres."
                    }
                },
                width: "100%",
                AllowClear: true,
                theme: "classic",
                minimumInputLength: 3,
                placeholder: "Busca a los usuarios que quieras agregar",
                ajax: {
                    url: "{{ route('api.company.getnotaccounts') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            company_id: {{ $company->id }}
                        };
                        return query;
                    },
                    processResults: function(data) {
                        var items = data.map(function(data){
                            return {
                                id: data.id,
                                text: `${data.name} <${data.email}>`
                            };
                        })
                        return {
                            results: items
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endsection