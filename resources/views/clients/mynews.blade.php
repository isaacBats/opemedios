@extends('layouts.home-clientv3')
@section('title', " - Mis Noticias")
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <style>
        /* ========================================
           News Dashboard Styles
        ======================================== */
        .news-dashboard {
            padding-top: 100px;
            min-height: 100vh;
            background: var(--ope-gray-100);
        }

        /* Header Stats */
        .dashboard-header {
            background: var(--ope-gradient);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .company-welcome {
            color: var(--ope-white);
        }

        .company-welcome h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--ope-white);
            margin-bottom: 0.5rem;
        }

        .company-welcome p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .stats-grid {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-md);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card .stat-icon i {
            font-size: 1.5rem;
            color: var(--ope-white);
        }

        .stat-card .stat-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ope-white);
            margin: 0;
            line-height: 1;
        }

        .stat-card .stat-info p {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0.25rem 0 0;
        }

        /* Filter Toolbar */
        .filter-toolbar {
            background: var(--ope-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-toolbar .filter-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ope-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-toolbar .filter-title i {
            color: var(--ope-primary);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ope-gray-600);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            font-size: 0.9375rem;
            border: 1px solid var(--ope-gray-300);
            border-radius: var(--radius-md);
            background: var(--ope-white);
            transition: all var(--transition-base);
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: var(--ope-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .filter-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-filter {
            padding: 0.625rem 1.25rem;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-base);
        }

        .btn-filter-primary {
            background: var(--ope-gradient);
            color: var(--ope-white);
        }

        .btn-filter-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-filter-secondary {
            background: var(--ope-gray-200);
            color: var(--ope-gray-700);
        }

        .btn-filter-secondary:hover {
            background: var(--ope-gray-300);
        }

        /* News Feed */
        .news-feed {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .news-card {
            background: var(--ope-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1.5rem;
            transition: all var(--transition-base);
        }

        .news-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card-hover);
        }

        .news-source {
            text-align: center;
            min-width: 120px;
        }

        .news-source img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: var(--radius-md);
            background: var(--ope-gray-100);
            padding: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .news-source h4 {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ope-dark);
            margin: 0;
            line-height: 1.3;
        }

        .news-source .source-company {
            font-size: 0.75rem;
            color: var(--ope-gray-500);
        }

        .news-content h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--ope-dark);
            margin: 0 0 0.75rem;
            line-height: 1.4;
        }

        .news-content p {
            font-size: 0.9375rem;
            color: var(--ope-gray-600);
            margin: 0 0 1rem;
            line-height: 1.6;
        }

        .news-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8125rem;
            color: var(--ope-gray-500);
        }

        .meta-item i {
            font-size: 1rem;
        }

        .meta-item.meta-type {
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-full);
            font-weight: 600;
        }

        .meta-item.meta-tv {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .meta-item.meta-radio {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .meta-item.meta-prensa {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
        }

        .meta-item.meta-internet {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .news-actions {
            margin-left: auto;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 2rem 0;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination .page-item .page-link {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            background: var(--ope-white);
            color: var(--ope-gray-700);
            text-decoration: none;
            font-weight: 500;
            border: 1px solid var(--ope-gray-300);
            transition: all var(--transition-base);
        }

        .pagination .page-item.active .page-link {
            background: var(--ope-primary);
            border-color: var(--ope-primary);
            color: var(--ope-white);
        }

        .pagination .page-item .page-link:hover:not(.active) {
            background: var(--ope-gray-100);
            border-color: var(--ope-primary);
        }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid var(--ope-gray-300);
            border-radius: var(--radius-md);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            padding-left: 0.875rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .news-card {
                grid-template-columns: 1fr;
            }

            .news-source {
                display: flex;
                align-items: center;
                gap: 1rem;
                text-align: left;
            }

            .news-source img {
                width: 60px;
                height: 60px;
                margin-bottom: 0;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <div class="news-dashboard">
        {{-- Dashboard Header with Stats --}}
        <div class="dashboard-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="company-welcome">
                            <h1>
                                <i class='bx bx-buildings'></i>
                                {{ $company->name }}
                            </h1>
                            <p>Panel de monitoreo de noticias</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="stats-grid justify-content-lg-end">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class='bx bx-calendar-check'></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $company->assignedNews()->whereDate('created_at', \Carbon\Carbon::today()->format('Y-m-d'))->count() }}</h3>
                                    <p>Noticias hoy</p>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class='bx bx-calendar'></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $company->assignedNews()->whereYear('created_at', \Carbon\Carbon::today()->format('Y'))->whereMonth('created_at', \Carbon\Carbon::today()->format('m'))->count() }}</h3>
                                    <p>Este mes</p>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class='bx bx-data'></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $company->assignedNews->count() }}</h3>
                                    <p>Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            {{-- Filter Toolbar --}}
            <div class="filter-toolbar">
                <div class="filter-title">
                    <i class='bx bx-filter-alt'></i>
                    Filtrar noticias
                </div>
                <form method="GET" action="{{ route('client.mynews', ['company' => $company]) }}">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Palabra clave</label>
                            <input type="text" name="word" value="{{ old('word') }}" placeholder="Buscar...">
                        </div>
                        <div class="filter-group">
                            <label>Tema</label>
                            <select id="select-themes" name="theme_id">
                                <option value="">Todos los temas</option>
                                @foreach($company->themes as $theme)
                                    <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                                        {{ $theme->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Medio</label>
                            <select name="mean" id="select-report-mean">
                                <option value="">Todos los medios</option>
                                @foreach(App\Models\Means::all() as $mean)
                                    <option value="{{ $mean->id }}" {{ old('mean') == $mean->id ? 'selected' : '' }}>
                                        {{ $mean->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Fecha inicio</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        <div class="filter-group">
                            <label>Fecha fin</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}">
                        </div>
                        <div class="filter-group">
                            <label>Resultados</label>
                            <select name="pagination">
                                <option value="25" {{ old('pagination') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ old('pagination') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ old('pagination') == 100 ? 'selected' : '' }}>100</option>
                                <option value="150" {{ old('pagination') == 150 ? 'selected' : '' }}>150</option>
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter btn-filter-primary">
                                <i class='bx bx-search'></i>
                                Buscar
                            </button>
                            <a href="{{ route('client.mynews', ['company' => $company]) }}" class="btn-filter btn-filter-secondary">
                                <i class='bx bx-reset'></i>
                            </a>
                        </div>
                    </div>
                    <div id="div-select-report-sources" class="mt-3"></div>
                </form>
            </div>

            {{-- News Feed --}}
            <div class="news-feed">
                @forelse($news as $note)
                    @isset($note->source)
                        <article class="news-card">
                            <div class="news-source">
                                <img src="{{ asset("images/{$note->source->logo}") }}" alt="{{ $note->source->name }}">
                                <div>
                                    <h4>{{ $note->source->name }}</h4>
                                    <span class="source-company">{{ $note->source->company }}</span>
                                </div>
                            </div>
                            <div class="news-content">
                                <h3>{{ $note->title }}</h3>
                                <p>{{ Illuminate\Support\Str::limit($note->synthesis, 250) }}</p>
                                <div class="news-meta">
                                    <span class="meta-item">
                                        <i class='bx bx-calendar'></i>
                                        {{ $note->news_date->diffForHumans() }}
                                    </span>
                                    @if($note->author)
                                        <span class="meta-item">
                                            <i class='bx bx-user'></i>
                                            {{ $note->author }}
                                        </span>
                                    @endif
                                    @if($note->mean)
                                        @php
                                            $meanClass = match(strtolower($note->mean->name ?? '')) {
                                                'televisión', 'television', 'tv' => 'meta-tv',
                                                'radio' => 'meta-radio',
                                                'prensa', 'periódico', 'periodico' => 'meta-prensa',
                                                'internet', 'web', 'digital' => 'meta-internet',
                                                default => 'meta-prensa'
                                            };
                                            $meanIcon = match(strtolower($note->mean->name ?? '')) {
                                                'televisión', 'television', 'tv' => 'bx-tv',
                                                'radio' => 'bx-radio',
                                                'prensa', 'periódico', 'periodico' => 'bx-news',
                                                'internet', 'web', 'digital' => 'bx-globe',
                                                default => 'bx-news'
                                            };
                                        @endphp
                                        <span class="meta-item meta-type {{ $meanClass }}">
                                            <i class='bx {{ $meanIcon }}'></i>
                                            {{ $note->mean->name }}
                                        </span>
                                    @endif
                                    <div class="news-actions">
                                        <a href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug]) }}" class="btn-saas btn-saas-primary">
                                            Ver más
                                            <i class='bx bx-right-arrow-alt'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endisset
                @empty
                    <div class="news-card" style="text-align: center; padding: 3rem;">
                        <div class="news-content" style="grid-column: 1 / -1;">
                            <i class='bx bx-search-alt' style="font-size: 3rem; color: var(--ope-gray-400); margin-bottom: 1rem;"></i>
                            <h3>No se encontraron noticias</h3>
                            <p>Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {!! $news->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#select-themes').select2({
                placeholder: 'Seleccionar tema',
                allowClear: true
            });

            $('#select-report-mean').on('change', function (event) {
                getHTMLSources(event.target.value);
            });

            function getHTMLSources(noteType) {
                if (!noteType) {
                    $('#div-select-report-sources').html('');
                    return;
                }

                $.post('{{ route('api.getsourceshtml') }}', {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'mean_id': noteType
                }, function (res) {
                    var divSelectSources = $('#div-select-report-sources').html(res);
                    divSelectSources.find('label.col-form-label').removeClass().addClass('filter-label');
                    divSelectSources.find('div.col-sm-10.col-md-11.col-lg-11').removeClass();
                    divSelectSources.find('#select-fuente').select2({
                        minimumInputLength: 3,
                        placeholder: 'Buscar fuente...',
                        ajax: {
                            type: 'POST',
                            url: "{{ route('api.getsourceajax') }}",
                            dataType: 'json',
                            data: function (params) {
                                return {
                                    q: params.term,
                                    mean_id: $('select#select-report-mean').val(),
                                    "_token": $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            processResults: function (data) {
                                return {
                                    results: data.items
                                }
                            },
                            cache: true
                        }
                    });
                }).fail(function (res) {
                    $('#div-select-report-sources').html(`<p class="text-danger">No se pueden obtener las fuentes</p>`);
                    console.error(`Error-Sources: ${res.responseJSON.message}`);
                });
            }
        });
    </script>
@endsection
