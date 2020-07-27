@extends('layouts.home2')
@section('title', " - Noticia")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <div class="row padding-top-40">
            <div class="col-lg-12">
               <img class="thumbnail new" style="max-width: 220px;" src="http://sistema.opemedios.com.mx/data/fuentes/{{ $new->fuente_logo }}" alt="{{ $new->fuente_nombre}}">
                <small style="position: absolute; right: 0px; top: 0px">{{ Illuminate\Support\Carbon::parse($new->fecha)->formatLocalized('%A %d de %B %Y') }}</small>
                {{-- 
                    Para que las fechas salgan en español y conacentos se debe instalar el paquete de idiomas es_MX y es_MX.UTF8
                    con el siguiente comando
                    sudo locale-gen es_MX.UTF8
                    sudo dpkg-reconfigure locales
                    y configurar en el service provider AppServiceProvider
                    Illuminate\Support\Carbon::parse($new->fecha)->diffForHumans()
                    Illuminate\Support\Carbon::parse($new->fecha)->formatLocalized('%A %d %B %Y')
                --}}
            </div>
        </div>
        <!-- NOTICIA HEADER -->
        <div class="row spacer-20">
            <div class="col-lg-12">
                <h1 class="new">{{ $new->encabezado }}</h1>
                <small style="font-size: 12px">SECCION: {{ $new->seccion }}</small>
            </div>
        </div>

        <div class="row spacer-20">
            <div class="col-lg-12">
                {{ $new->sintesis }}
            </div>
        </div>
        <div class="row spacer-20">
            <div class="col-lg-9">
                @foreach($metadata as $label => $meta)
                    <div class="col-lg-3">
                        <p><span class="label-red">{{ $label }}: </span> {!! $meta !!}</p>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-3 text-right">
                {{-- Compartir con redes sociales --}}
            </div>
        </div>

        <!-- Portfolio Item Row -->
        <div class="row">
            <div class="col-md-12">
                {{-- Archivos adjuntos --}}
                <hr>
                @foreach($adjuntosHTML as $html)
                    {!! $html !!}
                @endforeach
            </div>
        </div>
        <hr>
    </div>
    <!-- /.container -->
@endsection