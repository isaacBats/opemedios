@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Manager Users</h4>
              <p class="card-description">
                <a href="{{ route('addUser') }}" class="btn btn-primary btn-fw">
                    <i class="mdi mdi-account-plus "></i> 
                    {{ __('Add User') }}
                </a>
              </p>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>
                      User
                    </th>
                    <th>
                      First name
                    </th>
                    <th>
                      Position
                    </th>
                    <th>
                      Roll
                    </th>
                    <th>
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($all as $register)
                        <tr>
                            <td class="py-1">
                                <img src="../../images/faces-clipart/pic-1.png" alt="image"/>
                            </td>
                            <td>
                                {{ $register->name }}
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                            <td>
                                $ 77.99
                            </td>
                            <td>
                                May 15, 2015
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