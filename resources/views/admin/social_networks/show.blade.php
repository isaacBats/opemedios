@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row panel-show-social_network">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ $social_network->name }}</h4>
                </div>
                <div class="panel-body">
                    <h1>{{ $social_network->name }}</h1>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <div class="fm-sidebar">
                <button class="btn btn-success btn-lg btn-block btn-show-form"><i class="fa fa-pencil"></i> {{ __('Editar red social') }}</button>
                <button class="btn btn-danger btn-lg btn-block btn-delete-social_network" data-social_network="{{ $social_network->id }}" data-name="{{ $social_network->name }}" ><i class="fa fa-trash"></i> {{ __('Eliminar red social') }}</button>
            </div>
        </div>
    </div>
    <div class="row panel-form-edit-social_network" style="display: none;">
        <form action="{{ route('social_network.update', ['id' => $social_network->id]) }}" method="POST" class="form-horizontal">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            {{ __('Editar') }} {{ $social_network->name }}
                        </h4>
                    </div>
                    <div class="panel-body">
                        <hr>
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre de la red social<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la red social" value="{{ old('name', $social_network->name) }}" required />
                            </div>
                            @error('name')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="fm-sidebar">
                    <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-pencil"></i> {{ __('Actualizar red social') }}</button>
                    <button class="btn btn-danger btn-lg btn-block btn-hide-form"><i class="fa fa-remove"></i> {{ __('Cancelar') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // show form for edit the social_network
            $('.btn-show-form').on('click', function (event) {
                event.preventDefault()
                var principal_panel = $('.panel-show-social_network')
                var form_panel = $('.panel-form-edit-social_network')

                principal_panel.hide('slow')
                form_panel.show('slow')
            })

            // show view social_network
            $('.btn-hide-form').on('click', function(event) {
                event.preventDefault()
                var principal_panel = $('.panel-show-social_network')
                var form_panel = $('.panel-form-edit-social_network')

                principal_panel.show('slow')
                form_panel.hide('slow')  
            })


            // Modal for delete social_network
            $('.btn-delete-social_network').on('click', function(event){
                event.preventDefault()
                var sourceId = $(this).data('social_network')
                var sourceName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('social_network.delete', ['id' => $social_network->id]) }}')
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar red social`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${sourceName}</strong>?`)
                modal.modal('show')
            })

        })
    </script>
@endsection