@extends('layouts.admin')

@section('title', 'Users')

@section('content')
  @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
  @endif
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Manager Users</h4>
              <p class="card-description">
                <a href="{{ route('crateUser') }}" class="btn btn-primary btn-fw">
                    <i class="mdi mdi-account-plus "></i> 
                    {{ __('Add User') }}
                </a>
              </p>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>
                      {{ __('Full name') }}
                    </th>
                    <th>
                      {{ __('Email') }}
                    </th>
                    <th>
                      {{ __('Position') }}
                    </th>
                    <th>
                      {{ __('Roll') }}
                    </th>
                    <th>
                      {{ __('Actions') }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($all as $register)
                        <tr>
                            <td>
                                {{ "$register->name $register->last_name" }}
                            </td>
                            <td>
                                {{ $register->email }}
                            </td>
                            <td>
                                Position
                            </td>
                            <td>
                                Roll
                            </td>
                            <td>
                                <div class="rounded-legend legend-horizontal legend-top-right">
                                  <ul>
                                    <li class="icon-size"><a href=""><i class="mdi mdi-lead-pencil"></i></a></li>
                                    <li class="icon-size"><a href=""><i class="mdi mdi-delete"></i></a></li>
                                  </ul>
                                </div>
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