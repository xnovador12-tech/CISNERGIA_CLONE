@extends('TEMPLATES.ecommerce')

@section('title', 'INICIO')
@section('css')
<style>

.cis-prod-img {
    height: 180px;
    background-size: cover;        /* que cubra todo */
    background-repeat: no-repeat;
    background-position: center;
    margin: -1px;                  /* elimina el filo */
}


.productos-swiper {
    padding-bottom: 40px; /* espacio para la paginación */
}
.productos-swiper .swiper-button-prev,
.productos-swiper .swiper-button-next {
    top: 40%;
    color: var(--bs-primary);
}
.productos-swiper .swiper-pagination-bullet-active {
    background: var(--bs-primary);
}
</style>
@endsection
@section('content')

    {{-- ═══════════════════════════════════════
         HERO
    ═══════════════════════════════════════ --}}
    <section class="cis-hero" id="inicio">
      <div class="cis-hero-bar"></div>
      <div class="cis-hero-grid"></div>
      <div class="container position-relative">
        <div class="row align-items-center g-5">

          {{-- Columna izquierda --}}
          <div class="col-lg-6">
            <div class="cis-pill">
              <span class="cis-pill-dot"></span>
              Energía renovable para tu futuro
            </div>
            <h1 class="cis-h1 mb-3">
              Paneles solares e<br>instalación <em>profesional</em>
            </h1>
            <p class="mb-4 lh-lg" style="max-width:500px; font-size:1.05rem; color:var(--c-muted);">
              Reduce hasta un <strong style="color:var(--bs-primary);">90% tu factura eléctrica</strong> y apuesta por la sostenibilidad. Diseñamos, vendemos e instalamos soluciones de energía solar para hogares y empresas en todo el Perú.
            </p>
            <div class="d-flex flex-wrap gap-3 mb-4">
              <a href="#productos" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-grid-3x3-gap me-2"></i>Ver catálogo
              </a>
              <a href="#contacto" class="btn btn-outline-secondary btn-lg px-4">
                <i class="bi bi-calculator me-2"></i>Cotización gratis
              </a>
            </div>

            {{-- Benefit chips --}}
            <div class="row g-2 mb-4">
              <div class="col-sm-4">
                <div class="cis-chip">
                  <div class="cis-chip-icon" style="background:rgba(var(--c-success-rgb),.12); color:var(--c-success);">
                    <i class="bi bi-check-circle-fill"></i>
                  </div>
                  <div>
                    <small style="font-size:.7rem; color:var(--c-muted); display:block;">Evaluación</small>
                    <strong style="font-size:.82rem;">100% Gratuita</strong>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="cis-chip">
                  <div class="cis-chip-icon" style="background:rgba(var(--bs-primary-rgb),.07); color:var(--bs-primary);">
                    <i class="bi bi-shield-check"></i>
                  </div>
                  <div>
                    <small style="font-size:.7rem; color:var(--c-muted); display:block;">Garantía</small>
                    <strong style="font-size:.82rem;">25 años</strong>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="cis-chip">
                  <div class="cis-chip-icon" style="background:rgba(var(--bs-primary-rgb),.07); color:var(--bs-primary);">
                    <i class="bi bi-headset"></i>
                  </div>
                  <div>
                    <small style="font-size:.7rem; color:var(--c-muted); display:block;">Soporte</small>
                    <strong style="font-size:.82rem;">24/7 en Perú</strong>
                  </div>
                </div>
              </div>
            </div>

            {{-- Stats strip --}}
            <div class="row g-3 pt-4" style="border-top: 1px solid var(--c-border);">
              <div class="col-4 text-center">
                <div class="cis-stat-n">1,500+</div>
                <div class="cis-stat-l">Instalaciones</div>
              </div>
              <div class="col-4 text-center">
                <div class="cis-stat-n">98%</div>
                <div class="cis-stat-l">Satisfacción</div>
              </div>
              <div class="col-4 text-center">
                <div class="cis-stat-n">15 años</div>
                <div class="cis-stat-l">Experiencia</div>
              </div>
            </div>
          </div>

          {{-- Columna derecha: imagen --}}
          <div class="col-lg-6">
            <div class="cis-hero-img">
              <img src="https://images.pexels.com/photos/9875445/pexels-photo-9875445.jpeg?auto=compress&cs=tinysrgb&w=1200"
                   alt="Paneles solares en techo">
              <div class="cis-float-a">
                <i class="bi bi-sun-fill" style="font-size:1.4rem; color:var(--c-accent);"></i>
                <div class="cis-stat-n" style="font-size:1.5rem;">-90%</div>
                <small style="font-size:.7rem; color:var(--c-muted); display:block;">Ahorro en luz</small>
              </div>
              <div class="cis-float-b">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-check-circle-fill" style="color:var(--c-success);"></i>
                  <strong style="font-size:.84rem;">Instalación rápida</strong>
                </div>
                <p class="mb-0" style="font-size:.78rem; color:var(--c-muted);">
                  Tu sistema solar operando en <strong style="color:var(--bs-primary);">3–5 días</strong>.
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         PRODUCTOS DESTACADOS
    ═══════════════════════════════════════ --}}
    <section class="py-5" style="background:var(--c-light);" id="productos">
      <div class="container">
        <div class="text-center mb-5">
          <p class="cis-eyebrow mb-2">Catálogo</p>
          <h2 class="cis-sec-title mb-2">Paneles solares destacados</h2>
          <p style="color:var(--c-muted);">Encuentra la solución perfecta para tu hogar o negocio</p>
        </div>

        <!-- <ul class="nav cis-tabs justify-content-center mb-5" id="productTabs" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#residencial" type="button">
              <i class="bi bi-house-fill me-1"></i>Residencial
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#comercial" type="button">
              <i class="bi bi-building me-1"></i>Comercial
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#industrial" type="button">
              <i class="bi bi-gear-fill me-1"></i>Industrial
            </button>
          </li>
        </ul> -->

        <div class="tab-content" id="productTabsContent">

          {{-- Residencial --}}
          <div class="tab-pane fade show active" id="residencial" role="tabpanel">
              <div class="swiper productos-swiper">
                  <div class="swiper-wrapper">
                      @foreach($productos as $prod)
                      @php
                        $comentarios_total_pproducto = DB::table('comments')->select(DB::raw('count(id) as contador, sum(valoracion) as valoraciones'))->where('producto_id',$prod->id)->first();
                        if($comentarios_total_pproducto){
                            $valoracion_pproducto = $comentarios_total_pproducto->valoraciones == 0 ? 0: $comentarios_total_pproducto->valoraciones/$comentarios_total_pproducto->contador;
                            $calificacion_pproducto = $comentarios_total_pproducto->contador == 0 ? 0:round(($comentarios_total_pproducto->valoraciones/$comentarios_total_pproducto->contador),1);
                        }else{
                            $valoracion_pproducto = 0;
                            $calificacion_pproducto = 0;
                        }
                      @endphp
                      <div class="swiper-slide">
                          <div class="cis-prod">
                              <div class="cis-prod-img" style="background-image: url('{{ $prod->imagen ? asset('images/productos/' . $prod->imagen) : '' }}');">
                                  <span class="cis-prod-badge" style="
                                      background: rgba(var(--bs-primary-rgb),.85); 
                                      color: #fff;
                                      display: -webkit-box;
                                      -webkit-line-clamp: 2;
                                      -webkit-box-orient: vertical;
                                      overflow: hidden;
                                      font-size: 0.75rem;
                                      line-height: 1.2;
                                      max-width: 90%;
                                  ">
                                      {{ $prod->categorie->name }}
                                  </span>
                              </div>
                              <div class="cis-prod-body">
                                  <div class="cis-prod-stars">
                                      @if($valoracion_pproducto)
                                      <!--Valoracion de estrellas por producto-->
                                          @if($valoracion_pproducto > 0 && $valoracion_pproducto < 1)
                                              <i class="bi bi-star-half"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto == 1)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto > 1 && $valoracion_pproducto < 2)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-half"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto == 2)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto > 2 && $valoracion_pproducto < 3)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-half"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto == 3)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto > 3 && $valoracion_pproducto < 4)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-half"></i>
                                              <i class="bi bi-star"></i>
                                          @endif
                                          @if($valoracion_pproducto == 4)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star"></i>       
                                          @endif
                                          @if($valoracion_pproducto > 4 && $valoracion_pproducto < 5)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-half"></i>
                                          @endif
                                          @if($valoracion_pproducto == 5)
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                              <i class="bi bi-star-fill"></i>
                                          @endif
                                      <!--FIN - Valoracion de estrellas por producto-->
                                    @else
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                    @endif
                                      <small class="ms-1" style="color:var(--c-muted);">( {{$comentarios_total_pproducto->contador > 1 ? $comentarios_total_pproducto->contador : $comentarios_total_pproducto->contador}} )</small>
                                  </div>
                                  <div class="cis-prod-title">{{$prod->name}}</div>
                                  <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> {{$prod->potencia_nominal?$prod->potencia_nominal: '--'}} &nbsp;·&nbsp; <i class="bi bi-shield-check"></i> {{$prod->garantias? $prod->garantias: '--'}}</div>
                                  <div class="d-flex align-items-center gap-2">
                                      <span class="cis-prod-price">S/ {{$prod->precio_descuento != '' ? $prod->precio_descuento : $prod->precio}}</span>
                                      @if($prod->precio_descuento == '' || $prod->precio_descuento == 0)
                                      @else
                                          <span class="cis-prod-old">S/ {{$prod->precio}}</span>
                                          <span class="cis-prod-disc">-{{$prod->porcentaje}}%</span>
                                      @endif
                                  </div>
                                  <div class="cis-prod-actions">
                                      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                                      <a href="/product/{{$prod->slug}}" class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      @endforeach
                  </div>
                  <!-- Navegación -->
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-pagination"></div>
              </div>
          </div>

          {{-- Comercial --}}
          <div class="tab-pane fade" id="comercial" role="tabpanel">
            <div class="row g-4 justify-content-center">

              <div class="col-lg-4 col-md-6">
                <div class="cis-prod">
                  <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/159397/solar-panel-array-power-sun-electricity-159397.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85); color:#fff;">Comercial</span>
                  </div>
                  <div class="cis-prod-body">
                    <div class="cis-prod-stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                      <small class="ms-1" style="color:var(--c-muted);">(67)</small>
                    </div>
                    <div class="cis-prod-title">Sistema Solar 10kW Trifásico</div>
                    <div class="cis-prod-spec">Ideal para pequeños negocios y locales comerciales.</div>
                    <div class="d-flex align-items-center gap-2">
                      <span class="cis-prod-price">S/ 18,500.00</span>
                    </div>
                    <div class="cis-prod-actions">
                      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                      <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6">
                <div class="cis-prod">
                  <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85); color:#fff;">Comercial</span>
                  </div>
                  <div class="cis-prod-body">
                    <div class="cis-prod-stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <small class="ms-1" style="color:var(--c-muted);">(92)</small>
                    </div>
                    <div class="cis-prod-title">Sistema Solar 20kW Comercial</div>
                    <div class="cis-prod-spec">Para medianas empresas con consumo elevado.</div>
                    <div class="d-flex align-items-center gap-2">
                      <span class="cis-prod-price">S/ 32,900.00</span>
                    </div>
                    <div class="cis-prod-actions">
                      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                      <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          {{-- Industrial --}}
          <div class="tab-pane fade" id="industrial" role="tabpanel">
            <div class="row g-4 justify-content-center">

              <div class="col-lg-4 col-md-6">
                <div class="cis-prod">
                  <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="cis-prod-badge" style="background:var(--bs-primary); color:#fff;">Industrial</span>
                  </div>
                  <div class="cis-prod-body">
                    <div class="cis-prod-stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                      <small class="ms-1" style="color:var(--c-muted);">(45)</small>
                    </div>
                    <div class="cis-prod-title">Panel Solar 550W Industrial</div>
                    <div class="cis-prod-spec">Diseñado para proyectos de gran escala.</div>
                    <div class="d-flex align-items-center gap-2">
                      <span class="cis-prod-price">S/ 1,150.00</span>
                    </div>
                    <div class="cis-prod-actions">
                      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                      <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6">
                <div class="cis-prod">
                  <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=600');">
                    <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85); color:#fff;">Industrial</span>
                  </div>
                  <div class="cis-prod-body">
                    <div class="cis-prod-stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <small class="ms-1" style="color:var(--c-muted);">(38)</small>
                    </div>
                    <div class="cis-prod-title">Sistema Solar 50kW Industrial</div>
                    <div class="cis-prod-spec">Solución completa para industrias.</div>
                    <div class="d-flex align-items-center gap-2">
                      <span class="cis-prod-price">S/ 75,000.00</span>
                    </div>
                    <div class="cis-prod-actions">
                      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                      <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>{{-- /tab-content --}}

        <div class="text-center mt-5">
          <a href="/products" class="btn btn-primary btn-lg rounded-pill px-5">
            <i class="bi bi-grid-3x3-gap me-2"></i>Ver todos los productos
          </a>
        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         SERVICIO DE INSTALACIÓN
    ═══════════════════════════════════════ --}}
    <section class="py-5 bg-white" id="instalacion">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <p class="cis-eyebrow cis-eyebrow-left mb-2">Nuestro servicio</p>
            <h2 class="cis-sec-title mb-3">Servicio de instalación certificada</h2>
            <p style="font-size:1.02rem; max-width:460px; color:var(--c-muted); margin-bottom:1.5rem;">
              Nuestro equipo técnico se encarga de todo: diseño, instalación, configuración y capacitación para que puedas monitorear tu consumo.
            </p>

            <div class="cis-step">
              <div class="cis-step-icon"><i class="bi bi-clipboard-check"></i></div>
              <div>
                <strong style="color:var(--bs-primary);">Visita técnica y evaluación del sitio</strong>
                <p class="mb-0 mt-1 small" style="color:var(--c-muted);">Evaluamos tu espacio y consumo sin costo alguno</p>
              </div>
            </div>
            <div class="cis-step">
              <div class="cis-step-icon"><i class="bi bi-diagram-3"></i></div>
              <div>
                <strong style="color:var(--bs-primary);">Diseño personalizado según tu consumo</strong>
                <p class="mb-0 mt-1 small" style="color:var(--c-muted);">Sistema optimizado para tu necesidad específica</p>
              </div>
            </div>
            <div class="cis-step">
              <div class="cis-step-icon"><i class="bi bi-tools"></i></div>
              <div>
                <strong style="color:var(--bs-primary);">Instalación segura y certificada</strong>
                <p class="mb-0 mt-1 small" style="color:var(--c-muted);">Técnicos certificados con años de experiencia</p>
              </div>
            </div>
            <div class="cis-step">
              <div class="cis-step-icon"><i class="bi bi-headset"></i></div>
              <div>
                <strong style="color:var(--bs-primary);">Soporte post-venta y mantenimiento</strong>
                <p class="mb-0 mt-1 small" style="color:var(--c-muted);">Atención permanente y mantenimiento preventivo</p>
              </div>
            </div>

            <div class="mt-4">
              <a href="#contacto" class="btn btn-primary btn-lg rounded-pill px-4">
                <i class="bi bi-calendar-check me-2"></i>Agendar visita técnica
              </a>
            </div>
          </div>

          <div class="col-lg-6">
            <div style="border-radius:20px; overflow:hidden; box-shadow:0 24px 64px rgba(var(--bs-primary-rgb),.14);">
              <img src="https://images.pexels.com/photos/9875450/pexels-photo-9875450.jpeg?auto=compress&cs=tinysrgb&w=1200"
                   class="w-100" style="height:420px; object-fit:cover; display:block;"
                   alt="Técnico instalando paneles solares">
            </div>
          </div>
        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         PROCESO DE COMPRA
    ═══════════════════════════════════════ --}}
    <section class="py-5" style="background:var(--c-light);" id="proceso">
      <div class="container">
        <div class="text-center mb-5">
          <p class="cis-eyebrow mb-2">Paso a paso</p>
          <h2 class="cis-sec-title mb-2">¿Cómo funciona nuestro proceso?</h2>
          <p style="color:var(--c-muted);">En 4 simples pasos tendrás tu sistema solar funcionando</p>
        </div>
        <div class="row g-4">

          <div class="col-md-3 cis-proc-sep">
            <div class="cis-proc">
              <div class="cis-proc-n">1</div>
              <i class="bi bi-phone"></i>
              <h5 class="fw-bold mb-2" style="color:var(--bs-primary);">Contacto Inicial</h5>
              <p class="mb-0 small" style="color:var(--c-muted);">Llámanos o completa el formulario. Te respondemos en menos de 24 horas.</p>
            </div>
          </div>

          <div class="col-md-3 cis-proc-sep">
            <div class="cis-proc">
              <div class="cis-proc-n">2</div>
              <i class="bi bi-house-check"></i>
              <h5 class="fw-bold mb-2" style="color:var(--bs-primary);">Evaluación Técnica</h5>
              <p class="mb-0 small" style="color:var(--c-muted);">Visitamos tu propiedad para evaluar el espacio y consumo eléctrico.</p>
            </div>
          </div>

          <div class="col-md-3 cis-proc-sep">
            <div class="cis-proc">
              <div class="cis-proc-n">3</div>
              <i class="bi bi-file-earmark-text"></i>
              <h5 class="fw-bold mb-2" style="color:var(--bs-primary);">Propuesta y Cotización</h5>
              <p class="mb-0 small" style="color:var(--c-muted);">Recibe una propuesta detallada con costos claros y tiempo de instalación.</p>
            </div>
          </div>

          <div class="col-md-3">
            <div class="cis-proc">
              <div class="cis-proc-n">4</div>
              <i class="bi bi-check-circle"></i>
              <h5 class="fw-bold mb-2" style="color:var(--bs-primary);">Instalación</h5>
              <p class="mb-0 small" style="color:var(--c-muted);">Instalamos tu sistema en 3–5 días y te capacitamos en su uso.</p>
            </div>
          </div>

        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         TESTIMONIOS
    ═══════════════════════════════════════ --}}
    <section class="py-5 bg-white">
      <div class="container">
        <div class="text-center mb-5">
          <p class="cis-eyebrow mb-2">Clientes satisfechos</p>
          <h2 class="cis-sec-title mb-2">Lo que dicen nuestros clientes</h2>
          <p style="color:var(--c-muted);">Más de 850 familias y empresas confían en nosotros</p>
        </div>
        <div class="row g-4">

          <div class="col-md-4">
            <div class="cis-testi">
              <span class="cis-testi-q">"</span>
              <p class="mb-3" style="color:var(--c-text-muted); font-size:.95rem;">Mi factura de luz bajó de S/450 a solo S/50 mensuales. La instalación fue rápida y profesional.</p>
              <div class="d-flex align-items-center gap-3">
                <div class="cis-avatar"><i class="bi bi-person-fill"></i></div>
                <div>
                  <strong style="color:var(--bs-primary); font-size:.88rem;">María González</strong>
                  <small style="color:var(--c-muted); display:block;">Lima, Perú</small>
                </div>
                <div class="ms-auto" style="color:var(--c-accent); font-size:.8rem;">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="cis-testi">
              <span class="cis-testi-q">"</span>
              <p class="mb-3" style="color:var(--c-text-muted); font-size:.95rem;">La mejor inversión que he hecho. El equipo técnico fue muy profesional y me explicaron todo el proceso.</p>
              <div class="d-flex align-items-center gap-3">
                <div class="cis-avatar"><i class="bi bi-person-fill"></i></div>
                <div>
                  <strong style="color:var(--bs-primary); font-size:.88rem;">Carlos Mendoza</strong>
                  <small style="color:var(--c-muted); display:block;">Arequipa, Perú</small>
                </div>
                <div class="ms-auto" style="color:var(--c-accent); font-size:.8rem;">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="cis-testi">
              <span class="cis-testi-q">"</span>
              <p class="mb-3" style="color:var(--c-text-muted); font-size:.95rem;">Instalamos un sistema de 15kW y estamos ahorrando más de S/2,000 mensuales. ¡Excelente retorno!</p>
              <div class="d-flex align-items-center gap-3">
                <div class="cis-avatar"><i class="bi bi-building"></i></div>
                <div>
                  <strong style="color:var(--bs-primary); font-size:.88rem;">Restaurante El Sol</strong>
                  <small style="color:var(--c-muted); display:block;">Cusco, Perú</small>
                </div>
                <div class="ms-auto" style="color:var(--c-accent); font-size:.8rem;">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         ALIADOS ESTRATÉGICOS
    ═══════════════════════════════════════ --}}
    <section class="py-5" style="background:var(--c-light);">
      <div class="container">
        <div class="text-center mb-5">
          <p class="cis-eyebrow mb-2">Colaboraciones de confianza</p>
          <h2 class="cis-sec-title mb-2">Nuestros Aliados Estratégicos</h2>
          <p style="color:var(--c-muted);">Nos aliamos con empresas líderes para brindar mejores soluciones.</p>
        </div>

        <div class="row g-3 justify-content-center">
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.vestas.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/VESTA.png" alt="Vestas"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cat.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/CAT.png" alt="CAT"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cropx.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/CRPOX.png" alt="Cropx"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.cip.org.pe/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/CIP.png" alt="CIP"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.jinkosolar.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/JINKO-SOLAR.png" alt="Jinko Solar"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.yinglisolar.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/YINGLI-SOLAR.png" alt="Yingli Solar"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.ethosenergygroup.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/ETHOS-ENERGY.png" alt="Ethos Energy"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.liugong.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/LIUGONG-1.png" alt="LiuGong"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.udep.edu.pe/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/UDEP.png" alt="UDEP"></div>
            </a>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="https://www.ulima.edu.pe/" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <div class="cis-partner"><img src="https://cisnergia.com/wp-content/uploads/2023/07/LIMAQ.png" alt="Limaq"></div>
            </a>
          </div>
        </div>

        <div class="text-center mt-5">
          <p class="small" style="color:var(--c-muted);">
            <i class="bi bi-shield-check me-1" style="color:var(--c-success);"></i>
            Productos certificados y respaldados por marcas líderes mundiales
          </p>
        </div>
      </div>
    </section>


    {{-- ═══════════════════════════════════════
         CTA + CONTACTO
    ═══════════════════════════════════════ --}}
    <section class="cis-cta" id="contacto">
      <div class="cis-blob cis-blob-1"></div>
      <div class="cis-blob cis-blob-2"></div>
      <div class="container position-relative text-white py-3">

        <div class="text-center mb-5">
          <p class="mb-2" style="font-size:.72rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:rgba(255,255,255,.45);">
            ¿Tienes dudas?
          </p>
          <h2 class="display-5 fw-bold mb-3">¿Listo para comenzar a ahorrar?</h2>
          <p class="mb-0" style="color:rgba(255,255,255,.7); font-size:1.05rem; max-width:480px; margin:0 auto;">
            Obtén una cotización gratuita en menos de 24 horas, sin ningún compromiso.
          </p>
        </div>

        <div class="row g-3 justify-content-center mb-5">
          <div class="col-sm-6 col-lg-3">
            <div class="cis-contact-card">
              <div class="cis-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
              <div>
                <strong style="font-size:.9rem;">Dirección</strong>
                <p class="mb-0 small mt-1" style="color:rgba(255,255,255,.65);">Av. Principal 123, San Isidro<br>Lima, Perú</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="cis-contact-card">
              <div class="cis-contact-icon"><i class="bi bi-telephone-fill"></i></div>
              <div>
                <strong style="font-size:.9rem;">Teléfono</strong>
                <p class="mb-0 small mt-1" style="color:rgba(255,255,255,.65);">+51 999 999 999<br>+51 (01) 234-5678</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="cis-contact-card">
              <div class="cis-contact-icon"><i class="bi bi-envelope-fill"></i></div>
              <div>
                <strong style="font-size:.9rem;">Email</strong>
                <p class="mb-0 small mt-1" style="color:rgba(255,255,255,.65);">ventas@cisnergia.pe<br>soporte@cisnergia.pe</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="cis-contact-card">
              <div class="cis-contact-icon" style="background:rgba(var(--c-success-rgb),.25); color:rgba(255,255,255,.9);">
                <i class="bi bi-clock-fill"></i>
              </div>
              <div>
                <strong style="font-size:.9rem;">Horario</strong>
                <p class="mb-0 small mt-1" style="color:rgba(255,255,255,.65);">Lun–Vie: 9 AM – 6 PM<br>Sáb: 9 AM – 1 PM</p>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="{{ route('ecommerce.contact') }}" class="btn btn-light btn-lg px-5 fw-bold" style="color:var(--bs-primary);">
            <i class="bi bi-envelope-fill me-2"></i>Ir al formulario de contacto
          </a>
          <a href="tel:+51999999999" class="btn btn-outline-light btn-lg px-4">
            <i class="bi bi-telephone-fill me-2"></i>Llamar ahora
          </a>
        </div>

      </div>
    </section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const productosSwiper = new Swiper('.productos-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        992: { slidesPerView: 4 },
    }
});
</script>
@endsection
