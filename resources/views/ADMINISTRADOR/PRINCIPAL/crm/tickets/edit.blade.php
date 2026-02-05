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

                        {{-- Tipo de Ticket --}}
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-bold">Tipo de Ticket <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="consulta" {{ old('tipo', $ticket->tipo) == 'consulta' ? 'selected' : '' }}>❓ Consulta</option>
                                <option value="reclamo" {{ old('tipo', $ticket->tipo) == 'reclamo' ? 'selected' : '' }}>⚠️ Reclamo</option>
                                <option value="garantia" {{ old('tipo', $ticket->tipo) == 'garantia' ? 'selected' : '' }}>🛡️ Garantía</option>
                                <option value="soporte_tecnico" {{ old('tipo', $ticket->tipo) == 'soporte_tecnico' ? 'selected' : '' }}>🔧 Soporte Técnico</option>
                                <option value="mantenimiento" {{ old('tipo', $ticket->tipo) == 'mantenimiento' ? 'selected' : '' }}>🔩 Mantenimiento</option>
                                <option value="facturacion" {{ old('tipo', $ticket->tipo) == 'facturacion' ? 'selected' : '' }}>💰 Facturación</option>
                                <option value="otro" {{ old('tipo', $ticket->tipo) == 'otro' ? 'selected' : '' }}>📋 Otro</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría (Componente) --}}
                        <div class="col-md-6">
                            <label for="categoria" class="form-label fw-bold">Categoría (Componente)</label>
                            <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror">
                                <option value="">Seleccionar (opcional)...</option>
                                <option value="paneles" {{ old('categoria', $ticket->categoria) == 'paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                <option value="inversor" {{ old('categoria', $ticket->categoria) == 'inversor' ? 'selected' : '' }}>⚡ Inversor</option>
                                <option value="baterias" {{ old('categoria', $ticket->categoria) == 'baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                <option value="estructura" {{ old('categoria', $ticket->categoria) == 'estructura' ? 'selected' : '' }}>🏗️ Estructura</option>
                                <option value="cableado" {{ old('categoria', $ticket->categoria) == 'cableado' ? 'selected' : '' }}>🔌 Cableado</option>
                                <option value="monitoreo" {{ old('categoria', $ticket->categoria) == 'monitoreo' ? 'selected' : '' }}>📊 Monitoreo</option>
                                <option value="produccion" {{ old('categoria', $ticket->categoria) == 'produccion' ? 'selected' : '' }}>📈 Producción</option>
                                <option value="instalacion" {{ old('categoria', $ticket->categoria) == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                <option value="documentacion" {{ old('categoria', $ticket->categoria) == 'documentacion' ? 'selected' : '' }}>📄 Documentación</option>
                                <option value="otro" {{ old('categoria', $ticket->categoria) == 'otro' ? 'selected' : '' }}>📋 Otro</option>
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
