<div class="btn-group pull-right people-pager">
    {!! $notes->links() !!}
</div>
<table class="table table-bordered table-primary table-striped nomargin">
    <thead>
        <tr>
            <th>#</th>
            <th>No. Nota</th>
            <th>Título</th>
            <th>Tema</th>
            <th>Sector</th>
            <th>Género</th>
            <th>Fuente</th>
            <th>Medio</th>
            <th>Fecha</th>
            <th>Costo</th>
            <th>Tendencia</th>
            <th>Alcance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notes as $note)
            <tr>
                <td>{{ ($notes->currentPage() - 1) * $notes->perPage() + $loop->iteration }}</td>
                <td>
                    <a target="_blank" href="{{ route('admin.new.show', ['id' => $note->id]) }}">
                        {{ "OPE-{$note->id}" }}
                    </a>
                </td>
                <td>
                    <a target="_blank" href="{{ route('admin.new.show', ['id' => $note->id]) }}">
                        {{ $note->title }}
                    </a>
                </td>
                <td>{{ $note->assignedNews->where('company_id', $client->id)->where('news_id', $note->id)->first()->theme->name }}</td>
                <td>{{ $note->sector->name }}</td>
                <td>{{ $note->genre->description }}</td>
                <td>{{ $note->source->name }}</td>
                <td>{{ $note->mean->name }}</td>
                <td>{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</td>
                <td>{{  number_coin($note->cost) }}</td>
                <td>{{ $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa') }}</td>
                <td>{{ number_decimal($note->scope) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $notes->links() !!}
