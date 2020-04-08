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
    <div class="row panel-show-source">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ $source->name }}</h4>
                </div>
                <div class="panel-body">
                    <h1>{{ $source->name }}</h1>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="{{ asset("images/$source->logo") }}" class="img-responsive" alt="{{ $source->name }}">    
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <strong>{{ __('Nombre') }}:</strong> {{ $source->name }} <br>
                            <strong>{{ __('Empresa') }}:</strong> {{ $source->company }} <br>
                            <strong>{{ __('Covertura') }}:</strong> {{ $source->coverage }} <br>
                            @foreach(unserialize($source->extra_fields) as $label => $extra)
                                <strong>{{ $label }}:</strong>{{ $extra }} <br>
                            @endforeach
                            <strong>{{ __('Comentarios') }}:</strong> {{{ $source->comment }}} <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                            <h4 class="panel-title">{{ __('Secciones') }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                            <a href="javascript:void(0)" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva Sección') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <div class="fm-sidebar">
                <button class="btn btn-warning btn-lg btn-block btn-edit-logo" data-source="{{ $source->id }}" ><i class="fa fa-image"></i> {{ __('Editar Logo') }}</button>
                <button class="btn btn-success btn-lg btn-block btn-show-form"><i class="fa fa-pencil"></i> {{ __('Editar Fuente') }}</button>
                <button class="btn btn-danger btn-lg btn-block"><i class="fa fa-trash"></i> {{ __('Eliminar Fuente') }}</button>
            </div>
        </div>
    </div>
    <div class="row panel-form-edit-source" style="display: none;">
        <form action="{{ route('source.update', ['id' => $source->id]) }}" method="POST" class="form-horizontal">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            {{ __('Editar') }} {{ $source->name }}
                        </h4>
                    </div>
                    <div class="panel-body">
                        <hr>
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre de la fuente<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la fuente" value="{{ old('name', $source->name) }}" required />
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
                                <input type="text" name="company" class="form-control" placeholder="Empresa" value="{{ old('company', $source->company) }}" />
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
                                <select name="means_id" class="form-control" id="select-means" disabled>
                                    <option value="">Seleccionan un tipo de fuente</option>
                                    @foreach($means as $type)
                                        {{-- <option value="{{ $type->id }}" {{ (old("means_id") == $type->id ? "selected":"") }} >{{ $type->name }}</option> --}}
                                        <option value="{{ $type->id }}" {{ ($type->id == $source->means_id ? 'selected' : '')}} >{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('means_id')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                        @if($source->mean->short_name == 'int')
                            <div class="form-group fn-internet">
                                <label class="col-sm-3 control-label">Url del portal</label>
                                <div class="col-sm-8">
                                    <input id="input-int-url" type="url" name="url" class="form-control input-clean" placeholder="https://example.com" value="{{ old('url', $extras['Url']) }}" />
                                </div>
                                @error('url')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        @elseif($source->mean->short_name == 'per')
                            <div class="form-group fn-periodico">
                                <label class="col-sm-3 control-label">Tiraje</label>
                                <div class="col-sm-8">
                                    <input id="input-per" type="text" name="printing_per" class="form-control input-clean" placeholder="Tiraje" value="{{ old('printing_per', $extras['Tiraje']) }}" />
                                </div>
                                @error('printing_per')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        @elseif($source->mean->short_name == 'rad')
                            <div class="fn-radio" style="margin-bottom: 20px;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Conductor</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="conductor" class="form-control input-clean input-rd" placeholder="Conductor" value="{{ old('conductor', $extras['Conductor']) }}" />
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
                                        <input type="text" name="station" class="form-control input-clean input-rd" placeholder="Estación" value="{{ old('station', $extras['Estación']) }}" />
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
                                        <input type="text" name="schedule" class="form-control input-clean input-rd" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule', $extras['Horario']) }}" />
                                    </div>
                                    @error('schedule')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        @elseif($source->mean->short_name == 'rev')
                            <div class="form-group fn-revista">
                                <label class="col-sm-3 control-label">Tiraje</label>
                                <div class="col-sm-8">
                                    <input id="input-rev" type="text" name="printing_rev" class="form-control input-clean" placeholder="Tiraje" value="{{ old('printing_rev', $extras['Tiraje']) }}" />
                                </div>
                                @error('printing_rev')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        @elseif($source->mean->short_name == 'tel')
                            <div class="fn-tele" style="margin-bottom: 20px;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Conductor</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="conductor_tv" class="form-control input-clean input-tv" placeholder="Conductor" value="{{ old('conductor_tv', $extras['Conductor']) }}" />
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
                                        <input type="text" name="channel" class="form-control input-clean input-tv" placeholder="Canal" value="{{ old('channel', $extras['Canal']) }}" />
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
                                        <input type="text" name="schedule_tv" class="form-control input-clean input-tv" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule_tv', $extras['Horario']) }}" />
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
                                        <select name="signal" class="form-control select-clean input-tv" >
                                            <option value="">Señal</option>
                                            <option value="Televisión Abierta" {{ (old("signal", $extras['Señal']) == 'Televisión Abierta' ? "selected":"") }}>Televisión Abierta</option>
                                            <option value="Cablevisión" {{ (old("signal", $extras['Señal']) == 'Cablevisión' ? "selected":"") }}>Cablevisión</option>
                                            <option value="Sky" {{ (old("signal", $extras['Señal']) == 'Sky' ? "selected":"") }}>Sky</option>
                                        </select>
                                    </div>
                                    @error('signal')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cobertura<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="coverage" class="form-control">
                                    <option value="">Cobertura</option>
                                    <option value="Local" {{ (old("coverage", $source->coverage) == 'Local' ? "selected":"") }}>Local</option>
                                    <option value="Nacional" {{ (old("coverage", $source->coverage) == 'Nacional' ? "selected":"") }}>Nacional</option>
                                    <option value="Internacional" {{ (old("coverage", $source->coverage) == 'Internacional' ? "selected":"") }}>Internacional</option>
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
                                <textarea rows="5" name="comment" class="form-control" placeholder="Comentario">{{{ old('comment', $source->comment) }}}</textarea>
                            </div>
                            @error('comment')
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
                    <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-pencil"></i> {{ __('Actualizar Fuente') }}</button>
                    <button class="btn btn-danger btn-lg btn-block btn-hide-form"><i class="fa fa-remove"></i> {{ __('Cancelar') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // show form for edit the source
            $('.btn-show-form').on('click', function (event) {
                event.preventDefault()
                var principal_panel = $('.panel-show-source')
                var form_panel = $('.panel-form-edit-source')

                principal_panel.hide('slow')
                form_panel.show('slow')
            })

            // show view source
            $('.btn-hide-form').on('click', function(event) {
                event.preventDefault()
                var principal_panel = $('.panel-show-source')
                var form_panel = $('.panel-form-edit-source')

                principal_panel.show('slow')
                form_panel.hide('slow')  
            })

            // Modal to edit logo
            $('.btn-edit-logo').on('click', function (event){
                event.preventDefault()
                var sourceId = $(this).data('source')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('source.update.logo', ['id' => $source->id]) }}')
                form.attr('method', 'POST')
                form.attr('enctype', 'multipart/form-data')
                form.append($('<input>').attr('type', 'hidden').attr('name', 'source').val(sourceId))

                modal.find('.modal-title').text("{{ __('Cambiar Logo') }}")
                modal.find('#md-btn-submit').val("{{ __('Actualizar Logo') }}")
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>{{ __('Logo') }}</label>
                        <input type="file" name="logo" class="form-control">
                        <small>{{ __('La medida del logo debe de ser de 300 x 150') }}</small>
                    </div>
                `)
                modal.modal('show')

            })
        })
    </script>
@endsection