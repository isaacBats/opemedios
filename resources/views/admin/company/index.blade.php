@extends('layouts.admin')
@section('admin-title', ' - Empresas')
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
            <table class="table table-bordered table-inverse table-striped nomargin" id="table-company-list">
              <thead>
                <tr>
                  <th class="text-center">
                    <label class="ckbox">
                      <input type="checkbox"><span></span>
                    </label>
                  </th>
                  <th class="text-center">#</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Giro</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($companies as $company)
                    <tr>
                      <td class="text-center">
                        <label class="ckbox">
                          <input type="checkbox"><span></span>
                        </label>
                      </td>
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
<div class="col-sm-4 col-md-3 col-lg-2">
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">{{ __('Filtrar Empresas') }}</h4>
        </div>
        <div class="panel-body">
            <form action="{{ route('companies') }}" method="GET">
                <div class="form-group">
                    <label class="control-label center-block">{{ __('Buscar por nombre') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ __('Buscar por nombre') }}" value="{{ request()->get('name') }}">
                </div>
                <div class="form-group">
                    <label class="control-label center-block">{{ __('Giro') }}</label>
                    <select name="turn" class="form-control">
                        <option value="">{{ __('Filtrar por giro') }}</option>
                        @foreach($turns as $turn)
                            @if($turn->name == 'disable')
                                @continue
                            @endif
                            <option value="{{ $turn->id }}" {{ request()->get('turn') == $turn->id ? 'selected' : '' }}>{{ $turn->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-success btn-quirk btn-block" value="{{ __('Filtrar') }}">
            </form>
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