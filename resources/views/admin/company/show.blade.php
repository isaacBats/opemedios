@extends('layouts.admin')
@section('content')
    <div class="col-md-3 col-lg-4">
        <div class="row">
            <div class="col-sm-5 col-md-12 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cuentas</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list user-list">
                            @forelse($company->accounts() as $account)
                                <li class="media">
                                    <div class="media-left">
                                      <a href="#">
                                        <img class="media-object img-circle" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($account->name)) }}" alt="">
                                      </a>
                                    </div>
                                    <div class="media-body">
                                      <h4 class="media-heading nomargin">{{ $account->name }}</h4>
                                      {{ $account->metas->where('meta_key', 'user_position')->first()->meta_value }}
                                      {{-- <small class="date"><i class="glyphicon glyphicon-time"></i> Just now</small> --}}
                                    </div>
                                    
                                </li>
                            @empty
                                <li class="media">No hay cuentas para esta empresa</li>
                                {{-- <a href="">Agregar Cuenta</a> --}}
                            @endforelse
                        </ul>
                    </div>
                </div>    
            </div>
            <div class="col-sm-5 col-md-12 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Temas</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-8 people-list">
        <div class="people-options clearfix">
            <div class="btn-toolbar pull-left">
                <button class="btn btn-success btn-quirk" type="button">{{ __('Agregar usuario') }}</button>
                <button class="btn btn-success btn-quirk" type="button">{{ __('Agregar tema') }}</button>
            </div>
        </div>
        <div class="panel panel">
            <div class="panel-heading">
                <h1 class="panel-title">{{ $company->name }}</h1>
            </div>
            <div class="panel-body">
                <img class="img-responsive" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                <p class="text-center">{{ "{$company->address} | {$company->turn->name}" }}</p>
                @if($company->old_company_id)
                @else
                    <p class="text-center">
                        <button class="btn btn-primary" type="button" id="btn-relation">Relacionar con cliente anterior</button>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-relation').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('method', 'POST')
                form.attr('action', '/panel/empresa/relacionar')
                
                modal.find('.modal-title').html('Relacionar con una empresa del sistema pasado');
                modal.find('#md-btn-submit').val('Relacionar')
                $.get('/api/v2/clientes/antiguas', function (companies) {
                    var htmlOptions = `<select name="old_company_id" class="form-control select2">
                        <option>Selecciona un Cliente</option>`                    
                    $.each(companies, function (key, obj) {
                        htmlOptions += `<option value="${obj.id}">${obj.nombre}</option>` 
                    })
                    htmlOptions += `</select>`
                    modal.find('.modal-body').html(htmlOptions)
                })

                modal.modal('show')
            })
        })
    </script>
@endsection