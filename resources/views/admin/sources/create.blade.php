@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    {{ __('Crear nueva fuente') }}
                </h4>
                <p>{{ __('La medida del logo debe de ser de 300 x 150') }}</p>
            </div>
            <div class="panel-body">
                <hr>
                <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre de la fuente<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nombre de la fuente" value="{{ old('name') }}" required />
                        </div>
                        @error('name')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Empresa a la que pertenece</label>
                        <div class="col-sm-8">
                            <input type="text" name="company" class="form-control" placeholder="Empresa" value="{{ old('company') }}" />
                        </div>
                        @error('company')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Medio<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="means_id" class="form-control">
                                <option value="">Seleccionan un tipo de fuente</option>
                                @foreach($means as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('means_id')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group fn-internet">
                        <label class="col-sm-3 control-label">Url del portal</label>
                        <div class="col-sm-8">
                            <input type="text" name="url" class="form-control" placeholder="Empresa" value="{{ old('url') }}" />
                        </div>
                        @error('url')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group fn-periodico">
                        <label class="col-sm-3 control-label">Tiraje</label>
                        <div class="col-sm-8">
                            <input type="text" name="printing_per" class="form-control" placeholder="Tiraje" value="{{ old('printing_per') }}" />
                        </div>
                        @error('printing_per')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="fn-radio" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Conductor</label>
                            <div class="col-sm-8">
                                <input type="text" name="conductor" class="form-control" placeholder="Conductor" value="{{ old('conductor') }}" />
                            </div>
                            @error('conductor')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Estación</label>
                            <div class="col-sm-8">
                                <input type="text" name="station" class="form-control" placeholder="Estación" value="{{ old('station') }}" />
                            </div>
                            @error('station')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Horario</label>
                            <div class="col-sm-8">
                                <input type="text" name="schedule" class="form-control" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule') }}" />
                            </div>
                            @error('schedule')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group fn-revista">
                        <label class="col-sm-3 control-label">Tiraje</label>
                        <div class="col-sm-8">
                            <input type="text" name="printing_rev" class="form-control" placeholder="Tiraje" value="{{ old('printing_rev') }}" />
                        </div>
                        @error('printing_rev')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="fn-tele" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Conductor</label>
                            <div class="col-sm-8">
                                <input type="text" name="conductor_tv" class="form-control" placeholder="Conductor" value="{{ old('conductor_tv') }}" />
                            </div>
                            @error('conductor_tv')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Canal</label>
                            <div class="col-sm-8">
                                <input type="text" name="channel" class="form-control" placeholder="Canal" value="{{ old('channel') }}" />
                            </div>
                            @error('channel')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Horario</label>
                            <div class="col-sm-8">
                                <input type="text" name="schedule_tv" class="form-control" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule_tv') }}" />
                            </div>
                            @error('schedule_tv')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Señal</label>
                            <div class="col-sm-8">
                                <select name="signal" class="form-control">
                                    <option value="">Señal</option>
                                    <option value="Televisión Abierta">Televisión Abierta</option>
                                    <option value="Cablevisión">Cablevisión</option>
                                    <option value="Sky">Sky</option>
                                </select>
                            </div>
                            @error('signal')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cobertura<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="coverage" class="form-control">
                                <option value="">Cobertura</option>
                                <option value="Local">Local</option>
                                <option value="Nacional">Nacional</option>
                                <option value="Internacional">Internacional</option>
                            </select>
                        </div>
                        @error('coverage')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Comentario</label>
                        <div class="col-sm-8">
                            <textarea rows="5" name="comment" class="form-control" placeholder="Comentario"></textarea>
                        </div>
                        @error('comment')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Logo</label>
                        <div class="col-sm-8">
                            <input type="file" name="logo" class="form-control">
                        </div>
                        @error('logo')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-sm-11 text-right">
                            <input type="submit" value="Crear" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection