@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    @include('components.clientHeading')
    <!-- Page Content -->
    <div class="uk-padding op-content-mt">
        <div class="row" id="list-news">
            @foreach($company->themes as $theme)
                <h2 id="theme{{ $theme->id }}">{{ $theme->name }}</h2>
                @if($company->assignedNews->count() > 0)
                <div uk-grid="masonry: true;">
                    @foreach($company->assignedNews()->limit(30)->orderBy('id', 'desc')->get() as $assigned)
                        @if($assigned->theme_id == $theme->id)
                            <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-3@xl">
                                <div class="uk-card uk-card-default">

                                    <div class="uk-card-media-top uk-cover-container">
                                        <img src="{{ asset("images/{$assigned->news->source->logo}") }}" alt="{{ $assigned->news->source->name }}" uk-cover>
                                        <canvas width="700" height="250"></canvas>
                                    </div>
                                    <div class="uk-card-body">
                                        <h4 class="f-h4 text-muted">
                                    {{ $assigned->news->source->name }} | {{ $assigned->news->news_date->diffForHumans() }}
                                        </h4>
                                        <h3 class="f-h3">
                                            {{ $assigned->news->title  }}
                                        </h3>
                                        <p class="text-muted f-p">
                                             {{ $assigned->news->source->company }} | Autor: {{ $assigned->news->author }}
                                        </p>
                                        <p class="f-p">{!! Illuminate\Support\Str::limit($assigned->news->synthesis, 200) !!}</p>
                                        <a class="btn btn-primary uk-button uk-button-large uk-button-default" href="{{ route('client.shownew', ['id' => $assigned->news_id, 'company' => $company->slug ]) }}">Ver más</a>
                                    </div>
                                    
                                </div>
                            </div>
                        @endif
                    @endforeach
                    </div>
                    <hr>
                @else
                    <strong>No hay Noticias que mostrar</strong>
                @endif
            @endforeach
        </div>
    </div>
    <!-- /.container -->
@endsection

@section('scripts')
    {{-- <script type="text/javascript" src="{{ asset('js/home/client.js') }}"></script> --}}
@endsection