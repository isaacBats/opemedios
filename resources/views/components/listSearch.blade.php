<div class="op-content-mt main-content js-temas uk-padding news-group" style="background: #fff;">
    <h3>{{ "Se encontraron {$news->count()} resultados."}}</h3>
    @foreach($news as $note)
        <div uk-grid class="news-single">
            <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
                @php
                    $noteSourceLogo = !empty($note->source->logo) ? $note->source->logo : 'default.jpg';
                    $noteSourceName = !empty($note->source->name) ? $note->source->name : 'S/N';
                @endphp
                <img src="{{ asset("images/{$noteSourceLogo}") }}" alt="{{ $noteSourceName }}">
                <h4 class="uk-margin-remove-top">{{ $noteSourceName }} </h4>
            </div>
            <div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
                <h3 class="f-h3">
                    {{ !empty($note->title) ? $note->title : 'S/T'  }}
                </h3>
                <p class="f-p">{{ Illuminate\Support\Str::limit($note->synthesis, 200) }}</p>
                <div uk-grid class="info">
                    <div><span class="icon-calendar"></span> {{ $note->news_date->diffForHumans() }}</div>
                    <div class="text-muted f-p">{{ !empty($note->source->company) ? $note->source->company : 'N/C' }}</div>
                    <div class="text-muted f-p">Autor: {{ !empty($note->author) ? $note->autor : 'S/A' }}</div>
                    <div><a class="btn btn-primary uk-button uk-button-default" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">Ver más</a></div>
                </div>
            </div>
        </div>
@endforeach
</div>