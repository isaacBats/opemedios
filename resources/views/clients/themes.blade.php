@extends('layouts.home')
@section('title', " - Mis temas")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal">
            <h1 class="page-header">Noticias de: <span class="tema-actual"></span></h1>
            <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky;" class="uk-visible@l">
                <div class="uk-navbar-container" uk-navbar>
                    <div class="uk-navbar-left">
                        <ul class="uk-navbar-nav list-group" id="list-group-themes">
                            <li>
                                <a href="#">Temas<i class="icon-chevron-down"></i></a>
                                <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    @foreach ($company->themes as $theme)
                                    <li class="list-group-item theme-transition @if($theme->id == $defaultThemeId) uk-active @endif"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}">{{ $theme->name }}</a></li>
                                    @endforeach
                                </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="uk-padding uk-padding-remove-horizontal">
                <div class="loader">Cargando...</div>
                <div id="news-by-theme" class="col-md-9">
                    @include('components/listNews')
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection