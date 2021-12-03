@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
<div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
    @include('components.clientHeading')
    <div>
        <form action="">
            <div>
                <label for="">Palabra</label>
                <input type="text" name="palabra">
            </div>
        </form>
    </div>
    <!-- Page Content -->
    {{-- <div class="uk-container"> --}}
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
    {{-- </div> --}}
    <div id="list-news" class="filter-this">
        <div class="uk-box-shadow-medium sticky-this uk-padding uk-padding-small contenedor-select-temas">
            <div class="uk-flex uk-flex-middle uk-position-relative">
                <label class="uk-text-uppercase label-tema">Tema:</label>
                <select class="uk-select opciones-temas uk-width-large" id="client-theme-select2" style="width: 100%;">
                    <option value="" data-show-titles="true">Todos los temas</option>
                    @foreach($company->themes as $theme)
                    <option value=".theme{{ $theme->id }}" data-show-titles="false">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="op-content-mt main-content js-temas uk-padding uk-padding-remove-bottom" style="background: #fff;">
            @foreach($company->themes as $theme)
                @if($theme->assignedNews->count() > 0)
                    <div class="row theme{{ $theme->id }}" id="list-new">
                        <h2 id="theme{{ $theme->id }}" >{{ $theme->name }} <small class="count" id="count-{{ $theme->id }}"></small></h2>
                        @php
                            $contadorEntradas = 0;
                        @endphp
                        <div class="news-group uk-container">
                            @foreach($theme->assignedNews()->limit(30)->orderBy('id', 'desc')->get() as $assigned)
                                @if($assigned->theme_id == $theme->id)
                                    @php
                                        $contadorEntradas++;
                                    @endphp
                                    <div uk-grid class="news-single @php echo ($contadorEntradas > 4) ? "uk-hidden": "";  @endphp ">
                                        <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
                                            @if($assigned->news->source)
                                                <img src="{{ asset("images/{$assigned->news->source->logo}") }}" alt="{{ $assigned->news->source->name }}">
                                                <h4 class="uk-margin-remove-top">{{ $assigned->news->source->name ?? "N/A" }}</h4>
                                            @else
                                                <img src="{{ asset("images/sources_logos/default.png") }}" alt="Opemedios default">
                                                <h4 class="uk-margin-remove-top">N/A</h4>
                                            @endif
                                        </div>
                                        <div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
                                            <h3 class="f-h3">
                                                {{ $assigned->news->title  }}
                                            </h3>
                                            <p class="f-p">{!! Illuminate\Support\Str::limit($assigned->news->synthesis, 200) !!}</p>
                                            <div uk-grid class="info">
                                                <div><span class="icon-calendar"></span> {{ $assigned->news->news_date->diffForHumans() }}</div>
                                                <div class="text-muted f-p">{{ $assigned->news->source->company ?? 'N/A' }}</div>
                                                <div class="text-muted f-p">Autor: {{ $assigned->news->author ?? 'N/A' }}</div>
                                                <div><a class="btn btn-primary uk-button uk-button-default" href="{{ route('client.shownew', ['id' => $assigned->news_id, 'company' => $company->slug ]) }}">Ver más</a></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @php echo ($contadorEntradas > 4) ? '<div class="uk-text-center"><a href="#" class="uk-button more-theme-news">mostrar más '.$theme->name.'</a></div>': '';  @endphp
                        </div>
                        @php
                            echo '<span class="count uk-hidden" target="count-'.$theme->id.'">'.$contadorEntradas.'</span>';
                        @endphp
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- /.container -->
</div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/chart/Chart.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            $('#client-theme-select2').select2();
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