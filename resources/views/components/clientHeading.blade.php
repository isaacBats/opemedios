@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<!-- Page Heading -->
<div class="sidebar-left uk-visible@l">
    <div>
        <h3>{{ "Bienvenido " . $company->name }}</h3>
        <small class="card-filters">
              Noticias de hoy: <strong>{{ $company->assignedNews->where('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</strong> 
            <br> Noticias del mes: <strong>{{ $company->assignedNews->where('created_at', Carbon\Carbon::today()->format('Y-m'))->count() }}</strong> 
            <br> Total: <strong>{{ $company->assignedNews->count() }}</strong>
        </small>
    </div>

    <div id="search">
        @include('components.search-bar')
    </div>

    @if( $route == 'news')
    <h4>Tema</h4>
    <ul class="scroll-to uk-list">
    @foreach($company->themes as $theme)
        <li>
        <a href="#" id="link{{ $theme->name }}">{{ $theme->name }}</a>
        </li>
    @endforeach
    </ul>
    @endif

    @if( $route == 'themes')    
    <h4>Tema</h4>
    <div class="panel-body themes-list-p0">
        <ul class="list-group uk-list" id="list-group-themes">
            @foreach ($company->themes as $theme)
                <li class="list-group-item theme-transition">
                    <a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $company->id }}" data-themeid="{{ $theme->id }}" 
                    @if($theme->id == $defaultThemeId)
                    uk-icon = "icon:triangle-right;"
                    @endif
                    >
                        {{ $theme->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<!--<div class="loader">Cargando...</div>-->
<!-- /.row -->