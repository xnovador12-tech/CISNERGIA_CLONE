<?php $__env->startSection('title', 'COTIZACIONES'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem; margin-left: 2px; border: 1px solid #dee2e6; border-radius: 0.25rem; background: #fff; color: #212529 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #1C3146 !important; color: #fff !important; border-color: #1C3146; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #e9ecef !important; color: #212529 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #1C3146 !important; color: #fff !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { color: #6c757d !important; cursor: not-allowed; }
    .dataTables_wrapper .dataTables_info { padding-top: 0.85em; color: #6c757d; }
    .dataTables_wrapper .dataTables_paginate { float: right; text-align: right; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COTIZACIONES</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Cotizaciones</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-in">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Cotizaciones Mes</p>
                                <h3 class="mb-0 fw-bold"><?php echo e($stats['total_mes'] ?? 0); ?></h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-file-text fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Valor Total</p>
                                <h3 class="mb-0 fw-bold text-success">S/ <?php echo e(number_format($stats['valor_total'] ?? 0, 0)); ?></h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-stack fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Aprobadas</p>
                                <h3 class="mb-0 fw-bold text-info"><?php echo e($stats['aprobadas'] ?? 0); ?></h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Pendientes</p>
                                <h3 class="mb-0 fw-bold text-warning"><?php echo e($stats['pendientes'] ?? 0); ?></h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-in">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <a href="<?php echo e(route('admin.crm.cotizaciones.create')); ?>" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Cotización
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filtro-estado" class="form-label small text-muted mb-1">Estado</label>
                        <select id="filtro-estado" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Estados">
                            <option value="">Todos los Estados</option>
                            <option value="borrador">Borrador</option>
                            <option value="enviada">Enviada</option>
                            <option value="aceptada">Aceptada</option>
                            <option value="rechazada">Rechazada</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-tipo" class="form-label small text-muted mb-1">Tipo</label>
                        <select id="filtro-tipo" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Tipos">
                            <option value="">Todos los Tipos</option>
                            <option value="Producto">Producto</option>
                            <option value="Servicio">Servicio</option>
                            <option value="Mixto">Mixto</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-usuario" class="form-label small text-muted mb-1">Vendedor</label>
                        <select id="filtro-usuario" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Vendedores">
                            <option value="">Todos los Vendedores</option>
                            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($usuario->persona->name ?? $usuario->email); ?>">
                                    <?php echo e($usuario->persona->name ?? $usuario->email); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold"><?php echo e($cotizaciones->count()); ?></span></span>
                </div>

                <table id="tablaCotizaciones" class="table table-hover align-middle" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Oportunidad / Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Vigencia</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cotizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cotizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $estadoColors = [
                                    'borrador' => 'secondary', 'enviada' => 'primary',
                                    'aceptada' => 'success', 'rechazada' => 'danger'
                                ];
                            ?>
                            <tr>
                                <td class="text-center"><?php echo e($i + 1); ?></td>
                                <td class="text-center">
                                    <strong><?php echo e($cotizacion->codigo); ?></strong>
                                    <br><small class="text-muted"><?php echo e($cotizacion->created_at->format('d/m/Y')); ?></small>
                                    <?php if($cotizacion->version > 1): ?>
                                        <br><span class="badge bg-info">v<?php echo e($cotizacion->version); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start">
                                    <?php if($cotizacion->oportunidad): ?>
                                        <strong><?php echo e(Str::limit($cotizacion->oportunidad->nombre, 30)); ?></strong>
                                        <?php if($cotizacion->oportunidad->prospecto): ?>
                                            <br><small class="text-muted"><?php echo e(Str::limit($cotizacion->oportunidad->prospecto->nombre_completo, 30)); ?></small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">Sin oportunidad</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($cotizacion->oportunidad): ?>
                                        <?php
                                            $tipoColors = ['producto' => 'success', 'servicio' => 'warning', 'mixto' => 'info'];
                                        ?>
                                        <span class="badge bg-<?php echo e($tipoColors[$cotizacion->oportunidad->tipo_oportunidad] ?? 'secondary'); ?>">
                                            <?php echo e(ucfirst($cotizacion->oportunidad->tipo_oportunidad)); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center text-primary fw-bold">S/ <?php echo e(number_format($cotizacion->total ?? 0, 2)); ?></td>
                                <td class="text-center">
                                    <?php if($cotizacion->fecha_vigencia): ?>
                                        <small><?php echo e($cotizacion->fecha_vigencia->format('d/m/Y')); ?></small>
                                        <?php if($cotizacion->fecha_vigencia->isPast() && !in_array($cotizacion->estado, ['aceptada', 'rechazada'])): ?>
                                            <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Vencida</small>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo e($estadoColors[$cotizacion->estado] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $cotizacion->estado))); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                                data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.crm.cotizaciones.show', $cotizacion)); ?>">
                                                    <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.crm.cotizaciones.pdf', $cotizacion)); ?>">
                                                    <i class="bi bi-file-pdf text-danger me-2"></i>Descargar PDF
                                                </a>
                                            </li>
                                            <?php if(!in_array($cotizacion->estado, ['aceptada', 'rechazada'])): ?>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.crm.cotizaciones.edit', $cotizacion)); ?>">
                                                        <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="<?php echo e(route('admin.crm.cotizaciones.destroy', $cotizacion)); ?>"
                                                      method="POST" class="form-delete d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    var table = $('#tablaCotizaciones').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
            info: 'Mostrando página _PAGE_ de _PAGES_'
        },
        pageLength: 10,
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [7] }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // ==================== FILTROS ====================
    // Estado (columna 6)
    $('#filtro-estado').on('change', function() {
        table.column(6).search($(this).val()).draw();
    });

    // Tipo oportunidad (columna 3)
    $('#filtro-tipo').on('change', function() {
        table.column(3).search($(this).val()).draw();
    });

    // Vendedor (búsqueda global)
    $('#filtro-usuario').on('change', function() {
        table.search($(this).val()).draw();
    });

    // ==================== SWEETALERT: ELIMINAR ====================
    $('.form-delete').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: '¿Eliminar cotización?',
            html: 'Se eliminará permanentemente esta cotización y todos sus ítems.<br><strong class="text-danger">Esta acción no se puede deshacer.</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.isConfirmed) { form.submit(); }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/cotizaciones/index.blade.php ENDPATH**/ ?>