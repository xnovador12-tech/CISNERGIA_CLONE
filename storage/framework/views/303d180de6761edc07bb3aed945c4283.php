<?php $__env->startSection('title', 'PEDIDOS'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* Estados Minimalistas */
        .status-dot {
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: #4b5563;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .dot-warning { background-color: #f59e0b; }
        .dot-info    { background-color: #3b82f6; }
        .dot-primary { background-color: #6366f1; }
        .dot-success { background-color: #10b981; }
        .dot-danger  { background-color: #ef4444; }
        .dot-secondary { background-color: #9ca3af; }

        /* Aprobaciones Minimalistas */
        .mini-approvals {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 4px;
            font-size: 1rem;
        }
        .text-ready { color: #10b981 !important; }
        .text-not-ready { color: #d1d5db !important; }
    </style>

    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PEDIDOS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Pedidos</li>
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
                                <p class="text-muted mb-1 small">Pedidos Mes</p>
                                <h3 class="mb-0 fw-bold"><?php echo e($pedidos->where('created_at', '>=', now()->startOfMonth())->count()); ?></h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cart fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Pendientes</p>
                                <h3 class="mb-0 fw-bold text-warning"><?php echo e($pedidos->where('estado', 'pendiente')->count()); ?></h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock fs-3 text-warning"></i>
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
                                <p class="text-muted mb-1 small">En Proceso</p>
                                <h3 class="mb-0 fw-bold text-info"><?php echo e($pedidos->where('estado', 'proceso')->count()); ?></h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-arrow-repeat fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Entregados</p>
                                <h3 class="mb-0 fw-bold text-success"><?php echo e($pedidos->where('estado', 'entregado')->count()); ?></h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Tabla de Pedidos -->
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up">
            <div class="card-header bg-transparent py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    
                    <div>
                        <a href="<?php echo e(route('admin-pedidos.create')); ?>" class="btn btn-dark text-uppercase px-4 fw-bold shadow-sm" style="border-radius: 50px; background-color: #000c19; border: none; font-size: 0.8rem; padding: 10px 25px;">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Pedido
                        </a>
                    </div>
                    
                    
                    <div class="flex-grow-1">
                        <form action="<?php echo e(route('admin-pedidos.index')); ?>" method="GET" class="row g-2 justify-content-end align-items-center">
                            <div class="col-auto">
                                <input type="date" name="desde" class="form-control form-control-sm shadow-sm" 
                                    value="<?php echo e(request('desde')); ?>" 
                                    style="border-radius: 8px; border: 1px solid #ced4da; height: 38px; min-width: 150px;"
                                    title="Fecha Desde">
                            </div>
                            <div class="col-auto">
                                <input type="date" name="hasta" class="form-control form-control-sm shadow-sm" 
                                    value="<?php echo e(request('hasta')); ?>" 
                                    style="border-radius: 8px; border: 1px solid #ced4da; height: 38px; min-width: 150px;"
                                    title="Fecha Hasta">
                            </div>
                            <div class="col-auto">
                                <select name="estado" class="form-select form-select-sm shadow-sm fw-bold text-muted" 
                                    style="border-radius: 8px; border: 1px solid #ced4da; height: 38px; min-width: 160px; font-size: 0.85rem;">
                                    <option value="">TODOS LOS ESTADOS</option>
                                    <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>PENDIENTE</option>
                                    <option value="proceso" <?php echo e(request('estado') == 'proceso' ? 'selected' : ''); ?>>EN PROCESO</option>
                                    <option value="entregado" <?php echo e(request('estado') == 'entregado' ? 'selected' : ''); ?>>ENTREGADO</option>
                                    <option value="cancelado" <?php echo e(request('estado') == 'cancelado' ? 'selected' : ''); ?>>CANCELADO</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm">
                                    <button type="submit" class="btn btn-outline-dark shadow-sm px-3" style="border-radius: 8px; height: 38px;">
                                        <i class="bi bi-filter"></i>
                                    </button>
                                    <?php if(request()->anyFilled(['desde', 'hasta', 'estado'])): ?>
                                        <a href="<?php echo e(route('admin-pedidos.index')); ?>" class="btn btn-outline-danger shadow-sm px-3" style="border-radius: 8px; height: 38px;">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>

                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($pedido->id); ?></td>
                            <td class="fw-normal text-center align-middle">
                                <strong><?php echo e($pedido->codigo); ?></strong><br>
                                <small class="text-muted"><?php echo e($pedido->created_at->format('d/m/Y')); ?></small>
                            </td>
                            <td class="fw-normal text-center align-middle"><?php echo e($pedido->cliente->nombre ?? ''); ?> <?php echo e($pedido->cliente->apellidos ?? ''); ?></td>
                            <td class="fw-normal text-center align-middle"><?php echo e($pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'Sin fecha'); ?></td>
                            <td class="fw-normal text-center align-middle text-primary fw-bold">S/ <?php echo e(number_format($pedido->total, 2)); ?></td>
                            <td class="text-center align-middle">
                                
                                <?php
                                    $dotColor = match($pedido->estado) {
                                        'pendiente' => 'dot-warning',
                                        'proceso'   => 'dot-info',
                                        'entregado' => 'dot-success',
                                        'cancelado' => 'dot-danger',
                                        default     => 'dot-secondary',
                                    };
                                    $label = match($pedido->estado) {
                                        'pendiente' => 'Pendiente',
                                        'proceso'   => 'En Proceso',
                                        'entregado' => 'Entregado',
                                        'cancelado' => 'Cancelado',
                                        default     => ucfirst($pedido->estado),
                                    };
                                ?>
                                <div class="status-dot">
                                    <span class="dot <?php echo e($dotColor); ?>"></span><?php echo e($label); ?>

                                </div>

                                
                                <div class="mini-approvals">
                                    <i class="bi bi-wallet2 <?php echo e($pedido->aprobacion_finanzas ? 'text-ready' : 'text-not-ready'); ?>" 
                                       title="Pago: <?php echo e($pedido->aprobacion_finanzas ? 'Aprobado' : 'Pendiente'); ?>"></i>
                                    <i class="bi bi-box-seam <?php echo e($pedido->aprobacion_stock ? 'text-ready' : 'text-not-ready'); ?>" 
                                       title="Stock: <?php echo e($pedido->aprobacion_stock ? 'Reservado' : 'Sin reserva'); ?>"></i>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin-pedidos.show', $pedido)); ?>">
                                            <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a>
                                        </li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin-pedidos.edit', $pedido)); ?>">
                                            <i class="bi bi-pencil text-secondary me-2"></i>Editar</a>
                                        </li>
                                        
                                        <?php if(!$pedido->aprobacion_finanzas && $pedido->estado !== 'cancelado'): ?>
                                            <li>
                                                <form action="<?php echo e(route('admin-pedidos.aprobar-finanzas', $pedido)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-cash-coin text-primary me-2"></i>Confirmar Pago
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                        <?php endif; ?>

                                        <?php if($pedido->estado === 'proceso'): ?>
                                            <li>
                                                <form action="<?php echo e(route('admin-pedidos.estado', $pedido)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="estado" value="entregado">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-check2-all text-success me-2"></i>Marcar como Entregado
                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif; ?>

                                        <?php if($pedido->estado !== 'cancelado'): ?>
                                            <li>
                                                <form action="<?php echo e(route('admin-pedidos.estado', $pedido)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="estado" value="cancelado">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-x-circle me-2"></i>Anular Pedido
                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif; ?>

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?php echo e(route('admin-pedidos.destroy', $pedido)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item p-n3 small opacity-50" onclick="return confirm('¿Eliminar registro permanentemente?')">
                                                    <i class="bi bi-trash me-2"></i>Borrar (Admin)
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
<style>
    /* Mostrar X registros en una sola línea horizontal */
    .dataTables_length {
        display: flex !important;
        align-items: center !important;
    }
    .dataTables_length label {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        margin-bottom: 0 !important;
        white-space: nowrap !important;
    }
    .dataTables_length select {
        width: auto !important;
        display: inline-block !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/pedidos/index.blade.php ENDPATH**/ ?>