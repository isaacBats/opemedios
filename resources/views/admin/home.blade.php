@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-9 col-lg-8 dash-left">
            <div class="panel panel-site-traffic">
                <div class="panel-heading">
                    <h4 class="panel-title text-success">Operaciones del día</h4>
                    {{-- <p class="nomargin">Past 30 Days — Last Updated July 14, 2015</p> --}}
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="fa fa-building companies"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">{{ __('Empresas') }}</h4>
                                <h3>{{ number_format($count['clients']) }}</h3>
                                {{-- <h3>23.30%</h3> --}}
                                {{-- <h5 class="text-success">2.00% increased</h5> --}}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="fa fa-users"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">Usuarios</h4>
                                <h3>{{ number_format($count['users']) }}</h3>
                                {{-- <h3>23.30%</h3> --}}
                                {{-- <h5 class="text-success">2.00% increased</h5> --}}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="fa fa-pie-chart"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">{{ __('Sectores') }}</h4>
                                <h3>{{ number_format($count['sectors']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="fa fa-database"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">{{ __('Fuentes') }}</h4>
                                <h3>{{ number_format($count['sources']) }}</h3>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="fa fa-newspaper"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">Noticias</h4>
                                <h3>{{ number_format($count['news']) }}</h3>
                                {{-- <h3>23.30%</h3> --}}
                                {{-- <h5 class="text-success">2.00% increased</h5> --}}
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row panel-quick-page">
                <div class="col-xs-4 col-sm-5 col-md-4 page-user">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ _('Administrar Usuarios') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('users') }}"><div class="page-icon"><i class="fa fa-users"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 page-products">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Administrar Empresas') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('companies') }}"><div class="page-icon"><i class="fa fa-building"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3 col-md-2 page-events">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Giros') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.turns') }}"><div class="page-icon"><i class="fa fa-gears"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3 col-md-2 page-messages">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Sectores') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.sectors') }}"><div class="page-icon"><i class="fa fa-pie-chart"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Reportes') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Fuentes') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('sources') }}"><div class="page-icon"><i class="fa fa-database"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 page-support">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Noticias') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.news') }}"><div class="page-icon"><i class="fa fa-newspaper"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 page-privacy">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ __('Newsletters') }}</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('newsletters') }}"><div class="page-icon"><i class="fa fa-send-o"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 page-settings">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Settings</h4>
                        </div>
                        <div class="panel-body">
                            <div class="page-icon"><i class="icon ion-gear-a"></i></div>
                        </div>
                    </div>
                </div>
            </div><!-- row -->
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .panel-site-traffic .panel-body .fa {
            font-size: 48px;
            color: #fff;
            margin-right: 20px;
            border-radius: 2px;
            width: 70px;
            line-height: 54px;
        }
        .panel-site-traffic .panel-body .ion-ios-list-outline {
            background-color: #2574ab;
            padding: 7px 18px;
            width: 80%;
        }
        .panel-site-traffic .panel-body .fa-building {
            background-color: #28a1c5;
            padding: 7px 18px;
            width: 80%;
        }
        .panel-site-traffic .panel-body .fa-users {
            background-color: #2ab0c0;
            padding: 7px 18px;
            width: 80%;
        }
        .panel-site-traffic .panel-body .fa-database {
            background-color: #e27c79;
            padding: 7px 18px;
            width: 80%;
        }
        .panel-site-traffic .panel-body .fa-newspaper {
            background-color: #8046da;
            padding: 7px 18px;
            width: 80%;
        }
        .panel-site-traffic .panel-body .fa-pie-chart {
            background-color: #2574ab;
            padding: 7px 18px;
            width: 80%;
        }
    </style>
@endsection
