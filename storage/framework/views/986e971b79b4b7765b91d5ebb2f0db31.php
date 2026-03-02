<?php $__env->startSection('title', 'MANTENIMIENTOS'); ?>

<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">MANTENIMIENTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Mantenimientos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Programados</p><h3 class="mb-0 fw-bold text-primary"><?php echo e($stats['programados'] ?? 0); ?></h3></div><div class="bg-primary bg-opacity-10 p-3 rounded-3"><i class="bi bi-calendar-check fs-3 text-primary"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">En Ejecución</p><h3 class="mb-0 fw-bold text-warning"><?php echo e($stats['en_ejecucion'] ?? 0); ?></h3></div><div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-gear-wide-connected fs-3 text-warning"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Completados Mes</p><h3 class="mb-0 fw-bold text-success"><?php echo e($stats['completados_mes'] ?? 0); ?></h3></div><div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-check-circle fs-3 text-success"></i></div></div></div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Próximos 7 días</p><h3 class="mb-0 fw-bold text-info"><?php echo e($stats['proximos'] ?? 0); ?></h3></div><div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-clock-history fs-3 text-info"></i></div></div></div></div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="container-fluid mb-3"><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <a href="<?php echo e(route('admin.crm.mantenimientos.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Programar Mantenimiento</a>
            </div>
            <div class="card-body">
                
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
                            <?php $__currentLoopData = $tecnicos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tecnico->persona?->name ?? $tecnico->name); ?>"><?php echo e($tecnico->persona?->name ?? $tecnico->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <span class="text-uppercase">Total de registros: <span class="fw-bold"><?php echo e($mantenimientos->count()); ?></span></span>
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
                            <?php $__empty_1 = true; $__currentLoopData = $mantenimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $mantenimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($i + 1); ?></td>
                                    <td class="text-center"><span class="badge bg-secondary"><?php echo e($mantenimiento->codigo); ?></span></td>
                                    <td class="text-center"><?php echo e(Str::limit($mantenimiento->cliente->nombre ?? 'N/A', 20)); ?></td>
                                    <td class="text-start"><strong><?php echo e(Str::limit($mantenimiento->titulo, 30)); ?></strong><br><small class="text-muted"><?php echo e(number_format($mantenimiento->potencia_sistema_kw ?? 0, 1)); ?> kW</small></td>
                                    <td class="text-center">
                                        <?php $tipoColors = ['preventivo' => 'info', 'correctivo' => 'warning', 'predictivo' => 'secondary', 'limpieza' => 'success', 'inspeccion' => 'primary']; ?>
                                        <span class="badge bg-<?php echo e($tipoColors[$mantenimiento->tipo] ?? 'secondary'); ?>"><?php echo e(ucfirst($mantenimiento->tipo)); ?></span>
                                    </td>
                                    <td class="text-center"><small><?php echo e($mantenimiento->fecha_programada->format('d/m/Y')); ?><br><?php echo e($mantenimiento->hora_programada); ?></small></td>
                                    <td class="text-center"><small><?php echo e($mantenimiento->tecnico->name ?? 'Sin asignar'); ?></small></td>
                                    <td class="text-center">
                                        <?php $estadoColors = ['programado' => 'info', 'confirmado' => 'primary', 'en_camino' => 'warning', 'en_progreso' => 'warning', 'completado' => 'success', 'cancelado' => 'danger', 'reprogramado' => 'secondary']; ?>
                                        <span class="badge bg-<?php echo e($estadoColors[$mantenimiento->estado] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $mantenimiento->estado))); ?></span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.mantenimientos.show', $mantenimiento)); ?>"><i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.mantenimientos.edit', $mantenimiento)); ?>"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                                <?php if($mantenimiento->estado === 'programado'): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><form action="<?php echo e(route('admin.crm.mantenimientos.confirmar', $mantenimiento)); ?>" method="POST" id="form-confirmar-<?php echo e($mantenimiento->id); ?>"><?php echo csrf_field(); ?><button type="button" class="dropdown-item text-primary btn-confirmar-idx" data-id="<?php echo e($mantenimiento->id); ?>" data-codigo="<?php echo e($mantenimiento->codigo); ?>"><i class="bi bi-check me-2"></i>Confirmar</button></form></li>
                                                <?php endif; ?>
                                                <?php if(in_array($mantenimiento->estado, ['confirmado', 'en_camino'])): ?>
                                                    <li><form action="<?php echo e(route('admin.crm.mantenimientos.iniciar', $mantenimiento)); ?>" method="POST" id="form-iniciar-<?php echo e($mantenimiento->id); ?>"><?php echo csrf_field(); ?><button type="button" class="dropdown-item text-warning btn-iniciar-idx" data-id="<?php echo e($mantenimiento->id); ?>" data-codigo="<?php echo e($mantenimiento->codigo); ?>"><i class="bi bi-play-circle me-2"></i>Iniciar</button></form></li>
                                                <?php endif; ?>
                                                <?php if($mantenimiento->estado === 'en_progreso'): ?>
                                                    <li><a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#modalCompletar-<?php echo e($mantenimiento->id); ?>"><i class="bi bi-check-circle me-2"></i>Completar</a></li>
                                                <?php endif; ?>
                                                <?php if(!in_array($mantenimiento->estado, ['completado', 'cancelado', 'en_progreso'])): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalReprogramar-<?php echo e($mantenimiento->id); ?>">
                                                            <i class="bi bi-calendar-event me-2"></i>Reprogramar
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if(!in_array($mantenimiento->estado, ['completado', 'cancelado'])): ?>
                                                    <li>
                                                        <form action="<?php echo e(route('admin.crm.mantenimientos.cancelar', $mantenimiento)); ?>" method="POST" class="form-cancelar" data-codigo="<?php echo e($mantenimiento->codigo); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-x-circle me-2"></i>Cancelar</button>
                                                        </form>
                                                    </li>
                                                <?php endif; ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="<?php echo e(route('admin.crm.mantenimientos.destroy', $mantenimiento)); ?>" method="POST" class="form-delete">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Eliminar</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay mantenimientos</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
        title: '¿Eliminar mantenimiento?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// SweetAlert para cancelar mantenimiento
$('.form-cancelar').submit(function(e) {
    e.preventDefault();
    const form = this;
    const codigo = $(this).data('codigo');

    Swal.fire({
        title: '¿Cancelar mantenimiento?',
        html: `El mantenimiento <strong>${codigo}</strong> será cancelado.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Volver'
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
        confirmButtonColor: '#1C3146',
        cancelButtonColor: '#FF9C00',
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
        confirmButtonColor: '#1C3146',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: '<i class="bi bi-play-circle me-1"></i> Sí, iniciar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $(`#form-iniciar-${id}`).submit();
        }
    });
});
</script>


