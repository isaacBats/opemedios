@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ __('Create new user') }}</h4>
            <form class="form-sample" method="post" action="{{ route('storeUser') }}">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <p class="card-description">
                    {{ __('Personal info') }}
                    <hr>
                  </p>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                    </div>
                    @if ($errors->first('name'))
                      <div>
                        <p class="text-danger">{{ $errors->first('name') }}</p>                        
                      </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Last Name') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    @if ($errors->first('email'))
                      <div>
                        <p class="text-danger">{{ $errors->first('email') }}</p>                        
                      </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Mobil') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <p class="card-description">
                    {{ __('Laboral info') }}
                    <hr>
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
                      <input type="text" class="form-control" name="position" value="{{ old('position') }}" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Comments') }}</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="comments" rows="5">{{ old('comments') }}</textarea>
                    </div>
                  </div>
                  <p class="card-description">
                    {{ __('System Data') }}
                    <hr>
                  </p>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Username') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="username" value="{{ old('username') }}" />
                    </div>
                    @if ($errors->first('username'))
                      <div>
                        <p class="text-danger">{{ $errors->first('username') }}</p>                        
                      </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="password"/>
                    </div>
                    @if ($errors->first('password'))
                      <div>
                        <p class="text-danger">{{ $errors->first('password') }}</p>                        
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <button class="btn btn-primary" type="submit" >Create</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection