@extends('layouts.home')
@section('title', " - Noticia")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="container op-content-mt">
        <div class="row padding-top-40">
            <div class="col-lg-12">
               <img class="thumbnail new" style="max-width: 220px;" src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                <small style="position: absolute; right: 0px; top: 0px">{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</small>
            </div>
        </div>
        <!-- NOTICIA HEADER -->
        <div class="row spacer-20">
            <div class="col-lg-12">
                <h1 class="new">{{ $note->title }}</h1>
                <small style="font-size: 12px">SECCION: {{ $note->section->name }}</small>
            </div>
        </div>

        <div class="row spacer-20">
            <div class="col-lg-12">
                {!! $note->synthesis !!}
            </div>
        </div>
        <div class="row spacer-20">
            <div class="col-lg-9">
                @foreach($note->metas() as $meta)
                    @if($meta['label'] == 'Comentarios' || $meta['label'] == 'Creador' || $meta['label'] == 'Encabezado' || $meta['label'] == 'Síntesis' || $meta['label'] == 'Fecha')
                        @continue
                    @endif
                    <div class="col-lg-3">
                        <p><span class="label-red">{{ $meta['label'] }}: </span> {!! $meta['value'] !!}</p>
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