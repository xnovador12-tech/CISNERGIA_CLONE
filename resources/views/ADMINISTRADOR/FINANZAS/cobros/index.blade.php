@extends('TEMPLATES.administrador')
@section('title', 'COBROS')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COBROS Y COBRANZAS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Cobros</li>
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
                                <p class="text-muted mb-1 small">Cobros Pendientes</p>
                                <h3 class="mb-0 fw-bold text-danger">{{ $ventasPendientes->count() }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-exclamation-circle fs-3 text-danger"></i>
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
                                <p class="text-muted mb-1 small">Total por Cobrar</p>
                                <h3 class="mb-0 fw-bold text-danger">S/ {{ number_format($ventasPendientes->sum('saldo_pendiente'), 2) }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash fs-3 text-warning"></i>
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
                                <p class="text-muted mb-1 small">Total Cobrado</p>
                                <h3 class="mb-0 fw-bold text-success">S/ {{ number_format($ventas->sum('total_pagado'), 2) }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Ventas Completadas</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $ventasCompletadas->count() }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-bag-check fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Cobros Pendientes -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="tabCobros" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button" role="tab">
                            <i class="bi bi-clock-history me-1"></i>Pendientes
                            <span class="badge bg-danger ms-1">{{ $ventasPendientes->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="completadas-tab" data-bs-toggle="tab" data-bs-target="#completadas" type="button" role="tab">
                            <i class="bi bi-check-circle me-1"></i>Completadas
                            <span class="badge bg-success ms-1">{{ $ventasCompletadas->count() }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="tabCobrosContent">
                    <!-- Tab Pendientes -->
                    <div class="tab-pane fade show active" id="pendientes" role="tabpanel">
                        <table id="tablaPendientes" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Comprobante</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Condición</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Pagado</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Saldo</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">% Avance</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventasPendientes as $venta)
                                <tr>
                                    <td class="fw-normal text-center align-middle">{{ $loop->iteration }}</td>
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
                                        {{ $venta->tipocomprobante->name ?? 'Sin comprobante' }}<br>
                                        <small class="text-muted">{{ $venta->numero_comprobante }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($venta->condicion_pago == 'Crédito')
                                            <span class="badge bg-info">Crédito</span>
                                        @else
                                            <span class="badge bg-secondary">Contado</span>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle fw-bold">S/ {{ number_format($venta->total, 2) }}</td>
                                    <td class="fw-normal text-center align-middle fw-bold text-primary">S/ {{ number_format($venta->total_pagado, 2) }}</td>
                                    <td class="fw-normal text-center align-middle fw-bold text-danger">S/ {{ number_format($venta->saldo_pendiente, 2) }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        @php $porcentaje = $venta->total > 0 ? round(($venta->total_pagado / $venta->total) * 100) : 0; @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $porcentaje >= 50 ? 'bg-warning' : 'bg-danger' }}" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $porcentaje }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('admin-cobros.show', $venta) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalle / Registrar Cobro">
                                            <i class="bi bi-cash-coin me-1"></i>Cobrar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tab Completadas -->
                    <div class="tab-pane fade" id="completadas" role="tabpanel">
                        <table id="tablaCompletadas" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Comprobante</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Pagado</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventasCompletadas as $venta)
                                <tr>
                                    <td class="fw-normal text-center align-middle">{{ $loop->iteration }}</td>
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
                                        {{ $venta->tipocomprobante->name ?? 'Sin comprobante' }}<br>
                                        <small class="text-muted">{{ $venta->numero_comprobante }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle fw-bold">S/ {{ number_format($venta->total, 2) }}</td>
                                    <td class="fw-normal text-center align-middle fw-bold text-success">S/ {{ number_format($venta->total_pagado, 2) }}</td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('admin-cobros.show', $venta) }}" class="btn btn-sm btn-outline-secondary" title="Ver Detalle">
                                            <i class="bi bi-eye me-1"></i>Detalle
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dtConfig = {
            responsive: true,
            pageLength: 15,
            lengthMenu: [10, 15, 25, 50],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "No hay registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                zeroRecords: "No se encontraron resultados",
                paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
            },
            dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6"f>>rtip'
        };

        new DataTable('#tablaPendientes', dtConfig);

        // Inicializar tabla completadas cuando se muestra el tab
        let tablaCompletadasInit = false;
        document.getElementById('completadas-tab').addEventListener('shown.bs.tab', function () {
            if (!tablaCompletadasInit) {
                new DataTable('#tablaCompletadas', dtConfig);
                tablaCompletadasInit = true;
            }
        });
    });
</script>
@endsection
