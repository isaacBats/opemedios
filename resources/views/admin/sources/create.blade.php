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
                <form action="{{ route('source.create') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
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
                            <select name="means_id" class="form-control" id="select-means">
                                <option value="">Seleccionan un tipo de fuente</option>
                                @foreach($means as $type)
                                    {{-- <option value="{{ $type->id }}" {{ (old("means_id") == $type->id ? "selected":"") }} >{{ $type->name }}</option> --}}
                                    <option value="{{ $type->id }}" >{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('means_id')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group fn-internet" style="display: none;">
                        <label class="col-sm-3 control-label">Url del portal</label>
                        <div class="col-sm-8">
                            <input id="input-int-url" type="url" name="url" class="form-control input-clean" placeholder="https://example.com" value="{{ old('url') }}" disabled />
                        </div>
                        @error('url')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group fn-periodico" style="display: none;">
                        <label class="col-sm-3 control-label">Tiraje</label>
                        <div class="col-sm-8">
                            <input id="input-per" type="text" name="printing_per" class="form-control input-clean" placeholder="Tiraje" value="{{ old('printing_per') }}" disabled />
                        </div>
                        @error('printing_per')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="fn-radio" style="margin-bottom: 20px; display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Conductor</label>
                            <div class="col-sm-8">
                                <input type="text" name="conductor" class="form-control input-clean input-rd" placeholder="Conductor" value="{{ old('conductor') }}" disabled />
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
                                <input type="text" name="station" class="form-control input-clean input-rd" placeholder="Estación" value="{{ old('station') }}" disabled />
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
                                <input type="text" name="schedule" class="form-control input-clean input-rd" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule') }}" disabled />
                            </div>
                            @error('schedule')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group fn-revista" style="display: none;">
                        <label class="col-sm-3 control-label">Tiraje</label>
                        <div class="col-sm-8">
                            <input id="input-rev" type="text" name="printing_rev" class="form-control input-clean" placeholder="Tiraje" value="{{ old('printing_rev') }}" disabled />
                        </div>
                        @error('printing_rev')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="fn-tele" style="margin-bottom: 20px; display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Conductor</label>
                            <div class="col-sm-8">
                                <input type="text" name="conductor_tv" class="form-control input-clean input-tv" placeholder="Conductor" value="{{ old('conductor_tv') }}" disabled />
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
                                <input type="text" name="channel" class="form-control input-clean input-tv" placeholder="Canal" value="{{ old('channel') }}" disabled />
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
                                <input type="text" name="schedule_tv" class="form-control input-clean input-tv" placeholder="Ejemplo: 7:00 - 8:00 AM" value="{{ old('schedule_tv') }}" disabled />
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
                                <select name="signal" class="form-control select-clean input-tv" disabled >
                                    <option value="">Señal</option>
                                    <option value="Televisión Abierta" {{ (old("signal") == 'Televisión Abierta' ? "selected":"") }}>Televisión Abierta</option>
                                    <option value="Cablevisión" {{ (old("signal") == 'Cablevisión' ? "selected":"") }}>Cablevisión</option>
                                    <option value="Sky" {{ (old("signal") == 'Sky' ? "selected":"") }}>Sky</option>
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
                                <option value="Local" {{ (old("coverage") == 'Local' ? "selected":"") }}>Local</option>
                                <option value="Nacional" {{ (old("coverage") == 'Nacional' ? "selected":"") }}>Nacional</option>
                                <option value="Internacional" {{ (old("coverage") == 'Internacional' ? "selected":"") }}>Internacional</option>
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
                            <textarea rows="5" name="comment" class="form-control" placeholder="Comentario">{{{ old('comment') }}}</textarea>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // extra fields
            $('#select-means').on('change', function() {
                var value = $(this).val()
                var means = $('#select-means option:selected').text()
                var fieldsTV = $('.fn-tele')
                var fieldsRD = $('.fn-radio')
                var fieldsPR = $('.fn-periodico')
                var fieldsRV = $('.fn-revista')
                var fieldsIN = $('.fn-internet')
                
                switch (value) {
                    case "1":
                        hidenFields()
                        cleanFields()
                        $('.input-tv').removeAttr('disabled')
                        fieldsTV.show('slow')
                        break
                    case "2":
                        hidenFields()
                        cleanFields()
                        $('.input-rd').removeAttr('disabled')
                        fieldsRD.show('slow')
                        break
                    case "3":
                        hidenFields()
                        cleanFields()
                        $('#input-per').removeAttr('disabled')
                        fieldsPR.show('slow')
                        break
                    case "4":
                        hidenFields()
                        cleanFields()
                        $('#input-rev').removeAttr('disabled')
                        fieldsRV.show('slow')
                        break
                    case "5":
                        hidenFields()
                        cleanFields()
                        $('#input-int-url').removeAttr('disabled')
                        fieldsIN.show('slow')
                        break
                    default:
                        hidenFields()
                        cleanFields()
                }
            })
            
            // hide inputs
            function hidenFields() {
                var fieldsTV = $('.fn-tele')
                var fieldsRD = $('.fn-radio')
                var fieldsPR = $('.fn-periodico')
                var fieldsRV = $('.fn-revista')
                var fieldsIN = $('.fn-internet')

                fieldsTV.hide()
                fieldsRD.hide()
                fieldsPR.hide()
                fieldsRV.hide()
                fieldsIN.hide()
            }
            
            // clean inputs
            function cleanFields() {
                $('.input-clean').val('')
                    .attr('disabled', true)
                $('.select-clean').prop('selectedIndex','')
                    .attr('disabled', true)
            }
        })


    </script>
@endsection