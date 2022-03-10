@extends('layouts.admin')
@section('admin-title', ' - Usuarios')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="col-md-12 people-list">
    <div class="people-options clearfix"> <!-- filter-options -->
        <div class="btn-toolbar">
            <form action="{{ route('users') }}" method="GET">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label for="input-user-name" class="text-muted">Nombre</label>
                        <input type="text" name="name" class="form-control" id="input-user-name" value="{{ request()->get('name') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="input-user-email" class="text-muted">Correo</label>
                        <input type="text" name="email" class="form-control" id="input-user-email" value="{{ request()->get('email') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="select-user-roll" class="text-muted">Tipo de usuario</label>
                        <select class="form-control" name="roll">
                            <option value="">Tipo de usuario</option>
                            @foreach(Spatie\Permission\Models\Role::all() as $role)
                                @if($role->name === 'disable')
                                    @continue
                                @endif
                                <option value="{{ $role->id }}" {{ request()->get('roll') == $role->id ? 'selected' : '' }}>{{ App\User::getRoleNameCustom($role->name) }}</option>
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
                        @if(request()->has('name') || request()->has('email') || request()->has('roll'))
                            <a href="{{ route('users') }}" class="btn btn-warning ml-2" style="margin-left: .8em"> Limpiar filtros </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $users->count() }} de {{ $users->total() }}</strong> noticias</span>
    </div><!-- filter-options -->
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
                <table class="table table-bordered table-primary table-striped nomargin" id="table-list-users">
                    <thead>
                        <tr>
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
                                <td class="text-center" >{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                <td class="text-left" >
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">
                                        <div class="td-select-all">
                                            {{ $user->name }}
                                        </div>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">
                                        <div class="td-select-all">
                                            {{ $user->email }}
                                        </div>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">
                                        <div class="td-select-all">
                                            {{ App\User::getRoleNameCustom($user->roles->first()->name) }}
                                        </div>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">
                                        <div class="td-select-all">
                                            {{ 
                                                $user->metas->where('meta_key', 'user_position')
                                                ->first()->meta_value 
                                            }}
                                        </div>
                                    </a>
                                </td>
                                <td class="table-options">
                                    <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" data-name="{{ $user->name }}" class="btn-delete-user"><i class="fa fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <div>
            {!! $users->links() !!}
        </div>
    </div>
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