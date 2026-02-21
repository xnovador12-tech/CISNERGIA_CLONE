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
                <form action="{{ route('admin.crm.tickets.store') }}" method="POST" enctype="multipart/form-data">
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

                        {{-- Tipo de Ticket --}}
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-bold">Tipo de Ticket <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccionar...</option>
                                <option value="consulta" {{ old('tipo') == 'consulta' ? 'selected' : '' }}>❓ Consulta</option>
                                <option value="reclamo" {{ old('tipo') == 'reclamo' ? 'selected' : '' }}>⚠️ Reclamo</option>
                                <option value="garantia" {{ old('tipo') == 'garantia' ? 'selected' : '' }}>🛡️ Garantía</option>
                                <option value="soporte_tecnico" {{ old('tipo') == 'soporte_tecnico' ? 'selected' : '' }}>🔧 Soporte Técnico</option>
                                <option value="mantenimiento" {{ old('tipo') == 'mantenimiento' ? 'selected' : '' }}>🔩 Mantenimiento</option>
                                <option value="facturacion" {{ old('tipo') == 'facturacion' ? 'selected' : '' }}>💰 Facturación</option>
                                <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>📋 Otro</option>
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
                                <option value="paneles" {{ old('categoria') == 'paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                <option value="inversor" {{ old('categoria') == 'inversor' ? 'selected' : '' }}>⚡ Inversor</option>
                                <option value="baterias" {{ old('categoria') == 'baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                <option value="estructura" {{ old('categoria') == 'estructura' ? 'selected' : '' }}>🏗️ Estructura</option>
                                <option value="cableado" {{ old('categoria') == 'cableado' ? 'selected' : '' }}>🔌 Cableado</option>
                                <option value="monitoreo" {{ old('categoria') == 'monitoreo' ? 'selected' : '' }}>📊 Monitoreo</option>
                                <option value="produccion" {{ old('categoria') == 'produccion' ? 'selected' : '' }}>📈 Producción</option>
                                <option value="instalacion" {{ old('categoria') == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                <option value="documentacion" {{ old('categoria') == 'documentacion' ? 'selected' : '' }}>📄 Documentación</option>
                                <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>📋 Otro</option>
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

                        {{-- Adjuntos --}}
                        <div class="col-md-6">
                            <label for="adjuntos" class="form-label fw-bold">Archivos Adjuntos</label>
                            <input type="file" name="adjuntos[]" id="adjuntos" class="form-control @error('adjuntos.*') is-invalid @enderror" 
                                   multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="text-muted">Máx. 10MB por archivo. Formatos: jpg, png, pdf, doc</small>
                            @error('adjuntos.*')
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
