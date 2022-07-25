@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    <!-- Page Content -->
    <div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
        <h1>Bienvenido a {{ $company->name }}</h1>
        <div class="uk-child-width-1-2 uk-text-center" uk-grid>
            <div>
                <div class="uk-card uk-card-body">
                    <img src="{{ asset('images/user-default-logo.png') }}" alt="{{ auth()->user()->name }}">
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-width-expand">
                    <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            {{--<div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="{{ asset("images/user-default-logo.png") }}">
                            </div> --}}
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">{{ auth()->user()->name }}</h3>
                                <p class="uk-text-meta uk-margin-remove-top">
                                    {{ (auth()->user()->metas()->where('meta_key', 'user_position')->count())
                                        ? auth()->user()->metas()->where('meta_key', 'user_position')->first()->meta_value
                                        : ' '
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-body">
                        <h4>Acerca de mí:</h4>
                        <div class="uk-comment-body">
                            <p>{{
                                (auth()->user()->metas()->where('meta_key', 'user_aboutme')->count())
                                ? auth()->user()->metas()->where('meta_key', 'user_aboutme')->first()->meta_value
                                : 'No hay información sobre mi para mostrar'
                            }}</p>
                        </div>
                    </div>
                    <div class="uk-card-footer">
                        <div class="uk-text-left" uk-grid>
                            <div class="uk-width-auto">
                                <label for="">Dirección:</label>
                                {{
                                    (auth()->user()->metas()->where('meta_key', 'user_address')->count())
                                    ? auth()->user()->metas()->where('meta_key', 'user_address')->first()->meta_value
                                    : 'N/E'
                                }}
                            </div>
                            <div class="uk-column-1-3 uk-column-divider">
                                <p>
                                    <label>Email</label>
                                    {{ auth()->user()->email }}
                                </p>
                                <p>
                                    <label>Tel. Oficina: </label>
                                    {{
                                        (auth()->user()->metas()->where('meta_key', 'user_phone')->count())
                                        ? auth()->user()->metas()->where('meta_key', 'user_phone')->first()->meta_value
                                        : 'N/E'
                                    }}
                                </p>
                                <p>
                                    <label>WhatsApp: </label>
                                    {{
                                        (auth()->user()->metas()->where('meta_key', 'user_whatsapp')->count())
                                        ? auth()->user()->metas()->where('meta_key', 'user_whatsapp')->first()->meta_value
                                        : 'N/E'
                                    }}
                                </p>
                            </div>
                            <div class="uk-width-1-2"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="uk-card uk-card-default uk-card-body">
                    <h2>Bienvenido:</h2>
                    <p>Nombre: <span>{{ auth()->user()->name }}</span></p>
                    <p>Correo: <span>{{ auth()->user()->email }}</span></p>
                    <p>Cargo: <span>{{ auth()->user()->metas()->where('meta_key', 'user_position')->first()->meta_value }}</span></p>
                </div> --}}
            </div>
<!--            <div>
                <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                    <div>
                        <div class="uk-card uk-card-primary uk-card-body">Item</div>
                    </div>
                    <div>
                        <div class="uk-card uk-card-primary uk-card-body">Item</div>
                    </div>
                </div>
            </div>-->
        </div>
        <div class="uk-margin uk-card uk-card-default uk-card-body">
            <div uk-grid>
                <div class="uk-width-1-3@l">
                    <p>Noticias de hoy: <strong>{{ $company->assignedNews()->whereDate('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</strong></p>
                </div>
                <div class="uk-width-1-3@l">
                    <p>Noticias del mes: <strong>{{ $company->assignedNews()->whereYear('created_at', Carbon\Carbon::today()->format('Y'))->whereMonth('created_at', Carbon\Carbon::today()->format('m'))->count() }}</strong></p>
                </div>
                <div class="uk-width-1-3@l">
                    <p>Total: <strong>{{ $company->assignedNewsCount() }}</strong></p>
                </div>
            </div>
        </div>
        <div class="uk-text-center uk-margin-bottom" uk-grid>
            <div class="uk-width-1-2">
                <div class="uk-card uk-card-default uk-card-body">
                    <canvas id="canvas-graph"></canvas>
                </div>
            </div>
            <div class="uk-width-1-2">
                <div class="uk-card uk-card-default uk-card-body">
                    <canvas id="canvas-graph2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/chart/Chart.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            const graph1 = $('#canvas-graph');
            const graph2 = $('#canvas-graph2');

            $.get("{{route('api.client.notesday', ['company' => $company->id])}}", function (notes){
                let days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                const data = [0,0,0,0,0,0,0];

                notes.forEach(note => {
                    let numDay = new Date(note.day).getDay();
                    data[numDay] = note.total;
                });

                chartBar(graph1, data, days, 'Notas por día');
            });

            $.get("{{route('api.client.notesyear', ['company' => $company->id])}}", function (notes){
                let months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                const data = [0,0,0,0,0,0,0,0,0,0,0,0];

                notes.forEach(note => {
                    data[note.month -1] = note.total;
                });

                chartLine(graph2, data, months, 'Notas por año');
            });
        });

        function chartBar(ctx, data, items, title) {
            var myChart = new Chart(ctx, {
                type: 'bar',
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
