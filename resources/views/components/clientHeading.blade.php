@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!-- Page Heading -->
@if( $route == 'news')
<div class="uk-padding-small uk-margin-medium-bottom" style="background: #521e54; color: #fff;">
    <div>
        <h1 style="color: #fff; font-size: 1.5em;">{{ "Bienvenido " . $company->name }}</h1>
        <div uk-grid>
            <p>Noticias de hoy: <strong>{{ $company->assignedNews->where('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</strong></p>
            <p>Noticias del mes: <strong>{{ $company->assignedNews->where('created_at', Carbon\Carbon::today()->format('Y-m'))->count() }}</strong></p>
            <p>Total: <strong>{{ $company->assignedNews->count() }}</strong></p>
            <div id="search">
                @include('components.search-bar')
            </div>
        </div>
    </div>
</div>
@endif
<!--<div class="loader">Cargando...</div>-->
<!-- /.row -->