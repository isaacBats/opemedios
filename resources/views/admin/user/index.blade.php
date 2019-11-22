@extends('layouts.admin')
@section('admin-title', ' - Usuarios')
@section('content')
<div class="col-md-12">
  <div class="panel">
    <div class="panel-heading">
      <div class="row">
          <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
            <h4 class="panel-title" style="padding: 12px 0;">Administrador de usuarios</h4>  
          </div>
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
              <a href="" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> Nuevo usuario</a>
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
              <th class="text-center">Correo</th>
              <th class="text-center">Tipo de usuario</th>
              <th class="text-center">Cargo</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
                <tr>
                  <td class="text-center">
                    <label class="ckbox">
                      <input type="checkbox"><span></span>
                    </label>
                  </td>
                  <td class="text-center" >{{ $loop->iteration }}</td>
                  <td class="text-left" >{{ $user->name }}</td>
                  <td class="text-left">{{ $user->email }}</td>
                  <td class="text-left">{{ strtoupper(implode(',',$user->getRoleNames()->toArray())) }}</td>
                  <td class="text-left">{{ $user->metas->where('meta_key', 'user_position')->first()->meta_value }}</td>
                  <td class="table-options">
                      <li><a href="{{ route('user.show', ['id' => $user->id]) }}"><i class="fa fa-eye"></i></a></li>
                      <li><a href=""><i class="fa fa-trash"></i></a></li>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div><!-- table-responsive -->
    </div>
  </div><!-- panel -->
</div>
@endsection