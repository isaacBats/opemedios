@extends('layouts.admin')
@section('admin-title', ' - Nueva empresa')
@section('content')
    <form method="post" action="{{ route('company.create') }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading nopaddingbottom">
                    <h4 class="panel-title">Nueva empresa</h4>
                    <p>Ingresa los datos de la nueva empresa</p>
                </div>
                <div class="panel-body">
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre de la empresa<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nombre de la empresa" value="{{ old('name') }}" required />
                        </div>
                        @error('name')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Direcci&oacute;n<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="address" class="form-control" placeholder="Direcci&oacute;n de la empresa" value="{{ old('address') }}" required />
                        </div>
                        @error('address')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Giro<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select id="select-turn" name="turn_id" class="form-control" style="width: 100%;">
                                <option value="">Seleccionan un Giro</option>
                                @foreach($turns as $turn)
                                    <option value="{{ $turn->id }}">{{ $turn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('turn_id')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8">
                            <a id="btn-add-turn" href="{{ route('admin.turns.ajaxcreate') }}" >
                                <span id="add-turn">
                                    <i class="fa fa-plus-circle"></i>
                                </span>
                                Nuevo Giro
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Logo de la empresa<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" name="logo" class="form-control" required>
                        </div>
                    </div>
                    <hr>
                    <h4 class="panel-title">Propiedades Digitales</h4>
                    <div class="form-group">
                        <label for="social_facebook" class="col-sm-3 control-label">Facebook</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="https://..." class="form-control" name="digital_properties[face]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_instagram" class="col-sm-3 control-label">Instagram</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="https://..." class="form-control" name="digital_properties[insta]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_twitter" class="col-sm-3 control-label">Twitter</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="https://..." class="form-control" name="digital_properties[twitter]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_linkedin" class="col-sm-3 control-label">LinkedIn</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="https://..." class="form-control" name="digital_properties[linked]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_web" class="col-sm-3 control-label">Pagina Web</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="https://..." class="form-control" name="digital_properties[web]">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-success btn-quirk btn-wide mr5" type="submit">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <style>
        #add-turn {
            color: red;
            font-size: 20px;
            margin-top: 10px;
        }
        .tooltiptext-leftarrow::after {
              content: " ";
              position: absolute;
              top: 50%;
              right: 100%; /* To the left of the tooltip */
              margin-top: -5px;
              border-width: 5px;
              border-style: solid;
              border-color: transparent black transparent transparent;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('#select-turn').select2();

            $('#btn-add-turn').on('click', function(event) {
                event.preventDefault()
                var modal = $('#modal-default')
                var modalForm = $('#modal-default-form')
                
                modal.find('.modal-title').html('Agregar nuevo Giro')

                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label for="turn-name">Giro</label>
                        <input type="text" name="name" id="turn-name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="turn-description">Descripción</label>
                        <textarea name="description" class="form-control" id="turn-description">{{old('description')}}</textarea>
                    </div>
                `)

                modalForm.attr('action', $(this).attr('href'))
                modalForm.attr('method', 'POST')

                modal.find('#md-btn-submit').val('Agregar nuevo')

                modal.modal('show')
            })

            $('#modal-default-form').on('submit', function (event){
                event.preventDefault()
                var modal = $('#modal-default')
                var actionurl = event.currentTarget.action
                modal.modal('hide')
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: $("#modal-default-form").serialize(),
                    success: function(data) {
                        
                        var selectTurn = $('#select-turn')
                        selectTurn.append(`<option value="${data.id}" selected>${data.name}</option>`)
                        selectTurn.trigger('change')
                    },
                    error: function(err) {
                        console.error(err)
                    }
                })

            })
        })
    </script>
@endsection