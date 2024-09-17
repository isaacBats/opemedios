@extends('layouts.admin')
@section('admin-title', '- Reporte de Notas')
@section('content')
    <div class="row">
        <div class="col-sm-12 people-list">
            <div class="people-options clearfix"> <!-- filter-options -->
                <div class="btn-toolbar">
                    <form id="form-report-filter" action="{{ route('admin.report.bynotes') }}" method="GET">
                        <div class="col-md-2 form-group">
                            <label for="" class="text-muted">Fecha inicio</label>
                            <div class="input-group">
                                <input type="text" name="start" id="input-report-date-start" class="form-control input-date-format" value="{{ old('start') }}">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="" class="text-muted">Fecha fin</label>
                            <div class="input-group">
                                <input type="text" name="end" id="input-report-date-end" class="form-control input-date-format" value="{{ old('end') }}">
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
                {{-- <div class="btn-group pull-right ml-1">
                    <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-warning" id="btn-report-export">Exportar</a>
                </div> --}}

               {{-- <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">0 de 0</strong> noticias</span> --}}
            </div><!-- filter-options -->
            <div id="div-table-notes">
                <table class="table table-bordered table-primary table-striped nomargin">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td>
                                    <form method="GET" action="{{ route('admin.report.byuser', ['user' => $note->id]) }}">
                                        <input type="hidden" name="start" value="{{ $start }}">
                                        <input type="hidden" name="end" value="{{ $end }}">
                                        <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $loop->iteration }}</a>
                                    </form>
                                </td>
                                <td>
                                    <form method="GET" action="{{ route('admin.report.byuser', ['user' => $note->id]) }}">
                                        <input type="hidden" name="start" value="{{ $start }}">
                                        <input type="hidden" name="end" value="{{ $end }}">
                                        <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $note->name }}</a>
                                    </form>
                                </td>
                                <td>
                                    <form method="GET" action="{{ route('admin.report.byuser', ['user' => $note->id]) }}">
                                        <input type="hidden" name="start" value="{{ $start }}">
                                        <input type="hidden" name="end" value="{{ $end }}">
                                        <a href="javascript:void(0)" onclick="this.parentNode.submit();">{{ $note->count }}</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // Datepicker
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
        });

    </script>
@endsection
