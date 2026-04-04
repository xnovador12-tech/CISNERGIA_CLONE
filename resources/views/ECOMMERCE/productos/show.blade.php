@extends('TEMPLATES.ecommerce')

@section('title', 'Catálogo de Productos Solares')
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
<!-- BREADCRUMB -->
<div class="pd-breadcrumb">
  <div class="container">
    <div class="pd-breadcrumb__inner">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
          <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}"><i class="bi bi-house me-1"></i>Inicio</a></li>
          <li class="breadcrumb-item"><a href="{{ route('ecommerce.products') }}">Productos</a></li>
          <li class="breadcrumb-item"><a href="#">Inversores</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$producto->marca->name}}</li>
        </ol>
      </nav>
      <h1 class="pd-page-title">{{$producto->marca->name}} &mdash; <span>{{$producto->name}}</span></h1>
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
              src="{{ $producto->imagen ? asset('images/productos/' . $producto->imagen) : asset('images/no-image.png') }}"
              class="pd-gallery__img" 
              alt="{{ $producto->name }}">
            <span class="pd-stock-badge"><i class="bi bi-check-circle-fill me-1"></i>En stock</span>
            <button class="pd-wish-fab" aria-label="Añadir a favoritos"><i class="bi bi-heart"></i></button>
          </div>

          <!-- Miniaturas -->
        <div class="pd-thumbs">
            @foreach($producto->images as $img)
                <button class="pd-thumb {{ $loop->first ? 'active' : '' }}" 
                        onclick="pdImg(this, '{{ asset($img->url) }}')">
                    <img src="{{ asset($img->url) }}" 
                        alt="Vista {{ $loop->iteration }}">
                </button>
            @endforeach
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
        <div class="pd-brand">{{$producto->marca->name}}</div>

        <!-- Título -->
        <h1 class="pd-title">{{$producto->name}}</h1>

        <!-- Valoraciones -->

            @php
            $distribucion = DB::table('comments')
                ->select('valoracion', DB::raw('count(*) as contador'))
                ->where('producto_id', $producto->id)
                ->groupBy('valoracion')
                ->get()
                ->keyBy('valoracion');

            $comentarios_total = DB::table('comments')->select(DB::raw('count(id) as contador, sum(valoracion) as valoraciones'))->where('producto_id',$producto->id)->first();
            if($comentarios_total){
                $valoracion = $comentarios_total->valoraciones == 0 ? 0: $comentarios_total->valoraciones/$comentarios_total->contador;
                $calificacion_ = $comentarios_total->contador == 0 ? 0:round(($comentarios_total->valoraciones/$comentarios_total->contador),1);
            }else{
                $valoracion = 0;
                $calificacion_ = 0;
            }
        @endphp
        <div class="pd-rating">
          <div class="pd-stars">
            @if($valoracion)
              <!--Valoracion de estrellas por producto-->
                  @if($valoracion > 0 && $valoracion < 1)
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 1)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 1 && $valoracion < 2)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 2)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 2 && $valoracion < 3)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 3)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 3 && $valoracion < 4)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 4)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>       
                  @endif
                  @if($valoracion > 4 && $valoracion < 5)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                  @endif
                  @if($valoracion == 5)
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
          </div>
          <span class="pd-rating__score">{{ $calificacion_ }}</span>
          <span class="pd-rating__sep">·</span>
          <a href="#reviews" class="pd-rating__link">{{$comentarios_total->contador > 1 ? $comentarios_total->contador . ' valoraciones' : $comentarios_total->contador . ' valoración'}}</a>
        </div>

        <!-- Disponibilidad -->
        <div class="pd-availability">
          <span class="pd-avail--ok"><i class="bi bi-check-circle-fill me-1"></i>{{ $producto->inventarios->sum('cantidad') > 1 ? $producto->inventarios->sum('cantidad').' unidades disponibles' : $producto->inventarios->sum('cantidad').' unidad disponible'}}</span>
        </div>
        <div class="pd-stock-bar"><div class="pd-stock-bar__fill"></div></div>

        <!-- Precio -->
        <div class="pd-price-box">
          @if($producto->precio_descuento == '' || $producto->precio_descuento == 0)
            <div class="pd-price__current">S/ {{$producto->precio}}</div>
          @else
            <div class="pd-price__top">
              <span class="pd-price__original">S/ {{$producto->precio}}</span>
              <span class="pd-price__badge">-{{ $producto->porcentaje }}% OFF</span>
            </div>
            <div class="pd-price__current">S/ {{$producto->precio_descuento}}</div>
          @endif
          <div class="pd-price__note">Precio por unidad · Incluye IGV</div>
          <div class="pd-price__save"><i class="bi bi-tag-fill me-1"></i>
          @if($producto->precio_descuento == '' || $producto->precio_descuento == 0)
          @else
            Ahorras S/ {{$producto->precio - $producto->precio_descuento}} con esta oferta
          @endif
          </div>
          <div class="pd-price__installment">o <strong>6 cuotas de S/ 669</strong> sin interés &middot; Visa / MC</div>
          <div class="pd-price__roi">
            <i class="bi bi-sun-fill me-1"></i>
            Ahorro estimado: <strong>~S/ 180/mes</strong> en factura el&eacute;ctrica &middot; ROI en ~5 a&ntilde;os
          </div>
        </div>

        <!-- Specs chips -->
        <div class="pd-specs">
          <div class="pd-spec">
            <i class="bi bi-lightning-charge-fill text-primary fs-3 mb-2"></i>
            <span class="pd-spec__label">Potencia Nominal</span>
            <span class="pd-spec__val">{{$producto->potencia_nominal}}</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-graph-up-arrow text-success fs-3 mb-2"></i>
            <span class="pd-spec__label">Eficiencia</span>
            <span class="pd-spec__val">{{$producto->eficiencia}}</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-grid-3x3 text-warning fs-3 mb-2"></i>
            <span class="pd-spec__label">Número de celdas</span>
            <span class="pd-spec__val">{{$producto->num_celdas}}</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-rulers text-secondary fs-3 mb-2"></i>
            <span class="pd-spec__label">Dimensiones</span>
            <span class="pd-spec__val">{{$producto->dimensiones}}</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-cpu text-info fs-3 mb-2"></i>
            <span class="pd-spec__label">Tipo Celulas</span>
            <span class="pd-spec__val">{{$producto->tipo_celulas}}</span>
          </div>
          <div class="pd-spec">
            <i class="bi bi-shield-check text-success fs-3 mb-2"></i>
            <span class="pd-spec__label">Garantía</span>
            <span class="pd-spec__val">{{$producto->garantia}}</span>
          </div>
        </div>

        <!-- Descripción corta -->
        <p class="pd-short-desc">
          {{$producto->descripcion}}
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
            <button class="pd-tab active" onclick="pdTab(this,'pd-datos')">Datos</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-garantias')">Garantias</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-ficha-tecnica')">Ficha Tecnica</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-descripcion')">Descripcion del Producto</button>
            <button class="pd-tab" onclick="pdTab(this,'pd-fabricante')">Fabricante</button>
          </div>

          <!-- datos -->
          <div class="pd-tabpanel" id="pd-datos">
              <div class="p-3 bg-white border rounded" style="min-height: 210px">
                  {!! $producto->datos !!}
              </div>
          </div>

          <!-- garantias -->
          <div class="pd-tabpanel d-none" id="pd-garantias">
              <div class="p-3 bg-white border rounded" style="min-height: 210px">
                  {!! $producto->garantias !!}
              </div>
          </div>

          <!-- Ficha tecnica -->
          <div class="pd-tabpanel d-none" id="pd-ficha-tecnica">
              <div class="p-3 bg-white border rounded" style="min-height: 210px">
                  {!! $producto->ficha_tecnica !!}
              </div>
          </div>

          <!-- descripcion -->
          <div class="pd-tabpanel d-none" id="pd-descripcion">
              <div class="p-3 bg-white border rounded" style="min-height: 210px">
                  {!! $producto->descripcion !!}
              </div>
          </div>

          <!-- Fabricante -->
          <div class="pd-tabpanel d-none" id="pd-fabricante">
              <div class="p-3 bg-white border rounded" style="min-height: 210px">
                  {!! $producto->fabricante !!}
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
          <div class="pd-rv-score__num">{{$calificacion_}}</div>
          <div class="pd-rv-score__stars">
            @if($valoracion)
              <!--Valoracion de estrellas por producto-->
                  @if($valoracion > 0 && $valoracion < 1)
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 1)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 1 && $valoracion < 2)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 2)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 2 && $valoracion < 3)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 3)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion > 3 && $valoracion < 4)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                      <i class="bi bi-star"></i>
                  @endif
                  @if($valoracion == 4)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star"></i>       
                  @endif
                  @if($valoracion > 4 && $valoracion < 5)
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                  @endif
                  @if($valoracion == 5)
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
          </div>
          <p class="pd-rv-score__count">{{$comentarios_total->contador > 1 ? $comentarios_total->contador . ' valoraciones verificadas' : $comentarios_total->contador . ' valoracion verificada'}}</p>

          <!-- Distribución -->
          <div class="pd-rv-dist">
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">5 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:80%"></div></div>
              <span class="pd-rv-dist__n">{{$distribucion[5]->contador ?? 0}}</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">4 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:20%"></div></div>
              <span class="pd-rv-dist__n">{{$distribucion[4]->contador ?? 0}}</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">3 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">{{$distribucion[3]->contador ?? 0}}</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">2 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">{{$distribucion[2]->contador ?? 0}}</span>
            </div>
            <div class="pd-rv-dist__row">
              <span class="pd-rv-dist__lbl">1 <i class="bi bi-star-fill"></i></span>
              <div class="pd-rv-dist__bar"><div style="width:0%"></div></div>
              <span class="pd-rv-dist__n">{{$distribucion[1]->contador ?? 0}}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjetas -->
      <div class="col-lg-8 col-xl-9">
        <div class="d-flex flex-column gap-3">

          <!-- Review 1 -->
        @foreach($comments_producto as $comments_productos)
          <div class="pd-rv-card">
            <div class="pd-rv-card__top">
              @php
                  $nombre   = $comments_productos->user->persona->name ?? '';
                  $apellido = $comments_productos->user->persona->surnames ?? '';
                  $autorNombreFinal = trim("$nombre $apellido");

                  $palabras = explode(' ', trim($autorNombreFinal));
                  $iniciales = strtoupper(substr($palabras[0] ?? '', 0, 1));
                  if(isset($palabras[1]) && !empty($palabras[1])) {
                      $iniciales .= strtoupper(substr($palabras[1], 0, 1));
                  }
                  if(empty(trim($iniciales))) $iniciales = '?';
              @endphp
              <div class="d-flex align-items-center gap-3">
              <div class="pd-rv-avatar" style="background:linear-gradient(135deg,var(--bs-primary),var(--bs-secondary));">
                  @if($comments_productos->user->persona->avatar)
                      <img src="/images/users/{{ $comments_productos->user->persona->avatar }}"
                          alt="{{ $autorNombreFinal }}"
                          style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                  @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($autorNombreFinal) }}&background=0F3460&color=fff&size=60&bold=true"
                          alt="{{ $autorNombreFinal }}"
                          style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                  @endif
              </div>
                <div>
                  <strong class="pd-rv-card__name">{{$autorNombreFinal}}</strong>
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="pd-rv-verified"><i class="bi bi-patch-check-fill me-1"></i>Compra verificada</span>
                    <span class="pd-rv-card__date">Hace aprox {{$comments_productos->created_at->diffForHumans(null, true) }}</span>
                  </div>
                </div>
              </div>
              <div class="pd-rv-card__stars">
                <div class="star__calificaciones text-warning me-2">
                  @if($comments_productos->valoracion > 0)
                      @if($comments_productos->valoracion == 1)
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                      @endif
                      @if($comments_productos->valoracion == 2)
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                      @endif
                      @if($comments_productos->valoracion == 3)
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star"></i>
                          <i class="bi bi-star"></i>
                      @endif
                      @if($comments_productos->valoracion == 4)
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star"></i>       
                      @endif
                      @if($comments_productos->valoracion == 5)
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                      @endif
                  @else
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                      <i class="bi bi-star"></i>
                  @endif
                </div>
              </div>
            </div>
            <h6 class="pd-rv-card__title">{{$comments_productos->titulo}}</h6>
            <p class="pd-rv-card__text">{{$comments_productos->comentario}}</p>
          </div>
        @endforeach
        </div><!-- /.d-flex -->

        <!-- Paginación -->
        <div class="d-flex align-items-center justify-content-between mt-4 pt-3" style="border-top:1px solid var(--c-border);">
          <small style="color:var(--c-muted);">
              Mostrando {{ $comments_producto->firstItem() ?? 0 }} - {{ $comments_producto->lastItem() ?? 0 }} 
              de {{ $comments_producto->total() }} valoraciones
          </small>
          <nav id="paginacion-blade" aria-label="Navegación de productos" class="mt-4">
              {{ $comments_producto->links() }}
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

    <!-- Producto relacionado 1 -->
    <div class="swiper productos-swiper">
      <div class="swiper-wrapper">
      @foreach($otros_productos as $otros_producto)
        @php
          $comentarios_total_pproducto = DB::table('comments')->select(DB::raw('count(id) as contador, sum(valoracion) as valoraciones'))->where('producto_id',$otros_producto->id)->first();
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
            <div class="cis-prod-img" style="background-image:url('{{ $otros_producto->imagen ? asset('images/productos/' . $otros_producto->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=400');" alt="{{$otros_producto->name}}">
              <span class="cis-prod-badge" style="background:rgba(var(--bs-primary-rgb),.85);color:#fff;">Inversor</span>
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
              </div>
              <div class="cis-prod-title">{{$otros_producto->name}}</div>
              <div class="cis-prod-spec"><i class="bi bi-lightning-charge-fill"></i> {{ ($otros_producto->potencia_nominal ?? '--') . ' · ' . ($otros_producto->garantia ?? '--') }}</div>
              <div class="d-flex align-items-center gap-2">
                @if($otros_producto->precio_descuento == '' || $otros_producto->precio_descuento == 0)
                    <div class="pr-price">S/ {{$otros_producto->precio}}</div>
                  @else
                    <span class="pr-discount-badge">- {{$otros_producto->porcentaje}}% OFF</span>
                    <div class="pr-old-price">S/ {{$otros_producto->precio}}</div>
                    <div class="pr-price">S/ {{$otros_producto->precio_descuento}}</div>
                    <div class="pr-price-label">Por unidad</div>
                  @endif
              </div>
              <div class="cis-prod-actions">
                <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <a href="/product/{{$otros_producto->slug}}" class="btn btn-outline-secondary"><i class="bi bi-eye me-1"></i>Ver</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-pagination"></div>
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
        <form method="post" action="{{ route('ecommerce.product.store_comments') }}" class="mb-5">
          @csrf

          <input type="hidden" name="producto_id" value="{{$producto->id}}">
          <!-- Puntuación con estrellas interactivas -->
          <div class="mb-4">
            <label class="form-label fw-semibold mb-2" style="color:var(--c-text);font-size:.88rem;">
              Puntuación <span class="text-danger">*</span>
            </label>
            <div class="pd-rv-star-input" id="starInput">
              <button type="radio" name="star_puntaje" data-val="1" onclick="setStars(1)"><i class="bi bi-star"></i></button>
              <button type="radio" name="star_puntaje" data-val="2" onclick="setStars(2)"><i class="bi bi-star"></i></button>
              <button type="radio" name="star_puntaje" data-val="3" onclick="setStars(3)"><i class="bi bi-star"></i></button>
              <button type="radio" name="star_puntaje" data-val="4" onclick="setStars(4)"><i class="bi bi-star"></i></button>
              <button type="radio" name="star_puntaje" data-val="5" onclick="setStars(5)"><i class="bi bi-star"></i></button>
            </div>
            <input type="hidden" name="valoracion" id="puntuacionInput" value="0">
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
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
        const icon = btn.querySelector('i');
        if (i < val) {
            btn.classList.add('active');
            icon.className = 'bi bi-star-fill'; // rellena las seleccionadas
        } else {
            btn.classList.remove('active');
            icon.className = 'bi bi-star'; // vacía las no seleccionadas
        } 
    });
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productosSwiper = new Swiper('.productos-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: false,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        breakpoints: {
            576: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            992: { slidesPerView: 4 },
        }
    });
});
</script>
@endpush