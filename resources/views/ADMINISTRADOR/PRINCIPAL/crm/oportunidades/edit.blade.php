@extends('TEMPLATES.administrador')
@section('title', 'Editar Oportunidad')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR OPORTUNIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
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
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span class="badge bg-secondary fs-6">{{ $oportunidad->codigo }}</span>
                @php
                    $etapaColors = [
                        'calificacion' => 'secondary', 
                        'analisis_sitio' => 'info',
                        'propuesta_tecnica' => 'primary',
                        'negociacion' => 'warning', 
                        'contrato' => 'dark',
                        'ganada' => 'success', 
                        'perdida' => 'danger'
                    ];
                @endphp
                <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $oportunidad->etapa)) }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.crm.oportunidades.update', $oportunidad->slug) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- INFORMACIÓN GENERAL --}}
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-8">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $oportunidad->nombre) }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_proyecto') is-invalid @enderror" name="tipo_proyecto" required>
                                <option value="residencial" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'residencial' ? 'selected' : '' }}>Residencial</option>
                                <option value="comercial" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'comercial' ? 'selected' : '' }}>Comercial</option>
                                <option value="industrial" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="agricola" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'agricola' ? 'selected' : '' }}>Agrícola</option>
                                <option value="bombeo_solar" {{ old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'bombeo_solar' ? 'selected' : '' }}>Bombeo Solar</option>
                            </select>
                            @error('tipo_proyecto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto</label>
                            <select class="form-select @error('prospecto_id') is-invalid @enderror" name="prospecto_id">
                                <option value="">Ninguno</option>
                                @foreach($prospectos ?? [] as $prospecto)
                                    <option value="{{ $prospecto->id }}" {{ old('prospecto_id', $oportunidad->prospecto_id) == $prospecto->id ? 'selected' : '' }}>
                                        {{ $prospecto->codigo }} - {{ $prospecto->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prospecto_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select class="form-select @error('cliente_id') is-invalid @enderror" name="cliente_id">
                                <option value="">Ninguno</option>
                                @foreach($clientes ?? [] as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $oportunidad->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->codigo ?? '' }} - {{ $cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- SISTEMA SOLAR --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-sun me-2"></i>Sistema Solar</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Potencia (kW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('potencia_kw') is-invalid @enderror" name="potencia_kw" value="{{ old('potencia_kw', $oportunidad->potencia_kw) }}" step="0.01" required>
                            @error('potencia_kw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">N° Paneles</label>
                            <input type="number" class="form-control @error('cantidad_paneles') is-invalid @enderror" name="cantidad_paneles" value="{{ old('cantidad_paneles', $oportunidad->cantidad_paneles) }}">
                            @error('cantidad_paneles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo Panel</label>
                            <select class="form-select @error('tipo_panel') is-invalid @enderror" name="tipo_panel">
                                <option value="">Seleccionar</option>
                                <option value="Monocristalino" {{ old('tipo_panel', $oportunidad->tipo_panel) == 'Monocristalino' ? 'selected' : '' }}>Monocristalino</option>
                                <option value="Policristalino" {{ old('tipo_panel', $oportunidad->tipo_panel) == 'Policristalino' ? 'selected' : '' }}>Policristalino</option>
                                <option value="Thin Film" {{ old('tipo_panel', $oportunidad->tipo_panel) == 'Thin Film' ? 'selected' : '' }}>Thin Film</option>
                            </select>
                            @error('tipo_panel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca Panel</label>
                            <input type="text" class="form-control @error('marca_panel') is-invalid @enderror" name="marca_panel" value="{{ old('marca_panel', $oportunidad->marca_panel) }}">
                            @error('marca_panel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo Inversor</label>
                            <select class="form-select @error('tipo_inversor') is-invalid @enderror" name="tipo_inversor">
                                <option value="">Seleccionar</option>
                                <option value="String" {{ old('tipo_inversor', $oportunidad->tipo_inversor) == 'String' ? 'selected' : '' }}>String</option>
                                <option value="Microinversor" {{ old('tipo_inversor', $oportunidad->tipo_inversor) == 'Microinversor' ? 'selected' : '' }}>Microinversor</option>
                                <option value="Híbrido" {{ old('tipo_inversor', $oportunidad->tipo_inversor) == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                <option value="Central" {{ old('tipo_inversor', $oportunidad->tipo_inversor) == 'Central' ? 'selected' : '' }}>Central</option>
                            </select>
                            @error('tipo_inversor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca Inversor</label>
                            <input type="text" class="form-control @error('marca_inversor') is-invalid @enderror" name="marca_inversor" value="{{ old('marca_inversor', $oportunidad->marca_inversor) }}">
                            @error('marca_inversor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">¿Incluye Baterías?</label>
                            <select class="form-select @error('incluye_baterias') is-invalid @enderror" name="incluye_baterias">
                                <option value="0" {{ old('incluye_baterias', $oportunidad->incluye_baterias) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('incluye_baterias', $oportunidad->incluye_baterias) == 1 ? 'selected' : '' }}>Sí</option>
                            </select>
                            @error('incluye_baterias')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Capacidad Baterías (kWh)</label>
                            <input type="number" class="form-control @error('capacidad_baterias_kwh') is-invalid @enderror" name="capacidad_baterias_kwh" value="{{ old('capacidad_baterias_kwh', $oportunidad->capacidad_baterias_kwh) }}" step="0.01">
                            @error('capacidad_baterias_kwh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- PRODUCCIÓN Y AHORRO --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-lightning-charge me-2"></i>Producción y Ahorro Estimado</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Prod. Mensual (kWh)</label>
                            <input type="number" class="form-control @error('produccion_mensual_kwh') is-invalid @enderror" name="produccion_mensual_kwh" value="{{ old('produccion_mensual_kwh', $oportunidad->produccion_mensual_kwh) }}" step="0.01">
                            @error('produccion_mensual_kwh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Prod. Anual (kWh)</label>
                            <input type="number" class="form-control @error('produccion_anual_kwh') is-invalid @enderror" name="produccion_anual_kwh" value="{{ old('produccion_anual_kwh', $oportunidad->produccion_anual_kwh) }}" step="0.01">
                            @error('produccion_anual_kwh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Ahorro Mensual (S/)</label>
                            <input type="number" class="form-control @error('ahorro_mensual_soles') is-invalid @enderror" name="ahorro_mensual_soles" value="{{ old('ahorro_mensual_soles', $oportunidad->ahorro_mensual_soles) }}" step="0.01">
                            @error('ahorro_mensual_soles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Ahorro Anual (S/)</label>
                            <input type="number" class="form-control @error('ahorro_anual_soles') is-invalid @enderror" name="ahorro_anual_soles" value="{{ old('ahorro_anual_soles', $oportunidad->ahorro_anual_soles) }}" step="0.01">
                            @error('ahorro_anual_soles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Retorno Inversión (años)</label>
                            <input type="number" class="form-control @error('retorno_inversion_anos') is-invalid @enderror" name="retorno_inversion_anos" value="{{ old('retorno_inversion_anos', $oportunidad->retorno_inversion_anos) }}" step="0.1">
                            @error('retorno_inversion_anos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- PIPELINE --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Pipeline y Valores</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('monto_estimado') is-invalid @enderror" name="monto_estimado" value="{{ old('monto_estimado', $oportunidad->monto_estimado) }}" step="0.01" required>
                            @error('monto_estimado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Final (S/)</label>
                            <input type="number" class="form-control @error('monto_final') is-invalid @enderror" name="monto_final" value="{{ old('monto_final', $oportunidad->monto_final) }}" step="0.01">
                            @error('monto_final')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Etapa <span class="text-danger">*</span></label>
                            <select class="form-select @error('etapa') is-invalid @enderror" name="etapa" required>
                                <option value="calificacion" {{ old('etapa', $oportunidad->etapa) == 'calificacion' ? 'selected' : '' }}>Calificación</option>
                                <option value="analisis_sitio" {{ old('etapa', $oportunidad->etapa) == 'analisis_sitio' ? 'selected' : '' }}>Análisis de Sitio</option>
                                <option value="propuesta_tecnica" {{ old('etapa', $oportunidad->etapa) == 'propuesta_tecnica' ? 'selected' : '' }}>Propuesta Técnica</option>
                                <option value="negociacion" {{ old('etapa', $oportunidad->etapa) == 'negociacion' ? 'selected' : '' }}>Negociación</option>
                                <option value="contrato" {{ old('etapa', $oportunidad->etapa) == 'contrato' ? 'selected' : '' }}>Contrato</option>
                                <option value="ganada" {{ old('etapa', $oportunidad->etapa) == 'ganada' ? 'selected' : '' }}>Ganada</option>
                                <option value="perdida" {{ old('etapa', $oportunidad->etapa) == 'perdida' ? 'selected' : '' }}>Perdida</option>
                            </select>
                            @error('etapa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Probabilidad (%)</label>
                            <input type="number" class="form-control @error('probabilidad') is-invalid @enderror" name="probabilidad" value="{{ old('probabilidad', $oportunidad->probabilidad) }}" min="0" max="100">
                            @error('probabilidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- FECHAS --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Estimada</label>
                            <input type="date" class="form-control @error('fecha_cierre_estimada') is-invalid @enderror" name="fecha_cierre_estimada" 
                                   value="{{ old('fecha_cierre_estimada', $oportunidad->fecha_cierre_estimada?->format('Y-m-d')) }}">
                            @error('fecha_cierre_estimada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Real</label>
                            <input type="date" class="form-control @error('fecha_cierre_real') is-invalid @enderror" name="fecha_cierre_real" 
                                   value="{{ old('fecha_cierre_real', $oportunidad->fecha_cierre_real?->format('Y-m-d')) }}">
                            @error('fecha_cierre_real')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Instalación Estimada</label>
                            <input type="date" class="form-control @error('fecha_instalacion_estimada') is-invalid @enderror" name="fecha_instalacion_estimada" 
                                   value="{{ old('fecha_instalacion_estimada', $oportunidad->fecha_instalacion_estimada?->format('Y-m-d')) }}">
                            @error('fecha_instalacion_estimada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- ASIGNACIÓN --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-people me-2"></i>Asignación</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id">
                                <option value="">Sin asignar</option>
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id', $oportunidad->user_id) == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona->name ?? $vendedor->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Técnico Asignado</label>
                            <select class="form-select @error('tecnico_id') is-invalid @enderror" name="tecnico_id">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos ?? [] as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_id', $oportunidad->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->persona->name ?? $tecnico->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tecnico_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sede</label>
                            <select class="form-select @error('sede_id') is-invalid @enderror" name="sede_id">
                                <option value="">Sin asignar</option>
                                @foreach($sedes ?? [] as $sede)
                                    <option value="{{ $sede->id }}" {{ old('sede_id', $oportunidad->sede_id) == $sede->id ? 'selected' : '' }}>
                                        {{ $sede->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sede_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- NOTAS --}}
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-card-text me-2"></i>Notas</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3">{{ old('observaciones', $oportunidad->observaciones) }}</textarea>
                            @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Notas Técnicas</label>
                            <textarea class="form-control @error('notas_tecnicas') is-invalid @enderror" name="notas_tecnicas" rows="3">{{ old('notas_tecnicas', $oportunidad->notas_tecnicas) }}</textarea>
                            @error('notas_tecnicas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        @if($oportunidad->etapa === 'perdida')
                        {{-- MOTIVO DE PÉRDIDA --}}
                        <div class="col-12 mt-4"><h6 class="text-danger border-bottom pb-2"><i class="bi bi-x-circle me-2"></i>Motivo de Pérdida</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Motivo</label>
                            <select class="form-select @error('motivo_perdida') is-invalid @enderror" name="motivo_perdida">
                                <option value="">Seleccionar</option>
                                <option value="Precio alto" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Precio alto' ? 'selected' : '' }}>Precio alto</option>
                                <option value="Competencia" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Competencia' ? 'selected' : '' }}>Competencia</option>
                                <option value="Sin presupuesto" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Sin presupuesto' ? 'selected' : '' }}>Sin presupuesto</option>
                                <option value="Cambio de prioridades" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Cambio de prioridades' ? 'selected' : '' }}>Cambio de prioridades</option>
                                <option value="Sin respuesta" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Sin respuesta' ? 'selected' : '' }}>Sin respuesta</option>
                                <option value="Otro" {{ old('motivo_perdida', $oportunidad->motivo_perdida) == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('motivo_perdida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Competidor Ganador</label>
                            <input type="text" class="form-control @error('competidor_ganador') is-invalid @enderror" name="competidor_ganador" value="{{ old('competidor_ganador', $oportunidad->competidor_ganador) }}">
                            @error('competidor_ganador')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Detalle de Pérdida</label>
                            <textarea class="form-control @error('detalle_perdida') is-invalid @enderror" name="detalle_perdida" rows="2">{{ old('detalle_perdida', $oportunidad->detalle_perdida) }}</textarea>
                            @error('detalle_perdida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @endif

                        {{-- BOTONES --}}
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Creado: {{ $oportunidad->created_at->format('d/m/Y H:i') }} | 
                                    Actualizado: {{ $oportunidad->updated_at->format('d/m/Y H:i') }}
                                </small>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.crm.oportunidades.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Actualizar
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
