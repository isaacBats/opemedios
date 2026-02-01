@extends('layouts.home-clientv3')
@section('title', " - Generador de Reportes")

@section('styles')
<link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.css') }}">
<style>
    /* ========================================
       Report Generator v3 - SaaS Modern Theme
       ======================================== */

    .report-section {
        padding-top: var(--header-safe-area, 160px);
        padding-bottom: var(--section-padding, 100px);
        background: var(--ope-gray-100);
        min-height: 100vh;
    }

    /* Hero Header */
    .report-hero {
        background: var(--ope-gradient);
        border-radius: var(--radius-xl);
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        color: var(--ope-white);
        position: relative;
        overflow: hidden;
    }

    .report-hero::before {
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

    .report-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .report-hero-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 0.25rem;
    }

    .report-hero-subtitle {
        font-size: 0.9375rem;
        opacity: 0.9;
        margin: 0;
    }

    .report-hero-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-hero {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
        border: none;
        cursor: pointer;
    }

    .btn-hero-primary {
        background: var(--ope-white);
        color: var(--ope-primary);
    }

    .btn-hero-primary:hover {
        background: var(--ope-gray-100);
        transform: translateY(-1px);
    }

    .btn-hero-secondary {
        background: rgba(255, 255, 255, 0.15);
        color: var(--ope-white);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-hero-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
        color: var(--ope-white);
    }

    /* Filter Card */
    .filter-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--ope-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-card-title i {
        color: var(--ope-primary);
    }

    .filter-card-body {
        padding: 1.5rem;
    }

    /* Form Controls */
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }

    .form-group-modern {
        margin-bottom: 0;
    }

    .form-group-modern label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--ope-dark-soft);
        margin-bottom: 0.5rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        color: var(--ope-dark);
        background: var(--ope-gray-100);
        border: 2px solid transparent;
        border-radius: var(--radius-md);
        transition: all var(--transition-base);
    }

    .form-control-modern:focus {
        outline: none;
        background: var(--ope-white);
        border-color: var(--ope-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control-modern::placeholder {
        color: var(--ope-gray-500);
    }

    /* Select2 Override */
    .select2-container--default .select2-selection--multiple,
    .select2-container--default .select2-selection--single {
        background: var(--ope-gray-100) !important;
        border: 2px solid transparent !important;
        border-radius: var(--radius-md) !important;
        min-height: 46px !important;
        padding: 0.25rem 0.5rem;
        transition: all var(--transition-base);
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default.select2-container--open .select2-selection--single {
        background: var(--ope-white) !important;
        border-color: var(--ope-primary) !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: var(--ope-primary-lighter) !important;
        border: none !important;
        border-radius: var(--radius-sm) !important;
        color: var(--ope-primary) !important;
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.25rem 0.5rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: var(--ope-primary) !important;
        margin-right: 0.25rem;
    }

    .select2-dropdown {
        border-radius: var(--radius-md) !important;
        border: 1px solid var(--ope-gray-300) !important;
        box-shadow: var(--shadow-lg) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: var(--ope-primary) !important;
    }

    /* jQuery UI Datepicker Override */
    .ui-datepicker {
        border-radius: var(--radius-lg) !important;
        box-shadow: var(--shadow-xl) !important;
        border: 1px solid var(--ope-gray-200) !important;
        padding: 0.5rem;
    }

    .ui-datepicker-header {
        background: var(--ope-gradient) !important;
        border: none !important;
        border-radius: var(--radius-md) !important;
        color: var(--ope-white) !important;
    }

    .ui-datepicker-title {
        color: var(--ope-white) !important;
    }

    .ui-datepicker td a.ui-state-active {
        background: var(--ope-primary) !important;
        border-radius: var(--radius-sm) !important;
        color: var(--ope-white) !important;
    }

    .ui-datepicker td a:hover {
        background: var(--ope-primary-lighter) !important;
        border-radius: var(--radius-sm) !important;
    }

    /* Action Buttons */
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--ope-gray-200);
        flex-wrap: wrap;
    }

    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        border-radius: var(--radius-md);
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
        border: none;
        cursor: pointer;
    }

    .btn-filter-primary {
        background: var(--ope-gradient);
        color: var(--ope-white);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    }

    .btn-filter-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    }

    .btn-filter-secondary {
        background: var(--ope-white);
        color: var(--ope-dark);
        border: 1px solid var(--ope-gray-300);
    }

    .btn-filter-secondary:hover {
        background: var(--ope-gray-100);
        border-color: var(--ope-gray-400);
    }

    .btn-filter-export {
        background: #10b981;
        color: var(--ope-white);
    }

    .btn-filter-export:hover {
        background: #059669;
        color: var(--ope-white);
    }

    .btn-filter-pdf {
        background: #ef4444;
        color: var(--ope-white);
    }

    .btn-filter-pdf:hover {
        background: #dc2626;
        color: var(--ope-white);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card-mini {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        font-size: 1.25rem;
    }

    /* Colores según ui-style.md */
    .stat-card-icon.blue { background: rgba(37, 99, 235, 0.1); color: var(--ope-primary); }
    .stat-card-icon.green { background: rgba(16, 185, 129, 0.1); color: #10b981; } /* Success */
    .stat-card-icon.yellow { background: rgba(251, 191, 36, 0.1); color: #fbbf24; } /* Warning */
    .stat-card-icon.red { background: rgba(239, 68, 68, 0.1); color: #ef4444; } /* Error */

    .stat-card-content h4 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--ope-dark);
        margin: 0;
        line-height: 1;
    }

    .stat-card-content p {
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
        margin: 0.25rem 0 0;
    }

    /* Charts Grid */
    .charts-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .chart-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
    }

    .chart-card-full {
        grid-column: 1 / -1;
    }

    .chart-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
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
        min-height: 300px;
    }

    /* Data Table */
    .table-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .table-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--ope-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--ope-gray-100);
    }

    .table-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-card-title i {
        color: var(--ope-primary);
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern thead th {
        background: var(--ope-gray-100);
        padding: 1rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--ope-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--ope-gray-200);
    }

    .table-modern tbody td {
        padding: 1rem;
        font-size: 0.875rem;
        color: var(--ope-gray-700);
        border-bottom: 1px solid var(--ope-gray-100);
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background: var(--ope-gray-100);
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern .note-title {
        color: var(--ope-primary);
        font-weight: 600;
        text-decoration: none;
        transition: color var(--transition-base);
    }

    .table-modern .note-title:hover {
        color: var(--ope-primary-dark);
    }

    .table-modern .note-id {
        font-family: monospace;
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
    }

    /* Trend Badge */
    .trend-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.625rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .trend-badge.positive {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .trend-badge.neutral {
        background: rgba(107, 114, 128, 0.1);
        color: #4b5563;
    }

    .trend-badge.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--ope-gray-200);
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 0.75rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--ope-gray-600);
        background: var(--ope-white);
        border: 1px solid var(--ope-gray-300);
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .pagination .page-link:hover {
        background: var(--ope-gray-100);
        border-color: var(--ope-gray-400);
    }

    .pagination .page-item.active .page-link {
        background: var(--ope-primary);
        border-color: var(--ope-primary);
        color: var(--ope-white);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Alert Messages */
    .alert-modern {
        padding: 1rem 1.25rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-modern.success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #059669;
    }

    .alert-modern.error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #dc2626;
    }

    .alert-modern i {
        font-size: 1.25rem;
    }

    /* Tooltip */
    .tooltip-modern {
        position: relative;
    }

    .tooltip-modern .tooltip-text {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        bottom: calc(100% + 8px);
        left: 50%;
        transform: translateX(-50%);
        background: var(--ope-dark);
        color: var(--ope-white);
        padding: 0.5rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.8125rem;
        white-space: nowrap;
        max-width: 250px;
        white-space: normal;
        text-align: center;
        z-index: 1000;
        transition: all var(--transition-base);
    }

    .tooltip-modern:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Responsive */
    @media (min-width: 1600px) {
        .report-section {
            padding-top: 180px;
        }
    }

    @media (min-width: 1920px) {
        .report-section {
            padding-top: 200px;
        }
    }

    @media (max-width: 1199px) {
        .filter-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .report-section {
            padding-top: 140px;
        }
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-row {
            grid-template-columns: 1fr;
        }
        .report-hero-content {
            flex-direction: column;
            text-align: center;
        }
        .report-hero-actions {
            justify-content: center;
        }
    }

    @media (max-width: 767px) {
        .report-section {
            padding-top: 120px;
            padding-bottom: 60px;
        }
        .filter-grid {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .report-hero {
            padding: 1.5rem;
        }
        .filter-actions {
            flex-direction: column;
        }
        .btn-filter {
            justify-content: center;
        }
        .table-modern {
            font-size: 0.8125rem;
        }
        .table-modern thead {
            display: none;
        }
        .table-modern tbody tr {
            display: block;
            padding: 1rem;
            border-bottom: 1px solid var(--ope-gray-200);
        }
        .table-modern tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border: none;
        }
        .table-modern tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--ope-gray-600);
        }
    }

    @media (max-width: 480px) {
        .report-section {
            padding-top: 100px;
        }
    }
