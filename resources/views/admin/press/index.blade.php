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
                        <h4 class="panel-title">{{ __('Administrador de Portadas y Columnas') }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('admin.press.add') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-responsive" id="table-list-covers">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('Tipo') }}</th>
                            <th class="text-center">{{ __('Fecha') }}</th>
                            <th class="text-center">{{ __('Fuente') }}</th>
                            <th class="text-center">{{ __('Imagen') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($covers as $cover)
                            <tr>
                                @php
                                    $coverType = array_filter($types, function($v, $k) use($cover) { return $k == $cover->cover_type; }, ARRAY_FILTER_USE_BOTH);
                                @endphp
                                <th class="text-center">{{ ($covers->currentPage() - 1) * $covers->perPage() + $loop->iteration }}</th>
                                <th class="text-center">{{ $coverType[$cover->cover_type] }}</th>
                                <th class="text-center">{{ $cover->date_cover->toDateString() }}</th>
                                <th class="text-center">{{ $cover->source->name }}</th>
                                <th style="width: 12%;">
                                    <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->source->name }}" height="180" style="width: auto;">
                                </th>
                                <th class="text-center">
                                    <a href="{{ route('admin.press.edit', ['id' => $cover->id]) }}"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('admin.press.destroy', ['id' => $cover->id]) }}" data-date="{{ $cover->date_cover->toDateString() }}" data-type="{{ $coverType[$cover->cover_type] }}" id="btn-remove-cover"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        @empty
                        <tr>
                            <th class="text-center" colspan="5">{{ __('No hay portadas disponibles') }}</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $covers->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            // delete cover
            $('#table-list-covers').on('click', '#btn-remove-cover', function(event) {
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var type = $(this).data('type')
                var day = $(this).data('date') 

                form.attr('action', $(this).attr('href'))
                form.attr('method', 'POST')
                
                modal.find('.modal-title').text("{{ __('Eliminar') }}")
                modal.find('#md-btn-submit').val("{{ __('Eliminar') }}").removeClass('btn-primary').addClass('btn-danger')
                modal.find('.modal-body').html(`
                    <p>En verdad quieres eliminar el/la <strong>${type}</strong> del día ${day}?</p>
                `)
                modal.modal('show')
            })
        })
    </script>
@endsection