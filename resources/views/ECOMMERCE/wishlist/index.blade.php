@extends('TEMPLATES.ecommerce')

@section('title', 'Mis Favoritos')

@section('css')
<style>
    .wishlist-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .wishlist-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .wishlist-img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        padding: 10px;
    }
    .btn-remove-fav {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: #fee2e2;
        color: #dc3545;
        transition: all 0.2s;
    }
    .btn-remove-fav:hover {
        background: #dc3545;
        color: #fff;
    }
    .empty-wishlist {
        padding: 60px 20px;
        text-align: center;
    }
    .empty-wishlist i {
        font-size: 4rem;
        color: #dee2e6;
    }
</style>
@endsection

@section('content')

<!-- BREADCRUMB -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{-- route('productos.index') --}}" class="text-decoration-none">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mis Favoritos</li>
            </ol>
        </nav>
    </div>
</section>

<!-- CONTENIDO -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">Mis Favoritos</h4>
                <p class="text-muted mb-0">
                    {{ $favoritos->count() }} {{ $favoritos->count() === 1 ? 'producto' : 'productos' }} en tu lista
                </p>
            </div>
            @if($favoritos->count() > 0)
                <a href="{{-- route('productos.index') --}}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Seguir comprando
                </a>
            @endif
        </div>

        @if($favoritos->count() > 0)
            <div class="row g-3">
                @foreach($favoritos as $fav)
                    <div class="col-12" id="fav-item-{{ $fav->id }}">
                        <div class="wishlist-card bg-white p-3">
                            <div class="d-flex align-items-center gap-3">
                                {{-- Imagen --}}
                                <div class="flex-shrink-0">
                                    @if($fav->producto->images && $fav->producto->images->count() > 0)
                                        <img src="{{ asset('storage/' . $fav->producto->images->first()->url) }}"
                                             alt="{{ $fav->producto->nombre }}" class="wishlist-img">
                                    @else
                                        <div class="wishlist-img d-flex align-items-center justify-content-center bg-light rounded">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="fw-bold mb-1 text-truncate">
                                        <a href="{{-- route('productos.show', $fav->producto->slug ?? $fav->producto->id) --}}"
                                           class="text-decoration-none text-dark">
                                            {{ $fav->producto->nombre }}
                                        </a>
                                    </h6>
                                    @if($fav->producto->marca)
                                        <small class="text-muted">{{ $fav->producto->marca->name ?? '' }}</small>
                                    @endif
                                    <div class="mt-2">
                                        @if($fav->producto->precio_descuento && $fav->producto->precio_descuento < $fav->producto->precio)
                                            <span class="text-decoration-line-through text-muted small me-2">
                                                S/ {{ number_format($fav->producto->precio, 2) }}
                                            </span>
                                            <span class="fw-bold text-danger fs-5">
                                                S/ {{ number_format($fav->producto->precio_descuento, 2) }}
                                            </span>
                                        @else
                                            <span class="fw-bold text-primary fs-5">
                                                S/ {{ number_format($fav->producto->precio, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Acciones --}}
                                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                                    <a href="{{-- route('productos.show', $fav->producto->slug ?? $fav->producto->id) --}}"
                                       class="btn btn-primary btn-sm px-3">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                    <button type="button" class="btn-remove-fav"
                                            onclick="eliminarFavorito({{ $fav->id }}, {{ $fav->producto_id }})"
                                            title="Quitar de favoritos">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Resumen --}}
            <div class="mt-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted">Total estimado de tus favoritos:</span>
                    <span class="fw-bold fs-5 text-primary ms-2">
                        S/ {{ number_format($favoritos->sum(fn($f) => $f->producto->precio_descuento ?? $f->producto->precio), 2) }}
                    </span>
                </div>
            </div>

        @else
            {{-- Estado vacío --}}
            <div class="empty-wishlist bg-white rounded-3 shadow-sm">
                <i class="bi bi-heart"></i>
                <h5 class="mt-3 fw-bold text-dark">Tu lista de favoritos está vacía</h5>
                <p class="text-muted mb-4">Explora nuestros productos y agrega los que más te gusten.</p>
                <a href="{{-- route('productos.index') --}}" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Explorar Productos
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@section('js')
<script>
    function eliminarFavorito(favId, productoId) {
        fetch('{{ route("wishlist.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ producto_id: productoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.accion === 'removed') {
                const item = document.getElementById('fav-item-' + favId);
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.remove();
                    // Si no quedan items, recargar para mostrar estado vacío
                    if (document.querySelectorAll('[id^="fav-item-"]').length === 0) {
                        location.reload();
                    }
                }, 300);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
