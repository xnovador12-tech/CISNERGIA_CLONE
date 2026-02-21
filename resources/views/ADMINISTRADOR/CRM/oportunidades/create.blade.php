@extends('TEMPLATES.administrador')
@section('title', 'Nueva Oportunidad')

@section('css')
<style>
    .tabla-items th { font-size: 0.75rem; text-transform: uppercase; background: #f8f9fa; }
    .tabla-items td { vertical-align: top; }
    .tabla-items .form-control, .tabla-items .form-select { font-size: 0.8rem; }
    .item-subtotal { font-weight: 600; min-width: 100px; text-align: right; }
    .btn-quitar { padding: 0.15rem 0.4rem; font-size: 0.75rem; }
    .cascada-selects { display: flex; flex-wrap: wrap; gap: 4px; }
    .cascada-selects .sel-wrap { flex: 1; min-width: 120px; }
    .producto-info { font-size: 0.72rem; color: #6c757d; margin-top: 2px; }
    .cascada-selects .select2-container { font-size: 0.8rem; }
    .cascada-selects .select2-container--bootstrap-5 .select2-selection { min-height: 28px; padding: 0.15rem 0.5rem; font-size: 0.8rem; }
</style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA OPORTUNIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.oportunidades.index') }}">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.crm.oportunidades.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-body">

                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Seleccione un prospecto para llenar datos automáticamente. Los campos con <span class="text-danger">*</span> son obligatorios.</small>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- ===================== PROSPECTO ===================== --}}
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Prospecto Vinculado</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 @error('prospecto_id') is-invalid @enderror" name="prospecto_id" id="prospecto_id" required data-placeholder="Seleccionar prospecto...">
                                <option value="">Seleccionar prospecto...</option>
                                @foreach($prospectos ?? [] as $prospecto)
                                    <option value="{{ $prospecto->id }}"
                                            {{ old('prospecto_id', $prospectoId ?? '') == $prospecto->id ? 'selected' : '' }}
                                            data-nombre="{{ $prospecto->nombre_completo }}"
                                            data-email="{{ $prospecto->email }}"
                                            data-celular="{{ $prospecto->celular }}"
                                            data-segmento="{{ $prospecto->segmento }}"
                                            data-tipo-interes="{{ $prospecto->tipo_interes }}"
                                            data-user-id="{{ $prospecto->user_id }}">
                                        {{ $prospecto->codigo }} - {{ $prospecto->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prospecto_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6" id="info_prospecto" style="display: none;">
                            <div class="card bg-light border-0">
                                <div class="card-body py-2">
                                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i><span id="info_email">-</span></small>
                                    <small class="text-muted d-block"><i class="bi bi-phone me-1"></i><span id="info_celular">-</span></small>
                                    <small class="text-muted d-block"><i class="bi bi-tag me-1"></i>Segmento: <span id="info_segmento" class="fw-semibold">-</span></small>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== INFORMACIÓN GENERAL ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información General</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre de la Oportunidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('nombre') is-invalid @enderror" name="nombre" id="nombre_oportunidad"
                                   value="{{ old('nombre') }}" placeholder="Ej: Sistema Solar 5kW - Juan Pérez" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Oportunidad <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 @error('tipo_oportunidad') is-invalid @enderror" name="tipo_oportunidad" id="tipo_oportunidad" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <option value="producto" {{ old('tipo_oportunidad', 'producto') == 'producto' ? 'selected' : '' }}>Producto</option>
                                <option value="servicio" {{ old('tipo_oportunidad') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                <option value="mixto" {{ old('tipo_oportunidad') == 'mixto' ? 'selected' : '' }}>Mixto</option>
                            </select>
                            @error('tipo_oportunidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 @error('tipo_proyecto') is-invalid @enderror" name="tipo_proyecto" id="tipo_proyecto" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('tipo_proyecto') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('tipo_proyecto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- ===================== DETALLE SERVICIO (servicio/mixto) ===================== --}}
                        <div id="seccion_servicio" class="col-12" style="display: none;">
                            <div class="row g-3">
                                <div class="col-12 mt-3">
                                    <p class="text-secondary mb-2 small text-uppercase fw-bold"><i class="bi bi-wrench me-1"></i>Detalle del Servicio</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo de Servicio</label>
                                    <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_servicio" data-placeholder="Seleccionar...">
                                        <option value="">Seleccionar...</option>
                                        <option value="instalacion" {{ old('tipo_servicio') == 'instalacion' ? 'selected' : '' }}>Instalación</option>
                                        <option value="mantenimiento_preventivo" {{ old('tipo_servicio') == 'mantenimiento_preventivo' ? 'selected' : '' }}>Mantenimiento Preventivo</option>
                                        <option value="mantenimiento_correctivo" {{ old('tipo_servicio') == 'mantenimiento_correctivo' ? 'selected' : '' }}>Mantenimiento Correctivo</option>
                                        <option value="ampliacion" {{ old('tipo_servicio') == 'ampliacion' ? 'selected' : '' }}>Ampliación de Sistema</option>
                                        <option value="otro" {{ old('tipo_servicio') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Descripción del Servicio</label>
                                    <textarea class="form-control form-control-sm" name="descripcion_servicio" rows="2" placeholder="Describa qué servicio necesita el cliente...">{{ old('descripcion_servicio') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== VISITA TÉCNICA ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold"><i class="bi bi-geo-alt me-1"></i>Visita Técnica</p>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="requiere_visita_tecnica" id="requiere_visita" value="1"
                                       {{ old('requiere_visita_tecnica') ? 'checked' : '' }}>
                                <label class="form-check-label" for="requiere_visita">¿Requiere visita técnica?</label>
                            </div>
                        </div>

                        <div class="col-md-3" id="campo_fecha_visita" style="display: none;">
                            <label class="form-label">Fecha de Visita Programada</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_visita_programada" value="{{ old('fecha_visita_programada') }}">
                        </div>

                        {{-- ===================== VALORACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Valoración y Pipeline</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control form-control-sm @error('monto_estimado') is-invalid @enderror" name="monto_estimado" id="monto_estimado"
                                       value="{{ old('monto_estimado', $montoEstimado ?? '') }}" step="0.01" min="0" placeholder="45000" required>
                            </div>
                            <small class="text-muted" id="monto-auto-msg" style="display: none;"><i class="bi bi-calculator me-1"></i>Calculado desde productos</small>
                            @error('monto_estimado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Estimada <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm @error('fecha_cierre_estimada') is-invalid @enderror" name="fecha_cierre_estimada"
                                   value="{{ old('fecha_cierre_estimada') }}" required>
                            @error('fecha_cierre_estimada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" id="user_id" data-placeholder="Seleccionar vendedor...">
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id', auth()->id()) == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== DESCRIPCIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Descripción y Notas</p>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Descripción del negocio</label>
                            <textarea class="form-control form-control-sm" name="descripcion" rows="3" placeholder="Describa lo que el cliente necesita, contexto de la conversación...">{{ old('descripcion') }}</textarea>
                            <small class="text-muted">Ej: "Cliente interesado en 10 paneles 550W + inversor. Tiene techo de 80m². Contacto por llamada."</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones internas</label>
                            <textarea class="form-control form-control-sm" name="observaciones" rows="2" placeholder="Notas adicionales...">{{ old('observaciones') }}</textarea>
                        </div>

                        {{-- ===================== PRODUCTOS DE INTERÉS ===================== --}}
                        <div id="seccion_productos" class="col-12 mt-3" style="display: none;">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold"><i class="bi bi-box-seam me-1"></i>Productos de Interés</p>

                            {{-- Banner wishlist (dinámico) --}}
                            <div class="card border-0 rounded-0 border-start border-3 border-warning mb-3" id="banner-wishlist" style="display: none; box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #fff8e1">
                                <div class="card-body py-2 d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-heart-fill text-danger me-1"></i>
                                        El prospecto tiene <strong id="wishlist-count">0</strong> producto(s) en su lista de deseos.
                                    </small>
                                    <button type="button" class="btn btn-sm btn-outline-warning" id="btn-importar-wishlist">
                                        <i class="bi bi-download me-1"></i>Importar
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered tabla-items mb-0" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 70px;">Cant.</th>
                                            <th style="width: 110px;">P. Unit.</th>
                                            <th style="width: 110px;">Subtotal</th>
                                            <th>Notas</th>
                                            <th style="width: 35px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-productos">
                                        {{-- Filas dinámicas JS --}}
                                    </tbody>
                                    <tfoot id="tfoot-totales" style="display: none;">
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total Productos:</td>
                                            <td class="item-subtotal text-primary" id="total-productos">S/ 0.00</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div id="sinItems" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No hay productos. Haga clic en <strong>"Agregar Producto"</strong> o importe desde la wishlist.</p>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btn-agregar-producto">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones (SIN data-aos para evitar bug de scroll) --}}
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.crm.oportunidades.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Registrar Oportunidad
                </button>
            </div>
        </div>
    </form>
@endsection



@section('js')
<script>
$(document).ready(function() {

    // ==================== DATOS DEL SERVIDOR ====================
    const tipos = @json($tipos);
    const productosDB = @json($productos);
    var wishlistData = [];
    var contadorItems = 0;
    var wishlistUrl = "{{ url('admin/crm/prospectos') }}";

    // Mapa de precios por ID
    var preciosMap = {};
    productosDB.forEach(function(p) {
        preciosMap[p.id] = parseFloat(p.precio) || 0;
    });

    // ==================== TOGGLE SECCIONES ====================
    $('#tipo_oportunidad').on('change', function() {
        var valor = $(this).val();
        $('#seccion_servicio').toggle(valor === 'servicio' || valor === 'mixto');
        $('#seccion_productos').toggle(valor === 'producto' || valor === 'mixto');
    }).trigger('change');

    // ==================== TOGGLE VISITA TÉCNICA ====================
    $('#requiere_visita').on('change', function() {
        $('#campo_fecha_visita').toggle($(this).is(':checked'));
    }).trigger('change');

    // ==================== CÁLCULOS ====================
    function calcularSubtotalFila(idx) {
        var fila = $('#fila-' + idx);
        var cant = parseFloat(fila.find('.input-cantidad').val()) || 0;
        var precio = parseFloat(fila.find('.input-precio').val()) || 0;
        var subtotal = cant * precio;
        $('#subtotal-' + idx).text('S/ ' + subtotal.toFixed(2));
        return subtotal;
    }

    function calcularTotales() {
        var total = 0;
        $('.item-fila').each(function() {
            var idx = $(this).attr('id').replace('fila-', '');
            total += calcularSubtotalFila(idx);
        });

        $('#total-productos').text('S/ ' + total.toFixed(2));
        $('#tfoot-totales').toggle($('.item-fila').length > 0);
        $('#sinItems').toggle($('.item-fila').length === 0);

        if (total > 0) {
            $('#monto_estimado').val(total.toFixed(2));
            $('#monto-auto-msg').show();
        } else {
            $('#monto-auto-msg').hide();
        }
    }

    $(document).on('input', '.input-cantidad, .input-precio', function() {
        var idx = $(this).closest('tr').attr('id').replace('fila-', '');
        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== AGREGAR FILA ====================
    function agregarFila(datos) {
        datos = datos || {};
        var i = contadorItems++;
        $('#sinItems').hide();
        $('#tfoot-totales').show();

        // Opciones de tipos
        var optTipos = '<option value="">-- Tipo --</option>';
        tipos.forEach(function(t) {
            var sel = (datos.tipo_id && datos.tipo_id == t.id) ? 'selected' : '';
            optTipos += '<option value="' + t.id + '" ' + sel + '>' + t.name + '</option>';
        });

        var celdaProducto = '<div class="cascada-selects">' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-tipo" data-index="' + i + '">' + optTipos + '</select></div>' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-subcategoria" data-index="' + i + '" disabled><option value="">-- Categoría --</option></select></div>' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-producto" data-index="' + i + '" disabled><option value="">-- Producto --</option></select></div>' +
            '</div>' +
            '<input type="hidden" name="items[' + i + '][producto_id]" class="input-producto-id" value="' + (datos.producto_id || '') + '">' +
            '<div class="producto-info" id="producto-info-' + i + '"></div>';

        var fila = '<tr id="fila-' + i + '" class="item-fila">' +
            '<td>' + celdaProducto + '</td>' +
            '<td><input type="number" name="items[' + i + '][cantidad]" class="form-control form-control-sm input-cantidad" value="' + (datos.cantidad || 1) + '" step="0.01" min="0.01" required></td>' +
            '<td><div class="input-group input-group-sm"><span class="input-group-text" style="font-size:0.7rem;">S/</span><input type="number" name="items[' + i + '][precio_unitario]" class="form-control form-control-sm input-precio" value="' + (datos.precio || 0) + '" step="0.01" min="0" readonly></div></td>' +
            '<td class="item-subtotal text-end pt-2" id="subtotal-' + i + '">S/ 0.00</td>' +
            '<td><input type="text" name="items[' + i + '][notas]" class="form-control form-control-sm" value="' + (datos.notas || '') + '" placeholder="Notas..."></td>' +
            '<td class="text-center pt-2"><button type="button" class="btn btn-outline-danger btn-quitar" onclick="quitarFila(' + i + ')"><i class="bi bi-trash"></i></button></td>' +
        '</tr>';

        $('#tbody-productos').append(fila);

        // Inicializar Select2 en los selects de la fila
        initSelect2Fila(i);

        // Si viene con datos pre-cargados, simular la cascada
        if (datos.producto_id) {
            cargarCascadaCompleta(i, datos.tipo_id, datos.categorie_id, datos.producto_id, datos.precio);
        }

        calcularSubtotalFila(i);
        calcularTotales();
    }

    // Helper: inicializar Select2 en una fila
    function initSelect2Fila(idx) {
        var fila = $('#fila-' + idx);
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

    // Helper: reinicializar un select específico con Select2
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

    // Cargar cascada completa para productos pre-existentes
    function cargarCascadaCompleta(idx, tipoId, categorieId, productoId, precio) {
        // Cargar categorías del tipo
        var tipo = null;
        for (var t = 0; t < tipos.length; t++) {
            if (tipos[t].id == tipoId) { tipo = tipos[t]; break; }
        }

        var selSubcat = $('.sel-subcategoria[data-index="' + idx + '"]');
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        if (tipo && tipo.categories) {
            var opts = '<option value="">-- Categoría --</option>';
            tipo.categories.forEach(function(c) {
                var sel = (c.id == categorieId) ? 'selected' : '';
                opts += '<option value="' + c.id + '" ' + sel + '>' + c.name + '</option>';
            });
            selSubcat.html(opts).prop('disabled', false);
        }

        // Cargar productos de la categoría
        var prods = productosDB.filter(function(p) { return p.categorie_id == categorieId; });
        if (prods.length > 0) {
            var opts2 = '<option value="">-- Producto --</option>';
            prods.forEach(function(p) {
                var sel = (p.id == productoId) ? 'selected' : '';
                var marca = p.marca ? ' (' + p.marca.name + ')' : '';
                var precioTxt = p.precio ? ' - S/ ' + parseFloat(p.precio).toFixed(2) : '';
                opts2 += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '" ' + sel + '>' + (p.codigo ? p.codigo + ' - ' : '') + p.name + marca + precioTxt + '</option>';
            });
            selProducto.html(opts2).prop('disabled', false);
        }

        // Info del producto
        var prod = productosDB.find(function(p) { return p.id == productoId; });
        if (prod) {
            var marca = prod.marca ? prod.marca.name : '';
            var info = '<i class="bi bi-check-circle text-success me-1"></i><strong>' + prod.name + '</strong>';
            if (marca) info += ' — ' + marca;
            $('#producto-info-' + idx).html(info);
            $('#fila-' + idx).find('.input-precio').val(parseFloat(precio || prod.precio || 0).toFixed(2));
        }

        // Reinicializar Select2 después de cargar opciones
        reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
    }

    // Botón agregar
    $('#btn-agregar-producto').on('click', function() {
        agregarFila();
    });

    // Quitar fila
    window.quitarFila = function(i) {
        $('#fila-' + i).remove();
        calcularTotales();
    };

    // ==================== CASCADA: TIPO → CATEGORÍA ====================
    $(document).on('change', '.sel-tipo', function() {
        var idx = $(this).data('index');
        var tipoId = parseInt($(this).val());
        var selSubcat = $('.sel-subcategoria[data-index="' + idx + '"]');
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
        $('#fila-' + idx).find('.input-producto-id').val('');
        $('#fila-' + idx).find('.input-precio').val(0);
        $('#producto-info-' + idx).html('');

        if (!tipoId) {
            selSubcat.html('<option value="">-- Categoría --</option>').prop('disabled', true);
            reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
            calcularTotales();
            return;
        }

        var tipo = null;
        for (var t = 0; t < tipos.length; t++) {
            if (tipos[t].id === tipoId) { tipo = tipos[t]; break; }
        }

        if (!tipo || !tipo.categories || tipo.categories.length === 0) {
            selSubcat.html('<option value="">Sin categorías</option>').prop('disabled', true);
            reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
            return;
        }

        var opts = '<option value="">-- Categoría --</option>';
        tipo.categories.forEach(function(c) {
            opts += '<option value="' + c.id + '">' + c.name + '</option>';
        });
        selSubcat.html(opts).prop('disabled', false);
        reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
        calcularTotales();
    });

    // ==================== CASCADA: CATEGORÍA → PRODUCTO ====================
    $(document).on('change', '.sel-subcategoria', function() {
        var idx = $(this).data('index');
        var categoriaId = parseInt($(this).val());
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        $('#fila-' + idx).find('.input-producto-id').val('');
        $('#fila-' + idx).find('.input-precio').val(0);
        $('#producto-info-' + idx).html('');

        if (!categoriaId) {
            selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
            reinitSelect2('.sel-producto[data-index="' + idx + '"]');
            calcularTotales();
            return;
        }

        var prods = productosDB.filter(function(p) { return p.categorie_id === categoriaId; });

        if (prods.length === 0) {
            selProducto.html('<option value="">Sin productos</option>').prop('disabled', true);
            reinitSelect2('.sel-producto[data-index="' + idx + '"]');
            return;
        }

        var opts = '<option value="">-- Producto --</option>';
        prods.forEach(function(p) {
            var marca = p.marca ? ' (' + p.marca.name + ')' : '';
            var precio = p.precio ? ' - S/ ' + parseFloat(p.precio).toFixed(2) : '';
            opts += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '">' + (p.codigo ? p.codigo + ' - ' : '') + p.name + marca + precio + '</option>';
        });
        selProducto.html(opts).prop('disabled', false);
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
        calcularTotales();
    });

    // ==================== SELECCIÓN DE PRODUCTO ====================
    $(document).on('change', '.sel-producto', function() {
        var idx = $(this).data('index');
        var fila = $('#fila-' + idx);
        var selected = $(this).find(':selected');
        var productoId = $(this).val();

        if (productoId) {
            fila.find('.input-producto-id').val(productoId);
            fila.find('.input-precio').val(parseFloat(selected.data('precio') || 0).toFixed(2));

            var marca = selected.data('marca');
            var info = '<i class="bi bi-check-circle text-success me-1"></i><strong>' + selected.data('nombre') + '</strong>';
            if (marca) info += ' — ' + marca;
            $('#producto-info-' + idx).html(info);
        } else {
            fila.find('.input-producto-id').val('');
            fila.find('.input-precio').val(0);
            $('#producto-info-' + idx).html('');
        }

        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== IMPORTAR WISHLIST ====================
    function importarWishlist() {
        if (!wishlistData || wishlistData.length === 0) return 0;

        var yaImportados = [];
        $('.input-producto-id').each(function() {
            if ($(this).val()) yaImportados.push(parseInt($(this).val()));
        });

        var nuevos = 0;
        for (var w = 0; w < wishlistData.length; w++) {
            var item = wishlistData[w];
            if (yaImportados.indexOf(item.id) === -1) {
                // Buscar tipo_id y categorie_id del producto en productosDB
                var prod = productosDB.find(function(p) { return p.id === item.id; });
                agregarFila({
                    producto_id: item.id,
                    cantidad: 1,
                    precio: item.precio,
                    tipo_id: prod ? prod.tipo_id : null,
                    categorie_id: prod ? prod.categorie_id : null
                });
                nuevos++;
            }
        }
        return nuevos;
    }

    $('#btn-importar-wishlist').on('click', function() {
        var btn = $(this);
        var nuevos = importarWishlist();
        if (nuevos > 0) {
            btn.html('<i class="bi bi-check-circle me-1"></i>Importados (' + nuevos + ')').removeClass('btn-outline-warning').addClass('btn-success').prop('disabled', true);
        } else {
            btn.html('<i class="bi bi-info-circle me-1"></i>Ya importados').prop('disabled', true);
        }
    });

    // ==================== FETCH WISHLIST VIA AJAX ====================
    function cargarWishlist(prospectoId) {
        $('#tbody-productos').empty();
        calcularTotales();

        $('#banner-wishlist').hide();
        $('#btn-importar-wishlist').html('<i class="bi bi-download me-1"></i>Importar').removeClass('btn-success').addClass('btn-outline-warning').prop('disabled', false);
        wishlistData = [];

        if (!prospectoId) return;

        $.ajax({
            url: wishlistUrl + '/' + prospectoId + '/wishlist',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.count > 0) {
                    wishlistData = response.wishlist;
                    $('#wishlist-count').text(response.count);
                    $('#banner-wishlist').show();

                    var tipo = $('#tipo_oportunidad').val();
                    if (tipo === 'producto' || tipo === 'mixto') {
                        var importados = importarWishlist();
                        if (importados > 0) {
                            $('#btn-importar-wishlist').html('<i class="bi bi-check-circle me-1"></i>Importados (' + importados + ')').removeClass('btn-outline-warning').addClass('btn-success').prop('disabled', true);
                        }
                    }
                }
            },
            error: function(xhr) { console.warn('Error wishlist:', xhr.status); }
        });
    }

    // ==================== AUTO-LLENADO DESDE PROSPECTO ====================
    var segmentoToProyecto = { 'residencial': 'residencial', 'comercial': 'comercial', 'industrial': 'industrial', 'agricola': 'agricola' };
    var interesToTipo = { 'producto': 'producto', 'servicio': 'servicio', 'ambos': 'mixto' };

    $('#prospecto_id').on('change', function() {
        var selected = $(this).find(':selected');
        var prospectoId = $(this).val();

        if (!prospectoId) {
            $('#info_prospecto').hide();
            cargarWishlist(null);
            return;
        }

        $('#info_prospecto').show();
        $('#info_email').text(selected.data('email') || '-');
        $('#info_celular').text(selected.data('celular') || '-');
        var seg = selected.data('segmento') || '-';
        $('#info_segmento').text(seg.charAt(0).toUpperCase() + seg.slice(1));

        var nombreInput = $('#nombre_oportunidad');
        if (!nombreInput.val()) {
            nombreInput.val('Oportunidad - ' + selected.data('nombre'));
        }

        var tipoInteres = selected.data('tipo-interes');
        if (tipoInteres && interesToTipo[tipoInteres]) {
            $('#tipo_oportunidad').val(interesToTipo[tipoInteres]).trigger('change');
        }

        var segmento = selected.data('segmento');
        if (segmento && segmentoToProyecto[segmento]) {
            $('#tipo_proyecto').val(segmentoToProyecto[segmento]).trigger('change');
        }

        var userId = selected.data('user-id');
        if (userId) { $('#user_id').val(userId).trigger('change'); }

        cargarWishlist(prospectoId);
    });

    if ($('#prospecto_id').val()) {
        $('#prospecto_id').trigger('change');
    }
});
</script>
@endsection
