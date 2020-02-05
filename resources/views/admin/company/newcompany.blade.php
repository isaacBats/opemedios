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
                            <select id="select1" name="turn" class="form-control">
                                <option value="">Seleccionan un Giro</option>
                                @foreach($turns as $turn)
                                    <option value="{{ $turn->id }}">{{ $turn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8">
                            <a href="{{ route('turn.create') }}" >
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
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-success btn-quirk btn-wide mr5" type="submit">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-sm-5 col-md-12 col-lg-6">
                    <div class="panel panel-primary list-announcement">
                        <div class="panel-heading">
                            <h4 class="panel-title">Giro de la empresa</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select id="select1" name="turn" class="form-control">
                                    <option value="">Seleccionan un Giro</option>
                                    @foreach($turns as $turn)
                                        <option value="{{ $turn->id }}">{{ $turn->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="{{ route('turn.create') }}" >
                                <span id="add-turn">
                                    <i class="fa fa-plus-circle"></i>
                                </span>
                                Nuevo Giro
                            </a>
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
        $(function(){
            $('#select1').select2();
        })
    </script>
@endsection