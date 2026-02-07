@extends('layouts.home-clientv3')
@section('title', " - Dashboard de {$company->name}")

@section('styles')
<style>
    /* ========================================
       Client Dashboard v3 - SaaS Modern Theme
       ======================================== */

    .dashboard-section {
        padding-top: var(--header-safe-area, 160px);
        padding-bottom: var(--section-padding, 100px);
        background: var(--ope-gray-100);
        min-height: 100vh;
    }

    /* Dashboard Header with Company Branding */
    .dashboard-hero {
        background: var(--ope-gradient);
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: var(--ope-white);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='40' fill='rgba(255,255,255,0.05)'/%3E%3C/svg%3E") no-repeat center;
        background-size: contain;
        opacity: 0.5;
    }

    .dashboard-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .company-logo-wrapper {
        width: 100px;
        height: 100px;
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        padding: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-lg);
    }

    .company-logo-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .company-info {
        flex: 1;
    }

    .company-name {
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0 0 0.25rem;
    }

    .company-welcome {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    .dashboard-date {
        text-align: right;
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .dashboard-date strong {
        display: block;
        font-size: 1.125rem;
        opacity: 1;
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        transition: all var(--transition-base);
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-card-hover);
    }

    .kpi-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .kpi-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        font-size: 1.5rem;
    }

    .kpi-icon.blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
    .kpi-icon.green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .kpi-icon.orange { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .kpi-icon.purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

    .kpi-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--ope-dark);
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .kpi-label {
        font-size: 0.875rem;
        color: var(--ope-gray-500);
        font-weight: 500;
    }

    .kpi-change {
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-full);
    }

    .kpi-change.up { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .kpi-change.down { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    /* Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
    }

    .chart-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--ope-gray-200);
    }

    .chart-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-card-title i {
        color: var(--ope-primary);
    }

    .chart-container {
        position: relative;
        height: 280px;
    }

    /* Data Tables / Lists */
    .data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .data-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        overflow: hidden;
    }

    .data-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--ope-gray-200);
        background: var(--ope-gray-100);
    }

    .data-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .data-card-title i {
        color: var(--ope-primary);
    }

    .data-card-body {
        padding: 0;
    }

    /* Theme List */
    .theme-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .theme-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--ope-gray-100);
        transition: background var(--transition-base);
    }

    .theme-item:last-child {
        border-bottom: none;
    }

    .theme-item:hover {
        background: var(--ope-gray-100);
    }

    .theme-name {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--ope-dark-soft);
    }

    .theme-count {
        background: var(--ope-gradient-soft);
        color: var(--ope-primary);
        font-size: 0.8125rem;
        font-weight: 700;
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-full);
    }

    /* Recent News List */
    .news-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--ope-gray-100);
        transition: background var(--transition-base);
    }

    .news-item:last-child {
        border-bottom: none;
    }

    .news-item:hover {
        background: var(--ope-gray-100);
    }

    .news-item-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .news-item-icon.tv { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .news-item-icon.radio { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .news-item-icon.prensa { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .news-item-icon.internet { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .news-item-icon.revista { background: rgba(139, 92, 246, 0.1); color: #7c3aed; }

    .news-item-content {
        flex: 1;
        min-width: 0;
    }

    .news-item-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--ope-dark);
        margin: 0 0 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-item-meta {
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .news-item-date {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Trend Stats */
    .trend-stats {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
    }

    .trend-stat {
        flex: 1;
        text-align: center;
        padding: 1rem;
        border-radius: var(--radius-md);
    }

    .trend-stat.positive {
        background: rgba(16, 185, 129, 0.1);
    }

    .trend-stat.neutral {
        background: rgba(107, 114, 128, 0.1);
    }

    .trend-stat.negative {
        background: rgba(239, 68, 68, 0.1);
    }

    .trend-stat-value {
        font-size: 1.5rem;
        font-weight: 800;
    }

    .trend-stat.positive .trend-stat-value { color: #10b981; }
    .trend-stat.neutral .trend-stat-value { color: #6b7280; }
    .trend-stat.negative .trend-stat-value { color: #ef4444; }

    .trend-stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.25rem;
    }

    .trend-stat.positive .trend-stat-label { color: #059669; }
    .trend-stat.neutral .trend-stat-label { color: #4b5563; }
    .trend-stat.negative .trend-stat-label { color: #dc2626; }

    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: var(--ope-white);
        border: 1px solid var(--ope-gray-300);
        border-radius: var(--radius-md);
        color: var(--ope-dark-soft);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .quick-action-btn:hover {
        background: var(--ope-primary);
        border-color: var(--ope-primary);
        color: var(--ope-white);
    }

    .quick-action-btn i {
        font-size: 1.125rem;
    }

    /* Responsive */
    @media (min-width: 1600px) {
        .dashboard-section {
            padding-top: 180px;
        }
    }

    @media (min-width: 1920px) {
        .dashboard-section {
            padding-top: 200px;
        }
    }

    @media (max-width: 1199px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .dashboard-section {
            padding-top: 140px;
        }
        .charts-grid,
        .data-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-hero-content {
            flex-direction: column;
            text-align: center;
        }
        .dashboard-date {
            text-align: center;
        }
    }

    @media (max-width: 767px) {
        .dashboard-section {
            padding-top: 120px;
            padding-bottom: 60px;
        }
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-hero {
            padding: 1.5rem;
        }
        .company-logo-wrapper {
            width: 80px;
            height: 80px;
        }
        .company-name {
            font-size: 1.375rem;
        }
        .trend-stats {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .dashboard-section {
            padding-top: 100px;
        }
        .quick-actions {
            flex-direction: column;
        }
        .quick-action-btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-section">
    <div class="container">
        {{-- Dashboard Hero with Company Branding --}}
        <div class="dashboard-hero" data-aos="fade-up">
            <div class="dashboard-hero-content">
                <div class="company-logo-wrapper">
                    @if($company->logo)
                        <img src="{{ asset('images/' . $company->logo) }}" alt="{{ $company->name }}">
                    @else
                        <i class='bx bx-building-house' style="font-size: 3rem; color: var(--ope-primary);"></i>
                    @endif
                </div>
                <div class="company-info">
                    <h1 class="company-name">{{ $company->name }}</h1>
                    <p class="company-welcome">Bienvenido, {{ auth()->user()->name }}</p>
                </div>
                <div class="dashboard-date">
                    <span>Hoy es</span>
                    <strong>{{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F, Y') }}</strong>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="quick-actions mb-4" data-aos="fade-up" data-aos-delay="50">
            <a href="{{ route('client.mynews', $company->slug) }}" class="quick-action-btn">
                <i class='bx bx-news'></i>
                Ver Mis Noticias
            </a>
            <a href="{{ route('client.report', $company->slug) }}" class="quick-action-btn">
                <i class='bx bx-file'></i>
                Generar Reporte
            </a>
            <a href="{{ route('client.sections', ['company' => $company->slug, 'type' => 'primeras']) }}" class="quick-action-btn">
                <i class='bx bx-image-alt'></i>
                Primeras Planas
            </a>
            <a href="{{ route('client.sections', ['company' => $company->slug, 'type' => 'cartones']) }}" class="quick-action-btn">
                <i class='bx bx-palette'></i>
                Cartones
            </a>
        </div>

        {{-- KPI Cards --}}
        <div class="kpi-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <div class="kpi-icon blue">
                        <i class='bx bx-calendar-check'></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($newsToday) }}</div>
                <div class="kpi-label">Noticias Hoy</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <div class="kpi-icon green">
                        <i class='bx bx-calendar'></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($newsThisMonth) }}</div>
                <div class="kpi-label">Este Mes</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <div class="kpi-icon orange">
                        <i class='bx bx-calendar-star'></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($newsThisYear) }}</div>
                <div class="kpi-label">Este Año</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <div class="kpi-icon purple">
                        <i class='bx bx-data'></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($newsTotal) }}</div>
                <div class="kpi-label">Total Acumulado</div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="charts-grid" data-aos="fade-up" data-aos-delay="150">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <i class='bx bx-bar-chart-alt-2'></i>
                        Noticias por Día (Esta Semana)
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="chart-weekly"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <i class='bx bx-line-chart'></i>
                        Noticias por Mes (Este Año)
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="chart-monthly"></canvas>
                </div>
            </div>
        </div>

        {{-- Data Section --}}
        <div class="data-grid" data-aos="fade-up" data-aos-delay="200">
            {{-- Distribution by Media --}}
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">
                        <i class='bx bx-pie-chart-alt-2'></i>
                        Distribución por Medio (Este Mes)
                    </h3>
                </div>
                <div class="data-card-body">
                    @if($newsByMean->count() > 0)
                        <ul class="theme-list">
                            @foreach($newsByMean as $mean)
                                @php
                                    $iconClass = match($mean->short_name) {
                                        'tel' => 'bx-tv',
                                        'rad' => 'bx-radio',
                                        'per' => 'bx-news',
                                        'int' => 'bx-globe',
                                        'rev' => 'bx-book-open',
                                        default => 'bx-file'
                                    };
                                @endphp
                                <li class="theme-item">
                                    <span class="theme-name">
                                        <i class='bx {{ $iconClass }}' style="margin-right: 0.5rem; color: var(--ope-primary);"></i>
                                        {{ $mean->name }}
                                    </span>
                                    <span class="theme-count">{{ number_format($mean->total) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class='bx bx-info-circle' style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2">Sin datos este mes</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Trend Analysis --}}
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">
                        <i class='bx bx-trending-up'></i>
                        Análisis de Tendencias (Este Mes)
                    </h3>
                </div>
                <div class="data-card-body">
                    <div class="trend-stats">
                        <div class="trend-stat positive">
                            <div class="trend-stat-value">{{ $trendStats->get(1)?->total ?? 0 }}</div>
                            <div class="trend-stat-label">
                                <i class='bx bx-trending-up'></i> Positivas
                            </div>
                        </div>
                        <div class="trend-stat neutral">
                            <div class="trend-stat-value">{{ $trendStats->get(2)?->total ?? 0 }}</div>
                            <div class="trend-stat-label">
                                <i class='bx bx-minus'></i> Neutrales
                            </div>
                        </div>
                        <div class="trend-stat negative">
                            <div class="trend-stat-value">{{ $trendStats->get(3)?->total ?? 0 }}</div>
                            <div class="trend-stat-label">
                                <i class='bx bx-trending-down'></i> Negativas
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- More Data Section --}}
        <div class="data-grid" data-aos="fade-up" data-aos-delay="250">
            {{-- Themes --}}
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">
                        <i class='bx bx-purchase-tag'></i>
                        Temas con más Noticias (Este Mes)
                    </h3>
                </div>
                <div class="data-card-body">
                    @if($themesWithCount->count() > 0)
                        <ul class="theme-list">
                            @foreach($themesWithCount as $theme)
                                <li class="theme-item">
                                    <span class="theme-name">{{ $theme->name }}</span>
                                    <span class="theme-count">{{ number_format($theme->total) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class='bx bx-info-circle' style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2">Sin temas este mes</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent News --}}
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">
                        <i class='bx bx-time-five'></i>
                        Noticias Recientes
                    </h3>
                </div>
                <div class="data-card-body">
                    @if($recentNews->count() > 0)
                        @foreach($recentNews as $news)
                            @php
                                $meanClass = match($news->mean?->short_name) {
                                    'tel' => 'tv',
                                    'rad' => 'radio',
                                    'per' => 'prensa',
                                    'int' => 'internet',
                                    'rev' => 'revista',
                                    default => 'prensa'
                                };
                                $meanIcon = match($news->mean?->short_name) {
                                    'tel' => 'bx-tv',
                                    'rad' => 'bx-radio',
                                    'per' => 'bx-news',
                                    'int' => 'bx-globe',
                                    'rev' => 'bx-book-open',
                                    default => 'bx-file'
                                };
                            @endphp
                            <a href="{{ route('client.shownew', ['company' => $company->slug, 'id' => $news->id]) }}" class="news-item" style="text-decoration: none;">
                                <div class="news-item-icon {{ $meanClass }}">
                                    <i class='bx {{ $meanIcon }}'></i>
                                </div>
                                <div class="news-item-content">
                                    <h4 class="news-item-title">{{ $news->title }}</h4>
                                    <div class="news-item-meta">
                                        <span class="news-item-date">
                                            <i class='bx bx-calendar'></i>
                                            {{ $news->news_date->diffForHumans() }}
                                        </span>
                                        <span>{{ $news->source?->name ?? 'Sin fuente' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class='bx bx-info-circle' style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2">Sin noticias recientes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Reports Section --}}
        @if($recentReports->count() > 0)
        <div class="data-card mt-4" data-aos="fade-up" data-aos-delay="300">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class='bx bx-file'></i>
                    Últimos Reportes
                </h3>
                <a href="{{ route('client.report.solicitados', $company->slug) }}" class="text-primary" style="font-size: 0.875rem; text-decoration: none;">
                    Ver todos <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="data-card-body p-0">
                <table class="table table-hover mb-0" style="font-size: 0.875rem;">
                    <tbody>
                        @foreach($recentReports as $report)
                            <tr>
                                <td style="padding: 1rem;">
                                    <span style="font-family: monospace; font-size: 0.8125rem; background: var(--ope-gray-100); padding: 0.25rem 0.5rem; border-radius: 4px;">
                                        {{ $report->name_file ?? 'Sin archivo' }}
                                    </span>
                                </td>
                                <td style="padding: 1rem; white-space: nowrap;">
                                    {{ $report->start_date ? $report->start_date->format('d/m') : 'N/A' }} - {{ $report->end_date ? $report->end_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td style="padding: 1rem;">
                                    @switch($report->status)
                                        @case(0)
                                            <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 20px;">
                                                <i class='bx bx-time'></i> Pendiente
                                            </span>
                                            @break
                                        @case(1)
                                            <span class="badge" style="background: #d1fae5; color: #065f46; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 20px;">
                                                <i class='bx bx-check'></i> Listo
                                            </span>
                                            @break
                                        @case(2)
                                            <span class="badge" style="background: #e0e7ff; color: #4338ca; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 20px;">
                                                <i class='bx bx-download'></i> Descargado
                                            </span>
                                            @break
                                        @case(3)
                                            <span class="badge" style="background: #dbeafe; color: #1d4ed8; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 20px;">
                                                <i class='bx bx-loader-alt bx-spin'></i> Procesando
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td style="padding: 1rem; text-align: right;">
                                    @if($report->status == 1 || $report->status == 2)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($report->name_file) }}"
                                           class="btn btn-sm"
                                           style="background: var(--ope-gradient); color: #fff; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; text-decoration: none;">
                                            <i class='bx bx-download'></i> Descargar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            once: true
        });
    }

    // Chart.js default config for v3 theme
    const chartColors = {
        primary: '#2563eb',
        primaryLight: 'rgba(37, 99, 235, 0.1)',
        secondary: '#0ea5e9',
        gray: '#6b7280',
        grayLight: '#f3f4f6'
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: chartColors.grayLight
                },
                ticks: {
                    font: {
                        family: 'Inter'
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        family: 'Inter'
                    }
                }
            }
        }
    };

    // Weekly Chart
    const weeklyCtx = document.getElementById('chart-weekly');
    if (weeklyCtx) {
        fetch("{{ route('api.client.notesday', ['company' => $company->id]) }}")
            .then(response => response.json())
            .then(notes => {
                const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                const data = [0, 0, 0, 0, 0, 0, 0];

                notes.forEach(note => {
                    const numDay = new Date(note.day).getDay();
                    data[numDay] = note.total;
                });

                new Chart(weeklyCtx, {
                    type: 'bar',
                    data: {
                        labels: days,
                        datasets: [{
                            data: data,
                            backgroundColor: chartColors.primaryLight,
                            borderColor: chartColors.primary,
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false
                        }]
                    },
                    options: chartOptions
                });
            })
            .catch(err => console.error('Error loading weekly chart:', err));
    }

    // Monthly Chart
    const monthlyCtx = document.getElementById('chart-monthly');
    if (monthlyCtx) {
        fetch("{{ route('api.client.notesyear', ['company' => $company->id]) }}")
            .then(response => response.json())
            .then(notes => {
                const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                const data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                notes.forEach(note => {
                    data[note.month - 1] = note.total;
                });

                new Chart(monthlyCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            data: data,
                            borderColor: chartColors.primary,
                            backgroundColor: chartColors.primaryLight,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: chartColors.primary,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: chartOptions
                });
            })
            .catch(err => console.error('Error loading monthly chart:', err));
    }
});
</script>
@endsection
