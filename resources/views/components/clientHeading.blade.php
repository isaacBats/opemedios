<!-- Page Heading -->
<div class="row card-company">
    <div class="col-sm-3">
        <img src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}" width="420" height="150">
    </div>
    <div class="col-sm-8 page-header card-company-name">
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
<div class="loader">Cargando...</div>
<!-- /.row -->