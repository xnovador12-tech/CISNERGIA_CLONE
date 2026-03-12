@extends('TEMPLATES.administrador')

@section('title', 'EMITIR COMPROBANTE')

@section('css')
    <style>
        :root {
            --vt-primary: #1864ac;
            --vt-success: #10b981;
            --vt-warning: #f59e0b;
            --vt-dark: #1e293b;
            --vt-bg: #f8fafc;
        }

        .section-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--vt-dark);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title i {
            color: var(--vt-primary);
            font-size: 1.1rem;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.35rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
            border-color: #cbd5e1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--vt-primary);
            box-shadow: 0 0 0 3px rgba(24, 100, 172, 0.1);
        }

        .input-readonly {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            pointer-events: none;
        }

        .table-detalles,
        .table-cuotas {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-detalles th,
        .table-cuotas th {
            background: var(--vt-bg);
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .table-detalles td,
        .table-cuotas td {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .totales-box {
            background: var(--vt-bg);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px dashed #cbd5e1;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
        }

        .total-final {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #e2e8f0;
            font-size: 1.2rem;
            font-weight: 900;
            color: var(--vt-primary);
        }

        .total-neto {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            font-size: 1.4rem;
            font-weight: 900;
            color: var(--vt-success);
        }

        .btn-remove {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-remove:hover {
            background: #ef4444;
            color: #fff;
        }

        .detraccion-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1rem;
        }

        .cuotas-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0"><i class="bi bi-file-earmark-plus me-2"></i> Emitir Comprobante
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-comprobantes.index') }}">Comprobantes</a></li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-comprobantes.store') }}" method="POST" id="formVenta" enctype="multipart/form-data">
            @csrf
            
            {{-- Campos Ocultos para envío de totales calculados --}}
            <input type="hidden" name="pedido_id" id="pedido_id_hidden">
            <input type="hidden" name="subtotal_hidden" id="subtotal_hidden" value="0">
            <input type="hidden" name="igv_hidden" id="igv_hidden" value="0">
            <input type="hidden" name="total_hidden" id="total_hidden" value="0">

            {{-- BLOQUE PARA MOSTRAR ERRORES DE LARAVEL --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <h6 class="fw-bold"><i class="bi bi-exclamation-triangle"></i> Revisa los siguientes errores:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- FIN BLOQUE DE ERRORES --}}

            {{-- 0. BUSCAR PEDIDO (OPCIONAL) --}}
            <div class="section-card" style="border: 2px solid var(--vt-primary);">
                <div class="section-title"><i class="bi bi-search"></i> Importar desde Pedido (Opcional)</div>
                <div class="row g-3">
                    <div class="col-md-10">
                        <select id="select_pedido_id" class="form-select select2">
                            <option value="">-- Seleccione un pedido para autocompletar --</option>
                            @foreach ($pedidos as $p)
                                <option value="{{ $p->id }}">
                                    PEDIDO: {{ $p->codigo }} | CLIENTE: {{ $p->cliente?->nombre_completo }} | TOTAL: S/ {{ number_format($p->total, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-dark w-100 fw-bold" id="btn_importar_pedido">
                            <i class="bi bi-download me-1"></i> IMPORTAR
                        </button>
                    </div>
                </div>
                <small class="text-muted"><i class="bi bi-info-circle"></i> Al importar, se llenarán los datos del cliente, los servicios y las cuotas de pago automáticamente.</small>
            </div>

            {{-- 1. DATOS DEL CLIENTE --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-building"></i> Datos del Cliente (Empresa)</div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Cliente <span class="text-danger">*</span></label>
                        <select name="cliente_id" id="cliente_id" class="form-select select2" required>
                            <option value="">Seleccione o busque un cliente...</option>
                            @foreach ($clientes as $cli)
                                <option value="{{ $cli->id }}" 
                                    data-ruc="{{ $cli->documento }}"
                                    data-direccion="{{ $cli->direccion }}">
                                    {{ $cli->razon_social ?? $cli->nombre_completo }} ({{ $cli->documento }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">RUC / DNI</label>
                        <input type="text" id="cli_ruc" class="form-control input-readonly" readonly
                            placeholder="Se llena auto.">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Dirección Fiscal</label>
                        <input type="text" id="cli_dir" class="form-control input-readonly" readonly
                            placeholder="Se llena auto.">
                    </div>
                </div>
            </div>

            {{-- 2. DATOS DEL COMPROBANTE --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-receipt"></i> Datos del Comprobante</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tipo Comprobante <span class="text-danger">*</span></label>
                        <select name="tipo_comprobante_id" id="tipo_comprobante_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach ($tiposComprobante as $tc)
                                <option value="{{ $tc->id }}">{{ $tc->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Serie <span class="text-danger">*</span></label>
                        <select name="serie_id" id="serie_id" class="form-select" required disabled>
                            <option value="">Seleccione Serie</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número Generado</label>
                        <div class="fw-bold font-monospace text-primary fs-5 mt-1" id="preview_numero">------</div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Moneda <span class="text-danger">*</span></label>
                        <select name="moneda_id" class="form-select" required>
                            @foreach ($monedas as $moneda)
                                <option value="{{ $moneda->id }}" {{ $moneda->codigo == 'PEN' || $moneda->codigo == 'SOLES' ? 'selected' : '' }}>
                                    {{ $moneda->codigo }} - {{ $moneda->name ?? $moneda->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fecha Emisión <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_emision" id="fecha_emision" class="form-control fw-bold"
                            value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tipo Operación <span class="text-danger">*</span></label>
                        <select name="tipo_operacion_id" id="tipo_operacion_id" class="form-select" required>
                            @foreach ($tiposOperacion as $to)
                                <option value="{{ $to->id }}" {{ $to->code == '0101' ? 'selected' : '' }}>
                                    {{ $to->code }} - {{ $to->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Condición de Pago <span class="text-danger">*</span></label>
                        <select name="tipo_pago" id="tipo_pago" class="form-select fw-bold text-primary" required>
                            <option value="Contado">Contado (1 sola cuota)</option>
                            <option value="Credito">Crédito (En cuotas)</option>
                        </select>
                    </div>

                    <div class="col-md-2" id="box_cuotas" style="display:none;">
                        <label class="form-label text-primary">N° de Cuotas <span class="text-danger">*</span></label>
                        <input type="number" name="numero_cuotas" id="numero_cuotas" class="form-control fw-bold"
                            value="1" min="1" max="24">
                    </div>

                    {{-- CAJA DE DETRACCIÓN --}}
                    <div class="col-md-12" id="box_detraccion" style="display:none;">
                        <div class="detraccion-box">
                            <h6 class="text-warning fw-bold mb-3"><i class="bi bi-shield-check"></i> Datos de Detracción
                                (Autodetraído)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Bien o Servicio Sujeto a Detracción</label>
                                    <select name="detraccion[tipo_detraccion_id]" id="tipo_detraccion_id"
                                        class="form-select">
                                        <option value="">Seleccione...</option>
                                        @foreach ($tiposDetraccion as $td)
                                            <option value="{{ $td->id }}" data-porcentaje="{{ $td->porcentaje }}">
                                                {{ $td->code }} - {{ $td->descripcion }} ({{ $td->porcentaje }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Medio de Pago Detracción</label>
                                    @php
                                        $medioPagoDetrac =
                                            $mediosPagoDetrac->firstWhere('codigo', '001') ??
                                            $mediosPagoDetrac->first();
                                    @endphp
                                    <input type="hidden" name="detraccion[medio_pago_detraccion_id]"
                                        value="{{ $medioPagoDetrac->id ?? '' }}">
                                    <div class="form-control input-readonly bg-light">
                                        {{ $medioPagoDetrac ? $medioPagoDetrac->codigo . ' - ' . $medioPagoDetrac->descripcion : 'Depósito en cuenta' }}
                                    </div>
                                    <small class="text-muted"><i class="bi bi-info-circle"></i> Siempre se usará depósito
                                        en la cuenta del Banco de la Nación.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DESGLOSE DE CUOTAS --}}
                    <div class="col-md-12" id="box_desglose_cuotas" style="display:none;">
                        <div class="cuotas-box">
                            <h6 class="text-primary fw-bold mb-3"><i class="bi bi-calendar-range"></i> Desglose de Cuotas
                                a Pagar a tu Empresa</h6>
                            <p class="text-muted mb-2" style="font-size:0.8rem;">La suma de las cuotas debe ser igual al
                                Total Neto a Cobrar (Total Factura - Detracción).</p>
                            <div class="table-responsive">
                                <table class="table-cuotas bg-white" style="border-radius: 8px; overflow:hidden;">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">N° Cuota</th>
                                            <th style="width: 40%;">Fecha Vencimiento</th>
                                            <th style="width: 45%;">Monto de Cuota</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_cuotas">
                                        <!-- Generado por JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- 3. DETALLE DE SERVICIOS --}}
            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0"><i class="bi bi-list-task"></i> Detalle de Servicios a Facturar</div>
                    <button type="button" class="btn btn-primary btn-sm rounded-pill fw-bold px-3"
                        onclick="addDetalleRow()">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Servicio
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table-detalles">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Servicio</th>
                                <th style="width: 25%;">Descripción Específica</th>
                                <th style="width: 8%;">Cant.</th>
                                <th style="width: 15%;">Precio Unit.</th>
                                <th style="width: 15%;">Subtotal</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="detalles-tbody">
                            <tr id="empty-row">
                                <td colspan="6" class="text-center py-4 text-muted">Añada servicios para facturar...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-7">
                        <label class="form-label">Observaciones (Opcional)</label>
                        <textarea name="observaciones" class="form-control" rows="4"
                            placeholder="Ej: Pago de adelanto 50% según contrato..."></textarea>
                    </div>
                    <div class="col-md-5">
                        <div class="totales-box">
                            <div class="total-row">
                                <span>Subtotal (Gravado)</span>
                                <span id="lbl_subtotal">0.00</span>
                            </div>
                            <div class="total-row">
                                <span>IGV (18%)</span>
                                <span id="lbl_igv">0.00</span>
                            </div>
                            <div class="total-row text-danger">
                                <span>Descuento Global</span>
                                <input type="number" name="descuento_global" id="descuento_global"
                                    class="form-control form-control-sm text-end w-50" value="0.00" step="0.01">
                            </div>
                            <div class="total-final">
                                <span>TOTAL FACTURA</span>
                                <span id="lbl_total_factura">S/ 0.00</span>
                            </div>

                            <!-- Campos calculados dinámicos para detracción -->
                            <div id="row_detraccion_calculada" style="display:none;"
                                class="total-row text-warning mt-3 border-top pt-3">
                                <span>Monto Detracción (<span id="lbl_pct_detraccion">0</span>%)</span>
                                <span id="lbl_monto_detraccion">- S/ 0.00</span>
                            </div>
                            <div id="row_neto_cobrar" style="display:none;" class="total-neto">
                                <span>NETO A COBRAR</span>
                                <span id="lbl_neto_cobrar">S/ 0.00</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. DATOS DE RECAUDO (Empresa) --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-bank"></i> Datos de Recaudo (Cuenta de la Empresa)</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Método de Pago <span class="text-danger">*</span></label>
                        <select name="metodo_pago_id" class="form-select" required>
                            @foreach ($metodosPago as $mp)
                                <option value="{{ $mp->id }}">{{ $mp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Depositar en Cuenta Bancaria (Tu empresa)</label>
                        <select name="cuenta_bancaria_id" class="form-select">
                            <option value="">Ninguna / Efectivo en Caja</option>
                            @foreach ($cuentas as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->banco->name ?? 'Banco' }} - {{ $c->numero_cuenta }} 
                                    ({{ $c->moneda?->codigo ?? '??' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Si seleccionas una cuenta, el ingreso sumará al saldo de esta cuenta
                            bancaria cuando el cliente pague.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin-comprobantes.index') }}"
                    class="btn btn-secondary rounded-pill px-4 fw-bold">Cancelar</a>
                <button type="submit" id="btn-submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                    <i class="bi bi-check-circle me-1"></i> Generar Comprobante
                </button>
            </div>
        </form>
    </div>

    <!-- Selects Ocultos para inyectarlos en las filas -->
    <div style="display:none;" id="hidden_afectacion">
        @foreach ($tiposAfectacion as $ta)
            <option value="{{ $ta->id }}" data-porcentaje="{{ $ta->porcentaje }}">{{ $ta->descripcion }}</option>
        @endforeach
    </div>
    <div style="display:none;" id="hidden_unidad">
        @foreach ($unidadesMedida as $um)
            <option value="{{ $um->id }}" {{ $um->codigo_sunat == 'ZZ' ? 'selected' : '' }}>{{ $um->descripcion }}
            </option>
        @endforeach
    </div>
@endsection

@section('js')
    <script>
        let seriesFull = @json($series);
        let detalleIndex = 0;

        // Variables globales para cálculos
        let granTotalFactura = 0;
        let montoDetraccion = 0;
        let totalNetoCobrar = 0;

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // CARGAR DATOS DEL CLIENTE
            $('#cliente_id').on('change', function() {
                let ruc = $(this).find(':selected').data('ruc');
                let dir = $(this).find(':selected').data('direccion');

                $('#cli_ruc').val(ruc || '');
                $('#cli_dir').val(dir || '');
            });

            // FACTURA / BOLETA
            $('#tipo_comprobante_id').on('change', function() {
                let selectedId = $(this).val();
                let desc = $(this).find('option:selected').text().toUpperCase();

                let selectSerie = $('#serie_id');
                selectSerie.empty().append('<option value="">Seleccione Serie</option>');

                if (selectedId) {
                    let seriesFiltradas = seriesFull.filter(s => s.tipo_comprobante_id == selectedId);
                    seriesFiltradas.forEach(s => {
                        selectSerie.append(`<option value="${s.id}">${s.name}</option>`);
                    });
                    selectSerie.prop('disabled', false);
                    
                    // Si solo hay una serie, seleccionarla
                    if(seriesFiltradas.length === 1) {
                        selectSerie.val(seriesFiltradas[0].id).trigger('change');
                    }
                } else {
                    selectSerie.prop('disabled', true);
                }
                $('#preview_numero').text('------');

                if (desc.includes('FACTURA')) {
                    $('#tipo_pago').val('Credito').trigger('change');
                } else if (desc.includes('BOLETA')) {
                    $('#tipo_pago').val('Contado').trigger('change');
                }
            });

            // TIPO DE PAGO (CONTADO/CRÉDITO)
            $('#tipo_pago').on('change', function() {
                if ($(this).val() === 'Credito') {
                    $('#box_cuotas').slideDown();
                    $('#box_desglose_cuotas').slideDown();
                    generarTablaCuotas();
                } else {
                    $('#box_cuotas').slideUp();
                    $('#box_desglose_cuotas').slideUp();
                    $('#numero_cuotas').val(1);
                }
            });

            $('#numero_cuotas').on('input change', function() {
                if ($('#tipo_pago').val() === 'Credito') {
                    generarTablaCuotas();
                }
            });

            // OPERACIÓN Y DETRACCIÓN
            $('#tipo_operacion_id').on('change', function() {
                let desc = $(this).find('option:selected').text().toUpperCase();
                let code = $(this).find('option:selected').text().split(' - ')[0];

                if (desc.includes('DETRACCION') || desc.includes('DETRACCIÓN') || code === '1001' || code === '1002') {
                    $('#box_detraccion').slideDown();
                    $('#tipo_detraccion_id').attr('required', true);
                } else {
                    $('#box_detraccion').slideUp();
                    $('#tipo_detraccion_id').val('').attr('required', false);
                }
                calcularTotales();
            });

            // CÁLCULO DE DETRACCIÓN AL CAMBIAR PORCENTAJE
            $('#tipo_detraccion_id').on('change', function() {
                calcularTotales();
            });

            $('#serie_id').on('change', function() {
                let serieId = $(this).val();
                if (serieId) {
                    $.get('/admin-comprobantes/correlativo/' + serieId, function(res) {
                        $('#preview_numero').text(res.numero_comprobante);
                    }).fail(function() {
                        // Fallback manual si no hay endpoint
                        let s = seriesFull.find(x => x.id == serieId);
                        if(s) {
                            let next = parseInt(s.correlativo) + 1;
                            $('#preview_numero').text(s.name + '-' + String(next).padStart(8, '0'));
                        }
                    });
                } else {
                    $('#preview_numero').text('------');
                }
            });

            $(document).on('input', '.input-qty, .input-precio', calcularTotales);
            $('#descuento_global').on('input', calcularTotales);

            // LOGICA DE IMPORTACION DE PEDIDO
            $('#select_pedido_id').on('change', function() {
                let pedidoId = $(this).val();
                if (pedidoId) {
                    importarPedido(pedidoId);
                }
            });

            // Mantener el botón por si acaso, pero el evento principal es el change
            $('#btn_importar_pedido').on('click', function() {
                let pedidoId = $('#select_pedido_id').val();
                if (pedidoId) importarPedido(pedidoId);
                else Swal.fire('Atención', 'Seleccione un pedido primero.', 'warning');
            });
        });

        function importarPedido(id) {
            Swal.showLoading();
            $.get('/admin-comprobantes/api/pedido/' + id, function(res) {
                Swal.close();
                if (res.success) {
                    let p = res.pedido;
                    $('#pedido_id_hidden').val(id);
                    console.log("Pedido cargado:", p);
                    
                    // 1. Cliente y sus datos
                    $('#cliente_id').val(p.cliente_id).trigger('change');
                    // Forzar el llenado de RUC y dirección si el trigger change no lo hace a tiempo
                    if(p.cliente) {
                        $('#cli_ruc').val(p.cliente.ruc || p.cliente.dni || '-');
                        $('#cli_dir').val(p.cliente.direccion || '-');
                    }

                    // 2. Tipo de Comprobante sugerido
                    let tipoSugerido = null;
                    let textoObs = (p.observaciones || "").toUpperCase();

                    if (textoObs.includes('FACTURA')) {
                        tipoSugerido = 'FACTURA';
                    } else if (textoObs.includes('BOLETA')) {
                        tipoSugerido = 'BOLETA';
                    } else if (p.cliente && p.cliente.ruc) {
                        tipoSugerido = 'FACTURA';
                    } else {
                        tipoSugerido = 'BOLETA';
                    }

                    if (tipoSugerido) {
                        $("#tipo_comprobante_id option").each(function() {
                            let text = $(this).text().toUpperCase();
                            if (text.includes(tipoSugerido)) {
                                $('#tipo_comprobante_id').val($(this).val()).trigger('change');
                                return false;
                            }
                        });
                    }

                    // 2.1 Método de Pago sugerido
                    let metodoSugerido = null;
                    if (textoObs.includes('EFECTIVO')) metodoSugerido = 'EFECTIVO';
                    else if (textoObs.includes('TRANSFERENCIA')) metodoSugerido = 'TRANSFERENCIA';
                    else if (textoObs.includes('BILLETERA')) metodoSugerido = 'BILLETERA';

                    if (metodoSugerido) {
                        $("select[name='metodo_pago_id'] option").each(function() {
                            let text = $(this).text().toUpperCase();
                            if (text.includes(metodoSugerido)) {
                                $("select[name='metodo_pago_id']").val($(this).val()).trigger('change');
                                return false;
                            }
                        });
                    }

                    // 3. Totales y Descuentos
                    $('#descuento_global').val(p.descuento_monto || 0);

                    // 4. Limpiar Detalles Actuales y Agregar los del Pedido
                    $('#detalles-tbody').empty();
                    if (p.detalles && p.detalles.length > 0) {
                        p.detalles.forEach(d => {
                            addDetalleRowConDatos(d);
                        });
                    }

                    // 5. Pago y Cuotas
                    if (p.condicion_pago === 'Credito') {
                        $('#tipo_pago').val('Credito').trigger('change');
                        $('#numero_cuotas').val(p.cuotas ? p.cuotas.length : 1);
                        
                        if(p.cuotas && p.cuotas.length > 0) {
                            setTimeout(() => {
                                p.cuotas.forEach((c, idx) => {
                                    let row = $('#tbody_cuotas tr').eq(idx);
                                    if(row.length) {
                                        row.find('input[name*="[fecha]"]').val(c.fecha_vencimiento || c.fecha);
                                        row.find('input[name*="[monto]"]').val(c.monto);
                                    }
                                });
                                calcularTotales();
                            }, 600);
                        }
                    } else {
                        $('#tipo_pago').val('Contado').trigger('change');
                        calcularTotales();
                    }

                    Swal.fire('Éxito', 'Pedido importado correctamente con todos sus datos.', 'success');
                }
            }).fail(function() {
                Swal.fire('Error', 'No se pudo obtener la información completa del pedido.', 'error');
            });
        }

        function addDetalleRowConDatos(d) {
            $('#empty-row').remove();
            let afectacionHTML = $('#hidden_afectacion').html();
            let unidadHTML = $('#hidden_unidad').html();
            
            let nombreVisible = d.descripcion;
            if(d.servicio) nombreVisible = d.servicio.name;
            else if(d.producto) nombreVisible = d.producto.name;

            let row = `
        <tr data-index="${detalleIndex}">
            <td>
                <input type="text" name="detalles[${detalleIndex}][nombre_servicio]" class="form-control" value="${nombreVisible}" required>
                <div class="mt-1 d-none">
                    <select name="detalles[${detalleIndex}][tipo_afectacion_id]" class="form-select form-select-sm input-afectacion">${afectacionHTML}</select>
                    <select name="detalles[${detalleIndex}][unidad_medida_id]" class="form-select form-select-sm mt-1">${unidadHTML}</select>
                </div>
            </td>
            <td><input type="text" name="detalles[${detalleIndex}][descripcion]" class="form-control input-desc" value="${d.descripcion || ''}" required></td>
            <td><input type="number" name="detalles[${detalleIndex}][cantidad]" class="form-control text-center input-qty" value="${d.cantidad}" min="0.01" step="0.01" required></td>
            <td><input type="number" name="detalles[${detalleIndex}][precio_unitario]" class="form-control text-end input-precio" value="${d.precio_unitario}" min="0" step="0.01" required></td>
            <td><input type="text" class="form-control text-end row-subtotal input-readonly" value="${d.subtotal}" readonly></td>
            <td class="text-center">
                <button type="button" class="btn-remove" onclick="removeRow(this)"><i class="bi bi-trash"></i></button>
            </td>
        </tr>`;

            $('#detalles-tbody').append(row);
            detalleIndex++;
        }

        function addDetalleRow() {
            $('#empty-row').remove();

            let afectacionHTML = $('#hidden_afectacion').html();
            let unidadHTML = $('#hidden_unidad').html();

            let row = `
        <tr data-index="${detalleIndex}">
            <td>
                <input type="text" name="detalles[${detalleIndex}][nombre_servicio]" class="form-control" placeholder="Nombre del servicio..." required>
                <div class="mt-1 d-none">
                    <select name="detalles[${detalleIndex}][tipo_afectacion_id]" class="form-select form-select-sm input-afectacion">${afectacionHTML}</select>
                    <select name="detalles[${detalleIndex}][unidad_medida_id]" class="form-select form-select-sm mt-1">${unidadHTML}</select>
                </div>
            </td>
            <td><input type="text" name="detalles[${detalleIndex}][descripcion]" class="form-control input-desc" placeholder="Detalle adicional..." required></td>
            <td><input type="number" name="detalles[${detalleIndex}][cantidad]" class="form-control text-center input-qty" value="1" min="0.01" step="0.01" required></td>
            <td><input type="number" name="detalles[${detalleIndex}][precio_unitario]" class="form-control text-end input-precio" value="0.00" min="0" step="0.01" required></td>
            <td><input type="text" class="form-control text-end row-subtotal input-readonly" value="0.00" readonly></td>
            <td class="text-center">
                <button type="button" class="btn-remove" onclick="removeRow(this)"><i class="bi bi-trash"></i></button>
            </td>
        </tr>`;

            $('#detalles-tbody').append(row);
            detalleIndex++;
        }

        function removeRow(btn) {
            $(btn).closest('tr').remove();
            if ($('#detalles-tbody tr').length === 0) {
                $('#detalles-tbody').append('<tr id="empty-row"><td colspan="6" class="text-center py-4 text-muted">Añada servicios para facturar...</td></tr>');
            }
            calcularTotales();
        }

        function calcularTotales() {
            let sumSubtotal = 0;
            let sumIgv = 0;

            $('#detalles-tbody tr:not(#empty-row)').each(function() {
                let qty = parseFloat($(this).find('.input-qty').val()) || 0;
                let price = parseFloat($(this).find('.input-precio').val()) || 0;
                let pctIgv = parseFloat($(this).find('.input-afectacion option:selected').data('porcentaje')) || 18;

                let rowTotal = qty * price;
                $(this).find('.row-subtotal').val(rowTotal.toFixed(2));

                if (pctIgv > 0) {
                    let factor = 1 + (pctIgv / 100);
                    let base = rowTotal / factor;
                    sumSubtotal += base;
                    sumIgv += (rowTotal - base);
                } else {
                    sumSubtotal += rowTotal;
                }
            });

            let descGlobal = parseFloat($('#descuento_global').val()) || 0;

            // 1. TOTAL FACTURA CONTABLE
            granTotalFactura = (sumSubtotal + sumIgv) - descGlobal;

            // 2. CÁLCULO DE DETRACCIÓN EXACTO
            let pctDetraccion = 0;
            let selectedDetraccion = $('#tipo_detraccion_id').find('option:selected');

            if (selectedDetraccion.val()) {
                pctDetraccion = parseFloat(selectedDetraccion.data('porcentaje')) || 0;
            }

            montoDetraccion = granTotalFactura * (pctDetraccion / 100);
            totalNetoCobrar = granTotalFactura - montoDetraccion;

            // 3. ACTUALIZAR VISTA DE TOTALES
            $('#lbl_subtotal').text(sumSubtotal.toFixed(2));
            $('#lbl_igv').text(sumIgv.toFixed(2));
            $('#lbl_total_factura').text('S/ ' + granTotalFactura.toFixed(2));

            if (montoDetraccion > 0) {
                $('#lbl_pct_detraccion').text(pctDetraccion);
                $('#lbl_monto_detraccion').text('- S/ ' + montoDetraccion.toFixed(2));
                $('#lbl_neto_cobrar').text('S/ ' + totalNetoCobrar.toFixed(2));

                $('#row_detraccion_calculada').slideDown();
                $('#row_neto_cobrar').slideDown();
            } else {
                $('#row_detraccion_calculada').slideUp();
                $('#row_neto_cobrar').slideUp();
            }

            // 3.1 LLENAR INPUTS OCULTOS PARA ENVÍO
            $('#subtotal_hidden').val(sumSubtotal.toFixed(2));
            $('#igv_hidden').val(sumIgv.toFixed(2));
            $('#total_hidden').val(granTotalFactura.toFixed(2));

            // 4. RECALCULAR LAS CUOTAS CON EL NETO REAL
            if ($('#tipo_pago').val() === 'Credito') {
                generarTablaCuotas();
            }
        }

        // GENERAR LA TABLA DE CUOTAS
        function generarTablaCuotas() {
            let nCuotas = parseInt($('#numero_cuotas').val()) || 1;

            // Usa el totalNetoCobrar si es mayor a 0 y hay detracción, si no usa el total general
            let baseDivisible = (totalNetoCobrar > 0 && montoDetraccion > 0) ? totalNetoCobrar : granTotalFactura;

            let tbody = $('#tbody_cuotas');
            tbody.empty();

            if (nCuotas <= 0 || baseDivisible <= 0) {
                tbody.html(
                    '<tr><td colspan="3" class="text-center text-muted">Añada servicios para calcular cuotas.</td></tr>'
                );
                return;
            }

            let cuotaBase = (baseDivisible / nCuotas).toFixed(2);
            let cuotaUltima = (baseDivisible - (cuotaBase * (nCuotas - 1))).toFixed(2);

            let fechaBase = new Date($('#fecha_emision').val() + 'T00:00:00');

            for (let i = 1; i <= nCuotas; i++) {
                let monto = (i === nCuotas) ? cuotaUltima : cuotaBase;

                let fechaVence = new Date(fechaBase);
                fechaVence.setMonth(fechaVence.getMonth() + i);
                let d = String(fechaVence.getDate()).padStart(2, '0');
                let m = String(fechaVence.getMonth() + 1).padStart(2, '0');
                let y = fechaVence.getFullYear();
                let fechaStr = `${y}-${m}-${d}`;

                tbody.append(`
                <tr>
                    <td class="fw-bold text-center">Cuota ${i}</td>
                    <td><input type="date" name="cuotas[${i}][fecha]" class="form-control form-control-sm fw-bold" value="${fechaStr}" required></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light">S/</span>
                            <input type="number" name="cuotas[${i}][monto]" class="form-control text-end fw-bold text-primary input-monto-cuota" value="${monto}" step="0.01" required>
                        </div>
                    </td>
                </tr>
            `);
            }
        }

        $('#formVenta').on('submit', function(e) {
            if ($('#detalles-tbody tr:not(#empty-row)').length === 0) {
                e.preventDefault();
                Swal.fire('Error', 'Debe agregar al menos un servicio a facturar.', 'error');
                return false;
            }

            if ($('#tipo_pago').val() === 'Credito') {
                let sumaCuotas = 0;
                $('.input-monto-cuota').each(function() {
                    sumaCuotas += parseFloat($(this).val()) || 0;
                });

                let baseValidacion = (totalNetoCobrar > 0 && montoDetraccion > 0) ? totalNetoCobrar :
                    granTotalFactura;

                if (Math.abs(sumaCuotas - baseValidacion) > 0.10) {
                    e.preventDefault();
                    Swal.fire('Error de Cuotas',
                        `La suma de las cuotas (S/ ${sumaCuotas.toFixed(2)}) no coincide con el Neto a Cobrar (S/ ${baseValidacion.toFixed(2)}).`,
                        'error');
                    return false;
                }
            }

            let btn = $('#btn-submit');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Procesando...');
        });
    </script>
@endsection
