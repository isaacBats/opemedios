@extends('layouts.home')
@section('title', " - Reporte")
@section('content')
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12 people-list">
            <div class="people-options clearfix"> <!-- filter-options -->
                <div class="btn-toolbar">
                    {{-- <form id="form-report-filter" action="{{ route('admin.report.byclient') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="report-select-company" class="text-muted">Cliente</label>
                                <select name="company" class="form-control mt-2" id="report-select-company" style="width: 100%;">
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="text-muted">Sector</label>
                                <select class="form-control select-select2" style="width: 100%;" name="sector" >
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
                                <select class="form-control select-select2" style="width: 100%;" name="mean" id="select-report-mean">
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
                                    <input type="text" name="start_date" id="input-report-date-start" class="form-control input-date-format">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="" class="text-muted">Fecha fin</label>
                                <div class="input-group">
                                    <input type="text" name="end_date" id="input-report-date-end" class="form-control input-date-format">
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
                    </form> --}}
                </div>
                {{-- <div class="btn-group pull-right ml-1">
                    <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-warning" id="btn-report-export">Exportar</a>
                    <a href="javascript:void(0)" style="margin-left: 25px;" class="btn btn-warning" id="btn-report-export-pdf">Exportar PDF</a>
                </div> --}}

                {{-- <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">0 de 0</strong> noticias</span> --}}
            </div><!-- filter-options -->
            <div id="div-table-notes">

                <table class="uk-table uk-table-striped uk-table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiempo Aprox</th>
                            <th>Archivo</th>
                            <th>Estatus</th>
                            <th>Fechas</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $item)
                            <tr style="background: {{ $item->status == 0 ? '#ffd079' : ($item->status == 1 ? '#6d9af9' : '#259dab') }};">
                                <td>{{ $item->id }}</td>
                                <td>@if($item->status == 0) Tiempo aprox. {{ $item->size == 'small' ? (\App\Models\ListReport::where('size', 'small')->where('status', 0)->count() * 5) : ($item->size == 'medium' ? (\App\Models\ListReport::where('size', 'medium')->where('status', 0)->count() * 30) : (\App\Models\ListReport::where('size', 'big')->where('status', 0)->count() * 60)) }} mins @endif</td>
                                <td>{{ $item->name_file ?? 'N/E' }}</td>
                                <td>@if($item->status > 0) {{ $item->status == 1 ? 'Generado' : ($item->status == 3 ? 'Procesando' : 'Descargado') }} @endif</td>
                                <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($item->status == 1)
                                    <a style="color: #000000;" class="download_file" href="#" data-url="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->name_file) }}">Descargar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <iframe id="frame" src="" width="100%" height="300" style="display: none;"></iframe>
@endsection
@section('styles')

@endsection
@section('scripts')
    <script>
        $(".download_file").on("click", function(e){
            e.preventDefault();
            url = $(this).data('url');
            id = $(this).data('id');

            $("#frame").attr("src", url);

            $.ajax({
                url: {{ route('client.report.cambia_estatus_reporte', ['company' => session()->get('slug_company')]) }},
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                }
            })
        });
    </script>
@endsection
