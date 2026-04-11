@extends('TEMPLATES.ecommerce')

@section('title', 'Carrito de Compras')
@section('css')
<style>
.cantidad-input::-webkit-outer-spin-button,
.cantidad-input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
.cantidad-input[type=number] {
  -moz-appearance: textfield;
  appearance: textfield;
}
</style>
@endsection
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
        @if(count($cart) > 0)
        <div class="row g-4">
            <!-- COLUMNA IZQUIERDA: PRODUCTOS EN CARRITO -->
            <div class="col-lg-8">
                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Carrito ({{ count($cart) }} productos)</h2>
                    <a href="{{ route('ecommerce.products') }}" class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="bi bi-arrow-left me-2"></i>Continuar comprando
                    </a>
                </div>

                <!-- Lista de productos -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4" id="lista_carrito_compras_id">
                        @foreach($cart as $item)
                            @php
                                $valores_productos = \App\Models\Producto::where('id', $item['producto_id'])->first();
                            @endphp
                        <div class="row align-items-center mb-3 pb-3 {{ $loop->last ? '' : 'border-bottom' }}" data-item-id="{{ $item['producto_id'] }}">
                            <div class="col-auto">
                                <input type="checkbox" class="form-check-input item-checkbox" checked>
                            </div>
                            <div class="col-auto">
                                <div style="width: 100px; height: 100px;" class="border rounded">
                                    <img src="{{ asset($item['imagen_producto'] ?? 'images/logo.webp') }}" 
                                         class="w-100 h-100 object-fit-contain p-2" alt="{{ $item['name_producto'] }}">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">{{ $item['name_producto'] }}</h6>
                                @if(isset($valores_productos->marca_id))
                                <small class="text-muted d-block mb-1">Marca: {{ $valores_productos->marca->name }}</small>
                                @endif
                                <small class="text-muted">Código: {{ $valores_productos->codigo ?? 'N/A' }}</small>
                            </div>
                            <div class="col-auto">
                                <label class="form-label small mb-1">Cantidad:</label>
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-sm btn-outline-secondary decrement-btn" type="button" data-item-id="{{ $item['producto_id'] }}">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control form-control-sm text-center cantidad-input" 
                                           value="{{ $item['cantidad'] }}" min="1" data-item-id="{{ $item['producto_id'] }}" readonly>
                                    <button class="btn btn-sm btn-outline-secondary increment-btn" type="button" data-item-id="{{ $item['producto_id'] }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <div class="mb-1">
                                    
                                    <h5 class="text-primary fw-bold mb-0 item-subtotal">S/ {{ number_format(($valores_productos->precio * $item['cantidad']) - 0, 2) }}</h5>
                                    <span class="badge bg-secondary">{{ number_format($item['porcentaje'], 0) }}% OFF</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button onclick="eliminar_carrito_id({{ $item['producto_id'] }});" class="btn btn-sm btn-outline-danger remove-item-btn" data-item-id="{{ $item['producto_id'] }}">
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
                            <span class="text-muted">Productos ({{ count($cart) }})</span>
                            <span class="fw-semibold" id="cart-subtotal">S/ {{ number_format($subtotal, 2) }}</span>
                        </div>

                        <!-- Descuentos -->
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Descuentos</span>
                            <span class="fw-semibold">- S/ {{ number_format(0, 2) }}</span>
                        </div>

                        <!-- IGV -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">IGV (18%)</span>
                            <span class="fw-semibold" id="cart-igv">S/ {{ number_format($igv, 2) }}</span>
                        </div>

                        <!-- CUPON -->
                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Descuento por cupón</span>
                            <span class="fw-semibold" id="cupon_html">- S/ 0.00</span>
                            <input type="hidden" id="valor_cuponera_hidden" value="0">
                        </div>
                        <!-- Total -->
                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold h5 mb-0" id="cart-total">S/ {{ number_format($total, 2) }}</span>
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
                                <input type="text" class="form-control" placeholder="Código de cupón" id="valor_cuponera_id">
                                <button class="btn btn-outline-secondary" type="button" id="aplicar_cuponera_id">Aplicar</button>
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
            var itemId = this.dataset.itemId;
            var input = document.querySelector('.cantidad-input[data-item-id="' + itemId + '"]');
            var newCantidad = parseInt(input.value || '1', 10) + 1;
            updateItemQuantity(itemId, newCantidad);
        });
    });

    // Decrementar cantidad
    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            var itemId = this.dataset.itemId;
            var input = document.querySelector('.cantidad-input[data-item-id="' + itemId + '"]');
            var newCantidad = parseInt(input.value || '1', 10) - 1;
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

    // Función para actualizar cantidad en carrito de sesión
    function updateItemQuantity(itemId, cantidad) {
        var cantidadFinal = Math.max(1, Number(cantidad || 1));

        $.get('/actualizar_cantidad_carrito', { id_element_producto: itemId, cantidad: cantidadFinal }, function(response){
            applyCartResponse(response);
        }).fail(function(){
            alert('Error al actualizar la cantidad');
        });
    }

    function formatMoney(value) {
        return 'S/ ' + Number(value || 0).toFixed(2);
    }

    function renderCarrito(items) {
        let html = '';

        items.forEach(function(item, index) {
            const borderClass = (index === items.length - 1) ? '' : 'border-bottom';
            const marcaHtml = item.valor_marca
                ? '<small class="text-muted d-block mb-1">Marca: ' + item.valor_marca + '</small>'
                : '';

            html += '<div class="row align-items-center mb-3 pb-3 ' + borderClass + '" data-item-id="' + item.producto_id + '">';
            html += '  <div class="col-auto">';
            html += '      <input type="checkbox" class="form-check-input item-checkbox" checked>';
            html += '  </div>';
            html += '  <div class="col-auto">';
            html += '      <div style="width: 100px; height: 100px;" class="border rounded">';
            html += '          <img src="' + (item.imagen_producto || '{{ asset('images/logo.webp') }}') + '" class="w-100 h-100 object-fit-contain p-2" alt="' + (item.name_producto || '') + '">';
            html += '      </div>';
            html += '  </div>';
            html += '  <div class="col">';
            html += '      <h6 class="mb-1">' + (item.name_producto || '') + '</h6>';
            html +=        marcaHtml;
            html += '      <small class="text-muted">Código: ' + (item.valor_codigo || 'N/A') + '</small>';
            html += '  </div>';
            html += '  <div class="col-auto">';
            html += '      <label class="form-label small mb-1">Cantidad:</label>';
            html += '      <div class="input-group" style="width: 130px;">';
            html += '          <button class="btn btn-sm btn-outline-secondary decrement-btn" type="button" onclick="updateItemQuantity(' + item.producto_id + ', ' + (Number(item.cantidad) - 1) + ')">';
            html += '              <i class="bi bi-dash"></i>';
            html += '          </button>';
            html += '          <input type="number" class="form-control form-control-sm text-center cantidad-input" value="' + item.cantidad + '" min="1" data-item-id="' + item.producto_id + '" readonly>';
            html += '          <button class="btn btn-sm btn-outline-secondary increment-btn" type="button" onclick="updateItemQuantity(' + item.producto_id + ', ' + (Number(item.cantidad) + 1) + ')">';
            html += '              <i class="bi bi-plus"></i>';
            html += '          </button>';
            html += '      </div>';
            html += '  </div>';
            html += '  <div class="col-auto text-end">';
            html += '      <div class="mb-1">';
            html += '          <h5 class="text-primary fw-bold mb-0 item-subtotal">' + formatMoney(item.item_subtotal) + '</h5>';
            html += '          <span class="badge bg-secondary">' + Number(item.porcentaje || 0).toFixed(0) + '% OFF</span>';
            html += '      </div>';
            html += '  </div>';
            html += '  <div class="col-auto">';
            html += '      <button onclick="eliminar_carrito_id(' + item.producto_id + ');" class="btn btn-sm btn-outline-danger remove-item-btn" data-item-id="' + item.producto_id + '">';
            html += '          <i class="bi bi-trash"></i>';
            html += '      </button>';
            html += '  </div>';
            html += '</div>';
        });

        $('#lista_carrito_compras_id').html(html);
    }

    function applyCartResponse(response) {
        if (response.status === 'empty') {
            $('#lista_carrito_compras_id').html('');
            $('#cart-subtotal').text(formatMoney(0));
            $('#cart-igv').text(formatMoney(0));
            $('#cart-total').text(formatMoney(0));
            window.location.href = '/';
            return;
        }

        renderCarrito(response.items || []);
        var summary = response.summary || { subtotal: 0, igv: 0, total: 0 };
        $('#cart-subtotal').text(formatMoney(summary.subtotal));
        $('#cart-igv').text(formatMoney(summary.igv));
        $('#cart-total').text(formatMoney(summary.total));
    }

    function eliminar_carrito_id(producto_id){
        $.get('/eliminar_carrito', {id_element_producto: producto_id}, function(response){
            applyCartResponse(response);
        }).fail(function(){
            alert('No se pudo actualizar el carrito. Intenta nuevamente.');
        });
    }
</script>
@endsection
