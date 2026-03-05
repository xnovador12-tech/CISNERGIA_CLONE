@extends('TEMPLATES.administrador')
@section('title', 'Nueva Cotización')

@section('css')
<style>
    .tabla-items th { font-size: 0.75rem; text-transform: uppercase; background: #f8f9fa; }
    .tabla-items td { vertical-align: top; }
    .tabla-items .form-control, .tabla-items .form-select { font-size: 0.8rem; }
    .item-subtotal { font-weight: 600; min-width: 100px; text-align: right; }
    .btn-quitar { padding: 0.15rem 0.4rem; font-size: 0.75rem; }
    .resumen-valor { font-size: 0.95rem; }
    .cascada-selects { display: flex; flex-wrap: wrap; gap: 4px; }
    .cascada-selects .sel-wrap-half { flex: 1; min-width: 100px; }
    .cascada-selects .sel-wrap-full { flex: 0 0 100%; }
    .producto-info { font-size: 0.72rem; color: #6c757d; margin-top: 2px; }
    .cascada-selects .select2-container { font-size: 0.8rem; }
    .cascada-selects .select2-container--bootstrap-5 .select2-selection { min-height: 28px; padding: 0.15rem 0.5rem; font-size: 0.8rem; }
</style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA COTIZACIÓN</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
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

    <form action="{{ route('admin.crm.cotizaciones.store') }}" method="POST" id="formCotizacion">
        @csrf

        <div class="container-fluid">
            <div class="row g-4">
                {{-- ===================== COLUMNA PRINCIPAL ===================== --}}
                <div class="col-lg-8">

                    {{-- Card: Oportunidad y Vigencia --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold">Información General</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Oportunidad <span class="text-danger">*</span></label>
                                    <select name="oportunidad_id" id="oportunidad_id" class="form-select form-select-sm select2_bootstrap w-100 @error('oportunidad_id') is-invalid @enderror" required data-placeholder="Seleccione una oportunidad...">
                                        <option value="">Seleccione una oportunidad...</option>
                                        @foreach($oportunidades as $op)
                                            <option value="{{ $op->id }}"
                                                    {{ old('oportunidad_id', $oportunidadId) == $op->id ? 'selected' : '' }}
                                                    data-tipo="{{ $op->tipo_oportunidad }}"
                                                    data-monto="{{ $op->monto_estimado }}"
                                                    data-nombre="{{ $op->nombre }}">
                                                {{ $op->codigo }} - {{ $op->nombre }}
                                                @if($op->prospecto) ({{ $op->prospecto->nombre_completo }}) @endif
                                                — {{ ucfirst($op->tipo_oportunidad) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('oportunidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Vigencia <span class="text-danger">*</span></label>
                                    <select name="vigencia_dias" class="form-select form-select-sm" required>
                                        <option value="15" {{ old('vigencia_dias') == 15 ? 'selected' : '' }}>15 días</option>
                                        <option value="30" {{ old('vigencia_dias', 30) == 30 ? 'selected' : '' }}>30 días</option>
                                        <option value="45" {{ old('vigencia_dias') == 45 ? 'selected' : '' }}>45 días</option>
                                        <option value="60" {{ old('vigencia_dias') == 60 ? 'selected' : '' }}>60 días</option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="wrap-tiempo-ejecucion" style="display:none;">
                                    <label class="form-label">Tiempo Ejecución</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="tiempo_ejecucion_dias" class="form-control" value="{{ old('tiempo_ejecucion_dias', 5) }}" min="1">
                                        <span class="input-group-text">días</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Nombre del Proyecto <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control form-control-sm @error('nombre_proyecto') is-invalid @enderror"
                                           value="{{ old('nombre_proyecto') }}" placeholder="Se completará al seleccionar la oportunidad" required>
                                    @error('nombre_proyecto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Ítems de la Cotización --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold">Detalle de Ítems</p>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered tabla-items mb-0" id="tablaItems">
                                    <thead>
                                        <tr>
                                            <th style="width: 120px;">Categoría</th>
                                            <th>Descripción / Producto</th>
                                            <th style="width: 70px;">Cant.</th>
                                            <th style="width: 80px;">Unidad</th>
                                            <th style="width: 110px;">P. Unit.</th>
                                            <th style="width: 65px;">Dto.%</th>
                                            <th style="width: 110px;">Subtotal</th>
                                            <th style="width: 35px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                        {{-- Filas dinámicas via JS --}}
                                    </tbody>
                                </table>
                            </div>

                            <div id="sinItems" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No hay ítems. Haga clic en <strong>"Agregar Ítem"</strong> para comenzar.</p>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btnAgregarItem">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Ítem
                            </button>
                        </div>
                    </div>

                    {{-- Card: Notas y Condiciones --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold">Notas y Condiciones</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Condiciones Comerciales</label>
                                    <textarea name="condiciones_comerciales" class="form-control form-control-sm" rows="2"
                                              placeholder="Condiciones de pago, plazos de entrega, etc.">{{ old('condiciones_comerciales') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Garantía de Servicio</label>
                                    <input type="text" name="garantia_servicio" class="form-control form-control-sm"
                                           value="{{ old('garantia_servicio') }}" placeholder="Ej: 2 años en mano de obra">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" class="form-control form-control-sm" rows="1"
                                              placeholder="Observaciones generales">{{ old('observaciones') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas Internas <small class="text-muted">(solo visibles para el equipo)</small></label>
                                    <textarea name="notas_internas" class="form-control form-control-sm" rows="2"
                                              placeholder="Solo visible para el equipo interno">{{ old('notas_internas') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== COLUMNA LATERAL - RESUMEN ===================== --}}
                <div class="col-lg-4">
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold"><i class="bi bi-calculator me-1"></i>Resumen</p>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="resumen-valor" id="calc-subtotal">S/ 0.00</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Descuento General (%)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" name="descuento_porcentaje" id="descuento_porcentaje"
                                           class="form-control form-control-sm" value="{{ old('descuento_porcentaje', 0) }}" min="0" max="50">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento:</span>
                                <span class="resumen-valor" id="calc-descuento">- S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Base Imponible:</span>
                                <span class="resumen-valor" id="calc-base">S/ 0.00</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="incluye_igv" name="incluye_igv" value="1"
                                           {{ old('incluye_igv', true) ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="incluye_igv">IGV (18%)</label>
                                </div>
                                <span class="resumen-valor" id="calc-igv">S/ 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h6 mb-0 fw-bold">TOTAL:</span>
                                <span class="h5 mb-0 text-primary fw-bold" id="calc-total">S/ 0.00</span>
                            </div>

                            <hr>
                            <p class="small text-muted mb-2 fw-bold">Desglose por categoría:</p>
                            <div id="desglose-categorias" class="small">
                                <span class="text-muted">Sin ítems</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary px-5 text-white">
                            <i class="bi bi-save me-2"></i>Registrar Cotización
                        </button>
                        <a href="{{ route('admin.crm.cotizaciones.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="subtotal" id="input-subtotal">
        <input type="hidden" name="igv" id="input-igv">
        <input type="hidden" name="total" id="input-total">
        <input type="hidden" name="descuento_monto" id="input-descuento-monto">
    </form>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // ==================== DATOS DEL SERVIDOR ====================
    const tipos = @json($tipos);
    const productosDB = @json($productos);

    const catNombres = { 'producto': 'Productos', 'servicio': 'Servicios' };
    const catColors = { producto: 'primary', servicio: 'info' };

    // Sugerencias predefinidas para servicios
    const sugerencias = {
        servicio: [
            { desc: 'Instalación completa de sistema solar', unidad: 'glb' },
            { desc: 'Mano de obra técnica especializada', unidad: 'dia' },
            { desc: 'Mantenimiento preventivo', unidad: 'glb' },
            { desc: 'Mantenimiento correctivo - Diagnóstico y reparación', unidad: 'glb' },
            { desc: 'Trámite ante distribuidora eléctrica', unidad: 'glb' },
            { desc: 'Diseño de ingeniería y dimensionamiento', unidad: 'glb' },
            { desc: 'Transporte de equipos', unidad: 'glb' },
            { desc: 'Monitoreo remoto del sistema (anual)', unidad: 'glb' },
            { desc: 'Conexión eléctrica y puesta en marcha', unidad: 'glb' },
        ],
    };

    let itemIndex = 0;

    // ==================== AGREGAR ÍTEM ====================
    $('#btnAgregarItem').on('click', function() {
        agregarFila('producto');
    });

    function agregarFila(categoria = 'producto', datos = {}) {
        const i = itemIndex++;
        $('#sinItems').hide();

        const esProducto = categoria === 'producto';

        // ---- Celda de descripción ----
        let celdaDescripcion = '';

        if (esProducto) {
            // Selects en cascada: Tipo → Categoría → Producto
            let optTipos = '<option value="">-- Tipo --</option>';
            tipos.forEach(t => {
                optTipos += `<option value="${t.id}">${t.name}</option>`;
            });

            celdaDescripcion = `
                <div class="cascada-selects">
                    <div class="sel-wrap-half"><select class="form-select form-select-sm sel-tipo" data-index="${i}">
                        ${optTipos}
                    </select></div>
                    <div class="sel-wrap-half"><select class="form-select form-select-sm sel-subcategoria" data-index="${i}" disabled>
                        <option value="">-- Categoría --</option>
                    </select></div>
                    <div class="sel-wrap-full"><select class="form-select form-select-sm sel-producto" data-index="${i}" disabled>
                        <option value="">-- Producto --</option>
                    </select></div>
                </div>
                <input type="hidden" name="items[${i}][producto_id]" class="input-producto-id" value="${datos.producto_id || ''}">
                <input type="hidden" name="items[${i}][descripcion]" class="input-descripcion" value="${datos.descripcion || ''}" required>
                <input type="hidden" name="items[${i}][especificaciones]" value="${datos.especificaciones || ''}">
                <div class="producto-info" id="producto-info-${i}"></div>`;
        } else {
            // Select de servicios predefinidos + opción personalizada
            let selectHtml = '';
            if (sugerencias[categoria]) {
                selectHtml = `<select class="form-select form-select-sm sel-sugerencia mb-1" data-index="${i}">
                    <option value="">-- Seleccione un servicio --</option>`;
                sugerencias[categoria].forEach(s => {
                    const sel = datos.descripcion === s.desc ? 'selected' : '';
                    selectHtml += `<option value="${s.desc}" data-unidad="${s.unidad}" ${sel}>${s.desc}</option>`;
                });
                selectHtml += `<option value="__custom__" ${datos.descripcion && !sugerencias[categoria].some(s => s.desc === datos.descripcion) ? 'selected' : ''}>✏️ Personalizado...</option>`;
                selectHtml += `</select>`;
            }

            const esCustom = datos.descripcion && sugerencias[categoria] && !sugerencias[categoria].some(s => s.desc === datos.descripcion);
            const mostrarInput = !sugerencias[categoria] || esCustom;

            celdaDescripcion = `
                ${selectHtml}
                <input type="text" name="items[${i}][descripcion]" class="form-control form-control-sm input-descripcion input-descripcion-custom"
                       value="${datos.descripcion || ''}" placeholder="Escriba la descripción del ítem" required
                       style="${mostrarInput ? '' : 'display:none'}">
                <input type="hidden" name="items[${i}][producto_id]" class="input-producto-id" value="">
                <input type="hidden" name="items[${i}][especificaciones]" value="">`;
        }

        const fila = `
        <tr id="fila-${i}" class="item-fila" data-categoria="${categoria}">
            <td>
                <select name="items[${i}][categoria]" class="form-select form-select-sm sel-categoria" data-index="${i}">
                    <option value="producto" ${categoria === 'producto' ? 'selected' : ''}>Producto</option>
                    <option value="servicio" ${categoria === 'servicio' ? 'selected' : ''}>Servicio</option>
                </select>
            </td>
            <td class="celda-descripcion">${celdaDescripcion}</td>
            <td>
                <input type="number" name="items[${i}][cantidad]" class="form-control form-control-sm input-cantidad"
                       value="${datos.cantidad || 1}" step="0.01" min="0.01" required>
            </td>
            <td>
                <select name="items[${i}][unidad]" class="form-select form-select-sm input-unidad">
                    <option value="und" ${(datos.unidad || 'und') === 'und' ? 'selected' : ''}>Und</option>
                    <option value="glb" ${datos.unidad === 'glb' ? 'selected' : ''}>Global</option>
                    <option value="hrs" ${datos.unidad === 'hrs' ? 'selected' : ''}>Horas</option>
                    <option value="dia" ${datos.unidad === 'dia' ? 'selected' : ''}>Día</option>
                    <option value="kg" ${datos.unidad === 'kg' ? 'selected' : ''}>Kg</option>
                    <option value="m" ${datos.unidad === 'm' ? 'selected' : ''}>Metro</option>
                    <option value="m2" ${datos.unidad === 'm2' ? 'selected' : ''}>M²</option>
                    <option value="ml" ${datos.unidad === 'ml' ? 'selected' : ''}>ML</option>
                    <option value="jgo" ${datos.unidad === 'jgo' ? 'selected' : ''}>Juego</option>
                    <option value="rollo" ${datos.unidad === 'rollo' ? 'selected' : ''}>Rollo</option>
                </select>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text" style="font-size:0.7rem;">S/</span>
                    <input type="number" name="items[${i}][precio_unitario]" class="form-control form-control-sm input-precio"
                           value="${datos.precio_unitario || 0}" step="0.01" min="0" required>
                </div>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <input type="number" name="items[${i}][descuento_porcentaje]" class="form-control form-control-sm input-dto"
                           value="${datos.descuento_porcentaje || 0}" step="0.01" min="0" max="100">
                    <span class="input-group-text" style="font-size:0.7rem;">%</span>
                </div>
            </td>
            <td class="item-subtotal text-end pt-2" id="subtotal-${i}">S/ 0.00</td>
            <td class="text-center pt-2">
                <button type="button" class="btn btn-outline-danger btn-quitar" onclick="quitarFila(${i})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>`;

        $('#tbodyItems').append(fila);

        // Inicializar Select2 en cascada si es producto
        if (esProducto) {
            initSelect2Cascada(i);
        }

        calcularSubtotalFila(i);
        calcularTotales();
    }

    // ==================== SELECT2 HELPERS ====================
    function initSelect2Cascada(idx) {
        var fila = $(`#fila-${idx}`);
        fila.find('.sel-tipo, .sel-subcategoria, .sel-producto').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: $(this).find('option:first').text()
            });
        });
    }

    function reinitSelect2(selector) {
        var el = $(selector);
        if (el.hasClass('select2-hidden-accessible')) {
            el.select2('destroy');
        }
        el.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: el.find('option:first').text()
        });
    }

    // ==================== CAMBIO DE CATEGORÍA (SELECT) ====================
    $(document).on('change', '.sel-categoria', function() {
        const idx = $(this).data('index');
        const nuevaCat = $(this).val();
        const fila = $(`#fila-${idx}`);

        // Guardar datos actuales
        const cantActual = fila.find('.input-cantidad').val();
        const precioActual = fila.find('.input-precio').val();
        const unidadActual = fila.find('.input-unidad').val();

        // Eliminar fila y recrear con nueva categoría
        fila.remove();
        itemIndex--; // Reutilizar índice
        agregarFila(nuevaCat, {
            cantidad: cantActual,
            precio_unitario: precioActual,
            unidad: unidadActual
        });
    });

    // ==================== CASCADA: TIPO → CATEGORÍA ====================
    $(document).on('change', '.sel-tipo', function() {
        const idx = $(this).data('index');
        const tipoId = parseInt($(this).val());
        const selSubcat = $(`.sel-subcategoria[data-index="${idx}"]`);
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
        $(`#fila-${idx}`).find('.input-producto-id').val('');
        $(`#fila-${idx}`).find('.input-descripcion').val('');
        $(`#producto-info-${idx}`).html('');

        if (!tipoId) {
            selSubcat.html('<option value="">-- Categoría --</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }

        const tipo = tipos.find(t => t.id === tipoId);
        if (!tipo || !tipo.categories || tipo.categories.length === 0) {
            selSubcat.html('<option value="">Sin categorías</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }

        let opts = '<option value="">-- Categoría --</option>';
        tipo.categories.forEach(c => {
            opts += `<option value="${c.id}">${c.name}</option>`;
        });
        selSubcat.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
    });

    // ==================== CASCADA: CATEGORÍA → PRODUCTO ====================
    $(document).on('change', '.sel-subcategoria', function() {
        const idx = $(this).data('index');
        const categoriaId = parseInt($(this).val());
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        $(`#fila-${idx}`).find('.input-producto-id').val('');
        $(`#fila-${idx}`).find('.input-descripcion').val('');
        $(`#fila-${idx}`).find('.input-precio').val(0);
        $(`#producto-info-${idx}`).html('');

        if (!categoriaId) {
            selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }

        const prods = productosDB.filter(p => p.categorie_id === categoriaId);

        if (prods.length === 0) {
            selProducto.html('<option value="">Sin productos</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }

        let opts = '<option value="">-- Producto --</option>';
        prods.forEach(p => {
            const marca = p.marca ? ` (${p.marca.name})` : '';
            const precio = p.precio ? ` - S/ ${parseFloat(p.precio).toFixed(2)}` : '';
            opts += `<option value="${p.id}" data-precio="${p.precio || 0}" data-nombre="${p.name}" data-marca="${p.marca?.name || ''}" data-desc="${p.descripcion || ''}">${p.codigo ? p.codigo + ' - ' : ''}${p.name}${marca}${precio}</option>`;
        });
        selProducto.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
    });

    // ==================== SELECCIÓN DE PRODUCTO ====================
    $(document).on('change', '.sel-producto', function() {
        const idx = $(this).data('index');
        const fila = $(`#fila-${idx}`);
        const selected = $(this).find(':selected');
        const productoId = $(this).val();

        if (productoId) {
            fila.find('.input-producto-id').val(productoId);
            fila.find('.input-descripcion').val(selected.data('nombre'));
            fila.find('.input-precio').val(parseFloat(selected.data('precio') || 0).toFixed(2));
            fila.find('input[name*="[especificaciones]"]').val(selected.data('desc') || '');

            const marca = selected.data('marca');
            let infoHtml = `<i class="bi bi-check-circle text-success me-1"></i><strong>${selected.data('nombre')}</strong>`;
            if (marca) infoHtml += ` — ${marca}`;
            $(`#producto-info-${idx}`).html(infoHtml);
        } else {
            fila.find('.input-producto-id').val('');
            fila.find('.input-descripcion').val('');
            fila.find('.input-precio').val(0);
            $(`#producto-info-${idx}`).html('');
        }

        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== SELECT DE SERVICIOS ====================
    $(document).on('change', '.sel-sugerencia', function() {
        const idx = $(this).data('index');
        const fila = $(`#fila-${idx}`);
        const val = $(this).val();
        const inputDesc = fila.find('.input-descripcion');
        const inputCustom = fila.find('.input-descripcion-custom');

        if (val === '__custom__') {
            inputCustom.val('').show().focus();
        } else if (val) {
            const unidad = $(this).find(':selected').data('unidad');
            inputDesc.val(val);
            inputCustom.val(val).hide();
            if (unidad) fila.find('.input-unidad').val(unidad);
        } else {
            inputDesc.val('');
            inputCustom.val('').hide();
        }
    });

    // ==================== QUITAR FILA ====================
    window.quitarFila = function(i) {
        $(`#fila-${i}`).remove();
        calcularTotales();
        if ($('.item-fila').length === 0) {
            $('#sinItems').show();
        }
    }

    // ==================== CÁLCULOS ====================
    $(document).on('input', '.input-cantidad, .input-precio, .input-dto', function() {
        const fila = $(this).closest('tr');
        const idx = fila.attr('id').replace('fila-', '');
        calcularSubtotalFila(idx);
        calcularTotales();
    });

    function calcularSubtotalFila(idx) {
        const fila = $(`#fila-${idx}`);
        const cant = parseFloat(fila.find('.input-cantidad').val()) || 0;
        const precio = parseFloat(fila.find('.input-precio').val()) || 0;
        const dto = parseFloat(fila.find('.input-dto').val()) || 0;
        const bruto = cant * precio;
        const descuento = bruto * (dto / 100);
        const subtotal = bruto - descuento;
        $(`#subtotal-${idx}`).text('S/ ' + subtotal.toFixed(2));
        return subtotal;
    }

    function calcularTotales() {
        let subtotal = 0;
        let desglose = {};

        $('.item-fila').each(function() {
            const idx = $(this).attr('id').replace('fila-', '');
            const sub = calcularSubtotalFila(idx);
            subtotal += sub;

            const cat = $(this).find('.sel-categoria').val();
            desglose[cat] = (desglose[cat] || 0) + sub;
        });

        const dtoPct = parseFloat($('#descuento_porcentaje').val()) || 0;
        const dtoMonto = subtotal * (dtoPct / 100);
        
        // IMPORTANTE: Los precios en productos YA incluyen IGV
        // Si IGV está marcado, extraemos el IGV en lugar de sumarlo
        const conIgv = $('#incluye_igv').is(':checked');
        const subtotalConDescuento = subtotal - dtoMonto;
        
        let base, igv, total;
        if (conIgv) {
            // Los precios tienen IGV incluido, extraer base e IGV
            total = subtotalConDescuento;
            base = total / 1.18;
            igv = total - base;
        } else {
            // Sin IGV
            base = subtotalConDescuento;
            igv = 0;
            total = base;
        }

        $('#calc-subtotal').text('S/ ' + subtotal.toFixed(2));
        $('#calc-descuento').text('- S/ ' + dtoMonto.toFixed(2));
        $('#calc-base').text('S/ ' + base.toFixed(2));
        $('#calc-igv').text(conIgv ? 'S/ ' + igv.toFixed(2) : 'S/ 0.00');
        $('#calc-total').text('S/ ' + total.toFixed(2));

        $('#input-subtotal').val(subtotal.toFixed(2));
        $('#input-igv').val(igv.toFixed(2));
        $('#input-total').val(total.toFixed(2));
        $('#input-descuento-monto').val(dtoMonto.toFixed(2));

        let desgloseHtml = '';
        for (let cat in desglose) {
            const nombre = catNombres[cat] || cat;
            desgloseHtml += `<div class="d-flex justify-content-between mb-1">
                <span><i class="bi bi-circle-fill text-${catColors[cat] || 'secondary'} me-1" style="font-size:0.5rem;"></i>${nombre}:</span>
                <span class="fw-bold">S/ ${desglose[cat].toFixed(2)}</span>
            </div>`;
        }
        $('#desglose-categorias').html(desgloseHtml || '<span class="text-muted">Sin ítems</span>');
    }

    // ==================== IGV y DESCUENTO ====================
    $('#incluye_igv').on('change', calcularTotales);
    $('#descuento_porcentaje').on('input', calcularTotales);

    // ==================== OPORTUNIDAD SELECCIONADA ====================
    $('#oportunidad_id').on('change', function() {
        const selected = $(this).find(':selected');
        if (selected.val()) {
            $('#nombre_proyecto').val(selected.data('nombre') || '');
            const tipo = selected.data('tipo');
            if (tipo === 'servicio' || tipo === 'mixto') {
                $('#wrap-tiempo-ejecucion').show();
            } else {
                $('#wrap-tiempo-ejecucion').hide().find('input').val('');
            }
        } else {
            $('#wrap-tiempo-ejecucion').hide();
        }
    });

    if ($('#oportunidad_id').val()) {
        $('#oportunidad_id').trigger('change');
    }
});
</script>
@endsection
