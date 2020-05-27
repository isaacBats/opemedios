@extends('layouts.blank')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.new.add') }}" method="POST" enctype="multipart/form-data">
                <h5 class="card-title">{{ __('Nueva noticia') }}</h5>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-md-2 col-lg-1 col-form-label" for="select-mean">{{ __('Tipo de noticia') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-10 col-lg-11">
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
                    <label class="col-sm-2 col-md-2 col-lg-1 col-form-label" for="input-encabezado">{{ __('Encabezado') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                        <input type="text" class="form-control" id="input-encabezado" placeholder="Título de la noticia" name="title" value="{{ old('title') }}">
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
                            <label class="col-sm-2 col-md-2 col-lg-2 col-form-label" for="input-author">{{ __('Autor') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-10 col-md-10 col-lg-10">
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-author-type">{{ __('Tipo de autor') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-sector">{{ __('Sector') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-genre">{{ __('Genero') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
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
                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" name="news_date" id="input-news-date" value="{{ old('news_date') }}">
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
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-per item-rev" style="display: none;">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-page">{{ __('Pagina') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control item-input-clean" placeholder="10" name="page_number" id="input-page" value="{{ old('page_number') }}" disabled>
                                <small class="form-text text-muted">{{ __('Escribe solo el número de página') }}</small>    
                                @error('news_date')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-int item-rad item-tv" style="display: none">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-hour">{{ __('Hora') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control item-input-clean" placeholder="hh:mm:ss" name="news_hour" id="input-news-hour" value="{{ old('news_hour') }}" disabled>
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
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 item-rad item-tv" style="display: none;">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-news-duration">{{ __('Duración') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control item-input-clean" placeholder="hh:mm:ss" name="news_duration" id="input-news-duration" value="{{ old('news_duration') }}" disabled>
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
                <div class="form-group row item-int" style="display: none;">
                    <label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="input-url">{{ __('URL') }}: <span class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-11 col-lg-11">
                        <input type="url" class="form-control item-input-clean" id="input-url" placeholder="https://www.example.com" name="url" value="{{ old('url') }}" disabled>
                        @error('url')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="row item-rev item-per" style="display: none;">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-page-type">{{ __('Tipo') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <select class="form-control item-select-clean" id="select-author-type" name="page_type_id" disabled>
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
                            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="input-page-size">{{ __('Tamaño(%)') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <input type="number" min="0" max="100" step="0.01" class="form-control item-input-clean" id="input-page-size" placeholder="20" name="page_size" value="{{ old('page_size') }}" disabled>
                                @error('page_size')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="input-cost">{{ __('Costo Beneficio:') }}: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" step="0.01" placeholder="105.30" name="cost" id="input-cost"  value="{{ old('cost') }}">
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
                                    <option value="1" {{ (old('trend') == "1" ? 'selected' : '' ) }} >{{ __('Positiva') }}</option>
                                    <option value="2" {{ (old('trend') == "2" ? 'selected' : '' ) }} >{{ __('Neutral') }}</option>
                                    <option value="3" {{ (old('trend') == "3" ? 'selected' : '' ) }} >{{ __('Negativa') }}</option>
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
                                <input type="number" class="form-control" name="scope" id="input-scope" value="{{ old('scope') }}">
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
                        <textarea name="comments" id="textarea-comment" class="form-control" rows="3" placeholder="Comentarios">{!! old('comments') !!}</textarea>
                        @error('comments')
                            <label class="text-danger">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label class="form-check-label" for="input-check-newsletter">
                            {{ __('Incluir a un newsletter') }}
                        </label>
                    </div>
                    <div class="col-sm-10 col-md-10 col-lg-11">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="input-check-newsletter" name="in_newsletter" value="{{ old('in_newsletter') }}">
                        </div>
                    </div>
                </div>
                <div id="newsletters-items" style="display: none;">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-3 col-lg-2 col-form-label" for="select-newsletter">{{ __('Newsletter') }}:</label>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <select class="form-control" id="select-newsletter" name="newsletter_id" disabled>
                                        <option value="">{{ __('Selecciona un bloque de noticias') }}</option>
                                        @foreach($newsletters as $newsletter)
                                            <option value="{{ $newsletter->id }}" {{ (old('newsletter_id') == $newsletter->id ? 'selected' : '' ) }} >{{ $newsletter->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('newsletter_id')
                                        <label class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" id="div-select-nesletter-themes"></div>
                        </div>    
                    </div>      
                </div>
                <div class="form-group row justify-content-md-center" style="margin-top: 35px;">
                    <div class="col col-md-6">
                        <a href="javascript:void(0)" class="btn btn-success btn-lg btn-block">{{ __('Subir archivos') }}</a>
                    </div>
                </div>
                <div class="form-group text-right">
                    <a class="btn btn-danger btn-lg" href="javascript:window.close();" >{{ __('Cerrar') }}</a>
                    <input type="submit" class="btn btn-primary btn-lg" value="{{ __('Crear') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
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

            // close window
            // $('#btn-close-window').on('click', function(event) {
            //     event.preventDefault()
            //     window.close()
            // })

            // Note type
            var noteType = $('select#select-mean').val()
            getHTMLSources(noteType)
            getItemsByMean(noteType)

            $('#select-mean').on('change', function(event) {
                getHTMLSources(event.target.value)
                getItemsByMean(event.target.value)
                // var mean = $('#select-mean option:selected').text()                
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

            function getItemsByMean(mean) {

                var itemsTV = $('.item-tv')
                var itemsRad = $('.item-rad')
                var itemsRev = $('.item-rev')
                var itemsPer = $('.item-per')
                var itemsInt = $('.item-int')

                switch(mean) {
                    case "1":  // Television
                        hideFields()
                        cleanFields()
                        $('.item-tv')
                            .find('input[name=news_hour], input[name=news_duration]')
                            .removeAttr('disabled')
                        itemsTV.show('slow')
                        break
                    case "2": // Radio
                        hideFields()
                        cleanFields()
                        $('.item-rad')
                            .find('input[name=news_hour], input[name=news_duration]')
                            .removeAttr('disabled')
                        itemsRad.show('slow')
                        break
                    case "3": // Periodico
                        hideFields()
                        cleanFields()
                        $('.item-per')
                            .find('input[name=page_number], input[name=page_size], select[name=page_type_id]')
                            .removeAttr('disabled')
                        itemsPer.show('slow')
                        break
                    case "4": // Revista
                        hideFields()
                        cleanFields()
                        $('.item-rev')
                            .find('input[name=page_number], input[name=page_size], select[name=page_type_id]')
                            .removeAttr('disabled')
                        itemsRev.show('slow')
                        break
                    case "5": // Internet
                        hideFields()
                        cleanFields()
                        $('.item-int')
                            .find('input[name=news_hour], input[name=url]')
                            .removeAttr('disabled')
                        itemsInt.show('slow')
                        break
                    default:
                        hideFields()
                        cleanFields()
                        // getItemsByMean(mean)
                        //code here
                }   
            }

            function cleanFields() {
                $('.item-input-clean').val('')
                    .attr('disabled', true)
                $('.item-select-clean').prop('selectedIndex','')
                    .attr('disabled', true)
            }

            function hideFields(){
                var itemsTV = $('.item-tv')
                var itemsRad = $('.item-rad')
                var itemsRev = $('.item-rev')
                var itemsPer = $('.item-per')
                var itemsInt = $('.item-int')

                itemsTV.hide()
                itemsRad.hide()
                itemsRev.hide()
                itemsPer.hide()
                itemsInt.hide()
            }

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
            })

            // Updating themes for the newsletters
            $('#select-newsletter').on('change', function () {
                var newsletterId = $(this).val()
                $.post("{{ route('api.getnewsletterthemeshtml') }}", { '_token': $('meta[name="csrf-token"]').attr('content'), 'newsletter_id': newsletterId }, function(res){
                    var divSelectThemes = $('#div-select-nesletter-themes').html(res)
                    divSelectThemes.find('#select-newsletter-themes').select2()
                }).fail(function(res){
                    var divSelectThemes = $('#div-select-nesletter-themes').html(`<p>No se pueden obtener los temas del bloque</p>`)
                    console.error(`Error-Sections: ${res.responseJSON.message}`)
                })
            })

            // Checked for newsletter
            $('#input-check-newsletter').on('click', function(){
                var isChecked = $(this).is(':checked')
                if(isChecked) {
                    $('select[name=newsletter_id]#select-newsletter').removeAttr('disabled')
                    $('#newsletters-items').show('slow')
                } else {
                    $('#newsletters-items').hide('slow')
                    $('select[name=newsletter_id]#select-newsletter')
                        .attr('disabled', true)
                        .prop('selectedIndex', '')
                    $('select[name=newsletter_theme_id]#select-newsletter-themes').attr('disabled', true)
                    $('#div-select-nesletter-themes').html('')
                }
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