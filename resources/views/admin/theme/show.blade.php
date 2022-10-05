@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-10 col-lg-10">
        <div class="panel panel-default" id="show-theme-description">
            <div class="panel-heading">
                <h4 class="panel-title">
                    {{ __("Tema de {$theme->company->name}") }}
                </h4>
            </div>
            <div class="panel-body" id="panel-body-theme">
                <h3 id="theme-title"> {{ $theme->name }}</h3>
                <p id="theme-description">
                    {!! $theme->description !!}
                </p>
                <div class="row" id="form-edit-theme" style="display: none;">
                    <form action="{{ route('theme.update', ['id' => $theme->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="theme">Tema</label>
                            <input type="text" id="theme" name="name" class="form-control" value="{{ $theme->name }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $theme->description }}</textarea>
                        </div>
                        <input type="submit" class="btn btn-primary pull-right" value="Actualizar">
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="show-form-add-account" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __("Relacionar cuenta con el tema: {$theme->name}") }}</h4>
            </div>
            <div class="panel-body">
                @if($accounts->count() > 0)
                    <form action="{{ route('admin.theme.relationship.user') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $theme->id }}" name="theme_id">
                        <div class="form-group">
                            <label for="">{{ __('Cuenta') }}</label>
                            <select name="user_id" class="form-control">
                                <option value="">{{ __('Selecciona una cuenta') }}</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="javascript:void(0)" class="btn btn-default btn-return-description">{{ __('Cancelar') }}</a>
                            <input type="submit" class="btn btn-primary" value="{{ __('Relacionar') }}">
                        </div>
                    </form>
                @else
                    <p>{{ __('No hay cuentas para relacionar ó las cuentas ya estan relaconadas con este tema.') }}</p>
                    <a href="javascript:void(0)" class="btn btn-default btn-return-description">{{ __('Regresar') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2">
        <div class="panel" id="panel-options">
            <div class="panel-body">
                <a href="javascript:void(0)" id="btn-edit" class="btn btn-success btn-block">Editar</a>
                <a href="javascript:void(0)" data-theme="{{ $theme->id }}" data-name="{{ $theme->name }}"  id="btn-delete" class="btn btn-danger btn-block">Eliminar</a>
                <a href="{{ route('company.show', ['company' => $theme->company ]) }}" class="btn btn-default btn-block">Regresar</a>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Cuentas relacionadas con este tema') }}</h4>
            </div>
            <div class="panel-body">
                <ul class="media-list user-list" id="user-list">
                    @forelse($theme->accounts as $client)
                        <li class="media">
                            <div class="media-left">
                                <a href="{{ route('user.show', ['id' => $client->id]) }}">
                                    <img class="media-object img-circle" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($client->name)) }}" alt="{{ $client->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading nomargin"><a href="{{ route('user.show', ['id' => $client->id]) }}">{{ $client->name }}</a></h4>
                                {{ $client->email }}
                                <small class="date"><i class="glyphicon glyphicon-remove"></i> <a href="javascript:void(0)" id="btn-remove-account-theme" data-theme="{{ $theme->name }}" data-themeid="{{ $theme->id }}" data-href="{{ route('admin.theme.remove.user', ['id' => $client->id]) }}" data-username="{{ $client->name }}">Remover</a></small>
                            </div>
                        </li>
                    @empty
                        <li>
                            {{ __('Este tema no tiene cuentas relacionadas.') }}
                        </li>
                    @endforelse
                    <li class="media">
                        <a href="javascript:void(0)" id="btn-relationship-account" class="btn btn-primary btn-block btn-sm">{{ __('Relacionar cuenta a este tema') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // edit Theme
            $('#btn-edit').on('click', function(event) {
                event.preventDefault()

                var description = $('#theme-description')
                var title = $('#theme-title')
                var form = $('#form-edit-theme')
                var btnEdit = $(this)

                description.hide()
                title.hide()
                btnEdit.hide()
                form.show()
            })

            // delete theme
            $('#btn-delete').on('click', function(event) {
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

            // form relation with user
            $('#btn-relationship-account').on('click', function(event){
                event.preventDefault()
                var form = $('#show-form-add-account')
                var descripcionPanel = $('#show-theme-description')
                var optionsTheme = $('#panel-options')

                descripcionPanel.hide('fast')
                optionsTheme.hide('fast')
                form.show('slow')
            })

            $('.btn-return-description').on('click', function(event) {
                event.preventDefault()

                var form = $('#show-form-add-account')
                var descripcionPanel = $('#show-theme-description')
                var optionsTheme = $('#panel-options')

                descripcionPanel.show('slow')
                optionsTheme.show('slow')
                form.hide('fast')

            })

            // remove user from theme
            $('#user-list').on('click', '#btn-remove-account-theme', function (event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var action = $(this).data('href')
                var userName = $(this).data('username')
                var theme = $(this).data('theme')
                var themeID = $(this).data('themeid')
                var inputHiden = $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'theme_id')
                        .attr('value', themeID)


                form.attr('method', 'POST')
                    .attr('action', action)

                modal.find('.modal-title').html(`Quitar usuario de este tema`)
                modalBody.html(`<p>¿Estas seguro que remover a <strong>${userName}</strong> de ${theme}?</p>`)
                modalBody.append(inputHiden)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.modal('show')
            })
        })
    </script>
@endsection
