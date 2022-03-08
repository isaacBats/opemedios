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
    <div class="row">
        <div class="col-md-12 people-list">
            <div class="people-options clearfix" id="btn-group-list">
                <div class="btn-toolbar pull-left">
                    <a href="{{ route('user.add.company', ['companyId' => $company->id]) }}" class="btn btn-success btn-quirk">{{ __('Agregar usuario') }}</a>
                    <button data-company="{{ $company->id }}" id="btn-add-theme" class="btn btn-success btn-quirk" type="button">{{ __('Agregar tema') }}</button>
                    @if (! $company->newsletter)
                        <button data-company="{{ $company->id }}" id="btn-add-newsletter" class="btn btn-success btn-quirk" type="button">{{ __('Crear newsletter') }}</button>
                    @endif
                    <button id="btn-edit-company" class="btn btn-warning btn-quirk" type="button">{{ __('Editar datos de la empresa') }}</button>
                    <button id="btn-subcompany" data-company="{{ $company->id }}" class="btn btn-info btn-quirk" type="button">Hacer subcuenta</button>
                    @if(is_null($company->parent))
                        <a target="_blank" href="{{ route('company.create', ['father' => $company->id, 'subcompany' => true]) }}" class="btn btn-info btn-quirk">Crear una subcuenta para esta empresa</a>
                    @endif
                    @hasanyrole('manager|admin')
                    @if(auth()->user()->companies->firstWhere('id', $company->id))
                    <a href="{{ route('admin.admin.redirectto', ['company' => $company->id]) }}" class="btn btn-info">Ver como cliente</a>
                    @endif
                    @endhasanyrole
                </div>
            </div>
            <div class="panel" id="panel-show-company">
                <div class="panel-heading">
                    <h1 class="panel-title">{{ $company->name }}</h1>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        @include('components.card-company')
                    </div>
                    <div class="col-md-6 text-center">
                        <img class="img-responsive" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                        <p><a class="btn btn-info" href="javascript:void(0)" id="btn-change-logo" data-company="{{ $company->id }}" >Cambiar Imagen</a></p>
                    </div>
                </div>
            </div>
            <div class="panel" id="form-edit-company" style="display: none;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ __("Editar ") }} {{ $company->name }}
                    </h4>
                </div>
                <form action="{{ route('company.update', ['id' => $company->id]) }}" method="POST" class="form-horizontal">
                    <div class="panel-body">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre de la empresa<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la empresa" value="{{ old('name', $company->name) }}" required />
                            </div>
                            @error('name')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Direcci&oacute;n<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" placeholder="Direcci&oacute;n de la empresa" value="{{ old('address', $company->address) }}" required />
                            </div>
                            @error('address')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giro<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select id="select-turn" name="turn_id" class="form-control">
                                    <option value="">Seleccionan un Giro</option>
                                    @foreach($turns as $turn)
                                        <option value="{{ $turn->id }}" {{ ($turn->id == $company->turn_id ? 'selected' : '') }} >{{ $turn->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('turn_id')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="col-sm-11 text-right">
                                <button type="button" id="btn-cancel-form" class="btn btn-danger btn-quirk">Cancelar</button>
                                <input type="submit" value="{{ __('Actualizar') }}" class="btn btn-success btn-quirk btn-wide mr5">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">Cuentas</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="media-list user-list" id="user-list">
                                @forelse($accounts as $account)
                                    <li class="media">
                                        <div class="media-left">
                                          <a href="#">
                                            <img class="media-object img-circle" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($account->name)) }}" alt="">
                                          </a>
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading nomargin"><a href="{{ route('user.show', ['id' => $account->id, ]) }}">{{ $account->name }}</a></h4>
                                          {{ $account->metas->where('meta_key', 'user_position')->first()->meta_value }}
                                          <small class="date"><i class="glyphicon glyphicon-remove"></i> <a href="javascript:void(0)" id="btn-remove-account" data-company="{{ $company->name }}" data-companyid="{{ $company->id }}" data-userid="{{ $account->id }}" data-username="{{ $account->name }}">Remover</a></small>
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
                <div class="col-sm-6 col-md-6 col-lg-6">
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
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Notas enviadas</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped nomargin" id="table-assigned-news">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Titulo</th>
                                    <th>Tema</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company->assignedNews as $assigned)
                                    <tr>
                                        <td>{{ ($company->assignedNews->currentPage() - 1) * $company->assignedNews->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.new.show', ['id' => $assigned->news_id]) }}">
                                                {{ "OPE-{$assigned->news_id}" }} <br />
                                                {{ $assigned->news->title }}
                                            </a>
                                        </td>
                                        <td>
                                            <form id="{{ "form-company-theme-{$assigned->id}" }}" action="{{ route('admin.assignednews.replacetheme', ['id' => $assigned->id]) }}" class="form-company-theme" method="POST">
                                                @csrf
                                                <select class="select-company-theme" style="width: 100%;" name="theme_id">
                                                    @foreach($company->themes as $theme)
                                                        <option value="{{ $theme->id }}" {{ $theme->id == $assigned->theme_id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.assignednews.remove', ['id' => $assigned->id]) }}" class="btn-remove-assigned-news" data-title="{{ $assigned->news->title }}" data-company="{{ $company->name }}">Remover</a>
                                            <a style="display: none;"  href="javascript:void(0);" class="btn-form-assigned-news"
                                                onclick="event.preventDefault();
                                                    document.getElementById('{{ "form-company-theme-{$assigned->id}" }}').submit();"
                                            >Guardar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $company->assignedNews->render() !!}
                    </div>
                </div>
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
            
            //select2 for news assigned
            $('.select-company-theme').select2();

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
                var companyId = $(this).data('companyid')

                form.attr('method', 'POST')
                    .attr('action', `/panel/empresa/remover-usuario/${userID}`);
                form.append($('<input>').attr('type', 'hidden').attr('name', 'companyid').val(companyId));

                modal.find('.modal-title').html(`Quitar usuario de esta empresa`)
                modalBody.html(`<p>¿Estas seguro que remover a <strong>${userName}</strong> de ${company}?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.modal('show')
            })

            // edit company
            $('#btn-edit-company').on('click', function(event){
                event.preventDefault()
                var buttonsGroup = $('#btn-group-list')
                var panelShow = $('#panel-show-company')
                var form = $('#form-edit-company')

                buttonsGroup.hide('slow')
                panelShow.hide('slow')
                form.show('slow')
            })

            // cancel Edit company
            $('#btn-cancel-form').on('click', function(event){
                event.preventDefault()
                var buttonsGroup = $('#btn-group-list')
                var panelShow = $('#panel-show-company')
                var form = $('#form-edit-company')

                buttonsGroup.show('slow')
                panelShow.show('slow')
                form.hide('slow')
            })

            // Modal to edit logo
            $('#btn-change-logo').on('click', function (event){
                event.preventDefault()
                var companyId = $(this).data('company')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('company.update.logo', ['id' => $company->id]) }}')
                form.attr('method', 'POST')
                form.attr('enctype', 'multipart/form-data')
                form.append($('<input>').attr('type', 'hidden').attr('name', 'source').val(companyId))

                modal.find('.modal-title').text("{{ __('Cambiar Logo') }}")
                modal.find('#md-btn-submit').val("{{ __('Actualizar Logo') }}")
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>{{ __('Logo') }}</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                `)
                modal.modal('show')
            })

            // modal create newsletter for company
            $('#btn-add-newsletter').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var companyID = $(this).data('company')

                form.attr('method', 'POST')
                form.attr('action', '{{ route('admin.newsletter.create') }}')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear newsletter para {{ $company->name }}')
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(`<p> <strong>Vas a crear un Nesletter para la Empresa {{ $company->name }} </strong></p>`)
                var inputHiden = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'company_id')
                    .attr('value', companyID)

                modalBody.append(inputHiden)

                modal.modal('show')
            })

            // remove news from company
            $('#table-assigned-news').on('click', 'a.btn-remove-assigned-news', function(event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var title = $(this).data('title')
                var client = $(this).data('company')

                form.attr('method', 'POST')
                    .attr('action', $(this).attr('href'))

                modal.find('.modal-title').html('Remover nota');
                modalBody.html(`<p>¿Estas seguro que quieres remover la nota: <strong>${title}</strong>, de ${client}?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.modal('show')
            })

            // update theme
            $('#table-assigned-news').on('change', 'select.select-company-theme', function() {

                var btnSave = $(this).parent().parent().parent().find('a.btn-form-assigned-news');
                btnSave.show('slow');
                
            })

            // make sub company
            $('#btn-subcompany').on('click', function(){
                var modal = $('#modal-default');
                var form = $('#modal-default-form');
                var modalBody = modal.find('.modal-body');
                var companyID = $(this).data('company');
                var companies = @json($companies);

                form.attr('method', 'POST');
                form.attr('action', '{{ route('admin.company.createsubcompany') }}');
                form.addClass('form-horizontal');

                modal.find('.modal-title').html('Hacer esta empresa subcuenta');
                modal.find('#md-btn-submit').val('Relacionar');

                var select = $(`<select></select>`)
                        .attr('id', 'select-parent')
                        .attr('name', 'parent')
                        .attr("style", "width: 100%;")
                        .addClass('form-control')
                    select.append($('<option></option>').attr('value', '').text('Selecciona una Empresa'));

                    $.each(companies, function (key, obj) {
                        select.append($('<option></option>').attr('value', obj.id).text(obj.name));
                    });
                modalBody.html(select);

                var inputHiden = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'company_id')
                    .attr('value', companyID);

                modalBody.append(inputHiden);
                modal.find('#select-parent').select2({
                    dropdownParent: modal
                })

                modal.modal('show');
            });
        })
    </script>
@endsection
