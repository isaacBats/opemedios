@extends('layouts.newsletter')
@section('content')
    <div class="uk-container op-content-mt">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal uk-grid-divider" uk-grid>
            <div class="uk-width-1-3@s">
                <div>
                    <p class="uk-badge uk-padding-small uk-padding-remove-vertical">{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</p>
                    <img class="thumbnail new" src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                    <hr class="uk-visible@s">
                    <div class="uk-visible@s">
                        <dl class="uk-text-small uk-text-break uk-description-list">
                    @foreach($note->metas() as $meta)
                        @if($meta['label'] == 'Comentarios' || $meta['label'] == 'Creador' || $meta['label'] == 'Encabezado' || $meta['label'] == 'Síntesis' || $meta['label'] == 'Fecha')
                            @continue
                        @endif
                            <dt><b class="uk-text-emphasis">{{ $meta['label'] }}:</b></dt>
                            <dd>{!! $meta['value'] !!}</dd>
                    @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        <!-- NOTICIA HEADER -->
            <div class="uk-width-2-3@s">
                <h1 class="new">{{ $note->title }}</h1>
                <p class="uk-padding uk-padding-remove-horizontal">{!! $note->synthesis !!}</p>

                <div class="col-lg-3 text-right">
                    {{-- Compartir con redes sociales --}}
                </div>
                <div id="doc">
                 
                 <!-- Portfolio Item Row -->            

                {{-- Archivos adjuntos --}}
                @if($mainFile = $note->files->where('main_file', 1)->first())                   
                   @php
                    if( !preg_match('(.mp3|.ogg|.wav|.mpga|.mp4)', $mainFile->original_name ) ) {
                        if( preg_match('(.pdf)', $mainFile->original_name ) ) {
                            echo '<div id="lightbox" class="uk-box-shadow-medium uk-text-center lightbox pdf" uk-lightbox>
                                <a href="'.$mainFile->path_filename.'" data-type="iframe" class="link-source">'.$mainFile->getHTML().'<span class="icon-maximize uk-box-shadow-medium"></span></a>
                            </div>
                            <h3 class="uk-hidden no-pdf-inline uk-text-center uk-text-warning">PDF</h3>
                            ';
                        }
                        else{
                            echo '<div id="lightbox" class="uk-box-shadow-small uk-text-center lightbox" uk-lightbox>
                                '.$mainFile->getHTML().'
                            <span class="icon-maximize uk-box-shadow-medium"></span></div>';
                        }
                    } 
                    elseif( preg_match('(.mp4|.mov|.avi)', $mainFile->original_name ) ) {
                        echo '<div id="lightbox" class="uk-box-shadow-small uk-text-center lightbox video" uk-lightbox>
                            <a href="'.$mainFile->path_filename.'" data-type="iframe" class="link-source">'.$mainFile->getHTML().'<span class="icon-maximize uk-box-shadow-medium"></span></a>
                        </div>';
                    }
                    else{
                        echo '<div class="embed-responsive embed-responsive-16by9 uk-text-center">
                           '.$mainFile->getHTML().'
                        </div>';
                    }
                    @endphp
                    <p class="uk-text-center uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom">
                       {{ __('Descargar Archivo: ') }} <a href="{{ $mainFile->path_filename }}" target="_blank" class="uk-button uk-button-default uk-button-large uk-text-truncate uk-box-shadow-medium"><i class="icon-download"></i> {{ $mainFile->original_name }}</a>
                   </p>
               @else
                   <p class="text-center">{{ __('Esta noticia no contiene archivos ajuntos') }}</p>
               @endif
                </div>

                <div class="uk-hidden@s uk-padding-large uk-padding-remove-horizontal">
                    <div class="uk-text-small uk-text-break uk-description-list" uk-grid>
                @foreach($note->metas() as $meta)
                    @if($meta['label'] == 'Comentarios' || $meta['label'] == 'Creador' || $meta['label'] == 'Encabezado' || $meta['label'] == 'Síntesis' || $meta['label'] == 'Fecha')
                        @continue
                    @endif
                        @if($meta['label'] == 'URL')
                        <p class="uk-width-1-1">
                        @else
                        <p class="uk-width-1-2">
                        @endif
                            <span class="{{ $meta['label'] }}-meta"><b class="uk-text-emphasis">{{ $meta['label'] }}: </b></span>
                            <span class="{{ $meta['label'] }}-value">{!! $meta['value'] !!}</span>
                        </p>
                @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection