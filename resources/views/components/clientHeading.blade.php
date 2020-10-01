@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!-- Page Heading -->
@if( $route == 'news')
<div class="uk-section uk-section-muted uk-padding">
    <div>
        <div class="uk-grid-divider" uk-grid>
            <div>
                <h1>{{ "Bienvenido " . $company->name }}</h1>
                <small class="card-filters">
                      Noticias de hoy: <strong>{{ $company->assignedNews()->where('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</strong> 
                    <br> Noticias del mes: <strong>{{ $company->assignedNews()->where('created_at', Carbon\Carbon::today()->format('Y-m'))->count() }}</strong> 
                    <br> Total: <strong>{{ $company->assignedNews->count() }}</strong>
                </small>
            </div>
            <div id="search">
                @include('components.search-bar')
            </div>
        </div>
    </div>
</div>
<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
    <div class="uk-navbar-container uk-padding uk-padding-remove-vertical" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav scroll-to uk-list">
                <li>
                    <a href="#" uk-icon="chevron-down">Temas</a>
                    <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav" uk-scrollspy-nav="closest: li; scroll: true; offset: 200;">
                        @foreach($company->themes as $theme)
                        <li style="margin-top: 10px;">
                            <a href="#theme{{ $theme->id }}">{{ $theme->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
<!--<div class="loader">Cargando...</div>-->
<!-- /.row -->