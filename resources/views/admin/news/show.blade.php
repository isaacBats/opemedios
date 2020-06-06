@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="jumbotron">
            <div class="container">
                <h1>{{ $note->title }}</h1>
                <p>
                    {!! $note->synthesis !!}
                </p>
                <div class="col-md-12 text-right">
                    {{ __("Creado {$note->created_at->diffForHumans()}") }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        @foreach($note->metas() as $newMetas)
                            @if($newMetas['label'] == 'Comentarios' || $newMetas['label'] == 'Creador' || $newMetas['label'] == 'Encabezado' || $newMetas['label'] == 'Síntesis')
                                @continue
                            @endif
                            <span>{{ $newMetas['label'] }}:</span> <strong>{!! $newMetas['value'] !!}</strong>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $fileTemplate !!}
                </div>
            </div>
        </div>
        <div class="row mt20">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12">
                            <span>{{ __('Comentarios') }}</span>
                            <p>{!! $note->comments !!}</p>
                        </div>
                        <div class="col-sm-12 col-md-12 text-right">
                            <span>{{ __('Creado por') }}:</span>
                            <p>{{ $note->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection