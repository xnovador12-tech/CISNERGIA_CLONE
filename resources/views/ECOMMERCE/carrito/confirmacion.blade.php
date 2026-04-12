@extends('TEMPLATES.ecommerce')

@section('title', 'Pedido Confirmado')
@section('css')
  <style>
    .step-indicator {
      position: relative;
      display: flex;
      justify-content: space-between;
      margin-bottom: 3rem;
    }
    
    .step-indicator::before {
      content: '';
      position: absolute;
      top: 20px;
      left: 0;
      right: 0;
      height: 2px;
      background: #28a745;
      z-index: 0;
    }
    
    .step {
      position: relative;
      z-index: 1;
      text-align: center;
      flex: 1;
    }
    
    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #28a745;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 8px;
      font-weight: bold;
      transition: all 0.3s;
    }
    
    .success-icon {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 2rem;
      animation: scaleIn 0.5s ease-out;
      box-shadow: 0 10px 40px rgba(40, 167, 69, 0.3);
    }
    
    .success-icon i {
      font-size: 4rem;
      color: white;
      animation: checkmark 0.8s ease-in-out 0.3s both;
    }
    
    @keyframes scaleIn {
      from {
        transform: scale(0);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }
    
    @keyframes checkmark {
      0% {
        transform: scale(0) rotate(-45deg);
        opacity: 0;
      }
      50% {
        transform: scale(1.2) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
      }
    }
    
    .fadeInUp {
      animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .timeline-item {
      position: relative;
      padding-left: 40px;
      margin-bottom: 1.5rem;
    }
    
    .timeline-item::before {
      content: '';
      position: absolute;
      left: 8px;
      top: 28px;
      width: 2px;
      height: calc(100% + 1.5rem);
      background: #e9ecef;
    }
    
    .timeline-item:last-child::before {
      display: none;
    }
    
    .timeline-icon {
      position: absolute;
      left: 0;
      top: 0;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #0066cc;
      border: 3px solid #f8f9fa;
    }
    
    .order-tracking {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 1rem;
      padding: 1.5rem;
      color: white;
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
<!-- CONFIRMACIÓN DE PEDIDO -->
<!-- INDICADOR DE PASOS -->
<section class="mt-5 bg-light">
  <div class="container">
    <div class="step-indicator">
      <div class="step completed">
        <div class="step-circle">
          <i class="bi bi-check-lg"></i>
        </div>
        <small class="text-success fw-bold">Carrito</small>
      </div>
      <div class="step completed">
        <div class="step-circle">
          <i class="bi bi-check-lg"></i>
        </div>
        <small class="text-success fw-bold">Pago</small>
      </div>
      <div class="step completed">
        <div class="step-circle">
          <i class="bi bi-check-lg"></i>
        </div>
        <small class="text-success fw-bold">Confirmación</small>
      </div>
    </div>
  </div>
</section>

<!-- CONFIRMACIÓN DE COMPRA -->
<section class="mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <!-- Mensaje de éxito -->
        <div class="text-center mb-5 fadeInUp">
          <div class="success-icon">
            <i class="bi bi-check-lg"></i>
          </div>
          <h1 class="display-4 fw-bold mb-3">¡Compra Confirmada!</h1>
          <p class="lead text-muted mb-4">
            Tu pedido ha sido procesado exitosamente. Recibirás un email de confirmación en los próximos minutos.
          </p>
          <div class="d-flex justify-content-center gap-2 flex-wrap">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
              <i class="bi bi-receipt me-1"></i>Pedido {{$sale->pedido->codigo}}
            </span>
            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
              <i class="bi bi-calendar-check me-1"></i>{{$sale->pedido->created_at->locale('es_PE')->isoFormat('D [de] MMMM, YYYY [a las] HH:mm')}}
            </span>
          </div>
        </div>

        <div class="row g-4">
          <!-- Detalles del pedido -->
          <div class="col-lg-8">
            
            <!-- Resumen de productos -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="bi bi-box-seam text-primary fs-4"></i>
                  </div>
                  <h4 class="fw-bold mb-0">Productos Comprados</h4>
                </div>

                @foreach($dtlle_venta as $dtlle_ventas)
                @php
                    $producto = App\Models\Producto::where('id', $dtlle_ventas->producto_id)->first();
                @endphp
                <div class="mb-3 pb-3 border-bottom">
                  <div class="d-flex align-items-center">
                    <img src="{{ $producto->imagen ? asset('images/productos/' . $producto->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=100" 
                         class="rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="Producto">
                    <div class="ms-3 flex-grow-1">
                      <h6 class="mb-1 fw-bold">{{ $producto->name }}</h6>
                      <small class="text-muted">Cantidad: {{ $dtlle_ventas->cantidad }}</small>
                    </div>
                    <div class="text-end">
                      <p class="mb-0 fw-bold">S/ {{ number_format($dtlle_ventas->precio_unitario, 2) }}</p>
                    </div>
                  </div>
                </div>
                @endforeach

                <hr class="my-3">

                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Subtotal</span>
                  <span class="fw-bold">S/ {{ number_format($sale->subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-success">
                    <span>Descuento:</span>
                    @if($sale->pedido->descuento_porcentaje)
                        <span class="badge bg-success ms-2">({{ $sale->pedido->descuento_porcentaje }}%)</span>
                        <input type="hidden" id="descuento_porcentaje" value="{{ $sale->pedido->descuento_porcentaje }}">
                    @endif
                    <span class="fw-semibold">- S/ {{ number_format($sale->pedido->descuento_monto, 2) }}</span>
                    <input type="hidden" id="descuento" value="{{ $sale->pedido->descuento_monto }}">
                </div>
                <div class="d-flex justify-content-between mb-3">
                  <span class="text-muted">IGV (18%)</span>
                  <span class="fw-bold">S/ {{$sale->igv}}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Envío</span>
                  <span class="fw-bold text-success">Gratis</span>
                </div>

                <div class="d-flex justify-content-between border-top pt-3">
                  <span class="fs-5 fw-bold">Total Pagado</span>
                  <span class="fs-4 fw-bold text-primary">S/ {{ number_format($sale->total, 2) }}</span>
                </div>
              </div>
            </div>

            <!-- Información de envío -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="bi bi-truck text-success fs-4"></i>
                  </div>
                  <h4 class="fw-bold mb-0">Información de Envío</h4>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <p class="mb-1 small text-muted">Nombre del destinatario</p>
                    <p class="mb-0 fw-bold">{{$sale->cliente->user->persona->name.' '.$sale->cliente->user->persona->surnames}}</p>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 small text-muted">Teléfono</p>
                    <p class="mb-0 fw-bold">+51 {{$sale->cliente->user->persona->name.' '.$sale->cliente->user->persona->celular}}</p>
                  </div>
                  <div class="col-12">
                    <p class="mb-1 small text-muted">Dirección de envío</p>
                    <p class="mb-0 fw-bold">{{$sale->cliente->user->persona->direccion}}</p>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 small text-muted">Email</p>
                    <p class="mb-0 fw-bold">{{$sale->cliente->user->email}}</p>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 small text-muted">Método de pago</p>
                    <p class="mb-0 fw-bold">
                      @php
                        $metodoPagoNombre = optional($sale->mediopago)->name;
                      @endphp
                      @if($metodoPagoNombre === 'Billetera Digital')
                        <i class="bi bi-phone me-1"></i>{{ $metodoPagoNombre }}
                      @elseif($metodoPagoNombre === 'Transferencia Bancaria')
                        <i class="bi bi-bank me-1"></i>{{ $metodoPagoNombre }}
                      @else
                        <i class="bi bi-credit-card me-1"></i>{{ $metodoPagoNombre ?: 'Pago procesado' }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Próximos pasos -->
            <div class="card border-0 shadow-sm rounded-4">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="bi bi-list-check text-secondary fs-4"></i>
                  </div>
                  <h4 class="fw-bold mb-0">¿Qué sigue ahora?</h4>
                </div>

                <div class="timeline-item">
                  <div class="timeline-icon"></div>
                  <h6 class="fw-bold mb-1">Confirmación por email</h6>
                  <p class="text-muted small mb-0">Recibirás un email con los detalles de tu pedido y número de seguimiento.</p>
                </div>

                <div class="timeline-item">
                  <div class="timeline-icon"></div>
                  <h6 class="fw-bold mb-1">Preparación del pedido</h6>
                  <p class="text-muted small mb-0">Nuestro equipo preparará tus productos con el mayor cuidado (1-2 días hábiles).</p>
                </div>

                <div class="timeline-item">
                  <div class="timeline-icon"></div>
                  <h6 class="fw-bold mb-1">Envío a tu domicilio</h6>
                  <p class="text-muted small mb-0">El producto será enviado y podrás rastrearlo en tiempo real.</p>
                </div>

                <div class="timeline-item">
                  <div class="timeline-icon"></div>
                  <h6 class="fw-bold mb-1">Instalación profesional (opcional)</h6>
                  <p class="text-muted small mb-0">Coordinaremos contigo la fecha para la instalación de tus paneles solares.</p>
                </div>
              </div>
            </div>

          </div>

          <!-- Sidebar derecho -->
          <div class="col-lg-4">
            
            <!-- Rastreo de pedido -->
            <div class="order-tracking mb-4">
              <h5 class="fw-bold mb-3">
                <i class="bi bi-geo-alt-fill me-2"></i>Rastrea tu Pedido
              </h5>
              <p class="mb-3 small opacity-90">
                Usa tu número de pedido para rastrear tu envío en tiempo real.
              </p>
              <div class="bg-white bg-opacity-15 rounded-3 p-3 mb-3">
                <p class="mb-1 small opacity-75 text-dark">Número de pedido</p>
                <p class="mb-0 fw-bold fs-5 text-dark">{{$sale->pedido->codigo}}</p>
              </div>
              <p class="mb-0 small opacity-90">
                <i class="bi bi-clock me-1"></i>Tiempo estimado de entrega: {{$sale->pedido->fecha_entrega_estimada->locale('es_PE')->isoFormat('D [de] MMMM, YYYY')}}
              </p>
            </div>

            <!-- Acciones principales -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
              <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Acciones</h6>
                <div class="d-grid gap-2">
                  <a href="{{ route('ecommerce.mis_compras') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-bag-check me-2"></i>Ver Mis Compras
                  </a>
                  @if($sale->tiposcomprobante_id == '1')
                  <a href="/comprobante_compra/{{$sale->slug}}" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Factura
                  </a>
                  @elseif($sale->tiposcomprobante_id == '2')
                  <a href="/comprobante_compra/{{$sale->slug}}" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Boleta
                  </a>
                  @else
                  <a href="/comprobante_compra/{{$sale->slug}}" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Nota de venta
                  </a>
                  @endif
                  <a href="{{ route('ecommerce.products') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
                  </a>
                </div>
              </div>
            </div>

            <!-- Ayuda y soporte -->
            <div class="card border-0 bg-light rounded-4">
              <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                  <i class="bi bi-headset me-2 text-primary"></i>¿Necesitas Ayuda?
                </h6>
                <p class="small text-muted mb-3">
                  Nuestro equipo está disponible para ayudarte con cualquier consulta.
                </p>
                <div class="d-grid gap-2">
                  <a href="https://wa.me/51999999999" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp me-2"></i>WhatsApp
                  </a>
                  <a href="tel:+51999999999" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-telephone me-2"></i>Llamar
                  </a>
                  <a href="contacto.html" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-envelope me-2"></i>Email
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Sección de productos recomendados -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">También te Puede Interesar</h2>
      <p class="text-muted">Complementa tu instalación solar con estos productos</p>
    </div>

    <div class="row g-4">
        <div class="tab-pane fade show active" id="residencial" role="tabpanel">
              <div class="swiper productos-swiper">
                  <div class="swiper-wrapper">
                      @foreach($productos_destacados as $prod)
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
                          <div class="col-lg-3 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                            <img src="{{ $prod->imagen ? asset('images/productos/' . $prod->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=400" 
                                class="card-img-top rounded-top-4" alt="Regulador" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">{{$prod->tipo->name}}</span>
                                <h6 class="fw-bold mb-2">{{ $prod->name }}</h6>
                                <p class="small text-muted mb-3">{{ $prod->descripcion }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary fw-bold">S/ {{ $prod->precio }}</span>
                                <a href="{{ route('ecommerce.product.show', $prod->slug) }}" class="btn btn-sm btn-primary">Ver más</a>
                                </div>
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
    </div>
  </div>
</section>
@endsection
