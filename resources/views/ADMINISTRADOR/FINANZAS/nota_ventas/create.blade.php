@extends('TEMPLATES.administrador')
@section('title', $tipo === 'nc' ? 'EMITIR NOTA DE CREDITO' : 'EMITIR NOTA DE DEBITO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">
                    EMITIR {{ $tipo === 'nc' ? 'NOTA DE CREDITO' : 'NOTA DE DEBITO' }}
                </h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-comprobantes-finanzas.index') }}">Comprobantes</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $tipo === 'nc' ? 'Nota de Credito' : 'Nota de Debito' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-nota-ventas.store') }}" method="POST" id="formNota">
            @csrf
            <input type="hidden" name="sale_id" value="{{ $venta->id }}">
            <input type="hidden" name="tipo" value="{{ $tipo }}">

            <div class="row g-3">
                {{-- ====== COLUMNA IZQUIERDA ====== --}}
                <div class="col-md-8">

                    {{-- Info del Comprobante Afectado --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Comprobante Afectado</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>N° Comprobante:</strong> {{ $venta->numero_comprobante }}</p>
                                    <p class="mb-1"><strong>Tipo:</strong>
                                        @if($venta->tipocomprobante?->codigo == '01')
                                            <span class="badge bg-info">Factura</span>
                                        @else
                                            <span class="badge bg-success">Boleta</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? '' }} {{ $venta->cliente->apellidos ?? '' }}</p>
                                    <p class="mb-1"><strong>Documento:</strong> {{ $venta->cliente->documento ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Fecha Emisión:</strong> {{ $venta->created_at->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Total Comprobante:</strong> <span class="fw-bold text-primary">S/ {{ number_format($venta->total, 2) }}</span></p>
                                    @if($tipo === 'nc' && $totalNCPrevias > 0)
                                        <p class="mb-1"><strong>NC Previas:</strong> <span class="fw-bold text-danger">- S/ {{ number_format($totalNCPrevias, 2) }}</span></p>
                                        <p class="mb-1"><strong>Disponible NC:</strong> <span class="fw-bold text-success">S/ {{ number_format($venta->total - $totalNCPrevias, 2) }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Items del comprobante original --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header {{ $tipo === 'nc' ? 'bg-danger' : 'bg-info' }} text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-list-check me-2"></i>Seleccionar Items
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">
                                                <input type="checkbox" id="checkAll" class="form-check-input">
                                            </th>
                                            <th class="small text-uppercase fw-bold">Descripcion</th>
                                            <th class="text-center small text-uppercase fw-bold" style="width: 100px;">Cant. Original</th>
                                            <th class="text-center small text-uppercase fw-bold" style="width: 120px;">Cantidad</th>
                                            <th class="text-end small text-uppercase fw-bold" style="width: 120px;">P. Unit.</th>
                                            <th class="text-end small text-uppercase fw-bold" style="width: 120px;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($venta->detalles as $index => $detalle)
                                        <tr class="item-row"
                                            data-index="{{ $index }}"
                                            data-detalle-id="{{ $detalle->id }}"
                                            data-detalle-subtotal="{{ $detalle->subtotal }}"
                                            data-original-qty="{{ $detalle->cantidad }}">
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input item-check" data-index="{{ $index }}">
                                            </td>
                                            <td>
                                                {{ $detalle->descripcion }}
                                                <input type="hidden" class="item-descripcion" value="{{ $detalle->descripcion }}">
                                                <input type="hidden" class="item-producto-id" value="{{ $detalle->producto_id }}">
                                                <input type="hidden" class="item-servicio-id" value="{{ $detalle->servicio_id }}">
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">{{ $detalle->cantidad }}</span>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" class="form-control form-control-sm text-center item-cantidad"
                                                       step="0.01" min="0.01" max="{{ $detalle->cantidad }}"
                                                       value="{{ $detalle->cantidad }}" disabled>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-muted small">S/ {{ number_format($detalle->precio_unitario, 2) }}</span>
                                                @if($detalle->descuento_monto > 0)
                                                    <br><small class="text-danger">-S/ {{ number_format($detalle->descuento_monto, 2) }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold item-subtotal-display">
                                                S/ 0.00
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====== COLUMNA DERECHA ====== --}}
                <div class="col-md-4">

                    {{-- Datos de la nota --}}
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header {{ $tipo === 'nc' ? 'bg-danger' : 'bg-info' }} text-white">
                            <h5 class="mb-0">
                                <i class="bi {{ $tipo === 'nc' ? 'bi-dash-circle' : 'bi-plus-circle' }} me-2"></i>
                                {{ $tipo === 'nc' ? 'Nota de Credito' : 'Nota de Debito' }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Tipo de Nota</label>
                                <div>
                                    @if($tipo === 'nc')
                                        <span class="badge bg-danger fs-6">Nota de Credito</span>
                                    @else
                                        <span class="badge bg-info fs-6">Nota de Debito</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">N° Comprobante (Preview)</label>
                                <input type="text" class="form-control" value="{{ $previewNumero }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Motivo <span class="text-danger">*</span></label>
                                <select name="sunat_motivo_nota_id" class="form-select" id="selectMotivo" required>
                                    <option value="">-- Seleccionar motivo --</option>
                                    @foreach($motivos as $motivo)
                                        <option value="{{ $motivo->id }}" data-codigo="{{ $motivo->codigo }}">
                                            {{ $motivo->codigo }} - {{ $motivo->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="2" placeholder="Opcional"></textarea>
                            </div>

                            <hr>

                            {{-- Resumen calculado --}}
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold" id="lblSubtotal">S/ 0.00</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">IGV (18%):</span>
                                <span class="fw-bold" id="lblIgv">S/ 0.00</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="fw-bold {{ $tipo === 'nc' ? 'text-danger' : 'text-info' }}">TOTAL:</span>
                                <span class="fw-bold fs-5 {{ $tipo === 'nc' ? 'text-danger' : 'text-info' }}" id="lblTotal">S/ 0.00</span>
                            </div>

                            <div id="alertaItems" class="alert alert-warning d-none mb-3">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Seleccione al menos un item.
                            </div>

                            <button type="submit" class="btn {{ $tipo === 'nc' ? 'btn-danger' : 'btn-info text-white' }} w-100 py-2 shadow-sm" id="btnEmitir" disabled>
                                <i class="bi bi-check-circle me-2"></i>Emitir {{ $tipo === 'nc' ? 'Nota de Credito' : 'Nota de Debito' }}
                            </button>
                            <a href="{{ route('admin-comprobantes-finanzas.show', $venta) }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-arrow-left me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden inputs para items seleccionados (se llenan con JS) --}}
            <div id="hiddenItems"></div>
        </form>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const tipo = '{{ $tipo }}';
        const maxDisponible = {{ $tipo === 'nc' ? ($venta->total - $totalNCPrevias) : 999999999 }};

        // Montos reales de la venta original (ya con descuentos globales aplicados)
        const ventaSubtotal = {{ $venta->subtotal }};
        const ventaIgv      = {{ $venta->igv }};
        const ventaTotal    = {{ $venta->total }};
        // Suma de todos los subtotales de ítems (sin descuento global)
        const sumAllDetalles = {{ $venta->detalles->sum('subtotal') }};

        function recalcular() {
            let selectedDetallesSubtotal = 0;
            let haySeleccionados = false;

            $('.item-row').each(function() {
                const $row = $(this);
                const checked = $row.find('.item-check').is(':checked');
                const detalleSubtotal = parseFloat($row.data('detalle-subtotal')) || 0;
                const originalQty     = parseFloat($row.data('original-qty')) || 1;

                if (checked) {
                    haySeleccionados = true;
                    const qty = parseFloat($row.find('.item-cantidad').val()) || 0;
                    // Subtotal proporcional de este ítem según qty seleccionada
                    const itemContrib = (qty / originalQty) * detalleSubtotal;
                    $row.find('.item-subtotal-display').text('S/ ' + itemContrib.toFixed(2));
                    selectedDetallesSubtotal += itemContrib;
                } else {
                    $row.find('.item-subtotal-display').text('S/ 0.00');
                }
            });

            // Calcular proporción sobre los montos REALES de la venta (con descuento global)
            const ratio    = sumAllDetalles > 0 ? selectedDetallesSubtotal / sumAllDetalles : 0;
            const subtotal = Math.round(ratio * ventaSubtotal * 100) / 100;
            const igv      = Math.round(ratio * ventaIgv      * 100) / 100;
            const total    = Math.round(ratio * ventaTotal    * 100) / 100;

            $('#lblSubtotal').text('S/ ' + subtotal.toFixed(2));
            $('#lblIgv').text('S/ ' + igv.toFixed(2));
            $('#lblTotal').text('S/ ' + total.toFixed(2));

            const motivoSeleccionado = $('#selectMotivo').val() !== '';
            const montoValido = tipo !== 'nc' || total <= (maxDisponible + 0.05);

            if (!montoValido) {
                $('#alertaItems').removeClass('d-none').html('<i class="bi bi-exclamation-triangle me-1"></i>El monto excede el disponible (S/ ' + maxDisponible.toFixed(2) + ').');
            } else if (!haySeleccionados) {
                $('#alertaItems').removeClass('d-none').html('<i class="bi bi-exclamation-triangle me-1"></i>Seleccione al menos un item.');
            } else {
                $('#alertaItems').addClass('d-none');
            }

            $('#btnEmitir').prop('disabled', !haySeleccionados || !motivoSeleccionado || !montoValido);

            // Rellenar hidden inputs
            $('#hiddenItems').empty();
            let itemIndex = 0;
            $('.item-row').each(function() {
                const $row = $(this);
                if ($row.find('.item-check').is(':checked')) {
                    const cantidad    = $row.find('.item-cantidad').val();
                    const descripcion = $row.find('.item-descripcion').val();
                    const productoId  = $row.find('.item-producto-id').val();
                    const servicioId  = $row.find('.item-servicio-id').val();
                    const detalleId   = $row.data('detalle-id');

                    $('#hiddenItems').append(
                        '<input type="hidden" name="items[' + itemIndex + '][detalle_id]" value="' + detalleId + '">' +
                        '<input type="hidden" name="items[' + itemIndex + '][descripcion]" value="' + descripcion + '">' +
                        '<input type="hidden" name="items[' + itemIndex + '][cantidad]" value="' + cantidad + '">' +
                        '<input type="hidden" name="items[' + itemIndex + '][producto_id]" value="' + (productoId || '') + '">' +
                        '<input type="hidden" name="items[' + itemIndex + '][servicio_id]" value="' + (servicioId || '') + '">'
                    );
                    itemIndex++;
                }
            });
        }

        $('.item-check').on('change', function() {
            const $row = $(this).closest('.item-row');
            const checked = $(this).is(':checked');
            $row.find('.item-cantidad').prop('disabled', !checked);
            if (!checked) {
                $row.find('.item-cantidad').val($row.find('.item-cantidad').attr('max'));
            }
            recalcular();
        });

        $('#checkAll').on('change', function() {
            const checked = $(this).is(':checked');
            $('.item-check').prop('checked', checked).trigger('change');
        });

        $('.item-cantidad').on('input', recalcular);

        $('#selectMotivo').on('change', function() {
            const motivo = $(this).find(':selected').data('codigo');

            if (tipo === 'nc' && (motivo === '01' || motivo === '06')) {
                $('#checkAll').prop('checked', true).trigger('change');
                $('.item-cantidad').prop('disabled', true);
                $('.item-row').each(function() {
                    $(this).find('.item-cantidad').val($(this).find('.item-cantidad').attr('max'));
                });
            } else {
                $('.item-row').each(function() {
                    const checked = $(this).find('.item-check').is(':checked');
                    $(this).find('.item-cantidad').prop('disabled', !checked);
                });
            }
            recalcular();
        });

        $('#formNota').on('submit', function(e) {
            const tipoTexto = tipo === 'nc' ? 'Nota de Crédito' : 'Nota de Débito';
            const totalTexto = $('#lblTotal').text();
            if (!confirm('¿Está seguro de emitir esta ' + tipoTexto + ' por ' + totalTexto + '?\n\nEsta acción generará un comprobante fiscal.')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
