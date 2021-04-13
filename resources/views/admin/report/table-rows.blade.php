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
                {{-- <td>{{ ($note->currentPage() - 1) * $note->perPage() + $loop->iteration }}</td> --}}
                <td>{{ $loop->iteration }}</td>
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