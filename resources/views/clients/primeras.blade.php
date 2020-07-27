@extends('layouts.home2')
@section('title', " - {$title}")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <h1 class="page-header">{{ $title }}</h1>
        <div class="row">
            @forelse ($covers as $cover)
                <div class="col-sm-2 col-xs-6" style="margin-bottom: 10px;">
                    <a href="{{ $cover->image->path_filename }}" data-fancybox="roadtrip">
                        <img class="img-responsive portfolio-item" src="{{ $cover->image->path_filename }}" alt="{{ $cover->image->original_name }}" height="120">
                        <figcaption class="items-descripcion">
                            <strong>{{ $cover->source->name }}</strong>
                            <p>{{ $cover->date_cover->diffForHumans() }}</p>
                        </figcaption>
                    </a>
                </div>
            @empty
                <p>{{ __('No hay archivos aun...') }}</p>               
            @endforelse
        </div>
    </div>
    <!-- /.container -->
@endsection