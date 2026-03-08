@extends('TEMPLATES.administrador')
@section('title', 'Editar Actividad')

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR ACTIVIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.actividades.index') }}">Actividades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.crm.actividades.update', $actividad) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-body">

                    {{-- Info --}}
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">
                                Editando actividad <span class="badge bg-secondary">{{ $actividad->codigo }}</span>
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
                        {{-- ===================== INFORMACIÓN DE LA ACTIVIDAD ===================== --}}
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información de la Actividad</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Actividad <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <option value="llamada" {{ old('tipo', $actividad->tipo) == 'llamada' ? 'selected' : '' }}>📞 Llamada</option>
                                <option value="email" {{ old('tipo', $actividad->tipo) == 'email' ? 'selected' : '' }}>📧 Email</option>
                                <option value="reunion" {{ old('tipo', $actividad->tipo) == 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                                <option value="visita_tecnica" {{ old('tipo', $actividad->tipo) == 'visita_tecnica' ? 'selected' : '' }}>🏗️ Visita Técnica</option>
                                <option value="whatsapp" {{ old('tipo', $actividad->tipo) == 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="estado" required data-placeholder="Seleccionar...">
                                <option value="programada" {{ old('estado', $actividad->estado) == 'programada' ? 'selected' : '' }}>Programada</option>
                                <option value="completada" {{ old('estado', $actividad->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ old('estado', $actividad->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="reprogramada" {{ old('estado', $actividad->estado) == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
                                <option value="no_realizada" {{ old('estado', $actividad->estado) == 'no_realizada' ? 'selected' : '' }}>No Realizada</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Prioridad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="prioridad" data-placeholder="Seleccionar...">
                                <option value="baja" {{ old('prioridad', $actividad->prioridad) == 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                                <option value="media" {{ old('prioridad', $actividad->prioridad) == 'media' ? 'selected' : '' }}>🟡 Media</option>
                                <option value="alta" {{ old('prioridad', $actividad->prioridad) == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" required data-placeholder="Seleccionar responsable...">
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id', $actividad->user_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->persona?->name ?? $usuario->email }} {{ $usuario->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo', $actividad->titulo) }}" required placeholder="Ej: Reunión de presentación de propuesta">
                            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- ===================== PROGRAMACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Programación</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control form-control-sm @error('fecha_programada') is-invalid @enderror" name="fecha_programada" value="{{ old('fecha_programada', $actividad->fecha_programada->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_programada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Recordatorio</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="recordatorio_minutos" data-placeholder="Sin recordatorio">
                                <option value="">Sin recordatorio</option>
                                <option value="15" {{ old('recordatorio_minutos', $actividad->recordatorio_minutos_antes) == '15' ? 'selected' : '' }}>15 minutos antes</option>
                                <option value="30" {{ old('recordatorio_minutos', $actividad->recordatorio_minutos_antes) == '30' ? 'selected' : '' }}>30 minutos antes</option>
                                <option value="60" {{ old('recordatorio_minutos', $actividad->recordatorio_minutos_antes) == '60' ? 'selected' : '' }}>1 hora antes</option>
                                <option value="1440" {{ old('recordatorio_minutos', $actividad->recordatorio_minutos_antes) == '1440' ? 'selected' : '' }}>1 día antes</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Ubicación</label>
                            <input type="text" class="form-control form-control-sm" name="ubicacion" value="{{ old('ubicacion', $actividad->ubicacion) }}" placeholder="Ej: Oficina principal, Google Meet, etc.">
                        </div>

                        {{-- ===================== RELACIÓN CON ENTIDAD ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Relacionar con Entidad (opcional)</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo de Entidad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="activable_type" id="activable_type" data-placeholder="Ninguna">
                                <option value="">Ninguna</option>
                                <option value="App\Models\Prospecto" {{ old('activable_type', $actividad->actividadable_type) == 'App\Models\Prospecto' ? 'selected' : '' }}>Prospecto</option>
                                <option value="App\Models\Oportunidad" {{ old('activable_type', $actividad->actividadable_type) == 'App\Models\Oportunidad' ? 'selected' : '' }}>Oportunidad</option>
                                <option value="App\Models\Cliente" {{ old('activable_type', $actividad->actividadable_type) == 'App\Models\Cliente' ? 'selected' : '' }}>Cliente</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Entidad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="activable_id" id="activable_id" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                            </select>
                        </div>

                        {{-- ===================== DESCRIPCIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Descripción</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="descripcion" rows="3" placeholder="Detalles adicionales de la actividad...">{{ old('descripcion', $actividad->descripcion) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.crm.actividades.show', $actividad) }}" class="btn btn-outline-secondary px-4">
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
    const prospectos    = @json($prospectos);
    const oportunidades = @json($oportunidades);
    const clientes      = @json($clientes);
    const entidadIdInicial = "{{ old('activable_id', $actividad->actividadable_id ?? '') }}";

    // Cambiar opciones según tipo de entidad
    $('#activable_type').on('change', function() {
        const tipo = $(this).val();
        const selectEntidad = $('#activable_id');

        // Destruir select2 antes de modificar opciones
        if (selectEntidad.hasClass('select2-hidden-accessible')) {
            selectEntidad.select2('destroy');
        }

        selectEntidad.empty().append('<option value="">Seleccionar...</option>');

        if (tipo === 'App\\Models\\Prospecto') {
            prospectos.forEach(p => {
                selectEntidad.append(`<option value="${p.id}">${p.nombre} ${p.apellidos ?? ''}</option>`);
            });
        } else if (tipo === 'App\\Models\\Oportunidad') {
            oportunidades.forEach(o => {
                const nombre = o.prospecto ? o.prospecto.nombre : 'Sin nombre';
                selectEntidad.append(`<option value="${o.id}">${o.codigo} - ${nombre}</option>`);
            });
        } else if (tipo === 'App\\Models\\Cliente') {
            clientes.forEach(c => {
                const nombre = c.razon_social ?? `${c.nombre} ${c.apellidos ?? ''}`.trim();
                selectEntidad.append(`<option value="${c.id}">${nombre}</option>`);
            });
        }

        if (entidadIdInicial && selectEntidad.find(`option[value="${entidadIdInicial}"]`).length) {
            selectEntidad.val(entidadIdInicial);
        }

        // Reinicializar select2
        selectEntidad.select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Seleccionar...',
            allowClear: true
        });
    });

    // Cargar inicial si hay tipo seleccionado
    if ($('#activable_type').val()) {
        $('#activable_type').trigger('change');
    }
});
</script>
@endsection
