@extends('TEMPLATES.administrador')
@section('title', 'COMPROBANTES')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COMPROBANTES</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Finanzas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Comprobantes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="container-fluid mb-4">
        @php
            $facturas = $comprobantes->filter(fn($c) => $c->tipocomprobante && $c->tipocomprobante->codigo == '01');
            $boletas = $comprobantes->filter(fn($c) => $c->tipocomprobante && $c->tipocomprobante->codigo == '03');
        @endphp
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Comprobantes</p>
                                <h3 class="mb-0 fw-bold">{{ $comprobantes->count() }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-receipt fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Facturas</p>
                                <h3 class="mb-0 fw-bold text-info">{{ $facturas->count() }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-file-earmark-text fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Boletas</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $boletas->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-file-earmark fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Monto Total</p>
                                <h3 class="mb-0 fw-bold text-primary">S/ {{ number_format($comprobantes->sum('total'), 2) }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-stack fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Comprobantes -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-body">
                <table id="tablaComprobantes" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">N° Comprobante</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha Emisión</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Pagado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comprobantes as $comp)
                        <tr>
                            <td class="fw-normal text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="fw-normal text-center align-middle">
                                <strong>{{ $comp->numero_comprobante }}</strong>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                @if($comp->tipocomprobante->codigo == '01')
                                    <span class="badge bg-info">Factura</span>
                                @else
                                    <span class="badge bg-success">Boleta</span>
                                @endif
                            </td>
                            <td class="fw-normal text-center align-middle">
                                @if($comp->cliente)
                                    {{ $comp->cliente->nombre }} {{ $comp->cliente->apellidos }}
                                    @if($comp->cliente->razon_social)
                                        <br><small class="text-muted">{{ $comp->cliente->razon_social }}</small>
                                    @endif
                                    <br><small class="text-muted">{{ $comp->cliente->documento }}</small>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="fw-normal text-center align-middle">{{ $comp->created_at->format('d/m/Y') }}</td>
                            <td class="fw-normal text-center align-middle fw-bold">S/ {{ number_format($comp->total, 2) }}</td>
                            <td class="fw-normal text-center align-middle fw-bold text-primary">S/ {{ number_format($comp->total_pagado, 2) }}</td>
                            <td class="fw-normal text-center align-middle">
                                @if($comp->saldo_pendiente <= 0.05)
                                    <span class="badge bg-success">Pagado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('admin-comprobantes-finanzas.show', $comp) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
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
        new DataTable('#tablaComprobantes', {
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
