@extends('layouts.home')
@section('title', " - Mis temas")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
        <div class="">
            <div  id="list-news">

                <div class="uk-box-shadow-medium sticky-this" uk-slider="finite: true" style="background: #f2f2f2; margin-left: 0; margin-bottom: 0; position: relative;">
                    <ul id="list-group-themes" class="uk-subnav uk-slider-items list-group" uk-grid  style="background: #f2f2f2; margin-left: 0; margin-bottom: 0">
                        @foreach ($company->themes as $theme)
                        <li uk-filter-control=".theme{{ $theme->id }}" style="padding-left: 0;" class="list-group-item theme-transition @if($theme->id == $defaultThemeId) uk-active active @endif"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}" href="#" style="padding: 20px 15px;">{{ $theme->name }}</a></li>
                        @endforeach
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
            
                <div class="loader uk-container">Cargando...</div>
                
                <div id="news-by-theme">
                @include('components/listNews')
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection