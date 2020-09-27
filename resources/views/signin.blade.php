@extends('layouts.home')
@section('title', ' - Entrar a mi cuenta')
@section('content')
        <!-- container -->
        <div class="uk-container op-content-mt">
            <div class="uk-padding-large uk-padding-remove-horizontal">
                
                <!-- Article main content -->
                <article class="col-xs-12 maincontent uk-padding-large uk-padding-remove-horizontal uk-grid-divider uk-flex uk-flex-center" uk-grid>
                    <header class="page-header">
                        <h1 class="page-title">Ingresar</h1>
                    </header>
                    
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="thin text-center">Entra a tu cuenta</h3>
                                <hr>
                                
                                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                    @csrf
                                    <div class="top-margin uk-margin">
                                        <label for="email" class="uk-label">Correo <span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="uk-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback text-muted" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="top-margin uk-margin">
                                        <label for="password" class="uk-label">Contraseña <span class="text-danger">*</span></label>
                                        <input id="password" type="password" class="uk-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-4 text-right">
                                            <input type="submit" value="Entrar" class="uk-button uk-button-default uk-button-large btn btn-action">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    
                </article>
                <!-- /Article -->

            </div>
        </div>  <!-- /container -->
@endsection