</style>
@endsection

@section('content')
<section class="report-section">
    <div class="container">
        {{-- Alert Messages --}}
        @if (session('status'))
            <div class="alert-modern success">
                <i class='bx bx-check-circle'></i>
                {!! session('status') !!}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-modern error">
                <i class='bx bx-error-circle'></i>
                {!! session('error') !!}
            </div>
        @endif

        {{-- Hero Header --}}
        <div class="report-hero" data-aos="fade-up">
            <div class="report-hero-content">
                <div class="report-hero-info">
                    <h1 class="report-hero-title">
                        <i class='bx bx-file-find'></i>
                        Generador de Reportes
                    </h1>
                    <p class="report-hero-subtitle">
                        Filtra, analiza y exporta las notas de {{ $company->name }}
                    </p>
                </div>
                <div class="report-hero-actions">
                    <a href="{{ route('client.report.solicitados', $company->slug) }}" class="btn-hero btn-hero-secondary">
                        <i class='bx bx-list-ul'></i>
                        Mis Reportes
                    </a>
                    <a href="{{ route('news', $company->slug) }}" class="btn-hero btn-hero-primary">
                        <i class='bx bx-home'></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Summary --}}
        <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-mini">
                <div class="stat-card-icon blue">
                    <i class='bx bx-news'></i>
                </div>
                <div class="stat-card-content">
                    <h4>{{ number_format($notes->total()) }}</h4>
                    <p>Notas encontradas</p>
                </div>
            </div>
            <div class="stat-card-mini">
                <div class="stat-card-icon green">
                    <i class='bx bx-trending-up'></i>
                </div>
                <div class="stat-card-content">
                    @php
                        $positivas = collect($tendencias)->where('trend', 1)->first();
                    @endphp
                    <h4>{{ $positivas ? number_format($positivas->total) : 0 }}</h4>
                    <p>Notas positivas</p>
                </div>
            </div>
            <div class="stat-card-mini">
                <div class="stat-card-icon yellow">
                    <i class='bx bx-minus-circle'></i>
                </div>
                <div class="stat-card-content">
                    @php
                        $neutrales = collect($tendencias)->where('trend', 2)->first();
                    @endphp
                    <h4>{{ $neutrales ? number_format($neutrales->total) : 0 }}</h4>
                    <p>Notas neutrales</p>
                </div>
            </div>
            <div class="stat-card-mini">
                <div class="stat-card-icon red">
                    <i class='bx bx-trending-down'></i>
                </div>
                <div class="stat-card-content">
                    @php
                        $negativas = collect($tendencias)->where('trend', 3)->first();
                    @endphp
                    <h4>{{ $negativas ? number_format($negativas->total) : 0 }}</h4>
                    <p>Notas negativas</p>
                </div>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card" data-aos="fade-up" data-aos-delay="150">
            <div class="filter-card-header">
                <h3 class="filter-card-title">
                    <i class='bx bx-filter-alt'></i>
                    Filtros de Búsqueda
                </h3>
            </div>
            <div class="filter-card-body">
                <form action="{{ route('client.report', ['company' => $company]) }}" method="GET" id="form-report-filter">
                    <input type="hidden" name="company" value="{{ $company->id }}">

                    <div class="filter-grid">
                        <div class="form-group-modern">
                            <label for="input-report-date-start">
                                <i class='bx bx-calendar'></i> Fecha inicio
                            </label>
                            <input
                                id="input-report-date-start"
                                class="form-control-modern"
                                type="text"
                                name="start_date"
                                value="{{ $from_d }}"
                                placeholder="YYYY-MM-DD"
                            >
                        </div>

                        <div class="form-group-modern">
                            <label for="input-report-date-end">
                                <i class='bx bx-calendar'></i> Fecha fin
                            </label>
                            <input
                                id="input-report-date-end"
                                class="form-control-modern"
                                type="text"
                                name="end_date"
                                value="{{ $to_d }}"
                                placeholder="YYYY-MM-DD"
                            >
                        </div>

                        <div class="form-group-modern">
                            <label for="select-theme">
                                <i class='bx bx-purchase-tag'></i> Tema
                            </label>
                            <select
                                class="form-control-modern select2"
                                name="theme_id[]"
                                id="select-theme"
                                multiple
                            >
                                <option value="">** Todos **</option>
                                @foreach(App\Models\Company::where('slug', session()->get('slug_company'))->first()->themes as $theme)
                                    <option value="{{ $theme->id }}" {{ ((request()->has('theme_id') && is_array(request('theme_id')) && in_array($theme->id, request('theme_id'))) ? 'selected' : '' ) }}>
                                        {{ $theme->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern">
                            <label for="select-sector">
                                <i class='bx bx-category'></i> Sector
                            </label>
                            <select
                                class="form-control-modern select2"
                                name="sector[]"
                                id="select-sector"
                                multiple
                            >
                                <option value="">** Todos **</option>
                                @foreach(App\Models\Sector::all() as $sector)
                                    <option value="{{ $sector->id }}" {{ ((request()->has('sector') && is_array(request('sector')) && in_array($sector->id, request('sector'))) ? 'selected' : '' ) }}>
                                        {{ $sector->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern">
                            <label for="select-genre">
                                <i class='bx bx-book-content'></i> Género
                            </label>
                            <select
                                class="form-control-modern select2"
                                name="genre[]"
                                id="select-genre"
                                multiple
                            >
                                <option value="">** Todos **</option>
                                @foreach(App\Models\Genre::all() as $genre)
                                    <option value="{{ $genre->id }}" {{ ((request()->has('genre') && is_array(request('genre')) && in_array($genre->id, request('genre'))) ? 'selected' : '' ) }}>
                                        {{ $genre->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern">
                            <label for="select-report-mean">
                                <i class='bx bx-broadcast'></i> Medio
                            </label>
                            <select
                                class="form-control-modern select2"
                                name="mean[]"
                                id="select-report-mean"
                                multiple
                            >
                                <option value="">** Todos **</option>
                                @foreach(App\Models\Means::all() as $mean)
                                    <option value="{{ $mean->id }}" {{ ((request()->has('mean') && is_array(request('mean')) && in_array($mean->id, request('mean'))) ? 'selected' : '' ) }}>
                                        {{ $mean->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern" id="div-select-report-sources"></div>

                        <div class="form-group-modern">
                            <label for="input-word">
                                <i class='bx bx-search'></i> Buscar por
                            </label>
                            <input
                                class="form-control-modern"
                                type="text"
                                name="word"
                                id="input-word"
                                placeholder="Título o palabra..."
                                value="{{ old('word') }}"
                            >
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-filter btn-filter-primary" id="btn-form-submit">
                            <i class='bx bx-search'></i>
                            Filtrar / Buscar
                        </button>
                        <button type="button" class="btn-filter btn-filter-export" id="btn-report-export">
                            <i class='bx bx-spreadsheet'></i>
                            Exportar Excel
                        </button>
                        <button type="button" class="btn-filter btn-filter-pdf" id="btn-report-export-pdf">
                            <i class='bx bxs-file-pdf'></i>
                            Exportar PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Charts --}}
        <div class="charts-row" data-aos="fade-up" data-aos-delay="200">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <i class='bx bx-pie-chart-alt-2'></i>
                        Distribución por Tendencia
                    </h3>
                </div>
                <div class="chart-container" id="chart_tendencia"></div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <i class='bx bx-doughnut-chart'></i>
                        Distribución por Medio
                    </h3>
                </div>
                <div class="chart-container" id="chart_medio"></div>
            </div>
        </div>

        <div class="charts-row" data-aos="fade-up" data-aos-delay="250">
            <div class="chart-card chart-card-full">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <i class='bx bx-line-chart'></i>
                        Evolución Temporal
                    </h3>
                </div>
                <div class="chart-container" id="chart_hist"></div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="table-card" data-aos="fade-up" data-aos-delay="300">
            <div class="table-card-header">
                <h3 class="table-card-title">
                    <i class='bx bx-table'></i>
                    Listado de Notas
                </h3>
                <span class="text-muted" style="font-size: 0.875rem;">
                    Mostrando {{ $notes->firstItem() ?? 0 }} - {{ $notes->lastItem() ?? 0 }} de {{ $notes->total() }}
                </span>
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Nota</th>
                            <th>Título</th>
                            <th>Tema</th>
                            <th>Sector</th>
                            <th>Género</th>
                            <th>Fuente</th>
                            <th>Medio</th>
                            <th>Fecha</th>
                            <th>Costo</th>
                            <th>Tendencia</th>
                            <th>Alcance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            <tr>
                                <td data-label="#">
                                    {{ ($notes->currentPage() - 1) * $notes->perPage() + $loop->iteration }}
                                </td>
                                <td data-label="No. Nota">
                                    <span class="note-id">OPE-{{ $note->id }}</span>
                                </td>
                                <td data-label="Título">
                                    <a href="{{ route('client.shownew', ['id' => $note->id, 'company' => $company->slug]) }}"
                                       class="note-title tooltip-modern"
                                       target="_blank">
                                        {{ \Illuminate\Support\Str::limit($note->title, 50) }}
                                        @if(\Illuminate\Support\Str::length($note->title) > 50 || $note->synthesis)
                                            <span class="tooltip-text">{{ $note->synthesis ?: $note->title }}</span>
                                        @endif
                                    </a>
                                </td>
                                <td data-label="Tema">
                                    {{ $note->assignedNews->where('company_id', $company->id)->where('news_id', $note->id)->first()->theme->name ?? 'N/E' }}
                                </td>
                                <td data-label="Sector">{{ $note->sector->name ?? 'N/E' }}</td>
                                <td data-label="Género">{{ $note->genre->description ?? 'N/E' }}</td>
                                <td data-label="Fuente">{{ $note->source->name ?? 'N/E' }}</td>
                                <td data-label="Medio">{{ $note->mean->name ?? 'N/E' }}</td>
                                <td data-label="Fecha">
                                    {{ $note->news_date->format('d/m/Y') }}
                                </td>
                                <td data-label="Costo">{{ number_coin($note->cost) }}</td>
                                <td data-label="Tendencia">
                                    @if($note->trend == 1)
                                        <span class="trend-badge positive">
                                            <i class='bx bx-trending-up'></i> Positiva
                                        </span>
                                    @elseif($note->trend == 2)
                                        <span class="trend-badge neutral">
                                            <i class='bx bx-minus'></i> Neutral
                                        </span>
                                    @else
                                        <span class="trend-badge negative">
                                            <i class='bx bx-trending-down'></i> Negativa
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Alcance">{{ number_decimal($note->scope) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" style="text-align: center; padding: 3rem;">
                                    <div style="color: var(--ope-gray-500);">
                                        <i class='bx bx-search-alt' style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;"></i>
                                        No se encontraron notas con los filtros seleccionados
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($notes->hasPages())
                <div class="pagination-wrapper">
                    {{ $notes->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('lib/jquery/jquery.js') }}"></script>
<script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('lib/select2/select2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: 'Seleccionar...',
        allowClear: true,
        width: '100%'
    });

    // Mean selection - load sources
    $('#select-report-mean').on('change', function(event) {
        getHTMLSources(event.target.value);
    });

    function getHTMLSources(noteType) {
        $.post('{{ route('api.getsourceshtml') }}', {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'mean_id': noteType
        }, function(res) {
            var divSelectSources = $('#div-select-report-sources').html(res);
            divSelectSources.find('label.col-form-label').removeClass().addClass('form-group-modern label');
            divSelectSources.find('div.col-sm-10.col-md-11.col-lg-11').removeClass();
            divSelectSources.find('#select-fuente').addClass('form-control-modern').css('width', '100%').select2({
                minimumInputLength: 3,
                placeholder: 'Buscar fuente...',
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getsourceajax') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term,
                            mean_id: $('select#select-report-mean').val(),
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        };
                    },
                    processResults: function(data) {
                        return { results: data.items };
                    },
                    cache: true
                }
            });
        }).fail(function(res) {
            $('#div-select-report-sources').html(`
                <label class="form-group-modern label"><i class='bx bx-building'></i> Fuente</label>
                <p style="color: var(--ope-gray-500); font-size: 0.875rem;">Selecciona un medio primero</p>
            `);
            console.error(`Error-Sources: ${res.responseJSON?.message}`);
        });
    }

    // Datepickers
    var format = "yy-mm-dd";
    var from = $("#input-report-date-start").datepicker({
        defaultDate: "+1w",
        dateFormat: format,
        changeMonth: true,
        changeYear: true
    }).on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
    });

    var to = $("#input-report-date-end").datepicker({
        defaultDate: "+1w",
        dateFormat: format,
        changeMonth: true,
        changeYear: true
    }).on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
    });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(format, element.value);
        } catch (error) {
            date = null;
        }
        return date;
    }

    // Form submissions
    $('#btn-form-submit').on('click', function(event) {
        event.preventDefault();
        $('#form-report-filter')
            .attr('action', "{{ route('client.report', ['company' => session()->get('slug_company')]) }}")
            .attr('method', 'get')
            .submit();
    });

    $('#btn-report-export').on('click', function(event) {
        event.preventDefault();
        $('#form-report-filter')
            .attr('action', "{{ route('admin.report.export') }}")
            .attr('method', 'get')
            .submit();
    });

    $('#btn-report-export-pdf').on('click', function(event) {
        event.preventDefault();
        $('#form-report-filter')
            .attr('action', "{{ route('admin.report_pdf.export') }}")
            .attr('method', 'get')
            .submit();
    });
});

