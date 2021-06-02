@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
<div class="uk-padding op-content-mt main-content" style="background: #f9f9f9;">
    @include('components.clientHeading')
    <!-- Page Content -->

    <div id="list-news" class="filter-this">
        <div class="uk-box-shadow-medium sticky-this" uk-slider="finite: true" style="background: #f2f2f2; margin-left: 0; margin-bottom: 0; position: relative;">
            <ul class="uk-subnav uk-slider-items" uk-grid  style="background: #f2f2f2; margin-left: 0; margin-bottom: 0">
                <li class="active uk-active" uk-filter-control style="padding-left: 0;"><a href="#" style="padding: 20px 15px;">Todos los temas</a></li>
                @foreach($company->themes as $theme)
                <li uk-filter-control=".theme{{ $theme->id }}" style="padding-left: 0;"><a href="#" style="padding: 20px 15px;">{{ $theme->name }}</a></li>
                @endforeach
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
        </div>
        <div class="op-content-mt main-content js-temas uk-padding uk-padding-remove-bottom" style="background: #fff;">
            @foreach($company->themes as $theme)
            <div class="row theme{{ $theme->id }}" id="list-new">
                @if(!$theme->assignedNews()->count())
                    @continue
                @endif
                    <h2 id="theme{{ $theme->id }}" >{{ $theme->name }} <small class="count" id="count-{{ $theme->id }}"></small></h2>
                    @if($company->assignedNews->count() > 0)
                    @php
                    $contadorEntradas = 0;
                    @endphp
                    <div class="news-group uk-container">
                        @foreach($company->assignedNews()->limit(30)->orderBy('id', 'desc')->get() as $assigned)
                            @if($assigned->theme_id == $theme->id)
                                @php
                                $contadorEntradas++;
                                @endphp
                                <div uk-grid class="news-single @php echo ($contadorEntradas > 4) ? "uk-hidden": "";  @endphp ">
                                    <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
                                        @if($assigned->news->source)
                                        <img src="{{ asset("images/{$assigned->news->source->logo}") }}" alt="{{ $assigned->news->source->name }}">
                                        <h4 class="uk-margin-remove-top">{{ $assigned->news->source->name ?? "N/A" }}</h4>
                                        @else
                                            <img src="{{ asset("images/sources_logos/default.png") }}" alt="Opemedios default">
                                            <h4 class="uk-margin-remove-top">N/A</h4>
                                        @endif
                                    </div>
                                    <div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
                                        <h3 class="f-h3">
                                            {{ $assigned->news->title  }}
                                        </h3>
                                        <p class="f-p">{!! Illuminate\Support\Str::limit($assigned->news->synthesis, 200) !!}</p>
                                        <div uk-grid class="info">
                                            <div><span class="icon-calendar"></span> {{ $assigned->news->news_date->diffForHumans() }}</div>
                                            <div class="text-muted f-p">{{ $assigned->news->source->company ?? 'N/A' }}</div>
                                            <div class="text-muted f-p">Autor: {{ $assigned->news->author ?? 'N/A' }}</div>
                                            <div><a class="btn btn-primary uk-button uk-button-default" href="{{ route('client.shownew', ['id' => $assigned->news_id, 'company' => $company->slug ]) }}">Ver más</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @php echo ($contadorEntradas > 4) ? '<div class="uk-text-center"><a href="#" class="uk-button more-theme-news">mostrar más '.$theme->name.'</a></div>': '';  @endphp
                    </div>
                    @php
                    echo '<span class="count uk-hidden" target="count-'.$theme->id.'">'.$contadorEntradas.'</span>';
                    @endphp
                    @else
                        <strong>No hay Noticias que mostrar</strong>
                    @endif
            </div>
            @endforeach
        </div>
    </div>
    <!-- /.container -->
</div>
@endsection

@section('scripts')
    {{-- <script type="text/javascript" src="{{ asset('js/home/client.js') }}"></script> --}}
@endsection