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
                <li><a href="#companies" data-toggle="tab"><strong>Empresas (10)</strong></a></li>
                <li><a href="#themes" data-toggle="tab"><strong>Temas (20)</strong></a></li>
                <li><a href="#stadistics" data-toggle="tab"><strong>Estadisticas</strong></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                    @foreach($notesActivity as $activity)
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
                                {{-- <ul class="list-inline">
                                    <li><a href=""><i class="glyphicon glyphicon-heart"></i> Like</a></li>
                                    <li><a><i class="glyphicon glyphicon-comment"></i> Comments (0)</a></li>
                                    <li class="pull-right">5 liked this</li>
                                </ul> --}}
                            </div>
                            {{-- <div class="form-group">
                                <input type="text" class="form-control" placeholder="Write some comments">
                            </div> --}}
                        </div><!-- panel panel-post -->
                    @endforeach
                </div><!-- tab-pane -->

                <div class="tab-pane" id="companies">
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
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
            <div class="col-sm-6 col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Empresas asignadas (lista)</h4> {{-- borrar eso de lista, solo es referencia para saber que ahi va el listado de empresas y temas o cosas que tienen que ver con el usuario que se muestra --}}
                    </div>
                    <div class="panel-body">
                        <ul class="media-list user-list">
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading nomargin"><a href="">Floyd M. Romero</a></h4>
                                    is now following <a href="">Christina R. Hill</a>
                                    <small class="date"><i class="glyphicon glyphicon-time"></i> Just now</small>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object img-circle" src="../images/photos/user10.png" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading nomargin"><a href="">Roberta F. Horn</a></h4>
                                    commented on <a href="">HTML5 Tutorial</a>
                                    <small class="date"><i class="glyphicon glyphicon-time"></i> Yesterday</small>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object img-circle" src="../images/photos/user3.png" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading nomargin"><a href="">Jennie S. Gray</a></h4>
                                    posted a video on <a href="">The Discovery</a>
                                    <small class="date"><i class="glyphicon glyphicon-time"></i> June 25, 2015</small>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object img-circle" src="../images/photos/user5.png" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading nomargin"><a href="">Nicholas T. Hinkle</a></h4>
                                    liked your video on <a href="">The Discovery</a>
                                    <small class="date"><i class="glyphicon glyphicon-time"></i> June 24, 2015</small>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading nomargin"><a href="">Floyd M. Romero</a></h4>
                                    liked your photo on <a href="">My Life Adventure</a>
                                    <small class="date"><i class="glyphicon glyphicon-time"></i> June 24, 2015</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- panel -->
            </div>
        </div><!-- row -->
    </div>
</div><!-- row -->
@endsection