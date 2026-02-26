<?php $__env->startSection('title', 'Detalle Actividad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE ACTIVIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.actividades.index')); ?>">Actividades</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e(Str::limit($actividad->titulo, 40)); ?></li>
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

    <?php if(session('info')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i><?php echo e(session('info')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    <?php endif; ?>

    <?php
        $tipoIcons = ['llamada' => 'telephone', 'reunion' => 'people', 'visita_tecnica' => 'geo-alt', 'email' => 'envelope', 'whatsapp' => 'whatsapp'];
        $tipoColors = ['llamada' => 'primary', 'reunion' => 'success', 'visita_tecnica' => 'warning', 'email' => 'info', 'whatsapp' => 'success'];
        $estadoColors = ['programada' => 'warning', 'completada' => 'success', 'cancelada' => 'danger', 'reprogramada' => 'primary', 'no_realizada' => 'secondary'];
        $prioridadIcons = ['alta' => '🔴', 'media' => '🟡', 'baja' => '🟢'];
    ?>

    <div class="container-fluid">
        <div class="row g-4">
            <!-- Columna Principal -->
            <div class="col-lg-8">
                <!-- Información de la Actividad -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2"><?php echo e($actividad->codigo); ?></span>
                            <span class="badge bg-<?php echo e($tipoColors[$actividad->tipo] ?? 'secondary'); ?>">
                                <i class="bi bi-<?php echo e($tipoIcons[$actividad->tipo] ?? 'calendar'); ?> me-1"></i><?php echo e(ucfirst(str_replace('_', ' ', $actividad->tipo))); ?>

                            </span>
                            <span class="badge bg-<?php echo e($estadoColors[$actividad->estado] ?? 'secondary'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $actividad->estado))); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('admin.crm.actividades.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-1"><?php echo e($actividad->titulo); ?></h4>
                        <?php if($actividad->descripcion): ?>
                            <p class="text-muted mb-3"><?php echo nl2br(e($actividad->descripcion)); ?></p>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar3 text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Fecha Programada</small>
                                        <p class="mb-0 fw-bold"><?php echo e($actividad->fecha_programada->format('d/m/Y H:i')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-flag text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Prioridad</small>
                                        <p class="mb-0 fw-bold"><?php echo e($prioridadIcons[$actividad->prioridad] ?? ''); ?> <?php echo e(ucfirst($actividad->prioridad)); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php if($actividad->ubicacion): ?>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Ubicación</small>
                                        <p class="mb-0 fw-bold"><?php echo e($actividad->ubicacion); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Datos de Contacto (según tipo de actividad) -->
                <?php if(in_array($actividad->tipo, ['llamada', 'whatsapp', 'email', 'reunion']) && $actividad->actividadable): ?>
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Datos de Contacto</h6>
                    </div>
                    <div class="card-body">
                        <?php
                            $telefono = $actividad->telefono_contacto;
                            $email = $actividad->email_contacto;
                            $nombreContacto = $actividad->actividadable->nombre_completo ?? $actividad->actividadable->nombre ?? 'N/A';
                        ?>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted">Contacto</small>
                                <p class="mb-0 fw-bold"><?php echo e($nombreContacto); ?></p>
                            </div>
                            <?php if($telefono && in_array($actividad->tipo, ['llamada', 'whatsapp', 'reunion'])): ?>
                            <div class="col-md-4">
                                <small class="text-muted">Teléfono</small>
                                <p class="mb-0 fw-bold">
                                    <i class="bi bi-telephone text-primary me-1"></i>
                                    <a href="tel:<?php echo e($telefono); ?>" class="text-decoration-none"><?php echo e($telefono); ?></a>
                                    <?php if($actividad->tipo === 'whatsapp'): ?>
                                        <a href="https://wa.me/51<?php echo e(preg_replace('/\D/', '', $telefono)); ?>" target="_blank" class="btn btn-sm btn-success ms-2" title="Abrir WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                            <?php if($email && in_array($actividad->tipo, ['email', 'reunion'])): ?>
                            <div class="col-md-4">
                                <small class="text-muted">Email</small>
                                <p class="mb-0 fw-bold">
                                    <i class="bi bi-envelope text-info me-1"></i>
                                    <a href="mailto:<?php echo e($email); ?>" class="text-decoration-none"><?php echo e($email); ?></a>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Entidad Relacionada -->
                <?php if($actividad->actividadable): ?>
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Relacionado Con</h6>
                        <div>
                            <?php if($actividad->actividadable_type == 'App\Models\Prospecto'): ?>
                                <a href="<?php echo e(route('admin.crm.prospectos.show', $actividad->actividadable)); ?>" class="btn btn-sm btn-outline-primary">
                                    Ver Prospecto
                                </a>
                            <?php elseif($actividad->actividadable_type == 'App\Models\Oportunidad'): ?>
                                <a href="<?php echo e(route('admin.crm.oportunidades.show', $actividad->actividadable)); ?>" class="btn btn-sm btn-outline-primary">
                                    Ver Oportunidad
                                </a>
                            <?php elseif($actividad->actividadable_type == 'App\Models\Cliente'): ?>
                                <a href="<?php echo e(route('admin.crm.clientes.show', $actividad->actividadable)); ?>" class="btn btn-sm btn-outline-primary">
                                    Ver Cliente
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted"><?php echo e(class_basename($actividad->actividadable_type)); ?></small>
                            <p class="mb-0 fw-bold">
                                <?php if($actividad->actividadable_type == 'App\Models\Prospecto'): ?>
                                    <?php echo e($actividad->actividadable->nombre_completo ?? $actividad->actividadable->nombre); ?>

                                <?php elseif($actividad->actividadable_type == 'App\Models\Oportunidad'): ?>
                                    <?php echo e($actividad->actividadable->codigo); ?> - <?php echo e($actividad->actividadable->prospecto->nombre ?? 'N/A'); ?>

                                <?php elseif($actividad->actividadable_type == 'App\Models\Cliente'): ?>
                                    <?php echo e($actividad->actividadable->nombre_completo ?? $actividad->actividadable->nombre); ?>

                                <?php else: ?>
                                    <?php echo e($actividad->actividadable->nombre ?? 'N/A'); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna Lateral -->
            <div class="col-lg-4">
                
                <?php
                    $estadosFlow = [
                        'programada' => ['nombre' => 'Programada', 'color' => 'warning', 'icono' => 'bi-clock'],
                        'completada' => ['nombre' => 'Completada', 'color' => 'success', 'icono' => 'bi-check-circle'],
                    ];
                    $estadoActualInfo = $estadosFlow[$actividad->estado] ?? ['nombre' => ucfirst(str_replace('_', ' ', $actividad->estado)), 'color' => 'secondary', 'icono' => 'bi-circle'];
                    $siguienteEstado = match($actividad->estado) {
                        'programada' => $estadosFlow['completada'],
                        default => null,
                    };
                ?>

                <?php if($actividad->estado === 'programada'): ?>
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
                            <form action="<?php echo e(route('admin.crm.actividades.completar', $actividad)); ?>" method="POST" id="form-completar">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="resultado" id="input-resultado">
                                <button type="button" class="btn btn-outline-success btn-sm w-100 btn-completar">
                                    <i class="bi bi-check-circle me-2"></i>Marcar Completada
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.crm.actividades.reprogramar', $actividad)); ?>" method="POST" id="form-reprogramar">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="fecha_programada" id="input-nueva-fecha">
                                <input type="hidden" name="motivo_reprogramacion" id="input-motivo-reprogramacion">
                                <button type="button" class="btn btn-outline-warning btn-sm w-100 btn-reprogramar">
                                    <i class="bi bi-calendar-event me-2"></i>Reprogramar
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.crm.actividades.cancelar', $actividad)); ?>" method="POST" id="form-cancelar">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="motivo_cancelacion" id="input-motivo">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-cancelar">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar Actividad
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php elseif($actividad->estado === 'completada'): ?>
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #198754 !important;" data-aos="fade-up">
                    <div class="card-header bg-success text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Actividad Completada</h6></div>
                    <div class="card-body">
                        <?php if($actividad->resultado): ?>
                            <p class="mb-0"><strong>Resultado:</strong> <?php echo e($actividad->resultado); ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Completada sin resultado registrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php elseif($actividad->estado === 'cancelada'): ?>
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #dc3545 !important;" data-aos="fade-up">
                    <div class="card-header bg-danger text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-x-circle me-2"></i>Actividad Cancelada</h6></div>
                    <div class="card-body">
                        <?php if($actividad->motivo_cancelacion): ?>
                            <p class="mb-0"><strong>Motivo:</strong> <?php echo e($actividad->motivo_cancelacion); ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Sin motivo registrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Información -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Asignado a</small>
                            <p class="mb-0 fw-bold"><?php echo e($actividad->asignadoA?->persona?->name ?? $actividad->asignadoA?->name ?? 'Sin asignar'); ?></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Creado por</small>
                            <p class="mb-0 fw-bold"><?php echo e($actividad->creadoPor?->persona?->name ?? $actividad->creadoPor?->name ?? 'N/A'); ?></p>
                        </div>
                        <?php if($actividad->recordatorio_activo && $actividad->recordatorio_minutos_antes): ?>
                        <div>
                            <small class="text-muted">Recordatorio</small>
                            <p class="mb-0 fw-bold"><i class="bi bi-bell me-1"></i><?php echo e($actividad->recordatorio_minutos_antes); ?> minutos antes</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('admin.crm.actividades.edit', $actividad)); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Actividad
                            </a>
                            <form action="<?php echo e(route('admin.crm.actividades.destroy', $actividad)); ?>" method="POST" id="form-eliminar">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-eliminar">
                                    <i class="bi bi-trash me-2"></i>Eliminar Actividad
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Creado</small>
                            <p class="mb-0"><?php echo e($actividad->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Última actualización</small>
                            <p class="mb-0"><?php echo e($actividad->updated_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php if($actividad->fecha_realizada): ?>
                        <div class="mb-2">
                            <small class="text-muted">Fecha realizada</small>
                            <p class="mb-0 text-success fw-bold"><?php echo e($actividad->fecha_realizada->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {

    // ==================== COMPLETAR ACTIVIDAD (con resultado) ====================
    $('.btn-completar').on('click', function() {
        Swal.fire({
            title: '¿Marcar como completada?',
            html: `
                <p class="mb-3">La actividad <strong><?php echo e(Str::limit($actividad->titulo, 40)); ?></strong> se marcará como <strong class="text-success">Completada</strong>.</p>
                <div class="text-start">
                    <label class="form-label fw-bold small">¿Qué resultado se obtuvo?</label>
                    <textarea id="swal-resultado" class="form-control" rows="3" placeholder="Ej: Cliente aceptó la propuesta, se programó instalación..."></textarea>
                </div>
            `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Completar',
            cancelButtonText: 'Volver',
            focusConfirm: false,
            preConfirm: () => {
                return document.getElementById('swal-resultado').value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-resultado').val(result.value || 'Actividad completada');
                $('#form-completar').submit();
            }
        });
    });

    // ==================== REPROGRAMAR ACTIVIDAD ====================
    $('.btn-reprogramar').on('click', function() {
        Swal.fire({
            title: '¿Reprogramar actividad?',
            html: `
                <p class="mb-3">Seleccione la nueva fecha para <strong><?php echo e(Str::limit($actividad->titulo, 40)); ?></strong>.</p>
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nueva Fecha <span class="text-danger">*</span></label>
                        <input type="datetime-local" id="swal-nueva-fecha" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="form-label fw-bold small">Motivo (opcional)</label>
                        <textarea id="swal-motivo-reprog" class="form-control" rows="2" placeholder="Ej: Cliente solicitó cambio de fecha..."></textarea>
                    </div>
                </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-calendar-event me-1"></i> Reprogramar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const fecha = document.getElementById('swal-nueva-fecha').value;
                if (!fecha) {
                    Swal.showValidationMessage('Debe seleccionar una fecha');
                    return false;
                }
                return {
                    fecha: fecha,
                    motivo: document.getElementById('swal-motivo-reprog').value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-nueva-fecha').val(result.value.fecha);
                $('#input-motivo-reprogramacion').val(result.value.motivo);
                $('#form-reprogramar').submit();
            }
        });
    });

    // ==================== CANCELAR ACTIVIDAD (con motivo) ====================
    $('.btn-cancelar').on('click', function() {
        Swal.fire({
            title: '¿Cancelar actividad?',
            html: `
                <p class="mb-3">La actividad <strong><?php echo e(Str::limit($actividad->titulo, 40)); ?></strong> se marcará como <strong class="text-danger">Cancelada</strong>.</p>
                <div class="text-start">
                    <label class="form-label fw-bold small">Motivo de cancelación <span class="text-danger">*</span></label>
                    <textarea id="swal-motivo" class="form-control" rows="3" placeholder="Ej: Cliente no disponible, se reprogramará..."></textarea>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar actividad',
            cancelButtonText: 'Volver',
            focusConfirm: false,
            preConfirm: () => {
                const motivo = document.getElementById('swal-motivo').value;
                if (!motivo.trim()) {
                    Swal.showValidationMessage('Ingresa un motivo de cancelación');
                    return false;
                }
                return motivo;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-motivo').val(result.value);
                $('#form-cancelar').submit();
            }
        });
    });

    // ==================== ELIMINAR ACTIVIDAD ====================
    $('.btn-eliminar').on('click', function() {
        Swal.fire({
            title: '¿Eliminar actividad?',
            html: `Se eliminará permanentemente la actividad <strong><?php echo e(Str::limit($actividad->titulo, 40)); ?></strong>.<br><br>
                   <strong class="text-danger">Esta acción no se puede deshacer.</strong>`,
            icon: 'warning',
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

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/actividades/show.blade.php ENDPATH**/ ?>