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
                <div class="col-xs-4 col-sm-3 col-md-2 page-user">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Usuarios</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('users') }}"><div class="page-icon"><i class="fa fa-users"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3 col-md-2 page-products">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Empresas</h4>
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
                            <h4 class="panel-title">Sectores</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.sectors') }}"><div class="page-icon"><i class="fa fa-pie-chart"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Reportes</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.report.byclient') }}"><div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div></a>
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
                <div class="col-xs-4 col-sm-4 col-md-4 page-reports">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Reportes para descarga</h4>
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('admin.report.solicitados') }}"><div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div></a>
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
                            <a href="{{ route('admin.newsletters') }}"><div class="page-icon"><i class="fa fa-send-o"></i></div></a>
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
            <div class="row panel-site-traffic">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">Notas por monitor (día actual)</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-primary table-striped nomargin">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Monitor</th>
                                        <th>Notas</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monitores as $monitor)
                                        <tr>
                                            <td>
                                                <form method="GET" action="{{ route('admin.report.byuser', ['user' => $monitor->id]) }}">
                                                    <input type="hidden" name="day" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $loop->iteration }}</a>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="GET" action="{{ route('admin.report.byuser', ['user' => $monitor->id]) }}">
                                                    <input type="hidden" name="day" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $monitor->name }}</a>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="GET" action="{{ route('admin.report.byuser', ['user' => $monitor->id]) }}">
                                                    <input type="hidden" name="day" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $monitor->count }}</a>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="GET" action="{{ route('admin.report.byuser', ['user' => $monitor->id]) }}">
                                                    <input type="hidden" name="day" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $day }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel col-md-3 col-lg-4">
            <div class="col-lg-12">
                <canvas id="graph1"></canvas>
            </div>
            <div class="col-lg-12">
                <canvas id="graph2"></canvas>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/chart/Chart.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            const graph1 = $('#graph1');
            const graph2 = $('#graph2');
            $.get("{{route('api.admin.notesday')}}", function (notes){
                let days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                const data = [0,0,0,0,0,0,0];

                notes.forEach(note => {
                    let numDay = new Date(note.day).getDay();
                    data[numDay] = note.total;
                });

                chartBar(graph1, data, days, 'Notas por día');
            });
            $.get("{{route('api.admin.notesmeans')}}", function (notes){

                chartBar(graph2, notes.data, notes.labels, 'Notas por Medio', 'horizontalBar');
            });
        });

        function chartBar(ctx, data, items, title, type = 'bar') {
            var myChart = new Chart(ctx, {
                type: type,
                data: {
                    labels: items,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        function chartLine(ctx, data, items, title) {
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: items,
                    datasets: [{
                        label: title,
                        data: data,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        }
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/chart/Chart.min.css') }}">
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
