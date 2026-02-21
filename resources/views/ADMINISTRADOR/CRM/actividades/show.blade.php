@extends('TEMPLATES.administrador')
@section('title', 'Detalle Actividad')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE ACTIVIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.actividades.index') }}">Actividades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ Str::limit($actividad->titulo, 40) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Info Principal --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            @php 
                                $tipoIcons = ['llamada' => 'telephone', 'reunion' => 'people', 'visita_tecnica' => 'geo-alt', 'email' => 'envelope', 'tarea' => 'check2-square', 'videollamada' => 'camera-video', 'whatsapp' => 'whatsapp', 'nota' => 'file-text'];
                                $tipoColors = ['llamada' => 'primary', 'reunion' => 'success', 'visita_tecnica' => 'warning', 'email' => 'info', 'tarea' => 'secondary', 'videollamada' => 'info', 'whatsapp' => 'success', 'nota' => 'secondary'];
                            @endphp
                            <span class="badge bg-{{ $tipoColors[$actividad->tipo] ?? 'secondary' }} fs-6 me-2">
                                <i class="bi bi-{{ $tipoIcons[$actividad->tipo] ?? 'calendar' }} me-1"></i>{{ ucfirst(str_replace('_', ' ', $actividad->tipo)) }}
                            </span>
                            
                            @php 
                                $estadoColors = ['programada' => 'warning', 'en_progreso' => 'info', 'completada' => 'success', 'cancelada' => 'danger', 'reprogramada' => 'primary', 'no_realizada' => 'secondary']; 
                            @endphp
                            <span class="badge bg-{{ $estadoColors[$actividad->estado] ?? 'secondary' }} fs-6">
                                {{ ucfirst($actividad->estado) }}
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('admin.crm.actividades.edit', $actividad) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">{{ $actividad->titulo }}</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">FECHA Y HORA</p>
                                <p class="fw-bold">
                                    <i class="bi bi-calendar3 me-2"></i>{{ $actividad->fecha_programada->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">DURACIÓN</p>
                                <p class="fw-bold">
                                    <i class="bi bi-clock me-2"></i>{{ $actividad->duracion_minutos ?? 0 }} minutos
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">PRIORIDAD</p>
                                <p class="fw-bold">
                                    @php
                                        $prioridadIcons = ['alta' => '🔴', 'media' => '🟡', 'baja' => '🟢'];
                                    @endphp
                                    {{ $prioridadIcons[$actividad->prioridad] ?? '' }} {{ ucfirst($actividad->prioridad) }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">ASIGNADO A</p>
                                <p class="fw-bold">
                                    <i class="bi bi-person me-2"></i>{{ $actividad->asignadoA->name ?? 'Sin asignar' }}
                                </p>
                            </div>

                            @if($actividad->ubicacion)
                            <div class="col-md-12">
                                <p class="mb-1 text-muted small">UBICACIÓN</p>
                                <p class="fw-bold">
                                    <i class="bi bi-geo-alt me-2"></i>{{ $actividad->ubicacion }}
                                </p>
                            </div>
                            @endif

                            @if($actividad->descripcion)
                            <div class="col-md-12">
                                <p class="mb-1 text-muted small">DESCRIPCIÓN</p>
                                <p class="text-muted">{{ $actividad->descripcion }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Entidad Relacionada --}}
                @if($actividad->activable)
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">RELACIONADO CON</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-muted small">{{ class_basename($actividad->activable_type) }}</p>
                                <h6 class="fw-bold mb-0">
                                    @if($actividad->activable_type == 'App\Models\Prospecto')
                                        {{ $actividad->activable->nombre }}
                                    @elseif($actividad->activable_type == 'App\Models\Oportunidad')
                                        {{ $actividad->activable->codigo }} - {{ $actividad->activable->prospecto->nombre ?? 'N/A' }}
                                    @else
                                        {{ $actividad->activable->nombre ?? 'N/A' }}
                                    @endif
                                </h6>
                            </div>
                            <div>
                                @if($actividad->activable_type == 'App\Models\Prospecto')
                                    <a href="{{ route('admin.crm.prospectos.show', $actividad->activable) }}" class="btn btn-sm btn-outline-primary">
                                        Ver Prospecto
                                    </a>
                                @elseif($actividad->activable_type == 'App\Models\Oportunidad')
                                    <a href="{{ route('admin.crm.oportunidades.show', $actividad->activable) }}" class="btn btn-sm btn-outline-primary">
                                        Ver Oportunidad
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                {{-- Acciones --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">ACCIONES</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($actividad->estado === 'programada' || $actividad->estado === 'en_progreso')
                                <form action="{{ route('admin.crm.actividades.completar', $actividad) }}" method="POST" id="form-completar">
                                    @csrf
                                    <button type="button" class="btn btn-success w-100 btn-completar">
                                        <i class="bi bi-check-circle me-2"></i>Marcar como Completada
                                    </button>
                                </form>

                                <form action="{{ route('admin.crm.actividades.cancelar', $actividad) }}" method="POST" id="form-cancelar">
                                    @csrf
                                    <button type="button" class="btn btn-danger w-100 btn-cancelar">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar Actividad
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.crm.actividades.edit', $actividad) }}" class="btn btn-secondary w-100">
                                <i class="bi bi-pencil me-2"></i>Editar
                            </a>

                            <form action="{{ route('admin.crm.actividades.destroy', $actividad) }}" method="POST" id="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger w-100 btn-eliminar">
                                    <i class="bi bi-trash me-2"></i>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Información Adicional --}}
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">INFORMACIÓN</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">CREADO POR</p>
                            <p class="fw-bold mb-0">{{ $actividad->creadoPor->name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">FECHA DE CREACIÓN</p>
                            <p class="mb-0">{{ $actividad->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($actividad->updated_at != $actividad->created_at)
                        <div>
                            <p class="mb-1 text-muted small">ÚLTIMA ACTUALIZACIÓN</p>
                            <p class="mb-0">{{ $actividad->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        @if($actividad->recordatorio_minutos)
                        <hr>
                        <div>
                            <p class="mb-1 text-muted small">RECORDATORIO</p>
                            <p class="mb-0">
                                <i class="bi bi-bell me-2"></i>{{ $actividad->recordatorio_minutos }} minutos antes
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
$(document).ready(function() {

    // ==================== COMPLETAR ACTIVIDAD ====================
    $('.btn-completar').on('click', function() {
        Swal.fire({
            title: '¿Marcar como completada?',
            html: `La actividad <strong>{{ Str::limit($actividad->titulo, 40) }}</strong> se marcará como <strong class="text-success">Completada</strong>.`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, completar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-completar').submit();
            }
        });
    });

    // ==================== CANCELAR ACTIVIDAD ====================
    $('.btn-cancelar').on('click', function() {
        Swal.fire({
            title: '¿Cancelar actividad?',
            html: `La actividad <strong>{{ Str::limit($actividad->titulo, 40) }}</strong> se marcará como <strong class="text-danger">Cancelada</strong>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Sí, cancelar',
            cancelButtonText: 'Volver'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-cancelar').submit();
            }
        });
    });

    // ==================== ELIMINAR ACTIVIDAD ====================
    $('.btn-eliminar').on('click', function() {
        Swal.fire({
            title: '¿Eliminar actividad?',
            html: `Se eliminará permanentemente la actividad <strong>{{ Str::limit($actividad->titulo, 40) }}</strong>.<br><br>
                   <strong class="text-danger">Esta acción no se puede deshacer.</strong>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-eliminar').submit();
            }
        });
    });

});
</script>
@endsection
