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
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                        <h4 class="panel-title">{{ __('Administrador de Portadas y Columnas') }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right">
                        <a href="{{ route('admin.press.add') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nueva') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('Tipo') }}</th>
                            <th class="text-center">{{ __('Fecha') }}</th>
                            <th class="text-center">{{ __('Fuente') }}</th>
                            <th class="text-center">{{ __('Imagen') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($covers as $cover)
                            <tr>
                                @php
                                    $coverType = array_filter($types, function($v, $k) use($cover) { return $k == $cover->cover_type; }, ARRAY_FILTER_USE_BOTH);
                                @endphp
                                <th class="text-center">{{ ($covers->currentPage() - 1) * $covers->perPage() + $loop->iteration }}</th>
                                <th class="text-center">{{ $coverType[$cover->cover_type] }}</th>
                                <th class="text-center">{{ $cover->date_cover->toDateString() }}</th>
                                <th class="text-center">{{ $cover->source->name }}</th>
                                <th style="width: 12%;">
                                    <img src="{{ $cover->image->path_filename }}" alt="{{ $cover->source->name }}" height="180" style="width: auto;">
                                </th>
                                <th class="text-center">
                                    <a href="{{ route('admin.press.edit', ['id' => $cover->id]) }}"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        @empty
                        <tr>
                            <th class="text-center" colspan="5">{{ __('No hay portadas disponibles') }}</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $covers->links() }}
            </div>
        </div>
    </div>
@endsection