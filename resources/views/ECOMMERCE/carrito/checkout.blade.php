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
                                        name="nombre" id="nombre" value="{{Auth::user()->persona->name}}" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{Auth::user()->email}}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                                        name="telefono" id="telefono" value="{{Auth::user()->persona->celular}}" required>
                                    @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">DNI/RUC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('documento') is-invalid @enderror"
                                        name="documento" id="documento" maxlength="11"
                                        value="{{Auth::user()->persona->nro_identificacion}}" required>
                                    <div id="doc-hint" class="form-text"></div>
                                    @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- COMPROBANTE DE PAGO --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo de Comprobante <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tiposcomprobante_id') is-invalid @enderror"
                                            name="tiposcomprobante_id" id="tipo_comprobante" disabled required>
                                        <option value="">— Ingresa DNI o RUC primero —</option>
                                        <option value="3">Nota de venta</option>
                                        <option value="2">Boleta de Venta</option>
                                        <option value="1">Factura</option>
                                    </select>
                                    @error('tiposcomprobante_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- RAZÓN SOCIAL (solo visible si es Factura) --}}
                                <div class="col-md-6" id="razon-social-group" style="display: none;">
                                    <label class="form-label fw-semibold">Razón Social <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror"
                                        name="razon_social" id="razon_social" placeholder="Nombre de tu empresa">
                                    @error('razon_social')
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
                                {{-- Hidden: qué dirección_id se envía al backend --}}
                                <input type="hidden" name="direccion_id" id="direccion_id_hidden" value="">

                                {{-- Select principal --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        Dirección de Instalación/Entrega <span class="text-danger">*</span>
                                    </label>
                                    <select id="direccion_select" class="form-select" onchange="toggleNuevaDireccion(this.value)">
                                        <option value="">— Seleccionar dirección —</option>
                                        @foreach($direcciones as $dir)
                                            <option value="{{ $dir->id }}"
                                                data-departamento="{{ $dir->departamento_id }}"
                                                data-provincia="{{ $dir->provincia_id }}"
                                                data-distrito="{{ $dir->distrito_id }}">
                                                {{ $dir->direccion }}, {{ $dir->distrito->nombre }}
                                            </option>
                                        @endforeach
                                        <option value="nueva">+ Agregar nueva dirección</option>
                                    </select>
                                </div>

                                {{-- Preview de dirección guardada seleccionada --}}
                                <div class="col-12" id="direccion-preview" style="display: none;">
                                    <div class="alert alert-light border d-flex align-items-center gap-2 py-2 mb-0">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                        <span id="direccion-preview-texto" class="small"></span>
                                    </div>
                                </div>

                                {{-- Formulario nueva dirección (oculto por defecto) --}}
                                <div id="nueva-direccion-form" style="display: none;" class="col-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">
                                                Dirección Completa <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('direccion') is-invalid @enderror"
                                                name="direccion"
                                                id="direccion"
                                                value="{{ old('direccion') }}"
                                                placeholder="Calle, número, urbanización, referencia">
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                Departamento <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="departamento_id">
                                                <option value="">Seleccionar</option>
                                                @foreach($departamentos as $dep)
                                                    <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                Provincia <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="provincia_id">
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                Distrito <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('distrito_id') is-invalid @enderror"
                                                    name="distrito_id"
                                                    id="distrito_id">
                                                <option value="">Seleccionar</option>
                                            </select>
                                            @error('distrito_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="guardar_direccion" id="guardar_direccion" value="1">
                                                <label class="form-check-label small text-muted" for="guardar_direccion">
                                                    Guardar esta dirección para futuros pedidos
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
                                      name="observaciones"
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
                                    @if($cupon_aplicado)
                                        <span class="badge bg-success ms-2">{{ $cupon_aplicado->codigo }} ({{ $cupon_aplicado->porcentaje }}%)</span>
                                        <input type="hidden" id="descuento_porcentaje" value="{{ $cupon_aplicado->porcentaje }}">
                                    @endif
                                    <span class="fw-semibold">- S/ {{ number_format($descuento, 2) }}</span>
                                    <input type="hidden" id="descuento" value="{{ $descuento }}">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">IGV (18%):</span>
                                    <span class="fw-semibold" id="html_igv">S/ {{ number_format($igv, 2) }}</span>
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
                                    <span class="fw-bold fs-4 text-primary" id="html_total">S/ {{ number_format($total, 2) }}</span>
                                    <input type="hidden" id="total" value="{{ $total }}">
                                </div>

                                <button type="button" class="btn btn-primary w-100 py-3 fw-semibold mb-3" id="submitBtn">
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
{{-- <script src="https://checkout.culqi.com/js/v3"></script> --}}  {{-- CULQI DESACTIVADO (sin tokens aún) --}}

<script>
    $(document).ready(function() {
        $('#departamento_id').on('change', function() {
            valor_departamento = $(this).val();
            $.get('/ver_provincias',{valor_departamento:valor_departamento}, function(busqueda){
                $('#provincia_id').empty();
                $('#provincia_id').append('<option selected disabled>Seleccionar</option>');
                $.each(busqueda, function(index, value){
                    $('#provincia_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });

        $('#provincia_id').on('change', function() {
            valor_provincia = $(this).val();
            $.get('/ver_distritos',{valor_provincia:valor_provincia}, function(busqueda){
                $('#distrito_id').empty();
                $('#distrito_id').append('<option selected disabled>Seleccionar</option>');
                $.each(busqueda, function(index, value){
                    $('#distrito_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });
    });

</script>
<script>
    const checkoutForm = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');

    function getCsrfToken() {
        const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (metaToken) {
            return metaToken;
        }

        const inputToken = checkoutForm?.querySelector('input[name="_token"]')?.value;
        return inputToken || '';
    }

    function setSubmitButtonState(isLoading, label = 'Confirmar Pedido') {
        if (!submitBtn) {
            return;
        }

        submitBtn.disabled = isLoading;
        submitBtn.innerHTML = isLoading
            ? '<span class="spinner-border spinner-border-sm me-2"></span>' + label
            : '<i class="bi bi-shield-check me-2"></i>' + label;
    }
</script>

<!-- Proceso para ejecutar culqi -->

<script>
    const culqiPublicKey = "{{ config('services.culqi.public_key') ?: config('services.culqi.client_id') }}";
    const culqiAmount = {{ $culqiAmountPenCents ?? 0 }};
    const culqiEmail = "{{ auth()->check() ? auth()->user()->email : '' }}";
    
    function openCulqiCheckout(method) {
        if (!window.Culqi) {
            alert('No se pudo cargar Culqi. Recarga la página e intenta nuevamente.');
            setSubmitButtonState(false);
            return;
        }

        if (!culqiPublicKey) {
            alert('Culqi no está configurado. Falta la llave pública.');
            setSubmitButtonState(false);
            return;
        }

        if (!culqiAmount || culqiAmount <= 0) {
            alert('No se encontró un monto válido para procesar el pago.');
            setSubmitButtonState(false);
            return;
        }

        Culqi.publicKey = culqiPublicKey;
        Culqi.settings({
            title: 'CISNERGIA PERU',
            currency: 'PEN',
            amount: culqiAmount,
        });

        Culqi.options({
            lang: 'auto',
            installments: false,
            paymentMethods: {
                tarjeta: method === 'tarjeta',
                yape: method === 'yape',
                bancaMovil: false,
                agente: false,
                billetera: false,
                cuotealo: false,
            },
        });

        Culqi.open();
    }

    function selectPaymentMethod() {
        if (!checkoutForm.checkValidity()) {
            checkoutForm.reportValidity();
            return;
        }

        const selectedMethod = document.querySelector('input[name="metodo_pago"]:checked')?.value || 'tarjeta';
        setSubmitButtonState(true, 'Abriendo Culqi...');
        openCulqiCheckout(selectedMethod);
    }

    submitBtn?.addEventListener('click', function (event) {
        event.preventDefault();

        // ── BYPASS CULQI: envío directo al backend para pruebas ──
        if (!checkoutForm.checkValidity()) {
            checkoutForm.reportValidity();
            return;
        }
        setSubmitButtonState(true, 'Procesando...');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const csrfToken = getCsrfToken();
        const metodo_pago = document.querySelector('input[name="metodo_pago"]:checked')?.value || 'tarjeta';

        loadingOverlay?.classList.remove('d-none');
        loadingOverlay?.classList.add('d-flex');

        fetch("{{ route('pago_ecommerce.createCulqiCharge') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                token: 'TEST_BYPASS',
                nombre:           document.getElementById('nombre')?.value,
                email:            document.getElementById('email')?.value || culqiEmail,
                telefono:         document.getElementById('telefono')?.value,
                documento:        document.getElementById('documento')?.value,
                direccion:        document.getElementById('direccion')?.value,
                departamento_id:  document.getElementById('departamento_id')?.value,
                provincia_id:     document.getElementById('provincia_id')?.value,
                distrito_id:      document.getElementById('distrito_id')?.value,
                // ↓ Estos tres son los que faltaban:
                direccion_id:     document.getElementById('direccion_id_hidden')?.value,
                guardar_direccion: document.getElementById('guardar_direccion')?.checked ? '1' : '0',
                tiposcomprobante_id: document.getElementById('tipo_comprobante')?.value,
                subtotal:         document.getElementById('subtotal')?.value,
                descuento_porcentaje: document.getElementById('descuento_porcentaje')?.value || '0',
                descuento:        document.getElementById('descuento')?.value,
                igv:              document.getElementById('igv')?.value,
                total:            document.getElementById('total')?.value,
                observaciones:    document.getElementById('observaciones')?.value,
                metodo_pago:      metodo_pago,
            }),
        })
        .then(async (response) => {
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'Error al procesar.');
            return data;
        })
        .then((data) => {
            const ventaSlug = data?.venta_slug;
            if (!ventaSlug) {
                throw new Error('No se recibio el slug de la venta.');
            }

            const confirmUrl = `{{ route('ecommerce.confirmacion_pago', ['sale' => '__SALE_SLUG__']) }}`
                .replace('__SALE_SLUG__', encodeURIComponent(ventaSlug));

            window.location.href = confirmUrl;
        })
        .catch((error) => {
            alert('Error: ' + error.message);
        })
        .finally(() => {
            setSubmitButtonState(false);
            loadingOverlay?.classList.remove('d-flex');
            loadingOverlay?.classList.add('d-none');
        });
        // ── FIN BYPASS ──

        // selectPaymentMethod(); // ← Descomentar cuando Culqi esté configurado
    });

    window.culqi = function () {
        const loadingOverlay = document.getElementById('loadingOverlay');
        const csrfToken = getCsrfToken();
        const nombre = document.getElementById('nombre')?.value;
        const email = document.getElementById('email')?.value;
        const telefono = document.getElementById('telefono')?.value;
        const documento = document.getElementById('documento')?.value;
        const direccion = document.getElementById('direccion')?.value;
        const departamento_id = document.getElementById('departamento_id')?.value;
        const distrito_id = document.getElementById('distrito_id')?.value;
        const provincia_id = document.getElementById('provincia_id')?.value;
        const subtotal = document.getElementById('subtotal')?.value;
        const descuento_porcentaje = document.getElementById('descuento_porcentaje')?.value || '0';
        const descuento = document.getElementById('descuento')?.value;
        const igv = document.getElementById('igv')?.value;
        const total = document.getElementById('total')?.value;
        const observaciones = document.getElementById('observaciones')?.value;
        const metodo_pago = document.querySelector('input[name="metodo_pago"]:checked')?.value || 'tarjeta';

        if (Culqi.token) {
            setSubmitButtonState(true, 'Procesando...');
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
                    descuento_porcentaje: descuento_porcentaje,
                    igv: igv,
                    total: total,
                    email: email || culqiEmail,
                    metodo_pago: metodo_pago,
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
            .then((data) => {
                const alertHTML = `
                    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 10000; width: 90%; max-width: 500px;">
                        <div class="alert alert-success shadow-lg border-0 rounded-4 p-4 text-center" role="alert">
                            <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #198754;"></i>
                            <h4 class="alert-heading mt-3 mb-3">¡Pago Exitoso con Culqi!</h4>
                            <p class="mb-2">Bienvenido a CISNERGIA PERU</p>
                            <hr>
                            <p class="mb-0 small">Recibirás un correo de confirmación. Redirigiendo...</p>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHTML);

                const ventaSlug = data?.venta_slug;
                if (!ventaSlug) {
                    throw new Error('No se recibio el slug de la venta.');
                }

                const confirmUrl = `{{ route('ecommerce.confirmacion_pago', ['sale' => '__SALE_SLUG__']) }}`
                    .replace('__SALE_SLUG__', encodeURIComponent(ventaSlug));

                setTimeout(() => {
                    window.location.href = confirmUrl;
                }, 3000);
            })
            .catch((error) => {
                alert('Error en Culqi: ' + error.message);
            })
            .finally(() => {
                setSubmitButtonState(false);
                loadingOverlay.classList.remove('d-flex');
                loadingOverlay.classList.add('d-none');
            });
        } else if (Culqi.error) {
            setSubmitButtonState(false);
            alert(Culqi.error.user_message || 'No se pudo generar el token de Culqi.');
        }
    };
</script>
<!-- proceso de finalizacion de culqi -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const subtotalBase = parseFloat(document.getElementById('subtotal').value);
    const igvBase      = parseFloat(document.getElementById('igv').value);
    const totalBase    = parseFloat(document.getElementById('total').value);

    const docInput = document.getElementById('documento');
    const select   = document.getElementById('tipo_comprobante');
    const hint     = document.getElementById('doc-hint');
    const razonGrp = document.getElementById('razon-social-group');
    const razonInp = document.getElementById('razon_social');


    function recalcularIGV(tipoComprobante) {
        const esNotaVenta = tipoComprobante === '3';
        const igvMonto   = esNotaVenta ? 0 : igvBase;
        const totalMonto = esNotaVenta ? subtotalBase : totalBase;

        // Inputs hidden → van al backend
        document.getElementById('igv').value   = igvMonto.toFixed(2);
        document.getElementById('total').value = totalMonto.toFixed(2);

        // HTML visible → siempre actualiza el texto
        document.getElementById('html_igv').textContent = 'S/ ' + igvMonto.toFixed(2);
        document.getElementById('html_total').textContent = 'S/ ' + totalMonto.toFixed(2);
    }

    // Ejecutar al cargar si ya viene un valor prellenado
    handleDocumento();

    docInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
        handleDocumento();
    });

    select.addEventListener('change', function () {
        const esFact = this.value === '1';
        razonGrp.style.display = esFact ? '' : 'none';
        razonInp.required = esFact;
        if (!esFact) razonInp.value = '';

        recalcularIGV(this.value);
    });

    function handleDocumento() {
        const len = docInput.value.length;
        select.value = '';
        razonGrp.style.display = 'none';
        razonInp.required = false;

        if (len === 0) {
            hint.textContent = '';
            hint.className = 'form-text';
            select.disabled = true;
            select.options[0].text = '— Ingresa DNI o RUC primero —';

        } else if (len < 8) {
            hint.textContent = `${len} dígitos — faltan ${8 - len} para DNI`;
            hint.className = 'form-text text-danger';
            select.disabled = true;
            select.options[0].text = '— Completando documento —';

        } else if (len === 8) {
            hint.textContent = 'DNI detectado — solo Boleta o Nota de venta disponibles';
            hint.className = 'form-text text-success';
            select.disabled = false;
            select.options[0].text = '— Seleccionar —';
            select.querySelector('option[value="1"]').disabled = true;
            select.value = '2';

            recalcularIGV(2);

        } else if (len > 8 && len < 11) {
            hint.textContent = `${len} dígitos — faltan ${11 - len} para RUC`;
            hint.className = 'form-text text-danger';
            select.disabled = true;
            select.options[0].text = '— Completando documento —';

        } else if (len === 11) {
            hint.textContent = 'RUC detectado — Boleta o Factura disponibles';
            hint.className = 'form-text text-success';
            select.disabled = false;
            select.options[0].text = '— Seleccionar —';
            select.querySelector('option[value="1"]').disabled = false;
            select.value = '1';
            razonGrp.style.display = '';
            razonInp.required = true;

            recalcularIGV(11);
        }
    }
});
</script>

<!-- codigo para escoger entre direccion o crear nuevas -->
<script>
function toggleNuevaDireccion(valor) {
    const formNueva   = document.getElementById('nueva-direccion-form');
    const preview     = document.getElementById('direccion-preview');
    const hiddenId    = document.getElementById('direccion_id_hidden');
    const inputDir    = document.getElementById('direccion');
    const selDistrito = document.getElementById('distrito_id');

    if (valor === 'nueva') {
        // Mostrar formulario nuevo, ocultar preview
        formNueva.style.display = 'block';
        preview.style.display   = 'none';
        hiddenId.value          = '';

        // Hacer campos requeridos
        inputDir.required    = true;
        selDistrito.required = true;

    } else if (valor === '') {
        // Nada seleccionado
        formNueva.style.display = 'none';
        preview.style.display   = 'none';
        hiddenId.value          = '';
        inputDir.required       = false;
        selDistrito.required    = false;

    } else {
        // Dirección guardada seleccionada
        formNueva.style.display = 'none';
        hiddenId.value          = valor;
        inputDir.required       = false;
        selDistrito.required    = false;

        // Mostrar preview con el texto de la option
        const select      = document.getElementById('direccion_select');
        const opcion      = select.options[select.selectedIndex];
        const previewText = document.getElementById('direccion-preview-texto');
        previewText.textContent = opcion.text;
        preview.style.display   = 'block';
    }
}
</script>
@endsection
