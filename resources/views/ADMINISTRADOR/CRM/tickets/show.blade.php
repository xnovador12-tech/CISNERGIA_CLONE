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

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

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
                                $estadoColors = ['abierto' => 'danger', 'en_progreso' => 'warning', 'pendiente_cliente' => 'info', 'resuelto' => 'success', 'cerrado' => 'secondary'];
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
                                <p class="mb-0">{{ ucfirst(str_replace('_', ' ', $ticket->categoria)) }}</p>
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

                        @if($ticket->adjuntos && count($ticket->adjuntos) > 0)
                            <hr>
                            <h6 class="fw-bold mb-3">Archivos Adjuntos</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ticket->adjuntos as $adjunto)
                                    <a href="{{ Storage::url($adjunto['path']) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-paperclip me-1"></i>{{ $adjunto['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Conversación --}}
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2"></i>Conversación</h5>
                    </div>
                    <div class="card-body">
                        @forelse($ticket->mensajes as $mensaje)
                            <div class="d-flex mb-3 {{ $mensaje->es_interno ? 'justify-content-end' : '' }}">
                                <div class="card {{ $mensaje->es_interno ? 'bg-warning bg-opacity-10' : 'bg-light' }}" style="max-width: 80%">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold small">
                                                {{ $mensaje->usuario?->persona?->name ?? $mensaje->usuario?->name ?? 'Sistema' }}
                                            </span>
                                            <small class="text-muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <p class="mb-0">{!! nl2br(e($mensaje->mensaje)) !!}</p>
                                        @if($mensaje->es_interno)
                                            <small class="text-warning"><i class="bi bi-lock me-1"></i>Nota interna</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-chat fs-1 d-block mb-2"></i>
                                No hay mensajes aún
                            </div>
                        @endforelse

                        @if(!in_array($ticket->estado, ['resuelto', 'cerrado']))
                            <hr>
                            <form action="{{ route('admin.crm.tickets.mensaje', $ticket) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="mensaje" class="form-control" rows="3" placeholder="Escribir respuesta..." required></textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="es_interno" id="es_interno" value="1">
                                        <label class="form-check-label" for="es_interno">
                                            <i class="bi bi-lock me-1"></i>Nota interna
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-send me-2"></i>Enviar
                                    </button>
                                </div>
                            </form>
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
                                <form action="{{ route('admin.crm.tickets.cambiar-estado', $ticket) }}" method="POST" id="form-resolver">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="resuelto">
                                    <button type="button" class="btn btn-success btn-sm w-100 btn-resolver">
                                        <i class="bi bi-check-circle me-2"></i>Marcar Resuelto
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.crm.tickets.escalar', $ticket) }}" method="POST" id="form-escalar">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm w-100 btn-escalar">
                                        <i class="bi bi-arrow-up-circle me-2"></i>Escalar Ticket
                                    </button>
                                </form>
                            @endif
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
                            @if($ticket->satisfaccion)
                                <tr>
                                    <td class="text-muted">Satisfacción:</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $ticket->satisfaccion ? '-fill text-warning' : '' }}"></i>
                                        @endfor
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

    // ==================== MARCAR RESUELTO ====================
    $('.btn-resolver').on('click', function() {
        Swal.fire({
            title: '¿Marcar como Resuelto?',
            html: `El ticket <strong>{{ $ticket->codigo }}</strong> se marcará como <strong class="text-success">Resuelto</strong>.<br><br>
                   <small class="text-muted">Se registrará la fecha de resolución.</small>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, resolver',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-resolver').submit();
            }
        });
    });

    // ==================== ESCALAR TICKET ====================
    $('.btn-escalar').on('click', function() {
        Swal.fire({
            title: '¿Escalar ticket?',
            html: `El ticket <strong>{{ $ticket->codigo }}</strong> será escalado a un nivel superior de atención.<br><br>
                   <small class="text-muted">Se incrementará la prioridad y se notificará al supervisor.</small>`,
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

});
</script>
@endsection
