@extends('layouts.home')
@section('title', " - Reporte")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
        <div class="uk-padding reporte-container" style="background: #fff;">
            <h1 class="page-header">Reporte <span class="tema-actual"></span></h1>
            <br>
            <div class="">
                <form action="{{ route('client.report', ['company' => session()->get('slug_company')]) }}" method="GET" id="form-report-filter">
                    <input type="hidden" name="company" value="{{ Auth::user()->company()->id }}">
                    <div class="uk-child-width-1-1 uk-child-width-1-4@s uk-child-width-1-4@m" uk-grid>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Fecha inicio</label>
                            <input id="input-report-date-start" class="form-control uk-input" type="text" name="fstart" value="{{ request('fstart') }}">
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Fecha fin</label>
                            <input id="input-report-date-end" class="form-control uk-input" type="text" name="fend" value="{{ request('fend') }}">
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Tema</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="theme_id" id="">
                                <option value="">** Todos **</option>
                                @foreach(App\Company::where('slug', session()->get('slug_company'))->first()->themes as $theme)
                                    <option value="{{ $theme->id }}" {{ (request('theme_id') == $theme->id ? 'selected' : '' ) }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Sector</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="sector" id="">
                                <option value="">** Todos **</option>
                                @foreach(App\Sector::all() as $sector)
                                    <option value="{{ $sector->id }}" {{ (request('sector') == $sector->id ? 'selected' : '' ) }} >{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">G&eacute;nero</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="genre" id="">
                                <option value="">** Todos **</option>
                                @foreach(App\Genre::all() as $genre)
                                    <option value="{{ $genre->id }}" {{ (request('genre') == $genre->id ? 'selected' : '' ) }} >{{ $genre->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="">Medio</label>
                            <select style="width: 100%;" class="form-control uk-select select2" name="mean" id="select-report-mean">
                                <option value="">** Todos **</option>
                                @foreach(App\Means::all() as $mean)
                                    <option value="{{ $mean->id }}" {{ (request('mean') == $mean->id ? 'selected' : '' ) }}>{{ $mean->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin" id="div-select-report-sources"></div>
                    </div>
                    <div class="uk-margin">
                        <input id="btn-form-submit" class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Generar">
                        <a href="javascript:void(0)" style="margin-right: 25px;" class="btn btn-action uk-button uk-button-large uk-button-primary uk-box-shadow-medium" id="btn-report-export">Exportar</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Nota</th>
                        <th>Título</th>
                        <th>Tema</th>
                        <th>Sector</th>
                        <th>Género</th>
                        <th>Fuente</th>
                        <th>Medio</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                        <tr>
                            <td>{{ ($notes->currentPage() - 1) * $notes->perPage() + $loop->iteration }}</td>
                            <td>{{ "OPE-{$note->id}" }}</td>
                            <td>{{ $note->title }}</td>
                            <td>{{ $note->assignedNews->where('company_id', $company->id)->where('news_id', $note->id)->first()->theme->name }}</td>
                            <td>{{ $note->sector->name }}</td>
                            <td>{{ $note->genre->description }}</td>
                            <td>{{ $note->source->name }}</td>
                            <td>{{ $note->mean->name }}</td>
                            <td>{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

         });
    </script>
@endsection