@extends('layouts.admin')
@section('admin-title', ' - Configuración newsletters')
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
          <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
            <h4 class="panel-title" style="padding: 12px 0;">Lista de configuración newsletters</h4>
          </div>
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
              <a href="{{ route('admin.newsletter.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> Nuevo newsletter</a>
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
              <th class="text-center">Compañia</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($newsletters as $newsletter)
                <tr>
                  <td class="text-center">
                    <label class="ckbox">
                      <input type="checkbox"><span></span>
                    </label>
                  </td>
                  <td class="text-center" >{{ $loop->iteration }}</td>
                  <td class="text-left" >{{ $newsletter->name }}</td>
                  <td class="text-left">{{ $newsletter->company->name }}</td>
                  <td class="table-options">
                      <li><a href=""><i class="fa fa-eye"></i></a></li>
                      <li><a href=""><i class="fa fa-trash"></i></a></li>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{-- pagination --}}
        </div>
      </div><!-- table-responsive -->
    </div>
  </div><!-- panel -->
</div>
@endsection
