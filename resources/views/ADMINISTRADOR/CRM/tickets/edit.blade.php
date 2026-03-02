@extends('TEMPLATES.administrador')
@section('title', 'Editar Ticket #' . $ticket->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR TICKET #{{ $ticket->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.tickets.index') }}">Tickets</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $ticket->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                {{-- Info --}}
                <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                    <div class="card-body py-2">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <small class="text-muted">Editando ticket <span class="badge bg-secondary">{{ $ticket->codigo }}</span> — {{ Str::limit($ticket->asunto, 50) }}</small>
                    </div>
                </div>

                <form action="{{ route('admin.crm.tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        {{-- Cliente (solo lectura) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cliente</label>
                            <input type="text" class="form-control" value="{{ $ticket->cliente->nombre ?? $ticket->cliente->razon_social ?? 'N/A' }}" readonly disabled>
                        </div>

                        {{-- Código (solo lectura) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Código de Ticket</label>
                            <input type="text" class="form-control" value="{{ $ticket->codigo }}" readonly disabled>
                        </div>

                        {{-- Asunto --}}
                        <div class="col-md-12">
                            <label for="asunto" class="form-label fw-bold">Asunto <span class="text-danger">*</span></label>
                            <input type="text" name="asunto" id="asunto" class="form-control @error('asunto') is-invalid @enderror" 
                                   value="{{ old('asunto', $ticket->asunto) }}" maxlength="200" required>
                            @error('asunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="col-md-6">
                            <label for="categoria" class="form-label fw-bold">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                                <option value="">Seleccionar categoría...</option>
                                <optgroup label="🔧 Soporte Técnico">
                                    <option value="soporte_paneles" {{ old('categoria', $ticket->categoria) == 'soporte_paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                    <option value="soporte_inversores" {{ old('categoria', $ticket->categoria) == 'soporte_inversores' ? 'selected' : '' }}>⚡ Inversores</option>
                                    <option value="soporte_baterias" {{ old('categoria', $ticket->categoria) == 'soporte_baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                    <option value="soporte_monitoreo" {{ old('categoria', $ticket->categoria) == 'soporte_monitoreo' ? 'selected' : '' }}>📊 Monitoreo</option>
                                    <option value="soporte_estructura" {{ old('categoria', $ticket->categoria) == 'soporte_estructura' ? 'selected' : '' }}>🏗️ Estructura / Cableado</option>
                                </optgroup>
                                <optgroup label="🛠️ Servicios">
                                    <option value="mantenimiento" {{ old('categoria', $ticket->categoria) == 'mantenimiento' ? 'selected' : '' }}>🔩 Mantenimiento</option>
                                    <option value="instalacion" {{ old('categoria', $ticket->categoria) == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                    <option value="garantia" {{ old('categoria', $ticket->categoria) == 'garantia' ? 'selected' : '' }}>🛡️ Garantía</option>
                                </optgroup>
                                <optgroup label="📋 Administrativo">
                                    <option value="facturacion" {{ old('categoria', $ticket->categoria) == 'facturacion' ? 'selected' : '' }}>💰 Facturación / Cobranza</option>
                                    <option value="consulta" {{ old('categoria', $ticket->categoria) == 'consulta' ? 'selected' : '' }}>❓ Consulta General</option>
                                    <option value="reclamo" {{ old('categoria', $ticket->categoria) == 'reclamo' ? 'selected' : '' }}>⚠️ Reclamo</option>
                                </optgroup>
                                <optgroup label="📌 Otro">
                                    <option value="otro" {{ old('categoria', $ticket->categoria) == 'otro' ? 'selected' : '' }}>📋 Otro</option>
                                </optgroup>
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Prioridad --}}
                        <div class="col-md-6">
                            <label for="prioridad" class="form-label fw-bold">Prioridad <span class="text-danger">*</span></label>
                            <select name="prioridad" id="prioridad" class="form-select @error('prioridad') is-invalid @enderror" required>
                                <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>🟢 Baja (48h SLA)</option>
                                <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>🟡 Media (24h SLA)</option>
                                <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>🟠 Alta (8h SLA)</option>
                                <option value="critica" {{ old('prioridad', $ticket->prioridad) == 'critica' ? 'selected' : '' }}>🔴 Crítica (4h SLA)</option>
                            </select>
                            <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>Cambiar la prioridad recalculará el SLA</small>
                            @error('prioridad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción <span class="text-danger">*</span></label>
                            <textarea name="descripcion" id="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Asignar a --}}
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-bold">Asignar a</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id', $ticket->user_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->persona?->name ?? $usuario->name }} {{ $usuario->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Notas Internas --}}
                        <div class="col-12">
                            <label for="notas_internas" class="form-label fw-bold"><i class="bi bi-lock me-1 text-warning"></i>Notas Internas</label>
                            <textarea name="notas_internas" id="notas_internas" rows="3" class="form-control @error('notas_internas') is-invalid @enderror" placeholder="Notas privadas visibles solo para el equipo...">{{ old('notas_internas', $ticket->notas_internas) }}</textarea>
                            @error('notas_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.tickets.show', $ticket) }}" class="btn btn-outline-secondary">
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
