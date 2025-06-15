@extends('layouts.admin_guest')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-12 text-right">
                        {{ $newspapers->links() }}
                    </div>
                    <table class="table table-bordered table-inverse table-striped nomargin">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">{{ __('Periodico') }}</th>
                            <th class="text-center">{{ __('Fecha') }}</th>
                            <th class="text-center">{{ __('Archivo') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newspapers as $key => $item)
                            @if(Illuminate\Support\Facades\Storage::drive('s3')->exists('staging/' . $item->file))
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td class="text-center">
                                    {{$item->newspaper}}
                                </td>
                                <td class="text-center">
                                    @php 
                                        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                        $fecha = \Carbon\Carbon::parse($item->date);
                                        $mes = $meses[($fecha->format('n')) - 1];
                                        $dtn = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');    
                                    @endphp
                                    {{$dtn}}
                                </td>
                                <td>
                                    <a style="color: #000000;" target="_blank" href="{{ \Illuminate\Support\Facades\Storage::drive('s3')->url('staging/' . $item->file) }}">Descargar</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    {{ $newspapers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
