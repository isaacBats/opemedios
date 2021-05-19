@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
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
                                    <td>
                                        <a href="{{ route('admin.new.show', ['id' => $note->id]) }}">
                                            {{ "OPE-{$note->id}" }} <br />
                                            {{ $note->title }}
                                        </a>
                                    </td>
                                    @php
                                        $sourceNote = $note->source->where('id', $note->source_id)->first();
                                        $noteSendTo = $note->assignedNews;
                                    @endphp
                                    <td>{{ $sourceNote ? $sourceNote->name : 'N/E'  }}</td>
                                    @if(count($noteSendTo) > 0)
                                        <td>{{ $note->isAssigned() ? ($note->assignedNews->first()->company->name) : 'No enviada' }}</td>
                                    @else
                                        <td>No enviada</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $news->links() }}
                </div>
            </div>
        </div>
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
        <div class="col-sm-12 col-md-2">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __('Filtrar Noticias') }}</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.news') }}" method="GET">
                        <div class="form-group">
                            <label class="control-label center-block">{{ __('Filtrar por') }}</label>
                            <select name="option" class="form-control">
                                <option value="">{{ __('Filtrar por...') }}</option>
                                <option value="id" {{ request()->get('option') == 'id' ? 'selected' : '' }}>ID de la nota(sin OPE-)</option>
                                <option value="title" {{ request()->get('option') == 'title' ? 'selected' : '' }}>Palabra en título</option>
                                <option value="synthesis" {{ request()->get('option') == 'synthesis' ? 'selected' : '' }}>Palabra en sintesis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label center-block">{{ __('Buscar') }}</label>
                            <input type="text" name="query" class="form-control" placeholder="{{ __('Buscar') }}" value="{{ request()->get('query') }}">
                        </div>
                        <input type="submit" class="btn btn-success btn-quirk btn-block" value="{{ __('Filtrar') }}">
                    </form>
                </div>
            </div><!-- panel -->
        </div>
    </div>
@endsection