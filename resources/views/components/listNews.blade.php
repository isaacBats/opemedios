<div uk-grid="masonry: true;">
    @foreach($news as $note)
    <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-3@xl">
        <div class="uk-card uk-card-default">

            <div class="uk-card-media-top uk-cover-container">
                <img src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}" uk-cover>
                <canvas width="700" height="250"></canvas>
            </div>
            <div class="uk-card-body">
                <h4 class="f-h4 text-muted">
                    {{ $note->source->name }} | {{ $note->news_date->diffForHumans() }}
                </h4>
                <h3 class="f-h3">
                    {{ $note->title  }}
                </h3>
                <p class="text-muted f-p">
                    {{ $note->source->company }} | Autor: {{ $note->author }}
                </p>
                <p class="f-p">{{ Illuminate\Support\Str::limit($note->synthesis, 200) }}</p>
                <a class="btn btn-primary uk-button uk-button-large uk-button-default" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">Ver más</a>
            </div>
            
        </div>
    </div>
    @endforeach
</div>

<div class="text-right" id="news-pagination" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id_tema }}">
    {!! $news->links() !!}
</div>