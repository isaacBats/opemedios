<div class="btn-group pull-right people-pager">
    {!! $notes->links() !!}
</div>
<span>Mostrando <strong>{{ "{$notes->firstItem()} de " .  ($notes->firstItem() + $notes->count() - 1)}}</strong> noticias</span>
<table class="table table-bordered table-primary table-striped nomargin">
    <thead>
        <tr>
            <th>#</th>
            <th>No. Nota</th>
            <th>Título</th>
            <th>Sector</th>
            <th>Género</th>
            <th>Fuente</th>
            <th>Medio</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notes as $note)
            <tr>
                <td>{{ ($notes->currentPage() - 1) * $notes->perPage() + $loop->iteration }}</td>
                <td>{{ "OPE-{$note->id}" }}</td>
                <td>{{ $note->title }}</td>
                <td>{{ $note->sector->name }}</td>
                <td>{{ $note->genre->description }}</td>
                <td>{{ $note->source->name }}</td>
                <td>{{ $note->mean->name }}</td>
                <td>{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $notes->links() !!}
