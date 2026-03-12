@extends('TEMPLATES.administrador')

@section('title', 'Comprobantes de Ventas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --v-primary: #1864ac;
            --v-success: #10b981;
            --v-warning: #f59e0b;
            --v-danger: #ef4444;
            --v-info: #3b82f6;
            --v-purple: #8b5cf6;
        }

        /* ===== HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .page-header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-nueva-venta {
            background: linear-gradient(135deg, var(--v-success) 0%, #059669 100%);
            color: #fff !important;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            text-decoration: none;
        }

        .btn-nueva-venta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        /* ===== MINI CARDS ===== */
        .mini-summary {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .mini-card {
            background: #fff;
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            border-left: 3px solid var(--v-primary);
        }

        .mini-card.success { border-left-color: var(--v-success); }
        .mini-card.warning { border-left-color: var(--v-warning); }
        .mini-card.danger { border-left-color: var(--v-danger); }
        .mini-card.purple { border-left-color: var(--v-purple); }

        .mini-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .mini-card-icon.primary { background: rgba(24, 100, 172, 0.1); color: var(--v-primary); }
        .mini-card-icon.success { background: rgba(16, 185, 129, 0.1); color: var(--v-success); }
        .mini-card-icon.warning { background: rgba(245, 158, 11, 0.1); color: var(--v-warning); }
        .mini-card-icon.danger { background: rgba(239, 68, 68, 0.1); color: var(--v-danger); }

        .mini-card-content h4 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
            line-height: 1;
        }

        .mini-card-content span {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* ===== FILTROS ===== */
        .filters-container {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .filters-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .filters-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .filters-title i { color: var(--v-primary); }

        .btn-reset-filters {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-reset-filters:hover { background: #e2e8f0; color: #475569; }

        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-select, .filter-input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            width: 100%;
        }

        .filter-select:focus, .filter-input:focus {
            border-color: var(--v-primary);
            box-shadow: 0 0 0 3px rgba(24, 100, 172, 0.1);
            outline: none;
        }

        /* ===== TABLE ===== */
        .table-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
        }

        .table-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-card-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .table-v thead th {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
            background: #f8fafc;
            white-space: nowrap;
        }

        .table-v tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f5f9;
            font-size: 0.9rem;
        }

        /* ===== BADGES ===== */
        .badge-estado {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-estado.pendiente { background: rgba(245, 158, 11, 0.1); color: var(--v-warning); }
        .badge-estado.pagado { background: rgba(16, 185, 129, 0.1); color: var(--v-success); }
        .badge-estado.anulado { background: rgba(239, 68, 68, 0.1); color: var(--v-danger); }

        .badge-comprobante { padding: 0.3rem 0.65rem; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
        .badge-comprobante.factura { background: rgba(24, 100, 172, 0.1); color: var(--v-primary); }
        .badge-comprobante.boleta { background: rgba(139, 92, 246, 0.1); color: var(--v-purple); }
        .badge-comprobante.nota { background: rgba(245, 158, 11, 0.1); color: var(--v-warning); }

        .monto-venta { font-weight: 700; color: var(--v-primary); }

        /* ===== ACTION BUTTONS ===== */
        .btn-action-menu {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .btn-action-menu:hover { background: var(--v-primary); color: #fff; }

        @media (max-width: 992px) {
            .page-header { flex-direction: column; align-items: stretch; }
            .mini-summary { justify-content: center; }
        }
    </style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right" data-aos-once="true">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COMPROBANTES DE VENTAS</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Finanzas</li>
                        <li class="breadcrumb-item active">Ventas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-2">
        <div class="page-header" data-aos="fade-up">
            <div class="page-header-left">
                <a href="{{ route('admin-comprobantes.create') }}" class="btn-nueva-venta">
                    <i class="bi bi-plus-lg"></i>
                    <span>Nuevo Comprobante</span>
                </a>
            </div>
            <div class="mini-summary">
                <div class="mini-card">
                    <div class="mini-card-icon primary"><i class="bi bi-receipt"></i></div>
                    <div class="mini-card-content">
                        <h4>{{ $ventas->total() }}</h4>
                        <span>Total comprobantes</span>
                    </div>
                </div>
                <div class="mini-card warning">
                    <div class="mini-card-icon warning"><i class="bi bi-clock-history"></i></div>
                    <div class="mini-card-content">
                        <h4>S/ {{ number_format($totalPendiente, 2) }}</h4>
                        <span>Pendiente</span>
                    </div>
                </div>
                <div class="mini-card success">
                    <div class="mini-card-icon success"><i class="bi bi-check-circle"></i></div>
                    <div class="mini-card-content">
                        <h4>S/ {{ number_format($totalPagado, 2) }}</h4>
                        <span>Cobrado</span>
                    </div>
                </div>
                <div class="mini-card danger">
                    <div class="mini-card-icon danger"><i class="bi bi-x-circle"></i></div>
                    <div class="mini-card-content">
                        <h4>S/ {{ number_format($totalAnulado, 2) }}</h4>
                        <span>Anulado</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="filters-container" data-aos="fade-up">
            <form method="GET" action="{{ route('admin-ventas.index') }}" id="formFiltros">
                <div class="filters-header">
                    <h6 class="filters-title"><i class="bi bi-funnel"></i> Filtros Avanzados</h6>
                    <button type="button" class="btn-reset-filters" onclick="window.location.href='{{ route('admin-ventas.index') }}'">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar filtros
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Pagado" {{ request('estado') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="Anulado" {{ request('estado') == 'Anulado' ? 'selected' : '' }}>Anulado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Tipo Comprobante</label>
                        <select name="tipo_comprobante_id" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            @foreach ($tiposComprobante as $tc)
                                <option value="{{ $tc->id }}" {{ request('tipo_comprobante_id') == $tc->id ? 'selected' : '' }}>
                                    {{ $tc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Desde</label>
                        <input type="date" name="fecha_desde" class="filter-input" value="{{ request('fecha_desde') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Hasta</label>
                        <input type="date" name="fecha_hasta" class="filter-input" value="{{ request('fecha_hasta') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Buscar</label>
                        <div class="input-group">
                            <input type="text" name="search" class="filter-input" placeholder="N° o cliente..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary" style="border-radius: 0 8px 8px 0;"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-card-header">
                <h5 class="table-card-title"><i class="bi bi-table"></i> Listado de Comprobantes</h5>
                <small class="text-muted">{{ $ventas->total() }} registros encontrados</small>
            </div>
            <div class="table-card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-v">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Comprobante</th>
                                <th>Cliente</th>
                                <th>Sede</th>
                                <th>Fecha</th>
                                <th>Pago</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas as $venta)
                                <tr>
                                    <td>{{ $loop->iteration + ($ventas->currentPage() - 1) * $ventas->perPage() }}</td>
                                    <td>
                                        <span class="badge-comprobante {{ $venta->tipocomprobante?->codigo == '01' ? 'factura' : ($venta->tipocomprobante?->codigo == '03' ? 'boleta' : 'nota') }}">
                                            {{ $venta->tipocomprobante?->name ?? '-' }}
                                        </span>
                                        <div class="fw-bold mt-1">{{ $venta->numero_comprobante }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $venta->cliente?->nombre_completo ?? 'Cliente no definido' }}</div>
                                        <small class="text-muted">{{ $venta->cliente?->documento }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $venta->sede?->name ?? 'Sede Central' }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="small fw-semibold">{{ $venta->condicion_pago }}</div>
                                        <div class="text-muted small">{{ $venta->mediopago?->name ?? '-' }}</div>
                                    </td>
                                    <td class="monto-venta">S/ {{ number_format($venta->total, 2) }}</td>
                                    <td>
                                        <span class="badge-estado {{ strtolower($venta->estado) }}">
                                            {{ $venta->estado }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn-action-menu dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li><a class="dropdown-item" href="{{ route('admin-comprobantes.show', $venta->id) }}"><i class="bi bi-eye me-2"></i>Ver Detalle</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin-comprobantes.voucher', $venta->id) }}"><i class="bi bi-file-pdf me-2"></i>Descargar PDF</a></li>
                                                @if($venta->estado != 'Anulado')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Anular</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No se encontraron comprobantes de ventas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Mostrando {{ $ventas->firstItem() ?? 0 }} a {{ $ventas->lastItem() ?? 0 }} de {{ $ventas->total() }} registros
                    </small>
                    {{ $ventas->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
