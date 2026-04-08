@extends('TEMPLATES.ecommerce')

@section('title', 'Checkout - Finalizar Compra')

@section('content')
<!-- BREADCRUMB -->
<section class="py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.cart') }}" class="text-decoration-none">Carrito</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</section>

<!-- CHECKOUT -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4">Finalizar Compra</h2>

        <form action="{{ route('ecommerce.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row g-4">
                <!-- FORMULARIO DE DATOS -->
                <div class="col-lg-7">
                    <!-- Información Personal -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-person-circle me-2 text-primary"></i>Información Personal
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                           name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                                           name="telefono" id="telefono" value="{{ old('telefono') }}" required>
                                    @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">DNI/RUC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                                           name="documento" id="documento" value="{{ old('documento') }}" required>
                                    @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección de Entrega -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-geo-alt me-2 text-primary"></i>Dirección de Instalación/Entrega
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Dirección Completa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                                           name="direccion" id="direccion" value="{{ old('direccion') }}" 
                                           placeholder="Calle, número, urbanización, referencia" required>
                                    @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                                    <select class="form-select" id="departamento_id" required>
                                        <option value="">Seleccionar</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Provincia <span class="text-danger">*</span></label>
                                    <select class="form-select" id="provincia_id" required>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Distrito <span class="text-danger">*</span></label>
                                    <select class="form-select @error('distrito_id') is-invalid @enderror" 
                                            name="distrito_id" id="distrito_id" required>
                                        <option value="">Seleccionar</option>
                                    </select>
                                    @error('distrito_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-credit-card me-2 text-primary"></i>Método de Pago
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="payment-method-card form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_tarjeta" value="tarjeta">
                                        <label class="form-check-label w-100" for="metodo_tarjeta">
                                            <strong><i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito/Débito</strong>
                                            <small class="d-block text-muted mt-1">Visa, Mastercard</small>
                                            <span class="culqi-badge"><i class="bi bi-shield-check"></i> Procesado por Culqi</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="payment-method-card form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_yape" value="yape">
                                        <label class="form-check-label w-100" for="metodo_yape">
                                            <strong><i class="bi bi-phone me-2"></i>Yape / Plin</strong>
                                            <small class="d-block text-muted mt-1">Pago móvil</small>
                                            <span class="culqi-badge"><i class="bi bi-shield-check"></i> Procesado por Culqi</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_transferencia" value="transferencia">
                                        <label class="form-check-label w-100" for="metodo_transferencia">
                                            <strong><i class="bi bi-bank me-2"></i>Transferencia Bancaria</strong>
                                            <small class="d-block text-muted mt-1">BCP, Interbank, BBVA</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="metodo_pago" 
                                               id="metodo_contraentrega" value="contraentrega">
                                        <label class="form-check-label w-100" for="metodo_contraentrega">
                                            <strong><i class="bi bi-cash me-2"></i>Contra Entrega</strong>
                                            <small class="d-block text-muted mt-1">Pago al recibir</small>
                                        </label>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-chat-text me-2 text-primary"></i>Observaciones (Opcional)
                            </h5>
                            <textarea class="form-control" id="observaciones" rows="3" 
                                      placeholder="Agrega cualquier indicación especial para tu pedido">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DEL PEDIDO -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Resumen del Pedido</h5>

                            <!-- Productos -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Productos ({{ count($cart) }})</h6>
                                @foreach($cart as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div style="width: 60px; height: 60px;" class="border rounded me-3">
                                        <img src="{{ asset($item['imagen_producto'] ?? 'images/logo.webp') }}" 
                                            class="w-100 h-100 object-fit-contain p-1" alt="{{ $item['name_producto'] }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 small">{{ Str::limit($item['name_producto'], 40) }}</p>
                                        <small class="text-muted">Cant: {{ $item['cantidad'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Totales -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-semibold">S/ {{ number_format($subtotal, 2) }}</span>
                                    <input type="hidden" id="subtotal" value="{{ $subtotal }}">
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Descuento:</span>
                                    <span class="fw-semibold">- S/ {{ number_format(0, 2) }}</span>
                                    <input type="hidden" id="descuento" value="0">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">IGV (18%):</span>
                                    <span class="fw-semibold">S/ {{ number_format($igv, 2) }}</span>
                                    <input type="hidden" id="igv" value="{{ $igv }}">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Envío:</span>
                                    <span class="fw-semibold text-success">GRATIS</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold fs-5">Total a Pagar:</span>
                                    <span class="fw-bold fs-4 text-primary">S/ {{ number_format($total, 2) }}</span>
                                    <input type="hidden" id="total" value="{{ $total }}">
                                </div>

                                <button onclick="selectPaymentMethod('card')" class="btn btn-primary w-100 py-3 fw-semibold mb-3" id="submitBtn">
                                    <i class="bi bi-shield-check me-2"></i>Confirmar Pedido
                                </button>

                                <a href="{{ route('ecommerce.cart') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Volver al carrito
                                </a>
                            </div>

                            <!-- Información de seguridad -->
                            <div class="mt-4 pt-4 border-top">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Compra 100% Segura</p>
                                        <small class="text-muted">Tus datos están protegidos</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-truck text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Envío Gratis</p>
                                        <small class="text-muted">A todo el Perú</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-return-left text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 small fw-semibold">Garantía de Devolución</p>
                                        <small class="text-muted">30 días para devolver</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Loading Overlay -->
    <div class="position-fixed top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center" id="loadingOverlay" style="background: rgba(0,0,0,0.7); z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"></div>
            <p class="text-white mt-3 fw-semibold">Procesando pago seguro...</p>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="https://checkout.culqi.com/js/v3"></script>

<script>
    $(document).ready(function() {
        $('#departamento_id').on('change', function() {
            valor_departamento = $(this).val();
            $.get('/ver_provincias',{valor_departamento:valor_departamento}, function(busqueda){
                $('#provincia_id').empty();
                $.each(busqueda, function(index, value){
                    $('#provincia_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });

        $('#provincia_id').on('change', function() {
            valor_provincia = $(this).val();
            $.get('/ver_distritos',{valor_provincia:valor_provincia}, function(busqueda){
                $('#distrito_id').empty();
                $.each(busqueda, function(index, value){
                    $('#distrito_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });
    });

</script>
<script>
    // Manejar el envío del formulario
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        let btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
    });
</script>

<!-- Proceso para ejecutar culqi -->

<script>
    const culqiPublicKey = "{{ config('services.culqi.public_key') ?: config('services.culqi.client_id') }}";
    const culqiAmount = {{ $culqiAmountPenCents ?? 0 }};
    const culqiEmail = "{{ auth()->check() ? auth()->user()->email : '' }}";
    const limpiarSesionRoute = "{{ route('limpiar-sesion-planes.get') }}";

    window.history.pushState({ pago: true }, '', window.location.href);
    window.addEventListener('popstate', function () {
        window.location.href = limpiarSesionRoute;
    });
    
    function openCulqiCheckout() {
        if (!window.Culqi) {
            alert('No se pudo cargar Culqi. Recarga la página e intenta nuevamente.');
            return;
        }

        if (!culqiPublicKey) {
            alert('Culqi no está configurado. Falta la llave pública.');
            return;
        }

        if (!culqiAmount || culqiAmount <= 0) {
            alert('No se encontró un monto válido para procesar el pago.');
            return;
        }

        Culqi.publicKey = culqiPublicKey;
        Culqi.settings({
            title: 'LEIDINGER Familias Empresarias',
            currency: 'PEN',
            amount: culqiAmount,
        });

        Culqi.options({
            lang: 'auto',
            installments: false,
            paymentMethods: {
                tarjeta: true,
                yape: false,
                bancaMovil: false,
                agente: false,
                billetera: false,
                cuotealo: false,
            },
        });

        Culqi.open();
    }

    function selectPaymentMethod(method) {
        if (method === 'card') {
            openCulqiCheckout();
        }
    }

    window.culqi = function () {
        const loadingOverlay = document.getElementById('loadingOverlay');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const nombre = document.getElementById('nombre')?.value;
        const email = document.getElementById('email')?.value;
        const telefono = document.getElementById('telefono')?.value;
        const documento = document.getElementById('documento')?.value;
        const direccion = document.getElementById('direccion')?.value;
        const departamento_id = document.getElementById('departamento_id')?.value;
        const distrito_id = document.getElementById('distrito_id')?.value;
        const provincia_id = document.getElementById('provincia_id')?.value;
        const subtotal = document.getElementById('subtotal')?.value;
        const descuento = document.getElementById('descuento')?.value;
        const igv = document.getElementById('igv')?.value;
        const total = document.getElementById('total')?.value;
        const observaciones = document.getElementById('observaciones')?.value;

        if (Culqi.token) {
            loadingOverlay.classList.remove('d-none');
            loadingOverlay.classList.add('d-flex');

            fetch("{{ route('pago_ecommerce.createCulqiCharge') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    token: Culqi.token.id,
                    nombre: nombre,
                    telefono: telefono,
                    documento: documento,
                    direccion: direccion,
                    departamento_id: departamento_id,
                    provincia_id: provincia_id,
                    distrito_id: distrito_id,
                    subtotal: subtotal,
                    descuento: descuento,
                    igv: igv,
                    total: total,
                    email: culqiEmail,
                    observaciones: observaciones,
                }),
            })
            .then(async (response) => {
                const data = await response.json();
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'No se pudo procesar el pago con Culqi.');
                }
                return data;
            })
            .then(() => {
                const alertHTML = `
                    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 10000; width: 90%; max-width: 500px;">
                        <div class="alert alert-success shadow-lg border-0 rounded-4 p-4 text-center" role="alert">
                            <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #198754;"></i>
                            <h4 class="alert-heading mt-3 mb-3">¡Pago Exitoso con Culqi!</h4>
                            <p class="mb-2">Bienvenido a LEIDINGER Familias Empresarias</p>
                            <hr>
                            <p class="mb-0 small">Recibirás un correo de confirmación. Redirigiendo...</p>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHTML);

                setTimeout(() => {
                    window.location.href = "/";
                }, 3000);
            })
            .catch((error) => {
                alert('Error en Culqi: ' + error.message);
            })
            .finally(() => {
                loadingOverlay.classList.remove('d-flex');
                loadingOverlay.classList.add('d-none');
            });
        } else if (Culqi.error) {
            alert(Culqi.error.user_message || 'No se pudo generar el token de Culqi.');
        }
    };

        document.getElementById('cardPaymentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            openCulqiCheckout();
        });
</script>

<!-- proceso de finalizacion de culqi -->
@endsection
