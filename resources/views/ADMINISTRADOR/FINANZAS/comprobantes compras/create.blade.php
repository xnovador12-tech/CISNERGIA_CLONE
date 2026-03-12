@extends('TEMPLATES.administrador')

@section('title', 'Registrar Comprobante de Compra')

@section('css')
    <style>
        :root {
            --vt-primary: #1e293b;
            --vt-success: #10b981;
            --vt-warning: #f59e0b;
            --vt-dark: #0f172a;
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
            font-size: 0.95rem; font-weight: 800; color: var(--vt-dark); margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.5rem; text-transform: uppercase;
        }

        .section-title i { color: var(--vt-primary); }

        .form-label { font-size: 0.85rem !important; font-weight: 800 !important; color: #1e293b !important; margin-bottom: 0.4rem; }

        .form-control, .form-select { border-radius: 8px; font-size: 0.9rem; padding: 0.5rem 0.8rem; border-color: #cbd5e1; }

        .input-readonly { background-color: #f1f5f9; border-color: #e2e8f0; pointer-events: none; }

        .table-detalles { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-detalles th {
            background: var(--vt-bg); padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700;
            color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;
        }
        .table-detalles td { padding: 0.75rem 0.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: top; }

        .totales-box { background: var(--vt-bg); border-radius: 12px; padding: 1.5rem; border: 1px dashed #cbd5e1; }
        .total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.95rem; font-weight: 600; color: #475569; }
        .total-final {
            display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;
            padding-top: 1rem; border-top: 2px solid #e2e8f0; font-size: 1.2rem; font-weight: 900; color: var(--vt-primary);
        }

        .btn-remove {
            width: 32px; height: 32px; border-radius: 8px; border: none; background: rgba(239, 68, 68, 0.1);
            color: #ef4444; display: flex; align-items: center; justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">
                <i class="bi bi-file-earmark-plus me-2"></i> Registrar Pago a Proveedor
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-comprobantes-compras.index') }}">Comprobantes Compras</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-comprobantes-compras.store') }}" method="POST" id="formCompra">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- BUSCADOR DE OC --}}
            <div class="section-card" style="border: 2px solid #1e293b;">
                <div class="section-title"><i class="bi bi-search"></i> Paso 1: Seleccionar Orden de Compra (Pedido de Pago)</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <select id="select_oc_id" name="ordencompra_id" class="form-select select2">
                            <option value="">-- Buscar Orden de Compra Pendiente --</option>
                            @foreach ($ordenes_pendientes as $op)
                                <option value="{{ $op->id }}" {{ (isset($ordencompra) && $ordencompra->id == $op->id) ? 'selected' : '' }}>
                                    OC: {{ $op->codigo }} | PROVEEDOR: {{ $op->proveedor?->persona?->name }} | TOTAL: S/ {{ number_format($op->total, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted"><i class="bi bi-info-circle"></i> Al seleccionar, la página se recargará para llenar automáticamente los datos del proveedor y los productos.</small>
                    </div>
                </div>
            </div>

            {{-- DATOS DEL PROVEEDOR --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-person-badge"></i> Paso 2: Datos del Proveedor</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Proveedor</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-select select2" required>
                            <option value="">Seleccione Proveedor...</option>
                            @foreach ($proveedores as $prov)
                                <option value="{{ $prov->id }}" 
                                    {{ (isset($ordencompra) && $ordencompra->proveedor_id == $prov->id) ? 'selected' : '' }}>
                                    {{ $prov->persona?->name }} ({{ $prov->persona?->num_documento }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RUC / DNI</label>
                        <input type="text" id="prov_documento" class="form-control input-readonly" readonly 
                               value="{{ isset($ordencompra) ? $ordencompra->proveedor?->persona?->nro_identificacion : '' }}">
                    </div>
                </div>
            </div>

            {{-- DATOS DEL COMPROBANTE --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-receipt"></i> Paso 3: Detalles del Comprobante Recibido</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tipo Comprobante <span class="text-danger">*</span></label>
                        <select name="tiposcomprobante_id" id="tiposcomprobante_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach ($tiposcomprobante as $tc)
                                <option value="{{ $tc->id }}" 
                                    {{ (isset($ordencompra) && (str_contains(strtoupper($tc->name), strtoupper($ordencompra->comprobante ?? '')))) ? 'selected' : '' }}>
                                    {{ $tc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">N° Serie y Correlativo <span class="text-danger">*</span></label>
                        <input type="text" name="numero_comprobante" class="form-control" placeholder="Ej: F001-000456" required>
                        <small class="text-muted">Ingrese el número físico del comprobante del proveedor.</small>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Moneda</label>
                        <select name="moneda_id" class="form-select">
                            @foreach ($monedas as $mon)
                                <option value="{{ $mon->id }}" 
                                    {{ (isset($ordencompra) && ($ordencompra->moneda_id == $mon->id || ($ordencompra->tipo_moneda == 'Soles' && $mon->descripcion == 'SOLES') || ($ordencompra->tipo_moneda == 'Dolares' && $mon->descripcion == 'DOLARES'))) ? 'selected' : '' }}>
                                    {{ $mon->descripcion }} ({{ $mon->simbolo }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Condición Pago</label>
                        <select name="condicion_pago" class="form-select">
                            <option value="Contado" {{ (isset($ordencompra) && $ordencompra->condicion_pago == 'Contado') ? 'selected' : '' }}>Contado</option>
                            <option value="Credito" {{ (isset($ordencompra) && $ordencompra->condicion_pago == 'Credito') ? 'selected' : '' }}>Crédito</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Medio Pago</label>
                        <select name="mediopago_id" class="form-select">
                            @foreach($mediopagos as $mp)
                                <option value="{{ $mp->id }}">{{ $mp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- DETALLE DE PRODUCTOS --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-box-seam"></i> Paso 4: Detalle de Productos / Servicios</div>
                <div class="table-responsive">
                    <table class="table-detalles">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Descripción</th>
                                <th style="width: 10%;">Cant.</th>
                                <th style="width: 15%;">Precio Unit.</th>
                                <th style="width: 15%;">IGV (18%)</th>
                                <th style="width: 15%;">Total</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="detalles-tbody">
                            @if(isset($ordencompra) && $ordencompra->detallecompra)
                                @foreach($ordencompra->detallecompra as $index => $det)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="items[{{ $index }}][producto_id]" value="{{ $det->producto_id }}">
                                            <input type="text" name="items[{{ $index }}][descripcion]" class="form-control" value="{{ $det->producto ?? 'Producto' }}" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][cantidad]" class="form-control text-center input-qty" value="{{ $det->cantidad }}" step="0.01" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][precio]" class="form-control text-end input-precio" value="{{ $det->precio }}" step="0.01" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][igv]" class="form-control text-end input-igv" value="{{ number_format($det->subtotal * 0.18, 2, '.', '') }}" step="0.01" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][total]" class="form-control text-end input-total" value="{{ number_format($det->subtotal * 1.18, 2, '.', '') }}" step="0.01" readonly>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn-remove" onclick="$(this).closest('tr').remove(); calcularTotales();"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="empty-row">
                                    <td colspan="6" class="text-center py-4 text-muted">Seleccione una Orden de Compra para cargar productos...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-7">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="4">{{ isset($ordencompra) ? $ordencompra->observaciones : '' }}</textarea>
                    </div>
                    <div class="col-md-5">
                        <div class="totales-box">
                            <div class="total-row">
                                <span>Subtotal</span>
                                <input type="number" name="subtotal" id="inp_subtotal" class="form-control form-control-sm text-end w-50 input-readonly" 
                                       value="{{ isset($ordencompra) ? number_format($ordencompra->total / 1.18, 2, '.', '') : '0.00' }}" readonly required>
                            </div>
                            <div class="total-row">
                                <span>IGV (18%)</span>
                                <input type="number" name="igv" id="inp_igv" class="form-control form-control-sm text-end w-50 input-readonly" 
                                       value="{{ isset($ordencompra) ? number_format($ordencompra->total - ($ordencompra->total / 1.18), 2, '.', '') : '0.00' }}" readonly required>
                            </div>
                            <div class="total-final">
                                <span>TOTAL PAGO</span>
                                <input type="number" name="total" id="inp_total" class="form-control text-end w-50 border-0 bg-transparent fw-bold text-primary" 
                                       style="font-size: 1.5rem;" value="{{ isset($ordencompra) ? $ordencompra->total : '0.00' }}" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin-comprobantes-compras.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">Cancelar</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                    <i class="bi bi-check-circle me-1"></i> Finalizar y Guardar Pago
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

            // SERIE Y CORRELATIVO AUTOMÁTICO
            $('#tiposcomprobante_id').on('change', function() {
                let tipo = $(this).find('option:selected').text().toUpperCase();
                let serie = '';
                let correlativo = Math.floor(Math.random() * 900000) + 100000; // Simulación de correlativo

                if (tipo.includes('FACTURA')) {
                    serie = 'F001';
                } else if (tipo.includes('BOLETA')) {
                    serie = 'B001';
                } else {
                    serie = '0001';
                }

                $('input[name="numero_comprobante"]').val(serie + '-' + String(correlativo).padStart(8, '0'));
            });

            // DISPARAR AUTOMÁTICAMENTE AL CARGAR SI YA HAY UN TIPO SELECCIONADO (Desde la OC)
            if ($('#tiposcomprobante_id').val()) {
                $('#tiposcomprobante_id').trigger('change');
            }

            // REDIRECCIÓN PARA CARGAR OC (Server-side loading focus)
            $('#select_oc_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    Swal.fire({
                        title: 'Cargando datos...',
                        text: 'Espere un momento mientras importamos la información de la O.C.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    window.location.href = "{{ route('admin-comprobantes-compras.create') }}?id_oc=" + id;
                }
            });

            // CÁLCULOS DINÁMICOS si el usuario cambia cantidades/precios manualmente
            $(document).on('input', '.input-qty, .input-precio', function() {
                calcularTotales();
            });
        });

        function calcularTotales() {
            let subtotalGral = 0;
            let igvGral = 0;
            let totalGral = 0;

            $('#detalles-tbody tr').each(function() {
                let qty = parseFloat($(this).find('.input-qty').val()) || 0;
                let price = parseFloat($(this).find('.input-precio').val()) || 0;
                
                let subtotal = qty * price;
                let igv = subtotal * 0.18;
                let total = subtotal + igv;

                $(this).find('.input-igv').val(igv.toFixed(2));
                $(this).find('.input-total').val(total.toFixed(2));

                subtotalGral += subtotal;
                igvGral += igv;
                totalGral += total;
            });

            $('#inp_subtotal').val(subtotalGral.toFixed(2));
            $('#inp_igv').val(igvGral.toFixed(2));
            $('#inp_total').val(totalGral.toFixed(2));
        }
    </script>
@endsection
