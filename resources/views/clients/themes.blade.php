@extends('layouts.home2')
@section('title', " - Mis temas")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <div class="row card-company">
            <div class="col-sm-3">
                <img src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
            </div>
            <div class="col-sm-8 page-header card-company-name">
                <h1>{{ $company->name }}</h1>
            </div>
        </div>
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
                @include('components/listNews')
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/home/client.js') }}"></script>
@endsection