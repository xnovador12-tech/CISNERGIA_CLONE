@extends('TEMPLATES.administrador')
@section('title', 'MANTENIMIENTOS')

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
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">MANTENIMIENTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Mantenimientos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Programados</p><h3 class="mb-0 fw-bold text-primary">{{ $stats['programados'] ?? 0 }}</h3></div><div class="bg-primary bg-opacity-10 p-3 rounded-3"><i class="bi bi-calendar-check fs-3 text-primary"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">En Ejecución</p><h3 class="mb-0 fw-bold text-warning">{{ $stats['en_ejecucion'] ?? 0 }}</h3></div><div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-gear-wide-connected fs-3 text-warning"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Completados Mes</p><h3 class="mb-0 fw-bold text-success">{{ $stats['completados_mes'] ?? 0 }}</h3></div><div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-check-circle fs-3 text-success"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Próximos 7 días</p><h3 class="mb-0 fw-bold text-info">{{ $stats['proximos'] ?? 0 }}</h3></div><div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-clock-history fs-3 text-info"></i></div></div></div></div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3"><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    @endif

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <a href="{{ route('admin.crm.mantenimientos.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Programar Mantenimiento</a>
            </div>
            <div class="card-body">
                {{-- Filtros DataTables --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-2">
                        <select id="filtro-estado" class="form-select form-select-sm">
                            <option value="">Todos los Estados</option>
                            <option value="Programado">Programado</option>
                            <option value="Confirmado">Confirmado</option>
                            <option value="En camino">En Camino</option>
                            <option value="En progreso">En Progreso</option>
                            <option value="Completado">Completado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Reprogramado">Reprogramado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filtro-tipo" class="form-select form-select-sm">
                            <option value="">Todos los Tipos</option>
                            <option value="Preventivo">Preventivo</option>
                            <option value="Correctivo">Correctivo</option>
                            <option value="Limpieza">Limpieza</option>
                            <option value="Inspeccion">Inspección</option>
                            <option value="Predictivo">Predictivo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filtro-tecnico" class="form-select form-select-sm">
                            <option value="">Todos los Técnicos</option>
                            <option value="Sin asignar">Sin Asignar</option>
                            @foreach($tecnicos ?? [] as $tecnico)
                                <option value="{{ $tecnico->persona?->name ?? $tecnico->name }}">{{ $tecnico->persona?->name ?? $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" id="filtro-fecha-desde" class="form-control form-control-sm" placeholder="Desde">
                    </div>
                    <div class="col-md-2">
                        <input type="date" id="filtro-fecha-hasta" class="form-control form-control-sm" placeholder="Hasta">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="btn-limpiar-filtros" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-x-circle me-1"></i>Limpiar
                        </button>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $mantenimientos->count() }}</span></span>
                </div>
                <table id="tablaMantenimientos" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Sistema</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Fecha Prog.</th>
                            <th class="text-center">Técnico</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($mantenimientos as $i => $mantenimiento)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $mantenimiento->codigo }}</span></td>
                                    <td class="text-center">{{ Str::limit($mantenimiento->cliente->nombre ?? 'N/A', 20) }}</td>
                                    <td class="text-start"><strong>{{ Str::limit($mantenimiento->titulo, 30) }}</strong><br><small class="text-muted">{{ number_format($mantenimiento->potencia_sistema_kw ?? 0, 1) }} kW</small></td>
                                    <td class="text-center">
                                        @php $tipoColors = ['preventivo' => 'info', 'correctivo' => 'warning', 'predictivo' => 'secondary', 'limpieza' => 'success', 'inspeccion' => 'primary']; @endphp
                                        <span class="badge bg-{{ $tipoColors[$mantenimiento->tipo] ?? 'secondary' }}">{{ ucfirst($mantenimiento->tipo) }}</span>
                                    </td>
                                    <td class="text-center"><small>{{ $mantenimiento->fecha_programada->format('d/m/Y') }}<br>{{ $mantenimiento->hora_programada }}</small></td>
                                    <td class="text-center"><small>{{ $mantenimiento->tecnico->name ?? 'Sin asignar' }}</small></td>
                                    <td class="text-center">
                                        @php $estadoColors = ['programado' => 'info', 'confirmado' => 'primary', 'en_camino' => 'warning', 'en_progreso' => 'warning', 'completado' => 'success', 'cancelado' => 'danger', 'reprogramado' => 'secondary']; @endphp
                                        <span class="badge bg-{{ $estadoColors[$mantenimiento->estado] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $mantenimiento->estado)) }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="{{ route('admin.crm.mantenimientos.show', $mantenimiento) }}"><i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin.crm.mantenimientos.edit', $mantenimiento) }}"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                                @if($mantenimiento->estado === 'programado')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><form action="{{ route('admin.crm.mantenimientos.confirmar', $mantenimiento) }}" method="POST" id="form-confirmar-{{ $mantenimiento->id }}">@csrf<button type="button" class="dropdown-item text-primary btn-confirmar-idx" data-id="{{ $mantenimiento->id }}" data-codigo="{{ $mantenimiento->codigo }}"><i class="bi bi-check me-2"></i>Confirmar</button></form></li>
                                                @endif
                                                @if(in_array($mantenimiento->estado, ['confirmado', 'en_camino']))
                                                    <li><form action="{{ route('admin.crm.mantenimientos.iniciar', $mantenimiento) }}" method="POST" id="form-iniciar-{{ $mantenimiento->id }}">@csrf<button type="button" class="dropdown-item text-warning btn-iniciar-idx" data-id="{{ $mantenimiento->id }}" data-codigo="{{ $mantenimiento->codigo }}"><i class="bi bi-play-circle me-2"></i>Iniciar</button></form></li>
                                                @endif
                                                @if($mantenimiento->estado === 'en_progreso')
                                                    <li><a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#modalCompletar-{{ $mantenimiento->id }}"><i class="bi bi-check-circle me-2"></i>Completar</a></li>
                                                @endif
                                                {{-- @if(!in_array($mantenimiento->estado, ['completado', 'cancelado']))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.crm.mantenimientos.reporte', $mantenimiento) }}"><i class="bi bi-file-pdf text-danger me-2"></i>Generar Reporte</a></li>
                                                @endif --}}
                                                {{-- TODO: descomentar cuando se cree la vista reporte-pdf.blade.php --}}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay mantenimientos</td></tr>
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
    var table = $('#tablaMantenimientos').DataTable({
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
        order: [[0, 'asc']], // Ordenar por número de fila
        columnDefs: [
            { orderable: false, targets: [8] }, // Desactivar orden en columna de acciones
            { type: 'num', targets: [0] } // Columna N° como numérica
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // Filtro por Estado (columna 7)
    $('#filtro-estado').on('change', function() {
        var val = $(this).val();
        table.column(7).search(val).draw();
    });

    // Filtro por Tipo (columna 4)
    $('#filtro-tipo').on('change', function() {
        var val = $(this).val();
        table.column(4).search(val).draw();
    });

    // Filtro por Técnico (columna 6)
    $('#filtro-tecnico').on('change', function() {
        var val = $(this).val();
        table.column(6).search(val).draw();
    });

    // Filtro por Fecha Desde
    $('#filtro-fecha-desde').on('change', function() {
        table.draw();
    });

    // Filtro por Fecha Hasta
    $('#filtro-fecha-hasta').on('change', function() {
        table.draw();
    });

    // Filtro personalizado por rango de fechas
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var fechaDesde = $('#filtro-fecha-desde').val();
        var fechaHasta = $('#filtro-fecha-hasta').val();
        
        if (!fechaDesde && !fechaHasta) return true;
        
        // La fecha está en columna 5 (Fecha Prog.) formato dd/mm/yyyy
        var fechaCell = data[5].split('<')[0].trim(); // Obtener solo la fecha sin el HTML
        var partes = fechaCell.split('/');
        if (partes.length !== 3) return true;
        
        var fechaRow = new Date(partes[2], partes[1] - 1, partes[0]);
        
        if (fechaDesde) {
            var desde = new Date(fechaDesde);
            if (fechaRow < desde) return false;
        }
        
        if (fechaHasta) {
            var hasta = new Date(fechaHasta);
            if (fechaRow > hasta) return false;
        }
        
        return true;
    });

    // Botón limpiar filtros
    $('#btn-limpiar-filtros').on('click', function() {
        $('#filtro-estado').val('').trigger('change');
        $('#filtro-tipo').val('').trigger('change');
        $('#filtro-tecnico').val('').trigger('change');
        $('#filtro-fecha-desde').val('');
        $('#filtro-fecha-hasta').val('');
        table.search('').columns().search('').draw();
    });
});

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
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// SweetAlert para confirmar mantenimiento
$(document).on('click', '.btn-confirmar-idx', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const codigo = $(this).data('codigo');

    Swal.fire({
        title: '¿Confirmar mantenimiento?',
        html: `El mantenimiento <strong>${codigo}</strong> pasará a estado <strong class="text-primary">Confirmado</strong>.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-check me-1"></i> Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $(`#form-confirmar-${id}`).submit();
        }
    });
});

