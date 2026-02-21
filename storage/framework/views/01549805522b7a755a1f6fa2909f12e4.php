<?php $__env->startSection('title', 'Detalle Prospecto'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
        border-left: 2px solid #dee2e6;
    }
    .timeline-item:last-child { border-left: 2px solid transparent; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0d6efd;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $wishlistTotal = isset($wishlistItems) && $wishlistItems->count() > 0
            ? $wishlistItems->sum(fn($i) => $i->precio_descuento && $i->precio_descuento < $i->precio ? $i->precio_descuento : $i->precio)
            : 0;
        $oportunidadParams = ['prospecto_id' => $prospecto->id];
        if ($wishlistTotal > 0) {
            $oportunidadParams['monto_estimado'] = $wishlistTotal;
        }
    ?>

    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.prospectos.index')); ?>">Prospectos</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e($prospecto->codigo); ?></li>
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
            <!-- Columna Principal -->
            <div class="col-lg-8">
                <!-- Información del Prospecto -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2"><?php echo e($prospecto->codigo); ?></span>
                            <?php
                                $estadoColors = [
                                    'nuevo' => 'secondary',
                                    'contactado' => 'primary',
                                    'calificado' => 'success',
                                    'descartado' => 'danger',
                                    'convertido' => 'dark',
                                ];
                            ?>
                            <span class="badge bg-<?php echo e($estadoColors[$prospecto->estado] ?? 'secondary'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $prospecto->estado))); ?>

                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.crm.prospectos.edit', ['prospecto' => $prospecto, 'redirect_to' => 'show'])); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <?php if($prospecto->estado === 'calificado' && !$prospecto->es_cliente): ?>
                                <a href="<?php echo e(route('admin.crm.oportunidades.create', $oportunidadParams)); ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-arrow-right-circle me-1"></i>Crear Oportunidad
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-1">
                                    <?php if($prospecto->tipo_persona == 'juridica'): ?>
                                        <?php echo e($prospecto->razon_social ?? $prospecto->nombre); ?>

                                    <?php else: ?>
                                        <?php echo e($prospecto->nombre); ?> <?php echo e($prospecto->apellidos); ?>

                                    <?php endif; ?>
                                </h4>
                                <p class="text-muted mb-3">
                                    <?php if($prospecto->tipo_persona == 'juridica' && $prospecto->ruc): ?>
                                        RUC: <?php echo e($prospecto->ruc); ?>

                                    <?php elseif($prospecto->dni): ?>
                                        DNI: <?php echo e($prospecto->dni); ?>

                                    <?php endif; ?>
                                </p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <?php if($prospecto->email): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope text-primary me-2"></i>
                                            <a href="mailto:<?php echo e($prospecto->email); ?>"><?php echo e($prospecto->email); ?></a>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($prospecto->telefono): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone text-primary me-2"></i>
                                            <a href="tel:<?php echo e($prospecto->telefono); ?>"><?php echo e($prospecto->telefono); ?></a>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($prospecto->celular): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-phone text-success me-2"></i>
                                            <a href="tel:<?php echo e($prospecto->celular); ?>"><?php echo e($prospecto->celular); ?></a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if($prospecto->direccion): ?>
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="bi bi-geo-alt text-primary me-2 mt-1"></i>
                                            <span><?php echo e($prospecto->direccion); ?>

                                                <?php if($prospecto->distrito): ?>
                                                    <br><?php echo e($prospecto->distrito->nombre); ?>

                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <?php if($prospecto->observaciones): ?>
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-journal-text me-2"></i>Observaciones</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><?php echo e($prospecto->observaciones); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Oportunidades del Prospecto -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Oportunidades</h6>
                        <?php if($prospecto->estado === 'calificado' && !$prospecto->es_cliente): ?>
                            <a href="<?php echo e(route('admin.crm.oportunidades.create', $oportunidadParams)); ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Nueva
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $prospecto->oportunidades ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oportunidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <?php
                                        $etapaColors = [
                                            'calificacion' => 'primary', 'evaluacion' => 'info', 'propuesta_tecnica' => 'warning',
                                            'negociacion' => 'secondary', 'ganada' => 'success', 'perdida' => 'danger'
                                        ];
                                    ?>
                                    <span class="badge bg-secondary me-1"><?php echo e($oportunidad->codigo); ?></span>
                                    <strong class="small"><?php echo e(Str::limit($oportunidad->nombre, 30)); ?></strong>
                                    <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?> ms-1"><?php echo e(ucfirst(str_replace('_', ' ', $oportunidad->etapa))); ?></span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-primary small">S/ <?php echo e(number_format($oportunidad->monto_estimado, 0)); ?></span>
                                    <a href="<?php echo e(route('admin.crm.oportunidades.show', $oportunidad)); ?>" class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center py-3"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay oportunidades registradas</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Productos de Interés - Wishlist E-commerce -->
                <?php if(isset($wishlistItems) && $wishlistItems->count() > 0): ?>
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="bi bi-heart text-danger me-2"></i>Productos de Interés (E-commerce)</h6>
                            <span class="badge bg-danger"><?php echo e($wishlistItems->count()); ?> productos</span>
                        </div>
                        <div class="card-body">
                            <div class="card border-0 rounded-0 border-start border-3 border-warning mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #fff8e1">
                                <div class="card-body py-2">
                                    <i class="bi bi-lightbulb text-warning me-2"></i>
                                    <small class="text-muted">Estos son los productos que el prospecto agregó a favoritos en la tienda online. Use esta información para personalizar su propuesta.</small>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><i class="bi bi-box-seam text-primary me-1"></i><?php echo e($item->nombre); ?></td>
                                                <td class="text-end fw-bold">
                                                    <?php if($item->precio_descuento && $item->precio_descuento < $item->precio): ?>
                                                        <span class="text-decoration-line-through text-muted small me-1">S/ <?php echo e(number_format($item->precio, 2)); ?></span>
                                                        <span class="text-danger">S/ <?php echo e(number_format($item->precio_descuento, 2)); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-primary">S/ <?php echo e(number_format($item->precio, 2)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><small class="text-muted"><?php echo e(\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')); ?></small></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td class="fw-bold">Valor total estimado</td>
                                            <td class="text-end fw-bold text-primary">
                                                S/ <?php echo e(number_format($wishlistItems->sum(fn($i) => $i->precio_descuento && $i->precio_descuento < $i->precio ? $i->precio_descuento : $i->precio), 2)); ?>

                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php elseif($prospecto->registered_user_id): ?>
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-heart text-danger me-2"></i>Productos de Interés (E-commerce)</h6>
                        </div>
                        <div class="card-body text-center text-muted py-3">
                            <i class="bi bi-heart fs-3 d-block mb-2"></i>
                            El cliente tiene cuenta en la tienda pero aún no ha agregado productos a favoritos.
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Actividades -->
                <div class="card border-0 shadow-sm" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Actividades</h6>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalActividad">
                            <i class="bi bi-plus me-1"></i>Nueva Actividad
                        </button>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $prospecto->actividades ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="badge bg-<?php echo e($actividad->tipo == 'llamada' ? 'primary' : ($actividad->tipo == 'reunion' ? 'success' : 'info')); ?> me-2">
                                            <?php echo e(ucfirst($actividad->tipo)); ?>

                                        </span>
                                        <strong><?php echo e($actividad->titulo); ?></strong>
                                    </div>
                                    <small class="text-muted"><?php echo e($actividad->fecha_programada->format('d/m/Y H:i')); ?></small>
                                </div>
                                <?php if($actividad->descripcion): ?>
                                    <p class="text-muted small mb-0 mt-1"><?php echo e($actividad->descripcion); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center py-3">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No hay actividades registradas
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral -->
            <div class="col-lg-4">
                <!-- Cambiar Estado -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>Cambiar Estado</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.crm.prospectos.actualizar-estado', $prospecto)); ?>" method="POST" id="form-actualizar-estado">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select name="estado" id="select-estado-prospecto" class="form-select form-select-sm select2_bootstrap w-100 mb-2" data-placeholder="Seleccionar estado...">
                                <?php $__currentLoopData = ['nuevo' => 'Nuevo', 'contactado' => 'Contactado', 'calificado' => 'Calificado', 'descartado' => 'Descartado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e($prospecto->estado == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div id="motivo_descarte_show" style="<?php echo e($prospecto->estado == 'descartado' ? '' : 'display:none'); ?>">
                                <input type="text" name="motivo_descarte" class="form-control form-control-sm mb-2" placeholder="Motivo de descarte..." value="<?php echo e($prospecto->motivo_descarte); ?>">
                            </div>
                            <hr class="my-2">
                            <button type="button" class="btn btn-sm btn-primary w-100 btn-actualizar-estado">
                                <i class="bi bi-check-circle me-1"></i>Actualizar Estado
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Clasificación -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Clasificación</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Tipo</small>
                            <p class="mb-0 fw-bold"><?php echo e($prospecto->tipo_persona == 'natural' ? 'Persona Natural' : 'Empresa'); ?></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Segmento</small>
                            <p class="mb-0">
                                <?php
                                    $segmentoColors = ['residencial' => 'info', 'comercial' => 'warning', 'industrial' => 'primary', 'agricola' => 'success'];
                                ?>
                                <span class="badge bg-<?php echo e($segmentoColors[$prospecto->segmento] ?? 'secondary'); ?>">
                                    <?php echo e(ucfirst($prospecto->segmento)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Tipo de Interés</small>
                            <p class="mb-0 fw-bold"><?php echo e(ucfirst($prospecto->tipo_interes)); ?></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Origen</small>
                            <p class="mb-0">
                                <?php
                                    $origenIcons = ['sitio_web' => 'globe', 'redes_sociales' => 'share', 'llamada' => 'telephone', 'referido' => 'people', 'ecommerce' => 'cart3', 'otro' => 'tag'];
                                ?>
                                <i class="bi bi-<?php echo e($origenIcons[$prospecto->origen] ?? 'tag'); ?> me-1"></i>
                                <?php echo e(ucfirst(str_replace('_', ' ', $prospecto->origen))); ?>

                            </p>
                        </div>
                        <?php if($prospecto->nivel_interes): ?>
                        <div class="mb-3">
                            <small class="text-muted">Nivel de Interés</small>
                            <p class="mb-0 fw-bold"><?php echo e(ucfirst(str_replace('_', ' ', $prospecto->nivel_interes))); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($prospecto->urgencia): ?>
                        <div class="mb-3">
                            <small class="text-muted">Urgencia</small>
                            <p class="mb-0"><?php echo e(ucfirst(str_replace('_', ' ', $prospecto->urgencia))); ?></p>
                        </div>
                        <?php endif; ?>
                        <div>
                            <small class="text-muted">Asignado a</small>
                            <p class="mb-0 fw-bold"><?php echo e($prospecto->vendedor?->persona?->name ?? 'Sin asignar'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if($prospecto->email): ?>
                            <a href="mailto:<?php echo e($prospecto->email); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope me-2"></i>Enviar Email
                            </a>
                            <?php endif; ?>
                            <?php if($prospecto->celular): ?>
                            <a href="https://wa.me/51<?php echo e(preg_replace('/[^0-9]/', '', $prospecto->celular)); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                            <?php endif; ?>
                            <?php if($prospecto->telefono || $prospecto->celular): ?>
                            <a href="tel:<?php echo e($prospecto->celular ?? $prospecto->telefono); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-telephone me-2"></i>Llamar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="card border-0 shadow-sm" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Creado</small>
                            <p class="mb-0"><?php echo e($prospecto->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Última actualización</small>
                            <p class="mb-0"><?php echo e($prospecto->updated_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php if($prospecto->fecha_primer_contacto): ?>
                        <div class="mb-2">
                            <small class="text-muted">Primer contacto</small>
                            <p class="mb-0"><?php echo e($prospecto->fecha_primer_contacto->format('d/m/Y')); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($prospecto->fecha_proximo_contacto): ?>
                        <div>
                            <small class="text-muted">Próximo contacto</small>
                            <p class="mb-0 <?php echo e($prospecto->fecha_proximo_contacto->isPast() ? 'text-danger fw-bold' : ''); ?>">
                                <?php echo e($prospecto->fecha_proximo_contacto->format('d/m/Y')); ?>

                                <?php if($prospecto->fecha_proximo_contacto->isPast()): ?>
                                    <i class="bi bi-exclamation-triangle ms-1"></i>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endif; ?>
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
                <form action="<?php echo e(route('admin.crm.prospectos.actividad', $prospecto)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        
                        <div class="card border-0 rounded-0 border-start border-3 border-info mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                            <div class="card-body py-2">
                                <i class="bi bi-link-45deg text-info me-2"></i>
                                <small class="text-muted">
                                    Actividad vinculada a <strong>Prospecto</strong>:
                                    <span class="badge bg-secondary"><?php echo e($prospecto->codigo); ?></span>
                                    <?php echo e($prospecto->nombre_completo); ?>

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

    // ==================== TOGGLE MOTIVO DESCARTE ====================
    $('#select-estado-prospecto').on('change', function() {
        $('#motivo_descarte_show').toggle($(this).val() === 'descartado');
    }).trigger('change');

    // ==================== SELECT2 EN MODAL ====================
    $('#modalActividad').on('shown.bs.modal', function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            width: '100%',
            dropdownParent: $('#modalActividad')
        });
    });

    // ==================== ACTUALIZAR ESTADO ====================
    var estadoTextos = {
        'nuevo': { icon: 'info', color: '#6c757d', label: 'Nuevo' },
        'contactado': { icon: 'info', color: '#0d6efd', label: 'Contactado' },
        'calificado': { icon: 'success', color: '#198754', label: 'Calificado' },
        'descartado': { icon: 'error', color: '#dc3545', label: 'Descartado' }
    };

    $('.btn-actualizar-estado').on('click', function() {
        var estadoSeleccionado = $('#select-estado-prospecto').val();
        var info = estadoTextos[estadoSeleccionado] || { icon: 'question', color: '#0d6efd', label: estadoSeleccionado };
        var textoExtra = estadoSeleccionado === 'descartado' ? '<br><br><small class="text-danger">El prospecto quedará marcado como descartado.</small>' : '';

        Swal.fire({
            title: '¿Actualizar estado?',
            html: `El prospecto <strong><?php echo e($prospecto->nombre_completo); ?></strong> cambiará a estado <strong>${info.label}</strong>.${textoExtra}`,
            icon: info.icon,
            showCancelButton: true,
            confirmButtonColor: info.color,
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-actualizar-estado').submit();
            }
        });
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/prospectos/show.blade.php ENDPATH**/ ?>