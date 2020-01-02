@extends('layouts.admin')
@section('admin-title', ' - Nuevo Newsletter')
@section('content')
    <form method="post" action="{{ route('newsletter.create') }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading nopaddingbottom">
                    <h4 class="panel-title">Nuevo newsletter</h4>
                    <p>Un Newsletter es un correo que se envia automaticamente a las 7 am de cada día, con noticias de un día anterior.</p>
                </div>
                <div class="panel-body">
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre del Newsletter<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nombre del newsletter" value="{{ old('name') }}" required />
                        </div>
                        @error('name')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cliente al que se le va a enviar el newsletter<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="company_id" id="select-company" class="form-control">
                                <option value="">Selecciona un cliente</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('company_id')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Banner para el newsletter</label>
                        <div class="col-sm-8">
                            <input type="file" name="banner" class="form-control">
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
            </div>
        </div>
    </form>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            // $('#select-company').select2();
        })
    </script>
@endsection