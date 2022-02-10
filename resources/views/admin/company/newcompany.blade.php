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
                        <label class="col-sm-3 control-label nopaddingtop">Subcuenta</label>
                        <div class="col-sm-9">
                            <label for="checkbox-parent" class="ckbox">
                                <input {{ $subAccount ? 'checked' : ''}} type="checkbox" id="checkbox-parent" name="is_parent" value="true">
                                <span>¿Esta empresa es una subcuenta?</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="div-select-parent" style="display: none;">
                        <label class="col-sm-3 control-label">Empresa Padre</label>
                        <div class="col-sm-8">
                            <select id="select-parent-company" name="parent" class="form-control" style="width: 100%;" disabled="disabled">
                                <option value="">Seleccionan la empresa padre</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('parent')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Logo de la empresa<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" name="logo" class="form-control" required>
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
            $('#select-parent-company').select2();

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

            if( $('#checkbox-parent').attr('checked') ) {
                const selectCompanies = $('select#select-parent-company');
                selectCompanies.prop('disabled', false);
                $('#div-select-parent').show('slow');
                selectCompanies.val('{{ $father->id }}');
                selectCompanies.trigger('change');

            }

            $('#checkbox-parent').on('change', function(){
                if($(this).is(':checked')) {
                    $('select#select-parent-company').prop('disabled', false);
                    $('#div-select-parent').show('slow');
                } else {
                    $('select#select-parent-company').prop('disabled', 'disabled');
                    $('select#select-parent-company option').prop('selected', false).trigger('change');
                    $('#div-select-parent').hide('fast');
                }
            });

        })
    </script>
@endsection