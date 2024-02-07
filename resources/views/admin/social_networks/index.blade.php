@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12 people-list">
    <div class="people-options clearfix"> <!-- filter-options -->
        <div class="btn-toolbar">
            <form action="{{ route('social_networks') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="input-social_network-name" class="text-muted">Nombre</label>
                        <input type="text" name="name" class="form-control" id="input-social_network-name" value="{{ request()->get('name') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                        <select class="form-control" name="paginate">
                            <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group" style="margin-top: 20px">
                        <button class="btn btn-primary btn-lg"> Buscar</button>
                        @if(request()->has('name'))
                            <a href="{{ route('social_networks') }}" class="btn btn-warning ml-2" style="margin-left: .8em"> Limpiar filtros </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $redes_sociales->count() }} de {{ $redes_sociales->total() }}</strong> redes sociales</span>
    </div><!-- filter-options -->
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                        <h4 class="panel-title">{{ __('Administrador de redes sociales') }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('social_network.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva red social') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="panel-body-social_networks">
                @include('admin.social_networks.table_redes')
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
            // Modal for delete social_network
            $('#table-social_networks').on('click', '.btn-delete-social_network', function(event){
                event.preventDefault()
                // event.stopPropagation()
                var sourceId = $(this).data('social_network')
                var sourceName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar red social`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${sourceName}</strong>?`)
                modal.modal('show')
            })

        })
    </script>
@endsection