@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
    <div class="col-sm-12 col-md-12">
        <div class="well well-asset-options clearfix">
            <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                {{-- <div class="btn-group" role="group"> --}}
                    {{-- <button type="button" class="btn btn-default"><i class="fa fa-share"></i> {{ __('Compartir') }}</button> --}}
                    {{-- <button type="button" class="btn btn-default"><i class="fa fa-download"></i> Download</button> --}}
                {{-- </div> --}}
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.new.edit', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-pencil"></i> {{ __('Editar') }}</a>
                    <a href="{{ route('admin.new.adjunto.show', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-file"></i> {{ __('Adjuntos') }}</a>
                    <button type="button" class="btn btn-default"><i class="fa fa-folder-open"></i> {{ __('Incluir a Newsletter') }}</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-envelope"></i> {{ __('Enviar') }}</button>
              </div>
            </div><!-- btn-toolbar -->

            {{-- Esta parte es para tener botones del lado derecho --}}
            <div class="btn-group pull-right" data-toggle="buttons">
                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> {{ __('Eliminar') }}</button>
                {{-- <label class="btn btn-default-active active">
                    <input type="checkbox" checked> All
                </label>
                <label class="btn btn-default-active">
                    <input type="checkbox"> Images
                </label> --}}
            </div>
        </div>
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
                @if($mainFile = $note->files->where('main_file', 1)->first())
                    <div class="embed-responsive embed-responsive-16by9">
                        {!! $mainFile->getHTML() !!}
                    </div>
                @else
                    <p class="text-center">{{ __('Esta nota aun no contiene archivos ajuntos') }}</p>
                @endif
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