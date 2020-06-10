@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title" style="padding: 12px 0;">{{ __('Adjuntos de ') . $note->title }}</h4>
            </div>
            <div class="panel-body">
                <div class="row item-note">
                    <h2><strong>{{ __('Archivo Principal') }}</strong></h2>
                    <div class="col-md-12">
                        <div class="embed-responsive embed-responsive-16by9">
                            {!! $fileTemplate !!}
                        </div>
                    </div>
                </div>
                @if($note->files->count() > 0 )
                    <div class="row item-note">
                        @foreach($note->files->where('main_file', '!=', 1) as $file)
                            @if($file->main_file != 1)
                                <div class="col-sm-12 col-md-4">
                                    <div class="embed-responsive embed-responsive-4by3">
                                        {!! $_mediaController->template($file) !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                <div class="row item-note">
                    <form action="{{ route('admin.new.adjunto.upload', ['id' => $note->id]) }}" class="dropzone" method="POST" id="form-update-files" enctype="multipart/form-data">
                        @csrf
                        <div class="fallback">
                            <input name="files" type="file" multiple />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

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
            })

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
