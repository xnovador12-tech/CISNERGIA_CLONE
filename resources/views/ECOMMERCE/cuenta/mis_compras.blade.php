@extends('TEMPLATES.ecommerce')

@section('title', 'MIS COMPRAS')

@section('css')
  <style>
    .order-card {
      transition: all 0.3s ease;
      border-left: 4px solid transparent;
    }
    
    .order-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    
    .order-card.status-delivered {
      border-left-color: var(--bs-success);
    }
    
    .order-card.status-in-transit {
      border-left-color: var(--bs-secondary);
    }
    
    .order-card.status-processing {
      border-left-color: var(--bs-warning);
    }
    
    .order-card.status-cancelled {
      border-left-color: var(--c-danger);
    }
    
    .status-badge {
      font-size: 0.75rem;
      padding: 0.35rem 0.75rem;
      font-weight: 600;
    }
    
    .timeline-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: var(--bs-secondary);
      position: absolute;
      left: -6px;
      top: 5px;
    }
    
    .timeline-line {
      position: absolute;
      left: -1px;
      top: 20px;
      bottom: -10px;
      width: 2px;
      background: var(--c-border);
    }
    
    .product-thumb {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    
    .filter-chip {
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .filter-chip:hover {
      transform: translateY(-2px);
    }
    
    .filter-chip.active {
      background: var(--bs-secondary) !important;
      color: white !important;
    }
    
    .stats-card {
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
      color: white;
      border-radius: 1rem;
    }
    
    .order-details {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    
    .order-details.show {
      max-height: 1000px;
    }
  </style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-5 fw-bold mb-3">Mis Compras</h1>
        <p class="lead text-muted mb-0">
          Gestiona y rastrea todos tus pedidos en un solo lugar
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <div class="d-flex gap-2 justify-content-lg-end">
          <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
            <i class="bi bi-box-seam me-1"></i>5 Pedidos
          </span>
          <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
            <i class="bi bi-check-circle me-1"></i>4 Entregados
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FILTROS Y BÚSQUEDA -->
<section class="py-4 border-bottom">
  <div class="container">
    <div class="row g-3 align-items-center">
      <div class="col-lg-6">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0">
            <i class="bi bi-search text-muted"></i>
          </span>
          <input type="text" class="form-control border-start-0" placeholder="Buscar por número de pedido, producto..." id="searchOrders">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="d-flex gap-2 flex-wrap justify-content-lg-end">
          <span class="badge filter-chip active bg-light text-dark border px-3 py-2" data-filter="all">
            <i class="bi bi-grid me-1"></i>Todos
          </span>
          <span class="badge filter-chip bg-light text-dark border px-3 py-2" data-filter="processing">
            <i class="bi bi-hourglass-split me-1"></i>En proceso
          </span>
          <span class="badge filter-chip bg-light text-dark border px-3 py-2" data-filter="in-transit">
            <i class="bi bi-truck me-1"></i>En tránsito
          </span>
          <span class="badge filter-chip bg-light text-dark border px-3 py-2" data-filter="delivered">
            <i class="bi bi-check-circle me-1"></i>Entregados
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LISTA DE PEDIDOS -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      
      <!-- Pedido 1 - Entregado -->
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-delivered" data-status="delivered">
          <div class="card-body p-4">
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#CS-2025-001234</h5>
                  <span class="badge status-badge bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle-fill me-1"></i>Entregado
                  </span>
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el 28 de noviembre, 2025
                  <span class="mx-2">•</span>
                  <i class="bi bi-box-seam me-1"></i>Entregado el 2 de diciembre, 2025
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ 5,546.00</p>
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('order1')">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <div class="d-flex gap-3 mb-3 flex-wrap">
              <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Panel Solar">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Inversor">
              <div class="d-flex align-items-center">
                <span class="text-muted">+2 productos más</span>
              </div>
            </div>

            <div class="order-details" id="order1">
              <hr class="my-3">
              <div class="row g-3">
                <div class="col-lg-8">
                  <h6 class="fw-bold mb-3">Productos</h6>
                  <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                      <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" 
                           class="product-thumb me-3" alt="Panel Solar">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Panel Solar Monocristalino 550W</h6>
                        <small class="text-muted">Cantidad: 2</small>
                      </div>
                      <div class="text-end">
                        <p class="mb-0 fw-bold">S/ 1,200.00</p>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="d-flex align-items-center">
                      <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                           class="product-thumb me-3" alt="Inversor">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Inversor Híbrido 5kW</h6>
                        <small class="text-muted">Cantidad: 1</small>
                      </div>
                      <div class="text-end">
                        <p class="mb-0 fw-bold">S/ 3,500.00</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <h6 class="fw-bold mb-3">Información de Envío</h6>
                  <p class="mb-1 small text-muted">Dirección</p>
                  <p class="mb-3 small">Av. Principal 123, San Isidro, Lima</p>
                  
                  <h6 class="fw-bold mb-3 mt-4">Acciones</h6>
                  <div class="d-grid gap-2">
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="bi bi-arrow-clockwise me-1"></i>Comprar de nuevo
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-file-earmark-pdf me-1"></i>Descargar factura
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-star me-1"></i>Dejar reseña
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pedido 2 - En tránsito -->
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-in-transit" data-status="in-transit">
          <div class="card-body p-4">
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#CS-2025-001198</h5>
                  <span class="badge status-badge bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-truck me-1"></i>En tránsito
                  </span>
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el 25 de noviembre, 2025
                  <span class="mx-2">•</span>
                  <i class="bi bi-box-seam me-1"></i>Entrega estimada: 4 de diciembre, 2025
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ 2,850.00</p>
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('order2')">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <div class="d-flex gap-3 mb-3">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Batería">
            </div>

            <!-- Timeline de seguimiento -->
            <div class="mt-3">
              <div class="alert alert-info border-0 d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>
                  <strong>Tu pedido está en camino</strong>
                  <p class="mb-0 small">Última actualización: Lima, Centro de Distribución - 2 de diciembre, 10:30 AM</p>
                </div>
              </div>
            </div>

            <div class="order-details" id="order2">
              <hr class="my-3">
              <div class="row">
                <div class="col-lg-8">
                  <h6 class="fw-bold mb-3">Seguimiento del pedido</h6>
                  <div class="position-relative ps-4">
                    <div class="mb-4 position-relative">
                      <div class="timeline-dot" style="background: var(--bs-success);"></div>
                      <div class="timeline-line"></div>
                      <h6 class="mb-1 small fw-bold">Pedido confirmado</h6>
                      <p class="mb-0 text-muted small">25 de nov, 2025 - 2:30 PM</p>
                    </div>
                    <div class="mb-4 position-relative">
                      <div class="timeline-dot" style="background: var(--bs-success);"></div>
                      <div class="timeline-line"></div>
                      <h6 class="mb-1 small fw-bold">En preparación</h6>
                      <p class="mb-0 text-muted small">26 de nov, 2025 - 9:00 AM</p>
                    </div>
                    <div class="mb-4 position-relative">
                      <div class="timeline-dot" style="background: var(--bs-secondary);"></div>
                      <div class="timeline-line"></div>
                      <h6 class="mb-1 small fw-bold">En tránsito</h6>
                      <p class="mb-0 text-muted small">2 de dic, 2025 - 10:30 AM</p>
                    </div>
                    <div class="position-relative">
                      <div class="timeline-dot" style="background: var(--c-border);"></div>
                      <h6 class="mb-1 small text-muted">Entrega programada</h6>
                      <p class="mb-0 text-muted small">4 de dic, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <h6 class="fw-bold mb-3">Acciones</h6>
                  <div class="d-grid gap-2">
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="bi bi-geo-alt me-1"></i>Rastrear envío
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-x-circle me-1"></i>Cancelar pedido
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pedido 3 - En proceso -->
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-processing" data-status="processing">
          <div class="card-body p-4">
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#CS-2025-001156</h5>
                  <span class="badge status-badge bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-hourglass-split me-1"></i>En preparación
                  </span>
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el 1 de diciembre, 2025
                  <span class="mx-2">•</span>
                  <i class="bi bi-clock me-1"></i>Procesando
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ 1,450.00</p>
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('order3')">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <div class="d-flex gap-3">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Kit cables">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Estructura">
            </div>

            <div class="order-details" id="order3">
              <hr class="my-3">
              <p class="text-muted small">Tu pedido está siendo preparado y será enviado pronto. Te notificaremos cuando esté en camino.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pedido 4 - Entregado -->
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-delivered" data-status="delivered">
          <div class="card-body p-4">
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#CS-2025-001089</h5>
                  <span class="badge status-badge bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle-fill me-1"></i>Entregado
                  </span>
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el 15 de noviembre, 2025
                  <span class="mx-2">•</span>
                  <i class="bi bi-box-seam me-1"></i>Entregado el 20 de noviembre, 2025
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ 8,200.00</p>
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('order4')">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <div class="d-flex gap-3">
              <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Panel Solar">
              <div class="d-flex align-items-center">
                <span class="text-muted">Kit completo instalación</span>
              </div>
            </div>

            <div class="order-details" id="order4">
              <hr class="my-3">
              <div class="alert alert-success border-0">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Entrega completada.</strong> ¿Qué te pareció tu compra? 
                <a href="#" class="alert-link">Deja una reseña</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pedido 5 - Entregado -->
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-delivered" data-status="delivered">
          <div class="card-body p-4">
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#CS-2025-000987</h5>
                  <span class="badge status-badge bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle-fill me-1"></i>Entregado
                  </span>
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el 5 de noviembre, 2025
                  <span class="mx-2">•</span>
                  <i class="bi bi-box-seam me-1"></i>Entregado el 8 de noviembre, 2025
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ 650.00</p>
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('order5')">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <div class="d-flex gap-3">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="product-thumb" alt="Accesorios">
            </div>

            <div class="order-details" id="order5">
              <hr class="my-3">
              <p class="text-muted small">Pedido entregado exitosamente.</p>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Sin resultados -->
    <div class="text-center py-5 d-none" id="noResults">
      <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
      <h4 class="mt-3 text-muted">No se encontraron pedidos</h4>
      <p class="text-muted">Intenta con otros filtros o realiza tu primera compra</p>
      <a href="productos.html" class="btn btn-primary mt-3">
        <i class="bi bi-shop me-2"></i>Ir a la tienda
      </a>
    </div>
  </div>
</section>

<!-- Estadísticas de usuario -->
<section class="py-5 bg-light">
  <div class="container">
    <h3 class="fw-bold mb-4">Resumen de Compras</h3>
    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
              <i class="bi bi-box-seam text-primary fs-2"></i>
            </div>
            <h2 class="fw-bold mb-1">5</h2>
            <p class="text-muted mb-0">Pedidos Totales</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
              <i class="bi bi-check-circle text-success fs-2"></i>
            </div>
            <h2 class="fw-bold mb-1">4</h2>
            <p class="text-muted mb-0">Entregados</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
              <i class="bi bi-currency-dollar text-warning fs-2"></i>
            </div>
            <h2 class="fw-bold mb-1">S/ 18,696</h2>
            <p class="text-muted mb-0">Total Invertido</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
              <i class="bi bi-star text-info fs-2"></i>
            </div>
            <h2 class="fw-bold mb-1">4.8</h2>
            <p class="text-muted mb-0">Calificación Promedio</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
@endsection