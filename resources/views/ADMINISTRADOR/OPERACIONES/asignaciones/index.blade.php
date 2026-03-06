@extends('TEMPLATES.administrador')

@section('title', 'ASIGNACION DE TAREAS')

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
            grid-template-columns: repeat(6, 1fr);
            gap: 0.6rem;
            margin-bottom: 1rem;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 0.75rem 0.5rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card.active {
            transform: translateY(-3px);
        }

        .stat-card.active.sin-asignar { box-shadow: 0 3px 15px rgba(108, 117, 125, 0.35), inset 0 -3px 0 #6c757d; }
        .stat-card.active.logistica { box-shadow: 0 3px 15px rgba(13, 110, 253, 0.35), inset 0 -3px 0 #0d6efd; }
        .stat-card.active.almacen { box-shadow: 0 3px 15px rgba(111, 66, 193, 0.35), inset 0 -3px 0 #6f42c1; }
        .stat-card.active.calidad { box-shadow: 0 3px 15px rgba(214, 51, 132, 0.35), inset 0 -3px 0 #d63384; }
        .stat-card.active.despacho { box-shadow: 0 3px 15px rgba(253, 126, 20, 0.35), inset 0 -3px 0 #fd7e14; }
        .stat-card.active.completado { box-shadow: 0 3px 15px rgba(25, 135, 84, 0.35), inset 0 -3px 0 #198754; }

        .stat-card .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1rem;
        }

        .stat-card .stat-number {
            font-size: 1.4rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
            margin-bottom: 0.15rem;
        }

        .stat-card .stat-label {
            font-size: 0.62rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-card.sin-asignar .stat-icon { background: #6c757d20; color: #6c757d; }
        .stat-card.logistica .stat-icon { background: #0d6efd20; color: #0d6efd; }
        .stat-card.almacen .stat-icon { background: #6f42c120; color: #6f42c1; }
        .stat-card.calidad .stat-icon { background: #d6338420; color: #d63384; }
        .stat-card.despacho .stat-icon { background: #fd7e1420; color: #fd7e14; }
        .stat-card.completado .stat-icon { background: #19875420; color: #198754; }

        /* =============================================
           FILTERS
           ============================================= */

        .filters-card {
            background: white;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .filter-group label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
        }

        .filter-group select {
            font-size: 0.78rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 0.35rem 0.5rem;
            width: 140px;
        }

        .filter-group input {
            font-size: 0.78rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 0.35rem 0.5rem;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
        }

        /* =============================================
           TABLE CARD
           ============================================= */

        .table-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-card .table {
            font-size: 0.85rem;
        }

        .table-card .table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 700;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .bg-purple { background-color: #6f42c1 !important; }
        .bg-pink { background-color: #d63384 !important; }

        /* =============================================
           PROGRESS TRACKER (horizontal)
           ============================================= */

        .progress-tracker {
            padding: 1.5rem 0;
            overflow-x: auto;
        }

        .tracker-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-width: 550px;
            position: relative;
        }

        .tracker-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 40px;
            right: 40px;
            height: 3px;
            background: #e9ecef;
            z-index: 0;
        }

        .tracker-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            z-index: 1;
            flex: 1;
        }

        .tracker-step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            background: #e9ecef;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .tracker-step.completado .tracker-step-icon {
            background: #198754;
            color: white;
        }

        .tracker-step.activo .tracker-step-icon {
            background: #0d6efd;
            color: white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
        }

        .tracker-step.pendiente .tracker-step-icon {
            background: #e9ecef;
            color: #adb5bd;
        }

        .tracker-step-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 0.3px;
        }

        .tracker-step.completado .tracker-step-label { color: #198754; }
        .tracker-step.activo .tracker-step-label { color: #0d6efd; }
        .tracker-step.pendiente .tracker-step-label { color: #adb5bd; }

        /* =============================================
           TIMELINE VERTICAL
           ============================================= */

        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child { padding-bottom: 0; }

        .timeline-item-dot {
            position: absolute;
            left: -2.5rem;
            top: 3px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            z-index: 1;
        }

        .timeline-item-dot.completado { background: #198754; color: white; }
        .timeline-item-dot.activo { background: #0d6efd; color: white; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2); }
        .timeline-item-dot.pendiente { background: #e9ecef; color: #adb5bd; }

        .timeline-item-content {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            border: 1px solid #e9ecef;
        }

        .timeline-item-content.activo-bg {
            border-color: #0d6efd;
            background: #f0f6ff;
        }

        .timeline-item-content.pendiente-bg {
            opacity: 0.5;
        }

        .timeline-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.35rem;
        }

        .timeline-item-title { font-weight: 700; font-size: 0.88rem; color: #212529; }
        .timeline-item-description { font-size: 0.82rem; color: #495057; }

        /* =============================================
           MODAL STYLES
           ============================================= */

        #modalPedido .modal-content {
            border: none;
            border-radius: 15px;
        }

        #modalPedido .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }

        #modalPedido .modal-title {
            font-weight: 700;
        }

        #modalPedido .modal-body {
            padding: 0;
        }

        #modalPedido .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        #modalPedido .nav-tabs {
            padding: 0 1.5rem;
            border-bottom: 2px solid #e9ecef;
            background: #f8f9fa;
        }

        #modalPedido .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.85rem 1.25rem;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s ease;
        }

        #modalPedido .nav-tabs .nav-link:hover {
            color: #0d6efd;
            background: transparent;
        }

        #modalPedido .nav-tabs .nav-link.active {
            color: #0d6efd;
            background: transparent;
            border-bottom-color: #0d6efd;
        }

        #modalPedido .tab-content {
            padding: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .info-grid-item .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
        }

        .info-grid-item .info-value {
            font-size: 0.88rem;
            color: #212529;
            font-weight: 500;
        }

        .modal-loading {
            text-align: center;
            padding: 3rem;
        }

        .modal-loading .spinner-border {
            width: 2rem;
            height: 2rem;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */

        @media (max-width: 1400px) {
            .stats-row {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: repeat(3, 1fr);
            }

            .filters-card .row {
                gap: 0.75rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">
                    <i class="bi bi-clipboard-data me-2"></i>Asignaci&oacute;n de Tareas
                </h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Asignaci&oacute;n de Tareas</li>
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
            <div class="stat-card sin-asignar" data-area="sin_asignar">
                <div class="stat-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <div class="stat-number">{{ $stats['sin_asignar'] ?? 0 }}</div>
                <div class="stat-label">Sin Asignar</div>
            </div>
            <div class="stat-card logistica" data-area="logistica">
                <div class="stat-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="stat-number">{{ $stats['logistica'] ?? 0 }}</div>
                <div class="stat-label">Log&iacute;stica</div>
            </div>
            <div class="stat-card almacen" data-area="almacen">
                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-number">{{ $stats['almacen'] ?? 0 }}</div>
                <div class="stat-label">Almac&eacute;n</div>
            </div>
            <div class="stat-card calidad" data-area="calidad">
                <div class="stat-icon">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
                <div class="stat-number">{{ $stats['calidad'] ?? 0 }}</div>
                <div class="stat-label">Control Calidad</div>
            </div>
            <div class="stat-card despacho" data-area="despacho">
                <div class="stat-icon">
                    <i class="bi bi-send"></i>
                </div>
                <div class="stat-number">{{ $stats['despacho'] ?? 0 }}</div>
                <div class="stat-label">Despacho</div>
            </div>
            <div class="stat-card completado" data-area="completado">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['completado'] ?? 0 }}</div>
                <div class="stat-label">Completados</div>
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
                        <label>&Aacute;rea:</label>
                        <select class="form-select" id="filterArea">
                            <option value="">Todas</option>
                            <option value="logistica">Log&iacute;stica</option>
                            <option value="almacen">Almac&eacute;n</option>
                            <option value="calidad">Calidad</option>
                            <option value="despacho">Despacho</option>
                            <option value="sin_asignar">Sin Asignar</option>
                            <option value="completado">Completado</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="filter-group">
                        <label>Prioridad:</label>
                        <select class="form-select" id="filterPrioridad">
                            <option value="">Todas</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="filter-group">
                        <label>T&eacute;cnico:</label>
                        <select class="form-select" id="filterTecnico">
                            <option value="">Todos</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">
                                    {{ $tecnico->persona->name ?? '' }} {{ $tecnico->persona->surnames ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="filter-group">
                        <label>Fecha:</label>
                        <input type="date" class="form-control" id="filterFecha">
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-outline-secondary btn-sm" id="btnLimpiar">
                        <i class="bi bi-x-circle me-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="table-card" data-aos="fade-up" data-aos-delay="200">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablaPedidos" style="width:100%">
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Cliente</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">&Aacute;rea</th>
                            <th class="text-center">Prioridad</th>
                            <th>T&eacute;cnico</th>
                            <th>Fecha Estimada</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
    {{-- Fin contenido --}}

    <!-- Modal: Detalle del Pedido -->
    <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPedidoLabel">
                        <i class="bi bi-clipboard-data me-2"></i><span id="modal-titulo">Detalle del Pedido</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Loading -->
                    <div class="modal-loading" id="modalLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando detalle...</p>
                    </div>

                    <!-- Contenido dinámico -->
                    <div id="modalContenido" style="display: none;">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="modalTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tabDetalle-tab" data-bs-toggle="tab" data-bs-target="#tabDetalle" type="button" role="tab" aria-controls="tabDetalle" aria-selected="true">
                                    <i class="bi bi-file-earmark-text me-1"></i>Detalle y Asignaci&oacute;n
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tabProductos-tab" data-bs-toggle="tab" data-bs-target="#tabProductos" type="button" role="tab" aria-controls="tabProductos" aria-selected="false">
                                    <i class="bi bi-box me-1"></i>Productos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tabHistorial-tab" data-bs-toggle="tab" data-bs-target="#tabHistorial" type="button" role="tab" aria-controls="tabHistorial" aria-selected="false">
                                    <i class="bi bi-clock-history me-1"></i>Historial
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="modalTabsContent">
                            <!-- Tab 1: Detalle y Asignación -->
                            <div class="tab-pane fade show active" id="tabDetalle" role="tabpanel" aria-labelledby="tabDetalle-tab">
                                <!-- Info Grid -->
                                <div class="info-grid mb-4">
                                    <div class="info-grid-item">
                                        <div class="info-label">C&oacute;digo</div>
                                        <div class="info-value fw-bold" id="modal-codigo"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Fecha Pedido</div>
                                        <div class="info-value" id="modal-fecha"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Cliente</div>
                                        <div class="info-value" id="modal-cliente"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Prioridad</div>
                                        <div class="info-value" id="modal-prioridad"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Tel&eacute;fono</div>
                                        <div class="info-value" id="modal-telefono"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Estado</div>
                                        <div class="info-value" id="modal-estado"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value" id="modal-email"></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-label">Total</div>
                                        <div class="info-value fw-bold text-success" id="modal-total"></div>
                                    </div>
                                </div>

                                <!-- Dirección -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-2"><i class="bi bi-geo-alt me-2"></i>Direcci&oacute;n de Entrega</h6>
                                    <div class="bg-light p-3 rounded" id="modal-direccion"></div>
                                </div>

                                <!-- Banner de Rechazo de Calidad -->
                                <div id="modal-rechazo-banner" class="alert alert-danger border-danger mb-4" style="display:none;">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="alert-heading fw-bold mb-1">Rechazado en Control de Calidad <span id="modal-rechazo-destino" class="badge bg-dark ms-2" style="font-size:0.7rem;"></span></h6>
                                            <p class="mb-1" id="modal-rechazo-motivo"></p>
                                            <small class="text-muted">
                                                <span id="modal-rechazo-verificador"></span>
                                                <span id="modal-rechazo-fecha"></span>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Formulario de Asignación (estados normales) -->
                                <div id="seccion-asignacion" class="bg-primary bg-opacity-10 p-3 rounded">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-person-plus me-2"></i>Asignar Tarea</h6>
                                    <input type="hidden" id="asignar-pedido-id">
                                    <input type="hidden" id="asignar-estado-actual">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">&Aacute;rea</label>
                                            <select class="form-select" id="asignar-area">
                                                <option value="">Seleccionar &aacute;rea...</option>
                                                <option value="sin_asignar">Sin Asignar</option>
                                                <option value="logistica">Log&iacute;stica</option>
                                                <option value="almacen">Almac&eacute;n</option>
                                                <option value="calidad">Control de Calidad</option>
                                                <option value="despacho">Despacho</option>
                                                <option value="completado">Completado</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">T&eacute;cnico</label>
                                            <select class="form-select" id="asignar-tecnico">
                                                <option value="">Seleccionar t&eacute;cnico...</option>
                                                @foreach($tecnicos as $tecnico)
                                                    <option value="{{ $tecnico->id }}">
                                                        {{ $tecnico->persona->name ?? '' }} {{ $tecnico->persona->surnames ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Prioridad</label>
                                            <select class="form-select" id="asignar-prioridad">
                                                <option value="alta">Alta</option>
                                                <option value="media" selected>Media</option>
                                                <option value="baja">Baja</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Fecha Estimada</label>
                                            <input type="date" class="form-control" id="asignar-fecha">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label small fw-bold">Observaciones</label>
                                        <textarea class="form-control" rows="2" id="asignar-observaciones" placeholder="Agregar observaciones para el t&eacute;cnico..."></textarea>
                                    </div>
                                </div>

                                <!-- Despacho: Bot&oacute;n para marcar como completado -->
                                <div id="seccion-despacho" class="bg-warning bg-opacity-10 border border-warning p-3 rounded" style="display:none;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold mb-1"><i class="bi bi-send-check me-2"></i>Pedido en Despacho</h6>
                                            <p class="text-muted mb-0 small">Cuando el pedido haya sido entregado al cliente, marque como completado.</p>
                                        </div>
                                        <button type="button" class="btn btn-success btn-lg" id="btnMarcarCompletado">
                                            <i class="bi bi-check-circle-fill me-2"></i>Marcar como Completado
                                        </button>
                                    </div>
                                </div>

                                <!-- Completado: Info de solo lectura -->
                                <div id="seccion-completado" class="bg-success bg-opacity-10 border border-success p-3 rounded" style="display:none;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-success">Pedido Completado</h6>
                                            <p class="mb-0 small text-muted">Completado el: <span id="modal-fecha-completado" class="fw-bold text-dark"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Productos -->
                            <div class="tab-pane fade" id="tabProductos" role="tabpanel" aria-labelledby="tabProductos-tab">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center" style="width: 80px;">Cant.</th>
                                                <th class="text-end" style="width: 120px;">Precio</th>
                                                <th class="text-end" style="width: 120px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="modal-productos-body"></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                                <td class="text-end" id="modal-subtotal"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">IGV (18%):</td>
                                                <td class="text-end" id="modal-igv"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                                <td class="text-end fw-bold text-success" id="modal-total-footer"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab 3: Historial -->
                            <div class="tab-pane fade" id="tabHistorial" role="tabpanel" aria-labelledby="tabHistorial-tab">
                                <!-- Progress Tracker Horizontal -->
                                <h6 class="fw-bold mb-2"><i class="bi bi-diagram-3 me-2"></i>Progreso del Pedido</h6>
                                <div class="progress-tracker">
                                    <div class="tracker-steps" id="modal-tracker"></div>
                                </div>

                                <hr>

                                <!-- Timeline Vertical -->
                                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Recorrido del Pedido</h6>
                                <div class="timeline" id="modal-timeline"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnAsignarTarea">
                        <i class="bi bi-check-circle me-1"></i>Guardar Asignaci&oacute;n
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // =============================================
            // CONFIGURACION AJAX CON CSRF TOKEN
            // =============================================
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var baseUrlAsignaciones = "{{ url('admin-operaciones-asignaciones') }}";

            // =============================================
            // TRANSICIONES VALIDAS (replica reglas backend)
            // =============================================
            var transicionesValidas = {
                'sin_asignar': ['logistica', 'almacen', 'calidad', 'despacho'],
                'logistica': ['almacen', 'sin_asignar'],
                'almacen': ['calidad'],
                'calidad': ['despacho', 'almacen', 'logistica'],
                'despacho': ['completado'],
                'completado': []
            };

            // =============================================
            // LABELS Y COLORES
            // =============================================
            var labelsEstado = {
                sin_asignar: 'Sin Asignar',
                logistica: 'Log\u00edstica',
                almacen: 'Almac\u00e9n',
                calidad: 'Calidad',
                despacho: 'Despacho',
                completado: 'Completado'
            };

            var coloresEstado = {
                sin_asignar: 'secondary',
                logistica: 'primary',
                almacen: 'purple',
                calidad: 'pink',
                despacho: 'warning',
                completado: 'success'
            };

            var coloresPrioridad = {
                alta: 'danger',
                media: 'warning',
                baja: 'success'
            };

            var iconosEtapa = {
                sin_asignar: 'bi-cart-check',
                logistica: 'bi-truck',
                almacen: 'bi-box-seam',
                calidad: 'bi-clipboard2-check',
                despacho: 'bi-send',
                completado: 'bi-check-circle'
            };

            // =============================================
            // DATATABLE INIT (server-side)
            // =============================================
            var table = $('#tablaPedidos').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin-operaciones-asignaciones.data') }}",
                    data: function(d) {
                        d.area = $('#filterArea').val();
                        d.prioridad = $('#filterPrioridad').val();
                        d.tecnico = $('#filterTecnico').val();
                        d.fecha = $('#filterFecha').val();
                    }
                },
                columns: [
                    {
                        data: 'codigo',
                        render: function(data) {
                            return '<span class="fw-bold">' + data + '</span>';
                        }
                    },
                    { data: 'cliente_nombre' },
                    {
                        data: 'total',
                        className: 'text-end fw-bold'
                    },
                    {
                        data: 'estado_operativo',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var html = '<span class="badge bg-' + (coloresEstado[data] || 'secondary') + '">' + (labelsEstado[data] || data) + '</span>';
                            if (row.rechazado) {
                                html += ' <span class="badge bg-danger" title="' + (row.motivo_rechazo || 'Rechazado en calidad') + '" style="cursor:help"><i class="bi bi-exclamation-triangle-fill"></i> Rechazado</span>';
                            }
                            return html;
                        }
                    },
                    {
                        data: 'prioridad',
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="badge bg-' + (coloresPrioridad[data] || 'secondary') + '">' + (data ? data.charAt(0).toUpperCase() + data.slice(1) : 'Media') + '</span>';
                        }
                    },
                    {
                        data: 'tecnico_nombre',
                        render: function(data) {
                            return (data && data !== '\u2014') ? data : '<span class="text-muted">Sin asignar</span>';
                        }
                    },
                    {
                        data: 'fecha_entrega_estimada',
                        render: function(data) {
                            return (data && data !== '\u2014') ? data : '<span class="text-muted">\u2014</span>';
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return '<button class="btn btn-sm btn-outline-primary btn-ver-pedido" data-id="' + data + '"><i class="bi bi-eye"></i></button>';
                        }
                    }
                ],
                language: {
                    processing: "Procesando...",
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron pedidos",
                    emptyTable: "No hay pedidos en operaciones",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ pedidos",
                    infoEmpty: "Sin registros",
                    infoFiltered: "(filtrado de _MAX_ totales)",
                    search: "Buscar:",
                    paginate: { first: "Primero", last: "Último", next: "Sig.", previous: "Ant." }
                },
                order: [[0, 'desc']],
                pageLength: 25,
                dom: '<"row"<"col-sm-12"tr>><"row mt-3"<"col-sm-5"i><"col-sm-7"p>>'
            });

            // =============================================
            // STATS CARDS CLICK
            // =============================================
            $('.stat-card').click(function() {
                var area = $(this).data('area');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('#filterArea').val('');
                } else {
                    $('.stat-card').removeClass('active');
                    $(this).addClass('active');
                    $('#filterArea').val(area);
                }
                table.ajax.reload();
            });

            // =============================================
            // FILTER CHANGES
            // =============================================
            $('#filterArea, #filterPrioridad, #filterTecnico, #filterFecha').on('change', function() {
                var areaVal = $('#filterArea').val();
                $('.stat-card').removeClass('active');
                if (areaVal) {
                    $('.stat-card[data-area="' + areaVal + '"]').addClass('active');
                }
                table.ajax.reload();
            });

            // =============================================
            // CLEAR FILTERS
            // =============================================
            $('#btnLimpiar').click(function() {
                $('#filterArea, #filterPrioridad, #filterTecnico').val('');
                $('#filterFecha').val('');
                $('.stat-card').removeClass('active');
                table.ajax.reload();
            });

            // =============================================
            // OPEN MODAL
            // =============================================
            $(document).on('click', '.btn-ver-pedido', function() {
                var pedidoId = $(this).data('id');

                $('#modalLoading').show();
                $('#modalContenido').hide();
                $('#tabDetalle-tab').tab('show');
                $('#modalPedido').modal('show');

                $.get(baseUrlAsignaciones + "/" + pedidoId, function(data) {

                    // =============================================
                    // TAB 1 - DETALLE Y ASIGNACION
                    // =============================================
                    $('#modal-titulo').text(data.codigo + ' \u2014 ' + data.cliente_nombre);
                    $('#modal-codigo').text(data.codigo);
                    $('#modal-cliente').text(data.cliente_nombre);
                    $('#modal-telefono').text(data.cliente_celular || 'No especificado');
                    $('#modal-email').text(data.cliente_email || 'No especificado');
                    $('#modal-fecha').text(data.fecha_pedido);
                    $('#modal-total').text('S/ ' + data.total);

                    // Prioridad badge
                    var badgeP = coloresPrioridad[data.prioridad] || 'secondary';
                    $('#modal-prioridad').html('<span class="badge bg-' + badgeP + '">' + (data.prioridad ? data.prioridad.charAt(0).toUpperCase() + data.prioridad.slice(1) : 'Media') + '</span>');

                    // Estado badge
                    var badgeE = coloresEstado[data.estado_operativo] || 'secondary';
                    $('#modal-estado').html('<span class="badge bg-' + badgeE + '">' + (data.estado_operativo_label || 'Sin Asignar') + '</span>');

                    // Direccion
                    $('#modal-direccion').text((data.direccion || 'No especificada') + (data.distrito ? ' \u2014 ' + data.distrito : ''));

                    // Banner de rechazo
                    if (data.rechazo) {
                        $('#modal-rechazo-motivo').text(data.rechazo.motivo || 'Sin motivo especificado');
                        $('#modal-rechazo-verificador').text(data.rechazo.verificador ? 'Rechazado por: ' + data.rechazo.verificador : '');
                        $('#modal-rechazo-fecha').text(data.rechazo.fecha ? ' \u2014 ' + data.rechazo.fecha : '');
                        $('#modal-rechazo-destino').text(data.rechazo.area_destino_label ? 'Devuelto a: ' + data.rechazo.area_destino_label : '');
                        $('#modal-rechazo-banner').show();
                    } else {
                        $('#modal-rechazo-banner').hide();
                    }

                    // Secciones segun estado
                    $('#seccion-asignacion, #seccion-despacho, #seccion-completado').hide();
                    $('#btnAsignarTarea').hide();

                    if (data.estado_operativo === 'completado') {
                        $('#modal-fecha-completado').text(data.fecha_completado || 'No registrada');
                        $('#seccion-completado').show();
                    } else if (data.estado_operativo === 'despacho') {
                        $('#seccion-despacho').show();
                        $('#seccion-despacho').data('pedido-id', data.id);
                    } else {
                        $('#seccion-asignacion').show();
                        $('#btnAsignarTarea').show();
                    }

                    // Formulario de asignacion
                    $('#asignar-pedido-id').val(data.id);
                    $('#asignar-estado-actual').val(data.estado_operativo);
                    actualizarOpcionesArea(data.estado_operativo);
                    $('#asignar-tecnico').val(data.tecnico_id || '');
                    $('#asignar-prioridad').val(data.prioridad || 'media');
                    $('#asignar-fecha').val(data.fecha_entrega_estimada || '');
                    $('#asignar-observaciones').val(data.observaciones_operativas || '');

                    // =============================================
                    // TAB 2 - PRODUCTOS
                    // =============================================
                    var tbodyHtml = '';
                    var subtotal = 0;
                    if (data.productos && data.productos.length > 0) {
                        data.productos.forEach(function(p) {
                            tbodyHtml += '<tr>' +
                                '<td>' + p.descripcion + '</td>' +
                                '<td class="text-center">' + p.cantidad + '</td>' +
                                '<td class="text-end">S/ ' + parseFloat(p.precio_unitario).toFixed(2) + '</td>' +
                                '<td class="text-end">S/ ' + parseFloat(p.subtotal).toFixed(2) + '</td>' +
                            '</tr>';
                            subtotal += parseFloat(p.subtotal);
                        });
                    } else {
                        tbodyHtml = '<tr><td colspan="4" class="text-center text-muted">Sin productos</td></tr>';
                    }
                    $('#modal-productos-body').html(tbodyHtml);
                    $('#modal-subtotal').text('S/ ' + data.subtotal);
                    $('#modal-igv').text('S/ ' + data.igv);
                    $('#modal-total-footer').text('S/ ' + data.total);

                    // =============================================
                    // TAB 3 - HISTORIAL
                    // =============================================

                    // Progress tracker horizontal
                    var trackerHtml = '';
                    if (data.timeline) {
                        data.timeline.forEach(function(step) {
                            var dotIcon = step.estado === 'completado' ? 'bi-check' : (iconosEtapa[step.etapa] || 'bi-circle');
                            trackerHtml += '<div class="tracker-step ' + step.estado + '">' +
                                '<div class="tracker-step-icon"><i class="bi ' + dotIcon + '"></i></div>' +
                                '<span class="tracker-step-label">' + step.label + '</span>' +
                            '</div>';
                        });
                    }
                    $('#modal-tracker').html(trackerHtml);

                    // Timeline vertical
                    var timelineHtml = '';

                    // Evento de pago
                    if (data.pagado) {
                        timelineHtml += '<div class="timeline-item">' +
                            '<div class="timeline-item-dot completado"><i class="bi bi-check"></i></div>' +
                            '<div class="timeline-item-content">' +
                                '<div class="timeline-item-header">' +
                                    '<span class="timeline-item-title">Pago Confirmado</span>' +
                                '</div>' +
                                '<div class="timeline-item-description">Total: S/ ' + data.total + '</div>' +
                            '</div>' +
                        '</div>';
                    }

                    // Evento de asignacion
                    if (data.fecha_asignacion) {
                        timelineHtml += '<div class="timeline-item">' +
                            '<div class="timeline-item-dot completado"><i class="bi bi-check"></i></div>' +
                            '<div class="timeline-item-content">' +
                                '<div class="timeline-item-header">' +
                                    '<span class="timeline-item-title">Tarea Asignada</span>' +
                                    '<span style="font-size:0.75rem;color:#6c757d;">' + data.fecha_asignacion + '</span>' +
                                '</div>' +
                                '<div class="timeline-item-description">T\u00e9cnico: ' + (data.tecnico_nombre || 'Sin asignar') + '</div>' +
                            '</div>' +
                        '</div>';
                    }

                    // Etapas del Kanban
                    if (data.timeline) {
                        data.timeline.forEach(function(step) {
                            if (step.etapa === 'sin_asignar') return;

                            var dotIcon = step.estado === 'completado' ? 'bi-check' : (iconosEtapa[step.etapa] || 'bi-clock');
                            var contentClass = step.estado === 'activo' ? 'activo-bg' : (step.estado === 'pendiente' ? 'pendiente-bg' : '');

                            timelineHtml += '<div class="timeline-item">' +
                                '<div class="timeline-item-dot ' + step.estado + '"><i class="bi ' + dotIcon + '"></i></div>' +
                                '<div class="timeline-item-content ' + contentClass + '">' +
                                    '<div class="timeline-item-header">' +
                                        '<span class="timeline-item-title">' + step.label + '</span>' +
                                    '</div>' +
                                    '<div class="timeline-item-description">' + step.descripcion + '</div>' +
                                '</div>' +
                            '</div>';
                        });
                    }
                    $('#modal-timeline').html(timelineHtml);

                    // Mostrar contenido
                    $('#modalLoading').hide();
                    $('#modalContenido').show();

                }).fail(function() {
                    $('#modalLoading').html('<div class="text-danger"><i class="bi bi-exclamation-triangle" style="font-size:2rem;"></i><p class="mt-2">Error al cargar el detalle</p></div>');
                });
            });

            // =============================================
            // FILTRAR OPCIONES DE AREA SEGUN ESTADO ACTUAL
            // =============================================
            function actualizarOpcionesArea(estadoActual) {
                var permitidos = transicionesValidas[estadoActual] || [];
                $('#asignar-area option').each(function() {
                    var val = $(this).val();
                    if (val === '' || val === estadoActual) {
                        $(this).prop('disabled', false);
                    } else if (permitidos.indexOf(val) !== -1) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                    }
                });
                $('#asignar-area').val('');
            }

            // =============================================
            // ENVIAR ASIGNACION
            // =============================================
            $('#btnAsignarTarea').click(function() {
                var btn = $(this);
                var nuevoEstado = $('#asignar-area').val();

                if (!nuevoEstado) {
                    toastr.warning('Seleccione un \u00e1rea de destino');
                    return;
                }

                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Asignando...');

                $.post("{{ route('admin-operaciones-asignaciones.asignar') }}", {
                    pedido_id: $('#asignar-pedido-id').val(),
                    estado_operativo: nuevoEstado,
                    tecnico_asignado_id: $('#asignar-tecnico').val() || null,
                    prioridad: $('#asignar-prioridad').val(),
                    fecha_entrega_estimada: $('#asignar-fecha').val() || null,
                    observaciones_operativas: $('#asignar-observaciones').val()
                }, function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#modalPedido').modal('hide');
                        table.ajax.reload(null, false);
                        actualizarStats();
                    }
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Error al asignar');
                }).always(function() {
                    btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>Guardar Asignaci\u00f3n');
                });
            });

            // =============================================
            // MARCAR COMO COMPLETADO (desde despacho)
            // =============================================
            $('#btnMarcarCompletado').click(function() {
                var btn = $(this);
                var pedidoId = $('#seccion-despacho').data('pedido-id');

                Swal.fire({
                    title: '\u00bfMarcar como completado?',
                    text: 'Esto indica que el pedido fue entregado al cliente.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'S\u00ed, completar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Procesando...');

                        $.post("{{ route('admin-operaciones-asignaciones.asignar') }}", {
                            pedido_id: pedidoId,
                            estado_operativo: 'completado'
                        }, function(response) {
                            if (response.success) {
                                toastr.success('Pedido marcado como completado');
                                $('#modalPedido').modal('hide');
                                table.ajax.reload(null, false);
                                actualizarStats();
                            }
                        }).fail(function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error al completar');
                        }).always(function() {
                            btn.prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i>Marcar como Completado');
                        });
                    }
                });
            });

            // =============================================
            // ACTUALIZAR STATS
            // =============================================
            function actualizarStats() {
                $.get("{{ route('admin-operaciones-asignaciones.stats') }}", function(stats) {
                    $.each(stats, function(key, count) {
                        $('.stat-card[data-area="' + key + '"] .stat-number').text(count);
                    });
                });
            }

        });
    </script>
@endsection