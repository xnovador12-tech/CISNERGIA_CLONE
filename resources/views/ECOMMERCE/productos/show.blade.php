@extends('TEMPLATES.ecommerce')

@section('title', 'Catálogo de Productos Solares')

@section('css')
    <style>
    .thumbnail-btn {
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }
    .thumbnail-btn:hover,
    .thumbnail-btn.active {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
    }
    .hover-bg:hover {
        background: rgba(0,0,0,0.05) !important;
    }
    </style>
@endsection

@section('content')
<!-- BREADCRUMB -->
<section class="py-3 bg-light border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Productos</a></li>
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inversores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sungrow SH8.0RT</li>
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
              <img id="mainImage" src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=800" 
                   class="w-100 h-100 object-fit-contain p-4 bg-white" alt="Sungrow SH8.0RT">
              <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-3 rounded-circle">
                <i class="bi bi-heart"></i>
              </button>
              <span class="position-absolute top-0 start-0 m-3">
                <span class="badge bg-success">En Stock</span>
              </span>
            </div>
          </div>
          
          <!-- Miniaturas -->
          <div class="d-flex gap-2">
            <button class="border rounded p-2 thumbnail-btn active" onclick="changeImage(this, 'https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="d-block" style="width: 80px; height: 80px; object-fit: contain;" alt="Vista 1">
            </button>
            <button class="border rounded p-2 thumbnail-btn" onclick="changeImage(this, 'https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="d-block" style="width: 80px; height: 80px; object-fit: contain;" alt="Vista 2">
            </button>
            <button class="border rounded p-2 thumbnail-btn" onclick="changeImage(this, 'https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" 
                   class="d-block" style="width: 80px; height: 80px; object-fit: contain;" alt="Vista 3">
            </button>
          </div>

          <!-- Características destacadas -->
          <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
              <h6 class="fw-bold mb-3"><i class="bi bi-shield-check text-success me-2"></i>Garantías</h6>
              <ul class="list-unstyled mb-0 small">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>10 años de garantía del producto</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Eficiencia hasta 97.9%</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Certificación internacional</li>
                <li class="mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte técnico especializado</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- INFORMACIÓN DEL PRODUCTO -->
      <div class="col-lg-7">
        <!-- Marca -->
        <div class="mb-3">
          <a href="#" class="text-decoration-none">
            <img src="https://via.placeholder.com/120x40/0066CC/FFFFFF?text=SUNGROW" alt="Sungrow_Marca" height="30">
          </a>
        </div>

        <!-- Título -->
        <h1 class="fw-bold mb-3">Sungrow SH8.0RT Inversor Híbrido 8 KW 3 Fases 2 MPPT</h1>
        
        <!-- Valoraciones -->
        <div class="d-flex align-items-center gap-2 mb-4">
          <div class="d-flex align-items-center">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <span class="ms-2 fw-bold">5.0</span>
          </div>
          <span class="text-muted">|</span>
          <a href="#reviews" class="text-decoration-none small">(5 valoraciones)</a>
          <span class="text-muted">|</span>
          <span class="text-success small"><i class="bi bi-check-circle-fill me-1"></i>En stock</span>
        </div>

        <!-- Precio -->
        <div class="card border-0 bg-light mb-4 p-4">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="mb-2">
                <span class="text-muted text-decoration-line-through h5">S/ 4,899</span>
                <span class="badge bg-danger ms-2">-18% OFF</span>
              </div>
              <h2 class="text-danger fw-bold mb-1">S/ 4,015</h2>
              <small class="text-muted">Precio por unidad + IGV</small>
            </div>
            <div class="col-md-6">
              <div class="d-flex gap-2">
                <button class="btn btn-primary btn-lg flex-fill">
                  <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                </button>
                <button class="btn btn-outline-primary btn-lg">
                  <i class="bi bi-heart"></i>
                </button>
              </div>
              <button class="btn btn-outline-secondary w-100 mt-2">
                <i class="bi bi-chat-dots me-2"></i>Consultar disponibilidad
              </button>
            </div>
          </div>
        </div>

        <!-- Descripción corta -->
        <div class="mb-4">
          <p class="lead text-muted">
            El inversor híbrido SH8.0RT de Sungrow refleja un impresionante índice de eficiencia de hasta el 97,9%, 
            lo que lo convierte en una opción ideal para su próximo proyecto solar.
          </p>
        </div>

        <!-- Características principales -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3">
            <div class="card border text-center h-100">
              <div class="card-body p-3">
                <i class="bi bi-lightning-charge-fill text-primary fs-3 mb-2"></i>
                <div class="small fw-bold">Potencia DC</div>
                <div class="text-muted small">12.0 kW</div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border text-center h-100">
              <div class="card-body p-3">
                <i class="bi bi-cpu-fill text-success fs-3 mb-2"></i>
                <div class="small fw-bold">Potencia AC</div>
                <div class="text-muted small">8.0 kW</div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border text-center h-100">
              <div class="card-body p-3">
                <i class="bi bi-diagram-3-fill text-warning fs-3 mb-2"></i>
                <div class="small fw-bold">MPPT</div>
                <div class="text-muted small">2 Unidades</div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border text-center h-100">
              <div class="card-body p-3">
                <i class="bi bi-speedometer2 text-info fs-3 mb-2"></i>
                <div class="small fw-bold">Eficiencia</div>
                <div class="text-muted small">97.9%</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Badges informativos -->
        <div class="d-flex flex-wrap gap-2 mb-4">
          <span class="badge bg-light text-dark border p-2">
            <i class="bi bi-shield-check text-success me-1"></i>10 años de garantía
          </span>
          <span class="badge bg-light text-dark border p-2">
            <i class="bi bi-award text-primary me-1"></i>Certificado internacional
          </span>
          <span class="badge bg-light text-dark border p-2">
            <i class="bi bi-truck text-info me-1"></i>Envío disponible
          </span>
          <span class="badge bg-light text-dark border p-2">
            <i class="bi bi-tools text-warning me-1"></i>Instalación profesional
          </span>
        </div>

        <!-- Tabs de información -->
        <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
              Descripción
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button">
              Especificaciones
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="dimensions-tab" data-bs-toggle="tab" data-bs-target="#dimensions" type="button">
              Dimensiones
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="downloads-tab" data-bs-toggle="tab" data-bs-target="#downloads" type="button">
              Descargas
            </button>
          </li>
        </ul>

        <div class="tab-content" id="productTabsContent">
          <!-- Descripción -->
          <div class="tab-pane fade show active" id="description" role="tabpanel">
            <h5 class="fw-bold mb-3">Descripción del Producto</h5>
            <p class="text-muted mb-3">
              El inversor híbrido SH8.0RT de Sungrow es una solución avanzada para sistemas solares fotovoltaicos 
              con almacenamiento de energía. Este dispositivo de última generación combina la funcionalidad de un 
              inversor solar con un cargador de baterías, permitiendo maximizar el autoconsumo y la independencia energética.
            </p>
            <p class="text-muted mb-3">
              Con una eficiencia máxima del 97.9%, el SH8.0RT garantiza un rendimiento óptimo en la conversión de energía. 
              Su diseño trifásico y 2 seguidores de punto de máxima potencia (MPPT) permiten una instalación flexible 
              y un aprovechamiento óptimo de la energía solar en diferentes orientaciones del tejado.
            </p>
            <h6 class="fw-bold mb-2">Características destacadas:</h6>
            <ul class="text-muted">
              <li>Inversor híbrido trifásico de alta eficiencia (97.9%)</li>
              <li>Potencia nominal de salida: 8.0 kW</li>
              <li>Potencia máxima de entrada DC: 12.0 kW</li>
              <li>Compatible con baterías de alta tensión</li>
              <li>Monitoreo remoto vía WiFi/Ethernet</li>
              <li>Protecciones integradas contra sobretensión y cortocircuito</li>
              <li>Diseño compacto y ligero (27 kg)</li>
              <li>Instalación sencilla con conector plug-and-play</li>
            </ul>
          </div>

          <!-- Especificaciones -->
          <div class="tab-pane fade" id="specs" role="tabpanel">
            <h5 class="fw-bold mb-3">Datos de Rendimiento</h5>
            
            <h6 class="fw-bold text-primary mb-3">DC (Entrada)</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <tbody>
                  <tr>
                    <td class="fw-semibold bg-light">Potencia máxima</td>
                    <td>12.0 kW</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Corriente máxima</td>
                    <td>25.0 A</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Tensión nominal</td>
                    <td>600 V</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Tensión máxima</td>
                    <td>1,000 V</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Número de MPPT</td>
                    <td>2</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Entradas de cadena</td>
                    <td>2</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <h6 class="fw-bold text-success mb-3 mt-4">AC (Salida)</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <tbody>
                  <tr>
                    <td class="fw-semibold bg-light">Potencia nominal</td>
                    <td>8.0 kW</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Potencia máxima</td>
                    <td>8.0 kW</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Corriente nominal</td>
                    <td>11.6 A</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Corriente máxima</td>
                    <td>12.1 A</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Fases</td>
                    <td>3 Fases</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Eficiencia máxima</td>
                    <td>97.9%</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Dimensiones -->
          <div class="tab-pane fade" id="dimensions" role="tabpanel">
            <h5 class="fw-bold mb-3">Dimensiones y Peso</h5>
            <div class="table-responsive">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td class="fw-semibold bg-light" style="width: 40%;">Ancho</td>
                    <td>460 mm</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Alto</td>
                    <td>540 mm</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Profundidad</td>
                    <td>170 mm</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Peso</td>
                    <td>27 kg</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Grado de protección</td>
                    <td>IP65 (uso exterior)</td>
                  </tr>
                  <tr>
                    <td class="fw-semibold bg-light">Rango de temperatura</td>
                    <td>-25°C a +60°C</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="alert alert-info d-flex align-items-center mt-4">
              <i class="bi bi-info-circle-fill fs-4 me-3"></i>
              <div>
                <strong>Nota:</strong> Se recomienda instalación en área protegida de la lluvia directa 
                y con ventilación adecuada para garantizar el rendimiento óptimo.
              </div>
            </div>
          </div>

          <!-- Descargas -->
          <div class="tab-pane fade" id="downloads" role="tabpanel">
            <h5 class="fw-bold mb-3">Documentación Técnica</h5>
            <div class="list-group">
              <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-file-earmark-pdf text-danger fs-4 me-3"></i>
                  <span class="fw-semibold">Ficha Técnica</span>
                  <small class="text-muted d-block ms-5 ps-2">Especificaciones completas del producto</small>
                </div>
                <i class="bi bi-download"></i>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-file-earmark-pdf text-danger fs-4 me-3"></i>
                  <span class="fw-semibold">Manual de Instalación</span>
                  <small class="text-muted d-block ms-5 ps-2">Guía paso a paso para la instalación</small>
                </div>
                <i class="bi bi-download"></i>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-file-earmark-pdf text-danger fs-4 me-3"></i>
                  <span class="fw-semibold">Manual de Usuario</span>
                  <small class="text-muted d-block ms-5 ps-2">Instrucciones de uso y mantenimiento</small>
                </div>
                <i class="bi bi-download"></i>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-file-earmark-text text-primary fs-4 me-3"></i>
                  <span class="fw-semibold">Certificados</span>
                  <small class="text-muted d-block ms-5 ps-2">Certificaciones internacionales</small>
                </div>
                <i class="bi bi-download"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- REVIEWS -->
