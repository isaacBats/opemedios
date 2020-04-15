@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">
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
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="table-sources">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"></th>
                            <th class="text-center">{{ __('Nombre') }}</th>
                            <th class="text-center">{{ __('Empresa') }}</th>
                            <th class="text-center">{{ __('Activa') }}</th>
                            <th class="text-center">{{ __('Logo') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sources as $source)
                            <tr>
                                <td>{{ $loop->iteration }}</td>  
                                <td class="text-center"><i class="fa {{ $source->mean->icon }} fa-3x"></i></td>
                                <td>{{ $source->name }}</td>  
                                <td>{{ $source->company }}</td>  
                                <td class="text-center">
                                    <input type="checkbox" {{ ($source->active == 1 ? 'checked' : '') }} data-toggle="toggle" data-onstyle="success" data-source="{{ $source->id }}" data-name="{{ $source->name }}" class="btn-status">
                                </td>  
                                <td class="text-center"><img src="{{ asset("images/{$source->logo}") }}" alt="{{ $source->name }}"></td>  
                                <td class="table-options">
                                    <a href="{{ route('source.show', ['id' => $source->id]) }}" style="margin-right: 1em;"><i class="fa fa-eye fa-2x"></i></a>
                                    <a href="{{ route('source.delete', ['id' => $source->id]) }}" data-source="{{ $source->id }}" data-name="{{ $source->name }}"  class="btn-delete-source"><i class="fa fa-trash fa-2x"></i></a>
                                </td>  
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No hay fuentes por mostrar') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $sources->links() }}
            </div>
        </div>
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