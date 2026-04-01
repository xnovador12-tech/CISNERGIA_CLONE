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
                    <input class="form-check-input" type="radio" value="{{ $tipo_id }}" id="tipo_{{ $tipo_id }}" name="categoryFilter">
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
                      <input class="form-check-input" type="checkbox" id="brand{{ $marca_id }}">
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
              <strong>{{ $productos->count() }}</strong> resultados encontrados
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
          @foreach($todos_productos as $prod)
          <div class="pr-prod-row">
            <div class="pr-prod-img-wrap">
              <img src="{{ $prod->imagen ? asset('images/productos/' . $prod->imagen) : '' }}?auto=compress&cs=tinysrgb&w=400" alt="{{$prod->name}}">
              <button class="pr-wishlist-btn"><i class="bi bi-heart"></i></button>
              <span class="pr-img-badge accent">Eco Plus</span>
            </div>
            <div class="pr-prod-body">
              <div class="pr-prod-brand">{{$prod->marca->name}}</div>
              <div class="pr-prod-name">{{$prod->name}}</div>
              <div class="pr-prod-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                <small class="ms-1">(124 valoraciones)</small>
              </div>
              <div class="pr-specs-grid">
                <div class="pr-spec-cell"><span class="pr-spec-label">Potencia nominal</span><span class="pr-spec-val">{{$prod->potencia_nominal}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Eficiencia</span><span class="pr-spec-val">{{$prod->eficiencia}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">N.° de celdas</span><span class="pr-spec-val">{{$prod->num_celdas}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Dimensiones</span><span class="pr-spec-val">{{$prod->dimensiones}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Tipo célula</span><span class="pr-spec-val">{{$prod->tipo_celula}}</span></div>
                <div class="pr-spec-cell"><span class="pr-spec-label">Garantía</span><span class="pr-spec-val">{{$prod->garantia}}</span></div>
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
                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus me-1"></i>Agregar</button>
                <a href="/product/{{ $prod->slug }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Ver detalles</a>
              </div>
            </div>
          </div>
          @endforeach

          {{-- Paginación --}}
          <nav aria-label="Navegación de productos" class="mt-4">
              {{ $todos_productos->links() }}
          </nav>

        </div>{{-- /col-lg-9 --}}
      </div>{{-- /row --}}
    </div>{{-- /container --}}
  </section>

@endsection

@section('js')
<script>
// ✅ Usar name en lugar de id
$('input[name="categoryFilter"]').on('click', function(){
    var valor_check_tipo = $(this).val();
    console.log(valor_check_tipo);
    $.get('/busqueda_pmarca', {valor_check_tipo: valor_check_tipo}, function(productos){
        $('#div_marca').empty();
        $.each(productos, function(index, value){
            var fila = '';  // ← bug igual que antes, reasignabas con =
            fila += '<div class="pr-filter-item">';
            fila +=   '<div class="form-check m-0">';
            fila +=     '<input class="form-check-input" type="checkbox" id="brand'+value[0]+'">';
            fila +=     '<label class="form-check-label" for="brand'+value[0]+'">'+(value[1] ?? 'Sin marca')+'</label>';
            fila +=   '</div>';
            fila +=   '<span class="pr-filter-count">'+value[2]+'</span>';
            fila += '</div>';
            $('#div_marca').append(fila);
        });
    });
});
</script>
@endsection