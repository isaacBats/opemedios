@if($newsAssigned)
<div style="background: #fff;" class="op-content-mt main-content uk-padding">
    <div class="news-group uk-container" style="margin-left: 0;">
    @foreach($newsAssigned as $note)
    <div uk-grid class="news-single">
        <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
            {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
            <img src="http://sistema.opemedios.com.mx/data/fuentes/{{ $note->source_logo }}"" alt="{{ $note->source_name }}">
            <h4 class="uk-margin-remove-top">{{ $note->source_name }}</h4>
        </div>
        <div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
            <h3 class="f-h3">
                {{ $note->title  }}
                <br><small>Tema: <strong>{{ $note->theme_name }}</strong></small>
            </h3>
            <p class="f-p">{{ Illuminate\Support\Str::limit($note->sintesis, 200) }}</p>
            <div uk-grid class="info">
                <div><span class="icon-calendar"></span> {{ Illuminate\Support\Carbon::parse($note->fecha)->diffForHumans() }}</div>
                <div class="text-muted f-p">{{ $note->source_company }}</div>
                <div class="text-muted f-p">Autor: {{ $note->autor }}</div>
                <div><a class="btn btn-primary uk-button uk-button-default" href="{{ route('client.shownew', ['id' => $note->id_noticia, 'company' => $company->slug, 'type' => 'old' ]) }}">Ver más</a></div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@else
    <p><strong>No hay Noticias que mostrar</strong></p>
@endif
{!! $newsAssigned->links() !!}


