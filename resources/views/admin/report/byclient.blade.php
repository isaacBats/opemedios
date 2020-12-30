@extends('layouts.admin')
@section('admin-title', ' - Reportes por cliente')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Reporte por cliente</h4>
            </div>
            <div class="panel-body">
                <hr>
                <form action="" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cliente <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="company_id" id="select-company" style="width: 100%;" class="form-control" required="" aria-required="true"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fecha inicio <span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" name="fstart" class="form-control hasDatepicker" required="" aria-required="true">
                        </div>
                        <label class="col-sm-1 control-label">Fecha fin <span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" name="fend" class="form-control hasDatepicker" required="" aria-required="true">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tema</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="theme_id">
                                <option value="default">** Todos **</option>
                                {{-- @foreach(Auth::user()->themes as $theme)
                                    <option value="{{ $theme->id }}" {{ (old('theme_id') == $theme->id ? 'selected' : '' ) }}>{{ $theme->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Sector</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="sector_id">
                                <option value="default">** Todos **</option>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" {{ (old('sector_id') == $sector->id ? 'selected' : '' ) }} >{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">G&eacute;nero</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="genre_id" id="">
                                <option value="default">** Todos **</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ (old('genre_id') == $genre->id ? 'selected' : '' ) }} >{{ $genre->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Tendencia</label>
                        <div class="col-sm-8">
                            <select class="form-control uk-select" name="trend" id="">
                                <option value="default">** Todas **</option>
                                <option value="1" {{ (old('trend') == "1" ? 'selected' : '' ) }} >{{ __('Positiva') }}</option>
                                <option value="2" {{ (old('trend') == "2" ? 'selected' : '' ) }} >{{ __('Neutral') }}</option>
                                <option value="3" {{ (old('trend') == "3" ? 'selected' : '' ) }} >{{ __('Negativa') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Medio</label>
                        <div class="col-sm-8">
                            <select class="form-control uk-select" name="mean_id" id="">
                                <option value="default">** Todos **</option>
                                @foreach($means as $mean)
                                    <option value="{{ $mean->id }}" {{ (old('mean_id') == $mean->id ? 'selected' : '' ) }}>{{ $mean->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-success btn-quirk btn-wide mr5">Submit</button>
                            <button type="reset" class="btn btn-quirk btn-wide btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Select company combo
            $('#select-company').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getcompaniesajax') }}",
                    dataType: 'json',
                    data: function(params, noteType) {
                        return {
                            q: params.term,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        } 
                    },
                    processResults: function(data) {
                        return {
                            results: data.items
                        }
                    },
                    cache: true
                }
            })
        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
