@extends('TEMPLATES.administrador')
@section('title', 'DETALLE CAJA CHICA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE CAJA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-caja-chica.index') }}">Caja Chica</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $caja->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- Info de la Caja --}}
        <div class="card border-0 shadow-sm mb-3 border-start border-5 {{ $caja->estado === 'Abierto' ? 'border-success' : 'border-secondary' }}" data-aos="fade-up">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="{{ $caja->estado === 'Abierto' ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi {{ $caja->estado === 'Abierto' ? 'bi-unlock' : 'bi-lock' }} fs-2 {{ $caja->estado === 'Abierto' ? 'text-success' : 'text-secondary' }}"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">{{ $caja->codigo }}</h5>
                                <span class="badge {{ $caja->estado === 'Abierto' ? 'bg-success' : 'bg-secondary' }}">{{ $caja->estado }}</span>
                                <br><small class="text-muted">{{ $caja->user->name ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="text-muted small">Apertura</span>
                        <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y') }}</p>
                        <small class="text-muted">{{ $caja->hora_apertura }}</small>
                    </div>
                    @if($caja->estado === 'Cerrado')
                    <div class="col-md-2 text-center">
                        <span class="text-muted small">Cierre</span>
                        <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($caja->fecha_cierre)->format('d/m/Y') }}</p>
                        <small class="text-muted">{{ $caja->hora_cierre }}</small>
                    </div>
                    @endif
                    <div class="col text-end">
                        @if($caja->estado === 'Abierto')
                            <form action="{{ route('admin-caja-chica.cerrar', $caja) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de cerrar la caja? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-lock me-1"></i>Cerrar Caja
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="row g-3 mb-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="text-muted small">Saldo Inicial</span>
                        <h3 class="mb-0 fw-bold">S/ {{ number_format($caja->saldo_inicial, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="text-success small fw-bold">Total Ingresos (Cobros)</span>
                        <h3 class="mb-0 fw-bold text-success">+ S/ {{ number_format($totalIngresos, 2) }}</h3>
                        <small class="text-muted">{{ $ingresos->count() }} movimientos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="text-danger small fw-bold">Total Egresos (Pagos)</span>
                        <h3 class="mb-0 fw-bold text-danger">- S/ {{ number_format($totalEgresos, 2) }}</h3>
                        <small class="text-muted">{{ $egresos->count() }} movimientos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="text-primary small fw-bold">Saldo {{ $caja->estado === 'Abierto' ? 'Actual' : 'Cierre' }}</span>
                        <h3 class="mb-0 fw-bold text-primary">S/ {{ number_format($saldoActual, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Movimientos --}}
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px;" data-aos="fade-up">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="tabMovimientos" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos" type="button" role="tab">
                            <i class="bi bi-list-ul me-1"></i>Todos
                            <span class="badge bg-dark ms-1">{{ $movimientos->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="ingresos-tab" data-bs-toggle="tab" data-bs-target="#tab-ingresos" type="button" role="tab">
                            <i class="bi bi-arrow-down-circle me-1"></i>Ingresos
                            <span class="badge bg-success ms-1">{{ $ingresos->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="egresos-tab" data-bs-toggle="tab" data-bs-target="#tab-egresos" type="button" role="tab">
                            <i class="bi bi-arrow-up-circle me-1"></i>Egresos
                            <span class="badge bg-danger ms-1">{{ $egresos->count() }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="tabMovimientosContent">
                    {{-- Tab Todos --}}
                    <div class="tab-pane fade show active" id="todos" role="tabpanel">
                        <table id="tablaTodos" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Tercero</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Referencia</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Método</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Descripción</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movimientos as $index => $mov)
                                <tr>
                                    <td class="fw-normal text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}
                                        <br><small class="text-muted">{{ $mov['hora'] }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($mov['tipo'] === 'Ingreso')
                                            <span class="badge bg-success"><i class="bi bi-arrow-down-circle me-1"></i>Ingreso</span>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-arrow-up-circle me-1"></i>Egreso</span>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle">{{ $mov['tercero'] }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($mov['referencia'])
                                            <strong>{{ $mov['referencia'] }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        <span class="badge bg-secondary">{{ $mov['metodo_pago'] }}</span>
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        <small>{{ Str::limit($mov['descripcion'], 40) }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle fw-bold {{ $mov['tipo'] === 'Ingreso' ? 'text-success' : 'text-danger' }}">
                                        {{ $mov['tipo'] === 'Ingreso' ? '+' : '-' }} S/ {{ number_format($mov['monto'], 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Tab Ingresos --}}
                    <div class="tab-pane fade" id="tab-ingresos" role="tabpanel">
                        <table id="tablaIngresos" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Venta</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Método</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Descripción</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ingresos as $index => $ingreso)
                                <tr>
                                    <td class="fw-normal text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        {{ \Carbon\Carbon::parse($ingreso->fecha_movimiento)->format('d/m/Y') }}
                                        <br><small class="text-muted">{{ $ingreso->hora_movimiento }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle">{{ $ingreso->cliente->nombre_completo ?? 'N/A' }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($ingreso->venta)
                                            <strong>{{ $ingreso->venta->codigo }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        <span class="badge bg-secondary">{{ $ingreso->metodoPago->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="fw-normal text-center align-middle"><small>{{ Str::limit($ingreso->descripcion, 40) }}</small></td>
                                    <td class="fw-normal text-center align-middle fw-bold text-success">+ S/ {{ number_format($ingreso->monto, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">TOTAL INGRESOS:</td>
                                    <td class="text-center fw-bold text-success">+ S/ {{ number_format($totalIngresos, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Tab Egresos --}}
                    <div class="tab-pane fade" id="tab-egresos" role="tabpanel">
                        <table id="tablaEgresos" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Proveedor</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Orden Compra</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Método</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Descripción</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($egresos as $index => $egreso)
                                <tr>
                                    <td class="fw-normal text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        {{ \Carbon\Carbon::parse($egreso->fecha_movimiento)->format('d/m/Y') }}
                                        <br><small class="text-muted">{{ $egreso->hora_movimiento }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle">{{ $egreso->proveedor->persona->name ?? 'N/A' }}</td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($egreso->ordenCompra)
                                            <strong>{{ $egreso->ordenCompra->codigo }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        <span class="badge bg-secondary">{{ $egreso->metodoPago->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="fw-normal text-center align-middle"><small>{{ Str::limit($egreso->descripcion, 40) }}</small></td>
                                    <td class="fw-normal text-center align-middle fw-bold text-danger">- S/ {{ number_format($egreso->monto, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">TOTAL EGRESOS:</td>
                                    <td class="text-center fw-bold text-danger">- S/ {{ number_format($totalEgresos, 2) }}</td>
                                </tr>
                            </tfoot>
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

        new DataTable('#tablaTodos', dtConfig);

        let tabIngresosInit = false;
        let tabEgresosInit = false;

        document.getElementById('ingresos-tab').addEventListener('shown.bs.tab', function () {
            if (!tabIngresosInit) {
                new DataTable('#tablaIngresos', dtConfig);
                tabIngresosInit = true;
            }
        });

        document.getElementById('egresos-tab').addEventListener('shown.bs.tab', function () {
            if (!tabEgresosInit) {
                new DataTable('#tablaEgresos', dtConfig);
                tabEgresosInit = true;
            }
        });
    });
</script>
@endsection
