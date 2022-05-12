@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!-- Page Heading -->
@if( $route == 'news')
<div class="uk-padding-small uk-margin-medium-bottom" style="background: #521e54; color: #fff;">
    <div>
        <h1 style="color: #fff; font-size: 1.5em;">{{ "Bienvenido " . $company->name }}</h1>
        <div uk-grid>
            <p>Noticias de hoy: <strong>{{ $company->assignedNews()->whereDate('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</strong></p>
            <p>Noticias del mes: <strong>{{ $company->assignedNews()->whereYear('created_at', Carbon\Carbon::today()->format('Y'))->whereMonth('created_at', Carbon\Carbon::today()->format('m'))->count() }}</strong></p>
            <p>Total: <strong>{{ $company->assignedNewsCount() }}</strong></p>
            <div id="search" class="uk-width-expand">
                @include('components.search-bar')
            </div>
        </div>
    </div>
</div>
@endif
<!--<div class="loader">Cargando...</div>-->
<!-- /.row -->