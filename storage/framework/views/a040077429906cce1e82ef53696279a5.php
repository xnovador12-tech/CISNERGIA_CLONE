<?php $__env->startSection('title', 'Editar Prospecto'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.prospectos.index')); ?>">Prospectos</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.prospectos.show', $prospecto)); ?>"><?php echo e($prospecto->codigo); ?></a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php
        $redirectTo = request('redirect_to', 'show');
        $cancelUrl = $redirectTo === 'index'
            ? route('admin.crm.prospectos.index')
            : route('admin.crm.prospectos.show', $prospecto);
    ?>

    <form action="<?php echo e(route('admin.crm.prospectos.update', $prospecto)); ?>" method="POST" class="needs-validation" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-in">
                <div class="card-body">

                    
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Editando prospecto <strong><?php echo e($prospecto->codigo); ?></strong> — <?php echo e($prospecto->nombre_completo); ?></small>
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información General</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_persona" id="tipo_persona" required data-placeholder="Seleccionar...">
                                <option value="natural" <?php echo e(old('tipo_persona', $prospecto->tipo_persona) == 'natural' ? 'selected' : ''); ?>>Persona Natural</option>
                                <option value="juridica" <?php echo e(old('tipo_persona', $prospecto->tipo_persona) == 'juridica' ? 'selected' : ''); ?>>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-2" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control form-control-sm" name="dni" maxlength="8" value="<?php echo e(old('dni', $prospecto->dni)); ?>" placeholder="12345678">
                        </div>

                        <div class="col-md-2" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control form-control-sm" name="ruc" maxlength="11" value="<?php echo e(old('ruc', $prospecto->ruc)); ?>" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" value="<?php echo e(old('nombre', $prospecto->nombre)); ?>" required placeholder="Nombre o razón comercial">
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" value="<?php echo e(old('apellidos', $prospecto->apellidos)); ?>" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control form-control-sm" name="razon_social" value="<?php echo e(old('razon_social', $prospecto->razon_social)); ?>" placeholder="Razón social de la empresa">
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de Contacto</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" value="<?php echo e(old('email', $prospecto->email)); ?>" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control form-control-sm" name="celular" value="<?php echo e(old('celular', $prospecto->celular)); ?>" placeholder="987654321">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" name="telefono" value="<?php echo e(old('telefono', $prospecto->telefono)); ?>" placeholder="01-1234567">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" value="<?php echo e(old('direccion', $prospecto->direccion)); ?>" placeholder="Av. Principal 123">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Distrito</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="distrito_id" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = $distritos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($distrito->id); ?>" <?php echo e(old('distrito_id', $prospecto->distrito_id) == $distrito->id ? 'selected' : ''); ?>><?php echo e($distrito->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Clasificación</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="estado" id="estado" required data-placeholder="Seleccionar...">
                                <?php $__currentLoopData = [
                                    'nuevo' => 'Nuevo',
                                    'contactado' => 'Contactado',
                                    'calificado' => 'Calificado',
                                    'descartado' => 'Descartado',
                                    'convertido' => 'Convertido'
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('estado', $prospecto->estado) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="origen" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['sitio_web' => 'Sitio Web', 'redes_sociales' => 'Redes Sociales', 'llamada' => 'Llamada', 'referido' => 'Referido', 'ecommerce' => 'E-commerce', 'otro' => 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('origen', $prospecto->origen) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Interés <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_interes" required data-placeholder="Seleccionar...">
                                <option value="producto" <?php echo e(old('tipo_interes', $prospecto->tipo_interes) == 'producto' ? 'selected' : ''); ?>>Producto</option>
                                <option value="servicio" <?php echo e(old('tipo_interes', $prospecto->tipo_interes) == 'servicio' ? 'selected' : ''); ?>>Servicio</option>
                                <option value="ambos" <?php echo e(old('tipo_interes', $prospecto->tipo_interes) == 'ambos' ? 'selected' : ''); ?>>Ambos</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="segmento" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('segmento', $prospecto->segmento) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Seguimiento</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="nivel_interes" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                <?php $__currentLoopData = ['bajo' => 'Bajo', 'medio' => 'Medio', 'alto' => 'Alto', 'muy_alto' => 'Muy Alto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('nivel_interes', $prospecto->nivel_interes) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="urgencia" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                <?php $__currentLoopData = ['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo', 'mediano_plazo' => 'Mediano Plazo', 'largo_plazo' => 'Largo Plazo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('urgencia', $prospecto->urgencia) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Próximo Contacto</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_proximo_contacto"
                                   value="<?php echo e(old('fecha_proximo_contacto', $prospecto->fecha_proximo_contacto?->format('Y-m-d'))); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Seleccionar vendedor...">
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id', $prospecto->user_id) == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-12" id="campo_motivo_descarte" style="display: none;">
                            <label class="form-label">Motivo de Descarte</label>
                            <textarea class="form-control form-control-sm" name="motivo_descarte" rows="2" placeholder="Explique por qué se descartó este prospecto..."><?php echo e(old('motivo_descarte', $prospecto->motivo_descarte)); ?></textarea>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Observaciones</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto..."><?php echo e(old('observaciones', $prospecto->observaciones)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="<?php echo e($cancelUrl); ?>" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Toggle Persona Natural / Jurídica
    $('#tipo_persona').on('change', function() {
        var esJuridica = $(this).val() === 'juridica';
        $('#campo_apellidos').toggle(!esJuridica);
        $('#campo_razon_social').toggle(esJuridica);
        $('#campo_dni').toggle(!esJuridica);
        $('#campo_ruc').toggle(esJuridica);
    }).trigger('change');

    // Toggle Motivo de Descarte
    $('#estado').on('change', function() {
        $('#campo_motivo_descarte').toggle($(this).val() === 'descartado');
    }).trigger('change');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/prospectos/edit.blade.php ENDPATH**/ ?>