<?php $__currentLoopData = $mantenimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mantenimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($mantenimiento->estado === 'en_progreso'): ?>
        <div class="modal fade" id="modalCompletar-<?php echo e($mantenimiento->id); ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.crm.mantenimientos.completar', $mantenimiento)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Completar - <?php echo e($mantenimiento->codigo); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info mb-3">
                                <small>
                                    <strong>Cliente:</strong> <?php echo e($mantenimiento->cliente->nombre ?? 'N/A'); ?> |
                                    <strong>Tipo:</strong> <?php echo e(ucfirst($mantenimiento->tipo)); ?> |
                                    <strong>Fecha:</strong> <?php echo e($mantenimiento->fecha_programada->format('d/m/Y')); ?>

                                </small>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hallazgos</label>
                                    <textarea name="hallazgos" class="form-control" rows="2" placeholder="Hallazgos encontrados..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Recomendaciones</label>
                                    <textarea name="recomendaciones" class="form-control" rows="2" placeholder="Recomendaciones..."></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Duración Real (hrs)</label>
                                    <input type="number" name="duracion_real_horas" class="form-control" min="1" max="24" value="<?php echo e($mantenimiento->duracion_estimada_horas); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Mano de Obra (S/.)</label>
                                    <input type="number" name="costo_mano_obra" class="form-control" step="0.01" min="0" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Materiales (S/.)</label>
                                    <input type="number" name="costo_materiales" class="form-control" step="0.01" min="0" value="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold"><i class="bi bi-camera me-1"></i>Evidencias</label>
                                    <input type="file" name="evidencias[]" class="form-control" multiple accept="image/*">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
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
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $mantenimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mantenimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!in_array($mantenimiento->estado, ['completado', 'cancelado', 'en_progreso'])): ?>
        <div class="modal fade" id="modalReprogramar-<?php echo e($mantenimiento->id); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.crm.mantenimientos.reprogramar', $mantenimiento)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-calendar-event me-2 text-warning"></i>Reprogramar - <?php echo e($mantenimiento->codigo); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nueva Fecha <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_programada" class="form-control" required min="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nueva Hora</label>
                                <input type="time" name="hora_programada" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Motivo <span class="text-danger">*</span></label>
                                <textarea name="motivo_reprogramacion" class="form-control" rows="3" placeholder="Motivo de la reprogramación..." required></textarea>
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
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/mantenimientos/index.blade.php ENDPATH**/ ?>