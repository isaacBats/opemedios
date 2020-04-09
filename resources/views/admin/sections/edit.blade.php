@extends('layouts.admin')
@section('content')
    <form action="{{ route('section.edit', ['id' => $section->id]) }}" method="POST" class="form-horizontal">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ __('Editar la sección de: ') }} {{ $section->name }} {{ __(' de la fuente: ') }} {{ $section->source->name }}
                    </h4>
                </div>
                <div class="panel-body">
                    <hr>
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre de la sección<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nombre de la sección" value="{{ old('name', $section->name) }}" required />
                        </div>
                        @error('name')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Autor</label>
                        <div class="col-sm-8">
                            <input type="text" name="author" class="form-control" placeholder="Autor, Conductor, Locutor, etc..." value="{{ old('author', $section->author) }}" />
                        </div>
                        @error('author')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea name="description" class="form-control" id="" cols="30" rows="10">{{{ old('description', $section->description) }}}</textarea>
                        </div>
                        @error('description')
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
                <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-pencil"></i> {{ __('Actualizar Sección') }}</button>
                <button class="btn btn-danger btn-lg btn-block"><i class="fa fa-remove"></i> {{ __('Cancelar') }}</button>
            </div>
        </div>
    </form>
@endsection