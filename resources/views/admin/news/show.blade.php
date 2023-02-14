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
    <div class="col-sm-12 col-md-12" id="panel-primary">
        <div class="well well-asset-options clearfix">
            <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                {{-- <div class="btn-group" role="group"> --}}
                    {{-- <button type="button" class="btn btn-default"><i class="fa fa-share"></i> {{ __('Compartir') }}</button> --}}
                    {{-- <button type="button" class="btn btn-default"><i class="fa fa-download"></i> Download</button> --}}
                {{-- </div> --}}
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.new.edit', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-pencil"></i> {{ __('Editar') }}</a>
                    <a href="{{ route('admin.new.adjunto.show', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-file"></i> {{ __('Adjuntos') }}</a>
                    <a href="{{ route('admin.new.newletter.show', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-folder-open"></i> {{ __('Incluir a Newsletter') }}</a>
                    <a href="{{ route('admin.new.notice.show', ['id' => $note->id]) }}" class="btn btn-default"><i class="fa fa-envelope"></i> {{ __('Enviar') }}</a>
                    <a href="javascript:void(0);" id="btn-assign" class="btn btn-default"><i class="fa fa-share"></i> {{ __('Asignar') }}</a>
              </div>
            </div><!-- btn-toolbar -->

            {{-- Esta parte es para tener botones del lado derecho --}}
            <div class="btn-group pull-right" data-toggle="buttons">
                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> {{ __('Eliminar') }}</button> --}}
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
                    {{ $note->synthesis }}
                </p>
                <div class="col-md-12 text-right">
                    {{ __("Creado {$note->created_at->diffForHumans()}") }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="panel">
                    <div class="panel-body" >
                        <h4 style="color: #d9534f">{{ __("Noticia #: OPE-$note->id") }}</h4>
                        @foreach($note->metas() as $newMetas)
                            @if($newMetas['label'] == 'Comentarios' || $newMetas['label'] == 'Creador' || $newMetas['label'] == 'Encabezado' || $newMetas['label'] == 'Síntesis')
                                @continue
                            @endif
                            <span>{{ $newMetas['label'] }}:</span> <strong>{!! $newMetas['value'] !!}</strong>
                            <br>
                        @endforeach
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Archivos Adjuntos</h4>
                    </div>
                    <div class="panel-body">
                        <ol>
                            @forelse($note->files as $secondary)
                                <li><a href="{{ $secondary->path_filename }}" target="_blank">{{ $secondary->original_name }}</a></li>
                            @empty
                                <p>{{ __('No hay archivos adjuntos') }}</p>
                            @endforelse
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 text-center">
                @if($mainFile = $note->files->where('main_file', 1)->first())
                    <div class="embed-responsive embed-responsive-16by9">
                        {!! $mainFile->getHTML() !!}
                    </div>
                    <br>
                    <a class="text-info" href="{{ $mainFile->path_filename }}" target="_blank">{{ $mainFile->original_name }}</a>
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
    <div class="col-sm-12 col-md-12" id="panel-secondary" style="display: none;">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">Asignar nota a cliente</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.new.notice.toassign', ['id' => $note->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="select-companies" class="col-form-label">Empresa</label>
                        <select name="company_id" id="select-company" class="form-control" style="width: 100%;"></select>
                    </div>
                    <div class="form-group">
                        <div id="div-select-theme"></div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10">
                        <a href="javascript:void(0)" class="btn btn-quirk btn-wide btn-danger" id="btn-cancel">Cancelar</a>
                        <input type="submit" class="btn btn-quirk btn-wide btn-primary mr5" value="Asignar">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Relate button 
            $('#btn-assign').on('click', function(event){
                event.preventDefault()
                $('#panel-primary').hide('fast')
                $('#panel-secondary').show('slow')
            })

            // Cancel Assign
            $('#btn-cancel').on('click', function(event){
                event.preventDefault()
                $('#panel-primary').show('slow')
                $('#panel-secondary').hide('fast')
            })

            // Select company combo
            $('#select-company').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getcompaniesajax') }}",
                    dataType: 'json',
                    data: function(params, noteType) {
                        return {
                            q: params.term,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        } 
                    },
                    processResults: function(data) {
                        return {
                            results: data.items
                        }
                    },
                    cache: true
                }
            })

            // show select with themes when channge a company
            $('#select-company').on('change', function(){
                var companyId = $(this).val()
                var divAccountsList = $('#div-accounts-list')
                divAccountsList.html('') 

                $.post('{{ route('api.getthemeshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'company_id': companyId }, function (res) {
                    var divSelectThemes = $('#div-select-theme');
                    divSelectThemes.html(res);
                    divSelectThemes.find('#select-theme').css('width','100%').select2();
                })

            })

        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection