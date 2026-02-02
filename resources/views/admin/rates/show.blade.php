@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Editar Tarifa') }} #{{ $rate->id }}</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('rate.update', ['id' => $rate->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select-type">Tipo de Tarifa <span class="text-danger">*</span></label>
                                <select class="form-control" id="select-type" name="type" required>
                                    <option value="">Selecciona un tipo</option>
                                    @foreach($types as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $rate->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" id="div-social-network" style="{{ $rate->type !== 'social' ? 'display: none;' : '' }}">
                            <div class="form-group">
                                <label for="select-social-network">Red Social</label>
                                <select class="form-control" id="select-social-network" name="social_network_id">
                                    <option value="">Selecciona una red social</option>
                                    @foreach($socialNetworks as $sn)
                                        <option value="{{ $sn->id }}" {{ old('social_network_id', $rate->social_network_id) == $sn->id ? 'selected' : '' }}>{{ $sn->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="div-content-type" style="{{ $rate->type !== 'social' ? 'display: none;' : '' }}">
                            <div class="form-group">
                                <label for="select-content-type">Tipo de Contenido</label>
                                <select class="form-control" id="select-content-type" name="content_type">
                                    <option value="">Selecciona tipo de contenido</option>
                                    @foreach($contentTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('content_type', $rate->content_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="div-source" style="{{ $rate->type === 'social' ? 'display: none;' : '' }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select-source">Fuente</label>
                                <select class="form-control" id="select-source" name="source_id">
                                    <option value="">Buscar fuente...</option>
                                    @if($rate->source)
                                        <option value="{{ $rate->source->id }}" selected>{{ $rate->source->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select-section">Sección</label>
                                <select class="form-control" id="select-section" name="section_id">
                                    <option value="">Selecciona una sección</option>
                                    @if($rate->section)
                                        <option value="{{ $rate->section->id }}" selected>{{ $rate->section->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input-min-value">Valor Mínimo <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="input-min-value" name="min_value" min="0" value="{{ old('min_value', $rate->min_value) }}" required>
                                <small class="text-muted">Seguidores / Visitas / Audiencia</small>
                                @error('min_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input-max-value">Valor Máximo</label>
                                <input type="number" class="form-control" id="input-max-value" name="max_value" min="0" value="{{ old('max_value', $rate->max_value) }}">
                                <small class="text-muted">Dejar vacío para sin límite</small>
                                @error('max_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input-price">Precio <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" class="form-control" id="input-price" name="price" min="0" step="0.01" value="{{ old('price', $rate->price) }}" required>
                                </div>
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if($rate->metadata)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Metadatos</label>
                                    <pre class="well">{{ json_encode($rate->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group text-right" style="margin-top: 30px;">
                        <a href="{{ route('rates') }}" class="btn btn-default btn-lg">Volver</a>
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar Tarifa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            var typeSelect = $('#select-type');
            var socialDiv = $('#div-social-network');
            var contentDiv = $('#div-content-type');
            var sourceDiv = $('#div-source');

            function toggleFields() {
                var type = typeSelect.val();

                if (type === 'social') {
                    socialDiv.show();
                    contentDiv.show();
                    sourceDiv.hide();
                } else if (type === 'internet' || type === 'radio' || type === 'tv' || type === 'print') {
                    socialDiv.hide();
                    contentDiv.hide();
                    sourceDiv.show();
                } else {
                    socialDiv.hide();
                    contentDiv.hide();
                    sourceDiv.hide();
                }
            }

            typeSelect.on('change', toggleFields);

            // Select2 for source search
            $('#select-source').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getsourceajax') }}",
                    dataType: 'json',
                    data: function(params) {
                        var meanId = 5;
                        var type = $('#select-type').val();
                        if (type === 'radio') meanId = 2;
                        else if (type === 'tv') meanId = 1;
                        else if (type === 'print') meanId = 3;

                        return {
                            q: params.term,
                            mean_id: meanId,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        };
                    },
                    processResults: function(data) {
                        return { results: data.items };
                    },
                    cache: true
                }
            });

            $('#select-source').on('change', function() {
                var sourceId = $(this).val();
                if (sourceId) {
                    $.post("{{ route('api.getsectionshtml') }}", {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'source_id': sourceId
                    }, function(res) {
                        var temp = $('<div>').html(res);
                        var options = temp.find('option');
                        $('#select-section').html(options);
                    });
                }
            });
        });
    </script>
@endsection
