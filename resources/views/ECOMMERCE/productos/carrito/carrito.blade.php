@extends('TEMPLATES.ecommerce')

@section('title', 'Carrito de Compras')

@section('content')
<!-- BREADCRUMB -->
<section class="py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrito de Compras</li>
            </ol>
        </nav>
    </div>
</section>

<!-- CARRITO DE COMPRAS -->
<section class="py-5 bg-light">
    <div class="container">
        @if($cart->items->count() > 0)
        <div class="row g-4">
            <!-- COLUMNA IZQUIERDA: PRODUCTOS EN CARRITO -->
            <div class="col-lg-8">
                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Carrito ({{ $cart->getTotalItems() }} productos)</h2>
                    <a href="{{ route('ecommerce.products') }}" class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="bi bi-arrow-left me-2"></i>Continuar comprando
                    </a>
                </div>

                <!-- Lista de productos -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @foreach($cart->items as $index => $item)
                        <div class="row align-items-center mb-3 pb-3 {{ $loop->last ? '' : 'border-bottom' }}" data-item-id="{{ $item->id }}">
                            <div class="col-auto">
                                <input type="checkbox" class="form-check-input item-checkbox" checked>
                            </div>
                            <div class="col-auto">
                                <div style="width: 100px; height: 100px;" class="border rounded">
                                    <img src="{{ asset($item->producto->imagen ?? 'images/no-image.png') }}" 
                                         class="w-100 h-100 object-fit-contain p-2" alt="{{ $item->nombre }}">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">{{ $item->nombre }}</h6>
                                @if($item->producto && $item->producto->marca)
                                <small class="text-muted d-block mb-1">Marca: {{ $item->producto->marca->name }}</small>
                                @endif
                                <small class="text-muted">Código: {{ $item->producto->codigo ?? 'N/A' }}</small>
                            </div>
                            <div class="col-auto">
                                <label class="form-label small mb-1">Cantidad:</label>
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-sm btn-outline-secondary decrement-btn" type="button" data-item-id="{{ $item->id }}">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control form-control-sm text-center cantidad-input" 
                                           value="{{ $item->cantidad }}" min="1" data-item-id="{{ $item->id }}" readonly>
                                    <button class="btn btn-sm btn-outline-secondary increment-btn" type="button" data-item-id="{{ $item->id }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <div class="mb-1">
                                    @if($item->descuento > 0)
                                    <small class="text-muted text-decoration-line-through d-block">
                                        S/ {{ number_format($item->precio_unitario * $item->cantidad, 2) }}
                                    </small>
                                    @endif
                                    <h5 class="text-primary fw-bold mb-0 item-subtotal">S/ {{ number_format($item->subtotal, 2) }}</h5>
                                    @if($item->descuento > 0)
                                    <span class="badge bg-secondary">{{ number_format(($item->descuento / ($item->precio_unitario * $item->cantidad)) * 100, 0) }}% OFF</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-outline-danger remove-item-btn" data-item-id="{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: RESUMEN DE LA ORDEN -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Resumen de la orden</h5>
                        
                        <!-- Productos -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Productos ({{ $cart->getTotalItems() }})</span>
                            <span class="fw-semibold" id="cart-subtotal">S/ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>

                        <!-- Descuentos -->
                        @if($cart->descuento > 0)
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Descuentos</span>
                            <span class="fw-semibold">- S/ {{ number_format($cart->descuento, 2) }}</span>
                        </div>
                        @endif

                        <!-- IGV -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">IGV (18%)</span>
                            <span class="fw-semibold" id="cart-igv">S/ {{ number_format($cart->igv, 2) }}</span>
                        </div>

                        <!-- Total -->
                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold h5 mb-0" id="cart-total">S/ {{ number_format($cart->total, 2) }}</span>
                        </div>

                        <!-- Botón continuar -->
                        <a href="{{ route('ecommerce.checkout') }}" class="btn btn-primary w-100 py-3 fw-semibold mb-3">
                            Continuar compra
                        </a>

                        <!-- Información adicional -->
                        <div class="text-center">
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-shield-check me-1"></i>
                                Compra protegida
                            </small>
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-truck me-1"></i>
                                Envío a todo el Perú
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-credit-card me-1"></i>
                                Pago seguro
                            </small>
                        </div>

                        <!-- Cupón de descuento -->
                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label fw-semibold small">¿Tienes un cupón?</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Código de cupón" id="cupon-input">
                                <button class="btn btn-outline-secondary" type="button" id="apply-cupon-btn">Aplicar</button>
                            </div>
                        </div>

                        <!-- Métodos de pago -->
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted d-block mb-2 fw-semibold">Métodos de pago aceptados:</small>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-credit-card"></i> Visa
                                </span>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-credit-card"></i> Mastercard
                                </span>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-wallet2"></i> Yape
                                </span>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-bank"></i> Transferencia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Carrito vacío -->
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
            <h3 class="mb-3">Tu carrito está vacío</h3>
            <p class="text-muted mb-4">¡Explora nuestros productos y encuentra lo que necesitas!</p>
            <a href="{{ route('ecommerce.products') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-grid-3x3-gap me-2"></i>Ver productos
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

@section('js')
<script>
    // Incrementar cantidad
    document.querySelectorAll('.increment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let itemId = this.dataset.itemId;
            let input = document.querySelector(`.cantidad-input[data-item-id="${itemId}"]`);
            let newCantidad = parseInt(input.value) + 1;
            updateItemQuantity(itemId, newCantidad);
        });
    });

    // Decrementar cantidad
    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let itemId = this.dataset.itemId;
            let input = document.querySelector(`.cantidad-input[data-item-id="${itemId}"]`);
            let newCantidad = parseInt(input.value) - 1;
            if (newCantidad >= 1) {
                updateItemQuantity(itemId, newCantidad);
            }
        });
    });

    // Eliminar item
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('¿Estás seguro de eliminar este producto del carrito?')) {
                let itemId = this.dataset.itemId;
                removeItem(itemId);
            }
        });
    });

    // Función para actualizar cantidad
    function updateItemQuantity(itemId, cantidad) {
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cantidad: cantidad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar cantidad en input
                document.querySelector(`.cantidad-input[data-item-id="${itemId}"]`).value = cantidad;
                
                // Actualizar subtotal del item
                document.querySelector(`[data-item-id="${itemId}"] .item-subtotal`).textContent = 'S/ ' + data.subtotal;
                
                // Actualizar totales del carrito
                document.getElementById('cart-total').textContent = 'S/ ' + data.cart_total;
                
                // Recalcular subtotal e IGV
                location.reload(); // Recargar para actualizar todos los valores
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar la cantidad');
        });
    }

    // Función para eliminar item
    function removeItem(itemId) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Eliminar fila del DOM
                document.querySelector(`[data-item-id="${itemId}"]`).remove();
                
                // Actualizar contador del carrito
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cart_count;
                });

                // Si no hay más items, recargar página
                if (data.cart_count == 0) {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el producto');
        });
    }
</script>
@endsection
