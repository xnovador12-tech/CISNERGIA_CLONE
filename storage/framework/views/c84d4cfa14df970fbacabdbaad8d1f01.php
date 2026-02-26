<?php $__env->startSection('title', 'VER PEDIDO'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DEL PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-pedidos.index')); ?>">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ver Pedido</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?php echo e(session('success')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-x-circle-fill fs-5"></i>
                <div><?php echo e(session('error')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div><?php echo e(session('warning')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-info-circle-fill fs-5"></i>
                <div><?php echo e(session('info')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        

        <div class="row g-3">
            <!-- Información del Pedido -->
            <div class="col-md-8">
                
                <!-- Indicador de Origen -->
                <div class="mb-3" data-aos="fade-up">
                    <?php if($pedido->origen === 'ecommerce'): ?>
                        <span class="badge bg-info fs-6">
                            <i class="bi bi-cart-check me-2"></i>Pedido E-commerce (Pago Online Confirmado)
                        </span>
                    <?php elseif($pedido->origen === 'cotizacion'): ?>
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-file-earmark-text me-2"></i>Pedido desde Cotización
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">
                            <i class="bi bi-briefcase me-2"></i>Pedido Manual (Proyecto B2B)
                        </span>
                    <?php endif; ?>
                </div>

                
                <?php if(!$pedido->aprobacion_stock && $pedido->estado === 'pendiente'): ?>
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-3 mb-3" data-aos="fade-up">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Atención: Stock insuficiente</h6>
                            <small>No se pudo reservar el stock automáticamente. Por favor, revisa el inventario y una vez abastecido vuelve a intentar la reserva.</small>
                            <form action="<?php echo e(route('admin-pedidos.aprobar-stock', $pedido)); ?>" method="POST" class="mt-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-dark">Re-intentar reserva de stock</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> <?php echo e($pedido->codigo); ?></p>
                                <p class="mb-1"><strong>Fecha:</strong> <?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></p>
                                <p class="mb-1"><strong>Origen:</strong> 
                                    <span class="badge <?php echo e($pedido->origen == 'ecommerce' ? 'bg-purple' : 'bg-secondary'); ?>">
                                        <?php echo e(ucfirst($pedido->origen)); ?>

                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Estado:</strong>
                                    <?php if($pedido->estado == 'pendiente'): ?>
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    <?php elseif($pedido->estado == 'proceso'): ?>
                                        <span class="badge bg-info">En Proceso</span>
                                    <?php elseif($pedido->estado == 'entregado'): ?>
                                        <span class="badge bg-success">Entregado</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Anulado / Cancelado</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-1"><strong>Fecha Entrega:</strong> <?php echo e($pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'Sin fecha'); ?></p>
                                <p class="mb-1"><strong>Vendedor:</strong> <?php echo e($pedido->usuario->name ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <!-- Cliente -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                                <p class="mb-1"><strong>Nombre:</strong> <?php echo e($pedido->cliente->nombre ?? ''); ?> <?php echo e($pedido->cliente->apellidos ?? ''); ?></p>
                                <p class="mb-1"><strong>Documento:</strong> <?php echo e($pedido->cliente->ruc ?? $pedido->cliente->dni ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Correo:</strong> <?php echo e($pedido->cliente->correo ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Teléfono:</strong> <?php echo e($pedido->cliente->telefono ?? 'N/A'); ?></p>
                            </div>

                            <!-- Instalación -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Instalación</h6>
                                <p class="mb-1"><strong>Dirección:</strong> <?php echo e($pedido->direccion_instalacion ?? 'No especificada'); ?></p>
                                <p class="mb-1"><strong>Distrito:</strong> <?php echo e($pedido->distrito->name ?? 'No especificado'); ?></p>
                                <p class="mb-1"><strong>Técnico Asignado:</strong> <?php echo e($pedido->tecnico->name ?? 'Sin asignar'); ?></p>
                                <p class="mb-1"><strong>Almacén:</strong> <?php echo e($pedido->almacen->nombre ?? 'Sin asignar'); ?></p>
                            </div>
                        </div>

                        <?php if($pedido->observaciones): ?>
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p><?php echo e($pedido->observaciones); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Desc.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1; ?>
                                <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($contador++); ?></td>
                                    <td>
                                        <?php echo e($detalle->descripcion); ?>

                                        <br><small class="text-muted">Tipo: <?php echo e(ucfirst($detalle->tipo)); ?></small>
                                    </td>
                                    <td class="text-center"><?php echo e($detalle->cantidad); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->descuento, 2)); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->subtotal, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ <?php echo e(number_format($pedido->subtotal, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ <?php echo e(number_format($pedido->descuento, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ <?php echo e(number_format($pedido->igv, 2)); ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-primary">S/ <?php echo e(number_format($pedido->total, 2)); ?></h5>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <?php if($pedido->venta): ?>
                            <a href="<?php echo e(route('admin-ventas.show', $pedido->venta)); ?>" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-check-circle me-2"></i>Ver Comprobante: <?php echo e($pedido->venta->codigo); ?>

                            </a>
                        <?php else: ?>
                            
                            <?php if(!$pedido->aprobacion_finanzas): ?>
                                <form action="<?php echo e(route('admin-pedidos.aprobar-finanzas', $pedido)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary w-100 mb-2 py-2">
                                        <i class="bi bi-cash-coin me-2"></i>Confirmar Pago
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-success py-2 mb-2 text-center" style="font-size:0.85rem;">
                                    <i class="bi bi-check-all me-1"></i> Pago Verificado
                                    <form action="<?php echo e(route('admin-pedidos.aprobar-finanzas', $pedido)); ?>" method="POST" class="d-inline ms-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small" title="Revocar Pago">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalGenerarComprobante">
                                    <i class="bi bi-receipt me-2"></i>Generar Comprobante
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin-pedidos.edit', $pedido)); ?>" class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-pencil me-2"></i>Editar Pedido
                        </a>
                        <a href="<?php echo e(route('admin-pedidos.index')); ?>" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Generar Comprobante -->
<?php if(!$pedido->venta): ?>
    <div class="modal fade" id="modalGenerarComprobante" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Generar Comprobante de Venta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin-pedidos.generar-comprobante', $pedido)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            El comprobante heredará todos los datos del pedido <strong><?php echo e($pedido->codigo); ?></strong>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tipo de Comprobante <span class="text-danger">*</span></label>
                            <select name="tiposcomprobante_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = \App\Models\Tiposcomprobante::where('tipo', 'ventas')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Medio de Pago <span class="text-danger">*</span></label>
                            <select name="mediopago_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = \App\Models\Mediopago::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($medio->id); ?>"><?php echo e($medio->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de Comprobante</label>
                            <input type="text" name="numero_comprobante" class="form-control" placeholder="Ej: F001-00001 (opcional)">
                            <small class="text-muted">Dejar vacío para generar automáticamente</small>
                        </div>

                        <hr>
                        <h6 class="fw-bold">Resumen del Pedido:</h6>
                        <table class="table table-sm">
                            <tr><td>Cliente:</td><td class="fw-bold"><?php echo e($pedido->cliente->nombre ?? ''); ?> <?php echo e($pedido->cliente->apellidos ?? ''); ?></td></tr>
                            <tr><td>Subtotal:</td><td>S/ <?php echo e(number_format($pedido->subtotal, 2)); ?></td></tr>
                            <tr><td>IGV:</td><td>S/ <?php echo e(number_format($pedido->igv, 2)); ?></td></tr>
                            <tr class="table-primary"><td class="fw-bold">TOTAL:</td><td class="fw-bold">S/ <?php echo e(number_format($pedido->total, 2)); ?></td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Generar Comprobante
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/pedidos/show.blade.php ENDPATH**/ ?>