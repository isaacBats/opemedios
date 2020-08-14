@if($newsAssigned)
    @foreach($newsAssigned as $note)
        <div class="row f-col">
            <div class="col-md-4">
                <div class="bloque-new item-center">
                    <a class="img-responsive">
                        {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                      <img src="http://sistema.opemedios.com.mx/data/fuentes/{{ $note->source_logo }}" alt="{{ $note->source_name }}">
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <h4 class="f-h4 text-muted">
                    {{ $note->source_name }} | {{ Illuminate\Support\Carbon::parse($note->fecha)->diffForHumans() }}
                </h4>
                <h3 class="f-h3">
                    {{ $note->title  }}
                    <br><small>Tema: <strong>{{ $note->theme_name }}</strong></small>
                </h3>
                <p class="text-muted f-p">
                     {{ $note->source_company }} | Autor: {{ $note->autor }}
                </p>
                <p class="f-p">{{ Illuminate\Support\Str::limit($note->sintesis, 200) }}</p>
                <a class="btn btn-primary" href="{{ route('client.shownew', ['id' => $note->id_noticia, 'company' => $company->slug, 'type' => 'old' ]) }}">Ver más</a>
            </div>
        </div>
    @endforeach
@else
    <strong>No hay Noticias que mostrar</strong>
@endif
{!! $newsAssigned->links() !!}