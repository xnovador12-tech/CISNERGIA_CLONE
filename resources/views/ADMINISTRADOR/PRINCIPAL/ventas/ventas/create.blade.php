@extends('TEMPLATES.administrador')
@section('title', 'NUEVA VENTA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">REGISTRAR NUEVA VENTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-ventas.index') }}">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva Venta</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if($pedido)
        <form action="{{ route('admin-ventas.store') }}" method="POST" id="formNuevaVenta">
            @csrf
            <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">

            <div class="row g-3">
                {{-- ====== COLUMNA IZQUIERDA: Info del Pedido ====== --}}
                <div class="col-md-8">

                    {{-- Información del Pedido --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Código:</strong> {{ $pedido->codigo }}</p>
                                    <p class="mb-1"><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1"><strong>Vendedor:</strong> {{ $pedido->usuario->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Estado:</strong>
                                        <span class="badge bg-warning text-dark">{{ ucfirst($pedido->estado) }}</span>
                                    </p>
                                    <p class="mb-1"><strong>Origen:</strong>
                                        <span class="badge bg-secondary">{{ ucfirst($pedido->origen) }}</span>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            {{-- Datos del Cliente --}}
                            <h6 class="text-uppercase fw-bold mb-2"><i class="bi bi-person me-1"></i>Cliente</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nombre:</strong> {{ $pedido->cliente->nombre_completo ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Documento:</strong> {{ $pedido->cliente->documento ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Correo:</strong> {{ $pedido->cliente->email ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente->telefono ?? 'N/A' }}</p>
                                    @if($pedido->cliente->razon_social)
                                        <p class="mb-1"><strong>Razón Social:</strong> {{ $pedido->cliente->razon_social }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detalles del Pedido --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalle de Productos / Servicios</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">N°</th>
                                            <th>Descripción</th>
                                            <th class="text-center">Cant.</th>
                                            <th class="text-end">P. Unit.</th>
                                            <th class="text-end">Desc.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pedido->detalles as $index => $detalle)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                {{ $detalle->descripcion }}
                                                <br><small class="text-muted">Tipo: {{ ucfirst($detalle->tipo) }}</small>
                                            </td>
                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                            <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                            <td class="text-end">S/ {{ number_format($detalle->descuento, 2) }}</td>
                                            <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Facturación --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Datos de Facturación</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Tipo de Comprobante <span class="text-danger">*</span></label>
                                    <select name="tiposcomprobante_id" id="selectTipoComprobante" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($tiposComprobante as $tipo)
                                            <option value="{{ $tipo->id }}" data-name="{{ strtolower($tipo->name) }}">{{ $tipo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">N° Comprobante</label>
                                    <div class="d-flex align-items-center bg-light rounded p-2" style="height: 38px;">
                                        <span class="fw-bold text-primary" id="lblSerieCorrelativo">-- Seleccione tipo --</span>
                                    </div>
                                    <small class="text-muted">Se genera automáticamente</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Condición de Pago <span class="text-danger">*</span></label>
                                    <select name="condicion_pago" id="condicionPago" class="form-select" required>
                                        <option value="Contado" {{ $pedido->condicion_pago == 'Contado' ? 'selected' : '' }}>Al Contado</option>
                                        <option value="Crédito" {{ $pedido->condicion_pago == 'Crédito' ? 'selected' : '' }}>A Crédito</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Tipo de Operación <span class="text-danger">*</span></label>
                                    <select name="tipo_operacion_id" id="selectTipoOperacion" class="form-select" required>
                                        @foreach($tiposOperacion as $op)
                                            <option value="{{ $op->id }}" data-code="{{ $op->code }}" {{ $op->code == '0101' ? 'selected' : '' }}>
                                                {{ $op->code }} - {{ $op->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" id="colTipoDetraccion" style="display: none;">
                                    <label class="form-label small fw-bold">Tipo de Detracción <span class="text-danger">*</span></label>
                                    <select name="tipo_detraccion_id" id="selectTipoDetraccion" class="form-select">
                                        <option value="">Seleccionar...</option>
                                        @foreach($tiposDetraccion as $det)
                                            <option value="{{ $det->id }}" data-porcentaje="{{ $det->porcentaje }}">
                                                {{ $det->code }} - {{ $det->descripcion }} ({{ $det->porcentaje }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Info Detracción calculada --}}
                            <div id="infoDetraccion" class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="small text-muted">Porcentaje Detracción:</span>
                                        <strong id="lblPctDetraccion">0%</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="small text-muted">Monto Detracción:</span>
                                        <strong class="text-danger" id="lblMontoDetraccion">S/ 0.00</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Sección de Cuotas (solo crédito) --}}
                            <div id="seccionCuotas" class="mt-4 p-3 bg-light border rounded" style="display: none;">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-calendar-check me-2"></i>Configuración de Cuotas
                                </h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">N° de Cuotas <span class="text-danger">*</span></label>
                                        <input type="number" id="selectNroCuotas" class="form-control form-control-sm" min="1" max="12" value="1" placeholder="1 - 12">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Plazo de Días <span class="text-danger">*</span></label>
                                        <select id="selectPlazoDias" class="form-select form-select-sm">
                                            <option value="15">Cada 15 días</option>
                                            <option value="30" selected>Cada 30 días</option>
                                            <option value="60">Cada 60 días</option>
                                            <option value="90">Cada 90 días</option>
                                        </select>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-2 d-flex justify-content-between align-items-center">
                                    <span>Cronograma Generado</span>
                                    <small class="text-muted">Total: S/ <span id="montoTotalCuotas">{{ number_format($pedido->total, 2, '.', '') }}</span></small>
                                </h6>
                                <table class="table table-sm table-bordered bg-white mb-0" id="tablaCuotas">
                                    <thead class="table-secondary small">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">N°</th>
                                            <th>Fecha Vencimiento</th>
                                            <th class="text-end">Importe (S/)</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Desglose de Pago --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Desglose de Pago</h5>
                            <button type="button" class="btn btn-sm btn-outline-light" id="btnAgregarPago">
                                <i class="bi bi-plus-circle me-1"></i>Agregar
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tablaDesglosePago">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="small text-uppercase fw-bold ps-3" style="min-width: 200px;">Método de Pago</th>
                                            <th class="small text-uppercase fw-bold" style="min-width: 160px;">Billetera</th>
                                            <th class="small text-uppercase fw-bold" style="min-width: 300px;">Cuenta Destino</th>
                                            <th class="small text-uppercase fw-bold" style="min-width: 150px;">Monto</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fila-pago">
                                            <td class="ps-3">
                                                <select name="pagos[0][mediopago_id]" class="form-select form-select-sm select-metodo">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach($mediosPago as $medio)
                                                        <option value="{{ $medio->id }}">{{ $medio->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="pagos[0][billetera]" class="form-select form-select-sm select-billetera" disabled>
                                                    <option value="">--</option>
                                                    <option value="Yape">Yape</option>
                                                    <option value="Plin">Plin</option>
                                                    <option value="Tunki">Tunki</option>
                                                    <option value="BIM">BIM</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="pagos[0][cuenta_bancaria_id]" class="form-select form-select-sm select-cuenta" disabled>
                                                    <option value="">--</option>
                                                    @foreach($cuentasBancarias as $cuenta)
                                                        <option value="{{ $cuenta->id }}">
                                                            {{ $cuenta->banco->name ?? 'Banco' }} - {{ $cuenta->numero_cuenta }} ({{ $cuenta->tipocuenta->name ?? '' }} {{ $cuenta->moneda->simbolo ?? '' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" name="pagos[0][monto]" class="form-control form-control-sm input-pago-monto" placeholder="0.00">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm text-danger btn-eliminar-pago" style="visibility: hidden;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-top-0">
                            <div class="row pt-2 pb-2">
                                <div class="col-md-3">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted small">Subtotal:</span>
                                        <span class="fw-bold">S/ {{ number_format($pedido->subtotal, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted small">IGV (18%):</span>
                                        <span class="fw-bold">S/ {{ number_format($pedido->igv, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted small">Descuento:</span>
                                        <span class="fw-bold text-danger">S/ {{ number_format($pedido->descuento_monto ?? 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="text-primary small fw-bold">TOTAL A PAGAR:</span>
                                        <span class="h4 mb-0 fw-bold text-primary">S/ {{ number_format($pedido->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2 pb-2 border-top" id="filaNeto" style="display: none;">
                                <div class="col-md-12 text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="text-success small fw-bold">NETO A COBRAR:</span>
                                        <span class="h4 mb-0 fw-bold text-success" id="lblMontoNeto">S/ {{ number_format($pedido->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====== COLUMNA DERECHA: Resumen y Acciones ====== --}}
                <div class="col-md-4">
                    {{-- Acciones --}}
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-success w-100 py-2 mb-2 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Registrar Venta
                            </button>
                            <a href="{{ route('admin-pedidos.show', $pedido) }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-left me-2"></i>Volver al Pedido
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
            <div class="alert alert-warning text-center py-5">
                <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No se especificó un pedido</h5>
                <p class="text-muted">Debe seleccionar un pedido pendiente para registrar una venta.</p>
                <a href="{{ route('admin-ventas.index') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-arrow-left me-1"></i>Volver a Ventas
                </a>
            </div>
        @endif
    </div>

    {{-- Modal de confirmación --}}
    <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="modalConfirmTitulo"></h5>
                    <p class="text-muted small mb-4" id="modalConfirmMensaje"></p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success flex-grow-1" id="btnConfirmarVenta">
                            <i class="bi bi-check-circle me-1"></i>Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const totalPedido = parseFloat("{{ $pedido ? $pedido->total : 0 }}");
        const seriesPreview = @json($seriesComprobante);

        // =====================================================
        // PREVIEW SERIE + CORRELATIVO
        // =====================================================
        function actualizarPreviewSerie() {
            const tipoId = $('#selectTipoComprobante').val();
            if (tipoId && seriesPreview[tipoId]) {
                $('#lblSerieCorrelativo').text(seriesPreview[tipoId]);
            } else {
                $('#lblSerieCorrelativo').text('-- Seleccione tipo --');
            }
        }

        $('#selectTipoComprobante').on('change', function() {
            actualizarPreviewSerie();
            aplicarReglasCondicionPago();
        });
        actualizarPreviewSerie();

        // =====================================================
        // REGLA: Boleta = solo Contado | Factura = Contado o Crédito
        // =====================================================
        const $condicion = $('#condicionPago');

        function aplicarReglasCondicionPago() {
            const tipoName = $('#selectTipoComprobante option:selected').data('name') || '';
            const esBoleta = tipoName.includes('boleta');

            if (esBoleta) {
                $condicion.val('Contado');
                $condicion.find('option[value="Crédito"]').prop('disabled', true);
                toggleCuotas();
            } else {
                $condicion.find('option[value="Crédito"]').prop('disabled', false);
            }
        }

        aplicarReglasCondicionPago();
        const $seccionCuotas = $('#seccionCuotas');
        const $tbody = $('#tablaCuotas tbody');

        // =====================================================
        // CUOTAS (Automático)
        // =====================================================
        function toggleCuotas() {
            if ($condicion.val() === 'Crédito') {
                $seccionCuotas.slideDown();
                generarCuotas();
            } else {
                $seccionCuotas.slideUp();
                $tbody.empty();
            }
        }

        function generarCuotas() {
            const nroCuotas = parseInt($('#selectNroCuotas').val()) || 1;
            const plazoDias = parseInt($('#selectPlazoDias').val()) || 30;
            const montoCuota = Math.floor((totalPedido / nroCuotas) * 100) / 100;
            const resto = Math.round((totalPedido - (montoCuota * nroCuotas)) * 100) / 100;

            $tbody.empty();

            for (let i = 0; i < nroCuotas; i++) {
                const fechaVenc = new Date();
                fechaVenc.setDate(fechaVenc.getDate() + (plazoDias * (i + 1)));
                const fechaStr = fechaVenc.toISOString().split('T')[0];
                const fechaDisplay = fechaVenc.toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric' });

                // La última cuota absorbe el resto para que sume exacto
                const importe = (i === nroCuotas - 1) ? (montoCuota + resto).toFixed(2) : montoCuota.toFixed(2);

                const row = `
                    <tr>
                        <td class="align-middle text-center fw-bold">${i + 1}</td>
                        <td class="align-middle">${fechaDisplay}
                            <input type="hidden" name="cuotas[${i}][fecha_vencimiento]" value="${fechaStr}">
                        </td>
                        <td class="align-middle text-end fw-bold">S/ ${parseFloat(importe).toLocaleString('es-PE', {minimumFractionDigits: 2})}
                            <input type="hidden" name="cuotas[${i}][importe]" value="${importe}">
                        </td>
                    </tr>
                `;
                $tbody.append(row);
            }
        }

        toggleCuotas();
        $condicion.on('change', toggleCuotas);
        $('#selectNroCuotas').on('input', function() {
            let val = parseInt($(this).val());
            if (val > 12) $(this).val(12);
            if (val < 1) $(this).val(1);
        });

        $('#selectNroCuotas, #selectPlazoDias').on('change input', function() {
            if ($condicion.val() === 'Crédito') {
                generarCuotas();
            }
        });

        // =====================================================
        // TIPO DE OPERACIÓN / DETRACCIÓN
        // =====================================================
        const $selectOperacion = $('#selectTipoOperacion');
        const $colDetraccion = $('#colTipoDetraccion');
        const $selectDetraccion = $('#selectTipoDetraccion');
        const $infoDetraccion = $('#infoDetraccion');

        function toggleDetraccion() {
            const code = String($selectOperacion.find('option:selected').data('code'));
            if (code === '1001') {
                $colDetraccion.slideDown();
                $selectDetraccion.prop('required', true);
            } else {
                $colDetraccion.slideUp();
                $selectDetraccion.prop('required', false).val('');
                $infoDetraccion.slideUp();
                $('#filaNeto').slideUp();
            }
        }

        $selectOperacion.on('change', toggleDetraccion);
        toggleDetraccion();

        $selectDetraccion.on('change', function() {
            const porcentaje = parseFloat($(this).find('option:selected').data('porcentaje') || 0);
            if (porcentaje > 0) {
                const montoDetraccion = (totalPedido * porcentaje / 100).toFixed(2);
                const montoNeto = (totalPedido - montoDetraccion).toFixed(2);
                $('#lblPctDetraccion').text(porcentaje + '%');
                $('#lblMontoDetraccion').text('S/ ' + montoDetraccion);
                $('#lblMontoNeto').text('S/ ' + montoNeto);
                $infoDetraccion.slideDown();
                $('#filaNeto').slideDown();
            } else {
                $infoDetraccion.slideUp();
                $('#filaNeto').slideUp();
            }
        });

        // =====================================================
        // DESGLOSE DE PAGO (múltiples filas)
        // =====================================================
        const opcionesMedios = `<option value="">Seleccionar...</option>@foreach($mediosPago as $medio)<option value="{{ $medio->id }}">{{ $medio->name }}</option>@endforeach`;
        const opcionesCuentas = `<option value="">--</option>@foreach($cuentasBancarias as $cuenta)<option value="{{ $cuenta->id }}">{{ $cuenta->banco->name ?? 'Banco' }} - {{ $cuenta->numero_cuenta }} ({{ $cuenta->tipocuenta->name ?? '' }} {{ $cuenta->moneda->simbolo ?? '' }})</option>@endforeach`;

        function detectarTipoMedio(texto) {
            texto = texto.toLowerCase().trim();
            if (texto.includes('billetera') || texto.includes('digital')) return 'billetera';
            if (texto.includes('transferencia') || texto.includes('depósito') || texto.includes('deposito') || texto.includes('banco')) return 'banco';
            return 'otro';
        }

        function aplicarLogicaFila($fila) {
            const texto = $fila.find('.select-metodo option:selected').text();
            const tipo = detectarTipoMedio(texto);
            const $billetera = $fila.find('.select-billetera');
            const $cuenta = $fila.find('.select-cuenta');

            if (tipo === 'billetera') {
                $billetera.prop('disabled', false);
                $cuenta.prop('disabled', false);
            } else if (tipo === 'banco') {
                $billetera.prop('disabled', true).val('');
                $cuenta.prop('disabled', false);
            } else {
                $billetera.prop('disabled', true).val('');
                $cuenta.prop('disabled', true).val('');
            }
        }

        $(document).on('change', '.select-metodo', function() {
            aplicarLogicaFila($(this).closest('.fila-pago'));
        });

        // Agregar fila
        $('#btnAgregarPago').on('click', function() {
            const $tbodyPago = $('#tablaDesglosePago tbody');
            const index = $tbodyPago.find('.fila-pago').length;

            const row = `
                <tr class="fila-pago">
                    <td class="ps-3">
                        <select name="pagos[${index}][mediopago_id]" class="form-select form-select-sm select-metodo">
                            ${opcionesMedios}
                        </select>
                    </td>
                    <td>
                        <select name="pagos[${index}][billetera]" class="form-select form-select-sm select-billetera" disabled>
                            <option value="">--</option>
                            <option value="Yape">Yape</option>
                            <option value="Plin">Plin</option>
                            <option value="Tunki">Tunki</option>
                            <option value="BIM">BIM</option>
                        </select>
                    </td>
                    <td>
                        <select name="pagos[${index}][cuenta_bancaria_id]" class="form-select form-select-sm select-cuenta" disabled>
                            ${opcionesCuentas}
                        </select>
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0" name="pagos[${index}][monto]" class="form-control form-control-sm input-pago-monto" placeholder="0.00">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm text-danger btn-eliminar-pago"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `;
            $tbodyPago.append(row);
            actualizarBotonesPago();
        });

        // Eliminar fila
        $(document).on('click', '.btn-eliminar-pago', function() {
            $(this).closest('.fila-pago').remove();
            reindexarPagos();
            actualizarBotonesPago();
        });

        function reindexarPagos() {
            $('#tablaDesglosePago tbody .fila-pago').each(function(i) {
                $(this).find('.select-metodo').attr('name', `pagos[${i}][mediopago_id]`);
                $(this).find('.select-billetera').attr('name', `pagos[${i}][billetera]`);
                $(this).find('.select-cuenta').attr('name', `pagos[${i}][cuenta_bancaria_id]`);
                $(this).find('.input-pago-monto').attr('name', `pagos[${i}][monto]`);
            });
        }

        function actualizarBotonesPago() {
            const filas = $('#tablaDesglosePago tbody .fila-pago');
            filas.find('.btn-eliminar-pago').css('visibility', filas.length > 1 ? 'visible' : 'hidden');
        }

        actualizarBotonesPago();

        // =====================================================
        // VALIDACIÓN FINAL
        // =====================================================
        let ventaConfirmada = false;

        $('#formNuevaVenta').on('submit', function(e) {
            if (ventaConfirmada) return;

            let sumaPagos = 0;
            $('.input-pago-monto').each(function() {
                sumaPagos += parseFloat($(this).val() || 0);
            });

            let necesitaConfirmar = false;
            let titulo = '';
            let mensaje = '';

            if (sumaPagos === 0) {
                necesitaConfirmar = true;
                titulo = 'Sin monto de pago';
                mensaje = 'No se ha ingresado ningún monto. La venta se registrará como PARCIAL (pendiente de pago).';
            } else if (sumaPagos < totalPedido - 0.05) {
                necesitaConfirmar = true;
                titulo = 'Pago parcial';
                mensaje = `La suma de los pagos (S/ ${sumaPagos.toFixed(2)}) es menor al total (S/ ${totalPedido.toFixed(2)}). La venta se registrará como PARCIAL.`;
            }

            if (necesitaConfirmar) {
                e.preventDefault();
                $('#modalConfirmTitulo').text(titulo);
                $('#modalConfirmMensaje').text(mensaje);
                new bootstrap.Modal('#modalConfirmacion').show();
            }
        });

        $('#btnConfirmarVenta').on('click', function() {
            ventaConfirmada = true;
            bootstrap.Modal.getInstance('#modalConfirmacion').hide();
            $('#formNuevaVenta').submit();
        });
    });
</script>
@endsection
