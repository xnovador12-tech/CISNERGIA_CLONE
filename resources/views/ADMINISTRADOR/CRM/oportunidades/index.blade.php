@extends('TEMPLATES.administrador')
@section('title', 'OPORTUNIDADES')

@section('css')
<style>
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
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3"><i class="bi bi-cash-stack fs-3 text-primary"></i></div>
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
                            <div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-diagram-3 fs-3 text-info"></i></div>
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
                            <div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-graph-up-arrow fs-3 text-success"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Ganado este Mes</p>
                                <h3 class="mb-0 fw-bold text-warning">S/ {{ number_format($estadisticas['valor_ganado_mes'] ?? 0, 0) }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-trophy fs-3 text-warning"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas completas --}}
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
    @if(session('info'))
        <div class="container-fluid mb-3">
            <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i>{{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    {{-- Tabla --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <a href="{{ route('admin.crm.oportunidades.create') }}" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Oportunidad
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filtros --}}
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filtro-etapa" class="form-label small text-muted mb-1">Etapa</label>
                        <select id="filtro-etapa" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todas las Etapas">
                            <option value="">Todas las Etapas</option>
                            <option value="Calificación">Calificación</option>
                            <option value="Evaluación">Evaluación</option>
                            <option value="Propuesta Técnica">Propuesta Técnica</option>
                            <option value="Negociación">Negociación</option>
                            <option value="Ganada">Ganada</option>
                            <option value="Perdida">Perdida</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-tipo" class="form-label small text-muted mb-1">Tipo Proyecto</label>
                        <select id="filtro-tipo" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Proyectos">
                            <option value="">Todos los Proyectos</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Agrícola">Agrícola</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-tipo-oportunidad" class="form-label small text-muted mb-1">Tipo Oportunidad</label>
                        <select id="filtro-tipo-oportunidad" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Producto / Servicio">
                            <option value="">Producto / Servicio</option>
                            <option value="Producto">Producto</option>
                            <option value="Servicio">Servicio</option>
                            <option value="Mixto">Mixto</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" id="incluir-cerradas"
                                   {{ request('incluir_cerradas') ? 'checked' : '' }}>
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
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Etapa</th>
                            <th class="text-center">Probabilidad</th>
                            <th class="text-center">Cierre Est.</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oportunidades as $index => $oportunidad)
                            <tr>
                                <td class="text-center"></td>
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
                                    @php $tipoOpoColors = ['producto' => 'success', 'servicio' => 'warning', 'mixto' => 'info']; @endphp
                                    <span class="badge bg-{{ $tipoOpoColors[$oportunidad->tipo_oportunidad ?? 'producto'] ?? 'secondary' }}">
                                        {{ ucfirst($oportunidad->tipo_oportunidad ?? 'producto') }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold text-primary">S/ {{ number_format($oportunidad->monto_estimado, 0) }}</td>
                                <td class="text-center">
                                    @php
                                        $etapaColors = [
                                            'calificacion' => 'primary', 'evaluacion' => 'info',
                                            'propuesta_tecnica' => 'warning', 'negociacion' => 'secondary',
                                            'ganada' => 'success', 'perdida' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }}">
                                        {{ \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa) }}
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
                                            <li><a class="dropdown-item" href="{{ route('admin.crm.oportunidades.show', $oportunidad) }}">
                                                <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.crm.oportunidades.edit', ['oportunidad' => $oportunidad, 'redirect_to' => 'index']) }}">
                                                <i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.crm.oportunidades.destroy', $oportunidad) }}"
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
        // ==================== FILTRO INCLUIR CERRADAS (registrar ANTES de inicializar DataTable) ====================
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'tablaOportunidades') return true;
            if ($('#incluir-cerradas').is(':checked')) return true;
            // data[6] = texto de la columna Etapa
            var etapa = (data[6] || '').trim();
            return etapa !== 'Ganada' && etapa !== 'Perdida';
        });

        var table = $('#tablaOportunidades').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                paginate: { first: '«', previous: '‹', next: '›', last: '»' },
                info: 'Mostrando página _PAGE_ de _PAGES_'
            },
            pageLength: 10,
            order: [[1, 'desc']],
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

        // ==================== FILTROS POR COLUMNA ====================
        // Filtro por Etapa (columna 6)
        $('#filtro-etapa').on('change', function() { table.column(6).search($(this).val()).draw(); });
        // Filtro por Tipo Proyecto (columna 2 - subtexto en Nombre)
        $('#filtro-tipo').on('change', function() { table.column(2).search($(this).val()).draw(); });
        // Filtro por Tipo Oportunidad (columna 4)
        $('#filtro-tipo-oportunidad').on('change', function() { table.column(4).search($(this).val()).draw(); });

        // Al cambiar el checkbox, redibujar la tabla
        $('#incluir-cerradas').on('change', function() {
            table.draw();
        });

        // ==================== SWEETALERT: ELIMINAR ====================
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
