<?php $__env->startSection('title', 'VER VENTA'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE LA VENTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-ventas.index')); ?>">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e($venta->codigo); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-8">
                
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Información de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> <?php echo e($venta->codigo); ?></p>
                                <p class="mb-1"><strong>Fecha:</strong> <?php echo e($venta->created_at->format('d/m/Y H:i')); ?></p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    <?php if($venta->estado == 'completada'): ?>
                                        <span class="badge bg-success">Completada</span>
                                    <?php elseif($venta->estado == 'parcial'): ?>
                                        <span class="badge bg-warning">Parcial</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Anulada</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-1"><strong>Tipo de Venta:</strong>
                                    <span class="badge bg-<?php echo e($venta->tipo_venta === 'ecommerce' ? 'info' : ($venta->tipo_venta === 'pos' ? 'dark' : 'primary')); ?>">
                                        <?php echo e(ucfirst($venta->tipo_venta)); ?>

                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Comprobante:</strong> <?php echo e($venta->tipocomprobante->name ?? 'Sin comprobante'); ?></p>
                                <p class="mb-1"><strong>Número:</strong> <?php echo e($venta->numero_comprobante ?? 'Sin número'); ?></p>
                                <p class="mb-1"><strong>Medio de Pago:</strong> <?php echo e($venta->mediopago->name ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Vendedor:</strong> <?php echo e($venta->usuario->name ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        <hr>

                        
                        <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nombre:</strong>
                                    <?php if($venta->cliente): ?>
                                        <?php echo e($venta->cliente->nombre); ?> <?php echo e($venta->cliente->apellidos); ?>

                                        <?php if($venta->cliente->razon_social): ?>
                                            <br><small class="text-muted"><?php echo e($venta->cliente->razon_social); ?></small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </p>
                                <p class="mb-1"><strong>Documento:</strong>
                                    <?php if($venta->cliente): ?>
                                        <?php if($venta->cliente->tipo_persona === 'juridica'): ?>
                                            RUC: <?php echo e($venta->cliente->ruc ?? 'N/A'); ?>

                                        <?php else: ?>
                                            DNI: <?php echo e($venta->cliente->dni ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Correo:</strong> <?php echo e($venta->cliente->email ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Teléfono:</strong> <?php echo e($venta->cliente->celular ?? $venta->cliente->telefono ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        
                        <?php if($venta->pedido): ?>
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-3">Pedido Relacionado</h6>
                        <p class="mb-1"><strong>Código:</strong> <a href="<?php echo e(route('admin-pedidos.show', $venta->pedido)); ?>"><?php echo e($venta->pedido->codigo); ?></a></p>
                        <?php endif; ?>

                        
                        <?php if($venta->observaciones): ?>
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p><?php echo e($venta->observaciones); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if($venta->detalles->count() > 0): ?>
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40px;">N°</th>
                                        <th>Producto / Servicio</th>
                                        <th class="text-center" style="width: 80px;">Cant.</th>
                                        <th class="text-end" style="width: 110px;">Precio Unit.</th>
                                        <th class="text-end" style="width: 90px;">Desc.</th>
                                        <th class="text-end" style="width: 120px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $venta->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <span class="fw-semibold"><?php echo e($detalle->descripcion); ?></span>
                                            <?php if($detalle->tipo !== 'producto'): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info ms-1"><?php echo e(ucfirst($detalle->tipo)); ?></span>
                                            <?php endif; ?>
                                            <?php if($detalle->garantia_años): ?>
                                                <br><small class="text-muted"><i class="bi bi-shield-check me-1"></i>Garantía: <?php echo e($detalle->garantia_años); ?> años</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo e(number_format($detalle->cantidad, $detalle->cantidad == intval($detalle->cantidad) ? 0 : 2)); ?></td>
                                        <td class="text-end">S/ <?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
                                        <td class="text-end">
                                            <?php if($detalle->descuento_porcentaje > 0): ?>
                                                <?php echo e(number_format($detalle->descuento_porcentaje, 0)); ?>%
                                            <?php elseif($detalle->descuento_monto > 0): ?>
                                                S/ <?php echo e(number_format($detalle->descuento_monto, 2)); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end fw-semibold">S/ <?php echo e(number_format($detalle->subtotal, 2)); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot class="border-top-2">
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">Total Ítems:</td>
                                        <td class="text-end text-success">S/ <?php echo e(number_format($venta->detalles->sum('subtotal'), 2)); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ <?php echo e(number_format($venta->subtotal, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ <?php echo e(number_format($venta->descuento, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ <?php echo e(number_format($venta->igv, 2)); ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-success">S/ <?php echo e(number_format($venta->total, 2)); ?></h5>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header" style="background-color: #1C3146; color: white;">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <a href="<?php echo e(route('admin-ventas.voucher', $venta)); ?>" class="btn btn-danger w-100 mb-2" target="_blank">
                            <i class="bi bi-file-pdf me-2"></i>Generar Comprobante
                        </a>
                        <a href="<?php echo e(route('admin-ventas.index')); ?>" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/ventas/show.blade.php ENDPATH**/ ?>