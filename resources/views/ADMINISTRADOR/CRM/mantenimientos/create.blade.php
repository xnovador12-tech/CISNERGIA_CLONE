@extends('TEMPLATES.administrador')
@section('title', 'Nuevo Mantenimiento')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROGRAMAR MANTENIMIENTO</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.mantenimientos.index') }}">Mantenimientos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                {{-- Info / Ticket Origen --}}
                @if(isset($ticket) && $ticket)
                    <div class="card border-0 rounded-0 border-start border-3 border-warning mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #fff8e1">
                        <div class="card-body py-2">
                            <i class="bi bi-ticket-detailed text-warning me-2"></i>
                            <small>Mantenimiento originado desde ticket <a href="{{ route('admin.crm.tickets.show', $ticket) }}" class="fw-bold text-decoration-none"><span class="badge bg-secondary">{{ $ticket->codigo }}</span></a> — {{ Str::limit($ticket->asunto, 60) }}</small>
                        </div>
                    </div>
                @else
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios. La duración y costos se pueden completar después.</small>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.crm.mantenimientos.store') }}" method="POST">
                    @csrf
                    @if(isset($ticket) && $ticket)
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    @endif
                    
                    {{-- Sección: Cliente y Servicio --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Cliente y Ubicación</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $clienteId ?? '') == $cliente->id ? 'selected' : '' }}>
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
                                   value="{{ old('direccion') }}" placeholder="Dirección donde se realizará el servicio" required>
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
                            <label for="titulo" class="form-label fw-bold">Título del Mantenimiento <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo', isset($ticket) ? 'Mantenimiento - ' . $ticket->asunto : '') }}" placeholder="Ej: Mantenimiento preventivo trimestral" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tipo" class="form-label fw-bold">Tipo de Mantenimiento <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccionar...</option>
                                <option value="preventivo" {{ old('tipo') == 'preventivo' ? 'selected' : '' }}>🔧 Preventivo</option>
                                <option value="correctivo" {{ old('tipo') == 'correctivo' ? 'selected' : '' }}>🔩 Correctivo</option>
                                <option value="predictivo" {{ old('tipo') == 'predictivo' ? 'selected' : '' }}>📊 Predictivo</option>
                                <option value="limpieza" {{ old('tipo') == 'limpieza' ? 'selected' : '' }}>🧹 Limpieza</option>
                                <option value="inspeccion" {{ old('tipo') == 'inspeccion' ? 'selected' : '' }}>🔍 Inspección</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                            <select name="tecnico_id" id="tecnico_id" class="form-select @error('tecnico_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->persona?->name ?? $tecnico->name }} {{ $tecnico->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tecnico_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="duracion_estimada_horas" class="form-label fw-bold">Duración Estimada (horas)</label>
                            <input type="number" name="duracion_estimada_horas" id="duracion_estimada_horas" class="form-control @error('duracion_estimada_horas') is-invalid @enderror" 
                                   value="{{ old('duracion_estimada_horas', 2) }}" min="1" max="24">
                            @error('duracion_estimada_horas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="fecha_programada" class="form-label fw-bold">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_programada" id="fecha_programada" class="form-control @error('fecha_programada') is-invalid @enderror" 
                                   value="{{ old('fecha_programada', now()->addDay()->format('Y-m-d')) }}" required>
                            @error('fecha_programada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="hora_programada" class="form-label fw-bold">Hora Programada</label>
                            <input type="time" name="hora_programada" id="hora_programada" class="form-control @error('hora_programada') is-invalid @enderror" 
                                   value="{{ old('hora_programada', '09:00') }}">
                            @error('hora_programada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold d-block">&nbsp;</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="es_gratuito" id="es_gratuito" value="1" {{ old('es_gratuito') ? 'checked' : '' }}>
                                <label class="form-check-label" for="es_gratuito">
                                    Mantenimiento gratuito (incluido en servicio)
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Detalles del Sistema --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-sun me-2"></i>Datos del Sistema Solar</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="potencia_sistema_kw" class="form-label fw-bold">Potencia (kW)</label>
                            <input type="number" name="potencia_sistema_kw" id="potencia_sistema_kw" class="form-control @error('potencia_sistema_kw') is-invalid @enderror" 
                                   value="{{ old('potencia_sistema_kw') }}" min="0" step="0.01" placeholder="Ej: 5.5">
                            @error('potencia_sistema_kw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="cantidad_paneles" class="form-label fw-bold">Cantidad de Paneles</label>
                            <input type="number" name="cantidad_paneles" id="cantidad_paneles" class="form-control @error('cantidad_paneles') is-invalid @enderror" 
                                   value="{{ old('cantidad_paneles') }}" min="1" placeholder="Ej: 10">
                            @error('cantidad_paneles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="marca_inversor" class="form-label fw-bold">Marca Inversor</label>
                            <input type="text" name="marca_inversor" id="marca_inversor" class="form-control @error('marca_inversor') is-invalid @enderror" 
                                   value="{{ old('marca_inversor') }}" placeholder="Ej: Growatt">
                            @error('marca_inversor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="modelo_inversor" class="form-label fw-bold">Modelo Inversor</label>
                            <input type="text" name="modelo_inversor" id="modelo_inversor" class="form-control @error('modelo_inversor') is-invalid @enderror" 
                                   value="{{ old('modelo_inversor') }}" placeholder="Ej: MIN 5000TL-X">
                            @error('modelo_inversor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Descripción --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-card-text me-2"></i>Detalles del Servicio</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción del Trabajo</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" 
                                      placeholder="Descripción detallada del trabajo a realizar...">{{ old('descripcion', isset($ticket) ? $ticket->descripcion : '') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="observaciones" class="form-label fw-bold">Observaciones / Notas para el Técnico</label>
                            <textarea name="observaciones" id="observaciones" rows="3" class="form-control @error('observaciones') is-invalid @enderror" 
                                      placeholder="Instrucciones especiales, accesos, precauciones...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="notas_internas" class="form-label fw-bold"><i class="bi bi-lock me-1 text-warning"></i>Notas Internas</label>
                            <textarea name="notas_internas" id="notas_internas" rows="2" class="form-control @error('notas_internas') is-invalid @enderror" 
                                      placeholder="Notas privadas visibles solo para el equipo...">{{ old('notas_internas') }}</textarea>
                            @error('notas_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.mantenimientos.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-calendar-check me-2"></i>Programar Mantenimiento
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
});
</script>
@endsection
