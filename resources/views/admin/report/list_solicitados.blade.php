@extends('layouts.admin')
@section('admin-title', '- Reportes por cliente')
@section('styles')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
@endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 people-list">
            <div id="div-table-notes">
                <table class="table table-bordered table-primary table-striped nomargin">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiempo</th>
                        <th>Archivo</th>
                        <th>Estatus</th>
                        <th>Cliente</th>
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
                            <td>{{ App\Models\Company::find($item->company)->name ?? 'N/E' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->status > 0)
                                <a style="color: #000000;" class="download_file" data-id="{{ $item->id }}" href="#"
                                   data-url="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->name_file) }}">Descargar</a>
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
        $(".download_file").on("click", function (e) {
            e.preventDefault();
            url = $(this).data('url');
            id = $(this).data('id');

            $("#frame").attr("src", url);

            $.ajax({
                url: '{{ route('admin.report.cambia_estatus_reporte') }}',
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                }
            })
        });
    </script>
@endsection