<section class="py-5 bg-light" id="reviews">
  <div class="container">
    <h3 class="fw-bold mb-4">Opiniones de Clientes</h3>
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body text-center p-4">
            <h1 class="display-3 fw-bold text-primary mb-2">5.0</h1>
            <div class="mb-2">
              <i class="bi bi-star-fill text-warning fs-5"></i>
              <i class="bi bi-star-fill text-warning fs-5"></i>
              <i class="bi bi-star-fill text-warning fs-5"></i>
              <i class="bi bi-star-fill text-warning fs-5"></i>
              <i class="bi bi-star-fill text-warning fs-5"></i>
            </div>
            <p class="text-muted mb-0">Basado en 5 valoraciones</p>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="mb-1">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <h6 class="fw-bold mb-1">Excelente inversor híbrido</h6>
                <small class="text-muted">Por Juan Pérez - 15 Nov 2025</small>
              </div>
            </div>
            <p class="text-muted mb-0">
              Muy satisfecho con la compra. El inversor funciona perfectamente y la eficiencia es excelente. 
              La instalación fue sencilla y el monitoreo remoto funciona muy bien.
            </p>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="mb-1">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <h6 class="fw-bold mb-1">Calidad premium</h6>
                <small class="text-muted">Por María García - 8 Nov 2025</small>
              </div>
            </div>
            <p class="text-muted mb-0">
              Producto de primera calidad. La marca Sungrow es confiable y este modelo cumple todas las expectativas. 
              Altamente recomendado para proyectos residenciales.
            </p>
          </div>
        </div>

        <button class="btn btn-outline-primary w-100">
          <i class="bi bi-chat-dots me-2"></i>Escribir una opinión
        </button>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCTOS RELACIONADOS -->
