@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="col-md-12 people-list">
    <div class="people-options clearfix"> <!-- filter-options -->
        <div class="btn-toolbar">
            <form action="{{ route('companies') }}" method="GET">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label for="input-company-name" class="text-muted">Nombre</label>
                        <input type="text" name="name" class="form-control" id="input-company-name" value="{{ request()->get('name') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="select-company-turn" class="text-muted">Giro</label>
                        <select class="form-control" name="turn">
                            <option value="">Giro</option>
                            @foreach(App\Turn::all() as $turn)
                                <option value="{{ $turn->id }}" {{ request()->get('turn') == $turn->id ? 'selected' : '' }}>{{ $turn->name }}</option>
                            @endforeach
                        </select>
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
                        @if(request()->has('name') || request()->has('turn') )
                            <a href="{{ route('companies') }}" class="btn btn-warning ml-2" style="margin-left: .8em"> Limpiar filtros </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $companies->count() }} de {{ $companies->total() }}</strong> empresas</span>
    </div><!-- filter-options -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                    <h4 class="panel-title" style="padding: 12px 0;">Administrador de empresas</h4>  
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                    <a href="{{ route('company.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> Nueva empresa</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-primary table-striped nomargin" id="table-company-list">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Giro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center" >{{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}</td>
                                <td class="text-left" >{{ $company->name }}</td>
                                <td class="text-left">{{ $company->turn->name }}</td>
                                    <td class="table-options">
                                        <li><a href="{{ route('company.show', ['id' => $company->id]) }}"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="{{ route('admin.company.delete', ['id' => $company->id]) }}" class="btn-delete-company" data-name="{{ $company->name }}"><i class="fa fa-trash"></i></a></li>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $companies->links() !!}        
      </div><!-- table-responsive -->
    </div>
  </div><!-- panel -->
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            // Modal for delete a company
            $('#table-company-list').on('click', '.btn-delete-company', function(event){
                event.preventDefault()
                var companyName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar Empresa`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${companyName}</strong>?
                    <br />
                    <p>Si eliminas la empresa ${companyName} tambien se van a borrar las cuentas y los temas asociados a la empresa.</p>
                `)
                modal.modal('show')
            })
        })
    </script>
@endsection