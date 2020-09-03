@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __("Configuración para newsletter {$newsletter->name}") }}</h4>
                </div>
                <div class="panel-body">
                    @if($newsletter->banner)
                        <img class="img-responsive" src="{{ asset("images/{$newsletter->banner}") }}" alt="{{ $newsletter->name }}">
                    @else
                        <div class="rectangle-banner">Banner</div>
                    @endif
                    <div class="col-md-4 col-md-offset-4 mt-3" style="margin-top: 2em;">
                        <button id="btn-up-banner" class="btn btn-primary btn-lg btn-block">{{ __('Cambiar Banner') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // modal for change banner
            $('#btn-up-banner').on('click', function(){
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('admin.newsletter.update.banner', ['id' => $newsletter->id]) }}')
                form.attr('method', 'POST')
                form.attr('enctype', 'multipart/form-data')
                form.append($('<input>').attr('type', 'hidden').attr('name', 'source').val({{ $newsletter->id }}))

                modal.find('.modal-title').text("{{ __('Cambiar Banner') }}")
                modal.find('#md-btn-submit').val("{{ __('Actualizar Banner') }}")
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>{{ __('Banner') }}</label>
                        <input type="file" name="banner">
                    </div>
                `)
                modal.modal('show')
            })
        })
    </script>
@endsection
