@extends('layouts.newsletter')
@section('content')

    <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">{{ $new->encabezado }}</h1>
          <p class="lead text-muted">{{ $new->sintesis }}</p>
        </div>
      </section>

    <!--Page Content -->
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
               <img class="media thumbnail new" style="max-width: 220px;" src="http://sistema.opemedios.com.mx/data/fuentes/{{ $new->fuente_logo }}" alt="{{ $new->fuente_nombre}}">
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                <small>{{ Illuminate\Support\Carbon::parse($new->fecha)->formatLocalized('%A %d de %B %Y') }}</small>
            </div>
            <div class="col-lg-12">
                <small style="font-size: 12px">SECCION: {{ $new->seccion }}</small>
            </div>
        </div>
        <!-- NOTICIA HEADER -->
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @foreach($metadata as $label => $meta)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-4">
                            <p><span class="text-danger">{{ $label }}: </span> {!! $meta !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
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