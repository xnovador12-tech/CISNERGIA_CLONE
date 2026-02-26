<?php $__env->startSection('title', 'Cotización ' . $cotizacion->codigo); ?>

<?php $__env->startSection('css'); ?>
<style>
    .resumen-valor { font-size: 0.95rem; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0"><?php echo e($cotizacion->codigo); ?></h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.cotizaciones.index')); ?>">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e($cotizacion->codigo); ?></li>
                    </ol>
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
        <div class="row g-4">
            
            <div class="col-lg-8">

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <?php
                                    $estadoConfig = [
                                        'borrador' => ['color' => 'secondary', 'icono' => 'bi-pencil-square'],
                                        'enviada' => ['color' => 'primary', 'icono' => 'bi-send'],
                                        'aceptada' => ['color' => 'success', 'icono' => 'bi-check-circle'],
                                        'rechazada' => ['color' => 'danger', 'icono' => 'bi-x-circle']
                                    ];
                                    $ec = $estadoConfig[$cotizacion->estado] ?? ['color' => 'secondary', 'icono' => 'bi-circle'];
                                ?>
                                <span class="badge bg-<?php echo e($ec['color']); ?> fs-6 px-3 py-2">
                                    <i class="bi <?php echo e($ec['icono']); ?> me-1"></i><?php echo e(ucfirst(str_replace('_', ' ', $cotizacion->estado))); ?>

                                </span>
                                <?php if($cotizacion->version > 1): ?>
                                    <span class="badge bg-info ms-2">Versión <?php echo e($cotizacion->version); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <?php if($cotizacion->oportunidad): ?>
                                    <a href="<?php echo e(route('admin.crm.oportunidades.show', $cotizacion->oportunidad->slug)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-briefcase me-1"></i>Ver Oportunidad
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.crm.cotizaciones.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Oportunidad</p>
                                <?php if($cotizacion->oportunidad): ?>
                                    <a href="<?php echo e(route('admin.crm.oportunidades.show', $cotizacion->oportunidad->slug)); ?>" class="text-decoration-none fw-bold">
                                        <?php echo e($cotizacion->oportunidad->codigo); ?> - <?php echo e($cotizacion->oportunidad->nombre); ?>

                                    </a>
                                    <br><small class="text-muted"><?php echo e(ucfirst($cotizacion->oportunidad->tipo_oportunidad)); ?> — <?php echo e(ucfirst(str_replace('_', ' ', $cotizacion->oportunidad->etapa))); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">No asignada</span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Prospecto / Cliente</p>
                                <?php if($cotizacion->oportunidad?->prospecto): ?>
                                    <span class="fw-bold"><?php echo e($cotizacion->oportunidad->prospecto->nombre_completo); ?></span>
                                    <br><small class="text-muted"><?php echo e($cotizacion->oportunidad->prospecto->email); ?> — <?php echo e($cotizacion->oportunidad->prospecto->telefono); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">No disponible</span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Proyecto</p>
                                <span class="fw-bold"><?php echo e($cotizacion->nombre_proyecto); ?></span>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Tiempo de Ejecución</p>
                                <span><?php echo e($cotizacion->tiempo_ejecucion_dias ?? '-'); ?> días</span>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Garantía de Servicio</p>
                                <span><?php echo e($cotizacion->garantia_servicio ?? 'No especificada'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if($cotizacion->detalles->count() > 0): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Detalle de la Cotización</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php $__currentLoopData = $detallesPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$categoria] ?? ['nombre' => ucfirst($categoria), 'color' => 'secondary', 'icono' => 'bi-box'];
                            ?>
                            <div class="border-bottom">
                                <div class="px-3 py-2 bg-<?php echo e($catInfo['color']); ?> bg-opacity-10">
                                    <h6 class="mb-0 text-<?php echo e($catInfo['color']); ?>">
                                        <i class="bi <?php echo e($catInfo['icono']); ?> me-2"></i><?php echo e($catInfo['nombre']); ?>

                                        <span class="badge bg-<?php echo e($catInfo['color']); ?> ms-2"><?php echo e($items->count()); ?></span>
                                    </h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="small">Descripción</th>
                                                <th class="small text-center">Cant.</th>
                                                <th class="small text-end">P.Unit</th>
                                                <?php if($items->where('descuento_porcentaje', '>', 0)->count() > 0): ?>
                                                    <th class="small text-center">Dto.</th>
                                                <?php endif; ?>
                                                <th class="small text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="small">
                                                        <?php echo e($item->descripcion); ?>

                                                        <?php if($item->especificaciones): ?>
                                                            <br><small class="text-muted"><?php echo e(Str::limit($item->especificaciones, 60)); ?></small>
                                                        <?php endif; ?>
                                                        <?php if($item->producto): ?>
                                                            <br><small class="text-primary"><i class="bi bi-link-45deg"></i> <?php echo e($item->producto->codigo); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="small text-center"><?php echo e(number_format($item->cantidad, $item->cantidad == intval($item->cantidad) ? 0 : 2)); ?> <?php echo e($item->unidad); ?></td>
                                                    <td class="small text-end">S/ <?php echo e(number_format($item->precio_unitario, 2)); ?></td>
                                                    <?php if($items->where('descuento_porcentaje', '>', 0)->count() > 0): ?>
                                                        <td class="small text-center">
                                                            <?php if($item->descuento_porcentaje > 0): ?>
                                                                <span class="text-danger"><?php echo e($item->descuento_porcentaje); ?>%</span>
                                                            <?php else: ?>
                                                                —
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td class="small text-end fw-bold">S/ <?php echo e(number_format($item->subtotal, 2)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="<?php echo e($items->where('descuento_porcentaje', '>', 0)->count() > 0 ? 4 : 3); ?>" class="small text-end">Subtotal <?php echo e($catInfo['nombre']); ?>:</th>
                                                <th class="small text-end">S/ <?php echo e(number_format($items->sum('subtotal'), 2)); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($cotizacion->condiciones_comerciales || $cotizacion->observaciones || $cotizacion->notas_internas): ?>
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Notas y Condiciones</h5>
                        </div>
                        <div class="card-body">
                            <?php if($cotizacion->condiciones_comerciales): ?>
                                <h6 class="small text-muted text-uppercase">Condiciones Comerciales</h6>
                                <p class="mb-3" style="white-space: pre-line;"><?php echo e($cotizacion->condiciones_comerciales); ?></p>
                            <?php endif; ?>
                            <?php if($cotizacion->observaciones): ?>
                                <h6 class="small text-muted text-uppercase">Observaciones</h6>
                                <p class="mb-3"><?php echo e($cotizacion->observaciones); ?></p>
                            <?php endif; ?>
                            <?php if($cotizacion->notas_internas): ?>
                                <div class="p-2 bg-warning bg-opacity-10 rounded">
                                    <h6 class="small text-muted text-uppercase"><i class="bi bi-lock me-1"></i>Notas Internas</h6>
                                    <p class="mb-0 small"><?php echo e($cotizacion->notas_internas); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            
            <div class="col-lg-4">

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Resumen de Inversión</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span class="resumen-valor">S/ <?php echo e(number_format($cotizacion->subtotal ?? 0, 2)); ?></span>
                        </div>
                        <?php if($cotizacion->descuento_monto > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento (<?php echo e(number_format($cotizacion->descuento_porcentaje, 1)); ?>%):</span>
                                <span class="resumen-valor">- S/ <?php echo e(number_format($cotizacion->descuento_monto, 2)); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Base Imponible:</span>
                                <span class="resumen-valor">S/ <?php echo e(number_format(($cotizacion->subtotal ?? 0) - ($cotizacion->descuento_monto ?? 0), 2)); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">
                                IGV (18%)
                                <?php if(!$cotizacion->incluye_igv): ?> <small>(no incluido)</small> <?php endif; ?>
                            </span>
                            <span class="resumen-valor">S/ <?php echo e(number_format($cotizacion->igv ?? 0, 2)); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="h6 mb-0 fw-bold">TOTAL:</span>
                            <span class="h5 mb-0 text-primary fw-bold">S/ <?php echo e(number_format($cotizacion->total ?? 0, 2)); ?></span>
                        </div>

                        
                        <?php if($cotizacion->detalles->count() > 0): ?>
                            <hr>
                            <p class="small text-muted fw-bold mb-2">Desglose por categoría:</p>
                            <?php $__currentLoopData = $detallesPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$cat] ?? ['nombre' => $cat, 'color' => 'secondary']; ?>
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span><i class="bi bi-circle-fill text-<?php echo e($catInfo['color']); ?> me-1" style="font-size:0.5rem;"></i><?php echo e($catInfo['nombre']); ?>:</span>
                                    <span class="fw-bold">S/ <?php echo e(number_format($items->sum('subtotal'), 2)); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Fechas</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Emisión:</span>
                            <span><?php echo e($cotizacion->fecha_emision?->format('d/m/Y') ?? '-'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Válida hasta:</span>
                            <span class="<?php echo e($cotizacion->fecha_vigencia?->isPast() ? 'text-danger fw-bold' : ''); ?>">
                                <?php echo e($cotizacion->fecha_vigencia?->format('d/m/Y') ?? '-'); ?>

                                <?php if($cotizacion->fecha_vigencia && !$cotizacion->fecha_vigencia->isPast()): ?>
                                    <small class="text-muted">(<?php echo e($cotizacion->dias_para_vencer); ?> días)</small>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if($cotizacion->fecha_envio): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Enviada:</span>
                                <span><?php echo e($cotizacion->fecha_envio->format('d/m/Y H:i')); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($cotizacion->fecha_respuesta): ?>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Respuesta:</span>
                                <span><?php echo e($cotizacion->fecha_respuesta->format('d/m/Y H:i')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php
                    $estadosFlow = [
                        'borrador' => ['nombre' => 'Borrador', 'color' => 'secondary', 'icono' => 'bi-pencil-square'],
                        'enviada' => ['nombre' => 'Enviada', 'color' => 'primary', 'icono' => 'bi-send'],
                        'aceptada' => ['nombre' => 'Aceptada', 'color' => 'success', 'icono' => 'bi-check-circle'],
                    ];
                    $estadoActualInfo = $estadosFlow[$cotizacion->estado] ?? ['nombre' => ucfirst($cotizacion->estado), 'color' => 'secondary', 'icono' => 'bi-circle'];
                    $siguienteEstado = match($cotizacion->estado) {
                        'borrador' => $estadosFlow['enviada'],
                        'enviada' => $estadosFlow['aceptada'],
                        default => null,
                    };
                ?>

                <?php if(!in_array($cotizacion->estado, ['aceptada', 'rechazada'])): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>Cambiar Estado</h6></div>
                    <div class="card-body">
                        
                        <?php if($siguienteEstado): ?>
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 py-2 bg-light rounded">
                                <span class="badge bg-<?php echo e($estadoActualInfo['color']); ?>"><i class="bi <?php echo e($estadoActualInfo['icono']); ?> me-1"></i><?php echo e($estadoActualInfo['nombre']); ?></span>
                                <i class="bi bi-arrow-right text-muted"></i>
                                <span class="badge bg-<?php echo e($siguienteEstado['color']); ?>"><i class="bi <?php echo e($siguienteEstado['icono']); ?> me-1"></i><?php echo e($siguienteEstado['nombre']); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2">
                            <?php if($cotizacion->estado === 'borrador'): ?>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 btn-enviar">
                                    <i class="bi bi-send me-2"></i>Enviar Cotización
                                </button>
                            <?php endif; ?>
                            <?php if($cotizacion->estado === 'enviada'): ?>
                                <button type="button" class="btn btn-outline-success btn-sm w-100 btn-aprobar">
                                    <i class="bi bi-check-circle me-2"></i>Marcar Aprobada
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-rechazar">
                                    <i class="bi bi-x-circle me-2"></i>Marcar Rechazada
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php elseif($cotizacion->estado === 'aceptada'): ?>
                
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #198754 !important;" data-aos="fade-up">
                    <div class="card-header bg-success text-white" style="border-radius: 16px 16px 0 0;">
                        <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Cotización Aprobada</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <i class="bi bi-calendar-check me-1"></i>
                            Aprobada el <?php echo e($cotizacion->fecha_respuesta?->format('d/m/Y H:i') ?? '-'); ?>

                        </p>

                        <?php if(isset($pedidoGenerado) && $pedidoGenerado): ?>
                            <hr class="my-2">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-primary"><i class="bi bi-box-seam me-1"></i>Pedido Generado</span>
                                <span class="badge bg-<?php echo e($pedidoGenerado->estado === 'pendiente' ? 'warning text-dark' : ($pedidoGenerado->estado === 'entregado' ? 'success' : 'info')); ?>">
                                    <?php echo e(ucfirst($pedidoGenerado->estado)); ?>

                                </span>
                            </div>
                            <div class="small mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Código:</span>
                                    <span class="fw-bold"><?php echo e($pedidoGenerado->codigo); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Total:</span>
                                    <span class="fw-bold">S/ <?php echo e(number_format($pedidoGenerado->total, 2)); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Finanzas:</span>
                                    <span><?php echo $pedidoGenerado->aprobacion_finanzas ? '<i class="bi bi-check-circle-fill text-success"></i> Aprobado' : '<i class="bi bi-clock text-warning"></i> Pendiente'; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Stock:</span>
                                    <span><?php echo $pedidoGenerado->aprobacion_stock ? '<i class="bi bi-check-circle-fill text-success"></i> Reservado' : '<i class="bi bi-clock text-warning"></i> Pendiente'; ?></span>
                                </div>
                            </div>
                            <a href="<?php echo e(route('admin-pedidos.show', $pedidoGenerado)); ?>" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Ver Pedido
                            </a>
                        <?php else: ?>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-info-circle me-1"></i>No se encontró un pedido vinculado a esta cotización.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php elseif($cotizacion->estado === 'rechazada'): ?>
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #dc3545 !important;" data-aos="fade-up">
                    <div class="card-header bg-danger text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-x-circle me-2"></i>Cotización Rechazada</h6></div>
                    <div class="card-body">
                        <?php if($cotizacion->motivo_rechazo): ?>
                            <p class="mb-0"><strong>Motivo:</strong> <?php echo e($cotizacion->motivo_rechazo); ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Sin motivo registrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6></div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('admin.crm.cotizaciones.pdf', $cotizacion)); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-pdf me-2"></i>Descargar PDF
                            </a>
                            <?php if(!in_array($cotizacion->estado, ['aceptada', 'rechazada'])): ?>
                            <a href="<?php echo e(route('admin.crm.cotizaciones.edit', $cotizacion)); ?>" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Cotización
                            </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-duplicar">
                                <i class="bi bi-copy me-2"></i>Duplicar
                            </button>
                            <?php if(!in_array($cotizacion->estado, ['aceptada'])): ?>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Auditoría</h6></div>
                    <div class="card-body small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Vendedor:</span>
                            <span><?php echo e($cotizacion->usuario?->persona?->name ?? $cotizacion->usuario?->email ?? '-'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado:</span>
                            <span><?php echo e($cotizacion->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Actualizado:</span>
                            <span><?php echo e($cotizacion->updated_at->format('d/m/Y H:i')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <form id="form-enviar" action="<?php echo e(route('admin.crm.cotizaciones.enviar', $cotizacion)); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
    <form id="form-aprobar" action="<?php echo e(route('admin.crm.cotizaciones.aprobar', $cotizacion)); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
    <form id="form-rechazar" action="<?php echo e(route('admin.crm.cotizaciones.rechazar', $cotizacion)); ?>" method="POST" class="d-none">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="motivo_rechazo" id="input-motivo-rechazo">
    </form>
    <form id="form-duplicar" action="<?php echo e(route('admin.crm.cotizaciones.duplicar', $cotizacion)); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
    <form id="form-eliminar" action="<?php echo e(route('admin.crm.cotizaciones.destroy', $cotizacion)); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?></form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {

    // ==================== ENVIAR COTIZACIÓN ====================
    $('.btn-enviar').on('click', function() {
        Swal.fire({
            title: '¿Enviar cotización?',
            html: `Se marcará como <strong>Enviada</strong> la cotización <strong><?php echo e($cotizacion->codigo); ?></strong>.<br><br>
                   <small class="text-muted">Esta acción cambiará el estado y registrará la fecha de envío.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-send me-1"></i> Sí, enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-enviar').submit();
            }
        });
    });

    // ==================== APROBAR COTIZACIÓN ====================
    $('.btn-aprobar').on('click', function() {
        Swal.fire({
            title: '¿Aprobar cotización?',
            html: `Se aprobará la cotización <strong><?php echo e($cotizacion->codigo); ?></strong> por un total de <strong class="text-primary">S/ <?php echo e(number_format($cotizacion->total, 2)); ?></strong>.<br><br>
                   <div class="text-start small">
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Cotización → <strong>Aceptada</strong></p>
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Prospecto → <strong>Convertido a Cliente</strong></p>
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Oportunidad → <strong>Ganada</strong></p>
                       <p class="mb-0"><i class="bi bi-check2 text-success me-1"></i> Pedido → <strong>Creado automáticamente</strong></p>
                   </div>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-aprobar').submit();
            }
        });
    });

    // ==================== RECHAZAR COTIZACIÓN ====================
    $('.btn-rechazar').on('click', function() {
        Swal.fire({
            title: '¿Rechazar cotización?',
            html: `Se marcará como <strong class="text-danger">Rechazada</strong> la cotización <strong><?php echo e($cotizacion->codigo); ?></strong>.`,
            icon: 'warning',
            input: 'textarea',
            inputLabel: 'Motivo del rechazo',
            inputPlaceholder: 'Ej: El cliente consiguió mejor precio con la competencia...',
            inputAttributes: {
                'aria-label': 'Motivo del rechazo',
                'maxlength': 500
            },
            inputValidator: (value) => {
                if (!value || value.trim().length < 5) {
                    return 'Debe ingresar un motivo (mínimo 5 caracteres)';
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Sí, rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-motivo-rechazo').val(result.value);
                $('#form-rechazar').submit();
            }
        });
    });

    // ==================== DUPLICAR COTIZACIÓN ====================
    $('.btn-duplicar').on('click', function() {
        Swal.fire({
            title: '¿Duplicar cotización?',
            html: `Se creará una nueva versión basada en <strong><?php echo e($cotizacion->codigo); ?></strong> con todos sus ítems.<br><br>
                   <small class="text-muted">La nueva cotización se abrirá en modo edición.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-copy me-1"></i> Sí, duplicar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-duplicar').submit();
            }
        });
    });

    // ==================== ELIMINAR COTIZACIÓN ====================
    $('.btn-eliminar').on('click', function() {
        Swal.fire({
            title: '¿Eliminar cotización?',
            html: `Se eliminará permanentemente la cotización <strong><?php echo e($cotizacion->codigo); ?></strong> y todos sus ítems.<br><br>
                   <strong class="text-danger">Esta acción no se puede deshacer.</strong>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-eliminar').submit();
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/cotizaciones/show.blade.php ENDPATH**/ ?>