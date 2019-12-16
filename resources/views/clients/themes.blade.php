@extends('layouts.home2')
@section('title', " - Mis temas")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <h1 class="page-header"> Noticias por tema</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Temas
                    </div>
                    <div class="panel-body themes-list-p0">
                        <ul class="list-group" id="list-group-themes">
                            @foreach ($themes as $theme)
                                <li class="list-group-item theme-transition"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $idCompany }}" data-themeid="{{ $theme->id_tema }}">@if($theme->id_tema == $defaultThemeId) <i id="item-indicator" class="fa fa-arrow-right" style="color: #005b8a;"></i> @endif {{ $theme->nombre }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="loader">Cargando...</div>
            <div id="news-by-theme" class="col-md-9">
                @foreach($news as $new)
                    <div class="row f-col">
                        <div class="col-md-4">
                            <div class="bloque-new item-center">
                                <a class="img-responsive">
                                    {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                                  <img src="http://sistema.opemedios.com.mx/data/fuentes/{{ $new->logo }}" alt="{{ $new->nombre}}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="f-h4 text-muted">
                                {{ $new->nombre }} | {{ Illuminate\Support\Carbon::parse($new->fecha)->diffForHumans() }}
                            </h4>
                            <h3 class="f-h3">
                                {{ $new->encabezado  }}
                            </h3>
                            <p class="text-muted f-p">
                                 {{ $new->empresa }} | Autor: {{ $new->autor }}
                            </p>
                            <p class="f-p">{{ Illuminate\Support\Str::limit($new->sintesis, 200) }}</p>
                            <a class="btn btn-primary" href="{{ route('client.shownew', ['id' => $new->id_noticia, 'company' => $company->slug ]) }}">Ver más</a>
                        </div>
                    </div>
                @endforeach
                <div class="text-right">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection