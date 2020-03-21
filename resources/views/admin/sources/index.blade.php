@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                        <h4 class="panel-title">{{ __('Administrador de Fuentes') }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('source.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva Fuente') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"></th>
                            <th class="text-center">{{ __('Nombre') }}</th>
                            <th class="text-center">{{ __('Empresa') }}</th>
                            <th class="text-center">{{ __('Logo') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sources as $source)
                            <tr>
                                <td>{{ $loop->iterator }}</td>  
                                <td><i class="fa {{ $source->icon }} fa-3"></i></td>
                                <td>{{ $source->name }}</td>  
                                <td>{{ $source->company }}</td>  
                                <td><img src="http://lorempixel.com/400/200/" alt=""></td>  
                                <td class="table-options">
                                    <ul>
                                        <li><a href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></li>
                                    </ul>
                                </td>  
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No hay fuentes por mostrar') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection