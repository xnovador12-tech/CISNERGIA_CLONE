@extends('TEMPLATES.administrador')
@section('title', 'VER PEDIDO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DEL PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pedidos.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ver Pedido</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            <!-- Información del Pedido -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> {{ $pedido->codigo }}</p>
                                <p class="mb-1"><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Origen:</strong> 
                                    <span class="badge {{ $pedido->origen == 'ecommerce' ? 'bg-purple' : 'bg-secondary' }}">
                                        {{ ucfirst($pedido->origen) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Estado:</strong>
                                    @if($pedido->estado == 'pendiente')
                                        <span class="badge bg-warning">Pendiente</span>
                                    @elseif($pedido->estado == 'confirmado')
                                        <span class="badge bg-info">Confirmado</span>
                                    @elseif($pedido->estado == 'preparacion')
                                        <span class="badge bg-primary">En Preparación</span>
                                    @elseif($pedido->estado == 'despacho')
                                        <span class="badge bg-secondary">En Despacho</span>
                                    @elseif($pedido->estado == 'entregado')
                                        <span class="badge bg-success">Entregado</span>
                                    @else
                                        <span class="badge bg-danger">Cancelado</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Fecha Entrega:</strong> {{ $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'Sin fecha' }}</p>
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $pedido->usuario->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Nombre:</strong> {{ $pedido->cliente->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Documento:</strong> {{ $pedido->cliente->documento ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Correo:</strong> {{ $pedido->cliente->correo ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente->telefono ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase fw-bold mb-3">Instalación</h6>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Dirección:</strong> {{ $pedido->direccion_instalacion ?? 'No especificada' }}</p>
                                <p class="mb-1"><strong>Distrito:</strong> {{ $pedido->distrito->name ?? 'No especificado' }}</p>
                                <p class="mb-1"><strong>Técnico Asignado:</strong> {{ $pedido->tecnico->name ?? 'Sin asignar' }}</p>
                                <p class="mb-1"><strong>Almacén:</strong> {{ $pedido->almacen->name ?? 'Sin asignar' }}</p>
                            </div>
                        </div>

                        @if($pedido->observaciones)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p>{{ $pedido->observaciones }}</p>
                        @endif
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Desc.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>
                                        {{ $detalle->descripcion }}
                                        <br><small class="text-muted">Tipo: {{ ucfirst($detalle->tipo) }}</small>
                                    </td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->descuento, 2) }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ {{ number_format($pedido->subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ {{ number_format($pedido->descuento, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ {{ number_format($pedido->igv, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-primary">S/ {{ number_format($pedido->total, 2) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin-pedidos.edit', $pedido) }}" class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-pencil me-2"></i>Editar Pedido
                        </a>
                        <a href="{{ route('admin-pedidos.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
