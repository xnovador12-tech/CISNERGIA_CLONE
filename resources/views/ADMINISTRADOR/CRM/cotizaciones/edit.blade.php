@extends('TEMPLATES.administrador')
@section('title', 'Editar Cotización ' . $cotizacion->codigo)

@section('css')
<style>
    .tabla-items th { font-size: 0.75rem; text-transform: uppercase; background: #f8f9fa; }
    .tabla-items td { vertical-align: middle; }
    .tabla-items .form-control, .tabla-items .form-select { font-size: 0.8rem; }
    .item-subtotal { font-weight: 600; min-width: 100px; text-align: right; }
    .btn-quitar { padding: 0.15rem 0.4rem; font-size: 0.75rem; }
    .resumen-valor { font-size: 0.95rem; }
    .cascada-selects { display: flex; flex-wrap: wrap; gap: 4px; }
    .cascada-selects .sel-wrap-half { flex: 1; min-width: 100px; }
    .cascada-selects .sel-wrap-full { flex: 0 0 100%; }
    .producto-info { font-size: 0.72rem; color: #6c757d; margin-top: 2px; }
    .cascada-selects .select2-container--bootstrap-5 .select2-selection { min-height: 28px; padding: 0.15rem 0.5rem; font-size: 0.8rem; }
    #oportunidad-detalle { transition: all 0.3s ease; }
    .op-badge { font-size: 0.7rem; }
</style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR COTIZACIÓN</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $cotizacion->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Errores de validación:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.crm.cotizaciones.update', $cotizacion) }}" method="POST" id="formCotizacion">
        @csrf
        @method('PUT')

        <div class="container-fluid">
            <div class="row g-4">

                {{-- ===================== COLUMNA PRINCIPAL ===================== --}}
                <div class="col-lg-8">

                    {{-- Card: Información General --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="text-secondary mb-0 small text-uppercase fw-bold">Información General</p>
                                <span class="badge bg-secondary">{{ $cotizacion->codigo }}</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Oportunidad <span class="text-danger">*</span></label>
                                    <select name="oportunidad_id" id="oportunidad_id"
                                            class="form-select form-select-sm select2_bootstrap w-100 @error('oportunidad_id') is-invalid @enderror"
                                            required data-placeholder="Seleccione una oportunidad...">
                                        <option value="">Seleccione una oportunidad...</option>
                                        @foreach($oportunidades as $op)
                                            @php
                                                $etapaLabel = \App\Models\Oportunidad::ETAPAS[$op->etapa]['nombre'] ?? $op->etapa;
                                                $tipoServicioLabels = [
                                                    'instalacion' => 'Instalación',
                                                    'mantenimiento_preventivo' => 'Mant. Preventivo',
                                                    'mantenimiento_correctivo' => 'Mant. Correctivo',
                                                    'ampliacion' => 'Ampliación',
                                                    'otro' => 'Otro',
                                                ];
                                            @endphp
                                            <option value="{{ $op->id }}"
                                                {{ old('oportunidad_id', $cotizacion->oportunidad_id) == $op->id ? 'selected' : '' }}
                                                data-tipo="{{ $op->tipo_oportunidad }}"
                                                data-tipo-servicio="{{ $op->tipo_servicio }}"
                                                data-tipo-servicio-label="{{ $tipoServicioLabels[$op->tipo_servicio] ?? $op->tipo_servicio }}"
                                                data-servicio="{{ $op->servicio?->name }}"
                                                data-etapa="{{ $op->etapa }}"
                                                data-etapa-label="{{ $etapaLabel }}"
                                                data-monto="{{ $op->monto_estimado }}"
                                                data-monto-final="{{ $op->monto_final }}"
                                                data-nombre="{{ $op->nombre }}"
                                                data-codigo="{{ $op->codigo }}"
                                                data-tipo-proyecto="{{ $op->tipo_proyecto }}"
                                                data-prospecto="{{ $op->prospecto?->nombre_completo }}"
                                                data-email="{{ $op->prospecto?->email }}"
                                                data-telefono="{{ $op->prospecto?->telefono ?? $op->prospecto?->celular }}">
                                                {{ $op->codigo }}
                                                @if($op->prospecto) — {{ $op->prospecto->nombre_completo }} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('oportunidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Válido Hasta <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_vigencia"
                                           class="form-control form-control-sm @error('fecha_vigencia') is-invalid @enderror"
                                           value="{{ old('fecha_vigencia', $cotizacion->fecha_vigencia?->format('Y-m-d')) }}" required>
                                    @error('fecha_vigencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nombre del Proyecto <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre_proyecto" id="nombre_proyecto"
                                           class="form-control form-control-sm @error('nombre_proyecto') is-invalid @enderror"
                                           value="{{ old('nombre_proyecto', $cotizacion->nombre_proyecto) }}" required>
                                    @error('nombre_proyecto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Detalle de oportunidad seleccionada --}}
                            <div id="oportunidad-detalle" class="mt-3">
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="row g-2 align-items-start">
                                        <div class="col-md-6">
                                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size:0.68rem;">Cliente / Prospecto</p>
                                            <p class="mb-1 fw-semibold small" id="op-prospecto">—</p>
                                            <p class="mb-0 small text-muted" id="op-contacto">—</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size:0.68rem;">Segmento</p>
                                            <p class="mb-0 small" id="op-segmento">—</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size:0.68rem;">Tipo</p>
                                            <p class="mb-0 small" id="op-tipo-oportunidad">—</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Ítems --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold">Detalle de Ítems</p>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered tabla-items mb-0" id="tablaItems" style="table-layout:fixed;">
                                    <colgroup>
                                        <col style="width:45%">
                                        <col style="width:7%">
                                        <col style="width:10%">
                                        <col style="width:18%">
                                        <col style="width:15%">
                                        <col style="width:40px">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Ítem</th>
                                            <th style="width: 70px;">Cant.</th>
                                            <th style="width: 80px;">Unidad</th>
                                            <th style="width: 120px;">P. Unit.</th>
                                            <th style="width: 110px;">Subtotal</th>
                                            <th style="width: 35px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems"></tbody>
                                </table>
                            </div>

                            <div id="sinItems" class="text-center text-muted py-4" style="display:none;">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No hay ítems.</p>
                            </div>

                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btnAgregarProducto">
                                    <i class="bi bi-box me-1"></i>Agregar Producto
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info" id="btnAgregarServicio">
                                    <i class="bi bi-gear me-1"></i>Agregar Servicio
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Plazos, Notas y Condiciones --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold">Plazos, Notas y Condiciones</p>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Garantía de Servicio</label>
                                    <input type="text" name="garantia_servicio" class="form-control form-control-sm"
                                           value="{{ old('garantia_servicio', $cotizacion->garantia_servicio) }}"
                                           placeholder="Ej: 2 años en mano de obra">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Condiciones Comerciales</label>
                                    <textarea name="condiciones_comerciales" class="form-control form-control-sm" rows="2"
                                              placeholder="Condiciones de pago, plazos, etc.">{{ old('condiciones_comerciales', $cotizacion->condiciones_comerciales) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" class="form-control form-control-sm" rows="2"
                                              placeholder="Observaciones generales">{{ old('observaciones', $cotizacion->observaciones) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Notas Internas <small class="text-muted">(solo el equipo)</small></label>
                                    <textarea name="notas_internas" class="form-control form-control-sm" rows="2"
                                              placeholder="Solo visible para el equipo interno">{{ old('notas_internas', $cotizacion->notas_internas) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== COLUMNA LATERAL ===================== --}}
                <div class="col-lg-4">
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold"><i class="bi bi-calculator me-1"></i>Resumen</p>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="resumen-valor" id="calc-subtotal">S/ {{ number_format($cotizacion->subtotal, 2) }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Descuento General (%)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" name="descuento_porcentaje" id="descuento_porcentaje"
                                           class="form-control form-control-sm"
                                           value="{{ old('descuento_porcentaje', $cotizacion->descuento_porcentaje) }}" min="0" max="50">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento:</span>
                                <span class="resumen-valor" id="calc-descuento">- S/ {{ number_format($cotizacion->descuento_monto, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Base Imponible:</span>
                                <span class="resumen-valor" id="calc-base">S/ {{ number_format($cotizacion->subtotal - $cotizacion->descuento_monto, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="incluye_igv" name="incluye_igv" value="1"
                                           {{ old('incluye_igv', $cotizacion->incluye_igv) ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="incluye_igv">IGV (18%)</label>
                                </div>
                                <span class="resumen-valor" id="calc-igv">S/ {{ number_format($cotizacion->igv, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h6 mb-0 fw-bold">TOTAL:</span>
                                <span class="h5 mb-0 text-primary fw-bold" id="calc-total">S/ {{ number_format($cotizacion->total, 2) }}</span>
                            </div>

                            <hr>
                            <p class="small text-muted mb-2 fw-bold">Desglose por tipo:</p>
                            <div id="desglose-categorias" class="small">
                                <span class="text-muted">Cargando...</span>
                            </div>
                        </div>
                    </div>

                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius:20px;" data-aos="fade-up">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary px-5 text-white">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                                <a href="{{ route('admin.crm.cotizaciones.show', $cotizacion) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="subtotal" id="input-subtotal" value="{{ $cotizacion->subtotal }}">
        <input type="hidden" name="igv" id="input-igv" value="{{ $cotizacion->igv }}">
        <input type="hidden" name="total" id="input-total" value="{{ $cotizacion->total }}">
        <input type="hidden" name="descuento_monto" id="input-descuento-monto" value="{{ $cotizacion->descuento_monto }}">
    </form>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ==================== DATOS DEL SERVIDOR ====================
    const tipos         = @json($tipos);
    const productosDB   = @json($productos);
    const serviciosDB   = @json($servicios);
    const tipoNombres   = { 'producto': 'Productos', 'servicio': 'Servicios' };
    const tipoColors    = { 'producto': 'primary', 'servicio': 'info' };

    // Items a cargar: si hay old() por error de validación, usar esos; si no, los guardados de BD
    const itemsGuardados  = @json($itemsParaEditar);
    const itemsOld        = @json(old('items', []));
    const itemsACargar    = itemsOld.length > 0 ? itemsOld : itemsGuardados;

    let itemIndex = 0;

    // ==================== CARGAR ÍTEMS ====================
    itemsACargar.forEach(function(item) {
        const tipo = (item.categoria === 'servicio') ? 'servicio' : 'producto';
        agregarFila(tipo, item);
    });

    // ==================== BOTONES AGREGAR ====================
    $('#btnAgregarProducto').on('click', function() { agregarFila('producto'); });
    $('#btnAgregarServicio').on('click', function() { agregarFila('servicio'); });

    // ==================== CREAR FILA ====================
    function agregarFila(tipo, datos) {
        datos = datos || {};
        const i = itemIndex++;
        $('#sinItems').hide();

        let celdaDescripcion = '';

        if (tipo === 'producto') {
            let optTipos = '<option value="">-- Tipo --</option>';
            tipos.forEach(t => { optTipos += `<option value="${t.id}">${t.name}</option>`; });

            celdaDescripcion = `
                <div class="cascada-selects">
                    <div class="sel-wrap-half">
                        <select class="form-select form-select-sm sel-tipo" data-index="${i}">${optTipos}</select>
                    </div>
                    <div class="sel-wrap-half">
                        <select class="form-select form-select-sm sel-subcategoria" data-index="${i}" disabled>
                            <option value="">-- Categoría --</option>
                        </select>
                    </div>
                    <div class="sel-wrap-full">
                        <select class="form-select form-select-sm sel-producto" data-index="${i}" disabled>
                            <option value="">-- Producto --</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="items[${i}][producto_id]" class="input-producto-id" value="${datos.producto_id || ''}">
                <input type="hidden" name="items[${i}][servicio_id]" class="input-servicio-id" value="">
                <input type="hidden" name="items[${i}][descripcion]" class="input-descripcion" value="${datos.descripcion || ''}" required>
                <input type="hidden" name="items[${i}][especificaciones]" value="${datos.especificaciones || ''}">`;

        } else {
            let optsServicio = '<option value="">-- Seleccionar servicio --</option>';
            serviciosDB.forEach(s => {
                const tipo = s.tipo_servicio === 'publico' ? 'Público' : 'Privado';
                const sel  = (datos.servicio_id && datos.servicio_id == s.id) ? 'selected' : '';
                optsServicio += `<option value="${s.id}" data-desc="${s.descripcion || ''}" data-tipo="${s.tipo_servicio}" ${sel}>${s.name} (${tipo})</option>`;
            });

            celdaDescripcion = `
                <select class="form-select form-select-sm sel-servicio-especifico w-100" data-index="${i}">${optsServicio}</select>
                <div class="producto-info input-descripcion-hint mt-1" id="desc-servicio-${i}"
                     style="${datos.descripcion ? '' : 'display:none;'}">
                    <i class="bi bi-info-circle me-1"></i><span>${datos.descripcion || ''}</span>
                </div>
                <input type="hidden" name="items[${i}][descripcion]" class="input-descripcion" value="${datos.descripcion || ''}" required>
                <input type="hidden" name="items[${i}][servicio_id]" class="input-servicio-id" value="${datos.servicio_id || ''}">
                <input type="hidden" name="items[${i}][producto_id]" class="input-producto-id" value="">
                <input type="hidden" name="items[${i}][especificaciones]" value="${datos.especificaciones || ''}">`;
        }

        // Celda precio: si es servicio agrega campo tiempo_ejecucion
        const celdaPrecio = tipo === 'servicio' ? `
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" style="font-size:0.7rem;">S/</span>
                <input type="number" name="items[${i}][precio_unitario]" class="form-control form-control-sm input-precio"
                       value="${datos.precio_unitario || 0}" step="0.01" min="0" required>
            </div>
            <div class="input-group input-group-sm">
                <input type="number" name="items[${i}][tiempo_ejecucion_dias]" class="form-control form-control-sm input-tiempo"
                       value="${datos.tiempo_ejecucion_dias || ''}" min="1" placeholder="Días ej.">
                <span class="input-group-text" style="font-size:0.65rem;">días</span>
            </div>` : `
            <div class="input-group input-group-sm">
                <span class="input-group-text" style="font-size:0.7rem;">S/</span>
                <input type="number" name="items[${i}][precio_unitario]" class="form-control form-control-sm input-precio"
                       value="${datos.precio_unitario || 0}" step="0.01" min="0" required>
            </div>
            <div class="producto-info input-precio-original" id="precio-original-${i}" style="display:none;"></div>
            <input type="hidden" name="items[${i}][tiempo_ejecucion_dias]" value="">`;

        const fila = `
        <tr id="fila-${i}" class="item-fila" data-tipo="${tipo}">
            <td class="celda-descripcion">
                <input type="hidden" name="items[${i}][categoria]" value="${tipo}">
                <input type="hidden" name="items[${i}][descuento_porcentaje]" value="0">
                ${celdaDescripcion}
            </td>
            <td>
                <input type="number" name="items[${i}][cantidad]" class="form-control form-control-sm input-cantidad"
                       value="${datos.cantidad || 1}" step="0.01" min="0.01" required>
            </td>
            <td>
                <select name="items[${i}][unidad]" class="form-select form-select-sm input-unidad">
                    <option value="und"   ${ (datos.unidad||'und')==='und'   ?'selected':''}>Und</option>
                    <option value="glb"   ${ datos.unidad==='glb'   ?'selected':''}>Global</option>
                    <option value="hrs"   ${ datos.unidad==='hrs'   ?'selected':''}>Horas</option>
                    <option value="dia"   ${ datos.unidad==='dia'   ?'selected':''}>Día</option>
                    <option value="kg"    ${ datos.unidad==='kg'    ?'selected':''}>Kg</option>
                    <option value="m"     ${ datos.unidad==='m'     ?'selected':''}>Metro</option>
                    <option value="m2"    ${ datos.unidad==='m2'    ?'selected':''}>M²</option>
                    <option value="ml"    ${ datos.unidad==='ml'    ?'selected':''}>ML</option>
                    <option value="jgo"   ${ datos.unidad==='jgo'   ?'selected':''}>Juego</option>
                    <option value="rollo" ${ datos.unidad==='rollo' ?'selected':''}>Rollo</option>
                    <option value="par"   ${ datos.unidad==='par'   ?'selected':''}>Par</option>
                </select>
            </td>
            <td>${celdaPrecio}</td>
            <td class="item-subtotal text-end pt-2" id="subtotal-${i}">S/ 0.00</td>
            <td class="text-center pt-2">
                <button type="button" class="btn btn-outline-danger btn-quitar" onclick="quitarFila(${i})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>`;

                $('#tbodyItems').append(fila);

        if (tipo === 'producto') {
            initSelect2Cascada(i);
            // Restaurar cascada si viene de datos guardados o de old()
            if (datos.producto_id || datos.producto_tipo_id) {
                const tipoId     = datos.producto_tipo_id     || datos.tipo_id     || null;
                const catId      = datos.producto_categorie_id || datos.categorie_id || null;
                const productoId = datos.producto_id || null;
                restaurarCascadaProducto(i, tipoId, catId, productoId, datos.precio_unitario);
            }
        } else {
            initSelect2Servicio(i);
            // Servicio preseleccionado si viene de datos guardados/old()
            if (datos.servicio_id) {
                $(`.sel-servicio-especifico[data-index="${i}"]`).val(datos.servicio_id).trigger('change');
            }
        }

        calcularSubtotalFila(i);
        calcularTotales();
    }

    // ==================== SELECT2 HELPERS ====================
    function initSelect2Cascada(idx) {
        $(`#fila-${idx}`).find('.sel-tipo, .sel-subcategoria, .sel-producto').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) $(this).select2('destroy');
            $(this).select2({ theme: 'bootstrap-5', width: '100%', placeholder: $(this).find('option:first').text() });
        });
    }

    function initSelect2Servicio(idx) {
        $(`#fila-${idx}`).find('.sel-servicio-especifico').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) $(this).select2('destroy');
            $(this).select2({ theme: 'bootstrap-5', width: '100%', placeholder: $(this).find('option:first').text() });
        });
    }

    function reinitSelect2(selector) {
        const el = $(selector);
        if (el.hasClass('select2-hidden-accessible')) el.select2('destroy');
        el.select2({ theme: 'bootstrap-5', width: '100%', placeholder: el.find('option:first').text() });
    }

    // ==================== CASCADA: TIPO → CATEGORÍA → PRODUCTO ====================
    $(document).on('change', '.sel-tipo', function() {
        const idx    = $(this).data('index');
        const tipoId = parseInt($(this).val());
        const selSubcat   = $(`.sel-subcategoria[data-index="${idx}"]`);
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
        $(`#fila-${idx}`).find('.input-producto-id, .input-descripcion').val('');
        $(`#precio-original-${idx}`).hide();

        if (!tipoId) {
            selSubcat.html('<option value="">-- Categoría --</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }
        const tipo = tipos.find(t => t.id === tipoId);
        if (!tipo || !tipo.categories || !tipo.categories.length) {
            selSubcat.html('<option value="">Sin categorías</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }
        let opts = '<option value="">-- Categoría --</option>';
        tipo.categories.forEach(c => { opts += `<option value="${c.id}">${c.name}</option>`; });
        selSubcat.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
    });

    $(document).on('change', '.sel-subcategoria', function() {
        const idx         = $(this).data('index');
        const categoriaId = parseInt($(this).val());
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        $(`#fila-${idx}`).find('.input-producto-id').val('');
        $(`#fila-${idx}`).find('.input-descripcion').val('');
        $(`#fila-${idx}`).find('.input-precio').val(0);
        $(`#precio-original-${idx}`).hide();

        if (!categoriaId) {
            selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }
        const prods = productosDB.filter(p => p.categorie_id === categoriaId);
        if (!prods.length) {
            selProducto.html('<option value="">Sin productos</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }
        let opts = '<option value="">-- Producto --</option>';
        prods.forEach(p => {
            const marca  = p.marca  ? ` (${p.marca.name})` : '';
            opts += `<option value="${p.id}" data-precio="${p.precio||0}" data-nombre="${p.name}" data-marca="${p.marca?.name||''}" data-desc="${p.descripcion||''}">${p.codigo ? p.codigo+' — ':'' }${p.name}${marca}</option>`;
        });
        selProducto.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
    });

    $(document).on('change', '.sel-producto', function() {
        const idx      = $(this).data('index');
        const fila     = $(`#fila-${idx}`);
        const selected = $(this).find(':selected');

        if ($(this).val()) {
            fila.find('.input-producto-id').val($(this).val());
            fila.find('.input-descripcion').val(selected.data('nombre'));
            const precioOriginal = parseFloat(selected.data('precio') || 0);
            fila.find('.input-precio').val(precioOriginal.toFixed(2));
            fila.find('input[name*="[especificaciones]"]').val(selected.data('desc') || '');
            if (precioOriginal > 0) {
                $(`#precio-original-${idx}`).html(`<i class="bi bi-tag me-1"></i>Precio original: S/ ${precioOriginal.toFixed(2)}`).show();
            } else {
                $(`#precio-original-${idx}`).hide();
            }
        } else {
            fila.find('.input-producto-id, .input-descripcion').val('');
            fila.find('.input-precio').val(0);
            $(`#precio-original-${idx}`).hide();
        }
        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== CASCADA: TIPO SERVICIO → SERVICIO ====================
    $(document).on('change', '.sel-servicio-especifico', function() {

        const idx      = $(this).data('index');
        const fila     = $(`#fila-${idx}`);
        const selected = $(this).find(':selected');
        const val      = $(this).val();

        if (val) {
            fila.find('.input-servicio-id').val(val);
            const nombre = selected.text().replace(/\s*\([^)]*\)\s*$/, '').trim();
            const desc   = selected.data('desc') || '';
            fila.find('.input-descripcion').val(nombre);
            const hint = $(`#desc-servicio-${idx}`);
            if (desc) { hint.find('span').text(desc); hint.show(); }
            else { hint.hide(); }
        } else {
            fila.find('.input-servicio-id').val('');
            fila.find('.input-descripcion').val('');
            $(`#desc-servicio-${idx}`).hide();
        }
        calcularSubtotalFila(idx);
        calcularTotales();
    });


    // ==================== RESTAURAR CASCADA PRODUCTO (old/guardado) ====================
    function restaurarCascadaProducto(idx, tipoId, categoriaId, productoId, precioGuardado) {
        if (!tipoId) return;

        const selTipo    = $(`.sel-tipo[data-index="${idx}"]`);
        const selSubcat  = $(`.sel-subcategoria[data-index="${idx}"]`);
        const selProd    = $(`.sel-producto[data-index="${idx}"]`);

        // 1. Seleccionar Tipo y poblar Categorías
        const tipo = tipos.find(t => t.id == tipoId);
        if (!tipo) return;

        let optsCat = '<option value="">-- Categoría --</option>';
        (tipo.categories || []).forEach(cat => {
            const sel = cat.id == categoriaId ? 'selected' : '';
            optsCat += `<option value="${cat.id}" ${sel}>${cat.name}</option>`;
        });
        selSubcat.html(optsCat).prop('disabled', false);
        selTipo.val(tipoId);

        // 2. Poblar Productos de la categoría
        if (!categoriaId) return;
        const prods = productosDB.filter(p => p.categorie_id == categoriaId);
        if (!prods.length) return;

        let optsProd = '<option value="">-- Producto --</option>';
        prods.forEach(p => {
            const marca = p.marca ? ` (${p.marca.name})` : '';
            const sel   = p.id == productoId ? 'selected' : '';
            optsProd += `<option value="${p.id}" data-precio="${p.precio||0}" data-nombre="${p.name}" data-marca="${p.marca?.name||''}" data-desc="${p.descripcion||''}" ${sel}>${p.codigo ? p.codigo+' — ':''}${p.name}${marca}</option>`;
        });
        selProd.html(optsProd).prop('disabled', false);

        // 3. Si hay producto, mostrar precio original
        if (productoId) {
            const prod = prods.find(p => p.id == productoId);
            if (prod) {
                const precioOriginal = parseFloat(prod.precio || 0);
                if (precioOriginal > 0) {
                    $(`#precio-original-${idx}`).html(`<i class="bi bi-tag me-1"></i>Precio original: S/ ${precioOriginal.toFixed(2)}`).show();
                }
                $(`#fila-${idx}`).find('.input-descripcion').val(prod.name);
                // Precio final = lo guardado (puede haber sido editado manualmente)
                if (precioGuardado) {
                    $(`#fila-${idx}`).find('.input-precio').val(parseFloat(precioGuardado).toFixed(2));
                }
            }
        }

        // 4. Reinicializar Select2
        reinitSelect2(`.sel-tipo[data-index="${idx}"]`);
        reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);

        calcularSubtotalFila(idx);
        calcularTotales();
    }

    // ==================== QUITAR FILA ====================
    window.quitarFila = function(i) {
        $(`#fila-${i}`).remove();
        calcularTotales();
        if ($('.item-fila').length === 0) $('#sinItems').show();
    };

    // ==================== CÁLCULOS ====================
    $(document).on('input', '.input-cantidad, .input-precio', function() {
        const idx = $(this).closest('tr').attr('id').replace('fila-', '');
        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ── UTILIDADES DE PRECISIÓN FINANCIERA ──────────────────────────────────
    // Regla: operar siempre con round6; sólo redondear a 2 al mostrar en pantalla.
    // Razón: IEEE-754 double acumula error en cada operación; round6 lo contiene.
    function round6(val) { return Math.round(parseFloat(val || 0) * 1e6) / 1e6; }
    function round2(val) { return Math.round(val * 100) / 100; }
    function fmtMoney(val) {
        return 'S/ ' + round2(val).toFixed(2);
    }

    function calcularSubtotalFila(idx) {
        const fila   = $(`#fila-${idx}`);
        const cant   = round6(fila.find('.input-cantidad').val());
        const precio = round6(fila.find('.input-precio').val());
        // Multiplicar como floats de 64-bit y redondear a 6 para contener error
        const sub    = round6(cant * precio);
        $(`#subtotal-${idx}`).text(fmtMoney(sub));
        return sub; // devolver con 6 decimales para acumulación exacta
    }

    function calcularTotales() {
        let subtotal = 0;  // acumulador en escala 6
        let desglose = {};

        $('.item-fila').each(function() {
            const idx = $(this).attr('id').replace('fila-', '');
            const sub = calcularSubtotalFila(idx);
            subtotal  = round6(subtotal + sub); // sumar y re-redondear a 6
            const cat = $(this).data('tipo');
            desglose[cat] = round6((desglose[cat] || 0) + sub);
        });

        const dtoPct   = round6($('#descuento_porcentaje').val());
        // descuento_monto = subtotal × (pct/100)  — en escala 6
        const dtoMonto = round6(subtotal * (dtoPct / 100));
        const base     = round6(subtotal - dtoMonto);
        const conIgv   = $('#incluye_igv').is(':checked');

        let igv, total, baseNeta;
        if (conIgv) {
            // Precio YA incluye IGV → extraer: base_neta = total / 1.18
            total    = base;
            baseNeta = round6(total / 1.18);
            igv      = round6(total - baseNeta);
        } else {
            // Precio sin IGV → añadir: igv = base × 0.18
            baseNeta = base;
            igv      = round6(base * 0.18);
            total    = round6(base + igv);
        }

        // Mostrar con 2 decimales (presentación SUNAT)
        $('#calc-subtotal').text(fmtMoney(subtotal));
        $('#calc-descuento').text('- ' + fmtMoney(dtoMonto));
        $('#calc-base').text(fmtMoney(baseNeta));
        $('#calc-igv').text(conIgv ? fmtMoney(igv) : 'S/ 0.00');
        $('#calc-total').text(fmtMoney(total));

        // Enviar 6 decimales al servidor — el servidor recalcula con bcmath
        $('#input-subtotal').val(subtotal.toFixed(6));
        $('#input-igv').val(igv.toFixed(6));
        $('#input-total').val(total.toFixed(6));
        $('#input-descuento-monto').val(dtoMonto.toFixed(6));

        // Desglose por categoría
        let desgloseHtml = '';
        for (let cat in desglose) {
            const nombre = tipoNombres[cat] || cat;
            desgloseHtml += `<div class="d-flex justify-content-between mb-1">
                <span><i class="bi bi-circle-fill text-${tipoColors[cat]||'secondary'} me-1" style="font-size:0.5rem;"></i>${nombre}:</span>
                <span class="fw-bold">${fmtMoney(desglose[cat])}</span>
            </div>`;
        }
        $('#desglose-categorias').html(desgloseHtml || '<span class="text-muted">Sin ítems</span>');
    }

    
    $('#descuento_porcentaje').on('input', calcularTotales);

    // ==================== DETALLE DE OPORTUNIDAD ====================
    const tipoProyectoLabels = {
        'residencial': 'Residencial', 'comercial': 'Comercial',
        'industrial': 'Industrial', 'agricola': 'Agrícola'
    };
    const tipoOportunidadLabels = {
        'producto': 'Venta de Producto', 'servicio': 'Servicio', 'mixto': 'Mixto'
    };

    function actualizarDetalleOportunidad(sel) {
        if (!sel.val()) {
            $('#oportunidad-detalle').slideUp(200);
            return;
        }
        const prospecto    = sel.data('prospecto');
        const email        = sel.data('email');
        const tel          = sel.data('telefono');
        const tipoProyecto = sel.data('tipo-proyecto');
        const tipoOp       = sel.data('tipo');

        $('#op-prospecto').text(prospecto || '—');
        let contacto = [];
        if (email) contacto.push(`<i class="bi bi-envelope me-1"></i>${email}`);
        if (tel)   contacto.push(`<i class="bi bi-telephone me-1"></i>${tel}`);
        $('#op-contacto').html(contacto.length ? contacto.join(' &nbsp;&middot;&nbsp; ') : '—');

        $('#op-segmento').text(tipoProyectoLabels[tipoProyecto] || tipoProyecto || '—');
        $('#op-tipo-oportunidad').text(tipoOportunidadLabels[tipoOp] || (tipoOp ? tipoOp.charAt(0).toUpperCase()+tipoOp.slice(1) : '—'));

        $('#oportunidad-detalle').slideDown(200);
    }

    $('#oportunidad_id').on('change', function() {
        actualizarDetalleOportunidad($(this).find(':selected'));
    });

    // Disparar al cargar
    if ($('#oportunidad_id').val()) {
        actualizarDetalleOportunidad($('#oportunidad_id').find(':selected'));
    }
});
</script>
@endsection
