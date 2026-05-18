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
            <i class="bi bi-box-seam me-1"></i>{{ $stats['total_pedidos'] ?? 0 }} Pedidos
          </span>
          <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
            <i class="bi bi-check-circle me-1"></i>{{ $stats['entregados'] ?? 0 }} Entregados
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
            <i class="bi bi-hourglass-split me-1"></i>En preparación
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
    <div class="row g-4" id="orders-container">

      @forelse($ventas as $venta)
      @php
        $pedido = $venta->pedido;
        $detalle_venta = $venta->detalles;
      @endphp
      <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 order-card status-delivered" data-status="delivered">
          <div class="card-body p-4">

            <!-- CABECERA DEL PEDIDO -->
            <div class="row align-items-center mb-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h5 class="mb-0 fw-bold">#{{ $venta->pedido->codigo }}</h5>

                  @if(optional($pedido)->estado == 'pendiente')
                    <span class="badge status-badge bg-info bg-opacity-10 text-info">
                      <i class="bi bi-hourglass-split me-1"></i>Pendiente
                    </span>
                  @elseif(optional($pedido)->estado == 'proceso')
                    <span class="badge status-badge bg-warning bg-opacity-10 text-warning">
                      <i class="bi bi-hourglass-split me-1"></i>En preparación
                    </span>
                  @elseif(optional($pedido)->estado == 'enviado')
                    <span class="badge status-badge bg-primary bg-opacity-10 text-primary">
                      <i class="bi bi-truck me-1"></i>En tránsito
                    </span>
                  @elseif(optional($pedido)->estado == 'entregado')
                    <span class="badge status-badge bg-success bg-opacity-10 text-success">
                      <i class="bi bi-check-circle-fill me-1"></i>Entregado
                    </span>
                  @elseif(optional($pedido)->estado == 'cancelado')
                    <span class="badge status-badge bg-danger bg-opacity-10 text-danger">
                      <i class="bi bi-x-circle-fill me-1"></i>Cancelado
                    </span>
                  @else
                    <span class="badge status-badge bg-dark bg-opacity-10 text-dark">
                      <i class="bi bi-check-circle-fill me-1"></i>Confirmado
                    </span>
                  @endif
                </div>
                <p class="text-muted mb-0 small">
                  <i class="bi bi-calendar3 me-1"></i>Pedido el {{ optional(optional($pedido)->created_at)->format('d \\d\\e F, Y') ?? '-' }}
                  <span class="mx-2">•</span>
                  <i class="bi bi-box-seam me-1"></i>Entregado el {{ optional($pedido)->fecha_entrega_estimada
                    ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d \\d\\e F, Y')
                    : '-' }}
                </p>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <p class="mb-1 fw-bold fs-4 text-primary">S/ {{ $venta->total }}</p>
                {{-- FIX: botón apunta a toggleDetails con prefijo detail- --}}
                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails({{ $venta->id }}, this)">
                  <i class="bi bi-eye me-1"></i>Ver detalles
                </button>
              </div>
            </div>

            <!-- IMAGEN PRODUCTO -->
            <div class="d-flex gap-3 mb-3 flex-wrap align-items-center">
              @if($detalle_venta->count() == 1)
                @php $producto = App\Models\Producto::find($detalle_venta->first()->producto_id); @endphp
                <img src="{{ $producto->imagen ? asset('images/productos/' . $producto->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=100"
                     class="product-thumb" alt="{{ $producto->name }}">
                <div class="d-flex align-items-center">
                  <span class="text-muted">{{ $producto->name }}</span>
                </div>
              @else
                @php $primerProducto = App\Models\Producto::find($detalle_venta->first()->producto_id); @endphp
                <img src="{{ $primerProducto->imagen ? asset('images/productos/' . $primerProducto->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=100"
                     class="product-thumb" alt="{{ $primerProducto->name }}">
                <div class="d-flex align-items-center">
                  <span class="text-muted">+{{ $detalle_venta->count() - 1 }} productos más</span>
                </div>
              @endif
            </div>

            <!-- ALERTA SEGUIMIENTO -->
            <div class="mt-3">
              <div class="alert alert-info border-0 d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>
                  <strong>Tu pedido está en camino</strong>
                  <p class="mb-0 small">Última actualización: Lima, Centro de Distribución - 2 de diciembre, 10:30 AM</p>
                </div>
              </div>
            </div>

            {{-- FIX 1: id ahora tiene prefijo "detail-" --}}
            {{-- FIX 2: data-loaded="true" porque el contenido ya está precargado --}}
            <div class="order-details" id="detail-{{ $venta->id }}" data-loaded="true">
              <hr class="my-3">
              <div class="row g-3">
                <div class="col-lg-8">
                  <h6 class="fw-bold mb-3">Productos</h6>
                  <div class="mb-3 pb-3 border-bottom">
                    @foreach($detalle_venta as $detalle)
                      @php $producto = App\Models\Producto::find($detalle->producto_id); @endphp
                      <div class="d-flex align-items-center mb-3">
                        <img src="{{ $producto->imagen ? asset('images/productos/' . $producto->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=100"
                             class="product-thumb me-3" alt="{{ $producto->name }}">
                        <div class="flex-grow-1">
                          <h6 class="mb-1 fw-bold">{{ $producto->name }}</h6>
                          <small class="text-muted">Cantidad: {{ $detalle->cantidad }}</small>
                        </div>
                        <div class="text-end">
                          <p class="mb-0 fw-bold">S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <div class="col-lg-4">
                  <h6 class="fw-bold mb-3">Información de Envío</h6>
                  <p class="mb-1 small text-muted">Dirección</p>
                  <p class="mb-3 small">{{ $venta->cliente->user->persona->direccion }}</p>

                  <h6 class="fw-bold mb-3 mt-4">Acciones</h6>
                  <div class="d-grid gap-2 p-2">
                    <a href="/product" class="btn btn-sm btn-primary">
                      <i class="bi bi-arrow-clockwise me-1"></i>Comprar de nuevo
                    </a>
                    @if($venta->tiposcomprobante_id == '1')
                      <a href="/comprobante_compra/{{ $venta->slug }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Factura
                      </a>
                    @elseif($venta->tiposcomprobante_id == '2')
                      <a href="/comprobante_compra/{{ $venta->slug }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Boleta
                      </a>
                    @else
                      <a href="/comprobante_compra/{{ $venta->slug }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Descargar Nota de venta
                      </a>
                    @endif
                    <a href="#" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-star me-1"></i>Dejar reseña
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN order-details -->

          </div>
        </div>
      </div>

      @empty
      <div class="text-center py-5" id="noResults">
        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
        <h4 class="mt-3 text-muted">No se encontraron pedidos</h4>
        <p class="text-muted">Intenta con otros filtros o realiza tu primera compra</p>
        <a href="/products" class="btn btn-primary mt-3">
          <i class="bi bi-shop me-2"></i>Ir a la tienda
        </a>
      </div>
      @endforelse

    </div>
  </div>
