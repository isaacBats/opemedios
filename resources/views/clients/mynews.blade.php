@extends('layouts.home')
@section('title', " - Mi contenido")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
        <div class="">
            <div  id="list-news">
                <div class="uk-box-shadow-medium sticky-this uk-padding uk-padding-small contenedor-select-temas">
                    <div class="uk-flex uk-flex-middle uk-position-relative">
                        <label class="uk-text-uppercase label-tema">Tema:</label>
                        <select class="uk-select opciones-temas-ajax uk-width-large">
                            @foreach($company->themes as $theme)
                            <option data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
