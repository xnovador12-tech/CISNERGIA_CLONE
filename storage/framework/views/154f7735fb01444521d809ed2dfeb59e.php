
<?php $__env->startSection('title', 'Detalle Oportunidad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE OPORTUNIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.oportunidades.index')); ?>">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e($oportunidad->codigo); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-8">
                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2"><?php echo e($oportunidad->codigo); ?></span>
                            <?php 
                                $etapaColors = [
                                    'calificacion' => 'secondary', 
                                    'analisis_sitio' => 'info',
                                    'propuesta_tecnica' => 'primary',
                                    'negociacion' => 'warning', 
                                    'contrato' => 'dark',
                                    'ganada' => 'success', 
                                    'perdida' => 'danger'
                                ]; 
                            ?>
                            <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $oportunidad->etapa))); ?></span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.crm.oportunidades.edit', $oportunidad->slug)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Editar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-3"><?php echo e($oportunidad->nombre); ?></h4>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Cliente/Prospecto</p>
                                <p class="fw-bold mb-0">
                                    <?php if($oportunidad->cliente): ?>
                                        <span class="badge bg-success me-1">Cliente</span><?php echo e($oportunidad->cliente->nombre); ?>

                                    <?php elseif($oportunidad->prospecto): ?>
                                        <span class="badge bg-warning text-dark me-1">Prospecto</span><?php echo e($oportunidad->prospecto->nombre_completo); ?>

                                    <?php else: ?>
                                        <span class="text-muted">No asignado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Asignado a</p>
                                <p class="fw-bold mb-0"><?php echo e($oportunidad->vendedor->persona->name ?? 'Sin asignar'); ?></p>
                            </div>
                        </div>

                        <?php if($oportunidad->observaciones): ?>
                            <div class="bg-light p-3 rounded mb-3">
                                <p class="mb-0"><small class="text-muted">Observaciones:</small><br><?php echo e($oportunidad->observaciones); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-sun text-warning me-2"></i>Detalles del Sistema Solar</h6></div>
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            <div class="col-md-3">
                                <div class="bg-primary bg-opacity-10 rounded p-3">
                                    <i class="bi bi-lightning-charge fs-3 text-primary"></i>
                                    <p class="mb-0 small text-muted">Potencia</p>
                                    <h4 class="mb-0 fw-bold"><?php echo e(number_format($oportunidad->potencia_kw ?? 0, 1)); ?> kW</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-info bg-opacity-10 rounded p-3">
                                    <i class="bi bi-grid-3x3 fs-3 text-info"></i>
                                    <p class="mb-0 small text-muted">Paneles</p>
                                    <h4 class="mb-0 fw-bold"><?php echo e($oportunidad->cantidad_paneles ?? 0); ?></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <i class="bi bi-activity fs-3 text-warning"></i>
                                    <p class="mb-0 small text-muted">Producción Anual</p>
                                    <h4 class="mb-0 fw-bold"><?php echo e(number_format($oportunidad->produccion_anual_kwh ?? 0, 0)); ?> kWh</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <i class="bi bi-piggy-bank fs-3 text-success"></i>
                                    <p class="mb-0 small text-muted">Ahorro Anual</p>
                                    <h4 class="mb-0 fw-bold">S/ <?php echo e(number_format($oportunidad->ahorro_anual_soles ?? 0, 0)); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>Cotizaciones</h6>
                        <?php if(!in_array($oportunidad->etapa, ['ganada', 'perdida'])): ?>
                            <form action="<?php echo e(route('admin.crm.oportunidades.crear-cotizacion', $oportunidad->slug)); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?>
                                <button class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nueva Cotización</button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $oportunidad->cotizaciones ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <span class="badge bg-secondary me-2"><?php echo e($cotizacion->codigo); ?></span>
                                    <span class="badge bg-<?php echo e($cotizacion->estado == 'aprobada' ? 'success' : ($cotizacion->estado == 'rechazada' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($cotizacion->estado)); ?></span>
                                </div>
                                <div>
                                    <span class="fw-bold text-primary">S/ <?php echo e(number_format($cotizacion->total, 0)); ?></span>
                                    <a href="<?php echo e(route('admin.crm.cotizaciones.show', $cotizacion)); ?>" class="btn btn-sm btn-outline-primary ms-2"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center py-3"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay cotizaciones</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Valoración</h6></div>
                    <div class="card-body text-center">
                        <h2 class="text-primary fw-bold mb-3">S/ <?php echo e(number_format($oportunidad->monto_estimado, 0)); ?></h2>
                        <div class="mb-3">
                            <small class="text-muted">Probabilidad</small>
                            <div class="progress mt-1" style="height: 20px;">
                                <div class="progress-bar bg-<?php echo e($oportunidad->probabilidad >= 70 ? 'success' : ($oportunidad->probabilidad >= 40 ? 'warning' : 'danger')); ?>"
                                     style="width: <?php echo e($oportunidad->probabilidad); ?>%"><?php echo e($oportunidad->probabilidad); ?>%</div>
                            </div>
                        </div>
                        <p class="mb-0"><strong>Valor Ponderado:</strong> S/ <?php echo e(number_format($oportunidad->monto_estimado * $oportunidad->probabilidad / 100, 0)); ?></p>
                    </div>
                </div>

                
                <?php if(!in_array($oportunidad->etapa, ['ganada', 'perdida'])): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones</h6></div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <form action="<?php echo e(route('admin.crm.oportunidades.avanzar', $oportunidad->slug)); ?>" method="POST"><?php echo csrf_field(); ?>
                                <button class="btn btn-outline-primary btn-sm w-100"><i class="bi bi-arrow-right me-2"></i>Avanzar Etapa</button>
                            </form>
                            <form action="<?php echo e(route('admin.crm.oportunidades.ganada', $oportunidad->slug)); ?>" method="POST"><?php echo csrf_field(); ?>
                                <button class="btn btn-outline-success btn-sm w-100"><i class="bi bi-trophy me-2"></i>Marcar Ganada</button>
                            </form>
                            <form action="<?php echo e(route('admin.crm.oportunidades.perdida', $oportunidad->slug)); ?>" method="POST"><?php echo csrf_field(); ?>
                                <button class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-x-circle me-2"></i>Marcar Perdida</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php elseif($oportunidad->etapa === 'ganada'): ?>
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #198754 !important;" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-success text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-trophy me-2"></i>¡Oportunidad Ganada!</h6></div>
                    <div class="card-body">
                        <?php if($oportunidad->prospecto && !$oportunidad->prospecto->es_cliente): ?>
                            <p class="text-muted mb-3">El prospecto aún no ha sido convertido a cliente.</p>
                            <form action="<?php echo e(route('admin.crm.oportunidades.convertir-cliente', $oportunidad->slug)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-success w-100">
                                    <i class="bi bi-person-check me-2"></i>Convertir a Cliente
                                </button>
                            </form>
                        <?php elseif($oportunidad->cliente || ($oportunidad->prospecto && $oportunidad->prospecto->es_cliente)): ?>
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Cliente registrado:</strong> 
                                <?php echo e($oportunidad->cliente?->codigo ?? $oportunidad->prospecto?->cliente?->codigo); ?>

                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Sin prospecto asociado para convertir.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php elseif($oportunidad->etapa === 'perdida'): ?>
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #dc3545 !important;" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-danger text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-x-circle me-2"></i>Oportunidad Perdida</h6></div>
                    <div class="card-body">
                        <?php if($oportunidad->motivo_perdida): ?>
                            <p class="mb-0"><strong>Motivo:</strong> <?php echo e($oportunidad->motivo_perdida); ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Sin motivo registrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>
                    <div class="card-body">
                        <div class="mb-2"><small class="text-muted">Creada</small><p class="mb-0"><?php echo e($oportunidad->created_at->format('d/m/Y H:i')); ?></p></div>
                        <div class="mb-2"><small class="text-muted">Cierre Estimado</small><p class="mb-0"><?php echo e($oportunidad->fecha_cierre_estimada?->format('d/m/Y') ?? 'No definido'); ?></p></div>
                        <?php if($oportunidad->fecha_cierre_real): ?>
                            <div><small class="text-muted">Cierre Real</small><p class="mb-0"><?php echo e($oportunidad->fecha_cierre_real->format('d/m/Y')); ?></p></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/oportunidades/show.blade.php ENDPATH**/ ?>