</section>

<!-- ESTADÍSTICAS -->
<section class="py-5 bg-light">
  <div class="container">
    <h3 class="fw-bold mb-4">Resumen de Compras</h3>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
              <i class="bi bi-box-seam text-primary fs-2"></i>
            </div>
            <h2 class="fw-bold mb-1">{{ $stats['total_pedidos'] ?? 0 }}</h2>
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
            <h2 class="fw-bold mb-1">{{ $stats['entregados'] ?? 0 }}</h2>
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
            <h2 class="fw-bold mb-1">S/ {{ number_format($stats['total_invertido'] ?? 0, 2) }}</h2>
            <p class="text-muted mb-0">Total Invertido</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
// ─── TOGGLE DETALLES ─────────────────────────────────────────────────────────
function toggleDetails(ventaId, btn) {
    const detalle = document.getElementById('detail-' + ventaId);
    if (!detalle) { console.error('No se encontró detail-' + ventaId); return; }

    const isVisible = detalle.classList.contains('show');

    document.querySelectorAll('.order-details').forEach(el => el.classList.remove('show'));
    document.querySelectorAll('[onclick^="toggleDetails"]').forEach(b => {
        b.innerHTML = '<i class="bi bi-eye me-1"></i>Ver detalles';
        b.classList.remove('btn-primary');
        b.classList.add('btn-outline-primary');
    });

    if (isVisible) return;

    if (detalle.dataset.loaded === 'true') {
        detalle.classList.add('show');
        btn.innerHTML = '<i class="bi bi-eye-slash me-1"></i>Ocultar detalles';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-primary');
        return;
    }

    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Cargando...';
    btn.disabled = true;

    $.get('/getdetalle_venta', { venta_id: ventaId }, function(data) {
        let productosHtml = '';
        data.detalles.forEach(function(p) {
            productosHtml += `
            <div class="d-flex align-items-center mb-3">
                <img src="${p.imagen}" class="product-thumb me-3" alt="${p.nombre}">
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold">${p.nombre}</h6>
                    <small class="text-muted">Cantidad: ${p.cantidad}</small>
                </div>
                <div class="text-end">
                    <p class="mb-0 fw-bold">S/ ${p.subtotal}</p>
                </div>
            </div>`;
        });

        const comprobantes = { '1': 'Factura', '2': 'Boleta' };
        const tipoDoc = comprobantes[data.tiposcomprobante] ?? 'Nota de venta';

        detalle.innerHTML = `
        <hr class="my-3">
        <div class="row g-3">
            <div class="col-lg-8">
                <h6 class="fw-bold mb-3">Productos</h6>
                <div class="mb-3 pb-3 border-bottom">${productosHtml}</div>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Información de Envío</h6>
                <p class="mb-1 small text-muted">Dirección</p>
                <p class="mb-3 small">${data.direccion}</p>
                <h6 class="fw-bold mb-3 mt-4">Acciones</h6>
                <div class="d-grid gap-2 p-2">
                    <a href="/product" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Comprar de nuevo
                    </a>
                    <a href="/comprobante_compra/${data.slug}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Descargar ${tipoDoc}
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-star me-1"></i>Dejar reseña
                    </a>
                </div>
            </div>
        </div>`;

        detalle.dataset.loaded = 'true';
        detalle.classList.add('show');
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-eye-slash me-1"></i>Ocultar detalles';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-primary');

    }).fail(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-eye me-1"></i>Ver detalles';
        alert('Error al cargar los detalles. Intenta de nuevo.');
    });
}

