@extends('layouts.home-clientv3')
@section('title', " - Reportes Solicitados")

@section('styles')
<style>
    /* ========================================
       Reports List v3 - SaaS Modern Theme
       ======================================== */

    .reports-page {
        padding-top: var(--header-safe-area, 160px);
        padding-bottom: 80px;
        min-height: 100vh;
        background: var(--ope-gray-100);
    }

    /* Hero Header */
    .reports-hero {
        background: var(--ope-gradient);
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    }

    .reports-hero-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .reports-hero h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .reports-hero h1 i {
        font-size: 2.5rem;
    }

    .reports-hero p {
        color: rgba(255, 255, 255, 0.85);
        margin: 0.5rem 0 0;
        font-size: 1rem;
    }

    .reports-hero .btn-back {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 0.625rem 1.25rem;
        border-radius: var(--radius-full);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: var(--transition-base);
    }

    .reports-hero .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-1px);
    }

    /* Stats Summary */
    .reports-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--shadow-card);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.pending { background: #fef3c7; color: #d97706; }
    .stat-icon.processing { background: #dbeafe; color: #2563eb; }
    .stat-icon.generated { background: #d1fae5; color: #059669; }
    .stat-icon.downloaded { background: #e0e7ff; color: #6366f1; }

    .stat-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
    }

    .stat-info p {
        font-size: 0.875rem;
        color: var(--ope-gray-500);
        margin: 0;
    }

    /* Reports Table Card */
    .reports-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .reports-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--ope-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .reports-card-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reports-card-header h2 i {
        color: var(--ope-primary);
    }

    /* Table Styles */
    .reports-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reports-table thead {
        background: var(--ope-gray-100);
    }

    .reports-table th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--ope-gray-600);
    }

    .reports-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--ope-gray-200);
        vertical-align: middle;
    }

    .reports-table tbody tr:last-child td {
        border-bottom: none;
    }

    .reports-table tbody tr:hover {
        background: var(--ope-gray-50, #f9fafb);
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.processing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-badge.generated {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.downloaded {
        background: #e0e7ff;
        color: #4338ca;
    }

    .status-badge i {
        font-size: 0.875rem;
    }

    /* Progress Bar */
    .progress-container {
        width: 100%;
        max-width: 120px;
    }

    .progress-bar-modern {
        height: 6px;
        background: var(--ope-gray-200);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-bar-modern .progress-fill {
        height: 100%;
        background: var(--ope-gradient);
        border-radius: var(--radius-full);
        transition: width 0.3s ease;
    }

    .progress-text {
        font-size: 0.75rem;
        color: var(--ope-gray-500);
        margin-top: 0.25rem;
    }

    /* Date Range */
    .date-range {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .date-range .dates {
        font-weight: 500;
        color: var(--ope-dark);
    }

    .date-range .label {
        font-size: 0.75rem;
        color: var(--ope-gray-500);
    }

    /* Download Button */
    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--ope-gradient);
        color: #fff;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: var(--transition-base);
        border: none;
        cursor: pointer;
    }

    .btn-download:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: #fff;
    }

    .btn-download:disabled,
    .btn-download.disabled {
        background: var(--ope-gray-300);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* File Name */
    .file-name {
        font-family: monospace;
        font-size: 0.875rem;
        color: var(--ope-gray-700);
        background: var(--ope-gray-100);
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-sm);
    }

    /* Time Estimate */
    .time-estimate {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--ope-gray-600);
    }

    .time-estimate i {
        color: var(--ope-primary);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--ope-gray-300);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--ope-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--ope-gray-500);
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .reports-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .reports-hero-content {
            flex-direction: column;
            text-align: center;
        }

        .reports-page {
            padding-top: var(--header-safe-area, 140px);
        }
    }

    @media (max-width: 767px) {
        .reports-stats {
            grid-template-columns: 1fr;
        }

        .reports-table {
            display: block;
        }

        .reports-table thead {
            display: none;
        }

        .reports-table tbody {
            display: block;
        }

        .reports-table tr {
            display: block;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
        }

        .reports-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--ope-gray-100);
        }

        .reports-table td::before {
            content: attr(data-label);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--ope-gray-500);
        }
    }
</style>
@endsection

