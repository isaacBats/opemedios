@extends('layouts.admin')
@section('content')
    <div class="row">
        {{-- <div class="panel"> --}}
            {{-- <div class="panel-body"> --}}
                <nav class="navbar navbar-inverse nav-margin-bt">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-cloud-opemedios" aria-expanded="false">
                                <span class="sr-only">{{ __('Toggle navigation') }}</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="javascript:void(0);" class="navbar-brand">{{ __('Gestor de archivos') }}</a>
                        </div>
                        <div class="collapse navbar-collapse" id="menu-cloud-opemedios">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#">Link 1</a></li>
                                <li><a href="#">Link 2</a></li>
                                <li><a href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="panel">
                    <div class="panel body">
                        <div class="row filemanager">
                            <div class="col-md-3">
                                <nav class="nav-sidebar nav-sidebar-custom">
                                    <ul class="nav-custom">
                                        <li class="active"><i class="fa fa-folder-o"></i> Documentos</li>
                                        <li><i class="fa fa-folder-open-o"></i> Documentos
                                            <ul class="nav-custom">
                                                <li><i class="fa fa-folder-o"></i> Documents _ 1</li>
                                            </ul>
                                        </li>
                                        <li><i class="fa fa-folder-o"></i> Documentos</li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-9">
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                  <div class="thmb">
                                    <div class="thmb-prev">
                                      {{-- <img src="../images/mp3.png" class="img-responsive" alt="" /> --}}
                                      <span class="fa fa-folder-o fa-14x"></span>
                                    </div>
                                    <h5 class="fm-title"><a href="">Happy.mp3</a></h5>
                                  </div><!-- thmb -->
                                </div><!-- col-xs-6 -->

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                  <div class="thmb">
                                    <label class="ckbox">
                                      <input type="checkbox"><span></span>
                                    </label>
                                    <div class="btn-group fm-group">
                                      <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu pull-right fm-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-share"></i> Share</a></li>
                                        <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
                                        <li><a href="#"><i class="fa fa-download"></i> Download</a></li>
                                        <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                      </ul>
                                    </div><!-- btn-group -->
                                    <div class="thmb-prev">
                                      <img src="../images/mp3.png" class="img-responsive" alt="" />
                                    </div>
                                    <h5 class="fm-title"><a href="">Happy.mp3</a></h5>
                                    <small class="text-muted">Added: July 1, 2015</small>
                                  </div><!-- thmb -->
                                </div><!-- col-xs-6 -->
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        {{-- </div> --}}
    </div>
@endsection
@section('styles')
    <style>
        .fa-14x {
            font-size: 14rem;
        }
        .nav-custom {
            list-style: none;
        }

        .nav-custom-second {
            list-style: none;
            margin-top: 4px;
        }

        .nav-custom li {
            margin-bottom: 4px;
        }
        .nav-sidebar-custom {
            background-color: #d8dce3;
            padding: 15px 0;
        }
        .nav-margin-bt {
            margin-bottom: unset !important;
        }

    </style>
@endsection