<section class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold mb-0">Los clientes que vieron este artículo también vieron…</h3>
      <a href="#" class="btn btn-outline-primary btn-sm">Ver todos</a>
    </div>

    <div class="row g-4">
      <!-- Producto relacionado 1 -->
      <div class="col-lg-3 col-md-6">
        <div class="card product-card h-100 border shadow-sm">
          <div class="position-relative overflow-hidden" style="height: 220px;">
            <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400" 
                 class="w-100 h-100 object-fit-cover" alt="Inversor">
            <button class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
              <i class="bi bi-heart"></i>
            </button>
          </div>
          <div class="card-body d-flex flex-column">
            <small class="text-muted">SUNGROW</small>
            <h6 class="fw-bold mb-2" style="min-height: 48px;">Sungrow SH10RT-20</h6>
            <div class="mb-2">
              <span class="badge bg-light text-dark border me-1"><i class="bi bi-cpu"></i> 10kW</span>
            </div>
            <div class="mt-auto">
              <h5 class="text-danger fw-bold mb-2">S/ 5,250</h5>
              <button class="btn btn-primary w-100 btn-sm">
                <i class="bi bi-cart-plus me-1"></i>Agregar
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 2 -->
      <div class="col-lg-3 col-md-6">
        <div class="card product-card h-100 border shadow-sm">
          <div class="position-relative overflow-hidden" style="height: 220px;">
            <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400" 
                 class="w-100 h-100 object-fit-cover" alt="Inversor">
            <button class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
              <i class="bi bi-heart"></i>
            </button>
          </div>
          <div class="card-body d-flex flex-column">
            <small class="text-muted">SUNGROW</small>
            <h6 class="fw-bold mb-2" style="min-height: 48px;">Sungrow SG10RT</h6>
            <div class="mb-2">
              <span class="badge bg-light text-dark border me-1"><i class="bi bi-cpu"></i> 10kW</span>
            </div>
            <div class="mt-auto">
              <h5 class="text-danger fw-bold mb-2">S/ 4,890</h5>
              <button class="btn btn-primary w-100 btn-sm">
                <i class="bi bi-cart-plus me-1"></i>Agregar
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 3 -->
      <div class="col-lg-3 col-md-6">
        <div class="card product-card h-100 border shadow-sm">
          <div class="position-relative overflow-hidden" style="height: 220px;">
            <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400" 
                 class="w-100 h-100 object-fit-cover" alt="Inversor">
            <button class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
              <i class="bi bi-heart"></i>
            </button>
          </div>
          <div class="card-body d-flex flex-column">
            <small class="text-muted">SUNGROW</small>
            <h6 class="fw-bold mb-2" style="min-height: 48px;">Sungrow SG7.0RT</h6>
            <div class="mb-2">
              <span class="badge bg-light text-dark border me-1"><i class="bi bi-cpu"></i> 7kW</span>
            </div>
            <div class="mt-auto">
              <h5 class="text-danger fw-bold mb-2">S/ 3,750</h5>
              <button class="btn btn-primary w-100 btn-sm">
                <i class="bi bi-cart-plus me-1"></i>Agregar
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 4 -->
      <div class="col-lg-3 col-md-6">
        <div class="card product-card h-100 border shadow-sm">
          <div class="position-relative overflow-hidden" style="height: 220px;">
            <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400" 
                 class="w-100 h-100 object-fit-cover" alt="Inversor">
            <span class="position-absolute top-0 end-0 m-2">
              <span class="badge bg-danger">Top Venta</span>
            </span>
            <button class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
              <i class="bi bi-heart"></i>
            </button>
          </div>
          <div class="card-body d-flex flex-column">
            <small class="text-muted">SUNGROW</small>
            <h6 class="fw-bold mb-2" style="min-height: 48px;">Sungrow SG5.0RT</h6>
            <div class="mb-2">
              <span class="badge bg-light text-dark border me-1"><i class="bi bi-cpu"></i> 5kW</span>
            </div>
            <div class="mt-auto">
              <h5 class="text-danger fw-bold mb-2">S/ 2,990</h5>
              <button class="btn btn-primary w-100 btn-sm">
                <i class="bi bi-cart-plus me-1"></i>Agregar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  function changeImage(button, imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
    document.querySelectorAll('.thumbnail-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
  }
</script>
@endsection