@extends('layouts.home')
@section('title', " - Noticia")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-container op-content-mt">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal uk-grid-divider" uk-grid>
            <div class="uk-width-1-3@s">
                <div uk-sticky="offset: 140; media: @s; ">
                    <img class="thumbnail new" src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                    <p class="uk-text-bold">{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</p>
                    <span class="uk-badge uk-padding-small"> {{ $note->source->name }} </span>
                    <span class="uk-badge uk-padding-small"> Sección: {{ $note->section->name }} </span>
                </div>
            </div>
        <!-- NOTICIA HEADER -->
            <div class="uk-width-2-3@s">
                <div class="col-lg-12">
                    <h1 class="new">{{ $note->title }}</h1>
                </div>

                <div class="uk-padding uk-padding-remove-horizontal">
                    {!! $note->synthesis !!}
                </div>

                <div class="col-lg-9" uk-grid>
                    @foreach($note->metas() as $meta)
                        @if($meta['label'] == 'Comentarios' || $meta['label'] == 'Creador' || $meta['label'] == 'Encabezado' || $meta['label'] == 'Síntesis' || $meta['label'] == 'Fecha')
                            @continue
                        @endif
                        <dl class="col-lg-3 uk-width-1-2@s">
                            <dt>{{ $meta['label'] }}:</dt>
                            <dd>{!! $meta['value'] !!}</dd>
                        </dl>
                    @endforeach
                </div>
                <div class="col-lg-3 text-right">
                    {{-- Compartir con redes sociales --}}
                </div>
                <div class="uk-padding uk-padding-large uk-padding-remove-horizontal">
                 
                 <!-- Portfolio Item Row -->            

                {{-- Archivos adjuntos --}}
                @if($mainFile = $note->files->where('main_file', 1)->first())                   
                   @php
                    if( !preg_match('(.mp3|.ogg|.wav|.mpga)', $mainFile->original_name ) ) {
                        if( preg_match('(.pdf)', $mainFile->original_name ) ) {
                            echo '<div class="uk-box-shadow-small uk-text-center lightbox" uk-lightbox>
                                <a href="'.$mainFile->path_filename.'" data-type="iframe" class="link-source">'.$mainFile->getHTML().'</a>
                            </div>';
                        }
                        else{
                            echo '<div class="uk-box-shadow-small uk-text-center lightbox" uk-lightbox>
                                '.$mainFile->getHTML().'
                            </div>';
                        }
                    } 
                    else{
                        echo '<div class="embed-responsive embed-responsive-16by9 uk-text-center">
                           '.$mainFile->getHTML().'
                        </div>';
                    }
                    @endphp
                   <hr>
                    <p class="uk-text-center">
                       {{ __('Descargar Archivo: ') }} <a href="{{ $mainFile->path_filename }}" target="_blank" class="uk-button uk-button-default uk-button-large">{{ $mainFile->original_name }}</a>
                   </p>
               @else
                   <p class="text-center">{{ __('Esta noticia no contiene archivos ajuntos') }}</p>
               @endif
                </div>

            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection