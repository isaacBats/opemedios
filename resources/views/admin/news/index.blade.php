@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ __('Filtro por fuente') }}</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{ route('admin.news') }}">{{ __('Ver todas') }}</a></li>
                        @foreach( App\Means::all() as $mean )
                            <li class="list-group-item">
                                <a href="{{ route('admin.news', ['new_mean' => $mean->id]) }}">
                                    {{ $mean->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-12 text-right">
                        {{ $news->links() }}
                    </div>
                    <table class="table table-bordered table-inverse table-striped nomargin">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">{{ __('Noticia') }}</th>
                                <th class="text-center">{{ __('Fuente') }}</th>
                                <th class="text-center">{{ __('Enviado a') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $note)
                                <tr>
                                    <td class="text-center">
                                        <span class="fa {{ $note->mean->icon }} fa-3x"></span>
                                    </td>
                                    <td><a href="{{ route('admin.new.show', ['id' => $note->id]) }}">{{ $note->title }}</a></td>
                                    <td>{{ $note->source->name }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection