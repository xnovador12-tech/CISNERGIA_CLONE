@extends('TEMPLATES.administrador')

@section('title', 'Detalle de Campana')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
    <style>
        /* =============================================
           STATUS BADGES
           ============================================= */
        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 30px;
        }

        .estado-badge.activa {
            background: #19875420;
            color: #198754;
        }

        .estado-badge.borrador {
            background: #6c757d20;
            color: #6c757d;
        }

        .estado-badge.pausada {
            background: #ffc10720;
            color: #cc9a00;
        }

        .estado-badge.finalizada {
            background: #0d6efd20;
            color: #0d6efd;
        }

        .estado-badge-lg {
            font-size: 1rem;
            padding: 0.5rem 1.25rem;
        }

        .tipo-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            background: #e9ecef;
            color: #495057;
        }

        /* =============================================
           HEADER CARD
           ============================================= */
        .show-header-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .show-header-banner {
            height: 8px;
            width: 100%;
        }

        .show-header-banner.activa {
            background: linear-gradient(90deg, #198754, #20c997);
        }

        .show-header-banner.borrador {
            background: linear-gradient(90deg, #6c757d, #adb5bd);
        }

        .show-header-banner.pausada {
            background: linear-gradient(90deg, #ffc107, #ffda6a);
        }

        .show-header-banner.finalizada {
            background: linear-gradient(90deg, #0d6efd, #6ea8fe);
        }

        .show-header-body {
            padding: 1.5rem 2rem;
        }

        .show-campaign-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .show-dates-range {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .show-dates-range i {
            color: #0d6efd;
        }

        .dias-restantes-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            background: #dc354520;
            color: #dc3545;
        }

        .dias-restantes-badge.vigente {
            background: #19875420;
            color: #198754;
        }

        /* =============================================
           METRIC CARDS
           ============================================= */
        .metric-cards-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .metric-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .metric-card:hover {
            transform: translateY(-3px);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .metric-card.pedidos::before {
            background: linear-gradient(90deg, #0d6efd, #6ea8fe);
        }

        .metric-card.ventas::before {
            background: linear-gradient(90deg, #198754, #20c997);
        }

        .metric-card.conversion::before {
            background: linear-gradient(90deg, #ffc107, #ffda6a);
        }

        .metric-card.descuento::before {
            background: linear-gradient(90deg, #dc3545, #f1737f);
        }

        .metric-card .metric-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.25rem;
        }

        .metric-card.pedidos .metric-icon {
            background: #0d6efd20;
            color: #0d6efd;
        }

        .metric-card.ventas .metric-icon {
            background: #19875420;
            color: #198754;
        }

        .metric-card.conversion .metric-icon {
            background: #ffc10720;
            color: #cc9a00;
        }

        .metric-card.descuento .metric-icon {
            background: #dc354520;
            color: #dc3545;
        }

        .metric-card .metric-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .metric-card .metric-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* =============================================
           CHART CONTAINER
           ============================================= */
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .chart-container .chart-title {
            font-weight: 700;
            font-size: 1rem;
            color: #212529;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-wrapper {
            position: relative;
            height: 350px;
            width: 100%;
        }

        /* =============================================
           DESCRIPTION CARD
           ============================================= */
        .description-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .description-card .section-title {
            font-weight: 700;
            font-size: 1rem;
            color: #212529;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .description-card p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
            line-height: 1.6;
        }

        /* =============================================
           PRODUCTS TABLE CARD
           ============================================= */
        .products-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .products-card .section-title {
            font-weight: 700;
            font-size: 1rem;
            color: #212529;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .products-card .table {
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .all-products-message {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 8px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .all-products-message i {
            font-size: 1.5rem;
            color: #0d6efd;
        }

        /* =============================================
           ACTIVITY TIMELINE
           ============================================= */
        .timeline-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .timeline-card .section-title {
            font-weight: 700;
            font-size: 1rem;
            color: #212529;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #0d6efd;
            background: white;
            z-index: 1;
        }

        .timeline-item.created::before {
            border-color: #6c757d;
            background: #6c757d;
        }

        .timeline-item.activated::before {
            border-color: #198754;
            background: #198754;
        }

        .timeline-item.paused::before {
            border-color: #ffc107;
            background: #ffc107;
        }

        .timeline-item .timeline-date {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .timeline-item .timeline-content {
            font-size: 0.88rem;
            color: #212529;
        }

        .timeline-item .timeline-content .text-muted {
            font-size: 0.8rem;
        }

        /* =============================================
           ACTION BUTTONS CARD
           ============================================= */
        .actions-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */
        @media (max-width: 1200px) {
            .metric-cards-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .metric-cards-row {
                grid-template-columns: 1fr;
            }

            .show-header-body {
                padding: 1rem 1.25rem;
            }

            .show-campaign-name {
                font-size: 1.35rem;
            }

            .chart-wrapper {
                height: 250px;
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
                    <i class="bi bi-megaphone me-2"></i>Detalle de Campana
                </h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none link" href="#">Operaciones</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none link" href="{{ route('admin-operaciones-campanias.index') }}">Campanas</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $campania->nombre }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado -->

    {{-- Contenido --}}
    <div class="container-fluid">

        <!-- =============================================
             HEADER CARD
             ============================================= -->
        <div class="show-header-card" data-aos="fade-up">
            <div class="show-header-banner {{ $campania->estado }}"></div>
            <div class="show-header-body">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="show-campaign-name">{{ $campania->nombre }}</h1>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="estado-badge estado-badge-lg {{ $campania->estado }}">
                                @switch($campania->estado)
                                    @case('activa')
                                        <i class="bi bi-lightning-charge"></i>Activa
                                        @break
                                    @case('borrador')
                                        <i class="bi bi-pencil-square"></i>Borrador
                                        @break
                                    @case('pausada')
                                        <i class="bi bi-pause-circle"></i>Pausada
                                        @break
                                    @case('finalizada')
                                        <i class="bi bi-flag"></i>Finalizada
                                        @break
                                @endswitch
                            </span>
                            <span class="tipo-badge">
                                <i class="bi bi-tag"></i> {{ $campania->tipo_label }}
                            </span>
                        </div>
                        <div class="show-dates-range">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $campania->fecha_inicio->format('d M Y') }} &mdash; {{ $campania->fecha_fin->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        @if($campania->estado === 'activa' || $campania->estado === 'pausada')
                            @if($campania->dias_restantes > 0)
                                <span class="dias-restantes-badge vigente">
                                    <i class="bi bi-clock-history"></i> {{ $campania->dias_restantes }} dias restantes
                                </span>
                            @else
                                <span class="dias-restantes-badge">
                                    <i class="bi bi-clock-history"></i> Finalizada
                                </span>
                            @endif
                        @elseif($campania->estado === 'borrador')
                            <span class="dias-restantes-badge vigente">
                                <i class="bi bi-clock-history"></i> {{ $campania->dias_restantes }} dias de duracion
                            </span>
                        @else
                            <span class="dias-restantes-badge">
                                <i class="bi bi-check-circle"></i> Campana finalizada
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- =============================================
             DESCRIPTION
             ============================================= -->
        @if($campania->descripcion)
            <div class="description-card" data-aos="fade-up" data-aos-delay="50">
                <div class="section-title">
                    <i class="bi bi-text-paragraph text-primary"></i> Descripcion
                </div>
                <p>{{ $campania->descripcion }}</p>
            </div>
        @endif

        <!-- =============================================
             METRIC CARDS
             ============================================= -->
        <div class="metric-cards-row" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-card pedidos">
                <div class="metric-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="metric-number">{{ number_format($campania->total_pedidos) }}</div>
                <div class="metric-label">Total Pedidos</div>
            </div>
            <div class="metric-card ventas">
                <div class="metric-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="metric-number">S/ {{ number_format($campania->total_ventas, 2) }}</div>
                <div class="metric-label">Total Ventas</div>
            </div>
            <div class="metric-card conversion">
                <div class="metric-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="metric-number">{{ number_format($campania->tasa_conversion, 1) }}%</div>
                <div class="metric-label">Tasa Conversion</div>
            </div>
            <div class="metric-card descuento">
                <div class="metric-icon">
                    <i class="bi bi-tag-fill"></i>
                </div>
                <div class="metric-number">S/ {{ number_format($campania->total_descuento, 2) }}</div>
                <div class="metric-label">Descuento Aplicado</div>
            </div>
        </div>

        <!-- =============================================
             CHART SECTION
             ============================================= -->
        <div class="chart-container" data-aos="fade-up" data-aos-delay="150">
            <div class="chart-title">
                <i class="bi bi-bar-chart-line text-primary"></i> Rendimiento de la Campana
            </div>
            <div class="chart-wrapper">
                <canvas id="campaniaChart"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- =============================================
                     PRODUCTS TABLE
                     ============================================= -->
                <div class="products-card">
                    <div class="section-title">
                        <i class="bi bi-box text-primary"></i> Productos en Promocion
                    </div>

                    @if($campania->aplica_todos_productos)
                        <div class="all-products-message">
                            <i class="bi bi-boxes"></i>
                            <span>Esta campana aplica a todos los productos del catalogo</span>
                        </div>
                    @else
                        @if($campania->productos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 100px;">Codigo</th>
                                            <th class="text-end" style="width: 130px;">Precio Normal</th>
                                            <th class="text-center" style="width: 80px;">Dto. %</th>
                                            <th class="text-end" style="width: 130px;">Precio Promo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($campania->productos as $producto)
                                            @php
                                                $descuento = $producto->pivot->descuento_especifico ?? $campania->descuento_porcentaje;
                                                $precioPromo = $producto->precio * (1 - $descuento / 100);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold">{{ $producto->name }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $producto->codigo }}</span>
                                                </td>
                                                <td class="text-end text-decoration-line-through text-muted">
                                                    S/ {{ number_format($producto->precio, 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-danger fw-bold">{{ number_format($descuento, 0) }}%</span>
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    S/ {{ number_format($precioPromo, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="all-products-message">
                                <i class="bi bi-info-circle"></i>
                                <span>No hay productos asociados a esta campana</span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <!-- =============================================
                     ACTIVITY TIMELINE
                     ============================================= -->
                <div class="timeline-card">
                    <div class="section-title">
                        <i class="bi bi-clock-history text-primary"></i> Actividad
                    </div>

                    <div class="timeline">
                        {{-- Creation --}}
                        <div class="timeline-item created">
                            <div class="timeline-date">
                                {{ $campania->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-content">
                                <strong>Campana creada</strong>
                                @if($campania->creador && $campania->creador->persona)
                                    <div class="text-muted">
                                        <i class="bi bi-person me-1"></i>
                                        {{ $campania->creador->persona->name }} {{ $campania->creador->persona->surnames }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Activation --}}
                        @if($campania->activado_at)
                            <div class="timeline-item activated">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($campania->activado_at)->format('d M Y, H:i') }}
                                </div>
                                <div class="timeline-content">
                                    <strong>Campana activada</strong>
                                    @if($campania->activador && $campania->activador->persona)
                                        <div class="text-muted">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $campania->activador->persona->name }} {{ $campania->activador->persona->surnames }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Pause --}}
                        @if($campania->pausado_at)
                            <div class="timeline-item paused">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($campania->pausado_at)->format('d M Y, H:i') }}
                                </div>
                                <div class="timeline-content">
                                    <strong>Campana pausada</strong>
                                    @if($campania->pausador && $campania->pausador->persona)
                                        <div class="text-muted">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $campania->pausador->persona->name }} {{ $campania->pausador->persona->surnames }}
                                        </div>
                                    @endif
                                    @if($campania->motivo_pausa)
                                        <div class="text-muted mt-1">
                                            <i class="bi bi-chat-left-text me-1"></i>
                                            <em>{{ $campania->motivo_pausa }}</em>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- =============================================
                     CAMPAIGN INFO CARD
                     ============================================= -->
                <div class="description-card">
                    <div class="section-title">
                        <i class="bi bi-info-circle text-primary"></i> Informacion
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 0.88rem;">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Tipo</span>
                            <span class="fw-semibold">{{ $campania->tipo_label }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Descuento</span>
                            <span class="fw-semibold text-danger">{{ $campania->descuento_texto }}</span>
                        </li>
                        @if($campania->condicion_minimo)
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Compra minima</span>
                                <span class="fw-semibold">S/ {{ number_format($campania->condicion_minimo, 2) }}</span>
                            </li>
                        @endif
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Total Visitas</span>
                            <span class="fw-semibold">{{ number_format($campania->total_visitas) }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted">Productos</span>
                            <span class="fw-semibold">
                                @if($campania->aplica_todos_productos)
                                    Todos
                                @else
                                    {{ $campania->productos->count() }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- =============================================
             ACTION BUTTONS
             ============================================= -->
        <div class="actions-card">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <a href="{{ route('admin-operaciones-campanias.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al listado
                </a>

                <div class="d-flex flex-wrap gap-2">
                    @switch($campania->estado)
                        @case('activa')
                            <a href="{{ route('admin-operaciones-campanias.edit', $campania->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <button type="button" class="btn btn-outline-warning" id="btnPausar">
                                <i class="bi bi-pause-fill me-1"></i> Pausar
                            </button>
                            @break

                        @case('pausada')
                            <a href="{{ route('admin-operaciones-campanias.edit', $campania->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <button type="button" class="btn btn-success" id="btnReanudar">
                                <i class="bi bi-play-fill me-1"></i> Reanudar
                            </button>
                            @break

                        @case('borrador')
                            <button type="button" class="btn btn-outline-danger" id="btnEliminar">
                                <i class="bi bi-trash me-1"></i> Eliminar
                            </button>
                            <a href="{{ route('admin-operaciones-campanias.edit', $campania->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <button type="button" class="btn btn-success" id="btnActivar">
                                <i class="bi bi-lightning-charge me-1"></i> Activar
                            </button>
                            @break

                        @case('finalizada')
                            <button type="button" class="btn btn-outline-secondary" id="btnDuplicar">
                                <i class="bi bi-copy me-1"></i> Duplicar
                            </button>
                            @break
                    @endswitch
                </div>
            </div>
        </div>

    </div>
    {{-- Fin contenido --}}
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {

            // =============================================
            // CSRF Setup for AJAX
            // =============================================
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // =============================================
            // CHART.JS - Line chart with AJAX data
            // =============================================
            var campaniaChartCtx = document.getElementById('campaniaChart').getContext('2d');
            var campaniaChart = null;

            function loadChart() {
                $.ajax({
                    url: "{{ route('admin-operaciones-campanias.metricas', $campania->id) }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var labels = response.labels || [];
                        var pedidosData = response.pedidos || [];
                        var ventasData = response.ventas || [];

                        if (campaniaChart) {
                            campaniaChart.destroy();
                        }

                        campaniaChart = new Chart(campaniaChartCtx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Pedidos',
                                        data: pedidosData,
                                        borderColor: '#0d6efd',
                                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                        borderWidth: 2,
                                        tension: 0.4,
                                        fill: true,
                                        pointBackgroundColor: '#0d6efd',
                                        pointBorderColor: '#fff',
                                        pointBorderWidth: 2,
                                        pointRadius: 4,
                                        pointHoverRadius: 6
                                    },
                                    {
                                        label: 'Ventas (S/)',
                                        data: ventasData,
                                        borderColor: '#198754',
                                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                        borderWidth: 2,
                                        tension: 0.4,
                                        fill: true,
                                        pointBackgroundColor: '#198754',
                                        pointBorderColor: '#fff',
                                        pointBorderWidth: 2,
                                        pointRadius: 4,
                                        pointHoverRadius: 6,
                                        yAxisID: 'y1'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            usePointStyle: true,
                                            padding: 20,
                                            font: {
                                                size: 12,
                                                weight: '600'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: { size: 13 },
                                        bodyFont: { size: 12 },
                                        padding: 12,
                                        cornerRadius: 8,
                                        callbacks: {
                                            label: function(context) {
                                                var label = context.dataset.label || '';
                                                if (context.datasetIndex === 1) {
                                                    return label + ': S/ ' + parseFloat(context.raw).toLocaleString('es-PE', { minimumFractionDigits: 2 });
                                                }
                                                return label + ': ' + context.raw;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            font: { size: 11 }
                                        }
                                    },
                                    y: {
                                        type: 'linear',
                                        display: true,
                                        position: 'left',
                                        title: {
                                            display: true,
                                            text: 'Pedidos',
                                            font: { size: 12, weight: '600' }
                                        },
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        ticks: {
                                            font: { size: 11 },
                                            stepSize: 1
                                        }
                                    },
                                    y1: {
                                        type: 'linear',
                                        display: true,
                                        position: 'right',
                                        title: {
                                            display: true,
                                            text: 'Ventas (S/)',
                                            font: { size: 12, weight: '600' }
                                        },
                                        beginAtZero: true,
                                        grid: {
                                            drawOnChartArea: false
                                        },
                                        ticks: {
                                            font: { size: 11 },
                                            callback: function(value) {
                                                return 'S/ ' + value.toLocaleString('es-PE');
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error('Error al cargar metricas del chart:', xhr);
                        toastr.error('No se pudieron cargar las metricas del grafico');
                    }
                });
            }

            loadChart();

            // =============================================
            // ACTION: Pausar Campana
            // =============================================
            $('#btnPausar').on('click', function() {
                Swal.fire({
                    title: 'Pausar Campana',
                    text: 'Indica el motivo por el cual deseas pausar esta campana.',
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Motivo de pausa',
                    inputPlaceholder: 'Escribe el motivo aqui...',
                    inputAttributes: {
                        'aria-label': 'Motivo de pausa'
                    },
                    inputValidator: function(value) {
                        if (!value || value.trim() === '') {
                            return 'Debes indicar un motivo para pausar la campana';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: '<i class="bi bi-pause-fill me-1"></i> Pausar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: function(motivo) {
                        return $.ajax({
                            url: "{{ route('admin-operaciones-campanias.pausar', $campania->id) }}",
                            type: 'POST',
                            data: {
                                motivo_pausa: motivo
                            },
                            dataType: 'json'
                        }).then(function(response) {
                            return response;
                        }).catch(function(xhr) {
                            Swal.showValidationMessage('Error: ' + (xhr.responseJSON?.message || 'No se pudo pausar la campana'));
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        toastr.success('La campana ha sido pausada correctamente');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });

            // =============================================
            // ACTION: Reanudar Campana
            // =============================================
            $('#btnReanudar').on('click', function() {
                Swal.fire({
                    title: 'Reanudar Campana',
                    text: 'La campana volvera a estar activa. Deseas continuar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    confirmButtonText: '<i class="bi bi-play-fill me-1"></i> Reanudar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return $.ajax({
                            url: "{{ route('admin-operaciones-campanias.reanudar', $campania->id) }}",
                            type: 'POST',
                            dataType: 'json'
                        }).then(function(response) {
                            return response;
                        }).catch(function(xhr) {
                            Swal.showValidationMessage('Error: ' + (xhr.responseJSON?.message || 'No se pudo reanudar la campana'));
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        toastr.success('La campana ha sido reanudada correctamente');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });

            // =============================================
            // ACTION: Activar Campana
            // =============================================
            $('#btnActivar').on('click', function() {
                Swal.fire({
                    title: 'Activar Campana',
                    text: 'La campana se publicara y estara visible para los clientes. Deseas continuar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    confirmButtonText: '<i class="bi bi-lightning-charge me-1"></i> Activar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return $.ajax({
                            url: "{{ route('admin-operaciones-campanias.activar', $campania->id) }}",
                            type: 'POST',
                            dataType: 'json'
                        }).then(function(response) {
                            return response;
                        }).catch(function(xhr) {
                            Swal.showValidationMessage('Error: ' + (xhr.responseJSON?.message || 'No se pudo activar la campana'));
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        toastr.success('La campana ha sido activada correctamente');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });

            // =============================================
            // ACTION: Eliminar Campana
            // =============================================
            $('#btnEliminar').on('click', function() {
                Swal.fire({
                    title: 'Eliminar Campana',
                    html: 'Esta accion no se puede deshacer.<br><strong>Se eliminara permanentemente esta campana.</strong>',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: '<i class="bi bi-trash me-1"></i> Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return $.ajax({
                            url: "{{ route('admin-operaciones-campanias.destroy', $campania->id) }}",
                            type: 'DELETE',
                            dataType: 'json'
                        }).then(function(response) {
                            return response;
                        }).catch(function(xhr) {
                            Swal.showValidationMessage('Error: ' + (xhr.responseJSON?.message || 'No se pudo eliminar la campana'));
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        toastr.success('La campana ha sido eliminada correctamente');
                        setTimeout(function() {
                            window.location.href = "{{ route('admin-operaciones-campanias.index') }}";
                        }, 1000);
                    }
                });
            });

            // =============================================
            // ACTION: Duplicar Campana
            // =============================================
            $('#btnDuplicar').on('click', function() {
                Swal.fire({
                    title: 'Duplicar Campana',
                    text: 'Se creara una copia de esta campana en estado borrador. Deseas continuar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: '<i class="bi bi-copy me-1"></i> Duplicar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return $.ajax({
                            url: "{{ route('admin-operaciones-campanias.duplicar', $campania->id) }}",
                            type: 'POST',
                            dataType: 'json'
                        }).then(function(response) {
                            return response;
                        }).catch(function(xhr) {
                            Swal.showValidationMessage('Error: ' + (xhr.responseJSON?.message || 'No se pudo duplicar la campana'));
                        });
                    },
                    allowOutsideClick: function() {
                        return !Swal.isLoading();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        toastr.success('La campana ha sido duplicada correctamente');
                        setTimeout(function() {
                            if (result.value && result.value.redirect) {
                                window.location.href = result.value.redirect;
                            } else {
                                window.location.href = "{{ route('admin-operaciones-campanias.index') }}";
                            }
                        }, 1000);
                    }
                });
            });

            console.log('Modulo Detalle de Campana cargado correctamente');
        });
    </script>
@endsection
