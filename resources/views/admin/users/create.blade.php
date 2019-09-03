@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ __('Create new user') }}</h4>
            <form class="form-sample">
              <p class="card-description">
                {{ __('Personal info') }}
              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Last Name') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="last_name"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Mobil') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <p class="card-description">
                    {{ __('Laboral info') }}
                  </p>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Type') }}</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="user_type">
                        <option value=0 >{{ __('User Type') }}</option>
                        <option value=1 >Admin</option>
                        <option value=2 >Encargado de área</option>
                        <option value=3 >Monitorista</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Position') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="position"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Comments') }}</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="comments" rows="5"></textarea>
                    </div>
                  </div>
                  <p class="card-description">
                    {{ __('System Data') }}
                  </p>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Username') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="username"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="password"/>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection