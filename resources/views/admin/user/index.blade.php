@extends('layouts.admin')
@section('admin-title', ' - Usuarios')
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
            <h4 class="panel-title" style="padding: 12px 0;">{{ __('Administrador de usuarios') }}</h4>  
          </div>
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
              <a href="{{ route('register.user') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nuevo usuario') }}</a>
          </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-bordered table-inverse table-striped nomargin" id="table-list-users">
          <thead>
            <tr>
              {{-- <th class="text-center">
                <label class="ckbox">
                  <input type="checkbox"><span></span>
                </label>
              </th> --}}
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
                  {{-- <td class="text-center">
                    <label class="ckbox">
                      <input type="checkbox"><span></span>
                    </label>
                  </td> --}}
                  <td class="text-center" >{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                  <td class="text-left" >{{ $user->name }}</td>
                  <td class="text-left">{{ $user->email }}</td>
                  <td class="text-left">{{ strtoupper(implode(',',$user->getRoleNames()->toArray())) }}</td>
                  <td class="text-left">{{ $user->metas->where('meta_key', 'user_position')->first()->meta_value }}</td>
                  <td class="table-options">
                      <li><a href="{{ route('user.show', ['id' => $user->id]) }}"><i class="fa fa-eye"></i></a></li>
                      <li><a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" data-name="{{ $user->name }}" class="btn-delete-user"><i class="fa fa-trash"></i></a></li>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {!! $users->links() !!}
        </div>
      </div><!-- table-responsive -->
    </div>
  </div><!-- panel -->
</div>
<div class="col-sm-4 col-md-3 col-lg-2">
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">{{ __('Filtrar Usuarios') }}</h4>
        </div>
        <div class="panel-body">
            <form action="{{ route('users') }}" method="GET">
                <div class="form-group">
                    <label class="control-label center-block">{{ __('Buscar por nombre o correo') }}</label>
                    <input type="text" name="query" class="form-control" placeholder="{{ __('Buscar por nombre o correo') }}" value="{{ request()->get('query') }}">
                </div>
                <div class="form-group">
                    <label class="control-label center-block">{{ __('Tipo de usuario') }}</label>
                    <select name="roll" class="form-control">
                        <option value="">{{ __('Filtrar por tipo de usuario') }}</option>
                        @foreach($roles as $rol)
                            @if($rol->name == 'disable')
                                @continue
                            @endif
                            <option value="{{ $rol->id }}" {{ request()->get('roll') == $rol->id ? 'selected' : '' }}>{{ App\User::getRoleNameCustom($rol->name) }}</option>
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
        $(document).ready(function(){
            $('table#table-list-users').on('click', 'a.btn-delete-user', function(event){
                event.preventDefault()
                var action = $(this).attr('href')
                var userName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('method', 'GET')
                form.attr('action', action)

                modal.find('.modal-title').html(`Vas a eliminar a ${userName}.`)
                modal.find('.modal-body').html(`<h4>¿Quieres eliminar a ${userName}?</h4>`)
                modal.find('#md-btn-submit').attr('value', 'Si')

                modal.modal('show')

            })
        })
    </script>
@endsection