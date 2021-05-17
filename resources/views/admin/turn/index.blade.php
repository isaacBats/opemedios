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
                <form action="{{ route('admin.turns') }}" method="GET">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="input-company-name" class="text-muted">Nombre</label>
                            <input type="text" name="name" class="form-control" id="input-company-name" value="{{ request()->get('name') }}">
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
                                <a href="{{ route('admin.turns') }}" class="btn btn-warning ml-2" style="margin-left: .8em"> Limpiar filtros </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $turns->count() }} de {{ $turns->total() }}</strong> giros</span>
        </div><!-- filter-options -->
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                        <h4 class="panel-title" style="padding: 12px 0;">{{ __('Giros') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('admin.turns.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nuevo giro') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-primary table-striped nomargin" id="table-turns">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('Nombre') }}</th>
                            <th class="text-center">{{ __('Descripción') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turns as $turn)
                            <tr>
                                <td class="text-center">{{ ($turns->currentPage() - 1) * $turns->perPage() + $loop->iteration }}</td>
                                <td>{{ $turn->name }}</td>
                                <td>{{ $turn->description }}</td>
                                <td class="table-options">
                                  <li><a href="{{ route('admin.turns.edit', ['id' => $turn->id]) }}"><i class="fa fa-pencil"></i></a></li>
                                  <li><a href="{{ route('admin.turns.destroy', ['id' => $turn->id]) }}" data-name="{{ $turn->name }}" class="btn-delete-turn"><i class="fa fa-trash"></i></a></li>
                              </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $turns->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // Modal for delete source
            $('#table-turns').on('click', '.btn-delete-turn', function(event){
                event.preventDefault()
                var turnName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar giro`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${turnName}</strong>?`)
                modal.modal('show')
            })
        })
    </script>
@endsection