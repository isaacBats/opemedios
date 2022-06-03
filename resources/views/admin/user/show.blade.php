@extends('layouts.admin')
@section('admin-title', " - Perfil de {$profile->name}")
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
    <div class="col-md-9 col-lg-10 profile-right">
        <div class="profile-right-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified nav-line">
                <li class="active"><a href="#activity" data-toggle="tab"><strong>{{ __('Ultimas notas') }}</strong></a></li>
                @if ($profile->isMonitor())
                    <li><a href="#send-news" data-toggle="tab"><strong>Noticias Enviadas</strong></a></li>
                @endif
                @if ($profile->isExecutive())
                    <li><a href="#companies" data-toggle="tab"><strong>Empresas ({{ $profile->companies->count() }})</strong></a></li>
                    <li><a href="#themes" data-toggle="tab"><strong>Temas</strong></a></li>
                @endif
                @if ($profile->isAdmin())
                    <li><a href="#companies" data-toggle="tab"><strong>Empresas({{ App\Company::count() }})</strong></a></li>
                    <li><a href="#themes" data-toggle="tab"><strong>Temas</strong></a></li>
                @endif
                <li><a href="#stadistics" data-toggle="tab"><strong>Estadisticas</strong></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                    @if($notes->count() > 0)
                        @foreach($notes as $activity)
                            @php
                                if($profile->isExecutive() || $profile->isClient()){
                                    $activity = $activity->news;
                                }
                            @endphp
                            @include('components.post-news', ['user' => $profile, 'note' => $activity])
                        @endforeach
                        {{ $notes->links() }}
                    @endif
                </div><!-- tab-pane -->
                @if ($profile->isExecutive() || $profile->isAdmin())
                    <div class="tab-pane" id="companies">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-9">
                                <button  data-href="{{ route('admin.executive.add.company') }}" 
                                        data-executive="{{ $profile->name }}" 
                                        class="btn btn-danger btn-quirk btn-block" 
                                        id="btn-assign-company">Asignar empresa</button>
                            </div>
                        </div>
                        @foreach($companies as $company)
                            @include('components.card-company', ['company' => $company])
                        @endforeach
                        {{ $companies->links() }}
                    </div>
                    <div class="tab-pane" id="themes">
                        <div class="nav-wrapper white">
                            <ul class="nav nav-pills nav-stacked nav-quirk nav-quirk-info">
                                @foreach($themes as $theme)
                                    <li class="nav-parent active">
                                        <a href="javascript:void(0);"><i class="fa fa-archive"></i> <span>{{ $theme->name }}</span></a>
                                        <ul class="children">
                                            @php
                                                $countNote = 0;
                                            @endphp
                                            @foreach ($theme->assignedNews as $noteAssigned)
                                                @if($countNote == 10)
                                                    @break
                                                @endif
                                                <li><a href="{{ route('admin.new.show', ['id' => $noteAssigned->news->id]) }}">{{ $noteAssigned->news->title }}</a></li>
                                                @php 
                                                    $countNote++;
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        {{ $themes->links() }}
                    </div>
                @endif
                @if ($profile->isMonitor())
                    <div class="tab-pane" id="send-news">
                        @foreach($notesSent as $nSent)
                            @include('components.post-news', ['user' => $profile, 'note' => $nSent])
                        @endforeach
                    </div>
                @endif
                <div class="tab-pane" id="stadistics">
                    <div class="row">
                        <canvas id="line-chart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- row -->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/chart/Chart.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('lib/chart/Chart.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            // modal for add client to manager roll
            $('button#btn-assign-company').on('click', function(event){
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

            var ctx = document.getElementById('line-chart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                    datasets: [{
                        label: '# de notas',
                        data: @json($countNotes),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });

        })
    </script>
@endsection