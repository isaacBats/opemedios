<div class="uk-child-width-1-2@s" uk-grid="masonry: true;">
@foreach($news as $note)
    <div>
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