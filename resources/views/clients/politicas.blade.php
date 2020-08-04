@extends('layouts.home2')
@section('title', " - {$title}")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="container op-content-mt">
        <h1 class="page-header">{{ $title }}</h1>
        <div class="row">
            @foreach ($covers as $cover)
                <div class="col-sm-2 col-xs-6" style="margin-bottom: 10px;">
                    <a href="http://sistema.opemedios.com.mx/data/primera_plana/{{ $cover->imagen_jpg }}" data-fancybox="roadtrip">
                        <img class="img-responsive portfolio-item" src="http://sistema.opemedios.com.mx/data/thumbs/{{ $cover->imagen_jpg }}_pp.jpg" alt="{{ $cover->imagen_jpg }}" style="max-height: 350px;">
                        <figcaption class="items-descripcion">
                            <strong>{{ $cover->nombre }}</strong>
                            <p>{{ $cover->fecha }}</p>
                        </figcaption>
                    </a>
                </div>                
            @endforeach
        </div>
    </div>
    <!-- /.container -->
@endsection