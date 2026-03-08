@extends('TEMPLATES.administrador')
@section('title', 'Ticket #' . $ticket->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">TICKET #{{ $ticket->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.tickets.index') }}">Tickets</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $ticket->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @foreach(['success' => 'success', 'error' => 'danger', 'warning' => 'warning', 'info' => 'info'] as $key => $color)
        @if(session($key))
            <div class="container-fluid mb-3">
                <div class="alert alert-{{ $color }} alert-dismissible fade show">
                    <i class="bi bi-{{ $key === 'error' ? 'x-circle' : ($key === 'success' ? 'check-circle' : 'info-circle') }} me-2"></i>{{ session($key) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
    @endforeach

    <div class="container-fluid">
        <div class="row g-4">
            {{-- Columna Principal --}}
            <div class="col-lg-8">
                {{-- Información del Ticket --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ $ticket->asunto }}</h5>
                        <div class="d-flex gap-2">
                            @php
                                $estadoColors = ['abierto' => 'danger', 'asignado' => 'primary', 'en_progreso' => 'warning', 'pendiente_cliente' => 'info', 'pendiente_proveedor' => 'info', 'resuelto' => 'success', 'reabierto' => 'danger'];
                                $prioridadColors = ['baja' => 'success', 'media' => 'warning', 'alta' => 'danger', 'critica' => 'dark'];
                            @endphp
                            <span class="badge bg-{{ $estadoColors[$ticket->estado] ?? 'secondary' }}">
                                {{ str_replace('_', ' ', ucfirst($ticket->estado)) }}
                            </span>
                            <span class="badge bg-{{ $prioridadColors[$ticket->prioridad] ?? 'secondary' }}">
                                {{ ucfirst($ticket->prioridad) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">Cliente</p>
                                <p class="mb-0 fw-bold">{{ $ticket->cliente->nombre ?? $ticket->cliente->razon_social ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">Categoría</p>
                                <p class="mb-0">
                                    {{ $ticket->categoria_label }}
                                    @if($ticket->componente_afectado)
                                        <br><small class="text-muted"><i class="bi bi-cpu me-1"></i>{{ $ticket->componente_afectado }}</small>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">Creado</p>
                                <p class="mb-0">{{ $ticket->created_at->format('d/m/Y H:i') }} ({{ $tiempoTranscurrido }})</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">SLA</p>
                                <p class="mb-0">
                                    @if($ticket->sla_vencimiento)
                                        @if($ticket->sla_vencimiento->isPast())
                                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> Vencido</span>
                                        @else
                                            <span class="text-success">{{ $tiempoRestanteSla }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Descripción</h6>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($ticket->descripcion)) !!}
                        </div>

                        {{-- Solución (si está resuelto) --}}
                        @if($ticket->solucion)
                            <hr>
                            <h6 class="fw-bold mb-3 text-success"><i class="bi bi-check-circle me-2"></i>Solución</h6>
                            @if($ticket->tipo_solucion)
                                <p class="mb-2">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        {{ str_replace('_', ' ', ucfirst($ticket->tipo_solucion)) }}
                                    </span>
                                </p>
                            @endif
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                {!! nl2br(e($ticket->solucion)) !!}
                            </div>
                        @endif

                        {{-- Notas internas --}}
                        @if($ticket->notas_internas)
                            <hr>
                            <h6 class="fw-bold mb-3 text-warning"><i class="bi bi-lock me-2"></i>Notas Internas</h6>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                {!! nl2br(e($ticket->notas_internas)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Columna Lateral --}}
            <div class="col-lg-4">
                {{-- Acciones --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Acciones</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.crm.tickets.edit', $ticket) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Ticket
                            </a>
                            
                            @if($ticket->estado !== 'resuelto')
                                @php
                                    $tieneMantenimientoActivo = $ticket->mantenimiento
                                        && !in_array($ticket->mantenimiento->estado, ['completado', 'cancelado']);
                                    // Bloqueado solo si hay mantenimiento activo pendiente
                                    // Si el mantenimiento está completado/cancelado se permite resolver manualmente
                                    $resolucionBloqueada = $tieneMantenimientoActivo;
                                @endphp

                                {{-- Soporte/Garantía sin mantenimiento: botón agendar visita --}}
                                @if(in_array($ticket->categoria, ['soporte_tecnico', 'garantia']) && !$ticket->mantenimiento)
                                    <button type="button" class="btn btn-info btn-sm w-100 btn-agendar-visita">
                                        <i class="bi bi-calendar-check me-2"></i>No se pudo resolver — Agendar Visita
                                    </button>

                                    {{-- Form oculto que se submittea desde el SweetAlert --}}
                                    <form action="{{ route('admin.crm.tickets.agendar-visita', $ticket) }}" method="POST" id="form-agendar-visita">
                                        @csrf
                                        <input type="hidden" name="tipo_mantenimiento"  id="hidden-tipo">
                                        <input type="hidden" name="fecha_mantenimiento" id="hidden-fecha">
                                        <input type="hidden" name="hora_mantenimiento"  id="hidden-hora">
                                        <input type="hidden" name="tecnico_id"          id="hidden-tecnico">
                                    </form>
                                @endif

                                @if($resolucionBloqueada)
                                    <div class="alert alert-warning small mb-0 py-2">
                                        <i class="bi bi-tools me-1"></i>
                                        <strong>Resolución bloqueada.</strong>
                                        @if($ticket->mantenimiento)
                                            Completa el mantenimiento
                                            <a href="{{ route('admin.crm.mantenimientos.show', $ticket->mantenimiento) }}" class="fw-bold">
                                                {{ $ticket->mantenimiento->codigo }}
                                            </a> para resolver este ticket automáticamente.
                                        @else
                                            Este ticket se resuelve automáticamente al completar el mantenimiento vinculado.
                                        @endif
                                    </div>
                                @endif

                                @if(!$resolucionBloqueada)
                                    <form action="{{ route('admin.crm.tickets.cambiar-estado', $ticket) }}" method="POST" id="form-resolver">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estado" value="resuelto">
                                        <button type="button" class="btn btn-success btn-sm w-100 btn-resolver">
                                            <i class="bi bi-check-circle me-2"></i>Marcar Resuelto
                                        </button>
                                    </form>
                                @endif


                            @endif

                            <hr class="my-1">
                            <form action="{{ route('admin.crm.tickets.destroy', $ticket) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-2"></i>Eliminar Ticket
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Asignación --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-check me-2"></i>Técnico / Agente</h6>
                        <p class="mb-2">
                            <strong>Responsable:</strong><br>
                            {{ $ticket->asignado?->persona?->name ?? $ticket->asignado?->name ?? 'Sin asignar' }}
                        </p>
                        <p class="mb-3">
                            <strong>Creado por:</strong><br>
                            {{ $ticket->creador?->persona?->name ?? $ticket->creador?->name ?? 'Sistema' }}
                        </p>
                        
                        @if($ticket->estado !== 'resuelto')
                            <form action="{{ route('admin.crm.tickets.asignar', $ticket) }}" method="POST">
                                @csrf
                                <select name="user_id" class="form-select form-select-sm mb-2">
                                    <option value="">Seleccionar agente...</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ $ticket->user_id == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->persona?->name ?? $usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-person-plus me-2"></i>Asignar Responsable
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Información Adicional --}}
                <div class="card border-0 shadow-sm" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Información</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted small">Canal:</td>
                                <td class="small">{{ ucfirst($ticket->canal) }}</td>
                            </tr>
                            @if($ticket->componente_afectado)
                            <tr>
                                <td class="text-muted small">Componente:</td>
                                <td class="small"><i class="bi bi-cpu me-1 text-muted"></i>{{ $ticket->componente_afectado }}</td>
                            </tr>
                            @endif
                            @if($ticket->pedido)
                            <tr>
                                <td class="text-muted small">Pedido:</td>
                                <td class="small">
                                    <span class="badge bg-secondary">{{ $ticket->pedido->codigo }}</span>
                                    <small class="text-muted ms-1">S/ {{ number_format($ticket->pedido->total, 2) }}</small>
                                </td>
                            </tr>
                            @endif
                            @if($ticket->venta)
                            <tr>
                                <td class="text-muted small">Venta:</td>
                                <td class="small">
                                    <span class="badge bg-success">{{ $ticket->venta->codigo }}</span>
                                    @if($ticket->venta->numero_comprobante)
                                        <small class="text-muted ms-1">{{ $ticket->venta->numero_comprobante }}</small>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($ticket->direccion_sistema)
                            <tr>
                                <td class="text-muted small">Dirección:</td>
                                <td class="small"><i class="bi bi-geo-alt text-muted me-1"></i>{{ $ticket->direccion_sistema }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted small">Primera atención:</td>
                                <td class="small">{{ $ticket->fecha_primera_respuesta?->format('d/m/Y H:i') ?? 'Pendiente' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Resolución:</td>
                                <td class="small">{{ $ticket->fecha_resolucion?->format('d/m/Y H:i') ?? 'Pendiente' }}</td>
                            </tr>
                            @if($ticket->mantenimiento)
                                <tr>
                                    <td class="text-muted small">Mantenimiento:</td>
                                    <td class="small">
                                        <a href="{{ route('admin.crm.mantenimientos.show', $ticket->mantenimiento) }}" class="text-decoration-none">
                                            <span class="badge bg-info">{{ $ticket->mantenimiento->codigo }}</span>
                                            <i class="bi bi-box-arrow-up-right small"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Tipo:</td>
                                    <td class="small">{{ ucfirst($ticket->mantenimiento->tipo) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Fecha programada:</td>
                                    <td class="small">
                                        @if($ticket->mantenimiento->fecha_programada)
                                            <span class="{{ $ticket->mantenimiento->fecha_programada->isPast() && $ticket->mantenimiento->estado !== 'completado' ? 'text-danger fw-bold' : '' }}">
                                                {{ $ticket->mantenimiento->fecha_programada->format('d/m/Y') }}
                                                @if($ticket->mantenimiento->hora_programada)
                                                    — {{ \Carbon\Carbon::parse($ticket->mantenimiento->hora_programada)->format('H:i') }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-muted">Sin fecha</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Estado mant.:</td>
                                    <td class="small">
                                        @php
                                            $mantEstadoColors = [
                                                'programado'  => 'primary',
                                                'confirmado'  => 'info',
                                                'en_progreso' => 'warning',
                                                'completado'  => 'success',
                                                'cancelado'   => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $mantEstadoColors[$ticket->mantenimiento->estado] ?? 'secondary' }} bg-opacity-75">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->mantenimiento->estado)) }}
                                        </span>
                                    </td>
                                </tr>
                            @elseif($ticket->es_mantenimiento && $ticket->fecha_mantenimiento)
                                {{-- Ticket mantenimiento recién creado, sin mantenimiento vinculado aún --}}
                                <tr>
                                    <td class="text-muted small">Tipo programado:</td>
                                    <td class="small">{{ ucfirst($ticket->tipo_mantenimiento ?? 'preventivo') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Fecha programada:</td>
                                    <td class="small">
                                        {{ $ticket->fecha_mantenimiento->format('d/m/Y') }}
                                        @if($ticket->hora_mantenimiento)
                                            — {{ \Carbon\Carbon::parse($ticket->hora_mantenimiento)->format('H:i') }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>

                        {{-- Adjuntos --}}
                        @if($ticket->adjuntos && count($ticket->adjuntos) > 0)
                        <hr class="my-2">
                        <h6 class="fw-bold mb-2"><i class="bi bi-paperclip me-2"></i>Adjuntos</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($ticket->adjuntos as $i => $path)
                                @php $ext = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                <a href="{{ Storage::url($path) }}" target="_blank"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-{{ $ext === 'pdf' ? 'file-pdf text-danger' : 'image text-info' }} me-1"></i>
                                    {{ $ext === 'pdf' ? 'PDF' : 'Imagen' }} {{ $i + 1 }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.crm.tickets.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver al listado
            </a>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ==================== AGENDAR VISITA TÉCNICA ====================
    @if(in_array($ticket->categoria, ['soporte_tecnico', 'garantia']))
    @php
        $tecnicos = \App\Models\User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $tecnicoOptions = '<option value="">Sin asignar</option>';
        foreach ($tecnicos as $tec) {
            $nombre = e($tec->persona?->name ?? $tec->name);
            $sel = $ticket->user_id == $tec->id ? 'selected' : '';
            $tecnicoOptions .= "<option value=\"{$tec->id}\" {$sel}>{$nombre}</option>";
        }
    @endphp

    $('.btn-agendar-visita').on('click', function() {
        const hoy = new Date().toISOString().split('T')[0];
        Swal.fire({
            title: 'Agendar Visita Técnica',
            width: 520,
            padding: '1.5rem',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tipo de mantenimiento <span class="text-danger">*</span></label>
                        <select id="swal-tipo" class="form-select form-select-sm">
                            <option value="correctivo" selected>Correctivo</option>
                            <option value="preventivo">Preventivo</option>
                            <option value="limpieza">Limpieza</option>
                            <option value="inspeccion">Inspección</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:10px; margin-bottom:1rem;">
                        <div style="flex:1">
                            <label class="form-label fw-bold small">Fecha <span class="text-danger">*</span></label>
                            <input type="date" id="swal-fecha" class="form-control form-control-sm" min="${hoy}">
                        </div>
                        <div style="flex:0 0 130px">
                            <label class="form-label fw-bold small">Hora</label>
                            <input type="time" id="swal-hora" class="form-control form-control-sm" value="09:00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Técnico responsable</label>
                        <select id="swal-tecnico" class="form-select form-select-sm">
                            {!! $tecnicoOptions !!}
                        </select>
                    </div>
                    <div class="alert alert-info py-2 mb-0 small">
                        <i class="bi bi-info-circle me-1"></i>
                        El ticket pasará a <strong>En progreso</strong> y se resolverá al completar la visita.
                    </div>
                </div>`,
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-calendar-check me-1"></i> Agendar Visita',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const fecha = document.getElementById('swal-fecha').value;
                if (!fecha) {
                    Swal.showValidationMessage('La fecha es requerida');
                    return false;
                }
                return {
                    tipo:    document.getElementById('swal-tipo').value,
                    fecha:   fecha,
                    hora:    document.getElementById('swal-hora').value,
                    tecnico: document.getElementById('swal-tecnico').value,
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#hidden-tipo').val(result.value.tipo);
                $('#hidden-fecha').val(result.value.fecha);
                $('#hidden-hora').val(result.value.hora);
                $('#hidden-tecnico').val(result.value.tecnico);
                $('#form-agendar-visita').submit();
            }
        });
    });
    @endif

    // ==================== MARCAR RESUELTO (con solución) ====================
    $('.btn-resolver').on('click', function() {
        Swal.fire({
            title: 'Resolver Ticket',
            width: 520,
            padding: '1.5rem',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tipo de resolución</label>
                        <select id="swal-tipo-solucion" class="form-select form-select-sm">
                            <option value="">Seleccionar...</option>
                            <option value="resuelto_remoto">Resuelto de forma remota</option>
                            <option value="visita_tecnica">Visita técnica realizada</option>
                            <option value="cambio_equipo">Cambio / reemplazo de equipo</option>
                            <option value="ajuste_configuracion">Ajuste de configuración</option>
                            <option value="garantia_aplicada">Garantía aplicada</option>
                            <option value="derivado_proveedor">Derivado al proveedor</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Descripción de la solución <span class="text-danger">*</span></label>
                        <textarea id="swal-solucion" class="form-control form-control-sm" rows="3" placeholder="Describe cómo se resolvió el ticket..."></textarea>
                    </div>
                    <div class="border rounded p-2 bg-light">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="swal-seguimiento">
                            <label class="form-check-label fw-bold small" for="swal-seguimiento">
                                Requiere seguimiento
                            </label>
                        </div>
                        <div id="bloque-dias" style="display:none; margin-top:8px;">
                            <label class="form-label small mb-1">Verificar en (días)</label>
                            <input type="number" id="swal-dias" class="form-control form-control-sm" value="7" min="1" max="90" style="width:100px">
                            <small class="text-muted">Se creará una actividad de seguimiento para recordártelo.</small>
                        </div>
                    </div>
                </div>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Resolver',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                document.getElementById('swal-seguimiento').addEventListener('change', function() {
                    document.getElementById('bloque-dias').style.display = this.checked ? 'block' : 'none';
                });
            },
            preConfirm: () => {
                const solucion = document.getElementById('swal-solucion').value;
                if (!solucion.trim()) {
                    Swal.showValidationMessage('La descripción de la solución es requerida');
                    return false;
                }
                return {
                    solucion,
                    tipoSolucion:       document.getElementById('swal-tipo-solucion').value,
                    requiereSeguimiento: document.getElementById('swal-seguimiento').checked,
                    diasSeguimiento:    document.getElementById('swal-dias').value,
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('<input>').attr({ type: 'hidden', name: 'solucion',             value: result.value.solucion }).appendTo('#form-resolver');
                $('<input>').attr({ type: 'hidden', name: 'tipo_solucion',        value: result.value.tipoSolucion }).appendTo('#form-resolver');
                $('<input>').attr({ type: 'hidden', name: 'requiere_seguimiento', value: result.value.requiereSeguimiento ? '1' : '0' }).appendTo('#form-resolver');
                $('<input>').attr({ type: 'hidden', name: 'dias_seguimiento',     value: result.value.diasSeguimiento }).appendTo('#form-resolver');
                $('#form-resolver').submit();
            }
        });
    });

    // ==================== ELIMINAR TICKET ====================
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Eliminar ticket?',
            text: 'Esta acción no se puede revertir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
@endsection
