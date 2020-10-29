@extends('layouts.home')
@section('title', " - {$title}")
@section('content')
    {{--@include('components.clientHeading')--}}
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content op-content-mt ">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal">
            <h1 class="page-header">{{ $title }}</h1>
            <br>
            <div uk-grid="masonry: true" uk-lightbox="animation: fade;">
            @forelse ($covers as $cover)
                <a class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-3@l uk-width-1-4@xl card-primeras" href="{{ $cover->image->path_filename }}">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top uk-cover-container cover-top">
                            <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}" uk-cover>
                            <canvas width="700" height="450"></canvas>
                        </div>
                        <div class="uk-card-body">
                            <h4 class="f-h4 text-muted">
                                {{ $cover->source->name }} &mdash; <small>{{ $cover->date_cover->diffForHumans() }}</small>
                            </h4>
                        </div>
                    </div>
                </a>
            @empty
            <p>{{ __('No hay archivos aun...') }}</p>     
            @endforelse
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection