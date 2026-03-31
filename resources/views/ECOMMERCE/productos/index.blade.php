@extends('TEMPLATES.ecommerce')

@section('title', 'Catálogo de Productos Solares')

@section('content')

  {{-- Page Header --}}
  <section class="pr-header">
    <div class="container">
      <div class="pr-header-inner">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pr-breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="#"><i class="bi bi-house me-1"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Productos</li>
          </ol>
        </nav>
        <h1 class="pr-page-title">Catálogo de <span>Productos Solares</span></h1>
      </div>
    </div>
  </section>

  {{-- Products Section --}}
  <section class="py-5" style="background: var(--c-bg);">
    <div class="container">
      <div class="row g-4">

        {{-- Sidebar Filters --}}
        <div class="col-lg-3">
          <div class="pr-sidebar sticky-top" style="top: 80px;">

            {{-- Categorias --}}
            <div class="pr-filter-group">
              <div class="pr-filter-title">Filtrar por</div>
              @foreach($tipos_producto as $tipo_id => $productos)
              <div class="pr-filter-item">
                <div class="form-check m-0">
                  <input class="form-check-input" type="radio" name="categoryFilter" id="cat1" checked>
                  <label class="form-check-label" for="cat1">{{ $productos->first()->tipo->name ?? 'Sin tipo' }}</label>
                </div>
                <span class="pr-filter-count">{{ $productos->sum(fn($p) => $p->inventarios->sum('cantidad')) }}</span>
              </div>
              @endforeach
            </div>

            <hr class="pr-filter-sep">

            {{-- Estado --}}
            <div class="pr-filter-group">
              <div class="pr-filter-item">
                <div class="form-check m-0 d-flex align-items-center gap-2">
                  <i class="bi bi-box-seam" style="color:var(--bs-primary); font-size:1rem;"></i>
                  <input class="form-check-input mt-0" type="checkbox" id="inStock">
                  <label class="form-check-label" for="inStock">En stock</label>
                </div>
              </div>
              <div class="pr-filter-item">
                <div class="form-check m-0 d-flex align-items-center gap-2">
                  <i class="bi bi-shield-check" style="color:var(--c-success); font-size:1rem;"></i>
                  <input class="form-check-input mt-0" type="checkbox" id="protection">
                  <label class="form-check-label" for="protection">Protección al consumidor</label>
                </div>
              </div>
            </div>

            <hr class="pr-filter-sep">

            {{-- Marca --}}
            <div class="pr-filter-group">
              <div class="pr-filter-group-head">
                <span class="pr-fg-label">Marca</span>
                <i class="bi bi-chevron-down" style="color:var(--c-text-muted); font-size:.8rem; cursor:pointer;"></i>
              </div>
              @foreach($marcas_producto as $marca_id => $productos)
                <div class="pr-filter-item">
                  <div class="form-check m-0">
                    <input class="form-check-input" type="checkbox" id="brand{{ $marca_id }}">
                    <label class="form-check-label" for="brand{{ $marca_id }}">{{ $productos->first()->marca->name ?? 'Sin marca' }}</label>
                  </div>
                  <span class="pr-filter-count">{{ $productos->sum(fn($p) => $p->inventarios->sum('cantidad')) }}</span>
                </div>
              @endforeach
              <!-- <button class="pr-show-more mt-1">
                <i class="bi bi-plus-circle"></i> Ver más marcas
              </button> -->
            </div>

            <hr class="pr-filter-sep">

            <button class="btn pr-clear-btn w-100">
              <i class="bi bi-x-circle me-2"></i>Limpiar filtros
            </button>

          </div>
        </div>

        {{-- Product List Area --}}
        <div class="col-lg-9">

          {{-- Sort Bar --}}
          <div class="pr-sort-bar">
            <div class="pr-sort-info">
              <strong>193</strong> resultados encontrados
            </div>
            <div class="pr-sort-right">
              <span class="pr-sort-label">Ordenar por:</span>
              <select class="pr-sort-select">
                <option selected>Más relevantes</option>
                <option>Menor precio</option>
                <option>Mayor precio</option>
                <option>Más vendidos</option>
                <option>Mejor valorados</option>
                <option>Más recientes</option>
              </select>
              <div class="pr-view-grp">
                <button class="pr-view-btn active" title="Vista lista"><i class="bi bi-list-ul"></i></button>
                <button class="pr-view-btn" title="Vista grilla"><i class="bi bi-grid-3x3-gap"></i></button>
              </div>
            </div>
          </div>

          {{-- Producto 1: Panel Solar Monocristalino 450W --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Panel Solar 450W">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge accent">Eco Plus</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Jinko Solar</div>
              <div class="pr-prod-name">Panel Solar Monocristalino 450W</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                <small class="ms-1">(124 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">450 W</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">21.3%</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">N.° de celdas</span><span class="pr-spec-val">144</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Dimensiones</span><span class="pr-spec-val">2094x1038x35</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo célula</span><span class="pr-spec-val">Mono PERC</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">25 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-patch-check"></i> Certificado</span>
                <span class="pr-tag success"><i class="bi bi-truck"></i> Envío gratis</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <span class="pr-discount-badge">-18% OFF</span>
                <div class="pr-old-price">S/ 1,099</div>
                <div class="pr-price">S/ 899</div>
                <div class="pr-price-label">Por unidad</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Producto 2: Kit Solar 3kW --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Kit Solar 3kW">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge success">Top Venta</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Canadian Solar</div>
              <div class="pr-prod-name">Kit Solar Completo 3kW con Inversor On-Grid</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <small class="ms-1">(256 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia sistema</span><span class="pr-spec-val">3 kW</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Paneles</span><span class="pr-spec-val">6 x 550W</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo inversor</span><span class="pr-spec-val">On-Grid</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Ahorro estimado</span><span class="pr-spec-val">80%</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Instalación</span><span class="pr-spec-val">Incluida</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">10 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-box-seam"></i> Kit Completo</span>
                <span class="pr-tag success"><i class="bi bi-truck"></i> Envío gratis</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <div class="pr-price">S/ 7,490</div>
                <div class="pr-price-label">Kit completo</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Producto 3: Inversor Híbrido 5kW --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Inversor Híbrido 5kW">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge primary">Nuevo</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Huawei</div>
              <div class="pr-prod-name">Inversor Híbrido 5kW con Monitoreo WiFi</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                <small class="ms-1">(89 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">5 kW</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">97.6%</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo</span><span class="pr-spec-val">Hibrido</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Conectividad</span><span class="pr-spec-val">WiFi + App</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Compatible</span><span class="pr-spec-val">Baterías litio</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">5 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-wifi"></i> WiFi integrado</span>
                <span class="pr-tag"><i class="bi bi-phone"></i> App móvil</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <div class="pr-price">S/ 3,250</div>
                <div class="pr-price-label">Por unidad</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Producto 4: Kit Premium 5kW --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/159397/solar-panel-array-power-sun-electricity-159397.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Kit Premium 5kW">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge primary">Premium</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Longi Solar</div>
              <div class="pr-prod-name">Kit Premium 5kW Sistema Híbrido Completo</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <small class="ms-1">(178 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia sistema</span><span class="pr-spec-val">5 kW</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Paneles</span><span class="pr-spec-val">10 x 550W</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Batería</span><span class="pr-spec-val">10 kWh Litio</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo inversor</span><span class="pr-spec-val">Hibrido</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Monitoreo</span><span class="pr-spec-val">Inteligente</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">15 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-award"></i> Premium</span>
                <span class="pr-tag success"><i class="bi bi-truck"></i> Envío e instalación gratis</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <div class="pr-price">S/ 11,990</div>
                <div class="pr-price-label">Sistema completo</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Producto 5: Batería Litio 10kWh --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Batería Litio 10kWh">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Pylontech</div>
              <div class="pr-prod-name">Batería Litio 10kWh Apilable US3000C</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                <small class="ms-1">(145 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Capacidad</span><span class="pr-spec-val">10 kWh</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo batería</span><span class="pr-spec-val">LiFePO4</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Ciclos de vida</span><span class="pr-spec-val">6,000</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Escalable hasta</span><span class="pr-spec-val">48 kWh</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Sistema</span><span class="pr-spec-val">BMS Inteligente</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">10 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-stack"></i> Apilable</span>
                <span class="pr-tag"><i class="bi bi-recycle"></i> 6000 ciclos</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <span class="pr-discount-badge">-9% OFF</span>
                <div class="pr-old-price">S/ 8,799</div>
                <div class="pr-price">S/ 7,990</div>
                <div class="pr-price-label">Por unidad</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Producto 6: Inversor On-Grid Fronius --}}
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Inversor Fronius">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge accent">-15% OFF</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">Fronius</div>
              <div class="pr-prod-name">Inversor On-Grid Primo 4.0-1 con Monitoreo</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                <small class="ms-1">(67 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">4 kW</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">98%</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo</span><span class="pr-spec-val">On-Grid</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Conectividad</span><span class="pr-spec-val">WiFi / Ethernet</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Origen</span><span class="pr-spec-val">Austria</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">5 años</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-wifi"></i> Conectividad</span>
                <span class="pr-tag"><i class="bi bi-graph-up"></i> Monitoreo</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                <span class="pr-discount-badge">-15% OFF</span>
                <div class="pr-old-price">S/ 2,890</div>
                <div class="pr-price">S/ 2,456</div>
                <div class="pr-price-label">Por unidad</div>
              </div>
              <div class="d-flex flex-column gap-2">
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</button>
              </div>
            </div>
          </div>

          {{-- Paginación --}}
          <nav aria-label="Navegación de productos" class="mt-4">
            <ul class="pagination pr-pagination justify-content-center">
              <li class="page-item disabled">
                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item">
                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
              </li>
            </ul>
          </nav>

        </div>{{-- /col-lg-9 --}}
      </div>{{-- /row --}}
    </div>{{-- /container --}}
  </section>

@endsection

@section('js')
@endsection