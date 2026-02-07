@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">{{ __('Editar noticia de ') . $note->mean->name ?? 'N/E' }}</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.new.edit', ['id' => $note->id]) }}" method="POST" id="form-create-new-news">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-md-2 col-lg-1 col-form-label" for="input-encabezado">{{ __('Encabezado') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                        <input type="text" class="form-control" id="input-encabezado" placeholder="Título de la noticia" name="title" value="{{ old('title', $note->title) }}">
                        @error('title')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-md-2 col-lg-1 col-form-label" for="textarea-sintesis">{{ __('Síntesis') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                        <textarea name="synthesis" id="textarea-sintesis" class="form-control" rows="3" placeholder="Síntesis de la nota">{!! old('synthesis', $note->synthesis) !!}</textarea>
                        @error('synthesis')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="div-select-sources">
                    <label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="select-fuente">{{ __('Fuente') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-11 col-lg-11">
                        <select class="form-control" id="select-fuente" name="source_id">
                            <option value="{{ $note->source_id ?? '' }}">{{ $note->source->name ?? 'N/E' }}</option>
                        </select>
                        @error('source_id')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="div-select-sections-sources">
                    <label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="select-seccion">{{ __('Secciones') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-11 col-lg-11">
                        <select class="form-control" id="select-seccion" name="section_id">
                            <option value="{{ $note->section_id ?? '' }}">{{ $note->section->name ?? 'N/E' }}</option>
                        </select>
                        @error('section_id')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="row item-note">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-md-2 col-lg-2 col-form-label" for="input-author">{{ __('Autor') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <input type="text" class="form-control" id="input-author" placeholder="Nombre de autor" name="author" value="{{ old('author', $note->author) }}">
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-author-type">{{ __('Tipo de autor') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <select class="form-control" id="select-author-type" name="author_type_id">
                                    <option value="">{{ __('Tipo de autor') }}</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id ?? '' }}" {{ (old('author_type_id', $note->author_type_id) == $author->id ? 'selected' : '' ) }} >{{ $author->description ?? 'N/E' }}</option>
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
                <div class="row item-note">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-sector">{{ __('Sector') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <select class="form-control" id="select-sector" name="sector_id">
                                    <option value="">{{ __('Selecciona un sector') }}</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id ?? '' }}" {{ (old('sector_id', $note->sector_id) == $sector->id ? 'selected' : '' ) }} >{{ $sector->name ?? 'N/E' }}</option>
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-genre">{{ __('Genero') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <select class="form-control" id="select-genre" name="genre_id">
                                    <option value="">{{ __('Genero') }}</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id ?? ''}}" {{ (old('genre_id', $note->genre_id) == $genre->id ? 'selected' : '' ) }} >{{ $genre->description ?? 'N/E' }}</option>
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
                <div class="row item-note">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-date">{{ __('Fecha') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" name="news_date" id="input-news-date" value="{{ old('news_date', $note->news_date->format('d-m-Y')) }}">
                                    <div class="input-group-addon">
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
                    @if($note->mean->short_name == 'per' || $note->mean->short_name == 'rev')
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-per item-rev" >
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="input-page">{{ __('Pagina') }}: <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control item-input-clean" placeholder="10" name="page_number" id="input-page" value="{{ old('page_number', unserialize($note->metas_news)['page_number']) }}" >
                                    <small class="form-text text-muted">{{ __('Escribe solo el número de página') }}</small>    
                                    @error('news_date')
                                        <label class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($note->mean->short_name == 'tel' || $note->mean->short_name == 'rad' || $note->mean->short_name == 'int')
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-int item-rad item-tv" >
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="input-news-hour">{{ __('Hora') }}: <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control item-input-clean" placeholder="hh:mm:ss" name="news_hour" id="input-news-hour" value="{{ old('news_hour', unserialize($note->metas_news)['news_hour']) }}">
                                        <div class="input-group-addon">
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
                    @endif
                    @if($note->mean->short_name == 'tel' || $note->mean->short_name == 'rad')
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-rad item-tv">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="input-news-duration">{{ __('Duración') }}: <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control item-input-clean" placeholder="hh:mm:ss" name="news_duration" id="input-news-duration" value="{{ old('news_duration', unserialize($note->metas_news)['news_duration']) }}">
                                        <div class="input-group-addon">
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
                    @endif
                </div>
                @if($note->mean->short_name == 'int')
                    <div class="form-group row item-int">
                        <label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="input-url">{{ __('URL') }}: <span class="text-danger">*</span></label>
                        <div class="col-sm-10 col-md-11 col-lg-11">
                            <input type="url" class="form-control item-input-clean" id="input-url" placeholder="https://www.example.com" name="url" value="{{ old('url', unserialize($note->metas_news)['url']) }}">
                            @error('url')
                                <label class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                @endif
                @if($note->mean->short_name == 'per' || $note->mean->short_name == 'rev')
                    <div class="row item-rev item-per item-note">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-page-type">{{ __('Tipo') }}: <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <select class="form-control item-select-clean" id="select-author-type" name="page_type_id">
                                        <option value="">{{ __('Tipo de página') }}</option>
                                        @foreach($ptypes as $ptype)
                                            <option value="{{ $ptype->id }}" {{ (old('page_type_id', unserialize($note->metas_news)['page_type_id']) == $ptype->id ? 'selected' : '' ) }} >{{ $ptype->description }}</option>
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
                                <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="input-page-size">{{ __('Tamaño(%)') }}: <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <input type="number" min="0" max="100" step="0.01" class="form-control item-input-clean" id="input-page-size" placeholder="20" name="page_size" value="{{ old('page_size', unserialize($note->metas_news)['page_size']) }}" >
                                    @error('page_size')
                                        <label class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>    
                    </div>
                @endif
                <div class="row item-note">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-cost">{{ __('Costo Beneficio') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" step="0.01" placeholder="105.30" name="cost" id="input-cost"  value="{{ old('cost', $note->cost) }}">
                                </div>
                                @error('cost')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-trend">{{ __('Tendencia') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="input-trend" name="trend">
                                    <option value="">{{ __('Tendencia') }}</option>
                                    <option value="1" {{ (old('trend', $note->trend) == "1" ? 'selected' : '' ) }} >{{ __('Positiva') }}</option>
                                    <option value="2" {{ (old('trend', $note->trend) == "2" ? 'selected' : '' ) }} >{{ __('Neutral') }}</option>
                                    <option value="3" {{ (old('trend', $note->trend) == "3" ? 'selected' : '' ) }} >{{ __('Negativa') }}</option>
                                </select>    
                                @error('trend')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-scope">{{ __('Alcance') }}:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="scope" id="input-scope" value="{{ old('scope', $note->scope) }}">
                                @error('scope')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-md-2 col-lg-1 col-form-label" for="textarea-comment">{{ __('Comentarios') }}:</label>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                        <textarea name="comments" id="textarea-comment" class="form-control" rows="3" placeholder="Comentarios">{!! old('comments', $note->comments) !!}</textarea>
                        @error('comments')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group text-right">
                    <a class="btn btn-danger btn-lg" href="{{ route('admin.new.show', ['id' => $note->id]) }}" >{{ __('Cancelar') }}</a>
                    <input type="submit" class="btn btn-primary btn-lg" value="{{ __('Guardar') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/timepicker/timepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type='text/javascript' src="{{ asset('lib/summernote/summernote.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // settings timepicker
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

            // settings select2
            $('#select-sector').select2()

            // settings datepicker
            $('#input-news-date').datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true
            })
            var noteType = '{{ $note->mean_id }}'
            var divSelectSources = $('#div-select-sources')

            divSelectSources.find('#select-fuente').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getsourceajax') }}",
                    dataType: 'json',
                    data: function(params, noteType) {
                        return {
                            q: params.term,
                            mean_id: '{{ $note->mean_id }}',
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

            // Updating sources depending on the type of news
            $('#div-select-sources').on('change', '#select-fuente', function() {
                var sourceId = $(this).val()
                $.post('{{ route('api.getsectionshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'source_id': sourceId }, function(res){
                        var divSelectSections = $('#div-select-sections-sources').html(res)
                        divSelectSections.find('#select-seccion').select2()
                    }).fail(function(res){
                        var divSelectSections = $('#div-select-sections-sources').html(`<p>No se pueden obtener las seciones de la fuente</p>`)
                        console.error(`Error-Sections: ${res.responseJSON.message}`)
                    })
            });

            // Cost autocomplete - fetch rate when source/section changes
            function fetchCostRate() {
                var sourceId = $('#select-fuente').val()
                var sectionId = $('#select-seccion').val()
                var scope = $('#input-scope').val() || 0

                if (!sourceId) {
                    return
                }

                var params = {
                    source_id: sourceId,
                    section_id: sectionId,
                    value: scope
                }

                $.get('/api/admin/rates/lookup', params, function(res) {
                    if (res.success) {
                        var costInput = $('#input-cost')
                        var scopeInput = $('#input-scope')
                        var currentCost = costInput.val()
                        var currentScope = scopeInput.val()

                        // Auto-fill Costo if empty or zero
                        if (res.price && (!currentCost || parseFloat(currentCost) === 0)) {
                            costInput.val(res.price)
                            costInput.addClass('bg-success-light')
                            setTimeout(function() {
                                costInput.removeClass('bg-success-light')
                            }, 1500)
                        }

                        // Auto-fill Alcance (max_value) if empty or zero
                        if (res.max_value && (!currentScope || parseFloat(currentScope) === 0)) {
                            scopeInput.val(res.max_value)
                            scopeInput.addClass('bg-success-light')
                            setTimeout(function() {
                                scopeInput.removeClass('bg-success-light')
                            }, 1500)
                        }
                    }
                }).fail(function(err) {
                    console.log('No se encontró tarifa para esta combinación')
                })
            }

            // Trigger cost lookup when section changes
            $('#div-select-sections-sources').on('change', '#select-seccion', function() {
                fetchCostRate()
            })

            // Trigger cost lookup when source changes
            $('#div-select-sources').on('change', '#select-fuente', function() {
                setTimeout(fetchCostRate, 500)
            })

            // Trigger cost lookup when scope changes
            $('#input-scope').on('change blur', function() {
                fetchCostRate()
            })

            // $('#textarea-sintesis').summernote({
            //     height: 200,
            //     toolbar: [
            //         ['style', ['bold', 'italic', 'underline', 'clear']],
            //       ]
            // });
        })

    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/timepicker/timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link href="{{ asset('lib/summernote/summernote.css') }}" rel='stylesheet' type='text/css' />
    <style>
        .row.item-note {
            margin-bottom: 20px;
        }
        .bg-success-light {
            background-color: #d4edda !important;
            transition: background-color 0.3s ease;
        }
    </style>
@endsection