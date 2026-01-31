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
                        <li class="breadcrumb-item link" aria-current="page">Ver Venta</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-8">
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
                                    @if($venta->estado == 'completada')
                                        <span class="badge bg-success">Completada</span>
                                    @elseif($venta->estado == 'parcial')
                                        <span class="badge bg-warning">Parcial</span>
                                    @else
                                        <span class="badge bg-danger">Anulada</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Comprobante:</strong> {{ $venta->tipocomprobante->name ?? 'Sin comprobante' }}</p>
                                <p class="mb-1"><strong>Número:</strong> {{ $venta->numero_comprobante ?? 'Sin número' }}</p>
                                <p class="mb-1"><strong>Medio de Pago:</strong> {{ $venta->mediopago->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Nombre:</strong> {{ $venta->cliente->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Documento:</strong> {{ $venta->cliente->documento ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Correo:</strong> {{ $venta->cliente->correo ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if($venta->pedido)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-3">Pedido Relacionado</h6>
                        <p class="mb-1"><strong>Código:</strong> <a href="{{ route('admin-pedidos.show', $venta->pedido) }}">{{ $venta->pedido->codigo }}</a></p>
                        @endif

                        @if($venta->observaciones)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p>{{ $venta->observaciones }}</p>
                        @endif
                    </div>
                </div>

                <!-- Detalles de la Venta -->
                @if($venta->detalles->count() > 0)
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Desc.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach($venta->detalles as $detalle)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ $detalle->productos }}</td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->precio, 2) }}</td>
                                    <td class="text-end">{{ $detalle->descuento }}%</td>
                                    <td class="text-end">S/ {{ number_format($detalle->precio_descuento * $detalle->cantidad, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
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
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-danger w-100 mb-2">
                            <i class="bi bi-file-pdf me-2"></i>Descargar PDF
                        </button>
                        <a href="{{ route('admin-ventas.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
