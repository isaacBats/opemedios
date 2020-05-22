@extends('layouts.blank')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.new.add') }}" method="POST" enctype="multipart/form-data">
                <h5 class="card-title">{{ __('Nueva noticia') }}</h5>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="select-mean">{{ __('Tipo de noticia') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="select-mean" name="mean_id">
                            <option value="">{{ __('Tipo de noticia') }}</option>
                            @foreach($means as $mean)
                                <option value="{{ $mean->id }}" {{ (old('mean_id', $defaulNoteType->id) == $mean->id ? 'selected' : '' ) }} >{{ "Noticia de {$mean->name}" }}</option>
                            @endforeach
                        </select>
                        @error('mean_id')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="input-encabezado">{{ __('Encabezado') }}:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input-encabezado" placeholder="Título de la noticia" name="title" value="{{ old('title') }}">
                        @error('title')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="textarea-sintesis">{{ __('Síntesis') }}:</label>
                    <div class="col-sm-9">
                        <textarea name="synthesis" id="textarea-sintesis" class="form-control" rows="3" placeholder="Síntesis de la nota">{!! old('synthesis') !!}</textarea>
                        @error('synthesis')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="div-select-sources"></div>
                <div class="form-group row" id="div-select-sections-sources"></div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-author">{{ __('Autor') }}:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-author" placeholder="Nombre de autor" name="author" value="{{ old('author') }}">
                                @error('author')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>    
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="select-author-type">{{ __('Tipo de autor') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="select-author-type" name="author_type_id">
                                    <option value="">{{ __('Tipo de autor') }}</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ (old('author_type_id') == $author->id ? 'selected' : '' ) }} >{{ $author->description }}</option>
                                    @endforeach
                                </select>
                                @error('author_type_id')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="select-sector">{{ __('Sector') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="select-sector" name="sector_id">
                                    <option value="">{{ __('Selecciona un sector') }}</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ (old('sector_id') == $sector->id ? 'selected' : '' ) }} >{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                                @error('sector_id')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="select-genre">{{ __('Genero') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="select-genre" name="genre_id">
                                    <option value="">{{ __('Genero') }}</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ (old('genre_id') == $genre->id ? 'selected' : '' ) }} >{{ $genre->description }}</option>
                                    @endforeach
                                </select>
                                @error('genre_id')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>    
                </div>
                <label>Default Time Picker:</label>
                <div class="input-group mb15">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                  <div class="timepicker"><input id="tpBasic" type="text" class="form-control"/></div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-danger" onclick="window.close()" >{{ __('Cerrar') }}</button>
                    <input type="submit" class="btn btn-primary" value="{{ __('Crear') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // import '/lib/select2/select2.js';
            // import select2 from '/lib/select2/select2.js'
            // import select2 from 'select2'
            // import 'select2'
            // window.select2=require('/lib/select2/select2')
            // const select2 = import 'select2'
            // const select2 = require(' asset('lib/select2/select2.js') }}')
            // select2($)
            // $('#tpBasic').timepicker()

            var noteType = $('select#select-mean').val()
            getHTMLSources(noteType)

            $('#select-mean').on('change', function(event) {
                getHTMLSources(event.target.value)
            })
            
            function getHTMLSources(noteType) {
                $.post('{{ route('api.getsourceshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'mean_id': noteType }, function(res){
                        var divSelectSources = $('#div-select-sources').html(res)
                        divSelectSources.find('#select-fuente').select2()
                    }).fail(function(res){
                        var divSelectSources = $('#div-select-sources').html(`<p>No se pueden obtener las fuentes</p>`)
                        console.error(`Error-Sources: ${res.responseJSON.message}`)
                    })
            }

            $('#div-select-sources').on('change', '#select-fuente', function() {
                var sourceId = $(this).val()
                $.post('{{ route('api.getsectionshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'source_id': sourceId }, function(res){
                        var divSelectSections = $('#div-select-sections-sources').html(res)
                        divSelectSections.find('#select-seccion').select2()
                    }).fail(function(res){
                        var divSelectSections = $('#div-select-sections-sources').html(`<p>No se pueden obtener las seciones de la fuente</p>`)
                        console.error(`Error-Sections: ${res.responseJSON.message}`)
                    }) 
            })

        })

    </script>
@endsection
@section('styles')
    
@endsection