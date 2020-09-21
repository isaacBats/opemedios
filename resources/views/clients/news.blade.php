@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    @include('components.clientHeading')
    <!-- Page Content -->
    <div class="uk-container">
        <div class="uk-padding-large uk-padding-remove-horizontal op-content-mt">
            <div class="row" id="list-news">
                @foreach($company->themes as $theme)
                    <h2>{{ $theme->name }}</h2>
                    <hr>
                    @if($company->assignedNews->count() > 0)
                        @foreach($company->assignedNews()->limit(30)->orderBy('id', 'desc')->get() as $assigned)
                            @if($assigned->theme_id == $theme->id)
                                <div class="row f-col">
                                    <div class="col-md-4">
                                        <div class="bloque-new item-center">
                                            <a class="img-responsive">
                                              <img src="{{ asset("images/{$assigned->news->source->logo}") }}" alt="{{ $assigned->news->source->name }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
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
                                        <a class="btn btn-primary" href="{{ route('client.shownew', ['id' => $assigned->news_id, 'company' => $company->slug ]) }}">Ver más</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <strong>No hay Noticias que mostrar</strong>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection

@section('scripts')
    {{-- <script type="text/javascript" src="{{ asset('js/home/client.js') }}"></script> --}}
@endsection