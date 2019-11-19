@extends('layouts.home2')
@section('title', ' - Entrar a mi cuenta')
@section('content')
        <!-- container -->
        <div class="container">

            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li class="active">Acceso a tu cuenta</li>
            </ol>

            <div class="row">
                
                <!-- Article main content -->
                <article class="col-xs-12 maincontent">
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
                                    <div class="top-margin">
                                        <label for="email" >Correo <span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback text-muted" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="top-margin">
                                        <label for="password">Contraseña <span class="text-danger">*</span></label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-4 text-right">
                                            <input type="submit" value="Entrar" class="btn btn-action">
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