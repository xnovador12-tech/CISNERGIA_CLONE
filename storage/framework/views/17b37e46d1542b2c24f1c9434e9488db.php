

<?php $__env->startSection('title', 'Detalle Prospecto'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .scoring-badge-lg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 1.5rem;
    }
    .scoring-A { background-color: #198754; color: white; }
    .scoring-B { background-color: #ffc107; color: #212529; }
    .scoring-C { background-color: #dc3545; color: white; }
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
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE PROSPECTO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin.crm.prospectos.index')); ?>">Prospectos</a></li>
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

    <div class="container-fluid">
        <div class="row g-4">
            <!-- Columna Principal -->
            <div class="col-lg-8">
                <!-- Información del Prospecto -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2"><?php echo e($prospecto->codigo); ?></span>
                            <?php
                                $estadoColors = [
                                    'nuevo' => 'secondary',
                                    'contactado' => 'primary',
                                    'calificado' => 'success',
                                    'descartado' => 'danger',
                                    'convertido' => 'info',
                                ];
                            ?>
                            <span class="badge bg-<?php echo e($estadoColors[$prospecto->estado] ?? 'secondary'); ?>">
                                <?php echo e(ucfirst($prospecto->estado)); ?>

                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.crm.prospectos.edit', $prospecto)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <?php if($prospecto->estado === 'calificado'): ?>
                                <form action="<?php echo e(route('admin.crm.prospectos.crear-oportunidad', $prospecto)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-arrow-right-circle me-1"></i>Crear Oportunidad
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
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
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope text-primary me-2"></i>
                                            <a href="mailto:<?php echo e($prospecto->email); ?>"><?php echo e($prospecto->email); ?></a>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone text-primary me-2"></i>
                                            <a href="tel:<?php echo e($prospecto->telefono); ?>"><?php echo e($prospecto->telefono ?? 'N/A'); ?></a>
                                        </div>
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
                                                        <br><?php echo e($prospecto->distrito->nombre); ?>, <?php echo e($prospecto->distrito->provincia->nombre ?? ''); ?>, <?php echo e($prospecto->distrito->departamento->nombre ?? ''); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="scoring-badge-lg scoring-<?php echo e($prospecto->scoring); ?> mx-auto mb-2" 
                                     data-bs-toggle="modal" data-bs-target="#modalScoring" 
                                     style="cursor: pointer;" title="Clic para editar scoring">
                                    <?php echo e($prospecto->scoring); ?>

                                </div>
                                <p class="mb-1 fw-bold">Scoring: <?php echo e($prospecto->scoring_puntos); ?>/100</p>
                                <div class="progress mx-auto" style="width: 100px; height: 8px;">
                                    <div class="progress-bar bg-<?php echo e($prospecto->scoring == 'A' ? 'success' : ($prospecto->scoring == 'B' ? 'warning' : 'danger')); ?>"
                                         style="width: <?php echo e($prospecto->scoring_puntos); ?>%"></div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#modalScoring">
                                    <i class="bi bi-pencil me-1"></i>Editar Scoring
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Energía Solar -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-sun text-warning me-2"></i>Interés en Energía Solar</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 text-center">
                                <div class="bg-light rounded p-3">
                                    <i class="bi bi-lightning-charge fs-3 text-warning"></i>
                                    <p class="mb-0 small text-muted">Consumo Mensual</p>
                                    <h5 class="mb-0 fw-bold"><?php echo e(number_format($prospecto->consumo_mensual_kwh ?? 0, 0)); ?> kWh</h5>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-light rounded p-3">
                                    <i class="bi bi-cash-stack fs-3 text-success"></i>
                                    <p class="mb-0 small text-muted">Factura Mensual</p>
                                    <h5 class="mb-0 fw-bold">S/ <?php echo e(number_format($prospecto->factura_mensual_soles ?? 0, 0)); ?></h5>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-light rounded p-3">
                                    <i class="bi bi-rulers fs-3 text-info"></i>
                                    <p class="mb-0 small text-muted">Área Disponible</p>
                                    <h5 class="mb-0 fw-bold"><?php echo e(number_format($prospecto->area_disponible_m2 ?? 0, 0)); ?> m²</h5>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="bg-light rounded p-3">
                                    <i class="bi bi-house fs-3 text-primary"></i>
                                    <p class="mb-0 small text-muted">Tipo Inmueble</p>
                                    <h5 class="mb-0 fw-bold"><?php echo e(ucfirst(str_replace('_', ' ', $prospecto->tipo_inmueble ?? 'N/A'))); ?></h5>
                                </div>
                            </div>
                        </div>

                        <?php if($prospecto->presupuesto_estimado): ?>
                            <div class="mt-3 p-3 bg-primary bg-opacity-10 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-wallet2 text-primary me-2"></i>
                                    <span class="fw-bold">Presupuesto Estimado:</span>
                                    <span class="ms-2">
                                        <?php
                                            $presupuestos = [
                                                'menos_10k' => 'Menos de S/ 10,000',
                                                '10k_30k' => 'S/ 10,000 - S/ 30,000',
                                                '30k_50k' => 'S/ 30,000 - S/ 50,000',
                                                '50k_100k' => 'S/ 50,000 - S/ 100,000',
                                                'mas_100k' => 'Más de S/ 100,000',
                                            ];
                                        ?>
                                        <?php echo e($presupuestos[$prospecto->presupuesto_estimado] ?? $prospecto->presupuesto_estimado); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notas -->
                <?php if($prospecto->notas): ?>
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-journal-text me-2"></i>Notas</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><?php echo e($prospecto->notas); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Actividades -->
                <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="300">
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
                <!-- Clasificación -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
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
                                    $segmentoColors = [
                                        'residencial' => 'info',
                                        'comercial' => 'warning',
                                        'industrial' => 'primary',
                                        'agricola' => 'success',
                                    ];
                                ?>
                                <span class="badge bg-<?php echo e($segmentoColors[$prospecto->segmento] ?? 'secondary'); ?>">
                                    <?php echo e(ucfirst($prospecto->segmento)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Origen</small>
                            <p class="mb-0">
                                <?php
                                    $origenIcons = [
                                        'web' => 'globe',
                                        'facebook' => 'facebook',
                                        'instagram' => 'instagram',
                                        'google_ads' => 'google',
                                        'referido' => 'people',
                                        'llamada' => 'telephone',
                                        'visita' => 'person-walking',
                                        'feria' => 'calendar-event',
                                        'otro' => 'tag',
                                    ];
                                ?>
                                <i class="bi bi-<?php echo e($origenIcons[$prospecto->origen] ?? 'tag'); ?> me-1"></i>
                                <?php echo e(ucfirst(str_replace('_', ' ', $prospecto->origen))); ?>

                            </p>
                        </div>
                        <?php if($prospecto->origen_detalle): ?>
                            <div class="mb-3">
                                <small class="text-muted">Detalle Origen</small>
                                <p class="mb-0"><?php echo e($prospecto->origen_detalle); ?></p>
                            </div>
                        <?php endif; ?>
                        <div>
                            <small class="text-muted">Asignado a</small>
                            <p class="mb-0 fw-bold"><?php echo e($prospecto->vendedor?->persona?->name ?? 'Sin asignar'); ?> <?php echo e($prospecto->vendedor?->persona?->surnames ?? ''); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="mailto:<?php echo e($prospecto->email); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope me-2"></i>Enviar Email
                            </a>
                            <a href="tel:<?php echo e($prospecto->telefono); ?>" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-telephone me-2"></i>Llamar
                            </a>
                            <a href="https://wa.me/51<?php echo e(preg_replace('/[^0-9]/', '', $prospecto->telefono)); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                            <?php if($prospecto->estado !== 'calificado'): ?>
                                <form action="<?php echo e(route('admin.crm.prospectos.actualizar-estado', $prospecto)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="hidden" name="estado" value="calificado">
                                    <button type="submit" class="btn btn-outline-warning btn-sm w-100">
                                        <i class="bi bi-star me-2"></i>Marcar Calificado
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="300">
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
                        <?php if($prospecto->primer_contacto_at): ?>
                            <div class="mb-2">
                                <small class="text-muted">Primer contacto</small>
                                <p class="mb-0"><?php echo e($prospecto->primer_contacto_at->format('d/m/Y H:i')); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($prospecto->ultimo_contacto_at): ?>
                            <div>
                                <small class="text-muted">Último contacto</small>
                                <p class="mb-0"><?php echo e($prospecto->ultimo_contacto_at->format('d/m/Y H:i')); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Actividad -->
    <div class="modal fade" id="modalActividad" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Actividad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin.crm.prospectos.actividad', $prospecto)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipo" required>
                                <option value="llamada">Llamada</option>
                                <option value="reunion">Reunión</option>
                                <option value="visita">Visita Técnica</option>
                                <option value="email">Email</option>
                                <option value="tarea">Tarea</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="fecha_programada" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Actividad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Scoring -->
    <div class="modal fade" id="modalScoring" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('admin.crm.prospectos.actualizar-scoring', $prospecto)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-graph-up me-2"></i>Editar Scoring</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Categoría de Scoring <span class="text-danger">*</span></label>
                            <select class="form-select" name="scoring" required>
                                <option value="A" <?php echo e($prospecto->scoring == 'A' ? 'selected' : ''); ?>>A - Alto (Cliente potencial calificado)</option>
                                <option value="B" <?php echo e($prospecto->scoring == 'B' ? 'selected' : ''); ?>>B - Medio (Interés moderado)</option>
                                <option value="C" <?php echo e($prospecto->scoring == 'C' ? 'selected' : ''); ?>>C - Bajo (Bajo interés)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Puntos de Scoring (0-100) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="scoring_puntos" 
                                   value="<?php echo e($prospecto->scoring_puntos); ?>" min="0" max="100" required>
                            <div class="form-text">
                                <strong>Guía:</strong> 0-40 = C (Bajo), 41-70 = B (Medio), 71-100 = A (Alto)
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/prospectos/show.blade.php ENDPATH**/ ?>