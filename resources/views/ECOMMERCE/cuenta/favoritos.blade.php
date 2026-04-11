@extends('TEMPLATES.ecommerce')

@section('title', 'FAVORITOS')

@section('css')
  <style>
    .favorite-item {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, var(--c-surface) 0%, var(--c-bg) 100%);
      border-radius: 16px;
      padding: 1.75rem;
      margin-bottom: 1.25rem;
      border: 1px solid var(--c-border);
      position: relative;
      overflow: hidden;
    }
    
    .favorite-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, var(--bs-secondary) 0%, var(--bs-primary) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .favorite-item:hover {
      box-shadow: 0 8px 24px rgba(var(--bs-secondary-rgb), 0.12);
      border-color: var(--bs-secondary);
      transform: translateY(-2px);
    }
    
    .favorite-item:hover::before {
      opacity: 1;
    }
    
    .product-image {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--c-bg) 0%, var(--c-border) 100%);
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      transition: transform 0.3s ease;
    }
    
    .favorite-item:hover .product-image {
      transform: scale(1.05);
    }
    
    .product-title {
      font-size: 1rem;
      font-weight: 600;
      color: var(--c-text);
      margin-bottom: 0.25rem;
    }
    
    .product-category {
      font-size: 0.75rem;
      color: var(--c-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .price-current {
      font-size: 1.75rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--bs-secondary) 0%, var(--bs-primary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .price-old {
      font-size: 1rem;
      color: var(--c-muted);
      text-decoration: line-through;
      font-weight: 500;
    }
    
    .discount-badge {
      display: inline-block;
      background: linear-gradient(135deg, var(--c-danger) 0%, var(--bs-danger) 100%);
      color: white;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: 700;
      box-shadow: 0 2px 8px rgba(var(--c-danger-rgb), 0.3);
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    
    .stock-status {
      font-size: 0.875rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      background: rgba(0,0,0,0.02);
    }
    
    .stock-status.available {
      color: var(--bs-success);
      background: rgba(var(--bs-success-rgb), 0.08);
      border: 1px solid rgba(var(--bs-success-rgb), 0.2);
    }
    
    .stock-status.limited {
      color: var(--bs-warning);
      background: rgba(var(--bs-warning-rgb), 0.08);
      border: 1px solid rgba(var(--bs-warning-rgb), 0.2);
      animation: blink 2s infinite;
    }
    
    .stock-status.unavailable {
      color: var(--c-danger);
      background: rgba(var(--c-danger-rgb), 0.08);
      border: 1px solid rgba(var(--c-danger-rgb), 0.2);
    }
    
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    
    .qty-control {
      display: inline-flex;
      align-items: center;
      background: var(--c-bg);
      border: 2px solid var(--c-border);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .qty-btn {
      width: 40px;
      height: 40px;
      border: none;
      background: transparent;
      color: var(--bs-secondary);
      cursor: pointer;
      transition: all 0.2s;
      font-size: 1.3rem;
      font-weight: 700;
    }
    
    .qty-btn:hover {
      background: var(--bs-secondary);
      color: white;
    }
    
    .qty-btn:active {
      transform: scale(0.95);
    }
    
    .qty-input {
      width: 60px;
      height: 40px;
      border: none;
      text-align: center;
      font-weight: 700;
      font-size: 1.1rem;
      background: transparent;
      color: var(--c-text);
    }
    
    .qty-input:focus {
      outline: none;
    }
    
    .action-btn {
      background: none;
      border: none;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 0.625rem;
      border-radius: 10px;
    }
    
    .btn-delete {
      color: var(--c-danger);
      background: rgba(var(--c-danger-rgb), 0.05);
    }
    
    .btn-delete:hover {
      color: white;
      background: linear-gradient(135deg, var(--c-danger) 0%, var(--bs-danger) 100%);
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 4px 12px rgba(var(--c-danger-rgb), 0.3);
    }
    
    .btn-similar {
      color: var(--c-muted);
      font-size: 0.875rem;
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      transition: all 0.2s;
      display: inline-block;
    }
    
    .btn-similar:hover {
      color: var(--bs-secondary);
      background: rgba(var(--bs-secondary-rgb), 0.05);
      text-decoration: none;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--bs-secondary) 0%, var(--bs-primary) 100%) !important;
      border: none !important;
      padding: 0.75rem 1.5rem !important;
      font-weight: 600 !important;
      border-radius: 12px !important;
      box-shadow: 0 4px 16px rgba(var(--bs-secondary-rgb), 0.3) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 24px rgba(var(--bs-secondary-rgb), 0.4) !important;
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .empty-state {
      padding: 5rem 2rem;
      text-align: center;
    }
    
    .empty-state i {
      font-size: 6rem;
      color: var(--c-border);
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .favorite-item {
      animation: fadeIn 0.3s ease-out;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
  </style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="py-4 bg-white border-bottom">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h2 class="fw-bold mb-2">
          <i class="bi bi-heart-fill text-danger me-2"></i>Mis favoritos
        </h2>
        <p class="text-muted mb-0">
          <span id="favoriteCount">{{ $favoritos->count() }}</span> productos guardados
        </p>
      </div>
      <div>
        <button onclick="eliminartodofavoritos()" class="btn btn-outline-danger" id="clearAllBtn">
          <i class="bi bi-trash me-2"></i>Limpiar todo
        </button>
      </div>
    </div>
  </div>
</section>

<!-- LISTA DE PRODUCTOS FAVORITOS -->
<section class="py-4" id="favoritesGrid">
  <div class="container">
    
    <!-- Producto 1 -->
    @forelse($favoritos as $favorito)
    <div class="favorite-item" data-product-id="{{ $favorito->producto->id }}">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="{{ $favorito->producto->imagen ? asset('images/productos/' . $favorito->producto->imagen) : asset('images/logo.webp') }}" 
               class="product-image" alt="{{ $favorito->producto->name }}">
        </div>
        <div class="col">
          <div class="product-category mb-2">{{ $favorito->producto->categoria->name ?? 'Sin categoría' }}</div>
          <h3 class="product-title mb-2">{{ $favorito->producto->name }}</h3>
          <p class="text-muted mb-3">{{ $favorito->producto->descripcion }}</p>
          @if($favorito->producto->inventarios->sum('cantidad') > 5)
            <div class="stock-status available">
              <i class="bi bi-check-circle-fill me-1"></i>Disponible
            </div>
          @else
          <div class="stock-status available">
              <i class="bi bi-exclamation-triangle-fill me-1"></i>Pocas unidades
            </div>
          @endif
        </div>
        <div class="col-lg-auto text-center">
          @if($favorito->producto->precio_descuento == '' || $favorito->producto->precio_descuento == 0)
            <div class="price-current mb-1">S/ {{ number_format($favorito->producto->precio, 2) }}</div>
          @else
            <div class="price-current mb-1">S/ {{ number_format($favorito->producto->precio_descuento, 2) }}</div>
            <div class="price-old mb-2">S/ {{ number_format($favorito->producto->precio, 2) }}</div>
            <div class="discount-badge">
              - {{ $favorito->producto->porcentaje}}%
            </div>
          @endif
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="btn btn-sm btn-outline-secondary decrement-btn" type="button" data-item-id="{{ $favorito->producto->id }}">
                    <i class="bi bi-dash"></i>
                </button>
                <input type="number" class="form-control form-control-sm text-center cantidad-input" 
                        value="1" min="1" id="cantidad-{{ $favorito->producto->id }}" data-item-id="{{ $favorito->producto->id }}" readonly>
                <button class="btn btn-sm btn-outline-secondary increment-btn" type="button" data-item-id="{{ $favorito->producto->id }}">
                    <i class="bi bi-plus"></i>
                </button>
              </div>
              <small class="text-muted d-block mt-2">Máx. {{ $favorito->producto->inventarios->sum('cantidad') > 1 ? $favorito->producto->inventarios->sum('cantidad').' unidades disponibles' : $favorito->producto->inventarios->sum('cantidad').' unidad disponible'}}</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="agregar_carrito_idfavorito({{ $favorito->producto->id }})" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="eliminar_lista_id({{$favorito->producto->id}});" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    @empty
      <div class="empty-state text-center">
        <i class="bi bi-heart"></i>
        <h2 class="fw-bold mt-4 mb-3">Aún no tienes favoritos</h2>
        <p class="text-muted mb-4">
          Empieza a guardar tus productos favoritos para encontrarlos fácilmente después.
        </p>
        <a href="/products" class="btn btn-primary btn-lg">
          <i class="bi bi-shop me-2"></i>Explorar Productos
        </a>
      </div>
    @endforelse
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
            var max = parseInt(input.getAttribute('max') || '999', 10);
            var newCantidad = parseInt(input.value || '1', 10) + 1;
            if (newCantidad <= max) {
                input.value = newCantidad;
            }
        });
    });

    // Decrementar cantidad
    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            var itemId = this.dataset.itemId;
            var input = document.querySelector('.cantidad-input[data-item-id="' + itemId + '"]');
            var newCantidad = parseInt(input.value || '1', 10) - 1;
            if (newCantidad >= 1) {
                input.value = newCantidad;
            }
        });
    });
</script>
@endsection