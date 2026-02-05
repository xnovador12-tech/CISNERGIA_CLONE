<?php $__env->startSection('title', 'VENTAS'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">VENTAS Y FACTURACIÓN</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ventas Mes</p>
                                <h3 class="mb-0 fw-bold"><?php echo e($ventas->where('created_at', '>=', now()->startOfMonth())->count()); ?></h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-coin fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Facturación Mes</p>
                                <h3 class="mb-0 fw-bold text-success">S/ <?php echo e(number_format($ventas->where('created_at', '>=', now()->startOfMonth())->where('estado', 'completada')->sum('total'), 2)); ?></h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Facturas Emitidas</p>
                                <h3 class="mb-0 fw-bold text-info"><?php echo e($ventas->whereNotNull('numero_comprobante')->count()); ?></h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-receipt fs-3 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ticket Promedio</p>
                                <h3 class="mb-0 fw-bold text-warning">S/ <?php echo e($ventas->where('estado', 'completada')->count() > 0 ? number_format($ventas->where('estado', 'completada')->avg('total'), 2) : '0.00'); ?></h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-tag fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <a href="<?php echo e(route('admin-ventas.create')); ?>" class="btn btn-success text-uppercase text-white btn-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Registrar Venta
                </a>
            </div>
            <div class="card-body">
                <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Sede</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Comprobante</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador++); ?></td>
                            <td class="fw-normal text-center align-middle">
                                <strong><?php echo e($venta->codigo); ?></strong><br>
                                <small class="text-muted"><?php echo e($venta->created_at->format('d/m/Y')); ?></small>
                            </td>
                            <td class="fw-normal text-center align-middle"><?php echo e($venta->cliente->name ?? 'N/A'); ?></td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-info"><?php echo e($venta->sede->name ?? 'Sin sede'); ?></span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <?php if($venta->tipo_venta == 'pos'): ?>
                                    <span class="badge bg-primary">POS</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Pedido</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <?php echo e($venta->tipocomprobante->name ?? 'Sin comprobante'); ?><br>
                                <?php if($venta->numero_comprobante): ?>
                                    <small class="text-muted"><?php echo e($venta->numero_comprobante); ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="fw-normal text-center align-middle"><?php echo e($venta->created_at->format('d/m/Y H:i')); ?></td>
                            <td class="fw-normal text-center align-middle text-success fw-bold">S/ <?php echo e(number_format($venta->total, 2)); ?></td>
                            <td class="fw-normal text-center align-middle">
                                <?php if($venta->estado == 'completada'): ?>
                                    <span class="badge bg-success">Completada</span>
                                <?php elseif($venta->estado == 'parcial'): ?>
                                    <span class="badge bg-warning">Parcial</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Anulada</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin-ventas.show', $venta)); ?>">
                                            <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-file-pdf text-danger me-2"></i>Descargar PDF</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?php echo e(route('admin-ventas.destroy', $venta)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro?')">
                                                    <i class="bi bi-trash text-danger me-2"></i>Eliminar
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/ventas/index.blade.php ENDPATH**/ ?>