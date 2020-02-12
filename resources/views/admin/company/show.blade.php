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
    <div class="col-md-9 col-lg-8">
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
                        <a href="" class="btn btn-primary">Relacionar con cliente anterior</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection