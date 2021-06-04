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
                <form action="{{ route('admin.sectors') }}" method="GET">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="input-sector-name" class="text-muted">Nombre</label>
                            <input type="text" name="name" class="form-control" id="input-sector-name" value="{{ request()->get('name') }}">
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
                                <a href="{{ route('admin.sectors') }}" class="btn btn-warning ml-2" style="margin-left: .8em"> Limpiar filtros </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $sectors->count() }} de {{ $sectors->total() }}</strong> sectores</span>
        </div><!-- filter-options -->
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                        <h4 class="panel-title" style="padding: 12px 0;">{{ __('Sectores') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('admin.sector.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nuevo sector') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-primary table-striped nomargin" id="table-sectors">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('Nombre') }}</th>
                            <th class="text-center">{{ __('Descripción') }}</th>
                            <th class="text-center">{{ __('Estatus') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sectors as $sector)
                            <tr>
                                <td class="text-center">{{ ($sectors->currentPage() - 1) * $sectors->perPage() + $loop->iteration }}</td>
                                <td>{{ $sector->name }}</td>
                                <td>{{ $sector->description }}</td>
                                <td class="text-center">
                                    <i class="fa {{ $sector->active ? 'fa-check' : 'fa-close' }}"></i>
                                </td>
                                <td class="table-options">
                                  <li><a href="{{ route('admin.sector.edit', ['id' => $sector->id]) }}"><i class="fa fa-pencil"></i></a></li>
                                  <li><a href="{{ route('admin.sector.destroy', ['id' => $sector->id]) }}" data-sector="{{ $sector->id }}" data-name="{{ $sector->name }}" class="btn-delete-sector"><i class="fa fa-trash"></i></a></li>
                              </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $sectors->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // Modal for delete source
            $('#table-sectors').on('click', '.btn-delete-sector', function(event){
                event.preventDefault()
                var sectorId = $(this).data('sector')
                var sectorName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar sector`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${sectorName}</strong>?`)
                modal.modal('show')
            })
        })
    </script>
@endsection