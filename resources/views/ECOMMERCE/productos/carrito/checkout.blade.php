@extends('TEMPLATES.ecommerce')

@section('title', 'Checkout - Finalizar Compra')

@section('content')
<!-- BREADCRUMB -->
<section class="py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.cart') }}" class="text-decoration-none">Carrito</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</section>

<!-- CHECKOUT -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4">Finalizar Compra</h2>

        <form action="{{ route('ecommerce.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row g-4">
                <!-- FORMULARIO DE DATOS -->
                <div class="col-lg-7">
                    <!-- Información Personal -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-person-circle me-2 text-primary"></i>Información Personal
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                           name="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                                           name="telefono" value="{{ old('telefono') }}" required>
                                    @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">DNI/RUC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                                           name="documento" value="{{ old('documento') }}" required>
                                    @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección de Entrega -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-geo-alt me-2 text-primary"></i>Dirección de Instalación/Entrega
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Dirección Completa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                                           name="direccion" value="{{ old('direccion') }}" 
                                           placeholder="Calle, número, urbanización, referencia" required>
                                    @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                                    <select class="form-select" id="departamento_id" required>
                                        <option value="">Seleccionar</option>
                                        <!-- Se llenarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Provincia <span class="text-danger">*</span></label>
                                    <select class="form-select" id="provincia_id" required>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Distrito <span class="text-danger">*</span></label>
                                    <select class="form-select @error('distrito_id') is-invalid @enderror" 
                                            name="distrito_id" id="distrito_id" required>
                                        <option value="">Seleccionar</option>
                                    </select>
                                    @error('distrito_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-credit-card me-2 text-primary"></i>Método de Pago
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_tarjeta" value="tarjeta" checked>
                                        <label class="form-check-label w-100" for="metodo_tarjeta">
                                            <strong><i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito/Débito</strong>
                                            <small class="d-block text-muted mt-1">Visa, Mastercard</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_yape" value="yape">
                                        <label class="form-check-label w-100" for="metodo_yape">
                                            <strong><i class="bi bi-phone me-2"></i>Yape / Plin</strong>
                                            <small class="d-block text-muted mt-1">Pago móvil</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_transferencia" value="transferencia">
                                        <label class="form-check-label w-100" for="metodo_transferencia">
                                            <strong><i class="bi bi-bank me-2"></i>Transferencia Bancaria</strong>
                                            <small class="d-block text-muted mt-1">BCP, Interbank, BBVA</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_contraentrega" value="contraentrega">
                                        <label class="form-check-label w-100" for="metodo_contraentrega">
                                            <strong><i class="bi bi-cash me-2"></i>Contra Entrega</strong>
                                            <small class="d-block text-muted mt-1">Pago al recibir</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-chat-text me-2 text-primary"></i>Observaciones (Opcional)
                            </h5>
                            <textarea class="form-control" name="observaciones" rows="3" 
                                      placeholder="Agrega cualquier indicación especial para tu pedido">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DEL PEDIDO -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Resumen del Pedido</h5>

                            <!-- Productos -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Productos ({{ $cart->getTotalItems() }})</h6>
                                @foreach($cart->items as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div style="width: 60px; height: 60px;" class="border rounded me-3">
                                        <img src="{{ asset($item->producto->imagen ?? 'images/no-image.png') }}" 
                                             class="w-100 h-100 object-fit-contain p-1" alt="{{ $item->nombre }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 small">{{ Str::limit($item->nombre, 40) }}</p>
                                        <small class="text-muted">Cant: {{ $item->cantidad }}</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">S/ {{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Totales -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-semibold">S/ {{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                                @if($cart->descuento > 0)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Descuento:</span>
                                    <span class="fw-semibold">- S/ {{ number_format($cart->descuento, 2) }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">IGV (18%):</span>
                                    <span class="fw-semibold">S/ {{ number_format($cart->igv, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Envío:</span>
                                    <span class="fw-semibold text-success">GRATIS</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold fs-5">Total a Pagar:</span>
                                    <span class="fw-bold fs-4 text-primary">S/ {{ number_format($cart->total, 2) }}</span>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold mb-3" id="submitBtn">
                                    <i class="bi bi-shield-check me-2"></i>Confirmar Pedido
                                </button>

                                <a href="{{ route('ecommerce.cart') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Volver al carrito
                                </a>
                            </div>

                            <!-- Información de seguridad -->
                            <div class="mt-4 pt-4 border-top">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Compra 100% Segura</p>
                                        <small class="text-muted">Tus datos están protegidos</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-truck text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Envío Gratis</p>
                                        <small class="text-muted">A todo el Perú</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-return-left text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Garantía de Devolución</p>
                                        <small class="text-muted">30 días para devolver</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    // Manejar el envío del formulario
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        let btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
    });

    // Nota: En producción, aquí cargarías los departamentos, provincias y distritos
    // Por ahora, usaremos valores estáticos para Lima
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar departamentos (simplificado para el ejemplo)
        const departamentoSelect = document.getElementById('departamento_id');
        departamentoSelect.innerHTML = '<option value="">Seleccionar</option><option value="15">Lima</option>';
        
        // Cuando se cambie, cargar distritos (simplificado)
        departamentoSelect.addEventListener('change', function() {
            if (this.value == '15') {
                const distritoSelect = document.getElementById('distrito_id');
                distritoSelect.innerHTML = `
                    <option value="">Seleccionar</option>
                    <option value="1">Lima Cercado</option>
                    <option value="2">Miraflores</option>
                    <option value="3">San Isidro</option>
                    <option value="4">Surco</option>
                    <option value="5">La Molina</option>
                    <option value="6">San Borja</option>
                `;
            }
        });
    });
</script>
@endsection
