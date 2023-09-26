@extends('layouts.admin')
@section('admin-title', '- Reporte de Notas por Monitor')
@section('content')
    <div class="row">
        <div class="col-sm-12 people-list">
            <div id="div-table-notes">
                <table class="table table-bordered table-primary table-striped nomargin">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Fuente</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($notes as $note)
                        <tr>
                            <td>
                                <a href="{{ route('admin.new.show', ['id' => $note->id]) }}">{{ $loop->iteration }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.new.show', ['id' => $note->id]) }}">{{ $note->title }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.new.show', ['id' => $note->id]) }}">{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.new.show', ['id' => $note->id]) }}">{{ $note->source ? $note->source->name : 'N/A' }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $notes->links() !!}
            </div>
        </div>
    </div>
@endsection
