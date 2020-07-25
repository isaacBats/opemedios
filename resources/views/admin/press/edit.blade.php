@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-8 col-lg-8">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __("Editar ") }} {{ $coverType[$cover->cover_type] }}</h4>
            </div>
            <div class="panel-body">
                <hr>
                <form action="{{ route('admin.press.update', ['id' => $cover->id]) }}" class="form-horizontal" method="POST">
                    @csrf
                    @if($cover->cover_type == 3 || $cover->cover_type == 4)
                    <div class="form-group column">
                        <label class="col-sm-3 control-label">{{ __('Titulo') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control item-input-clean" value="{{ old('title', $cover->title) }}" required>
                            @error('title')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group column">
                        <label class="col-sm-3 control-label">{{ __('Autor') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="author" class="form-control item-input-clean" value="{{ old('author', $cover->author) }}" required>
                            @error('author')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="form-group column cover">
                        <label class="col-sm-3 control-label">{{ __('Fecha') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control item-input-clean" id="input-date-cover" placeholder="dd-mm-yyyy" name="date_cover" value="{{ old('date_cover', $cover->date_cover->format('d-m-Y')) }}">
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
                    <div class="form-group column cover">
                        <label class="col-sm-3 control-label">{{ __('Fuente') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="select-source" name="source_id" required>
                                <option value="">{{ __('Selecciona una fuente') }}</option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->id }}" {{ (old('source_id', $cover->source_id) == $source->id ? 'selected' : '') }}>{{ $source->name }}</option>
                                @endforeach
                            </select>
                            @error('source_id')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    @if($cover->cover_type == 3 || $cover->cover_type == 4)
                    <div class="form-group column">
                        <label class="col-sm-3 control-label">{{ __('Contenido') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <textarea name="content" id="textarea-content" class="form-control" cols="30" rows="10" required>{!! old('content', $cover->content) !!}</textarea>
                            @error('content')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3 text-right">
                            <input type="submit" class="btn btn-primary btn-lg" value="{{ __('Guardar') }}">
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Editar Archivo') }}</h4>
            </div>
            <div class="panel-body">
                <figure class="text-center">
                    <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->source->name }}" style="max-width: 100%;">
                    <figcaption class="text-right">
                        <a href="javascript:void(0);" class="btn btn-primary" data-cover="{{ $cover->id }}" id="btn-edit-file">{{ __('Cambiar Archivo') }}</a>
                    </figcaption>
                </figure>
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
            $('#select-source').select2({ width: '100%' })

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
                        hideFields()
                        $('#select-cover-type').each(function() {
                            $(this).val(cover); 
                        });
                        itemsCover.find('input[name=date_cover]').removeAttr('disabled').attr('required', true)
                        itemsCover.find('input[name=image]').removeAttr('disabled').attr('required', true)
                        itemsCover.find('#select-source').removeAttr('disabled').attr('required', true)
                        itemsCover.show('slow')
                        break
                    case "3": // Columnas politicas
                    case "4": // Columnas financieras
                        hideFields()
                        $('#select-cover-type').each(function() {
                            $(this).val(cover); 
                        });
                        itemsColumn.find('input[name=title]').removeAttr('disabled').attr('required', true)
                        itemsColumn.find('input[name=author]').removeAttr('disabled').attr('required', true)
                        itemsColumn.find('input[name=date_cover]').removeAttr('disabled').attr('required', true)
                        itemsColumn.find('input[name=image]').removeAttr('disabled').attr('required', true)
                        itemsColumn.find('#select-source').removeAttr('disabled').attr('required', true)
                        itemsColumn.find('#textarea-content').removeAttr('disabled').attr('required', true)
                        itemsColumn.show('slow')
                        break
                    default:
                        hideFields()
                }   
            }

            // Select cover type
            $('#select-cover-type').on('change', function(){
                var coverId = $(this).val()
                getItemsByCover(coverId) 
            })

            function hideFields(){
                $('.cover').hide()
                $('.column').hide()
                $('#form-add-cover').trigger('reset')
            }

            // Modal to edit file
            $('#btn-edit-file').on('click', function (event){
                event.preventDefault()
                var coverId = $(this).data('cover')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('admin.press.update.file', ['id' => $cover->id]) }}')
                form.attr('method', 'POST')
                form.attr('enctype', 'multipart/form-data')
                form.append($('<input>').attr('type', 'hidden').attr('name', 'cover').val(coverId))

                modal.find('.modal-title').text("{{ __('Cambiar Archivo') }}")
                modal.find('#md-btn-submit').val("{{ __('Actualizar Archivo') }}")
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>{{ __('Archivo') }}</label>
                        <input type="file" name="image">
                    </div>
                `)
                modal.modal('show')
            })
        })
    </script>
@endsection