@extends('layouts.home')
@section('title', " - Columnas Financieras")
@section('content')
    {{--@include('components.clientHeading')--}}
    <!--Page Content -->
    <div class="uk-container op-content-mt">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal">
            <h1 class="page-header">Columnas Financieras</h1>
            <br>
            <div uk-grid="masonry: true" uk-lightbox="animation: fade;">
            @foreach ($covers as $cover)
                 <a class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-3@xl" href="http://sistema.opemedios.com.mx/data/primera_plana/{{ $cover->imagen_jpg }}">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top uk-cover-container cover-top">
                            <img src="http://sistema.opemedios.com.mx/data/thumbs/{{ $cover->imagen_jpg }}_pp.jpg" alt="{{ $cover->imagen_jpg }}" uk-cover>
                            <canvas width="700" height="450"></canvas>
                        </div>
                        <div class="uk-card-body">
                            <h4 class="f-h4 text-muted">
                            {{ $cover->fecha }} | {{ $cover->nombre }}</h4>
                        </div>
                    </div>
                </a>                
            @endforeach
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection