@extends('TEMPLATES.ecommerce')

@section('title', 'Catálogo de Productos Solares')
@section('css')
<style>
  /* Vista lista (default - la que ya tienes) */
#prod-list.vista-lista .pr-prod-row {
    display: flex;
    flex-direction: row;
}

/* Vista grilla */
#prod-list.vista-grilla {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem;
}

#prod-list.vista-grilla .pr-prod-row {
    flex-direction: column;
}

/* Ocultar specs en grilla para que no quede muy cargado */
#prod-list.vista-grilla .pr-specs-grid {
    display: none;
}

#prod-list.vista-grilla .pr-prod-img-wrap {
    width: 100%;
    height: 180px;
}

#prod-list.vista-grilla .pr-prod-price-col {
    width: 100%;
    border-left: none;
    border-top: 1px solid var(--c-border);
    padding-top: 0.75rem;
}
</style>
@endsection
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
                    <input class="form-check-input" type="radio" value="{{ $tipo_id }}" id="tipo_{{ $tipo_id }}" name="tipoFilter">
                    <label class="form-check-label" for="tipo_{{ $tipo_id }}">{{ $productos->first()->tipo->name ?? 'Sin tipo' }}</label>
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
              <div id="div_marca">
                  @foreach($marcas_producto as $marca_id => $productos)
                  <div class="pr-filter-item">
                    <div class="form-check m-0">
                      <input class="form-check-input" type="checkbox" id="brand{{ $marca_id }}" name="marcaFilter">
                      <label class="form-check-label" for="brand{{ $marca_id }}">{{ $productos->first()->marca->name ?? 'Sin marca' }}</label>
                    </div>
                  <span class="pr-filter-count">{{ $productos->sum(fn($p) => $p->inventarios->sum('cantidad')) }}</span>
                  </div>
                  @endforeach
              </div>
              <!-- <button class="pr-show-more mt-1">
                <i class="bi bi-plus-circle"></i> Ver más marcas
              </button> -->
            </div>

            <hr class="pr-filter-sep">

            <button id="btn_limpiar" class="btn pr-clear-btn w-100">
              <i class="bi bi-x-circle me-2"></i>Limpiar filtros
            </button>

          </div>
        </div>

        {{-- Product List Area --}}
        <div class="col-lg-9">

          {{-- Sort Bar --}}
          <div class="pr-sort-bar">
              <div class="pr-sort-info">
                  <strong id="total-resultados">{{ $productos->count() }}</strong> resultados encontrados
              </div>
              <div class="pr-sort-right">
                  <span class="pr-sort-label">Ordenar por:</span>
                  <select class="pr-sort-select" id="ordenarSelect">
                      <option value="relevantes" {{ ($orden ?? 'relevantes') == 'relevantes' ? 'selected' : '' }}>Más relevantes</option>
                      <option value="menor_precio" {{ ($orden ?? '') == 'menor_precio' ? 'selected' : '' }}>Menor precio</option>
                      <option value="mayor_precio" {{ ($orden ?? '') == 'mayor_precio' ? 'selected' : '' }}>Mayor precio</option>
                      <option value="recientes" {{ ($orden ?? '') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                  </select>
                  <div class="pr-view-grp">
                      <button class="pr-view-btn active" title="Vista lista"><i class="bi bi-list-ul"></i></button>
                      <button class="pr-view-btn" title="Vista grilla"><i class="bi bi-grid-3x3-gap"></i></button>
                  </div>
              </div>
          </div>

          {{-- Producto 1: Panel Solar Monocristalino 450W --}}
          <div id="prod-list">
          @foreach($todos_productos as $prod)
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
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="{{ $prod->imagen ? asset('images/productos/' . $prod->imagen) : asset('images/logo.webp') }}?auto=compress&cs=tinysrgb&w=400" alt="{{$prod->name}}">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge accent">Eco Plus</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">{{$prod->marca->name}}</div>
              <div class="pr-prod-name">{{$prod->name}}</div>
              <div class="pr-prod-stars">
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
                <small class="ms-1">( {{$comentarios_total_pproducto->contador > 1 ? $comentarios_total_pproducto->contador : $comentarios_total_pproducto->contador}} )</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">{{$prod->potencia_nominal ?? '--'}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">{{$prod->eficiencia ?? '--'}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">N.° de celdas</span><span class="pr-spec-val">{{$prod->num_celdas ?? '--'}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Dimensiones</span><span class="pr-spec-val">{{$prod->dimensiones ?? '--'}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo célula</span><span class="pr-spec-val">{{$prod->tipo_celula ?? '--'}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">{{$prod->garantia ?? '--'}}</span></div>
              </div>
              <div class="d-flex flex-wrap gap-2 mt-auto">
                <span class="pr-tag"><i class="bi bi-patch-check"></i> Certificado</span>
                <span class="pr-tag success"><i class="bi bi-truck"></i> Envío gratis</span>
              </div>
            </div>
            <div class="pr-prod-price-col">
              <div>
                @if($prod->precio_descuento == '' || $prod->precio_descuento == 0)
                  <div class="pr-price">S/ {{$prod->precio}}</div>
                @else
                  <span class="pr-discount-badge">- {{$prod->porcentaje}}% OFF</span>
                  <div class="pr-old-price">S/ {{$prod->precio}}</div>
                  <div class="pr-price">S/ {{$prod->precio_descuento}}</div>
                  <div class="pr-price-label">Por unidad</div>
                @endif
              </div>
              <div class="d-flex flex-column gap-2">
                <button onclick="add_carrito_id({{$prod->id}});" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <a href="/product/{{ $prod->slug }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</a>
              </div>
            </div>
          </div>
          @endforeach
          </div>

          {{-- Paginación inicial de Laravel (se oculta cuando hay filtro activo) --}}
          <nav id="paginacion-blade" aria-label="Navegación de productos" class="mt-4">
              {{ $todos_productos->links() }}
          </nav>

          {{-- Paginación AJAX (aparece cuando hay filtro activo) --}}
          <div id="paginacion"></div>

        </div>{{-- /col-lg-9 --}}
      </div>{{-- /row --}}
    </div>{{-- /container --}}
  </section>

@endsection

@section('js')
<script>

$('.pr-view-btn').on('click', function(){
    $('.pr-view-btn').removeClass('active');
    $(this).addClass('active');
    
    const esGrilla = $(this).attr('title') === 'Vista grilla';
    
    if(esGrilla){
        $('#prod-list').addClass('vista-grilla').removeClass('vista-lista');
    } else {
        $('#prod-list').addClass('vista-lista').removeClass('vista-grilla');
    }
});


// ✅ Usar name en lugar de id

var valor_check_tipo = null;
var valor_check_marca = null;
var valor_orden = 'relevantes';

$('#ordenarSelect').on('change', function(){
    valor_orden = $(this).val();
    if (valor_check_marca && valor_check_marca.length > 0) {
        cargarProductospormarca(1);
    } else if (valor_check_tipo) {
        cargarProductosportipo(1);
    } else {
        // sin filtro activo, recarga con orden por URL
        const url = new URL(window.location.href);
        url.searchParams.set('orden', valor_orden);
        window.location.href = url.toString();
    }
});

$('input[name="tipoFilter"]').on('click', function(){
    valor_check_tipo = $(this).val();
    
    $('#paginacion-blade').hide(); // ← oculta paginación Laravel
    $('#paginacion').show();       // ← muestra paginación AJAX
    
    cargarProductosportipo(1);

    // busqueda para mostrar marca
    $.get('/busqueda_pmarca', {valor_check_tipo: valor_check_tipo}, function(productos){
        $('#div_marca').empty();
        $.each(productos, function(index, value){
            var fila = '';  // ← bug igual que antes, reasignabas con =
            fila += '<div class="pr-filter-item">';
            fila +=   '<div class="form-check m-0">';
            fila +=     '<input class="form-check-input" type="checkbox" id="brand'+value[0]+'" name="marcaFilter" value="'+value[0]+'">';
            fila +=     '<label class="form-check-label" for="brand'+value[0]+'">'+(value[1] ?? 'Sin marca')+'</label>';
            fila +=   '</div>';
            fila +=   '<span class="pr-filter-count">'+value[2]+'</span>';
            fila += '</div>';
            $('#div_marca').append(fila);
        });
    });
    // fin de busqueda para mostrar marca
});

$(document).on('click', 'input[name="marcaFilter"]', function(){
    // Recoger TODAS las marcas chequeadas
    valor_check_marca = $('input[name="marcaFilter"]:checked').map(function(){
        return $(this).val();
    }).get(); // → array: [1, 3, 5]

    valor_check_tipo = $('input[name="tipoFilter"]').filter(':checked').val() || null;
    $('#paginacion-blade').hide();
    $('#paginacion').show();
    cargarProductospormarca(1);
});

// Funcion para iterar dentro de la seleccion del primer filtro de tipos
  function cargarProductosportipo(page) {
      if (!valor_check_tipo) return;
      $.get('/busqueda_pproducto_categoria', {
          valor_check_tipo: valor_check_tipo,
          orden: valor_orden,
          page: page
      }, function(response){
          $('#total-resultados').text(response.pagination.total);
          $('#prod-list').empty();

          $.each(response.productos, function(index, value){
              var list_product = '';
              list_product += '<div class="pr-prod-row">' +   // ← sin id aquí
                '<div class="pr-prod-img-wrap">' +
                  '<img src="' + (value[3]) + '?auto=compress&cs=tinysrgb&w=400" alt="' + value[1] + '">' +
                  '<button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>' +
                  '<span class="pr-img-badge accent">Eco Plus</span>' +
                '</div>';
              list_product += '<div class="pr-prod-body">' +
                  '<div class="pr-prod-brand">' + value[4] + '</div>' +
                  '<div class="pr-prod-name">' + value[1] + '</div>' +
                  '<div class="pr-prod-stars">' +
                    '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>' +
                    '<small class="ms-1">(124 valoraciones)</small>' +
                  '</div>' +
                  '<div class="pr-specs-grid">' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">' + value[5] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">' + value[6] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">N.° de celdas</span><span class="pr-spec-val">' + value[7] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Dimensiones</span><span class="pr-spec-val">' + value[8] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Tipo célula</span><span class="pr-spec-val">' + value[9] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">' + value[10] + '</span></div>' +
                  '</div>' +
                  '<div class="d-flex flex-wrap gap-2 mt-auto">' +
                    '<span class="pr-tag"><i class="bi bi-patch-check"></i> Certificado</span>' +
                    '<span class="pr-tag success"><i class="bi bi-truck"></i> Envío gratis</span>' +
                  '</div>' +
              '</div>';
              list_product += '<div class="pr-prod-price-col">' +
                  '<div>';
                    if (value[11] == '' || value[11] == 0) {
                      list_product += '<div class="pr-price">S/ ' + value[13] + '</div>';
                    } else {
                      list_product += '<span class="pr-discount-badge">- ' + value[12] + '% OFF</span>';
                      list_product += '<div class="pr-old-price">S/ ' + value[13] + '</div>';
                      list_product += '<div class="pr-price">S/ ' + value[11] + '</div>';
                      list_product += '<div class="pr-price-label">Por unidad</div>';
                    }
                  list_product += '</div>';
                  list_product += '<div class="d-flex flex-column gap-2">';
                    list_product += '<button onclick="add_carrito_id(' + value[0] + ');" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>';
                    list_product += '<a href="/product/' + value[14] + '" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</a>';
                  list_product += '</div>';
              list_product += '</div>';
              list_product += '</div>';

              $('#prod-list').append(list_product);
          });

          renderPaginacion(response.pagination);
      });
  }

  function cargarProductospormarca(page) {
      if (!valor_check_marca) return;
      $.get('/busqueda_pproducto_marca', {
          valor_check_marca: valor_check_marca,valor_check_tipo:valor_check_tipo,
          orden: valor_orden,
          page: page
      }, function(response){
          $('#total-resultados').text(response.pagination.total);
          $('#prod-list').empty();

          $.each(response.productos, function(index, value){
              var list_product = '';
              list_product += '<div class="pr-prod-row">' +   // ← sin id aquí
                '<div class="pr-prod-img-wrap">' +
                  '<img src="' + (value[3]) + '?auto=compress&cs=tinysrgb&w=400" alt="' + value[1] + '">' +
                  '<button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>' +
                  '<span class="pr-img-badge accent">Eco Plus</span>' +
                '</div>';
              list_product += '<div class="pr-prod-body">' +
                  '<div class="pr-prod-brand">' + value[4] + '</div>' +
                  '<div class="pr-prod-name">' + value[1] + '</div>' +
                  '<div class="pr-prod-stars">' +
                    '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>' +
                    '<small class="ms-1">(124 valoraciones)</small>' +
                  '</div>' +
                  '<div class="pr-specs-grid">' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">' + value[5] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">' + value[6] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">N.° de celdas</span><span class="pr-spec-val">' + value[7] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Dimensiones</span><span class="pr-spec-val">' + value[8] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Tipo célula</span><span class="pr-spec-val">' + value[9] + '</span></div>' +
                    '<div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">' + value[10] + '</span></div>' +
                  '</div>' +
                  '<div class="d-flex flex-wrap gap-2 mt-auto">' +
                    '<span class="pr-tag"><i class="bi bi-patch-check"></i> Certificado</span>' +
                    '<span class="pr-tag success"><i class="bi bi-truck"></i> Envío gratis</span>' +
                  '</div>' +
              '</div>';
              list_product += '<div class="pr-prod-price-col">' +
                  '<div>';
                    if (value[11] == '' || value[11] == 0) {
                      list_product += '<div class="pr-price">S/ ' + value[13] + '</div>';
                    } else {
                      list_product += '<span class="pr-discount-badge">- ' + value[12] + '% OFF</span>';
                      list_product += '<div class="pr-old-price">S/ ' + value[13] + '</div>';
                      list_product += '<div class="pr-price">S/ ' + value[11] + '</div>';
                      list_product += '<div class="pr-price-label">Por unidad</div>';
                    }
                  list_product += '</div>';
                  list_product += '<div class="d-flex flex-column gap-2">';
                    list_product += '<button onclick="add_carrito_id(' + value[0] + ');" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>';
                    list_product += '<a href="/product/' + value[14] + '" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</a>';
                  list_product += '</div>';
              list_product += '</div>';
              list_product += '</div>';

              $('#prod-list').append(list_product);
          });

          renderPaginacion(response.pagination);
      });
  }

  function renderPaginacion(p) {
      if (p.last_page <= 1) {
          $('#paginacion').empty();
          return;
      }

      let html = '<ul class="pagination justify-content-center mt-4">';

      html += `<li class="page-item ${p.current_page == 1 ? 'disabled' : ''}">
                  <a class="page-link" href="#" onclick="cargarProductos(${p.current_page - 1}); return false;">
                      <i class="bi bi-chevron-left"></i>
                  </a>
              </li>`;

      let start = Math.max(1, p.current_page - 2);
      let end   = Math.min(p.last_page, p.current_page + 2);

      for (let i = start; i <= end; i++) {
          html += `<li class="page-item ${p.current_page == i ? 'active' : ''}">
                      <a class="page-link" href="#" onclick="cargarProductos(${i}); return false;">${i}</a>
                  </li>`;
      }

      html += `<li class="page-item ${p.current_page == p.last_page ? 'disabled' : ''}">
                  <a class="page-link" href="#" onclick="cargarProductos(${p.current_page + 1}); return false;">
                      <i class="bi bi-chevron-right"></i>
                  </a>
              </li>`;

      html += '</ul>';
      $('#paginacion').html(html);
  }
// Fin de la iteracion

// para limpiar la seleccion de los filtros

$('#btn_limpiar').on('click', function(){
    // Limpiar variables
    valor_check_tipo = null;
    valor_check_marca = null;

    // Desmarcar todos los checkboxes y radios
    $('input[name="tipoFilter"]').prop('checked', false);
    $('input[name="marcaFilter"]').prop('checked', false);
    $('#inStock').prop('checked', false);
    $('#protection').prop('checked', false);

    // Restaurar paginación original de Laravel
    $('#paginacion').empty().hide();
    $('#paginacion-blade').show();

    // Recargar lista original via AJAX o reload
    location.reload(); // ← más simple, recarga la página con los productos originales
});

// fin de la seleccion de los filtros
</script>
@endsection