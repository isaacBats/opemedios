@extends('layouts.home')
@section('title', " - Noticia")
@section('content')
    {{--@include('components.clientHeading')--}}
    <!--Page Content -->
    <div class="uk-container op-content-mt">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal uk-grid-divider" uk-grid>
            <div class="uk-width-1-3@s">
                <div>
                    <p class="uk-badge uk-padding-small uk-padding-remove-vertical">{{ Illuminate\Support\Carbon::parse($new->fecha)->formatLocalized('%A %d de %B %Y') }}</p>
                    {{-- 
                    Para que las fechas salgan en español y conacentos se debe instalar el paquete de idiomas es_MX y es_MX.UTF8
                    con el siguiente comando
                    sudo locale-gen es_MX.UTF8
                    sudo dpkg-reconfigure locales
                    y configurar en el service provider AppServiceProvider
                    Illuminate\Support\Carbon::parse($new->fecha)->diffForHumans()
                    Illuminate\Support\Carbon::parse($new->fecha)->formatLocalized('%A %d %B %Y')
                --}}
                    <img class="thumbnail new" src="http://sistema.opemedios.com.mx/data/fuentes/{{ $new->fuente_logo }}" alt="{{ $new->fuente_nombre}}">
                    <hr class="uk-visible@s">
                    <div class="uk-visible@s">
                        <dl class="uk-text-small uk-text-break uk-description-list">
                     @foreach($metadata as $label => $meta)
                            <dt><b class="uk-text-emphasis">{{ $label }}:</b></dt>
                            <dd>{!! $meta !!}</dd>
                    @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        <!-- NOTICIA HEADER -->
            <div class="uk-width-2-3@s">
                <h1 class="new">{{ $new->encabezado }}</h1>
                <p class="uk-padding uk-padding-remove-horizontal">{{ $new->sintesis }}</p>

                <div class="uk-hidden@s uk-padding uk-padding uk-padding-remove-horizontal uk-padding-remove-top">
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
                <div class="col-lg-3 text-right">
                    {{-- Compartir con redes sociales --}}
                </div>
                <div id="doc">
                 
                 <!-- Portfolio Item Row -->            

                {{-- Archivos adjuntos --}}
                @foreach($adjuntosHTML as $html)
                    {!! $html !!}
                @endforeach

                </div>

            </div>
        </div>
    </div>


    <!-- /.container -->
@endsection