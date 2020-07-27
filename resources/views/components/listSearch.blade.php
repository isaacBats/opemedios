@foreach($news as $note)
    <div class="row f-col">
        <div class="col-md-4">
            <div class="bloque-new item-center">
                <a class="img-responsive">
                    <img src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                </a>
            </div>
        </div>
        <div class="col-md-8">
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
            <a class="btn btn-primary" href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug ]) }}">Ver más</a>
        </div>
    </div>
@endforeach
