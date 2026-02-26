@extends('TEMPLATES.ecommerce')

@section('title', 'Pedido Confirmado')

@section('content')
<!-- CONFIRMACIÓN DE PEDIDO -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Mensaje de éxito -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-3">¡Pedido Confirmado!</h2>
                        <p class="text-muted mb-4">
                            Tu pedido <strong class="text-primary">{{ $pedido->codigo }}</strong> ha sido recibido exitosamente.
                            <br>Te enviaremos un correo de confirmación a <strong>{{ $pedido->cliente->email }}</strong>
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('ecommerce.index') }}" class="btn btn-primary">
                                <i class="bi bi-house-door me-2"></i>Volver al Inicio
                            </a>
                            <a href="{{ route('ecommerce.products') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-grid-3x3-gap me-2"></i>Ver Productos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-receipt me-2 text-primary"></i>Detalles del Pedido
                            </h5>
                            <span class="badge bg-warning text-dark">{{ ucfirst($pedido->estado) }}</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código de Pedido:</strong></p>
                                <p class="text-muted mb-0">{{ $pedido->codigo }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Fecha:</strong></p>
                                <p class="text-muted mb-0">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Cliente:</strong></p>
                                <p class="text-muted mb-0">{{ $pedido->cliente->nombre_completo }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Teléfono:</strong></p>
                                <p class="text-muted mb-0">{{ $pedido->cliente->telefono }}</p>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-geo-alt me-2"></i>Dirección de Entrega
                            </h6>
                            <p class="text-muted mb-0">{{ $pedido->direccion_instalacion }}</p>
                            @if($pedido->distrito)
                            <p class="text-muted mb-0">{{ $pedido->distrito->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-box-seam me-2 text-primary"></i>Productos ({{ $pedido->detalles->count() }})
                        </h5>

                        @foreach($pedido->detalles as $detalle)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ $loop->last ? '' : 'border-bottom' }}">
                            <div style="width: 80px; height: 80px;" class="border rounded me-3">
                                @if($detalle->producto)
                                <img src="{{ asset($detalle->producto->imagen ?? 'images/no-image.png') }}" 
                                     class="w-100 h-100 object-fit-contain p-2" alt="{{ $detalle->descripcion }}">
                                @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-box text-muted fs-3"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $detalle->descripcion }}</h6>
                                <p class="text-muted small mb-0">
                                    Cantidad: {{ $detalle->cantidad }} × S/ {{ number_format($detalle->precio_unitario, 2) }}
                                </p>
                                @if($detalle->producto && $detalle->producto->codigo)
                                <p class="text-muted small mb-0">Código: {{ $detalle->producto->codigo }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                <p class="mb-0 fw-bold">S/ {{ number_format($detalle->subtotal, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Resumen de Pago -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-calculator me-2 text-primary"></i>Resumen de Pago
                        </h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-semibold">S/ {{ number_format($pedido->subtotal, 2) }}</span>
                        </div>

                        @if($pedido->descuento > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Descuento:</span>
                            <span class="fw-semibold">- S/ {{ number_format($pedido->descuento, 2) }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">IGV (18%):</span>
                            <span class="fw-semibold">S/ {{ number_format($pedido->igv, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Envío:</span>
                            <span class="fw-semibold text-success">GRATIS</span>
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-5">Total Pagado:</span>
                                <span class="fw-bold fs-4 text-primary">S/ {{ number_format($pedido->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Próximos Pasos -->
                <div class="card border-0 bg-light mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-info-circle me-2 text-primary"></i>¿Qué sigue ahora?
                        </h5>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-envelope-check text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">1. Confirmación</h6>
                                    <p class="small text-muted mb-0">
                                        Recibirás un correo con los detalles de tu pedido
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-box-seam text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">2. Preparación</h6>
                                    <p class="small text-muted mb-0">
                                        Prepararemos tu pedido en nuestro almacén
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-truck text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">3. Envío</h6>
                                    <p class="small text-muted mb-0">
                                        Te lo enviaremos a la dirección indicada
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacto -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3">¿Necesitas ayuda con tu pedido?</h6>
                        <p class="text-muted small mb-3">
                            Nuestro equipo de soporte está disponible para ayudarte
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:ventas@cisnergia.com" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope me-2"></i>Enviar correo
                            </a>
                            <a href="https://wa.me/51999999999" class="btn btn-outline-success btn-sm" target="_blank">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                            <a href="tel:+51999999999" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-telephone me-2"></i>Llamar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
