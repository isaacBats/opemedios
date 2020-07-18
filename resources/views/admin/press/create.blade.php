@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Agregar una portada') }}</h4>
            </div>
            <div class="panel-body">
                <hr>
                <form action="{{ route('admin.press.add') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="select-cover-type" class="col-sm-3 control-label">{{ __('Tipo de portada') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="select-cover-type" name="cover_type" required>
                                <option value="">{{ __('Selecciona el tipo de portada') }}</option>
                                @foreach($coverTypes as $key => $cover)
                                    <option value="{{ $key }}">{{ $cover }}</option>
                                @endforeach
                            </select>
                            @error('cover_type')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Titulo') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control item-input-clean" disabled>
                            @error('title')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group hidden column" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Autor') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="author" class="form-control item-input-clean" disabled>
                            @error('author')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column cover" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Fecha') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control item-input-clean" id="input-date-cover" placeholder="dd-mm-yyyy" name="date_cover" value="{{ old('date_cover') }}" disabled>
                                <div class="input-group-addon">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @error('date_cover')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column cover" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Fuente') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="select-source" name="source_id" disabled>
                                <option value="">{{ __('Selecciona una fuente') }}</option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                @endforeach
                            </select>
                            @error('source_id')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Contenido') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <textarea name="content" id="textarea-content" class="form-control" cols="30" rows="10" disabled></textarea>
                            @error('content')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column cover" style="display: none;">
                        <label class="col-sm-3 control-label">{{ __('Imagen') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" name="image" disabled>
                            @error('image')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3 text-right">
                            <input type="submit" class="btn btn-primary btn-lg" value="{{ __('Crear') }}">
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/timepicker/timepicker.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('lib/timepicker/timepicker.css') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // settings select2
            $('#select-source').select2()

            // settings datepicker
            $('#input-date-cover').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            })

            function getItemsByCover(cover) {

                var itemsCover = $('.cover')
                var itemsColumn = $('.column')

                switch(cover) {
                    case "1":  // Primeras Planas
                    case "2": // Portadas Financieras
                    case "5": // Cartones
                        // hideFields()
                        // cleanFields()
                        // $('.item-rad')
                        //     .find('input[name=news_hour], input[name=news_duration]')
                        //     .removeAttr('disabled')
                        itemsCover.show('slow')
                        break
                    case "3": // Columnas politicas
                    case "4": // Columnas financieras
                        // hideFields()
                        // cleanFields()
                        // $('.item-rev')
                        //     .find('input[name=page_number], input[name=page_size], select[name=page_type_id]')
                        //     .removeAttr('disabled')
                        itemsColumn.show('slow')
                        break
                    default:
                        // hideFields()
                        // cleanFields()
                        // getItemsByMean(mean)
                        //code here
                }   
            }

            // disabled and hide items
            // $('.column').each(function(index, element) {
            //     var input = element.getElementsByTagName('input')
            //     if(input.length > 0)
            //         input[0].setAttribute('disabled', true)

            //     var select = element.getElementsByTagName('select')
            //     if(select.length > 0)
            //         select[0].setAttribute('disabled', true)

            //     var textarea = element.getElementsByTagName('textarea')
            //     if(textarea.length > 0)
            //         textarea[0].setAttribute('disabled', true)
            // })

            // Select cover type
            $('#select-cover-type').on('change', function(){
                var coverId = $(this).val()
                getItemsByCover(coverId) 
                // var coverType = $(this).val()
                // var itemsColumns = $('.column')
                // var itemsCovers = $('.cover')
                // if(coverType == 1 || coverType == 2 || coverType == 5) {
                //     itemsColumns.each(function(index, element){
                //         element.classList.remove('hidden')
                //     })
                // } else if(coverType == 3 || coverType == 4) {
                //     itemsCovers.each(function(index, element){
                //         element.classList.remove('hidden')
                //     })
                // }
            })

             function cleanFields() {
                $('.item-input-clean').val('')
                    .attr('disabled', true)
                $('.item-select-clean').prop('selectedIndex','')
                    .attr('disabled', true)
            }
        })
    </script>
@endsection