// SweetAlert para iniciar mantenimiento
$(document).on('click', '.btn-iniciar-idx', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const codigo = $(this).data('codigo');

    Swal.fire({
        title: '¿Iniciar mantenimiento?',
        html: `El mantenimiento <strong>${codigo}</strong> pasará a estado <strong class="text-warning">En Progreso</strong>.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-play-circle me-1"></i> Sí, iniciar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $(`#form-iniciar-${id}`).submit();
        }
    });
});
</script>

{{-- Modales de Completar Mantenimiento --}}
@foreach($mantenimientos as $mantenimiento)
    @if($mantenimiento->estado === 'en_progreso')
        <div class="modal fade" id="modalCompletar-{{ $mantenimiento->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.crm.mantenimientos.completar', $mantenimiento) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Completar Mantenimiento - {{ $mantenimiento->codigo }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info mb-3">
                                <small>
                                    <strong>Cliente:</strong> {{ $mantenimiento->cliente->nombre ?? 'N/A' }}<br>
                                    <strong>Tipo:</strong> {{ ucfirst($mantenimiento->tipo) }}<br>
                                    <strong>Fecha Programada:</strong> {{ $mantenimiento->fecha_programada->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="trabajo_realizado_{{ $mantenimiento->id }}" class="form-label fw-bold">Trabajo Realizado <span class="text-danger">*</span></label>
                                    <textarea name="trabajo_realizado" id="trabajo_realizado_{{ $mantenimiento->id }}" class="form-control" rows="3" placeholder="Describa el trabajo realizado..." required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="hallazgos_{{ $mantenimiento->id }}" class="form-label fw-bold">Hallazgos</label>
                                    <textarea name="hallazgos" id="hallazgos_{{ $mantenimiento->id }}" class="form-control" rows="2" placeholder="Hallazgos encontrados..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="recomendaciones_{{ $mantenimiento->id }}" class="form-label fw-bold">Recomendaciones</label>
                                    <textarea name="recomendaciones" id="recomendaciones_{{ $mantenimiento->id }}" class="form-control" rows="2" placeholder="Recomendaciones para el cliente..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="costo_mano_obra_{{ $mantenimiento->id }}" class="form-label fw-bold">Costo Mano de Obra (S/.)</label>
                                    <input type="number" name="costo_mano_obra" id="costo_mano_obra_{{ $mantenimiento->id }}" class="form-control" step="0.01" min="0" value="0">
                                </div>
                                <div class="col-md-6">
                                    <label for="costo_materiales_{{ $mantenimiento->id }}" class="form-label fw-bold">Costo Materiales (S/.)</label>
                                    <input type="number" name="costo_materiales" id="costo_materiales_{{ $mantenimiento->id }}" class="form-control" step="0.01" min="0" value="0">
                                </div>
                                <div class="col-12">
                                    <label for="observaciones_{{ $mantenimiento->id }}" class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones_{{ $mantenimiento->id }}" class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Completar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
