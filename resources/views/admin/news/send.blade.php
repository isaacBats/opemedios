@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title" style="padding: 12px 0;">{{ __('Enviar noticia #:') }}<span>{{ "OPE-{$note->id}" }}</span></h4>
            </div>
            <div class="panel-body">
                {{-- <h4>{{ __("Noticia #:") }}<span style="color: #d9534f">{{ "OPE-{$note->id}" }}</span></h4> --}}
                <h2>{{ $note->title }}</h2>
                <p class="lead">{!! $note->synthesis!!}</p>
                <small>{{ "{$note->source->name}({$note->section->name})" }}</small>
                <br>
                <br>
                <p>
                    {{ __('Archivo principal: ') }}
                    @if($mainFile)
                        <a href="{{ $mainFile->path_filename }}" target="_blank">{{ $mainFile->original_name }}</a>
                    @else
                        {{ __('Esta nota no tiene archivos adjuntos, pueder agregar un archivo: ') }}<a href="{{ route('admin.new.adjunto.show', ['id' => $note->id]) }}">{{ __('Aquí') }}</a>
                    @endif
                </p>
                <p>
                    {{ __('Archivos secundarios: ') }}
                    <ol>
                        @forelse($note->files->where('main_file', '<>', 1) as $secondary)
                            <li><a href="{{ $secondary->path_filename }}" target="_blank">{{ $secondary->original_name }}</a></li>
                        @empty
                            <p>{{ __('No hay mas archivos') }}</p>
                        @endforelse
                    </ol>
                </p>
                <div class="col-sm-12 col-md-6">
                    <label for="input-company">{{ __('Buscar cliente:') }}</label>
                    <div class="input-group">
                        <input id="input-company" type="company" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){

        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
