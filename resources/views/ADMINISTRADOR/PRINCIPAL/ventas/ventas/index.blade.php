@extends('TEMPLATES.administrador')
@section('title', 'VENTAS')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">VENTAS Y FACTURACIÓN</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ventas Mes</p>
                                <h3 class="mb-0 fw-bold">{{ $ventas->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-coin fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Facturación Mes</p>
                                <h3 class="mb-0 fw-bold text-success">S/ {{ number_format($ventas->where('created_at', '>=', now()->startOfMonth())->where('estado', 'completada')->sum('total'), 2) }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Facturas Emitidas</p>
                                <h3 class="mb-0 fw-bold text-info">{{ $ventas->whereNotNull('numero_comprobante')->count() }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-receipt fs-3 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ticket Promedio</p>
                                <h3 class="mb-0 fw-bold text-warning">S/ {{ $ventas->where('estado', 'completada')->count() > 0 ? number_format($ventas->where('estado', 'completada')->avg('total'), 2) : '0.00' }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-tag fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">

            <div class="card-body">
                <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Sede</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Comprobante</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($ventas as $venta)
                        <tr>
                            <td class="fw-normal text-center align-middle">{{ $contador++ }}</td>
                            <td class="fw-normal text-center align-middle">
                                <strong>{{ $venta->codigo }}</strong><br>
                                <small class="text-muted">{{ $venta->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                @if($venta->cliente)
                                    {{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}
                                    @if($venta->cliente->razon_social)
                                        <br><small class="text-muted">{{ $venta->cliente->razon_social }}</small>
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-info">{{ $venta->sede->name ?? 'Sin sede' }}</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                @if($venta->tipo_venta == 'pos')
                                    <span class="badge bg-dark">POS</span>
                                @elseif($venta->tipo_venta == 'ecommerce')
                                    <span class="badge bg-info">E-commerce</span>
                                @else
                                    <span class="badge bg-primary">Pedido</span>
                                @endif
                            </td>
                            <td class="fw-normal text-center align-middle">
                                {{ $venta->tipocomprobante->name ?? 'Sin comprobante' }}<br>
                                @if($venta->numero_comprobante)
                                    <small class="text-muted">{{ $venta->numero_comprobante }}</small>
                                @endif
                            </td>
                            <td class="fw-normal text-center align-middle">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-normal text-center align-middle text-success fw-bold">S/ {{ number_format($venta->total, 2) }}</td>
                            <td class="fw-normal text-center align-middle">
                                @if($venta->estado == 'completada')
                                    <span class="badge bg-success">Completada</span>
                                @elseif($venta->estado == 'parcial')
                                    <span class="badge bg-warning">Parcial</span>
                                @else
                                    <span class="badge bg-danger">Anulada</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="{{ route('admin-ventas.show', $venta) }}">
                                            <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-file-pdf text-danger me-2"></i>Descargar PDF</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin-ventas.destroy', $venta) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro?')">
                                                    <i class="bi bi-trash text-danger me-2"></i>Eliminar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
