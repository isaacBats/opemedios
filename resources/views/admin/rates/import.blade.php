@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Importar Tarifas desde CSV') }}</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Formato del CSV</h5>
                    <p>El archivo debe contener las siguientes columnas:</p>
                    <code>source_name, section_name, content_type, min_value, max_value, price, type</code>
                    <hr>
                    <p><strong>Tipos válidos (type):</strong> social, internet, radio, tv, print</p>
                    <p><strong>Tipos de contenido (content_type):</strong> post, story, reel, video, web</p>
                </div>

                <form action="{{ route('rate.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input-csv-file">Archivo CSV <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="input-csv-file" name="csv_file" accept=".csv,.txt" required>
                                <small class="text-muted">Tamaño máximo: 10MB. Se procesarán todas las filas usando updateOrCreate.</small>
                                @error('csv_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <a href="{{ route('rates') }}" class="btn btn-default btn-lg">Cancelar</a>
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-upload"></i> Importar CSV</button>
                        <a href="{{ route('rate.import.template') }}" class="btn btn-info btn-lg pull-right">
                            <i class="fa fa-download"></i> Descargar Plantilla
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Ejemplo de Estructura CSV') }}</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="active">
                                <th>source_name</th>
                                <th>section_name</th>
                                <th>content_type</th>
                                <th>min_value</th>
                                <th>max_value</th>
                                <th>price</th>
                                <th>type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Instagram</td>
                                <td></td>
                                <td>post</td>
                                <td>200</td>
                                <td>500</td>
                                <td>5000.0</td>
                                <td>social</td>
                            </tr>
                            <tr>
                                <td>Instagram</td>
                                <td></td>
                                <td>story</td>
                                <td>200</td>
                                <td>500</td>
                                <td>3000.0</td>
                                <td>social</td>
                            </tr>
                            <tr>
                                <td>EL UNIVERSAL</td>
                                <td></td>
                                <td>web</td>
                                <td>0</td>
                                <td>500000</td>
                                <td>76755.0</td>
                                <td>internet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Estadísticas Actuales') }}</h4>
            </div>
            <div class="panel-body">
                @php
                    $stats = [
                        'total' => \App\Models\Rate::count(),
                        'social' => \App\Models\Rate::where('type', 'social')->count(),
                        'internet' => \App\Models\Rate::where('type', 'internet')->count(),
                        'radio' => \App\Models\Rate::where('type', 'radio')->count(),
                        'tv' => \App\Models\Rate::where('type', 'tv')->count(),
                        'print' => \App\Models\Rate::where('type', 'print')->count(),
                    ];
                @endphp
                <div class="row">
                    <div class="col-md-2 text-center">
                        <h2>{{ number_format($stats['total']) }}</h2>
                        <p class="text-muted">Total</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <h2 class="text-info">{{ number_format($stats['social']) }}</h2>
                        <p class="text-muted">Redes Sociales</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <h2 class="text-primary">{{ number_format($stats['internet']) }}</h2>
                        <p class="text-muted">Internet</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <h2 class="text-warning">{{ number_format($stats['radio']) }}</h2>
                        <p class="text-muted">Radio</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <h2 class="text-success">{{ number_format($stats['tv']) }}</h2>
                        <p class="text-muted">TV</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <h2 class="text-danger">{{ number_format($stats['print']) }}</h2>
                        <p class="text-muted">Impreso</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
