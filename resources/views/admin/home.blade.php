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
                                <div class="icon icon ion-android-people"></div>
                            </div>
                            <div class="pull-left">
                                <h4 class="panel-title">Clientes</h4>
                                <h3>{{ number_format($count['clients']) }}</h3>
                                {{-- <h3>23.30%</h3> --}}
                                {{-- <h5 class="text-success">2.00% increased</h5> --}}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="pull-left">
                                <div class="icon icon ion-android-contact"></div>
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
                                <div class="icon icon ion-stats-bars"></div>
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
        </div>
    </div>
@endsection
