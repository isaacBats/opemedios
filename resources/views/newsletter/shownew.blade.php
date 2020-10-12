@extends('layouts.newsletter')
@section('content')

    <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">{{ $note->title }}</h1>
          <p class="lead text-muted">{!! $note->synthesis !!}</p>
        </div>
      </section>

    <!--Page Content -->
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
               <img class="media thumbnail new" width="300" height="150" src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                <small>{{ Illuminate\Support\Carbon::parse($note->news_date)->formatLocalized('%A %d de %B %Y') }}</small>
            </div>
            <div class="col-lg-12">
                <small style="font-size: 12px">SECCION: {{ $note->section->name }}</small>
            </div>
        </div>
        <!-- NOTICIA HEADER -->
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @foreach($note->metas() as $meta)
                        @if($meta['label'] == 'Comentarios' || $meta['label'] == 'Creador' || $meta['label'] == 'Encabezado' || $meta['label'] == 'Síntesis' || $meta['label'] == 'Fecha')
                            @continue
                        @endif
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-4">
                            <p><span class="text-danger">{{ $meta['label'] }}: </span> {!! $meta['value'] !!}</p>
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
                @if($mainFile = $note->files->where('main_file', 1)->first())
                    <div class="embed-responsive embed-responsive-16by9">
                        {!! $mainFile->getHTML() !!}
                    </div>
                     <p>
                        {{ __('Descargar Archivo: ') }} <a href="{{ $mainFile->path_filename }}" target="_blank">{{ $mainFile->original_name }}</a>
                    </p>
                @else
                    <p class="text-center">{{ __('Esta noticia no contiene archivos ajuntos') }}</p>
                @endif
            </div>
        </div>
        <hr>
    </div>
    <!-- /.container -->
@endsection