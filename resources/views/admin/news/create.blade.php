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
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-date">{{ __('Fecha') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="news_date" id="input-news-date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @error('news_date')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-page">{{ __('Pagina') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="10" name="page_number" id="input-page" disabled>
                                <small class="form-text text-muted">{{ __('Escribe solo el número de página') }}</small>    
                                @error('news_date')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-hour">{{ __('Hora') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="hh:mm:ss" name="news_hour" id="input-news-hour" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                                @error('news_hour')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-duration">{{ __('Duración') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="hh:mm:ss" name="news_duration" id="input-news-duration" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                                @error('news_duration')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="input-url">{{ __('URL') }}:</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control" id="input-url" placeholder="https://www.example.com" name="url" value="{{ old('url') }}" disabled>
                        @error('url')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="select-page-type">{{ __('Tipo') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="select-author-type" name="page_type_id" disabled>
                                    <option value="">{{ __('Tipo de página') }}</option>
                                    @foreach($ptypes as $ptype)
                                        <option value="{{ $ptype->id }}" {{ (old('page_type_id') == $ptype->id ? 'selected' : '' ) }} >{{ $ptype->description }}</option>
                                    @endforeach
                                </select>
                                @error('page_type_id')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-page-size">{{ __('Tamaño(%)') }}:</label>
                            <div class="col-sm-9">
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="input-page-size" placeholder="20" name="page_size" value="{{ old('page_size') }}" disabled>
                                @error('page_size')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>    
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

            $('#input-news-hour').timepicker({
                step: 1, // time in minutes
                timeFormat: 'H:i:s',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            })

            $('#input-news-duration').timepicker({
                step: 0.0167, // time in seconds
                maxTime: '01:59:59',
                timeFormat: 'H:i:s',
                scrollbar: true
            })

            $('#select-sector').select2()
            $('#input-news-date').datepicker({
                dateFormat: 'dd/mm/yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true
            })

            var noteType = $('select#select-mean').val()
            getHTMLSources(noteType)

            $('#select-mean').on('change', function(event) {
                getHTMLSources(event.target.value)
            })
            
            function getHTMLSources(noteType) {
                $.post('{{ route('api.getsourceshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'mean_id': noteType }, function(res){
                        var divSelectSources = $('#div-select-sources').html(res)
                        divSelectSources.find('#select-fuente').select2({
                            minimumInputLength: 3,
                            ajax: {
                                type: 'POST',
                                url: "{{ route('api.getsourceajax') }}",
                                dataType: 'json',
                                data: function(params, noteType) {
                                    return {
                                        q: params.term,
                                        mean_id: $('select#select-mean').val(),
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
    <style>
        .ui-datepicker .ui-datepicker-header .ui-datepicker-next:before,
        .ui-datepicker .ui-datepicker-header .ui-datepicker-prev:before {
          font-family: 'FontAwesome';
          position: absolute;
          top: 2px;
        }
        .ui-datepicker .ui-datepicker-header .ui-datepicker-next,
        .ui-datepicker .ui-datepicker-header .ui-datepicker-next:before {
          right: 0;
        }
        .ui-datepicker .ui-datepicker-header .ui-datepicker-next:before {
          content: '\f054';
        }
        .ui-datepicker .ui-datepicker-header .ui-datepicker-prev,
        .ui-datepicker .ui-datepicker-header .ui-datepicker-prev:before {
          left: 0;
        }
        .ui-datepicker .ui-datepicker-header .ui-datepicker-prev:before {
          content: '\f053';
        }
        .ui-datepicker .ui-datepicker-header .ui-datepicker-next-hover,
        .ui-datepicker .ui-datepicker-header .ui-datepicker-prev-hover {
          color: #c0c7d2;
          cursor: pointer;
          top: 1px;
          border: 0;
          background-color: transparent;
        }
    </style>
@endsection