@section('content')
<div class="reports-page">
    <!-- Hero Header -->
    <div class="reports-hero">
        <div class="container">
            <div class="reports-hero-content">
                <div>
                    <h1>
                        <i class='bx bx-file'></i>
                        Reportes Solicitados
                    </h1>
                    <p>Historial y estado de tus reportes generados</p>
                </div>
                <a href="{{ route('client.report', ['company' => $company->slug]) }}" class="btn-back">
                    <i class='bx bx-plus'></i>
                    Nuevo Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success mb-4" style="border-radius: var(--radius-md);">
                <i class='bx bx-check-circle me-2'></i>
                {{ session('status') }}
            </div>
        @endif

        @php
            $pendingCount = $datos->where('status', 0)->count();
            $processingCount = $datos->where('status', 3)->count();
            $generatedCount = $datos->where('status', 1)->count();
            $downloadedCount = $datos->where('status', 2)->count();
        @endphp

        <!-- Stats Summary -->
        <div class="reports-stats">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class='bx bx-time'></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $pendingCount }}</h3>
                    <p>Pendientes</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon processing">
                    <i class='bx bx-loader-alt bx-spin'></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $processingCount }}</h3>
                    <p>Procesando</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon generated">
                    <i class='bx bx-check-circle'></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $generatedCount }}</h3>
                    <p>Generados</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon downloaded">
                    <i class='bx bx-download'></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $downloadedCount }}</h3>
                    <p>Descargados</p>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="reports-card">
            <div class="reports-card-header">
                <h2>
                    <i class='bx bx-list-ul'></i>
                    Mis Reportes
                </h2>
                <span class="text-muted" style="font-size: 0.875rem;">
                    {{ $datos->count() }} reportes en total
                </span>
            </div>

            @if($datos->isEmpty())
                <div class="empty-state">
                    <i class='bx bx-file'></i>
                    <h3>No hay reportes solicitados</h3>
                    <p>Cuando solicites un reporte, aparecera aqui para que puedas seguir su progreso.</p>
                    <a href="{{ route('client.report', ['company' => $company->slug]) }}" class="btn-saas btn-saas-primary">
                        <i class='bx bx-plus'></i>
                        Crear Primer Reporte
                    </a>
                </div>
            @else
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Archivo</th>
                            <th>Rango de Fechas</th>
                            <th>Estado</th>
                            <th>Tiempo Est.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $queueSmall = $datos->where('status', 0)->where('size', 'small')->count();
                            $queueMedium = $datos->where('status', 0)->where('size', 'medium')->count();
                            $queueBig = $datos->where('status', 0)->where('size', 'big')->count();
                        @endphp

                        @foreach($datos as $item)
                            @php
                                // Calcular tiempo estimado basado en posicion en cola
                                $timeEstimate = '';
                                if ($item->status == 0) {
                                    $position = $datos->where('status', 0)
                                        ->where('size', $item->size)
                                        ->where('id', '<=', $item->id)
                                        ->count();

                                    $timeEstimate = match($item->size) {
                                        'small' => ($position * 5) . ' min',
                                        'medium' => ($position * 30) . ' min',
                                        'big' => ($position * 60) . ' min',
                                        default => 'Calculando...',
                                    };
                                }
                            @endphp
                            <tr>
                                <td data-label="ID">
                                    <strong>#{{ $item->id }}</strong>
                                </td>
                                <td data-label="Archivo">
                                    <span class="file-name">{{ $item->name_file ?? 'Sin archivo' }}</span>
                                </td>
                                <td data-label="Fechas">
                                    <div class="date-range">
                                        <span class="dates">
                                            {{ $item->start_date ? $item->start_date->format('d/m/Y') : 'N/A' }}
                                            -
                                            {{ $item->end_date ? $item->end_date->format('d/m/Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td data-label="Estado">
                                    @switch($item->status)
                                        @case(0)
                                            <span class="status-badge pending">
                                                <i class='bx bx-time'></i>
                                                Pendiente
                                            </span>
                                            @break
                                        @case(1)
                                            <span class="status-badge generated">
                                                <i class='bx bx-check-circle'></i>
                                                Generado
                                            </span>
                                            @break
                                        @case(2)
                                            <span class="status-badge downloaded">
                                                <i class='bx bx-download'></i>
                                                Descargado
                                            </span>
                                            @break
                                        @case(3)
                                            <span class="status-badge processing">
                                                <i class='bx bx-loader-alt bx-spin'></i>
                                                Procesando
                                            </span>
                                            @break
                                        @default
                                            <span class="status-badge">
                                                <i class='bx bx-question-mark'></i>
                                                Desconocido
                                            </span>
                                    @endswitch
                                </td>
                                <td data-label="Tiempo">
                                    @if($item->status == 0)
                                        <div class="time-estimate">
                                            <i class='bx bx-time-five'></i>
                                            ~{{ $timeEstimate }}
                                        </div>
                                    @elseif($item->status == 3)
                                        <div class="progress-container">
                                            <div class="progress-bar-modern">
                                                <div class="progress-fill" style="width: 50%;"></div>
                                            </div>
                                            <div class="progress-text">En proceso...</div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Acciones">
                                    @if($item->status == 1 || $item->status == 2)
                                        <button type="button"
                                                class="btn-download download-file"
                                                data-id="{{ $item->id }}"
                                                data-url="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->name_file) }}">
                                            <i class='bx bx-download'></i>
                                            Descargar
                                        </button>
                                    @elseif($item->status == 0 || $item->status == 3)
                                        <button class="btn-download disabled" disabled>
                                            <i class='bx bx-loader-alt bx-spin'></i>
                                            Espere...
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Hidden iframe for downloads -->
<iframe id="download-frame" style="display: none;"></iframe>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle download clicks
    document.querySelectorAll('.download-file').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const url = this.dataset.url;
            const id = this.dataset.id;
            const downloadFrame = document.getElementById('download-frame');

            // Trigger download via iframe
            downloadFrame.src = url;

            // Update status to downloaded
            fetch('{{ route('client.report.cambia_estatus_reporte', ['company' => $company->slug]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id: id })
            }).then(response => {
                if (response.ok) {
                    // Update button appearance
                    this.innerHTML = '<i class="bx bx-check"></i> Descargado';

                    // Update status badge in the same row
                    const row = this.closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.className = 'status-badge downloaded';
                        statusBadge.innerHTML = '<i class="bx bx-download"></i> Descargado';
                    }
                }
            }).catch(error => {
                console.error('Error updating status:', error);
            });
        });
    });

    // Auto-refresh for pending/processing reports
    const hasPending = document.querySelector('.status-badge.pending, .status-badge.processing');
    if (hasPending) {
        setTimeout(function() {
            location.reload();
        }, 60000); // Refresh every 60 seconds
    }
});
</script>
@endsection
