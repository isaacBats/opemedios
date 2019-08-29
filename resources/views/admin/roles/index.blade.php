@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    @if (session('message'))
      <div class="alert alert-{{ session('message')->type }}">
          {{ session('message')->message }}
      </div>
    @endif
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Manager Roles</h4>
              <p class="card-description">
                <a href="{{ route('crateRole') }}" class="btn btn-primary btn-fw">
                    <i class="mdi mdi-plus-circle-outline"></i> 
                    {{ __('New Role') }}
                </a>
              </p>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{ __('New Role') }}</h4>
                      <form class="form-inline" action="{{ route('crateRole') }}" method="post">
                        @csrf
                        <label class="sr-only" for="roleName">Username</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="roleName" placeholder="Role" name="role_name">
                        <button type="submit" class="btn btn-gradient-primary mb-2">{{ __('Create') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>
                      Role
                    </th>
                    <th>
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>
                                {{ $role->guard_name }}
                            </td>
                            <td>
                              <ul>
                                <li><i class="mdi mdi-lead-pencil"></i></li>
                                <li><i class="mdi mdi-delete"></i></li>
                              </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
@endsection