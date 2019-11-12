@extends('layouts.home2')
@section('title', ' - Entrar mi cuenta')
@section('content')
    <header id="head" class="secondary"></header>

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
                                
                                <form method="POST" action="/sign-in">
                                    <div class="top-margin">
                                        <label>Usuario <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required="true" name="username">
                                    </div>
                                    <div class="top-margin">
                                        <label>Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" required="true" name="password">
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