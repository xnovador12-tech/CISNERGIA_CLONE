@extends('TEMPLATES.administrador')
@section('title', 'ACTIVIDADES')

@section('css')
<style>
    /* Estilos de paginación DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 2px;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background: #fff;
        color: #212529 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1C3146 !important;
        color: #fff !important;
        border-color: #1C3146;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e9ecef !important;
        color: #212529 !important;
        border-color: #dee2e6;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #1C3146 !important;
        color: #fff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d !important;
        cursor: not-allowed;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 0.85em;
        color: #6c757d;
    }
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
    }
</style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">ACTIVIDADES</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Actividades</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- fin encabezado -->

    {{-- KPIs --}}
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Pendientes</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $stats['pendientes'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock-history fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Completadas (Mes)</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $stats['completadas_mes'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Vencidas</p>
                                <h3 class="mb-0 fw-bold text-danger">{{ $stats['vencidas'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Tasa Cumplimiento</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $stats['tasa_cumplimiento'] ?? 0 }}%</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas de sesión --}}

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-4 mb-2 mb-md-0 d-flex gap-2">
                        <a href="{{ route('admin.crm.actividades.create') }}" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Actividad
                        </a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filtros --}}
                <div class="row g-2 mb-3 align-items-end flex-nowrap">
                    <div class="col">
                        <label for="filtro-tipo" class="form-label small text-muted mb-1">Tipo</label>
                        <select id="filtro-tipo" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Tipos">
                            <option value="">Todos los Tipos</option>
                            @foreach(\App\Models\ActividadCrm::TIPOS as $key => $info)
                                <option value="{{ $info['nombre'] }}">{{ $info['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="filtro-estado" class="form-label small text-muted mb-1">Estado</label>
                        <select id="filtro-estado" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Estados">
                            <option value="">Todos los Estados</option>
                            <option value="Programada">Programada</option>
                            <option value="En Evaluación">En Evaluación</option>
                            <option value="Completada">Completada</option>
                            <option value="Reprogramada">Reprogramada</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="No Realizada">No Realizada</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="filtro-prioridad" class="form-label small text-muted mb-1">Prioridad</label>
                        <select id="filtro-prioridad" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todas las Prioridades">
                            <option value="">Todas las Prioridades</option>
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    @if($esAdmin ?? false)
                    <div class="col">
                        <label for="filtro-responsable" class="form-label small text-muted mb-1">Responsable</label>
                        <select id="filtro-responsable" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos">
                            <option value="">Todos</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->persona?->name ?? $u->email }}">
                                    {{ $u->persona?->name ?? $u->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-auto">
                        <button type="button" id="btn-limpiar"
                                class="btn btn-sm btn-outline-secondary"
                                title="Limpiar filtros"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                style="height: 31px; padding: 0 8px; border-radius: 6px;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $actividades->count() }}</span></span>
                </div>
                <table id="tablaActividades" class="table table-hover align-middle" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Título</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Relacionado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Responsable</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Prioridad</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                        @php
                            $estadoColors  = ['programada' => 'warning text-dark', 'completada' => 'success', 'cancelada' => 'danger', 'reprogramada' => 'primary', 'no_realizada' => 'secondary', 'en_evaluacion' => 'info'];
                            $estadoNombres = ['programada' => 'Programada', 'completada' => 'Completada', 'cancelada' => 'Cancelada', 'reprogramada' => 'Reprogramada', 'no_realizada' => 'No Realizada', 'en_evaluacion' => 'En Evaluación'];
                            $prioridadIcons = ['alta' => 'bi-arrow-up-circle-fill text-danger', 'media' => 'bi-dash-circle-fill text-warning', 'baja' => 'bi-arrow-down-circle-fill text-success'];
                        @endphp
                        <tbody>
                            @foreach($actividades as $index => $actividad)
                                @php $tipoInfo = $actividad->tipo_info; @endphp
                                <tr>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle">
                                        <span class="fw-semibold">{{ $actividad->codigo }}</span>
                                        <br><small class="text-muted">{{ $actividad->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-{{ $tipoInfo['color'] }}">
                                            <i class="bi {{ $tipoInfo['icono'] }} me-1"></i>{{ $tipoInfo['nombre'] }}
                                        </span>
                                    </td>
                                    <td class="text-start align-middle" style="max-width: 280px;">
                                        <div class="text-truncate fw-semibold" style="max-width: 280px;" title="{{ $actividad->titulo }}">
                                            {{ $actividad->titulo }}
                                        </div>
                                        @if($actividad->descripcion)
                                            <div class="text-truncate text-muted" style="max-width: 280px; font-size: 0.8rem;" title="{{ $actividad->descripcion }}">
                                                {{ $actividad->descripcion }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle" style="max-width: 180px;">
                                        @if($actividad->actividadable)
                                            @php
                                                $entidadNombre = class_basename($actividad->actividadable_type);
                                                $entidadLabel  = $actividad->actividadable->nombre_completo ?? $actividad->actividadable->nombre ?? 'N/A';
                                            @endphp
                                            <small>
                                                <span class="text-muted">{{ $entidadNombre }}</span><br>
                                                <span class="d-inline-block text-truncate" style="max-width: 160px;" title="{{ $entidadLabel }}">{{ $entidadLabel }}</span>
                                            </small>
                                        @else
                                            <small class="text-muted">Sin relación</small>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <small>{{ $actividad->asignadoA?->persona?->name ?? $actividad->asignadoA?->email ?? 'Sin asignar' }}</small>
                                    </td>
                                    <td class="text-center align-middle" data-order="{{ $actividad->fecha_programada->timestamp }}">
                                        <small>{{ $actividad->fecha_programada->format('d/m/Y') }}<br>
                                        <strong>{{ $actividad->fecha_programada->format('H:i') }}</strong></small>
                                        @if($actividad->estado === 'programada' && $actividad->fecha_programada < now())
                                            <br><small class="text-danger"><i class="bi bi-clock-fill me-1"></i>Vencida</small>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <i class="bi {{ $prioridadIcons[$actividad->prioridad] ?? 'bi-circle text-secondary' }}" title="{{ ucfirst($actividad->prioridad) }}" data-bs-toggle="tooltip"></i>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-{{ $estadoColors[$actividad->estado] ?? 'secondary' }}">
                                            {{ $estadoNombres[$actividad->estado] ?? ucfirst($actividad->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="width: 36px; height: 36px; padding: 0;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li>
                                                    <a href="{{ route('admin.crm.actividades.show', $actividad) }}"
                                                       class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.crm.actividades.edit', $actividad) }}"
                                                       class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.crm.actividades.destroy', $actividad) }}"
                                                          method="POST" class="form-delete d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center text-danger">
                                                            <i class="bi bi-trash me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#tablaActividades').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
            info: 'Mostrando página _PAGE_ de _PAGES_',
            emptyTable: '<div class="text-center py-4"><div class="text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay actividades registradas</div><a href="{{ route("admin.crm.actividades.create") }}" class="btn btn-primary btn-sm mt-2"><i class="bi bi-plus-circle me-1"></i>Crear primera actividad</a></div>'
        },
        pageLength: 10,
        order: [[6, 'desc']], // Ordenar por fecha descendente (col 6)
        columnDefs: [
            { orderable: false, searchable: false, targets: [0, 9] }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>',
        drawCallback: function(settings) {
            var api = this.api();
            api.column(0, { search: 'applied', order: 'applied', page: 'current' }).nodes().each(function(cell, i) {
                cell.innerHTML = api.page.info().start + i + 1;
            });
        }
    });

    // Filtro por Tipo (columna 2)
    $('#filtro-tipo').on('change', function() {
        table.column(2).search($(this).val()).draw();
    });

    // Filtro por Estado (columna 8)
    $('#filtro-estado').on('change', function() {
        table.column(8).search($(this).val()).draw();
    });

    // Filtro por Prioridad (columna 7)
    $('#filtro-prioridad').on('change', function() {
        table.column(7).search($(this).val()).draw();
    });

    // Filtro por Responsable (columna 5) — solo visible para admins
    $('#filtro-responsable').on('change', function() {
        table.column(5).search($(this).val()).draw();
    });

    // Limpiar filtros
    $('#btn-limpiar').on('click', function() {
        $('[id^="filtro-"]').each(function() {
            $(this).val('').trigger('change');
        });
        table.search('').columns().search('').draw();
    });

    // Inicializar tooltip
    var tooltipEl = document.querySelector('#btn-limpiar');
    if (tooltipEl) { new bootstrap.Tooltip(tooltipEl); }

    // SweetAlert para eliminar
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });
});
</script>
@endsection
