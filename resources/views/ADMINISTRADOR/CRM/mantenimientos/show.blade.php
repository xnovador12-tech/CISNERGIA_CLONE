@extends('TEMPLATES.administrador')
@section('title', 'Mantenimiento ' . $mantenimiento->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-up">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">MANTENIMIENTO {{ $mantenimiento->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.mantenimientos.index') }}">Mantenimientos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $mantenimiento->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-4">
            {{-- Columna Principal --}}
            <div class="col-lg-8">
                {{-- Estado y Tipo --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            @php
                                $tipoIcons = ['preventivo' => '🔧', 'correctivo' => '🔩', 'predictivo' => '📊', 'limpieza' => '🧹', 'inspeccion' => '🔍'];
                            @endphp
                            {{ $tipoIcons[$mantenimiento->tipo] ?? '🛠️' }} {{ ucfirst($mantenimiento->tipo) }}
                        </h5>
                        @php
                            $estadoColors = [
                                'programado'  => 'info',
                                'confirmado'  => 'primary',
                                'en_progreso' => 'warning',
                                'completado'  => 'success',
                                'cancelado'   => 'danger',
                            ];
                        @endphp
                        <span class="badge bg-{{ $estadoColors[$mantenimiento->estado] ?? 'secondary' }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $mantenimiento->estado)) }}
                        </span>
                    </div>
                    <div class="card-body">
                        {{-- Título del Mantenimiento --}}
                        <h4 class="mb-3">{{ $mantenimiento->titulo }}</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <p class="text-muted mb-1 small"><i class="bi bi-calendar me-1"></i>Fecha Programada</p>
                                    <h5 class="mb-0 fw-bold">{{ $mantenimiento->fecha_programada?->format('d/m/Y') ?? 'N/A' }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <p class="text-muted mb-1 small"><i class="bi bi-clock me-1"></i>Hora</p>
                                    <h5 class="mb-0 fw-bold">{{ $mantenimiento->hora_programada ?? 'Por definir' }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <p class="text-muted mb-1 small"><i class="bi bi-hourglass me-1"></i>Duración Est.</p>
                                    <h5 class="mb-0 fw-bold">{{ $mantenimiento->duracion_estimada_horas ?? 2 }} horas</h5>
                                </div>
                            </div>
                        </div>

                        @if($mantenimiento->descripcion)
                            <hr>
                            <h6 class="fw-bold mb-2">Descripción del Trabajo</h6>
                            <div class="bg-light p-3 rounded">
                                {!! nl2br(e($mantenimiento->descripcion)) !!}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Checklist --}}
                @if($mantenimiento->checklist && count($mantenimiento->checklist) > 0)
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Checklist de Tareas</h5>
                            @if($mantenimiento->estado === 'en_progreso')
                                <span class="badge bg-info">En Progreso</span>
                            @elseif($mantenimiento->estado === 'completado')
                                <span class="badge bg-success">Completado</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($mantenimiento->estado === 'en_progreso')
                                <form action="{{ route('admin.crm.mantenimientos.update', $mantenimiento) }}" method="POST" id="formChecklist">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="solo_checklist" value="1">
                                    <ul class="list-group list-group-flush">
                                        @foreach($mantenimiento->checklist as $index => $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input checklist-item" type="checkbox"
                                                           name="checklist[{{ $index }}][completado]"
                                                           id="check_{{ $index }}"
                                                           {{ !empty($item['completado']) ? 'checked' : '' }}>
                                                    <input type="hidden" name="checklist[{{ $index }}][tarea]" value="{{ $item['tarea'] }}">
                                                    <label class="form-check-label" for="check_{{ $index }}">
                                                        {{ $item['tarea'] }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-save me-2"></i>Guardar Progreso
                                        </button>
                                    </div>
                                </form>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach($mantenimiento->checklist as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                @if(!empty($item['completado']))
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                @else
                                                    <i class="bi bi-circle text-muted me-2"></i>
                                                @endif
                                                {{ $item['tarea'] }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Resultados (si está completado) --}}
                @if($mantenimiento->estado === 'completado')
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                        <div class="card-header bg-success bg-opacity-10">
                            <h5 class="mb-0 fw-bold text-success"><i class="bi bi-check-circle me-2"></i>Resultados del Servicio</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Fecha Realizada</p>
                                    <p class="mb-0 fw-bold">{{ $mantenimiento->fecha_realizada?->format('d/m/Y') ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1 small">Duración Real</p>
                                    <p class="mb-0 fw-bold">{{ $mantenimiento->duracion_real_horas ?? '-' }} horas</p>
                                </div>
                            </div>

                            @if($mantenimiento->hallazgos)
                                <hr>
                                <h6 class="fw-bold mb-2">Hallazgos</h6>
                                <p class="mb-0">{!! nl2br(e($mantenimiento->hallazgos)) !!}</p>
                            @endif

                            @if($mantenimiento->recomendaciones)
                                <hr>
                                <h6 class="fw-bold mb-2">Recomendaciones</h6>
                                <p class="mb-0">{!! nl2br(e($mantenimiento->recomendaciones)) !!}</p>
                            @endif

                            @if($mantenimiento->requiere_seguimiento)
                                <hr>
                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Requiere Seguimiento</strong>
                                    @if($mantenimiento->fecha_proximo_mantenimiento)
                                        - Próximo mantenimiento: {{ $mantenimiento->fecha_proximo_mantenimiento?->format('d/m/Y') }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Historial del Cliente --}}
                @if(isset($historial) && $historial->count() > 0)
                    <div class="card border-0 shadow-sm" style="border-radius: 15px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Historial del Cliente</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historial as $h)
                                            <tr>
                                                <td>{{ $h->fecha_programada?->format('d/m/Y') }}</td>
                                                <td>{{ ucfirst($h->tipo) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $estadoColors[$h->estado] ?? 'secondary' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $h->estado)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.crm.mantenimientos.show', $h) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Notas Internas --}}
                @if($mantenimiento->notas_internas)
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-lock me-2 text-warning"></i>Notas Internas</h6>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                {!! nl2br(e($mantenimiento->notas_internas)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Evidencias --}}
                @if($mantenimiento->evidencias && count($mantenimiento->evidencias) > 0)
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-camera me-2"></i>Evidencias ({{ count($mantenimiento->evidencias) }})</h6>
                            <div class="row g-2">
                                @foreach($mantenimiento->evidencias as $foto)
                                    <div class="col-4 col-md-3">
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Columna Lateral --}}
            <div class="col-lg-4">
                {{-- Acciones --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Acciones</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.crm.mantenimientos.edit', $mantenimiento) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar
                            </a>
                            
                            @if($mantenimiento->estado === 'programado')
                                <form action="{{ route('admin.crm.mantenimientos.confirmar', $mantenimiento) }}" method="POST" id="form-confirmar">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-sm w-100 btn-confirmar">
                                        <i class="bi bi-check me-2"></i>Confirmar
                                    </button>
                                </form>
                            @endif

                            @if($mantenimiento->estado === 'confirmado')
                                <form action="{{ route('admin.crm.mantenimientos.iniciar', $mantenimiento) }}" method="POST" id="form-iniciar">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm w-100 btn-iniciar">
                                        <i class="bi bi-play-circle me-2"></i>Iniciar
                                    </button>
                                </form>
                            @endif

                            @if($mantenimiento->estado === 'en_progreso')
                                <button type="button" class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalCompletarShow">
                                    <i class="bi bi-check-circle me-2"></i>Completar
                                </button>
                            @endif

                            @if(!in_array($mantenimiento->estado, ['completado', 'cancelado']))
                                <hr>
                                @if(!in_array($mantenimiento->estado, ['en_progreso']))
                                    <button type="button" class="btn btn-outline-warning btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalReprogramar">
                                        <i class="bi bi-calendar-event me-2"></i>Reprogramar
                                    </button>
                                @endif
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalCancelar">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </button>
                            @endif

                            <hr>
                            <form action="{{ route('admin.crm.mantenimientos.destroy', $mantenimiento) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-2"></i>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Cliente --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Cliente</h6>
                        <p class="mb-1"><strong>{{ $mantenimiento->cliente->nombre ?? $mantenimiento->cliente->razon_social ?? 'N/A' }}</strong></p>
                        <p class="text-muted small mb-2">{{ $mantenimiento->cliente->codigo ?? '' }}</p>
                        
                        @if($mantenimiento->direccion)
                            <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $mantenimiento->direccion }}</p>
                        @endif
                        @if($mantenimiento->cliente->telefono)
                            <p class="mb-0"><i class="bi bi-telephone me-2"></i>{{ $mantenimiento->cliente->telefono }}</p>
                        @endif
                    </div>
                </div>

                {{-- Técnico --}}
                @if($mantenimiento->ticket)
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-ticket-detailed me-2"></i>Ticket Origen</h6>
                        <a href="{{ route('admin.crm.tickets.show', $mantenimiento->ticket) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-secondary">{{ $mantenimiento->ticket->codigo }}</span>
                                <span class="small">{{ Str::limit($mantenimiento->ticket->asunto, 35) }}</span>
                                <i class="bi bi-box-arrow-up-right small text-muted"></i>
                            </div>
                        </a>
                        <p class="text-muted small mb-0 mt-2">
                            <i class="bi bi-calendar me-1"></i>{{ $mantenimiento->ticket->created_at->format('d/m/Y') }}
                            · <span class="badge bg-{{ ['resuelto' => 'success', 'reabierto' => 'danger'][$mantenimiento->ticket->estado] ?? 'warning' }}">{{ ucfirst(str_replace('_', ' ', $mantenimiento->ticket->estado)) }}</span>
                        </p>
                    </div>
                </div>
                @endif

                {{-- Técnico --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tools me-2"></i>Técnico Asignado</h6>
                        @if($mantenimiento->tecnico)
                            <p class="mb-1"><strong>{{ $mantenimiento->tecnico->persona?->name ?? $mantenimiento->tecnico->name }}</strong></p>
                            @if($mantenimiento->tecnico->persona?->telefono)
                                <p class="mb-0 text-muted small">
                                    <i class="bi bi-telephone me-1"></i>{{ $mantenimiento->tecnico->persona->telefono }}
                                </p>
                            @endif
                        @else
                            <p class="text-muted mb-2">Sin asignar</p>
                            @if(!in_array($mantenimiento->estado, ['completado', 'cancelado']))
                                <a href="{{ route('admin.crm.mantenimientos.edit', $mantenimiento) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-person-plus me-1"></i>Asignar Técnico
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Costos internos: visibles solo cuando está completado Y solo para admin --}}
                @if($mantenimiento->estado === 'completado' && $esAdmin)
                @php $esGarantiaShow = $mantenimiento->ticket && $mantenimiento->ticket->categoria === 'garantia'; @endphp
                <div class="card border-0 shadow-sm" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1"><i class="bi bi-cash me-2"></i>Costos Internos del Servicio</h6>
                        @if($esGarantiaShow)
                            <p class="text-muted small mb-3">Garantía — el cliente no fue cobrado. Registro de costo operativo.</p>
                        @endif
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Mano de Obra:</td>
                                <td class="text-end">S/ {{ number_format($mantenimiento->costo_mano_obra ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Materiales:</td>
                                <td class="text-end">S/ {{ number_format($mantenimiento->costo_materiales ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Transporte:</td>
                                <td class="text-end">S/ {{ number_format($mantenimiento->costo_transporte ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold">Total:</td>
                                <td class="text-end fw-bold">S/ {{ number_format($mantenimiento->costo_total ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.crm.mantenimientos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver al listado
            </a>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ==================== CONFIRMAR MANTENIMIENTO ====================
    $('.btn-confirmar').on('click', function() {
        Swal.fire({
            title: '¿Confirmar mantenimiento?',
            html: `El mantenimiento <strong>{{ $mantenimiento->codigo }}</strong> pasará a estado <strong class="text-primary">Confirmado</strong>.<br><br>
                   <small class="text-muted">Se notificará al técnico asignado.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check me-1"></i> Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-confirmar').submit();
            }
        });
    });

    // ==================== EN CAMINO ====================
    $('.btn-en-camino').on('click', function() {
        Swal.fire({
            title: '¿Técnico en camino?',
            html: `El mantenimiento <strong>{{ $mantenimiento->codigo }}</strong> pasará a estado <strong class="text-info">En Camino</strong>.<br><br>
                   <small class="text-muted">Indica que el técnico ya se desplaza hacia el cliente.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-truck me-1"></i> Sí, en camino',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-en-camino').submit();
            }
        });
    });

    // ==================== INICIAR MANTENIMIENTO ====================
    $('.btn-iniciar').on('click', function() {
        Swal.fire({
            title: '¿Iniciar mantenimiento?',
            html: `El mantenimiento <strong>{{ $mantenimiento->codigo }}</strong> pasará a estado <strong class="text-warning">En Progreso</strong>.<br><br>
                   <small class="text-muted">Se registrará la hora de inicio.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-play-circle me-1"></i> Sí, iniciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-iniciar').submit();
            }
        });
    });

    // ==================== ELIMINAR ====================
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Eliminar mantenimiento?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

});
</script>
@endsection

{{-- Modal Completar Mantenimiento --}}
@if($mantenimiento->estado === 'en_progreso')
    <div class="modal fade" id="modalCompletarShow" tabindex="-1" style="display:none">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.crm.mantenimientos.completar', $mantenimiento) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-check-circle me-2 text-success"></i>Completar Mantenimiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="hallazgos" class="form-label fw-bold">Hallazgos</label>
                                <textarea name="hallazgos" id="hallazgos" class="form-control" rows="3" placeholder="Hallazgos durante el mantenimiento..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="recomendaciones" class="form-label fw-bold">Recomendaciones</label>
                                <textarea name="recomendaciones" id="recomendaciones" class="form-control" rows="3" placeholder="Recomendaciones para el cliente..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="duracion_real_horas" class="form-label fw-bold">Duración Real (hrs)</label>
                                <input type="number" name="duracion_real_horas" id="duracion_real_horas" class="form-control" min="1" max="24" value="{{ $mantenimiento->duracion_estimada_horas }}">
                            </div>
                            @php $esGarantia = $mantenimiento->ticket && $mantenimiento->ticket->categoria === 'garantia'; @endphp
                            @if($esAdmin)
                            <div class="col-12">
                                <p class="fw-bold mb-1 small text-uppercase text-muted">
                                    Costos Internos del Servicio
                                    @if($esGarantia)
                                        <span class="badge bg-info ms-1">Garantía — no se cobra al cliente</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label for="costo_mano_obra" class="form-label fw-bold">Mano de Obra (S/.)</label>
                                <input type="number" name="costo_mano_obra" id="costo_mano_obra" class="form-control" step="0.01" min="0" value="{{ $mantenimiento->costo_mano_obra ?? 0 }}">
                            </div>
                            <div class="col-md-4">
                                <label for="costo_materiales" class="form-label fw-bold">Materiales (S/.)</label>
                                <input type="number" name="costo_materiales" id="costo_materiales" class="form-control" step="0.01" min="0" value="{{ $mantenimiento->costo_materiales ?? 0 }}">
                            </div>
                            <div class="col-md-4">
                                <label for="costo_transporte" class="form-label fw-bold">Transporte (S/.)</label>
                                <input type="number" name="costo_transporte" id="costo_transporte" class="form-control" step="0.01" min="0" value="{{ $mantenimiento->costo_transporte ?? 0 }}">
                            </div>
                            @endif
                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
                            </div>
                            <div class="col-12">
                                <label for="evidencias" class="form-label fw-bold"><i class="bi bi-camera me-1"></i>Evidencias Fotográficas</label>
                                <input type="file" name="evidencias[]" id="evidencias" class="form-control" multiple accept="image/*">
                                <div class="form-text">Puede subir múltiples fotos. Máximo 5MB por imagen.</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="requiere_seguimiento" id="requiere_seguimiento" value="1">
                                    <label class="form-check-label" for="requiere_seguimiento">Requiere seguimiento</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_proximo_mantenimiento" class="form-label fw-bold">Próximo Mantenimiento</label>
                                <input type="date" name="fecha_proximo_mantenimiento" id="fecha_proximo_mantenimiento" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Completar Mantenimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- Modal Reprogramar Mantenimiento --}}
@if(!in_array($mantenimiento->estado, ['completado', 'cancelado', 'en_progreso']))
    <div class="modal fade" id="modalReprogramar" tabindex="-1" style="display:none">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.crm.mantenimientos.reprogramar', $mantenimiento) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-calendar-event me-2 text-warning"></i>Reprogramar Mantenimiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fecha_programada" class="form-label fw-bold">Nueva Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_programada" id="fecha_programada_reprog" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="hora_programada" class="form-label fw-bold">Nueva Hora</label>
                            <input type="time" name="hora_programada" id="hora_programada_reprog" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="motivo_reprogramacion" class="form-label fw-bold">Motivo <span class="text-danger">*</span></label>
                            <textarea name="motivo_reprogramacion" id="motivo_reprogramacion" class="form-control" rows="3" placeholder="Indique el motivo de la reprogramación..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                        <button type="submit" class="btn btn-warning"><i class="bi bi-calendar-event me-2"></i>Reprogramar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- Modal Cancelar Mantenimiento --}}
@if(!in_array($mantenimiento->estado, ['completado', 'cancelado']))
    <div class="modal fade" id="modalCancelar" tabindex="-1" style="display:none">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.crm.mantenimientos.cancelar', $mantenimiento) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-x-circle me-2 text-danger"></i>Cancelar Mantenimiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>¿Está seguro de cancelar este mantenimiento?</strong>
                            <p class="mb-0 mt-2 small">Esta acción no se puede revertir.</p>
                        </div>
                        <div class="mb-3">
                            <label for="motivo_cancelacion" class="form-label fw-bold">Motivo de Cancelación</label>
                            <textarea name="motivo_cancelacion" id="motivo_cancelacion" class="form-control" rows="3" placeholder="Indique el motivo de la cancelación..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i>Cancelar Mantenimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
