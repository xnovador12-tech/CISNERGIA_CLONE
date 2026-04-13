@extends('TEMPLATES.administrador')
@section('title', 'VER VENTA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE LA VENTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-ventas.index') }}">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $venta->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-8">
                {{-- Información de la Venta --}}
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Información de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> {{ $venta->codigo }}</p>
                                <p class="mb-1"><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    @if($venta->estado == 'Pagado')
                                        <span class="badge bg-success">Pagado</span>
                                    @elseif($venta->estado == 'Parcial')
                                        <span class="badge bg-warning">Parcial</span>
                                    @elseif($venta->estado == 'Pendiente')
                                        <span class="badge bg-info">Pendiente</span>
                                    @elseif($venta->estado == 'Anulado')
                                        <span class="badge bg-danger">Anulado</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Tipo de Venta:</strong>
                                    <span class="badge bg-{{ $venta->tipo_venta === 'ecommerce' ? 'info' : ($venta->tipo_venta === 'pos' ? 'dark' : 'primary') }}">
                                        {{ ucfirst($venta->tipo_venta) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Comprobante:</strong> {{ $venta->tipocomprobante->name ?? 'Sin comprobante' }}</p>
                                <p class="mb-1"><strong>Número:</strong> {{ $venta->numero_comprobante ?? 'Sin número' }}</p>
                                @if($venta->mediopago)
                                <p class="mb-1"><strong>Medio de Pago:</strong> {{ $venta->mediopago->name }}</p>
                                @endif
                                <p class="mb-1"><strong>Tipo Operación:</strong>
                                    @if($venta->tipoOperacion)
                                        <span class="badge bg-{{ $venta->tipoOperacion->code == '1001' ? 'warning text-dark' : 'secondary' }}">
                                            {{ $venta->tipoOperacion->code }} - {{ $venta->tipoOperacion->descripcion }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                                @if($venta->detraccion)
                                <p class="mb-1"><strong>Detracción:</strong>
                                    <span class="badge bg-danger">
                                        {{ $venta->detraccion->tipoDetraccion->code }} - {{ $venta->detraccion->tipoDetraccion->descripcion }} ({{ $venta->detraccion->porcentaje }}%)
                                    </span>
                                </p>
                                @endif
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $venta->usuario->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        {{-- Datos del Cliente --}}
                        <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nombre:</strong>
                                    @if($venta->cliente)
                                        {{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}
                                        @if($venta->cliente->razon_social)
                                            <br><small class="text-muted">{{ $venta->cliente->razon_social }}</small>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Documento:</strong>
                                    @if($venta->cliente)
                                        @if($venta->cliente->tipo_persona === 'juridica')
                                            RUC: {{ $venta->cliente->ruc ?? 'N/A' }}
                                        @else
                                            DNI: {{ $venta->cliente->dni ?? 'N/A' }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Correo:</strong> {{ $venta->cliente->email ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Teléfono:</strong> {{ $venta->cliente->celular ?? $venta->cliente->telefono ?? 'N/A' }}</p>
                            </div>
                        </div>

                        {{-- Pedido Relacionado --}}
                        @if($venta->pedido)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-3">Pedido Relacionado</h6>
                        <p class="mb-1"><strong>Código:</strong> <a href="{{ route('admin-pedidos.show', $venta->pedido) }}">{{ $venta->pedido->codigo }}</a></p>
                        @endif

                        {{-- Observaciones --}}
                        @if($venta->observaciones)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p>{{ $venta->observaciones }}</p>
                        @endif
                    </div>
                </div>

                {{-- Detalles de la Venta --}}
                @if($venta->detalles->count() > 0)
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40px;">N°</th>
                                        <th>Producto / Servicio</th>
                                        <th class="text-center" style="width: 80px;">Cant.</th>
                                        <th class="text-end" style="width: 110px;">Precio Unit.</th>
                                        <th class="text-end" style="width: 90px;">Desc.</th>
                                        <th class="text-end" style="width: 120px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->detalles as $index => $detalle)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $detalle->descripcion }}</span>
                                            @if($detalle->tipo !== 'producto')
                                                <span class="badge bg-info bg-opacity-10 text-info ms-1">{{ ucfirst($detalle->tipo) }}</span>
                                            @endif
                                            @if($detalle->garantia_años)
                                                <br><small class="text-muted"><i class="bi bi-shield-check me-1"></i>Garantía: {{ $detalle->garantia_años }} años</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ number_format($detalle->cantidad, $detalle->cantidad == intval($detalle->cantidad) ? 0 : 2) }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="text-end">
                                            @if($detalle->descuento_porcentaje > 0)
                                                {{ number_format($detalle->descuento_porcentaje, 0) }}%
                                            @elseif($detalle->descuento_monto > 0)
                                                S/ {{ number_format($detalle->descuento_monto, 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end fw-semibold">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top-2">
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">Total Ítems:</td>
                                        <td class="text-end text-success">S/ {{ number_format($venta->detalles->sum('subtotal'), 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                {{-- Resumen de Montos --}}
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ {{ number_format($venta->subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ {{ number_format($venta->descuento, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ {{ number_format($venta->igv, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-success">S/ {{ number_format($venta->total, 2) }}</h5>
                        </div>
                        @if($venta->detraccion)
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-danger">Detracción ({{ $venta->detraccion->porcentaje }}%):</span>
                            <strong class="text-danger">- S/ {{ number_format($venta->detraccion->monto_detraccion, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold">NETO A COBRAR:</h6>
                            <h6 class="mb-0 fw-bold text-primary">S/ {{ number_format($venta->total - $venta->detraccion->monto_detraccion, 2) }}</h6>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header" style="background-color: #1C3146; color: white;">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin-ventas.voucher', $venta) }}" class="btn btn-danger w-100 mb-2" target="_blank">
                            <i class="bi bi-file-pdf me-2"></i>Descargar Comprobante
                        </a>
                        <a href="{{ route('admin-ventas.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>

                {{-- Información Financiera --}}
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Información Financiera</h5>
                    </div>
                    <div class="card-body">
                        {{-- Cronograma de cuotas --}}
                        @if($venta->condicion_pago === 'Crédito' && $venta->cuotas->count() > 0)
                        <hr>
                        <h6 class="fw-bold mb-2" style="font-size: 13px;"><i class="bi bi-calendar-check me-1"></i>Cuotas ({{ $venta->cuotas->count() }})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size: 12px;">
                                <thead class="bg-light">
                                    <tr>
                                        <th>N°</th>
                                        <th>Venc.</th>
                                        <th class="text-end">Importe</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->cuotas as $cuota)
                                    <tr>
                                        <td>{{ $cuota->numero_cuota }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                                        <td class="text-end fw-bold">S/ {{ number_format($cuota->importe, 2) }}</td>
                                        <td class="text-center">
                                            @if($cuota->estado === 'Pagado')
                                                <span class="badge bg-success" style="font-size: 10px;">Pagado</span>
                                            @elseif($cuota->estado === 'Vencido')
                                                <span class="badge bg-danger" style="font-size: 10px;">Vencido</span>
                                            @else
                                                <span class="badge bg-secondary" style="font-size: 10px;">Pendiente</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        {{-- Historial de pagos --}}
                        <hr>
                        <h6 class="fw-bold mb-2" style="font-size: 13px;"><i class="bi bi-clock-history me-1"></i>Pagos ({{ $venta->pagos->count() }})</h6>
                        @if($venta->pagos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size: 12px;">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Método</th>
                                        <th class="text-end">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->pagos->sortByDesc('created_at') as $pago)
                                    <tr>
                                        <td>{{ $pago->created_at->format('d/m/Y') }}</td>
                                        <td><small>{{ $pago->metodoPago->name ?? 'N/A' }}</small></td>
                                        <td class="text-end fw-bold text-success">S/ {{ number_format($pago->monto, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center mb-0" style="font-size: 12px;">Sin pagos registrados</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@if(session('auto_descargar_comprobante'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var link = document.createElement('a');
        link.href = "{{ route('admin-ventas.voucher', $venta) }}";
        link.target = '_blank';
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>
@endif
@endsection
