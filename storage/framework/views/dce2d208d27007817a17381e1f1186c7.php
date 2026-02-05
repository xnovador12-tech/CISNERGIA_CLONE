
<?php $__env->startSection('title', 'Nueva Oportunidad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA OPORTUNIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.oportunidades.index')); ?>">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body">
                <form action="<?php echo e(route('admin.crm.oportunidades.store')); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-8">
                            <label class="form-label">Nombre de la Oportunidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" value="<?php echo e(old('nombre')); ?>" 
                                   placeholder="Ej: Sistema Solar Residencial 5kW - Juan Pérez" required>
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['tipo_proyecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_proyecto" required>
                                <option value="">Seleccionar...</option>
                                <option value="residencial" <?php echo e(old('tipo_proyecto') == 'residencial' ? 'selected' : ''); ?>>Residencial</option>
                                <option value="comercial" <?php echo e(old('tipo_proyecto') == 'comercial' ? 'selected' : ''); ?>>Comercial</option>
                                <option value="industrial" <?php echo e(old('tipo_proyecto') == 'industrial' ? 'selected' : ''); ?>>Industrial</option>
                                <option value="agricola" <?php echo e(old('tipo_proyecto') == 'agricola' ? 'selected' : ''); ?>>Agrícola</option>
                                <option value="bombeo_solar" <?php echo e(old('tipo_proyecto') == 'bombeo_solar' ? 'selected' : ''); ?>>Bombeo Solar</option>
                            </select>
                            <?php $__errorArgs = ['tipo_proyecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['prospecto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="prospecto_id" required>
                                <option value="">Seleccionar prospecto...</option>
                                <?php $__currentLoopData = $prospectos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prospecto->id); ?>" <?php echo e(old('prospecto_id', $prospectoId ?? '') == $prospecto->id ? 'selected' : ''); ?>>
                                        <?php echo e($prospecto->codigo); ?> - <?php echo e($prospecto->nombre_completo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['prospecto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="user_id">
                                <option value="">Sin asignar (me asigno yo)</option>
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id') == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-sun me-2"></i>Detalles del Sistema Solar</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Potencia del Sistema (kW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['potencia_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="potencia_kw" value="<?php echo e(old('potencia_kw')); ?>" 
                                   step="0.1" min="0" placeholder="Ej: 5.5">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Número de Paneles</label>
                            <input type="number" class="form-control" name="cantidad_paneles" value="<?php echo e(old('cantidad_paneles')); ?>" 
                                   min="0" placeholder="Ej: 12">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Panel</label>
                            <input type="text" class="form-control" name="tipo_panel" value="<?php echo e(old('tipo_panel')); ?>" 
                                   placeholder="Ej: Monocristalino">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca de Panel</label>
                            <input type="text" class="form-control" name="marca_panel" value="<?php echo e(old('marca_panel')); ?>" 
                                   placeholder="Ej: Jinko Solar">
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Valoración y Pipeline</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="monto_estimado" value="<?php echo e(old('monto_estimado')); ?>" 
                                   step="0.01" min="0" placeholder="Ej: 45000" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Estimada <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_cierre_estimada" value="<?php echo e(old('fecha_cierre_estimada')); ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Inversor</label>
                            <input type="text" class="form-control" name="tipo_inversor" value="<?php echo e(old('tipo_inversor')); ?>" 
                                   placeholder="Ej: String">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca de Inversor</label>
                            <input type="text" class="form-control" name="marca_inversor" value="<?php echo e(old('marca_inversor')); ?>" 
                                   placeholder="Ej: Growatt">
                        </div>

                        <div class="col-md-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="incluye_baterias" value="1" id="incluyeBaterias" <?php echo e(old('incluye_baterias') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="incluyeBaterias">Incluye Baterías</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Capacidad Baterías (kWh)</label>
                            <input type="number" class="form-control" name="capacidad_baterias_kwh" value="<?php echo e(old('capacidad_baterias_kwh')); ?>" 
                                   step="0.1" min="0" placeholder="Ej: 10">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Detalles adicionales sobre la oportunidad..."><?php echo e(old('observaciones')); ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notas Técnicas</label>
                            <textarea class="form-control" name="notas_tecnicas" rows="2" placeholder="Aspectos técnicos a considerar..."><?php echo e(old('notas_tecnicas')); ?></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('admin.crm.oportunidades.index')); ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Oportunidad</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) { event.preventDefault(); event.stopPropagation(); }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/oportunidades/create.blade.php ENDPATH**/ ?>