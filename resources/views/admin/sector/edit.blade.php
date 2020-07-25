@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Editar Sector') }}</h4>
                <hr>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.sector.update', ['id' => $sector->id]) }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ __('Nombre') }}<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nombre del sector" value="{{ old('name', $sector->name) }}" required />
                        </div>
                        @error('name')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ __('Descripción') }}<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <textarea name="description" class="form-control" cols="30" rows="10" required >{!! old('description', $sector->description) !!}</textarea>
                        </div>
                        @error('description')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ __('Activar / Desactivar') }}</label>
                        <div class="col-sm-8">
                            <input type="checkbox" class="from-control" {{ $sector->active == 1 ? 'checked' : '' }} value="1" name="active">
                        </div>
                        @error('description')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-11 text-right">
                            <input type="submit" value="Actualizar" class="btn btn-primary btn-lg">
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
@endsection