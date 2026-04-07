<div class="offcanvas offcanvas-end sidebar-nav" style="z-index: 10001" tabindex="-1" id="carrito_compras" data-bs-backdrop="false" aria-labelledby="carrito_comprasLabel">
    <div class="offcanvas-header border-bottom">
        <p class="h5 mb-0 fw-bold text-primary text-uppercase small" id="carrito_comprasLabel">Carrito de compras</p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body py-0">
        <ul class="list-unstyled">
            <li class="border-bottom" id="lista_carrito_id">
            </li>
        </ul>
    </div>
    <div class="offcanvas-footer border-top pt-1 pb-3 px-3">
        <p class="small" id="contador_productos">( 0 ) Producto(s) en el carrito</p>
        <p class="h4 fw-bold text-dark text-uppercase" id="montotal_productos">TOTAL: S/ 00.00</p>
        @if(session('carrito', []) && count(session('carrito', [])) > 0)
            <a href="{{ route('ecommerce_pago_carrito_compras.index') }}" id="button_carrito" class="btn btn-primary w-100">Ir al carrito</a>
        @else
            <a href="{{ route('ecommerce_pago_carrito_compras.index') }}" id="button_carrito" class="btn btn-primary w-100">Ir al carrito</a>
        @endif
    </div>
</div>