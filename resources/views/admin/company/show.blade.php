@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-3 col-lg-4">
        <div class="row">
            <div class="col-sm-5 col-md-12 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cuentas</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list user-list" id="user-list">
                            @forelse($company->accounts() as $account)
                                <li class="media">
                                    <div class="media-left">
                                      <a href="#">
                                        <img class="media-object img-circle" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($account->name)) }}" alt="">
                                      </a>
                                    </div>
                                    <div class="media-body">
                                      <h4 class="media-heading nomargin"><a href="{{ route('user.show', ['id' => $account->id, ]) }}">{{ $account->name }}</a></h4>
                                      {{ $account->metas->where('meta_key', 'user_position')->first()->meta_value }}
                                      <small class="date"><i class="glyphicon glyphicon-remove"></i> <a href="javascript:void(0)" id="btn-remove-account" data-company="{{ $company->name }}" data-userid="{{ $account->id }}" data-username="{{ $account->name }}">Remover</a></small>
                                    </div>
                                    
                                </li>
                            @empty
                                <li class="media">No hay cuentas para esta empresa</li>
                                {{-- <a href="">Agregar Cuenta</a> --}}
                            @endforelse
                        </ul>
                    </div>
                </div>    
            </div>
            <div class="col-sm-5 col-md-12 col-lg-6">
                <div class="panel panel-default list-announcement">
                    <div class="panel-heading">
                        <h4 class="panel-title">Temas</h4>
                    </div>
                    <div class="panel-body" id="list-themes">
                        <ul class="list-unstyled mb20">
                            @forelse($company->themes as $theme)
                                <li>
                                    {{ $theme->name }}
                                    <span class="text-float-r" >
                                        <a href="{{ route('theme.show', ['id' => $theme->id ]) }}"><i class="fa fa-eye"></i></a>
                                        <a data-theme="{{ $theme->id }}" data-name="{{ $theme->name }}"  class="btn-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
                                    </span>
                                </li>
                            @empty
                                <li>No hay temas para esta empresa</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-8 people-list">
        <div class="people-options clearfix">
            <div class="btn-toolbar pull-left">
                <a href="{{ route('user.add.company', ['companyId' => $company->id]) }}" class="btn btn-success btn-quirk">{{ __('Agregar usuario') }}</a>
                <button data-company="{{ $company->id }}" id="btn-add-theme" class="btn btn-success btn-quirk" type="button">{{ __('Agregar tema') }}</button>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">{{ $company->name }}</h1>
            </div>
            <div class="panel-body">
                <img class="img-responsive" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                <p class="text-center"><a href="javascript:void(0)">Cambiar Imagen</a></p>
                <p class="text-center">{{ "{$company->address} | {$company->turn->name}" }}</p>
                @if($company->old_company_id)
                    @if($oldCompany = $company->oldCompany())
                        <p class="text-center">Empresa relacionada: <strong>{{ $oldCompany->nombre }}</strong></p>
                    @endif
                @else
                    <p class="text-center">
                        <button class="btn btn-primary" type="button" data-company="{{ $company->id }}" id="btn-relation">Relacionar con cliente anterior</button>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <style>
        .mt-3 {
            margin-top: 1.5rem;
        }

        .text-float-r {
            float: inline-end;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // relate company
            $('#btn-relation').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var companyID = $(this).data('company')

                form.attr('method', 'POST')
                form.attr('action', '/panel/empresa/relacionar')
                
                modal.find('.modal-title').html('Relacionar con una empresa del sistema pasado');
                modal.find('#md-btn-submit').val('Relacionar')
                $.get('/api/v2/clientes/antiguas', function (companies) {
                    var select = $(`<select></select>`)
                        .attr('id', 'old_company_id')
                        .attr('name', 'old_company_id')
                        .addClass('form-control')
                    select.append($('<option></option>').attr('value', '').text('Selecciona un Cliente'))
                    
                    $.each(companies, function (key, obj) {
                        select.append($('<option></option>').attr('value', obj.id).text(obj.nombre))
                    })
                    
                    // select.select2()
                    modalBody.html(select)
                    
                    var helpText = $('<p></p>').addClass('text-center mt-3').text('La compañia que elija, sera para actualizar las noticias de años anteriores.')
                    var inputHiden = $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'company')
                        .attr('value', companyID)
                    
                    modalBody.append(inputHiden)
                    modalBody.append(helpText)
                })
                

                modal.modal('show')
            })

            //create theme 
            $('#btn-add-theme').on('click', function(){
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var companyID = $(this).data('company')

                form.attr('method', 'POST')
                form.attr('action', '/panel/tema/nuevo')
                form.addClass('form-horizontal')
                
                modal.find('.modal-title').html('Crear un tema para esta empresa');
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreateTheme())
                var inputHiden = $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'company_id')
                        .attr('value', companyID)
                    
                modalBody.append(inputHiden)

                modal.modal('show')
            })
            function getTemplateForCreateTheme() {
                return `
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tema</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Descripción del tema</label>
                            <div class="col-sm-8">
                                <textarea rows="5" class="form-control" name="description" ></textarea>
                            </div>
                        </div>
                    </div>
                ` 
            }

            // delete theme
            $('#list-themes').on('click', '.btn-delete', function(event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var themeID = $(this).data('theme')
                var themeName = $(this).data('name')

                form.attr('method', 'POST')
                    .attr('action', `/panel/tema/eliminar/${themeID}`) 

                modal.find('.modal-title').html('Eliminar tema');
                modalBody.html(`<p>¿Estas seguro que quieres eliminar el tema: <strong>${themeName}</strong>?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Eliminar')

                modal.modal('show')
            })

            // remove user from company
            $('#user-list').on('click', '#btn-remove-account', function (event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var userID = $(this).data('userid')
                var userName = $(this).data('username')
                var company = $(this).data('company')

                form.attr('method', 'POST')
                    .attr('action', `/panel/empresa/remover-usuario/${userID}`)

                modal.find('.modal-title').html(`Quitar usuario de esta empresa`)
                modalBody.html(`<p>¿Estas seguro que remover a <strong>${userName}</strong> de ${company}?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.modal('show')
            })
        })
    </script>
@endsection