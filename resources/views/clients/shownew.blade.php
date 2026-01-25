@extends('layouts.home-clientv3')
@section('title', ' - ' . Str::limit($note->title, 50))

@section('metas')
    <meta property="og:title" content="{{ $note->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($note->synthesis), 160) }}">
    <meta property="og:type" content="article">
@endsection

@section('styles')
<style>
    /* ========================================
       News Detail v3 - Premium Reading Experience
       Uses global .main-content-wrapper for header safe area
       ======================================== */

    .news-detail-section {
        /* Inherits from .main-content-wrapper via theme-saas.css */
        padding-top: var(--header-safe-area, 160px);
        padding-bottom: var(--section-padding, 100px);
        background: var(--ope-gray-100);
        min-height: 100vh;
    }

    /* Back Navigation */
    .news-back-nav {
        margin-bottom: 2rem;
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
        box-shadow: var(--shadow-md);
    }

    .btn-back i {
        font-size: 1.25rem;
        transition: transform var(--transition-base);
    }

    .btn-back:hover i {
        transform: translateX(-2px);
    }

    /* Main Content Card */
    .news-detail-card {
        background: var(--ope-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--ope-gray-200);
    }

    /* Header Section */
    .news-detail-header {
        padding: 2.5rem 3rem;
        border-bottom: 1px solid var(--ope-gray-200);
        background: linear-gradient(135deg, var(--ope-gray-100) 0%, var(--ope-white) 100%);
    }

    .news-source-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .news-source-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        padding: 0.5rem;
        background: var(--ope-white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--ope-gray-200);
    }

    .news-source-info {
        flex: 1;
    }

    .news-source-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--ope-dark);
        margin-bottom: 0.25rem;
    }

    .news-mean-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .news-mean-badge.tv { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .news-mean-badge.radio { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .news-mean-badge.prensa { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .news-mean-badge.internet { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .news-mean-badge.revista { background: rgba(139, 92, 246, 0.1); color: #7c3aed; }

    .news-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--ope-dark);
        line-height: 1.3;
        letter-spacing: -0.02em;
        margin: 0;
    }

    /* Metadata Section */
    .news-metadata {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 1.5rem 3rem;
        background: var(--ope-gray-100);
        border-bottom: 1px solid var(--ope-gray-200);
    }

    .news-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--ope-gray-600);
        font-size: 0.875rem;
    }

    .news-meta-item i {
        color: var(--ope-primary);
        font-size: 1.125rem;
    }

    .news-meta-item strong {
        color: var(--ope-dark-soft);
        font-weight: 600;
    }

    /* Content Section */
    .news-content-wrapper {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 0;
    }

    .news-main-content {
        padding: 2.5rem 3rem;
        border-right: 1px solid var(--ope-gray-200);
    }

    /* Media Player Container */
    .news-media-container {
        margin-bottom: 2rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: var(--ope-dark);
        box-shadow: var(--shadow-md);
    }

    .news-media-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .news-media-container video,
    .news-media-container audio {
        width: 100%;
        display: block;
    }

    .news-media-container iframe,
    .news-media-container embed {
        width: 100%;
        height: 450px;
        border: none;
    }

    /* Audio Player Custom */
    .audio-player-custom {
        background: linear-gradient(135deg, var(--ope-dark) 0%, #1e293b 100%);
        padding: 2rem;
        border-radius: var(--radius-lg);
        text-align: center;
    }

    .audio-player-custom i {
        font-size: 3rem;
        color: var(--ope-primary);
        margin-bottom: 1rem;
        display: block;
    }

    .audio-player-custom audio {
        width: 100%;
        max-width: 400px;
    }

    /* Video Player Container */
    .video-player-custom {
        position: relative;
        background: var(--ope-dark);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .video-player-custom video {
        width: 100%;
        display: block;
    }

    /* PDF Viewer */
    .pdf-viewer-container {
        background: var(--ope-gray-200);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .pdf-viewer-container embed,
    .pdf-viewer-container iframe {
        width: 100%;
        height: 600px;
        border: none;
    }

    /* Synthesis */
    .news-synthesis {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--ope-gray-700);
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--ope-gray-200);
    }

    .news-synthesis p {
        margin-bottom: 1rem;
    }

    .news-synthesis p:last-child {
        margin-bottom: 0;
    }

    /* Download Section */
    .news-download-section {
        background: var(--ope-gradient-soft);
        padding: 1.5rem;
        border-radius: var(--radius-lg);
        margin-bottom: 2rem;
    }

    .news-download-section h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ope-dark-soft);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .news-download-section h4 i {
        color: var(--ope-primary);
    }

    .btn-download-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
    }

    /* Other Files */
    .other-files-section {
        margin-top: 1.5rem;
    }

    .other-files-section h5 {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--ope-gray-600);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .other-files-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .other-file-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: var(--ope-white);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--ope-dark-soft);
        font-size: 0.875rem;
        transition: all var(--transition-base);
        border: 1px solid var(--ope-gray-200);
    }

    .other-file-item:hover {
        background: var(--ope-gray-100);
        border-color: var(--ope-primary-lighter);
        color: var(--ope-primary);
    }

    .other-file-item i {
        color: var(--ope-primary);
        font-size: 1.125rem;
    }

    .other-file-item span {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Sidebar */
    .news-sidebar {
        padding: 2rem;
        background: var(--ope-gray-100);
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--ope-gray-500);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--ope-gray-300);
    }

    .sidebar-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--ope-gray-200);
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-item-label {
        font-size: 0.8125rem;
        color: var(--ope-gray-500);
        font-weight: 500;
    }

    .sidebar-item-value {
        font-size: 0.875rem;
        color: var(--ope-dark);
        font-weight: 600;
        text-align: right;
        max-width: 60%;
        word-break: break-word;
    }

    .sidebar-item-value a {
        color: var(--ope-primary);
        text-decoration: none;
    }

    .sidebar-item-value a:hover {
        text-decoration: underline;
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

    .trend-badge.positive { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .trend-badge.neutral { background: rgba(107, 114, 128, 0.1); color: #6b7280; }
    .trend-badge.negative { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

    /* Responsive - Large screens (1600px+) */
    @media (min-width: 1600px) {
        .news-detail-section {
            padding: 180px 0 120px;
        }
    }

    @media (min-width: 1920px) {
        .news-detail-section {
            padding: 200px 0 140px;
        }

        /* Limit content width for better readability */
        .news-detail-card {
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* Responsive - Standard breakpoints */
    @media (max-width: 1199px) {
        .news-content-wrapper {
            grid-template-columns: 1fr 280px;
        }
    }

    @media (max-width: 991px) {
        .news-detail-section {
            padding: 140px 0 80px;
        }

        .news-content-wrapper {
            grid-template-columns: 1fr;
        }

        .news-main-content {
            border-right: none;
            border-bottom: 1px solid var(--ope-gray-200);
        }

        .news-sidebar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .sidebar-section {
            margin-bottom: 0;
        }

        .news-detail-header,
        .news-main-content {
            padding: 2rem;
        }

        .news-metadata {
            padding: 1.25rem 2rem;
        }
    }

    @media (max-width: 767px) {
        .news-detail-section {
            padding: 120px 0 60px;
        }

        .news-detail-header,
        .news-main-content {
            padding: 1.5rem;
        }

        .news-metadata {
            padding: 1rem 1.5rem;
            gap: 1rem;
        }

        .news-meta-item {
            flex: 1 1 calc(50% - 0.5rem);
        }

        .news-sidebar {
            grid-template-columns: 1fr;
            padding: 1.5rem;
        }

        .news-source-logo {
            width: 60px;
            height: 60px;
        }

        .news-title {
            font-size: 1.375rem;
        }

        .news-synthesis {
            font-size: 1rem;
        }

        .pdf-viewer-container embed,
        .pdf-viewer-container iframe {
            height: 400px;
        }
    }

    @media (max-width: 480px) {
        .news-detail-section {
            padding: 100px 0 40px;
        }

        .news-detail-header,
        .news-main-content,
        .news-sidebar {
            padding: 1rem;
        }

        .news-metadata {
            padding: 0.75rem 1rem;
            flex-direction: column;
            gap: 0.75rem;
        }

        .news-meta-item {
            flex: 1 1 100%;
        }

        .news-source-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<section class="news-detail-section">
    <div class="container">
        {{-- Back Navigation --}}
        <div class="news-back-nav" data-aos="fade-right">
            <a href="{{ route('client.mynews', $company->slug) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Volver a Mis Noticias
            </a>
        </div>

        {{-- Main Card --}}
        <div class="news-detail-card" data-aos="fade-up">
            {{-- Header --}}
            <div class="news-detail-header">
                <div class="news-source-row">
                    @if($note->source && $note->source->logo)
                        <img
                            src="{{ asset('images/' . $note->source->logo) }}"
                            alt="{{ $note->source->name }}"
                            class="news-source-logo"
                        >
                    @endif
                    <div class="news-source-info">
                        <div class="news-source-name">{{ $note->source->name ?? 'Fuente no especificada' }}</div>
                        @if($note->mean)
                            @php
                                $meanClass = match($note->mean->short_name) {
                                    'tel' => 'tv',
                                    'rad' => 'radio',
                                    'per' => 'prensa',
                                    'int' => 'internet',
                                    'rev' => 'revista',
                                    default => 'prensa'
                                };
                                $meanIcon = match($note->mean->short_name) {
                                    'tel' => 'bx-tv',
                                    'rad' => 'bx-radio',
                                    'per' => 'bx-news',
                                    'int' => 'bx-globe',
                                    'rev' => 'bx-book-open',
                                    default => 'bx-file'
                                };
                            @endphp
                            <span class="news-mean-badge {{ $meanClass }}">
                                <i class='bx {{ $meanIcon }}'></i>
                                {{ $note->mean->name }}
                            </span>
                        @endif
                    </div>
                </div>
                <h1 class="news-title">{{ $note->title }}</h1>
            </div>

            {{-- Metadata Row --}}
            <div class="news-metadata">
                <div class="news-meta-item">
                    <i class='bx bx-calendar'></i>
                    <strong>{{ $note->news_date->formatLocalized('%A %d de %B %Y') }}</strong>
                </div>
                @if($note->author)
                    <div class="news-meta-item">
                        <i class='bx bx-user'></i>
                        <span>{{ $note->author }}</span>
                    </div>
                @endif
                @if($note->section)
                    <div class="news-meta-item">
                        <i class='bx bx-category'></i>
                        <span>{{ $note->section->name }}</span>
                    </div>
                @endif
                @if($note->sector)
                    <div class="news-meta-item">
                        <i class='bx bx-briefcase'></i>
                        <span>{{ $note->sector->name }}</span>
                    </div>
                @endif
            </div>

            {{-- Content Wrapper --}}
            <div class="news-content-wrapper">
                {{-- Main Content --}}
                <div class="news-main-content">
                    {{-- Media Section --}}
                    @if($mainFile = $note->files->where('main_file', 1)->first())
                        @php
                            $extension = strtolower(pathinfo($mainFile->original_name, PATHINFO_EXTENSION));
                            $isAudio = in_array($extension, ['mp3', 'wav', 'ogg', 'mpga']);
                            $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'ogv']);
                            $isPdf = $extension === 'pdf';
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp

                        @if($isAudio)
                            {{-- Audio Player --}}
                            <div class="news-media-container">
                                <div class="audio-player-custom">
                                    <i class='bx bx-music'></i>
                                    <audio controls preload="metadata">
                                        <source src="{{ $mainFile->path_filename }}" type="audio/{{ $extension === 'mp3' ? 'mpeg' : $extension }}">
                                        Tu navegador no soporta el elemento de audio.
                                    </audio>
                                </div>
                            </div>
                        @elseif($isVideo)
                            {{-- Video Player --}}
                            <div class="news-media-container">
                                <div class="video-player-custom">
                                    <video controls preload="metadata" poster="">
                                        <source src="{{ $mainFile->path_filename }}" type="video/{{ $extension }}">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                </div>
                            </div>
                        @elseif($isPdf)
                            {{-- PDF Viewer --}}
                            <div class="pdf-viewer-container">
                                <iframe src="{{ $mainFile->path_filename }}#toolbar=1&navpanes=0" title="Documento PDF"></iframe>
                            </div>
                        @elseif($isImage)
                            {{-- Image Viewer --}}
                            <div class="news-media-container">
                                <a href="{{ $mainFile->path_filename }}" target="_blank">
                                    <img src="{{ $mainFile->path_filename }}" alt="{{ $note->title }}">
                                </a>
                            </div>
                        @else
                            {{-- Generic embed --}}
                            <div class="news-media-container">
                                {!! $mainFile->getHTML() !!}
                            </div>
                        @endif

                        {{-- Download Section --}}
                        <div class="news-download-section">
                            <h4>
                                <i class='bx bx-download'></i>
                                Archivo Principal
                            </h4>
                            <a href="{{ $mainFile->path_filename }}" target="_blank" class="btn-saas btn-saas-primary btn-download-primary">
                                <i class='bx bx-download'></i>
                                Descargar {{ strtoupper($extension) }}
                            </a>

                            {{-- Other Files --}}
                            @if($note->files->where('main_file', '<>', 1)->count() > 0)
                                <div class="other-files-section">
                                    <h5>Otros archivos adjuntos</h5>
                                    <div class="other-files-list">
                                        @foreach($note->files->where('main_file', '<>', 1) as $file)
                                            <a href="{{ $file->path_filename }}" target="_blank" class="other-file-item">
                                                <i class='bx bx-file'></i>
                                                <span>{{ $file->original_name }}</span>
                                                <i class='bx bx-download'></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Synthesis --}}
                    <div class="news-synthesis">
                        {!! nl2br(e($note->synthesis)) !!}
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="news-sidebar">
                    {{-- General Info --}}
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Detalles</h3>

                        @if($note->genre)
                            <div class="sidebar-item">
                                <span class="sidebar-item-label">Genero</span>
                                <span class="sidebar-item-value">{{ $note->genre->description }}</span>
                            </div>
                        @endif

                        @if($note->authorType)
                            <div class="sidebar-item">
                                <span class="sidebar-item-label">Tipo de Autor</span>
                                <span class="sidebar-item-value">{{ $note->authorType->description }}</span>
                            </div>
                        @endif

                        <div class="sidebar-item">
                            <span class="sidebar-item-label">Tendencia</span>
                            <span class="sidebar-item-value">
                                @php
                                    $trendClass = match($note->trend) {
                                        1 => 'positive',
                                        2 => 'neutral',
                                        default => 'negative'
                                    };
                                    $trendLabel = match($note->trend) {
                                        1 => 'Positiva',
                                        2 => 'Neutral',
                                        default => 'Negativa'
                                    };
                                    $trendIcon = match($note->trend) {
                                        1 => 'bx-trending-up',
                                        2 => 'bx-minus',
                                        default => 'bx-trending-down'
                                    };
                                @endphp
                                <span class="trend-badge {{ $trendClass }}">
                                    <i class='bx {{ $trendIcon }}'></i>
                                    {{ $trendLabel }}
                                </span>
                            </span>
                        </div>
                    </div>

                    {{-- Metrics --}}
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Metricas</h3>

                        @php
                            $fmt = numfmt_create('es_MX', \NumberFormatter::CURRENCY);
                            $fmtn = numfmt_create('es_MX', \NumberFormatter::DECIMAL);
                        @endphp

                        <div class="sidebar-item">
                            <span class="sidebar-item-label">Costo Estimado</span>
                            <span class="sidebar-item-value">{{ numfmt_format($fmt, $note->cost) }}</span>
                        </div>

                        <div class="sidebar-item">
                            <span class="sidebar-item-label">Alcance</span>
                            <span class="sidebar-item-value">{{ numfmt_format($fmtn, $note->scope) }}</span>
                        </div>
                    </div>

                    {{-- Additional Metadata by Mean Type --}}
                    @php
                        $metasNews = @unserialize($note->metas_news);
                    @endphp

                    @if($metasNews && $note->mean)
                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Informacion Adicional</h3>

                            @if(in_array($note->mean->short_name, ['tel', 'rad']))
                                {{-- TV/Radio specific --}}
                                @if(!empty($metasNews['news_hour']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">Hora</span>
                                        <span class="sidebar-item-value">{{ $metasNews['news_hour'] }}</span>
                                    </div>
                                @endif
                                @if(!empty($metasNews['news_duration']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">Duracion</span>
                                        <span class="sidebar-item-value">{{ $metasNews['news_duration'] }}</span>
                                    </div>
                                @endif
                            @elseif(in_array($note->mean->short_name, ['per', 'rev']))
                                {{-- Print/Magazine specific --}}
                                @if(!empty($metasNews['page_type_id']))
                                    @php
                                        $pageType = \App\Models\TypePage::find($metasNews['page_type_id']);
                                    @endphp
                                    @if($pageType)
                                        <div class="sidebar-item">
                                            <span class="sidebar-item-label">Tipo de Pagina</span>
                                            <span class="sidebar-item-value">{{ $pageType->description }}</span>
                                        </div>
                                    @endif
                                @endif
                                @if(!empty($metasNews['page_number']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">Pagina</span>
                                        <span class="sidebar-item-value">{{ $metasNews['page_number'] }}</span>
                                    </div>
                                @endif
                                @if(!empty($metasNews['page_size']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">Tamano</span>
                                        <span class="sidebar-item-value">{{ $metasNews['page_size'] }}</span>
                                    </div>
                                @endif
                            @elseif($note->mean->short_name === 'int')
                                {{-- Internet specific --}}
                                @if(!empty($metasNews['url']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">URL</span>
                                        <span class="sidebar-item-value">
                                            <a href="{{ $metasNews['url'] }}" target="_blank" rel="noopener">
                                                Ver original <i class='bx bx-link-external'></i>
                                            </a>
                                        </span>
                                    </div>
                                @endif
                                @if(!empty($metasNews['news_hour']))
                                    <div class="sidebar-item">
                                        <span class="sidebar-item-label">Hora</span>
                                        <span class="sidebar-item-value">{{ $metasNews['news_hour'] }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif

                    {{-- Comments --}}
                    @if($note->comments)
                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Comentarios</h3>
                            <p style="font-size: 0.875rem; color: var(--ope-gray-600); line-height: 1.6; margin: 0;">
                                {{ $note->comments }}
                            </p>
                        </div>
                    @endif
                </aside>
            </div>
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
