<?php $__env->startSection('title', 'INICIO'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    

    <!-- BREADCRUMB -->
    <section class="py-3 bg-light ">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- PRODUCTOS PAGE -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- SIDEBAR FILTROS -->
                <div class="col-lg-3">
                    <div class="sticky-top" style="top: 20px;">

                        <!-- Filtrar por (Categorías con Radio Buttons) -->
                        <div class="filter-section mb-3">
                            <h6 class="filter-title text-muted mb-3">Filtrar por:</h6>

                            <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="radio" name="categoryFilter" id="cat1"
                                        checked>
                                    <label class="form-check-label text-primary fw-500" for="cat1">
                                        Módulo solar
                                    </label>
                                </div>
                                <span class="text-muted small">794</span>
                            </div>

                            <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="radio" name="categoryFilter" id="cat2">
                                    <label class="form-check-label text-primary fw-500" for="cat2">
                                        Inversor
                                    </label>
                                </div>
                                <span class="text-muted small">2739</span>
                            </div>

                            <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="radio" name="categoryFilter" id="cat3">
                                    <label class="form-check-label text-primary fw-500" for="cat3">
                                        Batería
                                    </label>
                                </div>
                                <span class="text-muted small">1231</span>
                            </div>

                            <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="radio" name="categoryFilter" id="cat4">
                                    <label class="form-check-label text-primary fw-500" for="cat4">
                                        Accesorios
                                    </label>
                                </div>
                                <span class="text-muted small">1027</span>
                            </div>

                            <div class="filter-option d-flex align-items-center justify-content-between mb-3">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="radio" name="categoryFilter" id="cat5">
                                    <label class="form-check-label text-primary fw-semibold" for="cat5">
                                        Todos
                                    </label>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Checkbox: En stock -->
                            <div class="filter-option d-flex align-items-center mb-2">
                                <div class="form-check m-0 d-flex align-items-center">
                                    <i class="bi bi-box-seam text-secondary me-2" style="font-size: 1.1rem;"></i>
                                    <input class="form-check-input me-2" type="checkbox" id="inStock">
                                    <label class="form-check-label text-dark" for="inStock">
                                        En stock
                                    </label>
                                </div>
                            </div>

                            <!-- Checkbox: Protección al consumidor -->
                            <div class="filter-option d-flex align-items-center mb-3">
                                <div class="form-check m-0 d-flex align-items-center">
                                    <i class="bi bi-shield-check text-secondary me-2" style="font-size: 1.1rem;"></i>
                                    <input class="form-check-input me-2" type="checkbox" id="protection">
                                    <label class="form-check-label text-dark" for="protection">
                                        Protección al consumidor
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- MARCA (Filtro por Marca) -->
                        <div class="filter-section mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="filter-title text-dark fw-bold mb-0 text-uppercase"
                                    style="font-size: 0.85rem; letter-spacing: 0.5px;">Marca</h6>
                                <i class="bi bi-chevron-down text-muted" style="cursor: pointer;"></i>
                            </div>

                            <div class="brand-list">
                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand1">
                                        <label class="form-check-label text-primary fw-500" for="brand1">
                                            Huawei
                                        </label>
                                    </div>
                                    <span class="text-muted small">672</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand2">
                                        <label class="form-check-label text-primary fw-500" for="brand2">
                                            Fronius
                                        </label>
                                    </div>
                                    <span class="text-muted small">556</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand3">
                                        <label class="form-check-label text-primary fw-500" for="brand3">
                                            SolarEdge
                                        </label>
                                    </div>
                                    <span class="text-muted small">449</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand4">
                                        <label class="form-check-label text-primary fw-500" for="brand4">
                                            JA Solar
                                        </label>
                                    </div>
                                    <span class="text-muted small">378</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand5">
                                        <label class="form-check-label text-primary fw-500" for="brand5">
                                            BYD
                                        </label>
                                    </div>
                                    <span class="text-muted small">362</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand6">
                                        <label class="form-check-label text-primary fw-500" for="brand6">
                                            Goodwe
                                        </label>
                                    </div>
                                    <span class="text-muted small">293</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand7">
                                        <label class="form-check-label text-primary fw-500" for="brand7">
                                            Solis
                                        </label>
                                    </div>
                                    <span class="text-muted small">274</span>
                                </div>

                                <div class="filter-option d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="brand8">
                                        <label class="form-check-label text-primary fw-500" for="brand8">
                                            Sungrow
                                        </label>
                                    </div>
                                    <span class="text-muted small">222</span>
                                </div>
                            </div>

                            <button class="btn btn-link text-muted text-decoration-none p-0 mt-2 small">
                                Suche nach Weiteren...
                            </button>
                        </div>

                        <!-- Botón limpiar filtros -->
                        <button class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-2"></i>Limpiar filtros
                        </button>
                    </div>
                </div>

                <!-- ÁREA DE PRODUCTOS -->
                <div class="col-lg-9">
                    <!-- Header con ordenamiento -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <div>
                            <h2 class="fw-bold mb-1">Todos los Productos</h2>
                            <p class="text-muted mb-0">Mostrando 193 resultados</p>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <label class="text-muted small mb-0 me-2">Ordenar por:</label>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option selected>Más relevantes</option>
                                <option>Menor precio</option>
                                <option>Mayor precio</option>
                                <option>Más vendidos</option>
                                <option>Mejor valorados</option>
                                <option>Más recientes</option>
                            </select>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-secondary active">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Productos -->
                    <div class="mb-4">
                        <!-- Producto 1 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Panel Solar">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <span class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-success">Eco Plus</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">JINKO SOLAR</small>
                                        <h5 class="fw-bold mb-2">Panel Solar Monocristalino 450W</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-half text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(124 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Potencia
                                                        nominal</span>
                                                    <strong class="text-primary">450 W</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Eficiencia</span>
                                                    <strong>21.3%</strong> <span class="badge bg-success"
                                                        style="font-size: 0.65rem;">high performance</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Número de
                                                        celdas</span>
                                                    <strong>144</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Dimensiones</span>
                                                    <strong>2094 × 1038 × 35 [mm]</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Tipo de
                                                        célula</span>
                                                    <strong>Mono PERC</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>25 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i
                                                    class="bi bi-check-circle"></i> Certificado</span>
                                            <span class="badge bg-success text-white"><i class="bi bi-truck"></i> Envío
                                                gratis</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <span class="badge bg-secondary mb-2">-18% OFF</span>
                                            <div class="mb-2">
                                                <small class="text-muted text-decoration-line-through d-block">S/
                                                    1,099</small>
                                                <h3 class="text-primary fw-bold mb-0">S/ 899</h3>
                                                <small class="text-muted">Por unidad</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 2 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Kit Solar">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <span class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-success">Top Venta</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">CANADIAN SOLAR</small>
                                        <h5 class="fw-bold mb-2">Kit Solar Completo 3kW con Inversor On-Grid</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(256 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Potencia
                                                        sistema</span>
                                                    <strong class="text-primary">3 kW</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Paneles
                                                        incluidos</span>
                                                    <strong>6 × 550W</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Tipo
                                                        inversor</span>
                                                    <strong>On-Grid</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Ahorro
                                                        estimado</span>
                                                    <strong>80%</strong> <span class="badge bg-success"
                                                        style="font-size: 0.65rem;">alto ahorro</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Instalación</span>
                                                    <strong>Incluida</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>10 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i class="bi bi-box-seam"></i>
                                                Kit Completo</span>
                                            <span class="badge bg-success text-white"><i class="bi bi-truck"></i> Envío
                                                gratis</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <div class="mb-2">
                                                <h3 class="text-primary fw-bold mb-0">S/ 7,490</h3>
                                                <small class="text-muted">Kit completo</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 3 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Inversor">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <span class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-secondary">Nuevo</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">HUAWEI</small>
                                        <h5 class="fw-bold mb-2">Inversor Híbrido 5kW con Monitoreo WiFi</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(89 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Potencia
                                                        nominal</span>
                                                    <strong class="text-primary">5 kW</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Eficiencia</span>
                                                    <strong>97.6%</strong> <span class="badge bg-success"
                                                        style="font-size: 0.65rem;">top performance</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Tipo</span>
                                                    <strong>Híbrido</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Conectividad</span>
                                                    <strong>WiFi + App</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Compatible</span>
                                                    <strong>Baterías litio</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>5 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i class="bi bi-wifi"></i> WiFi
                                                integrado</span>
                                            <span class="badge bg-light text-dark border"><i class="bi bi-phone"></i> App
                                                móvil</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <div class="mb-2">
                                                <h3 class="text-primary fw-bold mb-0">S/ 3,250</h3>
                                                <small class="text-muted">Por unidad</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 4 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/159397/solar-panel-array-power-sun-electricity-159397.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Kit Premium">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <span class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-primary text-white">Premium</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">LONGI SOLAR</small>
                                        <h5 class="fw-bold mb-2">Kit Premium 5kW Sistema Híbrido Completo</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(178 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Potencia
                                                        sistema</span>
                                                    <strong class="text-primary">5 kW</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Paneles
                                                        incluidos</span>
                                                    <strong>10 × 550W</strong> <span class="badge bg-primary"
                                                        style="font-size: 0.65rem;">LONGi</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Batería</span>
                                                    <strong>10 kWh Litio</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Tipo
                                                        inversor</span>
                                                    <strong>Híbrido</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Monitoreo</span>
                                                    <strong>Inteligente</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>15 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i class="bi bi-award"></i>
                                                Premium</span>
                                            <span class="badge bg-success text-white"><i class="bi bi-truck"></i> Envío e
                                                instalación gratis</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <div class="mb-2">
                                                <h3 class="text-primary fw-bold mb-0">S/ 11,990</h3>
                                                <small class="text-muted">Sistema completo</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 5 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Batería">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">PYLONTECH</small>
                                        <h5 class="fw-bold mb-2">Batería Litio 10kWh Apilable US3000C</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-half text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(145 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Capacidad</span>
                                                    <strong class="text-primary">10 kWh</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Tipo
                                                        batería</span>
                                                    <strong>LiFePO4</strong> <span class="badge bg-success"
                                                        style="font-size: 0.65rem;">litio</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Ciclos de
                                                        vida</span>
                                                    <strong>6,000</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Escalable
                                                        hasta</span>
                                                    <strong>48 kWh</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Sistema</span>
                                                    <strong>BMS Inteligente</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>10 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i class="bi bi-stack"></i>
                                                Apilable</span>
                                            <span class="badge bg-light text-dark border"><i class="bi bi-recycle"></i>
                                                6000 ciclos</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <span class="badge bg-secondary mb-2">-9% OFF</span>
                                            <div class="mb-2">
                                                <small class="text-muted text-decoration-line-through d-block">S/
                                                    8,799</small>
                                                <h3 class="text-primary fw-bold mb-0">S/ 7,990</h3>
                                                <small class="text-muted">Por unidad</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 6 -->
                        <div class="card product-card border shadow-sm mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="position-relative overflow-hidden h-100" style="min-height: 150px;">
                                        <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400"
                                            class="w-100 h-100 object-fit-cover" alt="Inversor">
                                        <button
                                            class="btn btn-light btn-sm position-absolute top-0 start-0 m-2 rounded-circle">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">FRONIUS</small>
                                        <h5 class="fw-bold mb-2">Inversor On-Grid Primo 4.0-1 con Monitoreo</h5>
                                        <div class="d-flex align-items-center gap-1 mb-3">
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                            <i class="bi bi-star text-warning" style="font-size: 0.85rem;"></i>
                                            <small class="text-muted ms-1">(67 valoraciones)</small>
                                        </div>
                                        <!-- Especificaciones Técnicas -->
                                        <div class="specs-table mb-3">
                                            <div class="row g-0 small">
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block" style="font-size: 0.75rem;">Potencia
                                                        nominal</span>
                                                    <strong class="text-primary">4 kW</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Eficiencia</span>
                                                    <strong>98%</strong> <span class="badge bg-success"
                                                        style="font-size: 0.65rem;">top performance</span>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Tipo</span>
                                                    <strong>On-Grid</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Conectividad</span>
                                                    <strong>WiFi / Ethernet</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Origen</span>
                                                    <strong>Austria</strong>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <span class="text-muted d-block"
                                                        style="font-size: 0.75rem;">Garantía</span>
                                                    <strong>5 años</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border"><i class="bi bi-wifi"></i>
                                                Conectividad</span>
                                            <span class="badge bg-light text-dark border"><i class="bi bi-graph-up"></i>
                                                Monitoreo</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <span class="badge bg-secondary mb-2">-15% OFF</span>
                                            <div class="mb-2">
                                                <small class="text-muted text-decoration-line-through d-block">S/
                                                    2,890</small>
                                                <h3 class="text-primary fw-bold mb-0">S/ 2,456</h3>
                                                <small class="text-muted">Por unidad</small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary w-100 mb-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al carrito
                                            </button>
                                            <button class="btn btn-outline-secondary w-100 btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <nav aria-label="Navegación de productos">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.ecommerce', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHERPIPO\Documents\GitHub\project_cisnergia\resources\views/ECOMMERCE/productos/index.blade.php ENDPATH**/ ?>