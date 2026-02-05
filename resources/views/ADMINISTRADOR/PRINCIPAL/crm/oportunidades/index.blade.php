@extends('TEMPLATES.administrador')
@section('title', 'OPORTUNIDADES')

@section('css')
<style>
    .kanban-stage { min-width: 260px; max-width: 260px; }
    .opportunity-card { cursor: pointer; transition: all 0.2s; }
    .opportunity-card:hover { transform: translateY(-2px); }
    
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
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">OPORTUNIDADES</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Oportunidades</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Valor Pipeline</p>
                                <h3 class="mb-0 fw-bold text-primary">S/ {{ number_format($estadisticas['valor_pipeline'] ?? 0, 0) }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-stack fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Oportunidades Activas</p>
                                <h3 class="mb-0 fw-bold">{{ $estadisticas['activas'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-diagram-3 fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Tasa Conversión</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $estadisticas['tasa_conversion'] ?? 0 }}%</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up-arrow fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Ciclo Promedio</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $estadisticas['ciclo_promedio'] ?? 0 }} días</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock-history fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
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

    {{-- Tabla de Oportunidades --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.crm.oportunidades.create') }}" class="btn btn-primary text-uppercase text-white btn-sm">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nueva Oportunidad
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filtros DataTables --}}
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-3">
                        <select id="filtro-etapa" class="form-select form-select-sm">
                            <option value="">Todas las Etapas</option>
                            <option value="calificacion">Calificación</option>
                            <option value="analisis_sitio">Análisis de Sitio</option>
                            <option value="propuesta_tecnica">Propuesta Técnica</option>
                            <option value="negociacion">Negociación</option>
                            <option value="contrato">Contrato</option>
                            <option value="ganada">Ganada</option>
                            <option value="perdida">Perdida</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-tipo" class="form-select form-select-sm">
                            <option value="">Todos los Tipos</option>
                            <option value="residencial">Residencial</option>
                            <option value="comercial">Comercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="agricola">Agrícola</option>
                            <option value="bombeo_solar">Bombeo Solar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluir-cerradas" 
                                   {{ request('incluir_cerradas') ? 'checked' : '' }}
                                   onchange="window.location.href='{{ route('admin.crm.oportunidades.index') }}' + (this.checked ? '?incluir_cerradas=1' : '')">
                            <label class="form-check-label small" for="incluir-cerradas">
                                <i class="bi bi-archive me-1"></i>Incluir Ganadas/Perdidas
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $oportunidades->count() }}</span></span>
                </div>
                <table id="tablaOportunidades" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Cliente/Prospecto</th>
                            <th class="text-center">Potencia</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Etapa</th>
                            <th class="text-center">Probabilidad</th>
                            <th class="text-center">Cierre Est.</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($oportunidades as $index => $oportunidad)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $oportunidad->codigo }}</span></td>
                                <td class="text-start">
                                    <strong>{{ Str::limit($oportunidad->nombre, 30) }}</strong>
                                    <br><small class="text-muted">{{ ucfirst($oportunidad->tipo_proyecto ?? '') }}</small>
                                </td>
                                <td class="text-center">
                                    @if($oportunidad->cliente)
                                        <span class="badge bg-success">{{ Str::limit($oportunidad->cliente->nombre, 20) }}</span>
                                    @elseif($oportunidad->prospecto)
                                        <span class="badge bg-warning text-dark">{{ Str::limit($oportunidad->prospecto->nombre_completo, 20) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ number_format($oportunidad->potencia_kw ?? 0, 1) }} kW</span>
                                </td>
                                <td class="text-center fw-bold text-primary">
                                    S/ {{ number_format($oportunidad->monto_estimado, 0) }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $etapaColors = [
                                            'calificacion' => 'secondary',
                                            'analisis_sitio' => 'info',
                                            'propuesta_tecnica' => 'primary',
                                            'propuesta' => 'primary',
                                            'negociacion' => 'warning',
                                            'contrato' => 'dark',
                                            'cierre' => 'info',
                                            'ganada' => 'success',
                                            'perdida' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $oportunidad->etapa)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <div class="progress" style="width: 50px; height: 6px;">
                                            <div class="progress-bar bg-{{ $oportunidad->probabilidad >= 70 ? 'success' : ($oportunidad->probabilidad >= 40 ? 'warning' : 'danger') }}"
                                                 style="width: {{ $oportunidad->probabilidad }}%"></div>
                                        </div>
                                        <small>{{ $oportunidad->probabilidad }}%</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <small>{{ $oportunidad->fecha_cierre_estimada ? $oportunidad->fecha_cierre_estimada->format('d/m/Y') : '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                            data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li><a class="dropdown-item" href="{{ route('admin.crm.oportunidades.show', $oportunidad->slug) }}">
                                                <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.crm.oportunidades.edit', $oportunidad->slug) }}">
                                                <i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                            @if(!in_array($oportunidad->etapa, ['ganada', 'perdida']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.crm.oportunidades.crear-cotizacion', $oportunidad->slug) }}" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item text-primary">
                                                            <i class="bi bi-file-text me-2"></i>Crear Cotización</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.crm.oportunidades.ganada', $oportunidad->slug) }}" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item text-success">
                                                            <i class="bi bi-trophy me-2"></i>Marcar Ganada</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.crm.oportunidades.perdida', $oportunidad->slug) }}" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item text-danger">
                                                            <i class="bi bi-x-circle me-2"></i>Marcar Perdida</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No hay oportunidades registradas
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
        // Inicializar DataTable con filtros del lado del cliente
        var table = $('#tablaOportunidades').DataTable({
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
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [9] }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
        });

        // Filtro por Etapa (columna 6)
        $('#filtro-etapa').on('change', function() {
            table.column(6).search($(this).val()).draw();
        });

        // Filtro por Tipo (columna 2 - incluido en nombre)
        $('#filtro-tipo').on('change', function() {
            table.column(2).search($(this).val()).draw();
        });
    });
</script>
@endsection
