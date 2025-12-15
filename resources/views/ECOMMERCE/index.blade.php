@extends('TEMPLATES.ecommerce')

@section('title', 'INICIO')

@section('css')
@endsection

@section('content')
    <!-- HERO -->
    <section class="hero-section" id="inicio">
    <div class="container">
        <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <div class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary mb-3 px-3 py-2">
            <i class="bi bi-lightning-charge-fill"></i> Energía renovable para tu futuro
            </div>
            <h1 class="hero-title mb-4 fw-bold display-4">Paneles solares e instalación <span class="text-primary">profesional</span></h1>
            <p class="mb-4 text-muted fs-5 lh-lg">
            Reduce hasta un <strong class="text-secondary">90% tu factura eléctrica</strong> y apuesta por la sostenibilidad. Diseñamos, vendemos e instalamos soluciones de energía solar para hogares y empresas en todo el Perú.
            </p>
            <div class="d-flex flex-wrap gap-3 mb-4">
            <a href="#productos" class="btn btn-primary btn-lg px-4 py-3">
                <i class="bi bi-grid-3x3-gap me-2"></i> Ver catálogo de productos
            </a>
            <a href="#contacto" class="btn btn-outline-secondary btn-lg px-4 py-3">
                <i class="bi bi-calculator me-2"></i> Cotización gratuita
            </a>
            </div>
            
            <!-- Beneficios destacados -->
            <div class="row g-3 mt-4">
            <div class="col-sm-4">
                <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                    <i class="bi bi-check-circle-fill text-secondary fs-5"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Evaluación</small>
                    <strong class="small">100% Gratuita</strong>
                </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                    <i class="bi bi-shield-check text-primary fs-5"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Garantía</small>
                    <strong class="small">25 años</strong>
                </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                    <i class="bi bi-headset text-secondary fs-5"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Soporte</small>
                    <strong class="small">24/7 en Perú</strong>
                </div>
                </div>
            </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row g-3 mt-4 pt-4 border-top">
            <div class="col-4">
                <h3 class="text-primary mb-0 fw-bold">1,500+</h3>
                <small class="text-muted">Instalaciones</small>
            </div>
            <div class="col-4">
                <h3 class="text-secondary mb-0 fw-bold">98%</h3>
                <small class="text-muted">Satisfacción</small>
            </div>
            <div class="col-4">
                <h3 class="text-primary mb-0 fw-bold">15 años</h3>
                <small class="text-muted">Experiencia</small>
            </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="position-relative">
            <!-- Imagen principal con overlay -->
            <div class="rounded-4 overflow-hidden shadow-lg position-relative hero-image-container" style="height: 600px;">
                <img src="https://images.pexels.com/photos/9875445/pexels-photo-9875445.jpeg?auto=compress&cs=tinysrgb&w=1200" 
                    class="w-100 h-100 object-fit-cover hero-main-image" 
                    alt="Paneles solares en techo">
                
                <!-- Badge flotante -->
                <div class="position-absolute top-0 end-0 m-4">
                <div class="bg-white rounded-3 shadow p-3 text-center" style="min-width: 120px;">
                    <div class="text-secondary mb-1">
                    <i class="bi bi-sun-fill fs-3"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-primary">-90%</h4>
                    <small class="text-muted">Ahorro en luz</small>
                </div>
                </div>

                <!-- Card flotante inferior -->
                <div class="position-absolute bottom-0 start-0 m-4">
                <div class="bg-white rounded-3 shadow-lg p-3" style="max-width: 280px;">
                    <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-secondary me-2"></i>
                    <strong class="small">Instalación rápida</strong>
                    </div>
                    <p class="small text-muted mb-0">
                    Tu sistema solar funcionando en <strong class="text-primary">3-5 días</strong> después de la aprobación.
                    </p>
                </div>
                </div>
            </div>

            <!-- Decoración de fondo -->
            <div class="position-absolute top-0 end-0 translate-middle-y" style="z-index: -1; opacity: 0.1;">
                <i class="bi bi-sun" style="font-size: 300px; color: var(--bs-warning);"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- LISTA DE PRODUCTOS -->
    <section class="py-5 bg-light" id="productos">
    <div class="container">
        <div class="text-center mb-5">
        <h2 class="section-title fw-bold">Paneles solares destacados</h2>
        <p class="text-muted">Encuentra la solución perfecta para tu hogar o negocio</p>
        </div>

        <!-- Tabs de categorías -->
        <ul class="nav nav-pills justify-content-center mb-4" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="residencial-tab" data-bs-toggle="pill" data-bs-target="#residencial" type="button">
            <i class="bi bi-house-fill"></i> Residencial
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="comercial-tab" data-bs-toggle="pill" data-bs-target="#comercial" type="button">
            <i class="bi bi-building"></i> Comercial
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="industrial-tab" data-bs-toggle="pill" data-bs-target="#industrial" type="button">
            <i class="bi bi-gear-fill"></i> Industrial
            </button>
        </li>
        </ul>

        <div class="tab-content" id="productTabsContent">
        <!-- Tab Residencial -->
        <div class="tab-pane fade show active" id="residencial" role="tabpanel">
            <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">Eco Plus</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-half text-warning me-2"></i>
                        <small class="text-white-50">(124)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Panel Solar 450W Monocristalino</h5>
                    <p class="small mb-2 text-white-50">
                        <i class="bi bi-lightning-charge-fill"></i> 450W • 
                        <i class="bi bi-shield-check"></i> 25 años garantía
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                        <small class="text-white-50 text-decoration-line-through d-block">S/ 1,099.00</small>
                        <span class="h5 mb-0 fw-bold">S/ 899.00</span>
                        </div>
                        <span class="badge bg-secondary">-18%</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-success position-absolute top-0 end-0 m-3">Top venta</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        <small class="text-white-50">(256)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Kit Solar 3kW + Inversor</h5>
                    <p class="small mb-2 text-white-50">
                        <i class="bi bi-check-circle"></i> Kit completo • 
                        <i class="bi bi-check-circle"></i> Listo para instalar
                    </p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 7,490.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">Nuevo</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star text-warning me-2"></i>
                        <small class="text-white-50">(89)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Inversor Híbrido 5kW</h5>
                    <p class="small mb-2 text-white-50">
                        <i class="bi bi-battery-half"></i> Con batería • 
                        <i class="bi bi-wifi"></i> Monitoreo WiFi
                    </p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 3,250.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/159397/solar-panel-array-power-sun-electricity-159397.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-primary position-absolute top-0 end-0 m-3">Premium</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        <small class="text-white-50">(178)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Kit Premium 5kW</h5>
                    <p class="small mb-2 text-white-50">
                        <i class="bi bi-award"></i> Máxima calidad • 
                        <i class="bi bi-truck"></i> Envío gratis
                    </p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 11,990.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Tab Comercial -->
        <div class="tab-pane fade" id="comercial" role="tabpanel">
            <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/159397/solar-panel-array-power-sun-electricity-159397.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-primary position-absolute top-0 end-0 m-3">Comercial</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-half text-warning me-2"></i>
                        <small class="text-white-50">(67)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Sistema Solar 10kW Trifásico</h5>
                    <p class="small mb-2 text-white-50">Ideal para pequeños negocios y locales comerciales.</p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 18,500.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">Comercial</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        <small class="text-white-50">(92)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Sistema Solar 20kW Comercial</h5>
                    <p class="small mb-2 text-white-50">Para medianas empresas con consumo elevado.</p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 32,900.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Tab Industrial -->
        <div class="tab-pane fade" id="industrial" role="tabpanel">
            <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-dark position-absolute top-0 end-0 m-3">Industrial</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star text-warning me-2"></i>
                        <small class="text-white-50">(45)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Panel Solar 550W Industrial</h5>
                    <p class="small mb-2 text-white-50">Diseñado para proyectos de gran escala.</p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 1,150.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100 border-0 rounded-4 overflow-hidden">
                <div class="product-card-image" style="background-image: url('https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="badge bg-primary position-absolute top-0 end-0 m-3">Industrial</span>
                    <div class="product-card-overlay">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        <small class="text-white-50">(38)</small>
                    </div>
                    <h5 class="fw-bold mb-2">Sistema Solar 50kW Industrial</h5>
                    <p class="small mb-2 text-white-50">Solución completa para industrias.</p>
                    <div class="mb-3">
                        <span class="h5 mb-0 fw-bold">S/ 75,000.00</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                    <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Ver detalles</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="text-center mt-5">
        <a href="#" class="btn btn-secondary btn-lg"><i class="bi bi-grid-3x3-gap"></i> Ver todos los productos</a>
        </div>
    </div>
    </section>

    <!-- SERVICIO DE INSTALACIÓN -->
    <section class="py-5 bg-white" id="instalacion">
    <div class="container">
        <div class="row align-items-center g-4">
        <div class="col-md-6">
            <h2 class="section-title fw-bold">Servicio de instalación certificada</h2>
            <p class="text-muted fs-5 mb-4">
            Nuestro equipo técnico se encarga de todo: diseño del sistema, instalación, configuración
            y capacitación básica para que puedas monitorear tu consumo.
            </p>
            <div class="mb-3">
            <div class="d-flex align-items-start mb-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                <i class="bi bi-clipboard-check fs-4"></i>
                </div>
                <div>
                <h5 class="fw-bold mb-1">Visita técnica y evaluación del sitio</h5>
                <p class="text-muted mb-0 small">Evaluamos tu espacio y consumo sin costo alguno</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 me-3">
                <i class="bi bi-diagram-3 fs-4"></i>
                </div>
                <div>
                <h5 class="fw-bold mb-1">Diseño personalizado según tu consumo</h5>
                <p class="text-muted mb-0 small">Sistema optimizado para tu necesidad específica</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                <i class="bi bi-tools fs-4"></i>
                </div>
                <div>
                <h5 class="fw-bold mb-1">Instalación segura y certificada</h5>
                <p class="text-muted mb-0 small">Técnicos certificados con años de experiencia</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 me-3">
                <i class="bi bi-headset fs-4"></i>
                </div>
                <div>
                <h5 class="fw-bold mb-1">Soporte post-venta y mantenimiento</h5>
                <p class="text-muted mb-0 small">Atención permanente y mantenimiento preventivo</p>
                </div>
            </div>
            </div>
            <a href="#contacto" class="btn btn-secondary btn-lg"><i class="bi bi-calendar-check"></i> Agendar visita técnica</a>
        </div>
        <div class="col-md-6">
            <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow">
            <img src="https://images.pexels.com/photos/9875450/pexels-photo-9875450.jpeg?auto=compress&cs=tinysrgb&w=1200" 
                class="w-100 h-100 object-fit-cover" 
                alt="Técnico instalando paneles solares">
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- PROCESO DE COMPRA -->
    <section class="py-5 bg-light" id="proceso">
    <div class="container">
        <div class="text-center mb-5">
        <h2 class="section-title fw-bold">¿Cómo funciona nuestro proceso?</h2>
        <p class="text-muted">En 4 simples pasos tendrás tu sistema solar funcionando</p>
        </div>
        <div class="row g-4">
        <div class="col-md-3">
            <div class="process-step text-center">
            <div class="step-number">1</div>
            <i class="bi bi-phone fs-1 text-primary mb-3 d-block mt-3"></i>
            <h5 class="fw-bold">Contacto Inicial</h5>
            <p class="text-muted small mb-0">Llámanos o completa el formulario. Te respondemos en menos de 24 horas.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="process-step text-center">
            <div class="step-number">2</div>
            <i class="bi bi-house-check fs-1 text-secondary mb-3 d-block mt-3"></i>
            <h5 class="fw-bold">Evaluación Técnica</h5>
            <p class="text-muted small mb-0">Visitamos tu propiedad para evaluar el espacio y tu consumo eléctrico.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="process-step text-center">
            <div class="step-number">3</div>
            <i class="bi bi-file-earmark-text fs-1 text-primary mb-3 d-block mt-3"></i>
            <h5 class="fw-bold">Propuesta y Cotización</h5>
            <p class="text-muted small mb-0">Recibe una propuesta detallada con costos claros y tiempo de instalación.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="process-step text-center">
            <div class="step-number">4</div>
            <i class="bi bi-check-circle fs-1 text-secondary mb-3 d-block mt-3"></i>
            <h5 class="fw-bold">Instalación</h5>
            <p class="text-muted small mb-0">Instalamos tu sistema en 3-5 días y te capacitamos en su uso.</p>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
        <h2 class="section-title fw-bold">Lo que dicen nuestros clientes</h2>
        <p class="text-muted">Más de 850 familias y empresas confían en nosotros</p>
        </div>
        <div class="row g-4">
        <div class="col-md-4">
            <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                <i class="bi bi-person-fill fs-4"></i>
                </div>
                <div>
                <h6 class="fw-bold mb-0">María González</h6>
                <small class="text-muted">Lima, Perú</small>
                </div>
            </div>
            <div class="mb-2">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
            <p class="text-muted mb-0">"Excelente servicio. Mi factura de luz bajó de S/450 a solo S/50 mensuales. La instalación fue rápida y profesional."</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                <i class="bi bi-person-fill fs-4"></i>
                </div>
                <div>
                <h6 class="fw-bold mb-0">Carlos Mendoza</h6>
                <small class="text-muted">Arequipa, Perú</small>
                </div>
            </div>
            <div class="mb-2">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
            <p class="text-muted mb-0">"La mejor inversión que he hecho. El equipo técnico fue muy profesional y me explicaron todo el proceso detalladamente."</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                <i class="bi bi-building fs-4"></i>
                </div>
                <div>
                <h6 class="fw-bold mb-0">Restaurante El Sol</h6>
                <small class="text-muted">Cusco, Perú</small>
                </div>
            </div>
            <div class="mb-2">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
            <p class="text-muted mb-0">"Instalamos un sistema de 15kW y estamos ahorrando más de S/2,000 mensuales. Recuperaremos la inversión en 3 años."</p>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-3">¿Listo para comenzar a ahorrar?</h2>
        <p class="fs-5 mb-4">Obtén una cotización gratuita en menos de 24 horas</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="#contacto" class="btn btn-light btn-lg"><i class="bi bi-telephone-fill"></i> Llamar ahora</a>
        <a href="#contacto" class="btn btn-outline-light btn-lg"><i class="bi bi-envelope-fill"></i> Solicitar cotización</a>
        </div>
    </div>
    </section>

    <!-- ALIADOS ESTRATÉGICOS -->
    <section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary mb-3 px-3 py-2">
            <i class="bi bi-award-fill"></i> Colaboraciones de Confianza
        </span>
        <h2 class="section-title fw-bold mb-3">Nuestros Aliados Estratégicos</h2>
        <p class="text-muted mx-auto fs-5">
            Nos aliamos con empresas líderes para brindar mejores soluciones a nuestros clientes.    
        </p>
        </div>

        <!-- Grid de aliados -->
        <div class="row g-4 justify-content-center">
        <!-- Vestas -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.vestas.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/VESTA.png" alt="Vestas" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- CAT -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cat.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/CAT.png" alt="CAT" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Cropx -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cropx.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/CRPOX.png" alt="Cropx" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Colegio de Ingenieros del Perú -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cip.org.pe/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/CIP.png" alt="Colegio de Ingenieros del Perú" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Jinko Solar -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.jinkosolar.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/JINKO-SOLAR.png" alt="Jinko Solar" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Yingli Solar -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.yinglisolar.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/YINGLI-SOLAR.png" alt="Yingli Solar" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Ethos Energy -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.ethosenergygroup.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/ETHOS-ENERGY.png" alt="Ethos Energy" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- LiuGong -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.liugong.com/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/LIUGONG-1.png" alt="LiuGong" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Universidad de Piura -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.udep.edu.pe/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/UDEP.png" alt="Universidad de Piura" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>

        <!-- Limaq -->
        <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.ulima.edu.pe/" target="_blank" rel="noopener noreferrer" class="partner-card-link">
            <div class="partner-logo-container">
                <div class="partner-logo-wrapper">
                <img src="https://cisnergia.com/wp-content/uploads/2023/07/LIMAQ.png" alt="Limaq" class="partner-logo">
                </div>
                <div class="partner-overlay">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
            </div>
            </a>
        </div>
        </div>

        <!-- Call to action -->
        <div class="text-center mt-5 pt-4">
        <p class="text-muted mb-3">
            <i class="bi bi-shield-check text-secondary me-2"></i>
            Productos certificados y respaldados por marcas líderes mundiales
        </p>
        </div>
    </div>
    </section>

    <!-- CONTACTO -->
    <section class="py-5" id="contacto">
    <div class="container">
        <div class="row g-4">
        <div class="col-lg-6">
            <h2 class="section-title fw-bold mb-4">Contáctanos</h2>
            <p class="text-muted mb-4">Completa el formulario y nos comunicaremos contigo a la brevedad</p>
            
            <form>
            <div class="row g-3">
                <div class="col-md-6">
                <label class="form-label fw-bold">Nombre completo</label>
                <input type="text" class="form-control" placeholder="Juan Pérez">
                </div>
                <div class="col-md-6">
                <label class="form-label fw-bold">Teléfono</label>
                <input type="tel" class="form-control" placeholder="+51 999 999 999">
                </div>
                <div class="col-12">
                <label class="form-label fw-bold">Correo electrónico</label>
                <input type="email" class="form-control" placeholder="ejemplo@correo.com">
                </div>
                <div class="col-12">
                <label class="form-label fw-bold">Tipo de instalación</label>
                <select class="form-select">
                    <option selected>Selecciona una opción</option>
                    <option>Residencial</option>
                    <option>Comercial</option>
                    <option>Industrial</option>
                </select>
                </div>
                <div class="col-12">
                <label class="form-label fw-bold">Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                </div>
                <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-send-fill"></i> Enviar solicitud</button>
                </div>
            </div>
            </form>
        </div>
        
        <div class="col-lg-6">
            <h3 class="fw-bold mb-4">Información de contacto</h3>
            
            <div class="d-flex align-items-start mb-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                <i class="bi bi-geo-alt-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Dirección</h5>
                <p class="text-muted mb-0">Av. Principal 123, San Isidro<br>Lima, Perú</p>
            </div>
            </div>

            <div class="d-flex align-items-start mb-4">
            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-3 me-3">
                <i class="bi bi-telephone-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Teléfono</h5>
                <p class="text-muted mb-0">+51 999 999 999<br>+51 (01) 234-5678</p>
            </div>
            </div>

            <div class="d-flex align-items-start mb-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                <i class="bi bi-envelope-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Email</h5>
                <p class="text-muted mb-0">ventas@cisnergia.pe<br>soporte@cisnergia.pe</p>
            </div>
            </div>

            <div class="d-flex align-items-start mb-4">
            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-3 me-3">
                <i class="bi bi-clock-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Horario de atención</h5>
                <p class="text-muted mb-0">Lunes a Viernes: 9:00 AM - 6:00 PM<br>Sábados: 9:00 AM - 1:00 PM</p>
            </div>
            </div>

            <div class="mt-4">
            <h5 class="fw-bold mb-3">Síguenos en redes sociales</h5>
            <div class="d-flex gap-2">
                <a href="#" class="btn btn-outline-primary"><i class="bi bi-facebook"></i></a>
                <a href="#" class="btn btn-outline-secondary"><i class="bi bi-twitter"></i></a>
                <a href="#" class="btn btn-outline-primary"><i class="bi bi-instagram"></i></a>
                <a href="#" class="btn btn-outline-secondary"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="btn btn-outline-primary"><i class="bi bi-whatsapp"></i></a>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
@endsection

@section('js')
@endsection