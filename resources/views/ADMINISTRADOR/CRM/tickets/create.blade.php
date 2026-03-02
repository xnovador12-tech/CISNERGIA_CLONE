@extends('TEMPLATES.administrador')
@section('title', 'Nuevo Ticket')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO TICKET DE SOPORTE</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.tickets.index') }}">Tickets</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
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
                        <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios. El SLA se calcula automáticamente según la prioridad.</small>
                    </div>
                </div>

                <form action="{{ route('admin.crm.tickets.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        {{-- Cliente --}}
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

                        {{-- Canal --}}
                        <div class="col-md-6">
                            <label for="canal" class="form-label fw-bold">Canal de Contacto <span class="text-danger">*</span></label>
                            <select name="canal" id="canal" class="form-select @error('canal') is-invalid @enderror" required>
                                <option value="">Seleccionar...</option>
                                <option value="web" {{ old('canal') == 'web' ? 'selected' : '' }}>🌐 Web</option>
                                <option value="email" {{ old('canal') == 'email' ? 'selected' : '' }}>📧 Email</option>
                                <option value="telefono" {{ old('canal') == 'telefono' ? 'selected' : '' }}>📞 Teléfono</option>
                                <option value="whatsapp" {{ old('canal') == 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                                <option value="presencial" {{ old('canal') == 'presencial' ? 'selected' : '' }}>🏢 Presencial</option>
                            </select>
                            @error('canal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Asunto --}}
                        <div class="col-md-12">
                            <label for="asunto" class="form-label fw-bold">Asunto <span class="text-danger">*</span></label>
                            <input type="text" name="asunto" id="asunto" class="form-control @error('asunto') is-invalid @enderror" 
                                   value="{{ old('asunto') }}" placeholder="Descripción breve del problema" maxlength="200" required>
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
                                    <option value="soporte_paneles" {{ old('categoria') == 'soporte_paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                    <option value="soporte_inversores" {{ old('categoria') == 'soporte_inversores' ? 'selected' : '' }}>⚡ Inversores</option>
                                    <option value="soporte_baterias" {{ old('categoria') == 'soporte_baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                    <option value="soporte_monitoreo" {{ old('categoria') == 'soporte_monitoreo' ? 'selected' : '' }}>📊 Monitoreo</option>
                                    <option value="soporte_estructura" {{ old('categoria') == 'soporte_estructura' ? 'selected' : '' }}>🏗️ Estructura / Cableado</option>
                                </optgroup>
                                <optgroup label="🛠️ Servicios">
                                    <option value="mantenimiento" {{ old('categoria') == 'mantenimiento' ? 'selected' : '' }}>🔩 Mantenimiento</option>
                                    <option value="instalacion" {{ old('categoria') == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                    <option value="garantia" {{ old('categoria') == 'garantia' ? 'selected' : '' }}>🛡️ Garantía</option>
                                </optgroup>
                                <optgroup label="📋 Administrativo">
                                    <option value="facturacion" {{ old('categoria') == 'facturacion' ? 'selected' : '' }}>💰 Facturación / Cobranza</option>
                                    <option value="consulta" {{ old('categoria') == 'consulta' ? 'selected' : '' }}>❓ Consulta General</option>
                                    <option value="reclamo" {{ old('categoria') == 'reclamo' ? 'selected' : '' }}>⚠️ Reclamo</option>
                                </optgroup>
                                <optgroup label="📌 Otro">
                                    <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>📋 Otro</option>
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
                                <option value="">Seleccionar...</option>
                                <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>🟢 Baja (48h SLA)</option>
                                <option value="media" {{ old('prioridad', 'media') == 'media' ? 'selected' : '' }}>🟡 Media (24h SLA)</option>
                                <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>🟠 Alta (8h SLA)</option>
                                <option value="critica" {{ old('prioridad') == 'critica' ? 'selected' : '' }}>🔴 Crítica (4h SLA)</option>
                            </select>
                            @error('prioridad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción Detallada <span class="text-danger">*</span></label>
                            <textarea name="descripcion" id="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror" 
                                      placeholder="Describa el problema o consulta en detalle" required>{{ old('descripcion') }}</textarea>
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
                                    <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
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
                            <textarea name="notas_internas" id="notas_internas" rows="3" class="form-control @error('notas_internas') is-invalid @enderror" placeholder="Notas privadas visibles solo para el equipo...">{{ old('notas_internas') }}</textarea>
                            @error('notas_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-ticket-detailed me-2"></i>Crear Ticket
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
