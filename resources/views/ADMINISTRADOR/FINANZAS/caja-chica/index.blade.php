@extends('TEMPLATES.administrador')
@section('title', 'CAJA CHICA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">CAJA CHICA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Finanzas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Caja Chica</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado de Caja Actual -->
    <div class="container-fluid mb-4">
        @if($cajaAbierta)
            @php
                $ingresosActual = $cajaAbierta->ingresos()->sum('monto');
                $egresosActual = $cajaAbierta->egresos()->sum('monto');
                $saldoActual = $cajaAbierta->saldo_inicial + $ingresosActual - $egresosActual;
            @endphp
            <div class="card border-0 shadow-sm border-start border-5 border-success" data-aos="fade-up">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-unlock fs-2 text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Caja Activa</small>
                                    <h5 class="mb-0 fw-bold">{{ $cajaAbierta->codigo }}</h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($cajaAbierta->fecha_apertura)->format('d/m/Y') }} {{ $cajaAbierta->hora_apertura }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="text-muted small">Saldo Inicial</span>
                            <h5 class="mb-0 fw-bold">S/ {{ number_format($cajaAbierta->saldo_inicial, 2) }}</h5>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="text-success small fw-bold">Ingresos</span>
                            <h5 class="mb-0 fw-bold text-success">+ S/ {{ number_format($ingresosActual, 2) }}</h5>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="text-danger small fw-bold">Egresos</span>
                            <h5 class="mb-0 fw-bold text-danger">- S/ {{ number_format($egresosActual, 2) }}</h5>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="text-primary small fw-bold">Saldo Actual</span>
                            <h4 class="mb-0 fw-bold text-primary">S/ {{ number_format($saldoActual, 2) }}</h4>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ route('admin-caja-chica.show', $cajaAbierta) }}" class="btn btn-outline-primary btn-sm me-1">
                                <i class="bi bi-eye me-1"></i>Ver
                            </a>
                            <form action="{{ route('admin-caja-chica.cerrar', $cajaAbierta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de cerrar la caja? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-lock me-1"></i>Cerrar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm border-start border-5 border-warning" data-aos="fade-up">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-lock fs-2 text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">No hay caja abierta</h5>
                                    <small class="text-muted">Debe abrir una caja para registrar movimientos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('admin-caja-chica.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>Abrir Caja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Historial de Cajas -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 400px" data-aos="fade-up">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Cajas</h5>
                </div>
                <table id="tablaCajas" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Usuario</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Apertura</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Saldo Inicial</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Ingresos</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Egresos</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Saldo Cierre</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = $cajas->count(); @endphp
                        @foreach($cajas as $caja)
                        <tr>
                            <td class="fw-normal text-center align-middle">{{ $contador-- }}</td>
                            <td class="fw-normal text-center align-middle">
                                <strong>{{ $caja->codigo }}</strong>
                            </td>
                            <td class="fw-normal text-center align-middle">{{ $caja->user->name ?? 'N/A' }}</td>
                            <td class="fw-normal text-center align-middle">
                                {{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y') }}
                                <br><small class="text-muted">{{ $caja->hora_apertura }}</small>
                            </td>
                            <td class="fw-normal text-center align-middle fw-bold">S/ {{ number_format($caja->saldo_inicial, 2) }}</td>
                            @php
                                $ingCaja = $caja->estado === 'Abierto' ? $caja->ingresos()->sum('monto') : $caja->total_ingresos;
                                $egrCaja = $caja->estado === 'Abierto' ? $caja->egresos()->sum('monto') : $caja->total_egresos;
                            @endphp
                            <td class="fw-normal text-center align-middle fw-bold text-success">S/ {{ number_format($ingCaja, 2) }}</td>
                            <td class="fw-normal text-center align-middle fw-bold text-danger">S/ {{ number_format($egrCaja, 2) }}</td>
                            <td class="fw-normal text-center align-middle fw-bold text-primary">
                                S/ {{ number_format($caja->estado === 'Abierto' ? $caja->saldo_inicial + $ingCaja - $egrCaja : $caja->saldo_cierre, 2) }}
                            </td>
                            <td class="fw-normal text-center align-middle">
                                @if($caja->estado === 'Abierto')
                                    <span class="badge bg-success">Abierta</span>
                                @else
                                    <span class="badge bg-secondary">Cerrada</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('admin-caja-chica.show', $caja) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#tablaCajas', {
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
        });
    });
</script>
@endsection
