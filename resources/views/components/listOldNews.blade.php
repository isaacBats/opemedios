@if($newsAssigned)
<div uk-grid="masonry: true;">
    @foreach($news as $note)
    <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-3@xl">
        <div class="uk-card uk-card-default">

            <div class="uk-card-media-top uk-cover-container">
                {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                <img src="http://sistema.opemedios.com.mx/data/fuentes/{{ $note->source_logo }}" alt="{{ $note->source_name }}" uk-cover>
                <canvas width="700" height="250"></canvas>
            </div>
            <div class="uk-card-body">
                <h4 class="f-h4 text-muted">
                    {{ $note->source_name }} &mdash; <small>{{ Illuminate\Support\Carbon::parse($note->fecha)->diffForHumans() }}</small>
                </h4>
                <h3 class="f-h3">
                    {{ $note->title  }}
                    <br><small>Tema: <strong>{{ $note->theme_name }}</strong></small>
                </h3>
                <p class="text-muted f-p">
                    {{ $note->source_company }} &mdash; <small>Autor: {{ $note->autor }}</small>
                </p>
                <p class="f-p">{{ Illuminate\Support\Str::limit($note->sintesis, 200) }}</p>
                <a class="btn btn-primary uk-button uk-button-large uk-button-default" href="{{ route('client.shownew', ['id' => $note->id_noticia, 'company' => $company->slug, 'type' => 'old' ]) }}">Ver más</a>
            </div>
            
        </div>
    </div>
    @endforeach
</div>
@else
    <p><strong>No hay Noticias que mostrar</strong></p>
@endif
{!! $newsAssigned->links() !!}