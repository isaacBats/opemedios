@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-10 col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    {{ $theme->name }}
                </h4>
            </div>
            <div class="panel-body" id="panel-body-theme">
                <p id="theme-description">
                    {{ $theme->description }}
                </p>
                <div class="row" id="form-edit-theme" style="display: none;">
                    <form action="{{ route('theme.update', ['id' => $theme->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="theme">Tema</label>
                            <input type="text" id="theme" name="name" class="form-control" value="{{ $theme->name }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $theme->description }}</textarea>
                        </div>
                        <input type="submit" class="btn btn-primary pull-right" value="Actualizar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2">
        <a href="javascript:void(0)" id="btn-edit" class="btn btn-success btn-block">Editar</a>
        <a href="javascript:void(0)" data-theme="{{ $theme->id }}" data-name="{{ $theme->name }}"  id="btn-delete" class="btn btn-danger btn-block">Eliminar</a>
        <a href="{{ route('company.show', ['id' => $theme->company->id ]) }}" class="btn btn-default btn-block">Regresar</a>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // edit Theme
            $('#btn-edit').on('click', function(event) {
                event.preventDefault()

                var description = $('#theme-description')
                var form = $('#form-edit-theme')
                var btnEdit = $(this)
                
                description.hide()
                btnEdit.hide()
                form.show()
            })

            // delete theme
            $('#btn-delete').on('click', function(event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var themeID = $(this).data('theme')
                var themeName = $(this).data('name')

                form.attr('method', 'POST')
                    .attr('action', `/panel/tema/eliminar/${themeID}`) 

                modal.find('.modal-title').html('Eliminar tema');
                modalBody.html(`<p>¿Estas seguro que quieres eliminar el tema: <strong>${themeName}</strong>?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Eliminar')

                modal.modal('show')
            })
        })
    </script>
@endsection