<?php $__env->startSection('title', 'Nuevo Ticket'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO TICKET DE SOPORTE</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.tickets.index')); ?>">Tickets</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                
                <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                    <div class="card-body py-2">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios. El SLA se calcula automáticamente según la prioridad.</small>
                    </div>
                </div>

                <form action="<?php echo e(route('admin.crm.tickets.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="form-select <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar cliente...</option>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id', $clienteId ?? '') == $cliente->id ? 'selected' : ''); ?>>
                                        <?php echo e($cliente->nombre ?? $cliente->razon_social); ?> - <?php echo e($cliente->codigo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="canal" class="form-label fw-bold">Canal de Contacto <span class="text-danger">*</span></label>
                            <select name="canal" id="canal" class="form-select <?php $__errorArgs = ['canal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar...</option>
                                <option value="web" <?php echo e(old('canal') == 'web' ? 'selected' : ''); ?>>🌐 Web</option>
                                <option value="email" <?php echo e(old('canal') == 'email' ? 'selected' : ''); ?>>📧 Email</option>
                                <option value="telefono" <?php echo e(old('canal') == 'telefono' ? 'selected' : ''); ?>>📞 Teléfono</option>
                                <option value="whatsapp" <?php echo e(old('canal') == 'whatsapp' ? 'selected' : ''); ?>>💬 WhatsApp</option>
                                <option value="presencial" <?php echo e(old('canal') == 'presencial' ? 'selected' : ''); ?>>🏢 Presencial</option>
                            </select>
                            <?php $__errorArgs = ['canal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="asunto" class="form-label fw-bold">Asunto <span class="text-danger">*</span></label>
                            <input type="text" name="asunto" id="asunto" class="form-control <?php $__errorArgs = ['asunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('asunto')); ?>" placeholder="Descripción breve del problema" maxlength="200" required>
                            <?php $__errorArgs = ['asunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="categoria" class="form-label fw-bold">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria" id="categoria" class="form-select <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar categoría...</option>
                                <optgroup label="🔧 Soporte Técnico">
                                    <option value="soporte_paneles" <?php echo e(old('categoria') == 'soporte_paneles' ? 'selected' : ''); ?>>☀️ Paneles Solares</option>
                                    <option value="soporte_inversores" <?php echo e(old('categoria') == 'soporte_inversores' ? 'selected' : ''); ?>>⚡ Inversores</option>
                                    <option value="soporte_baterias" <?php echo e(old('categoria') == 'soporte_baterias' ? 'selected' : ''); ?>>🔋 Baterías</option>
                                    <option value="soporte_monitoreo" <?php echo e(old('categoria') == 'soporte_monitoreo' ? 'selected' : ''); ?>>📊 Monitoreo</option>
                                    <option value="soporte_estructura" <?php echo e(old('categoria') == 'soporte_estructura' ? 'selected' : ''); ?>>🏗️ Estructura / Cableado</option>
                                </optgroup>
                                <optgroup label="🛠️ Servicios">
                                    <option value="mantenimiento" <?php echo e(old('categoria') == 'mantenimiento' ? 'selected' : ''); ?>>🔩 Mantenimiento</option>
                                    <option value="instalacion" <?php echo e(old('categoria') == 'instalacion' ? 'selected' : ''); ?>>🔧 Instalación</option>
                                    <option value="garantia" <?php echo e(old('categoria') == 'garantia' ? 'selected' : ''); ?>>🛡️ Garantía</option>
                                </optgroup>
                                <optgroup label="📋 Administrativo">
                                    <option value="facturacion" <?php echo e(old('categoria') == 'facturacion' ? 'selected' : ''); ?>>💰 Facturación / Cobranza</option>
                                    <option value="consulta" <?php echo e(old('categoria') == 'consulta' ? 'selected' : ''); ?>>❓ Consulta General</option>
                                    <option value="reclamo" <?php echo e(old('categoria') == 'reclamo' ? 'selected' : ''); ?>>⚠️ Reclamo</option>
                                </optgroup>
                                <optgroup label="📌 Otro">
                                    <option value="otro" <?php echo e(old('categoria') == 'otro' ? 'selected' : ''); ?>>📋 Otro</option>
                                </optgroup>
                            </select>
                            <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="prioridad" class="form-label fw-bold">Prioridad <span class="text-danger">*</span></label>
                            <select name="prioridad" id="prioridad" class="form-select <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar...</option>
                                <option value="baja" <?php echo e(old('prioridad') == 'baja' ? 'selected' : ''); ?>>🟢 Baja (48h SLA)</option>
                                <option value="media" <?php echo e(old('prioridad', 'media') == 'media' ? 'selected' : ''); ?>>🟡 Media (24h SLA)</option>
                                <option value="alta" <?php echo e(old('prioridad') == 'alta' ? 'selected' : ''); ?>>🟠 Alta (8h SLA)</option>
                                <option value="critica" <?php echo e(old('prioridad') == 'critica' ? 'selected' : ''); ?>>🔴 Crítica (4h SLA)</option>
                            </select>
                            <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción Detallada <span class="text-danger">*</span></label>
                            <textarea name="descripcion" id="descripcion" rows="5" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      placeholder="Describa el problema o consulta en detalle" required><?php echo e(old('descripcion')); ?></textarea>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-bold">Asignar a</label>
                            <select name="user_id" id="user_id" class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>" <?php echo e(old('user_id') == $usuario->id ? 'selected' : ''); ?>>
                                        <?php echo e($usuario->persona?->name ?? $usuario->name); ?> <?php echo e($usuario->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12">
                            <label for="notas_internas" class="form-label fw-bold"><i class="bi bi-lock me-1 text-warning"></i>Notas Internas</label>
                            <textarea name="notas_internas" id="notas_internas" rows="3" class="form-control <?php $__errorArgs = ['notas_internas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Notas privadas visibles solo para el equipo..."><?php echo e(old('notas_internas')); ?></textarea>
                            <?php $__errorArgs = ['notas_internas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.crm.tickets.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-ticket-detailed me-2"></i>Crear Ticket
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
    $('#cliente_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar cliente...',
        allowClear: true
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/tickets/create.blade.php ENDPATH**/ ?>