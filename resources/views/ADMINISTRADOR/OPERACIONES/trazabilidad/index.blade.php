@extends('TEMPLATES.administrador')

@section('title', 'CONSULTA DE PEDIDOS')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
    <style>
        /* =============================================
           SEARCH SECTION
           ============================================= */

        .search-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper .form-control {
            padding: 0.85rem 1rem 0.85rem 3rem;
            font-size: 1rem;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-wrapper .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
            z-index: 5;
        }

        .search-wrapper .search-spinner {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            max-height: 300px;
            overflow-y: auto;
            z-index: 100;
            display: none;
        }

        .search-results::-webkit-scrollbar {
            width: 5px;
        }

        .search-results::-webkit-scrollbar-track {
            background: transparent;
        }

        .search-results::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 5px;
        }

        .search-result-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f3f5;
            transition: background 0.15s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background: #f0f6ff;
        }

        .search-result-item .result-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .search-result-item .result-codigo {
            font-weight: 700;
            font-size: 0.88rem;
            color: #212529;
        }

        .search-result-item .result-cliente {
            font-size: 0.78rem;
            color: #6c757d;
        }

        .search-result-item .result-total {
            font-size: 0.78rem;
            font-weight: 600;
            color: #198754;
        }

        .search-no-results {
            padding: 1.5rem;
            text-align: center;
            color: #6c757d;
        }

        .search-no-results i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* =============================================
           RECENT TAGS
           ============================================= */

        .recent-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }

        .recent-tag {
            font-size: 0.72rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            background: #e9ecef;
            color: #495057;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            border: none;
        }

        .recent-tag:hover {
            background: #0d6efd;
            color: white;
        }

        .recent-tags-label {
            font-size: 0.7rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* =============================================
           RESULT CARD
           ============================================= */

        .result-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .result-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f5;
        }

        .result-card-header .header-info h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #212529;
        }

        .result-card-header .header-info .subtitle {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .badge-estado-op {
            font-size: 0.72rem;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-purple { background-color: #6f42c1 !important; }
        .bg-pink { background-color: #d63384 !important; }

        /* =============================================
           INFO GRID
           ============================================= */

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .info-grid-item {
            padding: 0.65rem 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-grid-item .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.15rem;
        }

        .info-grid-item .info-value {
            font-size: 0.88rem;
            color: #212529;
            font-weight: 500;
        }

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
           PRODUCTS TABLE
           ============================================= */

        .products-table {
            font-size: 0.85rem;
        }

        .products-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 700;
            color: #495057;
        }

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
           ACTION BUTTONS
           ============================================= */

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 2px solid #f1f3f5;
        }

        /* =============================================
           LOADING OVERLAY
           ============================================= */

        .result-loading {
            text-align: center;
            padding: 3rem;
            display: none;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .result-card-header {
                flex-direction: column;
                gap: 0.75rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .search-result-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.4rem;
            }
        }

        @media (max-width: 576px) {
            .search-card {
                padding: 1rem;
            }

            .result-card {
                padding: 1rem;
            }

            .search-wrapper .form-control {
                font-size: 0.9rem;
                padding: 0.75rem 0.85rem 0.75rem 2.5rem;
            }
        }

        /* =============================================
           PRINT STYLES
           ============================================= */

        @media print {
            .search-card,
            .action-buttons,
            nav,
            .offcanvas,
            .header_section {
                display: none !important;
            }

            .result-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
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
                    <i class="bi bi-diagram-3 me-2"></i>Consulta de Pedidos
                </h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Trazabilidad</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado -->

    {{-- Contenido --}}
    <div class="container-fluid">

        <!-- Search Section -->
        <div class="search-card" data-aos="fade-up">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-search me-2"></i>Buscar Pedido
            </h6>
            <div class="search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text"
                       class="form-control"
                       id="searchInput"
                       placeholder="Buscar por código de pedido o nombre del cliente..."
                       autocomplete="off">
                <div class="search-spinner">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Buscando...</span>
                    </div>
                </div>
                <div class="search-results" id="searchResults"></div>
            </div>

            <!-- Recent Searches -->
            <div id="recentContainer" style="display: none;">
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="recent-tags-label"><i class="bi bi-clock-history me-1"></i>Recientes:</span>
                    <div class="recent-tags" id="recentTags"></div>
                </div>
            </div>
        </div>

        <!-- Result Loading -->
        <div class="result-loading" id="resultLoading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 text-muted">Cargando información del pedido...</p>
        </div>

        <!-- Result Section -->
        <div class="result-card" id="resultCard" data-aos="fade-up">

            <!-- Header -->
            <div class="result-card-header">
                <div class="header-info">
                    <h4 id="result-codigo"></h4>
                    <span class="subtitle" id="result-origen"></span>
                </div>
                <span class="badge-estado-op badge" id="result-estado-badge"></span>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-grid-item">
                    <div class="info-label">Cliente</div>
                    <div class="info-value" id="result-cliente"></div>
                </div>
                <div class="info-grid-item">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value" id="result-telefono"></div>
                </div>
                <div class="info-grid-item">
                    <div class="info-label">Dirección de Entrega</div>
                    <div class="info-value" id="result-direccion"></div>
                </div>
                <div class="info-grid-item">
                    <div class="info-label">Total del Pedido</div>
                    <div class="info-value fw-bold text-success" id="result-total"></div>
                </div>
                <div class="info-grid-item">
                    <div class="info-label">Fecha del Pedido</div>
                    <div class="info-value" id="result-fecha"></div>
                </div>
                <div class="info-grid-item">
                    <div class="info-label">Técnico Asignado</div>
                    <div class="info-value" id="result-tecnico"></div>
                </div>
            </div>

            <!-- Progress Tracker Horizontal -->
            <h6 class="fw-bold mb-2"><i class="bi bi-arrow-right-circle me-2 text-primary"></i>Progreso del Pedido</h6>
            <div class="progress-tracker">
                <div class="tracker-steps" id="result-tracker"></div>
            </div>

            <hr>

            <!-- Products Table -->
            <h6 class="fw-bold mb-3"><i class="bi bi-box me-2"></i>Productos del Pedido</h6>
            <div class="table-responsive mb-4">
                <table class="table table-sm table-bordered products-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center" style="width: 70px;">Cant.</th>
                            <th class="text-end" style="width: 110px;">Precio</th>
                            <th class="text-end" style="width: 110px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="result-productos"></tbody>
                    <tfoot id="result-totales"></tfoot>
                </table>
            </div>

            <!-- Timeline Vertical -->
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Recorrido del Pedido</h6>
            <div class="timeline" id="result-timeline"></div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin-operaciones-asignaciones.index') }}" class="btn btn-outline-primary btn-sm" id="btnVerAsignaciones">
                    <i class="bi bi-kanban me-1"></i>Ver en Asignaciones
                </a>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnImprimir">
                    <i class="bi bi-printer me-1"></i>Imprimir
                </button>
            </div>

        </div>

    </div>
    {{-- Fin contenido --}}

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            var debounceTimer;
            var baseUrlTrazabilidad = "{{ url('admin-operaciones-trazabilidad') }}";

            var iconosEtapa = {
                'sin_asignar': 'bi-cart-check',
                'logistica': 'bi-truck',
                'almacen': 'bi-box-seam',
                'calidad': 'bi-clipboard2-check',
                'despacho': 'bi-send',
                'completado': 'bi-check-circle'
            };

            var labelsEstado = {
                'sin_asignar': 'Sin Asignar',
                'logistica': 'Logística',
                'almacen': 'Almacén',
                'calidad': 'Calidad',
                'despacho': 'Despacho',
                'completado': 'Completado'
            };

            var coloresEstado = {
                'sin_asignar': 'secondary',
                'logistica': 'primary',
                'almacen': 'purple',
                'calidad': 'pink',
                'despacho': 'warning',
                'completado': 'success'
            };

            // =============================================
            // RECENT SEARCHES (localStorage)
            // =============================================
            function loadRecientes() {
                var recientes = JSON.parse(localStorage.getItem('trazabilidad_recientes') || '[]');
                if (recientes.length === 0) {
                    $('#recentContainer').hide();
                    return;
                }
                var html = '';
                recientes.forEach(function(text) {
                    html += '<button type="button" class="recent-tag">' + $('<span>').text(text).html() + '</button>';
                });
                $('#recentTags').html(html);
                $('#recentContainer').show();
            }

            function saveReciente(text) {
                if (!text) return;
                var recientes = JSON.parse(localStorage.getItem('trazabilidad_recientes') || '[]');
                // Remove if already exists
                recientes = recientes.filter(function(item) { return item !== text; });
                // Add at the beginning
                recientes.unshift(text);
                // Keep only last 5
                recientes = recientes.slice(0, 5);
                localStorage.setItem('trazabilidad_recientes', JSON.stringify(recientes));
                loadRecientes();
            }

            // Load on page init
            loadRecientes();

            // =============================================
            // SEARCH INPUT WITH DEBOUNCE
            // =============================================
            $('#searchInput').on('input', function() {
                var q = $(this).val().trim();
                clearTimeout(debounceTimer);

                if (q.length < 2) {
                    $('#searchResults').hide();
                    $('.search-spinner').hide();
                    return;
                }

                $('.search-spinner').show();

                debounceTimer = setTimeout(function() {
                    $.get("{{ route('admin-operaciones-trazabilidad.buscar') }}", { q: q }, function(data) {
                        $('.search-spinner').hide();

                        if (!data || data.length === 0) {
                            $('#searchResults').html(
                                '<div class="search-no-results">' +
                                    '<i class="bi bi-inbox"></i>' +
                                    '<span>No se encontraron resultados para "<strong>' + $('<span>').text(q).html() + '</strong>"</span>' +
                                '</div>'
                            ).show();
                            return;
                        }

                        var html = '';
                        data.forEach(function(item) {
                            var badgeColor = coloresEstado[item.estado_operativo] || 'secondary';
                            var badgeLabel = labelsEstado[item.estado_operativo] || item.estado_operativo;
                            var badgeClass = 'bg-' + badgeColor;
                            // Handle text-dark for warning badge
                            var textClass = (badgeColor === 'warning') ? ' text-dark' : '';

                            html += '<div class="search-result-item" data-pedido-id="' + item.id + '" data-codigo="' + $('<span>').text(item.codigo).html() + '">' +
                                '<div class="result-info">' +
                                    '<span class="result-codigo">' + $('<span>').text(item.codigo).html() + '</span>' +
                                    '<span class="result-cliente"><i class="bi bi-person me-1"></i>' + $('<span>').text(item.cliente_nombre || 'Sin nombre').html() + '</span>' +
                                '</div>' +
                                '<div class="d-flex align-items-center gap-2">' +
                                    '<span class="result-total">S/ ' + parseFloat(item.total).toFixed(2) + '</span>' +
                                    '<span class="badge ' + badgeClass + textClass + '" style="font-size: 0.65rem;">' + badgeLabel + '</span>' +
                                '</div>' +
                            '</div>';
                        });

                        $('#searchResults').html(html).show();

                    }).fail(function() {
                        $('.search-spinner').hide();
                        $('#searchResults').html(
                            '<div class="search-no-results">' +
                                '<i class="bi bi-exclamation-triangle text-danger"></i>' +
                                '<span class="text-danger">Error al realizar la búsqueda</span>' +
                            '</div>'
                        ).show();
                    });
                }, 300);
            });

            // =============================================
            // CLICK ON SEARCH RESULT
            // =============================================
            $(document).on('click', '.search-result-item', function() {
                var pedidoId = $(this).data('pedido-id');
                var codigo = $(this).data('codigo');

                // Save to recent searches
                saveReciente(codigo);

                // Hide dropdown
                $('#searchResults').hide();

                // Load pedido detail
                cargarPedido(pedidoId);
            });

            // =============================================
            // LOAD PEDIDO DETAIL
            // =============================================
            function cargarPedido(id) {
                $('#resultCard').hide();
                $('#resultLoading').show();

                $.get(baseUrlTrazabilidad + "/" + id, function(data) {

                    // Header
                    $('#result-codigo').text(data.codigo);
                    var origenText = 'Origen: ' + (data.origen === 'ecommerce' ? 'E-commerce' : 'Manual') + ' | Fecha: ' + data.fecha_pedido;
                    $('#result-origen').text(origenText);

                    // Estado badge
                    var badgeColor = coloresEstado[data.estado_operativo] || 'secondary';
                    var badgeLabel = data.estado_operativo_label || labelsEstado[data.estado_operativo] || data.estado_operativo;
                    var badgeClass = 'bg-' + badgeColor;
                    var textClass = (badgeColor === 'warning') ? ' text-dark' : '';
                    $('#result-estado-badge').attr('class', 'badge-estado-op badge ' + badgeClass + textClass).html(
                        '<i class="bi bi-arrow-repeat me-1"></i>' + badgeLabel
                    );

                    // Info grid
                    $('#result-cliente').html('<i class="bi bi-person me-1 text-muted"></i>' + (data.cliente_nombre || 'No especificado'));
                    $('#result-telefono').html('<i class="bi bi-telephone me-1 text-muted"></i>' + (data.cliente_celular || 'No especificado'));
                    $('#result-direccion').html('<i class="bi bi-geo-alt me-1 text-muted"></i>' + (data.direccion || 'No especificada'));
                    $('#result-total').html('<i class="bi bi-cash me-1"></i>S/ ' + data.total);
                    $('#result-fecha').html('<i class="bi bi-calendar3 me-1 text-muted"></i>' + (data.fecha_pedido || 'No especificada'));
                    $('#result-tecnico').html('<i class="bi bi-person-badge me-1 text-muted"></i>' + (data.tecnico_nombre || 'Sin asignar'));

                    // Progress tracker horizontal
                    var trackerHtml = '';
                    if (data.timeline && data.timeline.length > 0) {
                        data.timeline.forEach(function(step) {
                            var iconClass = iconosEtapa[step.etapa] || 'bi-circle';
                            var dotIcon = step.estado === 'completado' ? 'bi-check' : iconClass;
                            trackerHtml += '<div class="tracker-step ' + step.estado + '">' +
                                '<div class="tracker-step-icon"><i class="bi ' + dotIcon + '"></i></div>' +
                                '<span class="tracker-step-label">' + step.label + '</span>' +
                            '</div>';
                        });
                    }
                    $('#result-tracker').html(trackerHtml);

                    // Products table
                    var tbodyHtml = '';
                    if (data.productos && data.productos.length > 0) {
                        data.productos.forEach(function(p) {
                            tbodyHtml += '<tr>' +
                                '<td>' + $('<span>').text(p.descripcion).html() + '</td>' +
                                '<td class="text-center">' + p.cantidad + '</td>' +
                                '<td class="text-end">S/ ' + parseFloat(p.precio_unitario).toFixed(2) + '</td>' +
                                '<td class="text-end">S/ ' + parseFloat(p.subtotal).toFixed(2) + '</td>' +
                            '</tr>';
                        });
                    } else {
                        tbodyHtml = '<tr><td colspan="4" class="text-center text-muted">Sin productos</td></tr>';
                    }
                    $('#result-productos').html(tbodyHtml);

                    // Totals footer
                    $('#result-totales').html(
                        '<tr><td colspan="3" class="text-end fw-bold">Subtotal:</td><td class="text-end">S/ ' + (data.subtotal || '0.00') + '</td></tr>' +
                        '<tr><td colspan="3" class="text-end fw-bold">IGV (18%):</td><td class="text-end">S/ ' + (data.igv || '0.00') + '</td></tr>' +
                        '<tr><td colspan="3" class="text-end fw-bold">Total:</td><td class="text-end fw-bold text-success">S/ ' + data.total + '</td></tr>'
                    );

                    // Timeline vertical
                    var timelineHtml = '';

                    // Pago event
                    if (data.pagado) {
                        timelineHtml += '<div class="timeline-item">' +
                            '<div class="timeline-item-dot completado"><i class="bi bi-check"></i></div>' +
                            '<div class="timeline-item-content">' +
                                '<div class="timeline-item-header">' +
                                    '<span class="timeline-item-title"><i class="bi bi-credit-card me-1"></i>Pago Confirmado</span>' +
                                '</div>' +
                                '<div class="timeline-item-description">Pago del pedido confirmado. Total: S/ ' + data.total + '</div>' +
                            '</div>' +
                        '</div>';
                    }

                    // Assignment event
                    if (data.fecha_asignacion) {
                        timelineHtml += '<div class="timeline-item">' +
                            '<div class="timeline-item-dot completado"><i class="bi bi-check"></i></div>' +
                            '<div class="timeline-item-content">' +
                                '<div class="timeline-item-header">' +
                                    '<span class="timeline-item-title"><i class="bi bi-person-plus me-1"></i>Tarea Asignada</span>' +
                                    '<span style="font-size: 0.75rem; color: #6c757d;">' + data.fecha_asignacion + '</span>' +
                                '</div>' +
                                '<div class="timeline-item-description">Técnico asignado: ' + (data.tecnico_nombre || 'Sin asignar') +
                                (data.fecha_entrega_estimada ? '. Entrega estimada: ' + data.fecha_entrega_estimada : '') + '</div>' +
                            '</div>' +
                        '</div>';
                    }

                    // Kanban stages
                    if (data.timeline && data.timeline.length > 0) {
                        data.timeline.forEach(function(step) {
                            if (step.etapa === 'sin_asignar') return;

                            var dotClass = step.estado;
                            var contentClass = '';
                            if (step.estado === 'activo') contentClass = 'activo-bg';
                            if (step.estado === 'pendiente') contentClass = 'pendiente-bg';

                            var dotIcon = step.estado === 'completado' ? 'bi-check' : (iconosEtapa[step.etapa] || 'bi-clock');

                            timelineHtml += '<div class="timeline-item">' +
                                '<div class="timeline-item-dot ' + dotClass + '"><i class="bi ' + dotIcon + '"></i></div>' +
                                '<div class="timeline-item-content ' + contentClass + '">' +
                                    '<div class="timeline-item-header">' +
                                        '<span class="timeline-item-title">' + step.label + '</span>' +
                                    '</div>' +
                                    '<div class="timeline-item-description">' + step.descripcion + '</div>' +
                                '</div>' +
                            '</div>';
                        });
                    }

                    $('#result-timeline').html(timelineHtml);

                    // Show result card, hide loading
                    $('#resultLoading').hide();
                    $('#resultCard').show();

                    // Smooth scroll to result
                    $('html, body').animate({
                        scrollTop: $('#resultCard').offset().top - 100
                    }, 400);

                }).fail(function() {
                    $('#resultLoading').hide();
                    toastr.error('Error al cargar la información del pedido');
                });
            }

            // =============================================
            // RECENT TAG CLICK
            // =============================================
            $(document).on('click', '.recent-tag', function() {
                var text = $(this).text();
                $('#searchInput').val(text).trigger('input');
            });

            // =============================================
            // CLOSE SEARCH RESULTS ON OUTSIDE CLICK
            // =============================================
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-wrapper').length) {
                    $('#searchResults').hide();
                }
            });

            // =============================================
            // KEYBOARD NAVIGATION (Enter to select first)
            // =============================================
            $('#searchInput').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    var firstResult = $('#searchResults .search-result-item').first();
                    if (firstResult.length && $('#searchResults').is(':visible')) {
                        firstResult.trigger('click');
                    }
                }
                if (e.key === 'Escape') {
                    $('#searchResults').hide();
                }
            });

            // =============================================
            // PRINT BUTTON
            // =============================================
            $('#btnImprimir').on('click', function() {
                window.print();
            });

            // =============================================
            // INIT
            // =============================================
            console.log('Módulo de Consulta de Pedidos (Trazabilidad) cargado correctamente');

        });
    </script>
@endsection
