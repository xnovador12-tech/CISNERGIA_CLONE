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
                        <li class="breadcrumb-item link" aria-current="page">{{ $prospecto->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span class="badge bg-secondary fs-6">{{ $prospecto->codigo }}</span>
                @php
                    $estadoColors = ['nuevo' => 'secondary', 'contactado' => 'primary', 'calificado' => 'success', 'descartado' => 'danger', 'no_calificado' => 'warning'];
                @endphp
                <span class="badge bg-{{ $estadoColors[$prospecto->estado] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $prospecto->estado)) }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.crm.prospectos.update', $prospecto) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Errores de validación --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <!-- Información General -->
                        <div class="col-md-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-info-circle me-2"></i>Información General
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipo_persona" id="tipo_persona" required>
                                <option value="natural" {{ old('tipo_persona', $prospecto->tipo_persona) == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="juridica" {{ old('tipo_persona', $prospecto->tipo_persona) == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-3" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" maxlength="8"
                                   value="{{ old('dni', $prospecto->dni) }}">
                        </div>

                        <div class="col-md-3" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control" name="ruc" maxlength="11"
                                   value="{{ old('ruc', $prospecto->ruc) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre"
                                   value="{{ old('nombre', $prospecto->nombre) }}" required>
                        </div>

                        <div class="col-md-3" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos"
                                   value="{{ old('apellidos', $prospecto->apellidos) }}">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control" name="razon_social"
                                   value="{{ old('razon_social', $prospecto->razon_social) }}">
                        </div>

                        <!-- Datos de Contacto -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-telephone me-2"></i>Datos de Contacto
                            </h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ old('email', $prospecto->email) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Teléfono Fijo</label>
                            <input type="tel" class="form-control" name="telefono"
                                   value="{{ old('telefono', $prospecto->telefono) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control" name="celular"
                                   value="{{ old('celular', $prospecto->celular) }}">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion"
                                   value="{{ old('direccion', $prospecto->direccion) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select" name="distrito_id">
                                <option value="">Seleccionar...</option>
                                @foreach($distritos ?? [] as $distrito)
                                    <option value="{{ $distrito->id }}" {{ old('distrito_id', $prospecto->distrito_id) == $distrito->id ? 'selected' : '' }}>
                                        {{ $distrito->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Clasificación -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-tags me-2"></i>Clasificación
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado" id="estado_select" required>
                                <option value="nuevo" {{ old('estado', $prospecto->estado) == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                                <option value="contactado" {{ old('estado', $prospecto->estado) == 'contactado' ? 'selected' : '' }}>Contactado</option>
                                <option value="calificado" {{ old('estado', $prospecto->estado) == 'calificado' ? 'selected' : '' }}>Calificado</option>
                                <option value="no_calificado" {{ old('estado', $prospecto->estado) == 'no_calificado' ? 'selected' : '' }}>No Calificado</option>
                                <option value="descartado" {{ old('estado', $prospecto->estado) == 'descartado' ? 'selected' : '' }}>Descartado</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select" name="origen" required>
                                <option value="">Seleccionar...</option>
                                @foreach(['web' => 'Sitio Web', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'google_ads' => 'Google Ads', 'referido' => 'Referido', 'llamada' => 'Llamada', 'visita' => 'Visita', 'feria' => 'Feria/Evento', 'otro' => 'Otro'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('origen', $prospecto->origen) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select" name="segmento" required>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('segmento', $prospecto->segmento) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select" name="user_id">
                                <option value="">Sin asignar</option>
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id', $prospecto->user_id) == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Detalle de Origen</label>
                            <input type="text" class="form-control" name="origen_detalle"
                                   value="{{ old('origen_detalle', $prospecto->origen_detalle) }}" placeholder="Ej: Campaña de verano 2026">
                        </div>

                        <div class="col-md-6" id="campo_motivo_descarte" style="{{ $prospecto->estado == 'descartado' ? '' : 'display:none' }}">
                            <label class="form-label">Motivo de Descarte</label>
                            <input type="text" class="form-control" name="motivo_descarte"
                                   value="{{ old('motivo_descarte', $prospecto->motivo_descarte) }}">
                        </div>

                        <!-- Interés en Energía Solar -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-sun me-2"></i>Interés en Energía Solar
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Consumo Mensual (kWh)</label>
                            <input type="number" class="form-control" name="consumo_mensual_kwh"
                                   value="{{ old('consumo_mensual_kwh', $prospecto->consumo_mensual_kwh) }}" step="0.01">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Factura Mensual (S/)</label>
                            <input type="number" class="form-control" name="factura_mensual_soles"
                                   value="{{ old('factura_mensual_soles', $prospecto->factura_mensual_soles) }}" step="0.01">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Área Disponible (m²)</label>
                            <input type="number" class="form-control" name="area_disponible_m2"
                                   value="{{ old('area_disponible_m2', $prospecto->area_disponible_m2) }}" step="0.01">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Inmueble</label>
                            <select class="form-select" name="tipo_inmueble">
                                <option value="">Seleccionar...</option>
                                @foreach(['casa' => 'Casa', 'departamento' => 'Departamento', 'local_comercial' => 'Local Comercial', 'oficina' => 'Oficina', 'fabrica' => 'Fábrica', 'almacen' => 'Almacén', 'terreno' => 'Terreno'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('tipo_inmueble', $prospecto->tipo_inmueble) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Empresa Eléctrica</label>
                            <select class="form-select" name="empresa_electrica">
                                <option value="">Seleccionar...</option>
                                @foreach(['Luz del Sur', 'Enel', 'Seal', 'Electronoroeste', 'Hidrandina', 'Electrocentro', 'Electrosur', 'Electro Oriente', 'Otro'] as $empresa)
                                    <option value="{{ $empresa }}" {{ old('empresa_electrica', $prospecto->empresa_electrica) == $empresa ? 'selected' : '' }}>{{ $empresa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Presupuesto Estimado (S/)</label>
                            <input type="number" class="form-control" name="presupuesto_estimado"
                                   value="{{ old('presupuesto_estimado', $prospecto->presupuesto_estimado) }}" step="0.01">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select" name="nivel_interes">
                                <option value="">Seleccionar...</option>
                                @foreach(['muy_alto' => 'Muy Alto', 'alto' => 'Alto', 'medio' => 'Medio', 'bajo' => 'Bajo'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('nivel_interes', $prospecto->nivel_interes) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select" name="urgencia">
                                <option value="">Seleccionar...</option>
                                @foreach(['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo (1-3 meses)', 'mediano_plazo' => 'Mediano Plazo (3-6 meses)', 'largo_plazo' => 'Largo Plazo (+6 meses)'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('urgencia', $prospecto->urgencia) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label d-block">Opciones</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="checkbox" name="tiene_medidor_bidireccional" value="1"
                                       {{ old('tiene_medidor_bidireccional', $prospecto->tiene_medidor_bidireccional) ? 'checked' : '' }}>
                                <label class="form-check-label">Medidor Bidireccional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requiere_financiamiento" value="1"
                                       {{ old('requiere_financiamiento', $prospecto->requiere_financiamiento) ? 'checked' : '' }}>
                                <label class="form-check-label">Requiere Financiamiento</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Próximo Contacto</label>
                            <input type="date" class="form-control" name="fecha_proximo_contacto"
                                   value="{{ old('fecha_proximo_contacto', $prospecto->fecha_proximo_contacto?->format('Y-m-d')) }}">
                        </div>

                        <!-- Scoring -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-graph-up me-2"></i>Scoring
                            </h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Scoring</label>
                            <select class="form-select" name="scoring">
                                <option value="C" {{ old('scoring', $prospecto->scoring) == 'C' ? 'selected' : '' }}>C - Bajo</option>
                                <option value="B" {{ old('scoring', $prospecto->scoring) == 'B' ? 'selected' : '' }}>B - Medio</option>
                                <option value="A" {{ old('scoring', $prospecto->scoring) == 'A' ? 'selected' : '' }}>A - Alto</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Puntos de Scoring (0-100)</label>
                            <input type="number" class="form-control" name="scoring_puntos"
                                   value="{{ old('scoring_puntos', $prospecto->scoring_puntos) }}" min="0" max="100">
                        </div>

                        <!-- Notas -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-chat-text me-2"></i>Observaciones
                            </h6>
                        </div>

                        <div class="col-md-12">
                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Notas adicionales...">{{ old('observaciones', $prospecto->observaciones) }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <small class="text-muted">
                                        Creado: {{ $prospecto->created_at->format('d/m/Y H:i') }} |
                                        Actualizado: {{ $prospecto->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.crm.prospectos.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Actualizar Prospecto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campos según tipo de persona
        const tipoPersona = document.getElementById('tipo_persona');
        const campoApellidos = document.getElementById('campo_apellidos');
        const campoRazonSocial = document.getElementById('campo_razon_social');
        
        function toggleCampos() {
            if (tipoPersona.value === 'juridica') {
                campoApellidos.style.display = 'none';
                campoRazonSocial.style.display = 'block';
            } else {
                campoApellidos.style.display = 'block';
                campoRazonSocial.style.display = 'none';
            }
        }
        
        tipoPersona.addEventListener('change', toggleCampos);
        toggleCampos();
        
        // Mostrar motivo de descarte si el estado es descartado
        const estadoSelect = document.getElementById('estado_select');
        const campoMotivoDescarte = document.getElementById('campo_motivo_descarte');
        
        estadoSelect.addEventListener('change', function() {
            campoMotivoDescarte.style.display = this.value === 'descartado' ? 'block' : 'none';
        });
    });
</script>
@endsection
