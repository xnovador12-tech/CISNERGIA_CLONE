@extends('TEMPLATES.administrador')

@section('title', 'Editar Prospecto')

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.prospectos.index') }}">Prospectos</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.prospectos.show', $prospecto) }}">{{ $prospecto->codigo }}</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $redirectTo = request('redirect_to', 'show');
        $cancelUrl  = $redirectTo === 'index'
            ? route('admin.crm.prospectos.index')
            : route('admin.crm.prospectos.show', $prospecto);

        // Datos del ubigeo actual para pre-cargar los selects
        $distritoActual    = $prospecto->distrito;
        $provinciaActual   = $distritoActual?->provincia;
        $departamentoActual = $provinciaActual?->departamento;
    @endphp

    <form action="{{ route('admin.crm.prospectos.update', $prospecto) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-body">

                    {{-- Info --}}
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Editando prospecto <strong>{{ $prospecto->codigo }}</strong> — {{ $prospecto->nombre_completo }}</small>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- ===================== INFORMACIÓN GENERAL ===================== --}}
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información General</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_persona" id="tipo_persona" required data-placeholder="Seleccionar...">
                                <option value="natural" {{ old('tipo_persona', $prospecto->tipo_persona) == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="juridica" {{ old('tipo_persona', $prospecto->tipo_persona) == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-2" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control form-control-sm" name="dni" maxlength="8" value="{{ old('dni', $prospecto->dni) }}" placeholder="12345678">
                        </div>

                        <div class="col-md-2" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control form-control-sm" name="ruc" maxlength="11" value="{{ old('ruc', $prospecto->ruc) }}" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $prospecto->nombre) }}" required placeholder="Nombre o razón comercial">
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" value="{{ old('apellidos', $prospecto->apellidos) }}" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control form-control-sm" name="razon_social" value="{{ old('razon_social', $prospecto->razon_social) }}" placeholder="Razón social de la empresa">
                        </div>

                        {{-- ===================== DATOS DE CONTACTO ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de Contacto</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $prospecto->email) }}" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control form-control-sm" name="celular" value="{{ old('celular', $prospecto->celular) }}" placeholder="987654321">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" name="telefono" value="{{ old('telefono', $prospecto->telefono) }}" placeholder="01-1234567">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" value="{{ old('direccion', $prospecto->direccion) }}" placeholder="Av. Principal 123">
                        </div>

                        {{-- === UBIGEO CASCADING: DEPARTAMENTO → PROVINCIA → DISTRITO === --}}
                        <div class="col-md-4">
                            <label class="form-label">Departamento</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100"
                                    id="select_departamento" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach($departamentos as $dep)
                                    <option value="{{ $dep->id }}"
                                        {{ $departamentoActual?->id == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Provincia</label>
                            <select class="form-select form-select-sm w-100"
                                    id="select_provincia"
                                    data-placeholder="Seleccione un departamento"
                                    {{ $provinciaActual ? '' : 'disabled' }}>
                                <option value="">Seleccionar...</option>
                                @if($provinciaActual)
                                    {{-- Pre-cargar provincias del departamento actual --}}
                                    @foreach($departamentoActual->provincias()->orderBy('nombre')->get() as $prov)
                                        <option value="{{ $prov->id }}"
                                            {{ $provinciaActual->id == $prov->id ? 'selected' : '' }}>
                                            {{ $prov->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select form-select-sm w-100"
                                    name="distrito_id" id="select_distrito"
                                    data-placeholder="Seleccione una provincia"
                                    {{ $distritoActual ? '' : 'disabled' }}>
                                <option value="">Seleccionar...</option>
                                @if($distritoActual)
                                    {{-- Pre-cargar distritos de la provincia actual --}}
                                    @foreach($provinciaActual->distritos()->orderBy('nombre')->get() as $dist)
                                        <option value="{{ $dist->id }}"
                                            {{ old('distrito_id', $distritoActual->id) == $dist->id ? 'selected' : '' }}>
                                            {{ $dist->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- ===================== CLASIFICACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Clasificación</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="estado" id="estado" required data-placeholder="Seleccionar...">
                                @foreach([
                                    'nuevo'      => 'Nuevo',
                                    'contactado' => 'Contactado',
                                    'calificado' => 'Calificado',
                                    'descartado' => 'Descartado',
                                    {{-- 'convertido' se asigna automáticamente al aprobar una cotización --}}
                                ] as $key => $label)
                                    <option value="{{ $key }}" {{ old('estado', $prospecto->estado) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                                @if($prospecto->estado === 'convertido')
                                    <option value="convertido" selected disabled>Convertido (solo lectura)</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            @if($prospecto->origen === 'ecommerce')
                                {{-- Origen automático del ecommerce: no editable.
                                     Se muestra un select deshabilitado (no se puede cambiar) y
                                     un input hidden que SÍ envía el valor al backend.
                                     NOTA: un <option disabled selected> NO envía valor al
                                     submit — por eso usamos este patrón con input hidden. --}}
                                <select class="form-select form-select-sm select2_bootstrap w-100" disabled data-placeholder="E-commerce (automático)">
                                    <option value="ecommerce" selected>E-commerce (automático)</option>
                                </select>
                                <input type="hidden" name="origen" value="ecommerce">
                            @else
                                <select class="form-select form-select-sm select2_bootstrap w-100" name="origen" required data-placeholder="Seleccionar...">
                                    <option value="">Seleccionar...</option>
                                    @foreach(['sitio_web' => 'Sitio Web', 'redes_sociales' => 'Redes Sociales', 'llamada' => 'Llamada', 'referido' => 'Referido', 'otro' => 'Otro'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('origen', $prospecto->origen) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Interés <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_interes" required data-placeholder="Seleccionar...">
                                <option value="producto" {{ old('tipo_interes', $prospecto->tipo_interes) == 'producto' ? 'selected' : '' }}>Producto</option>
                                <option value="servicio" {{ old('tipo_interes', $prospecto->tipo_interes) == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                <option value="ambos" {{ old('tipo_interes', $prospecto->tipo_interes) == 'ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="segmento" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('segmento', $prospecto->segmento) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== SEGUIMIENTO ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Seguimiento</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="nivel_interes" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                @foreach(['bajo' => 'Bajo', 'medio' => 'Medio', 'alto' => 'Alto', 'muy_alto' => 'Muy Alto'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('nivel_interes', $prospecto->nivel_interes) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="urgencia" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                @foreach(['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo', 'mediano_plazo' => 'Mediano Plazo', 'largo_plazo' => 'Largo Plazo'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('urgencia', $prospecto->urgencia) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Próximo Contacto</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_proximo_contacto"
                                   value="{{ old('fecha_proximo_contacto', $prospecto->fecha_proximo_contacto?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a</label>
                            @if($esAdmin ?? false)
                                {{-- Admin puede reasignar el prospecto a otro vendedor --}}
                                <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Sin asignar">
                                    <option value="">Sin asignar</option>
                                    @foreach($vendedores ?? [] as $vendedor)
                                        <option value="{{ $vendedor->id }}" {{ old('user_id', $prospecto->user_id) == $vendedor->id ? 'selected' : '' }}>
                                            {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{-- No-admin: readonly. El update() del controller preserva user_id original. --}}
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="{{ $prospecto->vendedor?->persona?->name ?? $prospecto->vendedor?->email ?? 'Sin asignar' }} {{ $prospecto->vendedor?->persona?->surnames ?? '' }}"
                                       readonly
                                       style="background-color: #f8f9fa; cursor: not-allowed;">
                                <small class="text-muted">Solo Gerencia/Administrador puede reasignar.</small>
                            @endif
                        </div>

                        {{-- Motivo de descarte (visible solo si estado = descartado) --}}
                        <div class="col-12" id="campo_motivo_descarte" style="display: none;">
                            <label class="form-label">Motivo de Descarte</label>
                            <textarea class="form-control form-control-sm" name="motivo_descarte" rows="2" placeholder="Explique por qué se descartó este prospecto...">{{ old('motivo_descarte', $prospecto->motivo_descarte) }}</textarea>
                        </div>

                        {{-- ===================== OBSERVACIONES ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Observaciones</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto...">{{ old('observaciones', $prospecto->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ===== TOGGLE PERSONA NATURAL / JURÍDICA =====
    $('#tipo_persona').on('change', function() {
        var esJuridica = $(this).val() === 'juridica';
        $('#campo_apellidos').toggle(!esJuridica);
        $('#campo_razon_social').toggle(esJuridica);
        $('#campo_dni').toggle(!esJuridica);
        $('#campo_ruc').toggle(esJuridica);
    }).trigger('change');

    // ===== TOGGLE MOTIVO DE DESCARTE =====
    $('#estado').on('change', function() {
        $('#campo_motivo_descarte').toggle($(this).val() === 'descartado');
    }).trigger('change');

    // ===== UBIGEO CASCADING =====
    var urlProvincias = '{{ route("ajax.provincias") }}';
    var urlDistritos  = '{{ route("ajax.distritos") }}';

    function destroySelect2(selector) {
        if ($(selector).hasClass('select2-hidden-accessible')) {
            $(selector).select2('destroy');
        }
    }

    function initSelect2(selector, placeholder) {
        $(selector).select2({ theme: 'bootstrap-5', placeholder: placeholder, width: '100%' });
    }

    function resetSelect(selector, msg) {
        destroySelect2(selector);
        $(selector).empty()
                   .append('<option value="">' + msg + '</option>')
                   .prop('disabled', true);
    }

    // Inicializar Select2 en los selects que ya tienen opciones pre-cargadas (edit)
    @if($provinciaActual)
        initSelect2('#select_provincia', 'Seleccionar provincia...');
    @endif
    @if($distritoActual)
        initSelect2('#select_distrito', 'Seleccionar distrito...');
    @endif

    // Al cambiar Departamento → cargar Provincias
    $(document).on('change', '#select_departamento', function() {
        var depId = $(this).val();

        resetSelect('#select_provincia', 'Seleccione un departamento');
        resetSelect('#select_distrito',  'Seleccione una provincia');

        if (!depId) return;

        $.getJSON(urlProvincias, { departamento_id: depId })
            .done(function(data) {
                destroySelect2('#select_provincia');
                var $prov = $('#select_provincia').empty()
                    .append('<option value="">Seleccionar...</option>');
                $.each(data, function(i, p) {
                    $prov.append('<option value="' + p.id + '">' + p.nombre + '</option>');
                });
                $prov.prop('disabled', false);
                initSelect2('#select_provincia', 'Seleccionar provincia...');
            })
            .fail(function() {
                alert('Error al cargar provincias. Intente nuevamente.');
            });
    });

    // Al cambiar Provincia → cargar Distritos (delegado en document)
    $(document).on('change', '#select_provincia', function() {
        var provId = $(this).val();

        resetSelect('#select_distrito', 'Seleccione una provincia');

        if (!provId) return;

        $.getJSON(urlDistritos, { provincia_id: provId })
            .done(function(data) {
                destroySelect2('#select_distrito');
                var $dist = $('#select_distrito').empty()
                    .append('<option value="">Seleccionar...</option>');
                $.each(data, function(i, d) {
                    $dist.append('<option value="' + d.id + '">' + d.nombre + '</option>');
                });
                $dist.prop('disabled', false);
                initSelect2('#select_distrito', 'Seleccionar distrito...');
            })
            .fail(function() {
                alert('Error al cargar distritos. Intente nuevamente.');
            });
    });

});
</script>
@endsection