// ApexCharts - Theme colors
// ApexCharts - Theme colors (según ui-style.md)
var chartColors = {
    primary: '#2563eb',     // --ope-primary
    secondary: '#0ea5e9',   // --ope-secondary
    success: '#10b981',     // Success (verde esmeralda)
    warning: '#fbbf24',     // Warning (amarillo ámbar)
    danger: '#ef4444',      // Error (rojo)
    gray: '#6b7280'         // --ope-gray-600
};

// Tendencia Chart (Donut)
var options_tendencia = {
    series: [
        @php $xcoma = '' @endphp
        @foreach($tendencias as $itm)
            {{ $xcoma . $itm->total }}
            @php $xcoma = ',' @endphp
        @endforeach
    ],
    labels: [
        @php $xcoma = '' @endphp
        @foreach($tendencias as $itm)
            {{$xcoma}}"{{ ($itm->trend == 1 ? 'Positiva' : ($itm->trend == 2 ? 'Neutral' : 'Negativa')) }}"
            @php $xcoma = ',' @endphp
        @endforeach
    ],
    chart: {
        type: 'donut',
        height: 300,
        fontFamily: 'Inter, sans-serif'
    },
    colors: [chartColors.success, chartColors.gray, chartColors.danger],
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 600,
                        color: '#1a1a1a'
                    }
                }
            }
        }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        position: 'bottom',
        fontSize: '13px',
        fontWeight: 500,
        markers: {
            width: 10,
            height: 10,
            radius: 3
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: { height: 250 },
            legend: { position: 'bottom' }
        }
    }]
};

