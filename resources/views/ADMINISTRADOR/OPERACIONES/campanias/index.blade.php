@extends('TEMPLATES.administrador')

@section('title', 'CAMPAÑAS Y PROMOCIONES')

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

        .stat-card.activas .stat-icon {
            background: #19875420;
            color: #198754;
        }

        .stat-card.borradores .stat-icon {
            background: #6c757d20;
            color: #6c757d;
        }

        .stat-card.pausadas .stat-icon {
            background: #ffc10720;
            color: #cc9a00;
        }

        .stat-card.finalizadas .stat-icon {
            background: #0d6efd20;
            color: #0d6efd;
        }

        /* =============================================
           FILTERS & ACTIONS BAR
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

        .filter-group select,
        .filter-group input {
            font-size: 0.85rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        /* =============================================
           CAMPAIGN CARDS
           ============================================= */

        .campaign-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .campaign-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .campaign-banner {
            height: 8px;
            width: 100%;
        }

        .campaign-banner.activa {
            background: linear-gradient(90deg, #198754, #20c997);
        }

        .campaign-banner.borrador {
            background: linear-gradient(90deg, #6c757d, #adb5bd);
        }

        .campaign-banner.pausada {
            background: linear-gradient(90deg, #ffc107, #ffda6a);
        }

        .campaign-banner.finalizada {
            background: linear-gradient(90deg, #0d6efd, #6ea8fe);
        }

        .campaign-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .campaign-title {
            font-weight: 700;
            font-size: 1rem;
            color: #212529;
            margin: 0;
            line-height: 1.3;
        }

        .campaign-status {
            font-size: 0.7rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .campaign-status.activa {
            background: #19875420;
            color: #198754;
        }

        .campaign-status.borrador {
            background: #6c757d20;
            color: #6c757d;
        }

        .campaign-status.pausada {
            background: #ffc10720;
            color: #cc9a00;
        }

        .campaign-status.finalizada {
            background: #0d6efd20;
            color: #0d6efd;
        }

        .campaign-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .campaign-dates {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 0.75rem;
        }

        .campaign-date-item {
            text-align: center;
        }

        .campaign-date-item .date-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
        }

        .campaign-date-item .date-value {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #212529;
        }

        /* Metrics Row */
        .campaign-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .campaign-metric {
            text-align: center;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .campaign-metric .metric-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
        }

        .campaign-metric .metric-label {
            font-size: 0.65rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Products Tags */
        .campaign-products {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            margin-bottom: 1rem;
        }

        .campaign-products .product-tag {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            background: #e9ecef;
            color: #495057;
            font-weight: 500;
        }

        .campaign-products .product-tag.more {
            background: #0d6efd15;
            color: #0d6efd;
            font-weight: 600;
        }

        /* Discount Badge */
        .campaign-discount {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 0.75rem;
        }

        .campaign-discount i {
            font-size: 1rem;
        }

        /* Footer */
        .campaign-footer {
            padding: 0.75rem 1.25rem;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .campaign-footer .btn {
            font-size: 0.78rem;
            padding: 0.35rem 0.75rem;
        }

        .campaign-author {
            font-size: 0.75rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* =============================================
           EMPTY STATE
           ============================================= */

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* =============================================
           MODAL STYLES
           ============================================= */

        .modal-content {
            border: none;
            border-radius: 15px;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-weight: 700;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .form-section-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: #212529;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

            .filters-card .row {
                gap: 1rem;
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
                    <i class="bi bi-megaphone me-2"></i>Campañas y Promociones
                </h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Campañas y Promociones</li>
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
            <div class="stat-card activas">
                <div class="stat-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div class="stat-number">{{ $stats['activas'] }}</div>
                <div class="stat-label">Activas</div>
            </div>
            <div class="stat-card borradores">
                <div class="stat-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="stat-number">{{ $stats['borradores'] }}</div>
                <div class="stat-label">Borradores</div>
            </div>
            <div class="stat-card pausadas">
                <div class="stat-icon">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['pausadas'] }}</div>
                <div class="stat-label">Pausadas</div>
            </div>
            <div class="stat-card finalizadas">
                <div class="stat-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <div class="stat-number">{{ $stats['finalizadas'] }}</div>
                <div class="stat-label">Finalizadas</div>
            </div>
        </div>

        <!-- Filtros y Acción -->
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
                            <option value="activa">Activas</option>
                            <option value="borrador">Borradores</option>
                            <option value="pausada">Pausadas</option>
                            <option value="finalizada">Finalizadas</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="filter-group">
                        <label>Tipo:</label>
                        <select class="form-select" id="filterTipo">
                            <option value="">Todos</option>
                            <option value="descuento">Descuento</option>
                            <option value="envio-gratis">Envío Gratis</option>
                            <option value="combo">Combo/Kit</option>
                            <option value="temporada">Temporada</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-outline-secondary btn-sm me-2" id="btnLimpiarFiltros">
                        <i class="bi bi-x-circle me-1"></i>Limpiar
                    </button>
                    <a href="{{ route('admin-operaciones-campanias.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Nueva Campaña
                    </a>
                </div>
            </div>
        </div>

        <!-- Grid de Campañas -->
        <div class="row g-4" id="campanias-grid" data-aos="fade-up" data-aos-delay="200">

            @forelse($campanias as $campania)
                <div class="col-lg-4 col-md-6 campania-item" data-estado="{{ $campania->estado }}" data-tipo="{{ $campania->tipo }}">
                    <div class="campaign-card">
                        <div class="campaign-banner {{ $campania->estado }}"></div>
                        <div class="campaign-body">
                            <div class="campaign-header">
                                <h6 class="campaign-title">{{ $campania->nombre }}</h6>
                                <span class="campaign-status {{ $campania->estado }}">
                                    {{ ucfirst($campania->estado) }}
                                </span>
                            </div>
                            <div class="campaign-description">
                                {{ $campania->descripcion }}
                            </div>
                            <div class="campaign-discount">
                                <i class="bi bi-tag-fill"></i> {{ $campania->descuento_texto }}
                            </div>
                            <div class="campaign-dates">
                                <div class="campaign-date-item">
                                    <span class="date-label">Inicio</span>
                                    <span class="date-value {{ $campania->estado === 'borrador' ? 'text-muted' : '' }}">
                                        {{ \Carbon\Carbon::parse($campania->fecha_inicio)->isoFormat('DD MMM YYYY') }}
                                    </span>
                                </div>
                                <div class="campaign-date-item">
                                    <span class="date-label">Fin</span>
                                    <span class="date-value {{ $campania->estado === 'borrador' ? 'text-muted' : '' }}">
                                        {{ \Carbon\Carbon::parse($campania->fecha_fin)->isoFormat('DD MMM YYYY') }}
                                    </span>
                                </div>
                                <div class="campaign-date-item">
                                    @if($campania->estado === 'pausada')
                                        <span class="date-label">Motivo</span>
                                        <span class="date-value text-warning">{{ Str::limit($campania->motivo_pausa, 15) }}</span>
                                    @elseif($campania->estado === 'finalizada' || $campania->estado === 'borrador')
                                        <span class="date-label">Duración</span>
                                        <span class="date-value">
                                            {{ \Carbon\Carbon::parse($campania->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($campania->fecha_fin)) }} días
                                        </span>
                                    @else
                                        <span class="date-label">Quedan</span>
                                        <span class="date-value {{ $campania->dias_restantes <= 7 ? 'text-danger' : ($campania->dias_restantes <= 30 ? 'text-warning' : 'text-success') }}">
                                            {{ $campania->dias_restantes }} días
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="campaign-metrics">
                                <div class="campaign-metric">
                                    <div class="metric-value">
                                        {{ $campania->estado === 'borrador' ? '—' : $campania->total_pedidos }}
                                    </div>
                                    <div class="metric-label">Pedidos</div>
                                </div>
                                <div class="campaign-metric">
                                    <div class="metric-value">
                                        @if($campania->estado === 'borrador')
                                            —
                                        @else
                                            S/ {{ $campania->total_ventas >= 1000 ? number_format($campania->total_ventas / 1000, 1) . 'K' : number_format($campania->total_ventas, 0) }}
                                        @endif
                                    </div>
                                    <div class="metric-label">Ventas</div>
                                </div>
                                <div class="campaign-metric">
                                    <div class="metric-value">
                                        {{ $campania->estado === 'borrador' ? '—' : $campania->tasa_conversion . '%' }}
                                    </div>
                                    <div class="metric-label">Conversión</div>
                                </div>
                            </div>
                            <div class="campaign-products">
                                @if($campania->aplica_todos_productos)
                                    <span class="product-tag">Todos los productos</span>
                                @else
                                    @foreach($campania->productos->take(3) as $producto)
                                        <span class="product-tag">{{ $producto->nombre }}</span>
                                    @endforeach
                                    @if($campania->productos->count() > 3)
                                        <span class="product-tag more">+{{ $campania->productos->count() - 3 }} más</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="campaign-footer">
                            <span class="campaign-author">
                                <i class="bi bi-person"></i>
                                {{ $campania->creador->persona->name ?? 'Sin asignar' }}
                            </span>
                            <div>
                                {{-- Acciones según estado --}}
                                @if($campania->estado === 'borrador')
                                    <a href="{{ route('admin-operaciones-campanias.edit', $campania->id) }}" class="btn btn-outline-secondary btn-sm me-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-success btn-sm me-1 btn-activar" data-id="{{ $campania->id }}" data-nombre="{{ $campania->nombre }}" title="Activar">
                                        <i class="bi bi-play-fill me-1"></i>Activar
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm btn-eliminar" data-id="{{ $campania->id }}" data-nombre="{{ $campania->nombre }}" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @elseif($campania->estado === 'activa')
                                    <button class="btn btn-outline-warning btn-sm me-1 btn-pausar" data-id="{{ $campania->id }}" data-nombre="{{ $campania->nombre }}" title="Pausar">
                                        <i class="bi bi-pause-fill"></i>
                                    </button>
                                    <a href="{{ route('admin-operaciones-campanias.show', $campania->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                @elseif($campania->estado === 'pausada')
                                    <button class="btn btn-success btn-sm me-1 btn-reanudar" data-id="{{ $campania->id }}" data-nombre="{{ $campania->nombre }}" title="Reanudar">
                                        <i class="bi bi-play-fill"></i>
                                    </button>
                                    <a href="{{ route('admin-operaciones-campanias.edit', $campania->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                @elseif($campania->estado === 'finalizada')
                                    <button class="btn btn-outline-secondary btn-sm me-1 btn-duplicar" data-id="{{ $campania->id }}" data-nombre="{{ $campania->nombre }}" title="Duplicar">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                    <a href="{{ route('admin-operaciones-campanias.show', $campania->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-bar-chart me-1"></i>Reporte
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-megaphone d-block"></i>
                        <h5>No hay campañas registradas</h5>
                        <p>Crea tu primera campaña para comenzar a impulsar tus ventas con promociones y descuentos especiales.</p>
                        <a href="{{ route('admin-operaciones-campanias.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Crear Primera Campaña
                        </a>
                    </div>
                </div>
            @endforelse

        </div>
        {{-- Fin Grid Campañas --}}

    </div>
    {{-- Fin contenido --}}
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // =============================================
            // CSRF Setup para AJAX
            // =============================================
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var baseUrlCampanias = "{{ url('admin-operaciones-campanias') }}";

            // =============================================
            // FILTROS CLIENT-SIDE
            // =============================================
            function aplicarFiltros() {
                var estado = $('#filterEstado').val();
                var tipo = $('#filterTipo').val();

                $('.campania-item').each(function() {
                    var itemEstado = $(this).data('estado');
                    var itemTipo = $(this).data('tipo');
                    var mostrar = true;

                    if (estado && itemEstado !== estado) {
                        mostrar = false;
                    }

                    if (tipo && itemTipo !== tipo) {
                        mostrar = false;
                    }

                    if (mostrar) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            $('#filterEstado, #filterTipo').on('change', function() {
                aplicarFiltros();
            });

            $('#btnLimpiarFiltros').click(function() {
                $('#filterEstado').val('');
                $('#filterTipo').val('');
                $('.campania-item').show();
            });

            // =============================================
            // ACTIVAR CAMPAÑA (borrador -> activa)
            // =============================================
            $(document).on('click', '.btn-activar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                Swal.fire({
                    title: '¿Activar campaña?',
                    html: 'La campaña <strong>' + nombre + '</strong> se activará y será visible para los clientes.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-play-fill me-1"></i>Sí, activar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrlCampanias + '/' + id + '/activar',
                            type: 'POST',
                            success: function(response) {
                                toastr.success('La campaña "' + nombre + '" ha sido activada exitosamente.');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al activar la campaña.';
                                toastr.error(msg);
                            }
                        });
                    }
                });
            });

            // =============================================
            // PAUSAR CAMPAÑA (activa -> pausada)
            // =============================================
            $(document).on('click', '.btn-pausar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                Swal.fire({
                    title: '¿Pausar campaña?',
                    html: 'La campaña <strong>' + nombre + '</strong> dejará de ser visible para los clientes.',
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Motivo de la pausa',
                    inputPlaceholder: 'Ej: Sin stock, revisión de precios, etc.',
                    inputAttributes: {
                        'aria-label': 'Motivo de la pausa'
                    },
                    inputValidator: function(value) {
                        if (!value) {
                            return 'Debes indicar un motivo para pausar la campaña.';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-pause-fill me-1"></i>Sí, pausar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrlCampanias + '/' + id + '/pausar',
                            type: 'POST',
                            data: {
                                motivo_pausa: result.value
                            },
                            success: function(response) {
                                toastr.warning('La campaña "' + nombre + '" ha sido pausada.');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al pausar la campaña.';
                                toastr.error(msg);
                            }
                        });
                    }
                });
            });

            // =============================================
            // REANUDAR CAMPAÑA (pausada -> activa)
            // =============================================
            $(document).on('click', '.btn-reanudar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                Swal.fire({
                    title: '¿Reanudar campaña?',
                    html: 'La campaña <strong>' + nombre + '</strong> volverá a estar activa y visible para los clientes.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-play-fill me-1"></i>Sí, reanudar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrlCampanias + '/' + id + '/reanudar',
                            type: 'POST',
                            success: function(response) {
                                toastr.success('La campaña "' + nombre + '" ha sido reanudada exitosamente.');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al reanudar la campaña.';
                                toastr.error(msg);
                            }
                        });
                    }
                });
            });

            // =============================================
            // ELIMINAR CAMPAÑA (solo borradores)
            // =============================================
            $(document).on('click', '.btn-eliminar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                Swal.fire({
                    title: '¿Eliminar campaña?',
                    html: 'La campaña <strong>' + nombre + '</strong> será eliminada permanentemente. Esta acción no se puede deshacer.',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash me-1"></i>Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrlCampanias + '/' + id,
                            type: 'DELETE',
                            success: function(response) {
                                toastr.success('La campaña "' + nombre + '" ha sido eliminada.');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al eliminar la campaña.';
                                toastr.error(msg);
                            }
                        });
                    }
                });
            });

            // =============================================
            // DUPLICAR CAMPAÑA (finalizadas)
            // =============================================
            $(document).on('click', '.btn-duplicar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                Swal.fire({
                    title: '¿Duplicar campaña?',
                    html: 'Se creará una copia de <strong>' + nombre + '</strong> en estado borrador con las mismas configuraciones.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-copy me-1"></i>Sí, duplicar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrlCampanias + '/' + id + '/duplicar',
                            type: 'POST',
                            success: function(response) {
                                toastr.success('La campaña "' + nombre + '" ha sido duplicada exitosamente.');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al duplicar la campaña.';
                                toastr.error(msg);
                            }
                        });
                    }
                });
            });

            console.log('Módulo de Campañas y Promociones cargado correctamente');
        });
    </script>
@endsection
