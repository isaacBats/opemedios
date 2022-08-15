<div class="op-content-mt main-content js-temas uk-padding uk-padding-remove-bottom" style="background: #fff;">
    <div class="row " id="list-news">
            <h2 class="theme-name"></h2>
            <div class="news-group uk-container">
                @foreach($news as $note)
                    @isset($note->source )
                        <div uk-grid class="news-single">
                            <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
                                <img src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                                <h4 class="uk-margin-remove-top">{{ $note->source->name }}</h4>
                            </div>
                            <div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
                                <h3 class="f-h3">
                                    {{ $note->title  }}
                                </h3>
                                <p class="f-p">{{ Illuminate\Support\Str::limit($note->synthesis, 200) }}</p>
                                <div uk-grid class="info">
                                    <div><span class="icon-calendar"></span> {{ $note->news_date->diffForHumans() }}</div>
                                    <div class="text-muted f-p">{{ $note->source->company }}</div>
                                    <div class="text-muted f-p">Autor: {{ $note->author }}</div>
                                    <div><a class="btn btn-primary uk-button uk-button-default" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">Ver más</a></div>
                                </div>
                            </div>
                        </div>
                    @endisset
                @endforeach
            </div>
    </div>
</div>


<div class="text-right" id="news-pagination" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id_tema }}">
    {!! $news->withQueryString()->links() !!}
</div>