var chart_tendencia = new ApexCharts(document.querySelector("#chart_tendencia"), options_tendencia);
chart_tendencia.render();

// Medio Chart (Pie)
var options_medio = {
    series: [
        @php $xcoma = '' @endphp
        @foreach($medios as $itm)
            {{ $xcoma . $itm->total }}
            @php $xcoma = ',' @endphp
        @endforeach
    ],
    labels: [
        @php $xcoma = '' @endphp
        @foreach($medios as $itm)
            {{$xcoma}}"{{ $itm->mean->name }}"
            @php $xcoma = ',' @endphp
        @endforeach
    ],
    chart: {
        type: 'pie',
        height: 300,
        fontFamily: 'Inter, sans-serif'
    },
    colors: [chartColors.primary, chartColors.secondary, chartColors.warning, chartColors.success, chartColors.danger, '#8b5cf6'],
    dataLabels: {
        enabled: true,
        formatter: function(val, opts) {
            return opts.w.globals.series[opts.seriesIndex];
        }
    },
    legend: {
        position: 'bottom',
        fontSize: '13px',
        fontWeight: 500,
        markers: {
            width: 10,
            height: 10,
            radius: 3
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: { height: 250 },
            legend: { position: 'bottom' }
        }
    }]
};

var chart_medio = new ApexCharts(document.querySelector("#chart_medio"), options_medio);
chart_medio.render();

