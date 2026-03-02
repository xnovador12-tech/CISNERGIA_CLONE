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
                                $estadoColors = ['abierto' => 'danger', 'asignado' => 'primary', 'en_progreso' => 'warning', 'pendiente_cliente' => 'info', 'pendiente_proveedor' => 'info', 'resuelto' => 'success', 'cerrado' => 'secondary', 'reabierto' => 'danger'];
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
                                <p class="mb-0">{{ $ticket->categoria_label }}</p>
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
                            
                            @if(!in_array($ticket->estado, ['resuelto', 'cerrado']))
                                {{-- Mantenimiento: Programar si no tiene uno vinculado --}}
                                @if($ticket->es_mantenimiento && !$ticket->mantenimiento)
                                    <form action="{{ route('admin.crm.tickets.cambiar-estado', $ticket) }}" method="POST" id="form-programar">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estado" value="en_progreso">
                                        <input type="hidden" name="programar_mantenimiento" value="1">
                                        <button type="button" class="btn btn-info btn-sm w-100 btn-programar">
                                            <i class="bi bi-tools me-2"></i>Programar Mantenimiento
                                        </button>
                                    </form>
                                @endif

                                {{-- Mantenimiento pendiente: aviso --}}
                                @if($ticket->mantenimiento && !in_array($ticket->mantenimiento->estado, ['completado', 'cancelado']))
                                    <div class="alert alert-info small mb-0 py-2">
                                        <i class="bi bi-hourglass-split me-1"></i>
                                        El ticket se resolverá automáticamente al completar el mantenimiento
                                        <a href="{{ route('admin.crm.mantenimientos.show', $ticket->mantenimiento) }}">{{ $ticket->mantenimiento->codigo }}</a>.
                                    </div>
                                @endif

                                {{-- Resolver manual: solo si NO es tipo mantenimiento, o si mantenimiento ya completado/cancelado --}}
                                @if(!$ticket->es_mantenimiento || ($ticket->mantenimiento && in_array($ticket->mantenimiento->estado, ['completado', 'cancelado'])))
                                    <form action="{{ route('admin.crm.tickets.cambiar-estado', $ticket) }}" method="POST" id="form-resolver">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estado" value="resuelto">
                                        <button type="button" class="btn btn-success btn-sm w-100 btn-resolver">
                                            <i class="bi bi-check-circle me-2"></i>Marcar Resuelto
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.crm.tickets.escalar', $ticket) }}" method="POST" id="form-escalar">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm w-100 btn-escalar">
                                        <i class="bi bi-arrow-up-circle me-2"></i>Escalar Ticket
                                    </button>
                                </form>
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
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-check me-2"></i>Asignación</h6>
                        <p class="mb-2">
                            <strong>Asignado a:</strong><br>
                            {{ $ticket->asignado?->persona?->name ?? $ticket->asignado?->name ?? 'Sin asignar' }}
                        </p>
                        <p class="mb-3">
                            <strong>Creado por:</strong><br>
                            {{ $ticket->creador?->persona?->name ?? $ticket->creador?->name ?? 'Sistema' }}
                        </p>
                        
                        @if(!in_array($ticket->estado, ['resuelto', 'cerrado']))
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
                                    <i class="bi bi-person-plus me-2"></i>Reasignar
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
                                <td class="text-muted">Canal:</td>
                                <td>{{ ucfirst($ticket->canal) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Primera Respuesta:</td>
                                <td>{{ $ticket->fecha_primera_respuesta?->format('d/m/Y H:i') ?? 'Pendiente' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Resolución:</td>
                                <td>{{ $ticket->fecha_resolucion?->format('d/m/Y H:i') ?? 'Pendiente' }}</td>
                            </tr>
                            @if($ticket->mantenimiento)
                                <tr>
                                    <td class="text-muted">Mantenimiento:</td>
                                    <td>
                                        <a href="{{ route('admin.crm.mantenimientos.show', $ticket->mantenimiento) }}" class="text-decoration-none">
                                            <span class="badge bg-info">{{ $ticket->mantenimiento->codigo }}</span>
                                            <i class="bi bi-box-arrow-up-right small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </table>
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

    // ==================== PROGRAMAR MANTENIMIENTO ====================
    $('.btn-programar').on('click', function() {
        Swal.fire({
            title: 'Programar Mantenimiento',
            html: `El ticket <strong>{{ $ticket->codigo }}</strong> pasará a <strong class="text-warning">En progreso</strong> y se creará un mantenimiento.<br><br>
                   <small class="text-muted">El ticket se resolverá automáticamente al completar el mantenimiento.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-tools me-1"></i> Programar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-programar').submit();
            }
        });
    });

    // ==================== MARCAR RESUELTO (con solución) ====================
    @php
        $tiposSolucion = [
            'resuelto_remoto' => 'Resuelto remoto',
            'visita_tecnica' => 'Visita técnica',
            'cambio_equipo' => 'Cambio de equipo',
            'ajuste_configuracion' => 'Ajuste de configuración',
            'capacitacion' => 'Capacitación',
            'sin_solucion' => 'Sin solución',
            'otro' => 'Otro',
        ];
    @endphp

    $('.btn-resolver').on('click', function() {
        Swal.fire({
            title: 'Resolver Ticket',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tipo de solución</label>
                        <select id="swal-tipo-solucion" class="form-select form-select-sm">
                            <option value="">Seleccionar...</option>
                            @foreach($tiposSolucion as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold small">Descripción de la solución</label>
                        <textarea id="swal-solucion" class="form-control form-control-sm" rows="3" placeholder="Describe cómo se resolvió el ticket..."></textarea>
                    </div>
                </div>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Resolver',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const solucion = document.getElementById('swal-solucion').value;
                const tipoSolucion = document.getElementById('swal-tipo-solucion').value;
                if (!solucion.trim()) {
                    Swal.showValidationMessage('La descripción de la solución es requerida');
                    return false;
                }
                return { solucion, tipoSolucion };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('<input>').attr({ type: 'hidden', name: 'solucion', value: result.value.solucion }).appendTo('#form-resolver');
                $('<input>').attr({ type: 'hidden', name: 'tipo_solucion', value: result.value.tipoSolucion }).appendTo('#form-resolver');
                $('#form-resolver').submit();
            }
        });
    });

    // ==================== ESCALAR TICKET ====================
    $('.btn-escalar').on('click', function() {
        Swal.fire({
            title: '¿Escalar ticket?',
            html: `El ticket <strong>{{ $ticket->codigo }}</strong> será escalado a un nivel superior de atención.<br><br>
                   <small class="text-muted">Se incrementará la prioridad.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-arrow-up-circle me-1"></i> Sí, escalar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-escalar').submit();
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
