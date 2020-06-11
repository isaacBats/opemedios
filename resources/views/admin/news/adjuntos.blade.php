@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title" style="padding: 12px 0;">{{ __('Adjuntos de ') . $note->title }}</h4>
            </div>
            <div class="panel-body">
                <div class="row item-note" id="main-file-content">
                    <h2><strong>{{ __('Archivo Principal') }}</strong></h2>
                    <hr>
                    <div class="col-md-12">
                        @if($main_file = $note->files->where('main_file', 1)->first())
                            <div class="embed-responsive embed-responsive-16by9">
                                {!! $main_file->getHTML() !!}
                            </div>
                            <p class="text-right"><a class="btn btn-danger btn-sm" id="btn-remove-main-file" data-news="{{$note->id}}" data-file="{{ $main_file->id }}" data-name="{{ $main_file->original_name }}" href="{{ route('admin.new.adjunto.remove') }}">{{ __('Eliminar') }}</a></p>
                        @else
                            <p class="text-center">{{ __('Esta nota aun no contiene un archivo principal') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row item-note" id="list-files-content">
                    @if($note->files->where('main_file', '!=', 1)->count() > 0)
                        <h3>{{ __('Otros archivos adjuntos a esta nota') }}</h3>
                        <hr>
                        @foreach($note->files->where('main_file', '!=', 1) as $file)
                            <div class="col-sm-12 col-md-4 text-center">
                                <div class="embed-responsive embed-responsive-4by3">
                                    {!! $file->getHTML() !!}
                                </div>
                                <br>
                                <p><strong>{{ $file->original_name }}</strong></p>
                                <p><a class="btn btn-danger btn-sm btn-remove-file" data-news="{{ $note->id }}" data-file="{{ $file->id }}" data-name="{{ $file->original_name }}" href="javascript:void(0)">{{ __('Eliminar') }}</a> <a class="btn btn-info btn-sm" href="{{ route('admin.new.adjunto.main', ['news' => $note->id, 'file' => $file->id]) }}">{{ __('Marcar como principal') }}</a></p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row item-note" id="row-btn-update-files">
                    <div class="col-sm-12 col-md-8 col-md-offset-2">
                        <button class="btn btn-success btn-block btn-lg" id="btn-update-files">{{ _('Subir archivos') }}</button>
                    </div>
                </div>
                <div class="row item-note" style="display: none;" id="row-form-update-files">
                    <form action="{{ route('admin.new.adjunto.upload', ['id' => $note->id]) }}" class="dropzone" method="POST" id="form-update-files" enctype="multipart/form-data">
                        @csrf
                        <div class="fallback">
                            <input name="files" type="file" multiple />
                        </div>
                    </form>
                    <br>
                    <div class="col-sm-12 col-md-12 text-right">
                        <a href="javascript:void(0)" class="btn btn-danger btn-lg" id="btn-cancel-upload-files">{{ __('Cancelar') }}</a>
                        <a href="{{ route('admin.new.adjunto.show', ['id' => $note->id]) }}" class="btn btn-default btn-lg">{{ __('Guardar') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            // show form for upload files
            $('#btn-update-files').on('click', function(){
                $('#main-file-content').hide('fast')
                $('#list-files-content').hide('fast')
                $('#row-btn-update-files').hide('fast')
                $('#row-form-update-files').show('slow')
            })

            // cancel upload files
            $('#btn-cancel-upload-files').on('click', function(){
                $('#main-file-content').show('slow')
                $('#list-files-content').show('slow')
                $('#row-btn-update-files').show('slow')
                $('#row-form-update-files').hide('fast')
            })

            //Upload file
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#form-update-files",{
                url: $('#form-update-files').attr('action'),
                paramName: 'files',
                maxFilesize: 64, // MB
                addRemoveLinks: true,
                dictDefaultMessage : '<span class="bigger-150 bolder"><i class=" fa fa-caret-right red"></i> Arrastra los archivos</span> para subirlos <span class="smaller-80 grey">(o da click)</span> <br /><i class="upload-icon fa fa-cloud-upload blue fa-3x"></i>',
                dictResponseError: 'Error while uploading file!',
                uploadMultiple: true,
                createImageThumbnails: true,
                maxThumbnailFilesize: 10,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                thumbnailMethod: 'crop',
                maxFiles: 5,
                parallelUploads: 5,
                // successmultiple: function(file, resp) {

                //     if($('#list-files-content').length > 0) { // el content para los archivos adjuntos existe

                //     } else { // El content no existe
                //         $('#main-file-content').after($('<div>', {
                //             'class': 'row item-note',
                //             'id': 'list-files-content'})
                //             .append($('<h3>', { 'text': 'Otros archivos adjuntos a esta nota' }))
                //             .append($('<br />'))
                //             .append(getHTMLContentFiles(resp.files))
                //         )

                //     }
                //     var formCreateNews = $('#form-create-new-news')
                //     formCreateNews.append($('<input>').attr('type', 'hidden').attr('name', 'files').attr('value', resp.files))
                //  }
            })

            // delete files
            $('#list-files-content').on('click', 'a.btn-remove-file', removeFile)

            $('#btn-remove-main-file').on('click', removeFile)

            function removeFile(event) {
                event.preventDefault()

                var fileName = $(this).data('name')
                var news = $(this).data('news')
                var file = $(this).data('file')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = "{{ route('admin.new.adjunto.remove') }}"
                
                form.attr('action', urlAction)
                form.attr('method', 'POST')
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'news',
                    'value': news 
                })).append($('<input>', {
                    'type': 'hidden',
                    'name': 'file',
                    'value': file 
                }))

                modal.find('.modal-title').text(`Eliminar archivo`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar el archivo ') }}<strong>${fileName}</strong>?`)
                modal.modal('show')  
            }
        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/dropzone/dropzone.css') }}">
    <style>
        .row.item-note {
            margin-bottom: 20px;
        }
    </style>
@endsection
