@extends('TEMPLATES.administrador')
@section('title', 'Nueva Actividad')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA ACTIVIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.actividades.index') }}">Actividades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                <form action="{{ route('admin.crm.actividades.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        {{-- Tipo de Actividad --}}
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccionar...</option>
                                <option value="llamada" {{ old('tipo') == 'llamada' ? 'selected' : '' }}>📞 Llamada</option>
                                <option value="email" {{ old('tipo') == 'email' ? 'selected' : '' }}>📧 Email</option>
                                <option value="reunion" {{ old('tipo') == 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                                <option value="visita_tecnica" {{ old('tipo') == 'visita_tecnica' ? 'selected' : '' }}>🏗️ Visita Técnica</option>
                                <option value="videollamada" {{ old('tipo') == 'videollamada' ? 'selected' : '' }}>🎥 Videollamada</option>
                                <option value="whatsapp" {{ old('tipo') == 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                                <option value="tarea" {{ old('tipo') == 'tarea' ? 'selected' : '' }}>✅ Tarea</option>
                                <option value="nota" {{ old('tipo') == 'nota' ? 'selected' : '' }}>📝 Nota</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="programada" {{ old('estado', 'programada') == 'programada' ? 'selected' : '' }}>Programada</option>
                                <option value="en_progreso" {{ old('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="reprogramada" {{ old('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
                                <option value="no_realizada" {{ old('estado') == 'no_realizada' ? 'selected' : '' }}>No Realizada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Título --}}
                        <div class="col-md-12">
                            <label for="titulo" class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo') }}" placeholder="Ej: Reunión de presentación de propuesta" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" 
                                      placeholder="Detalles adicionales de la actividad">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha Programada --}}
                        <div class="col-md-6">
                            <label for="fecha_programada" class="form-label fw-bold">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="fecha_programada" id="fecha_programada" 
                                   class="form-control @error('fecha_programada') is-invalid @enderror" 
                                   value="{{ old('fecha_programada') }}" required>
                            @error('fecha_programada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Duración --}}
                        <div class="col-md-6">
                            <label for="duracion_minutos" class="form-label fw-bold">Duración (minutos)</label>
                            <input type="number" name="duracion_minutos" id="duracion_minutos" 
                                   class="form-control @error('duracion_minutos') is-invalid @enderror" 
                                   value="{{ old('duracion_minutos', 30) }}" min="0">
                            @error('duracion_minutos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Prioridad --}}
                        <div class="col-md-6">
                            <label for="prioridad" class="form-label fw-bold">Prioridad</label>
                            <select name="prioridad" id="prioridad" class="form-select @error('prioridad') is-invalid @enderror">
                                <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                                <option value="media" {{ old('prioridad', 'media') == 'media' ? 'selected' : '' }}>🟡 Media</option>
                                <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                            </select>
                            @error('prioridad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Asignado a --}}
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-bold">Asignar a <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id', auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->persona?->name ?? $usuario->email }} {{ $usuario->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Relacionar con --}}
                        <div class="col-md-12">
                            <hr>
                            <h6 class="fw-bold mb-3">Relacionar con entidad (opcional)</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="activable_type" class="form-label fw-bold">Tipo de Entidad</label>
                            <select name="activable_type" id="activable_type" class="form-select @error('activable_type') is-invalid @enderror">
                                <option value="">Ninguna</option>
                                <option value="App\Models\Prospecto" {{ old('activable_type', $entidadTipo) == 'App\Models\Prospecto' ? 'selected' : '' }}>Prospecto</option>
                                <option value="App\Models\Oportunidad" {{ old('activable_type', $entidadTipo) == 'App\Models\Oportunidad' ? 'selected' : '' }}>Oportunidad</option>
                            </select>
                            @error('activable_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="activable_id" class="form-label fw-bold">Entidad</label>
                            <select name="activable_id" id="activable_id" class="form-select @error('activable_id') is-invalid @enderror">
                                <option value="">Seleccionar...</option>
                            </select>
                            @error('activable_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div class="col-md-12">
                            <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" 
                                   value="{{ old('ubicacion') }}" placeholder="Ej: Oficina principal, Google Meet, etc.">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Recordatorio --}}
                        <div class="col-md-6">
                            <label for="recordatorio_minutos" class="form-label fw-bold">Recordatorio (minutos antes)</label>
                            <select name="recordatorio_minutos" id="recordatorio_minutos" class="form-select @error('recordatorio_minutos') is-invalid @enderror">
                                <option value="">Sin recordatorio</option>
                                <option value="15" {{ old('recordatorio_minutos') == '15' ? 'selected' : '' }}>15 minutos</option>
                                <option value="30" {{ old('recordatorio_minutos') == '30' ? 'selected' : '' }}>30 minutos</option>
                                <option value="60" {{ old('recordatorio_minutos') == '60' ? 'selected' : '' }}>1 hora</option>
                                <option value="1440" {{ old('recordatorio_minutos') == '1440' ? 'selected' : '' }}>1 día</option>
                            </select>
                            @error('recordatorio_minutos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase">
                            <i class="bi bi-save me-2"></i>Guardar Actividad
                        </button>
                        <a href="{{ route('admin.crm.actividades.index') }}" class="btn btn-secondary text-uppercase">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    const prospectos = @json($prospectos);
    const oportunidades = @json($oportunidades);
    const entidadIdInicial = "{{ old('activable_id', $entidadId ?? '') }}";

    // Cambiar opciones según tipo de entidad
    $('#activable_type').on('change', function() {
        const tipo = $(this).val();
        const selectEntidad = $('#activable_id');
        selectEntidad.empty().append('<option value="">Seleccionar...</option>');

        if (tipo === 'App\\Models\\Prospecto') {
            prospectos.forEach(p => {
                selectEntidad.append(`<option value="${p.id}">${p.nombre}</option>`);
            });
        } else if (tipo === 'App\\Models\\Oportunidad') {
            oportunidades.forEach(o => {
                const nombre = o.prospecto ? o.prospecto.nombre : 'Sin nombre';
                selectEntidad.append(`<option value="${o.id}">${o.codigo} - ${nombre}</option>`);
            });
        }

        if (entidadIdInicial && selectEntidad.find(`option[value="${entidadIdInicial}"]`).length) {
            selectEntidad.val(entidadIdInicial);
        }
    });

    // Cargar inicial si hay tipo seleccionado
    if ($('#activable_type').val()) {
        $('#activable_type').trigger('change');
    }
});
</script>
@endsection
