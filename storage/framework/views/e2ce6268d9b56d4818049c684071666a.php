<?php $__env->startSection('title', 'Detalle Oportunidad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE OPORTUNIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
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
    <?php if(session('info')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i><?php echo e(session('info')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    <?php endif; ?>

    <?php
        $etapaColors = [
            'calificacion' => 'primary', 'evaluacion' => 'info',
            'propuesta_tecnica' => 'warning', 'negociacion' => 'secondary',
            'ganada' => 'success', 'perdida' => 'danger'
        ];
    ?>

    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-8">
                
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2"><?php echo e($oportunidad->codigo); ?></span>
                            <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?>">
                                <?php echo e(\App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa)); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('admin.crm.oportunidades.edit', ['oportunidad' => $oportunidad, 'redirect_to' => 'show'])); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Editar</a>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-3"><?php echo e($oportunidad->nombre); ?></h4>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Tipo</p>
                                <p class="mb-0">
                                    <span class="badge bg-<?php echo e(['producto' => 'success', 'servicio' => 'warning', 'mixto' => 'info'][$oportunidad->tipo_oportunidad] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst($oportunidad->tipo_oportunidad)); ?>

                                    </span>
                                    <span class="badge bg-light text-dark ms-1"><?php echo e(ucfirst($oportunidad->tipo_proyecto)); ?></span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Asignado a</p>
                                <p class="fw-bold mb-0"><?php echo e($oportunidad->vendedor->persona->name ?? 'Sin asignar'); ?> <?php echo e($oportunidad->vendedor->persona->surnames ?? ''); ?></p>
                            </div>
                        </div>

                        <?php if($oportunidad->descripcion): ?>
                            <div class="bg-light p-3 rounded mb-3">
                                <small class="text-muted d-block mb-1">Descripción del negocio:</small>
                                <p class="mb-0"><?php echo e($oportunidad->descripcion); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if($oportunidad->observaciones): ?>
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Observaciones:</small>
                                <p class="mb-0"><?php echo e($oportunidad->observaciones); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if($oportunidad->tipo_servicio || $oportunidad->requiere_visita_tecnica): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Datos Técnicos</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            
                            <?php if($oportunidad->tipo_servicio): ?>
                            <div class="col-md-6">
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <p class="mb-1 small text-muted"><i class="bi bi-wrench me-1"></i>Tipo de Servicio</p>
                                    <p class="mb-0 fw-bold"><?php echo e(ucfirst(str_replace('_', ' ', $oportunidad->tipo_servicio))); ?></p>
                                    <?php if($oportunidad->descripcion_servicio): ?>
                                        <p class="mb-0 mt-1 small text-muted"><?php echo e($oportunidad->descripcion_servicio); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            
                            <?php if($oportunidad->requiere_visita_tecnica): ?>
                            <div class="col-12">
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <p class="mb-1 small text-muted"><i class="bi bi-geo-alt me-1"></i>Visita Técnica</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-0"><strong>Fecha programada:</strong> <?php echo e($oportunidad->fecha_visita_programada?->format('d/m/Y') ?? 'Por definir'); ?></p>
                                        </div>
                                        <?php if($oportunidad->resultado_visita): ?>
                                        <div class="col-md-8">
                                            <p class="mb-0"><strong>Resultado:</strong> <?php echo e($oportunidad->resultado_visita); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($oportunidad->productosInteres->count() > 0): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="150">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i>Productos de Interés</h6>
                        <span class="badge bg-primary"><?php echo e($oportunidad->productosInteres->count()); ?> producto(s)</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center" style="width: 10%">Cant.</th>
                                        <th class="text-center" style="width: 12%">P. Unit.</th>
                                        <th class="text-center" style="width: 12%">Subtotal</th>
                                        <th>Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalProductos = 0; ?>
                                    <?php $__currentLoopData = $oportunidad->productosInteres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $subtotal = $producto->precio * $producto->pivot->cantidad;
                                        $totalProductos += $subtotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <i class="bi bi-box-seam text-primary me-1"></i>
                                            <strong class="small"><?php echo e($producto->name); ?></strong>
                                            <?php if($producto->marca): ?>
                                                <small class="text-muted ms-1">(<?php echo e($producto->marca->name); ?>)</small>
                                            <?php endif; ?>
                                            <br>
                                            <?php if($producto->tipo): ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem;"><?php echo e($producto->tipo->name); ?></span>
                                            <?php endif; ?>
                                            <?php if($producto->categorie): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.65rem;"><?php echo e($producto->categorie->name); ?></span>
                                            <?php endif; ?>
                                            <?php if($producto->codigo): ?>
                                                <small class="text-muted ms-1"><?php echo e($producto->codigo); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center fw-bold"><?php echo e(number_format($producto->pivot->cantidad, $producto->pivot->cantidad == intval($producto->pivot->cantidad) ? 0 : 2)); ?></td>
                                        <td class="text-center">S/ <?php echo e(number_format($producto->precio, 2)); ?></td>
                                        <td class="text-center fw-semibold">S/ <?php echo e(number_format($subtotal, 2)); ?></td>
                                        <td><small class="text-muted"><?php echo e($producto->pivot->notas ?? '-'); ?></small></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light fw-bold">
                                        <td colspan="3" class="text-end">Total Productos:</td>
                                        <td class="text-center text-primary">S/ <?php echo e(number_format($totalProductos, 2)); ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>Cotizaciones</h6>
                        <?php if(!in_array($oportunidad->etapa, ['ganada', 'perdida'])): ?>
                            <a href="<?php echo e(route('admin.crm.cotizaciones.create', ['oportunidad_id' => $oportunidad->id])); ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Nueva Cotización
                            </a>
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

                
                <div class="card border-4 borde-top-secondary shadow-sm mt-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Actividades</h6>
                        <?php if(!in_array($oportunidad->etapa, ['ganada', 'perdida'])): ?>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalActividad">
                                <i class="bi bi-plus me-1"></i>Nueva Actividad
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $oportunidad->actividades ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <?php
                                        $tipoIcons = [
                                            'llamada' => 'bi-telephone', 'email' => 'bi-envelope', 'reunion' => 'bi-people',
                                            'visita_tecnica' => 'bi-geo-alt', 'videollamada' => 'bi-camera-video',
                                            'whatsapp' => 'bi-whatsapp', 'tarea' => 'bi-check2-square', 'nota' => 'bi-sticky'
                                        ];
                                        $estadoColors = [
                                            'programada' => 'warning', 'en_progreso' => 'info', 'completada' => 'success',
                                            'cancelada' => 'danger', 'reprogramada' => 'secondary', 'no_realizada' => 'dark'
                                        ];
                                    ?>
                                    <i class="bi <?php echo e($tipoIcons[$actividad->tipo] ?? 'bi-circle'); ?> me-2 text-primary"></i>
                                    <strong class="small"><?php echo e(Str::limit($actividad->titulo, 35)); ?></strong>
                                    <span class="badge bg-<?php echo e($estadoColors[$actividad->estado] ?? 'secondary'); ?> ms-1"><?php echo e(ucfirst(str_replace('_', ' ', $actividad->estado))); ?></span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted"><?php echo e($actividad->fecha_programada?->format('d/m/Y')); ?></small>
                                    <a href="<?php echo e(route('admin.crm.actividades.show', $actividad)); ?>" class="btn btn-sm btn-outline-success ms-1"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center py-3"><i class="bi bi-calendar-x fs-3 d-block mb-2"></i>No hay actividades registradas</p>
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
                        <?php if($oportunidad->monto_final): ?>
                            <p class="mt-2 mb-0 text-success"><strong>Monto Final:</strong> S/ <?php echo e(number_format($oportunidad->monto_final, 0)); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if(!in_array($oportunidad->etapa, ['ganada', 'perdida'])): ?>
                <?php
                    $etapas = array_keys(\App\Models\Oportunidad::ETAPAS);
                    $indiceActual = array_search($oportunidad->etapa, $etapas);
                    $siguienteEtapa = ($indiceActual !== false && $indiceActual < count($etapas) - 2)
                        ? \App\Models\Oportunidad::ETAPAS[$etapas[$indiceActual + 1]] : null;
                    $etapaActualInfo = \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa];
                ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones</h6></div>
                    <div class="card-body">
                        
                        <?php if($siguienteEtapa): ?>
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 py-2 bg-light rounded">
                                <span class="badge bg-<?php echo e($etapaActualInfo['color']); ?>"><?php echo e($etapaActualInfo['nombre']); ?></span>
                                <i class="bi bi-arrow-right text-muted"></i>
                                <span class="badge bg-<?php echo e($siguienteEtapa['color']); ?>"><?php echo e($siguienteEtapa['nombre']); ?></span>
                                <small class="text-muted ms-1">(<?php echo e($siguienteEtapa['probabilidad']); ?>%)</small>
                            </div>
                        <?php else: ?>
                            <div class="text-center mb-3 py-2 bg-light rounded">
                                <small class="text-muted"><i class="bi bi-flag-fill text-success me-1"></i>Última etapa activa — Solo puede marcar como Ganada o Perdida</small>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2">
                            <?php if($siguienteEtapa): ?>
                            <form action="<?php echo e(route('admin.crm.oportunidades.avanzar', $oportunidad)); ?>" method="POST" id="form-avanzar"><?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 btn-avanzar">
                                    <i class="bi bi-arrow-right me-2"></i>Avanzar a <?php echo e($siguienteEtapa['nombre']); ?>

                                </button>
                            </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.crm.oportunidades.ganada', $oportunidad)); ?>" method="POST" id="form-ganada"><?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-outline-success btn-sm w-100 btn-ganada">
                                    <i class="bi bi-trophy me-2"></i>Marcar Ganada
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.crm.oportunidades.perdida', $oportunidad)); ?>" method="POST" id="form-perdida"><?php echo csrf_field(); ?>
                                <input type="hidden" name="motivo_perdida" id="input-motivo-perdida">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-perdida">
                                    <i class="bi bi-x-circle me-2"></i>Marcar Perdida
                                </button>
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
                            <form action="<?php echo e(route('admin.crm.oportunidades.convertir-cliente', $oportunidad)); ?>" method="POST" id="form-convertir"><?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-success w-100 btn-convertir">
                                    <i class="bi bi-person-check me-2"></i>Convertir a Cliente
                                </button>
                            </form>
                        <?php elseif($oportunidad->cliente || ($oportunidad->prospecto && $oportunidad->prospecto->es_cliente)): ?>
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle me-2"></i><strong>Cliente registrado:</strong> <?php echo e($oportunidad->cliente?->codigo ?? $oportunidad->prospecto?->cliente?->codigo); ?>

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
                            <p class="mb-1"><strong>Motivo:</strong> <?php echo e($oportunidad->motivo_perdida); ?></p>
                            <?php if($oportunidad->detalle_perdida): ?><p class="mb-1 text-muted small"><?php echo e($oportunidad->detalle_perdida); ?></p><?php endif; ?>
                            <?php if($oportunidad->competidor_ganador): ?><p class="mb-0"><strong>Competidor:</strong> <?php echo e($oportunidad->competidor_ganador); ?></p><?php endif; ?>
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
                            <div class="mb-2"><small class="text-muted">Cierre Real</small><p class="mb-0"><?php echo e($oportunidad->fecha_cierre_real->format('d/m/Y')); ?></p></div>
                        <?php endif; ?>
                        <div><small class="text-muted">Días en pipeline</small><p class="mb-0 fw-bold"><?php echo e($oportunidad->dias_en_pipeline); ?> días</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Nueva Actividad -->
    <div class="modal fade" id="modalActividad" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Actividad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin.crm.oportunidades.actividad', $oportunidad)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        
                        <div class="card border-0 rounded-0 border-start border-3 border-info mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                            <div class="card-body py-2">
                                <i class="bi bi-link-45deg text-info me-2"></i>
                                <small class="text-muted">
                                    Actividad vinculada a <strong>Oportunidad</strong>:
                                    <span class="badge bg-secondary"><?php echo e($oportunidad->codigo); ?></span>
                                    <?php echo e($oportunidad->nombre); ?>

                                </small>
                            </div>
                        </div>

                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Actividad <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2-modal" name="tipo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="llamada">📞 Llamada</option>
                                    <option value="email">📧 Email</option>
                                    <option value="reunion">👥 Reunión</option>
                                    <option value="visita_tecnica">🏗️ Visita Técnica</option>
                                    <option value="videollamada">🎥 Videollamada</option>
                                    <option value="whatsapp">💬 WhatsApp</option>
                                    <option value="tarea">✅ Tarea</option>
                                    <option value="nota">📝 Nota</option>
                                </select>
                            </div>

                            
                            <div class="col-md-6">
                                <label class="form-label">Prioridad</label>
                                <select class="form-select form-select-sm select2-modal" name="prioridad">
                                    <option value="baja">🟢 Baja</option>
                                    <option value="media" selected>🟡 Media</option>
                                    <option value="alta">🔴 Alta</option>
                                    <option value="urgente">🚨 Urgente</option>
                                </select>
                            </div>

                            
                            <div class="col-12">
                                <label class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="titulo" required placeholder="Ej: Reunión de presentación de propuesta">
                            </div>

                            
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control form-control-sm" name="descripcion" rows="3" placeholder="Detalles adicionales de la actividad..."></textarea>
                            </div>

                            
                            <div class="col-md-6">
                                <label class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control form-control-sm" name="fecha_programada" required>
                            </div>

                            
                            <div class="col-md-6">
                                <label class="form-label">Responsable <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2-modal" name="user_id" required>
                                    <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vendedor->id); ?>" <?php echo e(auth()->id() == $vendedor->id ? 'selected' : ''); ?>>
                                            <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona?->surnames ?? ''); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar Actividad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {

    // ==================== SELECT2 EN MODAL ====================
    $('#modalActividad').on('shown.bs.modal', function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            width: '100%',
            dropdownParent: $('#modalActividad')
        });
    });

    // ==================== AVANZAR ETAPA ====================
    $('.btn-avanzar').on('click', function() {
        Swal.fire({
            title: '¿Avanzar de etapa?',
            html: `La oportunidad <strong><?php echo e($oportunidad->codigo); ?></strong> pasará de <strong><?php echo e($etapaActualInfo['nombre']); ?></strong> a <strong><?php echo e($siguienteEtapa['nombre'] ?? 'siguiente'); ?></strong>.
                   <br><br><small class="text-muted">La probabilidad se ajustará a <?php echo e($siguienteEtapa['probabilidad'] ?? '-'); ?>%</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-arrow-right me-1"></i> Sí, avanzar a <?php echo e($siguienteEtapa['nombre'] ?? 'siguiente'); ?>',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-avanzar').submit();
            }
        });
    });

    // ==================== MARCAR GANADA ====================
    $('.btn-ganada').on('click', function() {
        Swal.fire({
            title: '🏆 ¿Marcar como Ganada?',
            html: `La oportunidad <strong><?php echo e($oportunidad->codigo); ?></strong> se marcará como <strong class="text-success">GANADA</strong> por <strong class="text-primary">S/ <?php echo e(number_format($oportunidad->monto_estimado, 0)); ?></strong>.<br><br>
                   <small class="text-muted">Se registrará la fecha de cierre real.</small>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trophy me-1"></i> Sí, marcar Ganada',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-ganada').submit();
            }
        });
    });

    // ==================== MARCAR PERDIDA ====================
    $('.btn-perdida').on('click', function() {
        Swal.fire({
            title: '¿Marcar como Perdida?',
            html: `La oportunidad <strong><?php echo e($oportunidad->codigo); ?></strong> se marcará como <strong class="text-danger">PERDIDA</strong>.`,
            icon: 'warning',
            input: 'textarea',
            inputLabel: 'Motivo de la pérdida',
            inputPlaceholder: 'Ej: El cliente eligió a la competencia por precio...',
            inputAttributes: { 'aria-label': 'Motivo de la pérdida', maxlength: 500 },
            inputValidator: (value) => {
                if (!value || value.trim().length < 5) {
                    return 'Debe ingresar un motivo (mínimo 5 caracteres)';
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Sí, marcar Perdida',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-motivo-perdida').val(result.value);
                $('#form-perdida').submit();
            }
        });
    });

    // ==================== CONVERTIR A CLIENTE ====================
    $('.btn-convertir').on('click', function() {
        Swal.fire({
            title: '¿Convertir a Cliente?',
            html: `El prospecto <strong><?php echo e($oportunidad->prospecto->nombre_completo ?? 'N/A'); ?></strong> será registrado como <strong class="text-success">Cliente</strong> en el sistema.<br><br>
                   <small class="text-muted">Se creará un registro de cliente con toda la información del prospecto.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-person-check me-1"></i> Sí, convertir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-convertir').submit();
            }
        });
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/oportunidades/show.blade.php ENDPATH**/ ?>