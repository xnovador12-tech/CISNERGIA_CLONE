@extends('TEMPLATES.administrador')

@section('title', 'CONTROL DE CALIDAD')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
    <style>
        /* =============================================
           STATS CARDS
           ============================================= */

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.25rem;
        }

        .stat-card .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card.pendientes .stat-icon {
            background: #ffc10720;
            color: #cc9a00;
        }

        .stat-card.aprobados .stat-icon {
            background: #19875420;
            color: #198754;
        }

        .stat-card.rechazados .stat-icon {
            background: #dc354520;
            color: #dc3545;
        }

        .stat-card.total .stat-icon {
            background: #0d6efd20;
            color: #0d6efd;
        }

        /* =============================================
           PEDIDOS LIST
           ============================================= */

        .pedido-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .pedido-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pedido-card-header {
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid #e9ecef;
        }

        .pedido-card-header:hover {
            background: #f8f9fa;
        }

        .pedido-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .pedido-code {
            font-weight: 700;
            font-size: 0.95rem;
            color: #212529;
        }

        .pedido-client {
            font-size: 0.9rem;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .pedido-client i {
            color: #6c757d;
        }

        .pedido-date {
            font-size: 0.8rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .pedido-status-badges {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .status-badge-mini {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .status-badge-mini.pendiente {
            background: #ffc10720;
            color: #cc9a00;
        }

        .status-badge-mini.aprobado {
            background: #19875420;
            color: #198754;
        }

        .status-badge-mini.rechazado {
            background: #dc354520;
            color: #dc3545;
        }

        .pedido-estado-general {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }

        /* =============================================
           CHECKLIST SECTION
           ============================================= */

        .checklist-body {
            padding: 1.25rem;
            background: #fafbfc;
        }

        .checklist-section {
            background: white;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .checklist-section:last-child {
            margin-bottom: 0;
        }

        .checklist-section-header {
            padding: 0.85rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e9ecef;
        }

        .checklist-section-header.empaque {
            background: linear-gradient(135deg, #6f42c110 0%, #6f42c105 100%);
            border-left: 4px solid #6f42c1;
        }

        .checklist-section-header.facturacion {
            background: linear-gradient(135deg, #0d6efd10 0%, #0d6efd05 100%);
            border-left: 4px solid #0d6efd;
        }

        .checklist-section-header.preparacion_envio {
            background: linear-gradient(135deg, #fd7e1410 0%, #fd7e1405 100%);
            border-left: 4px solid #fd7e14;
        }

        .checklist-section-header h6 {
            font-weight: 700;
            font-size: 0.85rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checklist-items {
            padding: 0.75rem 1.25rem;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .checklist-item:last-child {
            border-bottom: none;
        }

        .checklist-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checklist-item label {
            font-size: 0.85rem;
            color: #495057;
            margin: 0;
            cursor: pointer;
        }

        .checklist-item .form-check-input {
            width: 1.15rem;
            height: 1.15rem;
            cursor: pointer;
        }

        .checklist-item .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .checklist-item-status {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-weight: 600;
        }

        /* =============================================
           OBSERVATION SECTION
           ============================================= */

        .observation-section {
            padding: 0.75rem 1.25rem;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .observation-section textarea {
            font-size: 0.85rem;
            border-radius: 8px;
            resize: none;
        }

        /* =============================================
           ACTION BUTTONS
           ============================================= */

        .checklist-actions {
            padding: 1rem 1.25rem;
            background: white;
            border-top: 2px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* =============================================
           FILTERS
           ============================================= */

        .filters-card {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
        }

        .filter-group select {
            font-size: 0.85rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .filter-group select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        /* =============================================
           PROGRESS BAR
           ============================================= */

        .checklist-progress {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checklist-progress .progress {
            width: 100px;
            height: 6px;
            border-radius: 10px;
        }

        .checklist-progress span {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6c757d;
        }

        /* =============================================
           TOGGLE ARROW
           ============================================= */

        .toggle-arrow {
            transition: transform 0.3s ease;
            font-size: 1rem;
            color: #6c757d;
        }

        .toggle-arrow.collapsed {
            transform: rotate(-90deg);
        }

        /* =============================================
           EMPTY STATE
           ============================================= */

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            color: #6c757d;
            font-weight: 600;
        }

        .empty-state p {
            color: #adb5bd;
            font-size: 0.9rem;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */

        @media (max-width: 1200px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: 1fr;
            }

            .pedido-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .pedido-status-badges {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">
                    <i class="bi bi-clipboard2-check me-2"></i>Control de Calidad
                </h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Control de Calidad</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado -->

    {{-- Contenido --}}
    <div class="container-fluid">

        <!-- Stats Cards -->
        <div class="stats-row" data-aos="fade-up">
            <div class="stat-card pendientes">
                <div class="stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-number" id="statPendientes">{{ $stats['pendientes'] }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            <div class="stat-card aprobados">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number" id="statAprobados">{{ $stats['aprobados'] }}</div>
                <div class="stat-label">Aprobados</div>
            </div>
            <div class="stat-card rechazados">
                <div class="stat-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-number" id="statRechazados">{{ $stats['rechazados'] }}</div>
                <div class="stat-label">Rechazados</div>
            </div>
            <div class="stat-card total">
                <div class="stat-icon">
                    <i class="bi bi-clipboard2-data"></i>
                </div>
                <div class="stat-number" id="statTotal">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Revisados</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-card" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div class="filter-group">
                        <label><i class="bi bi-funnel me-1"></i>Filtros:</label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="filter-group">
                        <label>Estado:</label>
                        <select class="form-select" id="filterEstado">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendientes</option>
                            <option value="en_revision">En Revisión</option>
                            <option value="aprobado">Aprobados</option>
                            <option value="rechazado">Rechazados</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-outline-secondary btn-sm" id="btnLimpiarFiltros">
                        <i class="bi bi-x-circle me-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Lista de Pedidos con Checklists -->
        <div id="pedidosContainer" data-aos="fade-up" data-aos-delay="200">
            @forelse($pedidos as $pedido)
                @php
                    $calidad = $pedido->calidad;
                    $estadoCalidad = $calidad ? $calidad->estado_calidad : 'pendiente';

                    $clienteNombre = '';
                    if ($pedido->cliente && $pedido->cliente->user && $pedido->cliente->user->persona) {
                        $persona = $pedido->cliente->user->persona;
                        $clienteNombre = trim($persona->name . ' ' . ($persona->surnames ?? ''));
                    }

                    // Calcular estado por sección
                    $seccionesConfig = [
                        'empaque' => ['label' => 'Empaque', 'icono' => 'bi-box-seam'],
                        'facturacion' => ['label' => 'Facturación', 'icono' => 'bi-receipt'],
                        'preparacion_envio' => ['label' => 'Preparación de Envío', 'icono' => 'bi-truck'],
                    ];

                    $seccionEstados = [];
                    if ($calidad) {
                        foreach ($seccionesConfig as $secKey => $secConf) {
                            $verifs = $calidad->verificaciones->filter(fn($v) => $v->checklistItem && $v->checklistItem->seccion === $secKey);
                            $total = $verifs->count();
                            $cumplidos = $verifs->where('cumple', true)->count();

                            if ($estadoCalidad === 'rechazado') {
                                $fallidos = $total - $cumplidos;
                                $seccionEstados[$secKey] = $fallidos > 0 ? 'rechazado' : ($cumplidos === $total && $total > 0 ? 'aprobado' : 'pendiente');
                            } else {
                                $seccionEstados[$secKey] = ($cumplidos === $total && $total > 0) ? 'aprobado' : 'pendiente';
                            }
                        }
                    } else {
                        foreach ($seccionesConfig as $secKey => $secConf) {
                            $seccionEstados[$secKey] = 'pendiente';
                        }
                    }

                    // Estado general badge
                    $estadoBadge = match($estadoCalidad) {
                        'aprobado' => ['class' => 'bg-success bg-opacity-10 text-success', 'icono' => 'bi-check-circle', 'texto' => 'Aprobado'],
                        'rechazado' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icono' => 'bi-x-circle', 'texto' => 'Rechazado'],
                        'en_revision' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icono' => 'bi-clock', 'texto' => 'En Verificación'],
                        default => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icono' => 'bi-clock', 'texto' => 'Pendiente de Verificación'],
                    };
                @endphp

                <div class="pedido-card" data-pedido-id="{{ $pedido->id }}" data-estado-calidad="{{ $estadoCalidad }}">
                    <div class="pedido-card-header" data-bs-toggle="collapse" data-bs-target="#pedido{{ $pedido->id }}">
                        <div class="pedido-info">
                            <span class="pedido-code">{{ $pedido->codigo }}</span>
                            <span class="pedido-client"><i class="bi bi-person"></i> {{ $clienteNombre ?: 'Sin cliente' }}</span>
                            <span class="pedido-date"><i class="bi bi-calendar3"></i> {{ $pedido->created_at->format('d M Y') }}</span>
                            <span class="pedido-estado-general badge {{ $estadoBadge['class'] }}">
                                <i class="bi {{ $estadoBadge['icono'] }} me-1"></i>{{ $estadoBadge['texto'] }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="pedido-status-badges">
                                @foreach($seccionesConfig as $secKey => $secConf)
                                    <span class="status-badge-mini {{ $seccionEstados[$secKey] }}" title="{{ $secConf['label'] }}: {{ ucfirst($seccionEstados[$secKey]) }}">
                                        <i class="bi {{ $secConf['icono'] }}"></i>
                                    </span>
                                @endforeach
                            </div>
                            <i class="bi bi-chevron-down toggle-arrow collapsed"></i>
                        </div>
                    </div>
                    <div class="collapse" id="pedido{{ $pedido->id }}">
                        <div class="checklist-body">
                            <div class="text-center py-4" id="loader-{{ $pedido->id }}">
                                <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                                <span class="ms-2 text-muted">Cargando verificaciones...</span>
                            </div>
                            <div id="checklist-content-{{ $pedido->id }}" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-clipboard2-check d-block"></i>
                    <h5>No hay pedidos en Control de Calidad</h5>
                    <p>Los pedidos aparecerán aquí cuando sean movidos desde Almacén en el tablero Kanban.</p>
                </div>
            @endforelse
        </div>
        {{-- Fin lista pedidos --}}

    </div>
    {{-- Fin contenido --}}

    <!-- Modal de Rechazo -->
    <div class="modal fade" id="modalRechazo" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger bg-opacity-10">
                    <h5 class="modal-title text-danger"><i class="bi bi-x-circle me-2"></i>Rechazar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="rechazo_pedido_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivo del rechazo <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rechazo_motivo" rows="4" placeholder="Describa detalladamente el motivo del rechazo..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btnConfirmarRechazo">
                        <i class="bi bi-x-circle me-1"></i>Confirmar Rechazo
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // CSRF setup
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var baseUrlCalidad = "{{ url('admin-operaciones-calidad') }}";

            // =============================================
            // CARGAR CHECKLISTS AL EXPANDIR PEDIDO
            // =============================================
            $('.pedido-card-header').click(function() {
                let $arrow = $(this).find('.toggle-arrow');
                $arrow.toggleClass('collapsed');

                let pedidoId = $(this).closest('.pedido-card').data('pedido-id');
                let $content = $(`#checklist-content-${pedidoId}`);
                let $loader = $(`#loader-${pedidoId}`);

                // Solo cargar si no se ha cargado antes
                if ($content.data('loaded')) return;

                $.get(baseUrlCalidad + '/' + pedidoId, function(data) {
                    let html = buildChecklistHTML(data);
                    $content.html(html).show();
                    $loader.hide();
                    $content.data('loaded', true);

                    // Bind events
                    bindCheckboxEvents(pedidoId);
                    bindActionButtons(pedidoId);

                }).fail(function() {
                    $loader.html('<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Error al cargar los datos.</span>');
                });
            });

            // =============================================
            // CONSTRUIR HTML DE CHECKLISTS
            // =============================================
            function buildChecklistHTML(data) {
                let secciones = data.secciones;
                let esRechazado = data.estado_calidad === 'rechazado';
                let esAprobado = data.estado_calidad === 'aprobado';
                let disabled = esRechazado || esAprobado;

                let html = '<div class="row g-3">';

                $.each(secciones, function(secKey, seccion) {
                    let pctColor = 'bg-secondary';
                    if (seccion.porcentaje >= 100) pctColor = 'bg-success';
                    else if (seccion.porcentaje > 0) pctColor = 'bg-warning';

                    html += `<div class="col-md-4">
                        <div class="checklist-section" ${esRechazado && seccion.cumplidos < seccion.total ? 'style="border-color:#dc3545;"' : ''}>
                            <div class="checklist-section-header ${secKey}">
                                <h6><i class="bi ${seccion.icono}"></i> ${seccion.label}</h6>`;

                    if (disabled && seccion.cumplidos === seccion.total && seccion.total > 0) {
                        html += `<span class="badge bg-success">Aprobado</span>`;
                    } else if (esRechazado && seccion.cumplidos < seccion.total) {
                        html += `<span class="badge bg-danger">Observado</span>`;
                    } else {
                        html += `<div class="checklist-progress">
                                    <div class="progress">
                                        <div class="progress-bar ${pctColor}" style="width: ${seccion.porcentaje}%" id="progress-bar-${data.id}-${secKey}"></div>
                                    </div>
                                    <span id="progress-text-${data.id}-${secKey}">${seccion.cumplidos}/${seccion.total}</span>
                                </div>`;
                    }

                    html += `</div><div class="checklist-items">`;

                    $.each(seccion.verificaciones, function(i, v) {
                        let checked = v.cumple ? 'checked' : '';
                        let disabledAttr = disabled ? 'disabled' : '';
                        let labelClass = disabled && v.cumple ? 'text-muted' : (esRechazado && !v.cumple ? 'text-danger' : '');

                        html += `<div class="checklist-item">
                            <div class="checklist-item-left">
                                <input class="form-check-input check-item" type="checkbox" ${checked} ${disabledAttr}
                                    data-verificacion-id="${v.id}"
                                    data-pedido-id="${data.id}"
                                    data-seccion="${secKey}"
                                    id="check_${v.id}">
                                <label for="check_${v.id}" class="${labelClass}">${v.descripcion}</label>
                            </div>`;

                        if (v.cumple) {
                            html += `<span class="checklist-item-status badge bg-success bg-opacity-10 text-success">&check;</span>`;
                        } else if (esRechazado) {
                            html += `<span class="checklist-item-status badge bg-danger bg-opacity-10 text-danger">&cross;</span>`;
                        }

                        html += `</div>`;
                    });

                    html += `</div></div></div>`;
                });

                html += '</div>';

                // Alerta de rechazo si aplica
                if (esRechazado && data.motivo_rechazo) {
                    let verificadorInfo = data.verificador_nombre || 'Sistema';
                    let fechaInfo = data.fecha_verificacion ? `, ${data.fecha_verificacion}` : '';

                    html += `<div class="alert alert-danger border-0 mt-3 mb-0 d-flex align-items-start gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                        <div>
                            <strong>Motivo del rechazo:</strong> ${escapeHtml(data.motivo_rechazo)}
                            <br><small class="text-muted">Rechazado por: ${escapeHtml(verificadorInfo)}${fechaInfo}</small>
                        </div>
                    </div>`;
                }

                // Botones de acción
                if (!esAprobado && !esRechazado) {
                    html += `<div class="checklist-actions mt-3">
                        <button class="btn btn-outline-danger btn-sm btn-rechazar" data-pedido-id="${data.id}">
                            <i class="bi bi-x-circle me-1"></i>Rechazar
                        </button>
                        <button class="btn btn-success btn-sm btn-aprobar" data-pedido-id="${data.id}">
                            <i class="bi bi-check-circle me-1"></i>Aprobar Pedido
                        </button>
                    </div>`;
                } else if (esRechazado) {
                    html += `<div class="checklist-actions mt-3">
                        <span class="text-muted fst-italic me-auto" style="font-size:0.85rem;">
                            <i class="bi bi-info-circle me-1"></i>Este pedido fue devuelto a Almacén para corrección.
                        </span>
                    </div>`;
                } else if (esAprobado) {
                    html += `<div class="checklist-actions mt-3">
                        <span class="text-success fst-italic me-auto" style="font-size:0.85rem;">
                            <i class="bi bi-check-circle me-1"></i>Pedido aprobado y movido a Despacho${data.fecha_verificacion ? ' el ' + data.fecha_verificacion : ''}.
                        </span>
                    </div>`;
                }

                return html;
            }

            // =============================================
            // ESCAPE HTML
            // =============================================
            function escapeHtml(text) {
                if (!text) return '';
                let div = document.createElement('div');
                div.appendChild(document.createTextNode(text));
                return div.innerHTML;
            }

            // =============================================
            // BIND CHECKBOX EVENTS
            // =============================================
            function bindCheckboxEvents(pedidoId) {
                $(`#checklist-content-${pedidoId}`).on('change', '.check-item', function() {
                    let $cb = $(this);
                    let verificacionId = $cb.data('verificacion-id');
                    let seccion = $cb.data('seccion');
                    let cumple = $cb.is(':checked');

                    $cb.prop('disabled', true);

                    $.post('{{ route("admin-operaciones-calidad.guardar-check") }}', {
                        verificacion_id: verificacionId,
                        cumple: cumple ? 1 : 0,
                    }, function(res) {
                        $cb.prop('disabled', false);

                        // Actualizar barra de progreso
                        let $bar = $(`#progress-bar-${pedidoId}-${seccion}`);
                        let $text = $(`#progress-text-${pedidoId}-${seccion}`);

                        if ($bar.length) {
                            $bar.css('width', res.porcentaje + '%');
                            $bar.removeClass('bg-secondary bg-warning bg-success');
                            if (res.porcentaje >= 100) $bar.addClass('bg-success');
                            else if (res.porcentaje > 0) $bar.addClass('bg-warning');
                            else $bar.addClass('bg-secondary');
                        }
                        if ($text.length) {
                            $text.text(res.cumplidos + '/' + res.total);
                        }

                        // Actualizar mini badge del header
                        updateMiniBadge(pedidoId, seccion, res.cumplidos, res.total);

                        // Actualizar status del item
                        let $item = $cb.closest('.checklist-item');
                        $item.find('.checklist-item-status').remove();
                        if (cumple) {
                            $item.append('<span class="checklist-item-status badge bg-success bg-opacity-10 text-success">&check;</span>');
                        }

                    }).fail(function() {
                        $cb.prop('disabled', false);
                        $cb.prop('checked', !cumple);
                        toastr.error('Error al guardar la verificación.');
                    });
                });
            }

            // =============================================
            // UPDATE MINI BADGE
            // =============================================
            function updateMiniBadge(pedidoId, seccion, cumplidos, total) {
                let seccionIdx = { 'empaque': 0, 'facturacion': 1, 'preparacion_envio': 2 };
                let idx = seccionIdx[seccion];
                let $card = $(`.pedido-card[data-pedido-id="${pedidoId}"]`);
                let $badges = $card.find('.status-badge-mini');

                if ($badges.length > idx) {
                    let $badge = $($badges[idx]);
                    $badge.removeClass('pendiente aprobado rechazado');
                    if (cumplidos === total && total > 0) {
                        $badge.addClass('aprobado');
                    } else {
                        $badge.addClass('pendiente');
                    }
                }
            }

            // =============================================
            // BIND ACTION BUTTONS
            // =============================================
            function bindActionButtons(pedidoId) {
                let $content = $(`#checklist-content-${pedidoId}`);

                // Aprobar
                $content.on('click', '.btn-aprobar', function() {
                    let pid = $(this).data('pedido-id');

                    Swal.fire({
                        title: '¿Aprobar este pedido?',
                        text: 'El pedido será movido automáticamente a Despacho.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, aprobar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post('{{ route("admin-operaciones-calidad.aprobar") }}', {
                                pedido_id: pid,
                            }, function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Aprobado',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                                setTimeout(() => location.reload(), 1500);
                            }).fail(function(xhr) {
                                let msg = xhr.responseJSON?.message || 'Error al aprobar el pedido.';
                                let faltantes = xhr.responseJSON?.faltantes || 0;
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No se puede aprobar',
                                    html: msg + (faltantes > 0 ? '<br><small class="text-muted">Complete todos los checks antes de aprobar.</small>' : ''),
                                    confirmButtonColor: '#fd7e14',
                                });
                            });
                        }
                    });
                });

                // Rechazar - abrir modal
                $content.on('click', '.btn-rechazar', function() {
                    let pid = $(this).data('pedido-id');
                    $('#rechazo_pedido_id').val(pid);
                    $('#rechazo_motivo').val('');
                    $('#modalRechazo').modal('show');
                });
            }

            // =============================================
            // CONFIRMAR RECHAZO
            // =============================================
            $('#btnConfirmarRechazo').click(function() {
                let pedidoId = $('#rechazo_pedido_id').val();
                let motivo = $('#rechazo_motivo').val().trim();

                if (!motivo) {
                    toastr.warning('Debe ingresar el motivo del rechazo.');
                    return;
                }

                let $btn = $(this);
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Procesando...');

                $.post('{{ route("admin-operaciones-calidad.rechazar") }}', {
                    pedido_id: pedidoId,
                    motivo_rechazo: motivo,
                }, function(res) {
                    $('#modalRechazo').modal('hide');
                    toastr.success(res.message);
                    setTimeout(() => location.reload(), 1200);
                }).fail(function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Error al rechazar el pedido.';
                    toastr.error(msg);
                    $btn.prop('disabled', false).html('<i class="bi bi-x-circle me-1"></i>Confirmar Rechazo');
                });
            });

            // =============================================
            // FILTROS
            // =============================================
            $('#filterEstado').change(function() {
                filterCards();
            });

            $('#btnLimpiarFiltros').click(function() {
                $('#filterEstado').val('');
                filterCards();
            });

            function filterCards() {
                let estadoFilter = $('#filterEstado').val();

                $('.pedido-card').each(function() {
                    let estadoCalidad = $(this).data('estado-calidad');
                    let show = true;

                    if (estadoFilter) {
                        if (estadoFilter === 'pendiente') {
                            show = (estadoCalidad === 'pendiente' || estadoCalidad === 'en_revision');
                        } else {
                            show = (estadoCalidad === estadoFilter);
                        }
                    }

                    $(this).toggle(show);
                });
            }

            console.log('Módulo de Control de Calidad cargado correctamente');
        });
    </script>
@endsection
