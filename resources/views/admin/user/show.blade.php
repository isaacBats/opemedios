@extends('layouts.admin')
@section('admin-title', " - Perdil de {$profile->name}")
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
<div class="row profile-wrapper">
    <div class="col-xs-12 col-md-3 col-lg-2 profile-left">
        <div class="profile-left-heading">
            <ul class="panel-options">
                <li><a><i class="glyphicon glyphicon-option-vertical"></i></a></li>
            </ul>
            <a href="" class="profile-photo"><img class="img-circle img-responsive" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($profile->name)) }}" alt=""></a>
            <h2 class="profile-name">{{ $profile->name }}</h2>
            <h4 class="profile-designation">{{ $profile->metas->where('meta_key', 'user_position')->first()->meta_value }}</h4>

            <ul class="list-group">
                @foreach($countNews as $count)
                    <li class="list-group-item">{{ $count['label'] }} <a href="javascript:void(0)">{{ number_decimal($count['value']) }}</a></li>
                @endforeach
            </ul>


            <a href="{{ route('admin.user.edit', ['id' => $profile->id ]) }}" class="btn btn-danger btn-quirk btn-block profile-btn-follow">Editar</a>
        </div>
        <div class="profile-left-body">
            <h4 class="panel-title">{{ __('Sobre mi') }}</h4>
            <p>{!! $profile->getMetaByKey('user_aboutme') ? $profile->getMetaByKey('user_aboutme')->meta_value : "No hay información hacerca de {$profile->name}" !!}</p>
            <hr class="fadeout">

            <h4 class="panel-title">{{ __('Dirección') }}</h4>
            <p><i class="glyphicon glyphicon-user mr5"></i> {{ $profile->getMetaByKey('user_address') ? $profile->getMetaByKey('user_address')->meta_value : "-" }}</p>

            @if($profile->company())
                <hr class="fadeout">
                <h4 class="panel-title">{{ __('Empresa') }}</h4>
                <p><i class="glyphicon glyphicon-briefcase mr5"></i> {{ $profile->company()->name }}</p>
            @endif
            <hr class="fadeout">

            <h4 class="panel-title">{{ __('Tipo de usuario') }}</h4>
            <p><i class="glyphicon glyphicon-briefcase mr5"></i> {{ strtoupper($profile->toStringRoles()) }}</p>

            <hr class="fadeout">

            <h4 class="panel-title">{{ __('Contactos') }}</h4>

            <p><i class="glyphicon glyphicon-phone mr5"></i>Tel: {{ $profile->getMetaByKey('user_phone') ? $profile->getMetaByKey('user_phone')->meta_value : "-" }}</p>
            <p><i class="glyphicon glyphicon-phone mr5"></i>Whatsapp: {{ $profile->getMetaByKey('user_whatsapp') ? $profile->getMetaByKey('user_whatsapp')->meta_value : "-" }}</p>
            <p><i class="glyphicon glyphicon-phone mr5"></i>Email: {{ $profile->email }}</p>

            <hr class="fadeout">

            <h4 class="panel-title">Social</h4>
            <ul class="list-inline profile-social">
                @if($profile->getMetaByKey('user_facebook'))
                    <li><a href="{{ $profile->getMetaByKey('user_facebook')->meta_value }}"><i class="fa fa-facebook-official"></i></a></li>
                @endif
                @if($profile->getMetaByKey('user_twitter'))
                    <li><a href="{{ $profile->getMetaByKey('user_twitter')->meta_value}}"><i class="fa fa-twitter"></i></a></li>
                @endif
                @if($profile->getMetaByKey('user_instagram'))
                    <li><a href="{{ $profile->getMetaByKey('user_instagram')->meta_value}}"><i class="fa fa-instagram"></i></a></li>
                @endif
                @if($profile->getMetaByKey('user_linkedin'))
                    <li><a href="{{ $profile->getMetaByKey('user_linkedin')->meta_value}}"><i class="fa fa-linkedin"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-lg-8 profile-right">
        <div class="profile-right-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified nav-line">
                <li class="active"><a href="#activity" data-toggle="tab"><strong>{{ __('Ultimas notas') }}</strong></a></li>
                @if ($profile->isMonitor())
                    <li><a href="#send-news" data-toggle="tab"><strong>Noticias Enviadas</strong></a></li>
                    <li><a href="#total" data-toggle="tab"><strong>Total</strong></a></li>
                @endif
                @if ($profile->isExecutive())
                    <li><a href="#companies" data-toggle="tab"><strong>Empresas ({{ $profile->companies->count() }})</strong></a></li>
                    <li><a href="#themes" data-toggle="tab"><strong>Temas</strong></a></li>
                    {{-- <li><a href="#stadistics" data-toggle="tab"><strong>Estadisticas</strong></a></li> --}}
                @endif
                @if ($profile->isAdmin())
                    <li><a href="#companies" data-toggle="tab"><strong>Empresas({{ App\Company::count() }})</strong></a></li>
                    <li><a href="#themes" data-toggle="tab"><strong>Temas</strong></a></li>
                    <li><a href="#stadistics" data-toggle="tab"><strong>Estadisticas</strong></a></li>
                @endif
                @if ($profile->isClient())
                    <li><a href="#stadistics" data-toggle="tab"><strong>Estadisticas</strong></a></li>
                @endif
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                    @if($profile->isMonitor())
                        @php
                            $notes = $profile->news()->simplePaginate(15);
                        @endphp
                        @foreach($notes as $activity)
                            <div class="panel panel-post-item">
                                <div class="panel-heading">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="javascript:void(0);">
                                                <img alt="" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($profile->name)) }}" class="media-object img-circle">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{ $activity->title }}</h4>
                                            <p class="media-usermeta">
                                                <span class="media-time">{{ $activity->news_date->toDayDateTimeString() }}</span>
                                            </p>
                                        </div>
                                    </div><!-- media -->
                                </div><!-- panel-heading -->
                                <div class="panel-body">
                                    <p>{!! Illuminate\Support\Str::limit($activity->synthesis, 300) !!}</p>
                                    <p>{{ __('Nota completa:') }} <a href="{{ route('admin.new.show', ['id' => $activity->id]) }}" target="_blank">{{ route('admin.new.show', ['id' => $activity->id]) }}</a></p>
                                </div>
                                <div class="panel-footer">
                                    <div class="col-sm-2 col-sm-offset-10">
                                        @if ($activity->isAssigned())
                                            <span style="color: green;"><i class="fa fa-check-circle"></i> Enviada</span>
                                        @else
                                            <span style="color: orange;"><i class="fa fa-circle-o"></i> Pendiente</span>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- panel panel-post -->
                        @endforeach
                        {{ $notes->links() }}
                    @endif
                    @if ($profile->isAdmin())
                        @php
                            $notes = App\News::orderBy('id', 'asc')->simplePaginate(15);
                        @endphp
                        @foreach($notes as $activity)
                            <div class="panel panel-post-item">
                                <div class="panel-heading">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="javascript:void(0);">
                                                <img alt="" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($profile->name)) }}" class="media-object img-circle">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{ $activity->title }}</h4>
                                            <p class="media-usermeta">
                                                <span class="media-time">{{ $activity->news_date->toDayDateTimeString() }}</span>
                                            </p>
                                        </div>
                                    </div><!-- media -->
                                </div><!-- panel-heading -->
                                <div class="panel-body">
                                    <p>{!! Illuminate\Support\Str::limit($activity->synthesis, 300) !!}</p>
                                    <p>{{ __('Nota completa:') }} <a href="{{ route('admin.new.show', ['id' => $activity->id]) }}" target="_blank">{{ route('admin.new.show', ['id' => $activity->id]) }}</a></p>
                                </div>
                                <div class="panel-footer">
                                    <div class="col-sm-2 col-sm-offset-10">
                                        @if ($activity->isAssigned())
                                            <span style="color: green;"><i class="fa fa-check-circle"></i> Enviada</span>
                                        @else
                                            <span style="color: orange;"><i class="fa fa-circle-o"></i> Pendiente</span>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- panel panel-post -->
                        @endforeach
                        {{ $notes->links() }}
                    @endif
                </div><!-- tab-pane -->
                @if ($profile->isExecutive() || $profile->isAdmin())
                    <div class="tab-pane" id="companies">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-9">
                                <button  data-href="{{ route('admin.executive.add.company') }}" data-executive="{{ $profile->name }}" class="btn btn-danger btn-quirk btn-block" id="btn-add-company-{{ $profile->isAdmin() ? 'admin' : 'executive' }}">Asignar empresa</button>
                            </div>
                        </div>
                        @if($profile->isAdmin())
                            @php
                                $companies = App\Company::orderBy('id', 'asc')->simplePaginate(15);
                            @endphp
                            @foreach($companies as $company)
                                <div class="panel panel-profile list-view">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="{{ route('company.show', ['id' => $company->id]) }}">
                                                    <img class="media-object img-circle" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ $company->name }}</h4>
                                                <p class="media-usermeta"><i style="color: brown;" class="glyphicon glyphicon-info-sign"></i> {{ $company->turn->name }}</p>
                                            </div>
                                        </div><!-- media -->
                                        <ul class="panel-options">
                                            <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                                        </ul>
                                    </div><!-- panel-heading -->

                                    <div class="panel-body people-info">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Direcci&oacute;n</label>
                                                    {{ $company->address }}
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Email</label>
                                                    -
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Phone</label>
                                                    -
                                                </div>
                                            </div>
                                        </div><!-- row -->
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Notas enviadas hoy</label>
                                                    <h4>{{ $company->assignedNews()->where('created_at', Carbon\Carbon::today())->get()->count() }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Total de notas enviadas</label>
                                                    <h4>{{ $company->assignedNews->count() }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Social</label>
                                                        <div class="social-account-list">
                                                            <i class="fa fa-facebook-official"></i>
                                                            <i class="fa fa-twitter"></i>
                                                            <i class="fa fa-dribbble"></i>
                                                        </div>
                                                </div>
                                            </div>
                                        </div><!-- row -->
                                    </div>
                                </div><!-- panel -->
                            @endforeach
                             {{ $companies->links() }}
                        @else
                            @php
                                $companies = $profile->companies()->orderBy('id', 'asc')->simplePaginate(15);
                            @endphp
                            @foreach($companies as $company)
                                <div class="panel panel-profile list-view">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="{{ route('company.show', ['id' => $company->id]) }}">
                                                    <img class="media-object img-circle" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ $company->name }}</h4>
                                                <p class="media-usermeta"><i style="color: brown;" class="glyphicon glyphicon-info-sign"></i> {{ $company->turn->name }}</p>
                                            </div>
                                        </div><!-- media -->
                                        <ul class="panel-options">
                                            <li><a style="color: red;" href="javascript:void(0)" class="tooltips btn-remove-cassigned" data-company="{{ $company->name }}" data-companyid="{{ $company->id }}" data-userid="{{ $profile->id }}" data-username="{{ $profile->name }}" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a></li>
                                        </ul>
                                    </div><!-- panel-heading -->

                                    <div class="panel-body people-info">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Direcci&oacute;n</label>
                                                    {{ $company->address }}
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Email</label>
                                                    -
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Phone</label>
                                                    -
                                                </div>
                                            </div>
                                        </div><!-- row -->
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Notas enviadas hoy</label>
                                                    <h4>{{ $company->assignedNews()->where('created_at', Carbon\Carbon::today())->get()->count() }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Total de notas enviadas</label>
                                                    <h4>{{ $company->assignedNews->count() }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="info-group">
                                                    <label>Social</label>
                                                        <div class="social-account-list">
                                                            <i class="fa fa-facebook-official"></i>
                                                            <i class="fa fa-twitter"></i>
                                                            <i class="fa fa-dribbble"></i>
                                                        </div>
                                                </div>
                                            </div>
                                        </div><!-- row -->
                                    </div>
                                </div><!-- panel -->
                            @endforeach
                             {{ $companies->links() }}
                        @endif
                    </div>
                @endif
                <div class="tab-pane" id="themes">
                    Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.
                </div>
                <div class="tab-pane" id="stadistics">
                    Temporibus autem quibusdam #Stadistics et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-2 profile-sidebar">
        <div class="row">
            @if($profile->isClient())
                <div class="col-sm-6 col-md-12">
                    <div class="panel panel-default list-announcement">
                        <div class="panel-heading">
                            <h4 class="panel-title">Temas asignados ({{ $profile->themes()->count() }})</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled mb20">
                                @forelse($profile->themes as $theme)
                                    <li>
                                        {{ $theme->name }}
                                    </li>
                                @empty
                                    <li>No hay temas para esta empresa</li>
                                @endforelse
                            </ul>
                        </div>
                    </div><!-- panel -->
                </div>
            @endif
        </div><!-- row -->
    </div>
</div><!-- row -->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            // modal for add client to manager roll
            $('button#btn-add-company-executive').on('click', function(event){
                event.preventDefault()
                var action = $(this).data('href')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var executive = $(this).data('executive')

                form.attr('method', 'POST')
                form.attr('action', action)

                modal.find('.modal-title').html(`Asignar cuenta a ${executive}`)
                modal.find('.modal-body').html(`
                    <input name="user_id" type="hidden" value="{{ $profile->id }}">
                    <div>
                            <select name="company_id" id="select-company" class="form-control" style="width: 100%; ">
                                <option value="">Selecciona un cliente</option>
                                @foreach(App\Company::all() as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                `)
                modal.find('#select-company').select2({
                    dropdownParent: modal
                })
                modal.find('#md-btn-submit').attr('value', 'Agregar')

                modal.modal('show')

            })

            //remove company assigned
            $('.btn-remove-cassigned').on('click', function (event) {
                event.preventDefault()

                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')
                var userID = $(this).data('userid')
                var userName = $(this).data('username')
                var companyID = $(this).data('companyid')
                var company = $(this).data('company')

                form.attr('method', 'POST')
                    .attr('action', `{{ route('admin.executive.remove.company') }}`)
                
                if(form.find('input[name=company_id]').length == 0) {
                    form.append($('<input>').attr('type', 'hidden').attr('name', 'company_id').val(companyID))
                } else {
                    var inputCompany = form.find('input[name=company_id]')
                    inputCompany.val(companyID)
                }

                if(form.find('input[name=user_id]').length == 0) {
                    form.append($('<input>').attr('type', 'hidden').attr('name', 'user_id').val(userID))
                } else {
                    var inputUser = form.find('input[name=user_id]')
                    inputUser.val(userID)
                }

                modal.find('.modal-title').html(`Desasociar cliente.`)
                modalBody.html(`<p>¿Estas seguro que remover a <strong>${company}</strong> de las cuentas de ${userName}?</p>`)
                modal.find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.modal('show')
            })
        })
    </script>
@endsection