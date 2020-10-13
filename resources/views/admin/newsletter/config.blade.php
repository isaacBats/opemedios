@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __("Configuración para newsletter {$newsletter->name}") }}</h4>
                </div>
                <div class="panel-body">
                    @if($newsletter->banner)
                        <img class="img-responsive" src="{{ asset("images/{$newsletter->banner}") }}" alt="{{ $newsletter->name }}">
                    @else
                        <div class="rectangle-banner">Banner</div>
                    @endif
                    <div class="col-md-4 col-md-offset-4 mt-3" style="margin-top: 2em;">
                        <button id="btn-up-banner" class="btn btn-primary btn-lg btn-block">{{ __('Cambiar Banner') }}</button>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de correos para este Newsletter</h4>
                </div>
                <div class="panel-body">
                    <ul class="media-list user-list" id="media-list-emails">
                        @forelse($newsletter->newsletter_users as $item)
                            <li class="media">
                                <div class="media-body">
                                    <h4 class="media-heading nomargin">{{ $item->email }}</h4>
                                    <a href="javascript:void(0);" data-email="{{ $item->email }}" data-id="{{ $item->id }}" class="text-danger btn-remove-email">Remover</a>
                                </div>
                            </li>
                        @empty
                            <li class="media">
                                <p>
                                    No hay direcciones de correo para este newsletter
                                </p>
                                <button class="btn btn-primary" id="btn-add-emails">Agregar cuentas relacionadas con {{ $newsletter->company->name }}</button>
                            </li>
                        @endforelse
                        @if($newsletter->newsletter_users->count() > 0)
                            <li>
                                <div class="col-md-1 col-md-offset-11">
                                    <button class="btn btn-primary" id="btn-add-email">Agregar otro correo</button>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">Elige un template para este Newsletter</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.newsletter.config.updatetemplate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="newsletter_id" value="{{ $newsletter->id }}">
                        <div class="form-group">
                            <label for="template" class="control-label">Selecciona una plantilla para el Newsletter</label>
                            <select name="template" id="template" class="form-control">
                                @foreach($templates as $template)
                                    <option value="{{ $template['name'] }}" {{ $template['name'] == $newsletter->template ? 'selected' : '' }}>{{ $template['label'] }}</option>
                                @endforeach()
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-md-1 col-md-offset-11">
                                <input type="submit" class="btn btn-success" value="Guardar">
                            </div>
                        </div>                          
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // modal for change banner
            $('#btn-up-banner').on('click', function(){
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('admin.newsletter.update.banner', ['id' => $newsletter->id]) }}')
                form.attr('method', 'POST')
                form.attr('enctype', 'multipart/form-data')
                form.append($('<input>').attr('type', 'hidden').attr('name', 'source').val({{ $newsletter->id }}))

                modal.find('.modal-title').text("{{ __('Cambiar Banner') }}")
                modal.find('#md-btn-submit').val("{{ __('Actualizar Banner') }}")
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>{{ __('Banner') }}</label>
                        <input type="file" name="banner">
                    </div>
                `)
                modal.modal('show')
            })

            // modal for add emails
            $('#btn-add-emails').on('click', function(event){
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var accounts = `@json($newsletter->company->accounts()->toArray())`
                accounts = $.parseJSON(accounts)
                var fields = $.map(accounts, function (item) {
                    return `
                        <label class="ckbox">
                            <input id="accounts[]" type="checkbox" name="accounts[]" value="${item.email}" checked>
                            <span>${item.email}</span>
                        </label>
                    `  
                })
                form.attr('action', '{{ route('admin.newsletter.config.addemails') }}')
                form.attr('method', 'POST')
                form.addClass('form-horizontal')

                modal.find('.modal-title').text("{{ __('Agregar las siguientes cuentas') }}")
                modal.find('#md-btn-submit').val("{{ __('Agregar') }}")
                modal.find('.modal-body').html(`
                    <input type="hidden" name="newsletter_id" value="{{ $newsletter->id }}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label nopaddingtop">Lista de correos</label>
                        <div class="col-sm-9">
                            ${fields}          
                        </div>
                    </div>
                `)
                modal.modal('show')
            })

            // modal for add one email
            $('#btn-add-email').on('click', function(event){
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                
                form.attr('action', '{{ route('admin.newsletter.config.addemails') }}')
                form.attr('method', 'POST')
                form.addClass('form-horizontal')

                modal.find('.modal-title').text("{{ __('Agregar correo') }}")
                modal.find('#md-btn-submit').val("{{ __('Agregar') }}")
                modal.find('.modal-body').html(`
                    <input type="hidden" name="newsletter_id" value="{{ $newsletter->id }}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label nopaddingtop">Email</label>
                        <div class="col-sm-9">
                            <input type="text" name="accounts[]" class="form-control">          
                        </div>
                    </div>
                `)
                modal.modal('show')
            })

            // modal for remove one email
            $('#media-list-emails').on('click', '.btn-remove-email', function(event){
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var id = $(this).data('id')
                var email = $(this).data('email')
                
                form.attr('action', '{{ route('admin.newsletter.config.removeemails') }}')
                form.attr('method', 'POST')

                modal.find('.modal-title').text("{{ __('Remover correo') }}")
                modal.find('#md-btn-submit').val("{{ __('Eliminar') }}").removeClass('btn-primary').addClass('btn-danger')
                modal.find('.modal-body').html(`
                    <input type="hidden" name="id" value="${id}">
                    <p>¿Vas a eliminar a <strong>${email}</strong>?</p>
                `)
                modal.modal('show')
            })
        })
    </script>
@endsection
