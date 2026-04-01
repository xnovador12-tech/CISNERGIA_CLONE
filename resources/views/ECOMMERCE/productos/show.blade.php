@extends('TEMPLATES.ecommerce')

@section('title', 'Catálogo de Productos Solares')

@section('content')
<!-- BREADCRUMB -->
<div class="pd-breadcrumb">
  <div class="container">
    <div class="pd-breadcrumb__inner">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
          <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}"><i class="bi bi-house me-1"></i>Inicio</a></li>
          <li class="breadcrumb-item"><a href="{{ route('ecommerce.products') }}">Productos</a></li>
          <li class="breadcrumb-item"><a href="#">Inversores</a></li>
          <li class="breadcrumb-item active" aria-current="page">Sungrow SH8.0RT</li>
        </ol>
      </nav>
      <h1 class="pd-page-title">Sungrow SH8.0RT &mdash; <span>Inversor Híbrido 8 kW</span></h1>
    </div>
  </div>
</div>

<!-- DETALLE DEL PRODUCTO -->
<section class="pd-section">
  <div class="container">
    <div class="row g-5">

      <!-- ── GALERÍA ── -->
      <div class="col-lg-5">
        <div class="pd-gallery">

          <!-- Imagen principal -->
          <div class="pd-gallery__main">
            <img id="mainImage"
                 src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=800"
                 class="pd-gallery__img" alt="Sungrow SH8.0RT">
            <span class="pd-stock-badge"><i class="bi bi-check-circle-fill me-1"></i>En stock</span>
            <button class="pd-wish-fab" aria-label="Añadir a favoritos"><i class="bi bi-heart"></i></button>
          </div>

          <!-- Miniaturas -->
          <div class="pd-thumbs">
            <button class="pd-thumb active" onclick="pdImg(this,'https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Vista 1">
            </button>
            <button class="pd-thumb" onclick="pdImg(this,'https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Vista 2">
            </button>
            <button class="pd-thumb" onclick="pdImg(this,'https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=800')">
              <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Vista 3">
            </button>
          </div>

          <!-- Sellos de confianza -->
          <div class="row g-2 mt-1">
            <div class="col-6">
              <div class="cis-step py-2 px-2" style="margin-bottom:0;">
                <div class="cis-step-icon" style="width:34px;height:34px;font-size:.9rem;"><i class="bi bi-shield-check"></i></div>
                <div><small class="fw-semibold" style="font-size:.75rem;color:var(--c-text);">10 años garantía</small></div>
              </div>
            </div>
            <div class="col-6">
              <div class="cis-step py-2 px-2" style="margin-bottom:0;">
                <div class="cis-step-icon" style="width:34px;height:34px;font-size:.9rem;"><i class="bi bi-award"></i></div>
                <div><small class="fw-semibold" style="font-size:.75rem;color:var(--c-text);">Certificado int.</small></div>
              </div>
            </div>
            <div class="col-6">
              <div class="cis-step py-2 px-2" style="margin-bottom:0;">
                <div class="cis-step-icon" style="width:34px;height:34px;font-size:.9rem;"><i class="bi bi-truck"></i></div>
                <div><small class="fw-semibold" style="font-size:.75rem;color:var(--c-text);">Envío disponible</small></div>
              </div>
            </div>
            <div class="col-6">
              <div class="cis-step py-2 px-2" style="margin-bottom:0;">
                <div class="cis-step-icon" style="width:34px;height:34px;font-size:.9rem;"><i class="bi bi-tools"></i></div>
                <div><small class="fw-semibold" style="font-size:.75rem;color:var(--c-text);">Instalación prof.</small></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── INFO ── -->
      <div class="col-lg-7">

        <!-- Marca -->
        <div class="pd-brand">SUNGROW</div>

        <!-- Título -->
        <h1 class="pd-title">Sungrow SH8.0RT Inversor Híbrido 8 KW 3 Fases 2 MPPT</h1>

        <!-- Valoraciones -->
        <div class="pd-rating">
          <div class="pd-stars">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <span class="pd-rating__score">5.0</span>
          <span class="pd-rating__sep">·</span>
          <a href="#reviews" class="pd-rating__link">5 valoraciones</a>
        </div>

        <!-- Disponibilidad -->
        <div class="pd-availability">
          <span class="pd-avail--ok"><i class="bi bi-check-circle-fill me-1"></i>8 unidades disponibles</span>
        </div>
        <div class="pd-stock-bar"><div class="pd-stock-bar__fill"></div></div>

        <!-- Precio -->
        <div class="pd-price-box">
          <div class="pd-price__top">
            <span class="pd-price__original">S/ 4,899</span>
            <span class="pd-price__badge">-18% OFF</span>
          </div>
          <div class="pd-price__current">S/ 4,015</div>
          <div class="pd-price__note">Precio por unidad · Incluye IGV</div>
          <div class="pd-price__save"><i class="bi bi-tag-fill me-1"></i>Ahorras S/ 884 con esta oferta</div>
          <div class="pd-price__installment">o <strong>6 cuotas de S/ 669</strong> sin interés &middot; Visa / MC</div>
          <div class="pd-price__roi">
            <i class="bi bi-sun-fill me-1"></i>
            Ahorro estimado: <strong>~S/ 180/mes</strong> en factura el&eacute;ctrica &middot; ROI en ~5 a&ntilde;os
          </div>
        </div>

        <!-- Specs chips -->
        <div class="pd-specs">
          <div class="pd-spec">
            <i class="bi bi-lightning-charge-fill"></i>
            <span class="pd-spec__label">Potencia DC</span>
            <span class="pd-spec__val">12.0 kW</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-cpu-fill"></i>
            <span class="pd-spec__label">Potencia AC</span>
            <span class="pd-spec__val">8.0 kW</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-diagram-3-fill"></i>
            <span class="pd-spec__label">MPPT</span>
            <span class="pd-spec__val">2 und.</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-speedometer2"></i>
            <span class="pd-spec__label">Eficiencia</span>
            <span class="pd-spec__val">97.9%</span>
          </div>
        </div>

        <!-- Descripción corta -->
        <p class="pd-short-desc">
          Convierte la energía solar en ahorro real para tu hogar o negocio. Compatible con baterías
          <strong>SBR series de Sungrow</strong>, permite almacenar el excedente solar y usarlo en
          horario nocturno &mdash; maximizando tu independencia de la red eléctrica.
        </p>

        <!-- Cantidad -->
        <div class="pd-qty">
          <span class="pd-qty__label">Cantidad:</span>
          <div class="pd-qty__ctrl">
            <button type="button" onclick="pdQty(-1)" aria-label="Reducir">−</button>
            <input type="number" id="pdQtyVal" value="1" min="1" max="8" readonly>
            <button type="button" onclick="pdQty(1)" aria-label="Aumentar">+</button>
          </div>
          <small style="color:var(--c-muted);">Máx. 8 por pedido</small>
        </div>

        <!-- CTA -->
        <div class="d-flex gap-2 mb-2">
          <button type="button" class="btn btn-primary btn-lg flex-fill">
            <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
          </button>
          <button type="button" class="btn btn-outline-secondary btn-lg" style="width:54px;" aria-label="Añadir a favoritos">
            <i class="bi bi-heart"></i>
          </button>
        </div>
        <button type="button" class="btn btn-lg w-100 pd-btn-wa">
          <i class="bi bi-whatsapp me-2"></i>Comprar por WhatsApp
        </button>

        <!-- Beneficios solares -->
        <div class="pd-benefits">
          <div class="pd-benefit">
            <i class="bi bi-sun-fill" style="color:var(--c-accent);"></i>
            <div>
              <strong>~10,500 kWh/año de generación</strong>
              <small>Óptimo para instalaciones residenciales y comerciales</small>
            </div>
          </div>
          <div class="pd-benefit">
            <i class="bi bi-battery-charging" style="color:var(--bs-secondary);"></i>
            <div>
              <strong>Compatible con baterías SBR series</strong>
              <small>Almacenamiento de hasta 25.6 kWh con Sungrow</small>
            </div>
          </div>
          <div class="pd-benefit">
            <i class="bi bi-phone-fill" style="color:var(--bs-secondary);"></i>
            <div>
              <strong>Monitoreo en tiempo real</strong>
              <small>App iSolarCloud gratuita para iOS y Android</small>
            </div>
          </div>
        </div>

        <!-- Métodos de pago -->
        <div class="pd-payment">
          <small>Aceptamos:</small>
          <span class="pd-pay-badge">VISA</span>
          <span class="pd-pay-badge">MASTERCARD</span>
          <span class="pd-pay-badge">Yape</span>
          <span class="pd-pay-badge">Plin</span>
          <span class="pd-pay-badge">Transferencia</span>
        </div>

        <!-- Tabs de información -->
        <div class="pd-tabs mt-4">
          <div class="pd-tabs__nav">
            <button class="pd-tab active" onclick="pdTab(this,'pd-description')">Descripción</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-specs')">Especificaciones</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-dimensions')">Dimensiones</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-downloads')">Descargas</button>
          </div>

          <!-- Descripción -->
          <div class="pd-tabpanel" id="pd-description">
            <p class="pd-tab__text">
              El inversor híbrido SH8.0RT de Sungrow es una solución avanzada para sistemas solares fotovoltaicos 
              con almacenamiento de energía. Combina la funcionalidad de un inversor solar con un cargador de baterías, 
              permitiendo maximizar el autoconsumo y la independencia energética.
            </p>
            <p class="pd-tab__text">
              Su diseño trifásico y 2 seguidores MPPT permiten una instalación flexible y aprovechamiento óptimo 
              de la energía solar en diferentes orientaciones de tejado.
            </p>
            <h6 class="pd-tab__subtitle">Características destacadas</h6>
            <ul class="pd-tab__list">
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
          <div class="pd-tabpanel d-none" id="pd-specs">
            <h6 class="pd-tab__subtitle">DC (Entrada)</h6>
            <div class="pd-spec-table">
              <div class="pd-spec-row"><span>Potencia máxima</span><span>12.0 kW</span></div>
              <div class="pd-spec-row"><span>Corriente máxima</span><span>25.0 A</span></div>
              <div class="pd-spec-row"><span>Tensión nominal</span><span>600 V</span></div>
              <div class="pd-spec-row"><span>Tensión máxima</span><span>1,000 V</span></div>
              <div class="pd-spec-row"><span>Número de MPPT</span><span>2</span></div>
              <div class="pd-spec-row"><span>Entradas de cadena</span><span>2</span></div>
            </div>
            <h6 class="pd-tab__subtitle mt-4">AC (Salida)</h6>
            <div class="pd-spec-table">
              <div class="pd-spec-row"><span>Potencia nominal</span><span>8.0 kW</span></div>
              <div class="pd-spec-row"><span>Potencia máxima</span><span>8.0 kW</span></div>
              <div class="pd-spec-row"><span>Corriente nominal</span><span>11.6 A</span></div>
              <div class="pd-spec-row"><span>Corriente máxima</span><span>12.1 A</span></div>
              <div class="pd-spec-row"><span>Fases</span><span>3 Fases</span></div>
              <div class="pd-spec-row"><span>Eficiencia máxima</span><span>97.9%</span></div>
            </div>
          </div>

          <!-- Dimensiones -->
          <div class="pd-tabpanel d-none" id="pd-dimensions">
            <div class="pd-spec-table">
              <div class="pd-spec-row"><span>Ancho</span><span>460 mm</span></div>
              <div class="pd-spec-row"><span>Alto</span><span>540 mm</span></div>
              <div class="pd-spec-row"><span>Profundidad</span><span>170 mm</span></div>
              <div class="pd-spec-row"><span>Peso</span><span>27 kg</span></div>
              <div class="pd-spec-row"><span>Grado de protección</span><span>IP65 (exterior)</span></div>
              <div class="pd-spec-row"><span>Temperatura</span><span>-25°C a +60°C</span></div>
            </div>
            <div class="pd-info-note mt-3">
              <i class="bi bi-info-circle-fill"></i>
              <span>Se recomienda instalación en área protegida de lluvia directa y con ventilación adecuada.</span>
            </div>
          </div>

          <!-- Descargas -->
          <div class="pd-tabpanel d-none" id="pd-downloads">
            <div class="pd-download-list">
              <a href="#" class="pd-download">
                <div class="pd-download__icon pd-download__icon--pdf"><i class="bi bi-file-earmark-pdf"></i></div>
                <div class="pd-download__info">
                  <span class="pd-download__name">Ficha Técnica</span>
                  <span class="pd-download__desc">Especificaciones completas del producto</span>
                </div>
                <i class="bi bi-download pd-download__arrow"></i>
              </a>
              <a href="#" class="pd-download">
                <div class="pd-download__icon pd-download__icon--pdf"><i class="bi bi-file-earmark-pdf"></i></div>
                <div class="pd-download__info">
                  <span class="pd-download__name">Manual de Instalación</span>
                  <span class="pd-download__desc">Guía paso a paso para la instalación</span>
                </div>
                <i class="bi bi-download pd-download__arrow"></i>
              </a>
              <a href="#" class="pd-download">
                <div class="pd-download__icon pd-download__icon--pdf"><i class="bi bi-file-earmark-pdf"></i></div>
                <div class="pd-download__info">
                  <span class="pd-download__name">Manual de Usuario</span>
                  <span class="pd-download__desc">Instrucciones de uso y mantenimiento</span>
                </div>
                <i class="bi bi-download pd-download__arrow"></i>
              </a>
              <a href="#" class="pd-download">
                <div class="pd-download__icon pd-download__icon--cert"><i class="bi bi-file-earmark-text"></i></div>
                <div class="pd-download__info">
                  <span class="pd-download__name">Certificados</span>
                  <span class="pd-download__desc">Certificaciones internacionales</span>
                </div>
                <i class="bi bi-download pd-download__arrow"></i>
              </a>
            </div>
          </div>

        </div><!-- /.pd-tabs -->
      </div><!-- /.col-lg-7 -->
    </div><!-- /.row -->
  </div>
