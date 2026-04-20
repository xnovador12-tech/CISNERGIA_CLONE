@extends('TEMPLATES.administrador')
@section('title', 'DETALLE COMPROBANTE')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DEL COMPROBANTE</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-comprobantes-finanzas.index') }}">Comprobantes</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $venta->numero_comprobante }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-12">

                {{-- Datos del Comprobante --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>{{ $venta->tipocomprobante->name ?? 'Comprobante' }} - {{ $venta->numero_comprobante }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>N° Comprobante:</strong> {{ $venta->numero_comprobante }}</p>
                                <p class="mb-1"><strong>Tipo:</strong>
                                    @if($venta->tipocomprobante->codigo == '01')
                                        <span class="badge bg-info">Factura</span>
                                    @else
                                        <span class="badge bg-success">Boleta</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Código Venta:</strong> {{ $venta->codigo }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Fecha Emisión:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Condición:</strong>
                                    <span class="badge {{ $venta->condicion_pago == 'Crédito' ? 'bg-info' : 'bg-secondary' }}">{{ $venta->condicion_pago }}</span>
                                </p>
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $venta->usuario->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Cliente:</strong> {{ $venta->cliente->nombre_completo ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Documento:</strong> {{ $venta->cliente->documento ?? 'N/A' }}</p>
                                @if($venta->cliente && $venta->cliente->razon_social)
                                    <p class="mb-1"><strong>Razón Social:</strong> {{ $venta->cliente->razon_social }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resumen Financiero --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-2">
                                <span class="text-muted small">Subtotal</span>
                                <h5 class="mb-0 fw-bold">S/ {{ number_format($venta->subtotal, 2) }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="text-muted small">IGV (18%)</span>
                                <h5 class="mb-0 fw-bold">S/ {{ number_format($venta->igv, 2) }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="text-muted small">Descuento</span>
                                <h5 class="mb-0 fw-bold text-danger">S/ {{ number_format($venta->descuento ?? 0, 2) }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="text-primary small fw-bold">TOTAL</span>
                                <h5 class="mb-0 fw-bold text-primary">S/ {{ number_format($venta->total, 2) }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="text-success small fw-bold">PAGADO</span>
                                <h5 class="mb-0 fw-bold text-success">S/ {{ number_format($totalPagado, 2) }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="{{ $saldoPendiente > 0.05 ? 'text-danger' : 'text-success' }} small fw-bold">SALDO</span>
                                <h5 class="mb-0 fw-bold {{ $saldoPendiente > 0.05 ? 'text-danger' : 'text-success' }}">S/ {{ number_format(max(0, $saldoPendiente), 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detalle de Productos --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalle</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end">P. Unit.</th>
                                        <th class="text-end">Desc.</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->detalles as $index => $detalle)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detalle->descripcion }}</td>
                                        <td class="text-center">{{ $detalle->cantidad }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->descuento_monto ?? 0, 2) }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Historial de Pagos --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Pagos ({{ $venta->pagos->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($venta->pagos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center small text-uppercase fw-bold">N°</th>
                                            <th class="small text-uppercase fw-bold">Fecha</th>
                                            <th class="small text-uppercase fw-bold">Método</th>
                                            <th class="small text-uppercase fw-bold">Detalle</th>
                                            <th class="text-end small text-uppercase fw-bold">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($venta->pagos as $index => $pago)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pago->fecha_movimiento)->format('d/m/Y') }} <br><small class="text-muted">{{ $pago->hora_movimiento }}</small></td>
                                            <td><span class="badge bg-secondary">{{ $pago->metodoPago->name ?? 'N/A' }}</span></td>
                                            <td>
                                                @if($pago->cuentaBancaria && $pago->cuentaBancaria->banco)
                                                    <small>{{ $pago->cuentaBancaria->banco->name }} - {{ $pago->cuentaBancaria->numero_cuenta }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold text-success">S/ {{ number_format($pago->monto, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">TOTAL PAGADO:</td>
                                            <td class="text-end fw-bold text-primary">S/ {{ number_format($totalPagado, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">No se han registrado pagos</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Notas Asociadas --}}
                @if(isset($notasVentas) && $notasVentas->count() > 0)
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-minus me-2"></i>Notas Asociadas ({{ $notasVentas->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center small text-uppercase fw-bold">N° Comprobante</th>
                                        <th class="text-center small text-uppercase fw-bold">Tipo</th>
                                        <th class="small text-uppercase fw-bold">Motivo</th>
                                        <th class="text-center small text-uppercase fw-bold">Fecha</th>
                                        <th class="text-end small text-uppercase fw-bold">Total</th>
                                        <th class="text-center small text-uppercase fw-bold">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notasVentas as $nota)
                                    <tr>
                                        <td class="text-center">
                                            <strong>{{ $nota->numero_comprobante }}</strong>
                                            <br><small class="text-muted">{{ $nota->codigo }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($nota->tipocomprobante?->codigo === '07')
                                                <span class="badge bg-danger">NC</span>
                                            @else
                                                <span class="badge bg-info">ND</span>
                                            @endif
                                        </td>
                                        <td><small>{{ $nota->ventaReferencia?->sunatMotivoNota?->descripcion ?? 'N/A' }}</small></td>
                                        <td class="text-center">{{ $nota->created_at->format('d/m/Y') }}</td>
                                        <td class="text-end fw-bold {{ $nota->tipocomprobante?->codigo === '07' ? 'text-danger' : 'text-info' }}">
                                            S/ {{ number_format($nota->total, 2) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin-nota-ventas.show', $nota) }}" class="btn btn-sm btn-outline-primary">
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
                @endif

                {{-- Botones --}}
                <div class="d-flex gap-2 mb-4">
                    <a href="{{ route('admin-comprobantes-finanzas.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Volver a Comprobantes
                    </a>
                    <a href="{{ route('admin-ventas.show', $venta) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>Ver Venta
                    </a>
                    @if($venta->estado !== 'anulada')
                        <a href="{{ route('admin-nota-ventas.create', ['sale_id' => $venta->id, 'tipo' => 'nc']) }}" class="btn btn-danger">
                            <i class="bi bi-dash-circle me-2"></i>Emitir Nota de Credito
                        </a>
                        <a href="{{ route('admin-nota-ventas.create', ['sale_id' => $venta->id, 'tipo' => 'nd']) }}" class="btn btn-info text-white">
                            <i class="bi bi-plus-circle me-2"></i>Emitir Nota de Debito
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
