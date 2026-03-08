@extends('TEMPLATES.administrador')
@section('title', 'Editar Oportunidad')

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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR OPORTUNIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.oportunidades.index') }}">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $oportunidad->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin.crm.oportunidades.update', $oportunidad) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="redirect_to" value="{{ request('redirect_to', 'show') }}">

            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <span class="badge bg-secondary fs-6">{{ $oportunidad->codigo }}</span>
                    @php
                        $etapaColors = [
                            'calificacion' => 'primary', 'evaluacion' => 'info',
                            'cotizacion' => 'warning', 'negociacion' => 'secondary',
                            'ganada' => 'success', 'perdida' => 'danger'
                        ];
                    @endphp
                    <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }}">
                        {{ \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa) }}
                    </span>
                </div>
                <div class="card-body">

                    {{-- Info --}}
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">
                                Editando oportunidad <span class="badge bg-secondary">{{ $oportunidad->codigo }}</span>
                                — Prospecto: <strong>{{ $oportunidad->prospecto->nombre_completo ?? 'N/A' }}</strong>
                                — Los campos con <span class="text-danger">*</span> son obligatorios.
                            </small>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- INFORMACIÓN GENERAL --}}
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $oportunidad->nombre) }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 @error('tipo_proyecto') is-invalid @enderror" name="tipo_proyecto" required>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Oportunidad <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 @error('tipo_oportunidad') is-invalid @enderror" name="tipo_oportunidad" id="tipo_oportunidad" required>
                                <option value="producto" {{ old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'producto' ? 'selected' : '' }}>Producto</option>
                                <option value="servicio" {{ old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                <option value="mixto" {{ old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'mixto' ? 'selected' : '' }}>Mixto</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="prospecto_id" data-placeholder="Seleccionar prospecto...">
                                <option value="">Ninguno</option>
                                @foreach($prospectos ?? [] as $prospecto)
                                    <option value="{{ $prospecto->id }}" {{ old('prospecto_id', $oportunidad->prospecto_id) == $prospecto->id ? 'selected' : '' }}>
                                        {{ $prospecto->codigo }} - {{ $prospecto->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            @if($oportunidad->cliente)
                                <div class="form-control form-control-sm bg-light">
                                    <i class="bi bi-person-check text-success me-1"></i>{{ $oportunidad->cliente->codigo }} - {{ $oportunidad->cliente->nombre }}
                                </div>
                            @else
                                <div class="form-control form-control-sm bg-light text-muted">Sin cliente asignado</div>
                            @endif
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se asigna al marcar ganada</small>
                        </div>

                        {{-- DETALLE SERVICIO (servicio/mixto) --}}
                        <div id="seccion_servicio" class="col-12" style="display: none;">
                            <div class="row g-3">
                                <div class="col-12 mt-4"><h6 class="text-success border-bottom pb-2"><i class="bi bi-wrench me-2"></i>Detalle del Servicio</h6></div>

                                {{-- Select único de servicio --}}
                                <div class="col-md-6">
                                    <label class="form-label">Servicio</label>
                                    <select class="form-select form-select-sm select2_bootstrap w-100"
                                            id="sel_servicio_especifico"
                                            name="servicio_id"
                                            data-placeholder="Seleccionar servicio...">
                                        <option value="">Seleccionar servicio...</option>
                                        @foreach($servicios as $s)
                                            <option value="{{ $s->id }}"
                                                    data-desc="{{ $s->descripcion }}"
                                                    data-tipo="{{ $s->tipo_servicio }}"
                                                    {{ old('servicio_id', $oportunidad->servicio_id) == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                                ({{ $s->tipo_servicio === 'publico' ? 'Público' : 'Privado' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Descripción --}}
                                <div class="col-12" id="wrap_descripcion_servicio">
                                    <label class="form-label">Descripción del Servicio</label>
                                    <textarea class="form-control form-control-sm" id="textarea_descripcion_servicio" name="descripcion_servicio" rows="2"
                                              placeholder="Se autocompletará al seleccionar el servicio...">{{ old('descripcion_servicio', $oportunidad->descripcion_servicio) }}</textarea>
                                    <small class="text-muted"><i class="bi bi-pencil me-1"></i>Puedes editar la descripción si es necesario.</small>
                                </div>
                            </div>
                        </div>

                        {{-- VISITA TÉCNICA (solo servicio/mixto) --}}
                        <div id="seccion_visita" class="col-12 mt-4" style="display: none;">
                            <h6 class="text-primary border-bottom pb-2"><i class="bi bi-geo-alt me-2"></i>Visita Técnica</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="requiere_visita_tecnica" id="requiere_visita" value="1"
                                               {{ old('requiere_visita_tecnica', $oportunidad->requiere_visita_tecnica) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requiere_visita">¿Requiere visita técnica?</label>
                                    </div>
                                </div>
                            </div>
                            <div id="campos_visita" class="row g-3 mt-1" style="{{ old('requiere_visita_tecnica', $oportunidad->requiere_visita_tecnica) ? '' : 'display:none;' }}">
                                <div class="col-md-4">
                                    <label class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control form-control-sm" name="fecha_visita_programada"
                                           value="{{ old('fecha_visita_programada', $oportunidad->fecha_visita_programada?->format('Y-m-d\TH:i')) }}"
                                           id="fecha_visita_programada">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Ubicación / Dirección <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="ubicacion_visita"
                                           value="{{ old('ubicacion_visita', $oportunidad->ubicacion_visita) }}"
                                           placeholder="Ej: Av. Los Incas 456, Surco, Lima" id="ubicacion_visita">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Técnico Asignado <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm select2_bootstrap w-100" name="tecnico_visita_id"
                                            id="tecnico_visita_id" data-placeholder="Seleccionar técnico...">
                                        <option value="">Seleccionar técnico...</option>
                                        @foreach($vendedores ?? [] as $v)
                                            <option value="{{ $v->id }}"
                                                {{ old('tecnico_visita_id', $oportunidad->tecnico_visita_id) == $v->id ? 'selected' : '' }}>
                                                {{ $v->persona?->name ?? $v->email }} {{ $v->persona?->surnames ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Resultado visita (readonly, se llena desde la actividad) --}}
                        @if($oportunidad->resultado_visita)
                        <div class="col-12">
                            <div class="alert alert-success py-2 mb-0">
                                <small class="fw-bold"><i class="bi bi-clipboard-check me-1"></i>Resultado de Visita Técnica:</small>
                                <p class="mb-0 small mt-1">{{ $oportunidad->resultado_visita }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- PIPELINE --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Pipeline y Valores</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Etapa</label>
                            @php $etapaInfo = \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa] ?? ['nombre' => ucfirst($oportunidad->etapa), 'color' => 'secondary']; @endphp
                            <div class="form-control form-control-sm bg-light">
                                <span class="badge bg-{{ $etapaInfo['color'] }}">{{ $etapaInfo['nombre'] }}</span>
                            </div>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se gestiona desde el detalle</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control form-control-sm" name="monto_estimado" id="monto_estimado" value="{{ old('monto_estimado', $oportunidad->monto_estimado) }}" step="0.01" required>
                            </div>
                            <small class="text-muted" id="monto-auto-msg" style="display: none;"><i class="bi bi-calculator me-1"></i>Calculado desde productos</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Final (S/)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control form-control-sm bg-light" value="{{ $oportunidad->monto_final }}" step="0.01" readonly>
                            </div>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se define al marcar ganada</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Probabilidad (%)</label>
                            <input type="number" class="form-control form-control-sm bg-light" value="{{ $oportunidad->probabilidad }}" readonly>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se ajusta con la etapa</small>
                        </div>

                        {{-- FECHAS --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Cierre Estimada</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_cierre_estimada" value="{{ old('fecha_cierre_estimada', $oportunidad->fecha_cierre_estimada?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Cierre Real</label>
                            <input type="date" class="form-control form-control-sm bg-light" value="{{ $oportunidad->fecha_cierre_real?->format('Y-m-d') }}" readonly>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se define al marcar ganada</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Seleccionar vendedor...">
                                <option value="">Sin asignar</option>
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id', $oportunidad->user_id) == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona->name ?? $vendedor->email }} {{ $vendedor->persona->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DESCRIPCIÓN Y NOTAS --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-card-text me-2"></i>Descripción y Notas</h6></div>

                        <div class="col-12">
                            <label class="form-label">Descripción del negocio</label>
                            <textarea class="form-control form-control-sm" name="descripcion" rows="3">{{ old('descripcion', $oportunidad->descripcion) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones internas</label>
                            <textarea class="form-control form-control-sm" name="observaciones" rows="2">{{ old('observaciones', $oportunidad->observaciones) }}</textarea>
                        </div>

                        {{-- PRODUCTOS DE INTERÉS --}}
                        <div id="seccion_productos" class="col-12 mt-3" style="display: none;">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold"><i class="bi bi-box-seam me-1"></i>Productos de Interés</p>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered tabla-items mb-0" id="tablaProductos">
                                    <colgroup>
                                        <col style="width:40%">
                                        <col style="width:7%">
                                        <col style="width:16%">
                                        <col style="width:13%">
                                        <col style="width:19%">
                                        <col style="width:40px">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Ítem</th>
                                            <th>Cant.</th>
                                            <th>P. Unit.</th>
                                            <th>Subtotal</th>
                                            <th>Notas</th>
                                            <th style="width:40px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-productos"></tbody>
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
                                <p class="mb-0 mt-2">No hay productos. Haga clic en <strong>"Agregar Producto"</strong> para comenzar.</p>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btn-agregar-producto">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Producto
                            </button>
                        </div>

                        @if($oportunidad->etapa === 'perdida')
                        {{-- MOTIVO DE PÉRDIDA (solo lectura) --}}
                        <div class="col-12 mt-4"><h6 class="text-danger border-bottom pb-2"><i class="bi bi-x-circle me-2"></i>Motivo de Pérdida</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Motivo</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $oportunidad->motivo_perdida }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Competidor Ganador</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $oportunidad->competidor_ganador }}" readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Detalle de Pérdida</label>
                            <textarea class="form-control form-control-sm bg-light" rows="2" readonly>{{ $oportunidad->detalle_perdida }}</textarea>
                        </div>
                        <small class="text-muted"><i class="bi bi-lock me-1"></i>Estos datos se registran al marcar como perdida desde el detalle</small>
                        @endif
                    </div>
                </div>
            </div>

            @php
                $redirectTo = request('redirect_to', 'show');
                $cancelUrl = $redirectTo === 'index'
                    ? route('admin.crm.oportunidades.index')
                    : route('admin.crm.oportunidades.show', $oportunidad);
            @endphp

            {{-- Botones --}}
            <div class="pt-3 pb-5 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i>
                    Creado: {{ $oportunidad->created_at->format('d/m/Y H:i') }} | Actualizado: {{ $oportunidad->updated_at->format('d/m/Y H:i') }}
                </small>
                <div class="d-flex gap-2">
                    <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5 text-white">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('js')
<script>
$(document).ready(function() {

    // ==================== DATOS DEL SERVIDOR ====================
    const tipos = @json($tipos);
    const productosDB = @json($productos);
    const serviciosDB = @json($servicios);   // lista plana de servicios
    var productosExistentes = @json($productosExistentesJson);
    var contadorItems = 0;

    // ==================== SERVICIO (select único) ====================
    $('#sel_servicio_especifico').on('change', function() {
        var val  = $(this).val();
        var desc = $(this).find(':selected').data('desc') || '';
        if (val) {
            var oldDesc = $('#textarea_descripcion_servicio').val();
            if (!oldDesc) $('#textarea_descripcion_servicio').val(desc);
        }
    });

    // Al cargar: si hay servicio guardado y no hay descripción previa, autocompletar
    (function() {
        if ($('#sel_servicio_especifico').val()) {
            var desc = $('#sel_servicio_especifico').find(':selected').data('desc') || '';
            if (!$('#textarea_descripcion_servicio').val()) {
                $('#textarea_descripcion_servicio').val(desc);
            }
        }
    })();

    // ==================== TOGGLE SECCIONES ====================
    $('#tipo_oportunidad').on('change', function() {
        var valor = $(this).val();
        var esServicio = valor === 'servicio' || valor === 'mixto';
        $('#seccion_servicio').toggle(esServicio);
        $('#seccion_productos').toggle(valor === 'producto' || valor === 'mixto');
        $('#seccion_visita').toggle(esServicio);
        if (!esServicio) {
            $('#requiere_visita').prop('checked', false).trigger('change');
        }
    }).trigger('change');

    // Toggle campos visita técnica
    $('#requiere_visita').on('change', function() {
        $('#campos_visita').toggle($(this).is(':checked'));
    });

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

    // ==================== SELECT2 HELPERS ====================
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

    // ==================== AGREGAR FILA ====================
    function agregarFila(datos) {
        datos = datos || {};
        var i = contadorItems++;
        $('#sinItems').hide();
        $('#tfoot-totales').show();

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
            '';

        var fila = '<tr id="fila-' + i + '" class="item-fila">' +
            '<td>' + celdaProducto + '</td>' +
            '<td><input type="number" name="items[' + i + '][cantidad]" class="form-control form-control-sm input-cantidad" value="' + (datos.cantidad || 1) + '" step="0.01" min="0.01" required></td>' +
            '<td><div class="input-group input-group-sm"><span class="input-group-text" style="font-size:0.7rem;">S/</span><input type="number" name="items[' + i + '][precio_unitario]" class="form-control form-control-sm input-precio" value="' + (datos.precio || 0) + '" step="0.01" min="0"></div><div class="producto-info input-precio-original" id="precio-original-' + i + '" style="display:none;"></div></td>' +
            '<td class="item-subtotal text-end pt-2" id="subtotal-' + i + '">S/ 0.00</td>' +
            '<td><input type="text" name="items[' + i + '][notas]" class="form-control form-control-sm" value="' + (datos.notas || '') + '" placeholder="Notas..."></td>' +
            '<td class="text-center pt-2"><button type="button" class="btn btn-outline-danger btn-quitar" onclick="quitarFila(' + i + ')"><i class="bi bi-trash"></i></button></td>' +
        '</tr>';

        $('#tbody-productos').append(fila);
        initSelect2Fila(i);

        if (datos.producto_id) {
            cargarCascadaCompleta(i, datos.tipo_id, datos.categorie_id, datos.producto_id, datos.precio);
        }

        calcularSubtotalFila(i);
        calcularTotales();
    }

    // ==================== CASCADA COMPLETA (PRE-CARGA) ====================
    function cargarCascadaCompleta(idx, tipoId, categorieId, productoId, precio) {
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

        var prods = productosDB.filter(function(p) { return p.categorie_id == categorieId; });
        if (prods.length > 0) {
            var opts2 = '<option value="">-- Producto --</option>';
            prods.forEach(function(p) {
                var sel = (p.id == productoId) ? 'selected' : '';
                var marca = p.marca ? ' (' + p.marca.name + ')' : '';
                opts2 += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '" ' + sel + '>' + (p.codigo ? p.codigo + ' — ' : '') + p.name + marca + '</option>';
            });
            selProducto.html(opts2).prop('disabled', false);
        }

        var prod = productosDB.find(function(p) { return p.id == productoId; });
        if (prod) {
            var marca = prod.marca ? prod.marca.name : '';
            var info = '<i class="bi bi-check-circle text-success me-1"></i><strong>' + prod.name + '</strong>';
            if (marca) info += ' — ' + marca;
            var precioOrig = parseFloat(precio || prod.precio || 0);
            $('#fila-' + idx).find('.input-precio').val(precioOrig.toFixed(2));
            var hint = $('#precio-original-' + idx);
            if (precioOrig > 0) {
                hint.html('<i class="bi bi-tag me-1"></i>Precio original: S/ ' + precioOrig.toFixed(2)).show();
            } else {
                hint.hide();
            }
        }

        reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
    }

    // Botones
    $('#btn-agregar-producto').on('click', function() { agregarFila(); });
    window.quitarFila = function(i) { $('#fila-' + i).remove(); calcularTotales(); };

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
        $('#precio-original-' + idx).hide();

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
        $('#precio-original-' + idx).hide();

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
            opts += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '">' + (p.codigo ? p.codigo + ' — ' : '') + p.name + marca + '</option>';
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
            var precioOriginal = parseFloat(selected.data('precio') || 0);
            fila.find('.input-precio').val(precioOriginal.toFixed(2));
            var hint = $('#precio-original-' + idx);
            if (precioOriginal > 0) {
                hint.html('<i class="bi bi-tag me-1"></i>Precio original: S/ ' + precioOriginal.toFixed(2)).show();
            } else {
                hint.hide();
            }
        } else {
            fila.find('.input-producto-id').val('');
            fila.find('.input-precio').val(0);
            $('#precio-original-' + idx).hide();
        }

        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== PRE-CARGAR PRODUCTOS ====================
    // Si hubo error de validación → restaurar old('items') en lugar de los datos de BD
    // Si no hubo error → cargar los productos guardados normalmente
    @if(old('items'))
        var itemsOld = @json(old('items'));
        $.each(itemsOld, function(idx, item) {
            if (!item.producto_id) return; // omitir filas incompletas
            var prod = productosDB.find(function(p) { return p.id == item.producto_id; });
            if (!prod) return;
            agregarFila({
                producto_id:  parseInt(item.producto_id),
                cantidad:     parseFloat(item.cantidad) || 1,
                precio:       parseFloat(item.precio_unitario) || parseFloat(prod.precio) || 0,
                notas:        item.notas || '',
                tipo_id:      prod.tipo_id || null,
                categorie_id: prod.categorie_id || null,
            });
        });
    @else
        for (var j = 0; j < productosExistentes.length; j++) {
            agregarFila(productosExistentes[j]);
        }
    @endif
});
</script>
@endsection