</section>

<!-- MÉTRICAS SOLARES -->
<section class="pd-solar-banner">
  <div class="container">
    <div class="text-center mb-5">
      <p class="pd-solar-eyebrow">Por qué elegir energía solar</p>
      <h2 class="pd-solar-title">El inversor que transforma tu factura eléctrica</h2>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-4 col-md-6">
        <div class="pd-metric">
          <div class="pd-metric__icon"><i class="bi bi-lightning-charge-fill"></i></div>
          <div class="pd-metric__val">~10,500 kWh</div>
          <div class="pd-metric__lbl">Producción anual estimada</div>
          <div class="pd-metric__sub">Con 8 paneles de 400W en Lima</div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="pd-metric pd-metric--accent">
          <div class="pd-metric__icon"><i class="bi bi-currency-exchange"></i></div>
          <div class="pd-metric__val">~S/ 180/mes</div>
          <div class="pd-metric__lbl">Ahorro en factura eléctrica</div>
          <div class="pd-metric__sub">Hasta 90% de reducción en tu consumo</div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="pd-metric">
          <div class="pd-metric__icon"><i class="bi bi-graph-up-arrow"></i></div>
          <div class="pd-metric__val">~5 años</div>
          <div class="pd-metric__lbl">Retorno de inversión</div>
          <div class="pd-metric__sub">Y 25+ años de generación gratuita</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- INSTALACIÓN PROFESIONAL -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-lg-7">
        <p class="cis-eyebrow cis-eyebrow-left mb-2">Servicio integral</p>
        <h2 class="cis-sec-title mb-3">¿Necesitas instalación profesional?</h2>
        <p style="color:var(--c-muted);max-width:520px;margin-bottom:1.75rem;">
          Nuestro equipo certificado se encarga de todo: desde la visita técnica hasta la conexión
          a la red. Sin complicaciones, sin demoras.
        </p>

        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3">
            <div class="pd-install-step">
              <div class="pd-install-step__num">1</div>
              <div class="pd-install-step__txt">Cotización gratuita</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="pd-install-step">
              <div class="pd-install-step__num">2</div>
              <div class="pd-install-step__txt">Visita técnica</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="pd-install-step">
              <div class="pd-install-step__num">3</div>
              <div class="pd-install-step__txt">Instalación en 7&ndash;15 días</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="pd-install-step">
              <div class="pd-install-step__num">4</div>
              <div class="pd-install-step__txt">Activación y monitoreo</div>
            </div>
          </div>
        </div>

        <a href="{{ route('ecommerce.installation') }}" class="btn btn-primary btn-lg me-2">
          <i class="bi bi-tools me-2"></i>Ver servicio de instalación
        </a>
        <a href="{{ route('ecommerce.contact') }}" class="btn btn-outline-secondary btn-lg">
          <i class="bi bi-chat-dots me-2"></i>Cotizar ahora
        </a>
      </div>

      <div class="col-lg-5 d-none d-lg-block">
        <div class="pd-install-media">
          <img src="https://images.pexels.com/photos/9875394/pexels-photo-9875394.jpeg?auto=compress&cs=tinysrgb&w=700" alt="Instalación solar profesional">
          <div class="pd-install-chip">
            <i class="bi bi-clock-fill" style="color:var(--c-accent);"></i>
            <div>
              <strong>7&ndash;15 días</strong>
              <small>Tiempo de instalación</small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- REVIEWS -->
