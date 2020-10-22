@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ __('Guardar portadas y columnas para newsletters') }}
                    </h4>
                </div>
                <div class="panel-body">
                    <hr>
                    <form action="{{ route('admin.newsletter.config.add.footer') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Primeras Planas<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="primeras_planas" class="form-control" placeholder="https://..." value="{{ old('primeras_planas') }}" required />
                            </div>
                            @error('primeras_planas')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portadas Financieras<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="portadas_financieras" class="form-control" placeholder="https://..." value="{{ old('portadas_financieras') }}" required />
                            </div>
                            @error('portadas_financieras')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Columnas Financieras<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="columnas_financieras" class="form-control" placeholder="https://..." value="{{ old('columnas_financieras') }}" required />
                            </div>
                            @error('columnas_financieras')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portadas Políticas<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="portadas_politicas" class="form-control" placeholder="https://..." value="{{ old('portadas_politicas') }}" required />
                            </div>
                            @error('portadas_politicas')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cartones<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="cartones" class="form-control" placeholder="https://..." value="{{ old('cartones') }}" required />
                            </div>
                            @error('cartones')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group text-right">
                            <input type="submit" value="Guardar" class="btn btn-success btn-quirk btn-wide mr5">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection