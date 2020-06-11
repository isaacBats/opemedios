@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('content')
<div class="col-md-12">
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
        <table class="table table-bordered table-inverse table-striped nomargin">
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
                      <li><a href=""><i class="fa fa-trash"></i></a></li>
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