// ─── FUNCIÓN CENTRAL DE RENDER ───────────────────────────────────────────────
function cargarPedidos(valor_filtro, busqueda = '') {
    $.get('/getfiltro_miscompras', { valor_filtro: valor_filtro, busqueda: busqueda }, function(pedidos) {
        $('#orders-container').empty();

        if (pedidos.length === 0) {
            $('#orders-container').html(`
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">No se encontraron pedidos</h4>
                    <p class="text-muted">Intenta con otros filtros o realiza tu primera compra</p>
                    <a href="/products" class="btn btn-primary mt-3">
                        <i class="bi bi-shop me-2"></i>Ir a la tienda
                    </a>
                </div>`);
            return;
        }

        const badgeMap = {
            'pendiente': `<span class="badge status-badge bg-info bg-opacity-10 text-info"><i class="bi bi-hourglass-split me-1"></i>Pendiente</span>`,
            'proceso':   `<span class="badge status-badge bg-warning bg-opacity-10 text-warning"><i class="bi bi-hourglass-split me-1"></i>En preparación</span>`,
            'enviado':   `<span class="badge status-badge bg-primary bg-opacity-10 text-primary"><i class="bi bi-truck me-1"></i>En tránsito</span>`,
            'entregado': `<span class="badge status-badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle-fill me-1"></i>Entregado</span>`,
            'cancelado': `<span class="badge status-badge bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-circle-fill me-1"></i>Cancelado</span>`,
        };

        $.each(pedidos, function(index, pedido) {
            const badge = badgeMap[pedido.estado] ?? `<span class="badge status-badge bg-dark bg-opacity-10 text-dark">Confirmado</span>`;
            const productosTexto = pedido.total_productos > 1
                ? `+${pedido.total_productos - 1} productos más`
                : pedido.producto_nombre;

            $('#orders-container').append(`
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 order-card" data-status="${pedido.estado}">
                    <div class="card-body p-4">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <h5 class="mb-0 fw-bold">#${pedido.codigo}</h5>
                                    ${badge}
                                </div>
                                <p class="text-muted mb-0 small">
                                    <i class="bi bi-calendar3 me-1"></i>Pedido el ${pedido.fecha_pedido}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-box-seam me-1"></i>Entregado el ${pedido.fecha_entrega}
                                </p>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <p class="mb-1 fw-bold fs-4 text-primary">S/ ${parseFloat(pedido.total).toFixed(2)}</p>
                                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails(${pedido.venta_id}, this)">
                                    <i class="bi bi-eye me-1"></i>Ver detalles
                                </button>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 flex-wrap align-items-center">
                            <img src="${pedido.imagen}" class="product-thumb" alt="${pedido.producto_nombre}">
                            <span class="text-muted">${productosTexto}</span>
                        </div>
                        <div class="mt-3">
                            <div class="alert alert-info border-0 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                <div>
                                    <strong>Tu pedido está en camino</strong>
                                    <p class="mb-0 small">Última actualización: Lima, Centro de Distribución - 2 de diciembre, 10:30 AM</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-details" id="detail-${pedido.venta_id}" data-loaded="false"></div>
                    </div>
                </div>
            </div>`);
        });
    });
}

// ─── FILTROS + BUSCADOR (variables únicas) ───────────────────────────────────
let debounceTimer = null;
let filtroActivo  = 'all';

$('.filter-chip').on('click', function() {
    filtroActivo = $(this).data('filter');
    $('.filter-chip').removeClass('active');
    $(this).addClass('active');
    cargarPedidos(filtroActivo, $('#searchOrders').val().trim());
});

$('#searchOrders').on('input', function() {
    const busqueda = $(this).val().trim();
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
        cargarPedidos(filtroActivo, busqueda);
    }, 400);
});
</script>
@endsection