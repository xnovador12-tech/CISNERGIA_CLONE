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
          <span id="favoriteCount">6</span> productos guardados
        </p>
      </div>
      <div>
        <button class="btn btn-outline-danger" id="clearAllBtn">
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
    <div class="favorite-item" data-product-id="1">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Panel Solar">
        </div>
        <div class="col">
          <div class="product-category mb-2">PANELES SOLARES</div>
          <h3 class="product-title mb-2">Panel Solar Monocristalino 550W</h3>
          <p class="text-muted mb-3">Alta eficiencia 21.5% | Garantía 25 años</p>
          <div class="stock-status available">
            <i class="bi bi-check-circle-fill me-1"></i>Disponible
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 595</div>
          <div class="price-old mb-2">S/ 700</div>
          <div class="discount-badge">-15%</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(1)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-1" readonly>
                <button class="qty-btn" onclick="increaseQty(1)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 20 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(1)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(1)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Producto 2 -->
    <div class="favorite-item" data-product-id="2">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Inversor">
        </div>
        <div class="col">
          <div class="product-category mb-2">INVERSORES</div>
          <h3 class="product-title mb-2">Inversor Híbrido 5kW</h3>
          <p class="text-muted mb-3">On-Grid / Off-Grid | Monitoreo WiFi</p>
          <div class="stock-status available">
            <i class="bi bi-check-circle-fill me-1"></i>Disponible
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 3,500</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(2)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-2" readonly>
                <button class="qty-btn" onclick="increaseQty(2)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 20 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(2)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(2)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Producto 3 -->
    <div class="favorite-item" data-product-id="3">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Batería">
        </div>
        <div class="col">
          <div class="product-category mb-2">BATERÍAS</div>
          <h3 class="product-title mb-2">Batería de Litio 10kWh</h3>
          <p class="text-muted mb-3">6000 ciclos | BMS inteligente</p>
          <div class="stock-status limited">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>Pocas unidades
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 4,400</div>
          <div class="price-old mb-2">S/ 5,500</div>
          <div class="discount-badge">-20%</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(3)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-3" readonly>
                <button class="qty-btn" onclick="increaseQty(3)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 5 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(3)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(3)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Producto 4 -->
    <div class="favorite-item" data-product-id="4">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Estructura">
        </div>
        <div class="col">
          <div class="product-category mb-2">ACCESORIOS</div>
          <h3 class="product-title mb-2">Estructura de Montaje Reforzada</h3>
          <p class="text-muted mb-3">Aluminio anodizado | Para 8 paneles</p>
          <div class="stock-status available">
            <i class="bi bi-check-circle-fill me-1"></i>Disponible
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 850</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(4)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-4" readonly>
                <button class="qty-btn" onclick="increaseQty(4)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 20 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(4)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(4)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Producto 5 -->
    <div class="favorite-item" data-product-id="5">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Regulador">
        </div>
        <div class="col">
          <div class="product-category mb-2">REGULADORES</div>
          <h3 class="product-title mb-2">Regulador de Carga MPPT 60A</h3>
          <p class="text-muted mb-3">Eficiencia 98% | Pantalla LCD</p>
          <div class="stock-status available">
            <i class="bi bi-check-circle-fill me-1"></i>Disponible
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 1,200</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(5)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-5" readonly>
                <button class="qty-btn" onclick="increaseQty(5)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 20 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(5)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(5)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Producto 6 -->
    <div class="favorite-item" data-product-id="6">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=200" 
               class="product-image" alt="Kit Cables">
        </div>
        <div class="col">
          <div class="product-category mb-2">ACCESORIOS</div>
          <h3 class="product-title mb-2">Kit de Cables Solares 6mm²</h3>
          <p class="text-muted mb-3">20 metros | Certificado UV</p>
          <div class="stock-status available">
            <i class="bi bi-check-circle-fill me-1"></i>Disponible
          </div>
        </div>
        <div class="col-lg-auto text-center">
          <div class="price-current mb-1">S/ 350</div>
        </div>
        <div class="col-lg-auto">
          <div class="d-flex flex-column gap-3">
            <div class="text-center">
              <label class="d-block fw-semibold mb-2 text-muted" style="font-size: 0.875rem;">Cantidad</label>
              <div class="qty-control">
                <button class="qty-btn" onclick="decreaseQty(6)">−</button>
                <input type="number" class="qty-input" value="1" min="1" id="qty-6" readonly>
                <button class="qty-btn" onclick="increaseQty(6)">+</button>
              </div>
              <small class="text-muted d-block mt-2">Máx. 20 unidades</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="addToCart(6)" style="white-space: nowrap;">
                <i class="bi bi-cart-plus me-2"></i>Agregar
              </button>
              <button class="action-btn btn-delete" onclick="removeFromFavorites(6)" title="Eliminar de favoritos">
                <i class="bi bi-trash fs-5"></i>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ESTADO VACÍO -->
<section class="empty-state text-center d-none" id="emptyState">
  <div class="container">
    <i class="bi bi-heart"></i>
    <h2 class="fw-bold mt-4 mb-3">Aún no tienes favoritos</h2>
    <p class="text-muted mb-4">
      Empieza a guardar tus productos favoritos para encontrarlos fácilmente después.
    </p>
    <a href="productos.html" class="btn btn-primary btn-lg">
      <i class="bi bi-shop me-2"></i>Explorar Productos
    </a>
  </div>
</section>
@endsection

@section('js')
@endsection