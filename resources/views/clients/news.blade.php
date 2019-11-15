@extends('layouts.home2')
@section('title', " - {$company->name}")
@section('content')
    <!-- Page Content -->
        <div class="container op-content">

            <!-- Page Heading -->
            <div class="row card-company">
                <div class="col-sm-3">
                    <img src="{{ $company->logo }}" alt="{{ $company->name }}">
                </div>
                <div class="col-sm-8 page-header card-company-name">
                    <h1>{{ $company->name }}</h1>
                    <small class="card-filters">
                          Noticias de hoy: <strong>0</strong> 
                        | Noticias del mes: <strong>0</strong> 
                        | Total: <strong>{{ $countTotal }}</strong>
                    </small>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                @foreach($themes as $theme)
                    <h2>{{ $theme->nombre }}</h2>
                    <hr>
                    @if($newsAssigned)
                        @foreach($newsAssigned as $array)
                            @if($array[0] == $theme->id_tema)
                                @foreach($array[1] as $new)
                                    <div class="row f-col">
                                        <div class="col-md-4">
                                            <div class="bloque-new item-center">
                                                <a class="img-responsive">
                                                  <img src="..." alt="Logo Fuente">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="f-h4 text-muted">
                                                Noticia Fuente 
                                            </h4>
                                            <h3 class="f-h3">
                                                {{ $new->encabezado }}
                                            </h3>
                                            <p class="text-muted f-p">
                                                 Nombre Fuente | Autor:Nombre Autor
                                            </p>
                                            <p class="f-p">{{ Illuminate\Support\Str::limit($new->sintesis, 200) }}</p>
                                            <a class="btn btn-primary" href="#">Ver más</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <strong>No hay Noticias que mostrar</strong>
                    @endif
                @endforeach
            </div>
        </div>
    <!-- /.container -->
@endsection