// Historial Chart (Line)
var options_hist = {
    series: [
        {!! $json !!}
    ],
    chart: {
        height: 320,
        type: 'line',
        fontFamily: 'Inter, sans-serif',
        toolbar: {
            show: true,
            tools: {
                download: true,
                selection: false,
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: false,
                reset: true
            }
        },
        zoom: {
            enabled: true
        }
    },
    colors: [chartColors.success, chartColors.gray, chartColors.danger],
    stroke: {
        width: 3,
        curve: 'smooth'
    },
    markers: {
        size: 4,
        strokeWidth: 0,
        hover: {
            size: 6
        }
    },
    xaxis: {
        categories: [
            @php $xxcoma = ''; @endphp
            @foreach($fechas as $it)
                {{ $xxcoma }}'{{ $it }}'
                @php $xxcoma = ','; @endphp
            @endforeach
        ],
        labels: {
            style: {
                fontSize: '12px',
                fontWeight: 500,
                colors: '#6b7280'
            }
        }
    },
    yaxis: {
        labels: {
            style: {
                fontSize: '12px',
                fontWeight: 500,
                colors: '#6b7280'
            }
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        fontSize: '13px',
        fontWeight: 500,
        markers: {
            width: 10,
            height: 10,
            radius: 3
        }
    },
    grid: {
        borderColor: '#e5e7eb',
        strokeDashArray: 4
    },
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function(val) {
                return val + ' notas';
            }
        }
    }
};

var chart_hist = new ApexCharts(document.querySelector("#chart_hist"), options_hist);
chart_hist.render();
</script>
@endsection