<section class="pd-rv-section" id="reviews">
  <div class="container">

    <!-- Cabecera -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
      <div>
        <p class="cis-eyebrow cis-eyebrow-left mb-1">Valoraciones</p>
        <h2 class="cis-sec-title mb-0">Opiniones de clientes</h2>
      </div>
      @auth
        <button type="button" class="btn btn-primary rounded-pill px-4"
                data-bs-toggle="modal" data-bs-target="#modalReview">
          <i class="bi bi-pencil-square me-2"></i>Escribir una opinión
        </button>
      @else
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                data-bs-toggle="modal" data-bs-target="#iniciar_sesion"
                title="Inicia sesión para dejar una opinión">
          <i class="bi bi-lock me-2"></i>Inicia sesión para opinar
        </button>
      @endauth
    </div>

    <div class="row g-5 align-items-start">

      <!-- Panel de puntuación -->
      <div class="col-lg-4 col-xl-3">
        <div class="pd-rv-score">
          <div class="pd-rv-score__num">5.0</div>
          <div class="pd-rv-score__stars">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="pd-rv-score__count">10 valoraciones verificadas</p>

          <!-- Distribución -->
          <div class="pd-rv-dist">
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">5 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:80%"></div></div>
              <span class="pd-rv-dist__n">8</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">4 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:20%"></div></div>
              <span class="pd-rv-dist__n">2</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">3 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">0</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">2 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">0</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">1 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">0</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjetas -->
      <div class="col-lg-8 col-xl-9">
        <div class="d-flex flex-column gap-3">

          <!-- Review 1 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,var(--bs-primary),var(--bs-secondary));">JP</div>
                <div>
                  <strong class="pd-rv-card__name">Juan Pérez</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">15 Nov 2025 &middot; Lima, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Excelente inversor híbrido, 100% recomendado</h6>
            <p class="pd-rv-card__text">Muy satisfecho con la compra. El inversor funciona perfectamente y la eficiencia es excelente. La instalación fue sencilla y el monitoreo remoto a través de la app iSolarCloud funciona muy bien. La factura eléctrica bajó más de S/ 200.</p>
          </div>

          <!-- Review 2 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#003E64,#0ea5e9);">MG</div>
                <div>
                  <strong class="pd-rv-card__name">María García</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">8 Nov 2025 &middot; Arequipa, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Calidad premium, cumple todas las expectativas</h6>
            <p class="pd-rv-card__text">Producto de primera calidad. La marca Sungrow es confiable y este modelo cumple todas las expectativas. Altamente recomendado para proyectos residenciales. La instalación fue completada en menos de dos semanas.</p>
          </div>

          <!-- Review 3 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#1d4ed8,#0ea5e9);">RC</div>
                <div>
                  <strong class="pd-rv-card__name">Roberto Chuquihuanca</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">2 Nov 2025 &middot; Cusco, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Mi factura bajó de S/ 480 a S/ 60 al mes</h6>
            <p class="pd-rv-card__text">Tenía una factura eléctrica altisima por mi taller. Con este inversor y 10 paneles solares logré reducir casi el 90% de mi consumo. La instalación fue rápida y el equipo de Cisnergia explicó todo muy bien. Totalmente recomendado.</p>
          </div>

          <!-- Review 4 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#7c3aed,#6366f1);">AT</div>
                <div>
                  <strong class="pd-rv-card__name">Ana Torres</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">28 Oct 2025 &middot; Trujillo, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Muy buen inversor, instalación profesional</h6>
            <p class="pd-rv-card__text">Cuatro estrellas porque el proceso de permisos tomó un poco más de lo esperado, pero el producto en sí mismo es excelente. La app de monitoreo es muy intuitiva y me permite ver la producción en tiempo real desde mi celular.</p>
          </div>

          <!-- Review 5 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#059669,#10b981);">LV</div>
                <div>
                  <strong class="pd-rv-card__name">Luis Villanueva</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">20 Oct 2025 &middot; Piura, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Ideal para el norte del país, soporta alto calor</h6>
            <p class="pd-rv-card__text">Vivo en Piura donde el calor es intenso y tenía miedo de que el inversor se sobrecalentara. Lleva 6 meses funcionando perfectamente sin ningún inconveniente. La eficiencia sigue al 97%+. Excelente inversión a largo plazo.</p>
          </div>

          <!-- Review 6 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#b45309,#f59e0b);">CP</div>
                <div>
                  <strong class="pd-rv-card__name">Carmen Palacios</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">12 Oct 2025 &middot; Ica, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Mejor decisión para mi negocio familiar</h6>
            <p class="pd-rv-card__text">Tenemos una bodega y el gasto en electricidad era muy alto. Ahora generamos nuestra propia energía y el excedente se almacena en baterías. Las noches ya no son problema. Rápidamente recuperaré la inversión.</p>
          </div>

          <!-- Review 7 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#0F172A,#334155);">EM</div>
                <div>
                  <strong class="pd-rv-card__name">Eduardo Mamani</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">5 Oct 2025 &middot; Puno, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Funciona perfecto en altura y bajas temperaturas</h6>
            <p class="pd-rv-card__text">Estoy a 3,800 msnm y el inversor funciona excelente incluso con temperaturas bajo cero en las noches. La instalación estuvo a cargo del equipo de Cisnergia y todo salió perfecto. Gran producto para condiciones exigentes.</p>
          </div>

          <!-- Review 8 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#dc2626,#f87171);">SR</div>
                <div>
                  <strong class="pd-rv-card__name">Sofia Ríos</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">29 Sep 2025 &middot; Chiclayo, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Instalación impecable, soporte excelente</h6>
            <p class="pd-rv-card__text">El equipo de Cisnergia es muy profesional. Desde la visita técnica hasta la conexión final todo fue claro y ordenado. Ya llevamos 4 meses y no hemos tenido ningún problema. El soporte post-venta responde rápido ante cualquier duda.</p>
          </div>

          <!-- Review 9 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#0369a1,#38bdf8);">HQ</div>
                <div>
                  <strong class="pd-rv-card__name">Hugo Quispe</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">18 Sep 2025 &middot; Huancayo, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Muy satisfecho, aunque el manual es solo en inglés</h6>
            <p class="pd-rv-card__text">El inversor funciona de maravilla y la reducción en la factura es real. Mi única observación es que el manual físico viene en inglés y chino. El equipo de Cisnergia me guió en la configuración sin problema, pero sería mejor con manual en español.</p>
          </div>

          <!-- Review 10 -->
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              <div class="d-flex align-items-center gap-3">
                <div class="pd-rv-avatar" style="background:linear-gradient(135deg,#166534,#4ade80);">PF</div>
                <div>
                  <strong class="pd-rv-card__name">Patricia Flores</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">10 Sep 2025 &middot; Lima, Perú</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
            </div>
            <h6 class="pd-rv-card__title">Una inversión que se paga sola</h6>
            <p class="pd-rv-card__text">Llevo un año con el sistema solar instalado y los números son claros: ahorro S/ 2,100 anuales. En 5 años recuperé la inversión completa. Además contribuyo al medio ambiente. Si estás dudando, no lo pienses más. Vale cada sol invertido.</p>
          </div>

        </div><!-- /.d-flex -->

        <!-- Paginación -->
        <div class="d-flex align-items-center justify-content-between mt-4 pt-3" style="border-top:1px solid var(--c-border);">
          <small style="color:var(--c-muted);">Mostrando 10 de 10 valoraciones</small>
          <nav aria-label="Paginación de valoraciones">
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item active"><a class="page-link" href="#reviews">1</a></li>
              <li class="page-item disabled"><a class="page-link" href="#">2</a></li>
            </ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- PRODUCTOS RELACIONADOS -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <p class="cis-eyebrow cis-eyebrow-left mb-1">Relacionados</p>
        <h2 class="cis-sec-title mb-0">También te puede interesar</h2>
      </div>
      <a href="{{ route('ecommerce.products') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        Ver todos <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4">
      <!-- Producto relacionado 1 -->
      <div class="col-lg-3 col-md-6">
        <div class="cis-prod">
          <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400');">
            <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85);color:#fff;">Inversor</span>
          </div>
          <div class="cis-prod-body">
            <div class="cis-prod-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></div>
            <div class="cis-prod-title">Sungrow SH10RT-20</div>
            <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> 10kW · 3 Fases</div>
            <div class="d-flex align-items-center gap-2">
              <span class="cis-prod-price">S/ 5,250</span>
            </div>
            <div class="cis-prod-actions">
              <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
              <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 2 -->
      <div class="col-lg-3 col-md-6">
        <div class="cis-prod">
          <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400');">
            <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85);color:#fff;">Inversor</span>
          </div>
          <div class="cis-prod-body">
            <div class="cis-prod-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
            <div class="cis-prod-title">Sungrow SG10RT</div>
            <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> 10kW · Monofásico</div>
            <div class="d-flex align-items-center gap-2">
              <span class="cis-prod-price">S/ 4,890</span>
            </div>
            <div class="cis-prod-actions">
              <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
              <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 3 -->
      <div class="col-lg-3 col-md-6">
        <div class="cis-prod">
          <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=400');">
            <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85);color:#fff;">Inversor</span>
          </div>
          <div class="cis-prod-body">
            <div class="cis-prod-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></div>
            <div class="cis-prod-title">Sungrow SG7.0RT</div>
            <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> 7kW · 3 Fases</div>
            <div class="d-flex align-items-center gap-2">
              <span class="cis-prod-price">S/ 3,750</span>
            </div>
            <div class="cis-prod-actions">
              <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
              <button class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Producto relacionado 4 -->
      <div class="col-lg-3 col-md-6">
        <div class="cis-prod">
          <div class="cis-prod-img" style="background-image:url('https://images.pexels.com/photos/371900/pexels-photo-371900.jpeg?auto=compress&cs=tinysrgb&w=400');">
            <span class="cis-prod-badge" style="background:rgba(var(--c-accent-rgb),.9);color:var(--bs-primary);">Top Venta</span>
          </div>
          <div class="cis-prod-body">
            <div class="cis-prod-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
            <div class="cis-prod-title">Sungrow SG5.0RT</div>
            <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> 5kW · 3 Fases</div>
            <div class="d-flex align-items-center gap-2">
              <span class="cis-prod-price">S/ 2,990</span>
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
</section>

