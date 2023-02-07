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
                            <th>Archivo</th>
                            <th>Cliente</th>
                            <th>Fechas</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name_file ?? 'N/E' }}</td>
                                <td>{{ App\Company::find($item->company)->name ?? 'N/E' }}</td>
                                <td>{{ $item->start_date . ' - ' . $item->end_date }}</td>
                                <td>
                                    <a class="download_file" href="#" data-url="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->name_file) }}">Descargar</a>
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
            
            $("#frame").attr("src", url);
        });
    </script>
@endsection
