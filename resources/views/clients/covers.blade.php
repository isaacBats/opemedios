@extends('layouts.home-clientv3')
@section('title', " - {$title}")

@section('styles')
<style>
    /* ========================================
       Covers Portfolio v3 - SaaS Modern Theme
       ======================================== */

    .covers-section {
        padding-top: var(--header-safe-area, 160px);
        padding-bottom: var(--section-padding, 100px);
        background: var(--ope-gray-100);
        min-height: 100vh;
    }

    /* Page Header */
    .covers-header {
        margin-bottom: 2.5rem;
    }

    .covers-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .covers-title-wrap {
        flex: 1;
    }

    .covers-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--ope-dark);
        margin: 0 0 0.5rem;
        line-height: 1.2;
    }

    .covers-title span {
        background: var(--ope-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .covers-subtitle {
        font-size: 1rem;
        color: var(--ope-gray-600);
        margin: 0;
    }

    .covers-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--ope-gradient);
        color: var(--ope-white);
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Filter Tabs */
    .covers-filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }

    .filter-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: var(--ope-gray-100);
        border: 2px solid transparent;
        border-radius: var(--radius-full);
        color: var(--ope-gray-600);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .filter-tab:hover {
        background: var(--ope-primary-lighter);
        color: var(--ope-primary);
    }

    .filter-tab.active {
        background: var(--ope-gradient);
        color: var(--ope-white);
        border-color: var(--ope-primary);
    }

    .filter-tab i {
        font-size: 1.125rem;
    }

    /* Portfolio Grid */
    .covers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    /* Cover Card */
    .cover-card {
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--ope-gray-200);
        transition: all var(--transition-base);
    }

    .cover-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: var(--ope-primary-lighter);
    }

    .cover-card-image {
        position: relative;
        aspect-ratio: 3/4;
        overflow: hidden;
        background: var(--ope-gray-200);
    }

    .cover-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }

    .cover-card:hover .cover-card-image img {
        transform: scale(1.05);
    }

    .cover-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: opacity var(--transition-base);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 1.5rem;
    }

    .cover-card:hover .cover-card-overlay {
        opacity: 1;
    }

    .btn-view-cover {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--ope-white);
        color: var(--ope-dark);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .btn-view-cover:hover {
        background: var(--ope-primary);
        color: var(--ope-white);
    }

    .cover-card-body {
        padding: 1.25rem;
    }

    .cover-source-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0 0 0.375rem;
        line-height: 1.3;
    }

    .cover-date {
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .cover-date i {
        font-size: 0.875rem;
    }

    /* Cover with content (columns) */
    .cover-card.has-content .cover-card-body {
        border-top: 1px solid var(--ope-gray-200);
    }

    .cover-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--ope-dark-soft);
        margin: 0.75rem 0 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cover-author {
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-read-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: var(--ope-gradient-soft);
        color: var(--ope-primary);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .btn-read-content:hover {
        background: var(--ope-primary);
        color: var(--ope-white);
    }

    /* Empty State */
    .covers-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: var(--ope-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }

    .covers-empty i {
        font-size: 4rem;
        color: var(--ope-gray-400);
        margin-bottom: 1rem;
    }

    .covers-empty h3 {
        font-size: 1.25rem;
        color: var(--ope-dark);
        margin: 0 0 0.5rem;
    }

    .covers-empty p {
        color: var(--ope-gray-500);
        margin: 0;
    }

    /* Modal for content view */
    .cover-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .cover-modal-backdrop.active {
        display: flex;
    }

    .cover-modal {
        background: var(--ope-white);
        border-radius: var(--radius-xl);
        max-width: 900px;
        max-height: 90vh;
        width: 100%;
        overflow: hidden;
        display: grid;
        grid-template-columns: 300px 1fr;
        box-shadow: var(--shadow-2xl);
    }

    .cover-modal-image {
        background: var(--ope-gray-200);
        overflow: hidden;
    }

    .cover-modal-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cover-modal-content {
        padding: 2rem;
        overflow-y: auto;
        max-height: 90vh;
    }

    .cover-modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ope-white);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.5rem;
        color: var(--ope-gray-600);
        transition: all var(--transition-base);
        box-shadow: var(--shadow-md);
    }

    .cover-modal-close:hover {
        background: var(--ope-gray-100);
        color: var(--ope-dark);
    }

    /* Back Button */
    .covers-back-nav {
        margin-bottom: 1.5rem;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--ope-dark-soft);
        font-weight: 600;
        font-size: 0.9375rem;
        text-decoration: none;
        transition: all var(--transition-base);
        padding: 0.75rem 1.25rem;
        background: var(--ope-white);
        border: 1px solid var(--ope-gray-300);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
    }

    .btn-back:hover {
        color: var(--ope-primary);
        border-color: var(--ope-primary-lighter);
        background: var(--ope-gray-100);
        transform: translateX(-4px);
    }

    /* Lightbox enhancement */
    .lightbox-link {
        cursor: zoom-in;
    }

    /* Responsive */
    @media (min-width: 1600px) {
        .covers-section {
            padding-top: 180px;
        }
        .covers-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (min-width: 1920px) {
        .covers-section {
            padding-top: 200px;
        }
    }

    @media (max-width: 991px) {
        .covers-section {
            padding-top: 140px;
        }
        .covers-header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        .cover-modal {
            grid-template-columns: 1fr;
            max-height: 95vh;
        }
        .cover-modal-image {
            max-height: 300px;
        }
    }

    @media (max-width: 767px) {
        .covers-section {
            padding-top: 120px;
            padding-bottom: 60px;
        }
        .covers-filter-tabs {
            padding: 1rem;
        }
        .filter-tab {
            padding: 0.625rem 1rem;
            font-size: 0.8125rem;
        }
        .covers-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .covers-section {
            padding-top: 100px;
        }
        .covers-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<section class="covers-section">
    <div class="container">
        {{-- Back Navigation --}}
        <div class="covers-back-nav" data-aos="fade-right">
            <a href="{{ route('client.mynews', $company->slug) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Volver a Mis Noticias
            </a>
        </div>

        {{-- Page Header --}}
        <div class="covers-header" data-aos="fade-up">
            <div class="covers-header-content">
                <div class="covers-title-wrap">
                    <h1 class="covers-title">
                        <span>{{ $title }}</span>
                    </h1>
                    <p class="covers-subtitle">Explora las publicaciones del día</p>
                </div>
                <div class="covers-count">
                    <i class='bx bx-image-alt'></i>
                    {{ count($covers) }} {{ count($covers) == 1 ? 'publicación' : 'publicaciones' }}
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="covers-filter-tabs" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('client.sections', ['company' => $company, 'type' => 'primeras']) }}"
               class="filter-tab {{ request('type') == 'primeras' ? 'active' : '' }}">
                <i class='bx bx-news'></i>
                Primeras Planas
            </a>
            <a href="{{ route('client.sections', ['company' => $company, 'type' => 'politicas']) }}"
               class="filter-tab {{ request('type') == 'politicas' ? 'active' : '' }}">
                <i class='bx bx-building-house'></i>
                Columnas Políticas
            </a>
            <a href="{{ route('client.sections', ['company' => $company, 'type' => 'financieras']) }}"
               class="filter-tab {{ request('type') == 'financieras' ? 'active' : '' }}">
                <i class='bx bx-line-chart'></i>
                Columnas Financieras
            </a>
            <a href="{{ route('client.sections', ['company' => $company, 'type' => 'portadas']) }}"
               class="filter-tab {{ request('type') == 'portadas' ? 'active' : '' }}">
                <i class='bx bx-book-open'></i>
                Portadas Financieras
            </a>
            <a href="{{ route('client.sections', ['company' => $company, 'type' => 'cartones']) }}"
               class="filter-tab {{ request('type') == 'cartones' ? 'active' : '' }}">
                <i class='bx bx-palette'></i>
                Cartones
            </a>
        </div>

        {{-- Portfolio Grid --}}
        <div class="covers-grid">
            @forelse ($covers as $cover)
                @php
                    $hasContent = $cover->content && trim($cover->content) != "";
                    $isColumnType = in_array(request('type'), ['politicas', 'financieras']);
                @endphp

                <article class="cover-card {{ $hasContent ? 'has-content' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="cover-card-image">
                        <a href="{{ $cover->image->path_filename }}"
                           class="lightbox-link"
                           data-lightbox="covers"
                           data-title="{{ $cover->source->name }} - {{ $cover->date_cover->format('d/m/Y') }}">
                            <img src="{{ $cover->image->path_filename }}"
                                 alt="{{ $cover->source->name }}"
                                 loading="lazy">
                        </a>
                        <div class="cover-card-overlay">
                            <a href="{{ $cover->image->path_filename }}"
                               target="_blank"
                               class="btn-view-cover">
                                <i class='bx bx-zoom-in'></i>
                                Ver imagen
                            </a>
                        </div>
                    </div>
                    <div class="cover-card-body">
                        <h3 class="cover-source-name">{{ $cover->source->name }}</h3>
                        <div class="cover-date">
                            <i class='bx bx-calendar'></i>
                            {{ $cover->date_cover->diffForHumans() }}
                        </div>

                        @if($isColumnType || $hasContent)
                            @if($cover->title)
                                <h4 class="cover-title">{{ $cover->title }}</h4>
                            @endif
                            @if($cover->author)
                                <div class="cover-author">
                                    <i class='bx bx-user'></i>
                                    {{ $cover->author }}
                                </div>
                            @endif
                            @if($hasContent)
                                <button type="button"
                                        class="btn-read-content"
                                        data-bs-toggle="modal"
                                        data-bs-target="#coverModal{{ $cover->id }}">
                                    <i class='bx bx-book-reader'></i>
                                    Leer contenido
                                </button>
                            @endif
                        @endif
                    </div>
                </article>

                {{-- Modal for content --}}
                @if($hasContent)
                <div class="modal fade" id="coverModal{{ $cover->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" style="border-radius: var(--radius-xl); overflow: hidden;">
                            <div class="modal-header" style="background: var(--ope-gray-100); border-bottom: 1px solid var(--ope-gray-200);">
                                <div>
                                    <h5 class="modal-title" style="font-weight: 700; color: var(--ope-dark);">{{ $cover->title ?? $cover->source->name }}</h5>
                                    @if($cover->author)
                                        <p style="margin: 0; font-size: 0.875rem; color: var(--ope-gray-500);">Por {{ $cover->author }}</p>
                                    @endif
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body" style="padding: 2rem;">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <a href="{{ $cover->image->path_filename }}" target="_blank">
                                            <img src="{{ $cover->image->path_filename }}"
                                                 alt="{{ $cover->source->name }}"
                                                 class="img-fluid"
                                                 style="border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div style="font-size: 1rem; line-height: 1.8; color: var(--ope-gray-700);">
                                            {!! $cover->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="background: var(--ope-gray-100); border-top: 1px solid var(--ope-gray-200);">
                                <a href="{{ $cover->image->path_filename }}" target="_blank" class="btn-saas btn-saas-secondary">
                                    <i class='bx bx-download'></i>
                                    Descargar imagen
                                </a>
                                <button type="button" class="btn-saas btn-saas-primary" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div class="covers-empty">
                    <i class='bx bx-image-alt'></i>
                    <h3>No hay publicaciones disponibles</h3>
                    <p>No se encontraron {{ strtolower($title) }} para el día de hoy. Intenta revisar más tarde.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            once: true
        });
    }
</script>
@endsection
