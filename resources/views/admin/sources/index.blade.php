@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-sm-8 col-md-9 col-lg-10">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                        <h4 class="panel-title">{{ __('Administrador de Fuentes') }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('source.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva Fuente') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="panel-body-sources">
                @include('admin.sources.table_sources')
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-md-3 col-lg-2">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Filtrar Fuentes') }}</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('sources') }}" method="GET">
                    <div class="form-group">
                        <label class="control-label center-block">{{ __('Buscar por nombre') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{ __('Buscar por nombre') }}" value="{{ request()->get('name') }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label center-block">{{ __('Buscar por empresa') }}</label>
                        <input type="text" name="company" class="form-control" placeholder="{{ __('Buscar por empresa') }}" value="{{ request()->get('company') }}">
                    </div>
                    <input type="submit" class="btn btn-success btn-quirk btn-block" value="{{ __('Filtrar') }}">
                </form>
            </div>
        </div><!-- panel -->
    </div>
@endsection
@section('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            // Modal for delete source
            $('#table-sources').on('click', '.btn-delete-source', function(event){
                event.preventDefault()
                // event.stopPropagation()
                var sourceId = $(this).data('source')
                var sourceName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar fuente`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${sourceName}</strong>?`)
                modal.modal('show')
            })

            // status of the source
            $('#table-sources').on('change', '.btn-status', function (){
                var sourceId = $(this).data('source')
                var sourceName = $(this).data('name')

                if($(this).is(':checked')) {
                    $.post(`/panel/fuente/estatus/${sourceId}`, { "_token": $('meta[name="csrf-token"]').attr('content'), 'status': 1, 'source': sourceId }, function(res){
                        $.gritter.add({
                            title: 'Fuente Activa',
                            text: res.message,
                            class_name: 'with-icon check-circle success'
                        })
                    }).fail(function(res){
                        $.gritter.add({
                            title: 'Error al cambiar el estatus de la fuente',
                            text: res.error,
                            class_name: 'with-icon times-circle danger'
                        })
                    })
                }
                else{
                    $.post(`/panel/fuente/estatus/${sourceId}`, { "_token": $('meta[name="csrf-token"]').attr('content'), 'status': 0, 'source': sourceId }, function(res){
                        $.gritter.add({
                            title: 'Fuente Inactiva',
                            text: res.message,
                            class_name: 'with-icon check-circle success'
                        })
                    }).fail(function(res){
                        $.gritter.add({
                            title: 'Error al cambiar el estatus de la fuente',
                            text: res.error,
                            class_name: 'with-icon times-circle danger'
                        })
                    })
                }
            })
        })
    </script>
@endsection