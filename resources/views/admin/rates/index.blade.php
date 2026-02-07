@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            <strong><i class="fa fa-exclamation-triangle"></i> Advertencia:</strong> {{ session('warning') }}
        </div>
    @endif
    <div class="col-md-12 people-list">
        <div class="people-options clearfix">
            <div class="btn-toolbar">
                <form action="{{ route('rates') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="input-search" class="text-muted">Buscar por fuente</label>
                            <input type="text" class="form-control" name="search" id="input-search" placeholder="Nombre de fuente o red social..." value="{{ request()->get('search') }}">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="select-type" class="text-muted">Tipo</label>
                            <select class="form-control" name="type" id="select-type">
                                <option value="">Todos</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}" {{ request()->get('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="select-social-network" class="text-muted">Red Social</label>
                            <select class="form-control" name="social_network_id" id="select-social-network">
                                <option value="">Todas</option>
                                @foreach($socialNetworks as $sn)
                                    <option value="{{ $sn->id }}" {{ request()->get('social_network_id') == $sn->id ? 'selected' : '' }}>{{ $sn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="select-paginate" class="text-muted">Por página</label>
                            <select class="form-control" name="paginate" id="select-paginate">
                                <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group" style="margin-top: 20px">
                            <button class="btn btn-primary btn-lg"><i class="fa fa-search"></i> Buscar</button>
                            @if(request()->hasAny(['type', 'social_network_id', 'search']))
                                <a href="{{ route('rates') }}" class="btn btn-warning ml-2" style="margin-left: .8em">Limpiar</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <span class="people-count pull-right">Mostrando <strong>{{ $rates->count() }} de {{ $rates->total() }}</strong> tarifas</span>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h4 class="panel-title">{{ __('Administrador de Tarifas') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('rate.import') }}" class="btn btn-info btn-quirk"><i class="fa fa-upload"></i> {{ __('Importar CSV') }}</a>
                        <a href="{{ route('rate.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva Tarifa') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-rates">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Fuente / Red Social</th>
                                <th>Tipo Contenido</th>
                                <th>Rango</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rates as $rate)
                                <tr>
                                    <td>{{ $rate->id }}</td>
                                    <td>
                                        <span class="label label-{{ $rate->type === 'social' ? 'info' : ($rate->type === 'internet' ? 'primary' : 'warning') }}">
                                            {{ $types[$rate->type] ?? $rate->type }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($rate->socialNetwork)
                                            {{ $rate->socialNetwork->name }}
                                        @elseif($rate->source)
                                            {{ $rate->source->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $rate->content_type ? ucfirst($rate->content_type) : '-' }}</td>
                                    <td>{{ number_format($rate->min_value) }} - {{ $rate->max_value ? number_format($rate->max_value) : '∞' }}</td>
                                    <td><strong>${{ number_format($rate->price, 2) }}</strong></td>
                                    <td>
                                        <a href="{{ route('rate.show', ['id' => $rate->id]) }}" class="btn btn-sm btn-info" title="Ver/Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('rate.delete', ['id' => $rate->id]) }}" class="btn btn-sm btn-danger btn-delete-rate" data-rate="{{ $rate->id }}" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay tarifas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {{ $rates->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#table-rates').on('click', '.btn-delete-rate', function(event){
                event.preventDefault();
                var rateId = $(this).data('rate');
                var modal = $('#modal-default');
                var form = $('#modal-default-form');
                var urlAction = $(this).attr('href');

                form.attr('action', urlAction);
                form.attr('method', 'POST');

                modal.find('.modal-title').text('Eliminar tarifa');
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val('Eliminar');
                modal.find('.modal-body').html('¿Estás seguro que quieres eliminar la tarifa <strong>#' + rateId + '</strong>?');
                modal.modal('show');
            });
        });
    </script>
@endsection
