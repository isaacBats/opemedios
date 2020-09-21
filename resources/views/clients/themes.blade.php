@extends('layouts.home')
@section('title', " - Mis temas")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-container">
        <div class="uk-padding-large uk-padding-remove-horizontal">
            
            <h1 class="page-header">Noticias por tema</h1>
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Temas
                    </div>
                    <div class="panel-body themes-list-p0">
                        <ul class="list-group" id="list-group-themes">
                            @foreach ($company->themes as $theme)
                                <li class="list-group-item theme-transition"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}">@if($theme->id == $defaultThemeId) <i id="item-indicator" class="fa fa-arrow-right" style="color: #005b8a;"></i> @endif {{ $theme->name }}</a></li>
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