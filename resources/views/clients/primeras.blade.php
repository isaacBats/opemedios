@extends('layouts.home')
@section('title', " - {$title}")
@section('content')
    {{--@include('components.clientHeading')--}}
    <!--Page Content -->
    {{-- types: primeras, politicas, financieras, portadas, cartones --}}
    <div class="uk-padding op-content-mt main-content op-content-mt {{request('type')}}" style="background: #f9f9f9;">
        <div class="uk-padding uk-padding-remove-bottom" style="background: #fff;">
            <h1 class="page-header">{{ $title }} <small>({{ count($covers) }})</small></h1>
            <br>
            @if (request('type')=="cartones")
            <div uk-grid="masonry: true" uk-lightbox="animation: fade;">
            @elseif ( ( request('type')=="primeras" || request('type')=="portadas" ) && count($covers) > 0 )
            <div id="slider" class="uk-position-relative" tabindex="-1" style="height: calc(100vh - 180px);">
                <ul class="uk-slider-items" uk-grid style="height: calc(100vh - 300px); padding: 15px 0 0 0;" uk-lightbox="animation: fade;">
            @else
            <div uk-grid="masonry: true" class="uk-padding uk-padding-remove-horizontal uk-padding uk-padding-remove-top">
            @endif

            @forelse ($covers as $cover)
                @if (request('type')=="cartones")
                <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m uk-width-1-3@l uk-width-1-4@xl carton">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top uk-cover-container">
                            <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}">
                        </div>
                        <div class="uk-card-body uk-text-center">
                            <a href="{{ $cover->image->path_filename }}">
                                <h4 class="f-h4 text-muted">
                                    {{ $cover->source->name }}
                                </h4>
                                <p><small>{{ $cover->date_cover->diffForHumans() }}</small></p>
                                @if( request('type') == 'financieras' || request('type') == 'politicas' )
                                <p>
                                    Autor: {{ $cover->author }}
                                </p>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                
                @elseif (request('type')=="primeras" || request('type')=="portadas")
                <li class="primera portada" style="height: 100%;">
                    <a class="uk-panel uk-box-shadow-large" href="{{ $cover->image->path_filename }}" style="height: 100%;">
                        <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}" style="height: calc(100vh - 370px); width: auto;">
                        <div class="uk-text-center">
                            <h4 class="f-h4 text-muted">
                                {{ $cover->source->name }}
                            </h4>
                            <p><small>{{ $cover->date_cover->diffForHumans() }}</small></p>
                        </div>
                    </a>
                </li>
                
                @else
                <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-3@l uk-width-1-4@xl">
                    <div class="uk-card uk-card-default card-columna">
                        <a href="#" uk-toggle="target:#texto{{spl_object_id($cover)}}">
                            <div class="uk-card-media-top uk-cover-container cover-top">
                                <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}" uk-cover>
                                <canvas width="700" height="450"></canvas>
                            </div>
                            <div class="uk-card-body">
                                <h4 class="f-h4 text-muted">
                                    {{ $cover->source->name }} &mdash; <small>{{ $cover->date_cover->diffForHumans() }}</small>
                                </h4>
                                <h3 style="margin: 0;">{{$cover->title}}</h3>
                                <p style="margin: 0;">Autor: {{ $cover->author }}</p>
                                @if( $cover->content && trim($cover->content) != "")
                                @endif
                            </div>
                        </a>
                        @if( $cover->content && trim($cover->content) != "")
                        <div uk-modal class="uk-flex-top uk-modal-container" id="texto{{spl_object_id($cover)}}">
                            <div class="uk-overflow-auto uk-modal-dialog uk-margin-auto-vertical uk-modal-body" uk-lightbox="animation: fade;">
                                <div>
                                    <a href="{{ $cover->image->path_filename }}" style="max-width: 300px;">
                                        <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}" style="max-height: 600px;">
                                        <button class="uk-button" href="{{ $cover->image->path_filename }}">Ver imagen</button>
                                    </a>
                                </div>
                                <div>
                                    <h2>{{$cover->title}}</h2>
                                    <p style="margin-top: 0;">Autor: {{ $cover->author }}</p>
                                    {!! $cover->content !!}
                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            
            @empty
            <p class="uk-padding">{{ __('No hay archivos aun...') }}</p>     
            @endforelse
            @if ( (request('type')=="primeras" || request('type')=="portadas") && count($covers) > 0 )
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-flex uk-flex-middle" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-flex uk-flex-middle" href="#" uk-slidenav-next uk-slider-item="next"></a>
            <ul class="uk-slider-nav uk-flex-center uk-margin"></ul>
            @endif
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection