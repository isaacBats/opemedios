@extends('layouts.home')
@section('title', " - Reporte")
@section('content')
    @if (session('status'))
    <div class="uk-alert-success">
        {!! session('status') !!}
    </div>
    @endif
    @if (session('error'))
    <div class="uk-alert-danger">
        {!! session('error') !!}
    </div>
    @endif
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
        <div class="uk-padding reporte-container" style="background: #fff;">
            <h1 class="page-header">Reporte <span class="tema-actual"></span></h1>
            <br>
            <div class="">
                <form action="{{ route('client.report', ['company' => $company]) }}" method="GET" id="form-report-filter">
                    <div class="uk-child-width-1-1 uk-child-width-1-4@s uk-child-width-1-4@m" uk-grid>
                        <input type="hidden" name="company" value="{{ $company->id }}">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Fecha inicio</label>
                            <input id="input-report-date-start" class="form-control uk-input" type="text" name="start_date" value="{{ $from_d }}">
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Fecha fin</label>
                            <input id="input-report-date-end" class="form-control uk-input" type="text" name="end_date" value="{{ $to_d }}">
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Tema</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="theme_id[]" id="" multiple>
                                <option value="">** Todos **</option>
                                @foreach(App\Company::where('slug', session()->get('slug_company'))->first()->themes as $theme)
                                    <option value="{{ $theme->id }}" {{ ((request()->has('theme_id') && is_array(request('theme_id')) && in_array($theme->id, request('theme_id'))) ? 'selected' : '' ) }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Sector</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="sector[]" id="" multiple>
                                <option value="">** Todos **</option>
                                @foreach(App\Sector::all() as $sector)
                                    <option value="{{ $sector->id }}" {{ ((request()->has('sector') && is_array(request('sector')) && in_array($sector->id, request('sector'))) ? 'selected' : '' ) }} >{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">G&eacute;nero</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="genre[]" id="" multiple>
                                <option value="">** Todos **</option>
                                @foreach(App\Genre::all() as $genre)
                                    <option value="{{ $genre->id }}" {{ ((request()->has('genre') && is_array(request('genre')) && in_array($genre->id, request('genre'))) ? 'selected' : '' ) }} >{{ $genre->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Medio</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="mean[]" id="select-report-mean" multiple>
                                <option value="">** Todos **</option>
                                @foreach(App\Means::all() as $mean)
                                    <option value="{{ $mean->id }}" {{ ((request()->has('mean') && is_array(request('mean')) && in_array($mean->id, request('mean'))) ? 'selected' : '' ) }}>{{ $mean->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin" id="div-select-report-sources"></div>
                        <div class="uk-margin">
                            <label for="input-word" class="uk-form-label">Buscar por</label>
                            <input class="form-control uk-input" type="text" name="word" id="input-word" placeholder="T&iacute;tulo o palabra..." value="{{ old('word') }}">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <input id="btn-form-submit" class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Filtrar / Buscar">
                        <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-action uk-button uk-button-large uk-button-secondary uk-box-shadow-medium" id="btn-report-export">Exportar</a>
                        <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-action uk-button uk-button-large uk-button-secondary uk-box-shadow-medium" id="btn-report-export-pdf">Exportar PDF</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="uk-padding uk-padding-remove-top container-tabla-reporte" style="background: #fff;">
            <div class="uk-overflow-auto">
                <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m" uk-grid>
                    <div class="uk-margin">
                        <div id="chart_tendencia"></div>
                    </div>
                    <div class="uk-margin">
                        <div id="chart_medio"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-padding uk-padding-remove-top container-tabla-reporte" style="background: #fff;">
            <div class="uk-overflow-auto">
                <div class="uk-child-width-1-1 uk-child-width-1-1@s uk-child-width-1-1@m" uk-grid>
                    <div class="uk-margin">
                        <div id="chart_hist"></div>
                    </div>
                    <div class="uk-margin">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-padding uk-padding-remove-top container-tabla-reporte" style="background: #fff;">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-striped uk-table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Nota</th>
                            <th>T&iacute;tulo</th>
                            <th>Tema</th>
                            <th>Sector</th>
                            <th>G&eacute;nero</th>
                            <th>Fuente</th>
                            <th>Medio</th>
                            <th>Fecha</th>
                            <th>Costo</th>
                            <th>Tendencia</th>
                            <th>Alcance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td>{{ ($notes->currentPage() - 1) * $notes->perPage() + $loop->iteration }}</td>
                                <td>
                                    {{ "OPE-{$note->id}" }}
                                    {{-- <a target="_blank" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">
                                        {{ "OPE-{$note->id}" }}
                                    </a> --}}
                                </td>
                                <td>
                                    <a class="tooltip" target="_blank" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">
                                        {{ $note->title }}
                                        <span class="tooltiptext">{{ $note->synthesis }}</span>
                                    </a>
                                <td> {{ $note->assignedNews->where('company_id', $company->id)->where('news_id', $note->id)->first()->theme->name ?? 'N/E' }}</td>
                                <td>{{ $note->sector->name ?? 'N/E' }}</td>
                                <td>{{ $note->genre->description ?? 'N/E' }}</td>
                                <td>{{ $note->source->name ?? 'N/E' }}</td>
                                <td>{{ $note->mean->name ?? 'N/E' }}</td>
                                <td>{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</td>
                                <td>{{  number_coin($note->cost) }}</td>
                                <td>{{ $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa') }}</td>
                                <td>{{ number_decimal($note->scope) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $notes->links() !!}
            </div>
        </div>
        <div class="uk-padding uk-padding-remove-horizontal">
            <div class="loader">Cargando...</div>
            <div id="news-by-theme" class="col-md-9">
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
         $(document).ready(function(){
            $('.select2').select2();

            // select mean
            $('#select-report-mean').on('change', function(event) {
                getHTMLSources(event.target.value)
            })

            function getHTMLSources(noteType) {
                $.post('{{ route('api.getsourceshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'mean_id': noteType }, function(res){
                        var divSelectSources = $('#div-select-report-sources')
                            .html(res)
                        divSelectSources.find('label.col-form-label').removeClass().addClass('uk-form-label');
                        divSelectSources.find('div.col-sm-10.col-md-11.col-lg-11').removeClass();
                        divSelectSources.find('#select-fuente').css('width', '100%').select2({
                            minimumInputLength: 3,
                            ajax: {
                                type: 'POST',
                                url: "{{ route('api.getsourceajax') }}",
                                dataType: 'json',
                                data: function(params, noteType) {
                                    return {
                                        q: params.term,
                                        mean_id: $('select#select-report-mean').val(),
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    }
                                },
                                processResults: function(data) {
                                    return {
                                        results: data.items
                                    }
                                },
                                cache: true
                            }
                        })
                    }).fail(function(res){
                        var divSelectSources = $('#div-select-report-sources').html(`<p>No se pueden obtener las fuentes</p>`)
                        console.error(`Error-Sources: ${res.responseJSON.message}`)
                    })
            }

            format = "yy-mm-dd",
            from = $("#input-report-date-start").datepicker({
                    defaultDate: "+1w",
                    dateFormat: format,
                    changeMonth: true,
                    changeYear: true
                }).on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
            to = $("#input-report-date-end").datepicker({
                    defaultDate: "+1w",
                    dateFormat: format,
                    changeMonth: true,
                    changeYear: true
                }).on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
            });

            function getDate( element ) {
                var date;
                try {
                    date = $.datepicker.parseDate(format, element.value);
                } catch( error ) {
                    date = null;
                    console.error(error);
                }

                return date;
            }

            $('#btn-form-submit').on('click', function(event){
                event.preventDefault();
                var form = $('#form-report-filter')
                    .attr('action', "{{ route('client.report', ['company' => session()->get('slug_company')]) }}")
                    .attr('method', 'get');
                form.submit();
            });

            $('#btn-report-export').on('click', function(event){
                event.preventDefault();
                var form = $('#form-report-filter')
                    .attr('action', "{{ route('admin.report.export') }}")
                    .attr('method', 'get');
                form.submit();
            });

            $('#btn-report-export-pdf').on('click', function(event){
                event.preventDefault();
                var form = $('#form-report-filter')
                    .attr('action', "{{ route('admin.report_pdf.export') }}")
                    .attr('method', 'get');
                form.submit();
            });

         });
    </script>
    
    <script>
        
        var options_tendencia = {
            series: [
                @php $xcoma = '' @endphp
                @foreach($tendencias as $itm)
                    {{ $xcoma . $itm->total }}
                    @php $xcoma = ',' @endphp
                @endforeach
            ],
            labels: [
                @php $xcoma = '' @endphp
                @foreach($tendencias as $itm)
                    {{$xcoma}}"{{ ($itm->trend == 1 ? 'Positiva' : ($itm->trend == 2 ? 'Neutral' : 'Negativa')) }}"
                    @php $xcoma = ',' @endphp
                @endforeach
            ],
            chart: {
                width: 380,
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 270
                }
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
            },
            legend: {
                formatter: function(val, opts) {
                    const name = opts.w.globals.labels[opts.seriesIndex]
                    return name + " - " + opts.w.globals.series[opts.seriesIndex]
                }
            },
            title: {
                text: 'Tendencias'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart_tendencia = new ApexCharts(document.querySelector("#chart_tendencia"), options_tendencia);
        chart_tendencia.render();
    
        var options_medio = {
            series: [
                @php $xcoma = '' @endphp
                @foreach($medios as $itm)
                    {{ $xcoma . $itm->total }}
                    @php $xcoma = ',' @endphp
                @endforeach
            ],
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: [
                    @php $xcoma = '' @endphp
                    @foreach($medios as $itm)
                        {{$xcoma}}"{{ $itm->mean->name . ' - ' . $itm->total }}"
                        @php $xcoma = ',' @endphp
                    @endforeach
                ],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        
        var chart_medio = new ApexCharts(document.querySelector("#chart_medio"), options_medio);
        chart_medio.render();
      
        var options_hist = {
            series: [
                {!! $json !!}
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [5, 7, 5],
                curve: 'straight',
                dashArray: [0, 8, 5]
            },
            title: {
                text: 'Page Statistics',
                align: 'left'
            },
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
                }
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: [
                    @php $xxcoma = ''; @endphp
                    @foreach($fechas as $it)
                        {{ $xxcoma }}'{{ $it }}'
                        @php $xxcoma = ','; @endphp
                    @endforeach
                ],
            },
            tooltip: {
                y: [
                    {
                        title: {
                            formatter: function (val) {
                            return val + " (mins)"
                            }
                        }
                    },
                    {
                        title: {
                            formatter: function (val) {
                            return val + " per session"
                            }
                        }
                    },
                    {
                        title: {
                            formatter: function (val) {
                            return val;
                            }
                        }
                    }
                ]
            },
            grid: {
                borderColor: '#f1f1f1',
            }
        };
        
        var chart_hist = new ApexCharts(document.querySelector("#chart_hist"), options_hist);
        chart_hist.render();
    </script>

@endsection
