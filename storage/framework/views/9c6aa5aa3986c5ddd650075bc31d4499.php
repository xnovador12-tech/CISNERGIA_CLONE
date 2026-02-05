
<?php $__env->startSection('title', 'Nuevo Mantenimiento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROGRAMAR MANTENIMIENTO</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.mantenimientos.index')); ?>">Mantenimientos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                <form action="<?php echo e(route('admin.crm.mantenimientos.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    
                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Cliente y Ubicación</h5>
                    <div class="row g-3 mb-4">
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
                            <label for="direccion" class="form-label fw-bold">Dirección del Servicio <span class="text-danger">*</span></label>
                            <input type="text" name="direccion" id="direccion" class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('direccion')); ?>" placeholder="Dirección donde se realizará el servicio" required>
                            <?php $__errorArgs = ['direccion'];
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

                    <hr>

                    
                    <h5 class="fw-bold mb-3"><i class="bi bi-calendar me-2"></i>Programación</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="titulo" class="form-label fw-bold">Título del Mantenimiento <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('titulo')); ?>" placeholder="Ej: Mantenimiento preventivo trimestral" required>
                            <?php $__errorArgs = ['titulo'];
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

                        <div class="col-md-4">
                            <label for="tipo" class="form-label fw-bold">Tipo de Mantenimiento <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar...</option>
                                <option value="preventivo" <?php echo e(old('tipo') == 'preventivo' ? 'selected' : ''); ?>>🔧 Preventivo</option>
                                <option value="correctivo" <?php echo e(old('tipo') == 'correctivo' ? 'selected' : ''); ?>>🔩 Correctivo</option>
                                <option value="predictivo" <?php echo e(old('tipo') == 'predictivo' ? 'selected' : ''); ?>>📊 Predictivo</option>
                                <option value="limpieza" <?php echo e(old('tipo') == 'limpieza' ? 'selected' : ''); ?>>🧹 Limpieza</option>
                                <option value="inspeccion" <?php echo e(old('tipo') == 'inspeccion' ? 'selected' : ''); ?>>🔍 Inspección</option>
                            </select>
                            <?php $__errorArgs = ['tipo'];
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

                        <div class="col-md-4">
                            <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                            <select name="tecnico_id" id="tecnico_id" class="form-select <?php $__errorArgs = ['tecnico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tecnico->id); ?>" <?php echo e(old('tecnico_id') == $tecnico->id ? 'selected' : ''); ?>>
                                        <?php echo e($tecnico->persona?->name ?? $tecnico->name); ?> <?php echo e($tecnico->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tecnico_id'];
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

                        <div class="col-md-4">
                            <label for="duracion_estimada_horas" class="form-label fw-bold">Duración Estimada (horas)</label>
                            <input type="number" name="duracion_estimada_horas" id="duracion_estimada_horas" class="form-control <?php $__errorArgs = ['duracion_estimada_horas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('duracion_estimada_horas', 2)); ?>" min="1" max="24">
                            <?php $__errorArgs = ['duracion_estimada_horas'];
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

                        <div class="col-md-4">
                            <label for="fecha_programada" class="form-label fw-bold">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_programada" id="fecha_programada" class="form-control <?php $__errorArgs = ['fecha_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('fecha_programada', now()->addDay()->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['fecha_programada'];
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

                        <div class="col-md-4">
                            <label for="hora_programada" class="form-label fw-bold">Hora Programada</label>
                            <input type="time" name="hora_programada" id="hora_programada" class="form-control <?php $__errorArgs = ['hora_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('hora_programada', '09:00')); ?>">
                            <?php $__errorArgs = ['hora_programada'];
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

                        <div class="col-md-4">
                            <label class="form-label fw-bold d-block">&nbsp;</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="es_gratuito" id="es_gratuito" value="1" <?php echo e(old('es_gratuito') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="es_gratuito">
                                    Mantenimiento gratuito (incluido en servicio)
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    
                    <h5 class="fw-bold mb-3"><i class="bi bi-sun me-2"></i>Datos del Sistema Solar</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="potencia_sistema_kw" class="form-label fw-bold">Potencia (kW)</label>
                            <input type="number" name="potencia_sistema_kw" id="potencia_sistema_kw" class="form-control <?php $__errorArgs = ['potencia_sistema_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('potencia_sistema_kw')); ?>" min="0" step="0.01" placeholder="Ej: 5.5">
                            <?php $__errorArgs = ['potencia_sistema_kw'];
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

                        <div class="col-md-3">
                            <label for="cantidad_paneles" class="form-label fw-bold">Cantidad de Paneles</label>
                            <input type="number" name="cantidad_paneles" id="cantidad_paneles" class="form-control <?php $__errorArgs = ['cantidad_paneles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('cantidad_paneles')); ?>" min="1" placeholder="Ej: 10">
                            <?php $__errorArgs = ['cantidad_paneles'];
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

                        <div class="col-md-3">
                            <label for="marca_inversor" class="form-label fw-bold">Marca Inversor</label>
                            <input type="text" name="marca_inversor" id="marca_inversor" class="form-control <?php $__errorArgs = ['marca_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('marca_inversor')); ?>" placeholder="Ej: Growatt">
                            <?php $__errorArgs = ['marca_inversor'];
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

                        <div class="col-md-3">
                            <label for="modelo_inversor" class="form-label fw-bold">Modelo Inversor</label>
                            <input type="text" name="modelo_inversor" id="modelo_inversor" class="form-control <?php $__errorArgs = ['modelo_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('modelo_inversor')); ?>" placeholder="Ej: MIN 5000TL-X">
                            <?php $__errorArgs = ['modelo_inversor'];
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

                    <hr>

                    
                    <h5 class="fw-bold mb-3"><i class="bi bi-card-text me-2"></i>Detalles del Servicio</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción del Trabajo</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      placeholder="Descripción detallada del trabajo a realizar..."><?php echo e(old('descripcion')); ?></textarea>
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

                        <div class="col-md-12">
                            <label for="observaciones" class="form-label fw-bold">Observaciones / Notas para el Técnico</label>
                            <textarea name="observaciones" id="observaciones" rows="3" class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      placeholder="Instrucciones especiales, accesos, precauciones..."><?php echo e(old('observaciones')); ?></textarea>
                            <?php $__errorArgs = ['observaciones'];
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
                        <a href="<?php echo e(route('admin.crm.mantenimientos.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-calendar-check me-2"></i>Programar Mantenimiento
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

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/mantenimientos/create.blade.php ENDPATH**/ ?>