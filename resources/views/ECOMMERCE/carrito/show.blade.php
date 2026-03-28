@extends('TEMPLATES.ecommerce')

@section('title', $producto->name)

@section('css')
<style>
    .thumbnail-btn {
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }
    .thumbnail-btn.active {
        border-color: var(--bs-secondary) !important;
        border-width: 2px !important;
    }
    .thumbnail-btn:hover {
        border-color: var(--bs-secondary) !important;
    }
</style>
@endsection

@section('content')
<!-- BREADCRUMB -->
<section class="py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.products') }}" class="text-decoration-none">Productos</a></li>
                @if($producto->categorie)
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.products', ['categoria' => $producto->categoria_id]) }}" class="text-decoration-none">{{ $producto->categorie->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $producto->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- PRODUCT DETAIL -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- GALERÍA DE IMÁGENES -->
            <div class="col-lg-5">
                <div class="sticky-top" style="top: 20px;">
                    <!-- Imagen principal -->
                    <div class="card border shadow-sm mb-3 overflow-hidden">
                        <div class="position-relative" style="height: 450px;">
                            <img id="mainImage" src="{{ asset($producto->imagen ?? 'images/no-image.png') }}" 
                                 class="w-100 h-100 object-fit-contain p-4 bg-white" alt="{{ $producto->name }}">
                            <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-3 rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                            @if($producto->estado == 1)
                            <span class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-success">En Stock</span>
                            </span>
                            @endif
                            @if($producto->precio_descuento)
                            <span class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-danger">
                                    -{{ number_format((($producto->precio - $producto->precio_descuento) / $producto->precio) * 100, 0) }}% OFF
                                </span>
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Características destacadas -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-shield-check text-success me-2"></i>Garantías y Características</h6>
                            <ul class="list-unstyled mb-0 small">
                                @if($producto->tipo)
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Tipo: {{ $producto->tipo->name }}</li>
                                @endif
                                @if($producto->marca)
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Marca: {{ $producto->marca->name }}</li>
                                @endif
                                @if($producto->peso)
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Peso: {{ $producto->peso }} kg</li>
                                @endif
                                @if($producto->vida_util)
                                <li class="mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Vida útil: {{ $producto->vida_util }} años</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN DEL PRODUCTO -->
            <div class="col-lg-7">
                <!-- Marca -->
                @if($producto->marca)
                <div class="mb-3">
                    <span class="badge bg-light text-dark border">{{ $producto->marca->name }}</span>
                </div>
                @endif

                <!-- Título -->
                <h1 class="fw-bold mb-3 h2">{{ $producto->name }}</h1>

                <!-- Código -->
                <p class="text-muted mb-3">
                    <small>Código: <span class="fw-bold text-dark">{{ $producto->codigo }}</span></small>
                </p>

                <!-- Rating -->
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-muted small">(4.5) 128 reseñas</span>
                </div>

                <!-- Precio -->
                <div class="card border-0 bg-light mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            @if($producto->precio_descuento)
                            <small class="text-muted text-decoration-line-through d-block mb-1">S/ {{ number_format($producto->precio, 2) }}</small>
                            <h2 class="text-primary fw-bold mb-0">S/ {{ number_format($producto->precio_descuento, 2) }}</h2>
                            <small class="text-success">¡Ahorra S/ {{ number_format($producto->precio - $producto->precio_descuento, 2) }}!</small>
                            @else
                            <h2 class="text-primary fw-bold mb-0">S/ {{ number_format($producto->precio, 2) }}</h2>
                            @endif
                            <p class="text-muted small mb-0 mt-2">
                                <i class="bi bi-truck me-1"></i>Envío gratis a todo el Perú
                            </p>
                        </div>
                        <div class="col-md-5">
                            <div class="text-center p-3 bg-white rounded">
                                <p class="text-muted small mb-1">Stock disponible</p>
                                <p class="fw-bold mb-0 text-success">{{ $producto->estado ? 'Disponible' : 'Agotado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cantidad y Agregar al Carrito -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <form id="addToCartForm">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Cantidad:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decrementBtn">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" name="cantidad" id="cantidad" value="1" min="1" max="100">
                                    <button class="btn btn-outline-secondary" type="button" id="incrementBtn">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                    <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="row g-2 mt-3">
                        <div class="col-md-6">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="bi bi-heart me-2"></i>Agregar a favoritos
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="bi bi-share me-2"></i>Compartir
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-shield-check text-primary fs-3 mb-2"></i>
                            <p class="small mb-0 fw-semibold">Compra Protegida</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-truck text-primary fs-3 mb-2"></i>
                            <p class="small mb-0 fw-semibold">Envío Gratis</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-arrow-return-left text-primary fs-3 mb-2"></i>
                            <p class="small mb-0 fw-semibold">30 días de garantía</p>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Descripción del producto</h5>
                        <p class="text-muted">{{ $producto->descripcion ?? 'Sin descripción disponible' }}</p>
                        
                        @if($producto->tipo_material || $producto->vida_util || $producto->medida)
                        <h6 class="fw-bold mt-4 mb-3">Especificaciones técnicas</h6>
                        <ul class="list-unstyled">
                            @if($producto->tipo_material)
                            <li class="mb-2"><strong>Material:</strong> {{ $producto->tipo_material }}</li>
                            @endif
                            @if($producto->vida_util)
                            <li class="mb-2"><strong>Vida útil:</strong> {{ $producto->vida_util }} años</li>
                            @endif
                            @if($producto->medida)
                            <li class="mb-2"><strong>Unidad de medida:</strong> {{ $producto->medida->name }}</li>
                            @endif
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Relacionados -->
        @if($relacionados->count() > 0)
        <div class="mt-5">
            <h3 class="fw-bold mb-4">Productos Relacionados</h3>
            <div class="row g-4">
                @foreach($relacionados as $relacionado)
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative" style="height: 200px;">
                            <img src="{{ asset($relacionado->imagen ?? 'images/no-image.png') }}" 
                                 class="w-100 h-100 object-fit-contain p-3" alt="{{ $relacionado->name }}">
                            @if($relacionado->precio_descuento)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ number_format((($relacionado->precio - $relacionado->precio_descuento) / $relacionado->precio) * 100, 0) }}%
                            </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ Str::limit($relacionado->name, 50) }}</h6>
                            @if($relacionado->precio_descuento)
                            <small class="text-muted text-decoration-line-through d-block">S/ {{ number_format($relacionado->precio, 2) }}</small>
                            <p class="text-primary fw-bold mb-3">S/ {{ number_format($relacionado->precio_descuento, 2) }}</p>
                            @else
                            <p class="text-primary fw-bold mb-3">S/ {{ number_format($relacionado->precio, 2) }}</p>
                            @endif
                            <a href="{{ route('ecommerce.product.show', $relacionado->slug) }}" class="btn btn-outline-primary btn-sm w-100">
                                Ver producto
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('js')
<script>
    // Control de cantidad
    document.getElementById('decrementBtn').addEventListener('click', function() {
        let input = document.getElementById('cantidad');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });

    document.getElementById('incrementBtn').addEventListener('click', function() {
        let input = document.getElementById('cantidad');
        if (input.value < 100) {
            input.value = parseInt(input.value) + 1;
        }
    });

    // Agregar al carrito
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let btn = document.getElementById('addToCartBtn');
        let originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Agregando...';

        let formData = new FormData(this);

        fetch('{{ route("ecommerce.cart.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar contador del carrito
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cart_count;
                });

                // Mostrar mensaje de éxito
                btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>¡Agregado!';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                    btn.disabled = false;
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Error al agregar al carrito. Intenta nuevamente.');
        });
    });
</script>
@endsection