@auth
{{-- Modal para escribir una opinión (solo usuarios autenticados) --}}
<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius:1.25rem;overflow:hidden;">

      <!-- Header -->
      <div class="modal-header px-4 pt-4 pb-3 border-0" style="background:var(--c-bg);">
        <div>
          <h5 class="modal-title fw-800 mb-0" id="modalReviewLabel" style="color:var(--bs-primary);font-weight:800;">
            Deja tu opinión
          </h5>
          <small style="color:var(--c-muted);">
            Opinando como <strong style="color:var(--bs-secondary);">{{ Auth::user()->persona->name ?? Auth::user()->email }}</strong>
          </small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 pb-4" style="background:var(--c-bg);">
        <form action="#" method="POST">
          @csrf

          <!-- Puntuación con estrellas interactivas -->
          <div class="mb-4">
            <label class="form-label fw-semibold mb-2" style="color:var(--c-text);font-size:.88rem;">
              Puntuación <span class="text-danger">*</span>
            </label>
            <div class="pd-rv-star-input" id="starInput">
              <button type="button" data-val="1" onclick="setStars(1)"><i class="bi bi-star-fill"></i></button>
              <button type="button" data-val="2" onclick="setStars(2)"><i class="bi bi-star-fill"></i></button>
              <button type="button" data-val="3" onclick="setStars(3)"><i class="bi bi-star-fill"></i></button>
              <button type="button" data-val="4" onclick="setStars(4)"><i class="bi bi-star-fill"></i></button>
              <button type="button" data-val="5" onclick="setStars(5)"><i class="bi bi-star-fill"></i></button>
            </div>
            <input type="hidden" name="puntuacion" id="puntuacionInput" value="0">
            <small id="starLabel" style="color:var(--c-muted);font-size:.78rem;">Selecciona una puntuación</small>
          </div>

          <!-- Título -->
          <div class="mb-3">
            <label class="form-label fw-semibold" style="color:var(--c-text);font-size:.88rem;" for="rv_titulo">
              Título de tu opinión <span class="text-danger">*</span>
            </label>
            <input type="text" id="rv_titulo" name="titulo" class="form-control"
                   placeholder="Ej: Excelente producto, lo recomiendo" maxlength="100" required>
          </div>

          <!-- Comentario -->
          <div class="mb-4">
            <label class="form-label fw-semibold" style="color:var(--c-text);font-size:.88rem;" for="rv_comentario">
              Comentario <span class="text-danger">*</span>
            </label>
            <textarea id="rv_comentario" name="comentario" class="form-control" rows="4"
                      placeholder="Cuéntanos tu experiencia con el producto, la instalación, el ahorro energético..." 
                      maxlength="1000" required></textarea>
            <small style="color:var(--c-muted);font-size:.75rem;">Máximo 1000 caracteres. Tu opinión ayuda a otros compradores.</small>
          </div>

          <!-- Aviso compra verificada -->
          <div class="d-flex align-items-start gap-2 mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
            <i class="bi bi-patch-check-fill mt-1" style="color:#16a34a;font-size:.9rem;flex-shrink:0;"></i>
            <small style="color:#166534;line-height:1.5;">
              Tu opinión se publicará como <strong>Compra verificada</strong> al estar vinculada a tu cuenta.
            </small>
          </div>

          <!-- Acciones -->
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                    data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
              <i class="bi bi-send me-2"></i>Publicar opinión
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endauth

@endsection

@push('scripts')
<script>
function pdImg(btn, url) {
    document.getElementById('mainImage').src = url;
    document.querySelectorAll('.pd-thumb').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}
function pdTab(btn, panelId) {
    document.querySelectorAll('.pd-tab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.pd-tabpanel').forEach(p => p.classList.add('d-none'));
    btn.classList.add('active');
    document.getElementById(panelId).classList.remove('d-none');
}
function pdQty(delta) {
    const inp = document.getElementById('pdQtyVal');
    const val = Math.min(8, Math.max(1, parseInt(inp.value || 1) + delta));
    inp.value = val;
}

const starLabels = ['', 'Muy malo', 'Regular', 'Bueno', 'Muy bueno', 'Excelente'];
function setStars(val) {
    document.getElementById('puntuacionInput').value = val;
    document.getElementById('starLabel').textContent = starLabels[val];
    document.querySelectorAll('#starInput button').forEach((btn, i) => {
        btn.classList.toggle('active', i < val);
    });
}
</script>
@endpush