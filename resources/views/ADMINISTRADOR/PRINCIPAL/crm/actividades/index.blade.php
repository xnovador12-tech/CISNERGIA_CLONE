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
                                <p class="text-muted mb-1 small">Actividades Hoy</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $stats['hoy'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-calendar-check fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Llamadas Pendientes</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $stats['llamadas'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-telephone fs-3 text-warning"></i>
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
                                <p class="text-muted mb-1 small">Reuniones</p>
                                <h3 class="mb-0 fw-bold text-info">{{ $stats['reuniones'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-people fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Visitas Técnicas</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $stats['visitas'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-geo-alt fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas de sesión --}}
    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                        <a href="{{ route('admin.crm.actividades.create') }}" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Actividad
                        </a>
                    </div>
                    <div class="col-12 col-md-8 d-flex flex-wrap justify-content-md-end gap-2 mt-2 mt-md-0">
                        {{-- Filtro por Período --}}
                        <div class="d-flex align-items-center">
                            <label class="me-2 mb-0 text-nowrap small">Período:</label>
                            <select id="filtroPeriodo" class="form-select form-select-sm" style="width: auto;">
                                <option value="">Todos</option>
                                <option value="hoy">Hoy</option>
                                <option value="semana">Esta semana</option>
                                <option value="mes">Este mes</option>
                                <option value="vencidas">Vencidas</option>
                            </select>
                        </div>
                        {{-- Filtro por Tipo --}}
                        <div class="d-flex align-items-center">
                            <label class="me-2 mb-0 text-nowrap small">Tipo:</label>
                            <select id="filtroTipo" class="form-select form-select-sm" style="width: auto;">
                                <option value="">Todos</option>
                                <option value="llamada">Llamada</option>
                                <option value="email">Email</option>
                                <option value="reunion">Reunión</option>
                                <option value="visita_tecnica">Visita Técnica</option>
                                <option value="videollamada">Videollamada</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="tarea">Tarea</option>
                            </select>
                        </div>
                        {{-- Filtro por Estado --}}
                        <div class="d-flex align-items-center">
                            <label class="me-2 mb-0 text-nowrap small">Estado:</label>
                            <select id="filtroEstado" class="form-select form-select-sm" style="width: auto;">
                                <option value="">Todos</option>
                                <option value="programada">Programada</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="reprogramada">Reprogramada</option>
                                <option value="no_realizada">No Realizada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $actividades->count() }}</span></span>
                </div>
                <table id="tablaActividades" class="table table-hover align-middle" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Título</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Relacionado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha y Hora</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Asignado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($actividades as $i => $actividad)
                                <tr data-tipo="{{ $actividad->tipo }}" 
                                    data-fecha="{{ $actividad->fecha_programada->format('Y-m-d') }}"
                                    data-estado="{{ $actividad->estado }}">
                                    <td class="fw-normal text-center align-middle"></td>
                                    <td class="fw-normal text-center align-middle" data-search="{{ $actividad->tipo }}">
                                        @php 
                                            $tipoIcons = ['llamada' => 'telephone', 'reunion' => 'people', 'visita_tecnica' => 'geo-alt', 'email' => 'envelope', 'tarea' => 'check2-square', 'videollamada' => 'camera-video', 'whatsapp' => 'whatsapp'];
                                            $tipoColors = ['llamada' => 'primary', 'reunion' => 'success', 'visita_tecnica' => 'warning', 'email' => 'info', 'tarea' => 'secondary', 'videollamada' => 'dark', 'whatsapp' => 'success'];
                                        @endphp
                                        <span class="badge bg-{{ $tipoColors[$actividad->tipo] ?? 'secondary' }}">
                                            <i class="bi bi-{{ $tipoIcons[$actividad->tipo] ?? 'calendar' }} me-1"></i>{{ ucfirst(str_replace('_', ' ', $actividad->tipo)) }}
                                        </span>
                                    </td>
                                    <td class="fw-normal text-start align-middle">
                                        <strong>{{ Str::limit($actividad->titulo, 40) }}</strong>
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        @if($actividad->activable)
                                            <small>{{ class_basename($actividad->activable_type) }}: {{ Str::limit($actividad->activable->nombre_completo ?? $actividad->activable->nombre ?? 'N/A', 25) }}</small>
                                        @else
                                            <small class="text-muted">Sin relación</small>
                                        @endif
                                    </td>
                                    <td class="fw-normal text-center align-middle" data-order="{{ $actividad->fecha_programada->timestamp }}">
                                        <small>
                                            {{ $actividad->fecha_programada->format('d/m/Y') }}<br>
                                            <strong>{{ $actividad->fecha_programada->format('H:i') }}</strong>
                                        </small>
                                    </td>
                                    <td class="fw-normal text-center align-middle">
                                        <small>{{ $actividad->asignadoA->name ?? 'Sin asignar' }}</small>
                                    </td>
                                    <td class="fw-normal text-center align-middle" data-search="{{ $actividad->estado }}">
                                        @php 
                                            $estadoColors = [
                                                'programada' => 'warning', 
                                                'en_progreso' => 'info',
                                                'completada' => 'success', 
                                                'cancelada' => 'danger', 
                                                'reprogramada' => 'primary',
                                                'no_realizada' => 'secondary'
                                            ]; 
                                        @endphp
                                        <span class="badge bg-{{ $estadoColors[$actividad->estado] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $actividad->estado)) }}
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
                                                @if($actividad->estado === 'programada')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.crm.actividades.completar', $actividad) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item d-flex align-items-center text-success">
                                                                <i class="bi bi-check-circle me-2"></i>Completar
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.crm.actividades.cancelar', $actividad) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                                                <i class="bi bi-x-circle me-2"></i>Cancelar
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No hay actividades registradas
                                        </div>
                                        <a href="{{ route('admin.crm.actividades.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="bi bi-plus-circle me-1"></i>Crear primera actividad
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Fechas de referencia para filtros
    var hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    
    var inicioSemana = new Date(hoy);
    inicioSemana.setDate(hoy.getDate() - hoy.getDay());
    
    var finSemana = new Date(inicioSemana);
    finSemana.setDate(inicioSemana.getDate() + 6);
    
    var inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    var finMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);

    // Variables para filtros activos
    var filtroPeriodoActivo = '';
    var filtroTipoActivo = '';
    var filtroEstadoActivo = '';

    // Función de filtrado personalizado
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var row = $(settings.aoData[dataIndex].nTr);
        var fechaStr = row.data('fecha');
        var tipo = row.data('tipo');
        var estado = row.data('estado');
        
        // Filtro por período
        if (filtroPeriodoActivo) {
            var fechaRow = new Date(fechaStr + 'T00:00:00');
            
            switch(filtroPeriodoActivo) {
                case 'hoy':
                    if (fechaRow.toDateString() !== hoy.toDateString()) return false;
                    break;
                case 'semana':
                    if (fechaRow < inicioSemana || fechaRow > finSemana) return false;
                    break;
                case 'mes':
                    if (fechaRow < inicioMes || fechaRow > finMes) return false;
                    break;
                case 'vencidas':
                    if (fechaRow >= hoy || estado === 'completada' || estado === 'cancelada') return false;
                    break;
            }
        }

        // Filtro por tipo
        if (filtroTipoActivo && tipo !== filtroTipoActivo) {
            return false;
        }

        // Filtro por estado
        if (filtroEstadoActivo && estado !== filtroEstadoActivo) {
            return false;
        }

        return true;
    });

    // Inicializar DataTable
    var table = $('#tablaActividades').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
            },
            info: 'Mostrando página _PAGE_ de _PAGES_'
        },
        pageLength: 10,
        order: [[4, 'desc']], // Ordenar por fecha descendente
        columnDefs: [
            { 
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1 + meta.settings._iDisplayStart;
                }
            },
            { orderable: false, targets: [7] }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // Filtro por período
    $('#filtroPeriodo').on('change', function() {
        filtroPeriodoActivo = $(this).val();
        table.draw();
    });

    // Filtro por tipo
    $('#filtroTipo').on('change', function() {
        filtroTipoActivo = $(this).val();
        table.draw();
    });

    // Filtro por estado
    $('#filtroEstado').on('change', function() {
        filtroEstadoActivo = $(this).val();
        table.draw();
    });
});
</script>
@endsection
