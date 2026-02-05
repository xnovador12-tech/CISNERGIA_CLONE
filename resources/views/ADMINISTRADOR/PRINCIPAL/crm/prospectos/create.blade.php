@extends('TEMPLATES.administrador')

@section('title', 'Nuevo Prospecto')

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.prospectos.index') }}">Prospectos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Registrar Nuevo Prospecto</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.crm.prospectos.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

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
                                <option value="natural" {{ old('tipo_persona') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="juridica" {{ old('tipo_persona') == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-3" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" maxlength="8"
                                   value="{{ old('dni') }}" placeholder="12345678">
                        </div>

                        <div class="col-md-3" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control" name="ruc" maxlength="11"
                                   value="{{ old('ruc') }}" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre"
                                   value="{{ old('nombre') }}" required placeholder="Nombre o nombre comercial">
                        </div>

                        <div class="col-md-3" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos"
                                   value="{{ old('apellidos') }}" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control" name="razon_social"
                                   value="{{ old('razon_social') }}" placeholder="Razón social de la empresa">
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
                                   value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Teléfono Fijo</label>
                            <input type="tel" class="form-control" name="telefono"
                                   value="{{ old('telefono') }}" placeholder="01-1234567">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control" name="celular"
                                   value="{{ old('celular') }}" placeholder="987654321">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion"
                                   value="{{ old('direccion') }}" placeholder="Av. Principal 123, Urbanización">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select" name="distrito_id">
                                <option value="">Seleccionar...</option>
                                @foreach($distritos ?? [] as $distrito)
                                    <option value="{{ $distrito->id }}" {{ old('distrito_id') == $distrito->id ? 'selected' : '' }}>
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

                        <div class="col-md-4">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select" name="origen" required>
                                <option value="">Seleccionar...</option>
                                @foreach(['web' => 'Sitio Web', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'google_ads' => 'Google Ads', 'referido' => 'Referido', 'llamada' => 'Llamada', 'visita' => 'Visita', 'feria' => 'Feria/Evento', 'otro' => 'Otro'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('origen') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select" name="segmento" required>
                                <option value="">Seleccionar...</option>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('segmento') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select" name="user_id">
                                <option value="">Sin asignar</option>
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id') == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Detalle de Origen</label>
                            <input type="text" class="form-control" name="origen_detalle"
                                   value="{{ old('origen_detalle') }}" placeholder="Ej: Campaña de verano 2026">
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
                                   value="{{ old('consumo_mensual_kwh') }}" step="0.01" placeholder="450">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Factura Mensual (S/)</label>
                            <input type="number" class="form-control" name="factura_mensual_soles"
                                   value="{{ old('factura_mensual_soles') }}" step="0.01" placeholder="350.00">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Área Disponible (m²)</label>
                            <input type="number" class="form-control" name="area_disponible_m2"
                                   value="{{ old('area_disponible_m2') }}" step="0.01" placeholder="50">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Inmueble</label>
                            <select class="form-select" name="tipo_inmueble">
                                <option value="">Seleccionar...</option>
                                @foreach(['casa' => 'Casa', 'departamento' => 'Departamento', 'local_comercial' => 'Local Comercial', 'oficina' => 'Oficina', 'fabrica' => 'Fábrica', 'almacen' => 'Almacén', 'terreno' => 'Terreno'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('tipo_inmueble') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Empresa Eléctrica</label>
                            <select class="form-select" name="empresa_electrica">
                                <option value="">Seleccionar...</option>
                                @foreach(['Luz del Sur', 'Enel', 'Seal', 'Electronoroeste', 'Hidrandina', 'Electrocentro', 'Electrosur', 'Electro Oriente', 'Otro'] as $empresa)
                                    <option value="{{ $empresa }}" {{ old('empresa_electrica') == $empresa ? 'selected' : '' }}>{{ $empresa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Presupuesto Estimado (S/)</label>
                            <input type="number" class="form-control" name="presupuesto_estimado"
                                   value="{{ old('presupuesto_estimado') }}" step="0.01" placeholder="15000.00">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select" name="nivel_interes">
                                <option value="">Seleccionar...</option>
                                @foreach(['muy_alto' => 'Muy Alto', 'alto' => 'Alto', 'medio' => 'Medio', 'bajo' => 'Bajo'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('nivel_interes') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select" name="urgencia">
                                <option value="">Seleccionar...</option>
                                @foreach(['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo (1-3 meses)', 'mediano_plazo' => 'Mediano Plazo (3-6 meses)', 'largo_plazo' => 'Largo Plazo (+6 meses)'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('urgencia') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block">Opciones Adicionales</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="checkbox" name="tiene_medidor_bidireccional" value="1"
                                       {{ old('tiene_medidor_bidireccional') ? 'checked' : '' }}>
                                <label class="form-check-label">Tiene Medidor Bidireccional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requiere_financiamiento" value="1"
                                       {{ old('requiere_financiamiento') ? 'checked' : '' }}>
                                <label class="form-check-label">Requiere Financiamiento</label>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-chat-text me-2"></i>Observaciones
                            </h6>
                        </div>

                        <div class="col-md-12">
                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto...">{{ old('observaciones') }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.crm.prospectos.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Prospecto
                                </button>
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
        const campoDni = document.getElementById('campo_dni');
        const campoRuc = document.getElementById('campo_ruc');
        
        function toggleCampos() {
            if (tipoPersona.value === 'juridica') {
                campoApellidos.style.display = 'none';
                campoRazonSocial.style.display = 'block';
                campoDni.style.display = 'none';
                campoRuc.style.display = 'block';
            } else {
                campoApellidos.style.display = 'block';
                campoRazonSocial.style.display = 'none';
                campoDni.style.display = 'block';
                campoRuc.style.display = 'none';
            }
        }
        
        tipoPersona.addEventListener('change', toggleCampos);
        toggleCampos();
    });
</script>
@endsection
