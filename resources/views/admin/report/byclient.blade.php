@extends('layouts.admin')
@section('admin-title', '- Reportes por cliente')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 people-list">
            <div class="people-options clearfix"> <!-- filter-options -->
                <div class="btn-toolbar">
                    <form id="form-report-filter" action="{{ route('admin.report.byclient') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="report-select-company" class="text-muted">Cliente</label>
                                <select name="company" class="form-control mt-2" id="report-select-company"
                                        style="width: 100%;">
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="text-muted">Sector</label>
                                <select class="form-control select-select2" style="width: 100%;" name="sector">
                                    <option value="">Sector</option>
                                    @foreach(App\Models\Sector::all() as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="text-muted">Genero</label>
                                <select class="form-control select-select2" style="width: 100%;" name="genre">
                                    <option value="">Genero</option>
                                    @foreach(App\Models\Genre::all() as $genre)
                                        <option value="{{ $genre->id }}"> {{ $genre->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-report-mean" class="text-muted">Medio</label>
                                <select class="form-control select-select2" style="width: 100%;" name="mean"
                                        id="select-report-mean">
                                    <option value="">Medio</option>
                                    @foreach(App\Models\Means::all() as $mean)
                                        <option value="{{ $mean->id }}">{{ $mean->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="div-select-report-sources">
                            </div>
                        </div>
                        <div class="row">
                            <div id="select-report-theme" class="form-group"></div>
                            <div class="col-md-2 form-group">
                                <label for="" class="text-muted">Fecha inicio</label>
                                <div class="input-group">
                                    <input type="text" name="start_date" id="input-report-date-start"
                                           class="form-control input-date-format">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="" class="text-muted">Fecha fin</label>
                                <div class="input-group">
                                    <input type="text" name="end_date" id="input-report-date-end"
                                           class="form-control input-date-format">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <button class="btn btn-primary" id="btn-report-search"> Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="btn-group pull-right ml-1">
                    <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-warning"
                       id="btn-report-export">Exportar</a>
                    <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-warning"
                       id="btn-report-export-pdf">Exportar PDF</a>

                </div>

                <span id="span-count-info" class="people-count pull-right">Mostrando <strong
                            id="num-rows-info">0 de 0</strong> noticias</span>
            </div><!-- filter-options -->
            <div id="div-table-notes"></div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#report-select-company').select2();
            $('.select-select2').select2();

            // Datepicker
            format = "yy-mm-dd",
                from = $("#input-report-date-start").datepicker({
                    defaultDate: "+1w",
                    dateFormat: format,
                    changeMonth: true,
                    changeYear: true
                }).on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#input-report-date-end").datepicker({
                    defaultDate: "+1w",
                    dateFormat: format,
                    changeMonth: true,
                    changeYear: true
                }).on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(format, element.value);
                } catch (error) {
                    date = null;
                    console.error(error);
                }

                return date;
            }


            // Filter report
            $('#btn-report-search').on('click', function (event) {
                event.preventDefault();
                var data = $('#form-report-filter').serialize();

                $.get('{{ route('admin.report.byclient') }}', data, function (res) {

                    var finalNum = res.firstitem + res.count - 1;

                    $('#div-table-notes').html(res.render);
                    $('#num-rows-info').text(`${res.firstitem}-${finalNum}`);
                });
            });

            // select news by company
            $('#report-select-company').on('change', function (event) {
                var optionSelected = event.target.value;
                $('#div-table-notes').html("");

                $.get('{{ route('admin.report.byclient') }}', {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'company': optionSelected
                }, function (res) {
                    var btnPaginates = $('ul.pagination');
                    var finalNum = res.firstitem + res.count - 1;

                    $('#div-table-notes').html(res.render);
                    $('#num-rows-info').text(`${res.firstitem}-${finalNum}`);

                    $.post('{{ route('api.getthemeshtml') }}', {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'company_id': optionSelected
                    }, function (res) {
                        var divSelectThemes = $('#select-report-theme');
                        divSelectThemes.addClass('col-md-2').html(res);
                        divSelectThemes.find('label.col-form-label').removeClass().addClass('text-muted');
                        var spanLabel = divSelectThemes.find('span.text-danger');
                        spanLabel.remove();
                        var selectTheme = divSelectThemes.find('#select-theme');
                        selectTheme.css("width", "100%");
                        selectTheme.select2();
                    })
                });
            });

            // select mean
            $('#select-report-mean').on('change', function (event) {
                getHTMLSources(event.target.value)
            })

            function getHTMLSources(noteType) {
                $.post('{{ route('api.getsourceshtml') }}', {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'mean_id': noteType
                }, function (res) {
                    var divSelectSources = $('#div-select-report-sources')
                        .addClass('col-md-2')
                        .html(res)
                    divSelectSources.find('label.col-form-label').removeClass();
                    divSelectSources.find('div.col-sm-10.col-md-11.col-lg-11').removeClass();
                    divSelectSources.find('#select-fuente').select2({
                        minimumInputLength: 3,
                        ajax: {
                            type: 'POST',
                            url: "{{ route('api.getsourceajax') }}",
                            dataType: 'json',
                            data: function (params, noteType) {
                                return {
                                    q: params.term,
                                    mean_id: $('select#select-report-mean').val(),
                                    "_token": $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            processResults: function (data) {
                                return {
                                    results: data.items
                                }
                            },
                            cache: true
                        }
                    })
                }).fail(function (res) {
                    var divSelectSources = $('#div-select-report-sources').html(`<p>No se pueden obtener las fuentes</p>`)
                    console.error(`Error-Sources: ${res.responseJSON.message}`)
                })
            }

            // pagination
            $(document).on('click', '.pagination a', function (e) {
                getPosts($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });

            function getPosts(page) {
                var company = $('#report-select-company').val();

                $.ajax({
                    type: 'GET',
                    url: `/panel/reportes/por-cliente?page=${page}`,
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        'company': company
                    },
                }).done(function (data) {

                    var finalNum = data.firstitem + data.count - 1;

                    $('#div-table-notes').html(data.render);
                    $('#num-rows-info').text(`${data.firstitem}-${finalNum}`);
                    location.hash = page;
                }).fail(function () {
                    alert('Posts could not be loaded.');
                });
            }

            // Export button
            $('#btn-report-export').on('click', function (event) {
                event.preventDefault();
                var form = $('#form-report-filter')
                    .attr('action', "{{ route('admin.report.export') }}")
                    .attr('method', 'get');
                form.submit();
            });

            $('#btn-report-export-pdf').on('click', function (event) {
                event.preventDefault();
                var form = $('#form-report-filter')
                    .attr('action', "{{ route('admin.report_pdf.export') }}")
                    .attr('method', 'get');
                form.submit();
            });
        });

    </script>
@endsection
