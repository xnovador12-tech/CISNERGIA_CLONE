@extends('TEMPLATES.administrador')

@section('title', 'Comprobantes de Compras')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --v-primary: #1e293b;
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

        .btn-nueva-compra {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #fff !important;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 41, 59, 0.3);
            text-decoration: none;
        }

        .btn-nueva-compra:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 41, 59, 0.4);
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
        .mini-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .mini-card-icon.primary { background: rgba(30, 41, 59, 0.1); color: var(--v-primary); }
        .mini-card-content h4 { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin: 0; }
        .mini-card-content span { font-size: 0.75rem; color: #94a3b8; }

        /* ===== FILTROS ===== */
        .filters-container {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .filter-label { font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; display: block; }
        .filter-select, .filter-input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            width: 100%;
        }

        /* ===== TABLE ===== */
        .table-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04); }
        .table-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .table-v thead th { font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; padding: 1rem; background: #f8fafc; }
        .table-v tbody td { padding: 1rem; vertical-align: middle; border-color: #f1f5f9; font-size: 0.9rem; }

        /* ===== BADGES ===== */
        .badge-estado { padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-estado.completada { background: rgba(16, 185, 129, 0.1); color: var(--v-success); }
        .badge-estado.borrador { background: rgba(245, 158, 11, 0.1); color: var(--v-warning); }
        .badge-estado.anulada { background: rgba(239, 68, 68, 0.1); color: var(--v-danger); }

        .badge-comprobante { padding: 0.3rem 0.65rem; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
        .badge-comprobante.factura { background: rgba(30, 41, 59, 0.1); color: var(--v-primary); }
        .badge-comprobante.boleta { background: rgba(139, 92, 246, 0.1); color: var(--v-purple); }

        .btn-action-menu { width: 36px; height: 36px; border-radius: 8px; border: none; background: #f1f5f9; color: #64748b; }
    </style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COMPROBANTES DE COMPRAS</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Finanzas</li>
                        <li class="breadcrumb-item active">Compras</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-2">
        <div class="page-header" data-aos="fade-up">
            <div class="page-header-left">
                <a href="{{ route('admin-comprobantes-compras.create') }}" class="btn-nueva-compra">
                    <i class="bi bi-plus-lg"></i>
                    <span>Registrar Comprobante de Compra</span>
                </a>
            </div>
            <div class="mini-summary">
                <div class="mini-card">
                    <div class="mini-card-icon primary"><i class="bi bi-receipt-cutoff"></i></div>
                    <div class="mini-card-content">
                        <h4>{{ count($comprobantes) }}</h4>
                        <span>Total registrados</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="filters-container" data-aos="fade-up">
            <form method="GET" action="{{ route('admin-comprobantes-compras.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>Anulada</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Desde</label>
                        <input type="date" name="fecha_desde" class="filter-input" value="{{ request('fecha_desde') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Hasta</label>
                        <input type="date" name="fecha_hasta" class="filter-input" value="{{ request('fecha_hasta') }}" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-card-header">
                <h5 class="table-card-title fw-bold m-0"><i class="bi bi-table me-2"></i>Historial de Pagos a Proveedores</h5>
            </div>
            <div class="table-card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-v" id="table-comprobantes">
                        <thead>
                            <tr>
                                <th>Código Interno</th>
                                <th>Comprobante</th>
                                <th>Proveedor</th>
                                <th>O.C. Relacionada</th>
                                <th>Fecha Registro</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comprobantes as $comp)
                                <tr>
                                    <td class="fw-bold">{{ $comp->codigo }}</td>
                                    <td>
                                        <span class="badge-comprobante {{ $comp->tipocomprobante?->codigo == '01' ? 'factura' : 'boleta' }}">
                                            {{ $comp->tipocomprobante?->name ?? '-' }}
                                        </span>
                                        <div class="mt-1 small">{{ $comp->numero_comprobante }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $comp->proveedor?->persona?->name ?? 'Proveedor no encontrado' }}</div>
                                        <small class="text-muted">{{ $comp->proveedor?->persona?->nro_identificacion }}</small>
                                    </td>
                                    <td>
                                        @if($comp->ordencompra)
                                            <span class="badge bg-light text-dark border">{{ $comp->ordencompra->codigo }}</span>
                                        @else
                                            <span class="text-muted small">Sin OC</span>
                                        @endif
                                    </td>
                                    <td>{{ $comp->created_at->format('d/m/Y') }}</td>
                                    <td class="fw-bold text-primary">S/ {{ number_format($comp->total, 2) }}</td>
                                    <td>
                                        <span class="badge-estado {{ $comp->estado }}">
                                            {{ ucfirst($comp->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn-action-menu" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li><a class="dropdown-item" href="{{ route('admin-comprobantes-compras.show', $comp->slug) }}"><i class="bi bi-eye me-2"></i>Ver Detalle</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No se han registrado comprobantes de compras.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('new_registration') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: 'El comprobante de compra ha sido registrado y vinculado correctamente.',
                confirmButtonColor: '#1e293b'
            });
        </script>
    @endif
@endsection
