@extends('layouts.home2')
@section('title', " - Primeras Planas")
@section('content')
    {{-- <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"></h1>
            </div>
        </div> --}}
    <!--Page Content -->
    <div class="container op-content-mt">
        <h1 class="page-header">Primeras Planas</h1>
        <div class="row">
            @foreach ($covers as $cover)
                <div class="col-sm-2 col-xs-6" style="margin-bottom: 10px;">
                    <a href="http://sistema.opemedios.com.mx/data/primera_plana/{{ $cover->imagen }}" data-fancybox="roadtrip">
                        <img class="img-responsive portfolio-item" src="http://sistema.opemedios.com.mx/data/thumbs/{{ $cover->imagen }}_pp.jpg" alt="{{ $cover->imagen }}" style="max-height: 350px;">
                        {{-- URL base 
                            http://sistema.opemedios.com.mx/data/thumbs/ID1704873056_24.jpg_pp.jpg 
                            para mostrar la imagen original
                            <img class="img-responsive portfolio-item" src="http://sistema.opemedios.com.mx/data/primera_plana/{{ $cover->imagen }}" alt="{{ $cover->imagen }}" style="max-height: 350px;"> --}}
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