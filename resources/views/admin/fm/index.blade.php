@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <div class="fm-sidebar">
                <button class="btn btn-danger btn-quirk btn-block mb20">{{ __('Subir archivo') }}</button>
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ __('Folders') }}</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="folder-list">
                            <li><a href=""><i class="fa fa-folder-open"></i> My Pictures</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> Facebook Photos</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> My Collection</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> Illustrations</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> TV Series</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> Downloaded Movies</a></li>
                            <li><a href=""><i class="fa fa-folder-open"></i> E-book</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-9 col-lg-10">
            {{-- <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __('Administrador de archivos') }}</h4>
                </div>
            </div> --}}
        </div>
    </div>
@endsection