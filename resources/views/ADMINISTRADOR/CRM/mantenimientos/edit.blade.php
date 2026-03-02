@extends('TEMPLATES.administrador')
@section('title', 'Editar Mantenimiento ' . $mantenimiento->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR MANTENIMIENTO {{ $mantenimiento->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.mantenimientos.index') }}">Mantenimientos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $mantenimiento->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                {{-- Info --}}
                <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                    <div class="card-body py-2">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <small class="text-muted">Editando mantenimiento <span class="badge bg-secondary">{{ $mantenimiento->codigo }}</span> — {{ $mantenimiento->cliente->nombre_completo ?? 'N/A' }}</small>
                    </div>
                </div>

                <form action="{{ route('admin.crm.mantenimientos.update', $mantenimiento) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Sección: Cliente y Ubicación --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Cliente y Ubicación</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $mantenimiento->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre ?? $cliente->razon_social }} - {{ $cliente->codigo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="direccion" class="form-label fw-bold">Dirección del Servicio <span class="text-danger">*</span></label>
                            <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" 
                                   value="{{ old('direccion', $mantenimiento->direccion) }}" required placeholder="Dirección donde se realizará el mantenimiento">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Tipo y Programación --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-calendar me-2"></i>Programación</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="titulo" class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo', $mantenimiento->titulo) }}" required placeholder="Ej: Mantenimiento preventivo Q1 2024">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tipo" class="form-label fw-bold">Tipo de Mantenimiento <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="preventivo" {{ old('tipo', $mantenimiento->tipo) == 'preventivo' ? 'selected' : '' }}>🔧 Preventivo</option>
                                <option value="correctivo" {{ old('tipo', $mantenimiento->tipo) == 'correctivo' ? 'selected' : '' }}>🔩 Correctivo</option>
                                <option value="predictivo" {{ old('tipo', $mantenimiento->tipo) == 'predictivo' ? 'selected' : '' }}>📊 Predictivo</option>
                                <option value="limpieza" {{ old('tipo', $mantenimiento->tipo) == 'limpieza' ? 'selected' : '' }}>🧹 Limpieza</option>
                                <option value="inspeccion" {{ old('tipo', $mantenimiento->tipo) == 'inspeccion' ? 'selected' : '' }}>🔍 Inspección</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                            <select name="tecnico_id" id="tecnico_id" class="form-select @error('tecnico_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos ?? [] as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_id', $mantenimiento->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->persona?->name ?? $tecnico->name }} {{ $tecnico->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tecnico_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="estado" class="form-label fw-bold">Estado</label>
                            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror">
                                <option value="programado" {{ old('estado', $mantenimiento->estado) == 'programado' ? 'selected' : '' }}>📅 Programado</option>
                                <option value="confirmado" {{ old('estado', $mantenimiento->estado) == 'confirmado' ? 'selected' : '' }}>✅ Confirmado</option>
                                <option value="en_camino" {{ old('estado', $mantenimiento->estado) == 'en_camino' ? 'selected' : '' }}>🚗 En Camino</option>
                                <option value="en_progreso" {{ old('estado', $mantenimiento->estado) == 'en_progreso' ? 'selected' : '' }}>🔧 En Progreso</option>
                                <option value="completado" {{ old('estado', $mantenimiento->estado) == 'completado' ? 'selected' : '' }}>✔️ Completado</option>
                                <option value="cancelado" {{ old('estado', $mantenimiento->estado) == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                <option value="reprogramado" {{ old('estado', $mantenimiento->estado) == 'reprogramado' ? 'selected' : '' }}>🔄 Reprogramado</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="fecha_programada" class="form-label fw-bold">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_programada" id="fecha_programada" class="form-control @error('fecha_programada') is-invalid @enderror" 
                                   value="{{ old('fecha_programada', $mantenimiento->fecha_programada?->format('Y-m-d')) }}" required>
                            @error('fecha_programada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="hora_programada" class="form-label fw-bold">Hora Programada</label>
                            <input type="time" name="hora_programada" id="hora_programada" class="form-control @error('hora_programada') is-invalid @enderror" 
                                   value="{{ old('hora_programada', $mantenimiento->hora_programada) }}">
                            @error('hora_programada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="duracion_estimada_horas" class="form-label fw-bold">Duración Estimada (horas)</label>
                            <input type="number" name="duracion_estimada_horas" id="duracion_estimada_horas" class="form-control @error('duracion_estimada_horas') is-invalid @enderror" 
                                   value="{{ old('duracion_estimada_horas', $mantenimiento->duracion_estimada_horas ?? 2) }}" min="1" max="24">
                            @error('duracion_estimada_horas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Datos del Sistema Solar --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-sun me-2"></i>Datos del Sistema Solar</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="potencia_sistema_kw" class="form-label fw-bold">Potencia del Sistema (kW)</label>
                            <input type="number" name="potencia_sistema_kw" id="potencia_sistema_kw" class="form-control @error('potencia_sistema_kw') is-invalid @enderror" 
                                   value="{{ old('potencia_sistema_kw', $mantenimiento->potencia_sistema_kw) }}" step="0.01" min="0" placeholder="Ej: 5.5">
                            @error('potencia_sistema_kw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="cantidad_paneles" class="form-label fw-bold">Cantidad de Paneles</label>
                            <input type="number" name="cantidad_paneles" id="cantidad_paneles" class="form-control @error('cantidad_paneles') is-invalid @enderror" 
                                   value="{{ old('cantidad_paneles', $mantenimiento->cantidad_paneles) }}" min="1" placeholder="Ej: 12">
                            @error('cantidad_paneles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="marca_inversor" class="form-label fw-bold">Marca Inversor</label>
                            <input type="text" name="marca_inversor" id="marca_inversor" class="form-control @error('marca_inversor') is-invalid @enderror" 
                                   value="{{ old('marca_inversor', $mantenimiento->marca_inversor) }}" placeholder="Ej: Huawei">
                            @error('marca_inversor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="modelo_inversor" class="form-label fw-bold">Modelo Inversor</label>
                            <input type="text" name="modelo_inversor" id="modelo_inversor" class="form-control @error('modelo_inversor') is-invalid @enderror" 
                                   value="{{ old('modelo_inversor', $mantenimiento->modelo_inversor) }}" placeholder="Ej: SUN2000-5KTL">
                            @error('modelo_inversor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Detalles --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-card-text me-2"></i>Detalles del Servicio</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción del Trabajo</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" 
                                      placeholder="Describa las actividades a realizar...">{{ old('descripcion', $mantenimiento->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="es_gratuito" id="es_gratuito" value="1"
                                       {{ old('es_gratuito', $mantenimiento->es_gratuito) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="es_gratuito">
                                    <i class="bi bi-gift me-1"></i>Servicio Gratuito (Incluido en instalación)
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Costos (solo si no es gratuito) --}}
                    <div id="seccion-costos">
                        <h5 class="fw-bold mb-3"><i class="bi bi-cash me-2"></i>Costos</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="costo_mano_obra" class="form-label fw-bold">Mano de Obra (S/)</label>
                                <input type="number" name="costo_mano_obra" id="costo_mano_obra" class="form-control @error('costo_mano_obra') is-invalid @enderror" 
                                       value="{{ old('costo_mano_obra', $mantenimiento->costo_mano_obra ?? 0) }}" min="0" step="0.01">
                                @error('costo_mano_obra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="costo_materiales" class="form-label fw-bold">Materiales (S/)</label>
                                <input type="number" name="costo_materiales" id="costo_materiales" class="form-control @error('costo_materiales') is-invalid @enderror" 
                                       value="{{ old('costo_materiales', $mantenimiento->costo_materiales ?? 0) }}" min="0" step="0.01">
                                @error('costo_materiales')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="costo_transporte" class="form-label fw-bold">Transporte (S/)</label>
                                <input type="number" name="costo_transporte" id="costo_transporte" class="form-control @error('costo_transporte') is-invalid @enderror" 
                                       value="{{ old('costo_transporte', $mantenimiento->costo_transporte ?? 0) }}" min="0" step="0.01">
                                @error('costo_transporte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="estado_pago" class="form-label fw-bold">Estado de Pago</label>
                                <select name="estado_pago" id="estado_pago" class="form-select @error('estado_pago') is-invalid @enderror">
                                    <option value="no_aplica" {{ old('estado_pago', $mantenimiento->estado_pago) == 'no_aplica' ? 'selected' : '' }}>No Aplica</option>
                                    <option value="pendiente" {{ old('estado_pago', $mantenimiento->estado_pago) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="pagado" {{ old('estado_pago', $mantenimiento->estado_pago) == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                </select>
                                @error('estado_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Notas Internas --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-lock me-2 text-warning"></i>Notas Internas</h6>
                            <textarea name="notas_internas" id="notas_internas" rows="3" class="form-control @error('notas_internas') is-invalid @enderror" placeholder="Notas privadas visibles solo para el equipo...">{{ old('notas_internas', $mantenimiento->notas_internas) }}</textarea>
                            @error('notas_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.mantenimientos.show', $mantenimiento) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#cliente_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar cliente...',
        allowClear: true
    });

    // Mostrar/ocultar sección de costos
    function toggleCostos() {
        if ($('#es_gratuito').is(':checked')) {
            $('#seccion-costos').hide();
        } else {
            $('#seccion-costos').show();
        }
    }
    
    toggleCostos();
    $('#es_gratuito').change(toggleCostos);
});
</script>
@endsection
