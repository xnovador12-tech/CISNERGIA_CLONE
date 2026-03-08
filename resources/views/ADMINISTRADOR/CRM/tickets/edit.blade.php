@extends('TEMPLATES.administrador')
@section('title', 'Editar Ticket #' . $ticket->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR TICKET #{{ $ticket->codigo }}</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.tickets.index') }}">Tickets</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.tickets.show', $ticket) }}">{{ $ticket->codigo }}</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">

                <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17,17,26,0.1) 0px 1px 0px; background-color:#f6f6f6">
                    <div class="card-body py-2">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <small class="text-muted">
                            Editando <span class="badge bg-secondary">{{ $ticket->codigo }}</span>
                            — {{ Str::limit($ticket->asunto, 60) }}
                        </small>
                    </div>
                </div>

                <form action="{{ route('admin.crm.tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ── BLOQUE 1: Cabecera (Cliente read-only + Código + Prioridad) ── --}}
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cliente</label>
                            <input type="text" class="form-control bg-light"
                                   value="{{ $ticket->cliente->nombre_completo ?? 'N/A' }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Código</label>
                            <input type="text" class="form-control bg-light" value="{{ $ticket->codigo }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label for="prioridad" class="form-label fw-bold">Prioridad <span class="text-danger">*</span></label>
                            <select name="prioridad" id="prioridad" class="form-select select2_bootstrap_2 @error('prioridad') is-invalid @enderror" required>
                                <option value="baja"    {{ old('prioridad', $ticket->prioridad) == 'baja'    ? 'selected' : '' }}>🟢 Baja — 72h</option>
                                <option value="media"   {{ old('prioridad', $ticket->prioridad) == 'media'   ? 'selected' : '' }}>🟡 Media — 48h</option>
                                <option value="alta"    {{ old('prioridad', $ticket->prioridad) == 'alta'    ? 'selected' : '' }}>🟠 Alta — 24h</option>
                                <option value="critica" {{ old('prioridad', $ticket->prioridad) == 'critica' ? 'selected' : '' }}>🔴 Crítica — 4h</option>
                            </select>
                            <div class="form-text text-warning"><i class="bi bi-exclamation-triangle me-1"></i>Cambiar recalcula el SLA</div>
                            @error('prioridad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="col-md-6">
                            <label for="categoria" class="form-label fw-bold">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria" id="categoria" class="form-select select2_bootstrap_2 @error('categoria') is-invalid @enderror" required>
                                <option value="">Seleccionar categoría...</option>
                                <option value="mantenimiento"    {{ old('categoria', $ticket->categoria) == 'mantenimiento'    ? 'selected' : '' }}>🔩 Mantenimiento</option>
                                <option value="soporte_tecnico"  {{ old('categoria', $ticket->categoria) == 'soporte_tecnico'  ? 'selected' : '' }}>🔧 Soporte Técnico</option>
                                <option value="garantia"         {{ old('categoria', $ticket->categoria) == 'garantia'         ? 'selected' : '' }}>🛡️ Garantía</option>
                                <option value="facturacion"      {{ old('categoria', $ticket->categoria) == 'facturacion'      ? 'selected' : '' }}>💰 Facturación / Cobranza</option>
                                <option value="consulta_reclamo" {{ old('categoria', $ticket->categoria) == 'consulta_reclamo' ? 'selected' : '' }}>❓ Consulta / Reclamo</option>
                            </select>
                            @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Asunto --}}
                        <div class="col-md-6">
                            <label for="asunto" class="form-label fw-bold">Asunto <span class="text-danger">*</span></label>
                            <input type="text" name="asunto" id="asunto"
                                   class="form-control @error('asunto') is-invalid @enderror"
                                   value="{{ old('asunto', $ticket->asunto) }}" maxlength="200" required>
                            @error('asunto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── BLOQUE DINÁMICO: Mantenimiento ── --}}
                    <div id="bloque-mantenimiento" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-primary" style="background:#f0f4ff">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-primary-emphasis"><i class="bi bi-tools me-1"></i>Datos del Mantenimiento</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_mantenimiento" class="form-label fw-bold">Tipo</label>
                            <select name="tipo_mantenimiento" id="tipo_mantenimiento" class="form-select select2_bootstrap_2 @error('tipo_mantenimiento') is-invalid @enderror">
                                <option value="preventivo" {{ old('tipo_mantenimiento', $ticket->tipo_mantenimiento) == 'preventivo' ? 'selected' : '' }}>Preventivo</option>
                                <option value="correctivo" {{ old('tipo_mantenimiento', $ticket->tipo_mantenimiento) == 'correctivo' ? 'selected' : '' }}>Correctivo</option>
                                <option value="limpieza"   {{ old('tipo_mantenimiento', $ticket->tipo_mantenimiento) == 'limpieza'   ? 'selected' : '' }}>Limpieza</option>
                                <option value="inspeccion" {{ old('tipo_mantenimiento', $ticket->tipo_mantenimiento) == 'inspeccion' ? 'selected' : '' }}>Inspección</option>
                                <option value="predictivo" {{ old('tipo_mantenimiento', $ticket->tipo_mantenimiento) == 'predictivo' ? 'selected' : '' }}>Predictivo</option>
                            </select>
                            @error('tipo_mantenimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_mantenimiento" class="form-label fw-bold">Fecha Programada</label>
                            <input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento"
                                   class="form-control @error('fecha_mantenimiento') is-invalid @enderror"
                                   value="{{ old('fecha_mantenimiento', $ticket->fecha_mantenimiento?->toDateString()) }}">
                            @error('fecha_mantenimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="hora_mantenimiento" class="form-label fw-bold">Hora</label>
                            <input type="time" name="hora_mantenimiento" id="hora_mantenimiento"
                                   class="form-control @error('hora_mantenimiento') is-invalid @enderror"
                                   value="{{ old('hora_mantenimiento', $ticket->hora_mantenimiento) }}">
                            @error('hora_mantenimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── BLOQUE DINÁMICO: Soporte Técnico + Garantía ── --}}
                    <div id="bloque-tecnico" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-warning" style="background:#fffbf0">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-warning-emphasis"><i class="bi bi-tools me-1"></i>Datos del Sistema Solar</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="componente_afectado" class="form-label fw-bold">Componente Afectado</label>
                            <input type="text" name="componente_afectado" id="componente_afectado"
                                   class="form-control @error('componente_afectado') is-invalid @enderror"
                                   value="{{ old('componente_afectado', $ticket->componente_afectado) }}"
                                   placeholder="Ej: Inversor Fronius 5kW, Panel 400W...">
                            @error('componente_afectado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pedido_id" class="form-label fw-bold">Pedido de Referencia</label>
                            <select name="pedido_id" id="pedido_id" class="form-select select2_bootstrap_2 @error('pedido_id') is-invalid @enderror">
                                <option value="">Sin referencia</option>
                                @foreach($pedidos as $p)
                                    <option value="{{ $p->id }}"
                                            data-direccion="{{ $p->direccion_instalacion }}"
                                            {{ old('pedido_id', $ticket->pedido_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->codigo }} — S/ {{ number_format($p->total, 2) }} ({{ ucfirst($p->estado) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pedido_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="direccion_sistema" class="form-label fw-bold">Dirección del Sistema</label>
                            <input type="text" name="direccion_sistema" id="direccion_sistema"
                                   class="form-control @error('direccion_sistema') is-invalid @enderror"
                                   value="{{ old('direccion_sistema', $ticket->direccion_sistema) }}"
                                   placeholder="Se completa automáticamente al seleccionar un pedido" maxlength="255">
                            @error('direccion_sistema') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── BLOQUE DINÁMICO: Facturación ── --}}
                    <div id="bloque-facturacion" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-success" style="background:#f0fff4">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-success-emphasis"><i class="bi bi-receipt me-1"></i>Referencia de Venta</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="venta_id" class="form-label fw-bold">Venta / Comprobante</label>
                            <select name="venta_id" id="venta_id" class="form-select select2_bootstrap_2 @error('venta_id') is-invalid @enderror">
                                <option value="">Sin referencia</option>
                                @foreach($ventas as $v)
                                    <option value="{{ $v->id }}"
                                            {{ old('venta_id', $ticket->venta_id) == $v->id ? 'selected' : '' }}>
                                        {{ $v->codigo }} · {{ $v->numero_comprobante ?? 'Sin comprobante' }} — S/ {{ number_format($v->total, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venta_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── BLOQUE 3: Descripción + Adjuntos ── --}}
                    <div class="row g-3 mt-1">
                        <div class="col-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción <span class="text-danger">*</span></label>
                            <textarea name="descripcion" id="descripcion" rows="5"
                                      class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
                            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Adjuntos existentes --}}
                        @if($ticket->adjuntos && count($ticket->adjuntos) > 0)
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="bi bi-paperclip me-1"></i>Adjuntos actuales</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ticket->adjuntos as $i => $path)
                                    @php $ext = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                    <a href="{{ Storage::url($path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-{{ $ext === 'pdf' ? 'file-pdf text-danger' : 'image text-primary' }} me-1"></i>
                                        Archivo {{ $i + 1 }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="form-text">Los adjuntos existentes se conservan. Los nuevos se agregarán.</div>
                        </div>
                        @endif

                        <div class="col-12">
                            <label for="adjuntos_nuevos" class="form-label fw-bold">
                                <i class="bi bi-paperclip me-1"></i>Agregar Evidencias
                                <span class="text-muted fw-normal small">(máx. 5MB c/u · jpg, png, pdf)</span>
                            </label>
                            <input type="file" name="adjuntos[]" id="adjuntos_nuevos"
                                   class="form-control" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                    {{-- ── BLOQUE 4: Asignación + Canal + Notas ── --}}
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="user_id" class="form-label fw-bold">Técnico / Agente Responsable</label>
                            <select name="user_id" id="user_id" class="form-select select2_bootstrap_2 @error('user_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}" {{ old('user_id', $ticket->user_id) == $u->id ? 'selected' : '' }}>
                                        {{ $u->persona?->name ?? $u->name }} {{ $u->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="canal" class="form-label fw-bold">Canal de Contacto</label>
                            <select name="canal" id="canal" class="form-select select2_bootstrap_2 @error('canal') is-invalid @enderror">
                                <option value="whatsapp"  {{ old('canal', $ticket->canal) == 'whatsapp'  ? 'selected' : '' }}>💬 WhatsApp</option>
                                <option value="telefono"  {{ old('canal', $ticket->canal) == 'telefono'  ? 'selected' : '' }}>📞 Teléfono</option>
                                <option value="email"     {{ old('canal', $ticket->canal) == 'email'     ? 'selected' : '' }}>📧 Email</option>
                                <option value="presencial"{{ old('canal', $ticket->canal) == 'presencial'? 'selected' : '' }}>🏢 Presencial</option>
                                <option value="web"       {{ old('canal', $ticket->canal) == 'web'       ? 'selected' : '' }}>🌐 Web</option>
                            </select>
                            @error('canal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="notas_internas" class="form-label fw-bold">
                                <i class="bi bi-lock me-1 text-warning"></i>Notas Internas
                            </label>
                            <textarea name="notas_internas" id="notas_internas" rows="1"
                                      class="form-control @error('notas_internas') is-invalid @enderror"
                                      placeholder="Notas privadas del equipo...">{{ old('notas_internas', $ticket->notas_internas) }}</textarea>
                            @error('notas_internas') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

@section('js')
<script>
$(document).ready(function () {

    // ── Select2 ──────────────────────────────────────────────────────────
    $('#categoria, #prioridad, #user_id, #canal, #pedido_id, #venta_id, #tipo_mantenimiento').select2({
        theme: 'bootstrap-5', allowClear: true, width: '100%'
    });

    // ── Mostrar/ocultar bloques según categoría ──────────────────────────
    function actualizarBloques(cat) {
        const esMant        = (cat === 'mantenimiento');
        const esTecnico     = (cat === 'soporte_tecnico' || cat === 'garantia');
        const esFacturacion = (cat === 'facturacion');

        $('#bloque-mantenimiento').toggleClass('d-none', !esMant);
        $('#bloque-tecnico').toggleClass('d-none', !(esTecnico || esMant));
        $('#bloque-facturacion').toggleClass('d-none', !esFacturacion);
    }

    // Inicializar con la categoría actual del ticket
    actualizarBloques('{{ old('categoria', $ticket->categoria) }}');

    $('#categoria').on('change', function () {
        actualizarBloques($(this).val());
    });

    // Auto-rellenar dirección al cambiar pedido
    $('#pedido_id').on('change', function () {
        const dir = $('option:selected', this).data('direccion');
        if (dir) $('#direccion_sistema').val(dir);
    });
});
</script>
@endsection
